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

/*- Tables ---------------------------------------------------------------------------- */
$t_edb_most_used_passwords_login_users 		= $mysqlPrefixSav . "edb_most_used_passwords_login_users";
$t_edb_most_used_passwords_login_passwords 	= $mysqlPrefixSav . "edb_most_used_passwords_login_passwords";
$t_edb_most_used_passwords_startup_passwords  	= $mysqlPrefixSav . "edb_most_used_passwords_startup_passwords";
$t_edb_most_used_passwords_pins 		= $mysqlPrefixSav . "edb_most_used_passwords_pins";
$t_edb_most_used_passwords_unlock_patterns  	= $mysqlPrefixSav . "edb_most_used_passwords_unlock_patterns";


echo"

<!-- edb_most_used_passwords_login_users -->
";

$query = "SELECT * FROM $t_edb_most_used_passwords_login_users LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_most_used_passwords_login_users: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_most_used_passwords_login_users(
	  password_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(password_id), 
	   password_number INT,
	   password_pass VARCHAR(200), 
	   password_count INT, 
	   password_first_used_datetime DATETIME, 
	   password_first_used_time VARCHAR(200), 
	   password_first_used_saying VARCHAR(200), 
	   password_last_used_datetime DATETIME, 
	   password_last_used_time VARCHAR(200), 
	   password_last_used_saying VARCHAR(200))")
	   or die(mysqli_error());


}
echo"
<!-- //edb_most_used_passwords_login_users -->

<!-- edb_most_used_passwords_login_passwords -->
";

$query = "SELECT * FROM $t_edb_most_used_passwords_login_passwords LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_most_used_passwords_login_passwords: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_most_used_passwords_login_passwords(
	  password_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(password_id), 
	   password_number INT,
	   password_pass VARCHAR(200), 
	   password_count INT, 
	   password_first_used_datetime DATETIME, 
	   password_first_used_time VARCHAR(200), 
	   password_first_used_saying VARCHAR(200), 
	   password_last_used_datetime DATETIME, 
	   password_last_used_time VARCHAR(200), 
	   password_last_used_saying VARCHAR(200))")
	   or die(mysqli_error());
}
echo"
<!-- //edb_most_used_passwords_login_passwords -->

<!-- edb_most_used_passwords_startup_passwords -->
";

$query = "SELECT * FROM $t_edb_most_used_passwords_startup_passwords LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_most_used_passwords_startup_passwords: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_most_used_passwords_startup_passwords(
	  password_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(password_id), 
	   password_number INT,
	   password_pass VARCHAR(200), 
	   password_count INT, 
	   password_first_used_datetime DATETIME, 
	   password_first_used_time VARCHAR(200), 
	   password_first_used_saying VARCHAR(200), 
	   password_last_used_datetime DATETIME, 
	   password_last_used_time VARCHAR(200), 
	   password_last_used_saying VARCHAR(200))")
	   or die(mysqli_error());
}
echo"
<!-- //edb_most_used_passwords_startup_passwords -->

<!-- edb_most_used_passwords_pins -->
";

$query = "SELECT * FROM $t_edb_most_used_passwords_pins LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_most_used_passwords_pins: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_most_used_passwords_pins(
	  password_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(password_id), 
	   password_number INT,
	   password_pass VARCHAR(200), 
	   password_count INT, 
	   password_first_used_datetime DATETIME, 
	   password_first_used_time VARCHAR(200), 
	   password_first_used_saying VARCHAR(200), 
	   password_last_used_datetime DATETIME, 
	   password_last_used_time VARCHAR(200), 
	   password_last_used_saying VARCHAR(200))")
	   or die(mysqli_error());
}
echo"
<!-- //edb_most_used_passwords_pins -->

<!-- edb_most_used_passwords_unlock_patterns -->
";

$query = "SELECT * FROM $t_edb_most_used_passwords_unlock_patterns LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_most_used_passwords_unlock_patterns: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_most_used_passwords_unlock_patterns(
	  password_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(password_id), 
	   password_number INT,
	   password_pass VARCHAR(200), 
	   password_count INT, 
	   password_first_used_datetime DATETIME, 
	   password_first_used_time VARCHAR(200), 
	   password_first_used_saying VARCHAR(200), 
	   password_last_used_datetime DATETIME, 
	   password_last_used_time VARCHAR(200), 
	   password_last_used_saying VARCHAR(200))")
	   or die(mysqli_error());
}
echo"
<!-- //edb_most_used_passwords_unlock_patterns -->

";
?>