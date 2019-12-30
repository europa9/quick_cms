<?php
/**
*
* File: _admin/_inc/edb/_liquibase/case/001_case.php
* Version 1.0.0
* Date 21:19 28.08.2019
* Copyright (c) 2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

echo"
<!-- edb_case_index-->
";

$query = "SELECT * FROM $t_edb_case_index LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index(
	  case_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(case_id), 
	   case_number INT,
	   case_title VARCHAR(200), 
	   case_title_clean VARCHAR(200), 
	   case_suspect_in_custody INT, 
	   case_code_id INT, 
	   case_code_number INT, 
	   case_code_title VARCHAR(200), 
	   case_status_id INT, 
	   case_status_title VARCHAR(200), 
	   case_priority_id INT, 
	   case_priority_title VARCHAR(200), 
	   case_district_id INT, 
	   case_district_title VARCHAR(200), 
	   case_station_id INT, 
	   case_station_title VARCHAR(200), 
	   case_is_screened INT,
	   case_physical_location VARCHAR(200), 
	   case_backup_disks VARCHAR(200), 
	   case_confirmed_by_human INT,
	   case_human_rejected INT,
	   case_last_event_text VARCHAR(200), 
	   case_assigned_to_datetime DATETIME, 
	   case_assigned_to_date DATE, 
	   case_assigned_to_time VARCHAR(200), 
	   case_assigned_to_date_saying VARCHAR(200), 
	   case_assigned_to_date_ddmmyy VARCHAR(200), 
	   case_assigned_to_date_ddmmyyyy VARCHAR(200), 
	   case_assigned_to_user_id INT, 
	   case_assigned_to_user_name VARCHAR(200), 
	   case_assigned_to_user_alias VARCHAR(200), 
	   case_assigned_to_user_email VARCHAR(200), 
	   case_assigned_to_user_image_path VARCHAR(200), 
	   case_assigned_to_user_image_file VARCHAR(200), 
	   case_assigned_to_user_image_thumb_40 VARCHAR(200), 
	   case_assigned_to_user_image_thumb_50 VARCHAR(200), 
	   case_assigned_to_user_first_name VARCHAR(200), 
	   case_assigned_to_user_middle_name VARCHAR(200), 
	   case_assigned_to_user_last_name VARCHAR(200), 
	   case_created_datetime DATETIME, 
	   case_created_date DATE, 
	   case_created_time VARCHAR(200), 
	   case_created_date_saying VARCHAR(200), 
	   case_created_date_ddmmyy VARCHAR(200), 
	   case_created_date_ddmmyyyy VARCHAR(200), 
	   case_created_user_id INT, 
	   case_created_user_name VARCHAR(200), 
	   case_created_user_alias VARCHAR(200), 
	   case_created_user_email VARCHAR(200), 
	   case_created_user_image_path VARCHAR(200), 
	   case_created_user_image_file VARCHAR(200), 
	   case_created_user_image_thumb_40 VARCHAR(200), 
	   case_created_user_image_thumb_50 VARCHAR(200), 
	   case_created_user_first_name VARCHAR(200), 
	   case_created_user_middle_name VARCHAR(200), 
	   case_created_user_last_name VARCHAR(200), 
	   case_detective_user_id INT,
	   case_detective_user_job_title VARCHAR(200), 
	   case_detective_user_department VARCHAR(200), 
	   case_detective_user_first_name VARCHAR(200), 
	   case_detective_user_middle_name VARCHAR(200), 
	   case_detective_user_last_name VARCHAR(200), 
	   case_detective_user_name VARCHAR(200), 
	   case_detective_user_alias VARCHAR(200), 
	   case_detective_user_email VARCHAR(200), 
	   case_detective_email_alerts INT,
	   case_detective_user_image_path VARCHAR(200), 
	   case_detective_user_image_file VARCHAR(200), 
	   case_detective_user_image_thumb_40 VARCHAR(200), 
	   case_detective_user_image_thumb_50 VARCHAR(200), 
	   case_updated_datetime DATETIME, 
	   case_updated_date DATE, 
	   case_updated_time VARCHAR(200), 
	   case_updated_date_saying VARCHAR(200), 
	   case_updated_date_ddmmyy VARCHAR(200), 
	   case_updated_date_ddmmyyyy VARCHAR(200), 
	   case_updated_user_id INT, 
	   case_updated_user_name VARCHAR(200), 
	   case_updated_user_alias VARCHAR(200), 
	   case_updated_user_email VARCHAR(200), 
	   case_updated_user_image_path VARCHAR(200),
	   case_updated_user_image_file VARCHAR(200),
	   case_updated_user_image_thumb_40 VARCHAR(200),
	   case_updated_user_image_thumb_50 VARCHAR(200), 
	   case_updated_user_first_name VARCHAR(200), 
	   case_updated_user_middle_name VARCHAR(200), 
	   case_updated_user_last_name VARCHAR(200), 
	   case_is_closed INT,
	   case_closed_datetime DATETIME, 
	   case_closed_date DATE, 
	   case_closed_time VARCHAR(200), 
	   case_closed_date_saying VARCHAR(200), 
	   case_closed_date_ddmmyy VARCHAR(200), 
	   case_closed_date_ddmmyyyy VARCHAR(200), 
	   case_time_from_created_to_close VARCHAR(200))")
	   or die(mysqli_error());	

	// Dates
	$datetime = date("Y-m-d H:i:s");
	$time = time();
	$date_saying = date("j M Y");


	// Me
	$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_id=$my_user_id_mysql AND user_security=$my_security_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_language, $get_my_user_last_online, $get_my_user_rank, $get_my_user_login_tries) = $row;
	
	// Get my photo
	$query = "SELECT photo_id, photo_destination, photo_thumb_40 FROM $t_users_profile_photo WHERE photo_user_id='$get_my_user_id' AND photo_profile_image='1'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_photo_id, $get_my_photo_destination, $get_my_photo_thumb_40) = $row;


	$inp_my_user_alias_mysql = quote_smart($link, $get_my_user_alias);
	$inp_my_user_email_mysql = quote_smart($link, $get_my_user_email);
	$inp_my_user_image_mysql = quote_smart($link, $get_my_photo_destination);
	
	/*
	mysqli_query($link, "INSERT INTO $t_edb_case_index
	(case_id, case_number, case_title, case_title_clean, case_code_id, case_code_title, case_status_id, case_status_title, case_priority_id, case_priority_title, case_physical_location_id, case_physical_location_title, case_assigned_to_datetime, case_assigned_to_time, case_assigned_to_date_saying, case_assigned_to_user_id, case_assigned_to_user_alias, case_assigned_to_user_email, case_assigned_to_user_image, case_created_datetime, case_created_time, case_created_date_saying, case_created_user_id, case_created_user_alias, case_created_user_email, case_created_user_image, case_updated_datetime, case_updated_time, case_updated_date_saying, case_updated_user_id, case_updated_user_alias, case_updated_user_email, case_updated_user_image) 
	VALUES 
	(NULL, '71800513', 'Aasmund Hansen', 'aasmund_hansen', 1, 'Overgrep', '0', 'Venter', '1', 'Høy', '2', 'Haugesund', '$datetime', '$time', '$date_saying', $get_my_user_id, $inp_my_user_alias_mysql, $inp_my_user_email_mysql, $inp_my_user_image_mysql, '$datetime', '$time', '$date_saying', $get_my_user_id, $inp_my_user_alias_mysql, $inp_my_user_email_mysql, $inp_my_user_image_mysql, '$datetime', '$time', '$date_saying', $get_my_user_id, $inp_my_user_alias_mysql, $inp_my_user_email_mysql, $inp_my_user_image_mysql)
	") or die(mysqli_error($link));*/

}
echo"
<!-- //edb_case_index -->

