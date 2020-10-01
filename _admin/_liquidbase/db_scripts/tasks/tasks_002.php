<?php
if(isset($_SESSION['admin_user_id'])){


	$t_tasks_index  		= $mysqlPrefixSav . "tasks_index";
	$t_tasks_status_codes  		= $mysqlPrefixSav . "tasks_status_codes";
	$t_tasks_projects  		= $mysqlPrefixSav . "tasks_projects";
	$t_tasks_projects_parts  	= $mysqlPrefixSav . "tasks_projects_parts";
	$t_tasks_systems  		= $mysqlPrefixSav . "tasks_systems";
	$t_tasks_systems_parts  	= $mysqlPrefixSav . "tasks_systems_parts";
	$t_tasks_read			= $mysqlPrefixSav . "tasks_read";
	$t_tasks_subscribers  		= $mysqlPrefixSav . "tasks_subscribers";
	$t_tasks_history		= $mysqlPrefixSav . "tasks_history";
	$t_tasks_last_used_systems	= $mysqlPrefixSav . "tasks_last_used_systems";
	$t_tasks_last_used_projects	= $mysqlPrefixSav . "tasks_last_used_projects";


	mysqli_query($link,"DROP TABLE IF EXISTS $t_tasks_index") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_tasks_status_codes") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_tasks_projects") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_tasks_projects_parts") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_tasks_systems") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_tasks_systems_parts") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_tasks_read") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_tasks_subscribers") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_tasks_history") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_tasks_last_used_systems") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_tasks_last_used_projects") or die(mysqli_error());


$query = "SELECT * FROM $t_tasks_index LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_tasks_index(
	   task_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(task_id), 
	   task_system_task_abbr VARCHAR(200),
	   task_system_incremented_number INT,
	   task_project_task_abbr VARCHAR(200),
	   task_project_incremented_number INT,
	   task_title VARCHAR(200),
	   task_text TEXT,
	   task_solution TEXT,
	   task_qa TEXT,
	   task_status_code_id INT,
	   task_status_code_title VARCHAR(200),
	   task_priority_id INT,
	   task_created_datetime DATETIME,
	   task_created_translated VARCHAR(200),
	   task_created_by_user_id INT,
	   task_created_by_user_name VARCHAR(200),
	   task_created_by_user_alias VARCHAR(200),
	   task_created_by_user_image VARCHAR(200),
	   task_created_by_user_thumb_40 VARCHAR(200),
	   task_created_by_user_thumb_50 VARCHAR(200),
	   task_created_by_user_email VARCHAR(200),
	   task_system_id INT,
	   task_system_title VARCHAR(200),
	   task_system_part_id INT,
	   task_system_part_title VARCHAR(200),
	   task_project_id INT,
	   task_project_title VARCHAR(200),
	   task_project_part_id INT,
	   task_project_part_title VARCHAR(200),
	   task_updated_datetime DATETIME,
	   task_updated_translated VARCHAR(200),
	   task_due_datetime DATETIME,
	   task_due_time VARCHAR(200),
	   task_due_translated VARCHAR(200),
	   task_due_warning_sent INT,
	   task_assigned_to_user_id INT,
	   task_assigned_to_user_name VARCHAR(200),
	   task_assigned_to_user_alias VARCHAR(200),
	   task_assigned_to_user_image VARCHAR(200),
	   task_assigned_to_user_thumb_40 VARCHAR(200),
	   task_assigned_to_user_thumb_50 VARCHAR(200),
	   task_assigned_to_user_email VARCHAR(200),
	   task_hours_planned VARCHAR(20),
	   task_hours_used VARCHAR(20),
	   task_hours_diff_number VARCHAR(20),
	   task_hours_diff_percentage VARCHAR(20),
	   task_qa_datetime DATETIME,
	   task_qa_by_user_id INT,
	   task_qa_by_user_name VARCHAR(200),
	   task_qa_by_user_alias VARCHAR(200),
	   task_qa_by_user_image VARCHAR(200),
	   task_qa_by_user_thumb_40 VARCHAR(200),
	   task_qa_by_user_thumb_50 VARCHAR(200),
	   task_qa_by_user_email VARCHAR(200),
	   task_finished_is_finished INT,
	   task_finished_datetime DATETIME,
	   task_finished_year INT,
	   task_finished_month INT,
	   task_finished_month_saying VARCHAR(20),
	   task_finished_week INT,
	   task_finished_by_user_id INT,
	   task_finished_by_user_name VARCHAR(200),
	   task_finished_by_user_alias VARCHAR(200),
	   task_finished_by_user_image VARCHAR(200),
	   task_finished_by_user_thumb_40 VARCHAR(200),
	   task_finished_by_user_thumb_50 VARCHAR(200),
	   task_finished_by_user_email VARCHAR(200),
	   task_is_archived INT,
	   task_comments INT
		)")
	or die(mysqli_error($link));
}


