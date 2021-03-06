<?php
session_start();
ini_set('arg_separator.output', '&amp;');
/**
*
* File: _admin/login/index.php
* Version 2.0
* Date 21:53 29.10.2019
* Copyright (c) 2008-2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Functions ------------------------------------------------------------------------ */
include("../_functions/output_html.php");
include("../_functions/clean.php");
include("../_functions/quote_smart.php");
include("../global_variables.php");

/*- Website config --------------------------------------------------------------------------- */
include("../_data/logo.php");
include("../_data/config/meta.php");

/*- Check if setup is run ------------------------------------------------------------ */
$server_name = $_SERVER['HTTP_HOST'];
$server_name = clean($server_name);
$setup_finished_file = "setup_finished_" . $server_name . ".php";
if(!(file_exists("../_data/$setup_finished_file"))){
	header("Location: ../setup/");
	exit;
}

/*- MySQL ------------------------------------------------------------------------- */
$server_name = $_SERVER['HTTP_HOST'];
$server_name = clean($server_name);
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
	$t_users_status_comments 	= $mysqlPrefixSav . "users_status_comments";
	$t_users_status_comments_likes 	= $mysqlPrefixSav . "users_status_comments_likes";
	$t_users_status_likes 		= $mysqlPrefixSav . "users_status_likes";
	$t_users_profile 		= $mysqlPrefixSav . "users_profile";
	$t_users_cover_photos 		= $mysqlPrefixSav . "users_cover_photos";
	$t_users_email_subscriptions 	= $mysqlPrefixSav . "users_email_subscriptions";

	$t_users_known_devices 		= $mysqlPrefixSav . "users_known_devices";
	$t_users_logins 		= $mysqlPrefixSav . "users_logins";

	$t_stats_bot_visitor 	= $mysqlPrefixSav . "stats_bot_visitor";
	$t_stats_human_visitor 	= $mysqlPrefixSav . "stats_human_visitor";

	$t_pages 	= $mysqlPrefixSav . "pages";
	$t_navigation 	= $mysqlPrefixSav . "navigation";

	$t_banned_ips 			= $mysqlPrefixSav . "banned_ips";
	$t_banned_hostnames 		= $mysqlPrefixSav . "banned_hostnames";
	$t_banned_user_agents		= $mysqlPrefixSav . "banned_user_agents";
	$t_stats_user_agents_index 	= $mysqlPrefixSav . "stats_user_agents_index";
	$t_stats_ip_to_country_lookup 	= $mysqlPrefixSav . "stats_ip_to_country_lookup";
	$t_languages_countries		= $mysqlPrefixSav . "languages_countries";
	$t_users_moderator_of_the_week  = $mysqlPrefixSav . "users_moderator_of_the_week";
}
else{
	echo"No MySQL connection. Missing mysql_";echo"$server_name file";
	die;
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
if(isset($_GET['l'])) {
	$l = $_GET['l'];
	$l = strip_tags(stripslashes($l));
}
else{
	$l = "";
}


/*- Language and translation ---------------------------------------------------------- */
if($l == ""){
	if($page == ""){
		if(file_exists("../_translations/admin/en/login/t_login.php")){
			include("../_translations/admin/en/login/t_login.php");
		}
		else{
			echo"
			<h1>Server error 404</h1>
			<p>Language file not found.</p>
			";
			die;
		}
	}
	else{
		if(file_exists("../_translations/admin/en/login/t_$page.php")){
			include("../_translations/admin/en/login/t_$page.php");
		}
		else{
			echo"
			<h1>Server error 404</h1>
			<p>Language file not found.</p>
			";
			die;
		}
	}
}
else{
	if($page == ""){
		if(file_exists("../_translations/admin/$l/login/t_login.php")){
			include("../_translations/admin/$l/login/t_login.php");
		}
		else{
			echo"
			<h1>Server error 404</h1>
			<p>Language file $l/login/t_login not found.</p>
			";
			die;
		}
	}
	else{
		if(file_exists("../_translations/admin/$l/login/t_$page.php")){
			include("../_translations/admin/$l/login/t_$page.php");
		}
		else{
			echo"
			<h1>Server error 404</h1>
			<p>Language file $l/login/t_$page not found.</p>
			";
			die;
		}
	}
}



/*- SSL? ------------------------------------------------------------------------------- */
$server_name = $_SERVER['HTTP_HOST'];
$server_name = clean($server_name);
$ssl_config_file = "ssl_" . $server_name . ".php";
if(file_exists("../_data/config/$ssl_config_file")){
	include("../_data/config/$ssl_config_file");
	if($configSLLActiveSav == "1"){
		include("../_functions/use_ssl.php");
	}
}

// Me
$my_user_agent = $_SERVER['HTTP_USER_AGENT'];
$my_user_agent = output_html($my_user_agent);
$my_user_agent_mysql = quote_smart($link, $my_user_agent);

$my_ip = $_SERVER['REMOTE_ADDR'];
$my_ip = output_html($my_ip);
$my_ip_mysql = quote_smart($link, $my_ip);

$my_hostname = "$my_ip";
if($configSiteUseGethostbyaddrSav == "1"){
	$my_hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']); // Some servers in local network cant use getostbyaddr because of nameserver missing
}
$my_hostname = output_html($my_hostname);
$my_hostname_mysql = quote_smart($link, $my_hostname);


// Check if the user is banned
$query = "SELECT banned_ip_id FROM $t_banned_ips WHERE banned_ip=$my_ip_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_banned_ip_id) = $row;

$query = "SELECT banned_hostname_id FROM $t_banned_hostnames WHERE banned_hostname=$my_hostname_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_banned_hostname_id) = $row;

$query = "SELECT banned_user_agent_id FROM $t_banned_user_agents WHERE banned_user_agent=$my_user_agent_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_banned_user_agent_id) = $row;

if($get_banned_ip_id != "" OR $get_banned_hostname_id != "" OR $get_banned_user_agent_id != ""){
	header("HTTP/1.0 403 Forbidden");
	echo"<!DOCTYPE html>\n";
	echo"<html lang=\"en\">\n";
	echo"<head>\n";
	echo"	<title>Server error 403 #1</title>\n";
	echo"	<meta charset=iso-8859-1 />\n";
	echo"	</head>\n";
	echo"<body>\n";
	echo"<h1>Server error 403 #1</h1>\n";
	if($get_banned_ip_id != ""){
		echo"<p>IP ";echo $my_ip;echo" is banned.</p>\n";
	}
	if($get_banned_hostname_id != ""){
		echo"<p>Hostname ";echo $inp_hostname;echo" is banned.</p>\n";
	}
	if($get_banned_user_agent_id != ""){
		echo"<p>User agent ";echo $my_user_agent;echo" is banned.</p>\n";
	}
	echo"</body>\n";
	echo"</html>";
	die;
}


// Find user agent. By looking for user agent we can know if it is human or bot
$query = "SELECT stats_user_agent_id, stats_user_agent_string, stats_user_agent_type, stats_user_agent_browser, stats_user_agent_browser_version, stats_user_agent_browser_icon, stats_user_agent_os, stats_user_agent_os_version, stats_user_agent_os_icon, stats_user_agent_bot, stats_user_agent_bot_icon, stats_user_agent_bot_website, stats_user_agent_banned FROM $t_stats_user_agents_index WHERE stats_user_agent_string=$my_user_agent_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_stats_user_agent_id, $get_stats_user_agent_string, $get_stats_user_agent_type, $get_stats_user_agent_browser, $get_stats_user_agent_browser_version, $get_stats_user_agent_browser_icon, $get_stats_user_agent_os, $get_stats_user_agent_os_version, $get_stats_user_agent_os_icon, $get_stats_user_agent_bot, $get_stats_user_agent_bot_icon, $get_stats_user_agent_bot_website, $get_stats_user_agent_banned) = $row;
if($get_stats_user_agent_id == ""){
	$define_in_register_stats = 1;
	$root = "../..";
	include("$root/_admin/_functions/registrer_stats_autoinsert_new_user_agent.php");
}
else{
	// Banned
	if($get_stats_user_agent_banned == "1"){
		header("HTTP/1.0 403 Forbidden");
		echo"<!DOCTYPE html>\n";
		echo"<html lang=\"en\">\n";
		echo"<head>\n";
		echo"	<title>Server error 403 #2</title>\n";
		echo"	<meta charset=iso-8859-1 />\n";
		echo"	</head>\n";
		echo"<body>\n";
		echo"<h1>Server error 403 #1</h1>\n";
		echo"<p>User agent ";echo $user_agent;echo" is banned.</p>\n";
		echo"</body>\n";
		echo"</html>";
		die;
	}
}

/*- Design ---------------------------------------------------------------------------- */
if($process != "1"){
echo"<!DOCTYPE html>
<html lang=\"en\">
<head>
	<title>$cmsNameSav";
	if($page != ""){
		$page_saying = ucfirst($page);
		echo" - $page_saying";
	}
	echo"</title>

	<link rel=\"icon\" href=\"../favicon.ico\" />
	<meta name=\"viewport\" content=\"width=device-width; initial-scale=1.0;\"/>
	<link rel=\"stylesheet\" href=\"_login_design/login.css?datetime="; $datetime = date("Y-m-d His"); echo"$datetime\" type=\"text/css\" />
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UFT-8\" />


	<!-- jQuery -->
	<script type=\"text/javascript\" src=\"../_javascripts/jquery/jquery-3.4.0.min.js\"></script>
	<!-- //jQuery -->


</head>
<body>
<div class=\"body_bg\">
	<div class=\"wrapper\">
		<!-- Header -->
			<header>
				<p><a>$configWebsiteTitleSav <span>$configWebsiteVersionSav</span></a></p>
			</header>
		<!-- //Header -->

		
		<!-- Main -->
			<div id=\"main\">
			<!-- Page -->
			";
} // process
			if($page != ""){
				if (preg_match('/(http:\/\/|^\/|\.+?\/)/', $page)){
					echo"Server error 403";
				}
				else{
					if(file_exists("_login_pages/$page.php")){
						include("_login_pages/$page.php");
					}
					else{
						echo"Server error 404";
					}
				}
			}
			else{
				include("_login_pages/login.php");
			}
if($process != "1"){
			echo"
			<!-- //Page -->
			</div>
		<!-- //Main -->

		<!-- Footer -->
			<footer>
				<p>
				<a href=\"$cmsWebsiteSav\">&copy; 2019-2020 $cmsNameSav $cmsVersionSav</a>
				</p>
			</footer>
		<!-- //Footer -->

	</div> <!-- //wrapper-->
</div> <!-- //body_bg -->

</body>
</html>";

} // process
?>