<?php
/**
*
* File: _admin/_inc/media/statistics.php
* Version 2.0.0
* Date 18:16 28.04.2019
* Copyright (c) 2008-2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}


/*- Tables ---------------------------------------------------------------------------------- */
$t_stats_accepted_languages_per_month	= $mysqlPrefixSav . "stats_accepted_languages_per_month";
$t_stats_accepted_languages_per_year	= $mysqlPrefixSav . "stats_accepted_languages_per_year";

$t_stats_browsers_per_month	= $mysqlPrefixSav . "stats_browsers_per_month";
$t_stats_browsers_per_year	= $mysqlPrefixSav . "stats_browsers_per_year";

$t_stats_comments_per_month 	= $mysqlPrefixSav . "stats_comments_per_month";
$t_stats_comments_per_year 	= $mysqlPrefixSav . "stats_comments_per_year";

$t_stats_countries_per_year  = $mysqlPrefixSav . "stats_visits_per_year";
$t_stats_countries_per_month = $mysqlPrefixSav . "stats_visits_per_month";

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



/*- Translation ----------------------------------------------------------------------- */
include("_translations/admin/$l/dashboard/t_default.php");

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['week'])) {
	$week = $_GET['week'];
	$week = strip_tags(stripslashes($week));
}
else{
	$week = date("W");
}
$week_mysql = quote_smart($link, $week);

if(isset($_GET['month'])) {
	$month = $_GET['month'];
	$month = strip_tags(stripslashes($month));
}
else{
	$month = date("m");
}
$month_mysql = quote_smart($link, $month);

if(isset($_GET['year'])) {
	$year = $_GET['year'];
	$year = strip_tags(stripslashes($year));
}
else{
	$year = date("Y");
}
$year_mysql = quote_smart($link, $year);

