<?php 
/**
*
* File: edb/edit_station_members.php
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


	// Find station
	$query = "SELECT station_id, station_number, station_title, station_title_clean, station_district_id, station_district_title, station_icon_path, station_icon_16, station_icon_32, station_icon_260, station_number_of_cases_now FROM $t_edb_stations_index WHERE station_id=$station_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_station_id, $get_current_station_number, $get_current_station_title, $get_current_station_title_clean, $get_current_station_district_id, $get_current_station_district_title, $get_current_station_icon_path, $get_current_station_icon_16, $get_current_station_icon_32, $get_current_station_icon_260, $get_current_station_number_of_cases_now) = $row;
	
	if($get_current_station_id == ""){
		echo"<h1>Server error 404</h1><p>Station not found</p>";
		die;
	}
	else{

		// Find district
		$query = "SELECT district_id, district_number, district_title, district_title_clean, district_icon_path, district_icon_16, district_icon_32, district_icon_260, district_number_of_stations, district_number_of_cases_now FROM $t_edb_districts_index WHERE district_id=$get_current_station_district_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_district_id, $get_current_district_number, $get_current_district_title, $get_current_district_title_clean, $get_current_district_icon_path, $get_current_district_icon_16, $get_current_district_icon_32, $get_current_district_icon_260, $get_current_district_number_of_stations, $get_current_district_number_of_cases_now) = $row;
	
		if($get_current_district_id == ""){
			echo"<h1>Server error 404</h1><p>District not found</p>";
			die;
		}
		else{
			/*- Headers ---------------------------------------------------------------------------------- */
			$website_title = "$l_edb - $get_current_district_title - $get_current_station_title";
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
			else{
				if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator"){
					if($action == ""){
						echo"
						<h1>$get_current_station_title $l_members_lowercase</h1>

						<!-- Where am I ? -->
							<p><b>$l_you_are_here:</b><br />
							<a href=\"index.php?l=$l\">$l_edb</a>
							&gt;
							<a href=\"cases_board_1_view_district.php?district_id=$get_current_district_id&amp;l=$l\">$get_current_district_title</a>
							&gt;
							<a href=\"cases_board_2_view_station.php?station_id=$get_current_station_id&amp;l=$l\">$get_current_station_title</a>
							&gt;
							<a href=\"edit_station_members.php?station_id=$get_current_station_id&amp;l=$l\">$l_members</a>
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


						<!-- Memberlist -->

							<table class=\"hor-zebra\">
							 <thead>
							  <tr>
							   <th scope=\"col\">
								<span>$l_name</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_username</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_rank</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_show_on_board</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_can_be_jour</span>
							   </th>
							   <th scope=\"col\">
								<span>$l_actions</span>
							   </th>
							  </tr>
							 </thead>
							 <tbody>
							";
	
							$query = "SELECT request_id, request_station_id, request_station_title, request_district_id, request_district_title, request_user_id, request_rank, request_user_name, request_user_alias, request_user_first_name, request_user_middle_name, request_user_last_name, request_user_email, request_user_image_path, request_user_image_file, request_user_image_thumb_40, request_user_image_thumb_50, request_user_image_thumb_60, request_user_image_thumb_200, request_user_position, request_user_department, request_user_location, request_user_about, request_datetime, request_date_saying FROM $t_edb_stations_membership_requests WHERE request_station_id=$get_current_station_id";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_request_id, $get_request_station_id, $get_request_station_title, $get_request_district_id, $get_request_district_title, $get_request_user_id, $get_request_rank, $get_request_user_name, $get_request_user_alias, $get_request_user_first_name, $get_request_user_middle_name, $get_request_user_last_name, $get_request_user_email, $get_request_user_image_path, $get_request_user_image_file, $get_request_user_image_thumb_40, $get_request_user_image_thumb_50, $get_request_user_image_thumb_60, $get_request_user_image_thumb_200, $get_request_user_position, $get_request_user_department, $get_request_user_location, $get_request_user_about, $get_request_datetime, $get_request_date_saying) = $row;


								echo"
								<tr>
								  <td class=\"important\">
									<span>$get_request_user_first_name $get_request_user_middle_name $get_request_user_last_name</span>
								  </td>
								  <td class=\"important\">
									<a href=\"edit_station_members.php?action=view_request&amp;station_id=$get_current_station_id&amp;request_id=$get_request_id&amp;l=$l\">$get_request_user_name</a>";
									if($get_request_user_name != "$get_request_user_alias"){
										echo"(<a href=\"edit_station_members.php?action=view_request&amp;station_id=$get_current_station_id&amp;request_id=$get_request_id&amp;l=$l\">$get_request_user_alias</a>)";
									}
									echo"
								  </td>
								  <td class=\"important\">
									<span>";
									if($get_request_rank == "admin"){
										echo"$l_admin";
									}
									elseif($get_request_rank  == "moderator"){
										echo"$l_moderator";
									}
									elseif($get_request_rank  == "editor"){
										echo"$l_editor";
									}
									elseif($get_request_rank  == "member"){
										echo"$l_member";
									}
									echo"</span>
								  </td>
								  <td class=\"important\">
								  </td>
								  <td class=\"important\">
								  </td>
								  <td class=\"important\">
									<span>
									<a href=\"edit_station_members.php?action=view_request&amp;station_id=$get_current_station_id&amp;request_id=$get_request_id&amp;l=$l\">$l_view_request</a>
									</span>
								 </td>
								</tr>
								";
							} // while waiting members

					
							// Station Members
							$query = "SELECT station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60, station_member_user_image_thumb_200, station_member_user_position, station_member_user_department, station_member_user_location, station_member_user_about, station_member_show_on_board, station_member_can_be_jour, station_member_added_datetime, station_member_added_date_saying, station_member_added_by_user_id, station_member_added_by_user_name, station_member_added_by_user_alias, station_member_added_by_user_image FROM $t_edb_stations_members WHERE station_member_station_id=$get_current_station_id ORDER BY station_member_user_name ASC";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_station_member_id, $get_station_member_station_id, $get_station_member_station_title, $get_station_member_district_id, $get_station_member_district_title, $get_station_member_user_id, $get_station_member_rank, $get_station_member_user_name, $get_station_member_user_alias, $get_station_member_first_name, $get_station_member_middle_name, $get_station_member_last_name, $get_station_member_user_email, $get_station_member_user_image_path, $get_station_member_user_image_file, $get_station_member_user_image_thumb_40, $get_station_member_user_image_thumb_50, $get_station_member_user_image_thumb_60, $get_station_member_user_image_thumb_200, $get_station_member_user_position, $get_station_member_user_department, $get_station_member_user_location, $get_station_member_user_about, $get_station_member_show_on_board, $get_station_member_can_be_jour, $get_station_member_added_datetime, $get_station_member_added_date_saying, $get_station_member_added_by_user_id, $get_station_member_added_by_user_name, $get_station_member_added_by_user_alias, $get_station_member_added_by_user_image) = $row;

								if(isset($odd) && $odd == false){
									$odd = true;
								}
								else{
									$odd = false;
								}

								// Find user
								$query_b = "SELECT user_id, user_email, user_name, user_alias, user_language, user_rank, user_points, user_points_rank, user_gender, user_dob, user_registered, user_registered_time, user_last_online, user_last_online_time FROM $t_users WHERE user_id=$get_station_member_user_id";
								$result_b = mysqli_query($link, $query_b);
								$row_b = mysqli_fetch_row($result_b);
								list($get_user_id, $get_user_email, $get_user_name, $get_user_alias, $get_user_language, $get_user_rank, $get_user_points, $get_user_points_rank, $get_user_gender, $get_user_dob, $get_user_registered, $get_user_registered_time, $get_user_last_online, $get_user_last_online_time) = $row_b;
								if($get_user_id == ""){
									$result_delete = mysqli_query($link, "DELETE FROM $t_edb_stations_members WHERE station_member_id=$get_station_member_id") or die(mysqli_error($link));

								}

								echo"
								<tr>
								  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
									<span>$get_station_member_first_name $get_station_member_middle_name $get_station_member_last_name</span>
								  </td>
								  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
									<a href=\"edit_station_members.php?action=edit_member&amp;station_id=$get_current_station_id&amp;member_id=$get_station_member_id&amp;l=$l\">$get_station_member_user_name</a>
								  </td>
								  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
									<span>";
									if($get_station_member_rank == "admin"){
										echo"$l_admin";
									}
									elseif($get_station_member_rank  == "moderator"){
										echo"$l_moderator";
									}
									elseif($get_station_member_rank  == "editor"){
										echo"$l_editor";
									}
									elseif($get_station_member_rank  == "editor_limited"){
										echo"$l_editor_limited";
									}
									elseif($get_station_member_rank  == "member"){
										echo"$l_member";
									}
									echo"</span>
								  </td>
								  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
									<span>";
									if($get_station_member_show_on_board  == "1"){
										echo"$l_yes";
									}
									else{
										echo"$l_no";
									}
									echo"</span>
								  </td>
								  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
									<span>";
									if($get_station_member_can_be_jour  == "1"){
										echo"$l_yes";
									}
									else{
										echo"$l_no";
									}
									echo"</span>
								  </td>
								  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
									<span>
									<a href=\"edit_station_members.php?action=edit_member&amp;station_id=$get_current_station_id&amp;member_id=$get_station_member_id&amp;l=$l\">$l_edit</a>
									&middot;
									<a href=\"edit_station_members.php?action=delete_member&amp;station_id=$get_current_station_id&amp;member_id=$get_station_member_id&amp;l=$l\">$l_delete</a>
									</span>
								 </td>
								</tr>
								";
							} // while members
							echo"
							 </tbody>
							</table>


						<!-- //Memberlist -->
						";

					} // action == ""
					elseif($action == "edit_member"){
						// Find member	
						$query = "SELECT station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60, station_member_user_image_thumb_200, station_member_user_position, station_member_user_department, station_member_user_location, station_member_user_about, station_member_show_on_board, station_member_can_be_jour, station_member_added_datetime, station_member_added_date_saying, station_member_added_by_user_id, station_member_added_by_user_name, station_member_added_by_user_alias, station_member_added_by_user_image FROM $t_edb_stations_members WHERE station_member_id=$member_id_mysql AND station_member_district_id=$get_current_district_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_current_station_member_id, $get_current_station_member_station_id, $get_current_station_member_station_title, $get_current_station_member_district_id, $get_current_station_member_district_title, $get_current_station_member_user_id, $get_current_station_member_rank, $get_current_station_member_user_name, $get_current_station_member_user_alias, $get_current_station_member_first_name, $get_current_station_member_middle_name, $get_current_station_member_last_name, $get_current_station_member_user_email, $get_current_station_member_user_image_path, $get_current_station_member_user_image_file, $get_current_station_member_user_image_thumb_40, $get_current_station_member_user_image_thumb_50, $get_current_station_member_user_image_thumb_60, $get_current_station_member_user_image_thumb_200, $get_current_station_member_user_position, $get_current_station_member_user_department, $get_current_station_member_user_location, $get_current_station_member_user_about, $get_station_member_show_on_board, $get_station_member_can_be_jour, $get_current_station_member_added_datetime, $get_current_station_member_added_date_saying, $get_current_station_member_added_by_user_id, $get_current_station_member_added_by_user_name, $get_current_station_member_added_by_user_alias, $get_current_station_member_added_by_user_image) = $row;

						if($get_current_station_member_id == ""){
							echo"
							<h1>Server error 404</h1>

							<p>Member not found.</p>
							<p><a href=\"edit_station_members.php?station_id=$get_current_station_id&amp;l=$l\">Back</a></p>
							";
						}
						else{
							if($process == "1"){
								$inp_rank = $_POST['inp_rank'];
								$inp_rank = output_html($inp_rank);

								if($inp_rank == "admin"){
									if($get_my_station_member_rank != "admin"){
										$url = "edit_station_members.php?action=edit_member&station_id=$get_current_station_id&member_id=$get_current_station_member_id&l=$l&ft=error&fm=cannot_give_admin";
										header("Location: $url");
										die;
									}
								}
								$inp_rank_mysql = quote_smart($link, $inp_rank);

								$inp_show_on_board = $_POST['inp_show_on_board'];
								$inp_show_on_board = output_html($inp_show_on_board);
								$inp_show_on_board_mysql = quote_smart($link, $inp_show_on_board);

								$inp_can_be_jour = $_POST['inp_can_be_jour'];
								$inp_can_be_jour = output_html($inp_can_be_jour);
								$inp_can_be_jour_mysql = quote_smart($link, $inp_can_be_jour);

								
								$result = mysqli_query($link, "UPDATE $t_edb_stations_members SET 	
												station_member_rank=$inp_rank_mysql,
												station_member_show_on_board=$inp_show_on_board_mysql,
												station_member_can_be_jour=$inp_can_be_jour_mysql 
												 WHERE station_member_id=$member_id_mysql AND station_member_station_id=$get_current_station_id") or die(mysqli_error($link));

								$url = "edit_station_members.php?action=edit_member&station_id=$get_current_station_id&member_id=$get_current_station_member_id&l=$l&ft=success&fm=changes_saved";
								header("Location: $url");
								die;
							}
							echo"
							<h1>$l_edit $get_current_station_member_user_name</h1>


							<!-- Where am I ? -->
								<p><b>$l_you_are_here:</b><br />
								<a href=\"index.php?l=$l\">$l_edb</a>
								&gt;
								<a href=\"cases_board_1_view_district.php?district_id=$get_current_district_id&amp;l=$l\">$get_current_district_title</a>
								&gt;
								<a href=\"cases_board_2_view_station.php?station_id=$get_current_station_id&amp;l=$l\">$get_current_station_title</a>
								&gt;
								<a href=\"edit_station_members.php?station_id=$get_current_station_id&amp;l=$l\">$l_members</a>
								&gt;
								<a href=\"edit_station_members.php?action=edit_member&amp;station_id=$get_current_station_id&amp;member_id=$get_current_station_member_id&amp;l=$l\">$get_current_station_member_user_name</a>
								</p>
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

							
							<!-- Focus -->
								<script>
								\$(document).ready(function(){
									\$('[name=\"inp_rank\"]').focus();
								});
								</script>
							<!-- //Focus -->

							<!-- Edit member form -->
								<form method=\"POST\" action=\"edit_station_members.php?action=edit_member&amp;station_id=$get_current_station_id&amp;member_id=$get_current_station_member_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

								<p><b>$l_rank:</b><br />
								<select name=\"inp_rank\">
								";
								if($get_my_station_member_rank == "admin"){
									echo"<option value=\"admin\""; if($get_current_station_member_rank == "admin"){ echo" selected=\"selected\""; } echo">$l_admin</option>\n";
								}
								if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator"){
									echo"<option value=\"moderator\""; if($get_current_station_member_rank == "moderator"){ echo" selected=\"selected\""; } echo">$l_moderator</option>\n";
								}
								if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
									echo"<option value=\"editor\""; if($get_current_station_member_rank == "editor"){ echo" selected=\"selected\""; } echo">$l_editor</option>\n";
								}
								if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){
									echo"<option value=\"editor_limited\""; if($get_current_station_member_rank == "editor_limited"){ echo" selected=\"selected\""; } echo">$l_editor_limited ($l_can_only_edit_detective_notes_and_detective_tasks)</option>\n";
								}
								echo"
								<option value=\"member\""; if($get_current_station_member_rank == "member"){ echo" selected=\"selected\""; } echo">$l_member ($l_view_only)</option>
								</select>
								</p>

								<p><b>$l_show_on_board:</b><br />
								<input type=\"radio\" name=\"inp_show_on_board\" value=\"1\""; if($get_station_member_show_on_board == "1"){ echo" checked=\"checked\""; } echo" /> $l_yes &nbsp;
								<input type=\"radio\" name=\"inp_show_on_board\" value=\"0\""; if($get_station_member_show_on_board == "0" OR $get_station_member_show_on_board == ""){ echo" checked=\"checked\""; } echo" /> $l_no
								</p>
								<p><b>$l_can_be_jour:</b><br />
								<input type=\"radio\" name=\"inp_can_be_jour\" value=\"1\""; if($get_station_member_can_be_jour == "1"){ echo" checked=\"checked\""; } echo" /> $l_yes &nbsp;
								<input type=\"radio\" name=\"inp_can_be_jour\" value=\"0\""; if($get_station_member_can_be_jour == "0" OR $get_station_member_show_on_board == ""){ echo" checked=\"checked\""; } echo" /> $l_no
								</p>

								<p>
								<input type=\"submit\" value=\"$l_save\" class=\"btn_default\" />
								</p>
							<!-- //Edit member form -->
							";
						} // member found

					} // action == "edit_member
					elseif($action == "delete_member"){
						// Find member	
						$query = "SELECT station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60, station_member_user_image_thumb_200, station_member_user_position, station_member_user_department, station_member_user_location, station_member_user_about, station_member_added_datetime, station_member_added_date_saying, station_member_added_by_user_id, station_member_added_by_user_name, station_member_added_by_user_alias, station_member_added_by_user_image FROM $t_edb_stations_members WHERE station_member_id=$member_id_mysql AND station_member_district_id=$get_current_district_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_current_station_member_id, $get_current_station_member_station_id, $get_current_station_member_station_title, $get_current_station_member_district_id, $get_current_station_member_district_title, $get_current_station_member_user_id, $get_current_station_member_rank, $get_current_station_member_user_name, $get_current_station_member_user_alias, $get_current_station_member_first_name, $get_current_station_member_middle_name, $get_current_station_member_last_name, $get_current_station_member_user_email, $get_current_station_member_user_image_path, $get_current_station_member_user_image_file, $get_current_station_member_user_image_thumb_40, $get_current_station_member_user_image_thumb_50, $get_current_station_member_user_image_thumb_60, $get_current_station_member_user_image_thumb_200, $get_current_station_member_user_position, $get_current_station_member_user_department, $get_current_station_member_user_location, $get_current_station_member_user_about, $get_current_station_member_added_datetime, $get_current_station_member_added_date_saying, $get_current_station_member_added_by_user_id, $get_current_station_member_added_by_user_name, $get_current_station_member_added_by_user_alias, $get_current_station_member_added_by_user_image) = $row;

						if($get_current_station_member_id == ""){
							echo"
							<h1>Server error 404</h1>

							<p>Member not found.</p>
							<p><a href=\"edit_station_members.php?station_id=$get_current_station_id&amp;l=$l\">Back</a></p>
							";
						}
						else{
							if($process == "1"){
							

								$result = mysqli_query($link, "DELETE FROM $t_edb_stations_members WHERE station_member_id=$member_id_mysql AND station_member_station_id=$get_current_station_id") or die(mysqli_error($link));

								$url = "edit_station_members.php?station_id=$get_current_station_id&l=$l&ft=success&fm=member_deleted_from_station";
								header("Location: $url");
								die;
							}
							echo"
							<h1>$l_delete $get_current_station_member_user_name</h1>


							<!-- Where am I ? -->
								<p><b>$l_you_are_here:</b><br />
								<a href=\"index.php?l=$l\">$l_edb</a>
								&gt;
								<a href=\"open_district.php?district_id=$get_current_district_id&amp;l=$l\">$get_current_district_title</a>
								&gt;
								<a href=\"open_station.php?station_id=$get_current_station_id&amp;l=$l\">$get_current_station_title</a>
								&gt;
								<a href=\"edit_station_members.php?station_id=$get_current_station_id&amp;l=$l\">$l_members</a>
								&gt;
								<a href=\"edit_station_members.php?action=delete_member&amp;station_id=$get_current_station_id&amp;member_id=$get_current_station_member_id&amp;l=$l\">$get_current_station_member_user_name</a>
								</p>
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

							
							<!-- Focus -->
								<script>
								\$(document).ready(function(){
									\$('[name=\"inp_rank\"]').focus();
								});
								</script>
							<!-- //Focus -->
							<!-- Delete member form -->
								<p>$l_are_you_sure_you_want_to_delete_the_member_from_the_station $get_current_station_title?</p>

								<p>
								<a href=\"edit_station_members.php?action=delete_member&amp;station_id=$get_current_station_id&amp;member_id=$get_current_station_member_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">$l_confirm</a>
								</p>
							<!-- //Delete member form -->
							";
						} // member found

					} // action == "delete_member
					elseif($action == "view_request"){
						if(isset($_GET['request_id'])) {
							$request_id = $_GET['request_id'];
							$request_id = strip_tags(stripslashes($request_id));
						}
						else{
							$request_id = "";
						}
						$request_id_mysql = quote_smart($link, $request_id);


						// Find request
						$query = "SELECT request_id, request_station_id, request_station_title, request_district_id, request_district_title, request_user_id, request_rank, request_user_name, request_user_alias, request_user_first_name, request_user_middle_name, request_user_last_name, request_user_email, request_user_image_path, request_user_image_file, request_user_image_thumb_40, request_user_image_thumb_50, request_user_image_thumb_60, request_user_image_thumb_200, request_user_position, request_user_department, request_user_location, request_user_about, request_datetime, request_date_saying FROM $t_edb_stations_membership_requests WHERE request_id=$request_id_mysql AND request_station_id=$get_current_station_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_current_request_id, $get_current_request_station_id, $get_current_request_station_title, $get_current_request_district_id, $get_current_request_district_title, $get_current_request_user_id, $get_current_request_rank, $get_current_request_user_name, $get_current_request_user_alias, $get_current_request_user_first_name, $get_current_request_user_middle_name, $get_current_request_user_last_name, $get_current_request_user_email, $get_current_request_user_image_path, $get_current_request_user_image_file, $get_current_request_user_image_thumb_40, $get_current_request_user_image_thumb_50, $get_current_request_user_image_thumb_60, $get_current_request_user_image_thumb_200, $get_current_request_user_position, $get_current_request_user_department, $get_current_request_user_location, $get_current_request_user_about, $get_current_request_datetime, $get_current_request_date_saying) = $row;

						if($get_current_request_id == ""){
							echo"
							<h1>Server error 404</h1>

							<p>Request not found.</p>
							<p><a href=\"edit_station_members.php?station_id=$get_current_station_id&amp;l=$l\">Back</a></p>
							";
						}
						else{
							if($process == "1"){
								if($mode == "accept_request"){
									$inp_rank = $_POST['inp_rank'];
									$inp_rank = output_html($inp_rank);

									if($inp_rank == "admin"){
										if($get_my_district_member_rank != "admin"){
											$url = "edit_station_members.php?action=view_request&station_id=$get_current_station_id&request_id=$get_current_request_id&l=$l&ft=error&fm=cannot_give_admin";
											header("Location: $url");
											die;
										}
									}

									// Fetch data from requester
									$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_id=$get_current_request_user_id";
									$result = mysqli_query($link, $query);
									$row = mysqli_fetch_row($result);
									list($get_requester_user_id, $get_requester_user_email, $get_requester_user_name, $get_requester_user_alias, $get_requester_user_language, $get_requester_user_last_online, $get_requester_user_rank, $get_requester_user_login_tries) = $row;
					
									// Requester photo
									$query = "SELECT photo_id, photo_user_id, photo_profile_image, photo_title, photo_destination, photo_thumb_40, photo_thumb_50, photo_thumb_60, photo_thumb_200, photo_uploaded, photo_uploaded_ip, photo_views, photo_views_ip_block, photo_likes, photo_comments, photo_x_offset, photo_y_offset, photo_text FROM $t_users_profile_photo WHERE photo_user_id=$get_current_request_user_id AND photo_profile_image='1'";
									$result = mysqli_query($link, $query);
									$row = mysqli_fetch_row($result);
									list($get_requester_photo_id, $get_requester_photo_user_id, $get_requester_photo_profile_image, $get_requester_photo_title, $get_requester_photo_destination, $get_requester_photo_thumb_40, $get_requester_photo_thumb_50, $get_requester_photo_thumb_60, $get_requester_photo_thumb_200, $get_requester_photo_uploaded, $get_requester_photo_uploaded_ip, $get_requester_photo_views, $get_requester_photo_views_ip_block, $get_requester_photo_likes, $get_requester_photo_comments, $get_requester_photo_x_offset, $get_requester_photo_y_offset, $get_requester_photo_text) = $row;

									// Requester Profile
									$query = "SELECT profile_id, profile_first_name, profile_middle_name, profile_last_name, profile_about FROM $t_users_profile WHERE profile_user_id=$get_current_request_user_id";
									$result = mysqli_query($link, $query);
									$row = mysqli_fetch_row($result);
									list($get_requester_profile_id, $get_requester_profile_first_name, $get_requester_profile_middle_name, $get_requester_profile_last_name, $get_requester_profile_about) = $row;

									// Requester Professional
									$query = "SELECT professional_id, professional_user_id, professional_company, professional_company_location, professional_department, professional_work_email, professional_position FROM $t_users_professional WHERE professional_user_id=$get_current_request_user_id";
									$result = mysqli_query($link, $query);
									$row = mysqli_fetch_row($result);
									list($get_requester_professional_id, $get_requester_professional_user_id, $get_requester_professional_company, $get_requester_professional_company_location, $get_requester_professional_department, $get_requester_professional_work_email, $get_requester_professional_position) = $row;

									// Me
									$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_id=$my_user_id_mysql";
									$result = mysqli_query($link, $query);
									$row = mysqli_fetch_row($result);
									list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_language, $get_my_user_last_online, $get_my_user_rank, $get_my_user_login_tries) = $row;
					
									// My photo
									$query = "SELECT photo_id, photo_destination, photo_thumb_40 FROM $t_users_profile_photo WHERE photo_user_id=$my_user_id_mysql AND photo_profile_image='1'";
									$result = mysqli_query($link, $query);
									$row = mysqli_fetch_row($result);
									list($get_my_photo_id, $get_my_photo_destination, $get_my_photo_thumb_40) = $row;



									// Inputs
									$inp_station_title_mysql = quote_smart($link, $get_current_request_station_title);
									$inp_district_title_mysql = quote_smart($link, $get_current_request_district_title);

									$inp_user_id_mysql = quote_smart($link, $get_requester_user_id);
									$inp_rank_mysql = quote_smart($link, $inp_rank);
									$inp_user_name_mysql = quote_smart($link, $get_requester_user_name);
									$inp_user_alias_mysql = quote_smart($link, $get_requester_user_alias);
									$inp_user_first_name_mysql = quote_smart($link, $get_requester_profile_first_name);
									$inp_user_middle_name_mysql = quote_smart($link, $get_requester_profile_middle_name);
									$inp_user_last_name_mysql = quote_smart($link, $get_requester_profile_last_name);
									$inp_user_email_mysql = quote_smart($link, $get_requester_user_email);

									$inp_user_image_path = "_uploads/users/images/$get_requester_user_id";
									$inp_user_image_path_mysql = quote_smart($link, $inp_user_image_path);

									$inp_user_image_file_mysql = quote_smart($link, $get_requester_photo_destination);
									$inp_user_image_thumb_a_mysql = quote_smart($link, $get_requester_photo_thumb_40);
									$inp_user_image_thumb_b_mysql = quote_smart($link, $get_requester_photo_thumb_50);
									$inp_user_image_thumb_c_mysql = quote_smart($link, $get_requester_photo_thumb_60);
									$inp_user_image_thumb_d_mysql = quote_smart($link, $get_requester_photo_thumb_200);


									$inp_user_position_mysql = quote_smart($link, $get_requester_professional_position);
									$inp_user_department_mysql = quote_smart($link, $get_requester_professional_department);
									$inp_user_location_mysql = quote_smart($link, $get_requester_professional_company_location);
									$inp_user_about_mysql = quote_smart($link, $get_requester_profile_about);

									$inp_added_datetime = date("Y-m-d H:i:s");
									$inp_added_date_saying = date("j M Y");
									$inp_added_by_user_id_mysql = quote_smart($link, $get_my_user_id);
									$inp_added_by_user_name_mysql = quote_smart($link, $get_my_user_name);
									$inp_added_by_user_alias_mysql = quote_smart($link, $get_my_user_alias);
									$inp_added_by_user_image_mysql = quote_smart($link, $get_my_photo_destination);

									// Insert into member table
									mysqli_query($link, "INSERT INTO $t_edb_stations_members
									(station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60, station_member_user_image_thumb_200, station_member_user_position, station_member_user_department, station_member_user_location, station_member_user_about, station_member_added_datetime, station_member_added_date_saying, station_member_added_by_user_id, station_member_added_by_user_name, station_member_added_by_user_alias, station_member_added_by_user_image) 
									VALUES 
									(NULL, $get_current_station_id, $inp_station_title_mysql, $get_current_district_id, $inp_district_title_mysql, $inp_user_id_mysql, $inp_rank_mysql, $inp_user_name_mysql, $inp_user_alias_mysql, $inp_user_first_name_mysql, $inp_user_middle_name_mysql, $inp_user_last_name_mysql, $inp_user_email_mysql, $inp_user_image_path_mysql, $inp_user_image_file_mysql, $inp_user_image_thumb_a_mysql, $inp_user_image_thumb_b_mysql, $inp_user_image_thumb_c_mysql, $inp_user_image_thumb_d_mysql, $inp_user_position_mysql, $inp_user_department_mysql, $inp_user_location_mysql, $inp_user_about_mysql, '$inp_added_datetime', '$inp_added_date_saying', $inp_added_by_user_id_mysql, $inp_added_by_user_name_mysql, $inp_added_by_user_alias_mysql, $inp_added_by_user_image_mysql)")
									or die(mysqli_error($link));

									// Delete request
									$result = mysqli_query($link, "DELETE FROM $t_edb_stations_membership_requests WHERE request_id=$request_id_mysql AND request_station_id=$get_current_station_id");

									// Header
									$url = "edit_station_members.php?station_id=$get_current_station_id&l=$l&ft=success&fm=member_accepted";
									header("Location: $url");
									die;
								}
								else{
									// Delete request
									$result = mysqli_query($link, "DELETE FROM $t_edb_stations_membership_requests WHERE request_id=$request_id_mysql AND request_station_id=$get_current_station_id");

									$url = "edit_station_members.php?station_id=$get_current_station_id&l=$l&ft=success&fm=request_declined";
									header("Location: $url");
									die;
								}
							}
							echo"
							<h1>$l_request $get_current_request_user_name</h1>


							<!-- Where am I ? -->
							<p><b>$l_you_are_here:</b><br />
							<a href=\"index.php?l=$l\">$l_edb</a>
							&gt;
							<a href=\"cases_board_1_view_district.php?district_id=$get_current_district_id&amp;l=$l\">$get_current_district_title</a>
							&gt;
							<a href=\"cases_board_2_view_station.php?station_id=$get_current_station_id&amp;l=$l\">$get_current_station_title</a>
							&gt;
							<a href=\"edit_station_members.php?station_id=$get_current_station_id&amp;l=$l\">$l_members</a>
							&gt;
							<a href=\"edit_station_members.php?action=view_request&amp;station_id=$get_current_station_id&amp;request_id=$get_current_request_id&amp;l=$l\">$get_current_request_user_name</a>
							</p>
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

							<!-- Request form -->
								<form method=\"POST\" action=\"edit_station_members.php?action=view_request&amp;mode=accept_request&amp;station_id=$get_current_station_id&amp;request_id=$get_current_request_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

								";
								if($get_current_request_user_image_file != "" && file_exists("$root/_uploads/users/images/$get_current_request_user_id/$get_current_request_user_image_file")){
									echo"
									<img src=\"$root/_uploads/users/images/$get_current_request_user_id/$get_current_request_user_image_file\" alt=\"$get_current_request_user_image_file\" style=\"float: right;\" />
									";
								}
								echo"

								<p><b>$l_username</b><br />
								$get_current_request_user_name";
								if($get_current_request_user_alias != "$get_current_request_user_name"){
									echo" ($get_current_request_user_alias)";
								}
								echo"</p>

								<p><b>$l_name</b><br />
								$get_current_request_user_first_name $get_current_request_user_middle_name $get_current_request_user_last_name
								</p>

								<p><b>$l_email:</b><br />
								$get_current_request_user_email
								</p>

								<p><b>$l_position:</b><br />
								$get_current_request_user_position
								</p>

								<p><b>$l_department:</b><br />
								$get_current_request_user_department
								</p>

								<p><b>$l_location:</b><br />
								$get_current_request_user_location
								</p>

								<p><b>$l_about:</b><br />
								$get_current_request_user_about
								</p>

								<p><b>$l_requested_date:</b><br />
								$get_current_request_date_saying
								</p>

								<p><b>$l_rank:</b><br />
								<select name=\"inp_rank\">
									";
									if($get_my_station_member_rank == "admin"){
										echo"<option value=\"admin\">$l_admin</option>\n";
									}
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator"){
										echo"<option value=\"moderator\">$l_moderator</option>\n";
									}
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
										echo"<option value=\"editor\">$l_editor</option>\n";
									}
									if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor" OR $get_my_station_member_rank == "editor_limited"){
										echo"<option value=\"editor_limited\">$l_editor_limited ($l_can_only_edit_detective_notes_and_detective_tasks)</option>\n";
									}
									echo"
									<option value=\"member\">$l_member ($l_view_only)</option>
								</select>
								</p>

								<p>
								<input type=\"submit\" value=\"$l_accept_request\" class=\"btn_default\" />
								<a href=\"edit_station_members.php?action=view_request&amp;mode=decline_request&amp;station_id=$get_current_station_id&amp;request_id=$get_current_request_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">$l_decline_request</a>
								</p>
							<!-- //Edit member form -->
							";
						} // request found
					

					} // view_request
				} // admin or moderator
				else{
					echo"
					<h1>Server error 403</h1>
					<p>Only admin and moderators can edit access.</p>
					";
				}
			} // access to district 
		} // district found
	} // station found

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