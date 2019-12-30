<?php 
/**
*
* File: edb/open_case_evidence_edit_evidence_item.php
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


/*- Tables ---------------------------------------------------------------------------- */
$t_edb_evidence_storage_locations 	= $mysqlPrefixSav . "edb_evidence_storage_locations";
$t_edb_evidence_storage_shelves		= $mysqlPrefixSav . "edb_evidence_storage_shelves";

$t_edb_most_used_passwords 			= $mysqlPrefixSav . "edb_most_used_passwords";
$t_edb_case_index_usr_psw 			= $mysqlPrefixSav . "edb_case_index_usr_psw";
$t_edb_item_types_available_passwords		= $mysqlPrefixSav . "edb_item_types_available_passwords";
$t_edb_case_index_evidence_items_passwords 	= $mysqlPrefixSav . "edb_case_index_evidence_items_passwords";

/*- Tables Stats ----------------------------------------------------------------------- */
$t_edb_stats_index 			= $mysqlPrefixSav . "edb_stats_index";
$t_edb_stats_case_codes			= $mysqlPrefixSav . "edb_stats_case_codes";
$t_edb_stats_case_priorites		= $mysqlPrefixSav . "edb_stats_case_priorites";
$t_edb_stats_item_types 		= $mysqlPrefixSav . "edb_stats_item_types";
$t_edb_stats_statuses_per_day		= $mysqlPrefixSav . "edb_stats_statuses_per_day";
$t_edb_stats_employee_of_the_month	= $mysqlPrefixSav . "edb_stats_employee_of_the_month";
$t_edb_stats_acquirements_per_month	= $mysqlPrefixSav . "edb_stats_acquirements_per_month";

$t_edb_stats_requests_user_per_month			= $mysqlPrefixSav . "edb_stats_requests_user_per_month";
$t_edb_stats_requests_user_case_codes_per_month		= $mysqlPrefixSav . "edb_stats_requests_user_case_codes_per_month";
$t_edb_stats_requests_user_item_types_per_month		= $mysqlPrefixSav . "edb_stats_requests_user_item_types_per_month";
$t_edb_stats_requests_department_per_month		= $mysqlPrefixSav . "edb_stats_requests_department_per_month";
$t_edb_stats_requests_department_case_codes_per_month	= $mysqlPrefixSav . "edb_stats_requests_department_case_codes_per_month";
$t_edb_stats_requests_department_item_types_per_month	= $mysqlPrefixSav . "edb_stats_requests_department_item_types_per_month";


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

if(isset($_GET['focus'])) {
	$focus = $_GET['focus'];
	$focus = strip_tags(stripslashes($focus));
}
else{
	$focus = "";
}

if(isset($_GET['group_id'])) {
	$group_id = $_GET['group_id'];
	$group_id = strip_tags(stripslashes($group_id));
}
else{
	$group_id = "";
}


