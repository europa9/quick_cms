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
include("$root/_admin/_translations/site/$l/users/ts_users.php");


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
			if($process == "1"){
				if(isset($_POST['inp_submit_with_selected'])){
					$inp_submit_with_selected = $_POST['inp_submit_with_selected'];
				

					// What checkboxes (items) did we check?
					$items_selected = "";
					$query = "SELECT item_id FROM $t_edb_case_index_evidence_items WHERE item_case_id=$get_current_case_id ORDER BY item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_item_id) = $row;

						if(isset($_POST["inp_checkbox_item_$get_item_id"])){

							if($items_selected == ""){
								$items_selected = "$get_item_id";
							}
							else{
								$items_selected = $items_selected . ",$get_item_id";
							}
						}
					}


					$url = "open_case_evidence_select_many.php?case_id=$get_current_case_id&items_selected=$items_selected&l=$l";
					header("Location: $url");
					exit;
					

				} // do something with many

				// Ready months
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

				// Ready dates
				$year = date("Y");
				$month = date("m");

				// Loop trough items and save all fields
				$query_loop = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_storage_shelf_id, item_storage_shelf_title, item_storage_location_id, item_storage_location_abbr, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_timezone, item_date_now_date, item_time_now, item_correct_date_now_date, item_correct_time_now, item_adjust_clock_automatically, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy FROM $t_edb_case_index_evidence_items WHERE item_case_id=$get_current_case_id ORDER BY item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number ASC";
				$result_loop = mysqli_query($link, $query_loop);
				while($row_loop = mysqli_fetch_row($result_loop)) {
					list($get_item_id, $get_item_case_id, $get_item_record_id, $get_item_record_seized_year, $get_item_record_seized_journal, $get_item_record_seized_district_number, $get_item_numeric_serial_number, $get_item_title, $get_item_type_id, $get_item_type_title, $get_item_request_text, $get_item_requester_user_id, $get_item_requester_user_name, $get_item_requester_user_alias, $get_item_requester_user_email, $get_item_requester_user_image_path, $get_item_requester_user_image_file, $get_item_requester_user_image_thumb_40, $get_item_requester_user_image_thumb_50, $get_item_requester_user_first_name, $get_item_requester_user_middle_name, $get_item_requester_user_last_name, $get_item_requester_user_job_title, $get_item_requester_user_department, $get_item_in_datetime, $get_item_in_time, $get_item_in_date_saying, $get_item_in_date_ddmmyy, $get_item_storage_shelf_id, $get_item_storage_shelf_title, $get_item_storage_location_id, $get_item_storage_location_abbr, $get_item_comment, $get_item_condition, $get_item_serial_number, $get_item_imei_a, $get_item_imei_b, $get_item_imei_c, $get_item_imei_d, $get_item_timezone, $get_item_date_now, $get_item_time_now, $get_item_correct_date_now, $get_item_correct_time_now, $get_item_adjust_clock_automatically, $get_item_acquired_date, $get_item_acquired_time, $get_item_acquired_date_saying, $get_item_acquired_date_ddmmyy, $get_item_acquired_user_id, $get_item_acquired_user_name, $get_item_acquired_user_alias, $get_item_acquired_user_email, $get_item_acquired_user_image_path, $get_item_acquired_user_image_file, $get_item_acquired_user_image_thumb_40, $get_item_acquired_user_image_thumb_50, $get_item_acquired_user_first_name, $get_item_acquired_user_middle_name, $get_item_acquired_user_last_name, $get_item_out_date, $get_item_out_time, $get_item_out_date_saying, $get_item_out_date_ddmmyy) = $row_loop;


					$inp_item_title = $_POST["inp_item_title_$get_item_id"];
					$inp_item_title = output_html($inp_item_title);
					$inp_item_title_mysql = quote_smart($link, $inp_item_title);

					$inp_item_type_id = $_POST["inp_item_type_id_$get_item_id"];
					$inp_item_type_id = output_html($inp_item_type_id);
					$inp_item_type_id_mysql = quote_smart($link, $inp_item_type_id);
					if($inp_item_type_id == "0"){
						$get_types_item_type_id = "0";
						$get_types_item_type_title = "";
					}
					else{
						$query_i = "SELECT item_type_id, item_type_title FROM $t_edb_item_types WHERE item_type_id=$inp_item_type_id_mysql";
						$result_i = mysqli_query($link, $query_i);
						$row_i = mysqli_fetch_row($result_i);
						list($get_types_item_type_id, $get_types_item_type_title) = $row_i;
					}
					$inp_item_type_title_mysql = quote_smart($link, $get_types_item_type_title);
					
					// Is the item type the same as before? If it is not, then we need to adjust statistics
					if($get_item_type_id != "$inp_item_type_id"){

						// Item Type Stats: District
						$query_st = "SELECT stats_item_type_id, stats_item_type_counter FROM $t_edb_stats_item_types WHERE stats_item_type_year=$year AND stats_item_type_month=$month AND stats_item_type_district_id=$get_current_case_district_id AND stats_item_type_item_type_id=$get_types_item_type_id";
						$result_st = mysqli_query($link, $query_st);
						$row_st = mysqli_fetch_row($result_st);
						list($get_stats_item_type_id, $get_stats_item_type_counter) = $row_st;
						if($get_stats_item_type_id == ""){

							mysqli_query($link, "INSERT INTO $t_edb_stats_item_types 
									(stats_item_type_id, stats_item_type_year, stats_item_type_month, stats_item_type_district_id, stats_item_type_station_id, stats_item_type_user_id, stats_item_type_item_type_id, stats_item_type_item_type_title, stats_item_type_counter) 
									VALUES 
									(NULL, $year, $month, $get_current_case_district_id, NULL, NULL, $get_types_item_type_id, $inp_item_type_title_mysql, 1)")
									or die(mysqli_error($link));
						}
						else{
							$inp_stats_item_type_counter  = $get_stats_item_type_counter+1;
							$result_update = mysqli_query($link, "UPDATE $t_edb_stats_item_types SET 
											stats_item_type_counter=$inp_stats_item_type_counter  
											WHERE stats_item_type_id=$get_stats_item_type_id") or die(mysqli_error($link));
						}

						// Item Type Stats: Station
						$query_st = "SELECT stats_item_type_id, stats_item_type_counter FROM $t_edb_stats_item_types WHERE stats_item_type_year=$year AND stats_item_type_month=$month AND stats_item_type_station_id=$get_current_case_station_id AND stats_item_type_item_type_id=$get_types_item_type_id";
						$result_st = mysqli_query($link, $query_st);
						$row_st = mysqli_fetch_row($result_st);
						list($get_stats_item_type_id, $get_stats_item_type_counter) = $row_st;
						if($get_stats_item_type_id == ""){

							mysqli_query($link, "INSERT INTO $t_edb_stats_item_types 
									(stats_item_type_id, stats_item_type_year, stats_item_type_month, stats_item_type_district_id, stats_item_type_station_id, stats_item_type_user_id, stats_item_type_item_type_id, stats_item_type_item_type_title, stats_item_type_counter) 
									VALUES 
									(NULL, $year, $month, NULL, $get_current_case_station_id, NULL, $get_types_item_type_id, $inp_item_type_title_mysql, 1)")
									or die(mysqli_error($link));
						}
						else{
							$inp_stats_item_type_counter  = $get_stats_item_type_counter+1;
							$result_update = mysqli_query($link, "UPDATE $t_edb_stats_item_types SET 
											stats_item_type_counter=$inp_stats_item_type_counter  
											WHERE stats_item_type_id=$get_stats_item_type_id") or die(mysqli_error($link));
						}
					} // new type, write into statistics



					$inp_item_comment = $_POST["inp_item_comment_$get_item_id"];
					$inp_item_comment = output_html($inp_item_comment);
					$inp_item_comment_mysql = quote_smart($link, $inp_item_comment);

					$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
					item_title=$inp_item_title_mysql,
					item_type_id=$get_types_item_type_id,
					item_type_title=$inp_item_type_title_mysql,
					item_comment=$inp_item_comment_mysql
					WHERE item_id=$get_item_id AND item_case_id=$get_current_case_id") or die(mysqli_error($link));


					// In date
					$inp_item_in_date = $_POST["inp_item_in_date_$get_item_id"];
					$inp_item_in_date = output_html($inp_item_in_date);
					$inp_item_in_date_mysql = quote_smart($link, $inp_item_in_date);

					$inp_item_in_date_strlen = strlen($inp_item_in_date);


					if($inp_item_in_date_strlen == 10){
						$inp_item_in_date_year = substr($inp_item_in_date, 0, 4);
						$inp_item_in_date_month = substr($inp_item_in_date, 5, 2);
						$inp_item_in_date_day = substr($inp_item_in_date, 8, 2);
					
						$hour_min_sec = date("H:i:s");
						$inp_item_in_datetime = $inp_item_in_date_year . "-" . $inp_item_in_date_month . "-" . $inp_item_in_date_day . " $hour_min_sec"; 
						$inp_item_in_time = strtotime($inp_item_in_datetime);

						$inp_item_in_date_month_strlen = strlen($inp_item_in_date_month);
						if($inp_item_in_date_month_strlen == 2){
							$inp_item_in_date_month_saying = substr($inp_item_in_date_month, 1, 1);
							$inp_item_in_date_month_saying = $l_month_array[$inp_item_in_date_month_saying];
						}
						else{
							$inp_item_in_date_month_saying = $l_month_array[$inp_item_in_date_month];
						}
						$inp_item_in_date_saying = "$inp_item_in_date_day. $inp_item_in_date_month_saying $inp_item_in_date_year";

						$inp_item_in_datetime_mysql = quote_smart($link, $inp_item_in_datetime);
						$inp_item_in_time_mysql = quote_smart($link, $inp_item_in_time);
						$inp_item_in_date_saying_mysql = quote_smart($link, $inp_item_in_date_saying);

						$inp_item_in_date_ddmmyy = $inp_item_in_date_day . "." . $inp_item_in_date_month . "." . substr($inp_item_in_date_year, 2, 2);
						$inp_item_in_date_ddmmyy_mysql = quote_smart($link, $inp_item_in_date_ddmmyy);

						$inp_item_in_date_ddmmyyyy = $inp_item_in_date_day . "." . $inp_item_in_date_month . "." . $inp_item_in_date_year;
						$inp_item_in_date_ddmmyyyy_mysql = quote_smart($link, $inp_item_in_date_ddmmyyyy);

						$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
						item_title=$inp_item_title_mysql,
						item_type_id=$get_types_item_type_id,
						item_type_title=$inp_item_type_title_mysql,
						item_in_datetime=$inp_item_in_datetime_mysql, 
						item_in_date=$inp_item_in_date_mysql, 
						item_in_time=$inp_item_in_time_mysql, 
						item_in_date_saying=$inp_item_in_date_saying_mysql, 
						item_in_date_ddmmyy=$inp_item_in_date_ddmmyy_mysql, 
						item_in_date_ddmmyyyy=$inp_item_in_date_ddmmyyyy_mysql
						WHERE item_id=$get_item_id AND item_case_id=$get_current_case_id") or die(mysqli_error($link));


					}
					else{
						$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
						item_in_datetime=NULL, 
						item_in_time=NULL, 
						item_in_date_saying=NULL, 
						item_in_date_ddmmyy=NULL, 
						item_in_date_ddmmyyyy=NULL
						WHERE item_id=$get_item_id AND item_case_id=$get_current_case_id") or die(mysqli_error($link));
					}
	

					// Acquired date
					$inp_item_acquired_date = $_POST["inp_item_acquired_date_$get_item_id"];
					$inp_item_acquired_date = output_html($inp_item_acquired_date);
					$inp_item_acquired_date_mysql = quote_smart($link, $inp_item_acquired_date);

					$inp_item_acquired_date_strlen = strlen($inp_item_acquired_date);
					if($inp_item_acquired_date_strlen == 10){
						$inp_item_acquired_date_year = substr($inp_item_acquired_date, 0, 4);
						$inp_item_acquired_date_month = substr($inp_item_acquired_date, 5, 2);
						$inp_item_acquired_date_day = substr($inp_item_acquired_date, 8, 2);
					
						$inp_item_acquired_time = strtotime($inp_item_acquired_date);

						$inp_item_acquired_date_month_strlen = strlen($inp_item_acquired_date_month);
						if($inp_item_acquired_date_month_strlen == 2){
							$inp_item_acquired_date_month_saying = substr($inp_item_acquired_date_month, 1, 1);
							$inp_item_acquired_date_month_saying = $l_month_array[$inp_item_acquired_date_month_saying];
						}
						else{
							$inp_item_acquired_date_month_saying = $l_month_array[$inp_item_acquired_date_month];
						}
						$inp_item_acquired_date_saying = "$inp_item_acquired_date_day. $inp_item_acquired_date_month_saying $inp_item_acquired_date_year";

						$inp_item_acquired_date_mysql = quote_smart($link, $inp_item_acquired_date);
						$inp_item_acquired_time_mysql = quote_smart($link, $inp_item_acquired_time);
						$inp_item_acquired_date_saying_mysql = quote_smart($link, $inp_item_acquired_date_saying);

						$inp_item_acquired_date_ddmmyy = $inp_item_acquired_date_day . "." . $inp_item_acquired_date_month . "." . substr($inp_item_acquired_date_year, 2, 2); 
						$inp_item_acquired_date_ddmmyy_mysql = quote_smart($link, $inp_item_acquired_date_ddmmyy);

						$inp_item_acquired_date_ddmmyyyy = $inp_item_acquired_date_day . "." . $inp_item_acquired_date_month . "." . $inp_item_acquired_date_year; 
						$inp_item_acquired_date_ddmmyyyy_mysql = quote_smart($link, $inp_item_acquired_date_ddmmyyyy);

						$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
						item_title=$inp_item_title_mysql,
						item_type_id=$get_types_item_type_id,
						item_type_title=$inp_item_type_title_mysql,
						item_acquired_date=$inp_item_acquired_date_mysql, 
						item_acquired_time=$inp_item_acquired_time_mysql, 
						item_acquired_date_saying=$inp_item_acquired_date_saying_mysql, 
						item_acquired_date_ddmmyy=$inp_item_acquired_date_ddmmyy_mysql, 
						item_acquired_date_ddmmyyyy=$inp_item_acquired_date_ddmmyyyy_mysql
						WHERE item_id=$get_item_id AND item_case_id=$get_current_case_id") or die(mysqli_error($link));
					}
					else{
						$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
						item_acquired_date=NULL, 
						item_acquired_time=NULL, 
						item_acquired_date_saying=NULL, 
						item_acquired_date_ddmmyy=NULL, 
						item_acquired_date_ddmmyyyy=NULL
						WHERE item_id=$get_item_id AND item_case_id=$get_current_case_id") or die(mysqli_error($link));
					}
	

					// Out date
					$inp_item_out_date = $_POST["inp_item_out_date_$get_item_id"];
					$inp_item_out_date = output_html($inp_item_out_date);
					$inp_item_out_date_mysql = quote_smart($link, $inp_item_out_date);

					$inp_item_out_date_strlen = strlen($inp_item_out_date);
					if($inp_item_out_date_strlen == 10){
						$inp_item_out_date_year = substr($inp_item_out_date, 0, 4);
						$inp_item_out_date_month = substr($inp_item_out_date, 5, 2);
						$inp_item_out_date_day = substr($inp_item_out_date, 8, 2);
					
						$inp_item_out_date = $inp_item_out_date_year . "-" . $inp_item_out_date_month . "-" . $inp_item_out_date_day; 
						$inp_item_out_time = strtotime($inp_item_out_date);

						$inp_item_out_date_month_strlen = strlen($inp_item_out_date_month);
						if($inp_item_out_date_month_strlen == 2){
							$inp_item_out_date_month_saying = substr($inp_item_out_date_month, 1, 1);
							$inp_item_out_date_month_saying = $l_month_array[$inp_item_out_date_month_saying];
						}
						else{
							$inp_item_out_date_month_saying = $l_month_array[$inp_item_out_date_month];
						}
						$inp_item_out_date_saying = "$inp_item_out_date_day. $inp_item_out_date_month_saying $inp_item_out_date_year";

						$inp_item_out_date_mysql = quote_smart($link, $inp_item_out_date);
						$inp_item_out_time_mysql = quote_smart($link, $inp_item_out_time);
						$inp_item_out_date_saying_mysql = quote_smart($link, $inp_item_out_date_saying);

						$inp_item_out_date_ddmmyy =  $inp_item_out_date_day . "." . $inp_item_out_date_month . "." . substr($inp_item_out_date_year, 2, 2); 
						$inp_item_out_date_ddmmyy_mysql = quote_smart($link, $inp_item_out_date_ddmmyy);

						$inp_item_out_date_ddmmyyyy =  $inp_item_out_date_day . "." . $inp_item_out_date_month . "." . $inp_item_out_date_year; 
						$inp_item_out_date_ddmmyyyy_mysql = quote_smart($link, $inp_item_out_date_ddmmyyyy);


						$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
						item_title=$inp_item_title_mysql,
						item_type_id=$get_types_item_type_id,
						item_type_title=$inp_item_type_title_mysql,
						item_out_date=$inp_item_out_date_mysql, 
						item_out_time=$inp_item_out_time_mysql, 
						item_out_date_saying=$inp_item_out_date_saying_mysql, 
						item_out_date_ddmmyy=$inp_item_out_date_ddmmyy_mysql,
						item_out_date_ddmmyyyy=$inp_item_out_date_ddmmyyyy_mysql
						WHERE item_id=$get_item_id AND item_case_id=$get_current_case_id") or die(mysqli_error($link));
					}
					else{
						$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
						item_out_date=NULL, 
						item_out_time=NULL, 
						item_out_date_saying=NULL, 
						item_out_date_ddmmyy=NULL,
						item_out_date_ddmmyyyy=NULL
						WHERE item_id=$get_item_id AND item_case_id=$get_current_case_id") or die(mysqli_error($link));
					}

					// Out notes
					$inp_item_out_notes = $_POST["inp_item_out_notes_$get_item_id"];
					$inp_item_out_notes = output_html($inp_item_out_notes);
					$inp_item_out_notes_mysql = quote_smart($link, $inp_item_out_notes);

					$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
						item_out_notes=$inp_item_out_notes_mysql 
						WHERE item_id=$get_item_id AND item_case_id=$get_current_case_id") or die(mysqli_error($link));




					// Stats Requests :: Users and Department Item types
					if($inp_item_type_id != "$get_item_type_id" && $inp_item_type_id != "0" && $get_item_requester_user_id != ""){
						// Find requester location
						$query_r = "SELECT professional_id, professional_company_location FROM $t_users_professional WHERE professional_user_id=$get_item_requester_user_id";
						$result_r = mysqli_query($link, $query_r);
						$row_r = mysqli_fetch_row($result_r);
						list($get_professional_id, $get_professional_company_location) = $row_r;
							

						// Ready variables
						$date_yyyy = date("Y");
						$date_mm   = date("m");
						$inp_department_mysql = quote_smart($link, $get_item_requester_user_department);
						$inp_location_mysql = quote_smart($link, $get_professional_company_location);
						$inp_type_title_mysql = quote_smart($link, $get_types_item_type_title);

						// Department Item types
						$query_d = "SELECT stats_dep_item_type_id, stats_dep_item_type_counter FROM $t_edb_stats_requests_department_item_types_per_month WHERE stats_dep_item_type_year=$date_yyyy AND stats_dep_item_type_month=$date_mm AND stats_dep_item_type_department=$inp_department_mysql AND stats_dep_item_type_location=$inp_location_mysql AND stats_dep_item_type_item_type_id=$get_types_item_type_id";
						$result_d = mysqli_query($link, $query_d);
						$row_d = mysqli_fetch_row($result_d);
						list($get_stats_dep_item_type_id, $get_stats_dep_item_type_counter) = $row_d;
						if($get_stats_dep_item_type_id == ""){

							mysqli_query($link, "INSERT INTO $t_edb_stats_requests_department_item_types_per_month 
							(stats_dep_item_type_id, stats_dep_item_type_year, stats_dep_item_type_month, stats_dep_item_type_district_id, stats_dep_item_type_station_id, stats_dep_item_type_department, stats_dep_item_type_location, stats_dep_item_type_item_type_id, stats_dep_item_type_item_type_title, stats_dep_item_type_counter) 
							VALUES 
							(NULL, $date_yyyy, $date_mm, $get_current_case_district_id, $get_current_case_station_id, $inp_department_mysql, $inp_location_mysql, $get_types_item_type_id, $inp_type_title_mysql, 1)")
							or die(mysqli_error($link));

						}
						else{


							$inp_counter = $get_stats_dep_item_type_counter+1;
							$result = mysqli_query($link, "UPDATE $t_edb_stats_requests_department_item_types_per_month SET stats_dep_item_type_counter=$inp_counter WHERE stats_dep_item_type_id=$get_stats_dep_item_type_id") or die(mysqli_error($link));


						}

						// Stats Requests :: User Item types 
						$query = "SELECT stats_usr_item_type_id, stats_usr_item_type_counter FROM $t_edb_stats_requests_user_item_types_per_month WHERE stats_usr_item_type_year=$date_yyyy AND stats_usr_item_type_month=$date_mm AND stats_usr_item_type_user_id=$get_item_requester_user_id AND stats_usr_item_type_item_type_id=$get_types_item_type_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_stats_usr_item_type_id, $get_stats_usr_item_type_counter) = $row;
						if($get_stats_usr_item_type_id == ""){
							mysqli_query($link, "INSERT INTO $t_edb_stats_requests_user_item_types_per_month 
							(stats_usr_item_type_id, stats_usr_item_type_year, stats_usr_item_type_month, stats_usr_item_type_district_id, stats_usr_item_type_station_id, stats_usr_item_type_user_id, stats_usr_item_type_item_type_id, stats_usr_item_type_item_type_title, stats_usr_item_type_counter) 
							VALUES 
							(NULL, $date_yyyy, $date_mm, $get_current_case_district_id, $get_current_case_station_id, $get_item_requester_user_id, $get_types_item_type_id, $inp_type_title_mysql, 1)")
							or die(mysqli_error($link));
						}
						else{
							$inp_counter = $get_stats_usr_item_type_counter+1;
							$result = mysqli_query($link, "UPDATE $t_edb_stats_requests_user_item_types_per_month SET stats_usr_item_type_counter=$inp_counter WHERE stats_usr_item_type_id=$get_stats_usr_item_type_id") or die(mysqli_error($link));
						}


						} // new item type
					
				} // while items

				$save_time = date("H:i:s");
				$url = "open_case_evidence.php?case_id=$get_current_case_id&l=$l&ft=success&fm=changes_saved_$save_time";
				header("Location: $url");
				exit;
			}
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
					&gt;
					<a href=\"open_case_evidence.php?case_id=$get_current_case_id&amp;l=$l\">$l_evidence</a>
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
	

			
		echo"
		<h2>$l_evidence</h2>

		<!-- Case code check -->
			";
			if($get_current_case_code_id == ""){
				echo"
				<div class=\"info\"><p>$l_missing_case_code <a href=\"open_case_overview.php?case_id=$get_current_case_id&amp;l=$l\">$l_enter_case_code</a></p></div>
				";
			} // case code not null
			echo"
		<!-- //Case code check -->


		<!-- Evidence actions -->
			";
			if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
				echo"
				<p>
				<a href=\"open_case_evidence_new_record.php?case_id=$get_current_case_id&amp;l=$l\" class=\"btn_default\">$l_new_record</a>
				<a href=\"open_case_evidence_new_item.php?case_id=$get_current_case_id&amp;action=&amp;l=$l\" class=\"btn_default\">$l_add_item</a>\n";
				$query = "SELECT report_id, report_title, report_title_clean, report_logo_path, report_logo_file, report_type FROM $t_edb_case_reports";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_report_id, $get_report_title, $get_report_title_clean, $get_report_logo_path, $get_report_logo_file, $get_report_type) = $row;
					echo"			<a href=\"open_case_evidence_report_$get_report_type.php?case_id=$get_current_case_id&amp;report_id=$get_report_id&amp;l=$l\" class=\"btn_default\">$get_report_title</a>\n";
				}
				echo"
				</p>
				<div style=\"height: 10px;\"></div>
				";
			}
			echo"
		<!-- //Evidence actions -->


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

		<!-- List of all items -->
			";
			if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
				echo"
				<form method=\"POST\" action=\"open_case_evidence.php?case_id=$get_current_case_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
				";
			}
			echo"
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
				<span>$l_comment</span>
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
				<span>$l_out_notes</span>
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
			$counter = 0;
			$physical_location = "";
			$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_in_date_ddmmyyyy, item_storage_shelf_id, item_storage_shelf_title, item_storage_location_id, item_storage_location_abbr, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_timezone, item_date_now_date, item_date_now_ddmmyy, item_time_now, item_correct_date_now_date, item_correct_date_now_ddmmyy, item_correct_time_now, item_adjust_clock_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_date_ddmmyyyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy, item_out_date_ddmmyyyy, item_out_notes FROM $t_edb_case_index_evidence_items WHERE item_case_id=$get_current_case_id ORDER BY item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_item_id, $get_item_case_id, $get_item_record_id, $get_item_record_seized_year, $get_item_record_seized_journal, $get_item_record_seized_district_number, $get_item_numeric_serial_number, $get_item_title, $get_item_type_id, $get_item_type_title, $get_item_confirmed_by_human, $get_item_human_rejected, $get_item_request_text, $get_item_requester_user_id, $get_item_requester_user_name, $get_item_requester_user_alias, $get_item_requester_user_email, $get_item_requester_user_image_path, $get_item_requester_user_image_file, $get_item_requester_user_image_thumb_40, $get_item_requester_user_image_thumb_50, $get_item_requester_user_first_name, $get_item_requester_user_middle_name, $get_item_requester_user_last_name, $get_item_requester_user_job_title, $get_item_requester_user_department, $get_item_in_datetime, $get_item_in_date, $get_item_in_time, $get_item_in_date_saying, $get_item_in_date_ddmmyy, $get_item_in_date_ddmmyyyy, $get_item_storage_shelf_id, $get_item_storage_shelf_title, $get_item_storage_location_id, $get_item_storage_location_abbr, $get_item_comment, $get_item_condition, $get_item_serial_number, $get_item_imei_a, $get_item_imei_b, $get_item_imei_c, $get_item_imei_d, $get_item_os_title, $get_item_os_version, $get_item_timezone, $get_item_date_now_date, $get_item_date_now_ddmmyy, $get_item_time_now, $get_item_correct_date_now_date, $get_item_correct_date_now_ddmmyy, $get_item_correct_time_now, $get_item_adjust_clock_automatically, $get_item_acquired_software_id_a, $get_item_acquired_software_title_a, $get_item_acquired_software_notes_a, $get_item_acquired_software_id_b, $get_item_acquired_software_title_b, $get_item_acquired_software_notes_b, $get_item_acquired_software_id_c, $get_item_acquired_software_title_c, $get_item_acquired_software_notes_c, $get_item_acquired_date, $get_item_acquired_time, $get_item_acquired_date_saying, $get_item_acquired_date_ddmmyy, $get_item_acquired_date_ddmmyyyy, $get_item_acquired_user_id, $get_item_acquired_user_name, $get_item_acquired_user_alias, $get_item_acquired_user_email, $get_item_acquired_user_image_path, $get_item_acquired_user_image_file, $get_item_acquired_user_image_thumb_40, $get_item_acquired_user_image_thumb_50, $get_item_acquired_user_first_name, $get_item_acquired_user_middle_name, $get_item_acquired_user_last_name, $get_item_out_date, $get_item_out_time, $get_item_out_date_saying, $get_item_out_date_ddmmyy, $get_item_out_date_ddmmyyyy, $get_item_out_notes) = $row;

				if(isset($style) && $style == ""){
					$style = "odd";
				}
				else{
					$style = "";
				}

				echo"
				<tr>
				  <td class=\"$style\">
					<span>
					";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"
						<input type=\"checkbox\" name=\"inp_checkbox_item_$get_item_id\" />
						";
					}
					echo"
					<a href=\"open_case_evidence_edit_evidence_item_item.php?case_id=$get_current_case_id&amp;item_id=$get_item_id&amp;mode=item&amp;l=$l\">$get_item_record_seized_year/$get_item_record_seized_journal-$get_item_record_seized_district_number-$get_item_numeric_serial_number</a></span>
				  </td>
				  <td class=\"$style\">
					";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"<span><input type=\"text\" name=\"inp_item_title_$get_item_id\" value=\"$get_item_title\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>\n";
					}
					else{
						echo"<span>$get_item_title</span>";
					}
					echo"
				  </td>
				  <td class=\"$style\">
					<span>";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"
						<select name=\"inp_item_type_id_$get_item_id\" class=\"on_change_submit_form\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
							<option value=\"0\""; if($get_item_type_id == ""){ echo" selected=\"selected\""; } echo">-</option>\n";
						$query_sub = "SELECT item_type_id, item_type_title, item_type_image_path, item_type_image_file FROM $t_edb_item_types ORDER BY item_type_title ASC";
						$result_sub = mysqli_query($link, $query_sub);
						while($row_sub = mysqli_fetch_row($result_sub)) {
							list($get_types_item_type_id, $get_types_item_type_title, $get_types_item_type_image_path, $get_types_item_type_image_file) = $row_sub;
							echo"			";
							echo"<option value=\"$get_types_item_type_id\""; if($get_types_item_type_id == "$get_item_type_id"){ echo" selected=\"selected\""; } echo">$get_types_item_type_title</option>\n";
						}
						echo"
						</select>
						";
					}
					else{
						echo"<span>$get_item_type_title</span>";
					}
					echo"</span>
				  </td>
				  <td class=\"$style\">
					<span>";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"<input type=\"date\" name=\"inp_item_in_date_$get_item_id\" value=\"$get_item_in_date\" class=\"on_change_submit_form\" size=\"6\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
					}
					else{
						echo"$get_item_in_date_ddmmyyyy";
					}
					echo"</span>
				  </td>
				  <td class=\"$style\">
					";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"<span><input type=\"text\" name=\"inp_item_comment_$get_item_id\" value=\"$get_item_comment\" size=\"16\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>\n";
					}
					else{
						echo"<span>$get_item_comment</span>";
					}
					echo"
				  </td>
				  <td class=\"$style\">
					<span>";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"<input type=\"date\" name=\"inp_item_acquired_date_$get_item_id\" value=\"$get_item_acquired_date\" class=\"on_change_submit_form\" size=\"6\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
					}
					else{
						echo"$get_item_acquired_date_ddmmyyyy";
					}
					echo"</span>
				  </td>
				  <td class=\"$style\">";
					if($get_item_acquired_user_id != "" && $get_item_acquired_user_id != "0"){
						echo"
						<a href=\"$root/users/view_profile.php?user_id=$get_item_acquired_user_id&amp;l=$l\">$get_item_acquired_user_first_name $get_item_acquired_user_middle_name $get_item_acquired_user_last_name</a>
						";
					} // aquired user id not null
					echo"
				  </td>
				  <td class=\"$style\">
					<span>";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"<input type=\"date\" name=\"inp_item_out_date_$get_item_id\" value=\"$get_item_out_date\" class=\"on_change_submit_form\" size=\"6\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
					}
					else{
						echo"$get_item_out_date_ddmmyyyy";
					}
					echo"</span>

				  </td>
				  <td class=\"$style\">
					<span>";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"<input type=\"text\" name=\"inp_item_out_notes_$get_item_id\" value=\"$get_item_out_notes\" size=\"16\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />";
					}
					else{
						echo"$get_item_out_notes";
					}
					echo"</span>
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
				$counter = $counter + 1;

				// Location
				if($physical_location == ""){
					$physical_location = "$get_item_storage_shelf_title ($get_item_storage_location_abbr)";
				}
				else{
					if($physical_location != "$get_item_storage_shelf_title $get_item_storage_location_abbr"){
						$array = explode("|", $physical_location);
						$found = false;
						for($x=0;$x<sizeof($array);$x++){
							$full_name = $array[$x];
							if($full_name == "$get_item_storage_shelf_title ($get_item_storage_location_abbr)"){
								$found = true;
								break;
							}
						}
						if($found == false){
							$physical_location = $physical_location . "|$get_item_storage_shelf_title ($get_item_storage_location_abbr)";
						}
					}
				}
			} // while items
			if($counter != "$get_current_menu_counter_evidence"){
				$result = mysqli_query($link, "UPDATE $t_edb_case_index_open_case_menu_counters SET menu_counter_evidence=$counter WHERE menu_counter_case_id=$get_current_case_id");
			}
			if($get_current_case_physical_location != "$physical_location"){
				$input_physical_location = "";
				$array = explode("|", $physical_location);
				$array_size = sizeof($array);
				$array_size_last = $array_size -1;
				for($x=0;$x<sizeof($array);$x++){
					$full_name = trim($array[$x]);
					if($full_name != "" && $full_name != "()"){
						
						if($input_physical_location == ""){
							$input_physical_location = "$full_name";
						}
						else{
							if($x == "$array_size_last"){
								$input_physical_location = $input_physical_location . " $l_and_lowercase $full_name";
							}
							else{
								$input_physical_location = $input_physical_location . ", $full_name";
							}
						}
					}
				}
				$input_physical_location_mysql = quote_smart($link, $input_physical_location);
				$result = mysqli_query($link, "UPDATE $t_edb_case_index SET case_physical_location=$input_physical_location_mysql WHERE case_id=$get_current_case_id");
			}
			echo"
			 </tbody>
			</table>
			";
			if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
				echo"
				<p>
				<input type=\"submit\" value=\"$l_save_changes\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
				<input type=\"submit\" name=\"inp_submit_with_selected\" value=\"$l_with_selected...\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
				</p>
				</form>
				<!-- Submit form after change type -->
				<script>
				\$(function() {
					\$('.on_change_submit_form').change(function() {
						this.form.submit();
					});
				});
				</script>
				<!-- //Submit form after change type -->
				";
			}
			echo"
		<!-- List of all items -->
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