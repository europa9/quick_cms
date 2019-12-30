<?php 
/**
*
* File: edb/new_case_step_3_case_information.php
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

/*- Language --------------------------------------------------------------------------- */
include("$root/_admin/_translations/site/$l/edb/ts_edb.php");
include("$root/_admin/_translations/site/$l/users/ts_users.php");

/*- Tables ---------------------------------------------------------------------------- */
$t_edb_case_index				= $mysqlPrefixSav . "edb_case_index";
$t_edb_case_codes				= $mysqlPrefixSav . "edb_case_codes";
$t_edb_case_codes_priority_counters		= $mysqlPrefixSav . "edb_case_codes_priority_counters";
$t_edb_case_statuses				= $mysqlPrefixSav . "edb_case_statuses";
$t_edb_case_priorities				= $mysqlPrefixSav . "edb_case_priorities";
		

$t_edb_physical_locations_index		= $mysqlPrefixSav . "edb_physical_locations_index";
$t_edb_physical_locations_directories	= $mysqlPrefixSav . "edb_physical_locations_directories";

$t_edb_software_index	= $mysqlPrefixSav . "edb_software_index";

$t_edb_human_tasks_on_new_case		= $mysqlPrefixSav . "edb_human_tasks_on_new_case";
$t_edb_human_tasks_in_case_categories	= $mysqlPrefixSav . "edb_human_tasks_in_case_categories";
$t_edb_human_tasks_in_case_tasks	= $mysqlPrefixSav . "edb_human_tasks_in_case_tasks";

/*- Tables review ---------------------------------------------------------------------- */
$t_edb_review_matrix_titles = $mysqlPrefixSav . "edb_review_matrix_titles";
$t_edb_review_matrix_fields = $mysqlPrefixSav . "edb_review_matrix_fields";

