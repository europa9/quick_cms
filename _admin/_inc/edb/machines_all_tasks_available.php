<?php
/**
*
* File: _admin/_inc/edb/machines_all_tasks_available.php
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
$t_edb_item_types		= $mysqlPrefixSav . "edb_item_types";

$t_edb_machines_index				= $mysqlPrefixSav . "edb_machines_index";
$t_edb_machines_types				= $mysqlPrefixSav . "edb_machines_types";
$t_edb_machines_all_tasks_available		= $mysqlPrefixSav . "edb_machines_all_tasks_available";
$t_edb_machines_all_tasks_available_to_item  	= $mysqlPrefixSav . "edb_machines_all_tasks_available_to_item";

/*- Functions -------------------------------------------------------------------------- */
include("_functions/get_extension.php");

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['task_available_id'])) {
	$task_available_id = $_GET['task_available_id'];
	$task_available_id = strip_tags(stripslashes($task_available_id));
}
else{
	$task_available_id = "";
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
	<h1>Machines all tasks available</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Machines all tasks available</a>
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




	<p>
	<a href=\"index.php?open=edb&amp;page=$page&amp;action=new&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">New task</a>
	</p>

	<!-- Machines all tasks available -->
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">";
			if($order_by == ""){
				$order_by = "task_available_id";
			}
			if($order_by == "task_available_id" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}
		
			echo"
			<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=task_available_id&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>ID</b></a>";
			if($order_by == "task_available_id" && $order_method == "asc"){
				echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "task_available_id" && $order_method == "desc"){
				echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
			echo"</span>
		   </th>
		   <th scope=\"col\">";
			if($order_by == "task_available_name" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}
		
			echo"
			<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=task_available_name&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Name</b></a>";
			if($order_by == "task_available_name" && $order_method == "asc"){
				echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "task_available_name" && $order_method == "desc"){
				echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
			echo"</span>
		   </th>
		   <th scope=\"col\">";
			if($order_by == "task_available_machine_type_title" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}
		
			echo"
			<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=task_available_id&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Machine type</b></a>";
			if($order_by == "task_available_machine_type_title" && $order_method == "asc"){
				echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "task_available_machine_type_title" && $order_method == "desc"){
				echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
			echo"</span>
		   </th>
		   <th scope=\"col\">";
			if($order_by == "task_available_description" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}
		
			echo"
			<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=task_available_description&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Description</b></a>";
			if($order_by == "task_available_description" && $order_method == "asc"){
				echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "task_available_description" && $order_method == "desc"){
				echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
			echo"</span>
		   </th>
		   <th scope=\"col\">";
			if($order_by == "task_available_description_report" && $order_method == "asc"){
				$order_method_link = "desc";
			}
			else{
				$order_method_link = "asc";
			}
		
			echo"
			<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=task_available_description_report&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Report</b></a>";
			if($order_by == "task_available_description_report" && $order_method == "asc"){
				echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
			}
			if($order_by == "task_available_description_report" && $order_method == "desc"){
				echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
			}
			echo"</span>
		   </th>
		   <th scope=\"col\">
			<span><b>Item types</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Actions</b></span>
		   </th>
		  </tr>
		 </thead>
		 <tbody>
			";
		$query = "SELECT task_available_id, task_available_name, task_available_machine_type_title, task_available_description, task_available_description_report, task_available_script_file FROM $t_edb_machines_all_tasks_available";
		if($order_by == "task_available_id" OR $order_by == "task_available_name" OR $order_by == "task_available_machine_type_title" OR $order_by == "task_available_description" OR $order_by == "task_available_description_report" OR $order_by == "task_available_script_file"){
			if($order_method  == "asc" OR $order_method == "desc"){
					$query = $query  . " ORDER BY $order_by $order_method";
				}
			}
			else{
				$query = $query  . " ORDER BY task_available_id ASC";
			}
		$query = $query  . " LIMIT 0,200";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_task_available_id, $get_task_available_name, $get_task_available_machine_type_title, $get_task_available_description, $get_task_available_description_report, $get_task_available_script_file) = $row;
			
			// Style
			if(isset($style) && $style == ""){
				$style = "odd";
			}
			else{
				$style = "";
			}

			echo"
			 <tr>
			  <td class=\"$style\" style=\"vertical-align: top;\">
				<span>
				<a id=\"task_available_id$get_task_available_id\"></a>
				$get_task_available_id
				</span>
			  </td>
			  <td class=\"$style\" style=\"vertical-align: top;\">
				<span>
				$get_task_available_name
				</span>
			  </td>
			  <td class=\"$style\" style=\"vertical-align: top;\">
				<span>
				$get_task_available_machine_type_title
				</span>
			  </td>
			  <td class=\"$style\" style=\"vertical-align: top;\">
				<span>
				$get_task_available_description
				</span>
			  </td>
			  <td class=\"$style\" style=\"vertical-align: top;\">
				<span>
				$get_task_available_description_report
				</span>
			  </td>
			  <td class=\"$style\" style=\"vertical-align: top;\">
				<span>
				";
			$x = 0;
			$query_b = "SELECT $t_edb_machines_all_tasks_available_to_item.task_available_to_item_id, $t_edb_machines_all_tasks_available_to_item.task_available_id, $t_edb_machines_all_tasks_available_to_item.item_type_id, $t_edb_item_types.item_type_title FROM $t_edb_machines_all_tasks_available_to_item JOIN $t_edb_item_types ON $t_edb_machines_all_tasks_available_to_item.item_type_id=$t_edb_item_types.item_type_id WHERE $t_edb_machines_all_tasks_available_to_item.task_available_id=$get_task_available_id";
			$result_b = mysqli_query($link, $query_b);
			while($row_b = mysqli_fetch_row($result_b)) {
				list($get_itask_available_to_item_id, $get_task_available_id, $get_item_type_id, $get_item_type_title) = $row_b;
				if($x != "0"){
					echo" &middot; ";
				}
				echo"$get_item_type_title ";
				$x = $x+1;
			}
			
				echo"
				</span>
			  </td>
			  <td class=\"$style\" style=\"vertical-align: top;\">
				<span>
				<a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_task_available&amp;task_available_id=$get_task_available_id&amp;editor_language=$editor_language&amp;l=$l\">Edit</a>
				<br />
				<a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_task_to_item&amp;task_available_id=$get_task_available_id&amp;editor_language=$editor_language&amp;l=$l\">Task&nbsp;to&nbsp;item</a>
				<br />
				<a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_script_and_exe&amp;task_available_id=$get_task_available_id&amp;editor_language=$editor_language&amp;l=$l\">Script&nbsp;and&nbsp;exe</a>
				<br />
				<a href=\"index.php?open=edb&amp;page=$page&amp;action=delete_task_available&amp;task_available_id=$get_task_available_id&amp;editor_language=$editor_language&amp;l=$l\">Delete</a>
				</span>
			  </td>
			 </tr>";
		} // while
		echo"
		 </tbody>
		</table>
	<!-- //Machines all tasks available -->
	";
} // action == "open_physical_location"
elseif($action == "new"){

	if($process == "1"){
		$inp_name = $_POST['inp_name'];
		$inp_name = output_html($inp_name);
		$inp_name_mysql = quote_smart($link, $inp_name);

		$inp_type_id = $_POST['inp_type_id'];
		$inp_type_id = output_html($inp_type_id);
		$inp_type_id_mysql = quote_smart($link, $inp_type_id);

		// Machine type title
		$query = "SELECT machine_type_id, machine_type_title FROM $t_edb_machines_types WHERE machine_type_id=$inp_type_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_machine_type_id, $get_current_machine_type_title) = $row;
	
		$inp_type_title_mysql = quote_smart($link, $get_current_machine_type_title);

		$inp_description = $_POST['inp_description'];
		$inp_description = output_html($inp_description);
		$inp_description_mysql = quote_smart($link, $inp_description);

		$inp_description_report = $_POST['inp_description_report'];
		$inp_description_report = output_html($inp_description_report);
		$inp_description_report_mysql = quote_smart($link, $inp_description_report);

		mysqli_query($link, "INSERT INTO $t_edb_machines_all_tasks_available
		(task_available_id, task_available_name, task_available_machine_type_id, task_available_machine_type_title, task_available_description, task_available_description_report) 
		VALUES 
		(NULL, $inp_name_mysql, $inp_type_id_mysql, $inp_type_title_mysql, $inp_description_mysql, $inp_description_report_mysql)
		") or die(mysqli_error($link));


		$url = "index.php?open=edb&page=$page&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=saved";
		header("Location: $url");
		exit;
			
	}
	echo"
	<h1>New</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Machines all tasks available</a>
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



	<!-- New Machines all tasks available -->
		<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_name\"]').focus();
			});
			</script>
		<!-- //Focus -->

		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

		<p>Tasks available name:<br />
		<input type=\"text\" name=\"inp_name\" value=\"\" size=\"25\" />
		</p>

		<p>Machine type:<br />
		<select name=\"inp_type_id\">\n";
		$query = "SELECT machine_type_id, machine_type_title FROM $t_edb_machines_types ORDER BY machine_type_title ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_machine_type_id, $get_machine_type_title) = $row;
			echo"					";
			echo"<option value=\"$get_machine_type_id\">$get_machine_type_title</option>\n";
		}
		echo"
		</select>
		</p>

		<p>Description:<br />
		<input type=\"text\" name=\"inp_description\" value=\"\" size=\"25\" />
		</p>

		<p>Report text:<br />
		<textarea name=\"inp_description_report\" rows=\"10\" cols=\"80\"></textarea>
		</p>



		<p>
		<input type=\"submit\" value=\"Create\" class=\"btn_default\" />
		</p>
		</form>
	<!-- //New Machines all tasks available -->
	";
} // action == "new"
elseif($action == "edit_task_available"){
	// Find machine
	$task_available_id_mysql = quote_smart($link, $task_available_id);
	$query = "SELECT task_available_id, task_available_name, task_available_machine_type_id, task_available_machine_type_title, task_available_description, task_available_description_report, task_available_script_file FROM $t_edb_machines_all_tasks_available WHERE task_available_id=$task_available_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_task_available_id, $get_current_task_available_name, $get_current_task_available_machine_type_id, $get_current_task_available_machine_type_title, $get_current_task_available_description, $get_current_task_available_description_report, $get_current_task_available_script_file) = $row;
	
	if($get_current_task_available_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		if($process == "1"){
			$inp_name = $_POST['inp_name'];
			$inp_name = output_html($inp_name);
			$inp_name_mysql = quote_smart($link, $inp_name);

			$inp_type_id = $_POST['inp_type_id'];
			$inp_type_id = output_html($inp_type_id);
			$inp_type_id_mysql = quote_smart($link, $inp_type_id);

			// Machine type title
			$query = "SELECT machine_type_id, machine_type_title FROM $t_edb_machines_types WHERE machine_type_id=$inp_type_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_machine_type_id, $get_current_machine_type_title) = $row;
	
			$inp_type_title_mysql = quote_smart($link, $get_current_machine_type_title);

			$inp_description = $_POST['inp_description'];
			$inp_description = output_html($inp_description);
			$inp_description_mysql = quote_smart($link, $inp_description);

			$inp_description_report = $_POST['inp_description_report'];
			$inp_description_report = output_html($inp_description_report);
			$inp_description_report_mysql = quote_smart($link, $inp_description_report);


			
			$result = mysqli_query($link, "UPDATE $t_edb_machines_all_tasks_available SET
							task_available_name=$inp_name_mysql, 
							task_available_machine_type_id=$inp_type_id_mysql, 
							task_available_machine_type_title=$inp_type_title_mysql, 
							task_available_description=$inp_description_mysql, 
							task_available_description_report=$inp_description_report_mysql
							 WHERE task_available_id=$get_current_task_available_id") or die(mysqli_error($link));



			$url = "index.php?open=edb&page=$page&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;
			
		}
		echo"
		<h1>$get_current_task_available_name</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Machines all tasks available</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;task_available_id=$get_current_task_available_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_task_available_name</a>
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



		<!-- Edit task_available -->
			<!-- Focus -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_name\"]').focus();
				});
				</script>
			<!-- //Focus -->

			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;task_available_id=$get_current_task_available_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p>Machine name:<br />
			<input type=\"text\" name=\"inp_name\" value=\"$get_current_task_available_name\" size=\"25\" />
			</p>

			<p>Machine type:<br />
			<select name=\"inp_type_id\">\n";
			$query = "SELECT machine_type_id, machine_type_title FROM $t_edb_machines_types ORDER BY machine_type_title ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_machine_type_id, $get_machine_type_title) = $row;
				echo"					";
				echo"<option value=\"$get_machine_type_id\""; if($get_machine_type_id == "$get_current_task_available_machine_type_id"){ echo" selected=\"selected\""; } echo">$get_machine_type_title</option>\n";
			}
			echo"
			</select>
			</p>

			<p>Description:<br />
			<input type=\"text\" name=\"inp_description\" value=\"$get_current_task_available_description\" size=\"25\" />
			</p>

			<p>Report text:<br />
			<textarea name=\"inp_description_report\" rows=\"10\" cols=\"80\">$get_current_task_available_description_report</textarea>
			</p>


			<p>
			<input type=\"submit\" value=\"Save\" class=\"btn_default\" />
			</p>
			</form>
		<!-- //Edit task_available -->
		";
	} // task_available found
} // edit_task_available
elseif($action == "edit_task_to_item"){
	// Find task_available
	$task_available_id_mysql = quote_smart($link, $task_available_id);
	$query = "SELECT task_available_id, task_available_name, task_available_machine_type_id, task_available_machine_type_title, task_available_description, task_available_script_file FROM $t_edb_machines_all_tasks_available WHERE task_available_id=$task_available_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_task_available_id, $get_current_task_available_name, $get_current_task_available_machine_type_id, $get_current_task_available_machine_type_title, $get_current_task_available_description, $get_current_task_available_script_file) = $row;
	
	if($get_current_task_available_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		if($process == "1"){
			
			if(isset($_GET['item_type_id'])) {
				$item_type_id = $_GET['item_type_id'];
				$item_type_id = strip_tags(stripslashes($item_type_id));
			}
			else{
				$item_type_id = "";
			}
			$item_type_id_mysql = quote_smart($link, $item_type_id);

			// Check 
			$query_b = "SELECT task_available_to_item_id FROM $t_edb_machines_all_tasks_available_to_item WHERE task_available_id=$get_current_task_available_id AND item_type_id=$item_type_id_mysql";
			$result_b = mysqli_query($link, $query_b);
			$row_b = mysqli_fetch_row($result_b);
			list($get_task_available_to_item_id) = $row_b;

			if($get_task_available_to_item_id == ""){
				// Insert

				mysqli_query($link, "INSERT INTO $t_edb_machines_all_tasks_available_to_item 
				(task_available_to_item_id, task_available_id, item_type_id) 
				VALUES 
				(NULL, $get_current_task_available_id, $item_type_id_mysql)
				") or die(mysqli_error($link));

				$url = "index.php?open=edb&page=$page&action=$action&task_available_id=$get_current_task_available_id&editor_language=$editor_language&l=$l&ft=success&fm=added";
				header("Location: $url");
				exit;
			}
			else{
				// Delete
			
				$result = mysqli_query($link, "DELETE FROM $t_edb_machines_all_tasks_available_to_item WHERE task_available_to_item_id=$get_task_available_to_item_id") or die(mysqli_error($link));

				$url = "index.php?open=edb&page=$page&action=$action&task_available_id=$get_current_task_available_id&editor_language=$editor_language&l=$l&ft=info&fm=removed";
				header("Location: $url");
				exit;
			}

			
		}
		echo"
		<h1>$get_current_task_available_name</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Machines all tasks available</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;task_available_id=$get_current_task_available_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_task_available_name</a>
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



		<!-- Edit task to item -->
			<table class=\"hor-zebra\">
			 <thead>
			  <tr>
			   <th scope=\"col\">
				<span><b>Item type</b></span>
			   </th>
			   <th scope=\"col\">
				<span><b>Available for this task</b></span>
			   </th>
			  </tr>
			 </thead>
			 <tbody>";
			$query = "SELECT item_type_id, item_type_title, item_type_image_path, item_type_image_file, item_type_has_hard_disks, item_type_has_sim_cards, item_type_has_sd_cards, item_type_has_networks FROM $t_edb_item_types";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_item_type_id, $get_item_type_title, $get_item_type_image_path, $get_item_type_image_file, $get_item_type_has_hard_disks, $get_item_type_has_sim_cards, $get_item_type_has_sd_cards, $get_item_type_has_networks) = $row;
			
				// Style
				if(isset($style) && $style == ""){
					$style = "odd";
				}
				else{
					$style = "";
				}

				// Check
				$query_b = "SELECT task_available_to_item_id FROM $t_edb_machines_all_tasks_available_to_item WHERE task_available_id=$get_current_task_available_id AND item_type_id=$get_item_type_id";
				$result_b = mysqli_query($link, $query_b);
				$row_b = mysqli_fetch_row($result_b);
				list($get_task_available_to_item_id) = $row_b;
	



				echo"
				 <tr>
				  <td class=\"$style\">
					<span>$get_item_type_id $get_item_type_title</span>
				  </td>
				  <td class=\"$style\">
					<span>";
					if($get_task_available_to_item_id == ""){
						echo"<a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_task_to_item&amp;task_available_id=$get_current_task_available_id&amp;item_type_id=$get_item_type_id&amp;process=1&amp;editor_language=$editor_language&amp;l=$l\" style=\"color: red;\">Not available</a>";
					}
					else{
						echo"<a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_task_to_item&amp;task_available_id=$get_current_task_available_id&amp;item_type_id=$get_item_type_id&amp;process=1&amp;editor_language=$editor_language&amp;l=$l\" style=\"color: green;\">Available</a>";
					}

					echo"</span>
				  </td>
				 </tr>
				";
			} // while
			echo"
			 </tbody>
			</table>
		<!-- //Edit task to item  -->
		";
	} // task_available found
} // edit_task_to item
elseif($action == "edit_script_and_exe"){
	// Find machine
	$task_available_id_mysql = quote_smart($link, $task_available_id);
	$query = "SELECT task_available_id, task_available_name, task_available_machine_type_id, task_available_machine_type_title, task_available_description, task_available_description_report, task_available_script_path, task_available_script_file, task_available_script_version, task_available_code FROM $t_edb_machines_all_tasks_available WHERE task_available_id=$task_available_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_task_available_id, $get_current_task_available_name, $get_current_task_available_machine_type_id, $get_current_task_available_machine_type_title, $get_current_task_available_description, $get_current_task_available_description_report, $get_current_task_available_script_path, $get_current_task_available_script_file, $get_current_task_available_script_version, $get_current_task_available_code) = $row;
	
	if($get_current_task_available_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		if($process == "1"){
			$inp_script_version = $_POST['inp_script_version'];
			$inp_script_version = output_html($inp_script_version);
			$inp_script_version_mysql = quote_smart($link, $inp_script_version);
			
			$result = mysqli_query($link, "UPDATE $t_edb_machines_all_tasks_available SET
							task_available_script_version=$inp_script_version_mysql
							 WHERE task_available_id=$get_current_task_available_id") or die(mysqli_error($link));

			// Upload file
			if(!(is_dir("../_uploads"))){
				mkdir("../_uploads");
			}
			if(!(is_dir("../_uploads/edb"))){
				mkdir("../_uploads/edb");
			}
			if(!(is_dir("../_uploads/edb/machines_all_tasks_available"))){
				mkdir("../_uploads/edb/machines_all_tasks_available");
			}
			if(!(is_dir("../_uploads/edb/machines_all_tasks_available/$get_current_task_available_id"))){
				mkdir("../_uploads/edb/machines_all_tasks_available/$get_current_task_available_id");
			}

			$inp_script_file_name = stripslashes($_FILES['inp_script_file']['name']);
			$extension = get_extension($inp_script_file_name);
			$extension = strtolower($extension);

			$ft_script_file = "";
			$fm_script_file = "";

			$inp_script_name = clean($get_current_task_available_name);
			$inp_script_name = $inp_script_name . "_" . $inp_script_version . ".$extension";

			if($inp_script_file_name){
				if (($extension != "exe")) {
					$ft_script_file = "warning";
					$fm_script_file = "unknown_file_format";
				}
				else{
					$tmp_name = $_FILES['inp_script_file']['tmp_name'];
					$size = filesize($_FILES['inp_script_file']['tmp_name']);

	
					if(move_uploaded_file($tmp_name, "../_uploads/edb/machines_all_tasks_available/$get_current_task_available_id/$inp_script_name")){

						$ft_script_file = "success";
						$fm_script_file = "script_file_uploaded_as_$inp_script_name";

						// Path
						$inp_script_path = "_uploads/edb/machines_all_tasks_available/$get_current_task_available_id";
						$inp_script_path_mysql = quote_smart($link, $inp_script_path);

						// File 
						$inp_script_file_mysql = quote_smart($link, $inp_script_name);
						
						// Update
						$result = mysqli_query($link, "UPDATE $t_edb_machines_all_tasks_available SET
							task_available_script_path=$inp_script_path_mysql, 
							task_available_script_file=$inp_script_file_mysql 
							 WHERE task_available_id=$get_current_task_available_id") or die(mysqli_error($link));

						
					}
				}
			}


			// Code
			$inp_code = $_POST['inp_code'];

			$sql = "UPDATE $t_edb_machines_all_tasks_available SET task_available_code=? WHERE task_available_id=$get_current_task_available_id";
			$stmt = $link->prepare($sql);
			$stmt->bind_param("s", $inp_code);
			$stmt->execute();
			if ($stmt->errno) {
				echo "FAILURE!!! " . $stmt->error; die;
			}

	





			$url = "index.php?open=edb&page=$page&action=$action&task_available_id=$get_current_task_available_id&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved&$ft_script_file=$ft_script_file&$fm_script_file=$fm_script_file";
			header("Location: $url");
			exit;
			
		}
		echo"
		<h1>$get_current_task_available_name</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Machines all tasks available</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_task_available&amp;task_available_id=$get_current_task_available_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_task_available_name</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;task_available_id=$get_current_task_available_id&amp;editor_language=$editor_language&amp;l=$l\">Script and exe</a>
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



		<!-- Edit task_available -->
			<!-- Focus -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_name\"]').focus();
				});
				</script>
			<!-- //Focus -->

			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;task_available_id=$get_current_task_available_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p><b>Version:</b><br />
			<input type=\"text\" name=\"inp_script_version\" value=\"$get_current_task_available_script_version\" size=\"25\" />
			</p>

			<p><b>Script file:</b><br />
			<a href=\"../$get_current_task_available_script_path/$get_current_task_available_script_file\">$get_current_task_available_script_file</a>
			</p>

			<p><b>Upload new script file:</b><br />
			<span class=\"smal\">Leave blank to use old script file</span><br />
			<input type=\"file\" name=\"inp_script_file\" />
			</p>



			<p><b>Script code (for refrence):</b><br />
			<textarea name=\"inp_code\" rows=\"30\" cols=\"90\" style=\"width: 100%;height: 60%;\">";
			$get_current_task_available_code = str_replace("<br />", "\n", $get_current_task_available_code);
			echo"$get_current_task_available_code</textarea>
			</p>


			<p>
			<input type=\"submit\" value=\"Save\" class=\"btn_default\" />
			</p>
			</form>
		<!-- //Edit task_available -->
		";
	} // task_available found
} // edit_script_and_exe
elseif($action == "delete_task_available"){
	// Find task avaible
	$task_available_id_mysql = quote_smart($link, $task_available_id);
	$query = "SELECT task_available_id, task_available_name, task_available_machine_type_id, task_available_machine_type_title, task_available_description, task_available_script_file FROM $t_edb_machines_all_tasks_available WHERE task_available_id=$task_available_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_task_available_id, $get_current_task_available_name, $get_current_task_available_machine_type_id, $get_current_task_available_machine_type_title, $get_current_task_available_description, $get_current_task_available_script_file) = $row;
	
	if($get_current_task_available_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		if($process == "1"){
			
			$result = mysqli_query($link, "DELETE FROM $t_edb_machines_all_tasks_available WHERE task_available_id=$get_current_task_available_id") or die(mysqli_error($link));



			$url = "index.php?open=edb&page=$page&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=deleted";
			header("Location: $url");
			exit;
			
		}
		echo"
		<h1>$get_current_task_available_name</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Machines all tasks available</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;task_available_id=$get_current_task_available_id&amp;editor_language=$editor_language&amp;l=$l\">Delete $get_current_task_available_name</a>
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



		<!-- Delete form -->
			<p>Are you sure?</p>

			<p>
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;task_available_id=$get_current_task_available_id&amp;editor_language=$editor_language&amp;l=$l&amp;process=1\" class=\"btn_danger\">Delete</a></p>

		<!-- //Delete form -->
		";
	} // task avaible found
} // delete_task avaible 
?>