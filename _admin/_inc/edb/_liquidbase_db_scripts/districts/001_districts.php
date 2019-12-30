<?php
/**
*
* File: _admin/_inc/edb/_liquibase/districts/001_districts.php
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


<!-- edb_districts_index -->
";

$query = "SELECT * FROM $t_edb_districts_index LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_districts_index: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_districts_index(
	  district_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(district_id), 
	   district_number INT,
	   district_title VARCHAR(200), 
	   district_title_clean VARCHAR(200), 
	   district_icon_path VARCHAR(200), 
	   district_icon_16 VARCHAR(200), 
	   district_icon_32 VARCHAR(200), 
	   district_icon_260 VARCHAR(200), 
	   district_number_of_stations INT, 
	   district_number_of_cases_now INT, 
	   district_number_of_cases_total INT, 
	   district_number_updated DATE
	   )")
	   or die(mysqli_error());	
	
	mysqli_query($link, "INSERT INTO $t_edb_districts_index
	(district_id, district_number, district_title, district_title_clean, district_number_of_stations, district_number_of_cases_now) 
	VALUES 
	(NULL, 201, 'Oslo', 'Oslo', 2, 0),
	(NULL, 202, '&Oslash;st', 'sor-vest', 2, 0),
	(NULL, 203, 'Innlandet', 'innlandet', 2, 0),
	(NULL, 204, 'S&oslash;r-&Oslash;st', 'sor-ost', 2, 0),
	(NULL, 205, 'Agder', 'Agder', 2, 0),
	(NULL, 206, 'S&oslash;r-Vest', 'sor-vest', 2, 0),
	(NULL, 207, 'Vest', 'vest', 2, 0),
	(NULL, 208, 'M&oslash;re og Romsdal', 'more_og_romsdal', 2, 0),
	(NULL, 209, 'Tr&oslash;ndelag', 'trondelag', 2, 0),
	(NULL, 210, 'Nordland', 'nordland', 2, 0),
	(NULL, 211, 'Troms', 'troms', 2, 0),
	(NULL, 212, 'Finnmark', 'finnmark', 2, 0)
	") or die(mysqli_error($link));

}
echo"
<!-- //edb_districts_index -->


<!-- edb_districts_members -->
";

$query = "SELECT * FROM $t_edb_districts_members LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_districts_members: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_districts_members (
	  district_member_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(district_member_id), 
	   district_member_district_id INT, 
	   district_member_district_title VARCHAR(200),
	   district_member_user_id INT, 
	   district_member_rank VARCHAR(200),
	   district_member_user_name VARCHAR(200), 
	   district_member_user_alias VARCHAR(200), 
	   district_member_user_first_name VARCHAR(200), 
	   district_member_user_middle_name VARCHAR(200), 
	   district_member_user_last_name VARCHAR(200), 
	   district_member_user_email VARCHAR(200), 
	   district_member_user_phone VARCHAR(200), 
	   district_member_user_image_path VARCHAR(200),
	   district_member_user_image_file VARCHAR(200),
	   district_member_user_image_thumb_40 VARCHAR(200),
	   district_member_user_image_thumb_50 VARCHAR(200),
	   district_member_user_image_thumb_60 VARCHAR(200),
	   district_member_user_image_thumb_200 VARCHAR(200),
	   district_member_user_position VARCHAR(200),
	   district_member_user_department VARCHAR(200),
	   district_member_user_location VARCHAR(200),
	   district_member_user_about TEXT,
	   district_member_show_on_board INT, 
	   district_member_can_be_jour INT, 
	   district_member_added_datetime DATETIME, 
	   district_member_added_date_saying VARCHAR(200), 
	   district_member_added_by_user_id INT, 
	   district_member_added_by_user_name VARCHAR(200), 
	   district_member_added_by_user_alias VARCHAR(200), 
	   district_member_added_by_user_image VARCHAR(200))")
	   or die(mysqli_error());	



}
echo"
<!-- //edb_districts_members -->

<!-- edb_districts_membership_requests -->
";

$query = "SELECT * FROM $t_edb_districts_membership_requests LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_districts_membership_requests: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_districts_membership_requests (
	  request_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(request_id), 
	   request_district_id INT, 
	   request_district_title VARCHAR(200),
	   request_user_id INT, 
	   request_rank VARCHAR(200),
	   request_user_name VARCHAR(200), 
	   request_user_alias VARCHAR(200), 
	   request_user_first_name VARCHAR(200), 
	   request_user_middle_name VARCHAR(200), 
	   request_user_last_name VARCHAR(200), 
	   request_user_email VARCHAR(200), 
	   request_user_image_path VARCHAR(200),
	   request_user_image_file VARCHAR(200),
	   request_user_image_thumb_40 VARCHAR(200),
	   request_user_image_thumb_50 VARCHAR(200),
	   request_user_image_thumb_60 VARCHAR(200),
	   request_user_image_thumb_200 VARCHAR(200),
	   request_user_position VARCHAR(200),
	   request_user_department VARCHAR(200),
	   request_user_location VARCHAR(200),
	   request_user_about TEXT,
	   request_datetime DATETIME,
	   request_date_saying VARCHAR(200))")
	   or die(mysqli_error());
}
echo"
<!-- //edb_districts_membership_requests -->

<!-- edb_districts_jour -->
";

$query = "SELECT * FROM $t_edb_districts_jour LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_districts_jour: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_districts_jour(
	  jour_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(jour_id), 
	   jour_district_id INT, 
	   jour_district_title VARCHAR(200), 
	   jour_year_week INT, 
	   jour_year INT, 
	   jour_week INT, 
	   jour_from_date DATE, 
	   jour_from_date_saying VARCHAR(200), 
	   jour_from_date_ddmmyy VARCHAR(200), 
	   jour_from_date_ddmmyyyy VARCHAR(100), 
	   jour_user_id INT, 
	   jour_user_name VARCHAR(200), 
	   jour_user_alias VARCHAR(200), 
	   jour_user_first_name VARCHAR(200), 
	   jour_user_middle_name VARCHAR(200), 
	   jour_user_last_name VARCHAR(200), 
	   jour_user_email VARCHAR(200), 
	   jour_user_phone VARCHAR(200), 
	   jour_user_image_path VARCHAR(200),
	   jour_user_image_file VARCHAR(200),
	   jour_user_image_thumb_40 VARCHAR(200),
	   jour_user_image_thumb_50 VARCHAR(200)
	   )")
	   or die(mysqli_error());

}
echo"
<!-- //edb_districts_jour -->


";
?>