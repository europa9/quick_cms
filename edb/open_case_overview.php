<?php 
/**
*
* File: edb/open_case_overview.php
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
include("$root/_admin/_translations/site/$l/edb/ts_open_case_human_tasks.php");
include("$root/_admin/_translations/site/$l/edb/ts_open_case_automated_tasks.php");


/*- Variables -------------------------------------------------------------------------- */
$tabindex = 0;
if(isset($_GET['case_id'])) {
	$case_id = $_GET['case_id'];
	$case_id = strip_tags(stripslashes($case_id));
}
else{
	$case_id = "";
}
$case_id_mysql = quote_smart($link, $case_id);



/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){

	// Find case 
	$query = "SELECT case_id, case_number, case_title, case_title_clean, case_suspect_in_custody, case_code_id, case_code_number, case_code_title, case_status_id, case_status_title, case_priority_id, case_priority_title, case_district_id, case_district_title, case_station_id, case_station_title, case_is_screened, case_physical_location, case_backup_disks, case_confirmed_by_human, case_human_rejected, case_assigned_to_datetime, case_assigned_to_time, case_assigned_to_date_saying, case_assigned_to_date_ddmmyy, case_assigned_to_user_id, case_assigned_to_user_name, case_assigned_to_user_alias, case_assigned_to_user_email, case_assigned_to_user_image_path, case_assigned_to_user_image_file, case_assigned_to_user_image_thumb_40, case_assigned_to_user_image_thumb_50, case_assigned_to_user_first_name, case_assigned_to_user_middle_name, case_assigned_to_user_last_name, case_created_datetime, case_created_time, case_created_date_saying, case_created_date_ddmmyy, case_created_user_id, case_created_user_name, case_created_user_alias, case_created_user_email, case_created_user_image_path, case_created_user_image_file, case_created_user_image_thumb_40, case_created_user_image_thumb_50, case_created_user_first_name, case_created_user_middle_name, case_created_user_last_name, case_detective_user_id, case_detective_user_job_title, case_detective_user_department, case_detective_user_first_name, case_detective_user_middle_name, case_detective_user_last_name, case_detective_user_name, case_detective_user_alias, case_detective_user_email, case_detective_email_alerts, case_detective_user_image_path, case_detective_user_image_file, case_detective_user_image_thumb_40, case_detective_user_image_thumb_50, case_updated_datetime, case_updated_time, case_updated_date_saying, case_updated_date_ddmmyy, case_updated_user_id, case_updated_user_name, case_updated_user_alias, case_updated_user_email, case_updated_user_image_path, case_updated_user_image_file, case_updated_user_image_thumb_40, case_updated_user_image_thumb_50, case_updated_user_first_name, case_updated_user_middle_name, case_updated_user_last_name, case_is_closed, case_closed_datetime, case_closed_time, case_closed_date_saying, case_closed_date_ddmmyy, case_time_from_created_to_close FROM $t_edb_case_index WHERE case_id=$case_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_case_id, $get_current_case_number, $get_current_case_title, $get_current_case_title_clean, $get_current_case_suspect_in_custody, $get_current_case_code_id, $get_current_case_code_number, $get_current_case_code_title, $get_current_case_status_id, $get_current_case_status_title, $get_current_case_priority_id, $get_current_case_priority_title, $get_current_case_district_id, $get_current_case_district_title, $get_current_case_station_id, $get_current_case_station_title, $get_current_case_is_screened, $get_current_case_physical_location, $get_current_case_backup_disks, $get_current_case_confirmed_by_human, $get_current_case_human_rejected, $get_current_case_assigned_to_datetime, $get_current_case_assigned_to_time, $get_current_case_assigned_to_date_saying, $get_current_case_assigned_to_date_ddmmyy, $get_current_case_assigned_to_user_id, $get_current_case_assigned_to_user_name, $get_current_case_assigned_to_user_alias, $get_current_case_assigned_to_user_email, $get_current_case_assigned_to_user_image_path, $get_current_case_assigned_to_user_image_file, $get_current_case_assigned_to_user_image_thumb_40, $get_current_case_assigned_to_user_image_thumb_50, $get_current_case_assigned_to_user_first_name, $get_current_case_assigned_to_user_middle_name, $get_current_case_assigned_to_user_last_name, $get_current_case_created_datetime, $get_current_case_created_time, $get_current_case_created_date_saying, $get_current_case_created_date_ddmmyy, $get_current_case_created_user_id, $get_current_case_created_user_name, $get_current_case_created_user_alias, $get_current_case_created_user_email, $get_current_case_created_user_image_path, $get_current_case_created_user_image_file, $get_current_case_created_user_image_thumb_40, $get_current_case_created_user_image_thumb_50, $get_current_case_created_user_first_name, $get_current_case_created_user_middle_name, $get_current_case_created_user_last_name, $get_current_case_detective_user_id, $get_current_case_detective_user_job_title, $get_current_case_detective_user_department, $get_current_case_detective_user_first_name, $get_current_case_detective_user_middle_name, $get_current_case_detective_user_last_name, $get_current_case_detective_user_name, $get_current_case_detective_user_alias, $get_current_case_detective_user_email, $get_current_case_detective_email_alerts, $get_current_case_detective_user_image_path, $get_current_case_detective_user_image_file, $get_current_case_detective_user_image_thumb_40, $get_current_case_detective_user_image_thumb_50, $get_current_case_updated_datetime, $get_current_case_updated_time, $get_current_case_updated_date_saying, $get_current_case_updated_date_ddmmyy, $get_current_case_updated_user_id, $get_current_case_updated_user_name, $get_current_case_updated_user_alias, $get_current_case_updated_user_email, $get_current_case_updated_user_image_path, $get_current_case_updated_user_image_file, $get_current_case_updated_user_image_thumb_40, $get_current_case_updated_user_image_thumb_50, $get_current_case_updated_user_first_name, $get_current_case_updated_user_middle_name, $get_current_case_updated_user_last_name, $get_current_case_is_closed, $get_current_case_closed_datetime, $get_current_case_closed_time, $get_current_case_closed_date_saying, $get_current_case_closed_date_ddmmyy, $get_current_case_time_from_created_to_close) = $row;
	

	if($get_current_case_id == ""){
		echo"<h1>Server error 404</h1><p>Case not found</p>";
		die;
	}
	else{
		/*- Headers ---------------------------------------------------------------------------------- */
		$website_title = "$l_edb - $get_current_case_district_title - $get_current_case_station_title - $get_current_case_number";
		if(file_exists("./favicon.ico")){ $root = "."; }
		elseif(file_exists("../favicon.ico")){ $root = ".."; }
		elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
		elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
		include("$root/_webdesign/header.php");

		// Me
		$my_user_id = $_SESSION['user_id'];
		$my_user_id = output_html($my_user_id);
		$my_user_id_mysql = quote_smart($link, $my_user_id);


		// Check that I am member of this station
		$query = "SELECT station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60, station_member_user_image_thumb_200, station_member_user_position, station_member_user_department, station_member_user_location, station_member_user_about, station_member_added_datetime, station_member_added_date_saying, station_member_added_by_user_id, station_member_added_by_user_name, station_member_added_by_user_alias, station_member_added_by_user_image FROM $t_edb_stations_members WHERE station_member_user_id=$my_user_id_mysql AND station_member_station_id=$get_current_case_station_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_my_station_member_id, $get_my_station_member_station_id, $get_my_station_member_station_title, $get_my_station_member_district_id, $get_my_station_member_district_title, $get_my_station_member_user_id, $get_my_station_member_rank, $get_my_station_member_user_name, $get_my_station_member_user_alias, $get_my_station_member_first_name, $get_my_station_member_middle_name, $get_my_station_member_last_name, $get_my_station_member_user_email, $get_my_station_member_user_image_path, $get_my_station_member_user_image_file, $get_my_station_member_user_image_thumb_40, $get_my_station_member_user_image_thumb_50, $get_my_station_member_user_image_thumb_60, $get_my_station_member_user_image_thumb_200, $get_my_station_member_user_position, $get_my_station_member_user_department, $get_my_station_member_user_location, $get_my_station_member_user_about, $get_my_station_member_added_datetime, $get_my_station_member_added_date_saying, $get_my_station_member_added_by_user_id, $get_my_station_member_added_by_user_name, $get_my_station_member_added_by_user_alias, $get_my_station_member_added_by_user_image) = $row;

		if($get_my_station_member_id == ""){
			echo"
			<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> Please apply for access to this station..</h1>
			<meta http-equiv=\"refresh\" content=\"3;url=browse_districts_and_stations.php?action=apply_for_membership_to_station&amp;station_id=$get_current_case_station_id&amp;l=$l\">
			";
		} // access to station denied
		else{
			if($process != "1"){
				echo"
				<!-- Headline + Select cases board -->
					<h1>$get_current_case_number</h1>
				<!-- Headline + Select cases board -->

				<!-- Where am I? -->
					<p style=\"padding-top:0;margin-top:0;\"><b>$l_you_are_here:</b><br />
					<a href=\"index.php?l=$l\">$l_edb</a>
					&gt;
					<a href=\"cases_board_1_view_district.php?district_id=$get_current_case_district_id&amp;l=$l\">$get_current_case_district_title</a>
					&gt;
					<a href=\"cases_board_2_view_station.php?district_id=$get_current_case_district_id&amp;station_id=$get_current_case_station_id&amp;l=$l\">$get_current_case_station_title</a>
					&gt;
					<a href=\"open_case_overview.php?case_id=$get_current_case_id&amp;l=$l\">$get_current_case_number</a>
					</p>
					<div style=\"height: 10px;\"></div>
				<!-- //Where am I? -->


				<!-- Case navigation -->
					";
					include("open_case_menu.php");
					echo"
				<!-- //Case navigation -->
				";
			} // process != 1

			if($process == "1"){

				$inp_title = $_POST['inp_title'];
				$inp_title = output_html($inp_title);
				$inp_title_mysql = quote_smart($link, $inp_title);

				$inp_title_clean = clean($inp_title);
				$inp_title_clean_mysql = quote_smart($link, $inp_title_clean);

				$inp_code_number = $_POST['inp_code_number'];
				if($inp_code_number == ""){
					$inp_code_number = "0";
				}
				$inp_code_number = output_html($inp_code_number);
				$inp_code_number_mysql = quote_smart($link, $inp_code_number);

				if(isset($_POST['inp_suspect_in_custody'])){
					$inp_suspect_in_custody = 1;
				}
				else{
					$inp_suspect_in_custody = 0;
				}
				$inp_suspect_in_custody = output_html($inp_suspect_in_custody);
				$inp_suspect_in_custody_mysql = quote_smart($link, $inp_suspect_in_custody);

				$inp_priority_id = $_POST['inp_priority_id'];
				$inp_priority_id = output_html($inp_priority_id);
				$inp_priority_id_mysql = quote_smart($link, $inp_priority_id);

				// Code
				$query = "SELECT code_id, code_number, code_title, code_title_clean, code_gives_priority_id, code_gives_priority_title, code_last_used_datetime, code_last_used_time, code_times_used FROM $t_edb_case_codes WHERE code_number=$inp_code_number_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_code_id, $get_code_number, $get_code_title, $get_code_title_clean, $get_code_gives_priority_id, $get_code_gives_priority_title, $get_code_last_used_datetime, $get_code_last_used_time, $get_code_times_used) = $row;
				if($get_code_id != "" && $inp_code_number != "$get_current_case_code_number"){
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
					if($get_code_id == ""){
						$get_code_id = "0";
					}
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

				$inp_my_user_image_path = "_uploads/users/images/$get_my_user_id";
				$inp_my_user_image_path_mysql = quote_smart($link, $inp_my_user_image_path);

				$inp_my_user_image_file_mysql = quote_smart($link, $get_my_photo_destination);

				$inp_my_user_image_thumb_a_mysql = quote_smart($link, $get_my_photo_thumb_40);
				$inp_my_user_image_thumb_b_mysql = quote_smart($link, $get_my_photo_thumb_50);

				$inp_my_user_first_name_mysql = quote_smart($link, $get_my_profile_first_name);
				$inp_my_user_middle_name_mysql = quote_smart($link, $get_my_profile_middle_name);
				$inp_my_user_last_name_mysql = quote_smart($link, $get_my_profile_last_name);

				// Dates
				$inp_datetime = date("Y-m-d H:i:s");
				$inp_date = date("Y-m-d");
				$inp_time = time();
				$inp_date_saying = date("j M Y");
				$inp_date_ddmmyy = date("d.m.y");
				$inp_date_ddmmyyyy = date("d.m.Y");


				// District
				$inp_district_id = $_POST['inp_district_id'];
				$inp_district_id = output_html($inp_district_id);
				$inp_district_id_mysql = quote_smart($link, $inp_district_id);

				$query = "SELECT district_id, district_number, district_title, district_title_clean, district_icon_path, district_icon_16, district_icon_32, district_icon_260, district_number_of_stations, district_number_of_cases_now FROM $t_edb_districts_index WHERE district_id=$inp_district_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_district_id, $get_current_district_number, $get_current_district_title, $get_current_district_title_clean, $get_current_district_icon_path, $get_current_district_icon_16, $get_current_district_icon_32, $get_current_district_icon_260, $get_current_district_number_of_stations, $get_current_district_number_of_cases_now) = $row;

				$inp_district_title_mysql = quote_smart($link, $get_current_district_title);

				// Station
				$inp_station_id = $_POST['inp_station_id'];
				$inp_station_id = output_html($inp_station_id);
				if($inp_station_id == ""){
					$inp_station_id = $get_current_case_station_id;
				}
				$inp_station_id_mysql = quote_smart($link, $inp_station_id);

				$query = "SELECT station_id, station_number, station_title, station_title_clean, station_district_id, station_district_title, station_icon_path, station_icon_16, station_icon_32, station_icon_260, station_number_of_cases_now FROM $t_edb_stations_index WHERE station_id=$inp_station_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_station_id, $get_current_station_number, $get_current_station_title, $get_current_station_title_clean, $get_current_station_district_id, $get_current_station_district_title, $get_current_station_icon_path, $get_current_station_icon_16, $get_current_station_icon_32, $get_current_station_icon_260, $get_current_station_number_of_cases_now) = $row;
	
				$inp_station_title_mysql = quote_smart($link, $get_current_station_title);
				
				// Location
				// $inp_physical_location = $_POST['inp_physical_location'];
				// $inp_physical_location = output_html($inp_physical_location);
				// $inp_physical_location_mysql = quote_smart($link, $inp_physical_location);

				$inp_backup_disks = $_POST['inp_backup_disks'];
				$inp_backup_disks = output_html($inp_backup_disks);
				$inp_backup_disks_mysql = quote_smart($link, $inp_backup_disks);

				// Robot
				if(isset($_POST['inp_case_confirmed_by_human'])){
					$inp_case_confirmed_by_human = 1;
				}
				else{
					$inp_case_confirmed_by_human = 0;
				}
				$inp_case_confirmed_by_human = output_html($inp_case_confirmed_by_human);
				$inp_case_confirmed_by_human_mysql = quote_smart($link, $inp_case_confirmed_by_human);

				if(isset($_POST['inp_case_human_rejected'])){
					$inp_case_human_rejected = 1;
				}
				else{
					$inp_case_human_rejected = 0;
				}
				$inp_case_human_rejected = output_html($inp_case_human_rejected);
				$inp_case_human_rejected_mysql = quote_smart($link, $inp_case_human_rejected);

				// Update
				$result = mysqli_query($link, "UPDATE $t_edb_case_index SET 
								case_title=$inp_title_mysql, 
								case_title_clean=$inp_title_clean_mysql, 
								case_suspect_in_custody=$inp_suspect_in_custody_mysql, 
								case_code_id=$inp_code_id_mysql, 
								case_code_number=$inp_code_number_mysql, 
								case_code_title=$inp_code_title_mysql, 
								case_priority_id=$inp_priority_id_mysql, 
								case_priority_title=$inp_priority_title_mysql, 
								case_district_id=$inp_district_id_mysql, 
								case_district_title=$inp_district_title_mysql, 
								case_station_id=$inp_station_id_mysql, 
								case_station_title=$inp_station_title_mysql, 
								case_backup_disks=$inp_backup_disks_mysql, 
								case_confirmed_by_human=$inp_case_confirmed_by_human_mysql,
								case_human_rejected=$inp_case_human_rejected_mysql, 
								case_updated_datetime='$inp_datetime', 
								case_updated_date='$inp_date', 
								case_updated_time='$inp_time', 
								case_updated_date_saying='$inp_date_saying', 
								case_updated_date_ddmmyy='$inp_date_ddmmyy', 
								case_updated_date_ddmmyyyy='$inp_date_ddmmyyyy', 
								case_updated_user_id='$get_my_user_id', 
								case_updated_user_name=$inp_my_user_name_mysql, 
								case_updated_user_alias=$inp_my_user_alias_mysql, 
								case_updated_user_email=$inp_my_user_email_mysql, 
								case_updated_user_image_path=$inp_my_user_image_path_mysql, 
								case_updated_user_image_file=$inp_my_user_image_file_mysql, 
								case_updated_user_image_thumb_40=$inp_my_user_image_thumb_a_mysql, 
								case_updated_user_image_thumb_50=$inp_my_user_image_thumb_b_mysql, 
								case_updated_user_first_name=$inp_my_user_first_name_mysql, 
								case_updated_user_middle_name=$inp_my_user_middle_name_mysql, 
								case_updated_user_last_name=$inp_my_user_last_name_mysql 
								 WHERE case_id=$get_current_case_id") or die(mysqli_error($link));

				// Statuses
				$inp_status_id = $_POST['inp_status_id'];
				$inp_status_id = output_html($inp_status_id);
				$inp_status_id_mysql = quote_smart($link, $inp_status_id);
				if($inp_status_id != "$get_current_case_status_id"){
					include("open_case_overview_include_update_case_status.php");
				}


				// Assigned to (has to come after status because some statuses cannot be without assigned to person)
				if(!(isset($inp_assigned_to_user_name))){
					$inp_assigned_to_user_name = $_POST['inp_assigned_to_user_name'];
				}
				$inp_assigned_to_user_name = output_html($inp_assigned_to_user_name);
				if($inp_assigned_to_user_name != "$get_current_case_assigned_to_user_name" && $inp_assigned_to_user_name != ""){
					include("open_case_overview_include_update_case_assigned_to.php");
				}

				
				// 1) Statistics
				$year = date("Y");
				$month = date("m");
				$month_saying = date("M");
				$day = date("d");
				$day_saying = date("D");


				// Stats code
				if($get_code_id != "" && $inp_code_number != "$get_current_case_code_number"){
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

				} // case code


				// Stats priority
				if($get_priority_id != "" && $inp_priority_id != "$get_current_case_priority_id"){
					
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

				} // case priority stats

	
				
				$hour_minute = date("H:i");
				$url = "open_case_overview.php?case_id=$get_current_case_id&l=$l&ft=success&fm=case_saved_at_" . $hour_minute;
				header("Location: $url");
				exit;
			}


			echo"
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
					\$('[name=\"inp_code_number\"]').focus();
				});
				</script>
			<!-- //Focus -->

			<!-- Edit case overview -->
				";
				if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
					echo"
					<form method=\"POST\" action=\"open_case_overview.php?case_id=$get_current_case_id&amp;l=$l&amp;process=1\" id=\"open_case_overview_form\" enctype=\"multipart/form-data\">
					";
				}
				echo"
				<!-- Case information -->
					<h2>$l_case_information</h2>

				
					<table>
					 <tr>
					  <td style=\"vertical-align: top;padding-right: 40px;\">
						<!-- Case information left -->
						<table>
						 <tr>
						  <td style=\"padding: 4px 4px 4px 0px;text-align: right;\">
							<span>$l_number:</span>
						  </td>
						  <td style=\"padding: 4px 0px 4px 0px;\">
							<span>$get_current_case_number</span>
						  </td>
						 </tr>
							 <tr>
							  <td style=\"padding: 4px 4px 4px 0px;text-align: right;\">
								<span>$l_case_code:</span>
							  </td>
							  <td style=\"padding: 4px 0px 4px 0px;\">";
								if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
									echo"
									<span><input type=\"text\" name=\"inp_code_number\" id=\"inp_code_autosearch\" value=\"$get_current_case_code_number\" size=\"5\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
									<span id=\"inp_code_title\">$get_current_case_code_title</span>
	
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
               											url: \"open_case_overview_case_code_search.php\",
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
									";
								}
								else{
									echo"<span>$get_current_case_code_number $get_current_case_code_title</span>";
								}
								echo"
							  </td>
							 </tr>
						 <tr>
						  <td style=\"padding: 4px 4px 4px 0px;text-align: right;\">
							<span>$l_title:</span>
						  </td>
						  <td style=\"padding: 4px 0px 4px 0px;\">
							<span>";
							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
								echo"<input type=\"text\" name=\"inp_title\" id=\"inp_title\" value=\"$get_current_case_title\" size=\"50\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
							}
							else{
								echo"$get_current_case_title";
							}
							echo"</span>
						  </td>
						 </tr>
						 <tr>
						  <td style=\"padding: 4px 4px 4px 0px;text-align: right;\">
							<span>$l_custody:</span>
						  </td>
						  <td style=\"padding: 4px 0px 4px 0px;\">
							<span>";
							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
								echo"<input type=\"checkbox\" name=\"inp_suspect_in_custody\" "; if($get_current_case_suspect_in_custody == "1"){ echo" checked=\"checked\"";} echo" class=\"on_change_submit_form\" tabindex=\"";  $tabindex = $tabindex+1; echo"$tabindex\" />";
							}
							else{
								if($get_current_case_suspect_in_custody == "1"){
									echo"$l_yes";
								}
								else{
									echo"$l_no";
								}
							}
							echo"</span>
						  </td>
						 </tr>
							 <tr>
							  <td style=\"padding: 4px 4px 4px 0px;text-align: right;\">
								<span>$l_priority:</span>
							  </td>
							  <td style=\"padding: 4px 0px 4px 0px;\">
								";
								if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
									echo"
									<span>
									<select name=\"inp_priority_id\" id=\"inp_priority\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" class=\"on_change_submit_form\">\n";
									$query = "SELECT priority_id, priority_title, priority_title_clean, priority_bg_color, priority_border_color, priority_text_color, priority_link_color, priority_weight, priority_number_of_cases_now FROM $t_edb_case_priorities ORDER BY priority_weight ASC";
									$result = mysqli_query($link, $query);
									while($row = mysqli_fetch_row($result)) {
										list($get_priority_id, $get_priority_title, $get_priority_title_clean, $get_priority_bg_color, $get_priority_border_color, $get_priority_text_color, $get_priority_link_color, $get_priority_weight, $get_priority_number_of_cases_now) = $row;
										echo"							";
										echo"<option value=\"$get_priority_id\""; if($get_priority_id == "$get_current_case_priority_id"){ echo" selected=\"selected\""; } echo">$get_priority_title</option>\n";
									}
									echo"
									</select>
									</span>
									";
								}
								else{
									echo"<span>$get_current_case_priority_id $get_current_case_priority_title</span>";
								}
								echo"
							  </td>
							 </tr>
							</table>
						<!-- //Case information left -->
					  </td>
					  <td style=\"vertical-align: top;padding-left: 40px;\">
						<!-- Case information center -->
							<table>
							 <tr>
							  <td style=\"padding: 4px 4px 4px 0px;text-align: right;\">
								<span>$l_status:</span>
							  </td>
							  <td style=\"padding: 4px 0px 4px 0px;\">
								";
								if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
									echo"
									<span>
									<select name=\"inp_status_id\" class=\"on_change_submit_form\">
									";
									$query = "SELECT status_id, status_title, status_title_clean, status_bg_color, status_border_color, status_text_color, status_link_color, status_weight, status_number_of_cases_now, status_number_of_cases_max, status_show_on_front_page, status_on_given_status_do_close_case FROM $t_edb_case_statuses ORDER BY status_weight ASC";
									$result = mysqli_query($link, $query);
									while($row = mysqli_fetch_row($result)) {
										list($get_status_id, $get_status_title, $get_status_title_clean, $get_status_bg_color, $get_status_border_color, $get_status_text_color, $get_status_link_color, $get_status_weight, $get_status_number_of_cases_now, $get_status_number_of_cases_max, $get_status_show_on_front_page, $get_status_on_given_status_do_close_case) = $row;
										echo"			";
										echo"<option value=\"$get_status_id\""; if($get_status_id == "$get_current_case_status_id"){ echo" selected=\"selected\""; } echo">$get_status_title</option>\n";
									}
									echo"
									</select>
									</span>
									";
								}
								else{
									echo"<span>$get_current_case_status_title</span>";
								}
								echo"
							  </td>
							 </tr>
							 <tr>
							  <td style=\"padding: 4px 4px 4px 0px;text-align: right;vertical-align:top;\">
								<span>$l_assignee:</span>
							  </td>
							  <td style=\"padding: 4px 0px 4px 0px;vertical-align:top;\">
								";
								if($get_current_case_assigned_to_user_id == "" OR $get_current_case_assigned_to_user_id == "0"){
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
								
										echo"<span style=\"color: red;\">
										<input type=\"text\" name=\"inp_assigned_to_user_name\" id=\"autosearch_inp_search_for_assignee\" size=\"20\" value=\"\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
										<i>$l_unassigned</i></span>
										\n";
									}
									else{

										echo"<span style=\"color: red;\"><i>$l_unassigned</i></span>\n";
									}
								}
								else{
									echo"
									<table>
									 <tr>
									  <td style=\"padding-right: 5px;\">
											<!-- Img -->
											<p style=\"padding-top:0;margin-top:0;\">
											";
											if(file_exists("$root/$get_current_case_assigned_to_user_image_path/$get_current_case_assigned_to_user_image_file") && $get_current_case_assigned_to_user_image_file != ""){
												// Thumb name
												if($get_current_case_assigned_to_user_image_thumb_50 == ""){
													// Update thumb name
													$ext = get_extension($get_current_case_assigned_to_user_image_file);
													$inp_thumb_name = str_replace($ext, "", $get_current_case_assigned_to_user_image_file);
													$inp_thumb_name = $inp_thumb_name . "_50." . $ext;
													$inp_thumb_name_mysql = quote_smart($link, $inp_thumb_name);
													$result_update = mysqli_query($link, "UPDATE $t_edb_case_index SET case_assigned_to_user_image_thumb_50=$inp_thumb_name_mysql WHERE case_id=$get_current_case_id") or die(mysqli_error($link));
		
													// Transfer
													$get_current_case_assigned_to_user_image_thumb_40 = "$inp_thumb_name";
												}
										
												if(!(file_exists("$root/$get_current_case_assigned_to_user_image_path/$get_current_case_assigned_to_user_image_thumb_50"))){
													// Make thumb
													$inp_new_x = 50; // 950
													$inp_new_y = 50; // 640
													resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_current_case_assigned_to_user_image_path/$get_current_case_assigned_to_user_image_file", "$root/$get_current_case_assigned_to_user_image_path/$get_current_case_assigned_to_user_image_thumb_50");
												}


												echo"
												<a href=\"$root/users/view_profile.php?user_id=$get_current_case_assigned_to_user_id&amp;l=$l\"><img src=\"$root/$get_current_case_assigned_to_user_image_path/$get_current_case_assigned_to_user_image_thumb_50\" alt=\"$get_current_case_assigned_to_user_image_thumb_50\" /></a>
												";
											}
											else{
												echo"
												<a href=\"$root/users/view_profile.php?user_id=$get_current_case_assigned_to_user_id&amp;l=$l\"><img src=\"_gfx/avatar_blank_50.png\" alt=\"avatar_blank_50.png\" /></a>
												";
											}

											echo"
											</p>
											<!-- //Img -->
									  </td>
									  <td>
										<!-- Name -->	
											<p style=\"padding:0;margin:0;line-height:1;\">
											<a href=\"$root/users/view_profile.php?user_id=$get_current_case_assigned_to_user_id&amp;l=$l\">$get_current_case_assigned_to_user_name</a>
											";
											if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
												echo"<a href=\"open_case_unassign.php?case_id=$get_current_case_id&amp;l=$l&amp;process=1\"><img src=\"_gfx/unassign.png\" alt=\"unassign.png\" /></a><br />\n";
											}
											echo"
											<a href=\"$root/users/view_profile.php?user_id=$get_current_case_assigned_to_user_id&amp;l=$l\" style=\"color:black;\">$get_current_case_assigned_to_user_first_name $get_current_case_assigned_to_user_middle_name $get_current_case_assigned_to_user_last_name</a><br />
											<span class=\"grey\">$get_current_case_assigned_to_date_ddmmyy</span>
											</p>
										<!-- //Name -->
									  </td>
									 </tr>
									</table>
									";
					
								} // assigned to
								echo"
					
								
									<div class=\"open_case_assignee_reassign_results\">
									</div>

									<!-- Reassign Autocomplete -->
										<script>
										\$(document).ready(function () {
											\$('#autosearch_inp_search_for_assignee').keyup(function () {
       												// getting the value that user typed
       												var searchString    = $(\"#autosearch_inp_search_for_assignee\").val();
 												// forming the queryString
      												var data            = 'case_id=$get_current_case_id&station_id=$get_current_case_station_id&l=$l&q=' + searchString;
         
        											// if searchString is not empty
        											if(searchString) {
           												// ajax call
            												\$.ajax({
                												type: \"GET\",
               													url: \"open_case_overview_assigned_to_jquery_search_for_assignee.php\",
                												data: data,
														beforeSend: function(html) { // this happens before actual call
															\$(\".open_case_assignee_reassign_results\").html(''); 
														},
               													success: function(html){
                    													\$(\".open_case_assignee_reassign_results\").append(html);
              													}
            												});
       												}
        											return false;
            										});
         				  					 });
										</script>
									<!-- //Reassign Autocomplete -->


								<!-- //Assigned to -->
							  </td>
							 </tr>
							 <tr>
							  <td style=\"padding: 4px 4px 4px 0px;text-align: right;\">
								<span>$l_station:</span>
							  </td>
							  <td style=\"padding: 4px 0px 4px 0px;\">";
								if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
									echo"
									<span>
									<select name=\"inp_district_id\" class=\"on_change_submit_form\">
									";
									$query = "SELECT district_id, district_number, district_title, district_title_clean, district_icon_path, district_icon_16, district_icon_32, district_icon_260, district_number_of_stations, district_number_of_cases_now FROM $t_edb_districts_index ORDER BY district_title ASC";
									$result = mysqli_query($link, $query);
									while($row = mysqli_fetch_row($result)) {
										list($get_district_id, $get_district_number, $get_district_title, $get_district_title_clean, $get_district_icon_path, $get_district_icon_16, $get_district_icon_32, $get_district_icon_260, $get_district_number_of_stations, $get_district_number_of_cases_now) = $row;
										echo"			";
										echo"<option value=\"$get_district_id\""; if($get_district_id == "$get_current_case_district_id"){ echo" selected=\"selected\""; } echo">$get_district_title</option>\n";
									}
									echo"
									</select>
								

									<select name=\"inp_station_id\" class=\"on_change_submit_form\">
									";
									$query = "SELECT station_id, station_number, station_title, station_title_clean, station_district_id, station_district_title, station_icon_path, station_icon_16, station_icon_32, station_icon_260, station_number_of_cases_now FROM $t_edb_stations_index WHERE station_district_id=$get_current_case_district_id ORDER BY station_title ASC";
									$result = mysqli_query($link, $query);
									while($row = mysqli_fetch_row($result)) {
										list($get_station_id, $get_station_number, $get_station_title, $get_station_title_clean, $get_station_district_id, $get_station_district_title, $get_station_icon_path, $get_station_icon_16, $get_station_icon_32, $get_station_icon_260, $get_station_number_of_cases_now) = $row;
										echo"			";
										echo"<option value=\"$get_station_id\""; if($get_station_id == "$get_current_case_station_id"){ echo" selected=\"selected\""; } echo">$get_station_title</option>\n";
									}
									echo"
									</select>
									</span>
									";
								}
								else{
									echo"
									<span>
									$get_current_case_district_title,
									$get_current_case_station_title
									</span>
									";
								}
								echo"
							  </td>
							 </tr>
							 <tr>
							  <td style=\"padding: 4px 4px 4px 0px;text-align: right;\">
								<span>$l_location:</span>
							  </td>
							  <td style=\"padding: 4px 0px 4px 0px;\">";
								if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
									echo"
									<span>$get_current_case_physical_location</span>
									";
								}
								else{
									echo"
									<span>$get_current_case_physical_location</span>
									";
								}
								echo"
							  </td>
							 </tr>
							 <tr>
							  <td style=\"padding: 4px 4px 4px 0px;text-align: right;\">
								<span>$l_backup:</span>
							  </td>
							  <td style=\"padding: 4px 0px 4px 0px;\">";
								if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
									echo"
									<span>
									<span><input type=\"text\" name=\"inp_backup_disks\" value=\"$get_current_case_backup_disks\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
									</span>
									";
								}
								else{
									echo"
									<span>$get_current_case_backup_disks</span>
									";
								}
								echo"
							  </td>
							 </tr>
							</table>
						<!-- //Case information right --> 
					  </td>
					  <td style=\"vertical-align: top;padding-right: 40px;\">
						<!-- Case information right --> 

							<table>
							 <tr>
							  <td style=\"padding: 4px 4px 4px 0px;text-align: right;\">
								<span>$l_confirmed_by_human:</span>
							  </td>
							  <td style=\"padding: 4px 0px 4px 0px;\">";
								if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
									echo"
									<span><input type=\"checkbox\" name=\"inp_case_confirmed_by_human\" "; if($get_current_case_confirmed_by_human == "1"){ echo" checked=\"checked\"";} echo" class=\"on_change_submit_form\" tabindex=\"";  $tabindex = $tabindex+1; echo"$tabindex\" /></span>
									";
								}
								else{
									if($get_current_case_confirmed_by_human == "1"){
										echo"<span>$l_yes</span>";
									}
									else{
										echo"<span>$l_no</span>";
									}
								}
								echo"
							  </td>
							 </tr>
							 <tr>
							  <td style=\"padding: 4px 4px 4px 0px;text-align: right;\">
								<span>$l_human_rejected:</span>
							  </td>
							  <td style=\"padding: 4px 0px 4px 0px;\">";
								if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
									echo"
									<span><input type=\"checkbox\" name=\"inp_case_human_rejected\" "; if($get_current_case_human_rejected == "1"){ echo" checked=\"checked\"";} echo" class=\"on_change_submit_form\" tabindex=\"";  $tabindex = $tabindex+1; echo"$tabindex\" /></span>
									";
								}
								else{
									if($get_current_case_human_rejected == "1"){
										echo"<span>$l_yes</span>";
									}
									elseif($get_current_case_human_rejected == "1"){
										echo"<span>$l_no</span>";
									}
									else{
										echo"<span>-</span>";
									}
								}
								echo"
							  </td>
							 </tr>
							</table>
						<!-- //Case information right --> 
					  </td>
					 </tr>
					</table>
				<!-- //Case information -->

				";
				if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
					echo"
					<p>
					<input type=\"submit\" value=\"$l_save_changes\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
					</p>
					</form>
					<!-- On change value submit form -->
					<script>
					\$(function() {
						\$('.on_change_submit_form').change(function() {
							this.form.submit();
						});
					});
					</script>
					<!-- //On change value submit form -->
					";
				}
				echo"
			<!-- Edit case overview -->


			<!-- Case events -->
				<a id=\"events\"></a>
				<h2 style=\"padding: 25px 0px 10px 0px;\"><a href=\"open_case_events.php?case_id=$get_current_case_id&amp;l=$l\" class=\"h2\">$l_events</a></h2>
				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
					<span>$l_date</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_event</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_author</span>
			 	  </th>
			 	  <th scope=\"col\">
					<span>$l_actions</span>
				   </th>
				  </tr>
				 </thead>
				 <tbody>
				";
			
				$query = "SELECT event_id, event_case_id, event_importance, event_text, event_datetime, event_time, event_date_saying, event_date_ddmmyy, event_user_id, event_user_name, event_user_alias, event_user_email, event_user_image_path, event_user_image_file, event_user_image_thumb_40, event_user_image_thumb_50, event_user_first_name, event_user_middle_name, event_user_last_name FROM $t_edb_case_index_events WHERE event_case_id=$get_current_case_id ORDER BY event_id ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_event_id, $get_event_case_id, $get_event_importance, $get_event_text, $get_event_datetime, $get_event_time, $get_event_date_saying, $get_event_date_ddmmyy, $get_event_user_id, $get_event_user_name, $get_event_user_alias, $get_event_user_email, $get_event_user_image_path, $get_event_user_image_file, $get_event_user_image_thumb_40, $get_event_user_image_thumb_50, $get_event_user_first_name, $get_event_user_middle_name, $get_event_user_last_name) = $row;

					if(isset($style) && $style == ""){
						$style = "odd";
					}
					else{
						$style = "";
					}
					if($get_event_importance == "important"){
						$style = "important";
					}
					elseif($get_event_importance == "danger"){
						$style = "danger";
					}

					echo"
					 <tr>
					  <td class=\"$style\">
						<span>$get_event_date_ddmmyy</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_event_text</span>
					  </td>
					  <td class=\"$style\">
						<a href=\"$root/users/view_profile.php?user_id=$get_event_user_id&amp;l=$l\" title=\"$get_event_user_first_name $get_event_user_middle_name $get_event_user_last_name\">$get_event_user_name</a>
					  </td>
					  <td class=\"$style\">
						<span>
						<a href=\"open_case_events.php?case_id=$get_current_case_id&amp;action=edit_event&amp;event_id=$get_event_id&amp;l=$l\">$l_edit</a>
						&middot;
						<a href=\"open_case_events.php?case_id=$get_current_case_id&amp;action=delete_event&amp;event_id=$get_event_id&amp;l=$l\">$l_delete</a>
						</span>
					 </td>
					</tr>
					";
				} // while events
				// New event
				if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
					if(isset($style) && $style == ""){
						$style = "odd";
					}
					else{
						$style = "";
					}
					echo"
					 <tr>
					  <td class=\"$style\">
						<form method=\"POST\" action=\"open_case_events.php?case_id=$get_current_case_id&amp;action=new_event&amp;l=$l&amp;process=1&amp;referer=open_case_overview\" enctype=\"multipart/form-data\">
						
					  </td>
					  <td class=\"$style\">
						<span><input type=\"text\" name=\"inp_text\" value=\"\" size=\"25\" style=\"width: 87%;\" />
						
						<input type=\"hidden\" name=\"inp_importance\" value=\"normal\" />
						<input type=\"submit\" value=\"$l_save\" class=\"btn_default\" />
						</span>
					  </td>
					  <td class=\"$style\">
					  </td>
					  <td class=\"$style\">
						</form>
					 </td>
					</tr>
					";
				} // new event
				echo"
				 </tbody>
				</table>
			<!-- Case events -->


			<!-- Case evidence -->
				<table>
				 <tr>
				  <td style=\"padding: 0px 4px 0px 0px;\">
					<h2 style=\"padding: 25px 0px 10px 0px;\"><a href=\"open_case_evidence.php?case_id=$get_current_case_id&amp;l=$l\" class=\"h2\">$l_evidence</a></h2>
				  </td>
				  <td style=\"padding: 3px 4px 0px 0px;\">";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"
						<p>
						<a href=\"open_case_evidence_new_record.php?case_id=$get_current_case_id&amp;l=$l\" class=\"btn_default\">$l_new_record</a>
						<a href=\"open_case_evidence_new_item.php?case_id=$get_current_case_id&amp;action=&amp;l=$l\" class=\"btn_default\">$l_add_item</a>
						</p>
						";
					}
					echo"
				  </td>
				 </tr>
				</table>
				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
					<span>$l_record</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_item</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_type</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_in</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_acquired</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_acquired_by</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_out</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_requester</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_department</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_actions</span>
				   </th>
				  </tr>
				 </thead>
				 <tbody>
				";
			
				$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_timezone, item_date_now_date, item_date_now_ddmmyy, item_time_now, item_correct_date_now_date, item_correct_date_now_ddmmyy, item_correct_time_now, item_adjust_clock_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy FROM $t_edb_case_index_evidence_items WHERE item_case_id=$get_current_case_id ORDER BY item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_item_id, $get_item_case_id, $get_item_record_id, $get_item_record_seized_year, $get_item_record_seized_journal, $get_item_record_seized_district_number, $get_item_numeric_serial_number, $get_item_title, $get_item_type_id, $get_item_type_title, $get_item_confirmed_by_human, $get_item_human_rejected, $get_item_request_text, $get_item_requester_user_id, $get_item_requester_user_name, $get_item_requester_user_alias, $get_item_requester_user_email, $get_item_requester_user_image_path, $get_item_requester_user_image_file, $get_item_requester_user_image_thumb_40, $get_item_requester_user_image_thumb_50, $get_item_requester_user_first_name, $get_item_requester_user_middle_name, $get_item_requester_user_last_name, $get_item_requester_user_job_title, $get_item_requester_user_department, $get_item_in_datetime, $get_item_in_date, $get_item_in_time, $get_item_in_date_saying, $get_item_in_date_ddmmyy, $get_item_comment, $get_item_condition, $get_item_serial_number, $get_item_imei_a, $get_item_imei_b, $get_item_imei_c, $get_item_imei_d, $get_item_os_title, $get_item_os_version, $get_item_timezone, $get_item_date_now_date, $get_item_date_now_ddmmyy, $get_item_time_now, $get_item_correct_date_now_date, $get_item_correct_date_now_ddmmyy, $get_item_correct_time_now, $get_item_adjust_clock_automatically, $get_item_acquired_software_id_a, $get_item_acquired_software_title_a, $get_item_acquired_software_notes_a, $get_item_acquired_software_id_b, $get_item_acquired_software_title_b, $get_item_acquired_software_notes_b, $get_item_acquired_software_id_c, $get_item_acquired_software_title_c, $get_item_acquired_software_notes_c, $get_item_acquired_date, $get_item_acquired_time, $get_item_acquired_date_saying, $get_item_acquired_date_ddmmyy, $get_item_acquired_user_id, $get_item_acquired_user_name, $get_item_acquired_user_alias, $get_item_acquired_user_email, $get_item_acquired_user_image_path, $get_item_acquired_user_image_file, $get_item_acquired_user_image_thumb_40, $get_item_acquired_user_image_thumb_50, $get_item_acquired_user_first_name, $get_item_acquired_user_middle_name, $get_item_acquired_user_last_name, $get_item_out_date, $get_item_out_time, $get_item_out_date_saying, $get_item_out_date_ddmmyy) = $row;

					if(isset($style) && $style == ""){
						$style = "odd";
					}
					else{
						$style = "";
					}

					echo"
					 <tr>
					  <td class=\"$style\">
						<span><a href=\"open_case_evidence_edit_evidence_item_item.php?case_id=$get_current_case_id&amp;item_id=$get_item_id&amp;mode=item&amp;l=$l\">$get_item_record_seized_year/$get_item_record_seized_journal-$get_item_record_seized_district_number-$get_item_numeric_serial_number</a></span>
					  </td>
					  <td class=\"$style\">
						<span>$get_item_title</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_item_type_title</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_item_in_date_ddmmyy</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_item_acquired_date_ddmmyy</span>
					  </td>
					  <td class=\"$style\">
						<a href=\"$root/users/view_profile.php?user_id=$get_item_acquired_user_id&amp;l=$l\" title=\"$get_item_acquired_user_first_name $get_item_acquired_user_middle_name $get_item_acquired_user_last_name\">$get_item_acquired_user_name</a>
				 	  </td>
					  <td class=\"$style\">
						<span>$get_item_out_date_ddmmyy</span>
				  	  </td>
					  <td class=\"$style\">
						<a href=\"$root/users/view_profile.php?user_id=$get_item_requester_user_id&amp;l=$l\" title=\"$get_item_requester_user_name\">$get_item_requester_user_job_title $get_item_requester_user_first_name $get_item_requester_user_middle_name $get_item_requester_user_last_name</a>
					  </td>
					  <td class=\"$style\">
						<span>$get_item_requester_user_department</span>
					  </td>
					  <td class=\"$style\">
						<span>
						<a href=\"open_case_evidence_edit_evidence_item_info.php?case_id=$get_current_case_id&amp;item_id=$get_item_id&amp;l=$l\">$l_edit</a>
						&middot;
						<a href=\"open_case_evidence_delete_evidence_item.php?case_id=$get_current_case_id&amp;item_id=$get_item_id&amp;l=$l\">$l_delete</a>
						</span>
					 </td>
					</tr>
					";
				} // while items

				echo"
				 </tbody>
				</table>

			<!-- Case evidence  -->

			<!-- Case statuses -->
				<h2 style=\"padding: 25px 0px 10px 0px;\"><a href=\"open_case_statuses.php?case_id=$get_current_case_id&amp;l=$l\" class=\"h2\">$l_statuses</a></h2>
				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
					<span>$l_date</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_status</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_text</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_author</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_actions</span>
				   </th>
				  </tr>
				 </thead>
				 <tbody>
				";
			
				$counter = 0;
				$query = "SELECT case_index_status_id, case_index_status_case_id, case_index_status_status_id, case_index_status_status_title, case_index_status_datetime, case_index_status_time, case_index_status_date_saying, case_index_status_date_ddmmyy, case_index_status_text, case_index_status_user_id, case_index_status_user_name, case_index_status_user_alias, case_index_status_user_email, case_index_status_user_image_path, case_index_status_user_image_file, case_index_status_user_image_thumb_40, case_index_status_user_image_thumb_50, case_index_status_user_first_name, case_index_status_user_middle_name, case_index_status_user_last_name FROM $t_edb_case_index_statuses WHERE case_index_status_case_id=$get_current_case_id ORDER BY case_index_status_id ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_case_index_status_id, $get_case_index_status_case_id, $get_case_index_status_status_id, $get_case_index_status_status_title, $get_case_index_status_datetime, $get_case_index_status_time, $get_case_index_status_date_saying, $get_case_index_status_date_ddmmyy, $get_case_index_status_text, $get_case_index_status_user_id, $get_case_index_status_user_name, $get_case_index_status_user_alias, $get_case_index_status_user_email, $get_case_index_status_user_image_path, $get_case_index_status_image_file, $get_case_index_status_user_image_thumb_40, $get_case_index_status_user_image_thumb_50, $get_case_index_status_user_first_name, $get_case_index_status_user_middle_name, $get_case_index_status_user_last_name) = $row;

					if(isset($style) && $style == ""){
						$style = "odd";
					}
					else{
						$style = "";
					}

					echo"
					<tr>
					  <td class=\"$style\">
						<span>$get_case_index_status_date_ddmmyy</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_case_index_status_status_title</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_case_index_status_text</span>
					  </td>
					  <td class=\"$style\">
						<a href=\"$root/users/view_profile.php?user_id=$get_case_index_status_user_id&amp;l=$l\" title=\"$get_case_index_status_user_first_name $get_case_index_status_user_middle_name $get_case_index_status_user_last_name\">$get_case_index_status_user_name</a>
					  </td>
					  <td class=\"$style\">
						<span>
						<a href=\"open_case_statuses.php?case_id=$get_current_case_id&amp;page=statuses&amp;action=edit_status&amp;status_id=$get_case_index_status_id&amp;l=$l\">$l_edit</a>
						&middot;
						<a href=\"open_case_statuses.php?case_id=$get_current_case_id&amp;page=statuses&amp;action=delete_status&amp;status_id=$get_case_index_status_id&amp;l=$l\">$l_delete</a>
						</span>
					 </td>
					</tr>
					";
					$counter = $counter + 1;
				} // while statuses 
				if($counter != "$get_current_menu_counter_statuses"){
					$result = mysqli_query($link, "UPDATE $t_edb_case_index_open_case_menu_counters SET menu_counter_statuses=$counter WHERE menu_counter_case_id=$get_current_case_id");
				} 
				echo"
				 </tbody>
				</table>
			<!-- //Case statuses -->
			<!-- Case notes -->
				<h2 style=\"padding: 25px 0px 0px 0px;padding-bottom:0;\"><a href=\"open_case_notes.php?case_id=$get_current_case_id&amp;l=$l\" class=\"h2\">$l_notes</a></h2>
				";
				// Fetch notes
				$query = "SELECT note_id, note_case_id, note_text, note_datetime, note_time, note_date_saying, note_date_ddmmyy, note_user_id, note_user_name, note_user_alias, note_user_email, note_user_image_path, note_user_image_file, note_user_image_thumb_40, note_user_image_thumb_50, note_user_first_name, note_user_middle_name, note_user_last_name FROM $t_edb_case_index_notes WHERE note_case_id=$get_current_case_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_note_id, $get_current_note_case_id, $get_current_note_text, $get_current_note_datetime, $get_current_note_time, $get_current_note_date_saying, $get_current_note_date_ddmmyy, $get_current_note_user_id, $get_current_note_user_name, $get_current_note_user_alias, $get_current_note_user_email, $get_current_note_user_image_path, $get_current_note_user_image_file, $get_current_note_user_image_thumb_40, $get_current_note_user_image_thumb_50, $get_current_note_user_first_name, $get_current_note_user_middle_name, $get_current_note_user_last_name) = $row;

				echo"$get_current_note_text
			<!-- //Case notes -->

			<!-- Human tasks -->
				<h2 style=\"padding: 25px 0px 10px 0px;\"><a href=\"open_case_human_tasks.php?case_id=$get_current_case_id&amp;l=$l\" class=\"h2\">$l_human_tasks</a></h2>

					<table class=\"hor-zebra\">
					 <thead>
					  <tr>
					   <th scope=\"col\">
						<span>$l_task</span>
					   </th>
					   <th scope=\"col\">
						<span>$l_created</span>
					   </th>
					   <th scope=\"col\">
						<span>$l_deadline</span>
					   </th>
					   <th scope=\"col\">
						<span>$l_finished</span>
					   </th>
					   <th scope=\"col\">
						<span>$l_responsible</span>
					   </th>
					   <th scope=\"col\">
						<span>$l_actions</span>
					   </th>
					  </tr>
					 </thead>
					 <tbody>
					";
			
					$counter_human_tasks_total = 0;
					$counter_human_tasks_completed = 0;
					$query = "SELECT human_task_id, human_task_case_id, human_task_evidence_record_id, human_task_evidence_item_id, human_task_text, human_task_created_datetime, human_task_created_date, human_task_created_time, human_task_created_date_saying, human_task_created_date_ddmmyy, human_task_created_date_ddmmyyyy, human_task_deadline_date, human_task_deadline_time, human_task_deadline_date_saying, human_task_deadline_date_ddmmyy, human_task_deadline_date_ddmmyyyy, human_task_is_finished, human_task_finished_datetime, human_task_finished_date, human_task_finished_time, human_task_finished_date_saying, human_task_finished_date_ddmmyy, human_task_finished_date_ddmmyyyy, human_task_created_by_user_id, human_task_created_by_user_name, human_task_created_by_user_alias, human_task_created_by_user_email, human_task_created_by_user_image_path, human_task_created_by_user_image_file, human_task_created_by_user_image_thumb_40, human_task_created_by_user_image_thumb_50, human_task_created_by_user_first_name, human_task_created_by_user_middle_name, human_task_created_by_user_last_name, human_task_responsible_user_id, human_task_responsible_user_name, human_task_responsible_user_alias, human_task_responsible_user_email, human_task_responsible_user_image_path, human_task_responsible_user_image_file, human_task_responsible_user_image_thumb_40, human_task_responsible_user_image_thumb_50, human_task_responsible_user_first_name, human_task_responsible_user_middle_name, human_task_responsible_user_last_name FROM $t_edb_case_index_human_tasks WHERE human_task_case_id=$get_current_case_id ORDER BY human_task_id ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_human_task_id, $get_human_task_case_id, $get_human_task_evidence_record_id, $get_human_task_evidence_item_id, $get_human_task_text, $get_human_task_created_datetime, $get_human_task_created_date, $get_human_task_created_time, $get_human_task_created_date_saying, $get_human_task_created_date_ddmmyy, $get_human_task_created_date_ddmmyyyy, $get_human_task_deadline_date, $get_human_task_deadline_time, $get_human_task_deadline_date_saying, $get_human_task_deadline_date_ddmmyy, $get_human_task_deadline_date_ddmmyyyy, $get_human_task_is_finished, $get_human_task_finished_datetime, $get_human_task_finished_date, $get_human_task_finished_time, $get_human_task_finished_date_saying, $get_human_task_finished_date_ddmmyy, $get_human_task_finished_date_ddmmyyyy, $get_human_task_created_by_user_id, $get_human_task_created_by_user_name, $get_human_task_created_by_user_alias, $get_human_task_created_by_user_email, $get_human_task_created_by_user_image_path, $get_human_task_created_by_user_image_file, $get_human_task_created_by_user_image_thumb_40, $get_human_task_created_by_user_image_thumb_50, $get_human_task_created_by_user_first_name, $get_human_task_created_by_user_middle_name, $get_human_task_created_by_user_last_name, $get_human_task_responsible_user_id, $get_human_task_responsible_user_name, $get_human_task_responsible_user_alias, $get_human_task_responsible_user_email, $get_human_task_responsible_user_image_path, $get_human_task_responsible_user_image_file, $get_human_task_responsible_user_image_thumb_40, $get_human_task_responsible_user_image_thumb_50, $get_human_task_responsible_user_first_name, $get_human_task_responsible_user_middle_name, $get_human_task_responsible_user_last_name) = $row;

						if(isset($style) && $style == ""){
							$style = "odd";
						}
						else{
							$style = "";
						}

						echo"
						<tr>
						  <td class=\"$style\">
							<span>$get_human_task_text</span>
						  </td>
						  <td class=\"$style\">
							<span>$get_human_task_created_date_ddmmyy</span>
						  </td>
						  <td class=\"$style\">
							<span>$get_human_task_deadline_date_ddmmyy</span>
						  </td>
						  <td class=\"$style\">
							";
							if($get_human_task_is_finished == "" OR $get_human_task_is_finished == "0"){
								echo"<span><a href=\"open_case_human_tasks.php?case_id=$get_current_case_id&amp;action=set_task_finished&amp;human_task_id=$get_human_task_id&amp;l=$l&amp;process=1\"><img src=\"_gfx/tick_grey.png\" alt=\"tick_grey.png\" /></a>";
							}
							else{
								echo"<span><a href=\"open_case_human_tasks.php?case_id=$get_current_case_id&amp;action=set_task_unfinished&amp;human_task_id=$get_human_task_id&amp;l=$l&amp;process=1\"><img src=\"_gfx/tick.png\" alt=\"tick.png\" /></a> $get_human_task_finished_date_ddmmyy";
							}
							echo"
						  </td>
						  <td class=\"$style\">
							<a href=\"$root/users/view_profile.php?user_id=$get_human_task_responsible_user_id&amp;l=$l\" title=\"$get_human_task_responsible_user_first_name $get_human_task_responsible_user_middle_name $get_human_task_responsible_user_last_name\">$get_human_task_responsible_user_name</a>
						  </td>
						  <td class=\"$style\">
							<span>
							<a href=\"open_case_human_tasks.php?case_id=$get_current_case_id&amp;action=edit_task&amp;human_task_id=$get_human_task_id&amp;l=$l\">$l_edit</a>
							&middot;
							<a href=\"open_case_human_tasks.php?case_id=$get_current_case_id&amp;action=delete_task&amp;human_task_id=$get_human_task_id&amp;l=$l\">$l_delete</a>
							</span>
						 </td>
						</tr>
						";

						$counter_human_tasks_total++;
						if($get_human_task_is_finished == "1"){
							$counter_human_tasks_completed++;
						}
					} // while human tasks
					if($counter_human_tasks_total != "$get_current_menu_counter_human_tasks_total" OR $counter_human_tasks_completed != "$get_menu_counter_human_tasks_completed"){
						$result = mysqli_query($link, "UPDATE $t_edb_case_index_open_case_menu_counters SET menu_counter_human_tasks_completed=$counter_human_tasks_completed, menu_counter_human_tasks_total=$counter_human_tasks_total WHERE menu_counter_case_id=$get_current_case_id");
					}
					
					echo"
					 </tbody>
					</table>

			<!-- //Human tasks -->

			<!-- Glossaries -->
				<h2 style=\"padding: 25px 0px 10px 0px;\"><a href=\"open_case_glossaries.php?case_id=$get_current_case_id&amp;l=$l\" class=\"h2\">$l_glossaries</a></h2>

				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
					<span>$l_title</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_actions</span>
				   </th>
				  </tr>
				 </thead>
				 <tbody>
				";
				$counter=0;
				$query = "SELECT case_glossary_id, case_glossary_glossary_title FROM $t_edb_case_index_glossaries WHERE case_glossary_case_id=$get_current_case_id ORDER BY case_glossary_glossary_title ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_case_glossary_id, $get_case_glossary_glossary_title) = $row;

					if(isset($style) && $style == ""){
						$style = "odd";
					}
					else{
						$style = "";
					}
					echo"
					<tr>
					  <td class=\"$style\">
						<a href=\"open_case_glossaries.php?case_id=$get_current_case_id&amp;action=edit&amp;case_glossary_id=$get_case_glossary_id&amp;l=$l\">$get_case_glossary_glossary_title</a>
					  </td>
					  <td class=\"$style\">
						<span>
						<a href=\"open_case_glossaries.php?case_id=$get_current_case_id&amp;action=edit&amp;case_glossary_id=$get_case_glossary_id&amp;l=$l\">$l_edit</a>
						&middot;
						<a href=\"open_case_glossaries.php?case_id=$get_current_case_id&amp;action=delete&amp;case_glossary_id=$get_case_glossary_id&amp;l=$l\">$l_delete</a>
						</span>
					 </td>
					</tr>
					";
					$counter = $counter + 1;
				} // while events
				if($counter != "$get_current_menu_counter_glossaries"){
					$result = mysqli_query($link, "UPDATE $t_edb_case_index_open_case_menu_counters SET menu_counter_glossaries=$counter WHERE menu_counter_case_id=$get_current_case_id");
				}
				echo"
				 </tbody>
				</table>
			<!-- //Glossaries -->

			<!-- Automated tasks -->
				<h2 style=\"padding: 25px 0px 10px 0px;\"><a href=\"open_case_automated_tasks.php?case_id=$get_current_case_id&amp;l=$l\" class=\"h2\">$l_automated_tasks</a></h2>

				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
					<span>$l_evidence</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_task</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_created</span>
				   </th>
			 	  <th scope=\"col\">
					<span>$l_machine_type_needed</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_machine</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_finished</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_actions</span>
				   </th>
				  </tr>
				 </thead>
				 <tbody>
				";
				$counter_automated_tasks_completed = 0;
				$counter_automated_tasks_total = 0;
				$query = "SELECT automated_task_id, automated_task_case_id, automated_task_evidence_record_id, automated_task_evidence_item_id, automated_task_evidence_full_title, automated_task_task_available_id, automated_task_task_available_name, automated_task_task_machine_type_id, automated_task_task_machine_type_title, automated_task_mirror_file_id, automated_task_mirror_file_path_windows, automated_task_mirror_file_path_linux, automated_task_mirror_file_file, automated_task_added_datetime, automated_task_added_date, automated_task_added_time, automated_task_added_date_saying, automated_task_added_date_ddmmyy, automated_task_added_date_ddmmyyyy, automated_task_started_datetime, automated_task_started_date, automated_task_started_time, automated_task_started_date_saying, automated_task_started_date_ddmmyyhi, automated_task_started_date_ddmmyyyyhi, automated_task_machine_id, automated_task_machine_name, automated_task_is_finished, automated_task_finished_datetime, automated_task_finished_date, automated_task_finished_time, automated_task_finished_date_saying, automated_task_finished_date_ddmmyyhi, automated_task_finished_date_ddmmyyyyhi, automated_task_time_taken_time, automated_task_time_taken_human FROM $t_edb_case_index_automated_tasks WHERE automated_task_case_id=$get_current_case_id ORDER BY automated_task_id ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_automated_task_id, $get_automated_task_case_id, $get_automated_task_evidence_record_id, $get_automated_task_evidence_item_id, $get_automated_task_evidence_full_title, $get_automated_task_task_available_id, $get_automated_task_task_available_name, $get_automated_task_task_machine_type_id, $get_automated_task_task_machine_type_title, $get_automated_task_mirror_file_id, $get_automated_task_mirror_file_path_windows, $get_automated_task_mirror_file_path_linux, $get_automated_task_mirror_file_file, $get_automated_task_added_datetime, $get_automated_task_added_date, $get_automated_task_added_time, $get_automated_task_added_date_saying, $get_automated_task_added_date_ddmmyy, $get_automated_task_added_date_ddmmyyyy, $get_automated_task_started_datetime, $get_automated_task_started_date, $get_automated_task_started_time, $get_automated_task_started_date_saying, $get_automated_task_started_date_ddmmyyhi, $get_automated_task_started_date_ddmmyyyyhi, $get_automated_task_machine_id, $get_automated_task_machine_name, $get_automated_task_is_finished, $get_automated_task_finished_datetime, $get_automated_task_finished_date, $get_automated_task_finished_time, $get_automated_task_finished_date_saying, $get_automated_task_finished_date_ddmmyyhi, $get_automated_task_finished_date_ddmmyyyyhi, $get_automated_task_time_taken_time, $get_automated_task_time_taken_human) = $row;

					if(isset($style) && $style == ""){
						$style = "odd";
					}
					else{
						$style = "";
					}

					echo"
					<tr>
					  <td class=\"$style\">
						<span><a href=\"open_case_evidence_edit_evidence_item_info.php?case_id=$get_automated_task_case_id&amp;item_id=$get_automated_task_evidence_item_id&amp;l=$l\">$get_automated_task_evidence_full_title</a></span>
					  </td>
					  <td class=\"$style\">
						<span>$get_automated_task_task_available_name</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_automated_task_added_date_ddmmyy</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_automated_task_task_machine_type_title</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_automated_task_machine_name</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_automated_task_finished_date_ddmmyyyyhi</span>
					  </td>
					  <td class=\"$style\">
						<span>
						<a href=\"open_case_automated_tasks.php?case_id=$get_current_case_id&amp;action=edit_task&amp;automated_task_id=$get_automated_task_id&amp;l=$l\">$l_edit</a>
						&middot;
						<a href=\"open_case_automated_tasks.php?case_id=$get_current_case_id&amp;action=delete_task&amp;automated_task_id=$get_automated_task_id&amp;l=$l\">$l_delete</a>
						</span>
					 </td>
					</tr>
					";


					$counter_automated_tasks_total++;
					if($get_automated_task_finished_date_ddmmyyyyhi != ""){
						$counter_automated_tasks_completed++;
					}
				} // while automated tasks
				if($counter_automated_tasks_total != "$get_current_menu_counter_automated_tasks_total" OR $counter_automated_tasks_completed != "$get_current_menu_counter_automated_tasks_completed"){
					$result = mysqli_query($link, "UPDATE $t_edb_case_index_open_case_menu_counters SET menu_counter_automated_tasks_completed=$counter_automated_tasks_completed, menu_counter_automated_tasks_total=$counter_automated_tasks_total WHERE menu_counter_case_id=$get_current_case_id") or die(mysqli_error($link));
				}
				echo"
				 </tbody>
				</table>
			<!-- //Automated tasks -->
			<!-- Photos -->
				<h2 style=\"padding: 25px 0px 10px 0px;\"><a href=\"open_case_photos.php?case_id=$get_current_case_id&amp;l=$l\" class=\"h2\">$l_photos</a></h2>
				";
					$x = 0;
					$count_photos = 0;
					$query = "SELECT photo_id, photo_case_id, photo_path, photo_file, photo_ext, photo_thumb_60, photo_thumb_200, photo_title, photo_description, photo_uploaded_datetime, photo_weight FROM $t_edb_case_index_photos WHERE photo_case_id=$get_current_case_id ORDER BY photo_id DESC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_photo_id, $get_photo_case_id, $get_photo_path, $get_photo_file, $get_photo_ext, $get_photo_thumb_60, $get_photo_thumb_200, $get_photo_title, $get_photo_description, $get_photo_uploaded_datetime, $get_photo_weight) = $row;


						// Look for image
						if(!(file_exists("$root/$get_photo_path/$get_photo_file")) OR $get_photo_file == ""){
							echo"<div class=\"info\"><p>Image doesnt exists. Deleting database reference.</p></div>\n";
							$result_delete = mysqli_query($link, "DELETE FROM $t_edb_case_index_photos WHERE photo_id=$get_photo_id");
						}
	
						// Look for thumb
						if(!(file_exists("$root/$get_photo_path/$get_photo_thumb_200")) && $get_photo_thumb_200 != ""){
							resize_crop_image(200, 200, "$root/$get_photo_path/$get_photo_file", "$root/$get_photo_path/$get_photo_thumb_200");
						}

						// Layout
						if($x == 0){
							echo"
							<div class=\"image_gallery_folder_browse_row\">
							";
						}
						echo"
								<div class=\"image_gallery_folder_browse_col\">
									<p>
									<a href=\"open_case_photos.php?case_id=$get_current_case_id&amp;photo_id=$get_photo_id&amp;action=view_photo&amp;l=$l\"><img src=\"$root/$get_photo_path/$get_photo_thumb_200\" alt=\"$get_photo_thumb_200\" /></a><br />
									<a href=\"open_case_photos.php?case_id=$get_current_case_id&amp;photo_id=$get_photo_id&amp;action=view_photo&amp;l=$l\">$get_photo_title</a>
									</p>
								</div>
						";

						// Layout
						if($x == 3){
							echo"
							</div>
							";
							$x = -1;
						}
						$x++;
						$count_photos = $count_photos + 1;

						// Weight
						if($get_photo_weight != "$count_photos"){
							$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_photos SET
									photo_weight=$count_photos
									 WHERE photo_id=$get_photo_id");

						}
					}
					if($count_photos != "$get_current_menu_counter_photos"){
						$result = mysqli_query($link, "UPDATE $t_edb_case_index_open_case_menu_counters SET menu_counter_photos=$count_photos WHERE menu_counter_case_id=$get_current_case_id");
					}
					if($x == "1"){
						echo"
								<div class=\"image_gallery_folder_browse_col\">
								</div>
								<div class=\"image_gallery_folder_browse_col\">
								</div>
								<div class=\"image_gallery_folder_browse_col\">
								</div>
						";
					}
					elseif($x == "2"){
						echo"
								<div class=\"image_gallery_folder_browse_col\">
								</div>
								<div class=\"image_gallery_folder_browse_col\">
								</div>
						";
					}
					elseif($x == "3"){
						echo"
								<div class=\"image_gallery_folder_browse_col\">
								</div>
						";
					}
					
					if($x != 0){
						echo"
							</div>
						";
					}
				echo"
			<!-- //Photos -->

			";

		} // access to station
	} // case found

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