<!-- edb_case_index_events-->
";

$query = "SELECT * FROM $t_edb_case_index_events LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_events: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_events(
	  event_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(event_id), 
	   event_case_id INT,
	   event_importance VARCHAR(200), 
	   event_text TEXT, 
	   event_datetime DATETIME, 
	   event_date DATE, 
	   event_time VARCHAR(200), 
	   event_date_saying VARCHAR(200), 
	   event_date_ddmmyy VARCHAR(200), 
	   event_date_ddmmyyyy VARCHAR(200), 
	   event_user_id INT, 
	   event_user_name VARCHAR(200), 
	   event_user_alias VARCHAR(200), 
	   event_user_email VARCHAR(200), 
	   event_user_image_path VARCHAR(200), 
	   event_user_image_file VARCHAR(200), 
	   event_user_image_thumb_40 VARCHAR(200), 
	   event_user_image_thumb_50 VARCHAR(200), 
	   event_user_first_name VARCHAR(200), 
	   event_user_middle_name VARCHAR(200), 
	   event_user_last_name VARCHAR(200))")
	   or die(mysqli_error());	


}
echo"
<!-- //edb_case_index_events -->


<!-- edb_case_index_evidence_records -->
";

$query = "SELECT * FROM $t_edb_case_index_evidence_records LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_evidence_records: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_evidence_records(
	  record_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(record_id), 
	   record_case_id INT,
	   record_seized_year VARCHAR(4), 
	   record_seized_journal INT,
	   record_seized_district_id INT,
	   record_seized_district_number INT,
	   record_seized_district_title VARCHAR(200), 
	   record_confirmed_by_human INT,
	   record_human_rejected INT,
	   record_notes TEXT,
	   record_created_datetime DATETIME,
	   record_created_date DATE,
	   record_created_time VARCHAR(200), 
	   record_created_date_saying VARCHAR(100), 
	   record_created_date_ddmmyy VARCHAR(100), 
	   record_created_date_ddmmyyyy VARCHAR(100))")
	   or die(mysqli_error());	


}
echo"
<!-- //edb_case_index_evidence_records -->


