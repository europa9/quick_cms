<?php
/**
*
* File: _admin/_inc/edb/review_standards.php
* Version 12:59 07.10.2019
* Copyright (c) 2008-2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}
/*- Tables ---------------------------------------------------------------------------- */
$t_edb_case_index				= $mysqlPrefixSav . "edb_case_index";
$t_edb_case_index_events			= $mysqlPrefixSav . "edb_case_index_events";
$t_edb_case_index_evidence_records		= $mysqlPrefixSav . "edb_case_index_evidence_records";
$t_edb_case_index_evidence_items		= $mysqlPrefixSav . "edb_case_index_evidence_items";
$t_edb_case_index_evidence_items_sim_cards	= $mysqlPrefixSav . "edb_case_index_evidence_items_sim_cards";
$t_edb_case_index_evidence_items_sd_cards	= $mysqlPrefixSav . "edb_case_index_evidence_items_sd_cards";
$t_edb_case_index_evidence_items_networks	= $mysqlPrefixSav . "edb_case_index_evidence_items_networks";
$t_edb_case_index_evidence_items_hard_disks	= $mysqlPrefixSav . "edb_case_index_evidence_items_hard_disks";
$t_edb_case_index_evidence_items_mirror_files	= $mysqlPrefixSav . "edb_case_index_evidence_items_mirror_files";
$t_edb_case_index_statuses			= $mysqlPrefixSav . "edb_case_index_statuses";
$t_edb_case_index_human_tasks			= $mysqlPrefixSav . "edb_case_index_human_tasks";
$t_edb_case_index_automated_tasks		= $mysqlPrefixSav . "edb_case_index_automated_tasks";
$t_edb_case_index_notes				= $mysqlPrefixSav . "edb_case_index_notes";
$t_edb_case_index_open_case_menu_counters	= $mysqlPrefixSav . "edb_case_index_open_case_menu_counters";
$t_edb_case_codes				= $mysqlPrefixSav . "edb_case_codes";
$t_edb_case_statuses				= $mysqlPrefixSav . "edb_case_statuses";
$t_edb_case_statuses_district_case_counter	= $mysqlPrefixSav . "edb_case_statuses_district_case_counter";
$t_edb_case_statuses_station_case_counter	= $mysqlPrefixSav . "edb_case_statuses_station_case_counter";
$t_edb_case_statuses_user_case_counter		= $mysqlPrefixSav . "edb_case_statuses_user_case_counter";
$t_edb_case_priorities				= $mysqlPrefixSav . "edb_case_priorities";
$t_edb_case_reports				= $mysqlPrefixSav . "edb_case_reports";

$t_edb_districts_index			= $mysqlPrefixSav . "edb_districts_index";
$t_edb_districts_members		= $mysqlPrefixSav . "edb_districts_members";
$t_edb_districts_membership_requests	= $mysqlPrefixSav . "edb_districts_membership_requests";

$t_edb_stations_index			= $mysqlPrefixSav . "edb_stations_index";
$t_edb_stations_members			= $mysqlPrefixSav . "edb_stations_members";
$t_edb_stations_membership_requests	= $mysqlPrefixSav . "edb_stations_membership_requests";
$t_edb_stations_directories		= $mysqlPrefixSav . "edb_stations_directories";
$t_edb_stations_jour			= $mysqlPrefixSav . "edb_stations_jour";

$t_edb_item_types		= $mysqlPrefixSav . "edb_item_types";

$t_edb_software_index	= $mysqlPrefixSav . "edb_software_index";

$t_edb_machines_index				= $mysqlPrefixSav . "edb_machines_index";
$t_edb_machines_types				= $mysqlPrefixSav . "edb_machines_types";
$t_edb_machines_all_tasks_available		= $mysqlPrefixSav . "edb_machines_all_tasks_available";
$t_edb_machines_all_tasks_available_to_item  	= $mysqlPrefixSav . "edb_machines_all_tasks_available_to_item";

$t_edb_agent_log 	= $mysqlPrefixSav . "edb_agent_log";


$t_edb_stats_index 			= $mysqlPrefixSav . "edb_stats_index";
$t_edb_stats_case_codes			= $mysqlPrefixSav . "edb_stats_case_codes";
$t_edb_stats_case_priorites		= $mysqlPrefixSav . "edb_stats_case_priorites";
$t_edb_stats_item_types 		= $mysqlPrefixSav . "edb_stats_item_types";
$t_edb_stats_statuses_per_day		= $mysqlPrefixSav . "edb_stats_statuses_per_day";
$t_edb_stats_employee_of_the_month	= $mysqlPrefixSav . "edb_stats_employee_of_the_month";


$t_edb_review_matrix_titles	= $mysqlPrefixSav . "edb_review_matrix_titles";
$t_edb_review_matrix_fields	= $mysqlPrefixSav . "edb_review_matrix_fields";


