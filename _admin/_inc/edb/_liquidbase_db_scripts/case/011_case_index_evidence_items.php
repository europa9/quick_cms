<?php
/**
*
* File: _admin/_inc/edb/_liquibase/case/011_case_index_evidence_items.php
* Version 1.0.0
* Date 16:02 13.11.2019
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
	   item_title VARCHAR(600), 
	   item_parent_item_id INT,
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
	   item_name VARCHAR(200), 
	   item_domain VARCHAR(200), 
	   item_login_user VARCHAR(200), 
	   item_login_password VARCHAR(200), 
	   item_startup_password VARCHAR(200), 
	   item_screen_lock VARCHAR(200), 
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
	   item_adjust_time_zone_automatically VARCHAR(200), 


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
";
?>