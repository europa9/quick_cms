<?php 
/**
*
* File: edb/api/05_send_case_evidence_item_zip.php
* Version 1.0
* Date 12:50 26.11.2019
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
$t_edb_liquidbase				= $mysqlPrefixSav . "edb_liquidbase";

$t_edb_home_page_user_remember			= $mysqlPrefixSav . "edb_home_page_user_remember";

$t_edb_case_index					= $mysqlPrefixSav . "edb_case_index";
$t_edb_case_index_events				= $mysqlPrefixSav . "edb_case_index_events";
$t_edb_case_index_evidence_records			= $mysqlPrefixSav . "edb_case_index_evidence_records";
$t_edb_case_index_evidence_items			= $mysqlPrefixSav . "edb_case_index_evidence_items";
$t_edb_case_index_evidence_items_sim_cards		= $mysqlPrefixSav . "edb_case_index_evidence_items_sim_cards";
$t_edb_case_index_evidence_items_sd_cards		= $mysqlPrefixSav . "edb_case_index_evidence_items_sd_cards";
$t_edb_case_index_evidence_items_networks		= $mysqlPrefixSav . "edb_case_index_evidence_items_networks";
$t_edb_case_index_evidence_items_hard_disks		= $mysqlPrefixSav . "edb_case_index_evidence_items_hard_disks";
$t_edb_case_index_evidence_items_volumes		= $mysqlPrefixSav . "edb_case_index_evidence_items_volumes";
$t_edb_case_index_evidence_items_mirror_files		= $mysqlPrefixSav . "edb_case_index_evidence_items_mirror_files";
$t_edb_case_index_evidence_items_mirror_files_hash	= $mysqlPrefixSav . "edb_case_index_evidence_items_mirror_files_hash";

$t_edb_case_index_statuses				= $mysqlPrefixSav . "edb_case_index_statuses";
$t_edb_case_index_human_tasks				= $mysqlPrefixSav . "edb_case_index_human_tasks";
$t_edb_case_index_human_tasks_responsible_counters	= $mysqlPrefixSav . "edb_case_index_human_tasks_responsible_counters";
$t_edb_case_index_automated_tasks			= $mysqlPrefixSav . "edb_case_index_automated_tasks";
$t_edb_case_index_notes					= $mysqlPrefixSav . "edb_case_index_notes";
$t_edb_case_index_open_case_menu_counters		= $mysqlPrefixSav . "edb_case_index_open_case_menu_counters";
$t_edb_case_index_glossaries				= $mysqlPrefixSav . "edb_case_index_glossaries";
$t_edb_case_index_photos				= $mysqlPrefixSav . "edb_case_index_photos";

$t_edb_case_index_usr_psw				= $mysqlPrefixSav . "edb_case_index_usr_psw";

$t_edb_case_index_item_info_level_a	= $mysqlPrefixSav . "edb_case_index_item_info_level_a";
$t_edb_case_index_item_info_level_b	= $mysqlPrefixSav . "edb_case_index_item_info_level_b";
$t_edb_case_index_item_info_level_c	= $mysqlPrefixSav . "edb_case_index_item_info_level_c";
$t_edb_case_index_item_info_level_d	= $mysqlPrefixSav . "edb_case_index_item_info_level_d";

$t_edb_case_codes					= $mysqlPrefixSav . "edb_case_codes";
$t_edb_case_codes_priority_counters			= $mysqlPrefixSav . "edb_case_codes_priority_counters";
$t_edb_case_statuses					= $mysqlPrefixSav . "edb_case_statuses";
$t_edb_case_statuses_district_case_counter		= $mysqlPrefixSav . "edb_case_statuses_district_case_counter";
$t_edb_case_statuses_station_case_counter		= $mysqlPrefixSav . "edb_case_statuses_station_case_counter";
$t_edb_case_statuses_user_case_counter			= $mysqlPrefixSav . "edb_case_statuses_user_case_counter";
$t_edb_case_priorities					= $mysqlPrefixSav . "edb_case_priorities";
$t_edb_case_reports					= $mysqlPrefixSav . "edb_case_reports";


$t_edb_districts_index			= $mysqlPrefixSav . "edb_districts_index";
$t_edb_districts_members		= $mysqlPrefixSav . "edb_districts_members";
$t_edb_districts_membership_requests	= $mysqlPrefixSav . "edb_districts_membership_requests";
$t_edb_districts_jour 			= $mysqlPrefixSav . "edb_districts_jour";

$t_edb_stations_index			= $mysqlPrefixSav . "edb_stations_index";
$t_edb_stations_members			= $mysqlPrefixSav . "edb_stations_members";
$t_edb_stations_membership_requests	= $mysqlPrefixSav . "edb_stations_membership_requests";
$t_edb_stations_directories		= $mysqlPrefixSav . "edb_stations_directories";
$t_edb_stations_jour			= $mysqlPrefixSav . "edb_stations_jour";
$t_edb_stations_user_view_method	= $mysqlPrefixSav . "edb_stations_user_view_method";

$t_edb_item_types		= $mysqlPrefixSav . "edb_item_types";

$t_edb_glossaries		= $mysqlPrefixSav . "edb_glossaries";

$t_edb_software_index	= $mysqlPrefixSav . "edb_software_index";

$t_edb_machines_index				= $mysqlPrefixSav . "edb_machines_index";
$t_edb_machines_index_types			= $mysqlPrefixSav . "edb_machines_index_types";
$t_edb_machines_types				= $mysqlPrefixSav . "edb_machines_types";
$t_edb_machines_all_tasks_available		= $mysqlPrefixSav . "edb_machines_all_tasks_available";
$t_edb_machines_all_tasks_available_to_item  	= $mysqlPrefixSav . "edb_machines_all_tasks_available_to_item";

$t_edb_agent_log 			= $mysqlPrefixSav . "edb_agent_log";
$t_edb_agent_user_active_inactive 	= $mysqlPrefixSav . "edb_agent_user_active_inactive";
$t_edb_agents_index		 	= $mysqlPrefixSav . "edb_agents_index";


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

$t_edb_case_index_evidence_items_zips 	= $mysqlPrefixSav . "edb_case_index_evidence_items_zips";
$t_edb_backup_disks			= $mysqlPrefixSav . "edb_backup_disks";

/*- Functions -------------------------------------------------------------------------- */
function format_size_units($bytes) {
	if ($bytes >= 1073741824)  {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)  {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)  {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        }
        else {
            $bytes = '0 bytes';
        }

        return $bytes;
}

