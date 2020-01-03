<?php 
/**
*
* File: edb/api/01_look_for_task.php
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

/*- Functions ------------------------------------------------------------------------- */

function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
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
$t_edb_case_codes				= $mysqlPrefixSav . "edb_case_codes";
$t_edb_case_statuses				= $mysqlPrefixSav . "edb_case_statuses";
$t_edb_case_statuses_district_case_counter	= $mysqlPrefixSav . "edb_case_statuses_district_case_counter";
$t_edb_case_statuses_station_case_counter	= $mysqlPrefixSav . "edb_case_statuses_station_case_counter";
$t_edb_case_statuses_user_case_counter		= $mysqlPrefixSav . "edb_case_statuses_user_case_counter";
$t_edb_case_priorities				= $mysqlPrefixSav . "edb_case_priorities";


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
$t_edb_machines_index_types			= $mysqlPrefixSav . "edb_machines_index_types";
$t_edb_machines_types				= $mysqlPrefixSav . "edb_machines_types";
$t_edb_machines_all_tasks_available		= $mysqlPrefixSav . "edb_machines_all_tasks_available";
$t_edb_machines_all_tasks_available_to_item  	= $mysqlPrefixSav . "edb_machines_all_tasks_available_to_item";


/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['machine_key'])) {
	$machine_key = $_GET['machine_key'];
	$machine_key = strip_tags(stripslashes($machine_key));
}
else{
	$machine_key = "";
}
$machine_key_mysql = quote_smart($link, $machine_key);


// Dates
$datetime = date("Y-m-d H:i:s");
$time = time();
$date_ddmmyyhi = date("d.m.y H:i");
$date_saying = date("d M Y H:i");
$date_ddmmyyyyhi = date("d.m.Y H:i");


// Look for machine
$query = "SELECT machine_id, machine_name, machine_os, machine_ip, machine_mac, machine_key, machine_description, machine_station_id, machine_station_title, machine_last_seen_datetime, machine_last_seen_time, machine_last_seen_ddmmyyhi, machine_last_seen_ddmmyyyyhi, machine_is_working_with_automated_task_id, machine_started_working_datetime, machine_started_working_time, machine_started_working_ddmmyyhi, machine_started_working_ddmmyyyyhi FROM $t_edb_machines_index WHERE machine_key=$machine_key_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_machine_id, $get_current_machine_name, $get_current_machine_os, $get_current_machine_ip, $get_current_machine_mac, $get_current_machine_key, $get_current_machine_description, $get_current_machine_station_id, $get_current_machine_station_title, $get_current_machine_last_seen_datetime, $get_current_machine_last_seen_time, $get_current_machine_last_seen_ddmmyyhi, $get_current_machine_last_seen_ddmmyyyyhi, $get_current_machine_is_working_with_automated_task_id, $get_current_machine_started_working_datetime, $get_current_machine_started_working_time, $get_current_machine_started_working_ddmmyyhi, $get_current_machine_started_working_ddmmyyyyhi) = $row;

