<?php
/**
*
* File: _admin/_functions/registrer_stats.php
* Version 2.0
* Date 10:30 20.10.2020
* Copyright (c) 2008-2020 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
// To do: $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
// Referer


/*- Tables ---------------------------------------------------------------------------------- */
$t_stats_accepted_languages_per_month	= $mysqlPrefixSav . "stats_accepted_languages_per_month";
$t_stats_accepted_languages_per_year	= $mysqlPrefixSav . "stats_accepted_languages_per_year";

$t_stats_browsers_per_month	= $mysqlPrefixSav . "stats_browsers_per_month";
$t_stats_browsers_per_year	= $mysqlPrefixSav . "stats_browsers_per_year";

$t_stats_comments_per_month 	= $mysqlPrefixSav . "stats_comments_per_month";
$t_stats_comments_per_year 	= $mysqlPrefixSav . "stats_comments_per_year";

$t_stats_countries_per_year  = $mysqlPrefixSav . "stats_countries_per_year";
$t_stats_countries_per_month = $mysqlPrefixSav . "stats_countries_per_month";

$t_stats_ip_to_country_ipv4 		= $mysqlPrefixSav . "stats_ip_to_country_ipv4";
$t_stats_ip_to_country_ipv6 		= $mysqlPrefixSav . "stats_ip_to_country_ipv6";
$t_stats_ip_to_country_geonames 	= $mysqlPrefixSav . "stats_ip_to_country_geonames";

$t_stats_os_per_month = $mysqlPrefixSav . "stats_os_per_month";
$t_stats_os_per_year = $mysqlPrefixSav . "stats_os_per_year";

$t_stats_referers_per_year  = $mysqlPrefixSav . "stats_referers_per_year";
$t_stats_referers_per_month = $mysqlPrefixSav . "stats_referers_per_month";

$t_stats_user_agents_index = $mysqlPrefixSav . "stats_user_agents_index";

$t_stats_users_registered_per_month = $mysqlPrefixSav . "stats_users_registered_per_month";
$t_stats_users_registered_per_year = $mysqlPrefixSav . "stats_users_registered_per_year";

$t_stats_bots_per_month	= $mysqlPrefixSav . "stats_bots_per_month";
$t_stats_bots_per_year	= $mysqlPrefixSav . "stats_bots_per_year";

$t_stats_visists_per_day 	= $mysqlPrefixSav . "stats_visists_per_day";
$t_stats_visists_per_day_ips 	= $mysqlPrefixSav . "stats_visists_per_day_ips";
$t_stats_visists_per_month 	= $mysqlPrefixSav . "stats_visists_per_month";
$t_stats_visists_per_month_ips 	= $mysqlPrefixSav . "stats_visists_per_month_ips";
$t_stats_visists_per_year 	= $mysqlPrefixSav . "stats_visists_per_year";
$t_stats_visists_per_year_ips 	= $mysqlPrefixSav . "stats_visists_per_year_ips";

/*- Find me based on user ------------------------------------------------------------------- */
$inp_user_agent = $_SERVER['HTTP_USER_AGENT'];
$inp_user_agent = output_html($inp_user_agent);
$inp_user_agent_mysql = quote_smart($link, $inp_user_agent);

$inp_ip = $_SERVER['REMOTE_ADDR'];
if($inp_ip == "::1"){
	$inp_ip = "193.214.73.246";
}
$inp_ip = output_html($inp_ip);
$inp_ip_mysql = quote_smart($link, $inp_ip);

$inp_hostname = "$inp_ip";
if($configSiteUseGethostbyaddrSav == "1"){
	$inp_hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']); // Some servers in local network cant use getostbyaddr because of nameserver missing
}
$inp_hostname = output_html($inp_hostname);
$inp_hostname_mysql = quote_smart($link, $inp_hostname);


// Check if the user is banned
$query = "SELECT banned_ip_id FROM $t_banned_ips WHERE banned_ip=$inp_ip_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_banned_ip_id) = $row;

$query = "SELECT banned_hostname_id FROM $t_banned_hostnames WHERE banned_hostname=$inp_hostname_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_banned_hostname_id) = $row;

$query = "SELECT banned_user_agent_id FROM $t_banned_user_agents WHERE banned_user_agent=$inp_user_agent_mysql";
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
		echo"<p>IP ";echo $inp_ip;echo" is banned.</p>\n";
	}
	if($get_banned_hostname_id != ""){
		echo"<p>Hostname ";echo $inp_hostname;echo" is banned.</p>\n";
	}
	if($get_banned_user_agent_id != ""){
		echo"<p>User agent ";echo $user_agent;echo" is banned.</p>\n";
	}
	echo"</body>\n";
	echo"</html>";
	die;
}


// Find user agent. By looking for user agent we can know if it is human or bot
$query = "SELECT stats_user_agent_id, stats_user_agent_string, stats_user_agent_type, stats_user_agent_browser, stats_user_agent_browser_version, stats_user_agent_browser_icon, stats_user_agent_os, stats_user_agent_os_version, stats_user_agent_os_icon, stats_user_agent_bot, stats_user_agent_bot_icon, stats_user_agent_bot_website, stats_user_agent_banned FROM $t_stats_user_agents_index WHERE stats_user_agent_string=$inp_user_agent_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_stats_user_agent_id, $get_stats_user_agent_string, $get_stats_user_agent_type, $get_stats_user_agent_browser, $get_stats_user_agent_browser_version, $get_stats_user_agent_browser_icon, $get_stats_user_agent_os, $get_stats_user_agent_os_version, $get_stats_user_agent_os_icon, $get_stats_user_agent_bot, $get_stats_user_agent_bot_icon, $get_stats_user_agent_bot_website, $get_stats_user_agent_banned) = $row;


