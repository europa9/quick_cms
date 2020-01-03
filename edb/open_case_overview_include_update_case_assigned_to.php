<?php 
/**
*
* File: edb/open_case_index_update_status.php
* Version 1.0
* Date 21:03 04.08.2019
* Copyright (c) 2019 S. A. Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security']) && isset($get_current_case_id) && isset($inp_assigned_to_user_name)){


	// Check that the assigned user is a member of the station
	$inp_assigned_to_user_name_mysql = quote_smart($link, $inp_assigned_to_user_name);

	$query = "SELECT station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60, station_member_user_image_thumb_200, station_member_user_position, station_member_user_department, station_member_user_location, station_member_user_about, station_member_added_datetime, station_member_added_date_saying, station_member_added_by_user_id, station_member_added_by_user_name, station_member_added_by_user_alias, station_member_added_by_user_image FROM $t_edb_stations_members WHERE station_member_station_id=$get_current_case_station_id AND station_member_user_name=$inp_assigned_to_user_name_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_station_member_id, $get_current_station_member_station_id, $get_current_station_member_station_title, $get_current_station_member_district_id, $get_current_station_member_district_title, $get_current_station_member_user_id, $get_current_station_member_rank, $get_current_station_member_user_name, $get_current_station_member_user_alias, $get_current_station_member_first_name, $get_current_station_member_middle_name, $get_current_station_member_last_name, $get_current_station_member_user_email, $get_current_station_member_user_image_path, $get_current_station_member_user_image_file, $get_current_station_member_user_image_thumb_40, $get_current_station_member_user_image_thumb_50, $get_current_station_member_user_image_thumb_60, $get_current_station_member_user_image_thumb_200, $get_current_station_member_user_position, $get_current_station_member_user_department, $get_current_station_member_user_location, $get_current_station_member_user_about, $get_current_station_member_added_datetime, $get_current_station_member_added_date_saying, $get_current_station_member_added_by_user_id, $get_current_station_member_added_by_user_name, $get_current_station_member_added_by_user_alias, $get_current_station_member_added_by_user_image) = $row;
	
	if($get_current_station_member_id == ""){
		// user_is_no_a_member_of_the_station
	}		

	
	// Check that user is a admin, moderator or editor
	if($get_current_station_member_rank == "admin" OR $get_current_station_member_rank == "moderator" OR $get_current_station_member_rank == "editor"){

		// Fetch user profile
		$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_id=$get_current_station_member_user_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_assignee_user_id, $get_assignee_user_email, $get_assignee_user_name, $get_assignee_user_alias, $get_assignee_user_language, $get_assignee_user_last_online, $get_assignee_user_rank, $get_assignee_user_login_tries) = $row;
		if($get_assignee_user_id == ""){
			$url = "open_case_overview.php?case_id=$get_current_case_id&action=index&l=$l&ft=error&fm=user_is_not_a_user_because_users_was_not_found";
			header("Location: $url");
			die;
		}
	
		// Get assignee photo
		$query = "SELECT photo_id, photo_user_id, photo_profile_image, photo_title, photo_destination, photo_thumb_40, photo_thumb_50, photo_thumb_60, photo_thumb_200, photo_uploaded, photo_uploaded_ip, photo_views, photo_views_ip_block, photo_likes, photo_comments, photo_x_offset, photo_y_offset, photo_text FROM $t_users_profile_photo WHERE photo_user_id=$get_current_station_member_user_id AND photo_profile_image='1'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_assignee_photo_id, $get_assignee_photo_user_id, $get_assignee_photo_profile_image, $get_assignee_photo_title, $get_assignee_photo_destination, $get_assignee_photo_thumb_40, $get_assignee_photo_thumb_50, $get_assignee_photo_thumb_60, $get_assignee_photo_thumb_200, $get_assignee_photo_uploaded, $get_assignee_photo_uploaded_ip, $get_assignee_photo_views, $get_assignee_photo_views_ip_block, $get_assignee_photo_likes, $get_assignee_photo_comments, $get_assignee_photo_x_offset, $get_assignee_photo_y_offset, $get_assignee_photo_text) = $row;

		// Assignee  Profile
		$query = "SELECT profile_id, profile_first_name, profile_middle_name, profile_last_name, profile_about FROM $t_users_profile WHERE profile_user_id=$get_current_station_member_user_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_assignee_profile_id, $get_assignee_profile_first_name, $get_assignee_profile_middle_name, $get_assignee_profile_last_name, $get_assignee_profile_about) = $row;
	
		// Assignee Professional
		$query = "SELECT professional_id, professional_user_id, professional_company, professional_company_location, professional_department, professional_work_email, professional_position FROM $t_users_professional WHERE professional_user_id=$get_current_station_member_user_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_assignee_professional_id, $get_assignee_professional_user_id, $get_assignee_professional_company, $get_assignee_professional_company_location, $get_assignee_professional_department, $get_assignee_professional_work_email, $get_assignee_professional_position) = $row;


		// Update Case
		$inp_datetime = date("Y-m-d H:i:s");
		$inp_time = time();
		$inp_date_saying = date("j M Y");
		$inp_date_ddmmyy = date("d.m.y");
		$inp_assigned_to_user_id = "$get_assignee_user_id";
		
		$inp_assigned_to_user_name_mysql = quote_smart($link, $get_assignee_user_name);
		$inp_assigned_to_user_alias_mysql = quote_smart($link, $get_assignee_user_alias);
		$inp_assigned_to_user_email_mysql = quote_smart($link, $get_assignee_user_alias);

		$inp_assigned_to_user_image_path = "_uploads/users/images/$get_assignee_user_id";
		$inp_assigned_to_user_image_path_mysql = quote_smart($link, $inp_assigned_to_user_image_path);

		$inp_assigned_to_user_image_file_mysql = quote_smart($link, $get_assignee_photo_destination);
		$inp_assigned_to_user_image_thumb_a_mysql = quote_smart($link, $get_assignee_photo_thumb_40);
		$inp_assigned_to_user_image_thumb_b_mysql = quote_smart($link, $get_assignee_photo_thumb_50);
		$inp_assigned_to_user_image_thumb_c_mysql = quote_smart($link, $get_assignee_photo_thumb_60);
		$inp_assigned_to_user_image_thumb_d_mysql = quote_smart($link, $get_assignee_photo_thumb_200);
		
		$inp_assigned_to_user_first_name_mysql = quote_smart($link, $get_assignee_profile_first_name);
		$inp_assigned_to_user_middle_name_mysql = quote_smart($link, $get_assignee_profile_middle_name);
		$inp_assigned_to_user_last_name_mysql = quote_smart($link, $get_assignee_profile_last_name);


		$result = mysqli_query($link, "UPDATE $t_edb_case_index SET 
						case_assigned_to_datetime='$inp_datetime', 
						case_assigned_to_time='$inp_time', 
						case_assigned_to_date_saying='$inp_date_saying', 
						case_assigned_to_date_ddmmyy='$inp_date_ddmmyy', 
						case_assigned_to_user_id='$inp_assigned_to_user_id', 
						case_assigned_to_user_name=$inp_assigned_to_user_name_mysql,
						case_assigned_to_user_alias=$inp_assigned_to_user_alias_mysql,
						case_assigned_to_user_email=$inp_assigned_to_user_email_mysql,
						case_assigned_to_user_image_path=$inp_assigned_to_user_image_path_mysql,
						case_assigned_to_user_image_file=$inp_assigned_to_user_image_file_mysql,
						case_assigned_to_user_image_thumb_40=$inp_assigned_to_user_image_thumb_a_mysql,
						case_assigned_to_user_image_thumb_50=$inp_assigned_to_user_image_thumb_b_mysql,
						case_assigned_to_user_first_name=$inp_assigned_to_user_first_name_mysql,
						case_assigned_to_user_middle_name=$inp_assigned_to_user_middle_name_mysql,
						case_assigned_to_user_last_name=$inp_assigned_to_user_last_name_mysql
						 WHERE case_id=$get_current_case_id") or die(mysqli_error($link));

		// Update member station profile of assigned to
		$inp_member_first_name_mysql = quote_smart($link, $get_assignee_profile_first_name);
		$inp_member_middle_name_mysql = quote_smart($link, $get_assignee_profile_middle_name);
		$inp_member_last_name_mysql = quote_smart($link, $get_assignee_profile_last_name);
		$inp_member_user_about_mysql = quote_smart($link, $get_assignee_profile_about);
		$inp_member_user_position_mysql = quote_smart($link, $get_assignee_professional_position);
		$inp_member_user_department_mysql = quote_smart($link, $get_assignee_professional_department);
		$inp_member_user_location_mysql = quote_smart($link, $get_assignee_professional_company_location);

		$result = mysqli_query($link, "UPDATE $t_edb_stations_members SET 
						station_member_user_name=$inp_assigned_to_user_name_mysql,
						station_member_user_alias=$inp_assigned_to_user_alias_mysql, 
						station_member_first_name=$inp_member_first_name_mysql, 
						station_member_middle_name=$inp_member_middle_name_mysql, 
						station_member_last_name=$inp_member_last_name_mysql, 
						station_member_user_email=$inp_assigned_to_user_email_mysql,
						station_member_user_image_path=$inp_assigned_to_user_image_path_mysql,
						station_member_user_image_file=$inp_assigned_to_user_image_file_mysql,
						station_member_user_image_thumb_40=$inp_assigned_to_user_image_thumb_a_mysql,
						station_member_user_image_thumb_50=$inp_assigned_to_user_image_thumb_b_mysql,
						station_member_user_image_thumb_60=$inp_assigned_to_user_image_thumb_c_mysql,
						station_member_user_image_thumb_200=$inp_assigned_to_user_image_thumb_d_mysql,
						station_member_user_position=$inp_member_user_position_mysql, 
						station_member_user_department=$inp_member_user_department_mysql, 
						station_member_user_location=$inp_member_user_location_mysql, 
						station_member_user_about=$inp_member_user_about_mysql
						 WHERE station_member_user_id=$get_current_station_member_user_id") or die(mysqli_error($link));

		// Update assignee district profile

		$result = mysqli_query($link, "UPDATE $t_edb_districts_members SET 
						district_member_user_name=$inp_assigned_to_user_name_mysql,
						district_member_user_alias=$inp_assigned_to_user_alias_mysql, 
						district_member_user_first_name=$inp_member_first_name_mysql, 
						district_member_user_middle_name=$inp_member_middle_name_mysql, 
						district_member_user_last_name=$inp_member_last_name_mysql, 
						district_member_user_email=$inp_assigned_to_user_email_mysql,
						district_member_user_image_path=$inp_assigned_to_user_image_path_mysql,
						district_member_user_image_file=$inp_assigned_to_user_image_file_mysql,
						district_member_user_image_thumb_40=$inp_assigned_to_user_image_thumb_a_mysql,
						district_member_user_image_thumb_50=$inp_assigned_to_user_image_thumb_b_mysql,
						district_member_user_image_thumb_60=$inp_assigned_to_user_image_thumb_c_mysql,
						district_member_user_image_thumb_200=$inp_assigned_to_user_image_thumb_d_mysql,
						district_member_user_position=$inp_member_user_position_mysql, 
						district_member_user_department=$inp_member_user_department_mysql, 
						district_member_user_location=$inp_member_user_location_mysql, 
						district_member_user_about=$inp_member_user_about_mysql
						 WHERE district_member_user_id=$get_current_station_member_user_id") or die(mysqli_error($link));

		// Header
		

	} // admin, moderator, editor
	else{
		// user_is_not_a_admin,_moderator_or_editor_of_this_station
	} // not admin, moderator, editor

} // logged in and case exists
else{
	// Log in
	echo"<h1>Server error 403</h1>";
} // not logged in or case doesnt exists
?>