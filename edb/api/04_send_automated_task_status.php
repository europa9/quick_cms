<?php 
/**
*
* File: edb/api/04_send_automated_task_status.php
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


/*- Functions -------------------------------------------------------------------------- */
function seconds_to_time($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
}

/*- Test ------------------------------------------------------------------------------- */
$test_mode = "0";
$test_machine_key = "sindre";
$test_item_id = "11";


/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['machine_key'])) {
	$machine_key = $_GET['machine_key'];
	$machine_key = strip_tags(stripslashes($machine_key));
}
else{
	$machine_key = "";
	if($test_mode == "1"){
		$machine_key = "$test_machine_key";
	}
}
$machine_key_mysql = quote_smart($link, $machine_key);


if(isset($_GET['automated_task_id'])) {
	$automated_task_id = $_GET['automated_task_id'];
	$automated_task_id = strip_tags(stripslashes($automated_task_id));
}
else{
	$automated_task_id = "";
}
$automated_task_id_mysql = quote_smart($link, $automated_task_id);



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


	// Fetch the automated task that the machine is currently working on, and end it
	$query = "SELECT automated_task_id, automated_task_case_id, automated_task_evidence_record_id, automated_task_evidence_item_id, automated_task_evidence_full_title, automated_task_task_available_id, automated_task_task_available_name, automated_task_task_machine_type_id, automated_task_task_machine_type_title, automated_task_station_id, automated_task_station_title, automated_task_mirror_file_id, automated_task_mirror_file_path_windows, automated_task_mirror_file_path_linux, automated_task_mirror_file_file, automated_task_added_by_user_id, automated_task_added_by_user_email, automated_task_added_datetime, automated_task_added_date, automated_task_added_time, automated_task_added_date_saying, automated_task_added_date_ddmmyy, automated_task_added_date_ddmmyyyy, automated_task_started_datetime, automated_task_started_date, automated_task_started_time, automated_task_started_date_saying, automated_task_started_date_ddmmyyhi, automated_task_started_date_ddmmyyyyhi, automated_task_machine_id, automated_task_machine_name, automated_task_last_status_msg, automated_task_last_status_ddmmyyyyhi, automated_task_is_finished, automated_task_finished_datetime, automated_task_finished_date, automated_task_finished_time, automated_task_finished_date_saying, automated_task_finished_date_ddmmyyhi, automated_task_finished_date_ddmmyyyyhi, automated_task_time_taken_time, automated_task_time_taken_human FROM $t_edb_case_index_automated_tasks ";
	$query = $query . "WHERE automated_task_id=$automated_task_id_mysql AND automated_task_machine_id=$get_current_machine_id";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_automated_task_id, $get_automated_task_case_id, $get_automated_task_evidence_record_id, $get_automated_task_evidence_item_id, $get_automated_task_evidence_full_title, $get_automated_task_task_available_id, $get_automated_task_task_available_name, $get_automated_task_task_machine_type_id, $get_automated_task_task_machine_type_title, $get_automated_task_station_id, $get_automated_task_station_title, $get_automated_task_mirror_file_id, $get_automated_task_mirror_file_path_windows, $get_automated_task_mirror_file_path_linux, $get_automated_task_mirror_file_file, $get_automated_task_added_by_user_id, $get_automated_task_added_by_user_email, $get_automated_task_added_datetime, $get_automated_task_added_date, $get_automated_task_added_time, $get_automated_task_added_date_saying, $get_automated_task_added_date_ddmmyy, $get_automated_task_added_date_ddmmyyyy, $get_automated_task_started_datetime, $get_automated_task_started_date, $get_automated_task_started_time, $get_automated_task_started_date_saying, $get_automated_task_started_date_ddmmyyhi, $get_automated_task_started_date_ddmmyyyyhi, $get_automated_task_machine_id, $get_automated_task_machine_name, $get_automated_task_last_status_msg, $get_automated_task_last_status_ddmmyyyyhi, $get_automated_task_is_finished, $get_automated_task_finished_datetime, $get_automated_task_finished_date, $get_automated_task_finished_time, $get_automated_task_finished_date_saying, $get_automated_task_finished_date_ddmmyyhi, $get_automated_task_finished_date_ddmmyyyyhi, $get_automated_task_time_taken_time, $get_automated_task_time_taken_human) = $row;

	if($get_automated_task_id == ""){
		echo"No tasks";
	}
	else{
		$status_msg = $_GET['status_msg'];
		$status_msg = output_html($status_msg);
		$status_msg = str_replace("_", " ", $status_msg);
		$status_msg_mysql = quote_smart($link, $status_msg);

		$result = mysqli_query($link, "UPDATE $t_edb_case_index_automated_tasks SET
					automated_task_last_status_msg=$status_msg_mysql, 
					automated_task_last_status_datetime='$datetime',
					automated_task_last_status_saying='$date_saying',
					automated_task_last_status_ddmmyyhi='$date_ddmmyyhi',
					automated_task_last_status_ddmmyyyyhi='$date_ddmmyyyyhi'
					 WHERE automated_task_id=$get_automated_task_id") or die(mysqli_error($link));

		// Update log file
		$log_file = "../../_cache/edb_automated_task_$get_automated_task_id.log";
		
		$input = "$datetime $status_msg\r\n
";
		$fh = fopen($log_file, "a+") or die("can not open file");
		fwrite($fh, $input);
		fclose($fh); 

		// Feedback
		echo"<!DOCTYPE html>
<html lang=\"en\">
<head>
	<title>Status updated</title>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
	<meta name=\"viewport\" content=\"width=device-width; initial-scale=1.0;\"/>
</head>
<body>
<h1>Status updated</h1>

<p>
Date: $date_ddmmyyyyhi<br />
New status: $status_msg
</p>

</body>
</html>";

	} // automated task found
} // machine found

?>