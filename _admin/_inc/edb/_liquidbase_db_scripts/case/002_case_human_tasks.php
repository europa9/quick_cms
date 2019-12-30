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

<!-- edb_case_index_human_tasks -->
";

$query = "SELECT * FROM $t_edb_case_index_human_tasks LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_human_tasks: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_human_tasks(
	  human_task_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(human_task_id), 
	   human_task_case_id INT,
	   human_task_case_number INT,
	   human_task_evidence_record_id INT,
	   human_task_evidence_item_id INT,
	   human_task_district_id INT,
	   human_task_district_title VARCHAR(200), 
	   human_task_station_id INT,
	   human_task_station_title VARCHAR(200), 
	   human_task_text VARCHAR(200), 
	   human_task_priority_id INT,
	   human_task_priority_title VARCHAR(200), 
	   human_task_created_datetime DATETIME, 
	   human_task_created_date DATE, 
	   human_task_created_time VARCHAR(200), 
	   human_task_created_date_saying VARCHAR(200), 
	   human_task_created_date_ddmmyy VARCHAR(200), 
	   human_task_created_date_ddmmyyyy VARCHAR(200), 
	  
	   human_task_deadline_date DATE, 
	   human_task_deadline_time VARCHAR(200), 
	   human_task_deadline_date_saying VARCHAR(200), 
	   human_task_deadline_date_ddmmyy VARCHAR(200), 
	   human_task_deadline_date_ddmmyyyy VARCHAR(200), 
	   human_task_deadline_week INT, 
	   human_task_sent_deadline_notification INT, 

	   human_task_is_finished INT, 
	   human_task_finished_datetime DATETIME, 
	   human_task_finished_date DATE, 
	   human_task_finished_time VARCHAR(200), 
	   human_task_finished_date_saying VARCHAR(200), 
	   human_task_finished_date_ddmmyy VARCHAR(200), 
	   human_task_finished_date_ddmmyyyy VARCHAR(200), 

	   human_task_created_by_user_id INT, 
	   human_task_created_by_user_rank VARCHAR(200), 
	   human_task_created_by_user_name VARCHAR(200), 
	   human_task_created_by_user_alias VARCHAR(200), 
	   human_task_created_by_user_email VARCHAR(200), 
	   human_task_created_by_user_image_path VARCHAR(200), 
	   human_task_created_by_user_image_file VARCHAR(200), 
	   human_task_created_by_user_image_thumb_40 VARCHAR(200), 
	   human_task_created_by_user_image_thumb_50 VARCHAR(200), 
	   human_task_created_by_user_first_name VARCHAR(200), 
	   human_task_created_by_user_middle_name VARCHAR(200), 
	   human_task_created_by_user_last_name VARCHAR(200), 

	   human_task_responsible_user_id INT, 
	   human_task_responsible_user_name VARCHAR(200), 
	   human_task_responsible_user_alias VARCHAR(200), 
	   human_task_responsible_user_email VARCHAR(200), 
	   human_task_responsible_user_image_path VARCHAR(200), 
	   human_task_responsible_user_image_file VARCHAR(200), 
	   human_task_responsible_user_image_thumb_40 VARCHAR(200), 
	   human_task_responsible_user_image_thumb_50 VARCHAR(200), 
	   human_task_responsible_user_first_name VARCHAR(200), 
	   human_task_responsible_user_middle_name VARCHAR(200), 
	   human_task_responsible_user_last_name VARCHAR(200))")
	   or die(mysqli_error());
}
echo"
<!-- //edb_case_index_human_tasks -->


<!-- edb_case_index_human_tasks_responsible_users -->
";

$query = "SELECT * FROM $t_edb_case_index_human_tasks_responsible_counters LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_human_tasks_responsible_counters: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_human_tasks_responsible_counters(
	  counter_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(counter_id), 
	   counter_user_id INT, 
	   counter_user_name VARCHAR(200), 
	   counter_user_alias VARCHAR(200), 
	   counter_user_email VARCHAR(200), 
	   counter_user_image_path VARCHAR(200), 
	   counter_user_image_file VARCHAR(200), 
	   counter_user_image_thumb_40 VARCHAR(200), 
	   counter_user_image_thumb_50 VARCHAR(200), 
	   counter_user_first_name VARCHAR(200), 
	   counter_user_middle_name VARCHAR(200), 
	   counter_user_last_name VARCHAR(200), 
	   counter_number_of_tasks INT)")
	   or die(mysqli_error());
}
echo"
<!-- //edb_case_index_human_tasks_responsible_counters  -->
";
?>