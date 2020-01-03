<?php 
/**
*
* File: edb/cases_explorer.php
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

/*- Tables ---------------------------------------------------------------------------- */
$t_edb_cases_counter_total 				= $mysqlPrefixSav . "edb_cases_counter_total";
$t_edb_cases_explorer_assigned_to_unique_users		= $mysqlPrefixSav . "edb_cases_explorer_assigned_to_unique_users";

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

if(isset($_GET['assigned_to_user_id'])) {
	$assigned_to_user_id = $_GET['assigned_to_user_id'];
	$assigned_to_user_id = strip_tags(stripslashes($assigned_to_user_id));
}
else{
	$assigned_to_user_id = "";
}
$assigned_to_user_id_mysql = quote_smart($link, $assigned_to_user_id);




if(isset($_GET['order_by'])) {
	$order_by = $_GET['order_by'];
	$order_by = strip_tags(stripslashes($order_by));
}
else{
	$order_by = "case_number";
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
	$order_method = "desc";
}


$date = date("Y-m-d");


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
		$query = "SELECT station_id, station_number, station_title, station_title_clean, station_district_id, station_district_title, station_icon_path, station_icon_16, station_icon_32, station_icon_260, station_number_of_cases_now, station_number_of_cases_total, station_number_updated FROM $t_edb_stations_index WHERE station_id=$station_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_station_id, $get_current_station_number, $get_current_station_title, $get_current_station_title_clean, $get_current_station_district_id, $get_current_station_district_title, $get_current_station_icon_path, $get_current_station_icon_16, $get_current_station_icon_32, $get_current_station_icon_260, $get_current_station_number_of_cases_now, $get_current_station_number_of_cases_total, $get_current_station_number_updated) = $row;
	
		if($get_current_station_id == ""){
			echo"<h1>Server error 404</h1><p>Station not found</p>";
			die;
		}
		else{
			// Update number of cases
			if($get_current_station_number_updated != "$date"){
				// Update 
				$query = "SELECT count(case_id) FROM $t_edb_case_index WHERE case_station_id=$get_current_station_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_count_cases_total) = $row;
				
				$query = "SELECT count(case_id) FROM $t_edb_case_index WHERE case_station_id=$get_current_station_id AND case_is_closed='0'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_count_cases_now) = $row;
			
				$result = mysqli_query($link, "UPDATE $t_edb_stations_index SET station_number_of_cases_now=$get_count_cases_now, station_number_of_cases_total=$get_count_cases_total, station_number_updated='$date' WHERE station_id=$station_id_mysql") or die(mysqli_error($link));
			}

			


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
	$website_title = "$l_edb - $l_cases_explorer";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");


	if($action == ""){
		echo"
		<!-- Headline -->
			<h1>$l_cases_explorer</h1>
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
			<a href=\"cases_explorer.php?l=$l\">$l_cases_explorer</a>
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

		<!-- Search and Filters -->
			<table>
			 <tr>
			  <td style=\"padding-right: 10px;vertical-align:top;\">
				<!-- Search case number + title -->
					<div class=\"search_for_case_and_evidence_query\">
						<form method=\"get\" action=\"search_for_case_and_evidence.php\" enctype=\"multipart/form-data\" id=\"search_for_case_and_evidence_form\">
						<p>
						<input type=\"text\" name=\"inp_search_for_case_query\" id=\"inp_search_for_case_query\" class='auto' value=\"\" size=\"9\" style=\"width:97%;\" />
						</p>
						</form>
					</div>
					<!-- Search engines Autocomplete -->
					<script id=\"source\" language=\"javascript\" type=\"text/javascript\">
					\$(document).ready(function () {
						\$('#inp_search_for_case_query').keyup(function () {
							// getting the value that user typed
       							var searchString    = \$(\"#inp_search_for_case_query\").val();
 							// forming the queryString
      							var data            = 'inp_search_for_case_query='+ searchString;
         
        							// if searchString is not empty
        							if(searchString) {
									\$(\"#inp_search_for_case_query_results\").css('visibility','visible');

           								// ajax call
            								\$.ajax({
                								type: \"POST\",
               									url: \"cases_explorer_search_for_case_autocomplete.php\",
                								data: data,
										beforeSend: function(html) { // this happens before actual call
										\$(\"#inp_search_for_case_query_results\").html(''); 
									},
               								success: function(html){
                    								\$(\"#inp_search_for_case_query_results\").append(html);
              								}
            								});
       								}
        							return false;
            						});
         				   	});
						</script>
					<!-- //Search engines Autocomplete -->

				<!-- //Search case number + title -->
			  </td>
			  <td style=\"padding-right: 10px;vertical-align:top;\">
				<!-- Select person -->
					<form>
					<p>
					<select name=\"assigned_to_user_name\" class=\"on_change_go_to_url\">
						<option value=\"cases_explorer.php?district_id=$district_id&amp;station_id=$station_id&amp;assigned_to_user_id=&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\">- $l_assigned_to -</option>
						<option value=\"cases_explorer.php?action=update_assigned_to_unique_users&amp;l=$l\">- $l_update -</option>\n";
						$query = "SELECT assigned_id, assigned_user_id, aassigned_user_name, assigned_user_alias, assigned_user_email, assigned_user_image_path, assigned_user_image_file, assigned_user_image_thumb_40, assigned_user_image_thumb_50, assigned_user_first_name, assigned_user_middle_name, assigned_user_last_name, assigned_updated_year FROM $t_edb_cases_explorer_assigned_to_unique_users ORDER BY assigned_user_first_name ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_assigned_id, $get_assigned_user_id, $get_aassigned_user_name, $get_assigned_user_alias, $get_assigned_user_email, $get_assigned_user_image_path, $get_assigned_user_image_file, $get_assigned_user_image_thumb_40, $get_assigned_user_image_thumb_50, $get_assigned_user_first_name, $get_assigned_user_middle_name, $get_assigned_user_last_name, $get_assigned_updated_year) = $row;
							echo"								";
							echo"<option value=\"cases_explorer.php?district_id=$district_id&amp;station_id=$station_id&amp;assigned_to_user_id=$get_assigned_user_id&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\""; if($get_assigned_user_id == "$assigned_to_user_id"){ echo" selected=\"selected\""; } echo">$get_assigned_user_first_name $get_assigned_user_middle_name $get_assigned_user_last_name</option>\n";
						}
						
					echo"
					</select>
					</form>
				<!-- //Select person -->
			  </td>
			  <td style=\"padding-right: 10px;vertical-align:top;\">
				<form>
				<p>
				<!-- Districts -->
				<select name=\"district\" class=\"on_change_go_to_url\">
					<option value=\"cases_explorer.php?station_id=$station_id&amp;assigned_to_user_id=$assigned_to_user_id&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\">- $l_district -</option>\n";
					$query = "SELECT district_member_id, district_member_district_id, district_member_district_title FROM $t_edb_districts_members WHERE district_member_user_id='$my_user_id_mysql' ORDER BY district_member_district_title ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_district_member_id, $get_district_member_district_id, $get_district_member_district_title) = $row;
						echo"								";
						echo"<option value=\"cases_explorer.php?district_id=$get_district_member_district_id&amp;station_id=$station_id&amp;assigned_to_user_id=$assigned_to_user_id&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\""; if($get_district_member_district_id == "$district_id"){ echo" selected=\"selected\""; } echo">$get_district_member_district_title</option>\n";
					}
				echo"
				</select>

				<select name=\"station\" class=\"on_change_go_to_url\">
					<option value=\"cases_explorer.php?district_id=$district_id&amp;assigned_to_user_id=$assigned_to_user_id&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\">- $l_station -</option>\n";
					$query_sub = "SELECT station_member_id, station_member_station_id, station_member_station_title FROM $t_edb_stations_members WHERE station_member_user_id='$my_user_id_mysql'  ORDER BY station_member_station_title ASC";
					$result_sub = mysqli_query($link, $query_sub);
					while($row_sub = mysqli_fetch_row($result_sub)) {
						list($get_station_member_id, $get_station_member_station_id, $get_station_member_station_title) = $row_sub;

						echo"								";
						echo"<option value=\"cases_explorer.php?district_id=$district_id&amp;station_id=$get_station_member_station_id&amp;assigned_to_user_id=$assigned_to_user_id&amp;order_by=$order_by&amp;order_method=$order_method&amp;l=$l\""; if($get_station_member_station_id == "$station_id"){ echo" selected=\"selected\""; } echo">$get_station_member_station_title</option>\n";
					}
				echo"
				</select>
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
			  </td>
			 </tr>
			</table>

		<!-- //Filters -->


		<!-- List of all cases -->
			<div style=\"height: 10px;\"></div>
			<table class=\"hor-zebra\">


			 <thead>
			  <tr>
			   <th scope=\"col\">
				";
				$th_order_by = "case_number";
				$th_title    = "$l_number";
						
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"cases_explorer.php?district_id=$district_id&amp;station_id=$station_id&amp;assigned_to_user_id=$assigned_to_user_id&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
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
				$th_order_by = "case_title";
				$th_title    = "$l_title";
						
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"cases_explorer.php?district_id=$district_id&amp;station_id=$station_id&amp;assigned_to_user_id=$assigned_to_user_id&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
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
				$th_order_by = "case_assigned_to_user_name";
				$th_title    = "$l_assigned_to";
						
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"cases_explorer.php?district_id=$district_id&amp;station_id=$station_id&amp;assigned_to_user_id=$assigned_to_user_id&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
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
				$th_order_by = "case_updated_date";
				$th_title    = "$l_updated";
						
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"cases_explorer.php?district_id=$district_id&amp;station_id=$station_id&amp;assigned_to_user_id=$assigned_to_user_id&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
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
				$th_order_by = "case_physical_location";
				$th_title    = "$l_location";
						
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"cases_explorer.php?district_id=$district_id&amp;station_id=$station_id&amp;assigned_to_user_id=$assigned_to_user_id&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
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
				$th_order_by = "case_backup_disks";
				$th_title    = "$l_backup";
						
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"cases_explorer.php?district_id=$district_id&amp;station_id=$station_id&amp;assigned_to_user_id=$assigned_to_user_id&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
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
				$th_order_by = "case_station_title";
				$th_title    = "$l_station";
						
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"cases_explorer.php?district_id=$district_id&amp;station_id=$station_id&amp;assigned_to_user_id=$assigned_to_user_id&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
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
				$th_order_by = "case_code_title";
				$th_title    = "$l_code";
						
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"cases_explorer.php?district_id=$district_id&amp;station_id=$station_id&amp;assigned_to_user_id=$assigned_to_user_id&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
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
				$th_order_by = "case_priority_title";
				$th_title    = "$l_priority";
						
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"cases_explorer.php?district_id=$district_id&amp;station_id=$station_id&amp;assigned_to_user_id=$assigned_to_user_id&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
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
				$th_order_by = "case_created_datetime";
				$th_title    = "$l_created";
						
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"cases_explorer.php?district_id=$district_id&amp;station_id=$station_id&amp;assigned_to_user_id=$assigned_to_user_id&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
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
				$th_order_by = "case_closed_datetime";
				$th_title    = "$l_closed";
						
				if($order_by == "$th_order_by" && $order_method == "asc"){
					$order_method_link = "desc";
				}
				else{
					$order_method_link = "asc";
				}

				echo"<span><a href=\"cases_explorer.php?district_id=$district_id&amp;station_id=$station_id&amp;assigned_to_user_id=$assigned_to_user_id&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l\" style=\"color:black;\"><b>$th_title</b></a>";
				if($order_by == "$th_order_by" && $order_method == "asc"){
					echo"<img src=\"_gfx/arrow_down.png\" alt=\"arrow_down.png\" />";
				}
				if($order_by == "$th_order_by" && $order_method == "desc"){
					echo"<img src=\"_gfx/arrow_up.png\" alt=\"arrow_up.png\" />";
				}
				echo"</span>
			   </th>
			  </tr>
			 </thead>
			 <tbody id=\"inp_search_for_case_query_results\">
			";
		
			// Paging
			$cases_per_page = 100;
			if(isset($_GET['page'])){
				$page = (int)$_GET['page'];
				$page = output_html($page);
			}
			else{
				$page = 1;
			}
			$start_at = $cases_per_page * ($page - 1);

			// Paging - number of cases
			if($station_id == ""){
				$query = "SELECT total_id, total_number_of_cases, total_number_update FROM $t_edb_cases_counter_total";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_total_id, $get_total_number_of_cases, $get_total_number_update) = $row;
				if($get_total_id == ""){
					mysqli_query($link, "INSERT INTO $t_edb_cases_counter_total (total_id, total_number_of_cases) VALUES (NULL, '0')") or die(mysqli_error($link));
				}
				else{
					if($get_total_number_update != "$date"){
						// Update 
						$query = "SELECT count(case_id) FROM $t_edb_case_index";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_count_cases) = $row;
				
						$result = mysqli_query($link, "UPDATE $t_edb_cases_counter_total SET total_number_of_cases=$get_count_cases, total_number_update='$date' WHERE total_id=$get_total_id");
					}
				}
				$total_pages = ceil($get_total_number_of_cases / $cases_per_page);
			}
			else{
				// Station selected
				$total_pages = ceil($get_current_station_number_of_cases_total / $cases_per_page);
				
			}
			

			$paging_links = "";
			for ($i = 1; $i <= $total_pages; $i++) {
				$paging_links .= ($i != $page ) 
				? "<a href='cases_explorer.php?district_id=$district_id&amp;station_id=$station_id&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l&amp;page=$i' class=\"btn_default\">$i</a> "
				: "<a href='cases_explorer.php?district_id=$district_id&amp;station_id=$station_id&amp;order_by=$th_order_by&amp;order_method=$order_method_link&amp;l=$l&amp;page=$i' class=\"btn_default\" style=\"font-weight:bold;\">$i</a> ";
			}



			// Query cases
			$query_cases = "SELECT case_id, case_number, case_title, case_code_id, case_code_title, case_priority_id, case_station_id, case_station_title, case_physical_location, case_backup_disks, case_assigned_to_user_id, case_assigned_to_user_name, case_assigned_to_user_first_name, case_assigned_to_user_middle_name, case_assigned_to_user_last_name, case_priority_title, case_updated_date_ddmmyyyy, case_updated_user_id, case_updated_user_name, case_updated_user_first_name, case_updated_user_middle_name, case_updated_user_last_name, case_created_date_ddmmyyyy, case_closed_date_ddmmyyyy FROM $t_edb_case_index";
			if($district_id != "" OR $station_id != "" OR $assigned_to_user_id != ""){
				$query_cases = $query_cases . "  WHERE ";
				$and = "0";
				if($district_id != ""){
					$query_cases = $query_cases . " case_district_id=$district_id_mysql";
					$and = "1";
				}
				if($station_id != ""){
					if($and == "1"){
						$query_cases = $query_cases . " AND ";
					}
					$query_cases = $query_cases . " case_station_id=$station_id_mysql";
					$and = "1";
				}
				if($assigned_to_user_id != ""){
					if($and == "1"){
						$query_cases = $query_cases . " AND ";
					}
					$query_cases = $query_cases . " case_assigned_to_user_id=$assigned_to_user_id_mysql";
					$and = "1";
				}
			}


			if($order_by == "case_number" OR $order_by == "case_title" OR $order_by == "case_assigned_to_user_name" OR $order_by == "case_updated_date" OR $order_by == "case_physical_location" OR $order_by == "case_backup_disks" OR $order_by == "case_station_title" OR $order_by == "case_code_title" OR $order_by == "case_priority_title" OR $order_by == "case_created_datetime" OR $order_by == "case_closed_datetime"){
				if($order_method == "asc" OR $order_method == "desc"){
					$query_cases = $query_cases . " ORDER BY $order_by $order_method";
				}
			}
			else{
				$query_cases = $query_cases . " ORDER BY case_id ASC";
			}

			$query_cases = $query_cases . " LIMIT $start_at, $cases_per_page ";

			$result_cases = mysqli_query($link, $query_cases);
			while($row_cases = mysqli_fetch_row($result_cases)) {
				list($get_case_id, $get_case_number, $get_case_title, $get_case_code_id, $get_case_code_title, $get_case_priority_id, $get_case_station_id, $get_case_station_title, $get_case_physical_location, $get_case_backup_disks, $get_case_assigned_to_user_id, $get_case_assigned_to_user_name, $get_case_assigned_to_user_first_name, $get_case_assigned_to_user_middle_name, $get_case_assigned_to_user_last_name, $get_case_priority_title, $get_case_updated_date_ddmmyyyy, $get_case_updated_user_id, $get_case_updated_user_name, $get_case_updated_user_first_name, $get_case_updated_user_middle_name, $get_case_updated_user_last_name, $get_case_created_date_ddmmyyyy, $get_case_closed_date_ddmmyyyy) = $row_cases;

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
					<span><a href=\"open_case_overview.php?case_id=$get_case_id&amp;l=$l\">$get_case_number</a></span>
				  </td>
				  <td class=\"$style\">
					<span>$get_case_title</span>
				  </td>
				  <td class=\"$style\">
					<span>";
					if($get_case_assigned_to_user_id == ""){
						echo"
						(<a href=\"$root/users/view_profile.php?user_id=$get_case_updated_user_id&amp;l=$l\" title=\"$get_case_updated_user_name\">";
						if($get_case_updated_user_first_name == ""){
							echo"$get_case_updated_user_name";
						}
						else{
							echo"$get_case_updated_user_first_name $get_case_updated_user_middle_name $get_case_updated_user_last_name";
						}

						echo"</a>)
						";
					}
					else{
						echo"
						<a href=\"$root/users/view_profile.php?user_id=$get_case_assigned_to_user_id&amp;l=$l\" title=\"$get_case_assigned_to_user_name\">";
						if($get_case_assigned_to_user_first_name == ""){
							echo"$get_case_assigned_to_user_name";
						}
						else{
							echo"$get_case_assigned_to_user_first_name $get_case_assigned_to_user_middle_name $get_case_assigned_to_user_last_name";
						}

						echo"</a>
						";
					}
					echo"</span>
				  </td>
				  <td class=\"$style\">
					<span>$get_case_updated_date_ddmmyyyy</span>
				  </td>
				  <td class=\"$style\">
					<span>$get_case_physical_location</span>
				  </td>
				  <td class=\"$style\">
					<span>$get_case_backup_disks</span>
				  </td>
				  <td class=\"$style\">
					<span>$get_case_station_title</span>
				  </td>
				  <td class=\"$style\">
					<span>$get_case_code_id $get_case_code_title</span>
				  </td>
				  <td class=\"$style\">
					<span>$get_case_priority_title</span>
				  </td>
				  <td class=\"$style\">
					<span>$get_case_created_date_ddmmyyyy</span>
				  </td>
				  <td class=\"$style\">
					<span>$get_case_closed_date_ddmmyyyy</span>
				  </td>
				</tr>
				";
			} // while human tasks
			echo"
			 </tbody>
			</table>

			<p>$paging_links</p>
			<div style=\"height: 10px;\"></div>
		<!-- //List of all cases -->
		";
	} // action == ""
	elseif($action == "update_assigned_to_unique_users"){

		echo"
		<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> Loading...</h1>
		<meta http-equiv=\"refresh\" content=\"1;url=cases_explorer.php?ft=success&fm=list_generated&l=$l\">

		
		";
		$year = date("Y");
		$query_cases = "SELECT DISTINCT case_assigned_to_user_id FROM $t_edb_case_index";
		$result_cases = mysqli_query($link, $query_cases);
		while($row_cases = mysqli_fetch_row($result_cases)) {
			list($get_case_assigned_to_user_id) = $row_cases;

			if($get_case_assigned_to_user_id != ""){
				// Check if user exits
				$query = "SELECT assigned_id FROM $t_edb_cases_explorer_assigned_to_unique_users WHERE assigned_user_id=$get_case_assigned_to_user_id";

				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_assigned_id) = $row;
				if($get_assigned_id == ""){
					// Fetch user info
					$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_id=$get_case_assigned_to_user_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_user_id, $get_user_email, $get_user_name, $get_user_alias, $get_user_language, $get_user_last_online, $get_user_rank, $get_user_login_tries) = $row;
					
					// User photo
					$query = "SELECT photo_id, photo_destination, photo_thumb_40, photo_thumb_50 FROM $t_users_profile_photo WHERE photo_user_id=$get_case_assigned_to_user_id AND photo_profile_image='1'";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_photo_id, $get_photo_destination, $get_photo_thumb_40, $get_photo_thumb_50) = $row;

					// User Profile
					$query = "SELECT profile_id, profile_first_name, profile_middle_name, profile_last_name, profile_about FROM $t_users_profile WHERE profile_user_id=$get_case_assigned_to_user_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_profile_id, $get_profile_first_name, $get_profile_middle_name, $get_profile_last_name, $get_profile_about) = $row;


					// Input variables
					$inp_user_name_mysql = quote_smart($link, $get_user_name);
					$inp_user_alias_mysql = quote_smart($link, $get_user_alias);
					$inp_user_email_mysql = quote_smart($link, $get_user_email);
					$inp_user_rank_mysql = quote_smart($link, $get_user_rank);

					$inp_user_image_path = "_uploads/users/images/$get_user_id";
					$inp_user_image_path_mysql = quote_smart($link, $inp_user_image_path);

					$inp_user_image_file_mysql = quote_smart($link, $get_photo_destination);

					$inp_user_image_thumb_a_mysql = quote_smart($link, $get_photo_thumb_40);
					$inp_user_image_thumb_b_mysql = quote_smart($link, $get_photo_thumb_50);
	
					$inp_user_first_name_mysql = quote_smart($link, $get_profile_first_name);
					$inp_user_middle_name_mysql = quote_smart($link, $get_profile_middle_name);
					$inp_user_last_name_mysql = quote_smart($link, $get_profile_last_name);



					// Insert user info
					mysqli_query($link, "INSERT INTO $t_edb_cases_explorer_assigned_to_unique_users 
					(assigned_id, assigned_user_id, aassigned_user_name, assigned_user_alias, assigned_user_email, 
					assigned_user_image_path, assigned_user_image_file, assigned_user_image_thumb_40, assigned_user_image_thumb_50, assigned_user_first_name, 
					assigned_user_middle_name, assigned_user_last_name, assigned_updated_year) 
					VALUES 
					(NULL, $get_user_id, $inp_user_name_mysql, $inp_user_alias_mysql, $inp_user_email_mysql, 
					$inp_user_image_path_mysql, $inp_user_image_file_mysql, $inp_user_image_thumb_a_mysql, $inp_user_image_thumb_b_mysql, $inp_user_first_name_mysql, 
					$inp_user_middle_name_mysql, $inp_user_last_name_mysql, $year)")
					or die(mysqli_error($link)); 
				} // assigned to user id doesnt exits
			} // $get_case_assigned_to_user_id != ""
		} // while cases


	} // action == "update_assigned_to_unique_users"
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