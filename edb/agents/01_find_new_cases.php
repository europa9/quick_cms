<?php 
/**
*
* File: edb/agents/01_find_new_cases.php
* Version 1.0
* Date 21:03 04.08.2019
* Copyright (c) 2019 S. A. Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
ini_set('max_execution_time', 10);
/*- Tables ---------------------------------------------------------------------------- */
$t_edb_human_tasks_on_new_case		= $mysqlPrefixSav . "edb_human_tasks_on_new_case";
$t_edb_human_tasks_in_case_categories	= $mysqlPrefixSav . "edb_human_tasks_in_case_categories";
$t_edb_human_tasks_in_case_tasks	= $mysqlPrefixSav . "edb_human_tasks_in_case_tasks";

/*- Tables review ---------------------------------------------------------------------- */
$t_edb_review_matrix_titles = $mysqlPrefixSav . "edb_review_matrix_titles";
$t_edb_review_matrix_fields = $mysqlPrefixSav . "edb_review_matrix_fields";

$t_edb_case_index_review_notes			= $mysqlPrefixSav . "edb_case_index_review_notes";
$t_edb_case_index_review_matrix_titles		= $mysqlPrefixSav . "edb_case_index_review_matrix_titles";
$t_edb_case_index_review_matrix_fields		= $mysqlPrefixSav . "edb_case_index_review_matrix_fields";
$t_edb_case_index_review_matrix_contents	= $mysqlPrefixSav . "edb_case_index_review_matrix_contents";


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


