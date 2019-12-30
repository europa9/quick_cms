<?php
/**
*
* File: _admin/_inc/edb/machine_types.php
* Version 11:55 30.12.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}
/*- Tables ---------------------------------------------------------------------------- */
$t_edb_case_index		= $mysqlPrefixSav . "edb_case_index";
$t_edb_case_codes		= $mysqlPrefixSav . "edb_case_codes";
$t_edb_case_statuses		= $mysqlPrefixSav . "edb_case_statuses";
$t_edb_case_priorities		= $mysqlPrefixSav . "edb_case_priorities";

$t_edb_districts_index		= $mysqlPrefixSav . "edb_districts_index";
$t_edb_districts_members	= $mysqlPrefixSav . "edb_districts_members";

$t_edb_stations_index		= $mysqlPrefixSav . "edb_stations_index";
$t_edb_stations_members		= $mysqlPrefixSav . "edb_stations_members";
$t_edb_stations_directories	= $mysqlPrefixSav . "edb_stations_directories";
$t_edb_stations_jour		= $mysqlPrefixSav . "edb_stations_jour";

$t_edb_software_index	= $mysqlPrefixSav . "edb_software_index";


$t_edb_machines_index				= $mysqlPrefixSav . "edb_machines_index";
$t_edb_machines_types				= $mysqlPrefixSav . "edb_machines_types";
$t_edb_machines_all_tasks_available		= $mysqlPrefixSav . "edb_machines_all_tasks_available";
$t_edb_machines_all_tasks_available_to_item  	= $mysqlPrefixSav . "edb_machines_all_tasks_available_to_item";


/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['machine_type_id'])) {
	$machine_type_id = $_GET['machine_type_id'];
	$machine_type_id = strip_tags(stripslashes($machine_type_id));
}
else{
	$machine_type_id = "";
}
if(isset($_GET['order_by'])) {
	$order_by = $_GET['order_by'];
	$order_by = strip_tags(stripslashes($order_by));
}
else{
	$order_by = "";
}
if(isset($_GET['order_method'])) {
	$order_method = $_GET['order_method'];
	$order_method = strip_tags(stripslashes($order_method));
	if($order_method != "asc" && $order_method != "desc"){
		echo"Wrong order method";
		die;
	}
}
else{
	$order_method = "asc";
}


