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

// Config
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


	$t_stats_bot_visitor 	= $mysqlPrefixSav . "stats_bot_visitor";
	$t_stats_human_visitor 	= $mysqlPrefixSav . "stats_human_visitor";

	$t_pages 	= $mysqlPrefixSav . "pages";
	$t_navigation 	= $mysqlPrefixSav . "navigation";
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

	<link rel=\"stylesheet\" href=\"_login_design/reset.css\" type=\"text/css\" />
	<link rel=\"stylesheet\" href=\"_login_design/login.css\" type=\"text/css\" />
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UFT-8\" />


	<!-- jQuery -->
	<script type=\"text/javascript\" src=\"../_javascripts/jquery/jquery-3.4.0.min.js\"></script>
	<!-- //jQuery -->


</head>
<body>

<div id=\"wrapper\""; 
$week = date("W");
if(file_exists("_login_design/images/bg/$week.jpg")){
	echo" style=\"background: url('_login_design/images/bg/$week.jpg') no-repeat center center fixed;background-size: cover;\""; 
}
echo">
	<div id=\"content\">

	<!-- Header -->
	<header>
		<p><a>$configWebsiteTitleSav <span>$configWebsiteVersionSav $week</span></a></p>
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

	</div> <!-- //Content -->
</div> <!-- //Wrapper -->

</body>
</html>";

} // process
?>