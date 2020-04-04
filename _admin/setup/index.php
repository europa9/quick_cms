<?php
error_reporting(E_ALL & ~E_STRICT);
session_start();
ini_set('arg_separator.output', '&amp;');
/**
*
* File: _admin/setup/index.php
* Version 1.2
* Date 17:58 17.07.2019
* Copyright (c) 2008-2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Make sure we are on the correct web site ----------------------------------------- */
if(file_exists("../_data/config/meta.php")){
	include("../_data/config/meta.php");
	if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443") {
		$page = $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} 
	else {
		$page = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	if(isset($configSLLActiveSav) && $configSLLActiveSav == 1){
		$page_url = 'https://' . $page;
	}
	else{
		$page_url = 'http://' . $page;
	}
	if(isset($configControlPanelURLSav)){
		
		$page_url_substr = substr($page_url, 0, strlen($configControlPanelURLSav));

		if($configControlPanelURLSav != "$page_url_substr"){
			// Check for localhost
			$check_localhost = substr($page_url, 0, 16);
			if($check_localhost != "http://localhost"){
	
				echo"<p>Security error. Page url is not the same as configured. Please fix meta.php.
				</p>

				<p>
				<a href=\"$configControlPanelURLSav\">$configControlPanelURLSav</a> != $page_url_substr
				</p>
				";
				die;
			}
		}
	}
}
/*- Functions ------------------------------------------------------------------------ */
include("../_functions/output_html.php");
include("../_functions/clean.php");
include("../_functions/quote_smart.php");
include("../global_variables.php");


/*- Check if setup is run ------------------------------------------------------------ */
$server_name = $_SERVER['HTTP_HOST'];
$server_name = clean($server_name);
$check = substr($server_name, 0, 3);
if($check == "www"){
	$server_name = substr($server_name, 3);
}
$setup_finished_file = "setup_finished_" . $server_name . ".php";
if(file_exists("../_data/$setup_finished_file")){
	echo"<p style=\"color:#fff;background:#000;font-size:100px;\">Setup is finished.</p><META HTTP-EQUIV=Refresh CONTENT=\"1; URL=../../index.php\">";
	die;
}

