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


	// Dates
	$datetime = date("Y-m-d H:i:s");
	$date_saying = date("j M Y");
	$time = time();

	// Create users
	$x=0;
	$user_email[$x] 	 = "anne.heradstveit@politiet.noo";
	$profile_first_name[$x]  = "Anne";
	$profile_middle_name[$x] = "";
	$profile_last_name[$x]   = "Heradstveit";
	$user_name[$x] 		 = "AHE043";
	$user_alias[$x] 	 = "AHE043";
	$user_company[$x]	 = "S&oslash;r-Vest politidistrikt";
	$user_position[$x]	 = "Spesialetterforsker";

	$x=$x+1;
	$user_email[$x] 	 = "bernt.nordbotten@politiet.noo";
	$profile_first_name[$x]  = "Bernt";
	$profile_middle_name[$x] = "";
	$profile_last_name[$x]   = "Nordbotten";
	$user_name[$x] 		 = "BNO017";
	$user_alias[$x] 	 = "BNO017";
	$user_company[$x]	 = "S&oslash;r-Vest politidistrikt";
	$user_position[$x]	 = "Spesialetterforsker";

	$x=$x+1;
	$user_email[$x] 	 = "kristian.m.overskeid@politiet.noo";
	$profile_first_name[$x]  = "Kristian";
	$profile_middle_name[$x] = "M";
	$profile_last_name[$x]   = "Overskeid";
	$user_name[$x] 		 = "KMO044";
	$user_alias[$x] 	 = "KMO044";
	$user_company[$x]	 = "S&oslash;r-Vest politidistrikt";
	$user_position[$x]	 = "Spesialetterforsker";

	$x=$x+1;
	$user_email[$x] 	 = "knut.erik.rame@politiet.noo";
	$profile_first_name[$x]  = "Knut";
	$profile_middle_name[$x] = "Erik";
	$profile_last_name[$x]   = "Rame";
	$user_name[$x] 		 = "KER001";
	$user_alias[$x] 	 = "KER001";
	$user_company[$x]	 = "S&oslash;r-Vest politidistrikt";
	$user_position[$x]	 = "Spesialetterforsker";

	$x=$x+1;
	$user_email[$x] 	 = "aina.svendsen@politiet.noo";
	$profile_first_name[$x]  = "Aina";
	$profile_middle_name[$x] = "Marie";
	$profile_last_name[$x]   = "Svendsen";
	$user_name[$x] 		 = "ASV018";
	$user_alias[$x] 	 = "ASV018";
	$user_company[$x]	 = "S&oslash;r-Vest politidistrikt";
	$user_position[$x]	 = "Spesialetterforsker";

	$x=$x+1;
	$user_email[$x] 	 = "jarle.thorsen@politiet.noo";
	$profile_first_name[$x]  = "Jarle";
	$profile_middle_name[$x] = "";
	$profile_last_name[$x]   = "Thorsen";
	$user_name[$x] 		 = "JTH007";
	$user_alias[$x] 	 = "JTH007";
	$user_company[$x]	 = "S&oslash;r-Vest politidistrikt";
	$user_position[$x]	 = "Spesialetterforsker";

	$x=$x+1;
	$user_email[$x] 	 = "odd.frode.torbjornsen@politiet.noo";
	$profile_first_name[$x]  = "Odd";
	$profile_middle_name[$x] = "Frode";
	$profile_last_name[$x]   = "Torbjornsen";
	$user_name[$x]		 = "OFT001";
	$user_alias[$x] 	 = "OFT001";
	$user_company[$x]	 = "S&oslash;r-Vest politidistrikt";
	$user_position[$x]	 = "Spesialetterforsker";

	$x=$x+1;
	$user_email[$x] 	 = "sindre.andre.ditlefsen@politiet.noo";
	$profile_first_name[$x]  = "Sindre";
	$profile_middle_name[$x] = "Andre";
	$profile_last_name[$x]   = "Ditlefsen";
	$user_name[$x] 		 = "SDI004";
	$user_alias[$x] 	 = "SDI004";
	$user_company[$x]	 = "S&oslash;r-Vest politidistrikt";
	$user_position[$x]	 = "Spesialetterforsker";


	$x=$x+1;
	$user_email[$x] 	 = "eirik.tjorholm@politiet.noo";
	$profile_first_name[$x]  = "Eirik";
	$profile_middle_name[$x] = "";
	$profile_last_name[$x]   = "Tjorholm";
	$user_name[$x] 		 = "ETJ002";
	$user_alias[$x] 	 = "ETJ002";
	$user_company[$x]	 = "S&oslash;r-Vest politidistrikt";
	$user_position[$x]	 = "Spesialetterforsker";





	for($x=0;$x<sizeof($user_email);$x++){
		// Check if exists
		$inp_user_email_mysql = quote_smart($link, $user_email[$x]);
		$inp_user_name_mysql = quote_smart($link, strtolower($user_name[$x]));
		$inp_user_alias_mysql = quote_smart($link, strtolower($user_alias[$x]));

		$inp_profile_first_name_mysql = quote_smart($link, $profile_first_name[$x]);
		$inp_profile_middle_name_mysql = quote_smart($link, $profile_middle_name[$x]);
		$inp_profile_last_name_mysql = quote_smart($link, $profile_last_name[$x]);


		$query_p = "SELECT user_id FROM $t_users WHERE user_email=$inp_user_email_mysql";
		$result_p = mysqli_query($link, $query_p);
		$row_p = mysqli_fetch_row($result_p);
		list($get_user_id) = $row_p;
		
		if($get_user_id == ""){
			echo"<p><i>Insert user $user_email[$x]</i></p>\n";
			// Create salt
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    			$charactersLength = strlen($characters);
    			$salt = '';
    			for ($i = 0; $i < 6; $i++) {
        			$salt .= $characters[rand(0, $charactersLength - 1)];
    			}
			$inp_user_salt_mysql = quote_smart($link, $salt);

			// Security
			$inp_user_security = rand(0,9999);

			mysqli_query($link, "INSERT INTO $t_users
			(`user_id`, `user_email`, `user_name`, `user_alias`, `user_password`, `user_password_replacement`, `user_password_date`, `user_salt`, `user_security`, `user_language`, `user_gender`, `user_height`, `user_measurement`, `user_dob`, `user_date_format`, `user_registered`, `user_registered_time`, `user_last_online`, `user_last_online_time`, `user_rank`, `user_points`, `user_points_rank`, `user_likes`, `user_dislikes`, `user_status`, `user_login_tries`, `user_last_ip`, `user_synchronized`, `user_verified_by_moderator`, `user_notes`, `user_marked_as_spammer`) 
			VALUES 
			(NULL, $inp_user_email_mysql, $inp_user_name_mysql, $inp_user_alias_mysql,  'c55bc0962f1491f077137239e204d2c878edb2fd', NULL, NULL, $inp_user_salt_mysql, $inp_user_security, 'no', '', NULL, 'metric', NULL, 'l d. f Y', '$datetime', '$time', '$datetime', '$time', 'admin', 0, 'Newbie', 0, 0, NULL, NULL, '::1', NULL, '1', NULL, NULL)")
			or die(mysqli_error($link));

			// Get user id
			$query = "SELECT user_id FROM $t_users WHERE user_email=$inp_user_email_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_user_id) = $row;
			
			// Insert profile			
			mysqli_query($link, "INSERT INTO $t_users_profile
			(profile_id, profile_user_id, profile_first_name, profile_middle_name, profile_last_name, profile_newsletter, profile_views, profile_privacy) 
			VALUES 
			(NULL, '$get_user_id', $inp_profile_first_name_mysql, $inp_profile_middle_name_mysql, $inp_profile_last_name_mysql, '1', '0', 'public')")
			or die(mysqli_error($link));
			
			// Insert photo
			$inp_photo_title_mysql = quote_smart($link, $profile_first_name[$x]);

			$inp_photo_destination = strtolower($user_name[$x]) . ".png";
			$inp_photo_destination_mysql = quote_smart($link, $inp_photo_destination);
			
			$inp_photo_thumb_a = strtolower($user_name[$x]) . "_40.png";
			$inp_photo_thumb_a_mysql = quote_smart($link, $inp_photo_thumb_a);
			
			$inp_photo_thumb_b = strtolower($user_name[$x]) . "_50.png";
			$inp_photo_thumb_b_mysql = quote_smart($link, $inp_photo_thumb_b);
			
			$inp_photo_thumb_c = strtolower($user_name[$x]) . "_60.png";
			$inp_photo_thumb_c_mysql = quote_smart($link, $inp_photo_thumb_c);
			
			$inp_photo_thumb_d = strtolower($user_name[$x]) . "_200.png";
			$inp_photo_thumb_d_mysql = quote_smart($link, $inp_photo_thumb_d);

			$inp_photo_uploaded = date("Y-m-d H:i:s");

			mysqli_query($link, "INSERT INTO $t_users_profile_photo
			(photo_id, photo_user_id, photo_profile_image, photo_title, photo_destination, photo_thumb_40, photo_thumb_50, photo_thumb_60, photo_thumb_200, photo_uploaded) 
			VALUES 
			(NULL, '$get_user_id', 1, $inp_photo_title_mysql, $inp_photo_destination_mysql, $inp_photo_thumb_a_mysql, $inp_photo_thumb_b_mysql, $inp_photo_thumb_c_mysql, $inp_photo_thumb_d_mysql, '$inp_photo_uploaded')")
			or die(mysqli_error($link));
			
			// Insert professional
			$inp_company_mysql = quote_smart($link, $user_company[$x]);
			$inp_position_mysql = quote_smart($link, $user_position[$x]);

			mysqli_query($link, "INSERT INTO $t_users_professional
			(professional_id, professional_user_id, professional_company, professional_company_location, professional_department, professional_work_email, professional_position) 
			VALUES 
			(NULL, '$get_user_id', $inp_company_mysql, '', '', '', $inp_position_mysql)")
			or die(mysqli_error($link));

		}
	}


	// Add all to this districts
	$query = "SELECT user_id, user_email, user_name, user_alias FROM $t_users WHERE user_rank='admin'";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_user_id, $get_user_email, $get_user_name, $get_user_alias) = $row;

	
		// Get photo
		$query_p = "SELECT photo_id, photo_destination, photo_thumb_40 FROM $t_users_profile_photo WHERE photo_user_id='$get_my_user_id' AND photo_profile_image='1'";
		$result_p = mysqli_query($link, $query_p);
		$row_p = mysqli_fetch_row($result_p);
		list($get_photo_id, $get_photo_destination, $get_photo_thumb_40) = $row_p;


		$inp_user_name_mysql = quote_smart($link, $get_user_name);
		$inp_user_alias_mysql = quote_smart($link, $get_user_alias);
		$inp_user_email_mysql = quote_smart($link, $get_user_email);
		$inp_user_image_mysql = quote_smart($link, $get_photo_destination);
	
		mysqli_query($link, "INSERT INTO $t_edb_districts_members
		(district_member_id, district_member_district_id, district_member_district_title, district_member_rank, district_member_user_id, district_member_user_name, district_member_user_alias, district_member_user_email, district_member_user_image_file, district_member_user_about, district_member_can_be_jour, district_member_show_on_board, district_member_added_datetime, district_member_added_date_saying, district_member_added_by_user_id, district_member_added_by_user_alias, district_member_added_by_user_image) 
		VALUES 
		(NULL, 6, 'S&oslash;r-Vest', 'admin', $get_user_id, $inp_user_name_mysql, $inp_user_alias_mysql, $inp_user_email_mysql, $inp_user_image_mysql, '', '1', '1', '$datetime', '$date_saying', 1, 'Administrator', '')")
		or die(mysqli_error($link));
	}

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