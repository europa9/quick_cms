<?php 
/**
*
* File: edb/open_case_delete_case.php
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
$t_edb_liquidbase				= $mysqlPrefixSav . "edb_liquidbase";

$t_edb_home_page_user_remember			= $mysqlPrefixSav . "edb_home_page_user_remember";

$t_edb_case_index				= $mysqlPrefixSav . "edb_case_index";
$t_edb_case_index_events			= $mysqlPrefixSav . "edb_case_index_events";
$t_edb_case_index_evidence_records		= $mysqlPrefixSav . "edb_case_index_evidence_records";
$t_edb_case_index_evidence_items		= $mysqlPrefixSav . "edb_case_index_evidence_items";
$t_edb_case_index_evidence_items_sim_cards	= $mysqlPrefixSav . "edb_case_index_evidence_items_sim_cards";
$t_edb_case_index_evidence_items_sd_cards	= $mysqlPrefixSav . "edb_case_index_evidence_items_sd_cards";
$t_edb_case_index_evidence_items_networks	= $mysqlPrefixSav . "edb_case_index_evidence_items_networks";
$t_edb_case_index_evidence_items_hard_disks	= $mysqlPrefixSav . "edb_case_index_evidence_items_hard_disks";
$t_edb_case_index_evidence_items_volumes	= $mysqlPrefixSav . "edb_case_index_evidence_items_volumes";
$t_edb_case_index_evidence_items_mirror_files	= $mysqlPrefixSav . "edb_case_index_evidence_items_mirror_files";

$t_edb_case_index_statuses				= $mysqlPrefixSav . "edb_case_index_statuses";
$t_edb_case_index_human_tasks				= $mysqlPrefixSav . "edb_case_index_human_tasks";
$t_edb_case_index_human_tasks_responsible_counters	= $mysqlPrefixSav . "edb_case_index_human_tasks_responsible_counters";
$t_edb_case_index_automated_tasks			= $mysqlPrefixSav . "edb_case_index_automated_tasks";
$t_edb_case_index_notes					= $mysqlPrefixSav . "edb_case_index_notes";
$t_edb_case_index_open_case_menu_counters		= $mysqlPrefixSav . "edb_case_index_open_case_menu_counters";
$t_edb_case_index_glossaries				= $mysqlPrefixSav . "edb_case_index_glossaries";
$t_edb_case_index_photos				= $mysqlPrefixSav . "edb_case_index_photos";

$t_edb_case_codes					= $mysqlPrefixSav . "edb_case_codes";
$t_edb_case_codes_priority_counters			= $mysqlPrefixSav . "edb_case_codes_priority_counters";
$t_edb_case_statuses					= $mysqlPrefixSav . "edb_case_statuses";
$t_edb_case_statuses_district_case_counter		= $mysqlPrefixSav . "edb_case_statuses_district_case_counter";
$t_edb_case_statuses_station_case_counter		= $mysqlPrefixSav . "edb_case_statuses_station_case_counter";
$t_edb_case_statuses_user_case_counter			= $mysqlPrefixSav . "edb_case_statuses_user_case_counter";
$t_edb_case_priorities					= $mysqlPrefixSav . "edb_case_priorities";
$t_edb_case_reports					= $mysqlPrefixSav . "edb_case_reports";

$t_edb_case_index_matrix_names			= $mysqlPrefixSav . "edb_case_index_matrix_names";
$t_edb_case_index_matrix_header 		= $mysqlPrefixSav . "edb_case_index_matrix_header";
$t_edb_case_index_matrix_body_titles 		= $mysqlPrefixSav . "edb_case_index_matrix_body_titles";
$t_edb_case_index_matrix_body_values 		= $mysqlPrefixSav . "edb_case_index_matrix_body_values";

$t_edb_districts_index			= $mysqlPrefixSav . "edb_districts_index";
$t_edb_districts_members		= $mysqlPrefixSav . "edb_districts_members";
$t_edb_districts_membership_requests	= $mysqlPrefixSav . "edb_districts_membership_requests";
$t_edb_districts_jour 			= $mysqlPrefixSav . "edb_districts_jour";

$t_edb_stations_index			= $mysqlPrefixSav . "edb_stations_index";
$t_edb_stations_members			= $mysqlPrefixSav . "edb_stations_members";
$t_edb_stations_membership_requests	= $mysqlPrefixSav . "edb_stations_membership_requests";
$t_edb_stations_directories		= $mysqlPrefixSav . "edb_stations_directories";
$t_edb_stations_jour			= $mysqlPrefixSav . "edb_stations_jour";
$t_edb_stations_user_view_method	= $mysqlPrefixSav . "edb_stations_user_view_method";

$t_edb_item_types		= $mysqlPrefixSav . "edb_item_types";

$t_edb_glossaries		= $mysqlPrefixSav . "edb_glossaries";

$t_edb_software_index	= $mysqlPrefixSav . "edb_software_index";

$t_edb_machines_index				= $mysqlPrefixSav . "edb_machines_index";
$t_edb_machines_index_types			= $mysqlPrefixSav . "edb_machines_index_types";
$t_edb_machines_types				= $mysqlPrefixSav . "edb_machines_types";
$t_edb_machines_all_tasks_available		= $mysqlPrefixSav . "edb_machines_all_tasks_available";
$t_edb_machines_all_tasks_available_to_item  	= $mysqlPrefixSav . "edb_machines_all_tasks_available_to_item";

$t_edb_agent_log 			= $mysqlPrefixSav . "edb_agent_log";
$t_edb_agent_user_active_inactive 	= $mysqlPrefixSav . "edb_agent_user_active_inactive";
$t_edb_agents_index		 	= $mysqlPrefixSav . "edb_agents_index";


$t_edb_stats_index 			= $mysqlPrefixSav . "edb_stats_index";
$t_edb_stats_case_codes			= $mysqlPrefixSav . "edb_stats_case_codes";
$t_edb_stats_case_priorites		= $mysqlPrefixSav . "edb_stats_case_priorites";
$t_edb_stats_item_types 		= $mysqlPrefixSav . "edb_stats_item_types";
$t_edb_stats_statuses_per_day		= $mysqlPrefixSav . "edb_stats_statuses_per_day";
$t_edb_stats_employee_of_the_month	= $mysqlPrefixSav . "edb_stats_employee_of_the_month";
$t_edb_stats_acquirements_per_month	= $mysqlPrefixSav . "edb_stats_acquirements_per_month";




$t_edb_case_index_review_notes			= $mysqlPrefixSav . "edb_case_index_review_notes";
$t_edb_case_index_review_matrix_titles		= $mysqlPrefixSav . "edb_case_index_review_matrix_titles";
$t_edb_case_index_review_matrix_fields		= $mysqlPrefixSav . "edb_case_index_review_matrix_fields";
$t_edb_case_index_review_matrix_values		= $mysqlPrefixSav . "edb_case_index_review_matrix_values";
$t_edb_case_index_review_matrix_items		= $mysqlPrefixSav . "edb_case_index_review_matrix_items";

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
					<a href=\"open_case.php?case_id=$get_current_case_id&amp;l=$l\">$get_current_case_number</a>
					&gt;
					<a href=\"open_case_delete_case.php?case_id=$get_current_case_id&amp;l=$l\">$l_delete_case</a>
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
	
			// Process
			if($process == "1" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor")){

				$inp_case_number = $_POST['inp_case_number'];
				if($inp_case_number == "$get_current_case_number"){

				// Delete case
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index WHERE case_id=$get_current_case_id") or die(mysqli_error($link));

				// Records
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_automated_tasks WHERE automated_task_case_id=$get_current_case_id") or die(mysqli_error($link));
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_events WHERE event_case_id=$get_current_case_id") or die(mysqli_error($link));
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_evidence_items_hard_disks WHERE hard_disk_case_id=$get_current_case_id") or die(mysqli_error($link));
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_case_id=$get_current_case_id") or die(mysqli_error($link));

				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_evidence_items_networks WHERE network_case_id=$get_current_case_id") or die(mysqli_error($link));
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_evidence_items_sd_cards WHERE sd_card_case_id=$get_current_case_id") or die(mysqli_error($link));
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_evidence_items_sim_cards WHERE sim_card_case_id=$get_current_case_id") or die(mysqli_error($link));
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_evidence_items_volumes WHERE volume_case_id=$get_current_case_id") or die(mysqli_error($link));
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_evidence_records WHERE record_case_id=$get_current_case_id") or die(mysqli_error($link));
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_glossaries WHERE case_glossary_case_id=$get_current_case_id") or die(mysqli_error($link));

				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_human_tasks WHERE human_task_case_id=$get_current_case_id") or die(mysqli_error($link));
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_matrix_body_titles WHERE body_title_case_id=$get_current_case_id") or die(mysqli_error($link));
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_matrix_body_values WHERE body_value_case_id=$get_current_case_id") or die(mysqli_error($link));

				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_matrix_header WHERE header_case_id=$get_current_case_id") or die(mysqli_error($link));
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_matrix_names WHERE matrix_name_case_id=$get_current_case_id") or die(mysqli_error($link));

				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_notes WHERE note_case_id=$get_current_case_id") or die(mysqli_error($link));

				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_open_case_menu_counters WHERE menu_counter_case_id=$get_current_case_id") or die(mysqli_error($link));

				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_review_matrix_fields WHERE field_case_id=$get_current_case_id") or die(mysqli_error($link));
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_review_matrix_items WHERE matrix_item_case_id=$get_current_case_id") or die(mysqli_error($link));
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_review_matrix_titles WHERE title_case_id=$get_current_case_id") or die(mysqli_error($link));
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_review_matrix_values WHERE value_case_id=$get_current_case_id") or die(mysqli_error($link));
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_review_notes WHERE review_case_id=$get_current_case_id") or die(mysqli_error($link));

				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_statuses WHERE case_index_status_case_id=$get_current_case_id") or die(mysqli_error($link));
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_automated_tasks WHERE automated_task_case_id=$get_current_case_id") or die(mysqli_error($link));
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_automated_tasks WHERE automated_task_case_id=$get_current_case_id") or die(mysqli_error($link));
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_automated_tasks WHERE automated_task_case_id=$get_current_case_id") or die(mysqli_error($link));
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_automated_tasks WHERE automated_task_case_id=$get_current_case_id") or die(mysqli_error($link));
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_automated_tasks WHERE automated_task_case_id=$get_current_case_id") or die(mysqli_error($link));
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_automated_tasks WHERE automated_task_case_id=$get_current_case_id") or die(mysqli_error($link));


					// Photos
					$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_photos WHERE photo_case_id=$get_current_case_id") or die(mysqli_error($link));

					$url = "cases_board_2_view_station.php?station_id=$get_current_case_station_id&l=$l&ft=success&fm=case_deleted";
					header("Location: $url");
					exit;
				}
				else{

					$url = "open_case_delete_case.php?case_id=$get_current_case_id&l=$l&ft=info&fm=wrong_number";
					header("Location: $url");
					exit;
				}
			}

			echo"
			<h2>$l_delete_case</h2>
		
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

			<!-- Delete case form -->
				";
				if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
					echo"
					<p>$l_are_you_sure</p>


					<!-- Confirm by entering case number -->
						<form method=\"POST\" id=\"form\" action=\"open_case_delete_case.php?case_id=$get_current_case_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
			
						<p>$l_confirm_by_entering_case_number:<br />
						<input type=\"text\" name=\"inp_case_number\" value=\"\" size=\"35\" autocomplete=\"off\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
						</p>

						<p>
						<input type=\"submit\" class=\"btn_danger\" value=\"$l_delete\" />
						<a href=\"open_case_overview.php?case_id=$get_current_case_id&amp;l=$l\" class=\"btn_default\">$l_cancel</a>
						</p>
						</form>
					<!-- //Confirm by entering case number -->
				
					";
				}
				else{
					echo"<div class=\"info\"><p>$l_access_denied</p></div>";
				}
				echo"
			<!-- //Delete case form -->
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