$query = "SELECT * FROM $t_tasks_status_codes LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_tasks_status_codes(
	   status_code_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(status_code_id), 
	   status_code_title VARCHAR(200),
	   status_code_text_color VARCHAR(200),
	   status_code_bg_color VARCHAR(200),
	   status_code_border_color VARCHAR(200),
	   status_code_weight INT,
	   status_code_show_on_board INT,
	   status_code_on_status_close_task INT,
	   status_code_count_tasks INT)")
	or die(mysqli_error($link));

	// Tasks: Blue #b2def7
	// Ongoing: Orange #faa64b
	// Blocked: Red #f96868
	// Quality assurance: Pink #efb3e6
	// Finished: Green #15c377
	mysqli_query($link, "INSERT INTO $t_tasks_status_codes
	(status_code_id, status_code_title, status_code_text_color, status_code_weight, status_code_show_on_board, status_code_on_status_close_task, status_code_count_tasks) 
	VALUES 
	(NULL, 'Tasks', '#b2def7', '1', 1, 0, '0'),
	(NULL, 'Ongoing', '#faa64b', '2',  1, 0, '0'),
	(NULL, 'Blocked', '#f96868', '3',  1, 0, '0'),
	(NULL, 'Quality assurance', '#efb3e6', '4',  1, 0, '0'),
	(NULL, 'Finished', '#15c377', '5',  0, 1, '0')")
	or die(mysqli_error($link));
}

$query = "SELECT * FROM $t_tasks_systems LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_tasks_systems(
	   system_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(system_id), 
	   system_title VARCHAR(200),
	   system_task_abbr VARCHAR(200),
	   system_description TEXT,
	   system_logo VARCHAR(200),
	   system_is_active INT,
	   system_increment_tasks_counter INT,
	   system_created DATETIME,
	   system_updated DATETIME)")
	or die(mysqli_error($link));

	mysqli_query($link, "INSERT INTO $t_tasks_systems
	(system_id, system_title, system_task_abbr, system_description, system_logo, system_is_active, system_increment_tasks_counter) 
	VALUES 
	(NULL, 'Website', 'SWCR', 'This webside', 'website.jpg', 1, 1)")
	or die(mysqli_error($link));


}

$query = "SELECT * FROM $t_tasks_systems_parts LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_tasks_systems_parts(
	  system_part_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(system_part_id), 
	   system_part_system_id INT,
	   system_part_title VARCHAR(200),
	   system_part_description TEXT,
	   system_part_logo VARCHAR(200),
	   system_part_is_active INT,
	   system_part_created DATETIME,
	   system_part_updated DATETIME)")
	or die(mysqli_error($link));

	/*
	mysqli_query($link, "INSERT INTO $t_tasks_systems_parts
	(system_part_id, system_part_system_id, system_part_title, system_part_description, system_part_logo, system_part_is_active) 
	VALUES 
	(NULL, 1, 'Recipes', 'Recipes part', 'recipes.jpg', 1),
	(NULL, 2, 'Android', 'Android app', 'android.jpg', 1),
	(NULL, 2, 'iPhone', 'iPhone app', 'iphone.jpg', 1)")
	or die(mysqli_error($link));
	*/
}


$query = "SELECT * FROM $t_tasks_projects LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_tasks_projects(
	   project_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(project_id), 
	   project_system_id INT,
	   project_title VARCHAR(200),
	   project_task_abbr VARCHAR(200),
	   project_description TEXT,
	   project_logo VARCHAR(200),
	   project_is_active INT,
	   project_increment_tasks_counter INT,
	   project_created DATETIME,
	   project_updated DATETIME)")
	or die(mysqli_error($link));


	mysqli_query($link, "INSERT INTO $t_tasks_projects
	(project_id, project_system_id, project_title, project_is_active, project_increment_tasks_counter) 
	VALUES 
	(NULL, '1', 'New website', 1, 1)")
	or die(mysqli_error($link));

}

$query = "SELECT * FROM $t_tasks_projects_parts LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_tasks_projects_parts(
	   project_part_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(project_part_id), 
	   project_part_project_id INT,
	   project_part_system_id INT,
	   project_part_title VARCHAR(200),
	   project_part_description TEXT,
	   project_part_logo VARCHAR(200),
	   project_part_is_active INT,
	   project_part_created DATETIME,
	   project_part_updated DATETIME)")
	or die(mysqli_error($link));
}


$query = "SELECT * FROM $t_tasks_read LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_tasks_read(
	   read_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(read_id), 
	   read_task_id INT,
	   read_user_id INT)")
	or die(mysqli_error($link));
}


$query = "SELECT * FROM $t_tasks_history LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_tasks_history(
	   history_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(history_id), 
	   history_task_id INT,
	   history_updated_by_user_id INT,
	   history_updated_by_user_name VARCHAR(200),
	   history_updated_by_user_alias VARCHAR(200),
	   history_updated_by_user_email VARCHAR(200),
	   history_updated_datetime DATETIME,
	   history_updated_datetime_saying VARCHAR(200),
	   history_summary TEXT,
	   history_new_title VARCHAR(200),
	   history_new_text TEXT,
	   history_new_status_code_id INT,
	   history_new_status_code_title VARCHAR(200),
	   history_new_priority_id INT,
	   history_new_assigned_to_user_id INT,
	   history_new_assigned_to_user_name VARCHAR(200),
	   history_new_assigned_to_user_alias VARCHAR(200),
	   history_new_assigned_to_user_image VARCHAR(200),
	   history_new_assigned_to_user_email VARCHAR(200),
	   history_new_hours_planned INT,
	   history_new_hours_used INT
	)")
	or die(mysqli_error($link));
}


$query = "SELECT * FROM $t_tasks_last_used_systems LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_tasks_last_used_systems(
	   last_used_system_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(last_used_system_id), 
	   last_used_system_user_id INT,
	   last_used_system_system_id INT
	)")
	or die(mysqli_error($link));
}

$query = "SELECT * FROM $t_tasks_last_used_projects LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
}
else{
	mysqli_query($link, "CREATE TABLE $t_tasks_last_used_projects(
	   last_used_project_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(last_used_project_id), 
	   last_used_project_user_id INT,
	   last_used_project_project_id INT
	)")
	or die(mysqli_error($link));
}

}
?>