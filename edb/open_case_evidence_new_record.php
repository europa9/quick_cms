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
include("$root/_admin/_translations/site/$l/edb/ts_open_case_overview.php");
include("$root/_admin/_translations/site/$l/edb/ts_open_case_evidence_report_acquire_report.php");
include("$root/_admin/_translations/site/$l/users/ts_users.php");


/*- Tables ---------------------------------------------------------------------------- */
$t_edb_stats_index 			= $mysqlPrefixSav . "edb_stats_index";
$t_edb_stats_case_codes			= $mysqlPrefixSav . "edb_stats_case_codes";
$t_edb_stats_case_priorites		= $mysqlPrefixSav . "edb_stats_case_priorites";
$t_edb_stats_item_types 		= $mysqlPrefixSav . "edb_stats_item_types";
$t_edb_stats_statuses_per_day		= $mysqlPrefixSav . "edb_stats_statuses_per_day";
$t_edb_stats_employee_of_the_month	= $mysqlPrefixSav . "edb_stats_employee_of_the_month";
$t_edb_stats_acquirements_per_month	= $mysqlPrefixSav . "edb_stats_acquirements_per_month";

$t_edb_stats_requests_user_per_month			= $mysqlPrefixSav . "edb_stats_requests_user_per_month";
$t_edb_stats_requests_user_case_codes_per_month		= $mysqlPrefixSav . "edb_stats_requests_user_case_codes_per_month";
$t_edb_stats_requests_user_item_types_per_month		= $mysqlPrefixSav . "edb_stats_requests_user_item_types_per_month";
$t_edb_stats_requests_department_per_month		= $mysqlPrefixSav . "edb_stats_requests_department_per_month";
$t_edb_stats_requests_department_case_codes_per_month	= $mysqlPrefixSav . "edb_stats_requests_department_case_codes_per_month";
$t_edb_stats_requests_department_item_types_per_month	= $mysqlPrefixSav . "edb_stats_requests_department_item_types_per_month";

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
	$query = "SELECT case_id, case_number, case_title, case_title_clean, case_suspect_in_custody, case_code_id, case_code_number, case_code_title, case_status_id, case_status_title, case_priority_id, case_priority_title, case_district_id, case_district_title, case_station_id, case_station_title, case_is_screened, case_physical_location, case_backup_disks, case_confirmed_by_human, case_human_rejected, case_last_event_text, case_assigned_to_datetime, case_assigned_to_date, case_assigned_to_time, case_assigned_to_date_saying, case_assigned_to_date_ddmmyy, case_assigned_to_date_ddmmyyyy, case_assigned_to_user_id, case_assigned_to_user_name, case_assigned_to_user_alias, case_assigned_to_user_email, case_assigned_to_user_image_path, case_assigned_to_user_image_file, case_assigned_to_user_image_thumb_40, case_assigned_to_user_image_thumb_50, case_assigned_to_user_first_name, case_assigned_to_user_middle_name, case_assigned_to_user_last_name, case_created_datetime, case_created_date, case_created_time, case_created_date_saying, case_created_date_ddmmyy, case_created_date_ddmmyyyy, case_created_user_id, case_created_user_name, case_created_user_alias, case_created_user_email, case_created_user_image_path, case_created_user_image_file, case_created_user_image_thumb_40, case_created_user_image_thumb_50, case_created_user_first_name, case_created_user_middle_name, case_created_user_last_name, case_detective_user_id, case_detective_user_job_title, case_detective_user_department, case_detective_user_first_name, case_detective_user_middle_name, case_detective_user_last_name, case_detective_user_name, case_detective_user_alias, case_detective_user_email, case_detective_email_alerts, case_detective_user_image_path, case_detective_user_image_file, case_detective_user_image_thumb_40, case_detective_user_image_thumb_50, case_updated_datetime, case_updated_date, case_updated_time, case_updated_date_saying, case_updated_date_ddmmyy, case_updated_date_ddmmyyyy, case_updated_user_id, case_updated_user_name, case_updated_user_alias, case_updated_user_email, case_updated_user_image_path, case_updated_user_image_file, case_updated_user_image_thumb_40, case_updated_user_image_thumb_50, case_updated_user_first_name, case_updated_user_middle_name, case_updated_user_last_name, case_is_closed, case_closed_datetime, case_closed_date, case_closed_time, case_closed_date_saying, case_closed_date_ddmmyy, case_closed_date_ddmmyyyy, case_time_from_created_to_close FROM $t_edb_case_index WHERE case_id=$case_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_case_id, $get_current_case_number, $get_current_case_title, $get_current_case_title_clean, $get_current_case_suspect_in_custody, $get_current_case_code_id, $get_current_case_code_number, $get_current_case_code_title, $get_current_case_status_id, $get_current_case_status_title, $get_current_case_priority_id, $get_current_case_priority_title, $get_current_case_district_id, $get_current_case_district_title, $get_current_case_station_id, $get_current_case_station_title, $get_current_case_is_screened, $get_current_case_physical_location, $get_current_case_backup_disks, $get_current_case_confirmed_by_human, $get_current_case_human_rejected, $get_current_case_last_event_text, $get_current_case_assigned_to_datetime, $get_current_case_assigned_to_date, $get_current_case_assigned_to_time, $get_current_case_assigned_to_date_saying, $get_current_case_assigned_to_date_ddmmyy, $get_current_case_assigned_to_date_ddmmyyyy, $get_current_case_assigned_to_user_id, $get_current_case_assigned_to_user_name, $get_current_case_assigned_to_user_alias, $get_current_case_assigned_to_user_email, $get_current_case_assigned_to_user_image_path, $get_current_case_assigned_to_user_image_file, $get_current_case_assigned_to_user_image_thumb_40, $get_current_case_assigned_to_user_image_thumb_50, $get_current_case_assigned_to_user_first_name, $get_current_case_assigned_to_user_middle_name, $get_current_case_assigned_to_user_last_name, $get_current_case_created_datetime, $get_current_case_created_date, $get_current_case_created_time, $get_current_case_created_date_saying, $get_current_case_created_date_ddmmyy, $get_current_case_created_date_ddmmyyyy, $get_current_case_created_user_id, $get_current_case_created_user_name, $get_current_case_created_user_alias, $get_current_case_created_user_email, $get_current_case_created_user_image_path, $get_current_case_created_user_image_file, $get_current_case_created_user_image_thumb_40, $get_current_case_created_user_image_thumb_50, $get_current_case_created_user_first_name, $get_current_case_created_user_middle_name, $get_current_case_created_user_last_name, $get_current_case_detective_user_id, $get_current_case_detective_user_job_title, $get_current_case_detective_user_department, $get_current_case_detective_user_first_name, $get_current_case_detective_user_middle_name, $get_current_case_detective_user_last_name, $get_current_case_detective_user_name, $get_current_case_detective_user_alias, $get_current_case_detective_user_email, $get_current_case_detective_email_alerts, $get_current_case_detective_user_image_path, $get_current_case_detective_user_image_file, $get_current_case_detective_user_image_thumb_40, $get_current_case_detective_user_image_thumb_50, $get_current_case_updated_datetime, $get_current_case_updated_date, $get_current_case_updated_time, $get_current_case_updated_date_saying, $get_current_case_updated_date_ddmmyy, $get_current_case_updated_date_ddmmyyyy, $get_current_case_updated_user_id, $get_current_case_updated_user_name, $get_current_case_updated_user_alias, $get_current_case_updated_user_email, $get_current_case_updated_user_image_path, $get_current_case_updated_user_image_file, $get_current_case_updated_user_image_thumb_40, $get_current_case_updated_user_image_thumb_50, $get_current_case_updated_user_first_name, $get_current_case_updated_user_middle_name, $get_current_case_updated_user_last_name, $get_current_case_is_closed, $get_current_case_closed_datetime, $get_current_case_closed_date, $get_current_case_closed_time, $get_current_case_closed_date_saying, $get_current_case_closed_date_ddmmyy, $get_current_case_closed_date_ddmmyyyy, $get_current_case_time_from_created_to_close) = $row;
	

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
			<meta http-equiv=\"refresh\" content=\"3;url=districts.php?action=apply_for_membership_to_station&amp;station_id=$get_current_case_station_id&amp;l=$l\">
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
				// My user
				$inp_my_user_name_mysql = quote_smart($link, $get_my_station_member_user_name);

				$inp_seized_year = $_POST['inp_seized_year'];
				$inp_seized_year = output_html($inp_seized_year);
				$inp_seized_year_mysql = quote_smart($link, $inp_seized_year);

				$inp_seized_journal = $_POST['inp_seized_journal'];
				$inp_seized_journal = output_html($inp_seized_journal);
				$inp_seized_journal_mysql = quote_smart($link, $inp_seized_journal);

				$inp_seized_district_number = $_POST['inp_seized_district_number'];
				$inp_seized_district_number = output_html($inp_seized_district_number);
				$inp_seized_district_number_mysql = quote_smart($link, $inp_seized_district_number);

				// District ID
				$query = "SELECT district_id, district_title FROM $t_edb_districts_index WHERE district_number=$inp_seized_district_number_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_district_id, $get_district_title) = $row;

				$inp_seized_district_id_mysql = quote_smart($link, $get_district_id);
				$inp_seized_district_title_mysql = quote_smart($link, $get_district_title);

				$inp_items = $_POST['inp_items'];
				$inp_items = output_html($inp_items);
	
				$inp_request_text = $_POST['inp_request_text'];
				$inp_request_text = output_html($inp_request_text);
				$inp_request_text_mysql = quote_smart($link, $inp_request_text);

				$inp_requester_user_name = $_POST['inp_requester_user_name'];
				$inp_requester_user_name = output_html($inp_requester_user_name);
				$inp_requester_user_name_mysql = quote_smart($link, $inp_requester_user_name);
				
				// Requester user
				$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_name=$inp_requester_user_name_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_requester_user_id, $get_requester_user_email, $get_requester_user_name, $get_requester_user_alias, $get_requester_user_language, $get_requester_user_last_online, $get_requester_user_rank, $get_requester_user_login_tries) = $row;

				if($get_requester_user_id == ""){
					$get_requester_user_id = 0;
					$inp_requester_user_image_path = "";
					$get_requester_photo_destination = "";
					$get_requester_photo_thumb_40 = "";
					$get_requester_photo_thumb_50 = "";
					$get_requester_profile_first_name = "";
					$get_requester_profile_middle_name = "";
					$get_requester_profile_last_name = "";
					$get_requester_professional_position = "";
					$get_requester_professional_department = "";
				}
				else{
					// Requester photo
					$query = "SELECT photo_id, photo_destination, photo_thumb_40, photo_thumb_50 FROM $t_users_profile_photo WHERE photo_user_id=$get_requester_user_id AND photo_profile_image='1'";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_requester_photo_id, $get_requester_photo_destination, $get_requester_photo_thumb_40, $get_requester_photo_thumb_50) = $row;

					// Requester Profile
					$query = "SELECT profile_id, profile_first_name, profile_middle_name, profile_last_name, profile_about FROM $t_users_profile WHERE profile_user_id=$get_requester_user_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_requester_profile_id, $get_requester_profile_first_name, $get_requester_profile_middle_name, $get_requester_profile_last_name, $get_requester_profile_about) = $row;

					// Requester professional
					$query = "SELECT professional_id, professional_user_id, professional_company, professional_company_location, professional_department, professional_work_email, professional_position FROM $t_users_professional WHERE professional_user_id=$get_requester_user_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_requester_professional_id, $get_requester_professional_user_id, $get_requester_professional_company, $get_requester_professional_company_location, $get_requester_professional_department, $get_requester_professional_work_email, $get_requester_professional_position) = $row;
				}
			
				$inp_requester_user_name_mysql = quote_smart($link, $get_requester_user_name);
				$inp_requester_user_alias_mysql = quote_smart($link, $get_requester_user_alias);
				$inp_requester_user_email_mysql = quote_smart($link, $get_requester_user_email);

				$inp_requester_user_image_path = "_uploads/users/images/$get_requester_user_id";
				$inp_requester_user_image_path_mysql = quote_smart($link, $inp_requester_user_image_path);
	
				$inp_requester_user_image_file_mysql = quote_smart($link, $get_requester_photo_destination);

				$inp_requester_user_image_thumb_a_mysql = quote_smart($link, $get_requester_photo_thumb_40);
				$inp_requester_user_image_thumb_b_mysql = quote_smart($link, $get_requester_photo_thumb_50);

				$inp_requester_user_first_name_mysql = quote_smart($link, $get_requester_profile_first_name);
				$inp_requester_user_middle_name_mysql = quote_smart($link, $get_requester_profile_middle_name);
				$inp_requester_user_last_name_mysql = quote_smart($link, $get_requester_profile_last_name);
			
				$inp_requester_user_job_title_mysql = quote_smart($link, $get_requester_professional_position);
				$inp_requester_user_department_mysql = quote_smart($link, $get_requester_professional_department);
				$inp_requester_professional_company_location_mysql = quote_smart($link, $get_requester_professional_company_location);

				// Dates
				$datetime = date("Y-m-d H:i:s");
				$date = date("Y-m-d");
				$time = time();
				$date_saying = date("j M Y");
				$date_ddmmyy = date("d.m.y");
				$date_ddmmyyyy = date("d.m.Y");
				$date_yyyy = date("Y");
				$date_mm = date("m");

				// Insert
				mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_records
				(record_id, record_case_id, record_seized_year, record_seized_journal, record_seized_district_id, 
				record_seized_district_number, record_seized_district_title, record_confirmed_by_human, record_human_rejected, record_notes, record_created_datetime, 
				record_created_date, record_created_time, record_created_date_saying, record_created_date_ddmmyy, record_created_date_ddmmyyyy) 
				VALUES 
				(NULL, $get_current_case_id, $inp_seized_year_mysql, $inp_seized_journal_mysql, $inp_seized_district_id_mysql, 
				$inp_seized_district_number_mysql, $inp_seized_district_title_mysql, 1, 0, '', '$datetime',
				'$date', '$time', '$date_saying', '$date_ddmmyy', '$date_ddmmyyyy')")
				or die(mysqli_error($link));

				// Get ID
				$query = "SELECT record_id FROM $t_edb_case_index_evidence_records WHERE record_case_id=$get_current_case_id AND record_created_datetime='$datetime'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_record_id) = $row;


				// Create evidence_items
				$count_number_of_items = 0;
				// Look for -
				if(strstr($inp_items, '-')){
					// - exists
					$items_array_series = explode("-", $inp_items);
					$items_array_series_size = sizeof($items_array_series);
				
					$start_number = $items_array_series[0];
					$stop_number = $items_array_series[1]+1;

					for($x=$start_number;$x<$stop_number;$x++){
						// Insert series
						$inp_numeric_serial_number = $x;
						$inp_numeric_serial_number_mysql = quote_smart($link, $inp_numeric_serial_number);
				
						mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_items
						(item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_parent_item_id,
						item_request_text, 
						item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, 
						item_requester_user_id, item_requester_user_name, item_requester_user_alias, 
						item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department,
						item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_date_ddmmyyyy, item_acquired_user_id, item_acquired_user_name) 
						VALUES 
						(NULL, $get_current_case_id, $get_record_id, $inp_seized_year_mysql, $inp_seized_journal_mysql, $inp_seized_district_number_mysql, $inp_numeric_serial_number_mysql, 0,
						$inp_request_text_mysql, 
						'$datetime', '$date', '$time', '$date_saying', '$date_ddmmyy',
						$get_requester_user_id, $inp_requester_user_name_mysql, $inp_requester_user_alias_mysql, 
						$inp_requester_user_email_mysql, $inp_requester_user_image_path_mysql, $inp_requester_user_image_file_mysql, $inp_requester_user_image_thumb_a_mysql, 
						$inp_requester_user_image_thumb_b_mysql, $inp_requester_user_first_name_mysql, $inp_requester_user_middle_name_mysql, $inp_requester_user_last_name_mysql, $inp_requester_user_job_title_mysql, 
						$inp_requester_user_department_mysql,
						'$date', '$time', '$date_saying', '$date_ddmmyy', '$date_ddmmyyyy', $my_user_id_mysql , $inp_my_user_name_mysql)")
						or die(mysqli_error($link));

						$count_number_of_items++;
					}
				} // series (1-5)
				else{
					// Look for ,
					if(strstr($inp_items, ',')){
						$items_array = explode(",", $inp_items);
						$items_array_size = sizeof($items_array);

						for($x=0;$x<$items_array_size;$x++){
							// Insert series
							$inp_numeric_serial_number = $items_array[$x];
							$inp_numeric_serial_number_mysql = quote_smart($link, $inp_numeric_serial_number);
					

							mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_items
							(item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_parent_item_id,
							item_request_text, 
							item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, 
							item_requester_user_id, item_requester_user_name, item_requester_user_alias, 
							item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department,
							item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_date_ddmmyyyy, item_acquired_user_id, item_acquired_user_name)  
							VALUES 
							(NULL, $get_current_case_id, $get_record_id, $inp_seized_year_mysql, $inp_seized_journal_mysql, $inp_seized_district_number_mysql, $inp_numeric_serial_number_mysql, 0,
							$inp_request_text_mysql, 
							'$datetime', '$date', '$time', '$date_saying', '$date_ddmmyy', 
							 $get_requester_user_id, $inp_requester_user_name_mysql, $inp_requester_user_alias_mysql, 
							$inp_requester_user_email_mysql, $inp_requester_user_image_path_mysql, $inp_requester_user_image_file_mysql, $inp_requester_user_image_thumb_a_mysql, 
							$inp_requester_user_image_thumb_b_mysql, $inp_requester_user_first_name_mysql, $inp_requester_user_middle_name_mysql, $inp_requester_user_last_name_mysql, $inp_requester_user_job_title_mysql, 
							$inp_requester_user_department_mysql,
							'$date', '$time', '$date_saying', '$date_ddmmyy', '$date_ddmmyyyy', $my_user_id_mysql , $inp_my_user_name_mysql)")
							or die(mysqli_error($link));

							$count_number_of_items++;
						}
				
					}
					else{
						// Insert series
						$inp_numeric_serial_number = $inp_items;
						$inp_numeric_serial_number_mysql = quote_smart($link, $inp_numeric_serial_number);
					
				
						mysqli_query($link, "INSERT INTO $t_edb_case_index_evidence_items
						(item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, 
						item_record_seized_district_number, item_numeric_serial_number, item_parent_item_id, item_request_text, item_in_datetime, 

						item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_requester_user_id, 
						item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, 
						item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, 
						item_requester_user_job_title, item_requester_user_department,
						item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_date_ddmmyyyy, item_acquired_user_id, item_acquired_user_name) 
						VALUES 
						(NULL, $get_current_case_id, $get_record_id, $inp_seized_year_mysql, $inp_seized_journal_mysql, 
						$inp_seized_district_number_mysql, $inp_numeric_serial_number_mysql, 0, $inp_request_text_mysql, '$datetime', 

						'$date', '$time', '$date_saying', '$date_ddmmyy',
						$get_requester_user_id, $inp_requester_user_name_mysql, $inp_requester_user_alias_mysql, 
						$inp_requester_user_email_mysql, $inp_requester_user_image_path_mysql, $inp_requester_user_image_file_mysql, $inp_requester_user_image_thumb_a_mysql, 
						$inp_requester_user_image_thumb_b_mysql, $inp_requester_user_first_name_mysql, $inp_requester_user_middle_name_mysql, $inp_requester_user_last_name_mysql, $inp_requester_user_job_title_mysql, 
						$inp_requester_user_department_mysql,
						'$date', '$time', '$date_saying', '$date_ddmmyy', '$date_ddmmyyyy', $my_user_id_mysql , $inp_my_user_name_mysql)")
						or die(mysqli_error($link));

						$count_number_of_items++;
					} // single
				} // double (1,5)


				// Number of acquirements_per_month :: District
				$inp_district_title_mysql = quote_smart($link, $get_current_case_district_title);
				$query = "SELECT acquirements_per_month_id, acquirements_per_month_year, acquirements_per_month_month, acquirements_per_month_counter, acquirements_per_month_district_id, acquirements_per_month_district_title, acquirements_per_month_station_id, acquirements_per_month_station_title, acquirements_per_month_user_id, acquirements_per_month_user_name, acquirements_per_month_size_bytes, acquirements_per_month_size_human FROM $t_edb_stats_acquirements_per_month WHERE acquirements_per_month_year=$date_yyyy AND acquirements_per_month_month=$date_mm AND acquirements_per_month_district_id=$get_current_case_district_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_acquirements_per_month_id, $get_acquirements_per_month_year, $get_acquirements_per_month_month, $get_acquirements_per_month_counter, $get_acquirements_per_month_district_id, $get_acquirements_per_month_district_title, $get_acquirements_per_month_station_id, $get_acquirements_per_month_station_title, $get_acquirements_per_month_user_id, $get_acquirements_per_month_user_name, $get_acquirements_per_month_size_bytes, $get_acquirements_per_month_size_human) = $row;
				if($get_acquirements_per_month_id == ""){

				
					mysqli_query($link, "INSERT INTO $t_edb_stats_acquirements_per_month 
					(acquirements_per_month_id, acquirements_per_month_year, acquirements_per_month_month, acquirements_per_month_counter, acquirements_per_month_district_id, acquirements_per_month_district_title, acquirements_per_month_station_id, acquirements_per_month_station_title, acquirements_per_month_user_id, acquirements_per_month_user_name) 
					VALUES 
					(NULL, $date_yyyy, $date_mm, $count_number_of_items, $get_current_case_district_id, $inp_district_title_mysql, NULL, NULL, NULL, NULL)")
					or die(mysqli_error($link));
				}
				else{
					$inp_counter = $get_acquirements_per_month_counter+$count_number_of_items;
					$result = mysqli_query($link, "UPDATE $t_edb_stats_acquirements_per_month SET acquirements_per_month_counter=$inp_counter WHERE acquirements_per_month_id=$get_acquirements_per_month_id") or die(mysqli_error($link));

				}



				// Number of acquirements_per_month :: Station
				$inp_station_title_mysql = quote_smart($link, $get_current_case_station_title);
				$query = "SELECT acquirements_per_month_id, acquirements_per_month_year, acquirements_per_month_month, acquirements_per_month_counter, acquirements_per_month_district_id, acquirements_per_month_district_title, acquirements_per_month_station_id, acquirements_per_month_station_title, acquirements_per_month_user_id, acquirements_per_month_user_name, acquirements_per_month_size_bytes, acquirements_per_month_size_human FROM $t_edb_stats_acquirements_per_month WHERE acquirements_per_month_year=$date_yyyy AND acquirements_per_month_month=$date_mm AND acquirements_per_month_station_id=$get_current_case_station_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_acquirements_per_month_id, $get_acquirements_per_month_year, $get_acquirements_per_month_month, $get_acquirements_per_month_counter, $get_acquirements_per_month_district_id, $get_acquirements_per_month_district_title, $get_acquirements_per_month_station_id, $get_acquirements_per_month_station_title, $get_acquirements_per_month_user_id, $get_acquirements_per_month_user_name, $get_acquirements_per_month_size_bytes, $get_acquirements_per_month_size_human) = $row;
				if($get_acquirements_per_month_id == ""){
					mysqli_query($link, "INSERT INTO $t_edb_stats_acquirements_per_month 
					(acquirements_per_month_id, acquirements_per_month_year, acquirements_per_month_month, acquirements_per_month_counter, acquirements_per_month_district_id, acquirements_per_month_district_title, acquirements_per_month_station_id, acquirements_per_month_station_title, acquirements_per_month_user_id, acquirements_per_month_user_name) 
					VALUES 
					(NULL, $date_yyyy, $date_mm, $count_number_of_items, NULL, NULL, $get_current_case_station_id,$inp_station_title_mysql , NULL, NULL)")
					or die(mysqli_error($link));
				}
				else{
					$inp_counter = $get_acquirements_per_month_counter+$count_number_of_items;
					$result = mysqli_query($link, "UPDATE $t_edb_stats_acquirements_per_month SET acquirements_per_month_counter=$inp_counter WHERE acquirements_per_month_id=$get_acquirements_per_month_id") or die(mysqli_error($link));

				}

				// Number of acquirements_per_month :: User
				$inp_user_name_mysql = quote_smart($link, $get_my_station_member_user_name);
				$query = "SELECT acquirements_per_month_id, acquirements_per_month_year, acquirements_per_month_month, acquirements_per_month_counter, acquirements_per_month_district_id, acquirements_per_month_district_title, acquirements_per_month_station_id, acquirements_per_month_station_title, acquirements_per_month_user_id, acquirements_per_month_user_name, acquirements_per_month_size_bytes, acquirements_per_month_size_human FROM $t_edb_stats_acquirements_per_month WHERE acquirements_per_month_year=$date_yyyy AND acquirements_per_month_month=$date_mm AND acquirements_per_month_user_id=$get_my_station_member_user_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_acquirements_per_month_id, $get_acquirements_per_month_year, $get_acquirements_per_month_month, $get_acquirements_per_month_counter, $get_acquirements_per_month_district_id, $get_acquirements_per_month_district_title, $get_acquirements_per_month_station_id, $get_acquirements_per_month_station_title, $get_acquirements_per_month_user_id, $get_acquirements_per_month_user_name, $get_acquirements_per_month_size_bytes, $get_acquirements_per_month_size_human) = $row;
				if($get_acquirements_per_month_id == ""){
					mysqli_query($link, "INSERT INTO $t_edb_stats_acquirements_per_month 
					(acquirements_per_month_id, acquirements_per_month_year, acquirements_per_month_month, acquirements_per_month_counter, acquirements_per_month_district_id, acquirements_per_month_district_title, acquirements_per_month_station_id, acquirements_per_month_station_title, acquirements_per_month_user_id, acquirements_per_month_user_name) 
					VALUES 
					(NULL, $date_yyyy, $date_mm, $count_number_of_items, NULL, NULL, NULL, NULL, $get_my_station_member_user_id, $inp_user_name_mysql)")
					or die(mysqli_error($link));
				}
				else{
					$inp_counter = $get_acquirements_per_month_counter+$count_number_of_items;
					$result = mysqli_query($link, "UPDATE $t_edb_stats_acquirements_per_month SET acquirements_per_month_counter=$inp_counter WHERE acquirements_per_month_id=$get_acquirements_per_month_id") or die(mysqli_error($link));

				}

				// REQUESTS START

				// Number of requests per month: User
				$query = "SELECT stats_req_usr_id, stats_req_usr_counter FROM $t_edb_stats_requests_user_per_month WHERE stats_req_usr_year=$date_yyyy AND stats_req_usr_month=$date_mm AND stats_req_usr_user_id=$get_requester_user_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_stats_req_usr_id, $get_stats_req_usr_counter) = $row;
				if($get_stats_req_usr_id == ""){
					mysqli_query($link, "INSERT INTO $t_edb_stats_requests_user_per_month 
					(stats_req_usr_id, stats_req_usr_year, stats_req_usr_month, stats_req_usr_district_id, stats_req_usr_station_id, stats_req_usr_user_id, stats_req_usr_user_name, stats_req_usr_user_alias, stats_req_usr_user_first_name, stats_req_usr_user_middle_name, stats_req_usr_user_last_name, stats_req_usr_user_position, stats_req_usr_user_department, stats_req_usr_user_location, stats_req_usr_counter) 
					VALUES 
					(NULL, $date_yyyy, $date_mm, $get_current_case_district_id, $get_current_case_station_id, $get_requester_user_id, $inp_requester_user_name_mysql, $inp_requester_user_alias_mysql, $inp_requester_user_first_name_mysql, $inp_requester_user_middle_name_mysql, $inp_requester_user_last_name_mysql, $inp_requester_user_job_title_mysql, $inp_requester_user_department_mysql, $inp_requester_professional_company_location_mysql, $count_number_of_items)")
					or die(mysqli_error($link));
				}
				else{
					$inp_counter = $get_stats_req_usr_counter+$count_number_of_items;
					$result = mysqli_query($link, "UPDATE $t_edb_stats_requests_user_per_month SET stats_req_usr_counter=$inp_counter WHERE stats_req_usr_id=$get_stats_req_usr_id") or die(mysqli_error($link));

				}

				// Number of requests per month: Department
				$query = "SELECT stats_req_dep_id, stats_req_dep_counter FROM $t_edb_stats_requests_department_per_month WHERE stats_req_dep_year=$date_yyyy AND stats_req_dep_month=$date_mm AND stats_req_dep_department=$inp_requester_user_department_mysql AND stats_req_dep_location=$inp_requester_professional_company_location_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_stats_req_dep_id, $get_stats_req_dep_counter) = $row;
				if($get_stats_req_dep_id == ""){
					mysqli_query($link, "INSERT INTO $t_edb_stats_requests_department_per_month 
					(stats_req_dep_id, stats_req_dep_year, stats_req_dep_month, stats_req_dep_district_id, stats_req_dep_station_id, stats_req_dep_department, stats_req_dep_location, stats_req_dep_counter) 
					VALUES 
					(NULL, $date_yyyy, $date_mm, $get_current_case_district_id, $get_current_case_station_id, $inp_requester_user_department_mysql, $inp_requester_professional_company_location_mysql, $count_number_of_items)")
					or die(mysqli_error($link));
				}
				else{
					$inp_counter = $get_stats_req_dep_counter+$count_number_of_items;
					$result = mysqli_query($link, "UPDATE $t_edb_stats_requests_department_per_month SET stats_req_dep_counter=$inp_counter WHERE stats_req_dep_id=$get_stats_req_dep_id") or die(mysqli_error($link));

				}

				// Number of requests per month: Users Case Codes
				$inp_case_code_title_mysql = quote_smart($link, $get_current_case_code_title);
				if($get_current_case_code_id != ""){
					$query = "SELECT stats_usr_case_code_id, stats_usr_case_code_counter FROM $t_edb_stats_requests_user_case_codes_per_month WHERE stats_usr_case_code_year=$date_yyyy AND stats_usr_case_code_month=$date_mm AND stats_usr_case_code_user_id=$get_requester_user_id AND stats_usr_case_code_case_code_id=$get_current_case_code_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_stats_usr_case_code_id, $get_stats_usr_case_code_counter) = $row;
					if($get_stats_usr_case_code_id == ""){
						mysqli_query($link, "INSERT INTO $t_edb_stats_requests_user_case_codes_per_month 
						(stats_usr_case_code_id, stats_usr_case_code_year, stats_usr_case_code_month, stats_usr_case_code_district_id, stats_usr_case_code_station_id, stats_usr_case_code_user_id, stats_usr_case_code_case_code_id, stats_usr_case_code_case_code_number, stats_usr_case_code_case_code_title, stats_usr_case_code_counter) 
						VALUES 
						(NULL, $date_yyyy, $date_mm, $get_current_case_district_id, $get_current_case_station_id, $get_requester_user_id,  $get_current_case_code_id, $get_current_case_code_number, $inp_case_code_title_mysql, $count_number_of_items)")
						or die(mysqli_error($link));
					}
					else{
						$inp_counter = $get_stats_usr_case_code_counter+$count_number_of_items;
						$result = mysqli_query($link, "UPDATE $t_edb_stats_requests_user_case_codes_per_month SET stats_usr_case_code_counter=$inp_counter WHERE stats_usr_case_code_id=$get_stats_usr_case_code_id") or die(mysqli_error($link));

					}
				} // case code not null

				// Number of requests per month: Department Case Codes 
				if($get_current_case_code_id != ""){
					$inp_case_code_title_mysql = quote_smart($link, $get_current_case_code_title);
					$query = "SELECT stats_dep_case_code_id, stats_dep_case_code_counter FROM $t_edb_stats_requests_department_case_codes_per_month WHERE stats_dep_case_code_year=$date_yyyy AND stats_dep_case_code_month=$date_mm AND stats_dep_case_code_department=$inp_requester_user_department_mysql AND stats_dep_case_code_location=$inp_requester_professional_company_location_mysql AND stats_dep_case_code_case_code_id=$get_current_case_code_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_stats_dep_case_code_id, $get_stats_dep_case_code_counter) = $row;
					if($get_stats_dep_case_code_id == ""){
						mysqli_query($link, "INSERT INTO $t_edb_stats_requests_department_case_codes_per_month 
						(stats_dep_case_code_id, stats_dep_case_code_year, stats_dep_case_code_month, stats_dep_case_code_district_id, stats_dep_case_code_station_id, stats_dep_case_code_department, stats_dep_case_code_location, stats_dep_case_code_case_code_id, stats_dep_case_code_case_code_number, stats_dep_case_code_case_code_title, stats_dep_case_code_counter) 
						VALUES 
						(NULL, $date_yyyy, $date_mm, $get_current_case_district_id, $get_current_case_station_id, $inp_requester_user_department_mysql, $inp_requester_professional_company_location_mysql, $get_current_case_code_id, $get_current_case_code_number, $inp_case_code_title_mysql, $count_number_of_items)")
						or die(mysqli_error($link));
					}
					else{
						$inp_counter = $get_stats_dep_case_code_counter+$count_number_of_items;
						$result = mysqli_query($link, "UPDATE $t_edb_stats_requests_department_case_codes_per_month SET stats_dep_case_code_counter=$inp_counter WHERE stats_dep_case_code_id=$get_stats_dep_case_code_id") or die(mysqli_error($link));
					}
				} // case code not null




				// Number of requests per month: Users Item types
				// We dont know the item type at this point




				$url = "open_case_evidence.php?case_id=$get_current_case_id&l=$l&ft=success&fm=record_created_with_id_" . $get_record_id;
				header("Location: $url");
				exit;
			}
			echo"
			<h2>$l_new_record</h2>


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
				\$('[name=\"inp_seized_year\"]').focus();
			});
			</script>
			<!-- //Focus -->
		
			<!-- New evidence record -->

			<form method=\"POST\" action=\"open_case_evidence_new_record.php?case_id=$get_current_case_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<table>
			 <tr>
			  <td style=\"padding-right: 4px;text-align:center;\">
				<p><b>$l_year</b><br />";
				$inp_year = date("Y");
				echo"
				<input type=\"text\" name=\"inp_seized_year\" value=\"$inp_year\" size=\"4\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" style=\"text-align:center;border: #fff 1px solid;border-bottom: #ccc 1px dashed;\" />
				</p>
			  </td>
			  <td style=\"padding-right: 4px;text-align:center;vertical-align:top;\">
				<p><b>/</b></p>
			  </td>
			  <td style=\"padding-right: 4px;text-align:center;\">
				<p><b>$l_journal</b><br />
				<input type=\"text\" name=\"inp_seized_journal\" value=\"\" size=\"6\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" style=\"text-align:center;border: #fff 1px solid;border-bottom: #ccc 1px dashed;\" />
				</p>
			  </td>
			  <td style=\"padding-right: 4px;text-align:center;vertical-align:top;\">
				<p><b>-</b></p>
			  </td>
			  <td style=\"padding-right: 4px;text-align:center;\">
				<p><b>$l_district</b><br />";
				$query = "SELECT district_id, district_number FROM $t_edb_districts_index WHERE district_id=$get_current_case_district_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_district_id, $get_current_district_number) = $row;
	
				echo"
				<input type=\"text\" name=\"inp_seized_district_number\" value=\"$get_current_district_number\" size=\"6\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" style=\"text-align:center;border: #fff 1px solid;border-bottom: #ccc 1px dashed;\" />
				</p>
			  </td>
			 </tr>
			</table>

			<p><b>$l_evidence_items:</b><br />
			<input type=\"text\" name=\"inp_items\" id=\"inp_items\" value=\"\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" style=\"width: 100%;\" /><br />
			<span id=\"inp_items_info\" class=\"small\" style=\"display: none;\">$l_example_one_to_five_creates_evidence_one_two_three_four_five<br />
			$l_example_one_three_creates_evidence_one_and_three</span>
			</p>
			<!-- Open close evidence items info --> 
				<script>
				  \$(document).ready(function(){
				    \$(\"#inp_items\").focus(function () {
				      \$(\"#inp_items_info\").toggle();
				    });
				    \$(\"#inp_items\").focusout(function () {
				      \$(\"#inp_items_info\").toggle();
				    });
				  });
				</script>
			<!-- //Open close evidence items info --> 



			<p><b>$l_request_text:</b><br />
			";
			$date_print = date("j M Y");
			// Pick random requester
			$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_timezone, item_date_now_date, item_date_now_ddmmyy, item_time_now, item_correct_date_now_date, item_correct_date_now_ddmmyy, item_correct_time_now, item_adjust_clock_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy FROM $t_edb_case_index_evidence_items ORDER BY item_id DESC LIMIT 0,1";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_prev_item_id, $get_prev_item_case_id, $get_prev_item_record_id, $get_prev_item_record_seized_year, $get_prev_item_record_seized_journal, $get_prev_item_record_seized_district_number, $get_prev_item_numeric_serial_number, $get_prev_item_title, $get_prev_item_type_id, $get_prev_item_type_title, $get_prev_item_confirmed_by_human, $get_prev_item_human_rejected, $get_prev_item_request_text, $get_prev_item_requester_user_id, $get_prev_item_requester_user_name, $get_prev_item_requester_user_alias, $get_prev_item_requester_user_email, $get_prev_item_requester_user_image_path, $get_prev_item_requester_user_image_file, $get_prev_item_requester_user_image_thumb_40, $get_prev_item_requester_user_image_thumb_50, $get_prev_item_requester_user_first_name, $get_prev_item_requester_user_middle_name, $get_prev_item_requester_user_last_name, $get_prev_item_requester_user_job_title, $get_prev_item_requester_user_department, $get_prev_item_in_datetime, $get_prev_item_in_date, $get_prev_item_in_time, $get_prev_item_in_date_saying, $get_prev_item_in_date_ddmmyy, $get_prev_item_comment, $get_prev_item_condition, $get_prev_item_serial_number, $get_prev_item_imei_a, $get_prev_item_imei_b, $get_prev_item_imei_c, $get_prev_item_imei_d, $get_prev_item_os_title, $get_prev_item_os_version, $get_prev_item_timezone, $get_prev_item_date_now_date, $get_prev_item_date_now_ddmmyy, $get_prev_item_time_now, $get_prev_item_correct_date_now_date, $get_prev_item_correct_date_now_ddmmyy, $get_prev_item_correct_time_now, $get_prev_item_adjust_clock_automatically, $get_prev_item_acquired_software_id_a, $get_prev_item_acquired_software_title_a, $get_prev_item_acquired_software_notes_a, $get_prev_item_acquired_software_id_b, $get_prev_item_acquired_software_title_b, $get_prev_item_acquired_software_notes_b, $get_prev_item_acquired_software_id_c, $get_prev_item_acquired_software_title_c, $get_prev_item_acquired_software_notes_c, $get_prev_item_acquired_date, $get_prev_item_acquired_time, $get_prev_item_acquired_date_saying, $get_prev_item_acquired_date_ddmmyy, $get_prev_item_acquired_user_id, $get_prev_item_acquired_user_name, $get_prev_item_acquired_user_alias, $get_prev_item_acquired_user_email, $get_prev_item_acquired_user_image_path, $get_prev_item_acquired_user_image_file, $get_prev_item_acquired_user_image_thumb_40, $get_prev_item_acquired_user_image_thumb_50, $get_prev_item_acquired_user_first_name, $get_prev_item_acquired_user_middle_name, $get_prev_item_acquired_user_last_name, $get_prev_item_out_date, $get_prev_item_out_time, $get_prev_item_out_date_saying, $get_prev_item_out_date_ddmmyy) = $row;
	
			echo"<span class=\"smal\">
			$l_in_request_for_laboratory_examination_the $date_print, 
			$l_i_was_requested_by_lowercase 
			$get_prev_item_requester_user_job_title $get_prev_item_requester_user_first_name $get_prev_item_requester_user_middle_name 
			$get_prev_item_requester_user_last_name $l_from_department_lowercase $get_prev_item_requester_user_department
			$l_to_lowercase 
			<textarea name=\"inp_request_text\" rows=\"5\" cols=\"80\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" style=\"width: 100%;\">$l_special_default_request_text</textarea>
			</p>


			<p><b>$l_requester_user_name 
			<span class=\"smal\">(<a href=\"open_case_evidence_new_requester.php?case_id=$get_current_case_id&amp;l=$l\" target=\"_blank\" class=\"smal\">$l_new_requester</a>
			&middot;
			<a href=\"$root/_admin/index.php?open=users&amp;editor_language=$l&amp;l=$l\" target=\"_blank\" class=\"smal\">$l_edit_users</a>)</span>:</b><br />
			<input type=\"text\" name=\"inp_requester_user_name\" id=\"autosearch_inp_search_for_requester\" value=\"\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" style=\"width: 100%;\" />
			</p>

			<div class=\"open_requester_results\">
			</div>

			<!-- Responsible Autocomplete -->
				<script>
				\$(document).ready(function () {
					\$('#autosearch_inp_search_for_requester').keyup(function () {
       						// getting the value that user typed
       						var searchString    = $(\"#autosearch_inp_search_for_requester\").val();
 						// forming the queryString
      						var data            = 'l=$l&q=' + searchString;
         
        					// if searchString is not empty
        					if(searchString) {
           						// ajax call
            						\$.ajax({
                						type: \"GET\",
               							url: \"open_case_evidence_new_record_requester_jquery_search.php\",
                						data: data,
								beforeSend: function(html) { // this happens before actual call
									\$(\".open_requester_results\").html(''); 
								},
               							success: function(html){
                    							\$(\".open_requester_results\").append(html);
              							}
            						});
       						}
        					return false;
            				});
         				 });
				</script>
			<!-- //Responsible Autocomplete -->

			<p>
			<input type=\"submit\" value=\"$l_create_record\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
			</p>
			<!-- //New evidence record -->
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