if($action == ""){
	echo"
	<h1>Stations machine types</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Machine types</a>
		</p>
	<!-- //Where am I? -->

	<!-- Feedback -->
		";
		if($ft != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			else{
				$fm = str_replace("_", " ", $fm);
				$fm = ucfirst($fm);
			}
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
	<!-- //Feedback -->


			
	<!-- Machine types -->
		<p>
		<a href=\"index.php?open=edb&amp;page=$page&amp;action=new&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">New machine type</a>
		</p>

		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">";
			if($order_by == ""){
				$order_by = "machine_type_id";
			}
			if($order_by == "machine_type_id" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			elseif($order_by == "machine_type_id" && $order_method == "asc"){
				$order_method_link = "asc";
			}
	
			echo"
			<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=machine_type_id&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>ID</b></a>";
			if($order_by == "machine_type_id" && $order_method == "asc"){
				echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "machine_type_id" && $order_method == "desc"){
				echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
			echo"</span>
		   </th>
		   <th scope=\"col\">";
				if($order_by == "machine_type_title" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				elseif($order_by == "machine_type_title" && $order_method == "asc"){
					$order_method_link = "asc";
				}
				echo"
				<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=machine_type_title&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Title</b></a>";
				if($order_by == "machine_type_title" && $order_method == "asc"){
					echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
				}
				elseif($order_by == "machine_type_title" && $order_method == "desc"){
					echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
				}
				echo"</span>
			   </th>
			   <th scope=\"col\">
				<span><b>Actions</b></span>
			   </th>
			  </tr>
			 </thead>
			 <tbody>
			";
			$query = "SELECT machine_type_id, machine_type_title FROM $t_edb_machines_types";
			if($order_by == "machine_type_id" OR $order_by == "machine_type_title"){
				if($order_method  == "asc" OR $order_method == "desc"){
						$query = $query  . " ORDER BY $order_by $order_method";
					}
				}
				else{
					$query = $query  . " ORDER BY jour_id ASC";
				}
				$query = $query  . " LIMIT 0,200";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_machine_type_id, $get_machine_type_title) = $row;
			
				// Style
				if(isset($style) && $style == ""){
					$style = "odd";
				}
				else{
					$style = "";
				}

				echo"
				 <tr>
				  <td class=\"$style\">
					<span>
					<a id=\"machine_type_id$get_machine_type_id\"></a>
					$get_machine_type_id
					</span>
				  </td>
				  <td class=\"$style\">
					<span>
					$get_machine_type_title
					</span>
				  </td>
				  <td class=\"$style\">
					<span>
					<a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_machine_type&amp;machine_type_id=$get_machine_type_id&amp;editor_language=$editor_language&amp;l=$l\">Edit</a>
					|
					<a href=\"index.php?open=edb&amp;page=$page&amp;action=delete_machine_type&amp;machine_type_id=$get_machine_type_id&amp;editor_language=$editor_language&amp;l=$l\">Delete</a>
					</span>
				  </td>
				 </tr>";
			} // while
			echo"
			 </tbody>
			</table>
	<!-- //Machine types -->
	";
} // action == ""
elseif($action == "new"){
	if($process == "1"){
		$inp_title = $_POST['inp_title'];
		$inp_title = output_html($inp_title);
		$inp_title_mysql = quote_smart($link, $inp_title);


		mysqli_query($link, "INSERT INTO $t_edb_machines_types
		(machine_type_id, machine_type_title) 
		VALUES 
		(NULL, $inp_title_mysql)
		") or die(mysqli_error($link));


		$url = "index.php?open=edb&page=$page&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=created";
		header("Location: $url");
		exit;
		
	}
	echo"
	<h1>New</h1>

	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Machine types</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;editor_language=$editor_language&amp;l=$l\">New</a>
		</p>
	<!-- //Where am I? -->

	<!-- Feedback -->
		";
		if($ft != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			else{
				$fm = str_replace("_", " ", $fm);
				$fm = ucfirst($fm);
			}
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
	<!-- //Feedback -->


	<!-- New machine type form -->
		<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_title\"]').focus();
			});
			</script>
		<!-- //Focus -->

		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

		<p>Machine type title:<br />
		<input type=\"text\" name=\"inp_title\" value=\"\" size=\"25\" />
		</p>

		<p>
		<input type=\"submit\" value=\"Create\" class=\"btn_default\" />
		</p>
		</form>
	<!-- //New machine type form -->
	";
} // action == "new"
elseif($action == "edit_machine_type"){
	// Find machine
	$machine_type_id_mysql = quote_smart($link, $machine_type_id);
	$query = "SELECT machine_type_id, machine_type_title FROM $t_edb_machines_types WHERE machine_type_id=$machine_type_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_machine_type_id, $get_current_machine_type_title) = $row;
	
	if($get_current_machine_type_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		if($process == "1"){
			$inp_title = $_POST['inp_title'];
			$inp_title = output_html($inp_title);
			$inp_title_mysql = quote_smart($link, $inp_title);

			
			$result = mysqli_query($link, "UPDATE $t_edb_machines_types SET
							machine_type_title=$inp_title_mysql
							 WHERE machine_type_id=$get_current_machine_type_id") or die(mysqli_error($link));



			$url = "index.php?open=edb&page=$page&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;
			
		}
		echo"
		<h1>$get_current_machine_type_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Machine type</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;machine_type_id=$get_current_machine_type_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_machine_type_title</a>
			</p>
		<!-- //Where am I? -->

		<!-- Feedback -->
			";
			if($ft != ""){
				if($fm == "changes_saved"){
					$fm = "$l_changes_saved";
				}
				else{
					$fm = str_replace("_", " ", $fm);
					$fm = ucfirst($fm);
				}
				echo"<div class=\"$ft\"><span>$fm</span></div>";
			}
			echo"	
		<!-- //Feedback -->



		<!-- Edit machine form -->
			<!-- Focus -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_title\"]').focus();
				});
				</script>
			<!-- //Focus -->

			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;machine_type_id=$get_current_machine_type_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p>Machine type title:<br />
			<input type=\"text\" name=\"inp_title\" value=\"$get_current_machine_type_title\" size=\"25\" />
			</p>

			<p>
			<input type=\"submit\" value=\"Save\" class=\"btn_default\" />
			</p>
			</form>
		<!-- //Edit machine type form -->
		";
	} // machine found
} // edit_machine type
elseif($action == "delete_machine_type"){
	// Find machine
	$machine_type_id_mysql = quote_smart($link, $machine_type_id);
	$query = "SELECT machine_type_id, machine_type_title FROM $t_edb_machines_types WHERE machine_type_id=$machine_type_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_machine_type_id, $get_current_machine_type_title) = $row;
	
	if($get_current_machine_type_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		if($process == "1"){
			
			$result = mysqli_query($link, "DELETE FROM $t_edb_machines_types WHERE machine_type_id=$machine_type_id_mysql") or die(mysqli_error($link));



			$url = "index.php?open=edb&page=$page&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=deleted";
			header("Location: $url");
			exit;
			
		}
		echo"
		<h1>$get_current_machine_type_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Machine type</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;machine_type_id=$get_current_machine_type_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_machine_type_title</a>
			</p>
		<!-- //Where am I? -->


		<!-- Feedback -->
			";
			if($ft != ""){
				if($fm == "changes_saved"){
					$fm = "$l_changes_saved";
				}
				else{
					$fm = str_replace("_", " ", $fm);
					$fm = ucfirst($fm);
				}
				echo"<div class=\"$ft\"><span>$fm</span></div>";
			}
			echo"	
		<!-- //Feedback -->



		<!-- Delete machine form -->
			<p>Are you sure?</p>

			<p>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;machine_type_id=$get_current_machine_type_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">Delete</a></p>

		<!-- //Delete machine form -->
		";
	} // machine found
} // delete_machine type
?>