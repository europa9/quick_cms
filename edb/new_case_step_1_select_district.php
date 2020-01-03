<?php 
/**
*
* File: edb/new_case_step_1_select_district.php
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


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_edb - $l_new_case";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){

	// Me
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);

	echo"
	<h1>$l_new_case</h1>

	<!-- Where am I ? -->
		<p><b>$l_you_are_here:</b><br />
		<a href=\"index.php?l=$l\">$l_edb</a>
		&gt;
		<a href=\"new_case_step_1_select_district.php?l=$l\">$l_new_case</a>
		</p>
		<div style=\"height: 10px;\"></div>
	<!-- //Where am I ? -->

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

	<!-- Select district to place case on -->
		<p>$l_please_select_the_district_where_the_case_belongs</p>
		<p><b>$l_districts:</b></p>
		<div class=\"vertical\" style=\"width: 100%;\">
					
			<ul style=\"width: 100%;\">
				";
				$districts = 0;
				$query = "SELECT district_member_id, district_member_district_id, district_member_district_title FROM $t_edb_districts_members WHERE district_member_user_id=$my_user_id_mysql ORDER BY district_member_district_title ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_district_member_id, $get_district_member_district_id, $get_district_member_district_title) = $row;
					echo"				";
					echo"<li style=\"width: 100%;\"><a href=\"new_case_step_2_select_station.php?district_id=$get_district_member_district_id&amp;l=$l\">$get_district_member_district_title</a></li>\n";
					$districts++;
				}
				echo"
			</ul>";
			if($districts == 1){
				echo"
				<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> $l_auto_transferring_you_to_the_only_district_available...</h1>
				<meta http-equiv=\"refresh\" content=\"0;url=new_case_step_2_select_station.php?district_id=$get_district_member_district_id&amp;l=$l\">
				";

			}
			echo"
		</div>
		<div class=\"clear\"></div>
	<!-- //Select district to place case on -->
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