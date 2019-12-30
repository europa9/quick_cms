<?php
/**
*
* File: _admin/_inc/edb/priorities.php
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


$t_edb_physical_locations_index		= $mysqlPrefixSav . "edb_physical_locations_index";
$t_edb_physical_locations_directories	= $mysqlPrefixSav . "edb_physical_locations_directories";

$t_edb_software_index	= $mysqlPrefixSav . "edb_software_index";

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['priority_id'])) {
	$priority_id = $_GET['priority_id'];
	$priority_id = strip_tags(stripslashes($priority_id));
}
else{
	$priority_id = "";
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
	<h1>Priorities</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=priorities&amp;editor_language=$editor_language&amp;l=$l\">Priorities</a>
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

	<!-- Navigation -->
		<p>
		<a href=\"index.php?open=edb&amp;page=$page&amp;action=new&amp;order_by=$;order_by&amp;order_method=$order_method&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">New</a>
		</p>
	<!-- //Navigation -->


	<!-- Case codes -->

		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\" style=\"width: 30%;\">
			<span><b>Weight</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Title</b></span>
		   </th>
		  </tr>
		 </thead>
		 <tbody id=\"autosearch_search_results_hide\">

		";
		$human_counter = 1;
		$query = "SELECT priority_id, priority_title, priority_title_clean, priority_bg_color, priority_border_color, priority_text_color, priority_link_color, priority_weight, priority_number_of_cases_now FROM $t_edb_case_priorities";
		if($order_by == "priority_weight" OR $order_by == "priority_title"){
			if($order_method  == "asc" OR $order_method == "desc"){
				$query = $query  . " ORDER BY $order_by $order_method";
			}
		}
		else{
			$query = $query  . " ORDER BY priority_weight ASC";
		}
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_priority_id, $get_priority_title, $get_priority_title_clean, $get_priority_bg_color, $get_priority_border_color, $get_priority_text_color, $get_priority_link_color, $get_priority_weight, $get_priority_number_of_cases_now) = $row;
			
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
				<a id=\"#priority$get_priority_id\"></a>
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit&amp;priority_id=$get_priority_id&amp;l=$l&amp;editor_language=$editor_language\">$get_priority_weight</a>
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit&amp;priority_id=$get_priority_id&amp;l=$l&amp;editor_language=$editor_language\">$get_priority_title</a>
				</span>
			  </td>
			 </tr>";

			if($human_counter != "$get_priority_weight"){
				$result_update = mysqli_query($link, "UPDATE $t_edb_case_priorities SET priority_weight=$human_counter WHERE priority_id=$get_priority_id") or die(mysqli_error($link));
				echo"
				<img src=\"_design/gfx/loading_22.gif\" alt=\"loading_22.gif\" /> <h2>Updating weight</h2>

				<meta http-equiv=\"refresh\" content=\"1;URL='index.php?open=edb&page=priorities&editor_language=$editor_language&l=$l'\" />    
				";
			}

			$human_counter++;
		} // while
		
		echo"
		 </tbody>
		</table>
		<table class=\"hor-zebra\" id=\"autosearch_search_results_show\">
		</table>
	<!-- //priorities -->
	";
} // action == ""
elseif($action == "edit"){
	// Find
	$priority_id_mysql = quote_smart($link, $priority_id);
	$query = "SELECT priority_id, priority_title, priority_title_clean, priority_bg_color, priority_border_color, priority_text_color, priority_link_color, priority_weight, priority_number_of_cases_now FROM $t_edb_case_priorities WHERE priority_id=$priority_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_priority_id, $get_current_priority_title, $get_current_priority_title_clean, $get_current_priority_bg_color, $get_current_priority_border_color, $get_current_priority_text_color, $get_current_priority_link_color, $get_current_priority_weight, $get_current_priority_number_of_cases_now) = $row;
	
	if($get_current_priority_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

	

		if($process == "1"){


			$inp_title = $_POST['inp_title'];
			$inp_title = output_html($inp_title);
			$inp_title_mysql = quote_smart($link, $inp_title);

			$inp_title_clean = clean($inp_title);
			$inp_title_clean_mysql = quote_smart($link, $inp_title_clean);

			$inp_bg_color = $_POST['inp_bg_color'];
			$inp_bg_color = output_html($inp_bg_color);
			$inp_bg_color_mysql = quote_smart($link, $inp_bg_color);

			$inp_border_color = $_POST['inp_border_color'];
			$inp_border_color = output_html($inp_border_color);
			$inp_border_color_mysql = quote_smart($link, $inp_border_color);

			$inp_text_color = $_POST['inp_text_color'];
			$inp_text_color = output_html($inp_text_color);
			$inp_text_color_mysql = quote_smart($link, $inp_text_color);

			$inp_link_color = $_POST['inp_link_color'];
			$inp_link_color = output_html($inp_link_color);
			$inp_link_color_mysql = quote_smart($link, $inp_link_color);

			$inp_weight = $_POST['inp_weight'];
			$inp_weight = output_html($inp_weight);
			$inp_weight_mysql = quote_smart($link, $inp_weight);


			$result = mysqli_query($link, "UPDATE $t_edb_case_priorities SET 
					priority_title=$inp_title_mysql, 
					priority_title_clean=$inp_title_clean_mysql, 
					priority_bg_color=$inp_bg_color_mysql, 
					priority_border_color=$inp_border_color_mysql, 
					priority_text_color=$inp_text_color_mysql, 
					priority_link_color=$inp_link_color_mysql, 
					priority_weight=$inp_weight_mysql
					 WHERE priority_id=$get_current_priority_id") or die(mysqli_error($link));


			$url = "index.php?open=edb&page=$page&action=$action&priority_id=$get_current_priority_id&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>$get_current_priority_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=priorities&amp;editor_language=$editor_language&amp;l=$l\">Priorities</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;priority_id=$get_current_priority_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_priority_title</a>
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

		<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_title\"]').focus();
			});
			</script>
		<!-- //Focus -->

		<!-- Edit form -->";
		
			echo"
			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;priority_id=$get_current_priority_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p>Title:<br />
			<input type=\"text\" name=\"inp_title\" value=\"$get_current_priority_title\" size=\"25\" />
			</p>

			<p>Weight:<br />
			<input type=\"text\" name=\"inp_weight\" value=\"$get_current_priority_weight\" size=\"10\" />
			</p>

			<p>Bg color: <span style=\"color: $get_current_priority_bg_color;background: $get_current_priority_bg_color;\">$get_current_priority_bg_color</span><br />
			<input type=\"text\" name=\"inp_bg_color\" value=\"$get_current_priority_bg_color\" size=\"10\" />
			</p>

			<p>Border color: <span style=\"color: $get_current_priority_border_color;background: $get_current_priority_border_color;\">$get_current_priority_border_color</span><br />
			<input type=\"text\" name=\"inp_border_color\" value=\"$get_current_priority_border_color\" size=\"10\" />
			</p>

			<p>Text color: <span style=\"color: $get_current_priority_text_color;background: $get_current_priority_text_color;\">$get_current_priority_text_color</span><br />
			<input type=\"text\" name=\"inp_text_color\" value=\"$get_current_priority_text_color\" size=\"10\" />
			</p>

			<p>Link color: <span style=\"color: $get_current_priority_link_color;background: $get_current_priority_link_color;\">$get_current_priority_link_color</span><br />
			<input type=\"text\" name=\"inp_link_color\" value=\"$get_current_priority_link_color\" size=\"10\" />
			</p>

			<p><input type=\"submit\" value=\"Save changes\" class=\"btn_default\" />
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete&amp;priority_id=$get_current_priority_id&amp;l=$l\" class=\"btn_warning\">Delete</a></p>
	
			</form>
		<!-- //Edit form -->

		";
	} // found
} // edit
elseif($action == "delete"){
	// Find
	$priority_id_mysql = quote_smart($link, $priority_id);
	$query = "SELECT priority_id, priority_title, priority_title_clean, priority_bg_color, priority_border_color, priority_text_color, priority_link_color, priority_weight, priority_number_of_cases_now FROM $t_edb_case_priorities WHERE priority_id=$priority_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_priority_id, $get_current_priority_title, $get_current_priority_title_clean, $get_current_priority_bg_color, $get_current_priority_border_color, $get_current_priority_text_color, $get_current_priority_link_color, $get_current_priority_weight, $get_current_priority_number_of_cases_now) = $row;
		if($get_current_priority_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

	

		if($process == "1"){



			$result = mysqli_query($link, "DELETE FROM $t_edb_case_priorities WHERE priority_id=$get_current_priority_id") or die(mysqli_error($link));


			$url = "index.php?open=edb&page=$page&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=deleted";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>$get_current_priority_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=priorities&amp;editor_language=$editor_language&amp;l=$l\">Priorities</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;priority_id=$get_current_priority_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_priority_title</a>
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

		<!-- Delete -->
			<p>
			Are you sure you want to delete?
			</p>

			<p>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;priority_id=$get_current_priority_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">Delete</a></p>
	
			</form>
		<!-- //Delete -->

		";
	} // found
} // delete
elseif($action == "new"){
	if($process == "1"){

		$inp_title = $_POST['inp_title'];
		$inp_title = output_html($inp_title);
		$inp_title_mysql = quote_smart($link, $inp_title);

		$inp_title_clean = clean($inp_title);
		$inp_title_clean_mysql = quote_smart($link, $inp_title_clean);

		$inp_bg_color = $_POST['inp_bg_color'];
		$inp_bg_color = output_html($inp_bg_color);
		$inp_bg_color_mysql = quote_smart($link, $inp_bg_color);

		$inp_border_color = $_POST['inp_border_color'];
		$inp_border_color = output_html($inp_border_color);
		$inp_border_color_mysql = quote_smart($link, $inp_border_color);

		$inp_text_color = $_POST['inp_text_color'];
		$inp_text_color = output_html($inp_text_color);
		$inp_text_color_mysql = quote_smart($link, $inp_text_color);

		$inp_link_color = $_POST['inp_link_color'];
		$inp_link_color = output_html($inp_link_color);
		$inp_link_color_mysql = quote_smart($link, $inp_link_color);

		$inp_weight = $_POST['inp_weight'];
		$inp_weight = output_html($inp_weight);
		$inp_weight_mysql = quote_smart($link, $inp_weight);


		mysqli_query($link, "INSERT INTO $t_edb_case_priorities 
		(priority_id, priority_title, priority_title_clean, priority_bg_color, priority_border_color, priority_text_color, priority_link_color, priority_weight, priority_number_of_cases_now) 
		VALUES 
		(NULL, $inp_title_mysql, $inp_title_clean_mysql, $inp_bg_color_mysql, $inp_border_color_mysql, $inp_text_color_mysql, $inp_link_color_mysql, $inp_weight_mysql, 0)")
		or die(mysqli_error($link));

		$url = "index.php?open=edb&page=$page&action=$action&priority_id=$get_current_priority_id&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=saved";
		header("Location: $url");
		exit;
	}
	echo"
	<h1>New</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=priorities&amp;editor_language=$editor_language&amp;l=$l\">Priorities</a>
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

	<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_title\"]').focus();
			});
			</script>
	<!-- //Focus -->

	<!-- New form -->
		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p>Title:<br />
			<input type=\"text\" name=\"inp_title\" value=\"\" size=\"25\" />
			</p>

			<p>Weight:<br />
			<input type=\"text\" name=\"inp_weight\" value=\"\" size=\"10\" />
			</p>

			<p>Bg color:<br />
			<input type=\"text\" name=\"inp_bg_color\" value=\"\" size=\"10\" />
			</p>

			<p>Border color:<br />
			<input type=\"text\" name=\"inp_border_color\" value=\"\" size=\"10\" />
			</p>

			<p>Text color:<br />
			<input type=\"text\" name=\"inp_text_color\" value=\"\" size=\"10\" />
			</p>

			<p>Link color:<br />
			<input type=\"text\" name=\"inp_link_color\" value=\"\" size=\"10\" />
			</p>

			<p><input type=\"submit\" value=\"Create\" class=\"btn_default\" />
			</p>
	
			</form>
	<!-- //New form -->

	";
} // new
?>