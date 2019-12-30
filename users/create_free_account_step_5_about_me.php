<?php
/**
*
* File: users/create_free_account_step_5_about_me.php
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

	$query = "SELECT user_id, user_email, user_name, user_alias, user_password, user_password_replacement, user_password_date, user_salt, user_security, user_language, user_gender, user_height, user_measurement, user_dob, user_date_format, user_registered, user_registered_time, user_last_online, user_last_online_time, user_rank, user_points, user_points_rank, user_likes, user_dislikes, user_status, user_login_tries, user_last_ip, user_synchronized, user_verified_by_moderator, user_notes FROM $t_users WHERE user_id=$my_user_id_mysql AND user_security=$my_security_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_password, $get_my_user_password_replacement, $get_my_user_password_date, $get_my_user_salt, $get_my_user_security, $get_my_user_language, $get_my_user_gender, $get_my_user_height, $get_my_user_measurement, $get_my_user_dob, $get_my_user_date_format, $get_my_user_registered, $get_my_user_registered_time, $get_my_user_last_online, $get_my_user_last_online_time, $get_my_user_rank, $get_my_user_points, $get_my_user_points_rank, $get_my_user_likes, $get_my_user_dislikes, $get_my_user_status, $get_my_user_login_tries, $get_my_user_last_ip, $get_my_user_synchronized, $get_my_user_verified_by_moderator, $get_my_user_notes) = $row;

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
		
		$inp_profile_about_me = $_POST['inp_profile_about_me'];
		$inp_profile_about_me = output_html($inp_profile_about_me);
		$inp_profile_about_me_mysql = quote_smart($link, $inp_profile_about_me);

		$result = mysqli_query($link, "UPDATE $t_users_profile SET profile_about=$inp_profile_about_me_mysql WHERE profile_id=$get_my_profile_id");
		

		$url = "create_free_account_step_6_image.php?l=$l";
		header("Location: $url");
		exit;
	}
	if($action == ""){
		echo"
		<h1>$l_hello $get_my_user_name</h1>

		<p>
		$l_good_to_get_to_know_you
		</p>

		<p>
		$l_can_you_please_give_a_short_introduction_about_yourself
		</p>


		<!-- Form -->
			<form method=\"POST\" action=\"create_free_account_step_5_about_me.php?l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_profile_about_me\"]').focus();
			});
			</script>
			<!-- //Focus -->

			<p><b>$l_about_me:</b><br />
			<textarea name=\"inp_profile_about_me\" rows=\"5\" cols=\"40\">"; $get_my_profile_about = str_replace("<br />", "\n", $get_my_profile_about); echo"$get_my_profile_about</textarea>
			</p>
			
			<p>
			<input type=\"submit\" value=\"$l_save\" class=\"btn\" />
			</p>
			</form>

		<!-- //Form -->

		<hr />
		<p>
		<a href=\"create_free_account_step_6_image.php?user_id=$my_user_id&amp;l=$l\" class=\"btn btn_default\">$l_skip_this_step</a>
		</p>
		";
	}
}
/*- Footer ---------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");

?>