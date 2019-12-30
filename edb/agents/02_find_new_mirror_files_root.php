<?php 
/**
*
* File: edb/agents/02_find_new_mirror_files_root.php
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



/*- Debug - */
$debug = "0";

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


	
	// 2. Look for new mirror files in root of case dir
	// First open directory for station
	$query = "SELECT directory_id, directory_station_id, directory_station_title, directory_district_id, directory_district_title, directory_type, directory_address_linux, directory_address_windows, directory_address_prefered_for_agent, directory_last_checked_for_new_files_counter, directory_last_checked_for_new_files_time, directory_last_checked_for_new_files_hour, directory_last_checked_for_new_files_minute, directory_now_size_last_calculated_day, directory_now_size_last_calculated_hour, directory_now_size_last_calculated_minute, directory_now_size_mb, directory_now_size_gb, directory_available_size_mb, directory_available_size_gb, directory_available_size_percentage FROM $t_edb_stations_directories WHERE directory_type='mirror_files' ORDER BY directory_last_checked_for_new_files_counter ASC LIMIT 0,1";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_directory_id, $get_current_directory_station_id, $get_current_directory_station_title, $get_current_directory_district_id, $get_current_directory_district_title, $get_current_directory_type, $get_current_directory_address_linux, $get_current_directory_address_windows, $get_current_directory_address_prefered_for_agent, $get_current_directory_last_checked_for_new_files_counter, $get_current_directory_last_checked_for_new_files_time, $get_current_directory_last_checked_for_new_files_hour, $get_current_directory_last_checked_for_new_files_minute, $get_current_directory_now_size_last_calculated_day, $get_current_directory_now_size_last_calculated_hour, $get_current_directory_now_size_last_calculated_minute, $get_current_directory_now_size_mb, $get_current_directory_now_size_gb, $get_current_directory_available_size_mb, $get_current_directory_available_size_gb, $get_current_directory_available_size_percentage) = $row;


	echo"
	<div class=\"main\">
	<p><a href=\"agent_display_log.php?l=$l\" target=\"_top\">$l_agent 02</a> $get_current_directory_station_title $date_hi
	";

	if($get_current_directory_id != ""){


		$inp_directory_last_checked_for_new_files_counter = $get_current_directory_last_checked_for_new_files_counter+1;

		$result_update = mysqli_query($link, "UPDATE $t_edb_stations_directories SET 
							directory_last_checked_for_new_files_counter=$inp_directory_last_checked_for_new_files_counter,
							directory_last_checked_for_new_files_time='$time',
							directory_last_checked_for_new_files_hour='$date_h',
							directory_last_checked_for_new_files_minute='$date_i'
							 WHERE directory_id=$get_current_directory_id") or die(mysqli_error($link));



		// Find all cases that are not closed
		$query_cases = "SELECT case_id, case_number, case_title, case_path_windows, case_path_linux, case_path_folder_name FROM $t_edb_case_index WHERE case_station_id=$get_current_directory_station_id AND case_confirmed_by_human=1 AND case_human_rejected=0 AND case_is_closed=0";
		$result_cases = mysqli_query($link, $query_cases);
		while($row_cases = mysqli_fetch_row($result_cases)) {
			list($get_case_id, $get_case_number, $get_case_title, $get_case_path_windows, $get_case_path_linux, $get_case_path_folder_name) = $row_cases;

			// Fix case path
			if($get_case_path_windows == "" OR $get_case_path_linux == "" OR $get_case_path_folder_name == ""){
				// Update case path
				$inp_case_path_windows = "$get_current_directory_address_windows\\$get_case_number";
				$inp_case_path_windows_mysql = quote_smart($link, $inp_case_path_windows);

				$inp_case_path_linux = "$get_current_directory_address_linux/$get_case_number";
				$inp_case_path_linux_mysql = quote_smart($link, $inp_case_path_linux);
				
				$inp_case_path_folder_name_mysql = quote_smart($link, $get_case_number);

				$result_update = mysqli_query($link, "UPDATE $t_edb_case_index SET case_path_windows=$inp_case_path_windows_mysql, case_path_linux=$inp_case_path_linux_mysql, case_path_folder_name=$inp_case_path_folder_name_mysql  WHERE case_id=$get_case_id") or die(mysqli_error($link));

				$text = "#1 <span style=\"color:orange;\">Case number $get_case_number: Updated paths. <b>Windows:</b> $inp_case_path_windows <b>Linux:</b> $inp_case_path_linux <b>Folder:</b> $get_case_number</span>";
				$text_mysql = quote_smart($link, $text);
				echo" &middot; $text ";
				mysqli_query($link, "INSERT INTO $t_edb_agent_log
				(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '02_find_new_mirror_files_root.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
				or die(mysqli_error($link));
				die;
			}

			// Print
			if($debug == "1"){ $time = time(); echo"<br /><hr / ><br />$time Case ID $get_case_id - Case no $get_case_number:<br />\n"; }

			// Open case dir
			if($get_current_directory_address_prefered_for_agent == "linux"){
				$case_dir = "$get_case_path_linux";
			}
			else{
				$case_dir = "$get_case_path_windows";
			}

			if(is_dir($case_dir)){
				if($debug == "1"){ $time = time(); echo"<br />$time &nbsp; is dir $case_dir<br />\n"; }
				if ($handle = opendir($case_dir)) {
					while (false !== ($files = readdir($handle))) {
						if ($files === '.') continue;
						if ($files == '..') continue;
	
						// We are now here: files = /home/datakrim/share_test/speilfiler_haugesund_test/8040494/8040494_2019_0494_206_1_LenovoG50
						// Loop trough evidence directory for sub folders
						if($get_current_directory_address_prefered_for_agent == "linux"){
							$evidence_file_full_path = "$get_case_path_linux/$files";
						}
						else{
							$evidence_file_full_path = "$get_case_path_windows\\$files";
						}

						if(!(is_dir($evidence_file_full_path))){
				
							$array = explode("_", $files);
							$array_size = sizeof($array);
	
							
							if($array_size > 4){
								// echo"Level b files: $level_b_file<br />";
								$ext = get_extension($files); // $level_b_file = 8374123_2019_3434_206_16_hp_i3_laptop.001
								$case_number = $array[0];
								$year = $array[1];
								$journal = $array[2];
								$district_number = $array[3];
								$item_numeric_serial_number = str_replace(".$ext", "", $array[4]); // Somehow we get a name that is "14900476_2019_7213_206_1.001.txt", which has double ext
									
								$extra_ext = get_extension($item_numeric_serial_number);
								if($extra_ext != ""){
									$item_numeric_serial_number = str_replace(".$extra_ext", "", $item_numeric_serial_number);
								}
	
								if($array_size > 5){
									// Title should be everything that is after the array 4. Ex 14950293_2019_7786_206_1_Daniel_HANSEN title should be "Daniel HANSEN"
									$title = $array[5];
									for($i=6;$i<$array_size;$i++){
										$title = $title . " " . $array[$i]; 
									}
								}
								else{
									$title = "";
								}
								// echo"Now scanning $case_number-$year-$journal-$district_number-$item_numeric_serial_number-$title at $level_c_dir<br />";
										
								if(is_numeric($case_number) && $case_number == "$get_case_number" && is_numeric($year) && is_numeric($journal) && is_numeric($district_number) && is_numeric($item_numeric_serial_number)){

									$year_mysql = quote_smart($link, $year);
									$journal_mysql = quote_smart($link, $journal);
									$district_number_mysql = quote_smart($link, $district_number);
									$item_numeric_serial_number_mysql = quote_smart($link, $item_numeric_serial_number);
									$title_mysql = quote_smart($link, $title);

									// Find that district
									$query = "SELECT district_id, district_number, district_title FROM $t_edb_districts_index WHERE district_number=$district_number_mysql";
									$result = mysqli_query($link, $query);
									$row = mysqli_fetch_row($result);
									list($get_district_id, $get_district_number, $get_district_title) = $row;
									if($get_district_id == ""){
										$text = "<span style=\"color:red;\">#7 District not found ($district_number) for file <em>$files</em>. Please fix file naming. It should be case_year_journal_district_item_title.ext.";
										$text = $text . "<b>case_number:</b> $case_number ";
										$text = $text . "<b>year:</b> $year ";
										$text = $text . "<b>journal:</b> $journal ";
										$text = $text . "<b>district_number:</b> $district_number ";
										$text = $text . "<b>item_numeric_serial_number:</b> $item_numeric_serial_number ";
										$text = $text . "</span>";
										$text_mysql = quote_smart($link, $text);
										echo" &middot; $text ";
										mysqli_query($link, "INSERT INTO $t_edb_agent_log
										(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '02_find_new_mirror_files_root.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
										or die(mysqli_error($link));
									}
									else{
										$inp_district_title_mysql = quote_smart($link, $get_district_title);

										// Find that record
										$query_record = "SELECT record_id, record_case_id, record_seized_year, record_seized_journal, record_seized_district_id, record_seized_district_number, record_seized_district_title, record_notes, record_created_datetime, record_created_time, record_created_date_saying, record_created_date_ddmmyy FROM $t_edb_case_index_evidence_records WHERE record_seized_year=$year_mysql AND record_seized_journal=$journal_mysql AND record_seized_district_id=$get_district_id AND record_case_id=$get_case_id";
										$result_record = mysqli_query($link, $query_record);
										$row_record = mysqli_fetch_row($result_record);
										list($get_current_record_id, $get_current_record_case_id, $get_current_record_seized_year, $get_current_record_seized_journal, $get_current_record_seized_district_id, $get_current_record_seized_district_number, $get_current_record_seized_district_title, $get_current_record_notes, $get_current_record_created_datetime, $get_current_record_created_time, $get_current_record_created_date_saying, $get_current_record_created_date_ddmmyy) = $row_record;
	
										if($get_current_record_id == ""){
											// Insert it
											mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_records
											(record_id, record_case_id, record_seized_year, record_seized_journal, record_seized_district_id, 
											record_seized_district_number, record_seized_district_title, record_confirmed_by_human, record_human_rejected, record_notes, record_created_datetime, 
											record_created_date, record_created_time, record_created_date_saying, record_created_date_ddmmyy) 
											VALUES 
											(NULL, $get_case_id, $year_mysql, $journal_mysql, $get_district_id,
											$district_number_mysql, $inp_district_title_mysql, 0, 0, $title_mysql, '$datetime',
											'$date', '$time', '$date_saying', '$date_dmy')")
											or die(mysqli_error($link));
	
											$query = "SELECT record_id, record_case_id, record_seized_year, record_seized_journal, record_seized_district_id, record_seized_district_number, record_seized_district_title, record_notes, record_created_datetime, record_created_time, record_created_date_saying, record_created_date_ddmmyy FROM $t_edb_case_index_evidence_records WHERE record_seized_year=$year_mysql AND record_seized_journal=$journal_mysql AND record_seized_district_id=$get_district_id AND record_case_id=$get_case_id";
											$result = mysqli_query($link, $query);
											$row = mysqli_fetch_row($result);
											list($get_current_record_id, $get_current_record_case_id, $get_current_record_seized_year, $get_current_record_seized_journal, $get_current_record_seized_district_id, $get_current_record_seized_district_number, $get_current_record_seized_district_title, $get_current_record_notes, $get_current_record_created_datetime, $get_current_record_created_time, $get_current_record_created_date_saying, $get_current_record_created_date_ddmmyy) = $row;

											// Log
											/*
											$text = "#3 Created record from scanning mirror folders. <b>Case number:</b> $get_current_case_number&middot;";
											$text = $text  . "<b>Year:</b> $year &middot;";
											$text = $text  . "<b>Journal:</b> $journal &middot;";
											$text = $text  . "<b>District:</b> $district_number &middot;";
											$text = $text  . "<b>Item :</b> $item_numeric_serial_number &middot;";
											$text = $text  . "<b>Title:</b> $title";	
											$text_mysql = quote_smart($link, $text);
											echo" &middot; $text ";
											mysqli_query($link, "INSERT INTO $t_edb_agent_log
											(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '02_find_new_mirror_files_root.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
											or die(mysqli_error($link));
											*/
										}
										if($get_current_record_id != ""){
								
											// Does the item exists?
											$item_numeric_serial_number_mysql = quote_smart($link, $item_numeric_serial_number);

											$query_item = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title FROM $t_edb_case_index_evidence_items WHERE item_case_id=$get_case_id AND item_record_id=$get_current_record_id AND item_numeric_serial_number=$item_numeric_serial_number_mysql";
											$result_item = mysqli_query($link, $query_item);
											$row_item = mysqli_fetch_row($result_item);
											list($get_current_item_id, $get_current_item_case_id, $get_current_item_record_id, $get_current_item_record_seized_year, $get_current_item_record_seized_journal, $get_current_item_record_seized_district_number, $get_current_item_numeric_serial_number, $get_current_item_title, $get_current_item_type_id, $get_current_item_type_title) = $row_item;
	
		
											if($get_current_item_id == ""){
												// Can we determine the item type? Look for $title
												$inp_item_type_id = "0";
												$inp_item_type_title = "";
												if($title != ""){
													$search_title = str_replace(" ", "_", $title);
													$query_it = "SELECT item_type_id, item_type_title, item_type_keywords FROM $t_edb_item_types";
													$result_it = mysqli_query($link, $query_it);
													while($row_it = mysqli_fetch_row($result_it)) {
														list($get_item_type_id, $get_item_type_title, $get_item_type_keywords) = $row_it;

														// Look for needle in haystack
														if($get_item_type_keywords != ""){
															$keywords_array = explode("\n", $get_item_type_keywords);
															for($i=0;$i<sizeof($keywords_array);$i++){
																$keyword = trim($keywords_array[$i]);
																$pos = strpos($search_title, $keyword);

																$text = "strpos($search_title, $keyword) -&gt; ";
																if ($pos === false) {
																	$text = $text  . "<span style=\"color:orange\">false</span>";
																	// echo "The string '$findme' was not found in the string '$mystring'";
																} else {
																	$text = $text  . "<span style=\"color:blue\">true</span>";
																	$inp_item_type_id = "$get_item_type_id";
																	$inp_item_type_title = "$get_item_type_title";
																}
																$text_mysql = quote_smart($link, $text);
																echo" &middot; $text ";
																mysqli_query($link, "INSERT INTO $t_edb_agent_log
																(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '03_find_new_mirror_files_sub.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
																or die(mysqli_error($link));
															} // for
														}
													}
												}
												$inp_item_type_title_mysql = quote_smart($link, $inp_item_type_title);

												// Insert it
												mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_items
												(item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, 
												item_record_seized_district_number, item_numeric_serial_number, item_title, item_parent_item_id, 
												item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy) 
												VALUES 
												(NULL, $get_case_id, $get_current_record_id, $get_current_record_seized_year, $get_current_record_seized_journal, 
												$get_current_record_seized_district_number, $item_numeric_serial_number_mysql, $title_mysql, 0, $inp_item_type_id, 
												$inp_item_type_title_mysql, 0, 0, '$datetime', '$date', '$time', '$date_saying', '$date_dmy')")
												or die(mysqli_error($link));
	
												$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title FROM $t_edb_case_index_evidence_items WHERE item_case_id=$get_case_id AND item_record_id=$get_current_record_id AND item_numeric_serial_number=$item_numeric_serial_number_mysql";
												$result = mysqli_query($link, $query);
												$row = mysqli_fetch_row($result);
												list($get_current_item_id, $get_current_item_case_id, $get_current_item_record_id, $get_current_item_record_seized_year, $get_current_item_record_seized_journal, $get_current_item_record_seized_district_number, $get_current_item_numeric_serial_number, $get_current_item_title, $get_current_item_type_id, $get_current_item_type_title) = $row;
	
												// Log
												$text = "#4 Created record and item from scanning mirror folders. <b>Case number:</b> $get_case_number &middot;";
												$text = $text  . "<b>Year:</b> $year &middot; ";
												$text = $text  . "<b>Journal:</b> $journal &middot; ";
												$text = $text  . "<b>District:</b> $district_number &middot; ";
												$text = $text  . "<b>Item :</b> $item_numeric_serial_number &middot; ";
												$text = $text  . "<b>Title:</b> $title &middot; ";
												$text = $text  . "<b>File:</b> $files &middot; ";
												$text = $text  . "<b>Ext:</b> $ext";
												$text_mysql = quote_smart($link, $text);
												echo" &middot; $text ";
												mysqli_query($link, "INSERT INTO $t_edb_agent_log
												(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '02_find_new_mirror_files_root.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
												or die(mysqli_error($link));

											} // create item

											if($get_current_item_id != ""){
												// The mirror file can be stored in 2 diffrent ways:
												// 1) Straight to the root: \\DPAHAUGEKONTOR3\Mirror_files_Haugesund_test\8040494\8040494_2019_0494_206_1_Lenovo_G50.000
												// 2) In a subfolder: \\DPAHAUGEKONTOR3\Mirror_files_Haugesund_test\8040494\8040494_2019_0494_206_1_Lenovo_G50\8040494_2019_0494_206_1_Lenovo_G50.000
													
												// Aquire file
												// We may want to use / on Linux and \ on Windows
												$inp_mirror_file_path_linux = $get_case_path_linux;
												$inp_mirror_file_path_linux = output_html($inp_mirror_file_path_linux);
												$inp_mirror_file_path_linux_mysql = quote_smart($link, $inp_mirror_file_path_linux);
													
												$inp_mirror_file_path_windows = $get_case_path_windows;
												$inp_mirror_file_path_windows = output_html($inp_mirror_file_path_windows);
												$inp_mirror_file_path_windows = str_replace("&#92", "\\", $inp_mirror_file_path_windows);
												$inp_mirror_file_path_windows_mysql = quote_smart($link, $inp_mirror_file_path_windows);
													
	
												$inp_mirror_file_file = "$files";
												$inp_mirror_file_file = output_html($inp_mirror_file_file);
												$inp_mirror_file_file_mysql = quote_smart($link, $inp_mirror_file_file);

												$inp_mirror_file_ext = output_html($ext);
												$inp_mirror_file_ext_mysql = quote_smart($link, $inp_mirror_file_ext);
	
												if($get_current_directory_address_prefered_for_agent == "linux"){
													$mirror_file_path = "$inp_mirror_file_path_linux";
												}
												else{
													$mirror_file_path = "$inp_mirror_file_path_windows";
												}

												/*
												$text = "#5 <b>inp_mirror_file_path_linux:</b> $inp_mirror_file_path_linux  &middot;";
												$text = $text  . "<b>inp_mirror_file_path_windows:</b> $inp_mirror_file_path_windows  &middot;";
												$text = $text  . "<b>inp_mirror_file_file:</b> $inp_mirror_file_file";
												$text_mysql = quote_smart($link, $text);
												echo" &middot; $text <br />"; 
												mysqli_query($link, "INSERT INTO $t_edb_agent_log
												(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '02_find_new_mirror_files_root.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
												or die(mysqli_error($link));
												*/

												$query = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_case_id=$get_current_item_case_id AND mirror_file_record_id=$get_current_item_record_id AND mirror_file_item_id=$get_current_item_id AND mirror_file_path_windows=$inp_mirror_file_path_windows_mysql AND mirror_file_file=$inp_mirror_file_file_mysql";
												$result = mysqli_query($link, $query);
												$row = mysqli_fetch_row($result);
												list($get_current_mirror_file_id, $get_current_mirror_file_case_id, $get_current_mirror_file_record_id, $get_current_mirror_file_item_id, $get_current_mirror_file_path_windows, $get_current_mirror_file_path_linux, $get_current_mirror_file_file, $get_current_mirror_file_ext, $get_current_mirror_file_type) = $row;
												if($get_current_mirror_file_id == ""){

														
													if($get_current_directory_address_prefered_for_agent == "linux"){
	 													$inp_mirror_file_type = mime_content_type("$inp_mirror_file_path_linux/$inp_mirror_file_file");

														// Log	
														/*
														$text = "#6 Linux Mime content type <b>inp_mirror_file_path_linux:</b> $inp_mirror_file_path_linux &middot; <b>inp_mirror_file_file:</b> $inp_mirror_file_file";
														$text = $text . "<b>mime_content_type(</b>$inp_mirror_file_path_linux/$inp_mirror_file_file<b>)</b>";
														$text_mysql = quote_smart($link, $text);
														echo"<br />$text ";
														mysqli_query($link, "INSERT INTO $t_edb_agent_log
														(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '02_find_new_mirror_files_root.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
														or die(mysqli_error($link));
														 */
														

													}
													else{
	 													$inp_mirror_file_type = mime_content_type("$inp_mirror_file_path_windows\\$inp_mirror_file_file");

														/* // Log
														$text = "#7 Windows Mime content type <b>inp_mirror_file_path_windows:</b> $inp_mirror_file_path_windows &middot; <b>inp_mirror_file_file:</b> $inp_mirror_file_file";
														$text = $text . "<b>mime_content_type(</b>$inp_mirror_file_path_windows\\$inp_mirror_file_file<b>)</b> &middot; <b>Content type:</b> $inp_mirror_file_type";
														$text_mysql = quote_smart($link, $text);
														echo"<br />$text ";
														mysqli_query($link, "INSERT INTO $t_edb_agent_log
														(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '02_find_new_mirror_files_root.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
														or die(mysqli_error($link));
														
														*/
													}
													$inp_mirror_file_type = output_html($inp_mirror_file_type);
													$inp_mirror_file_type_mysql = quote_smart($link, $inp_mirror_file_type);
	
													$inp_mirror_file_created_datetime = date ("Y-m-d H:i:s", filemtime("$mirror_file_path/$inp_mirror_file_file"));
													$inp_mirror_file_created_time  = filemtime("$mirror_file_path/$inp_mirror_file_file");
													$inp_mirror_file_created_date_saying = date ("d. M y H:i", filemtime("$mirror_file_path/$inp_mirror_file_file"));
													$inp_mirror_file_created_date_ddmmyy = date ("d.m.y H:i", filemtime("$mirror_file_path/$inp_mirror_file_file"));


	
													mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_items_mirror_files
													(mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_confirmed_by_human, mirror_file_human_rejected, mirror_file_created_datetime, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_backup_disk, mirror_file_ready_for_automated_machine, mirror_file_ready_agent_tries_counter, mirror_file_comments) 
													VALUES 
													(NULL, $get_case_id, $get_current_item_record_id, $get_current_item_id, $inp_mirror_file_path_windows_mysql, $inp_mirror_file_path_linux_mysql, $inp_mirror_file_file_mysql, $inp_mirror_file_ext_mysql, $inp_mirror_file_type_mysql, 0, 0, '$inp_mirror_file_created_datetime', '$inp_mirror_file_created_time', '$inp_mirror_file_created_date_saying', '$inp_mirror_file_created_date_ddmmyy', '', 0, 0, '')")
													or die(mysqli_error($link));
															
													// Get mirror file ID
													$query_m = "SELECT mirror_file_id FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_case_id=$get_current_item_case_id AND mirror_file_record_id=$get_current_item_record_id AND mirror_file_item_id=$get_current_item_id AND mirror_file_path_windows=$inp_mirror_file_path_windows_mysql AND mirror_file_file=$inp_mirror_file_file_mysql";
													$result_m = mysqli_query($link, $query_m);
													$row_m = mysqli_fetch_row($result_m);
													list($get_current_mirror_file_id) = $row_m;
															
	
													$text = "#8 Found mirror file. <b>Case number:</b> $get_case_number &middot;";
													$text = $text  . "<b>Mirror file:</b> $mirror_file_path/$inp_mirror_file_file &middot;";
													$text = $text  . "<b>Mirror file ID:</b> $get_current_mirror_file_id";
													$text_mysql = quote_smart($link, $text);
													echo" &middot; $text ";
													mysqli_query($link, "INSERT INTO $t_edb_agent_log
													(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '02_find_new_mirror_files_root.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
													or die(mysqli_error($link));
													

													// Ping on
													$get_current_case_id = "$get_case_id";
													include("agents/02-03_find_new_mirror_files_ping_on.php");
												} // Mirror file doesnt exists in db

											} // curent item id
										} // record exists
									} // district found
								} // level c is numeric case number, year, journal, 
							} // level c array size over 4
						} // level c is not dir
					} //  if($get_current_case_id != ""){
				} // is numeric $level_a_files
			} // readdir level a
			else{

				$result_update = mysqli_query($link, "UPDATE $t_edb_case_index SET case_path_windows='', case_path_linux='', case_path_folder_name='' WHERE case_id=$get_case_id") or die(mysqli_error($link));

				$text = "<span style=\"color: red;\">#9 Case dir $case_dir is not a directory</span>";
				$text_mysql = quote_smart($link, $text);
				echo" &middot; $text ";
				mysqli_query($link, "INSERT INTO $t_edb_agent_log
				(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '02_find_new_mirror_files_root.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
				or die(mysqli_error($link));
				
			}
		} // while cases
	} // if($get_current_directory_id != ""){


	echo"
	</p>
	</div>
	";
	echo"</body>\n";
	echo"</html>";
} // logged in

?>