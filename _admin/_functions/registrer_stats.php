<?php
/**
*
* File: _admin/_functions/registrer_stats.php
* Version 1.0
* Date 20:54 03.11.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
// To do: $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
// Referer


/*- Find me based on user ------------------------------------------------------------------- */
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$user_agent = output_html($user_agent);
$user_agent_mysql = quote_smart($link, $user_agent);

$inp_ip = $_SERVER['REMOTE_ADDR'];
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

$query = "SELECT banned_user_agent_id FROM $t_banned_user_agents WHERE banned_user_agent=$user_agent_mysql";
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



$query = "SELECT stats_user_agent_id, stats_user_agent_string, stats_user_agent_browser, stats_user_agent_os, stats_user_agent_bot, stats_user_agent_url, stats_user_agent_browser_icon, stats_user_agent_os_icon, stats_user_agent_bot_icon, stats_user_agent_type, stats_user_agent_banned FROM $t_stats_user_agents WHERE stats_user_agent_string=$user_agent_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_stats_user_agent_id, $get_stats_user_agent_string, $get_stats_user_agent_browser, $get_stats_user_agent_os, $get_stats_user_agent_bot, $get_stats_user_agent_url, $get_stats_user_agent_browser_icon, $get_stats_user_agent_os_icon, $get_stats_user_agent_bot_icon, $get_stats_user_agent_type, $get_stats_user_agent_banned) = $row;