/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){

	// Find case 
	$query = "SELECT case_id, case_number, case_title, case_title_clean, case_suspect_in_custody, case_code_id, case_code_number, case_code_title, case_status_id, case_status_title, case_priority_id, case_priority_title, case_district_id, case_district_title, case_station_id, case_station_title, case_is_screened, case_physical_location, case_backup_disks, case_confirmed_by_human, case_human_rejected, case_last_event_text, case_assigned_to_datetime, case_assigned_to_date, case_assigned_to_time, case_assigned_to_date_saying, case_assigned_to_date_ddmmyy, case_assigned_to_date_ddmmyyyy, case_assigned_to_user_id, case_assigned_to_user_name, case_assigned_to_user_alias, case_assigned_to_user_email, case_assigned_to_user_image_path, case_assigned_to_user_image_file, case_assigned_to_user_image_thumb_40, case_assigned_to_user_image_thumb_50, case_assigned_to_user_first_name, case_assigned_to_user_middle_name, case_assigned_to_user_last_name, case_created_datetime, case_created_date, case_created_time, case_created_date_saying, case_created_date_ddmmyy, case_created_date_ddmmyyyy, case_created_user_id, case_created_user_name, case_created_user_alias, case_created_user_email, case_created_user_image_path, case_created_user_image_file, case_created_user_image_thumb_40, case_created_user_image_thumb_50, case_created_user_first_name, case_created_user_middle_name, case_created_user_last_name, case_detective_user_id, case_detective_user_job_title, case_detective_user_department, case_detective_user_first_name, case_detective_user_middle_name, case_detective_user_last_name, case_detective_user_name, case_detective_user_alias, case_detective_user_email, case_detective_email_alerts, case_detective_user_image_path, case_detective_user_image_file, case_detective_user_image_thumb_40, case_detective_user_image_thumb_50, case_updated_datetime, case_updated_date, case_updated_time, case_updated_date_saying, case_updated_date_ddmmyy, case_updated_date_ddmmyyyy, case_updated_user_id, case_updated_user_name, case_updated_user_alias, case_updated_user_email, case_updated_user_image_path, case_updated_user_image_file, case_updated_user_image_thumb_40, case_updated_user_image_thumb_50, case_updated_user_first_name, case_updated_user_middle_name, case_updated_user_last_name, case_is_closed, case_closed_datetime, case_closed_date, case_closed_time, case_closed_date_saying, case_closed_date_ddmmyy, case_closed_date_ddmmyyyy, case_time_from_created_to_close FROM $t_edb_case_index WHERE case_id=$case_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_case_id, $get_current_case_number, $get_current_case_title, $get_current_case_title_clean, $get_current_case_suspect_in_custody, $get_current_case_code_id, $get_current_case_code_number, $get_current_case_code_title, $get_current_case_status_id, $get_current_case_status_title, $get_current_case_priority_id, $get_current_case_priority_title, $get_current_case_district_id, $get_current_case_district_title, $get_current_case_station_id, $get_current_case_station_title, $get_current_case_is_screened, $get_current_case_physical_location, $get_current_case_backup_disks, $get_current_case_confirmed_by_human, $get_current_case_human_rejected, $get_current_case_last_event_text, $get_current_case_assigned_to_datetime, $get_current_case_assigned_to_date, $get_current_case_assigned_to_time, $get_current_case_assigned_to_date_saying, $get_current_case_assigned_to_date_ddmmyy, $get_current_case_assigned_to_date_ddmmyyyy, $get_current_case_assigned_to_user_id, $get_current_case_assigned_to_user_name, $get_current_case_assigned_to_user_alias, $get_current_case_assigned_to_user_email, $get_current_case_assigned_to_user_image_path, $get_current_case_assigned_to_user_image_file, $get_current_case_assigned_to_user_image_thumb_40, $get_current_case_assigned_to_user_image_thumb_50, $get_current_case_assigned_to_user_first_name, $get_current_case_assigned_to_user_middle_name, $get_current_case_assigned_to_user_last_name, $get_current_case_created_datetime, $get_current_case_created_date, $get_current_case_created_time, $get_current_case_created_date_saying, $get_current_case_created_date_ddmmyy, $get_current_case_created_date_ddmmyyyy, $get_current_case_created_user_id, $get_current_case_created_user_name, $get_current_case_created_user_alias, $get_current_case_created_user_email, $get_current_case_created_user_image_path, $get_current_case_created_user_image_file, $get_current_case_created_user_image_thumb_40, $get_current_case_created_user_image_thumb_50, $get_current_case_created_user_first_name, $get_current_case_created_user_middle_name, $get_current_case_created_user_last_name, $get_current_case_detective_user_id, $get_current_case_detective_user_job_title, $get_current_case_detective_user_department, $get_current_case_detective_user_first_name, $get_current_case_detective_user_middle_name, $get_current_case_detective_user_last_name, $get_current_case_detective_user_name, $get_current_case_detective_user_alias, $get_current_case_detective_user_email, $get_current_case_detective_email_alerts, $get_current_case_detective_user_image_path, $get_current_case_detective_user_image_file, $get_current_case_detective_user_image_thumb_40, $get_current_case_detective_user_image_thumb_50, $get_current_case_updated_datetime, $get_current_case_updated_date, $get_current_case_updated_time, $get_current_case_updated_date_saying, $get_current_case_updated_date_ddmmyy, $get_current_case_updated_date_ddmmyyyy, $get_current_case_updated_user_id, $get_current_case_updated_user_name, $get_current_case_updated_user_alias, $get_current_case_updated_user_email, $get_current_case_updated_user_image_path, $get_current_case_updated_user_image_file, $get_current_case_updated_user_image_thumb_40, $get_current_case_updated_user_image_thumb_50, $get_current_case_updated_user_first_name, $get_current_case_updated_user_middle_name, $get_current_case_updated_user_last_name, $get_current_case_is_closed, $get_current_case_closed_datetime, $get_current_case_closed_date, $get_current_case_closed_time, $get_current_case_closed_date_saying, $get_current_case_closed_date_ddmmyy, $get_current_case_closed_date_ddmmyyyy, $get_current_case_time_from_created_to_close) = $row;


	if($get_current_case_id == ""){
		echo"<h1>Server error 404</h1><p>Case not found</p>";
		die;
	}
	else{
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
			$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_parent_item_id, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_in_date_ddmmyyyy, item_storage_shelf_id, item_storage_shelf_title, item_storage_location_id, item_storage_location_abbr, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_name, item_timezone, item_date_now_date, item_date_now_saying, item_date_now_ddmmyy, item_date_now_ddmmyyyy, item_time_now, item_correct_date_now_date, item_correct_date_now_saying, item_correct_date_now_ddmmyy, item_correct_date_now_ddmmyyyy, item_correct_time_now, item_adjust_clock_automatically, item_adjust_time_zone_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_date_ddmmyyyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy, item_out_date_ddmmyyyy, item_out_notes FROM $t_edb_case_index_evidence_items WHERE item_id=$item_id_mysql AND item_case_id=$get_current_case_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_item_id, $get_current_item_case_id, $get_current_item_record_id, $get_current_item_record_seized_year, $get_current_item_record_seized_journal, $get_current_item_record_seized_district_number, $get_current_item_numeric_serial_number, $get_current_item_title, $get_current_item_parent_item_id, $get_current_item_type_id, $get_current_item_type_title, $get_current_item_confirmed_by_human, $get_current_item_human_rejected, $get_current_item_request_text, $get_current_item_requester_user_id, $get_current_item_requester_user_name, $get_current_item_requester_user_alias, $get_current_item_requester_user_email, $get_current_item_requester_user_image_path, $get_current_item_requester_user_image_file, $get_current_item_requester_user_image_thumb_40, $get_current_item_requester_user_image_thumb_50, $get_current_item_requester_user_first_name, $get_current_item_requester_user_middle_name, $get_current_item_requester_user_last_name, $get_current_item_requester_user_job_title, $get_current_item_requester_user_department, $get_current_item_in_datetime, $get_current_item_in_date, $get_current_item_in_time, $get_current_item_in_date_saying, $get_current_item_in_date_ddmmyy, $get_current_item_in_date_ddmmyyyy, $get_current_item_storage_shelf_id, $get_current_item_storage_shelf_title, $get_current_item_storage_location_id, $get_current_item_storage_location_abbr, $get_current_item_comment, $get_current_item_condition, $get_current_item_serial_number, $get_current_item_imei_a, $get_current_item_imei_b, $get_current_item_imei_c, $get_current_item_imei_d, $get_current_item_os_title, $get_current_item_os_version, $get_current_item_name, $get_current_item_timezone, $get_current_item_date_now_date, $get_current_item_date_now_saying, $get_current_item_date_now_ddmmyy, $get_current_item_date_now_ddmmyyyy, $get_current_item_time_now, $get_current_item_correct_date_now_date, $get_current_item_correct_date_now_saying, $get_current_item_correct_date_now_ddmmyy, $get_current_item_correct_date_now_ddmmyyyy, $get_current_item_correct_time_now, $get_current_item_adjust_clock_automatically, $get_current_item_adjust_time_zone_automatically, $get_current_item_acquired_software_id_a, $get_current_item_acquired_software_title_a, $get_current_item_acquired_software_notes_a, $get_current_item_acquired_software_id_b, $get_current_item_acquired_software_title_b, $get_current_item_acquired_software_notes_b, $get_current_item_acquired_software_id_c, $get_current_item_acquired_software_title_c, $get_current_item_acquired_software_notes_c, $get_current_item_acquired_date, $get_current_item_acquired_time, $get_current_item_acquired_date_saying, $get_current_item_acquired_date_ddmmyy, $get_current_item_acquired_date_ddmmyyyy, $get_current_item_acquired_user_id, $get_current_item_acquired_user_name, $get_current_item_acquired_user_alias, $get_current_item_acquired_user_email, $get_current_item_acquired_user_image_path, $get_current_item_acquired_user_image_file, $get_current_item_acquired_user_image_thumb_40, $get_current_item_acquired_user_image_thumb_50, $get_current_item_acquired_user_first_name, $get_current_item_acquired_user_middle_name, $get_current_item_acquired_user_last_name, $get_current_item_out_date, $get_current_item_out_time, $get_current_item_out_date_saying, $get_current_item_out_date_ddmmyy, $get_current_item_out_date_ddmmyyyy, $get_current_item_out_notes) = $row;
	

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
					
				// Item type
				if($get_current_item_type_id == ""){
					$query = "SELECT item_type_id, item_type_title, item_type_image_path, item_type_image_file, item_type_has_hard_disks, item_type_has_sim_cards, item_type_has_sd_cards, item_type_has_networks FROM $t_edb_item_types LIMIT 0,1";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_current_item_type_id, $get_current_item_type_title, $get_current_item_type_image_path, $get_current_item_type_image_file, $get_current_item_type_has_hard_disks, $get_current_item_type_has_sim_cards, $get_current_item_type_has_sd_cards, $get_current_item_type_has_networks) = $row;
				}
				else{
					$query = "SELECT item_type_id, item_type_title, item_type_image_path, item_type_image_file, item_type_has_hard_disks, item_type_has_sim_cards, item_type_has_sd_cards, item_type_has_networks FROM $t_edb_item_types WHERE item_type_id=$get_current_item_type_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_current_item_type_id, $get_current_item_type_title, $get_current_item_type_image_path, $get_current_item_type_image_file, $get_current_item_type_has_hard_disks, $get_current_item_type_has_sim_cards, $get_current_item_type_has_sd_cards, $get_current_item_type_has_networks) = $row;
				}

				if($process == "1" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor")){
					// Dates
					$datetime = date("Y-m-d H:i:s");
					$date_saying = date("j. M Y");
					$time = time();

					// 1. General
					$inp_title = $_POST['inp_title'];
					$inp_title = output_html($inp_title);
					$inp_title_mysql = quote_smart($link, $inp_title);
					
					$inp_item_type_id = $_POST['inp_item_type_id'];
					$inp_item_type_id = output_html($inp_item_type_id);
					$inp_item_type_id_mysql = quote_smart($link, $inp_item_type_id);
					// Find that item type
					$query = "SELECT item_type_id, item_type_title FROM $t_edb_item_types WHERE item_type_id=$inp_item_type_id_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_item_type_id, $get_item_type_title) = $row;
						
					if($get_item_type_id == ""){
						$get_item_type_id = "0";
					}
					$inp_item_type_title_mysql = quote_smart($link, $get_item_type_title);
					
					$inp_comment = $_POST['inp_comment'];
					$inp_comment = output_html($inp_comment);
					$inp_comment_mysql = quote_smart($link, $inp_comment);
					
					$inp_condition = $_POST['inp_condition'];
					$inp_condition = output_html($inp_condition);
					$inp_condition_mysql = quote_smart($link, $inp_condition);
						
					$inp_serial_number = $_POST['inp_serial_number'];
					$inp_serial_number = output_html($inp_serial_number);
					$inp_serial_number_mysql = quote_smart($link, $inp_serial_number);
	
					$inp_os_title = $_POST['inp_os_title'];
					$inp_os_title = output_html($inp_os_title);
					$inp_os_title_mysql = quote_smart($link, $inp_os_title);

					$inp_os_version = $_POST['inp_os_version'];
					$inp_os_version = output_html($inp_os_version);
					$inp_os_version_mysql = quote_smart($link, $inp_os_version);

					// Storage
					$inp_storage = $_POST['inp_storage'];
					$inp_storage = output_html($inp_storage);
					if($inp_storage != ""){
						$storage_location_abbr = strstr($inp_storage, '(');
						$storage_location_abbr = str_replace("(", "", $storage_location_abbr);
						$storage_location_abbr = str_replace(")", "", $storage_location_abbr);

						// Storage Location (Norwegian: Lager)
						if($storage_location_abbr != ""){
							$storage_location_abbr_mysql = quote_smart($link, $storage_location_abbr);
							$query = "SELECT storage_location_id, storage_location_title, storage_location_abbr, storage_location_station_id FROM $t_edb_evidence_storage_locations WHERE storage_location_abbr=$storage_location_abbr_mysql";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_storage_location_id, $get_storage_location_title, $get_storage_location_abbr, $get_storage_location_station_id) = $row;

							if($get_storage_location_id == ""){
									
								$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
											item_storage_location_id=NULL,
											item_storage_location_abbr=NULL
											 WHERE item_id=$get_current_item_id") or die(mysqli_error($link));
							}
							else{
								$inp_storage_location_abbr_mysql = quote_smart($link, $get_storage_location_abbr);
								$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
												item_storage_location_id=$get_storage_location_id, 
												item_storage_location_abbr=$inp_storage_location_abbr_mysql
												 WHERE item_id=$get_current_item_id") or die(mysqli_error($link));
							}
						
		
							// Shelve
							$storage_shelf_full_name = str_replace("($storage_location_abbr)", "", $inp_storage); 
							$storage_shelf_full_name_mysql = quote_smart($link, $storage_shelf_full_name);
	
							if($storage_shelf_full_name != "" && $get_storage_location_station_id != "" && $get_storage_location_id != ""){
								$query = "SELECT shelf_id, shelf_full_name FROM $t_edb_evidence_storage_shelves WHERE shelf_full_name=$storage_shelf_full_name_mysql AND shelf_station_id=$get_storage_location_station_id AND shelf_storage_location_id=$get_storage_location_id";
								$result = mysqli_query($link, $query);
								$row = mysqli_fetch_row($result);
								list($get_shelf_id, $get_shelf_full_name) = $row;

	
								if($get_shelf_id == ""){
									$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
										item_storage_shelf_id=NULL,
										item_storage_shelf_title=NULL
										 WHERE item_id=$get_current_item_id") or die(mysqli_error($link));
							
								}
								else{
									$inp_shelf_full_name_mysql = quote_smart($link, $get_shelf_full_name);
									$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
											item_storage_shelf_id=$get_shelf_id, 
											item_storage_shelf_title=$inp_shelf_full_name_mysql
											 WHERE item_id=$get_current_item_id") or die(mysqli_error($link));
								}
							}
						} // if($storage_location_abbr != ""){
					} // Storage

					// Parent
					$inp_parent_item_id = $_POST['inp_parent_item_id'];
					$inp_parent_item_id = output_html($inp_parent_item_id);
					$inp_parent_item_id_mysql = quote_smart($link, $inp_parent_item_id);

					// Date and time
					$inp_item_timezone = $_POST['inp_item_timezone'];
					$inp_item_timezone = output_html($inp_item_timezone);
					$inp_item_timezone_mysql = quote_smart($link, $inp_item_timezone);

						$inp_date_now_date = $_POST['inp_date_now_date'];
						$inp_date_now_date = output_html($inp_date_now_date);
						$inp_date_now_date_mysql = quote_smart($link, $inp_date_now_date);
						$inp_date_now_date_len = strlen($inp_date_now_date);
						if($inp_date_now_date_len == "10"){
							$y = substr($inp_date_now_date, 0, 4);
							$m = substr($inp_date_now_date, 5, 2);
							$d = substr($inp_date_now_date, 8, 2);

							$inp_date_now_ddmmyy = $d . "." . $m . "." . substr($y, 2, 2);
							$inp_date_now_ddmmyy_mysql = quote_smart($link, $inp_date_now_ddmmyy);

							$inp_date_now_ddmmyyyy = $d . "." . $m . "." . $y;
							$inp_date_now_ddmmyyyy_mysql = quote_smart($link, $inp_date_now_ddmmyyyy);

							$result = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
									item_date_now_date=$inp_date_now_date_mysql,
									item_date_now_ddmmyy=$inp_date_now_ddmmyy_mysql,
									item_date_now_ddmmyyyy=$inp_date_now_ddmmyyyy_mysql
									 WHERE item_id=$get_current_item_id") or die(mysqli_error($link));
					}
					else{
							$result = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
									item_date_now_date=NULL,
									item_date_now_ddmmyy=NULL,
									item_date_now_ddmmyyyy=NULL
								 WHERE item_id=$get_current_item_id") or die(mysqli_error($link));
					}

					$inp_time_now = $_POST['inp_time_now'];
					$inp_time_now = output_html($inp_time_now);
					$inp_time_now_mysql = quote_smart($link, $inp_time_now);

					$inp_correct_date_now_date = $_POST['inp_correct_date_now_date'];
					$inp_correct_date_now_date = output_html($inp_correct_date_now_date);
					$inp_correct_date_now_date_mysql = quote_smart($link, $inp_correct_date_now_date);
					$inp_correct_date_now_date_len = strlen($inp_correct_date_now_date);
					if($inp_correct_date_now_date_len == "10"){
							$y = substr($inp_correct_date_now_date, 0, 4);
							$m = substr($inp_correct_date_now_date, 5, 2);
							$d = substr($inp_correct_date_now_date, 8, 2);

							$inp_correct_date_now_ddmmyy = $d . "." . $m . "." . substr($y, 2, 2);
							$inp_correct_date_now_ddmmyy_mysql = quote_smart($link, $inp_correct_date_now_ddmmyy);

							$inp_correct_date_now_ddmmyyyy = $d . "." . $m . "." . $y;
							$inp_correct_date_now_ddmmyyyy_mysql = quote_smart($link, $inp_correct_date_now_ddmmyyyy);

							$result = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
									item_correct_date_now_date=$inp_correct_date_now_date_mysql,
									item_correct_date_now_ddmmyy=$inp_correct_date_now_ddmmyy_mysql,
									item_correct_date_now_ddmmyyyy=$inp_correct_date_now_ddmmyyyy_mysql
									 WHERE item_id=$get_current_item_id") or die(mysqli_error($link));
					}
					else{
							$result = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
									item_date_now_date=NULL,
									item_date_now_ddmmyy=NULL,
									item_correct_date_now_ddmmyyyy=NULL
									 WHERE item_id=$get_current_item_id") or die(mysqli_error($link));
					}

					$inp_correct_time_now = $_POST['inp_correct_time_now'];
					$inp_correct_time_now = output_html($inp_correct_time_now);
					$inp_correct_time_now_mysql = quote_smart($link, $inp_correct_time_now);

					$inp_adjust_clock_automatically = $_POST['inp_adjust_clock_automatically'];
					$inp_adjust_clock_automatically = output_html($inp_adjust_clock_automatically);
					$inp_adjust_clock_automatically_mysql = quote_smart($link, $inp_adjust_clock_automatically);

					$inp_adjust_time_zone_automatically = $_POST['inp_adjust_time_zone_automatically'];
					$inp_adjust_time_zone_automatically = output_html($inp_adjust_time_zone_automatically);
					$inp_adjust_time_zone_automatically_mysql = quote_smart($link, $inp_adjust_time_zone_automatically);



					$result = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
									item_title=$inp_title_mysql, 
									item_parent_item_id=$inp_parent_item_id_mysql, 
									item_type_id=$get_item_type_id, 
									item_type_title=$inp_item_type_title_mysql, 
									item_comment=$inp_comment_mysql ,
									item_condition=$inp_condition_mysql,
									item_serial_number=$inp_serial_number_mysql,
									item_os_title=$inp_os_title_mysql,
									item_os_version=$inp_os_version_mysql,
									item_timezone=$inp_item_timezone_mysql,
									item_time_now=$inp_time_now_mysql,
									item_correct_time_now=$inp_correct_time_now_mysql,
									item_adjust_clock_automatically=$inp_adjust_clock_automatically_mysql, 
									item_adjust_time_zone_automatically=$inp_adjust_time_zone_automatically_mysql 
									 WHERE item_id=$get_current_item_id") or die(mysqli_error($link));
					
		
					// Passwords existing
					$ping_new_passwords = 0;
					$datetime = date("Y-m-d H:i:s");
					$inp_my_user_name_mysql = quote_smart($link, $get_my_station_member_user_name);

					$query_set = "SELECT DISTINCT(password_set_number) FROM $t_edb_case_index_evidence_items_passwords WHERE password_case_id=$get_current_case_id AND password_item_id=$get_current_item_id";
					$result_set = mysqli_query($link, $query_set);
					while($row_set = mysqli_fetch_row($result_set)) {
						list($get_current_password_set_number) = $row_set;
		
						$query_av = "SELECT available_id, available_item_type_id, available_title, available_type, available_size, available_last_updated_datetime, available_last_updated_user_id FROM $t_edb_item_types_available_passwords WHERE available_item_type_id=$get_current_item_type_id";
						$result_av = mysqli_query($link, $query_av);
						while($row_av = mysqli_fetch_row($result_av)) {
							list($get_available_id, $get_available_item_type_id, $get_available_title, $get_available_type, $get_available_size, $get_available_last_updated_datetime, $get_available_last_updated_user_id) = $row_av;
							
							

							if($get_available_type != "unlock_pattern"){
								// Fetch data
								$query_psw = "SELECT password_id, password_case_id, password_item_id, password_available_id, password_item_type_id, password_set_number, password_value, password_created_by_user_id, password_created_by_user_name, password_created_datetime, password_updated_by_user_id, password_updated_by_user_name, password_updated_datetime FROM $t_edb_case_index_evidence_items_passwords WHERE password_case_id=$get_current_case_id AND password_item_id=$get_current_item_id AND password_available_id=$get_available_id AND password_item_type_id=$get_available_item_type_id AND password_set_number=$get_current_password_set_number";
								$result_psw = mysqli_query($link, $query_psw);
								$row_psw = mysqli_fetch_row($result_psw);
								list($get_password_id, $get_password_case_id, $get_password_item_id, $get_password_available_id, $get_password_item_type_id, $get_password_set_number, $get_password_value, $get_password_created_by_user_id, $get_password_created_by_user_name, $get_password_created_datetime, $get_password_updated_by_user_id, $get_password_updated_by_user_name, $get_password_updated_datetime) = $row_psw;
								if($get_password_id == ""){
									echo"password_id NOT FOUND!!"; die;
								}

								$inp_password_value = $_POST["inp_password_value_$get_password_id"];
								$inp_password_value = output_html($inp_password_value);
								$inp_password_value_mysql = quote_smart($link, $inp_password_value);

								$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items_passwords SET 
												password_value=$inp_password_value_mysql, 
												password_updated_by_user_id=$my_user_id_mysql, 
												password_updated_by_user_name=$inp_my_user_name_mysql, 
												password_updated_datetime='$datetime'
												WHERE password_id=$get_password_id");


								if($inp_password_value != "$get_password_value"){


									// Most used passwords
	  								$inp_available_title_mysql = quote_smart($link, $get_available_title);
	   								$inp_available_title_clean = clean($get_available_title);
	  								$inp_available_title_clean_mysql = quote_smart($link, $inp_available_title_clean);

									// Most used passwords
									$query_most = "SELECT password_id, password_count FROM $t_edb_most_used_passwords WHERE password_available_id=$get_available_id AND password_item_type_id=$get_available_item_type_id AND password_pass=$inp_password_value_mysql";
									$result_most = mysqli_query($link, $query_most);
									$row_most = mysqli_fetch_row($result_most);
									list($get_password_id, $get_password_count) = $row_most;
									if($get_password_id == ""){
										mysqli_query($link, "INSERT INTO $t_edb_most_used_passwords 
										(password_id, password_available_id, password_available_title, password_available_title_clean, password_item_type_id, password_pass, password_count, password_first_used_datetime, password_first_used_time, password_first_used_saying, password_last_used_datetime, password_last_used_time, password_last_used_saying) 
										VALUES 
										(NULL, $get_available_id, $inp_available_title_mysql, $inp_available_title_clean_mysql, $get_available_item_type_id, $inp_password_value_mysql, 1, '$datetime', '$time', '$date_saying', '$datetime', '$time', '$date_saying')")
										or die(mysqli_error($link));
									}
									else{
										$inp_password_count = $get_password_count+1;
										$result_update = mysqli_query($link, "UPDATE $t_edb_most_used_passwords SET password_available_title=$inp_available_title_mysql, password_available_title_clean=$inp_available_title_clean_mysql, password_count=$inp_password_count, password_last_used_datetime='$datetime', password_last_used_time='$time', password_last_used_saying='$date_saying' WHERE password_id=$get_password_id") or die(mysqli_error($link));
									}
							
									// Ping new passwords
									$ping_new_passwords = 1;
								}
							} // type not unlock_pattern
						} // available
					} // DISTINCT(password_set_number)
					if($ping_new_passwords == "1"){
						include("open_case_evidence_edit_evidence_item_item_ping_new_passwords.php");
					}


					// Hard disks
					if($get_current_item_type_has_hard_disks == "1"){
							$query = "SELECT hard_disk_id, hard_disk_case_id, hard_disk_record_id, hard_disk_item_id, hard_disk_manufacturer, hard_disk_type, hard_disk_size, hard_disk_serial, hard_disk_comments FROM $t_edb_case_index_evidence_items_hard_disks WHERE hard_disk_case_id=$get_current_case_id AND hard_disk_item_id=$get_current_item_id";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_hard_disk_id, $get_hard_disk_case_id, $get_hard_disk_record_id, $get_hard_disk_item_id, $get_hard_disk_manufacturer, $get_hard_disk_type, $get_hard_disk_size, $get_hard_disk_serial, $get_hard_disk_comments) = $row;


								$inp_hard_disk_manufacturer = $_POST["inp_hard_disk_manufacturer_$get_hard_disk_id"];
								$inp_hard_disk_manufacturer = output_html($inp_hard_disk_manufacturer);
								$inp_hard_disk_manufacturer_mysql = quote_smart($link, $inp_hard_disk_manufacturer);

								$inp_hard_disk_type = $_POST["inp_hard_disk_type_$get_hard_disk_id"];
								$inp_hard_disk_type = output_html($inp_hard_disk_type);
								$inp_hard_disk_type_mysql = quote_smart($link, $inp_hard_disk_type);

								$inp_hard_disk_size = $_POST["inp_hard_disk_size_$get_hard_disk_id"];
								$inp_hard_disk_size = output_html($inp_hard_disk_size);
								$inp_hard_disk_size_mysql = quote_smart($link, $inp_hard_disk_size);

								$inp_hard_disk_serial = $_POST["inp_hard_disk_serial_$get_hard_disk_id"];
								$inp_hard_disk_serial = output_html($inp_hard_disk_serial);
								$inp_hard_disk_serial_mysql = quote_smart($link, $inp_hard_disk_serial);

								$inp_hard_disk_comments = $_POST["inp_hard_disk_comments_$get_hard_disk_id"];
								$inp_hard_disk_comments = output_html($inp_hard_disk_comments);
								$inp_hard_disk_comments_mysql = quote_smart($link, $inp_hard_disk_comments);

								if(isset($_POST["inp_hard_disk_delete_$get_hard_disk_id"])){
									$inp_hard_disk_delete = $_POST["inp_hard_disk_delete_$get_hard_disk_id"];
								}
								else{
									$inp_hard_disk_delete = "off";
								}
								if($inp_hard_disk_delete == "on"){
									$result_delete = mysqli_query($link, "DELETE FROM $t_edb_case_index_evidence_items_hard_disks WHERE hard_disk_id=$get_hard_disk_id");
								}
								else{
									$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items_hard_disks SET
													hard_disk_manufacturer=$inp_hard_disk_manufacturer_mysql,
												 	hard_disk_type=$inp_hard_disk_type_mysql,
												 	hard_disk_size=$inp_hard_disk_size_mysql,
												 	hard_disk_serial=$inp_hard_disk_serial_mysql,
												 	hard_disk_comments=$inp_hard_disk_comments_mysql
												 WHERE hard_disk_id=$get_hard_disk_id") or die(mysqli_error($link));
								}


						} // while hard_disk
						// Add 1 hard disk
						for($x=0;$x<2;$x++){
							
								$inp_hard_disk_manufacturer = $_POST["inp_hard_disk_manufacturer_new_$x"];
								$inp_hard_disk_manufacturer = output_html($inp_hard_disk_manufacturer);
								$inp_hard_disk_manufacturer_mysql = quote_smart($link, $inp_hard_disk_manufacturer);

								$inp_hard_disk_type = $_POST["inp_hard_disk_type_new_$x"];
								$inp_hard_disk_type = output_html($inp_hard_disk_type);
								$inp_hard_disk_type_mysql = quote_smart($link, $inp_hard_disk_type);

								$inp_hard_disk_size = $_POST["inp_hard_disk_size_new_$x"];
								$inp_hard_disk_size = output_html($inp_hard_disk_size);
								$inp_hard_disk_size_mysql = quote_smart($link, $inp_hard_disk_size);

								$inp_hard_disk_serial = $_POST["inp_hard_disk_serial_new_$x"];
								$inp_hard_disk_serial = output_html($inp_hard_disk_serial);
								$inp_hard_disk_serial_mysql = quote_smart($link, $inp_hard_disk_serial);

								$inp_hard_disk_comments = $_POST["inp_hard_disk_comments_new_$x"];
								$inp_hard_disk_comments = output_html($inp_hard_disk_comments);
								$inp_hard_disk_comments_mysql = quote_smart($link, $inp_hard_disk_comments);


								if($inp_hard_disk_manufacturer != "" OR $inp_hard_disk_type != "" OR $inp_hard_disk_size != "" OR $inp_hard_disk_serial != "" OR $inp_hard_disk_comments != ""){
									mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_items_hard_disks
									(hard_disk_id, hard_disk_case_id, hard_disk_record_id, hard_disk_item_id, hard_disk_manufacturer, hard_disk_type, hard_disk_size, hard_disk_serial, hard_disk_comments) 
									VALUES 
									(NULL, $get_current_case_id, $get_current_item_record_id, $get_current_item_id, $inp_hard_disk_manufacturer_mysql, $inp_hard_disk_type_mysql, $inp_hard_disk_size_mysql, $inp_hard_disk_serial_mysql, $inp_hard_disk_comments_mysql)")
									or die(mysqli_error($link));
								}
							}
					} // item has hard disks

					// Sim cards
					if($get_current_item_type_has_sim_cards == "1"){
							// Existing
						$query = "SELECT sim_card_id, sim_card_case_id, sim_card_record_id, sim_card_item_id, sim_card_imei, sim_card_iccid, sim_card_imsi, sim_card_phone_number, sim_card_pin, sim_card_puc, sim_card_operator, sim_card_comments FROM $t_edb_case_index_evidence_items_sim_cards WHERE sim_card_case_id=$get_current_case_id AND sim_card_item_id=$get_current_item_id";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_sim_card_id, $get_sim_card_case_id, $get_sim_card_record_id, $get_sim_card_item_id, $get_sim_card_imei, $get_sim_card_iccid, $get_sim_card_imsi, $get_sim_card_phone_number, $get_sim_card_pin, $get_sim_card_puc, $get_sim_card_operator, $get_sim_card_comments) = $row;

								$inp_sim_card_imei = $_POST["inp_sim_card_imei_$get_sim_card_id"];
								$inp_sim_card_imei = output_html($inp_sim_card_imei);
								$inp_sim_card_imei_mysql = quote_smart($link, $inp_sim_card_imei);

								$inp_sim_card_iccid = $_POST["inp_sim_card_iccid_$get_sim_card_id"];
								$inp_sim_card_iccid = output_html($inp_sim_card_iccid);
								$inp_sim_card_iccid_mysql = quote_smart($link, $inp_sim_card_iccid);

								$inp_sim_card_imsi = $_POST["inp_sim_card_imsi_$get_sim_card_id"];
								$inp_sim_card_imsi = output_html($inp_sim_card_imsi);
								$inp_sim_card_imsi_mysql = quote_smart($link, $inp_sim_card_imsi);
	
								$inp_sim_card_phone_number = $_POST["inp_sim_card_phone_number_$get_sim_card_id"];
								$inp_sim_card_phone_number = output_html($inp_sim_card_phone_number);
								$inp_sim_card_phone_number_mysql = quote_smart($link, $inp_sim_card_phone_number);

								$inp_sim_card_pin = $_POST["inp_sim_card_pin_$get_sim_card_id"];
								$inp_sim_card_pin = output_html($inp_sim_card_pin);
								$inp_sim_card_pin_mysql = quote_smart($link, $inp_sim_card_pin);

								$inp_sim_card_puc = $_POST["inp_sim_card_puc_$get_sim_card_id"];
								$inp_sim_card_puc = output_html($inp_sim_card_puc);
								$inp_sim_card_puc_mysql = quote_smart($link, $inp_sim_card_puc);

								$inp_sim_card_operator = $_POST["inp_sim_card_operator_$get_sim_card_id"];
								$inp_sim_card_operator = output_html($inp_sim_card_operator);
								$inp_sim_card_operator_mysql = quote_smart($link, $inp_sim_card_operator);

								$inp_sim_card_comment = $_POST["inp_sim_card_comment_$get_sim_card_id"];
								$inp_sim_card_comment = output_html($inp_sim_card_comment);
								$inp_sim_card_comment_mysql = quote_smart($link, $inp_sim_card_comment);

								if(isset($_POST["inp_sim_card_delete_$get_sim_card_id"])){
									$inp_sim_card_delete = $_POST["inp_sim_card_delete_$get_sim_card_id"];
								}
								else{
									$inp_sim_card_delete = "off";
								}
								if($inp_sim_card_delete == "on"){
									$result_delete = mysqli_query($link, "DELETE FROM $t_edb_case_index_evidence_items_sim_cards WHERE sim_card_id=$get_sim_card_id");
								}
								else{
									$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items_sim_cards SET
													sim_card_imei=$inp_sim_card_imei_mysql,
													sim_card_iccid=$inp_sim_card_iccid_mysql,
													sim_card_imsi=$inp_sim_card_imsi_mysql,
													sim_card_phone_number=$inp_sim_card_phone_number_mysql,
													sim_card_pin=$inp_sim_card_pin_mysql,
													sim_card_puc=$inp_sim_card_puc_mysql,
													sim_card_operator=$inp_sim_card_operator_mysql,
													sim_card_comments=$inp_sim_card_comment_mysql 
												 WHERE sim_card_id=$get_sim_card_id");
								}
							}


							// New
							for($x=0;$x<2;$x++){
								$inp_sim_card_imei = $_POST["inp_sim_card_imei_new_$x"];
								$inp_sim_card_imei = output_html($inp_sim_card_imei);
								$inp_sim_card_imei_mysql = quote_smart($link, $inp_sim_card_imei);
							
								$inp_sim_card_iccid = $_POST["inp_sim_card_iccid_new_$x"];
								$inp_sim_card_iccid = output_html($inp_sim_card_iccid);
								$inp_sim_card_iccid_mysql = quote_smart($link, $inp_sim_card_iccid);
							
								$inp_sim_card_imsi = $_POST["inp_sim_card_imsi_new_$x"];
								$inp_sim_card_imsi = output_html($inp_sim_card_imsi);
								$inp_sim_card_imsi_mysql = quote_smart($link, $inp_sim_card_imsi);
							
								$inp_sim_card_phone_number = $_POST["inp_sim_card_phone_number_new_$x"];
								$inp_sim_card_phone_number = output_html($inp_sim_card_phone_number);
								$inp_sim_card_phone_number_mysql = quote_smart($link, $inp_sim_card_phone_number);
							
								$inp_sim_card_pin = $_POST["inp_sim_card_pin_new_$x"];
								$inp_sim_card_pin = output_html($inp_sim_card_pin);
								$inp_sim_card_pin_mysql = quote_smart($link, $inp_sim_card_pin);
							
								$inp_sim_card_puc = $_POST["inp_sim_card_puc_new_$x"];
								$inp_sim_card_puc = output_html($inp_sim_card_puc);
								$inp_sim_card_puc_mysql = quote_smart($link, $inp_sim_card_puc);
							
								$inp_sim_card_operator = $_POST["inp_sim_card_operator_new_$x"];
								$inp_sim_card_operator = output_html($inp_sim_card_operator);
								$inp_sim_card_operator_mysql = quote_smart($link, $inp_sim_card_operator);
							
								$inp_sim_card_comment = $_POST["inp_sim_card_comment_new_$x"];
								$inp_sim_card_comment = output_html($inp_sim_card_comment);
								$inp_sim_card_comment_mysql = quote_smart($link, $inp_sim_card_comment);
							
								if($inp_sim_card_imei != "" OR $inp_sim_card_iccid != "" OR $inp_sim_card_imsi != "" OR $inp_sim_card_phone_number != "" OR $inp_sim_card_pin != "" OR $inp_sim_card_puc != "" OR $inp_sim_card_operator  != "" OR $inp_sim_card_comment != ""){
									mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_items_sim_cards
									(sim_card_id, sim_card_case_id, sim_card_record_id, sim_card_item_id, sim_card_imei, 
									sim_card_iccid, sim_card_imsi, sim_card_phone_number, sim_card_pin, sim_card_puc, 
									sim_card_operator, sim_card_comments) 
									VALUES 
									(NULL, $get_current_case_id, $get_current_item_record_id, $get_current_item_id, $inp_sim_card_imei_mysql, 
									$inp_sim_card_iccid_mysql, $inp_sim_card_imsi_mysql, $inp_sim_card_phone_number_mysql, $inp_sim_card_pin_mysql, $inp_sim_card_puc_mysql, 
									$inp_sim_card_operator_mysql, $inp_sim_card_comment_mysql)")
									or die(mysqli_error($link));
								}
							
							} // for
						} // $get_current_item_type_has_sim_card

						// SD card
						if($get_current_item_type_has_sd_cards == "1"){
							$query = "SELECT sd_card_id, sd_card_case_id, sd_card_record_id, sd_card_item_id, sd_card_manufacturer, sd_card_size, sd_card_serial, sd_card_comments FROM $t_edb_case_index_evidence_items_sd_cards WHERE sd_card_case_id=$get_current_case_id AND sd_card_item_id=$get_current_item_id";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_sd_card_id, $get_sd_card_case_id, $get_sd_card_record_id, $get_sd_card_item_id, $get_sd_card_manufacturer, $get_sd_card_size, $get_sd_card_serial, $get_sd_card_comments) = $row;


								$inp_sd_card_manufacturer = $_POST["inp_sd_card_manufacturer_$get_sd_card_id"];
								$inp_sd_card_manufacturer = output_html($inp_sd_card_manufacturer);
								$inp_sd_card_manufacturer_mysql = quote_smart($link, $inp_sd_card_manufacturer);

								$inp_sd_card_size = $_POST["inp_sd_card_size_$get_sd_card_id"];
								$inp_sd_card_size = output_html($inp_sd_card_size);
								$inp_sd_card_size_mysql = quote_smart($link, $inp_sd_card_size);

								$inp_sd_card_serial = $_POST["inp_sd_card_serial_$get_sd_card_id"];
								$inp_sd_card_serial = output_html($inp_sd_card_serial);
								$inp_sd_card_serial_mysql = quote_smart($link, $inp_sd_card_serial);

								$inp_sd_card_comments = $_POST["inp_sd_card_comments_$get_sd_card_id"];
								$inp_sd_card_comments = output_html($inp_sd_card_comments);
								$inp_sd_card_comments_mysql = quote_smart($link, $inp_sd_card_comments);

								if(isset($_POST["inp_sd_card_delete_$get_sd_card_id"])){
									$inp_sd_card_delete = $_POST["inp_sd_card_delete_$get_sd_card_id"];
								}
								else{
									$inp_sd_card_delete = "off";
								}
								if($inp_sd_card_delete == "on"){
									$result_delete = mysqli_query($link, "DELETE FROM $t_edb_case_index_evidence_items_sd_cards WHERE sd_card_id=$get_sd_card_id");
								}
								else{
									$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items_sd_cards SET
													sd_card_manufacturer=$inp_sd_card_manufacturer_mysql, 
													sd_card_size=$inp_sd_card_size_mysql, 
													sd_card_serial=$inp_sd_card_serial_mysql, 
													sd_card_comments=$inp_sd_card_comments_mysql 
												 WHERE  sd_card_id=$get_sd_card_id") or die(mysqli_error($link));
								}


							} // while sd cards
							// Add 1 sd card
							for($x=0;$x<2;$x++){
								

								$inp_sd_card_manufacturer = $_POST["inp_sd_card_manufacturer_new_$x"];
								$inp_sd_card_manufacturer = output_html($inp_sd_card_manufacturer);
								$inp_sd_card_manufacturer_mysql = quote_smart($link, $inp_sd_card_manufacturer);

								$inp_sd_card_size = $_POST["inp_sd_card_size_new_$x"];
								$inp_sd_card_size = output_html($inp_sd_card_size);
								$inp_sd_card_size_mysql = quote_smart($link, $inp_sd_card_size);

								$inp_sd_card_serial = $_POST["inp_sd_card_serial_new_$x"];
								$inp_sd_card_serial = output_html($inp_sd_card_serial);
								$inp_sd_card_serial_mysql = quote_smart($link, $inp_sd_card_serial);

								$inp_sd_card_comments = $_POST["inp_sd_card_comments_new_$x"];
								$inp_sd_card_comments = output_html($inp_sd_card_comments);
								$inp_sd_card_comments_mysql = quote_smart($link, $inp_sd_card_comments);

								if($inp_sd_card_manufacturer != "" OR $inp_sd_card_size != "" OR $inp_sd_card_serial != "" OR $inp_sd_card_comments != ""){
									mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_items_sd_cards
									(sd_card_id, sd_card_case_id, sd_card_record_id, sd_card_item_id, sd_card_manufacturer, sd_card_size, sd_card_serial, sd_card_comments) 
									VALUES 
									(NULL, $get_current_case_id, $get_current_item_record_id, $get_current_item_id, $inp_sd_card_manufacturer_mysql, $inp_sd_card_size_mysql, $inp_sd_card_serial_mysql, $inp_sd_card_comments_mysql)")
									or die(mysqli_error($link));
								}
							}
						} // item has sd card



						// Networks
						if($get_current_item_type_has_networks == "1"){
							
							$query = "SELECT network_id, network_case_id, network_record_id, network_item_id, network_is_wifi, network_manufacturer, network_card_title, network_mac, network_serial, network_comments FROM $t_edb_case_index_evidence_items_networks WHERE network_case_id=$get_current_case_id AND network_item_id=$get_current_item_id";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_network_id, $get_network_case_id, $get_network_record_id, $get_network_item_id, $get_network_is_wifi, $get_network_manufacturer, $get_network_card_title, $get_network_mac, $get_network_serial, $get_network_comments) = $row;


								if(isset($_POST["inp_network_is_wifi_$get_network_id"])){
									$inp_network_is_wifi = $_POST["inp_network_is_wifi_$get_network_id"];
								}
								else{
									$inp_network_is_wifi = "off";
								}
								if($inp_network_is_wifi == "on"){
									$inp_network_is_wifi = 1;
								}
								else{
									$inp_network_is_wifi = 0;
								}
								$inp_network_is_wifi_mysql = quote_smart($link, $inp_network_is_wifi);

								$inp_network_manufacturer = $_POST["inp_network_manufacturer_$get_network_id"];
								$inp_network_manufacturer = output_html($inp_network_manufacturer);
								$inp_network_manufacturer_mysql = quote_smart($link, $inp_network_manufacturer);

								$inp_network_card_title = $_POST["inp_network_card_title_$get_network_id"];
								$inp_network_card_title = output_html($inp_network_card_title);
								$inp_network_card_title_mysql = quote_smart($link, $inp_network_card_title);

								$inp_network_mac = $_POST["inp_network_mac_$get_network_id"];
								$inp_network_mac = output_html($inp_network_mac);
								$inp_network_mac_mysql = quote_smart($link, $inp_network_mac);

								$inp_network_serial = $_POST["inp_network_serial_$get_network_id"];
								$inp_network_serial = output_html($inp_network_serial);
								$inp_network_serial_mysql = quote_smart($link, $inp_network_serial);

								$inp_network_comments = $_POST["inp_network_comments_$get_network_id"];
								$inp_network_comments = output_html($inp_network_comments);
								$inp_network_comments_mysql = quote_smart($link, $inp_network_comments);

								if(isset($_POST["inp_network_delete_$get_network_id"])){
									$inp_network_delete = $_POST["inp_network_delete_$get_network_id"];
								}
								else{
									$inp_network_delete = "off";
								}
								if($inp_network_delete == "on"){
									$result_delete = mysqli_query($link, "DELETE FROM $t_edb_case_index_evidence_items_networks WHERE network_id=$get_network_id");
								}
								else{
									$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items_networks SET
														network_is_wifi=$inp_network_is_wifi_mysql,
														network_manufacturer=$inp_network_manufacturer_mysql, 
														network_card_title=$inp_network_card_title_mysql, 
														network_mac=$inp_network_mac_mysql,
														network_serial=$inp_network_serial_mysql, 
														network_comments=$inp_network_comments_mysql 
												 WHERE network_id=$get_network_id") or die(mysqli_error($link));
								}

							} // while networks

							// Add 1 network 
							for($x=0;$x<2;$x++){
							
								if(isset($_POST["inp_network_is_wifi_new_$x"])){
									$inp_network_is_wifi = $_POST["inp_network_is_wifi_new_$x"];
								}
								else{
									$inp_network_is_wifi = "off";
								}
								if($inp_network_is_wifi == "on"){
									$inp_network_is_wifi = 1;
								}
								else{
									$inp_network_is_wifi = 0;
								}
								$inp_network_is_wifi_mysql = quote_smart($link, $inp_network_is_wifi);

								$inp_network_manufacturer = $_POST["inp_network_manufacturer_new_$x"];
								$inp_network_manufacturer = output_html($inp_network_manufacturer);
								$inp_network_manufacturer_mysql = quote_smart($link, $inp_network_manufacturer);

								$inp_network_card_title = $_POST["inp_network_card_title_new_$x"];
								$inp_network_card_title = output_html($inp_network_card_title);
								$inp_network_card_title_mysql = quote_smart($link, $inp_network_card_title);

								$inp_network_mac = $_POST["inp_network_mac_new_$x"];
								$inp_network_mac = output_html($inp_network_mac);
								$inp_network_mac_mysql = quote_smart($link, $inp_network_mac);

								$inp_network_serial = $_POST["inp_network_serial_new_$x"];
								$inp_network_serial = output_html($inp_network_serial);
								$inp_network_serial_mysql = quote_smart($link, $inp_network_serial);

								$inp_network_comments = $_POST["inp_network_comments_new_$x"];
								$inp_network_comments = output_html($inp_network_comments);
								$inp_network_comments_mysql = quote_smart($link, $inp_network_comments);


								if($inp_network_manufacturer  != "" OR $inp_network_card_title != "" OR $inp_network_mac != "" OR $inp_network_serial != "" OR $inp_network_comments != ""){
									mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_items_networks
									(network_id, network_case_id, network_record_id, network_item_id, network_is_wifi, network_manufacturer, network_card_title, network_mac, network_serial, network_comments) 
									VALUES 
									(NULL, $get_current_case_id, $get_current_item_record_id, $get_current_item_id, $inp_network_is_wifi_mysql, $inp_network_manufacturer_mysql, $inp_network_card_title_mysql, $inp_network_mac_mysql, $inp_network_serial_mysql, $inp_network_comments_mysql)")
									or die(mysqli_error($link));
								}


							}
							echo"
								 </tbody>
								</table>
							";
					} // networks



					// Loop trough all items to redefine storage location (if changed)
					$physical_location = "";
					$query = "SELECT item_id, item_storage_shelf_id, item_storage_shelf_title, item_storage_location_id, item_storage_location_abbr FROM $t_edb_case_index_evidence_items WHERE item_case_id=$get_current_case_id ORDER BY item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_item_id, $get_item_storage_shelf_id, $get_item_storage_shelf_title, $get_item_storage_location_id, $get_item_storage_location_abbr) = $row;

						// Location
						if($physical_location == ""){
							$physical_location = "$get_item_storage_shelf_title ($get_item_storage_location_abbr)";
						}
						else{
							if($physical_location != "$get_item_storage_shelf_title $get_item_storage_location_abbr"){
								$array = explode("|", $physical_location);
								$found = false;
								for($x=0;$x<sizeof($array);$x++){
									$full_name = $array[$x];
									if($full_name == "$get_item_storage_shelf_title ($get_item_storage_location_abbr)"){
										$found = true;
										break;
									}
								}
								if($found == false){
									$physical_location = $physical_location . "|$get_item_storage_shelf_title ($get_item_storage_location_abbr)";
								}
							}
						}
					}
					if($get_current_case_physical_location != "$physical_location"){
						$input_physical_location = "";
						$array = explode("|", $physical_location);
						$array_size = sizeof($array);
						$array_size_last = $array_size -1;
						for($x=0;$x<sizeof($array);$x++){
							$full_name = trim($array[$x]);
							if($full_name != "" && $full_name != "()"){
						
								if($input_physical_location == ""){
									$input_physical_location = "$full_name";
								}
								else{
									if($x == "$array_size_last"){
										$input_physical_location = $input_physical_location . " $l_and_lowercase $full_name";
									}
									else{
										$input_physical_location = $input_physical_location . ", $full_name";
									}
								}
							}
						}
						$input_physical_location_mysql = quote_smart($link, $input_physical_location);
						$result = mysqli_query($link, "UPDATE $t_edb_case_index SET case_physical_location=$input_physical_location_mysql WHERE case_id=$get_current_case_id");
					}


					// Stats: Is the item type the same as before? If it is not, then we need to adjust statistics
					if($get_current_item_type_id != "$inp_item_type_id"){
						// Dates
						$year = date("Y");
						$month = date("m");

						// Item Type Stats: District
						$query_st = "SELECT stats_item_type_id, stats_item_type_counter FROM $t_edb_stats_item_types WHERE stats_item_type_year=$year AND stats_item_type_month=$month AND stats_item_type_district_id=$get_current_case_district_id AND stats_item_type_item_type_id=$get_item_type_id";
						$result_st = mysqli_query($link, $query_st);
						$row_st = mysqli_fetch_row($result_st);
						list($get_stats_item_type_id, $get_stats_item_type_counter) = $row_st;
						if($get_stats_item_type_id == ""){

							mysqli_query($link, "INSERT INTO $t_edb_stats_item_types 
									(stats_item_type_id, stats_item_type_year, stats_item_type_month, stats_item_type_district_id, stats_item_type_station_id, stats_item_type_user_id, stats_item_type_item_type_id, stats_item_type_item_type_title, stats_item_type_counter) 
									VALUES 
									(NULL, $year, $month, $get_current_case_district_id, NULL, NULL, $get_item_type_id, $inp_item_type_title_mysql, 1)")
									or die(mysqli_error($link));
						}
						else{
							$inp_stats_item_type_counter  = $get_stats_item_type_counter+1;
							$result_update = mysqli_query($link, "UPDATE $t_edb_stats_item_types SET 
											stats_item_type_counter=$inp_stats_item_type_counter  
											WHERE stats_item_type_id=$get_stats_item_type_id") or die(mysqli_error($link));
						}

						// Item Type Stats: Station
						$query_st = "SELECT stats_item_type_id, stats_item_type_counter FROM $t_edb_stats_item_types WHERE stats_item_type_year=$year AND stats_item_type_month=$month AND stats_item_type_station_id=$get_current_case_station_id AND stats_item_type_item_type_id=$get_item_type_id";
						$result_st = mysqli_query($link, $query_st);
						$row_st = mysqli_fetch_row($result_st);
						list($get_stats_item_type_id, $get_stats_item_type_counter) = $row_st;
						if($get_stats_item_type_id == ""){

							mysqli_query($link, "INSERT INTO $t_edb_stats_item_types 
									(stats_item_type_id, stats_item_type_year, stats_item_type_month, stats_item_type_district_id, stats_item_type_station_id, stats_item_type_user_id, stats_item_type_item_type_id, stats_item_type_item_type_title, stats_item_type_counter) 
									VALUES 
									(NULL, $year, $month, NULL, $get_current_case_station_id, NULL, $get_item_type_id, $inp_item_type_title_mysql, 1)")
									or die(mysqli_error($link));
						}
						else{
							$inp_stats_item_type_counter  = $get_stats_item_type_counter+1;
							$result_update = mysqli_query($link, "UPDATE $t_edb_stats_item_types SET 
											stats_item_type_counter=$inp_stats_item_type_counter  
											WHERE stats_item_type_id=$get_stats_item_type_id") or die(mysqli_error($link));
						}
					} // new type, write into statistics



					// Stats: 

					// Stats Requests :: Users and Department Item types
					if($get_current_item_type_id != "$inp_item_type_id" && $inp_item_type_id != "0" && $get_current_item_requester_user_id != ""){

						// Find requester location
						$query_r = "SELECT professional_id, professional_company_location FROM $t_users_professional WHERE professional_user_id=$get_current_item_requester_user_id";
						$result_r = mysqli_query($link, $query_r);
						$row_r = mysqli_fetch_row($result_r);
						list($get_professional_id, $get_professional_company_location) = $row_r;
							

						// Ready variables
						$date_yyyy = date("Y");
						$date_mm   = date("m");
						$inp_department_mysql = quote_smart($link, $get_current_item_requester_user_department);
						$inp_location_mysql = quote_smart($link, $get_professional_company_location);

						// Department Item types
						$query_d = "SELECT stats_dep_item_type_id, stats_dep_item_type_counter FROM $t_edb_stats_requests_department_item_types_per_month WHERE stats_dep_item_type_year=$date_yyyy AND stats_dep_item_type_month=$date_mm AND stats_dep_item_type_department=$inp_department_mysql AND stats_dep_item_type_location=$inp_location_mysql AND stats_dep_item_type_item_type_id=$get_item_type_id";
						$result_d = mysqli_query($link, $query_d);
						$row_d = mysqli_fetch_row($result_d);
						list($get_stats_dep_item_type_id, $get_stats_dep_item_type_counter) = $row_d;
						if($get_stats_dep_item_type_id == ""){

							mysqli_query($link, "INSERT INTO $t_edb_stats_requests_department_item_types_per_month 
							(stats_dep_item_type_id, stats_dep_item_type_year, stats_dep_item_type_month, stats_dep_item_type_district_id, stats_dep_item_type_station_id, stats_dep_item_type_department, stats_dep_item_type_location, stats_dep_item_type_item_type_id, stats_dep_item_type_item_type_title, stats_dep_item_type_counter) 
							VALUES 
							(NULL, $date_yyyy, $date_mm, $get_current_case_district_id, $get_current_case_station_id, $inp_department_mysql, $inp_location_mysql, $get_item_type_id, $inp_item_type_title_mysql, 1)")
							or die(mysqli_error($link));

						}
						else{


							$inp_counter = $get_stats_dep_item_type_counter+1;
							$result = mysqli_query($link, "UPDATE $t_edb_stats_requests_department_item_types_per_month SET stats_dep_item_type_counter=$inp_counter WHERE stats_dep_item_type_id=$get_stats_dep_item_type_id") or die(mysqli_error($link));
						}


						// Stats Requests :: User Item types 
						$query = "SELECT stats_usr_item_type_id, stats_usr_item_type_counter FROM $t_edb_stats_requests_user_item_types_per_month WHERE stats_usr_item_type_year=$date_yyyy AND stats_usr_item_type_month=$date_mm AND stats_usr_item_type_user_id=$get_current_item_requester_user_id AND stats_usr_item_type_item_type_id=$get_item_type_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_stats_usr_item_type_id, $get_stats_usr_item_type_counter) = $row;
						if($get_stats_usr_item_type_id == ""){
							mysqli_query($link, "INSERT INTO $t_edb_stats_requests_user_item_types_per_month 
							(stats_usr_item_type_id, stats_usr_item_type_year, stats_usr_item_type_month, stats_usr_item_type_district_id, stats_usr_item_type_station_id, stats_usr_item_type_user_id, stats_usr_item_type_item_type_id, stats_usr_item_type_item_type_title, stats_usr_item_type_counter) 
							VALUES 
							(NULL, $date_yyyy, $date_mm, $get_current_case_district_id, $get_current_case_station_id, $get_current_item_requester_user_id, $get_item_type_id, $inp_item_type_title_mysql, 1)")
							or die(mysqli_error($link));
						}
						else{
							$inp_counter = $get_stats_usr_item_type_counter+1;
							$result = mysqli_query($link, "UPDATE $t_edb_stats_requests_user_item_types_per_month SET stats_usr_item_type_counter=$inp_counter WHERE stats_usr_item_type_id=$get_stats_usr_item_type_id") or die(mysqli_error($link));
						}


					} // new item type





					$url = "open_case_evidence_edit_evidence_item_item.php?case_id=$get_current_case_id&item_id=$get_current_item_id&mode=$mode&l=$l&ft=success&fm=changes_saved";
					header("Location: $url");
					exit;
				}

				echo"
				<h2>$l_item</h2>


				<!-- Focus -->
					";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"
						<script>
						\$(document).ready(function(){
							\$('[name=\""; if($focus == ""){ echo"inp_title"; } else{ echo"$focus"; } echo"\"]').focus();
							});
						</script>
						";
					}
					echo"
				<!-- //Focus -->

				<!-- Edit evidence item -->
					";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"
						<form method=\"POST\" action=\"open_case_evidence_edit_evidence_item_item.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;mode=$mode&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
						";
					}
					echo"
					<table>
					 <tr>
					  <td style=\"padding-right: 80px;vertical-align:top;\">
						<h3>$l_general</h3>

							<p>$l_type: (<a href=\"$root/_admin/index.php?open=edb&amp;page=item_types&amp;editor_language=$l&amp;l=$l\" target=\"_blank\" class=\"small\">$l_edit</a>)<br />";

							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
								echo"
								<select name=\"inp_item_type_id\" id=\"inp_item_type_id\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
								<option value=\"\""; if($get_current_item_type_id == ""){ echo" selected=\"selected\""; } echo">-</option>
								";
								$query = "SELECT item_type_id, item_type_title, item_type_image_path, item_type_image_file FROM $t_edb_item_types ORDER BY item_type_title ASC";
								$result = mysqli_query($link, $query);
								while($row = mysqli_fetch_row($result)) {
									list($get_item_type_id, $get_item_type_title, $get_item_type_image_path, $get_item_type_image_file) = $row;
									echo"			";
									echo"<option value=\"$get_item_type_id\""; if($get_item_type_id == "$get_current_item_type_id"){ echo" selected=\"selected\""; } echo">$get_item_type_title</option>\n";
								}
								echo"
								</select>
								<!-- Submit form after change type -->
								<script>
								\$(function() {
									\$('#inp_item_type_id').change(function() {
										this.form.submit();
									});
								});
								</script>
								<!-- //Submit form after change type -->
								";
							}
							else{
								echo"<span>$get_current_item_type_title</span>";
							}
							echo"
							</p>

							<p>$l_title:<br />";
							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
								echo"<input type=\"text\" name=\"inp_title\" value=\"$get_current_item_title\" size=\"35\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
							}
							else{
								echo"<span>$get_current_item_type_title</span>";
							}
							echo"
							</p>


							<p>$l_storage: (<a href=\"$root/_admin/index.php?open=edb&amp;page=evidence_storage_shelves&amp;editor_language=$l&amp;l=$l\" target=\"_blank\" class=\"small\">$l_edit</a>)<br />
						
							";
							if($get_current_item_storage_location_abbr != ""){
								$storage_value = "$get_current_item_storage_shelf_title ($get_current_item_storage_location_abbr)";
							}
							else{
								$storage_value = "$get_current_item_storage_shelf_title";
							}
							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){


							echo"
							<input type=\"text\" name=\"inp_storage\" id=\"inp_storage_autosearch\" value=\"$storage_value\" autocomplete=\"off\" size=\"35\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
							</p>
	
							<!-- Storage Search script -->
								<script id=\"source\" language=\"javascript\" type=\"text/javascript\">
									\$(document).ready(function () {
										\$('#inp_storage_autosearch').keyup(function () {

       										// getting the value that user typed
       										var searchString    = $(\"#inp_storage_autosearch\").val();
 										// forming the queryString
      										var data            = 'l=$l&q='+ searchString;
         
        									// if searchString is not empty
        									if(searchString) {
										
           										// ajax call
            										\$.ajax({
                										type: \"GET\",
               											url: \"open_case_evidence_edit_evidence_item_item_jquery_search_for_storage_shelve.php\",
                										data: data,
												beforeSend: function(html) { // this happens before actual call
													\$(\"#autosearch_storage_search_results_show\").html(''); 
												},
               											success: function(html){
                    											\$(\"#autosearch_storage_search_results_show\").append(html);
              											}
            										});
       										}
        									return false;
            								});
         				   			});
								</script>
								<div id=\"autosearch_storage_search_results_show\"></div>
							<!-- //Storage Search script -->

							";
						}
						else{
							echo"<p style=\"padding:0;\">$storage_value</p>";
						}
						echo"

						<!-- Categorization -->

							<p>$l_name:<br />";
							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
								echo"<input type=\"text\" name=\"inp_name\" value=\"$get_current_item_name\" size=\"35\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
							}
							else{
								echo"<span>$get_current_item_name</span>";
							}
							echo"
							</p>

							<p>$l_serial_number:<br />";
							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
								echo"<input type=\"text\" name=\"inp_serial_number\" value=\"$get_current_item_serial_number\" size=\"35\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
							}
							else{
								echo"<span>$get_current_item_serial_number</span>";
							}
							echo"
							</p>

							<p>$l_os_title_and_version:<br />";
							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
								echo"<input type=\"text\" name=\"inp_os_title\" value=\"$get_current_item_os_title\" size=\"20\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
								$l_ver_lowercase <input type=\"text\" name=\"inp_os_version\" value=\"$get_current_item_os_version\" size=\"5\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
							}
							else{
								echo"<span>$get_current_item_os_title $l_ver_lowercase $get_current_item_os_version</span>";
							}
							echo"
							</p>
							<p>$l_parent:<br />";

							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
								echo"
								<select name=\"inp_parent_item_id\" class=\"on_change_submit_form\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
								<option value=\"0\""; if($get_current_item_parent_item_id == "0"){ echo" selected=\"selected\""; } echo">-</option>
								";
								$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title FROM $t_edb_case_index_evidence_items WHERE item_case_id=$get_current_case_id AND item_parent_item_id=0 ORDER BY item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number ASC";
								$result = mysqli_query($link, $query);
								while($row = mysqli_fetch_row($result)) {
									list($get_item_id, $get_item_case_id, $get_item_record_id, $get_item_record_seized_year, $get_item_record_seized_journal, $get_item_record_seized_district_number, $get_item_numeric_serial_number, $get_item_title) = $row;
									if($get_current_item_id != "$get_item_id"){
										echo"			";
										echo"<option value=\"$get_item_id\""; if($get_item_id == "$get_current_item_parent_item_id"){ echo" selected=\"selected\""; } echo">$get_item_record_id/$get_item_record_seized_year-$get_item_record_seized_journal-$get_item_record_seized_district_number-$get_item_numeric_serial_number $get_item_title</option>\n";
									}
								}
								echo"
								</select>
								<!-- Submit form after change type -->
								<script>
								\$(function() {
									\$('.on_change_submit_form').change(function() {
										this.form.submit();
									});
								});
								</script>
								<!-- //Submit form after change type -->
								";
							}
							else{
								echo"<span>$get_current_item_parent_item_id</span>";
							}
							echo"
							</p>
						<!-- //Categorization -->
					  </td>
					  <td style=\"padding-right: 80px;vertical-align:top;\">
						<h3>$l_comment</h3>
					

							<p>$l_comment:<br />";
							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
								$get_current_item_comment = str_replace("<br />", "\n", $get_current_item_comment);
								echo"<textarea name=\"inp_comment\" rows=\"6\" cols=\"50\" tabindex=\"";$tabindex = $tabindex+1; echo"$tabindex\">$get_current_item_comment</textarea>";
							}
							else{
								echo"<span>$get_current_item_comment</span>";
							}
							echo"
							</p>

							<p>$l_condition:<br />";
							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
								$get_current_item_condition = str_replace("<br />", "\n", $get_current_item_condition);
								echo"<textarea name=\"inp_condition\" rows=\"6\" cols=\"50\" tabindex=\"";$tabindex = $tabindex+1; echo"$tabindex\">$get_current_item_condition</textarea>";
							}
							else{
								echo"<span>$get_current_item_condition</span>";
							}
							echo"
							</p>

					  </td>
					  <td style=\"padding-right: 80px;vertical-align:top;\">
						<!-- Time and date -->

						<a id=\"date_and_time\"></a>
						<h3>$l_date_and_time</h3>


						<p>$l_item_time_zone<br />";
						if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
							echo"<input type=\"text\" name=\"inp_item_timezone\" value=\"$get_current_item_timezone\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
						}
						else{
							echo"$get_current_item_timezone";
						}
						echo"
						</p>

						<table>
						 <tr>
						  <td style=\"padding-right: 10px;\">
							<p>$l_item_date: <a href=\"#date_and_time\" id=\"input_date_and_time_now\"><img src=\"_gfx/ic_event_black_18dp.png\" alt=\"ic_event_black_18dp.png\" /></a><br />";
							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
								echo"<input type=\"date\" name=\"inp_date_now_date\" id=\"inp_date_now\" value=\"$get_current_item_date_now_date\" size=\"10\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
							}
							else{
								echo"$get_current_item_date_now_ddmmyyyy";
							}
							echo"
							</p>
						  </td>
						  <td>
							<p>$l_item_time:<br />";
							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
								echo"<input type=\"text\" name=\"inp_time_now\" id=\"inp_time_now\" value=\"$get_current_item_time_now\" size=\"5\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
							}
							else{
								echo"$get_current_item_time_now";
							}
							echo"
							</p>
						  </td>
						 </tr>
						 <tr>
						  <td style=\"padding-right: 10px;\">
							<p>$l_date_now:<br />";
							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
								echo"<input type=\"date\" name=\"inp_correct_date_now_date\" value=\"";
								if($get_current_item_correct_date_now_date == ""){
									//echo date("d.m.y");
									echo date("Y-m-d");
								}
								else{
									echo"$get_current_item_correct_date_now_date";
								}
								echo"\" size=\"10\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
							}
							else{
								echo"$get_current_item_correct_date_now_ddmmyyyy";
							}
							echo"
							</p>
						  </td>
						  <td>
							<p>$l_time_now:<br />";
							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
								echo"<input type=\"text\" name=\"inp_correct_time_now\" value=\"";
								if($get_current_item_correct_time_now == ""){
									echo date("H:i");
								}
								else{
									echo"$get_current_item_correct_time_now";
								}
								echo"\" size=\"5\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
							}
							else{
								echo"$get_current_item_correct_time_now";
							}
							echo"
							</p>
						  </td>
						 </tr>
						</table>
						<!-- Add date and time to field on click -->
							<script type=\"text/javascript\">
							\$(function() {
								\$('#input_date_and_time_now').click(function() {
									var date = '"; echo date("Y-m-d"); echo"'
									var time = '"; echo date("H:i"); echo"'
            								var input_date = \$('#inp_date_now');
            								var input_time = \$('#inp_time_now');
            								input_date.val(date);
            								input_time.val(time);
            								return false;
       								});
    							});
							</script>
						<!-- //Add date and time to field on click -->
		
						<p>$l_item_adjust_clock_automatically:<br />";
						if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
							echo"
							<input type=\"radio\" name=\"inp_adjust_clock_automatically\" value=\"yes\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\"";
							if($get_current_item_adjust_clock_automatically == "yes"){ echo" checked=\"checked\""; } echo" /> $l_yes &nbsp;

							<input type=\"radio\" name=\"inp_adjust_clock_automatically\" value=\"no\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\"";
							if($get_current_item_adjust_clock_automatically == "no"){ echo" checked=\"checked\""; } echo" /> $l_no &nbsp;

							<input type=\"radio\" name=\"inp_adjust_clock_automatically\" value=\"undefined\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\"";
							if($get_current_item_adjust_clock_automatically == "undefined" OR $get_current_item_adjust_clock_automatically == ""){ echo" checked=\"checked\""; } echo" /> $l_undefined &nbsp;
							";
						}
						else{
							if($get_current_item_adjust_clock_automatically == "yes"){ echo"$l_yes"; }

							if($get_current_item_adjust_clock_automatically == "no"){ echo"$l_no"; }

							if($get_current_item_adjust_clock_automatically == "undefined" OR $get_current_item_adjust_clock_automatically == ""){ echo"$l_undefined"; }
							
						}
						echo"
						</p>
		
						<p>$l_item_adjust_time_zone_automatically:<br />";
						if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
							echo"
							<input type=\"radio\" name=\"inp_adjust_time_zone_automatically\" value=\"yes\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\"";
							if($get_current_item_adjust_time_zone_automatically == "yes"){ echo" checked=\"checked\""; } echo" /> $l_yes &nbsp;

							<input type=\"radio\" name=\"inp_adjust_time_zone_automatically\" value=\"no\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\"";
							if($get_current_item_adjust_time_zone_automatically == "no"){ echo" checked=\"checked\""; } echo" /> $l_no &nbsp;

							<input type=\"radio\" name=\"inp_adjust_time_zone_automatically\" value=\"undefined\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\"";
							if($get_current_item_adjust_time_zone_automatically == "undefined" OR $get_current_item_adjust_time_zone_automatically == ""){ echo" checked=\"checked\""; } echo" /> $l_undefined &nbsp;
							";
						}
						else{
							if($get_current_item_adjust_time_zone_automatically == "yes"){ echo"$l_yes"; }

							if($get_current_item_adjust_time_zone_automatically == "no"){ echo"$l_no"; }

							if($get_current_item_adjust_time_zone_automatically == "undefined" OR $get_current_item_adjust_time_zone_automatically == ""){ echo"$l_undefined"; }
							
						}
						echo"
						</p>
						<!-- //Time and date -->
					  </td>
					 </tr>
					</table>


						<!-- Passwords -->
							<hr />
							<a id=\"user_and_passwords\"></a>
							<table>
							 <tr>
							  <td style=\"padding-right: 6px;vertical-align:top;\">
								<h3>$l_user_and_passwords</h3>
							  </td>
							  <td style=\"vertical-align:top;\">
								<p>
								[<a href=\"open_case_evidence_edit_evidence_item_add_password_row.php?case_id=$case_id&amp;item_id=$item_id&amp;mode=item&amp;l=$l&amp;process=1\">$l_add_row</a>]
								</p>
							 </tr>
							</table>
							<table class=\"hor-zebra\">
							 <thead>
							  <tr>";
							if($get_current_item_type_id == ""){
								echo"
								  <th>
									<span style=\"color: red;\">$l_missing_item_type</span>
								  </th>
								";
							} // Missing item type
							else{
								$query = "SELECT available_id, available_item_type_id, available_title, available_type, available_size, available_last_updated_datetime, available_last_updated_user_id FROM $t_edb_item_types_available_passwords WHERE available_item_type_id=$get_current_item_type_id";
								$result = mysqli_query($link, $query);
								while($row = mysqli_fetch_row($result)) {
									list($get_available_id, $get_available_item_type_id, $get_available_title, $get_available_type, $get_available_size, $get_available_last_updated_datetime, $get_available_last_updated_user_id) = $row;
									echo"
									   <th scope=\"col\">
										<span>$get_available_title</span>
									   </th>
									";
								}
							}
							echo"
							  </tr>
							 </thead>
							 <tbody>
							";

							// Count number of password stored for this item
							$set_counter = 0;
							$count_availables = 0;

							if($get_current_item_type_id != ""){
								$query_set = "SELECT DISTINCT(password_set_number) FROM $t_edb_case_index_evidence_items_passwords WHERE password_case_id=$get_current_case_id AND password_item_id=$get_current_item_id";
								$result_set = mysqli_query($link, $query_set);
								while($row_set = mysqli_fetch_row($result_set)) {
									list($get_current_password_set_number) = $row_set;
									if(isset($style) && $style == ""){
										$style = "odd";
									}
									else{
										$style = "";
									}
									echo"
									 <tr>";
									$query_av = "SELECT available_id, available_item_type_id, available_title, available_type, available_size, available_last_updated_datetime, available_last_updated_user_id FROM $t_edb_item_types_available_passwords WHERE available_item_type_id=$get_current_item_type_id";
									$result_av = mysqli_query($link, $query_av);
									while($row_av = mysqli_fetch_row($result_av)) {
										list($get_available_id, $get_available_item_type_id, $get_available_title, $get_available_type, $get_available_size, $get_available_last_updated_datetime, $get_available_last_updated_user_id) = $row_av;

										// Fetch data
										$query_psw = "SELECT password_id, password_case_id, password_item_id, password_available_id, password_item_type_id, password_set_number, password_value, password_created_by_user_id, password_created_by_user_name, password_created_datetime, password_updated_by_user_id, password_updated_by_user_name, password_updated_datetime FROM $t_edb_case_index_evidence_items_passwords WHERE password_case_id=$get_current_case_id AND password_item_id=$get_current_item_id AND password_available_id=$get_available_id AND password_item_type_id=$get_available_item_type_id AND password_set_number=$get_current_password_set_number";
										$result_psw = mysqli_query($link, $query_psw);
										$row_psw = mysqli_fetch_row($result_psw);
										list($get_password_id, $get_password_case_id, $get_password_item_id, $get_password_available_id, $get_password_item_type_id, $get_password_set_number, $get_password_value, $get_password_created_by_user_id, $get_password_created_by_user_name, $get_password_created_datetime, $get_password_updated_by_user_id, $get_password_updated_by_user_name, $get_password_updated_datetime) = $row_psw;
										if($get_password_id == ""){
											// Insert
											$inp_available_title_mysql = quote_smart($link, $get_available_title);
											mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_items_passwords 
											(password_id, password_case_id, password_item_id, password_available_id, password_available_title, password_item_type_id, password_set_number) 
											VALUES 
											(NULL, $get_current_case_id, $get_current_item_id, $get_available_id, $inp_available_title_mysql, $get_available_item_type_id, $get_current_password_set_number)")
											or die(mysqli_error($link));

											// Get new ID
											$query_psw = "SELECT password_id, password_case_id, password_item_id, password_available_id, password_item_type_id, password_set_number, password_value, password_created_by_user_id, password_created_by_user_name, password_created_datetime, password_updated_by_user_id, password_updated_by_user_name, password_updated_datetime FROM $t_edb_case_index_evidence_items_passwords WHERE password_case_id=$get_current_case_id AND password_item_id=$get_current_item_id AND password_available_id=$get_available_id AND password_item_type_id=$get_available_item_type_id AND password_set_number=$get_current_password_set_number";
											$result_psw = mysqli_query($link, $query_psw);
											$row_psw = mysqli_fetch_row($result_psw);
											list($get_password_id, $get_password_case_id, $get_password_item_id, $get_password_available_id, $get_password_item_type_id, $get_password_set_number, $get_password_value, $get_password_created_by_user_id, $get_password_created_by_user_name, $get_password_created_datetime, $get_password_updated_by_user_id, $get_password_updated_by_user_name, $get_password_updated_datetime) = $row_psw;
										}

										// Check set number
										if($set_counter != "$get_password_set_number"){
											$result_up = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items_passwords SET password_set_number=$set_counter WHERE password_id=$get_password_id");

										}

										echo"
										   <td class=\"$style\">
										";
										if($get_available_type == "text" OR $get_available_type == "numeric"){
											echo"
											<span><input type=\"text\" name=\"inp_password_value_$get_password_id\" size=\"$get_available_size\" value=\"$get_password_value\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
											";
										}
										elseif($get_available_type == "unlock_pattern"){
										
											if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
												echo"(<a href=\"open_case_evidence_edit_evidence_item_item_unlock_pattern_selecter.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;mode=item&amp;password_id=$get_password_id&amp;l=$l\" target=\"_blank\">$l_select_pattern</a>)
											";
											}
											if($get_password_value != ""){
												echo"<br />
												<a href=\"most_used_passwords_unlock_pattern_drawer_to_image.php?pattern=$get_password_value\">$get_password_value</a>";
											}
										}
										echo"
										   </td>
										";
	
										$count_availables++;
									}
									$set_counter++;
									echo"
									 </tr>
									";
								} // while password set number
							} // item type
							echo"
								  </tr>
								 </tbody>
								</table>
							
						
						<!-- //Passwords -->

						";
						if($get_current_item_type_has_hard_disks == "1"){
							echo"
							<hr />
							<a id=\"hard_disks\"></a>
							<h3>$l_hard_disks</h3>

							<table class=\"hor-zebra\">
							 <thead>
							  <tr>
							   <th scope=\"col\">
								<span>$l_manufacturer</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_type</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_size</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_serial</span>
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
			
							$query = "SELECT hard_disk_id, hard_disk_case_id, hard_disk_record_id, hard_disk_item_id, hard_disk_manufacturer, hard_disk_type, hard_disk_size, hard_disk_serial, hard_disk_comments FROM $t_edb_case_index_evidence_items_hard_disks WHERE hard_disk_case_id=$get_current_case_id AND hard_disk_item_id=$get_current_item_id";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_hard_disk_id, $get_hard_disk_case_id, $get_hard_disk_record_id, $get_hard_disk_item_id, $get_hard_disk_manufacturer, $get_hard_disk_type, $get_hard_disk_size, $get_hard_disk_serial, $get_hard_disk_comments) = $row;

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
										echo"<input type=\"text\" name=\"inp_hard_disk_manufacturer_$get_hard_disk_id\" size=\"15\" value=\"$get_hard_disk_manufacturer\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_hard_disk_manufacturer";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_hard_disk_type_$get_hard_disk_id\" size=\"15\" value=\"$get_hard_disk_type\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\"/>";
									}
									else{
										echo"$get_hard_disk_type";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_hard_disk_size_$get_hard_disk_id\" size=\"15\" value=\"$get_hard_disk_size\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_hard_disk_size";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_hard_disk_serial_$get_hard_disk_id\" size=\"15\" value=\"$get_hard_disk_serial\"  tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_hard_disk_serial";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_hard_disk_comments_$get_hard_disk_id\" size=\"15\" value=\"$get_hard_disk_comments\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_hard_disk_comments";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"checkbox\" name=\"inp_hard_disk_delete_$get_hard_disk_id\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									echo"
									</span>
								  </td>
								 </tr>
								";
							} // while hard_disk
							// Add x hard disk
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
										<span><input type=\"text\" name=\"inp_hard_disk_manufacturer_new_$x\" size=\"15\" value=\"\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
									  </td>
									  <td class=\"$style\">
										<span><input type=\"text\" name=\"inp_hard_disk_type_new_$x\" size=\"15\" value=\"\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\"/></span>
									  </td>
									  <td class=\"$style\">
										<span><input type=\"text\" name=\"inp_hard_disk_size_new_$x\" size=\"15\" value=\"\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
									  </td>
									  <td class=\"$style\">
										<span><input type=\"text\" name=\"inp_hard_disk_serial_new_$x\" size=\"15\" value=\"\"  tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
									  </td>
									  <td class=\"$style\">
										<span><input type=\"text\" name=\"inp_hard_disk_comments_new_$x\" size=\"15\" value=\"\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
									  </td>
									  <td class=\"$style\">
									
									  </td>
									 </tr>
									";
								}
							}
							echo"
								 </tbody>
								</table>
							";
						} // hard disks
						
						// Sim cards
						if($get_current_item_type_has_sim_cards == "1"){
							echo"
							<hr />
							<a id=\"sim_card\"></a>
							<h3>$l_sim_cards</h3>

							<table class=\"hor-zebra\">
							 <thead>
							  <tr>
							   <th scope=\"col\">
								<span>$l_imei</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_sim_card_number (ICCID)</span>
							   </th>
							   <th scope=\"col\">
								<span>IMSI</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_phone_number</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_pin</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_puc</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_operator</span>
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

			
							$query = "SELECT sim_card_id, sim_card_case_id, sim_card_record_id, sim_card_item_id, sim_card_imei, sim_card_iccid, sim_card_imsi, sim_card_phone_number, sim_card_pin, sim_card_puc, sim_card_operator, sim_card_comments FROM $t_edb_case_index_evidence_items_sim_cards WHERE sim_card_case_id=$get_current_case_id AND sim_card_item_id=$get_current_item_id";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_sim_card_id, $get_sim_card_case_id, $get_sim_card_record_id, $get_sim_card_item_id, $get_sim_card_imei, $get_sim_card_iccid, $get_sim_card_imsi, $get_sim_card_phone_number, $get_sim_card_pin, $get_sim_card_puc, $get_sim_card_operator, $get_sim_card_comments) = $row;

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
										echo"<input type=\"text\" name=\"inp_sim_card_imei_$get_sim_card_id\" size=\"15\" value=\"$get_sim_card_imei\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_sim_card_imei";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_sim_card_iccid_$get_sim_card_id\" size=\"15\" value=\"$get_sim_card_iccid\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\"/>";
									}
									else{
										echo"$get_sim_card_iccid";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_sim_card_imsi_$get_sim_card_id\" size=\"15\" value=\"$get_sim_card_imsi\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_sim_card_imsi";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_sim_card_phone_number_$get_sim_card_id\" size=\"15\" value=\"$get_sim_card_phone_number\"  tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_sim_card_phone_number";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_sim_card_pin_$get_sim_card_id\" size=\"15\" value=\"$get_sim_card_pin\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_sim_card_pin";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_sim_card_puc_$get_sim_card_id\" size=\"15\" value=\"$get_sim_card_puc\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_sim_card_puc";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_sim_card_operator_$get_sim_card_id\" size=\"15\" value=\"$get_sim_card_operator\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_sim_card_operator";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_sim_card_comment_$get_sim_card_id\" size=\"15\" value=\"$get_sim_card_comments\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_sim_card_comments";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"checkbox\" name=\"inp_sim_card_delete_$get_sim_card_id\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									echo"</span>
								  </td>
								 </tr>
								";
							} // while sim cards
							// Add n sim card
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
									<span><input type=\"text\" name=\"inp_sim_card_imei_new_$x\" size=\"15\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
								  </td>
								  <td class=\"$style\">
									<span><input type=\"text\" name=\"inp_sim_card_iccid_new_$x\" size=\"15\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
								  </td>
								  <td class=\"$style\">
									<span><input type=\"text\" name=\"inp_sim_card_imsi_new_$x\" size=\"15\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
								  </td>
								  <td class=\"$style\">
									<span><input type=\"text\" name=\"inp_sim_card_phone_number_new_$x\" size=\"15\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
								  </td>
								  <td class=\"$style\">
									<span><input type=\"text\" name=\"inp_sim_card_pin_new_$x\" size=\"15\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
								  </td>
								  <td class=\"$style\">
									<span><input type=\"text\" name=\"inp_sim_card_puc_new_$x\" size=\"15\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
								  </td>
								  <td class=\"$style\">
									<span><input type=\"text\" name=\"inp_sim_card_operator_new_$x\" size=\"15\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
								  </td>
								  <td class=\"$style\">
									<span><input type=\"text\" name=\"inp_sim_card_comment_new_$x\" size=\"15\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
								  </td>
								  <td class=\"$style\">
								
								  </td>
								 </tr>
								";
							}
							}
							echo"
								 </tbody>
								</table>
							";
						} // sim cards
						
						// SD cards
						if($get_current_item_type_has_sd_cards == "1"){
							echo"
							<hr />
							<a id=\"sd_cards\"></a>
							<h3>$l_sd_cards</h3>

							<table class=\"hor-zebra\">
							 <thead>
							  <tr>
							   <th scope=\"col\">
								<span>$l_manufacturer</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_size</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_serial</span>
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

			
							$query = "SELECT sd_card_id, sd_card_case_id, sd_card_record_id, sd_card_item_id, sd_card_manufacturer, sd_card_size, sd_card_serial, sd_card_comments FROM $t_edb_case_index_evidence_items_sd_cards WHERE sd_card_case_id=$get_current_case_id AND sd_card_item_id=$get_current_item_id";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_sd_card_id, $get_sd_card_case_id, $get_sd_card_record_id, $get_sd_card_item_id, $get_sd_carc_manufacturer, $get_sd_card_size, $get_sd_card_serial, $get_sd_card_comments) = $row;

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
										echo"<input type=\"text\" name=\"inp_sd_card_manufacturer_$get_sd_card_id\" size=\"15\" value=\"$get_sd_carc_manufacturer\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_sd_carc_manufacturer";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_sd_card_size_$get_sd_card_id\" size=\"15\" value=\"$get_sd_card_size\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\"/>";
									}
									else{
										echo"$get_sd_card_size";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_sd_card_serial_$get_sd_card_id\" size=\"15\" value=\"$get_sd_card_serial\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_sd_card_serial";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_sd_card_comments_$get_sd_card_id\" size=\"15\" value=\"$get_sd_card_comments\"  tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_sd_card_comments";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"checkbox\" name=\"inp_sd_card_delete_$get_sd_card_id\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									echo"</span>
								  </td>
								 </tr>
								";
							} // while sd cards
							// Add n sd card
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
									<span><input type=\"text\" name=\"inp_sd_card_manufacturer_new_$x\" size=\"15\" value=\"\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
								  </td>
								  <td class=\"$style\">
									<span><input type=\"text\" name=\"inp_sd_card_size_new_$x\" size=\"15\" value=\"\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\"/></span>
								  </td>
								  <td class=\"$style\">
									<span><input type=\"text\" name=\"inp_sd_card_serial_new_$x\" size=\"15\" value=\"\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
								  </td>
								  <td class=\"$style\">
									<span><input type=\"text\" name=\"inp_sd_card_comments_new_$x\" size=\"15\" value=\"\"  tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
								  </td>
								  <td class=\"$style\">
								
								  </td>
								 </tr>
								";
							}
							}
							echo"
								 </tbody>
								</table>
							";
						} // sd cards


						// Networks
						if($get_current_item_type_has_networks == "1"){
							echo"
							<hr />
							<a id=\"networks\"></a>
							<h3>$l_networks</h3>

							<table class=\"hor-zebra\">
							 <thead>
							  <tr>
							   <th scope=\"col\">
								<span>$l_is_wifi</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_manufacturer</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_card_title</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_mac</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_serial</span>
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

			
							$query = "SELECT network_id, network_case_id, network_record_id, network_item_id, network_is_wifi, network_manufacturer, network_card_title, network_mac, network_serial, network_comments FROM $t_edb_case_index_evidence_items_networks WHERE network_case_id=$get_current_case_id AND network_item_id=$get_current_item_id";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_network_id, $get_network_case_id, $get_network_record_id, $get_network_item_id, $get_network_is_wifi, $get_network_manufacturer, $get_network_card_title, $get_network_mac, $get_network_serial, $get_network_comments) = $row;

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
										echo"<input type=\"checkbox\" name=\"inp_network_is_wifi_$get_network_id\""; if($get_network_is_wifi == "1"){ echo" checked=\"checked\""; } echo" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										if($get_network_is_wifi == "1"){
											echo"$l_yes";
										}
										else{
											echo"$l_no";
										}
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_network_manufacturer_$get_network_id\" size=\"15\" value=\"$get_network_manufacturer\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\"/>";
									}
									else{
										echo"$get_network_manufacturer";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_network_card_title_$get_network_id\" size=\"15\" value=\"$get_network_card_title\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_network_card_title";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_network_mac_$get_network_id\" size=\"15\" value=\"$get_network_mac\"  tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_network_mac";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_network_serial_$get_network_id\" size=\"15\" value=\"$get_network_serial\"  tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_network_serial";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"text\" name=\"inp_network_comments_$get_network_id\" size=\"15\" value=\"$get_network_comments\"  tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									else{
										echo"$get_network_comments";
									}
									echo"</span>
								  </td>
								  <td class=\"$style\">
									<span>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<input type=\"checkbox\" name=\"inp_network_delete_$get_network_id\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
									}
									echo"
									</span>
								  </td>
								 </tr>
								";
							} // while networks
							// Add n network 
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
									<span><input type=\"checkbox\" name=\"inp_network_is_wifi_new_$x\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
								  </td>
								  <td class=\"$style\">
									<span><input type=\"text\" name=\"inp_network_manufacturer_new_$x\" size=\"15\" value=\"\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\"/></span>
								  </td>
								  <td class=\"$style\">
									<span><input type=\"text\" name=\"inp_network_card_title_new_$x\" size=\"15\" value=\"\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
								  </td>
								  <td class=\"$style\">
									<span><input type=\"text\" name=\"inp_network_mac_new_$x\" size=\"15\" value=\"\"  tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
								  </td>
								  <td class=\"$style\">
									<span><input type=\"text\" name=\"inp_network_serial_new_$x\" size=\"15\" value=\"\"  tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
								  </td>
								  <td class=\"$style\">
									<span><input type=\"text\" name=\"inp_network_comments_new_$x\" size=\"15\" value=\"\"  tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
								  </td>
								  <td class=\"$style\">
									
								  </td>
								 </tr>
								";
							}
							}
							echo"
								 </tbody>
								</table>
							";
						} // networks


					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"
						<p>
						<input type=\"submit\" value=\"$l_save_changes\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
						</p>
						</form>


						<!-- Submit form after change type -->
							<script>
							\$(function() {
								\$('.on_change_submit_form').change(function() {
									this.form.submit();
								});
							});
							</script>
						<!-- //Submit form after change type -->
						";
					}
					echo"
				<!-- //Edit evidence item -->
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