/*- Test ------------------------------------------------------------------------------- */
$test_mode 		= "1";
$test_machine_key 	= "sindre";
$test_item_id 		= "4";
$test_file_name 	= "x.zip";
$test_file_path_windows	= "c:/";
$test_file_path_linux	= "/home/test";
$test_size_bytes	= "5000000000";


/*- Variables -------------------------------------------------------------------------- */
if(isset($_POST['machine_key'])) {
	$machine_key = $_POST['machine_key'];
	$machine_key = strip_tags(stripslashes($machine_key));
}
else{
	$machine_key = "";
	if($test_mode == "1"){
		$machine_key = "$test_machine_key";
	}
	else{
		echo"Missing machine key";
		die;
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
	else{
		echo"Missing item id";
		die;
	}
}
$item_id_mysql = quote_smart($link, $item_id);


if(isset($_POST['file_name'])) {
	$file_name = $_POST['file_name'];
	$file_name = strip_tags(stripslashes($file_name));
}
else{
	$file_name = "";
	if($test_mode == "1"){
		$file_name = "$test_file_name";
	}
	else{
		echo"Missing file_name";
		die;
	}
}
$file_name_mysql = quote_smart($link, $file_name);




if(isset($_POST['file_path_windows'])) {
	$file_path_windows = $_POST['file_path_windows'];
	$file_path_windows = strip_tags(stripslashes($file_path_windows));
}
else{
	$file_path_windows = "";
	if($test_mode == "1"){
		$file_path_windows = "$test_file_path_windows";
	}
	else{
		echo"Missing file_path_windows";
		die;
	}
}
$file_path_windows_mysql = quote_smart($link, $file_path_windows);



if(isset($_POST['file_path_linux'])) {
	$file_path_linux = $_POST['file_path_linux'];
	$file_path_linux = strip_tags(stripslashes($file_path_linux));
}
else{
	$file_path_linux = "";
	if($test_mode == "1"){
		$file_path_linux = "$test_file_path_linux";
	}
	else{
		echo"Missing file_path_linux";
		die;
	}
}
$file_path_linux_mysql = quote_smart($link, $file_path_linux);


if(isset($_POST['size_bytes'])) {
	$size_bytes = $_POST['size_bytes'];
	$size_bytes = strip_tags(stripslashes($size_bytes));
}
else{
	$size_bytes = "";
	if($test_mode == "1"){
		$size_bytes = "$test_size_bytes";
	}
	else{
		echo"Missing size_bytes";
		die;
	}
}
$size_bytes_mysql = quote_smart($link, $size_bytes);


// Look for machine
$query = "SELECT machine_id, machine_name, machine_os, machine_ip, machine_mac, machine_key, machine_description, machine_station_id, machine_station_title, machine_last_seen_datetime, machine_last_seen_time, machine_last_seen_ddmmyyhi, machine_last_seen_ddmmyyyyhi, machine_is_working_with_automated_task_id, machine_started_working_datetime, machine_started_working_time, machine_started_working_ddmmyyhi, machine_started_working_ddmmyyyyhi FROM $t_edb_machines_index WHERE machine_key=$machine_key_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_machine_id, $get_current_machine_name, $get_current_machine_os, $get_current_machine_ip, $get_current_machine_mac, $get_current_machine_key, $get_current_machine_description, $get_current_machine_station_id, $get_current_machine_station_title, $get_current_machine_last_seen_datetime, $get_current_machine_last_seen_time, $get_current_machine_last_seen_ddmmyyhi, $get_current_machine_last_seen_ddmmyyyyhi, $get_current_machine_is_working_with_automated_task_id, $get_current_machine_started_working_datetime, $get_current_machine_started_working_time, $get_current_machine_started_working_ddmmyyhi, $get_current_machine_started_working_ddmmyyyyhi) = $row;

if($get_current_machine_id == ""){
	echo"Server error 404: Machine not found";
	die;
}
else{
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

	// Find item
	$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_timezone, item_date_now_date, item_date_now_ddmmyy, item_time_now, item_correct_date_now_date, item_correct_date_now_ddmmyy, item_correct_time_now, item_adjust_clock_automatically, item_adjust_time_zone_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy FROM $t_edb_case_index_evidence_items WHERE item_id=$item_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_item_id, $get_current_item_case_id, $get_current_item_record_id, $get_current_item_record_seized_year, $get_current_item_record_seized_journal, $get_current_item_record_seized_district_number, $get_current_item_numeric_serial_number, $get_current_item_title, $get_current_item_type_id, $get_current_item_type_title, $get_current_item_confirmed_by_human, $get_current_item_human_rejected, $get_current_item_request_text, $get_current_item_requester_user_id, $get_current_item_requester_user_name, $get_current_item_requester_user_alias, $get_current_item_requester_user_email, $get_current_item_requester_user_image_path, $get_current_item_requester_user_image_file, $get_current_item_requester_user_image_thumb_40, $get_current_item_requester_user_image_thumb_50, $get_current_item_requester_user_first_name, $get_current_item_requester_user_middle_name, $get_current_item_requester_user_last_name, $get_current_item_requester_user_job_title, $get_current_item_requester_user_department, $get_current_item_in_datetime, $get_current_item_in_date, $get_current_item_in_time, $get_current_item_in_date_saying, $get_current_item_in_date_ddmmyy, $get_current_item_comment, $get_current_item_condition, $get_current_item_serial_number, $get_current_item_imei_a, $get_current_item_imei_b, $get_current_item_imei_c, $get_current_item_imei_d, $get_current_item_os_title, $get_current_item_os_version, $get_current_item_timezone, $get_current_item_date_now_date, $get_current_item_date_now_ddmmyy, $get_current_item_time_now, $get_current_item_correct_date_now_date, $get_current_item_correct_date_now_ddmmyy, $get_current_item_correct_time_now, $get_current_item_adjust_clock_automatically, $get_current_item_adjust_time_zone_automatically, $get_current_item_acquired_software_id_a, $get_current_item_acquired_software_title_a, $get_current_item_acquired_software_notes_a, $get_current_item_acquired_software_id_b, $get_current_item_acquired_software_title_b, $get_current_item_acquired_software_notes_b, $get_current_item_acquired_software_id_c, $get_current_item_acquired_software_title_c, $get_current_item_acquired_software_notes_c, $get_current_item_acquired_date, $get_current_item_acquired_time, $get_current_item_acquired_date_saying, $get_current_item_acquired_date_ddmmyy, $get_current_item_acquired_user_id, $get_current_item_acquired_user_name, $get_current_item_acquired_user_alias, $get_current_item_acquired_user_email, $get_current_item_acquired_user_image_path, $get_current_item_acquired_user_image_file, $get_current_item_acquired_user_image_thumb_40, $get_current_item_acquired_user_image_thumb_50, $get_current_item_acquired_user_first_name, $get_current_item_acquired_user_middle_name, $get_current_item_acquired_user_last_name, $get_current_item_out_date, $get_current_item_out_time, $get_current_item_out_date_saying, $get_current_item_out_date_ddmmyy) = $row;
	
	if($get_current_item_id == ""){
		echo"Item not found";
		die;
	}
	else{
		// Date
		$datetime = date("Y-m-d H:i:s");

		// Me
		$inp_machine_name_mysql = quote_smart($link, $get_current_machine_name);

		$inp_my_ip = $_SERVER['REMOTE_ADDR'];
		$inp_my_ip = output_html($inp_my_ip);
		$inp_my_ip_mysql = quote_smart($link, $inp_my_ip);

		// Size
		$inp_size_human = format_size_units($size_bytes);
		$inp_size_human = output_html($inp_size_human);
		$inp_size_human_mysql = quote_smart($link, $inp_size_human);

		// Check if zip file exists
		$query = "SELECT zip_id, zip_case_id, zip_item_id, zip_file_name, zip_file_path_windows, zip_file_path_linux, zip_size_bytes, zip_size_human, zip_backup_disk_id, zip_backup_disk_name, zip_created_datetime, zip_created_user_id, zip_created_by_user_name, zip_created_by_ip, zip_updated_datetime, zip_updated_user_id, zip_updated_user_name, zip_updated_ip FROM $t_edb_case_index_evidence_items_zips WHERE zip_case_id=$get_current_item_case_id AND zip_item_id=$get_current_item_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_zip_id, $get_current_zip_case_id, $get_current_zip_item_id, $get_current_zip_file_name, $get_current_zip_file_path_windows, $get_current_zip_file_path_linux, $get_current_zip_size_bytes, $get_current_zip_size_human, $get_current_zip_backup_disk_id, $get_current_zip_backup_disk_name, $get_current_zip_created_datetime, $get_current_zip_created_user_id, $get_current_zip_created_by_user_name, $get_current_zip_created_by_ip, $get_current_zip_updated_datetime, $get_current_zip_updated_user_id, $get_current_zip_updated_user_name, $get_current_zip_updated_ip) = $row;
	

		// If exists then update, if not then create
		if($get_current_zip_id == ""){
			mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_items_zips 
			(zip_id, zip_case_id, zip_item_id, zip_file_name, zip_file_path_windows, 
			zip_file_path_linux, zip_size_bytes, zip_size_human, zip_created_datetime, zip_created_user_id, 
			zip_created_by_user_name, zip_created_by_ip) 
			VALUES 
			(NULL, $get_current_case_id, $get_current_item_id, $file_name_mysql, $file_path_windows_mysql, 
			$file_path_linux_mysql, $inp_size_human_mysql, $size_bytes_mysql, '$datetime', NULL, 
			$inp_machine_name_mysql,  $inp_my_ip_mysql)")
			or die(mysqli_error($link));
	
			echo"Created zip";
		}
		else{
			$result = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items_zips SET 
							zip_file_name=$file_name_mysql,  
							zip_file_path_windows=$file_path_windows_mysql,  
							zip_file_path_linux=$file_path_linux_mysql, 
							zip_size_bytes=$size_bytes_mysql, 
							zip_size_human=$inp_size_human_mysql, 
							zip_updated_datetime='$datetime', 
							zip_updated_user_id=NULL, 
							zip_updated_user_name=$inp_machine_name_mysql,  
							zip_updated_ip=$inp_my_ip_mysql
							WHERE zip_id=$get_current_zip_id") or die(mysqli_error($link));

			echo"Updated zip ID $get_current_zip_id";
		}

	} // item found
} // machine found

?>