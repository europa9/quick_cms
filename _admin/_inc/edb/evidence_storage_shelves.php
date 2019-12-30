<?php
/**
*
* File: _admin/_inc/edb/evidence_storage_shelves.php
* Version 1.0.0
* Date 17:40 07.09.2019
* Copyright (c) 2019 Sindre Andre Ditlefsen
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


$t_edb_evidence_storage_locations 	= $mysqlPrefixSav . "edb_evidence_storage_locations";
$t_edb_evidence_storage_shelves		= $mysqlPrefixSav . "edb_evidence_storage_shelves";

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['storage_location_id'])) {
	$storage_location_id = $_GET['storage_location_id'];
	$storage_location_id = strip_tags(stripslashes($storage_location_id));
}
else{
	$storage_location_id = "";
}
if(isset($_GET['shelf_id'])) {
	$shelf_id = $_GET['shelf_id'];
	$shelf_id = strip_tags(stripslashes($shelf_id));
}
else{
	$shelf_id = "";
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
	<h1>Evidence storage shelves</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Evidence storage shelves</a>
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

	<!-- Navigation -->
		<p>
		<a href=\"index.php?open=edb&amp;page=$page&amp;action=new_storage_location&amp;order_by=$;order_by&amp;order_method=$order_method&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">New storage location</a>
		</p>
	<!-- //Navigation -->


	<!-- Left and right -->
		<table>
		 <tbody>
		  <tr>
		   <td style=\"width: 200px;margin-right: 40px;vertical-align: top;\">
			<!-- storage_location_title -->
				<table class=\"hor-zebra\">
				 <tbody>
				  <tr>
				   <td>

				";
				$query = "SELECT storage_location_id, storage_location_title, storage_location_station_id, storage_location_station_title FROM $t_edb_evidence_storage_locations ORDER BY storage_location_title ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_storage_location_id, $get_storage_location_title, $get_storage_location_station_id, $get_storage_location_station_title) = $row;
			
					$title_len = strlen($get_storage_location_title);
					if($title_len > 20){
						$get_storage_location_title = substr($get_storage_location_title, 0, 25);
						$get_storage_location_title = $get_storage_location_title . "...";
					}
					echo"
					<a href=\"index.php?open=$open&amp;page=$page&amp;action=open_storage_location&amp;storage_location_id=$get_storage_location_id&amp;l=$l&amp;editor_language=$editor_language\">$get_storage_location_title</a><br />
					";

				} // while
		
				echo"
				   </td>
				  </tr>
				 </tbody>
				</table>
			<!-- //storage_location_title -->
		   </td>
		   <td style=\"vertical-align: top;\">
			<!-- Shelves -->
			<!-- //Shelves -->
		   </td>
		  </tr>
		 </tbody>
		</table>
	<!-- //Left and right -->
	";
} // action == ""
elseif($action == "new_storage_location"){
	if($process == "1"){

		$inp_title = $_POST['inp_title'];
		$inp_title = output_html($inp_title);
		$inp_title_mysql = quote_smart($link, $inp_title);

		$inp_abbr = "";
		$words = explode(" ", $inp_title);
		foreach ($words as $w) {
			$inp_abbr .= $w[0];
		}
		$inp_abbr_mysql = quote_smart($link, $inp_abbr);

		$inp_station_id = $_POST['inp_station_id'];
		$inp_station_id = output_html($inp_station_id);
		$inp_station_id_mysql = quote_smart($link, $inp_station_id);

		$query = "SELECT station_id, station_title FROM $t_edb_stations_index WHERE station_id=$inp_station_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_station_id, $get_current_station_title) = $row;

		$inp_station_title_mysql = quote_smart($link, $get_current_station_title);



		mysqli_query($link, "INSERT INTO $t_edb_evidence_storage_locations
		(storage_location_id, storage_location_title, storage_location_abbr, storage_location_station_id, storage_location_station_title) 
		VALUES 
		(NULL, $inp_title_mysql, $inp_abbr_mysql, $inp_station_id_mysql, $inp_station_title_mysql)")
		or die(mysqli_error($link));

		$url = "index.php?open=edb&page=$page&action=$action&editor_language=$editor_language&l=$l&ft=success&fm=created_$inp_title";
		header("Location: $url");
		exit;
	}
	echo"
	<h1>New storage location</h1>


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Evidence storage shelves</a>
		&gt;
		<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;editor_language=$editor_language&amp;l=$l\">New storage location</a>
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
			\$('[name=\"inp_title\"]').focus();
		});
		</script>
	<!-- //Focus -->

	<!-- New form -->
		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

		<p>Title:<br />
		<input type=\"text\" name=\"inp_title\" value=\"\" size=\"25\" />
		</p>

		<p>Station: (<a href=\"index.php?open=$open&amp;page=stations_index&amp;l=$l\">Edit</a>)<br />
		<select name=\"inp_station_id\">\n";
		$query = "SELECT station_id, station_title, station_title_clean, station_number_of_cases_now FROM $t_edb_stations_index ORDER BY station_title ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_station_id, $get_station_title, $get_station_title_clean, $get_station_number_of_cases_now) = $row;
			echo"			";
			echo"<option value=\"$get_station_id\">$get_station_title</option>\n";
		}
		echo"
		</select>
		</p>

		<p><input type=\"submit\" value=\"Create storage location\" class=\"btn_default\" />
		</p>
	
		</form>
	<!-- //New form -->

	";
} // new storage_location
elseif($action == "open_storage_location"){
	// Find
	$storage_location_id_mysql = quote_smart($link, $storage_location_id);
	$query = "SELECT storage_location_id, storage_location_title, storage_location_station_id, storage_location_station_title FROM $t_edb_evidence_storage_locations WHERE storage_location_id=$storage_location_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_storage_location_id, $get_current_storage_location_title, $get_current_storage_location_station_id, $get_current_storage_location_station_title) = $row;
	
	if($get_current_storage_location_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

	
		echo"
		<h1>$get_current_storage_location_title</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Evidence storage shelves</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;storage_location_id=$get_current_storage_location_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_storage_location_title</a>
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

		<!-- Navigation -->
			<p>
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=new_storage_location&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">New storage location</a>
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_storage_location&amp;storage_location_id=$get_current_storage_location_id&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">Edit storage location</a>
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=delete_storage_location&amp;storage_location_id=$get_current_storage_location_id&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">Delete storage location</a>
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=new_storage_shelf&amp;storage_location_id=$get_current_storage_location_id&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">New storage shelf</a>
			</p>
		<!-- //Navigation -->



		<!-- Left and right -->
		<table>
		 <tbody>
		  <tr>
		   <td style=\"width: 200px;padding-right: 40px;vertical-align: top;\">
			<!-- storage_location_title -->
				<table class=\"hor-zebra\">
				 <tbody>
				  <tr>
				   <td>

				";
				$query = "SELECT storage_location_id, storage_location_title, storage_location_station_id, storage_location_station_title FROM $t_edb_evidence_storage_locations ORDER BY storage_location_title ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_storage_location_id, $get_storage_location_title, $get_storage_location_station_id, $get_storage_location_station_title) = $row;
			
					$title_len = strlen($get_storage_location_title);
					if($title_len > 20){
						$get_storage_location_title = substr($get_storage_location_title, 0, 25);
						$get_storage_location_title = $get_storage_location_title . "...";
					}
					echo"
					<a href=\"index.php?open=$open&amp;page=$page&amp;action=open_storage_location&amp;storage_location_id=$get_storage_location_id&amp;l=$l&amp;editor_language=$editor_language\""; if($get_storage_location_id == "$get_current_storage_location_id"){ echo" style=\"font-weight: bold;\""; } echo">$get_storage_location_title</a><br />
					";

				} // while
		
				echo"
				   </td>
				  </tr>
				 </tbody>
				</table>
			<!-- //storage_location_title -->
		   </td>
		   <td style=\"vertical-align: top;\">
			<!-- Shelves -->
				<table>
				 <tbody>
				  <tr>

					";

				// Shelves
				$last_letter = "";
				$query = "SELECT shelf_id, shelf_first_letter, shelf_number, shelf_full_name, shelf_barcode, shelf_station_id, shelf_station_title, shelf_storage_location_id, shelf_storage_location_title FROM $t_edb_evidence_storage_shelves WHERE shelf_storage_location_id=$get_current_storage_location_id ORDER BY shelf_full_name ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_shelf_id, $get_shelf_first_letter, $get_shelf_number, $get_shelf_full_name, $get_shelf_barcode, $get_shelf_station_id, $get_shelf_station_title, $get_shelf_storage_location_id, $get_shelf_storage_location_title) = $row;
			
					if($last_letter != "" && $last_letter != "$get_shelf_first_letter"){
						echo"
						  </td>
						";
					}
					if($last_letter != "$get_shelf_first_letter"){
						echo"
						  <td style=\"padding-right: 10px;vertical-align:top;text-align:center;\">
							<h2>$get_shelf_first_letter</h2>
							
						";
					}
					echo"
							<div style=\"border: #ccc 1px solid;padding: 5px;\">
								<a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_storage_shelf&amp;shelf_id=$get_shelf_id&amp;editor_language=$editor_language&amp;l=$l\">$get_shelf_full_name</a>
							</div>
					";

					if($last_letter != "$get_shelf_first_letter"){
						echo"
						";
					}
					$last_letter = "$get_shelf_first_letter";
				} // while
		
				echo"
				   </td>
				  </tr>
				 </tbody>
				</table>
			<!-- //Shelves -->
		   </td>
		  </tr>
		 </tbody>
		</table>
		<!-- //Left and right -->
		";
	} // found
} // open_storage_location
elseif($action == "edit_storage_location"){
	// Find
	$storage_location_id_mysql = quote_smart($link, $storage_location_id);
	$query = "SELECT storage_location_id, storage_location_title, storage_location_station_id, storage_location_station_title, storage_location_abbr FROM $t_edb_evidence_storage_locations WHERE storage_location_id=$storage_location_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_storage_location_id, $get_current_storage_location_title, $get_current_storage_location_station_id, $get_current_storage_location_station_title, $get_current_storage_location_abbr) = $row;
	
	if($get_current_storage_location_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

		if($process == "1"){
			$inp_title = $_POST['inp_title'];
			$inp_title = output_html($inp_title);
			$inp_title_mysql = quote_smart($link, $inp_title);

			$inp_abbr = $_POST['inp_abbr'];
			$inp_abbr = output_html($inp_abbr);
			$inp_abbr_mysql = quote_smart($link, $inp_abbr);


			$inp_station_id = $_POST['inp_station_id'];
			$inp_station_id = output_html($inp_station_id);
			$inp_station_id_mysql = quote_smart($link, $inp_station_id);

			$query = "SELECT station_id, station_title FROM $t_edb_stations_index WHERE station_id=$inp_station_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_station_id, $get_current_station_title) = $row;

			$inp_station_title_mysql = quote_smart($link, $get_current_station_title);


			// Update
			$result = mysqli_query($link, "UPDATE $t_edb_evidence_storage_locations SET 
							storage_location_title=$inp_title_mysql, 
							storage_location_abbr=$inp_abbr_mysql, 
							storage_location_station_id=$inp_station_id_mysql, 
							storage_location_station_title=$inp_station_title_mysql
							 WHERE storage_location_id=$get_current_storage_location_id");

			// Update shelves
			$result = mysqli_query($link, "UPDATE $t_edb_evidence_storage_shelves SET 
							shelf_storage_location_title=$inp_title_mysql, 
							shelf_storage_location_abbr=$inp_abbr_mysql 
							 WHERE shelf_storage_location_id=$get_current_storage_location_id") or die(mysqli_error($link));



			$url = "index.php?open=edb&page=$page&action=$action&storage_location_id=$get_current_storage_location_id&editor_language=$editor_language&l=$l&ft=success&fm=saved_$inp_title";
			header("Location: $url");
			exit;

		}
		echo"
		<h1>New storage shelve</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Evidence storage shelves</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=open_storage_location&amp;storage_location_id=$get_current_storage_location_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_storage_location_title</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;storage_location_id=$get_current_storage_location_id&amp;editor_language=$editor_language&amp;l=$l\">Edit $get_current_storage_location_title</a>
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

		<!-- Edit storage location form -->
			
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_title\"]').focus();
			});
			</script>

			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;storage_location_id=$get_current_storage_location_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
	
			<p>Title:<br />
			<input type=\"text\" name=\"inp_title\" value=\"$get_current_storage_location_title\" size=\"25\" />
			</p>
			<p>Abbreviation:<br />
			<input type=\"text\" name=\"inp_abbr\" value=\"$get_current_storage_location_abbr\" size=\"25\" />
			</p>

			<p>Station: (<a href=\"index.php?open=$open&amp;page=stations_index&amp;l=$l\">Edit</a>)<br />
			<select name=\"inp_station_id\">\n";
			$query = "SELECT station_id, station_title, station_title_clean, station_number_of_cases_now FROM $t_edb_stations_index ORDER BY station_title ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_station_id, $get_station_title, $get_station_title_clean, $get_station_number_of_cases_now) = $row;
				echo"			";
				echo"<option value=\"$get_station_id\""; if($get_station_id == "$get_current_storage_location_station_id"){ echo" selected=\"selected\""; } echo">$get_station_title</option>\n";
			}
			echo"
			</select>
			</p>

			<p><input type=\"submit\" value=\"Save changes\" class=\"btn_default\" />
			</p>
	
			</form>
		<!-- //Edit storage location form -->

		";
	} // found
} // edit_storage_location
elseif($action == "delete_storage_location"){
	// Find
	$storage_location_id_mysql = quote_smart($link, $storage_location_id);
	$query = "SELECT storage_location_id, storage_location_title, storage_location_station_id, storage_location_station_title FROM $t_edb_evidence_storage_locations WHERE storage_location_id=$storage_location_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_storage_location_id, $get_current_storage_location_title, $get_current_storage_location_station_id, $get_current_storage_location_station_title) = $row;
	
	if($get_current_storage_location_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

		if($process == "1"){
			// delete
			$result = mysqli_query($link, "DELETE FROM $t_edb_evidence_storage_locations WHERE storage_location_id=$get_current_storage_location_id");
			$result = mysqli_query($link, "DELETE FROM $t_edb_evidence_storage_shelves WHERE shelf_storage_location_id=$get_current_storage_location_id");


			$url = "index.php?open=edb&page=$page&editor_language=$editor_language&l=$l&ft=success&fm=deleted_$get_current_storage_location_title";
			header("Location: $url");
			exit;

		}
		echo"
		<h1>New storage shelve</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Evidence storage shelves</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=open_storage_location&amp;storage_location_id=$get_current_storage_location_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_storage_location_title</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;storage_location_id=$get_current_storage_location_id&amp;editor_language=$editor_language&amp;l=$l\">Delete $get_current_storage_location_title</a>
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

		<!-- Delete storage location form -->
			
			<p>Are you sure you want to delete the storage location?</p>
		
			<p>
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;storage_location_id=$get_current_storage_location_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">Confirm</a>
			</p>
		<!-- //Delete storage location form -->

		";
	} // found
} // delete_storage_location
elseif($action == "new_storage_shelf"){
	// Find
	$storage_location_id_mysql = quote_smart($link, $storage_location_id);
	$query = "SELECT storage_location_id, storage_location_title, storage_location_station_id, storage_location_station_title FROM $t_edb_evidence_storage_locations WHERE storage_location_id=$storage_location_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_storage_location_id, $get_current_storage_location_title, $get_current_storage_location_station_id, $get_current_storage_location_station_title) = $row;
	
	if($get_current_storage_location_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{

		if($process == "1"){

			$inp_full_name = $_POST['inp_full_name'];
			$inp_full_name = output_html($inp_full_name);
			$inp_full_name_mysql = quote_smart($link, $inp_full_name);

			$inp_first_letter = substr($inp_full_name, 0, 1);
			$inp_first_letter = output_html($inp_first_letter);
			$inp_first_letter_mysql = quote_smart($link, $inp_first_letter);

			$inp_number = str_replace("$inp_first_letter", "", $inp_full_name);
			$inp_number = output_html($inp_number);
			$inp_number_mysql = quote_smart($link, $inp_number);
			

			$inp_station_title_mysql = quote_smart($link, $get_current_storage_location_station_title);
			$inp_storage_location_title_mysql = quote_smart($link, $get_current_storage_location_title);


			// Barcode
			$characters = '0123456789';
			$charactersLength = strlen($characters);
			$inp_barcode = '';
			for ($i = 0; $i < 13; $i++) {
				$inp_barcode .= $characters[rand(0, $charactersLength - 1)];
			}
				

			mysqli_query($link, "INSERT INTO $t_edb_evidence_storage_shelves
			(shelf_id, shelf_first_letter, shelf_number, shelf_full_name, shelf_barcode, shelf_station_id, shelf_station_title, shelf_storage_location_id, shelf_storage_location_title) 
			VALUES 
			(NULL, $inp_first_letter_mysql, $inp_number_mysql, $inp_full_name_mysql, '$inp_barcode', $get_current_storage_location_station_id, $inp_station_title_mysql, $get_current_storage_location_id, $inp_storage_location_title_mysql)")
			or die(mysqli_error($link));


			$url = "index.php?open=edb&page=$page&action=$action&storage_location_id=$get_current_storage_location_id&editor_language=$editor_language&l=$l&ft=success&fm=created_$inp_full_name";
			header("Location: $url");
			exit;

		}
		echo"
		<h1>New storage shelf</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Evidence storage shelves</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=open_storage_location&amp;storage_location_id=$get_current_storage_location_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_storage_location_title</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;storage_location_id=$get_current_storage_location_id&amp;editor_language=$editor_language&amp;l=$l\">New storage shelf</a>
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

		<!-- Left and right -->
		<table>
		 <tbody>
		  <tr>
		   <td style=\"width: 200px;padding-right: 40px;vertical-align: top;\">
			<!-- new_storage_shelve form -->
				<h2>New storage shelf</h2>
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_full_name\"]').focus();
				});
				</script>

				<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;storage_location_id=$get_current_storage_location_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
	
				<p>Full name:<br />
				<input type=\"text\" name=\"inp_full_name\" value=\"\" size=\"25\" />
				</p>

				<p><input type=\"submit\" value=\"Create storage shelf\" class=\"btn_default\" />
				</p>
	
				</form>
			<!-- //new_storage_shelve form -->
		   </td>
		   <td style=\"vertical-align: top;\">
			
			<!-- Shelves -->
				<table>
				 <tbody>
				  <tr>

					";

				// Shelves
				$last_letter = "";
				$query = "SELECT shelf_id, shelf_first_letter, shelf_number, shelf_full_name, shelf_barcode, shelf_station_id, shelf_station_title, shelf_storage_location_id, shelf_storage_location_title FROM $t_edb_evidence_storage_shelves WHERE shelf_storage_location_id=$get_current_storage_location_id ORDER BY shelf_full_name ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_shelf_id, $get_shelf_first_letter, $get_shelf_number, $get_shelf_full_name, $get_shelf_barcode, $get_shelf_station_id, $get_shelf_station_title, $get_shelf_storage_location_id, $get_shelf_storage_location_title) = $row;
			
					if($last_letter != "" && $last_letter != "$get_shelf_first_letter"){
						echo"
						  </td>
						";
					}
					if($last_letter != "$get_shelf_first_letter"){
						echo"
						  <td style=\"padding-right: 10px;vertical-align:top;text-align:center;\">
							<h2>$get_shelf_first_letter</h2>
							
						";
					}
					echo"
							<div style=\"border: #ccc 1px solid;padding: 5px;\">
								<a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_storage_shelf&amp;shelf_id=$get_shelf_id&amp;editor_language=$editor_language&amp;l=$l\">$get_shelf_full_name</a>
							</div>
					";

					if($last_letter != "$get_shelf_first_letter"){
						echo"
						";
					}
					$last_letter = "$get_shelf_first_letter";
				} // while
		
				echo"
				   </td>
				  </tr>
				 </tbody>
				</table>
			<!-- //Shelves -->
		   </td>
		  </tr>
		 </tbody>
		</table>
		<!-- //Left and right -->

		";
	} // found
} // new_storage_shelve
elseif($action == "edit_storage_shelf"){
	// Find shelf
	$shelf_id_mysql = quote_smart($link, $shelf_id);
	$query = "SELECT shelf_id, shelf_first_letter, shelf_number, shelf_full_name, shelf_barcode, shelf_station_id, shelf_station_title, shelf_storage_location_id, shelf_storage_location_title FROM $t_edb_evidence_storage_shelves WHERE shelf_id=$shelf_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_shelf_id, $get_current_shelf_first_letter, $get_current_shelf_number, $get_current_shelf_full_name, $get_current_shelf_barcode, $get_current_shelf_station_id, $get_current_shelf_station_title, $get_current_shelf_storage_location_id, $get_current_shelf_storage_location_title) = $row;
	

	if($get_current_shelf_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		// Find storage location
		$query = "SELECT storage_location_id, storage_location_title, storage_location_station_id, storage_location_station_title FROM $t_edb_evidence_storage_locations WHERE storage_location_id=$get_current_shelf_storage_location_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_storage_location_id, $get_current_storage_location_title, $get_current_storage_location_station_id, $get_current_storage_location_station_title) = $row;
	

		if($process == "1"){

			$inp_full_name = $_POST['inp_full_name'];
			$inp_full_name = output_html($inp_full_name);
			$inp_full_name_mysql = quote_smart($link, $inp_full_name);

			$inp_first_letter = substr($inp_full_name, 0, 1);
			$inp_first_letter = output_html($inp_first_letter);
			$inp_first_letter_mysql = quote_smart($link, $inp_first_letter);

			$inp_number = str_replace("$inp_first_letter", "", $inp_full_name);
			$inp_number = output_html($inp_number);
			$inp_number_mysql = quote_smart($link, $inp_number);
			

			$inp_station_title_mysql = quote_smart($link, $get_current_storage_location_station_title);
			$inp_storage_location_title_mysql = quote_smart($link, $get_current_storage_location_title);


			// Barcode
			$characters = '0123456789';
			$charactersLength = strlen($characters);
			$inp_barcode = '';
			for ($i = 0; $i < 13; $i++) {
				$inp_barcode .= $characters[rand(0, $charactersLength - 1)];
			}
				

			$result = mysqli_query($link, "UPDATE $t_edb_evidence_storage_shelves SET 
							shelf_first_letter=$inp_first_letter_mysql, 
							shelf_number=$inp_number_mysql, 
							shelf_full_name=$inp_full_name_mysql 
							WHERE shelf_id=$get_current_shelf_id") or die(mysqli_error($link));

			$url = "index.php?open=edb&page=$page&action=$action&shelf_id=$get_current_shelf_id&editor_language=$editor_language&l=$l&ft=success&fm=saved_$inp_full_name";
			header("Location: $url");
			exit;

		}
		echo"
		<h1>Edit storage shelf</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Evidence storage shelves</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=open_storage_location&amp;storage_location_id=$get_current_storage_location_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_storage_location_title</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;shelf_id=$get_current_shelf_id&amp;editor_language=$editor_language&amp;l=$l\">Edit $get_current_shelf_full_name</a>
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

		<!-- Left and right -->
		<table>
		 <tbody>
		  <tr>
		   <td style=\"width: 200px;padding-right: 40px;vertical-align: top;\">
			<!-- new_storage_shelve form -->
				<h2>Edit $get_current_shelf_full_name</h2>
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_full_name\"]').focus();
				});
				</script>

				<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;shelf_id=$get_current_shelf_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
	
				<p>Full name:<br />
				<input type=\"text\" name=\"inp_full_name\" value=\"$get_current_shelf_full_name\" size=\"25\" />
				</p>

				<p><input type=\"submit\" value=\"Save\" class=\"btn_default\" />
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete_storage_shelve&amp;shelf_id=$get_current_shelf_id&amp;l=$l\" class=\"btn_warning\">Delete</a>
				</p>
	
				</form>
			<!-- //new_storage_shelve form -->
		   </td>
		   <td style=\"vertical-align: top;\">
			
			<!-- Shelves -->
				<table>
				 <tbody>
				  <tr>

					";

				// Shelves
				$last_letter = "";
				$query = "SELECT shelf_id, shelf_first_letter, shelf_number, shelf_full_name, shelf_barcode, shelf_station_id, shelf_station_title, shelf_storage_location_id, shelf_storage_location_title FROM $t_edb_evidence_storage_shelves WHERE shelf_storage_location_id=$get_current_storage_location_id ORDER BY shelf_full_name ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_shelf_id, $get_shelf_first_letter, $get_shelf_number, $get_shelf_full_name, $get_shelf_barcode, $get_shelf_station_id, $get_shelf_station_title, $get_shelf_storage_location_id, $get_shelf_storage_location_title) = $row;
			
					if($last_letter != "" && $last_letter != "$get_shelf_first_letter"){
						echo"
						  </td>
						";
					}
					if($last_letter != "$get_shelf_first_letter"){
						echo"
						  <td style=\"padding-right: 10px;vertical-align:top;text-align:center;\">
							<h2>$get_shelf_first_letter</h2>
							
						";
					}
					echo"
							<div style=\"border: #ccc 1px solid;padding: 5px;\">
								<a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_storage_shelf&amp;shelf_id=$get_shelf_id&amp;editor_language=$editor_language&amp;l=$l\">$get_shelf_full_name</a>
							</div>
					";

					if($last_letter != "$get_shelf_first_letter"){
						echo"
						";
					}
					$last_letter = "$get_shelf_first_letter";
				} // while
		
				echo"
				   </td>
				  </tr>
				 </tbody>
				</table>
			<!-- //Shelves -->
		   </td>
		  </tr>
		 </tbody>
		</table>
		<!-- //Left and right -->

		";
	} // found
} // edit_storage_shelve
elseif($action == "delete_storage_shelve"){
	// Find shelf
	$shelf_id_mysql = quote_smart($link, $shelf_id);
	$query = "SELECT shelf_id, shelf_first_letter, shelf_number, shelf_full_name, shelf_barcode, shelf_station_id, shelf_station_title, shelf_storage_location_id, shelf_storage_location_title FROM $t_edb_evidence_storage_shelves WHERE shelf_id=$shelf_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_shelf_id, $get_current_shelf_first_letter, $get_current_shelf_number, $get_current_shelf_full_name, $get_current_shelf_barcode, $get_current_shelf_station_id, $get_current_shelf_station_title, $get_current_shelf_storage_location_id, $get_current_shelf_storage_location_title) = $row;
	

	if($get_current_shelf_id == ""){
		echo"
		<h1>Server error 404</h1>
		";
	}
	else{
		// Find storage location
		$query = "SELECT storage_location_id, storage_location_title, storage_location_station_id, storage_location_station_title FROM $t_edb_evidence_storage_locations WHERE storage_location_id=$get_current_shelf_storage_location_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_storage_location_id, $get_current_storage_location_title, $get_current_storage_location_station_id, $get_current_storage_location_station_title) = $row;
	

		if($process == "1"){

			

			$result = mysqli_query($link, "DELETE FROM $t_edb_evidence_storage_shelves WHERE shelf_id=$get_current_shelf_id") or die(mysqli_error($link));

			$url = "index.php?open=edb&page=$page&action=open_storage_location&storage_location_id=$get_current_storage_location_id&editor_language=$editor_language&l=$l&ft=success&fm=deleted_$get_current_shelve_full_name";
			header("Location: $url");
			exit;

		}
		echo"
		<h1>Delete storage shelf</h1>


		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=edb&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Evidence DB</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">Evidence storage shelves</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=open_storage_location&amp;storage_location_id=$get_current_storage_location_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_storage_location_title</a>
			&gt;
			<a href=\"index.php?open=edb&amp;page=$page&amp;action=$action&amp;shelf_id=$get_current_shelf_id&amp;editor_language=$editor_language&amp;l=$l\">Delete $get_current_shelf_full_name</a>
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

		<!-- Left and right -->
		<table>
		 <tbody>
		  <tr>
		   <td style=\"width: 200px;padding-right: 40px;vertical-align: top;\">
			<!-- Delete form -->
				<h2>Delete $get_current_shelf_full_name</h2>
				<p>Are you sure you want to delete the shelf?</p>

				<p>
				<a href=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;shelf_id=$get_current_shelf_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">Delete</a>
				</p>
			<!-- //Delete form -->
		   </td>
		   <td style=\"vertical-align: top;\">
			
			<!-- Shelves -->
				<table>
				 <tbody>
				  <tr>

					";

				// Shelves
				$last_letter = "";
				$query = "SELECT shelf_id, shelf_first_letter, shelf_number, shelf_full_name, shelf_barcode, shelf_station_id, shelf_station_title, shelf_storage_location_id, shelf_storage_location_title FROM $t_edb_evidence_storage_shelves WHERE shelf_storage_location_id=$get_current_storage_location_id ORDER BY shelf_full_name ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_shelf_id, $get_shelf_first_letter, $get_shelf_number, $get_shelf_full_name, $get_shelf_barcode, $get_shelf_station_id, $get_shelf_station_title, $get_shelf_storage_location_id, $get_shelf_storage_location_title) = $row;
			
					if($last_letter != "" && $last_letter != "$get_shelf_first_letter"){
						echo"
						  </td>
						";
					}
					if($last_letter != "$get_shelf_first_letter"){
						echo"
						  <td style=\"padding-right: 10px;vertical-align:top;text-align:center;\">
							<h2>$get_shelf_first_letter</h2>
							
						";
					}
					echo"
							<div style=\"border: #ccc 1px solid;padding: 5px;\">
								<a href=\"index.php?open=edb&amp;page=$page&amp;action=edit_storage_shelf&amp;shelf_id=$get_shelf_id&amp;editor_language=$editor_language&amp;l=$l\">$get_shelf_full_name</a>
							</div>
					";

					if($last_letter != "$get_shelf_first_letter"){
						echo"
						";
					}
					$last_letter = "$get_shelf_first_letter";
				} // while
		
				echo"
				   </td>
				  </tr>
				 </tbody>
				</table>
			<!-- //Shelves -->
		   </td>
		  </tr>
		 </tbody>
		</table>
		<!-- //Left and right -->

		";
	} // found
} // edit_storage_shelve
?>