/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['title_id'])) {
	$title_id = $_GET['title_id'];
	$title_id = strip_tags(stripslashes($title_id));
}
else{
	$title_id = "";
}
if(isset($_GET['field_id'])) {
	$field_id = $_GET['field_id'];
	$field_id = strip_tags(stripslashes($field_id));
}
else{
	$field_id = "";
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
	<h1>Review standard</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Review standard</a>
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

	<!-- About -->
		<p>
		Review standard is a special matrix that will be created on new cases. 
		</p>
	<!-- //About -->

	<!-- Navigation -->
		<p>
		<a href=\"index.php?open=edb&amp;page=$page&amp;action=new_title&amp;order_by=$;order_by&amp;order_method=$order_method&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">New title</a>
		</p>
	<!-- //Navigation -->


	<!-- Title index -->

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
			<span><b>Colspan</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Actions</b></span>
		   </th>
		  </tr>
		 </thead>

		";
		$human_counter = 1;
		$query = "SELECT title_id, title_name, title_weight, title_colspan FROM $t_edb_review_matrix_titles ORDER BY title_id ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_title_id, $get_title_name, $get_title_weight, $get_title_colspan) = $row;
			
			// Style
			if(isset($style) && $style == ""){
				$style = "odd";
			}
			else{
				$style = "";
			}
	
			// Cellspan control
			$query_count = "SELECT count(field_id) FROM $t_edb_review_matrix_fields WHERE field_title_id=$get_title_id";
			$result_count = mysqli_query($link, $query_count);
			$row_count = mysqli_fetch_row($result_count);
			list($get_count_field_id) = $row_count;
			if($get_title_colspan != "$get_count_field_id"){
				$result_upadte = mysqli_query($link, "UPDATE $t_edb_review_matrix_titles SET title_colspan=$get_count_field_id WHERE title_id=$get_title_id");
			}
	
			// Counter
			if($human_counter != "$get_title_weight"){
				$result_upadte = mysqli_query($link, "UPDATE $t_edb_review_matrix_titles SET title_weight=$human_counter WHERE title_id=$get_title_id");
			}

			echo"
			 <tr>
			  <td class=\"$style\">
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=title_fields&amp;title_id=$get_title_id&amp;l=$l&amp;editor_language=$editor_language\">$get_title_id</a>
				</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_title_name</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_title_colspan</span>
			  </td>
			  <td class=\"$style\">
				<span>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=title_fields&amp;title_id=$get_title_id&amp;l=$l&amp;editor_language=$editor_language\">Fields</a>
				&middot;
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit_title&amp;title_id=$get_title_id&amp;l=$l&amp;editor_language=$editor_language\">Edit</a>
				&middot;
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete_title&amp;title_id=$get_title_id&amp;l=$l&amp;editor_language=$editor_language\">Delete</a>
				</span>
			  </td>
			 </tr>";
			$human_counter = $human_counter+1;
		} // while
		
		echo"
		 </tbody>
		</table>
	<!-- //Title index -->
	";
} // action == ""
elseif($action == "new_title"){
	if($process == "1"){

		$inp_name = $_POST['inp_name'];
		$inp_name = output_html($inp_name);
		$inp_name_mysql = quote_smart($link, $inp_name);

		$inp_headcell_text_color = $_POST['inp_headcell_text_color'];
		$inp_headcell_text_color = output_html($inp_headcell_text_color);
		$inp_headcell_text_color_mysql = quote_smart($link, $inp_headcell_text_color);

		$inp_headcell_bg_color = $_POST['inp_headcell_bg_color'];
		$inp_headcell_bg_color = output_html($inp_headcell_bg_color);
		$inp_headcell_bg_color_mysql = quote_smart($link, $inp_headcell_bg_color);

		$inp_headcell_border_color_edge = $_POST['inp_headcell_border_color_edge'];
		$inp_headcell_border_color_edge = output_html($inp_headcell_border_color_edge);
		$inp_headcell_border_color_edge_mysql = quote_smart($link, $inp_headcell_border_color_edge);

		$inp_headcell_border_color_center = $_POST['inp_headcell_border_color_center'];
		$inp_headcell_border_color_center = output_html($inp_headcell_border_color_center);
		$inp_headcell_border_color_center_mysql = quote_smart($link, $inp_headcell_border_color_center);




		$inp_bodycell_text_color = $_POST['inp_bodycell_text_color'];
		$inp_bodycell_text_color = output_html($inp_bodycell_text_color);
		$inp_bodycell_text_color_mysql = quote_smart($link, $inp_bodycell_text_color);

		$inp_bodycell_bg_color = $_POST['inp_bodycell_bg_color'];
		$inp_bodycell_bg_color = output_html($inp_bodycell_bg_color);
		$inp_bodycell_bg_color_mysql = quote_smart($link, $inp_bodycell_bg_color);

		$inp_bodycell_border_color_edge = $_POST['inp_bodycell_border_color_edge'];
		$inp_bodycell_border_color_edge = output_html($inp_bodycell_border_color_edge);
		$inp_bodycell_border_color_edge_mysql = quote_smart($link, $inp_bodycell_border_color_edge);

		$inp_bodycell_border_color_center = $_POST['inp_bodycell_border_color_center'];
		$inp_bodycell_border_color_center = output_html($inp_bodycell_border_color_center);
		$inp_bodycell_border_color_center_mysql = quote_smart($link, $inp_bodycell_border_color_center);



		$inp_subcell_text_color = $_POST['inp_subcell_text_color'];
		$inp_subcell_text_color = output_html($inp_subcell_text_color);
		$inp_subcell_text_color_mysql = quote_smart($link, $inp_subcell_text_color);

		$inp_subcell_bg_color = $_POST['inp_subcell_bg_color'];
		$inp_subcell_bg_color = output_html($inp_subcell_bg_color);
		$inp_subcell_bg_color_mysql = quote_smart($link, $inp_subcell_bg_color);

		$inp_subcell_border_color_edge = $_POST['inp_subcell_border_color_edge'];
		$inp_subcell_border_color_edge = output_html($inp_subcell_border_color_edge);
		$inp_subcell_border_color_edge_mysql = quote_smart($link, $inp_subcell_border_color_edge);

		$inp_subcell_border_color_center = $_POST['inp_subcell_border_color_center'];
		$inp_subcell_border_color_center = output_html($inp_subcell_border_color_center);
		$inp_subcell_border_color_center_mysql = quote_smart($link, $inp_subcell_border_color_center);


		mysqli_query($link, "INSERT INTO $t_edb_review_matrix_titles
		(title_id, title_name, 
		title_headcell_text_color, title_headcell_bg_color, title_headcell_border_color_edge, title_headcell_border_color_center, 
		title_bodycell_text_color, title_bodycell_bg_color, title_bodycell_border_color_edge, title_bodycell_border_color_center, 
		title_subcell_text_color, title_subcell_bg_color, title_subcell_border_color_edge, title_subcell_border_color_center) 
		VALUES 
		(NULL, $inp_name_mysql, 
		$inp_headcell_text_color_mysql, $inp_headcell_bg_color_mysql, $inp_headcell_border_color_edge_mysql, $inp_headcell_border_color_center_mysql, 
		$inp_bodycell_text_color_mysql, $inp_bodycell_bg_color_mysql, $inp_bodycell_border_color_edge_mysql, $inp_bodycell_border_color_center_mysql, 
		$inp_subcell_text_color_mysql, $inp_subcell_bg_color_mysql, $inp_subcell_border_color_edge_mysql, $inp_subcell_border_color_center_mysql)")
		or die(mysqli_error($link));

		$url = "index.php?open=edb&page=$page&action=$action&editor_language=$editor_language&l=$l&ft=success&fm=saved_$inp_name";
		header("Location: $url");
		exit;
	}
	echo"
	<h1>New</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Review standard</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;editor_language=$editor_language&amp;l=$l\">New title</a>
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
			\$('[name=\"inp_name\"]').focus();
		});
		</script>
	<!-- //Focus -->

	<!-- New form -->
		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

		<p>Name:<br />
		<input type=\"text\" name=\"inp_name\" value=\"\" size=\"25\" />
		</p>

		<hr />
		<p>Headcell Text color:<br />
		<input type=\"text\" name=\"inp_headcell_text_color\" value=\"\" size=\"25\" />
		</p>

		<p>Headcell BG color:<br />
		<input type=\"text\" name=\"inp_headcell_bg_color\" value=\"\" size=\"25\" />
		</p>

		<p>Headcell Border color edge:<br />
		<input type=\"text\" name=\"inp_headcell_border_color_edge\" value=\"\" size=\"25\" />
		</p>


		<p>Headcell Border color center:<br />
		<input type=\"text\" name=\"inp_headcell_border_color_center\" value=\"\" size=\"25\" />
		</p>


		<hr />
		<p>Bodycell Text color:<br />
		<input type=\"text\" name=\"inp_bodycell_text_color\" value=\"\" size=\"25\" />
		</p>

		<p>Bodycell BG color:<br />
		<input type=\"text\" name=\"inp_bodycell_bg_color\" value=\"\" size=\"25\" />
		</p>

		<p>Bodycell Border color edge:<br />
		<input type=\"text\" name=\"inp_bodycell_border_color_edge\" value=\"\" size=\"25\" />
		</p>

		<p>Bodycell Border color center:<br />
		<input type=\"text\" name=\"inp_bodycell_border_color_center\" value=\"\" size=\"25\" />
		</p>



		<hr />
		<p>Subcell Text color:<br />
		<input type=\"text\" name=\"inp_subcell_text_color\" value=\"\" size=\"25\" />
		</p>

		<p>Subcell BG color:<br />
		<input type=\"text\" name=\"inp_subcell_bg_color\" value=\"\" size=\"25\" />
		</p>

		<p>Subcell Border color edge:<br />
		<input type=\"text\" name=\"inp_subcell_border_color_edge\" value=\"\" size=\"25\" />
		</p>

		<p>Subcell Border color center:<br />
		<input type=\"text\" name=\"inp_subcell_border_color_center\" value=\"\" size=\"25\" />
		</p>


		<p><input type=\"submit\" value=\"Create\" class=\"btn_default\" />
		</p>
	
		</form>
	<!-- //New form -->

	";
} // new
elseif($action == "edit_title"){
	// Find title
	$title_id_mysql = quote_smart($link, $title_id);
	$query = "SELECT title_id, title_name, title_weight, title_colspan, title_headcell_text_color, title_headcell_bg_color, title_headcell_border_color_edge, title_headcell_border_color_center, title_bodycell_text_color, title_bodycell_bg_color, title_bodycell_border_color_edge, title_bodycell_border_color_center, title_subcell_text_color, title_subcell_bg_color, title_subcell_border_color_edge, title_subcell_border_color_center FROM $t_edb_review_matrix_titles WHERE title_id=$title_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_title_id, $get_current_title_name, $get_current_title_weight, $get_current_title_colspan, $get_current_title_headcell_text_color, $get_current_title_headcell_bg_color, $get_current_title_headcell_border_color_edge, $get_current_title_headcell_border_color_center, $get_current_title_bodycell_text_color, $get_current_title_bodycell_bg_color, $get_current_title_bodycell_border_color_edge, $get_current_title_bodycell_border_color_center, $get_current_title_subcell_text_color, $get_current_title_subcell_bg_color, $get_current_title_subcell_border_color_edge, $get_current_title_subcell_border_color_center) = $row;
	
	if($get_current_title_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		if($process == "1"){
	
			$inp_name = $_POST['inp_name'];
			$inp_name = output_html($inp_name);
			$inp_name_mysql = quote_smart($link, $inp_name);

			$inp_headcell_text_color = $_POST['inp_headcell_text_color'];
			$inp_headcell_text_color = output_html($inp_headcell_text_color);
			$inp_headcell_text_color_mysql = quote_smart($link, $inp_headcell_text_color);

			$inp_headcell_bg_color = $_POST['inp_headcell_bg_color'];
			$inp_headcell_bg_color = output_html($inp_headcell_bg_color);
			$inp_headcell_bg_color_mysql = quote_smart($link, $inp_headcell_bg_color);

			$inp_headcell_border_color_edge = $_POST['inp_headcell_border_color_edge'];
			$inp_headcell_border_color_edge = output_html($inp_headcell_border_color_edge);
			$inp_headcell_border_color_edge_mysql = quote_smart($link, $inp_headcell_border_color_edge);

			$inp_headcell_border_color_center = $_POST['inp_headcell_border_color_center'];
			$inp_headcell_border_color_center = output_html($inp_headcell_border_color_center);
			$inp_headcell_border_color_center_mysql = quote_smart($link, $inp_headcell_border_color_center);




			$inp_bodycell_text_color = $_POST['inp_bodycell_text_color'];
			$inp_bodycell_text_color = output_html($inp_bodycell_text_color);
			$inp_bodycell_text_color_mysql = quote_smart($link, $inp_bodycell_text_color);

			$inp_bodycell_bg_color = $_POST['inp_bodycell_bg_color'];
			$inp_bodycell_bg_color = output_html($inp_bodycell_bg_color);
			$inp_bodycell_bg_color_mysql = quote_smart($link, $inp_bodycell_bg_color);

			$inp_bodycell_border_color_edge = $_POST['inp_bodycell_border_color_edge'];
			$inp_bodycell_border_color_edge = output_html($inp_bodycell_border_color_edge);
			$inp_bodycell_border_color_edge_mysql = quote_smart($link, $inp_bodycell_border_color_edge);

			$inp_bodycell_border_color_center = $_POST['inp_bodycell_border_color_center'];
			$inp_bodycell_border_color_center = output_html($inp_bodycell_border_color_center);
			$inp_bodycell_border_color_center_mysql = quote_smart($link, $inp_bodycell_border_color_center);



			$inp_subcell_text_color = $_POST['inp_subcell_text_color'];
			$inp_subcell_text_color = output_html($inp_subcell_text_color);
			$inp_subcell_text_color_mysql = quote_smart($link, $inp_subcell_text_color);

			$inp_subcell_bg_color = $_POST['inp_subcell_bg_color'];
			$inp_subcell_bg_color = output_html($inp_subcell_bg_color);
			$inp_subcell_bg_color_mysql = quote_smart($link, $inp_subcell_bg_color);

			$inp_subcell_border_color_edge = $_POST['inp_subcell_border_color_edge'];
			$inp_subcell_border_color_edge = output_html($inp_subcell_border_color_edge);
			$inp_subcell_border_color_edge_mysql = quote_smart($link, $inp_subcell_border_color_edge);

			$inp_subcell_border_color_center = $_POST['inp_subcell_border_color_center'];
			$inp_subcell_border_color_center = output_html($inp_subcell_border_color_center);
			$inp_subcell_border_color_center_mysql = quote_smart($link, $inp_subcell_border_color_center);


			$result = mysqli_query($link, "UPDATE $t_edb_review_matrix_titles SET 
			title_name=$inp_name_mysql, 
			title_headcell_text_color=$inp_headcell_text_color_mysql, 
			title_headcell_bg_color=$inp_headcell_bg_color_mysql, 
			title_headcell_border_color_edge=$inp_headcell_border_color_edge_mysql, 
			title_headcell_border_color_center=$inp_headcell_border_color_center_mysql, 
			title_bodycell_text_color=$inp_bodycell_text_color_mysql, 
			title_bodycell_bg_color=$inp_bodycell_bg_color_mysql, 
			title_bodycell_border_color_edge=$inp_bodycell_border_color_edge_mysql,
			title_bodycell_border_color_center=$inp_bodycell_border_color_center_mysql,
			title_subcell_text_color=$inp_subcell_text_color_mysql, 
			title_subcell_bg_color=$inp_subcell_bg_color_mysql, 
			title_subcell_border_color_edge=$inp_subcell_border_color_edge_mysql,
			title_subcell_border_color_center=$inp_subcell_border_color_center_mysql 
			 WHERE title_id=$get_current_title_id");

	
			$url = "index.php?open=edb&page=$page&action=$action&title_id=$get_current_title_id&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>Edit title $get_current_title_name</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Review standard</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;title_id=$get_current_title_id&amp;editor_language=$editor_language&amp;l=$l\">Edit title $get_current_title_name</a>
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
				\$('[name=\"inp_name\"]').focus();
			});
			</script>
		<!-- //Focus -->

		<!-- Edit title form -->
			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;title_id=$get_current_title_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p>Name:<br />
			<input type=\"text\" name=\"inp_name\" value=\"$get_current_title_name\" size=\"25\" />
			</p>

			<hr />
			<p>Headcell Text color:<br />
			<input type=\"text\" name=\"inp_headcell_text_color\" value=\"$get_current_title_headcell_text_color\" size=\"25\" />
			</p>

			<p>Headcell BG color:<br />
			<input type=\"text\" name=\"inp_headcell_bg_color\" value=\"$get_current_title_headcell_bg_color\" size=\"25\" />
			</p>

			<p>Headcell Border color edge:<br />
			<input type=\"text\" name=\"inp_headcell_border_color_edge\" value=\"$get_current_title_headcell_border_color_edge\" size=\"25\" />
			</p>

			<p>Headcell Border color center:<br />
			<input type=\"text\" name=\"inp_headcell_border_color_center\" value=\"$get_current_title_headcell_border_color_center\" size=\"25\" />
			</p>


			<hr />
			<p>Bodycell Text color:<br />
			<input type=\"text\" name=\"inp_bodycell_text_color\" value=\"$get_current_title_bodycell_text_color\" size=\"25\" />
			</p>

			<p>Bodycell BG color:<br />
			<input type=\"text\" name=\"inp_bodycell_bg_color\" value=\"$get_current_title_bodycell_bg_color\" size=\"25\" />
			</p>

			<p>Bodycell Border color edge:<br />
			<input type=\"text\" name=\"inp_bodycell_border_color_edge\" value=\"$get_current_title_bodycell_border_color_edge\" size=\"25\" />
			</p>

			<p>Bodycell Border color center:<br />
			<input type=\"text\" name=\"inp_bodycell_border_color_center\" value=\"$get_current_title_bodycell_border_color_center\" size=\"25\" />
			</p>



			<hr />
			<p>Subcell Text color:<br />
			<input type=\"text\" name=\"inp_subcell_text_color\" value=\"$get_current_title_subcell_text_color\" size=\"25\" />
			</p>

			<p>Subcell BG color:<br />
			<input type=\"text\" name=\"inp_subcell_bg_color\" value=\"$get_current_title_subcell_bg_color\" size=\"25\" />
			</p>

			<p>Subcell Border color edge:<br />
			<input type=\"text\" name=\"inp_subcell_border_color_edge\" value=\"$get_current_title_subcell_border_color_edge\" size=\"25\" />
			</p>

			<p>Subcell Border color center:<br />
			<input type=\"text\" name=\"inp_subcell_border_color_center\" value=\"$get_current_title_subcell_border_color_center\" size=\"25\" />
			</p>

			<p><input type=\"submit\" value=\"Save changes\" class=\"btn_default\" />
			</p>
	
			</form>
		<!-- //Edit title form -->

		";
	} // title found
} // edit_title
elseif($action == "delete_title"){
	// Find title
	$title_id_mysql = quote_smart($link, $title_id);
	$query = "SELECT title_id, title_name FROM $t_edb_review_matrix_titles WHERE title_id=$title_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_title_id, $get_current_title_name) = $row;
	
	if($get_current_title_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		if($process == "1"){
	
			
			$result = mysqli_query($link, "DELETE FROM $t_edb_review_matrix_titles WHERE title_id=$get_current_title_id");
			$result = mysqli_query($link, "DELETE FROM $t_edb_review_matrix_fields WHERE field_title_id=$get_current_title_id");

	
			$url = "index.php?open=edb&page=$page&editor_language=$editor_language&l=$l&ft=success&fm=title_deleted";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>Delete title $get_current_title_name</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Review standard</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;title_id=$get_current_title_id&amp;editor_language=$editor_language&amp;l=$l\">Delete title $get_current_title_name</a>
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


		<!-- Delete title form -->
			<p>
			Are you sure you want to delete?
			</p>

			<p>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;title_id=$get_current_title_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">Confirm</a>
			</p>
		<!-- //Delete  title form -->

		";
	} // title found
} // delete_title
elseif($action == "title_fields"){
	// Find title
	$title_id_mysql = quote_smart($link, $title_id);
	$query = "SELECT title_id, title_name FROM $t_edb_review_matrix_titles WHERE title_id=$title_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_title_id, $get_current_title_name) = $row;
	
	if($get_current_title_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		echo"
		<h1>$get_current_title_name</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Review standard</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;title_id=$get_current_title_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_title_name</a>
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


		<!-- Title Fields left and right -->
			<p>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=new_field&amp;title_id=$get_current_title_id&amp;l=$l\" class=\"btn_default\">New field</a>
			</p>

			<table>
			  <tr>
			   <td style=\"width: 200px;vertical-align: top;padding-right: 20px;\">

				<!-- Title index -->

					<table class=\"hor-zebra\">
					 <tbody>
					  <tr>
					   <td>

					";
					$query = "SELECT title_id, title_name, title_colspan FROM $t_edb_review_matrix_titles ORDER BY title_id ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_title_id, $get_title_name, $get_title_colspan) = $row;
			
						// Style
						if(isset($style) && $style == ""){
							$style = "odd";
						}
						else{
							$style = "";
						}

	
						// colspan control
						$query_count = "SELECT count(field_id) FROM $t_edb_review_matrix_fields WHERE field_title_id=$get_title_id";
						$result_count = mysqli_query($link, $query_count);
						$row_count = mysqli_fetch_row($result_count);
						list($get_count_field_id) = $row_count;
						if($get_title_colspan != "$get_count_field_id"){
							$result_upadte = mysqli_query($link, "UPDATE $t_edb_review_matrix_titles SET title_colspan=$get_count_field_id WHERE title_id=$get_title_id");
						}

						echo"
						<span>
						<a href=\"index.php?open=$open&amp;page=$page&amp;action=title_fields&amp;title_id=$get_title_id&amp;l=$l&amp;editor_language=$editor_language\""; if($get_title_id == "$get_current_title_id"){ echo" style=\"font-weight: bold;\""; } echo">$get_title_name</a><br />
						</span>
						";
					} // while
		
					echo"
					   </td>
					  </tr>
					 </tbody>
					</table>
				<!-- //Title index -->

			   </td>
			   <td style=\"vertical-align: top;\">
				<!-- Fields -->

					<table class=\"hor-zebra\">
					 <thead>
					  <tr>
					   <th scope=\"col\">
						<span><b>ID</b></span>
					   </th>
					   <th scope=\"col\">
						<span><b>Name</b></span>
					   </th>
					   <th scope=\"col\">
						<span><b>Type</b></span>
					   </th>
					   <th scope=\"col\">
						<span><b>Size</b></span>
					   </th>
					   <th scope=\"col\">
						<span><b>Alternatives</b></span>
					   </th>
					   <th scope=\"col\">
						<span><b>Actions</b></span>
					   </th>
					  </tr>
					 </thead>

					";
					$human_counter = 1;
					$query = "SELECT field_id, field_name, field_title_id, field_title_name, field_weight, field_type, field_size, field_alt_a, field_alt_b, field_alt_c, field_alt_d, field_alt_e, field_alt_f, field_alt_g, field_alt_h, field_alt_i, field_alt_j, field_alt_k, field_alt_l, field_alt_m FROM $t_edb_review_matrix_fields WHERE field_title_id=$get_current_title_id ORDER BY field_weight ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_field_id, $get_field_name, $get_field_title_id, $get_field_title_name, $get_field_weight, $get_field_type, $get_field_size, $get_field_alt_a, $get_field_alt_b, $get_field_alt_c, $get_field_alt_d, $get_field_alt_e, $get_field_alt_f, $get_field_alt_g, $get_field_alt_h, $get_field_alt_i, $get_field_alt_j, $get_field_alt_k, $get_field_alt_l, $get_field_alt_m) = $row;
			
						// Style
						if(isset($style) && $style == ""){
							$style = "odd";
						}
						else{
							$style = "";
						}

						// Weight
						if($get_field_weight != "$human_counter"){
							// Update weight
							$result_update = mysqli_query($link, "UPDATE $t_edb_review_matrix_fields SET field_weight=$human_counter WHERE field_id=$get_field_id");
						}

						echo"
						 <tr>
						  <td class=\"$style\">
							<span>
							<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit_field&amp;title_id=$get_current_title_id&amp;field_id=$get_field_id&amp;l=$l&amp;editor_language=$editor_language\">$get_field_id</a>
							</span>
						  </td>
						  <td class=\"$style\">
							<span>$get_field_name</span>
						  </td>
						  <td class=\"$style\">
							<span>$get_field_type</span>
						  </td>
						  <td class=\"$style\">
							<span>$get_field_size</span>
						  </td>
						  <td class=\"$style\">
							<span>$get_field_alt_a";
							if($get_field_alt_b != ""){ echo", \n$get_field_alt_b"; }
							if($get_field_alt_c != ""){ echo", \n$get_field_alt_c"; }
							if($get_field_alt_d != ""){ echo", \n$get_field_alt_d"; }
							if($get_field_alt_e != ""){ echo", \n$get_field_alt_e"; }
							if($get_field_alt_f != ""){ echo", \n$get_field_alt_f"; }
							if($get_field_alt_g != ""){ echo", \n$get_field_alt_g"; }
							if($get_field_alt_h != ""){ echo", \n$get_field_alt_h"; }
							if($get_field_alt_i != ""){ echo", \n$get_field_alt_i"; }
							if($get_field_alt_j != ""){ echo", \n$get_field_alt_j"; }
							if($get_field_alt_k != ""){ echo", \n$get_field_alt_k"; }
							if($get_field_alt_l != ""){ echo", \n$get_field_alt_l"; }
							if($get_field_alt_m != ""){ echo", \n$get_field_alt_m"; }
							echo"
						  </td>
						  <td class=\"$style\">
							<span>
							<a href=\"index.php?open=$open&amp;page=$page&amp;action=edit_field&amp;title_id=$get_current_title_id&amp;field_id=$get_field_id&amp;l=$l&amp;editor_language=$editor_language\">Edit</a>
							&middot;
							<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete_field&amp;title_id=$get_current_title_id&amp;field_id=$get_field_id&amp;l=$l&amp;editor_language=$editor_language\">Delete</a>
							</span>
						  </td>
						 </tr>";

						// Counter
						$human_counter++;
					} // while
		
					echo"
					 </tbody>
					</table>
				<!-- //Fields -->
			   </td>
			  </tr>
			 </table>
		<!-- //Title Fields left and right -->

		";
	} // title found
} // title_fields
elseif($action == "new_field"){
	// Find title
	$title_id_mysql = quote_smart($link, $title_id);
	$query = "SELECT title_id, title_name FROM $t_edb_review_matrix_titles WHERE title_id=$title_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_title_id, $get_current_title_name) = $row;
	
	if($get_current_title_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

		if($process == "1"){

			$inp_name = $_POST['inp_name'];
			$inp_name = output_html($inp_name);
			$inp_name_mysql = quote_smart($link, $inp_name);

			$inp_type = $_POST['inp_type'];
			$inp_type = output_html($inp_type);
			$inp_type_mysql = quote_smart($link, $inp_type);

			$inp_size = $_POST['inp_size'];
			$inp_size = output_html($inp_size);
			$inp_size_mysql = quote_smart($link, $inp_size);

			$inp_alt_a = $_POST['inp_alt_a'];
			$inp_alt_a = output_html($inp_alt_a);
			$inp_alt_a_mysql = quote_smart($link, $inp_alt_a);

			$inp_alt_b = $_POST['inp_alt_b'];
			$inp_alt_b = output_html($inp_alt_b);
			$inp_alt_b_mysql = quote_smart($link, $inp_alt_b);

			$inp_alt_c = $_POST['inp_alt_c'];
			$inp_alt_c = output_html($inp_alt_c);
			$inp_alt_c_mysql = quote_smart($link, $inp_alt_c);

			$inp_alt_d = $_POST['inp_alt_d'];
			$inp_alt_d = output_html($inp_alt_d);
			$inp_alt_d_mysql = quote_smart($link, $inp_alt_d);

			$inp_alt_e = $_POST['inp_alt_e'];
			$inp_alt_e = output_html($inp_alt_e);
			$inp_alt_e_mysql = quote_smart($link, $inp_alt_e);

			$inp_alt_f = $_POST['inp_alt_f'];
			$inp_alt_f = output_html($inp_alt_f);
			$inp_alt_f_mysql = quote_smart($link, $inp_alt_f);

			$inp_alt_g = $_POST['inp_alt_g'];
			$inp_alt_g = output_html($inp_alt_g);
			$inp_alt_g_mysql = quote_smart($link, $inp_alt_g);

			$inp_alt_h = $_POST['inp_alt_h'];
			$inp_alt_h = output_html($inp_alt_h);
			$inp_alt_h_mysql = quote_smart($link, $inp_alt_h);

			$inp_alt_i = $_POST['inp_alt_i'];
			$inp_alt_i = output_html($inp_alt_i);
			$inp_alt_i_mysql = quote_smart($link, $inp_alt_i);

			$inp_alt_j = $_POST['inp_alt_j'];
			$inp_alt_j = output_html($inp_alt_j);
			$inp_alt_j_mysql = quote_smart($link, $inp_alt_j);

			$inp_alt_k = $_POST['inp_alt_k'];
			$inp_alt_k = output_html($inp_alt_k);
			$inp_alt_k_mysql = quote_smart($link, $inp_alt_k);

			$inp_alt_l = $_POST['inp_alt_l'];
			$inp_alt_l = output_html($inp_alt_l);
			$inp_alt_l_mysql = quote_smart($link, $inp_alt_l);

			$inp_alt_m = $_POST['inp_alt_m'];
			$inp_alt_m = output_html($inp_alt_m);
			$inp_alt_m_mysql = quote_smart($link, $inp_alt_m);

			// Field title
			$inp_field_title_name_mysql = quote_smart($link, $get_current_title_name);

			mysqli_query($link, "INSERT INTO $t_edb_review_matrix_fields
			(field_id, field_name, field_title_id, field_title_name, field_weight, 
			field_type, field_size, field_alt_a, field_alt_b, field_alt_c, field_alt_d, 
			field_alt_e, field_alt_f, field_alt_g, field_alt_h, field_alt_i, 
			field_alt_j, field_alt_k, field_alt_l, field_alt_m) 
			VALUES 
			(NULL, $inp_name_mysql, $get_current_title_id, $inp_field_title_name_mysql, 999, 
			$inp_type_mysql, $inp_size_mysql, $inp_alt_a_mysql, $inp_alt_b_mysql, $inp_alt_c_mysql, $inp_alt_d_mysql, 
			$inp_alt_e_mysql, $inp_alt_f_mysql, $inp_alt_g_mysql, $inp_alt_h_mysql, $inp_alt_i_mysql, 
			$inp_alt_j_mysql, $inp_alt_k_mysql, $inp_alt_l_mysql, $inp_alt_m_mysql)")
			or die(mysqli_error($link));

			$url = "index.php?open=edb&page=$page&action=$action&title_id=$get_current_title_id&editor_language=$editor_language&l=$l&ft=success&fm=created_field_$inp_name";
			header("Location: $url");
			exit;
		}

		echo"
		<h1>New field to $get_current_title_name</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Review standard</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=title_fields&amp;title_id=$get_current_title_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_title_name</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;title_id=$get_current_title_id&amp;editor_language=$editor_language&amp;l=$l\">New field</a>
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
				\$('[name=\"inp_name\"]').focus();
			});
			</script>
		<!-- //Focus -->

		<!-- New field form -->
			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;title_id=$get_current_title_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p>Field name:<br />
			<input type=\"text\" name=\"inp_name\" value=\"\" size=\"25\" />
			</p>

			<p>Field type:<br />
			<select name=\"inp_type\">
				<option value=\"text\">Text</option>
				<option value=\"select\">Select</option>
				<option value=\"checkbox\">Checkbox</option>
				<option value=\"date\">Date</option>
			</select>
			</p>

			<p>Size (for text):<br />
			<input type=\"text\" name=\"inp_size\" value=\"25\" size=\"25\" />
			</p>

			<p>Alt 1 (for select and checkbox):<br />
			<input type=\"text\" name=\"inp_alt_a\" value=\"\" size=\"25\" />
			</p>

			<p>Alt 2 (for select):<br />
			<input type=\"text\" name=\"inp_alt_b\" value=\"\" size=\"25\" />
			</p>

			<p>Alt 3 (for select):<br />
			<input type=\"text\" name=\"inp_alt_c\" value=\"\" size=\"25\" />
			</p>

			<p>Alt 4 (for select):<br />
			<input type=\"text\" name=\"inp_alt_d\" value=\"\" size=\"25\" />
			</p>

			<p>Alt 5 (for select):<br />
			<input type=\"text\" name=\"inp_alt_e\" value=\"\" size=\"25\" />
			</p>

			<p>Alt 6 (for select):<br />
			<input type=\"text\" name=\"inp_alt_f\" value=\"\" size=\"25\" />
			</p>

			<p>Alt 7 (for select):<br />
			<input type=\"text\" name=\"inp_alt_g\" value=\"\" size=\"25\" />
			</p>

			<p>Alt 8 (for select):<br />
			<input type=\"text\" name=\"inp_alt_h\" value=\"\" size=\"25\" />
			</p>

			<p>Alt 9 (for select):<br />
			<input type=\"text\" name=\"inp_alt_i\" value=\"\" size=\"25\" />
			</p>

			<p>Alt 10 (for select):<br />
			<input type=\"text\" name=\"inp_alt_j\" value=\"\" size=\"25\" />
			</p>

			<p>Alt 11 (for select):<br />
			<input type=\"text\" name=\"inp_alt_k\" value=\"\" size=\"25\" />
			</p>

			<p>Alt 12 (for select):<br />
			<input type=\"text\" name=\"inp_alt_l\" value=\"\" size=\"25\" />
			</p>

			<p>Alt 13 (for select):<br />
			<input type=\"text\" name=\"inp_alt_m\" value=\"\" size=\"25\" />
			</p>

			<p><input type=\"submit\" value=\"Create field\" class=\"btn_default\" />
			</p>
	
			</form>
		<!-- //New field form -->

		";
	} // title found
} // new_field
elseif($action == "edit_field"){
	// Find title
	$title_id_mysql = quote_smart($link, $title_id);
	$query = "SELECT title_id, title_name FROM $t_edb_review_matrix_titles WHERE title_id=$title_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_title_id, $get_current_title_name) = $row;
	
	if($get_current_title_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		// Find field
		$field_id_mysql = quote_smart($link, $field_id);
		$query = "SELECT field_id, field_name, field_title_id, field_title_name, field_weight, field_type, field_size, field_alt_a, field_alt_b, field_alt_c, field_alt_d, field_alt_e, field_alt_f, field_alt_g, field_alt_h, field_alt_i, field_alt_j, field_alt_k, field_alt_l, field_alt_m FROM $t_edb_review_matrix_fields WHERE field_id=$field_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_field_id, $get_current_field_name, $get_current_field_title_id, $get_current_field_title_name, $get_current_field_weight, $get_current_field_type, $get_current_field_size, $get_current_field_alt_a, $get_current_field_alt_b, $get_current_field_alt_c, $get_current_field_alt_d, $get_current_field_alt_e, $get_current_field_alt_f, $get_current_field_alt_g, $get_current_field_alt_h, $get_current_field_alt_i, $get_current_field_alt_j, $get_current_field_alt_k, $get_current_field_alt_l, $get_current_field_alt_m) = $row;
	
		if($get_current_field_id == ""){
			echo"
			<h1>Server error 404</h1>
			";

		}
		else{
			if($process == "1"){

				$inp_name = $_POST['inp_name'];
				$inp_name = output_html($inp_name);
				$inp_name_mysql = quote_smart($link, $inp_name);

				$inp_type = $_POST['inp_type'];
				$inp_type = output_html($inp_type);
				$inp_type_mysql = quote_smart($link, $inp_type);

				$inp_size = $_POST['inp_size'];
				$inp_size = output_html($inp_size);
				$inp_size_mysql = quote_smart($link, $inp_size);

				$inp_alt_a = $_POST['inp_alt_a'];
				$inp_alt_a = output_html($inp_alt_a);
				$inp_alt_a_mysql = quote_smart($link, $inp_alt_a);

				$inp_alt_b = $_POST['inp_alt_b'];
				$inp_alt_b = output_html($inp_alt_b);
				$inp_alt_b_mysql = quote_smart($link, $inp_alt_b);

				$inp_alt_c = $_POST['inp_alt_c'];
				$inp_alt_c = output_html($inp_alt_c);
				$inp_alt_c_mysql = quote_smart($link, $inp_alt_c);

				$inp_alt_d = $_POST['inp_alt_d'];
				$inp_alt_d = output_html($inp_alt_d);
				$inp_alt_d_mysql = quote_smart($link, $inp_alt_d);

				$inp_alt_e = $_POST['inp_alt_e'];
				$inp_alt_e = output_html($inp_alt_e);
				$inp_alt_e_mysql = quote_smart($link, $inp_alt_e);

				$inp_alt_f = $_POST['inp_alt_f'];
				$inp_alt_f = output_html($inp_alt_f);
				$inp_alt_f_mysql = quote_smart($link, $inp_alt_f);

				$inp_alt_g = $_POST['inp_alt_g'];
				$inp_alt_g = output_html($inp_alt_g);
				$inp_alt_g_mysql = quote_smart($link, $inp_alt_g);

				$inp_alt_h = $_POST['inp_alt_h'];
				$inp_alt_h = output_html($inp_alt_h);
				$inp_alt_h_mysql = quote_smart($link, $inp_alt_h);

				$inp_alt_i = $_POST['inp_alt_i'];
				$inp_alt_i = output_html($inp_alt_i);
				$inp_alt_i_mysql = quote_smart($link, $inp_alt_i);

				$inp_alt_j = $_POST['inp_alt_j'];
				$inp_alt_j = output_html($inp_alt_j);
				$inp_alt_j_mysql = quote_smart($link, $inp_alt_j);

				$inp_alt_k = $_POST['inp_alt_k'];
				$inp_alt_k = output_html($inp_alt_k);
				$inp_alt_k_mysql = quote_smart($link, $inp_alt_k);

				$inp_alt_l = $_POST['inp_alt_l'];
				$inp_alt_l = output_html($inp_alt_l);
				$inp_alt_l_mysql = quote_smart($link, $inp_alt_l);

				$inp_alt_m = $_POST['inp_alt_m'];
				$inp_alt_m = output_html($inp_alt_m);
				$inp_alt_m_mysql = quote_smart($link, $inp_alt_m);

				// Field title
				$inp_field_title_name_mysql = quote_smart($link, $get_current_title_name);


				$result = mysqli_query($link, "UPDATE $t_edb_review_matrix_fields SET 
				field_name=$inp_name_mysql, 
				field_title_name=$inp_field_title_name_mysql, 
				field_type=$inp_type_mysql, 
				field_size=$inp_size_mysql,
				field_alt_a=$inp_alt_a_mysql,
				field_alt_b=$inp_alt_b_mysql,
				field_alt_c=$inp_alt_c_mysql,
				field_alt_d=$inp_alt_d_mysql,
				field_alt_e=$inp_alt_e_mysql,
				field_alt_f=$inp_alt_f_mysql,
				field_alt_g=$inp_alt_g_mysql,
				field_alt_h=$inp_alt_h_mysql,
				field_alt_i=$inp_alt_i_mysql,
				field_alt_j=$inp_alt_j_mysql,
				field_alt_k=$inp_alt_k_mysql,
				field_alt_k=$inp_alt_l_mysql,
				field_alt_m=$inp_alt_m_mysql
				WHERE field_id=$get_current_field_id") or die(mysqli_error($link));

				$url = "index.php?open=edb&page=$page&action=$action&title_id=$get_current_title_id&field_id=$get_current_field_id&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
				header("Location: $url");
				exit;
			}

			echo"
			<h1>Edit field $get_current_field_name</h1>


			<!-- Where am I? -->
				<p><b>You are here:</b><br />
				<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
				&gt;
				<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Review standard</a>
				&gt;
				<a href=\"index.php?open=edb&amp;page=$page&amp;action=title_fields&amp;title_id=$get_current_title_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_title_name</a>
				&gt;
				<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;title_id=$get_current_title_id&amp;field_id=$get_current_field_id&amp;editor_language=$editor_language&amp;l=$l\">Edit field $get_current_field_name</a>
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
					\$('[name=\"inp_name\"]').focus();
				});
				</script>
			<!-- //Focus -->

			<!-- Edit field form -->
				<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;title_id=$get_current_title_id&amp;field_id=$get_current_field_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
	
				<p>Field name:<br />
				<input type=\"text\" name=\"inp_name\" value=\"$get_current_field_name\" size=\"25\" />
				</p>

				<p>Field type:<br />
				<select name=\"inp_type\">
					<option value=\"text\""; if($get_current_field_type == "text"){ echo" selected=\"selected\""; } echo">Text</option>
					<option value=\"select\""; if($get_current_field_type == "select"){ echo" selected=\"selected\""; } echo">Select</option>
					<option value=\"checkbox\""; if($get_current_field_type == "checkbox"){ echo" selected=\"selected\""; } echo">Checkbox</option>
					<option value=\"date\""; if($get_current_field_type == "date"){ echo" selected=\"selected\""; } echo">Date</option>
				</select>
				</p>

				<p>Size (for text):<br />
				<input type=\"text\" name=\"inp_size\" value=\"$get_current_field_size\" size=\"25\" />
				</p>

				<p>Alt 1 (for select and checkbox):<br />
				<input type=\"text\" name=\"inp_alt_a\" value=\"$get_current_field_alt_a\" size=\"25\" />
				</p>

				<p>Alt 2 (for select):<br />
				<input type=\"text\" name=\"inp_alt_b\" value=\"$get_current_field_alt_b\" size=\"25\" />
				</p>

				<p>Alt 3 (for select):<br />
				<input type=\"text\" name=\"inp_alt_c\" value=\"$get_current_field_alt_c\" size=\"25\" />
				</p>
	
				<p>Alt 4 (for select):<br />
				<input type=\"text\" name=\"inp_alt_d\" value=\"$get_current_field_alt_d\" size=\"25\" />
				</p>
	
				<p>Alt 5 (for select):<br />
				<input type=\"text\" name=\"inp_alt_e\" value=\"$get_current_field_alt_e\" size=\"25\" />
				</p>

				<p>Alt 6 (for select):<br />
				<input type=\"text\" name=\"inp_alt_f\" value=\"$get_current_field_alt_f\" size=\"25\" />
				</p>

				<p>Alt 7 (for select):<br />
				<input type=\"text\" name=\"inp_alt_g\" value=\"$get_current_field_alt_g\" size=\"25\" />
				</p>

				<p>Alt 8 (for select):<br />
				<input type=\"text\" name=\"inp_alt_h\" value=\"$get_current_field_alt_h\" size=\"25\" />
				</p>

				<p>Alt 9 (for select):<br />
				<input type=\"text\" name=\"inp_alt_i\" value=\"$get_current_field_alt_i\" size=\"25\" />
				</p>

				<p>Alt 10 (for select):<br />
				<input type=\"text\" name=\"inp_alt_j\" value=\"$get_current_field_alt_j\" size=\"25\" />
				</p>

				<p>Alt 11 (for select):<br />
				<input type=\"text\" name=\"inp_alt_k\" value=\"$get_current_field_alt_k\" size=\"25\" />
				</p>

				<p>Alt 12 (for select):<br />
				<input type=\"text\" name=\"inp_alt_l\" value=\"$get_current_field_alt_l\" size=\"25\" />
				</p>

				<p>Alt 13 (for select):<br />
				<input type=\"text\" name=\"inp_alt_m\" value=\"$get_current_field_alt_m\" size=\"25\" />
				</p>
	
				<p><input type=\"submit\" value=\"Create field\" class=\"btn_default\" />
				</p>
	
				</form>
			<!-- //New field form -->

			";
		} // field found
	} // title found
} // edit_field
elseif($action == "delete_field"){
	// Find title
	$title_id_mysql = quote_smart($link, $title_id);
	$query = "SELECT title_id, title_name FROM $t_edb_review_matrix_titles WHERE title_id=$title_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_title_id, $get_current_title_name) = $row;
	
	if($get_current_title_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		// Find field
		$field_id_mysql = quote_smart($link, $field_id);
		$query = "SELECT field_id, field_name, field_title_id, field_title_name, field_weight, field_type, field_size, field_alt_a, field_alt_b, field_alt_c, field_alt_d, field_alt_e, field_alt_f, field_alt_g, field_alt_h, field_alt_i, field_alt_j, field_alt_k, field_alt_l, field_alt_m FROM $t_edb_review_matrix_fields WHERE field_id=$field_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_field_id, $get_current_field_name, $get_current_field_title_id, $get_current_field_title_name, $get_current_field_weight, $get_current_field_type, $get_current_field_size, $get_current_field_alt_a, $get_current_field_alt_b, $get_current_field_alt_c, $get_current_field_alt_d, $get_current_field_alt_e, $get_current_field_alt_f, $get_current_field_alt_g, $get_current_field_alt_h, $get_current_field_alt_i, $get_current_field_alt_j, $get_current_field_alt_k, $get_current_field_alt_l, $get_current_field_alt_m) = $row;
	
		if($get_current_field_id == ""){
			echo"
			<h1>Server error 404</h1>
			";

		}
		else{
			if($process == "1"){

				

				$result = mysqli_query($link, "DELETE FROM $t_edb_review_matrix_fields WHERE field_id=$get_current_field_id") or die(mysqli_error($link));

				$url = "index.php?open=edb&page=$page&action=title_fields&title_id=$get_current_title_id&editor_language=$editor_language&l=$l&ft=success&fm=field_deleted";
				header("Location: $url");
				exit;
			}

			echo"
			<h1>Delete field $get_current_field_name</h1>


			<!-- Where am I? -->
				<p><b>You are here:</b><br />
				<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
				&gt;
				<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Review standard</a>
				&gt;
				<a href=\"index.php?open=edb&amp;page=$page&amp;action=title_fields&amp;title_id=$get_current_title_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_title_name</a>
				&gt;
				<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;title_id=$get_current_title_id&amp;field_id=$get_current_field_id&amp;editor_language=$editor_language&amp;l=$l\">Delete field $get_current_field_name</a>
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


			<!-- Delete field form -->
				<p>
				Are you sure you want to delete the field?
				</p>

				<p>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;title_id=$get_current_title_id&amp;field_id=$get_current_field_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">Delete</a>
				</p>
			<!-- //Delete field form -->

			";
		} // field found
	} // title found
} // delete_field
?>