<?php
/**
*
* File: _admin/_inc/edb/_liquibase/item/002d_item_information.php
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

$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_edb_case_index_item_info_groups") or die(mysqli_error($link)); 
$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_edb_case_index_item_info_level_a") or die(mysqli_error($link)); 
$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_edb_case_index_item_info_level_b") or die(mysqli_error($link)); 
$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_edb_case_index_item_info_level_c") or die(mysqli_error($link)); 
$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_edb_case_index_item_info_level_d") or die(mysqli_error($link)); 

echo"



<!-- edb_case_index_item_info_groups -->
";

$query = "SELECT * FROM $t_edb_case_index_item_info_groups LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_item_info_groups: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_case_index_item_info_groups(
	  group_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(group_id), 
	   group_case_id INT,
	   group_item_id INT,
	   group_title VARCHAR(250), 
	   group_show_on_analysis_report INT, 
	   group_count_level_a INT,
	   group_created_by_user_id INT,
	   group_created_by_user_name VARCHAR(250), 
	   group_created_datetime DATETIME,
	   group_updated_by_user_id INT,
	   group_updated_by_user_name VARCHAR(250), 
	   group_updated_datetime DATETIME
	   )")
	   or die(mysqli_error());
	
}
echo"
<!-- //edb_case_index_item_info_groups -->


<!-- edb_case_index_item_info_level_a -->
";

$query = "SELECT * FROM $t_edb_case_index_item_info_level_a LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_item_info_level_a: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_case_index_item_info_level_a(
	  level_a_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(level_a_id), 
	   level_a_case_id INT,
	   level_a_item_id INT, 
	   level_a_group_id INT, 
	   level_a_title VARCHAR(250), 
	   level_a_value TEXT, 
	   level_a_flag INT, 
	   level_a_flag_checked INT, 
	   level_a_type VARCHAR(250), 
	   level_a_show_on_analysis_report INT,
	   level_a_created_by_user_id INT,
	   level_a_created_by_user_name VARCHAR(250), 
	   level_a_created_datetime DATETIME,
	   level_a_updated_by_user_id INT,
	   level_a_updated_by_user_name VARCHAR(250), 
	   level_a_updated_datetime DATETIME
	   )")
	   or die(mysqli_error());
	
}
echo"
<!-- //edb_case_index_item_info_level_a -->


<!-- edb_case_index_item_info_level_b -->
";

$query = "SELECT * FROM $t_edb_case_index_item_info_level_b LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_item_info_level_b: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_case_index_item_info_level_b(
	  level_b_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(level_b_id), 
	   level_b_case_id INT,
	   level_b_item_id INT, 
	   level_b_group_id INT, 
	   level_b_level_a_id INT,
	   level_b_title VARCHAR(250), 
	   level_b_value TEXT,
	   level_b_flag INT, 
	   level_b_flag_checked INT, 
	   level_b_type VARCHAR(250), 
	   level_b_show_on_analysis_report INT,
	   level_b_created_by_user_id INT,
	   level_b_created_by_user_name VARCHAR(250), 
	   level_b_created_datetime DATETIME,
	   level_b_updated_by_user_id INT,
	   level_b_updated_by_user_name VARCHAR(250), 
	   level_b_updated_datetime DATETIME
	   )")
	   or die(mysqli_error());
	
}
echo"
<!-- //edb_case_index_item_info_level_b -->

<!-- edb_case_index_item_info_level_c -->
";

$query = "SELECT * FROM $t_edb_case_index_item_info_level_c LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_item_info_level_c: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_case_index_item_info_level_c(
	  level_c_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(level_c_id), 
	   level_c_case_id INT,
	   level_c_item_id INT, 
	   level_c_group_id INT, 
	   level_c_level_a_id INT,
	   level_c_level_b_id INT,
	   level_c_title VARCHAR(250), 
	   level_c_value TEXT, 
	   level_c_flag INT, 
	   level_c_flag_checked INT, 
	   level_c_type VARCHAR(250), 
	   level_c_show_on_analysis_report INT,
	   level_c_created_by_user_id INT,
	   level_c_created_by_user_name VARCHAR(250), 
	   level_c_created_datetime DATETIME,
	   level_c_updated_by_user_id INT,
	   level_c_updated_by_user_name VARCHAR(250), 
	   level_c_updated_datetime DATETIME
	   )")
	   or die(mysqli_error());
	
}
echo"
<!-- //edb_case_index_item_info_level_c -->

<!-- edb_case_index_item_info_level_d -->
";

$query = "SELECT * FROM $t_edb_case_index_item_info_level_d LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_item_info_level_d: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_case_index_item_info_level_d(
	  level_d_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(level_d_id), 
	   level_d_case_id INT,
	   level_d_item_id INT, 
	   level_d_group_id INT, 
	   level_d_level_a_id INT,
	   level_d_level_b_id INT,
	   level_d_level_c_id INT,
	   level_d_title VARCHAR(250), 
	   level_d_value TEXT, 
	   level_d_flag INT, 
	   level_d_flag_checked INT, 
	   level_d_type VARCHAR(250), 
	   level_d_show_on_analysis_report INT,
	   level_d_created_by_user_id INT,
	   level_d_created_by_user_name VARCHAR(250), 
	   level_d_created_datetime DATETIME,
	   level_d_updated_by_user_id INT,
	   level_d_updated_by_user_name VARCHAR(250), 
	   level_d_updated_datetime DATETIME
	   )")
	   or die(mysqli_error());
	
}
echo"
<!-- //edb_case_index_item_info_level_d -->



";
?>