<!-- edb_case_index_evidence_items -->
";

$query = "SELECT * FROM $t_edb_case_index_evidence_items LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_evidence_items: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_evidence_items(
	  item_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(item_id), 
	   item_case_id INT,
	   item_record_id INT,
	   item_record_seized_year VARCHAR(4), 
	   item_record_seized_journal INT,
	   item_record_seized_district_number INT,
	   item_numeric_serial_number INT,
	   item_title VARCHAR(200), 
	   item_type_id INT, 
	   item_type_title VARCHAR(200), 
	   item_confirmed_by_human INT,
	   item_human_rejected INT,

	   item_request_text TEXT, 
	   item_requester_user_id INT, 
	   item_requester_user_name VARCHAR(200), 
	   item_requester_user_alias VARCHAR(200), 
	   item_requester_user_email VARCHAR(200), 
	   item_requester_user_image_path VARCHAR(200),
	   item_requester_user_image_file VARCHAR(200),
	   item_requester_user_image_thumb_40 VARCHAR(200),
	   item_requester_user_image_thumb_50 VARCHAR(200), 
	   item_requester_user_first_name VARCHAR(200), 
	   item_requester_user_middle_name VARCHAR(200), 
	   item_requester_user_last_name VARCHAR(200),
	   item_requester_user_job_title VARCHAR(200), 
	   item_requester_user_department VARCHAR(200),

	   item_in_datetime DATETIME,
	   item_in_date DATE,
	   item_in_time VARCHAR(200), 
	   item_in_date_saying VARCHAR(100), 
	   item_in_date_ddmmyy VARCHAR(100), 
	   item_in_date_ddmmyyyy VARCHAR(100), 
	   item_storage_shelf_id INT, 
	   item_storage_shelf_title VARCHAR(200), 
	   item_storage_location_id INT, 
	   item_storage_location_abbr VARCHAR(200), 

	   item_comment TEXT, 
	   item_condition TEXT, 
	   item_serial_number VARCHAR(200), 
	   item_imei_a VARCHAR(200), 
	   item_imei_b VARCHAR(200), 
	   item_imei_c VARCHAR(200), 
	   item_imei_d VARCHAR(200), 
	   item_os_title VARCHAR(200), 
	   item_os_version VARCHAR(200), 
	   item_login_user VARCHAR(200), 
	   item_login_password VARCHAR(200), 
	   item_startup_password VARCHAR(200), 
	   item_pin VARCHAR(200), 
	   item_unlock_pattern VARCHAR(200), 
	   item_decrypt_password VARCHAR(200), 
	   item_bios_password VARCHAR(200), 
	   item_timezone VARCHAR(200), 
	   item_date_now_date DATE, 
	   item_date_now_saying VARCHAR(100), 
	   item_date_now_ddmmyy VARCHAR(100), 
	   item_date_now_ddmmyyyy VARCHAR(100), 
	   item_time_now VARCHAR(200), 
	   item_correct_date_now_date DATE,
	   item_correct_date_now_saying VARCHAR(100), 
	   item_correct_date_now_ddmmyy VARCHAR(100), 
	   item_correct_date_now_ddmmyyyy VARCHAR(100), 
	   item_correct_time_now VARCHAR(200), 
	   item_adjust_clock_automatically VARCHAR(200), 


	   item_acquired_software_id_a INT,
	   item_acquired_software_title_a VARCHAR(200),
	   item_acquired_software_notes_a VARCHAR(200),
	   item_acquired_software_id_b INT,
	   item_acquired_software_title_b VARCHAR(200),
	   item_acquired_software_notes_b VARCHAR(200),
	   item_acquired_software_id_c INT,
	   item_acquired_software_title_c VARCHAR(200),
	   item_acquired_software_notes_c VARCHAR(200),
	   item_acquired_date DATE,
	   item_acquired_time VARCHAR(200), 
	   item_acquired_date_saying VARCHAR(200), 
	   item_acquired_date_ddmmyy VARCHAR(200), 
	   item_acquired_date_ddmmyyyy VARCHAR(200), 

	   item_acquired_user_id INT, 
	   item_acquired_user_name VARCHAR(200), 
	   item_acquired_user_alias VARCHAR(200), 
	   item_acquired_user_email VARCHAR(200), 
	   item_acquired_user_image_path VARCHAR(200), 
	   item_acquired_user_image_file VARCHAR(200), 
	   item_acquired_user_image_thumb_40 VARCHAR(200), 
	   item_acquired_user_image_thumb_50 VARCHAR(200), 
	   item_acquired_user_first_name VARCHAR(200), 
	   item_acquired_user_middle_name VARCHAR(200), 
	   item_acquired_user_last_name VARCHAR(200), 
	   

	   item_out_date DATE,
	   item_out_time VARCHAR(200), 
	   item_out_date_saying VARCHAR(100), 
	   item_out_date_ddmmyy VARCHAR(100), 
	   item_out_date_ddmmyyyy VARCHAR(100),
	   item_out_notes VARCHAR(200)
		)")
	   or die(mysqli_error());	


}
echo"
<!-- //edb_case_index_evidence_items -->