if($action == ""){
	echo"
	<h1>Statistics</h1>

	<!-- Menu -->
		<div class=\"tabs\">
			<ul>
				<li><a href=\"index.php?open=dashboard&amp;page=statistics&amp;l=$l\" class=\"active\">Statistics</a></li>
				<li><a href=\"index.php?open=dashboard&amp;page=statistics&amp;action=ipv4_to_country&amp;l=$l\">IPv4 to country</a></li>
				<li><a href=\"index.php?open=dashboard&amp;page=statistics&amp;action=ipv6_to_country&amp;l=$l\">IPv6 to country</a></li>
			</ul>
		</div>
		<div class=\"clear\" style=\"height: 10px;\"></div>
	<!-- Menu -->


	<!-- Unknown agents -->
		";
		// Unknown type
		$unknown_type = 0;
		$query = "SELECT * FROM $t_stats_user_agents_index WHERE stats_user_agent_type=''";
		if ($result = mysqli_query($link, "$query")) {
			$unknown_type = mysqli_num_rows($result);
			mysqli_free_result($result);
		}

		// Unknown browsers
		$unknown_browser = 0;
		$query = "SELECT * FROM $t_stats_user_agents_index WHERE stats_user_agent_browser='' AND stats_user_agent_bot=''";
		if ($result = mysqli_query($link, "$query")) {
			$unknown_browser = mysqli_num_rows($result);
			mysqli_free_result($result);
		}

		// Unknown os
		$unknown_os = 0;
		$query = "SELECT * FROM $t_stats_user_agents_index WHERE stats_user_agent_os='' AND stats_user_agent_bot=''";
		if ($result = mysqli_query($link, "$query")) {
			$unknown_os = mysqli_num_rows($result);
			mysqli_free_result($result);
		}

		// Unknown flag
		$unknown_flag = 0;
		$query = "SELECT * FROM $t_stats_user_agents_index WHERE stats_user_agent_type='unknown'";
		if ($result = mysqli_query($link, "$query")) {
			$unknown_flag = mysqli_num_rows($result);
			mysqli_free_result($result);
		}



		$unknown_total = $unknown_type+$unknown_browser+$unknown_os+$unknown_flag;
		if($unknown_total != 0){
			echo"
			<div class=\"warning\"><p>$l_unknown_agents_has $unknown_total $l_new_unknown_user_agents:
			$unknown_type $l_unknown_types,
			$unknown_browser $l_unknown_browsers,
			$unknown_os $l_unknown_os,
			$l_and $unknown_flag $l_marked_with_unknown_flag.
			
			</p><p><a href=\"index.php?open=$open&amp;page=unknown_agents&amp;action=fix_agents&amp;editor_language=$editor_language\" class=\"btn\">$l_fix_problems</a></p></div>
			";
		}


		echo"
	<!-- //Unknown agents -->


	<!-- Periode selection -->
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span><b>Year</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>Unique</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>Unique desktop</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>Unique mobile</b></span>
		   </td>
		   <th scope=\"col\">
			<span><b>Unique bots</b></span>
		   </td>
		  </tr>
		 </thead>";

		$query = "SELECT stats_visit_per_year_id, stats_visit_per_year_year, stats_visit_per_year_human_unique, stats_visit_per_year_human_unique_diff_from_last_year, stats_visit_per_year_human_average_duration, stats_visit_per_year_human_new_visitor_unique, stats_visit_per_year_human_returning_visitor_unique, stats_visit_per_year_unique_desktop, stats_visit_per_year_unique_mobile, stats_visit_per_year_unique_bots, stats_visit_per_year_hits_total, stats_visit_per_year_hits_human, stats_visit_per_year_hits_desktop, stats_visit_per_year_hits_mobile, stats_visit_per_year_hits_bots FROM $t_stats_visists_per_year ORDER BY stats_visit_per_year_id DESC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_stats_visit_per_year_id, $get_stats_visit_per_year_year, $get_stats_visit_per_year_human_unique, $get_stats_visit_per_year_human_unique_diff_from_last_year, $get_stats_visit_per_year_human_average_duration, $get_stats_visit_per_year_human_new_visitor_unique, $get_stats_visit_per_year_human_returning_visitor_unique, $get_stats_visit_per_year_unique_desktop, $get_stats_visit_per_year_unique_mobile, $get_stats_visit_per_year_unique_bots, $get_stats_visit_per_year_hits_total, $get_stats_visit_per_year_hits_human, $get_stats_visit_per_year_hits_desktop, $get_stats_visit_per_year_hits_mobile, $get_stats_visit_per_year_hits_bots) = $row;
			

			// Style
			if(isset($style) && $style == ""){
				$style = "odd";
			}
			else{
				$style = "";
			}

		
			echo"
			 <tr>
			  <td class=\"$style\">
				<a id=\"#year$get_stats_visit_per_year_year\"></a>
				<span>
				<a href=\"index.php?open=$open&amp;page=statistics_year&amp;stats_year=$get_stats_visit_per_year_year&amp;&amp;l=$l&amp;editor_language=$editor_language\">$get_stats_visit_per_year_year</a>
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				$get_stats_visit_per_year_human_unique
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				$get_stats_visit_per_year_unique_desktop
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				$get_stats_visit_per_year_unique_mobile
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				$get_stats_visit_per_year_unique_bots
				</span>
			  </td>
			 </tr>";


		}
		echo"
			</table>
		  </td>
		 </tr>
		</table>
	<!-- //Periode selection -->

	";
}
elseif($action == "online_now"){
	echo"
	<h1>Online now</h1>

	<!-- Menu -->
		<div class=\"tabs\">
			<ul>
				<li><a href=\"index.php?open=dashboard&amp;page=statistics&amp;l=$l\">Statistics</a></li>
				<li><a href=\"index.php?open=dashboard&amp;page=statistics&amp;action=online_now&amp;l=$l\" class=\"active\">Online now</a></li>
				<li><a href=\"index.php?open=dashboard&amp;page=statistics&amp;action=ipv4_to_country&amp;l=$l\">IPv4 to country</a></li>
				<li><a href=\"index.php?open=dashboard&amp;page=statistics&amp;action=ipv6_to_country&amp;l=$l\">IPv6 to country</a></li>
			</ul>
		</div>
		<div class=\"clear\" style=\"height: 10px;\"></div>
	<!-- Menu -->

				<!-- Online now -->


					<h2 class=\"online_now_headline\">$l_right_now</h2>

					";

					// Get record
					if(!(isset($date)) OR $date == ""){
						$date = date("Y-m-d");
					}
					$unix_time = time();
					$unix_time_minus_ten = 60*5;
					$unix_time = $unix_time - $unix_time_minus_ten;

					$query = "SELECT stats_human_online_record_id, stats_human_online_record_count FROM $t_stats_human_online_records WHERE stats_human_online_record_date='$date'";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_stats_human_online_record_id, $get_stats_human_online_record_count) = $row;
			
					// Online now
					$query = "SELECT * FROM $t_stats_human_ipblock WHERE stats_human_visitor_timestamp_last_seen > $unix_time";
					$result = mysqli_query($link, $query);
					$online_now = mysqli_num_rows($result);

					echo"
					<p class=\"online_now_number\">$online_now</p>

					<p class=\"online_now_sub_text\">$l_active_users_on_site</p>
				<!-- //Online now -->

	<!-- Online now -->
		<h2>$l_online_now</h2>
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span>$l_page</span>
		   </th>
		   <th scope=\"col\">
			<span>$l_os</span>
		   </th>
		   <th scope=\"col\">
			<span>$l_browser</span>
		   </th>
		   <th scope=\"col\">
			<span>$l_language</span>
		   </th>
		   <th scope=\"col\">
			<span>$l_type</span>
		   </th>
		   <th scope=\"col\">
			<span>$l_hits</span>
		   </th>
		   <th scope=\"col\">
			<span>$l_ip</span>
		   </th>
		  </tr>
		 </thead>
		 <tbody>
		";
		

		$query = "SELECT stats_human_visitor_id, stats_human_visitor_date, stats_human_visitor_time, stats_human_visitor_month, stats_human_visitor_year, stats_human_visitor_timestamp_first_seen, stats_human_visitor_timestamp_last_seen, stats_human_visitor_hits, stats_human_visitor_ip, stats_human_visitor_browser, stats_human_visitor_os, stats_human_visitor_language, stats_human_visitor_type, stats_human_visitor_page FROM $t_stats_human_ipblock WHERE stats_human_visitor_timestamp_last_seen > '$unix_time'";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_stats_human_visitor_id, $get_stats_human_visitor_date, $get_stats_human_visitor_time, $get_stats_human_visitor_month, $get_stats_human_visitor_year, $get_stats_human_visitor_timestamp_first_seen, $get_stats_human_visitor_timestamp_last_seen, $get_stats_human_visitor_hits, $get_stats_human_visitor_ip, $get_stats_human_visitor_browser, $get_stats_human_visitor_os, $get_stats_human_visitor_language, $get_stats_human_visitor_type, $get_stats_human_visitor_page) = $row;

			if(isset($style) && $style == "odd"){
				$style = "";
			}
			else{
				$style = "odd";
			}

			$diff = $get_stats_human_visitor_timestamp_last_seen-$unix_time;

			

			echo"
			 <tr>
			  <td class=\"$style\">
				<span><a href=\"../..$get_stats_human_visitor_page\">$get_stats_human_visitor_page</a></span>
			  </td>
			  <td class=\"$style\">
				<span>$get_stats_human_visitor_browser</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_stats_human_visitor_os</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_stats_human_visitor_language</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_stats_human_visitor_type</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_stats_human_visitor_hits</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_stats_human_visitor_ip</span>
			  </td>
			 </tr>
			";
		}
		echo"
		 </tbody>
		</table>
	<!-- //Online now -->

	";
} // online now
elseif($action == "ipv4_to_country"){
	echo"
	<h1>IPv4 to country</h1>
	<!-- Menu -->
		<div class=\"tabs\">
			<ul>
				<li><a href=\"index.php?open=dashboard&amp;page=statistics&amp;l=$l\">Statistics</a></li>
				<li><a href=\"index.php?open=dashboard&amp;page=statistics&amp;action=online_now&amp;l=$l\">Online now</a></li>
				<li><a href=\"index.php?open=dashboard&amp;page=statistics&amp;action=ipv4_to_country&amp;l=$l\" class=\"active\">IPv4 to country</a></li>
				<li><a href=\"index.php?open=dashboard&amp;page=statistics&amp;action=ipv6_to_country&amp;l=$l\">IPv6 to country</a></li>
			</ul>
		</div>
		<div class=\"clear\" style=\"height: 10px;\"></div>
	<!-- Menu -->

	<!-- Example -->
		<h2>Example</h2>
		";
		if(isset($_GET['inp_ip'])) {
			$inp_ip = $_GET['inp_ip'];
			$inp_ip = strip_tags(stripslashes($inp_ip));
		}
		else{
			$inp_ip = $_SERVER['REMOTE_ADDR'];
			if($inp_ip == "::1"){
				$inp_ip = "193.214.73.246";
			}
		}
		echo"
		<!-- Form -->
			<form method=\"get\" action=\"index.php?open=dashboard&amp;page=statistics&amp;action=ipv4_to_country&amp;l=$l\" enctype=\"multipart/form-data\">
			<p>
			<input type=\"hidden\" name=\"open\" value=\"$open\" />
			<input type=\"hidden\" name=\"page\" value=\"$page\" />
			<input type=\"hidden\" name=\"action\" value=\"$action\" />
			<input type=\"hidden\" name=\"l\" value=\"$l\" />
			<b>IP:</b> <input type=\"text\" name=\"inp_ip\" value=\"$inp_ip\" size=\"25\" />
			<input type=\"submit\" value=\"Search\" class=\"btn_default\" />
			</p>
			</form>
		<!-- //Form -->
		";

		$inp_ip = output_html($inp_ip);
		$ip_array = explode(".", $inp_ip);
		$ip_a = $ip_array[0];
		$ip_a_mysql = quote_smart($link, $ip_a);

		$ip_b = $ip_array[1];
		$ip_b_mysql = quote_smart($link, $ip_b);

		$ip_c = $ip_array[2];
		$ip_c_mysql = quote_smart($link, $ip_c);

		$ip_d = $ip_array[3];
		$ip_d_mysql = quote_smart($link, $ip_d);

		$ip_number = $ip_a . $ip_b . $ip_c . $ip_d;
		$ip_number = output_html($ip_number);
		$ip_number_mysql = quote_smart($link, $ip_number);
		
		$query = "SELECT $t_stats_ip_to_country_ipv4.ip_id, $t_stats_ip_to_country_geonames.geoname_country_name FROM $t_stats_ip_to_country_ipv4 JOIN $t_stats_ip_to_country_geonames ON $t_stats_ip_to_country_ipv4.ip_geoname_id=$t_stats_ip_to_country_geonames.geoname_id";
		$query = $query . " WHERE ip_registered_country_geoname_id != ''";
		$query = $query . " AND $t_stats_ip_to_country_ipv4.ip_from_a<=$ip_a_mysql AND $t_stats_ip_to_country_ipv4.ip_to_a>=$ip_a_mysql";
		$query = $query . " AND $t_stats_ip_to_country_ipv4.ip_from_b<=$ip_b_mysql AND $t_stats_ip_to_country_ipv4.ip_to_b>=$ip_b_mysql";
		$query = $query . " AND $t_stats_ip_to_country_ipv4.ip_from_c<=$ip_c_mysql AND $t_stats_ip_to_country_ipv4.ip_to_c>=$ip_c_mysql";
		$query = $query . " AND $t_stats_ip_to_country_ipv4.ip_from_d<=$ip_d_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_ip_id, $get_geoname_country_name) = $row;

		echo"
		<p>
		Query: $query <br />
		IP ID: $get_ip_id<br />
		Country name: $get_geoname_country_name
		</p>

	<!-- //Example -->

	<!-- Generate-->
		<h2>Generate</h2>
		<p>
		<a href=\"index.php?open=dashboard&amp;page=statistics_ipv4_generate_insert_script&amp;editor_language=$editor_language&amp;l=$l\">Generate IPv4 insert script</a>
		</p>
	<!-- //Generate -->


	<!-- ipv4 -->
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span>Network</span>
		   </th>
		   <th scope=\"col\">
			<span>Start</span>
		   </th>
		   <th scope=\"col\">
			<span>Stop</span>
		   </th>
		   <th scope=\"col\">
			<span>Geo</span>
		   </th>
		  </tr>
		 </thead>
		 <tbody>
		";
		

		$query = "SELECT ip_id, ip_network, ip_from, ip_from_a, ip_from_b, ip_from_c, ip_from_d, ip_from_numeric, ip_to, ip_to_a, ip_to_b, ip_to_c, ip_to_d, ip_to_numeric, ip_geoname_id, ip_registered_country_geoname_id, ip_represented_country_geoname_id, ip_is_anonymous_proxy, ip_is_satellite_provider FROM $t_stats_ip_to_country_ipv4 LIMIT 0,500";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_ip_id, $get_ip_network, $get_ip_from, $get_ip_from_a, $get_ip_from_b, $get_ip_from_c, $get_ip_from_d, $get_ip_from_numeric, $get_ip_to, $get_ip_to_a, $get_ip_to_b, $get_ip_to_c, $get_ip_to_d, $get_ip_to_numeric, $get_ip_geoname_id, $get_ip_registered_country_geoname_id, $get_ip_represented_country_geoname_id, $get_ip_is_anonymous_proxy, $get_ip_is_satellite_provider) = $row;

			if(isset($style) && $style == "odd"){
				$style = "";
			}
			else{
				$style = "odd";
			}

			// Country
			$query_country = "SELECT geoname_row, geoname_country_name FROM $t_stats_ip_to_country_geonames WHERE geoname_id='$get_ip_geoname_id'";
			$result_country = mysqli_query($link, $query_country);
			$row_country = mysqli_fetch_row($result_country);
			list($get_geoname_row, $get_geoname_country_name) = $row_country;


			echo"
			 <tr>
			  <td class=\"$style\">
				<span>$get_ip_network</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_ip_from</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_ip_to</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_geoname_country_name</span>
			  </td>
			 </tr>
			";
		}
		echo"
		 </tbody>
		</table>
	<!-- //IPv4 -->
	";
} // ipv4_to_country
elseif($action == "ipv6_to_country"){
	echo"
	<h1>IPv6 to country</h1>
	<!-- Menu -->
		<div class=\"tabs\">
			<ul>
				<li><a href=\"index.php?open=dashboard&amp;page=statistics&amp;l=$l\">Statistics</a></li>
				<li><a href=\"index.php?open=dashboard&amp;page=statistics&amp;action=online_now&amp;l=$l\">Online now</a></li>
				<li><a href=\"index.php?open=dashboard&amp;page=statistics&amp;action=ipv4_to_country&amp;l=$l\">IPv4 to country</a></li>
				<li><a href=\"index.php?open=dashboard&amp;page=statistics&amp;action=ipv6_to_country&amp;l=$l\" class=\"active\">IPv6 to country</a></li>
			</ul>
		</div>
		<div class=\"clear\" style=\"height: 10px;\"></div>
	<!-- Menu -->

	<!-- Example ipv6 -->
		";
		if(isset($_GET['inp_ip'])) {
			$inp_ip = $_GET['inp_ip'];
			$inp_ip = strip_tags(stripslashes($inp_ip));
		}
		else{
			$inp_ip = $_SERVER['REMOTE_ADDR'];
			if($inp_ip == "::1"){
				$inp_ip = "2605:e000:151e:c4d7:9564:867f:79d7:bceb";
			}
		}
		echo"
		<!-- Form -->
			<form method=\"get\" action=\"index.php?open=dashboard&amp;page=statistics&amp;action=ipv6_to_country&amp;l=$l\" enctype=\"multipart/form-data\">
			<p>
			<input type=\"hidden\" name=\"open\" value=\"$open\" />
			<input type=\"hidden\" name=\"page\" value=\"$page\" />
			<input type=\"hidden\" name=\"action\" value=\"$action\" />
			<input type=\"hidden\" name=\"l\" value=\"$l\" />
			<b>IP:</b> <input type=\"text\" name=\"inp_ip\" value=\"$inp_ip\" size=\"25\" />
			<input type=\"submit\" value=\"Search\" class=\"btn_default\" />
			</p>
			</form>
		<!-- //Form -->
		";

		$inp_ip = output_html($inp_ip);
		$ip_array = explode(":", $inp_ip);

		$ip_a = hexdec($ip_array[0]);
		$ip_a_mysql = quote_smart($link, $ip_a);

		$ip_b = hexdec($ip_array[1]);
		$ip_b_mysql = quote_smart($link, $ip_b);

		$ip_c = hexdec($ip_array[2]);
		$ip_c_mysql = quote_smart($link, $ip_c);

		$ip_d = hexdec($ip_array[3]);
		$ip_d_mysql = quote_smart($link, $ip_d);

		$ip_e = hexdec($ip_array[4]);
		$ip_e_mysql = quote_smart($link, $ip_e);

		$ip_f = hexdec($ip_array[5]);
		$ip_f_mysql = quote_smart($link, $ip_f);

		$ip_g = hexdec($ip_array[6]);
		$ip_g_mysql = quote_smart($link, $ip_g);

		$ip_h = hexdec($ip_array[7]);
		$ip_h_mysql = quote_smart($link, $ip_h);

		
		$query = "SELECT $t_stats_ip_to_country_ipv6.ip_id, $t_stats_ip_to_country_geonames.geoname_country_name FROM $t_stats_ip_to_country_ipv6 JOIN $t_stats_ip_to_country_geonames ON $t_stats_ip_to_country_ipv6.ip_geoname_id=$t_stats_ip_to_country_geonames.geoname_id";
		$query = $query . " WHERE ip_registered_country_geoname_id != ''";
		$query = $query . " AND $t_stats_ip_to_country_ipv6.ip_from_dec_a<=$ip_a_mysql AND $t_stats_ip_to_country_ipv6.ip_to_dec_a>=$ip_a_mysql";
		$query = $query . " AND $t_stats_ip_to_country_ipv6.ip_from_dec_b<=$ip_b_mysql AND $t_stats_ip_to_country_ipv6.ip_to_dec_b>=$ip_b_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_ip_id, $get_geoname_country_name) = $row;


		echo"
		<p>
		Query: $query<br />
		IP ID: $get_ip_id<br />
		Country name: $get_geoname_country_name
		</p>
	<!-- //Example ipv6 -->

	<!-- Generate-->
		<h2>Generate</h2>
		<p>
		<a href=\"index.php?open=dashboard&amp;page=statistics_ipv6_generate_insert_script&amp;editor_language=$editor_language&amp;l=$l\">Generate IPv6 insert script</a>
		</p>
	<!-- //Generate -->


	<!-- ipv6 -->
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span>Network</span>
		   </th>
		   <th scope=\"col\">
			<span>Start</span>
		   </th>
		   <th scope=\"col\">
			<span>Stop</span>
		   </th>
		   <th scope=\"col\">
			<span>Geo</span>
		   </th>
		  </tr>
		 </thead>
		 <tbody>
		";
		

		$query = "SELECT ip_id, ip_network, ip_from, ip_to, ip_geoname_id FROM $t_stats_ip_to_country_ipv6 WHERE ip_from_dec_a<=$ip_a_mysql LIMIT 0,500";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_ip_id, $get_ip_network, $get_ip_from, $get_ip_to, $get_ip_geoname_id) = $row;

			if(isset($style) && $style == "odd"){
				$style = "";
			}
			else{
				$style = "odd";
			}

			// Country
			$query_country = "SELECT geoname_row, geoname_country_name FROM $t_stats_ip_to_country_geonames WHERE geoname_id='$get_ip_geoname_id'";
			$result_country = mysqli_query($link, $query_country);
			$row_country = mysqli_fetch_row($result_country);
			list($get_geoname_row, $get_geoname_country_name) = $row_country;


			echo"
			 <tr>
			  <td class=\"$style\">
				<span>$get_ip_network</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_ip_from</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_ip_to</span>
			  </td>
			  <td class=\"$style\">
				<span>$get_geoname_country_name</span>
			  </td>
			 </tr>
			";
		}
		echo"
		 </tbody>
		</table>
	<!-- //IPv6 -->
	";
} // ipv4_to_country

?>