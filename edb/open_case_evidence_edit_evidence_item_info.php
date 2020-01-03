<?php 
/**
*
* File: edb/open_case_evidence_edit_evidence_item_info.php
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
			$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_timezone, item_date_now_date, item_date_now_ddmmyy, item_time_now, item_correct_date_now_date, item_correct_date_now_ddmmyy, item_correct_time_now, item_adjust_clock_automatically, item_adjust_time_zone_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy FROM $t_edb_case_index_evidence_items WHERE item_id=$item_id_mysql AND item_case_id=$get_current_case_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_item_id, $get_current_item_case_id, $get_current_item_record_id, $get_current_item_record_seized_year, $get_current_item_record_seized_journal, $get_current_item_record_seized_district_number, $get_current_item_numeric_serial_number, $get_current_item_title, $get_current_item_type_id, $get_current_item_type_title, $get_current_item_confirmed_by_human, $get_current_item_human_rejected, $get_current_item_request_text, $get_current_item_requester_user_id, $get_current_item_requester_user_name, $get_current_item_requester_user_alias, $get_current_item_requester_user_email, $get_current_item_requester_user_image_path, $get_current_item_requester_user_image_file, $get_current_item_requester_user_image_thumb_40, $get_current_item_requester_user_image_thumb_50, $get_current_item_requester_user_first_name, $get_current_item_requester_user_middle_name, $get_current_item_requester_user_last_name, $get_current_item_requester_user_job_title, $get_current_item_requester_user_department, $get_current_item_in_datetime, $get_current_item_in_date, $get_current_item_in_time, $get_current_item_in_date_saying, $get_current_item_in_date_ddmmyy, $get_current_item_comment, $get_current_item_condition, $get_current_item_serial_number, $get_current_item_imei_a, $get_current_item_imei_b, $get_current_item_imei_c, $get_current_item_imei_d, $get_current_item_os_title, $get_current_item_os_version, $get_current_item_timezone, $get_current_item_date_now_date, $get_current_item_date_now_ddmmyy, $get_current_item_time_now, $get_current_item_correct_date_now_date, $get_current_item_correct_date_now_ddmmyy, $get_current_item_correct_time_now, $get_current_item_adjust_clock_automatically, $get_current_item_adjust_time_zone_automatically, $get_current_item_acquired_software_id_a, $get_current_item_acquired_software_title_a, $get_current_item_acquired_software_notes_a, $get_current_item_acquired_software_id_b, $get_current_item_acquired_software_title_b, $get_current_item_acquired_software_notes_b, $get_current_item_acquired_software_id_c, $get_current_item_acquired_software_title_c, $get_current_item_acquired_software_notes_c, $get_current_item_acquired_date, $get_current_item_acquired_time, $get_current_item_acquired_date_saying, $get_current_item_acquired_date_ddmmyy, $get_current_item_acquired_user_id, $get_current_item_acquired_user_name, $get_current_item_acquired_user_alias, $get_current_item_acquired_user_email, $get_current_item_acquired_user_image_path, $get_current_item_acquired_user_image_file, $get_current_item_acquired_user_image_thumb_40, $get_current_item_acquired_user_image_thumb_50, $get_current_item_acquired_user_first_name, $get_current_item_acquired_user_middle_name, $get_current_item_acquired_user_last_name, $get_current_item_out_date, $get_current_item_out_time, $get_current_item_out_date_saying, $get_current_item_out_date_ddmmyy) = $row;
	

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
					<h2><a href=\"open_case_evidence_view_record.php?case_id=$get_current_case_id&amp;record_id=$get_current_item_record_id&amp;l=$l\" class=\"h2\">$get_current_item_record_seized_year/$get_current_item_record_seized_journal-$get_current_item_record_seized_district_number</a>-<a href=\"open_case_evidence_edit_evidence_item_info.php?case_id=$get_current_case_id&amp;page=$page&amp;action=edit_evidence_item&amp;item_id=$get_current_item_id&amp;l=$l\" class=\"h2\">$get_current_item_numeric_serial_number</a> $get_current_item_title</h2>
			
			
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


					echo"
					<!-- Request -->
						<h2 style=\"padding:4px 4px 4px 4px;margin:0;\">$l_request</h2>
						<div class=\"cases_evidence_info_box\">
							<table>
							 <tr>
							  <td style=\"width:360px;padding-right:40px;vertical-align:top;\">
								<!-- Request left -->
								<table>
								 <tr>
								  <td style=\"text-align:right;padding: 4px 4px 4px 4px;vertical-align:top;\">
									<span>$l_in_date:</span>
								  </td>
								  <td>
									<span>$get_current_item_in_date_ddmmyy</span>
								  </td>
								 </tr>
								 <tr>
								  <td style=\"text-align:right;padding: 4px 4px 4px 4px;vertical-align:top;\">
									<span>$l_request_text:</span>
								  </td>
								  <td>
									<span>$get_current_item_request_text</span>
								  </td>
								 </tr>
								</table>
								<!-- //Request left -->
							  </td>
							  <td style=\"vertical-align:top;\">
								<!-- Request right -->
								<table>
								 <tr>
								  <td style=\"text-align:right;padding: 4px 4px 4px 4px;vertical-align:top;\">
									<span>$l_requester:</span>
								  </td>
								  <td style=\"padding: 4px 0px 4px 0px;vertical-align:top;\">
									<table>
									 <tr>
									  <td style=\"padding-right: 6px;vertical-align:top;\">
										<span>$get_current_item_requester_user_first_name $get_current_item_requester_user_middle_name $get_current_item_requester_user_last_name</span>
									  </td>
									  <td>
										<span>";
										if(file_exists("$root/$get_current_item_requester_user_image_path/$get_current_item_requester_user_image_file") && $get_current_item_requester_user_image_file != ""){
											// Thumb name
											if($get_current_item_requester_user_image_thumb_40 == ""){
												// Update thumb name
												$ext = get_extension($get_current_item_requester_user_image_file);
												$inp_thumb_name = str_replace($ext, "", $get_current_item_requester_user_image_file);
												$inp_thumb_name = $inp_thumb_name . "_40." . $ext;
												$inp_thumb_name_mysql = quote_smart($link, $inp_thumb_name);
												$result_update = mysqli_query($link, "UPDATE $t_edb_case_index SET item_requester_user_image_file=$inp_thumb_name_mysql WHERE item_id=$get_item_id") or die(mysqli_error($link));

												// Transfer
												$get_current_item_requester_user_image_thumb_40 = "$inp_thumb_name";
											}
								
											if(!(file_exists("$root/$get_current_item_requester_user_image_path/$get_current_item_requester_user_image_thumb_40"))){
												// Make thumb
												$inp_new_x = 40; // 950
												$inp_new_y = 40; // 640
												resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_current_item_requester_user_image_path/$get_current_item_requester_user_image_file", "$root/$get_current_item_requester_user_image_path/$get_current_item_requester_user_image_thumb_40");
											}


											echo"
											<a href=\"$root/users/view_profile.php?user_id=$get_current_item_requester_user_id&amp;l=$l\"><img src=\"$root/$get_current_item_requester_user_image_path/$get_current_item_requester_user_image_thumb_40\" alt=\"$get_current_item_requester_user_image_file\" /></a><br />
											";
										}
										else{
											echo"
											<a href=\"$root/users/view_profile.php?user_id=$get_current_item_requester_user_id&amp;l=$l\"><img src=\"_gfx/avatar_blank_40.png\" alt=\"avatar_blank_40.png\" /></a><br />
											";
										}
										echo"
									  </td>
									 </tr>
									</table>
								  </td>
								 </tr>
								</table>
								<!-- //Request right -->
							  </td>
							 </tr>
							</table>
						</div> <!-- //cases_evidence_info_box -->
					<!-- //Request -->

					<!-- Item -->
						<h2 style=\"padding:4px 4px 4px 4px;margin:0;\">$l_item</h2>
						<div class=\"cases_evidence_info_box\">
							<table>
							 <tr>
							  <td style=\"width:360px;padding-right:40px;vertical-align:top;\">
							<!-- Item left -->
	
								<table>
								 <tr>
								  <td style=\"text-align:right;padding: 4px 4px 4px 4px;vertical-align:top;\">
									<span>$l_type:</span>
								  </td>
								  <td>
									<span>$get_current_item_type_title</span>
								  </td>
								 </tr>
								 <tr>
								  <td style=\"text-align:right;padding: 4px 4px 4px 4px;vertical-align:top;\">
									<span>$l_title:</span>
								  </td>
								  <td>
									<span>$get_current_item_title</span>
								  </td>
								 </tr>

								 <tr>
								  <td style=\"text-align:right;padding: 4px 4px 4px 4px;vertical-align:top;\">
									<span>$l_comment:</span>
								  </td>
								  <td style=\"padding: 4px 0px 4px 0px;vertical-align:top;\">
									<span>$get_current_item_comment</span>
								  </td>
								 </tr>

								 <tr>
								  <td style=\"text-align:right;padding: 4px 4px 4px 4px;vertical-align:top;\">
									<span>$l_condition:</span>
								  </td>
								  <td style=\"padding: 4px 0px 4px 0px;vertical-align:top;\">
									<span>$get_current_item_condition</span>
								  </td>
								 </tr>

								 <tr>
								  <td style=\"text-align:right;padding: 4px 4px 4px 4px;vertical-align:top;\">
									<span>$l_serial_number:</span>
								  </td>
								  <td style=\"padding: 4px 0px 4px 0px;vertical-align:top;\">
									<span>$get_current_item_serial_number</span>
								  </td>
								 </tr>

								 <tr>
								  <td style=\"text-align:right;padding: 4px 4px 4px 4px;vertical-align:top;\">
									<span>$l_os:</span>
								  </td>
								  <td style=\"padding: 4px 0px 4px 0px;vertical-align:top;\">
									<span>$get_current_item_os_title $get_current_item_os_version</span>
								  </td>
								 </tr>
								</table>
							<!-- //Item left -->
						  </td>
						  <td style=\"vertical-align:top;\">
							<!-- Item right -->

								<table>
								 <tr>
								  <td style=\"text-align:right;padding: 4px 4px 4px 4px;vertical-align:top;\">
									<span>$l_item_time_zone:</span>
								  </td>
								  <td>
									<span>$get_current_item_timezone</span>
								  </td>
								 </tr>
								 <tr>
								  <td style=\"text-align:right;padding: 4px 4px 4px 4px;vertical-align:top;\">
									<span>$l_item_date:</span>
								  </td>
								  <td>
									<span>$get_current_item_date_now_ddmmyy $get_current_item_time_now</span>
								  </td>
								 </tr>

								 <tr>
								  <td style=\"text-align:right;padding: 4px 4px 4px 4px;vertical-align:top;\">
									<span>$l_date_now:</span>
								  </td>
								  <td style=\"padding: 4px 0px 4px 0px;vertical-align:top;\">
									<span>$get_current_item_correct_date_now_ddmmyy $get_current_item_correct_time_now</span>
								  </td>
								 </tr>

								 <tr>
								  <td style=\"text-align:right;padding: 4px 4px 4px 4px;vertical-align:top;\">
									<span>$l_adjust_clock_automatically:</span>
								  </td>
								  <td style=\"padding: 4px 0px 4px 0px;vertical-align:top;\">
									<span>";
									if($get_current_item_adjust_clock_automatically == "yes"){
										echo"$l_yes";
									}
									elseif($get_current_item_adjust_clock_automatically == "no"){
										echo"$l_no";
									}
									else{
										echo"$l_undefined";
									}
									echo"</span>
								  </td>
								 </tr>

								 <tr>
								  <td style=\"text-align:right;padding: 4px 4px 4px 4px;vertical-align:top;\">
									<span>$l_adjust_time_zone_automatically:</span>
								  </td>
								  <td style=\"padding: 4px 0px 4px 0px;vertical-align:top;\">
									<span>";
									if($get_current_item_adjust_time_zone_automatically == "yes"){
										echo"$l_yes";
									}
									elseif($get_current_item_adjust_time_zone_automatically == "no"){
										echo"$l_no";
									}
									else{
										echo"$l_undefined";
									}
									echo"</span>
								  </td>
								 </tr>
								</table>
							<!-- //Item right -->
							  </td>
							 </tr>
							</table>

							<!-- Hard disks -->
							";
							if($get_current_item_type_has_hard_disks == "1"){
								echo"
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
									<span>$get_hard_disk_manufacturer</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_hard_disk_type</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_hard_disk_size</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_hard_disk_serial</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_hard_disk_comments</span>
								  </td>
								 </tr>
								";
							} // while hard_disk
							echo"
								 </tbody>
								</table>
							";
						} // hard disks
						
						// Sim cards
						if($get_current_item_type_has_sim_cards == "1"){
							echo"
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
									<span>$get_sim_card_imei</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_sim_card_iccid</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_sim_card_imsi</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_sim_card_phone_number</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_sim_card_pin</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_sim_card_puc</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_sim_card_operator</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_sim_card_comments</span>
								  </td>
								 </tr>
								";
							} // while sim cards
							echo"
								 </tbody>
								</table>
							";
						} // sim cards
						
						// SD cards
						if($get_current_item_type_has_sd_cards == "1"){
							echo"
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
									<span>$get_sd_carc_manufacturer</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_sd_card_size</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_sd_card_serial</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_sd_card_comments</span>
								  </td>
								 </tr>
								";
							} // while sd cards
							echo"
								 </tbody>
								</table>
							";
						} // sd cards


						// Networks
						if($get_current_item_type_has_networks == "1"){
							echo"
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
									<span>"; if($get_network_is_wifi == "1"){ echo"$l_yes"; } else{ echo"$l_no"; } echo"
								  </td>
								  <td class=\"$style\">
									<span>$get_network_manufacturer</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_network_card_title</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_network_mac</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_network_serial</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_network_comments</span>
								  </td>
								 </tr>
								";
							} // while networks
							echo"
								 </tbody>
								</table>
							";
						} // networks
						echo"

							<!-- //Hard disks -->
						</div> <!-- //cases_evidence_info_box -->
					<!-- //Item -->


					<!-- Acquire -->
						<h2 style=\"padding:4px 4px 4px 4px;margin:0;\">$l_acquire</h2>
						<div class=\"cases_evidence_info_box\">
							<table>
							 <tr>
							  <td style=\"width:360px;padding-right:40px;vertical-align:top;\">
								<!-- Aquire left -->

								<table>
								 <tr>
								  <td style=\"text-align:right;padding: 4px 4px 4px 4px;vertical-align:top;\">
									<span>$l_acquired:</span>
								  </td>
								  <td>
									<span>$get_current_item_acquired_date_ddmmyy</span>
								  </td>
								 </tr>
								</table>
								<!-- //Aquire left -->
							  </td>
							  <td style=\"vertical-align:top;\">
								<!-- Aquire right -->
								<table>
								 <tr>
								  <td style=\"text-align:right;padding: 4px 4px 4px 4px;vertical-align:top;\">
									<span>$l_acquired_by:</span>
								  </td>
								  <td style=\"padding: 4px 0px 4px 0px;vertical-align:top;\">
									";
									if($get_current_item_acquired_user_id != "" && $get_current_item_acquired_user_id != "0"){
										echo"<table>
									 <tr>
									  <td style=\"padding-right: 6px;vertical-align:top;\">
										<span>$get_current_item_acquired_user_first_name $get_current_item_acquired_user_middle_name $get_current_item_acquired_user_last_name</span>
									  </td>
									  <td>
										<span>";
										if(file_exists("$root/$get_current_item_acquired_user_image_path/$get_current_item_acquired_user_image_file") && $get_current_item_acquired_user_image_file != ""){
											// Thumb name
											if($get_current_item_acquired_user_image_thumb_40 == ""){
												// Update thumb name
												$ext = get_extension($get_current_item_acquired_user_image_file);
												$inp_thumb_name = str_replace($ext, "", $get_current_item_acquired_user_image_file);
												$inp_thumb_name = $inp_thumb_name . "_40." . $ext;
												$inp_thumb_name_mysql = quote_smart($link, $inp_thumb_name);
												$result_update = mysqli_query($link, "UPDATE $t_edb_case_index SET $get_current_item_acquired_user_image_file=$inp_thumb_name_mysql WHERE item_id=$get_item_id") or die(mysqli_error($link));

												// Transfer
												$get_current_item_acquired_user_image_thumb_40 = "$inp_thumb_name";
											}
								
											if(!(file_exists("$root/$get_current_item_acquired_user_image_path/$get_current_item_acquired_user_image_thumb_40"))){
												// Make thumb
												$inp_new_x = 40; // 950
												$inp_new_y = 40; // 640
												resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_current_item_acquired_user_image_path/$get_current_item_acquired_user_image_file", "$root/$get_current_item_acquired_user_image_path/$get_current_item_acquired_user_image_thumb_40");
											}


											echo"
											<a href=\"$root/users/view_profile.php?user_id=$get_current_item_acquired_user_id&amp;l=$l\"><img src=\"$root/$get_current_item_acquired_user_image_path/$get_current_item_acquired_user_image_thumb_40\" alt=\"$get_current_item_acquired_user_image_file\" /></a><br />
											";
										}
										else{
											echo"
											<a href=\"$root/users/view_profile.php?user_id=$get_current_item_acquired_user_id&amp;l=$l\"><img src=\"_gfx/avatar_blank_40.png\" alt=\"avatar_blank_40.png\" /></a><br />
											";
										}
										echo"
									  </td>
									 </tr>
									</table>
									";
									} // aquired by not null
									echo"
									  </td>
									 </tr>
									</table>
									<!-- //Aquire right -->
								  </td>
								 </tr>
								</table>
						



							<!-- Mirror files -->
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
								<span>$l_backup_disk</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_comments</span>
							   </th>
							  </tr>
							 </thead>
							 <tbody>
							";
			
							$query = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_created_datetime, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_modified_datetime, mirror_file_modified_time, mirror_file_modified_date_saying, mirror_file_modified_date_ddmmyy, mirror_file_size_mb, mirror_file_size_human, mirror_file_backup_disk, mirror_file_comments FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_case_id=$get_current_case_id AND mirror_file_item_id=$get_current_item_id";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_mirror_file_id, $get_mirror_file_case_id, $get_mirror_file_record_id, $get_mirror_file_item_id, $get_mirror_file_path_windows, $get_mirror_file_path_linux, $get_mirror_file_file, $get_mirror_file_ext, $get_mirror_file_type, $get_mirror_file_created_datetime, $get_mirror_file_created_time, $get_mirror_file_created_date_saying, $get_mirror_file_created_date_ddmmyy, $get_mirror_file_modified_datetime, $get_mirror_file_modified_time, $get_mirror_file_modified_date_saying, $get_mirror_file_modified_date_ddmmyy, $get_mirror_file_size_mb, $get_mirror_file_size_human, $get_mirror_file_backup_disk, $get_mirror_file_comments) = $row;

								if(isset($style) && $style == ""){
									$style = "odd";
								}
								else{
									$style = "";
								}
								echo"
								 <tr>
								  <td class=\"$style\">
									<span>$get_mirror_file_path_windows</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_mirror_file_file</span>
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
									<span>$get_mirror_file_backup_disk</span>
								  </td>
								  <td class=\"$style\">
									<span>$get_mirror_file_comments</span>
								  </td>
								 </tr>
								";
							} // while mirror files
							echo"
								 </tbody>
								</table>
							<!-- //Mirror files -->
								
						</div>
					<!-- //Item -->

					<!-- Information -->
						<a id=\"information\"></a>";
						// Info groups
						$query_set = "SELECT group_id, group_case_id, group_item_id, group_title, group_show_on_analysis_report, group_count_level_a FROM $t_edb_case_index_item_info_groups WHERE group_case_id=$get_current_case_id AND group_item_id=$get_current_item_id";
						$result_set = mysqli_query($link, $query_set);
						while($row_set = mysqli_fetch_row($result_set)) {
							list($get_group_id, $get_group_case_id, $get_group_item_id, $get_group_title, $get_group_show_on_analysis_report, $get_group_count_level_a) = $row_set;


							echo"
							<a href=\"open_case_evidence_edit_evidence_item_info_group_view.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;mode=info_group_view&amp;group_id=$get_group_id&amp;l=$l\" class=\"h2\">$get_group_title</a>
						
							<table>";
							$query_a = "SELECT level_a_id, level_a_case_id, level_a_item_id, level_a_title, level_a_value, level_a_flag, level_a_flag_checked, level_a_type, level_a_show_on_analysis_report, level_a_created_by_user_id, level_a_created_by_user_name, level_a_created_datetime, level_a_updated_by_user_id, level_a_updated_by_user_name, level_a_updated_datetime FROM $t_edb_case_index_item_info_level_a WHERE level_a_case_id=$get_current_case_id AND level_a_item_id=$get_current_item_id AND level_a_group_id=$get_group_id ORDER BY level_a_id ASC";
							$result_a = mysqli_query($link, $query_a);
							while($row_a = mysqli_fetch_row($result_a)) {
								list($get_level_a_id, $get_level_a_case_id, $get_level_a_item_id, $get_level_a_title, $get_level_a_value, $get_level_a_flag, $get_level_a_flag_checked, $get_level_a_type, $get_level_a_show_on_analysis_report, $get_level_a_created_by_user_id, $get_level_a_created_by_user_name, $get_level_a_created_datetime, $get_level_a_updated_by_user_id, $get_level_a_updated_by_user_name, $get_level_a_updated_datetime) = $row_a;
			
								echo"
								 <tr>
								  <td style=\"padding: 0px 6px 4px 0px;vertical-align:top;\""; if($get_level_a_value == ""){ echo" colspan=\"2\""; } echo">
									";
								
									if($get_level_a_type == "headline"){ 
										echo"<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:8px 0px 0px 0px;margin:0;\"><b>$get_level_a_title</b>"; if($get_level_a_flag == "1"){ echo" <img src=\"_gfx/flag_red_16x16.png\" alt=\"flag_red_16x16.png\" />\n"; } echo"</p>";
									}
									else{
										echo"<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:8px 0px 0px 0px;margin:0;\">$get_level_a_title:"; if($get_level_a_flag == "1"){ echo" <img src=\"_gfx/flag_red_16x16.png\" alt=\"flag_red_16x16.png\" />\n"; } echo"</p>";
									}
									echo"
								  </td>";
								if($get_level_a_type != "headline"){ 
									echo"
									  <td style=\"padding: 0px 6px 4px 0px;vertical-align:top;\">
										";
										if($get_level_a_type == "html"){
											echo"
											$get_level_a_value
											";
										}
										else{
											echo"
											<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:8px 0px 0px 0px;margin:0;\">$get_level_a_value</p>
											";
										}
										echo"
									  </td>";
								}
								echo"
								 </tr>
								";

								// B
								$query_b = "SELECT level_b_id, level_b_case_id, level_b_item_id, level_b_level_a_id, level_b_title, level_b_value, level_b_flag, level_b_flag_checked, level_b_type, level_b_show_on_analysis_report, level_b_created_by_user_id, level_b_created_by_user_name, level_b_created_datetime, level_b_updated_by_user_id, level_b_updated_by_user_name, level_b_updated_datetime FROM $t_edb_case_index_item_info_level_b WHERE level_b_case_id=$get_current_case_id AND level_b_item_id=$get_current_item_id AND level_b_level_a_id=$get_level_a_id AND level_b_group_id=$get_group_id ORDER BY level_b_id ASC";
								$result_b = mysqli_query($link, $query_b);
								while($row_b = mysqli_fetch_row($result_b)) {
									list($get_level_b_id, $get_level_b_case_id, $get_level_b_item_id, $get_level_b_level_a_id, $get_level_b_title, $get_level_b_value, $get_level_b_flag, $get_level_b_flag_checked, $get_level_b_type, $get_level_b_show_on_analysis_report, $get_level_b_created_by_user_id, $get_level_b_created_by_user_name, $get_level_b_created_datetime, $get_level_b_updated_by_user_id, $get_level_b_updated_by_user_name, $get_level_b_updated_datetime) = $row_b;
			
									echo"
											 <tr>
											  <td style=\"padding: 0px 6px 4px 0px;vertical-align:top;\""; if($get_level_b_type == "headline"){ echo" colspan=\"2\""; } echo">
												";
												if($get_level_b_type == "headline"){ 
													echo"<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:8px 0px 0px 10px;margin:0;\"><b>$get_level_b_title</b> "; if($get_level_b_flag == "1"){ echo" <img src=\"_gfx/flag_red_16x16.png\" alt=\"flag_red_16x16.png\" />\n"; } echo"</p>";
												}
												else{
													echo"<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:8px 0px 0px 10px;margin:0;\">$get_level_b_title: "; if($get_level_b_flag == "1"){ echo" <img src=\"_gfx/flag_red_16x16.png\" alt=\"flag_red_16x16.png\" />\n"; } echo"</p>";
												}
												echo"
											  </td>";
											if($get_level_b_type != "headline"){ 
												echo"
												  <td style=\"padding: 0px 6px 4px 0px;vertical-align:top;\">
													";
													if($get_level_b_type == "html"){
														echo"
														$get_level_b_value
														";
													}
													else{
														echo"
														<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:8px 0px 0px 0px;margin:0;\">$get_level_b_value</p>
														";
													}
													echo"
												  </td>";
											}
											echo"
											 </tr>
											";

									// C
									$query_c = "SELECT level_c_id, level_c_case_id, level_c_item_id, level_c_level_a_id, level_c_title, level_c_value, level_c_flag, level_c_flag_checked, level_c_type, level_c_show_on_analysis_report, level_c_created_by_user_id, level_c_created_by_user_name, level_c_created_datetime, level_c_updated_by_user_id, level_c_updated_by_user_name, level_c_updated_datetime FROM $t_edb_case_index_item_info_level_c WHERE level_c_case_id=$get_current_case_id AND level_c_item_id=$get_current_item_id  AND level_c_level_a_id=$get_level_a_id AND level_c_level_b_id=$get_level_b_id AND level_c_group_id=$get_group_id ORDER BY level_c_id ASC";
									$result_c = mysqli_query($link, $query_c);
									while($row_c = mysqli_fetch_row($result_c)) {
										list($get_level_c_id, $get_level_c_case_id, $get_level_c_item_id, $get_level_c_level_a_id, $get_level_c_title, $get_level_c_value, $get_level_c_flag, $get_level_c_flag_checked, $get_level_c_type, $get_level_c_show_on_analysis_report, $get_level_c_created_by_user_id, $get_level_c_created_by_user_name, $get_level_c_created_datetime, $get_level_c_updated_by_user_id, $get_level_c_updated_by_user_name, $get_level_c_updated_datetime) = $row_c;
			
										echo"
												 <tr>
												  <td style=\"padding: 0px 6px 4px 0px;vertical-align:top;\""; if($get_level_c_type == "headline"){ echo" colspan=\"2\""; } echo">
													";
													if($get_level_c_type == "headline"){ 
														echo"<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:8px 0px 0px 20px;margin:0;\"><b>$get_level_c_title</b>"; if($get_level_c_flag == "1"){ echo" <img src=\"_gfx/flag_red_16x16.png\" alt=\"flag_red_16x16.png\" />\n"; } echo"</p>";
													}
													else{
														echo"<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:8px 0px 0px 20px;margin:0;\">$get_level_c_title:"; if($get_level_c_flag == "1"){ echo" <img src=\"_gfx/flag_red_16x16.png\" alt=\"flag_red_16x16.png\" />\n"; } echo"</p>";
													}
													echo"
												  </td>";
												if($get_level_c_type != "headline"){
													echo"
													  <td style=\"padding: 0px 6px 4px 0px;vertical-align:top;\">
														";
														if($get_level_c_type == "html"){
															echo"
															$get_level_c_value
															";
														}
														else{
															echo"
															<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:8px 0px 0px 0px;margin:0;\">$get_level_c_value</p>
															";
														}
														echo"
													  </td>";
												}
												echo"
												 </tr>
												";


										// D
										$query_d = "SELECT level_d_id, level_d_case_id, level_d_item_id, level_d_level_a_id, level_d_title, level_d_value, level_d_flag, level_d_flag_checked, level_d_type, level_d_show_on_analysis_report, level_d_created_by_user_id, level_d_created_by_user_name, level_d_created_datetime, level_d_updated_by_user_id, level_d_updated_by_user_name, level_d_updated_datetime FROM $t_edb_case_index_item_info_level_d WHERE level_d_case_id=$get_current_item_case_id AND level_d_item_id=$get_current_item_id  AND level_d_level_a_id=$get_level_a_id AND level_d_level_b_id=$get_level_b_id AND level_d_level_c_id=$get_level_c_id AND level_d_group_id=$get_group_id ORDER BY level_d_id ASC";
										$result_d = mysqli_query($link, $query_d);
										while($row_d = mysqli_fetch_row($result_d)) {
											list($get_level_d_id, $get_level_d_case_id, $get_level_d_item_id, $get_level_d_level_a_id, $get_level_d_title, $get_level_d_value, $get_level_d_flag, $get_level_d_flag_checked, $get_level_d_type, $get_level_d_show_on_analysis_report, $get_level_d_created_by_user_id, $get_level_d_created_by_user_name, $get_level_d_created_datetime, $get_level_d_updated_by_user_id, $get_level_d_updated_by_user_name, $get_level_d_updated_datetime) = $row_d;
			
											echo"
													 <tr>
													  <td style=\"padding: 0px 6px 4px 0px;vertical-align:top;\""; if($get_level_d_type == "headline"){ echo" colspan=\"2\""; } echo">
														";
														if($get_level_d_type == "headline"){ 
															echo"<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:8px 0px 0px 30px;margin:0;\"><b>$get_level_d_title</b>"; if($get_level_d_flag == "1"){ echo" <img src=\"_gfx/flag_red_16x16.png\" alt=\"flag_red_16x16.png\" />\n"; } echo"</p>";
														}
														else{
															echo"<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:8px 0px 0px 30px;margin:0;\">$get_level_d_title:"; if($get_level_d_flag == "1"){ echo" <img src=\"_gfx/flag_red_16x16.png\" alt=\"flag_red_16x16.png\" />\n"; } echo"</p>";
														}
														echo"
													  </td>";
													if($get_level_d_type != "headline"){
														echo"
														  <td style=\"padding: 0px 6px 4px 0px;vertical-align:top;\">
															";
															if($get_level_d_type == "html"){
																echo"
																$get_level_d_value
																";
															}
															else{
																echo"
																<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:8px 0px 0px 0px;margin:0;\">$get_level_d_value</p>
																";
															}
															echo"
														  </td>";
													}
													echo"
													 </tr>
													";
										} // while d
									} // while c
								} // while b
							} // while a
						} // while groups
						echo"
						</table>
					<!-- //Information -->
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