<?php 
/**
*
* File: edb/open_case_evidence_edit_evidence_item_acquire.php
* Version 1.0
* Date 21:03 04.08.2019
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
include("$root/_admin/_translations/site/$l/edb/ts_open_case_evidence_edit_evidence_item_info.php");
include("$root/_admin/_translations/site/$l/users/ts_users.php");



/*- Tables ---------------------------------------------------------------------------------- */
$t_edb_case_index_item_info_groups	= $mysqlPrefixSav . "edb_case_index_item_info_groups";
$t_edb_case_index_item_info_level_a	= $mysqlPrefixSav . "edb_case_index_item_info_level_a";
$t_edb_case_index_item_info_level_b	= $mysqlPrefixSav . "edb_case_index_item_info_level_b";
$t_edb_case_index_item_info_level_c	= $mysqlPrefixSav . "edb_case_index_item_info_level_c";
$t_edb_case_index_item_info_level_d	= $mysqlPrefixSav . "edb_case_index_item_info_level_d";


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

		if(isset($_GET['item_id'])) {
			$item_id = $_GET['item_id'];
			$item_id = strip_tags(stripslashes($item_id));
		}
		else{
			$item_id = "";
		}
		$item_id_mysql = quote_smart($link, $item_id);

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

		// Find station	
		$query = "SELECT station_id, station_number, station_title, station_title_clean, station_district_id, station_district_title, station_icon_path, station_icon_16, station_icon_32, station_icon_260, station_number_of_cases_now FROM $t_edb_stations_index WHERE station_id=$get_current_case_station_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_station_id, $get_current_station_number, $get_current_station_title, $get_current_station_title_clean, $get_current_station_district_id, $get_current_station_district_title, $get_current_station_icon_path, $get_current_station_icon_16, $get_current_station_icon_32, $get_current_station_icon_260, $get_current_station_number_of_cases_now) = $row;
	
		// Find station directory
		$query = "SELECT directory_id, directory_station_id, directory_station_title, directory_district_id, directory_district_title, directory_type, directory_address_linux, directory_address_windows, directory_address_prefered_for_agent, directory_last_checked_for_new_files_counter, directory_last_checked_for_new_files_time, directory_last_checked_for_new_files_hour, directory_last_checked_for_new_files_minute, directory_now_size_last_calculated_day, directory_now_size_last_calculated_hour, directory_now_size_last_calculated_minute, directory_now_size_mb, directory_now_size_gb, directory_available_size_mb, directory_available_size_gb, directory_available_size_percentage FROM $t_edb_stations_directories WHERE directory_station_id=$get_current_case_station_id AND directory_type='mirror_files'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_directory_id, $get_current_directory_station_id, $get_current_directory_station_title, $get_current_directory_district_id, $get_current_directory_district_title, $get_current_directory_type, $get_current_directory_address_linux, $get_current_directory_address_windows, $get_current_directory_address_prefered_for_agent, $get_current_directory_last_checked_for_new_files_counter, $get_current_directory_last_checked_for_new_files_time, $get_current_directory_last_checked_for_new_files_hour, $get_current_directory_last_checked_for_new_files_minute, $get_current_directory_now_size_last_calculated_day, $get_current_directory_now_size_last_calculated_hour, $get_current_directory_now_size_last_calculated_minute, $get_current_directory_now_size_mb, $get_current_directory_now_size_gb, $get_current_directory_available_size_mb, $get_current_directory_available_size_gb, $get_current_directory_available_size_percentage) = $row;
	
		

		/*- Headers ---------------------------------------------------------------------------------- */
		$website_title = "$l_edb - $get_current_case_district_title - $get_current_case_station_title - $get_current_case_number";
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
			// Find that item
			$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_timezone, item_date_now_date, item_date_now_ddmmyy, item_time_now, item_correct_date_now_date, item_correct_date_now_ddmmyy, item_correct_time_now, item_adjust_clock_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_date_ddmmyyyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy FROM $t_edb_case_index_evidence_items WHERE item_id=$item_id_mysql AND item_case_id=$get_current_case_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_item_id, $get_current_item_case_id, $get_current_item_record_id, $get_current_item_record_seized_year, $get_current_item_record_seized_journal, $get_current_item_record_seized_district_number, $get_current_item_numeric_serial_number, $get_current_item_title, $get_current_item_type_id, $get_current_item_type_title, $get_current_item_confirmed_by_human, $get_current_item_human_rejected, $get_current_item_request_text, $get_current_item_requester_user_id, $get_current_item_requester_user_name, $get_current_item_requester_user_alias, $get_current_item_requester_user_email, $get_current_item_requester_user_image_path, $get_current_item_requester_user_image_file, $get_current_item_requester_user_image_thumb_40, $get_current_item_requester_user_image_thumb_50, $get_current_item_requester_user_first_name, $get_current_item_requester_user_middle_name, $get_current_item_requester_user_last_name, $get_current_item_requester_user_job_title, $get_current_item_requester_user_department, $get_current_item_in_datetime, $get_current_item_in_date, $get_current_item_in_time, $get_current_item_in_date_saying, $get_current_item_in_date_ddmmyy, $get_current_item_comment, $get_current_item_condition, $get_current_item_serial_number, $get_current_item_imei_a, $get_current_item_imei_b, $get_current_item_imei_c, $get_current_item_imei_d, $get_current_item_os_title, $get_current_item_os_version, $get_current_item_timezone, $get_current_item_date_now_date, $get_current_item_date_now_ddmmyy, $get_current_item_time_now, $get_current_item_correct_date_now_date, $get_current_item_correct_date_now_ddmmyy, $get_current_item_correct_time_now, $get_current_item_adjust_clock_automatically, $get_current_item_acquired_software_id_a, $get_current_item_acquired_software_title_a, $get_current_item_acquired_software_notes_a, $get_current_item_acquired_software_id_b, $get_current_item_acquired_software_title_b, $get_current_item_acquired_software_notes_b, $get_current_item_acquired_software_id_c, $get_current_item_acquired_software_title_c, $get_current_item_acquired_software_notes_c, $get_current_item_acquired_date, $get_current_item_acquired_time, $get_current_item_acquired_date_saying, $get_current_item_acquired_date_ddmmyy, $get_current_item_acquired_date_ddmmyyyy, $get_current_item_acquired_user_id, $get_current_item_acquired_user_name, $get_current_item_acquired_user_alias, $get_current_item_acquired_user_email, $get_current_item_acquired_user_image_path, $get_current_item_acquired_user_image_file, $get_current_item_acquired_user_image_thumb_40, $get_current_item_acquired_user_image_thumb_50, $get_current_item_acquired_user_first_name, $get_current_item_acquired_user_middle_name, $get_current_item_acquired_user_last_name, $get_current_item_out_date, $get_current_item_out_time, $get_current_item_out_date_saying, $get_current_item_out_date_ddmmyy) = $row;
	
			if($get_current_item_id == ""){
				echo"<h1>Server error 404</h1><p>Item not found</p>";
				die;
			}
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
						<a href=\"open_case_evidence.php?case_id=$get_current_case_id&amp;page=$page&amp;l=$l\">$l_evidence</a>
						&gt;
						<a href=\"open_case_evidence_view_record.php?case_id=$get_current_case_id&amp;record_id=$get_current_item_record_id&amp;l=$l\">$get_current_item_record_seized_year/$get_current_item_record_seized_journal-$get_current_item_record_seized_district_number</a>
						&gt;
						<a href=\"open_case_evidence_edit_evidence_item_info.php?case_id=$get_current_case_id&amp;page=$page&amp;action=edit_evidence_item&amp;item_id=$get_current_item_id&amp;l=$l\">$get_current_item_numeric_serial_number</a>

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



				if($process != 1){
					echo"
					<h2>$get_current_item_record_seized_year/$get_current_item_record_seized_journal-$get_current_item_record_seized_district_number-$get_current_item_numeric_serial_number $get_current_item_title</h2>
			
			
					<!-- Edit item tabs -->
						<div class=\"clear\" style=\"height: 10px;\"></div>
						<div class=\"tabs\">
							<ul>
								<li><a href=\"open_case_evidence_edit_evidence_item_info.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;l=$l\""; if($mode == ""){ echo" class=\"active\""; } echo">$l_info</a></li>
								<li><a href=\"open_case_evidence_edit_evidence_item_request.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;mode=request&amp;l=$l\""; if($mode == "request"){ echo" class=\"active\""; } echo">$l_request</a></li>
								<li><a href=\"open_case_evidence_edit_evidence_item_item.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;mode=item&amp;l=$l\""; if($mode == "item"){ echo" class=\"active\""; } echo">$l_item</a></li>
								<li><a href=\"open_case_evidence_edit_evidence_item_acquire.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;mode=acquire&amp;l=$l\""; if($mode == "acquire"){ echo" class=\"active\""; } echo">$l_acquire</a></li>\n";
								// Info groups
								$query_set = "SELECT group_id, group_case_id, group_item_id, group_title, group_show_on_analysis_report, group_count_level_a FROM $t_edb_case_index_item_info_groups WHERE group_case_id=$get_current_case_id AND group_item_id=$get_current_item_id";
								$result_set = mysqli_query($link, $query_set);
								while($row_set = mysqli_fetch_row($result_set)) {
									list($get_group_id, $get_group_case_id, $get_group_item_id, $get_group_title, $get_group_show_on_analysis_report, $get_group_count_level_a) = $row_set;
									echo"								";
									echo"<li><a href=\"open_case_evidence_edit_evidence_item_info_group_view.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;mode=info_group_view&amp;group_id=$get_group_id&amp;l=$l\""; if($mode == "info_group_view" && $get_group_id == "$group_id"){ echo" class=\"active\""; } echo">$get_group_title ($get_group_count_level_a)</a></li>\n";
								}
								echo"
								<li><a href=\"open_case_evidence_edit_evidence_item_info_group_add.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;mode=info_group_add&amp;l=$l\""; if($mode == "info_group_add"){ echo" class=\"active\""; } echo">+</a></li>
							</ul>
						</div>
						<div class=\"clear\" style=\"height: 10px;\"></div>
					<!-- Edit item tabs -->
	
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
					";
				} // process != 1

				if($process == "1" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor")){
					$inp_acquired_day = $_POST['inp_acquired_day'];
					$inp_acquired_day = output_html($inp_acquired_day);
						

					$inp_acquired_month = $_POST['inp_acquired_month'];
					$inp_acquired_month = output_html($inp_acquired_month);
						
					$inp_acquired_year = $_POST['inp_acquired_year'];
					$inp_acquired_year = output_html($inp_acquired_year);
						
					if($inp_acquired_day == "" OR $inp_acquired_month == "" OR $inp_acquired_year == ""){
						$result = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
								item_acquired_date=NULL,
								item_acquired_time=NULL,
								item_acquired_date_saying=NULL,
								item_acquired_date_ddmmyy=NULL,
								item_acquired_date_ddmmyyyy=NULL
								 WHERE item_id=$get_current_item_id") or die(mysqli_error($link));

					}
					else{
						$inp_acquired_date = $inp_acquired_year . "-" . $inp_acquired_month . "-" . $inp_acquired_day;
						$inp_acquired_date_mysql = quote_smart($link, $inp_acquired_date);

						$inp_acquired_time = strtotime($inp_acquired_date);
						$inp_acquired_time_mysql = quote_smart($link, $inp_acquired_time);
					
	
							$l_month_array[0] = "";
							$l_month_array[1] = "$l_month_january";
							$l_month_array[2] = "$l_month_february";
							$l_month_array[3] = "$l_month_march";
							$l_month_array[4] = "$l_month_april";
							$l_month_array[5] = "$l_month_may";
							$l_month_array[6] = "$l_month_june";
							$l_month_array[7] = "$l_month_juli";
							$l_month_array[8] = "$l_month_august";
							$l_month_array[9] = "$l_month_september";
							$l_month_array[10] = "$l_month_october";
							$l_month_array[11] = "$l_month_november";
							$l_month_array[12] = "$l_month_december";
		
						$inp_acquired_day_saying = str_replace("0", "", $inp_acquired_day);
						$inp_acquired_month_saying = str_replace("0", "", $inp_acquired_month);
					
						$inp_acquired_date_saying = $inp_acquired_day_saying . ". " . $l_month_array[$inp_acquired_month_saying] . " " . $inp_acquired_year;
						$inp_acquired_date_saying_mysql = quote_smart($link, $inp_acquired_date_saying);

						$inp_acquired_date_ddmmyy_year = substr($inp_acquired_year, 2, 2);
						$inp_acquired_date_ddmmyy = $inp_acquired_day . "." . $inp_acquired_month  . "." . $inp_acquired_date_ddmmyy_year;
						$inp_acquired_date_ddmmyy_mysql = quote_smart($link, $inp_acquired_date_ddmmyy);

						$inp_acquired_date_ddmmyyyy = $inp_acquired_day . "." . $inp_acquired_month  . "." . $inp_acquired_year;
						$inp_acquired_date_ddmmyyyy_mysql = quote_smart($link, $inp_acquired_date_ddmmyyyy);



						$result = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
									item_acquired_date=$inp_acquired_date_mysql,
									item_acquired_time=$inp_acquired_time_mysql,
									item_acquired_date_saying=$inp_acquired_date_saying_mysql,
									item_acquired_date_ddmmyy=$inp_acquired_date_ddmmyy_mysql,
									item_acquired_date_ddmmyyyy=$inp_acquired_date_ddmmyyyy_mysql 
									 WHERE item_id=$get_current_item_id") or die(mysqli_error($link));

					} // Dates
					// Acquired by
					$inp_acquired_user_name = $_POST['inp_acquired_user_name'];
					$inp_acquired_user_name = output_html($inp_acquired_user_name);
					$inp_acquired_user_name_mysql = quote_smart($link, $inp_acquired_user_name);
				
					// acquired user
					$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_name=$inp_acquired_user_name_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_acquired_user_id, $get_acquired_user_email, $get_acquired_user_name, $get_acquired_user_alias, $get_acquired_user_language, $get_acquired_user_last_online, $get_acquired_user_rank, $get_acquired_user_login_tries) = $row;

					if($get_acquired_user_id != ""){
							
							// acquired photo
							$query = "SELECT photo_id, photo_destination, photo_thumb_40, photo_thumb_50 FROM $t_users_profile_photo WHERE photo_user_id=$get_acquired_user_id AND photo_profile_image='1'";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_acquired_photo_id, $get_acquired_photo_destination, $get_acquired_photo_thumb_40, $get_acquired_photo_thumb_50) = $row;
					
							// acquired Profile
						
							$query = "SELECT profile_id, profile_first_name, profile_middle_name, profile_last_name, profile_about FROM $t_users_profile WHERE profile_user_id=$get_acquired_user_id";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_acquired_profile_id, $get_acquired_profile_first_name, $get_acquired_profile_middle_name, $get_acquired_profile_last_name, $get_acquired_profile_about) = $row;
							$inp_acquired_user_name_mysql = quote_smart($link, $get_acquired_user_name);
							$inp_acquired_user_alias_mysql = quote_smart($link, $get_acquired_user_alias);
							$inp_acquired_user_email_mysql = quote_smart($link, $get_acquired_user_email);

							$inp_acquired_user_image_path = "_uploads/users/images/$get_acquired_user_id";
							$inp_acquired_user_image_path_mysql = quote_smart($link, $inp_acquired_user_image_path);

							$inp_acquired_user_image_file_mysql = quote_smart($link, $get_acquired_photo_destination);
			
							$inp_acquired_user_image_thumb_a_mysql = quote_smart($link, $get_acquired_photo_thumb_40);
							$inp_acquired_user_image_thumb_b_mysql = quote_smart($link, $get_acquired_photo_thumb_50);

							$inp_acquired_user_first_name_mysql = quote_smart($link, $get_acquired_profile_first_name);
							$inp_acquired_user_middle_name_mysql = quote_smart($link, $get_acquired_profile_middle_name);
							$inp_acquired_user_last_name_mysql = quote_smart($link, $get_acquired_profile_last_name);
			
						
							$result = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
											item_acquired_user_id=$get_acquired_user_id, 
											item_acquired_user_name=$inp_acquired_user_name_mysql,
											item_acquired_user_alias=$inp_acquired_user_alias_mysql,
											item_acquired_user_email=$inp_acquired_user_email_mysql,
											item_acquired_user_image_path=$inp_acquired_user_image_path_mysql,
											item_acquired_user_image_file=$inp_acquired_user_image_file_mysql,
											item_acquired_user_image_thumb_40=$inp_acquired_user_image_thumb_a_mysql,
											item_acquired_user_image_thumb_50=$inp_acquired_user_image_thumb_b_mysql,
											item_acquired_user_first_name=$inp_acquired_user_first_name_mysql,
											item_acquired_user_middle_name=$inp_acquired_user_middle_name_mysql,
											item_acquired_user_last_name=$inp_acquired_user_last_name_mysql 
											 WHERE item_id=$get_current_item_id") or die(mysqli_error($link));
					} // acquired user id not empty

					// Software
					$inp_acquired_software_id_a = $_POST['inp_acquired_software_id_a'];
					$inp_acquired_software_id_a = output_html($inp_acquired_software_id_a);
					$inp_acquired_software_id_a_mysql = quote_smart($link, $inp_acquired_software_id_a);
						
					$query = "SELECT software_id, software_title, software_version FROM $t_edb_software_index WHERE software_id=$inp_acquired_software_id_a_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_software_id, $get_software_title, $get_software_version) = $row;
					$inp_software_title_mysql = quote_smart($link, $get_software_title);
					$inp_software_version_mysql = quote_smart($link, $get_software_version);

					$result = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
									item_acquired_software_id_a=$inp_acquired_software_id_a_mysql,
									item_acquired_software_title_a=$inp_software_title_mysql,
									item_acquired_software_notes_a=$inp_software_version_mysql 
									 WHERE item_id=$get_current_item_id") or die(mysqli_error($link));


					if(isset($_POST['inp_acquired_software_id_b'])){
						$inp_acquired_software_id_b = $_POST['inp_acquired_software_id_b'];
						$inp_acquired_software_id_b = output_html($inp_acquired_software_id_b);
						$inp_acquired_software_id_b_mysql = quote_smart($link, $inp_acquired_software_id_b);

						$query = "SELECT software_id, software_title, software_version FROM $t_edb_software_index WHERE software_id=$inp_acquired_software_id_b_mysql";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_software_id, $get_software_title, $get_software_version) = $row;
						$inp_software_title_mysql = quote_smart($link, $get_software_title);
						$inp_software_version_mysql = quote_smart($link, $get_software_version);

						$result = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
								item_acquired_software_id_b=$inp_acquired_software_id_b_mysql,
								item_acquired_software_title_b=$inp_software_title_mysql,
								item_acquired_software_notes_b=$inp_software_version_mysql 
								 WHERE item_id=$get_current_item_id") or die(mysqli_error($link));
					}
					else{
						$result = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
								item_acquired_software_id_b=NULL,
								item_acquired_software_title_b=NULL,
								item_acquired_software_notes_b=NULL
								 WHERE item_id=$get_current_item_id") or die(mysqli_error($link));
					}

					if(isset($_POST['inp_acquired_software_id_c'])){
						$inp_acquired_software_id_c = $_POST['inp_acquired_software_id_c'];
						$inp_acquired_software_id_c = output_html($inp_acquired_software_id_c);
						$inp_acquired_software_id_c_mysql = quote_smart($link, $inp_acquired_software_id_c);


						$query = "SELECT software_id, software_title, software_version FROM $t_edb_software_index WHERE software_id=$inp_acquired_software_id_c_mysql";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_software_id, $get_software_title, $get_software_version) = $row;
						$inp_software_title_mysql = quote_smart($link, $get_software_title);
						$inp_software_version_mysql = quote_smart($link, $get_software_version);


						$result = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
								item_acquired_software_id_c=$inp_acquired_software_id_c_mysql,
								item_acquired_software_title_c=$inp_software_title_mysql,
								item_acquired_software_notes_c=$inp_software_version_mysql 
								 WHERE item_id=$get_current_item_id") or die(mysqli_error($link));
					}
					else{
						$result = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
								item_acquired_software_id_c=NULL,
								item_acquired_software_title_c=NULL,
								item_acquired_software_notes_c=NULL
								 WHERE item_id=$get_current_item_id") or die(mysqli_error($link));
					}

					// Mirror files
					$query = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_created_datetime, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_modified_datetime, mirror_file_modified_time, mirror_file_modified_date_saying, mirror_file_modified_date_ddmmyy, mirror_file_size_mb, mirror_file_size_human, mirror_file_backup_disk, mirror_file_comments FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_case_id=$get_current_case_id AND mirror_file_item_id=$get_current_item_id";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
							list($get_mirror_file_id, $get_mirror_file_case_id, $get_mirror_file_record_id, $get_mirror_file_item_id, $get_mirror_file_path_windows, $get_mirror_file_path_linux, $get_mirror_file_file, $get_mirror_file_ext, $get_mirror_file_type, $get_mirror_file_created_datetime, $get_mirror_file_created_time, $get_mirror_file_created_date_saying, $get_mirror_file_created_date_ddmmyy, $get_mirror_file_modified_datetime, $get_mirror_file_modified_time, $get_mirror_file_modified_date_saying, $get_mirror_file_modified_date_ddmmyy, $get_mirror_file_size_mb, $get_mirror_file_size_human, $get_mirror_file_backup_disk, $get_mirror_file_comments) = $row;

							// We need to save both windows and linux file format from this given address
							$inp_mirror_file_path = $_POST["inp_mirror_file_path_$get_mirror_file_id"];
							$inp_mirror_file_path = output_html($inp_mirror_file_path);
							$inp_mirror_file_path_mysql = quote_smart($link, $inp_mirror_file_path);
							
							$inp_mirror_file_path_windows = "$inp_mirror_file_path";
							$inp_mirror_file_path_windows = str_replace("$get_current_directory_address_windows", "", $inp_mirror_file_path_windows);
							$inp_mirror_file_path_windows = str_replace("$get_current_directory_address_linux", "", $inp_mirror_file_path_windows);
							$inp_mirror_file_path_windows = $get_current_directory_address_windows . "\\" . $inp_mirror_file_path_windows;
							$inp_mirror_file_path_windows_mysql = quote_smart($link, $inp_mirror_file_path_windows);
							
							$inp_mirror_file_path_linux = "$inp_mirror_file_path";
							$inp_mirror_file_path_linux = str_replace("$get_current_directory_address_windows", "", $inp_mirror_file_path_linux);
							$inp_mirror_file_path_linux = str_replace("$get_current_directory_address_linux", "", $inp_mirror_file_path_linux);
							$inp_mirror_file_path_linux = $get_current_directory_address_linux . "/" . $inp_mirror_file_path_linux;
							$inp_mirror_file_path_linux_mysql = quote_smart($link, $inp_mirror_file_path_linux);

							$inp_mirror_file_file = $_POST["inp_mirror_file_file_$get_mirror_file_id"];
							$inp_mirror_file_file = output_html($inp_mirror_file_file);
							$inp_mirror_file_file_mysql = quote_smart($link, $inp_mirror_file_file);

							$inp_mirror_file_ext = get_extension($inp_mirror_file_file);
							$inp_mirror_file_ext = output_html($inp_mirror_file_ext);
							$inp_mirror_file_ext_mysql = quote_smart($link, $inp_mirror_file_ext);

							if(file_exists("$inp_mirror_file_path/$inp_mirror_file_file")){
 								$inp_mirror_file_type = mime_content_type("$inp_mirror_file_path/$inp_mirror_file_file");
							}
							else{
								$inp_mirror_file_type = "$inp_mirror_file_ext file";
							}
							$inp_mirror_file_type = output_html($inp_mirror_file_type);
							$inp_mirror_file_type_mysql = quote_smart($link, $inp_mirror_file_type);
							
							$inp_mirror_file_backup_disk = $_POST["inp_mirror_file_backup_disk_$get_mirror_file_id"];
							$inp_mirror_file_backup_disk = output_html($inp_mirror_file_backup_disk);
							$inp_mirror_file_backup_disk_mysql = quote_smart($link, $inp_mirror_file_backup_disk);

							$inp_mirror_file_comments = $_POST["inp_mirror_file_comments_$get_mirror_file_id"];
							$inp_mirror_file_comments = output_html($inp_mirror_file_comments);
							$inp_mirror_file_comments_mysql = quote_smart($link, $inp_mirror_file_comments);

							if(isset($_POST["inp_mirror_file_delete_$get_mirror_file_id"])){
								$inp_mirror_file_delete = $_POST["inp_mirror_file_delete_$get_mirror_file_id"];
							}
							else{
								$inp_mirror_file_delete = "off";
							}
							if($inp_mirror_file_delete == "on"){
								$result_delete = mysqli_query($link, "DELETE FROM $t_edb_case_index_evidence_items_mirror_files  WHERE mirror_file_id=$get_mirror_file_id");
							}
							else{
								$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items_mirror_files SET
													mirror_file_path_windows=$inp_mirror_file_path_windows_mysql,
													mirror_file_path_linux=$inp_mirror_file_path_linux_mysql,
 													mirror_file_file=$inp_mirror_file_file_mysql,
 													mirror_file_ext=$inp_mirror_file_ext_mysql,
													mirror_file_type=$inp_mirror_file_type_mysql,
													mirror_file_backup_disk=$inp_mirror_file_backup_disk_mysql,
													mirror_file_ready_agent_tries_counter=0,
													mirror_file_comments=$inp_mirror_file_comments_mysql 
												 WHERE mirror_file_id=$get_mirror_file_id") or die(mysqli_error($link));

							}
					} // while mirror files


					// Add n mirror files
					for($x=0;$x<2;$x++){
							$inp_mirror_file_path = $_POST["inp_mirror_file_path_new_$x"];
							$inp_mirror_file_path = output_html($inp_mirror_file_path);
							$inp_mirror_file_path_mysql = quote_smart($link, $inp_mirror_file_path);

							$inp_mirror_file_file = $_POST["inp_mirror_file_file_new_$x"];
							$inp_mirror_file_file = output_html($inp_mirror_file_file);
							$inp_mirror_file_file_mysql = quote_smart($link, $inp_mirror_file_file);

							$inp_mirror_file_ext = get_extension($inp_mirror_file_file);
							$inp_mirror_file_ext = output_html($inp_mirror_file_ext);
							$inp_mirror_file_ext_mysql = quote_smart($link, $inp_mirror_file_ext);


							if(file_exists("$inp_mirror_file_path/$inp_mirror_file_file")){
 								$inp_mirror_file_type = mime_content_type("$inp_mirror_file_path/$inp_mirror_file_file");
							}
							else{
								$inp_mirror_file_type = "$inp_mirror_file_ext file";
							}
							$inp_mirror_file_type = output_html($inp_mirror_file_type);
							$inp_mirror_file_type_mysql = quote_smart($link, $inp_mirror_file_type);

							$inp_mirror_file_backup_disk = $_POST["inp_mirror_file_backup_disk_new_$x"];
							$inp_mirror_file_backup_disk = output_html($inp_mirror_file_backup_disk);
							$inp_mirror_file_backup_disk_mysql = quote_smart($link, $inp_mirror_file_backup_disk);

							$inp_mirror_file_comments = $_POST["inp_mirror_file_comments_new_$x"];
							$inp_mirror_file_comments = output_html($inp_mirror_file_comments);
							$inp_mirror_file_comments_mysql = quote_smart($link, $inp_mirror_file_comments);
	
							if(file_exists("$inp_mirror_file_path/$inp_mirror_file_file")){
								$inp_mirror_file_created_datetime = date ("Y-m-d H:i:s", filemtime("$inp_mirror_file_path/$inp_mirror_file_file"));
								$inp_mirror_file_created_time  = filemtime("$inp_mirror_file_path/$inp_mirror_file_file");
								$inp_mirror_file_created_date_saying = date ("d. M y H:i", filemtime("$inp_mirror_file_path/$inp_mirror_file_file"));
								$inp_mirror_file_created_date_ddmmyy = date ("d.m.y H:i", filemtime("$inp_mirror_file_path/$inp_mirror_file_file"));
							}
							else{
								$inp_mirror_file_created_datetime = date ("Y-m-d H:i:s");
								$inp_mirror_file_created_time  = time();
								$inp_mirror_file_created_date_saying = date ("d. M y H:i");
								$inp_mirror_file_created_date_ddmmyy = date ("d.m.y H:i");
							}



							if($inp_mirror_file_file != "" OR $inp_mirror_file_backup_disk != "" OR $inp_mirror_file_comments != ""){
								mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_items_mirror_files
								(mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_created_datetime, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_backup_disk, mirror_file_ready_for_automated_machine, mirror_file_ready_agent_tries_counter, mirror_file_comments) 
								VALUES 
								(NULL, $get_current_case_id, $get_current_item_record_id, $get_current_item_id, $inp_mirror_file_path_mysql, $inp_mirror_file_path_mysql, $inp_mirror_file_file_mysql, $inp_mirror_file_ext_mysql, $inp_mirror_file_type_mysql, '$inp_mirror_file_created_datetime', '$inp_mirror_file_created_time', '$inp_mirror_file_created_date_saying', '$inp_mirror_file_created_date_ddmmyy', $inp_mirror_file_backup_disk_mysql, 0, 0, $inp_mirror_file_comments_mysql)")
								or die(mysqli_error($link));
						}
					}


					$url = "open_case_evidence_edit_evidence_item_acquire.php?case_id=$get_current_case_id&item_id=$get_current_item_id&mode=$mode&l=$l&ft=success&fm=changes_saved";
					header("Location: $url");
					exit;
				}
				echo"
				<h2>$l_acquire</h2>

				<!-- Edit evidence acquire -->
					";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
					echo"
						<!-- Focus -->
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_title\"]').focus();
						});
						</script>
						<!-- //Focus -->

						<form method=\"POST\" action=\"open_case_evidence_edit_evidence_item_acquire.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;mode=$mode&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
						";
					}
					echo"

					<p>$l_acquired";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo" <a href=\"#acquired\" id=\"input_date_now\"><img src=\"_gfx/ic_event_black_18dp.png\" alt=\"ic_event_black_18dp.png\" /></a><br />";
						$acquired_year = substr($get_current_item_acquired_date, 0, 4);
						$acquired_month = substr($get_current_item_acquired_date, 5, 2);
						$acquired_month = str_replace("0", "", $acquired_month);
						$acquired_day = substr($get_current_item_acquired_date, 8, 4);
						echo"
						<select name=\"inp_acquired_day\" id=\"inp_acquired_day\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" >
							<option value=\"\">- $l_day -</option>\n";
							for($x=1;$x<32;$x++){
								if($x<10){
									$y = 0 . $x;
								}
								else{
									$y = $x;
								}
								echo"<option value=\"$y\""; if($acquired_day == "$y"){ echo" selected=\"selected\""; } echo">$x</option>\n";
							}
							echo"
						</select>

						<select name=\"inp_acquired_month\" id=\"inp_acquired_month\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" >
							<option value=\"\">- $l_month -</option>\n";
							$l_month_array[0] = "";
							$l_month_array[1] = "$l_month_january";
							$l_month_array[2] = "$l_month_february";
							$l_month_array[3] = "$l_month_march";
							$l_month_array[4] = "$l_month_april";
							$l_month_array[5] = "$l_month_may";
							$l_month_array[6] = "$l_month_june";
							$l_month_array[7] = "$l_month_juli";
							$l_month_array[8] = "$l_month_august";
							$l_month_array[9] = "$l_month_september";
							$l_month_array[10] = "$l_month_october";
							$l_month_array[11] = "$l_month_november";
							$l_month_array[12] = "$l_month_december";
							for($x=1;$x<13;$x++){
								if($x<10){
									$y = 0 . $x;
								}
								else{
									$y = $x;
								}
								echo"<option value=\"$y\""; if($acquired_month == "$y"){ echo" selected=\"selected\""; } echo">$l_month_array[$x]</option>\n";
							}
							echo"
						</select>

						<select name=\"inp_acquired_year\" id=\"inp_acquired_year\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" >
							<option value=\"\">- $l_year -</option>\n";
							$year = date("Y");
							for($x=0;$x<150;$x++){
								echo"<option value=\"$year\""; if($acquired_year == "$year"){ echo" selected=\"selected\""; } echo">$year</option>\n";
								$year = $year-1;
							}
							echo"
							</select>
						</p>

						<!-- Input date now on click -->
							<script type=\"text/javascript\">
							\$(function() {
								\$('#input_date_now').click(function() {
									var day = '"; echo date("d"); echo"'
									var month = '"; echo date("m"); echo"'
									var year = '"; echo date("Y"); echo"'
            								\$(\"#inp_acquired_day\").val(day);
            								\$(\"#inp_acquired_month\").val(month);
            								\$(\"#inp_acquired_year\").val(year);
            								return false;
       								});
    							});
							</script>
						<!-- //Input date now on click -->
						";
					}
					else{
						echo":<br />
						$get_current_item_acquired_date_ddmmyyyy</p>";
					}
					echo"
					<p>$l_acquired_by_user_name:<br />";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"<input type=\"text\" name=\"inp_acquired_user_name\" id=\"autosearch_inp_search_for_acquired\" value=\"$get_current_item_acquired_user_name\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
					}
					else{
						echo"$get_current_item_acquired_user_name";
					}
					echo"
					</p>

						<div class=\"open_case_acquired_results\">
						</div>

						<!-- Acquired Autocomplete -->
						<script>
						\$(document).ready(function () {
							\$('#autosearch_inp_search_for_acquired').keyup(function () {
       								// getting the value that user typed
       								var searchString    = $(\"#autosearch_inp_search_for_acquired\").val();
 								// forming the queryString
      								var data            = 'l=$l&q=' + searchString;
         
        							// if searchString is not empty
        							if(searchString) {
           								// ajax call
            								\$.ajax({
                								type: \"GET\",
               									url: \"open_case_evidence_edit_evidence_item_acquire_jquery_search_for_user.php\",
                								data: data,
										beforeSend: function(html) { // this happens before actual call
											\$(\".open_case_acquired_results\").html(''); 
										},
               									success: function(html){
                    									\$(\".open_case_acquired_results\").append(html);
              									}
            								});
       								}
        							return false;
            						});
         					});
						</script>
						<!-- //Acquired Autocomplete -->

					<p>$l_software:";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo" (<a href=\"$root/_admin/index.php?open=edb&amp;page=software_index&amp;editor_language=$l&amp;l=$l\" target=\"_blank\">$l_edit</a>)<br />
						
						<select name=\"inp_acquired_software_id_a\" class=\"on_change_submit_form\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
							<option value=\"0\""; if($get_current_item_acquired_software_id_a == ""){ echo" selected=\"selected\""; } echo">-</option>\n";
						$found = 0;
						$query_sub = "SELECT software_id, software_title, software_version FROM $t_edb_software_index WHERE software_show_in_acquire_list=1 ORDER BY software_title ASC";
						$result_sub = mysqli_query($link, $query_sub);
						while($row_sub = mysqli_fetch_row($result_sub)) {
							list($get_software_id, $get_software_title, $get_software_version) = $row_sub;
							echo"			";
							echo"<option value=\"$get_software_id\""; if($get_software_id == "$get_current_item_acquired_software_id_a"){ $found = 1; echo" selected=\"selected\""; } echo">$get_software_title $get_software_version</option>\n";
						}
						echo"			<option value=\"0\">-</option>\n";
						$query_sub = "SELECT software_id, software_title, software_version FROM $t_edb_software_index WHERE software_show_in_acquire_list=0 ORDER BY software_title ASC";
						$result_sub = mysqli_query($link, $query_sub);
						while($row_sub = mysqli_fetch_row($result_sub)) {
							list($get_software_id, $get_software_title, $get_software_version) = $row_sub;
							echo"			";
							echo"<option value=\"$get_software_id\""; if($get_software_id == "$get_current_item_acquired_software_id_a"){ $found = 1; echo" selected=\"selected\""; } echo">$get_software_title $get_software_version</option>\n";
						}
						echo"
						</select>
						";
						// Legacy mode for beslagsdb ver 2
						if($found == "0" && $get_current_item_acquired_software_title_a != ""){
							echo"$get_current_item_acquired_software_title_a";
						}

						if($get_current_item_acquired_software_id_a != "" && $get_current_item_acquired_software_id_a != "0"){
							echo"
							<select name=\"inp_acquired_software_id_b\" class=\"on_change_submit_form\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
								<option value=\"0\""; if($get_current_item_acquired_software_id_a == ""){ echo" selected=\"selected\""; } echo">-</option>\n";
								$query_sub = "SELECT software_id, software_title, software_version FROM $t_edb_software_index WHERE software_show_in_acquire_list=1 ORDER BY software_title ASC";
								$result_sub = mysqli_query($link, $query_sub);
								while($row_sub = mysqli_fetch_row($result_sub)) {
									list($get_software_id, $get_software_title, $get_software_version) = $row_sub;
									echo"			";
									echo"<option value=\"$get_software_id\""; if($get_software_id == "$get_current_item_acquired_software_id_b"){ echo" selected=\"selected\""; } echo">$get_software_title $get_software_version</option>\n";
								}
								echo"
								<option value=\"0\">-</option>\n";
								$query_sub = "SELECT software_id, software_title, software_version FROM $t_edb_software_index WHERE software_show_in_acquire_list=0 ORDER BY software_title ASC";
								$result_sub = mysqli_query($link, $query_sub);
								while($row_sub = mysqli_fetch_row($result_sub)) {
									list($get_software_id, $get_software_title, $get_software_version) = $row_sub;
									echo"			";
									echo"<option value=\"$get_software_id\""; if($get_current_item_acquired_software_id_b == "$get_software_id"){ echo" selected=\"selected\""; } echo">$get_software_title $get_software_version</option>\n";
								}
								echo"
							</select>
							";
						}
						if($get_current_item_acquired_software_id_b != "" && $get_current_item_acquired_software_id_b != "0"){
							echo"
							<select name=\"inp_acquired_software_id_c\" class=\"on_change_submit_form\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
								<option value=\"0\""; if($get_current_item_acquired_software_id_a == ""){ echo" selected=\"selected\""; } echo">-</option>\n";
								$query_sub = "SELECT software_id, software_title, software_version FROM $t_edb_software_index WHERE software_show_in_acquire_list=1 ORDER BY software_title ASC";
								$result_sub = mysqli_query($link, $query_sub);
								while($row_sub = mysqli_fetch_row($result_sub)) {
									list($get_software_id, $get_software_title, $get_software_version) = $row_sub;
									echo"			";
									echo"<option value=\"$get_software_id\""; if($get_software_id == "$get_current_item_acquired_software_id_c"){ echo" selected=\"selected\""; } echo">$get_software_title $get_software_version</option>\n";
								}
								echo"
								<option value=\"0\">-</option>\n";
								$query_sub = "SELECT software_id, software_title, software_version FROM $t_edb_software_index WHERE software_show_in_acquire_list=0 ORDER BY software_title ASC";
								$result_sub = mysqli_query($link, $query_sub);
								while($row_sub = mysqli_fetch_row($result_sub)) {
									list($get_software_id, $get_software_title, $get_software_version) = $row_sub;
									echo"			";
									echo"<option value=\"$get_software_id\""; if($get_current_item_acquired_software_id_c == "$get_software_id"){ echo" selected=\"selected\""; } echo">$get_software_title $get_software_version</option>\n";
								}
								echo"
							</select>
							";
						}
					}
					else{
						echo"<br />	
						$get_current_item_acquired_software_title_a $get_current_item_acquired_software_notes_a ";
						if($get_current_item_acquired_software_title_b != ""){
							echo" &middot; $get_current_item_acquired_software_title_b $get_current_item_acquired_software_notes_b ";
						}
						if($get_current_item_acquired_software_title_c != ""){
							echo" &middot; $get_current_item_acquired_software_title_c $get_current_item_acquired_software_notes_c ";
						}
					}
					echo"			
					</p>

					";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"
						<!-- On change value submit form -->
							<script>
							\$(function() {
								\$('.on_change_submit_form').change(function() {
									this.form.submit();
								});
							});
							</script>
						<!-- //On change value submit form -->
						";
					}
					echo"
						<!-- Mirror files -->

							<hr />
							<a id=\"mirror_files\"></a>
							<h3>$l_mirror_files</h3>

							<table class=\"hor-zebra\">
							 <thead>
							  <tr>
							   <th scope=\"col\">
								<span>$l_path</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_file</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_ext</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_type</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_created</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_modified</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_size</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_exists</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_ready_for_automated_machine</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_backup_disk</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_comments</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_delete</span>
							   </th>
							  </tr>
							 </thead>
							 <tbody>
							";
			
							$query = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_created_datetime, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_modified_datetime, mirror_file_modified_time, mirror_file_modified_date_saying, mirror_file_modified_date_ddmmyy, mirror_file_size_mb, mirror_file_size_human, mirror_file_backup_disk, mirror_file_exists, mirror_file_ready_for_automated_machine, mirror_file_comments FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_case_id=$get_current_case_id AND mirror_file_item_id=$get_current_item_id";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_mirror_file_id, $get_mirror_file_case_id, $get_mirror_file_record_id, $get_mirror_file_item_id, $get_mirror_file_path_windows, $get_mirror_file_path_linux, $get_mirror_file_file, $get_mirror_file_ext, $get_mirror_file_type, $get_mirror_file_created_datetime, $get_mirror_file_created_time, $get_mirror_file_created_date_saying, $get_mirror_file_created_date_ddmmyy, $get_mirror_file_modified_datetime, $get_mirror_file_modified_time, $get_mirror_file_modified_date_saying, $get_mirror_file_modified_date_ddmmyy, $get_mirror_file_size_mb, $get_mirror_file_size_human, $get_mirror_file_backup_disk, $get_mirror_file_exists, $get_mirror_file_ready_for_automated_machine, $get_mirror_file_comments) = $row;

								if(isset($style) && $style == ""){
									$style = "odd";
								}
								else{
									$style = "";
								}
								echo"
								 <tr>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_mirror_file_path_$get_mirror_file_id\" size=\"15\" value=\"$get_mirror_file_path_windows\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_mirror_file_path";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_mirror_file_file_$get_mirror_file_id\" size=\"35\" value=\"$get_mirror_file_file\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_mirror_file_file";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_mirror_file_ext</span>
								  </td>
								  <td class=\"$style\">	
									<span>$get_mirror_file_type</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_mirror_file_created_date_ddmmyy</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_mirror_file_modified_date_ddmmyy</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_mirror_file_size_human</span>
								  </td>
								  <td class=\"$style\">
									 ";
									if($get_mirror_file_exists == "1"){
										echo"<a href=\"open_case_evidence_edit_evidence_item_acquire_hash.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;mode=acquire&amp;l=$l#mirror_file$get_mirror_file_id\">$l_yes</a>";
									}
									elseif($get_mirror_file_exists == "0"){
										echo"$l_no";
									}
									else{
										echo"$l_unknown";
									}
									echo"
								  </td>
								  <td class=\"$style\">
									 ";
									if($get_mirror_file_ready_for_automated_machine == "1"){
										echo"$l_yes";
									}
									elseif($get_mirror_file_ready_for_automated_machine == "0"){
										echo"$l_no";
									}
									else{
										echo"$l_unknown";
									}
									echo"
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_mirror_file_backup_disk_$get_mirror_file_id\" size=\"5\" value=\"$get_mirror_file_backup_disk\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_mirror_file_backup_disk";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_mirror_file_comments_$get_mirror_file_id\" size=\"15\" value=\"$get_mirror_file_comments\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_mirror_file_comments";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"checkbox\" name=\"inp_mirror_file_delete_$get_mirror_file_id\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									echo"</span>
								  </td>
								 </tr>
								";
							} // while mirror files

							// Find station mirror file default directory 
							$query = "SELECT directory_id, directory_address_linux, directory_address_windows, directory_address_prefered_for_agent FROM $t_edb_stations_directories WHERE directory_station_id=$get_current_case_station_id AND directory_type='mirror_files'";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_current_directory_id, $get_current_directory_address_linux, $get_current_directory_address_windows, $get_current_directory_address_prefered_for_agent) = $row;
	
							// We may want to use / on Linux and \ on Windows
							// $search_for_foward = strpos($get_current_directory_address, "/");
							if($get_current_directory_address_prefered_for_agent == "windows"){
								$inp_mirror_file_path = "$get_current_directory_address_windows" . "\\" . $get_current_case_number;
							}
							else{
								$inp_mirror_file_path = "$get_current_directory_address_linux/$get_current_case_number";
							}

						// Add n mirror files
						if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
							for($x=0;$x<2;$x++){
								if(isset($style) && $style == ""){
									$style = "odd";
								}
								else{
									$style = "";
								}
								echo"
								<tr>
								  <td class=\"$style\">
									<span><input type=\"text\" name=\"inp_mirror_file_path_new_$x\" size=\"15\" value=\"$inp_mirror_file_path\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
								  </td>
								  <td class=\"$style\">
									<span><input type=\"text\" name=\"inp_mirror_file_file_new_$x\" size=\"35\" value=\"\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
								  </td>
								  <td class=\"$style\">
									<!-- Ext -->
								  </td>
								  <td class=\"$style\">
									<!-- Type -->
								  </td>
								  <td class=\"$style\">
									<!-- Created -->
								  </td>
								  <td class=\"$style\">
									<!-- Modified -->
								  </td>
								  <td class=\"$style\">
									<!-- Size -->
								  </td>
								  <td class=\"$style\">
									<!-- Exists -->
								  </td>
								  <td class=\"$style\">
									<!-- Ready -->
								  </td>
								  <td class=\"$style\">
									<span><input type=\"text\" name=\"inp_mirror_file_backup_disk_new_$x\" size=\"5\" value=\"\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
								  </td>
								  <td class=\"$style\">
									<span><input type=\"text\" name=\"inp_mirror_file_comments_new_$x\" size=\"15\" value=\"\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
								  </td>
								  <td class=\"$style\">
									<!-- Delete -->
								  </td>
								 </tr>
								";
							}
						}
						echo"
							 </tbody>
							</table>
					<!-- //Mirror files -->
						
					";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){	
						echo"
						<p>
						<input type=\"submit\" value=\"$l_save_changes\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
						</p>
						</form>
						";
					}
					echo"
				<!-- //Edit evidence acquire -->
				";
			} // item found

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