if($get_stats_user_agent_id == ""){
	$define_in_register_stats = 1;
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
	
	// Date
	$inp_day = date("d");
	$inp_day_full = date("l ");
	$inp_day_short = date("D");
	$inp_day_single = substr($inp_day_short, 0, 1);
	$inp_date = date("Y-m-d");
	$inp_time = date("H:i:s");
	$inp_month = date("m");
	$inp_month_full = date("F");
	$inp_month_short = date("M");
	$inp_year = date("Y");
	$inp_unix_time = time();


	// Visits per year
	$query = "SELECT stats_visit_per_year_id, stats_visit_per_year_year, stats_visit_per_year_human_unique, stats_visit_per_year_human_unique_diff_from_last_year, stats_visit_per_year_human_average_duration, stats_visit_per_year_human_new_visitor_unique, stats_visit_per_year_human_returning_visitor_unique, stats_visit_per_year_unique_desktop, stats_visit_per_year_unique_mobile, stats_visit_per_year_unique_bots, stats_visit_per_year_hits_total, stats_visit_per_year_hits_human, stats_visit_per_year_hits_desktop, stats_visit_per_year_hits_mobile, stats_visit_per_year_hits_bots FROM $t_stats_visists_per_year WHERE stats_visit_per_year_year='$inp_year'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_visit_per_year_id, $get_stats_visit_per_year_year, $get_stats_visit_per_year_human_unique, $get_stats_visit_per_year_human_unique_diff_from_last_year, $get_stats_visit_per_year_human_average_duration, $get_stats_visit_per_year_human_new_visitor_unique, $get_stats_visit_per_year_human_returning_visitor_unique, $get_stats_visit_per_year_unique_desktop, $get_stats_visit_per_year_unique_mobile, $get_stats_visit_per_year_unique_bots, $get_stats_visit_per_year_hits_total, $get_stats_visit_per_year_hits_human, $get_stats_visit_per_year_hits_desktop, $get_stats_visit_per_year_hits_mobile, $get_stats_visit_per_year_hits_bots) = $row;
	if($get_stats_visit_per_year_id == ""){
		// Create new year
		mysqli_query($link, "INSERT INTO $t_stats_visists_per_year
		(stats_visit_per_year_id, stats_visit_per_year_year, stats_visit_per_year_human_unique, stats_visit_per_year_human_unique_diff_from_last_year, stats_visit_per_year_human_average_duration, 
		stats_visit_per_year_human_new_visitor_unique, stats_visit_per_year_human_returning_visitor_unique, stats_visit_per_year_unique_desktop, stats_visit_per_year_unique_mobile, stats_visit_per_year_unique_bots, 
		stats_visit_per_year_hits_total, stats_visit_per_year_hits_human, stats_visit_per_year_hits_desktop, stats_visit_per_year_hits_mobile, stats_visit_per_year_hits_bots) 
		VALUES
		(NULL, '$inp_year', '0', '0', '0',
		'0', '0', '0', '0', '0',
		'0', '0', '0', '0', '0')") or die(mysqli_error($link));
	
		// Get new ID
		$query = "SELECT stats_visit_per_year_id, stats_visit_per_year_year, stats_visit_per_year_human_unique, stats_visit_per_year_human_unique_diff_from_last_year, stats_visit_per_year_human_average_duration, stats_visit_per_year_human_new_visitor_unique, stats_visit_per_year_human_returning_visitor_unique, stats_visit_per_year_unique_desktop, stats_visit_per_year_unique_mobile, stats_visit_per_year_unique_bots, stats_visit_per_year_hits_total, stats_visit_per_year_hits_human, stats_visit_per_year_hits_desktop, stats_visit_per_year_hits_mobile, stats_visit_per_year_hits_bots FROM $t_stats_visists_per_year WHERE stats_visit_per_year_year='$inp_year'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_visit_per_year_id, $get_stats_visit_per_year_year, $get_stats_visit_per_year_human_unique, $get_stats_visit_per_year_human_unique_diff_from_last_year, $get_stats_visit_per_year_human_average_duration, $get_stats_visit_per_year_human_new_visitor_unique, $get_stats_visit_per_year_human_returning_visitor_unique, $get_stats_visit_per_year_unique_desktop, $get_stats_visit_per_year_unique_mobile, $get_stats_visit_per_year_unique_bots, $get_stats_visit_per_year_hits_total, $get_stats_visit_per_year_hits_human, $get_stats_visit_per_year_hits_desktop, $get_stats_visit_per_year_hits_mobile, $get_stats_visit_per_year_hits_bots) = $row;
		
		// Truncate temp data
		mysqli_query($link,"TRUNCATE TABLE $t_stats_visists_per_year_ips") or die(mysqli_error());
	}


	// Visits per month
	$query = "SELECT stats_visit_per_month_id, stats_visit_per_month_human_unique, stats_visit_per_month_human_unique_diff_from_last_month, stats_visit_per_month_human_average_duration, stats_visit_per_month_human_new_visitor_unique, stats_visit_per_month_human_returning_visitor_unique, stats_visit_per_month_unique_desktop, stats_visit_per_month_unique_mobile, stats_visit_per_month_unique_bots, stats_visit_per_month_hits_total, stats_visit_per_month_hits_human, stats_visit_per_month_hits_desktop, stats_visit_per_month_hits_mobile, stats_visit_per_month_hits_bots FROM $t_stats_visists_per_month WHERE stats_visit_per_month_month='$inp_month' AND stats_visit_per_month_year='$inp_year'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_visit_per_month_id, $get_stats_visit_per_month_human_unique, $get_stats_visit_per_month_human_unique_diff_from_last_month, $get_stats_visit_per_month_human_average_duration, $get_stats_visit_per_month_human_new_visitor_unique, $get_stats_visit_per_month_human_returning_visitor_unique, $get_stats_visit_per_month_unique_desktop, $get_stats_visit_per_month_unique_mobile, $get_stats_visit_per_month_unique_bots, $get_stats_visit_per_month_hits_total, $get_stats_visit_per_month_hits_human, $get_stats_visit_per_month_hits_desktop, $get_stats_visit_per_month_hits_mobile, $get_stats_visit_per_month_hits_bots) = $row;
	if($get_stats_visit_per_month_id == ""){
		// Create new year
		mysqli_query($link, "INSERT INTO $t_stats_visists_per_month
		(stats_visit_per_month_id, stats_visit_per_month_month, stats_visit_per_month_month_full, stats_visit_per_month_month_short, stats_visit_per_month_year,
		stats_visit_per_month_human_unique, stats_visit_per_month_human_unique_diff_from_last_month, stats_visit_per_month_human_average_duration, stats_visit_per_month_human_new_visitor_unique, stats_visit_per_month_human_returning_visitor_unique, 
		stats_visit_per_month_unique_desktop, stats_visit_per_month_unique_mobile, stats_visit_per_month_unique_bots, stats_visit_per_month_hits_total, stats_visit_per_month_hits_human, 
		stats_visit_per_month_hits_desktop, stats_visit_per_month_hits_mobile, stats_visit_per_month_hits_bots) 
		VALUES
		(NULL, '$inp_month', '$inp_month_full', '$inp_month_short',  $inp_year,
		0, 0, 0, 0, 0,
		0, 0, 0, 0, 0,
		0, 0, 0)") or die(mysqli_error($link));


		// Get new ID
		$query = "SELECT stats_visit_per_month_id, stats_visit_per_month_human_unique, stats_visit_per_month_human_unique_diff_from_last_month, stats_visit_per_month_human_average_duration, stats_visit_per_month_human_new_visitor_unique, stats_visit_per_month_human_returning_visitor_unique, stats_visit_per_month_unique_desktop, stats_visit_per_month_unique_mobile, stats_visit_per_month_unique_bots, stats_visit_per_month_hits_total, stats_visit_per_month_hits_human, stats_visit_per_month_hits_desktop, stats_visit_per_month_hits_mobile, stats_visit_per_month_hits_bots FROM $t_stats_visists_per_month WHERE stats_visit_per_month_month='$inp_month' AND stats_visit_per_month_year='$inp_year'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_visit_per_month_id, $get_stats_visit_per_month_human_unique, $get_stats_visit_per_month_human_unique_diff_from_last_month, $get_stats_visit_per_month_human_average_duration, $get_stats_visit_per_month_human_new_visitor_unique, $get_stats_visit_per_month_human_returning_visitor_unique, $get_stats_visit_per_month_unique_desktop, $get_stats_visit_per_month_unique_mobile, $get_stats_visit_per_month_unique_bots, $get_stats_visit_per_month_hits_total, $get_stats_visit_per_month_hits_human, $get_stats_visit_per_month_hits_desktop, $get_stats_visit_per_month_hits_mobile, $get_stats_visit_per_month_hits_bots) = $row;

		// Truncate temp data
		mysqli_query($link,"TRUNCATE TABLE $t_stats_visists_per_month_ips") or die(mysqli_error());
	}


	// Visits per day
	$query = "SELECT stats_visit_per_day_id, stats_visit_per_day_human_unique, stats_visit_per_day_human_unique_diff_from_yesterday, stats_visit_per_day_human_average_duration, stats_visit_per_day_human_new_visitor_unique, stats_visit_per_day_human_returning_visitor_unique, stats_visit_per_day_unique_desktop, stats_visit_per_day_unique_mobile, stats_visit_per_day_unique_bots, stats_visit_per_day_hits_total, stats_visit_per_day_hits_human, stats_visit_per_day_hits_desktop, stats_visit_per_day_hits_mobile, stats_visit_per_day_hits_bots FROM $t_stats_visists_per_day WHERE stats_visit_per_day_day='$inp_day' AND stats_visit_per_day_month='$inp_month' AND stats_visit_per_day_year='$inp_year'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_visit_per_day_id, $get_stats_visit_per_day_human_unique, $get_stats_visit_per_day_human_unique_diff_from_yesterday, $get_stats_visit_per_day_human_average_duration, $get_stats_visit_per_day_human_new_visitor_unique, $get_stats_visit_per_day_human_returning_visitor_unique, $get_stats_visit_per_day_unique_desktop, $get_stats_visit_per_day_unique_mobile, $get_stats_visit_per_day_unique_bots, $get_stats_visit_per_day_hits_total, $get_stats_visit_per_day_hits_human, $get_stats_visit_per_day_hits_desktop, $get_stats_visit_per_day_hits_mobile, $get_stats_visit_per_day_hits_bots) = $row;
	if($get_stats_visit_per_day_id == ""){
		// Create
		mysqli_query($link, "INSERT INTO $t_stats_visists_per_day
		(stats_visit_per_day_id, stats_visit_per_day_day, stats_visit_per_day_day_full, stats_visit_per_day_day_three, stats_visit_per_day_day_single, 
		stats_visit_per_day_month, stats_visit_per_day_month_full, stats_visit_per_day_month_short, 
		stats_visit_per_day_year, stats_visit_per_day_human_unique, stats_visit_per_day_human_unique_diff_from_yesterday, stats_visit_per_day_human_average_duration, stats_visit_per_day_human_new_visitor_unique, 
		stats_visit_per_day_human_returning_visitor_unique, stats_visit_per_day_unique_desktop, stats_visit_per_day_unique_mobile, stats_visit_per_day_unique_bots, stats_visit_per_day_hits_total, 
		stats_visit_per_day_hits_human, stats_visit_per_day_hits_desktop, stats_visit_per_day_hits_mobile, stats_visit_per_day_hits_bots) 
		VALUES
		(NULL, '$inp_day', '$inp_day_full', '$inp_day_short', '$inp_day_single', '$inp_month', '$inp_month_full', '$inp_month_short',
		'$inp_year', '0', '0','0','0', 
		'0', '0', '0', '0', '0', 
		'0', '0', '0', '0')") or die(mysqli_error($link));

		$query = "SELECT stats_visit_per_day_id, stats_visit_per_day_human_unique, stats_visit_per_day_human_unique_diff_from_yesterday, stats_visit_per_day_human_average_duration, stats_visit_per_day_human_new_visitor_unique, stats_visit_per_day_human_returning_visitor_unique, stats_visit_per_day_unique_desktop, stats_visit_per_day_unique_mobile, stats_visit_per_day_unique_bots, stats_visit_per_day_hits_total, stats_visit_per_day_hits_human, stats_visit_per_day_hits_desktop, stats_visit_per_day_hits_mobile, stats_visit_per_day_hits_bots FROM $t_stats_visists_per_day WHERE stats_visit_per_day_day='$inp_day' AND stats_visit_per_day_month='$inp_month' AND stats_visit_per_day_year='$inp_year'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_visit_per_day_id, $get_stats_visit_per_day_human_unique, $get_stats_visit_per_day_human_unique_diff_from_yesterday, $get_stats_visit_per_day_human_average_duration, $get_stats_visit_per_day_human_new_visitor_unique, $get_stats_visit_per_day_human_returning_visitor_unique, $get_stats_visit_per_day_unique_desktop, $get_stats_visit_per_day_unique_mobile, $get_stats_visit_per_day_unique_bots, $get_stats_visit_per_day_hits_total, $get_stats_visit_per_day_hits_human, $get_stats_visit_per_day_hits_desktop, $get_stats_visit_per_day_hits_mobile, $get_stats_visit_per_day_hits_bots) = $row;

	}


	// Inp from user agent
	if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
		$inp_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		$inp_language = output_html($inp_language);
		$inp_language = strtolower($inp_language);
	}
	else{
		$inp_language = "ZZ";
	}
	$inp_language = substr("$inp_language", 0,2);
	$inp_language_mysql = quote_smart($link, $inp_language);

	$inp_page = $_SERVER['REQUEST_URI'];
	$inp_page = output_html($inp_page);
	$inp_page_mysql = quote_smart($link, $inp_page);

	$inp_user_agent_bot = output_html($get_stats_user_agent_bot);
	$inp_user_agent_bot_mysql = quote_smart($link, $inp_user_agent_bot);

	$inp_user_agent_bot_icon = output_html($get_stats_user_agent_bot_icon);
	$inp_user_agent_bot_icon_mysql = quote_smart($link, $inp_user_agent_bot_icon);

	$inp_user_agent_browser = output_html($get_stats_user_agent_browser);
	$inp_user_agent_browser_mysql = quote_smart($link, $inp_user_agent_browser);

	$inp_user_agent_os = output_html($get_stats_user_agent_os);
	$inp_user_agent_os_mysql = quote_smart($link, $inp_user_agent_os);
	
	$inp_stats_user_agent_type = output_html($get_stats_user_agent_type);
	$inp_stats_user_agent_type_mysql = quote_smart($link, $inp_stats_user_agent_type);

	
	// Bot
	if($get_stats_user_agent_type == "bot"){

		// Visists :: Year :: IPs
		$query = "SELECT stats_visit_per_year_ip_id, stats_visit_per_year_ip_year, stats_visit_per_year_type, stats_visit_per_year_ip FROM $t_stats_visists_per_year_ips WHERE stats_visit_per_year_ip_year='$inp_year' AND stats_visit_per_year_ip=$inp_ip_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_visit_per_year_ip_id, $get_stats_visit_per_year_ip_year, $get_stats_visit_per_year_type, $get_stats_visit_per_year_ip) = $row;
		if($get_stats_visit_per_year_ip_id == ""){
			// New visitor this year
			mysqli_query($link, "INSERT INTO $t_stats_visists_per_year_ips 
			(stats_visit_per_year_ip_id, stats_visit_per_year_ip_year, stats_visit_per_year_type, stats_visit_per_year_ip) 
			VALUES
			(NULL, '$inp_year', '$get_stats_user_agent_type', $inp_ip_mysql)") or die(mysqli_error($link));
			
			// Update unique
			$inp_visit_per_year_bots_unique = $get_stats_visit_per_year_unique_bots+1;
			$inp_visit_per_year_hits_bots = $get_stats_visit_per_year_hits_bots+1;
			$inp_visit_per_year_hits_total = $get_stats_visit_per_year_hits_total+1;
			
			// Update
			$result = mysqli_query($link, "UPDATE $t_stats_visists_per_year SET 
							stats_visit_per_year_unique_bots=$inp_visit_per_year_bots_unique,
							stats_visit_per_year_hits_total=$inp_visit_per_year_hits_total,
							stats_visit_per_year_hits_bots=$inp_visit_per_year_hits_bots
							WHERE stats_visit_per_year_id=$get_stats_visit_per_year_id") or die(mysqli_error($link));

		}
		else{
			// Update hits
			$inp_visit_per_year_hits_total = $get_stats_visit_per_year_hits_total+1;
			$inp_visit_per_year_hits_bots = $get_stats_visit_per_year_hits_bots+1;
			$result = mysqli_query($link, "UPDATE $t_stats_visists_per_year SET 
							stats_visit_per_year_hits_total=$inp_visit_per_year_hits_total,
							stats_visit_per_year_hits_bots=$inp_visit_per_year_hits_bots
							WHERE stats_visit_per_year_id=$get_stats_visit_per_year_id") or die(mysqli_error($link));
		} // Visits :: Year

		// Visists :: Month :: IPs
		$query = "SELECT stats_visit_per_month_ip_id, stats_visit_per_month_ip_month, stats_visit_per_month_ip_year, stats_visit_per_month_type, stats_visit_per_month_ip FROM $t_stats_visists_per_month_ips WHERE stats_visit_per_month_ip_month='$inp_month' AND stats_visit_per_month_ip_year='$inp_year' AND stats_visit_per_month_ip=$inp_ip_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_visit_per_month_ip_id, $get_stats_visit_per_month_ip_month, $get_stats_visit_per_month_ip_year, $get_stats_visit_per_month_type, $get_stats_visit_per_month_ip) = $row;
		if($get_stats_visit_per_month_ip_id == ""){
			// New visitor this month
			mysqli_query($link, "INSERT INTO $t_stats_visists_per_month_ips 
			(stats_visit_per_month_ip_id, stats_visit_per_month_ip_month, stats_visit_per_month_ip_year, stats_visit_per_month_type, stats_visit_per_month_ip) 
			VALUES
			(NULL, '$inp_month', '$inp_year', '$get_stats_user_agent_type', $inp_ip_mysql)") or die(mysqli_error($link));
			
			// Update unique
			$inp_visit_per_month_bots_unique = $get_stats_visit_per_month_unique_bots+1;
			$inp_visit_per_month_hits_bots = $get_stats_visit_per_month_hits_bots+1;
			$inp_visit_per_month_hits_total = $get_stats_visit_per_month_hits_total+1;
			
			// Update
			$result = mysqli_query($link, "UPDATE $t_stats_visists_per_month SET 
							stats_visit_per_month_unique_bots=$inp_visit_per_month_bots_unique,
							stats_visit_per_month_hits_total=$inp_visit_per_month_hits_total,
							stats_visit_per_month_hits_bots=$inp_visit_per_month_hits_bots
							WHERE stats_visit_per_month_id=$get_stats_visit_per_month_id") or die(mysqli_error($link));

		}
		else{
			// Update hits for bots
			$inp_visit_per_month_hits_total = $get_stats_visit_per_month_hits_total+1;
			$inp_visit_per_month_hits_bots = $get_stats_visit_per_month_hits_bots+1;
			$result = mysqli_query($link, "UPDATE $t_stats_visists_per_month SET 
							stats_visit_per_month_hits_total=$inp_visit_per_month_hits_total,
							stats_visit_per_month_hits_bots=$inp_visit_per_month_hits_bots
							WHERE stats_visit_per_month_id=$get_stats_visit_per_month_id") or die(mysqli_error($link));
			
		} // Visits :: Month



		// Visists :: Day :: IPs
		$query = "SELECT stats_visit_per_day_ip_id, stats_visit_per_day_ip_day, stats_visit_per_day_ip_month, stats_visit_per_day_ip_year, stats_visit_per_day_type, stats_visit_per_day_ip FROM $t_stats_visists_per_day_ips WHERE stats_visit_per_day_ip_day='$inp_day' AND stats_visit_per_day_ip_month='$inp_month' AND stats_visit_per_day_ip_year='$inp_year' AND stats_visit_per_day_ip=$inp_ip_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_visit_per_day_ip_id, $get_stats_visit_per_day_ip_day, $get_stats_visit_per_day_ip_month, $get_stats_visit_per_day_ip_year, $get_stats_visit_per_day_type, $get_stats_visit_per_day_ip) = $row;
		if($get_stats_visit_per_day_ip_id == ""){
			// New visitor this day
			mysqli_query($link, "INSERT INTO $t_stats_visists_per_day_ips 
			(stats_visit_per_day_ip_id, stats_visit_per_day_ip_day, stats_visit_per_day_ip_month, stats_visit_per_day_ip_year, stats_visit_per_day_type, stats_visit_per_day_ip) 
			VALUES
			(NULL, '$inp_day', '$inp_month', '$inp_year', '$get_stats_user_agent_type', $inp_ip_mysql)") or die(mysqli_error($link));
			
			// Update unique
			$inp_visit_per_day_bots_unique = $get_stats_visit_per_day_unique_bots+1;
			$inp_visit_per_day_hits_bots = $get_stats_visit_per_day_hits_bots+1;
			$inp_visit_per_day_hits_total = $get_stats_visit_per_day_hits_total+1;
			
			// Update
			$result = mysqli_query($link, "UPDATE $t_stats_visists_per_day SET 
							stats_visit_per_day_unique_bots=$inp_visit_per_day_bots_unique,
							stats_visit_per_day_hits_total=$inp_visit_per_day_hits_total,
							stats_visit_per_day_hits_bots=$inp_visit_per_day_hits_bots
							WHERE stats_visit_per_day_id=$get_stats_visit_per_day_id") or die(mysqli_error($link));

		}
		else{
			// Update hits
			$inp_visit_per_day_hits_total = $get_stats_visit_per_day_hits_total+1;
			$inp_visit_per_day_hits_bots = $get_stats_visit_per_day_hits_bots+1;
			$result = mysqli_query($link, "UPDATE $t_stats_visists_per_day SET 
							stats_visit_per_day_hits_total=$inp_visit_per_day_hits_total,
							stats_visit_per_day_hits_bots=$inp_visit_per_day_hits_bots
							WHERE stats_visit_per_day_id=$get_stats_visit_per_day_id") or die(mysqli_error($link));
		} // Visits :: Day


		// Bots :: Year
		$query = "SELECT stats_bot_id, stats_bot_unique, stats_bot_hits FROM $t_stats_bots_per_year WHERE stats_bot_year='$inp_year' AND stats_bot_name=$inp_user_agent_bot_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_bot_id, $get_stats_bot_unique, $get_stats_bot_hits) = $row;
		if($get_stats_bot_id == ""){

			mysqli_query($link, "INSERT INTO $t_stats_bots_per_year
			(stats_bot_id, stats_bot_year, stats_bot_name, stats_bot_unique, stats_bot_hits) 
			VALUES
			(NULL, '$inp_year', $inp_user_agent_bot_mysql, '1', '1')") or die(mysqli_error($link));
		}
		else{
			$inp_stats_bot_hits = $get_stats_bot_hits+1;
			$result = mysqli_query($link, "UPDATE $t_stats_bots_per_year SET stats_bot_hits='$inp_stats_bot_hits' WHERE stats_bot_id='$get_stats_bot_id'") or die(mysqli_error($link));
		}
		// Bots :: Month
		$query = "SELECT stats_bot_id, stats_bot_unique, stats_bot_hits FROM $t_stats_bots_per_month WHERE stats_bot_month='$inp_month' AND stats_bot_year='$inp_year' AND stats_bot_name=$inp_user_agent_bot_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_bot_id, $get_stats_bot_unique, $get_stats_bot_hits) = $row;
		if($get_stats_bot_id == ""){
			mysqli_query($link, "INSERT INTO $t_stats_bots_per_month
			(stats_bot_id, stats_bot_month, stats_bot_year, stats_bot_name, stats_bot_unique, stats_bot_hits) 
			VALUES
			(NULL, '$inp_month', '$inp_year', $inp_user_agent_bot_mysql, '1', '1')") or die(mysqli_error($link));
		}
		else{
			$inp_stats_bot_unique = $get_stats_bot_unique+1;
			$inp_stats_bot_hits = $get_stats_bot_hits+1;
			$result = mysqli_query($link, "UPDATE $t_stats_bots_per_month SET stats_bot_unique='$inp_stats_bot_unique', stats_bot_hits='$inp_stats_bot_hits' WHERE stats_bot_id='$get_stats_bot_id'");
		}


	} // End Bot
	elseif($get_stats_user_agent_type == "desktop" OR $get_stats_user_agent_type == "mobile"){
		// Visists :: Year :: IPs
		$query = "SELECT stats_visit_per_year_ip_id, stats_visit_per_year_ip_year, stats_visit_per_year_type, stats_visit_per_year_ip FROM $t_stats_visists_per_year_ips WHERE stats_visit_per_year_ip_year='$inp_year' AND stats_visit_per_year_ip=$inp_ip_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_visit_per_year_ip_id, $get_stats_visit_per_year_ip_year, $get_stats_visit_per_year_type, $get_stats_visit_per_year_ip) = $row;
		if($get_stats_visit_per_year_ip_id == ""){
			// New visitor this year
			mysqli_query($link, "INSERT INTO $t_stats_visists_per_year_ips 
			(stats_visit_per_year_ip_id, stats_visit_per_year_ip_year, stats_visit_per_year_type, stats_visit_per_year_ip) 
			VALUES
			(NULL, '$inp_year', '$get_stats_user_agent_type', $inp_ip_mysql)") or die(mysqli_error($link));
			
			// Update unique
			$inp_visit_per_year_human_unique = $get_stats_visit_per_year_human_unique+1;
			if($get_stats_user_agent_type == "desktop"){
				$inp_visit_per_year_unique_desktop = $get_stats_visit_per_year_unique_desktop+1;
				if($get_stats_visit_per_year_unique_mobile == ""){ $get_stats_visit_per_year_unique_mobile = "0"; }
				$inp_visit_per_year_unique_mobile = $get_stats_visit_per_year_unique_mobile;
			}
			else{
				$inp_visit_per_year_unique_desktop = $get_stats_visit_per_year_unique_desktop;
				$inp_visit_per_year_unique_mobile = $get_stats_visit_per_year_unique_mobile+1;
			}
			$inp_visit_per_year_hits_total = $get_stats_visit_per_year_hits_total+1;
			$inp_visit_per_year_hits_human = $get_stats_visit_per_year_hits_human+1;
			
			// Update new human visitor this year
			$result = mysqli_query($link, "UPDATE $t_stats_visists_per_year SET 
							stats_visit_per_year_human_unique=$inp_visit_per_year_human_unique,
							stats_visit_per_year_unique_desktop=$inp_visit_per_year_unique_desktop, 
							stats_visit_per_year_unique_mobile=$inp_visit_per_year_unique_mobile,
							stats_visit_per_year_hits_total=$inp_visit_per_year_hits_total,
							stats_visit_per_year_hits_human=$inp_visit_per_year_hits_human
							WHERE stats_visit_per_year_id=$get_stats_visit_per_year_id") or die(mysqli_error($link));

		}
		else{
			// Update hits
			$inp_visit_per_year_hits_total = $get_stats_visit_per_year_hits_total+1;
			$inp_visit_per_year_hits_human = $get_stats_visit_per_year_hits_human+1;
			$result = mysqli_query($link, "UPDATE $t_stats_visists_per_year SET 
							stats_visit_per_year_hits_total=$inp_visit_per_year_hits_total,
							stats_visit_per_year_hits_human=$inp_visit_per_year_hits_human
							WHERE stats_visit_per_year_id=$get_stats_visit_per_year_id") or die(mysqli_error($link));
			
		} // Visits :: Year


		// Visists :: Month :: IPs
		$query = "SELECT stats_visit_per_month_ip_id, stats_visit_per_month_ip_month, stats_visit_per_month_ip_year, stats_visit_per_month_type, stats_visit_per_month_ip FROM $t_stats_visists_per_month_ips WHERE stats_visit_per_month_ip_month='$inp_month' AND stats_visit_per_month_ip_year='$inp_year' AND stats_visit_per_month_ip=$inp_ip_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_visit_per_month_ip_id, $get_stats_visit_per_month_ip_month, $get_stats_visit_per_month_ip_year, $get_stats_visit_per_month_type, $get_stats_visit_per_month_ip) = $row;
		if($get_stats_visit_per_month_ip_id == ""){
			// New visitor this month
			mysqli_query($link, "INSERT INTO $t_stats_visists_per_month_ips 
			(stats_visit_per_month_ip_id, stats_visit_per_month_ip_month, stats_visit_per_month_ip_year, stats_visit_per_month_type, stats_visit_per_month_ip) 
			VALUES
			(NULL, '$inp_month', '$inp_year', '$get_stats_user_agent_type', $inp_ip_mysql)") or die(mysqli_error($link));
			
			// Update unique
			$inp_visit_per_month_human_unique = $get_stats_visit_per_month_human_unique+1;
			if($get_stats_user_agent_type == "desktop"){
				$inp_visit_per_month_unique_desktop = $get_stats_visit_per_month_unique_desktop+1;
				$inp_visit_per_month_unique_mobile = $get_stats_visit_per_month_unique_mobile;
			}
			else{
				$inp_visit_per_month_unique_desktop = $get_stats_visit_per_month_unique_desktop;
				$inp_visit_per_month_unique_mobile = $get_stats_visit_per_month_unique_mobile+1;
			}
			$inp_visit_per_month_hits_total = $get_stats_visit_per_month_hits_total+1;
			$inp_visit_per_month_hits_human = $get_stats_visit_per_month_hits_human+1;
			
			// Update

			$result = mysqli_query($link, "UPDATE $t_stats_visists_per_month SET 
							stats_visit_per_month_human_unique=$inp_visit_per_month_human_unique,
							stats_visit_per_month_unique_desktop=$inp_visit_per_month_unique_desktop, 
							stats_visit_per_month_unique_mobile=$inp_visit_per_month_unique_mobile,
							stats_visit_per_month_hits_total=$inp_visit_per_month_hits_total,
							stats_visit_per_month_hits_human=$inp_visit_per_month_hits_human
							WHERE stats_visit_per_month_id=$get_stats_visit_per_month_id") or die(mysqli_error($link));

		}
		else{
			// Update hits
			$inp_visit_per_month_hits_total = $get_stats_visit_per_month_hits_total+1;
			$inp_visit_per_month_hits_human = $get_stats_visit_per_month_hits_human+1;
			$result = mysqli_query($link, "UPDATE $t_stats_visists_per_month SET 
							stats_visit_per_month_hits_total=$inp_visit_per_month_hits_total,
							stats_visit_per_month_hits_human=$inp_visit_per_month_hits_human
							WHERE stats_visit_per_month_id=$get_stats_visit_per_month_id") or die(mysqli_error($link));
			
		} // Visits :: Month

		// Visists :: Day :: IPs
		$query = "SELECT stats_visit_per_day_ip_id, stats_visit_per_day_ip_day, stats_visit_per_day_ip_month, stats_visit_per_day_ip_year, stats_visit_per_day_type, stats_visit_per_day_ip FROM $t_stats_visists_per_day_ips WHERE stats_visit_per_day_ip_day='$inp_day' AND stats_visit_per_day_ip_month='$inp_month' AND stats_visit_per_day_ip_year='$inp_year' AND stats_visit_per_day_ip=$inp_ip_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_visit_per_day_ip_id, $get_stats_visit_per_day_ip_day, $get_stats_visit_per_day_ip_month, $get_stats_visit_per_day_ip_year, $get_stats_visit_per_day_type, $get_stats_visit_per_day_ip) = $row;
		if($get_stats_visit_per_day_ip_id == ""){
			// New visitor this day
			mysqli_query($link, "INSERT INTO $t_stats_visists_per_day_ips 
			(stats_visit_per_day_ip_id, stats_visit_per_day_ip_day, stats_visit_per_day_ip_month, stats_visit_per_day_ip_year, stats_visit_per_day_type, stats_visit_per_day_ip) 
			VALUES
			(NULL, '$inp_day', '$inp_month', '$inp_year', '$get_stats_user_agent_type', $inp_ip_mysql)") or die(mysqli_error($link));
			
			// Update unique
			$inp_visit_per_day_human_unique = $get_stats_visit_per_day_human_unique+1;
			if($get_stats_user_agent_type == "desktop"){
				$inp_visit_per_day_unique_desktop = $get_stats_visit_per_day_unique_desktop+1;
				$inp_visit_per_day_unique_mobile = $get_stats_visit_per_day_unique_mobile;
			}
			else{
				$inp_visit_per_day_unique_desktop = $get_stats_visit_per_day_unique_desktop;
				$inp_visit_per_day_unique_mobile = $get_stats_visit_per_day_unique_mobile+1;
			}
			$inp_visit_per_day_hits_total = $get_stats_visit_per_day_hits_total+1;
			$inp_visit_per_day_hits_human = $get_stats_visit_per_day_hits_human+1;
			
			// Update
			$result = mysqli_query($link, "UPDATE $t_stats_visists_per_day SET 
							stats_visit_per_day_human_unique=$inp_visit_per_day_human_unique,
							stats_visit_per_day_unique_desktop=$inp_visit_per_day_unique_desktop, 
							stats_visit_per_day_unique_mobile=$inp_visit_per_day_unique_mobile,
							stats_visit_per_day_hits_total=$inp_visit_per_day_hits_total,
							stats_visit_per_day_hits_human=$inp_visit_per_day_hits_human
							WHERE stats_visit_per_day_id=$get_stats_visit_per_day_id") or die(mysqli_error($link));

		}
		else{
			// Update hits
			$inp_visit_per_day_hits_total = $get_stats_visit_per_day_hits_total+1;
			$inp_visit_per_day_hits_human = $get_stats_visit_per_day_hits_human+1;
			$result = mysqli_query($link, "UPDATE $t_stats_visists_per_day SET 
							stats_visit_per_day_hits_total=$inp_visit_per_day_hits_total,
							stats_visit_per_day_hits_human=$inp_visit_per_day_hits_human
							WHERE stats_visit_per_day_id=$get_stats_visit_per_day_id") or die(mysqli_error($link));
			
		} // Visits :: Day


		// Browsers :: Year
		$query = "SELECT stats_browser_id, stats_browser_year, stats_browser_name, stats_browser_unique, stats_browser_hits FROM $t_stats_browsers_per_year WHERE stats_browser_year='$inp_year' AND stats_browser_name=$inp_user_agent_browser_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_browser_id, $get_stats_browser_year, $get_stats_browser_name, $get_stats_browser_unique, $get_stats_browser_hits) = $row;
		if($get_stats_browser_id == ""){
			mysqli_query($link, "INSERT INTO $t_stats_browsers_per_year
			(stats_browser_id, stats_browser_year, stats_browser_name, stats_browser_unique, stats_browser_hits) 
			VALUES
			(NULL, '$inp_year', $inp_user_agent_browser_mysql, '1', '1')") or die(mysqli_error($link));
		}
		else{
			// We have record, if unique
			if($get_stats_visit_per_year_ip_id == ""){
				// Unique + hits
				$inp_unique = $get_stats_browser_unique+1;
				$inp_hits   = $get_stats_browser_hits+1;
				mysqli_query($link, "UPDATE $t_stats_browsers_per_year SET stats_browser_unique=$inp_unique, stats_browser_hits=$inp_hits WHERE stats_browser_id=$get_stats_browser_id") or die(mysqli_error($link));
			}
			else{
				// Hits
				$inp_hits = $get_stats_browser_hits+1;
				mysqli_query($link, "UPDATE $t_stats_browsers_per_year SET stats_browser_hits=$inp_hits WHERE stats_browser_id=$get_stats_browser_id") or die(mysqli_error($link));
			}
		}


		// Browsers :: Month
		$query = "SELECT stats_browser_id, stats_browser_month, stats_browser_year, stats_browser_name, stats_browser_unique, stats_browser_hits FROM $t_stats_browsers_per_month WHERE stats_browser_month='$inp_month' AND stats_browser_year='$inp_year' AND stats_browser_name=$inp_user_agent_browser_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_browser_id, $get_stats_browser_month, $get_stats_browser_year, $get_stats_browser_name, $get_stats_browser_unique, $get_stats_browser_hits) = $row;
		if($get_stats_browser_id == ""){
			mysqli_query($link, "INSERT INTO $t_stats_browsers_per_month
			(stats_browser_id, stats_browser_month, stats_browser_year, stats_browser_name, stats_browser_unique, stats_browser_hits) 
			VALUES
			(NULL, '$inp_month', '$inp_year', $inp_user_agent_browser_mysql, '1', '1')") or die(mysqli_error($link));
		}
		else{
			// We have record, if unique
			if($get_stats_visit_per_month_ip_id == ""){
				// Unique + hits
				$inp_unique = $get_stats_browser_unique+1;
				$inp_hits   = $get_stats_browser_hits+1;
				mysqli_query($link, "UPDATE $t_stats_browsers_per_month SET stats_browser_unique=$inp_unique, stats_browser_hits=$inp_hits WHERE stats_browser_id=$get_stats_browser_id") or die(mysqli_error($link));
			}
			else{
				// Hits
				$inp_hits = $get_stats_browser_hits+1;
				mysqli_query($link, "UPDATE $t_stats_browsers_per_month SET stats_browser_hits=$inp_hits WHERE stats_browser_id=$get_stats_browser_id") or die(mysqli_error($link));
			}
		}
	
		// OS :: Year
		$query = "SELECT stats_os_id, stats_os_year, stats_os_name, stats_os_type, stats_os_unique, stats_os_hits FROM $t_stats_os_per_year WHERE stats_os_year='$inp_year' AND stats_os_name=$inp_user_agent_os_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_os_id, $get_stats_os_year, $get_stats_os_name, $get_stats_os_type, $get_stats_os_unique, $get_stats_os_hits) = $row;

		if($get_stats_os_id == ""){
			mysqli_query($link, "INSERT INTO $t_stats_os_per_year
			(stats_os_id, stats_os_year, stats_os_name, stats_os_type, stats_os_unique, stats_os_hits) 
			VALUES
			(NULL, '$inp_year', $inp_user_agent_os_mysql, $inp_stats_user_agent_type_mysql, '1', '1')") or die(mysqli_error($link));
		}
		else{
			// We have record, if unique
			if($get_stats_visit_per_year_ip_id == ""){
				// Unique + hits
				$inp_unique = $get_stats_os_unique+1;
				$inp_hits   = $get_stats_os_hits+1;
				mysqli_query($link, "UPDATE $t_stats_os_per_year SET stats_os_unique=$inp_unique, stats_os_hits=$inp_hits WHERE stats_os_id=$get_stats_os_id") or die(mysqli_error($link));
			}
			else{
				// Hits
				$inp_hits = $get_stats_os_unique+1;
				mysqli_query($link, "UPDATE $t_stats_os_per_year SET stats_os_hits=$inp_hits WHERE stats_os_id=$get_stats_os_id") or die(mysqli_error($link));
			}
		}

	
		// OS :: Month
		$query = "SELECT stats_os_id, stats_os_month, stats_os_year, stats_os_name, stats_os_type, stats_os_unique, stats_os_hits FROM $t_stats_os_per_month WHERE stats_os_month='$inp_month' AND stats_os_year='$inp_year' AND stats_os_name=$inp_user_agent_os_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_os_id, $get_stats_os_month, $get_stats_os_year, $get_stats_os_name, $get_stats_os_type, $get_stats_os_unique, $get_stats_os_hits) = $row;

		if($get_stats_os_id == ""){
			mysqli_query($link, "INSERT INTO $t_stats_os_per_month 
			(stats_os_id, stats_os_month, stats_os_year, stats_os_name, stats_os_type, stats_os_unique, stats_os_hits) 
			VALUES
			(NULL, '$inp_month', '$inp_year', $inp_user_agent_os_mysql, $inp_stats_user_agent_type_mysql, '1', '1')") or die(mysqli_error($link));
		}
		else{
			// We have record, if unique
			if($get_stats_visit_per_month_ip_id == ""){
				// Unique + hits
				$inp_unique = $get_stats_os_unique+1;
				$inp_hits   = $get_stats_os_hits+1;
				mysqli_query($link, "UPDATE $t_stats_os_per_month SET stats_os_unique=$inp_unique, stats_os_hits=$inp_hits WHERE stats_os_id=$get_stats_os_id") or die(mysqli_error($link));
			}
			else{
				// Hits
				$inp_hits = $get_stats_os_unique+1;
				mysqli_query($link, "UPDATE $t_stats_os_per_month SET stats_os_hits=$inp_hits WHERE stats_os_id=$get_stats_os_id") or die(mysqli_error($link));
			}
		}


		// Accepted languages :: Year
		$query = "SELECT stats_accepted_language_id, stats_accepted_language_year, stats_accepted_language_name, stats_accepted_language_unique, stats_accepted_language_hits FROM $t_stats_accepted_languages_per_year WHERE stats_accepted_language_year='$inp_year' AND stats_accepted_language_name=$inp_language_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_accepted_language_id, $get_stats_accepted_language_year, $get_stats_accepted_language_name, $get_stats_accepted_language_unique, $get_stats_accepted_language_hits) = $row;

		if($get_stats_accepted_language_id == ""){
			mysqli_query($link, "INSERT INTO $t_stats_accepted_languages_per_year
			(stats_accepted_language_id, stats_accepted_language_year, stats_accepted_language_name, stats_accepted_language_unique, stats_accepted_language_hits) 
			VALUES
			(NULL, '$inp_year', $inp_language_mysql, '1', '1')") or die(mysqli_error($link));
		}
		else{
			// We have record, if unique
			if($get_stats_visit_per_year_ip_id == ""){
				// Unique + hits
				$inp_unique = $get_stats_accepted_language_unique+1;
				$inp_hits   = $get_stats_accepted_language_hits+1;
				mysqli_query($link, "UPDATE $t_stats_accepted_languages_per_year SET stats_accepted_language_unique=$inp_unique, stats_accepted_language_hits=$inp_hits WHERE stats_accepted_language_id=$get_stats_accepted_language_id") or die(mysqli_error($link));
			}
			else{
				// Hits
				$inp_hits = $get_stats_accepted_language_unique+1;
				mysqli_query($link, "UPDATE $t_stats_accepted_languages_per_year SET stats_accepted_language_hits=$inp_hits WHERE stats_accepted_language_id=$get_stats_accepted_language_id") or die(mysqli_error($link));
			}
		}

		// Accepted languages :: Month
		$query = "SELECT stats_accepted_language_id, stats_accepted_language_month, stats_accepted_language_year, stats_accepted_language_name, stats_accepted_language_unique, stats_accepted_language_hits FROM $t_stats_accepted_languages_per_month WHERE stats_accepted_language_month='$inp_month' AND stats_accepted_language_year='$inp_year' AND stats_accepted_language_name=$inp_language_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_accepted_language_id, $get_stats_accepted_language_month, $get_stats_accepted_language_year, $get_stats_accepted_language_name, $get_stats_accepted_language_unique, $get_stats_accepted_language_hits) = $row;

		if($get_stats_accepted_language_id == ""){
			mysqli_query($link, "INSERT INTO $t_stats_accepted_languages_per_month
			(stats_accepted_language_id, stats_accepted_language_month, stats_accepted_language_year, stats_accepted_language_name, stats_accepted_language_unique, stats_accepted_language_hits) 
			VALUES
			(NULL, '$inp_month', '$inp_year', $inp_language_mysql, '1', '1')") or die(mysqli_error($link));
		}
		else{
			// We have record, if unique
			if($get_stats_visit_per_month_ip_id == ""){
				// Unique + hits
				$inp_unique = $get_stats_accepted_language_unique+1;
				$inp_hits   = $get_stats_accepted_language_hits+1;
				mysqli_query($link, "UPDATE $t_stats_accepted_languages_per_month SET stats_accepted_language_unique=$inp_unique, stats_accepted_language_hits=$inp_hits WHERE stats_accepted_language_id=$get_stats_accepted_language_id") or die(mysqli_error($link));
			}
			else{
				// Hits
				$inp_hits = $get_stats_accepted_language_unique+1;
				mysqli_query($link, "UPDATE $t_stats_accepted_languages_per_month SET stats_accepted_language_hits=$inp_hits WHERE stats_accepted_language_id=$get_stats_accepted_language_id") or die(mysqli_error($link));
			}
		}

		// Referer
		if(isset($_SERVER['HTTP_REFERER']) ){
			$inp_stats_referer_from_url  = $_SERVER['HTTP_REFERER'];
			$inp_stats_referer_from_url  = output_html($inp_stats_referer_from_url);
			$inp_stats_referer_from_url_mysql = quote_smart($link, $inp_stats_referer_from_url);
			if($inp_stats_referer_from_url != "" && $configSiteURLSav != ""){

				if (strpos($inp_stats_referer_from_url, $configSiteURLSav) !== false) {
				
				}
				else{
					// Referer :: Year
					$query = "SELECT stats_referer_id, stats_referer_year, stats_referer_from_url, stats_referer_to_url, stats_referer_unique, stats_referer_hits FROM $t_stats_referers_per_year WHERE stats_referer_year='$inp_year' AND stats_referer_from_url=$inp_stats_referer_from_url_mysql AND stats_referer_to_url=$inp_page_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_stats_referer_id, $get_stats_referer_year, $get_stats_referer_from_url, $get_stats_referer_to_url, $get_stats_referer_unique, $get_stats_referer_hits) = $row;
					if($get_stats_referer_id == ""){
						mysqli_query($link, "INSERT INTO $t_stats_referers_per_year 
						(stats_referer_id, stats_referer_year, stats_referer_from_url, stats_referer_to_url, stats_referer_unique, stats_referer_hits) 
						VALUES
						(NULL,'$inp_year', $inp_stats_referer_from_url_mysql, $inp_page_mysql, '1', '1')") or die(mysqli_error($link));
	
					}
					else{
						// We have record, if unique
						if($get_stats_visit_per_year_ip_id == ""){
							// Unique + hits
							$inp_unique = $get_stats_referer_unique+1;
							$inp_hits   = $get_stats_referer_hits+1;
							mysqli_query($link, "UPDATE $t_stats_referers_per_year SET stats_referer_unique=$inp_unique, stats_referer_hits=$inp_hits WHERE stats_referer_id=$get_stats_referer_id") or die(mysqli_error($link));
						}
						else{
							// Hits
							$inp_hits = $get_stats_referer_unique+1;
							mysqli_query($link, "UPDATE $t_stats_referers_per_year SET stats_referer_hits=$inp_hits WHERE stats_referer_id=$get_stats_referer_id") or die(mysqli_error($link));
						}
					}

					// Referer :: Month
					$query = "SELECT stats_referer_id, stats_referer_month, stats_referer_year, stats_referer_from_url, stats_referer_to_url, stats_referer_unique, stats_referer_hits FROM $t_stats_referers_per_month WHERE stats_referer_month='$inp_month' AND stats_referer_year='$inp_year' AND stats_referer_from_url=$inp_stats_referer_from_url_mysql AND stats_referer_to_url=$inp_page_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_stats_referer_id, $get_stats_referer_month, $get_stats_referer_year, $get_stats_referer_from_url, $get_stats_referer_to_url, $get_stats_referer_unique, $get_stats_referer_hits) = $row;
					if($get_stats_referer_id == ""){
						mysqli_query($link, "INSERT INTO $t_stats_referers_per_month 
						(stats_referer_id, stats_referer_month, stats_referer_year, stats_referer_from_url, stats_referer_to_url, stats_referer_unique, stats_referer_hits) 
						VALUES
						(NULL, '$inp_month', '$inp_year', $inp_stats_referer_from_url_mysql, $inp_page_mysql, '1', '1')") or die(mysqli_error($link));
	
					}
					else{
						// We have record, if unique
						if($get_stats_visit_per_month_ip_id == ""){
							// Unique + hits
							$inp_unique = $get_stats_referer_unique+1;
							$inp_hits   = $get_stats_referer_hits+1;
							mysqli_query($link, "UPDATE $t_stats_referers_per_month SET stats_referer_unique=$inp_unique, stats_referer_hits=$inp_hits WHERE stats_referer_id=$get_stats_referer_id") or die(mysqli_error($link));
						}
						else{
							// Hits
							$inp_hits = $get_stats_referer_unique+1;
							mysqli_query($link, "UPDATE $t_stats_referers_per_year month SET stats_referer_hits=$inp_hits WHERE stats_referer_id=$get_stats_referer_id") or die(mysqli_error($link));
						}
					}
				}
			}
		}

		// Country :: Find my country based on IP
		$get_ip_id = 0;
		$get_geoname_country_name = "Unknown";
		$ip_array = explode(".", $inp_ip);
		$size = sizeof($ip_array);
		if($size > 1){
			$ip_a = $ip_array[0];
			$ip_a_mysql = quote_smart($link, $ip_a);

			$ip_b = $ip_array[1];
			$ip_b_mysql = quote_smart($link, $ip_b);

			$ip_c = $ip_array[2];
			$ip_c_mysql = quote_smart($link, $ip_c);

			$ip_d = $ip_array[3];
			$ip_d_mysql = quote_smart($link, $ip_d);

			$query = "SELECT $t_stats_ip_to_country_ipv4.ip_id, $t_stats_ip_to_country_geonames.geoname_country_name FROM $t_stats_ip_to_country_ipv4 JOIN $t_stats_ip_to_country_geonames ON $t_stats_ip_to_country_ipv4.ip_geoname_id=$t_stats_ip_to_country_geonames.geoname_id";
			$query = $query . " WHERE ip_registered_country_geoname_id != ''";
			$query = $query . " AND $t_stats_ip_to_country_ipv4.ip_from_a<=$ip_a_mysql AND $t_stats_ip_to_country_ipv4.ip_to_a>=$ip_a_mysql";
			$query = $query . " AND $t_stats_ip_to_country_ipv4.ip_from_b<=$ip_b_mysql AND $t_stats_ip_to_country_ipv4.ip_to_b>=$ip_b_mysql";
			$query = $query . " AND $t_stats_ip_to_country_ipv4.ip_from_c<=$ip_c_mysql AND $t_stats_ip_to_country_ipv4.ip_to_c>=$ip_c_mysql";
			$query = $query . " AND $t_stats_ip_to_country_ipv4.ip_from_d<=$ip_d_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_ip_id, $get_geoname_country_name) = $row;
		} // ipv4
		else{
			$ip_array = explode(":", $inp_ip);

			$ip_a = hexdec($ip_array[0]);
			$ip_a_mysql = quote_smart($link, $ip_a);

			$ip_b = hexdec($ip_array[1]);
			$ip_b_mysql = quote_smart($link, $ip_b);

			$query = "SELECT $t_stats_ip_to_country_ipv6.ip_id, $t_stats_ip_to_country_geonames.geoname_country_name FROM $t_stats_ip_to_country_ipv6 JOIN $t_stats_ip_to_country_geonames ON $t_stats_ip_to_country_ipv6.ip_geoname_id=$t_stats_ip_to_country_geonames.geoname_id";
			$query = $query . " WHERE ip_registered_country_geoname_id != ''";
			$query = $query . " AND $t_stats_ip_to_country_ipv6.ip_from_dec_a<=$ip_a_mysql AND $t_stats_ip_to_country_ipv6.ip_to_dec_a>=$ip_a_mysql";
			$query = $query . " AND $t_stats_ip_to_country_ipv6.ip_from_dec_b<=$ip_b_mysql AND $t_stats_ip_to_country_ipv6.ip_to_dec_b>=$ip_b_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_ip_id, $get_geoname_country_name) = $row;
		} // ipv6


		// Country :: Year
		$inp_geoname_country_name_mysql = quote_smart($link, $get_geoname_country_name);
		$query = "SELECT stats_country_id, stats_country_unique, stats_country_hits FROM $t_stats_countries_per_year WHERE stats_country_year='$inp_year' AND stats_country_name=$inp_geoname_country_name_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_country_id, $get_stats_country_unique, $get_stats_country_hits) = $row;
		if($get_stats_country_id == ""){
			mysqli_query($link, "INSERT INTO $t_stats_countries_per_year
			(stats_country_id, stats_country_year, stats_country_name, stats_country_unique, stats_country_hits) 
			VALUES
			(NULL, '$inp_year', $inp_geoname_country_name_mysql, 1, 1)") or die(mysqli_error($link));
		}
		else{
			// We have record, if unique
			if($get_stats_visit_per_year_ip_id == ""){
				// Unique + hits
				$inp_unique = $get_stats_country_unique+1;
				$inp_hits   = $get_stats_country_hits+1;
				mysqli_query($link, "UPDATE $t_stats_countries_per_year SET stats_country_unique=$inp_unique, stats_country_hits=$inp_hits WHERE stats_country_id=$get_stats_country_id") or die(mysqli_error($link));
			}
			else{
				// Hits
				$inp_hits = $get_stats_country_hits+1;
				mysqli_query($link, "UPDATE $t_stats_countries_per_year SET stats_country_hits=$inp_hits WHERE stats_country_id=$get_stats_country_id") or die(mysqli_error($link));
			}
		}

		// Country :: Month
		$inp_geoname_country_name_mysql = quote_smart($link, $get_geoname_country_name);
		$query = "SELECT stats_country_id, stats_country_unique, stats_country_hits FROM $t_stats_countries_per_month WHERE stats_country_month='$inp_month' AND stats_country_year='$inp_year' AND stats_country_name=$inp_geoname_country_name_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_country_id, $get_stats_country_unique, $get_stats_country_hits) = $row;
		if($get_stats_country_id == ""){
			mysqli_query($link, "INSERT INTO $t_stats_countries_per_month
			(stats_country_id, stats_country_month, stats_country_year, stats_country_name, stats_country_unique, stats_country_hits) 
			VALUES
			(NULL, '$inp_month', '$inp_year', $inp_geoname_country_name_mysql, 1, 1)") or die(mysqli_error($link));
		}
		else{
			// We have record, if unique
			if($get_stats_visit_per_year_ip_id == ""){
				// Unique + hits
				$inp_unique = $get_stats_country_unique+1;
				$inp_hits   = $get_stats_country_hits+1;
				mysqli_query($link, "UPDATE $t_stats_countries_per_month SET stats_country_unique=$inp_unique, stats_country_hits=$inp_hits WHERE stats_country_id=$get_stats_country_id") or die(mysqli_error($link));
			}
			else{
				// Hits
				$inp_hits = $get_stats_country_hits+1;
				mysqli_query($link, "UPDATE $t_stats_countries_per_month SET stats_country_hits=$inp_hits WHERE stats_country_id=$get_stats_country_id") or die(mysqli_error($link));
			}
		}

	} // End Human

	
	
	
} // user agent found
?>