<?php
/**
*
* File: _admin/_functions/registrer_stats_autoinsert_new_user_agent.php
* Version 2.0
* Date 10:35 20.10.2020
* Copyright (c) 2008-2020 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/



/*- Find me based on user ------------------------------------------------------------------- */
if($define_in_register_stats == "1"){
	// Visitor type
	$visitor_type = "";

	// A B C D E F G H I J K L M N O P Q R S T U V W X Y Z Æ Ø Å
	$robots = array(
		'Apache-HttpClient', 'archive.org_bot', 'AhrefsBot', 'AlphaBot', 'aboundex', 'altavista', 'appengine-google',
		'Baiduspider', 'browsershot', 'botje.com', 'bing', 'bingbot', 
		'CheckMarkNetwork', 'Cliqzbot', 'curl', 
		'Dataprovider.com', 'discobot', 'Dispatch', 'edisterbot', 'DuckDuckGo-Favicons-Bot', 
		'exabot', 'ExtLinksBot', 'evc-batch', 'facebook', 'dotbot', 
		'gigabot', 'G-i-g-a-b-o-t', 'Grammarly', 'googlebot-mobile', 'gigabot', 'gidbot', 'googlebot', 'mediapartners-google', 'google-site-verification', 'googlebot-image', 
		'Go-http-client', 'GuzzleHttp', 'Google-Youtube-Links', 
		'ia_archiver', 'ics', 
		'jyxobot',  'lycos', 
		'HTTrack', 'Hstpnetwork.com', 
		'linkdexbot', 
		'MJ12bot', 'mail.ru_bot', 'meanpathbo', 'mlbot', 'msnbot', 'MSIECrawler',
		 'openbot', 
		'Qwantify', 
		'proximic', 'PocketParser', 'python-requests', 'Python-urllib', 
		'SeznamBot', 'semrushbot', 'SEOkicks-Robot', 'SMTBot','slurp', 'scooter', 'SiteExplorer', 
		'startsite.com', 'synapse', 'Snapchat', 'Sogou web spider', 'spbot', 'Scrapy', 
		'teoma', 'openacoon', 'twitter', 'temnos', 
		'unikstart', 'Uptimebot',
		'vbseo', 
		'Yandexnot', 'yammybot', 'YandexMobileBot', 'YandexBot', 'yahoo', 
		'zgrab',
		'Wappalyzer', 'w3c_validator', 'windows-live', 'WhatsApp', 'WordPress');


	foreach($robots as $r){
 		if(stripos($inp_user_agent, $r) !== false ){

			// Visitor type
			$visitor_type = "bot";


			// URL
			$inp_stats_user_agent_url = "http://" . $r . ".com";
			$inp_stats_user_agent_url = output_html($inp_stats_user_agent_url);
			$inp_stats_user_agent_url_mysql = quote_smart($link, $inp_stats_user_agent_url);

			// Agent Name
			$inp_stats_user_agent_bot = ucfirst($r);
			$inp_stats_user_agent_bot = output_html($inp_stats_user_agent_bot);
			$inp_stats_user_agent_bot_mysql = quote_smart($link, $inp_stats_user_agent_bot);

			// Icon
			$inp_stats_user_agent_bot_icon = $r . ".png";
			$inp_stats_user_agent_bot_icon = output_html($inp_stats_user_agent_bot_icon);
			$inp_stats_user_agent_bot_icon_mysql = quote_smart($link, $inp_stats_user_agent_bot_icon);
			
			// Insert new bot
			mysqli_query($link, "INSERT INTO $t_stats_user_agents_index
			(stats_user_agent_id, stats_user_agent_string, stats_user_agent_type, stats_user_agent_browser, stats_user_agent_browser_version, 
			stats_user_agent_browser_icon, stats_user_agent_os, stats_user_agent_os_version, stats_user_agent_os_icon, stats_user_agent_bot, 
			stats_user_agent_bot_icon, stats_user_agent_bot_website, stats_user_agent_banned) 
			VALUES
			(NULL, $inp_user_agent_mysql, 'bot', '', '', 
			'', '', '', '', $inp_stats_user_agent_bot_mysql, 
			$inp_stats_user_agent_bot_icon_mysql, $inp_stats_user_agent_url_mysql, '0')
			") or die(mysqli_error($link));


			break;
		}
	}


	// Mobile
	if($visitor_type == ""){
		$mobile_os = array('Android', 'Blackberry', 'iPhone', 'iPad', 'Nokia', 'Samsung');
		
		foreach($mobile_os as $m_os){
 			if(stripos($inp_user_agent, $m_os) !== false ){

				// Visitor type
				$visitor_type = "mobile";


				// Browser checkup
				// A B C D E F G H I J K L M N O P Q R S T U V W X Y Z
				$mobile_browsers = array('AppleWebKit', 'Dalvik', 'Mobile Safari', 'Minefield', 'Safari', 'Chrome', 'Firefox', 'Opera', 'SamsungBrowser', 'UCBrowser');
				$inp_stats_user_agent_browser = "";
				foreach($mobile_browsers as $m_b){
 					if(stripos($inp_user_agent, $m_b) !== false ){
						$inp_stats_user_agent_browser = "$m_b";
					}
				}

				$inp_stats_user_agent_browser_icon = clean($inp_stats_user_agent_browser);
				$inp_stats_user_agent_browser_icon = $inp_stats_user_agent_browser_icon . ".png";
				$inp_stats_user_agent_browser_icon = output_html($inp_stats_user_agent_browser_icon);
				$inp_stats_user_agent_browser_icon_mysql = quote_smart($link, $inp_stats_user_agent_browser_icon);


				// Browser
				$inp_stats_user_agent_browser = output_html(ucfirst($inp_stats_user_agent_browser));
				$inp_stats_user_agent_browser_mysql = quote_smart($link, $inp_stats_user_agent_browser);


				// OS 
				$inp_stats_user_agent_os = ucfirst($m_os);
				$inp_stats_user_agent_os = output_html($inp_stats_user_agent_os);
				$inp_stats_user_agent_os_mysql = quote_smart($link, $inp_stats_user_agent_os);

				// OS Icon
				$inp_stats_user_agent_os_icon = clean($m_os);
				$inp_stats_user_agent_os_icon =  $inp_stats_user_agent_os_icon. ".png";
				$inp_stats_user_agent_os_icon = output_html($inp_stats_user_agent_os_icon);
				$inp_stats_user_agent_os_icon_mysql = quote_smart($link, $inp_stats_user_agent_os_icon);
			
				// Insert new mobile
				mysqli_query($link, "INSERT INTO $t_stats_user_agents_index
				(stats_user_agent_id, stats_user_agent_string, stats_user_agent_type, stats_user_agent_browser, stats_user_agent_browser_version, 
				stats_user_agent_browser_icon, stats_user_agent_os, stats_user_agent_os_version, stats_user_agent_os_icon, stats_user_agent_bot, 
				stats_user_agent_bot_icon, stats_user_agent_bot_website, stats_user_agent_banned) 
				VALUES
				(NULL, $inp_user_agent_mysql, 'mobile', $inp_stats_user_agent_browser_mysql, 0,
				'', $inp_stats_user_agent_os_mysql, 0, $inp_stats_user_agent_browser_icon_mysql, '',
				'', '', '0')
				") or die(mysqli_error($link));


				break;
			}
		}
	}

	


	// Desktop
	if($visitor_type == ""){


		// A B C D E F G H I J K L M N O P Q R S T U V W X Y Z Æ Ø Å

		$desktop_os = array('Freebsd', 'Fedora', 'Linux x86_64', 'Linux i686', 'linux-gnu', 'Mac OS X', 'Windows', 'Ubuntu', 'X11');
		foreach($desktop_os as $os){
 			if(stripos($inp_user_agent, $os) !== false ){
				
				// Visitor type
				$visitor_type = "desktop";

				// OS
				$inp_stats_user_agent_os = ucfirst($os);
				$inp_stats_user_agent_os = output_html($inp_stats_user_agent_os);
				$inp_stats_user_agent_os_mysql = quote_smart($link, $inp_stats_user_agent_os);

				// OS Icon
				$inp_stats_user_agent_os_icon = clean($os);
				$inp_stats_user_agent_os_icon = $inp_stats_user_agent_os_icon . ".png";
				$inp_stats_user_agent_os_icon = output_html($inp_stats_user_agent_os_icon);
				$inp_stats_user_agent_os_icon_mysql = quote_smart($link, $inp_stats_user_agent_os_icon);


				// Browser checkup (desktop)
				$desktop_browsers = array('AppleWebKit', 'Safari', 'Chrome', 'Edge', 'Firefox', 'Galeon', 'Minefield', 'MSIE', 'Opera', 'SkypeUriPreview', 'Trident', 
							  'Thunderbird', 'Qt', 'Wget');
				$inp_stats_user_agent_browser = "";
				foreach($desktop_browsers as $d_b){
 					if(stripos($inp_user_agent, $d_b) !== false ){
						$inp_stats_user_agent_browser = "$d_b";
					}
				}

				// Browser icon
				$inp_stats_user_agent_browser_icon = clean($inp_stats_user_agent_browser);
				$inp_stats_user_agent_browser_icon = $inp_stats_user_agent_browser_icon . ".png";
				$inp_stats_user_agent_browser_icon = output_html($inp_stats_user_agent_browser_icon);
				$inp_stats_user_agent_browser_icon_mysql = quote_smart($link, $inp_stats_user_agent_browser_icon);



				// Browser
				$inp_stats_user_agent_browser = output_html(ucfirst($inp_stats_user_agent_browser));
				$inp_stats_user_agent_browser_mysql = quote_smart($link, $inp_stats_user_agent_browser);



				// Insert new desktop
				mysqli_query($link, "INSERT INTO $t_stats_user_agents_index
				(stats_user_agent_id, stats_user_agent_string, stats_user_agent_type, stats_user_agent_browser, stats_user_agent_browser_version, 
				stats_user_agent_browser_icon, stats_user_agent_os, stats_user_agent_os_version, stats_user_agent_os_icon, stats_user_agent_bot, 
				stats_user_agent_bot_icon, stats_user_agent_bot_website, stats_user_agent_banned) 
				VALUES
				(NULL, $inp_user_agent_mysql, 'desktop', $inp_stats_user_agent_browser_mysql, 0, 
				$inp_stats_user_agent_browser_icon_mysql, $inp_stats_user_agent_os_mysql, 0, $inp_stats_user_agent_os_icon_mysql, '', 
				'', '', '0')
				") or die(mysqli_error($link));




				break;
			}
		}

	}

	// Unknown - Is it a bot?
	if($visitor_type == ""){

		// Search for "Crawler", "Bot"
		$crawlers = array(
			'bot', 'crawler');

		foreach($crawlers as $c){
 			if(stripos($inp_user_agent, $c) !== false ){



				// Agent name
				$array = explode(" ", $c);
				$array_size = sizeof($array);
				for($x=0;$x<$array_size;$x++){
					if(stripos($array[$x], $c) !== false ){

						// Visitor type
						$visitor_type = "bot";

						// URL
						$inp_stats_user_agent_url = "http://" . $inp_user_agent . ".com";
						$inp_stats_user_agent_url = output_html($inp_stats_user_agent_url);
						$inp_stats_user_agent_url_mysql = quote_smart($link, $inp_stats_user_agent_url);

						// Agent Name
						$inp_stats_user_agent_bot = ucfirst($inp_user_agent);
						$inp_stats_user_agent_bot = output_html($inp_stats_user_agent_bot);
						$inp_stats_user_agent_bot_mysql = quote_smart($link, $inp_stats_user_agent_bot);

						// Icon
						$inp_stats_user_agent_bot_icon = $array[$x] . ".png";
						$inp_stats_user_agent_bot_icon = output_html($inp_stats_user_agent_bot_icon);
						$inp_stats_user_agent_bot_icon_mysql = quote_smart($link, $inp_stats_user_agent_bot_icon);
			
						// Insert new bot
						mysqli_query($link, "INSERT INTO $t_stats_user_agents_index
						(stats_user_agent_id, stats_user_agent_string, stats_user_agent_type, stats_user_agent_browser, stats_user_agent_browser_version, 
						stats_user_agent_browser_icon, stats_user_agent_os, stats_user_agent_os_version, stats_user_agent_os_icon, stats_user_agent_bot, 
						stats_user_agent_bot_icon, stats_user_agent_bot_website, stats_user_agent_banned) 
						VALUES
						(NULL, $inp_user_agent_mysql, 'bot', '', 0, 
						'', '', 0, '' $inp_stats_user_agent_bot_mysql, 
						$inp_stats_user_agent_bot_icon_mysql, $inp_stats_user_agent_url_mysql, '0')
						") or die(mysqli_error($link));


						break;
					}
				}
			}
		}
	}

	// Unknown
	if($visitor_type == ""){
		// New visitor
		mysqli_query($link, "INSERT INTO $t_stats_user_agents_index
		(stats_user_agent_id, stats_user_agent_string, stats_user_agent_type, stats_user_agent_banned) 
		VALUES
		(NULL, $inp_user_agent_mysql, 'unknown', '0')
		") or die(mysqli_error($link));


		// Who is moderator of the week?
		$week = date("W");
		$year = date("Y");

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





		// Mail approve URLs
		$pageURL = 'http';
		$pageURL .= "://";

		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} 
		else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}

		$control_panel = "http://" . $_SERVER["SERVER_NAME"] . "/_admin";

		$host = $_SERVER['HTTP_HOST'];
		$from = "$configFromEmailSav";
		$subject = "New user agent at $host: $inp_user_agent";

		$message = "<html>\n";
		$message = $message. "<head>\n";
		$message = $message. "  <title>$subject</title>\n";
		$message = $message. " </head>\n";
		$message = $message. "<body>\n";

		$message = $message . "<p>Hi $get_moderator_user_name,</p>\n\n";
		$message = $message . "<p><b>Summary:</b><br />There is a new user agent at at $host. Please update database at the control panel dashboard.</p>\n\n";
		$message = $message . "<p style=\"margin-bottom:0;padding-bottom:0;\"><b>User agent:</b><br />\n<a href=\"https://www.google.no/search?q=$inp_user_agent\">$inp_user_agent</a></p>\n\n";
		$message = $message . "<p><b>Actions:</b><br />\n";
		$message = $message . "Site: <a href=\"$configSiteURLSav\">$configSiteURLSav</a><br />";
		$message = $message . "Admin: <a href=\"$configControlPanelURLSav\">$configControlPanelURLSav</a></p>";
		$message = $message . "<p>\n\n--<br />\nBest regards<br />\n$host</p>";
		$message = $message. "</body>\n";
		$message = $message. "</html>\n";


		$encoding = "utf-8";

		// Preferences for Subject field
		$subject_preferences = array(
					       "input-charset" => $encoding,
					       "output-charset" => $encoding,
					       "line-length" => 76,
					       "line-break-chars" => "\r\n"
		);
		$header = "Content-type: text/html; charset=".$encoding." \r\n";
		$header .= "From: ".$host." <".$from."> \r\n";
		$header .= "MIME-Version: 1.0 \r\n";
		$header .= "Content-Transfer-Encoding: 8bit \r\n";
		$header .= "Date: ".date("r (T)")." \r\n";
		$header .= iconv_mime_encode("Subject", $subject, $subject_preferences);

		mail($get_moderator_user_email, $subject, $message, $header);

	}
}
?>