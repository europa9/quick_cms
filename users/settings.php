<?php
/**
*
* File: users/index.php
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


if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	// Get user
	$user_id = $_SESSION['user_id'];
	$user_id_mysql = quote_smart($link, $user_id);
	$security = $_SESSION['security'];
	$security_mysql = quote_smart($link, $security);

	$query = "SELECT user_id, user_email, user_name, user_alias, user_password, user_password_replacement, user_password_date, user_salt, user_security, user_language, user_gender, user_height, user_measurement, user_dob, user_date_format, user_registered, user_last_online, user_rank, user_points, user_likes, user_dislikes, user_status, user_login_tries, user_last_ip, user_synchronized, user_verified_by_moderator, user_notes FROM $t_users WHERE user_id=$user_id_mysql AND user_security=$security_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_user_id, $get_user_email, $get_user_name, $get_user_alias, $get_user_password, $get_user_password_replacement, $get_user_password_date, $get_user_salt, $get_user_security, $get_user_language, $get_user_gender, $get_user_height, $get_user_measurement, $get_user_dob, $get_user_date_format, $get_user_registered, $get_user_last_online, $get_user_rank, $get_user_points, $get_user_likes, $get_user_dislikes, $get_user_status, $get_user_login_tries, $get_user_last_ip, $get_user_synchronized, $get_user_verified_by_moderator, $get_user_notes) = $row;

	$query = "SELECT profile_id, profile_user_id, profile_first_name, profile_middle_name, profile_last_name, profile_address_line_a, profile_address_line_b, profile_zip, profile_city, profile_country, profile_phone, profile_work, profile_university, profile_high_school, profile_languages, profile_website, profile_interested_in, profile_relationship, profile_about, profile_newsletter, profile_views, profile_views_ip_block, profile_privacy FROM $t_users_profile WHERE profile_user_id=$user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_profile_id, $get_profile_user_id, $get_profile_first_name, $get_profile_middle_name, $get_profile_last_name, $get_profile_address_line_a, $get_profile_address_line_b, $get_profile_zip, $get_profile_city, $get_profile_country, $get_profile_phone, $get_profile_work, $get_profile_university, $get_profile_high_school, $get_profile_languages, $get_profile_website, $get_profile_interested_in, $get_profile_relationship, $get_profile_about, $get_profile_newsletter, $get_profile_views, $get_profile_views_ip_block, $get_profile_privacy) = $row;

	if($get_user_id == ""){
		echo"<h1>Error</h1><p>Error with user id.</p>"; 
		$_SESSION = array();
		session_destroy();
		die;
	}

	if($action == "save"){

		
		$inp_user_measurement = $_POST['inp_user_measurement'];
		$inp_user_measurement = output_html($inp_user_measurement);
		$inp_user_measurement_mysql = quote_smart($link, $inp_user_measurement);


		$inp_user_language = $_POST['inp_user_language'];
		$inp_user_language = output_html($inp_user_language);
		$inp_user_language_mysql = quote_smart($link, $inp_user_language);

		$inp_user_date_format = $_POST['inp_user_date_format'];
		$inp_user_date_format = output_html($inp_user_date_format);
		$inp_user_date_format_mysql = quote_smart($link, $inp_user_date_format);

		$inp_privacy = $_POST['inp_privacy'];
		$inp_privacy = output_html($inp_privacy);
		$inp_privacy_mysql = quote_smart($link, $inp_privacy);



		$result = mysqli_query($link, "UPDATE $t_users SET user_language=$inp_user_language_mysql, user_date_format=$inp_user_date_format_mysql, user_measurement=$inp_user_measurement_mysql WHERE user_id=$user_id_mysql");

		$result = mysqli_query($link, "UPDATE $t_users_profile SET profile_privacy=$inp_privacy_mysql WHERE profile_id=$get_profile_id");

		
		$url = "settings.php?l=$inp_user_language&ft=success&fm=changes_saved"; 
		if($process == "1"){
			header("Location: $url");
		}
		else{
			echo"<meta http-equiv=\"refresh\" content=\"1;url=$url\">";
		}
		exit;
	}
	if($action == ""){
		echo"
		<h1>$l_settings</h1>


		<!-- You are here -->
			<div class=\"you_are_here\">
				<p>
				<b>$l_you_are_here:</b><br />
				<a href=\"my_profile.php?l=$l\">$l_my_profile</a>
				&gt; 
				<a href=\"settings.php?l=$l\">$l_settings</a>
				</p>
			</div>
		<!-- //You are here -->


		<form method=\"POST\" action=\"settings.php?action=save&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\" name=\"nameform\">

		<!-- Feedback -->
			";
			if($ft != "" && $fm != ""){
				if($fm == "changes_saved"){
					$fm = "$l_changes_saved";
				}
				else{
					$fm = "$ft";
				}
				echo"<div class=\"$ft\"><p>$fm</p></div>";
			}
			echo"
		<!-- //Feedback -->


		<!-- Focus -->
		<script>
		\$(document).ready(function(){
			\$('[name=\"inp_profile_newsletter\"]').focus();
		});
		</script>
		<!-- //Focus -->


		<p>
		$l_prefered_messurement:<br />
		<select name=\"inp_user_measurement\"> 
			<option value=\"imperial\""; if($get_user_measurement == "imperial"){ echo" selected=\"selected\""; } echo">$l_imperial_units</option>
			<option value=\"metric\""; if($get_user_measurement == "metric"){ echo" selected=\"selected\""; } echo">$l_metric_system</option>
		</select>
		</p>

		<p>
		$l_language:<br />
		<select name=\"inp_user_language\">";

		$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;

			$flag_path 	= "_design/gfx/flags/16x16/$get_language_active_flag" . "_16x16.png";


			echo"			";
			echo"<option value=\"$get_language_active_iso_two\""; if($get_language_active_iso_two == "$get_user_language"){ echo" selected=\"selected\""; } echo">$get_language_active_name</option>\n";
		}
		echo"
		</select>
		</p>


		<p>
		$l_date_format:<br />
		<select name=\"inp_user_date_format\"> 
			<option value=\"l jS \of F Y\""; if($get_user_date_format == "l jS \of F Y"){ echo" selected=\"selected\""; } echo">Monday 14th of August 2005</option>
			<option value=\"Y-m-d\""; if($get_user_date_format == "Y-m-d"){ echo" selected=\"selected\""; } echo">2005-08-14</option>
			<option value=\"l d. f Y\""; if($get_user_date_format == "l d. f Y"){ echo" selected=\"selected\""; } echo">Monday 14. august 2005</option>
		</select>
		</p>

		<p>
		$l_profile_privacy:<br />
		<select name=\"inp_privacy\"> 
			<option value=\"public\""; if($get_profile_privacy == "public"){ echo" selected=\"selected\""; } echo">$l_public</option>
			<option value=\"registered_users\""; if($get_profile_privacy == "registered_users"){ echo" selected=\"selected\""; } echo">$l_registered_users</option>
			<option value=\"friends\""; if($get_profile_privacy == "friends"){ echo" selected=\"selected\""; } echo">$l_friends</option>
		</select>
		</p>


		<p>
		<input type=\"submit\" value=\"$l_save\" class=\"btn btn-success\" />
		</p>

		</form>

		";
	}
}
else{
	echo"
	<table>
	 <tr> 
	  <td style=\"padding-right: 6px;\">
		<p>
		<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"Loading\" />
		</p>
	  </td>
	  <td>
		<h1>Loading</h1>
	  </td>
	 </tr>
	</table>
		
	<meta http-equiv=\"refresh\" content=\"1;url=index.php\">
	";
}
/*- Footer ---------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");

?>