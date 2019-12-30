<?php 
/**
*
* File: edb/tasks.php
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
include("$root/_admin/_translations/site/$l/edb/ts_cases_board_1_view_district.php");
include("$root/_admin/_translations/site/$l/edb/ts_open_case_human_tasks.php");
include("$root/_admin/_translations/site/$l/edb/ts_open_case_overview.php");

include("$root/_admin/_translations/site/$l/users/ts_users.php");


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

if(isset($_GET['user_id'])) {
	$user_id = $_GET['user_id'];
	$user_id = strip_tags(stripslashes($user_id));
}
else{
	$user_id = "";
}
$user_id_mysql = quote_smart($link, $user_id);

if(isset($_GET['priority_id'])) {
	$priority_id = $_GET['priority_id'];
	$priority_id = strip_tags(stripslashes($priority_id));
}
else{
	$priority_id = "";
}
$priority_id_mysql = quote_smart($link, $priority_id);

if(isset($_GET['without_status'])) {
	$without_status = $_GET['without_status'];
	$without_status = strip_tags(stripslashes($without_status));
}
else{
	$without_status = "0";
}
$without_status_mysql = quote_smart($link, $without_status);



if(isset($_GET['finished'])) {
	$finished = $_GET['finished'];
	$finished = strip_tags(stripslashes($finished));
}
else{
	$finished = "";
}

if(isset($_GET['order_by'])) {
	$order_by = $_GET['order_by'];
	$order_by = strip_tags(stripslashes($order_by));
}
else{
	$order_by = "";
}
if(isset($_GET['order_method'])) {
	$order_method = $_GET['order_method'];
	$order_method = strip_tags(stripslashes($order_method));
	if($order_method != "asc" && $order_method != "desc"){
		echo"Wrong order method";
		die;
	}
}
else{
	$order_method = "asc";
}



/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){

	// Me
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);

	$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_language, $get_my_user_last_online, $get_my_user_rank, $get_my_user_login_tries) = $row;
		
	

	// Find district
	if($district_id != "") {
		$query = "SELECT district_id, district_number, district_title, district_title_clean, district_icon_path, district_icon_16, district_icon_32, district_icon_260, district_number_of_stations, district_number_of_cases_now FROM $t_edb_districts_index WHERE district_id=$district_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_district_id, $get_current_district_number, $get_current_district_title, $get_current_district_title_clean, $get_current_district_icon_path, $get_current_district_icon_16, $get_current_district_icon_32, $get_current_district_icon_260, $get_current_district_number_of_stations, $get_current_district_number_of_cases_now) = $row;
	
		if($get_current_district_id == ""){
			echo"<h1>Server error 404</h1><p>District not found</p>";
			die;
		}
		else{
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
				die;
			} // access to district denied
		}
	}


	// Find station
	if($station_id != "") {
		$query = "SELECT station_id, station_number, station_title, station_title_clean, station_district_id, station_district_title, station_icon_path, station_icon_16, station_icon_32, station_icon_260, station_number_of_cases_now FROM $t_edb_stations_index WHERE station_id=$station_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_station_id, $get_current_station_number, $get_current_station_title, $get_current_station_title_clean, $get_current_station_district_id, $get_current_station_district_title, $get_current_station_icon_path, $get_current_station_icon_16, $get_current_station_icon_32, $get_current_station_icon_260, $get_current_station_number_of_cases_now) = $row;
	
		if($get_current_station_id == ""){
			echo"<h1>Server error 404</h1><p>Station not found</p>";
			die;
		}
		else{
			// Check that I am member of this station
			$query = "SELECT station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60, station_member_user_image_thumb_200, station_member_user_position, station_member_user_department, station_member_user_location, station_member_user_about, station_member_added_datetime, station_member_added_date_saying, station_member_added_by_user_id, station_member_added_by_user_name, station_member_added_by_user_alias, station_member_added_by_user_image FROM $t_edb_stations_members WHERE station_member_user_id=$my_user_id_mysql AND station_member_station_id=$get_current_station_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_my_station_member_id, $get_my_station_member_station_id, $get_my_station_member_station_title, $get_my_station_member_district_id, $get_my_station_member_district_title, $get_my_station_member_user_id, $get_my_station_member_rank, $get_my_station_member_user_name, $get_my_station_member_user_alias, $get_my_station_member_first_name, $get_my_station_member_middle_name, $get_my_station_member_last_name, $get_my_station_member_user_email, $get_my_station_member_user_image_path, $get_my_station_member_user_image_file, $get_my_station_member_user_image_thumb_40, $get_my_station_member_user_image_thumb_50, $get_my_station_member_user_image_thumb_60, $get_my_station_member_user_image_thumb_200, $get_my_station_member_user_position, $get_my_station_member_user_department, $get_my_station_member_user_location, $get_my_station_member_user_about, $get_my_station_member_added_datetime, $get_my_station_member_added_date_saying, $get_my_station_member_added_by_user_id, $get_my_station_member_added_by_user_name, $get_my_station_member_added_by_user_alias, $get_my_station_member_added_by_user_image) = $row;

			if($get_my_station_member_id == ""){
				echo"
				<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> Please apply for access to this station..</h1>
				<meta http-equiv=\"refresh\" content=\"3;url=browse_districts_and_stations.php?action=apply_for_membership_to_station&amp;station_id=$get_current_station_id&amp;l=$l\">
				";
				die;
			} // access to station denied
		}
	}

	// We need either district rank or station rank. If we have none, then use user rank
	if(!(isset($get_my_station_member_rank))){
		// Transfer
		$get_my_station_member_rank = "$get_my_user_rank";			
	}

	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "$l_edb - $l_tasks";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");


	if($action == ""){
		echo"
		<!-- Headline -->
			<h1>$l_tasks</h1>
		<!-- //Headline -->

		<!-- Where am I? -->
			<p><b>$l_you_are_here:</b><br />
			<a href=\"index.php?l=$l\">$l_edb</a>
			&gt;";
			
			// District
			if(isset($get_current_district_id)){
				echo"
				<a href=\"cases_board_1_view_district.php?district_id=$get_current_district_id&amp;l=$l\">$get_current_district_title</a>
				&gt;
				";
			}
			else{	
				if(isset($get_current_station_district_id)){
					echo"
					<a href=\"cases_board_1_view_district.php?district_id=$get_current_station_district_id&amp;l=$l\">$get_current_station_district_title</a>
					&gt;
					";
				}
			}

			// Station
			if(isset($get_current_station_id)){
				echo"
				<a href=\"cases_board_2_view_station.php?station_id=$get_current_station_id&amp;l=$l\">$get_current_station_title</a>
				&gt;
				";
			}
			echo"
			<a href=\"tasks.php?l=$l\">$l_tasks</a>
			</p>
		<!-- //Where am I? -->


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
		
		<!-- Filters -->
			<form>
			<p>";
			if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
				echo"
				<a href=\"tasks.php?action=new_task&amp;district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;without_status=$without_status&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\" class=\"btn_default\">$l_new_task</a>
				
				";
			}
			echo"
			<!-- Districts -->
				<select name=\"district\" class=\"on_change_go_to_url\">
					<option value=\"tasks.php?station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;without_status=$without_status&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\">- $l_district -</option>\n";
					$query = "SELECT district_member_id, district_member_district_id, district_member_district_title FROM $t_edb_districts_members WHERE district_member_user_id='$my_user_id_mysql' ORDER BY district_member_district_title ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_district_member_id, $get_district_member_district_id, $get_district_member_district_title) = $row;
						echo"								";
						echo"<option value=\"tasks.php?district_id=$get_district_member_district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;without_status=$without_status&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\""; if($get_district_member_district_id == "$district_id"){ echo" selected=\"selected\""; } echo">$get_district_member_district_title</option>\n";
					}
				echo"
				</select>

				<select name=\"station\" class=\"on_change_go_to_url\">
					<option value=\"tasks.php?district_id=$district_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$order_by&amp;without_status=$without_status&amp;order_method=$order_method&amp;l=$l\">- $l_station -</option>\n";
					$query_sub = "SELECT station_member_id, station_member_station_id, station_member_station_title FROM $t_edb_stations_members WHERE station_member_user_id='$my_user_id_mysql'  ORDER BY station_member_station_title ASC";
					$result_sub = mysqli_query($link, $query_sub);
					while($row_sub = mysqli_fetch_row($result_sub)) {
						list($get_station_member_id, $get_station_member_station_id, $get_station_member_station_title) = $row_sub;

						echo"								";
						echo"<option value=\"tasks.php?district_id=$district_id&amp;station_id=$get_station_member_station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;without_status=$without_status&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\""; if($get_station_member_station_id == "$station_id"){ echo" selected=\"selected\""; } echo">$get_station_member_station_title</option>\n";
					}
				echo"
				</select>

				<select name=\"priorities\" class=\"on_change_go_to_url\">
					<option value=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;finished=$finished&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\">- $l_priority -</option>\n";
					$query = "SELECT priority_id, priority_title, priority_title_clean, priority_bg_color, priority_border_color, priority_text_color, priority_link_color, priority_weight, priority_number_of_cases_now FROM $t_edb_case_priorities ORDER BY priority_weight ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_priority_id, $get_priority_title, $get_priority_title_clean, $get_priority_bg_color, $get_priority_border_color, $get_priority_text_color, $get_priority_link_color, $get_priority_weight, $get_priority_number_of_cases_now) = $row;
			
						echo"								";
						echo"<option value=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$get_priority_id&amp;finished=$finished&amp;without_status=$without_status&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\""; if($get_priority_id == "$priority_id"){ echo" selected=\"selected\""; } echo">$get_priority_title</option>\n";
					}
				echo"
				</select>

				<select name=\"responsible\" class=\"on_change_go_to_url\">
					<option value=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;without_status=$without_status&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\">- $l_responsible -</option>
					<option value=\"tasks.php?action=generate_responsible&amp;district_id=$district_id&amp;station_id=$get_station_member_station_id&amp;user_id=$user_id&amp;priority_id=$get_priority_id&amp;without_status=$without_status&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l&amp;process=1\">($l_generate)</option>\n";
					$query = "SELECT counter_id, counter_user_id, counter_user_name, counter_user_alias, counter_user_email, counter_user_image_path, counter_user_image_file, counter_user_image_thumb_40, counter_user_image_thumb_50, counter_user_first_name, counter_user_middle_name, counter_user_last_name, counter_number_of_tasks FROM $t_edb_case_index_human_tasks_responsible_counters ORDER BY counter_user_first_name ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_counter_id, $get_counter_user_id, $get_counter_user_name, $get_counter_user_alias, $get_counter_user_email, $get_counter_user_image_path, $get_counter_user_image_file, $get_counter_user_image_thumb_40, $get_counter_user_image_thumb_50, $get_counter_user_first_name, $get_counter_user_middle_name, $get_counter_user_last_name, $get_counter_number_of_tasks) = $row;

						echo"								";
						echo"<option value=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$get_counter_user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;without_status=$without_status&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\""; if($get_counter_user_id == "$user_id"){ echo" selected=\"selected\""; } echo">";

						if($get_counter_user_first_name == ""){
							echo"$get_counter_user_name";
						}
						else{
							echo"$get_counter_user_first_name $get_counter_user_middle_name $get_counter_user_last_name";
						}
						echo" ($get_counter_number_of_tasks)</option>\n";
					}
				echo"
				</select>

				<select name=\"finished\" class=\"on_change_go_to_url\">
					<option value=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;without_status=$without_status&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\">- $l_finished -</option>
					<option value=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=1&amp;without_status=$without_status&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\""; if($finished == "1"){ echo" selected=\"selected\""; } echo">$l_yes</option>
					<option value=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=0&amp;without_status=$without_status&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\""; if($finished == "0"){ echo" selected=\"selected\""; } echo">$l_no</option>
				</select>

				<input type=\"checkbox\" name=\"without_status\" class=\"on_check_checkbox_go_to_url\" data-target=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=0&amp;without_status="; if($without_status == "0"){ echo"1"; } else{ echo"0"; } echo"&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\" "; if($without_status == "1"){ echo" checked=\"checked\""; } echo" /> $l_show_without_status
					
			</p>

					
			</form>

			<!-- On change go to URL -->
				<script>
				\$(function(){
					// bind change event to select
					\$('.on_change_go_to_url').on('change', function () {
						var url = \$(this).val(); // get selected value
						if (url) { // require a URL
							window.location = url; // redirect
						}
						return false;
					});
				});
				</script>
			<!-- //On change go to URL -->


			<!-- On check checkbox go to URL -->
				<script>
				\$(function(){
					\$(\".on_check_checkbox_go_to_url\").change(function(){
						var item=\$(this);    
						window.location.href= item.data(\"target\")
					});
				});
				</script>
			<!-- //On check checkbox go to URL  -->
		<!-- //Filters -->


		<!-- List of all human tasks -->
			<div style=\"height: 10px;\"></div>

			<table class=\"hor-zebra\">
			 <thead>
			  <tr>
			   <th scope=\"col\">
				";
				$th_order_by = "human_task_case_number";
				$th_title    = "$l_case";
						
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
				if($order_by == "$th_order_by" && $order_method == "asc"){
					echo"<img src=\"_gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
				}
				if($order_by == "$th_order_by" && $order_method == "desc"){
					echo"<img src=\"_gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
				}
				echo"</span>
			   </th>
			   <th scope=\"col\">
				";
				$th_order_by = "human_task_text";
				$th_title    = "$l_task";
						
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
				if($order_by == "$th_order_by" && $order_method == "asc"){
					echo"<img src=\"_gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
				}
				if($order_by == "$th_order_by" && $order_method == "desc"){
					echo"<img src=\"_gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
				}
				echo"</span>
			   </th>
			   <th scope=\"col\">
				";
				$th_order_by = "human_task_created_datetime";
				$th_title    = "$l_created";
						
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
				if($order_by == "$th_order_by" && $order_method == "asc"){
					echo"<img src=\"_gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
				}
				if($order_by == "$th_order_by" && $order_method == "desc"){
					echo"<img src=\"_gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
				}
				echo"</span>
			   </th>
			   <th scope=\"col\">
				";
				$th_order_by = "human_task_priority_id";
				$th_title    = "$l_priority";
						
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
				if($order_by == "$th_order_by" && $order_method == "asc"){
					echo"<img src=\"_gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
				}
				if($order_by == "$th_order_by" && $order_method == "desc"){
					echo"<img src=\"_gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
				}
				echo"</span>
			   </th>
			   <th scope=\"col\">
				";
				$th_order_by = "human_task_deadline_date";
				$th_title    = "$l_deadline";
						
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
				if($order_by == "$th_order_by" && $order_method == "asc"){
					echo"<img src=\"_gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
				}
				if($order_by == "$th_order_by" && $order_method == "desc"){
					echo"<img src=\"_gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
				}
				echo"</span>
			   </th>
			   <th scope=\"col\">
				";
				$th_order_by = "human_task_finished_datetime";
				$th_title    = "$l_finished";
						
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
				if($order_by == "$th_order_by" && $order_method == "asc"){
					echo"<img src=\"_gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
				}
				if($order_by == "$th_order_by" && $order_method == "desc"){
					echo"<img src=\"_gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
				}
				echo"</span>
			   </th>
			   <th scope=\"col\">
				";
				$th_order_by = "human_task_created_by_user_first_name";
				$th_title    = "$l_responsible";
						
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
				if($order_by == "$th_order_by" && $order_method == "asc"){
					echo"<img src=\"_gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
				}
				if($order_by == "$th_order_by" && $order_method == "desc"){
					echo"<img src=\"_gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
				}
				echo"</span>
			   </th>
			   <th scope=\"col\">
				";
				$th_order_by = "human_task_district_title";
				$th_title    = "$l_district";
						
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
				if($order_by == "$th_order_by" && $order_method == "asc"){
					echo"<img src=\"_gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
				}
				if($order_by == "$th_order_by" && $order_method == "desc"){
					echo"<img src=\"_gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
				}
				echo"</span>
			   </th>
			   <th scope=\"col\">
				";
				$th_order_by = "human_task_station_title";
				$th_title    = "$l_station";
						
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
				if($order_by == "$th_order_by" && $order_method == "asc"){
					echo"<img src=\"_gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
				}
				if($order_by == "$th_order_by" && $order_method == "desc"){
					echo"<img src=\"_gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
				}
				echo"</span>
			   </th>
			   <th scope=\"col\">
				<span>$l_actions</span>
			   </th>
			  </tr>
			 </thead>
			 <tbody>
			";
		
			$week = date("W");
			$year = date("Y");
			$counter_human_tasks_total = 0;
			$counter_human_tasks_completed = 0;
			$query = "SELECT human_task_id, human_task_case_id, human_task_case_number, human_task_evidence_record_id, human_task_evidence_item_id, human_task_district_id, human_task_district_title, human_task_station_id, human_task_station_title, human_task_text, human_task_priority_id, human_task_priority_title, human_task_created_datetime, human_task_created_date, human_task_created_time, human_task_created_date_saying, human_task_created_date_ddmmyy, human_task_created_date_ddmmyyyy, human_task_deadline_date, human_task_deadline_time, human_task_deadline_date_saying, human_task_deadline_date_ddmmyy, human_task_deadline_date_ddmmyyyy, human_task_deadline_week, human_task_deadline_year, human_task_is_finished, human_task_finished_datetime, human_task_finished_date, human_task_finished_time, human_task_finished_date_saying, human_task_finished_date_ddmmyy, human_task_finished_date_ddmmyyyy, human_task_created_by_user_id, human_task_created_by_user_name, human_task_created_by_user_alias, human_task_created_by_user_email, human_task_created_by_user_image_path, human_task_created_by_user_image_file, human_task_created_by_user_image_thumb_40, human_task_created_by_user_image_thumb_50, human_task_created_by_user_first_name, human_task_created_by_user_middle_name, human_task_created_by_user_last_name, human_task_responsible_user_id, human_task_responsible_user_name, human_task_responsible_user_alias, human_task_responsible_user_email, human_task_responsible_user_image_path, human_task_responsible_user_image_file, human_task_responsible_user_image_thumb_40, human_task_responsible_user_image_thumb_50, human_task_responsible_user_first_name, human_task_responsible_user_middle_name, human_task_responsible_user_last_name FROM $t_edb_case_index_human_tasks";

			if($district_id != "" OR $station_id != "" OR $priority_id != "" OR $user_id != "" OR $finished != ""){
				$query = $query . "  WHERE ";
				$and = "0";
				if($district_id != ""){
					$query = $query . " human_task_district_id=$district_id_mysql";
					$and = "1";
				}
				if($station_id != ""){
					if($and == "1"){
						$query = $query . " AND ";
					}
					$query = $query . " human_task_station_id=$station_id_mysql";
					$and = "1";
				}
				if($priority_id != ""){
					if($and == "1"){
						$query = $query . " AND ";
					}
					$query = $query . " human_task_priority_id <= $priority_id_mysql";
					$and = "1";
				}
				if($user_id != ""){
					if($and == "1"){
						$query = $query . " AND ";
					}
					$query = $query . " human_task_responsible_user_id=$user_id_mysql";
					$and = "1";
				}
				if($finished != ""){
					if($and == "1"){
						$query = $query . " AND ";
					}
					if($finished == "1" OR $finished == "0"){
						$query = $query . " human_task_is_finished=$finished";
						$and = "1";
					}
				}
				if($without_status == "0"){
					if($and == "1"){
						$query = $query . " AND ";
					}
					$query = $query . " human_task_priority_id != 0";
					$and = "1";

				}
			}

			if($order_by == "human_task_case_number" OR $order_by == "human_task_text" OR $order_by == "human_task_created_datetime" OR $order_by == "human_task_priority_id" OR $order_by == "human_task_deadline_date" OR $order_by == "human_task_finished_datetime" OR $order_by == "human_task_created_by_user_first_name"){
				if($order_method == "asc" OR $order_method == "desc"){
					$query = $query . " ORDER BY $order_by $order_method";
				}
			}
			else{
				$query = $query . " ORDER BY human_task_id ASC";
			}
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_human_task_id, $get_human_task_case_id, $get_human_task_case_number, $get_human_task_evidence_record_id, $get_human_task_evidence_item_id, $get_human_task_district_id, $get_human_task_district_title, $get_human_task_station_id, $get_human_task_station_title, $get_human_task_text, $get_human_task_priority_id, $get_human_task_priority_title, $get_human_task_created_datetime, $get_human_task_created_date, $get_human_task_created_time, $get_human_task_created_date_saying, $get_human_task_created_date_ddmmyy, $get_human_task_created_date_ddmmyyyy, $get_human_task_deadline_date, $get_human_task_deadline_time, $get_human_task_deadline_date_saying, $get_human_task_deadline_date_ddmmyy, $get_human_task_deadline_date_ddmmyyyy, $get_human_task_deadline_week, $get_human_task_deadline_year, $get_human_task_is_finished, $get_human_task_finished_datetime, $get_human_task_finished_date, $get_human_task_finished_time, $get_human_task_finished_date_saying, $get_human_task_finished_date_ddmmyy, $get_human_task_finished_date_ddmmyyyy, $get_human_task_created_by_user_id, $get_human_task_created_by_user_name, $get_human_task_created_by_user_alias, $get_human_task_created_by_user_email, $get_human_task_created_by_user_image_path, $get_human_task_created_by_user_image_file, $get_human_task_created_by_user_image_thumb_40, $get_human_task_created_by_user_image_thumb_50, $get_human_task_created_by_user_first_name, $get_human_task_created_by_user_middle_name, $get_human_task_created_by_user_last_name, $get_human_task_responsible_user_id, $get_human_task_responsible_user_name, $get_human_task_responsible_user_alias, $get_human_task_responsible_user_email, $get_human_task_responsible_user_image_path, $get_human_task_responsible_user_image_file, $get_human_task_responsible_user_image_thumb_40, $get_human_task_responsible_user_image_thumb_50, $get_human_task_responsible_user_first_name, $get_human_task_responsible_user_middle_name, $get_human_task_responsible_user_last_name) = $row;

				// Style
				if(isset($style) && $style == ""){
					$style = "odd";
				}
				else{
					$style = "";
				}
				if($week == "$get_human_task_deadline_week" && $get_human_task_is_finished != "1"){
					if($year == "$get_human_task_deadline_year"){
						$style = "important";
					}
				}
				elseif($week > "$get_human_task_deadline_week" && $get_human_task_is_finished != "1"){
					if($year > "$get_human_task_deadline_year"){
						$style = "danger";
					}
				}
				
				echo"
				<tr>
				  <td class=\"$style\">
					<span><a href=\"open_case_overview.php?case_id=$get_human_task_case_id&amp;l=$l\">$get_human_task_case_number</a></span>
				  </td>
				  <td class=\"$style\">
					<span>$get_human_task_text</span>
				  </td>
				  <td class=\"$style\">
					<span>$get_human_task_created_date_ddmmyy</span>
				  </td>
				  <td class=\"$style\">
					<span><a href=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$get_human_task_priority_id&amp;finished=$finished&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\">$get_human_task_priority_title</a></span>
				  </td>
				  <td class=\"$style\">
					<span>$get_human_task_deadline_date_ddmmyy</span>
				  </td>
				  <td class=\"$style\">
					<span>";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						if($get_human_task_is_finished == "" OR $get_human_task_is_finished == "0"){
							echo"<a href=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$order_by&amp;order_method=$order_method&amp;case_id=$get_human_task_case_id&amp;action=set_task_finished&amp;human_task_id=$get_human_task_id&amp;l=$l&amp;process=1\"><img src=\"_gfx/tick_grey.png\" alt=\"tick_grey.png\" /></a>";
						}
						else{
							echo"<a href=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$order_by&amp;order_method=$order_method&amp;case_id=$get_human_task_case_id&amp;action=set_task_unfinished&amp;human_task_id=$get_human_task_id&amp;l=$l&amp;process=1\"><img src=\"_gfx/tick.png\" alt=\"tick.png\" /></a> $get_human_task_finished_date_ddmmyy";
						}
					}
					else{
						if($get_human_task_is_finished == "1"){
							echo"<img src=\"_gfx/tick.png\" alt=\"tick.png\" /> $get_human_task_finished_date_ddmmyy";
						}
					}
					echo"
					</span>
				  </td>
				  <td class=\"$style\">
					<a href=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$get_human_task_responsible_user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\" title=\"$get_human_task_responsible_user_first_name $get_human_task_responsible_user_middle_name $get_human_task_responsible_user_last_name\">$get_human_task_responsible_user_name</a>
				  </td>
				  <td class=\"$style\">
					<a href=\"tasks.php?district_id=$get_human_task_district_id&amp;station_id=$station_id&amp;user_id=$get_human_task_responsible_user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\">$get_human_task_district_title</a>
				  </td>
				  <td class=\"$style\">
					<a href=\"tasks.php?district_id=$district_id&amp;station_id=$get_human_task_station_id&amp;user_id=$get_human_task_responsible_user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\">$get_human_task_station_title</a>
				  </td>
				  <td class=\"$style\">
					<span>";
					if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
						echo"<a href=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$order_by&amp;order_method=$order_method&amp;action=edit_task&amp;human_task_id=$get_human_task_id&amp;l=$l\">$l_edit</a>
						&middot;
						<a href=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$order_by&amp;order_method=$order_method&amp;action=delete_task&amp;human_task_id=$get_human_task_id&amp;l=$l\">$l_delete</a>
						";
					}
					echo"</span>
				 </td>
				</tr>
				";
			} // while human tasks
			echo"
			 </tbody>
			</table>
		<!-- List of all human tasks -->
		";
	} // action == ""
	elseif($action == "edit_task" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor")){
		if(isset($_GET['human_task_id'])) {
			$human_task_id = $_GET['human_task_id'];
			$human_task_id = strip_tags(stripslashes($human_task_id));
		}
		else{
			$human_task_id = "";
		}
		$human_task_id_mysql = quote_smart($link, $human_task_id);

		// Find human task
		$query = "SELECT human_task_id, human_task_case_id, human_task_evidence_record_id, human_task_evidence_item_id, human_task_text, human_task_priority_id, human_task_priority_title, human_task_created_datetime, human_task_created_time, human_task_created_date_saying, human_task_created_date_ddmmyy, human_task_deadline_date, human_task_deadline_time, human_task_deadline_date_saying, human_task_deadline_date_ddmmyy, human_task_sent_deadline_notification, human_task_is_finished, human_task_finished_datetime, human_task_finished_time, human_task_finished_date_saying, human_task_finished_date_ddmmyy, human_task_created_by_user_id, human_task_created_by_user_name, human_task_created_by_user_alias, human_task_created_by_user_email, human_task_created_by_user_image_path, human_task_created_by_user_image_file, human_task_created_by_user_image_thumb_40, human_task_created_by_user_image_thumb_50, human_task_created_by_user_first_name, human_task_created_by_user_middle_name, human_task_created_by_user_last_name, human_task_responsible_user_id, human_task_responsible_user_name, human_task_responsible_user_alias, human_task_responsible_user_email, human_task_responsible_user_image_path, human_task_responsible_user_image_file, human_task_responsible_user_image_thumb_40, human_task_responsible_user_image_thumb_50, human_task_responsible_user_first_name, human_task_responsible_user_middle_name, human_task_responsible_user_last_name
 FROM $t_edb_case_index_human_tasks WHERE human_task_id=$human_task_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_human_task_id, $get_current_human_task_case_id, $get_current_human_task_evidence_record_id, $get_current_human_task_evidence_item_id, $get_current_human_task_text, $get_current_human_task_priority_id, $get_current_human_task_priority_title, $get_current_human_task_created_datetime, $get_current_human_task_created_time, $get_current_human_task_created_date_saying, $get_current_human_task_created_date_ddmmyy, $get_current_human_task_deadline_date, $get_current_human_task_deadline_time, $get_current_human_task_deadline_date_saying, $get_current_human_task_deadline_date_ddmmyy, $get_current_human_task_sent_deadline_notification, $get_current_human_task_is_finished, $get_current_human_task_finished_datetime, $get_current_human_task_finished_time, $get_current_human_task_finished_date_saying, $get_current_human_task_finished_date_ddmmyy, $get_current_human_task_created_by_user_id, $get_current_human_task_created_by_user_name, $get_current_human_task_created_by_user_alias, $get_current_human_task_created_by_user_email, $get_current_human_task_created_by_user_image_path, $get_current_human_task_created_by_user_image_file, $get_current_human_task_created_by_user_image_thumb_40, $get_current_human_task_created_by_user_image_thumb_50, $get_current_human_task_created_by_user_first_name, $get_current_human_task_created_by_user_middle_name, $get_current_human_task_created_by_user_last_name, $get_current_human_task_responsible_user_id, $get_current_human_task_responsible_user_name, $get_current_human_task_responsible_user_alias, $get_current_human_task_responsible_user_email, $get_current_human_task_responsible_user_image_path, $get_current_human_task_responsible_user_image_file, $get_current_human_task_responsible_user_image_thumb_40, $get_current_human_task_responsible_user_image_thumb_50, $get_current_human_task_responsible_user_first_name, $get_current_human_task_responsible_user_middle_name, $get_current_human_task_responsible_user_last_name) = $row;
		
		if($get_current_human_task_id == ""){
			echo"
			<h2>Human task not found</h2>
			<p><a href=\"open_case_human_tasks.php?case_id=$get_current_case_id&amp;l=$l\">Human tasks</a></p>
			";
		}
		else{
			if($process == "1"){
				$inp_text = $_POST['inp_text'];
				$inp_text = output_html($inp_text);
				$inp_text_mysql = quote_smart($link, $inp_text);

				$inp_is_finished = $_POST['inp_is_finished'];
				$inp_is_finished = output_html($inp_is_finished);
				$inp_is_finished_mysql = quote_smart($link, $inp_is_finished);
	
				$inp_deadline_date = $_POST['inp_deadline_date'];
				$inp_deadline_date_mysql = quote_smart($link, $inp_deadline_date);

				$inp_deadline_year = substr($inp_deadline_date, 0, 4);
				$inp_deadline_month = substr($inp_deadline_date, 5, 2);
				$inp_deadline_day = substr($inp_deadline_date, 8, 4);

				$inp_deadline_time = strtotime($inp_deadline_date);
				$inp_deadline_time_mysql = quote_smart($link, $inp_deadline_time);

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
				$inp_deadline_day_saying = str_replace("0", "", $inp_deadline_day);
				$inp_deadline_month_saying = str_replace("0", "", $inp_deadline_month);
				
				$inp_deadline_date_saying  = $inp_deadline_day . ". " . $l_month_array[$inp_deadline_month_saying] . " " . $inp_deadline_year;
				$inp_deadline_date_saying_mysql = quote_smart($link, $inp_deadline_date_saying);

				$inp_deadline_date_ddmmyy = $inp_deadline_day . "." . $inp_deadline_month . "." . substr($inp_deadline_year, 2, 2);
				$inp_deadline_date_ddmmyy_mysql = quote_smart($link, $inp_deadline_date_ddmmyy);

				$inp_deadline_date_ddmmyyyy = $inp_deadline_day . "." . $inp_deadline_month . "." . $inp_deadline_year;
				$inp_deadline_date_ddmmyyyy_mysql = quote_smart($link, $inp_deadline_date_ddmmyyyy);

				// Deadline week
				$inp_deadline_week = date("W", $inp_deadline_time);
				$inp_deadline_week_mysql = quote_smart($link, $inp_deadline_week);

				$inp_deadline_year = date("Y", $inp_deadline_time);
				$inp_deadline_year_mysql = quote_smart($link, $inp_deadline_year);

				$inp_responsible = $_POST['inp_responsible'];
				$inp_responsible = output_html($inp_responsible);
				$inp_responsible_mysql = quote_smart($link, $inp_responsible);

				// Find responsible
				$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_name=$inp_responsible_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_responsible_user_id, $get_responsible_user_email, $get_responsible_user_name, $get_responsible_user_alias, $get_responsible_user_language, $get_responsible_user_last_online, $get_responsible_user_rank, $get_responsible_user_login_tries) = $row;
					
				// Responsible photo
				$query = "SELECT photo_id, photo_destination, photo_thumb_40, photo_thumb_50 FROM $t_users_profile_photo WHERE photo_user_id=$my_user_id_mysql AND photo_profile_image='1'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_responsible_photo_id, $get_responsible_photo_destination, $get_responsible_photo_thumb_40, $get_responsible_photo_thumb_50) = $row;

				// Responsible Profile
				$query = "SELECT profile_id, profile_first_name, profile_middle_name, profile_last_name, profile_about FROM $t_users_profile WHERE profile_user_id=$my_user_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_responsible_profile_id, $get_responsible_profile_first_name, $get_responsible_profile_middle_name, $get_responsible_profile_last_name, $get_responsible_profile_about) = $row;

				$inp_responsible_user_name_mysql = quote_smart($link, $get_responsible_user_name);
				$inp_responsible_user_alias_mysql = quote_smart($link, $get_responsible_user_alias);
				$inp_responsible_user_email_mysql = quote_smart($link, $get_responsible_user_email);

				$inp_responsible_user_image_path = "_uploads/users/images/$get_responsible_user_id";
				$inp_responsible_user_image_path_mysql = quote_smart($link, $inp_responsible_user_image_path);

				$inp_responsible_user_image_file_mysql = quote_smart($link, $get_responsible_photo_destination);

				$inp_responsible_user_image_thumb_a_mysql = quote_smart($link, $get_responsible_photo_thumb_40);
				$inp_responsible_user_image_thumb_b_mysql = quote_smart($link, $get_responsible_photo_thumb_50);

				$inp_responsible_user_first_name_mysql = quote_smart($link, $get_responsible_profile_first_name);
				$inp_responsible_user_middle_name_mysql = quote_smart($link, $get_responsible_profile_middle_name);
				$inp_responsible_user_last_name_mysql = quote_smart($link, $get_responsible_profile_last_name);


				// Dates
				$inp_datetime = date("Y-m-d H:i:s");
				$inp_time = time();
				$inp_date_saying = date("j M Y");
				$inp_date_ddmmyy = date("d.m.y");
				$inp_date_ddmmyyyy = date("d.m.Y");
				


				// Priority
				$inp_priority_id = $_POST['inp_priority_id'];
				$inp_priority_id = output_html($inp_priority_id);
				$inp_priority_id_mysql = quote_smart($link, $inp_priority_id);

				$query = "SELECT priority_id, priority_title, priority_title_clean, priority_bg_color, priority_border_color, priority_text_color, priority_link_color, priority_weight, priority_number_of_cases_now, priority_last_used_datetime, priority_last_used_time, priority_times_used FROM $t_edb_case_priorities WHERE priority_id=$inp_priority_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_priority_id, $get_priority_title, $get_priority_title_clean, $get_priority_bg_color, $get_priority_border_color, $get_priority_text_color, $get_priority_link_color, $get_priority_weight, $get_priority_number_of_cases_now, $get_priority_last_used_datetime, $get_priority_last_used_time, $get_priority_times_used) = $row;
				$inp_priority_title_mysql = quote_smart($link, $get_priority_title);

				// Deadline warning
				$inp_sent_deadline_notification = $_POST['inp_sent_deadline_notification'];
				$inp_sent_deadline_notification = output_html($inp_sent_deadline_notification);
				$inp_sent_deadline_notification_mysql = quote_smart($link, $inp_sent_deadline_notification);

				// Update
				$result = mysqli_query($link, "UPDATE $t_edb_case_index_human_tasks SET 
								human_task_text=$inp_text_mysql,  
								human_task_priority_id=$inp_priority_id_mysql, 
							 	human_task_priority_title=$inp_priority_title_mysql, 
								human_task_is_finished=$inp_is_finished_mysql,
								human_task_deadline_date=$inp_deadline_date_mysql,
								human_task_deadline_time=$inp_deadline_time_mysql, 
								human_task_deadline_date_saying=$inp_deadline_date_saying_mysql, 
								human_task_deadline_date_ddmmyy=$inp_deadline_date_ddmmyy_mysql, 
								human_task_deadline_date_ddmmyyyy=$inp_deadline_date_ddmmyyyy_mysql, 
								human_task_deadline_week=$inp_deadline_week_mysql,  
								human_task_deadline_year=$inp_deadline_year_mysql,  
								human_task_sent_deadline_notification=$inp_sent_deadline_notification_mysql, 
								human_task_responsible_user_id='$get_responsible_user_id', 
								human_task_responsible_user_name=$inp_responsible_user_name_mysql, 
								human_task_responsible_user_alias=$inp_responsible_user_alias_mysql, 
								human_task_responsible_user_email=$inp_responsible_user_email_mysql, 
								human_task_responsible_user_image_path=$inp_responsible_user_image_path_mysql, 
								human_task_responsible_user_image_file=$inp_responsible_user_image_file_mysql, 
								human_task_responsible_user_image_thumb_40=$inp_responsible_user_image_thumb_a_mysql, 
								human_task_responsible_user_image_thumb_50=$inp_responsible_user_image_thumb_b_mysql, 
								human_task_responsible_user_first_name=$inp_responsible_user_first_name_mysql, 
								human_task_responsible_user_middle_name=$inp_responsible_user_middle_name_mysql, 
								human_task_responsible_user_last_name=$inp_responsible_user_last_name_mysql 
								 WHERE human_task_id=$get_current_human_task_id") or die(mysqli_error($link));


				$url = "tasks.php?district_id=$district_id&station_id=$station_id&user_id=$user_id&priority_id=$priority_id&finished=$finished&order_by=$order_by&order_method=$order_method&human_task_id=$get_current_human_task_id&l=$l&ft=success&fm=changes_saved#human_task$get_current_human_task_id";
				header("Location: $url");
				exit;

			}
			echo"
			<h2>$l_edit_human_task</h2>

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
		
			<!-- Edit human task form -->
				<form method=\"POST\" action=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$order_by&amp;order_method=$order_method&amp;action=edit_task&amp;human_task_id=$get_current_human_task_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

				<!-- <p><b>$l_evidence_record:</b><br />
				x
				</p>

				<p><b>$l_evidence_item:</b><br />
				x
				</p> -->


				<p><b>$l_text:</b><br />
				<input type=\"text\" name=\"inp_text\" value=\"$get_current_human_task_text\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" style=\"width: 100%;\" />
				</p>

				<p><b>$l_task_finished:</b><br />
				<input type=\"radio\" name=\"inp_is_finished\" value=\"1\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\""; if($get_current_human_task_is_finished == "1"){ echo" checked=\"checked\""; } echo" />
				$l_yes
				<input type=\"radio\" name=\"inp_is_finished\" value=\"0\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\""; if($get_current_human_task_is_finished == "0"){ echo" checked=\"checked\""; } echo" />
				$l_no
				</p>


				<p><b>$l_deadline:</b><br />
				<input type=\"date\" name=\"inp_deadline_date\" value=\"$get_current_human_task_deadline_date\" size=\"6\"  tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
				</p>

				<p><b>$l_responsible ($l_user_name):</b><br />
				<input type=\"text\" name=\"inp_responsible\" id=\"autosearch_inp_search_for_responsible\" value=\"$get_current_human_task_responsible_user_name\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" style=\"width: 100%;\" />
				</p>

				<div class=\"open_case_assignee_results\">
				</div>

				<!-- Responsible Autocomplete -->
				<script>
				\$(document).ready(function () {
					\$('#autosearch_inp_search_for_responsible').keyup(function () {
       						// getting the value that user typed
       						var searchString    = $(\"#autosearch_inp_search_for_responsible\").val();
 						// forming the queryString
      						var data            = 'l=$l&q=' + searchString;
         
        					// if searchString is not empty
        					if(searchString) {
           						// ajax call
            						\$.ajax({
                						type: \"GET\",
               							url: \"open_case_human_tasks_users_jquery_search.php\",
                						data: data,
								beforeSend: function(html) { // this happens before actual call
									\$(\".open_case_assignee_results\").html(''); 
								},
               							success: function(html){
                    							\$(\".open_case_assignee_results\").append(html);
              							}
            						});
       						}
        					return false;
            				});
         				 });
				</script>
				<!-- //Responsible Autocomplete -->

				<p>$l_priority:<br />
				<select name=\"inp_priority_id\" id=\"inp_priority\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">\n";
					$query = "SELECT priority_id, priority_title, priority_title_clean, priority_bg_color, priority_border_color, priority_text_color, priority_link_color, priority_weight, priority_number_of_cases_now FROM $t_edb_case_priorities ORDER BY priority_weight ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_priority_id, $get_priority_title, $get_priority_title_clean, $get_priority_bg_color, $get_priority_border_color, $get_priority_text_color, $get_priority_link_color, $get_priority_weight, $get_priority_number_of_cases_now) = $row;
						
						echo"							";
						echo"<option value=\"$get_priority_id\""; if($get_priority_id == "$get_current_human_task_priority_id"){ echo" selected=\"selected\""; } echo">$get_priority_title</option>\n";

					}
					echo"
				</select>
				</p>

				<p>$l_deadline_notification_sent:<br />
				<input type=\"radio\" name=\"inp_sent_deadline_notification\" value=\"1\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\""; if($get_current_human_task_sent_deadline_notification == "1"){ echo" checked=\"checked\""; } echo"> $l_yes
				&nbsp;
				<input type=\"radio\" name=\"inp_sent_deadline_notification\" value=\"0\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\""; if($get_current_human_task_sent_deadline_notification == "0"){ echo" checked=\"checked\""; } echo"> $l_no
				</p>



				<p>
				<input type=\"submit\" value=\"$l_save_changes\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
				</p>
			<!-- //Edit human task form -->
			";
		} // human task found
	} // action == edit human task
	elseif($action == "delete_task" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor")){
		if(isset($_GET['human_task_id'])) {
			$human_task_id = $_GET['human_task_id'];
			$human_task_id = strip_tags(stripslashes($human_task_id));
		}
		else{
			$human_task_id = "";
		}
		$human_task_id_mysql = quote_smart($link, $human_task_id);

		// Find human task
		$query = "SELECT human_task_id, human_task_case_id, human_task_evidence_record_id, human_task_evidence_item_id, human_task_text, human_task_created_datetime, human_task_created_time, human_task_created_date_saying, human_task_created_date_ddmmyy, human_task_deadline_date, human_task_deadline_time, human_task_deadline_date_saying, human_task_deadline_date_ddmmyy, human_task_is_finished, human_task_finished_datetime, human_task_finished_time, human_task_finished_date_saying, human_task_finished_date_ddmmyy, human_task_created_by_user_id, human_task_created_by_user_name, human_task_created_by_user_alias, human_task_created_by_user_email, human_task_created_by_user_image_path, human_task_created_by_user_image_file, human_task_created_by_user_image_thumb_40, human_task_created_by_user_image_thumb_50, human_task_created_by_user_first_name, human_task_created_by_user_middle_name, human_task_created_by_user_last_name, human_task_responsible_user_id, human_task_responsible_user_name, human_task_responsible_user_alias, human_task_responsible_user_email, human_task_responsible_user_image_path, human_task_responsible_user_image_file, human_task_responsible_user_image_thumb_40, human_task_responsible_user_image_thumb_50, human_task_responsible_user_first_name, human_task_responsible_user_middle_name, human_task_responsible_user_last_name
 FROM $t_edb_case_index_human_tasks WHERE human_task_id=$human_task_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_human_task_id, $get_current_human_task_case_id, $get_current_human_task_evidence_record_id, $get_current_human_task_evidence_item_id, $get_current_human_task_text, $get_current_human_task_created_datetime, $get_current_human_task_created_time, $get_current_human_task_created_date_saying, $get_current_human_task_created_date_ddmmyy, $get_current_human_task_deadline_date, $get_current_human_task_deadline_time, $get_current_human_task_deadline_date_saying, $get_current_human_task_deadline_date_ddmmyy, $get_current_human_task_is_finished, $get_current_human_task_finished_datetime, $get_current_human_task_finished_time, $get_current_human_task_finished_date_saying, $get_current_human_task_finished_date_ddmmyy, $get_current_human_task_created_by_user_id, $get_current_human_task_created_by_user_name, $get_current_human_task_created_by_user_alias, $get_current_human_task_created_by_user_email, $get_current_human_task_created_by_user_image_path, $get_current_human_task_created_by_user_image_file, $get_current_human_task_created_by_user_image_thumb_40, $get_current_human_task_created_by_user_image_thumb_50, $get_current_human_task_created_by_user_first_name, $get_current_human_task_created_by_user_middle_name, $get_current_human_task_created_by_user_last_name, $get_current_human_task_responsible_user_id, $get_current_human_task_responsible_user_name, $get_current_human_task_responsible_user_alias, $get_current_human_task_responsible_user_email, $get_current_human_task_responsible_user_image_path, $get_current_human_task_responsible_user_image_file, $get_current_human_task_responsible_user_image_thumb_40, $get_current_human_task_responsible_user_image_thumb_50, $get_current_human_task_responsible_user_first_name, $get_current_human_task_responsible_user_middle_name, $get_current_human_task_responsible_user_last_name) = $row;
		
		if($get_current_human_task_id == ""){
			echo"
			<h2>Human task not found</h2>
			<p><a href=\"open_case_human_tasks.php?case_id=$get_current_case_id&amp;l=$l\">Human tasks</a></p>
			";
		}
		else{

			if($process == "1"){
				
				// Delete
				$result = mysqli_query($link, "DELETE FROM $t_edb_case_index_human_tasks WHERE human_task_id=$get_current_human_task_id") or die(mysqli_error($link));



				$url = "tasks.php?district_id=$district_id&station_id=$station_id&user_id=$user_id&priority_id=$priority_id&finished=$finished&order_by=$order_by&order_method=$order_method&human_task_id=$get_current_human_task_id&l=$l&ft=success&fm=human_task_deleted";
				header("Location: $url");
				exit;

			}
			echo"
			<h2>$l_delete_human_task</h2>

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

		
			<!-- Delete human task form -->
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
						<span>$get_current_human_task_id</span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding-right: 5px;\">
						<span>$l_date:</span>
					  </td>
					  <td>
						<span>$get_current_human_task_created_date_ddmmyy</span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding-right: 5px;\">
						<span>$l_text:</span>
					  </td>
					  <td>
						<span>$get_current_human_task_text</span>
					  </td>
					 </tr>
					</table>
				</div>

				<p>
				<a href=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$order_by&amp;order_method=$order_method&amp;action=$action&amp;human_task_id=$get_current_human_task_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">$l_confirm</a>
				<a href=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\" class=\"btn_default\">$l_cancel</a>
				</p>
			<!-- //Delete event form -->
			";
		} // human_task found
	} // action == delete human_task
	elseif(($action == "set_task_finished" OR $action == "set_task_unfinished") && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor")){
		if(isset($_GET['human_task_id'])) {
			$human_task_id = $_GET['human_task_id'];
			$human_task_id = strip_tags(stripslashes($human_task_id));
		}
		else{
			$human_task_id = "";
		}
		$human_task_id_mysql = quote_smart($link, $human_task_id);

		// Find human task
		$query = "SELECT human_task_id, human_task_case_id, human_task_evidence_record_id, human_task_evidence_item_id, human_task_text, human_task_created_datetime, human_task_created_time, human_task_created_date_saying, human_task_created_date_ddmmyy, human_task_deadline_date, human_task_deadline_time, human_task_deadline_date_saying, human_task_deadline_date_ddmmyy, human_task_is_finished, human_task_finished_datetime, human_task_finished_time, human_task_finished_date_saying, human_task_finished_date_ddmmyy, human_task_created_by_user_id, human_task_created_by_user_name, human_task_created_by_user_alias, human_task_created_by_user_email, human_task_created_by_user_image_path, human_task_created_by_user_image_file, human_task_created_by_user_image_thumb_40, human_task_created_by_user_image_thumb_50, human_task_created_by_user_first_name, human_task_created_by_user_middle_name, human_task_created_by_user_last_name, human_task_responsible_user_id, human_task_responsible_user_name, human_task_responsible_user_alias, human_task_responsible_user_email, human_task_responsible_user_image_path, human_task_responsible_user_image_file, human_task_responsible_user_image_thumb_40, human_task_responsible_user_image_thumb_50, human_task_responsible_user_first_name, human_task_responsible_user_middle_name, human_task_responsible_user_last_name
 FROM $t_edb_case_index_human_tasks WHERE human_task_id=$human_task_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_human_task_id, $get_current_human_task_case_id, $get_current_human_task_evidence_record_id, $get_current_human_task_evidence_item_id, $get_current_human_task_text, $get_current_human_task_created_datetime, $get_current_human_task_created_time, $get_current_human_task_created_date_saying, $get_current_human_task_created_date_ddmmyy, $get_current_human_task_deadline_date, $get_current_human_task_deadline_time, $get_current_human_task_deadline_date_saying, $get_current_human_task_deadline_date_ddmmyy, $get_current_human_task_is_finished, $get_current_human_task_finished_datetime, $get_current_human_task_finished_time, $get_current_human_task_finished_date_saying, $get_current_human_task_finished_date_ddmmyy, $get_current_human_task_created_by_user_id, $get_current_human_task_created_by_user_name, $get_current_human_task_created_by_user_alias, $get_current_human_task_created_by_user_email, $get_current_human_task_created_by_user_image_path, $get_current_human_task_created_by_user_image_file, $get_current_human_task_created_by_user_image_thumb_40, $get_current_human_task_created_by_user_image_thumb_50, $get_current_human_task_created_by_user_first_name, $get_current_human_task_created_by_user_middle_name, $get_current_human_task_created_by_user_last_name, $get_current_human_task_responsible_user_id, $get_current_human_task_responsible_user_name, $get_current_human_task_responsible_user_alias, $get_current_human_task_responsible_user_email, $get_current_human_task_responsible_user_image_path, $get_current_human_task_responsible_user_image_file, $get_current_human_task_responsible_user_image_thumb_40, $get_current_human_task_responsible_user_image_thumb_50, $get_current_human_task_responsible_user_first_name, $get_current_human_task_responsible_user_middle_name, $get_current_human_task_responsible_user_last_name) = $row;
		
		if($get_current_human_task_id == ""){
			echo"
			<h2>Human task not found</h2>
			<p><a href=\"open_case_human_tasks.php?case_id=$get_current_case_id&amp;l=$l\">Human tasks</a></p>
			";
		}
		else{
			if($process == "1"){
				if($get_current_human_task_is_finished == "1"){
					$result = mysqli_query($link, "UPDATE $t_edb_case_index_human_tasks SET 
									human_task_is_finished=0, 
									human_task_finished_datetime=NULL, 
									human_task_finished_date=NULL, 
									human_task_finished_time=NULL, 
									human_task_finished_date_saying=NULL, 
									human_task_finished_date_ddmmyy=NULL, 
									human_task_finished_date_ddmmyyyy=NULL
									 WHERE human_task_id=$get_current_human_task_id") or die(mysqli_error($link));

					$url = "tasks.php?district_id=$district_id&station_id=$station_id&user_id=$user_id&priority_id=$priority_id&finished=$finished&order_by=$order_by&order_method=$order_method&human_task_id=$get_current_human_task_id&l=$l&ft=success&fm=set_task_unfinished#human_task$get_current_human_task_id";
					header("Location: $url");
					exit;
				}
				else{
					// Dates
					$inp_datetime = date("Y-m-d H:i:s");
					$inp_date = date("Y-m-d");
					$inp_time = time();
					$inp_date_saying = date("j M Y");
					$inp_date_ddmmyy = date("d.m.y");
					$inp_date_ddmmyyyy = date("d.m.Y");

					$result = mysqli_query($link, "UPDATE $t_edb_case_index_human_tasks SET 
									human_task_is_finished=1, 
									human_task_finished_datetime='$inp_datetime', 
									human_task_finished_date='$inp_date', 
									human_task_finished_time='$inp_time', 
									human_task_finished_date_saying='$inp_date_saying', 
									human_task_finished_date_ddmmyy='$inp_date_ddmmyy', 
									human_task_finished_date_ddmmyyyy='$inp_date_ddmmyyyy'
									 WHERE human_task_id=$get_current_human_task_id") or die(mysqli_error($link));

					$url = "tasks.php?district_id=$district_id&station_id=$station_id&user_id=$user_id&priority_id=$priority_id&finished=$finished&order_by=$order_by&order_method=$order_method&human_task_id=$get_current_human_task_id&l=$l&ft=success&fm=set_task_finished#human_task$get_current_human_task_id";
					header("Location: $url");
					exit;
				}
			} // process == 1
		} // task found
	} // action == set task finished
	elseif($action == "generate_responsible"){
		// Truncate table
		$result_update = mysqli_query($link, "TRUNCATE $t_edb_case_index_human_tasks_responsible_counters") or die(mysqli_error($link));



		$query = "SELECT human_task_id, human_task_case_id, human_task_case_number, human_task_evidence_record_id, human_task_evidence_item_id, human_task_district_id, human_task_district_title, human_task_station_id, human_task_station_title, human_task_text, human_task_priority_id, human_task_priority_title, human_task_created_datetime, human_task_created_date, human_task_created_time, human_task_created_date_saying, human_task_created_date_ddmmyy, human_task_created_date_ddmmyyyy, human_task_deadline_date, human_task_deadline_time, human_task_deadline_date_saying, human_task_deadline_date_ddmmyy, human_task_deadline_date_ddmmyyyy, human_task_is_finished, human_task_finished_datetime, human_task_finished_date, human_task_finished_time, human_task_finished_date_saying, human_task_finished_date_ddmmyy, human_task_finished_date_ddmmyyyy, human_task_created_by_user_id, human_task_created_by_user_name, human_task_created_by_user_alias, human_task_created_by_user_email, human_task_created_by_user_image_path, human_task_created_by_user_image_file, human_task_created_by_user_image_thumb_40, human_task_created_by_user_image_thumb_50, human_task_created_by_user_first_name, human_task_created_by_user_middle_name, human_task_created_by_user_last_name, human_task_responsible_user_id, human_task_responsible_user_name, human_task_responsible_user_alias, human_task_responsible_user_email, human_task_responsible_user_image_path, human_task_responsible_user_image_file, human_task_responsible_user_image_thumb_40, human_task_responsible_user_image_thumb_50, human_task_responsible_user_first_name, human_task_responsible_user_middle_name, human_task_responsible_user_last_name FROM $t_edb_case_index_human_tasks";
		$query = $query . "  WHERE human_task_is_finished=0";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_human_task_id, $get_human_task_case_id, $get_human_task_case_number, $get_human_task_evidence_record_id, $get_human_task_evidence_item_id, $get_human_task_district_id, $get_human_task_district_title, $get_human_task_station_id, $get_human_task_station_title, $get_human_task_text, $get_human_task_priority_id, $get_human_task_priority_title, $get_human_task_created_datetime, $get_human_task_created_date, $get_human_task_created_time, $get_human_task_created_date_saying, $get_human_task_created_date_ddmmyy, $get_human_task_created_date_ddmmyyyy, $get_human_task_deadline_date, $get_human_task_deadline_time, $get_human_task_deadline_date_saying, $get_human_task_deadline_date_ddmmyy, $get_human_task_deadline_date_ddmmyyyy, $get_human_task_is_finished, $get_human_task_finished_datetime, $get_human_task_finished_date, $get_human_task_finished_time, $get_human_task_finished_date_saying, $get_human_task_finished_date_ddmmyy, $get_human_task_finished_date_ddmmyyyy, $get_human_task_created_by_user_id, $get_human_task_created_by_user_name, $get_human_task_created_by_user_alias, $get_human_task_created_by_user_email, $get_human_task_created_by_user_image_path, $get_human_task_created_by_user_image_file, $get_human_task_created_by_user_image_thumb_40, $get_human_task_created_by_user_image_thumb_50, $get_human_task_created_by_user_first_name, $get_human_task_created_by_user_middle_name, $get_human_task_created_by_user_last_name, $get_human_task_responsible_user_id, $get_human_task_responsible_user_name, $get_human_task_responsible_user_alias, $get_human_task_responsible_user_email, $get_human_task_responsible_user_image_path, $get_human_task_responsible_user_image_file, $get_human_task_responsible_user_image_thumb_40, $get_human_task_responsible_user_image_thumb_50, $get_human_task_responsible_user_first_name, $get_human_task_responsible_user_middle_name, $get_human_task_responsible_user_last_name) = $row;

			// Check if user exists
			$query_u = "SELECT counter_id, counter_number_of_tasks FROM $t_edb_case_index_human_tasks_responsible_counters WHERE counter_user_id=$get_human_task_responsible_user_id";
			$result_u = mysqli_query($link, $query_u);
			$row_u = mysqli_fetch_row($result_u);
			list($get_counter_id, $get_counter_number_of_tasks) = $row_u;
			if($get_counter_id == ""){
				// Insert
				$inp_responsible_user_name_mysql = quote_smart($link, $get_human_task_responsible_user_name);
				$inp_responsible_user_alias_mysql = quote_smart($link, $get_human_task_responsible_user_alias);
				$inp_responsible_user_email_mysql = quote_smart($link, $get_human_task_responsible_user_email);
				$inp_responsible_user_image_path_mysql = quote_smart($link, $get_human_task_responsible_user_image_path);
				$inp_responsible_user_image_file_mysql = quote_smart($link, $get_human_task_responsible_user_image_file);
				$inp_responsible_user_image_thumb_40_mysql = quote_smart($link, $get_human_task_responsible_user_image_thumb_40);
				$inp_responsible_user_image_thumb_50_mysql = quote_smart($link, $get_human_task_responsible_user_image_thumb_50);
				$inp_responsible_user_first_name_mysql = quote_smart($link, $get_human_task_responsible_user_first_name);
				$inp_responsible_user_middle_name_mysql = quote_smart($link, $get_human_task_responsible_user_middle_name);
				$inp_responsible_user_last_name_mysql = quote_smart($link, $get_human_task_responsible_user_last_name);
				$inp_responsible_number_of_tasks_mysql = quote_smart($link, 1);



				mysqli_query($link, "INSERT INTO $t_edb_case_index_human_tasks_responsible_counters
				(counter_id, counter_user_id, counter_user_name, counter_user_alias, counter_user_email, 
				counter_user_image_path, counter_user_image_file, counter_user_image_thumb_40, counter_user_image_thumb_50, counter_user_first_name, counter_user_middle_name, counter_user_last_name, counter_number_of_tasks) 
				VALUES 
				(NULL, $get_human_task_responsible_user_id, $inp_responsible_user_name_mysql, $inp_responsible_user_alias_mysql, $inp_responsible_user_email_mysql, 
				$inp_responsible_user_image_path_mysql, $inp_responsible_user_image_file_mysql, $inp_responsible_user_image_thumb_40_mysql, $inp_responsible_user_image_thumb_50_mysql, 
				$inp_responsible_user_first_name_mysql, $inp_responsible_user_middle_name_mysql, $inp_responsible_user_last_name_mysql, $inp_responsible_number_of_tasks_mysql)")
				or die(mysqli_error($link));

			}
			else{
				// Update counter
				$inp_responsible_number_of_tasks = $get_counter_number_of_tasks+1;
				$result_update = mysqli_query($link, "UPDATE $t_edb_case_index_human_tasks_responsible_counters SET counter_number_of_tasks=$inp_responsible_number_of_tasks WHERE counter_id=$get_counter_id") or die(mysqli_error($link));

			}


		} // while tasks

		$url = "tasks.php?district_id=$district_id&station_id=$station_id&user_id=$user_id&priority_id=$priority_id&order_by=$order_by&order_method=$order_method&l=$l&ft=info&fm=generated_successfully";
		header("Location: $url");
		exit;
	} // $action == "generate_responsible"
	elseif($action == "new_task" && ($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor")){
		if($process == "1"){
			// Find case
			$inp_case_number = $_POST['inp_case_number'];
			$inp_case_number = output_html($inp_case_number);
			$inp_case_number_mysql = quote_smart($link, $inp_case_number);

			$query = "SELECT case_id, case_number, case_title, case_title_clean, case_suspect_in_custody, case_code_id, case_code_title, case_status_id, case_status_title, case_priority_id, case_priority_title, case_district_id, case_district_title, case_station_id, case_station_title, case_is_screened, case_assigned_to_datetime, case_assigned_to_time, case_assigned_to_date_saying, case_assigned_to_date_ddmmyy, case_assigned_to_user_id, case_assigned_to_user_name, case_assigned_to_user_alias, case_assigned_to_user_email, case_assigned_to_user_image_path, case_assigned_to_user_image_file, case_assigned_to_user_image_thumb_40, case_assigned_to_user_image_thumb_50, case_assigned_to_user_first_name, case_assigned_to_user_middle_name, case_assigned_to_user_last_name, case_created_datetime, case_created_time, case_created_date_saying, case_created_date_ddmmyy, case_created_user_id, case_created_user_name, case_created_user_alias, case_created_user_email, case_created_user_image_path, case_created_user_image_file, case_created_user_image_thumb_40, case_created_user_image_thumb_50, case_created_user_first_name, case_created_user_middle_name, case_created_user_last_name, case_detective_user_id, case_detective_user_job_title, case_detective_user_first_name, case_detective_user_middle_name, case_detective_user_last_name, case_detective_user_name, case_detective_user_alias, case_detective_user_email, case_detective_email_alerts, case_detective_user_image_path, case_detective_user_image_file, case_detective_user_image_thumb_40, case_detective_user_image_thumb_50, case_updated_datetime, case_updated_time, case_updated_date_saying, case_updated_date_ddmmyy, case_updated_user_id, case_updated_user_name, case_updated_user_alias, case_updated_user_email, case_updated_user_image_path, case_updated_user_image_file, case_updated_user_image_thumb_40, case_updated_user_image_thumb_50, case_updated_user_first_name, case_updated_user_middle_name, case_updated_user_last_name, case_is_closed, case_closed_datetime, case_closed_time, case_closed_date_saying, case_closed_date_ddmmyy, case_time_from_created_to_close FROM $t_edb_case_index WHERE case_number=$inp_case_number_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_case_id, $get_current_case_number, $get_current_case_title, $get_current_case_title_clean, $get_current_case_suspect_in_custody, $get_current_case_code_id, $get_current_case_code_title, $get_current_case_status_id, $get_current_case_status_title, $get_current_case_priority_id, $get_current_case_priority_title, $get_current_case_district_id, $get_current_case_district_title, $get_current_case_station_id, $get_current_case_station_title, $get_current_case_is_screened, $get_current_case_assigned_to_datetime, $get_current_case_assigned_to_time, $get_current_case_assigned_to_date_saying, $get_current_case_assigned_to_date_ddmmyy, $get_current_case_assigned_to_user_id, $get_current_case_assigned_to_user_name, $get_current_case_assigned_to_user_alias, $get_current_case_assigned_to_user_email, $get_current_case_assigned_to_user_image_path, $get_current_case_assigned_to_user_image_file, $get_current_case_assigned_to_user_image_thumb_40, $get_current_case_assigned_to_user_image_thumb_50, $get_current_case_assigned_to_user_first_name, $get_current_case_assigned_to_user_middle_name, $get_current_case_assigned_to_user_last_name, $get_current_case_created_datetime, $get_current_case_created_time, $get_current_case_created_date_saying, $get_current_case_created_date_ddmmyy, $get_current_case_created_user_id, $get_current_case_created_user_name, $get_current_case_created_user_alias, $get_current_case_created_user_email, $get_current_case_created_user_image_path, $get_current_case_created_user_image_file, $get_current_case_created_user_image_thumb_40, $get_current_case_created_user_image_thumb_50, $get_current_case_created_user_first_name, $get_current_case_created_user_middle_name, $get_current_case_created_user_last_name, $get_current_case_detective_user_id, $get_current_case_detective_user_job_title, $get_current_case_detective_user_first_name, $get_current_case_detective_user_middle_name, $get_current_case_detective_user_last_name, $get_current_case_detective_user_name, $get_current_case_detective_user_alias, $get_current_case_detective_user_email, $get_current_case_detective_email_alerts, $get_current_case_detective_user_image_path, $get_current_case_detective_user_image_file, $get_current_case_detective_user_image_thumb_40, $get_current_case_detective_user_image_thumb_50, $get_current_case_updated_datetime, $get_current_case_updated_time, $get_current_case_updated_date_saying, $get_current_case_updated_date_ddmmyy, $get_current_case_updated_user_id, $get_current_case_updated_user_name, $get_current_case_updated_user_alias, $get_current_case_updated_user_email, $get_current_case_updated_user_image_path, $get_current_case_updated_user_image_file, $get_current_case_updated_user_image_thumb_40, $get_current_case_updated_user_image_thumb_50, $get_current_case_updated_user_first_name, $get_current_case_updated_user_middle_name, $get_current_case_updated_user_last_name, $get_current_case_is_closed, $get_current_case_closed_datetime, $get_current_case_closed_time, $get_current_case_closed_date_saying, $get_current_case_closed_date_ddmmyy, $get_current_case_time_from_created_to_close) = $row;
	
			$inp_case_id_mysql = quote_smart($link, $get_current_case_id);

			// District + station
			$inp_district_id_mysql = quote_smart($link, $get_current_case_district_id);
			$inp_district_title_mysql = quote_smart($link, $get_current_case_district_title);

			$inp_station_id_mysql = quote_smart($link, $get_current_case_station_id);
			$inp_station_title_mysql = quote_smart($link, $get_current_case_station_title);

			$inp_text = $_POST['inp_text'];
			$inp_text = output_html($inp_text);
			$inp_text_mysql = quote_smart($link, $inp_text);

	
			$inp_deadline_date = $_POST['inp_deadline_date'];
			$inp_deadline_date_mysql = quote_smart($link, $inp_deadline_date);

			$inp_deadline_year = substr($inp_deadline_date, 0, 4);
			$inp_deadline_month = substr($inp_deadline_date, 5, 2);
			$inp_deadline_day = substr($inp_deadline_date, 8, 4);

			$inp_deadline_time = strtotime($inp_deadline_date);
			$inp_deadline_time_mysql = quote_smart($link, $inp_deadline_time);

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
			$inp_deadline_day_saying = str_replace("0", "", $inp_deadline_day);
			$inp_deadline_month_saying = str_replace("0", "", $inp_deadline_month);
				
			$inp_deadline_date_saying  = $inp_deadline_day . ". " . $l_month_array[$inp_deadline_month_saying] . " " . $inp_deadline_year;
			$inp_deadline_date_saying_mysql = quote_smart($link, $inp_deadline_date_saying);

			$inp_deadline_date_ddmmyy = $inp_deadline_day . "." . $inp_deadline_month . "." . substr($inp_deadline_year, 2, 2);
			$inp_deadline_date_ddmmyy_mysql = quote_smart($link, $inp_deadline_date_ddmmyy);

			$inp_deadline_date_ddmmyyyy = $inp_deadline_day . "." . $inp_deadline_month . "." . $inp_deadline_year;
			$inp_deadline_date_ddmmyyyy_mysql = quote_smart($link, $inp_deadline_date_ddmmyyyy);

			// Deadline week
			$inp_deadline_week = date("W", $inp_deadline_time);
			$inp_deadline_week_mysql = quote_smart($link, $inp_deadline_week);

			$inp_deadline_year = date("Y", $inp_deadline_time);
			$inp_deadline_year_mysql = quote_smart($link, $inp_deadline_year);

			$inp_responsible = $_POST['inp_responsible'];
			$inp_responsible = output_html($inp_responsible);
			$inp_responsible_mysql = quote_smart($link, $inp_responsible);

			// Find responsible
			$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_name=$inp_responsible_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_responsible_user_id, $get_responsible_user_email, $get_responsible_user_name, $get_responsible_user_alias, $get_responsible_user_language, $get_responsible_user_last_online, $get_responsible_user_rank, $get_responsible_user_login_tries) = $row;
					
			// Responsible photo
			$query = "SELECT photo_id, photo_destination, photo_thumb_40, photo_thumb_50 FROM $t_users_profile_photo WHERE photo_user_id=$my_user_id_mysql AND photo_profile_image='1'";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_responsible_photo_id, $get_responsible_photo_destination, $get_responsible_photo_thumb_40, $get_responsible_photo_thumb_50) = $row;

			// Responsible Profile
			$query = "SELECT profile_id, profile_first_name, profile_middle_name, profile_last_name, profile_about FROM $t_users_profile WHERE profile_user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_responsible_profile_id, $get_responsible_profile_first_name, $get_responsible_profile_middle_name, $get_responsible_profile_last_name, $get_responsible_profile_about) = $row;

			$inp_responsible_user_name_mysql = quote_smart($link, $get_responsible_user_name);
			$inp_responsible_user_alias_mysql = quote_smart($link, $get_responsible_user_alias);
			$inp_responsible_user_email_mysql = quote_smart($link, $get_responsible_user_email);

			$inp_responsible_user_image_path = "_uploads/users/images/$get_responsible_user_id";
			$inp_responsible_user_image_path_mysql = quote_smart($link, $inp_responsible_user_image_path);

			$inp_responsible_user_image_file_mysql = quote_smart($link, $get_responsible_photo_destination);

			$inp_responsible_user_image_thumb_a_mysql = quote_smart($link, $get_responsible_photo_thumb_40);
			$inp_responsible_user_image_thumb_b_mysql = quote_smart($link, $get_responsible_photo_thumb_50);

			$inp_responsible_user_first_name_mysql = quote_smart($link, $get_responsible_profile_first_name);
			$inp_responsible_user_middle_name_mysql = quote_smart($link, $get_responsible_profile_middle_name);
			$inp_responsible_user_last_name_mysql = quote_smart($link, $get_responsible_profile_last_name);

			// Dates
			$inp_datetime = date("Y-m-d H:i:s");
			$inp_time = time();
			$inp_date_saying = date("j M Y");
			$inp_date_ddmmyy = date("d.m.y");
			$inp_date_ddmmyyyy = date("d.m.Y");
				

			// Priority
			$inp_priority_id = $_POST['inp_priority_id'];
			$inp_priority_id = output_html($inp_priority_id);
			$inp_priority_id_mysql = quote_smart($link, $inp_priority_id);
			$query = "SELECT priority_id, priority_title, priority_title_clean, priority_bg_color, priority_border_color, priority_text_color, priority_link_color, priority_weight, priority_number_of_cases_now, priority_last_used_datetime, priority_last_used_time, priority_times_used FROM $t_edb_case_priorities WHERE priority_id=$inp_priority_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_priority_id, $get_priority_title, $get_priority_title_clean, $get_priority_bg_color, $get_priority_border_color, $get_priority_text_color, $get_priority_link_color, $get_priority_weight, $get_priority_number_of_cases_now, $get_priority_last_used_datetime, $get_priority_last_used_time, $get_priority_times_used) = $row;
			$inp_priority_title_mysql = quote_smart($link, $get_priority_title);


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
					$inp_my_user_rank_mysql = quote_smart($link, $get_my_user_rank);

					$inp_my_user_image_path = "_uploads/users/images/$get_my_user_id";
					$inp_my_user_image_path_mysql = quote_smart($link, $inp_my_user_image_path);

					$inp_my_user_image_file_mysql = quote_smart($link, $get_my_photo_destination);

					$inp_my_user_image_thumb_a_mysql = quote_smart($link, $get_my_photo_thumb_40);
					$inp_my_user_image_thumb_b_mysql = quote_smart($link, $get_my_photo_thumb_50);

					$inp_my_user_first_name_mysql = quote_smart($link, $get_my_profile_first_name);
					$inp_my_user_middle_name_mysql = quote_smart($link, $get_my_profile_middle_name);
					$inp_my_user_last_name_mysql = quote_smart($link, $get_my_profile_last_name);

			// Insert
			mysqli_query($link, "INSERT INTO $t_edb_case_index_human_tasks
			(human_task_id, human_task_case_id, human_task_case_number, human_task_evidence_record_id, human_task_evidence_item_id, human_task_district_id,
		 	human_task_district_title, human_task_station_id, human_task_station_title, human_task_text, human_task_priority_id, 
			human_task_priority_title, human_task_created_datetime, human_task_created_date, human_task_created_time, human_task_created_date_saying, human_task_created_date_ddmmyy, human_task_created_date_ddmmyyyy, human_task_deadline_date, 
			human_task_deadline_time, human_task_deadline_date_saying, human_task_deadline_date_ddmmyy, human_task_deadline_date_ddmmyyyy, human_task_deadline_week, human_task_deadline_year, human_task_sent_deadline_notification, human_task_is_finished, human_task_created_by_user_id, 
			human_task_created_by_user_rank, 
			human_task_created_by_user_name, human_task_created_by_user_alias, human_task_created_by_user_email, human_task_created_by_user_image_path, human_task_created_by_user_image_file, human_task_created_by_user_image_thumb_40, human_task_created_by_user_image_thumb_50, human_task_created_by_user_first_name, human_task_created_by_user_middle_name, human_task_created_by_user_last_name,
			human_task_responsible_user_id, human_task_responsible_user_name, human_task_responsible_user_alias, human_task_responsible_user_email, human_task_responsible_user_image_path, human_task_responsible_user_image_file, human_task_responsible_user_image_thumb_40, human_task_responsible_user_image_thumb_50, human_task_responsible_user_first_name, human_task_responsible_user_middle_name, human_task_responsible_user_last_name) 
			VALUES 
			(NULL, $inp_case_id_mysql, $inp_case_number_mysql, '0', '0', $inp_district_id_mysql, 
			$inp_district_title_mysql, $inp_station_id_mysql, $inp_station_title_mysql, $inp_text_mysql, $inp_priority_id_mysql, 
			$inp_priority_title_mysql, 
			'$inp_datetime', '$inp_date', '$inp_time', '$inp_date_saying', '$inp_date_ddmmyy', '$inp_date_ddmmyyyy', $inp_deadline_date_mysql,
			$inp_deadline_time_mysql, $inp_deadline_date_saying_mysql, $inp_deadline_date_ddmmyy_mysql, $inp_deadline_date_ddmmyyyy_mysql, $inp_deadline_week_mysql, $inp_deadline_year_mysql, '0', '0', '$get_my_user_id',
			$inp_my_user_rank_mysql, 
			$inp_my_user_name_mysql, $inp_my_user_alias_mysql, $inp_my_user_email_mysql, $inp_my_user_image_path_mysql, $inp_my_user_image_file_mysql, $inp_my_user_image_thumb_a_mysql, $inp_my_user_image_thumb_b_mysql, $inp_my_user_first_name_mysql, $inp_my_user_middle_name_mysql, $inp_my_user_last_name_mysql,
			'$get_responsible_user_id',
			$inp_responsible_user_name_mysql, $inp_responsible_user_alias_mysql, $inp_responsible_user_email_mysql, $inp_responsible_user_image_path_mysql, $inp_responsible_user_image_file_mysql, $inp_responsible_user_image_thumb_a_mysql, $inp_responsible_user_image_thumb_b_mysql, $inp_responsible_user_first_name_mysql, $inp_responsible_user_middle_name_mysql, $inp_responsible_user_last_name_mysql)")
			or die(mysqli_error($link));

			// Get ID
			$query = "SELECT human_task_id FROM $t_edb_case_index_human_tasks WHERE human_task_created_datetime='$inp_datetime' AND human_task_created_by_user_id=$get_my_user_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_human_task_id) = $row;


			$url = "tasks.php?district_id=$district_id&station_id=$station_id&user_id=$user_id&priority_id=$priority_id&finished=$finished&order_by=$order_by&order_method=$order_method&human_task_id=$get_current_human_task_id&l=$l&ft=success&fm=task_created#human_task$get_human_task_id";
			header("Location: $url");
			exit;

		}
		echo"
		<h2>$l_new_task</h2>


		<!-- Where am I? -->
			<p><b>$l_you_are_here:</b><br />
			<a href=\"index.php?l=$l\">$l_edb</a>
			&gt;";
			
			// District
			if(isset($get_current_district_id)){
				echo"
				<a href=\"cases_board_1_view_district.php?district_id=$get_current_district_id&amp;l=$l\">$get_current_district_title</a>
				&gt;
				";
			}
			else{	
				if(isset($get_current_station_district_id)){
					echo"
					<a href=\"cases_board_1_view_district.php?district_id=$get_current_station_district_id&amp;l=$l\">$get_current_station_district_title</a>
					&gt;
					";
				}
			}

			// Station
			if(isset($get_current_station_id)){
				echo"
				<a href=\"cases_board_2_view_station.php?station_id=$get_current_station_id&amp;l=$l\">$get_current_station_title</a>
				&gt;
				";
			}
			echo"
				<a href=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\">$l_tasks</a>
				&gt;
				<a href=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$order_by&amp;order_method=$order_method&amp;action=$action&amp;l=$l\">$l_new_task</a>
				</p>
		<!-- //Where am I? -->

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
				\$('[name=\"inp_case_number\"]').focus();
			});
			</script>
		<!-- //Focus -->
	
		<!-- New human task form -->
			<form method=\"POST\" action=\"tasks.php?district_id=$district_id&amp;station_id=$station_id&amp;user_id=$user_id&amp;priority_id=$priority_id&amp;finished=$finished&amp;order_by=$order_by&amp;order_method=$order_method&amp;action=$action&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<!-- <p><b>$l_evidence_record:</b><br />
			x
			</p>
			<p><b>$l_evidence_item:</b><br />
			x
			</p> -->

			<p>$l_case_number:<br />
			<input type=\"text\" name=\"inp_case_number\" id=\"inp_case_number\" value=\"\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" style=\"width: 100%;\" />
			</p>
			<div id=\"inp_case_number_query_results\"></div>
			<!-- Search engines Autocomplete -->
				<script id=\"source\" language=\"javascript\" type=\"text/javascript\">
					\$(document).ready(function () {
						\$('#inp_case_number').keyup(function () {
									
 							// getting the value that user typed
							var searchString    = \$(\"#inp_case_number\").val();
							// forming the queryString
      							var data            = 'inp_case_number='+ searchString;
         
        						// if searchString is not empty
        						if(searchString) {
								\$(\"#inp_case_number_query_results\").css('visibility','visible');
								// ajax call
								\$.ajax({
									type: \"POST\",
									url: \"tasks_new_jquery_searh_for_case_number.php\",
                							data: data,
									beforeSend: function(html) { // this happens before actual call
									\$(\"#inp_case_number_query_results\").html(''); 
								},
               							success: function(html){
                    							\$(\"#inp_case_number_query_results\").append(html);
              							}
            						});
       						}
        					return false;
            				});
         			});
				</script>
			<!-- //Search engines Autocomplete -->


			<p>$l_text:<br />
			<input type=\"text\" name=\"inp_text\" value=\"\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" style=\"width: 100%;\" />
			</p>

			<p>$l_deadline:<br />";
			// One week
			$inp_day_one_week = date("d", strtotime("+1 week"));
			$inp_month_one_week = date("m", strtotime("+1 week"));
			$inp_year_one_week = date("Y", strtotime("+1 week"));
			$inp_date_one_week = date("Y-m-d", strtotime("+1 week"));
			echo"
			<input type=\"date\" name=\"inp_deadline_date\" value=\"$inp_date_one_week\" size=\"6\"  tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
			</p>

			<p>$l_responsible ($l_user_name):<br />";
			// Me
			$my_user_id = $_SESSION['user_id'];
			$my_user_id = output_html($my_user_id);
			$my_user_id_mysql = quote_smart($link, $my_user_id);
			
			// My user
			$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_language, $get_my_user_last_online, $get_my_user_rank, $get_my_user_login_tries) = $row;
					
			echo"
			<input type=\"text\" name=\"inp_responsible\" id=\"autosearch_inp_search_for_responsible\" value=\"$get_my_user_name\" size=\"25\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" style=\"width: 100%;\" />
			</p>

			<div class=\"open_case_assignee_results\">
			</div>

			<!-- Responsible Autocomplete -->
			<script>
			\$(document).ready(function () {
				\$('#autosearch_inp_search_for_responsible').keyup(function () {
      						// getting the value that user typed
      						var searchString    = $(\"#autosearch_inp_search_for_responsible\").val();
 						// forming the queryString
     						var data            = 'l=$l&q=' + searchString;
         
        					// if searchString is not empty
       					if(searchString) {
          						// ajax call
           						\$.ajax({
               						type: \"GET\",
              							url: \"open_case_human_tasks_users_jquery_search.php\",
               						data: data,
							beforeSend: function(html) { // this happens before actual call
								\$(\".open_case_assignee_results\").html(''); 
							},
              							success: function(html){
                   							\$(\".open_case_assignee_results\").append(html);
             							}
           						});
      						}
       					return false;
           				});
        				 });
				</script>
			<!-- //Responsible Autocomplete -->

			<p>$l_priority:<br />
			<select name=\"inp_priority_id\" id=\"inp_priority\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\">\n";
				$x = 0;
				$query = "SELECT priority_id, priority_title, priority_title_clean, priority_bg_color, priority_border_color, priority_text_color, priority_link_color, priority_weight, priority_number_of_cases_now FROM $t_edb_case_priorities ORDER BY priority_weight ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_priority_id, $get_priority_title, $get_priority_title_clean, $get_priority_bg_color, $get_priority_border_color, $get_priority_text_color, $get_priority_link_color, $get_priority_weight, $get_priority_number_of_cases_now) = $row;
					
					echo"							";
					echo"<option value=\"$get_priority_id\""; if($x == "1"){ echo" selected=\"selected\""; } echo">$get_priority_title</option>\n";

					$x++;
				}
				echo"
			</select>
			</p>

			<p>
			<input type=\"submit\" value=\"$l_save_changes\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
			</p>
		<!-- //New human task form -->
		";
	} // action == new task

} // logged in
else{
	// Log in
	echo"
	<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> $l_please_log_in...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/edb/tasks.php\">
	";
} // not logged in
/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/$webdesignSav/footer.php");
?>