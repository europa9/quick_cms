<?php 
/**
*
* File: edb/api/01_add_password_to_evidence.php
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

$t_edb_backup_disks  	= $mysqlPrefixSav . "edb_backup_disks";

/*- Tables ---------------------------------------------------------------------------- */
$t_edb_most_used_passwords 			= $mysqlPrefixSav . "edb_most_used_passwords";
$t_edb_case_index_usr_psw 			= $mysqlPrefixSav . "edb_case_index_usr_psw";
$t_edb_item_types_available_passwords		= $mysqlPrefixSav . "edb_item_types_available_passwords";
$t_edb_case_index_evidence_items_passwords 	= $mysqlPrefixSav . "edb_case_index_evidence_items_passwords";


/*- Translations ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/en/edb/ts_01_add_password_to_evidence.php");


/*- Test mode -------------------------------------------------------------------------- */
$test_mode 		= "0";
$test_machine_key	= "haugesund_backup";
$test_item_id 		= "7";




/*- Variables -------------------------------------------------------------------------- */
if(isset($_POST['machine_key'])) {
	$machine_key = $_POST['machine_key'];
	$machine_key = strip_tags(stripslashes($machine_key));
}
else{
	if($test_mode == "1"){
		$machine_key = "$test_machine_key";
	}
	else{
		$machine_key = "";
	}
}
$machine_key_mysql = quote_smart($link, $machine_key);

if(isset($_POST['item_id'])) {
	$item_id = $_POST['item_id'];
	$item_id = strip_tags(stripslashes($item_id));
}
else{
	$item_id = "";
	if($test_mode == "1"){
		$item_id = "$test_item_id";
	}
	
}
$item_id_mysql = quote_smart($link, $item_id);

// Dates
$datetime = date("Y-m-d H:i:s");
$time = time();
$date_ddmmyyhi = date("d.m.y H:i");
$date_saying = date("d M Y H:i");
$date_ddmmyyyyhi = date("d.m.Y H:i");
$date_ddmmyyyy = date("d.m.Y");


// IP
$my_user_agent = $_SERVER['HTTP_USER_AGENT'];
$my_user_agent = output_html($my_user_agent);
$my_user_agent_mysql = quote_smart($link, $my_user_agent);

