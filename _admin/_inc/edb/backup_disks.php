<?php
/**
*
* File: _admin/_inc/edb/backup_disks.php
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


$t_edb_backup_disks  	= $mysqlPrefixSav . "edb_backup_disks";

$t_edb_machines_index 	= $mysqlPrefixSav . "edb_machines_index";


/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['station_id'])) {
	$station_id = $_GET['station_id'];
	$station_id = strip_tags(stripslashes($station_id));
}
else{
	$station_id = "";
}
if(isset($_GET['disk_id'])) {
	$disk_id = $_GET['disk_id'];
	$disk_id = strip_tags(stripslashes($disk_id));
}
else{
	$disk_id = "";
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
	<h1>Backup disks</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Backup disks</a>
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

			<!-- Right side backup disks -->
				
				<p>
				<a href=\"index.php?open=edb&amp;page=$page&amp;action=new&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">New backup disk</a>
				</p>

				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
					<span>Disk ID</span>
				   </th>
				   <th scope=\"col\">
					<span>Name</span>
				   </th>
				   <th scope=\"col\">
					<span>Signature</span>
				   </th>
				   <th scope=\"col\">
					<span>Capacity</span>
				   </th>
				   <th scope=\"col\">
					<span>Available</span>
				   </th>
				   <th scope=\"col\">
					<span>Used</span>
				   </th>
				   <th scope=\"col\">
					<span>Client</span>
				   </th>
				   <th scope=\"col\">
					<span>District</span>
				   </th>
				   <th scope=\"col\">
					<span>Station</span>
				   </th>
				   <th scope=\"col\">
					<span><b>Actions</b></span>
				   </th>
				  </tr>
				 </thead>
				 <tbody>

					";

				$query = "SELECT disk_id, disk_name, disk_signature, disk_capacity_bytes, disk_capacity_human, disk_available_bytes, disk_available_human, disk_used_bytes, disk_used_human, disk_created_datetime, disk_created_ddmmyyyy, disk_updated_datetime, disk_updated_ddmmyyyy, disk_client_machine_id, disk_client_machine_name, disk_client_machine_key, disk_client_machine_ip, disk_client_machine_agent, disk_client_last_mounted_datetime, disk_client_last_mounted_ddmmyyyy, disk_district_id, disk_district_title, disk_station_id, disk_station_title FROM $t_edb_backup_disks ORDER BY disk_id DESC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_disk_id, $get_disk_name, $get_disk_signature, $get_disk_capacity_bytes, $get_disk_capacity_human, $get_disk_available_bytes, $get_disk_available_human, $get_disk_used_bytes, $get_disk_used_human, $get_disk_created_datetime, $get_disk_created_ddmmyyyy, $get_disk_updated_datetime, $get_disk_updated_ddmmyyyy, $get_disk_client_machine_id, $get_disk_client_machine_name, $get_disk_client_machine_key, $get_disk_client_machine_ip, $get_disk_client_machine_agent, $get_disk_client_last_mounted_datetime, $get_disk_client_last_mounted_ddmmyyyy, $get_disk_district_id, $get_disk_district_title, $get_disk_station_id, $get_disk_station_title) = $row;
			
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
						<a id=\"disk_id$get_disk_id\"></a>
						$get_disk_id
						</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_disk_name</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_disk_signature</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_disk_capacity_human</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_disk_available_human</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_disk_used_human</span>
					  </td>
					  <td class=\"$style\">
						<span>";
						if($get_disk_client_machine_id != ""){
							echo"<a href=\"index.php?open=edb&amp;page=machines&amp;action=edit_machine&amp;machine_id=$get_disk_client_machine_id&amp;editor_language=$editor_language&amp;l=$l\">$get_disk_client_machine_name</a>";
						}
						if($get_disk_client_last_mounted_ddmmyyyy != ""){
							echo" <span>($get_disk_client_last_mounted_ddmmyyyy)</span>";
						}
						echo"
						</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_disk_district_title</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_disk_station_title</span>
					  </td>
					  <td class=\"$style\">
						<span>
						<a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_disk&amp;disk_id=$get_disk_id&amp;editor_language=$editor_language&amp;l=$l\">Edit</a>
						|
						<a href=\"index.php?open=edb&amp;page=$page&amp;action=delete_disk&amp;disk_id=$get_disk_id&amp;editor_language=$editor_language&amp;l=$l\">Delete</a>
						</span>
					  </td>
					 </tr>";
				} // while
		
				echo"
				 </tbody>
				</table>
			<!-- //Right side disks -->
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
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Backup disk</a>
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

			<!-- Right side backup disks -->
				
				<p>
				<a href=\"index.php?open=edb&amp;page=$page&amp;action=new&amp;station_id=$get_current_station_id&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">New backup disk</a>
				</p>

				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
					<span>Disk ID</span>
				   </th>
				   <th scope=\"col\">
					<span>Name</span>
				   </th>
				   <th scope=\"col\">
					<span>Signature</span>
				   </th>
				   <th scope=\"col\">
					<span>Capacity</span>
				   </th>
				   <th scope=\"col\">
					<span>Available</span>
				   </th>
				   <th scope=\"col\">
					<span>Used</span>
				   </th>
				   <th scope=\"col\">
					<span>Client</span>
				   </th>
				   <th scope=\"col\">
					<span>District</span>
				   </th>
				   <th scope=\"col\">
					<span>Station</span>
				   </th>
				   <th scope=\"col\">
					<span><b>Actions</b></span>
				   </th>
				  </tr>
				 </thead>
				 <tbody>

					";
				$query = "SELECT disk_id, disk_name, disk_signature, disk_capacity_bytes, disk_capacity_human, disk_available_bytes, disk_available_human, disk_used_bytes, disk_used_human, disk_created_datetime, disk_created_ddmmyyyy, disk_updated_datetime, disk_updated_ddmmyyyy, disk_client_machine_id, disk_client_machine_name, disk_client_machine_key, disk_client_machine_ip, disk_client_machine_agent, disk_client_last_mounted_datetime, disk_client_last_mounted_ddmmyyyy, disk_district_id, disk_district_title, disk_station_id, disk_station_title FROM $t_edb_backup_disks WHERE disk_station_id=$get_current_station_id  ORDER BY disk_id DESC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_disk_id, $get_disk_name, $get_disk_signature, $get_disk_capacity_bytes, $get_disk_capacity_human, $get_disk_available_bytes, $get_disk_available_human, $get_disk_used_bytes, $get_disk_used_human, $get_disk_created_datetime, $get_disk_created_ddmmyyyy, $get_disk_updated_datetime, $get_disk_updated_ddmmyyyy, $get_disk_client_machine_id, $get_disk_client_machine_name, $get_disk_client_machine_key, $get_disk_client_machine_ip, $get_disk_client_machine_agent, $get_disk_client_last_mounted_datetime, $get_disk_client_last_mounted_ddmmyyyy, $get_disk_district_id, $get_disk_district_title, $get_disk_station_id, $get_disk_station_title) = $row;
			
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
						<a id=\"disk_id$get_disk_id\"></a>
						$get_disk_id
						</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_disk_name</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_disk_signature</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_disk_capacity_human</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_disk_available_human</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_disk_used_human</span>
					  </td>
					  <td class=\"$style\">
						<span>";
						if($get_disk_client_machine_id != ""){
							echo"<a href=\"index.php?open=edb&amp;page=machines&amp;action=edit_machine&amp;machine_id=$get_disk_client_machine_id&amp;editor_language=$editor_language&amp;l=$l\">$get_disk_client_machine_name</a>";
						}
						if($get_disk_client_last_mounted_ddmmyyyy != ""){
							echo" <span>($get_disk_client_last_mounted_ddmmyyyy)</span>";
						}
						echo"
						</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_disk_district_title</span>
					  </td>
					  <td class=\"$style\">
						<span>$get_disk_station_title</span>
					  </td>
					  <td class=\"$style\">
						<span>
						<a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_disk&amp;disk_id=$get_disk_id&amp;editor_language=$editor_language&amp;l=$l\">Edit</a>
						|
						<a href=\"index.php?open=edb&amp;page=$page&amp;action=delete_disk&amp;disk_id=$get_disk_id&amp;editor_language=$editor_language&amp;l=$l\">Delete</a>
						</span>
					  </td>
					 </tr>";
				} // while
		
				echo"
				 </tbody>
				</table>
			<!-- //Right side disks -->
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

			$inp_signature = $_POST['inp_signature'];
			$inp_signature = output_html($inp_signature);
			$inp_signature_mysql = quote_smart($link, $inp_signature);

			$inp_capacity_human = $_POST['inp_capacity_human'];
			$inp_capacity_human = output_html($inp_capacity_human);
			$inp_capacity_bytes = $inp_capacity_human*1024;
			$inp_capacity_bytes = $inp_capacity_bytes*1024;
			$inp_capacity_bytes = $inp_capacity_bytes*1024;
			$inp_capacity_bytes_mysql = quote_smart($link, $inp_capacity_bytes);

			$inp_capacity_human = $inp_capacity_human . " GB";
			$inp_capacity_human_mysql = quote_smart($link, $inp_capacity_human);
			
			// Dates
			$datetime = date("Y-m-d H:i:s");
			$date_dmy = date("d.m.Y");


			$inp_station_id = $_GET['station_id'];
			$inp_station_id = output_html($inp_station_id);
			$inp_station_id_mysql = quote_smart($link, $inp_station_id);

			// Station title
			$inp_station_title_mysql = quote_smart($link, $get_current_station_title);
			$inp_district_title_mysql = quote_smart($link, $get_current_station_district_title);

			


			mysqli_query($link, "INSERT INTO $t_edb_backup_disks
			(disk_id, disk_name, disk_signature, disk_capacity_bytes, disk_capacity_human, 
			disk_available_bytes, disk_available_human, disk_used_bytes, disk_used_human, 
			disk_created_datetime, disk_created_ddmmyyyy, 
			disk_district_id, disk_district_title, disk_station_id, disk_station_title) 
			VALUES 
			(NULL, $inp_name_mysql, $inp_signature_mysql, $inp_capacity_bytes_mysql, $inp_capacity_human_mysql,
			$inp_capacity_bytes_mysql, $inp_capacity_human_mysql, 0, 0, 
			'$datetime', '$date_dmy', 
			$get_current_station_district_id, $inp_district_title_mysql, $inp_station_id_mysql, $inp_station_title_mysql)			
			") or die(mysqli_error($link));

			// Get ID
			$query = "SELECT disk_id FROM $t_edb_backup_disks WHERE disk_name=$inp_name_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_disk_id) = $row;
			
			
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
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Backup disks</a>
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



		<!-- New disk -->
		
				
			<!-- Focus -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_name\"]').focus();
				});
				</script>
			<!-- //Focus -->

			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p>Disk name:<br />
			<input type=\"text\" name=\"inp_name\" value=\"\" size=\"25\" />
			</p>

			<p>Signature:<br />
			<input type=\"text\" name=\"inp_signature\" value=\"\" size=\"25\" />
			</p>

			<p>Capacity human:<br />
			<input type=\"text\" name=\"inp_capacity_human\" value=\"\" size=\"5\" /> GB
			</p>
			<p>
			<input type=\"submit\" value=\"Create\" class=\"btn_default\" />
			</p>
			</form>
		<!-- //New disk -->
		";
	} // station found
} // action == "new"
elseif($action == "edit_disk"){
	// Find disk
	$disk_id_mysql = quote_smart($link, $disk_id);
	$query = "SELECT disk_id, disk_name, disk_signature, disk_capacity_bytes, disk_capacity_human, disk_available_bytes, disk_available_human, disk_used_bytes, disk_used_human, disk_created_datetime, disk_created_ddmmyyyy, disk_updated_datetime, disk_updated_ddmmyyyy, disk_client_machine_id, disk_client_machine_name, disk_client_machine_key, disk_client_machine_ip, disk_client_machine_agent, disk_client_last_mounted_datetime, disk_client_last_mounted_ddmmyyyy, disk_district_id, disk_district_title, disk_station_id, disk_station_title FROM $t_edb_backup_disks WHERE disk_id=$disk_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_disk_id, $get_current_disk_name, $get_current_disk_signature, $get_current_disk_capacity_bytes, $get_current_disk_capacity_human, $get_current_disk_available_bytes, $get_current_disk_available_human, $get_current_disk_used_bytes, $get_current_disk_used_human, $get_current_disk_created_datetime, $get_current_disk_created_ddmmyyyy, $get_current_disk_updated_datetime, $get_current_disk_updated_ddmmyyyy, $get_current_disk_client_machine_id, $get_current_disk_client_machine_name, $get_current_disk_client_machine_key, $get_current_disk_client_machine_ip, $get_current_disk_client_machine_agent, $get_current_disk_client_last_mounted_datetime, $get_current_disk_client_last_mounted_ddmmyyyy, $get_current_disk_district_id, $get_current_disk_district_title, $get_current_disk_station_id, $get_current_disk_station_title) = $row;

	if($get_current_disk_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		if($process == "1"){

			$inp_name = $_POST['inp_name'];
			$inp_name = output_html($inp_name);
			$inp_name_mysql = quote_smart($link, $inp_name);

			$inp_signature = $_POST['inp_signature'];
			$inp_signature = output_html($inp_signature);
			$inp_signature_mysql = quote_smart($link, $inp_signature);

			// Capacity
			$inp_capacity_human = $_POST['inp_capacity_human'];
			$inp_capacity_human = output_html($inp_capacity_human);

			$inp_capacity_bytes = $inp_capacity_human*1024;
			$inp_capacity_bytes = $inp_capacity_bytes*1024;
			$inp_capacity_bytes = $inp_capacity_bytes*1024;
			$inp_capacity_bytes_mysql = quote_smart($link, $inp_capacity_bytes);

			$inp_capacity_human = $inp_capacity_human . " GB";
			$inp_capacity_human_mysql = quote_smart($link, $inp_capacity_human);

			// Used
			$inp_used_human = $_POST['inp_used_human'];
			$inp_used_human = output_html($inp_used_human);

			$inp_used_bytes = $inp_used_human*1024;
			$inp_used_bytes = $inp_used_bytes*1024;
			$inp_used_bytes = $inp_used_bytes*1024;
			$inp_used_bytes_mysql = quote_smart($link, $inp_used_bytes);

			$inp_used_human = $inp_used_human . " GB";
			$inp_used_human_mysql = quote_smart($link, $inp_used_human);

			// Available
			$inp_available_bytes = $inp_capacity_bytes-$inp_used_bytes;
			$inp_available_bytes_mysql = quote_smart($link, $inp_available_bytes);

			$inp_available_human = $inp_available_bytes/1024;
			$inp_available_human = $inp_available_human/1024;
			$inp_available_human = $inp_available_human/1024;
			$inp_available_human = $inp_available_human . " GB";
			$inp_available_human_mysql = quote_smart($link, $inp_available_human);

			// Dates
			$datetime = date("Y-m-d H:i:s");
			$date_dmy = date("d.m.Y");


			$result = mysqli_query($link, "UPDATE $t_edb_backup_disks SET
							disk_name=$inp_name_mysql, 
							disk_signature=$inp_signature_mysql, 
							disk_capacity_bytes=$inp_capacity_bytes_mysql, 
							disk_capacity_human=$inp_capacity_human_mysql, 
							disk_available_bytes=$inp_available_bytes_mysql, 
							disk_available_human=$inp_available_human_mysql, 
							disk_used_bytes=$inp_used_bytes_mysql,  
							disk_used_human=$inp_used_human_mysql,  
							disk_updated_datetime='$datetime',
							disk_updated_ddmmyyyy='$date_dmy'
							 WHERE disk_id=$get_current_disk_id") or die(mysqli_error($link));

			// Client
			$inp_client_machine_id = $_POST['inp_client_machine_id'];
			$inp_client_machine_id = output_html($inp_client_machine_id);
			$inp_client_machine_id_mysql = quote_smart($link, $inp_client_machine_id);

			if($inp_client_machine_id == ""){
				$result = mysqli_query($link, "UPDATE $t_edb_backup_disks SET
							disk_client_machine_id=NULL, 
							disk_client_machine_name=NULL, 
							disk_client_machine_key=NULL, 
							disk_client_machine_ip=NULL, 
							disk_client_machine_agent=NULL
							 WHERE disk_id=$get_current_disk_id") or die(mysqli_error($link));
			}
			else{
				// Get machine name
				$query = "SELECT machine_id, machine_name, machine_os, machine_ip, machine_mac, machine_key, machine_description, machine_station_id, machine_station_title, machine_last_seen_datetime, machine_last_seen_time, machine_last_seen_ddmmyyhi, machine_last_seen_ddmmyyyyhi, machine_is_working_with_automated_task_id, machine_started_working_datetime, machine_started_working_time, machine_started_working_ddmmyyhi, machine_started_working_ddmmyyyyhi FROM $t_edb_machines_index WHERE machine_id=$inp_client_machine_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_machine_id, $get_current_machine_name, $get_current_machine_os, $get_current_machine_ip, $get_current_machine_mac, $get_current_machine_key, $get_current_machine_description, $get_current_machine_station_id, $get_current_machine_station_title, $get_current_machine_last_seen_datetime, $get_current_machine_last_seen_time, $get_current_machine_last_seen_ddmmyyhi, $get_current_machine_last_seen_ddmmyyyyhi, $get_current_machine_is_working_with_automated_task_id, $get_current_machine_started_working_datetime, $get_current_machine_started_working_time, $get_current_machine_started_working_ddmmyyhi, $get_current_machine_started_working_ddmmyyyyhi) = $row;
	
				$inp_machine_name_mysql = quote_smart($link, $get_current_machine_name);
				$inp_machine_key_mysql = quote_smart($link, $get_current_machine_key);

				$result = mysqli_query($link, "UPDATE $t_edb_backup_disks SET
							disk_client_machine_id=$get_current_machine_id, 
							disk_client_machine_name=$inp_machine_name_mysql, 
							disk_client_machine_key=$inp_machine_key_mysql
							 WHERE disk_id=$get_current_disk_id") or die(mysqli_error($link));
			}



			$url = "index.php?open=edb&page=$page&action=edit_disk&disk_id=$get_current_disk_id&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;
			
		}
		echo"
		<h1>$get_current_disk_name</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Stations machines</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=open_station&amp;station_id=$get_current_disk_station_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_disk_station_title</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;disk_id=$get_current_disk_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_disk_name</a>
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



		<!-- Edit disk form -->
			<!-- Focus -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_name\"]').focus();
				});
				</script>
			<!-- //Focus -->

			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;disk_id=$get_current_disk_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p>Disk name:<br />
			<input type=\"text\" name=\"inp_name\" value=\"$get_current_disk_name\" size=\"25\" />
			</p>

			<p>Signature:<br />
			<input type=\"text\" name=\"inp_signature\" value=\"$get_current_disk_signature\" size=\"25\" />
			</p>

			<p>Capacity human:<br />
			<input type=\"text\" name=\"inp_capacity_human\" value=\"";
			$capacity_gb = $get_current_disk_capacity_bytes/1024;
			$capacity_gb = $capacity_gb/1024;
			$capacity_gb = $capacity_gb/1024;
			echo"$capacity_gb\" size=\"5\" /> GB
			</p>

			<p>Used human:<br />
			<input type=\"text\" name=\"inp_used_human\" value=\"";
			$used_gb = $get_current_disk_used_bytes/1024;
			$used_gb = $used_gb/1024;
			$used_gb = $used_gb/1024;
			echo"$used_gb\" size=\"5\" /> GB
			</p>

			<p>Client:<br />
			<span classs=\"smal\">Set blank if the client is stuck</span><br />
			<select name=\"inp_client_machine_id\">
				<option value=\"\""; if($get_current_disk_client_machine_id == ""){ echo" selected=\"selected\""; } echo">-</option>\n";
			$query = "SELECT machine_id, machine_name, machine_os, machine_ip, machine_mac, machine_key, machine_description, machine_station_id, machine_station_title, machine_last_seen_datetime, machine_last_seen_time, machine_last_seen_ddmmyyhi, machine_last_seen_ddmmyyyyhi, machine_is_working_with_automated_task_id, machine_started_working_datetime, machine_started_working_time, machine_started_working_ddmmyyhi, machine_started_working_ddmmyyyyhi FROM $t_edb_machines_index";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_machine_id, $get_machine_name, $get_machine_os, $get_machine_ip, $get_machine_mac, $get_machine_key, $get_machine_description, $get_machine_station_id, $get_machine_station_title, $get_machine_last_seen_datetime, $get_machine_last_seen_time, $get_machine_last_seen_ddmmyyhi, $get_machine_last_seen_ddmmyyyyhi, $get_machine_is_working_with_automated_task_id, $get_machine_started_working_datetime, $get_machine_started_working_time, $get_machine_started_working_ddmmyyhi, $get_machine_started_working_ddmmyyyyhi) = $row;
				
				echo"			";
				echo"<option value=\"$get_machine_id\""; if($get_machine_id == "$get_current_disk_client_machine_id"){ echo" selected=\"selected\""; } echo">$get_machine_name</option>\n";
			}
			echo"</select>
			</p>

			<p>
			<input type=\"submit\" value=\"Save\" class=\"btn_default\" />
			</p>
			</form>
		<!-- //Edit disk form -->
		";
	} // disk found
} // edit_machine
elseif($action == "delete_disk"){
	// Find disk
	$disk_id_mysql = quote_smart($link, $disk_id);
	$query = "SELECT disk_id, disk_name, disk_signature, disk_capacity_bytes, disk_capacity_human, disk_available_bytes, disk_available_human, disk_used_bytes, disk_used_human, disk_created_datetime, disk_created_ddmmyyyy, disk_updated_datetime, disk_updated_ddmmyyyy, disk_client_machine_id, disk_client_machine_name, disk_client_machine_key, disk_client_machine_ip, disk_client_machine_agent, disk_client_last_mounted_datetime, disk_client_last_mounted_ddmmyyyy, disk_district_id, disk_district_title, disk_station_id, disk_station_title FROM $t_edb_backup_disks WHERE disk_id=$disk_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_disk_id, $get_current_disk_name, $get_current_disk_signature, $get_current_disk_capacity_bytes, $get_current_disk_capacity_human, $get_current_disk_available_bytes, $get_current_disk_available_human, $get_current_disk_used_bytes, $get_current_disk_used_human, $get_current_disk_created_datetime, $get_current_disk_created_ddmmyyyy, $get_current_disk_updated_datetime, $get_current_disk_updated_ddmmyyyy, $get_current_disk_client_machine_id, $get_current_disk_client_machine_name, $get_current_disk_client_machine_key, $get_current_disk_client_machine_ip, $get_current_disk_client_machine_agent, $get_current_disk_client_last_mounted_datetime, $get_current_disk_client_last_mounted_ddmmyyyy, $get_current_disk_district_id, $get_current_disk_district_title, $get_current_disk_station_id, $get_current_disk_station_title) = $row;

	if($get_current_disk_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		if($process == "1"){
			
			$result = mysqli_query($link, "DELETE FROM $t_edb_backup_disks WHERE disk_id=$get_current_disk_id") or die(mysqli_error($link));



			$url = "index.php?open=edb&page=$page&action=open_station&station_id=$get_current_disk_station_id&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=deleted";
			header("Location: $url");
			exit;
			
		}
		echo"
		<h1>$get_current_disk_name</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Stations machines</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=open_station&amp;station_id=$get_current_disk_station_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_disk_station_title</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;disk_id=$get_current_disk_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_disk_name</a>
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



		<!-- Delete disk form -->
			<p>Are you sure?</p>

			<p>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;disk_id=$get_current_disk_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">Delete</a></p>

		<!-- //Delete disk form -->
		";
	} // machine found
} // delete_machine
?>