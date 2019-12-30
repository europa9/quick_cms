<?php
/**
*
* File: _admin/_inc/edb/stations_directories.php
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

$t_edb_software_index	= $mysqlPrefixSav . "edb_software_index";

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['station_id'])) {
	$station_id = $_GET['station_id'];
	$station_id = strip_tags(stripslashes($station_id));
}
else{
	$station_id = "";
}
if(isset($_GET['directory_id'])) {
	$directory_id = $_GET['directory_id'];
	$directory_id = strip_tags(stripslashes($directory_id));
}
else{
	$directory_id = "";
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
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Stations directories</a>
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

			<!-- Right side directions all -->
				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">";
					if($order_by == ""){
						$order_by = "directory_station_title";
					}
					if($order_by == "directory_id" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=directory_id&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>ID</b></a>";
					if($order_by == "directory_id" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					if($order_by == "directory_id" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "directory_station_title" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=directory_station_title&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Locations</b></a>";
					if($order_by == "directory_station_title" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					if($order_by == "directory_station_title" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "directory_type" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=directory_type&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Type</b></a>";
					if($order_by == "directory_type" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					if($order_by == "directory_type" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "directory_address" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;order_by=directory_address&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Directory address</b></a>";
					if($order_by == "directory_address" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					if($order_by == "directory_address" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				  </tr>
				 </thead>
				 <tbody id=\"autosearch_search_results_hide\">

					";
					$query = "SELECT directory_id, directory_station_id, directory_station_title, directory_type, directory_address FROM $t_edb_stations_directories";
					if($order_by == "directory_id" OR $order_by == "directory_station_title" OR $order_by == "directory_type" OR $order_by == "directory_address"){
						if($order_method  == "asc" OR $order_method == "desc"){
							$query = $query  . " ORDER BY $order_by $order_method";
						}
					}
					else{
						$query = $query  . " ORDER BY directory_location_title ASC";
					}
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_directory_id, $get_directory_station_id, $get_directory_station_title, $get_directory_type, $get_directory_address) = $row;
			
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
							<a id=\"#directory$get_directory_id\"></a>
							<span>
							<a href=\"index.php?open=$open&amp;page=$page&amp;action=open_directory&amp;directory_id=$get_directory_id&amp;l=$l&amp;editor_language=$editor_language\">$get_directory_id</a>
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_directory_station_title
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_directory_type
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_directory_address
							</span>
						  </td>
						 </tr>";
					} // while
		
				echo"
				 </tbody>
				</table>
			<!-- //Right side directions all -->
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
		<h1>Stations directories</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Stations directories</a>
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
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=new_directory&amp;station_id=$get_current_station_id&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">New directory</a>
			</p>

			<!-- Right side directions all -->
				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">";
					if($order_by == ""){
						$order_by = "directory_station_title";
					}
					if($order_by == "directory_id" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;order_by=directory_id&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>ID</b></a>";
					if($order_by == "directory_id" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					if($order_by == "directory_id" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "directory_station_title" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;order_by=directory_station_title&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Locations</b></a>";
					if($order_by == "directory_station_title" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					if($order_by == "directory_station_title" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "directory_type" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;order_by=directory_type&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Type</b></a>";
					if($order_by == "directory_type" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					if($order_by == "directory_type" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				   <th scope=\"col\">";
					if($order_by == "directory_address" && $order_method == "asc"){
						$order_method_link = "desc";
					}
					else{
						$order_method_link = "asc";
					}
		
					echo"
					<span><a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;station_id=$get_current_station_id&amp;order_by=directory_address&amp;order_method=$order_method_link&amp;editor_language=$editor_language&amp;l=$l\" style=\"color:black;\"><b>Directory address</b></a>";
					if($order_by == "directory_address" && $order_method == "asc"){
						echo"<img src=\"_design/gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
					}
					if($order_by == "directory_address" && $order_method == "desc"){
						echo"<img src=\"_design/gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
					}
					echo"</span>
				   </th>
				  </tr>
				 </thead>
				 <tbody id=\"autosearch_search_results_hide\">

					";

					$query = "SELECT directory_id, directory_station_id, directory_station_title, directory_type, directory_address FROM $t_edb_stations_directories WHERE directory_station_id=$get_current_station_id";
					if($order_by == "directory_id" OR $order_by == "directory_station_title" OR $order_by == "directory_type" OR $order_by == "directory_address"){
						if($order_method  == "asc" OR $order_method == "desc"){
							$query = $query  . " ORDER BY $order_by $order_method";
						}
					}
					else{
						$query = $query  . " ORDER BY directory_location_title ASC";
					}

					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_directory_id, $get_directory_station_id, $get_directory_station_title, $get_directory_type, $get_directory_address) = $row;
			
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
							<a id=\"#directory$get_directory_id\"></a>
							<span>
							<a href=\"index.php?open=$open&amp;page=$page&amp;action=open_directory&amp;directory_id=$get_directory_id&amp;l=$l&amp;editor_language=$editor_language\">$get_directory_id</a>
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_directory_station_title
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_directory_type
							</span>
						  </td>
						  <td class=\"$style\">
							<span>
							$get_directory_address
							</span>
						  </td>
						 </tr>";
					} // while
		
				echo"
				 </tbody>
				</table>
			<!-- //Right side directions all -->
		  </td>
		 </tr>
		</table>
		<!-- //Left and right side -->
		";
	} // physical_location_found
} // action == "open_physical_location"
elseif($action == "open_directory"){
	// Find directory

	$directory_id_mysql = quote_smart($link, $directory_id);
	$query = "SELECT directory_id, directory_station_id, directory_station_title, directory_type, directory_address, directory_last_checked_for_new_files_counter, directory_last_checked_for_new_files_time, directory_last_checked_for_new_files_hour, directory_last_checked_for_new_files_minute, directory_now_size_last_calculated_day, directory_now_size_last_calculated_hour, directory_now_size_last_calculated_minute, directory_now_size_mb, directory_now_size_gb, directory_available_size_mb, directory_available_size_gb, directory_available_size_percentage FROM $t_edb_stations_directories WHERE directory_id=$directory_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_directory_id, $get_current_directory_station_id, $get_current_directory_station_title, $get_current_directory_type, $get_current_directory_address, $get_current_directory_last_checked_for_new_files_counter, $get_current_directory_last_checked_for_new_files_time, $get_current_directory_last_checked_for_new_files_hour, $get_current_directory_last_checked_for_new_files_minute, $get_current_directory_now_size_last_calculated_day, $get_current_directory_now_size_last_calculated_hour, $get_current_directory_now_size_last_calculated_minute, $get_current_directory_now_size_mb, $get_current_directory_now_size_gb, $get_current_directory_available_size_mb, $get_current_directory_available_size_gb, $get_current_directory_available_size_percentage) = $row;
	


	if($get_current_directory_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		if($process == "1"){
			$inp_station_id = $_POST['inp_station_id'];
			$inp_station_id = output_html($inp_station_id);
			$inp_station_id_mysql = quote_smart($link, $inp_station_id);

			// Station title
			$query = "SELECT station_id, station_title, station_district_id, station_district_title FROM $t_edb_stations_index WHERE station_id=$inp_station_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_station_id, $get_current_station_title, $get_current_station_district_id, $get_current_station_district_title) = $row;
	
			$inp_station_title_mysql = quote_smart($link, $get_current_station_title);
			$inp_district_title_mysql = quote_smart($link, $get_current_station_district_title);

			$inp_type = $_POST['inp_type'];
			$inp_type = output_html($inp_type);
			$inp_type_mysql = quote_smart($link, $inp_type);

			$inp_address = $_POST['inp_address'];
			$inp_address = output_html($inp_address);
			$inp_address = str_replace("&#92;", "\\", $inp_address);
			$inp_address = str_replace("&#92", "\\", $inp_address);
			$inp_address_mysql = quote_smart($link, $inp_address);

			$inp_available_size_mb = $_POST['inp_available_size_mb'];
			$inp_available_size_mb = output_html($inp_available_size_mb);
			$inp_available_size_mb_mysql = quote_smart($link, $inp_available_size_mb);
		
			// GB=(MB/1024)
			$inp_available_size_gb = round($inp_available_size_mb/1024, 1);
			$inp_available_size_gb = output_html($inp_available_size_gb);
			$inp_available_size_gb_mysql = quote_smart($link, $inp_available_size_gb);
			
			$result = mysqli_query($link, "UPDATE  $t_edb_stations_directories SET
							directory_station_id=$inp_station_id_mysql, 
							directory_station_title=$inp_station_title_mysql, 
							directory_district_id=$get_current_station_district_id, 
							directory_district_title=$inp_district_title_mysql, 

							directory_type=$inp_type_mysql, 
							directory_address=$inp_address_mysql, 
							directory_available_size_mb=$inp_available_size_mb_mysql, 
							directory_available_size_gb=$inp_available_size_gb_mysql
							 WHERE directory_id=$get_current_directory_id") or die(mysqli_error($link));



			$url = "index.php?open=edb&page=$page&action=$action&directory_id=$get_current_directory_id&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;
			
		}
		echo"
		<h1>Stations directories</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Stations directories</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=open_physical_location&amp;station_id=$get_current_directory_station_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_directory_station_title</a>
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
							<a href=\"index.php?open=$open&amp;page=$page&amp;action=open_station&amp;station_id=$get_station_id&amp;l=$l&amp;editor_language=$editor_language\""; if($get_station_id == "$get_current_directory_station_id"){ echo" style=\"font-weight: bold;\""; } echo">$get_station_title</a>
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

			<!-- Right side Edit directory -->
				
				<!-- Focus -->
					<script>
					\$(document).ready(function(){
						\$('[name=\"inp_location_id\"]').focus();
					});
					</script>
				<!-- //Focus -->

				<h2>$get_current_directory_station_title $get_current_directory_type</h2>

				<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;directory_id=$get_current_directory_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">



				<p>Station:<br />
				<select name=\"inp_station_id\">\n";
				$query = "SELECT station_id, station_title, station_title_clean, station_number_of_cases_now FROM $t_edb_stations_index ORDER BY station_title ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_station_id, $get_station_title, $get_station_title_clean, $get_station_number_of_cases_now) = $row;
			
					echo"					";
					echo"<option value=\"$get_station_id\""; if($get_station_id == "$get_current_directory_station_id"){ echo" selected=\"selected\""; } echo">$get_station_title</option>\n";
				}
				echo"
				</select>
				</p>

				<p>Type:<br />
				<select name=\"inp_type\">
					<option value=\"case_files\""; if($get_current_directory_type == "case_files"){ echo" selected=\"selected\""; } echo">Case files</option>
					<option value=\"mirror_files\""; if($get_current_directory_type == "mirror_files"){ echo" selected=\"selected\""; } echo">Mirror files</option>
				</select>
				</p>

				<p>Directory address:<br />
				<input type=\"text\" name=\"inp_address\" value=\"$get_current_directory_address\" size=\"25\" />
				</p>

				<p>Available size in mb:<br />
				<input type=\"text\" name=\"inp_available_size_mb\" value=\"$get_current_directory_available_size_mb\" size=\"25\" />
				</p>


				<p>
				<input type=\"submit\" value=\"Save changes\" class=\"btn_default\" />
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete_directory&amp;directory_id=$get_current_directory_id&amp;l=$l\" class=\"btn_warning\">Delete</a>
				</p>
				</form>
			<!-- //Right side Edit directory -->
		  </td>
		 </tr>
		</table>
		<!-- //Left and right side -->
		";
	} // directory_found
} // action == "open_directory"\
elseif($action == "delete_directory"){
	// Find directory

	$directory_id_mysql = quote_smart($link, $directory_id);
	$query = "SELECT directory_id, directory_station_id, directory_station_title, directory_type, directory_address, directory_last_checked_for_new_files_counter, directory_last_checked_for_new_files_time, directory_last_checked_for_new_files_hour, directory_last_checked_for_new_files_minute, directory_now_size_last_calculated_day, directory_now_size_last_calculated_hour, directory_now_size_last_calculated_minute, directory_now_size_mb, directory_now_size_gb, directory_available_size_mb, directory_available_size_gb, directory_available_size_percentage FROM $t_edb_stations_directories WHERE directory_id=$directory_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_directory_id, $get_current_directory_station_id, $get_current_directory_station_title, $get_current_directory_type, $get_current_directory_address, $get_current_directory_last_checked_for_new_files_counter, $get_current_directory_last_checked_for_new_files_time, $get_current_directory_last_checked_for_new_files_hour, $get_current_directory_last_checked_for_new_files_minute, $get_current_directory_now_size_last_calculated_day, $get_current_directory_now_size_last_calculated_hour, $get_current_directory_now_size_last_calculated_minute, $get_current_directory_now_size_mb, $get_current_directory_now_size_gb, $get_current_directory_available_size_mb, $get_current_directory_available_size_gb, $get_current_directory_available_size_percentage) = $row;
	


	if($get_current_directory_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		if($process == "1"){
			
			
			$result = mysqli_query($link, "DELETE FROM $t_edb_stations_directories
							 WHERE directory_id=$get_current_directory_id") or die(mysqli_error($link));



			$url = "index.php?open=edb&page=$page&action=open_station&station_id=$get_current_directory_station_id&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=deleted";
			header("Location: $url");
			exit;
			
		}
		echo"
		<h1>Stations directories</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Stations directories</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=open_physical_location&amp;station_id=$get_current_directory_station_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_directory_station_title</a>
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
							<a href=\"index.php?open=$open&amp;page=$page&amp;action=open_station&amp;station_id=$get_station_id&amp;l=$l&amp;editor_language=$editor_language\""; if($get_station_id == "$get_current_directory_station_id"){ echo" style=\"font-weight: bold;\""; } echo">$get_station_title</a>
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

			<!-- Right side Delete directory -->
				
				
				<h2>$get_current_directory_station_title $get_current_directory_type</h2>

				<p>
				Are you sure you want to delete?
				</p>

				<p>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;directory_id=$get_current_directory_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">Confirm</a>
				</P>

			<!-- //Right side Delete directory -->
		  </td>
		 </tr>
		</table>
		<!-- //Left and right side -->
		";
	} // directory_found
} // action == "delete_directory"
elseif($action == "new_directory"){
	if($process == "1"){

		$inp_station_id = $_POST['inp_station_id'];
		$inp_station_id = output_html($inp_station_id);
		$inp_station_id_mysql = quote_smart($link, $inp_station_id);

		// Station title
		$query = "SELECT station_id, station_title, station_district_id, station_district_title FROM $t_edb_stations_index WHERE station_id=$inp_station_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_station_id, $get_current_station_title, $get_current_station_district_id, $get_current_station_district_title) = $row;
	
		$inp_station_title_mysql = quote_smart($link, $get_current_station_title);
		$inp_district_title_mysql = quote_smart($link, $get_current_station_district_title);

		$inp_type = $_POST['inp_type'];
		$inp_type = output_html($inp_type);
		$inp_type_mysql = quote_smart($link, $inp_type);

		$inp_address = $_POST['inp_address'];
		$inp_address = output_html($inp_address);
		$inp_address = str_replace("&#92;", "\\", $inp_address);
		$inp_address = str_replace("&#92", "\\", $inp_address);
		$inp_address_mysql = quote_smart($link, $inp_address);

		$inp_available_size_mb = $_POST['inp_available_size_mb'];
		$inp_available_size_mb = output_html($inp_available_size_mb);
		$inp_available_size_mb_mysql = quote_smart($link, $inp_available_size_mb);
		
		// GB=(MB/1024)
		$inp_available_size_gb = round($inp_available_size_mb/1024, 1);
		$inp_available_size_gb = output_html($inp_available_size_gb);
		$inp_available_size_gb_mysql = quote_smart($link, $inp_available_size_gb);
			

		mysqli_query($link, "INSERT INTO $t_$t_edb_stations_directories 
		(directory_id, directory_station_id, directory_station_title, directory_district_id, directory_district_title, directory_type, directory_address, directory_available_size_mb, directory_available_size_gb) 
		VALUES 
		(NULL, $inp_station_id_mysql, $inp_station_title_mysql, $get_current_station_district_id, $inp_district_title_mysql, $inp_type_mysql, $inp_address_mysql, $inp_available_size_mb_mysql, $inp_available_size_gb_mysql)
		") or die(mysqli_error($link));

		

		$url = "index.php?open=edb&page=$page&action=open_station&station_id=$inp_station_id&order_by=$order_by&order_method=$order_method&editor_language=$editor_language&l=$l&ft=success&fm=created";
		header("Location: $url");
		exit;
	}
	echo"
	<h1>New station directory</h1>


	<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Stations directories</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=new_directory&amp;editor_language=$editor_language&amp;l=$l\">New directory</a>
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
			\$('[name=\"inp_station_id\"]').focus();
		});
		</script>
	<!-- //Focus -->

	<!-- New form -->
		<h2>New directory</h2>

		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">



		
		<p>Station:<br />
		<select name=\"inp_station_id\">\n";
		$query = "SELECT station_id, station_title, station_title_clean, station_number_of_cases_now FROM $t_edb_stations_index ORDER BY station_title ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_station_id, $get_station_title, $get_station_title_clean, $get_station_number_of_cases_now) = $row;
			
			echo"					";
			echo"<option value=\"$get_station_id\""; if($get_station_id == "$station_id"){ echo" selected=\"selected\""; } echo">$get_station_title</option>\n";
		}
		echo"
		</select>
		</p>

		<p>Type:<br />
		<select name=\"inp_type\">
			<option value=\"case_files\">Case files</option>
			<option value=\"mirror_files\">Mirror files</option>
		</select>
		</p>

		<p>Directory address:<br />
		<input type=\"text\" name=\"inp_address\" value=\"\" size=\"25\" />
		</p>

		<p>Available size in mb:<br />
		<input type=\"text\" name=\"inp_available_size_mb\" value=\"\" size=\"25\" />
		</p>


		<p>
		<input type=\"submit\" value=\"Save changes\" class=\"btn_default\" />
		</p>
		</form>
	<!-- //New form -->

	";

} // new
?>