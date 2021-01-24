<?php
/**
*
* File: _admin/_inc/media/statistics_month.php
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

$t_search_engine_searches = $mysqlPrefixSav . "search_engine_searches";



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

if(isset($_GET['stats_month'])) {
	$stats_month = $_GET['stats_month'];
	$stats_month = strip_tags(stripslashes($stats_month));
}
else{
	$stats_month = date("m");
}
$stats_month_mysql = quote_smart($link, $stats_month);


// Find month
$query = "SELECT stats_visit_per_month_id, stats_visit_per_month_month, stats_visit_per_month_month_full, stats_visit_per_month_month_short, stats_visit_per_month_year, stats_visit_per_month_human_unique, stats_visit_per_month_human_unique_diff_from_last_month, stats_visit_per_month_human_average_duration, stats_visit_per_month_human_new_visitor_unique, stats_visit_per_month_human_returning_visitor_unique, stats_visit_per_month_unique_desktop, stats_visit_per_month_unique_mobile, stats_visit_per_month_unique_bots, stats_visit_per_month_hits_total, stats_visit_per_month_hits_human, stats_visit_per_month_hits_desktop, stats_visit_per_month_hits_mobile, stats_visit_per_month_hits_bots FROM $t_stats_visists_per_month WHERE stats_visit_per_month_month=$stats_month_mysql AND stats_visit_per_month_year=$stats_year_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_stats_visit_per_month_id, $get_current_stats_visit_per_month_month, $get_current_stats_visit_per_month_month_full, $get_current_stats_visit_per_month_month_short, $get_current_stats_visit_per_month_year, $get_current_stats_visit_per_month_human_unique, $get_current_stats_visit_per_month_human_unique_diff_from_last_month, $get_current_stats_visit_per_month_human_average_duration, $get_current_stats_visit_per_month_human_new_visitor_unique, $get_current_stats_visit_per_month_human_returning_visitor_unique, $get_current_stats_visit_per_month_unique_desktop, $get_current_stats_visit_per_month_unique_mobile, $get_current_stats_visit_per_month_unique_bots, $get_current_stats_visit_per_month_hits_total, $get_current_stats_visit_per_month_hits_human, $get_current_stats_visit_per_month_hits_desktop, $get_current_stats_visit_per_month_hits_mobile, $get_current_stats_visit_per_month_hits_bots) = $row;

if($get_current_stats_visit_per_month_id == ""){
	echo"<p>Server error 404</p>";
}
else{	
	echo"
	<!-- Headline -->
		<h1>Statistics $get_current_stats_visit_per_month_month_full $get_current_stats_visit_per_month_year</h1>
	<!-- //Headline -->
	
	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=$open&amp;page=statistics&amp;l=$l\">Statistics</a>
		&gt;
		<a href=\"index.php?open=$open&amp;page=statistics_year&amp;stats_year=$get_current_stats_visit_per_month_year&amp;l=$l\">$get_current_stats_visit_per_month_year</a>
		&gt;
		<a href=\"index.php?open=$open&amp;page=$page&amp;stats_year=$get_current_stats_visit_per_month_year&amp;stats_month=$get_current_stats_visit_per_month_month&amp;l=$l\">$get_current_stats_visit_per_month_month_full $get_current_stats_visit_per_month_year</a>
		</p>
	<!-- //Where am I? -->

	

	<!-- Charts javascript -->
		<script src=\"_javascripts/amcharts4/core.js\"></script>
		<script src=\"_javascripts/amcharts4/charts.js\"></script>
		<script src=\"_javascripts/amcharts4/themes/animated.js\"></script>
		<script src=\"_javascripts/amcharts4/plugins/venn.js\"></script>
		<script src=\"_javascripts/amcharts4/maps.js\"></script>
		<script src=\"_javascripts/amcharts4/geodata/worldLow.js\"></script>
	<!-- //Charts javascript -->


	<!-- Visits per day -->
		<h2 style=\"padding-bottom:0;margin-bottom:0;\">Visits per day</h2>

		<script>
		am4core.ready(function() {
			var chart = am4core.create(\"chartdiv_visits_per_month\", am4charts.XYChart);
			chart.data = [";

			$x = 0;
			$query = "SELECT stats_visit_per_day_id, stats_visit_per_day_day, stats_visit_per_day_day_full, stats_visit_per_day_day_three, stats_visit_per_day_day_single, stats_visit_per_day_month, stats_visit_per_day_month_full, stats_visit_per_day_month_short, stats_visit_per_day_year, stats_visit_per_day_human_unique, stats_visit_per_day_human_unique_diff_from_yesterday, stats_visit_per_day_human_average_duration, stats_visit_per_day_human_new_visitor_unique, stats_visit_per_day_human_returning_visitor_unique, stats_visit_per_day_unique_desktop, stats_visit_per_day_unique_mobile, stats_visit_per_day_unique_bots, stats_visit_per_day_hits_total, stats_visit_per_day_hits_human, stats_visit_per_day_hits_desktop, stats_visit_per_day_hits_mobile, stats_visit_per_day_hits_bots FROM $t_stats_visists_per_day WHERE stats_visit_per_day_month=$get_current_stats_visit_per_month_month AND stats_visit_per_day_year=$get_current_stats_visit_per_month_year ORDER BY stats_visit_per_day_id";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_stats_visit_per_day_id, $get_stats_visit_per_day_day, $get_stats_visit_per_day_day_full, $get_stats_visit_per_day_day_three, $get_stats_visit_per_day_day_single, $get_stats_visit_per_day_month, $get_stats_visit_per_day_month_full, $get_stats_visit_per_day_month_short, $get_stats_visit_per_day_year, $get_stats_visit_per_day_human_unique, $get_stats_visit_per_day_human_unique_diff_from_yesterday, $get_stats_visit_per_day_human_average_duration, $get_stats_visit_per_day_human_new_visitor_unique, $get_stats_visit_per_day_human_returning_visitor_unique, $get_stats_visit_per_day_unique_desktop, $get_stats_visit_per_day_unique_mobile, $get_stats_visit_per_day_unique_bots, $get_stats_visit_per_day_hits_total, $get_stats_visit_per_day_hits_human, $get_stats_visit_per_day_hits_desktop, $get_stats_visit_per_day_hits_mobile, $get_stats_visit_per_day_hits_bots) = $row;
						
				if($x > 0){
					echo",";
				}
				echo"
				{
					\"x\": \"$get_stats_visit_per_day_day_three $get_stats_visit_per_day_day\",
					\"value\": $get_stats_visit_per_day_human_unique
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
			var series1 = chart.series.push(new am4charts.LineSeries());
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
	<!-- //Visits per day -->


	<!-- Countries -->
		<h2 style=\"margin-top:20px;padding-bottom:0;margin-bottom:0;\">Unique Visits per Country for $get_current_stats_visit_per_month_month_full</h2>

		<script>
		am4core.ready(function() {
			am4core.useTheme(am4themes_animated);
			var chart = am4core.create(\"chartdiv_unique_visits_per_country\", am4maps.MapChart);
			chart.geodata = am4geodata_worldLow;


			chart.projection = new am4maps.projections.Miller();

			var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
			var polygonTemplate = polygonSeries.mapPolygons.template;
			polygonTemplate.tooltipText = \"{name}: {value.value}\";
			polygonSeries.useGeodata = true;
			polygonSeries.heatRules.push({ property: \"fill\", target: polygonSeries.mapPolygons.template, min: am4core.color(\"#ffffff\"), max: am4core.color(\"#263544\") });


			// add heat legend
			var heatLegend = chart.chartContainer.createChild(am4maps.HeatLegend);
			heatLegend.valign = \"bottom\";
			heatLegend.series = polygonSeries;
			heatLegend.width = am4core.percent(100);
			heatLegend.orientation = \"horizontal\";
			heatLegend.padding(30, 30, 30, 30);
			heatLegend.valueAxis.renderer.labels.template.fontSize = 10;
			heatLegend.valueAxis.renderer.minGridDistance = 40;

			polygonSeries.mapPolygons.template.events.on(\"over\", function (event) {
			  handleHover(event.target);
			})

			polygonSeries.mapPolygons.template.events.on(\"hit\", function (event) {
			  handleHover(event.target);
			})

			function handleHover(mapPolygon) {
			  if (!isNaN(mapPolygon.dataItem.value)) {
			    heatLegend.valueAxis.showTooltipAt(mapPolygon.dataItem.value)
			  }
			  else {
			    heatLegend.valueAxis.hideTooltip();
			  }
			}

			polygonSeries.mapPolygons.template.events.on(\"out\", function (event) {
			  heatLegend.valueAxis.hideTooltip();
			})


			// data
			polygonSeries.data = [";
				$x = 0;
				$query = "SELECT stats_country_id, stats_country_name, stats_country_alpha_2, stats_country_unique, stats_country_hits FROM $t_stats_countries_per_month WHERE stats_country_month=$get_current_stats_visit_per_month_month AND stats_country_year=$get_current_stats_visit_per_month_year";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_stats_country_id, $get_stats_country_name, $get_stats_country_alpha_2, $get_stats_country_unique, $get_stats_country_hits) = $row;

					if($x > 0){
						echo",";
					}
					echo"
					{ \"id\": \"$get_stats_country_alpha_2\", \"value\": $get_stats_country_unique }";

					// x++
					$x++;
				} // while
			echo"];

			// excludes Antarctica
			polygonSeries.exclude = [\"AQ\"];

			chart.seriesContainer.draggable = false;
			chart.seriesContainer.resizable = false;
			chart.maxZoomLevel = 1;
		}); // end am4core.ready()
		</script>
		<div id=\"chartdiv_unique_visits_per_country\" style=\"width: 100%;max-height: 600px;height: 100vh;\"></div>
		
	<!-- //Countries -->


	<!-- Accepted languages -->
		<div class=\"left_right_left\">
			<h2 style=\"margin-top: 20px;\">$l_accepted_languages</h2>


			<script>
			am4core.ready(function() {
				var chart = am4core.create(\"chartdiv_accepted_language_year\", am4charts.PieChart);
				chart.data = [";
				$x = 0;
				$query = "SELECT stats_accepted_language_id, stats_accepted_language_year, stats_accepted_language_name, stats_accepted_language_unique, stats_accepted_language_hits FROM $t_stats_accepted_languages_per_month WHERE stats_accepted_language_month=$get_current_stats_visit_per_month_month AND stats_accepted_language_year=$get_current_stats_visit_per_month_year";
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
	<!-- //Accepted languages -->

	<!-- Mobile vs desktop -->
		<div class=\"left_right_right\">
			<h2 style=\"margin-top: 20px;\">Mobile vs desktop</h2>

			<script>
			am4core.ready(function() {
				var chart = am4core.create(\"chartdiv_mobile_vs_desktop\", am4charts.PieChart);
				chart.data = [
					{
					\"x\": \"Desktop\",
					\"value\": $get_current_stats_visit_per_month_unique_desktop
					},
					{
					\"x\": \"Mobile\",
					\"value\": $get_current_stats_visit_per_month_unique_mobile
					}

            			];
				var series = chart.series.push(new am4charts.PieSeries());
				series.dataFields.value = \"value\";
				series.dataFields.category = \"x\";
			}); // end am4core.ready()
       			</script>
       			<div id=\"chartdiv_mobile_vs_desktop\" style=\"max-height: 250px;margin-top:10px;\"></div>
		</div>
		<div class=\"clear\"></div>
	<!-- //Mobile vs desktop -->


	<!-- Os -->
		<div class=\"left_right_left\">
			<h2 style=\"margin-top: 20px;\">$l_os</h2>

			<script>
			am4core.ready(function() {
				var chart = am4core.create(\"chartdiv_os_year\", am4charts.PieChart);
				chart.data = [";
				$x = 0;
				$query = "SELECT stats_os_id, stats_os_year, stats_os_name, stats_os_type, stats_os_unique, stats_os_hits FROM $t_stats_os_per_month WHERE stats_os_month=$get_current_stats_visit_per_month_month AND stats_os_year=$get_current_stats_visit_per_month_year";
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
			<h2 style=\"margin-top: 20px;\">$l_browsers</h2>

			<script>
			am4core.ready(function() {
				var chart = am4core.create(\"chartdiv_browsers_year\", am4charts.PieChart);
				chart.data = [";
				$x = 0;
				$query = "SELECT stats_browser_id, stats_browser_year, stats_browser_name, stats_browser_unique, stats_browser_hits FROM $t_stats_browsers_per_month WHERE stats_browser_month=$get_current_stats_visit_per_month_month AND stats_browser_year=$get_current_stats_visit_per_month_year";
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




	<!-- Humans vs bots unique -->
		<div class=\"left_right_left\">
			<h2 style=\"margin-top: 20px;\">Human vs bots unique</h2>

			<script>
			am4core.ready(function() {
				var chart = am4core.create(\"chartdiv_humans_vs_bots_unique\", am4charts.PieChart);
				chart.data = [
					{
					\"x\": \"Humans\",
					\"value\": $get_current_stats_visit_per_month_human_unique
					},
					{
					\"x\": \"Bots\",
					\"value\": $get_current_stats_visit_per_month_unique_bots
					}

            			];
				var series = chart.series.push(new am4charts.PieSeries());
				series.dataFields.value = \"value\";
				series.dataFields.category = \"x\";
			}); // end am4core.ready()
       			</script>
       			<div id=\"chartdiv_humans_vs_bots_unique\" style=\"max-height: 250px;margin-top:10px;\"></div>
		</div>
	<!-- //Humans vs bots unique -->

		

	<!-- xyz -->
		<div class=\"left_right_right\">

		</div>
		<div class=\"clear\"></div>
	<!-- //xyz -->

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

		$query = "SELECT stats_bot_id, stats_bot_year, stats_bot_name, stats_bot_unique, stats_bot_hits FROM $t_stats_bots_per_month WHERE stats_bot_month=$get_current_stats_visit_per_month_month AND stats_bot_year=$get_current_stats_visit_per_month_year  ORDER BY stats_bot_unique DESC LIMIT 0,5";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_stats_bot_id, $get_stats_bot_year, $get_stats_bot_name, $get_stats_bot_unique, $get_stats_bot_hits) = $row;
			

			$percent = round(($get_stats_bot_unique/$get_current_stats_visit_per_month_unique_bots)*100);
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

	<!-- Searches -->
		<h2>Searches</h2>
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span>Query</span>
		   </th>
		   <th scope=\"col\">
			<span>Search counter</span>
		   </th>
		   <th scope=\"col\">
			<span>Results</span>
		   </th>
		   <th scope=\"col\">
			<span>Created</span>
		   </th>
		   <th scope=\"col\">
			<span>Updated</span>
		   </th>
		  </tr>
		 </thead>
		 <tbody>
		";

		// Calendar
		$between_from = "$get_current_stats_visit_per_month_year-$get_current_stats_visit_per_month_month-01 00:00:00";
		if($get_current_stats_visit_per_month_month < "10"){
			$between_from = "$get_current_stats_visit_per_month_year-0$get_current_stats_visit_per_month_month-01 00:00:00";
		}
		$between_from_mysql = quote_smart($link, $between_from);

		$between_to = "$get_current_stats_visit_per_month_year-$get_current_stats_visit_per_month_month-31 00:00:00";
		if($get_current_stats_visit_per_month_month == "2"){
			$between_to = "$get_current_stats_visit_per_month_year-$get_current_stats_visit_per_month_month-28 00:00:00";
		}
		elseif($get_current_stats_visit_per_month_month == "4" OR $get_current_stats_visit_per_month_month == "6" OR $get_current_stats_visit_per_month_month == "9" OR $get_current_stats_visit_per_month_month == "11"){
			$between_to = "$get_current_stats_visit_per_month_year-$get_current_stats_visit_per_month_month-30 00:00:00";
		}
		else{
			$between_to = "$get_current_stats_visit_per_month_year-$get_current_stats_visit_per_month_month-31 00:00:00";
		}
		$between_to_mysql = quote_smart($link, $between_to);

		$query = "SELECT search_id, search_query, search_unique_counter, search_language_used, search_unique_ip_block, search_number_of_results, search_created_datetime, search_created_datetime_print, search_updated_datetime, search_updated_datetime_print FROM $t_search_engine_searches WHERE search_updated_datetime > $between_from_mysql AND search_updated_datetime < $between_to_mysql ORDER BY search_updated_datetime DESC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_search_id, $get_search_query, $get_search_unique_counter, $get_search_language_used, $get_search_unique_ip_block, $get_search_number_of_results, $get_search_created_datetime, $get_search_created_datetime_print, $get_search_updated_datetime, $get_search_updated_datetime_print) = $row;
			
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
				<span>
				<a href=\"../search/search.php?inp_search_query=$get_search_query&amp;l=$get_search_language_used\">$get_search_query</a>
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				$get_search_unique_counter
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				$get_search_number_of_results
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				$get_search_created_datetime_print
				</span>
			  </td>
			  <td class=\"$style\">
				<span>
				$get_search_updated_datetime_print
				</span>
			  </td>
			 </tr>";
		}
		


		echo"
		 </tbody>
		</table>
	<!-- //Searches -->

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

		$query = "SELECT stats_referer_id, stats_referer_year, stats_referer_from_url, stats_referer_to_url, stats_referer_unique, stats_referer_hits FROM $t_stats_referers_per_month WHERE stats_referer_month=$get_current_stats_visit_per_month_month AND stats_referer_year=$get_current_stats_visit_per_month_year ORDER BY stats_referer_unique DESC LIMIT 0,30";
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