<!-- edb_case_index_evidence_items_sim_cards -->
";

$query = "SELECT * FROM $t_edb_case_index_evidence_items_sim_cards LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_evidence_items_sim_cards: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_evidence_items_sim_cards(
	  sim_card_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(sim_card_id), 
	   sim_card_case_id INT,
	   sim_card_record_id INT,
	   sim_card_item_id INT,
	   sim_card_imei VARCHAR(200), 
	   sim_card_iccid VARCHAR(200), 
	   sim_card_imsi VARCHAR(200), 
	   sim_card_phone_number VARCHAR(200), 
	   sim_card_pin VARCHAR(200), 
	   sim_card_puc VARCHAR(200), 
	   sim_card_operator VARCHAR(200), 
	   sim_card_comments TEXT)")
	   or die(mysqli_error());	


}
echo"
<!-- //edb_case_index_evidence_items_sim_cards -->


<!-- edb_case_index_evidence_items_sd_cards -->
";

$query = "SELECT * FROM $t_edb_case_index_evidence_items_sd_cards LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_evidence_items_sd_cards: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_evidence_items_sd_cards(
	  sd_card_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(sd_card_id), 
	   sd_card_case_id INT,
	   sd_card_record_id INT,
	   sd_card_item_id INT,
	   sd_card_manufacturer VARCHAR(200), 
	   sd_card_size VARCHAR(200), 
	   sd_card_serial VARCHAR(200), 
	   sd_card_comments TEXT)")
	   or die(mysqli_error());
}
echo"
<!-- //edb_case_index_evidence_items_sd_cards -->


<!-- edb_case_index_evidence_items_networks -->
";

$query = "SELECT * FROM $t_edb_case_index_evidence_items_networks LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_evidence_items_networks: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_evidence_items_networks(
	  network_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(network_id), 
	   network_case_id INT,
	   network_record_id INT,
	   network_item_id INT,
	   network_is_wifi INT, 
	   network_manufacturer VARCHAR(200), 
	   network_card_title VARCHAR(200), 
	   network_mac VARCHAR(200), 
	   network_serial VARCHAR(200), 
	   network_comments TEXT)")
	   or die(mysqli_error());
}
echo"
<!-- //edb_case_index_evidence_items_networks -->



<!-- edb_case_index_evidence_items_hard_disks -->
";

$query = "SELECT * FROM $t_edb_case_index_evidence_items_hard_disks LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_evidence_items_hard_disks: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_evidence_items_hard_disks(
	  hard_disk_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(hard_disk_id), 
	   hard_disk_case_id INT,
	   hard_disk_record_id INT,
	   hard_disk_item_id INT,
	   hard_disk_manufacturer VARCHAR(200), 
	   hard_disk_type VARCHAR(200), 
	   hard_disk_size VARCHAR(200), 
	   hard_disk_serial VARCHAR(200), 
	   hard_disk_comments TEXT)")
	   or die(mysqli_error());
}
echo"
<!-- //edb_case_index_evidence_items_hard_disks -->


<!-- edb_case_index_evidence_items_mirror_files -->
";

$query = "SELECT * FROM $t_edb_case_index_evidence_items_mirror_files LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_evidence_items_mirror_files: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_evidence_items_mirror_files(
	  mirror_file_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(mirror_file_id), 
	   mirror_file_case_id INT,
	   mirror_file_record_id INT,
	   mirror_file_item_id INT,
	   mirror_file_path VARCHAR(200), 
	   mirror_file_file VARCHAR(200), 
	   mirror_file_ext VARCHAR(200), 
	   mirror_file_type VARCHAR(200), 
	   mirror_file_confirmed_by_human INT,
	   mirror_file_human_rejected INT,

	   mirror_file_created_datetime DATETIME,
	   mirror_file_created_date DATE,
	   mirror_file_created_time VARCHAR(200), 
	   mirror_file_created_date_saying VARCHAR(200), 
	   mirror_file_created_date_ddmmyy VARCHAR(200), 
	   mirror_file_created_date_ddmmyyyy VARCHAR(200), 

	   mirror_file_modified_datetime DATETIME,
	   mirror_file_modified_date DATE,
	   mirror_file_modified_time VARCHAR(200), 
	   mirror_file_modified_date_saying VARCHAR(200), 
	   mirror_file_modified_date_ddmmyy VARCHAR(200), 
	   mirror_file_modified_date_ddmmyyyy VARCHAR(200), 
	   
	   mirror_file_size_bytes VARCHAR(200), 
	   mirror_file_size_mb DOUBLE, 
	   mirror_file_size_human VARCHAR(200), 
	   mirror_file_backup_disk VARCHAR(200), 
	   mirror_file_exists INT,
	   mirror_file_exists_agent_tries_counter INT,
	   mirror_file_ready_for_automated_machine INT,
	   mirror_file_ready_agent_tries_counter INT,
	   mirror_file_comments VARCHAR(200))")
	   or die(mysqli_error());
}
echo"
<!-- //edb_case_index_evidence_items_mirror_files -->