/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){

	
	/*- Headers ---------------------------------------------------------------------------------- */
	echo"<!DOCTYPE html>\n";
	echo"<html lang=\"$l\">\n";
	echo"<head>\n";
	echo"	<title>$l_edb - $l_agent</title>\n";
	echo"	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
	echo"	<meta name=\"viewport\" content=\"width=device-width; initial-scale=1.0;\"/>\n";
	echo"	<style type=\"text/css\">\n";
	echo"	div.main {\n";
   	echo"		text-align: center;\n";
	echo"	}\n";
	echo"	p {\n";
   	echo"		font: normal 12px Arial,\"Helvetica Neue\",Helvetica,sans-serif;\n";
	echo"	}\n";
	echo"	a {\n";
   	echo"		font: normal 12px Arial,\"Helvetica Neue\",Helvetica,sans-serif;\n";
   	echo"		color: #0052cd;\n";
   	echo"		text-decoration:none;\n";
	echo"	}\n";
	echo"	a:hover {\n";
   	echo"		color: #172b4d;\n";
	echo"	}\n";
	echo"	</style>\n";
	echo"	<meta http-equiv=\"refresh\" content=\"300;URL='agent.php?l=$l'\" />\n";  
	echo"</head>\n";
	echo"<body>\n";

	
	$datetime = date("Y-m-d H:i:s");
	$date = date("Y-m-d");
	$time = time();
	$date_dmyhi = date("d.m.y H:i");
	$date_saying = date("d. M y H:i");
	$date_hi = date("H:i");
	$date_h = date("H");
	$date_i = date("i");
	$date_dmy = date("d.m.y");
	$date_ddmmyyyy = date("d.m.Y");
	$date_ddmmyyyyhi = date("d.m.Y H:i");

	echo"
	<div class=\"main\">
	<p><a href=\"agent_display_log.php?l=$l\" target=\"_top\">$l_agent 01</a> $date_hi
	";

	
	// 2. Look for new cases
	// First open directory for station
	$query = "SELECT directory_id, directory_station_id, directory_station_title, directory_district_id, directory_district_title, directory_type, directory_address_linux, directory_address_windows, directory_address_prefered_for_agent, directory_last_checked_for_new_files_counter, directory_last_checked_for_new_files_time, directory_last_checked_for_new_files_hour, directory_last_checked_for_new_files_minute, directory_now_size_last_calculated_day, directory_now_size_last_calculated_hour, directory_now_size_last_calculated_minute, directory_now_size_mb, directory_now_size_gb, directory_available_size_mb, directory_available_size_gb, directory_available_size_percentage FROM $t_edb_stations_directories WHERE directory_type='mirror_files' ORDER BY directory_last_checked_for_new_files_counter ASC LIMIT 0,1";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_directory_id, $get_current_directory_station_id, $get_current_directory_station_title, $get_current_directory_district_id, $get_current_directory_district_title, $get_current_directory_type, $get_current_directory_address_linux, $get_current_directory_address_windows, $get_current_directory_address_prefered_for_agent, $get_current_directory_last_checked_for_new_files_counter, $get_current_directory_last_checked_for_new_files_time, $get_current_directory_last_checked_for_new_files_hour, $get_current_directory_last_checked_for_new_files_minute, $get_current_directory_now_size_last_calculated_day, $get_current_directory_now_size_last_calculated_hour, $get_current_directory_now_size_last_calculated_minute, $get_current_directory_now_size_mb, $get_current_directory_now_size_gb, $get_current_directory_available_size_mb, $get_current_directory_available_size_gb, $get_current_directory_available_size_percentage) = $row;
	if($get_current_directory_id != ""){


		$inp_directory_last_checked_for_new_files_counter = $get_current_directory_last_checked_for_new_files_counter+1;

		$result_update = mysqli_query($link, "UPDATE $t_edb_stations_directories SET 
							directory_last_checked_for_new_files_counter=$inp_directory_last_checked_for_new_files_counter,
							directory_last_checked_for_new_files_time='$time',
							directory_last_checked_for_new_files_hour='$date_h',
							directory_last_checked_for_new_files_minute='$date_i'
							 WHERE directory_id=$get_current_directory_id") or die(mysqli_error($link));




		// Loop for new cases
		$filenames = "";
		if($get_current_directory_address_prefered_for_agent == "linux"){
			$dir = "$get_current_directory_address_linux";
		}
		else{
			$dir = "$get_current_directory_address_windows";
		}

		if(!(is_dir("$dir"))){
			// Text output
			$text = "<span style=\"color:red;\">#5 <tt>$dir</tt> is not a dir</span>";
			$text_mysql = quote_smart($link, $text);
			echo" &middot; $text ";
			mysqli_query($link, "INSERT INTO $t_edb_agent_log
			(agent_log_id, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
			or die(mysqli_error($link));
		}
		if ($handle = opendir($dir)) {
			while (false !== ($case_directory = readdir($handle))) {
				if ($case_directory === '.') continue;
				if ($case_directory === '..') continue;
	
				// Check if it exists
				$case_directory = output_html($case_directory);
				$inp_case_id_mysql = quote_smart($link, $case_directory);
				if(is_numeric($case_directory)){
					$query = "SELECT case_id, case_number FROM $t_edb_case_index WHERE case_number=$inp_case_id_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_current_case_id, $get_current_case_number) = $row;
					if($get_current_case_id == ""){
						// Fetch first status
						$query = "SELECT status_id, status_title FROM $t_edb_case_statuses WHERE status_weight=1";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_status_id, $get_status_title) = $row;
						$inp_status_title_mysql = quote_smart($link, $get_status_title);
	
						// Fetch first priority
						$query = "SELECT priority_id, priority_title FROM $t_edb_case_priorities WHERE priority_weight=1";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_priority_id, $get_priority_title) = $row;
						$inp_priority_title_mysql = quote_smart($link, $get_priority_title);				


						// District
						$inp_district_title_mysql = quote_smart($link, $get_current_directory_district_title);

						// Station
						$inp_station_title_mysql = quote_smart($link, $get_current_directory_station_title);

						// Get agent user
						$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_name='agent'";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_agent_user_id, $get_agent_user_email, $get_agent_user_name, $get_agent_user_alias, $get_agent_user_language, $get_agent_user_last_online, $get_agent_user_rank, $get_agent_user_login_tries) = $row;
						if($get_agent_user_id == ""){
							mysqli_query($link, "INSERT INTO $t_users 
							(user_id, user_email, user_name, user_alias, user_language, user_rank)  VALUES (NULL, 'agent@$configFromEmailSav', 'agent', 'agent', $l_mysql, 'admin')")
							or die(mysqli_error($link));

							$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_name='agent'";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_agent_user_id, $get_agent_user_email, $get_agent_user_name, $get_agent_user_alias, $get_agent_user_language, $get_agent_user_last_online, $get_agent_user_rank, $get_agent_user_login_tries) = $row;

							mysqli_query($link, "INSERT INTO $t_users_profile 
							(profile_id, profile_user_id, profile_first_name, profile_middle_name, profile_last_name)  VALUES (NULL, $get_agent_user_id, 'Agent', 'Milla', 'Kamilla')")
							or die(mysqli_error($link));
						}

						// My photo
						$query = "SELECT photo_id, photo_destination, photo_thumb_40, photo_thumb_50 FROM $t_users_profile_photo WHERE photo_user_id=$get_agent_user_id AND photo_profile_image='1'";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_agent_photo_id, $get_agent_photo_destination, $get_agent_photo_thumb_40, $get_agent_photo_thumb_50) = $row;

						// My Profile
						$query = "SELECT profile_id, profile_first_name, profile_middle_name, profile_last_name, profile_about FROM $t_users_profile WHERE profile_user_id=$get_agent_user_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_agent_profile_id, $get_agent_profile_first_name, $get_agent_profile_middle_name, $get_agent_profile_last_name, $get_agent_profile_about) = $row;

						$inp_agent_user_name_mysql = quote_smart($link, $get_agent_user_name);
						$inp_agent_user_alias_mysql = quote_smart($link, $get_agent_user_alias);
						$inp_agent_user_email_mysql = quote_smart($link, $get_agent_user_email);
						$inp_agent_user_rank_mysql = quote_smart($link, $get_agent_user_rank);

						$inp_agent_user_image_path = "_uploads/users/images/$get_agent_user_id";
						$inp_agent_user_image_path_mysql = quote_smart($link, $inp_agent_user_image_path);

						$inp_agent_user_image_file_mysql = quote_smart($link, $get_agent_photo_destination);

						$inp_agent_user_image_thumb_a_mysql = quote_smart($link, $get_agent_photo_thumb_40);
						$inp_agent_user_image_thumb_b_mysql = quote_smart($link, $get_agent_photo_thumb_50);

						$inp_agent_user_first_name_mysql = quote_smart($link, $get_agent_profile_first_name);
						$inp_agent_user_middle_name_mysql = quote_smart($link, $get_agent_profile_middle_name);
						$inp_agent_user_last_name_mysql = quote_smart($link, $get_agent_profile_last_name);

						// Case dir Linux, Windows and folder name
						$inp_case_path_windows = $get_current_directory_address_windows . "\\" . $case_directory;
						$inp_case_path_windows_mysql = quote_smart($link, $inp_case_path_windows);

						$inp_case_path_linux = $get_current_directory_address_linux . "/" . $case_directory;
						$inp_case_path_linux_mysql = quote_smart($link, $inp_case_path_linux);

						$inp_case_path_folder_name = $case_directory;
						$inp_case_path_folder_name_mysql = quote_smart($link, $inp_case_path_folder_name);

						// Create case
						mysqli_query($link, "INSERT INTO $t_edb_case_index 
						(case_id, case_number, case_status_id, case_status_title, case_priority_id, 
						case_priority_title, case_district_id, case_district_title, case_station_id, case_station_title, 
						case_is_screened, case_physical_location, case_confirmed_by_human, case_human_rejected, case_path_windows,
						case_path_linux, case_path_folder_name, case_created_datetime, 
						case_created_date, case_created_time, case_created_date_saying, case_created_date_ddmmyy, case_created_date_ddmmyyyy, case_created_user_id, 
						case_created_user_name, case_created_user_alias, case_created_user_email, case_created_user_image_path, case_created_user_image_file, 
						case_created_user_image_thumb_40, case_created_user_image_thumb_50, case_created_user_first_name, case_created_user_middle_name, case_created_user_last_name, 
						case_updated_datetime, case_updated_date, case_updated_time, case_updated_date_saying, case_updated_date_ddmmyy, 
						case_updated_date_ddmmyyyy, case_updated_user_id, case_updated_user_name, case_updated_user_alias, case_updated_user_email, 
						case_updated_user_image_path, case_updated_user_image_file, case_updated_user_image_thumb_40, case_updated_user_image_thumb_50, case_updated_user_first_name, 
						case_updated_user_middle_name, case_updated_user_last_name,  case_is_closed)  
						VALUES 
						(NULL, $inp_case_id_mysql, $get_status_id, $inp_status_title_mysql, $get_priority_id,  
						$inp_priority_title_mysql, $get_current_directory_district_id, $inp_district_title_mysql, $get_current_directory_station_id, $inp_station_title_mysql,
						0, $inp_station_title_mysql, 0,  0, $inp_case_path_windows_mysql, 
						$inp_case_path_linux_mysql, $inp_case_path_folder_name_mysql, '$datetime', 
						'$date', '$time', '$date_saying', '$date_dmy', '$date_ddmmyyyy', $get_agent_user_id, 
						$inp_agent_user_name_mysql, $inp_agent_user_alias_mysql, $inp_agent_user_email_mysql, $inp_agent_user_image_path_mysql, $inp_agent_user_image_file_mysql, 
						$inp_agent_user_image_thumb_a_mysql, $inp_agent_user_image_thumb_b_mysql, $inp_agent_user_first_name_mysql, $inp_agent_user_middle_name_mysql, $inp_agent_user_last_name_mysql, 
						'$datetime', '$date', '$time', '$date_saying', '$date_dmy', '$date_ddmmyyyy', $get_agent_user_id, 
						$inp_agent_user_name_mysql, $inp_agent_user_alias_mysql, $inp_agent_user_email_mysql, $inp_agent_user_image_path_mysql, $inp_agent_user_image_file_mysql, 
						$inp_agent_user_image_thumb_a_mysql, $inp_agent_user_image_thumb_b_mysql, $inp_agent_user_first_name_mysql, $inp_agent_user_middle_name_mysql, $inp_agent_user_last_name_mysql, 
						0)")
						or die(mysqli_error($link));

						// Get ID
						$query = "SELECT case_id, case_number FROM $t_edb_case_index WHERE case_created_datetime='$datetime' AND case_created_user_id=$get_agent_user_id ORDER BY case_id DESC LIMIT 0,1";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_case_id, $get_case_number) = $row;

						

						// Text output
						$text = "<span>#6 Created case <tt>$case_directory</tt> from searching in $dir. Case ID = $get_case_id.</span>";
						$text_mysql = quote_smart($link, $text);
						echo" &middot; $text ";
						mysqli_query($link, "INSERT INTO $t_edb_agent_log
						(agent_log_id, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
						or die(mysqli_error($link));

						// Add to stats
					
						// 1) Statistics Index :: District
						$year = date("Y");
						$month = date("m");
						$month_saying = date("M");
						$query = "SELECT stats_id, stats_year, stats_month, stats_month_saying, stats_district_id, stats_station_id, stats_user_id, stats_cases_created, stats_cases_closed FROM $t_edb_stats_index WHERE stats_year=$year AND stats_month=$month AND stats_district_id=$get_current_directory_district_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_stats_id, $get_stats_year, $get_stats_month, $get_stats_month_saying, $get_stats_district_id, $get_stats_station_id, $get_stats_user_id, $get_stats_cases_created, $get_stats_cases_closed) = $row;
						if($get_stats_id == ""){
							mysqli_query($link, "INSERT INTO $t_edb_stats_index 
							(stats_id, stats_year, stats_month, stats_month_saying, stats_district_id, stats_station_id, stats_user_id, stats_cases_created, stats_cases_closed) 
							VALUES 
							(NULL, $year, $month, '$month_saying', $get_current_directory_district_id, NULL, NULL, 1, 0)")
							or die(mysqli_error($link));
						}
						else{
							$inp_stats_cases_created = $get_stats_cases_created+1;
							$result_update = mysqli_query($link, "UPDATE $t_edb_stats_index SET stats_cases_created=$inp_stats_cases_created WHERE stats_id=$get_stats_id");
						}

						// 2) Statistics Index :: Station
						$query = "SELECT stats_id, stats_year, stats_month, stats_month_saying, stats_district_id, stats_station_id, stats_user_id, stats_cases_created, stats_cases_closed FROM $t_edb_stats_index WHERE stats_year=$year AND stats_month=$month AND stats_station_id=$get_current_directory_station_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_stats_id, $get_stats_year, $get_stats_month, $get_stats_month_saying, $get_stats_district_id, $get_stats_station_id, $get_stats_user_id, $get_stats_cases_created, $get_stats_cases_closed) = $row;
						if($get_stats_id == ""){
							mysqli_query($link, "INSERT INTO $t_edb_stats_index 
							(stats_id, stats_year, stats_month, stats_month_saying, stats_district_id, stats_station_id, stats_user_id, stats_cases_created, stats_cases_closed) 
							VALUES 
							(NULL, $year, $month, '$month_saying', NULL, $get_current_directory_station_id, NULL, 1, 0)")
							or die(mysqli_error($link));
						}
						else{
							$inp_stats_cases_created = $get_stats_cases_created+1;
							$result_update = mysqli_query($link, "UPDATE $t_edb_stats_index SET stats_cases_created=$inp_stats_cases_created WHERE stats_id=$get_stats_id");
						}


						// 3) Statistics Index :: Person
						$query = "SELECT stats_id, stats_year, stats_month, stats_month_saying, stats_district_id, stats_station_id, stats_user_id, stats_cases_created, stats_cases_closed FROM $t_edb_stats_index WHERE stats_year=$year AND stats_month=$month AND stats_user_id=$my_user_id_mysql";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_stats_id, $get_stats_year, $get_stats_month, $get_stats_month_saying, $get_stats_district_id, $get_stats_station_id, $get_stats_user_id, $get_stats_cases_created, $get_stats_cases_closed) = $row;
						if($get_stats_id == ""){
							mysqli_query($link, "INSERT INTO $t_edb_stats_index 
							(stats_id, stats_year, stats_month, stats_month_saying, stats_district_id, stats_station_id, stats_user_id, stats_cases_created, stats_cases_closed) 
							VALUES 
							(NULL, $year, $month, '$month_saying', NULL, NULL, $my_user_id_mysql, 1, 0)")
							or die(mysqli_error($link));
						}
						else{
							$inp_stats_cases_created = $get_stats_cases_created+1;
							$result_update = mysqli_query($link, "UPDATE $t_edb_stats_index SET stats_cases_created=$inp_stats_cases_created WHERE stats_id=$get_stats_id");
						}

						// 4) Statistics Case Priorities :: District
						$query = "SELECT stats_case_priority_id, stats_case_priority_year, stats_case_priority_month, stats_case_priority_district_id, stats_case_priority_station_id, stats_case_priority_user_id, stats_case_priority_priority_id, stats_case_priority_priority_title, stats_case_priority_counter FROM $t_edb_stats_case_priorites WHERE stats_case_priority_year=$year AND stats_case_priority_month=$month AND stats_case_priority_district_id=$get_current_directory_district_id AND stats_case_priority_priority_id=$get_priority_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_stats_case_priority_id, $get_stats_case_priority_year, $get_stats_case_priority_month, $get_stats_case_priority_district_id, $get_stats_case_priority_station_id, $get_stats_case_priority_user_id, $get_stats_case_priority_priority_id, $get_stats_case_priority_priority_title, $get_stats_case_priority_counter) = $row;
						if($get_stats_case_priority_id == ""){
							mysqli_query($link, "INSERT INTO $t_edb_stats_case_priorites
							(stats_case_priority_id, stats_case_priority_year, stats_case_priority_month, stats_case_priority_district_id, stats_case_priority_station_id, stats_case_priority_user_id, stats_case_priority_priority_id, stats_case_priority_priority_title, stats_case_priority_counter) 
							VALUES 
							(NULL, $year, $month, $get_current_directory_district_id, NULL, NULL, $get_priority_id, $inp_priority_title_mysql, 1)")
							or die(mysqli_error($link));
						}
						else{
							$inp_stats_case_priority_counter = $get_stats_case_priority_counter+1;
							$result_update = mysqli_query($link, "UPDATE $t_edb_stats_case_priorites SET stats_case_priority_counter=$inp_stats_case_priority_counter WHERE stats_case_priority_id=$get_stats_case_priority_id");
						}

						// 5) Statistics Case Priorities :: Station
						$query = "SELECT stats_case_priority_id, stats_case_priority_year, stats_case_priority_month, stats_case_priority_district_id, stats_case_priority_station_id, stats_case_priority_user_id, stats_case_priority_priority_id, stats_case_priority_priority_title, stats_case_priority_counter FROM $t_edb_stats_case_priorites WHERE stats_case_priority_year=$year AND stats_case_priority_month=$month AND stats_case_priority_station_id=$get_current_directory_station_id AND stats_case_priority_priority_id=$get_priority_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_stats_case_priority_id, $get_stats_case_priority_year, $get_stats_case_priority_month, $get_stats_case_priority_district_id, $get_stats_case_priority_station_id, $get_stats_case_priority_user_id, $get_stats_case_priority_priority_id, $get_stats_case_priority_priority_title, $get_stats_case_priority_counter) = $row;
						if($get_stats_case_priority_id == ""){
							mysqli_query($link, "INSERT INTO $t_edb_stats_case_priorites
							(stats_case_priority_id, stats_case_priority_year, stats_case_priority_month, stats_case_priority_district_id, stats_case_priority_station_id, stats_case_priority_user_id, stats_case_priority_priority_id, stats_case_priority_priority_title, stats_case_priority_counter) 
							VALUES 
							(NULL, $year, $month, NULL, $get_current_directory_station_id, NULL, $get_priority_id, $inp_priority_title_mysql, 1)")
							or die(mysqli_error($link));
						}
						else{
							$inp_stats_case_priority_counter = $get_stats_case_priority_counter+1;
							$result_update = mysqli_query($link, "UPDATE $t_edb_stats_case_priorites SET stats_case_priority_counter=$inp_stats_case_priority_counter WHERE stats_case_priority_id=$get_stats_case_priority_id");
						}

						// 6) Statistics Case Priorities :: Person
						$query = "SELECT stats_case_priority_id, stats_case_priority_year, stats_case_priority_month, stats_case_priority_district_id, stats_case_priority_station_id, stats_case_priority_user_id, stats_case_priority_priority_id, stats_case_priority_priority_title, stats_case_priority_counter FROM $t_edb_stats_case_priorites WHERE stats_case_priority_year=$year AND stats_case_priority_month=$month AND stats_case_priority_user_id=$get_agent_user_id AND stats_case_priority_priority_id=$get_priority_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_stats_case_priority_id, $get_stats_case_priority_year, $get_stats_case_priority_month, $get_stats_case_priority_district_id, $get_stats_case_priority_station_id, $get_stats_case_priority_user_id, $get_stats_case_priority_priority_id, $get_stats_case_priority_priority_title, $get_stats_case_priority_counter) = $row;
						if($get_stats_case_priority_id == ""){
							mysqli_query($link, "INSERT INTO $t_edb_stats_case_priorites
							(stats_case_priority_id, stats_case_priority_year, stats_case_priority_month, stats_case_priority_district_id, stats_case_priority_station_id, stats_case_priority_user_id, stats_case_priority_priority_id, stats_case_priority_priority_title, stats_case_priority_counter) 
							VALUES 
							(NULL, $year, $month, NULL, NULL, $get_agent_user_id, $get_priority_id, $inp_priority_title_mysql, 1)")
							or die(mysqli_error($link));
						}
						else{
							$inp_stats_case_priority_counter = $get_stats_case_priority_counter+1;
							$result_update = mysqli_query($link, "UPDATE $t_edb_stats_case_priorites SET stats_case_priority_counter=$inp_stats_case_priority_counter WHERE stats_case_priority_id=$get_stats_case_priority_id");
						}


						// Automated tasks
						
						// Human tasks
						$query = "SELECT new_case_id, new_case_title, new_case_priority_id, new_case_priority_title, new_case_deadline_days FROM $t_edb_human_tasks_on_new_case ORDER BY new_case_priority_id ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_new_case_id, $get_new_case_title, $get_new_case_priority_id, $get_new_case_priority_title, $get_new_case_deadline_days) = $row;
							
							// Deadline 1 week
							$inp_deadline_day   = date("d", strtotime("+$get_new_case_deadline_days day"));
							$inp_deadline_month = date("m", strtotime("+$get_new_case_deadline_days day"));
							$inp_deadline_year  = date("Y", strtotime("+$get_new_case_deadline_days day"));
		
							$inp_deadline_date = $inp_deadline_year . "-" . $inp_deadline_month . "-" . $inp_deadline_day;
							$inp_deadline_date_mysql = quote_smart($link, $inp_deadline_date);

							$inp_deadline_time = strtotime($inp_deadline_date);
							$inp_deadline_time_mysql = quote_smart($link, $inp_deadline_time);


							$l_month_array[0] = "";
							$l_month_array[1] = "$l_month_january";
							$l_month_array[2] = "$l_month_february";
							$l_month_array[3] = "$l_month_march";
							$l_month_array[4] = "$l_month_april";
							$l_month_array[5] = "$l_month_may";
							$l_month_array[6] = "$l_month_june";
							$l_month_array[7] = "$l_month_juli";
							$l_month_array[8] = "$l_month_august";
							$l_month_array[9] = "$l_month_september";
							$l_month_array[10] = "$l_month_october";
							$l_month_array[11] = "$l_month_november";
							$l_month_array[12] = "$l_month_december";
							$inp_deadline_day_saying = str_replace("0", "", $inp_deadline_day);
							$inp_deadline_month_saying = str_replace("0", "", $inp_deadline_month);
				
							$inp_deadline_date_saying  = $inp_deadline_day . ". " . $l_month_array[$inp_deadline_month_saying] . " " . $inp_deadline_year;
							$inp_deadline_date_saying_mysql = quote_smart($link, $inp_deadline_date_saying);

							$inp_deadline_date_ddmmyy = $inp_deadline_day . "." . $inp_deadline_month . "." . substr($inp_deadline_year,2,2);
							$inp_deadline_date_ddmmyy_mysql = quote_smart($link, $inp_deadline_date_ddmmyy);

							$inp_deadline_date_ddmmyyyy = $inp_deadline_day . "." . $inp_deadline_month . "." . $inp_deadline_year;
							$inp_deadline_date_ddmmyyyy_mysql = quote_smart($link, $inp_deadline_date_ddmmyyyy);

							// Deadline week
							$inp_deadline_week = date("W", $inp_deadline_time);
							$inp_deadline_week_mysql = quote_smart($link, $inp_deadline_week);

							$inp_deadline_year = date("Y", $inp_deadline_time);
							$inp_deadline_year_mysql = quote_smart($link, $inp_deadline_year);

							// Priority
							$inp_new_case_priority_title_mysql = quote_smart($link, $get_new_case_priority_title);


							// Text
							$inp_text_mysql = quote_smart($link, $get_new_case_title);
	


							// Insert
							mysqli_query($link, "INSERT INTO $t_edb_case_index_human_tasks
							(human_task_id, human_task_case_id, human_task_case_number, human_task_evidence_record_id, human_task_evidence_item_id, 
							human_task_district_id,	human_task_district_title, human_task_station_id, human_task_station_title, human_task_text, 
							human_task_priority_id, human_task_priority_title, human_task_created_datetime, human_task_created_time, human_task_created_date_saying, 
							human_task_created_date_ddmmyy, human_task_created_date_ddmmyyyy, human_task_deadline_date, human_task_deadline_time, human_task_deadline_date_saying, 
							human_task_deadline_date_ddmmyy, human_task_deadline_date_ddmmyyyy, human_task_deadline_week, human_task_deadline_year, human_task_sent_deadline_notification, human_task_is_finished, 
							human_task_created_by_user_id, human_task_created_by_user_rank, human_task_created_by_user_name, human_task_created_by_user_alias, human_task_created_by_user_email, 
							human_task_created_by_user_image_path, human_task_created_by_user_image_file, human_task_created_by_user_image_thumb_40, human_task_created_by_user_image_thumb_50, 
							human_task_created_by_user_first_name, human_task_created_by_user_middle_name, human_task_created_by_user_last_name, human_task_responsible_user_id, human_task_responsible_user_name, 
							human_task_responsible_user_alias, human_task_responsible_user_email, human_task_responsible_user_image_path, human_task_responsible_user_image_file, human_task_responsible_user_image_thumb_40, 
							human_task_responsible_user_image_thumb_50, human_task_responsible_user_first_name, human_task_responsible_user_middle_name, human_task_responsible_user_last_name) 
							VALUES 
							(NULL, $get_case_id, $get_case_number, '0', '0', 
							$get_current_directory_district_id, $inp_district_title_mysql, $get_current_directory_station_id, $inp_station_title_mysql, $inp_text_mysql, $get_new_case_priority_id,
							$inp_new_case_priority_title_mysql, 
							'$datetime', '$time', '$date_saying', '$date_dmy', '$date_ddmmyyyy', $inp_deadline_date_mysql,
							$inp_deadline_time_mysql, $inp_deadline_date_saying_mysql, $inp_deadline_date_ddmmyy_mysql, $inp_deadline_date_ddmmyyyy_mysql, $inp_deadline_week_mysql, $inp_deadline_year_mysql, '0', '0', '$get_agent_user_id',
							$inp_agent_user_rank_mysql, 
							$inp_agent_user_name_mysql, $inp_agent_user_alias_mysql, $inp_agent_user_email_mysql, $inp_agent_user_image_path_mysql, $inp_agent_user_image_file_mysql, $inp_agent_user_image_thumb_a_mysql, $inp_agent_user_image_thumb_b_mysql, $inp_agent_user_first_name_mysql, $inp_agent_user_middle_name_mysql, $inp_agent_user_last_name_mysql,
							'$get_agent_user_id',
							$inp_agent_user_name_mysql, $inp_agent_user_alias_mysql, $inp_agent_user_email_mysql, $inp_agent_user_image_path_mysql, $inp_agent_user_image_file_mysql, $inp_agent_user_image_thumb_a_mysql, $inp_agent_user_image_thumb_b_mysql, $inp_agent_user_first_name_mysql, $inp_agent_user_middle_name_mysql, $inp_agent_user_last_name_mysql)")
							or die(mysqli_error($link));

						}

						

						// Review titles
						$query = "SELECT title_id, title_name, title_weight, title_colspan, title_headcell_text_color, title_headcell_bg_color, title_headcell_border_color_edge, title_headcell_border_color_center, title_bodycell_text_color, title_bodycell_bg_color, title_bodycell_border_color_edge, title_bodycell_border_color_center, title_subcell_text_color, title_subcell_bg_color, title_subcell_border_color_edge, title_subcell_border_color_center FROM $t_edb_review_matrix_titles ORDER BY title_weight ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_title_id, $get_title_name, $get_title_weight, $get_title_colspan, $get_title_headcell_text_color, $get_title_headcell_bg_color, $get_title_headcell_border_color_edge, $get_title_headcell_border_color_center, $get_title_bodycell_text_color, $get_title_bodycell_bg_color, $get_title_bodycell_border_color_edge, $get_title_bodycell_border_color_center, $get_title_subcell_text_color, $get_title_subcell_bg_color, $get_title_subcell_border_color_edge, $get_title_subcell_border_color_center) = $row;
							
							$inp_title_name_mysql = quote_smart($link, $get_title_name);
							$inp_title_weight_mysql = quote_smart($link, $get_title_weight);
							$inp_title_colspan_mysql = quote_smart($link, $get_title_colspan);

							$inp_title_headcell_text_color_mysql = quote_smart($link, $get_title_headcell_text_color);
							$inp_title_headcell_bg_color_mysql = quote_smart($link, $get_title_headcell_bg_color);
							$inp_title_headcell_border_color_edge_mysql = quote_smart($link, $get_title_headcell_border_color_edge);
							$inp_title_headcell_border_color_center_mysql = quote_smart($link, $get_title_headcell_border_color_center);

							$inp_title_bodycell_text_color_mysql = quote_smart($link, $get_title_bodycell_text_color);
							$inp_title_bodycell_bg_color_mysql = quote_smart($link, $get_title_bodycell_bg_color);
							$inp_title_bodycell_border_color_edge_mysql = quote_smart($link, $get_title_bodycell_border_color_edge);
							$inp_title_bodycell_border_color_center_mysql = quote_smart($link, $get_title_bodycell_border_color_center);

							$inp_title_subcell_text_color_mysql = quote_smart($link, $get_title_subcell_text_color);
							$inp_title_subcell_bg_color_mysql = quote_smart($link, $get_title_subcell_bg_color);
							$inp_title_subcell_border_color_edge_mysql = quote_smart($link, $get_title_subcell_border_color_edge);
							$inp_title_subcell_border_color_center_mysql = quote_smart($link, $get_title_subcell_border_color_center);

			
							// Insert
							mysqli_query($link, "INSERT INTO $t_edb_case_index_review_matrix_titles
							(title_id, title_case_id, title_name, title_weight, title_colspan, title_headcell_text_color, title_headcell_bg_color, title_headcell_border_color_edge, title_headcell_border_color_center, title_bodycell_text_color, title_bodycell_bg_color, title_bodycell_border_color_edge, title_bodycell_border_color_center, title_subcell_text_color, title_subcell_bg_color, title_subcell_border_color_edge, title_subcell_border_color_center) 
							VALUES 
							(NULL, $get_case_id, $inp_title_name_mysql, $inp_title_weight_mysql, $inp_title_colspan_mysql, $inp_title_headcell_text_color_mysql, $inp_title_headcell_bg_color_mysql, $inp_title_headcell_border_color_edge_mysql, $inp_title_headcell_border_color_center_mysql, $inp_title_bodycell_text_color_mysql, $inp_title_bodycell_bg_color_mysql, $inp_title_bodycell_border_color_edge_mysql, $inp_title_bodycell_border_color_center_mysql, $inp_title_subcell_text_color_mysql, $inp_title_subcell_bg_color_mysql, $inp_title_subcell_border_color_edge_mysql, $inp_title_subcell_border_color_center_mysql)")
							or die(mysqli_error($link));
	
							// Get this title ID
							$query_title = "SELECT title_id, title_case_id, title_name FROM $t_edb_case_index_review_matrix_titles WHERE title_case_id=$get_case_id AND title_name=$inp_title_name_mysql";
							$result_title = mysqli_query($link, $query_title);
							$row_titles = mysqli_fetch_row($result_title);
							list($get_case_index_review_matrix_title_id, $get_case_index_review_matrix_title_case_id, $get_case_index_review_matrix_title_name) = $row_titles;


							// Review fields
							$query_fields = "SELECT field_id, field_name, field_title_id, field_title_name, field_weight, field_type, field_size, field_alt_a, field_alt_b, field_alt_c, field_alt_d, field_alt_e, field_alt_f, field_alt_g, field_alt_h, field_alt_i, field_alt_j, field_alt_k, field_alt_l, field_alt_m FROM $t_edb_review_matrix_fields WHERE field_title_id=$get_title_id ORDER BY field_title_id, field_weight ASC";
							$result_fields = mysqli_query($link, $query_fields);
							while($row_fields = mysqli_fetch_row($result_fields)) {
								list($get_field_id, $get_field_name, $get_field_title_id, $get_field_title_name, $get_field_weight, $get_field_type, $get_field_size, $get_field_alt_a, $get_field_alt_b, $get_field_alt_c, $get_field_alt_d, $get_field_alt_e, $get_field_alt_f, $get_field_alt_g, $get_field_alt_h, $get_field_alt_i, $get_field_alt_j, $get_field_alt_k, $get_field_alt_l, $get_field_alt_m) = $row_fields;
							


								$inp_field_name_mysql = quote_smart($link, $get_field_name);
								$inp_field_title_id_mysql = quote_smart($link, $get_case_index_review_matrix_title_id);
								$inp_field_title_name_mysql = quote_smart($link, $get_case_index_review_matrix_title_name);
								$inp_field_weight_mysql = quote_smart($link, $get_field_weight);
								$inp_field_type_mysql = quote_smart($link, $get_field_type);
								$inp_field_size_mysql = quote_smart($link, $get_field_size);
								$inp_field_alt_a_mysql = quote_smart($link, $get_field_alt_a);
								$inp_field_alt_b_mysql = quote_smart($link, $get_field_alt_b);
								$inp_field_alt_c_mysql = quote_smart($link, $get_field_alt_c);
								$inp_field_alt_d_mysql = quote_smart($link, $get_field_alt_d);
								$inp_field_alt_e_mysql = quote_smart($link, $get_field_alt_e);
								$inp_field_alt_f_mysql = quote_smart($link, $get_field_alt_f);
								$inp_field_alt_g_mysql = quote_smart($link, $get_field_alt_g);
								$inp_field_alt_h_mysql = quote_smart($link, $get_field_alt_h);
								$inp_field_alt_i_mysql = quote_smart($link, $get_field_alt_i);
								$inp_field_alt_j_mysql = quote_smart($link, $get_field_alt_j);
								$inp_field_alt_k_mysql = quote_smart($link, $get_field_alt_k);
								$inp_field_alt_l_mysql = quote_smart($link, $get_field_alt_l);
								$inp_field_alt_m_mysql = quote_smart($link, $get_field_alt_m);


			
								// Insert
								mysqli_query($link, "INSERT INTO $t_edb_case_index_review_matrix_fields
								(field_id, field_case_id, field_name, field_title_id, field_title_name, field_weight, field_type, field_size, field_alt_a, field_alt_b, field_alt_c, field_alt_d, field_alt_e, field_alt_f, field_alt_g, field_alt_h, field_alt_i, field_alt_j, field_alt_k, field_alt_l, field_alt_m) 
								VALUES 
								(NULL, $get_case_id, $inp_field_name_mysql, $inp_field_title_id_mysql, $inp_field_title_name_mysql, $inp_field_weight_mysql, $inp_field_type_mysql, $inp_field_size_mysql, $inp_field_alt_a_mysql, $inp_field_alt_b_mysql, $inp_field_alt_c_mysql, $inp_field_alt_d_mysql, $inp_field_alt_e_mysql, $inp_field_alt_f_mysql, $inp_field_alt_g_mysql, $inp_field_alt_h_mysql, $inp_field_alt_i_mysql, $inp_field_alt_j_mysql, $inp_field_alt_k_mysql, $inp_field_alt_l_mysql, $inp_field_alt_m_mysql)")
								or die(mysqli_error($link));
	
							}

						}
						$text = "<span>#6 Created case index review matrix for case id $get_case_id.</span>";
						$text_mysql = quote_smart($link, $text);
						echo" &middot; $text ";
						mysqli_query($link, "INSERT INTO $t_edb_agent_log
						(agent_log_id, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
						or die(mysqli_error($link));

						/* Case doesnt get case code when agent creates it  */


					} // if($get_current_case_id == ""){
				} // is numeric case_directory
			} // while (false !== ($case_directory = readdir($handle))) {
		} // handle
	} // if($get_current_directory_id != ""){


	echo"
	</p>
	</div>
	";
	echo"</body>\n";
	echo"</html>";
} // logged in

?>