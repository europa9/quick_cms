<?php
/**
*
* File: _admin/_inc/edb/_liquibase/stations/001_stations.php
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


<!-- edb_stations_index -->
";

$query = "SELECT * FROM $t_edb_stations_index LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_stations_index: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_stations_index(
	  station_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(station_id), 
	   station_number INT,
	   station_title VARCHAR(200), 
	   station_title_clean VARCHAR(200), 
	   station_district_id INT,
	   station_district_title VARCHAR(200), 
	   station_icon_path VARCHAR(200), 
	   station_icon_16 VARCHAR(200), 
	   station_icon_32 VARCHAR(200), 
	   station_icon_260 VARCHAR(200), 
	   station_number_of_cases_now INT, 
	   station_number_of_cases_total INT, 
	   station_number_updated DATE
	   )")
	   or die(mysqli_error());	
	
	mysqli_query($link, "INSERT INTO $t_edb_stations_index
	(station_id, station_title, station_title_clean, station_district_id, station_district_title, station_number_of_cases_now) 
	VALUES 
	(NULL, 'Stavanger', 'stavanger', 6, 'S&oslash;r-Vest', 0),
	(NULL, 'Haugesund', 'haugesund', 6, 'S&oslash;r-Vest', 0)
	") or die(mysqli_error($link));

}
echo"
<!-- //edb_stations_index -->


<!-- edb_stations_members -->
";

$query = "SELECT * FROM $t_edb_stations_members LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_stations_members: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_stations_members (
	  station_member_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(station_member_id), 
	   station_member_station_id INT, 
	   station_member_station_title VARCHAR(200),
	   station_member_district_id INT, 
	   station_member_district_title VARCHAR(200),
	   station_member_user_id INT, 
	   station_member_rank VARCHAR(200),
	   station_member_user_name VARCHAR(200), 
	   station_member_user_alias VARCHAR(200), 
	   station_member_first_name VARCHAR(200), 
	   station_member_middle_name VARCHAR(200), 
	   station_member_last_name VARCHAR(200), 
	   station_member_user_email VARCHAR(200), 
	   station_member_user_phone VARCHAR(200), 
	   station_member_user_image_path VARCHAR(200),
	   station_member_user_image_file VARCHAR(200),
	   station_member_user_image_thumb_40 VARCHAR(200),
	   station_member_user_image_thumb_50 VARCHAR(200),
	   station_member_user_image_thumb_60 VARCHAR(200),
	   station_member_user_image_thumb_200 VARCHAR(200),
	   station_member_user_position VARCHAR(200),
	   station_member_user_department VARCHAR(200),
	   station_member_user_location VARCHAR(200),
	   station_member_user_about TEXT,
	   station_member_show_on_board INT, 
	   station_member_can_be_jour INT, 
	   station_member_added_datetime DATETIME, 
	   station_member_added_date_saying VARCHAR(200), 
	   station_member_added_by_user_id INT, 
	   station_member_added_by_user_name VARCHAR(200), 
	   station_member_added_by_user_alias VARCHAR(200), 
	   station_member_added_by_user_image VARCHAR(200))")
	   or die(mysqli_error());	


	// Dates
	$datetime = date("Y-m-d H:i:s");
	$date_saying = date("j M Y");


	// Add all to all stations
	$query = "SELECT station_id, station_number, station_title, station_title_clean, station_district_id, station_district_title FROM $t_edb_stations_index";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_station_id, $get_station_number, $get_station_title, $get_station_title_clean, $get_station_district_id, $get_station_district_title) = $row;
		
		$inp_station_title_mysql = quote_smart($link, $get_station_title);
		$inp_station_district_title_mysql = quote_smart($link, $get_station_district_title);
	
		// Find users
		$query_u = "SELECT user_id, user_email, user_name, user_alias FROM $t_users WHERE user_rank='admin'";
		$result_u = mysqli_query($link, $query_u);
		while($row_u = mysqli_fetch_row($result_u)) {
			list($get_user_id, $get_user_email, $get_user_name, $get_user_alias) = $row_u;


			// Get photo
			$query_p = "SELECT photo_id, photo_destination, photo_thumb_40, photo_thumb_50, photo_thumb_60, photo_thumb_200 FROM $t_users_profile_photo WHERE photo_user_id='$get_user_id' AND photo_profile_image='1'";
			$result_p = mysqli_query($link, $query_p);
			$row_p = mysqli_fetch_row($result_p);
			list($get_photo_id, $get_photo_destination, $get_photo_thumb_40, $get_photo_thumb_50, $get_photo_thumb_60, $get_photo_thumb_200) = $row_p;

			// Get Profile
			$query = "SELECT profile_id, profile_first_name, profile_middle_name, profile_last_name, profile_about FROM $t_users_profile WHERE profile_user_id=$get_user_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_profile_id, $get_profile_first_name, $get_profile_middle_name, $get_profile_last_name, $get_profile_about) = $row;


			$inp_user_name_mysql = quote_smart($link, $get_user_name);
			$inp_user_alias_mysql = quote_smart($link, $get_user_alias);
			$inp_user_email_mysql = quote_smart($link, $get_user_email);

			$inp_user_image_path = "_uploads/users/images/$get_user_id";
			$inp_user_image_path_mysql = quote_smart($link, $inp_user_image_path);

			$inp_user_image_file_mysql = quote_smart($link, $get_photo_destination);
			$inp_user_image_thumb_a_mysql = quote_smart($link, $get_photo_thumb_40);
									$inp_user_image_thumb_b_mysql = quote_smart($link, $get_photo_thumb_50);
									$inp_user_image_thumb_c_mysql = quote_smart($link, $get_photo_thumb_60);
									$inp_user_image_thumb_d_mysql = quote_smart($link, $get_photo_thumb_200);

			$inp_user_first_name_mysql = quote_smart($link, $get_profile_first_name);
			$inp_user_middle_name_mysql = quote_smart($link, $get_profile_middle_name);
			$inp_user_last_name_mysql = quote_smart($link, $get_profile_last_name);
		
			mysqli_query($link, "INSERT INTO $t_edb_stations_members 
			(`station_member_id`, `station_member_station_id`, `station_member_station_title`, `station_member_district_id`, `station_member_district_title`, `station_member_user_id`, `station_member_rank`, `station_member_user_name`, `station_member_user_alias`, `station_member_first_name`, `station_member_middle_name`, `station_member_last_name`, `station_member_user_email`, `station_member_user_image_path`, `station_member_user_image_file`, `station_member_user_image_thumb_40`, `station_member_user_image_thumb_50`, `station_member_user_image_thumb_60`, `station_member_user_image_thumb_200`, `station_member_user_position`, `station_member_user_department`, `station_member_user_location`, `station_member_user_about`, `station_member_show_on_board`, `station_member_can_be_jour`, `station_member_added_datetime`, `station_member_added_date_saying`, `station_member_added_by_user_id`, `station_member_added_by_user_name`, `station_member_added_by_user_alias`, `station_member_added_by_user_image`) 
			VALUES 
			(NULL, $get_station_id, $inp_station_title_mysql, $get_station_district_id, $inp_station_district_title_mysql, 
			$get_user_id, 'admin', $inp_user_name_mysql, $inp_user_alias_mysql, $inp_user_first_name_mysql, $inp_user_middle_name_mysql, $inp_user_last_name_mysql, 
			$inp_user_email_mysql, $inp_user_image_path_mysql, $inp_user_image_file_mysql, $inp_user_image_thumb_a_mysql, $inp_user_image_thumb_b_mysql, 
			$inp_user_image_thumb_c_mysql, $inp_user_image_thumb_d_mysql, '', '', '', '', NULL, NULL, '2019-08-23 07:13:54', '23 Aug 2019', 1, 'administrator', 'administrator', '')
			") or die(mysqli_error($link));
		}
	} // stations
}
echo"
<!-- //edb_stations_members -->


<!-- edb_stations_membership_requests -->
";

$query = "SELECT * FROM $t_edb_stations_membership_requests LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_stations_membership_requests: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_stations_membership_requests (
	  request_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(request_id), 
	   request_station_id INT, 
	   request_station_title VARCHAR(200),
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
<!-- //edb_stations_membership_requests -->

<!-- edb_stations_directories -->
";

$query = "SELECT * FROM $t_edb_stations_directories LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_stations_directories: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_stations_directories(
	  directory_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(directory_id), 
	   directory_station_id INT, 
	   directory_station_title VARCHAR(200), 
	   directory_district_id INT, 
	   directory_district_title VARCHAR(200), 
	   directory_type VARCHAR(200),
	   directory_address_linux VARCHAR(200),
	   directory_address_windows VARCHAR(200),
	   directory_address_prefered_for_agent VARCHAR(200),
	   directory_last_checked_for_new_files_counter INT,
	   directory_last_checked_for_new_files_time VARCHAR(200),
	   directory_last_checked_for_new_files_hour INT,
	   directory_last_checked_for_new_files_minute INT,
	   directory_now_size_last_calculated_day INT,
	   directory_now_size_last_calculated_hour INT,
	   directory_now_size_last_calculated_minute INT,
	   directory_now_size_mb VARCHAR(40),
	   directory_now_size_gb VARCHAR(40),
	   directory_available_size_mb VARCHAR(40),
	   directory_available_size_gb VARCHAR(40),
	   directory_available_size_percentage INT
	   )")
	   or die(mysqli_error());

	// Stavanger
	$inp_mirror_files_linux = "\\\\10.0.0.23\Beslagsdb_test_Stavanger_speilfiler";
	$inp_mirror_files_linux_mysql = quote_smart($link, $inp_mirror_files_linux);

	$inp_mirror_files_windows = "X:\Beslagsdb_test_Stavanger_speilfiler";
	$inp_mirror_files_windows_mysql = quote_smart($link, $inp_mirror_files_windows);

	mysqli_query($link, "INSERT INTO $t_edb_stations_directories
	(directory_id, directory_station_id, directory_station_title, directory_district_id, directory_district_title, directory_type, directory_address_linux, directory_address_windows, directory_address_prefered_for_agent) 
	VALUES 
	(NULL, 1, 'Stavanger', 7, 'S&oslash;r-Vest', 'mirror_files', $inp_mirror_files_linux_mysql, $inp_mirror_files_windows_mysql, 'linux')
	") or die(mysqli_error($link));


	$inp_mirror_files_linux = "\\\\10.0.0.23\Beslagsdb_test_Stavanger_sak";
	$inp_mirror_files_linux_mysql = quote_smart($link, $inp_mirror_files_linux);

	$inp_mirror_files_windows = "X:\Beslagsdb_test_Stavanger_sak";
	$inp_mirror_files_windows_mysql = quote_smart($link, $inp_mirror_files_windows);

	mysqli_query($link, "INSERT INTO $t_edb_stations_directories
	(directory_id, directory_station_id, directory_station_title, directory_district_id, directory_district_title, directory_type, directory_address_linux, directory_address_windows, directory_address_prefered_for_agent) 
	VALUES 
	(NULL, 1, 'Stavanger', 7, 'S&oslash;r-Vest', 'case_files', $inp_mirror_files_linux_mysql, $inp_mirror_files_windows_mysql, 'linux')
	") or die(mysqli_error($link));

	// Haugesund
	$inp_mirror_files_linux = "\\\\10.0.0.23\Beslagsdb_test_Haugesund_speilfiler";
	$inp_mirror_files_linux_mysql = quote_smart($link, $inp_mirror_files_linux);

	$inp_mirror_files_windows = "X:\Beslagsdb_test_Haugesund_speilfiler";
	$inp_mirror_files_windows_mysql = quote_smart($link, $inp_mirror_files_windows);

	mysqli_query($link, "INSERT INTO $t_edb_stations_directories
	(directory_id, directory_station_id, directory_station_title, directory_district_id, directory_district_title, directory_type, directory_address_linux, directory_address_windows, directory_address_prefered_for_agent) 
	VALUES 
	(NULL, 2, 'Haugesund', 7, 'S&oslash;r-Vest', 'mirror_files', $inp_mirror_files_linux_mysql, $inp_mirror_files_windows_mysql, 'linux')
	") or die(mysqli_error($link));


	$inp_mirror_files_linux = "\\\\10.0.0.23\Beslagsdb_test_Haugesund_sak";
	$inp_mirror_files_linux_mysql = quote_smart($link, $inp_mirror_files_linux);

	$inp_mirror_files_windows = "X:\Beslagsdb_test_Haugesund_sak";
	$inp_mirror_files_windows_mysql = quote_smart($link, $inp_mirror_files_windows);

	mysqli_query($link, "INSERT INTO $t_edb_stations_directories
	(directory_id, directory_station_id, directory_station_title, directory_district_id, directory_district_title, directory_type, directory_address_linux, directory_address_windows, directory_address_prefered_for_agent) 
	VALUES 
	(NULL, 2, 'Haugesund', 7, 'S&oslash;r-Vest', 'case_files', $inp_mirror_files_linux_mysql, $inp_mirror_files_windows_mysql, 'linux')
	") or die(mysqli_error($link));


}
echo"
<!-- //edb_stations_directories -->


<!-- edb_stations_jour -->
";

$query = "SELECT * FROM $t_edb_stations_jour LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_stations_jour: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_stations_jour(
	  jour_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(jour_id), 
	   jour_station_id INT, 
	   jour_station_title VARCHAR(200), 
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
<!-- //edb_stations_jour -->

<!-- edb_stations_user_view_method -->
";

$query = "SELECT * FROM $t_edb_stations_user_view_method LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_stations_user_view_method: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_stations_user_view_method(
	  view_method_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(view_method_id), 
	   user_id INT, 
	   view_method VARCHAR(100)
	   )")
	   or die(mysqli_error());


}
echo"
<!-- //edb_stations_user_view_method -->



";
?>