<!-- edb_case_index_statuses -->
";

$query = "SELECT * FROM $t_edb_case_index_statuses LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_statuses: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_statuses(
	  case_index_status_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(case_index_status_id), 
	   case_index_status_case_id INT,
	   case_index_status_status_id INT,
	   case_index_status_status_title VARCHAR(200), 
	   case_index_status_weight INT,
	   case_index_status_datetime DATETIME,
	   case_index_status_date DATE,
	   case_index_status_time VARCHAR(200), 
	   case_index_status_date_saying VARCHAR(200), 
	   case_index_status_date_ddmmyy VARCHAR(200), 
	   case_index_status_date_ddmmyyyy VARCHAR(200), 
	   case_index_status_text VARCHAR(200), 
	  
	   case_index_status_user_id INT, 
	   case_index_status_user_name VARCHAR(200), 
	   case_index_status_user_alias VARCHAR(200), 
	   case_index_status_user_email VARCHAR(200), 
	   case_index_status_user_image_path VARCHAR(200), 
	   case_index_status_user_image_file VARCHAR(200), 
	   case_index_status_user_image_thumb_40 VARCHAR(200), 
	   case_index_status_user_image_thumb_50 VARCHAR(200), 
	   case_index_status_user_first_name VARCHAR(200), 
	   case_index_status_user_middle_name VARCHAR(200), 
	   case_index_status_user_last_name VARCHAR(200))")
	   or die(mysqli_error());	


}
echo"
<!-- //edb_case_index_statuses -->

<!-- edb_case_index_automated_tasks -->
";

$query = "SELECT * FROM $t_edb_case_index_automated_tasks LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_automated_tasks: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_automated_tasks(
	  automated_task_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(automated_task_id), 
	   automated_task_case_id INT,
	   automated_task_evidence_record_id INT,
	   automated_task_evidence_item_id INT,
	   automated_task_evidence_full_title VARCHAR(200), 
	   automated_task_task_available_id INT, 
	   automated_task_task_available_name VARCHAR(200), 
	   automated_task_task_machine_type_id INT, 
	   automated_task_task_machine_type_title VARCHAR(200), 

	   automated_task_station_id INT, 
	   automated_task_station_title VARCHAR(200), 

	   automated_task_mirror_file_id INT, 
	   automated_task_mirror_file_path VARCHAR(200), 
	   automated_task_mirror_file_file VARCHAR(200), 

	   automated_task_glossaries_ids VARCHAR(100), 
	   automated_task_priority INT, 
	   automated_task_dependent_on_automated_task_id INT, 
	   automated_task_dependent_on_automated_task_title VARCHAR(200), 

	   automated_task_added_by_user_id INT,
	   automated_task_added_by_user_email VARCHAR(200), 
	   automated_task_added_datetime DATETIME, 
	   automated_task_added_date DATE, 
	   automated_task_added_time VARCHAR(200), 
	   automated_task_added_date_saying VARCHAR(200), 
	   automated_task_added_date_ddmmyy VARCHAR(200),  
	   automated_task_added_date_ddmmyyyy VARCHAR(200),  

	   automated_task_started_datetime DATETIME, 
	   automated_task_started_date DATE, 
	   automated_task_started_time VARCHAR(200), 
	   automated_task_started_date_saying VARCHAR(200), 
	   automated_task_started_date_ddmmyyhi VARCHAR(200), 
	   automated_task_started_date_ddmmyyyyhi VARCHAR(200), 
	   automated_task_machine_id INT, 
	   automated_task_machine_name VARCHAR(200),
	  
	   automated_task_is_finished INT, 
	   automated_task_finished_datetime DATETIME, 
	   automated_task_finished_date DATE, 
	   automated_task_finished_time VARCHAR(200), 
	   automated_task_finished_date_saying VARCHAR(200), 
	   automated_task_finished_date_ddmmyyhi VARCHAR(200), 
	   automated_task_finished_date_ddmmyyyyhi VARCHAR(200), 
	   automated_task_time_taken_time VARCHAR(100), 
	   automated_task_time_taken_human VARCHAR(100))")
	   or die(mysqli_error());
}
echo"
<!-- //edb_case_index_automated_tasks -->


