<?php
/**
*
* File: _admin/_inc/edb/machines.php
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


$t_edb_machines_index				= $mysqlPrefixSav . "edb_machines_index";
$t_edb_machines_types				= $mysqlPrefixSav . "edb_machines_types";
$t_edb_machines_all_tasks_available		= $mysqlPrefixSav . "edb_machines_all_tasks_available";
$t_edb_machines_all_tasks_available_to_item  	= $mysqlPrefixSav . "edb_machines_all_tasks_available_to_item";


/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['station_id'])) {
	$station_id = $_GET['station_id'];
	$station_id = strip_tags(stripslashes($station_id));
}
else{
	$station_id = "";
}
if(isset($_GET['machine_id'])) {
	$machine_id = $_GET['machine_id'];
	$machine_id = strip_tags(stripslashes($machine_id));
}
else{
	$machine_id = "";
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
	<h1>Stations machines</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Machines</a>
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

			<!-- Right side machines -->
				
			<p>
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=new&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">New machine</a>
			</p>

				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">";
					if($order_by == ""){
						$order_by = "machine_id";
					}
					if($order_by == "machine_id" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=machine_id&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>ID</b></a>";
					if($order_by == "machine_id" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					elseif($order_by == "machine_id" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "machine_name" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=machine_name&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Name</b></a>";
					if($order_by == "machine_name" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					elseif($order_by == "machine_name" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "machine_type_title" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=machine_type_title&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Type</b></a>";
					if($order_by == "machine_type_title" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					elseif($order_by == "machine_type_title" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "machine_os" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=machine_os&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Os</b></a>";
					if($order_by == "machine_os" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					elseif($order_by == "machine_os" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "machine_ip" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=machine_ip&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>IP and MAC</b></a>";
					if($order_by == "machine_ip" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					elseif($order_by == "machine_ip" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "machine_key" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=machine_key&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Key</b></a>";
					if($order_by == "machine_key" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					elseif($order_by == "machine_key" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "machine_last_seen_datetime" && $order_method == "asc"){
						$order_method_description = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=machine_last_seen_datetime&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Last seen</b></a>";
					if($order_by == "machine_last_seen_datetime" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					elseif($order_by == "machine_last_seen_datetime" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "machine_is_working_with_automated_task_id" && $order_method == "asc"){
						$order_method_description = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=machine_is_working_with_automated_task_id&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Task</b></a>";
					if($order_by == "machine_is_working_with_automated_task_id" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					elseif($order_by == "machine_is_working_with_automated_task_id" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">
					<span><b>Actions</b></span>
				   </th>
				  </tr>
				 </thead>
				 <tbody>

					";

					$query = "SELECT machine_id, machine_name, machine_type_id, machine_type_title, machine_os, machine_ip, machine_mac, machine_key, machine_description, machine_station_id, machine_station_title, machine_last_seen_datetime, machine_last_seen_time, machine_last_seen_ddmmyyhi, machine_last_seen_ddmmyyyyhi, machine_is_working_with_automated_task_id, machine_started_working_datetime, machine_started_working_time, machine_started_working_ddmmyyhi, machine_started_working_ddmmyyyyhi FROM $t_edb_machines_index";
					if($order_by == "machine_id" OR $order_by == "machine_name" OR $order_by == "machine_type_title" OR $order_by == "machine_os" OR $order_by == "machine_ip" OR $order_by == "machine_mac" OR $order_by == "machine_key" OR $order_by == "machine_description" OR $order_by == "machine_station_id" OR $order_by == "machine_station_title" OR $order_by == "machine_last_seen_datetime" OR $order_by == "machine_last_seen_time" OR $order_by == "machine_last_seen_dmyhi" OR $order_by == "machine_is_working_with_automated_task_id" OR $order_by == "machine_started_working_datetime" OR $order_by == "machine_started_working_time" OR $order_by == "machine_started_working_dmyhi"){
						if($order_method  == "asc" OR $order_method == "desc"){
							$query = $query  . " ORDER BY $order_by $order_method";
						}
					}
					else{
						$query = $query  . " ORDER BY machine_name ASC";
					}
					$query = $query  . " LIMIT 0,200";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_machine_id, $get_machine_name, $get_machine_type_id, $get_machine_type_title, $get_machine_os, $get_machine_ip, $get_machine_mac, $get_machine_key, $get_machine_description, $get_machine_station_id, $get_machine_station_title, $get_machine_last_seen_datetime, $get_machine_last_seen_time, $get_machine_last_seen_ddmmyyhi, $get_machine_last_seen_ddmmyyyyhi, $get_machine_is_working_with_automated_task_id, $get_machine_started_working_datetime, $get_machine_started_working_time, $get_machine_started_working_ddmmyyhi, $get_machine_started_working_ddmmyyyyhi) = $row;
			
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
							<a id=\"machine_id$get_machine_id\"></a>
							$get_machine_id
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_machine_name<br />
							$get_machine_description
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_machine_type_title
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_machine_os
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_machine_ip<br />
							$get_machine_mac
			
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_machine_key
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_machine_last_seen_ddmmyyhi
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_machine_is_working_with_automated_task_id<br />
							$get_machine_started_working_ddmmyyhi
			
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							<a href=\"../edb/api/01_look_for_new_task.php?machine_key=$get_machine_key\">API</a>
							|
							<a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_machine&amp;machine_id=$get_machine_id&amp;editor_language=$editor_language&amp;l=$l\">Edit</a>
							|
							<a href=\"index.php?open=edb&amp;page=$page&amp;action=delete_machine&amp;machine_id=$get_machine_id&amp;editor_language=$editor_language&amp;l=$l\">Delete</a>
							</span>
						  </td>
						 </tr>";
					} // while
		
				echo"
				 </tbody>
				</table>
			<!-- //Right side machines -->
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
		<h1>Stations Machines</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Machines</a>
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
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=new&amp;station_id=$get_current_station_id&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">New machine</a>
			</p>

			<!-- Right side jour -->
				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">";
					if($order_by == ""){
						$order_by = "machine_id";
					}
					if($order_by == "machine_id" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;order_by=machine_id&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>ID</b></a>";
					if($order_by == "machine_id" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					if($order_by == "machine_id" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "machine_name" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;order_by=machine_name&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Name</b></a>";
					if($order_by == "machine_name" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					elseif($order_by == "machine_name" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "machine_type_title" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;order_by=machine_type_title&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Type</b></a>";
					if($order_by == "machine_type_title" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					if($order_by == "machine_type_title" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "machine_os" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;order_by=machine_os&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>OS</b></a>";
					if($order_by == "machine_os" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					if($order_by == "machine_os" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "machine_ip" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;order_by=machine_ip&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>IP and MAC</b></a>";
					if($order_by == "machine_ip" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					if($order_by == "machine_ip" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "machine_key" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;order_by=machine_key&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Key</b></a>";
					if($order_by == "machine_key" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					if($order_by == "machine_key" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "machine_last_seen_datetime" && $order_method == "asc"){
						$order_method_description = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;order_by=machine_last_seen_datetime&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Last seen</b></a>";
					if($order_by == "machine_last_seen_datetime" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					if($order_by == "machine_last_seen_datetime" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "machine_is_working_with_automated_task_id" && $order_method == "asc"){
						$order_method_description = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;order_by=machine_is_working_with_automated_task_id&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Task</b></a>";
					if($order_by == "machine_is_working_with_automated_task_id" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					if($order_by == "machine_is_working_with_automated_task_id" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">
					<span><b>Actions</b></span>
				   </th>
				  </tr>
				 </thead>
				 <tbody>

					";

					$query = "SELECT machine_id, machine_name, machine_type_id, machine_type_title, machine_os, machine_ip, machine_mac, machine_key, machine_description, machine_station_id, machine_station_title, machine_last_seen_datetime, machine_last_seen_time, machine_last_seen_ddmmyyhi, machine_last_seen_ddmmyyyyhi, machine_is_working_with_automated_task_id, machine_started_working_datetime, machine_started_working_time, machine_started_working_ddmmyyhi, machine_started_working_ddmmyyyyhi FROM $t_edb_machines_index WHERE machine_station_id=$get_current_station_id";
					if($order_by == "machine_id" OR $order_by == "machine_name" OR $order_by == "machine_type_title" OR $order_by == "machine_os" OR $order_by == "machine_ip" OR $order_by == "machine_mac" OR $order_by == "machine_key" OR $order_by == "machine_description" OR $order_by == "machine_station_id" OR $order_by == "machine_station_title" OR $order_by == "machine_last_seen_datetime" OR $order_by == "machine_last_seen_time" OR $order_by == "machine_last_seen_dmyhi" OR $order_by == "machine_is_working_with_automated_task_id" OR $order_by == "machine_started_working_datetime" OR $order_by == "machine_started_working_time" OR $order_by == "machine_started_working_dmyhi"){
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
						list($get_machine_id, $get_machine_name, $get_machine_type_id, $get_machine_type_title, $get_machine_os, $get_machine_ip, $get_machine_mac, $get_machine_key, $get_machine_description, $get_machine_station_id, $get_machine_station_title, $get_machine_last_seen_datetime, $get_machine_last_seen_time, $get_machine_last_seen_ddmmyyhi, $get_machine_last_seen_ddmmyyyyhi, $get_machine_is_working_with_automated_task_id, $get_machine_started_working_datetime, $get_machine_started_working_time, $get_machine_started_working_ddmmyyhi, $get_machine_started_working_ddmmyyyyhi) = $row;
			
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
							<a id=\"machine_id$get_machine_id\"></a>
							$get_machine_id
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_machine_name<br />
							$get_machine_description
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_machine_type_title
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_machine_os
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_machine_ip<br />
							$get_machine_mac
			
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_machine_key
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_machine_last_seen_ddmmyyhi
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_machine_is_working_with_automated_task_id<br />
							$get_machine_started_working_ddmmyyhi
			
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							<a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_machine&amp;machine_id=$get_machine_id&amp;editor_language=$editor_language&amp;l=$l\">Edit</a>
							|
							<a href=\"index.php?open=edb&amp;page=$page&amp;action=delete_machine&amp;machine_id=$get_machine_id&amp;editor_language=$editor_language&amp;l=$l\">Delete</a>
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
elseif($action == "new"){
	// Find station
	$station_id_mysql = quote_smart($link, $station_id);
	$query = "SELECT station_id, station_number, station_title, station_title_clean, station_district_id, station_district_title, station_icon_path, station_icon_16, station_icon_32, station_icon_260, station_number_of_cases_now FROM $t_edb_stations_index WHERE station_id=$station_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_station_id, $get_current_station_number, $get_current_station_title, $get_current_station_title_clean, $get_current_station_district_id, $get_current_station_district_title, $get_current_station_icon_path, $get_current_station_icon_16, $get_current_station_icon_32, $get_current_station_icon_260, $get_current_station_number_of_cases_now) = $row;
	
	if($get_current_station_id == ""){
		echo"
		<h1>New</h1>

		<p><b>Please select station:</b></p>
		<div class=\"vertical\">
			<ul>";
			$query = "SELECT station_id, station_title, station_title_clean, station_number_of_cases_now FROM $t_edb_stations_index ORDER BY station_title ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_station_id, $get_station_title, $get_station_title_clean, $get_station_number_of_cases_now) = $row;
				echo"<li><a href=\"index.php?open=edb&amp;page=$page&amp;action=new&amp;station_id=$get_station_id&amp;editor_language=$editor_language&amp;l=$l\">$get_station_title</a></li>\n";
			}
			echo"
			</ul>
		</div>
		";
	}
	else{
		if($process == "1"){
			$inp_name = $_POST['inp_name'];
			$inp_name = output_html($inp_name);
			$inp_name_mysql = quote_smart($link, $inp_name);

			$inp_type_id = $_POST['inp_type_id'];
			$inp_type_id = output_html($inp_type_id);
			$inp_type_id_mysql = quote_smart($link, $inp_type_id);

			// Machine type title
			$query = "SELECT machine_type_id, machine_type_title FROM $t_edb_machines_types WHERE machine_type_id=$inp_type_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_machine_type_id, $get_current_machine_type_title) = $row;
	
			$inp_type_title_mysql = quote_smart($link, $get_current_machine_type_title);

			$inp_os = $_POST['inp_os'];
			$inp_os = output_html($inp_os);
			$inp_os_mysql = quote_smart($link, $inp_os);

			$inp_ip = $_POST['inp_ip'];
			$inp_ip = output_html($inp_ip);
			$inp_ip_mysql = quote_smart($link, $inp_ip);

			$inp_mac = $_POST['inp_mac'];
			$inp_mac = output_html($inp_mac);
			$inp_mac_mysql = quote_smart($link, $inp_mac);

			$inp_key = $_POST['inp_key'];
			$inp_key = output_html($inp_key);
			$inp_key_mysql = quote_smart($link, $inp_key);

			$inp_description = $_POST['inp_description'];
			$inp_description = output_html($inp_description);
			$inp_description_mysql = quote_smart($link, $inp_description);

			$inp_station_id = $_POST['inp_station_id'];
			$inp_station_id = output_html($inp_station_id);
			$inp_station_id_mysql = quote_smart($link, $inp_station_id);

			// Station title
			$query = "SELECT station_id, station_title FROM $t_edb_stations_index WHERE station_id=$inp_station_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_station_id, $get_current_station_title) = $row;
	
			$inp_station_title_mysql = quote_smart($link, $get_current_station_title);


			
			mysqli_query($link, "INSERT INTO $t_edb_machines_index
			(machine_id, machine_name, machine_type_id, machine_type_title, machine_os, machine_ip, machine_mac, machine_key, machine_description, machine_station_id, machine_station_title) 
			VALUES 
			(NULL, $inp_name_mysql, $inp_type_id_mysql, $inp_type_title_mysql, $inp_os_mysql, $inp_ip_mysql, $inp_mac_mysql, $inp_key_mysql, $inp_description_mysql, $inp_station_id_mysql, $inp_station_title_mysql)
			") or die(mysqli_error($link));


			$url = "index.php?open=edb&page=$page&action=open_station&station_id=$get_current_station_id&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;
			
		}
		echo"
		<h1>New</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Stations machines</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=open_station&amp;station_id=$get_current_station_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_station_title</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;editor_language=$editor_language&amp;l=$l\">New</a>
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



		<!-- New machine form -->
		
				
			<!-- Focus -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_name\"]').focus();
				});
				</script>
			<!-- //Focus -->

			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p>Machine name:<br />
			<input type=\"text\" name=\"inp_name\" value=\"\" size=\"25\" />
			</p>

			<p>Machine type:<br />
			<select name=\"inp_type_id\">\n";
			$query = "SELECT  machine_type_id, machine_type_title FROM $t_edb_machines_types ORDER BY machine_type_title ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_machine_type_id, $get_machine_type_title) = $row;
				echo"					";
				echo"<option value=\"$get_machine_type_id\">$get_machine_type_title</option>\n";
			}
			echo"
			</select>
			</p>

			<p>Machine OS:<br />
			<input type=\"text\" name=\"inp_os\" value=\"\" size=\"25\" />
			</p>

			<p>IP:<br />
			<input type=\"text\" name=\"inp_ip\" value=\"\" size=\"25\" />
			</p>

			<p>MAC:<br />
			<input type=\"text\" name=\"inp_mac\" value=\"\" size=\"25\" />
			</p>
			
			<p>Key:<br />";
			$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
			$pass = ""; //remember to declare $pass as an array
			$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
			for ($i = 0; $i < 8; $i++) {
				$n = rand(0, $alphaLength);
				$pass = $pass . $alphabet[$n];
			}
			echo"
			<input type=\"text\" name=\"inp_key\" value=\"$pass\" size=\"25\" />
			</p>

			<p>Description:<br />
			<input type=\"text\" name=\"inp_description\" value=\"\" size=\"25\" />
			</p>

			<p>Station:<br />
			<select name=\"inp_station_id\">\n";
			$query = "SELECT station_id, station_title, station_title_clean, station_number_of_cases_now FROM $t_edb_stations_index ORDER BY station_title ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_station_id, $get_station_title, $get_station_title_clean, $get_station_number_of_cases_now) = $row;
				echo"					";
				echo"<option value=\"$get_station_id\""; if($get_station_id == "$get_current_station_id"){ echo" selected=\"selected\""; } echo">$get_station_title</option>\n";
			}
			echo"
			</select>
			</p>
			
			<p>
			<input type=\"submit\" value=\"Create\" class=\"btn_default\" />
			</p>
			</form>
		<!-- //New machine form -->
		";
	} // station found
} // action == "new"
elseif($action == "edit_machine"){
	// Find machine
	$machine_id_mysql = quote_smart($link, $machine_id);
	$query = "SELECT machine_id, machine_name, machine_type_id, machine_type_title, machine_os, machine_ip, machine_mac, machine_key, machine_description, machine_station_id, machine_station_title, machine_last_seen_datetime, machine_last_seen_time, machine_last_seen_ddmmyyhi, machine_last_seen_ddmmyyyyhi, machine_is_working_with_automated_task_id, machine_started_working_datetime, machine_started_working_time, machine_started_working_ddmmyyhi, machine_started_working_ddmmyyyyhi FROM $t_edb_machines_index WHERE machine_id=$machine_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_machine_id, $get_current_machine_name, $get_current_machine_type_id, $get_current_machine_type_title, $get_current_machine_os, $get_current_machine_ip, $get_current_machine_mac, $get_current_machine_key, $get_current_machine_description, $get_current_machine_station_id, $get_current_machine_station_title, $get_current_machine_last_seen_datetime, $get_current_machine_last_seen_time, $get_current_machine_last_seen_ddmmyyhi, $get_current_machine_last_seen_ddmmyyyyhi, $get_current_machine_is_working_with_automated_task_id, $get_current_machine_started_working_datetime, $get_current_machine_started_working_time, $get_current_machine_started_working_ddmmyyhi, $get_current_machine_started_working_ddmmyyyyhi) = $row;
	
	if($get_current_machine_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		if($process == "1"){
			$inp_name = $_POST['inp_name'];
			$inp_name = output_html($inp_name);
			$inp_name_mysql = quote_smart($link, $inp_name);

			$inp_type_id = $_POST['inp_type_id'];
			$inp_type_id = output_html($inp_type_id);
			$inp_type_id_mysql = quote_smart($link, $inp_type_id);

			// Machine type title
			$query = "SELECT machine_type_id, machine_type_title FROM $t_edb_machines_types WHERE machine_type_id=$inp_type_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_machine_type_id, $get_current_machine_type_title) = $row;
	
			$inp_type_title_mysql = quote_smart($link, $get_current_machine_type_title);

			$inp_os = $_POST['inp_os'];
			$inp_os = output_html($inp_os);
			$inp_os_mysql = quote_smart($link, $inp_os);

			$inp_ip = $_POST['inp_ip'];
			$inp_ip = output_html($inp_ip);
			$inp_ip_mysql = quote_smart($link, $inp_ip);

			$inp_mac = $_POST['inp_mac'];
			$inp_mac = output_html($inp_mac);
			$inp_mac_mysql = quote_smart($link, $inp_mac);

			$inp_key = $_POST['inp_key'];
			$inp_key = output_html($inp_key);
			$inp_key_mysql = quote_smart($link, $inp_key);

			$inp_description = $_POST['inp_description'];
			$inp_description = output_html($inp_description);
			$inp_description_mysql = quote_smart($link, $inp_description);

			$inp_station_id = $_POST['inp_station_id'];
			$inp_station_id = output_html($inp_station_id);
			$inp_station_id_mysql = quote_smart($link, $inp_station_id);

			// Station title
			$query = "SELECT station_id, station_title FROM $t_edb_stations_index WHERE station_id=$inp_station_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_station_id, $get_current_station_title) = $row;
	
			$inp_station_title_mysql = quote_smart($link, $get_current_station_title);

			
			$result = mysqli_query($link, "UPDATE $t_edb_machines_index SET
							machine_name=$inp_name_mysql,  
							machine_type_id=$inp_type_id_mysql,  
							machine_type_title=$inp_type_title_mysql,  
							machine_os=$inp_os_mysql,  
							machine_ip=$inp_ip_mysql, 
							machine_mac=$inp_mac_mysql,  
							machine_key=$inp_key_mysql, 
							machine_description=$inp_description_mysql,  
							machine_station_id=$inp_station_id_mysql, 
							machine_station_title=$inp_station_title_mysql 
							 WHERE machine_id=$get_current_machine_id") or die(mysqli_error($link));

			// Working with 
			$inp_is_working_with_automated_task_id  = $_POST['inp_is_working_with_automated_task_id'];
			$inp_is_working_with_automated_task_id = output_html($inp_is_working_with_automated_task_id);
			$inp_is_working_with_automated_task_id_mysql = quote_smart($link, $inp_is_working_with_automated_task_id);
			if($inp_is_working_with_automated_task_id == "" OR $inp_is_working_with_automated_task_id == "0"){
				$result = mysqli_query($link, "UPDATE $t_edb_machines_index SET
							machine_is_working_with_automated_task_id=NULL,
							machine_started_working_datetime=NULL,
							machine_started_working_time=NULL,
							machine_started_working_ddmmyyhi=NULL,
							machine_started_working_ddmmyyyyhi=NULL
							 WHERE machine_id=$get_current_machine_id") or die(mysqli_error($link));
			}


			$url = "index.php?open=edb&page=machines&action=edit_machine&machine_id=$get_current_machine_id&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;
			
		}
		echo"
		<h1>$get_current_machine_name</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Stations machines</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=open_station&amp;station_id=$get_current_machine_station_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_machine_station_title</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;machine_id=$get_current_machine_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_machine_name</a>
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



		<!-- Edit machine form -->
			<!-- Focus -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_name\"]').focus();
				});
				</script>
			<!-- //Focus -->

			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;machine_id=$get_current_machine_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<table>
			 <tr>
			  <td style=\"vertical-align:top;padding-right: 40px;\">
				<h2>Machine settings</h2>
				<p>Here are the general settings for the machine.</p>
				<p>Machine name:<br />
				<input type=\"text\" name=\"inp_name\" value=\"$get_current_machine_name\" size=\"25\" />
				</p>
	
				<p>Machine type:<br />
				<select name=\"inp_type_id\">\n";
				$query = "SELECT  machine_type_id, machine_type_title FROM $t_edb_machines_types ORDER BY machine_type_title ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_machine_type_id, $get_machine_type_title) = $row;
					echo"					";
					echo"<option value=\"$get_machine_type_id\""; if($get_machine_type_id == "$get_current_machine_type_id"){ echo" selected=\"selected\""; } echo">$get_machine_type_title</option>\n";
				}
				echo"
				</select>
				</p>

				<p>Machine type:<br />
				<input type=\"text\" name=\"inp_type\" value=\"$get_current_machine_type\" size=\"25\" />
				</p>

				<p>Machine OS:<br />
				<input type=\"text\" name=\"inp_os\" value=\"$get_current_machine_os\" size=\"25\" />
				</p>

				<p>IP:<br />
				<input type=\"text\" name=\"inp_ip\" value=\"$get_current_machine_ip\" size=\"25\" />
				</p>

				<p>MAC:<br />
				<input type=\"text\" name=\"inp_mac\" value=\"$get_current_machine_mac\" size=\"25\" />
				</p>
			
				<p>Key:<br />
				<input type=\"text\" name=\"inp_key\" value=\"$get_current_machine_key\" size=\"25\" />
				</p>

				<p>Description:<br />
				<input type=\"text\" name=\"inp_description\" value=\"$get_current_machine_description\" size=\"25\" />
				</p>

				<p>Station:<br />
				<select name=\"inp_station_id\">\n";
				$query = "SELECT station_id, station_title, station_title_clean, station_number_of_cases_now FROM $t_edb_stations_index ORDER BY station_title ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_station_id, $get_station_title, $get_station_title_clean, $get_station_number_of_cases_now) = $row;
					echo"					";
					echo"<option value=\"$get_station_id\""; if($get_station_id == "$get_current_machine_station_id"){ echo" selected=\"selected\""; } echo">$get_station_title</option>\n";
				}
				echo"
				</select>
				</p>
			  </td>
			  <td style=\"border-left: #ccc 1px solid;\">
				<span>&nbsp;</span>
			  </td>
			  <td style=\"vertical-align:top;padding-left: 40px;\">
				<h2>Current task</h2>
				<p>If the machine is stuck then you can remove current task it's working on here.</p>

				<p>Last seen (Y-m-d H:i:s):<br />
				$get_current_machine_last_seen_datetime
				</p>

				<p>Working with task ID (set blank if the machine is stuck):<br />
				<input type=\"text\" name=\"inp_is_working_with_automated_task_id\" value=\"$get_current_machine_is_working_with_automated_task_id\" size=\"25\" />
				</p>

				<p>Started working with task (Y-m-d H:i:s):<br />
				$get_current_machine_started_working_datetime
				</p>

			  </td>
			 </tr>
			</table>
			<p>
			<input type=\"submit\" value=\"Save\" class=\"btn_default\" />
			</p>
			</form>
		<!-- //Edit machine form -->
		";
	} // machine found
} // edit_machine
elseif($action == "delete_machine"){
	// Find machine
	$machine_id_mysql = quote_smart($link, $machine_id);
	$query = "SELECT machine_id, machine_name, machine_type_id, machine_type_title, machine_os, machine_ip, machine_mac, machine_key, machine_description, machine_station_id, machine_station_title, machine_last_seen_datetime, machine_last_seen_time, machine_last_seen_ddmmyyhi, machine_last_seen_ddmmyyyyhi, machine_is_working_with_automated_task_id, machine_started_working_datetime, machine_started_working_time, machine_started_working_ddmmyyhi, machine_started_working_ddmmyyyyhi FROM $t_edb_machines_index WHERE machine_id=$machine_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_machine_id, $get_current_machine_name, $get_current_machine_type_id, $get_current_machine_type_title, $get_current_machine_os, $get_current_machine_ip, $get_current_machine_mac, $get_current_machine_key, $get_current_machine_description, $get_current_machine_station_id, $get_current_machine_station_title, $get_current_machine_last_seen_datetime, $get_current_machine_last_seen_time, $get_current_machine_last_seen_ddmmyyhi, $get_current_machine_last_seen_ddmmyyyyhi, $get_current_machine_is_working_with_automated_task_id, $get_current_machine_started_working_datetime, $get_current_machine_started_working_time, $get_current_machine_started_working_ddmmyyhi, $get_current_machine_started_working_ddmmyyyyhi) = $row;
	
	if($get_current_machine_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		if($process == "1"){
			
			$result = mysqli_query($link, "DELETE FROM $t_edb_machines_index WHERE machine_id=$get_current_machine_id") or die(mysqli_error($link));



			$url = "index.php?open=edb&page=$page&action=open_station&station_id=$get_current_machine_station_id&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=deleted";
			header("Location: $url");
			exit;
			
		}
		echo"
		<h1>$get_current_machine_name</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Stations machines</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=open_station&amp;station_id=$get_current_machine_station_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_machine_station_title</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;machine_id=$get_current_machine_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_machine_name</a>
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



		<!-- Delete machine form -->
			<p>Are you sure?</p>

			<p>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;machine_id=$get_current_machine_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">Delete</a></p>

		<!-- //Delete machine form -->
		";
	} // machine found
} // delete_machine
?>