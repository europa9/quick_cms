<?php 
/**
*
* File: edb/index.php
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


/*- Tables ---------------------------------------------------------------------------- */
$t_edb_home_page_user_remember			= $mysqlPrefixSav . "edb_home_page_user_remember";


/*- Variables -------------------------------------------------------------------------- */

/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	// Me
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);

	

	// If I have visited a station or district we go to that
	// (go to the last used home page)
	$query = "SELECT user_remember_id, user_remember_user_id, user_remember_district_id, user_remember_district_title, user_remember_station_id, user_remember_station_title FROM $t_edb_home_page_user_remember WHERE user_remember_user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_user_remember_id, $get_current_user_remember_user_id, $get_current_user_remember_district_id, $get_current_user_remember_district_title, $get_current_user_remember_station_id, $get_current_user_remember_station_title) = $row;
	if($get_current_user_remember_id != ""){
		if($get_current_user_remember_station_id != ""){
			// Go to station
			$url  = "cases_board_2_view_station.php?district_id=$get_current_user_remember_district_id&station_id=$get_current_user_remember_station_id&l=$l";
			header("Location: $url");
			exit;
		}
		else{
			// Go to station
			$url  = "cases_board_1_view_district.php?district_id=$get_current_user_remember_district_id&l=$l";
			header("Location: $url");
			exit;
		}
	} // remember

	// Check how many districts I am a member of, 
	// If only one then go to that districts cases board
	$districts = 0;
	$query = "SELECT district_member_id, district_member_district_id, district_member_district_title FROM $t_edb_districts_members WHERE district_member_user_id=$my_user_id_mysql ORDER BY district_member_district_title ASC";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_district_member_id, $get_district_member_district_id, $get_district_member_district_title) = $row;
		$districts++;
	}
	if($districts == 1){
		$url  = "cases_board_1_view_district.php?district_id=$get_district_member_district_id&l=$l";
		header("Location: $url");
		exit;
	}
	else{
		/*- Headers ---------------------------------------------------------------------------------- */
		$website_title = "$l_edb";
		if(file_exists("./favicon.ico")){ $root = "."; }
		elseif(file_exists("../favicon.ico")){ $root = ".."; }
		elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
		elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
		include("$root/_webdesign/header.php");


		echo"
		<h1>$l_edb</h1>

		<!-- Cases board -->
			<p><b>$l_please_select_your_district:</b></p>
			<div class=\"vertical\" style=\"width: 100%;\">
					
			<ul style=\"width: 100%;\">
				";
				$districts = 0;
				$query = "SELECT district_member_id, district_member_district_id, district_member_district_title FROM $t_edb_districts_members WHERE district_member_user_id=$my_user_id_mysql ORDER BY district_member_district_title ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_district_member_id, $get_district_member_district_id, $get_district_member_district_title) = $row;
					echo"				";
					echo"<li style=\"width: 100%;\"><a href=\"cases_board_1_view_district.php?district_id=$get_district_member_district_id&l=$l\">$get_district_member_district_title</a></li>\n";
				}
				echo"
			</ul>
			</div>
			<div class=\"clear\"></div>
		<!-- //Cases board -->


		<!-- All district browse -->
			<p><b>$l_browse_all_districts:</b></p>
					
			<div class=\"vertical\" style=\"width: 100%;\">
				<ul style=\"width: 100%;\">
				";
				$query = "SELECT district_id, district_title, district_title_clean, district_number_of_cases_now FROM $t_edb_districts_index ORDER BY district_title ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_district_id, $get_district_title, $get_district_title_clean, $get_district_number_of_cases_now) = $row;
					echo"				";
					echo"<li style=\"width: 100%;\"><a href=\"browse_districts_and_stations.php?action=open_district&amp;district_id=$get_district_id&amp;l=$l\">$get_district_title</a></li>\n";
				}
				echo"
				</ul>
			</div>
			<div class=\"clear\"></div>
		<!-- //All district browse -->


		";
	}
	

} // logged in
else{
	// Log in
	$url = "$root/users/login.php?l=$l&referer=$root/edb";
	header("Location: $url");
	exit;
	// echo"
	// <h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> $l_please_log_in...</h1>
	// <meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/edb\">
	// ";
} // not logged in

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/$webdesignSav/footer.php");
?>