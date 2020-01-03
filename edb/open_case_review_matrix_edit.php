<?php 
/**
*
* File: edb/open_case_review_matrix_edit.php
* Version 1.0
* Date 16:06 07.10.2019
* Copyright (c) 2019 S. A. Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "2";
$pageNoColumnSav      = "2";
$pageAllowCommentsSav = "1";
$pageAuthorUserIdSav  = "1";

/*- Root dir --------------------------------------------------------------------------------- */
// This determine where we are
if(file_exists("favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
elseif(file_exists("../../../../favicon.ico")){ $root = "../../../.."; }
else{ $root = "../../.."; }

/*- Website config --------------------------------------------------------------------------- */
include("$root/_admin/website_config.php");

/*- Language --------------------------------------------------------------------------- */
include("$root/_admin/_translations/site/$l/edb/ts_edb.php");
include("$root/_admin/_translations/site/$l/edb/ts_open_case_overview.php");


/*- Tables ---------------------------------------------------------------------------- */
// (Should not be used here) $t_edb_review_matrix_titles = $mysqlPrefixSav . "edb_review_matrix_titles";
// (Should not be used here) $t_edb_review_matrix_fields = $mysqlPrefixSav . "edb_review_matrix_fields";

$t_edb_case_index_review_notes			= $mysqlPrefixSav . "edb_case_index_review_notes";
$t_edb_case_index_review_matrix_titles		= $mysqlPrefixSav . "edb_case_index_review_matrix_titles";
$t_edb_case_index_review_matrix_fields		= $mysqlPrefixSav . "edb_case_index_review_matrix_fields";
$t_edb_case_index_review_matrix_values		= $mysqlPrefixSav . "edb_case_index_review_matrix_values";


/*- Variables -------------------------------------------------------------------------- */
$tabindex = 0;
if(isset($_GET['case_id'])) {
	$case_id = $_GET['case_id'];
	$case_id = strip_tags(stripslashes($case_id));
}
else{
	$case_id = "";
}
$case_id_mysql = quote_smart($link, $case_id);

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





/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){

	// Find case 
	$query = "SELECT case_id, case_number, case_title, case_title_clean, case_suspect_in_custody, case_code_id, case_code_title, case_status_id, case_status_title, case_priority_id, case_priority_title, case_district_id, case_district_title, case_station_id, case_station_title, case_is_screened, case_assigned_to_datetime, case_assigned_to_time, case_assigned_to_date_saying, case_assigned_to_date_ddmmyy, case_assigned_to_user_id, case_assigned_to_user_name, case_assigned_to_user_alias, case_assigned_to_user_email, case_assigned_to_user_image_path, case_assigned_to_user_image_file, case_assigned_to_user_image_thumb_40, case_assigned_to_user_image_thumb_50, case_assigned_to_user_first_name, case_assigned_to_user_middle_name, case_assigned_to_user_last_name, case_created_datetime, case_created_time, case_created_date_saying, case_created_date_ddmmyy, case_created_user_id, case_created_user_name, case_created_user_alias, case_created_user_email, case_created_user_image_path, case_created_user_image_file, case_created_user_image_thumb_40, case_created_user_image_thumb_50, case_created_user_first_name, case_created_user_middle_name, case_created_user_last_name, case_detective_user_id, case_detective_user_job_title, case_detective_user_first_name, case_detective_user_middle_name, case_detective_user_last_name, case_detective_user_name, case_detective_user_alias, case_detective_user_email, case_detective_email_alerts, case_detective_user_image_path, case_detective_user_image_file, case_detective_user_image_thumb_40, case_detective_user_image_thumb_50, case_updated_datetime, case_updated_time, case_updated_date_saying, case_updated_date_ddmmyy, case_updated_user_id, case_updated_user_name, case_updated_user_alias, case_updated_user_email, case_updated_user_image_path, case_updated_user_image_file, case_updated_user_image_thumb_40, case_updated_user_image_thumb_50, case_updated_user_first_name, case_updated_user_middle_name, case_updated_user_last_name, case_is_closed, case_closed_datetime, case_closed_time, case_closed_date_saying, case_closed_date_ddmmyy, case_time_from_created_to_close FROM $t_edb_case_index WHERE case_id=$case_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_case_id, $get_current_case_number, $get_current_case_title, $get_current_case_title_clean, $get_current_case_suspect_in_custody, $get_current_case_code_id, $get_current_case_code_title, $get_current_case_status_id, $get_current_case_status_title, $get_current_case_priority_id, $get_current_case_priority_title, $get_current_case_district_id, $get_current_case_district_title, $get_current_case_station_id, $get_current_case_station_title, $get_current_case_is_screened, $get_current_case_assigned_to_datetime, $get_current_case_assigned_to_time, $get_current_case_assigned_to_date_saying, $get_current_case_assigned_to_date_ddmmyy, $get_current_case_assigned_to_user_id, $get_current_case_assigned_to_user_name, $get_current_case_assigned_to_user_alias, $get_current_case_assigned_to_user_email, $get_current_case_assigned_to_user_image_path, $get_current_case_assigned_to_user_image_file, $get_current_case_assigned_to_user_image_thumb_40, $get_current_case_assigned_to_user_image_thumb_50, $get_current_case_assigned_to_user_first_name, $get_current_case_assigned_to_user_middle_name, $get_current_case_assigned_to_user_last_name, $get_current_case_created_datetime, $get_current_case_created_time, $get_current_case_created_date_saying, $get_current_case_created_date_ddmmyy, $get_current_case_created_user_id, $get_current_case_created_user_name, $get_current_case_created_user_alias, $get_current_case_created_user_email, $get_current_case_created_user_image_path, $get_current_case_created_user_image_file, $get_current_case_created_user_image_thumb_40, $get_current_case_created_user_image_thumb_50, $get_current_case_created_user_first_name, $get_current_case_created_user_middle_name, $get_current_case_created_user_last_name, $get_current_case_detective_user_id, $get_current_case_detective_user_job_title, $get_current_case_detective_user_first_name, $get_current_case_detective_user_middle_name, $get_current_case_detective_user_last_name, $get_current_case_detective_user_name, $get_current_case_detective_user_alias, $get_current_case_detective_user_email, $get_current_case_detective_email_alerts, $get_current_case_detective_user_image_path, $get_current_case_detective_user_image_file, $get_current_case_detective_user_image_thumb_40, $get_current_case_detective_user_image_thumb_50, $get_current_case_updated_datetime, $get_current_case_updated_time, $get_current_case_updated_date_saying, $get_current_case_updated_date_ddmmyy, $get_current_case_updated_user_id, $get_current_case_updated_user_name, $get_current_case_updated_user_alias, $get_current_case_updated_user_email, $get_current_case_updated_user_image_path, $get_current_case_updated_user_image_file, $get_current_case_updated_user_image_thumb_40, $get_current_case_updated_user_image_thumb_50, $get_current_case_updated_user_first_name, $get_current_case_updated_user_middle_name, $get_current_case_updated_user_last_name, $get_current_case_is_closed, $get_current_case_closed_datetime, $get_current_case_closed_time, $get_current_case_closed_date_saying, $get_current_case_closed_date_ddmmyy, $get_current_case_time_from_created_to_close) = $row;
	

	if($get_current_case_id == ""){
		echo"<h1>Server error 404</h1><p>Case not found</p>";
		die;
	}
	else{
		/*- Headers ---------------------------------------------------------------------------------- */
		$website_title = "$l_edb - $get_current_case_district_title - $get_current_case_station_title - $get_current_case_number - $l_review_matrix";
		if(file_exists("./favicon.ico")){ $root = "."; }
		elseif(file_exists("../favicon.ico")){ $root = ".."; }
		elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
		elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
		include("$root/_webdesign/header.php");

		// Me
		$my_user_id = $_SESSION['user_id'];
		$my_user_id = output_html($my_user_id);
		$my_user_id_mysql = quote_smart($link, $my_user_id);


		// Check that I am member of this station
		$query = "SELECT station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60, station_member_user_image_thumb_200, station_member_user_position, station_member_user_department, station_member_user_location, station_member_user_about, station_member_added_datetime, station_member_added_date_saying, station_member_added_by_user_id, station_member_added_by_user_name, station_member_added_by_user_alias, station_member_added_by_user_image FROM $t_edb_stations_members WHERE station_member_user_id=$my_user_id_mysql AND station_member_station_id=$get_current_case_station_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_my_station_member_id, $get_my_station_member_station_id, $get_my_station_member_station_title, $get_my_station_member_district_id, $get_my_station_member_district_title, $get_my_station_member_user_id, $get_my_station_member_rank, $get_my_station_member_user_name, $get_my_station_member_user_alias, $get_my_station_member_first_name, $get_my_station_member_middle_name, $get_my_station_member_last_name, $get_my_station_member_user_email, $get_my_station_member_user_image_path, $get_my_station_member_user_image_file, $get_my_station_member_user_image_thumb_40, $get_my_station_member_user_image_thumb_50, $get_my_station_member_user_image_thumb_60, $get_my_station_member_user_image_thumb_200, $get_my_station_member_user_position, $get_my_station_member_user_department, $get_my_station_member_user_location, $get_my_station_member_user_about, $get_my_station_member_added_datetime, $get_my_station_member_added_date_saying, $get_my_station_member_added_by_user_id, $get_my_station_member_added_by_user_name, $get_my_station_member_added_by_user_alias, $get_my_station_member_added_by_user_image) = $row;

		if($get_my_station_member_id == ""){
			echo"
			<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> Please apply for access to this station..</h1>
			<meta http-equiv=\"refresh\" content=\"3;url=districts.php?action=apply_for_membership_to_station&amp;station_id=$get_current_case_station_id&amp;l=$l\">
			";
		} // access to station denied
		else{
			if($process != "1"){
				echo"
				<!-- Headline + Select cases board -->
					<h1>$get_current_case_number</h1>
				<!-- Headline + Select cases board -->

				<!-- Where am I? -->
					<p style=\"padding-top:0;margin-top:0;\"><b>$l_you_are_here:</b><br />
					<a href=\"index.php?l=$l\">$l_edb</a>
					&gt;
					<a href=\"cases_board_1_view_district.php?district_id=$get_current_case_district_id&amp;l=$l\">$get_current_case_district_title</a>
					&gt;
					<a href=\"cases_board_2_view_station.php?district_id=$get_current_case_district_id&amp;station_id=$get_current_case_station_id&amp;l=$l\">$get_current_case_station_title</a>
					&gt;
					<a href=\"open_case_overview.php?case_id=$get_current_case_id&amp;l=$l\">$get_current_case_number</a>
					&gt;
					<a href=\"open_case_review_matrix.php?case_id=$get_current_case_id&amp;l=$l\">$l_review_matrix</a>
					&gt;
					<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;l=$l\">$l_edit_review_matrix</a>
					</p>
					<div style=\"height: 10px;\"></div>
				<!-- //Where am I? -->


				<!-- Case navigation -->
					";
					include("open_case_menu.php");
					echo"
				<!-- //Case navigation -->
				";
			} // process != 1

				
			if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){
				if($action == ""){
				
					echo"
					<h2>$l_edit_review_matrix</h2>
		
					<!-- Feedback -->
						";
						if($ft != ""){
							if($fm == "changes_saved"){
								$fm = "$l_changes_saved";
							}
							else{
								$fm = ucfirst($fm);
								$fm = str_replace("_", " ", $fm);
							}
							echo"<div class=\"$ft\"><span>$fm</span></div>";
						}
						echo"	
					<!-- //Feedback -->

					<!-- About -->
						<p>
						$l_if_you_edit_the_matrix_here_then_it_will_only_apply_for_this_case
						<a href=\"$root/_admin/index.php?open=edb&amp;page=review_standards&amp;editor_language=$l&amp;l=$l\">$l_edit_review_matrix_template_for_new_cases</a>.
						</p>
						<div style=\"height:10px;\"></div>
					<!-- //About -->

					<!-- Navigation -->
						<p>
						<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=new_title&amp;l=$l\" class=\"btn_default\">$l_new_title</a>
						</p>
						<div style=\"height: 10px;\"></div>
					<!-- //Navigation -->

					<!-- Title index -->
						<table class=\"hor-zebra\">
						 <thead>
						  <tr>
						   <th scope=\"col\">
							<span><b>$l_id</b></span>
						   </th>
	 					  <th scope=\"col\">
							<span><b>$l_title</b></span>
						   </th>
						   <th scope=\"col\">
							<span><b>$l_colspan</b></span>
						   </th>
						   <th scope=\"col\">
							<span><b>$l_action</b></span>
						   </th>
						  </tr>
						 </thead>
						";
						$human_counter = 1;
						$query = "SELECT title_id, title_name, title_weight, title_colspan FROM $t_edb_case_index_review_matrix_titles WHERE title_case_id=$get_current_case_id ORDER BY title_id ASC";
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
							$query_count = "SELECT count(field_id) FROM $t_edb_case_index_review_matrix_fields WHERE field_title_id=$get_title_id";
							$result_count = mysqli_query($link, $query_count);
							$row_count = mysqli_fetch_row($result_count);
							list($get_count_field_id) = $row_count;
							if($get_title_colspan != "$get_count_field_id"){
								$result_upadte = mysqli_query($link, "UPDATE $t_edb_case_index_review_matrix_titles SET title_colspan=$get_count_field_id WHERE title_id=$get_title_id") or die(mysqli_error($link));
							}
							
							// Counter
							if($human_counter != "$get_title_weight"){
								$result_upadte = mysqli_query($link, "UPDATE $t_edb_case_index_review_matrix_titles SET title_weight=$human_counter WHERE title_id=$get_title_id");
							}
				
							echo"
							 <tr>
							  <td class=\"$style\">
								<span>
								<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=title_fields&amp;title_id=$get_title_id&amp;l=$l\">$get_title_id</a>
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
								<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=title_fields&amp;title_id=$get_title_id&amp;l=$l\">$l_fields</a>
								&middot;
								<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=edit_title&amp;title_id=$get_title_id&amp;l=$l\">$l_edit</a>
								&middot;
								<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=delete_title&amp;title_id=$get_title_id&amp;l=$l\">$l_delete</a>
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


						mysqli_query($link, "INSERT INTO $t_edb_case_index_review_matrix_titles
						(title_id, title_case_id, title_name, title_colspan,
						title_headcell_text_color, title_headcell_bg_color, title_headcell_border_color_edge, title_headcell_border_color_center, 
						title_bodycell_text_color, title_bodycell_bg_color, title_bodycell_border_color_edge, title_bodycell_border_color_center, 
						title_subcell_text_color, title_subcell_bg_color, title_subcell_border_color_edge, title_subcell_border_color_center) 
						VALUES 
						(NULL, $get_current_case_id, $inp_name_mysql, 1, 
						$inp_headcell_text_color_mysql, $inp_headcell_bg_color_mysql, $inp_headcell_border_color_edge_mysql, $inp_headcell_border_color_center_mysql, 
						$inp_bodycell_text_color_mysql, $inp_bodycell_bg_color_mysql, $inp_bodycell_border_color_edge_mysql, $inp_bodycell_border_color_center_mysql, 
						$inp_subcell_text_color_mysql, $inp_subcell_bg_color_mysql, $inp_subcell_border_color_edge_mysql, $inp_subcell_border_color_center_mysql)")
						or die(mysqli_error($link));

						$url = "open_case_review_matrix_edit.php?case_id=$get_current_case_id&action=$action&l=$l&ft=success&fm=saved_$inp_name";
						header("Location: $url");
						exit;
					}
					echo"
					<h1>New</h1>
				

					<!-- Where am I? -->
						<p><b>$l_you_are_here:</b><br />
						<a href=\"open_case_review_matrix.php?case_id=$get_current_case_id&amp;l=$l\">$l_review_matrix</a>
						&gt;
						<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;l=$l\">$l_edit_review_matrix</a>
						&gt;
						<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=$action&amp;l=$l\">$l_new_title</a>
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
						<form method=\"post\" action=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=$action&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

						<p>$l_name:<br />
						<input type=\"text\" name=\"inp_name\" value=\"\" size=\"25\" />
						</p>
				
						<!-- Color picker -->
							<div style=\"height: 10px;\"></div>
							<table>
							 <tr>
							  <td style=\"background: #a6a6a6;\">
								<a href=\"#\" style=\"color:#a6a6a6;\" id=\"color_grey\">#a6a6a6</a>
							  </td>
							 </tr>
							</table>

							<!-- Grey -->
								<script>
								\$(\"#color_grey\").click(function(event) { 
									\$('#inp_headcell_text_color').val(\"#000000\"); 
									\$('#inp_headcell_bg_color').val(\"#a6a6a6\"); 
									\$('#inp_headcell_border_color_edge').val(\"#000000\"); 
									\$('#inp_headcell_border_color_center').val(\"#a3a3a3\");

									\$('#inp_bodycell_text_color').val(\"#000000\"); 
									\$('#inp_bodycell_bg_color').val(\"#d9d9d9\"); 
									\$('#inp_bodycell_border_color_edge').val(\"#000000\"); 
									\$('#inp_bodycell_border_color_center').val(\"#a3a3a3\"); 

									\$('#inp_subcell_text_color').val(\"#000000\"); 
									\$('#inp_subcell_bg_color').val(\"#f2f2f2\"); 
									\$('#inp_subcell_border_color_edge').val(\"#000000\"); 
									\$('#inp_subcell_border_color_center').val(\"#a3a3a3\"); 

								}); 


								</script>
							<!-- //Grey -->
						<!-- Color picker -->

						<hr />
						<p>Headcell $l_text_color_lowercase:<br />
						<input type=\"text\" name=\"inp_headcell_text_color\" id=\"inp_headcell_text_color\" value=\"\" size=\"25\" />
						</p>

						<p>Headcell $l_bg_color_lowercase:<br />
						<input type=\"text\" name=\"inp_headcell_bg_color\" id=\"inp_headcell_bg_color\" value=\"\" size=\"25\" />
						</p>

						<p>Headcell $l_border_color_edge_lowercase:<br />
						<input type=\"text\" name=\"inp_headcell_border_color_edge\" id=\"inp_headcell_border_color_edge\" value=\"\" size=\"25\" />
						</p>


						<p>Headcell $l_border_color_center_lowercase:<br />
						<input type=\"text\" name=\"inp_headcell_border_color_center\" id=\"inp_headcell_border_color_center\" value=\"\" size=\"25\" />
						</p>


						<hr />
						<p>Bodycell $l_text_color_lowercase:<br />
						<input type=\"text\" name=\"inp_bodycell_text_color\" id=\"inp_bodycell_text_color\" value=\"\" size=\"25\" />
						</p>

						<p>Bodycell $l_bg_color_lowercase:<br />
						<input type=\"text\" name=\"inp_bodycell_bg_color\" id=\"inp_bodycell_bg_color\" value=\"\" size=\"25\" />
						</p>

						<p>Bodycell $l_border_color_edge_lowercase:<br />
						<input type=\"text\" name=\"inp_bodycell_border_color_edge\" id=\"inp_bodycell_border_color_edge\" value=\"\" size=\"25\" />
						</p>

						<p>Bodycell $l_border_color_center_lowercase:<br />
						<input type=\"text\" name=\"inp_bodycell_border_color_center\" id=\"inp_bodycell_border_color_center\" value=\"\" size=\"25\" />
						</p>



						<hr />
						<p>Subcell $l_text_color_lowercase:<br />
						<input type=\"text\" name=\"inp_subcell_text_color\" id=\"inp_subcell_text_color\" value=\"\" size=\"25\" />
						</p>

						<p>Subcell $l_bg_color_lowercase:<br />
						<input type=\"text\" name=\"inp_subcell_bg_color\" id=\"inp_subcell_bg_color\" value=\"\" size=\"25\" />
						</p>

						<p>Subcell $l_border_color_edge_lowercase:<br />
						<input type=\"text\" name=\"inp_subcell_border_color_edge\" id=\"inp_subcell_border_color_edge\" value=\"\" size=\"25\" />
						</p>

						<p>Subcell $l_border_color_center_lowercase:<br />
						<input type=\"text\" name=\"inp_subcell_border_color_center\" id=\"inp_subcell_border_color_center\" value=\"\" size=\"25\" />
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
					$query = "SELECT title_id, title_case_id, title_name, title_weight, title_colspan, title_headcell_text_color, title_headcell_bg_color, title_headcell_border_color_edge, title_headcell_border_color_center, title_bodycell_text_color, title_bodycell_bg_color, title_bodycell_border_color_edge, title_bodycell_border_color_center, title_subcell_text_color, title_subcell_bg_color, title_subcell_border_color_edge, title_subcell_border_color_center FROM $t_edb_case_index_review_matrix_titles WHERE title_id=$title_id_mysql AND title_case_id=$get_current_case_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_current_title_id, $get_title_case_id, $get_current_title_name, $get_current_title_weight, $get_current_title_colspan, $get_current_title_headcell_text_color, $get_current_title_headcell_bg_color, $get_current_title_headcell_border_color_edge, $get_current_title_headcell_border_color_center, $get_current_title_bodycell_text_color, $get_current_title_bodycell_bg_color, $get_current_title_bodycell_border_color_edge, $get_current_title_bodycell_border_color_center, $get_current_title_subcell_text_color, $get_current_title_subcell_bg_color, $get_current_title_subcell_border_color_edge, $get_current_title_subcell_border_color_center) = $row;
	
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


							$result = mysqli_query($link, "UPDATE $t_edb_case_index_review_matrix_titles SET 
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

	
							$url = "open_case_review_matrix_edit.php?case_id=$get_current_case_id&action=$action&title_id=$get_current_title_id&l=$l&ft=success&fm=changes_saved";
							header("Location: $url");
							exit;
						}
						echo"
						<h1>Edit title $get_current_title_name</h1>


						<!-- Where am I? -->
							<p><b>You are here:</b><br />
							<a href=\"open_case_review_matrix.php?case_id=$get_current_case_id&amp;l=$l\">$l_review_matrix</a>
							&gt;
							<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;l=$l\">$l_edit_review_matrix</a>
							&gt;
							<a href=\"open_case_review_matrix.php?case_id=$get_current_case_id&amp;action=$action&amp;title_id=$get_current_title_id&amp;l=$l\">Edit title $get_current_title_name</a>
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
							<form method=\"post\" action=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=$action&amp;title_id=$get_current_title_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

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
					$query = "SELECT title_id, title_name FROM $t_edb_case_index_review_matrix_titles WHERE title_id=$title_id_mysql AND title_case_id=$get_current_case_id";
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
	
			
							$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_review_matrix_titles WHERE title_id=$get_current_title_id AND title_case_id=$get_current_case_id");
							$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_review_matrix_fields WHERE field_case_id=$get_current_case_id AND field_title_id=$get_current_title_id");
							// $result = mysqli_query($link, "DELETE FROM $t_edb_case_index_review_matrix_values WHERE value_case_id=$get_current_case_id AND value_title_id=$get_current_title_id");

							$url = "open_case_review_matrix_edit.php?case_id=$get_current_case_id&l=$l&ft=success&fm=title_deleted";
							header("Location: $url");
							exit;
						}
						echo"
						<h1>Delete title $get_current_title_name</h1>


						<!-- Where am I? -->
							<p><b>You are here:</b><br />
							<a href=\"open_case_review_matrix.php?case_id=$get_current_case_id&amp;l=$l\">$l_review_matrix</a>
							&gt;
							<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;l=$l\">$l_edit_review_matrix</a>
							&gt;
							<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=$action&amp;title_id=$get_current_title_id&amp;l=$l\">Delete title $get_current_title_name</a>
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
							<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=$action&amp;title_id=$get_current_title_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">Confirm</a>
							</p>
						<!-- //Delete  title form -->

						";
					} // title found
				} // delete_title
				elseif($action == "title_fields"){
					// Find title
					$title_id_mysql = quote_smart($link, $title_id);
					$query = "SELECT title_id, title_name FROM $t_edb_case_index_review_matrix_titles WHERE title_id=$title_id_mysql AND title_case_id=$get_current_case_id";
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
							<a href=\"open_case_review_matrix.php?case_id=$get_current_case_id&amp;l=$l\">$l_review_matrix</a>
							&gt;
							<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;l=$l\">$l_edit_review_matrix</a>
							&gt;
							<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=$action&amp;title_id=$get_current_title_id&amp;l=$l\">$get_current_title_name</a>
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
							<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=new_field&amp;title_id=$get_current_title_id&amp;l=$l\" class=\"btn_default\">New field</a>
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
									$query = "SELECT title_id, title_name, title_colspan FROM $t_edb_case_index_review_matrix_titles WHERE title_case_id=$get_current_case_id ORDER BY title_id ASC";
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
										$query_count = "SELECT count(field_id) FROM $t_edb_case_index_review_matrix_fields WHERE field_case_id=$get_current_case_id AND field_title_id=$get_title_id";
										$result_count = mysqli_query($link, $query_count);
										$row_count = mysqli_fetch_row($result_count);
										list($get_count_field_id) = $row_count;
										if($get_title_colspan != "$get_count_field_id"){
											$result_upadte = mysqli_query($link, "UPDATE $t_edb_case_index_review_matrix_titles SET title_colspan=$get_count_field_id WHERE title_id=$get_title_id");
										}

										echo"
										<span>
										<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=title_fields&amp;title_id=$get_title_id&amp;l=$l\""; if($get_title_id == "$get_current_title_id"){ echo" style=\"font-weight: bold;\""; } echo">$get_title_name</a><br />
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
									$query = "SELECT field_id, field_name, field_title_id, field_title_name, field_weight, field_type, field_size, field_alt_a, field_alt_b, field_alt_c, field_alt_d, field_alt_e, field_alt_f, field_alt_g, field_alt_h, field_alt_i, field_alt_j, field_alt_k, field_alt_l, field_alt_m FROM $t_edb_case_index_review_matrix_fields WHERE field_case_id=$get_current_case_id AND field_title_id=$get_current_title_id ORDER BY field_weight ASC";
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
											$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_review_matrix_fields SET field_weight=$human_counter WHERE field_case_id=$get_current_case_id AND field_id=$get_field_id");
										}

										echo"
										 <tr>
										  <td class=\"$style\">
											<span>
											<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=edit_field&amp;title_id=$get_current_title_id&amp;field_id=$get_field_id&amp;l=$l\">$get_field_id</a>
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
											<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=edit_field&amp;title_id=$get_current_title_id&amp;field_id=$get_field_id&amp;l=$l\">Edit</a>
											&middot;
											<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=delete_field&amp;title_id=$get_current_title_id&amp;field_id=$get_field_id&amp;l=$l\">Delete</a>
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
					$query = "SELECT title_id, title_name FROM $t_edb_case_index_review_matrix_titles WHERE title_id=$title_id_mysql AND title_case_id=$get_current_case_id";
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

							mysqli_query($link, "INSERT INTO $t_edb_case_index_review_matrix_fields
							(field_id, field_case_id, field_name, field_title_id, field_title_name, field_weight, 
							field_type, field_size, field_alt_a, field_alt_b, field_alt_c, field_alt_d, 
							field_alt_e, field_alt_f, field_alt_g, field_alt_h, field_alt_i, 
							field_alt_j, field_alt_k, field_alt_l, field_alt_m) 
							VALUES 
							(NULL, $get_current_case_id, $inp_name_mysql, $get_current_title_id, $inp_field_title_name_mysql, 999, 
							$inp_type_mysql, $inp_size_mysql, $inp_alt_a_mysql, $inp_alt_b_mysql, $inp_alt_c_mysql, $inp_alt_d_mysql, 
							$inp_alt_e_mysql, $inp_alt_f_mysql, $inp_alt_g_mysql, $inp_alt_h_mysql, $inp_alt_i_mysql, 
							$inp_alt_j_mysql, $inp_alt_k_mysql, $inp_alt_l_mysql, $inp_alt_m_mysql)")
							or die(mysqli_error($link));

							// Recalculate Cellspan width
							$query_count = "SELECT count(field_id) FROM $t_edb_case_index_review_matrix_fields WHERE field_title_id=$get_current_title_id";
							$result_count = mysqli_query($link, $query_count);
							$row_count = mysqli_fetch_row($result_count);
							list($get_count_field_id) = $row_count;
							if($get_current_title_colspan != "$get_count_field_id"){
								$result_upadte = mysqli_query($link, "UPDATE $t_edb_case_index_review_matrix_titles SET title_colspan=$get_count_field_id WHERE title_id=$get_current_title_id") or die(mysqli_error($link));
							}

							$url = "open_case_review_matrix_edit.php?case_id=$get_current_case_id&action=$action&title_id=$get_current_title_id&l=$l&ft=success&fm=created_field_$inp_name";
							header("Location: $url");
							exit;
						}

						echo"
						<h1>New field to $get_current_title_name</h1>


						<!-- Where am I? -->
							<p><b>You are here:</b><br />
							<a href=\"open_case_review_matrix.php?case_id=$get_current_case_id&amp;l=$l\">$l_review_matrix</a>
							&gt;
							<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;l=$l\">$l_edit_review_matrix</a>
							&gt;
							<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=title_fields&amp;title_id=$get_current_title_id&amp;l=$l\">$get_current_title_name</a>
							&gt;
							<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=$action&amp;title_id=$get_current_title_id&amp;l=$l\">New field</a>
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
							<form method=\"post\" action=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=$action&amp;title_id=$get_current_title_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

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
					$query = "SELECT title_id, title_name FROM $t_edb_case_index_review_matrix_titles WHERE title_id=$title_id_mysql AND title_case_id=$get_current_case_id";
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
						$query = "SELECT field_id, field_name, field_title_id, field_title_name, field_weight, field_type, field_size, field_alt_a, field_alt_b, field_alt_c, field_alt_d, field_alt_e, field_alt_f, field_alt_g, field_alt_h, field_alt_i, field_alt_j, field_alt_k, field_alt_l, field_alt_m FROM $t_edb_case_index_review_matrix_fields WHERE field_case_id=$get_current_case_id AND field_id=$field_id_mysql";
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


								$result = mysqli_query($link, "UPDATE $t_edb_case_index_review_matrix_fields SET 
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

								$url = "open_case_review_matrix_edit.php?case_id=$get_current_case_id&action=$action&title_id=$get_current_title_id&field_id=$get_current_field_id&l=$l&ft=success&fm=changes_saved";
								header("Location: $url");
								exit;
							}

							echo"
							<h1>Edit field $get_current_field_name</h1>


							<!-- Where am I? -->
								<p><b>You are here:</b><br />
								<a href=\"open_case_review_matrix.php?case_id=$get_current_case_id&amp;l=$l\">$l_review_matrix</a>
								&gt;
								<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;l=$l\">$l_edit_review_matrix</a>
								&gt;
								<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=title_fields&amp;title_id=$get_current_title_id&amp;l=$l\">$get_current_title_name</a>
								&gt;
								<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=$action&amp;title_id=$get_current_title_id&amp;field_id=$get_current_field_id&amp;l=$l\">Edit field $get_current_field_name</a>
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
								<form method=\"post\" action=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=$action&amp;title_id=$get_current_title_id&amp;field_id=$get_current_field_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
	
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
					$query = "SELECT title_id, title_name FROM $t_edb_case_index_review_matrix_titles WHERE title_id=$title_id_mysql AND title_case_id=$get_current_case_id";
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
						$query = "SELECT field_id, field_name, field_title_id, field_title_name, field_weight, field_type, field_size, field_alt_a, field_alt_b, field_alt_c, field_alt_d, field_alt_e, field_alt_f, field_alt_g, field_alt_h, field_alt_i, field_alt_j, field_alt_k, field_alt_l, field_alt_m FROM $t_edb_case_index_review_matrix_fields WHERE field_case_id=$get_current_case_id AND field_id=$field_id_mysql";
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

				

								$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_review_matrix_fields WHERE field_id=$get_current_field_id AND field_case_id=$get_current_case_id") or die(mysqli_error($link));
								// $result = mysqli_query($link, "DELETE FROM $t_edb_case_index_review_matrix_values WHERE value_case_id=$get_current_case_id AND =$get_current_field_id AND field_case_id=") or die(mysqli_error($link));


								// Recalculate Cellspan width
								$query_count = "SELECT count(field_id) FROM $t_edb_case_index_review_matrix_fields WHERE field_title_id=$get_current_title_id";
								$result_count = mysqli_query($link, $query_count);
								$row_count = mysqli_fetch_row($result_count);
								list($get_count_field_id) = $row_count;
								if($get_current_title_colspan != "$get_count_field_id"){
									$result_upadte = mysqli_query($link, "UPDATE $t_edb_case_index_review_matrix_titles SET title_colspan=$get_count_field_id WHERE title_id=$get_current_title_id") or die(mysqli_error($link));
								}


								$url = "open_case_review_matrix_edit.php?case_id=$get_current_case_id&action=title_fields&title_id=$get_current_title_id&editor_language=$editor_language&l=$l&ft=success&fm=field_deleted";
								header("Location: $url");
								exit;
							}

							echo"
							<h1>Delete field $get_current_field_name</h1>


							<!-- Where am I? -->
								<p><b>You are here:</b><br />
								<a href=\"open_case_review_matrix.php?case_id=$get_current_case_id&amp;l=$l\">$l_review_matrix</a>
								&gt;
								<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;l=$l\">$l_edit_review_matrix</a>
								&gt;
								<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=title_fields&amp;title_id=$get_current_title_id&amp;l=$l\">$get_current_title_name</a>
								&gt;
								<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=$action&amp;title_id=$get_current_title_id&amp;field_id=$get_current_field_id&amp;l=$l\">Delete field $get_current_field_name</a>
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
								<a href=\"open_case_review_matrix_edit.php?case_id=$get_current_case_id&amp;action=$action&amp;title_id=$get_current_title_id&amp;field_id=$get_current_field_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">Delete</a>
								</p>
							<!-- //Delete field form -->

							";
						} // field found
					} // title found
				} // delete_field
			} // access 
			else{
				echo"<p>$l_access_denied</p>";
			} // is not admin, moderator, editor, editor_limited
		} // access to station
	} // case found

} // logged in
else{
	// Log in
	echo"
	<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> $l_please_log_in...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/edb\">
	";
} // not logged in
/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/$webdesignSav/footer.php");
?>