$my_ip = $_SERVER['REMOTE_ADDR'];
$my_ip = output_html($my_ip);
$my_ip_mysql = quote_smart($link, $my_ip);



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
	
	// Update machine last seen
	$result = mysqli_query($link, "UPDATE $t_edb_machines_index SET
					machine_last_seen_datetime='$datetime',
					machine_last_seen_time='$time',
					machine_last_seen_ddmmyyhi='$date_ddmmyyhi',
					machine_last_seen_ddmmyyyyhi='$date_ddmmyyyyhi'
					 WHERE machine_id=$get_current_machine_id") or die(mysqli_error($link));

	// Update last seen
	$datetime = date("Y-m-d H:i:s");
	$time = time();
	$date_saying = date("d M Y H:i");
	$date_ddmmyyhi = date("d.m.y H:i");
	$date_ddmmyyyyhi = date("d.m.Y H:i");
	
	$result = mysqli_query($link, "UPDATE $t_edb_machines_index SET
					machine_last_seen_datetime='$datetime',
					machine_last_seen_time='$time',
					machine_last_seen_ddmmyyhi='$date_ddmmyyhi',
					machine_last_seen_ddmmyyyyhi='$date_ddmmyyyyhi'
					 WHERE machine_id=$get_current_machine_id") or die(mysqli_error($link));

	// My name
	$inp_machine_name_mysql = quote_smart($link, $get_current_machine_name);

	// Find evidence ID
	$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_parent_item_id, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_in_date_ddmmyyyy, item_storage_shelf_id, item_storage_shelf_title, item_storage_location_id, item_storage_location_abbr, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_name, item_timezone, item_date_now_date, item_date_now_saying, item_date_now_ddmmyy, item_date_now_ddmmyyyy, item_time_now, item_correct_date_now_date, item_correct_date_now_saying, item_correct_date_now_ddmmyy, item_correct_date_now_ddmmyyyy, item_correct_time_now, item_adjust_clock_automatically, item_adjust_time_zone_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_date_ddmmyyyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy, item_out_date_ddmmyyyy, item_out_notes FROM $t_edb_case_index_evidence_items WHERE item_id=$item_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_item_id, $get_current_item_case_id, $get_current_item_record_id, $get_current_item_record_seized_year, $get_current_item_record_seized_journal, $get_current_item_record_seized_district_number, $get_current_item_numeric_serial_number, $get_current_item_title, $get_current_item_parent_item_id, $get_current_item_type_id, $get_current_item_type_title, $get_current_item_confirmed_by_human, $get_current_item_human_rejected, $get_current_item_request_text, $get_current_item_requester_user_id, $get_current_item_requester_user_name, $get_current_item_requester_user_alias, $get_current_item_requester_user_email, $get_current_item_requester_user_image_path, $get_current_item_requester_user_image_file, $get_current_item_requester_user_image_thumb_40, $get_current_item_requester_user_image_thumb_50, $get_current_item_requester_user_first_name, $get_current_item_requester_user_middle_name, $get_current_item_requester_user_last_name, $get_current_item_requester_user_job_title, $get_current_item_requester_user_department, $get_current_item_in_datetime, $get_current_item_in_date, $get_current_item_in_time, $get_current_item_in_date_saying, $get_current_item_in_date_ddmmyy, $get_current_item_in_date_ddmmyyyy, $get_current_item_storage_shelf_id, $get_current_item_storage_shelf_title, $get_current_item_storage_location_id, $get_current_item_storage_location_abbr, $get_current_item_comment, $get_current_item_condition, $get_current_item_serial_number, $get_current_item_imei_a, $get_current_item_imei_b, $get_current_item_imei_c, $get_current_item_imei_d, $get_current_item_os_title, $get_current_item_os_version, $get_current_item_name, $get_current_item_timezone, $get_current_item_date_now_date, $get_current_item_date_now_saying, $get_current_item_date_now_ddmmyy, $get_current_item_date_now_ddmmyyyy, $get_current_item_time_now, $get_current_item_correct_date_now_date, $get_current_item_correct_date_now_saying, $get_current_item_correct_date_now_ddmmyy, $get_current_item_correct_date_now_ddmmyyyy, $get_current_item_correct_time_now, $get_current_item_adjust_clock_automatically, $get_current_item_adjust_time_zone_automatically, $get_current_item_acquired_software_id_a, $get_current_item_acquired_software_title_a, $get_current_item_acquired_software_notes_a, $get_current_item_acquired_software_id_b, $get_current_item_acquired_software_title_b, $get_current_item_acquired_software_notes_b, $get_current_item_acquired_software_id_c, $get_current_item_acquired_software_title_c, $get_current_item_acquired_software_notes_c, $get_current_item_acquired_date, $get_current_item_acquired_time, $get_current_item_acquired_date_saying, $get_current_item_acquired_date_ddmmyy, $get_current_item_acquired_date_ddmmyyyy, $get_current_item_acquired_user_id, $get_current_item_acquired_user_name, $get_current_item_acquired_user_alias, $get_current_item_acquired_user_email, $get_current_item_acquired_user_image_path, $get_current_item_acquired_user_image_file, $get_current_item_acquired_user_image_thumb_40, $get_current_item_acquired_user_image_thumb_50, $get_current_item_acquired_user_first_name, $get_current_item_acquired_user_middle_name, $get_current_item_acquired_user_last_name, $get_current_item_out_date, $get_current_item_out_time, $get_current_item_out_date_saying, $get_current_item_out_date_ddmmyy, $get_current_item_out_date_ddmmyyyy, $get_current_item_out_notes) = $row;

	if($get_current_item_id == ""){
		echo"Server error 404: Could not find evidence item";
	}
	else{
		// Find case
		$query = "SELECT case_id, case_number, case_title, case_title_clean, case_suspect_in_custody, case_code_id, case_code_number, case_code_title, case_status_id, case_status_title, case_priority_id, case_priority_title, case_district_id, case_district_title, case_station_id, case_station_title, case_is_screened, case_physical_location, case_backup_disks, case_confirmed_by_human, case_human_rejected, case_last_event_text, case_path_windows, case_path_linux, case_path_folder_name, case_assigned_to_datetime, case_assigned_to_date, case_assigned_to_time, case_assigned_to_date_saying, case_assigned_to_date_ddmmyy, case_assigned_to_date_ddmmyyyy, case_assigned_to_user_id, case_assigned_to_user_name, case_assigned_to_user_alias, case_assigned_to_user_email, case_assigned_to_user_image_path, case_assigned_to_user_image_file, case_assigned_to_user_image_thumb_40, case_assigned_to_user_image_thumb_50, case_assigned_to_user_first_name, case_assigned_to_user_middle_name, case_assigned_to_user_last_name, case_created_datetime, case_created_date, case_created_time, case_created_date_saying, case_created_date_ddmmyy, case_created_date_ddmmyyyy, case_created_user_id, case_created_user_name, case_created_user_alias, case_created_user_email, case_created_user_image_path, case_created_user_image_file, case_created_user_image_thumb_40, case_created_user_image_thumb_50, case_created_user_first_name, case_created_user_middle_name, case_created_user_last_name, case_detective_user_id, case_detective_user_job_title, case_detective_user_department, case_detective_user_first_name, case_detective_user_middle_name, case_detective_user_last_name, case_detective_user_name, case_detective_user_alias, case_detective_user_email, case_detective_email_alerts, case_detective_user_image_path, case_detective_user_image_file, case_detective_user_image_thumb_40, case_detective_user_image_thumb_50, case_updated_datetime, case_updated_date, case_updated_time, case_updated_date_saying, case_updated_date_ddmmyy, case_updated_date_ddmmyyyy, case_updated_user_id, case_updated_user_name, case_updated_user_alias, case_updated_user_email, case_updated_user_image_path, case_updated_user_image_file, case_updated_user_image_thumb_40, case_updated_user_image_thumb_50, case_updated_user_first_name, case_updated_user_middle_name, case_updated_user_last_name, case_is_closed, case_closed_datetime, case_closed_date, case_closed_time, case_closed_date_saying, case_closed_date_ddmmyy, case_closed_date_ddmmyyyy, case_time_from_created_to_close FROM $t_edb_case_index WHERE case_id=$get_current_item_case_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_case_id, $get_current_case_number, $get_current_case_title, $get_current_case_title_clean, $get_current_case_suspect_in_custody, $get_current_case_code_id, $get_current_case_code_number, $get_current_case_code_title, $get_current_case_status_id, $get_current_case_status_title, $get_current_case_priority_id, $get_current_case_priority_title, $get_current_case_district_id, $get_current_case_district_title, $get_current_case_station_id, $get_current_case_station_title, $get_current_case_is_screened, $get_current_case_physical_location, $get_current_case_backup_disks, $get_current_case_confirmed_by_human, $get_current_case_human_rejected, $get_current_case_last_event_text, $get_current_case_path_windows, $get_current_case_path_linux, $get_current_case_path_folder_name, $get_current_case_assigned_to_datetime, $get_current_case_assigned_to_date, $get_current_case_assigned_to_time, $get_current_case_assigned_to_date_saying, $get_current_case_assigned_to_date_ddmmyy, $get_current_case_assigned_to_date_ddmmyyyy, $get_current_case_assigned_to_user_id, $get_current_case_assigned_to_user_name, $get_current_case_assigned_to_user_alias, $get_current_case_assigned_to_user_email, $get_current_case_assigned_to_user_image_path, $get_current_case_assigned_to_user_image_file, $get_current_case_assigned_to_user_image_thumb_40, $get_current_case_assigned_to_user_image_thumb_50, $get_current_case_assigned_to_user_first_name, $get_current_case_assigned_to_user_middle_name, $get_current_case_assigned_to_user_last_name, $get_current_case_created_datetime, $get_current_case_created_date, $get_current_case_created_time, $get_current_case_created_date_saying, $get_current_case_created_date_ddmmyy, $get_current_case_created_date_ddmmyyyy, $get_current_case_created_user_id, $get_current_case_created_user_name, $get_current_case_created_user_alias, $get_current_case_created_user_email, $get_current_case_created_user_image_path, $get_current_case_created_user_image_file, $get_current_case_created_user_image_thumb_40, $get_current_case_created_user_image_thumb_50, $get_current_case_created_user_first_name, $get_current_case_created_user_middle_name, $get_current_case_created_user_last_name, $get_current_case_detective_user_id, $get_current_case_detective_user_job_title, $get_current_case_detective_user_department, $get_current_case_detective_user_first_name, $get_current_case_detective_user_middle_name, $get_current_case_detective_user_last_name, $get_current_case_detective_user_name, $get_current_case_detective_user_alias, $get_current_case_detective_user_email, $get_current_case_detective_email_alerts, $get_current_case_detective_user_image_path, $get_current_case_detective_user_image_file, $get_current_case_detective_user_image_thumb_40, $get_current_case_detective_user_image_thumb_50, $get_current_case_updated_datetime, $get_current_case_updated_date, $get_current_case_updated_time, $get_current_case_updated_date_saying, $get_current_case_updated_date_ddmmyy, $get_current_case_updated_date_ddmmyyyy, $get_current_case_updated_user_id, $get_current_case_updated_user_name, $get_current_case_updated_user_alias, $get_current_case_updated_user_email, $get_current_case_updated_user_image_path, $get_current_case_updated_user_image_file, $get_current_case_updated_user_image_thumb_40, $get_current_case_updated_user_image_thumb_50, $get_current_case_updated_user_first_name, $get_current_case_updated_user_middle_name, $get_current_case_updated_user_last_name, $get_current_case_is_closed, $get_current_case_closed_datetime, $get_current_case_closed_date, $get_current_case_closed_time, $get_current_case_closed_date_saying, $get_current_case_closed_date_ddmmyy, $get_current_case_closed_date_ddmmyyyy, $get_current_case_time_from_created_to_close) = $row;

		if($get_current_item_type_id == ""){
			echo"Error: Item $get_current_item_id has no item type (example PC, Mobile). Please fix here: <a href=\"../../open_case_evidence_edit_evidence_item_item.php?case_id=$get_current_item_case_id&amp;item_id=$get_current_item_id&amp;mode=item\">open_case_evidence_edit_evidence_item_item.php?case_id=$get_current_item_case_id&amp;item_id=$get_current_item_id&amp;mode=item</a>"; die;
		}

		if($test_mode == "1"){
			$data[] = ['available_title' => 'Bruker', 'value' => 'Adam'];
			$data[] = ['available_title' => 'Passord', 'value' => '23rw'];
			$data[] = ['available_title' => 'Domene', 'value' => 'Home'];
			
 			$json_object = json_encode($data);
                        
		}
		else{
			$json = $_POST['json'];
			$json_object = json_decode($json);
		}

		// Set
		$inp_password_set_new = rand(100, 9999);
		$inp_password_set_new_mysql = quote_smart($link, $inp_password_set_new);

		// Loop trough array
		$count_insert = 0;
		$json_array = json_decode($json_object, true);
		foreach($json_array as $item) { 
			$inp_available_title = $item['available_title']; 
			$inp_available_title = output_html($inp_available_title);
			$inp_available_title_mysql = quote_smart($link, $inp_available_title);
 
			$inp_value = $item['value']; 
			$inp_value = output_html($inp_value);
			$inp_value_mysql = quote_smart($link, $inp_value);


			// Find available
			$query_available = "SELECT available_id, available_item_type_id, available_title, available_title_clean, available_type, available_size, available_last_updated_datetime, available_last_updated_user_id FROM $t_edb_item_types_available_passwords WHERE available_item_type_id=$get_current_item_type_id AND available_title=$inp_available_title_mysql";
			$result_available = mysqli_query($link, $query_available);
			$row_available = mysqli_fetch_row($result_available);
			list($get_available_id, $get_available_item_type_id, $get_available_title, $get_available_title_clean, $get_available_type, $get_available_size, $get_available_last_updated_datetime, $get_available_last_updated_user_id) = $row_available;
			if($get_available_id == ""){
				echo"Error: Could not find item_types_available_passwords $inp_available_title"; die;
			}

			// Insert this
			mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_items_passwords
			(password_id, password_case_id, password_item_id, password_available_id, password_available_title, password_item_type_id, password_set_number, password_value, password_created_by_user_id, password_created_by_user_name, password_created_datetime) 
			VALUES 
			(NULL, $get_current_item_case_id, $get_current_item_id, $get_available_id, $inp_available_title_mysql, $get_available_item_type_id, $inp_password_set_new_mysql, $inp_value_mysql, 1, $inp_machine_name_mysql, '$datetime')")
			or die(mysqli_error($link));
			
			// Count insert
			$count_insert = $count_insert+1;
		}
		// Feedback
		echo"Success. Insert $count_insert. ";

		// Send info to case owner
		if($get_current_case_assigned_to_user_id != ""){
			// Insert into user notifications
			$inp_notification_url = "$configSiteURLSav/edb/open_case_evidence_edit_evidence_item_item.php?case_id=$get_current_item_case_id&amp;item_id=$get_current_item_id&amp;mode=item#passwords";
			$inp_notification_url_mysql = quote_smart($link, $inp_notification_url);

			$inp_notification_text = "$l_username_and_password_found_for_case $get_current_case_number: $get_current_item_record_seized_year/$get_current_item_record_seized_journal-$get_current_item_record_seized_district_number-$get_current_item_numeric_serial_number $get_current_item_title";
			$inp_notification_text_mysql = quote_smart($link, $inp_notification_text);
			$week = date("W");
			mysqli_query($link, "INSERT INTO $t_users_notifications
			(notification_id, notification_user_id, notification_seen, notification_url, notification_text, notification_datetime, notification_emailed, notification_week) 
			VALUES 
			(NULL, $get_current_case_assigned_to_user_id, 0, $inp_notification_url_mysql, $inp_notification_text_mysql, '$datetime', '0', '$week')")
			or die(mysqli_error($link));

			// Feedback
			echo"Msg to $get_current_case_assigned_to_user_id.";
		}

		
		
	} // evidence found
} // machine found

?>