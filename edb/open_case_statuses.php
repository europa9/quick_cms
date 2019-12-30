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
		<h2>$l_statuses</h2>
	


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

		<!-- List of all statuses -->
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
				  <td class=\"$style\">";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"<span>
						<a href=\"open_case_statuses.php?case_id=$get_current_case_id&amp;page=statuses&amp;action=edit_status&amp;status_id=$get_case_index_status_id&amp;l=$l\">$l_edit</a>
						&middot;
						<a href=\"open_case_statuses.php?case_id=$get_current_case_id&amp;page=statuses&amp;action=delete_status&amp;status_id=$get_case_index_status_id&amp;l=$l\">$l_delete</a>
						</span>";
					}
					echo"
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

		<!-- List of all statuses -->
		";
	} // $action == ""
	elseif($action == "edit_status" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor")){
		if(isset($_GET['status_id'])) {
			$status_id = $_GET['status_id'];
			$status_id = strip_tags(stripslashes($status_id));
		}
		else{
			$status_id = "";
		}
		$status_id_mysql = quote_smart($link, $status_id);

		// Find event
		$query = "SELECT case_index_status_id, case_index_status_case_id, case_index_status_status_id, case_index_status_status_title, case_index_status_datetime, case_index_status_time, case_index_status_date_saying, case_index_status_date_ddmmyy, case_index_status_text, case_index_status_user_id, case_index_status_user_name, case_index_status_user_alias, case_index_status_user_email, case_index_status_user_image_path, case_index_status_user_image_file, case_index_status_user_image_thumb_40, case_index_status_user_image_thumb_50, case_index_status_user_first_name, case_index_status_user_middle_name, case_index_status_user_last_name FROM $t_edb_case_index_statuses WHERE case_index_status_id=$status_id_mysql AND case_index_status_case_id=$get_current_case_id ORDER BY case_index_status_id ASC";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_case_index_status_id, $get_current_case_index_status_case_id, $get_current_case_index_status_status_id, $get_current_case_index_status_status_title, $get_current_case_index_status_datetime, $get_current_case_index_status_time, $get_current_case_index_status_date_saying, $get_current_case_index_status_date_ddmmyy, $get_current_case_index_status_text, $get_current_case_index_status_user_id, $get_current_case_index_status_user_name, $get_current_case_index_status_user_alias, $get_current_case_index_status_user_email, $get_current_case_index_status_user_image_path, $get_current_case_index_status_user_image_file, $get_current_case_index_status_user_image_thumb_40, $get_current_case_index_status_user_image_thumb_50, $get_current_case_index_status_user_first_name, $get_current_case_index_status_user_middle_name, $get_current_case_index_status_user_last_name) = $row;
		
		if($get_current_case_index_status_id == ""){
			echo"
			<h2>Status not found</h2>
			<p><a href=\"open_case_statuses.php?case_id=$get_current_case_id&amp;page=statuses&amp;l=$l\">Statuses</a></p>
			";
		}
		else{

			if($process == "1"){
				$inp_status_id = $_POST['inp_status_id'];
				$inp_status_id = output_html($inp_status_id);
				$inp_status_id_mysql = quote_smart($link, $inp_status_id);

				$inp_text = $_POST['inp_text'];
				$inp_text = output_html($inp_text);
				$inp_text_mysql = quote_smart($link, $inp_text);

				// Find status
				$query = "SELECT status_id, status_title, status_title_clean, status_bg_color, status_border_color, status_text_color, status_link_color, status_weight, status_number_of_cases_now, status_number_of_cases_max, status_show_on_front_page, status_on_given_status_do_close_case FROM $t_edb_case_statuses WHERE status_id=$inp_status_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_new_status_id, $get_new_status_title, $get_new_status_title_clean, $get_new_status_bg_color, $get_new_status_border_color, $get_new_status_text_color, $get_new_status_link_color, $get_new_status_weight, $get_new_status_number_of_cases_now, $get_new_status_number_of_cases_max, $get_new_status_show_on_front_page, $get_new_status_on_given_status_do_close_case) = $row;
				if($get_new_status_id == ""){
					$url = "open_case_statuses.php?case_id=$get_current_case_id&page=statuses&action=edit_status&status_id=$get_current_case_index_status_id&l=$l&ft=error&fm=status_not_found";
					header("Location: $url");
					die;
				}
				else{
					// Update status
					$inp_status_title_mysql = quote_smart($link, $get_new_status_title);
					$result = mysqli_query($link, "UPDATE $t_edb_case_index_statuses SET 
							case_index_status_status_id=$get_new_status_id, 
							case_index_status_status_title=$inp_status_title_mysql, 
							case_index_status_text=$inp_text_mysql WHERE case_index_status_id=$get_current_case_index_status_id") or die(mysqli_error($link));

					// If this is the last (current status), then we need to update the case status also
					$last_status_id = "";
					$query = "SELECT case_index_status_id, case_index_status_case_id, case_index_status_status_id, case_index_status_status_title, case_index_status_datetime, case_index_status_time, case_index_status_date_saying, case_index_status_date_ddmmyy, case_index_status_text, case_index_status_user_id, case_index_status_user_name, case_index_status_user_alias, case_index_status_user_email, case_index_status_user_image_path, case_index_status_user_image_file, case_index_status_user_image_thumb_40, case_index_status_user_image_thumb_50, case_index_status_user_first_name, case_index_status_user_middle_name, case_index_status_user_last_name FROM $t_edb_case_index_statuses WHERE case_index_status_case_id=$get_current_case_id ORDER BY case_index_status_id ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_case_index_status_id, $get_case_index_status_case_id, $get_case_index_status_status_id, $get_case_index_status_status_title, $get_case_index_status_datetime, $get_case_index_status_time, $get_case_index_status_date_saying, $get_case_index_status_date_ddmmyy, $get_case_index_status_text, $get_case_index_status_user_id, $get_case_index_status_user_name, $get_case_index_status_user_alias, $get_case_index_status_user_email, $get_case_index_status_user_image_path, $get_case_index_status_image_file, $get_case_index_status_user_image_thumb_40, $get_case_index_status_user_image_thumb_50, $get_case_index_status_user_first_name, $get_case_index_status_user_middle_name, $get_case_index_status_user_last_name) = $row;

						$last_status_id = "$get_case_index_status_id";

					}
					if($last_status_id == "$get_current_case_index_status_id"){
						// Also update case
						$result = mysqli_query($link, "UPDATE $t_edb_case_index SET case_status_id=$get_new_status_id, case_status_title=$inp_status_title_mysql WHERE case_id=$get_current_case_id") or die(mysqli_error($link));

					}


					$url = "open_case_statuses.php?case_id=$get_current_case_id&page=statuses&l=$l&ft=success&fm=changes_saved";
					header("Location: $url");
					exit;
				}
			}
			echo"
			<h2>$l_edit_status</h2>

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
				\$('[name=\"inp_text\"]').focus();
			});
			</script>
			<!-- //Focus -->
		
			<!-- Edit status form -->
				<form method=\"POST\" action=\"open_case_statuses.php?case_id=$get_current_case_id&amp;page=statuses&amp;action=edit_status&amp;status_id=$get_current_case_index_status_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

				<p><b>$l_status:</b><br />
				<select name=\"inp_status_id\">
				";
				$query = "SELECT status_id, status_title, status_title_clean, status_bg_color, status_border_color, status_text_color, status_link_color, status_weight, status_number_of_cases_now, status_number_of_cases_max, status_show_on_front_page, status_on_given_status_do_close_case FROM $t_edb_case_statuses ORDER BY status_weight ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_status_id, $get_status_title, $get_status_title_clean, $get_status_bg_color, $get_status_border_color, $get_status_text_color, $get_status_link_color, $get_status_weight, $get_status_number_of_cases_now, $get_status_number_of_cases_max, $get_status_show_on_front_page, $get_status_on_given_status_do_close_case) = $row;
					echo"			";
					echo"<option value=\"$get_status_id\""; if($get_status_id == "$get_current_case_index_status_status_id"){ echo" selected=\"selected\""; } echo">$get_status_title</option>\n";
				}
				echo"
				</select>
				</p>
				<p><b>$l_text:</b><br />
				<input type=\"text\" name=\"inp_text\" value=\"$get_current_case_index_status_text\" size=\"25\" style=\"width: 98%;\" />
				</p>


				<p>
				<input type=\"submit\" value=\"$l_save\" class=\"btn_default\" />
				</p>
			<!-- //Edit status form -->
			";
		} // status found
	} // action == edit status
	elseif($action == "delete_status" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor")){
		if(isset($_GET['status_id'])) {
			$status_id = $_GET['status_id'];
			$status_id = strip_tags(stripslashes($status_id));
		}
		else{
			$status_id = "";
		}
		$status_id_mysql = quote_smart($link, $status_id);

		// Find event
		$query = "SELECT case_index_status_id, case_index_status_case_id, case_index_status_status_id, case_index_status_status_title, case_index_status_datetime, case_index_status_time, case_index_status_date_saying, case_index_status_date_ddmmyy, case_index_status_text, case_index_status_user_id, case_index_status_user_name, case_index_status_user_alias, case_index_status_user_email, case_index_status_user_image_path, case_index_status_user_image_file, case_index_status_user_image_thumb_40, case_index_status_user_image_thumb_50, case_index_status_user_first_name, case_index_status_user_middle_name, case_index_status_user_last_name FROM $t_edb_case_index_statuses WHERE case_index_status_id=$status_id_mysql AND case_index_status_case_id=$get_current_case_id ORDER BY case_index_status_id ASC";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_case_index_status_id, $get_current_case_index_status_case_id, $get_current_case_index_status_status_id, $get_current_case_index_status_status_title, $get_current_case_index_status_datetime, $get_current_case_index_status_time, $get_current_case_index_status_date_saying, $get_current_case_index_status_date_ddmmyy, $get_current_case_index_status_text, $get_current_case_index_status_user_id, $get_current_case_index_status_user_name, $get_current_case_index_status_user_alias, $get_current_case_index_status_user_email, $get_current_case_index_status_user_image_path, $get_current_case_index_status_user_image_file, $get_current_case_index_status_user_image_thumb_40, $get_current_case_index_status_user_image_thumb_50, $get_current_case_index_status_user_first_name, $get_current_case_index_status_user_middle_name, $get_current_case_index_status_user_last_name) = $row;
		
		if($get_current_case_index_status_id == ""){
			echo"
			<h2>Status not found</h2>
			<p><a href=\"open_case_statuses.php?case_id=$get_current_case_id&amp;page=statuses&amp;l=$l\">Statuses</a></p>
			";
		}
		else{

			if($process == "1"){
				
				// Delete
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_statuses WHERE case_index_status_id=$get_current_case_index_status_id") or die(mysqli_error($link));



				$url = "open_case_statuses.php?case_id=$get_current_case_id&page=statuses&l=$l&ft=success&fm=status_deleted";
				header("Location: $url");
				exit;

			}
			echo"
			<h2>$l_delete_status</h2>

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

		
			<!-- Delete status form -->
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
						<span>$get_current_case_index_status_id</span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding-right: 5px;\">
						<span>$l_date:</span>
					  </td>
					  <td>
						<span>$get_current_case_index_status_date_ddmmyy</span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding-right: 5px;\">
						<span>$l_title:</span>
					  </td>
					  <td>
						<span>$get_current_case_index_status_status_title</span>
					  </td>
					 </tr>
					</table>
				</div>

				<p>
				<a href=\"open_case_statuses.php?case_id=$get_current_case_id&amp;page=statuses&amp;action=delete_status&amp;status_id=$get_current_case_index_status_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">$l_confirm</a>
				<a href=\"open_case_statuses.php?case_id=$get_current_case_id&amp;page=statuses&amp;l=$l\" class=\"btn_default\">$l_cancel</a>
				</p>
			<!-- //Delete status form -->
			";
		} // status found
	} // action == delete status

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