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
				<h2>$l_events</h2>

				<!-- Events actions -->";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"
						<p>
						<a href=\"open_case_events.php?case_id=$get_current_case_id&amp;action=new_event&amp;l=$l\" class=\"btn_default\">$l_new_event</a>
						</p>
						<div style=\"height: 10px;\"></div>
						";
					}
				echo"
				<!-- //Events actions -->


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

		<!-- List of all events -->
			<table class=\"hor-zebra\">
			 <thead>
			  <tr>
			   <th scope=\"col\">
				<span>$l_date</span>
			   </th>
			   <th scope=\"col\">
				<span>$l_event</span>
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
			$counter=0;
			$query = "SELECT event_id, event_case_id, event_importance, event_text, event_datetime, event_time, event_date_saying, event_date_ddmmyy, event_user_id, event_user_name, event_user_alias, event_user_email, event_user_image_path, event_user_image_file, event_user_image_thumb_40, event_user_image_thumb_50, event_user_first_name, event_user_middle_name, event_user_last_name FROM $t_edb_case_index_events WHERE event_case_id=$get_current_case_id ORDER BY event_id ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_event_id, $get_event_case_id, $get_event_importance, $get_event_text, $get_event_datetime, $get_event_time, $get_event_date_saying, $get_event_date_ddmmyy, $get_event_user_id, $get_event_user_name, $get_event_user_alias, $get_event_user_email, $get_event_user_image_path, $get_event_user_image_file, $get_event_user_image_thumb_40, $get_event_user_image_thumb_50, $get_event_user_first_name, $get_event_user_middle_name, $get_event_user_last_name) = $row;

				if(isset($style) && $style == ""){
					$style = "odd";
				}
				else{
					$style = "";
				}
				if($get_event_importance == "important"){
					$style = "important";
				}
				elseif($get_event_importance == "danger"){
					$style = "danger";
				}

				echo"
				<tr>
				  <td class=\"$style\">
					<span>$get_event_date_ddmmyy</span>
				  </td>
				  <td class=\"$style\">
					<span>$get_event_text</span>
				  </td>
				  <td class=\"$style\">
					<a href=\"$root/users/view_profile.php?user_id=$get_event_user_id&amp;l=$l\" title=\"$get_event_user_first_name $get_event_user_middle_name $get_event_user_last_name\">$get_event_user_name</a>
				  </td>
				  <td class=\"$style\">";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"
						<span>
						<a href=\"open_case_events.php?case_id=$get_current_case_id&amp;action=edit_event&amp;event_id=$get_event_id&amp;l=$l\">$l_edit</a>
						&middot;
						<a href=\"open_case_events.php?case_id=$get_current_case_id&amp;action=delete_event&amp;event_id=$get_event_id&amp;l=$l\">$l_delete</a>
						</span>
						";
					}
					echo"
				 </td>
				</tr>
				";
				$counter = $counter + 1;
			} // while events
			if($counter != "$get_current_menu_counter_events"){
				$result = mysqli_query($link, "UPDATE $t_edb_case_index_open_case_menu_counters SET menu_counter_events=$counter WHERE menu_counter_case_id=$get_current_case_id");
			}
			echo"
			 </tbody>
			</table>

		<!-- List of all events -->
		";
	} // $action == ""
	elseif($action == "new_event" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor")){
		if($process == "1"){
			$inp_text = $_POST['inp_text'];
			$inp_text = output_html($inp_text);
			$inp_text_mysql = quote_smart($link, $inp_text);

			$inp_importance = $_POST['inp_importance'];
			$inp_importance = output_html($inp_importance);
			$inp_importance_mysql = quote_smart($link, $inp_importance);
				
			// Dates
			$inp_datetime = date("Y-m-d H:i:s");
			$inp_time = time();
			$inp_date_saying = date("j M Y");
			$inp_date_ddmmyy = date("d.m.y");
			
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

			// Insert
			mysqli_query($link, "INSERT INTO $t_edb_case_index_events
			(event_id, event_case_id, event_importance, event_text, event_datetime, event_time, event_date_saying, event_date_ddmmyy, event_user_id, event_user_name, event_user_alias, event_user_email, event_user_image_path, event_user_image_file, event_user_image_thumb_40, event_user_image_thumb_50, event_user_first_name, event_user_middle_name, event_user_last_name) 
			VALUES 
			(NULL, $get_current_case_id, $inp_importance_mysql, $inp_text_mysql, '$inp_datetime', '$inp_time', '$inp_date_saying', '$inp_date_ddmmyy', '$get_my_user_id', $inp_my_user_name_mysql, $inp_my_user_alias_mysql, $inp_my_user_email_mysql, $inp_my_user_image_path_mysql, $inp_my_user_image_file_mysql, $inp_my_user_image_thumb_a_mysql, $inp_my_user_image_thumb_b_mysql, $inp_my_user_first_name_mysql, $inp_my_user_middle_name_mysql, $inp_my_user_last_name_mysql)")
			or die(mysqli_error($link));

			// Get ID
			$query = "SELECT event_id FROM $t_edb_case_index_events WHERE event_datetime='$inp_datetime' AND event_user_id=$get_my_user_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_event_id) = $row;

			// Update counter
			$counter = $get_current_menu_counter_events+1;
			$result = mysqli_query($link, "UPDATE $t_edb_case_index_open_case_menu_counters SET menu_counter_events=$counter WHERE menu_counter_case_id=$get_current_case_id");

			// Update case
			$result = mysqli_query($link, "UPDATE $t_edb_case_index SET case_last_event_text=$inp_text_mysql WHERE case_id=$get_current_case_id");
			
			// Header
			if(isset($_GET['referer'])) {
				$referer = $_GET['referer'];
				$referer = strip_tags(stripslashes($referer));
				$url = "$referer.php?case_id=$get_current_case_id&page=events&l=$l&ft=success&fm=event_saved#events";
			}
			else{
				$url = "open_case_events.php?case_id=$get_current_case_id&page=events&l=$l&ft=success&fm=event_saved";
			}
			header("Location: $url");
			exit;
		}
		echo"
		<h2>$l_new_event</h2>

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
		
		<!-- New event form -->
			<form method=\"POST\" action=\"open_case_events.php?case_id=$get_current_case_id&amp;action=new_event&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p><b>$l_text:</b><br />
			<input type=\"text\" name=\"inp_text\" value=\"\" size=\"25\" style=\"width: 100%;\" />
			</p>


			<p><b>$l_importance:</b><br />
			<select name=\"inp_importance\">
				<option value=\"normal\">$l_normal</option>
				<option value=\"important\">$l_important</option>
				<option value=\"danger\">$l_danger</option>
			</select>
			</p>

			<p>
			<input type=\"submit\" value=\"$l_save\" class=\"btn_default\" />
			</p>
		<!-- //New event form -->
		";
	} // action == new event
	elseif($action == "edit_event" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor")){
		if(isset($_GET['event_id'])) {
			$event_id = $_GET['event_id'];
			$event_id = strip_tags(stripslashes($event_id));
		}
		else{
			$event_id = "";
		}
		$event_id_mysql = quote_smart($link, $event_id);

		// Find event
		$query = "SELECT event_id, event_case_id, event_importance, event_text, event_datetime, event_time, event_date_saying, event_date_ddmmyy, event_user_id, event_user_name, event_user_alias, event_user_email, event_user_image_path, event_user_image_file, event_user_image_thumb_40, event_user_image_thumb_50, event_user_first_name, event_user_middle_name, event_user_last_name FROM $t_edb_case_index_events WHERE event_id=$event_id_mysql AND event_case_id=$get_current_case_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_event_id, $get_current_event_case_id, $get_current_event_importance, $get_current_event_text, $get_current_event_datetime, $get_current_event_time, $get_current_event_date_saying, $get_current_event_date_ddmmyy, $get_current_event_user_id, $get_current_event_user_name, $get_current_event_user_alias, $get_current_event_user_email, $get_current_event_user_image_path, $get_current_event_user_image_file, $get_current_event_user_image_thumb_40, $get_current_event_user_image_thumb_50, $get_current_event_user_first_name, $get_current_event_user_middle_name, $get_current_event_user_last_name) = $row;
		
		if($get_current_event_id == ""){
			echo"
			<h2>Event not found</h2>
			<p><a href=\"open_case_events.php?case_id=$get_current_case_id&amp;action=new_event&amp;l=$l\">Events</a></p>
			";
		}
		else{

			if($process == "1"){
				$inp_text = $_POST['inp_text'];
				$inp_text = output_html($inp_text);
				$inp_text_mysql = quote_smart($link, $inp_text);

				$inp_importance = $_POST['inp_importance'];
				$inp_importance = output_html($inp_importance);
				$inp_importance_mysql = quote_smart($link, $inp_importance);
				
				// Update
				$result = mysqli_query($link, "UPDATE $t_edb_case_index_events SET 
								event_importance=$inp_importance_mysql, 
								event_text=$inp_text_mysql 
								 WHERE event_id=$get_current_event_id") or die(mysqli_error($link));



				$url = "open_case_events.php?case_id=$get_current_case_id&page=events&l=$l&ft=success&fm=changes_saved";
				header("Location: $url");
				exit;

			}
			echo"
			<h2>$l_edit_event</h2>

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
		
			<!-- Edit event form -->
				<form method=\"POST\" action=\"open_case_events.php?case_id=$get_current_case_id&amp;action=edit_event&amp;event_id=$get_current_event_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

				<p><b>$l_text:</b><br />
				<input type=\"text\" name=\"inp_text\" value=\"$get_current_event_text\" size=\"25\" style=\"width: 100%;\" />
				</p>


				<p><b>$l_importance:</b><br />
				<select name=\"inp_importance\">
					<option value=\"normal\""; if($get_current_event_importance == "normal"){ echo" selected=\"selected\"";} echo">$l_normal</option>
					<option value=\"important\""; if($get_current_event_importance == "important"){ echo" selected=\"selected\"";} echo">$l_important</option>
					<option value=\"danger\""; if($get_current_event_importance == "danger"){ echo" selected=\"selected\"";} echo">$l_danger</option>
				</select>
				</p>

				<p>
				<input type=\"submit\" value=\"$l_save\" class=\"btn_default\" />
				</p>
			<!-- //Edit event form -->
			";
		} // event found
	} // action == edit event
	elseif($action == "delete_event" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor")){
		if(isset($_GET['event_id'])) {
			$event_id = $_GET['event_id'];
			$event_id = strip_tags(stripslashes($event_id));
		}
		else{
			$event_id = "";
		}
		$event_id_mysql = quote_smart($link, $event_id);

		// Find event
		$query = "SELECT event_id, event_case_id, event_importance, event_text, event_datetime, event_time, event_date_saying, event_date_ddmmyy, event_user_id, event_user_name, event_user_alias, event_user_email, event_user_image_path, event_user_image_file, event_user_image_thumb_40, event_user_image_thumb_50, event_user_first_name, event_user_middle_name, event_user_last_name FROM $t_edb_case_index_events WHERE event_id=$event_id_mysql AND event_case_id=$get_current_case_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_event_id, $get_current_event_case_id, $get_current_event_importance, $get_current_event_text, $get_current_event_datetime, $get_current_event_time, $get_current_event_date_saying, $get_current_event_date_ddmmyy, $get_current_event_user_id, $get_current_event_user_name, $get_current_event_user_alias, $get_current_event_user_email, $get_current_event_user_image_path, $get_current_event_user_image_file, $get_current_event_user_image_thumb_40, $get_current_event_user_image_thumb_50, $get_current_event_user_first_name, $get_current_event_user_middle_name, $get_current_event_user_last_name) = $row;
		
		if($get_current_event_id == ""){
			echo"
			<h2>Event not found</h2>
			<p><a href=\"open_case_events.php?case_id=$get_current_case_id&amp;action=new_event&amp;l=$l\">Events</a></p>
			";
		}
		else{

			if($process == "1"){
				
				// Delete
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_events WHERE event_id=$get_current_event_id") or die(mysqli_error($link));



				$url = "open_case_events.php?case_id=$get_current_case_id&page=events&l=$l&ft=success&fm=event_deleted";
				header("Location: $url");
				exit;

			}
			echo"
			<h2>$l_delete_event</h2>

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

		
			<!-- Delete event form -->
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
						<span>$get_current_event_id</span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding-right: 5px;\">
						<span>$l_date:</span>
					  </td>
					  <td>
						<span>$get_current_event_date_ddmmyy</span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding-right: 5px;\">
						<span>$l_text:</span>
					  </td>
					  <td>
						<span>$get_current_event_text</span>
					  </td>
					 </tr>
					</table>
				</div>

				<p>
				<a href=\"open_case_events.php?case_id=$get_current_case_id&amp;action=delete_event&amp;event_id=$get_current_event_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">$l_confirm</a>
				<a href=\"open_case_events.php?case_id=$get_current_case_id&amp;l=$l\" class=\"btn_default\">$l_cancel</a>
				</p>
			<!-- //Delete event form -->
			";
		} // event found
	} // action == delete event

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