<?php 
/**
*
* File: edb/api/01_client_mounted_backup_disk.php
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

/*- Test mode -------------------------------------------------------------------------- */
$test_mode = "1";
$test_machine_key		= "haugesund_backup";
$test_disk_name 		= "H10";
$test_disk_signature 		= "oaijdq0992adwadw";
$test_disk_capacity_bytes 	= "536870912000"; // 500 GB
$test_disk_available_bytes 	= "236870912000"; // 200 GB
$test_disk_station_title	= "Haugesund";




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

if(isset($_POST['disk_name'])) {
	$disk_name = $_POST['disk_name'];
	$disk_name = strip_tags(stripslashes($disk_name));
}
else{
	if($test_mode == "1"){
		if(isset($test_disk_name)){
			$disk_name = "$test_disk_name";
		}
		else{
			$disk_name = "";
		}
	}
	else{
		$disk_name = "";
	}
}
$disk_name_mysql = quote_smart($link, $disk_name);

if(isset($_POST['disk_signature'])) {
	$disk_signature = $_POST['disk_signature'];
	$disk_signature = strip_tags(stripslashes($disk_signature));
}
else{
	if($test_mode == "1"){
		$disk_signature = "$test_disk_signature";
	}
	else{
		$disk_signature = "";
	}
}
$disk_signature_mysql = quote_smart($link, $disk_signature);

if(isset($_POST['disk_capacity_bytes'])) {
	$disk_capacity_bytes = $_POST['disk_capacity_bytes'];
	$disk_capacity_bytes = strip_tags(stripslashes($disk_capacity_bytes));
}
else{
	if($test_mode == "1"){
		$disk_capacity_bytes = "$test_disk_capacity_bytes";
	}
	else{
		$disk_capacity_bytes = "";
	}
}
$disk_capacity_bytes_mysql = quote_smart($link, $disk_capacity_bytes);

if(isset($_POST['disk_available_bytes'])) {
	$disk_available_bytes = $_POST['disk_available_bytes'];
	$disk_available_bytes = strip_tags(stripslashes($disk_available_bytes));
}
else{
	if($test_mode == "1"){
		$disk_available_bytes = "$test_disk_available_bytes";
	}
	else{
		$disk_available_bytes = "";
	}
}
$disk_available_bytes_mysql = quote_smart($link, $disk_available_bytes);

