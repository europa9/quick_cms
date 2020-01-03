<?php 
/**
*
* File: edb/open_case_evidence_edit_evidence_item_information.php
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

/*- Language --------------------------------------------------------------------------------- */
include("$root/_admin/_translations/site/$l/edb/ts_edb.php");
include("$root/_admin/_translations/site/$l/edb/ts_open_case_overview.php");
include("$root/_admin/_translations/site/$l/edb/ts_open_case_evidence_edit_evidence_item_info_group_view.php");
include("$root/_admin/_translations/site/$l/users/ts_users.php");


/*- Tables ---------------------------------------------------------------------------------- */
$t_edb_case_index_item_info_groups	= $mysqlPrefixSav . "edb_case_index_item_info_groups";
$t_edb_case_index_item_info_level_a	= $mysqlPrefixSav . "edb_case_index_item_info_level_a";
$t_edb_case_index_item_info_level_b	= $mysqlPrefixSav . "edb_case_index_item_info_level_b";
$t_edb_case_index_item_info_level_c	= $mysqlPrefixSav . "edb_case_index_item_info_level_c";
$t_edb_case_index_item_info_level_d	= $mysqlPrefixSav . "edb_case_index_item_info_level_d";



/*- Variables -------------------------------------------------------------------------------- */
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

if(isset($_GET['group_id'])) {
	$group_id = $_GET['group_id'];
	$group_id = strip_tags(stripslashes($group_id));
}
else{
	$group_id = "";
}
$group_id_mysql = quote_smart($link, $group_id);

if(isset($_GET['level_a_id'])) {
	$level_a_id = $_GET['level_a_id'];
	$level_a_id = strip_tags(stripslashes($level_a_id));
}
else{
	$level_a_id = "";
}
$level_a_id_mysql = quote_smart($link, $level_a_id);

if(isset($_GET['level_b_id'])) {
	$level_b_id = $_GET['level_b_id'];
	$level_b_id = strip_tags(stripslashes($level_b_id));
}
else{
	$level_b_id = "";
}
$level_b_id_mysql = quote_smart($link, $level_b_id);

if(isset($_GET['level_c_id'])) {
	$level_c_id = $_GET['level_c_id'];
	$level_c_id = strip_tags(stripslashes($level_c_id));
}
else{
	$level_c_id = "";
}
$level_c_id_mysql = quote_smart($link, $level_c_id);