<!-- edb_case_index_notes -->
";

$query = "SELECT * FROM $t_edb_case_index_notes LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_notes: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_notes(
	  note_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(note_id), 
	   note_case_id INT,
	   note_text TEXT, 
	   note_datetime DATETIME, 
	   note_date DATE, 
	   note_time VARCHAR(200), 
	   note_date_saying VARCHAR(200), 
	   note_date_ddmmyy VARCHAR(200), 
	   note_date_ddmmyyyy VARCHAR(200), 
	   note_user_id INT, 
	   note_user_name VARCHAR(200), 
	   note_user_alias VARCHAR(200), 
	   note_user_email VARCHAR(200), 
	   note_user_image_path VARCHAR(200), 
	   note_user_image_file VARCHAR(200), 
	   note_user_image_thumb_40 VARCHAR(200), 
	   note_user_image_thumb_50 VARCHAR(200), 
	   note_user_first_name VARCHAR(200), 
	   note_user_middle_name VARCHAR(200), 
	   note_user_last_name VARCHAR(200))")
	   or die(mysqli_error());
}
echo"
<!-- //edb_case_index_notes -->




<!-- edb_case_index_glossaries -->
";

$query = "SELECT * FROM $t_edb_case_index_glossaries LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_glossaries: $row_cnt</p>
	";
}
else{

	mysqli_query($link, "CREATE TABLE $t_edb_case_index_glossaries(
	  case_glossary_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(case_glossary_id), 
	   case_glossary_case_id INT,
	   case_glossary_glossary_id INT,
	   case_glossary_glossary_title VARCHAR(200),
	   case_glossary_words TEXT)")
	   or die(mysqli_error());
}
echo"
<!-- //edb_case_index_glossaries -->


<!-- edb_case_index_photos -->
";

$query = "SELECT * FROM $t_edb_case_index_photos LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_photos: $row_cnt</p>
	";
}
else{

	mysqli_query($link, "CREATE TABLE $t_edb_case_index_photos(
	  photo_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(photo_id), 
	   photo_case_id INT,
	   photo_path VARCHAR(200),
	   photo_file VARCHAR(200),
	   photo_ext VARCHAR(20),
	   photo_thumb_60 VARCHAR(200),
	   photo_thumb_200 VARCHAR(200),
	   photo_title VARCHAR(200),
	   photo_description TEXT,
	   photo_uploaded_datetime DATETIME,
	   photo_weight INT)")
	   or die(mysqli_error());
}
echo"
<!-- //edb_case_index_photos -->



<!-- edb_case_codes-->
";

$query = "SELECT * FROM $t_edb_case_codes LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_codes: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_case_codes(
	  code_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(code_id), 
	   code_number VARCHAR(100),
	   code_title VARCHAR(200), 
	   code_title_clean VARCHAR(200), 
	   code_gives_priority_id INT,
	   code_gives_priority_title VARCHAR(200), 
	   code_last_used_datetime DATETIME, 
	   code_last_used_time VARCHAR(200), 
	   code_times_used INT)")
	   or die(mysqli_error());	
	
	mysqli_query($link, "INSERT INTO $t_edb_case_codes
	(code_id, code_number, code_title, code_title_clean, code_gives_priority_id, code_gives_priority_title, code_times_used) 
	VALUES 
	(NULL, '0576', 'Brudd på kontaktforbud', 'brudd_pa_kontaktforbud', 3, 'Lav', 0),
	(NULL, '0751', 'Narkotikaovertredelse', 'narkotikaovertredelse', 3, 'Lav', 0),
	(NULL, '1466', 'Seksuell handling med barn under 16 år', 'seksuell_handling_med_barn_under_16_ar', 1, 'Høy', 0),
	(NULL, '1470', 'Fremvis/still av seksu overgr mot barn el seksualiserer barn', 'fremvis_still_av_seksu_overgr_mot_barn_el_seksualiserer_barn', 1, 'Høy', 0),
	(NULL, '1466', 'Seksuell handling med barn under 16 år', 'seksuell_handling_med_barn_under_16_ar', 1, 'Høy', 0),
	(NULL, '9701', 'Mistenkelig dødsfall', 'mistenkelig_dodsfall', 1, 'Høy', 0),
	(NULL, '9707', 'Selvdrap, andre', 'selvdrap_andre', 2, 'Medium', 0)
	") or die(mysqli_error($link));

}
echo"
<!-- //edb_case_codes -->


