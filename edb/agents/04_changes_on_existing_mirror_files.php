<?php 
/**
*
* File: edb/agent.php
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

$t_edb_case_index_evidence_items_mirror_files_hash	= $mysqlPrefixSav . "edb_case_index_evidence_items_mirror_files_hash";


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
	$date_ddmmyyyyhis = date("d.m.Y H:i:s");

	echo"
	<div class=\"main\">
	<p><a href=\"agent_display_log.php?l=$l\" target=\"_top\">$l_agent 04</a> $date_hi
	";

	// are we linux or windows?
	$query = "SELECT directory_id, directory_address_prefered_for_agent FROM $t_edb_stations_directories WHERE directory_type='mirror_files' ORDER BY directory_last_checked_for_new_files_counter ASC LIMIT 0,1";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_directory_id, $get_current_directory_address_prefered_for_agent) = $row;
	if($get_current_directory_id == ""){
		echo"No directory found!";
		die;
	}


	// 1. Existing mirror files
	$query = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_created_datetime, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_modified_datetime, mirror_file_modified_time, mirror_file_modified_date_saying, mirror_file_modified_date_ddmmyy, mirror_file_size_bytes, mirror_file_size_mb, mirror_file_size_human, mirror_file_backup_disk, mirror_file_exists, mirror_file_ready_for_automated_machine, mirror_file_ready_agent_tries_counter, mirror_file_comments FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_ready_for_automated_machine=0 AND mirror_file_ready_agent_tries_counter < 20";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_mirror_file_id, $get_mirror_file_case_id, $get_mirror_file_record_id, $get_mirror_file_item_id, $get_mirror_file_path_windows, $get_mirror_file_path_linux, $get_mirror_file_file, $get_mirror_file_ext, $get_mirror_file_type, $get_mirror_file_created_datetime, $get_mirror_file_created_time, $get_mirror_file_created_date_saying, $get_mirror_file_created_date_ddmmyy, $get_mirror_file_modified_datetime, $get_mirror_file_modified_time, $get_mirror_file_modified_date_saying, $get_mirror_file_modified_date_ddmmyy, $get_mirror_file_size_bytes, $get_mirror_file_size_mb, $get_mirror_file_size_human, $get_mirror_file_backup_disk, $get_mirror_file_exists, $get_mirror_file_ready_for_automated_machine, $get_mirror_file_ready_agent_tries_counter, $get_mirror_file_comments) = $row;
			

		// Does the file exists?
		if($get_mirror_file_exists == "" OR $get_mirror_file_exists == "0"){
			if($get_current_directory_address_prefered_for_agent == "linux"){
				$mirror_file_path = "$get_mirror_file_path_linux";
			}
			else{
				$mirror_file_path = "$get_mirror_file_path_windows";
			}

			// Update tries counter, in case of time out
			$inp_mirror_file_ready_agent_tries_counter = $get_mirror_file_ready_agent_tries_counter+1;
			$text = "<span>#0 Does the file &quot;$mirror_file_path/$get_mirror_file_file&quot; exists? Tries counter = $inp_mirror_file_ready_agent_tries_counter</span>";
			$text_mysql = quote_smart($link, $text);
			echo" &middot; $text ";
			mysqli_query($link, "INSERT INTO $t_edb_agent_log
			(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '04_changes_on_existing_mirror_files.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
			or die(mysqli_error($link));
			$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items_mirror_files SET mirror_file_ready_agent_tries_counter=$inp_mirror_file_ready_agent_tries_counter WHERE mirror_file_id=$get_mirror_file_id") or die(mysqli_error($link));
			
			if(file_exists("$mirror_file_path/$get_mirror_file_file") && $get_mirror_file_file != ""){
				// Exists
				$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items_mirror_files SET mirror_file_exists=1 WHERE mirror_file_id=$get_mirror_file_id") or die(mysqli_error($link));
				
				// Text output
				$text = "<span style=\"color:green;\">#1 $mirror_file_path/$get_mirror_file_file exists</span>";
				$text_mysql = quote_smart($link, $text);
				echo" &middot; $text ";
				mysqli_query($link, "INSERT INTO $t_edb_agent_log
				(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '04_changes_on_existing_mirror_files.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
				or die(mysqli_error($link));
			}
			else{
				// Doesnt exists
				$inp_mirror_file_ready_agent_tries_counter = $get_mirror_file_ready_agent_tries_counter+1;
				$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items_mirror_files SET mirror_file_exists=0 WHERE mirror_file_id=$get_mirror_file_id") or die(mysqli_error($link));


				// Text output
				$text = "<span style=\"color:red;\">#2 $mirror_file_path/$get_mirror_file_file doesnt exists (try number $get_mirror_file_ready_agent_tries_counter of 20)</span>";
				$text_mysql = quote_smart($link, $text);
				echo" &middot;  $text ";
				mysqli_query($link, "INSERT INTO $t_edb_agent_log
				(agent_log_id, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
				or die(mysqli_error($link));
			}
		}

		if($get_mirror_file_exists == "1"){

			if($get_current_directory_address_prefered_for_agent == "linux"){
				$mirror_file_path = "$get_mirror_file_path_linux";
			}
			else{
				$mirror_file_path = "$get_mirror_file_path_windows";
			}

			// Check that file exists
			if(file_exists("$mirror_file_path/$get_mirror_file_file")){
				// File exists
				// Fetch file size etc
				$inp_mirror_file_modified_datetime = date ("Y-m-d H:i:s", filemtime("$mirror_file_path/$get_mirror_file_file"));
				$inp_mirror_file_modified_date = date ("Y-m-d", filemtime("$mirror_file_path/$get_mirror_file_file"));
				$inp_mirror_file_modified_time  = filemtime("$mirror_file_path/$get_mirror_file_file");
				$inp_mirror_file_modified_date_saying = date ("d. M y H:i", filemtime("$mirror_file_path/$get_mirror_file_file"));
				$inp_mirror_file_modified_date_ddmmyy = date ("d.m.y H:i", filemtime("$mirror_file_path/$get_mirror_file_file"));
			
				$file_size_bytes = filesize("$mirror_file_path/$get_mirror_file_file");
				$file_size_human = format_size_units($file_size_bytes);
	
				if(mime_content_type("$mirror_file_path/$get_mirror_file_file")){

					$inp_mirror_file_type = mime_content_type("$mirror_file_path/$get_mirror_file_file");
					$inp_mirror_file_type = output_html($inp_mirror_file_type);
					$inp_mirror_file_type_mysql = quote_smart($link, $inp_mirror_file_type);

					$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items_mirror_files SET 
							mirror_file_type=$inp_mirror_file_type_mysql,
							mirror_file_modified_datetime='$inp_mirror_file_modified_datetime', 
							mirror_file_modified_date='$inp_mirror_file_modified_date', 
							mirror_file_modified_time='$inp_mirror_file_modified_time', 
							mirror_file_modified_date_saying='$inp_mirror_file_modified_date_saying', 
							mirror_file_modified_date_ddmmyy='$inp_mirror_file_modified_date_ddmmyy',
							mirror_file_size_bytes='$file_size_bytes',
							mirror_file_size_human='$file_size_human' WHERE mirror_file_id=$get_mirror_file_id") or die(mysqli_error($link));
			
					// Text output
					$diff_seconds = $time-$inp_mirror_file_modified_time;
					$diff_minutes = floor($diff_seconds/60);

					$text = "<span>#3 <b>Mirror file ID:</b> $get_mirror_file_id <b>Full Path:</b> $mirror_file_path/$get_mirror_file_file modified <tt>$inp_mirror_file_modified_date_saying</tt> and file size is <tt>$file_size_human</tt>. Modified in minutes = $diff_minutes</span>";
					$text_mysql = quote_smart($link, $text);
					echo" &middot;$text ";
					mysqli_query($link, "INSERT INTO $t_edb_agent_log
					(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '04_changes_on_existing_mirror_files.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
					or die(mysqli_error($link));

					// The file is ready for processing if the file size hasnt changed in 20 minutes
					if($diff_minutes > 45){
						// Ready to process
						$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items_mirror_files SET mirror_file_ready_for_automated_machine=1 WHERE mirror_file_id=$get_mirror_file_id") or die(mysqli_error($link));

						// Generate hash
						$md5 = md5_file("$mirror_file_path/$get_mirror_file_file");
						$md5_mysql = quote_smart($link, $md5);

						$sha1 = sha1_file("$mirror_file_path/$get_mirror_file_file");
						$sha1_mysql = quote_smart($link, $sha1);


						$query = "SELECT hash_id FROM $t_edb_case_index_evidence_items_mirror_files_hash WHERE hash_case_id=$get_mirror_file_case_id AND hash_mirror_file_id=$get_mirror_file_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_hash_id) = $row;
						if($get_hash_id == ""){
							mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_items_mirror_files_hash 
							(hash_id, hash_case_id, hash_mirror_file_id, hash_md5, hash_sha1, hash_created_datetime, hash_created_ddmmyyhhiiss) 
							VALUES 
							(NULL, $get_mirror_file_case_id, $get_mirror_file_id, $md5_mysql, $sha1_mysql, '$datetime', '$date_ddmmyyyyhis')")
							or die(mysqli_error($link)); 
						}
						else{
							$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items_mirror_files_hash SET 
							hash_md5=$md5_mysql, 
							hash_sha1=$sha1_mysql, 
							hash_created_datetime='$datetime',
							hash_created_ddmmyyhhiiss='$date_ddmmyyyyhis'
							 WHERE hash_id=$get_hash_id") or die(mysqli_error($link));
						}
				
				
						// Text output
						$text = "<span>#4 $mirror_file_path/$get_mirror_file_file has not been modifiend in <tt>$diff_minutes</tt> minutes and is ready for processing. MD5=$md5. SHA1=$sha1.</span>";
						$text_mysql = quote_smart($link, $text);
						echo" &middot; $text ";
						mysqli_query($link, "INSERT INTO $t_edb_agent_log
						(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '04_changes_on_existing_mirror_files.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
						or die(mysqli_error($link));

						// Ping
						$get_current_case_id = "$get_mirror_file_case_id";
						$get_current_mirror_file_id = "$get_mirror_file_id";
						include("02-03_find_new_mirror_files_ping_on.php");
					}
				} // if mime_content_type("$mirror_file_path/$get_mirror_file_file")
				else{
					$text = "<span style=\"color: orange\">#5 <b>Mirror file ID:</b> $get_mirror_file_id <b>mime_content_type(</b>$mirror_file_path/$get_mirror_file_file<b>)</b> failed</span>";
					$text_mysql = quote_smart($link, $text);
					echo" &middot;$text ";
					mysqli_query($link, "INSERT INTO $t_edb_agent_log
					(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '04_changes_on_existing_mirror_files.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
					or die(mysqli_error($link));
				}
			} // file exists
			else{
				$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items_mirror_files SET 
							mirror_file_exists=0
							WHERE mirror_file_id=$get_mirror_file_id") or die(mysqli_error($link));

				// Text output
				$text = "<span>#5 $mirror_file_path/$get_mirror_file_file doesnt exists.</span>";
				$text_mysql = quote_smart($link, $text);
				echo" &middot; $text ";
				mysqli_query($link, "INSERT INTO $t_edb_agent_log
				(agent_log_id, agent_name, agent_log_datetime, agent_log_date_ddmmyyhi, agent_log_date_ddmmyyyyhi, agent_log_date_saying, agent_log_text)  VALUES (NULL, '04_changes_on_existing_mirror_files.php', '$datetime', '$date_dmyhi', '$date_ddmmyyyyhi', '$date_saying', $text_mysql)")
				or die(mysqli_error($link));
			} // file doesnt exist
		}
	}


	echo"
	</p>
	</div>
	";
	echo"</body>\n";
	echo"</html>";
} // logged in

?>