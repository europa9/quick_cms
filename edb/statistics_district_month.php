<?php 
/**
*
* File: edb/statistics_district_month.php
* Version 1.0
* Date 20:08 18.08.2019
* Copyright (c) 2019 S. A. Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "2";
$pageNoColumnSav      = "2";
$pageAllowCommentsSav = "1";
$pageAuthorUserIdSav  = "1";

/*- Root dir --------------------------------------------------------------------------------- */
// This determine where we are
if(file_exists("favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
elseif(file_exists("../../../../favicon.ico")){ $root = "../../../.."; }
else{ $root = "../../.."; }

/*- Website config --------------------------------------------------------------------------- */
include("$root/_admin/website_config.php");

/*- Language --------------------------------------------------------------------------- */
include("$root/_admin/_translations/site/$l/edb/ts_edb.php");
include("$root/_admin/_translations/site/$l/edb/ts_statistics_station.php");
include("$root/_admin/_translations/site/$l/edb/ts_statistics_station_month.php");

/*- Tables ---------------------------------------------------------------------------- */
$t_edb_stats_acquirements_per_month	= $mysqlPrefixSav . "edb_stats_acquirements_per_month";


/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['stats_id'])) {
	$stats_id = $_GET['stats_id'];
	$stats_id = strip_tags(stripslashes($stats_id));
}
else{
	$stats_id = "";
}
$stats_id_mysql = quote_smart($link, $stats_id);



/*- Tables ---------------------------------------------------------------------------- */
$t_edb_stats_index 			= $mysqlPrefixSav . "edb_stats_index";
$t_edb_stats_case_codes			= $mysqlPrefixSav . "edb_stats_case_codes";
$t_edb_stats_case_priorites		= $mysqlPrefixSav . "edb_stats_case_priorites";
$t_edb_stats_item_types 		= $mysqlPrefixSav . "edb_stats_item_types";
$t_edb_stats_statuses_per_day		= $mysqlPrefixSav . "edb_stats_statuses_per_day";
$t_edb_stats_employee_of_the_month	= $mysqlPrefixSav . "edb_stats_employee_of_the_month";
$t_edb_stats_acquirements_per_month	= $mysqlPrefixSav . "edb_stats_acquirements_per_month";

$t_edb_stats_requests_user_per_month			= $mysqlPrefixSav . "edb_stats_requests_user_per_month";
$t_edb_stats_requests_user_case_codes_per_month		= $mysqlPrefixSav . "edb_stats_requests_user_case_codes_per_month";
$t_edb_stats_requests_user_item_types_per_month		= $mysqlPrefixSav . "edb_stats_requests_user_item_types_per_month";
$t_edb_stats_requests_department_per_month		= $mysqlPrefixSav . "edb_stats_requests_department_per_month";
$t_edb_stats_requests_department_case_codes_per_month	= $mysqlPrefixSav . "edb_stats_requests_department_case_codes_per_month";
$t_edb_stats_requests_department_item_types_per_month	= $mysqlPrefixSav . "edb_stats_requests_department_item_types_per_month";

