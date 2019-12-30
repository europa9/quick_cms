<?php
/**
*
* File: users/create_free_account_step_4_dob.php
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
		// Dob
		$inp_user_dob_day = $_POST['inp_user_dob_day'];
		$day_len = strlen($inp_user_dob_day);

		$inp_user_dob_month = $_POST['inp_user_dob_month'];
		$month_len = strlen($inp_user_dob_month);

		$inp_user_dob_year = $_POST['inp_user_dob_year'];
		$year_len = strlen($inp_user_dob_year);

		$inp_user_dob = $inp_user_dob_year . "-" . $inp_user_dob_month . "-" . $inp_user_dob_day;
		$inp_user_dob = output_html($inp_user_dob);
		$inp_user_dob_mysql = quote_smart($link, $inp_user_dob);
		if($inp_user_dob != "--"){
			$result = mysqli_query($link, "UPDATE $t_users SET user_dob=$inp_user_dob_mysql WHERE user_id=$get_my_user_id");
		}

		$url = "create_free_account_step_5_about_me.php?l=$l";
		header("Location: $url");
		exit;
	}
	if($action == ""){
		echo"
		<h1>$l_hello $get_my_user_name</h1>

		<p>
		$l_when_is_your_birthday
		</p>


		<!-- Form -->
			<form method=\"POST\" action=\"create_free_account_step_4_dob.php?l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_city\"]').focus();
			});
			</script>
			<!-- //Focus -->

			<p><b>$l_birthday:</b><br />";
			$dob_array = explode("-", $get_my_user_dob);
			$dob_year = $dob_array[0];
			if(isset($dob_array[1])){
				$dob_month = $dob_array[1];
			}
			else{
				$dob_month = 0;
			}
			if(isset($dob_array[2])){
				$dob_day = $dob_array[2];
			}
			else{
				$dob_day = 0;
			}
					
			echo"
			<select name=\"inp_user_dob_day\">
				<option value=\"\""; if($dob_day == ""){ echo" selected=\"selected\""; } echo">- $l_day -</option>\n";
			for($x=1;$x<32;$x++){
				if($x<10){
					$y = 0 . $x;
				}
				else{
					$y = $x;
				}
				echo"<option value=\"$y\""; if($dob_day == "$x"){ echo" selected=\"selected\""; } echo">$x</option>\n";
			}
			echo"
			</select>
			<select name=\"inp_user_dob_month\">
			<option value=\"\""; if($dob_month == ""){ echo" selected=\"selected\""; } echo">- $l_month -</option>\n";
			$l_month_array[0] = "";
			$l_month_array[1] = "$l_month_january";
			$l_month_array[2] = "$l_month_february";
			$l_month_array[3] = "$l_month_march";
			$l_month_array[4] = "$l_month_april";
			$l_month_array[5] = "$l_month_may";
			$l_month_array[6] = "$l_month_june";
			$l_month_array[7] = "$l_month_juli";
			$l_month_array[8] = "$l_month_august";
			$l_month_array[9] = "$l_month_september";
			$l_month_array[10] = "$l_month_october";
			$l_month_array[11] = "$l_month_november";
			$l_month_array[12] = "$l_month_december";
			for($x=1;$x<13;$x++){
			if($x<10){
				$y = 0 . $x;
			}
			else{
				$y = $x;
			}
			echo"<option value=\"$y\""; if($dob_month == "$y"){ echo" selected=\"selected\""; } echo">$l_month_array[$x]</option>\n";
			}
			echo"
			</select>
			<select name=\"inp_user_dob_year\">
			<option value=\"\""; if($dob_year == ""){ echo" selected=\"selected\""; } echo">- $l_year -</option>\n";
			$year = date("Y");
			for($x=0;$x<150;$x++){
			echo"<option value=\"$year\""; if($dob_year == "$year"){ echo" selected=\"selected\""; } echo">$year</option>\n";
			$year = $year-1;
			}
			echo"
			</select>
			

			<input type=\"submit\" value=\"$l_save\" class=\"btn\" />
			</p>
			</form>

		<!-- //Form -->

		<hr />
		<p>
		<a href=\"create_free_account_step_5_about_me.php?user_id=$my_user_id&amp;l=$l\" class=\"btn btn_default\">$l_skip_this_step</a>
		</p>
		";
	}
}
/*- Footer ---------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");

?>