<!-- edb_case_statuses-->
";

$query = "SELECT * FROM $t_edb_case_statuses LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_statuses: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_case_statuses(
	  status_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(status_id), 
	   status_parent_id INT,
	   status_title VARCHAR(200), 
	   status_title_clean VARCHAR(200), 
	   status_bg_color VARCHAR(200), 
	   status_border_color VARCHAR(200), 
	   status_text_color VARCHAR(200), 
	   status_link_color VARCHAR(200), 
	   status_weight INT, 
	   status_number_of_cases_now INT,
	   status_number_of_cases_max INT,
	   status_show_on_front_page INT,
	   status_on_given_status_do_close_case INT,
	   status_on_person_view_show_without_person INT,
	   status_show_on_stats_page INT,
	   status_gives_amount_of_points_to_user INT)")
	   or die(mysqli_error());	
	
	mysqli_query($link, "INSERT INTO $t_edb_case_statuses
	(status_id, status_title, status_title_clean, status_weight, status_number_of_cases_now, status_number_of_cases_max, status_show_on_front_page, status_on_given_status_do_close_case, status_on_person_view_show_without_person, status_show_on_stats_page, status_gives_amount_of_points_to_user) 
	VALUES 
	(NULL, 'Ikke tildelt', 'ikke_tildelt', 1, 0, 10, 1, 0, 1, 1, 1),
	(NULL, 'Tildelt', 'Tildelt', 2, 0, 10, 1, 0, 0, 1, 1),
	(NULL, 'Sikres', 'sikres', 3, 0, 10, 1, 0, 0, 1, 1),
	(NULL, 'Sikring utsatt', 'sikring_utsatt', 4, 0, 10, 1, 0, 0, 1, 1),
	(NULL, 'Venter analyse', 'venter_analyse', 5, 0, 10, 1, 0, 0, 1, 1),
	(NULL, 'Analyse utsatt', 'analyse_utsatt', 6, 0, 10, 1, 0, 0, 1, 1),
	(NULL, 'Analyse', 'analyse', 7, 0, 10, 1, 0, 0, 1, 1),
	(NULL, 'QA', 'qa', 8, 0, 10, 1, 0, 0, 1, 1),
	(NULL, 'Ferdig', 'ferdig', 9, 0, 10, 1, 1, 1, 1, 1),
	(NULL, 'Avvist', 'avvist', 10, 0, 0, 0, 1, 1, 1, 1)
	") or die(mysqli_error($link));

}
echo"
<!-- //edb_statuses -->


<!-- edb_case_statuses_district_case_counter -->
";

$query = "SELECT * FROM $t_edb_case_statuses_district_case_counter LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_statuses_district_case_counter: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_case_statuses_district_case_counter(
	  district_case_counter_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(district_case_counter_id), 
	   district_case_counter_district_id INT,
	   district_case_counter_status_id INT,
	   district_case_counter_number_of_cases_now INT)")
	   or die(mysqli_error());	
	

}
echo"
<!-- //edb_case_statuses_district_case_counter -->


<!-- edb_case_statuses_station_case_counter -->
";

$query = "SELECT * FROM $t_edb_case_statuses_station_case_counter LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_statuses_station_case_counter: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_case_statuses_station_case_counter(
	  station_case_counter_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(station_case_counter_id), 
	   station_case_counter_station_id INT,
	   station_case_counter_status_id INT,
	   station_case_counter_number_of_cases_now INT)")
	   or die(mysqli_error());	
	

}
echo"
<!-- //edb_case_statuses_station_case_counter -->


<!-- edb_case_statuses_user_case_counter -->
";

$query = "SELECT * FROM $t_edb_case_statuses_user_case_counter LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_statuses_user_case_counter: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_case_statuses_user_case_counter (
	  user_case_counter_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(user_case_counter_id), 
	   user_case_counter_district_id INT,
	   user_case_counter_station_id INT,
	   user_case_counter_user_id INT,
	   user_case_counter_number_of_cases_now INT)")
	   or die(mysqli_error());	
	

}
echo"
<!-- //edb_case_statuses_user_case_counter -->




<!-- edb_case_priorities-->
";