/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){


	// Find stats
	$query = "SELECT stats_id, stats_year, stats_month, stats_month_saying, stats_district_id, stats_station_id, stats_user_id, stats_cases_created, stats_cases_closed, stats_avg_created_to_close_time, stats_avg_created_to_close_days, stats_avg_created_to_close_saying FROM $t_edb_stats_index WHERE stats_id=$stats_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_stats_id, $get_current_stats_year, $get_current_stats_month, $get_current_stats_month_saying, $get_current_stats_district_id, $get_current_stats_station_id, $get_current_stats_user_id, $get_current_stats_cases_created, $get_current_stats_cases_closed, $get_current_stats_avg_created_to_close_time, $get_current_stats_avg_created_to_close_days, $get_current_stats_avg_created_to_close_saying) = $row;
	
	if($get_current_stats_id == ""){
		echo"<h1>Server error 404</h1>
		<p>Stats not found.</p>";
			die;
	}
	else{
		// Find district
		$query = "SELECT district_id, district_number, district_title, district_title_clean, district_icon_path, district_icon_16, district_icon_32, district_icon_260, district_number_of_stations, district_number_of_cases_now FROM $t_edb_districts_index WHERE district_id=$get_current_stats_district_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_district_id, $get_current_district_number, $get_current_district_title, $get_current_district_title_clean, $get_current_district_icon_path, $get_current_district_icon_16, $get_current_district_icon_32, $get_current_district_icon_260, $get_current_district_number_of_stations, $get_current_district_number_of_cases_now) = $row;
		if($get_current_district_id == ""){
			echo"<h1>Server error 404</h1><p>District not found</p>";
			die;
		}
		else{
			/*- Headers ---------------------------------------------------------------------------------- */
			$website_title = "$l_edb - $get_current_district_title - $l_statistics - $get_current_stats_month_saying $get_current_stats_year";
			if(file_exists("./favicon.ico")){ $root = "."; }
			elseif(file_exists("../favicon.ico")){ $root = ".."; }
			elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
			elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
			include("$root/_webdesign/header.php");
	
			// Me
			$my_user_id = $_SESSION['user_id'];
			$my_user_id = output_html($my_user_id);
			$my_user_id_mysql = quote_smart($link, $my_user_id);

			// Check that I am member of this district
			$query = "SELECT district_member_id, district_member_district_id, district_member_district_title, district_member_user_id, district_member_rank, district_member_user_name, district_member_user_alias, district_member_user_first_name, district_member_user_middle_name, district_member_user_last_name, district_member_user_email, district_member_user_image_path, district_member_user_image_file, district_member_user_image_thumb_40, district_member_user_image_thumb_50, district_member_user_image_thumb_60, district_member_user_image_thumb_200, district_member_user_position, district_member_user_department, district_member_user_location, district_member_user_about, district_member_added_datetime, district_member_added_date_saying, district_member_added_by_user_id, district_member_added_by_user_name, district_member_added_by_user_alias, district_member_added_by_user_image FROM $t_edb_districts_members WHERE district_member_district_id=$get_current_district_id AND district_member_user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_my_district_member_id, $get_my_district_member_district_id, $get_my_district_member_district_title, $get_my_district_member_user_id, $get_my_district_member_rank, $get_my_district_member_user_name, $get_my_district_member_user_alias, $get_my_district_member_user_first_name, $get_my_district_member_user_middle_name, $get_my_district_member_user_last_name, $get_my_district_member_user_email, $get_my_district_member_user_image_path, $get_my_district_member_user_image_file, $get_my_district_member_user_image_thumb_40, $get_my_district_member_user_image_thumb_50, $get_my_district_member_user_image_thumb_60, $get_my_district_member_user_image_thumb_200, $get_my_district_member_user_position, $get_my_district_member_user_department, $get_my_district_member_user_location, $get_my_district_member_user_about, $get_my_district_member_added_datetime, $get_my_district_member_added_date_saying, $get_my_district_member_added_by_user_id, $get_my_district_member_added_by_user_name, $get_my_district_member_added_by_user_alias, $get_my_district_member_added_by_user_image) = $row;

			if($get_my_district_member_id == ""){
				echo"
				<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> Please apply for access to this district..</h1>
				<meta http-equiv=\"refresh\" content=\"3;url=browse_districts_and_stations.php?action=apply_for_membership_to_district&amp;district_id=$get_current_district_id&amp;l=$l\">
				";
			} // access to district denied
			else{
				echo"
				<h1>$get_current_district_title $l_statistics</h1>
					
				<!-- Where am I ? -->
					<p><b>$l_you_are_here:</b><br />
					<a href=\"index.php?l=$l\">$l_edb</a>
					&gt;
					<a href=\"cases_board_1_view_district.php?district_id=$get_current_district_id&amp;l=$l\">$get_current_district_title</a>
					&gt;
					<a href=\"statistics_district.php?district_id=$get_current_district_id&amp;l=$l\">$l_statistics</a>
					&gt;
					<a href=\"statistics_district_month.php?stats_id=$get_current_stats_id&amp;l=$l\">$get_current_stats_month_saying $get_current_stats_year</a>
					</p>
					<div style=\"height: 10px;\"></div>
				<!-- //Where am I ? -->

				<!-- Feedback -->
					";
					if($ft != ""){
						if($fm == "changes_saved"){
							$fm = "$l_changes_saved";
						}
						else{
							$fm = ucfirst($fm);
							$fm = str_replace("_", " ", $fm);
						}
						echo"<div class=\"$ft\"><span>$fm</span></div>";
					}
					echo"	
				<!-- //Feedback -->

				<!-- Sparkline javascript -->
					<script src=\"$root/_admin/_javascripts/sparkline/jquery.sparkline.js\"></script>
				<!-- //Sparkline javascript -->


				<!-- Charts javascript -->
					<script src=\"$root/_admin/_javascripts/amcharts/amcharts/amcharts.js\"></script>
					<script src=\"$root/_admin/_javascripts/amcharts/amcharts/serial.js\"></script>
					<script src=\"$root/_admin/_javascripts/amcharts/amcharts/pie.js\" type=\"text/javascript\"></script>
				<!-- //Charts javascript -->

				<!-- Statuses :: New and closed per day of this month -->

						<table style=\"width: 100%;\">
						";
						$layout = 0;
						$query = "SELECT status_id, status_title, status_weight, status_gives_amount_of_points_to_user FROM $t_edb_case_statuses WHERE status_show_on_stats_page=1 ORDER BY status_weight ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_status_id, $get_status_title, $get_status_weight, $get_status_gives_amount_of_points_to_user) = $row;

							if($layout == 0){
								echo"
								 <tr>
								  <td style=\"width: 47%;vertical-align: top;padding-right: 3%;\">
								";
							}
							else{
								echo"
								  <td style=\"width: 47%;vertical-align: top;padding-right: 3%;\">
								";
							}
							echo"
							<h2>$get_status_title</h2>


							<script>
							var chart;
							var graph;
	
							var chartData$get_status_id = [";
							

							$x = 0;
							$query_b = "SELECT status_per_day_id, status_per_day_year, status_per_day_month, status_per_day_day, status_per_day_day_saying, status_per_day_district_id, status_per_day_station_id, status_per_day_user_id, status_per_day_status_id, status_per_day_status_title, status_per_day_weight, status_per_day_counter, status_per_day_avg_spent_time, status_per_day_avg_spent_days, status_per_day_avg_spent_saying FROM $t_edb_stats_statuses_per_day WHERE status_per_day_year=$get_current_stats_year AND status_per_day_month=$get_current_stats_month AND status_per_day_district_id=$get_current_stats_district_id AND status_per_day_status_id=$get_status_id ORDER BY status_per_day_day ASC";
							$result_b = mysqli_query($link, $query_b);
							while($row_b = mysqli_fetch_row($result_b)) {
								list($get_status_per_day_id, $get_status_per_day_year, $get_status_per_day_month, $get_status_per_day_day, $get_status_per_day_day_saying, $get_status_per_day_district_id, $get_status_per_day_station_id, $get_status_per_day_user_id, $get_status_per_day_status_id, $get_status_per_day_status_title, $get_status_per_day_weight, $get_status_per_day_counter, $get_status_per_day_avg_spent_time, $get_status_per_day_avg_spent_days, $get_status_per_day_avg_spent_saying) = $row_b;
	

								if($x > 0){
									echo",";
								}
								echo"
								{
									\"day\": \"$get_status_per_day_day_saying $get_status_per_day_day\",
									\"value\": $get_status_per_day_counter
								}";


								// xx
								$x++;

							}
							echo"
							];
							";
							if($x != 0){
								echo"
								AmCharts.ready(function () {
								// SERIAL CHART
								chart = new AmCharts.AmSerialChart();

								chart.dataProvider = chartData$get_status_id;
								chart.categoryField = \"day\";
								chart.dataDateFormat = \"dd\";
								chart.hideCredits = \"true\";

                						// Y value
                						var valueAxis = new AmCharts.ValueAxis();
               					 		valueAxis.axisAlpha = 0;
                						valueAxis.inside = true;
                						valueAxis.dashLength = 3;
                						chart.addValueAxis(valueAxis);

                						// X GRAPH
                						graph = new AmCharts.AmGraph();
                						graph.lineColor = \"#66d5c9\";
                						graph.negativeLineColor = \"#66d5c9\"; // this line makes the graph to change color when it drops below 0
						
                						graph.lineThickness = 2;
                						graph.valueField = \"value\";
                						graph.balloonText = \"[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>\";
                						chart.addGraph(graph);
	
                						// WRITE
                						chart.write(\"chartdiv_$get_status_id\");
           							});

								</script>
        							<div id=\"chartdiv_$get_status_id\" style=\"width:100%; height:180px;\"></div>
								";
							} // x != 0 (there is data)
							else{
								echo"
								</script>
								";
							}

							if($layout == 0){
								echo"
								  </td>
								";
								$layout = 1;
							}
							else{
								echo"
								  </td>
								 </tr>
								";
								$layout = 0;
							}
							
						} // while statuses
						if($layout == 0){
								echo"
								  <td>
								  </td>
								 </tr>
								</table>
								";
						}
						else{
								echo"
								</table>
								";

						}
						echo"
					<!-- //New and closed per day of this month -->


					<!-- Cases code, Cases priority, item types -->
						<table style=\"width: 100%;\">
						 <tr>
						  <td style=\"width:31%;vertical-align:top;padding-right: 40px;\">
							<!-- Case codes -->
								<div style=\"height: 50px;\"></div>
								<hr />
								<h2>$l_cases_codes</h2>

								<script>
          							var chart;
         							var legend;

								var chartDataCodes = [";
								$x = 0;
								$query = "SELECT stats_case_code_id, stats_case_code_year, stats_case_code_month, stats_case_code_district_id, stats_case_code_station_id, stats_case_code_user_id, stats_case_code_code_id, stats_case_code_code_title, stats_case_code_counter FROM $t_edb_stats_case_codes WHERE stats_case_code_year=$get_current_stats_year AND stats_case_code_month=$get_current_stats_month AND stats_case_code_district_id=$get_current_stats_district_id ORDER BY stats_case_code_counter DESC";
								$result = mysqli_query($link, $query);
								while($row = mysqli_fetch_row($result)) {
									list($get_stats_case_code_id, $get_stats_case_code_year, $get_stats_case_code_month, $get_stats_case_code_district_id, $get_stats_case_code_station_id, $get_stats_case_code_user_id, $get_stats_case_code_code_id, $get_stats_case_code_code_title, $get_stats_case_code_counter) = $row;

									if($x > 0){
										echo",";
									}
									$code_len = strlen($get_stats_case_code_code_title);
									if($code_len > 20){
										$get_stats_case_code_code_title = substr($get_stats_case_code_code_title, 0, 17);
									}
									echo"
									{
									\"code\": \"$get_stats_case_code_code_title\",
									\"value\": $get_stats_case_code_counter
									}";


									// x++
									$x++;
								}
								echo"
            							];
            							AmCharts.ready(function () {
            								// PIE CHART
            								chart = new AmCharts.AmPieChart();
									chart.hideCredits = \"true\";
            								chart.dataProvider = chartDataCodes;
            								chart.titleField = \"code\";
            								chart.valueField = \"value\";
            								chart.outlineColor = \"#FFFFFF\";
            								chart.outlineAlpha = 0.8;
            								chart.outlineThickness = 2;
            								chart.balloonText = \"[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>\";
									chart.startDuration = 0;
            								// WRITE
            								chart.write(\"chartdiv_codes\");
            							});
       								</script>
       								<div id=\"chartdiv_codes\" style=\"width: 100%; height: 400px;\"></div>



							<!-- //Case codes -->
						  </td>
						  <td style=\"width:31%;vertical-align:top;padding-right: 40px;\">
							<div style=\"height: 50px;\"></div>
							<hr />
							<h2>$l_cases_priority</h2>
							<!-- How many of diffrent priorites this month -->

								<script>
          							var chart;
         							var legend;

								var chartDataPriorities = [";
								$x = 0;
								$query = "SELECT stats_case_priority_id, stats_case_priority_year, stats_case_priority_month, stats_case_priority_district_id, stats_case_priority_station_id, stats_case_priority_user_id, stats_case_priority_priority_id, stats_case_priority_priority_title, stats_case_priority_counter FROM $t_edb_stats_case_priorites WHERE stats_case_priority_year=$get_current_stats_year AND stats_case_priority_month=$get_current_stats_month AND stats_case_priority_district_id=$get_current_stats_district_id ORDER BY stats_case_priority_counter DESC";
								$result = mysqli_query($link, $query);
								while($row = mysqli_fetch_row($result)) {
									list($get_stats_case_priority_id, $get_stats_case_priority_year, $get_stats_case_priority_month, $get_stats_case_priority_district_id, $get_stats_case_priority_station_id, $get_stats_case_priority_user_id, $get_stats_case_priority_priority_id, $get_stats_case_priority_priority_title, $get_stats_case_priority_counter) = $row;

									$get_stats_case_priority_priority_title = str_replace("&oslash;", "ø", $get_stats_case_priority_priority_title);
									if($x > 0){
										echo",";
									}
									echo"
									{
									\"priority\": \"$get_stats_case_priority_priority_title\",
									\"value\": $get_stats_case_priority_counter
									}";


									// x++
									$x++;
								}
								echo"
            							];
            							AmCharts.ready(function () {
            								// PIE CHART
            								chart = new AmCharts.AmPieChart();
									chart.hideCredits = \"true\";
            								chart.dataProvider = chartDataPriorities;
            								chart.titleField = \"priority\";
            								chart.valueField = \"value\";
            								chart.outlineColor = \"#FFFFFF\";
            								chart.outlineAlpha = 0.8;
            								chart.outlineThickness = 2;
            								chart.balloonText = \"[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>\";
									chart.startDuration = 0;
            								// WRITE
            								chart.write(\"chartdiv_priorities\");
            							});
       								</script>
       								<div id=\"chartdiv_priorities\" style=\"width: 100%; height: 400px;\"></div>


						  </td>
						  <td style=\"width:31%;vertical-align:top;padding-right: 40px;\">
							<div style=\"height: 50px;\"></div>
							<hr />
							<h2>$l_item_types_headline</h2>
							<!-- How many of diffrent item types this month -->

								<script>
          							var chart;
         							var legend;

								var chartDataItemTypes = [";
								$x = 0;
								$query = "SELECT stats_item_type_id, stats_item_type_year, stats_item_type_month, stats_item_type_district_id, stats_item_type_station_id, stats_item_type_user_id, stats_item_type_item_type_id, stats_item_type_item_type_title, stats_item_type_line_color, stats_item_type_fill_color, stats_item_type_counter FROM $t_edb_stats_item_types WHERE stats_item_type_year=$get_current_stats_year AND stats_item_type_month=$get_current_stats_month AND stats_item_type_district_id=$get_current_stats_district_id ORDER BY stats_item_type_counter DESC";
								$result = mysqli_query($link, $query);
								while($row = mysqli_fetch_row($result)) {
									list($get_stats_item_type_id, $get_stats_item_type_year, $get_stats_item_type_month, $get_stats_item_type_district_id, $get_stats_item_type_station_id, $get_stats_item_type_user_id, $get_stats_item_type_item_type_id, $get_stats_item_type_item_type_title, $get_stats_item_type_line_color, $get_stats_item_type_fill_color, $get_stats_item_type_counter) = $row;

									if($get_stats_item_type_item_type_title == ""){
										// No name, we dont need statistics over no names, just unlink
										
										$result_delete = mysqli_query($link, "DELETE FROM $t_edb_stats_item_types 
														WHERE stats_item_type_id=$get_stats_item_type_id") or die(mysqli_error($link));
									}

									if($x > 0){
										echo",";
									}
									echo"
									{
									\"priority\": \"$get_stats_item_type_item_type_title\",
									\"value\": $get_stats_item_type_counter
									}";


									// x++
									$x++;
								}
								echo"
            							];
            							AmCharts.ready(function () {
            								// PIE CHART
            								chart = new AmCharts.AmPieChart();
									chart.hideCredits = \"true\";
            								chart.dataProvider = chartDataItemTypes;
            								chart.titleField = \"priority\";
            								chart.valueField = \"value\";
            								chart.outlineColor = \"#FFFFFF\";
            								chart.outlineAlpha = 0.8;
            								chart.outlineThickness = 2;
            								chart.balloonText = \"[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>\";
									chart.startDuration = 0;
            								// WRITE
            								chart.write(\"chartdiv_item_types\");
            							});
       								</script>
       								<div id=\"chartdiv_item_types\" style=\"width: 100%; height: 400px;\"></div>
							<!-- //How many of diffrent item types this month -->
						  </td>
						 </tr>
						</table>
					<!-- //Cases code and Cases priority -->


					<!-- Time used per status -->
						<div style=\"height: 50px;\"></div>
						<hr />
						<h2>$l_time_spent_per_status ($l_days_lowercase)</h2>
						<div style=\"height: 10px;\"></div>
						<table class=\"hor-zebra\">
						 <thead>
						  <tr>
							   <th scope=\"col\">
								
						 	   </th>";
						$avg_days_spent_total_sum = 0;
						$days_in_month = date('t',mktime(0,0,0,$get_current_stats_month,1,$get_current_stats_year));
						for($x=1;$x<$days_in_month+1;$x++){
							$date = $get_current_stats_year . "-" . $get_current_stats_month . "-" . $x;
							$dayofweek = date('D', strtotime($date));
							echo"
							   <th scope=\"col\" style=\"text-align:center;\">
								<span>$dayofweek<br />$x</span>
						 	   </th>
							";

						}
						echo"
							   <th scope=\"col\" style=\"text-align:center;\">
								<span>$l_avg_sum</span>
						 	   </th>
						  </tr>
						 </thead>
						 <tbody>
						";
						// 1. List all statuses
						// 
						//
						$avg_days_spent_per_status_sum_array = array();
						$query = "SELECT status_id, status_title, status_weight, status_gives_amount_of_points_to_user FROM $t_edb_case_statuses ORDER BY status_weight ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_status_id, $get_status_title, $get_status_weight, $get_status_gives_amount_of_points_to_user) = $row;

							if(isset($odd) && $odd == false){
								$odd = true;
							}
							else{
								$odd = false;
							}

							echo"
							  <tr>
							   <td "; if($odd == true){ echo" class=\"odd\""; } echo">
								<span>$get_status_title</span>
						 	   </td>";

							$avg_days_spent_per_status_sum_array[$get_status_id] = 0;
							for($x=1;$x<$days_in_month+1;$x++){
								$query_c = "SELECT status_per_day_id, status_per_day_counter, status_per_day_avg_spent_time, status_per_day_avg_spent_days, status_per_day_avg_spent_saying FROM $t_edb_stats_statuses_per_day WHERE status_per_day_year=$get_current_stats_year AND status_per_day_month=$get_current_stats_month AND status_per_day_day=$x AND status_per_day_district_id=$get_current_district_id AND status_per_day_status_id=$get_status_id";
								$result_c = mysqli_query($link, $query_c);
								$row_c = mysqli_fetch_row($result_c);
								list($get_status_per_day_id, $get_status_per_day_counter, $get_status_per_day_avg_spent_time, $get_status_per_day_avg_spent_days, $get_status_per_day_avg_spent_saying) = $row_c;

								echo"
							  	  <td "; if($odd == true){ echo" class=\"odd\""; } echo" style=\"text-align:center;\">
									<span>$get_status_per_day_avg_spent_saying</span>
						 		  </td>
								";


								$avg_days_spent_per_status_sum_array[$get_status_id] = $avg_days_spent_per_status_sum_array[$get_status_id]+$get_status_per_day_avg_spent_saying;
								$avg_days_spent_total_sum = $avg_days_spent_total_sum+$get_status_per_day_avg_spent_saying;
							}
							echo"
							   <td "; if($odd == true){ echo" class=\"odd\""; } echo" style=\"text-align:center;\">
								<span><em>$avg_days_spent_per_status_sum_array[$get_status_id]</em></span>
						 	   </td>
							  </tr>
							";
						}


						if(isset($odd) && $odd == false){
							$odd = true;
						}
						else{
							$odd = false;
						}
						echo"
						  <tr>
						    <td "; if($odd == true){ echo" class=\"odd\""; } echo" style=\"text-align:center;\">
								
						    </td>
						";
						for($x=1;$x<$days_in_month+1;$x++){
							echo"
							    <td "; if($odd == true){ echo" class=\"odd\""; } echo" style=\"text-align:center;\">
								
						 	   </td>
							";
						}
						echo"
							    <td "; if($odd == true){ echo" class=\"odd\""; } echo" style=\"text-align:center;\">
								<span><b>$avg_days_spent_total_sum</b></span>
						 	   </td>
						  </tr>
						 </tbody>
						</table>

					<!-- //Time used per status -->

					<!-- Employee of the month -->
						<div style=\"height: 50px;\"></div>
						<hr />
						<h2>$l_employee_of_the_month</h2>
						<div style=\"height: 10px;\"></div>
						<table class=\"hor-zebra\">
						 <thead>
						  <tr>
						   <th scope=\"col\">
							<span>$l_name</span>
						   </th>
						   <th scope=\"col\" style=\"text-align:center;\">
							<span>$l_acquirements<br />1 $l_points_lowercase</span>
						   </th>
						";

						// 1. List all employees and then points
						// 
						//
						$query = "SELECT status_id, status_title, status_weight, status_gives_amount_of_points_to_user FROM $t_edb_case_statuses ORDER BY status_weight ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_status_id, $get_status_title, $get_status_weight, $get_status_gives_amount_of_points_to_user) = $row;

							echo"
							   <th scope=\"col\" style=\"text-align:center;\">
								<span>$get_status_title<br />$get_status_gives_amount_of_points_to_user $l_points_lowercase</span>
						 	   </th>
							";
						}
						echo"
							   <th scope=\"col\" style=\"text-align:center;\">
								<span>$l_sum</span>
						 	   </th>
						  </tr>
						 </thead>
						";

						// District Members
						$employee_of_the_month_user_id = 0;
						$employee_of_the_month_points = 0;

						$query = "SELECT district_member_id, district_member_district_id, district_member_district_title, district_member_user_id, district_member_rank, district_member_user_name, district_member_user_alias, district_member_user_first_name, district_member_user_middle_name, district_member_user_last_name, district_member_user_email, district_member_user_image_path, district_member_user_image_file, district_member_user_image_thumb_40, district_member_user_image_thumb_50, district_member_user_image_thumb_60, district_member_user_image_thumb_200, district_member_user_position, district_member_user_department, district_member_user_location, district_member_user_about, district_member_show_on_board, district_member_added_datetime, district_member_added_date_saying, district_member_added_by_user_id, district_member_added_by_user_name, district_member_added_by_user_alias, district_member_added_by_user_image FROM $t_edb_districts_members WHERE district_member_show_on_board=1 ORDER BY district_member_user_name ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_district_member_id, $get_district_member_district_id, $get_district_member_district_title, $get_district_member_user_id, $get_district_member_rank, $get_district_member_user_name, $get_district_member_user_alias, $get_district_member_user_first_name, $get_district_member_user_middle_name, $get_district_member_user_last_name, $get_district_member_user_email, $get_district_member_user_image_path, $get_district_member_user_image_file, $get_district_member_user_image_thumb_40, $get_district_member_user_image_thumb_50, $get_district_member_user_image_thumb_60, $get_district_member_user_image_thumb_200, $get_district_member_user_position, $get_district_member_user_department, $get_district_member_user_location, $get_district_member_user_about, $get_district_member_show_on_board, $get_district_member_added_datetime, $get_district_member_added_date_saying, $get_district_member_added_by_user_id, $get_district_member_added_by_user_name, $get_district_member_added_by_user_alias, $get_district_member_added_by_user_image) = $row;


							if(isset($odd) && $odd == false){
								$odd = true;
							}
							else{
								$odd = false;
							}

							echo"
							<tr>
							  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
								<span><a href=\"view_profile_and_update_profile_link.php?user_id=$get_district_member_user_id&amp;l=$l&amp;process=1\" style=\"color: #000\">";
								if($get_district_member_user_first_name != ""){
									echo"$get_district_member_user_first_name $get_district_member_user_middle_name $get_district_member_user_last_name";
								}
								else{
									echo"$get_district_member_user_name";
								}
								echo"</a></span>
							 </td>";

							$points_total = 0;


							// Acquirements
							$query_acquirements = "SELECT acquirements_per_month_id, acquirements_per_month_year, acquirements_per_month_month, acquirements_per_month_counter, acquirements_per_month_district_id, acquirements_per_month_district_title, acquirements_per_month_station_id, acquirements_per_month_station_title, acquirements_per_month_user_id, acquirements_per_month_user_name, acquirements_per_month_size_bytes, acquirements_per_month_size_human FROM $t_edb_stats_acquirements_per_month WHERE acquirements_per_month_year=$get_current_stats_year AND acquirements_per_month_month=$get_current_stats_month AND acquirements_per_month_user_id=$get_district_member_user_id";
							$result_acquirements = mysqli_query($link, $query_acquirements);
							$row_acquirements = mysqli_fetch_row($result_acquirements);
							list($get_acquirements_per_month_id, $get_acquirements_per_month_year, $get_acquirements_per_month_month, $get_acquirements_per_month_counter, $get_acquirements_per_month_district_id, $get_acquirements_per_month_district_title, $get_acquirements_per_month_station_id, $get_acquirements_per_month_station_title, $get_acquirements_per_month_user_id, $get_acquirements_per_month_user_name, $get_acquirements_per_month_size_bytes, $get_acquirements_per_month_size_human) = $row_acquirements;
							if($get_acquirements_per_month_counter == ""){ $get_acquirements_per_month_counter = "0"; }
							$points_total = $points_total+$get_acquirements_per_month_counter;

							echo"
								  <td"; if($odd == true){ echo" class=\"odd\""; } echo" style=\"text-align:center;\">
									<span>$get_acquirements_per_month_counter</span>
								  </td>
							";


							$query_b = "SELECT status_id, status_title, status_weight, status_gives_amount_of_points_to_user FROM $t_edb_case_statuses ORDER BY status_weight ASC";
							$result_b = mysqli_query($link, $query_b);
							while($row_b = mysqli_fetch_row($result_b)) {
								list($get_status_id, $get_status_title, $get_status_weight, $get_status_gives_amount_of_points_to_user) = $row_b;


								$query_c = "SELECT SUM(status_per_day_counter) FROM $t_edb_stats_statuses_per_day WHERE status_per_day_year=$get_current_stats_year AND status_per_day_month=$get_current_stats_month AND status_per_day_user_id=$get_district_member_user_id AND status_per_day_status_id=$get_status_id";
								$result_c = mysqli_query($link, $query_c);
								$row_c = mysqli_fetch_row($result_c);
								list($get_status_per_day_counter) = $row_c;


								$points_this = $get_status_per_day_counter*$get_status_gives_amount_of_points_to_user;
								echo"
								  <td"; if($odd == true){ echo" class=\"odd\""; } echo" style=\"text-align:center;\">
									";
									if($points_this != 0){
										echo"<span>$points_this</span>";
									}
									echo"
								  </td>
								";

								$points_total = $points_total+$points_this;
							}
							echo"
							  <td"; if($odd == true){ echo" class=\"odd\""; } echo" style=\"text-align:center;\">
								<span><em>$points_total</em></span>
							 </td>
							</tr>
							";

							// Employee of the month?
							if($employee_of_the_month_points < $points_total){
								$employee_of_the_month_points = $points_total;
								$employee_of_the_month_user_id = $get_district_member_user_id;
							}
						}
						echo"
						 <tbody>
						 </tbody>
						</table>
						";

						// Employee of the month table
						$query_c = "SELECT employee_of_the_month_id, employee_of_the_month_year, employee_of_the_month_month, employee_of_the_month_saying, employee_of_the_month_district_id, employee_of_the_month_station_id, employee_of_the_month_points, employee_of_the_month_user_id, employee_of_the_month_user_name, employee_of_the_month_user_alias, employee_of_the_month_user_first_name, employee_of_the_month_user_middle_name, employee_of_the_month_user_last_name, employee_of_the_month_user_email, employee_of_the_month_user_image_path, employee_of_the_month_user_image_file, employee_of_the_month_user_image_thumb_40, employee_of_the_month_user_image_thumb_50, employee_of_the_month_user_image_thumb_200 FROM $t_edb_stats_employee_of_the_month WHERE employee_of_the_month_year=$get_current_stats_year AND employee_of_the_month_month=$get_current_stats_month AND employee_of_the_month_district_id=$get_current_stats_district_id";	
						$result_c = mysqli_query($link, $query_c);
						$row_c = mysqli_fetch_row($result_c);
						list($get_employee_of_the_month_id, $get_employee_of_the_month_year, $get_employee_of_the_month_month, $get_employee_of_the_month_saying, $get_employee_of_the_month_district_id, $get_employee_of_the_month_station_id, $get_employee_of_the_month_points, $get_employee_of_the_month_user_id, $get_employee_of_the_month_user_name, $get_employee_of_the_month_user_alias, $get_employee_of_the_month_user_first_name, $get_employee_of_the_month_user_middle_name, $get_employee_of_the_month_user_last_name, $get_employee_of_the_month_user_email, $get_employee_of_the_month_user_image_path, $get_employee_of_the_month_user_image_file, $get_employee_of_the_month_user_image_thumb_40, $get_employee_of_the_month_user_image_thumb_50, $get_employee_of_the_month_user_image_thumb_200) = $row_c;
						if($get_employee_of_the_month_id == "" && $employee_of_the_month_user_id != "0"){
							// Insert employee of the month
							$inp_month_saying_mysql = quote_smart($link, $get_current_stats_month_saying);
							mysqli_query($link, "INSERT INTO $t_edb_stats_employee_of_the_month 
							(employee_of_the_month_id, employee_of_the_month_year, employee_of_the_month_month, employee_of_the_month_saying, employee_of_the_month_district_id, employee_of_the_month_station_id) 
							VALUES 
							(NULL, $get_current_stats_year, $get_current_stats_month, $inp_month_saying_mysql, $get_current_stats_district_id, NULL)")
							or die(mysqli_error($link));

							$query_c = "SELECT employee_of_the_month_id, employee_of_the_month_year, employee_of_the_month_month, employee_of_the_month_saying, employee_of_the_month_district_id, employee_of_the_month_station_id, employee_of_the_month_points, employee_of_the_month_user_id, employee_of_the_month_user_name, employee_of_the_month_user_alias, employee_of_the_month_user_first_name, employee_of_the_month_user_middle_name, employee_of_the_month_user_last_name, employee_of_the_month_user_email, employee_of_the_month_user_image_path, employee_of_the_month_user_image_file, employee_of_the_month_user_image_thumb_40, employee_of_the_month_user_image_thumb_50 FROM $t_edb_stats_employee_of_the_month WHERE employee_of_the_month_year=$get_current_stats_year AND employee_of_the_month_month=$get_current_stats_month AND employee_of_the_month_district_id=$get_current_stats_district_id";	
							$result_c = mysqli_query($link, $query_c);
							$row_c = mysqli_fetch_row($result_c);
							list($get_employee_of_the_month_id, $get_employee_of_the_month_year, $get_employee_of_the_month_month, $get_employee_of_the_month_saying, $get_employee_of_the_month_district_id, $get_employee_of_the_month_station_id, $get_employee_of_the_month_points, $get_employee_of_the_month_user_id, $get_employee_of_the_month_user_name, $get_employee_of_the_month_user_alias, $get_employee_of_the_month_user_first_name, $get_employee_of_the_month_user_middle_name, $get_employee_of_the_month_user_last_name, $get_employee_of_the_month_user_email, $get_employee_of_the_month_user_image_path, $get_employee_of_the_month_user_image_file, $get_employee_of_the_month_user_image_thumb_40, $get_employee_of_the_month_user_image_thumb_50) = $row_c;
						}

						if($employee_of_the_month_user_id != "$get_employee_of_the_month_user_id"){
							// Update row
							$query = "SELECT user_id, user_email, user_name, user_alias, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_id=$employee_of_the_month_user_id";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_employee_user_id, $get_employee_user_email, $get_employee_user_name, $get_employee_user_alias, $get_employee_user_language, $get_employee_user_last_online, $get_employee_user_rank, $get_employee_user_login_tries) = $row;
					
							// My photo
							$query = "SELECT photo_id, photo_destination, photo_thumb_40, photo_thumb_50, photo_thumb_200 FROM $t_users_profile_photo WHERE photo_user_id=$get_employee_user_id AND photo_profile_image='1'";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_employee_photo_id, $get_employee_photo_destination, $get_employee_photo_thumb_40, $get_employee_photo_thumb_50, $get_employee_photo_thumb_200) = $row;

							// My Profile
							$query = "SELECT profile_id, profile_first_name, profile_middle_name, profile_last_name, profile_about FROM $t_users_profile WHERE profile_user_id=$get_employee_user_id";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_employee_profile_id, $get_employee_profile_first_name, $get_employee_profile_middle_name, $get_employee_profile_last_name, $get_employee_profile_about) = $row;

							$inp_employee_user_name_mysql = quote_smart($link, $get_employee_user_name);
							$inp_employee_user_alias_mysql = quote_smart($link, $get_employee_user_alias);
							$inp_employee_user_email_mysql = quote_smart($link, $get_employee_user_email);

							$inp_employee_user_image_path = "_uploads/users/images/$get_employee_user_id";
							$inp_employee_user_image_path_mysql = quote_smart($link, $inp_employee_user_image_path);

							$inp_employee_user_image_file_mysql = quote_smart($link, $get_employee_photo_destination);

							$inp_employee_user_image_thumb_a_mysql = quote_smart($link, $get_employee_photo_thumb_40);
							$inp_employee_user_image_thumb_b_mysql = quote_smart($link, $get_employee_photo_thumb_50);
							$inp_employee_user_image_thumb_c_mysql = quote_smart($link, $get_employee_photo_thumb_200);

							$inp_employee_user_first_name_mysql = quote_smart($link, $get_employee_profile_first_name);
							$inp_employee_user_middle_name_mysql = quote_smart($link, $get_employee_profile_middle_name);
							$inp_employee_user_last_name_mysql = quote_smart($link, $get_employee_profile_last_name);



							$result = mysqli_query($link, "UPDATE $t_edb_stats_employee_of_the_month SET 
											employee_of_the_month_points=$employee_of_the_month_points,
											employee_of_the_month_user_id=$employee_of_the_month_user_id, 
											employee_of_the_month_user_name=$inp_employee_user_name_mysql, 
											employee_of_the_month_user_alias=$inp_employee_user_alias_mysql, 
											employee_of_the_month_user_first_name=$inp_employee_user_first_name_mysql, 
											employee_of_the_month_user_middle_name=$inp_employee_user_middle_name_mysql, 
											employee_of_the_month_user_last_name=$inp_employee_user_last_name_mysql, 
											employee_of_the_month_user_email=$inp_employee_user_email_mysql, 
											employee_of_the_month_user_image_path=$inp_employee_user_image_path_mysql, 
											employee_of_the_month_user_image_file=$inp_employee_user_image_file_mysql, 
											employee_of_the_month_user_image_thumb_40=$inp_employee_user_image_thumb_a_mysql, 
											employee_of_the_month_user_image_thumb_50=$inp_employee_user_image_thumb_b_mysql,
											employee_of_the_month_user_image_thumb_200=$inp_employee_user_image_thumb_c_mysql
											WHERE employee_of_the_month_id=$get_employee_of_the_month_id") or die(mysqli_error($link));

							$query_c = "SELECT employee_of_the_month_id, employee_of_the_month_year, employee_of_the_month_month, employee_of_the_month_saying, employee_of_the_month_district_id, employee_of_the_month_station_id, employee_of_the_month_points, employee_of_the_month_user_id, employee_of_the_month_user_name, employee_of_the_month_user_alias, employee_of_the_month_user_first_name, employee_of_the_month_user_middle_name, employee_of_the_month_user_last_name, employee_of_the_month_user_email, employee_of_the_month_user_image_path, employee_of_the_month_user_image_file, employee_of_the_month_user_image_thumb_40, employee_of_the_month_user_image_thumb_50, employee_of_the_month_user_image_thumb_200 FROM $t_edb_stats_employee_of_the_month WHERE employee_of_the_month_year=$get_current_stats_year AND employee_of_the_month_month=$get_current_stats_month AND employee_of_the_month_district_id=$get_current_stats_district_id";	
							$result_c = mysqli_query($link, $query_c);
							$row_c = mysqli_fetch_row($result_c);
							list($get_employee_of_the_month_id, $get_employee_of_the_month_year, $get_employee_of_the_month_month, $get_employee_of_the_month_saying, $get_employee_of_the_month_district_id, $get_employee_of_the_month_station_id, $get_employee_of_the_month_points, $get_employee_of_the_month_user_id, $get_employee_of_the_month_user_name, $get_employee_of_the_month_user_alias, $get_employee_of_the_month_user_first_name, $get_employee_of_the_month_user_middle_name, $get_employee_of_the_month_user_last_name, $get_employee_of_the_month_user_email, $get_employee_of_the_month_user_image_path, $get_employee_of_the_month_user_image_file, $get_employee_of_the_month_user_image_thumb_40, $get_employee_of_the_month_user_image_thumb_50, $get_employee_of_the_month_user_image_thumb_200) = $row_c;

						}

						// Show
						if($get_employee_of_the_month_user_id != "" && $get_employee_of_the_month_user_id != "0"){
							echo"	
							<div style=\"height: 20px;\"></div>
							<table>
							 <tr>
							  <td style=\"padding: 35px 10px 0px 0px;\">
								<p><img src=\"_gfx/employee_of_the_month_badge/employee_of_the_month_badge.png\" alt=\"employee_of_the_month_badge.png\" /></p>
							  </td>
							  <td style=\"padding: 0px 10px 0px 0px;text-align:center;vertical-align:top;\">
								<h3 style=\"font: 20px normal Georgia;color: black;margin:0;padding:0;\">$get_employee_of_the_month_saying  $get_employee_of_the_month_year</h3>
								<h3 style=\"font: 26px normal Georgia;color: black;margin:0;padding:0;\">$get_current_district_title</h3>
								";

								if(file_exists("$root/$get_employee_of_the_month_user_image_path/$get_employee_of_the_month_user_image_thumb_200") && $get_employee_of_the_month_user_image_thumb_200 != ""){
									echo"
									<a href=\"$root/users/view_profile.php?user_id=$get_employee_of_the_month_user_id&amp;l=$l\"><img src=\"$root/$get_employee_of_the_month_user_image_path/$get_employee_of_the_month_user_image_thumb_200\" alt=\"$get_employee_of_the_month_user_image_thumb_200\" style=\"border-radius: 10%;\" /></a><br />
									";
								}
								echo" 
								<p style=\"padding-top: 0px;margin-top:0px;\">
								<a href=\"$root/users/view_profile.php?user_id=$get_employee_of_the_month_user_id&amp;l=$l\" style=\"font: 28px normal Georgia;color: black;\">$get_employee_of_the_month_user_first_name  $get_employee_of_the_month_user_middle_name  $get_employee_of_the_month_user_last_name</a>
								</p>
								
							  </td>
							  <td style=\"padding: 35px 0px 0px 0px;\">
								<p><img src=\"_gfx/employee_of_the_month_badge/employee_of_the_month_badge.png\" alt=\"employee_of_the_month_badge.png\" /></p>
							  </td>
							 </tr>
							</table>
							";
						}
						echo"
					<!-- //Employee of the month -->


					<!-- item_requester department -->
						<div style=\"height: 50px;\"></div>
						<hr />
						<h2>$l_requests_per_locations_headline</h2>


						<!-- requester department javascript -->
							<script>
							var chart;
							var graph;
	
							var chartDataRequesterDepartments = [";

							$x = 0;
							$query = "SELECT stats_req_dep_id, stats_req_dep_year, stats_req_dep_month, stats_req_dep_district_id, stats_req_dep_station_id, stats_req_dep_department, stats_req_dep_location, stats_req_dep_counter FROM $t_edb_stats_requests_department_per_month WHERE stats_req_dep_district_id=$get_current_district_id ORDER BY stats_req_dep_counter ASC";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_stats_req_dep_id, $get_stats_req_dep_year, $get_stats_req_dep_month, $get_stats_req_dep_district_id, $get_stats_req_dep_station_id, $get_stats_req_dep_department, $get_stats_req_dep_location, $get_stats_req_dep_counter) = $row;

									if($x > 0){
										echo",";
									}
									echo"
									{
										\"department\": \"$get_stats_req_dep_department $get_stats_req_dep_location<br>$get_stats_req_dep_counter\",
										\"value\": $get_stats_req_dep_counter
									}";


									// xx
									$x++;

							}
							
							echo"
							];
							";
							if($x != 0){
								echo"
								
								AmCharts.ready(function () {
									// SERIAL CHART
									chart = new AmCharts.AmSerialChart();

									chart.dataProvider = chartDataRequesterDepartments;
									chart.categoryField = \"department\";
									chart.hideCredits = \"true\";

                							// Y value
                							var valueAxis = new AmCharts.ValueAxis();
               					 			valueAxis.axisAlpha = 0;
                							valueAxis.inside = true;
                							valueAxis.dashLength = 3;
                							chart.addValueAxis(valueAxis);

                							// X GRAPH
                							graph = new AmCharts.AmGraph();
                							graph.lineColor = \"#66d5c9\";
                							graph.negativeLineColor = \"#66d5c9\"; // this line makes the graph to change color when it drops below 0
						 			graph.type = \"column\";
									graph.lineAlpha = 1;
									graph.lineColor = \"#66d5c9\";
									graph.fillColors = \"#99e4dc\";
									graph.fillAlphas = 1;
                							graph.valueField = \"value\";
                							graph.balloonText = \"[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>\";
                							chart.addGraph(graph);

	
                							// WRITE
                							chart.write(\"chartdiv_stats_requests_department_per_month\");
           							});

								</script>
        							<div id=\"chartdiv_stats_requests_department_per_month\" style=\"width:100%; height:180px;\"></div>
								";
							} // x != 0 (there is data)
							else{
								echo"
								</script>
								";
							}
							echo"
						<!-- //requester department javascript -->

					<!-- item_requester department -->


					<!-- requests_per_locations_with_case_codes_headline -->
						<div style=\"height: 50px;\"></div>
						<hr />
						<h2>$l_requests_per_locations_with_case_codes_headline</h2>


						<!-- requester department javascript -->";
							$script_chart_data = "
							<script>
           						var chart;

	
							var chartDataRequesterDepartmentsCaseCodes = [";

							$x = 0;
							$script_graphs = "";
							$query = "SELECT stats_req_dep_id, stats_req_dep_year, stats_req_dep_month, stats_req_dep_district_id, stats_req_dep_station_id, stats_req_dep_department, stats_req_dep_location, stats_req_dep_counter FROM $t_edb_stats_requests_department_per_month WHERE stats_req_dep_district_id=$get_current_district_id ORDER BY stats_req_dep_counter ASC";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_stats_req_dep_id, $get_stats_req_dep_year, $get_stats_req_dep_month, $get_stats_req_dep_district_id, $get_stats_req_dep_station_id, $get_stats_req_dep_department, $get_stats_req_dep_location, $get_stats_req_dep_counter) = $row;

								if($x > 0){
									$script_chart_data = $script_chart_data . ",";
								}
								$script_chart_data = $script_chart_data . "
								{
									\"department\": \"$get_stats_req_dep_department $get_stats_req_dep_location\"";
								// Find case codes
								$department_mysql = quote_smart($link, $get_stats_req_dep_department);
								$location_mysql = quote_smart($link, $get_stats_req_dep_location);
								$query_sub = "SELECT stats_dep_case_code_id, stats_dep_case_code_year, stats_dep_case_code_month, stats_dep_case_code_district_id, stats_dep_case_code_station_id, stats_dep_case_code_department, stats_dep_case_code_location, stats_dep_case_code_case_code_id, stats_dep_case_code_case_code_number, stats_dep_case_code_case_code_title, stats_dep_case_code_counter FROM $t_edb_stats_requests_department_case_codes_per_month WHERE stats_dep_case_code_year=$get_current_stats_year AND stats_dep_case_code_month=$get_current_stats_month AND stats_dep_case_code_district_id=$get_current_district_id AND stats_dep_case_code_department=$department_mysql AND stats_dep_case_code_location=$location_mysql ORDER BY stats_dep_case_code_case_code_number ASC";
								$result_sub = mysqli_query($link, $query_sub);
								while($row_sub = mysqli_fetch_row($result_sub)) {
									list($get_stats_dep_case_code_id, $get_stats_dep_case_code_year, $get_stats_dep_case_code_month, $get_stats_dep_case_code_district_id, $get_stats_dep_case_code_station_id, $get_stats_dep_case_code_department, $get_stats_dep_case_code_location, $get_stats_dep_case_code_case_code_id, $get_stats_dep_case_code_case_code_number, $get_stats_dep_case_code_case_code_title, $get_stats_dep_case_code_counter) = $row_sub;

									$script_chart_data = $script_chart_data . ",\n";
									$script_chart_data = $script_chart_data . "									";
									$script_chart_data = $script_chart_data . "\"case_code_$get_stats_dep_case_code_case_code_number\": $get_stats_dep_case_code_counter";
								}

								$script_chart_data = $script_chart_data . "\n";
								$script_chart_data = $script_chart_data . "								";
								$script_chart_data = $script_chart_data . "}";

								$x++;
							}
							
							echo"$script_chart_data 
							];
							";
							if($x != 0){
								echo"
								 AmCharts.ready(function () {
               								// SERIAL CHART
									chart = new AmCharts.AmSerialChart();
									chart.dataProvider = chartDataRequesterDepartmentsCaseCodes;
									chart.categoryField = \"department\";
									chart.startDuration = 1;
									chart.plotAreaBorderColor = \"#DADADA\";
									chart.plotAreaBorderAlpha = 1;
									chart.hideCredits = \"true\";

									// AXES
									// Category
									var categoryAxis = chart.categoryAxis;
									categoryAxis.gridPosition = \"start\";
									categoryAxis.gridAlpha = 0.1;
									categoryAxis.axisAlpha = 0;

									// Value
									var valueAxis = new AmCharts.ValueAxis();
									valueAxis.axisAlpha = 0;
									valueAxis.gridAlpha = 0.1;
									valueAxis.position = \"top\";
									chart.addValueAxis(valueAxis);


									";
									// Case code craphs
									$y = 1;
	 								$query_sub = "SELECT DISTINCT stats_dep_case_code_case_code_id, stats_dep_case_code_case_code_number, stats_dep_case_code_case_code_title, stats_dep_case_code_priority_id, stats_dep_case_code_priority_title, stats_dep_case_code_line_color, stats_dep_case_code_fill_color FROM $t_edb_stats_requests_department_case_codes_per_month WHERE stats_dep_case_code_year=$get_current_stats_year AND stats_dep_case_code_month=$get_current_stats_month AND stats_dep_case_code_district_id=$get_current_district_id ORDER BY stats_dep_case_code_case_code_number ASC";
									$result_sub = mysqli_query($link, $query_sub);
									while($row_sub = mysqli_fetch_row($result_sub)) {
										list($get_stats_dep_case_code_case_code_id, $get_stats_dep_case_code_case_code_number, $get_stats_dep_case_code_case_code_title, $get_stats_dep_case_code_priority_id, $get_stats_dep_case_code_priority_title, $get_stats_dep_case_code_line_color, $get_stats_dep_case_code_fill_color) = $row_sub;

										// Priority empty check
										if($get_stats_dep_case_code_priority_id == "" OR $get_stats_dep_case_code_line_color == ""){
											$query_code = "SELECT code_id, code_number, code_title, code_title_clean, code_title_abbr, code_is_active, code_valid_from_date, code_valid_from_time, code_valid_to_date, code_valid_to_time, code_gives_priority_id, code_gives_priority_title, code_last_used_datetime, code_last_used_time, code_times_used, code_line_color_graph, code_fill_color_graph FROM $t_edb_case_codes WHERE code_id=$get_stats_dep_case_code_case_code_id";
											$result_code = mysqli_query($link, $query_code);
											$row_code = mysqli_fetch_row($result_code);
											list($get_code_id, $get_code_number, $get_code_title, $get_code_title_clean, $get_code_title_abbr, $get_code_is_active, $get_code_valid_from_date, $get_code_valid_from_time, $get_code_valid_to_date, $get_code_valid_to_time, $get_code_gives_priority_id, $get_code_gives_priority_title, $get_code_last_used_datetime, $get_code_last_used_time, $get_code_times_used, $get_code_line_color_graph, $get_code_fill_color_graph) = $row_code;
	
											if($get_code_id != ""){
												$inp_priority_id_mysql = quote_smart($link, $get_code_gives_priority_id);
												$inp_priority_title_mysql = quote_smart($link, $get_code_gives_priority_title);
												$inp_line_color_mysql = quote_smart($link, $get_code_line_color_graph);
												$inp_fill_color_mysql = quote_smart($link, $get_code_fill_color_graph);

												$result_update = mysqli_query($link, "UPDATE $t_edb_stats_requests_department_case_codes_per_month SET 
													stats_dep_case_code_priority_id=$inp_priority_id_mysql,
													stats_dep_case_code_priority_title=$inp_priority_title_mysql,
													stats_dep_case_code_line_color=$inp_line_color_mysql,
													stats_dep_case_code_fill_color=$inp_fill_color_mysql
													 WHERE stats_dep_case_code_case_code_id=$get_stats_dep_case_code_case_code_id") or die(mysqli_error($link));

												// parameter transfer
												$get_stats_dep_case_code_line_color = "$get_code_line_color_graph";
												$get_stats_dep_case_code_fill_color = "$get_code_fill_color_graph";
											}
										}


										// Color empty check
										echo"
										// GRAPHS
										// first graph
										var graph$y = new AmCharts.AmGraph();
										graph$y.type = \"column\";
										graph$y.title = \"$get_stats_dep_case_code_case_code_number $get_stats_dep_case_code_case_code_title\";
										graph$y.valueField = \"case_code_$get_stats_dep_case_code_case_code_number\";
										graph$y.balloonText = \"$get_stats_dep_case_code_case_code_number $get_stats_dep_case_code_case_code_title:[[value]]\";
										graph$y.lineAlpha = 1;
										graph$y.lineColor = \"$get_stats_dep_case_code_line_color\";
										graph$y.fillColors = \"$get_stats_dep_case_code_fill_color\";
										graph$y.fillAlphas = 1;
										chart.addGraph(graph$y);
										";
										$y = $y+1;
									}
									echo"
                

									// LEGEND
               								var legend = new AmCharts.AmLegend();
									chart.addLegend(legend);

	
                							// WRITE
                							chart.write(\"chartdiv_stats_requests_department_case_codes_per_month\");
           							});

								</script>
        							<div id=\"chartdiv_stats_requests_department_case_codes_per_month\" style=\"width:100%; height:180px;\"></div>
								";
							} // x != 0 (there is data)
							else{
								echo"
								</script>
								";
							}
							echo"
						<!-- //requester department javascript -->

					<!-- requests_per_locations_with_case_codes_headline -->





					<!-- requests_per_locations_with_item_types_headline -->
						<div style=\"height: 50px;\"></div>
						<hr />
						<h2>$l_requests_per_locations_with_item_types_headline</h2>


						<!-- requester department javascript -->";
							$script_chart_data = "
							<script>
           						var chart;

	
							var chartDataRequesterDepartmentsItemTypes = [";

							$x = 0;
							$script_graphs = "";
							$query = "SELECT stats_req_dep_id, stats_req_dep_year, stats_req_dep_month, stats_req_dep_district_id, stats_req_dep_station_id, stats_req_dep_department, stats_req_dep_location, stats_req_dep_counter FROM $t_edb_stats_requests_department_per_month WHERE stats_req_dep_district_id=$get_current_district_id ORDER BY stats_req_dep_counter ASC";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_stats_req_dep_id, $get_stats_req_dep_year, $get_stats_req_dep_month, $get_stats_req_dep_district_id, $get_stats_req_dep_station_id, $get_stats_req_dep_department, $get_stats_req_dep_location, $get_stats_req_dep_counter) = $row;

								if($x > 0){
									$script_chart_data = $script_chart_data . ",";
								}
								$script_chart_data = $script_chart_data . "
								{
									\"department\": \"$get_stats_req_dep_department $get_stats_req_dep_location\"";
								// Find case codes
								$department_mysql = quote_smart($link, $get_stats_req_dep_department);
								$location_mysql = quote_smart($link, $get_stats_req_dep_location);
								$query_sub = "SELECT stats_dep_item_type_id, stats_dep_item_type_year, stats_dep_item_type_month, stats_dep_item_type_district_id, stats_dep_item_type_station_id, stats_dep_item_type_department, stats_dep_item_type_location, stats_dep_item_type_item_type_id, stats_dep_item_type_item_type_title, stats_dep_item_type_line_color, stats_dep_item_type_fill_color, stats_dep_item_type_counter FROM $t_edb_stats_requests_department_item_types_per_month WHERE stats_dep_item_type_year=$get_current_stats_year AND stats_dep_item_type_month=$get_current_stats_month AND stats_dep_item_type_district_id=$get_current_district_id AND stats_dep_item_type_department=$department_mysql AND stats_dep_item_type_location=$location_mysql ORDER BY stats_dep_item_type_item_type_title ASC";
								$result_sub = mysqli_query($link, $query_sub);
								while($row_sub = mysqli_fetch_row($result_sub)) {
									list($get_stats_dep_item_type_id, $get_stats_dep_item_type_year, $get_stats_dep_item_type_month, $get_stats_dep_item_type_district_id, $get_stats_dep_item_type_station_id, $get_stats_dep_item_type_department, $get_stats_dep_item_type_location, $get_stats_dep_item_type_item_type_id, $get_stats_dep_item_type_item_type_title, $get_stats_dep_item_type_line_color, $get_stats_dep_item_type_fill_color, $get_stats_dep_item_type_counter) = $row_sub;

									$script_chart_data = $script_chart_data . ",\n";
									$script_chart_data = $script_chart_data . "									";
									$script_chart_data = $script_chart_data . "\"item_type_$get_stats_dep_item_type_item_type_id\": $get_stats_dep_item_type_counter";
								}

								$script_chart_data = $script_chart_data . "\n";
								$script_chart_data = $script_chart_data . "								";
								$script_chart_data = $script_chart_data . "}";

								$x++;
							}
							
							echo"$script_chart_data 
							];
							";
							if($x != 0){
								echo"
								 AmCharts.ready(function () {
               								// SERIAL CHART
									chart = new AmCharts.AmSerialChart();
									chart.dataProvider = chartDataRequesterDepartmentsItemTypes;
									chart.categoryField = \"department\";
									chart.startDuration = 1;
									chart.plotAreaBorderColor = \"#DADADA\";
									chart.plotAreaBorderAlpha = 1;
									chart.hideCredits = \"true\";

									// AXES
									// Category
									var categoryAxis = chart.categoryAxis;
									categoryAxis.gridPosition = \"start\";
									categoryAxis.gridAlpha = 0.1;
									categoryAxis.axisAlpha = 0;

									// Value
									var valueAxis = new AmCharts.ValueAxis();
									valueAxis.axisAlpha = 0;
									valueAxis.gridAlpha = 0.1;
									valueAxis.position = \"top\";
									chart.addValueAxis(valueAxis);


									";
									// Case code craphs
									$y = 1;
	 								$query_sub = "SELECT DISTINCT stats_dep_item_type_item_type_id, stats_dep_item_type_item_type_title, stats_dep_item_type_line_color, stats_dep_item_type_fill_color FROM $t_edb_stats_requests_department_item_types_per_month WHERE stats_dep_item_type_year=$get_current_stats_year AND stats_dep_item_type_month=$get_current_stats_month AND stats_dep_item_type_district_id=$get_current_district_id AND stats_dep_item_type_department=$department_mysql AND stats_dep_item_type_location=$location_mysql ORDER BY stats_dep_item_type_item_type_title ASC";
									$result_sub = mysqli_query($link, $query_sub);
									while($row_sub = mysqli_fetch_row($result_sub)) {
										list($get_stats_dep_item_type_item_type_id, $get_stats_dep_item_type_item_type_title, $get_stats_dep_item_type_line_color, $get_stats_dep_item_type_fill_color) = $row_sub;

										// Color empty check
										if($get_stats_dep_item_type_line_color == ""){
											$query_code = "SELECT item_type_id, item_type_line_color, item_type_fill_color FROM $t_edb_item_types WHERE item_type_id=$get_stats_dep_item_type_item_type_id";
											$result_code = mysqli_query($link, $query_code);
											$row_code = mysqli_fetch_row($result_code);
											list($get_item_type_id, $get_item_type_line_color, $get_item_type_fill_color) = $row_code;
	
											if($get_item_type_id != ""){
												$inp_line_color_mysql = quote_smart($link, $get_item_type_line_color);
												$inp_fill_color_mysql = quote_smart($link, $get_item_type_fill_color);

												$result_update = mysqli_query($link, "UPDATE $t_edb_stats_requests_department_item_types_per_month SET 
													stats_dep_item_type_line_color=$inp_line_color_mysql,
													stats_dep_item_type_fill_color=$inp_fill_color_mysql
													 WHERE stats_dep_item_type_item_type_id=$get_stats_dep_item_type_item_type_id") or die(mysqli_error($link));

												// parameter transfer
												$get_stats_dep_item_type_line_color= "$get_item_type_line_color";
												$get_stats_dep_item_type_fill_color = "$get_item_type_fill_color";
											}
										}


										// Color empty check
										echo"
										// GRAPHS
										// first graph
										var graph$y = new AmCharts.AmGraph();
										graph$y.type = \"column\";
										graph$y.title = \"$get_stats_dep_item_type_item_type_title\";
										graph$y.valueField = \"item_type_$get_stats_dep_item_type_item_type_id\";
										graph$y.balloonText = \"$get_stats_dep_item_type_item_type_title:[[value]]\";
										graph$y.lineAlpha = 1;
										graph$y.lineColor = \"$get_stats_dep_item_type_line_color\";
										graph$y.fillColors = \"$get_stats_dep_item_type_fill_color\";
										graph$y.fillAlphas = 1;
										chart.addGraph(graph$y);
										";
										$y = $y+1;
									}
									echo"
                

									// LEGEND
               								var legend = new AmCharts.AmLegend();
									chart.addLegend(legend);

	
                							// WRITE
                							chart.write(\"chartdiv_stats_requests_department_item_types_per_month\");
           							});

								</script>
        							<div id=\"chartdiv_stats_requests_department_item_types_per_month\" style=\"width:100%; height:180px;\"></div>
								";
							} // x != 0 (there is data)
							else{
								echo"
								</script>
								";
							}
							echo"
						<!-- //requester department javascript -->

					<!-- requests_per_locations_with_item_types_headline -->




					<!-- item_requester person -->
						<div style=\"height: 30px;\"></div>
						<hr />
						<h2>$l_number_of_requests_per_person_headline</h2>
						<div style=\"height: 10px;\"></div>
						<table class=\"hor-zebra\">
						 <thead>
						  <tr>
						   <th scope=\"col\">
							<span>$l_position</span>
						   </th>
						   <th scope=\"col\">
							<span>$l_name</span>
						   </th>
						   <th scope=\"col\">
							<span>$l_department</span>
						   </th>
						   <th scope=\"col\">
							<span>$l_location</span>
						   </th>
						   <th scope=\"col\">
							<span>$l_requests</span>
						   </th>
						  </tr>
						 </thead>
						 <tbody>
						";

						$query = "SELECT stats_req_usr_id, stats_req_usr_year, stats_req_usr_month, stats_req_usr_district_id, stats_req_usr_station_id, stats_req_usr_user_id, stats_req_usr_user_name, stats_req_usr_user_alias, stats_req_usr_user_first_name, stats_req_usr_user_middle_name, stats_req_usr_user_last_name, stats_req_usr_user_position, stats_req_usr_user_department, stats_req_usr_user_location, stats_req_usr_counter FROM $t_edb_stats_requests_user_per_month WHERE stats_req_usr_year=$get_current_stats_year AND stats_req_usr_month=$get_current_stats_month AND stats_req_usr_district_id=$get_current_district_id ORDER BY stats_req_usr_counter DESC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_stats_req_usr_id, $get_stats_req_usr_year, $get_stats_req_usr_month, $get_stats_req_usr_district_id, $get_stats_req_usr_station_id, $get_stats_req_usr_user_id, $get_stats_req_usr_user_name, $get_stats_req_usr_user_alias, $get_stats_req_usr_user_first_name, $get_stats_req_usr_user_middle_name, $get_stats_req_usr_user_last_name, $get_stats_req_usr_user_position, $get_stats_req_usr_user_department, $get_stats_req_usr_user_location, $get_stats_req_usr_counter) = $row;


							if(isset($odd) && $odd == false){
								$odd = true;
							}
							else{
								$odd = false;
							}

							echo"
							<tr>
							  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
								<span>$get_stats_req_usr_user_position</span>
							  </td>
							  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
								<span><a href=\"view_profile_and_update_profile_link.php?user_id=$get_stats_req_usr_user_id&amp;l=$l&amp;process=1\" style=\"color: #000\">";
								if($get_stats_req_usr_user_first_name != ""){
									echo"$get_stats_req_usr_user_first_name $get_stats_req_usr_user_middle_name $get_stats_req_usr_user_last_name";
								}
								else{
									echo"$get_stats_req_usr_user_name";
								}
								echo"</a></span>
							  </td>
							  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
								<span>$get_stats_req_usr_user_department</span>
							  </td>
							  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
								<span>$get_stats_req_usr_user_location</span>
							  </td>
							  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
								<span>$get_stats_req_usr_counter</span>
							  </td>
							 </tr>";
						}
						echo"
						 </tbody>
						</table>
					<!-- //item_requester person -->





					<!-- requests_per_person_with_case_codes_headline -->
						<div style=\"height: 30px;\"></div>
						<hr />
						<h2>$l_requests_per_person_with_case_codes_headline</h2>


						<!-- requests_per_person_with_case_codes javascript -->";
							$script_chart_data = "
							<script>
           						var chart;

	
							var chartDataRequesterPersonCaseCodes = [";

							$x = 0;
							$script_graphs = "";

							$query = "SELECT stats_req_usr_id, stats_req_usr_year, stats_req_usr_month, stats_req_usr_district_id, stats_req_usr_station_id, stats_req_usr_user_id, stats_req_usr_user_name, stats_req_usr_user_alias, stats_req_usr_user_first_name, stats_req_usr_user_middle_name, stats_req_usr_user_last_name, stats_req_usr_user_position, stats_req_usr_user_department, stats_req_usr_user_location, stats_req_usr_counter FROM $t_edb_stats_requests_user_per_month WHERE stats_req_usr_year=$get_current_stats_year AND stats_req_usr_month=$get_current_stats_month AND stats_req_usr_district_id=$get_current_district_id ORDER BY stats_req_usr_counter DESC";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_stats_req_usr_id, $get_stats_req_usr_year, $get_stats_req_usr_month, $get_stats_req_usr_district_id, $get_stats_req_usr_station_id, $get_stats_req_usr_user_id, $get_stats_req_usr_user_name, $get_stats_req_usr_user_alias, $get_stats_req_usr_user_first_name, $get_stats_req_usr_user_middle_name, $get_stats_req_usr_user_last_name, $get_stats_req_usr_user_position, $get_stats_req_usr_user_department, $get_stats_req_usr_user_location, $get_stats_req_usr_counter) = $row;

								// Characters
								$get_stats_req_usr_user_first_name = str_replace("&oslash;", "ø", $get_stats_req_usr_user_first_name);

								if($x > 0){
									$script_chart_data = $script_chart_data . ",";
								}
								$script_chart_data = $script_chart_data . "
								{
									\"name\": \"$get_stats_req_usr_user_first_name $get_stats_req_usr_user_middle_name $get_stats_req_usr_user_last_name\"";
								// Find case codes
								$query_case_codes = "SELECT stats_usr_case_code_id, stats_usr_case_code_year, stats_usr_case_code_month, stats_usr_case_code_district_id, stats_usr_case_code_station_id, stats_usr_case_code_user_id, stats_usr_case_code_case_code_id, stats_usr_case_code_case_code_number, stats_usr_case_code_case_code_title, stats_usr_case_code_priority_id, stats_usr_case_code_priority_title, stats_usr_case_code_line_color, stats_usr_case_code_fill_color, stats_usr_case_code_counter FROM $t_edb_stats_requests_user_case_codes_per_month WHERE stats_usr_case_code_year=$get_current_stats_year AND stats_usr_case_code_month=$get_current_stats_month AND stats_usr_case_code_district_id=$get_current_district_id AND stats_usr_case_code_user_id=$get_stats_req_usr_user_id ORDER BY stats_usr_case_code_counter ASC";
								$result_case_codes = mysqli_query($link, $query_case_codes);
								while($row_case_codes = mysqli_fetch_row($result_case_codes)) {
									list($get_stats_usr_case_code_id, $get_stats_usr_case_code_year, $get_stats_usr_case_code_month, $get_stats_usr_case_code_district_id, $get_stats_usr_case_code_station_id, $get_stats_usr_case_code_user_id, $get_stats_usr_case_code_case_code_id, $get_stats_usr_case_code_case_code_number, $get_stats_usr_case_code_case_code_title, $get_stats_usr_case_code_priority_id, $get_stats_usr_case_code_priority_title, $get_stats_usr_case_code_line_color, $get_stats_usr_case_code_fill_color, $get_stats_usr_case_code_counter) = $row_case_codes;

									$script_chart_data = $script_chart_data . ",\n";
									$script_chart_data = $script_chart_data . "									";
									$script_chart_data = $script_chart_data . "\"case_code_$get_stats_usr_case_code_case_code_number\": $get_stats_usr_case_code_counter";
								}

								$script_chart_data = $script_chart_data . "\n";
								$script_chart_data = $script_chart_data . "								";
								$script_chart_data = $script_chart_data . "}";

								$x++;
							}
							
							echo"$script_chart_data 
							];
							";
							if($x != 0){
								echo"
								 AmCharts.ready(function () {
               								// SERIAL CHART
									chart = new AmCharts.AmSerialChart();
									chart.dataProvider = chartDataRequesterPersonCaseCodes;
									chart.categoryField = \"name\";
									chart.startDuration = 1;
									chart.plotAreaBorderColor = \"#DADADA\";
									chart.plotAreaBorderAlpha = 1;
									chart.hideCredits = \"true\";

									// AXES
									// Category
									var categoryAxis = chart.categoryAxis;
									categoryAxis.gridPosition = \"start\";
									categoryAxis.gridAlpha = 0.1;
									categoryAxis.axisAlpha = 0;

									// Value
									var valueAxis = new AmCharts.ValueAxis();
									valueAxis.axisAlpha = 0;
									valueAxis.gridAlpha = 0.1;
									valueAxis.position = \"top\";
									chart.addValueAxis(valueAxis);


									";
									// Case code craphs
									$y = 1;

									$query_case_codes = "SELECT DISTINCT stats_usr_case_code_case_code_id, stats_usr_case_code_case_code_number, stats_usr_case_code_case_code_title, stats_usr_case_code_priority_id, stats_usr_case_code_priority_title, stats_usr_case_code_line_color, stats_usr_case_code_fill_color FROM $t_edb_stats_requests_user_case_codes_per_month WHERE stats_usr_case_code_year=$get_current_stats_year AND stats_usr_case_code_month=$get_current_stats_month AND stats_usr_case_code_district_id=$get_current_district_id ORDER BY stats_usr_case_code_counter ASC";
									$result_case_codes = mysqli_query($link, $query_case_codes);
									while($row_case_codes = mysqli_fetch_row($result_case_codes)) {
										list($get_stats_usr_case_code_case_code_id, $get_stats_usr_case_code_case_code_number, $get_stats_usr_case_code_case_code_title, $get_stats_usr_case_code_priority_id, $get_stats_usr_case_code_priority_title, $get_stats_usr_case_code_line_color, $get_stats_usr_case_code_fill_color) = $row_case_codes;



										// Priority empty check
										if($get_stats_usr_case_code_priority_id == "" OR $get_stats_usr_case_code_line_color == ""){
											$query_code = "SELECT code_id, code_number, code_title, code_title_clean, code_title_abbr, code_is_active, code_valid_from_date, code_valid_from_time, code_valid_to_date, code_valid_to_time, code_gives_priority_id, code_gives_priority_title, code_last_used_datetime, code_last_used_time, code_times_used, code_line_color_graph, code_fill_color_graph FROM $t_edb_case_codes WHERE code_id=$get_stats_usr_case_code_case_code_id";
											$result_code = mysqli_query($link, $query_code);
											$row_code = mysqli_fetch_row($result_code);
											list($get_code_id, $get_code_number, $get_code_title, $get_code_title_clean, $get_code_title_abbr, $get_code_is_active, $get_code_valid_from_date, $get_code_valid_from_time, $get_code_valid_to_date, $get_code_valid_to_time, $get_code_gives_priority_id, $get_code_gives_priority_title, $get_code_last_used_datetime, $get_code_last_used_time, $get_code_times_used, $get_code_line_color_graph, $get_code_fill_color_graph) = $row_code;
	
											if($get_code_id != ""){
												$inp_priority_id_mysql = quote_smart($link, $get_code_gives_priority_id);
												$inp_priority_title_mysql = quote_smart($link, $get_code_gives_priority_title);
												$inp_line_color_mysql = quote_smart($link, $get_code_line_color_graph);
												$inp_fill_color_mysql = quote_smart($link, $get_code_fill_color_graph);

												$result_update = mysqli_query($link, "UPDATE $t_edb_stats_requests_user_case_codes_per_month  SET 
													stats_usr_case_code_priority_id=$inp_priority_id_mysql,
													stats_usr_case_code_priority_title=$inp_priority_title_mysql,
													stats_usr_case_code_line_color=$inp_line_color_mysql,
													stats_usr_case_code_fill_color=$inp_fill_color_mysql
													 WHERE stats_usr_case_code_case_code_id=$get_stats_usr_case_code_case_code_id") or die(mysqli_error($link));

												// parameter transfer
												$get_stats_usr_case_code_line_color = "$get_code_line_color_graph";
												$get_stats_usr_case_code_fill_color = "$get_code_fill_color_graph";
											}
										}


										// Color empty check
										echo"
										// GRAPHS
										// first graph
										var graph$y = new AmCharts.AmGraph();
										graph$y.type = \"column\";
										graph$y.title = \"$get_stats_usr_case_code_case_code_number $get_stats_usr_case_code_case_code_title\";
										graph$y.valueField = \"case_code_$get_stats_usr_case_code_case_code_number\";
										graph$y.balloonText = \"$get_stats_usr_case_code_case_code_number $get_stats_usr_case_code_case_code_title:[[value]]\";
										graph$y.lineAlpha = 1;
										graph$y.lineColor = \"$get_stats_usr_case_code_line_color\";
										graph$y.fillColors = \"$get_stats_usr_case_code_fill_color\";
										graph$y.fillAlphas = 1;
										chart.addGraph(graph$y);
										";
										$y = $y+1;
									}
									echo"
                

									// LEGEND
               								var legend = new AmCharts.AmLegend();
									chart.addLegend(legend);

	
                							// WRITE
                							chart.write(\"chartdiv_stats_requests_per_person_with_case_codes\");
           							});

								</script>
        							<div id=\"chartdiv_stats_requests_per_person_with_case_codes\" style=\"width:100%; height:180px;\"></div>
								";
							} // x != 0 (there is data)
							else{
								echo"
								</script>
								";
							}
							echo"
						<!-- //requests_per_person_with_case_codes javascript -->

					<!-- requests_per_person_with_case_codes_headline -->


					<!-- requests_per_person_with_item_types_headline -->
						<div style=\"height: 30px;\"></div>
						<hr />
						<h2>$l_requests_per_person_with_item_types_headline</h2>


						<!-- requests_per_person_with_item_types javascript -->";
							$script_chart_data = "
							<script>
           						var chart;

	
							var chartDataRequesterPersonItemTypes = [";

							$x = 0;
							$script_graphs = "";

							$query = "SELECT stats_req_usr_id, stats_req_usr_year, stats_req_usr_month, stats_req_usr_district_id, stats_req_usr_station_id, stats_req_usr_user_id, stats_req_usr_user_name, stats_req_usr_user_alias, stats_req_usr_user_first_name, stats_req_usr_user_middle_name, stats_req_usr_user_last_name, stats_req_usr_user_position, stats_req_usr_user_department, stats_req_usr_user_location, stats_req_usr_counter FROM $t_edb_stats_requests_user_per_month WHERE stats_req_usr_year=$get_current_stats_year AND stats_req_usr_month=$get_current_stats_month AND stats_req_usr_district_id=$get_current_district_id ORDER BY stats_req_usr_counter DESC";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_stats_req_usr_id, $get_stats_req_usr_year, $get_stats_req_usr_month, $get_stats_req_usr_district_id, $get_stats_req_usr_station_id, $get_stats_req_usr_user_id, $get_stats_req_usr_user_name, $get_stats_req_usr_user_alias, $get_stats_req_usr_user_first_name, $get_stats_req_usr_user_middle_name, $get_stats_req_usr_user_last_name, $get_stats_req_usr_user_position, $get_stats_req_usr_user_department, $get_stats_req_usr_user_location, $get_stats_req_usr_counter) = $row;

								// Characters
								$get_stats_req_usr_user_first_name = str_replace("&oslash;", "ø", $get_stats_req_usr_user_first_name);

								if($x > 0){
									$script_chart_data = $script_chart_data . ",";
								}
								$script_chart_data = $script_chart_data . "
								{
									\"name\": \"$get_stats_req_usr_user_first_name $get_stats_req_usr_user_middle_name $get_stats_req_usr_user_last_name\"";
								// Find item types
								$query_item_types = "SELECT stats_usr_item_type_id, stats_usr_item_type_year, stats_usr_item_type_month, stats_usr_item_type_district_id, stats_usr_item_type_station_id, stats_usr_item_type_user_id, stats_usr_item_type_item_type_id, stats_usr_item_type_item_type_title, stats_usr_item_type_line_color, stats_usr_item_type_fill_color, stats_usr_item_type_counter FROM $t_edb_stats_requests_user_item_types_per_month WHERE stats_usr_item_type_year=$get_current_stats_year AND stats_usr_item_type_month=$get_current_stats_month AND stats_usr_item_type_district_id=$get_current_district_id AND stats_usr_item_type_user_id=$get_stats_req_usr_user_id ORDER BY stats_usr_item_type_counter ASC";
								$result_item_types = mysqli_query($link, $query_item_types);
								while($row_item_types = mysqli_fetch_row($result_item_types)) {
									list($get_stats_usr_item_type_id, $get_stats_usr_item_type_year, $get_stats_usr_item_type_month, $get_stats_usr_item_type_district_id, $get_stats_usr_item_type_station_id, $get_stats_usr_item_type_user_id, $get_stats_usr_item_type_item_type_id, $get_stats_usr_item_type_item_type_title, $get_stats_usr_item_type_line_color, $get_stats_usr_item_type_fill_color, $get_stats_usr_item_type_counter) = $row_item_types;

									$script_chart_data = $script_chart_data . ",\n";
									$script_chart_data = $script_chart_data . "									";
									$script_chart_data = $script_chart_data . "\"item_type_$get_stats_usr_item_type_item_type_id\": $get_stats_usr_item_type_counter";
								}

								$script_chart_data = $script_chart_data . "\n";
								$script_chart_data = $script_chart_data . "								";
								$script_chart_data = $script_chart_data . "}";

								$x++;
							}
							
							echo"$script_chart_data 
							];
							";
							if($x != 0){
								echo"
								 AmCharts.ready(function () {
               								// SERIAL CHART
									chart = new AmCharts.AmSerialChart();
									chart.dataProvider = chartDataRequesterPersonItemTypes;
									chart.categoryField = \"name\";
									chart.startDuration = 1;
									chart.plotAreaBorderColor = \"#DADADA\";
									chart.plotAreaBorderAlpha = 1;
									chart.hideCredits = \"true\";

									// AXES
									// Category
									var categoryAxis = chart.categoryAxis;
									categoryAxis.gridPosition = \"start\";
									categoryAxis.gridAlpha = 0.1;
									categoryAxis.axisAlpha = 0;

									// Value
									var valueAxis = new AmCharts.ValueAxis();
									valueAxis.axisAlpha = 0;
									valueAxis.gridAlpha = 0.1;
									valueAxis.position = \"top\";
									chart.addValueAxis(valueAxis);


									";
									// Item types
									$y = 1;
									$query_item_types = "SELECT DISTINCT stats_usr_item_type_item_type_id, stats_usr_item_type_item_type_title, stats_usr_item_type_line_color, stats_usr_item_type_fill_color FROM $t_edb_stats_requests_user_item_types_per_month WHERE stats_usr_item_type_year=$get_current_stats_year AND stats_usr_item_type_month=$get_current_stats_month AND stats_usr_item_type_district_id=$get_current_district_id ORDER BY stats_usr_item_type_counter ASC";
									$result_item_types = mysqli_query($link, $query_item_types);
									while($row_item_types = mysqli_fetch_row($result_item_types)) {
										list($get_stats_usr_item_type_item_type_id, $get_stats_usr_item_type_item_type_title, $get_stats_usr_item_type_line_color, $get_stats_usr_item_type_fill_color) = $row_item_types;


										// Color empty check
										if($get_stats_usr_item_type_line_color == ""){
											$query_code = "SELECT item_type_id, item_type_line_color, item_type_fill_color FROM $t_edb_item_types WHERE item_type_id=$get_stats_usr_item_type_item_type_id";
											$result_code = mysqli_query($link, $query_code);
											$row_code = mysqli_fetch_row($result_code);
											list($get_item_type_id, $get_item_type_line_color, $get_item_type_fill_color) = $row_code;
	
											if($get_item_type_id != ""){
												$inp_line_color_mysql = quote_smart($link, $get_item_type_line_color);
												$inp_fill_color_mysql = quote_smart($link, $get_item_type_fill_color);

												$result_update = mysqli_query($link, "UPDATE $t_edb_stats_requests_user_item_types_per_month SET 
													stats_usr_item_type_line_color=$inp_line_color_mysql,
													stats_usr_item_type_fill_color=$inp_fill_color_mysql
													 WHERE stats_usr_item_type_item_type_id=$get_stats_usr_item_type_item_type_id") or die(mysqli_error($link));

												// parameter transfer
												$get_stats_usr_item_type_line_color = "$get_item_type_line_color";
												$get_stats_usr_item_type_fill_color = "$get_item_type_fill_color";
											}
										}


										// Color empty check
										echo"
										// GRAPHS
										// first graph
										var graph$y = new AmCharts.AmGraph();
										graph$y.type = \"column\";
										graph$y.title = \"$get_stats_usr_item_type_item_type_title\";
										graph$y.valueField = \"item_type_$get_stats_usr_item_type_item_type_id\";
										graph$y.balloonText = \"$get_stats_usr_item_type_item_type_title:[[value]]\";
										graph$y.lineAlpha = 1;
										graph$y.lineColor = \"$get_stats_usr_item_type_line_color\";
										graph$y.fillColors = \"$get_stats_usr_item_type_fill_color\";
										graph$y.fillAlphas = 1;
										chart.addGraph(graph$y);
										";
										$y = $y+1;
									}
									echo"
                

									// LEGEND
               								var legend = new AmCharts.AmLegend();
									chart.addLegend(legend);

	
                							// WRITE
                							chart.write(\"chartdiv_stats_requests_per_person_with_item_types\");
           							});

								</script>
        							<div id=\"chartdiv_stats_requests_per_person_with_item_types\" style=\"width:100%; height:180px;\"></div>
								";
							} // x != 0 (there is data)
							else{
								echo"
								</script>
								";
							}
							echo"
						<!-- //requests_per_person_with_item types javascript -->

					<!-- requests_per_person_with_item types -->

					<!-- Cases and evidence items per employee -->
						
						<h2>$l_cases_and_items_per_member_headline</h2>
						<table class=\"hor-zebra\">
						 <thead>
						  <tr>
						   <th scope=\"col\">
							<span>$l_name</span>
						   </th>
						   <th scope=\"col\">
							<span>$l_case</span>
						   </th>
						   <th scope=\"col\">
							<span>$l_evidence</span>
						   </th>
						   <th scope=\"col\">
							<span>$l_code</span>
						   </th>
						   <th scope=\"col\">
							<span>$l_priority</span>
						   </th>
						  </tr>
						 </thead>
						 <tbody>
						";

						$query = "SELECT district_member_id, district_member_user_id, district_member_user_name, district_member_user_first_name, district_member_user_middle_name, district_member_user_last_name FROM $t_edb_districts_members WHERE district_member_district_id=$get_current_district_id AND district_member_show_on_board=1 ORDER BY district_member_user_name ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_district_member_id, $get_district_member_user_id, $get_district_member_user_name, $get_district_member_user_first_name, $get_district_member_user_middle_name, $get_district_member_user_last_name) = $row;

							if(isset($odd) && $odd == false){
								$odd = true;
							}
							else{
								$odd = false;
							}

							echo"
							 <tr>
							  <td"; if($odd == true){ echo" class=\"odd\""; } echo" colspan=\"5\" style=\"text-align:center;\">
								<span><a href=\"$root/users/view_profile.php?user_id=$get_district_member_user_id&amp;l=$l\">";
								if($get_district_member_user_first_name == ""){
									echo"$get_district_member_user_name";
								}
								else{
									echo"$get_district_member_user_first_name $get_district_member_user_middle_name $get_district_member_user_last_name";
								}
								echo"</a></span>
							  </td>
							 </tr>
							";

							// All evidence
							$query_items = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title FROM $t_edb_case_index_evidence_items WHERE item_acquired_user_id=$get_district_member_user_id AND YEAR(item_acquired_date) = $get_current_stats_year AND MONTH(item_acquired_date) = $get_current_stats_month";
							$result_items = mysqli_query($link, $query_items);
							while($row_items = mysqli_fetch_row($result_items)) {
								list($get_item_id, $get_item_case_id, $get_item_record_id, $get_item_record_seized_year, $get_item_record_seized_journal, $get_item_record_seized_district_number, $get_item_numeric_serial_number, $get_item_title) = $row_items;

								// Get case number, etc
								$query_case = "SELECT case_id, case_number, case_title, case_code_number, case_code_title, case_priority_id, case_priority_title, case_assigned_to_user_id, case_assigned_to_user_name, case_assigned_to_user_first_name, case_assigned_to_user_middle_name, case_assigned_to_user_last_name, case_created_user_id, case_created_user_name, case_created_user_first_name, case_created_user_middle_name, case_created_user_last_name FROM $t_edb_case_index WHERE case_id=$get_item_case_id";
								$result_case = mysqli_query($link, $query_case);
								$row_case = mysqli_fetch_row($result_case);
								list($get_case_id, $get_case_number, $get_case_title, $get_case_code_number, $get_case_code_title, $get_case_priority_id, $get_case_priority_title, $get_case_assigned_to_user_id, $get_case_assigned_to_user_name, $get_case_assigned_to_user_first_name, $get_case_assigned_to_user_middle_name, $get_case_assigned_to_user_last_name, $get_case_created_user_id, $get_case_created_user_name, $get_case_created_user_first_name, $get_case_created_user_middle_name, $get_case_created_user_last_name) = $row_case;
	


								echo"
								 <tr>
								  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
									<span><a href=\"$root/users/view_profile.php?user_id=$get_district_member_user_id&amp;l=$l\">";
									if($get_district_member_user_first_name == ""){
										echo"$get_district_member_user_name";
									}
									else{
										echo"$get_district_member_user_first_name $get_district_member_user_middle_name $get_district_member_user_last_name";
									}
									echo"</a></span>
								  </td>
								  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
									<span><a href=\"open_case_overview.php?case_id=$get_case_id&amp;l=$l\">$get_case_number $get_case_title</a></span>
								  </td>
								  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
									<span><a href=\"open_case_evidence_edit_evidence_item_info.php?case_id=$get_item_case_id&amp;item_id=$get_item_id&amp;l=$l\">$get_item_record_id/$get_item_record_seized_year-$get_item_record_seized_journal-$get_item_record_seized_district_number-$get_item_numeric_serial_number $get_item_title</a></span>
								  </td>
								  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
									<span>$get_case_code_number $get_case_code_title</span>
								  </td>
								  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
									<span>$get_case_priority_title</span>
								  </td>
								 </tr>
								";

							}
						} // members
						echo"
						 <tbody>
						</table>
					
					<!-- //Cases and evidence items per employee -->
				";
			} // access to district
		} // district found
	} // stats found

} // logged in
else{
	// Log in
	echo"
	<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> $l_please_log_in...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/edb\">
	";
} // not logged in
/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/$webdesignSav/footer.php");
?>