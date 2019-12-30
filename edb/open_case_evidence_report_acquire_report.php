<?php 
/**
*
* File: edb/open_case_report.php
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

if(isset($_GET['report_id'])) {
	$report_id = $_GET['report_id'];
	$report_id = strip_tags(stripslashes($report_id));
}
else{
	$report_id = "";
}
$report_id_mysql = quote_smart($link, $report_id);


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
		// Find report
		$query = "SELECT report_id, report_title, report_title_clean, report_logo_path, report_logo_file, report_type FROM $t_edb_case_reports WHERE report_id=$report_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_report_id, $get_current_report_title, $get_current_report_title_clean, $get_current_report_logo_path, $get_current_report_logo_file, $get_current_report_type) = $row;
	

		if($get_current_report_id == ""){
			echo"<h1>Server error 404</h1><p>Report not found</p>";
			die;
		}
		else{

			/*- Headers ---------------------------------------------------------------------------------- */
			$website_title = "$l_edb - $get_current_case_district_title - $get_current_case_station_title - $get_current_case_number - $get_current_report_title";
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
				// Me
				$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_id=$my_user_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_language, $get_my_user_last_online, $get_my_user_rank, $get_my_user_login_tries) = $row;
					
				// My Profile
				$query = "SELECT profile_id, profile_first_name, profile_middle_name, profile_last_name, profile_about FROM $t_users_profile WHERE profile_user_id=$get_my_user_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_my_profile_id, $get_my_profile_first_name, $get_my_profile_middle_name, $get_my_profile_last_name, $get_my_profile_about) = $row;

				// My professional
				$query = "SELECT professional_id, professional_user_id, professional_company, professional_company_location, professional_department, professional_work_email, professional_position, professional_position_abbr, professional_district FROM $t_users_professional WHERE professional_user_id=$get_my_user_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_my_professional_id, $get_my_professional_user_id, $get_my_professional_company, $get_my_professional_company_location, $get_my_professional_department, $get_my_professional_work_email, $get_my_professional_position, $get_my_professional_position_abbr, $get_my_professional_district) = $row;


				if($action == ""){
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


					<h2>$l_evidence $get_current_report_title</h2>
				
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
						<form method=\"get\" action=\"open_case_evidence_report_acquire_report.php\" enctype=\"multipart/form-data\">
						<input type=\"hidden\" name=\"case_id\" value=\"$get_current_case_id\" />
						<input type=\"hidden\" name=\"report_id\" value=\"$get_current_report_id\" />
						<input type=\"hidden\" name=\"action\" value=\"generate\" />
						<input type=\"hidden\" name=\"l\" value=\"$l\" />
						<input type=\"hidden\" name=\"process\" value=\"1\" />
						<table class=\"hor-zebra\">
						 <thead>
						  <tr>
						   <th scope=\"col\">
							<span>$l_include</span>
						   </th>
						   <th scope=\"col\">
							<span>$l_record</span>
						   </th>
						   <th scope=\"col\">
							<span>$l_item</span>
						   </th>
						   <th scope=\"col\">
							<span>$l_type</span>
						   </th>
						  </tr>
						 </thead>
						 <tbody>
						";
						$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_in_date_ddmmyyyy, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_timezone, item_date_now_date, item_date_now_saying, item_date_now_ddmmyy, item_date_now_ddmmyyyy, item_time_now, item_correct_date_now_date, item_correct_date_now_saying, item_correct_date_now_ddmmyy, item_correct_date_now_ddmmyyyy, item_correct_time_now, item_adjust_clock_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_date_ddmmyyyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy, item_out_date_ddmmyyyy FROM $t_edb_case_index_evidence_items WHERE item_case_id=$get_current_case_id ORDER BY item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_item_id, $get_item_case_id, $get_item_record_id, $get_item_record_seized_year, $get_item_record_seized_journal, $get_item_record_seized_district_number, $get_item_numeric_serial_number, $get_item_title, $get_item_type_id, $get_item_type_title, $get_item_confirmed_by_human, $get_item_human_rejected, $get_item_request_text, $get_item_requester_user_id, $get_item_requester_user_name, $get_item_requester_user_alias, $get_item_requester_user_email, $get_item_requester_user_image_path, $get_item_requester_user_image_file, $get_item_requester_user_image_thumb_40, $get_item_requester_user_image_thumb_50, $get_item_requester_user_first_name, $get_item_requester_user_middle_name, $get_item_requester_user_last_name, $get_item_requester_user_job_title, $get_item_requester_user_department, $get_item_in_datetime, $get_item_in_date, $get_item_in_time, $get_item_in_date_saying, $get_item_in_date_ddmmyy, $get_item_in_date_ddmmyyyy, $get_item_comment, $get_item_condition, $get_item_serial_number, $get_item_imei_a, $get_item_imei_b, $get_item_imei_c, $get_item_imei_d, $get_item_os_title, $get_item_os_version, $get_item_timezone, $get_item_date_now_date, $get_item_date_now_saying, $get_item_date_now_ddmmyy, $get_item_date_now_ddmmyyyy, $get_item_time_now, $get_item_correct_date_now_date, $get_item_correct_date_now_saying, $get_item_correct_date_now_ddmmyy, $get_item_correct_date_now_ddmmyyyy, $get_item_correct_time_now, $get_item_adjust_clock_automatically, $get_item_acquired_software_id_a, $get_item_acquired_software_title_a, $get_item_acquired_software_notes_a, $get_item_acquired_software_id_b, $get_item_acquired_software_title_b, $get_item_acquired_software_notes_b, $get_item_acquired_software_id_c, $get_item_acquired_software_title_c, $get_item_acquired_software_notes_c, $get_item_acquired_date, $get_item_acquired_time, $get_item_acquired_date_saying, $get_item_acquired_date_ddmmyy, $get_item_acquired_date_ddmmyyyy, $get_item_acquired_user_id, $get_item_acquired_user_name, $get_item_acquired_user_alias, $get_item_acquired_user_email, $get_item_acquired_user_image_path, $get_item_acquired_user_image_file, $get_item_acquired_user_image_thumb_40, $get_item_acquired_user_image_thumb_50, $get_item_acquired_user_first_name, $get_item_acquired_user_middle_name, $get_item_acquired_user_last_name, $get_item_out_date, $get_item_out_time, $get_item_out_date_saying, $get_item_out_date_ddmmyy, $get_item_out_date_ddmmyyyy) = $row;

							if(isset($style) && $style == ""){
								$style = "odd";
							}
							else{
								$style = "";
							}

							echo"
							<tr>
							  <td class=\"$style\">
								<span><input type=\"checkbox\" name=\"inp_include_$get_item_id\" checked=\"checked\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" /></span>
							  </td>
							  <td class=\"$style\">
								<span><a href=\"open_case_evidence_view_record.php?case_id=$get_current_case_id&amp;record_id=$get_item_record_id&amp;l=$l\">$get_item_record_seized_year/$get_item_record_seized_journal-$get_item_record_seized_district_number</a>-<a href=\"open_case_evidence_edit_evidence_item_info.php?case_id=$get_current_case_id&amp;item_id=$get_item_id&amp;l=$l\">$get_item_numeric_serial_number</a></span>
							  </td>
						 	  <td class=\"$style\">
								<span>$get_item_title</span>
							  </td>
							  <td class=\"$style\">
								<span>$get_item_type_title</span>
							  </td>
							</tr>
						";
						} // while items
					
						echo"
						 </tbody>
						</table>
			

						<p>
						<input type=\"submit\" value=\"$l_generate_report\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
						</p>
						</form>
					";
				} // action == ""
				elseif($action == "generate"){
					// Start file
					$write_to_doc_header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' \"+
\"xmlns:w='urn:schemas-microsoft-com:office:word' \"+
\"xmlns='http://www.w3.org/TR/REC-html40'>\"+
\"<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
					$write_to_doc = "";

					// Get all evidence that shall be in report

					$array_item_id[] = array();
					$array_item_request_text[] = array();
					$array_item_in_date_ddmmyy[] = array();
					$array_item_requester_user_job_title[] = array();
					$array_item_requester_user_first_name[] = array();
					$array_item_requester_user_middle_name[] = array();
					$array_item_requester_user_last_name[] = array();
					$array_item_requester_user_department[] = array();
					
					$array_item_condition[] = array();

					$array_item_record_seized_year[] = array();
					$array_item_record_seized_journal[] = array();
					$array_item_record_seized_district_number[] = array();
					$array_item_numeric_serial_number[] = array();
					$array_item_title[] = array();
					$array_item_acquired_date_ddmmyy[] = array();

					$array_item_acquired_software_id_a[] = array();
					$array_item_acquired_software_id_b[] = array();
					$array_item_acquired_software_id_c[] = array();

					$array_item_timezone[] = array();
					$array_item_date_now_ddmmyy[] = array();
					$array_item_time_now[] = array();
					$array_item_correct_date_now_ddmmyy[] = array();
					$array_item_correct_time_now[] = array();
					$array_item_adjust_clock_automatically[] = array();

					$array_item_imei[][] = array();


					$array_item_type_id[] = array();
					$array_item_type_has_hard_disks[] = array();
					$array_item_type_terms[] = array(); // Contains all terms, so if we have 2 cellphones the same terms will be twice

					// tmp dir
					$datetime = date("ymdhis");
					$cache_terms_dir = $get_current_case_number . "_terms_" . $datetime;
					if(!(is_dir("../_cache/$cache_terms_dir"))){
						mkdir("../_cache/$cache_terms_dir");
					}

					$cache_software_dir = $get_current_case_number . "_software_" . $datetime;
					if(!(is_dir("../_cache/$cache_software_dir"))){
						mkdir("../_cache/$cache_software_dir");
					}

					$x = 0;
					$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_in_date_ddmmyyyy, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_timezone, item_date_now_date, item_date_now_saying, item_date_now_ddmmyy, item_date_now_ddmmyyyy, item_time_now, item_correct_date_now_date, item_correct_date_now_saying, item_correct_date_now_ddmmyy, item_correct_date_now_ddmmyyyy, item_correct_time_now, item_adjust_clock_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_date_ddmmyyyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy, item_out_date_ddmmyyyy FROM $t_edb_case_index_evidence_items WHERE item_case_id=$get_current_case_id ORDER BY item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_item_id, $get_item_case_id, $get_item_record_id, $get_item_record_seized_year, $get_item_record_seized_journal, $get_item_record_seized_district_number, $get_item_numeric_serial_number, $get_item_title, $get_item_type_id, $get_item_type_title, $get_item_confirmed_by_human, $get_item_human_rejected, $get_item_request_text, $get_item_requester_user_id, $get_item_requester_user_name, $get_item_requester_user_alias, $get_item_requester_user_email, $get_item_requester_user_image_path, $get_item_requester_user_image_file, $get_item_requester_user_image_thumb_40, $get_item_requester_user_image_thumb_50, $get_item_requester_user_first_name, $get_item_requester_user_middle_name, $get_item_requester_user_last_name, $get_item_requester_user_job_title, $get_item_requester_user_department, $get_item_in_datetime, $get_item_in_date, $get_item_in_time, $get_item_in_date_saying, $get_item_in_date_ddmmyy, $get_item_in_date_ddmmyyyy, $get_item_comment, $get_item_condition, $get_item_serial_number, $get_item_imei_a, $get_item_imei_b, $get_item_imei_c, $get_item_imei_d, $get_item_os_title, $get_item_os_version, $get_item_timezone, $get_item_date_now_date, $get_item_date_now_saying, $get_item_date_now_ddmmyy, $get_item_date_now_ddmmyyyy, $get_item_time_now, $get_item_correct_date_now_date, $get_item_correct_date_now_saying, $get_item_correct_date_now_ddmmyy, $get_item_correct_date_now_ddmmyyyy, $get_item_correct_time_now, $get_item_adjust_clock_automatically, $get_item_acquired_software_id_a, $get_item_acquired_software_title_a, $get_item_acquired_software_notes_a, $get_item_acquired_software_id_b, $get_item_acquired_software_title_b, $get_item_acquired_software_notes_b, $get_item_acquired_software_id_c, $get_item_acquired_software_title_c, $get_item_acquired_software_notes_c, $get_item_acquired_date, $get_item_acquired_time, $get_item_acquired_date_saying, $get_item_acquired_date_ddmmyy, $get_item_acquired_date_ddmmyyyy, $get_item_acquired_user_id, $get_item_acquired_user_name, $get_item_acquired_user_alias, $get_item_acquired_user_email, $get_item_acquired_user_image_path, $get_item_acquired_user_image_file, $get_item_acquired_user_image_thumb_40, $get_item_acquired_user_image_thumb_50, $get_item_acquired_user_first_name, $get_item_acquired_user_middle_name, $get_item_acquired_user_last_name, $get_item_out_date, $get_item_out_time, $get_item_out_date_saying, $get_item_out_date_ddmmyy, $get_item_out_date_ddmmyyyy) = $row;
						
						if(isset($_GET["inp_include_$get_item_id"])){
							$inp_include_check = $_GET["inp_include_$get_item_id"];
							if($inp_include_check == "on"){
								$array_item_id[$x] = "$get_item_id";

								// Request
								$array_item_request_text[$x] = "$get_item_request_text";
								$array_item_in_date_ddmmyy[$x] = "$get_item_in_date_ddmmyy";
								$array_item_requester_user_job_title[$x] = "$get_item_requester_user_job_title"; 
								$array_item_requester_user_first_name[$x] = "$get_item_requester_user_first_name";
								$array_item_requester_user_middle_name[$x] = "$get_item_requester_user_middle_name";
								$array_item_requester_user_last_name[$x] = "$get_item_requester_user_last_name";
								$array_item_requester_user_department[$x] = "$get_item_requester_user_department";

								// Evidence for investigation 
								$array_item_record_seized_year[$x] = "$get_item_record_seized_year";
								$array_item_record_seized_journal[$x] = "$get_item_record_seized_journal";
								$array_item_record_seized_district_number[$x] = "$get_item_record_seized_district_number";
								$array_item_numeric_serial_number[$x] = "$get_item_numeric_serial_number";
								$array_item_title[$x] = "$get_item_title";
								$array_item_acquired_date_ddmmyy[$x] = "$get_item_acquired_date_ddmmyy";

								$array_item_condition[$x] = "$get_item_condition";

								// Acquire
								$array_item_acquired_software_id_a[$x] = "$get_item_acquired_software_id_a";
								$array_item_acquired_software_id_b[$x] = "$get_item_acquired_software_id_b";
								$array_item_acquired_software_id_c[$x] = "$get_item_acquired_software_id_c";

								// Time 
								$array_item_timezone[$x] = "$get_item_timezone";
								$array_item_date_now_ddmmyy[$x] = "$get_item_date_now_ddmmyy";
								$array_item_time_now[$x] = "$get_item_time_now";
								$array_item_correct_date_now_ddmmyy[$x] = "$get_item_correct_date_now_ddmmyy";
								$array_item_correct_time_now[$x] = "$get_item_correct_time_now";
								$array_item_adjust_clock_automatically[$x] = "$get_item_adjust_clock_automatically";

								// Item type
								$array_item_type_id[$x] = "$get_item_type_id";
								$array_item_type_has_hard_disks[$x] = "";
								if($get_item_type_id != ""){
									$query_b = "SELECT item_type_id, item_type_title, item_type_image_path, item_type_image_file, item_type_has_hard_disks, item_type_has_sim_cards, item_type_has_sd_cards, item_type_has_networks, item_type_terms FROM $t_edb_item_types WHERE item_type_id=$get_item_type_id";
									$result_b = mysqli_query($link, $query_b);
									$row_b = mysqli_fetch_row($result_b);
									list($get_current_item_type_id, $get_current_item_type_title, $get_current_item_type_image_path, $get_current_item_type_image_file, $get_current_item_type_has_hard_disks, $get_current_item_type_has_sim_cards, $get_current_item_type_has_sd_cards, $get_current_item_type_has_networks, $get_current_item_type_terms) = $row_b;
									$array_item_type_has_hard_disks[$x] = "$get_current_item_type_has_hard_disks";
									$array_item_type_terms[$x] = "$get_current_item_type_terms";

									// Write the item type to tmp folder
									$cache_term_file = md5("$get_current_item_type_terms");
									if(!(file_exists("../_cache/$cache_terms_dir/$cache_term_file.html"))){

								
										$input_term = str_replace('<p>', '<p style="font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;">', $array_item_type_terms[$x]);
										$input_term = "
$input_term";

										$fh = fopen("../_cache/$cache_terms_dir/$cache_term_file.html", "w+") or die("can not open file");
										fwrite($fh, $input_term);
										fclose($fh);

								
									}

								}

								// IMEI
								$imei_counter = 0;
								$query_imei = "SELECT sim_card_id, sim_card_case_id, sim_card_record_id, sim_card_item_id, sim_card_imei, sim_card_iccid, sim_card_imsi, sim_card_phone_number, sim_card_pin, sim_card_puc, sim_card_operator, sim_card_comments FROM $t_edb_case_index_evidence_items_sim_cards WHERE sim_card_case_id=$get_current_case_id AND sim_card_item_id=$get_item_id";
								$result_imei = mysqli_query($link, $query_imei);
								while($row_imei = mysqli_fetch_row($result_imei)) {
									list($get_sim_card_id, $get_sim_card_case_id, $get_sim_card_record_id, $get_sim_card_item_id, $get_sim_card_imei, $get_sim_card_iccid, $get_sim_card_imsi, $get_sim_card_phone_number, $get_sim_card_pin, $get_sim_card_puc, $get_sim_card_operator, $get_sim_card_comments) = $row_imei;
									$array_item_imei[$x][$imei_counter] = "$get_sim_card_imei";


									$imei_counter = $imei_counter+1;
								}


								// Software saying
								if($get_item_acquired_software_id_a != ""){
									$query_soft = "SELECT software_id, software_title, software_version, software_used_for, software_description, software_report_text, software_image_path, software_image_file FROM $t_edb_software_index WHERE software_id=$get_item_acquired_software_id_a";
									$result_soft = mysqli_query($link, $query_soft);
									$row_soft = mysqli_fetch_row($result_soft);
									list($get_software_id, $get_software_title, $get_software_version, $get_software_used_for, $get_software_description, $get_software_report_text, $get_software_image_path, $get_software_image_file) = $row_soft;
		
									// Write the item type to tmp folder
									$cache_software_file = clean($get_software_title);
									if(!(file_exists("../_cache/$cache_software_dir/$cache_software_file.html"))){

				
										$get_software_report_text = str_replace('<p>', '', $get_software_report_text);
										$get_software_report_text = str_replace('</p>', '', $get_software_report_text);
										$input_software = "<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;\"><b>$get_software_title</b><br />
$get_software_report_text
</p>";

										$fh = fopen("../_cache/$cache_software_dir/$cache_software_file.html", "w+") or die("can not open file");
										fwrite($fh, $input_software);
										fclose($fh);
									}
								}

								$x++;
							}
						}

					}


					echo"<!DOCTYPE html>\n";
					echo"<html lang=\"$l\">\n";
					echo"<head>\n";
					echo"	<title>$get_current_report_title - $l_case $get_current_case_number</title>\n";
					echo"	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
					echo"</head>\n";
					echo"<body>\n";

					

					$write_to_doc = $write_to_doc . "

					<!-- Assignment -->
						<h1 style=\"font: bold 24px Arial,Helvetica,sans-serif;\">$l_assignment</h1>

							<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;\">
							$l_in_request_for_laboratory_examination_the $array_item_in_date_ddmmyy[0]
							$l_i_was_requested_by_lowercase
							$array_item_requester_user_job_title[0] $array_item_requester_user_first_name[0] $array_item_requester_user_middle_name[0] 
							$array_item_requester_user_last_name[0]
							$l_from_department_lowercase 
							$array_item_requester_user_department[0]
							$l_to_lowercase ";
							$write_to_doc = $write_to_doc . strtolower($array_item_request_text[0]);
							$write_to_doc = $write_to_doc . " $l_the_evidence_that_has_been_prosessed_is_listed_in_the_table_below
							</p>
					<!-- //Assignment -->


					<!-- Seizures -->
						<h1 style=\"font: bold 24px Arial,Helvetica,sans-serif;\">$l_seizures</h1>
		
						<p style=\"font: oblique 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding-bottom:0;margin-bottom:4px;\">$l_table_one_seizures</p>
	
							<table style=\"width:100%;border-collapse:collapse;width: 100%;text-align: left;border-spacing:0;border: #cccccc 1px solid;\" cellspacing=\"0\" cellmargin=\"0\">
							 <thead style=\"border-top: #cccccc 1px solid;\">
							  <tr>
							   <th style=\"background: #e2e2e2;border-top: #ffffff 1px solid;border-bottom: #cccccc 1px solid;padding: 4px;color: #000;text-align:left;\">
								<span style=\"font: bold 16px Arial,Helvetica Neue,Helvetica,sans-serif;\">$l_evidence_number</span>
							   </th>
							   <th style=\"background: #e2e2e2;border-top: #ffffff 1px solid;border-bottom: #cccccc 1px solid;padding: 4px;color: #000;text-align:left;\">
								<span style=\"font: bold 16px Arial,Helvetica Neue,Helvetica,sans-serif;\">$l_description</span>
							   </th>
							   <th style=\"background: #e2e2e2;border-top: #ffffff 1px solid;border-bottom: #cccccc 1px solid;padding: 4px;color: #000;text-align:left;\">
								<span style=\"font: bold 16px Arial,Helvetica Neue,Helvetica,sans-serif;\">$l_acquired</span>
							   </th>
							  </tr>
							 </thead>
							 <tbody>";
							for($x=0;$x<sizeof($array_item_id);$x++){
											
								if(isset($odd) && $odd == false){
									$odd = true;
								}
								else{
									$odd = false;
								}

								$write_to_doc = $write_to_doc . "
								 <tr>
								  <td"; if($odd == true){ $write_to_doc = $write_to_doc . " style=\"background: #f8f8f8;border-bottom: #cccccc 1px solid;padding: 8px 4px 8px 4px;\""; }
								else{ $write_to_doc = $write_to_doc . " style=\"background: #f3f3f3;border-bottom: #cccccc 1px solid;padding: 8px 4px 8px 4px;\""; }
								$write_to_doc = $write_to_doc . ">
									<span style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;\">$array_item_record_seized_year[$x] / 
									$array_item_record_seized_journal[$x] - 	
									$array_item_record_seized_district_number[$x] -	
									$array_item_numeric_serial_number[$x]</span>
								  </td>
								  <td"; if($odd == true){ $write_to_doc = $write_to_doc . " style=\"background: #f8f8f8;border-bottom: #cccccc 1px solid;padding: 8px 4px 8px 4px;\""; }
								else{ $write_to_doc = $write_to_doc . " style=\"background: #f3f3f3;border-bottom: #cccccc 1px solid;padding: 8px 4px 8px 4px;\""; }
								$write_to_doc = $write_to_doc . ">
									<span style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;\">$array_item_title[$x]</span>
								  </td>
								  <td"; if($odd == true){ $write_to_doc = $write_to_doc . " style=\"background: #f8f8f8;border-bottom: #cccccc 1px solid;padding: 8px 4px 8px 4px;\""; }
								else{ $write_to_doc = $write_to_doc . " style=\"background: #f3f3f3;border-bottom: #cccccc 1px solid;padding: 8px 4px 8px 4px;\""; }
								$write_to_doc = $write_to_doc . ">
									<span style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;\">$array_item_acquired_date_ddmmyy[$x]</span>
								  </td>
								 </tr>
								";
							}
							$write_to_doc = $write_to_doc . "
							 </tbody>
							</table>
					<!-- //Seizures -->
						
					";

					$write_to_doc = $write_to_doc . " 
					<!-- Acquiring -->
						<h1 style=\"font: bold 24px Arial,Helvetica,sans-serif;\">$l_acquiring</h1>
						";
						for($x=0;$x<sizeof($array_item_id);$x++){

							$write_to_doc = $write_to_doc . "
							<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:8px 0px 0px 0px;margin:8px 0px 0px 0px;\">
							<b>$array_item_record_seized_year[$x] / 
							$array_item_record_seized_journal[$x] - 	
							$array_item_record_seized_district_number[$x] -	
							$array_item_numeric_serial_number[$x] $array_item_title[$x]</b>
							</p>
							<table style=\"padding:0px 0px 0px 0px;margin:0px 0px 0px 0px;\">";

							// Acquired with software A
							if($array_item_acquired_software_id_a[$x] != ""){
								$query = "SELECT software_id, software_title, software_version, software_used_for, software_description, software_report_text, software_image_path, software_image_file FROM $t_edb_software_index WHERE software_id=$array_item_acquired_software_id_a[$x]";
								$result = mysqli_query($link, $query);
								$row = mysqli_fetch_row($result);
								list($get_current_software_id, $get_current_software_title, $get_current_software_version, $get_current_software_used_for, $get_current_software_description, $get_current_software_report_text, $get_current_software_image_path, $get_current_software_image_file) = $row;
	
								$l_acquired_with = str_replace(" ", "&nbsp;", $l_acquired_with);
								$write_to_doc = $write_to_doc . "
								 <tr>
								  <td style=\"padding:0px 6px 0px 0px;vertical-align:top;\">
									<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:0px 0px 0px 0px;margin:0;\">
									$l_acquired_with:
									</p>
								  </td>
								  <td style=\"vertical-align:top;\">
									<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:0px 0px 0px 0px;margin:0;\">
									$get_current_software_title $l_version_lowercase $get_current_software_version
									</p>
								";
								// $get_current_software_report_text
								// Acquired with software B
								if($array_item_acquired_software_id_b[$x] != ""){
									$query = "SELECT software_id, software_title, software_version, software_used_for, software_description, software_report_text, software_image_path, software_image_file FROM $t_edb_software_index WHERE software_id=$array_item_acquired_software_id_b[$x]";
									$result = mysqli_query($link, $query);
									$row = mysqli_fetch_row($result);
									list($get_current_software_id, $get_current_software_title, $get_current_software_version, $get_current_software_used_for, $get_current_software_description, $get_current_software_report_text, $get_current_software_image_path, $get_current_software_image_file) = $row;
		
									$write_to_doc = $write_to_doc . "
									$l_and_lowercase
									$array_item_title[$x] $l_was_acquired_with_lowercase $get_current_software_title $l_version_lowercase $get_current_software_version";
								
								
									// Acquired with software C
									if($array_item_acquired_software_id_c[$x] != ""){
										$query = "SELECT software_id, software_title, software_version, software_used_for, software_description, software_report_text, software_image_path, software_image_file FROM $t_edb_software_index WHERE software_id=$array_item_acquired_software_id_c[$x]";
										$result = mysqli_query($link, $query);
										$row = mysqli_fetch_row($result);
										list($get_current_software_id, $get_current_software_title, $get_current_software_version, $get_current_software_used_for, $get_current_software_description, $get_current_software_report_text, $get_current_software_image_path, $get_current_software_image_file) = $row;
	
										$write_to_doc = $write_to_doc . "
										$l_and_lowercase
										$array_item_title[$x] $l_was_acquired_with_lowercase $get_current_software_title $l_version_lowercase $get_current_software_version";
									} // c
								} // b

								$write_to_doc = $write_to_doc . "
								  </td>
								 </tr>
								";
							}
							if($array_item_condition[$x] != ""){
								$write_to_doc = $write_to_doc . "
								 <tr>
								  <td style=\"padding:0px 6px 0px 0px;vertical-align:top;\">
									<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:0px 0px 0px 0px;margin:0;\">
									$l_condition:
									</p>
								  </td>
								  <td style=\"vertical-align:top;\">
									<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:0px 0px 0px 0px;margin:0;\">
									$array_item_condition[$x]
									</p>
								  </td>
								 </tr>
								";
									
							}

							// Time and date
							if($array_item_date_now_ddmmyy[$x] != ""){
								$l_date_and_time = str_replace(" ", "&nbsp;", $l_date_and_time);
								$write_to_doc = $write_to_doc . "
								 <tr>
								  <td style=\"padding:0px 6px 0px 0px;vertical-align:top;\">
									<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:0px 0px 0px 0px;margin:0;\">
									$l_date_and_time:
									</p>
								  </td>
								  <td style=\"vertical-align:top;\">
									<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:0;margin:0;\">
								";
								if($array_item_date_now_ddmmyy[$x] == "$array_item_correct_date_now_ddmmyy[$x]" && $array_item_time_now[$x] == "$array_item_correct_time_now[$x]"){
								
									$write_to_doc = $write_to_doc . "$l_date_and_time_was_correct";
								}
								else{
									$write_to_doc = $write_to_doc . "$l_date_and_time_was_not_correct 
									$l_date_and_time_on_the_device_was $array_item_date_now_ddmmyy[$x] $array_item_time_now[$x] 
									$l_while_correct_date_and_time_was_lowercase $array_item_correct_date_now_ddmmyy[$x] $array_item_correct_time_now[$x]";
								}


								if($array_item_date_now_ddmmyy[$x] == "" && $array_item_adjust_clock_automatically[$x] != ""){
									$write_to_doc = $write_to_doc . "";
								}
							
								if($array_item_adjust_clock_automatically[$x] == "yes"){
									$write_to_doc = $write_to_doc . " $l_the_clock_was_set_to_adjust_automatically";
								}
								elseif($array_item_adjust_clock_automatically[$x] == "no"){
									$write_to_doc = $write_to_doc . " $l_the_clock_was_not_set_to_adjust_automatically";
								}
								$write_to_doc = $write_to_doc . "
									</p>
								  </td>
								 </tr>
								";

							}
							// Time Zone
							if($array_item_timezone[$x] != ""){
								$write_to_doc = $write_to_doc . "
								 <tr>
								  <td style=\"padding:0px 6px 0px 0px;\">
									<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:0px 0px 0px 0px;margin:0;\">
									$l_time_zone:
									</p>
								  </td>
								  <td>
									<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:0px 0px 0px 0px;margin:0;\">
									$array_item_timezone[$x].";
									if($array_item_adjust_clock_automatically[$x] == "yes"){
										$write_to_doc = $write_to_doc . " $l_the_time_zone_was_set_to_adjust_automatically";
									}
									elseif($array_item_adjust_clock_automatically[$x] == "no"){
										$write_to_doc = $write_to_doc . " $l_the_time_zone_was_not_set_to_adjust_automatically";
									}
									$write_to_doc = $write_to_doc . "
									</p>
								  </td>
								 </tr>
								";
							}

							// IMEI

							if(isset($array_item_imei[$x])){
								$imei_size = sizeof($array_item_imei[$x]);
								if($imei_size > 0){
									for($i=0;$i<$imei_size;$i++){
										if(isset($array_item_imei[$x][$i])){
											$number = $array_item_imei[$x][$i];
											if(!(is_array($number))){
												$write_to_doc = $write_to_doc . "
											 <tr>
											  <td style=\"padding:0px 6px 0px 0px;\">
												<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:0px 0px 0px 0px;margin:0;\">
												$l_imei:
												</p>
											  </td>
											  <td>
												<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;padding:0px 0px 0px 0px;margin:0;\">
												$number 
												</p>
											  </td>
											 </tr>
											";
											} 
										}
									}
								}
							}

							$write_to_doc = $write_to_doc . "
							</table>";

						}
						$write_to_doc = $write_to_doc . "
					<!-- //Acquiring -->

					<!-- Other -->
						<h1 style=\"font: bold 24px Arial,Helvetica,sans-serif;\">$l_other</h1>

						<p style=\"font: normal 16px Arial,Helvetica Neue,Helvetica,sans-serif;\">$l_secured_contents_is_stored_at_digital_police </p>

					<!-- Expressions -->
						<h1 style=\"font: bold 24px Arial,Helvetica,sans-serif;\">$l_expressions</h1>
						";
						
						// The strategy is to make a folder and write all terms into text files into the category,
						// Then we can include all terms
						$datetime = date("ymdhis");


						// Software
						$dir = "../_cache/" . $get_current_case_number . "_software_" . $datetime;
						if(is_dir("$dir")){
							if ($handle = opendir($dir)) {
								while (false !== ($file = readdir($handle))) {
									if ($file === '.') continue;
									if ($file === '..') continue;
									
									$fh = fopen("$dir/$file", "r");
									$data = fread($fh, filesize("$dir/$file"));
									fclose($fh);

									$write_to_doc = $write_to_doc . "$data";
								}
							}
						}

						// Terms
						$filenames = "";
						$dir = "../_cache/" . $get_current_case_number . "_terms_" . $datetime;
						if(is_dir("$dir")){
							if ($handle = opendir($dir)) {
								while (false !== ($file = readdir($handle))) {
									if ($file === '.') continue;
									if ($file === '..') continue;
									
									$fh = fopen("$dir/$file", "r");
									$data = fread($fh, filesize("$dir/$file"));
									fclose($fh);

									$write_to_doc = $write_to_doc . "$data";
								}
							}
						}



						echo"
					<!-- //Expressions -->
					";





					$write_to_doc_footer = "</body></html>\"";

					$ymd = date("ymd");
					$doc_file = "$get_current_report_title - $l_case $get_current_case_number ($ymd).doc";
					$fh = fopen("$root/_cache/$doc_file", "w+") or die("can not open file");
					fwrite($fh, $write_to_doc_header);
					fwrite($fh, $write_to_doc);
					fwrite($fh, $write_to_doc_footer);
					fclose($fh);

					// Open it
					echo"<meta http-equiv=\"refresh\" content=\"1;url=$root/_cache/$doc_file\">";
	
					echo"$write_to_doc";

					echo"</body>\n";
					echo"</html>";
				} // generate
		
			} // access to station
		} // report found
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