$query = "SELECT * FROM $t_edb_case_priorities LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_priorities: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_case_priorities(
	  priority_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(priority_id), 
	   priority_title VARCHAR(200), 
	   priority_title_clean VARCHAR(200), 
	   priority_bg_color VARCHAR(200), 
	   priority_border_color VARCHAR(200), 
	   priority_text_color VARCHAR(200), 
	   priority_link_color VARCHAR(200), 
	   priority_icon_path VARCHAR(200), 
	   priority_icon_file VARCHAR(200), 
	   priority_weight INT, 
	   priority_number_of_cases_now INT, 
	   priority_last_used_datetime DATETIME, 
	   priority_last_used_time VARCHAR(200), 
	   priority_times_used INT
	   )")
	   or die(mysqli_error());	
	
	mysqli_query($link, "INSERT INTO $t_edb_case_priorities
	(priority_id, priority_title, priority_title_clean, priority_bg_color, priority_border_color, priority_text_color, priority_link_color, priority_icon_path, priority_icon_file, priority_weight, priority_number_of_cases_now) 
	VALUES 
	(NULL, 'H&oslash;y', 'hoy', '#cc0000', '#f2bfbf', '#000000', '#5673af', '_uploads/edb/priority_icons', 'high.png', 1, 0),
	(NULL, 'Middels', 'middels', '#ff9933', '#ffe6cc', '#000000', '#5673af', '_uploads/edb/priority_icons', 'medium.png', 1, 0),
	(NULL, 'Lav', 'lav', '#66cc33', '#ffffff',  '#0000000', '#5673af', '_uploads/edb/priority_icons', 'low.png', 1, 0)
	") or die(mysqli_error($link));

}
echo"
<!-- //edb_case_priorities -->
<!-- edb_case_reports -->
";

$query = "SELECT * FROM $t_edb_case_reports LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_reports: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_case_reports(
	  report_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(report_id), 
	   report_title VARCHAR(200), 
	   report_title_clean VARCHAR(200), 
	   report_logo_path VARCHAR(200), 
	   report_logo_file VARCHAR(200), 
	   report_type VARCHAR(200)
	   )")
	   or die(mysqli_error());	
	
	mysqli_query($link, "INSERT INTO $t_edb_case_reports
	(report_id, report_title, report_title_clean, report_logo_path, report_logo_file, report_type) 
	VALUES 
	(NULL, 'Sikringsrapport', 'sikringsrapport', '_uploads/edb/reports', 'sikringsrapport.png', 'acquire_report')
	") or die(mysqli_error($link));

}
echo"
<!-- //edb_case_reports -->



<!-- edb_case_index_search_book -->
";

$query = "SELECT * FROM $t_edb_glossaries LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_glossaries: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_glossaries(
	  glossary_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(glossary_id), 
	   glossary_title VARCHAR(200), 
	   glossary_description TEXT, 
	   glossary_words TEXT, 
	   glossary_last_used_datetime DATETIME
	   )")
	   or die(mysqli_error());

	$inp_overgrepsutrykk ="grep:'(\s)'loll(as|ies|y)'(\s)'
lordofthering
grep:'(_|-|\s)'ls magazine'(\s|-|_)'
maffiasex
mafiasex
grep:'(_|-|\s)'mylola'(\s|-|_)'
nextdoorlola
grep:'(_|-|\s)'nymph(et)'(\s|-|_)'
grep:'(_|-|\s)'paedo'(\s|-|_)'
grep:'(_|-|\s)'pedo'(\s|-|_)'
grep:pedo(fil|phil)
grep:'(_|-|\s)'petting'(\s|-|_)'
grep:'(_|-|\s)'pink teens'(\s|-|_)'
grep:'(_|-|\s)'plenity'(\s|-|_)'
grep:'(_|-|\s)'pre-teen'(\s|-|_)'
grep:'(_|-|\s)'preteen'(\s|-|_)'
grep:'(_|-|\s)'PTHC'(\s|-|_)'
qqaazz
grep:'(_|-|\s)'raped'(\s|-|_)'
grep:r(@|a)ygold
grep:real(kiddy|lola)
reelkid
grep:'(_|-|\s)'step daughter'(_|-|\s)'
grep:'(_|-|\s)'taboo'(_|-|\s)'
grep:'(_|-|\s)'toddler'(_|-|\s)'
grep:'(_|-|\s)'underage'(_|-|\s)'
grep:'(_|-|\s)'video angels'(_|-|\s)'
vladmodels
grep:'(_|-|\s)'yamad'(_|-|\s)'
youngvideomodels
zadoom";
	$inp_overgrepsutrykk_mysql = quote_smart($link, $inp_overgrepsutrykk);

	mysqli_query($link, "INSERT INTO $t_edb_glossaries
	(glossary_id, glossary_title, glossary_words) 
	VALUES 
	(NULL, 'IP', '(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)'),
	(NULL, 'Counter mail passord', '\xC8\x42\xFD\x38\x14\x00\x00\x00.+\x01\x00\x00\x00\xC8\x42\xFD\x38'),
	(NULL, 'MAC adresser', '[0-9A-F]{2,2}(:[0-9A-F]{2,2}){5,5}'),
	(NULL, 'E-postadresser', '\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,6}\b'),
	(NULL, 'Overgrepsutrykk', $inp_overgrepsutrykk_mysql)
	") or die(mysqli_error($link));

}
echo"
<!-- //edb_case_index_search_book -->

";
?>