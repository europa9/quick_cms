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
include("$root/_admin/_data/logo.php");
include("$root/_admin/_data/config/user_system.php");

/*- Tables ---------------------------------------------------------------------------- */
$t_search_engine_index 		= $mysqlPrefixSav . "search_engine_index";
$t_search_engine_access_control = $mysqlPrefixSav . "search_engine_access_control";

$t_stats_users_registered_per_month = $mysqlPrefixSav . "stats_users_registered_per_month";
$t_stats_users_registered_per_year  = $mysqlPrefixSav . "stats_users_registered_per_year";
$t_stats_users_registered_per_week  = $mysqlPrefixSav . "stats_users_registered_per_week";

/*- Translation ------------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/users/ts_users.php");
include("$root/_admin/_translations/site/$l/users/ts_create_free_account.php");

/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_users";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");


/*- Variables ----------------------------------------------------------------------- */

if(!(isset($_SESSION['user_id']))){

	if($_SESSION['antispam_ok']){

		if($action == "create_new_user"){
			// Dates
			$datetime = date("Y-m-d H:i:s");
			$datetime_saying = date("j M Y H:i");


			// User information
			$inp_alias = $_POST['inp_alias'];
			$inp_alias = preg_replace("/[^ \w]+/", "", $inp_alias);
			$inp_alias = output_html($inp_alias);
			$inp_alias = substr($inp_alias, 0, 20);
			$inp_alias_mysql = quote_smart($link, $inp_alias);
			if(empty($inp_alias)){
				$ft = "warning";
				$fm = "users_please_enter_a_alias";
				$action = "";
			}

			$inp_email = $_POST['inp_email'];
			$inp_email = output_html($inp_email);
			$inp_email = strtolower($inp_email);
			$inp_email_mysql = quote_smart($link, $inp_email);
			if(empty($inp_email)){
				$ft = "warning";
				$fm = "users_please_enter_your_email_address";
				$action = "";
			}
			else{
				// Does that alias belong to someone else?
				$query = "SELECT user_id FROM $t_users WHERE user_name=$inp_alias_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_user_id) = $row;
				if($get_user_id != ""){
					$ft = "warning";
					$fm = "users_alias_taken";
					$action = "";
				}

				// Does that e-mail belong to someone else?
				$query = "SELECT user_id FROM $t_users WHERE user_email=$inp_email_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_user_id) = $row;
				if($get_user_id != ""){
					$ft = "warning";
					$fm = "users_email_taken";
					$action = "";
				}
			}

			$inp_password = $_POST['inp_password'];
			if(empty($inp_password)){
				$ft = "warning";
				$fm = "users_please_enter_a_password";
				$action = "";
			}
			
			$inp_gender = $_POST['inp_gender'];
			$inp_gender = output_html($inp_gender);
			$inp_gender_mysql = quote_smart($link, $inp_gender);
			if(empty($inp_gender)){
				$ft = "warning";
				$fm = "please_select_your_gender";
				$action = "";
			}


			$inp_country = $_POST['inp_country'];
			$inp_country = output_html($inp_country);
			$inp_country = ucfirst($inp_country);
			$inp_country_mysql = quote_smart($link, $inp_country);
			if(empty($inp_country)){
				$ft = "warning";
				$fm = "please_select_a_country";
				$action = "";
			}
	

			// Find the messurement the last person registrered used
			$query = "SELECT profile_id FROM $t_users_profile WHERE profile_country=$inp_country_mysql ORDER BY profile_id DESC LIMIT 0,1";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_profile_user_id) = $row;

			if($get_profile_user_id != ""){
				$query = "SELECT user_measurement FROM $t_users WHERE user_id=$get_profile_user_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($inp_mesurment) = $row;
			}
			else{
				$inp_mesurment = "";
			}
			if($inp_mesurment == ""){	
				if($inp_country == "United States"){
					$inp_mesurment = "i";
				}
				else{
					$inp_mesurment = "m";
				}
			}
			$inp_mesurment = output_html($inp_mesurment);
			$inp_mesurment_mysql = quote_smart($link, $inp_mesurment);

			$inp_newsletter = $_POST['inp_newsletter'];
			$inp_newsletter = output_html($inp_newsletter);
			$inp_newsletter_mysql = quote_smart($link, $inp_newsletter);

	
			if($action == "create_new_user"){
			
				// Create salt
				$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    				$charactersLength = strlen($characters);
    				$salt = '';
    				for ($i = 0; $i < 6; $i++) {
        				$salt .= $characters[rand(0, $charactersLength - 1)];
    				}
				$inp_user_salt_mysql = quote_smart($link, $salt);

				// Password
				$inp_user_password_encrypted =  sha1($inp_password);
				$inp_user_password_mysql = quote_smart($link, $inp_user_password_encrypted);

				// Security
				$inp_user_security = rand(0,9999);

				// Language
				$inp_user_language = output_html($l);
				$inp_user_language_mysql = quote_smart($link, $inp_user_language);

				// Registered
				$datetime = date("Y-m-d H:i:s");
				$time = time();

				// Date format
				if($l == "no"){
					$inp_user_date_format = "l d. f Y";
				}
				else{
					$inp_user_date_format = "l jS \of F Y";
				}
				$inp_user_date_format_mysql = quote_smart($link, $inp_user_date_format);


				// Ip
				$inp_user_last_ip_mysql = quote_smart($link, $inp_ip);


				// Insert user
				mysqli_query($link, "INSERT INTO $t_users
				(user_id, user_email, user_name, user_alias, user_password, user_salt, user_security, user_language, user_measurement, user_date_format, user_registered, user_registered_time, user_last_online, user_last_online_time, user_rank, user_points, user_points_rank, user_likes, user_dislikes, user_last_ip, user_marked_as_spammer) 
				VALUES 
				(NULL, $inp_email_mysql, $inp_alias_mysql, $inp_alias_mysql, $inp_user_password_mysql, $inp_user_salt_mysql, '$inp_user_security', $inp_user_language_mysql, $inp_mesurment_mysql, $inp_user_date_format_mysql, '$datetime', '$time', '$datetime', '$time', 'user', '0', 'Newbie', '0', '0', $inp_user_last_ip_mysql, '0')")
				or die(mysqli_error($link));

				// Get user id
				$query = "SELECT user_id FROM $t_users WHERE user_email=$inp_email_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_my_user_id) = $row;
			
				// Insert profile			
				mysqli_query($link, "INSERT INTO $t_users_profile
				(profile_id, profile_user_id, profile_country, profile_newsletter, profile_views, profile_privacy) 
				VALUES 
				(NULL, '$get_my_user_id', $inp_country_mysql, $inp_newsletter_mysql, '0', 'public')")
				or die(mysqli_error($link));


				// Search engine
				if($configShowUsersOnSearchEngineIndexSav == "1"){

					$inp_index_title = "$inp_alias | $l_users";
					$inp_index_title_mysql = quote_smart($link, $inp_index_title);

					$inp_index_url = "users/view_profile.php?user_id=$get_my_user_id";
					$inp_index_url_mysql = quote_smart($link, $inp_index_url);

					// Insert
					mysqli_query($link, "INSERT INTO $t_search_engine_index 
					(index_id, index_title, index_url, index_short_description, index_keywords, 
					index_module_name, index_module_part_name, index_module_part_id, index_reference_name, index_reference_id, 
					index_has_access_control, index_is_ad, index_created_datetime, index_created_datetime_print, index_language, 
					index_unique_hits) 
					VALUES 
					(NULL, $inp_index_title_mysql, $inp_index_url_mysql, '', '', 
					'users', 'users', '0', 'user_id', '$get_my_user_id',
					'0', '0', '$datetime', '$datetime_saying', '',
					0)")
					or die(mysqli_error($link));

				}

			
				// Send welcome mail
				$host = $_SERVER['HTTP_HOST'];

				$subject = $l_welcome_to . " " . $configWebsiteTitleSav;
			
				$message = "<html>\n";
				$message = $message. "<head>\n";
				$message = $message. "  <title>$subject</title>\n";
				$message = $message. " </head>\n";
				$message = $message. "<body>\n";

				$message = $message . "<p><a href=\"$configSiteURLSav\"><img src=\"$configSiteURLSav/$logoPathSav/$logoFileSav\" alt=\"($configWebsiteTitleSav logo)\" /></a></p>\n\n";
				$message = $message . "<h1>$l_welcome_to $configWebsiteTitleSav</h1>\n\n";
				$message = $message . "<p>$l_hi $inp_alias,<br /><br />\n";
				$message = $message . "$l_thank_you_for_signing_up\n";
				$message = $message . "$l_we_hope_you_will_be_pleased_with_your_membership</p>";

				$message = $message . "<p><b>$l_your_information</b><br />\n\n";
				$message = $message . "$l_email_address: $inp_email<br />\n";
				$message = $message . "$l_alias: $inp_alias</p>\n";


				if($configUsersHasToBeVerifiedByModeratorSav == "1"){
					$message = $message . "<p>$l_your_account_will_be_examined_by_a_moderator_shortly\n";
					$message = $message . "$l_it_will_after_examination_be_approved</p>\n";
				}

				$message = $message . "<p>\n\n--<br />\nBest regards<br />\n$configWebsiteTitleSav<br />\n<a href=\"$configSiteURLSav\">$configSiteURLSav</a></p>";
				$message = $message. "</body>\n";
				$message = $message. "</html>\n";



				// Preferences for Subject field
				$headers[] = 'MIME-Version: 1.0';
				$headers[] = 'Content-type: text/html; charset=utf-8';
				$headers[] = "From: $configFromNameSav <" . $configFromEmailSav . ">";
				if($configMailSendActiveSav == "1"){
					mail($inp_email, $subject, $message, implode("\r\n", $headers));
				}
				
			

				// Setup email notifications
				$inp_es_user_id = quote_smart($link, $get_my_user_id);
				mysqli_query($link, "INSERT INTO $t_users_email_subscriptions
				(es_id, es_user_id, es_type, es_on_off) 
				VALUES 
				(NULL, $inp_es_user_id, 'friend_request', '1'),
				(NULL, $inp_es_user_id, 'status_comments', '1'),
				(NULL, $inp_es_user_id, 'status_replies', '1'),
				(NULL, $inp_es_user_id, 'my_birthday', '1')")
				or die(mysqli_error($link));

				// Statistics
				// --> weekly
				$day = date("d");
				$month = date("m");
				$month_saying = date("M");
				$week = date("W");
				$year = date("Y");
				$week = date("W");

				// User registered :: Year
				$query = "SELECT stats_registered_id, stats_registered_users_registed FROM $t_stats_users_registered_per_year WHERE stats_registered_year=$year";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_stats_registered_id, $get_stats_registered_users_registed) = $row;
				if($get_stats_registered_id == ""){
					mysqli_query($link, "INSERT INTO $t_stats_users_registered_per_year 
					(stats_registered_id, stats_registered_year, stats_registered_users_registed) 
					VALUES 
					(NULL, $year, 1)")
					or die(mysqli_error($link));
				}
				else{
					$inp_counter = $get_stats_registered_users_registed+1;

					$result = mysqli_query($link, "UPDATE $t_stats_users_registered_per_year SET stats_registered_users_registed=$inp_counter WHERE stats_registered_id=$get_stats_registered_id") or die(mysqli_error($link));
				}

				// User registered :: Month
				$query = "SELECT stats_registered_id, stats_registered_users_registed FROM $t_stats_users_registered_per_month WHERE stats_registered_month=$month AND stats_registered_year=$year";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_stats_registered_id, $get_stats_registered_users_registed) = $row;
				if($get_stats_registered_id == ""){
					mysqli_query($link, "INSERT INTO $t_stats_users_registered_per_month 
					(stats_registered_id, stats_registered_month, stats_registered_month_saying, stats_registered_year, stats_registered_users_registed) 
					VALUES 
					(NULL, $month, '$month_saying', $year, 1)")
					or die(mysqli_error($link));
				}
				else{
					$inp_counter = $get_stats_registered_users_registed+1;

					$result = mysqli_query($link, "UPDATE $t_stats_users_registered_per_month SET stats_registered_users_registed=$inp_counter WHERE stats_registered_id=$get_stats_registered_id") or die(mysqli_error($link));
				}

				// User registered :: Week
				$query = "SELECT stats_registered_id, stats_registered_users_registed FROM $t_stats_users_registered_per_week WHERE stats_registered_week=$week AND stats_registered_year=$year";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_stats_registered_id, $get_stats_registered_users_registed) = $row;
				if($get_stats_registered_id == ""){
					mysqli_query($link, "INSERT INTO $t_stats_users_registered_per_week 
					(stats_registered_id, stats_registered_week, stats_registered_year, stats_registered_users_registed, stats_registered_users_registed_diff_from_last_week) 
					VALUES 
					(NULL, $week, $year, 1, 1)")
					or die(mysqli_error($link));
				}
				else{
					$inp_counter = $get_stats_registered_users_registed+1;

					$result = mysqli_query($link, "UPDATE $t_stats_users_registered_per_week SET stats_registered_users_registed=$inp_counter WHERE stats_registered_id=$get_stats_registered_id") or die(mysqli_error($link));
				}


				// Who is moderator of the week?
				$query = "SELECT moderator_user_id, moderator_user_email, moderator_user_name FROM $t_users_moderator_of_the_week WHERE moderator_week=$week AND moderator_year=$year";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_moderator_user_id, $get_moderator_user_email, $get_moderator_user_name) = $row;
				if($get_moderator_user_id == ""){
					// Create moderator of the week
					include("$root/_admin/_functions/create_moderator_of_the_week.php");
					
					$query = "SELECT moderator_user_id, moderator_user_email, moderator_user_name FROM $t_users_moderator_of_the_week WHERE moderator_week=$week AND moderator_year=$year";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_moderator_user_id, $get_moderator_user_email, $get_moderator_user_name) = $row;
				}


				// Do we need to approve/verify user?
				if($configUsersHasToBeVerifiedByModeratorSav == "0"){
			

					// Set user verified
					$result = mysqli_query($link, "UPDATE $t_users SET user_verified_by_moderator='1' WHERE user_id='$get_my_user_id'");


					// Login user
					$_SESSION['user_id'] = "$get_my_user_id";
					$_SESSION['security'] = "$inp_user_security";


					// Send e-mail to moderators that there is a new user
					
					$subject = "New user $inp_alias at $configWebsiteTitleSav";

					$message = "<html>\n";
					$message = $message. "<head>\n";
					$message = $message. "  <title>$subject</title>\n";
					$message = $message. " </head>\n";
					$message = $message. "<body>\n";

					$message = $message . "<p><a href=\"$configSiteURLSav\"><img src=\"$configSiteURLSav/$logoPathSav/$logoFileSav\" alt=\"$logoFileSav\" /></a></p>\n\n";
					$message = $message . "<h1>New user $inp_alias</h1>\n\n";
					$message = $message . "<p>\n";
					$message = $message . "E-mail: $inp_email<br />\n";
					$message = $message . "Alias: $inp_alias<br />\n";
					$message = $message . "Country: $inp_country <br />\n";
					$message = $message . "Newsletter: $inp_newsletter<br />\n";
					$message = $message . "</p>\n";
					$message = $message . "<p><a href=\"$configSiteURLSav/users/view_profile.php?user_id=$get_my_user_id\">View profile</a></p>\n";

					$message = $message . "<p>\n\n--<br />\nBest regards<br />\n$get_moderator_user_name at $configWebsiteTitleSav<br />\n";
					$message = $message . "<a href=\"$configSiteURLSav/index.php?l=$l\">$configSiteURLSav</a></p>";
					$message = $message. "</body>\n";
					$message = $message. "</html>\n";



					// Preferences for Subject field
					$headers_mail[] = 'MIME-Version: 1.0';
					$headers_mail[] = 'Content-type: text/html; charset=utf-8';
					$headers_mail[] = "From: $configFromNameSav <" . $configFromEmailSav . ">";
					if($configMailSendActiveSav == "1"){
						mail($get_moderator_user_email, $subject, $message, implode("\r\n", $headers_mail));
					}


				
					$url = "create_free_account_step_3_city.php?l=$l"; 
					echo"
					<table>
					 <tr> 
					  <td style=\"padding-right: 6px;vertical-align: top;\">
						<span>
						<img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"margin:0;padding: 23px 0px 0px 0px;\" />
						</span>
					  </td>
					  <td>
						<h1 style=\"border:0;margin:0;padding: 20px 0px 0px 0px;\">$l_hi $inp_alias!</h1>
					  </td>
					 </tr>
					</table>

					<p>$l_nice_to_meet_you</p>
					

					<meta http-equiv=\"refresh\" content=\"1;url=$url\">";
				}
				else{

					// Set user not verified
					$result = mysqli_query($link, "UPDATE $t_users SET user_verified_by_moderator='0' WHERE user_id='$get_my_user_id'");



					// Mail approve URLs
					$pageURL = 'http';
					$pageURL .= "://";

					if ($_SERVER["SERVER_PORT"] != "80") {
						$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
					} 
					else {
						$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
					}
	
					$view_link = $configSiteURLSav . "/users/view_profile.php?user_id=$get_my_user_id";
					$approve_link = $configControlPanelURLSav . "/index.php?open=users&page=pending_users&action=approve&user_id=$get_my_user_id";
					$disapprove_link = $configControlPanelURLSav . "/index.php?open=users&page=pending_users&action=disapprove&user_id=$get_my_user_id";

					$user_agent = $_SERVER['HTTP_USER_AGENT'];
					$user_agent = output_html($user_agent);

					$subject = "Please approve user $inp_alias at $configWebsiteTitleSav";

					$message = "<html>\n";
					$message = $message. "<head>\n";
					$message = $message. "  <title>$subject</title>\n";
					$message = $message. " </head>\n";
					$message = $message. "<body>\n";

					$message = $message . "<p>Hi $get_moderator_user_name,</p>\n\n";
					$message = $message . "<p><b>Summary:</b><br />There is a new user at $host. Please approve or disapprove.</p>\n\n";
					$message = $message . "<p style=\"margin-bottom:0;padding-bottom:0;\"><b>User:</b><br />\n<ul style=\"margin:0px 0px 5px 5px;padding:0px 0px 5px 5px;\">\n<li><span>E-mail: $inp_email</span></li>\n<li><span>User name: $inp_alias</span></li>\n<li><span>Language: $inp_user_language</span></li>\n<li><span>Date: $datetime</span></li>\n<li><span>Agent: $user_agent</span></li>\n<li><span>IP: <a href=\"https://www.google.no/search?q=$inp_ip\">$inp_ip</a></span></li>\n</ul>\n\n";
					$message = $message . "<p><b>Actions:</b><br />\n";
					$message = $message . "View: <a href=\"$view_link\">$view_link</a><br />";
					$message = $message . "Approve: <a href=\"$approve_link\">$approve_link</a><br />";
					$message = $message . "Disapprove: <a href=\"$disapprove_link\">$disapprove_link</a></p>";
					$message = $message . "<p>\n\n--<br />\nBest regards<br />\n$host</p>";
					$message = $message. "</body>\n";
					$message = $message. "</html>\n";


					// Preferences for Subject field
					$headers_email[] = 'MIME-Version: 1.0';
					$headers_email[] = 'Content-type: text/html; charset=utf-8';
					$headers_email[] = "From: $configFromNameSav <" . $configFromEmailSav . ">";
					if($configMailSendActiveSav == "1"){
						mail($get_moderator_user_email, $subject, $message, implode("\r\n", $headers_email));
					}


					$url = "index.php?page=create_free_account_awaiting_approvement&l=$l"; 
					if($process == "1"){
						header("Location: $url");
					}
					else{
						echo"
						<table>
						 <tr> 
						  <td style=\"padding-right: 6px;vertical-align: top;\">
							<span>
							<img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"margin:0;padding: 23px 0px 0px 0px;\" />
							</span>
						  </td>
						  <td>
							<h1 style=\"border:0;margin:0;padding: 20px 0px 0px 0px;\">Loading</h1>
						  </td>
						 </tr>
						</table>

						<meta http-equiv=\"refresh\" content=\"1;url=$url\">";
					}
					exit;

				}
			
			}
		}
		if($action == "" OR $action == "check_antispam"){

			echo"
			<h1>$l_menu_create_free_account</h1>

			<form method=\"POST\" action=\"create_free_account_step_2_user.php?action=create_new_user&amp;l=$l\" enctype=\"multipart/form-data\">

			<!-- Feedback -->
			";
			if($ft != "" && $fm != ""){
				if($fm == "users_please_enter_a_alias"){
					$fm = "$l_users_please_enter_a_alias";
				}
				elseif($fm == "users_alias_taken"){
					$fm = "$l_users_alias_taken";
				}
				elseif($fm == "users_email_taken"){
					$fm = "$l_users_email_taken";
				}
				elseif($fm == "users_please_enter_a_password"){
					$fm = "$l_users_please_enter_a_password";
				}
				elseif($fm == "server_error"){
					$fm = "$l_server_error";
				}
				else{
					$fm = ucfirst($fm);
				}
				echo"<div class=\"$ft\"><p>$fm</p></div>";
			}
			echo"
			<!-- //Feedback -->


			<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_alias\"]').focus();
			});
			</script>
			<!-- //Focus -->


			<p>
			$l_users_about_registration
			</p>

			<h2>$l_user_information</h2>
			<p>
			$l_user_alias*:<br />
			<input type=\"text\" name=\"inp_alias\" size=\"45\" value=\""; if(isset($inp_alias)){ echo"$inp_alias"; } echo"\" /><br />
			</p>

			<p>
			$l_email_address*:<br />
			<input type=\"text\" name=\"inp_email\" size=\"45\" value=\""; if(isset($inp_email)){ echo"$inp_email"; } echo"\" /><br />
			</p>

			<p>
			$l_wanted_password*:<br />
			<input type=\"password\" name=\"inp_password\" size=\"45\" value=\""; if(isset($inp_password)){ echo"$inp_password"; } echo"\" /><br />
			</p>

			<p>
			$l_gender*:<br />
			<select name=\"inp_gender\"> 
				<option value=\"male\""; if(isset($inp_gender) && $inp_gender == "male"){ echo" selected=\"selected\""; } echo">$l_male</option>
				<option value=\"female\""; if(isset($inp_gender) && $inp_gender == "female"){ echo" selected=\"selected\""; } echo">$l_female</option>
			</select>
			</p>

			<p>
			$l_country*:<br />
			<select name=\"inp_country\">";

			if(!(isset($inp_country))){
				// Find the country the last person registrered used
				$query = "SELECT profile_country FROM $t_users_profile ORDER BY profile_id DESC LIMIT 0,1";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($inp_country) = $row;
			}
			$prev_country = "";
			$query = "SELECT geoname_country_name FROM $t_stats_ip_to_country_geonames ORDER BY geoname_country_name ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_geoname_country_name) = $row;

				if($get_geoname_country_name != "$prev_country"){
					echo"			";
					echo"<option value=\"$get_geoname_country_name\""; if(isset($inp_country) && $inp_country == "$get_geoname_country_name"){ echo" selected=\"selected\""; } echo">$get_geoname_country_name</option>\n";
				}
				$prev_country = "$get_geoname_country_name";
			}
			echo"
			</select>
			</p>
	


			<p>";
			if(!(isset($inp_newsletter))){
				$inp_newsletter = 0;
			}
			echo"$l_newsletter*:<br />
			<input type=\"radio\" name=\"inp_newsletter\" value=\"1\""; if(isset($inp_newsletter) && $inp_newsletter == "1"){ echo" checked=\"checked\""; } echo" /> $l_yes
			&nbsp;
			<input type=\"radio\" name=\"inp_newsletter\" value=\"0\""; if(isset($inp_newsletter) && $inp_newsletter == "0"){ echo" checked=\"checked\""; } echo" /> $l_no
			</p>

			<p>
			<input type=\"submit\" value=\"$l_user_create\" class=\"btn\" />
			</p>

			</form>

			";

		}
	} // antispam ok
	else{
		echo"<p>Please start at the beginning..</p>";
	}
}
else{
	echo"
	<table>
	 <tr> 
	  <td style=\"padding-right: 6px;\">
		<p>
		<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" />
		</p>
	  </td>
	  <td>
		<h1>Loading</h1>
	  </td>
	 </tr>
	</table>
	<p>You are registered!</p>
	<p>
	<a href=\"$root/index.php\" class=\"btn\">Home</a></p>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/index.php\">
	";
}
/*- Footer ---------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");

?>