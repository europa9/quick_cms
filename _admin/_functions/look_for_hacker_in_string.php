<?php
/**
*
* File: _admin/_functions/look_for_hacker_in_string.php
* Version: 2
* Date: 14:29 05.05.2021
* Copyright (c) 2021 Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/* input = $search_query
* if a hacker is found in search_string then a email is sendt to moderator
*/


// Hacker count file
$my_ip_sum = md5("$my_ip");
$count_file = "../_cache/look_for_hacker_$my_ip_sum.txt";

// Variables
$is_hacker = 0;
$is_hacker_because = "";

// SQL
$sql_hacks = array(
		'"', '")', '";', '`',
		'`)',
		'`;',
		"'", 
		"%'27", 
		'[t]', 
		"%'", 
		'"', 
		'/', 
		'//', 
		';',
		"'='", 
		"'=0--+", 
		"AND",
		"or",
		"OR",
		"LIKE", 
		"-false", 
		"-true", 
		"ORDER BY",
		"WHERE", 
		"UNION"
		);

	
foreach($sql_hacks as $r){
	$position = stripos($search_query, $r);
	if($position !== false ){
		$is_hacker = 1;
		$is_hacker_because = "Searched for $r";
	}
}

if($is_hacker == "1"){
	// Open hacker count file.
	if(!(file_exists("$count_file"))){
		$myfile = fopen("$count_file", "w") or die("Unable to open file!");
		fwrite($myfile, "0");
		fclose($myfile);
	}
	else{
		// Read counter
		$fh = fopen("$count_file", "r");
		$counter = fread($fh, filesize("$count_file"));
		fclose($fh);

		$inp_counter = $counter+1;

		// Write new number
		$myfile = fopen("$count_file", "w") or die("Unable to open file!");
		fwrite($myfile, $inp_counter);
		fclose($myfile);

		// If counter is over 3 then send email
		if($counter == 3){
			// Email
			include("$root/_admin/_data/logo.php");

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
				

			// Dates
			$datedatime_saying = date("j M Y H:i:s");
			// Sum
			$my_ip_sum = md5("$my_ip");
			$my_user_agent_sum = md5("$my_user_agent");

			$subject = "Hacker attempt at $configWebsiteTitleSav the $datedatime_saying";

			$message = "<html>\n";
			$message = $message. "<head>\n";
			$message = $message. "  <title>$subject</title>\n";
			$message = $message. " </head>\n";
			$message = $message. "<body>\n";

			$message = $message . "<p><a href=\"$configSiteURLSav\"><img src=\"$configSiteURLSav/$logoPathSav/$logoFileSav\" alt=\"($configWebsiteTitleSav logo)\" /></a></p>\n\n";
			
			$message = $message . "<p>Hello $get_moderator_user_name,<br />\n";
			$message = $message . "You are the moderator of the week at $configWebsiteTitleSav and because of this you receive this email.\n";
			$message = $message . "</p>";
			$message = $message . "<p>There was a hacking attempt at $configWebsiteTitleSav.\n";
			$message = $message . "The user has searched for hacking words for more than four times.\n";
			$message = $message . "You should take action to make sure that your site stays safe.\n";
			$message = $message . "No more emails will be sendt about this IP.\n";
			$message = $message . "To find more information look at the \n";
			$message = $message . "<a href=\"$configControlPanelURLSav/index.php?open=dashboard&page=statistics_year&stats_year=$year&editor_language=$l&amp;ip_sum=$my_ip_sum#trackers\">trackers</a>.";
			$message = $message . "</p>";


			$message = $message . "<table>\n\n";
			$message = $message . " <tr>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "		<span>IP:</span>\n";
			$message = $message . "  </td>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "		<span>$my_ip</span>\n";
			$message = $message . "  </td>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "		<span>[<a href=\"$configControlPanelURLSav/index.php?open=dashboard&amp;page=banned&amp;action=add_new_banned_ip\">Ban</a>]</span>\n";
			$message = $message . "  </td>\n";
			$message = $message . " </tr>\n";
			$message = $message . " <tr>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "		<span>Hostname:</span>\n";
			$message = $message . "  </td>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "		<span>$my_hostname</span>\n";
			$message = $message . "  </td>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "		<span>[<a href=\"$configControlPanelURLSav/index.php?open=dashboard&amp;page=banned&amp;action=add_new_banned_hostname\">Ban</a>]</span>\n";
			$message = $message . "  </td>\n";
			$message = $message . " </tr>\n";

			$message = $message . " <tr>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "		<span>User agent:</span>\n";
			$message = $message . "  </td>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "		<span>$my_user_agent</span>\n";
			$message = $message . "  </td>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "		<span>[<a href=\"$configControlPanelURLSav/index.php?open=dashboard&amp;page=user_agents&amp;mode=ban_hostname&amp;user_agent_sum=$my_user_agent_sum\">Ban</a>]</span>\n";
			$message = $message . "  </td>\n";
			$message = $message . " </tr>\n";

			$message = $message . " <tr>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "		<span>Accpeted language:</span>\n";
			$message = $message . "  </td>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "		<span>$inp_accpeted_language</span>\n";
			$message = $message . "  </td>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "  </td>\n";
			$message = $message . " </tr>\n";

			$message = $message . " <tr>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "		<span>Language:</span>\n";
			$message = $message . "  </td>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "		<span>$l</span>\n";
			$message = $message . "  </td>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "  </td>\n";
			$message = $message . " </tr>\n";

			$message = $message . " <tr>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "		<span>Country:</span>\n";
			$message = $message . "  </td>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "		<span>$get_geoname_country_name</span>\n";
			$message = $message . "  </td>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "  </td>\n";
			$message = $message . " </tr>\n";

			$message = $message . " <tr>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "		<span>Datetime:</span>\n";
			$message = $message . "  </td>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "		<span>$datedatime_saying</span>\n";
			$message = $message . "  </td>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "  </td>\n";
			$message = $message . " </tr>\n";

			$message = $message . " <tr>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "		<span>URL:</span>\n";
			$message = $message . "  </td>\n";
			$message = $message . "  <td style=\"padding: 4px 4px 4px 0px;\">\n";
			$message = $message . "		<span>$page_url</span>\n";
			$message = $message . "  </td>\n";
			$message = $message . " </tr>\n";
			$message = $message . "</table>\n\n";

			$message = $message . "<p>\n\n--<br />\nBest regards<br />\n$configWebsiteTitleSav<br />\n<a href=\"$configSiteURLSav\">$configSiteURLSav</a></p>";
			$message = $message. "</body>\n";
			$message = $message. "</html>\n";

			// Preferences for Subject field
			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-type: text/html; charset=utf-8';
			$headers[] = "From: $configFromNameSav <" . $configFromEmailSav . ">";
			if($configMailSendActiveSav == "1"){
				mail($get_moderator_user_email, $subject, $message, implode("\r\n", $headers));
			}
		} // user may be hacker
	}
} // user may be hacker


?>