// Mysql Setup
$mysql_config_file = "../_data/mysql_" . $server_name . ".php";
if(file_exists("$mysql_config_file")){
	include("$mysql_config_file");
	$link = mysqli_connect($mysqlHostSav, $mysqlUserNameSav, $mysqlPasswordSav, $mysqlDatabaseNameSav);
	if (!$link) {
		echo "
		<div class=\"alert alert-danger\"><span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span><strong>MySQL connection error</strong>"; 
		echo PHP_EOL;
   		echo "<br />Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    		echo "<br />Debugging error: " . mysqli_connect_error() . PHP_EOL;
    		echo"
		</div>
		";
		die;
	}

	/*- MySQL Tables -------------------------------------------------- */
	$t_users 	 		= $mysqlPrefixSav . "users";
	$t_users_profile 		= $mysqlPrefixSav . "users_profile";
	$t_users_friends 		= $mysqlPrefixSav . "users_friends";
	$t_users_friends_requests 	= $mysqlPrefixSav . "users_friends_requests";
	$t_users_profile		= $mysqlPrefixSav . "users_profile";
	$t_users_profile_photo 		= $mysqlPrefixSav . "users_profile_photo";
	$t_users_status 		= $mysqlPrefixSav . "users_status";
	$t_users_status_likes 		= $mysqlPrefixSav . "users_status_likes";
	$t_users_profile 		= $mysqlPrefixSav . "users_profile";
	$t_users_profile_views 		= $mysqlPrefixSav . "users_profile_views";
	$t_users_cover_photos 		= $mysqlPrefixSav . "users_cover_photos";
	$t_users_email_subscriptions 	= $mysqlPrefixSav . "users_email_subscriptions";
	$t_users_notifications 		= $mysqlPrefixSav . "users_notifications";
	$t_users_moderator_of_the_week	= $mysqlPrefixSav . "users_moderator_of_the_week";

	$t_users_antispam_questions	= $mysqlPrefixSav . "users_antispam_questions";
	$t_users_antispam_answers	= $mysqlPrefixSav . "users_antispam_answers";
	$t_users_api_sessions		= $mysqlPrefixSav . "users_api_sessions";

	$t_stats_bot_ipblock 		= $mysqlPrefixSav . "stats_bot_ipblock";
	$t_stats_human_ipblock 		= $mysqlPrefixSav . "stats_human_ipblock";
	$t_stats_human_online_records	= $mysqlPrefixSav . "stats_human_online_records";
	$t_stats_user_agents 		= $mysqlPrefixSav . "stats_user_agents";
	$t_stats_dayli 			= $mysqlPrefixSav . "stats_dayli";
	$t_stats_monthly		= $mysqlPrefixSav . "stats_monthly";
	$t_stats_browsers 		= $mysqlPrefixSav . "stats_browsers";
	$t_stats_os	 		= $mysqlPrefixSav . "stats_os";
	$t_stats_bots			= $mysqlPrefixSav . "stats_bots";
	$t_stats_accepted_languages	= $mysqlPrefixSav . "stats_accepted_languages";
	$t_stats_referers		= $mysqlPrefixSav . "stats_referers";
	$t_stats_users_registered_weekly = $mysqlPrefixSav . "stats_users_registered_weekly";
	$t_stats_users_registered_monthly = $mysqlPrefixSav . "stats_users_registered_monthly";
	$t_stats_users_registered_yearly = $mysqlPrefixSav . "stats_users_registered_yearly";

	$t_pages 		= $mysqlPrefixSav . "pages";
	$t_navigation 		= $mysqlPrefixSav . "navigation";

	$t_images		= $mysqlPrefixSav . "images";
	$t_images_paths		= $mysqlPrefixSav . "images_paths";
	
	$t_languages        	= $mysqlPrefixSav . "languages";
	$t_languages_active 	= $mysqlPrefixSav . "languages_active";
	
	$t_site_translations_directories = $mysqlPrefixSav . "site_translations_directories";
	$t_site_translations_files       = $mysqlPrefixSav . "site_translations_files";
	$t_site_translations_strings	 = $mysqlPrefixSav . "site_translations_strings";
	
	$t_admin_translations_directories = $mysqlPrefixSav . "admin_translations_directories";
	$t_admin_translations_files       = $mysqlPrefixSav . "admin_translations_files";
	$t_admin_translations_strings     = $mysqlPrefixSav . "admin_translations_strings";

	$t_admin_messages_inbox		= $mysqlPrefixSav . "admin_messages_inbox";

	$t_admin_liquidbase		  = $mysqlPrefixSav . "admin_liquidbase";

	$t_banned_hostnames	= $mysqlPrefixSav . "banned_hostnames";
	$t_banned_ips	 	= $mysqlPrefixSav . "banned_ips";
	$t_banned_user_agents	= $mysqlPrefixSav . "banned_user_agents";

	$t_analytics	= $mysqlPrefixSav . "analytics";
}

/*- Variables ------------------------------------------------------------------------ */
if(isset($_GET['page'])) {
	$page = $_GET['page'];
	$page = strip_tags(stripslashes($page));
}
else{
	$page = "";
}
if(isset($_GET['process'])) {
	$process = $_GET['process'];
	$process = strip_tags(stripslashes($process));
}
else{
	$process = "";
}
if(isset($_GET['ft'])) {
	$ft = $_GET['ft'];
	$ft = strip_tags(stripslashes($ft));
	if($ft != "error" && $ft != "warning" && $ft != "success" && $ft != "info"){
		echo"Server error 403 feedback error";die;
	}
}
else{
	$ft = "";
}
if(isset($_GET['fm'])) {
	$fm = $_GET['fm'];
	$fm = strip_tags(stripslashes($fm));
}
if(isset($_GET['action'])) {
	$action = $_GET['action'];
	$action = strip_tags(stripslashes($action));
}
else{
	$action = "";
}
if(isset($_GET['language'])) {
	$language = $_GET['language'];
	$language = strip_tags(stripslashes($language));
}
else{
	$language = "en";
}



