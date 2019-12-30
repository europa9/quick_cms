<?php 
/**
*
* File: edb/open_case_review_matrix.php
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
$t_edb_review_matrix_titles = $mysqlPrefixSav . "edb_review_matrix_titles";
$t_edb_review_matrix_fields = $mysqlPrefixSav . "edb_review_matrix_fields";

$t_edb_case_index_review_notes			= $mysqlPrefixSav . "edb_case_index_review_notes";
$t_edb_case_index_review_matrix_titles		= $mysqlPrefixSav . "edb_case_index_review_matrix_titles";
$t_edb_case_index_review_matrix_fields		= $mysqlPrefixSav . "edb_case_index_review_matrix_fields";
$t_edb_case_index_review_matrix_values		= $mysqlPrefixSav . "edb_case_index_review_matrix_values";
$t_edb_case_index_review_matrix_items		= $mysqlPrefixSav . "edb_case_index_review_matrix_items";


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
			// Check that all evidence exits
			$need_parent_check = 0;
			$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_parent_item_id, item_title FROM $t_edb_case_index_evidence_items WHERE item_case_id=$get_current_case_id ORDER BY item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_item_id, $get_item_case_id, $get_item_record_id, $get_item_record_seized_year, $get_item_record_seized_journal, $get_item_record_seized_district_number, $get_item_numeric_serial_number, $get_item_parent_item_id, $get_item_title) = $row;
				if($get_item_parent_item_id == ""){
					$get_item_parent_item_id = "0";
				}
				// Check that it exists
				$query_matrix = "SELECT matrix_item_id, matrix_item_title, matrix_item_parent_item_id, matrix_item_parent_matrix_item_id FROM $t_edb_case_index_review_matrix_items WHERE matrix_item_item_id=$get_item_id";
				$result_matrix = mysqli_query($link, $query_matrix);
				$row_matrix = mysqli_fetch_row($result_matrix);
				list($get_matrix_item_id, $get_matrix_item_title, $get_matrix_item_parent_item_id, $get_matrix_item_parent_matrix_item_id) = $row_matrix;
				/*
				echo"
				<p>$get_item_record_seized_year, $get_item_record_seized_journal, $get_item_record_seized_district_number, $get_item_numeric_serial_number, $get_item_parent_item_id, $get_item_title<br />
				$query_matrix. Matrix ID= $get_matrix_item_id</p>";
				*/

				if($get_matrix_item_id == ""){
				
					// Insert it
					$inp_title_mysql = quote_smart($link, $get_item_title);
					mysqli_query($link, "INSERT INTO $t_edb_case_index_review_matrix_items 
					(matrix_item_id, matrix_item_case_id, matrix_item_item_id, matrix_item_record_id, matrix_item_record_seized_year, matrix_item_record_seized_journal, matrix_item_record_seized_district_number, matrix_item_numeric_serial_number, matrix_item_title, matrix_item_parent_item_id, matrix_item_parent_matrix_item_id) 
					VALUES 
					(NULL, $get_item_case_id, $get_item_id, $get_item_record_id, $get_item_record_seized_year, $get_item_record_seized_journal, $get_item_record_seized_district_number, $get_item_numeric_serial_number, $inp_title_mysql, $get_item_parent_item_id, 0)")
					or die(mysqli_error($link)); 

					if($get_item_parent_item_id != "0"){	
						$need_parent_check = 1;
					} // parent is not 0
				} // create matrix item id
			} // loop trough items
			if($need_parent_check == "1"){
				// Loop trough all and fix parents
				
				$query = "SELECT matrix_item_id, matrix_item_case_id, matrix_item_item_id, matrix_item_record_id, matrix_item_record_seized_year, matrix_item_record_seized_journal, matrix_item_record_seized_district_number, matrix_item_numeric_serial_number, matrix_item_title, matrix_item_parent_item_id, matrix_item_parent_matrix_item_id FROM $t_edb_case_index_review_matrix_items WHERE matrix_item_case_id=$get_item_case_id";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_matrix_item_id, $get_matrix_item_case_id, $get_matrix_item_item_id, $get_matrix_item_record_id, $get_matrix_item_record_seized_year, $get_matrix_item_record_seized_journal, $get_matrix_item_record_seized_district_number, $get_matrix_item_numeric_serial_number, $get_matrix_item_title, $get_matrix_item_parent_item_id, $get_matrix_item_parent_matrix_item_id) = $row;

					if($get_matrix_item_parent_item_id != "0"){
						// Find parent ID
						$query_new = "SELECT matrix_item_id, matrix_item_case_id, matrix_item_item_id, matrix_item_record_id, matrix_item_record_seized_year, matrix_item_record_seized_journal, matrix_item_record_seized_district_number, matrix_item_numeric_serial_number, matrix_item_title, matrix_item_parent_item_id, matrix_item_parent_matrix_item_id FROM $t_edb_case_index_review_matrix_items WHERE matrix_item_case_id=$get_item_case_id AND matrix_item_item_id=$get_matrix_item_parent_item_id";
						$result_new = mysqli_query($link, $query_new);
						$row_new = mysqli_fetch_row($result_new);
						list($get_parent_matrix_item_id, $get_parent_matrix_item_case_id, $get_parent_matrix_item_item_id, $get_parent_matrix_item_record_id, $get_parent_matrix_item_record_seized_year, $get_parent_matrix_item_record_seized_journal, $get_parent_matrix_item_record_seized_district_number, $get_parent_matrix_item_numeric_serial_number, $get_parent_matrix_item_title, $get_parent_matrix_item_parent_item_id, $get_parent_matrix_item_parent_matrix_item_id) = $row_new;

						// Update 
						$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_review_matrix_items SET matrix_item_parent_matrix_item_id=$get_parent_matrix_item_id WHERE matrix_item_id=$get_matrix_item_id") or die(mysqli_error($link));
					}
				}
							
				
			}

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
					<a href=\"open_case_review_notes.php?case_id=$get_current_case_id&amp;l=$l\">$l_review_matrix</a>
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

			if($action == ""){
				if($process == "1"){
					
					// Evidence items
					$focus = "";

					// Body
					$query = "SELECT matrix_item_id, matrix_item_case_id, matrix_item_item_id, matrix_item_record_id, matrix_item_record_seized_year, matrix_item_record_seized_journal, matrix_item_record_seized_district_number, matrix_item_numeric_serial_number, matrix_item_title FROM $t_edb_case_index_review_matrix_items WHERE matrix_item_case_id=$get_current_case_id ORDER BY matrix_item_record_seized_year, matrix_item_record_seized_journal, matrix_item_record_seized_district_number, matrix_item_numeric_serial_number ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_matrix_item_id, $get_matrix_item_case_id, $get_matrix_item_item_id, $get_matrix_item_record_id, $get_matrix_item_record_seized_year, $get_matrix_item_record_seized_journal, $get_matrix_item_record_seized_district_number, $get_matrix_item_numeric_serial_number, $get_matrix_item_title) = $row;
				




						$query_fields = "SELECT field_id, field_case_id, field_name, field_title_id, field_title_name, field_weight, field_type, field_size, field_alt_a, field_alt_b, field_alt_c, field_alt_d, field_alt_e, field_alt_f, field_alt_g, field_alt_h, field_alt_i, field_alt_j, field_alt_k, field_alt_l, field_alt_m FROM $t_edb_case_index_review_matrix_fields WHERE field_case_id=$get_current_case_id ORDER BY field_title_id, field_weight ASC";
						$result_fields = mysqli_query($link, $query_fields);
						while($row_fields = mysqli_fetch_row($result_fields)) {
							list($get_field_id, $get_field_case_id, $get_field_name, $get_field_title_id, $get_field_title_name, $get_field_weight, $get_field_type, $get_field_size, $get_field_alt_a, $get_field_alt_b, $get_field_alt_c, $get_field_alt_d, $get_field_alt_e, $get_field_alt_f, $get_field_alt_g, $get_field_alt_h, $get_field_alt_i, $get_field_alt_j, $get_field_alt_k, $get_field_alt_l, $get_field_alt_m) = $row_fields;

							
							if(isset($_POST["inp_text_$get_matrix_item_id" . "_$get_field_id"])){
								$inp_text = $_POST["inp_text_$get_matrix_item_id" . "_$get_field_id"];
							}
							else{
								$inp_text = "";
							}
							$inp_text = output_html($inp_text);
							$inp_text_mysql = quote_smart($link, $inp_text);

							// Check if exists, if not then create it
							$query_value = "SELECT value_id, value_case_id, value_text, value_item_id, value_title_id, value_field_id FROM $t_edb_case_index_review_matrix_values WHERE value_case_id=$get_current_case_id AND value_item_id=$get_matrix_item_id AND value_title_id=$get_field_title_id AND value_field_id=$get_field_id";
							$result_value = mysqli_query($link, $query_value);
							$row_value = mysqli_fetch_row($result_value);
							list($get_value_id, $get_value_case_id, $get_value_text, $get_value_item_id, $get_value_title_id, $get_value_field_id) = $row_value;
							if($get_value_id == ""){
								mysqli_query($link, "INSERT INTO $t_edb_case_index_review_matrix_values 
								(value_id, value_case_id, value_text, value_item_id, value_title_id, value_field_id) 
								VALUES 
								(NULL, $get_current_case_id, $inp_text_mysql, $get_matrix_item_id, $get_field_title_id, $get_field_id)")
								or die(mysqli_error($link)); 
							}
							else{
								$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_review_matrix_values SET value_text=$inp_text_mysql WHERE value_id=$get_value_id") or die(mysqli_error($link));
							}


							// Focus?
							if($inp_text != "$get_value_text"){
								$focus = "inp_text_$get_matrix_item_id" . "_$get_field_id";
							}
						} // fields
					} // Evidence items

					$time = date("H:i:s");
					$url = "open_case_review_matrix.php?case_id=$get_current_case_id&l=$l&ft=success&fm=changes_save_$time&focus=$focus";
					//echo"changes_save_$time";
					header("Location: $url");
					exit;
				} // process == 1

				
					


				echo"
				<h2>$l_review_matrix</h2>
		
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
					<div id=\"feedback_message\"></div>
				<!-- //Feedback -->

				<!-- Actions -->
					<p>
					<a href=\"open_case_review_matrix_edit_matrix_items.php?case_id=$case_id&amp;l=$l\" class=\"btn_default\">$l_edit_matrix_items</a>
					<a href=\"open_case_review_matrix_edit.php?case_id=$case_id&amp;l=$l\" class=\"btn_default\">$l_edit_matrix</a>
					</p>
					<div style=\"height:10px;\"></div>
				<!-- //Actions -->

				<!-- Review Matrix -->
					";

					// Jquery 
					$jquery_variables = "";
					$jquery_data      = "";

					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){
						echo"
						<form method=\"POST\" action=\"open_case_review_matrix.php?case_id=$get_current_case_id&amp;l=$l&amp;process=1\" id=\"matrix_form\" enctype=\"multipart/form-data\">
						<input type=\"hidden\" name=\"case_id\" value=\"$get_current_case_id\" /> ";

						if(isset($_GET['focus'])){
							$focus = $_GET['focus'];
							$focus = output_html($focus);
							echo"

							<script>
							\$(document).ready(function(){
								\$('[name=\"$focus\"]').focus();
								});
							</script>
							";
						}
					}
					echo"
					
					<table class=\"hor-zebra\">
					 <thead>
					  <tr>
					   <th>
						
					   </th>";
					$query = "SELECT title_id, title_case_id, title_name, title_weight, title_colspan, title_headcell_text_color, title_headcell_bg_color, title_headcell_border_color_edge, title_headcell_border_color_center, title_bodycell_text_color, title_bodycell_bg_color, title_bodycell_border_color_edge, title_bodycell_border_color_center, title_subcell_text_color, title_subcell_bg_color, title_subcell_border_color_edge, title_subcell_border_color_center FROM $t_edb_case_index_review_matrix_titles WHERE title_case_id=$get_current_case_id ORDER BY title_weight ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_title_id, $get_title_case_id, $get_title_name, $get_title_weight, $get_title_colspan, $get_title_headcell_text_color, $get_title_headcell_bg_color, $get_title_headcell_border_color_edge, $get_title_headcell_border_color_center, $get_title_bodycell_text_color, $get_title_bodycell_bg_color, $get_title_bodycell_border_color_edge, $get_title_bodycell_border_color_center, $get_title_subcell_text_color, $get_title_subcell_bg_color, $get_title_subcell_border_color_edge, $get_title_subcell_border_color_center) = $row;
						echo"
						   <th style=\"background: $get_title_headcell_bg_color;border: $get_title_headcell_border_color_edge 1px solid;text-align:center;\""; if($get_title_colspan != "1"){ echo" colspan=\"$get_title_colspan\""; } echo">
							<span style=\"color: $get_title_headcell_text_color;\">$get_title_name</span>
						   </th>
						";
					}
					echo"
					  </tr>
					  <tr>
					   <th>
						
					   </th>";

					// Titles
					$query_titles = "SELECT title_id, title_case_id, title_name, title_weight, title_colspan, title_headcell_text_color, title_headcell_bg_color, title_headcell_border_color_edge, title_headcell_border_color_center, title_bodycell_text_color, title_bodycell_bg_color, title_bodycell_border_color_edge, title_bodycell_border_color_center, title_subcell_text_color, title_subcell_bg_color, title_subcell_border_color_edge, title_subcell_border_color_center FROM $t_edb_case_index_review_matrix_titles WHERE title_case_id=$get_current_case_id ORDER BY title_weight ASC";
					$result_titles = mysqli_query($link, $query_titles);
					while($row_titles = mysqli_fetch_row($result_titles)) {
						list($get_title_id, $get_title_case_id, $get_title_name, $get_title_weight, $get_title_colspan, $get_title_headcell_text_color, $get_title_headcell_bg_color, $get_title_headcell_border_color_edge, $get_title_headcell_border_color_center, $get_title_bodycell_text_color, $get_title_bodycell_bg_color, $get_title_bodycell_border_color_edge, $get_title_bodycell_border_color_center, $get_title_subcell_text_color, $get_title_subcell_bg_color, $get_title_subcell_border_color_edge, $get_title_subcell_border_color_center) = $row_titles;

				
						$field_human_counter = 1;
						$query_fields = "SELECT field_id, field_case_id, field_name, field_title_id, field_title_name, field_weight, field_type, field_size, field_alt_a, field_alt_b, field_alt_c, field_alt_d, field_alt_e, field_alt_f, field_alt_g, field_alt_h, field_alt_i, field_alt_j, field_alt_k, field_alt_l, field_alt_m FROM $t_edb_case_index_review_matrix_fields WHERE field_case_id=$get_current_case_id AND field_title_id=$get_title_id ORDER BY field_title_id, field_weight ASC";
						$result_fields = mysqli_query($link, $query_fields);
						while($row_fields = mysqli_fetch_row($result_fields)) {
							list($get_field_id, $get_field_case_id, $get_field_name, $get_field_title_id, $get_field_title_name, $get_field_weight, $get_field_type, $get_field_size, $get_field_alt_a, $get_field_alt_b, $get_field_alt_c, $get_field_alt_d, $get_field_alt_e, $get_field_alt_f, $get_field_alt_g, $get_field_alt_h, $get_field_alt_i, $get_field_alt_j, $get_field_alt_k, $get_field_alt_l, $get_field_alt_m) = $row_fields;
							
							// Style
							if($field_human_counter == "1"){
								echo"
								   <th style=\"background: $get_title_headcell_bg_color;border: $get_title_headcell_border_color_center 1px solid;border-left: $get_title_headcell_border_color_edge 1px solid;text-align: center;\">
								";
							}
							elseif($field_human_counter == "$get_title_colspan"){
								echo"
								   <th style=\"background: $get_title_headcell_bg_color;border: $get_title_headcell_border_color_center 1px solid;border-right: $get_title_headcell_border_color_edge 1px solid;text-align: center;\">
								";
							}
							else{
								echo"
								   <th style=\"background: $get_title_headcell_bg_color;border: $get_title_headcell_border_color_center 1px solid;text-align: center;\">
								";
							}
							echo"
							 
								<span style=\"color: $get_title_headcell_text_color;\">$get_field_name</span>
							   </th>
							";
							$field_human_counter++;
						} // fields
								
						// Colspan control
						$colspan_control_count = $field_human_counter-1;
						if($get_title_colspan != "$colspan_control_count"){
							echo"<meta http-equiv=\"refresh\" content=\"10;url=open_case_review_matrix.php?case_id=$get_current_case_id&amp;l=$l\">";
							echo"
							<div class=\"info\">
								<img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" />
								<p><b>$get_title_name:</b> Colspan error. Was $get_title_colspan but should be $colspan_control_count. Fixing and refreshing.</p>
							</div>";
							$result_upadte = mysqli_query($link, "UPDATE $t_edb_case_index_review_matrix_titles SET title_colspan=$colspan_control_count WHERE title_id=$get_title_id") or die(mysqli_error($link));
						}

					} // titles
					echo"
					  </tr>
					 </thead>
					 <tbody>";

					// Body parents
					$query = "SELECT matrix_item_id, matrix_item_case_id, matrix_item_item_id, matrix_item_record_id, matrix_item_record_seized_year, matrix_item_record_seized_journal, matrix_item_record_seized_district_number, matrix_item_numeric_serial_number, matrix_item_title FROM $t_edb_case_index_review_matrix_items WHERE matrix_item_case_id=$get_current_case_id  AND matrix_item_parent_matrix_item_id=0 ORDER BY matrix_item_record_seized_year, matrix_item_record_seized_journal, matrix_item_record_seized_district_number, matrix_item_numeric_serial_number ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_parent_matrix_item_id, $get_parent_matrix_item_case_id, $get_parent_matrix_item_item_id, $get_parent_matrix_item_record_id, $get_parent_matrix_item_record_seized_year, $get_parent_matrix_item_record_seized_journal, $get_parent_matrix_item_record_seized_district_number, $get_parent_matrix_item_numeric_serial_number, $get_parent_matrix_item_title) = $row;


						if(isset($style) && $style == ""){
							$style = "odd";
						}
						else{
							$style = "";
						}
						echo"
						  <tr>
						   <td class=\"$style\">
							<span>$get_parent_matrix_item_record_seized_year/$get_parent_matrix_item_record_seized_journal-$get_parent_matrix_item_record_seized_district_number-$get_parent_matrix_item_numeric_serial_number&nbsp;$get_parent_matrix_item_title</span>
						   </td>
						";


						// Titles
						$query_titles = "SELECT title_id, title_case_id, title_name, title_weight, title_colspan, title_headcell_text_color, title_headcell_bg_color, title_headcell_border_color_edge, title_headcell_border_color_center, title_bodycell_text_color, title_bodycell_bg_color, title_bodycell_border_color_edge, title_bodycell_border_color_center, title_subcell_text_color, title_subcell_bg_color, title_subcell_border_color_edge, title_subcell_border_color_center FROM $t_edb_case_index_review_matrix_titles WHERE title_case_id=$get_current_case_id ORDER BY title_weight ASC";
						$result_titles = mysqli_query($link, $query_titles);
						while($row_titles = mysqli_fetch_row($result_titles)) {
							list($get_title_id, $get_title_case_id, $get_title_name, $get_title_weight, $get_title_colspan, $get_title_headcell_text_color, $get_title_headcell_bg_color, $get_title_headcell_border_color_edge, $get_title_headcell_border_color_center, $get_title_bodycell_text_color, $get_title_bodycell_bg_color, $get_title_bodycell_border_color_edge, $get_title_bodycell_border_color_center, $get_title_subcell_text_color, $get_title_subcell_bg_color, $get_title_subcell_border_color_edge, $get_title_subcell_border_color_center) = $row_titles;

							$field_human_counter = 1;
							$query_fields = "SELECT field_id, field_case_id, field_name, field_title_id, field_title_name, field_weight, field_type, field_size, field_alt_a, field_alt_b, field_alt_c, field_alt_d, field_alt_e, field_alt_f, field_alt_g, field_alt_h, field_alt_i, field_alt_j, field_alt_k, field_alt_l, field_alt_m FROM $t_edb_case_index_review_matrix_fields WHERE field_case_id=$get_current_case_id AND field_title_id=$get_title_id ORDER BY field_title_id, field_weight ASC";
							$result_fields = mysqli_query($link, $query_fields);
							while($row_fields = mysqli_fetch_row($result_fields)) {
								list($get_field_id, $get_field_case_id, $get_field_name, $get_field_title_id, $get_field_title_name, $get_field_weight, $get_field_type, $get_field_size, $get_field_alt_a, $get_field_alt_b, $get_field_alt_c, $get_field_alt_d, $get_field_alt_e, $get_field_alt_f, $get_field_alt_g, $get_field_alt_h, $get_field_alt_i, $get_field_alt_j, $get_field_alt_k, $get_field_alt_l, $get_field_alt_m) = $row_fields;
								
								// Value
								$query_value = "SELECT value_id, value_case_id, value_text, value_item_id, value_title_id, value_field_id FROM $t_edb_case_index_review_matrix_values WHERE value_case_id=$get_current_case_id AND value_item_id=$get_parent_matrix_item_id AND value_title_id=$get_field_title_id AND value_field_id=$get_field_id";
								$result_value = mysqli_query($link, $query_value);
								$row_value = mysqli_fetch_row($result_value);
								list($get_value_id, $get_value_case_id, $get_value_text, $get_value_item_id, $get_value_title_id, $get_value_field_id) = $row_value;
								

								// Style
								if($field_human_counter == "1"){
									echo"
									   <td"; if($style == "odd"){ echo" style=\"background: $get_title_subcell_bg_color;border: $get_title_subcell_border_color_center 1px solid;border-left: $get_title_subcell_border_color_edge 1px solid;\""; } else{ echo" style=\"background: $get_title_bodycell_bg_color;border: $get_title_bodycell_border_color_center 1px solid;border-left: $get_title_subcell_border_color_edge 1px solid;\""; } echo">
									";
								}
								elseif($field_human_counter == "$get_title_colspan"){
									echo"
									   <td"; if($style == "odd"){ echo" style=\"background: $get_title_subcell_bg_color;border: $get_title_subcell_border_color_center 1px solid;border-right: $get_title_subcell_border_color_edge 1px solid;\""; } else{ echo" style=\"background: $get_title_bodycell_bg_color;border: $get_title_bodycell_border_color_center 1px solid;border-right: $get_title_subcell_border_color_edge 1px solid;\""; } echo">
									";
								}
								else{
									echo"
									   <td"; if($style == "odd"){ echo" style=\"background: $get_title_subcell_bg_color;border: $get_title_subcell_border_color_center 1px solid;\""; } else{ echo" style=\"background: $get_title_bodycell_bg_color;border: $get_title_bodycell_border_color_center 1px solid;\""; } echo">
									";
								}
								// Field types
								echo"<span>";
								if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){
									

									if($get_field_type == "text"){
										echo"<input type=\"text\" name=\"inp_text_$get_parent_matrix_item_id" . "_$get_field_id\" class=\"input_on_change_submit_form\" value=\"$get_value_text\" size=\"$get_field_size\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									elseif($get_field_type == "select"){
										echo"<select name=\"inp_text_$get_parent_matrix_item_id" . "_$get_field_id\" class=\"select_on_change_submit_form\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">\n";
										if($get_field_alt_a != ""){
											echo"										";
											echo"<option value=\"$get_field_alt_a\""; if($get_field_alt_a == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_a</option>\n";
										}
										if($get_field_alt_b != ""){
											echo"										";
											echo"<option value=\"$get_field_alt_b\""; if($get_field_alt_b == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_b</option>\n";
										}
										if($get_field_alt_c != ""){
											echo"										";
											echo"<option value=\"$get_field_alt_c\""; if($get_field_alt_c == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_c</option>\n";
										}
										if($get_field_alt_d != ""){
											echo"										";
											echo"<option value=\"$get_field_alt_d\""; if($get_field_alt_d == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_d</option>\n";
										}
										if($get_field_alt_e != ""){
											echo"										";
											echo"<option value=\"$get_field_alt_e\""; if($get_field_alt_e == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_e</option>\n";
										}
										if($get_field_alt_f != ""){
											echo"										";
											echo"<option value=\"$get_field_alt_f\""; if($get_field_alt_f == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_f</option>\n";
										}
										if($get_field_alt_g != ""){
											echo"										";
											echo"<option value=\"$get_field_alt_g\""; if($get_field_alt_g == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_g</option>\n";
										}
										if($get_field_alt_h != ""){
											echo"										";
											echo"<option value=\"$get_field_alt_h\""; if($get_field_alt_h == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_h</option>\n";
										}
										if($get_field_alt_i != ""){
											echo"										";
											echo"<option value=\"$get_field_alt_i\""; if($get_field_alt_i == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_i</option>\n";
										}
										if($get_field_alt_j != ""){
											echo"										";
											echo"<option value=\"$get_field_alt_j\""; if($get_field_alt_j == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_j</option>\n";
										}
										if($get_field_alt_k != ""){
											echo"										";
											echo"<option value=\"$get_field_alt_k\""; if($get_field_alt_k == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_k</option>\n";
										}
										if($get_field_alt_l != ""){
											echo"										";
											echo"<option value=\"$get_field_alt_l\""; if($get_field_alt_l == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_l</option>\n";
										}
										if($get_field_alt_m != ""){
											echo"										";
											echo"<option value=\"$get_field_alt_m\""; if($get_field_alt_m == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_m</option>\n";
										}
										echo"
										</select>";
									}
									elseif($get_field_type == "date"){
										echo"<input type=\"date\" name=\"inp_text_$get_parent_matrix_item_id" . "_$get_field_id\" class=\"select_on_change_submit_form\" value=\"$get_value_text\" size=\"$get_field_size\" class=\"on_change_submit_form\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									elseif($get_field_type == "checkbox"){
										echo"<input type=\"checkbox\" name=\"inp_text_$get_parent_matrix_item_id" . "_$get_field_id\" class=\"select_on_change_submit_form\" value=\"$get_field_alt_a\" class=\"on_change_submit_form\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\""; if($get_field_alt_a == "$get_value_text"){ echo" checked=\"checked\""; } echo" /> $get_field_alt_a";
									}
								}
								else{
									echo"$get_value_text";
								}
								echo"</span>
								   </td>
								";
								$field_human_counter = $field_human_counter+1;
							} // fields

						} // Body parent matrix_item_id
						echo"
						  </tr>
						";



						// Body children
						$query_matrix_item_children = "SELECT matrix_item_id, matrix_item_case_id, matrix_item_item_id, matrix_item_record_id, matrix_item_record_seized_year, matrix_item_record_seized_journal, matrix_item_record_seized_district_number, matrix_item_numeric_serial_number, matrix_item_title FROM $t_edb_case_index_review_matrix_items WHERE matrix_item_case_id=$get_current_case_id AND matrix_item_parent_matrix_item_id=$get_parent_matrix_item_id ORDER BY matrix_item_record_seized_year, matrix_item_record_seized_journal, matrix_item_record_seized_district_number, matrix_item_numeric_serial_number ASC";
						$result_matrix_item_children = mysqli_query($link, $query_matrix_item_children);
						while($row_matrix_item_children = mysqli_fetch_row($result_matrix_item_children)) {
							list($get_child_matrix_item_id, $get_child_matrix_item_case_id, $get_child_matrix_item_item_id, $get_child_matrix_item_record_id, $get_child_matrix_item_record_seized_year, $get_child_matrix_item_record_seized_journal, $get_child_matrix_item_record_seized_district_number, $get_child_matrix_item_numeric_serial_number, $get_child_matrix_item_title) = $row_matrix_item_children;
							
							// Title
							$get_child_matrix_item_title = str_replace(" ", "&nbsp;", $get_child_matrix_item_title);

							if(isset($style) && $style == ""){
								$style = "odd";
							}
							else{
								$style = "";
							}
							echo"
							  <tr>
							   <td class=\"$style\" style=\"padding-left: 5px;\">
								<span><img src=\"_gfx/review_matrix_child.png\" alt=\"review_matrix_child.png\" />&nbsp;$get_child_matrix_item_record_id/$get_child_matrix_item_record_seized_year-$get_child_matrix_item_record_seized_journal-$get_child_matrix_item_record_seized_district_number-$get_child_matrix_item_numeric_serial_number&nbsp;$get_child_matrix_item_title</span>
							   </td>
							";

							// Titles
							$query_titles = "SELECT title_id, title_case_id, title_name, title_weight, title_colspan, title_headcell_text_color, title_headcell_bg_color, title_headcell_border_color_edge, title_headcell_border_color_center, title_bodycell_text_color, title_bodycell_bg_color, title_bodycell_border_color_edge, title_bodycell_border_color_center, title_subcell_text_color, title_subcell_bg_color, title_subcell_border_color_edge, title_subcell_border_color_center FROM $t_edb_case_index_review_matrix_titles WHERE title_case_id=$get_current_case_id ORDER BY title_weight ASC";
							$result_titles = mysqli_query($link, $query_titles);
							while($row_titles = mysqli_fetch_row($result_titles)) {
								list($get_title_id, $get_title_case_id, $get_title_name, $get_title_weight, $get_title_colspan, $get_title_headcell_text_color, $get_title_headcell_bg_color, $get_title_headcell_border_color_edge, $get_title_headcell_border_color_center, $get_title_bodycell_text_color, $get_title_bodycell_bg_color, $get_title_bodycell_border_color_edge, $get_title_bodycell_border_color_center, $get_title_subcell_text_color, $get_title_subcell_bg_color, $get_title_subcell_border_color_edge, $get_title_subcell_border_color_center) = $row_titles;

								$field_human_counter = 1;
								$query_fields = "SELECT field_id, field_case_id, field_name, field_title_id, field_title_name, field_weight, field_type, field_size, field_alt_a, field_alt_b, field_alt_c, field_alt_d, field_alt_e, field_alt_f, field_alt_g, field_alt_h, field_alt_i, field_alt_j, field_alt_k, field_alt_l, field_alt_m FROM $t_edb_case_index_review_matrix_fields WHERE field_case_id=$get_current_case_id AND field_title_id=$get_title_id ORDER BY field_title_id, field_weight ASC";
								$result_fields = mysqli_query($link, $query_fields);
								while($row_fields = mysqli_fetch_row($result_fields)) {
									list($get_field_id, $get_field_case_id, $get_field_name, $get_field_title_id, $get_field_title_name, $get_field_weight, $get_field_type, $get_field_size, $get_field_alt_a, $get_field_alt_b, $get_field_alt_c, $get_field_alt_d, $get_field_alt_e, $get_field_alt_f, $get_field_alt_g, $get_field_alt_h, $get_field_alt_i, $get_field_alt_j, $get_field_alt_k, $get_field_alt_l, $get_field_alt_m) = $row_fields;
								
									// Value
									$query_value = "SELECT value_id, value_case_id, value_text, value_item_id, value_title_id, value_field_id FROM $t_edb_case_index_review_matrix_values WHERE value_case_id=$get_current_case_id AND value_item_id=$get_child_matrix_item_id AND value_title_id=$get_field_title_id AND value_field_id=$get_field_id";
									$result_value = mysqli_query($link, $query_value);
									$row_value = mysqli_fetch_row($result_value);
									list($get_value_id, $get_value_case_id, $get_value_text, $get_value_item_id, $get_value_title_id, $get_value_field_id) = $row_value;
								

									// Style
									if($field_human_counter == "1"){
										echo"
										   <td"; if($style == "odd"){ echo" style=\"background: $get_title_subcell_bg_color;border: $get_title_subcell_border_color_center 1px solid;border-left: $get_title_subcell_border_color_edge 1px solid;\""; } else{ echo" style=\"background: $get_title_bodycell_bg_color;border: $get_title_bodycell_border_color_center 1px solid;border-left: $get_title_subcell_border_color_edge 1px solid;\""; } echo">
										";
									}
									elseif($field_human_counter == "$get_title_colspan"){
										echo"
										   <td"; if($style == "odd"){ echo" style=\"background: $get_title_subcell_bg_color;border: $get_title_subcell_border_color_center 1px solid;border-right: $get_title_subcell_border_color_edge 1px solid;\""; } else{ echo" style=\"background: $get_title_bodycell_bg_color;border: $get_title_bodycell_border_color_center 1px solid;border-right: $get_title_subcell_border_color_edge 1px solid;\""; } echo">
										";
									}
									else{
										echo"
										   <td"; if($style == "odd"){ echo" style=\"background: $get_title_subcell_bg_color;border: $get_title_subcell_border_color_center 1px solid;\""; } else{ echo" style=\"background: $get_title_bodycell_bg_color;border: $get_title_bodycell_border_color_center 1px solid;\""; } echo">
										";
									}
									// Field types
									echo"<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){
									

										if($get_field_type == "text"){
											echo"<input type=\"text\" name=\"inp_text_$get_child_matrix_item_id" . "_$get_field_id\" class=\"input_on_change_submit_form\" value=\"$get_value_text\" size=\"$get_field_size\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
										}
										elseif($get_field_type == "select"){
											echo"<select name=\"inp_text_$get_child_matrix_item_id" . "_$get_field_id\" class=\"select_on_change_submit_form\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">\n";
											if($get_field_alt_a != ""){
												echo"										";
												echo"<option value=\"$get_field_alt_a\""; if($get_field_alt_a == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_a</option>\n";
											}
											if($get_field_alt_b != ""){
											echo"										";
											echo"<option value=\"$get_field_alt_b\""; if($get_field_alt_b == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_b</option>\n";
											}
											if($get_field_alt_c != ""){
												echo"										";
												echo"<option value=\"$get_field_alt_c\""; if($get_field_alt_c == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_c</option>\n";
											}
											if($get_field_alt_d != ""){
												echo"										";
												echo"<option value=\"$get_field_alt_d\""; if($get_field_alt_d == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_d</option>\n";
											}
											if($get_field_alt_e != ""){
												echo"										";
												echo"<option value=\"$get_field_alt_e\""; if($get_field_alt_e == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_e</option>\n";
											}
											if($get_field_alt_f != ""){
												echo"										";
												echo"<option value=\"$get_field_alt_f\""; if($get_field_alt_f == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_f</option>\n";
											}
											if($get_field_alt_g != ""){
												echo"										";
												echo"<option value=\"$get_field_alt_g\""; if($get_field_alt_g == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_g</option>\n";
											}
											if($get_field_alt_h != ""){
												echo"										";
												echo"<option value=\"$get_field_alt_h\""; if($get_field_alt_h == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_h</option>\n";
											}
											if($get_field_alt_i != ""){
												echo"										";
												echo"<option value=\"$get_field_alt_i\""; if($get_field_alt_i == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_i</option>\n";
											}
											if($get_field_alt_j != ""){
												echo"										";
												echo"<option value=\"$get_field_alt_j\""; if($get_field_alt_j == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_j</option>\n";
											}
											if($get_field_alt_k != ""){
												echo"										";
												echo"<option value=\"$get_field_alt_k\""; if($get_field_alt_k == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_k</option>\n";
											}
											if($get_field_alt_l != ""){
												echo"										";
												echo"<option value=\"$get_field_alt_l\""; if($get_field_alt_l == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_l</option>\n";
											}
											if($get_field_alt_m != ""){
												echo"										";
												echo"<option value=\"$get_field_alt_m\""; if($get_field_alt_m == "$get_value_text"){ echo" selected=\"selected\""; } echo">$get_field_alt_m</option>\n";
											}
											echo"
											</select>";
										}
										elseif($get_field_type == "date"){
											echo"<input type=\"date\" name=\"inp_text_$get_child_matrix_item_id" . "_$get_field_id\" class=\"select_on_change_submit_form\" value=\"$get_value_text\" size=\"$get_field_size\" class=\"on_change_submit_form\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
										}
										elseif($get_field_type == "checkbox"){
											echo"<input type=\"checkbox\" name=\"inp_text_$get_child_matrix_item_id" . "_$get_field_id\" class=\"select_on_change_submit_form\" value=\"$get_field_alt_a\" class=\"on_change_submit_form\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\""; if($get_field_alt_a == "$get_value_text"){ echo" checked=\"checked\""; } echo" /> $get_field_alt_a";
										}
									}
									else{
										echo"$get_value_text";
									}
									echo"</span>
									   </td>
									";
									$field_human_counter = $field_human_counter+1;
								} // fields
							} // ?
							echo"
							  </tr>
							";
						} // matrix items childrens
					} // matrix items parents
					echo"
					 </tbody>
					</table> 

					<!-- Save -->

						";
						if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){
							echo"
							<p>
							<input type=\"submit\" value=\"$l_save_changes\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
							</p>

							
							<!-- On change text save it -->
								<script type=\"text/javascript\">




}
								</script>

								<script id=\"source\" language=\"javascript\" type=\"text/javascript\">
								\$(document).ready(function () {
									\$('.input_on_change_submit_form').keyup(function () {
										// alert(\"Hello! I am an alert box!!\");
										saveForm();
									});
									\$('.select_on_change_submit_form').change(function() {
										// alert(\"Hello! I am an alert box!!\");
										saveForm();
									});
									

									function saveForm() {
        									// ajax call
            									\$.ajax({
                									type: \"POST\",
               										url: \"open_case_review_matrix_jquery_save.php\",
                									data: \$(\"#matrix_form\").serialize(), // get the form data
											beforeSend: function(html) { // this happens before actual call
												\$(\"#feedback_message\").html('<div class=\"success\"><p>$l_saving...</p></div>'); 
											},
               										success: function(html){
                    										\$(\"#feedback_message\").html(html);

												// Clock
												var today = new Date();
												var time = today.getHours() + \":\" + today.getMinutes() + \":\" + today.getSeconds();

												\$(document).prop('title', '$l_saved ' + time + ' - $l_review_matrix');
              										}
            									});
									}
         				   			});
								</script>

							<!-- //Submit form after change type -->
							";
						}
						echo"
					<!-- //Save -->
				<!-- //Review Matrix -->
				";
			} // action == ""

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