if($get_current_machine_id == ""){
	echo"<h1>$date_saying 01_look_for_task.php Server error 404</h1><p>Machine $machine_key not found</p>";
	die;
}
else{
	
	// Update last seen
	
	$result = mysqli_query($link, "UPDATE $t_edb_machines_index SET
					machine_last_seen_datetime='$datetime',
					machine_last_seen_time='$time',
					machine_last_seen_ddmmyyhi='$date_ddmmyyhi',
					machine_last_seen_ddmmyyyyhi='$date_ddmmyyyyhi'
					 WHERE machine_id=$get_current_machine_id") or die(mysqli_error($link));


	if($get_current_machine_is_working_with_automated_task_id == "0" OR $get_current_machine_is_working_with_automated_task_id == ""){


		// Look for tasks for this machine
		
		// We first need to make a list of all types of tasks the machine can handle
		$get_current_machine_type_ids = "";
		$query_it = "SELECT machine_index_type_id, machine_index_type_type_id, machine_index_type_type_title FROM $t_edb_machines_index_types WHERE machine_index_type_machine_id=$get_current_machine_id";
		$result_it = mysqli_query($link, $query_it);
		while($row_it = mysqli_fetch_row($result_it)) {
		list($get_machine_index_type_id, $get_machine_index_type_type_id, $get_machine_index_type_type_title) = $row_it;
			if($get_current_machine_type_ids == ""){
				$get_current_machine_type_ids = "$get_machine_index_type_type_id";
			}
			else{
				$get_current_machine_type_ids = "$get_current_machine_type_ids," . "$get_machine_index_type_type_id";
			}
		}
		if($get_current_machine_type_ids == ""){
			echo"Your machine cant do any tasks because it has no types sat";
			die;
		}

		// The machine type is $get_current_machine_type_id, $get_current_machine_type_title
		// so tasks have to match the machine type
		// also machine station id ($get_current_machine_station_id)
		$count_amount_of_tasks = 0;
		$mirror_files_found_and_ready = ""; 
		$query_tasks = "SELECT automated_task_id, automated_task_case_id, automated_task_evidence_record_id, automated_task_evidence_item_id, automated_task_evidence_full_title, automated_task_task_available_id, automated_task_task_available_name, automated_task_task_machine_type_id, automated_task_task_machine_type_title, automated_task_mirror_file_id, automated_task_mirror_file_path_windows, automated_task_mirror_file_path_linux, automated_task_mirror_file_file, automated_task_glossaries_ids, automated_task_priority, automated_task_dependent_on_automated_task_id, automated_task_dependent_on_automated_task_title, automated_task_added_datetime, automated_task_added_date, automated_task_added_time, automated_task_added_date_saying, automated_task_added_date_ddmmyy, automated_task_added_date_ddmmyyyy, automated_task_started_datetime, automated_task_started_date, automated_task_started_time, automated_task_started_date_saying, automated_task_started_date_ddmmyyhi, automated_task_started_date_ddmmyyyyhi, automated_task_machine_id, automated_task_machine_name, automated_task_is_finished, automated_task_finished_datetime, automated_task_finished_date, automated_task_finished_time, automated_task_finished_date_saying, automated_task_finished_date_ddmmyyhi, automated_task_finished_date_ddmmyyyyhi, automated_task_time_taken_time, automated_task_time_taken_human FROM $t_edb_case_index_automated_tasks";
		$query_tasks = $query_tasks . " WHERE automated_task_task_machine_type_id IN ($get_current_machine_type_ids) AND automated_task_station_id=$get_current_machine_station_id AND automated_task_machine_id='0'";
		$result_tasks = mysqli_query($link, $query_tasks);
		while($row_tasks = mysqli_fetch_row($result_tasks)) {
			list($get_automated_task_id, $get_automated_task_case_id, $get_automated_task_evidence_record_id, $get_automated_task_evidence_item_id, $get_automated_task_evidence_full_title, $get_automated_task_task_available_id, $get_automated_task_task_available_name, $get_automated_task_task_machine_type_id, $get_automated_task_task_machine_type_title, $get_automated_task_mirror_file_id, $get_automated_task_mirror_file_path_windows, $get_automated_task_mirror_file_path_linux, $get_automated_task_mirror_file_file, $get_automated_task_glossaries_ids, $get_automated_task_priority, $get_automated_task_dependent_on_automated_task_id, $get_automated_task_dependent_on_automated_task_title, $get_automated_task_added_datetime, $get_automated_task_added_date, $get_automated_task_added_time, $get_automated_task_added_date_saying, $get_automated_task_added_date_ddmmyy, $get_automated_task_added_date_ddmmyyyy, $get_automated_task_started_datetime, $get_automated_task_started_date, $get_automated_task_started_time, $get_automated_task_started_date_saying, $get_automated_task_started_date_ddmmyyhi, $get_automated_task_started_date_ddmmyyyyhi, $get_automated_task_machine_id, $get_automated_task_machine_name, $get_automated_task_is_finished, $get_automated_task_finished_datetime, $get_automated_task_finished_date, $get_automated_task_finished_time, $get_automated_task_finished_date_saying, $get_automated_task_finished_date_ddmmyyhi, $get_automated_task_finished_date_ddmmyyyyhi, $get_automated_task_time_taken_time, $get_automated_task_time_taken_human) = $row_tasks;


			// Am I avaible?? Example if I have taken a task already, then I am not avaible for new tasks
			$query = "SELECT machine_id, machine_is_working_with_automated_task_id FROM $t_edb_machines_index WHERE machine_id=$get_current_machine_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_check_machine_id, $get_check_machine_is_working_with_automated_task_id) = $row;
			if($get_check_machine_is_working_with_automated_task_id == "0" OR $get_check_machine_is_working_with_automated_task_id == ""){

				// Is this task dependend on another task? If yes, then check if the other task is completed before we start on this one.
				$can_start_on_the_automated_task = "1";
				if($get_automated_task_dependent_on_automated_task_id != "0"){
					// Check task
					$query = "SELECT automated_task_id, automated_task_is_finished FROM $t_edb_case_index_automated_tasks WHERE automated_task_id=$get_automated_task_dependent_on_automated_task_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_check_automated_task_id, $get_check_automated_task_is_finished) = $row;

					if($get_check_automated_task_id == ""){
						// The depended is not avaible
					}
					else{
						if($get_check_automated_task_is_finished == "1"){
							// We are ready
						}
						else{
							// We have to wait
							$can_start_on_the_automated_task = "0";
						}
					}
				}
					
				// We also need to check if there are other mirror files in the same evidence.
				// All mirror files have to be ready for machine, because mirror files can be parts. Example: 001, 002, 003
				if($can_start_on_the_automated_task == "1"){
				
					$query = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_confirmed_by_human, mirror_file_human_rejected, mirror_file_created_datetime, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_modified_datetime, mirror_file_modified_time, mirror_file_modified_date_saying, mirror_file_modified_date_ddmmyy, mirror_file_size_bytes, mirror_file_size_mb, mirror_file_size_human, mirror_file_backup_disk, mirror_file_exists, mirror_file_exists_agent_tries_counter, mirror_file_ready_for_automated_machine, mirror_file_ready_agent_tries_counter, mirror_file_comments FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_case_id=$get_automated_task_case_id AND mirror_file_item_id=$get_automated_task_evidence_item_id AND mirror_file_ready_for_automated_machine=0";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($check_mirror_file_id, $check_mirror_file_case_id, $check_mirror_file_record_id, $check_mirror_file_item_id, $check_mirror_file_path_windows, $check_mirror_file_path_linux, $check_mirror_file_file, $check_mirror_file_ext, $check_mirror_file_type, $check_mirror_file_confirmed_by_human, $check_mirror_file_human_rejected, $check_mirror_file_created_datetime, $check_mirror_file_created_time, $check_mirror_file_created_date_saying, $check_mirror_file_created_date_ddmmyy, $check_mirror_file_modified_datetime, $check_mirror_file_modified_time, $check_mirror_file_modified_date_saying, $check_mirror_file_modified_date_ddmmyy, $check_mirror_file_size_bytes, $check_mirror_file_size_mb, $check_mirror_file_size_human, $check_mirror_file_backup_disk, $check_mirror_file_exists, $check_mirror_file_exists_agent_tries_counter, $check_mirror_file_ready_for_automated_machine, $check_mirror_file_ready_agent_tries_counter, $check_mirror_file_comments) = $row;
					if($check_mirror_file_id != ""){
						// We have to wait
						$can_start_on_the_automated_task = "0";
						echo"Mirror files not ready (Case no: $check_mirror_file_case_id - Item ID: $check_mirror_file_item_id - File Path: $check_mirror_file_path_linux - File: $check_mirror_file_file - Exists: $check_mirror_file_exists - Modified datetime: $check_mirror_file_modified_datetime)";
					}
				}

				if($can_start_on_the_automated_task == "1"){

					// Station storage path
					$query = "SELECT directory_id, directory_type, directory_address_linux, directory_address_windows, directory_address_prefered_for_agent FROM $t_edb_stations_directories WHERE directory_station_id=$get_current_machine_station_id AND directory_type='case_files'";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_current_case_directory_id, $get_current_directory_type, $get_current_case_directory_address_linux, $get_current_case_directory_address_windows, $get_current_case_directory_address_prefered_for_agent) = $row;

			
					$query = "SELECT directory_id, directory_type, directory_address_linux, directory_address_windows, directory_address_prefered_for_agent FROM $t_edb_stations_directories WHERE directory_station_id=$get_current_machine_station_id AND directory_type='mirror_files'";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_current_mirror_case_directory_id, $get_current_mirror_directory_type, $get_current_mirror_directory_address_linux, $get_current_mirror_directory_address_windows, $get_current_mirror_directory_address_prefered_for_agent) = $row;

					if($get_current_case_directory_id == ""){
						echo"Stations storage path not found";
					}
					else{
						// Fetch the case number
						$query = "SELECT case_id, case_number, case_title FROM $t_edb_case_index WHERE case_id=$get_automated_task_case_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_current_case_id, $get_current_case_number, $get_current_case_title) = $row;
		


						// Fetch the evidence item
						$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_in_date_ddmmyyyy, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_timezone, item_date_now_date, item_date_now_saying, item_date_now_ddmmyy, item_date_now_ddmmyyyy, item_time_now, item_correct_date_now_date, item_correct_date_now_saying, item_correct_date_now_ddmmyy, item_correct_date_now_ddmmyyyy, item_correct_time_now, item_adjust_clock_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_date_ddmmyyyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy, item_out_date_ddmmyyyy FROM $t_edb_case_index_evidence_items WHERE item_id=$get_automated_task_evidence_item_id AND item_case_id=$get_automated_task_case_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_current_item_id, $get_current_item_case_id, $get_current_item_record_id, $get_current_item_record_seized_year, $get_current_item_record_seized_journal, $get_current_item_record_seized_district_number, $get_current_item_numeric_serial_number, $get_current_item_title, $get_current_item_type_id, $get_current_item_type_title, $get_current_item_confirmed_by_human, $get_current_item_human_rejected, $get_current_item_request_text, $get_current_item_requester_user_id, $get_current_item_requester_user_name, $get_current_item_requester_user_alias, $get_current_item_requester_user_email, $get_current_item_requester_user_image_path, $get_current_item_requester_user_image_file, $get_current_item_requester_user_image_thumb_40, $get_current_item_requester_user_image_thumb_50, $get_current_item_requester_user_first_name, $get_current_item_requester_user_middle_name, $get_current_item_requester_user_last_name, $get_current_item_requester_user_job_title, $get_current_item_requester_user_department, $get_current_item_in_datetime, $get_current_item_in_date, $get_current_item_in_time, $get_current_item_in_date_saying, $get_current_item_in_date_ddmmyy, $get_current_item_in_date_ddmmyyyy, $get_current_item_comment, $get_current_item_condition, $get_current_item_serial_number, $get_current_item_imei_a, $get_current_item_imei_b, $get_current_item_imei_c, $get_current_item_imei_d, $get_current_item_os_title, $get_current_item_os_version, $get_current_item_timezone, $get_current_item_date_now_date, $get_current_item_date_now_saying, $get_current_item_date_now_ddmmyy, $get_current_item_date_now_ddmmyyyy, $get_current_item_time_now, $get_current_item_correct_date_now_date, $get_current_item_correct_date_now_saying, $get_current_item_correct_date_now_ddmmyy, $get_current_item_correct_date_now_ddmmyyyy, $get_current_item_correct_time_now, $get_current_item_adjust_clock_automatically, $get_current_item_acquired_software_id_a, $get_current_item_acquired_software_title_a, $get_current_item_acquired_software_notes_a, $get_current_item_acquired_software_id_b, $get_current_item_acquired_software_title_b, $get_current_item_acquired_software_notes_b, $get_current_item_acquired_software_id_c, $get_current_item_acquired_software_title_c, $get_current_item_acquired_software_notes_c, $get_current_item_acquired_date, $get_current_item_acquired_time, $get_current_item_acquired_date_saying, $get_current_item_acquired_date_ddmmyy, $get_current_item_acquired_date_ddmmyyyy, $get_current_item_acquired_user_id, $get_current_item_acquired_user_name, $get_current_item_acquired_user_alias, $get_current_item_acquired_user_email, $get_current_item_acquired_user_image_path, $get_current_item_acquired_user_image_file, $get_current_item_acquired_user_image_thumb_40, $get_current_item_acquired_user_image_thumb_50, $get_current_item_acquired_user_first_name, $get_current_item_acquired_user_middle_name, $get_current_item_acquired_user_last_name, $get_current_item_out_date, $get_current_item_out_time, $get_current_item_out_date_saying, $get_current_item_out_date_ddmmyy, $get_current_item_out_date_ddmmyyyy) = $row;
		

						if($get_current_item_id == ""){
							// Delete automated task
							$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_automated_tasks WHERE automated_task_id=$get_automated_task_id");

							echo"Item not found. automated_task_id=$get_automated_task_id";
							die;
						}

						// Item title clean
						if($get_current_item_title == ""){
							$item_year_journal_district_numeric_title_clean = $get_current_item_record_seized_year . "_" . $get_current_item_record_seized_journal . "_" . $get_current_item_record_seized_district_number . "_" . $get_current_item_numeric_serial_number;
						}
						else{
							$item_year_journal_district_numeric_title_clean = $get_current_item_record_seized_year . "_" . $get_current_item_record_seized_journal . "_" . $get_current_item_record_seized_district_number . "_" . $get_current_item_numeric_serial_number . "_" . $get_current_item_title;
						}
						$item_year_journal_district_numeric_title_clean = clean($item_year_journal_district_numeric_title_clean);

						


						// We just want to take this task IF the mirror files are ready.
						// (what can happen is that police is mirroring a computer, and then we dont want to start before the mirroring is finished)
						$mirror_files_found_and_ready = 0; // guess
						$mirror_files_counter = 0;
						$query = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_created_datetime, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_modified_datetime, mirror_file_modified_time, mirror_file_modified_date_saying, mirror_file_modified_date_ddmmyy, mirror_file_size_mb, mirror_file_size_human, mirror_file_backup_disk, mirror_file_exists, mirror_file_ready_for_automated_machine, mirror_file_comments FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_case_id=$get_automated_task_case_id AND mirror_file_item_id=$get_current_item_id AND mirror_file_exists=1";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_mirror_file_id, $get_mirror_file_case_id, $get_mirror_file_record_id, $get_mirror_file_item_id, $get_mirror_file_path_windows, $get_mirror_file_path_linux, $get_mirror_file_file, $get_mirror_file_ext, $get_mirror_file_type, $get_mirror_file_created_datetime, $get_mirror_file_created_time, $get_mirror_file_created_date_saying, $get_mirror_file_created_date_ddmmyy, $get_mirror_file_modified_datetime, $get_mirror_file_modified_time, $get_mirror_file_modified_date_saying, $get_mirror_file_modified_date_ddmmyy, $get_mirror_file_size_mb, $get_mirror_file_size_human, $get_mirror_file_backup_disk, $get_mirror_file_exists, $get_mirror_file_ready_for_automated_machine, $get_mirror_file_comments) = $row;

							if($get_mirror_file_ready_for_automated_machine == "1"){
								$mirror_files_found_and_ready = 1;
							}
							else{
								$mirror_files_found_and_ready = 0;
							}
							$mirror_files_counter++;
						}

						if($mirror_files_found_and_ready == "0"){
							// If the mirror file is not ready the API will give the next mirror file.
							// If no mirror files are ready a error will be printet at the bottom of the script.
						}
						elseif($mirror_files_found_and_ready == "1"){
							// Set the machine active on this task
							$result = mysqli_query($link, "UPDATE $t_edb_machines_index SET
								machine_is_working_with_automated_task_id=$get_automated_task_id, 
								machine_started_working_datetime='$datetime',
								machine_started_working_time='$time',
								machine_started_working_ddmmyyhi='$date_ddmmyyhi',
								machine_started_working_ddmmyyyyhi='$date_ddmmyyyyhi'
								 WHERE machine_id=$get_current_machine_id") or die(mysqli_error($link));


							// Update automatic task
							$inp_machine_name_mysql = quote_smart($link, $get_current_machine_name);

							$result = mysqli_query($link, "UPDATE $t_edb_case_index_automated_tasks SET
									automated_task_started_datetime='$datetime',
									automated_task_started_time='$time',
									automated_task_started_date_saying='$date_saying',
									automated_task_started_date_ddmmyyhi='$date_ddmmyyhi',
									automated_task_started_date_ddmmyyyyhi='$date_ddmmyyyyhi',
									automated_task_machine_id=$get_current_machine_id,
									automated_task_machine_name=$inp_machine_name_mysql 
								 WHERE automated_task_id=$get_automated_task_id") or die(mysqli_error($link));


							// Get the script file name (exe name)
							$query = "SELECT task_available_id, task_available_script_path, task_available_script_file, task_available_script_version, task_available_code FROM $t_edb_machines_all_tasks_available WHERE task_available_id=$get_automated_task_task_available_id";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_current_task_available_id, $get_current_task_available_script_path, $get_current_task_available_script_file, $get_current_task_available_script_version, $get_current_task_available_code) = $row;
		

							// File paths
							$get_automated_task_mirror_file_path_short_linux = str_replace("$get_current_mirror_directory_address_linux/", "", $get_automated_task_mirror_file_path_linux);
							$get_automated_task_mirror_file_path_short_windows = str_replace("$get_current_mirror_directory_address_windows\\", "", $get_automated_task_mirror_file_path_windows);


							// Build array
							$task_array = array();
							$task_array['automated_task_id'] = "$get_automated_task_id";
							$task_array['task_id'] = "$get_automated_task_id";
							$task_array['case_id'] = "$get_automated_task_case_id";
							$task_array['case_numberx'] = "$get_current_case_number";
							$task_array['case_title'] = "$get_current_case_title";
							$task_array['case_number'] = "$get_automated_task_case_id";
							$task_array['evidence_record_id'] = "$get_automated_task_evidence_record_id";
							$task_array['evidence_item_id'] = "$get_automated_task_evidence_item_id";
							$task_array['item_record_seized_year'] = "$get_current_item_record_seized_year";
							$task_array['item_record_seized_journal'] = "$get_current_item_record_seized_journal";
							$task_array['item_record_seized_district_number'] = "$get_current_item_record_seized_district_number";
							$task_array['item_numeric_serial_number'] = "$get_current_item_numeric_serial_number";
							$task_array['item_type_id'] = "$get_current_item_type_id";
							$task_array['item_type_title'] = "$get_current_item_type_title";
							$task_array['item_year_journal_district_numeric_title'] = "$item_year_journal_district_numeric_title_clean";
		

							$task_array['automated_task_task_available_id'] = "$get_automated_task_task_available_id";
							$task_array['automated_task_task_available_name'] = "$get_automated_task_task_available_name";
							$task_array['automated_task_mirror_file_id'] = "$get_automated_task_mirror_file_id";
							$task_array['automated_task_mirror_file_path_linux'] = "$get_automated_task_mirror_file_path_linux";
							$task_array['automated_task_mirror_file_path_windows'] = "$get_automated_task_mirror_file_path_windows";
							$task_array['automated_task_mirror_file_path_short_linux'] = "$get_automated_task_mirror_file_path_short_linux";
							$task_array['automated_task_mirror_file_path_short_windows'] = "$get_automated_task_mirror_file_path_short_windows";
							$task_array['automated_task_mirror_file_file'] = "$get_automated_task_mirror_file_file";
							$task_array['automated_task_glossaries_ids'] = "$get_automated_task_glossaries_ids";
							$task_array['case_files_directory_address_linux'] = "$get_current_case_directory_address_linux";
							$task_array['case_files_directory_address_windows'] = "$get_current_case_directory_address_windows";

							$task_array['task_available_id'] = "$get_current_task_available_id";
							$task_array['task_available_script_path'] = "$get_current_task_available_script_path";
							$task_array['task_available_script_file'] = "$get_current_task_available_script_file";
							$task_array['task_available_script_version'] = "$get_current_task_available_script_version";
							// $get_current_task_available_code

							// Json everything
							$rows_json = json_encode(utf8ize($task_array));
	
							echo"$rows_json";

							// We only want one task.
							exit;
						} // $mirror_files_found_and_ready
					} // station case directory found
				} // if($can_start_on_the_automated_task == "1"){
				$count_amount_of_tasks++;
			} // machine is avaible for tasks (max 1 task per machine per call)
		} // while automated tasks

		// No tasks, or mirror file not ready
		if($mirror_files_found_and_ready == "0"){
			echo"Mirror files not ready (Case no: $get_mirror_file_case_id - Item: $item_year_journal_district_numeric_title_clean - File Path: $get_automated_task_mirror_file_path - File: $get_mirror_file_file - Exists: $get_mirror_file_exists - Modified datetime: $get_mirror_file_modified_datetime)";
		}
		else{
			if($count_amount_of_tasks == "0"){
				echo"No tasks";
			}
		}


	} // machine already busy with task (before seeing tasks)
	else{
		echo"Your already busy with task (ID=$get_current_machine_is_working_with_automated_task_id), that you started working on $get_current_machine_started_working_ddmmyyyyhi";
	}
} // machine found

?>