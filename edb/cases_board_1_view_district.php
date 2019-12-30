<?php 
/**
*
* File: edb/cases_overview.php
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
include("$root/_admin/_translations/site/$l/edb/ts_cases_board_2_view_station.php");

/*- Tables ---------------------------------------------------------------------------- */
$t_edb_home_page_user_remember			= $mysqlPrefixSav . "edb_home_page_user_remember";


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



/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){



	// Find district
	$query = "SELECT district_id, district_number, district_title, district_title_clean, district_icon_path, district_icon_16, district_icon_32, district_icon_260, district_number_of_stations, district_number_of_cases_now FROM $t_edb_districts_index WHERE district_id=$district_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_district_id, $get_current_district_number, $get_current_district_title, $get_current_district_title_clean, $get_current_district_icon_path, $get_current_district_icon_16, $get_current_district_icon_32, $get_current_district_icon_260, $get_current_district_number_of_stations, $get_current_district_number_of_cases_now) = $row;
	
	if($get_current_district_id == ""){
		echo"<h1>Server error 404</h1><p>District not found</p>";
		die;
	}
	else{
		/*- Headers ---------------------------------------------------------------------------------- */
		$website_title = "$l_edb - $get_current_district_title";
		if(file_exists("./favicon.ico")){ $root = "."; }
		elseif(file_exists("../favicon.ico")){ $root = ".."; }
		elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
		elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
		include("$root/_webdesign/header.php");

		// Me
		$my_user_id = $_SESSION['user_id'];
		$my_user_id = output_html($my_user_id);
		$my_user_id_mysql = quote_smart($link, $my_user_id);


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
		else{
			// View method
			$query = "SELECT view_method_id, view_method FROM $t_edb_stations_user_view_method WHERE user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_view_method_id, $get_current_view_method) = $row;
			if($get_current_view_method_id == ""){
				mysqli_query($link, "INSERT INTO $t_edb_stations_user_view_method 
				(view_method_id, user_id, view_method) 
				VALUES 
				(NULL, $my_user_id_mysql, 'person')")
				or die(mysqli_error($link));
				$get_current_view_method = "person";
			}
			if(isset($_GET['view_method'])) {
				$view_method = $_GET['view_method'];
				$view_method = strip_tags(stripslashes($view_method));
				$get_current_view_method = "$view_method";
				if($view_method == "default"){
					$result = mysqli_query($link, "UPDATE $t_edb_stations_user_view_method SET view_method='default' WHERE user_id=$my_user_id_mysql");
				}
				elseif($view_method == "person"){
					$result = mysqli_query($link, "UPDATE $t_edb_stations_user_view_method SET view_method='person' WHERE user_id=$my_user_id_mysql");
				}
			}


			// Agent active/inactive
			$query = "SELECT active_inactive_id, agent_is_active FROM $t_edb_agent_user_active_inactive WHERE user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_active_inactive_id, $get_current_agent_is_active) = $row;
			if($get_current_active_inactive_id == ""){
				mysqli_query($link, "INSERT INTO $t_edb_agent_user_active_inactive 
				(active_inactive_id, user_id, agent_is_active) 
				VALUES 
				(NULL, $my_user_id_mysql, 0)")
				or die(mysqli_error($link));
			}
			if(isset($_GET['agent_active'])) {
				$agent_active = $_GET['agent_active'];
				$agent_active = strip_tags(stripslashes($agent_active));
				$get_current_agent_is_active = "$agent_active";
				if($agent_active == "1"){
					$result = mysqli_query($link, "UPDATE $t_edb_agent_user_active_inactive SET agent_is_active=1 WHERE user_id=$my_user_id_mysql");
				}
				elseif($agent_active == "0"){
					$result = mysqli_query($link, "UPDATE $t_edb_agent_user_active_inactive SET agent_is_active=0 WHERE user_id=$my_user_id_mysql");
				}
			}


			// Human tasks deadline overdue
			$query = "SELECT human_task_id, human_task_case_id, human_task_text, human_task_deadline_date_ddmmyyyy FROM $t_edb_case_index_human_tasks WHERE human_task_responsible_user_id=$my_user_id_mysql AND human_task_sent_deadline_notification='0' AND human_task_deadline_time < '$time'";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_human_task_id, $get_human_task_case_id, $get_human_task_text, $get_human_task_deadline_date_ddmmyyyy) = $row;
			if($get_human_task_id != ""){
				$inp_text = "$l_task_deadline_overdue_for_case $get_human_task_case_id: $get_human_task_text ($get_human_task_deadline_date_ddmmyyyy)";
				$inp_text_mysql = quote_smart($link, $inp_text);

				$inp_url = "../edb/open_case_human_tasks.php?case_id=$get_human_task_case_id&amp;l=$l";
				$inp_url_mysql = quote_smart($link, $inp_url);
				
				// Insert into notification
				$datetime = date("Y-m-d H:i:s");
				$week = date("W");
				mysqli_query($link, "INSERT INTO $t_users_notifications
				(notification_id, notification_user_id, notification_seen, notification_url, notification_text, notification_datetime, notification_emailed, notification_week) 
				VALUES 
				(NULL, $my_user_id_mysql, 0, $inp_url_mysql, $inp_text_mysql, '$datetime', '0', '$week')")
				or die(mysqli_error($link));

				// Get notification ID
				$query = "SELECT notification_id FROM $t_users_notifications WHERE notification_user_id=$my_user_id_mysql AND notification_seen=0 AND notification_datetime='$datetime'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_notification_id) = $row;

				echo"
				<div class=\"warning\"><p><a href=\"$root/users/notifications.php?action=visit&amp;notification_id=$get_notification_id&amp;l=$l&amp;process=1\">$inp_text</a></p></div>
				";
					
				// Update task
				$result = mysqli_query($link, "UPDATE $t_edb_case_index_human_tasks SET human_task_sent_deadline_notification='1' WHERE human_task_id=$get_human_task_id") or die(mysqli_error($link));
			}

			if($action == ""){
				echo"
				<!-- Headline + Select cases board -->
					<div style=\"float: left;\">
						<table>
						 <tr>
						  <td style=\"vertical-align:top;padding-right: 6px;\">
							<!-- Headline -->";
								if(isset($get_current_station_id)){
									echo"<h1>$get_current_station_title</h1>";
								}
								else{
									if(isset($get_current_district_id)){
										echo"<h1>$get_current_district_title</h1>";
									}
									else{
										echo"<h1>$l_all_locations</h1>";
									}
								}
								echo"
							<!-- //Headline -->
						  </td>
						  <td style=\"vertical-align:top;padding-right: 10px;\">
							<!-- Select Location -->

							<script>
							\$(document).ready(function(){
								\$(\".edb_switch_location_link\").click(function () {
									\$(\"#edb_locations\").toggle();
								});
							});
							</script>



							<p class=\"edb_switch_location_p\"><a href=\"#\" class=\"edb_switch_location_link\">$l_locations <img src=\"_gfx/switch_board_icon.png\" alt=\"switch_board_icon.png\" /></a></p>

							<div id=\"edb_locations\">
								<ul>
								";
								$query = "SELECT district_member_id, district_member_district_id, district_member_district_title FROM $t_edb_districts_members WHERE district_member_user_id='$my_user_id_mysql' ORDER BY district_member_district_title ASC";
								$result = mysqli_query($link, $query);
								while($row = mysqli_fetch_row($result)) {
									list($get_district_member_id, $get_district_member_district_id, $get_district_member_district_title) = $row;
		
									echo"<li><a href=\"cases_board_1_view_district.php?district_id=$get_district_member_district_id&amp;l=$l\">$get_district_member_district_title</a></li>";
										
									if(isset($get_current_district_id) && $get_current_district_id == "$get_district_member_district_id"){
										$query_sub = "SELECT station_member_id, station_member_station_id, station_member_station_title FROM $t_edb_stations_members WHERE station_member_district_id='$get_current_district_id' AND station_member_user_id='$my_user_id_mysql'  ORDER BY station_member_station_title ASC";
										$result_sub = mysqli_query($link, $query_sub);
										while($row_sub = mysqli_fetch_row($result_sub)) {
											list($get_station_member_id, $get_station_member_station_id, $get_station_member_station_title) = $row_sub;

											echo"<li style=\"padding-left: 20px;\"><a href=\"cases_board_2_view_station.php?district_id=$get_district_member_district_id&amp;station_id=$get_station_member_station_id&amp;l=$l\">$get_station_member_station_title</a></li>";
	
										}

									} // stations
								} // while districts
								echo"
									<li><a href=\"browse_districts_and_stations.php?l=$l\">$l_show_all...</a></li>

								</ul>
							</div>
							<!-- //Select Location -->
						  </td>
						  <td style=\"vertical-align:top;padding-right: 10px;\">
							<!-- View method -->

							<script>
							\$(document).ready(function(){
								\$(\".edb_switch_view_link\").click(function () {
									\$(\"#edb_views\").toggle();
								});
							});
							</script>



							<p class=\"edb_switch_view_p\"><a href=\"#switch_view\" class=\"edb_switch_view_link\">";
							if($get_current_view_method == "default" OR $get_current_view_method == ""){
								echo"$l_default";
							}
							else{
								echo"$l_person";
							}
							echo" <img src=\"_gfx/switch_board_icon.png\" alt=\"switch_board_icon.png\" /></a></p>

							<div id=\"edb_views\">
								<ul>
								<li><a href=\"cases_board_1_view_district.php?district_id=$get_current_district_id&amp;view_method=default&amp;l=$l\">$l_default</a></li>
								<li><a href=\"cases_board_1_view_district.php?district_id=$get_current_district_id&amp;view_method=person&amp;l=$l\">$l_person</a></li>
								</ul>
							</div>
							<!-- //View method -->
						  </td>
						  <td style=\"vertical-align:top;padding-right: 10px;\">
							<!-- Agent active -->

							
							<p class=\"edb_switch_view_p\">";
							if($get_current_agent_is_active == "1"){
								echo"<a href=\"cases_board_1_view_district.php?district_id=$get_current_district_id&amp;agent_active=0&amp;l=$l\">$l_agent_active</a>";
							}
							else{
								echo"<a href=\"cases_board_1_view_district.php?district_id=$get_current_district_id&amp;agent_active=1&amp;l=$l\">$l_agent_inactive</a>";
							}
							echo" <img src=\"_gfx/switch_board_icon.png\" alt=\"switch_board_icon.png\" /></a></p>
							<!-- //View method -->
						  </td>
						  <td style=\"vertical-align:top;padding-right: 10px;\">
							<!-- Menu -->

							<script>
							\$(document).ready(function(){
								\$(\".edb_switch_menu_link\").click(function () {
									\$(\"#edb_menu\").toggle();
								});
							});
							</script>



							<p class=\"edb_switch_menu_p\"><a href=\"#switch_menu\" class=\"edb_switch_menu_link\"> $l_menu <img src=\"_gfx/switch_board_icon.png\" alt=\"switch_board_icon.png\" /></a></p>

							<div id=\"edb_menu\">";
								include("menu.php");
							echo"
							</div>
							<!-- //Menu -->
						  </td>
						  <td style=\"vertical-align:top;\">
							<!-- Search -->
									<div class=\"search_for_case_and_evidence_query\">
										<form method=\"get\" action=\"search_for_case_and_evidence.php\" enctype=\"multipart/form-data\" id=\"search_for_case_and_evidence_form\">
										<input type=\"text\" name=\"inp_search_for_case_and_evidence_query\" id=\"inp_search_for_case_and_evidence_query\" class='auto' value=\"\" size=\"10\" />
										<input type=\"submit\" value=\"$l_search\" class=\"btn_default\" />
										</form>
										<div id=\"inp_search_for_case_and_evidence_query_results\"></div>
									</div>
									<!-- Search engines Autocomplete -->
									<script id=\"source\" language=\"javascript\" type=\"text/javascript\">
										\$(document).ready(function () {
											\$('#inp_search_for_case_and_evidence_query').keyup(function () {
									

       												// getting the value that user typed
       												var searchString    = \$(\"#inp_search_for_case_and_evidence_query\").val();
 												// forming the queryString
      												var data            = 'inp_search_for_case_and_evidence_query='+ searchString;
         
        											// if searchString is not empty
        											if(searchString) {
													\$(\"#inp_search_for_case_and_evidence_query_results\").css('visibility','visible');

           												// ajax call
            												\$.ajax({
                												type: \"POST\",
               													url: \"search_for_case_and_evidence_autocomplete.php\",
                												data: data,
														beforeSend: function(html) { // this happens before actual call
														\$(\"#inp_search_for_case_and_evidence_query_results\").html(''); 
													},
               												success: function(html){
                    												\$(\"#inp_search_for_case_and_evidence_query_results\").append(html);
              												}
            											});
       											}
        										return false;
            									});
         				   				});
									</script>
									<!-- //Search engines Autocomplete -->
							<!-- //Search -->
						  </td>
						 </tr>
						</table>
					</div>

						<div class=\"station_jour\">
							<!-- Jour this week + next week -->
								<table>
								 <tr>";
								$monday_time = strtotime('last monday', strtotime('tomorrow'));
								$monday_time = strtotime('last monday', $monday_time);
								$monday_date_ymd = date('Y-m-d', $monday_time);
								$x = 0;
								$query = "SELECT jour_id, jour_district_id, jour_district_title, jour_year_week, jour_year, jour_week, jour_from_date, jour_from_date_saying, jour_from_date_ddmmyy, jour_user_id, jour_user_name, jour_user_alias, jour_user_first_name, jour_user_middle_name, jour_user_last_name, jour_user_email, jour_user_image_path, jour_user_image_file, jour_user_image_thumb_40, jour_user_image_thumb_50 FROM $t_edb_districts_jour WHERE jour_district_id=$get_current_district_id AND jour_from_date > '$monday_date_ymd' ORDER BY jour_from_date ASC LIMIT 0,2";
								$result = mysqli_query($link, $query);
								while($row = mysqli_fetch_row($result)) {
									list($get_jour_id, $get_jour_district_id, $get_jour_district_title, $get_jour_year_week, $get_jour_year, $get_jour_week, $get_jour_from_date, $get_jour_from_date_saying, $get_jour_from_date_ddmmyy, $get_jour_user_id, $get_jour_user_name, $get_jour_user_alias, $get_jour_user_first_name, $get_jour_user_middle_name, $get_jour_user_last_name, $get_jour_user_email, $get_jour_user_image_path, $get_jour_user_image_file, $get_jour_user_image_thumb_40, $get_jour_user_image_thumb_50) = $row;
			
									echo"
									  <td style=\"padding-left: 10px;text-align: left;\">
										<p class=\"station_jour_headline_p\">";
										if($x == "0"){
											echo"<a href=\"jour.php?district_id=$get_current_district_id&amp;l=$l\" class=\"station_jour_headline_a\">$l_jour <span>$get_jour_year/$get_jour_week</span></a>";
										}
										else{
											echo"<a href=\"jour.php?district_id=$get_current_district_id&amp;l=$l\" class=\"station_jour_headline_a\"><span>$get_jour_week</span></a>";
										}
										echo"
										</p>
	
									";
									if($get_jour_id == ""){	
										echo"<span>$l_no_jour</span>";
									}
									else{
										$name = "$get_jour_user_first_name $get_jour_user_middle_name $get_jour_user_last_name";
										$name_len = strlen($name);
										if($name_len > 10){
											$name = substr($name, 0,7);
											$name = $name . "...";
										}
										echo"
										<table>
										 <tr>
										  <td style=\"padding-right: 4px;text-align: left;\">
											<a href=\"view_profile_and_update_profile_link.php?user_id=$get_jour_user_id&amp;l=$l\">";
											if(file_exists("$root/$get_jour_user_image_path/$get_jour_user_image_thumb_40") && $get_jour_user_image_thumb_40 != ""){
												echo"<img src=\"$root/$get_jour_user_image_path/$get_jour_user_image_thumb_40\" alt=\"$get_jour_user_image_thumb_40\" />";
											}
											else{
												echo"<img src=\"_gfx/avatar_blank_40.png\" alt=\"avatar_blank_40.png\" />";
											}
											echo"</a>
										  </td>
										  <td style=\"text-align: left;\">
											<a href=\"view_profile_and_update_profile_link.php?user_id=$get_jour_user_id&amp;l=$l\">$get_jour_user_name</a><br />
											<a href=\"view_profile_and_update_profile_link.php?user_id=$get_jour_user_id&amp;l=$l\" title=\"$get_jour_user_first_name $get_jour_user_middle_name $get_jour_user_last_name\">$name</a><br />
										  </td>
										 </tr>
										</table>
										";
									}
									echo"
										  </td>
									";
									$x++;
								} // while
							echo"
								 </tr>
								</table>
							<!-- //Jour this week + next week -->
						</div>
					<div class=\"clear\"></div>
				<!-- Headline + Select cases board -->

				<!-- Waiting membership requests for selected district and stations that belongs to this district -->
				";
				if($get_my_district_member_rank == "admin" OR $get_my_district_member_rank == "moderator"){
					$membership_district_requests_waiting = 0;
					$membership_stations_requests_waiting = 0;
					$query = "SELECT request_id FROM $t_edb_districts_membership_requests WHERE request_district_id=$get_current_district_id";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_request_id) = $row;

						$membership_district_requests_waiting++;
					} // while
					$query = "SELECT request_id, request_station_id FROM $t_edb_stations_membership_requests WHERE request_district_id=$get_current_district_id";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_request_id, $get_request_station_id) = $row;

						$membership_stations_requests_waiting++;
					} // while
					if($membership_district_requests_waiting > 0){
						echo"
						<div class=\"info\"><p><a href=\"edit_district_members.php?district_id=$get_current_district_id&amp;l=$l\">$l_district_membership_request: $membership_district_requests_waiting</a></p></div>
						";
					}
					if($membership_stations_requests_waiting > 0){
						echo"
						<div class=\"info\"><p><a href=\"edit_station_members.php?station_id=$get_request_station_id&amp;l=$l\">$l_station_membership_request: $membership_stations_requests_waiting</a></p></div>
						";
					}
				}
				echo"
				<!-- //Waiting membership requests for selected district and stations that belongs to this district -->

				<!-- Not confirmed cases -->";
					$query_cases = "SELECT case_id, case_number, case_title, case_code_id, case_code_title, case_priority_id, case_assigned_to_date_saying, case_assigned_to_date_ddmmyy, case_assigned_to_user_id, case_assigned_to_user_name, case_assigned_to_user_image_path, case_assigned_to_user_image_file, case_assigned_to_user_image_thumb_40, case_assigned_to_user_image_thumb_50, case_assigned_to_user_first_name, case_assigned_to_user_middle_name, case_assigned_to_user_last_name, case_created_date_saying, case_created_date_ddmmyy FROM $t_edb_case_index WHERE case_district_id=$get_current_district_id AND case_confirmed_by_human=0 AND case_human_rejected=0";
					$result_cases = mysqli_query($link, $query_cases);
					while($row_cases = mysqli_fetch_row($result_cases)) {
						list($get_case_id, $get_case_number, $get_case_title, $get_case_code_id, $get_case_code_title, $get_case_priority_id, $get_case_assigned_to_date_saying, $get_case_assigned_to_date_ddmmyy, $get_case_assigned_to_user_id, $get_case_assigned_to_user_name, $get_case_assigned_to_user_image_path, $get_case_assigned_to_user_image_file, $get_case_assigned_to_user_image_thumb_40, $get_case_assigned_to_user_image_thumb_50, $get_case_assigned_to_user_first_name, $get_case_assigned_to_user_middle_name, $get_case_assigned_to_user_last_name, $get_case_created_date_saying, $get_case_created_date_ddmmyy) = $row_cases;
						echo"
						<div class=\"info\"><p><a href=\"open_case_overview.php?case_id=$get_case_id&amp;l=$l\" style=\"color: black;\">$l_new_case_found: <b>$get_case_number</b>. $l_please_confirm_or_reject_it</a> 
						<a href=\"confirm_case.php?case_id=$get_case_id&amp;l=$l&amp;process=1\" class=\"btn_default\">$l_accept</a>
						<a href=\"reject_case.php?case_id=$get_case_id&amp;l=$l&amp;process=1\" class=\"btn_warning\">$l_reject</a></p></div>
						";
					}
					echo"
				<!-- //Not confirmed cases -->						


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


				<!-- Actions -->
					<p>
					<a href=\"new_case_step_2_select_station.php?district_id=$get_current_district_id&amp;l=$l\" class=\"btn_default\">$l_new_case</a>
					<a href=\"edit_district_members.php?district_id=$get_current_district_id&amp;l=$l\" class=\"btn_default\">$l_members</a>
					<a href=\"statistics_district.php?district_id=$get_current_district_id&amp;l=$l\" class=\"btn_default\">$l_statistics</a>
					</p>
				<!-- //Actions -->

				<!-- Statuses (for district) -->";
					if($get_current_view_method == "" OR $get_current_view_method == "default"){
						echo"
						<div id=\"edb_statuses\">
							<table>
							 <tbody>
							  <tr>";

						$query = "SELECT status_id, status_title, status_title_clean, status_bg_color, status_border_color, status_text_color, status_link_color, status_weight, status_number_of_cases_now, status_number_of_cases_max, status_show_on_front_page, status_on_given_status_do_close_case FROM $t_edb_case_statuses WHERE status_show_on_front_page=1 ORDER BY status_weight ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_status_id, $get_status_title, $get_status_title_clean, $get_status_bg_color, $get_status_border_color, $get_status_text_color, $get_status_link_color, $get_status_weight, $get_status_number_of_cases_now, $get_status_number_of_cases_max, $get_status_show_on_front_page, $get_status_on_given_status_do_close_case) = $row;
					
							// Get number of cases for this status on this district
							$query_counter = "SELECT district_case_counter_id, district_case_counter_number_of_cases_now FROM $t_edb_case_statuses_district_case_counter WHERE district_case_counter_district_id=$get_current_district_id AND district_case_counter_status_id=$get_status_id";
							$result_counter = mysqli_query($link, $query_counter);
							$row_counter = mysqli_fetch_row($result_counter);
							list($get_district_case_counter_id, $get_district_case_counter_number_of_cases_now) = $row_counter;

							echo"
							  <td style=\"width: 290px;vertical-align:top;padding-right:10px;\" class=\"cases_status_td\" id=\"status_id$get_status_id\">
								<p><b>$get_district_case_counter_number_of_cases_now</b> $get_status_title</p>
							";

							$cases_for_status_counter = 0;
							$query_cases = "SELECT $t_edb_case_index.case_id, $t_edb_case_index.case_number, $t_edb_case_index.case_title, $t_edb_case_index.case_code_id, $t_edb_case_index.case_code_title, $t_edb_case_index.case_priority_id, $t_edb_case_index.case_last_event_text, $t_edb_case_index.case_assigned_to_date_saying, $t_edb_case_index.case_assigned_to_date_ddmmyy, $t_edb_case_index.case_assigned_to_user_id, $t_edb_case_index.case_assigned_to_user_name, $t_edb_case_index.case_assigned_to_user_image_path, $t_edb_case_index.case_assigned_to_user_image_file, $t_edb_case_index.case_assigned_to_user_image_thumb_40, $t_edb_case_index.case_assigned_to_user_image_thumb_50, $t_edb_case_index.case_assigned_to_user_first_name, $t_edb_case_index.case_assigned_to_user_middle_name, $t_edb_case_index.case_assigned_to_user_last_name, $t_edb_case_index.case_created_date_saying, $t_edb_case_index.case_created_date_ddmmyy, $t_edb_case_priorities.priority_bg_color, $t_edb_case_priorities.priority_border_color, $t_edb_case_priorities.priority_text_color, $t_edb_case_priorities.priority_link_color FROM $t_edb_case_index JOIN $t_edb_case_priorities ON $t_edb_case_index.case_priority_id=$t_edb_case_priorities.priority_id WHERE $t_edb_case_index.case_status_id=$get_status_id AND $t_edb_case_index.case_district_id=$get_current_district_id AND $t_edb_case_index.case_confirmed_by_human=1 AND $t_edb_case_index.case_human_rejected=0 AND $t_edb_case_index.case_is_closed=0";
							$result_cases = mysqli_query($link, $query_cases);
							while($row_cases = mysqli_fetch_row($result_cases)) {
								list($get_case_id, $get_case_number, $get_case_title, $get_case_code_id, $get_case_code_title, $get_case_priority_id, $get_case_last_event_text, $get_case_assigned_to_date_saying, $get_case_assigned_to_date_ddmmyy, $get_case_assigned_to_user_id, $get_case_assigned_to_user_name, $get_case_assigned_to_user_image_path, $get_case_assigned_to_user_image_file, $get_case_assigned_to_user_image_thumb_40, $get_case_assigned_to_user_image_thumb_50, $get_case_assigned_to_user_first_name, $get_case_assigned_to_user_middle_name, $get_case_assigned_to_user_last_name, $get_case_created_date_saying, $get_case_created_date_ddmmyy, $get_priority_bg_color, $get_priority_border_color, $get_priority_text_color, $get_priority_link_color) = $row_cases;

								echo"
									<div class=\"cases_board_box_wrapper\" id=\"case_id$get_case_id\">
										<div class=\"cases_board_box_inner\" style=\"border-left: $get_priority_bg_color 4px solid;\">

											<!-- Case assigned to -->";
												if($get_case_assigned_to_user_id != "0" && $get_case_assigned_to_user_id != ""){
													echo"
													<div class=\"cases_board_box_inner_assigned_to_div\">
														<p>";
													if(file_exists("$root/$get_case_assigned_to_user_image_path/$get_case_assigned_to_user_image_file") && $get_case_assigned_to_user_image_file != ""){
														// Thumb name
														if($get_case_assigned_to_user_image_thumb_50 == ""){
															// Update thumb name
															$ext = get_extension($get_case_assigned_to_user_image_file);
															$inp_thumb_name = str_replace($ext, "", $get_case_assigned_to_user_image_file);
															$inp_thumb_name = $inp_thumb_name . "_50." . $ext;
															$inp_thumb_name_mysql = quote_smart($link, $inp_thumb_name);
															$result_update = mysqli_query($link, "UPDATE $t_edb_case_index SET case_assigned_to_user_image_thumb_50=$inp_thumb_name_mysql WHERE case_id=$get_case_id") or die(mysqli_error($link));

															// Transfer
															$get_case_assigned_to_user_image_thumb_40 = "$inp_thumb_name";
														}
								
														if(!(file_exists("$root/$get_case_assigned_to_user_image_path/$get_case_assigned_to_user_image_thumb_50"))){
															// Make thumb
															$inp_new_x = 50; // 950
															$inp_new_y = 50; // 640
															resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_case_assigned_to_user_image_path/$get_case_assigned_to_user_image_file", "$root/$get_case_assigned_to_user_image_path/$get_case_assigned_to_user_image_thumb_50");
														}


														echo"
														<a href=\"view_profile_and_update_profile_link.php?user_id=$get_case_assigned_to_user_id&amp;l=$l\"><img src=\"$root/$get_case_assigned_to_user_image_path/$get_case_assigned_to_user_image_thumb_50\" alt=\"$get_case_assigned_to_user_image_thumb_50\" title=\"$get_case_assigned_to_user_name ($get_case_assigned_to_user_first_name $get_case_assigned_to_user_middle_name $get_case_assigned_to_user_last_name)\" /></a><br />
														";
													}
													else{
														echo"
														<a href=\"view_profile_and_update_profile_link.php?user_id=$get_case_assigned_to_user_id&amp;l=$l\"><img src=\"_gfx/avatar_blank_50.png\" alt=\"avatar_blank_50.png\" title=\"$get_case_assigned_to_user_name ($get_case_assigned_to_user_first_name $get_case_assigned_to_user_middle_name $get_case_assigned_to_user_last_name)\" /></a><br />
														";
													}

													// Username saying
													$username_len = strlen($get_case_assigned_to_user_name);
													if($username_len > 6){
														$username_saying = substr($get_case_assigned_to_user_name, 0, 6);
													}
													else{
														$username_saying = "$get_case_assigned_to_user_name";
													}

													echo"
														<a href=\"view_profile_and_update_profile_link.php?user_id=$get_case_assigned_to_user_id&amp;l=$l\" title=\"$get_case_assigned_to_user_name ($get_case_assigned_to_user_first_name $get_case_assigned_to_user_middle_name $get_case_assigned_to_user_last_name)\">$username_saying</a>
														</p>
													</div>
													";
												}
												echo"

											<!-- //Case assigned to -->

											<p class=\"cases_box_headline_p\"><a href=\"open_case_overview.php?case_id=$get_case_id&amp;l=$l\"  class=\"cases_box_headline_a\" style=\"color: $get_priority_link_color;\">$get_case_number</a></p>

											<p class=\"cases_box_body_p\">
												$get_case_title<br />
												<span class=\"grey\" title=\"$get_case_created_date_saying\">$get_case_created_date_ddmmyy</span>

												<!-- Event -->
												";
												if($get_case_last_event_text != ""){
													echo"<span><br /><br />$get_case_last_event_text</span>";
												}
												echo"
												<!-- Location -->
											</p>
											<div class=\"clear\"></div>
										</div>
									</div>
									";
									$cases_for_status_counter++;
							} // while cases
							if($cases_for_status_counter != "$get_district_case_counter_number_of_cases_now" && $get_district_case_counter_id != ""){
								// echo"<div class=\"info\"><p>Updated number of cases counter</p></div>";
								$result_update = mysqli_query($link, "UPDATE $t_edb_case_statuses_district_case_counter SET district_case_counter_number_of_cases_now=$cases_for_status_counter WHERE district_case_counter_id=$get_district_case_counter_id") or die(mysqli_error($link));

							}
							echo"
							  </td>
							";
			
						} // while statuses


						echo"
							  </tr>
							 </tbody>
							</table>
						</div>
						";
					} // view method = default
					elseif($get_current_view_method == "person"){
						echo"
						<div style=\"height: 10px;\"></div>
						<div id=\"edb_statuses\">

							<table>
							 <tbody>
							  <tr>";
							// Show all BEFORE persons 
							$query = "SELECT status_id, status_title, status_title_clean, status_bg_color, status_border_color, status_text_color, status_link_color, status_weight, status_number_of_cases_now, status_number_of_cases_max, status_show_on_front_page, status_on_given_status_do_close_case, status_on_person_view_show_without_person FROM $t_edb_case_statuses WHERE status_show_on_front_page=1 AND status_on_person_view_show_without_person=1 AND status_on_person_view_show_before_person=1 ORDER BY status_weight ASC";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_status_id, $get_status_title, $get_status_title_clean, $get_status_bg_color, $get_status_border_color, $get_status_text_color, $get_status_link_color, $get_status_weight, $get_status_number_of_cases_now, $get_status_number_of_cases_max, $get_status_show_on_front_page, $get_status_on_given_status_do_close_case, $get_status_on_person_view_show_without_person) = $row;
					
								// Get number of cases for this status on this district
								$query_counter = "SELECT district_case_counter_id, district_case_counter_number_of_cases_now FROM $t_edb_case_statuses_district_case_counter WHERE district_case_counter_district_id=$get_current_district_id AND district_case_counter_status_id=$get_status_id";
								$result_counter = mysqli_query($link, $query_counter);
								$row_counter = mysqli_fetch_row($result_counter);
								list($get_district_case_counter_id, $get_district_case_counter_number_of_cases_now) = $row_counter;

								echo"
								  <td style=\"width: 290px;vertical-align:top;padding-right:10px;\" class=\"cases_status_td\" id=\"status_id$get_status_id\">
									<div class=\"cases_board_status_round_box\">
										<p><b>$get_district_case_counter_number_of_cases_now</b> $get_status_title</p>
								";

							
								$cases_for_status_counter = 0;
								$query_cases = "SELECT $t_edb_case_index.case_id, $t_edb_case_index.case_number, $t_edb_case_index.case_title, $t_edb_case_index.case_code_id, $t_edb_case_index.case_code_title, $t_edb_case_index.case_priority_id, $t_edb_case_index.case_last_event_text, $t_edb_case_index.case_assigned_to_date_saying, $t_edb_case_index.case_assigned_to_date_ddmmyy, $t_edb_case_index.case_assigned_to_user_id, $t_edb_case_index.case_assigned_to_user_name, $t_edb_case_index.case_assigned_to_user_image_path, $t_edb_case_index.case_assigned_to_user_image_file, $t_edb_case_index.case_assigned_to_user_image_thumb_40, $t_edb_case_index.case_assigned_to_user_image_thumb_50, $t_edb_case_index.case_assigned_to_user_first_name, $t_edb_case_index.case_assigned_to_user_middle_name, $t_edb_case_index.case_assigned_to_user_last_name, $t_edb_case_index.case_created_date_saying, $t_edb_case_index.case_created_date_ddmmyy, $t_edb_case_priorities.priority_bg_color, $t_edb_case_priorities.priority_border_color, $t_edb_case_priorities.priority_text_color, $t_edb_case_priorities.priority_link_color FROM $t_edb_case_index JOIN $t_edb_case_priorities ON $t_edb_case_index.case_priority_id=$t_edb_case_priorities.priority_id WHERE $t_edb_case_index.case_status_id=$get_status_id AND $t_edb_case_index.case_district_id=$get_current_district_id AND $t_edb_case_index.case_confirmed_by_human=1 AND $t_edb_case_index.case_human_rejected=0 AND $t_edb_case_index.case_is_closed=0";
								$result_cases = mysqli_query($link, $query_cases);
								while($row_cases = mysqli_fetch_row($result_cases)) {
									list($get_case_id, $get_case_number, $get_case_title, $get_case_code_id, $get_case_code_title, $get_case_priority_id, $get_case_last_event_text, $get_case_assigned_to_date_saying, $get_case_assigned_to_date_ddmmyy, $get_case_assigned_to_user_id, $get_case_assigned_to_user_name, $get_case_assigned_to_user_image_path, $get_case_assigned_to_user_image_file, $get_case_assigned_to_user_image_thumb_40, $get_case_assigned_to_user_image_thumb_50, $get_case_assigned_to_user_first_name, $get_case_assigned_to_user_middle_name, $get_case_assigned_to_user_last_name, $get_case_created_date_saying, $get_case_created_date_ddmmyy, $get_priority_bg_color, $get_priority_border_color, $get_priority_text_color, $get_priority_link_color) = $row_cases;

									echo"
										<div class=\"cases_board_box_wrapper\" id=\"case_id$get_case_id\">
											<div class=\"cases_board_box_inner\" style=\"border-left: $get_priority_bg_color 4px solid;\">

											<!-- Case assigned to -->";
												if($get_case_assigned_to_user_id != "0" && $get_case_assigned_to_user_id != ""){
													echo"
													<div class=\"cases_board_box_inner_assigned_to_div\">
														<p>";
													if(file_exists("$root/$get_case_assigned_to_user_image_path/$get_case_assigned_to_user_image_file") && $get_case_assigned_to_user_image_file != ""){
														// Thumb name
														if($get_case_assigned_to_user_image_thumb_50 == ""){
															// Update thumb name
															$ext = get_extension($get_case_assigned_to_user_image_file);
															$inp_thumb_name = str_replace($ext, "", $get_case_assigned_to_user_image_file);
															$inp_thumb_name = $inp_thumb_name . "_50." . $ext;
															$inp_thumb_name_mysql = quote_smart($link, $inp_thumb_name);
															$result_update = mysqli_query($link, "UPDATE $t_edb_case_index SET case_assigned_to_user_image_thumb_50=$inp_thumb_name_mysql WHERE case_id=$get_case_id") or die(mysqli_error($link));

															// Transfer
															$get_case_assigned_to_user_image_thumb_40 = "$inp_thumb_name";
														}
								
														if(!(file_exists("$root/$get_case_assigned_to_user_image_path/$get_case_assigned_to_user_image_thumb_50"))){
															// Make thumb
															$inp_new_x = 50; // 950
															$inp_new_y = 50; // 640
															resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_case_assigned_to_user_image_path/$get_case_assigned_to_user_image_file", "$root/$get_case_assigned_to_user_image_path/$get_case_assigned_to_user_image_thumb_50");
														}


														echo"
														<a href=\"view_profile_and_update_profile_link.php?user_id=$get_case_assigned_to_user_id&amp;l=$l\"><img src=\"$root/$get_case_assigned_to_user_image_path/$get_case_assigned_to_user_image_thumb_50\" alt=\"$get_case_assigned_to_user_image_thumb_50\" title=\"$get_case_assigned_to_user_name ($get_case_assigned_to_user_first_name $get_case_assigned_to_user_middle_name $get_case_assigned_to_user_last_name)\" /></a><br />
														";
													}
													else{
														echo"
														<a href=\"view_profile_and_update_profile_link.php?user_id=$get_case_assigned_to_user_id&amp;l=$l\"><img src=\"_gfx/avatar_blank_50.png\" alt=\"avatar_blank_50.png\" title=\"$get_case_assigned_to_user_name ($get_case_assigned_to_user_first_name $get_case_assigned_to_user_middle_name $get_case_assigned_to_user_last_name)\" /></a><br />
														";
													}

													// Username saying
													$username_len = strlen($get_case_assigned_to_user_name);
													if($username_len > 6){
														$username_saying = substr($get_case_assigned_to_user_name, 0, 6);
													}
													else{
														$username_saying = "$get_case_assigned_to_user_name";
													}

													echo"
														<a href=\"view_profile_and_update_profile_link.php?user_id=$get_case_assigned_to_user_id&amp;l=$l\" title=\"$get_case_assigned_to_user_name ($get_case_assigned_to_user_first_name $get_case_assigned_to_user_middle_name $get_case_assigned_to_user_last_name)\">$username_saying</a>
														</p>
													</div>
													";
												}
												echo"

											<!-- //Case assigned to -->

											<p class=\"cases_box_headline_p\"><a href=\"open_case_overview.php?case_id=$get_case_id&amp;l=$l\"  class=\"cases_box_headline_a\" style=\"color: $get_priority_link_color;\">$get_case_number</a></p>

											<p class=\"cases_box_body_p\">
												$get_case_title<br />
												<span class=\"grey\" title=\"$get_case_created_date_saying\">$get_case_created_date_ddmmyy</span>

												<!-- Event -->
												";
												if($get_case_last_event_text != ""){
													echo"<span><br /><br />$get_case_last_event_text</span>";
												}
												echo"
												<!-- Location -->
												</p>
												<div class=\"clear\"></div>
											</div> <!-- //cases_board_box_inner -->
										</div> <!-- //cases_board_box_wrapper -->
										";
										$cases_for_status_counter++;
									} // cases while
									if($cases_for_status_counter != "$get_district_case_counter_number_of_cases_now" && $get_district_case_counter_id != ""){
										// echo"<div class=\"info\"><p>Updated number of cases counter</p></div>";
										$result_update = mysqli_query($link, "UPDATE $t_edb_case_statuses_district_case_counter SET district_case_counter_number_of_cases_now=$cases_for_status_counter WHERE district_case_counter_id=$get_district_case_counter_id") or die(mysqli_error($link));
									}

									echo"
										</div>
									  </td>
									";

							} // while statuses BEFORE person
							
							// Fetch all district members
							$query = "SELECT district_member_id, district_member_district_id, district_member_district_title, district_member_user_id, district_member_rank, district_member_user_name, district_member_user_alias, district_member_user_first_name, district_member_user_middle_name, district_member_user_last_name, district_member_user_email, district_member_user_image_path, district_member_user_image_file, district_member_user_image_thumb_40, district_member_user_image_thumb_50, district_member_user_image_thumb_60, district_member_user_image_thumb_200, district_member_user_position, district_member_user_department, district_member_user_location, district_member_user_about, district_member_added_datetime, district_member_added_date_saying, district_member_added_by_user_id, district_member_added_by_user_name, district_member_added_by_user_alias, district_member_added_by_user_image FROM $t_edb_districts_members WHERE district_member_district_id=$get_current_district_id AND district_member_show_on_board='1' ORDER BY district_member_user_first_name ASC";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_district_member_id, $get_district_member_district_id, $get_district_member_district_title, $get_district_member_user_id, $get_district_member_rank, $get_district_member_user_name, $get_district_member_user_alias, $get_district_member_user_first_name, $get_district_member_user_middle_name, $get_district_member_user_last_name, $get_district_member_user_email, $get_district_member_user_image_path, $get_district_member_user_image_file, $get_district_member_user_image_thumb_40, $get_district_member_user_image_thumb_50, $get_district_member_user_image_thumb_60, $get_district_member_user_image_thumb_200, $get_district_member_user_position, $get_district_member_user_department, $get_district_member_user_location, $get_district_member_user_about, $get_district_member_added_datetime, $get_district_member_added_date_saying, $get_district_member_added_by_user_id, $get_district_member_added_by_user_name, $get_district_member_added_by_user_alias, $get_district_member_added_by_user_image) = $row;
										
								// Get number of cases 
								$query_counter = "SELECT user_case_counter_id, user_case_counter_number_of_cases_now FROM $t_edb_case_statuses_user_case_counter WHERE user_case_counter_district_id=$get_current_district_id AND user_case_counter_station_id=0 AND user_case_counter_user_id=$get_district_member_user_id";
								$result_counter = mysqli_query($link, $query_counter);
								$row_counter = mysqli_fetch_row($result_counter);
								list($get_user_case_counter_id, $get_user_case_counter_number_of_cases_now) = $row_counter;
								if($get_user_case_counter_id == ""){
									// Create
									mysqli_query($link, "INSERT INTO $t_edb_case_statuses_user_case_counter 
									(user_case_counter_id, user_case_counter_district_id, user_case_counter_station_id, user_case_counter_user_id, user_case_counter_number_of_cases_now) 
									VALUES 
									(NULL, $get_current_district_id, 0, $get_district_member_user_id, 0)")
									or die(mysqli_error($link));
								}	

								echo"
								  <td style=\"width: 290px;vertical-align:top;padding-right:10px;\">
									<!-- District Member $get_district_member_user_name - Statuses and cases -->
										<div class=\"cases_board_status_round_box\">
											<p><b>$get_user_case_counter_number_of_cases_now</b>
											<a href=\"view_profile_and_update_profile_link.php?user_id=$get_district_member_user_id&amp;l=$l&amp;process=1\" style=\"color: black;\">";
											if($get_district_member_user_first_name == ""){
												echo"$get_district_member_user_name";
											}
											else{
												echo"$get_district_member_user_first_name $get_district_member_user_middle_name $get_district_member_user_last_name";
											}
											echo"</a></p>
								";
								// All possible status for this member
								$cases_for_status_counter = 0;
								$query_s = "SELECT status_id, status_title, status_title_clean, status_bg_color, status_border_color, status_text_color, status_link_color, status_weight, status_number_of_cases_now, status_number_of_cases_max, status_show_on_front_page, status_on_given_status_do_close_case, status_on_person_view_show_without_person FROM $t_edb_case_statuses WHERE status_show_on_front_page=1 AND status_on_person_view_show_without_person=0 ORDER BY status_weight ASC";
								$result_s = mysqli_query($link, $query_s);
								while($row_s = mysqli_fetch_row($result_s)) {
									list($get_status_id, $get_status_title, $get_status_title_clean, $get_status_bg_color, $get_status_border_color, $get_status_text_color, $get_status_link_color, $get_status_weight, $get_status_number_of_cases_now, $get_status_number_of_cases_max, $get_status_show_on_front_page, $get_status_on_given_status_do_close_case, $get_status_on_person_view_show_without_person) = $row_s;

									echo"

										<div class=\"cases_status_person_drop_div\" id=\"status_id$get_status_id"; echo"user_id$get_district_member_user_id\">


											<p class=\"cases_status_p\">$get_status_title</p>
											";
											// Fetch all cases that has status + assigned to user
											
											$query_cases = "SELECT $t_edb_case_index.case_id, $t_edb_case_index.case_number, $t_edb_case_index.case_title, $t_edb_case_index.case_code_id, $t_edb_case_index.case_code_title, $t_edb_case_index.case_priority_id, $t_edb_case_index.case_last_event_text, $t_edb_case_index.case_assigned_to_date_saying, $t_edb_case_index.case_assigned_to_date_ddmmyy, $t_edb_case_index.case_assigned_to_user_id, $t_edb_case_index.case_assigned_to_user_name, $t_edb_case_index.case_assigned_to_user_image_path, $t_edb_case_index.case_assigned_to_user_image_file, $t_edb_case_index.case_assigned_to_user_image_thumb_40, $t_edb_case_index.case_assigned_to_user_image_thumb_50, $t_edb_case_index.case_assigned_to_user_first_name, $t_edb_case_index.case_assigned_to_user_middle_name, $t_edb_case_index.case_assigned_to_user_last_name, $t_edb_case_index.case_created_date_saying, $t_edb_case_index.case_created_date_ddmmyy, $t_edb_case_priorities.priority_bg_color, $t_edb_case_priorities.priority_border_color, $t_edb_case_priorities.priority_text_color, $t_edb_case_priorities.priority_link_color FROM $t_edb_case_index JOIN $t_edb_case_priorities ON $t_edb_case_index.case_priority_id=$t_edb_case_priorities.priority_id WHERE $t_edb_case_index.case_status_id=$get_status_id AND $t_edb_case_index.case_district_id=$get_current_district_id AND $t_edb_case_index.case_assigned_to_user_id=$get_district_member_user_id AND $t_edb_case_index.case_confirmed_by_human=1 AND $t_edb_case_index.case_human_rejected=0 AND $t_edb_case_index.case_is_closed=0";
											$result_cases = mysqli_query($link, $query_cases);
											while($row_cases = mysqli_fetch_row($result_cases)) {
												list($get_case_id, $get_case_number, $get_case_title, $get_case_code_id, $get_case_code_title, $get_case_priority_id, $get_case_last_event_text, $get_case_assigned_to_date_saying, $get_case_assigned_to_date_ddmmyy, $get_case_assigned_to_user_id, $get_case_assigned_to_user_name, $get_case_assigned_to_user_image_path, $get_case_assigned_to_user_image_file, $get_case_assigned_to_user_image_thumb_40, $get_case_assigned_to_user_image_thumb_50, $get_case_assigned_to_user_first_name, $get_case_assigned_to_user_middle_name, $get_case_assigned_to_user_last_name, $get_case_created_date_saying, $get_case_created_date_ddmmyy, $get_priority_bg_color, $get_priority_border_color, $get_priority_text_color, $get_priority_link_color) = $row_cases;

												echo"
												<div class=\"cases_board_box_wrapper\" id=\"case_id$get_case_id\">
													<div class=\"cases_board_box_inner\" style=\"border-left: $get_priority_bg_color 4px solid;\">

										

														<p class=\"cases_box_headline_p\"><a href=\"open_case_overview.php?case_id=$get_case_id&amp;l=$l\"  class=\"cases_box_headline_a\" style=\"color: $get_priority_link_color;\">$get_case_number</a></p>

														<p class=\"cases_box_body_p\">
														$get_case_title<br />
														<span class=\"grey\" title=\"$get_case_created_date_saying\">$get_case_created_date_ddmmyy</span>

														<!-- Event -->
														";
														if($get_case_last_event_text != ""){
															echo"<span><br /><br />$get_case_last_event_text</span>";
														}
														echo"
														<!-- Location -->
														</p>
														<div class=\"clear\"></div>
													</div> <!-- //cases_board_box_inner -->
												</div> <!-- //cases_board_box_wrapper -->
												";
												$cases_for_status_counter++;
											} // cases while
										echo"
											</div> <!-- //cases_status_person_drop_div -->
										";
									} // statuses for this user
										
									if($cases_for_status_counter != "$get_user_case_counter_number_of_cases_now"  && $get_user_case_counter_id != ""){
										// echo"<div class=\"info\"><p>Updated number of cases counter</p></div>";
										$result_update = mysqli_query($link, "UPDATE $t_edb_case_statuses_user_case_counter SET user_case_counter_number_of_cases_now=$cases_for_status_counter WHERE user_case_counter_id=$get_user_case_counter_id") or die(mysqli_error($link));
									}


										echo"
										</div> <!-- //cases_board_status_round_box -->
									<!-- //District Member $get_district_member_user_name - Statuses and cases -->
								  </td>
								";
							} // district members (in this comes status)

							// Show all AFTER persons 
							$query = "SELECT status_id, status_title, status_title_clean, status_bg_color, status_border_color, status_text_color, status_link_color, status_weight, status_number_of_cases_now, status_number_of_cases_max, status_show_on_front_page, status_on_given_status_do_close_case, status_on_person_view_show_without_person FROM $t_edb_case_statuses WHERE status_show_on_front_page=1 AND status_on_person_view_show_without_person=1 AND status_on_person_view_show_before_person=0 ORDER BY status_weight ASC";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_status_id, $get_status_title, $get_status_title_clean, $get_status_bg_color, $get_status_border_color, $get_status_text_color, $get_status_link_color, $get_status_weight, $get_status_number_of_cases_now, $get_status_number_of_cases_max, $get_status_show_on_front_page, $get_status_on_given_status_do_close_case, $get_status_on_person_view_show_without_person) = $row;
					
								// Get number of cases for this status on this district
								$query_counter = "SELECT district_case_counter_id, district_case_counter_number_of_cases_now FROM $t_edb_case_statuses_district_case_counter WHERE district_case_counter_district_id=$get_current_district_id AND district_case_counter_status_id=$get_status_id";
								$result_counter = mysqli_query($link, $query_counter);
								$row_counter = mysqli_fetch_row($result_counter);
								list($get_district_case_counter_id, $get_district_case_counter_number_of_cases_now) = $row_counter;

								echo"
								  <td style=\"width: 290px;vertical-align:top;padding-right:10px;\" class=\"cases_status_td\" id=\"status_id$get_status_id\">
									<div class=\"cases_board_status_round_box\">
										<p><b>$get_district_case_counter_number_of_cases_now</b> $get_status_title</p>
								";

							
								$cases_for_status_counter = 0;
								$query_cases = "SELECT $t_edb_case_index.case_id, $t_edb_case_index.case_number, $t_edb_case_index.case_title, $t_edb_case_index.case_code_id, $t_edb_case_index.case_code_title, $t_edb_case_index.case_priority_id, $t_edb_case_index.case_last_event_text, $t_edb_case_index.case_assigned_to_date_saying, $t_edb_case_index.case_assigned_to_date_ddmmyy, $t_edb_case_index.case_assigned_to_user_id, $t_edb_case_index.case_assigned_to_user_name, $t_edb_case_index.case_assigned_to_user_image_path, $t_edb_case_index.case_assigned_to_user_image_file, $t_edb_case_index.case_assigned_to_user_image_thumb_40, $t_edb_case_index.case_assigned_to_user_image_thumb_50, $t_edb_case_index.case_assigned_to_user_first_name, $t_edb_case_index.case_assigned_to_user_middle_name, $t_edb_case_index.case_assigned_to_user_last_name, $t_edb_case_index.case_created_date_saying, $t_edb_case_index.case_created_date_ddmmyy, $t_edb_case_priorities.priority_bg_color, $t_edb_case_priorities.priority_border_color, $t_edb_case_priorities.priority_text_color, $t_edb_case_priorities.priority_link_color FROM $t_edb_case_index JOIN $t_edb_case_priorities ON $t_edb_case_index.case_priority_id=$t_edb_case_priorities.priority_id WHERE $t_edb_case_index.case_status_id=$get_status_id AND $t_edb_case_index.case_district_id=$get_current_district_id AND $t_edb_case_index.case_confirmed_by_human=1 AND $t_edb_case_index.case_human_rejected=0 AND $t_edb_case_index.case_is_closed=0";
								$result_cases = mysqli_query($link, $query_cases);
								while($row_cases = mysqli_fetch_row($result_cases)) {
									list($get_case_id, $get_case_number, $get_case_title, $get_case_code_id, $get_case_code_title, $get_case_priority_id, $get_case_last_event_text, $get_case_assigned_to_date_saying, $get_case_assigned_to_date_ddmmyy, $get_case_assigned_to_user_id, $get_case_assigned_to_user_name, $get_case_assigned_to_user_image_path, $get_case_assigned_to_user_image_file, $get_case_assigned_to_user_image_thumb_40, $get_case_assigned_to_user_image_thumb_50, $get_case_assigned_to_user_first_name, $get_case_assigned_to_user_middle_name, $get_case_assigned_to_user_last_name, $get_case_created_date_saying, $get_case_created_date_ddmmyy, $get_priority_bg_color, $get_priority_border_color, $get_priority_text_color, $get_priority_link_color) = $row_cases;

									echo"
										<div class=\"cases_board_box_wrapper\" id=\"case_id$get_case_id\">
											<div class=\"cases_board_box_inner\" style=\"border-left: $get_priority_bg_color 4px solid;\">

											<!-- Case assigned to -->";
												if($get_case_assigned_to_user_id != "0" && $get_case_assigned_to_user_id != ""){
													echo"
													<div class=\"cases_board_box_inner_assigned_to_div\">
														<p>";
													if(file_exists("$root/$get_case_assigned_to_user_image_path/$get_case_assigned_to_user_image_file") && $get_case_assigned_to_user_image_file != ""){
														// Thumb name
														if($get_case_assigned_to_user_image_thumb_50 == ""){
															// Update thumb name
															$ext = get_extension($get_case_assigned_to_user_image_file);
															$inp_thumb_name = str_replace($ext, "", $get_case_assigned_to_user_image_file);
															$inp_thumb_name = $inp_thumb_name . "_50." . $ext;
															$inp_thumb_name_mysql = quote_smart($link, $inp_thumb_name);
															$result_update = mysqli_query($link, "UPDATE $t_edb_case_index SET case_assigned_to_user_image_thumb_50=$inp_thumb_name_mysql WHERE case_id=$get_case_id") or die(mysqli_error($link));

															// Transfer
															$get_case_assigned_to_user_image_thumb_40 = "$inp_thumb_name";
														}
								
														if(!(file_exists("$root/$get_case_assigned_to_user_image_path/$get_case_assigned_to_user_image_thumb_50"))){
															// Make thumb
															$inp_new_x = 50; // 950
															$inp_new_y = 50; // 640
															resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_case_assigned_to_user_image_path/$get_case_assigned_to_user_image_file", "$root/$get_case_assigned_to_user_image_path/$get_case_assigned_to_user_image_thumb_50");
														}


														echo"
														<a href=\"view_profile_and_update_profile_link.php?user_id=$get_case_assigned_to_user_id&amp;l=$l\"><img src=\"$root/$get_case_assigned_to_user_image_path/$get_case_assigned_to_user_image_thumb_50\" alt=\"$get_case_assigned_to_user_image_thumb_50\" title=\"$get_case_assigned_to_user_name ($get_case_assigned_to_user_first_name $get_case_assigned_to_user_middle_name $get_case_assigned_to_user_last_name)\" /></a><br />
														";
													}
													else{
														echo"
														<a href=\"view_profile_and_update_profile_link.php?user_id=$get_case_assigned_to_user_id&amp;l=$l\"><img src=\"_gfx/avatar_blank_50.png\" alt=\"avatar_blank_50.png\" title=\"$get_case_assigned_to_user_name ($get_case_assigned_to_user_first_name $get_case_assigned_to_user_middle_name $get_case_assigned_to_user_last_name)\" /></a><br />
														";
													}

													// Username saying
													$username_len = strlen($get_case_assigned_to_user_name);
													if($username_len > 6){
														$username_saying = substr($get_case_assigned_to_user_name, 0, 6);
													}
													else{
														$username_saying = "$get_case_assigned_to_user_name";
													}

													echo"
														<a href=\"view_profile_and_update_profile_link.php?user_id=$get_case_assigned_to_user_id&amp;l=$l\" title=\"$get_case_assigned_to_user_name ($get_case_assigned_to_user_first_name $get_case_assigned_to_user_middle_name $get_case_assigned_to_user_last_name)\">$username_saying</a>
														</p>
													</div>
													";
												}
												echo"

											<!-- //Case assigned to -->

											<p class=\"cases_box_headline_p\"><a href=\"open_case_overview.php?case_id=$get_case_id&amp;l=$l\"  class=\"cases_box_headline_a\" style=\"color: $get_priority_link_color;\">$get_case_number</a></p>

											<p class=\"cases_box_body_p\">
												$get_case_title<br />
												<span class=\"grey\" title=\"$get_case_created_date_saying\">$get_case_created_date_ddmmyy</span>

												<!-- Event -->
												";
												if($get_case_last_event_text != ""){
													echo"<span><br /><br />$get_case_last_event_text</span>";
												}
												echo"
												<!-- Location -->
												</p>
												<div class=\"clear\"></div>
											</div> <!-- //cases_board_box_inner -->
										</div> <!-- //cases_board_box_wrapper -->
										";
										$cases_for_status_counter++;
									} // cases while
									if($cases_for_status_counter != "$get_district_case_counter_number_of_cases_now" && $get_district_case_counter_id != ""){
										// echo"<div class=\"info\"><p>Updated number of cases counter</p></div>";
										$result_update = mysqli_query($link, "UPDATE $t_edb_case_statuses_district_case_counter SET district_case_counter_number_of_cases_now=$cases_for_status_counter WHERE district_case_counter_id=$get_district_case_counter_id") or die(mysqli_error($link));
									}

									echo"
										</div>
									  </td>
									";

							} // while statuses AFTER person
							
							echo"
							  </tr>
							 </tbody>
							</table>
						</div>
						";
					} // view method = person
					echo"
				<!-- //Statuses (for district) -->


				<!-- Drag and drop script (for district) -->
					";
					if($get_my_district_member_rank == "admin" OR $get_my_district_member_rank == "moderator" OR $get_my_district_member_rank == "editor"){
						echo"
						<script src=\"$root/_admin/_javascripts/jquery/jquery-ui.js\"></script>
						<script type=\"text/javascript\">
							\$(function () {
								\$( \".cases_board_box_wrapper\" ).draggable();
								\$( \".cases_status_td\" ).droppable({ drop: Drop });
								\$( \".cases_status_person_drop_div\" ).droppable({ drop: Drop });
							});

							function Drop(event, ui) {
								var draggableId = ui.draggable.attr(\"id\");
								var droppableId = \$(this).attr(\"id\");
      								var data            = 'case_id=' + draggableId + '&status_id=' + droppableId;
								\$.ajax({
									type: \"POST\",
               								url: \"cases_board_2_view_station_drag_and_drop_update_status.php\",
                							data: data,
									success: function (data) {
										\$('.status_update_result').html(data);
										window.location.replace(\"cases_board_1_view_district.php?district_id=$get_current_district_id&l=$l\");
									}
								});
							}
						</script>
						";
					}
					echo"
				<!-- //Drag and drop script (for district) -->
				
				<div class=\"status_update_result\"></div>

				<!-- Agent -->
					";
					if($get_current_agent_is_active == "1"){
						echo"
						<iframe src=\"agent.php?process=1&amp;l=$l\" height=\"60\" width=\"100%\"></iframe>
						";
					}
					echo"
				<!-- //Agent -->
				";

				// Remember home page
				$query = "SELECT user_remember_id, user_remember_user_id, user_remember_district_id, user_remember_district_title, user_remember_station_id, user_remember_station_title FROM $t_edb_home_page_user_remember WHERE user_remember_user_id=$my_user_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_user_remember_id, $get_current_user_remember_user_id, $get_current_user_remember_district_id, $get_current_user_remember_district_title, $get_current_user_remember_station_id, $get_current_user_remember_station_title) = $row;
				$inp_district_title_mysql = quote_smart($link, $get_current_district_title);
				if($get_current_user_remember_id == ""){
					mysqli_query($link, "INSERT INTO $t_edb_home_page_user_remember 
					(user_remember_id, user_remember_user_id, user_remember_district_id, user_remember_district_title) 
					VALUES 
					(NULL, $my_user_id_mysql, $get_current_district_id, $inp_district_title_mysql)") or die(mysqli_error($link));	
				}
				else{
					$result = mysqli_query($link, "UPDATE $t_edb_home_page_user_remember SET 
									user_remember_district_id=$get_current_district_id, user_remember_district_title=$inp_district_title_mysql,
									user_remember_station_id=NULL, user_remember_station_title=NULL
								 WHERE user_remember_id=$get_current_user_remember_id");
				}
			} // action == ""
		} // access to district 
	} // district found

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