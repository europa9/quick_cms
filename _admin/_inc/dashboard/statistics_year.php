<?php
/**
*
* File: _admin/_inc/media/statistics_year.php
* Version 3.0
* Date 13:25 21.10.2020
* Copyright (c) 2008-2020 Sindre Andre Ditlefsen
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



/*- Translation ----------------------------------------------------------------------- */
include("_translations/admin/$l/dashboard/t_default.php");

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['stats_year'])) {
	$stats_year = $_GET['stats_year'];
	$stats_year = strip_tags(stripslashes($stats_year));
}
else{
	$stats_year = date("Y");
}
$stats_year_mysql = quote_smart($link, $stats_year);

// Find year
$query = "SELECT stats_visit_per_year_id, stats_visit_per_year_year, stats_visit_per_year_human_unique, stats_visit_per_year_human_unique_diff_from_last_year, stats_visit_per_year_human_average_duration, stats_visit_per_year_human_new_visitor_unique, stats_visit_per_year_human_returning_visitor_unique, stats_visit_per_year_unique_desktop, stats_visit_per_year_unique_mobile, stats_visit_per_year_unique_bots, stats_visit_per_year_hits_total, stats_visit_per_year_hits_human, stats_visit_per_year_hits_desktop, stats_visit_per_year_hits_mobile, stats_visit_per_year_hits_bots FROM $t_stats_visists_per_year WHERE stats_visit_per_year_year=$stats_year_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_stats_visit_per_year_id, $get_current_stats_visit_per_year_year, $get_current_stats_visit_per_year_human_unique, $get_current_stats_visit_per_year_human_unique_diff_from_last_year, $get_current_stats_visit_per_year_human_average_duration, $get_current_stats_visit_per_year_human_new_visitor_unique, $get_current_stats_visit_per_year_human_returning_visitor_unique, $get_current_stats_visit_per_year_unique_desktop, $get_current_stats_visit_per_year_unique_mobile, $get_current_stats_visit_per_year_unique_bots, $get_current_stats_visit_per_year_hits_total, $get_current_stats_visit_per_year_hits_human, $get_current_stats_visit_per_year_hits_desktop, $get_current_stats_visit_per_year_hits_mobile, $get_current_stats_visit_per_year_hits_bots) = $row;

