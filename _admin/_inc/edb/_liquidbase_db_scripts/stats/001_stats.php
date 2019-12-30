<?php
/**
*
* File: _admin/_inc/edb/_liquibase/stats/001_stats.php
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


<!-- edb_stats_index -->
";

$query = "SELECT * FROM $t_edb_stats_index LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_stats_index: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_stats_index(
	  stats_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(stats_id), 
	   stats_year INT,
	   stats_month INT,
	   stats_month_saying VARCHAR(100),
	   stats_district_id INT,
	   stats_station_id INT,
	   stats_user_id INT,
	   stats_cases_created INT,
	   stats_cases_closed INT,
	   stats_avg_created_to_close_time VARCHAR(100),
	   stats_avg_created_to_close_days INT,
	   stats_avg_created_to_close_saying VARCHAR(100),
	   stats_last_calculated_day INT
	   )")
	   or die(mysqli_error());

}
echo"
<!-- //edb_stats_index -->

<!-- edb_stats_case_codes -->
";

$query = "SELECT * FROM $t_edb_stats_case_codes LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_stats_case_codes: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_stats_case_codes(
	  stats_case_code_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(stats_case_code_id), 
	   stats_case_code_year INT,
	   stats_case_code_month INT,
	   stats_case_code_district_id INT,
	   stats_case_code_station_id INT,
	   stats_case_code_user_id INT,
	   stats_case_code_code_id INT,
	   stats_case_code_code_title VARCHAR(100),
	   stats_case_code_counter INT
	   )")
	   or die(mysqli_error());

}
echo"
<!-- //edb_stats_case_codes -->

<!-- edb_stats_case_priorites -->
";

$query = "SELECT * FROM $t_edb_stats_case_priorites LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_stats_case_priorites: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_stats_case_priorites(
	  stats_case_priority_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(stats_case_priority_id), 
	   stats_case_priority_year INT,
	   stats_case_priority_month INT,
	   stats_case_priority_district_id INT,
	   stats_case_priority_station_id INT,
	   stats_case_priority_user_id INT,
	   stats_case_priority_priority_id INT,
	   stats_case_priority_priority_title VARCHAR(100),
	   stats_case_priority_counter INT
	   )")
	   or die(mysqli_error());

}
echo"
<!-- //edb_stats_case_priorites -->


<!-- edb_stats_item_types -->
";

$query = "SELECT * FROM $t_edb_stats_item_types LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_stats_item_types: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_stats_item_types(
	  stats_item_type_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(stats_item_type_id), 
	   stats_item_type_year INT,
	   stats_item_type_month INT,
	   stats_item_type_district_id INT,
	   stats_item_type_station_id INT,
	   stats_item_type_user_id INT,
	   stats_item_type_item_type_id INT,
	   stats_item_type_item_type_title VARCHAR(100),
	   stats_item_type_counter INT
	   )")
	   or die(mysqli_error());

}
echo"
<!-- //edb_stats_item_types -->


<!-- edb_stats_statuses_per_day -->
";

$query = "SELECT * FROM $t_edb_stats_statuses_per_day LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_stats_statuses_per_day: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_stats_statuses_per_day (
	  status_per_day_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(status_per_day_id), 
	   status_per_day_year INT,
	   status_per_day_month INT,
	   status_per_day_day INT, 
	   status_per_day_day_saying VARCHAR(100), 
	   status_per_day_district_id INT,
	   status_per_day_station_id INT,
	   status_per_day_user_id INT,
	   status_per_day_status_id INT,
	   status_per_day_status_title VARCHAR(100),
	   status_per_day_weight INT,
	   status_per_day_counter INT,
	   status_per_day_avg_spent_time VARCHAR(100),
	   status_per_day_avg_spent_days INT,
	   status_per_day_avg_spent_saying VARCHAR(100)
	   )")
	   or die(mysqli_error());

}
echo"
<!-- //edb_stats_statuses_per_day -->


<!-- edb_stats_employee_of_the_month -->
";

$query = "SELECT * FROM $t_edb_stats_employee_of_the_month LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_stats_employee_of_the_month: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_stats_employee_of_the_month (
	  employee_of_the_month_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(employee_of_the_month_id), 
	   employee_of_the_month_year INT,
	   employee_of_the_month_month INT,
	   employee_of_the_month_saying VARCHAR(100), 
	   employee_of_the_month_district_id INT,
	   employee_of_the_month_station_id INT,
	   employee_of_the_month_points INT,
	   employee_of_the_month_user_id INT,
	   employee_of_the_month_user_name VARCHAR(200), 
	   employee_of_the_month_user_alias VARCHAR(200), 
	   employee_of_the_month_user_first_name VARCHAR(200), 
	   employee_of_the_month_user_middle_name VARCHAR(200), 
	   employee_of_the_month_user_last_name VARCHAR(200), 
	   employee_of_the_month_user_email VARCHAR(200), 
	   employee_of_the_month_user_image_path VARCHAR(200),
	   employee_of_the_month_user_image_file VARCHAR(200),
	   employee_of_the_month_user_image_thumb_40 VARCHAR(200),
	   employee_of_the_month_user_image_thumb_50 VARCHAR(200),
	   employee_of_the_month_user_image_thumb_200 VARCHAR(200)
	   )")
	   or die(mysqli_error());

}
echo"
<!-- //edb_stats_employee_of_the_month -->
";
?>