<?php
/**
*
* File: _admin/_inc/media/default.php
* Version 2
* Date 16:12 27.04.2019
* Copyright (c) 2008-2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Functions ----------------------------------------------------------------------- */
include("_functions/decode_national_letters.php");

/*- Tables ---------------------------------------------------------------------------- */
$t_tasks_index  		= $mysqlPrefixSav . "tasks_index";
$t_tasks_status_codes  		= $mysqlPrefixSav . "tasks_status_codes";
$t_tasks_projects  		= $mysqlPrefixSav . "tasks_projects";
$t_tasks_projects_parts  	= $mysqlPrefixSav . "tasks_projects_parts";
$t_tasks_systems  		= $mysqlPrefixSav . "tasks_systems";
$t_tasks_systems_parts  	= $mysqlPrefixSav . "tasks_systems_parts";
$t_tasks_read			= $mysqlPrefixSav . "tasks_read";


$t_stats_visists_per_year 	   	= $mysqlPrefixSav . "stats_visists_per_year";
$t_stats_visists_per_month 	   	= $mysqlPrefixSav . "stats_visists_per_month";
$t_stats_visists_per_day 	   	= $mysqlPrefixSav . "stats_visists_per_day";
$t_stats_users_registered_per_year 	= $mysqlPrefixSav . "stats_users_registered_per_year";
$t_stats_comments_per_year 		= $mysqlPrefixSav . "stats_comments_per_year";

