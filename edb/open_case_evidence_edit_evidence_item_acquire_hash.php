<?php 
/**
*
* File: edb/open_case_evidence_edit_evidence_item_acquire_hash.php
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

/*- Tables ---------------------------------------------------------------------------- */
$t_edb_case_index_evidence_items_mirror_files_hash	= $mysqlPrefixSav . "edb_case_index_evidence_items_mirror_files_hash";

/*- Language --------------------------------------------------------------------------- */
include("$root/_admin/_translations/site/$l/edb/ts_edb.php");
include("$root/_admin/_translations/site/$l/edb/ts_open_case_overview.php");
include("$root/_admin/_translations/site/$l/edb/ts_open_case_evidence_edit_evidence_item_info.php");
include("$root/_admin/_translations/site/$l/edb/ts_open_case_evidence_edit_evidence_item_acquire.php");
include("$root/_admin/_translations/site/$l/users/ts_users.php");


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
						<a href=\"open_case_evidence_view_record.php?case_id=$get_current_case_id&amp;page=$page&amp;action=open_record&amp;year=$get_current_item_record_seized_year&amp;journal=$get_current_item_record_seized_journal&amp;district_number=$get_current_item_record_seized_district_number&amp;l=$l\">$get_current_item_record_seized_year/$get_current_item_record_seized_journal-$get_current_item_record_seized_district_number</a>
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
								<li><a href=\"open_case_evidence_edit_evidence_item_acquire.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;mode=acquire&amp;l=$l\""; if($mode == "acquire"){ echo" class=\"active\""; } echo">$l_acquire</a></li>
								<li><a href=\"open_case_evidence_edit_evidence_item_information.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;mode=information&amp;l=$l\""; if($mode == "information"){ echo" class=\"active\""; } echo">$l_information</a></li>
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

				echo"
				<h2>$l_acquire - &gt; $l_mirror_files</h2>

				<!-- Mirror files -->";

					$query = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_confirmed_by_human, mirror_file_human_rejected, mirror_file_created_datetime, mirror_file_created_date, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_created_date_ddmmyyyy, mirror_file_modified_datetime, mirror_file_modified_date, mirror_file_modified_time, mirror_file_modified_date_saying, mirror_file_modified_date_ddmmyy, mirror_file_modified_date_ddmmyyyy, mirror_file_size_bytes, mirror_file_size_mb, mirror_file_size_human, mirror_file_backup_disk, mirror_file_exists, mirror_file_exists_agent_tries_counter, mirror_file_ready_for_automated_machine, mirror_file_ready_agent_tries_counter, mirror_file_comments FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_case_id=$get_current_case_id AND mirror_file_item_id=$get_current_item_id";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_mirror_file_id, $get_mirror_file_case_id, $get_mirror_file_record_id, $get_mirror_file_item_id, $get_mirror_file_path_windows, $get_mirror_file_path_linux, $get_mirror_file_file, $get_mirror_file_ext, $get_mirror_file_type, $get_mirror_file_confirmed_by_human, $get_mirror_file_human_rejected, $get_mirror_file_created_datetime, $get_mirror_file_created_date, $get_mirror_file_created_time, $get_mirror_file_created_date_saying, $get_mirror_file_created_date_ddmmyy, $get_mirror_file_created_date_ddmmyyyy, $get_mirror_file_modified_datetime, $get_mirror_file_modified_date, $get_mirror_file_modified_time, $get_mirror_file_modified_date_saying, $get_mirror_file_modified_date_ddmmyy, $get_mirror_file_modified_date_ddmmyyyy, $get_mirror_file_size_bytes, $get_mirror_file_size_mb, $get_mirror_file_size_human, $get_mirror_file_backup_disk, $get_mirror_file_exists, $get_mirror_file_exists_agent_tries_counter, $get_mirror_file_ready_for_automated_machine, $get_mirror_file_ready_agent_tries_counter, $get_mirror_file_comments) = $row;
						
						// Get hash
						$query = "SELECT hash_id, hash_case_id, hash_mirror_file_id, hash_md5, hash_sha1, hash_created_datetime, hash_created_ddmmyyhhiiss FROM $t_edb_case_index_evidence_items_mirror_files_hash WHERE hash_case_id=$get_mirror_file_case_id AND hash_mirror_file_id=$get_mirror_file_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_hash_id, $get_hash_case_id, $get_hash_mirror_file_id, $get_hash_md5, $get_hash_sha1, $get_hash_created_datetime, $get_hash_created_ddmmyyhhiiss) = $row;
						if($get_hash_id == ""){
							if(file_exists("$get_mirror_file_path_linux/$get_mirror_file_file") && $get_mirror_file_file != ""){
								// Generate hash
								$datetime = date("Y-m-d H:i:s");
								$date_ddmmyyyyhis = date("d.m.Y H:i:s");

								$md5 = md5_file("$get_mirror_file_path_linux/$get_mirror_file_file");
								$md5_mysql = quote_smart($link, $md5);

								$sha1 = sha1_file("$get_mirror_file_path_linux/$get_mirror_file_file");
								$sha1_mysql = quote_smart($link, $sha1);


								mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_items_mirror_files_hash 
								(hash_id, hash_case_id, hash_mirror_file_id, hash_md5, hash_sha1, hash_created_datetime, hash_created_ddmmyyhhiiss) 
								VALUES 
								(NULL, $get_mirror_file_case_id, $get_mirror_file_id, $md5_mysql, $sha1_mysql, '$datetime', '$date_ddmmyyyyhis')")
								or die(mysqli_error($link)); 

								// Parameter transfer
								$get_hash_md5 = "$md5";
								$get_hash_sha1 = "$sha1"; 
								$get_hash_created_ddmmyyhhiiss = "$date_ddmmyyyyhis";
							}
						}

						echo"
						<p><a id=\"mirror_file$get_mirror_file_id\"></a><b>$get_mirror_file_path_linux/$get_mirror_file_file</b></p>
						<table>
						 <tr>
						  <td style=\"padding: 0px 6px 0px 0px;\">
							<span>Ext:</span>
						  </td>
						  <td>
							<span>$get_mirror_file_ext</span>
						  </td>
						 </tr>

						 <tr>
						  <td style=\"padding: 0px 6px 0px 0px;\">
							<span>$l_type:</span>
						  </td>
						  <td>
							<span>$get_mirror_file_type</span>
						  </td>
						 </tr>

						 <tr>
						  <td style=\"padding: 0px 6px 0px 0px;\">
							<span>$l_created:</span>
						  </td>
						  <td>
							<span>$get_mirror_file_created_date_ddmmyy</span>
						  </td>
						 </tr>

						 <tr>
						  <td style=\"padding: 0px 6px 0px 0px;\">
							<span>$l_modified:</span>
						  </td>
						  <td>
							<span>$get_mirror_file_modified_date_ddmmyy</span>
						  </td>
						 </tr>

						 <tr>
						  <td style=\"padding: 0px 6px 0px 0px;\">
							<span>$l_size:</span>
						  </td>
						  <td>
							<span>$get_mirror_file_size_human</span>
						  </td>
						 </tr>

						 <tr>
						  <td style=\"padding: 0px 6px 0px 0px;\">
							<span>$l_exists:</span>
						  </td>
						  <td>
							<span>";if($get_mirror_file_exists == "1"){
										echo"$l_yes";
									}
									elseif($get_mirror_file_exists == "0"){
										echo"$l_no";
									}
									else{
										echo"$l_unknown";
									}
									echo"</span>
						  </td>
						 </tr>

						 <tr>
						  <td style=\"padding: 0px 6px 0px 0px;\">
							<span title=\"$l_ready_for_automated_machine\">$l_ready:</span>
						  </td>
						  <td>
							<span>";
							if($get_mirror_file_ready_for_automated_machine == "1"){
								echo"$l_yes";
							}
							elseif($get_mirror_file_ready_for_automated_machine == "0"){
								echo"$l_no";
							}
							else{
								echo"$l_unknown";
							}
							echo"</span>
						  </td>
						 </tr>

						 <tr>
						  <td style=\"padding: 0px 6px 0px 0px;\">
							<span>$l_backup:</span>
						  </td>
						  <td>
							<span>$get_mirror_file_backup_disk</span>
						  </td>
						 </tr>

						 <tr>
						  <td style=\"padding: 0px 6px 0px 0px;\">
							<span>$l_comments:</span>
						  </td>
						  <td>
							<span>$get_mirror_file_comments</span>
						  </td>
						 </tr>

						 <tr>
						  <td style=\"padding: 0px 6px 0px 0px;\">
							<span>$l_hash_date:</span>
						  </td>
						  <td>
							<span>$get_hash_created_ddmmyyhhiiss</span>
						  </td>
						 </tr>

						 <tr>
						  <td style=\"padding: 0px 6px 0px 0px;\">
							<span>Md5:</span>
						  </td>
						  <td>
							<span>$get_hash_md5</span>
						  </td>
						 </tr>

						 <tr>
						  <td style=\"padding: 0px 6px 0px 0px;\">
							<span>Sha1:</span>
						  </td>
						  <td>
							<span>$get_hash_sha1</span>
						  </td>
						 </tr>
						</table>
						
						";
					} // while mirror files
				echo"
				<!-- //Mirror files -->
					
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