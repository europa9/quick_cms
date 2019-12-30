<?php 
/**
*
* File: edb/browse_districts_and_stations.php
* Version 1.0
* Date 21:03 04.08.2019
* Copyright (c) 2019 S. A. Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "2";
$pageNoColumnSav      = "2";
$pageAllowCommentsSav = "1";
$pageAuthorUserIdSav  = "1";

/*- Root dir --------------------------------------------------------------------------------- */
// This determine where we are
if(file_exists("favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
elseif(file_exists("../../../../favicon.ico")){ $root = "../../../.."; }
else{ $root = "../../.."; }

/*- Website config --------------------------------------------------------------------------- */
include("$root/_admin/website_config.php");

/*- Variables -------------------------------------------------------------------------- */
$tabindex = 0;

if(isset($_GET['district_id'])) {
	$district_id = $_GET['district_id'];
	$district_id = strip_tags(stripslashes($district_id));
}
else{
	$district_id = "";
}
$district_id_mysql = quote_smart($link, $district_id);

if(isset($_GET['station_id'])) {
	$station_id = $_GET['station_id'];
	$station_id = strip_tags(stripslashes($station_id));
}
else{
	$station_id = "";
}
$station_id_mysql = quote_smart($link, $station_id);

// Find district
if($district_id != ""){
	$query = "SELECT district_id, district_number, district_title, district_title_clean, district_icon_path, district_icon_16, district_icon_32, district_icon_260, district_number_of_stations, district_number_of_cases_now FROM $t_edb_districts_index WHERE district_id=$district_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_district_id, $get_current_district_number, $get_current_district_title, $get_current_district_title_clean, $get_current_district_icon_path, $get_current_district_icon_16, $get_current_district_icon_32, $get_current_district_icon_260, $get_current_district_number_of_stations, $get_current_district_number_of_cases_now) = $row;
	
	if($get_current_district_id == ""){
		echo"<h1>Server error 404</h1><p>District not found</p>";
		die;
	}
	else{
		// Check that I am member of this district
	}
}
// Find station
if($station_id != ""){
	$query = "SELECT station_id, station_number, station_title, station_title_clean, station_district_id, station_district_title, station_icon_path, station_icon_16, station_icon_32, station_icon_260, station_number_of_cases_now FROM $t_edb_stations_index WHERE station_id=$station_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_station_id, $get_current_station_number, $get_current_station_title, $get_current_station_title_clean, $get_current_station_district_id, $get_current_station_district_title, $get_current_station_icon_path, $get_current_station_icon_16, $get_current_station_icon_32, $get_current_station_icon_260, $get_current_station_number_of_cases_now) = $row;
	
	if($get_current_station_id == ""){
		echo"<h1>Server error 404</h1><p>Station not found</p>";
		die;
	}
	else{
		// Check that I am member of this station
		
	}
}


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_edb - $l_districts";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	// Me
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);

	$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_language, $get_my_user_last_online, $get_my_user_rank, $get_my_user_login_tries) = $row;
					
	// Get my photo
	$query = "SELECT photo_id, photo_user_id, photo_profile_image, photo_title, photo_destination, photo_thumb_40, photo_thumb_50, photo_thumb_60, photo_thumb_200, photo_uploaded, photo_uploaded_ip, photo_views, photo_views_ip_block, photo_likes, photo_comments, photo_x_offset, photo_y_offset, photo_text FROM $t_users_profile_photo WHERE photo_user_id='$get_my_user_id'  AND photo_profile_image='1'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_photo_id, $get_my_photo_user_id, $get_my_photo_profile_image, $get_my_photo_title, $get_my_photo_destination, $get_my_photo_thumb_40, $get_my_photo_thumb_50, $get_my_photo_thumb_60, $get_my_photo_thumb_200, $get_my_photo_uploaded, $get_my_photo_uploaded_ip, $get_my_photo_views, $get_my_photo_views_ip_block, $get_my_photo_likes, $get_my_photo_comments, $get_my_photo_x_offset, $get_my_photo_y_offset, $get_my_photo_text) = $row;

	// My Profile
	$query = "SELECT profile_id, profile_first_name, profile_middle_name, profile_last_name, profile_about FROM $t_users_profile WHERE profile_user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_profile_id, $get_my_profile_first_name, $get_my_profile_middle_name, $get_my_profile_last_name, $get_my_profile_about) = $row;

	// My Professional
	$query = "SELECT professional_id, professional_user_id, professional_company, professional_company_location, professional_department, professional_work_email, professional_position FROM $t_users_professional WHERE professional_user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_professional_id, $get_my_professional_user_id, $get_my_professional_company, $get_my_professional_company_location, $get_my_professional_department, $get_my_professional_work_email, $get_my_professional_position) = $row;
	if($get_my_professional_id == ""){
		// Create professional profile
		mysqli_query($link, "INSERT INTO $t_users_professional 
		(professional_id, professional_user_id) 
		VALUES 
		(NULL, $get_my_user_id)")
		or die(mysqli_error($link));
	}


	if($action == ""){
		echo"
		<h1>$l_districts</h1>


		<!-- Where am I ? -->
			<p><b>$l_you_are_here:</b><br />
			<a href=\"index.php?l=$l\">$l_edb</a>
			&gt;
			<a href=\"browse_districts_and_stations.php?l=$l\">$l_districts</a>
			</p>
		<!-- //Where am I ? -->


		<!-- Feedback -->
			";
			if($ft != ""){
				if($fm == "changes_saved"){
					$fm = "$l_changes_saved";
				}
				else{
					$fm = ucfirst($fm);
					$fm = str_replace("_", " ", $fm);
				}
				echo"<div class=\"$ft\"><span>$fm</span></div>";
			}
			echo"	
		<!-- //Feedback -->

		<!-- All districts -->
			<p>
			$l_below_is_a_list_of_all_districts $l_you_can_apply_for_access_to_each_district_by_clicking_on_them
			$l_administrator_can_add_new_districts_in_the_admin_control_panel </p>
			<div class=\"vertical\" style=\"width: 100%;\">
				<ul style=\"width: 100%;\">
				";
				$query = "SELECT district_id, district_title, district_title_clean, district_number_of_cases_now FROM $t_edb_districts_index ORDER BY district_title ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_district_id, $get_district_title, $get_district_title_clean, $get_district_number_of_cases_now) = $row;
					echo"				";
					echo"<li style=\"width: 100%;\"><a href=\"browse_districts_and_stations.php?action=open_district&amp;district_id=$get_district_id&amp;l=$l\">$get_district_title</a></li>\n";
				}
				echo"
				</ul>
			</div>
			<div class=\"clear\"></div>
		<!-- All districts -->
		";
	} // action == ""
	elseif($action == "open_district"){
		// Find district
		$district_id_mysql = quote_smart($link, $district_id);
		$query = "SELECT district_id, district_number, district_title, district_title_clean, district_icon_path, district_icon_16, district_icon_32, district_icon_260, district_number_of_stations, district_number_of_cases_now FROM $t_edb_districts_index WHERE district_id=$district_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_district_id, $get_current_district_number, $get_current_district_title, $get_current_district_title_clean, $get_current_district_icon_path, $get_current_district_icon_16, $get_current_district_icon_32, $get_current_district_icon_260, $get_current_district_number_of_stations, $get_current_district_number_of_cases_now) = $row;
	
		if($get_current_district_id == ""){
			echo"
			<h1>Server error 404</h1>
			<p>District not found.</p>
			";
		}
		else{
			// Am I a member of this district?
			$query = "SELECT district_member_id, district_member_district_id, district_member_district_title, district_member_user_id, district_member_rank, district_member_user_name, district_member_user_alias, district_member_user_first_name, district_member_user_middle_name, district_member_user_last_name, district_member_user_email, district_member_user_image_path, district_member_user_image_file, district_member_user_image_thumb_40, district_member_user_image_thumb_50, district_member_user_image_thumb_60, district_member_user_image_thumb_200, district_member_user_position, district_member_user_department, district_member_user_location, district_member_user_about, district_member_added_datetime, district_member_added_date_saying, district_member_added_by_user_id, district_member_added_by_user_name, district_member_added_by_user_alias, district_member_added_by_user_image FROM $t_edb_districts_members WHERE district_member_district_id=$get_current_district_id AND district_member_user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_my_district_member_id, $get_my_district_member_district_id, $get_my_district_member_district_title, $get_my_district_member_user_id, $get_my_district_member_rank, $get_my_district_member_user_name, $get_my_district_member_user_alias, $get_my_district_member_user_first_name, $get_my_district_member_user_middle_name, $get_my_district_member_user_last_name, $get_my_district_member_user_email, $get_my_district_member_user_image_path, $get_my_district_member_user_image_file, $get_my_district_member_user_image_thumb_40, $get_my_district_member_user_image_thumb_50, $get_my_district_member_user_image_thumb_60, $get_my_district_member_user_image_thumb_200, $get_my_district_member_user_position, $get_my_district_member_user_department, $get_my_district_member_user_location, $get_my_district_member_user_about, $get_my_district_member_added_datetime, $get_my_district_member_added_date_saying, $get_my_district_member_added_by_user_id, $get_my_district_member_added_by_user_name, $get_my_district_member_added_by_user_alias, $get_my_district_member_added_by_user_image) = $row;
	

			echo"
			<h1>$get_current_district_title</h1>

			<!-- Where am I ? -->
				<p><b>$l_you_are_here:</b><br />
				<a href=\"browse_districts_and_stations.php?l=$l\">$l_districts</a>
				&gt;
				<a href=\"browse_districts_and_stations.php?action=open_district&amp;district_id=$get_current_district_id&amp;l=$l\">$get_current_district_title</a>
				</p>
			<!-- //Where am I ? -->

			<!-- Feedback -->
			";
			if($ft != ""){
				if($fm == "changes_saved"){
					$fm = "$l_changes_saved";
				}
				else{
					$fm = ucfirst($fm);
					$fm = str_replace("_", " ", $fm);
				}
				echo"<div class=\"$ft\"><span>$fm</span></div>";
			}
			echo"	
			<!-- //Feedback -->

			<!-- Actions -->
				<p>";

				if($get_my_district_member_id == ""){
					// Im not a member of this district
					// Check if I have applied for membership before
					$query = "SELECT request_id, request_district_id, request_district_title, request_user_id, request_rank, request_user_name, request_user_alias, request_user_first_name, request_user_middle_name, request_user_last_name, request_user_email, request_user_image_path, request_user_image_file, request_user_image_thumb_40, request_user_image_thumb_50, request_user_image_thumb_60, request_user_image_thumb_200, request_user_position, request_user_department, request_user_location, request_user_about, request_datetime, request_date_saying FROM $t_edb_districts_membership_requests WHERE request_district_id=$get_current_district_id AND request_user_id=$my_user_id_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_current_request_id, $get_current_request_district_id, $get_current_request_district_title, $get_current_request_user_id, $get_current_request_rank, $get_current_request_user_name, $get_current_request_user_alias, $get_current_request_user_first_name, $get_current_request_user_middle_name, $get_current_request_user_last_name, $get_current_request_user_email, $get_current_request_user_image_path, $get_current_request_user_image_file, $get_current_request_user_image_thumb_40, $get_current_request_user_image_thumb_50, $get_current_request_user_image_thumb_60, $get_current_request_user_image_thumb_200, $get_current_request_user_position, $get_current_request_user_department, $get_current_request_user_location, $get_current_request_user_about, $get_current_request_datetime, $get_current_request_date_saying) = $row;
					if($get_current_request_id == ""){
						echo"
						<a href=\"browse_districts_and_stations.php?action=apply_for_membership_to_district&amp;district_id=$get_current_district_id&amp;l=$l\" class=\"btn_default\">$l_apply_for_membership_to_district</a>
						";
					}
					else{
						echo"$l_membership_request_sent";
					}
				}

				echo"
				</p>
			<!-- //Actions -->

			<!-- Stations -->
				<p><b>$l_stations:</b></p>
				<div class=\"vertical\" style=\"width: 100%;\">
					<ul style=\"width: 100%;\">
					";
					$query = "SELECT station_id, station_title FROM $t_edb_stations_index WHERE station_district_id='$get_current_district_id' ORDER BY station_title ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_station_id, $get_station_title) = $row;
						echo"				";
						echo"<li style=\"width: 100%;\"><a href=\"browse_districts_and_stations.php?action=open_station&amp;district_id=$get_current_district_id&amp;station_id=$get_station_id&amp;l=$l\">$get_station_title</a></li>\n";
					}
					echo"
					</ul>
				</div>
				<div class=\"clear\"></div>
			<!-- //Stations -->
			";
		} // district found
	} // open_district
	elseif($action == "apply_for_membership_to_district"){
		// Find district
		$district_id_mysql = quote_smart($link, $district_id);
		$query = "SELECT district_id, district_number, district_title, district_title_clean, district_icon_path, district_icon_16, district_icon_32, district_icon_260, district_number_of_stations, district_number_of_cases_now FROM $t_edb_districts_index WHERE district_id=$district_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_district_id, $get_current_district_number, $get_current_district_title, $get_current_district_title_clean, $get_current_district_icon_path, $get_current_district_icon_16, $get_current_district_icon_32, $get_current_district_icon_260, $get_current_district_number_of_stations, $get_current_district_number_of_cases_now) = $row;
	
		if($get_current_district_id == ""){
			echo"
			<h1>Server error 404</h1>
			<p>District not found.</p>
			";
		}
		else{
			// Am I a member of this district?
			$query = "SELECT district_member_id, district_member_district_id, district_member_district_title, district_member_user_id, district_member_rank, district_member_user_name, district_member_user_alias, district_member_user_first_name, district_member_user_middle_name, district_member_user_last_name, district_member_user_email, district_member_user_image_path, district_member_user_image_file, district_member_user_image_thumb_40, district_member_user_image_thumb_50, district_member_user_image_thumb_60, district_member_user_image_thumb_200, district_member_user_position, district_member_user_department, district_member_user_location, district_member_user_about, district_member_added_datetime, district_member_added_date_saying, district_member_added_by_user_id, district_member_added_by_user_name, district_member_added_by_user_alias, district_member_added_by_user_image FROM $t_edb_districts_members WHERE district_member_district_id=$get_current_district_id AND district_member_user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_my_district_member_id, $get_my_district_member_district_id, $get_my_district_member_district_title, $get_my_district_member_user_id, $get_my_district_member_rank, $get_my_district_member_user_name, $get_my_district_member_user_alias, $get_my_district_member_user_first_name, $get_my_district_member_user_middle_name, $get_my_district_member_user_last_name, $get_my_district_member_user_email, $get_my_district_member_user_image_path, $get_my_district_member_user_image_file, $get_my_district_member_user_image_thumb_40, $get_my_district_member_user_image_thumb_50, $get_my_district_member_user_image_thumb_60, $get_my_district_member_user_image_thumb_200, $get_my_district_member_user_position, $get_my_district_member_user_department, $get_my_district_member_user_location, $get_my_district_member_user_about, $get_my_district_member_added_datetime, $get_my_district_member_added_date_saying, $get_my_district_member_added_by_user_id, $get_my_district_member_added_by_user_name, $get_my_district_member_added_by_user_alias, $get_my_district_member_added_by_user_image) = $row;
	

			if($get_my_district_member_id != ""){
				echo"
				<h1>$l_you_are_already_a_member</h1>
				";
			}
			else{
				// Check if I have applied before
				$query = "SELECT request_id, request_district_id, request_district_title, request_user_id, request_rank, request_user_name, request_user_alias, request_user_first_name, request_user_middle_name, request_user_last_name, request_user_email, request_user_image_path, request_user_image_file, request_user_image_thumb_40, request_user_image_thumb_50, request_user_image_thumb_60, request_user_image_thumb_200, request_user_position, request_user_department, request_user_location, request_user_about, request_datetime, request_date_saying FROM $t_edb_districts_membership_requests WHERE request_district_id=$get_current_district_id AND request_user_id=$my_user_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_request_id, $get_current_request_district_id, $get_current_request_district_title, $get_current_request_user_id, $get_current_request_rank, $get_current_request_user_name, $get_current_request_user_alias, $get_current_request_user_first_name, $get_current_request_user_middle_name, $get_current_request_user_last_name, $get_current_request_user_email, $get_current_request_user_image_path, $get_current_request_user_image_file, $get_current_request_user_image_thumb_40, $get_current_request_user_image_thumb_50, $get_current_request_user_image_thumb_60, $get_current_request_user_image_thumb_200, $get_current_request_user_position, $get_current_request_user_department, $get_current_request_user_location, $get_current_request_user_about, $get_current_request_datetime, $get_current_request_date_saying) = $row;
				if($get_current_request_id != ""){
					echo"
					<h1>$l_membership_request_to_district_is_already_sent $get_current_request_date_saying</h1>

					<p>$l_please_contact_administrator_if_you_have_any_questions</p>

					<p>
					<a href=\"browse_districts_and_stations.php?action=open_district&amp;district_id=$get_current_district_id&amp;l=$l\"><img src=\"_gfx/go-previous.png\" alt=\"go-previous.png\" /></a>
					<a href=\"browse_districts_and_stations.php?action=open_district&amp;district_id=$get_current_district_id&amp;l=$l\">$l_back</a>
					</p>
					";
				}
				else{
					if($get_my_user_rank == "admin" OR $get_my_user_rank == "moderator"){
						// Auto insert 
						$inp_position_mysql = quote_smart($link, $get_my_professional_position);
						$inp_department_mysql = quote_smart($link, $get_my_professional_department);
						$inp_location_mysql = quote_smart($link, $get_my_professional_company_location);
						$inp_about_mysql = quote_smart($link, $get_my_profile_about);

						// Dates
						$datetime = date("Y-m-d H:i:s");
						$date_saying = date("j M Y");

						$inp_my_user_rank_mysql = quote_smart($link, $get_my_user_rank);
						$inp_my_user_name_mysql = quote_smart($link, $get_my_user_name);
						$inp_my_user_alias_mysql = quote_smart($link, $get_my_user_alias);
						$inp_first_name_mysql = quote_smart($link, $get_my_profile_first_name);
						$inp_middle_name_mysql = quote_smart($link, $get_my_profile_middle_name);
						$inp_last_name_mysql = quote_smart($link, $get_my_profile_last_name);

						$inp_my_user_email_mysql = quote_smart($link, $get_my_user_email);

						$inp_my_image_path = "_uploads/users/images/$get_my_user_id";
						$inp_my_image_path_mysql = quote_smart($link, $inp_my_image_path);
						$inp_my_image_file_mysql = quote_smart($link, $get_my_photo_destination);
						$inp_my_image_thumb_a_mysql = quote_smart($link, $get_my_photo_thumb_40);
						$inp_my_image_thumb_b_mysql = quote_smart($link, $get_my_photo_thumb_50);
						$inp_my_image_thumb_c_mysql = quote_smart($link, $get_my_photo_thumb_60);
						$inp_my_image_thumb_d_mysql = quote_smart($link, $get_my_photo_thumb_200);


						$inp_district_title_mysql = quote_smart($link, $get_current_district_title);

						// Insert request
						mysqli_query($link, "INSERT INTO $t_edb_districts_members
						(district_member_id, district_member_district_id, district_member_district_title, district_member_user_id, district_member_rank, 
						district_member_user_name, district_member_user_alias, district_member_user_first_name, district_member_user_middle_name, district_member_user_last_name, 
						district_member_user_email, district_member_user_image_path, district_member_user_image_file, district_member_user_image_thumb_40, district_member_user_image_thumb_50, 
						district_member_user_image_thumb_60, district_member_user_image_thumb_200, district_member_user_position, district_member_user_department, district_member_user_location, 
						district_member_user_about, district_member_added_datetime, district_member_added_date_saying, district_member_added_by_user_id, district_member_added_by_user_name, 
						district_member_added_by_user_alias, district_member_added_by_user_image) 
						VALUES 
						(NULL,  $get_current_district_id, $inp_district_title_mysql, $get_my_user_id, $inp_my_user_rank_mysql, 
						$inp_my_user_name_mysql, $inp_my_user_alias_mysql, $inp_first_name_mysql, $inp_middle_name_mysql, $inp_last_name_mysql, 
						$inp_my_user_email_mysql, $inp_my_image_path_mysql, $inp_my_image_file_mysql, $inp_my_image_thumb_a_mysql, $inp_position_mysql, $inp_department_mysql, $inp_location_mysql, 
						$inp_my_image_thumb_b_mysql, $inp_my_image_thumb_c_mysql, $inp_my_image_thumb_d_mysql,
						$inp_about_mysql, '$datetime', '$date_saying', $get_my_user_id, $inp_my_user_name_mysql, 
						$inp_my_user_alias_mysql, $inp_my_image_file_mysql)")
						or die(mysqli_error($link));

						echo"
						<h1>$l_access_granted</h1>
						<p>$l_you_now_have_access</p>

						<p>
						<a href=\"browse_districts_and_stations.php?action=open_district&amp;district_id=$get_current_district_id&amp;l=$l&amp;ft=success&amp;fm=access_granted\"><img src=\"_gfx/go-previous.png\" alt=\"go-previous.png\" /></a>
						<a href=\"browse_districts_and_stations.php?action=open_district&amp;district_id=$get_current_district_id&amp;l=$l&amp;ft=success&amp;fm=access_granted\">$l_back</a>
						</p>";
					}
					else{
						if($process == "1"){
							$inp_first_name = $_POST['inp_first_name'];
							$inp_first_name = output_html($inp_first_name);
							$inp_first_name_mysql = quote_smart($link, $inp_first_name);

							$inp_middle_name = $_POST['inp_middle_name'];
							$inp_middle_name = output_html($inp_middle_name);
							$inp_middle_name_mysql = quote_smart($link, $inp_middle_name);

							$inp_last_name = $_POST['inp_last_name'];
							$inp_last_name = output_html($inp_last_name);
							$inp_last_name_mysql = quote_smart($link, $inp_last_name);

							$inp_position = $_POST['inp_position'];
							$inp_position = output_html($inp_position);
							$inp_position_mysql = quote_smart($link, $inp_position);

							$inp_department = $_POST['inp_department'];
							$inp_department = output_html($inp_department);
							$inp_department_mysql = quote_smart($link, $inp_department);

							$inp_location = $_POST['inp_location'];
							$inp_location = output_html($inp_location);
							$inp_location_mysql = quote_smart($link, $inp_location);

							$inp_about = $_POST['inp_about'];
							$inp_about = output_html($inp_about);
							$inp_about_mysql = quote_smart($link, $inp_about);

							// Name + about
							$result = mysqli_query($link, "UPDATE $t_users_profile SET profile_first_name=$inp_first_name_mysql, profile_middle_name=$inp_middle_name_mysql, profile_last_name=$inp_last_name_mysql, profile_about=$inp_about_mysql WHERE profile_user_id=$my_user_id_mysql") or die(mysqli_error($link));
							
							// Professional
							$result = mysqli_query($link, "UPDATE $t_users_professional SET 
								professional_company_location=$inp_location_mysql, 
								professional_department=$inp_department_mysql, 
								professional_position=$inp_position_mysql
								WHERE professional_user_id=$my_user_id_mysql") or die(mysqli_error($link));


							// Dates
							$datetime = date("Y-m-d H:i:s");
							$date_saying = date("j M Y");


							$inp_my_user_rank_mysql = quote_smart($link, $get_my_user_rank);
							$inp_my_user_name_mysql = quote_smart($link, $get_my_user_name);
							$inp_my_user_alias_mysql = quote_smart($link, $get_my_user_alias);
							$inp_my_user_email_mysql = quote_smart($link, $get_my_user_email);

							$inp_my_image_path = "_uploads/users/images/$get_requester_user_id";
							$inp_my_image_path_mysql = quote_smart($link, $inp_my_image_path);
							$inp_my_image_file_mysql = quote_smart($link, $get_my_photo_destination);
							$inp_my_image_thumb_a_mysql = quote_smart($link, $get_my_photo_thumb_40);
							$inp_my_image_thumb_b_mysql = quote_smart($link, $get_my_photo_thumb_50);
							$inp_my_image_thumb_c_mysql = quote_smart($link, $get_my_photo_thumb_60);
							$inp_my_image_thumb_d_mysql = quote_smart($link, $get_my_photo_thumb_200);

							$inp_district_title_mysql = quote_smart($link, $get_current_district_title);

							// Insert request
							mysqli_query($link, "INSERT INTO $t_edb_districts_membership_requests
							(request_id, request_district_id, request_district_title, request_user_id, request_rank, request_user_name, request_user_alias, request_user_first_name, request_user_middle_name, request_user_last_name, request_user_email, request_user_image_path, request_user_image_file, request_user_image_thumb_40, request_user_image_thumb_50, request_user_image_thumb_60, request_user_image_thumb_200, request_user_position, request_user_department, request_user_location, request_user_about, request_datetime, request_date_saying) 
							VALUES 
							(NULL,  $get_current_district_id, $inp_district_title_mysql, $get_my_user_id, $inp_my_user_rank_mysql, $inp_my_user_name_mysql, $inp_my_user_alias_mysql, $inp_first_name_mysql, $inp_middle_name_mysql, $inp_last_name_mysql, $inp_my_user_email_mysql, $inp_my_image_path_mysql, $inp_my_image_file_mysql, $inp_my_image_thumb_a_mysql, $inp_my_image_thumb_b_mysql, $inp_my_image_thumb_c_mysql, $inp_my_image_thumb_d_mysql, $inp_position_mysql, $inp_department_mysql, $inp_location_mysql, $inp_about_mysql, '$datetime', '$date_saying')")
							or die(mysqli_error($link));


							// Email to admins
							$subject = "Access request to district $get_current_district_title by $get_my_user_alias";
							$message = "Hello,\n\nThe user $get_my_user_alias has requested access to the district $get_current_district_title.\n";
							$message = $message . "View requests: $configSiteURLSav/edb/edit_district_members.php?district_id=$get_current_district_id\n";
							$message = $message . "--\n";
							$message = $message . "Best regards\n";
							$message = $message . "$configFromNameSav\n";
							$message = $message . "$configSiteURLSav\n";
							$headers = "From: $configFromEmailSav" . "\r\n" .
							    'X-Mailer: PHP/' . phpversion();


							$query = "SELECT member_id, member_space_id, member_rank, member_user_id, member_user_alias, member_user_email, member_user_image, member_user_about, member_added_datetime, member_added_date_saying, member_added_by_user_id, member_added_by_user_alias, member_added_by_user_image FROM $t_knowledge_spaces_members WHERE member_space_id=$get_current_space_id AND (member_rank='admin' OR member_rank='moderator')";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_member_id, $get_member_space_id, $get_member_rank, $get_member_user_id, $get_member_user_alias, $get_member_user_email, $get_member_user_image, $get_member_user_about, $get_member_added_datetime, $get_member_added_date_saying, $get_member_added_by_user_id, $get_member_added_by_user_alias, $get_member_added_by_user_image) = $row;
						
								mail($get_member_user_email, $subject, $message, $headers);
							}
					
							$url = "browse_districts_and_stations.php?action=open_district&district_id=$get_current_district_id&l=$l&ft=success&fm=request_sent";
							header("Location: $url");
							exit;
						}


						// Not member yet
						echo"
						<h1>$l_request_membership_to_district $get_current_district_title</h1>

						<!-- Focus -->
							<script>
							\$(document).ready(function(){
								\$('[name=\"inp_first_name\"]').focus();
							});
							</script>
						<!-- //Focus -->
				
						<!-- Form -->
							<form method=\"POST\" action=\"browse_districts_and_stations.php?action=apply_for_membership_to_district&amp;district_id=$get_current_district_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

							<p><b>$l_first_name</b><br />
							<input type=\"text\" name=\"inp_first_name\" value=\"$get_my_profile_first_name\" size=\"25\" />

							</p>

							<p><b>$l_middle_name</b><br />
							<input type=\"text\" name=\"inp_middle_name\" value=\"$get_my_profile_middle_name\" size=\"25\" />
							</p>

							<p><b>$l_last_name</b><br />
							<input type=\"text\" name=\"inp_last_name\" value=\"$get_my_profile_last_name\" size=\"25\" />
							</p>

							<p><b>$l_your_position</b><br />
							<input type=\"text\" name=\"inp_position\" value=\"$get_my_professional_position\" size=\"25\" />
							</p>

							<p><b>$l_your_department</b><br />
							<input type=\"text\" name=\"inp_department\" value=\"$get_my_professional_department\" size=\"25\" />
							</p>

							<p><b>$l_your_location</b><br />
							<input type=\"text\" name=\"inp_location\" value=\"$get_my_professional_company_location\" size=\"25\" />
							</p>

							<p><b>$l_about_you</b><br />
							<textarea name=\"inp_about\" rows=\"3\" cols=\"40\">";
							$get_my_profile_about = str_replace("<br />", "\n", $get_my_profile_about);
							echo"$get_my_profile_about</textarea>
							</p>

							<p>
							<input type=\"submit\" value=\"$l_send_request\" class=\"btn_default\" />
							</p>
						<!-- //Form -->

						";
					} // not admin or moderator 
				} // membership request not sent
			} // get_current_district_member_id == 
		} // district found
	} // action ==  apply_for_membership_to_district
	elseif($action == "open_station"){
		// Find station
		$station_id_mysql = quote_smart($link, $station_id);
		$query = "SELECT station_id, station_number, station_title, station_title_clean, station_district_id, station_district_title, station_icon_path, station_icon_16, station_icon_32, station_icon_260, station_number_of_cases_now FROM $t_edb_stations_index WHERE station_id=$station_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_station_id, $get_current_station_number, $get_current_station_title, $get_current_station_title_clean, $get_current_station_district_id, $get_current_station_district_title, $get_current_station_icon_path, $get_current_station_icon_16, $get_current_station_icon_32, $get_current_station_icon_260, $get_current_station_number_of_cases_now) = $row;
	
		if($get_current_station_id == ""){
			echo"
			<h1>Server error 404</h1>
			<p>Station not found.</p>
			";
		}
		else{
			// Am I a member of this station?
			$query = "SELECT station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60, station_member_user_image_thumb_200, station_member_user_position, station_member_user_department, station_member_user_location, station_member_user_about, station_member_added_datetime, station_member_added_date_saying, station_member_added_by_user_id, station_member_added_by_user_name, station_member_added_by_user_alias, station_member_added_by_user_image FROM $t_edb_stations_members WHERE station_member_station_id=$get_current_station_id AND station_member_user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_station_member_id, $get_current_station_member_station_id, $get_current_station_member_station_title, $get_current_station_member_district_id, $get_current_station_member_district_title, $get_current_station_member_user_id, $get_current_station_member_rank, $get_current_station_member_user_name, $get_current_station_member_user_alias, $get_current_station_member_first_name, $get_current_station_member_middle_name, $get_current_station_member_last_name, $get_current_station_member_user_email, $get_current_station_member_user_image_path, $get_current_station_member_user_image_file, $get_current_station_member_user_image_thumb_40, $get_current_station_member_user_image_thumb_50, $get_current_station_member_user_image_thumb_60, $get_current_station_member_user_image_thumb_200, $get_current_station_member_user_position, $get_current_station_member_user_department, $get_current_station_member_user_location, $get_current_station_member_user_about, $get_current_station_member_added_datetime, $get_current_station_member_added_date_saying, $get_current_station_member_added_by_user_id, $get_current_station_member_added_by_user_name, $get_current_station_member_added_by_user_alias, $get_current_station_member_added_by_user_image) = $row;
		
			// Find district of this station
			$query = "SELECT district_id, district_number, district_title, district_title_clean, district_icon_path, district_icon_16, district_icon_32, district_icon_260, district_number_of_stations, district_number_of_cases_now FROM $t_edb_districts_index WHERE district_id=$get_current_station_district_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_district_id, $get_current_district_number, $get_current_district_title, $get_current_district_title_clean, $get_current_district_icon_path, $get_current_district_icon_16, $get_current_district_icon_32, $get_current_district_icon_260, $get_current_district_number_of_stations, $get_current_district_number_of_cases_now) = $row;
	
			if($get_current_district_id == ""){
				echo"
				<h1>Server error 404</h1>
				<p>Station was found, but district wasnt.</p>
				";
			}
			else{
				echo"
				<h1>$get_current_station_member_station_title</h1>

				<!-- Where am I ? -->
					<p><b>$l_you_are_here:</b><br />
					<a href=\"browse_districts_and_stations.php?l=$l\">$l_districts</a>
					&gt;
					<a href=\"browse_districts_and_stations.php?action=open_district&amp;district_id=$get_current_district_id&amp;l=$l\">$get_current_district_title</a>
					&gt;
					<a href=\"browse_districts_and_stations.php?action=open_station&amp;station_id=$get_current_station_id&amp;l=$l\">$get_current_station_title</a>
					</p>
				<!-- //Where am I ? -->

				<!-- Feedback -->
				";
				if($ft != ""){
					if($fm == "changes_saved"){
						$fm = "$l_changes_saved";
					}
					else{
						$fm = ucfirst($fm);
						$fm = str_replace("_", " ", $fm);
					}
					echo"<div class=\"$ft\"><span>$fm</span></div>";
				}
				echo"	
				<!-- //Feedback -->

				<!-- Actions -->
				<p>";

				if($get_current_station_member_id == ""){
					// Im not a member of this district
					// Check if I have applied for membership before
					$query = "SELECT request_id, request_station_id, request_station_title, request_district_id, request_district_title, request_user_id, request_rank, request_user_name, request_user_alias, request_user_first_name, request_user_middle_name, request_user_last_name, request_user_email, request_user_image_path, request_user_image_file, request_user_image_thumb_40, request_user_image_thumb_50, request_user_image_thumb_60, request_user_image_thumb_200, request_user_position, request_user_department, request_user_location, request_user_about, request_datetime, request_date_saying FROM $t_edb_stations_membership_requests WHERE request_station_id=$get_current_station_id AND request_user_id=$my_user_id_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_current_request_id, $get_current_request_station_id, $get_current_request_station_title, $get_current_request_district_id, $get_current_request_district_title, $get_current_request_user_id, $get_current_request_rank, $get_current_request_user_name, $get_current_request_user_alias, $get_current_request_user_first_name, $get_current_request_user_middle_name, $get_current_request_user_last_name, $get_current_request_user_email, $get_current_request_user_image_path, $get_current_request_user_image_file, $get_current_request_user_image_thumb_40, $get_current_request_user_image_thumb_50, $get_current_request_user_image_thumb_60, $get_current_request_user_image_thumb_200, $get_current_request_user_position, $get_current_request_user_department, $get_current_request_user_location, $get_current_request_user_about, $get_current_request_datetime, $get_current_request_date_saying) = $row;
					if($get_current_request_id == ""){
						echo"
						<a href=\"browse_districts_and_stations.php?action=apply_for_membership_to_station&amp;station_id=$get_current_station_id&amp;l=$l\" class=\"btn_default\">$l_apply_for_membership_to_station</a>
						";
					}
					else{
						echo"$l_membership_request_sent";
					}
				}
				else{
					echo"$l_your_a_member_of_this_station";
				}

				echo"
				</p>
				<!-- //Actions -->

				<!-- View board -->
					<p><b>$get_current_station_title $l_menu_lowercase:</b></p>

					<div class=\"vertical\">
						<ul>
							<li><a href=\"cases_board_2_view_station.php?station_id=$get_current_station_id&amp;l=$l\">$l_view_board</a></li>
							<li><a href=\"new_case_step_3_case_information.php?district_id=$get_current_district_id&amp;station_id=$get_current_station_id&amp;l=$l\">$l_create_case</a></li>
							<li><a href=\"edit_station_members.php?station_id=$get_current_station_id&amp;l=$l\">$l_view_members</a></li>
							<li><a href=\"statistics_station.php?station_id=$get_current_station_id&amp;l=$l\">$l_view_statistics</a></li>
						</ul>
					</div>
				<!-- //View board -->
				
				";
			} // district found
		} // station found
	} // action == open_station
	elseif($action == "apply_for_membership_to_station"){
		// Find station
		$station_id_mysql = quote_smart($link, $station_id);
		$query = "SELECT station_id, station_number, station_title, station_title_clean, station_district_id, station_district_title, station_icon_path, station_icon_16, station_icon_32, station_icon_260, station_number_of_cases_now FROM $t_edb_stations_index WHERE station_id=$station_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_station_id, $get_current_station_number, $get_current_station_title, $get_current_station_title_clean, $get_current_station_district_id, $get_current_station_district_title, $get_current_station_icon_path, $get_current_station_icon_16, $get_current_station_icon_32, $get_current_station_icon_260, $get_current_station_number_of_cases_now) = $row;
	
		if($get_current_station_id == ""){
			echo"
			<h1>Server error 404</h1>
			<p>Station not found.</p>
			";
		}
		else{
			// Am I a member of this station?
			$query = "SELECT station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60, station_member_user_image_thumb_200, station_member_user_position, station_member_user_department, station_member_user_location, station_member_user_about, station_member_added_datetime, station_member_added_date_saying, station_member_added_by_user_id, station_member_added_by_user_name, station_member_added_by_user_alias, station_member_added_by_user_image FROM $t_edb_stations_members WHERE station_member_station_id=$get_current_station_id AND station_member_user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_station_member_id, $get_current_station_member_station_id, $get_current_station_member_station_title, $get_current_station_member_district_id, $get_current_station_member_district_title, $get_current_station_member_user_id, $get_current_station_member_rank, $get_current_station_member_user_name, $get_current_station_member_user_alias, $get_current_station_member_first_name, $get_current_station_member_middle_name, $get_current_station_member_last_name, $get_current_station_member_user_email, $get_current_station_member_user_image_path, $get_current_station_member_user_image_file, $get_current_station_member_user_image_thumb_40, $get_current_station_member_user_image_thumb_50, $get_current_station_member_user_image_thumb_60, $get_current_station_member_user_image_thumb_200, $get_current_station_member_user_position, $get_current_station_member_user_department, $get_current_station_member_user_location, $get_current_station_member_user_about, $get_current_station_member_added_datetime, $get_current_station_member_added_date_saying, $get_current_station_member_added_by_user_id, $get_current_station_member_added_by_user_name, $get_current_station_member_added_by_user_alias, $get_current_station_member_added_by_user_image) = $row;
		
			// Find district of this station
			$query = "SELECT district_id, district_number, district_title, district_title_clean, district_icon_path, district_icon_16, district_icon_32, district_icon_260, district_number_of_stations, district_number_of_cases_now FROM $t_edb_districts_index WHERE district_id=$get_current_station_district_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_district_id, $get_current_district_number, $get_current_district_title, $get_current_district_title_clean, $get_current_district_icon_path, $get_current_district_icon_16, $get_current_district_icon_32, $get_current_district_icon_260, $get_current_district_number_of_stations, $get_current_district_number_of_cases_now) = $row;
	
			if($get_current_district_id == ""){
				echo"
				<h1>Server error 404</h1>
				<p>Station was found, but district wasnt.</p>
				";
			}
			else{

				if($get_current_station_member_id == ""){
					// Im not a member of this district
					// Check if I have applied for membership before
					$query = "SELECT request_id, request_station_id, request_station_title, request_district_id, request_district_title, request_user_id, request_rank, request_user_name, request_user_alias, request_user_first_name, request_user_middle_name, request_user_last_name, request_user_email, request_user_image_path, request_user_image_file, request_user_image_thumb_40, request_user_image_thumb_50, request_user_image_thumb_60, request_user_image_thumb_200, request_user_position, request_user_department, request_user_location, request_user_about, request_datetime, request_date_saying FROM $t_edb_stations_membership_requests WHERE request_station_id=$get_current_station_id AND request_user_id=$my_user_id_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_current_request_id, $get_current_request_station_id, $get_current_request_station_title, $get_current_request_district_id, $get_current_request_district_title, $get_current_request_user_id, $get_current_request_rank, $get_current_request_user_name, $get_current_request_user_alias, $get_current_request_user_first_name, $get_current_request_user_middle_name, $get_current_request_user_last_name, $get_current_request_user_email, $get_current_request_user_image_path, $get_current_request_user_image_file, $get_current_request_user_image_thumb_40, $get_current_request_user_image_thumb_50, $get_current_request_user_image_thumb_60, $get_current_request_user_image_thumb_200, $get_current_request_user_position, $get_current_request_user_department, $get_current_request_user_location, $get_current_request_user_about, $get_current_request_datetime, $get_current_request_date_saying) = $row;
					if($get_current_request_id == ""){

						if($get_my_user_rank == "admin" OR $get_my_user_rank == "moderator"){
							// Auto insert 
							$inp_position_mysql = quote_smart($link, $get_my_professional_position);
							$inp_department_mysql = quote_smart($link, $get_my_professional_department);
							$inp_location_mysql = quote_smart($link, $get_my_professional_company_location);
							$inp_about_mysql = quote_smart($link, $get_my_profile_about);

							// Dates
							$datetime = date("Y-m-d H:i:s");
							$date_saying = date("j M Y");
	
							$inp_my_user_rank_mysql = quote_smart($link, $get_my_user_rank);
							$inp_my_user_name_mysql = quote_smart($link, $get_my_user_name);
							$inp_my_user_alias_mysql = quote_smart($link, $get_my_user_alias);
							$inp_first_name_mysql = quote_smart($link, $get_my_profile_first_name);
							$inp_middle_name_mysql = quote_smart($link, $get_my_profile_middle_name);
							$inp_last_name_mysql = quote_smart($link, $get_my_profile_last_name);

							$inp_my_user_email_mysql = quote_smart($link, $get_my_user_email);

							$inp_my_image_path = "_uploads/users/images/$get_my_user_id";
							$inp_my_image_path_mysql = quote_smart($link, $inp_my_image_path);
							$inp_my_image_file_mysql = quote_smart($link, $get_my_photo_destination);
							$inp_my_image_thumb_a_mysql = quote_smart($link, $get_my_photo_thumb_40);
							$inp_my_image_thumb_b_mysql = quote_smart($link, $get_my_photo_thumb_50);
							$inp_my_image_thumb_c_mysql = quote_smart($link, $get_my_photo_thumb_60);
							$inp_my_image_thumb_d_mysql = quote_smart($link, $get_my_photo_thumb_200);



							$inp_station_title_mysql = quote_smart($link, $get_current_station_title);
							$inp_request_district_title_mysql = quote_smart($link, $get_current_district_title);

							// Insert request
							mysqli_query($link, "INSERT INTO $t_edb_stations_members
							(station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60, station_member_user_image_thumb_200, station_member_user_position, station_member_user_department, station_member_user_location, station_member_user_about, station_member_added_datetime, station_member_added_date_saying, station_member_added_by_user_id, station_member_added_by_user_name, station_member_added_by_user_alias, station_member_added_by_user_image) 
							VALUES 
							(NULL,  $get_current_station_id, $inp_station_title_mysql, $get_current_district_id, $inp_request_district_title_mysql, $get_my_user_id, $inp_my_user_rank_mysql, 
						$inp_my_user_name_mysql, $inp_my_user_alias_mysql, $inp_first_name_mysql, $inp_middle_name_mysql, $inp_last_name_mysql, 
						$inp_my_user_email_mysql, $inp_my_image_path_mysql, $inp_my_image_file_mysql, $inp_my_image_thumb_a_mysql, $inp_position_mysql, $inp_department_mysql, $inp_location_mysql, 
						$inp_my_image_thumb_b_mysql, $inp_my_image_thumb_c_mysql, $inp_my_image_thumb_d_mysql,
						$inp_about_mysql, '$datetime', '$date_saying', $get_my_user_id, $inp_my_user_name_mysql, 
						$inp_my_user_alias_mysql, $inp_my_image_file_mysql)")
							or die(mysqli_error($link));

							echo"
							<h1>$l_access_granted</h1>
							<p>$l_you_now_have_access</p>

							<p>
							<a href=\"browse_districts_and_stations.php?action=open_station&amp;station_id=$get_current_station_id&amp;l=$l\"><img src=\"_gfx/go-previous.png\" alt=\"go-previous.png\" /></a>
							<a href=\"browse_districts_and_stations.php?action=open_station&amp;station_id=$get_current_station_id&amp;l=$l\">$l_back</a>
							</p>";
						}
						else{

							if($process == "1"){
								$inp_first_name = $_POST['inp_first_name'];
								$inp_first_name = output_html($inp_first_name);
								$inp_first_name_mysql = quote_smart($link, $inp_first_name);
	
								$inp_middle_name = $_POST['inp_middle_name'];
								$inp_middle_name = output_html($inp_middle_name);
								$inp_middle_name_mysql = quote_smart($link, $inp_middle_name);

								$inp_last_name = $_POST['inp_last_name'];
								$inp_last_name = output_html($inp_last_name);
								$inp_last_name_mysql = quote_smart($link, $inp_last_name);

								$inp_position = $_POST['inp_position'];
								$inp_position = output_html($inp_position);
								$inp_position_mysql = quote_smart($link, $inp_position);

								$inp_department = $_POST['inp_department'];
								$inp_department = output_html($inp_department);
								$inp_department_mysql = quote_smart($link, $inp_department);

								$inp_location = $_POST['inp_location'];
								$inp_location = output_html($inp_location);
								$inp_location_mysql = quote_smart($link, $inp_location);

								$inp_about = $_POST['inp_about'];
								$inp_about = output_html($inp_about);
								$inp_about_mysql = quote_smart($link, $inp_about);

								// Name + about
								$result = mysqli_query($link, "UPDATE $t_users_profile SET profile_first_name=$inp_first_name_mysql, profile_middle_name=$inp_middle_name_mysql, profile_last_name=$inp_last_name_mysql, profile_about=$inp_about_mysql WHERE profile_user_id=$my_user_id_mysql") or die(mysqli_error($link));
							
								// Professional
								$result = mysqli_query($link, "UPDATE $t_users_professional SET 
									professional_company_location=$inp_location_mysql, 
									professional_department=$inp_department_mysql, 
									professional_position=$inp_position_mysql
									WHERE professional_user_id=$my_user_id_mysql") or die(mysqli_error($link));


								// Dates
								$datetime = date("Y-m-d H:i:s");
								$date_saying = date("j M Y");


								$inp_my_user_rank_mysql = quote_smart($link, $get_my_user_rank);
								$inp_my_user_name_mysql = quote_smart($link, $get_my_user_name);
								$inp_my_user_alias_mysql = quote_smart($link, $get_my_user_alias);
								$inp_my_user_email_mysql = quote_smart($link, $get_my_user_email);

								$inp_my_image_path = "_uploads/users/images/$get_requester_user_id";
								$inp_my_image_path_mysql = quote_smart($link, $inp_my_image_path);
								$inp_my_image_file_mysql = quote_smart($link, $get_my_photo_destination);
								$inp_my_image_thumb_a_mysql = quote_smart($link, $get_my_photo_thumb_40);
								$inp_my_image_thumb_b_mysql = quote_smart($link, $get_my_photo_thumb_50);
								$inp_my_image_thumb_c_mysql = quote_smart($link, $get_my_photo_thumb_60);
								$inp_my_image_thumb_d_mysql = quote_smart($link, $get_my_photo_thumb_200);


	
								$inp_station_title_mysql = quote_smart($link, $get_current_station_title);

								$inp_request_district_title_mysql = quote_smart($link, $get_current_district_title);
	
								// Insert request
								mysqli_query($link, "INSERT INTO $t_edb_stations_membership_requests
								(request_id, request_station_id, request_station_title, request_district_id, request_district_title, request_user_id, request_rank, request_user_name, request_user_alias, request_user_first_name, request_user_middle_name, request_user_last_name, request_user_email, request_user_image_path, request_user_image_file, request_user_image_thumb_40, request_user_image_thumb_50, request_user_image_thumb_60, request_user_image_thumb_200, request_user_position, request_user_department, request_user_location, request_user_about, request_datetime, request_date_saying) 
								VALUES 
								(NULL,  $get_current_station_id, $inp_station_title_mysql, $get_current_district_id, $inp_request_district_title_mysql, $get_my_user_id, $inp_my_user_rank_mysql, $inp_my_user_name_mysql, $inp_my_user_alias_mysql, $inp_first_name_mysql, $inp_middle_name_mysql, $inp_last_name_mysql, $inp_my_user_email_mysql, $inp_my_image_path_mysql, $inp_my_image_file_mysql, $inp_my_image_thumb_a_mysql, $inp_my_image_thumb_b_mysql, $inp_my_image_thumb_c_mysql, $inp_my_image_thumb_d_mysql, $inp_position_mysql, $inp_department_mysql, $inp_location_mysql, $inp_about_mysql, '$datetime', '$date_saying')")
								or die(mysqli_error($link));


								// Email to admins
								$subject = "Access request to station $get_current_station_title by $get_my_user_alias";
								$message = "Hello,\n\nThe user $get_my_user_alias has requested access to the station $get_current_station_title.\n";
								$message = $message . "View requests: $configSiteURLSav/edb/edit_station_members.php?station_id=$get_current_station_id\n";
								$message = $message . "--\n";
								$message = $message . "Best regards\n";
								$message = $message . "$configFromNameSav\n";
								$message = $message . "$configSiteURLSav\n";
								$headers = "From: $configFromEmailSav" . "\r\n" .
						   		 'X-Mailer: PHP/' . phpversion();


								$query = "SELECT member_id, member_space_id, member_rank, member_user_id, member_user_alias, member_user_email, member_user_image, member_user_about, member_added_datetime, member_added_date_saying, member_added_by_user_id, member_added_by_user_alias, member_added_by_user_image FROM $t_knowledge_spaces_members WHERE member_space_id=$get_current_space_id AND (member_rank='admin' OR member_rank='moderator')";
								$result = mysqli_query($link, $query);
								while($row = mysqli_fetch_row($result)) {
									list($get_member_id, $get_member_space_id, $get_member_rank, $get_member_user_id, $get_member_user_alias, $get_member_user_email, $get_member_user_image, $get_member_user_about, $get_member_added_datetime, $get_member_added_date_saying, $get_member_added_by_user_id, $get_member_added_by_user_alias, $get_member_added_by_user_image) = $row;
						
									mail($get_member_user_email, $subject, $message, $headers);
								}
					
								$url = "browse_districts_and_stations.php?action=open_station&station_id=$get_current_station_id&l=$l&ft=success&fm=request_sent";
								header("Location: $url");
								exit;
							}

							echo"
							<h1>$l_request_membership_to_station $get_current_station_member_station_title</h1>

							<!-- Where am I ? -->
								<p><b>$l_you_are_here:</b><br />
								<a href=\"browse_districts_and_stations.php?l=$l\">$l_districts</a>
								&gt;
								<a href=\"browse_districts_and_stations.php?action=open_district&amp;district_id=$get_current_district_id&amp;l=$l\">$get_current_district_title</a>
								&gt;
								<a href=\"browse_districts_and_stations.php?action=open_station&amp;station_id=$get_current_station_id&amp;l=$l\">$get_current_station_title</a>
								</p>
							<!-- //Where am I ? -->

							<!-- Feedback -->
								";
								if($ft != ""){
									if($fm == "changes_saved"){
										$fm = "$l_changes_saved";
									}
									else{
										$fm = ucfirst($fm);
										$fm = str_replace("_", " ", $fm);
									}
									echo"<div class=\"$ft\"><span>$fm</span></div>";
								}
								echo"	
							<!-- //Feedback -->

							<!-- Focus -->
							<script>
							\$(document).ready(function(){
								\$('[name=\"inp_first_name\"]').focus();
							});
							</script>
							<!-- //Focus -->
				
							<!-- Form -->
							<form method=\"POST\" action=\"browse_districts_and_stations.php?action=apply_for_membership_to_station&amp;station_id=$get_current_station_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

							<p><b>$l_first_name</b><br />
							<input type=\"text\" name=\"inp_first_name\" value=\"$get_my_profile_first_name\" size=\"25\" />

							</p>

							<p><b>$l_middle_name</b><br />
							<input type=\"text\" name=\"inp_middle_name\" value=\"$get_my_profile_middle_name\" size=\"25\" />
							</p>

							<p><b>$l_last_name</b><br />
							<input type=\"text\" name=\"inp_last_name\" value=\"$get_my_profile_last_name\" size=\"25\" />
							</p>

							<p><b>$l_your_position</b><br />
							<input type=\"text\" name=\"inp_position\" value=\"$get_my_professional_position\" size=\"25\" />
							</p>

							<p><b>$l_your_department</b><br />
							<input type=\"text\" name=\"inp_department\" value=\"$get_my_professional_department\" size=\"25\" />
							</p>

							<p><b>$l_your_location</b><br />
							<input type=\"text\" name=\"inp_location\" value=\"$get_my_professional_company_location\" size=\"25\" />
							</p>

							<p><b>$l_about_you</b><br />
							<textarea name=\"inp_about\" rows=\"3\" cols=\"40\">";
							$get_my_profile_about = str_replace("<br />", "\n", $get_my_profile_about);
							echo"$get_my_profile_about</textarea>
							</p>

							<p>
							<input type=\"submit\" value=\"$l_send_request\" class=\"btn_default\" />
							</p>
							<!-- //Form -->

							";
						} // not admin or moderator
					}
					else{
						echo"$l_membership_request_sent";
					}
				}
				else{
					echo"$l_your_a_member_of_this_station";
				}
			} // district found
		} // station found
	} // action == open_station
} // logged in
else{
	// Log in
	echo"
	<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> $l_please_log_in...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/edb/browse_districts_and_stations.php\">
	";
} // not logged in

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/$webdesignSav/footer.php");
?>