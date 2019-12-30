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

$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_edb_case_index_automated_tasks") or die(mysqli_error($link)); 

echo"

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
	   automated_task_mirror_file_path_windows VARCHAR(200), 
	   automated_task_mirror_file_path_linux VARCHAR(200), 
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
	  
	   automated_task_last_status_msg TEXT,
	   automated_task_last_status_datetime DATETIME, 
	   automated_task_last_status_saying VARCHAR(200), 
	   automated_task_last_status_ddmmyyhi VARCHAR(200), 
	   automated_task_last_status_ddmmyyyyhi VARCHAR(200), 

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
";
?>