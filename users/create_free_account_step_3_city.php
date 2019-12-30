<?php
/**
*
* File: users/create_free_account_step_3_city.php
* Version 17.46 18.02.2017
* Copyright (c) 2009-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "0";
$pageNoColumnSav      = "2";
$pageAllowCommentsSav = "0";

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

/*- Translation ------------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/users/ts_users.php");

/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_users";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");



/*- Content --------------------------------------------------------------------------- */

/*- Translations -------------------------------------------------------------------- */
include("$root/_admin/_translations/site/$l/users/ts_create_free_account_step_3_city.php");



if(isset($_SESSION['user_id'])){
	// Get user
	$my_user_id = $_SESSION['user_id'];
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	$my_security = $_SESSION['security'];
	$my_security_mysql = quote_smart($link, $my_security);

	$query = "SELECT user_id, user_name, user_language, user_rank, user_points FROM $t_users WHERE user_id=$my_user_id_mysql AND user_security=$my_security_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_name, $get_my_user_language, $get_my_user_rank, $get_my_user_points) = $row;

	$query = "SELECT profile_id, profile_user_id, profile_first_name, profile_middle_name, profile_last_name, profile_address_line_a, profile_address_line_b, profile_zip, profile_city, profile_country, profile_phone, profile_work, profile_university, profile_high_school, profile_languages, profile_website, profile_interested_in, profile_relationship, profile_about, profile_newsletter, profile_views, profile_views_ip_block, profile_privacy FROM $t_users_profile WHERE profile_user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_profile_id, $get_my_profile_user_id, $get_my_profile_first_name, $get_my_profile_middle_name, $get_my_profile_last_name, $get_my_profile_address_line_a, $get_my_profile_address_line_b, $get_my_profile_zip, $get_my_profile_city, $get_my_profile_country, $get_my_profile_phone, $get_my_profile_work, $get_my_profile_university, $get_my_profile_high_school, $get_my_profile_languages, $get_my_profile_website, $get_my_profile_interested_in, $get_my_profile_relationship, $get_my_profile_about, $get_my_profile_newsletter, $get_my_profile_views, $get_my_profile_views_ip_block, $get_my_profile_privacy) = $row;

	if($get_my_user_id == ""){
		echo"<h1>Error</h1><p>Error with user id.</p>"; 
		$_SESSION = array();
		session_destroy();
		die;
	}


	if($process == "1"){
		$inp_city = $_POST['inp_city'];
		$inp_city = output_html($inp_city);
		$inp_city_mysql = quote_smart($link, $inp_city);

		$result = mysqli_query($link, "UPDATE $t_users_profile SET profile_city=$inp_city_mysql WHERE profile_id=$get_my_profile_id");

		$url = "create_free_account_step_4_dob.php?l=$l";
		header("Location: $url");
		exit;
	}
	if($action == ""){
		echo"
		<h1>$l_hello $get_my_user_name</h1>

		<p>
		$l_pleased_to_meet_you
		</p>


		<!-- Form -->
			<form method=\"POST\" action=\"create_free_account_step_3_city.php?l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_city\"]').focus();
			});
			</script>
			<!-- //Focus -->

			<p><b>$l_what_city_do_you_live_in</b><br />
			<input type=\"text\" name=\"inp_city\" size=\"30\" value=\"$get_my_profile_city\" />
			<input type=\"submit\" value=\"$l_save\" class=\"btn\" />
			</p>
			</form>

		<!-- //Form -->

		<hr />
		<p>
		<a href=\"create_free_account_step_4_dob.php?user_id=$my_user_id&amp;l=$l\" class=\"btn btn_default\">$l_skip_this_step</a>
		</p>
		";
	}
}
/*- Footer ---------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");

?>