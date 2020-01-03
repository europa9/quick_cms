<?php 
/**
*
* File: edb/api/03_send_case_evidence_edit_evidence_item_information.php
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

$t_edb_case_index_item_info_groups	= $mysqlPrefixSav . "edb_case_index_item_info_groups";
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
$test_machine_key = "haugesund_backup";
$test_item_id = "7";
$test_group_title = "Maskin";


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


// Look for machine
$query = "SELECT machine_id, machine_name, machine_os, machine_ip, machine_mac, machine_key, machine_description, machine_station_id, machine_station_title, machine_last_seen_datetime, machine_last_seen_time, machine_last_seen_ddmmyyhi, machine_last_seen_ddmmyyyyhi, machine_is_working_with_automated_task_id, machine_started_working_datetime, machine_started_working_time, machine_started_working_ddmmyyhi, machine_started_working_ddmmyyyyhi FROM $t_edb_machines_index WHERE machine_key=$machine_key_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_machine_id, $get_current_machine_name, $get_current_machine_os, $get_current_machine_ip, $get_current_machine_mac, $get_current_machine_key, $get_current_machine_description, $get_current_machine_station_id, $get_current_machine_station_title, $get_current_machine_last_seen_datetime, $get_current_machine_last_seen_time, $get_current_machine_last_seen_ddmmyyhi, $get_current_machine_last_seen_ddmmyyyyhi, $get_current_machine_is_working_with_automated_task_id, $get_current_machine_started_working_datetime, $get_current_machine_started_working_time, $get_current_machine_started_working_ddmmyyhi, $get_current_machine_started_working_ddmmyyyyhi) = $row;

if($get_current_machine_id == ""){
	echo"Server error 404: Machine not found ($machine_key)";
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

	// My name
	$inp_machine_name_mysql = quote_smart($link, $get_current_machine_name);

	// Find evidence ID
	$query = "SELECT item_id, item_case_id FROM $t_edb_case_index_evidence_items WHERE item_id=$item_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_item_id, $get_current_item_case_id) = $row;

	if($get_current_item_id == ""){
		echo"Server error 404: Could not find evidence item";
	}
	else{
		$count_new_level_a = 0;
		$count_new_level_b = 0;
		$count_new_level_c = 0;
		$count_new_level_d = 0;

		if($test_mode == "1"){



			$data[] = [
                        	'level_a_title' => 'Disk 1', 'level_a_flag' => '0', 'level_a_show_on_analysis_report' => '1', 'level_a_type' => 'text', 'level_a_value' => [
                        		['level_b_title' => 'Partition 1', 'level_b_flag' => '0', 'level_b_show_on_analysis_report' => '1', 'level_b_type' => 'text', 'level_b_value' => [
                        				['level_c_title' => 'Name', 'level_c_flag' => '0', 'level_c_show_on_analysis_report' => '1', 'level_c_type' => 'text', 'level_c_value' => 'Windows'],
                        				['level_c_title' => 'Volume Serial Number', 'level_c_flag' => '0', 'level_c_show_on_analysis_report' => '1', 'level_c_type' => 'text', 'level_c_value' => '2423113434'],
                        				['level_c_title' => 'Users', 'level_c_flag' => '0', 'level_c_show_on_analysis_report' => '1', 'level_c_type' => 'text', 'level_c_value' => [
                        					['level_d_title' => 'Name', 'level_d_flag' => '0', 'level_d_show_on_analysis_report' => '1', 'level_d_type' => 'text', 'level_d_value' => 'Sam'],
                        					['level_d_title' => 'Last login', 'level_d_flag' => '0', 'level_d_show_on_analysis_report' => '1', 'level_d_type' => 'text', 'level_d_value' => 'Nov 27 2019 10:42:00'],
                        					['level_d_title' => 'Password', 'level_d_flag' => '0', 'level_d_show_on_analysis_report' => '1', 'level_d_type' => 'text', 'level_d_value' => '3fxfg2'],
								]
							]
						]
					]
				],
				'level_a_flag' => '0',
				'level_a_show_on_analysis_report' => '1'
                    	];

			$data[] = [
                        	'level_a_title' => 'Time data', 'level_a_flag' => '0', 'level_a_show_on_analysis_report' => '1', 'level_a_type' => 'text', 'level_a_value' => [
                        		['level_b_title' => 'Time zone', 'level_b_flag' => '0', 'level_b_show_on_analysis_report' => '1', 'level_b_type' => 'text', 'level_b_value' => 'Oslo'],
                        		['level_b_title' => 'Time now', 'level_b_flag' => '0', 'level_b_show_on_analysis_report' => '1', 'level_b_type' => 'text', 'level_b_value' => 'Nov 28 2019 19:22:00'],
				],
				
				
                    	];
 			$json_object = json_encode($data);
			// echo"$json_object";
			// die;

			//$json = '[{"level_a_title":"Disk 1","level_a_flag":"0","level_a_show_on_analysis_report":"1","level_a_type":"text","level_a_value":[{"level_b_title":"Partition 1","level_b_flag":"0","level_b_show_on_analysis_report":"1","level_b_type":"text","level_b_value":[{"level_c_title":"Name","level_c_flag":"0","level_c_show_on_analysis_report":"1","level_c_type":"text","level_c_value":"Windows"},{"level_c_title":"Volume Serial Number","level_c_flag":"0","level_c_show_on_analysis_report":"1","level_c_type":"text","level_c_value":"2423113434"},{"level_c_title":"Users","level_c_flag":"0","level_c_show_on_analysis_report":"1","level_c_type":"text","level_c_value":[{"level_d_title":"Name","level_d_flag":"0","level_d_show_on_analysis_report":"1","level_d_type":"text","level_d_value":"Sam"},{"level_d_title":"Last login","level_d_flag":"0","level_d_show_on_analysis_report":"1","level_d_type":"text","level_d_value":"Nov 27 2019 10:42:00"},{"level_d_title":"Password","level_d_flag":"0","level_d_show_on_analysis_report":"1","level_d_type":"text","level_d_value":"3fxfg2"}]}]}]},{"level_a_title":"Time data","level_a_flag":"0","level_a_show_on_analysis_report":"1","level_a_type":"text","level_a_value":[{"level_b_title":"Time zone","level_b_flag":"0","level_b_show_on_analysis_report":"1","level_b_type":"text","level_b_value":"Oslo"},{"level_b_title":"Time now","level_b_flag":"0","level_b_show_on_analysis_report":"1","level_b_type":"text","level_b_value":"Nov 28 2019 19:22:00"}]}]';
			
			$json ='[{"level_a_flag": "0", "level_a_show_on_analysis_report": "1", "level_a_title": "Disk 1", "level_a_value": [{"level_b_value": [{"level_c_value": "FAT32", "level_c_show_on_analysis_report": "1", "level_c_title": "File System Type", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": "0xa438d956", "level_c_show_on_analysis_report": "1", "level_c_title": "Volume ID", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": "MSDOS5.0", "level_c_show_on_analysis_report": "1", "level_c_title": "OEM Name", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": "Unknown", "level_c_show_on_analysis_report": "1", "level_c_title": "Partition Type", "level_c_flag": "0", "level_c_type": "text"}], "level_b_type": "text", "level_b_flag": "0", "level_b_show_on_analysis_report": "1", "level_b_title": "Partition 0"}, {"level_b_value": [{"level_c_value": "Unknown File System", "level_c_show_on_analysis_report": "1", "level_c_title": "File System Type", "level_c_flag": "1", "level_c_type": "text"}], "level_b_type": "text", "level_b_flag": "0", "level_b_show_on_analysis_report": "1", "level_b_title": "Partition 1"}, {"level_b_value": [{"level_c_value": "NTFS", "level_c_show_on_analysis_report": "1", "level_c_title": "File System Type", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": "0840FF7640FF68B8", "level_c_show_on_analysis_report": "1", "level_c_title": "Volume Serial Number", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": "NTFS    ", "level_c_show_on_analysis_report": "1", "level_c_title": "OEM Name", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": "Windows", "level_c_show_on_analysis_report": "1", "level_c_title": "Volume Name", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": "Windows XP", "level_c_show_on_analysis_report": "1", "level_c_title": "Version", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": "Windows", "level_c_show_on_analysis_report": "1", "level_c_title": "Partition Type", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": "Windows 10 Home", "level_c_show_on_analysis_report": "1", "level_c_title": "OS Version", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": "Wed Aug 21 20:01:39 2019", "level_c_show_on_analysis_report": "1", "level_c_title": "OS Install Date", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": [{"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Last Write Time", "level_d_value": "Wed Oct 30 09:22:55 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Active Time Bias", "level_d_value": "-60", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Time Zone Key Name", "level_d_value": "W. Europe Standard Time", "level_d_flag": "0"}], "level_c_show_on_analysis_report": "1", "level_c_title": "Time Zone Info", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": [{"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Username", "level_d_value": "Administrator", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Sid", "level_d_value": "S-1-5-21-3053591196-345683929-4106601824-500", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Full Name", "level_d_value": "", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "account Created", "level_d_value": "Wed Aug 21 20:01:34 2019 Z", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Last Login Date", "level_d_value": "Never", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Pwd Reset Date", "level_d_value": "Never", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Login Counts", "level_d_value": "0", "level_d_flag": "0"}], "level_c_show_on_analysis_report": "1", "level_c_title": "User0", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": [{"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Username", "level_d_value": "Gjest", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Sid", "level_d_value": "S-1-5-21-3053591196-345683929-4106601824-501", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Full Name", "level_d_value": "", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "account Created", "level_d_value": "Wed Aug 21 20:01:34 2019 Z", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Last Login Date", "level_d_value": "Never", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Pwd Reset Date", "level_d_value": "Never", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Login Counts", "level_d_value": "0", "level_d_flag": "0"}], "level_c_show_on_analysis_report": "1", "level_c_title": "User1", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": [{"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Username", "level_d_value": "Standardkonto", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Sid", "level_d_value": "S-1-5-21-3053591196-345683929-4106601824-503", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Full Name", "level_d_value": "", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "account Created", "level_d_value": "Wed Aug 21 20:01:34 2019 Z", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Last Login Date", "level_d_value": "Never", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Pwd Reset Date", "level_d_value": "Never", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Login Counts", "level_d_value": "0", "level_d_flag": "0"}], "level_c_show_on_analysis_report": "1", "level_c_title": "User2", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": [{"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Username", "level_d_value": "WDAGUtilityAccount", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Sid", "level_d_value": "S-1-5-21-3053591196-345683929-4106601824-504", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Full Name", "level_d_value": "", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "account Created", "level_d_value": "Wed Aug 21 20:01:34 2019 Z", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Last Login Date", "level_d_value": "Never", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Pwd Reset Date", "level_d_value": "Wed Aug 21 19:53:27 2019 Z", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Login Counts", "level_d_value": "0", "level_d_flag": "0"}], "level_c_show_on_analysis_report": "1", "level_c_title": "User3", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": [{"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Username", "level_d_value": "Victor", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Sid", "level_d_value": "S-1-5-21-3053591196-345683929-4106601824-1001", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Full Name", "level_d_value": "", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "account Created", "level_d_value": "Wed Oct 23 07:12:25 2019 Z", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Last Login Date", "level_d_value": "Sun Nov 10 02:58:41 2019 Z", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Pwd Reset Date", "level_d_value": "Wed Aug 21 18:45:49 2019 Z", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Login Counts", "level_d_value": "110", "level_d_flag": "0"}], "level_c_show_on_analysis_report": "1", "level_c_title": "User4", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": [{"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Google Chrome v.78.0.3904.87", "level_d_value": "Wed Nov  6 20:54:34 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Google Update Helper v.1.3.35.341", "level_d_value": "Wed Nov  6 20:53:40 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "NoteBook FanControl v.1.6.3.0", "level_d_value": "Mon Oct 21 19:04:51 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "NoteBook FanControl v.1.6.3.0", "level_d_value": "Mon Oct 21 19:04:47 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Teams Machine-Wide Installer v.1.2.0.22654", "level_d_value": "Thu Sep 12 08:28:05 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "HP Audio Switch v.1.0.154.0", "level_d_value": "Wed Aug 21 20:00:27 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "HP Connection Optimizer v.2.0.15.0", "level_d_value": "Wed Aug 21 20:00:27 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "AddressBook", "level_d_value": "Wed Aug 21 19:53:42 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Connection Manager", "level_d_value": "Wed Aug 21 19:53:42 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DirectDrawEx", "level_d_value": "Wed Aug 21 19:53:42 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DXM_Runtime", "level_d_value": "Wed Aug 21 19:53:42 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Fontcore", "level_d_value": "Wed Aug 21 19:53:42 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "IE40", "level_d_value": "Wed Aug 21 19:53:42 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "IE4Data", "level_d_value": "Wed Aug 21 19:53:42 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "IE5BAKEX", "level_d_value": "Wed Aug 21 19:53:42 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "IEData", "level_d_value": "Wed Aug 21 19:53:42 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "MobileOptionPack", "level_d_value": "Wed Aug 21 19:53:42 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "MPlayer2", "level_d_value": "Wed Aug 21 19:53:42 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "SchedulingAgent", "level_d_value": "Wed Aug 21 19:53:42 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "WIC", "level_d_value": "Wed Aug 21 19:53:42 2019 (UTC)", "level_d_flag": "0"}], "level_c_show_on_analysis_report": "1", "level_c_title": "Installed Programs 32-bit", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": [{"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Microsoft Office 365 - da-dk v.16.0.11328.20438", "level_d_value": "Wed Oct 23 07:28:15 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Microsoft Office 365 - en-us v.16.0.11328.20438", "level_d_value": "Wed Oct 23 07:28:15 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Microsoft Office 365 - fi-fi v.16.0.11328.20438", "level_d_value": "Wed Oct 23 07:28:15 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Microsoft Office 365 - nb-no v.16.0.11328.20438", "level_d_value": "Wed Oct 23 07:28:15 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Microsoft Office 365 - sv-se v.16.0.11328.20438", "level_d_value": "Wed Oct 23 07:28:15 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Microsoft Office 365 ProPlus - nb-no v.16.0.11328.20438", "level_d_value": "Wed Oct 23 07:28:15 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "VLC media player v.3.0.8", "level_d_value": "Fri Oct 11 09:47:08 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Office 16 Click-to-Run Extensibility Component v.16.0.11929.20300", "level_d_value": "Thu Sep 12 08:28:01 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Office 16 Click-to-Run Licensing Component v.16.0.11929.20300", "level_d_value": "Thu Sep 12 08:26:50 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Office 16 Click-to-Run Localization Component v.16.0.11929.20300", "level_d_value": "Thu Sep 12 08:26:49 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Office 16 Click-to-Run Localization Component v.16.0.11929.20300", "level_d_value": "Thu Sep 12 08:26:47 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Office 16 Click-to-Run Localization Component v.16.0.11929.20300", "level_d_value": "Thu Sep 12 08:26:45 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Office 16 Click-to-Run Localization Component v.16.0.11929.20300", "level_d_value": "Thu Sep 12 08:26:44 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Office 16 Click-to-Run Localization Component v.16.0.11929.20300", "level_d_value": "Thu Sep 12 08:26:43 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "{E5FB98E0-0784-44F0-8CEC-95CD4690C43F} v.255.255.65535.0", "level_d_value": "Thu Aug 29 09:10:05 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "HP Documentation v.1.0.0.1", "level_d_value": "Wed Aug 21 20:00:19 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "AddressBook", "level_d_value": "Wed Aug 21 19:53:35 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Connection Manager", "level_d_value": "Wed Aug 21 19:53:35 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DirectDrawEx", "level_d_value": "Wed Aug 21 19:53:35 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DXM_Runtime", "level_d_value": "Wed Aug 21 19:53:35 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Fontcore", "level_d_value": "Wed Aug 21 19:53:35 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "IE40", "level_d_value": "Wed Aug 21 19:53:35 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "IE4Data", "level_d_value": "Wed Aug 21 19:53:35 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "IE5BAKEX", "level_d_value": "Wed Aug 21 19:53:35 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "IEData", "level_d_value": "Wed Aug 21 19:53:35 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "MobileOptionPack", "level_d_value": "Wed Aug 21 19:53:35 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "MPlayer2", "level_d_value": "Wed Aug 21 19:53:35 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "SchedulingAgent", "level_d_value": "Wed Aug 21 19:53:35 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "WIC", "level_d_value": "Wed Aug 21 19:53:35 2019 (UTC)", "level_d_flag": "0"}], "level_c_show_on_analysis_report": "1", "level_c_title": "Installed Programs 64-bit", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": [], "level_c_show_on_analysis_report": "1", "level_c_title": "Installed Programs Encryption", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": [], "level_c_show_on_analysis_report": "1", "level_c_title": "Installed Programs Hacking", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": [{"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "VLC media player v.3.0.8", "level_d_value": "Fri Oct 11 09:47:08 2019 (UTC)", "level_d_flag": "0"}], "level_c_show_on_analysis_report": "1", "level_c_title": "Installed Programs Antivirus", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": [], "level_c_show_on_analysis_report": "1", "level_c_title": "Installed Programs Sync", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": [{"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "S/N", "level_d_value": "0123456789ABCDEF&0", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Device Parameters LastWrite", "level_d_value": "Wed Oct 16 09:17:02 2019", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Properties LastWrite", "level_d_value": "Wed Oct 16 09:17:04 2019", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Friendly Name", "level_d_value": "KINGSTON  SHSS37A240G USB Device", "level_d_flag": "0"}], "level_c_show_on_analysis_report": "1", "level_c_title": "USB Device 0", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": [{"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "S/N", "level_d_value": "120300000000015C&0", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Device Parameters LastWrite", "level_d_value": "Wed Oct 16 08:48:39 2019", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Properties LastWrite", "level_d_value": "Wed Oct 16 08:48:41 2019", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Friendly Name", "level_d_value": "Verbatim STORE N GO USB Device", "level_d_flag": "0"}], "level_c_show_on_analysis_report": "1", "level_c_title": "USB Device 1", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": [{"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "S/N", "level_d_value": "14120496013001&0", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Device Parameters LastWrite", "level_d_value": "Wed Oct 23 09:23:04 2019", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Properties LastWrite", "level_d_value": "Wed Oct 23 09:23:05 2019", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Friendly Name", "level_d_value": "Verbatim STORE N GO USB Device", "level_d_flag": "0"}], "level_c_show_on_analysis_report": "1", "level_c_title": "USB Device 2", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": [{"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Last Write Time", "level_d_value": "Wed Aug 21 19:53:40 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Disable Notifications", "level_d_value": "0", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Enable Firewall", "level_d_value": "1", "level_d_flag": "0"}], "level_c_show_on_analysis_report": "1", "level_c_title": "Firewall DomainProfile", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": [{"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Last Write Time", "level_d_value": "Wed Aug 21 19:53:40 2019 (UTC)", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Disable Notifications", "level_d_value": "0", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Enable Firewall", "level_d_value": "1", "level_d_flag": "0"}], "level_c_show_on_analysis_report": "1", "level_c_title": "Firewall StandardProfile", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": [{"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Adapter Id", "level_d_value": "ab6e2608-9511-4cb5-92b7-1c5676863e58", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Adapter Name", "level_d_value": "Wi-Fi", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "LeaseTerminatesTime", "level_d_value": "Mon Nov 11 03:01:45 2019 Z", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DhcpInterfaceOptions", "level_d_value": "TEST", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "TEST2", "level_d_value": "", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Lease", "level_d_value": "86400", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "TEST3", "level_d_value": "", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DhcpServer", "level_d_value": "192.168.10.1", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Domain", "level_d_value": "", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DhcpDomain", "level_d_value": "home", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DhcpIPAddress", "level_d_value": "192.168.10.142", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DhcpDefaultGateway", "level_d_value": "192.168.10.1", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "T2", "level_d_value": "Mon Nov 11 00:01:45 2019 Z", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DhcpSubnetMask", "level_d_value": "255.255.255.0", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "NameServer", "level_d_value": "", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "AddressType", "level_d_value": "0", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DhcpNetworkHint", "level_d_value": "Altibox384018_5G", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "TEST3", "level_d_value": "", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "LeaseObtainedTime", "level_d_value": "Sun Nov 10 03:01:45 2019 Z", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DhcpNameServer", "level_d_value": "109.247.114.4 92.220.228.70", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "T1", "level_d_value": "Sun Nov 10 15:01:45 2019 Z", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DhcpSubnetMaskOpt", "level_d_value": "255.255.255.0", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "EnableDHCP", "level_d_value": "1", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "TEST5", "level_d_value": "", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DhcpConnForceBroadcastFlag", "level_d_value": "0", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "IsServerNapAware", "level_d_value": "0", "level_d_flag": "0"}], "level_c_show_on_analysis_report": "1", "level_c_title": "NIC 5", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": [{"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Adapter Id", "level_d_value": "ab6e2608-9511-4cb5-92b7-1c5676863e58", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Adapter Name", "level_d_value": "Wi-Fi", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "LeaseTerminatesTime", "level_d_value": "Thu Oct 31 12:37:19 2019 Z", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "TEST7", "level_d_value": "", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DhcpInterfaceOptions", "level_d_value": "TEST4", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Lease", "level_d_value": "86400", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DhcpServer", "level_d_value": "10.65.0.1", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "Domain", "level_d_value": "", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DhcpConnForceBroadcastFlag", "level_d_value": "0", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DhcpIPAddress", "level_d_value": "10.65.1.215", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DhcpDefaultGateway", "level_d_value": "10.65.0.1", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "T2", "level_d_value": "Thu Oct 31 09:37:19 2019 Z", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DhcpSubnetMask", "level_d_value": "255.255.240.0", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "NameServer", "level_d_value": "", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "AddressType", "level_d_value": "0", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "SSID", "level_d_value": "Decoded: Sveio-gjest", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DhcpNetworkHint", "level_d_value": "Sveio-gjest", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "LeaseObtainedTime", "level_d_value": "Wed Oct 30 12:37:19 2019 Z", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DhcpNameServer", "level_d_value": "8.8.8.8 8.8.4.4", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "T1", "level_d_value": "Thu Oct 31 00:37:19 2019 Z", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "DhcpSubnetMaskOpt", "level_d_value": "255.255.240.0", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "EnableDHCP", "level_d_value": "1", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "TEST6", "level_d_value": "", "level_d_flag": "0"}, {"level_d_show_on_analysis_report": "1", "level_d_type": "text", "level_d_title": "IsServerNapAware", "level_d_value": "0", "level_d_flag": "0"}], "level_c_show_on_analysis_report": "1", "level_c_title": "NIC 6", "level_c_flag": "0", "level_c_type": "text"}], "level_b_type": "text", "level_b_flag": "0", "level_b_show_on_analysis_report": "1", "level_b_title": "Partition 2"}, {"level_b_value": [{"level_c_value": "NTFS", "level_c_show_on_analysis_report": "1", "level_c_title": "File System Type", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": "A0349C12349BEA14", "level_c_show_on_analysis_report": "1", "level_c_title": "Volume Serial Number", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": "NTFS    ", "level_c_show_on_analysis_report": "1", "level_c_title": "OEM Name", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": "Windows RE tools", "level_c_show_on_analysis_report": "1", "level_c_title": "Volume Name", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": "Windows XP", "level_c_show_on_analysis_report": "1", "level_c_title": "Version", "level_c_flag": "0", "level_c_type": "text"}, {"level_c_value": "Recovery", "level_c_show_on_analysis_report": "1", "level_c_title": "Partition Type", "level_c_flag": "0", "level_c_type": "text"}], "level_b_type": "text", "level_b_flag": "0", "level_b_show_on_analysis_report": "1", "level_b_title": "Partition 3"}], "level_a_type": "headline"}]';

		}
		else{
			$json = $_POST['json'];
		}

		if(isset($_POST['json_replace_single_quotes'])){
			$json_replace_single_quotes = $_POST['json_replace_single_quotes'];
			$json_replace_single_quotes = output_html($json_replace_single_quotes);
			if($json_replace_single_quotes == "1"){
				$json = str_replace("'", '"', $json);
			}
		}
		

		if(isset($_POST['json_replace_backslash_single_quote'])){
			$json_replace_backslash_single_quote = $_POST['json_replace_backslash_single_quote'];
			$json_replace_backslash_single_quote = output_html($json_replace_backslash_single_quote);
			if($json_replace_backslash_single_quote == "1"){
				$json = str_replace("\'", "'", $json);
			}
		}

		// Group title
		if($test_mode == "1"){
			$group_title 			= "$test_group_title";
		}
		else{
			if(isset($_POST['group_title'])){
				$group_title = $_POST['group_title'];
				$group_title = output_html($group_title);
				if($group_title == ""){
					echo"group_title is empty";
					die;
				}
			}
			else{
				echo"Missing group_title";
				die;
			}
		}
		$group_title_mysql = quote_smart($link, $group_title);


		if($test_mode == "1"){
			$group_show_on_analysis_report 	= "1";
		}
		else{
			if(isset($_POST['group_show_on_analysis_report'])){
				$group_show_on_analysis_report = $_POST['group_show_on_analysis_report'];
				$group_show_on_analysis_report = output_html($group_show_on_analysis_report);
				if($group_show_on_analysis_report == ""){
					echo"group_show_on_analysis_report is empty";
					die;
				}
			}
			else{
				echo"Missing group_show_on_analysis_report";
				die;
			}
		}
		$group_show_on_analysis_report_mysql = quote_smart($link, $group_show_on_analysis_report);

		// Find group title
		$query = "SELECT group_id, group_case_id, group_item_id, group_title, group_show_on_analysis_report, group_count_level_a, group_created_by_user_id, group_created_by_user_name, group_created_datetime, group_updated_by_user_id, group_updated_by_user_name, group_updated_datetime FROM $t_edb_case_index_item_info_groups WHERE group_case_id=$get_current_item_case_id AND group_item_id=$get_current_item_id AND group_title=$group_title_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_group_id, $get_current_group_case_id, $get_current_group_item_id, $get_current_group_title, $get_current_group_show_on_analysis_report, $get_current_group_count_level_a, $get_current_group_created_by_user_id, $get_current_group_created_by_user_name, $get_current_group_created_datetime, $get_current_group_updated_by_user_id, $get_current_group_updated_by_user_name, $get_current_group_updated_datetime) = $row;
		if($get_current_group_id == ""){
			// Create group
			mysqli_query($link, "INSERT INTO $t_edb_case_index_item_info_groups 
			(group_id, group_case_id, group_item_id, group_title, group_show_on_analysis_report, group_count_level_a, group_created_by_user_id, group_created_by_user_name, group_created_datetime) 
			VALUES 
			(NULL, $get_current_item_case_id, $get_current_item_id, $group_title_mysql, $group_show_on_analysis_report_mysql, 0, 1, $inp_machine_name_mysql, '$datetime')")
			or die(mysqli_error($link)); 

			// Get ID
			$query = "SELECT group_id, group_case_id, group_item_id, group_title, group_show_on_analysis_report, group_count_level_a, group_created_by_user_id, group_created_by_user_name, group_created_datetime, group_updated_by_user_id, group_updated_by_user_name, group_updated_datetime FROM $t_edb_case_index_item_info_groups WHERE group_case_id=$get_current_item_case_id AND group_item_id=$get_current_item_id AND group_title=$group_title_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_group_id, $get_current_group_case_id, $get_current_group_item_id, $get_current_group_title, $get_current_group_show_on_analysis_report, $get_current_group_count_level_a, $get_current_group_created_by_user_id, $get_current_group_created_by_user_name, $get_current_group_created_datetime, $get_current_group_updated_by_user_id, $get_current_group_updated_by_user_name, $get_current_group_updated_datetime) = $row;


		}
		
		
		
		$json_object = json_decode($json);
		// var_dump($json_object);
		
		$size_object = sizeof($json_object);
		for($a=0;$a<$size_object;$a++) {

			// LEVEL A
			$level_a_title = $json_object[$a]->level_a_title;
			$level_a_title = output_html($level_a_title);
			$level_a_title_mysql = quote_smart($link, $level_a_title);

			$level_a_value = $json_object[$a]->level_a_value;
			$level_a_is_array = is_array($level_a_value);
			if($level_a_is_array){
				$level_a_value_mysql = quote_smart($link, "");
			}
			else{
				$level_a_value = output_html($level_a_value);
				$level_a_value_mysql = quote_smart($link, $level_a_value);

			}

			$level_a_flag = $json_object[$a]->level_a_flag;
			$level_a_flag = output_html($level_a_flag);
			$level_a_flag_mysql = quote_smart($link, $level_a_flag);

			$level_a_type = $json_object[$a]->level_a_type;
			$level_a_type = output_html($level_a_type);
			$level_a_type_mysql = quote_smart($link, $level_a_type);

			$level_a_show_on_analysis_report = $json_object[$a]->level_a_show_on_analysis_report;
			$level_a_show_on_analysis_report = output_html($level_a_show_on_analysis_report);
			$level_a_show_on_analysis_report_mysql = quote_smart($link, $level_a_show_on_analysis_report);
			
			if($level_a_title != ""){
				// Check if level A exists
				$query = "SELECT level_a_id FROM $t_edb_case_index_item_info_level_a WHERE level_a_case_id=$get_current_item_case_id AND level_a_item_id=$get_current_item_id AND level_a_group_id=$get_current_group_id AND level_a_title=$level_a_title_mysql AND level_a_value=$level_a_value_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_level_a_id) = $row;
				if($get_level_a_id == ""){
					// Create group
					mysqli_query($link, "INSERT INTO $t_edb_case_index_item_info_level_a 
					(level_a_id, level_a_case_id, level_a_item_id, level_a_group_id, level_a_title, level_a_value, level_a_flag, level_a_flag_checked, level_a_type, level_a_show_on_analysis_report, level_a_created_by_user_id, level_a_created_by_user_name, level_a_created_datetime) 
					VALUES 
					(NULL, $get_current_item_case_id, $get_current_item_id, $get_current_group_id, $level_a_title_mysql, $level_a_value_mysql, $level_a_flag_mysql, 0, $level_a_type_mysql, $level_a_show_on_analysis_report_mysql, 1, $inp_machine_name_mysql, '$datetime')")
					or die(mysqli_error($link)); 

					// Get new ID
					$query = "SELECT level_a_id FROM $t_edb_case_index_item_info_level_a WHERE level_a_case_id=$get_current_item_case_id AND level_a_item_id=$get_current_item_id AND level_a_group_id=$get_current_group_id AND level_a_title=$level_a_title_mysql AND level_a_value=$level_a_value_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_level_a_id) = $row;

					// HTML?
					if($level_a_type == "html"){
						$level_a_value = $json_object[$a]->level_a_value;
						$sql = "UPDATE $t_edb_case_index_item_info_level_a  SET level_a_value=? WHERE level_a_id='$get_level_a_id'";
						$stmt = $link->prepare($sql);
						$stmt->bind_param("s", $level_a_value);
						$stmt->execute();
						if ($stmt->errno) {
							echo "FAILURE!!! " . $stmt->error; die;
						}
					}

					$count_new_level_a++;
				} // create group

				// Level B
				if($level_a_is_array && $get_level_a_id != ""){
					$size_a = sizeof($level_a_value);
					for($b=0;$b<$size_a;$b++) {
						// LEVEL B
						$level_b_title = $json_object[$a]->level_a_value[$b]->level_b_title;
						$level_b_title = output_html($level_b_title);
						$level_b_title_mysql = quote_smart($link, $level_b_title);


						$level_b_value = $json_object[$a]->level_a_value[$b]->level_b_value;
						$level_b_is_array = is_array($level_b_value);
						if($level_b_is_array){
							$level_b_value_mysql = quote_smart($link, "");
						}
						else{
							$level_b_value = output_html($level_b_value);
							$level_b_value_mysql = quote_smart($link, $level_b_value);
						}

						$level_b_flag = $json_object[$a]->level_a_value[$b]->level_b_flag;
						$level_b_flag = output_html($level_b_flag);
						$level_b_flag_mysql = quote_smart($link, $level_b_flag);

						$level_b_type = $json_object[$a]->level_a_value[$b]->level_b_type;
						$level_b_type = output_html($level_b_type);
						$level_b_type_mysql = quote_smart($link, $level_b_type);

						$level_b_show_on_analysis_report = $json_object[$a]->level_a_value[$b]->level_b_show_on_analysis_report;
						$level_b_show_on_analysis_report = output_html($level_b_show_on_analysis_report);
						$level_b_show_on_analysis_report_mysql = quote_smart($link, $level_b_show_on_analysis_report);

			
						if($level_b_title != ""){
							// Check if level B exists
							$query = "SELECT level_b_id FROM $t_edb_case_index_item_info_level_b WHERE level_b_case_id=$get_current_item_case_id AND level_b_item_id=$get_current_item_id AND level_b_group_id=$get_current_group_id AND level_b_level_a_id=$get_level_a_id AND level_b_title=$level_b_title_mysql AND level_b_value=$level_b_value_mysql";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_level_b_id) = $row;
							if($get_level_b_id == ""){

								// Create level b
								mysqli_query($link, "INSERT INTO $t_edb_case_index_item_info_level_b 
								(level_b_id, level_b_case_id, level_b_item_id, level_b_group_id, level_b_level_a_id, level_b_title, level_b_value, level_b_flag, level_b_flag_checked, level_b_type, level_b_show_on_analysis_report, level_b_created_by_user_id, level_b_created_by_user_name, level_b_created_datetime) 
								VALUES 
								(NULL, $get_current_item_case_id, $get_current_item_id, $get_current_group_id, $get_level_a_id, $level_b_title_mysql, $level_b_value_mysql, $level_b_flag_mysql, 0, $level_b_type_mysql, $level_b_show_on_analysis_report_mysql, 1, $inp_machine_name_mysql, '$datetime')")
								or die(mysqli_error($link)); 

								// Get new ID
								$query = "SELECT level_b_id FROM $t_edb_case_index_item_info_level_b WHERE level_b_case_id=$get_current_item_case_id AND level_b_item_id=$get_current_item_id AND level_b_group_id=$get_current_group_id AND level_b_level_a_id=$get_level_a_id AND level_b_title=$level_b_title_mysql AND level_b_value=$level_b_value_mysql";
								$result = mysqli_query($link, $query);
								$row = mysqli_fetch_row($result);
								list($get_level_b_id) = $row;

								// HTML?
								if($level_b_type == "html"){
									$level_b_value = $json_object[$a]->level_a_value[$b]->level_b_value;
									$sql = "UPDATE $t_edb_case_index_item_info_level_b SET level_b_value=? WHERE level_b_id='$get_level_b_id'";
									$stmt = $link->prepare($sql);
									$stmt->bind_param("s", $level_b_value);
									$stmt->execute();
									if ($stmt->errno) {
										echo "FAILURE!!! " . $stmt->error; die;
									}
								}

								$count_new_level_b++;
							} // create group



							// Level B
							if($level_b_is_array && $get_level_b_id != ""){
								$size_b = sizeof($level_b_value);
								for($c=0;$c<$size_b;$c++) {
									// LEVEL C
									$level_c_title = $json_object[$a]->level_a_value[$b]->level_b_value[$c]->level_c_title;
									$level_c_title = output_html($level_c_title);
									$level_c_title_mysql = quote_smart($link, $level_c_title);


									$level_c_value = $json_object[$a]->level_a_value[$b]->level_b_value[$c]->level_c_value;
									$level_c_is_array = is_array($level_c_value);
									if($level_c_is_array){
										$level_c_value_mysql = quote_smart($link, "");
									}
									else{
										$level_c_value = output_html($level_c_value);
										$level_c_value_mysql = quote_smart($link, $level_c_value);
									}

									$level_c_flag = $json_object[$a]->level_a_value[$b]->level_b_value[$c]->level_c_flag;
									$level_c_flag = output_html($level_c_flag);
									$level_c_flag_mysql = quote_smart($link, $level_c_flag);

									$level_c_type = $json_object[$a]->level_a_value[$b]->level_b_value[$c]->level_c_type;
									$level_c_type = output_html($level_c_type);
									$level_c_type_mysql = quote_smart($link, $level_c_type);

									$level_c_show_on_analysis_report = $json_object[$a]->level_a_value[$b]->level_b_value[$c]->level_c_show_on_analysis_report;
									$level_c_show_on_analysis_report = output_html($level_c_show_on_analysis_report);
									$level_c_show_on_analysis_report_mysql = quote_smart($link, $level_c_show_on_analysis_report);

									if($level_c_title != ""){
										// Check if level C exists
										$query = "SELECT level_c_id FROM $t_edb_case_index_item_info_level_c WHERE level_c_case_id=$get_current_item_case_id AND level_c_item_id=$get_current_item_id AND level_c_group_id=$get_current_group_id AND level_c_level_a_id=$get_level_a_id AND level_c_level_b_id=$get_level_b_id AND level_c_title=$level_c_title_mysql AND level_c_value=$level_c_value_mysql";
										$result = mysqli_query($link, $query);
										$row = mysqli_fetch_row($result);
										list($get_level_c_id) = $row;
										if($get_level_c_id == ""){

											// Create level c
											mysqli_query($link, "INSERT INTO $t_edb_case_index_item_info_level_c 
											(level_c_id, level_c_case_id, level_c_item_id, level_c_group_id, level_c_level_a_id, level_c_level_b_id, level_c_title, level_c_value, level_c_flag, level_c_flag_checked, level_c_type, level_c_show_on_analysis_report, level_c_created_by_user_id, level_c_created_by_user_name, level_c_created_datetime) 
											VALUES 
											(NULL, $get_current_item_case_id, $get_current_item_id, $get_current_group_id, $get_level_a_id, $get_level_b_id, $level_c_title_mysql, $level_c_value_mysql, $level_c_flag_mysql, 0, $level_c_type_mysql, $level_c_show_on_analysis_report_mysql, 1, $inp_machine_name_mysql, '$datetime')")
											or die(mysqli_error($link)); 

											// Get new ID
											$query = "SELECT level_c_id FROM $t_edb_case_index_item_info_level_c WHERE level_c_case_id=$get_current_item_case_id AND level_c_item_id=$get_current_item_id AND level_c_group_id=$get_current_group_id AND level_c_level_a_id=$get_level_a_id AND level_c_level_b_id=$get_level_b_id AND level_c_title=$level_c_title_mysql AND level_c_value=$level_c_value_mysql";
											$result = mysqli_query($link, $query);
											$row = mysqli_fetch_row($result);
											list($get_level_c_id) = $row;

											// HTML?
											if($level_c_type == "html"){
												$level_c_value = $json_object[$a]->level_a_value[$b]->level_b_value[$c]->level_c_value;
												$sql = "UPDATE $t_edb_case_index_item_info_level_c SET level_c_value=? WHERE level_c_id='$get_level_c_id'";
												$stmt = $link->prepare($sql);
												$stmt->bind_param("s", $level_c_value);
												$stmt->execute();
												if ($stmt->errno) {
													echo "FAILURE!!! " . $stmt->error; die;
												}
											}

											$count_new_level_c++;
										} // create group




										// Level D
										if($level_c_is_array && $get_level_c_id != ""){
											$level_c_value_size = sizeof($level_c_value);
											for($d=0;$d<$level_c_value_size;$d++) {
												// LEVEL D
												
												$level_d_title = $json_object[$a]->level_a_value[$b]->level_b_value[$c]->level_c_value[$d]->level_d_title;
												$level_d_title = output_html($level_d_title);
												$level_d_title_mysql = quote_smart($link, $level_d_title);

												$level_d_value = $json_object[$a]->level_a_value[$b]->level_b_value[$c]->level_c_value[$d]->level_d_value;
												$level_d_is_array = is_array($level_d_value);
												if($level_d_is_array){
													$level_d_value_mysql = quote_smart($link, "");
												}
												else{
													$level_d_value = output_html($level_d_value);
													$level_d_value_mysql = quote_smart($link, $level_d_value);
												}

												$level_d_flag = $json_object[$a]->level_a_value[$b]->level_b_value[$c]->level_c_value[$d]->level_d_flag;
												$level_d_flag = output_html($level_d_flag);
												$level_d_flag_mysql = quote_smart($link, $level_d_flag);

												$level_d_type = $json_object[$a]->level_a_value[$b]->level_b_value[$c]->level_c_value[$d]->level_d_type;
												$level_d_type = output_html($level_d_type);
												$level_d_type_mysql = quote_smart($link, $level_d_type);

												$level_d_show_on_analysis_report = $json_object[$a]->level_a_value[$b]->level_b_value[$c]->level_c_value[$d]->level_d_show_on_analysis_report;
												$level_d_show_on_analysis_report = output_html($level_d_show_on_analysis_report);
												$level_d_show_on_analysis_report_mysql = quote_smart($link, $level_d_show_on_analysis_report);
												if($level_d_title != ""){
													// Check if level C exists
													$query = "SELECT level_d_id FROM $t_edb_case_index_item_info_level_d WHERE level_d_case_id=$get_current_item_case_id AND level_d_item_id=$get_current_item_id AND level_d_group_id=$get_current_group_id AND level_d_level_a_id=$get_level_a_id AND level_d_level_b_id=$get_level_b_id AND level_d_level_c_id=$get_level_c_id AND level_d_title=$level_d_title_mysql AND level_d_value=$level_d_value_mysql";
													$result = mysqli_query($link, $query);
													$row = mysqli_fetch_row($result);
													list($get_level_d_id) = $row;
													if($get_level_d_id == ""){
														// Create level d
														mysqli_query($link, "INSERT INTO $t_edb_case_index_item_info_level_d 
														(level_d_id, level_d_case_id, level_d_item_id, level_d_group_id, level_d_level_a_id, level_d_level_b_id, level_d_level_c_id, level_d_title, level_d_value, level_d_flag, level_d_flag_checked, level_d_type, level_d_show_on_analysis_report, level_d_created_by_user_id, level_d_created_by_user_name, level_d_created_datetime) 
														VALUES 
														(NULL, $get_current_item_case_id, $get_current_item_id, $get_current_group_id, $get_level_a_id, $get_level_b_id, $get_level_c_id, $level_d_title_mysql, $level_d_value_mysql, $level_d_flag_mysql, 0, $level_d_type_mysql, $level_d_show_on_analysis_report_mysql, 1, $inp_machine_name_mysql, '$datetime')")
														or die(mysqli_error($link)); 

														// Get new ID
														$query = "SELECT level_d_id FROM $t_edb_case_index_item_info_level_d WHERE level_d_case_id=$get_current_item_case_id AND level_d_item_id=$get_current_item_id AND level_d_group_id=$get_current_group_id AND level_d_level_a_id=$get_level_a_id AND level_d_level_b_id=$get_level_b_id AND level_d_level_c_id=$get_level_c_id AND level_d_title=$level_d_title_mysql AND level_d_value=$level_d_value_mysql";
														$result = mysqli_query($link, $query);
														$row = mysqli_fetch_row($result);
														list($get_level_d_id) = $row;

														// HTML?
														if($level_c_type == "html"){
															$level_d_value = $json_object[$a]->level_a_value[$b]->level_b_value[$c]->level_c_value[$d]->level_d_value;
															$sql = "UPDATE $t_edb_case_index_item_info_level_d SET level_d_value=? WHERE level_d_id='$get_level_d_id'";
															$stmt = $link->prepare($sql);
															$stmt->bind_param("s", $level_d_value);
															$stmt->execute();
															if ($stmt->errno) {
																echo "FAILURE!!! " . $stmt->error; die;
															}
														}

														$count_new_level_d++;
													} // create group
												} // level d title != ""

											} // for level d
										} // Level C is array



									} // level c title != ""
								} // for level c
							} // Level B is array

						} // level b title != ""
					} // for level b
				} // Level A is array
			} // level a title != ""

		} // for level a


		// Group count level A
		$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_item_info_groups SET group_count_level_a='$count_new_level_a' WHERE group_id=$get_current_group_id") or die(mysqli_error($link)); 

		// Feedback
		echo"Success. Group ID=$get_current_group_id. Group title=$get_current_group_title. Level a = $count_new_level_a. Level b = $count_new_level_b. Level c = $count_new_level_c. Level d = $count_new_level_d.";
		
		
	} // evidence found
} // machine found

?>