if(isset($_POST['disk_station_title'])) {
	$disk_station_title = $_POST['disk_station_title'];
	$disk_station_title = strip_tags(stripslashes($disk_station_title));
}
else{
	if($test_mode == "1"){
		$disk_station_title = "$test_disk_station_title";
	}
	else{
		$disk_station_title = "";
	}
}
$disk_station_title_mysql = quote_smart($link, $disk_station_title);


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


	if($get_current_machine_is_working_with_automated_task_id == "0" OR $get_current_machine_is_working_with_automated_task_id == ""){

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

		// Look for harddisk, if none specified, then create next harddisk name
		if($disk_name == ""){
			// New backup disk
			// Get last created disk name, then create a new 
			$query_last_disk = "SELECT disk_id, disk_name, disk_signature, disk_capacity_bytes, disk_capacity_human, disk_available_bytes, disk_available_human, disk_used_bytes, disk_used_human, disk_created_datetime, disk_created_ddmmyyyy, disk_updated_datetime, disk_updated_ddmmyyyy, disk_client_machine_id, disk_client_machine_name, disk_client_machine_key, disk_client_machine_ip, disk_client_machine_agent, disk_client_last_mounted_datetime, disk_client_last_mounted_ddmmyyyy, disk_district_id, disk_district_title, disk_station_id, disk_station_title FROM $t_edb_backup_disks WHERE disk_station_title=$disk_station_title_mysql ORDER BY disk_id DESC LIMIT 0,1";
			$result_last_disk = mysqli_query($link, $query_last_disk);
			$row_last_disk = mysqli_fetch_row($result_last_disk);
			list($get_last_disk_id, $get_last_disk_name, $get_last_disk_signature, $get_last_disk_capacity_bytes, $get_last_disk_capacity_human, $get_last_disk_available_bytes, $get_last_disk_available_human, $get_last_disk_used_bytes, $get_last_disk_used_human, $get_last_disk_created_datetime, $get_last_disk_created_ddmmyyyy, $get_last_disk_updated_datetime, $get_last_disk_updated_ddmmyyyy, $get_last_disk_client_machine_id, $get_last_disk_client_machine_name, $get_last_disk_client_machine_key, $get_last_disk_client_machine_ip, $get_last_disk_client_machine_agent, $get_last_disk_client_last_mounted_datetime, $get_last_disk_client_last_mounted_ddmmyyyy, $get_last_disk_district_id, $get_last_disk_district_title, $get_last_disk_station_id, $get_last_disk_station_title) = $row_last_disk;

			if($get_last_disk_id == ""){
				echo"Could not find last disk used! First hard disk for station $disk_station_title has to be created in website control panel."; die;
			}
			else{
				// Pattern for disk name is "some text" "some number"
				// Find prefix
				$prefix = "$get_last_disk_name";
				$prefix = str_replace('0', '', $prefix);
				$prefix = str_replace('1', '', $prefix);
				$prefix = str_replace('2', '', $prefix);
				$prefix = str_replace('3', '', $prefix);
				$prefix = str_replace('4', '', $prefix);
				$prefix = str_replace('5', '', $prefix);
				$prefix = str_replace('6', '', $prefix);
				$prefix = str_replace('7', '', $prefix);
				$prefix = str_replace('8', '', $prefix);
				$prefix = str_replace('9', '', $prefix);
			
				$last_used_number = str_replace($prefix, "", $get_last_disk_name);
				$next_number = $last_used_number+1;
				
				$inp_disk_name = $prefix . $next_number;
				$inp_disk_name_mysql = quote_smart($link, $inp_disk_name);

				$inp_disk_client_mysql = quote_smart($link, $get_current_machine_name);

				$inp_district_title_mysql = quote_smart($link, $get_last_disk_district_title);
				$inp_station_title_mysql = quote_smart($link, $get_last_disk_station_title);

				// Automated machine
				$inp_machine_name_mysql = quote_smart($link, $get_current_machine_name);
				$inp_machine_key_mysql = quote_smart($link, $get_current_machine_key);
				
				// Create disk
				mysqli_query($link, "INSERT INTO $t_edb_backup_disks 
				(disk_id, disk_name, disk_signature, disk_client_machine_id, disk_client_machine_name, disk_client_machine_key, 
				disk_client_machine_ip, disk_client_machine_agent, disk_client_last_mounted_datetime, disk_client_last_mounted_ddmmyyyy, disk_district_id, 
				disk_district_title, disk_station_id, disk_station_title) 
				VALUES 
				(NULL, $inp_disk_name_mysql, $disk_signature_mysql, $get_current_machine_id, $inp_machine_name_mysql, $inp_machine_key_mysql,
				$my_ip_mysql, $my_user_agent_mysql, '$datetime', '$date_ddmmyyyy', $get_last_disk_district_id,
				$inp_district_title_mysql, $get_last_disk_station_id, $inp_station_title_mysql)")
				or die(mysqli_error($link));

				// Get the ID
				$query_disk = "SELECT disk_id, disk_name, disk_signature, disk_capacity_bytes, disk_capacity_human, disk_available_bytes, disk_available_human, disk_used_bytes, disk_used_human, disk_created_datetime, disk_created_ddmmyyyy, disk_updated_datetime, disk_updated_ddmmyyyy, disk_client_machine_id, disk_client_machine_name, disk_client_machine_key, disk_client_machine_ip, disk_client_machine_agent, disk_client_last_mounted_datetime, disk_client_last_mounted_ddmmyyyy, disk_district_id, disk_district_title, disk_station_id, disk_station_title FROM $t_edb_backup_disks WHERE disk_name=$inp_disk_name_mysql AND disk_station_title=$disk_station_title_mysql";
				$result_disk = mysqli_query($link, $query_disk);
				$row_disk = mysqli_fetch_row($result_disk);
				list($get_current_disk_id, $get_current_disk_name, $get_current_disk_signature, $get_current_disk_capacity_bytes, $get_current_disk_capacity_human, $get_current_disk_available_bytes, $get_current_disk_available_human, $get_current_disk_used_bytes, $get_current_disk_used_human, $get_current_disk_created_datetime, $get_current_disk_created_ddmmyyyy, $get_current_disk_updated_datetime, $get_current_disk_updated_ddmmyyyy, $get_current_disk_client_machine_id, $get_current_disk_client_machine_name, $get_current_disk_client_machine_key, $get_current_disk_client_machine_ip, $get_current_disk_client_machine_agent, $get_current_disk_client_last_mounted_datetime, $get_current_disk_client_last_mounted_ddmmyyyy, $get_current_disk_district_id, $get_current_disk_district_title, $get_current_disk_station_id, $get_current_disk_station_title) = $row_disk;
			
				// Size of disk?
				if($disk_capacity_bytes != "" && $disk_available_bytes != ""){
					// Capacity
					$inp_capacity_human = $disk_capacity_bytes/1024;
					$inp_capacity_human = $inp_capacity_human/1024;
					$inp_capacity_human = $inp_capacity_human/1024;
					$inp_capacity_human = round($inp_capacity_human, 1);
					$inp_capacity_human = $inp_capacity_human . " GB";
					$inp_capacity_human_mysql = quote_smart($link, $inp_capacity_human);

					// Available
					$inp_available_human = $disk_available_bytes/1024;
					$inp_available_human = $inp_available_human/1024;
					$inp_available_human = $inp_available_human/1024;
					$inp_available_human = $inp_available_human . " GB";
					$inp_available_human = round($inp_available_human, 1);
					$inp_available_human_mysql = quote_smart($link, $inp_available_human);

					// Used
					$inp_used_bytes = $disk_capacity_bytes-$disk_available_bytes;
					$inp_used_bytes_mysql = quote_smart($link, $inp_used_bytes);

					$inp_used_human = $inp_used_bytes/1024;
					$inp_used_human = $inp_used_human/1024;
					$inp_used_human = $inp_used_human/1024;
					$inp_used_human = round($inp_used_human, 1);
					$inp_used_human = $inp_used_human . " GB";
					$inp_used_human_mysql = quote_smart($link, $inp_used_human);

						$result = mysqli_query($link, "UPDATE $t_edb_backup_disks SET 
								disk_capacity_bytes=$disk_capacity_bytes_mysql,
								disk_capacity_human=$inp_capacity_human_mysql,
								disk_available_bytes=$disk_available_bytes_mysql,
								disk_available_human=$inp_available_human_mysql,
								disk_used_bytes=$inp_used_bytes_mysql,
								disk_used_human=$inp_used_human_mysql 
								 WHERE disk_id=$get_current_disk_id") or die(mysqli_error($link));
				}


				// Json disk
				$rows_array = array();
				$query = "SELECT * FROM $t_edb_backup_disks WHERE disk_name=$inp_disk_name_mysql AND disk_station_title=$disk_station_title_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$rows_array[] = $row;
				$rows_json = json_encode(utf8ize($rows_array));
				echo"$rows_json";
				die;
				
			}
		} // new disk (disk name not entered)
		else{
			$query_disk = "SELECT disk_id, disk_name, disk_signature, disk_capacity_bytes, disk_capacity_human, disk_available_bytes, disk_available_human, disk_used_bytes, disk_used_human, disk_created_datetime, disk_created_ddmmyyyy, disk_updated_datetime, disk_updated_ddmmyyyy, disk_client_machine_id, disk_client_machine_name, disk_client_machine_key, disk_client_machine_ip, disk_client_machine_agent, disk_client_last_mounted_datetime, disk_client_last_mounted_ddmmyyyy, disk_district_id, disk_district_title, disk_station_id, disk_station_title FROM $t_edb_backup_disks WHERE disk_name=$disk_name_mysql AND disk_station_title=$disk_station_title_mysql";
			$result_disk = mysqli_query($link, $query_disk);
			$row_disk = mysqli_fetch_row($result_disk);
			list($get_current_disk_id, $get_current_disk_name, $get_current_disk_signature, $get_current_disk_capacity_bytes, $get_current_disk_capacity_human, $get_current_disk_available_bytes, $get_current_disk_available_human, $get_current_disk_used_bytes, $get_current_disk_used_human, $get_current_disk_created_datetime, $get_current_disk_created_ddmmyyyy, $get_current_disk_updated_datetime, $get_current_disk_updated_ddmmyyyy, $get_current_disk_client_machine_id, $get_current_disk_client_machine_name, $get_current_disk_client_machine_key, $get_current_disk_client_machine_ip, $get_current_disk_client_machine_agent, $get_current_disk_client_last_mounted_datetime, $get_current_disk_client_last_mounted_ddmmyyyy, $get_current_disk_district_id, $get_current_disk_district_title, $get_current_disk_station_id, $get_current_disk_station_title) = $row_disk;
			
			if($get_current_disk_id == ""){
				echo"Disk not found (disk_name=$disk_name AND disk_station_title=$disk_station_title)"; die;
			}
			else{
				// Mount disk	
				$inp_machine_name_mysql = quote_smart($link, $get_current_machine_name);
				$inp_machine_key_mysql = quote_smart($link, $get_current_machine_key);
				
				$result = mysqli_query($link, "UPDATE $t_edb_backup_disks SET 
								disk_signature=$disk_signature_mysql, 
								disk_client_machine_id=$get_current_machine_id, 
								disk_client_machine_name=$inp_machine_name_mysql, 
								disk_client_machine_key=$inp_machine_key_mysql, 
								disk_client_machine_ip=$my_ip_mysql, 
								disk_client_machine_agent=$my_user_agent_mysql, 
								disk_client_last_mounted_datetime='$datetime', 
								disk_client_last_mounted_ddmmyyyy='$date_ddmmyyyy'
								 WHERE disk_id=$get_current_disk_id") or die(mysqli_error($link));


				// Size of disk?
				if($disk_capacity_bytes != "" && $disk_available_bytes != ""){
					// Capacity
					$inp_capacity_human = $disk_capacity_bytes/1024;
					$inp_capacity_human = $inp_capacity_human/1024;
					$inp_capacity_human = $inp_capacity_human/1024;
					$inp_capacity_human = round($inp_capacity_human, 1);
					$inp_capacity_human = $inp_capacity_human . " GB";
					$inp_capacity_human_mysql = quote_smart($link, $inp_capacity_human);

					// Available
					$inp_available_human = $disk_available_bytes/1024;
					$inp_available_human = $inp_available_human/1024;
					$inp_available_human = $inp_available_human/1024;
					$inp_available_human = round($inp_available_human, 1);
					$inp_available_human = $inp_available_human . " GB";
					$inp_available_human_mysql = quote_smart($link, $inp_available_human);

					// Used
					$inp_used_bytes = $disk_capacity_bytes-$disk_available_bytes;
					$inp_used_bytes_mysql = quote_smart($link, $inp_used_bytes);

					$inp_used_human = $inp_used_bytes/1024;
					$inp_used_human = $inp_used_human/1024;
					$inp_used_human = $inp_used_human/1024;
					$inp_used_human = round($inp_used_human, 1);
					$inp_used_human = $inp_used_human . " GB";
					$inp_used_human_mysql = quote_smart($link, $inp_used_human);

						$result = mysqli_query($link, "UPDATE $t_edb_backup_disks SET 
								disk_capacity_bytes=$disk_capacity_bytes_mysql,
								disk_capacity_human=$inp_capacity_human_mysql,
								disk_available_bytes=$disk_available_bytes_mysql,
								disk_available_human=$inp_available_human_mysql,
								disk_used_bytes=$inp_used_bytes_mysql,
								disk_used_human=$inp_used_human_mysql 
								 WHERE disk_id=$get_current_disk_id") or die(mysqli_error($link));
				}

				// Give back info
				$rows_array = array();
				$query = "SELECT * FROM $t_edb_backup_disks WHERE disk_id=$get_current_disk_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$rows_array[] = $row;
				$rows_json = json_encode(utf8ize($rows_array));
				echo"$rows_json";

			}
		} // disk name entered by user


	} // machine already busy with task (before seeing tasks)
	else{
		echo"Your already busy with task (ID=$get_current_machine_is_working_with_automated_task_id), that you started working on $get_current_machine_started_working_ddmmyyyyhi";
	}
} // machine found

?>