/*- Notebook -------------------------------------------------------------------------- */
if(!(file_exists("_data/notepad_common.php"))){

	// Create file
	$datetime = date("Y-m-d H:i:s");
	$input="<?php
\$notepadUpdatedDateTimeSav = \"$datetime\";
\$notepadUpdatedUserIdSav   = \"$get_my_user_id\";
\$notepadUpdatedUserNameSav = \"$get_my_user_name\";
\$notepadNotesSav = \"\";
?>";

	$fh = fopen("_data/notepad_common.php", "w+") or die("can not open file");
	fwrite($fh, $input);
	fclose($fh);
}





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
	<!-- Sparkline javascript -->
		<script src=\"_javascripts/sparkline/jquery.sparkline.js\"></script>
	<!-- //Sparkline javascript -->

	<!-- Charts javascript -->
		<script src=\"_javascripts/amcharts4/core.js\"></script>
		<script src=\"_javascripts/amcharts4/charts.js\"></script>
		<script src=\"_javascripts/amcharts4/themes/animated.js\"></script>
		<script src=\"_javascripts/amcharts4/plugins/venn.js\"></script>

	<!-- //Charts javascript -->

	<!-- Feedback -->
		";
		if($ft != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			else{
				$fm = ucfirst($fm);
			}
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
	<!-- //Feedback -->

			</div> <!-- //main_right_content -->
			<div class=\"clear_main_right_content\">


	<!-- Check if setup folder exists -->
		";
		if(file_exists("setup/index.php")){
			echo"
			<!-- <div class=\"error\"><span>Security issue: </span></div> -->
			";
		}
		echo"
	<!-- //Check if setup folder exists -->



	<!-- Row 1 -->
		<div class=\"flex_row\">

			<!-- Visits per year -->
				<div class=\"flex_col_white_bg\">
					<p class=\"flex_col_white_bg_text_left_content\"><span class=\"barsparks_this_year\">";

							$x = 0;

							$visit_per_year_year 					= 0;
							$visit_per_year_human_unique				= 0;
							$visit_per_year_human_unique_diff_from_last_year	= 0;

							$query = "SELECT stats_visit_per_year_id, stats_visit_per_year_year, stats_visit_per_year_human_unique, stats_visit_per_year_human_unique_diff_from_last_year, stats_visit_per_year_human_average_duration, stats_visit_per_year_human_new_visitor_unique, stats_visit_per_year_human_returning_visitor_unique, stats_visit_per_year_unique_desktop, stats_visit_per_year_unique_mobile, stats_visit_per_year_unique_bots, stats_visit_per_year_hits_total, stats_visit_per_year_hits_human, stats_visit_per_year_hits_desktop, stats_visit_per_year_hits_mobile, stats_visit_per_year_hits_bots FROM $t_stats_visists_per_year ORDER BY stats_visit_per_year_id ASC LIMIT 0,12";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_stats_visit_per_year_id, $get_stats_visit_per_year_year, $get_stats_visit_per_year_human_unique, $get_stats_visit_per_year_human_unique_diff_from_last_year, $get_stats_visit_per_year_human_average_duration, $get_stats_visit_per_year_human_new_visitor_unique, $get_stats_visit_per_year_human_returning_visitor_unique, $get_stats_visit_per_year_unique_desktop, $get_stats_visit_per_year_unique_mobile, $get_stats_visit_per_year_unique_bots, $get_stats_visit_per_year_hits_total, $get_stats_visit_per_year_hits_human, $get_stats_visit_per_year_hits_desktop, $get_stats_visit_per_year_hits_mobile, $get_stats_visit_per_year_hits_bots) = $row;
	

								if($x > 0){
									echo",";
								}
								echo"$get_stats_visit_per_year_human_unique";
								
								// Check that diff is ok
								$diff = $get_stats_visit_per_year_human_unique-$visit_per_year_human_unique;
								if($diff != "$get_stats_visit_per_year_human_unique_diff_from_last_year"){
									$res_update = mysqli_query($link, "UPDATE $t_stats_visists_per_year SET stats_visit_per_year_human_unique_diff_from_last_year=$diff WHERE stats_visit_per_year_id=$get_stats_visit_per_year_id") or die(mysqli_error($link));
								
								}

								// Transfer last year for print
								$visit_per_year_year				 = $get_stats_visit_per_year_year;
								$visit_per_year_human_unique			 = $get_stats_visit_per_year_human_unique;
								$visit_per_year_human_unique_diff_from_last_year = $get_stats_visit_per_year_human_unique_diff_from_last_year;


								// xx
								$x++;
							} // while
					echo"</span></p>
					<script>
					$('.barsparks_this_year').sparkline('html', { 
						type: 'bar',
						barColor: '#f2a654', 
						barWidth: 7,
						barSpacing: 4, 
						height:'40px' });
					</script>

                			<div class=\"flex_col_white_bg_text_right\">
						<p class=\"flex_col_white_bg_text_right_headline\" title=\"$visit_per_year_year unique visits\">$visit_per_year_year&nbsp;unique&nbsp;visits</p>
                  				<p class=\"flex_col_white_bg_text_right_content\">";
						if($visit_per_year_human_unique_diff_from_last_year == 0){
							echo"<img src=\"_inc/dashboard/_img/ti_angle_flat_no_change.png\" alt=\"ti_angle_up_no_change.png\" title=\"Same as last year ($visit_per_year_human_unique_diff_from_last_year unique human visits diff)\" />";
						}
						elseif($visit_per_year_human_unique_diff_from_last_year < 0){
							echo"<img src=\"_inc/dashboard/_img/ti_angle_down_warning.png\" alt=\"ti_angle_up_warning.png\" title=\"Decreased with $visit_per_year_human_unique_diff_from_last_year unique humans from last year\" />";
						}
						else{
							echo"<img src=\"_inc/dashboard/_img/ti_angle_up_success.png\" alt=\"ti_angle_up_success.png\" title=\"Increasted with $visit_per_year_human_unique_diff_from_last_year unique humans from last year\" />";
						}
                    				echo"
						<span>$visit_per_year_human_unique</span>
            					</p>
					</div>
				</div> <!-- //flex_col_white_bg -->
			<!-- //Visits per year -->


			<!-- Users per year -->
				<div class=\"flex_col_white_bg\">
					<table style=\"width: 100%;\">
					 <tr>
					  <td style=\"vertical-align:top;\">
						<span class=\"barsparks_user_registered\">";

						$x = 0;

						$registered_year 				= 0;
						$registered_users_registed			= 0;
						$registered_users_registed_diff_from_last_year = 0;

						$query = "SELECT stats_registered_id, stats_registered_year, stats_registered_users_registed, stats_registered_users_registed_diff_from_last_year, stats_registered_last_updated, stats_registered_last_updated_day, stats_registered_last_updated_month, stats_registered_last_updated_year FROM $t_stats_users_registered_per_year ORDER BY stats_registered_year ASC LIMIT 0,12";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_stats_registered_id, $get_stats_registered_year, $get_stats_registered_users_registed, $get_stats_registered_users_registed_diff_from_last_year, $get_stats_registered_last_updated, $get_stats_registered_last_updated_day, $get_stats_registered_last_updated_month, $get_stats_registered_last_updated_year) = $row;
	

								if($x > 0){
									echo",";
								}
								echo"$get_stats_registered_users_registed";
								
								// Check that diff is ok
								$diff = $get_stats_registered_users_registed-$registered_users_registed;
								if($diff  != "$get_stats_registered_users_registed_diff_from_last_year"){
									$res_update = mysqli_query($link, "UPDATE $t_stats_users_registered_per_year SET stats_registered_users_registed_diff_from_last_year=$diff WHERE stats_registered_id=$get_stats_registered_id") or die(mysqli_error($link));
								
								}

								// Transfer last year for print
								$registered_year 		= $get_stats_registered_year;
								$registered_users_registed	= $get_stats_registered_users_registed;
								$registered_users_registed_diff_from_last_year = $get_stats_registered_users_registed_diff_from_last_year;

								// xx
								$x++;
						} // while
						echo"</span>
						<script>
						$('.barsparks_user_registered').sparkline('html', { 
							lineColor: '#99e4dc', 
							spotColor: '#33cabb', 
							minSpotColor: '#33cabb', 
							maxSpotColor: '#33cabb', 
							fillColor: false, height:'40px', barWidth:60
							});
						</script>
					  </td>
					  <td style=\"vertical-align:top;\">
                  				<p class=\"flex_col_white_bg_text_right_headline\">Users&nbsp;registered&nbsp;in&nbsp;$registered_year</p>
                  				<p class=\"flex_col_white_bg_text_right_content\">";
						if($registered_users_registed_diff_from_last_year == 0){
							echo"<img src=\"_inc/dashboard/_img/ti_angle_flat_no_change.png\" alt=\"ti_angle_up_no_change.png\" title=\"$registered_users_registed_diff_from_last_year new users\" />";
						}
						elseif($registered_users_registed_diff_from_last_year < 0){
							echo"<img src=\"_inc/dashboard/_img/ti_angle_down_warning.png\" alt=\"ti_angle_up_warning.png\" title=\"$registered_users_registed_diff_from_last_year new users\" />";
						}
						else{
							echo"<img src=\"_inc/dashboard/_img/ti_angle_up_success.png\" alt=\"ti_angle_up_success.png\" title=\"$registered_users_registed_diff_from_last_year new users\" />";
						}
                    				echo"
						<span>$registered_users_registed</span>
            					</p>
			                  </td>
					 </tr>
					</table>
				</div> <!-- //flex_col_white_bg -->
			<!-- //Users per year -->




			<!-- Comments per year -->
				<div class=\"flex_col_white_bg\">
					<table style=\"width: 100%;\">
					 <tr>
					  <td style=\"vertical-align:top;\">
						<span class=\"barsparks_new_comments\">";

						$x = 0;

						$comments_year 					= 0;
						$comments_comments_written			= 0;
						$comments_comments_written_diff_from_last_year = 0;

						$query = "SELECT stats_comments_id, stats_comments_year, stats_comments_comments_written, stats_comments_comments_written_diff_from_last_year, stats_comments_last_updated, stats_comments_last_updated_day, stats_comments_last_updated_month, stats_comments_last_updated_year FROM $t_stats_comments_per_year ORDER BY stats_comments_id ASC LIMIT 0,12";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_stats_comments_id, $get_stats_comments_year, $get_stats_comments_comments_written, $get_stats_comments_comments_written_diff_from_last_year, $get_stats_comments_last_updated, $get_stats_comments_last_updated_day, $get_stats_comments_last_updated_month, $get_stats_comments_last_updated_year) = $row;
	

							if($x > 0){
								echo",";
							}
							echo"$get_stats_comments_comments_written";
								
								// Check that diff is ok
								$diff = $get_stats_comments_comments_written-$comments_comments_written;
								if($diff  != "$get_stats_comments_comments_written_diff_from_last_year"){
									$res_update = mysqli_query($link, "UPDATE $t_stats_comments_per_year SET stats_comments_comments_written_diff_from_last_year=$diff WHERE stats_comments_id=$get_stats_comments_id") or die(mysqli_error($link));
								
								}

								// Transfer last year for print
								$comments_year 					= $get_stats_comments_year;
								$comments_comments_written			= $get_stats_comments_comments_written;
								$comments_comments_written_diff_from_last_year = $get_stats_comments_comments_written_diff_from_last_year;

								// xx
								$x++;
						} // while
						echo"</span>
						<script>
						$('.barsparks_new_comments').sparkline('html', { 
							type: 'discrete',
							lineColor: '#926dde', 
							thresholdColor: '#926dde', 
							height:'40px' });
						</script>
					  </td>
					  <td style=\"vertical-align:top;\">
                  				<p class=\"flex_col_white_bg_text_right_headline\">Comments&nbsp;in&nbsp;$comments_year</p>
                  				<p class=\"flex_col_white_bg_text_right_content\">";
						if($comments_comments_written_diff_from_last_year == 0){
							echo"<img src=\"_inc/dashboard/_img/ti_angle_flat_no_change.png\" alt=\"ti_angle_up_no_change.png\" title=\"$comments_comments_written_diff_from_last_year comments this year diff\" />";
						}
						elseif($comments_comments_written_diff_from_last_year < 0){
							echo"<img src=\"_inc/dashboard/_img/ti_angle_down_warning.png\" alt=\"ti_angle_up_warning.png\" title=\"$comments_comments_written_diff_from_last_year comments this year diff\" />";
						}
						else{
							echo"<img src=\"_inc/dashboard/_img/ti_angle_up_success.png\" alt=\"ti_angle_up_success.png\" title=\"$comments_comments_written_diff_from_last_year comments this year diff\" />";
						}
                    				echo"
						<span>$comments_comments_written</span>
            					</p>
			                  </td>
					 </tr>
					</table>
				</div> <!-- //flex_col_white_bg -->
			<!-- //Comments per year -->


		</div>
	<!-- //Row 1 -->



	<!-- Row 2 -->
		<div class=\"flex_row\">
			<!-- Visits per  month -->
				<div class=\"flex_col_white_bg\" style=\"flex:2;margin-right:0px;\">
					<div class=\"flex_col_white_bg_headline_left\">
						<h2>$year $l_numbers</h2>
					</div>
					<div class=\"flex_col_white_bg_headline_right\">
						<p><a href=\"index.php?open=dashboard&amp;page=statistics_year&amp;stats_year=$year&amp;l=$l&amp;editor_language=$editor_language\">$year statistics</a></p>
					</div>
					<div class=\"clear\"></div>

					<script>
					am4core.ready(function() {
						var chart = am4core.create(\"chartdiv_visits_per_month\", am4charts.XYChart);
						chart.data = [";

						$x = 0;
						$query = "SELECT stats_visit_per_month_id, stats_visit_per_month_month, stats_visit_per_month_month_short, stats_visit_per_month_year, stats_visit_per_month_human_unique, stats_visit_per_month_human_unique_diff_from_last_month, stats_visit_per_month_human_average_duration, stats_visit_per_month_human_new_visitor_unique, stats_visit_per_month_human_returning_visitor_unique, stats_visit_per_month_unique_desktop, stats_visit_per_month_unique_mobile, stats_visit_per_month_unique_bots, stats_visit_per_month_hits_total, stats_visit_per_month_hits_human, stats_visit_per_month_hits_desktop, stats_visit_per_month_hits_mobile, stats_visit_per_month_hits_bots FROM $t_stats_visists_per_month ORDER BY stats_visit_per_month_id ASC LIMIT 0,12";
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
						series1.name = \"Human unique\";
						series1.tooltipText = \"Human unique: {valueY}\";
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
				</div>
			<!-- //Visits per month -->
			<!-- Visits per day -->
				<div class=\"flex_col_white_bg\" style=\"flex:2;\">
				
					<div class=\"flex_col_white_bg_headline_left\">
					
				
					";
					if($month == "01"){
						echo"<h2>$l_january $l_numbers</h2>";
					}
					elseif($month == "02"){
						echo"<h2>$l_february  $l_numbers</h2>";
					}
					elseif($month == "03"){
						echo"<h2>$l_march $l_numbers</h2>";
					}
					elseif($month == "04"){
						echo"<h2>$l_april $l_numbers</h2>";
					}
					elseif($month == "05"){
						echo"<h2>$l_may $l_numbers</h2>";
					}
					elseif($month == "06"){
						echo"<h2>$l_june $l_numbers</h2>";
					}
					elseif($month == "07"){
						echo"<h2>$l_july $l_numbers</h2>";
					}
					elseif($month == "08"){
						echo"<h2>$l_august $l_numbers</h2>";
					}
					elseif($month == "09"){
						echo"<h2>$l_september $l_numbers</h2>";
					}
					elseif($month == "10"){
						echo"<h2>$l_october $l_numbers</h2>";
					}
					elseif($month == "11"){
						echo"<h2>$l_november $l_numbers</h2>";
					}
					elseif($month == "12"){
						echo"<h2>$l_december $l_numbers</h2>";
					}
					echo"
					</div>
					<div class=\"flex_col_white_bg_headline_right\">
						<p><a href=\"index.php?open=dashboard&amp;page=statistics_month&amp;stats_year=$year&amp;stats_month=$month&amp;l=$l&amp;editor_language=$editor_language\">View stats</a></p>
					</div>
					<div class=\"clear\"></div>
					<script>
					am4core.ready(function() {
						var chart = am4core.create(\"chartdiv_visits_per_day\", am4charts.XYChart);
						chart.data = [";

						$x = 0;
						$query = "SELECT stats_visit_per_day_id, stats_visit_per_day_day, stats_visit_per_day_day_single, stats_visit_per_day_human_unique, stats_visit_per_day_human_unique_diff_from_yesterday, stats_visit_per_day_human_average_duration, stats_visit_per_day_human_new_visitor_unique, stats_visit_per_day_human_returning_visitor_unique, stats_visit_per_day_unique_desktop, stats_visit_per_day_unique_mobile, stats_visit_per_day_unique_bots, stats_visit_per_day_hits_total, stats_visit_per_day_hits_human, stats_visit_per_day_hits_desktop, stats_visit_per_day_hits_mobile, stats_visit_per_day_hits_bots FROM $t_stats_visists_per_day WHERE stats_visit_per_day_month=$month AND stats_visit_per_day_year=$year ORDER BY stats_visit_per_day_id ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_stats_visit_per_day_id, $get_stats_visit_per_day_day, $get_stats_visit_per_day_day_single, $get_stats_visit_per_day_human_unique, $get_stats_visit_per_day_human_unique_diff_from_yesterday, $get_stats_visit_per_day_human_average_duration, $get_stats_visit_per_day_human_new_visitor_unique, $get_stats_visit_per_day_human_returning_visitor_unique, $get_stats_visit_per_day_unique_desktop, $get_stats_visit_per_day_unique_mobile, $get_stats_visit_per_day_unique_bots, $get_stats_visit_per_day_hits_total, $get_stats_visit_per_day_hits_human, $get_stats_visit_per_day_hits_desktop, $get_stats_visit_per_day_hits_mobile, $get_stats_visit_per_day_hits_bots) = $row;
						
							if($x > 0){
								echo",";
							}
							echo"
							{
								\"x\": \"$get_stats_visit_per_day_day_single $get_stats_visit_per_day_day\",
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
						series1.name = \"Human unique visits\";
						series1.tooltipText = \"Human unique visits: {valueY}\";
						series1.fill = am4core.color(\"#66d5c9\");
						series1.stroke = am4core.color(\"#66d5c9\");
					
						// Tooltips
						chart.cursor = new am4charts.XYCursor();
						chart.cursor.snapToSeries = series;
						chart.cursor.xAxis = valueAxis;
					}); // end am4core.ready()
					</script>
					<div id=\"chartdiv_visits_per_day\" style=\"height: 400px;\"></div>

				</div>
			<!-- //Visits per day -->


		</div>
	<!-- //Row 2 -->


	<!-- Row 3 -->
		<div class=\"flex_row\">
			<!-- Tasks -->";
			$query_statuses = "SELECT status_code_id, status_code_title, status_code_text_color, status_code_bg_color, status_code_border_color, status_code_weight, status_code_show_on_board, status_code_on_status_close_task, status_code_count_tasks FROM $t_tasks_status_codes WHERE status_code_show_on_board=1 ORDER BY status_code_weight ASC";
			$result_statuses = mysqli_query($link, $query_statuses);
			while($row_statuses = mysqli_fetch_row($result_statuses)) {
				list($get_status_code_id, $get_status_code_title, $get_status_code_text_color, $get_status_code_bg_color, $get_status_code_border_color, $get_status_code_weight, $get_status_code_show_on_board, $get_status_code_on_status_close_task, $get_status_code_count_tasks) = $row_statuses;
				
				echo"
				<div class=\"flex_col_white_bg\">
					<div class=\"flex_col_white_bg_headline_left\">
						<h2>$get_status_code_title</h2>
					</div>
					<div class=\"flex_col_white_bg_headline_right\">
						<p>
						<a href=\"index.php?open=dashboard&amp;page=tasks&amp;status_code_id=$get_status_code_id&amp;l=$l\">Open</a>	
						&middot;	
						<a href=\"index.php?open=dashboard&amp;page=tasks&amp;action=new_task&amp;status_code_id=$get_status_code_id&amp;l=$l\">New task</a>
						</p>
					</div>

					<div class=\"vertical\">
						<ul>";
						$query = "SELECT task_id, task_system_task_abbr, task_system_incremented_number, task_project_task_abbr, task_project_incremented_number, task_title, task_text, task_status_code_id, task_priority_id, task_created_datetime, task_created_by_user_id, task_created_by_user_alias, task_created_by_user_image, task_created_by_user_email, task_updated_datetime, task_due_datetime, task_due_time, task_due_translated, task_assigned_to_user_id, task_assigned_to_user_alias, task_assigned_to_user_image, task_assigned_to_user_thumb_40, task_assigned_to_user_email, task_qa_datetime, task_qa_by_user_id, task_qa_by_user_alias, task_qa_by_user_image, task_qa_by_user_email, task_finished_datetime, task_finished_by_user_id, task_finished_by_user_alias, task_finished_by_user_image, task_finished_by_user_email, task_is_archived, task_comments, task_project_id, task_project_part_id, task_system_id, task_system_part_id FROM $t_tasks_index ";
						$query = $query . "WHERE task_status_code_id=$get_status_code_id AND task_is_archived='0' ORDER BY task_priority_id, task_id ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_task_id, $get_task_system_task_abbr, $get_task_system_incremented_number, $get_task_project_task_abbr, $get_task_project_incremented_number, $get_task_title, $get_task_text, $get_task_status_code_id, $get_task_priority_id, $get_task_created_datetime, $get_task_created_by_user_id, $get_task_created_by_user_alias, $get_task_created_by_user_image, $get_task_created_by_user_email, $get_task_updated_datetime, $get_task_due_datetime, $get_task_due_time, $get_task_due_translated, $get_task_assigned_to_user_id, $get_task_assigned_to_user_alias, $get_task_assigned_to_user_image, $get_task_assigned_to_user_thumb_40, $get_task_assigned_to_user_email, $get_task_qa_datetime, $get_task_qa_by_user_id, $get_task_qa_by_user_alias, $get_task_qa_by_user_image, $get_task_qa_by_user_email, $get_task_finished_datetime, $get_task_finished_by_user_id, $get_task_finished_by_user_alias, $get_task_finished_by_user_image, $get_task_finished_by_user_email, $get_task_is_archived, $get_task_comments, $get_task_project_id, $get_task_project_part_id, $get_task_system_id, $get_task_system_part_id) = $row;
			
							// Number
							$number = "";
							if($get_task_project_incremented_number == "0" OR $get_task_project_incremented_number == ""){
								if($get_task_system_incremented_number == "0" OR $get_task_system_incremented_number == ""){
									$number = "$get_task_id";
								}
								else{
									$number = "$get_task_system_task_abbr-$get_task_system_incremented_number";
								}
							}
							else{
								$number = "$get_task_project_task_abbr-$get_task_project_incremented_number";
							}

							// Read?
							$query_r = "SELECT read_id FROM $t_tasks_read WHERE read_task_id=$get_task_id AND read_user_id=$my_user_id_mysql";
							$result_r = mysqli_query($link, $query_r);
							$row_r = mysqli_fetch_row($result_r);
							list($get_read_id) = $row_r;	

					
							echo"
							<li><a href=\"index.php?open=$open&amp;page=tasks&amp;action=open_task&amp;task_id=$get_task_id&amp;l=$l&amp;editor_language=$editor_language\""; if($get_read_id == ""){ echo" style=\"font-weight: bold;\""; } echo">";

							// Assigned to image
							if($get_task_assigned_to_user_id == "" OR $get_task_assigned_to_user_id == "0"){
					
							}
							else{
								if($get_task_assigned_to_user_thumb_40 != "" && file_exists("../_uploads/users/images/$get_task_assigned_to_user_id/$get_task_assigned_to_user_thumb_40")){
									echo"
									<img src=\"../_uploads/users/images/$get_task_assigned_to_user_id/$get_task_assigned_to_user_thumb_40\" alt=\"../$get_task_assigned_to_user_thumb_40/_uploads/users/images/$get_task_assigned_to_user_id/$get_task_assigned_to_user_thumb_40\" width=\"20\" height=\"20\" />
									";
								}
								else{
									echo"
									<img src=\"_inc/dashboard/_img/avatar_blank_40.png\" alt=\"avatar_blank_40.png\" width=\"20\" height=\"20\" />
									";
								}

							}
							echo"
							$number  $get_task_title</a></li>
							";
						}
						echo"
						</ul>
					</div>
				</div>";
			} // categories
			echo"
			<!-- //Tasks -->
		</div>
	<!-- //Row 3 -->


	";
}


?>