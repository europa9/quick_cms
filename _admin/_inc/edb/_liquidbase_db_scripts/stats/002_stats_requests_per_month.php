<?php
/**
*
* File: _admin/_inc/edb/_liquibase/stats/002_stats_requests_per_month.php
* Version 1.0.0
* Date 14:07 07.11.2019
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


<!-- edb_stats_requests_user_per_month -->
";

$query = "SELECT * FROM $t_edb_stats_requests_user_per_month LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_stats_requests_user_per_month: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_stats_requests_user_per_month (
	  stats_req_usr_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(stats_req_usr_id), 
	   stats_req_usr_year INT,
	   stats_req_usr_month INT,
	   stats_req_usr_district_id INT,
	   stats_req_usr_station_id INT,
	   stats_req_usr_user_id INT,
	   stats_req_usr_user_name VARCHAR(200), 
	   stats_req_usr_user_alias VARCHAR(200), 
	   stats_req_usr_user_first_name VARCHAR(200), 
	   stats_req_usr_user_middle_name VARCHAR(200), 
	   stats_req_usr_user_last_name VARCHAR(200), 
	   stats_req_usr_user_position VARCHAR(200),
	   stats_req_usr_user_department VARCHAR(200),
	   stats_req_usr_user_location VARCHAR(200),
	   stats_req_usr_counter INT
	   )")
	   or die(mysqli_error());

}
echo"
<!-- //edb_stats_requests_user_per_month -->



<!-- edb_stats_requests_user_case_codes_per_month -->
";

$query = "SELECT * FROM $t_edb_stats_requests_user_case_codes_per_month LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_stats_requests_user_case_codes_per_month: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_stats_requests_user_case_codes_per_month (
	  stats_usr_case_code_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(stats_usr_case_code_id), 
	   stats_usr_case_code_year INT,
	   stats_usr_case_code_month INT,
	   stats_usr_case_code_district_id INT,
	   stats_usr_case_code_station_id INT,
	   stats_usr_case_code_user_id INT,
	   stats_usr_case_code_case_code_id INT, 
	   stats_usr_case_code_case_code_number INT, 
	   stats_usr_case_code_case_code_title VARCHAR(200),
	   stats_usr_case_code_priority_id INT, 
	   stats_usr_case_code_priority_title VARCHAR(200),
	   stats_usr_case_code_line_color VARCHAR(50),
	   stats_usr_case_code_fill_color VARCHAR(50),
	   stats_usr_case_code_counter INT
	   )")
	   or die(mysqli_error());

}
echo"
<!-- //edb_stats_requests_user_case_codes_per_month -->


<!-- edb_stats_requests_user_item_types_per_month -->
";

$query = "SELECT * FROM $t_edb_stats_requests_user_item_types_per_month LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_stats_requests_user_item_types_per_month: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_stats_requests_user_item_types_per_month (
	  stats_usr_item_type_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(stats_usr_item_type_id), 
	   stats_usr_item_type_year INT,
	   stats_usr_item_type_month INT,
	   stats_usr_item_type_district_id INT,
	   stats_usr_item_type_station_id INT,
	   stats_usr_item_type_user_id INT,
	   stats_usr_item_type_item_type_id INT, 
	   stats_usr_item_type_item_type_title VARCHAR(200),
	   stats_usr_item_type_line_color VARCHAR(50),
	   stats_usr_item_type_fill_color VARCHAR(50),
	   stats_usr_item_type_counter INT
	   )")
	   or die(mysqli_error());

}
echo"
<!-- //edb_stats_requests_user_item_types_per_month -->


<!-- edb_stats_requests_department_per_month-->
";

$query = "SELECT * FROM $t_edb_stats_requests_department_per_month LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_stats_requests_department_per_month: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_stats_requests_department_per_month (
	  stats_req_dep_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(stats_req_dep_id), 
	   stats_req_dep_year INT,
	   stats_req_dep_month INT,
	   stats_req_dep_district_id INT,
	   stats_req_dep_station_id INT,
	   stats_req_dep_department VARCHAR(200),
	   stats_req_dep_location VARCHAR(200),
	   stats_req_dep_counter INT
	   )")
	   or die(mysqli_error());

}
echo"
<!-- //edb_stats_requests_department_per_month -->



<!-- edb_stats_requests_department_case_codes_per_month -->
";

$query = "SELECT * FROM $t_edb_stats_requests_department_case_codes_per_month LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_stats_requests_department_case_codes_per_month: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_stats_requests_department_case_codes_per_month (
	  stats_dep_case_code_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(stats_dep_case_code_id), 
	   stats_dep_case_code_year INT,
	   stats_dep_case_code_month INT,
	   stats_dep_case_code_district_id INT,
	   stats_dep_case_code_station_id INT,
	   stats_dep_case_code_department VARCHAR(200),
	   stats_dep_case_code_location VARCHAR(200),
	   stats_dep_case_code_case_code_id INT, 
	   stats_dep_case_code_case_code_number INT, 
	   stats_dep_case_code_case_code_title VARCHAR(200),
	   stats_dep_case_code_priority_id INT, 
	   stats_dep_case_code_priority_title VARCHAR(200),
	   stats_dep_case_code_line_color VARCHAR(50),
	   stats_dep_case_code_fill_color VARCHAR(50),
	   stats_dep_case_code_counter INT
	   )")
	   or die(mysqli_error());

}
echo"
<!-- //edb_stats_requests_department_case_codes_per_month -->



<!-- edb_stats_requests_department_item_types_per_month -->
";

$query = "SELECT * FROM $t_edb_stats_requests_department_item_types_per_month LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_stats_requests_department_item_types_per_month: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_stats_requests_department_item_types_per_month (
	  stats_dep_item_type_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(stats_dep_item_type_id), 
	   stats_dep_item_type_year INT,
	   stats_dep_item_type_month INT,
	   stats_dep_item_type_district_id INT,
	   stats_dep_item_type_station_id INT,
	   stats_dep_item_type_department VARCHAR(200),
	   stats_dep_item_type_location VARCHAR(200),
	   stats_dep_item_type_item_type_id INT, 
	   stats_dep_item_type_item_type_title VARCHAR(200),
	   stats_dep_item_type_line_color VARCHAR(50),
	   stats_dep_item_type_fill_color VARCHAR(50),
	   stats_dep_item_type_counter INT
	   )")
	   or die(mysqli_error());

}
echo"
<!-- //edb_stats_requests_department_item_types_per_month -->
";
?>