/*- Language and translation ---------------------------------------------------------- */
if($language == ""){
	if($page == ""){
		include("../_translations/admin/en/setup/t_01_select_language.php");

	}
	else{
		if(!(file_exists("../_translations/admin/$language/setup/t_$page.php"))){
			$fh = fopen("../_translations/admin/$language/setup/t_$page.php", "w+") or die("can not open file");
			fwrite($fh, "<?php ?>");
			fclose($fh);

		}
		include("../_translations/admin/en/setup/t_$page.php");
	}
}
else{
	if($page == ""){
		include("../_translations/admin/$language/setup/t_01_select_language.php");

	}
	else{
		if(!(file_exists("../_translations/admin/$language/setup/t_$page.php"))){
		
			if(!(is_dir("../_translations/admin/$language/setup"))){
				mkdir("../_translations/admin/$language/setup");
			}

			$fh = fopen("../_translations/admin/$language/setup/t_$page.php", "w+") or die("can not open file");
			fwrite($fh, "<?php ?>");
			fclose($fh);
		}
		include("../_translations/admin/$language/setup/t_$page.php");
	}
}



/*- Design ---------------------------------------------------------------------------- */
if($process != "1"){
echo"<!DOCTYPE html>
<html lang=\"en\">
<head>
	<title>$cmsNameSav $cmsVersionSav";
	if($page != ""){
		$page_saying = ucfirst($page);
		echo" - $page_saying";
	}
	echo"</title>

	<link rel=\"icon\" href=\"favicon.ico\" />
	<meta name=\"viewport\" content=\"width=device-width; initial-scale=1.0;\"/>

	<link rel=\"stylesheet\" href=\"_setup_design/reset.css\" type=\"text/css\" />
	<link rel=\"stylesheet\" href=\"_setup_design/setup.css\" type=\"text/css\" />
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UFT-8\" />


	<!-- jQuery -->
	<script type=\"text/javascript\" src=\"../_javascripts/jquery/jquery-3.4.0.min.js\"></script>
	<!-- //jQuery -->

</head>
<body>

<!-- Wrapper -->
<div id=\"wrapper\">
	
	<!-- Wrapper -->
	<div id=\"wrapper\">
	

		<!-- Header -->
			<header>
				<p>
				<a href=\"$cmsWebsiteSav\">$cmsNameSav</a>
				<span>$cmsVersionSav</span> 
				</p>
			</header>
		<!-- //Header -->


		<!-- Main -->
			<div id=\"main\">

			<!-- Navigation -->
				<div id=\"navigation\">
					<ul>
						<li><span"; if($page == "" OR $page == "01_select_language"){ echo" class=\"active\" "; } echo">1. Language</span></li>
						<li><span"; if($page == "02_chmod"){ echo" class=\"active\" "; } echo">2. Chmod</span></li>
						<li><span"; if($page == "03_a_database"){ echo" class=\"active\" "; } echo">3. Database</span></li>
						<li><span"; if($page == "04_site"){ echo" class=\"active\" "; } echo">4. Site</span></li>
						<li><span"; if($page == "05_administrator"){ echo" class=\"active\" "; } echo">5. Administrator</span></li>
						<li><span"; if($page == "06_web_design"){ echo" class=\"active\" "; } echo">6. Web design</span></li>
					</ul>
				</div>
			<!-- //Navigation -->

			<!-- Content -->
				<div id=\"content\">
					<!-- Page -->
					";
} // process
					if($page != ""){

						if (preg_match('/(http:\/\/|^\/|\.+?\/)/', $page)){
							echo"Server error 403";
						}
						else{
							if(file_exists("_setup_pages/$page.php")){
								include("_setup_pages/$page.php");
							}
							else{
								echo"Server error 404";
							}
						}
					}
					else{
						include("_setup_pages/01_select_language.php");
					}
if($process != "1"){
					echo"
					<!-- //Page -->
				</div>
			<!-- //Content -->
		</div>
		<!-- //Main -->

</div> <!--// Wrapper -->
</body>
</html>";

} // process
?>