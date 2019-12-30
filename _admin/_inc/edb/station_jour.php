<?php
/**
*
* File: _admin/_inc/edb/station_jour.php
* Version 11:55 30.12.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}
/*- Tables ---------------------------------------------------------------------------- */
$t_edb_case_index		= $mysqlPrefixSav . "edb_case_index";
$t_edb_case_codes		= $mysqlPrefixSav . "edb_case_codes";
$t_edb_case_statuses		= $mysqlPrefixSav . "edb_case_statuses";
$t_edb_case_priorities		= $mysqlPrefixSav . "edb_case_priorities";

$t_edb_districts_index		= $mysqlPrefixSav . "edb_districts_index";
$t_edb_districts_members	= $mysqlPrefixSav . "edb_districts_members";

$t_edb_stations_index		= $mysqlPrefixSav . "edb_stations_index";
$t_edb_stations_members		= $mysqlPrefixSav . "edb_stations_members";
$t_edb_stations_directories	= $mysqlPrefixSav . "edb_stations_directories";
$t_edb_stations_jour		= $mysqlPrefixSav . "edb_stations_jour";

$t_edb_software_index	= $mysqlPrefixSav . "edb_software_index";

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['station_id'])) {
	$station_id = $_GET['station_id'];
	$station_id = strip_tags(stripslashes($station_id));
}
else{
	$station_id = "";
}
if(isset($_GET['jour_id'])) {
	$jour_id = $_GET['jour_id'];
	$jour_id = strip_tags(stripslashes($jour_id));
}
else{
	$jour_id = "";
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


if($action == ""){
	echo"
	<h1>Stations directories</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Station jour</a>
		</p>
	<!-- //Where am I? -->

	<!-- Feedback -->
		";
		if($ft != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			else{
				$fm = str_replace("_", " ", $fm);
				$fm = ucfirst($fm);
			}
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
	<!-- //Feedback -->



	<!-- Left and right side -->
		<table style=\"width: 100%;\">
		 <tr>
		  <td style=\"width: 150px;vertical-align:top;\">
			<!-- Left side Locations -->
				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
					<span><b>Locations</b></span>
				   </th>
				  </tr>
				 </thead>
				 <tbody id=\"autosearch_search_results_hide\">

					";

					$query = "SELECT station_id, station_title, station_title_clean, station_number_of_cases_now FROM $t_edb_stations_index ORDER BY station_title ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_station_id, $get_station_title, $get_station_title_clean, $get_station_number_of_cases_now) = $row;
			
						// Style
						if(isset($style) && $style == ""){
							$style = "odd";
						}
						else{
							$style = "";
						}

						echo"
						 <tr>
						  <td class=\"$style\">
							<span>
							<a href=\"index.php?open=$open&amp;page=$page&amp;action=open_station&amp;station_id=$get_station_id&amp;l=$l&amp;editor_language=$editor_language\">$get_station_title</a>
							</span>
						  </td>
						 </tr>";
					} // while
		
				echo"
				 </tbody>
				</table>
			<!-- //Left side Locations -->
		  </td>
		  <td style=\"padding-left:20px;vertical-align: top;\">

			<!-- Right side jour-->
				
			<!-- //Right side jour -->
		  </td>
		 </tr>
		</table>
	<!-- //Left and right side -->
	";
} // action == ""
elseif($action == "open_station"){
	// Find station
	$station_id_mysql = quote_smart($link, $station_id);
	$query = "SELECT station_id, station_number, station_title, station_title_clean, station_district_id, station_district_title, station_icon_path, station_icon_16, station_icon_32, station_icon_260, station_number_of_cases_now FROM $t_edb_stations_index WHERE station_id=$station_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_station_id, $get_current_station_number, $get_current_station_title, $get_current_station_title_clean, $get_current_station_district_id, $get_current_station_district_title, $get_current_station_icon_path, $get_current_station_icon_16, $get_current_station_icon_32, $get_current_station_icon_260, $get_current_station_number_of_cases_now) = $row;
	
	if($get_current_station_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		echo"
		<h1>Stations jour</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Station jour</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_station_title</a>
			</p>
		<!-- //Where am I? -->

		<!-- Feedback -->
			";
			if($ft != ""){
				if($fm == "changes_saved"){
					$fm = "$l_changes_saved";
				}
				else{
					$fm = str_replace("_", " ", $fm);
					$fm = ucfirst($fm);
				}
				echo"<div class=\"$ft\"><span>$fm</span></div>";
			}
			echo"	
		<!-- //Feedback -->



		<!-- Left and right side -->
		<table style=\"width: 100%;\">
		 <tr>
		  <td style=\"width: 150px;vertical-align:top;\">
			<!-- Left side Locations -->
				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
					<span><b>Locations</b></span>
				   </th>
				  </tr>
				 </thead>
				 <tbody id=\"autosearch_search_results_hide\">

					";
					$query = "SELECT station_id, station_title, station_title_clean, station_number_of_cases_now FROM $t_edb_stations_index ORDER BY station_title ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_station_id, $get_station_title, $get_station_title_clean, $get_station_number_of_cases_now) = $row;
			
			
						// Style
						if(isset($style) && $style == ""){
							$style = "odd";
						}
						else{
							$style = "";
						}

						echo"
						 <tr>
						  <td class=\"$style\">
							<span>
							<a href=\"index.php?open=$open&amp;page=$page&amp;action=open_station&amp;station_id=$get_station_id&amp;l=$l&amp;editor_language=$editor_language\""; if($get_station_id == "$get_current_station_id"){ echo" style=\"font-weight: bold;\""; } echo">$get_station_title</a>
							</span>
						  </td>
						 </tr>";
					} // while
		
				echo"
				 </tbody>
				</table>
			<!-- //Left side Locations -->
		  </td>
		  <td style=\"padding-left:20px;vertical-align: top;\">

			<p>
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=auto_create_one_year&amp;station_id=$get_current_station_id&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">Auto create for one year</a>
			<a href=\"../edb/edit_station_members.php?station_id=$get_current_station_id&amp;l=$l\" class=\"btn_default\" target=\"_blank\">Edit station members</a>
			</p>

			<!-- Right side jour -->
				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">";
					if($order_by == "jour_year_week" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;order_by=jour_year_week&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Year/week</b></a>";
					if($order_by == "jour_year_week" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					if($order_by == "jour_year_week" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == ""){
						$order_by = "jour_from_date";
					}
					if($order_by == "jour_from_date" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;order_by=jour_from_date&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Date from</b></a>";
					if($order_by == "jour_from_date" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					if($order_by == "jour_from_date" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "jour_user_first_name" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;order_by=jour_user_first_name&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Name</b></a>";
					if($order_by == "jour_user_first_name" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					if($order_by == "jour_user_first_name" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "jour_user_name" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;order_by=jour_user_name&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>User name</b></a>";
					if($order_by == "jour_user_name" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					if($order_by == "jour_user_name" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">
					<span><b>E-mail</b></span>
				   </th>
				   <th scope=\"col\">
					<span><b>Phone</b></span>
				   </th>
				   <th scope=\"col\">
					<span><b>Actions</b></span>
				   </th>
				  </tr>
				 </thead>
				 <tbody>

					";

				$query = "SELECT jour_id, jour_station_id, jour_station_title, jour_year_week, jour_week, jour_year, jour_from_date, jour_from_date_saying, jour_from_date_ddmmyy, jour_user_id, jour_user_name, jour_user_alias, jour_user_first_name, jour_user_middle_name, jour_user_last_name, jour_user_email, jour_user_phone, jour_user_image_path, jour_user_image_file, jour_user_image_thumb_40, jour_user_image_thumb_50 FROM $t_edb_stations_jour WHERE jour_station_id=$get_current_station_id";
				if($order_by == "jour_year_week" OR $order_by == "jour_from_date" OR $order_by == "jour_user_first_name" OR $order_by == "jour_user_name"){
					if($order_method  == "asc" OR $order_method == "desc"){
						$query = $query  . " ORDER BY $order_by $order_method";
					}
				}
				else{
					$query = $query  . " ORDER BY jour_id ASC";
				}
				$query = $query  . " LIMIT 0,200";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_jour_id, $get_jour_station_id, $get_jour_station_title, $get_jour_year_week, $get_jour_week, $get_jour_year, $get_jour_from_date, $get_jour_from_date_saying, $get_jour_from_date_ddmmyy, $get_jour_user_id, $get_jour_user_name, $get_jour_user_alias, $get_jour_user_first_name, $get_jour_user_middle_name, $get_jour_user_last_name, $get_jour_user_email, $get_jour_user_phone, $get_jour_user_image_path, $get_jour_user_image_file, $get_jour_user_image_thumb_40, $get_jour_user_image_thumb_50) = $row;
			
						// Style
						if(isset($style) && $style == ""){
							$style = "odd";
						}
						else{
							$style = "";
						}

						echo"
						 <tr>
						  <td class=\"$style\">
							<span>
							<a id=\"jour_id$get_jour_id\"></a>
							$get_jour_year/$get_jour_week
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_jour_from_date_ddmmyy
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_jour_user_first_name $get_jour_user_middle_name $get_jour_user_last_name
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_jour_user_name
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_jour_user_email
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_jour_user_phone
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							<a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_jour&amp;jour_id=$get_jour_id&amp;editor_language=$editor_language&amp;l=$l\">Edit</a>
							</span>
						  </td>
						 </tr>";
					} // while
		
				echo"
				 </tbody>
				</table>
			<!-- //Right side jour -->
		  </td>
		 </tr>
		</table>
		<!-- //Left and right side -->
		";
	} // physical_location_found
} // action == "open_physical_location"
elseif($action == "auto_create_one_year"){
	// Find station
	$station_id_mysql = quote_smart($link, $station_id);
	$query = "SELECT station_id, station_number, station_title, station_title_clean, station_district_id, station_district_title, station_icon_path, station_icon_16, station_icon_32, station_icon_260, station_number_of_cases_now FROM $t_edb_stations_index WHERE station_id=$station_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_station_id, $get_current_station_number, $get_current_station_title, $get_current_station_title_clean, $get_current_station_district_id, $get_current_station_district_title, $get_current_station_icon_path, $get_current_station_icon_16, $get_current_station_icon_32, $get_current_station_icon_260, $get_current_station_number_of_cases_now) = $row;
	
	if($get_current_station_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

		$date_yymmdd = date("Y-m-d");
		$week = date("W");
		$time = strtotime('last monday', strtotime('tomorrow'));


		echo"
		<!-- Now -->
			<h2>Now</h2>
			<table>
			 <tr>
			  <td style=\"padding-right: 4px;\">
				<span>Current date:</span>
			  </td>
			  <td>
				<span>$date_yymmdd</span>
			  </td>
			 </tr>
			 <tr>
			  <td style=\"padding-right: 4px;\">
				<span>Current week:</span>
			  </td>
			  <td>
				<span>$week</span>
			  </td>
			 </tr>
			</table>

		<!-- //Now -->
";

echo"
		<!-- Next 52 weeks -->
			<h2>Next 52 weeks</h2>$date_yymmdd 

			<table>
				 <tr>
				  <td style=\"padding-right: 4px;\">
					<span>Year</span>
				  </td>
				  <td>
					<span>Week</span>
				  </td>
				  <td style=\"padding-right: 4px;\">
					<span>Date</span>
				  </td>
				  <td style=\"padding-right: 4px;\">
					<span>User</span>
				  </td>
				 </tr>
			";
			for($x=0;$x<52;$x++){
				$date_yymmdd = date('Y-m-d', $time);
				$date_ddmmyy = date('d.m.y', $time);
				$date_saying = date('d. M Y', $time);
				$week = date('W', $time);
				$year = date('Y', $time);


				echo"
				 <tr>
				  <td style=\"padding-right: 4px;\">
					<span>$year</span>
				  </td>
				  <td style=\"padding-right: 4px;\">
					<span>$week</span>
				  </td>
				  <td style=\"padding-right: 4px;\">
					<span>$date_yymmdd</span>
				  </td>
				  <td style=\"padding-right: 4px;\">
					<p>
				";

				// Check if entry exists
				$query_j = "SELECT jour_id, jour_user_id, jour_user_name FROM $t_edb_stations_jour WHERE jour_station_id=$station_id_mysql AND jour_year=$year AND jour_week=$week";
				$result_j = mysqli_query($link, $query_j);
				$row_j = mysqli_fetch_row($result_j);
				list($get_jour_id, $get_jour_user_id, $get_jour_user_name) = $row_j;
				if($get_jour_id == ""){
					// Find a member to be jour
					if(isset($last_week_station_member_id)){
						$query = "SELECT station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_phone, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60, station_member_user_image_thumb_200, station_member_user_position, station_member_user_department, station_member_user_location, station_member_user_about, station_member_added_datetime, station_member_added_date_saying, station_member_added_by_user_id, station_member_added_by_user_name, station_member_added_by_user_alias, station_member_added_by_user_image FROM $t_edb_stations_members WHERE station_member_id > $last_week_station_member_id AND station_member_station_id=$get_current_station_id AND station_member_can_be_jour='1'";
					}
					else{
						$query = "SELECT station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_phone, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60, station_member_user_image_thumb_200, station_member_user_position, station_member_user_department, station_member_user_location, station_member_user_about, station_member_added_datetime, station_member_added_date_saying, station_member_added_by_user_id, station_member_added_by_user_name, station_member_added_by_user_alias, station_member_added_by_user_image FROM $t_edb_stations_members WHERE station_member_station_id=$get_current_station_id AND station_member_can_be_jour='1'";
					}
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_station_member_id, $get_station_member_station_id, $get_station_member_station_title, $get_station_member_district_id, $get_station_member_district_title, $get_station_member_user_id, $get_station_member_rank, $get_station_member_user_name, $get_station_member_user_alias, $get_station_member_first_name, $get_station_member_middle_name, $get_station_member_last_name, $get_station_member_user_email, $get_station_member_user_phone, $get_station_member_user_image_path, $get_station_member_user_image_file, $get_station_member_user_image_thumb_40, $get_station_member_user_image_thumb_50, $get_station_member_user_image_thumb_60, $get_station_member_user_image_thumb_200, $get_station_member_user_position, $get_station_member_user_department, $get_station_member_user_location, $get_station_member_user_about, $get_station_member_added_datetime, $get_station_member_added_date_saying, $get_station_member_added_by_user_id, $get_station_member_added_by_user_name, $get_station_member_added_by_user_alias, $get_station_member_added_by_user_image) = $row;
				
					if($get_station_member_id == ""){
						// Start over again
						$query = "SELECT station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_phone, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60, station_member_user_image_thumb_200, station_member_user_position, station_member_user_department, station_member_user_location, station_member_user_about, station_member_added_datetime, station_member_added_date_saying, station_member_added_by_user_id, station_member_added_by_user_name, station_member_added_by_user_alias, station_member_added_by_user_image FROM $t_edb_stations_members WHERE station_member_station_id=$get_current_station_id AND station_member_can_be_jour='1'";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_station_member_id, $get_station_member_station_id, $get_station_member_station_title, $get_station_member_district_id, $get_station_member_district_title, $get_station_member_user_id, $get_station_member_rank, $get_station_member_user_name, $get_station_member_user_alias, $get_station_member_first_name, $get_station_member_middle_name, $get_station_member_last_name, $get_station_member_user_email, $get_station_member_user_phone, $get_station_member_user_image_path, $get_station_member_user_image_file, $get_station_member_user_image_thumb_40, $get_station_member_user_image_thumb_50, $get_station_member_user_image_thumb_60, $get_station_member_user_image_thumb_200, $get_station_member_user_position, $get_station_member_user_department, $get_station_member_user_location, $get_station_member_user_about, $get_station_member_added_datetime, $get_station_member_added_date_saying, $get_station_member_added_by_user_id, $get_station_member_added_by_user_name, $get_station_member_added_by_user_alias, $get_station_member_added_by_user_image) = $row;

					}


					if($get_station_member_id != ""){

						$inp_station_title_mysql = quote_smart($link, $get_current_station_title);
						$inp_year_week = $year . $week;


						$inp_user_name_mysql = quote_smart($link, $get_station_member_user_name);
						$inp_user_alias_mysql = quote_smart($link, $get_station_member_user_alias);
						$inp_user_first_name_mysql = quote_smart($link, $get_station_member_first_name);
						$inp_user_middle_name_mysql = quote_smart($link, $get_station_member_middle_name);
						$inp_user_last_name_mysql = quote_smart($link, $get_station_member_last_name);
						$inp_user_email_mysql = quote_smart($link, $get_station_member_user_email);
						$inp_user_phone_mysql = quote_smart($link, $get_station_member_user_phone);

						$inp_user_image_path_mysql = quote_smart($link, $get_station_member_user_image_path);
						$inp_user_image_file_mysql = quote_smart($link, $get_station_member_user_image_file);
						$inp_user_image_thumb_40_mysql = quote_smart($link, $get_station_member_user_image_thumb_40);
						$inp_user_image_thumb_50_mysql = quote_smart($link, $get_station_member_user_image_thumb_50);

						// Insert
						mysqli_query($link, "INSERT INTO $t_edb_stations_jour 
						(jour_id, jour_station_id, jour_station_title, jour_year_week, jour_year, jour_week, jour_from_date, jour_from_date_saying, jour_from_date_ddmmyy, jour_user_id, jour_user_name, jour_user_alias, jour_user_first_name, jour_user_middle_name, jour_user_last_name, jour_user_email, jour_user_phone, jour_user_image_path, jour_user_image_file, jour_user_image_thumb_40, jour_user_image_thumb_50) 
						VALUES 
						(NULL, $get_current_station_id, $inp_station_title_mysql, '$inp_year_week', '$year', '$week', '$date_yymmdd', '$date_saying', '$date_ddmmyy', $get_station_member_user_id, $inp_user_name_mysql, $inp_user_alias_mysql, $inp_user_first_name_mysql, $inp_user_middle_name_mysql, $inp_user_last_name_mysql, $inp_user_email_mysql, $inp_user_phone_mysql, $inp_user_image_path_mysql, $inp_user_image_file_mysql, $inp_user_image_thumb_40_mysql, $inp_user_image_thumb_50_mysql)")
						or die(mysqli_error($link));

						// Transfer to table
						$get_jour_user_name = "$get_station_member_user_name";
					}


					// Transfer to next x
					$last_week_station_member_id = "$get_station_member_id";
				}
				echo"$get_jour_user_name</p>
				  </td>
				 </tr>
				";

	
				// Increment time
				$time = strtotime("+7 day", $time);
			}
			echo"
			</table>
		<!-- //Next 52 weeks -->
			";


	} // station found
} // action == "auto_create_one_year"
elseif($action == "edit_jour"){
	// Find jour
	$jour_id_mysql = quote_smart($link, $jour_id);
	$query = "SELECT jour_id, jour_station_id, jour_station_title, jour_year_week, jour_year, jour_week, jour_from_date, jour_from_date_saying, jour_from_date_ddmmyy, jour_user_id, jour_user_name, jour_user_alias, jour_user_first_name, jour_user_middle_name, jour_user_last_name, jour_user_email, jour_user_image_path, jour_user_image_file, jour_user_image_thumb_40, jour_user_image_thumb_50 FROM $t_edb_stations_jour WHERE jour_id=$jour_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_jour_id, $get_current_jour_station_id, $get_current_jour_station_title, $get_current_jour_year_week, $get_current_jour_year, $get_current_jour_week, $get_current_jour_from_date, $get_current_jour_from_date_saying, $get_current_jour_from_date_ddmmyy, $get_current_jour_user_id, $get_current_jour_user_name, $get_current_jour_user_alias, $get_current_jour_user_first_name, $get_current_jour_user_middle_name, $get_current_jour_user_last_name, $get_current_jour_user_email, $get_current_jour_user_image_path, $get_current_jour_user_image_file, $get_current_jour_user_image_thumb_40, $get_current_jour_user_image_thumb_50) = $row;
	
	if($get_current_jour_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		if($process == "1"){

			$inp_user_name = $_POST['inp_user_name'];
			$inp_user_name = output_html($inp_user_name);
			$inp_user_name_mysql = quote_smart($link, $inp_user_name);


			// Fetch user profile
			$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_name=$inp_user_name_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_user_id, $get_user_email, $get_user_name, $get_user_alias, $get_user_language, $get_user_last_online, $get_user_rank, $get_user_login_tries) = $row;
			if($get_user_id == ""){
				$url = "index.php?open=edb&page=station_jour&action=edit_jour&jour_id=$get_current_jour_id&editor_language=$editor_language&l=$l&ft=error&fm=user_not_found";
				header("Location: $url");
				die;
			}
	
			// Get photo
			$query = "SELECT photo_id, photo_user_id, photo_profile_image, photo_title, photo_destination, photo_thumb_40, photo_thumb_50, photo_thumb_60, photo_thumb_200, photo_uploaded, photo_uploaded_ip, photo_views, photo_views_ip_block, photo_likes, photo_comments, photo_x_offset, photo_y_offset, photo_text FROM $t_users_profile_photo WHERE photo_user_id=$get_user_id AND photo_profile_image='1'";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_photo_id, $get_photo_user_id, $get_photo_profile_image, $get_photo_title, $get_photo_destination, $get_photo_thumb_40, $get_photo_thumb_50, $get_photo_thumb_60, $get_photo_thumb_200, $get_photo_uploaded, $get_photo_uploaded_ip, $get_photo_views, $get_photo_views_ip_block, $get_photo_likes, $get_photo_comments, $get_photo_x_offset, $get_photo_y_offset, $get_photo_text) = $row;

			// Get Profile
			$query = "SELECT profile_id, profile_first_name, profile_middle_name, profile_last_name, profile_about FROM $t_users_profile WHERE profile_user_id=$get_user_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_profile_id, $get_profile_first_name, $get_profile_middle_name, $get_profile_last_name, $get_profile_about) = $row;
	
			$inp_user_name_mysql = quote_smart($link, $get_user_name);
			$inp_user_alias_mysql = quote_smart($link, $get_user_alias);
			$inp_user_first_name_mysql = quote_smart($link, $get_profile_first_name);
			$inp_user_middle_name_mysql = quote_smart($link, $get_profile_middle_name);
			$inp_user_last_name_mysql = quote_smart($link, $get_profile_last_name);
			$inp_user_email_mysql = quote_smart($link, $get_user_email);

			$inp_user_image_path = "_uploads/users/images/$get_user_id";
			$inp_user_image_path_mysql = quote_smart($link, $inp_user_image_path);
			$inp_user_image_file_mysql = quote_smart($link, $get_photo_destination);
			$inp_user_image_thumb_40_mysql = quote_smart($link, $get_photo_thumb_40);
			$inp_user_image_thumb_50_mysql = quote_smart($link, $get_photo_thumb_50);

			// Update
			$result = mysqli_query($link, "UPDATE $t_edb_stations_jour SET 
jour_user_id=$get_user_id, 
jour_user_name=$inp_user_name_mysql,
jour_user_alias=$inp_user_alias_mysql,
jour_user_first_name=$inp_user_first_name_mysql, 
jour_user_middle_name=$inp_user_middle_name_mysql, 
jour_user_last_name=$inp_user_last_name_mysql,
jour_user_email=$inp_user_email_mysql,
jour_user_image_path=$inp_user_image_path_mysql, 
jour_user_image_file=$inp_user_image_file_mysql, 
jour_user_image_thumb_40=$inp_user_image_thumb_40_mysql, 
jour_user_image_thumb_50=$inp_user_image_thumb_50_mysql 
 WHERE jour_id=$get_current_jour_id") or die(mysqli_error($link));


			$url = "index.php?open=edb&page=$page&action=open_station&station_id=$get_current_jour_station_id&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=saved#jour_id$get_current_jour_id";
			header("Location: $url");
			exit;
		}

		echo"
		<h1>Jour $get_current_jour_station_title $get_current_jour_year/$get_current_jour_week</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Station jour</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=open_station&amp;station_id=$get_current_jour_station_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_jour_station_title</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;jour_id=$get_current_jour_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_jour_year/$get_current_jour_week</a>
			</p>
		<!-- //Where am I? -->
	
	

		<!-- Feedback -->
		";
		if($ft != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			else{
				$fm = str_replace("_", " ", $fm);
				$fm = ucfirst($fm);
			}
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
		<!-- //Feedback -->

		<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_user_name\"]').focus();
			});
			</script>
		<!-- //Focus -->

		<!-- Edit form -->
			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;jour_id=$get_current_jour_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p>User name:<br />
			<input type=\"text\" name=\"inp_user_name\" value=\"$get_current_jour_user_name\" size=\"25\" />
			</p>


			<p>
			<input type=\"submit\" value=\"Save changes\" class=\"btn_default\" />
			</p>
			</form>
		<!-- //Edit form -->

		";
	} // jour found
} // edit_jour
?>