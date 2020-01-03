<?php 
/**
*
* File: edb/open_case_automated_tasks.php
* Version 1.0
* Date 17:49 11.08.2019
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
$t_edb_machines_index				= $mysqlPrefixSav . "edb_machines_index";
$t_edb_machines_index_types			= $mysqlPrefixSav . "edb_machines_index_types";
$t_edb_machines_types				= $mysqlPrefixSav . "edb_machines_types";
$t_edb_machines_all_tasks_available		= $mysqlPrefixSav . "edb_machines_all_tasks_available";
$t_edb_machines_all_tasks_available_to_item  	= $mysqlPrefixSav . "edb_machines_all_tasks_available_to_item";



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
					<a href=\"open_case_overview.php?case_id=$get_current_case_id&amp;l=$l\">$get_current_case_number</a>
					&gt;
					<a href=\"open_case_automated_tasks.php?case_id=$get_current_case_id&amp;l=$l\">$l_automated_tasks</a>
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
			if($action == ""){
				echo"
				<h2>$l_automated_tasks</h2>

				<!-- Automated tasks actions -->";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"
						<p>
						<a href=\"open_case_automated_tasks.php?case_id=$get_current_case_id&amp;action=new_automated_task&amp;l=$l\" class=\"btn_default\">$l_new_automated_task</a>
						</p>
						<div style=\"height: 10px;\"></div>
						";
					}	
					echo"
				<!-- //Automated tasks actions -->


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

				<!-- List of automatic tasks -->
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
						<span>$l_mirror_file</span>
					   </th>
					   <th scope=\"col\">
						<span>$l_started</span>
					   </th>
					   <th scope=\"col\">
						<span>$l_machine</span>
					   </th>
					   <th scope=\"col\">
						<span>$l_status</span>
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
					$query = "SELECT automated_task_id, automated_task_case_id, automated_task_evidence_record_id, automated_task_evidence_item_id, automated_task_evidence_full_title, automated_task_task_available_id, automated_task_task_available_name, automated_task_task_machine_type_id, automated_task_task_machine_type_title, automated_task_mirror_file_id, automated_task_mirror_file_path_windows, automated_task_mirror_file_path_linux, automated_task_mirror_file_file, automated_task_added_datetime, automated_task_added_date, automated_task_added_time, automated_task_added_date_saying, automated_task_added_date_ddmmyy, automated_task_added_date_ddmmyyyy, automated_task_started_datetime, automated_task_started_date, automated_task_started_time, automated_task_started_date_saying, automated_task_started_date_ddmmyyhi, automated_task_started_date_ddmmyyyyhi, automated_task_machine_id, automated_task_machine_name, automated_task_last_status_msg, automated_task_last_status_ddmmyyyyhi, automated_task_is_finished, automated_task_finished_datetime, automated_task_finished_date, automated_task_finished_time, automated_task_finished_date_saying, automated_task_finished_date_ddmmyyhi, automated_task_finished_date_ddmmyyyyhi, automated_task_time_taken_time, automated_task_time_taken_human FROM $t_edb_case_index_automated_tasks WHERE automated_task_case_id=$get_current_case_id AND automated_task_dependent_on_automated_task_id='0'  ORDER BY automated_task_id ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_automated_task_id, $get_automated_task_case_id, $get_automated_task_evidence_record_id, $get_automated_task_evidence_item_id, $get_automated_task_evidence_full_title, $get_automated_task_task_available_id, $get_automated_task_task_available_name, $get_automated_task_task_machine_type_id, $get_automated_task_task_machine_type_title, $get_automated_task_mirror_file_id, $get_automated_task_mirror_file_path_windows, $get_automated_task_mirror_file_path_linux, $get_automated_task_mirror_file_file, $get_automated_task_added_datetime, $get_automated_task_added_date, $get_automated_task_added_time, $get_automated_task_added_date_saying, $get_automated_task_added_date_ddmmyy, $get_automated_task_added_date_ddmmyyyy, $get_automated_task_started_datetime, $get_automated_task_started_date, $get_automated_task_started_time, $get_automated_task_started_date_saying, $get_automated_task_started_date_ddmmyyhi, $get_automated_task_started_date_ddmmyyyyhi, $get_automated_task_machine_id, $get_automated_task_machine_name, $get_automated_task_last_status_msg, $get_automated_task_last_status_ddmmyyyyhi, $get_automated_task_is_finished, $get_automated_task_finished_datetime, $get_automated_task_finished_date, $get_automated_task_finished_time, $get_automated_task_finished_date_saying, $get_automated_task_finished_date_ddmmyyhi, $get_automated_task_finished_date_ddmmyyyyhi, $get_automated_task_time_taken_time, $get_automated_task_time_taken_human) = $row;

						if(isset($style) && $style == ""){
							$style = "odd";
						}
						else{
							$style = "";
						}
						
						// Mirror files ready?
						$query_mirror = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_created_datetime, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_modified_datetime, mirror_file_modified_time, mirror_file_modified_date_saying, mirror_file_modified_date_ddmmyy, mirror_file_size_mb, mirror_file_size_human, mirror_file_backup_disk, mirror_file_exists, mirror_file_ready_for_automated_machine, mirror_file_comments FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_id=$get_automated_task_mirror_file_id AND mirror_file_case_id=$get_automated_task_case_id AND mirror_file_item_id=$get_automated_task_evidence_item_id";
						$result_mirror = mysqli_query($link, $query_mirror);
						$row_mirror = mysqli_fetch_row($result_mirror);
						list($get_mirror_file_id, $get_mirror_file_case_id, $get_mirror_file_record_id, $get_mirror_file_item_id, $get_mirror_file_path_windows, $get_mirror_file_path_linux, $get_mirror_file_file, $get_mirror_file_ext, $get_mirror_file_type, $get_mirror_file_created_datetime, $get_mirror_file_created_time, $get_mirror_file_created_date_saying, $get_mirror_file_created_date_ddmmyy, $get_mirror_file_modified_datetime, $get_mirror_file_modified_time, $get_mirror_file_modified_date_saying, $get_mirror_file_modified_date_ddmmyy, $get_mirror_file_size_mb, $get_mirror_file_size_human, $get_mirror_file_backup_disk, $get_mirror_file_exists, $get_mirror_file_ready_for_automated_machine, $get_mirror_file_comments) = $row_mirror;
	

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
							<!-- Status -->
							";
							if($get_mirror_file_id == ""){
								echo"
								<span style=\"color: red;\">get_mirror_file_id = &quot;&quot;. This means that the mirror file was not found in the table with mirror files.</span>
								";
							}
							else{
								if($get_mirror_file_exists == "1"){
									if($get_mirror_file_ready_for_automated_machine == "1"){
										echo"
										<span>$get_mirror_file_file $l_ready_lowercase</span>
										";
									}
									else{
										echo"
										<span style=\"color: orange;\">$get_mirror_file_file $l_not_ready_lowercase &middot; $l_modified $get_mirror_file_modified_date_saying &middot; $l_not_ready</span>
										";
									}
								}
								else{
									echo"
									<span style=\"color: red;\">$get_mirror_file_file $l_doesnt_exist_lowercase</span>
									";
								}
							}
							echo"	
							<!-- //Status -->			
						  </td>
						  <td class=\"$style\">
							<span>$get_automated_task_started_date_ddmmyyyyhi</span>
						  </td>
						  <td class=\"$style\">
							<span>$get_automated_task_machine_name</span>
						  </td>
						  <td class=\"$style\">
							<span>"; 
							if($get_automated_task_last_status_ddmmyyyyhi != ""){
								$log_file = "edb_automated_task_$get_automated_task_id.log";
								if(file_exists("$root/_cache/$log_file")){
									echo"<a href=\"$root/_cache/$log_file\">$get_automated_task_last_status_ddmmyyyyhi: $get_automated_task_last_status_msg</a>";
								}
								else{
									echo"$get_automated_task_last_status_ddmmyyyyhi: $get_automated_task_last_status_msg";
								}
							}
							echo"</span>
						  </td>
						  <td class=\"$style\">
							<span>$get_automated_task_finished_date_ddmmyyyyhi</span>
						  </td>
						  <td class=\"$style\">";
							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
								echo"
								<span>
								<a href=\"open_case_automated_tasks.php?case_id=$get_current_case_id&amp;action=edit_task&amp;automated_task_id=$get_automated_task_id&amp;l=$l\">$l_edit</a>
								&middot;
								<a href=\"open_case_automated_tasks.php?case_id=$get_current_case_id&amp;action=delete_task&amp;automated_task_id=$get_automated_task_id&amp;l=$l\">$l_delete</a>
								</span>
								";
							}
							echo"
						 </td>
						</tr>
					";


					$counter_automated_tasks_total++;
					if($get_automated_task_finished_date_ddmmyyyyhi != ""){
						$counter_automated_tasks_completed++;
					}

					// Select children of this task (tasks that are dependendt on the parent)
					$query_child = "SELECT automated_task_id, automated_task_case_id, automated_task_evidence_record_id, automated_task_evidence_item_id, automated_task_evidence_full_title, automated_task_task_available_id, automated_task_task_available_name, automated_task_task_machine_type_id, automated_task_task_machine_type_title, automated_task_mirror_file_id, automated_task_mirror_file_path_windows, automated_task_mirror_file_path_linux, automated_task_mirror_file_file, automated_task_added_datetime, automated_task_added_date, automated_task_added_time, automated_task_added_date_saying, automated_task_added_date_ddmmyy, automated_task_added_date_ddmmyyyy, automated_task_started_datetime, automated_task_started_date, automated_task_started_time, automated_task_started_date_saying, automated_task_started_date_ddmmyyhi, automated_task_started_date_ddmmyyyyhi, automated_task_machine_id, automated_task_machine_name, automated_task_is_finished, automated_task_finished_datetime, automated_task_finished_date, automated_task_finished_time, automated_task_finished_date_saying, automated_task_finished_date_ddmmyyhi, automated_task_finished_date_ddmmyyyyhi, automated_task_time_taken_time, automated_task_time_taken_human FROM $t_edb_case_index_automated_tasks WHERE automated_task_case_id=$get_current_case_id AND automated_task_dependent_on_automated_task_id=$get_automated_task_id  ORDER BY automated_task_id ASC";
					$result_child = mysqli_query($link, $query_child);
					while($row_child = mysqli_fetch_row($result_child)) {
						list($get_child_automated_task_id, $get_child_automated_task_case_id, $get_child_automated_task_evidence_record_id, $get_child_automated_task_evidence_item_id, $get_child_automated_task_evidence_full_title, $get_child_automated_task_task_available_id, $get_child_automated_task_task_available_name, $get_child_automated_task_task_machine_type_id, $get_child_automated_task_task_machine_type_title, $get_child_automated_task_mirror_file_id, $get_child_automated_task_mirror_file_path_windows, $get_child_automated_task_mirror_file_path_linux, $get_child_automated_task_mirror_file_file, $get_child_automated_task_added_datetime, $get_child_automated_task_added_date, $get_child_automated_task_added_time, $get_child_automated_task_added_date_saying, $get_child_automated_task_added_date_ddmmyy, $get_child_automated_task_added_date_ddmmyyyy, $get_child_automated_task_started_datetime, $get_child_automated_task_started_date, $get_child_automated_task_started_time, $get_child_automated_task_started_date_saying, $get_child_automated_task_started_date_ddmmyyhi, $get_child_automated_task_started_date_ddmmyyyyhi, $get_child_automated_task_machine_id, $get_child_automated_task_machine_name, $get_child_automated_task_is_finished, $get_child_automated_task_finished_datetime, $get_child_automated_task_finished_date, $get_child_automated_task_finished_time, $get_child_automated_task_finished_date_saying, $get_child_automated_task_finished_date_ddmmyyhi, $get_child_automated_task_finished_date_ddmmyyyyhi, $get_child_automated_task_time_taken_time, $get_child_automated_task_time_taken_human) = $row_child;

						if(isset($style) && $style == ""){
							$style = "odd";
						}
						else{
							$style = "";
						}

						// Mirror files ready?
						$query_mirror = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_created_datetime, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_modified_datetime, mirror_file_modified_time, mirror_file_modified_date_saying, mirror_file_modified_date_ddmmyy, mirror_file_size_mb, mirror_file_size_human, mirror_file_backup_disk, mirror_file_exists, mirror_file_ready_for_automated_machine, mirror_file_comments FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_id=$get_child_automated_task_mirror_file_id AND mirror_file_case_id=$get_child_automated_task_case_id AND mirror_file_item_id=$get_child_automated_task_evidence_item_id";
						$result_mirror = mysqli_query($link, $query_mirror);
						$row_mirror = mysqli_fetch_row($result_mirror);
						list($get_mirror_file_id, $get_mirror_file_case_id, $get_mirror_file_record_id, $get_mirror_file_item_id, $get_mirror_file_path_windows, $get_mirror_file_path_linux, $get_mirror_file_file, $get_mirror_file_ext, $get_mirror_file_type, $get_mirror_file_created_datetime, $get_mirror_file_created_time, $get_mirror_file_created_date_saying, $get_mirror_file_created_date_ddmmyy, $get_mirror_file_modified_datetime, $get_mirror_file_modified_time, $get_mirror_file_modified_date_saying, $get_mirror_file_modified_date_ddmmyy, $get_mirror_file_size_mb, $get_mirror_file_size_human, $get_mirror_file_backup_disk, $get_mirror_file_exists, $get_mirror_file_ready_for_automated_machine, $get_mirror_file_comments) = $row_mirror;
	


						echo"
						 <tr>
						  <td class=\"$style\">
							<span><a href=\"open_case_evidence_edit_evidence_item_info.php?case_id=$get_child_automated_task_case_id&amp;item_id=$get_child_automated_task_evidence_item_id&amp;l=$l\">$get_child_automated_task_evidence_full_title</a></span>
						  </td>
						  <td class=\"$style\">
							<span><img src=\"_gfx/automated_task_dependent_on.png\" alt=\"automated_task_dependent_on.png\" /> $get_child_automated_task_task_available_name</span>
						  </td>
						  <td class=\"$style\">
							<span>$get_child_automated_task_added_date_ddmmyy</span>
						  </td>
						  <td class=\"$style\">
							<span>$get_child_automated_task_task_machine_type_title</span>
						  </td>
						  <td class=\"$style\">
							<!-- Status -->
							";
							if($get_mirror_file_exists == "1"){
								if($get_mirror_file_ready_for_automated_machine == "1"){
									echo"
									<span>$get_mirror_file_file $l_ready_lowercase</span>
									";
								}
								else{
									echo"
									<span style=\"color: orange;\">$get_mirror_file_file $l_not_ready_lowercase &middot; $l_modified $get_mirror_file_modified_date_saying &middot; $l_not_ready</span>
									";
								}
							}
							else{
								echo"
								<span style=\"color: red;\">$get_mirror_file_file $l_doesnt_exist_lowercase</span>
								";
							}
							echo"	
							<!-- //Status -->
						  </td>
						  <td class=\"$style\">
							<span>$get_child_automated_task_machine_name</span>
						  </td>
						  <td class=\"$style\">
							<span>$get_child_automated_task_finished_date_ddmmyyyyhi</span>
						  </td>
						  <td class=\"$style\">";
							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
								echo"
								<span>
								<a href=\"open_case_automated_tasks.php?case_id=$get_current_case_id&amp;action=edit_task&amp;automated_task_id=$get_child_automated_task_id&amp;l=$l\">$l_edit</a>
								&middot;
								<a href=\"open_case_automated_tasks.php?case_id=$get_current_case_id&amp;action=delete_task&amp;automated_task_id=$get_child_automated_task_id&amp;l=$l\">$l_delete</a>
								</span>
								";
							}
							echo"
						 </td>
						</tr>
					";

					} // query children
				} // while automated tasks
				if($counter_automated_tasks_total != "$get_current_menu_counter_automated_tasks_total" OR $counter_automated_tasks_completed != "$get_current_menu_counter_automated_tasks_completed"){
					$result = mysqli_query($link, "UPDATE $t_edb_case_index_open_case_menu_counters SET menu_counter_automated_tasks_completed=$counter_automated_tasks_completed, menu_counter_automated_tasks_total=$counter_automated_tasks_total WHERE menu_counter_case_id=$get_current_case_id") or die(mysqli_error($link));
				}
				echo"
				 </tbody>
				</table>

				<!-- List of automatic tasks -->

				<!-- Refresh every 3 minutes -->
					<meta http-equiv=\"refresh\" content=\"180;url=open_case_automated_tasks.php?case_id=$get_current_case_id&amp;l=$l\">
				<!-- //Refresh every 3 minutes -->

				";
			} // $action == ""
			elseif($action == "new_automated_task" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor")){
		
				echo"
				<h2>$l_new_automated_task</h2>


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

		
				<!-- New automated task form -->
					<p>$l_evidence_item:</p>
					<div class=\"vertical\">
				<ul>\n";
			$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title FROM $t_edb_case_index_evidence_items WHERE item_case_id=$get_current_case_id ORDER BY item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_item_id, $get_item_case_id, $get_item_record_id, $get_item_record_seized_year, $get_item_record_seized_journal, $get_item_record_seized_district_number, $get_item_numeric_serial_number, $get_item_title, $get_item_type_id, $get_item_type_title) = $row;
				echo"	<li><a href=\"open_case_automated_tasks.php?case_id=$get_current_case_id&amp;action=new_automated_task_step_2_select_mirror_file&amp;item_id=$get_item_id&amp;l=$l\">$get_item_record_seized_year/$get_item_record_seized_journal-$get_item_record_seized_district_number-$get_item_numeric_serial_number $get_item_title</a></li>\n";
			}
			echo"
				</ul>
			</div>
		<!-- //New automated task form -->
		";
			} // action == new automated task
			elseif($action == "new_automated_task_step_2_select_mirror_file" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor")){

				// Item
				$item_id = $_GET['item_id'];
				$item_id = output_html($item_id);
				$item_id_mysql = quote_smart($link, $item_id);

				$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_in_date_ddmmyyyy, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_timezone, item_date_now_date, item_date_now_saying, item_date_now_ddmmyy, item_date_now_ddmmyyyy, item_time_now, item_correct_date_now_date, item_correct_date_now_saying, item_correct_date_now_ddmmyy, item_correct_date_now_ddmmyyyy, item_correct_time_now, item_adjust_clock_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_date_ddmmyyyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy, item_out_date_ddmmyyyy FROM $t_edb_case_index_evidence_items WHERE item_id=$item_id_mysql AND item_case_id=$get_current_case_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_item_id, $get_current_item_case_id, $get_current_item_record_id, $get_current_item_record_seized_year, $get_current_item_record_seized_journal, $get_current_item_record_seized_district_number, $get_current_item_numeric_serial_number, $get_current_item_title, $get_current_item_type_id, $get_current_item_type_title, $get_current_item_confirmed_by_human, $get_current_item_human_rejected, $get_current_item_request_text, $get_current_item_requester_user_id, $get_current_item_requester_user_name, $get_current_item_requester_user_alias, $get_current_item_requester_user_email, $get_current_item_requester_user_image_path, $get_current_item_requester_user_image_file, $get_current_item_requester_user_image_thumb_40, $get_current_item_requester_user_image_thumb_50, $get_current_item_requester_user_first_name, $get_current_item_requester_user_middle_name, $get_current_item_requester_user_last_name, $get_current_item_requester_user_job_title, $get_current_item_requester_user_department, $get_current_item_in_datetime, $get_current_item_in_date, $get_current_item_in_time, $get_current_item_in_date_saying, $get_current_item_in_date_ddmmyy, $get_current_item_in_date_ddmmyyyy, $get_current_item_comment, $get_current_item_condition, $get_current_item_serial_number, $get_current_item_imei_a, $get_current_item_imei_b, $get_current_item_imei_c, $get_current_item_imei_d, $get_current_item_os_title, $get_current_item_os_version, $get_current_item_timezone, $get_current_item_date_now_date, $get_current_item_date_now_saying, $get_current_item_date_now_ddmmyy, $get_current_item_date_now_ddmmyyyy, $get_current_item_time_now, $get_current_item_correct_date_now_date, $get_current_item_correct_date_now_saying, $get_current_item_correct_date_now_ddmmyy, $get_current_item_correct_date_now_ddmmyyyy, $get_current_item_correct_time_now, $get_current_item_adjust_clock_automatically, $get_current_item_acquired_software_id_a, $get_current_item_acquired_software_title_a, $get_current_item_acquired_software_notes_a, $get_current_item_acquired_software_id_b, $get_current_item_acquired_software_title_b, $get_current_item_acquired_software_notes_b, $get_current_item_acquired_software_id_c, $get_current_item_acquired_software_title_c, $get_current_item_acquired_software_notes_c, $get_current_item_acquired_date, $get_current_item_acquired_time, $get_current_item_acquired_date_saying, $get_current_item_acquired_date_ddmmyy, $get_current_item_acquired_date_ddmmyyyy, $get_current_item_acquired_user_id, $get_current_item_acquired_user_name, $get_current_item_acquired_user_alias, $get_current_item_acquired_user_email, $get_current_item_acquired_user_image_path, $get_current_item_acquired_user_image_file, $get_current_item_acquired_user_image_thumb_40, $get_current_item_acquired_user_image_thumb_50, $get_current_item_acquired_user_first_name, $get_current_item_acquired_user_middle_name, $get_current_item_acquired_user_last_name, $get_current_item_out_date, $get_current_item_out_time, $get_current_item_out_date_saying, $get_current_item_out_date_ddmmyy, $get_current_item_out_date_ddmmyyyy) = $row;
	

				echo"
				<h2>$l_new_automated_task</h2>


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

				<!-- New automated task form -->
			<p>$l_mirror_file:</p>
			<div class=\"vertical\">
				<ul>\n";
	
			$query = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_confirmed_by_human, mirror_file_human_rejected, mirror_file_created_datetime, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_modified_datetime, mirror_file_modified_time, mirror_file_modified_date_saying, mirror_file_modified_date_ddmmyy, mirror_file_size_bytes, mirror_file_size_mb, mirror_file_size_human, mirror_file_backup_disk, mirror_file_exists, mirror_file_exists_agent_tries_counter, mirror_file_ready_for_automated_machine, mirror_file_ready_agent_tries_counter, mirror_file_comments FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_case_id=$get_current_item_case_id AND mirror_file_item_id=$get_current_item_id";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_mirror_file_id, $get_mirror_file_case_id, $get_mirror_file_record_id, $get_mirror_file_item_id, $get_mirror_file_path_windows, $get_mirror_file_path_linux, $get_mirror_file_file, $get_mirror_file_ext, $get_mirror_file_type, $get_mirror_file_confirmed_by_human, $get_mirror_file_human_rejected, $get_mirror_file_created_datetime, $get_mirror_file_created_time, $get_mirror_file_created_date_saying, $get_mirror_file_created_date_ddmmyy, $get_mirror_file_modified_datetime, $get_mirror_file_modified_time, $get_mirror_file_modified_date_saying, $get_mirror_file_modified_date_ddmmyy, $get_mirror_file_size_bytes, $get_mirror_file_size_mb, $get_mirror_file_size_human, $get_mirror_file_backup_disk, $get_mirror_file_exists, $get_mirror_file_exists_agent_tries_counter, $get_mirror_file_ready_for_automated_machine, $get_mirror_file_ready_agent_tries_counter, $get_mirror_file_comments) = $row;
				echo"	<li><a href=\"open_case_automated_tasks.php?case_id=$get_current_case_id&amp;action=new_automated_task_step_3_select_task&amp;item_id=$get_current_item_id&amp;mirror_file_id=$get_mirror_file_id&amp;l=$l\">$get_mirror_file_file</a></li>\n";
				
				// Empty name?
				if($get_mirror_file_file == ""){
					$result_delete = mysqli_query($link, "DELETE FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_id=$get_mirror_file_id");

				}
			}
			echo"
				</ul>
			</div>
			
			<p><a href=\"open_case_evidence_edit_evidence_item_acquire.php?case_id=$get_current_case_id&amp;item_id=$get_current_item_id&amp;mode=acquire&amp;l=$l\" class=\"btn_default\">$l_new_mirror_file</a>
		<!-- //New automated task form -->
		";
			}
			elseif($action == "new_automated_task_step_3_select_task"){

				// Item
				$item_id = $_GET['item_id'];
				$item_id = output_html($item_id);
				$item_id_mysql = quote_smart($link, $item_id);

				$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_in_date_ddmmyyyy, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_timezone, item_date_now_date, item_date_now_saying, item_date_now_ddmmyy, item_date_now_ddmmyyyy, item_time_now, item_correct_date_now_date, item_correct_date_now_saying, item_correct_date_now_ddmmyy, item_correct_date_now_ddmmyyyy, item_correct_time_now, item_adjust_clock_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_date_ddmmyyyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy, item_out_date_ddmmyyyy FROM $t_edb_case_index_evidence_items WHERE item_id=$item_id_mysql AND item_case_id=$get_current_case_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_item_id, $get_current_item_case_id, $get_current_item_record_id, $get_current_item_record_seized_year, $get_current_item_record_seized_journal, $get_current_item_record_seized_district_number, $get_current_item_numeric_serial_number, $get_current_item_title, $get_current_item_type_id, $get_current_item_type_title, $get_current_item_confirmed_by_human, $get_current_item_human_rejected, $get_current_item_request_text, $get_current_item_requester_user_id, $get_current_item_requester_user_name, $get_current_item_requester_user_alias, $get_current_item_requester_user_email, $get_current_item_requester_user_image_path, $get_current_item_requester_user_image_file, $get_current_item_requester_user_image_thumb_40, $get_current_item_requester_user_image_thumb_50, $get_current_item_requester_user_first_name, $get_current_item_requester_user_middle_name, $get_current_item_requester_user_last_name, $get_current_item_requester_user_job_title, $get_current_item_requester_user_department, $get_current_item_in_datetime, $get_current_item_in_date, $get_current_item_in_time, $get_current_item_in_date_saying, $get_current_item_in_date_ddmmyy, $get_current_item_in_date_ddmmyyyy, $get_current_item_comment, $get_current_item_condition, $get_current_item_serial_number, $get_current_item_imei_a, $get_current_item_imei_b, $get_current_item_imei_c, $get_current_item_imei_d, $get_current_item_os_title, $get_current_item_os_version, $get_current_item_timezone, $get_current_item_date_now_date, $get_current_item_date_now_saying, $get_current_item_date_now_ddmmyy, $get_current_item_date_now_ddmmyyyy, $get_current_item_time_now, $get_current_item_correct_date_now_date, $get_current_item_correct_date_now_saying, $get_current_item_correct_date_now_ddmmyy, $get_current_item_correct_date_now_ddmmyyyy, $get_current_item_correct_time_now, $get_current_item_adjust_clock_automatically, $get_current_item_acquired_software_id_a, $get_current_item_acquired_software_title_a, $get_current_item_acquired_software_notes_a, $get_current_item_acquired_software_id_b, $get_current_item_acquired_software_title_b, $get_current_item_acquired_software_notes_b, $get_current_item_acquired_software_id_c, $get_current_item_acquired_software_title_c, $get_current_item_acquired_software_notes_c, $get_current_item_acquired_date, $get_current_item_acquired_time, $get_current_item_acquired_date_saying, $get_current_item_acquired_date_ddmmyy, $get_current_item_acquired_date_ddmmyyyy, $get_current_item_acquired_user_id, $get_current_item_acquired_user_name, $get_current_item_acquired_user_alias, $get_current_item_acquired_user_email, $get_current_item_acquired_user_image_path, $get_current_item_acquired_user_image_file, $get_current_item_acquired_user_image_thumb_40, $get_current_item_acquired_user_image_thumb_50, $get_current_item_acquired_user_first_name, $get_current_item_acquired_user_middle_name, $get_current_item_acquired_user_last_name, $get_current_item_out_date, $get_current_item_out_time, $get_current_item_out_date_saying, $get_current_item_out_date_ddmmyy, $get_current_item_out_date_ddmmyyyy) = $row;
	

				// Mirror file
				$mirror_file_id = $_GET['mirror_file_id'];
				$mirror_file_id = output_html($mirror_file_id);
				$mirror_file_id_mysql = quote_smart($link, $mirror_file_id);

				$query = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_confirmed_by_human, mirror_file_human_rejected, mirror_file_created_datetime, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_modified_datetime, mirror_file_modified_time, mirror_file_modified_date_saying, mirror_file_modified_date_ddmmyy, mirror_file_size_bytes, mirror_file_size_mb, mirror_file_size_human, mirror_file_backup_disk, mirror_file_exists, mirror_file_exists_agent_tries_counter, mirror_file_ready_for_automated_machine, mirror_file_ready_agent_tries_counter, mirror_file_comments FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_id=$mirror_file_id_mysql AND mirror_file_case_id=$get_current_case_id AND mirror_file_item_id=$item_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_mirror_file_id, $get_current_mirror_file_case_id, $get_current_mirror_file_record_id, $get_current_mirror_file_item_id, $get_current_mirror_file_path_windows, $get_current_mirror_file_path_linux, $get_current_mirror_file_file, $get_current_mirror_file_ext, $get_current_mirror_file_type, $get_current_mirror_file_confirmed_by_human, $get_current_mirror_file_human_rejected, $get_current_mirror_file_created_datetime, $get_current_mirror_file_created_time, $get_current_mirror_file_created_date_saying, $get_current_mirror_file_created_date_ddmmyy, $get_current_mirror_file_modified_datetime, $get_current_mirror_file_modified_time, $get_current_mirror_file_modified_date_saying, $get_current_mirror_file_modified_date_ddmmyy, $get_current_mirror_file_size_bytes, $get_current_mirror_file_size_mb, $get_current_mirror_file_size_human, $get_current_mirror_file_backup_disk, $get_current_mirror_file_exists, $get_current_mirror_file_exists_agent_tries_counter, $get_current_mirror_file_ready_for_automated_machine, $get_current_mirror_file_ready_agent_tries_counter, $get_current_mirror_file_comments) = $row;
	
				if($get_current_mirror_file_id == ""){
					echo"Mirror file not found!";die;
				}	


				echo"
				<h2>$l_new_automated_task</h2>


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

				<!-- New automated task form -->
					<p>$l_task:</p>
					<div class=\"vertical\">
						<ul>\n";
	
							$query = "SELECT task_available_id, task_available_name, task_available_machine_type_id, task_available_machine_type_title, task_available_description FROM $t_edb_machines_all_tasks_available";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_task_available_id, $get_task_available_name, $get_task_available_machine_type_id, $get_task_available_machine_type_title, $get_task_available_description) = $row;
								echo"	<li><a href=\"open_case_automated_tasks.php?case_id=$get_current_case_id&amp;action=new_automated_task_step_4_select_glossaries&amp;item_id=$get_current_item_id&amp;mirror_file_id=$get_current_mirror_file_id&amp;task_available_id=$get_task_available_id&amp;l=$l\">$get_task_available_name<br /><span class=\"smal\">$get_task_available_description</span></a></li>\n";
							}
							echo"
						</ul>
					</div>
			
				<!-- //New automated task form -->
				";
			} // action == new automated task
			elseif($action == "new_automated_task_step_4_select_glossaries" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor")){

				// Item
				$item_id = $_GET['item_id'];
				$item_id = output_html($item_id);
				$item_id_mysql = quote_smart($link, $item_id);

				$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_in_date_ddmmyyyy, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_timezone, item_date_now_date, item_date_now_saying, item_date_now_ddmmyy, item_date_now_ddmmyyyy, item_time_now, item_correct_date_now_date, item_correct_date_now_saying, item_correct_date_now_ddmmyy, item_correct_date_now_ddmmyyyy, item_correct_time_now, item_adjust_clock_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_date_ddmmyyyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy, item_out_date_ddmmyyyy FROM $t_edb_case_index_evidence_items WHERE item_id=$item_id_mysql AND item_case_id=$get_current_case_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_item_id, $get_current_item_case_id, $get_current_item_record_id, $get_current_item_record_seized_year, $get_current_item_record_seized_journal, $get_current_item_record_seized_district_number, $get_current_item_numeric_serial_number, $get_current_item_title, $get_current_item_type_id, $get_current_item_type_title, $get_current_item_confirmed_by_human, $get_current_item_human_rejected, $get_current_item_request_text, $get_current_item_requester_user_id, $get_current_item_requester_user_name, $get_current_item_requester_user_alias, $get_current_item_requester_user_email, $get_current_item_requester_user_image_path, $get_current_item_requester_user_image_file, $get_current_item_requester_user_image_thumb_40, $get_current_item_requester_user_image_thumb_50, $get_current_item_requester_user_first_name, $get_current_item_requester_user_middle_name, $get_current_item_requester_user_last_name, $get_current_item_requester_user_job_title, $get_current_item_requester_user_department, $get_current_item_in_datetime, $get_current_item_in_date, $get_current_item_in_time, $get_current_item_in_date_saying, $get_current_item_in_date_ddmmyy, $get_current_item_in_date_ddmmyyyy, $get_current_item_comment, $get_current_item_condition, $get_current_item_serial_number, $get_current_item_imei_a, $get_current_item_imei_b, $get_current_item_imei_c, $get_current_item_imei_d, $get_current_item_os_title, $get_current_item_os_version, $get_current_item_timezone, $get_current_item_date_now_date, $get_current_item_date_now_saying, $get_current_item_date_now_ddmmyy, $get_current_item_date_now_ddmmyyyy, $get_current_item_time_now, $get_current_item_correct_date_now_date, $get_current_item_correct_date_now_saying, $get_current_item_correct_date_now_ddmmyy, $get_current_item_correct_date_now_ddmmyyyy, $get_current_item_correct_time_now, $get_current_item_adjust_clock_automatically, $get_current_item_acquired_software_id_a, $get_current_item_acquired_software_title_a, $get_current_item_acquired_software_notes_a, $get_current_item_acquired_software_id_b, $get_current_item_acquired_software_title_b, $get_current_item_acquired_software_notes_b, $get_current_item_acquired_software_id_c, $get_current_item_acquired_software_title_c, $get_current_item_acquired_software_notes_c, $get_current_item_acquired_date, $get_current_item_acquired_time, $get_current_item_acquired_date_saying, $get_current_item_acquired_date_ddmmyy, $get_current_item_acquired_date_ddmmyyyy, $get_current_item_acquired_user_id, $get_current_item_acquired_user_name, $get_current_item_acquired_user_alias, $get_current_item_acquired_user_email, $get_current_item_acquired_user_image_path, $get_current_item_acquired_user_image_file, $get_current_item_acquired_user_image_thumb_40, $get_current_item_acquired_user_image_thumb_50, $get_current_item_acquired_user_first_name, $get_current_item_acquired_user_middle_name, $get_current_item_acquired_user_last_name, $get_current_item_out_date, $get_current_item_out_time, $get_current_item_out_date_saying, $get_current_item_out_date_ddmmyy, $get_current_item_out_date_ddmmyyyy) = $row;
	

				// Mirror file
				$mirror_file_id = $_GET['mirror_file_id'];
				$mirror_file_id = output_html($mirror_file_id);
				$mirror_file_id_mysql = quote_smart($link, $mirror_file_id);

				$query = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_confirmed_by_human, mirror_file_human_rejected, mirror_file_created_datetime, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_modified_datetime, mirror_file_modified_time, mirror_file_modified_date_saying, mirror_file_modified_date_ddmmyy, mirror_file_size_bytes, mirror_file_size_mb, mirror_file_size_human, mirror_file_backup_disk, mirror_file_exists, mirror_file_exists_agent_tries_counter, mirror_file_ready_for_automated_machine, mirror_file_ready_agent_tries_counter, mirror_file_comments FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_id=$mirror_file_id_mysql AND mirror_file_case_id=$get_current_case_id AND mirror_file_item_id=$item_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_mirror_file_id, $get_current_mirror_file_case_id, $get_current_mirror_file_record_id, $get_current_mirror_file_item_id, $get_current_mirror_file_path_windows, $get_current_mirror_file_path_linux, $get_current_mirror_file_file, $get_current_mirror_file_ext, $get_current_mirror_file_type, $get_current_mirror_file_confirmed_by_human, $get_current_mirror_file_human_rejected, $get_current_mirror_file_created_datetime, $get_current_mirror_file_created_time, $get_current_mirror_file_created_date_saying, $get_current_mirror_file_created_date_ddmmyy, $get_current_mirror_file_modified_datetime, $get_current_mirror_file_modified_time, $get_current_mirror_file_modified_date_saying, $get_current_mirror_file_modified_date_ddmmyy, $get_current_mirror_file_size_bytes, $get_current_mirror_file_size_mb, $get_current_mirror_file_size_human, $get_current_mirror_file_backup_disk, $get_current_mirror_file_exists, $get_current_mirror_file_exists_agent_tries_counter, $get_current_mirror_file_ready_for_automated_machine, $get_current_mirror_file_ready_agent_tries_counter, $get_current_mirror_file_comments) = $row;

				// Task available
				$task_available_id = $_GET['task_available_id'];
				$task_available_id = strip_tags(stripslashes($task_available_id));
				$task_available_id_mysql = quote_smart($link, $task_available_id);

				$query = "SELECT task_available_id, task_available_name, task_available_machine_type_id, task_available_machine_type_title, task_available_description FROM $t_edb_machines_all_tasks_available WHERE task_available_id=$task_available_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_task_available_id, $get_current_task_available_name, $get_current_task_available_machine_type_id, $get_current_task_available_machine_type_title, $get_current_task_available_description) = $row;
	
	
				if($get_current_mirror_file_id == ""){
					echo"Mirror file not found!";die;
				}	

				if($get_current_task_available_id == ""){
					echo"Task available id not found!";die;
				}	


				if($process == "1"){
					// Glossaries
					$inp_glossaries_ids = "";
					$query = "SELECT case_glossary_id, case_glossary_glossary_title FROM $t_edb_case_index_glossaries WHERE case_glossary_case_id=$get_current_case_id ORDER BY case_glossary_glossary_title ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_case_glossary_id, $get_case_glossary_glossary_title) = $row;
					
						if(isset($_POST["inp_case_glossary_id_$get_case_glossary_id"])){

							$data = $_POST["inp_case_glossary_id_$get_case_glossary_id"];
							if($data == "on"){
								if($inp_glossaries_ids == ""){
									$inp_glossaries_ids = "$get_case_glossary_id";
								}
								else{
									$inp_glossaries_ids = $inp_glossaries_ids . ",$get_case_glossary_id";
								}
							}
						}
					}


					$url = "open_case_automated_tasks.php?case_id=$get_current_case_id&action=new_automated_task_step_5_dependent_on_automated_task&item_id=$get_current_item_id&mirror_file_id=$get_current_mirror_file_id&task_available_id=$get_current_task_available_id&glossaries_ids=$inp_glossaries_ids&l=$l";
					header("Location: $url");
					exit;
				}
				echo"
				<h2>$l_new_automated_task</h2>


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

				<!-- New automated task form -->
					<p>$l_do_you_want_to_attatch_any_glossaries</p>
		
					<form method=\"POST\" action=\"open_case_automated_tasks.php?case_id=$get_current_case_id&amp;action=new_automated_task_step_4_select_glossaries&amp;item_id=$get_current_item_id&amp;mirror_file_id=$get_current_mirror_file_id&amp;task_available_id=$get_current_task_available_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
		
					<div class=\"vertical\">
						<ul>\n";
					
	
						$query = "SELECT case_glossary_id, case_glossary_glossary_title FROM $t_edb_case_index_glossaries WHERE case_glossary_case_id=$get_current_case_id ORDER BY case_glossary_glossary_title ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_case_glossary_id, $get_case_glossary_glossary_title) = $row;

								echo"
								<li>
								<span style=\"float: left;padding-right: 5px;\">
								<input type=\"checkbox\" name=\"inp_case_glossary_id_$get_case_glossary_id\" id=\"inp_case_glossary_id_$get_case_glossary_id\" checked=\"checked\" />
								</span>	
								<label for=\"inp_case_glossary_id_$get_case_glossary_id\" style=\"padding-top: 2px;width:50%;\">$get_case_glossary_glossary_title</label>
								
								<div class=\"clear\"></div></li>\n";
						}
						echo"
						</ul>
					</div>
					

					<p>
					<input type=\"submit\" value=\"$l_next\" class=\"btn_default\" />
					</p>

					</form>

					<!-- On click text check checkbox -->
						<script>
						\$('.RedHover').click(
							function (e) {
								try {
									\$(this).children('input').trigger('click');
									e.stopPropagation();
									e.preventDefault();
								} catch (e) {
									//handle no click event.alert
								}
							}
						);
						</script>
					<!-- //On click text check checkbox -->

				<!-- //New automated task form -->
				";
			} // action == new automated task step 4
			elseif($action == "new_automated_task_step_5_dependent_on_automated_task" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor")){

				// Item
				$item_id = $_GET['item_id'];
				$item_id = output_html($item_id);
				$item_id_mysql = quote_smart($link, $item_id);

				$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_in_date_ddmmyyyy, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_timezone, item_date_now_date, item_date_now_saying, item_date_now_ddmmyy, item_date_now_ddmmyyyy, item_time_now, item_correct_date_now_date, item_correct_date_now_saying, item_correct_date_now_ddmmyy, item_correct_date_now_ddmmyyyy, item_correct_time_now, item_adjust_clock_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_date_ddmmyyyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy, item_out_date_ddmmyyyy FROM $t_edb_case_index_evidence_items WHERE item_id=$item_id_mysql AND item_case_id=$get_current_case_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_item_id, $get_current_item_case_id, $get_current_item_record_id, $get_current_item_record_seized_year, $get_current_item_record_seized_journal, $get_current_item_record_seized_district_number, $get_current_item_numeric_serial_number, $get_current_item_title, $get_current_item_type_id, $get_current_item_type_title, $get_current_item_confirmed_by_human, $get_current_item_human_rejected, $get_current_item_request_text, $get_current_item_requester_user_id, $get_current_item_requester_user_name, $get_current_item_requester_user_alias, $get_current_item_requester_user_email, $get_current_item_requester_user_image_path, $get_current_item_requester_user_image_file, $get_current_item_requester_user_image_thumb_40, $get_current_item_requester_user_image_thumb_50, $get_current_item_requester_user_first_name, $get_current_item_requester_user_middle_name, $get_current_item_requester_user_last_name, $get_current_item_requester_user_job_title, $get_current_item_requester_user_department, $get_current_item_in_datetime, $get_current_item_in_date, $get_current_item_in_time, $get_current_item_in_date_saying, $get_current_item_in_date_ddmmyy, $get_current_item_in_date_ddmmyyyy, $get_current_item_comment, $get_current_item_condition, $get_current_item_serial_number, $get_current_item_imei_a, $get_current_item_imei_b, $get_current_item_imei_c, $get_current_item_imei_d, $get_current_item_os_title, $get_current_item_os_version, $get_current_item_timezone, $get_current_item_date_now_date, $get_current_item_date_now_saying, $get_current_item_date_now_ddmmyy, $get_current_item_date_now_ddmmyyyy, $get_current_item_time_now, $get_current_item_correct_date_now_date, $get_current_item_correct_date_now_saying, $get_current_item_correct_date_now_ddmmyy, $get_current_item_correct_date_now_ddmmyyyy, $get_current_item_correct_time_now, $get_current_item_adjust_clock_automatically, $get_current_item_acquired_software_id_a, $get_current_item_acquired_software_title_a, $get_current_item_acquired_software_notes_a, $get_current_item_acquired_software_id_b, $get_current_item_acquired_software_title_b, $get_current_item_acquired_software_notes_b, $get_current_item_acquired_software_id_c, $get_current_item_acquired_software_title_c, $get_current_item_acquired_software_notes_c, $get_current_item_acquired_date, $get_current_item_acquired_time, $get_current_item_acquired_date_saying, $get_current_item_acquired_date_ddmmyy, $get_current_item_acquired_date_ddmmyyyy, $get_current_item_acquired_user_id, $get_current_item_acquired_user_name, $get_current_item_acquired_user_alias, $get_current_item_acquired_user_email, $get_current_item_acquired_user_image_path, $get_current_item_acquired_user_image_file, $get_current_item_acquired_user_image_thumb_40, $get_current_item_acquired_user_image_thumb_50, $get_current_item_acquired_user_first_name, $get_current_item_acquired_user_middle_name, $get_current_item_acquired_user_last_name, $get_current_item_out_date, $get_current_item_out_time, $get_current_item_out_date_saying, $get_current_item_out_date_ddmmyy, $get_current_item_out_date_ddmmyyyy) = $row;
	

				// Mirror file
				$mirror_file_id = $_GET['mirror_file_id'];
				$mirror_file_id = output_html($mirror_file_id);
				$mirror_file_id_mysql = quote_smart($link, $mirror_file_id);

				$query = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_confirmed_by_human, mirror_file_human_rejected, mirror_file_created_datetime, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_modified_datetime, mirror_file_modified_time, mirror_file_modified_date_saying, mirror_file_modified_date_ddmmyy, mirror_file_size_bytes, mirror_file_size_mb, mirror_file_size_human, mirror_file_backup_disk, mirror_file_exists, mirror_file_exists_agent_tries_counter, mirror_file_ready_for_automated_machine, mirror_file_ready_agent_tries_counter, mirror_file_comments FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_id=$mirror_file_id_mysql AND mirror_file_case_id=$get_current_case_id AND mirror_file_item_id=$item_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_mirror_file_id, $get_current_mirror_file_case_id, $get_current_mirror_file_record_id, $get_current_mirror_file_item_id, $get_current_mirror_file_path_windows, $get_current_mirror_file_path_linux, $get_current_mirror_file_file, $get_current_mirror_file_ext, $get_current_mirror_file_type, $get_current_mirror_file_confirmed_by_human, $get_current_mirror_file_human_rejected, $get_current_mirror_file_created_datetime, $get_current_mirror_file_created_time, $get_current_mirror_file_created_date_saying, $get_current_mirror_file_created_date_ddmmyy, $get_current_mirror_file_modified_datetime, $get_current_mirror_file_modified_time, $get_current_mirror_file_modified_date_saying, $get_current_mirror_file_modified_date_ddmmyy, $get_current_mirror_file_size_bytes, $get_current_mirror_file_size_mb, $get_current_mirror_file_size_human, $get_current_mirror_file_backup_disk, $get_current_mirror_file_exists, $get_current_mirror_file_exists_agent_tries_counter, $get_current_mirror_file_ready_for_automated_machine, $get_current_mirror_file_ready_agent_tries_counter, $get_current_mirror_file_comments) = $row;

				// Task available
				$task_available_id = $_GET['task_available_id'];
				$task_available_id = strip_tags(stripslashes($task_available_id));
				$task_available_id_mysql = quote_smart($link, $task_available_id);

				$query = "SELECT task_available_id, task_available_name, task_available_machine_type_id, task_available_machine_type_title, task_available_description FROM $t_edb_machines_all_tasks_available WHERE task_available_id=$task_available_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_task_available_id, $get_current_task_available_name, $get_current_task_available_machine_type_id, $get_current_task_available_machine_type_title, $get_current_task_available_description) = $row;
	
	
				if($get_current_mirror_file_id == ""){
					echo"Mirror file not found!";die;
				}	

				if($get_current_task_available_id == ""){
					echo"Task available id not found!";die;
				}	

				// Glossaries IDs
				if(isset($_GET['glossaries_ids'])) {
					$glossaries_ids = $_GET['glossaries_ids'];
					$glossaries_ids = strip_tags(stripslashes($glossaries_ids));
				}
				else{
					$glossaries_ids = "";
				}


				if($process == "1"){
					$inp_record_id_mysql = quote_smart($link, $get_current_item_record_id);

					$inp_full_title = "$get_current_item_record_seized_year/$get_current_item_record_id-$get_current_item_record_seized_journal-$get_current_item_record_seized_district_number-$get_current_item_numeric_serial_number $get_current_item_title";
					$inp_full_title_mysql = quote_smart($link, $inp_full_title);

					// Mirror file
					$inp_automated_task_mirror_file_path_windows_mysql = quote_smart($link, $get_current_mirror_file_path_windows);
					$inp_automated_task_mirror_file_path_linux_mysql = quote_smart($link, $get_current_mirror_file_path_linux);
					$inp_automated_task_mirror_file_file_mysql = quote_smart($link, $get_current_mirror_file_file);


					$inp_automated_task_task_available_name_mysql = quote_smart($link, $get_current_task_available_name);
					$inp_machine_type_id_mysql = quote_smart($link, $get_current_task_available_machine_type_id);
					$inp_machine_type_title_mysql = quote_smart($link, $get_current_task_available_machine_type_title);

					// Station
					$inp_automated_task_station_id_mysql = quote_smart($link, $get_current_case_station_id);
					$inp_automated_task_station_title_mysql = quote_smart($link, $get_current_case_station_title);

					// Glossaries
					$inp_glossaries_ids = output_html($glossaries_ids);
					$inp_glossaries_ids_mysql = quote_smart($link, $inp_glossaries_ids);
					
					// Depends on
					$inp_dependent_on_automated_task_id = "0";
					$inp_dependent_on_automated_task_title = "";
					if(isset($_GET['dependent'])) {
						$dependent = $_GET['dependent'];
						$dependent = strip_tags(stripslashes($dependent));
						$dependent_mysql = quote_smart($link, $dependent);
						
						$query = "SELECT automated_task_id, automated_task_evidence_full_title, automated_task_task_available_name FROM $t_edb_case_index_automated_tasks WHERE automated_task_id=$dependent_mysql";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_automated_task_id, $get_automated_task_evidence_full_title, $get_automated_task_task_available_name) = $row;
						if($get_automated_task_id != ""){
							$inp_dependent_on_automated_task_id = "$get_automated_task_id";
							$inp_dependent_on_automated_task_title = "$get_automated_task_evidence_full_title &middot; $get_automated_task_task_available_name";

						}
					}
					else{
						$dependent = "";
					}
					$inp_dependent_on_automated_task_id_mysql = quote_smart($link, $inp_dependent_on_automated_task_id);
					$inp_dependent_on_automated_task_title_mysql = quote_smart($link, $inp_dependent_on_automated_task_title);
					

					// Dates
					$inp_datetime = date("Y-m-d H:i:s");
					$inp_time = time();
					$inp_date_saying = date("j M Y");
					$inp_date_ddmmyy = date("d.m.y");
					$inp_date_ddmmyyyy = date("d.m.Y");


					// Me $my_user_id_mysql 
					$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_id=$my_user_id_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_language, $get_my_user_last_online, $get_my_user_rank, $get_my_user_login_tries) = $row;
				
					$inp_my_user_email_mysql = quote_smart($link, $get_my_user_email);	
			
					// Create temporary file, then look for automated_task_dependent_on_automated_task_id
					




					mysqli_query($link, "INSERT INTO $t_edb_case_index_automated_tasks
					(automated_task_id, automated_task_case_id, automated_task_evidence_record_id, automated_task_evidence_item_id, automated_task_evidence_full_title, 
					automated_task_task_available_id, automated_task_task_available_name, automated_task_task_machine_type_id, automated_task_task_machine_type_title, 
					automated_task_station_id, automated_task_station_title, 
					automated_task_mirror_file_id, automated_task_mirror_file_path_windows, automated_task_mirror_file_path_linux, automated_task_mirror_file_file, automated_task_glossaries_ids, automated_task_priority, 
					automated_task_dependent_on_automated_task_id, automated_task_dependent_on_automated_task_title, 
					automated_task_added_by_user_id, automated_task_added_by_user_email, 
					automated_task_added_datetime, automated_task_added_time, automated_task_added_date_saying, automated_task_added_date_ddmmyy, automated_task_added_date_ddmmyyyy,
					automated_task_is_finished,
					automated_task_machine_id) 
					VALUES 
					(NULL, $get_current_case_id, $inp_record_id_mysql, $get_current_item_id, $inp_full_title_mysql, 
					$get_current_task_available_id, $inp_automated_task_task_available_name_mysql, $inp_machine_type_id_mysql, $inp_machine_type_title_mysql, 
					$inp_automated_task_station_id_mysql, $inp_automated_task_station_title_mysql, 
					$get_current_mirror_file_id, $inp_automated_task_mirror_file_path_windows_mysql, $inp_automated_task_mirror_file_path_linux_mysql, $inp_automated_task_mirror_file_file_mysql, $inp_glossaries_ids_mysql, 1,
					$inp_dependent_on_automated_task_id_mysql, $inp_dependent_on_automated_task_title_mysql, 
					$get_my_user_id, $inp_my_user_email_mysql,
					'$inp_datetime', '$inp_time', '$inp_date_saying', '$inp_date_ddmmyy', '$inp_date_ddmmyyyy', 
					0,
					0)")
					or die(mysqli_error($link));


					$url = "open_case_automated_tasks.php?case_id=$get_current_case_id&l=$l&ft=success&fm=automatic_task_created";
					header("Location: $url");
					exit;
				}
				echo"
				<h2>$l_new_automated_task</h2>


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

				<!-- Does this task depend on another task? -->
					<p>$l_does_this_task_depend_on_another_task</p>

					<div class=\"vertical\">
						<ul>
							<li><a href=\"open_case_automated_tasks.php?case_id=$get_current_case_id&amp;action=new_automated_task_step_5_dependent_on_automated_task&amp;item_id=$get_current_item_id&amp;mirror_file_id=$get_current_mirror_file_id&amp;task_available_id=$get_current_task_available_id&amp;glossaries_ids=$glossaries_ids&amp;l=$l&amp;process=1\">$l_no</a></li>\n";
					
						$query = "SELECT automated_task_id, automated_task_case_id, automated_task_evidence_record_id, automated_task_evidence_item_id, automated_task_evidence_full_title, automated_task_task_available_id, automated_task_task_available_name, automated_task_task_machine_type_id, automated_task_task_machine_type_title, automated_task_mirror_file_id, automated_task_mirror_file_path_windows, automated_task_mirror_file_path_linux, automated_task_mirror_file_file, automated_task_added_datetime, automated_task_added_date, automated_task_added_time, automated_task_added_date_saying, automated_task_added_date_ddmmyy, automated_task_added_date_ddmmyyyy, automated_task_started_datetime, automated_task_started_date, automated_task_started_time, automated_task_started_date_saying, automated_task_started_date_ddmmyyhi, automated_task_started_date_ddmmyyyyhi, automated_task_machine_id, automated_task_machine_name, automated_task_is_finished, automated_task_finished_datetime, automated_task_finished_date, automated_task_finished_time, automated_task_finished_date_saying, automated_task_finished_date_ddmmyyhi, automated_task_finished_date_ddmmyyyyhi, automated_task_time_taken_time, automated_task_time_taken_human FROM $t_edb_case_index_automated_tasks WHERE automated_task_case_id=$get_current_case_id AND automated_task_dependent_on_automated_task_id='0' ORDER BY automated_task_id ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_automated_task_id, $get_automated_task_case_id, $get_automated_task_evidence_record_id, $get_automated_task_evidence_item_id, $get_automated_task_evidence_full_title, $get_automated_task_task_available_id, $get_automated_task_task_available_name, $get_automated_task_task_machine_type_id, $get_automated_task_task_machine_type_title, $get_automated_task_mirror_file_id, $get_automated_task_mirror_file_path_windows, $get_automated_task_mirror_file_path_linux, $get_automated_task_mirror_file_file, $get_automated_task_added_datetime, $get_automated_task_added_date, $get_automated_task_added_time, $get_automated_task_added_date_saying, $get_automated_task_added_date_ddmmyy, $get_automated_task_added_date_ddmmyyyy, $get_automated_task_started_datetime, $get_automated_task_started_date, $get_automated_task_started_time, $get_automated_task_started_date_saying, $get_automated_task_started_date_ddmmyyhi, $get_automated_task_started_date_ddmmyyyyhi, $get_automated_task_machine_id, $get_automated_task_machine_name, $get_automated_task_is_finished, $get_automated_task_finished_datetime, $get_automated_task_finished_date, $get_automated_task_finished_time, $get_automated_task_finished_date_saying, $get_automated_task_finished_date_ddmmyyhi, $get_automated_task_finished_date_ddmmyyyyhi, $get_automated_task_time_taken_time, $get_automated_task_time_taken_human) = $row;

							echo"
							<li><a href=\"open_case_automated_tasks.php?case_id=$get_current_case_id&amp;action=new_automated_task_step_5_dependent_on_automated_task&amp;item_id=$get_current_item_id&amp;mirror_file_id=$get_current_mirror_file_id&amp;task_available_id=$get_current_task_available_id&amp;glossaries_ids=$glossaries_ids&amp;dependent=$get_automated_task_id&amp;l=$l&amp;process=1\">$get_automated_task_evidence_full_title &middot; $get_automated_task_task_available_name</a></li>\n";
						}
						echo"
						</ul>
					</div>
					



				<!-- //Does this task depend on another task? -->
				";
			} // action == 5_dependent_on_automated_task
			elseif($action == "edit_task" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor")){
				if(isset($_GET['automated_task_id'])) {
					$automated_task_id = $_GET['automated_task_id'];
					$automated_task_id = strip_tags(stripslashes($automated_task_id));
				}
				else{
					$automated_task_id = "";
				}
				$automated_task_id_mysql = quote_smart($link, $automated_task_id);

				// Find automated task
				$query = "SELECT automated_task_id, automated_task_case_id, automated_task_evidence_record_id, automated_task_evidence_item_id, automated_task_evidence_full_title, automated_task_task_available_id, automated_task_task_available_name, automated_task_task_machine_type_id, automated_task_task_machine_type_title, automated_task_mirror_file_id, automated_task_mirror_file_path_windows, automated_task_mirror_file_path_linux, automated_task_mirror_file_file, automated_task_glossaries_ids, automated_task_priority, automated_task_added_datetime, automated_task_added_date, automated_task_added_time, automated_task_added_date_saying, automated_task_added_date_ddmmyy, automated_task_added_date_ddmmyyyy, automated_task_started_datetime, automated_task_started_date, automated_task_started_time, automated_task_started_date_saying, automated_task_started_date_ddmmyyhi, automated_task_started_date_ddmmyyyyhi, automated_task_machine_id, automated_task_machine_name, automated_task_is_finished, automated_task_finished_datetime, automated_task_finished_date, automated_task_finished_time, automated_task_finished_date_saying, automated_task_finished_date_ddmmyyhi, automated_task_finished_date_ddmmyyyyhi, automated_task_time_taken_time, automated_task_time_taken_human FROM $t_edb_case_index_automated_tasks WHERE automated_task_id=$automated_task_id_mysql AND automated_task_case_id=$get_current_case_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_automated_task_id, $get_current_automated_task_case_id, $get_current_automated_task_evidence_record_id, $get_current_automated_task_evidence_item_id, $get_current_automated_task_evidence_full_title, $get_current_automated_task_task_available_id, $get_current_automated_task_task_available_name, $get_current_automated_task_task_machine_type_id, $get_current_automated_task_task_machine_type_title, $get_current_automated_task_mirror_file_id, $get_current_automated_task_mirror_file_path_windows, $get_current_automated_task_mirror_file_path_linux, $get_current_automated_task_mirror_file_file, $get_current_automated_task_glossaries_ids, $get_current_automated_task_priority, $get_current_automated_task_added_datetime, $get_current_automated_task_added_date, $get_current_automated_task_added_time, $get_current_automated_task_added_date_saying, $get_current_automated_task_added_date_ddmmyy, $get_current_automated_task_added_date_ddmmyyyy, $get_current_automated_task_started_datetime, $get_current_automated_task_started_date, $get_current_automated_task_started_time, $get_current_automated_task_started_date_saying, $get_current_automated_task_started_date_ddmmyyhi, $get_current_automated_task_started_date_ddmmyyyyhi, $get_current_automated_task_machine_id, $get_current_automated_task_machine_name, $get_current_automated_task_is_finished, $get_current_automated_task_finished_datetime, $get_current_automated_task_finished_date, $get_current_automated_task_finished_time, $get_current_automated_task_finished_date_saying, $get_current_automated_task_finished_date_ddmmyyhi, $get_current_automated_task_finished_date_ddmmyyyyhi, $get_current_automated_task_time_taken_time, $get_current_automated_task_time_taken_human) = $row;
		
				if($get_current_automated_task_id == ""){
					echo"
					<h2>Automated task not found</h2>
					<p><a href=\"open_case_automated_tasks.php?case_id=$get_current_case_id&amp;l=$l\">Automated tasks</a></p>
					";
				}
				else{

					if($process == "1"){
						$inp_item_id = $_POST['inp_item_id'];
						$inp_item_id = output_html($inp_item_id);
						$inp_item_id_mysql = quote_smart($link, $inp_item_id);

						// Item
						$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title, item_confirmed_by_human, item_human_rejected, item_request_text, item_requester_user_id, item_requester_user_name, item_requester_user_alias, item_requester_user_email, item_requester_user_image_path, item_requester_user_image_file, item_requester_user_image_thumb_40, item_requester_user_image_thumb_50, item_requester_user_first_name, item_requester_user_middle_name, item_requester_user_last_name, item_requester_user_job_title, item_requester_user_department, item_in_datetime, item_in_date, item_in_time, item_in_date_saying, item_in_date_ddmmyy, item_in_date_ddmmyyyy, item_comment, item_condition, item_serial_number, item_imei_a, item_imei_b, item_imei_c, item_imei_d, item_os_title, item_os_version, item_timezone, item_date_now_date, item_date_now_saying, item_date_now_ddmmyy, item_date_now_ddmmyyyy, item_time_now, item_correct_date_now_date, item_correct_date_now_saying, item_correct_date_now_ddmmyy, item_correct_date_now_ddmmyyyy, item_correct_time_now, item_adjust_clock_automatically, item_acquired_software_id_a, item_acquired_software_title_a, item_acquired_software_notes_a, item_acquired_software_id_b, item_acquired_software_title_b, item_acquired_software_notes_b, item_acquired_software_id_c, item_acquired_software_title_c, item_acquired_software_notes_c, item_acquired_date, item_acquired_time, item_acquired_date_saying, item_acquired_date_ddmmyy, item_acquired_date_ddmmyyyy, item_acquired_user_id, item_acquired_user_name, item_acquired_user_alias, item_acquired_user_email, item_acquired_user_image_path, item_acquired_user_image_file, item_acquired_user_image_thumb_40, item_acquired_user_image_thumb_50, item_acquired_user_first_name, item_acquired_user_middle_name, item_acquired_user_last_name, item_out_date, item_out_time, item_out_date_saying, item_out_date_ddmmyy, item_out_date_ddmmyyyy FROM $t_edb_case_index_evidence_items WHERE item_id=$inp_item_id_mysql AND item_case_id=$get_current_case_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_current_item_id, $get_current_item_case_id, $get_current_item_record_id, $get_current_item_record_seized_year, $get_current_item_record_seized_journal, $get_current_item_record_seized_district_number, $get_current_item_numeric_serial_number, $get_current_item_title, $get_current_item_type_id, $get_current_item_type_title, $get_current_item_confirmed_by_human, $get_current_item_human_rejected, $get_current_item_request_text, $get_current_item_requester_user_id, $get_current_item_requester_user_name, $get_current_item_requester_user_alias, $get_current_item_requester_user_email, $get_current_item_requester_user_image_path, $get_current_item_requester_user_image_file, $get_current_item_requester_user_image_thumb_40, $get_current_item_requester_user_image_thumb_50, $get_current_item_requester_user_first_name, $get_current_item_requester_user_middle_name, $get_current_item_requester_user_last_name, $get_current_item_requester_user_job_title, $get_current_item_requester_user_department, $get_current_item_in_datetime, $get_current_item_in_date, $get_current_item_in_time, $get_current_item_in_date_saying, $get_current_item_in_date_ddmmyy, $get_current_item_in_date_ddmmyyyy, $get_current_item_comment, $get_current_item_condition, $get_current_item_serial_number, $get_current_item_imei_a, $get_current_item_imei_b, $get_current_item_imei_c, $get_current_item_imei_d, $get_current_item_os_title, $get_current_item_os_version, $get_current_item_timezone, $get_current_item_date_now_date, $get_current_item_date_now_saying, $get_current_item_date_now_ddmmyy, $get_current_item_date_now_ddmmyyyy, $get_current_item_time_now, $get_current_item_correct_date_now_date, $get_current_item_correct_date_now_saying, $get_current_item_correct_date_now_ddmmyy, $get_current_item_correct_date_now_ddmmyyyy, $get_current_item_correct_time_now, $get_current_item_adjust_clock_automatically, $get_current_item_acquired_software_id_a, $get_current_item_acquired_software_title_a, $get_current_item_acquired_software_notes_a, $get_current_item_acquired_software_id_b, $get_current_item_acquired_software_title_b, $get_current_item_acquired_software_notes_b, $get_current_item_acquired_software_id_c, $get_current_item_acquired_software_title_c, $get_current_item_acquired_software_notes_c, $get_current_item_acquired_date, $get_current_item_acquired_time, $get_current_item_acquired_date_saying, $get_current_item_acquired_date_ddmmyy, $get_current_item_acquired_date_ddmmyyyy, $get_current_item_acquired_user_id, $get_current_item_acquired_user_name, $get_current_item_acquired_user_alias, $get_current_item_acquired_user_email, $get_current_item_acquired_user_image_path, $get_current_item_acquired_user_image_file, $get_current_item_acquired_user_image_thumb_40, $get_current_item_acquired_user_image_thumb_50, $get_current_item_acquired_user_first_name, $get_current_item_acquired_user_middle_name, $get_current_item_acquired_user_last_name, $get_current_item_out_date, $get_current_item_out_time, $get_current_item_out_date_saying, $get_current_item_out_date_ddmmyy, $get_current_item_out_date_ddmmyyyy) = $row;
	
						$inp_record_id_mysql = quote_smart($link, $get_current_item_record_id);

						$inp_full_title = "$get_current_item_record_seized_year/$get_current_item_record_id-$get_current_item_record_seized_journal-$get_current_item_record_seized_district_number-$get_current_item_numeric_serial_number $get_current_item_title";
						$inp_full_title_mysql = quote_smart($link, $inp_full_title);

						$inp_task_available_id = $_POST['inp_task_available_id'];
						$inp_task_available_id = output_html($inp_task_available_id);
						$inp_task_available_id_mysql = quote_smart($link, $inp_task_available_id);
						$query = "SELECT task_available_id, task_available_name, task_available_machine_type_id, task_available_machine_type_title, task_available_description FROM $t_edb_machines_all_tasks_available WHERE task_available_id=$inp_task_available_id_mysql";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_current_task_available_id, $get_current_task_available_name, $get_current_task_available_machine_type_id, $get_current_task_available_machine_type_title, $get_current_task_available_description) = $row;
	
						$inp_automated_task_task_available_name_mysql = quote_smart($link, $get_current_task_available_name);
						$inp_machine_type_id_mysql = quote_smart($link, $get_current_task_available_machine_type_id);
						$inp_machine_type_title_mysql = quote_smart($link, $get_current_task_available_machine_type_title);

						// Mirror file
						$inp_mirror_file_id = $_POST['inp_mirror_file_id'];
						$inp_mirror_file_id = output_html($inp_mirror_file_id);
						$inp_mirror_file_id_mysql = quote_smart($link, $inp_mirror_file_id);

						$query = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_confirmed_by_human, mirror_file_human_rejected, mirror_file_created_datetime, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_modified_datetime, mirror_file_modified_time, mirror_file_modified_date_saying, mirror_file_modified_date_ddmmyy, mirror_file_size_bytes, mirror_file_size_mb, mirror_file_size_human, mirror_file_backup_disk, mirror_file_exists, mirror_file_exists_agent_tries_counter, mirror_file_ready_for_automated_machine, mirror_file_ready_agent_tries_counter, mirror_file_comments FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_id=$inp_mirror_file_id_mysql AND mirror_file_case_id=$get_current_case_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_current_mirror_file_id, $get_current_mirror_file_case_id, $get_current_mirror_file_record_id, $get_current_mirror_file_item_id, $get_current_mirror_file_path_windows, $get_current_mirror_file_path_linux, $get_current_mirror_file_file, $get_current_mirror_file_ext, $get_current_mirror_file_type, $get_current_mirror_file_confirmed_by_human, $get_current_mirror_file_human_rejected, $get_current_mirror_file_created_datetime, $get_current_mirror_file_created_time, $get_current_mirror_file_created_date_saying, $get_current_mirror_file_created_date_ddmmyy, $get_current_mirror_file_modified_datetime, $get_current_mirror_file_modified_time, $get_current_mirror_file_modified_date_saying, $get_current_mirror_file_modified_date_ddmmyy, $get_current_mirror_file_size_bytes, $get_current_mirror_file_size_mb, $get_current_mirror_file_size_human, $get_current_mirror_file_backup_disk, $get_current_mirror_file_exists, $get_current_mirror_file_exists_agent_tries_counter, $get_current_mirror_file_ready_for_automated_machine, $get_current_mirror_file_ready_agent_tries_counter, $get_current_mirror_file_comments) = $row;

						// Mirror file
						$inp_automated_task_mirror_file_path_windows_mysql = quote_smart($link, $get_current_mirror_file_path_windows);
						$inp_automated_task_mirror_file_path_linux_mysql = quote_smart($link, $get_current_mirror_file_path_linux);
						$inp_automated_task_mirror_file_file_mysql = quote_smart($link, $get_current_mirror_file_file);



						// Dates
						$inp_datetime = date("Y-m-d H:i:s");
						$inp_time = time();
						$inp_date_saying = date("j M Y");
						$inp_date_ddmmyy = date("d.m.y");

						// Machine working on the task now
						$inp_automated_task_machine_id = $_POST['inp_automated_task_machine_id'];
						$inp_automated_task_machine_id = output_html($inp_automated_task_machine_id);
						$inp_automated_task_machine_id_mysql = quote_smart($link, $inp_automated_task_machine_id);

						if($inp_automated_task_machine_id == "0"){
							$get_current_machine_name = "";

							// Already a machine working with the task, and we have removed it?
							if($inp_automated_task_machine_id != "$get_current_automated_task_machine_id" && $get_current_automated_task_machine_id != ""){
								// Lookup machine and remove task ID from it
								$result = mysqli_query($link, "UPDATE $t_edb_machines_index  SET 
								machine_is_working_with_automated_task_id=NULL
								 WHERE machine_id=$get_current_automated_task_machine_id") or die(mysqli_error($link));
								

							}
						}
						else{
							// Get machine name
							$query = "SELECT machine_id, machine_name FROM $t_edb_machines_index WHERE machine_id=$inp_automated_task_machine_id_mysql";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_current_machine_id, $get_current_machine_name) = $row;
						}
						$inp_automated_task_machine_name_mysql = quote_smart($link, $get_current_machine_name);

						
						// Glossaries
						$inp_glossaries_ids = "";
						$query = "SELECT case_glossary_id, case_glossary_glossary_title FROM $t_edb_case_index_glossaries WHERE case_glossary_case_id=$get_current_case_id ORDER BY case_glossary_glossary_title ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_case_glossary_id, $get_case_glossary_glossary_title) = $row;
					
							if(isset($_POST["inp_case_glossary_id_$get_case_glossary_id"])){

								$data = $_POST["inp_case_glossary_id_$get_case_glossary_id"];
								if($data == "on"){
									if($inp_glossaries_ids == ""){
										$inp_glossaries_ids = "$get_case_glossary_id";
									}
									else{
										$inp_glossaries_ids = $inp_glossaries_ids . ",$get_case_glossary_id";
									}
								}
							}
						}
						$inp_glossaries_ids_mysql = quote_smart($link, $inp_glossaries_ids);
				
						// Update
						$result = mysqli_query($link, "UPDATE $t_edb_case_index_automated_tasks SET 
								automated_task_evidence_record_id=$inp_record_id_mysql, 
								automated_task_evidence_item_id=$inp_item_id_mysql, 
								automated_task_evidence_full_title=$inp_full_title_mysql, 
								automated_task_task_available_id=$get_current_task_available_id,
								automated_task_task_available_name=$inp_automated_task_task_available_name_mysql,
								automated_task_task_machine_type_id=$inp_machine_type_id_mysql,
								automated_task_task_machine_type_title=$inp_machine_type_title_mysql,

								automated_task_mirror_file_id=$inp_mirror_file_id_mysql,
								automated_task_mirror_file_path_windows=$inp_automated_task_mirror_file_path_windows_mysql,
								automated_task_mirror_file_path_linux=$inp_automated_task_mirror_file_path_linux_mysql,
								automated_task_mirror_file_file=$inp_automated_task_mirror_file_file_mysql,

								automated_task_glossaries_ids=$inp_glossaries_ids_mysql, 

								automated_task_started_datetime=NULL, 
								automated_task_started_date=NULL, 
								automated_task_started_date_saying=NULL, 
								automated_task_started_date_ddmmyyhi=NULL, 
								automated_task_started_date_ddmmyyyyhi=NULL,

								automated_task_machine_id=$inp_automated_task_machine_id_mysql,
								automated_task_machine_name=$inp_automated_task_machine_name_mysql
								 WHERE automated_task_id=$get_current_automated_task_id") or die(mysqli_error($link));

						$saved_time = date("H:i:s");
						$url = "open_case_automated_tasks.php?case_id=$get_current_case_id&action=edit_task&automated_task_id=$get_current_automated_task_id&l=$l&ft=success&fm=changes_saved_$saved_time";
						header("Location: $url");
						exit;

					}
					echo"
					<h2>$l_edit_automated_task</h2>

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
							\$('[name=\"inp_item_id\"]').focus();
						});
					</script>
					<!-- //Focus -->
		
					<!-- Edit automated task form -->
						<form method=\"POST\" action=\"open_case_automated_tasks.php?case_id=$get_current_case_id&amp;action=$action&amp;automated_task_id=$get_current_automated_task_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
		
						<p>$l_evidence_item:<br />
						<select name=\"inp_item_id\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" class=\"on_change_submit_form\">";
						$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title, item_type_id, item_type_title FROM $t_edb_case_index_evidence_items WHERE item_case_id=$get_current_case_id ORDER BY item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_item_id, $get_item_case_id, $get_item_record_id, $get_item_record_seized_year, $get_item_record_seized_journal, $get_item_record_seized_district_number, $get_item_numeric_serial_number, $get_item_title, $get_item_type_id, $get_item_type_title) = $row;
							echo"<option value=\"$get_item_id\""; if($get_item_id == "$get_current_automated_task_evidence_item_id"){ echo" selected=\"selected\""; } echo">$get_item_record_seized_year/$get_item_record_seized_journal-$get_item_record_seized_district_number-$get_item_numeric_serial_number $get_item_title</option>\n";
						}
						echo"
						</select>
						</p>

						<p>$l_mirror_file:<br />
						<select name=\"inp_mirror_file_id\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" class=\"on_change_submit_form\">";
						$query = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_confirmed_by_human, mirror_file_human_rejected, mirror_file_created_datetime, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_modified_datetime, mirror_file_modified_time, mirror_file_modified_date_saying, mirror_file_modified_date_ddmmyy, mirror_file_size_bytes, mirror_file_size_mb, mirror_file_size_human, mirror_file_backup_disk, mirror_file_exists, mirror_file_exists_agent_tries_counter, mirror_file_ready_for_automated_machine, mirror_file_ready_agent_tries_counter, mirror_file_comments FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_case_id=$get_current_automated_task_case_id AND mirror_file_item_id=$get_current_automated_task_evidence_item_id";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_mirror_file_id, $get_mirror_file_case_id, $get_mirror_file_record_id, $get_mirror_file_item_id, $get_mirror_file_path_windows, $get_mirror_file_path_linux, $get_mirror_file_file, $get_mirror_file_ext, $get_mirror_file_type, $get_mirror_file_confirmed_by_human, $get_mirror_file_human_rejected, $get_mirror_file_created_datetime, $get_mirror_file_created_time, $get_mirror_file_created_date_saying, $get_mirror_file_created_date_ddmmyy, $get_mirror_file_modified_datetime, $get_mirror_file_modified_time, $get_mirror_file_modified_date_saying, $get_mirror_file_modified_date_ddmmyy, $get_mirror_file_size_bytes, $get_mirror_file_size_mb, $get_mirror_file_size_human, $get_mirror_file_backup_disk, $get_mirror_file_exists, $get_mirror_file_exists_agent_tries_counter, $get_mirror_file_ready_for_automated_machine, $get_mirror_file_ready_agent_tries_counter, $get_mirror_file_comments) = $row;
			
							echo"<option value=\"$get_mirror_file_id\""; if($get_mirror_file_id == "$get_current_automated_task_mirror_file_id"){ echo" selected=\"selected\""; } echo">$get_mirror_file_file</option>\n";
						}
						echo"
						</select>
						</p>

						<p>$l_task:<br />
						<select name=\"inp_task_available_id\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" class=\"on_change_submit_form\">";
						$query = "SELECT task_available_id, task_available_name, task_available_machine_type_id, task_available_machine_type_title, task_available_description FROM $t_edb_machines_all_tasks_available";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_task_available_id, $get_task_available_name, $get_task_available_machine_type_id, $get_task_available_machine_type_title, $get_task_available_description) = $row;
							echo"<option value=\"$get_task_available_id\""; if($get_task_available_id == "$get_current_automated_task_task_available_id"){ echo" selected=\"selected\""; } echo">$get_task_available_name</option>\n";
						}
						echo"
						</select>
						</p>

						<p>$l_machine_working_on_task_now ($l_set_to_blank_if_machine_is_stuck):<br />
						<select name=\"inp_automated_task_machine_id\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" class=\"on_change_submit_form\">
							<option value=\"0\""; if($get_current_automated_task_machine_id == "0"){ echo" selected=\"selected\""; } echo"> - </option>\n";
						$query = "SELECT machine_id, machine_name FROM $t_edb_machines_index";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_machine_id, $get_machine_name) = $row;
							echo"<option value=\"$get_machine_id\""; if($get_machine_id == "$get_current_automated_task_machine_id"){ echo" selected=\"selected\""; } echo">$get_machine_name";

							// Machine types
							$types_saying = "";
							$query_it = "SELECT machine_index_type_id, machine_index_type_type_id, machine_index_type_type_title FROM $t_edb_machines_index_types WHERE machine_index_type_machine_id=$get_machine_id";
							$result_it = mysqli_query($link, $query_it);
							while($row_it = mysqli_fetch_row($result_it)) {
								list($get_machine_index_type_id, $get_machine_index_type_type_id, $get_machine_index_type_type_title) = $row_it;
								if($types_saying == ""){
									$types_saying = "$get_machine_index_type_type_title";
								}
								else{
									$types_saying = "$types_saying, " . "$get_machine_index_type_type_title";
								}
							}
							echo" ($types_saying)</option>\n";
						}
						echo"
						</select>
						</p>

						<p style=\"padding-bottom:0;margin-bottom:0;\">$l_glossaries:</p>\n";
					
						$automated_task_glossaries_ids_array = explode(",", $get_current_automated_task_glossaries_ids);
						$query = "SELECT case_glossary_id, case_glossary_glossary_title FROM $t_edb_case_index_glossaries WHERE case_glossary_case_id=$get_current_case_id ORDER BY case_glossary_glossary_title ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_case_glossary_id, $get_case_glossary_glossary_title) = $row;

								echo"
								<span style=\"float: left;padding-right: 5px;\">
								<input type=\"checkbox\" name=\"inp_case_glossary_id_$get_case_glossary_id\" id=\"inp_case_glossary_id_$get_case_glossary_id\"";
							

								for($x=0;$x<sizeof($automated_task_glossaries_ids_array);$x++){
									$id = $automated_task_glossaries_ids_array[$x];
									if($get_case_glossary_id == "$id"){
										echo" checked=\"checked\"";

									}
								}
								echo" />
								</span>	
								<label for=\"inp_case_glossary_id_$get_case_glossary_id\" style=\"padding-top: 2px;width:60%;\">$get_case_glossary_glossary_title</label>
								<div class=\"clear\"></div>\n";
						}
						echo"
						</p>


						<p>
						<input type=\"submit\" value=\"$l_save_task\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
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
						<!-- //Edit automated task form -->



							<!-- Refresh every 5 minutes -->
								<meta http-equiv=\"refresh\" content=\"300;url=open_case_automated_tasks.php?case_id=$get_current_case_id&action=edit_task&amp;automated_task_id=$get_automated_task_id&amp;l=$l\">
							<!-- //Refresh every 5 minutes -->
							";
						} // automated task found
					} // action == edit human task
					elseif($action == "delete_task" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor")){
						if(isset($_GET['automated_task_id'])) {
							$automated_task_id = $_GET['automated_task_id'];
							$automated_task_id = strip_tags(stripslashes($automated_task_id));
						}
						else{
							$automated_task_id = "";
						}
						$automated_task_id_mysql = quote_smart($link, $automated_task_id);

						// Find automated task
						$query = "SELECT automated_task_id, automated_task_case_id, automated_task_evidence_record_id, automated_task_evidence_item_id, automated_task_evidence_full_title, automated_task_task_available_id, automated_task_task_available_name, automated_task_task_machine_type_id, automated_task_task_machine_type_title, automated_task_mirror_file_id, automated_task_mirror_file_path_windows, automated_task_mirror_file_path_linux, automated_task_mirror_file_file, automated_task_added_datetime, automated_task_added_date, automated_task_added_time, automated_task_added_date_saying, automated_task_added_date_ddmmyy, automated_task_added_date_ddmmyyyy, automated_task_started_datetime, automated_task_started_date, automated_task_started_time, automated_task_started_date_saying, automated_task_started_date_ddmmyyhi, automated_task_started_date_ddmmyyyyhi, automated_task_machine_id, automated_task_machine_name, automated_task_is_finished, automated_task_finished_datetime, automated_task_finished_date, automated_task_finished_time, automated_task_finished_date_saying, automated_task_finished_date_ddmmyyhi, automated_task_finished_date_ddmmyyyyhi, automated_task_time_taken_time, automated_task_time_taken_human FROM $t_edb_case_index_automated_tasks WHERE automated_task_id=$automated_task_id_mysql AND automated_task_case_id=$get_current_case_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_current_automated_task_id, $get_current_automated_task_case_id, $get_current_automated_task_evidence_record_id, $get_current_automated_task_evidence_item_id, $get_current_automated_task_evidence_full_title, $get_current_automated_task_task_available_id, $get_current_automated_task_task_available_name, $get_current_automated_task_task_machine_type_id, $get_current_automated_task_task_machine_type_title, $get_current_automated_task_mirror_file_id, $get_current_automated_task_mirror_file_path_windows, $get_current_automated_task_mirror_file_path_linux, $get_current_automated_task_mirror_file_file, $get_current_automated_task_added_datetime, $get_current_automated_task_added_date, $get_current_automated_task_added_time, $get_current_automated_task_added_date_saying, $get_current_automated_task_added_date_ddmmyy, $get_current_automated_task_added_date_ddmmyyyy, $get_current_automated_task_started_datetime, $get_current_automated_task_started_date, $get_current_automated_task_started_time, $get_current_automated_task_started_date_saying, $get_current_automated_task_started_date_ddmmyyhi, $get_current_automated_task_started_date_ddmmyyyyhi, $get_current_automated_task_machine_id, $get_current_automated_task_machine_name, $get_current_automated_task_is_finished, $get_current_automated_task_finished_datetime, $get_current_automated_task_finished_date, $get_current_automated_task_finished_time, $get_current_automated_task_finished_date_saying, $get_current_automated_task_finished_date_ddmmyyhi, $get_current_automated_task_finished_date_ddmmyyyyhi, $get_current_automated_task_time_taken_time, $get_current_automated_task_time_taken_human) = $row;
		
						if($get_current_automated_task_id == ""){
							echo"
							<h2>Automated task not found</h2>
							<p><a href=\"open_case_automated_tasks.php?case_id=$get_current_case_id&amp;l=$l\">Automated tasks</a></p>
							";
						}
						else{

							if($process == "1"){
				
								// Delete
								$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_automated_tasks WHERE automated_task_id=$get_current_automated_task_id") or die(mysqli_error($link));



								$url = "open_case_automated_tasks.php?case_id=$get_current_case_id&l=$l&ft=success&fm=automated_task_deleted";
								header("Location: $url");
								exit;

							}
					echo"
					<h2>$l_delete_automated_task</h2>

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

		
					<!-- Delete automated task form -->
						<p>
						$l_are_you_sure
						</p>

						<div class=\"bodycell\">
							<table>
							 <tr>
							  <td style=\"padding-right: 5px;\">
								<span>$l_id:</span>
							  </td>
							  <td>
								<span>$get_current_automated_task_id</span>
							  </td>
							 </tr>
							</table>
						</div>
	
						<p>
						<a href=\"open_case_automated_tasks.php?case_id=$get_current_case_id&amp;action=$action&amp;automated_task_id=$get_current_automated_task_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">$l_confirm</a>
						<a href=\"open_case_automated_tasks.php?case_id=$get_current_case_id&amp;l=$l\" class=\"btn_default\">$l_cancel</a>
						</p>
					<!-- //Delete automated form -->
					";
				} // automated_task found
			} // action == delete automated_task
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