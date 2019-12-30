<?php 
/**
*
* File: stottegruppe/index.php
* Version 
* Date 2018-04-01 09:06:22
* Copyright (c) 2011-2018 Nettport.com
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "11";
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

/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "St&oslash;ttegruppe";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */
echo"
<h1>St&oslash;ttegruppe - gratis nettm&oslash;te om slanking, kosthold og trening hver mandag</h1>

<img src=\"_gfx/badge_gratis.png\" alt=\"badge.png\" style=\"float: right;padding: 0px 0px 0px 10px\" />
<div class=\"stottegruppe_main\">
<h2>Hva er nettm&oslash;tet?</h2>
<p style=\"padding-left: 15px;\"><img src=\"_gfx/check.png\" alt=\"check.png\" /> Ukentlig gruppem&oslash;te p&aring; Skype</p>
<p style=\"padding-left: 15px;\"><img src=\"_gfx/check.png\" alt=\"check.png\" /> Hver mandag 21:00</p>
<p style=\"padding-left: 15px;\"><img src=\"_gfx/check.png\" alt=\"check.png\" /> F&oslash;rste mann til m&oslash;lla - maks 25 deltagere pr uke</p>

<h2 style=\"padding-top: 20px;\">Hva snakker vi om?</h2>
<p style=\"padding-left: 15px;\"><img src=\"_gfx/check.png\" alt=\"check.png\" /> Presentasjonsrunde av nye personer</p>
<p style=\"padding-left: 15px;\"><img src=\"_gfx/check.png\" alt=\"check.png\" /> Hvordan g&aring;r det med <b>slanking</b>, <b>kosthold</b> og <b>trening</b>?</p>
<p style=\"padding-left: 15px;\"><img src=\"_gfx/check.png\" alt=\"check.png\" /> Du kan stille sp&oslash;rsm&aring;l til <b>kostholds- og treningseksperter</b></p>
<p style=\"padding-left: 15px;\"><img src=\"_gfx/check.png\" alt=\"check.png\" /> Foredrag</p>
</div>



";



// Next monday
$next_monday = strtotime('next monday');
$current_week_no = date('W');
$next_monday_week_no = date('W', $next_monday);
$next_monday_year_no = date('Y', $next_monday);
$next_monday_date = date('d.m.y', $next_monday);

/*if($next_monday_week_no != "$current_week_no"){
	$next_monday_week_no = date('W');
	$next_monday_year_no = date('Y');
	$next_monday_date = date('d.m.y');
}*/

// Find moderator of that week


$query = "SELECT moderator_user_id, moderator_user_email, moderator_user_name FROM $t_users_moderator_of_the_week WHERE moderator_week=$next_monday_week_no AND moderator_year=$next_monday_year_no";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_moderator_user_id, $get_moderator_user_email, $get_moderator_user_name) = $row;

if($get_moderator_user_id == ""){
	// Create moderator of the week
	$week = "$next_monday_week_no";
	$year = "$next_monday_year_no";
	include("$root/_admin/_functions/create_moderator_of_the_week.php");

	$query = "SELECT moderator_user_id, moderator_user_email, moderator_user_name FROM $t_users_moderator_of_the_week WHERE moderator_week=$next_monday_week_no AND moderator_year=$next_monday_year_no";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_moderator_user_id, $get_moderator_user_email, $get_moderator_user_name) = $row;

}
$get_moderator_user_email = str_replace(".", '<img src="_gfx/punktum.png" alt="punktum" />', $get_moderator_user_email);
$get_moderator_user_email = str_replace("@", '<img src="_gfx/snabel.png" alt="snabel" />', $get_moderator_user_email);


echo"
	<div style=\"height: 20px;\"></div>
	<table class=\"hor-zebra\">
	 <tbody>
	  <tr>
	   <td style=\"text-align: center;\">
		<h2>Neste m&oslash;te er $next_monday_date kl 21:00</h2>
		<p>For &aring; bli med legg til f&oslash;lgende e-post adresse i Skype:</p>
		<p>$get_moderator_user_email</p>

		<p>Og skriv at du &oslash;nsker &aring; v&aelig;re med!</p>
	   </td>
	  </tr>
	 </tbody>
	</table>
	<div style=\"height: 20px;\"></div>


";


/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>