<?php 
/**
*
* File: edb/open_case_evidence_select_many.php
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
include("$root/_admin/_translations/site/$l/edb/ts_open_case_evidence.php");
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

if(isset($_GET['items_selected'])) {
	$items_selected = $_GET['items_selected'];
	$items_selected = strip_tags(stripslashes($items_selected));
}
else{
	$items_selected = "";
}


/*- Tables ---------------------------------------------------------------------------- */
$t_edb_evidence_storage_locations 	= $mysqlPrefixSav . "edb_evidence_storage_locations";
$t_edb_evidence_storage_shelves		= $mysqlPrefixSav . "edb_evidence_storage_shelves";

/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){

	// Find case 
	$query = "SELECT case_id, case_number, case_title, case_title_clean, case_suspect_in_custody, case_code_id, case_code_title, case_status_id, case_status_title, case_priority_id, case_priority_title, case_district_id, case_district_title, case_station_id, case_station_title, case_is_screened, case_assigned_to_datetime, case_assigned_to_time, case_assigned_to_date_saying, case_assigned_to_date_ddmmyy, case_assigned_to_user_id, case_assigned_to_user_name, case_assigned_to_user_alias, case_assigned_to_user_email, case_assigned_to_user_image_path, case_assigned_to_user_image_file, case_assigned_to_user_image_thumb_40, case_assigned_to_user_image_thumb_50, case_assigned_to_user_first_name, case_assigned_to_user_middle_name, case_assigned_to_user_last_name, case_created_datetime, case_created_time, case_created_date_saying, case_created_date_ddmmyy, case_created_user_id, case_created_user_name, case_created_user_alias, case_created_user_email, case_created_user_image_path, case_created_user_image_file, case_created_user_image_thumb_40, case_created_user_image_thumb_50, case_created_user_first_name, case_created_user_middle_name, case_created_user_last_name, case_detective_user_id, case_detective_user_job_title, case_detective_user_first_name, case_detective_user_middle_name, case_detective_user_last_name, case_detective_user_name, case_detective_user_alias, case_detective_user_email, case_detective_email_alerts, case_detective_user_image_path, case_detective_user_image_file, case_detective_user_image_thumb_40, case_detective_user_image_thumb_50, case_updated_datetime, case_updated_time, case_updated_date_saying, case_updated_date_ddmmyy, case_updated_user_id, case_updated_user_name, case_updated_user_alias, case_updated_user_email, case_updated_user_image_path, case_updated_user_image_file, case_updated_user_image_thumb_40, case_updated_user_image_thumb_50, case_updated_user_first_name, case_updated_user_middle_name, case_updated_user_last_name, case_is_closed, case_closed_datetime, case_closed_time, case_closed_date_saying, case_closed_date_ddmmyy, case_time_from_created_to_close FROM $t_edb_case_index WHERE case_id=$case_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_case_id, $get_current_case_number, $get_current_case_title, $get_current_case_title_clean, $get_current_case_suspect_in_custody, $get_current_case_code_id, $get_current_case_code_title, $get_current_case_status_id, $get_current_case_status_title, $get_current_case_priority_id, $get_current_case_priority_title, $get_current_case_district_id, $get_current_case_district_title, $get_current_case_station_id, $get_current_case_station_title, $get_current_case_is_screened, $get_current_case_assigned_to_datetime, $get_current_case_assigned_to_time, $get_current_case_assigned_to_date_saying, $get_current_case_assigned_to_date_ddmmyy, $get_current_case_assigned_to_user_id, $get_current_case_assigned_to_user_name, $get_current_case_assigned_to_user_alias, $get_current_case_assigned_to_user_email, $get_current_case_assigned_to_user_image_path, $get_current_case_assigned_to_user_image_file, $get_current_case_assigned_to_user_image_thumb_40, $get_current_case_assigned_to_user_image_thumb_50, $get_current_case_assigned_to_user_first_name, $get_current_case_assigned_to_user_middle_name, $get_current_case_assigned_to_user_last_name, $get_current_case_created_datetime, $get_current_case_created_time, $get_current_case_created_date_saying, $get_current_case_created_date_ddmmyy, $get_current_case_created_user_id, $get_current_case_created_user_name, $get_current_case_created_user_alias, $get_current_case_created_user_email, $get_current_case_created_user_image_path, $get_current_case_created_user_image_file, $get_current_case_created_user_image_thumb_40, $get_current_case_created_user_image_thumb_50, $get_current_case_created_user_first_name, $get_current_case_created_user_middle_name, $get_current_case_created_user_last_name, $get_current_case_detective_user_id, $get_current_case_detective_user_job_title, $get_current_case_detective_user_first_name, $get_current_case_detective_user_middle_name, $get_current_case_detective_user_last_name, $get_current_case_detective_user_name, $get_current_case_detective_user_alias, $get_current_case_detective_user_email, $get_current_case_detective_email_alerts, $get_current_case_detective_user_image_path, $get_current_case_detective_user_image_file, $get_current_case_detective_user_image_thumb_40, $get_current_case_detective_user_image_thumb_50, $get_current_case_updated_datetime, $get_current_case_updated_time, $get_current_case_updated_date_saying, $get_current_case_updated_date_ddmmyy, $get_current_case_updated_user_id, $get_current_case_updated_user_name, $get_current_case_updated_user_alias, $get_current_case_updated_user_email, $get_current_case_updated_user_image_path, $get_current_case_updated_user_image_file, $get_current_case_updated_user_image_thumb_40, $get_current_case_updated_user_image_thumb_50, $get_current_case_updated_user_first_name, $get_current_case_updated_user_middle_name, $get_current_case_updated_user_last_name, $get_current_case_is_closed, $get_current_case_closed_datetime, $get_current_case_closed_time, $get_current_case_closed_date_saying, $get_current_case_closed_date_ddmmyy, $get_current_case_time_from_created_to_close) = $row;
	

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

				// Out date
				$inp_item_out_date = $_POST["inp_item_out_date"];
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

					$inp_item_out_date_ddmmyy =  $inp_item_out_date_day . "." . $inp_item_out_date_month . "." . $inp_item_out_date_year; 
					$inp_item_out_date_ddmmyy_mysql = quote_smart($link, $inp_item_out_date_ddmmyy);

						
				}

				// Out notes
				$inp_item_out_notes = $_POST["inp_item_out_notes"];
				$inp_item_out_notes = output_html($inp_item_out_notes);
				$inp_item_out_notes_mysql = quote_smart($link, $inp_item_out_notes);

					
				// Storage
				$inp_storage_location_id = "";
				$inp_storage_location_abbr = "";
				$inp_storage_shelf_id = "";
				$inp_storage_shelf_title = "";

				$inp_storage = $_POST['inp_storage'];
				$inp_storage = output_html($inp_storage);
				if($inp_storage != ""){
					$storage_location_abbr = strstr($inp_storage, '(');
					$storage_location_abbr = str_replace("(", "", $storage_location_abbr);
					$storage_location_abbr = str_replace(")", "", $storage_location_abbr);

					if($storage_location_abbr != ""){
						$storage_location_abbr_mysql = quote_smart($link, $storage_location_abbr);
						$query = "SELECT storage_location_id, storage_location_title, storage_location_abbr, storage_location_station_id FROM $t_edb_evidence_storage_locations WHERE storage_location_abbr=$storage_location_abbr_mysql";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_storage_location_id, $get_storage_location_title, $get_storage_location_abbr, $get_storage_location_station_id) = $row;
						if($get_storage_location_id == ""){

						}
						else{
							$inp_storage_location_id = "$get_storage_location_id";
							$inp_storage_location_abbr = "$get_storage_location_abbr";
						}
					
		
						// Shelve
						$storage_shelf_full_name = str_replace("($storage_location_abbr)", "", $inp_storage); 
						$storage_shelf_full_name_mysql = quote_smart($link, $storage_shelf_full_name);

						if($storage_shelf_full_name != ""){
							$query = "SELECT shelf_id, shelf_full_name FROM $t_edb_evidence_storage_shelves WHERE shelf_full_name=$storage_shelf_full_name_mysql AND shelf_station_id=$get_storage_location_station_id AND shelf_storage_location_id=$get_storage_location_id";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_shelf_id, $get_shelf_full_name) = $row;
							if($get_shelf_id == ""){
							}
							else{
								$inp_storage_shelf_id = "$get_shelf_id";
								$inp_storage_shelf_title = "$get_shelf_full_name";
							}
						}
					} // if($storage_location_abbr != ""){
				} // Storage
				$inp_storage_location_id_mysql = quote_smart($link, $inp_storage_location_id);
				$inp_storage_location_abbr_mysql = quote_smart($link, $inp_storage_location_abbr);
				$inp_storage_shelf_id_mysql = quote_smart($link, $inp_storage_shelf_id);
				$inp_storage_shelf_title_mysql = quote_smart($link, $inp_storage_shelf_title);

		
 		
				// Loop trough items and save all fields
				$items_selected_array = explode(",", $items_selected);
				$items_selected_array_size = sizeof($items_selected_array);
		

				$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_timezone, item_date_now_date, item_date_now_ddmmyy, item_time_now, item_correct_date_now_date, item_correct_date_now_ddmmyy, item_correct_time_now, item_adjust_clock_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy, item_out_notes FROM $t_edb_case_index_evidence_items WHERE item_case_id=$get_current_case_id ORDER BY item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_item_id, $get_item_case_id, $get_item_record_id, $get_item_record_seized_year, $get_item_record_seized_journal, $get_item_record_seized_district_number, $get_item_numeric_serial_number, $get_item_title, $get_item_type_id, $get_item_type_title, $get_item_confirmed_by_human, $get_item_human_rejected, $get_item_request_text, $get_item_requester_user_id, $get_item_requester_user_name, $get_item_requester_user_alias, $get_item_requester_user_email, $get_item_requester_user_image_path, $get_item_requester_user_image_file, $get_item_requester_user_image_thumb_40, $get_item_requester_user_image_thumb_50, $get_item_requester_user_first_name, $get_item_requester_user_middle_name, $get_item_requester_user_last_name, $get_item_requester_user_job_title, $get_item_requester_user_department, $get_item_in_datetime, $get_item_in_date, $get_item_in_time, $get_item_in_date_saying, $get_item_in_date_ddmmyy, $get_item_comment, $get_item_condition, $get_item_serial_number, $get_item_imei_a, $get_item_imei_b, $get_item_imei_c, $get_item_imei_d, $get_item_os_title, $get_item_os_version, $get_item_timezone, $get_item_date_now_date, $get_item_date_now_ddmmyy, $get_item_time_now, $get_item_correct_date_now_date, $get_item_correct_date_now_ddmmyy, $get_item_correct_time_now, $get_item_adjust_clock_automatically, $get_item_acquired_software_id_a, $get_item_acquired_software_title_a, $get_item_acquired_software_notes_a, $get_item_acquired_software_id_b, $get_item_acquired_software_title_b, $get_item_acquired_software_notes_b, $get_item_acquired_software_id_c, $get_item_acquired_software_title_c, $get_item_acquired_software_notes_c, $get_item_acquired_date, $get_item_acquired_time, $get_item_acquired_date_saying, $get_item_acquired_date_ddmmyy, $get_item_acquired_user_id, $get_item_acquired_user_name, $get_item_acquired_user_alias, $get_item_acquired_user_email, $get_item_acquired_user_image_path, $get_item_acquired_user_image_file, $get_item_acquired_user_image_thumb_40, $get_item_acquired_user_image_thumb_50, $get_item_acquired_user_first_name, $get_item_acquired_user_middle_name, $get_item_acquired_user_last_name, $get_item_out_date, $get_item_out_time, $get_item_out_date_saying, $get_item_out_date_ddmmyy, $get_item_out_notes) = $row;

					for($x=0;$x<$items_selected_array_size;$x++){
						if($get_item_id == "$items_selected_array[$x]"){

							if($inp_item_out_date_strlen == 10){
								$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
													item_out_date=$inp_item_out_date_mysql, 
													item_out_time=$inp_item_out_time_mysql, 
													item_out_date_saying=$inp_item_out_date_saying_mysql, 
													item_out_date_ddmmyy=$inp_item_out_date_ddmmyy_mysql
													WHERE item_id=$get_item_id AND item_case_id=$get_current_case_id") or die(mysqli_error($link));


							}
							else{
								$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
													item_out_date=NULL, 
													item_out_time=NULL, 
													item_out_date_saying=NULL, 
													item_out_date_ddmmyy=NULL
													WHERE item_id=$get_item_id AND item_case_id=$get_current_case_id") or die(mysqli_error($link));
							}

							$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
												item_out_notes=$inp_item_out_notes_mysql 
												WHERE item_id=$get_item_id AND item_case_id=$get_current_case_id") or die(mysqli_error($link));


							
							// Storage
							if($inp_storage_location_id == "" OR $inp_storage_shelf_id == ""){

								$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
													item_storage_location_id=NULL,
													item_storage_location_abbr=NULL,
													item_storage_shelf_id=NULL,
													item_storage_shelf_title=NULL
													 WHERE item_id=$get_item_id") or die(mysqli_error($link));
							}
							else{
								$inp_storage_location_id_mysql = quote_smart($link, $inp_storage_location_id);
								$inp_storage_location_abbr_mysql = quote_smart($link, $inp_storage_location_abbr);
								$inp_storage_shelf_id_mysql = quote_smart($link, $inp_storage_shelf_id);
								$inp_storage_shelf_title_mysql = quote_smart($link, $inp_storage_shelf_title);

								$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items SET 
													item_storage_location_id=$inp_storage_location_id_mysql, 
													item_storage_location_abbr=$inp_storage_location_abbr_mysql,
													item_storage_shelf_id=$inp_storage_shelf_id_mysql, 
													item_storage_shelf_title=$inp_storage_shelf_title_mysql
													 WHERE item_id=$get_item_id") or die(mysqli_error($link));
							}
						} // item selected 
					} // for items_selected

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
			<div style=\"float: left;\">
				<h2>$l_selected_items</h2>
				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
					<span>$l_record</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_item</span>
				   </th>
				  </tr>
				 </thead>
				 <tbody>
			";
			$items_selected_array = explode(",", $items_selected);
			$items_selected_array_size = sizeof($items_selected_array);
			
			$transfer_item_out_date = "";
			$transfer_item_out_notes = "";

			$transfer_item_storage_shelf_id = "";
			$transfer_item_storage_shelf_title = "";
			$transfer_item_storage_location_id = "";
			$transfer_item_storage_location_abbr = "";


			$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_in_date_ddmmyyyy, item_storage_shelf_id, item_storage_shelf_title, item_storage_location_id, item_storage_location_abbr, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_timezone, item_date_now_date, item_date_now_saying, item_date_now_ddmmyy, item_date_now_ddmmyyyy, item_time_now, item_correct_date_now_date, item_correct_date_now_saying, item_correct_date_now_ddmmyy, item_correct_date_now_ddmmyyyy, item_correct_time_now, item_adjust_clock_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_date_ddmmyyyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy, item_out_date_ddmmyyyy, item_out_notes FROM $t_edb_case_index_evidence_items WHERE item_case_id=$get_current_case_id ORDER BY item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_item_id, $get_item_case_id, $get_item_record_id, $get_item_record_seized_year, $get_item_record_seized_journal, $get_item_record_seized_district_number, $get_item_numeric_serial_number, $get_item_title, $get_item_type_id, $get_item_type_title, $get_item_confirmed_by_human, $get_item_human_rejected, $get_item_request_text, $get_item_requester_user_id, $get_item_requester_user_name, $get_item_requester_user_alias, $get_item_requester_user_email, $get_item_requester_user_image_path, $get_item_requester_user_image_file, $get_item_requester_user_image_thumb_40, $get_item_requester_user_image_thumb_50, $get_item_requester_user_first_name, $get_item_requester_user_middle_name, $get_item_requester_user_last_name, $get_item_requester_user_job_title, $get_item_requester_user_department, $get_item_in_datetime, $get_item_in_date, $get_item_in_time, $get_item_in_date_saying, $get_item_in_date_ddmmyy, $get_item_in_date_ddmmyyyy, $get_item_storage_shelf_id, $get_item_storage_shelf_title, $get_item_storage_location_id, $get_item_storage_location_abbr, $get_item_comment, $get_item_condition, $get_item_serial_number, $get_item_imei_a, $get_item_imei_b, $get_item_imei_c, $get_item_imei_d, $get_item_os_title, $get_item_os_version, $get_item_timezone, $get_item_date_now_date, $get_item_date_now_saying, $get_item_date_now_ddmmyy, $get_item_date_now_ddmmyyyy, $get_item_time_now, $get_item_correct_date_now_date, $get_item_correct_date_now_saying, $get_item_correct_date_now_ddmmyy, $get_item_correct_date_now_ddmmyyyy, $get_item_correct_time_now, $get_item_adjust_clock_automatically, $get_item_acquired_software_id_a, $get_item_acquired_software_title_a, $get_item_acquired_software_notes_a, $get_item_acquired_software_id_b, $get_item_acquired_software_title_b, $get_item_acquired_software_notes_b, $get_item_acquired_software_id_c, $get_item_acquired_software_title_c, $get_item_acquired_software_notes_c, $get_item_acquired_date, $get_item_acquired_time, $get_item_acquired_date_saying, $get_item_acquired_date_ddmmyy, $get_item_acquired_date_ddmmyyyy, $get_item_acquired_user_id, $get_item_acquired_user_name, $get_item_acquired_user_alias, $get_item_acquired_user_email, $get_item_acquired_user_image_path, $get_item_acquired_user_image_file, $get_item_acquired_user_image_thumb_40, $get_item_acquired_user_image_thumb_50, $get_item_acquired_user_first_name, $get_item_acquired_user_middle_name, $get_item_acquired_user_last_name, $get_item_out_date, $get_item_out_time, $get_item_out_date_saying, $get_item_out_date_ddmmyy, $get_item_out_date_ddmmyyyy, $get_item_out_notes) = $row;

				for($x=0;$x<$items_selected_array_size;$x++){
					if($get_item_id == "$items_selected_array[$x]"){
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
							<a href=\"open_case_evidence_view_record.php?case_id=$get_current_case_id&amp;record_id=$get_item_record_id&amp;l=$l\">$get_item_record_seized_year/$get_item_record_seized_journal-$get_item_record_seized_district_number</a>-<a href=\"open_case_evidence_edit_evidence_item_info.php?case_id=$get_current_case_id&amp;item_id=$get_item_id&amp;l=$l\">$get_item_numeric_serial_number</a></span>
						  </td>
						  <td class=\"$style\">
							<span>$get_item_title</span>
						  </td>
						</tr>
						";

						// Transfer
						$transfer_item_out_date = "$get_item_out_date";
						$transfer_item_out_notes = "$get_item_out_notes";
						$transfer_item_storage_shelf_id = "$get_item_storage_shelf_id";
						$transfer_item_storage_shelf_title = "$get_item_storage_shelf_title";
						$transfer_item_storage_location_id = "$get_item_storage_location_id";
						$transfer_item_storage_location_abbr = "$get_item_storage_location_abbr";

					} // item is selected
				} // for
			} // while items
			echo"
				 </tbody>
				</table>
			</div>

		<!-- List of all items -->


		<!-- With selected form ... -->
			<div style=\"float: left;margin-left: 40px;\">
				<h2>$l_with_selected...</h2>
				<form method=\"POST\" action=\"open_case_evidence_select_many.php?case_id=$get_current_case_id&amp;items_selected=$items_selected&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\" class=\"form\">
			
				<p>$l_out:<br />
				<input type=\"date\" name=\"inp_item_out_date\" value=\"$transfer_item_out_date\" size=\"6\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
				</p>

				<p>$l_out_notes:<br />
				<input type=\"text\" name=\"inp_item_out_notes\" value=\"$transfer_item_out_notes\" size=\"20\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
				</p>

				
				<p style=\"padding:0;\">$l_storage: (<a href=\"$root/_admin/index.php?open=edb&amp;page=evidence_storage_shelves&amp;editor_language=$l&amp;l=$l\" target=\"_blank\" class=\"small\">$l_edit</a>)<br />\n";
				if($transfer_item_storage_location_abbr != ""){
					$storage_value = "$transfer_item_storage_shelf_title ($transfer_item_storage_location_abbr)";
				}
				else{
					$storage_value = "$transfer_item_storage_shelf_title";
				}
				echo"<input type=\"text\" name=\"inp_storage\" id=\"inp_storage_autosearch\" value=\"$storage_value\" autocomplete=\"off\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
				</p>
	
				<!-- Storage Search script -->
					<script id=\"source\" language=\"javascript\" type=\"text/javascript\">
						\$(document).ready(function () {
							\$('#inp_storage_autosearch').keyup(function () {
								// getting the value that user typed
								var searchString    = $(\"#inp_storage_autosearch\").val();
								// forming the queryString
      								var data            = 'l=$l&q='+ searchString;
         
        							// if searchString is not empty
        							if(searchString) {	
        								// ajax call
            								\$.ajax({
                								type: \"GET\",
               									url: \"open_case_evidence_edit_evidence_item_item_jquery_search_for_storage_shelve.php\",
                								data: data,
										beforeSend: function(html) { // this happens before actual call
											\$(\"#autosearch_storage_search_results_show\").html(''); 
										},
               									success: function(html){
                    									\$(\"#autosearch_storage_search_results_show\").append(html);
              									}
            								});
       								}
        							return false;
            						});
         				   	});
					</script>
					<div id=\"autosearch_storage_search_results_show\"></div>
				<!-- //Storage Search script -->

				<p>
				<input type=\"submit\" value=\"$l_save_changes\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
				</p>
				</form>
			</div>
		<!-- //With selected form ... -->

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