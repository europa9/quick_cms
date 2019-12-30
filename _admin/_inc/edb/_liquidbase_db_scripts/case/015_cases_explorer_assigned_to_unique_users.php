<?php
/**
*
* File: _admin/_inc/edb/_liquibase/case/015_cases_explorer_assigned_to_unique_users
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
<!-- edb_cases_explorer_assigned_to_unique_users -->
";

$query = "SELECT * FROM $t_edb_cases_explorer_assigned_to_unique_users LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_cases_explorer_assigned_to_unique_users: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_cases_explorer_assigned_to_unique_users(
	  assigned_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(assigned_id), 
	   assigned_user_id INT,
	   aassigned_user_name VARCHAR(200), 
	   assigned_user_alias VARCHAR(200), 
	   assigned_user_email VARCHAR(200), 
	   assigned_user_image_path VARCHAR(200), 
	   assigned_user_image_file VARCHAR(200), 
	   assigned_user_image_thumb_40 VARCHAR(200), 
	   assigned_user_image_thumb_50 VARCHAR(200), 
	   assigned_user_first_name VARCHAR(200), 
	   assigned_user_middle_name VARCHAR(200), 
	   assigned_user_last_name VARCHAR(200), 
	   assigned_updated_year INT)")
	   or die(mysqli_error());	

}
echo"
<!-- //edb_cases_explorer_assigned_to_unique_users -->

";
?>