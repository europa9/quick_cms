<?php
/**
*
* File: _admin/_inc/edb/human_tasks_on_new_case
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

$t_edb_human_tasks_on_new_case		= $mysqlPrefixSav . "edb_human_tasks_on_new_case";
$t_edb_human_tasks_in_case_categories	= $mysqlPrefixSav . "edb_human_tasks_in_case_categories";
$t_edb_human_tasks_in_case_tasks	= $mysqlPrefixSav . "edb_human_tasks_in_case_tasks";


/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['in_case_task_id'])) {
	$in_case_task_id = $_GET['in_case_task_id'];
	$in_case_task_id = strip_tags(stripslashes($in_case_task_id));
}
else{
	$in_case_task_id = "";
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
	<h1>Human tasks in case</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Human tasks in case</a>
		</p>
	<!-- //Where am I? -->

	<p>
	Human tasks here will be avaible to create under Human tasks in a case.
	</p>

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
		   <th scope=\"col\">
			<span><b>ID</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Title</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Category</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Priority</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Deadline days</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Actions</b></span>
		   </th>
		  </tr>
		 </thead>
		 <tbody id=\"autosearch_search_results_hide\">

		";
		$query = "SELECT in_case_task_id, in_case_task_title, in_case_category_id, in_case_category_title, in_case_task_priority_id, in_case_task_priority_title, in_case_task_deadline_days FROM $t_edb_human_tasks_in_case_tasks ORDER BY in_case_category_id, in_case_task_title ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_in_case_task_id, $get_in_case_task_title, $get_in_case_category_id, $get_in_case_category_title, $get_in_case_task_priority_id, $get_in_case_task_priority_title, $get_in_case_task_deadline_days) = $row;
			
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
				<a id=\"#in_case_task_id$get_in_case_task_id\"></a>
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit&amp;in_case_task_id=$get_in_case_task_id&amp;l=$l&amp;editor_language=$editor_language\">$get_in_case_task_id</a>
				</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_in_case_task_title</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_in_case_category_title</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_in_case_task_priority_title</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_in_case_task_deadline_days</span>
			  </td>
			  <td class=\"$style\">
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit&amp;in_case_task_id=$get_in_case_task_id&amp;l=$l&amp;editor_language=$editor_language\">Edit</a>
				&middot;
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete&amp;in_case_task_id=$get_in_case_task_id&amp;l=$l&amp;editor_language=$editor_language\">Delete</a>
				</span>
			  </td>
			 </tr>";

		} // while
		
		echo"
		 </tbody>
		</table>
		<table class=\"hor-zebra\" id=\"autosearch_search_results_show\">
		</table>
	<!-- //statuses -->
	";
} // action == ""
elseif($action == "new"){
	if($process == "1"){

		$inp_title = $_POST['inp_title'];
		$inp_title = output_html($inp_title);
		$inp_title_mysql = quote_smart($link, $inp_title);

		$inp_category_id = $_POST['inp_category_id'];
		$inp_category_id = output_html($inp_category_id);
		$inp_category_id_mysql = quote_smart($link, $inp_category_id);

		$query = "SELECT in_case_category_id, in_case_category_title FROM $t_edb_human_tasks_in_case_categories WHERE in_case_category_id=$inp_category_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_in_case_category_id, $get_current_in_case_category_title) = $row;

		$inp_category_title_mysql = quote_smart($link, $get_current_in_case_category_title);

		$inp_priority_id = $_POST['inp_priority_id'];
		$inp_priority_id = output_html($inp_priority_id);
		$inp_priority_id_mysql = quote_smart($link, $inp_priority_id);

		$query = "SELECT priority_id, priority_title FROM $t_edb_case_priorities WHERE priority_id=$inp_priority_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_priority_id, $get_current_priority_title) = $row;

		$inp_priority_title_mysql = quote_smart($link, $get_current_priority_title);

		$inp_deadline_days = $_POST['inp_deadline_days'];
		$inp_deadline_days = output_html($inp_deadline_days);
		$inp_deadline_days_mysql = quote_smart($link, $inp_deadline_days);


		mysqli_query($link, "INSERT INTO $t_edb_human_tasks_in_case_tasks
		(in_case_task_id, in_case_task_title, in_case_category_id, in_case_category_title, in_case_task_priority_id, in_case_task_priority_title, in_case_task_deadline_days) 
		VALUES 
		(NULL, $inp_title_mysql, $inp_category_id_mysql, $inp_category_title_mysql, $inp_priority_id_mysql, $inp_priority_title_mysql, $inp_deadline_days_mysql)")
		or die(mysqli_error($link));

		$url = "index.php?open=edb&page=$page&action=$action&editor_language=$editor_language&l=$l&ft=success&fm=created_$inp_title";
		header("Location: $url");
		exit;
	}
	echo"
	<h1>New</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Human tasks in case</a>
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

		<p>Category: (<a href=\"index.php?open=$open&amp;page=human_tasks_in_case_categories&amp;l=$l\">Edit</a>)<br />
		<select name=\"inp_category_id\">";
		$query = "SELECT in_case_category_id, in_case_category_title FROM $t_edb_human_tasks_in_case_categories ORDER BY in_case_category_title ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_in_case_category_id, $get_in_case_category_title) = $row;
			echo"			";
			echo"<option value=\"$get_in_case_category_id\">$get_in_case_category_title</option>\n";
		}
		echo"
		</select>
		</p>

		<p>Priority:<br />
		<select name=\"inp_priority_id\">";
		$query = "SELECT priority_id, priority_title, priority_title_clean, priority_bg_color, priority_border_color, priority_text_color, priority_link_color, priority_weight, priority_number_of_cases_now FROM $t_edb_case_priorities ORDER BY priority_weight ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_priority_id, $get_priority_title, $get_priority_title_clean, $get_priority_bg_color, $get_priority_border_color, $get_priority_text_color, $get_priority_link_color, $get_priority_weight, $get_priority_number_of_cases_now) = $row;
			echo"			";
			echo"<option value=\"$get_priority_id\">$get_priority_title</option>\n";
		}
		echo"
		</select>
		</p>

		<p>Deadline in days:<br />
		<input type=\"text\" name=\"inp_deadline_days\" value=\"14\" size=\"25\" />
		</p>

		<p><input type=\"submit\" value=\"Create\" class=\"btn_default\" />
		</p>
	
		</form>
	<!-- //New form -->

	";
} // new
elseif($action == "edit"){
	// Find
	$in_case_task_id_mysql = quote_smart($link, $in_case_task_id);
	$query = "SELECT in_case_task_id, in_case_task_title, in_case_category_id, in_case_category_title, in_case_task_priority_id, in_case_task_priority_title, in_case_task_deadline_days FROM $t_edb_human_tasks_in_case_tasks WHERE in_case_task_id=$in_case_task_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_in_case_task_id, $get_current_in_case_task_title, $get_current_in_case_category_id, $get_current_in_case_category_title, $get_current_in_case_task_priority_id, $get_current_in_case_task_priority_title, $get_current_in_case_task_deadline_days) = $row;
	
	if($get_current_in_case_task_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

	

		if($process == "1"){

			$inp_title = $_POST['inp_title'];
			$inp_title = output_html($inp_title);
			$inp_title_mysql = quote_smart($link, $inp_title);

			$inp_category_id = $_POST['inp_category_id'];
			$inp_category_id = output_html($inp_category_id);
			$inp_category_id_mysql = quote_smart($link, $inp_category_id);

			$query = "SELECT in_case_category_id, in_case_category_title FROM $t_edb_human_tasks_in_case_categories WHERE in_case_category_id=$inp_category_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_in_case_category_id, $get_current_in_case_category_title) = $row;

			$inp_category_title_mysql = quote_smart($link, $get_current_in_case_category_title);

			$inp_priority_id = $_POST['inp_priority_id'];
			$inp_priority_id = output_html($inp_priority_id);
			$inp_priority_id_mysql = quote_smart($link, $inp_priority_id);

			$query = "SELECT priority_id, priority_title FROM $t_edb_case_priorities WHERE priority_id=$inp_priority_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_priority_id, $get_current_priority_title) = $row;

			$inp_priority_title_mysql = quote_smart($link, $get_current_priority_title);

			$inp_deadline_days = $_POST['inp_deadline_days'];
			$inp_deadline_days = output_html($inp_deadline_days);
			$inp_deadline_days_mysql = quote_smart($link, $inp_deadline_days);


			$result = mysqli_query($link, "UPDATE $t_edb_human_tasks_in_case_tasks SET 
					in_case_task_title=$inp_title_mysql, 
					in_case_category_id=$inp_category_id_mysql, 
					in_case_category_title=$inp_category_title_mysql, 
					in_case_task_priority_id=$inp_priority_id_mysql, 
					in_case_task_priority_title=$inp_priority_title_mysql, 
					in_case_task_deadline_days=$inp_deadline_days_mysql 
					 WHERE in_case_task_id=$get_current_in_case_task_id") or die(mysqli_error($link));


			$url = "index.php?open=edb&page=$page&action=$action&in_case_task_id=$get_current_in_case_task_id&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>$get_current_in_case_task_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Human tasks in case</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;in_case_task_id=$get_current_in_case_task_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_in_case_task_title</a>
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
			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;in_case_task_id=$get_current_in_case_task_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p>Title:<br />
			<input type=\"text\" name=\"inp_title\" value=\"$get_current_in_case_task_title\" size=\"25\" />
			</p>

			<p>Category: (<a href=\"index.php?open=$open&amp;page=human_tasks_in_case_categories&amp;l=$l\">Edit</a>)<br />
			<select name=\"inp_category_id\">";
			$query = "SELECT in_case_category_id, in_case_category_title FROM $t_edb_human_tasks_in_case_categories ORDER BY in_case_category_title ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_in_case_category_id, $get_in_case_category_title) = $row;
				echo"			";
				echo"<option value=\"$get_in_case_category_id\""; if($get_in_case_category_id == "$get_current_in_case_category_id"){ echo" selected=\"selected\""; } echo">$get_in_case_category_title</option>\n";
			}
			echo"
			</select>
			</p>

			<p>Priority:<br />
			<select name=\"inp_priority_id\">";
			$query = "SELECT priority_id, priority_title, priority_title_clean, priority_bg_color, priority_border_color, priority_text_color, priority_link_color, priority_weight, priority_number_of_cases_now FROM $t_edb_case_priorities ORDER BY priority_weight ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_priority_id, $get_priority_title, $get_priority_title_clean, $get_priority_bg_color, $get_priority_border_color, $get_priority_text_color, $get_priority_link_color, $get_priority_weight, $get_priority_number_of_cases_now) = $row;
				echo"			";
				echo"<option value=\"$get_priority_id\""; if($get_priority_id == "$get_current_in_case_task_priority_id"){ echo" selected=\"selected\""; } echo">$get_priority_title</option>\n";
			}
			echo"
			</select>
			</p>

			<p>Deadline in days:<br />
			<input type=\"text\" name=\"inp_deadline_days\" value=\"$get_current_in_case_task_deadline_days\" size=\"25\" />
			</p>

			<p><input type=\"submit\" value=\"Save changes\" class=\"btn_default\" />
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete&amp;status_id=$get_current_status_id&amp;l=$l\" class=\"btn_warning\">Delete</a></p>
	
			</form>
		<!-- //Edit form -->

		";
	} // found
} // edit
elseif($action == "delete"){
	// Find
	$in_case_task_id_mysql = quote_smart($link, $in_case_task_id);
	$query = "SELECT in_case_task_id, in_case_task_title, in_case_category_id, in_case_category_title, in_case_task_priority_id, in_case_task_priority_title, in_case_task_deadline_days FROM $t_edb_human_tasks_in_case_tasks WHERE in_case_task_id=$in_case_task_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_in_case_task_id, $get_current_in_case_task_title, $get_current_in_case_category_id, $get_current_in_case_category_title, $get_current_in_case_task_priority_id, $get_current_in_case_task_priority_title, $get_current_in_case_task_deadline_days) = $row;
	
	if($get_current_in_case_task_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

		if($process == "1"){



			$result = mysqli_query($link, "DELETE FROM $t_edb_human_tasks_in_case_tasks WHERE in_case_task_id=$get_current_in_case_task_id") or die(mysqli_error($link));


			$url = "index.php?open=edb&page=$page&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=deleted";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>$get_current_in_case_task_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Human tasks in case</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;in_case_task_id=$get_current_in_case_task_id&amp;editor_language=$editor_language&amp;l=$l\">Delete $get_current_in_case_task_title</a>
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
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;in_case_task_id=$get_current_in_case_task_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">Delete</a></p>
	
			</form>
		<!-- //Delete -->

		";
	} // found
} // delete
?>