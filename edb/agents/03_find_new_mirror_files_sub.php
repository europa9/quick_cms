<?php 
/**
*
* File: edb/agents/03_find_new_mirror_files_sub.php
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
	<p><a href=\"agent_display_log.php?l=$l\" target=\"_top\">$l_agent 03</a> $date_hi
	";

	// This agent want to look for case folders -> evidence folders -> evidence files

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

		// Find all cases that are not closed
		$query_cases = "SELECT case_id, case_number, case_title FROM $t_edb_case_index WHERE case_station_id=$get_current_directory_station_id AND case_confirmed_by_human=1 AND case_human_rejected=0 AND case_is_closed=0";
		$result_cases = mysqli_query($link, $query_cases);
		while($row_cases = mysqli_fetch_row($result_cases)) {
			list($get_case_id, $get_case_number, $get_case_title) = $row_cases;


			if($get_current_directory_address_prefered_for_agent == "linux"){
				$dir = "$get_current_directory_address_linux/$get_case_number";
			}
			else{
				$dir = "$get_current_directory_address_windows\\$get_case_number";
			}
			if(is_dir($dir)){
				if ($handle = opendir($dir)) {
					while (false !== ($case_files_and_sub_directories = readdir($handle))) {
						if ($case_files_and_sub_directories === '.') continue;
						if ($case_files_and_sub_directories === '..') continue;
	
						// We are now here: $evidence_directory/$evidence_sub_directory = /home/datakrim/share_test/speilfiler_haugesund_test/8040494/8040494_2019_0494_206_1_LenovoG50
						// Loop trough evidence directory for sub folders
						if($get_current_directory_address_prefered_for_agent == "linux"){
							$evidence_files_sub_folder = "$get_current_directory_address_linux/$get_case_number/$case_files_and_sub_directories";
						}
						else{
							$evidence_files_sub_folder = "$get_current_directory_address_windows\\$get_case_number\\$case_files_and_sub_directories";
						}
						if(is_dir($evidence_files_sub_folder)){

							if ($handle_evidence_files_sub_folder = opendir($evidence_files_sub_folder)) {
								while (false !== ($evidence_file = readdir($handle_evidence_files_sub_folder))) {
									if ($evidence_file === '.') continue;
									if ($evidence_file === '..') continue;

									// Looping trough D:\Beslagsdb_test_Haugesund_speilfiler\8374123\8374123_2019_3434_206_4_iphone and found UFEDREPORT.report
									// We get the name etc from the file $case_files_and_sub_directories.
									/*
									$text = "<span>Looping trough $evidence_files_sub_folder and found $evidence_file</span>";
									$text_mysql = quote_smart($link, $text);
									echo" &middot; $text ";
									mysqli_query($link, "INSERT INTO $t_edb_agent_log
									(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '03_find_new_mirror_files_sub.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
									or die(mysqli_error($link));
									*/

									$array = explode("_", $case_files_and_sub_directories);
									$array_size = sizeof($array);


									if($array_size > 4){

										// Path to file in Linux
										$inp_mirror_file_path_linux = "$get_current_directory_address_linux" . "/" . $get_case_number . "/" . $case_files_and_sub_directories;
										$inp_mirror_file_path_linux = output_html($inp_mirror_file_path_linux);
										$inp_mirror_file_path_linux_mysql = quote_smart($link, $inp_mirror_file_path_linux);
												
										$inp_mirror_file_path_windows = "$get_current_directory_address_windows" . "\\" . $get_case_number . "\\" . $case_files_and_sub_directories;
										$inp_mirror_file_path_windows = output_html($inp_mirror_file_path_windows);
										$inp_mirror_file_path_windows_mysql = quote_smart($link, $inp_mirror_file_path_windows);
											


										$ext = get_extension($evidence_file);
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
												$text = "<span style=\"color:red;\">03_find_new_mirror_files_sub.php #7 District not found ($district_number) for file $evidence_files_sub_folder/$evidence_file. Please fix file naming. It should be case_year_district_item_title.ext</span>";
												$text_mysql = quote_smart($link, $text);
												echo" &middot; $text ";
												mysqli_query($link, "INSERT INTO $t_edb_agent_log
												(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '03_find_new_mirror_files_sub.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
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
													$text = "03_find_new_mirror_files_sub.php #8a Created record from scanning mirror folders. <b>Case number:</b> $get_case_number&middot;";
													$text = $text  . "<b>Year:</b> $year &middot;";
													$text = $text  . "<b>Journal:</b> $journal &middot;";
													$text = $text  . "<b>District:</b> $district_number &middot;";
													$text = $text  . "<b>Item :</b> $item_numeric_serial_number &middot;";
													$text = $text  . "<b>Title:</b> $title";	
													$text_mysql = quote_smart($link, $text);
													echo" &middot; $text ";
													mysqli_query($link, "INSERT INTO $t_edb_agent_log
													(agent_log_id, 'agent_name', agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '03_find_new_mirror_files_sub.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
													or die(mysqli_error($link));
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
														item_record_seized_district_number, item_numeric_serial_number, item_title, item_parent_item_id, item_type_id, 
														item_type_title, item_confirmed_by_human, item_human_rejected, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy) 
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
														$text = "03_find_new_mirror_files_sub.php #8b Created record and item from scanning mirror folders. <b>Case number:</b> $get_case_number&middot;";
														$text = $text  . "<b>Year:</b> $year &middot; ";
														$text = $text  . "<b>Journal:</b> $journal &middot; ";
														$text = $text  . "<b>District:</b> $district_number &middot; ";
														$text = $text  . "<b>Item:</b> $item_numeric_serial_number &middot; ";
														$text = $text  . "<b>Type ID:</b> $inp_item_type_id &middot; ";
														$text = $text  . "<b>Type Title:</b> $inp_item_type_title &middot; ";
														$text = $text  . "<b>Title:</b> $title &middot; ";
														$text = $text  . "<b>File:</b> $evidence_file &middot; ";
														$text = $text  . "<b>Ext:</b> $ext";
														$text_mysql = quote_smart($link, $text);
														echo" &middot; $text ";
														mysqli_query($link, "INSERT INTO $t_edb_agent_log
														(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '03_find_new_mirror_files_sub.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
														or die(mysqli_error($link));
													} // create item
													if($get_current_item_id != ""){


											

														$inp_mirror_file_file = "$evidence_file";
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
														if(!(is_dir("$mirror_file_path/$inp_mirror_file_file"))){

															$query = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_case_id=$get_current_item_case_id AND mirror_file_record_id=$get_current_item_record_id AND mirror_file_item_id=$get_current_item_id AND mirror_file_path_windows=$inp_mirror_file_path_windows_mysql AND mirror_file_file=$inp_mirror_file_file_mysql";
															$result = mysqli_query($link, $query);
															$row = mysqli_fetch_row($result);
															list($get_current_mirror_file_id, $get_current_mirror_file_case_id, $get_current_mirror_file_record_id, $get_current_mirror_file_item_id, $get_current_mirror_file_path_windows, $get_current_mirror_file_path_linux, $get_current_mirror_file_file, $get_current_mirror_file_ext, $get_current_mirror_file_type) = $row;
															if($get_current_mirror_file_id == ""){
		
																if($get_current_directory_address_prefered_for_agent == "linux"){
 																	$inp_mirror_file_type = mime_content_type("$inp_mirror_file_path_linux/$inp_mirror_file_file");
																}
																else{
 																	$inp_mirror_file_type = mime_content_type("$inp_mirror_file_path_windows/$inp_mirror_file_file");
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

																$text = "03_find_new_mirror_files_sub.php #10 Found mirror file. <b>Case number:</b> $get_case_number&middot;";
																$text = $text  . "<b>Mirror file:</b> $mirror_file_path/$inp_mirror_file_file";
																$text_mysql = quote_smart($link, $text);
																echo" &middot; $text ";
																mysqli_query($link, "INSERT INTO $t_edb_agent_log
																(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '03_find_new_mirror_files_sub.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
																or die(mysqli_error($link));


																// Get mirror file ID
																$query_m = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_case_id=$get_current_item_case_id AND mirror_file_record_id=$get_current_item_record_id AND mirror_file_item_id=$get_current_item_id AND mirror_file_path_windows=$inp_mirror_file_path_windows_mysql AND mirror_file_file=$inp_mirror_file_file_mysql";
																$result_m = mysqli_query($link, $query_m);
																$row_m = mysqli_fetch_row($result_m);
																list($get_current_mirror_file_id) = $row_m;
													

																// Ping on
																$get_current_case_id = "$get_case_id";
																include("agents/02-03_find_new_mirror_files_ping_on.php");
															}
														} // 1) mirror file saved in root of case dir
													} // curent item id
												} // record exists
											} // district found

										} // is_numeric($case_number) && $case_number == "$get_case_number" && is_numeric($year) && is_numeric($journal) && is_numeric($district_number) && is_numeric($item_numeric_serial_number)
									} // $array_size > 4

								} // while /home/datakrim/share_test/speilfiler_haugesund_test/8040494/8040494_2019_0494_206_1_LenovoG50
							} // if open dir /home/datakrim/share_test/speilfiler_haugesund_test/8040494/8040494_2019_0494_206_1_LenovoG50
							// END loop trough /home/datakrim/share_test/speilfiler_haugesund_test/8040494/8040494_2019_0494_206_1_LenovoG50

						} // 	if(is_dir($evidence_files_sub_folder)){

					} // while open case folder
				} // handle case folder
			} // is dir ($get_current_directory_address_windows\\$get_case_number)
			else{
				// Error
				$text = "03_find_new_mirror_files_sub.php #1 Could not open <a href=\"open_case_overview.php?case_id=$get_case_id&amp;l=$l\">$get_case_number</a>. Dir: $dir";	
				$text_mysql = quote_smart($link, $text);
				echo" &middot; $text ";
				mysqli_query($link, "INSERT INTO $t_edb_agent_log
				(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '03_find_new_mirror_files_sub.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
				or die(mysqli_error($link));
			} // not dir ($get_current_directory_address_windows\\$get_case_number)

		} // all open cases
	} // if($get_current_directory_id != ""){


	echo"
	</p>
	</div>
	";
	echo"</body>\n";
	echo"</html>";
} // logged in

?>