if($get_stats_user_agent_id == ""){
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
	$inp_date = date("Y-m-d");
	$inp_time = date("H:i:s");
	$inp_month = date("m");
	$inp_month_saying = date("M");
	$inp_year = date("Y");
	$inp_unix_time = time();
	$inp_weekday = date("D");


	// Get monthly
	$query = "SELECT stats_monthly_id, stats_monthly_month, stats_monthly_month_saying, stats_monthly_year, stats_monthly_human_unique, stats_monthly_human_unique_diff_from_last_month, stats_monthly_human_average_duration, stats_monthly_human_new_visitor_unique, stats_monthly_human_returning_visitor_unique, stats_monthly_unique_desktop, stats_monthly_unique_desktop_diff_from_last_month, stats_monthly_unique_mobile, stats_monthly_unique_mobile_diff_from_last_month, stats_monthly_unique_bots, stats_monthly_unique_bots_diff_from_last_month, stats_monthly_hits, stats_monthly_hits_desktop, stats_monthly_hits_mobile, stats_monthly_hits_bots, stats_monthly_sum_unique_browsers, stats_monthly_sum_unique_os FROM $t_stats_monthly WHERE stats_monthly_month='$inp_month' AND stats_monthly_year='$inp_year'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_monthly_id, $get_stats_monthly_month, $get_stats_monthly_month_saying, $get_stats_monthly_year, $get_stats_monthly_human_unique, $get_stats_monthly_human_unique_diff_from_last_month, $get_stats_monthly_human_average_duration, $get_stats_monthly_human_new_visitor_unique, $get_stats_monthly_human_returning_visitor_unique, $get_stats_monthly_unique_desktop, $get_stats_monthly_unique_desktop_diff_from_last_month, $get_stats_monthly_unique_mobile, $get_stats_monthly_unique_mobile_diff_from_last_month, $get_stats_monthly_unique_bots, $get_stats_monthly_unique_bots_diff_from_last_month, $get_stats_monthly_hits, $get_stats_monthly_hits_desktop, $get_stats_monthly_hits_mobile, $get_stats_monthly_hits_bots, $get_stats_monthly_sum_unique_browsers, $get_stats_monthly_sum_unique_os) = $row;
	if($get_stats_monthly_id == ""){
		// Create
		mysqli_query($link, "INSERT INTO $t_stats_monthly
		(stats_monthly_id, stats_monthly_month, stats_monthly_month_saying, stats_monthly_year, stats_monthly_human_unique, 
		stats_monthly_human_unique_diff_from_last_month, stats_monthly_human_average_duration, stats_monthly_human_new_visitor_unique, stats_monthly_human_returning_visitor_unique, stats_monthly_unique_desktop, 
		stats_monthly_unique_desktop_diff_from_last_month, stats_monthly_unique_mobile, stats_monthly_unique_mobile_diff_from_last_month, stats_monthly_unique_bots, stats_monthly_unique_bots_diff_from_last_month, 
		stats_monthly_hits, stats_monthly_hits_desktop, stats_monthly_hits_mobile, stats_monthly_hits_bots, stats_monthly_sum_unique_browsers, 
		stats_monthly_sum_unique_os) 
		VALUES
		(NULL, '$inp_month', '$inp_month_saying', '$inp_year', '0', 
		'0', '0', '0', '0', '0', 
		'0', '0', '0', '0', '0', 
		'0', '0', '0', '0', '0',
		'0')") or die(mysqli_error($link));
	
		$query = "SELECT stats_monthly_id, stats_monthly_month, stats_monthly_month_saying, stats_monthly_year, stats_monthly_human_unique, stats_monthly_human_unique_diff_from_last_month, stats_monthly_human_average_duration, stats_monthly_human_new_visitor_unique, stats_monthly_human_returning_visitor_unique, stats_monthly_unique_desktop, stats_monthly_unique_desktop_diff_from_last_month, stats_monthly_unique_mobile, stats_monthly_unique_mobile_diff_from_last_month, stats_monthly_unique_bots, stats_monthly_unique_bots_diff_from_last_month, stats_monthly_hits, stats_monthly_hits_desktop, stats_monthly_hits_mobile, stats_monthly_hits_bots, stats_monthly_sum_unique_browsers, stats_monthly_sum_unique_os FROM $t_stats_monthly WHERE stats_monthly_month='$inp_month' AND stats_monthly_year='$inp_year'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_monthly_id, $get_stats_monthly_month, $get_stats_monthly_month_saying, $get_stats_monthly_year, $get_stats_monthly_human_unique, $get_stats_monthly_human_unique_diff_from_last_month, $get_stats_monthly_human_average_duration, $get_stats_monthly_human_new_visitor_unique, $get_stats_monthly_human_returning_visitor_unique, $get_stats_monthly_unique_desktop, $get_stats_monthly_unique_desktop_diff_from_last_month, $get_stats_monthly_unique_mobile, $get_stats_monthly_unique_mobile_diff_from_last_month, $get_stats_monthly_unique_bots, $get_stats_monthly_unique_bots_diff_from_last_month, $get_stats_monthly_hits, $get_stats_monthly_hits_desktop, $get_stats_monthly_hits_mobile, $get_stats_monthly_hits_bots, $get_stats_monthly_sum_unique_browsers, $get_stats_monthly_sum_unique_os) = $row;

		// Truncate temp data
		mysqli_query($link,"TRUNCATE TABLE $t_stats_human_ipblock") or die(mysqli_error());
		mysqli_query($link,"TRUNCATE TABLE $t_stats_bot_ipblock") or die(mysqli_error());
	}


	// Get dayli
	$query = "SELECT stats_dayli_id, stats_dayli_day, stats_dayli_month, stats_dayli_year, stats_dayli_weekday, stats_dayli_human_unique, stats_dayli_human_unique_diff_from_yesterday, stats_dayli_human_average_duration, stats_dayli_human_new_visitor_unique, stats_dayli_human_returning_visitor_unique, stats_dayli_unique_desktop, stats_dayli_unique_mobile, stats_dayli_unique_bots, stats_dayli_hits, stats_dayli_hits_desktop, stats_dayli_hits_mobile, stats_dayli_hits_bots FROM $t_stats_dayli WHERE stats_dayli_day='$inp_day' AND stats_dayli_month='$inp_month' AND stats_dayli_year='$inp_year'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_stats_dayli_id, $get_stats_dayli_day, $get_stats_dayli_month, $get_stats_dayli_year, $get_stats_dayli_weekday, $get_stats_dayli_human_unique, $get_stats_dayli_human_unique_diff_from_yesterday, $get_stats_dayli_human_average_duration, $get_stats_dayli_human_new_visitor_unique, $get_stats_dayli_human_returning_visitor_unique, $get_stats_dayli_unique_desktop, $get_stats_dayli_unique_mobile, $get_stats_dayli_unique_bots, $get_stats_dayli_hits, $get_stats_dayli_hits_desktop, $get_stats_dayli_hits_mobile, $get_stats_dayli_hits_bots) = $row;
	if($get_stats_dayli_id == ""){
		// Create
		mysqli_query($link, "INSERT INTO $t_stats_dayli 
		(stats_dayli_id, stats_dayli_day, stats_dayli_month, stats_dayli_year, stats_dayli_weekday, stats_dayli_human_unique, stats_dayli_human_unique_diff_from_yesterday, stats_dayli_human_average_duration, stats_dayli_human_new_visitor_unique, stats_dayli_human_returning_visitor_unique, stats_dayli_unique_desktop, stats_dayli_unique_mobile, stats_dayli_unique_bots, stats_dayli_hits, stats_dayli_hits_desktop, stats_dayli_hits_mobile, stats_dayli_hits_bots) 
		VALUES
		(NULL, '$inp_day', '$inp_month', '$inp_year', '$inp_weekday', '0', '0','0','0','0', '0', '0', '0', '0', '0', '0', '0')") or die(mysqli_error($link));

		$query = "SELECT stats_dayli_id, stats_dayli_day, stats_dayli_month, stats_dayli_year, stats_dayli_weekday, stats_dayli_human_unique, stats_dayli_human_unique_diff_from_yesterday, stats_dayli_human_average_duration, stats_dayli_human_new_visitor_unique, stats_dayli_human_returning_visitor_unique, stats_dayli_unique_desktop, stats_dayli_unique_mobile, stats_dayli_unique_bots, stats_dayli_hits, stats_dayli_hits_desktop, stats_dayli_hits_mobile, stats_dayli_hits_bots FROM $t_stats_dayli WHERE stats_dayli_day='$inp_day' AND stats_dayli_month='$inp_month' AND stats_dayli_year='$inp_year'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_dayli_id, $get_stats_dayli_day, $get_stats_dayli_month, $get_stats_dayli_year, $get_stats_dayli_weekday, $get_stats_dayli_human_unique, $get_stats_dayli_human_unique_diff_from_yesterday, $get_stats_dayli_human_average_duration, $get_stats_dayli_human_new_visitor_unique, $get_stats_dayli_human_returning_visitor_unique, $get_stats_dayli_unique_desktop, $get_stats_dayli_unique_mobile, $get_stats_dayli_unique_bots, $get_stats_dayli_hits, $get_stats_dayli_hits_desktop, $get_stats_dayli_hits_mobile, $get_stats_dayli_hits_bots) = $row;

	}


	// Browser

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
		// Have I visited before?
		$query = "SELECT stats_bot_ipblock_visitor_id FROM $t_stats_bot_ipblock WHERE stats_bot_ipblock_visitor_date='$inp_date' AND stats_bot_ipblock_visitor_name=$inp_user_agent_bot_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_bot_ipblock_visitor_id) = $row;
		
		if($get_stats_bot_ipblock_visitor_id == ""){

			// This bot has not visited today
			mysqli_query($link, "INSERT INTO $t_stats_bot_ipblock
			(stats_bot_ipblock_visitor_id, stats_bot_ipblock_visitor_date, stats_bot_ipblock_visitor_time, stats_bot_ipblock_visitor_month, stats_bot_ipblock_visitor_year, stats_bot_ipblock_visitor_name, stats_bot_ipblock_visitor_page) 
			VALUES
			(NULL, '$inp_date', '$inp_time', '$inp_month', '$inp_year', $inp_user_agent_bot_mysql, $inp_page_mysql)") or die(mysqli_error($link));

			
			// Did it visit before this month?
			$query = "SELECT stats_bot_id, stats_bot_unique, stats_bot_hits FROM $t_stats_bots WHERE stats_bot_month='$inp_month' AND stats_bot_year='$inp_year' AND stats_bot_name=$inp_user_agent_bot_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_stats_bot_id, $get_stats_bot_unique, $get_stats_bot_hits) = $row;
			if($get_stats_bot_id == ""){
				// This bot has not visited at all this month
				// Insert Stats bots
				mysqli_query($link, "INSERT INTO $t_stats_bots
				(stats_bot_id, stats_bot_month, stats_bot_year, stats_bot_name, stats_bot_unique, stats_bot_hits) 
				VALUES
				(NULL, '$inp_month', '$inp_year', $inp_user_agent_bot_mysql, '1', '1')") or die(mysqli_error($link));
			}
			else{
				// This bot was here yesterday
				// Update unique hits
				
				$inp_stats_bot_unique = $get_stats_bot_unique+1;
				$inp_stats_bot_hits = $get_stats_bot_hits+1;
				$result = mysqli_query($link, "UPDATE $t_stats_bots SET stats_bot_unique='$inp_stats_bot_unique', stats_bot_hits='$inp_stats_bot_hits' WHERE stats_bot_id='$get_stats_bot_id'");

			}

			// Update Stats :: Daily (unique bots)
			$inp_stats_dayli_unique_bots = $get_stats_dayli_unique_bots+1;
			$inp_stats_dayli_hits	     = $get_stats_dayli_hits+1;
			$inp_stats_dayli_hits_bots   = $get_stats_dayli_hits_bots+1;
			$result = mysqli_query($link, "UPDATE $t_stats_dayli SET stats_dayli_unique_bots='$inp_stats_dayli_unique_bots', stats_dayli_hits=$inp_stats_dayli_hits, stats_dayli_hits_bots='$inp_stats_dayli_hits_bots' WHERE stats_dayli_id='$get_stats_dayli_id'");

			//  Update Stats :: Monthly (unique bots)
			$inp_stats_monthly_unique_bots = $get_stats_monthly_unique_bots+1;
			$inp_stats_monthly_hits_bots   = $get_stats_monthly_hits_bots+1;
			$result = mysqli_query($link, "UPDATE $t_stats_monthly SET stats_monthly_unique_bots='$inp_stats_monthly_unique_bots', stats_monthly_hits_bots='$inp_stats_monthly_hits_bots' WHERE stats_monthly_id='$get_stats_monthly_id'");



		}
		else{
			// Make sure that the bot is registered this month
			$query = "SELECT stats_bot_id, stats_bot_unique, stats_bot_hits FROM $t_stats_bots WHERE stats_bot_month='$inp_month' AND stats_bot_year='$inp_year' AND stats_bot_name=$inp_user_agent_bot_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_stats_bot_id, $get_stats_bot_unique, $get_stats_bot_hits) = $row;
			if($get_stats_bot_id == ""){
				// Insert Stats bots
				mysqli_query($link, "INSERT INTO $t_stats_bots
				(stats_bot_id, stats_bot_month, stats_bot_year, stats_bot_name, stats_bot_unique, stats_bot_hits) 
				VALUES
				(NULL, '$inp_month', '$inp_year', $inp_user_agent_bot_mysql, '1', '1')") or die(mysqli_error($link));
			}


			// Returning bot visitor for today
			$inp_stats_bot_hits = $get_stats_bot_hits+1;
			$result = mysqli_query($link, "UPDATE $t_stats_bots SET stats_bot_hits='$inp_stats_bot_hits' WHERE stats_bot_id='$get_stats_bot_id'");


			// Update Stats :: Daily (hits bots)
			$inp_stats_dayli_hits	     = $get_stats_dayli_hits+1;
			$inp_stats_dayli_hits_bots   = $get_stats_dayli_hits_bots+1;
			$result = mysqli_query($link, "UPDATE $t_stats_dayli SET stats_dayli_hits=$inp_stats_dayli_hits, stats_dayli_hits_bots='$inp_stats_dayli_hits_bots' WHERE stats_dayli_id='$get_stats_dayli_id'");

			//  Update Stats :: Monthly (hits bots)
			$inp_stats_monthly_hits_bots   = $get_stats_monthly_hits_bots+1;
			$result = mysqli_query($link, "UPDATE $t_stats_monthly SET stats_monthly_hits_bots='$inp_stats_monthly_hits_bots' WHERE stats_monthly_id='$get_stats_monthly_id'");




		}


		


	} // End Bot
	elseif($get_stats_user_agent_type == "desktop" OR $get_stats_user_agent_type == "mobile"){
		// Have I visisted before this month?
		$query = "SELECT stats_human_visitor_id, stats_human_visitor_date, stats_human_visitor_hits FROM $t_stats_human_ipblock WHERE stats_human_visitor_month='$inp_month' AND stats_human_visitor_year='$inp_year' AND stats_human_visitor_ip=$inp_ip_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_human_visitor_id, $get_stats_human_visitor_date, $get_stats_human_visitor_hits) = $row;




		// Get browsers
		$query = "SELECT stats_browser_id, stats_browser_unique, stats_browser_hits FROM $t_stats_browsers WHERE stats_browser_month='$inp_month' AND stats_browser_year='$inp_year' AND stats_browser_name=$inp_user_agent_browser_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_browser_id, $get_stats_browser_unique, $get_stats_browser_hits) = $row;

		if($get_stats_browser_id == ""){

			mysqli_query($link, "INSERT INTO $t_stats_browsers
			(stats_browser_id, stats_browser_month, stats_browser_year, stats_browser_name, stats_browser_unique, stats_browser_hits) 
			VALUES
			(NULL, '$inp_month', '$inp_year', $inp_user_agent_browser_mysql, '0', '0')") or die(mysqli_error($link));

			$query = "SELECT stats_browser_id, stats_browser_unique, stats_browser_hits FROM $t_stats_browsers WHERE stats_browser_month='$inp_month' AND stats_browser_year='$inp_year' AND stats_browser_name=$inp_user_agent_browser_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_stats_browser_id, $get_stats_browser_unique, $get_stats_browser_hits) = $row;

		}

		// Get os
		$query = "SELECT stats_os_id, stats_os_unique, stats_os_hits FROM $t_stats_os WHERE stats_os_month='$inp_month' AND stats_os_year='$inp_year' AND stats_os_name=$inp_user_agent_os_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_os_id, $get_stats_os_unique, $get_stats_os_hits) = $row;

		if($get_stats_os_id == ""){
			mysqli_query($link, "INSERT INTO $t_stats_os
			(stats_os_id, stats_os_month, stats_os_year, stats_os_name, stats_os_type, stats_os_unique, stats_os_hits) 
			VALUES
			(NULL, '$inp_month', '$inp_year', $inp_user_agent_os_mysql, $inp_stats_user_agent_type_mysql, '0', '0')") or die(mysqli_error($link));

			$query = "SELECT stats_os_id, stats_os_unique, stats_os_hits FROM $t_stats_os WHERE stats_os_month='$inp_month' AND stats_os_year='$inp_year' AND stats_os_name=$inp_user_agent_os_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_stats_os_id, $get_stats_os_unique, $get_stats_os_hits) = $row;

		}

		// Get language
		$query = "SELECT stats_accepted_language_id, stats_accepted_language_unique, stats_accepted_language_hits FROM $t_stats_accepted_languages WHERE stats_accepted_language_month='$inp_month' AND stats_accepted_language_year='$inp_year' AND stats_accepted_language_name=$inp_language_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_accepted_language_id, $get_stats_accepted_language_unique, $get_stats_accepted_language_hits) = $row;

		if($get_stats_accepted_language_id == ""){
			mysqli_query($link, "INSERT INTO $t_stats_accepted_languages
			(stats_accepted_language_id, stats_accepted_language_month, stats_accepted_language_year, stats_accepted_language_name, stats_accepted_language_unique, stats_accepted_language_hits) 
			VALUES
			(NULL, '$inp_month', '$inp_year', $inp_language_mysql, '0', '0')") or die(mysqli_error($link));

			$query = "SELECT stats_accepted_language_id, stats_accepted_language_unique, stats_accepted_language_hits FROM $t_stats_accepted_languages WHERE stats_accepted_language_month='$inp_month' AND stats_accepted_language_year='$inp_year' AND stats_accepted_language_name=$inp_language_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_stats_accepted_language_id, $get_stats_accepted_language_unique, $get_stats_accepted_language_hits) = $row;

		}



		// Human visitor
		if($get_stats_human_visitor_id == ""){
			// I have never visited this month or this year

			// New human visitor
			mysqli_query($link, "INSERT INTO $t_stats_human_ipblock
			(stats_human_visitor_id, stats_human_visitor_date, stats_human_visitor_time, stats_human_visitor_month, stats_human_visitor_year, stats_human_visitor_timestamp_first_seen, stats_human_visitor_timestamp_last_seen, stats_human_visitor_hits, stats_human_visitor_ip, stats_human_visitor_browser, stats_human_visitor_os, stats_human_visitor_language, stats_human_visitor_type, stats_human_visitor_page) 
			VALUES
			(NULL, '$inp_date', '$inp_time', '$inp_month', '$inp_year', '$inp_unix_time', '$inp_unix_time', '1', $inp_ip_mysql, $inp_user_agent_browser_mysql, '$get_stats_user_agent_os', $inp_language_mysql, '$get_stats_user_agent_type', $inp_page_mysql)") or die(mysqli_error($link));



			// Update unique humans
			$inp_stats_dayli_human_unique = $get_stats_dayli_human_unique+1;
			$inp_stats_dayli_hits = $get_stats_dayli_hits+1;

			// Update returning visitor (we dont have any line in stats_human_ipblock with yesterdays date)
			$inp_stats_dayli_human_new_visitor_unique = $get_stats_dayli_human_new_visitor_unique + 1; // New today
			$inp_stats_dayli_human_returning_visitor_unique = $get_stats_dayli_human_returning_visitor_unique; // Not returning today

			if($get_stats_user_agent_type == "desktop"){
				$inp_stats_dayli_unique_desktop = $get_stats_dayli_unique_desktop+1;
			$inp_stats_dayli_hits_desktop  = $get_stats_dayli_hits_desktop+1;
			}
			else{
				$inp_stats_dayli_unique_desktop = $get_stats_dayli_unique_desktop;
				$inp_stats_dayli_hits_desktop  = $get_stats_dayli_hits_desktop;
			}
			if($get_stats_user_agent_type == "mobile"){
				$inp_stats_dayli_unique_mobile  = $get_stats_dayli_unique_mobile+1;
				$inp_stats_dayli_hits_mobile  = $get_stats_dayli_hits_mobile+1;
			}
			else{
				$inp_stats_dayli_unique_mobile  = $get_stats_dayli_unique_mobile;
				$inp_stats_dayli_hits_mobile  = $get_stats_dayli_hits_mobile;
			}

			$result = mysqli_query($link, "UPDATE $t_stats_dayli SET stats_dayli_human_unique=$inp_stats_dayli_human_unique, 
				stats_dayli_human_new_visitor_unique=$inp_stats_dayli_human_new_visitor_unique,
				stats_dayli_human_returning_visitor_unique=$inp_stats_dayli_human_returning_visitor_unique,
				stats_dayli_unique_desktop=$inp_stats_dayli_unique_desktop, stats_dayli_unique_mobile=$inp_stats_dayli_unique_mobile, stats_dayli_hits=$inp_stats_dayli_hits, stats_dayli_hits_desktop=$inp_stats_dayli_hits_desktop, stats_dayli_hits_mobile=$inp_stats_dayli_hits_mobile WHERE stats_dayli_id='$get_stats_dayli_id'");


	 	 
			// Update browser unique + hits
			$inp_stats_browser_unique = $get_stats_browser_unique+1;
			$inp_stats_browser_hits   = $get_stats_browser_hits+1;

			$result = mysqli_query($link, "UPDATE $t_stats_browsers SET stats_browser_unique='$inp_stats_browser_unique', stats_browser_hits='$inp_stats_browser_hits' WHERE stats_browser_id='$get_stats_browser_id'") or die(mysqli_error());

			// Update os unique + hits
			$inp_stats_os_unique = $get_stats_os_unique+1;
			$inp_stats_os_hits   = $get_stats_os_hits+1;

			$result = mysqli_query($link, "UPDATE $t_stats_os SET stats_os_unique='$inp_stats_os_unique', stats_os_hits='$inp_stats_os_hits' WHERE stats_os_id='$get_stats_os_id'") or die(mysqli_error());

			// Update language unique + hits
			$inp_stats_accepted_language_unique = $get_stats_accepted_language_unique+1;
			$inp_stats_accepted_language_hits   = $get_stats_accepted_language_hits+1;

			$result = mysqli_query($link, "UPDATE $t_stats_accepted_languages SET stats_accepted_language_unique='$inp_stats_accepted_language_unique', stats_accepted_language_hits='$inp_stats_accepted_language_hits' WHERE stats_accepted_language_id='$get_stats_accepted_language_id'") or die(mysqli_error());


			// Update monthly 
			$inp_stats_monthly_human_unique = $get_stats_monthly_human_unique+1;
			$inp_stats_monthly_hits = $get_stats_monthly_hits+1;

			$inp_stats_monthly_human_new_visitor_unique = $get_stats_monthly_human_new_visitor_unique + 1; // New this month
			$inp_stats_monthly_human_returning_visitor_unique = $get_stats_monthly_human_returning_visitor_unique; // Not returning this month (new)

			if($get_stats_user_agent_type == "desktop"){ 
				$inp_stats_monthly_unique_desktop = $get_stats_monthly_unique_desktop+1;
				$inp_stats_monthly_hits_desktop   = $get_stats_monthly_hits_desktop+1;
			} 
			else{ 
				$inp_stats_monthly_unique_desktop = $get_stats_monthly_unique_desktop;
				$inp_stats_monthly_hits_desktop   = $get_stats_monthly_hits_desktop;
			}
			if($get_stats_user_agent_type == "mobile"){	
				$inp_stats_monthly_unique_mobile = $get_stats_monthly_unique_mobile+1;
				$inp_stats_monthly_hits_mobile = $get_stats_monthly_hits_mobile+1;
			}
			else{ 
				$inp_stats_monthly_unique_mobile = $get_stats_monthly_unique_mobile;
				$inp_stats_monthly_hits_mobile = $get_stats_monthly_hits_mobile;
			}

			$inp_stats_monthly_sum_unique_browsers = $get_stats_monthly_sum_unique_browsers+1;
			$inp_stats_monthly_sum_unique_os       = $get_stats_monthly_sum_unique_os+1;

			$result = mysqli_query($link, "UPDATE $t_stats_monthly SET stats_monthly_human_unique='$inp_stats_monthly_human_unique', 
							stats_monthly_human_new_visitor_unique=$inp_stats_monthly_human_new_visitor_unique, stats_monthly_human_returning_visitor_unique=$inp_stats_monthly_human_returning_visitor_unique,
							stats_monthly_unique_desktop='$inp_stats_monthly_unique_desktop', 
							stats_monthly_unique_mobile='$inp_stats_monthly_unique_mobile',
							stats_monthly_hits='$inp_stats_monthly_hits', stats_monthly_hits_desktop='$inp_stats_monthly_hits_desktop', 
							stats_monthly_hits_mobile='$inp_stats_monthly_hits_mobile', 
							stats_monthly_sum_unique_browsers='$inp_stats_monthly_sum_unique_browsers', stats_monthly_sum_unique_os='$inp_stats_monthly_sum_unique_os' WHERE stats_monthly_id='$get_stats_monthly_id'");

			// Find my country based on IP
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


			if(isset($get_geoname_country_name) && $get_geoname_country_name != ""){
				// Check if exists
				$inp_geoname_country_name_mysql = quote_smart($link, $get_geoname_country_name);

				$query = "SELECT stats_country_id, stats_country_unique FROM $t_stats_countries WHERE stats_country_month='$inp_month' AND stats_country_year='$inp_year' AND stats_country_name=$inp_geoname_country_name_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_stats_country_id, $get_stats_country_unique) = $row;

				if($get_stats_country_id == ""){
					mysqli_query($link, "INSERT INTO $t_stats_countries
					(stats_country_id, stats_country_month, stats_country_year, stats_country_name, stats_country_unique, stats_country_last_ip) 
					VALUES
					(NULL, '$inp_month', '$inp_year', $inp_geoname_country_name_mysql, 1, $inp_ip_mysql)") or die(mysqli_error($link));
				}
				else{
					$inp_stats_country_unique = $get_stats_country_unique+1;
					$result = mysqli_query($link, "UPDATE $t_stats_countries SET stats_country_unique=$inp_stats_country_unique, stats_country_last_ip=$inp_ip_mysql WHERE stats_country_id='$get_stats_country_id'");
				}
			}

		}
		else{
			// I have visited before this month, but maby not today?

			// Returning human visitor -- IP BLOCK table
			$inp_hits = $get_stats_human_visitor_hits+1;

			$result = mysqli_query($link, "UPDATE $t_stats_human_ipblock SET 
			stats_human_visitor_date='$inp_date', stats_human_visitor_time='$inp_time', stats_human_visitor_timestamp_last_seen='$inp_unix_time', stats_human_visitor_hits=$inp_hits, stats_human_visitor_page=$inp_page_mysql WHERE stats_human_visitor_id='$get_stats_human_visitor_id'");


			if($get_stats_human_visitor_date == "$inp_date"){
				// I have visited before this month and today
				// Update hits humans
				$inp_stats_dayli_human_unique = $get_stats_dayli_human_unique;
				$inp_stats_dayli_hits = $get_stats_dayli_hits+1;

				// Update returning visitor
				$inp_stats_dayli_human_new_visitor_unique = $get_stats_dayli_human_new_visitor_unique; // Not new today
				$inp_stats_dayli_human_returning_visitor_unique = $get_stats_dayli_human_returning_visitor_unique; // Returning visitor, but I have been registered below (in else)


				if($get_stats_user_agent_type == "desktop"){
					$inp_stats_dayli_unique_desktop = $get_stats_dayli_unique_desktop;
					$inp_stats_dayli_hits_desktop  = $get_stats_dayli_hits_desktop+1;
				}
				else{
					$inp_stats_dayli_unique_desktop = $get_stats_dayli_unique_desktop;
					$inp_stats_dayli_hits_desktop  = $get_stats_dayli_hits_desktop;
				}
				if($get_stats_user_agent_type == "mobile"){
					$inp_stats_dayli_unique_mobile  = $get_stats_dayli_unique_mobile;
					$inp_stats_dayli_hits_mobile  = $get_stats_dayli_hits_mobile+1;
				}
				else{
					$inp_stats_dayli_unique_mobile  = $get_stats_dayli_unique_mobile;
					$inp_stats_dayli_hits_mobile  = $get_stats_dayli_hits_mobile;
				}
			}
			else{
				$inp_stats_dayli_human_unique = $get_stats_dayli_human_unique+1;
				$inp_stats_dayli_hits = $get_stats_dayli_hits+1;

				// Update returning visitor (here we have to have a line in stats_human_ipblock with yesterdays date)
				$inp_stats_dayli_human_new_visitor_unique = $get_stats_dayli_human_new_visitor_unique + 1; // New today
				$inp_stats_dayli_human_returning_visitor_unique = $get_stats_dayli_human_returning_visitor_unique; // Not returning today

				if($get_stats_user_agent_type == "desktop"){
					$inp_stats_dayli_unique_desktop = $get_stats_dayli_unique_desktop+1;
					$inp_stats_dayli_hits_desktop  = $get_stats_dayli_hits_desktop+1;
				}
				else{
					$inp_stats_dayli_unique_desktop = $get_stats_dayli_unique_desktop;
					$inp_stats_dayli_hits_desktop  = $get_stats_dayli_hits_desktop;
				}
				if($get_stats_user_agent_type == "mobile"){
					$inp_stats_dayli_unique_mobile  = $get_stats_dayli_unique_mobile+1;
					$inp_stats_dayli_hits_mobile  = $get_stats_dayli_hits_mobile+1;
				}
				else{
					$inp_stats_dayli_unique_mobile  = $get_stats_dayli_unique_mobile;
					$inp_stats_dayli_hits_mobile  = $get_stats_dayli_hits_mobile;
				}

				// Returing monthly
				$inp_stats_monthly_human_returning_visitor_unique = $get_stats_monthly_human_returning_visitor_unique+1;

				$result = mysqli_query($link, "UPDATE $t_stats_monthly SET stats_monthly_human_returning_visitor_unique=$inp_stats_monthly_human_returning_visitor_unique WHERE stats_monthly_id='$get_stats_monthly_id'");

			}

						


			$result = mysqli_query($link, "UPDATE $t_stats_dayli SET stats_dayli_human_unique=$inp_stats_dayli_human_unique, 
						stats_dayli_human_new_visitor_unique=$inp_stats_dayli_human_new_visitor_unique,
						stats_dayli_human_returning_visitor_unique=$inp_stats_dayli_human_returning_visitor_unique,
						stats_dayli_unique_desktop=$inp_stats_dayli_unique_desktop, 
						stats_dayli_unique_mobile=$inp_stats_dayli_unique_mobile, 
						stats_dayli_hits=$inp_stats_dayli_hits, 
						stats_dayli_hits_desktop=$inp_stats_dayli_hits_desktop, 
						stats_dayli_hits_mobile=$inp_stats_dayli_hits_mobile WHERE stats_dayli_id='$get_stats_dayli_id'") or die(mysqli_error($link));



			// Update browser hits
			$inp_stats_browser_hits   = $get_stats_browser_hits+1;

			$result = mysqli_query($link, "UPDATE $t_stats_browsers SET stats_browser_hits='$inp_stats_browser_hits' WHERE stats_browser_id='$get_stats_browser_id'");

			// Update os hits
			$inp_stats_os_hits   = $get_stats_os_hits+1;

			$result = mysqli_query($link, "UPDATE $t_stats_os SET stats_os_hits='$inp_stats_os_hits' WHERE stats_os_id='$get_stats_os_id'");


			// Update language hits
			$inp_stats_accepted_language_hits   = $get_stats_accepted_language_hits+1;

			$result = mysqli_query($link, "UPDATE $t_stats_accepted_languages SET stats_accepted_language_hits='$inp_stats_accepted_language_hits' WHERE stats_accepted_language_id='$get_stats_accepted_language_id'") or die(mysqli_error());

			// Update monthly 
			$inp_stats_monthly_hits = $get_stats_monthly_hits+1;
			if($get_stats_user_agent_type == "desktop"){ 
				$inp_stats_monthly_hits_desktop   = $get_stats_monthly_hits_desktop+1;
			} 
			else{ 
				$inp_stats_monthly_hits_desktop   = $get_stats_monthly_hits_desktop;
			}
			if($get_stats_user_agent_type == "mobile"){	
				$inp_stats_monthly_hits_mobile = $get_stats_monthly_hits_mobile+1;
			}
			else{ 
				$inp_stats_monthly_hits_mobile = $get_stats_monthly_hits_mobile;
			}
			$result = mysqli_query($link, "UPDATE $t_stats_monthly SET stats_monthly_hits='$inp_stats_monthly_hits', stats_monthly_hits_desktop='$inp_stats_monthly_hits_desktop', 
						stats_monthly_hits_mobile='$inp_stats_monthly_hits_mobile' WHERE stats_monthly_id='$get_stats_monthly_id'") ;

		} // if($get_stats_human_visitor_id != ""){





		// Update record
		$query = "SELECT stats_human_online_record_id, stats_human_online_record_count FROM $t_stats_human_online_records WHERE stats_human_online_record_date='$inp_date'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_stats_human_online_record_id, $get_stats_human_online_record_count) = $row;

		if($get_stats_human_online_record_id == ""){
			mysqli_query($link, "INSERT INTO $t_stats_human_online_records 
			(stats_human_online_record_id, stats_human_online_record_date, stats_human_online_record_count) 
			VALUES
			(NULL, '$inp_date', '1')") or die(mysqli_error($link));

			$query = "SELECT stats_human_online_record_id, stats_human_online_record_count FROM $t_stats_human_online_records WHERE stats_human_online_record_date='$inp_date'";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_stats_human_online_record_id, $get_stats_human_online_record_count) = $row;

		}		

		// Count whatever is online now
		$five_minutes = $inp_unix_time+300;
		$query = "SELECT * FROM $t_stats_human_ipblock WHERE stats_human_visitor_timestamp_last_seen < $five_minutes";
		$result = mysqli_query($link, $query);
		$row_cnt = mysqli_num_rows($result);
		
		if($get_stats_human_online_record_count < $row_cnt){
			
			$result = mysqli_query($link, "UPDATE $t_stats_human_online_records SET stats_human_online_record_count='$row_cnt' WHERE stats_human_online_record_id='$get_stats_human_online_record_id'");

		}
	} // End Human


	// Search queries and Referer
	if(isset($_SERVER['HTTP_REFERER']) ){
		$inp_stats_referer_from_url  = $_SERVER['HTTP_REFERER'];
		$inp_stats_referer_from_url  = output_html($inp_stats_referer_from_url);
		$inp_stats_referer_from_url_mysql = quote_smart($link, $inp_stats_referer_from_url);
		if($inp_stats_referer_from_url != "" && $configSiteURLSav != ""){

			if (strpos($inp_stats_referer_from_url, $configSiteURLSav) !== false) {
			
			}
			else{

				// Does it exists?
				$query = "SELECT stats_referer_id, stats_referer_unique, stats_referer_hits FROM $t_stats_referers WHERE stats_referer_month='$inp_month' AND stats_referer_year='$inp_year' AND stats_referer_from_url=$inp_stats_referer_from_url_mysql AND stats_referer_to_url=$inp_page_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_stats_referer_id, $get_stats_referer_unique, $get_stats_referer_hits) = $row;
				if($get_stats_referer_id == ""){
					mysqli_query($link, "INSERT INTO $t_stats_referers
					(stats_referer_id, stats_referer_month, stats_referer_year, stats_referer_from_url, stats_referer_to_url, stats_referer_unique, stats_referer_hits) 
					VALUES
					(NULL, '$inp_month', '$inp_year', $inp_stats_referer_from_url_mysql, $inp_page_mysql, '1', '1')") or die(mysqli_error($link));

				}
				else{
					$inp_stats_referer_unique = $get_stats_referer_unique+1;
					$inp_stats_referer_hits = $get_stats_referer_hits+1;
					$result = mysqli_query($link, "UPDATE $t_stats_referers SET stats_referer_unique='$inp_stats_referer_unique', stats_referer_hits='$inp_stats_referer_hits' WHERE stats_referer_id='$get_stats_referer_id'");
				}
			}
		}
	}
	
	
	
} // user agent found
?>