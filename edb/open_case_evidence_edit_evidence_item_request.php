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
include("$root/_admin/_translations/site/$l/users/ts_users.php");


/*- Tables ---------------------------------------------------------------------------- */
$t_edb_stats_acquirements_per_month		= $mysqlPrefixSav . "edb_stats_acquirements_per_month";
$t_edb_stats_requests_user_per_month		= $mysqlPrefixSav . "edb_stats_requests_user_per_month";
$t_edb_stats_requests_department_per_month	= $mysqlPrefixSav . "edb_stats_requests_department_per_month";

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
			$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_in_date_ddmmyyyy, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_timezone, item_date_now_date, item_date_now_ddmmyy, item_time_now, item_correct_date_now_date, item_correct_date_now_ddmmyy, item_correct_time_now, item_adjust_clock_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy FROM $t_edb_case_index_evidence_items WHERE item_id=$item_id_mysql AND item_case_id=$get_current_case_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_item_id, $get_current_item_case_id, $get_current_item_record_id, $get_current_item_record_seized_year, $get_current_item_record_seized_journal, $get_current_item_record_seized_district_number, $get_current_item_numeric_serial_number, $get_current_item_title, $get_current_item_type_id, $get_current_item_type_title, $get_current_item_confirmed_by_human, $get_current_item_human_rejected, $get_current_item_request_text, $get_current_item_requester_user_id, $get_current_item_requester_user_name, $get_current_item_requester_user_alias, $get_current_item_requester_user_email, $get_current_item_requester_user_image_path, $get_current_item_requester_user_image_file, $get_current_item_requester_user_image_thumb_40, $get_current_item_requester_user_image_thumb_50, $get_current_item_requester_user_first_name, $get_current_item_requester_user_middle_name, $get_current_item_requester_user_last_name, $get_current_item_requester_user_job_title, $get_current_item_requester_user_department, $get_current_item_in_datetime, $get_current_item_in_date, $get_current_item_in_time, $get_current_item_in_date_saying, $get_current_item_in_date_ddmmyy, $get_current_item_in_date_ddmmyyyy, $get_current_item_comment, $get_current_item_condition, $get_current_item_serial_number, $get_current_item_imei_a, $get_current_item_imei_b, $get_current_item_imei_c, $get_current_item_imei_d, $get_current_item_os_title, $get_current_item_os_version, $get_current_item_timezone, $get_current_item_date_now_date, $get_current_item_date_now_ddmmyy, $get_current_item_time_now, $get_current_item_correct_date_now_date, $get_current_item_correct_date_now_ddmmyy, $get_current_item_correct_time_now, $get_current_item_adjust_clock_automatically, $get_current_item_acquired_software_id_a, $get_current_item_acquired_software_title_a, $get_current_item_acquired_software_notes_a, $get_current_item_acquired_software_id_b, $get_current_item_acquired_software_title_b, $get_current_item_acquired_software_notes_b, $get_current_item_acquired_software_id_c, $get_current_item_acquired_software_title_c, $get_current_item_acquired_software_notes_c, $get_current_item_acquired_date, $get_current_item_acquired_time, $get_current_item_acquired_date_saying, $get_current_item_acquired_date_ddmmyy, $get_current_item_acquired_user_id, $get_current_item_acquired_user_name, $get_current_item_acquired_user_alias, $get_current_item_acquired_user_email, $get_current_item_acquired_user_image_path, $get_current_item_acquired_user_image_file, $get_current_item_acquired_user_image_thumb_40, $get_current_item_acquired_user_image_thumb_50, $get_current_item_acquired_user_first_name, $get_current_item_acquired_user_middle_name, $get_current_item_acquired_user_last_name, $get_current_item_out_date, $get_current_item_out_time, $get_current_item_out_date_saying, $get_current_item_out_date_ddmmyy) = $row;
	

			if($get_current_item_id == ""){
				echo"<h1>Server error 404</h1><p>Record not found</p>";
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
					$inp_request_text = $_POST['inp_request_text'];
						$inp_request_text = output_html($inp_request_text);
						$inp_request_text_mysql = quote_smart($link, $inp_request_text);
					
						$inp_requester_user_name = $_POST['inp_requester_user_name'];
						$inp_requester_user_name = output_html($inp_requester_user_name);
						$inp_requester_user_name_mysql = quote_smart($link, $inp_requester_user_name);
				
						// Requester user
						$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_name=$inp_requester_user_name_mysql";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_requester_user_id, $get_requester_user_email, $get_requester_user_name, $get_requester_user_alias, $get_requester_user_language, $get_requester_user_last_online, $get_requester_user_rank, $get_requester_user_login_tries) = $row;

						if($get_requester_user_id == ""){
							$get_requester_user_id = "0";
							$get_requester_user_name = "";
							$get_requester_user_alias = "";
							$get_requester_user_email = "";

							$get_requester_photo_destination = "";
							$get_requester_photo_thumb_40 = "";
							$get_requester_photo_thumb_50 = "";

							$get_requester_profile_first_name = "";
							$get_requester_profile_middle_name = "";
							$get_requester_profile_last_name = "";
			
							$get_requester_professional_position = "";
							$get_requester_professional_department = "";
						}
						else{
							// Requester photo
							$query = "SELECT photo_id, photo_destination, photo_thumb_40, photo_thumb_50 FROM $t_users_profile_photo WHERE photo_user_id=$get_requester_user_id AND photo_profile_image='1'";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_requester_photo_id, $get_requester_photo_destination, $get_requester_photo_thumb_40, $get_requester_photo_thumb_50) = $row;

							// Requester Profile
							$query = "SELECT profile_id, profile_first_name, profile_middle_name, profile_last_name, profile_about FROM $t_users_profile WHERE profile_user_id=$get_requester_user_id";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_requester_profile_id, $get_requester_profile_first_name, $get_requester_profile_middle_name, $get_requester_profile_last_name, $get_requester_profile_about) = $row;

							// Requester professional
							$query = "SELECT professional_id, professional_user_id, professional_company, professional_company_location, professional_department, professional_work_email, professional_position FROM $t_users_professional WHERE professional_user_id=$get_requester_user_id";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_requester_professional_id, $get_requester_professional_user_id, $get_requester_professional_company, $get_requester_professional_company_location, $get_requester_professional_department, $get_requester_professional_work_email, $get_requester_professional_position) = $row;
						}

						$inp_requester_user_name_mysql = quote_smart($link, $get_requester_user_name);
						$inp_requester_user_alias_mysql = quote_smart($link, $get_requester_user_alias);
						$inp_requester_user_email_mysql = quote_smart($link, $get_requester_user_email);

						$inp_requester_user_image_path = "_uploads/users/images/$get_requester_user_id";
						$inp_requester_user_image_path_mysql = quote_smart($link, $inp_requester_user_image_path);

						$inp_requester_user_image_file_mysql = quote_smart($link, $get_requester_photo_destination);
		
						$inp_requester_user_image_thumb_a_mysql = quote_smart($link, $get_requester_photo_thumb_40);
						$inp_requester_user_image_thumb_b_mysql = quote_smart($link, $get_requester_photo_thumb_50);

						$inp_requester_user_first_name_mysql = quote_smart($link, $get_requester_profile_first_name);
						$inp_requester_user_middle_name_mysql = quote_smart($link, $get_requester_profile_middle_name);
						$inp_requester_user_last_name_mysql = quote_smart($link, $get_requester_profile_last_name);
			
						$inp_requester_user_job_title_mysql = quote_smart($link, $get_requester_professional_position);
						$inp_requester_user_department_mysql = quote_smart($link, $get_requester_professional_department);
						$inp_requester_professional_company_location_mysql = quote_smart($link, $get_requester_professional_company_location);


						$result = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
									item_request_text=$inp_request_text_mysql,
									item_requester_user_id=$get_requester_user_id, item_requester_user_name=$inp_requester_user_name_mysql, 
									item_requester_user_alias=$inp_requester_user_alias_mysql, 
									item_requester_user_email=$inp_requester_user_email_mysql, 
									item_requester_user_image_path=$inp_requester_user_image_path_mysql, 
									item_requester_user_image_file=$inp_requester_user_image_file_mysql, 
									item_requester_user_image_thumb_40=$inp_requester_user_image_thumb_a_mysql, 
									item_requester_user_image_thumb_50=$inp_requester_user_image_thumb_b_mysql, 
									item_requester_user_first_name=$inp_requester_user_first_name_mysql, 
									item_requester_user_middle_name=$inp_requester_user_middle_name_mysql, 
									item_requester_user_last_name=$inp_requester_user_last_name_mysql, 
									item_requester_user_job_title=$inp_requester_user_job_title_mysql, 
									item_requester_user_department=$inp_requester_user_department_mysql 
									 WHERE item_id=$get_current_item_id") or die(mysqli_error($link));


						$inp_in_day = $_POST['inp_in_day'];
						$inp_in_day = output_html($inp_in_day);
						

						$inp_in_month = $_POST['inp_in_month'];
						$inp_in_month = output_html($inp_in_month);
						
						$inp_in_year = $_POST['inp_in_year'];
						$inp_in_year = output_html($inp_in_year);
						
					
						if($inp_in_day == "" OR $inp_in_month == "" OR $inp_in_year == ""){
							$result = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
									item_in_datetime=NULL,
									item_in_time=NULL,
									item_in_date_saying=NULL,
									item_in_date_ddmmyy=NULL
									 WHERE item_id=$get_current_item_id") or die(mysqli_error($link));

						}
						else{
							$inp_in_date = $inp_in_year . "-" . $inp_in_month . "-" . $inp_in_day;
							$inp_in_date_mysql = quote_smart($link, $inp_in_date);

							$inp_in_time = strtotime($inp_in_date);
							$inp_in_time_mysql = quote_smart($link, $inp_in_time);
					
	
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
		
							$inp_in_day_saying = str_replace("0", "", $inp_in_day);
							$inp_in_month_saying = str_replace("0", "", $inp_in_month);
					
							$inp_in_date_saying = $inp_in_day_saying . ". " . $l_month_array[$inp_in_month_saying] . " " . $inp_in_year;
							$inp_in_date_saying_mysql = quote_smart($link, $inp_in_date_saying);
					
							$inp_in_date_ddmmyy_year = substr($inp_in_year, 2, 2);
							$inp_in_date_ddmmyy = $inp_in_day . "." . $inp_in_month  . "." . $inp_in_date_ddmmyy_year;
							$inp_in_date_ddmmyy_mysql = quote_smart($link, $inp_in_date_ddmmyy);
							$result = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
									item_in_datetime=$inp_in_date_mysql,
									item_in_time=$inp_in_time_mysql,
									item_in_date_saying=$inp_in_date_saying_mysql,
									item_in_date_ddmmyy=$inp_in_date_ddmmyy_mysql 
									 WHERE item_id=$get_current_item_id") or die(mysqli_error($link));

						} // Dates

						// Number of requests per month: User
						if($get_requester_user_id != "$get_current_item_requester_user_id"){
							$date_yyyy = date("Y");
							$date_mm = date("m");
							
							$query = "SELECT stats_req_usr_id, stats_req_usr_counter FROM $t_edb_stats_requests_user_per_month WHERE stats_req_usr_year=$date_yyyy AND stats_req_usr_month=$date_mm AND stats_req_usr_user_id=$get_requester_user_id";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_stats_req_usr_id, $get_stats_req_usr_counter) = $row;
							if($get_stats_req_usr_id == ""){
								mysqli_query($link, "INSERT INTO $t_edb_stats_requests_user_per_month 
								(stats_req_usr_id, stats_req_usr_year, stats_req_usr_month, stats_req_usr_district_id, stats_req_usr_station_id,stats_req_usr_user_id, stats_req_usr_user_name, stats_req_usr_user_alias, stats_req_usr_user_first_name, stats_req_usr_user_middle_name, stats_req_usr_user_last_name, stats_req_usr_user_position, stats_req_usr_user_department, stats_req_usr_user_location, stats_req_usr_counter) 
								VALUES 
								(NULL, $date_yyyy, $date_mm, $get_current_case_district_id, $get_current_case_station_id, $get_requester_user_id, $inp_requester_user_name_mysql, $inp_requester_user_alias_mysql, $inp_requester_user_first_name_mysql, $inp_requester_user_middle_name_mysql, $inp_requester_user_last_name_mysql, $inp_requester_user_job_title_mysql, $inp_requester_user_department_mysql, $inp_requester_professional_company_location_mysql, 1)")
								or die(mysqli_error($link));
							}
							else{
								$inp_counter = $get_stats_req_usr_counter+1;
								$result = mysqli_query($link, "UPDATE $t_edb_stats_requests_user_per_month SET stats_req_usr_counter=$inp_counter WHERE stats_req_usr_id=$get_stats_req_usr_id") or die(mysqli_error($link));

							}

							// Number of requests per month: Department
							$query = "SELECT stats_req_dep_id, stats_req_dep_counter FROM $t_edb_stats_requests_department_per_month WHERE stats_req_dep_year=$date_yyyy AND stats_req_dep_month=$date_mm AND stats_req_dep_department=$inp_requester_user_department_mysql AND stats_req_dep_location=$inp_requester_professional_company_location_mysql";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_stats_req_dep_id, $get_stats_req_dep_counter) = $row;
							if($get_stats_req_dep_id == ""){
								mysqli_query($link, "INSERT INTO $t_edb_stats_requests_department_per_month 
								(stats_req_dep_id, stats_req_dep_year, stats_req_dep_month, stats_req_dep_district_id, stats_req_dep_station_id, stats_req_dep_department, stats_req_dep_location, stats_req_dep_counter) 
								VALUES 
								(NULL, $date_yyyy, $date_mm, $get_current_case_district_id, $get_current_case_station_id, $inp_requester_user_department_mysql, $inp_requester_professional_company_location_mysql, 1)")
								or die(mysqli_error($link));
							}
							else{
								$inp_counter = $get_stats_req_dep_counter+1;
								$result = mysqli_query($link, "UPDATE $t_edb_stats_requests_department_per_month SET stats_req_dep_counter=$inp_counter WHERE stats_req_dep_id=$get_stats_req_dep_id") or die(mysqli_error($link));

							}

						} // new requester




						$url = "open_case_evidence_edit_evidence_item_request.php?case_id=$get_current_case_id&item_id=$get_current_item_id&mode=$mode&l=$l&ft=success&fm=changes_saved";
						header("Location: $url");
						exit;
				}
				echo"
				<h2>$l_request</h2>

				<!-- Edit evidence request -->
					";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"
						<!-- Focus -->
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_request_text\"]').focus();
						});
						</script>
						<!-- //Focus -->

						<form method=\"POST\" action=\"open_case_evidence_edit_evidence_item_request.php?case_id=$get_current_case_id&amp;page=$page&amp;action=$action&amp;item_id=$get_current_item_id&amp;mode=$mode&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
						";
					}
					echo"

					<p>$l_request_text:<br />
					";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						$get_current_item_request_text = str_replace("<br />", "\n", $get_current_item_request_text);
						echo"<textarea name=\"inp_request_text\" rows=\"5\" cols=\"80\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />$get_current_item_request_text</textarea>";
					}
					else{
						echo"$get_current_item_request_text";
					}
					echo"</p>


					<p>$l_requester_user_name 
					<span class=\"smal\">
					(<a href=\"open_case_evidence_new_requester.php?case_id=$get_current_case_id&amp;l=$l\" target=\"_blank\" class=\"smal\">$l_new_requester</a>
					&middot;
					<a href=\"$root/_admin/index.php?open=users&amp;editor_language=$l&amp;l=$l\" target=\"_blank\" class=\"smal\">$l_edit_users</a>)</span>:<br />
					";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"<input type=\"text\" name=\"inp_requester_user_name\" id=\"autosearch_inp_search_for_requester\" value=\"$get_current_item_requester_user_name\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
					}
					else{
						echo"$get_current_item_requester_user_name";
					}
					echo"</p>
					<div class=\"open_requester_results\">
					</div>

						<!-- Responsible Autocomplete -->
						<script>
							\$(document).ready(function () {
								\$('#autosearch_inp_search_for_requester').keyup(function () {
       									// getting the value that user typed
       									var searchString    = $(\"#autosearch_inp_search_for_requester\").val();
 									// forming the queryString
      									var data            = 'l=$l&q=' + searchString;
         
        								// if searchString is not empty
        								if(searchString) {
           									// ajax call
            									\$.ajax({
                									type: \"GET\",
               										url: \"open_case_evidence_new_record_requester_jquery_search.php\",
                									data: data,
											beforeSend: function(html) { // this happens before actual call
												\$(\".open_requester_results\").html(''); 
											},
               										success: function(html){
                    										\$(\".open_requester_results\").append(html);
              										}
            									});
       									}
        								return false;
            							});
         				 		});
							</script>
						<!-- //Responsible Autocomplete -->



					<p>$l_in: ";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						
						$in_year = substr($get_current_item_in_datetime, 0, 4);
						$in_month = substr($get_current_item_in_datetime, 5, 2);
						$in_month = str_replace("0", "", $in_month);
						$in_day = substr($get_current_item_in_datetime, 8, 2);
						echo" <a href=\"#in\" id=\"input_date_now\"><img src=\"_gfx/ic_event_black_18dp.png\" alt=\"ic_event_black_18dp.png\" /></a><br />
						<select name=\"inp_in_day\" id=\"inp_in_day\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" >
						<option value=\"\">- $l_day -</option>\n";
						for($x=1;$x<32;$x++){
							if($x<10){
								$y = 0 . $x;
							}
							else{
								$y = $x;
							}
							echo"<option value=\"$y\""; if($in_day == "$y"){ echo" selected=\"selected\""; } echo">$x</option>\n";
						}
						echo"
						</select>

						<select name=\"inp_in_month\" id=\"inp_acquired_month\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" >
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
								echo"<option value=\"$y\""; if($in_month == "$y"){ echo" selected=\"selected\""; } echo">$l_month_array[$x]</option>\n";
							}
							echo"
						</select>

						<select name=\"inp_in_year\" id=\"inp_in_year\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" >
							<option value=\"\">- $l_year -</option>\n";
							$year = date("Y");
							for($x=0;$x<150;$x++){
								echo"<option value=\"$year\""; if($in_year == "$year"){ echo" selected=\"selected\""; } echo">$year</option>\n";
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
            								\$(\"#inp_in_day\").val(day);
            								\$(\"#inp_in_month\").val(month);
            								\$(\"#inp_in_year\").val(year);
            								return false;
       								});
    							});
						</script>
						<!-- //Input date now on click -->
						";
					}
					else{
						echo"<br />$get_current_item_in_date_ddmmyyyy";
					}
					
					
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"
						<p>
						<input type=\"submit\" value=\"$l_save_changes\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
						</p>
						</form>
						";
					}
					echo"
				<!-- //Request --> 
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