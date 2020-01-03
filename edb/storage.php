<?php 
/**
*
* File: edb/storage.php
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


/*- Tables ---------------------------------------------------------------------------- */
$t_edb_evidence_storage_locations 	= $mysqlPrefixSav . "edb_evidence_storage_locations";
$t_edb_evidence_storage_shelves		= $mysqlPrefixSav . "edb_evidence_storage_shelves";



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
/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	// Get station
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

		}
	}
	
	// Get district
	if($district_id != ""){
		$query = "SELECT district_id, district_number, district_title, district_title_clean, district_icon_path, district_icon_16, district_icon_32, district_icon_260, district_number_of_stations, district_number_of_cases_now FROM $t_edb_districts_index WHERE district_id=$district_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_district_id, $get_current_district_number, $get_current_district_title, $get_current_district_title_clean, $get_current_district_icon_path, $get_current_district_icon_16, $get_current_district_icon_32, $get_current_district_icon_260, $get_current_district_number_of_stations, $get_current_district_number_of_cases_now) = $row;
	
		if($get_current_district_id == ""){
			echo"<h1>Server error 404</h1><p>District not found</p>";
			die;
		}
		else{

		}
	}

	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "$l_edb - $l_storage";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");

	echo"
	<h1>$l_storage</h1>

	<!-- Where am I ? -->	
		<p><b>$l_you_are_here:</b><br />
		<a href=\"index.php?l=$l\">$l_edb</a>
		";
		if(isset($get_current_district_id)){
			echo"
			&gt;
			<a href=\"cases_board_1_view_district.php?district_id=$get_current_district_id&amp;l=$l\">$get_current_district_title</a>
			";
		}
		if(isset($get_current_station_id)){
			echo"
			&gt;
			<a href=\"cases_board_2_view_station.php?station_id=$get_current_station_id&amp;l=$l\">$get_current_station_title</a>
			";
		}
		echo"
		&gt;
		<a href=\"storage.php?l=$l"; if(isset($get_current_district_id)){ echo"&amp;district_id=$get_current_district_id"; } if(isset($get_current_station_id)){ echo"&amp;station_id=$get_current_station_id"; } echo"\">$l_storage</a>
		</p>
	<!-- //Where am I ? -->

	<!-- Filters -->
		<form>
		<p>
		<select name=\"storage_locations\" class=\"on_change_go_to_url\">
			<option value=\"storage.php?district_id=$district_id&amp;station_id=$station_id&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\">- $l_location -</option>\n";
			$query = "SELECT storage_location_id, storage_location_title, storage_location_station_id, storage_location_station_title FROM $t_edb_evidence_storage_locations ORDER BY storage_location_title ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_storage_location_id, $get_storage_location_title, $get_storage_location_station_id, $get_storage_location_station_title) = $row;
			
				if($storage_location_id == ""){
					$storage_location_id = "$get_storage_location_id";
				}
				if(!(isset($get_current_station_id))){
					$get_current_station_id = "$get_storage_location_station_id";
				}

				echo"								";
				echo"<option value=\"storage.php?district_id=$district_id&amp;station_id=$get_storage_location_station_id&amp;storage_location_id=$get_storage_location_id&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\""; if($get_storage_location_id == "$storage_location_id"){ echo" selected=\"selected\""; } echo">$get_storage_location_title</option>\n";
			}
		echo"
		</select>

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
	<!-- //Filters -->

	<!-- Storage -->
		";
		// Get storage location
		if($storage_location_id != ""){
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
				// Check that I am member of this station
				$query = "SELECT station_member_id, station_member_station_id, station_member_station_title, station_member_district_id, station_member_district_title, station_member_user_id, station_member_rank, station_member_user_name, station_member_user_alias, station_member_first_name, station_member_middle_name, station_member_last_name, station_member_user_email, station_member_user_image_path, station_member_user_image_file, station_member_user_image_thumb_40, station_member_user_image_thumb_50, station_member_user_image_thumb_60, station_member_user_image_thumb_200, station_member_user_position, station_member_user_department, station_member_user_location, station_member_user_about, station_member_added_datetime, station_member_added_date_saying, station_member_added_by_user_id, station_member_added_by_user_name, station_member_added_by_user_alias, station_member_added_by_user_image FROM $t_edb_stations_members WHERE station_member_user_id=$my_user_id_mysql AND station_member_station_id=$get_current_storage_location_station_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_my_station_member_id, $get_my_station_member_station_id, $get_my_station_member_station_title, $get_my_station_member_district_id, $get_my_station_member_district_title, $get_my_station_member_user_id, $get_my_station_member_rank, $get_my_station_member_user_name, $get_my_station_member_user_alias, $get_my_station_member_first_name, $get_my_station_member_middle_name, $get_my_station_member_last_name, $get_my_station_member_user_email, $get_my_station_member_user_image_path, $get_my_station_member_user_image_file, $get_my_station_member_user_image_thumb_40, $get_my_station_member_user_image_thumb_50, $get_my_station_member_user_image_thumb_60, $get_my_station_member_user_image_thumb_200, $get_my_station_member_user_position, $get_my_station_member_user_department, $get_my_station_member_user_location, $get_my_station_member_user_about, $get_my_station_member_added_datetime, $get_my_station_member_added_date_saying, $get_my_station_member_added_by_user_id, $get_my_station_member_added_by_user_name, $get_my_station_member_added_by_user_alias, $get_my_station_member_added_by_user_image) = $row;

				if($get_my_station_member_id == ""){
					if(isset($get_current_station_id)){
						echo"
						<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> Please apply for access to this station..</h1>
						<meta http-equiv=\"refresh\" content=\"3;url=browse_districts_and_stations.php?action=apply_for_membership_to_station&amp;station_id=$get_current_station_id&amp;l=$l\">
						";
					}
					else{
						echo"<p>Missing current_station_id</p>";
					}
				} // access to station denied
				else{
					echo"
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
								  <td style=\"padding-right: 10px;vertical-align:top;\">
									<h2>$get_shelf_first_letter</h2>
							
								";
							}
							echo"
									<div  class=\"storage_shelf\">
										<div style=\"text-align:center;\">
											<p><b>$get_shelf_full_name</b></p>
										</div>

										<!-- Evidence stored at this shelf -->";

											$last_item_case_id = "";
											$query_i = "SELECT $t_edb_case_index_evidence_items.item_id, $t_edb_case_index_evidence_items.item_case_id, $t_edb_case_index_evidence_items.item_record_id, $t_edb_case_index_evidence_items.item_record_seized_year, $t_edb_case_index_evidence_items.item_record_seized_journal, $t_edb_case_index_evidence_items.item_record_seized_district_number, $t_edb_case_index_evidence_items.item_numeric_serial_number, $t_edb_case_index_evidence_items.item_title, $t_edb_case_index_evidence_items.item_in_time, $t_edb_case_index_evidence_items.item_in_date_ddmmyyyy, $t_edb_case_index.case_number, $t_edb_case_index.case_priority_id FROM $t_edb_case_index_evidence_items JOIN $t_edb_case_index ON $t_edb_case_index_evidence_items.item_case_id=$t_edb_case_index.case_id WHERE item_storage_shelf_id=$get_shelf_id ORDER BY item_case_id ASC";
											$result_i = mysqli_query($link, $query_i);
											while($row_i = mysqli_fetch_row($result_i)) {
												list($get_item_id, $get_item_case_id, $get_item_record_id, $get_item_record_seized_year, $get_item_record_seized_journal, $get_item_record_seized_district_number, $get_item_numeric_serial_number, $get_item_title, $get_item_in_time, $get_item_in_date_ddmmyyyy, $get_case_number, $get_case_priority_id) = $row_i;
												if($last_item_case_id != "" && $last_item_case_id != "$get_item_case_id"){
													echo"
														</p>
													</div>
													";
												}
												if($last_item_case_id != "$get_item_case_id"){
													echo"
													<div class=\"storage_box\">
														<p style=\"float: right;\">$get_item_in_date_ddmmyyyy</p>
														<p><a href=\"open_case_overview.php?case_id=$get_item_case_id&amp;l=$l\" class=\"storage_box_headline\">$get_case_number</a> <br />\n";
												}
												echo"
														<a href=\"open_case_evidence_edit_evidence_item_info.php?case_id=$get_item_case_id&amp;item_id=$get_item_id&amp;l=$l\">$get_item_record_seized_year/$get_item_record_seized_journal-$get_item_record_seized_district_number-$get_item_numeric_serial_number $get_item_title</a><br />
												";
												$last_item_case_id = "$get_item_case_id";
											}
											if($last_item_case_id  != ""){
												echo"	
														</p>
													</div>
												";
											}
											echo"
										<!-- //Evidence stored at this shelf -->
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
					";
				} // access to station ok
			} // storage location id found
		} // storage location id != ""
		echo"
	<!-- //Storage -->
	";



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