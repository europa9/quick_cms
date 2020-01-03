<?php 
/**
*
* File: edb/automated_tasks_overview.php
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
include("$root/_admin/_translations/site/$l/edb/ts_edit_district_members.php");


/*- Variables -------------------------------------------------------------------------- */
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

if(isset($_GET['member_id'])) {
	$member_id = $_GET['member_id'];
	$member_id = strip_tags(stripslashes($member_id));
}
else{
	$member_id = "";
}
$member_id_mysql = quote_smart($link, $member_id);



/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){

	// Me
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);

	// Find district
	if($district_id != ""){
		$query = "SELECT district_id, district_number, district_title, district_title_clean, district_icon_path, district_icon_16, district_icon_32, district_icon_260, district_number_of_stations, district_number_of_cases_now FROM $t_edb_districts_index WHERE district_id=$district_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_district_id, $get_current_district_number, $get_current_district_title, $get_current_district_title_clean, $get_current_district_icon_path, $get_current_district_icon_16, $get_current_district_icon_32, $get_current_district_icon_260, $get_current_district_number_of_stations, $get_current_district_number_of_cases_now) = $row;
	
		if($get_current_district_id == ""){
			echo"<h1>Server error 404</h1><p>District not found</p>";
			die;
		}

		// Check that I am member of this district
		$query = "SELECT district_member_id, district_member_district_id, district_member_district_title, district_member_user_id, district_member_rank, district_member_user_name, district_member_user_alias, district_member_user_first_name, district_member_user_middle_name, district_member_user_last_name, district_member_user_email, district_member_user_image_path, district_member_user_image_file, district_member_user_image_thumb_40, district_member_user_image_thumb_50, district_member_user_image_thumb_60, district_member_user_image_thumb_200, district_member_user_position, district_member_user_department, district_member_user_location, district_member_user_about, district_member_added_datetime, district_member_added_date_saying, district_member_added_by_user_id, district_member_added_by_user_name, district_member_added_by_user_alias, district_member_added_by_user_image FROM $t_edb_districts_members WHERE district_member_district_id=$get_current_district_id AND district_member_user_id=$my_user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_my_district_member_id, $get_my_district_member_district_id, $get_my_district_member_district_title, $get_my_district_member_user_id, $get_my_district_member_rank, $get_my_district_member_user_name, $get_my_district_member_user_alias, $get_my_district_member_user_first_name, $get_my_district_member_user_middle_name, $get_my_district_member_user_last_name, $get_my_district_member_user_email, $get_my_district_member_user_image_path, $get_my_district_member_user_image_file, $get_my_district_member_user_image_thumb_40, $get_my_district_member_user_image_thumb_50, $get_my_district_member_user_image_thumb_60, $get_my_district_member_user_image_thumb_200, $get_my_district_member_user_position, $get_my_district_member_user_department, $get_my_district_member_user_location, $get_my_district_member_user_about, $get_my_district_member_added_datetime, $get_my_district_member_added_date_saying, $get_my_district_member_added_by_user_id, $get_my_district_member_added_by_user_name, $get_my_district_member_added_by_user_alias, $get_my_district_member_added_by_user_image) = $row;

		if($get_my_district_member_id == ""){
			echo"
			<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> Please apply for access to this district..</h1>
			<meta http-equiv=\"refresh\" content=\"3;url=browse_districts_and_stations.php?action=apply_for_membership_to_district&amp;district_id=$get_current_district_id&amp;l=$l\">
			";
		} // access to district denied

	}

	// Find station
	if($station_id != ""){
		$query = "SELECT station_id, station_number, station_title, station_title_clean, station_district_id, station_district_title, station_icon_path, station_icon_16, station_icon_32, station_icon_260, station_number_of_cases_now FROM $t_edb_stations_index WHERE station_id=$station_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_station_id, $get_current_station_number, $get_current_station_title, $get_current_station_title_clean, $get_current_station_district_id, $get_current_station_district_title, $get_current_station_icon_path, $get_current_station_icon_16, $get_current_station_icon_32, $get_current_station_icon_260, $get_current_station_number_of_cases_now) = $row;
	
		if($get_current_station_id == ""){
			echo"<h1>Server error 404</h1><p>Station not found</p>";
			die;
		}

		// Check that I am member of this station
		$query = "SELECT station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60, station_member_user_image_thumb_200, station_member_user_position, station_member_user_department, station_member_user_location, station_member_user_about, station_member_added_datetime, station_member_added_date_saying, station_member_added_by_user_id, station_member_added_by_user_name, station_member_added_by_user_alias, station_member_added_by_user_image FROM $t_edb_stations_members WHERE station_member_user_id=$my_user_id_mysql AND station_member_station_id=$get_current_station_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_my_station_member_id, $get_my_station_member_station_id, $get_my_station_member_station_title, $get_my_station_member_district_id, $get_my_station_member_district_title, $get_my_station_member_user_id, $get_my_station_member_rank, $get_my_station_member_user_name, $get_my_station_member_user_alias, $get_my_station_member_first_name, $get_my_station_member_middle_name, $get_my_station_member_last_name, $get_my_station_member_user_email, $get_my_station_member_user_image_path, $get_my_station_member_user_image_file, $get_my_station_member_user_image_thumb_40, $get_my_station_member_user_image_thumb_50, $get_my_station_member_user_image_thumb_60, $get_my_station_member_user_image_thumb_200, $get_my_station_member_user_position, $get_my_station_member_user_department, $get_my_station_member_user_location, $get_my_station_member_user_about, $get_my_station_member_added_datetime, $get_my_station_member_added_date_saying, $get_my_station_member_added_by_user_id, $get_my_station_member_added_by_user_name, $get_my_station_member_added_by_user_alias, $get_my_station_member_added_by_user_image) = $row;

		if($get_my_station_member_id == ""){
			echo"
			<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> Please apply for access to this station..</h1>
			<meta http-equiv=\"refresh\" content=\"4;url=browse_districts_and_stations.php?action=apply_for_membership_to_station&amp;station_id=$get_current_station_id&amp;l=$l\">
			";
		} // access to station denied
	} // Station


	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "$l_edb - $l_automated_tasks_overview";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");



	if($action == ""){
		echo"
		<h1>$l_automated_tasks_overview</h1>

		<!-- Where am I ? -->
			<p><b>$l_you_are_here:</b><br />
			<a href=\"index.php?l=$l\">$l_edb</a>
			&gt;";
			if(isset($get_current_district_id)){
				echo"
				<a href=\"cases_board_1_view_district.php?district_id=$get_current_district_id&amp;l=$l\">$get_current_district_title</a>
				&gt;
				";
			}
			if(isset($get_current_station_id)){
				echo"
				<a href=\"cases_board_2_view_station.php?station_id=$get_current_station_id&amp;l=$l\">$get_current_station_title</a>
				&gt;
				";
			}
			echo"
			<a href=\"automated_tasks_overview.php?district_id=$district_id&amp;station_id=$station_id&amp;l=$l\">$l_automated_tasks_overview</a>
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

		<!-- Automated tasks -->
			<h2>$l_automated_tasks</h2>
			<table class=\"hor-zebra\">
			 <thead>
			  <tr>
			   <th scope=\"col\">
				<span>$l_id</span>
			   </th>
			   <th scope=\"col\">
				<span>$l_case</span>
			   </th>
			   <th scope=\"col\">
				<span>$l_evidence</span>
			   </th>
			   <th scope=\"col\">
				<span>$l_name</span>
			   </th>
			   <th scope=\"col\">
				<span>$l_status</span>
			   </th>
			   <th scope=\"col\">
				<span>$l_actions</span>
			   </th>
			  </tr>
			 </thead>
			 <tbody>
			";
	
			$query_tasks = "SELECT automated_task_id, automated_task_case_id, automated_task_evidence_record_id, automated_task_evidence_item_id, automated_task_evidence_full_title, automated_task_task_available_id, automated_task_task_available_name, automated_task_task_machine_type_id, automated_task_task_machine_type_title, automated_task_mirror_file_id, automated_task_mirror_file_path_windows, automated_task_mirror_file_path_linux, automated_task_mirror_file_file, automated_task_glossaries_ids, automated_task_priority, automated_task_dependent_on_automated_task_id, automated_task_dependent_on_automated_task_title, automated_task_added_datetime, automated_task_added_date, automated_task_added_time, automated_task_added_date_saying, automated_task_added_date_ddmmyy, automated_task_added_date_ddmmyyyy, automated_task_started_datetime, automated_task_started_date, automated_task_started_time, automated_task_started_date_saying, automated_task_started_date_ddmmyyhi, automated_task_started_date_ddmmyyyyhi, automated_task_machine_id, automated_task_machine_name, automated_task_is_finished, automated_task_finished_datetime, automated_task_finished_date, automated_task_finished_time, automated_task_finished_date_saying, automated_task_finished_date_ddmmyyhi, automated_task_finished_date_ddmmyyyyhi, automated_task_time_taken_time, automated_task_time_taken_human FROM $t_edb_case_index_automated_tasks";
			$query_tasks = $query_tasks . " ORDER BY automated_task_id DESC";
			$result_tasks = mysqli_query($link, $query_tasks);
			while($row_tasks = mysqli_fetch_row($result_tasks)) {
				list($get_automated_task_id, $get_automated_task_case_id, $get_automated_task_evidence_record_id, $get_automated_task_evidence_item_id, $get_automated_task_evidence_full_title, $get_automated_task_task_available_id, $get_automated_task_task_available_name, $get_automated_task_task_machine_type_id, $get_automated_task_task_machine_type_title, $get_automated_task_mirror_file_id, $get_automated_task_mirror_file_path_windows, $get_automated_task_mirror_file_path_linux, $get_automated_task_mirror_file_file, $get_automated_task_glossaries_ids, $get_automated_task_priority, $get_automated_task_dependent_on_automated_task_id, $get_automated_task_dependent_on_automated_task_title, $get_automated_task_added_datetime, $get_automated_task_added_date, $get_automated_task_added_time, $get_automated_task_added_date_saying, $get_automated_task_added_date_ddmmyy, $get_automated_task_added_date_ddmmyyyy, $get_automated_task_started_datetime, $get_automated_task_started_date, $get_automated_task_started_time, $get_automated_task_started_date_saying, $get_automated_task_started_date_ddmmyyhi, $get_automated_task_started_date_ddmmyyyyhi, $get_automated_task_machine_id, $get_automated_task_machine_name, $get_automated_task_is_finished, $get_automated_task_finished_datetime, $get_automated_task_finished_date, $get_automated_task_finished_time, $get_automated_task_finished_date_saying, $get_automated_task_finished_date_ddmmyyhi, $get_automated_task_finished_date_ddmmyyyyhi, $get_automated_task_time_taken_time, $get_automated_task_time_taken_human) = $row_tasks;


				// Case numer
				$query_c = "SELECT case_id, case_number FROM $t_edb_case_index WHERE case_id=$get_automated_task_case_id";
				$result_c = mysqli_query($link, $query_c);
				$row_c = mysqli_fetch_row($result_c);
				list($get_case_id, $get_case_number) = $row_c;



				if(isset($style) && $style = "odd"){
					$style = "";
				}
				else{
					$style = "odd";
				}
				echo"
				<tr>
				  <td class=\"$style\">
					<span>$get_automated_task_id</span>
				  </td>
				  <td class=\"$style\">
					<span><a href=\"open_case_overview.php?case_id=$get_automated_task_case_id&amp;l=$l\">$get_case_number</a></span>
				  </td>
				  <td class=\"$style\">
					<span><a href=\"open_case_evidence.php?case_id=$get_automated_task_case_id&amp;l=$l\">$get_automated_task_evidence_full_title</a>
				  </td>
				  <td class=\"$style\">
					<span>$get_automated_task_task_available_name</span>
				  </td>
				  <td class=\"$style\">
					<!-- Status -->
						<table>";
						// Mirror files ready?
						$mirror_files_found_and_ready = 0; // guess
						$mirror_files_counter = 0;
						$query = "SELECT mirror_file_id, mirror_file_case_id, mirror_file_record_id, mirror_file_item_id, mirror_file_path_windows, mirror_file_path_linux, mirror_file_file, mirror_file_ext, mirror_file_type, mirror_file_created_datetime, mirror_file_created_time, mirror_file_created_date_saying, mirror_file_created_date_ddmmyy, mirror_file_modified_datetime, mirror_file_modified_time, mirror_file_modified_date_saying, mirror_file_modified_date_ddmmyy, mirror_file_size_mb, mirror_file_size_human, mirror_file_backup_disk, mirror_file_exists, mirror_file_ready_for_automated_machine, mirror_file_comments FROM $t_edb_case_index_evidence_items_mirror_files WHERE mirror_file_case_id=$get_automated_task_case_id AND mirror_file_item_id=$get_automated_task_evidence_item_id";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_mirror_file_id, $get_mirror_file_case_id, $get_mirror_file_record_id, $get_mirror_file_item_id, $get_mirror_file_path_windows, $get_mirror_file_path_linux, $get_mirror_file_file, $get_mirror_file_ext, $get_mirror_file_type, $get_mirror_file_created_datetime, $get_mirror_file_created_time, $get_mirror_file_created_date_saying, $get_mirror_file_created_date_ddmmyy, $get_mirror_file_modified_datetime, $get_mirror_file_modified_time, $get_mirror_file_modified_date_saying, $get_mirror_file_modified_date_ddmmyy, $get_mirror_file_size_mb, $get_mirror_file_size_human, $get_mirror_file_backup_disk, $get_mirror_file_exists, $get_mirror_file_ready_for_automated_machine, $get_mirror_file_comments) = $row;
							echo"
									 <tr>
							";
							if($get_mirror_file_exists == "1"){
								if($get_mirror_file_ready_for_automated_machine == "1"){
									echo"
									  <td style=\"padding-right: 4px;\">
										<span>$get_mirror_file_file</span>
									  </td>
									  <td>
										<span>$l_ready_lowercase</span>
									  </td>";
								}
								else{
									echo"
									  <td style=\"padding-right: 4px;\">
										<span style=\"color: orange;\">$get_mirror_file_file $l_not_ready_lowercase &middot; $l_modified $get_mirror_file_modified_date_saying</span>
									  </td>
									  <td>
										<span style=\"color: orange;\">$l_not_ready_lowercase</span>
									  </td>";
								}
							}
							else{
									echo"
									  <td style=\"padding-right: 4px;\">
										<span style=\"color: red;\">$get_mirror_file_file</span>
									  </td>
									  <td>
										<span style=\"color: red;\">$l_doesnt_exist_lowercase</span>
									  </td>";
							}
							echo"
									 </tr>
							";
						} // Mirror files
						echo"
						</table>
					<!-- //Status -->
					
				  </td>
				  <td class=\"$style\">";
					echo"
							<span>
							<a href=\"open_case_automated_tasks.php?case_id=$get_case_id&amp;action=edit_task&amp;automated_task_id=$get_automated_task_id&amp;l=$l\">$l_edit</a>
							&middot;
							<a href=\"open_case_automated_tasks.php?case_id=$get_case_id&amp;action=delete_task&amp;automated_task_id=$get_automated_task_id&amp;l=$l\">$l_delete</a>
							</span>
							";
					echo"
				  </td>
				</tr>
				";
			}
		echo"
			   </th>
			  </tr>
			 </thead>
			</table>
			
		<!-- //Automated tasks -->

		";
	} // action == ""

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