$t_edb_case_index_review_notes			= $mysqlPrefixSav . "edb_case_index_review_notes";
$t_edb_case_index_review_matrix_titles		= $mysqlPrefixSav . "edb_case_index_review_matrix_titles";
$t_edb_case_index_review_matrix_fields		= $mysqlPrefixSav . "edb_case_index_review_matrix_fields";
$t_edb_case_index_review_matrix_contents	= $mysqlPrefixSav . "edb_case_index_review_matrix_contents";


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


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_edb - $l_new_case";
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

	// Find district
	$query = "SELECT district_id, district_number, district_title, district_title_clean, district_icon_path, district_icon_16, district_icon_32, district_icon_260, district_number_of_stations, district_number_of_cases_now FROM $t_edb_districts_index WHERE district_id=$district_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_district_id, $get_current_district_number, $get_current_district_title, $get_current_district_title_clean, $get_current_district_icon_path, $get_current_district_icon_16, $get_current_district_icon_32, $get_current_district_icon_260, $get_current_district_number_of_stations, $get_current_district_number_of_cases_now) = $row;
	
	if($get_current_district_id == ""){
		echo"<h1>Server error 404</h1><p>District not found</p>";
		die;
	}
	else{
		// Find station
		$query = "SELECT station_id, station_number, station_title, station_title_clean, station_district_id, station_district_title, station_icon_path, station_icon_16, station_icon_32, station_icon_260, station_number_of_cases_now FROM $t_edb_stations_index WHERE station_id=$station_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_station_id, $get_current_station_number, $get_current_station_title, $get_current_station_title_clean, $get_current_station_district_id, $get_current_station_district_title, $get_current_station_icon_path, $get_current_station_icon_16, $get_current_station_icon_32, $get_current_station_icon_260, $get_current_station_number_of_cases_now) = $row;
	
		if($get_current_station_id == ""){
			echo"<h1>Server error 404</h1><p>Station not found</p>";
			die;
		}
		else{
			// Do I have access to the station?
			$query = "SELECT station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60, station_member_user_image_thumb_200, station_member_user_position, station_member_user_department, station_member_user_location, station_member_user_about, station_member_added_datetime, station_member_added_date_saying, station_member_added_by_user_id, station_member_added_by_user_name, station_member_added_by_user_alias, station_member_added_by_user_image FROM $t_edb_stations_members WHERE station_member_station_id=$get_current_station_id AND station_member_user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_station_member_id, $get_current_station_member_station_id, $get_current_station_member_station_title, $get_current_station_member_district_id, $get_current_station_member_district_title, $get_current_station_member_user_id, $get_current_station_member_rank, $get_current_station_member_user_name, $get_current_station_member_user_alias, $get_current_station_member_first_name, $get_current_station_member_middle_name, $get_current_station_member_last_name, $get_current_station_member_user_email, $get_current_station_member_user_image_path, $get_current_station_member_user_image_file, $get_current_station_member_user_image_thumb_40, $get_current_station_member_user_image_thumb_50, $get_current_station_member_user_image_thumb_60, $get_current_station_member_user_image_thumb_200, $get_current_station_member_user_position, $get_current_station_member_user_department, $get_current_station_member_user_location, $get_current_station_member_user_about, $get_current_station_member_added_datetime, $get_current_station_member_added_date_saying, $get_current_station_member_added_by_user_id, $get_current_station_member_added_by_user_name, $get_current_station_member_added_by_user_alias, $get_current_station_member_added_by_user_image) = $row;
		
			if($get_current_station_member_id == ""){
				echo"
				<h1>$l_new_case</h1>

				<!-- Where am I ? -->
					<p><b>$l_you_are_here:</b><br />
					<a href=\"index.php?l=$l\">$l_edb</a>
					&gt;
					<a href=\"cases_board_1_view_district.php?district_id=$get_current_district_id&amp;l=$l\">$get_current_district_title</a>
					&gt;
					<a href=\"cases_board_2_view_station.php?district_id=$get_current_district_id&amp;station_id=$get_current_station_id&amp;l=$l\">$get_current_station_title</a>
					&gt;
					<a href=\"new_case_step_3_case_information.php?district_id=$get_current_district_id&amp;station_id=$get_current_station_id&amp;$l\">$l_new_case</a>
					</p>
					<div style=\"height: 10px;\"></div>
				<!-- //Where am I ? -->

				<p>$l_your_not_a_member_of_the_station</p>

				<p>
				<a href=\"browse_districts_and_stations.php?action=open_station&amp;station_id=$get_current_station_id&amp;$l\">$l_apply_for_membership</a>
				</p>
				";
			}
			else{
				// I have to be admin, moderator or editor to create cases
				if($get_current_station_member_rank == "admin" OR $get_current_station_member_rank == "moderator" OR $get_current_station_member_rank == "editor"){

					if($process == "1"){
						$inp_number = $_POST['inp_number'];
						$inp_number = output_html($inp_number);
						$inp_number_mysql = quote_smart($link, $inp_number);

						$inp_title = $_POST['inp_title'];
						$inp_title = output_html($inp_title);
						$inp_title_mysql = quote_smart($link, $inp_title);

						$inp_title_clean = clean($inp_title);
						$inp_title_clean_mysql = quote_smart($link, $inp_title_clean);

						$inp_code_number = $_POST['inp_code_number'];
						$inp_code_number = output_html($inp_code_number);
						$inp_code_number_mysql = quote_smart($link, $inp_code_number);

						$inp_suspect_in_custody = $_POST['inp_suspect_in_custody'];
						$inp_suspect_in_custody = output_html($inp_suspect_in_custody);
						$inp_suspect_in_custody_mysql = quote_smart($link, $inp_suspect_in_custody);

						if(isset($_POST['inp_priority_id'])){
							$inp_priority_id = $_POST['inp_priority_id'];
						}
						else{
							$inp_priority_id =  "0";
						}
						$inp_priority_id = output_html($inp_priority_id);
						$inp_priority_id_mysql = quote_smart($link, $inp_priority_id);

						// inp number Empty check
						if($inp_number == ""){
							$url = "new_case_step_3_case_information.php?district_id=$get_current_district_id&station_id=$get_current_station_id&l=$l&ft=error&fm=missing_case_number&inp_title=$inp_title&inp_code_number=$inp_code_number&inp_suspect_in_custody=$inp_suspect_in_custody&inp_priority_id=$inp_priority_id";
							header("Location: $url");
							die;
						}
						else{
							if(!(is_numeric($inp_number))){
								$url = "new_case_step_3_case_information.php?district_id=$get_current_district_id&station_id=$get_current_station_id&l=$l&ft=error&fm=case_number_is_not_a_number&inp_number=$inp_number&inp_title=$inp_title&inp_code_number=$inp_code_number&inp_suspect_in_custody=$inp_suspect_in_custody&inp_priority_id=$inp_priority_id";
								header("Location: $url");
								die;
							}
							else{
								// Check that we dont have the case already, if we have - then go to that case instead (we dont want duplicates)
								$query = "SELECT case_id FROM $t_edb_case_index WHERE case_number=$inp_number_mysql";
								$result = mysqli_query($link, $query);
								$row = mysqli_fetch_row($result);
								list($get_case_id) = $row;
								if($get_case_id != ""){
									// Go to that case (open it)
							
									$url = "open_case_overview.php?case_id=$get_case_id&l=$l&ft=info&fm=case_number_" . $inp_number . "_already_exists_(ID=" . $get_case_id . ")";
									header("Location: $url");
									exit;
								}
								
							}
						}

						// Code number
						if($inp_code_number == ""){
							$url = "new_case_step_3_case_information.php?district_id=$get_current_district_id&station_id=$get_current_station_id&l=$l&ft=error&fm=missing_code_code_number&inp_number=$inp_number&inp_title=$inp_title&inp_code_number=$inp_code_number&inp_suspect_in_custody=$inp_suspect_in_custody&inp_priority_id=$inp_priority_id";
							header("Location: $url");
							die;
						}
						else{
							if(!(is_numeric($inp_code_number))){
								$url = "new_case_step_3_case_information.php?district_id=$get_current_district_id&station_id=$get_current_station_id&l=$l&ft=error&fm=code_code_number_is_not_a_number&inp_number=$inp_number&inp_title=$inp_title&inp_code_number=$inp_code_number&inp_suspect_in_custody=$inp_suspect_in_custody&inp_priority_id=$inp_priority_id";
								header("Location: $url");
								die;
							}
						}

						// Code
						$query = "SELECT code_id, code_number, code_title, code_title_clean, code_gives_priority_id, code_gives_priority_title, code_last_used_datetime, code_last_used_time, code_times_used FROM $t_edb_case_codes WHERE code_number=$inp_code_number_mysql";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_code_id, $get_code_number, $get_code_title, $get_code_title_clean, $get_code_gives_priority_id, $get_code_gives_priority_title, $get_code_last_used_datetime, $get_code_last_used_time, $get_code_times_used) = $row;
						if($get_code_id != ""){
							$inp_last_used_datetime = date("Y-m-d H:i:s");
							$inp_last_used_time = time();
							$inp_times_used = $get_code_times_used+1;

							$result = mysqli_query($link, "UPDATE $t_edb_case_codes SET 
										code_last_used_datetime='$inp_last_used_datetime', 
										code_last_used_time='$inp_last_used_time', 
										code_times_used=$inp_times_used
										 WHERE code_id=$get_code_id");

						}
						else{
							$get_code_id = "0";
						}
						$inp_code_id_mysql = quote_smart($link, $get_code_id);
						$inp_code_title_mysql = quote_smart($link, $get_code_title);
						

						// Priority
						$query = "SELECT priority_id, priority_title, priority_title_clean, priority_bg_color, priority_border_color, priority_text_color, priority_link_color, priority_weight, priority_number_of_cases_now, priority_last_used_datetime, priority_last_used_time, priority_times_used FROM $t_edb_case_priorities WHERE priority_id=$inp_priority_id_mysql";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_priority_id, $get_priority_title, $get_priority_title_clean, $get_priority_bg_color, $get_priority_border_color, $get_priority_text_color, $get_priority_link_color, $get_priority_weight, $get_priority_number_of_cases_now, $get_priority_last_used_datetime, $get_priority_last_used_time, $get_priority_times_used) = $row;
						if($get_priority_id != ""){


							$inp_number_of_cases_now = $get_priority_number_of_cases_now+1;
							$inp_last_used_datetime = date("Y-m-d H:i:s");
							$inp_last_used_time = time();
							$inp_times_used = $get_code_times_used+1;

							$result = mysqli_query($link, "UPDATE $t_edb_case_priorities SET 
										priority_number_of_cases_now=$inp_number_of_cases_now,
										priority_last_used_datetime='$inp_last_used_datetime', 
										priority_last_used_time='$inp_last_used_time', 
										priority_times_used=$inp_times_used
										 WHERE priority_id=$get_priority_id");

						}
						$inp_priority_title_mysql = quote_smart($link, $get_priority_title);


						// Status
						$query = "SELECT status_id, status_title, status_title_clean, status_bg_color, status_border_color, status_text_color, status_link_color, status_weight, status_number_of_cases_now, status_number_of_cases_max, status_show_on_front_page, status_on_given_status_do_close_case FROM $t_edb_case_statuses WHERE status_weight=1 LIMIT 0,1";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_status_id, $get_status_title, $get_status_title_clean, $get_status_bg_color, $get_status_border_color, $get_status_text_color, $get_status_link_color, $get_status_weight, $get_status_number_of_cases_now, $get_status_number_of_cases_max, $get_status_show_on_front_page, $get_status_on_given_status_do_close_case) = $row;
						if($get_status_id != ""){
							$inp_number_of_cases_now = $get_status_number_of_cases_now+1;

							$result = mysqli_query($link, "UPDATE $t_edb_case_statuses SET 
										status_number_of_cases_now=$inp_number_of_cases_now
										 WHERE status_id=$get_status_id");

						}
						$inp_status_id_mysql = quote_smart($link, $get_status_id);
						$inp_status_title_mysql = quote_smart($link, $get_status_title);
						
						// District + station
						$inp_district_title_mysql = quote_smart($link, $get_current_district_title);
						$inp_station_title_mysql = quote_smart($link, $get_current_station_title);

						// Dates
						$inp_datetime = date("Y-m-d H:i:s");
						$inp_time = time();
						$inp_date_saying = date("j M Y");
						$inp_date_ddmmyy = date("d.m.y");
						$inp_date_ddmmyyyy = date("d.m.Y");


						// Me
						$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_id=$my_user_id_mysql";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_language, $get_my_user_last_online, $get_my_user_rank, $get_my_user_login_tries) = $row;
					
						// My photo
						$query = "SELECT photo_id, photo_destination, photo_thumb_40, photo_thumb_50 FROM $t_users_profile_photo WHERE photo_user_id=$my_user_id_mysql AND photo_profile_image='1'";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_my_photo_id, $get_my_photo_destination, $get_my_photo_thumb_40, $get_my_photo_thumb_50) = $row;

						// My Profile
						$query = "SELECT profile_id, profile_first_name, profile_middle_name, profile_last_name, profile_about FROM $t_users_profile WHERE profile_user_id=$my_user_id_mysql";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_my_profile_id, $get_my_profile_first_name, $get_my_profile_middle_name, $get_my_profile_last_name, $get_my_profile_about) = $row;

						$inp_my_user_name_mysql = quote_smart($link, $get_my_user_name);
						$inp_my_user_alias_mysql = quote_smart($link, $get_my_user_alias);
						$inp_my_user_email_mysql = quote_smart($link, $get_my_user_email);
						$inp_my_user_rank_mysql = quote_smart($link, $get_my_user_rank);

						$inp_my_user_image_path = "_uploads/users/images/$get_my_user_id";
						$inp_my_user_image_path_mysql = quote_smart($link, $inp_my_user_image_path);

						$inp_my_user_image_file_mysql = quote_smart($link, $get_my_photo_destination);

						$inp_my_user_image_thumb_a_mysql = quote_smart($link, $get_my_photo_thumb_40);
						$inp_my_user_image_thumb_b_mysql = quote_smart($link, $get_my_photo_thumb_50);

						$inp_my_user_first_name_mysql = quote_smart($link, $get_my_profile_first_name);
						$inp_my_user_middle_name_mysql = quote_smart($link, $get_my_profile_middle_name);
						$inp_my_user_last_name_mysql = quote_smart($link, $get_my_profile_last_name);

						// Station path
						$query = "SELECT directory_id, directory_station_id, directory_station_title, directory_district_id, directory_district_title, directory_type, directory_address_linux, directory_address_windows, directory_address_prefered_for_agent, directory_last_checked_for_new_files_counter, directory_last_checked_for_new_files_time, directory_last_checked_for_new_files_hour, directory_last_checked_for_new_files_minute, directory_now_size_last_calculated_day, directory_now_size_last_calculated_hour, directory_now_size_last_calculated_minute, directory_now_size_mb, directory_now_size_gb, directory_available_size_mb, directory_available_size_gb, directory_available_size_percentage FROM $t_edb_stations_directories WHERE directory_station_id=$get_current_station_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_current_directory_id, $get_current_directory_station_id, $get_current_directory_station_title, $get_current_directory_district_id, $get_current_directory_district_title, $get_current_directory_type, $get_current_directory_address_linux, $get_current_directory_address_windows, $get_current_directory_address_prefered_for_agent, $get_current_directory_last_checked_for_new_files_counter, $get_current_directory_last_checked_for_new_files_time, $get_current_directory_last_checked_for_new_files_hour, $get_current_directory_last_checked_for_new_files_minute, $get_current_directory_now_size_last_calculated_day, $get_current_directory_now_size_last_calculated_hour, $get_current_directory_now_size_last_calculated_minute, $get_current_directory_now_size_mb, $get_current_directory_now_size_gb, $get_current_directory_available_size_mb, $get_current_directory_available_size_gb, $get_current_directory_available_size_percentage) = $row;


						// Case dir Linux, Windows and folder name
						$inp_case_path_windows = $get_current_directory_address_windows . "\\" . $inp_number;
						$inp_case_path_windows_mysql = quote_smart($link, $inp_case_path_windows);

						$inp_case_path_linux = $get_current_directory_address_linux . "/" . $inp_number;
						$inp_case_path_linux_mysql = quote_smart($link, $inp_case_path_linux);

						$inp_case_path_folder_name = $inp_number;
						$inp_case_path_folder_name_mysql = quote_smart($link, $inp_case_path_folder_name);



						// Insert
						mysqli_query($link, "INSERT INTO $t_edb_case_index
						(case_id, case_number, case_title, case_title_clean, case_suspect_in_custody, case_code_id, case_code_number, case_code_title, case_status_id, case_status_title, case_priority_id, case_priority_title, case_district_id, case_district_title, case_station_id, case_station_title, case_is_screened, case_confirmed_by_human, case_human_rejected, case_path_windows,
						case_path_linux, case_path_folder_name, case_created_datetime, case_created_time, case_created_date_saying, case_created_date_ddmmyy, case_created_date_ddmmyyyy, case_created_user_id, case_created_user_name, case_created_user_alias, case_created_user_email, case_created_user_image_path, case_created_user_image_file, case_created_user_image_thumb_40, case_created_user_image_thumb_50, case_created_user_first_name, case_created_user_middle_name, case_created_user_last_name, case_updated_datetime, case_updated_date, case_updated_time, case_updated_date_saying, case_updated_date_ddmmyy, case_updated_date_ddmmyyyy, case_updated_user_id, case_updated_user_name, case_updated_user_alias, case_updated_user_email, case_updated_user_image_path, case_updated_user_image_file, case_updated_user_image_thumb_40, case_updated_user_image_thumb_50, case_updated_user_first_name, case_updated_user_middle_name, case_updated_user_last_name, case_is_closed) 
						VALUES 
						(NULL, $inp_number_mysql, $inp_title_mysql, $inp_title_clean_mysql, $inp_suspect_in_custody_mysql, $inp_code_id_mysql, $inp_code_number_mysql, $inp_code_title_mysql, $inp_status_id_mysql, $inp_status_title_mysql, $inp_priority_id_mysql, $inp_priority_title_mysql, $get_current_district_id, $inp_district_title_mysql, $get_current_station_id, $inp_station_title_mysql, 0, 1, 0, $inp_case_path_windows_mysql, 
						$inp_case_path_linux_mysql, $inp_case_path_folder_name_mysql,'$inp_datetime', '$inp_time', '$inp_date_saying', '$inp_date_ddmmyy', '$inp_date_ddmmyyyy', $get_my_user_id, $inp_my_user_name_mysql, $inp_my_user_alias_mysql, $inp_my_user_email_mysql, $inp_my_user_image_path_mysql, $inp_my_user_image_file_mysql, $inp_my_user_image_thumb_a_mysql, $inp_my_user_image_thumb_b_mysql, $inp_my_user_first_name_mysql, $inp_my_user_middle_name_mysql, $inp_my_user_last_name_mysql, '$inp_datetime', '$inp_date', '$inp_time', '$inp_date_saying', '$inp_date_ddmmyy', '$inp_date_ddmmyyyy', $get_my_user_id, $inp_my_user_name_mysql, $inp_my_user_alias_mysql, $inp_my_user_email_mysql, $inp_my_user_image_path_mysql, $inp_my_user_image_file_mysql, $inp_my_user_image_thumb_a_mysql, $inp_my_user_image_thumb_b_mysql, $inp_my_user_first_name_mysql, $inp_my_user_middle_name_mysql, $inp_my_user_last_name_mysql, 0)")
						or die(mysqli_error($link));




						// Get ID
						$query = "SELECT case_id, case_number FROM $t_edb_case_index WHERE case_created_datetime='$inp_datetime' AND case_created_user_id=$get_my_user_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_case_id, $get_case_number) = $row;

						// 1) Statistics Index :: District
						$year = date("Y");
						$month = date("m");
						$month_saying = date("M");
						$day = date("d");
						$day_saying = date("D");

						$query = "SELECT stats_id, stats_year, stats_month, stats_month_saying, stats_district_id, stats_station_id, stats_user_id, stats_cases_created, stats_cases_closed FROM $t_edb_stats_index WHERE stats_year=$year AND stats_month=$month AND stats_district_id=$get_current_district_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_stats_id, $get_stats_year, $get_stats_month, $get_stats_month_saying, $get_stats_district_id, $get_stats_station_id, $get_stats_user_id, $get_stats_cases_created, $get_stats_cases_closed) = $row;
						if($get_stats_id == ""){
							mysqli_query($link, "INSERT INTO $t_edb_stats_index 
							(stats_id, stats_year, stats_month, stats_month_saying, stats_district_id, stats_station_id, stats_user_id, stats_cases_created, stats_cases_closed) 
							VALUES 
							(NULL, $year, $month, '$month_saying', $get_current_district_id, NULL, NULL, 1, 0)")
							or die(mysqli_error($link));
						}
						else{
							$inp_stats_cases_created = $get_stats_cases_created+1;
							$result_update = mysqli_query($link, "UPDATE $t_edb_stats_index SET stats_cases_created=$inp_stats_cases_created WHERE stats_id=$get_stats_id");
						}

						// 2) Statistics Index :: Station
						$query = "SELECT stats_id, stats_year, stats_month, stats_month_saying, stats_district_id, stats_station_id, stats_user_id, stats_cases_created, stats_cases_closed FROM $t_edb_stats_index WHERE stats_year=$year AND stats_month=$month AND stats_station_id=$get_current_station_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_stats_id, $get_stats_year, $get_stats_month, $get_stats_month_saying, $get_stats_district_id, $get_stats_station_id, $get_stats_user_id, $get_stats_cases_created, $get_stats_cases_closed) = $row;
						if($get_stats_id == ""){
							mysqli_query($link, "INSERT INTO $t_edb_stats_index 
							(stats_id, stats_year, stats_month, stats_month_saying, stats_district_id, stats_station_id, stats_user_id, stats_cases_created, stats_cases_closed) 
							VALUES 
							(NULL, $year, $month, '$month_saying', NULL, $get_current_station_id, NULL, 1, 0)")
							or die(mysqli_error($link));
						}
						else{
							$inp_stats_cases_created = $get_stats_cases_created+1;
							$result_update = mysqli_query($link, "UPDATE $t_edb_stats_index SET stats_cases_created=$inp_stats_cases_created WHERE stats_id=$get_stats_id");
						}

						// 3) Statistics Index :: Person
						$query = "SELECT stats_id, stats_year, stats_month, stats_month_saying, stats_district_id, stats_station_id, stats_user_id, stats_cases_created, stats_cases_closed FROM $t_edb_stats_index WHERE stats_year=$year AND stats_month=$month AND stats_user_id=$my_user_id_mysql";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_stats_id, $get_stats_year, $get_stats_month, $get_stats_month_saying, $get_stats_district_id, $get_stats_station_id, $get_stats_user_id, $get_stats_cases_created, $get_stats_cases_closed) = $row;
						if($get_stats_id == ""){
							mysqli_query($link, "INSERT INTO $t_edb_stats_index 
							(stats_id, stats_year, stats_month, stats_month_saying, stats_district_id, stats_station_id, stats_user_id, stats_cases_created, stats_cases_closed) 
							VALUES 
							(NULL, $year, $month, '$month_saying', NULL, NULL, $my_user_id_mysql, 1, 0)")
							or die(mysqli_error($link));
						}
						else{
							$inp_stats_cases_created = $get_stats_cases_created+1;
							$result_update = mysqli_query($link, "UPDATE $t_edb_stats_index SET stats_cases_created=$inp_stats_cases_created WHERE stats_id=$get_stats_id");
						}


						// Stats priority
						if($get_priority_id != ""){
							// 4) Statistics Case Priorities :: District
							$query = "SELECT stats_case_priority_id, stats_case_priority_year, stats_case_priority_month, stats_case_priority_district_id, stats_case_priority_station_id, stats_case_priority_user_id, stats_case_priority_priority_id, stats_case_priority_priority_title, stats_case_priority_counter FROM $t_edb_stats_case_priorites WHERE stats_case_priority_year=$year AND stats_case_priority_month=$month AND stats_case_priority_district_id=$get_current_district_id AND stats_case_priority_priority_id=$get_priority_id";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_stats_case_priority_id, $get_stats_case_priority_year, $get_stats_case_priority_month, $get_stats_case_priority_district_id, $get_stats_case_priority_station_id, $get_stats_case_priority_user_id, $get_stats_case_priority_priority_id, $get_stats_case_priority_priority_title, $get_stats_case_priority_counter) = $row;
							if($get_stats_case_priority_id == ""){
								mysqli_query($link, "INSERT INTO $t_edb_stats_case_priorites
								(stats_case_priority_id, stats_case_priority_year, stats_case_priority_month, stats_case_priority_district_id, stats_case_priority_station_id, stats_case_priority_user_id, stats_case_priority_priority_id, stats_case_priority_priority_title, stats_case_priority_counter) 
								VALUES 
								(NULL, $year, $month, $get_current_district_id, NULL, NULL, $get_priority_id, $inp_priority_title_mysql, 1)")
								or die(mysqli_error($link));
							}
							else{
								$inp_stats_case_priority_counter = $get_stats_case_priority_counter+1;
								$result_update = mysqli_query($link, "UPDATE $t_edb_stats_case_priorites SET stats_case_priority_counter=$inp_stats_case_priority_counter WHERE stats_case_priority_id=$get_stats_case_priority_id");
							}

							// 5) Statistics Case Priorities :: Station
							$query = "SELECT stats_case_priority_id, stats_case_priority_year, stats_case_priority_month, stats_case_priority_district_id, stats_case_priority_station_id, stats_case_priority_user_id, stats_case_priority_priority_id, stats_case_priority_priority_title, stats_case_priority_counter FROM $t_edb_stats_case_priorites WHERE stats_case_priority_year=$year AND stats_case_priority_month=$month AND stats_case_priority_station_id=$get_current_station_id AND stats_case_priority_priority_id=$get_priority_id";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_stats_case_priority_id, $get_stats_case_priority_year, $get_stats_case_priority_month, $get_stats_case_priority_district_id, $get_stats_case_priority_station_id, $get_stats_case_priority_user_id, $get_stats_case_priority_priority_id, $get_stats_case_priority_priority_title, $get_stats_case_priority_counter) = $row;
							if($get_stats_case_priority_id == ""){
								mysqli_query($link, "INSERT INTO $t_edb_stats_case_priorites
								(stats_case_priority_id, stats_case_priority_year, stats_case_priority_month, stats_case_priority_district_id, stats_case_priority_station_id, stats_case_priority_user_id, stats_case_priority_priority_id, stats_case_priority_priority_title, stats_case_priority_counter) 
								VALUES 
								(NULL, $year, $month, NULL, $get_current_station_id, NULL, $get_priority_id, $inp_priority_title_mysql, 1)")
								or die(mysqli_error($link));
							}
							else{
								$inp_stats_case_priority_counter = $get_stats_case_priority_counter+1;
								$result_update = mysqli_query($link, "UPDATE $t_edb_stats_case_priorites SET stats_case_priority_counter=$inp_stats_case_priority_counter WHERE stats_case_priority_id=$get_stats_case_priority_id");
							}

							// 6) Statistics Case Priorities :: Person
							$query = "SELECT stats_case_priority_id, stats_case_priority_year, stats_case_priority_month, stats_case_priority_district_id, stats_case_priority_station_id, stats_case_priority_user_id, stats_case_priority_priority_id, stats_case_priority_priority_title, stats_case_priority_counter FROM $t_edb_stats_case_priorites WHERE stats_case_priority_year=$year AND stats_case_priority_month=$month AND stats_case_priority_user_id=$my_user_id_mysql AND stats_case_priority_priority_id=$get_priority_id";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_stats_case_priority_id, $get_stats_case_priority_year, $get_stats_case_priority_month, $get_stats_case_priority_district_id, $get_stats_case_priority_station_id, $get_stats_case_priority_user_id, $get_stats_case_priority_priority_id, $get_stats_case_priority_priority_title, $get_stats_case_priority_counter) = $row;
							if($get_stats_case_priority_id == ""){
								mysqli_query($link, "INSERT INTO $t_edb_stats_case_priorites
								(stats_case_priority_id, stats_case_priority_year, stats_case_priority_month, stats_case_priority_district_id, stats_case_priority_station_id, stats_case_priority_user_id, stats_case_priority_priority_id, stats_case_priority_priority_title, stats_case_priority_counter) 
								VALUES 
								(NULL, $year, $month, NULL, NULL, $my_user_id_mysql, $get_priority_id, $inp_priority_title_mysql, 1)")
								or die(mysqli_error($link));
							}
							else{
								$inp_stats_case_priority_counter = $get_stats_case_priority_counter+1;
								$result_update = mysqli_query($link, "UPDATE $t_edb_stats_case_priorites SET stats_case_priority_counter=$inp_stats_case_priority_counter WHERE stats_case_priority_id=$get_stats_case_priority_id");
							}
						} // stats priority


						if($get_code_id != ""){
							// 7) Statistics Case Code :: District
							$query = "SELECT stats_case_code_id, stats_case_code_year, stats_case_code_month, stats_case_code_district_id, stats_case_code_station_id, stats_case_code_user_id, stats_case_code_code_id, stats_case_code_code_title, stats_case_code_counter FROM $t_edb_stats_case_codes WHERE stats_case_code_year=$year AND stats_case_code_month=$month AND stats_case_code_district_id=$get_current_district_id AND stats_case_code_code_id=$get_code_id";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_stats_case_code_id, $get_stats_case_code_year, $get_stats_case_code_month, $get_stats_case_code_district_id, $get_stats_case_code_station_id, $get_stats_case_code_user_id, $get_stats_case_code_code_id, $get_stats_case_code_code_title, $get_stats_case_code_counter) = $row;
							if($get_stats_case_code_id == ""){
								mysqli_query($link, "INSERT INTO $t_edb_stats_case_codes
								(stats_case_code_id, stats_case_code_year, stats_case_code_month, stats_case_code_district_id, stats_case_code_station_id, stats_case_code_user_id, stats_case_code_code_id, stats_case_code_code_title, stats_case_code_counter) 
								VALUES 
								(NULL, $year, $month, $get_current_district_id, NULL, NULL, $get_code_id, $inp_code_title_mysql, 1)")
								or die(mysqli_error($link));
							}
							else{
								$inp_stats_case_code_counter = $get_stats_case_code_counter+1;
								$result_update = mysqli_query($link, "UPDATE $t_edb_stats_case_codes SET stats_case_code_counter=$inp_stats_case_code_counter WHERE stats_case_code_id=$get_stats_case_code_id");
							}

							// 8) Statistics Case Code :: Station
							$query = "SELECT stats_case_code_id, stats_case_code_year, stats_case_code_month, stats_case_code_district_id, stats_case_code_station_id, stats_case_code_user_id, stats_case_code_code_id, stats_case_code_code_title, stats_case_code_counter FROM $t_edb_stats_case_codes WHERE stats_case_code_year=$year AND stats_case_code_month=$month AND stats_case_code_station_id=$get_current_station_id AND stats_case_code_code_id=$get_code_id";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_stats_case_code_id, $get_stats_case_code_year, $get_stats_case_code_month, $get_stats_case_code_district_id, $get_stats_case_code_station_id, $get_stats_case_code_user_id, $get_stats_case_code_code_id, $get_stats_case_code_code_title, $get_stats_case_code_counter) = $row;
							if($get_stats_case_code_id == ""){
								mysqli_query($link, "INSERT INTO $t_edb_stats_case_codes
								(stats_case_code_id, stats_case_code_year, stats_case_code_month, stats_case_code_district_id, stats_case_code_station_id, stats_case_code_user_id, stats_case_code_code_id, stats_case_code_code_title, stats_case_code_counter) 
								VALUES 
								(NULL, $year, $month, NULL, $get_current_station_id, NULL, $get_code_id, $inp_code_title_mysql, 1)")
								or die(mysqli_error($link));
							}
							else{
								$inp_stats_case_code_counter = $get_stats_case_code_counter+1;
								$result_update = mysqli_query($link, "UPDATE $t_edb_stats_case_codes SET stats_case_code_counter=$inp_stats_case_code_counter WHERE stats_case_code_id=$get_stats_case_code_id");
							}



							// 9) Statistics Case Code :: Person
							$query = "SELECT stats_case_code_id, stats_case_code_year, stats_case_code_month, stats_case_code_district_id, stats_case_code_station_id, stats_case_code_user_id, stats_case_code_code_id, stats_case_code_code_title, stats_case_code_counter FROM $t_edb_stats_case_codes WHERE stats_case_code_year=$year AND stats_case_code_month=$month AND stats_case_code_user_id=$my_user_id_mysql AND stats_case_code_code_id=$get_code_id";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_stats_case_code_id, $get_stats_case_code_year, $get_stats_case_code_month, $get_stats_case_code_district_id, $get_stats_case_code_station_id, $get_stats_case_code_user_id, $get_stats_case_code_code_id, $get_stats_case_code_code_title, $get_stats_case_code_counter) = $row;
							if($get_stats_case_code_id == ""){
								mysqli_query($link, "INSERT INTO $t_edb_stats_case_codes
								(stats_case_code_id, stats_case_code_year, stats_case_code_month, stats_case_code_district_id, stats_case_code_station_id, stats_case_code_user_id, stats_case_code_code_id, stats_case_code_code_title, stats_case_code_counter) 
								VALUES 
								(NULL, $year, $month, NULL, NULL, $my_user_id_mysql, $get_code_id, $inp_code_title_mysql, 1)")
								or die(mysqli_error($link));
							}
							else{
								$inp_stats_case_code_counter = $get_stats_case_code_counter+1;
								$result_update = mysqli_query($link, "UPDATE $t_edb_stats_case_codes SET stats_case_code_counter=$inp_stats_case_code_counter WHERE stats_case_code_id=$get_stats_case_code_id");
							}


						} // stats code

							
						// Cases statuses per day
						// Cases statuses per day :: 4) District
						$inp_status_title_mysql = quote_smart($link, $get_status_title);
						$inp_status_weight_mysql = quote_smart($link, $get_status_weight);
		
						$query = "SELECT status_per_day_id, status_per_day_year, status_per_day_month, status_per_day_day, status_per_day_district_id, status_per_day_station_id, status_per_day_user_id, status_per_day_status_id, status_per_day_status_title, status_per_day_weight, status_per_day_counter, status_per_day_avg_spent_time, status_per_day_avg_spent_days, status_per_day_avg_spent_saying FROM $t_edb_stats_statuses_per_day WHERE status_per_day_year=$year AND status_per_day_month=$month AND status_per_day_day=$day AND status_per_day_district_id=$get_current_district_id AND status_per_day_status_id=$get_status_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_status_per_day_id, $get_status_per_day_year, $get_status_per_day_month, $get_status_per_day_day, $get_status_per_day_district_id, $get_status_per_day_station_id, $get_status_per_day_user_id, $get_status_per_day_status_id, $get_status_per_day_status_title, $get_status_per_day_weight, $get_status_per_day_counter, $get_status_per_day_avg_spent_time, $get_status_per_day_avg_spent_days, $get_status_per_day_avg_spent_saying) = $row;
						if($get_status_per_day_id == ""){
							mysqli_query($link, "INSERT INTO $t_edb_stats_statuses_per_day 
							(status_per_day_id, status_per_day_year, status_per_day_month, status_per_day_day, status_per_day_day_saying, status_per_day_district_id, status_per_day_station_id, status_per_day_user_id, status_per_day_status_id, status_per_day_status_title, status_per_day_weight, status_per_day_counter, status_per_day_avg_spent_time, status_per_day_avg_spent_days, status_per_day_avg_spent_saying) 
							VALUES 
							(NULL, $year, $month, '$day', '$day_saying', $get_current_district_id, NULL, NULL, $get_status_id, $inp_status_title_mysql, $inp_status_weight_mysql, 1, 0, 0, 0)")
							or die(mysqli_error($link));
						}
						else{
							$inp_status_per_day_counter = $get_status_per_day_counter+1;
							$result_update = mysqli_query($link, "UPDATE $t_edb_stats_statuses_per_day SET 
											status_per_day_counter=$inp_status_per_day_counter
											 WHERE status_per_day_id=$get_status_per_day_id");
						}

						// Cases statuses per day :: 5) Station
						$query = "SELECT status_per_day_id, status_per_day_year, status_per_day_month, status_per_day_day, status_per_day_district_id, status_per_day_station_id, status_per_day_user_id, status_per_day_status_id, status_per_day_status_title, status_per_day_weight, status_per_day_counter, status_per_day_avg_spent_time, status_per_day_avg_spent_days, status_per_day_avg_spent_saying FROM $t_edb_stats_statuses_per_day WHERE status_per_day_year=$year AND status_per_day_month=$month AND status_per_day_day=$day AND status_per_day_station_id=$get_current_station_id AND status_per_day_status_id=$get_status_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_status_per_day_id, $get_status_per_day_year, $get_status_per_day_month, $get_status_per_day_day, $get_status_per_day_district_id, $get_status_per_day_station_id, $get_status_per_day_user_id, $get_status_per_day_status_id, $get_status_per_day_status_title, $get_status_per_day_weight, $get_status_per_day_counter, $get_status_per_day_avg_spent_time, $get_status_per_day_avg_spent_days, $get_status_per_day_avg_spent_saying) = $row;
						if($get_status_per_day_id == ""){
							mysqli_query($link, "INSERT INTO $t_edb_stats_statuses_per_day 
							(status_per_day_id, status_per_day_year, status_per_day_month, status_per_day_day, status_per_day_day_saying, status_per_day_district_id, status_per_day_station_id, status_per_day_user_id, status_per_day_status_id, status_per_day_status_title, status_per_day_weight, status_per_day_counter, status_per_day_avg_spent_time, status_per_day_avg_spent_days, status_per_day_avg_spent_saying) 
							VALUES 
							(NULL, $year, $month, '$day', '$day_saying', NULL, $get_current_station_id, NULL, $get_status_id, $inp_status_title_mysql, $inp_status_weight_mysql, 1, 0, 0, 0)")
							or die(mysqli_error($link));
						}
						else{
							$inp_status_per_day_counter = $get_status_per_day_counter+1;
							$result_update = mysqli_query($link, "UPDATE $t_edb_stats_statuses_per_day SET 
											status_per_day_counter=$inp_status_per_day_counter
											 WHERE status_per_day_id=$get_status_per_day_id");
						}

						// Cases statuses per day :: 6) Person
						$query = "SELECT status_per_day_id, status_per_day_year, status_per_day_month, status_per_day_day, status_per_day_district_id, status_per_day_station_id, status_per_day_user_id, status_per_day_status_id, status_per_day_status_title, status_per_day_weight, status_per_day_counter, status_per_day_avg_spent_time, status_per_day_avg_spent_days, status_per_day_avg_spent_saying FROM $t_edb_stats_statuses_per_day WHERE status_per_day_year=$year AND status_per_day_month=$month AND status_per_day_day=$day AND status_per_day_user_id=$my_user_id_mysql AND status_per_day_status_id=$get_status_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_status_per_day_id, $get_status_per_day_year, $get_status_per_day_month, $get_status_per_day_day, $get_status_per_day_district_id, $get_status_per_day_station_id, $get_status_per_day_user_id, $get_status_per_day_status_id, $get_status_per_day_status_title, $get_status_per_day_weight, $get_status_per_day_counter, $get_status_per_day_avg_spent_time, $get_status_per_day_avg_spent_days, $get_status_per_day_avg_spent_saying) = $row;
						if($get_status_per_day_id == ""){
							mysqli_query($link, "INSERT INTO $t_edb_stats_statuses_per_day 
							(status_per_day_id, status_per_day_year, status_per_day_month, status_per_day_day, status_per_day_day_saying, status_per_day_district_id, status_per_day_station_id, status_per_day_user_id, status_per_day_status_id, status_per_day_status_title, status_per_day_weight, status_per_day_counter, status_per_day_avg_spent_time, status_per_day_avg_spent_days, status_per_day_avg_spent_saying) 
							VALUES 
							(NULL, $year, $month, '$day', '$day_saying', NULL, NULL, $my_user_id_mysql, $get_status_id, $inp_status_title_mysql, $inp_status_weight_mysql, 1, 0, 0, 0)")
							or die(mysqli_error($link));
						}
						else{
							$inp_status_per_day_counter = $get_status_per_day_counter+1;
							$result_update = mysqli_query($link, "UPDATE $t_edb_stats_statuses_per_day SET 
											status_per_day_counter=$inp_status_per_day_counter
											 WHERE status_per_day_id=$get_status_per_day_id");
						}


						// Human tasks
						$query = "SELECT new_case_id, new_case_title, new_case_priority_id, new_case_priority_title, new_case_deadline_days FROM $t_edb_human_tasks_on_new_case ORDER BY new_case_priority_id ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_new_case_id, $get_new_case_title, $get_new_case_priority_id, $get_new_case_priority_title, $get_new_case_deadline_days) = $row;
							
							// Deadline 1 week
							$inp_deadline_day   = date("d", strtotime("+$get_new_case_deadline_days day"));
							$inp_deadline_month = date("m", strtotime("+$get_new_case_deadline_days day"));
							$inp_deadline_year  = date("Y", strtotime("+$get_new_case_deadline_days day"));
		
							$inp_deadline_date = $inp_deadline_year . "-" . $inp_deadline_month . "-" . $inp_deadline_day;
							$inp_deadline_date_mysql = quote_smart($link, $inp_deadline_date);

							$inp_deadline_time = strtotime($inp_deadline_date);
							$inp_deadline_time_mysql = quote_smart($link, $inp_deadline_time);


							$l_month_array[0] = "";
							$l_month_array[1] = "$l_month_january";
							$l_month_array[2] = "$l_month_february";
							$l_month_array[3] = "$l_month_march";
							$l_month_array[4] = "$l_month_april";
							$l_month_array[5] = "$l_month_may";
							$l_month_array[6] = "$l_month_june";
							$l_month_array[7] = "$l_month_juli";
							$l_month_array[8] = "$l_month_august";
							$l_month_array[9] = "$l_month_september";
							$l_month_array[10] = "$l_month_october";
							$l_month_array[11] = "$l_month_november";
							$l_month_array[12] = "$l_month_december";
							$inp_deadline_day_saying = str_replace("0", "", $inp_deadline_day);
							$inp_deadline_month_saying = str_replace("0", "", $inp_deadline_month);
				
							$inp_deadline_date_saying  = $inp_deadline_day . ". " . $l_month_array[$inp_deadline_month_saying] . " " . $inp_deadline_year;
							$inp_deadline_date_saying_mysql = quote_smart($link, $inp_deadline_date_saying);

							$inp_deadline_date_ddmmyy = $inp_deadline_day . "." . $inp_deadline_month . "." . substr($inp_deadline_year,2,2);
							$inp_deadline_date_ddmmyy_mysql = quote_smart($link, $inp_deadline_date_ddmmyy);

							$inp_deadline_date_ddmmyyyy = $inp_deadline_day . "." . $inp_deadline_month . "." . $inp_deadline_year;
							$inp_deadline_date_ddmmyyyy_mysql = quote_smart($link, $inp_deadline_date_ddmmyyyy);

							// Deadline week
							$inp_deadline_week = date("W", $inp_deadline_time);
							$inp_deadline_week_mysql = quote_smart($link, $inp_deadline_week);

							$inp_deadline_year = date("Y", $inp_deadline_time);
							$inp_deadline_year_mysql = quote_smart($link, $inp_deadline_year);

							// Priority
							$inp_new_case_priority_title_mysql = quote_smart($link, $get_new_case_priority_title);


							// Text
							$inp_text_mysql = quote_smart($link, $get_new_case_title);
	


							// Insert
							mysqli_query($link, "INSERT INTO $t_edb_case_index_human_tasks
							(human_task_id, human_task_case_id, human_task_case_number, human_task_evidence_record_id, human_task_evidence_item_id, 
							human_task_district_id,	human_task_district_title, human_task_station_id, human_task_station_title, human_task_text, 
							human_task_priority_id, human_task_priority_title, human_task_created_datetime, human_task_created_time, human_task_created_date_saying, 
							human_task_created_date_ddmmyy, human_task_created_date_ddmmyyyy, human_task_deadline_date, human_task_deadline_time, human_task_deadline_date_saying, 
							human_task_deadline_date_ddmmyy, human_task_deadline_date_ddmmyyyy, human_task_deadline_week, human_task_deadline_year, human_task_sent_deadline_notification, human_task_is_finished, 
							human_task_created_by_user_id, human_task_created_by_user_rank, human_task_created_by_user_name, human_task_created_by_user_alias, human_task_created_by_user_email, 
							human_task_created_by_user_image_path, human_task_created_by_user_image_file, human_task_created_by_user_image_thumb_40, human_task_created_by_user_image_thumb_50, 
							human_task_created_by_user_first_name, human_task_created_by_user_middle_name, human_task_created_by_user_last_name, human_task_responsible_user_id, human_task_responsible_user_name, 
							human_task_responsible_user_alias, human_task_responsible_user_email, human_task_responsible_user_image_path, human_task_responsible_user_image_file, human_task_responsible_user_image_thumb_40, 
							human_task_responsible_user_image_thumb_50, human_task_responsible_user_first_name, human_task_responsible_user_middle_name, human_task_responsible_user_last_name) 
							VALUES 
							(NULL, $get_case_id, $get_case_number, '0', '0', $get_current_district_id, 
							$inp_district_title_mysql, $get_current_station_id, $inp_station_title_mysql, $inp_text_mysql, $get_new_case_priority_id,
							$inp_new_case_priority_title_mysql, 
							'$inp_datetime', '$inp_time', '$inp_date_saying', '$inp_date_ddmmyy', '$inp_date_ddmmyyyy', $inp_deadline_date_mysql,
							$inp_deadline_time_mysql, $inp_deadline_date_saying_mysql, $inp_deadline_date_ddmmyy_mysql, $inp_deadline_date_ddmmyyyy_mysql, $inp_deadline_week_mysql, $inp_deadline_year_mysql, '0', '0', '$get_my_user_id',
							$inp_my_user_rank_mysql, 
							$inp_my_user_name_mysql, $inp_my_user_alias_mysql, $inp_my_user_email_mysql, $inp_my_user_image_path_mysql, $inp_my_user_image_file_mysql, $inp_my_user_image_thumb_a_mysql, $inp_my_user_image_thumb_b_mysql, $inp_my_user_first_name_mysql, $inp_my_user_middle_name_mysql, $inp_my_user_last_name_mysql,
							'$get_my_user_id',
							$inp_my_user_name_mysql, $inp_my_user_alias_mysql, $inp_my_user_email_mysql, $inp_my_user_image_path_mysql, $inp_my_user_image_file_mysql, $inp_my_user_image_thumb_a_mysql, $inp_my_user_image_thumb_b_mysql, $inp_my_user_first_name_mysql, $inp_my_user_middle_name_mysql, $inp_my_user_last_name_mysql)")
							or die(mysqli_error($link));

						}

						// Review titles
						$query = "SELECT title_id, title_name, title_weight, title_colspan, title_headcell_text_color, title_headcell_bg_color, title_headcell_border_color_edge, title_headcell_border_color_center, title_bodycell_text_color, title_bodycell_bg_color, title_bodycell_border_color_edge, title_bodycell_border_color_center, title_subcell_text_color, title_subcell_bg_color, title_subcell_border_color_edge, title_subcell_border_color_center FROM $t_edb_review_matrix_titles ORDER BY title_weight ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_title_id, $get_title_name, $get_title_weight, $get_title_colspan, $get_title_headcell_text_color, $get_title_headcell_bg_color, $get_title_headcell_border_color_edge, $get_title_headcell_border_color_center, $get_title_bodycell_text_color, $get_title_bodycell_bg_color, $get_title_bodycell_border_color_edge, $get_title_bodycell_border_color_center, $get_title_subcell_text_color, $get_title_subcell_bg_color, $get_title_subcell_border_color_edge, $get_title_subcell_border_color_center) = $row;
							
							$inp_title_name_mysql = quote_smart($link, $get_title_name);
							$inp_title_weight_mysql = quote_smart($link, $get_title_weight);
							$inp_title_colspan_mysql = quote_smart($link, $get_title_colspan);

							$inp_title_headcell_text_color_mysql = quote_smart($link, $get_title_headcell_text_color);
							$inp_title_headcell_bg_color_mysql = quote_smart($link, $get_title_headcell_bg_color);
							$inp_title_headcell_border_color_edge_mysql = quote_smart($link, $get_title_headcell_border_color_edge);
							$inp_title_headcell_border_color_center_mysql = quote_smart($link, $get_title_headcell_border_color_center);

							$inp_title_bodycell_text_color_mysql = quote_smart($link, $get_title_bodycell_text_color);
							$inp_title_bodycell_bg_color_mysql = quote_smart($link, $get_title_bodycell_bg_color);
							$inp_title_bodycell_border_color_edge_mysql = quote_smart($link, $get_title_bodycell_border_color_edge);
							$inp_title_bodycell_border_color_center_mysql = quote_smart($link, $get_title_bodycell_border_color_center);

							$inp_title_subcell_text_color_mysql = quote_smart($link, $get_title_subcell_text_color);
							$inp_title_subcell_bg_color_mysql = quote_smart($link, $get_title_subcell_bg_color);
							$inp_title_subcell_border_color_edge_mysql = quote_smart($link, $get_title_subcell_border_color_edge);
							$inp_title_subcell_border_color_center_mysql = quote_smart($link, $get_title_subcell_border_color_center);

			
							// Insert
							mysqli_query($link, "INSERT INTO $t_edb_case_index_review_matrix_titles
							(title_id, title_case_id, title_name, title_weight, title_colspan, title_headcell_text_color, title_headcell_bg_color, title_headcell_border_color_edge, title_headcell_border_color_center, title_bodycell_text_color, title_bodycell_bg_color, title_bodycell_border_color_edge, title_bodycell_border_color_center, title_subcell_text_color, title_subcell_bg_color, title_subcell_border_color_edge, title_subcell_border_color_center) 
							VALUES 
							(NULL, $get_case_id, $inp_title_name_mysql, $inp_title_weight_mysql, $inp_title_colspan_mysql, $inp_title_headcell_text_color_mysql, $inp_title_headcell_bg_color_mysql, $inp_title_headcell_border_color_edge_mysql, $inp_title_headcell_border_color_center_mysql, $inp_title_bodycell_text_color_mysql, $inp_title_bodycell_bg_color_mysql, $inp_title_bodycell_border_color_edge_mysql, $inp_title_bodycell_border_color_center_mysql, $inp_title_subcell_text_color_mysql, $inp_title_subcell_bg_color_mysql, $inp_title_subcell_border_color_edge_mysql, $inp_title_subcell_border_color_center_mysql)")
							or die(mysqli_error($link));
	
							// Get this title ID
							$query_title = "SELECT title_id, title_case_id, title_name FROM $t_edb_case_index_review_matrix_titles WHERE title_case_id=$get_case_id AND title_name=$inp_title_name_mysql";
							$result_title = mysqli_query($link, $query_title);
							$row_titles = mysqli_fetch_row($result_title);
							list($get_case_index_review_matrix_title_id, $get_case_index_review_matrix_title_case_id, $get_case_index_review_matrix_title_name) = $row_titles;


							// Review fields
							$query_fields = "SELECT field_id, field_name, field_title_id, field_title_name, field_weight, field_type, field_size, field_alt_a, field_alt_b, field_alt_c, field_alt_d, field_alt_e, field_alt_f, field_alt_g, field_alt_h, field_alt_i, field_alt_j, field_alt_k, field_alt_l, field_alt_m FROM $t_edb_review_matrix_fields WHERE field_title_id=$get_title_id ORDER BY field_title_id, field_weight ASC";
							$result_fields = mysqli_query($link, $query_fields);
							while($row_fields = mysqli_fetch_row($result_fields)) {
								list($get_field_id, $get_field_name, $get_field_title_id, $get_field_title_name, $get_field_weight, $get_field_type, $get_field_size, $get_field_alt_a, $get_field_alt_b, $get_field_alt_c, $get_field_alt_d, $get_field_alt_e, $get_field_alt_f, $get_field_alt_g, $get_field_alt_h, $get_field_alt_i, $get_field_alt_j, $get_field_alt_k, $get_field_alt_l, $get_field_alt_m) = $row_fields;
							


								$inp_field_name_mysql = quote_smart($link, $get_field_name);
								$inp_field_title_id_mysql = quote_smart($link, $get_case_index_review_matrix_title_id);
								$inp_field_title_name_mysql = quote_smart($link, $get_case_index_review_matrix_title_name);
								$inp_field_weight_mysql = quote_smart($link, $get_field_weight);
								$inp_field_type_mysql = quote_smart($link, $get_field_type);
								$inp_field_size_mysql = quote_smart($link, $get_field_size);
								$inp_field_alt_a_mysql = quote_smart($link, $get_field_alt_a);
								$inp_field_alt_b_mysql = quote_smart($link, $get_field_alt_b);
								$inp_field_alt_c_mysql = quote_smart($link, $get_field_alt_c);
								$inp_field_alt_d_mysql = quote_smart($link, $get_field_alt_d);
								$inp_field_alt_e_mysql = quote_smart($link, $get_field_alt_e);
								$inp_field_alt_f_mysql = quote_smart($link, $get_field_alt_f);
								$inp_field_alt_g_mysql = quote_smart($link, $get_field_alt_g);
								$inp_field_alt_h_mysql = quote_smart($link, $get_field_alt_h);
								$inp_field_alt_i_mysql = quote_smart($link, $get_field_alt_i);
								$inp_field_alt_j_mysql = quote_smart($link, $get_field_alt_j);
								$inp_field_alt_k_mysql = quote_smart($link, $get_field_alt_k);
								$inp_field_alt_l_mysql = quote_smart($link, $get_field_alt_l);
								$inp_field_alt_m_mysql = quote_smart($link, $get_field_alt_m);


			
								// Insert
								mysqli_query($link, "INSERT INTO $t_edb_case_index_review_matrix_fields
								(field_id, field_case_id, field_name, field_title_id, field_title_name, field_weight, field_type, field_size, field_alt_a, field_alt_b, field_alt_c, field_alt_d, field_alt_e, field_alt_f, field_alt_g, field_alt_h, field_alt_i, field_alt_j, field_alt_k, field_alt_l, field_alt_m) 
								VALUES 
								(NULL, $get_case_id, $inp_field_name_mysql, $inp_field_title_id_mysql, $inp_field_title_name_mysql, $inp_field_weight_mysql, $inp_field_type_mysql, $inp_field_size_mysql, $inp_field_alt_a_mysql, $inp_field_alt_b_mysql, $inp_field_alt_c_mysql, $inp_field_alt_d_mysql, $inp_field_alt_e_mysql, $inp_field_alt_f_mysql, $inp_field_alt_g_mysql, $inp_field_alt_h_mysql, $inp_field_alt_i_mysql, $inp_field_alt_j_mysql, $inp_field_alt_k_mysql, $inp_field_alt_l_mysql, $inp_field_alt_m_mysql)")
								or die(mysqli_error($link));
	
							}

						}




						// Priority counter
						// -> Check that the priority exists for case code 
						$year = date("Y");
						$query = "SELECT priority_counter_id, priority_counter_year, priority_counter_case_code_id, priority_counter_case_code_title, priority_counter_priority_id, priority_counter_priority_title, priority_counter_count FROM $t_edb_case_codes_priority_counters WHERE priority_counter_year=$year AND priority_counter_case_code_id=$get_code_id AND priority_counter_priority_id=$get_priority_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_priority_counter_id, $get_priority_counter_year, $get_priority_counter_case_code_id, $get_priority_counter_case_code_title, $get_priority_counter_priority_id, $get_priority_counter_priority_title, $get_priority_counter_count) = $row;
						if($get_priority_counter_id == ""){
							// Insert
							mysqli_query($link, "INSERT INTO $t_edb_case_codes_priority_counters
							(priority_counter_id, priority_counter_year, priority_counter_case_code_id, priority_counter_case_code_title, priority_counter_priority_id, priority_counter_priority_title, priority_counter_count) 
							VALUES 
							(NULL, $year, $get_code_id, $inp_code_title_mysql, $get_priority_id, $inp_priority_title_mysql, 1)")
							or die(mysqli_error($link));
						}
						else{
							// Update
							$inp_counter = $get_priority_counter_count+1;
							$result_update = mysqli_query($link, "UPDATE $t_edb_case_codes_priority_counters SET 
											priority_counter_count=$inp_counter
											 WHERE priority_counter_id=$get_priority_counter_id");
						}

						// -> Should we update priority for the case code?
						$case_code_feedback = "";
						$query = "SELECT priority_counter_id, priority_counter_year, priority_counter_case_code_id, priority_counter_case_code_title, priority_counter_priority_id, priority_counter_priority_title, priority_counter_count FROM $t_edb_case_codes_priority_counters WHERE priority_counter_year=$year AND priority_counter_case_code_id=$get_code_id ORDER BY priority_counter_priority_id ASC LIMIT 0,1";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_top_priority_counter_id, $get_top_priority_counter_year, $get_top_priority_counter_case_code_id, $get_top_priority_counter_case_code_title, $get_top_priority_counter_priority_id, $get_top_priority_counter_priority_title, $get_top_priority_counter_count) = $row;
						if($get_top_priority_counter_case_code_id != "$get_code_gives_priority_id"){
							$inp_case_code_title_mysql = quote_smart($link, $get_top_priority_counter_priority_title);

							$result_update = mysqli_query($link, "UPDATE $t_edb_case_codes SET 
											code_gives_priority_id=$get_top_priority_counter_case_code_id,
											code_gives_priority_title=$inp_case_code_title_mysql
											 WHERE code_id=$get_code_id") or die(mysqli_error($link));

							$case_code_feedback = "._Updated_$get_code_title" . "_to_" . $get_top_priority_counter_priority_title . ".";
						}

						$url = "cases_board_2_view_station.php?district_id=$get_current_district_id&station_id=$get_current_station_id&l=$l&ft=success&fm=case_number_" . $inp_number . "_created_(ID=" . $get_case_id . ")" . $case_code_feedback;
						header("Location: $url");
						exit;
					}
					echo"
					<h1>$l_new_case</h1>

					<!-- Where am I ? -->
						<p><b>$l_you_are_here:</b><br />
						<a href=\"index.php?l=$l\">$l_edb</a>
						&gt;
						<a href=\"cases_board_1_view_district.php?district_id=$get_current_district_id&amp;l=$l\">$get_current_district_title</a>
						&gt;
						<a href=\"cases_board_2_view_station.php?district_id=$get_current_district_id&amp;station_id=$get_current_station_id&amp;l=$l\">$get_current_station_title</a>
						&gt;
						<a href=\"new_case_step_3_case_information.php?district_id=$get_current_district_id&amp;station_id=$get_current_station_id&amp;$l\">$l_new_case</a>
						</p>
						<div style=\"height: 10px;\"></div>
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

					<!-- New case form -->

						<!-- Focus -->
							<script>
							\$(document).ready(function(){
								\$('[name=\"inp_number\"]').focus();
							});
							</script>
						<!-- //Focus -->

						<form method=\"POST\" action=\"new_case_step_3_case_information.php?district_id=$get_current_district_id&amp;station_id=$get_current_station_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

						<p><b>$l_case_number*:</b><br />
						<input type=\"text\" name=\"inp_number\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\"";
						if(isset($_GET['inp_number'])){
							$inp_number = $_GET['inp_number'];
							$inp_number = output_html($inp_number);
							echo" value=\"$inp_number\""; 
						}
						echo" />
						</p>

						<p><b>$l_case_code*:</b> (<a href=\"$root/_admin/index.php?open=edb&amp;page=case_codes&amp;editor_language=$l&amp;l=$l\" target=\"_blank\">$l_edit</a>)<br />
						<input type=\"text\" name=\"inp_code_number\" id=\"inp_code_autosearch\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\"";
						if(isset($_GET['inp_code_number'])){
							$inp_code_number = $_GET['inp_code_number'];
							$inp_code_number = output_html($inp_code_number);
							echo" value=\"$inp_code_number\""; 
						}
						echo" />
						<span id=\"inp_code_title\"></span></p>

						<!-- case_code Search script -->
							<script id=\"source\" language=\"javascript\" type=\"text/javascript\">
							\$(document).ready(function () {
								\$('#inp_code_autosearch').keyup(function () {
									

       									// getting the value that user typed
       									var searchString    = $(\"#inp_code_autosearch\").val();
 									// forming the queryString
      									var data            = 'l=$l&q='+ searchString;
         
        								// if searchString is not empty
        								if(searchString) {
										
           									// ajax call
            									\$.ajax({
                									type: \"POST\",
               										url: \"new_case_step_3_case_information_case_code_search.php\",
                									data: data,
											beforeSend: function(html) { // this happens before actual call
												\$(\"#autosearch_search_results_show\").html(''); 
											},
               										success: function(html){
                    										\$(\"#autosearch_search_results_show\").append(html);
              										}
            									});
       									}
        								return false;
            							});
         				   		});
							</script>
							<div id=\"autosearch_search_results_show\"></div>
						<!-- //Search script -->

						<p><b>$l_case_title:</b><br />
						<input type=\"text\" name=\"inp_title\" id=\"inp_title\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\"";
						if(isset($_GET['inp_title'])){
							$inp_title = $_GET['inp_title'];
							$inp_title = output_html($inp_title);
							echo" value=\"$inp_title\""; 
						}
						echo" />
						</p>

						<p><b>$l_suspect_in_custody:</b><br />";
						if(isset($_GET['inp_suspect_in_custody'])){
							$inp_suspect_in_custody = $_GET['inp_suspect_in_custody'];
							$inp_suspect_in_custody = output_html($inp_suspect_in_custody);
							
						}
						else{
							$inp_suspect_in_custody = "0";
						}
						echo"
						<input type=\"radio\" name=\"inp_suspect_in_custody\" value=\"1\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\""; if($inp_suspect_in_custody == "1"){ echo" checked=\"checked\""; } echo" />
						$l_yes
						&nbsp; &nbsp;
						<input type=\"radio\" name=\"inp_suspect_in_custody\" value=\"0\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\""; if($inp_suspect_in_custody == "0"){ echo" checked=\"checked\""; } echo" />
						$l_no
						</p>


						<p><b>$l_priority*:</b> (<a href=\"$root/_admin/index.php?open=edb&amp;page=priorities&amp;editor_language=$l&amp;l=$l\" target=\"_blank\">$l_edit</a>)<br />
						";
						if(isset($_GET['inp_priority_id'])){
							$inp_priority_id = $_GET['inp_priority_id'];
							$inp_priority_id = output_html($inp_priority_id);
							
						}
						else{
							$inp_priority_id = "0";
						}
						echo"
						<select name=\"inp_priority_id\" id=\"inp_priority\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">\n";
						$query = "SELECT priority_id, priority_title, priority_title_clean, priority_bg_color, priority_border_color, priority_text_color, priority_link_color, priority_weight, priority_number_of_cases_now FROM $t_edb_case_priorities ORDER BY priority_weight ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_priority_id, $get_priority_title, $get_priority_title_clean, $get_priority_bg_color, $get_priority_border_color, $get_priority_text_color, $get_priority_link_color, $get_priority_weight, $get_priority_number_of_cases_now) = $row;
							echo"							";
							echo"<option value=\"$get_priority_id\""; if($inp_priority_id == "$get_priority_id"){ echo" selected=\"selected\""; } echo">$get_priority_title</option>\n";
						}
						echo"
						</select>
						</p>

							
						<p>
						<input type=\"submit\" value=\"$l_create_case\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
						</p>
					<!-- //New case form -->
					";
				} // station rank is admin, moderator or editor
				else{
					echo"
					<h1>$l_new_case</h1>

					<!-- Where am I ? -->
						<p><b>$l_you_are_here:</b><br />
						<a href=\"index.php?l=$l\">$l_edb</a>
						&gt;
						<a href=\"open_district.php?district_id=$get_current_district_id&amp;l=$l\">$get_current_district_title</a>
						&gt;
						<a href=\"open_station.php?station_id=$get_current_station_id&amp;$l\">$get_current_station_title</a>
						&gt;
						<a href=\"new_case_step_3_case_information.php?district_id=$get_current_district_id&amp;station_id=$get_current_station_id&amp;$l\">$l_new_case</a>
						</p>
						<div style=\"height: 10px;\"></div>
					<!-- //Where am I ? -->

					<p>$l_you_dont_have_the_nessesary_rights_to_create_cases</p>

					";
				}
			} // member of station
		} // station found
	} // district found

} // logged in
else{
	// Log in
	echo"
	<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> $l_please_log_in...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/edb\">
	";
} // not logged in
/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/$webdesignSav/footer.php");
?>