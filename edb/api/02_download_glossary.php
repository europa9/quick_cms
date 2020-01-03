<?php 
/**
*
* File: edb/api/02_download_glossary.php
* Version 1.0
* Date 15:23 21.08.2019
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
$t_edb_machines_types				= $mysqlPrefixSav . "edb_machines_types";
$t_edb_machines_all_tasks_available		= $mysqlPrefixSav . "edb_machines_all_tasks_available";
$t_edb_machines_all_tasks_available_to_item  	= $mysqlPrefixSav . "edb_machines_all_tasks_available_to_item";

/*- Functions -------------------------------------------------------------------------- */

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['machine_key'])) {
	$machine_key = $_GET['machine_key'];
	$machine_key = strip_tags(stripslashes($machine_key));
}
else{
	$machine_key = "";
}
$machine_key_mysql = quote_smart($link, $machine_key);

if(isset($_GET['case_id'])) {
	$case_id = $_GET['case_id'];
	$case_id = strip_tags(stripslashes($case_id));
}
else{
	$case_id = "";
}
$case_id_mysql = quote_smart($link, $case_id);



if(isset($_GET['case_glossary_id'])) {
	$case_glossary_id = $_GET['case_glossary_id'];
	$case_glossary_id = strip_tags(stripslashes($case_glossary_id));
}
else{
	$case_glossary_id = "";
}
$case_glossary_id_mysql = quote_smart($link, $case_glossary_id);



// Look for machine
$query = "SELECT machine_id, machine_name, machine_os, machine_ip, machine_mac, machine_key, machine_description, machine_station_id, machine_station_title, machine_last_seen_datetime, machine_last_seen_time, machine_last_seen_ddmmyyhi, machine_last_seen_ddmmyyyyhi, machine_is_working_with_automated_task_id, machine_started_working_datetime, machine_started_working_time, machine_started_working_ddmmyyhi, machine_started_working_ddmmyyyyhi FROM $t_edb_machines_index WHERE machine_key=$machine_key_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_machine_id, $get_current_machine_name, $get_current_machine_os, $get_current_machine_ip, $get_current_machine_mac, $get_current_machine_key, $get_current_machine_description, $get_current_machine_station_id, $get_current_machine_station_title, $get_current_machine_last_seen_datetime, $get_current_machine_last_seen_time, $get_current_machine_last_seen_ddmmyyhi, $get_current_machine_last_seen_ddmmyyyyhi, $get_current_machine_is_working_with_automated_task_id, $get_current_machine_started_working_datetime, $get_current_machine_started_working_time, $get_current_machine_started_working_ddmmyyhi, $get_current_machine_started_working_ddmmyyyyhi) = $row;

if($get_current_machine_id == ""){
	echo"<h1>02_download_glossary.php Server error 404</h1><p>Machine not found</p>";
	die;
}

// Look for case
$query = "SELECT case_id FROM $t_edb_case_index WHERE case_id=$case_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_case_id) = $row;
	
if($get_current_case_id == ""){
	echo"<h1>02_download_glossary.php Server error 404</h1><p>Case not found</p>";
	die;
}


// Look for case glossary
$query = "SELECT case_glossary_id, case_glossary_case_id, case_glossary_glossary_id, case_glossary_glossary_title, case_glossary_words FROM $t_edb_case_index_glossaries WHERE case_glossary_id=$case_glossary_id_mysql AND case_glossary_case_id=$get_current_case_id";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_case_glossary_id, $get_current_case_glossary_case_id, $get_current_case_glossary_glossary_id, $get_current_case_glossary_glossary_title, $get_current_case_glossary_words) = $row;
		
if($get_current_case_glossary_id == ""){
	echo"<h1>02_download_glossary.php Server error 404</h1><p>Case glossary not found</p>";
	die;
}



// Update last seen
$datetime = date("Y-m-d H:i:s");
$time = time();
$date_saying = date("d M Y H:i");
$date_ddmmyyhi = date("d.m.y H:i");
$date_ddmmyyyyhi = date("d.m.Y H:i:");
	
$result = mysqli_query($link, "UPDATE $t_edb_machines_index SET
				machine_last_seen_datetime='$datetime',
				machine_last_seen_time='$time',
				machine_last_seen_ddmmyyhi='$date_ddmmyyhi',
				machine_last_seen_ddmmyyyyhi='$date_ddmmyyyyhi',
				machine_is_working_with_automated_task_id='0',
				machine_started_working_datetime=NULL,
				machine_started_working_time=NULL,
				machine_started_working_ddmmyyhi=NULL,
				machine_started_working_ddmmyyyyhi=NULL
				 WHERE machine_id=$get_current_machine_id") or die(mysqli_error($link));


// Glossary data
$get_current_case_glossary_words = str_replace('&#039;', '"', $get_current_case_glossary_words);

// Build array
/*
$case_glossary_array = array();
$case_glossary_array['case_glossary_id'] = "$get_current_case_glossary_id";
$case_glossary_array['case_glossary_case_id'] = "$get_current_case_glossary_case_id";
$case_glossary_array['case_glossary_glossary_id'] = "$get_current_case_glossary_glossary_id";
$case_glossary_array['case_glossary_glossary_title'] = "$get_current_case_glossary_glossary_title";
$case_glossary_array['case_glossary_words'] = "$get_current_case_glossary_words";

// Json everything
$rows_json = json_encode(utf8ize($case_glossary_array));

echo"$rows_json";
*/
echo"$get_current_case_glossary_words";



?>