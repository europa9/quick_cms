<?php
if(isset($_SESSION['admin_user_id'])){


	$t_tasks_projects  		= $mysqlPrefixSav . "tasks_projects";
	$t_tasks_projects_parts  	= $mysqlPrefixSav . "tasks_projects_parts";
	$t_tasks_systems  		= $mysqlPrefixSav . "tasks_systems";
	$t_tasks_systems_parts  	= $mysqlPrefixSav . "tasks_systems_parts";
	$t_tasks_read			= $mysqlPrefixSav . "tasks_read";
	$t_tasks_subscribers  		= $mysqlPrefixSav . "tasks_subscribers";
	$t_tasks_history		= $mysqlPrefixSav . "tasks_history";
	$t_tasks_last_used_systems	= $mysqlPrefixSav . "tasks_last_used_systems";
	$t_tasks_last_used_projects	= $mysqlPrefixSav . "tasks_last_used_projects";
	mysqli_query($link,"DROP TABLE IF EXISTS $t_tasks_projects") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_tasks_projects_parts") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_tasks_systems") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_tasks_systems_parts") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_tasks_read") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_tasks_subscribers") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_tasks_history") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_tasks_last_used_systems") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_tasks_last_used_projects") or die(mysqli_error());



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