if(isset($_GET['level_d_id'])) {
	$level_d_id = $_GET['level_d_id'];
	$level_d_id = strip_tags(stripslashes($level_d_id));
}
else{
	$level_d_id = "";
}
$level_d_id_mysql = quote_smart($link, $level_d_id);

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
				// Find group
				$query = "SELECT group_id, group_case_id, group_item_id, group_title, group_show_on_analysis_report, group_count_level_a, group_created_by_user_id, group_created_by_user_name, group_created_datetime, group_updated_by_user_id, group_updated_by_user_name, group_updated_datetime FROM $t_edb_case_index_item_info_groups WHERE group_id=$group_id_mysql AND group_case_id=$get_current_case_id AND group_item_id=$get_current_item_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_group_id, $get_current_group_case_id, $get_current_group_item_id, $get_current_group_title, $get_current_group_show_on_analysis_report, $get_current_group_count_level_a, $get_current_group_created_by_user_id, $get_current_group_created_by_user_name, $get_current_group_created_datetime, $get_current_group_updated_by_user_id, $get_current_group_updated_by_user_name, $get_current_group_updated_datetime) = $row;

				if($get_current_group_id == ""){
					echo"<h1>Server error 404</h1><p>Group not found</p>";
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

					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						if($process == "1"){
							$datetime = date("Y-m-d H:i:s");
							$focus = "";
							$inp_my_user_name_mysql = quote_smart($link, $get_my_station_member_user_name);
						


							// Group
							$inp_group_title = $_POST["inp_group_title"];
							$inp_group_title = output_html($inp_group_title);
							$inp_group_title_mysql = quote_smart($link, $inp_group_title);


							if(isset($_POST["inp_group_show_on_analysis_report"])){
								$inp_group_show_on_analysis_report = $_POST["inp_group_show_on_analysis_report"];
								if($inp_group_show_on_analysis_report == "on"){
									$inp_group_show_on_analysis_report = "1";
								}
								else{
									$inp_group_show_on_analysis_report = "0";
								}
							}
							else{
								$inp_group_show_on_analysis_report  = "0";
							}
							$inp_group_show_on_analysis_report = output_html($inp_group_show_on_analysis_report);
							$inp_group_show_on_analysis_report_mysql = quote_smart($link, $inp_group_show_on_analysis_report);

							$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_item_info_groups SET 
												group_title=$inp_group_title_mysql,
												group_show_on_analysis_report=$inp_group_show_on_analysis_report_mysql,
												group_updated_by_user_id=$my_user_id_mysql,
												group_updated_by_user_name=$inp_my_user_name_mysql,
											 	group_updated_datetime='$datetime'
												 WHERE group_id=$get_current_group_id") or die(mysqli_error($link)); 

							// Level A
							$query = "SELECT level_a_id, level_a_case_id, level_a_item_id, level_a_title, level_a_value, level_a_flag, level_a_flag_checked, level_a_type, level_a_show_on_analysis_report, level_a_created_by_user_id, level_a_created_by_user_name, level_a_created_datetime, level_a_updated_by_user_id, level_a_updated_by_user_name, level_a_updated_datetime FROM $t_edb_case_index_item_info_level_a WHERE level_a_case_id=$get_current_case_id AND level_a_item_id=$get_current_item_id AND level_a_group_id=$get_current_group_id ORDER BY level_a_id ASC";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
							list($get_level_a_id, $get_level_a_case_id, $get_level_a_item_id, $get_level_a_title, $get_level_a_value, $get_level_a_flag, $get_level_a_flag_checked, $get_level_a_type, $get_level_a_show_on_analysis_report, $get_level_a_created_by_user_id, $get_level_a_created_by_user_name, $get_level_a_created_datetime, $get_level_a_updated_by_user_id, $get_level_a_updated_by_user_name, $get_level_a_updated_datetime) = $row;
			
								$inp_title = $_POST["inp_level_a_title_$get_level_a_id"];
								$inp_title = output_html($inp_title);
								$inp_title_mysql = quote_smart($link, $inp_title);

								$inp_value = $_POST["inp_level_a_value_$get_level_a_id"];
								$inp_value = output_html($inp_value);
								$inp_value_mysql = quote_smart($link, $inp_value);

								if(isset($_POST["inp_level_a_show_on_analysis_report_$get_level_a_id"])){
									$inp_show_on_analysis_report = $_POST["inp_level_a_show_on_analysis_report_$get_level_a_id"];
									if($inp_show_on_analysis_report == "on"){
										$inp_show_on_analysis_report = "1";
									}
									else{
										$inp_show_on_analysis_report = "0";
									}
								}
								else{
									$inp_show_on_analysis_report  = "0";
								}
								$inp_show_on_analysis_report = output_html($inp_show_on_analysis_report);
								$inp_show_on_analysis_report_mysql = quote_smart($link, $inp_show_on_analysis_report);


								$inp_type = $_POST["inp_level_a_type_$get_level_a_id"];
								$inp_type = output_html($inp_type);
								$inp_type_mysql = quote_smart($link, $inp_type);


								if(isset($_POST["inp_level_a_flag_$get_level_a_id"])){
									$inp_flag = $_POST["inp_level_a_flag_$get_level_a_id"];
									if($inp_flag == "on"){
										$inp_flag = "1";
									}
									else{
										$inp_flag = "0";
									}
								}
								else{
									$inp_flag = "0";
								}

								$inp_flag = output_html($inp_flag);
								$inp_flag_mysql = quote_smart($link, $inp_flag);


								if($inp_title != ""){
									if($inp_title != "$get_level_a_title" OR $inp_value != "$get_level_a_value" OR $inp_flag != "$get_level_a_flag" OR $inp_type != "$get_level_a_type" OR $inp_show_on_analysis_report != "$get_level_a_show_on_analysis_report"){
										$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_item_info_level_a SET 
												level_a_title=$inp_title_mysql,
												level_a_value=$inp_value_mysql,
												level_a_flag=$inp_flag_mysql,
											 	level_a_type=$inp_type_mysql, 
												level_a_show_on_analysis_report=$inp_show_on_analysis_report_mysql,
												level_a_updated_by_user_id=$my_user_id_mysql,
												level_a_updated_by_user_name=$inp_my_user_name_mysql,
											 	level_a_updated_datetime='$datetime'
												 WHERE level_a_id=$get_level_a_id") or die(mysqli_error($link)); 

										// HTML?
										if($inp_type == "html"){
											$inp_value = $_POST["inp_level_a_value_$get_level_a_id"];
											$sql = "UPDATE $t_edb_case_index_item_info_level_a SET level_a_value=? WHERE level_a_id=$get_level_a_id";
											$stmt = $link->prepare($sql);
											$stmt->bind_param("s", $inp_value);
											$stmt->execute();
											if ($stmt->errno) {
												echo "FAILURE!!! " . $stmt->error; die;
											}
										}

										$focus = "inp_level_a_title_$get_level_a_id";
									}
							
								}
								else{
									$result_update = mysqli_query($link, "DELETE FROM $t_edb_case_index_item_info_level_a WHERE level_a_id=$get_level_a_id") or die(mysqli_error($link));
									$result_update = mysqli_query($link, "DELETE FROM $t_edb_case_index_item_info_level_b WHERE level_b_level_a_id=$get_level_a_id") or die(mysqli_error($link));
									$result_update = mysqli_query($link, "DELETE FROM $t_edb_case_index_item_info_level_c WHERE level_c_level_a_id=$get_level_a_id") or die(mysqli_error($link));
									$result_update = mysqli_query($link, "DELETE FROM $t_edb_case_index_item_info_level_d WHERE level_d_level_a_id=$get_level_a_id") or die(mysqli_error($link));
									$get_level_a_id = "";
								} 
									

							
								// Level B
								if($get_level_a_id != ""){
									$query_b = "SELECT level_b_id, level_b_case_id, level_b_item_id, level_b_level_a_id, level_b_title, level_b_value, level_b_flag, level_b_flag_checked, level_b_type, level_b_show_on_analysis_report, level_b_created_by_user_id, level_b_created_by_user_name, level_b_created_datetime, level_b_updated_by_user_id, level_b_updated_by_user_name, level_b_updated_datetime FROM $t_edb_case_index_item_info_level_b WHERE level_b_case_id=$get_current_case_id AND level_b_item_id=$get_current_item_id AND level_b_group_id=$get_current_group_id AND level_b_level_a_id=$get_level_a_id ORDER BY level_b_id ASC";
									$result_b = mysqli_query($link, $query_b);
									while($row_b = mysqli_fetch_row($result_b)) {
										list($get_level_b_id, $get_level_b_case_id, $get_level_b_item_id, $get_level_b_level_a_id, $get_level_b_title, $get_level_b_value, $get_level_b_flag, $get_level_b_flag_checked, $get_level_b_type, $get_level_b_show_on_analysis_report, $get_level_b_created_by_user_id, $get_level_b_created_by_user_name, $get_level_b_created_datetime, $get_level_b_updated_by_user_id, $get_level_b_updated_by_user_name, $get_level_b_updated_datetime) = $row_b;


										$inp_title = $_POST["inp_level_b_title_$get_level_b_id"];
										$inp_title = output_html($inp_title);
										$inp_title_mysql = quote_smart($link, $inp_title);
		
										$inp_value = $_POST["inp_level_b_value_$get_level_b_id"];
										$inp_value = output_html($inp_value);
										$inp_value_mysql = quote_smart($link, $inp_value);

										if(isset($_POST["inp_level_b_show_on_analysis_report_$get_level_b_id"])){
											$inp_show_on_analysis_report = $_POST["inp_level_b_show_on_analysis_report_$get_level_b_id"];
											if($inp_show_on_analysis_report == "on"){
												$inp_show_on_analysis_report = "1";
											}
											else{
												$inp_show_on_analysis_report = "0";
											}
										}
										else{
											$inp_show_on_analysis_report  = "0";
										}
										$inp_show_on_analysis_report = output_html($inp_show_on_analysis_report);
										$inp_show_on_analysis_report_mysql = quote_smart($link, $inp_show_on_analysis_report);


										$inp_type = $_POST["inp_level_b_type_$get_level_b_id"];
										$inp_type = output_html($inp_type);
										$inp_type_mysql = quote_smart($link, $inp_type);


										if(isset($_POST["inp_level_b_flag_$get_level_b_id"])){
											$inp_flag = $_POST["inp_level_b_flag_$get_level_b_id"];
											if($inp_flag == "on"){
												$inp_flag = "1";
											}
											else{
												$inp_flag = "0";
											}
										}
										else{
											$inp_flag = "0";
										}

										$inp_flag = output_html($inp_flag);
										$inp_flag_mysql = quote_smart($link, $inp_flag);
	

										if($inp_title != ""){
											if($inp_title != "$get_level_b_title" OR $inp_value != "$get_level_b_value" OR $inp_flag != "$get_level_b_flag" OR $inp_type != "$get_level_b_type" OR $inp_show_on_analysis_report != "$get_level_b_show_on_analysis_report"){
												$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_item_info_level_b SET 
														level_b_title=$inp_title_mysql,
														level_b_value=$inp_value_mysql,
														level_b_flag=$inp_flag_mysql,
											 			level_b_type=$inp_type_mysql, 
														level_b_show_on_analysis_report=$inp_show_on_analysis_report_mysql,
														level_b_updated_by_user_id=$my_user_id_mysql,
														level_b_updated_by_user_name=$inp_my_user_name_mysql,
											 			level_b_updated_datetime='$datetime'
														 WHERE level_b_id=$get_level_b_id") or die(mysqli_error($link)); 


												// HTML?
												if($inp_type == "html"){
													$inp_value = $_POST["inp_level_b_value_$get_level_b_id"];
													$sql = "UPDATE $t_edb_case_index_item_info_level_b SET level_b_value=? WHERE level_b_id=$get_level_b_id";
													$stmt = $link->prepare($sql);
													$stmt->bind_param("s", $inp_value);
													$stmt->execute();
													if ($stmt->errno) {
														echo "FAILURE!!! " . $stmt->error; die;
													}
												}

												$focus = "inp_level_b_title_$get_level_b_id";
											}
							
										}
										else{
											$result_update = mysqli_query($link, "DELETE FROM $t_edb_case_index_item_info_level_b WHERE level_b_id=$get_level_b_id") or die(mysqli_error($link));
											$result_update = mysqli_query($link, "DELETE FROM $t_edb_case_index_item_info_level_c WHERE level_c_level_b_id=$get_level_b_id") or die(mysqli_error($link));
											$result_update = mysqli_query($link, "DELETE FROM $t_edb_case_index_item_info_level_d WHERE level_d_level_b_id=$get_level_b_id") or die(mysqli_error($link));
											$get_level_b_id = "";
										} 
						


							
										// Level C
										if($get_level_b_id != ""){
											$query_c = "SELECT level_c_id, level_c_case_id, level_c_item_id, level_c_level_a_id, level_c_level_b_id, level_c_title, level_c_value, level_c_flag, level_c_flag_checked, level_c_type, level_c_show_on_analysis_report, level_c_created_by_user_id, level_c_created_by_user_name, level_c_created_datetime, level_c_updated_by_user_id, level_c_updated_by_user_name, level_c_updated_datetime FROM $t_edb_case_index_item_info_level_c WHERE level_c_case_id=$get_current_case_id AND level_c_item_id=$get_current_item_id AND level_c_group_id=$get_current_group_id AND level_c_level_a_id=$get_level_a_id AND level_c_level_b_id=$get_level_b_id ORDER BY level_c_id ASC";
											$result_c = mysqli_query($link, $query_c);
											while($row_c = mysqli_fetch_row($result_c)) {
												list($get_level_c_id, $get_level_c_case_id, $get_level_c_item_id, $get_level_c_level_a_id, $get_level_c_level_b_id, $get_level_c_title, $get_level_c_value, $get_level_c_flag, $get_level_c_flag_checked, $get_level_c_type, $get_level_c_show_on_analysis_report, $get_level_c_created_by_user_id, $get_level_c_created_by_user_name, $get_level_c_created_datetime, $get_level_c_updated_by_user_id, $get_level_c_updated_by_user_name, $get_level_c_updated_datetime) = $row_c;


												$inp_title = $_POST["inp_level_c_title_$get_level_c_id"];
												$inp_title = output_html($inp_title);
												$inp_title_mysql = quote_smart($link, $inp_title);

												$inp_value = $_POST["inp_level_c_value_$get_level_c_id"];
												$inp_value = output_html($inp_value);
												$inp_value_mysql = quote_smart($link, $inp_value);



												if(isset($_POST["inp_level_c_show_on_analysis_report_$get_level_c_id"])){
													$inp_show_on_analysis_report = $_POST["inp_level_c_show_on_analysis_report_$get_level_c_id"];
													if($inp_show_on_analysis_report == "on"){
														$inp_show_on_analysis_report = "1";
													}
													else{
														$inp_show_on_analysis_report = "0";
													}
												}
												else{
													$inp_show_on_analysis_report  = "0";
												}
												$inp_show_on_analysis_report = output_html($inp_show_on_analysis_report);
												$inp_show_on_analysis_report_mysql = quote_smart($link, $inp_show_on_analysis_report);


												$inp_type = $_POST["inp_level_c_type_$get_level_c_id"];
												$inp_type = output_html($inp_type);
												$inp_type_mysql = quote_smart($link, $inp_type);


												if(isset($_POST["inp_level_c_flag_$get_level_c_id"])){
													$inp_flag = $_POST["inp_level_c_flag_$get_level_c_id"];
													if($inp_flag == "on"){
														$inp_flag = "1";
													}
													else{
														$inp_flag = "0";
													}
												}
												else{
													$inp_flag = "0";
												}
												$inp_flag = output_html($inp_flag);
												$inp_flag_mysql = quote_smart($link, $inp_flag);
	

												if($inp_title != ""){
													if($inp_title != "$get_level_c_title" OR $inp_value != "$get_level_c_value" OR $inp_flag != "$get_level_c_flag" OR $inp_type != "$get_level_c_type" OR $inp_show_on_analysis_report != "$get_level_c_show_on_analysis_report"){
														$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_item_info_level_c SET 
																level_c_title=$inp_title_mysql,
																level_c_value=$inp_value_mysql,
																level_c_flag=$inp_flag_mysql,
											 					level_c_type=$inp_type_mysql, 
																level_c_show_on_analysis_report=$inp_show_on_analysis_report_mysql,
																level_c_updated_by_user_id=$my_user_id_mysql,
																level_c_updated_by_user_name=$inp_my_user_name_mysql,
											 					level_c_updated_datetime='$datetime'
																 WHERE level_c_id=$get_level_c_id") or die(mysqli_error($link)); 


														// HTML?
														if($inp_type == "html"){
															$inp_value = $_POST["inp_level_c_value_$get_level_c_id"];
															$sql = "UPDATE $t_edb_case_index_item_info_level_c SET level_c_value=? WHERE level_c_id=$get_level_c_id";
															$stmt = $link->prepare($sql);
															$stmt->bind_param("s", $inp_value);
															$stmt->execute();
															if ($stmt->errno) {
																echo "FAILURE!!! " . $stmt->error; die;
															}
														}

														$focus = "inp_level_c_title_$get_level_c_id";
													}
									
												}
												else{
													$result_update = mysqli_query($link, "DELETE FROM $t_edb_case_index_item_info_level_b WHERE level_b_id=$get_level_b_id") or die(mysqli_error($link));
													$result_update = mysqli_query($link, "DELETE FROM $t_edb_case_index_item_info_level_c WHERE level_c_level_b_id=$get_level_b_id") or die(mysqli_error($link));
													$result_update = mysqli_query($link, "DELETE FROM $t_edb_case_index_item_info_level_d WHERE level_d_level_b_id=$get_level_b_id") or die(mysqli_error($link));
													$get_level_c_id = "";
												} 
								
												if($get_level_c_id != ""){
													// Level D
													$query_d = "SELECT level_d_id, level_d_case_id, level_d_item_id, level_d_level_a_id, level_d_title, level_d_value, level_d_flag, level_d_flag_checked, level_d_type, level_d_show_on_analysis_report, level_d_created_by_user_id, level_d_created_by_user_name, level_d_created_datetime, level_d_updated_by_user_id, level_d_updated_by_user_name, level_d_updated_datetime FROM $t_edb_case_index_item_info_level_d WHERE level_d_case_id=$get_current_case_id AND level_d_item_id=$get_current_item_id AND level_d_group_id=$get_current_group_id AND level_d_level_a_id=$get_level_a_id AND level_d_level_b_id=$get_level_b_id AND level_d_level_c_id=$get_level_c_id ORDER BY level_d_id ASC";
													$result_d = mysqli_query($link, $query_d);
													while($row_d = mysqli_fetch_row($result_d)) {
														list($get_level_d_id, $get_level_d_case_id, $get_level_d_item_id, $get_level_d_level_a_id, $get_level_d_title, $get_level_d_value, $get_level_d_flag, $get_level_d_flag_checked, $get_level_d_type, $get_level_d_show_on_analysis_report, $get_level_d_created_by_user_id, $get_level_d_created_by_user_name, $get_level_d_created_datetime, $get_level_d_updated_by_user_id, $get_level_d_updated_by_user_name, $get_level_d_updated_datetime) = $row_d;

														$inp_title = $_POST["inp_level_d_title_$get_level_d_id"];
														$inp_title = output_html($inp_title);
														$inp_title_mysql = quote_smart($link, $inp_title);

														$inp_value = $_POST["inp_level_d_value_$get_level_d_id"];
														$inp_value = output_html($inp_value);
														$inp_value_mysql = quote_smart($link, $inp_value);



														if(isset($_POST["inp_level_d_show_on_analysis_report_$get_level_d_id"])){
															$inp_show_on_analysis_report = $_POST["inp_level_d_show_on_analysis_report_$get_level_d_id"];
															if($inp_show_on_analysis_report == "on"){
																$inp_show_on_analysis_report = "1";
															}
															else{
																$inp_show_on_analysis_report = "0";
															}
														}
														else{
															$inp_show_on_analysis_report  = "0";
														}
														$inp_show_on_analysis_report = output_html($inp_show_on_analysis_report);
														$inp_show_on_analysis_report_mysql = quote_smart($link, $inp_show_on_analysis_report);


														$inp_type = $_POST["inp_level_d_type_$get_level_d_id"];
														$inp_type = output_html($inp_type);
														$inp_type_mysql = quote_smart($link, $inp_type);


														if(isset($_POST["inp_level_d_flag_$get_level_d_id"])){
															$inp_flag = $_POST["inp_level_d_flag_$get_level_d_id"];
															if($inp_flag == "on"){
																$inp_flag = "1";
															}
															else{
																$inp_flag = "0";
															}
														}
														else{
															$inp_flag = "0";
														}
														$inp_flag = output_html($inp_flag);
														$inp_flag_mysql = quote_smart($link, $inp_flag);
	
														if($inp_title != ""){
															if($inp_title != "$get_level_d_title" OR $inp_value != "$get_level_d_value" OR $inp_flag != "$get_level_d_flag" OR $inp_type != "$get_level_d_type" OR $inp_show_on_analysis_report != "$get_level_d_show_on_analysis_report"){
																$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_item_info_level_d SET 
																		level_d_title=$inp_title_mysql,
																		level_d_value=$inp_value_mysql,
																		level_d_flag=$inp_flag_mysql,
											 							level_d_type=$inp_type_mysql, 
																		level_d_show_on_analysis_report=$inp_show_on_analysis_report_mysql,
																		level_d_updated_by_user_id=$my_user_id_mysql,
																		level_d_updated_by_user_name=$inp_my_user_name_mysql,
											 							level_d_updated_datetime='$datetime'
																		 WHERE level_d_id=$get_level_d_id") or die(mysqli_error($link)); 



																// HTML?
																if($inp_type == "html"){
																	$inp_value = $_POST["inp_level_d_value_$get_level_d_id"];
																	$sql = "UPDATE $t_edb_case_index_item_info_level_d SET level_d_value=? WHERE level_d_id=$get_level_d_id";
																	$stmt = $link->prepare($sql);
																	$stmt->bind_param("s", $inp_value);
																	$stmt->execute();
																	if ($stmt->errno) {
																		echo "FAILURE!!! " . $stmt->error; die;
																	}
																}

																$focus = "inp_level_d_title_$get_level_d_id";
															}
							
														}
														else{
															$result_update = mysqli_query($link, "DELETE FROM $t_edb_case_index_item_info_level_d WHERE level_d_id=$get_level_d_id") or die(mysqli_error($link));
															$get_level_d_id = "";
														} 

		
													} // while level d

													// New level D
													$inp_title = $_POST["inp_level_d_title_new_$get_level_c_id"];
													$inp_title = output_html($inp_title);
													$inp_title_mysql = quote_smart($link, $inp_title);

													$inp_value = $_POST["inp_level_d_value_new_$get_level_c_id"];
													$inp_value = output_html($inp_value);
													$inp_value_mysql = quote_smart($link, $inp_value);

													if(isset($_POST["inp_level_d_show_on_analysis_report_new_$get_level_c_id"])){
														$inp_show_on_analysis_report = $_POST["inp_level_d_show_on_analysis_report_new_$get_level_c_id"];
														if($inp_show_on_analysis_report == "on"){
															$inp_show_on_analysis_report = "1";
														}
														else{
															$inp_show_on_analysis_report = "0";
														}
													}
													else{
														$inp_show_on_analysis_report  = "0";
													}
													$inp_show_on_analysis_report = output_html($inp_show_on_analysis_report);
													$inp_show_on_analysis_report_mysql = quote_smart($link, $inp_show_on_analysis_report);

													$inp_type = $_POST["inp_level_d_type_new_$get_level_c_id"];
													$inp_type = output_html($inp_type);
													$inp_type_mysql = quote_smart($link, $inp_type);

													if(isset($_POST["inp_level_d_flag_new_$get_level_c_id"])){
														$inp_flag = $_POST["inp_level_d_flag_new_$get_level_c_id"];
														if($inp_flag == "on"){
															$inp_flag = "1";
														}
														else{
															$inp_flag = "0";
														}
													}
													else{
														$inp_flag = "0";
													}
													$inp_flag = output_html($inp_flag);
													$inp_flag_mysql = quote_smart($link, $inp_flag);
		
													if($inp_title != ""){
														mysqli_query($link, "INSERT INTO $t_edb_case_index_item_info_level_d 
														(level_d_id, level_d_case_id, level_d_item_id, level_d_group_id, level_d_level_a_id, level_d_level_b_id, level_d_level_c_id, level_d_title, level_d_value, level_d_flag, level_d_flag_checked, level_d_type, level_d_show_on_analysis_report, level_d_created_by_user_id, level_d_created_by_user_name, level_d_created_datetime) 
														VALUES 
														(NULL, $get_current_item_case_id, $get_current_item_id, $get_current_group_id, $get_level_a_id, $get_level_b_id, $get_level_c_id, $inp_title_mysql, $inp_value_mysql, $inp_flag_mysql, 0, $inp_type_mysql, $inp_show_on_analysis_report_mysql, $my_user_id_mysql, $inp_my_user_name_mysql, '$datetime')")
														or die(mysqli_error($link)); 
														$focus = "inp_level_d_title_new_$get_level_c_id";
													} // new level D

												} // $get_level_c_id  != ""

											} // while level c

											// New level C
											$inp_title = $_POST["inp_level_c_title_new_$get_level_b_id"];
											$inp_title = output_html($inp_title);
											$inp_title_mysql = quote_smart($link, $inp_title);

											$inp_value = $_POST["inp_level_c_value_new_$get_level_b_id"];
											$inp_value = output_html($inp_value);
											$inp_value_mysql = quote_smart($link, $inp_value);

											if(isset($_POST["inp_level_c_show_on_analysis_report_new_$get_level_b_id"])){
												$inp_show_on_analysis_report = $_POST["inp_level_c_show_on_analysis_report_new_$get_level_b_id"];
												if($inp_show_on_analysis_report == "on"){
													$inp_show_on_analysis_report = "1";
												}
												else{
													$inp_show_on_analysis_report = "0";
												}
											}
											else{
												$inp_show_on_analysis_report  = "0";
											}
											$inp_show_on_analysis_report = output_html($inp_show_on_analysis_report);
											$inp_show_on_analysis_report_mysql = quote_smart($link, $inp_show_on_analysis_report);
		
											$inp_type = $_POST["inp_level_c_type_new_$get_level_b_id"];
											$inp_type = output_html($inp_type);
											$inp_type_mysql = quote_smart($link, $inp_type);

											if(isset($_POST["inp_level_c_flag_new_$get_level_b_id"])){
												$inp_flag = $_POST["inp_level_c_flag_new_$get_level_b_id"];
												if($inp_flag == "on"){
													$inp_flag = "1";
												}
												else{
													$inp_flag = "0";
												}
											}
											else{
												$inp_flag = "0";
											}
											$inp_flag = output_html($inp_flag);
											$inp_flag_mysql = quote_smart($link, $inp_flag);
		
											if($inp_title != ""){
												mysqli_query($link, "INSERT INTO $t_edb_case_index_item_info_level_c 
												(level_c_id, level_c_case_id, level_c_item_id, level_c_group_id, level_c_level_a_id, level_c_level_b_id, level_c_title, level_c_value, level_c_flag, level_c_flag_checked, level_c_type, level_c_show_on_analysis_report, level_c_created_by_user_id, level_c_created_by_user_name, level_c_created_datetime) 
												VALUES 
												(NULL, $get_current_item_case_id, $get_current_item_id, $get_current_group_id, $get_level_a_id, $get_level_b_id, $inp_title_mysql, $inp_value_mysql, $inp_flag_mysql, 0, $inp_type_mysql, $inp_show_on_analysis_report_mysql, $my_user_id_mysql, $inp_my_user_name_mysql, '$datetime')")
												or die(mysqli_error($link)); 
												$focus = "inp_level_c_title_new_$get_level_b_id";
											} // new level C


										} // $get_level_b_id != ""


									} // while level b



									// New level B
									$inp_title = $_POST["inp_level_b_title_new_$get_level_a_id"];
									$inp_title = output_html($inp_title);
									$inp_title_mysql = quote_smart($link, $inp_title);

									$inp_value = $_POST["inp_level_b_value_new_$get_level_a_id"];
									$inp_value = output_html($inp_value);
									$inp_value_mysql = quote_smart($link, $inp_value);

									if(isset($_POST["inp_level_b_show_on_analysis_report_new_$get_level_a_id"])){
										$inp_show_on_analysis_report = $_POST["inp_level_b_show_on_analysis_report_new_$get_level_a_id"];
										if($inp_show_on_analysis_report == "on"){
											$inp_show_on_analysis_report = "1";
										}
										else{
											$inp_show_on_analysis_report = "0";
										}
									}
									else{
										$inp_show_on_analysis_report  = "0";
									}
									$inp_show_on_analysis_report = output_html($inp_show_on_analysis_report);
									$inp_show_on_analysis_report_mysql = quote_smart($link, $inp_show_on_analysis_report);

									$inp_type = $_POST["inp_level_b_type_new_$get_level_a_id"];
									$inp_type = output_html($inp_type);
									$inp_type_mysql = quote_smart($link, $inp_type);

									if(isset($_POST["inp_level_b_flag_new_$get_level_a_id"])){
										$inp_flag = $_POST["inp_level_b_flag_new_$get_level_a_id"];
										if($inp_flag == "on"){
											$inp_flag = "1";
										}
										else{
											$inp_flag = "0";
										}
									}
									else{
										$inp_flag = "0";
									}
									$inp_flag = output_html($inp_flag);
									$inp_flag_mysql = quote_smart($link, $inp_flag);
		

									if($inp_title != ""){
										mysqli_query($link, "INSERT INTO $t_edb_case_index_item_info_level_b 
										(level_b_id, level_b_case_id, level_b_item_id, level_b_group_id, level_b_level_a_id, level_b_title, level_b_value, level_b_flag, level_b_flag_checked, level_b_type, level_b_show_on_analysis_report, level_b_created_by_user_id, level_b_created_by_user_name, level_b_created_datetime) 
										VALUES 
										(NULL, $get_current_item_case_id, $get_current_item_id, $get_current_group_id, $get_level_a_id, $inp_title_mysql, $inp_value_mysql, $inp_flag_mysql, 0, $inp_type_mysql, $inp_show_on_analysis_report_mysql, $my_user_id_mysql, $inp_my_user_name_mysql, '$datetime')")
										or die(mysqli_error($link)); 
										$focus = "inp_level_b_title_new_$get_level_a_id";
									}
	
								} // $get_level_a_id != ""
							} // while level a
	

							// New level a
							$inp_title = $_POST["inp_level_a_title_new"];
							$inp_title = output_html($inp_title);
							$inp_title_mysql = quote_smart($link, $inp_title);

							$inp_value = $_POST["inp_level_a_value_new"];
							$inp_value = output_html($inp_value);
							$inp_value_mysql = quote_smart($link, $inp_value);
	
							if(isset($_POST["inp_level_a_show_on_analysis_report_new"])){
								$inp_show_on_analysis_report = $_POST["inp_level_a_show_on_analysis_report_new"];
								if($inp_show_on_analysis_report == "on"){
									$inp_show_on_analysis_report = "1";
								}
								else{
									$inp_show_on_analysis_report = "0";
								}
							}
							else{
								$inp_show_on_analysis_report  = "0";
							}
							$inp_show_on_analysis_report = output_html($inp_show_on_analysis_report);
							$inp_show_on_analysis_report_mysql = quote_smart($link, $inp_show_on_analysis_report);

							$inp_type = $_POST["inp_level_a_type_new"];
							$inp_type = output_html($inp_type);
							$inp_type_mysql = quote_smart($link, $inp_type);
	
							if(isset($_POST["inp_level_a_flag_new"])){
								$inp_flag = $_POST["inp_level_a_flag_new"];
								if($inp_flag == "on"){
									$inp_flag = "1";
								}
								else{
									$inp_flag = "0";
								}
							}
							else{
								$inp_flag = "0";
							}
							$inp_flag = output_html($inp_flag);
							$inp_flag_mysql = quote_smart($link, $inp_flag);

							if($inp_title != ""){
								mysqli_query($link, "INSERT INTO $t_edb_case_index_item_info_level_a 
								(level_a_id, level_a_case_id, level_a_item_id, level_a_group_id, level_a_title, level_a_value, level_a_flag, level_a_flag_checked, level_a_type, level_a_show_on_analysis_report, level_a_created_by_user_id, level_a_created_by_user_name, level_a_created_datetime) 
								VALUES 
								(NULL, $get_current_item_case_id, $get_current_item_id, $get_current_group_id, $inp_title_mysql, $inp_value_mysql, $inp_flag_mysql, 0, $inp_type_mysql, $inp_show_on_analysis_report_mysql, $my_user_id_mysql, $inp_my_user_name_mysql, '$datetime')")
								or die(mysqli_error($link)); 
								$focus = "inp_level_a_title_new";
							}


							// Header
							$url = "open_case_evidence_edit_evidence_item_info_group_edit.php?case_id=$get_current_case_id&item_id=$get_current_item_id&group_id=$get_current_group_id&mode=$mode&l=$l&ft=success&fm=changes_saved&focus=$focus";
							header("Location: $url");
							exit;
						} // process == 1
				
						echo"

						<form method=\"POST\" action=\"open_case_evidence_edit_evidence_item_info_group_edit.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;group_id=$get_current_group_id&amp;mode=$mode&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

						<!-- TinyMCE -->
						<script type=\"text/javascript\" src=\"$root/_admin/_javascripts/tinymce/tinymce.min.js\"></script>
						<script>
						tinymce.init({
							selector: 'textarea.editor',
							plugins: 'print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern help',
							toolbar: 'formatselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | link image media pageembed | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat | addcomment',
							image_advtab: true,
							content_css: [
								'$root/_admin/_javascripts/tinymce_includes/fonts/lato/lato_300_300i_400_400i.css',
								'$root/_admin/_javascripts/tinymce_includes/codepen.min.css'
							],";
							$count_photos = 0;
							$image_list = "";
							$query = "SELECT photo_id, photo_case_id, photo_path, photo_file, photo_ext, photo_thumb_60, photo_thumb_200, photo_title, photo_description, photo_uploaded_datetime, photo_weight FROM $t_edb_case_index_photos WHERE photo_case_id=$get_current_case_id ORDER BY photo_id DESC";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_photo_id, $get_photo_case_id, $get_photo_path, $get_photo_file, $get_photo_ext, $get_photo_thumb_60, $get_photo_thumb_200, $get_photo_title, $get_photo_description, $get_photo_uploaded_datetime, $get_photo_weight) = $row;

								if($count_photos == "0"){
									$image_list  = "{ title: '$get_photo_title', value: '$root/$get_photo_path/$get_photo_file' }";
								}
								else{
									$image_list  = $image_list  . ",\n" . "								{ title: '$get_photo_title', value: '$root/$get_photo_path/$get_photo_file' }";
								}
								$count_photos++;
							}
							if($count_photos != "0"){
								echo"
								image_list: [
									$image_list  
								],
								";
							}
							echo"
							importcss_append: true,
							height: 400
						});
						</script>
						<!-- //TinyMCE -->

						<!-- Headline and Actions -->
							<table>
							 <tr>
							  <td style=\"padding-right: 6px;vertical-align: top;\">
								<p>
								<input type=\"text\" name=\"inp_group_title\" value=\"$get_current_group_title\" size=\"30\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" style=\"font-size: 110%\" />
								</p>
							  </td>
							  <td style=\"padding-right: 6px;vertical-align: top;\">
								<p>
								<input type=\"checkbox\" name=\"inp_group_show_on_analysis_report\""; if($get_current_group_show_on_analysis_report == "1"){ echo" checked=\"checked\""; } echo" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
								$l_analysis_report
								</p>
							  </td>		
							  <td style=\"vertical-align: top;\">
								<!-- Actions -->
									<p>
									";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"
										<a href=\"open_case_evidence_edit_evidence_item_info_group_view.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;group_id=$get_current_group_id&amp;mode=$mode&amp;l=$l\"><img src=\"_gfx/view.png\" alt=\"view.png\" /></a>
										<a href=\"open_case_evidence_edit_evidence_item_info_group_delete.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;group_id=$get_current_group_id&amp;mode=$mode&amp;l=$l\"><img src=\"_gfx/delete.png\" alt=\"delete.png\" /></a>
										";
									}
									echo"</p>
								<!-- //Actions -->
							  </td>
							 </tr>
							</table>
						<!-- //Headline and Actions -->


						<!-- Information groups and info on this item -->
							";
							// Focus
							if(isset($_GET['focus'])) {
								$focus = $_GET['focus'];
								$focus = strip_tags(stripslashes($focus));
								echo"
								<!-- Focus -->
									<script>
									\$(document).ready(function(){
										\$('[name=\"$focus\"]').focus();
									});
									</script>
								<!-- //Focus -->
								";
							}
		
							$count_level_a = 0;
							$query = "SELECT level_a_id, level_a_case_id, level_a_item_id, level_a_title, level_a_value, level_a_flag, level_a_flag_checked, level_a_type, level_a_show_on_analysis_report, level_a_created_by_user_id, level_a_created_by_user_name, level_a_created_datetime, level_a_updated_by_user_id, level_a_updated_by_user_name, level_a_updated_datetime FROM $t_edb_case_index_item_info_level_a WHERE level_a_case_id=$get_current_case_id AND level_a_item_id=$get_current_item_id AND level_a_group_id=$get_current_group_id ORDER BY level_a_id ASC";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_level_a_id, $get_level_a_case_id, $get_level_a_item_id, $get_level_a_title, $get_level_a_value, $get_level_a_flag, $get_level_a_flag_checked, $get_level_a_type, $get_level_a_show_on_analysis_report, $get_level_a_created_by_user_id, $get_level_a_created_by_user_name, $get_level_a_created_datetime, $get_level_a_updated_by_user_id, $get_level_a_updated_by_user_name, $get_level_a_updated_datetime) = $row;
			
								echo"
								<table>
								 <tr>
								  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
									<p>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"
										<input type=\"text\" name=\"inp_level_a_title_$get_level_a_id\" value=\"$get_level_a_title\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
										";
									}
									else{
										echo"$get_level_a_title";
									}
									echo"</p>
								  </td>
								  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
									<p>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										if($get_level_a_type == "text" OR $get_level_a_type == "headline"){
											echo"<input type=\"text\" name=\"inp_level_a_value_$get_level_a_id\" value=\"$get_level_a_value\" size=\"55\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
										}
										else{
											$get_level_a_value_replace = str_replace("<br />", "\n", $get_level_a_value);
											$array = explode("\n", $get_level_a_value_replace);
											$calcualte_rows = sizeof($array);
											if($get_level_a_type == "textarea"){
												echo"<textarea name=\"inp_level_a_value_$get_level_a_id\" rows=\"$calcualte_rows\" cols=\"80\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">$get_level_a_value_replace</textarea>";
											}
											else{
												echo"<textarea name=\"inp_level_a_value_$get_level_a_id\" rows=\"$calcualte_rows\" cols=\"80\" class=\"editor\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">$get_level_a_value</textarea>";
											}
										}
									}
									else{
										echo"$get_level_a_value";
									}
									echo"</p>
								  </td>
								  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
									<p>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"
										<input type=\"checkbox\" name=\"inp_level_a_show_on_analysis_report_$get_level_a_id\""; if($get_level_a_show_on_analysis_report == "1"){ echo" checked=\"checked\""; } echo" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
										$l_analysis_report
										";
									}
									else{
										if($get_level_a_show_on_analysis_report == "1"){
											echo"$l_analysis_report: $l_yes";
										}
										else{
											echo"$l_analysis_report: $l_no";
										}
									}
									echo"</p>
								  </td>
								  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
									<p>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"
										<select name=\"inp_level_a_type_$get_level_a_id\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">
											<option value=\"text\""; if($get_level_a_type == "text"){ echo" selected=\"selected\""; } echo">text</option>
											<option value=\"textarea\""; if($get_level_a_type == "textarea"){ echo" selected=\"selected\""; } echo">textarea</option>
											<option value=\"html\""; if($get_level_a_type == "html"){ echo" selected=\"selected\""; } echo">html</option>
											<option value=\"headline\""; if($get_level_a_type == "headline"){ echo" selected=\"selected\""; } echo">headline</option>
										</select>
										";
									}
									else{
										echo"$get_level_a_type";
									}
									echo"</p>
								  </td>
								  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
									<p>";
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"
										<input type=\"checkbox\" name=\"inp_level_a_flag_$get_level_a_id\""; if($get_level_a_flag == "1"){ echo" checked=\"checked\""; } echo" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
										$l_flagged
										";
									}
									else{
										if($get_level_a_flag == "1"){
											echo"$l_flagged: $l_yes";
										}
										else{
											echo"$l_flagged: $l_no";
										}
									}
									echo"</p>
								  </td>
								 </tr>
								";
	

								$query_b = "SELECT level_b_id, level_b_case_id, level_b_item_id, level_b_level_a_id, level_b_title, level_b_value, level_b_flag, level_b_flag_checked, level_b_type, level_b_show_on_analysis_report, level_b_created_by_user_id, level_b_created_by_user_name, level_b_created_datetime, level_b_updated_by_user_id, level_b_updated_by_user_name, level_b_updated_datetime FROM $t_edb_case_index_item_info_level_b WHERE level_b_case_id=$get_current_case_id AND level_b_item_id=$get_current_item_id AND level_b_level_a_id=$get_level_a_id AND level_b_group_id=$get_current_group_id ORDER BY level_b_id ASC";
								$result_b = mysqli_query($link, $query_b);
								while($row_b = mysqli_fetch_row($result_b)) {
									list($get_level_b_id, $get_level_b_case_id, $get_level_b_item_id, $get_level_b_level_a_id, $get_level_b_title, $get_level_b_value, $get_level_b_flag, $get_level_b_flag_checked, $get_level_b_type, $get_level_b_show_on_analysis_report, $get_level_b_created_by_user_id, $get_level_b_created_by_user_name, $get_level_b_created_datetime, $get_level_b_updated_by_user_id, $get_level_b_updated_by_user_name, $get_level_b_updated_datetime) = $row_b;
				
									echo"
									 <tr>
									  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
										<p>
										<img src=\"_gfx/evidence_item_information_child_level_b.png\" alt=\"evidence_item_information_child_level_b.png\" />";
										if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"
										<input type=\"text\" name=\"inp_level_b_title_$get_level_b_id\" value=\"$get_level_b_title\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
										";
										}
										else{
											echo"$get_level_b_title";
										}
										echo"</p>
									  </td>
									  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
										<p>";
										if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
											if($get_level_b_type == "text" OR $get_level_b_type == "headline"){
												echo"<input type=\"text\" name=\"inp_level_b_value_$get_level_b_id\" value=\"$get_level_b_value\" size=\"55\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
											}
											else{
												$get_level_b_value_replace = str_replace("<br />", "\n", $get_level_b_value);
												$array = explode("\n", $get_level_b_value_replace);
												$calcualte_rows = sizeof($array);
												if($get_level_a_type == "textarea"){
													echo"<textarea name=\"inp_level_b_value_$get_level_b_id\" rows=\"$calcualte_rows\" cols=\"80\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">$get_level_b_value_replace</textarea>";
												}
												else{
													echo"<textarea name=\"inp_level_b_value_$get_level_b_id\" rows=\"$calcualte_rows\" cols=\"80\" class=\"editor\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">$get_level_b_value</textarea>";
												}

											}
										}
										else{
											echo"$get_level_b_value";
										}
										echo"</p>
									  </td>
									  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
										<p>";
										if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
											echo"
											<input type=\"checkbox\" name=\"inp_level_b_show_on_analysis_report_$get_level_b_id\""; if($get_level_b_show_on_analysis_report == "1"){ echo" checked=\"checked\""; } echo" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
											$l_analysis_report
											";
										}
										else{
											if($get_level_b_show_on_analysis_report == "1"){
												echo"$l_analysis_report: $l_yes";
											}
											else{
												echo"$l_analysis_report: $l_no";
											}
										}
										echo"</p>
									  </td>
									  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
										<p>";
										if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
											echo"
											<select name=\"inp_level_b_type_$get_level_b_id\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">
												<option value=\"text\""; if($get_level_b_type == "text"){ echo" selected=\"selected\""; } echo">text</option>
												<option value=\"textarea\""; if($get_level_b_type == "textarea"){ echo" selected=\"selected\""; } echo">textarea</option>
												<option value=\"html\""; if($get_level_b_type == "html"){ echo" selected=\"selected\""; } echo">html</option>
												<option value=\"headline\""; if($get_level_b_type == "headline"){ echo" selected=\"selected\""; } echo">headline</option>
											</select>
											";
										}
										else{
											echo"$get_level_b_type";
										}
										echo"</p>
									  </td>
									  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
										<p>";
										if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
											echo"
											<input type=\"checkbox\" name=\"inp_level_b_flag_$get_level_b_id\""; if($get_level_b_flag == "1"){ echo" checked=\"checked\""; } echo" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
											$l_flagged
											";
										}
										else{
											if($get_level_b_flag == "1"){
												echo"$l_flagged: $l_yes";
											}
											else{
												echo"$l_flagged: $l_no";
											}
										}
										echo"</p>
									  </td>
									 </tr>
									";
	
									// Level C
									$query_c = "SELECT level_c_id, level_c_case_id, level_c_item_id, level_c_level_a_id, level_c_title, level_c_value, level_c_flag, level_c_flag_checked, level_c_type, level_c_show_on_analysis_report, level_c_created_by_user_id, level_c_created_by_user_name, level_c_created_datetime, level_c_updated_by_user_id, level_c_updated_by_user_name, level_c_updated_datetime FROM $t_edb_case_index_item_info_level_c WHERE level_c_case_id=$get_current_case_id AND level_c_item_id=$get_current_item_id AND level_c_level_a_id=$get_level_a_id AND level_c_level_b_id=$get_level_b_id AND level_c_group_id=$get_current_group_id ORDER BY level_c_id ASC";
									$result_c = mysqli_query($link, $query_c);
									while($row_c = mysqli_fetch_row($result_c)) {
										list($get_level_c_id, $get_level_c_case_id, $get_level_c_item_id, $get_level_c_level_a_id, $get_level_c_title, $get_level_c_value, $get_level_c_flag, $get_level_c_flag_checked, $get_level_c_type, $get_level_c_show_on_analysis_report, $get_level_c_created_by_user_id, $get_level_c_created_by_user_name, $get_level_c_created_datetime, $get_level_c_updated_by_user_id, $get_level_c_updated_by_user_name, $get_level_c_updated_datetime) = $row_c;
				
										echo"
										 <tr>
										  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
											<p>
											<img src=\"_gfx/evidence_item_information_child_level_c.png\" alt=\"evidence_item_information_child_level_c.png\" />";
											if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
												echo"
												<input type=\"text\" name=\"inp_level_c_title_$get_level_c_id\" value=\"$get_level_c_title\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
												";
											}
											else{
												echo"$get_level_c_title";
											}
											echo"</p>
										  </td>
										  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
											<p>";
											if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
												if($get_level_c_type == "text" OR $get_level_c_type == "headline"){
													echo"<input type=\"text\" name=\"inp_level_c_value_$get_level_c_id\" value=\"$get_level_c_value\" size=\"55\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
												}
												else{
													$get_level_c_value_replace = str_replace("<br />", "\n", $get_level_c_value);
													$array = explode("\n", $get_level_c_value_replace);
													$calcualte_rows = sizeof($array);
													if($get_level_a_type == "textarea"){
														echo"<textarea name=\"inp_level_c_value_$get_level_c_id\" rows=\"$calcualte_rows\" cols=\"80\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">$get_level_c_value_replace</textarea>";
													}
													else{
														echo"<textarea name=\"inp_level_c_value_$get_level_c_id\" rows=\"$calcualte_rows\" cols=\"80\" class=\"editor\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">$get_level_c_value</textarea>";
													}
												}
											}
											else{
												echo"$get_level_c_value";
											}
											echo"</p>
										  </td>
										  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
											<p>";
											if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
												echo"
												<input type=\"checkbox\" name=\"inp_level_c_show_on_analysis_report_$get_level_c_id\""; if($get_level_c_show_on_analysis_report == "1"){ echo" checked=\"checked\""; } echo" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
												$l_analysis_report
												";
											}
											else{
												if($get_level_c_show_on_analysis_report == "1"){
													echo"$l_analysis_report: $l_yes";
												}
												else{
													echo"$l_analysis_report: $l_no";
												}
											}
											echo"</p>
										  </td>
										  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
											<p>";
											if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
												echo"
												<select name=\"inp_level_c_type_$get_level_c_id\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">
													<option value=\"text\""; if($get_level_c_type == "text"){ echo" selected=\"selected\""; } echo">text</option>
													<option value=\"textarea\""; if($get_level_c_type == "textarea"){ echo" selected=\"selected\""; } echo">textarea</option>
													<option value=\"html\""; if($get_level_c_type == "html"){ echo" selected=\"selected\""; } echo">html</option>
													<option value=\"headline\""; if($get_level_c_type == "headline"){ echo" selected=\"selected\""; } echo">headline</option>
												</select>
												";
											}
											else{
												echo"$get_level_c_type";
											}
											echo"</p>
										  </td>
										  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
											<p>";
											if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
												echo"
												<input type=\"checkbox\" name=\"inp_level_c_flag_$get_level_c_id\""; if($get_level_c_flag == "1"){ echo" checked=\"checked\""; } echo" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
												$l_flagged
												";
											}
											else{
												if($get_level_c_flag == "1"){
													echo"$l_flagged: $l_yes";
												}
												else{
													echo"$l_flagged: $l_no";
												}
											}
											echo"</p>
										  </td>
										 </tr>
										";
	
										// Level D
										$query_d = "SELECT level_d_id, level_d_case_id, level_d_item_id, level_d_level_a_id, level_d_title, level_d_value, level_d_flag, level_d_flag_checked, level_d_type, level_d_show_on_analysis_report, level_d_created_by_user_id, level_d_created_by_user_name, level_d_created_datetime, level_d_updated_by_user_id, level_d_updated_by_user_name, level_d_updated_datetime FROM $t_edb_case_index_item_info_level_d WHERE level_d_case_id=$get_current_case_id AND level_d_item_id=$get_current_item_id AND level_d_level_a_id=$get_level_a_id AND level_d_level_b_id=$get_level_b_id AND level_d_level_c_id=$get_level_c_id AND level_d_group_id=$get_current_group_id ORDER BY level_d_id ASC";
										$result_d = mysqli_query($link, $query_d);
										while($row_d = mysqli_fetch_row($result_d)) {
											list($get_level_d_id, $get_level_d_case_id, $get_level_d_item_id, $get_level_d_level_a_id, $get_level_d_title, $get_level_d_value, $get_level_d_flag, $get_level_d_flag_checked, $get_level_d_type, $get_level_d_show_on_analysis_report, $get_level_d_created_by_user_id, $get_level_d_created_by_user_name, $get_level_d_created_datetime, $get_level_d_updated_by_user_id, $get_level_d_updated_by_user_name, $get_level_d_updated_datetime) = $row_d;
			
											echo"
											 <tr>
											  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
												<p>
												<img src=\"_gfx/evidence_item_information_child_level_d.png\" alt=\"evidence_item_information_child_level_d.png\" />";
												if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
													echo"
													<input type=\"text\" name=\"inp_level_d_title_$get_level_d_id\" value=\"$get_level_d_title\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
													";
												}
												else{
													echo"$get_level_d_title";
												}
												echo"</p>
											  </td>
											  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
												<p>";
												if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
													if($get_level_d_type == "text" OR $get_level_d_type == "headline"){
														echo"<input type=\"text\" name=\"inp_level_d_value_$get_level_d_id\" value=\"$get_level_d_value\" size=\"55\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\"";  echo" />";
													}
													else{
														$get_level_d_value_replace = str_replace("<br />", "\n", $get_level_d_value);
														$array = explode("\n", $get_level_d_value_replace);
														$calcualte_rows = sizeof($array);
														if($get_level_a_type == "textarea"){
															echo"<textarea name=\"inp_level_d_value_$get_level_d_id\" rows=\"$calcualte_rows\" cols=\"80\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">$get_level_d_value_replace</textarea>";
														}
														else{
															echo"<textarea name=\"inp_level_d_value_$get_level_d_id\" rows=\"$calcualte_rows\" cols=\"80\" class=\"editor\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">$get_level_d_value</textarea>";
														}
													}
												}
												else{
													echo"$get_level_d_value";
												}
												echo"</p>
											  </td>
											  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
												<p>";
												if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
													echo"
													<input type=\"checkbox\" name=\"inp_level_d_show_on_analysis_report_$get_level_d_id\""; if($get_level_d_show_on_analysis_report == "1"){ echo" checked=\"checked\""; } echo" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
													$l_analysis_report
													";
												}
												else{
													if($get_level_d_show_on_analysis_report == "1"){
														echo"$l_analysis_report: $l_yes";
													}
													else{
														echo"$l_analysis_report: $l_no";
													}
												}
												echo"</p>
											  </td>
											  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
												<p>";
												if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
													echo"
													<select name=\"inp_level_d_type_$get_level_d_id\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">
														<option value=\"text\""; if($get_level_d_type == "text"){ echo" selected=\"selected\""; } echo">text</option>
														<option value=\"textarea\""; if($get_level_d_type == "textarea"){ echo" selected=\"selected\""; } echo">textarea</option>
														<option value=\"html\""; if($get_level_d_type == "html"){ echo" selected=\"selected\""; } echo">html</option>
														<option value=\"headline\""; if($get_level_d_type == "headline"){ echo" selected=\"selected\""; } echo">headline</option>
													</select>
													";
												}
												else{
													echo"$get_level_d_type";
												}
												echo"</p>
										 	 </td>
											  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
												<p>";
												if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
													echo"
													<input type=\"checkbox\" name=\"inp_level_d_flag_$get_level_d_id\""; if($get_level_d_flag == "1"){ echo" checked=\"checked\""; } echo" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
													$l_flagged
													";
												}	
												else{
													if($get_level_d_flag == "1"){
														echo"$l_flagged: $l_yes";
													}
													else{
														echo"$l_flagged: $l_no";
													}
												}
												echo"</p>
											  </td>
											 </tr>
											";
										} // while level d

										// New level D
										if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
											echo"
											 <tr>
										  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
											<p>
											<img src=\"_gfx/evidence_item_information_child_level_d.png\" alt=\"evidence_item_information_child_level_d.png\" />
											<input type=\"text\" name=\"inp_level_d_title_new_$get_level_c_id\" value=\"\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
											</p>
										  </td>
										  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
											<p>
											<input type=\"text\" name=\"inp_level_d_value_new_$get_level_c_id\" value=\"\" size=\"55\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
											</p>
										  </td>
										  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
											<p>
											<input type=\"checkbox\" name=\"inp_level_d_show_on_analysis_report_new_$get_level_c_id\" checked=\"checked\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
											$l_analysis_report
											</p>
										  </td>
										  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
											<p>
											<select name=\"inp_level_d_type_new_$get_level_c_id\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">
												<option value=\"text\">text</option>
												<option value=\"textarea\">textarea</option>
												<option value=\"html\">html</option>
												<option value=\"headline\">headline</option>
											</select>
											</p>
									 	 </td>
										  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
											<p>
											<input type=\"checkbox\" name=\"inp_level_d_flag_new_$get_level_c_id\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
											$l_flagged
											</p>
										  </td>
										 </tr>
												";
										} // new level d
									} // while level c

									// New Level C
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"
										 <tr>
										  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
										<p>
										<img src=\"_gfx/evidence_item_information_child_level_c.png\" alt=\"evidence_item_information_child_level_c.png\" />
										<input type=\"text\" name=\"inp_level_c_title_new_$get_level_b_id\" value=\"\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
										</p>
									  </td>
									  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
										<p><input type=\"text\" name=\"inp_level_c_value_new_$get_level_b_id\" value=\"\" size=\"55\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></p>
									  </td>
									  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
										<p><input type=\"checkbox\" name=\"inp_level_c_show_on_analysis_report_new_$get_level_b_id\" checked=\"checked\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
										$l_analysis_report
										</p>
									  </td>
									  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
										<p>
										<select name=\"inp_level_c_type_new_$get_level_b_id\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">
											<option value=\"text\">text</option>
											<option value=\"textarea\">textarea</option>
											<option value=\"html\">html</option>
											<option value=\"headline\">headline</option>
										</select>
										</p>
									  </td>
									  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
										<p>
										<input type=\"checkbox\" name=\"inp_level_c_flag_new_$get_level_b_id\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
										$l_flagged
										</p>
									  </td>
									 </tr>
									";
									} // new level C
								} // level b

								// New Level B
								if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
									echo"
									 <tr>
									  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
										<p>
										<img src=\"_gfx/evidence_item_information_child_level_b.png\" alt=\"evidence_item_information_child_level_b.png\" />
										<input type=\"text\" name=\"inp_level_b_title_new_$get_level_a_id\" value=\"\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
										</p>
								  </td>
								  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
									<p><input type=\"text\" name=\"inp_level_b_value_new_$get_level_a_id\" value=\"\" size=\"55\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></p>
								  </td>
								  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
									<p><input type=\"checkbox\" name=\"inp_level_b_show_on_analysis_report_new_$get_level_a_id\" checked=\"checked\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
									$l_analysis_report
									</p>
								  </td>
								  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
									<p>
									<select name=\"inp_level_b_type_new_$get_level_a_id\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">
										<option value=\"text\">text</option>
										<option value=\"textarea\">textarea</option>
										<option value=\"html\">html</option>
										<option value=\"headline\">headline</option>
									</select>
									</p>
								  </td>
								  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
									<p>
									<input type=\"checkbox\" name=\"inp_level_b_flag_new_$get_level_a_id\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
									$l_flagged
									</p>
								  </td>
								 </tr>
								";
							} // new level B

							echo"
							</table>
							";
							$count_level_a = $count_level_a+1;
						} // level a
						if($get_current_group_count_level_a != "$count_level_a"){
							$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_item_info_groups SET group_count_level_a='$count_level_a' WHERE group_id=$get_current_group_id") or die(mysqli_error($link)); 
						}


						// New level A
						if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						
							echo"
							<table
							 <tr>
							  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
								<p>
								<input type=\"text\" name=\"inp_level_a_title_new\" value=\"\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
								</p>
							  </td>
							  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
								<p><input type=\"text\" name=\"inp_level_a_value_new\" value=\"\" size=\"55\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></p>
							  </td>
							  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
								<p><input type=\"checkbox\" name=\"inp_level_a_show_on_analysis_report_new\"  checked=\"checked\" "; $tabindex = $tabindex+1; echo"$tabindex\" />
								$l_analysis_report
								</p>
							  </td>
							  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
								<p><select name=\"inp_level_a_type_new\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">
									<option value=\"text\">text</option>
									<option value=\"textarea\">textarea</option>
									<option value=\"html\">html</option>
									<option value=\"headline\">headline</option>
								</select>
								</p>
							  </td>
							  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
								<p>
								<input type=\"checkbox\" name=\"inp_level_a_flag_new\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
								$l_flagged
								</p>
							  </td>
							 </tr>
							";


							echo"
							</table>
							";
							} // new level a
		
							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
								echo"
								<p>
								<input type=\"submit\" value=\"$l_save_changes\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
								</p>
								</form>";
							}
							echo"
						<!-- //Information groups and info on this item -->
						";
					} // access (can edit, is admin, moderator or editor)
				} // group found
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