<?php 
/**
*
* File: edb/open_case_evidence_edit_evidence_item_item_unlock_pattern_selecter.php
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
include("$root/_admin/_translations/site/$l/edb/ts_open_case_evidence_edit_evidence_item_info.php");
include("$root/_admin/_translations/site/$l/users/ts_users.php");

/*- Tables ---------------------------------------------------------------------------- */
$t_edb_case_index_usr_psw			= $mysqlPrefixSav . "edb_case_index_usr_psw";
$t_edb_case_index_evidence_items_passwords	= $mysqlPrefixSav . "edb_case_index_evidence_items_passwords";
$t_edb_item_types_available_passwords 		= $mysqlPrefixSav . "edb_item_types_available_passwords";
$t_edb_most_used_passwords 			= $mysqlPrefixSav . "edb_most_used_passwords";

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

if(isset($_GET['item_id'])) {
	$item_id = $_GET['item_id'];
	$item_id = strip_tags(stripslashes($item_id));
}
else{
	$item_id = "";
}
$item_id_mysql = quote_smart($link, $item_id);


if(isset($_GET['password_id'])) {
	$password_id = $_GET['password_id'];
	$password_id = strip_tags(stripslashes($password_id));
}
else{
	$password_id = "";
}
$password_id_mysql = quote_smart($link, $password_id);

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
			// Find that item
			$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_timezone, item_date_now_date, item_date_now_ddmmyy, item_time_now, item_correct_date_now_date, item_correct_date_now_ddmmyy, item_correct_time_now, item_adjust_clock_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy FROM $t_edb_case_index_evidence_items WHERE item_id=$item_id_mysql AND item_case_id=$get_current_case_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_item_id, $get_current_item_case_id, $get_current_item_record_id, $get_current_item_record_seized_year, $get_current_item_record_seized_journal, $get_current_item_record_seized_district_number, $get_current_item_numeric_serial_number, $get_current_item_title, $get_current_item_type_id, $get_current_item_type_title, $get_current_item_confirmed_by_human, $get_current_item_human_rejected, $get_current_item_request_text, $get_current_item_requester_user_id, $get_current_item_requester_user_name, $get_current_item_requester_user_alias, $get_current_item_requester_user_email, $get_current_item_requester_user_image_path, $get_current_item_requester_user_image_file, $get_current_item_requester_user_image_thumb_40, $get_current_item_requester_user_image_thumb_50, $get_current_item_requester_user_first_name, $get_current_item_requester_user_middle_name, $get_current_item_requester_user_last_name, $get_current_item_requester_user_job_title, $get_current_item_requester_user_department, $get_current_item_in_datetime, $get_current_item_in_date, $get_current_item_in_time, $get_current_item_in_date_saying, $get_current_item_in_date_ddmmyy, $get_current_item_comment, $get_current_item_condition, $get_current_item_serial_number, $get_current_item_imei_a, $get_current_item_imei_b, $get_current_item_imei_c, $get_current_item_imei_d, $get_current_item_os_title, $get_current_item_os_version, $get_current_item_timezone, $get_current_item_date_now_date, $get_current_item_date_now_ddmmyy, $get_current_item_time_now, $get_current_item_correct_date_now_date, $get_current_item_correct_date_now_ddmmyy, $get_current_item_correct_time_now, $get_current_item_adjust_clock_automatically, $get_current_item_acquired_software_id_a, $get_current_item_acquired_software_title_a, $get_current_item_acquired_software_notes_a, $get_current_item_acquired_software_id_b, $get_current_item_acquired_software_title_b, $get_current_item_acquired_software_notes_b, $get_current_item_acquired_software_id_c, $get_current_item_acquired_software_title_c, $get_current_item_acquired_software_notes_c, $get_current_item_acquired_date, $get_current_item_acquired_time, $get_current_item_acquired_date_saying, $get_current_item_acquired_date_ddmmyy, $get_current_item_acquired_user_id, $get_current_item_acquired_user_name, $get_current_item_acquired_user_alias, $get_current_item_acquired_user_email, $get_current_item_acquired_user_image_path, $get_current_item_acquired_user_image_file, $get_current_item_acquired_user_image_thumb_40, $get_current_item_acquired_user_image_thumb_50, $get_current_item_acquired_user_first_name, $get_current_item_acquired_user_middle_name, $get_current_item_acquired_user_last_name, $get_current_item_out_date, $get_current_item_out_time, $get_current_item_out_date_saying, $get_current_item_out_date_ddmmyy) = $row;
	

			if($get_current_item_id == ""){
				echo"<h1>Server error 404</h1><p>Record not found</p>";
				die;
			}
			else{
				// Find password
				$query_psw = "SELECT password_id, password_case_id, password_item_id, password_available_id, password_item_type_id, password_set_number, password_value, password_created_by_user_id, password_created_by_user_name, password_created_datetime, password_updated_by_user_id, password_updated_by_user_name, password_updated_datetime FROM $t_edb_case_index_evidence_items_passwords WHERE password_id=$password_id_mysql AND password_case_id=$get_current_case_id AND password_item_id=$get_current_item_id";
				$result_psw = mysqli_query($link, $query_psw);
				$row_psw = mysqli_fetch_row($result_psw);
				list($get_current_password_id, $get_current_password_case_id, $get_current_password_item_id, $get_current_password_available_id, $get_current_password_item_type_id, $get_current_password_set_number, $get_current_password_value, $get_current_password_created_by_user_id, $get_current_password_created_by_user_name, $get_current_password_created_datetime, $get_current_password_updated_by_user_id, $get_current_password_updated_by_user_name, $get_current_password_updated_datetime) = $row_psw;
	
				// Find avaible information
				if($get_current_password_available_id == ""){
					echo"<p style=\"color:red;\">get_current_password_available_id = $get_current_password_available_id</p>";
				}
				else{
					$query_avaible = "SELECT available_id, available_item_type_id, available_title, available_type, available_size, available_last_updated_datetime, available_last_updated_user_id FROM $t_edb_item_types_available_passwords WHERE available_id=$get_current_password_available_id";
					$result_avaible = mysqli_query($link, $query_avaible);
					$row_avaible = mysqli_fetch_row($result_avaible);
					list($get_current_available_id, $get_current_available_item_type_id, $get_current_available_title, $get_current_available_type, $get_current_available_size, $get_current_available_last_updated_datetime, $get_current_available_last_updated_user_id) = $row_avaible;
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
						<a href=\"open_case_evidence.php?case_id=$get_current_case_id&amp;page=$page&amp;l=$l\">$l_evidence</a>
						&gt;
						<a href=\"open_case_evidence_view_record.php?case_id=$get_current_case_id&amp;page=$page&amp;action=open_record&amp;year=$get_current_item_record_seized_year&amp;journal=$get_current_item_record_seized_journal&amp;district_number=$get_current_item_record_seized_district_number&amp;l=$l\">$get_current_item_record_seized_year/$get_current_item_record_seized_journal-$get_current_item_record_seized_district_number</a>
						&gt;
						<a href=\"open_case_evidence_edit_evidence_item_info.php?case_id=$get_current_case_id&amp;page=$page&amp;action=edit_evidence_item&amp;item_id=$get_current_item_id&amp;l=$l\">$get_current_item_numeric_serial_number</a>

						</p>
						<div style=\"height: 10px;\"></div>
					<!-- //Where am I? -->


					<!-- Case navigation -->
						";
						include("open_case_menu.php");
						echo"
					<!-- //Case navigation -->

					<h2>$get_current_item_record_seized_year/$get_current_item_record_seized_journal-$get_current_item_record_seized_district_number-$get_current_item_numeric_serial_number $get_current_item_title</h2>
			
			
					<!-- Edit item tabs -->
						<div class=\"clear\" style=\"height: 10px;\"></div>
						<div class=\"tabs\">
							<ul>
								<li><a href=\"open_case_evidence_edit_evidence_item_info.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;l=$l\""; if($mode == ""){ echo" class=\"active\""; } echo">$l_info</a></li>
								<li><a href=\"open_case_evidence_edit_evidence_item_request.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;mode=request&amp;l=$l\""; if($mode == "request"){ echo" class=\"active\""; } echo">$l_request</a></li>
								<li><a href=\"open_case_evidence_edit_evidence_item_item.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;mode=item&amp;l=$l\""; if($mode == "item"){ echo" class=\"active\""; } echo">$l_item</a></li>
								<li><a href=\"open_case_evidence_edit_evidence_item_acquire.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;mode=acquire&amp;l=$l\""; if($mode == "acquire"){ echo" class=\"active\""; } echo">$l_acquire</a></li>
							</ul>
						</div>
						<div class=\"clear\" style=\"height: 10px;\"></div>
					<!-- Edit item tabs -->
	
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
					";
				} // process != 1


				if($action == ""){
					if($process == "1"){
						// Dates
						$datetime = date("Y-m-d H:i:s");
						$date_saying = date("j. M Y");
						$time = time();
						$inp_my_user_name_mysql = quote_smart($link, $get_my_station_member_user_name);


						$inp_password_value = $_POST["inp_password_value"];
						$inp_password_value = output_html($inp_password_value);
						$inp_password_value_mysql = quote_smart($link, $inp_password_value);

						
						$result = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items_passwords SET 
										password_value=$inp_password_value_mysql,
										password_updated_by_user_id=$my_user_id_mysql, 
										password_updated_by_user_name=$inp_my_user_name_mysql, 
										password_updated_datetime='$datetime'
										WHERE password_id=$get_current_password_id") or die(mysqli_error($link));


						if($inp_password_value != "$get_current_password_value"){
							
							// Most used passwords
	  						$inp_available_title_mysql = quote_smart($link, $get_current_available_title);
	   						$inp_available_title_clean = clean($get_current_available_title);
	  						$inp_available_title_clean_mysql = quote_smart($link, $inp_available_title_clean);

							// Most used passwords
							$query_most = "SELECT password_id, password_count FROM $t_edb_most_used_passwords WHERE password_available_id=$get_current_available_id AND password_item_type_id=$get_current_available_item_type_id AND password_pass=$inp_password_value_mysql";
							$result_most = mysqli_query($link, $query_most);
							$row_most = mysqli_fetch_row($result_most);
							list($get_password_id, $get_password_count) = $row_most;
							if($get_password_id == ""){
								mysqli_query($link, "INSERT INTO $t_edb_most_used_passwords 
								(password_id, password_available_id, password_available_title, password_available_title_clean, password_item_type_id, password_pass, password_count, password_first_used_datetime, password_first_used_time, password_first_used_saying, password_last_used_datetime, password_last_used_time, password_last_used_saying) 
								VALUES 
								(NULL, $get_current_available_id, $inp_available_title_mysql, $inp_available_title_clean_mysql, $get_current_available_item_type_id, $inp_password_value_mysql, 1, '$datetime', '$time', '$date_saying', '$datetime', '$time', '$date_saying')")
								or die(mysqli_error($link));
							}
							else{
								$inp_password_count = $get_password_count+1;
								$result_update = mysqli_query($link, "UPDATE $t_edb_most_used_passwords SET password_available_title=$inp_available_title_mysql, password_available_title_clean=$inp_available_title_clean_mysql, password_count=$inp_password_count, password_last_used_datetime='$datetime', password_last_used_time='$time', password_last_used_saying='$date_saying' WHERE password_id=$get_password_id") or die(mysqli_error($link));
							}
						}


	

						/*
						// Look for connection to username/password
						$query_usr_psw = "SELECT usr_psw_id, usr_psw_case_id, usr_psw_related_to_text, usr_psw_item_id, usr_psw_record_id, usr_psw_review_matrix_item_id, usr_psw_domain, usr_psw_login_user, usr_psw_login_password, usr_psw_startup_password, usr_psw_screen_lock, usr_psw_pin, usr_psw_unlock_pattern, usr_psw_decrypt_password, usr_psw_bios_password, usr_psw_reset_to_a, usr_psw_reset_to_b, usr_psw_tag_a, usr_psw_tag_b, usr_psw_tag_c, usr_psw_tag_d, usr_psw_updated_datetime, usr_psw_updated_user_id, usr_psw_updated_user_name FROM $t_edb_case_index_usr_psw WHERE usr_psw_case_id=$get_current_case_id AND usr_psw_item_id=$get_current_item_id";
						$result_usr_psw = mysqli_query($link, $query_usr_psw);
						$row_usr_psw = mysqli_fetch_row($result_usr_psw);
						list($get_usr_psw_id, $get_usr_psw_case_id, $get_usr_psw_related_to_text, $get_usr_psw_item_id, $get_usr_psw_record_id, $get_usr_psw_review_matrix_item_id, $get_usr_psw_domain, $get_usr_psw_login_user, $get_usr_psw_login_password, $get_usr_psw_startup_password, $get_usr_psw_screen_lock, $get_usr_psw_pin, $get_usr_psw_unlock_pattern, $get_usr_psw_decrypt_password, $get_usr_psw_bios_password, $get_usr_psw_reset_to_a, $get_usr_psw_reset_to_b, $get_usr_psw_tag_a, $get_usr_psw_tag_b, $get_usr_psw_tag_c, $get_usr_psw_tag_d, $get_usr_psw_updated_datetime, $get_usr_psw_updated_user_id, $get_usr_psw_updated_user_name) = $row_usr_psw;
						
						if($get_usr_psw_id != "" && $inp_domain != "$get_usr_psw_unlock_pattern"){
							$result = mysqli_query($link, "UPDATE $t_edb_case_index_usr_psw SET 
									usr_psw_unlock_pattern=$inp_unlock_pattern_mysql 
									 WHERE usr_psw_id=$get_usr_psw_id") or die(mysqli_error($link));

						}
						*/

						// Send password to API
						include("open_case_evidence_edit_evidence_item_item_ping_new_passwords.php");
					
						$time = date("H:i:s");
						$url = "open_case_evidence_edit_evidence_item_item_unlock_pattern_selecter.php?case_id=$get_current_case_id&item_id=$get_current_item_id&mode=item&l=$l&password_id=$get_current_password_id&ft=success&fm=changes_saved_$time";
						header("Location: $url");
						exit;
					}

					echo"
					<h2>$l_unlock_pattern</h2>

					<p><b>$l_actions:</b><br />
					<a href=\"open_case_evidence_edit_evidence_item_item_unlock_pattern_selecter.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;password_id=$get_current_password_id&amp;action=clear&amp;l=$l&amp;process=1\">$l_clear</a>
					</p>


						<table>
						 <tr>
						  <td style=\"vertical-align: top;padding-right: 10px;\">
							<!-- 3x3 -->
						<p><b>$l_draw_pattern:</b></p>
						<table>";

						$unlock_pattern_array = explode("-", $get_current_password_value);
						$unlock_pattern_array_size = sizeof($unlock_pattern_array);
						

						$i = 1;
						$found_counter = 1;
						for($x=1;$x<4;$x++){
							echo"
							 <tr>
							";
							for($y=1;$y<4;$y++){
								echo"
								  <td style=\"padding: 10px 10px 10px 10px;text-align:center;\">
									<span><a href=\"#\" class=\"tags_select\" data-divid=\"$i\">";
									
									// Check if this is part of the array
									$found = false;
									for($z=1;$z<$unlock_pattern_array_size+1;$z++){
										$z_minus_one = $z-1;
										if($i == "$unlock_pattern_array[$z_minus_one]"){
											echo"$z";
											$found = true;
											$found_counter = $found_counter+1;
											break;
										}
									}
									if($found == false){
										echo"O";
									}

									echo"</a></span>
								  </td>
								";
								$i = $i+1;
							}
							echo"
							 </tr>	
							";
						}
						echo"
						</table>

					<!-- Javascript on click add text to text input -->
							<script type=\"text/javascript\">
							\$(function() {
								\$('.tags_select').click(function() {
									var clicked_number = \$(this).data('divid');
									var exiting_data = \$('#inp_unlock_pattern').val();

									if(exiting_data == ''){ // or this.value == 'volvo'
	            								\$('#inp_unlock_pattern').val(clicked_number);
									}
									else{
	            								\$('#inp_unlock_pattern').val(exiting_data + \"-\" + clicked_number);
									}

									// Update image
									var pattner_now =\$('#inp_unlock_pattern').val();
									\$(\"#drawer_to_image\").attr(\"src\",\"most_used_passwords_unlock_pattern_drawer_to_image.php?pattern=\" + pattner_now);

									// Remember to save
									\$('#remember_to_save').css('display', 'block');

            								return false;
       								});
    							});
							</script>
						<!-- //Javascript on click add text to text input -->
					<!-- //3x3 -->	

						  </td>
						  <td style=\"vertical-align: top;\">
							<p>";
							if($get_current_password_value != ""){
								echo"<img src=\"most_used_passwords_unlock_pattern_drawer_to_image.php?pattern=$get_current_password_value\" id=\"drawer_to_image\" alt=\"$get_current_password_value\" />";
							}
							else{
								echo"<img src=\"_gfx/spacer.png\" id=\"drawer_to_image\" alt=\"$get_current_password_value\" />";
							}
							echo"
							</p>
						  </td>
						 </tr>
						</table>
						<div class=\"info\" id=\"remember_to_save\" style=\"display:none;width:200px\"><p>$l_remember_to_save</p></div>

					<form method=\"POST\" action=\"open_case_evidence_edit_evidence_item_item_unlock_pattern_selecter.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;password_id=$get_current_password_id&amp;mode=$mode&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

					<p><b>$l_pattern:</b><br />
					<input type=\"text\" name=\"inp_password_value\" id=\"inp_unlock_pattern\" size=\"25\" value=\"$get_current_password_value\"  tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
					</p>
			
					<p>
					<input type=\"submit\" value=\"$l_save_changes\" id=\"submit_save_changes\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
					</p>
					</form>

					";
				} // action == ""
				elseif($action == "clear"){
					$inp_my_user_name_mysql = quote_smart($link, $get_my_station_member_user_name);
					$datetime = date("Y-m-d H:i:s");
	
					$result = mysqli_query($link, "UPDATE $t_edb_case_index_evidence_items_passwords SET 
										password_value=NULL,
										password_updated_by_user_id=$my_user_id_mysql, 
										password_updated_by_user_name=$inp_my_user_name_mysql, 
										password_updated_datetime='$datetime'
										WHERE password_id=$get_current_password_id") or die(mysqli_error($link));

					$url = "open_case_evidence_edit_evidence_item_item_unlock_pattern_selecter.php?case_id=$get_current_case_id&item_id=$get_current_item_id&password_id=$get_current_password_id&l=$l&ft=success&fm=pattern_cleared";
					header("Location: $url");
					exit;
				}
			} // item found

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