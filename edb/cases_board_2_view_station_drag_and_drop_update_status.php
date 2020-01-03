<?php 
/**
*
* File: edb/cases_board_2_view_station_drag_and_drop_update_status.php
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
include("$root/_admin/_translations/site/$l/edb/ts_cases_board_2_view_station_drag_and_drop_update_status.php");

/*- Functions -------------------------------------------------------------------------- */
function seconds_to_days($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a');
}
function seconds_to_time($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
}

/*- Query --------------------------------------------------------------------------- */
if(isset($_POST['case_id']) && isset($_POST['status_id'])){
	$case_id = $_POST['case_id'];
	$case_id = output_html($case_id);
	$case_id = str_replace("case_id", "", $case_id);
	$case_id_mysql = quote_smart($link, $case_id);

	$status_id = $_POST['status_id'];
	$status_id = output_html($status_id);
	$status_id = str_replace("status_id", "", $status_id);
	$status_id_mysql = quote_smart($link, $status_id);

	// Look for user id
	// if user id is present, then we want to also assign it to the user
	
	if(strstr($status_id, 'user_id')) {
		// Remove user id from string
		$array = explode("user_id", $status_id);
		$status_id 	   = $array[0];
		$assign_to_user_id = $array[1];
	}


	// Find case
	$query = "SELECT case_id, case_status_id, case_district_id, case_station_id, case_created_time FROM $t_edb_case_index WHERE case_id=$case_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_case_id, $get_case_status_id, $get_case_district_id, $get_case_station_id, $get_case_created_time) = $row;
	
	if($get_case_id == ""){
		echo"Case not found";
	}
	else{
		// Find status
		$query = "SELECT status_id, status_parent_id, status_title, status_title_clean, status_bg_color, status_border_color, status_text_color, status_link_color, status_weight, status_number_of_cases_now, status_number_of_cases_max, status_show_on_front_page, status_on_given_status_do_close_case, status_on_person_view_show_without_person, status_on_person_view_show_before_person, status_show_on_stats_page, status_show_as_image, status_image_path, status_image_file, status_gives_amount_of_points_to_user FROM $t_edb_case_statuses WHERE status_id=$status_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_new_status_id, $get_new_status_parent_id, $get_new_status_title, $get_new_status_title_clean, $get_new_status_bg_color, $get_new_status_border_color, $get_new_status_text_color, $get_new_status_link_color, $get_new_status_weight, $get_new_status_number_of_cases_now, $get_new_status_number_of_cases_max, $get_new_status_show_on_front_page, $get_new_status_on_given_status_do_close_case, $get_new_status_on_person_view_show_without_person, $get_new_status_on_person_view_show_before_person, $get_new_status_show_on_stats_page, $get_new_status_show_as_image, $get_new_status_image_path, $get_new_status_image_file, $get_new_status_gives_amount_of_points_to_user) = $row;
		if($get_new_status_id == ""){
			echo"New status not found";
		}
		else{
			// Dates
			$inp_datetime = date("Y-m-d H:i:s");
			$inp_time = time();
			$inp_date_saying = date("j M Y");
			$inp_date_ddmmyy = date("d.m.y");


			// Move to self?
			if($get_case_status_id == "$get_new_status_id"){
				// Move to self
				echo"
				<div class=\"warning\">$l_the_case_already_have_the_status</div>
				";
			}
			else{
				// Does the new status close the case? If so, then all tasks has to be completed!
				if($get_new_status_on_given_status_do_close_case == "1"){
					// Check all tasks
					
					$query = "SELECT human_task_id FROM $t_edb_case_index_human_tasks WHERE human_task_case_id=$get_case_id AND human_task_is_finished=0";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_human_task_id) = $row;
					if($get_human_task_id != ""){
						echo"
						<div class=\"error\" style=\"margin: 10px 0px 10px 0px;\"><a href=\"open_case_human_tasks.php?case_id=$get_case_id&amp;l=$l\" style=\"font-size: 400%;\">$l_not_all_tasks_for_case_is_finished</div>
						<meta http-equiv=\"refresh\" content=\"1;url=open_case_human_tasks.php?case_id=$get_case_id&amp;l=$l\">
						";
						die;
					}
				}


				// Total (all districts+stations): Update number of cases on new status
				$inp_new_status_number_of_cases_now = $get_new_status_number_of_cases_now+1;
				$result = mysqli_query($link, "UPDATE $t_edb_case_statuses SET status_number_of_cases_now=$inp_new_status_number_of_cases_now WHERE status_id=$get_new_status_id");


				// Total (all districts+stations): Update number of cases on old status
				$query = "SELECT status_id, status_parent_id, status_title, status_number_of_cases_now, status_on_given_status_do_close_case FROM $t_edb_case_statuses WHERE status_id=$get_case_status_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_old_status_id, $get_old_status_parent_id, $get_old_status_title, $get_old_status_number_of_cases_now, $get_old_status_on_given_status_do_close_case) = $row;
	
				$inp_old_status_number_of_cases_now = $get_old_status_number_of_cases_now-1;
				$result = mysqli_query($link, "UPDATE $t_edb_case_statuses SET status_number_of_cases_now=$inp_old_status_number_of_cases_now WHERE status_id=$get_old_status_id");

				// Current station:  Update number of cases on old status
				$query = "SELECT station_case_counter_id, station_case_counter_station_id, station_case_counter_status_id, station_case_counter_number_of_cases_now FROM $t_edb_case_statuses_station_case_counter WHERE station_case_counter_station_id=$get_case_station_id AND station_case_counter_status_id=$get_case_status_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_old_station_case_counter_id, $get_old_station_case_counter_station_id, $get_old_station_case_counter_status_id, $get_old_station_case_counter_number_of_cases_now) = $row;
				if($get_old_station_case_counter_id == ""){
					// First case
					mysqli_query($link, "INSERT INTO $t_edb_case_statuses_station_case_counter
					(station_case_counter_id, station_case_counter_station_id, station_case_counter_status_id, station_case_counter_number_of_cases_now) 
					VALUES 
					(NULL, $get_case_station_id, $get_case_status_id, 0)")
					or die(mysqli_error($link));
				}
				else{
					$inp_station_case_counter_number_of_cases_now = $get_old_station_case_counter_number_of_cases_now-1;
					$result = mysqli_query($link, "UPDATE $t_edb_case_statuses_station_case_counter SET station_case_counter_number_of_cases_now=$inp_station_case_counter_number_of_cases_now WHERE station_case_counter_id=$get_old_station_case_counter_id") or die(mysqli_error($link));
				}

				// Current station:  Update number of cases on new status
				$query = "SELECT station_case_counter_id, station_case_counter_station_id, station_case_counter_status_id, station_case_counter_number_of_cases_now FROM $t_edb_case_statuses_station_case_counter WHERE station_case_counter_station_id=$get_case_station_id AND station_case_counter_status_id=$get_new_status_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_new_station_case_counter_id, $get_new_station_case_counter_station_id, $get_new_station_case_counter_status_id, $get_new_station_case_counter_number_of_cases_now) = $row;
				if($get_new_station_case_counter_id == ""){
					// First case
					mysqli_query($link, "INSERT INTO $t_edb_case_statuses_station_case_counter
					(station_case_counter_id, station_case_counter_station_id, station_case_counter_status_id, station_case_counter_number_of_cases_now) 
					VALUES 
					(NULL, $get_case_station_id, $get_new_status_id, 1)")
					or die(mysqli_error($link));
				}
				else{
					$inp_station_case_counter_number_of_cases_now = $get_new_station_case_counter_number_of_cases_now+1;
					$result = mysqli_query($link, "UPDATE $t_edb_case_statuses_station_case_counter SET station_case_counter_number_of_cases_now=$inp_station_case_counter_number_of_cases_now WHERE station_case_counter_id=$get_new_station_case_counter_id") or die(mysqli_error($link));
				}

				// Current district:  Update number of cases on old status
				$query = "SELECT district_case_counter_id, district_case_counter_district_id, district_case_counter_status_id, district_case_counter_number_of_cases_now FROM $t_edb_case_statuses_district_case_counter WHERE district_case_counter_district_id=$get_case_district_id AND district_case_counter_status_id=$get_case_status_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_old_district_case_counter_id, $get_old_district_case_counter_district_id, $get_old_district_case_counter_status_id, $get_old_district_case_counter_number_of_cases_now) = $row;
				if($get_old_district_case_counter_id == ""){
					// First case
					mysqli_query($link, "INSERT INTO $t_edb_case_statuses_district_case_counter
					(district_case_counter_id, district_case_counter_district_id, district_case_counter_status_id, district_case_counter_number_of_cases_now) 
					VALUES 
					(NULL, $get_case_district_id, $get_case_status_id, 0)")
					or die(mysqli_error($link));
				}
				else{
					$inp_district_case_counter_number_of_cases_now = $get_old_district_case_counter_number_of_cases_now-1;
					$result = mysqli_query($link, "UPDATE $t_edb_case_statuses_district_case_counter SET district_case_counter_number_of_cases_now=$inp_district_case_counter_number_of_cases_now WHERE district_case_counter_id=$get_old_district_case_counter_id") or die(mysqli_error($link));
				}
				// Current district:  Update number of cases on new status
				$query = "SELECT district_case_counter_id, district_case_counter_district_id, district_case_counter_status_id, district_case_counter_number_of_cases_now FROM $t_edb_case_statuses_district_case_counter WHERE district_case_counter_district_id=$get_case_district_id AND district_case_counter_status_id=$get_new_status_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_new_district_case_counter_id, $get_new_district_case_counter_district_id, $get_new_district_case_counter_status_id, $get_new_district_case_counter_number_of_cases_now) = $row;
				if($get_new_district_case_counter_id == ""){
					// First case
					mysqli_query($link, "INSERT INTO $t_edb_case_statuses_district_case_counter
					(district_case_counter_id, district_case_counter_district_id, district_case_counter_status_id, district_case_counter_number_of_cases_now) 
					VALUES 
					(NULL, $get_case_district_id, $get_new_status_id, 1)")
					or die(mysqli_error($link));
				}
				else{
					$inp_district_case_counter_number_of_cases_now = $get_new_district_case_counter_number_of_cases_now+1;
					$result = mysqli_query($link, "UPDATE $t_edb_case_statuses_district_case_counter SET district_case_counter_number_of_cases_now=$inp_district_case_counter_number_of_cases_now WHERE district_case_counter_id=$get_new_district_case_counter_id") or die(mysqli_error($link));
				}

			
				// Update status on case
				$inp_status_title_mysql = quote_smart($link, $get_new_status_title);
				$result = mysqli_query($link, "UPDATE $t_edb_case_index SET case_status_id=$get_new_status_id, case_status_title=$inp_status_title_mysql, case_is_closed=0 WHERE case_id=$get_case_id");




				// Insert into status table
				$inp_status_title_mysql = quote_smart($link, $get_new_status_title);

				// Me
				$my_user_id = $_SESSION['user_id'];
				$my_user_id = output_html($my_user_id);
				$my_user_id_mysql = quote_smart($link, $my_user_id);
			
				// My user
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


				mysqli_query($link, "INSERT INTO $t_edb_case_index_statuses
				(case_index_status_id, case_index_status_case_id, case_index_status_status_id, case_index_status_status_title, case_index_status_datetime, case_index_status_time, case_index_status_date_saying, case_index_status_date_ddmmyy, case_index_status_text, case_index_status_user_id, case_index_status_user_name, case_index_status_user_alias, case_index_status_user_email, case_index_status_user_image_path, case_index_status_user_image_file, case_index_status_user_image_thumb_40, case_index_status_user_image_thumb_50, case_index_status_user_first_name, case_index_status_user_middle_name, case_index_status_user_last_name) 
				VALUES 
				(NULL, $get_case_id, $get_new_status_id, $inp_status_title_mysql, '$inp_datetime', '$inp_time', '$inp_date_saying', '$inp_date_ddmmyy', '', '$get_my_user_id', $inp_my_user_name_mysql, $inp_my_user_alias_mysql, $inp_my_user_email_mysql, $inp_my_user_image_path_mysql, $inp_my_user_image_file_mysql, $inp_my_user_image_thumb_a_mysql, $inp_my_user_image_thumb_b_mysql, $inp_my_user_first_name_mysql, $inp_my_user_middle_name_mysql, $inp_my_user_last_name_mysql)")
				or die(mysqli_error($link));
	

			
				// Statistics start
				$year = date("Y");
				$month = date("m");
				$month_saying = date("M");
				$day = date("d");
				$day_saying = date("D");
				$max_days = date('t');
				$between_from = "01-$month-$year";
				$between_to = "$max_days-$month-$year";


				// Close case?
				if($get_new_status_on_given_status_do_close_case == "1"){
					
					$inp_time_from_created_to_close = $inp_time-$get_case_created_time;

					$result = mysqli_query($link, "UPDATE $t_edb_case_index SET 
								case_is_closed='1',
								case_closed_datetime='$inp_datetime',
								case_closed_time='$inp_time',
								case_closed_date_saying='$inp_date_saying',
								case_closed_date_ddmmyy='$inp_date_ddmmyy',
								case_time_from_created_to_close='$inp_time_from_created_to_close'
								 WHERE case_id=$get_case_id");



				
					// 1) Statistics :: District
					// -> District Avg time
					$query = "SELECT AVG(case_time_from_created_to_close) FROM $t_edb_case_index WHERE case_district_id=$get_case_district_id AND case_closed_datetime > '$between_from' AND  case_closed_datetime < '$between_to'";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_avg_case_time_from_created_to_close) = $row;
					
					$get_avg_case_time_from_created_to_close = round($get_avg_case_time_from_created_to_close, 0);

					$inp_stats_avg_created_to_close_time = "$get_avg_case_time_from_created_to_close";
					$inp_stats_avg_created_to_close_time_mysql = quote_smart($link, $inp_stats_avg_created_to_close_time);

					$inp_stats_avg_created_to_close_days = seconds_to_days($get_avg_case_time_from_created_to_close);
					$inp_stats_avg_created_to_close_days_mysql = quote_smart($link, $inp_stats_avg_created_to_close_days);

					$inp_stats_avg_created_to_close_saying = seconds_to_time($get_avg_case_time_from_created_to_close);
					$inp_stats_avg_created_to_close_saying_mysql = quote_smart($link, $inp_stats_avg_created_to_close_saying);

					$query = "SELECT stats_id, stats_year, stats_month, stats_month_saying, stats_district_id, stats_station_id, stats_user_id, stats_cases_created, stats_cases_closed FROM $t_edb_stats_index WHERE stats_year=$year AND stats_month=$month AND stats_district_id=$get_case_district_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_stats_id, $get_stats_year, $get_stats_month, $get_stats_month_saying, $get_stats_district_id, $get_stats_station_id, $get_stats_user_id, $get_stats_cases_created, $get_stats_cases_closed) = $row;
					if($get_stats_id == ""){
						mysqli_query($link, "INSERT INTO $t_edb_stats_index 
						(stats_id, stats_year, stats_month, stats_month_saying, stats_district_id, stats_station_id, stats_user_id, stats_cases_created, stats_cases_closed, stats_avg_created_to_close_time, stats_avg_created_to_close_days, stats_avg_created_to_close_saying) 
						VALUES 
						(NULL, $year, $month, '$month_saying', $get_case_district_id, NULL, NULL, 0, 1, $inp_stats_avg_created_to_close_time_mysql, $inp_stats_avg_created_to_close_days_mysql, $inp_stats_avg_created_to_close_saying_mysql)")
						or die(mysqli_error($link));
					}
					else{
						$inp_stats_cases_closed = $get_stats_cases_closed+1;
						$result_update = mysqli_query($link, "UPDATE $t_edb_stats_index SET stats_cases_closed=$inp_stats_cases_closed,
											stats_avg_created_to_close_time=$inp_stats_avg_created_to_close_time_mysql,
											stats_avg_created_to_close_days=$inp_stats_avg_created_to_close_days_mysql,
											stats_avg_created_to_close_saying=$inp_stats_avg_created_to_close_saying_mysql WHERE stats_id=$get_stats_id");
					}

					// 2) Statistics :: Station
					// -> Station Avg time
					$query = "SELECT AVG(case_time_from_created_to_close) FROM $t_edb_case_index WHERE case_station_id=$get_case_station_id AND case_closed_datetime > '$between_from' AND  case_closed_datetime < '$between_to'";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_avg_case_time_from_created_to_close) = $row;
					
					$get_avg_case_time_from_created_to_close = round($get_avg_case_time_from_created_to_close, 0);

					$inp_stats_avg_created_to_close_time = "$get_avg_case_time_from_created_to_close";
					$inp_stats_avg_created_to_close_time_mysql = quote_smart($link, $inp_stats_avg_created_to_close_time);

					$inp_stats_avg_created_to_close_days = seconds_to_days($get_avg_case_time_from_created_to_close);
					$inp_stats_avg_created_to_close_days_mysql = quote_smart($link, $inp_stats_avg_created_to_close_days);

					$inp_stats_avg_created_to_close_saying = seconds_to_time($get_avg_case_time_from_created_to_close);
					$inp_stats_avg_created_to_close_saying_mysql = quote_smart($link, $inp_stats_avg_created_to_close_saying);

					$query = "SELECT stats_id, stats_year, stats_month, stats_month_saying, stats_district_id, stats_station_id, stats_user_id, stats_cases_created, stats_cases_closed FROM $t_edb_stats_index WHERE stats_year=$year AND stats_month=$month AND stats_station_id=$get_case_station_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_stats_id, $get_stats_year, $get_stats_month, $get_stats_month_saying, $get_stats_district_id, $get_stats_station_id, $get_stats_user_id, $get_stats_cases_created, $get_stats_cases_closed) = $row;
					if($get_stats_id == ""){
						mysqli_query($link, "INSERT INTO $t_edb_stats_index 
						(stats_id, stats_year, stats_month, stats_month_saying, stats_district_id, stats_station_id, stats_user_id, stats_cases_created, stats_cases_closed, stats_avg_created_to_close_time, stats_avg_created_to_close_days, stats_avg_created_to_close_saying) 
						VALUES 
						(NULL, $year, $month, '$month_saying', NULL, $get_case_station_id, NULL, 0, 1, $inp_stats_avg_created_to_close_time_mysql, $inp_stats_avg_created_to_close_days_mysql, $inp_stats_avg_created_to_close_saying_mysql)")
						or die(mysqli_error($link));
					}
					else{
						$inp_stats_cases_closed = $get_stats_cases_closed+1;
						$result_update = mysqli_query($link, "UPDATE $t_edb_stats_index SET stats_cases_closed=$inp_stats_cases_closed,
											stats_avg_created_to_close_time=$inp_stats_avg_created_to_close_time_mysql,
											stats_avg_created_to_close_days=$inp_stats_avg_created_to_close_days_mysql,
											stats_avg_created_to_close_saying=$inp_stats_avg_created_to_close_saying_mysql 
											 WHERE stats_id=$get_stats_id");
					}

					// 3) Statistics :: Person
					// -> Person Avg time
					$query = "SELECT AVG(case_time_from_created_to_close) FROM $t_edb_case_index WHERE case_created_user_id=$my_user_id_mysql AND case_closed_datetime > '$between_from' AND  case_closed_datetime < '$between_to'";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_avg_case_time_from_created_to_close) = $row;
					
					$get_avg_case_time_from_created_to_close = round($get_avg_case_time_from_created_to_close, 0);

					$inp_stats_avg_created_to_close_time = "$get_avg_case_time_from_created_to_close";
					$inp_stats_avg_created_to_close_time_mysql = quote_smart($link, $inp_stats_avg_created_to_close_time);

					$inp_stats_avg_created_to_close_days = seconds_to_days($get_avg_case_time_from_created_to_close);
					$inp_stats_avg_created_to_close_days_mysql = quote_smart($link, $inp_stats_avg_created_to_close_days);

					$inp_stats_avg_created_to_close_saying = seconds_to_time($get_avg_case_time_from_created_to_close);
					$inp_stats_avg_created_to_close_saying_mysql = quote_smart($link, $inp_stats_avg_created_to_close_saying);

					$query = "SELECT stats_id, stats_year, stats_month, stats_month_saying, stats_district_id, stats_station_id, stats_user_id, stats_cases_created, stats_cases_closed FROM $t_edb_stats_index WHERE stats_year=$year AND stats_month=$month AND stats_user_id=$my_user_id_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_stats_id, $get_stats_year, $get_stats_month, $get_stats_month_saying, $get_stats_district_id, $get_stats_station_id, $get_stats_user_id, $get_stats_cases_created, $get_stats_cases_closed) = $row;
					if($get_stats_id == ""){
						mysqli_query($link, "INSERT INTO $t_edb_stats_index 
						(stats_id, stats_year, stats_month, stats_month_saying, stats_district_id, stats_station_id, stats_user_id, stats_cases_created, stats_cases_closed, stats_avg_created_to_close_time, stats_avg_created_to_close_days, stats_avg_created_to_close_saying) 
						VALUES 
						(NULL, $year, $month, '$month_saying', NULL, NULL, $my_user_id_mysql, 0, 1, $inp_stats_avg_created_to_close_time_mysql, $inp_stats_avg_created_to_close_days_mysql, $inp_stats_avg_created_to_close_saying_mysql)")
						or die(mysqli_error($link));
					}
					else{
						$inp_stats_cases_closed = $get_stats_cases_closed+1;
						$result_update = mysqli_query($link, "UPDATE $t_edb_stats_index SET stats_cases_closed=$inp_stats_cases_closed,
											stats_avg_created_to_close_time=$inp_stats_avg_created_to_close_time_mysql,
											stats_avg_created_to_close_days=$inp_stats_avg_created_to_close_days_mysql,
											stats_avg_created_to_close_saying=$inp_stats_avg_created_to_close_saying_mysql  WHERE stats_id=$get_stats_id");
					}

				} // close case


				// Cases statuses per day
				// Cases statuses per day :: 4) District
				$inp_status_title_mysql = quote_smart($link, $get_new_status_title);
				$inp_status_weight_mysql = quote_smart($link, $get_new_status_weight);
				// $get_new_status_id, $get_new_status_title, $get_new_status_title_clean, $get_new_status_bg_color, $get_new_status_border_color, $get_new_status_text_color, $get_new_status_link_color, $get_new_status_weight, $get_new_status_number_of_cases_now, $get_new_status_number_of_cases_max, $get_new_status_show_on_front_page, $get_new_status_on_given_status_do_close_case
				$query = "SELECT status_per_day_id, status_per_day_year, status_per_day_month, status_per_day_day, status_per_day_district_id, status_per_day_station_id, status_per_day_user_id, status_per_day_status_id, status_per_day_status_title, status_per_day_weight, status_per_day_counter, status_per_day_avg_spent_time, status_per_day_avg_spent_days, status_per_day_avg_spent_saying FROM $t_edb_stats_statuses_per_day WHERE status_per_day_year=$year AND status_per_day_month=$month AND status_per_day_day=$day AND status_per_day_district_id=$get_case_district_id AND status_per_day_status_id=$get_new_status_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_status_per_day_id, $get_status_per_day_year, $get_status_per_day_month, $get_status_per_day_day, $get_status_per_day_district_id, $get_status_per_day_station_id, $get_status_per_day_user_id, $get_status_per_day_status_id, $get_status_per_day_status_title, $get_status_per_day_weight, $get_status_per_day_counter, $get_status_per_day_avg_spent_time, $get_status_per_day_avg_spent_days, $get_status_per_day_avg_spent_saying) = $row;
				if($get_status_per_day_id == ""){
					mysqli_query($link, "INSERT INTO $t_edb_stats_statuses_per_day 
					(status_per_day_id, status_per_day_year, status_per_day_month, status_per_day_day, status_per_day_day_saying, status_per_day_district_id, status_per_day_station_id, status_per_day_user_id, status_per_day_status_id, status_per_day_status_title, status_per_day_weight, status_per_day_counter, status_per_day_avg_spent_time, status_per_day_avg_spent_days, status_per_day_avg_spent_saying) 
					VALUES 
					(NULL, $year, $month, '$day', '$day_saying', $get_case_district_id, NULL, NULL, $get_new_status_id, $inp_status_title_mysql, $inp_status_weight_mysql, 1, 0, 0, 0)")
					or die(mysqli_error($link));
				}
				else{
					$inp_status_per_day_counter = $get_status_per_day_counter+1;
					$result_update = mysqli_query($link, "UPDATE $t_edb_stats_statuses_per_day SET 
							status_per_day_counter=$inp_status_per_day_counter
							 WHERE status_per_day_id=$get_status_per_day_id");
				}

				// Cases statuses per day :: 5) Station
				$query = "SELECT status_per_day_id, status_per_day_year, status_per_day_month, status_per_day_day, status_per_day_district_id, status_per_day_station_id, status_per_day_user_id, status_per_day_status_id, status_per_day_status_title, status_per_day_weight, status_per_day_counter, status_per_day_avg_spent_time, status_per_day_avg_spent_days, status_per_day_avg_spent_saying FROM $t_edb_stats_statuses_per_day WHERE status_per_day_year=$year AND status_per_day_month=$month AND status_per_day_day=$day AND status_per_day_station_id=$get_case_station_id AND status_per_day_status_id=$get_new_status_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_status_per_day_id, $get_status_per_day_year, $get_status_per_day_month, $get_status_per_day_day, $get_status_per_day_district_id, $get_status_per_day_station_id, $get_status_per_day_user_id, $get_status_per_day_status_id, $get_status_per_day_status_title, $get_status_per_day_weight, $get_status_per_day_counter, $get_status_per_day_avg_spent_time, $get_status_per_day_avg_spent_days, $get_status_per_day_avg_spent_saying) = $row;
				if($get_status_per_day_id == ""){
					mysqli_query($link, "INSERT INTO $t_edb_stats_statuses_per_day 
					(status_per_day_id, status_per_day_year, status_per_day_month, status_per_day_day, status_per_day_day_saying, status_per_day_district_id, status_per_day_station_id, status_per_day_user_id, status_per_day_status_id, status_per_day_status_title, status_per_day_weight, status_per_day_counter, status_per_day_avg_spent_time, status_per_day_avg_spent_days, status_per_day_avg_spent_saying) 
					VALUES 
					(NULL, $year, $month, '$day', '$day_saying', NULL, $get_case_station_id, NULL, $get_new_status_id, $inp_status_title_mysql, $inp_status_weight_mysql, 1, 0, 0, 0)")
					or die(mysqli_error($link));
				}
				else{
					$inp_status_per_day_counter = $get_status_per_day_counter+1;
					$result_update = mysqli_query($link, "UPDATE $t_edb_stats_statuses_per_day SET 
							status_per_day_counter=$inp_status_per_day_counter
							 WHERE status_per_day_id=$get_status_per_day_id");
				}

				// Cases statuses per day :: 6) Person
				$query = "SELECT status_per_day_id, status_per_day_year, status_per_day_month, status_per_day_day, status_per_day_district_id, status_per_day_station_id, status_per_day_user_id, status_per_day_status_id, status_per_day_status_title, status_per_day_weight, status_per_day_counter, status_per_day_avg_spent_time, status_per_day_avg_spent_days, status_per_day_avg_spent_saying FROM $t_edb_stats_statuses_per_day WHERE status_per_day_year=$year AND status_per_day_month=$month AND status_per_day_day=$day AND status_per_day_user_id=$my_user_id_mysql AND status_per_day_status_id=$get_new_status_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_status_per_day_id, $get_status_per_day_year, $get_status_per_day_month, $get_status_per_day_day, $get_status_per_day_district_id, $get_status_per_day_station_id, $get_status_per_day_user_id, $get_status_per_day_status_id, $get_status_per_day_status_title, $get_status_per_day_weight, $get_status_per_day_counter, $get_status_per_day_avg_spent_time, $get_status_per_day_avg_spent_days, $get_status_per_day_avg_spent_saying) = $row;
				if($get_status_per_day_id == ""){
					mysqli_query($link, "INSERT INTO $t_edb_stats_statuses_per_day 
					(status_per_day_id, status_per_day_year, status_per_day_month, status_per_day_day, status_per_day_day_saying, status_per_day_district_id, status_per_day_station_id, status_per_day_user_id, status_per_day_status_id, status_per_day_status_title, status_per_day_weight, status_per_day_counter, status_per_day_avg_spent_time, status_per_day_avg_spent_days, status_per_day_avg_spent_saying) 
					VALUES 
					(NULL, $year, $month, '$day', '$day_saying', NULL, NULL, $my_user_id_mysql, $get_new_status_id, $inp_status_title_mysql, $inp_status_weight_mysql, 1, 0, 0, 0)")
					or die(mysqli_error($link));
				}
				else{
					$inp_status_per_day_counter = $get_status_per_day_counter+1;
					$result_update = mysqli_query($link, "UPDATE $t_edb_stats_statuses_per_day SET 
							status_per_day_counter=$inp_status_per_day_counter
							 WHERE status_per_day_id=$get_status_per_day_id");
				}


				echo"
				<div class=\"info\">$l_status_updated</div>
				";
			} // Move to self?



			// If status == "Tildelt", "Sikres" etc then we someone have to be in charge of the assignment.
			if($get_new_status_on_person_view_show_without_person == "0"){
				if(!(isset($assign_to_user_id))){
					$assign_to_user_id = $_SESSION['user_id'];
				}
			}

			// Assign the case to the given user
			if(isset($assign_to_user_id)){
					$assign_to_user_id = output_html($assign_to_user_id);
					$assign_to_user_id_mysql = quote_smart($link, $assign_to_user_id);

					// Assign to user profile
					$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_id=$assign_to_user_id_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_assign_to_user_id, $get_assign_to_user_email, $get_assign_to_user_name, $get_assign_to_user_alias, $get_assign_to_user_language, $get_assign_to_user_last_online, $get_assign_to_user_rank, $get_assign_to_user_login_tries) = $row;
					
					if($get_assign_to_user_id == ""){

						$get_assign_to_user_id = "0";

						$get_assign_to_user_name = "0";
						$get_assign_to_user_alias = "0";
						$get_assign_to_user_email = "0";

						$get_assign_to_photo_destination = "0";

						$get_assign_to_photo_thumb_40 = "0";
						$get_assign_to_photo_thumb_50 = "0";

						$get_assign_to_profile_first_name = "0";
						$get_assign_to_profile_middle_name = "0";
						$get_assign_to_profile_last_name = "0";
					}
					else{
						// Assign to photo
						$query = "SELECT photo_id, photo_destination, photo_thumb_40, photo_thumb_50 FROM $t_users_profile_photo WHERE photo_user_id=$assign_to_user_id_mysql AND photo_profile_image='1'";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_assign_to_photo_id, $get_assign_to_photo_destination, $get_assign_to_photo_thumb_40, $get_assign_to_photo_thumb_50) = $row;

						// Assign to Profile
						$query = "SELECT profile_id, profile_first_name, profile_middle_name, profile_last_name, profile_about FROM $t_users_profile WHERE profile_user_id=$assign_to_user_id_mysql";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_assign_to_profile_id, $get_assign_to_profile_first_name, $get_assign_to_profile_middle_name, $get_assign_to_profile_last_name, $get_assign_to_profile_about) = $row;


					}
					$inp_assign_to_user_name_mysql = quote_smart($link, $get_assign_to_user_name);
					$inp_assign_to_user_alias_mysql = quote_smart($link, $get_assign_to_user_alias);
					$inp_assign_to_user_email_mysql = quote_smart($link, $get_assign_to_user_email);

					$inp_assign_to_user_image_path = "_uploads/users/images/$get_assign_to_user_id";
					$inp_assign_to_user_image_path_mysql = quote_smart($link, $inp_assign_to_user_image_path);

					$inp_assign_to_user_image_file_mysql = quote_smart($link, $get_assign_to_photo_destination);

					$inp_assign_to_user_image_thumb_a_mysql = quote_smart($link, $get_assign_to_photo_thumb_40);
					$inp_assign_to_user_image_thumb_b_mysql = quote_smart($link, $get_assign_to_photo_thumb_50);

					$inp_assign_to_user_first_name_mysql = quote_smart($link, $get_assign_to_profile_first_name);
					$inp_assign_to_user_middle_name_mysql = quote_smart($link, $get_assign_to_profile_middle_name);
					$inp_assign_to_user_last_name_mysql = quote_smart($link, $get_assign_to_profile_last_name);


					$result = mysqli_query($link, "UPDATE $t_edb_case_index SET 
									case_assigned_to_datetime='$inp_datetime',
									case_assigned_to_time='$inp_time',
									case_assigned_to_date_saying='$inp_date_saying',	
									case_assigned_to_date_ddmmyy='$inp_date_ddmmyy',
									case_assigned_to_user_id=$get_assign_to_user_id,
									case_assigned_to_user_name=$inp_assign_to_user_name_mysql,
									case_assigned_to_user_alias=$inp_assign_to_user_alias_mysql,
									case_assigned_to_user_email=$inp_assign_to_user_email_mysql,
									case_assigned_to_user_image_path=$inp_assign_to_user_image_path_mysql,
									case_assigned_to_user_image_file=$inp_assign_to_user_image_file_mysql,
									case_assigned_to_user_image_thumb_40=$inp_assign_to_user_image_thumb_a_mysql,
									case_assigned_to_user_image_thumb_50=$inp_assign_to_user_image_thumb_b_mysql,
									case_assigned_to_user_first_name=$inp_assign_to_user_first_name_mysql,
									case_assigned_to_user_middle_name=$inp_assign_to_user_middle_name_mysql,
									case_assigned_to_user_last_name=$inp_assign_to_user_last_name_mysql 
									 WHERE case_id=$get_case_id") or die(mysqli_error($link));

					echo"
					<div class=\"success\" style=\"margin: 10px 0px 10px 0px;\">$l_assigned to username $get_assign_to_user_name</div>
					";

						
			} // move to new person
			
		} // new status found
		
	} // case found

}

else{

	echo"Missing case_id or status_id";

}


?>