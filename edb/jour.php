<?php 
/**
*
* File: edb/jour.php
* Version 1.0
* Date 19:56 14.08.2019
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

	if($station_id != ""){
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
				$website_title = "$l_edb - $get_current_district_title - $get_current_station_title - $l_jour";
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
					<meta http-equiv=\"refresh\" content=\"3;url=districts.php?action=apply_for_membership_to_station&amp;station_id=$get_current_station_id&amp;l=$l\">
					";
				} // access to station denied
				else{
					if($action == ""){
						echo"
						<h1>$get_current_station_title $l_jour</h1>

						<!-- Where am I ? -->	
						<p><b>$l_you_are_here:</b><br />
						<a href=\"index.php?l=$l\">$l_edb</a>
						&gt;
						<a href=\"cases_board_1_view_district.php?district_id=$get_current_district_id&amp;l=$l\">$get_current_district_title</a>
						&gt;
						<a href=\"cases_board_2_view_station.php?district_id=$get_current_district_id&amp;station_id=$get_current_station_id&amp;l=$l\">$get_current_station_title</a>
						&gt;
						<a href=\"jour.php?station_id=$get_current_station_id&amp;l=$l\">$l_jour</a>
						</p>
						<!-- //Where am I ? -->

						<!-- Navigation -->	
						<p>
						<a href=\"edit_station_members.php?district_id=$get_current_district_id&amp;station_id=$get_current_station_id&amp;l=$l\" class=\"btn_default\">$l_members</a>
						
						<a href=\"$root/_admin/index.php?open=edb&amp;page=station_jour&amp;action=open_station&amp;station_id=$get_current_station_id&amp;editor_language=$l&amp;l=$l\" class=\"btn_default\">$l_edit_jour</a>
						</p>
						<div style=\"height: 10px;\"></div>
						<!-- //Navigation -->
					
						<!-- Jour -->
						<table class=\"hor-zebra\">
						 <thead>
						  <tr>
						   <th scope=\"col\">
							<span>$l_year_week</span>
						   </th>
						   <th scope=\"col\">
							<span>$l_date</span>
						   </th>
						   <th scope=\"col\">
							<span>$l_user</span>
						   </th>
						   <th scope=\"col\">
							<span>$l_email</span>
						   </th>
						   <th scope=\"col\">
							<span>$l_phone</span>
						   </th>
						  </tr>
						 </thead>
						 <tbody>

						";
						$monday_time = strtotime('last monday', strtotime('tomorrow'));
						$monday_time = strtotime('last monday', $monday_time);
						$monday_date_ymd = date('Y-m-d', $monday_time);
						$query = "SELECT jour_id, jour_station_id, jour_station_title, jour_year_week, jour_year, jour_week, jour_from_date, jour_from_date_saying, jour_from_date_ddmmyy, jour_user_id, jour_user_name, jour_user_alias, jour_user_first_name, jour_user_middle_name, jour_user_last_name, jour_user_email, jour_user_phone, jour_user_image_path, jour_user_image_file, jour_user_image_thumb_40, jour_user_image_thumb_50 FROM $t_edb_stations_jour WHERE jour_station_id=$get_current_station_id AND jour_from_date > '$monday_date_ymd' ORDER BY jour_from_date ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_jour_id, $get_jour_station_id, $get_jour_station_title, $get_jour_year_week, $get_jour_year, $get_jour_week, $get_jour_from_date, $get_jour_from_date_saying, $get_jour_from_date_ddmmyy, $get_jour_user_id, $get_jour_user_name, $get_jour_user_alias, $get_jour_user_first_name, $get_jour_user_middle_name, $get_jour_user_last_name, $get_jour_user_email, $get_jour_user_phone, $get_jour_user_image_path, $get_jour_user_image_file, $get_jour_user_image_thumb_40, $get_jour_user_image_thumb_50) = $row;
			

							if(isset($odd) && $odd == false){
								$odd = true;
							}
							else{
								$odd = false;
							}

							echo"
							<tr>
							  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
								<span>$get_jour_year/$get_jour_week</span>
							  </td>
							  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
								<span>$get_jour_from_date_ddmmyy</span>
							  </td>
							  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
								<table>
								 <tr>
								  <td style=\"padding-right: 4px;text-align: left;\">
									<a href=\"view_profile_and_update_profile_link.php?user_id=$get_jour_user_id&amp;l=$l\">";
									if($get_jour_user_image_thumb_40 != ""){
										if($get_jour_user_image_file != "" && file_exists("$root/$get_jour_user_image_path/$get_jour_user_image_file") && !(file_exists("$root/$get_jour_user_image_path/$get_jour_user_image_thumb_40"))){
											resize_crop_image(40, 40, "$root/$get_jour_user_image_path/$get_jour_user_image_file", "$root/$get_jour_user_image_path/$get_jour_user_image_thumb_40");
										}
									}
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
									<a href=\"view_profile_and_update_profile_link.php?user_id=$get_jour_user_id&amp;l=$l\">$get_jour_user_first_name $get_jour_user_middle_name $get_jour_user_last_name</a><br />
								  </td>
								 </tr>
								</table>
							  </td>
							  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
								<span>$get_jour_user_email</span>
							  </td>
							  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
								<span>$get_jour_user_phone</span>
							  </td>
							 </tr>
							";
						}
						echo"
						  </tr>
						 </tbody>
						</table>
					
						<!-- //Jour -->
						";
					} // action == ""
				} // access to station
			} // station found
		} // district found
	} // Station view ($station_id != "")
	else{
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
			$website_title = "$l_edb - $get_current_district_title - $l_jour";
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
			list($get_my_district_member_id, $get_my_district_member_district_id, $get_my_district_member_district_title, $get_my_district_member_user_id, $get_my_district_member_rank, $get_my_district_member_user_name, $get_my_district_member_user_alias, $get_my_district_member_user_first_name, $get_my_district_member_user_middle_name, $get_my_district_member_user_last_name, $get_my_district_member_user_email, $get_my_district_member_user_image_path, $get_my_district_member_user_image_file, $get_my_district_member_user_image_thumb_40, $get_my_district_member_user_image_thumb_50, $get_my_district_member_user_image_thumb_60, $get_my_district_member_user_image_thumb_200, $get_my_district_member_user_position, $get_my_district_member_user_department, $get_my_district_member_user_location, $get_my_district_member_user_about, $get_my_district_member_added_datetime, $get_my_district_member_added_date_saying, $get_my_district_member_added_by_user_id, $get_my_district_member_added_by_user_name, $get_my_district_member_added_b_user_alias, $get_my_district_member_added_by_user_image) = $row;

			if($get_my_district_member_id == ""){
				echo"
				<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> Please apply for access to this district..</h1>
				<meta http-equiv=\"refresh\" content=\"3;url=browse_districts_and_stations.php?action=apply_for_membership_to_district&amp;district_id=$get_current_district_id&amp;l=$l\">
				";
			} // access to district denied
			else{
				if($action == ""){
					echo"
					<h1>$get_current_district_title $l_jour</h1>

					<!-- Where am I ? -->	
						<p><b>$l_you_are_here:</b><br />
						<a href=\"index.php?l=$l\">$l_edb</a>
						&gt;
						<a href=\"cases_board_1_view_district.php?district_id=$get_current_district_id&amp;l=$l\">$get_current_district_title</a>
						&gt;
						<a href=\"jour.php?district_id=$get_current_district_id&amp;l=$l\">$l_jour</a>
						</p>
					<!-- //Where am I ? -->

					<!-- Navigation -->	
						<p>
						<a href=\"edit_district_members.php?district_id=$get_current_district_id&amp;district_id=$get_current_district_id&amp;l=$l\" class=\"btn_default\">$l_members</a>
						
						<a href=\"$root/_admin/index.php?open=edb&amp;page=district_jour&amp;action=open_district&amp;district_id=$get_current_district_id&amp;editor_language=$l&amp;l=$l\" class=\"btn_default\">$l_edit_jour</a>
						</p>
						<div style=\"height: 10px;\"></div>
					<!-- //Navigation -->
					
					<!-- Jour -->
						<table class=\"hor-zebra\">
						 <thead>
						  <tr>
						   <th scope=\"col\">
							<span>$l_year_week</span>
						   </th>
						   <th scope=\"col\">
							<span>$l_date</span>
						   </th>
						   <th scope=\"col\">
							<span>$l_user</span>
						   </th>
						   <th scope=\"col\">
							<span>$l_email</span>
						   </th>
						   <th scope=\"col\">
							<span>$l_phone</span>
						   </th>
						  </tr>
						 </thead>
						 <tbody>

						";
						$monday_time = strtotime('last monday', strtotime('tomorrow'));
						$monday_time = strtotime('last monday', $monday_time);
						$monday_date_ymd = date('Y-m-d', $monday_time);
						$query = "SELECT jour_id, jour_district_id, jour_district_title, jour_year_week, jour_year, jour_week, jour_from_date, jour_from_date_saying, jour_from_date_ddmmyy, jour_user_id, jour_user_name, jour_user_alias, jour_user_first_name, jour_user_middle_name, jour_user_last_name, jour_user_email, jour_user_phone, jour_user_image_path, jour_user_image_file, jour_user_image_thumb_40, jour_user_image_thumb_50 FROM $t_edb_districts_jour WHERE jour_district_id=$get_current_district_id AND jour_from_date > '$monday_date_ymd' ORDER BY jour_from_date ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_jour_id, $get_jour_district_id, $get_jour_district_title, $get_jour_year_week, $get_jour_year, $get_jour_week, $get_jour_from_date, $get_jour_from_date_saying, $get_jour_from_date_ddmmyy, $get_jour_user_id, $get_jour_user_name, $get_jour_user_alias, $get_jour_user_first_name, $get_jour_user_middle_name, $get_jour_user_last_name, $get_jour_user_email, $get_jour_user_phone, $get_jour_user_image_path, $get_jour_user_image_file, $get_jour_user_image_thumb_40, $get_jour_user_image_thumb_50) = $row;
			

							if(isset($odd) && $odd == false){
								$odd = true;
							}
							else{
								$odd = false;
							}

							echo"
							<tr>
							  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
								<span>$get_jour_year/$get_jour_week</span>
							  </td>
							  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
								<span>$get_jour_from_date_ddmmyy</span>
							  </td>
							  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
								
								<table>
								 <tr>
								  <td style=\"padding-right: 4px;text-align: left;\">
									<a href=\"view_profile_and_update_profile_link.php?user_id=$get_jour_user_id&amp;l=$l\">";
									if($get_jour_user_image_thumb_40 != ""){
										if($get_jour_user_image_file != "" && file_exists("$root/$get_jour_user_image_path/$get_jour_user_image_file") && !(file_exists("$root/$get_jour_user_image_path/$get_jour_user_image_thumb_40"))){
											resize_crop_image(40, 40, "$root/$get_jour_user_image_path/$get_jour_user_image_file", "$root/$get_jour_user_image_path/$get_jour_user_image_thumb_40");
										}
									}
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
									<a href=\"view_profile_and_update_profile_link.php?user_id=$get_jour_user_id&amp;l=$l\">$get_jour_user_first_name $get_jour_user_middle_name $get_jour_user_last_name</a><br />
								  </td>
								 </tr>
								</table>
							  </td>
							  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
								<span>$get_jour_user_email</span>
							  </td>
							  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
								<span>$get_jour_user_phone</span>
							  </td>
							 </tr>
							";
						}
						echo"
						  </tr>
						 </tbody>
						</table>
					
						<!-- //Jour -->
						";
				} // action == ""
			} // access to district
		} // district found
	} // District view (// station == "")


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