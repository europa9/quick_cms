<?php 
/**
*
* File: edb/agents/02-03_find_new_mirror_files_ping_on.php
* Version 1.0
* Date 21:03 04.08.2019
* Copyright (c) 2019 S. A. Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Tables ---------------------------------------------------------------------------- */
$t_edb_ping_on	= $mysqlPrefixSav . "edb_ping_on";



/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
	
	if($get_current_case_id != "" && $get_current_mirror_file_id != ""){

		$rows_array = array();


		// This file will have data already in it
		$query_case = "SELECT case_id, case_number, case_title, case_title_clean, case_suspect_in_custody, case_code_id, case_code_number, case_code_title, case_status_id, case_status_title, case_priority_id, case_priority_title, case_district_id, case_district_title, case_station_id, case_station_title, case_is_screened, case_physical_location, case_backup_disks, case_confirmed_by_human, case_human_rejected, case_last_event_text, case_path_windows, case_path_linux, case_path_folder_name, case_assigned_to_datetime, case_assigned_to_date, case_assigned_to_time, case_assigned_to_date_saying, case_assigned_to_date_ddmmyy, case_assigned_to_date_ddmmyyyy, case_assigned_to_user_id, case_assigned_to_user_name, case_assigned_to_user_alias, case_assigned_to_user_email, case_assigned_to_user_image_path, case_assigned_to_user_image_file, case_assigned_to_user_image_thumb_40, case_assigned_to_user_image_thumb_50, case_assigned_to_user_first_name, case_assigned_to_user_middle_name, case_assigned_to_user_last_name, case_created_datetime, case_created_date, case_created_time, case_created_date_saying, case_created_date_ddmmyy, case_created_date_ddmmyyyy, case_created_user_id, case_created_user_name, case_created_user_alias, case_created_user_email, case_created_user_image_path, case_created_user_image_file, case_created_user_image_thumb_40, case_created_user_image_thumb_50, case_created_user_first_name, case_created_user_middle_name, case_created_user_last_name, case_detective_user_id, case_detective_user_job_title, case_detective_user_department, case_detective_user_first_name, case_detective_user_middle_name, case_detective_user_last_name, case_detective_user_name, case_detective_user_alias, case_detective_user_email, case_detective_email_alerts, case_detective_user_image_path, case_detective_user_image_file, case_detective_user_image_thumb_40, case_detective_user_image_thumb_50, case_updated_datetime, case_updated_date, case_updated_time, case_updated_date_saying, case_updated_date_ddmmyy, case_updated_date_ddmmyyyy, case_updated_user_id, case_updated_user_name, case_updated_user_alias, case_updated_user_email, case_updated_user_image_path, case_updated_user_image_file, case_updated_user_image_thumb_40, case_updated_user_image_thumb_50, case_updated_user_first_name, case_updated_user_middle_name, case_updated_user_last_name, case_is_closed, case_closed_datetime, case_closed_date, case_closed_time, case_closed_date_saying, case_closed_date_ddmmyy, case_closed_date_ddmmyyyy, case_time_from_created_to_close FROM $t_edb_case_index WHERE case_id=$get_current_case_id";
		$result_case = mysqli_query($link, $query_case);
		$row_case = mysqli_fetch_array($result_case, MYSQLI_ASSOC);
		$rows_array['case_index'] = $row_case;

		$query_mirror = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_confirmed_by_human, mirror_file_human_rejected, mirror_file_created_datetime, mirror_file_created_date, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_created_date_ddmmyyyy, mirror_file_modified_datetime, mirror_file_modified_date, mirror_file_modified_time, mirror_file_modified_date_saying, mirror_file_modified_date_ddmmyy, mirror_file_modified_date_ddmmyyyy, mirror_file_size_bytes, mirror_file_size_mb, mirror_file_size_human, mirror_file_backup_disk, mirror_file_exists, mirror_file_exists_agent_tries_counter, mirror_file_ready_for_automated_machine, mirror_file_ready_agent_tries_counter, mirror_file_comments FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_id=$get_current_mirror_file_id";
		$result_mirror = mysqli_query($link, $query_mirror);
		$row_mirror = mysqli_fetch_array($result_mirror, MYSQLI_ASSOC);
		$rows_array['mirror_file'] = $row_mirror;

		// Get Item ID
		$query_item = "SELECT mirror_file_item_id FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_id=$get_current_mirror_file_id";
		$result_item = mysqli_query($link, $query_item);
		$row_item = mysqli_fetch_row($result_item);
		list($get_mirror_file_item_id) = $row_item;

		$query_item = "SELECT * FROM $t_edb_case_index_evidence_items WHERE item_id=$get_mirror_file_item_id AND item_case_id=$get_current_case_id";
		$result_item = mysqli_query($link, $query_item);
		$row_item = mysqli_fetch_array($result_item, MYSQLI_ASSOC);
		$rows_array['evidence_item'] = $row_item;



		// Json everything
		$rows_json = json_encode(utf8ize($rows_array));

		// Find who to send it to
		$datetime = date("Y-m-d H:i:s");
		$query_pings = "SELECT ping_on_id, ping_on_when, ping_on_to_ip, ping_on_last_datetime FROM $t_edb_ping_on WHERE ping_on_when='new_mirror_file'";
		$result_pings = mysqli_query($link, $query_pings);
		while($row_pings = mysqli_fetch_row($result_pings)) {
			list($get_ping_on_id, $get_ping_on_when, $get_ping_on_to_ip, $get_ping_on_last_datetime) = $row_pings;


			// Update last pinged
			$result_update = mysqli_query($link, "UPDATE $t_edb_ping_on SET ping_on_last_datetime='$datetime' WHERE ping_on_id=$get_ping_on_id");
		

			$curl = curl_init($get_ping_on_to_ip);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER,
			        array("Content-type: application/json"));
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $rows_json);
			
			$json_response = curl_exec($curl);

			$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

			if ($status == 200 OR $status == 201) {
				// Log
				//$json = json_decode($rows_json);
				//echo json_encode($json, JSON_PRETTY_PRINT);

				curl_close($curl);
				$response = json_decode($json_response, true);

				// Log
				$text = "Ping new mirror file to $get_ping_on_to_ip. Response: $response. ";
				$text_mysql = quote_smart($link, $text);
				echo" &middot; $text ";
				mysqli_query($link, "INSERT INTO $t_edb_agent_log
				(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES 
				(NULL, '02_find_new_mirror_files_root_ping_on.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
				or die(mysqli_error($link));
				
			}
			else{
				// Log
				$text = "<span style=\"color:red;\">Ping new mirror file to $get_ping_on_to_ip. Failed with status $status.</span>";
				$text_mysql = quote_smart($link, $text);
				echo" &middot; $text ";
				mysqli_query($link, "INSERT INTO $t_edb_agent_log
				(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES 
				(NULL, '02_find_new_mirror_files_root_ping_on.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
				or die(mysqli_error($link));
			}
		} // ping on
	} // mirror file

} // logged in

?>