if($get_current_stats_visit_per_year_id == ""){
	echo"<p>Server error 404</p>";
}
else{	
	echo"
	<!-- Headline -->
		<h1>Statistics $get_current_stats_visit_per_year_year</h1>
	<!-- //Headline -->
	
	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=$open&amp;page=statistics&amp;l=$l\">Statistics</a>
		&gt;
		<a href=\"index.php?open=$open&amp;page=$page&amp;stats_year=$get_current_stats_visit_per_year_year&amp;l=$l\">$get_current_stats_visit_per_year_year</a>
		</p>
	<!-- //Where am I? -->

	

	<!-- Charts javascript -->
		<script src=\"_javascripts/amcharts4/core.js\"></script>
		<script src=\"_javascripts/amcharts4/charts.js\"></script>
		<script src=\"_javascripts/amcharts4/themes/animated.js\"></script>
		<script src=\"_javascripts/amcharts4/plugins/venn.js\"></script>
	<!-- //Charts javascript -->


	<!-- Visits per month -->
		<h2 style=\"padding-bottom:0;margin-bottom:0;\">Visits per month</h2>

		<script>
		am4core.ready(function() {
			var chart = am4core.create(\"chartdiv_visits_per_month\", am4charts.XYChart);
			chart.data = [";

			$x = 0;
			$query = "SELECT stats_visit_per_month_id, stats_visit_per_month_month, stats_visit_per_month_month_short, stats_visit_per_month_year, stats_visit_per_month_human_unique, stats_visit_per_month_human_unique_diff_from_last_month, stats_visit_per_month_human_average_duration, stats_visit_per_month_human_new_visitor_unique, stats_visit_per_month_human_returning_visitor_unique, stats_visit_per_month_unique_desktop, stats_visit_per_month_unique_mobile, stats_visit_per_month_unique_bots, stats_visit_per_month_hits_total, stats_visit_per_month_hits_human, stats_visit_per_month_hits_desktop, stats_visit_per_month_hits_mobile, stats_visit_per_month_hits_bots FROM $t_stats_visists_per_month WHERE stats_visit_per_month_year=$get_current_stats_visit_per_year_year ORDER BY stats_visit_per_month_id ASC LIMIT 0,12";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_stats_visit_per_month_id, $get_stats_visit_per_month_month, $get_stats_visit_per_month_month_short, $get_stats_visit_per_month_year, $get_stats_visit_per_month_human_unique, $get_stats_visit_per_month_human_unique_diff_from_last_month, $get_stats_visit_per_month_human_average_duration, $get_stats_visit_per_month_human_new_visitor_unique, $get_stats_visit_per_month_human_returning_visitor_unique, $get_stats_visit_per_month_unique_desktop, $get_stats_visit_per_month_unique_mobile, $get_stats_visit_per_month_unique_bots, $get_stats_visit_per_month_hits_total, $get_stats_visit_per_month_hits_human, $get_stats_visit_per_month_hits_desktop, $get_stats_visit_per_month_hits_mobile, $get_stats_visit_per_month_hits_bots) = $row;
						
				if($x > 0){
					echo",";
				}
				echo"
				{
					\"x\": \"$get_stats_visit_per_month_month_short\",
					\"value\": $get_stats_visit_per_month_human_unique
				}";
				$x++;
			} // while

			echo"
			];
			// Create axes
			var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = \"x\";
			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
							
			// Create series
			var series1 = chart.series.push(new am4charts.ColumnSeries);
			series1.dataFields.valueY = \"value\";
			series1.dataFields.categoryX = \"x\";
			series1.name = \"Unique visits\";
			series1.tooltipText = \"Unique visits: {valueY}\";
			series1.fill = am4core.color(\"#99e4dc\");
			series1.stroke = am4core.color(\"#66d5c9\");
			series1.strokeWidth = 1;

			// Tooltips
			chart.cursor = new am4charts.XYCursor();
			chart.cursor.snapToSeries = series;
			chart.cursor.xAxis = valueAxis;
		}); // end am4core.ready()
		</script>
		<div id=\"chartdiv_visits_per_month\" style=\"height: 400px;\"></div>
	<!-- //Visits per month -->


	<!-- Accepted languages -->
		<div class=\"left_right_left\">
			<h2 style=\"padding-bottom:0;margin-bottom:0;\">Countries</h2>

			<script>
			am4core.ready(function() {
				var chart = am4core.create(\"chartdiv_countries_year\", am4charts.PieChart);
				chart.data = [";
				$x = 0;
				$query = "SELECT stats_country_id, stats_country_name, stats_country_unique, stats_country_hits FROM $t_stats_countries_per_year WHERE stats_country_year=$get_current_stats_visit_per_year_year";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_stats_country_id, $get_stats_country_name, $get_stats_country_unique, $get_stats_country_hits) = $row;

					if($x > 0){
						echo",";
					}
					echo"
					{
					\"x\": \"$get_stats_country_name\",
					\"value\": $get_stats_country_unique
					}";

					// x++
					$x++;
				} // while
				echo"
            			];
				var series = chart.series.push(new am4charts.PieSeries());
				series.dataFields.value = \"value\";
				series.dataFields.category = \"x\";
			}); // end am4core.ready()
       			</script>
       			<div id=\"chartdiv_countries_year\" style=\"max-height: 250px;margin-top:10px;\"></div>
		</div>
	<!-- //Countries -->

	<!-- Accepted languages -->
		<div class=\"left_right_right\">
			<h2>$l_accepted_languages</h2>


			<script>
			am4core.ready(function() {
				var chart = am4core.create(\"chartdiv_accepted_language_year\", am4charts.PieChart);
				chart.data = [";
				$x = 0;
				$query = "SELECT stats_accepted_language_id, stats_accepted_language_year, stats_accepted_language_name, stats_accepted_language_unique, stats_accepted_language_hits FROM $t_stats_accepted_languages_per_year WHERE stats_accepted_language_year=$get_current_stats_visit_per_year_year";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_stats_accepted_language_id, $get_stats_accepted_language_year, $get_stats_accepted_language_name, $get_stats_accepted_language_unique, $get_stats_accepted_language_hits) = $row;

					if($x > 0){
						echo",";
					}
					echo"
					{
					\"x\": \"$get_stats_accepted_language_name\",
					\"value\": $get_stats_accepted_language_unique
					}";

					// x++
					$x++;
				} // while
				echo"
            			];
				var series = chart.series.push(new am4charts.PieSeries());
				series.dataFields.value = \"value\";
				series.dataFields.category = \"x\";
			}); // end am4core.ready()
       			</script>
       			<div id=\"chartdiv_accepted_language_year\" style=\"max-height: 250px;margin-top:10px;\"></div>
		</div>
		<div class=\"clear\"></div>
	<!-- //Accepted languages -->


	<!-- Os -->
		<div class=\"left_right_left\">
			<h2>$l_os</h2>

			<script>
			am4core.ready(function() {
				var chart = am4core.create(\"chartdiv_os_year\", am4charts.PieChart);
				chart.data = [";
				$x = 0;
				$query = "SELECT stats_os_id, stats_os_year, stats_os_name, stats_os_type, stats_os_unique, stats_os_hits FROM $t_stats_os_per_year WHERE stats_os_year=$get_current_stats_visit_per_year_year";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_stats_os_id, $get_stats_os_year, $get_stats_os_name, $get_stats_os_type, $get_stats_os_unique, $get_stats_os_hits) = $row;

					if($x > 0){
						echo",";
					}
					echo"
					{
					\"x\": \"$get_stats_os_name\",
					\"value\": $get_stats_os_unique
					}";

					// x++
					$x++;
				} // while
				echo"
            			];
				var series = chart.series.push(new am4charts.PieSeries());
				series.dataFields.value = \"value\";
				series.dataFields.category = \"x\";
			}); // end am4core.ready()
       			</script>
       			<div id=\"chartdiv_os_year\" style=\"max-height: 250px;margin-top:10px;\"></div>

		</div>
	<!-- //Os -->



	<!-- Browsers -->
		<div class=\"left_right_right\">
			<h2>$l_browsers</h2>

			<script>
			am4core.ready(function() {
				var chart = am4core.create(\"chartdiv_browsers_year\", am4charts.PieChart);
				chart.data = [";
				$x = 0;
				$query = "SELECT stats_browser_id, stats_browser_year, stats_browser_name, stats_browser_unique, stats_browser_hits FROM $t_stats_browsers_per_year WHERE stats_browser_year=$get_current_stats_visit_per_year_year";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_stats_browser_id, $get_stats_browser_year, $get_stats_browser_name, $get_stats_browser_unique, $get_stats_browser_hits) = $row;

					if($x > 0){
						echo",";
					}
					echo"
					{
					\"x\": \"$get_stats_browser_name\",
					\"value\": $get_stats_browser_unique
					}";

					// x++
					$x++;
				} // while
				echo"
            			];
				var series = chart.series.push(new am4charts.PieSeries());
				series.dataFields.value = \"value\";
				series.dataFields.category = \"x\";
			}); // end am4core.ready()
       			</script>
       			<div id=\"chartdiv_browsers_year\" style=\"max-height: 250px;margin-top:10px;\"></div>

		</div>
		<div class=\"clear\"></div>
	<!-- //Browsers -->




	<!-- Bots -->
		<h2>$l_bots</h2>
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\" style=\"width: 40%;\">
			<span>$l_bot</span>
		   </th>
		   <th scope=\"col\" style=\"width: 30%;\">
			<span>$l_unique</span>
		   </th>
		   <th scope=\"col\" style=\"width: 30%;\">
			<span>$l_hits</span>
		   </th>
		  </tr>
		 </thead>
		 <tbody>
		";

		$query = "SELECT stats_bot_id, stats_bot_year, stats_bot_name, stats_bot_unique, stats_bot_hits FROM $t_stats_bots_per_year WHERE stats_bot_year=$get_current_stats_visit_per_year_year ORDER BY stats_bot_unique DESC LIMIT 0,5";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_stats_bot_id, $get_stats_bot_year, $get_stats_bot_name, $get_stats_bot_unique, $get_stats_bot_hits) = $row;
			

			$percent = round(($get_stats_bot_unique/$get_current_stats_visit_per_year_unique_bots)*100);
			if($percent > 90){
				$width = 90;
			}
			elseif($percent == 0){
				$width = 1;
			}
			else{
				$width = $percent;
			}
			$div_width = $width . "px";

			echo"
			 <tr>
			  <td>
				<span>$get_stats_bot_name</span>
			  </td>
			  <td>
				<span style=\"float:left;margin-right:10px;\">$get_stats_bot_unique</span>
				<div class=\"stats_bar\" style=\"float:left;margin-right:10px;width: $div_width\">
					<div class=\"stats_bar_inner\"><span>&nbsp;</span></div>
				</div>
			  </td>
			  <td>
				<span>$get_stats_bot_hits</span>
			  </td>
			 </tr>
			";
		}
		echo"
		 </tbody>
		</table>
	<!-- //Bots -->

	<!-- Referers-->
		<h2>Referrers</h2>
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\" style=\"width: 40%;\">
			<span>From URL</span>
		   </th>
		   <th scope=\"col\" style=\"width: 30%;\">
			<span>To URL</span>
		   </th>
		   <th scope=\"col\" style=\"width: 30%;\">
			<span>Unique</span>
		   </th>
		   <th scope=\"col\" style=\"width: 30%;\">
			<span>Hits</span>
		   </th>
		  </tr>
		 </thead>
		 <tbody>
		";

		$query = "SELECT stats_referer_id, stats_referer_year, stats_referer_from_url, stats_referer_to_url, stats_referer_unique, stats_referer_hits FROM $t_stats_referers_per_year WHERE stats_referer_year=$get_current_stats_visit_per_year_year ORDER BY stats_referer_unique DESC LIMIT 0,30";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_stats_referer_id, $get_stats_referer_year, $get_stats_referer_from_url, $get_stats_referer_to_url, $get_stats_referer_unique, $get_stats_referer_hits) = $row;
			


			echo"
			 <tr>
			  <td>
				<span><a href=\"$get_stats_referer_from_url\">$get_stats_referer_from_url</a></span>
			  </td>
			  <td>
				<span><a href=\"$get_stats_referer_to_url\">$get_stats_referer_to_url</a></span>
			  </td>
			  <td>
				<span>$get_stats_referer_unique</span>
			  </td>
			  <td>
				<span>$get_stats_referer_hits</span>
			  </td>
			 </tr>
			";
		}
		echo"
		 </tbody>
		</table>
	<!-- //Referers-->

	";
	
} // year found

?>