<?php
/**
*
* File: _admin/_inc/media/default.php
* Version 2
* Date 16:12 27.04.2019
* Copyright (c) 2021 Sindre Andre Ditlefsen
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
$t_stats_visists_per_week 	   	= $mysqlPrefixSav . "stats_visists_per_week";
$t_stats_visists_per_day 	   	= $mysqlPrefixSav . "stats_visists_per_day";
$t_stats_users_registered_per_year 	= $mysqlPrefixSav . "stats_users_registered_per_year";
$t_stats_users_registered_per_week 	= $mysqlPrefixSav . "stats_users_registered_per_week";
$t_stats_comments_per_year 		= $mysqlPrefixSav . "stats_comments_per_year";
$t_stats_comments_per_week		= $mysqlPrefixSav . "stats_comments_per_week";

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


			</div> <!-- //main_right_content -->
			<div class=\"clear_main_right_content\">

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
			echo"
			<div class=\"$ft\" style=\"margin: 0px 20px 20px 20px;\"><span>$fm</span></div>";
		}
		echo"	
	<!-- //Feedback -->

	<!-- Check if setup folder exists -->
		";
		if(file_exists("setup/index.php")){
			echo"
			<div class=\"white_bg_box\"><span><b>Security issue:</b> The setup folder exists. Do you want to <a href=\"index.php?open=dashboard&amp;page=delete_setup_folder&amp;editor_language=$editor_language&amp;l=$l\">delete the setup folder</a>?</span></div> 
			";
		}
		echo"
	<!-- //Check if setup folder exists -->


	<!-- Row 1 -->
		<div class=\"flex_row\">

			<!-- 1.1 Visits per week -->
				<div class=\"flex_col_white_bg\">
					<p class=\"flex_col_white_bg_text_left_content\"><span class=\"barsparks_this_year\">";

							$x = 0;

							$visit_per_week_week 					= 0;
							$visit_per_week_human_unique				= 0;
							$visit_per_week_human_unique_diff_from_last_week	= 0;

							$query = "SELECT stats_visit_per_week_id, stats_visit_per_week_week, stats_visit_per_week_year, stats_visit_per_week_human_unique, stats_visit_per_week_human_unique_diff_from_last_week FROM $t_stats_visists_per_week ORDER BY stats_visit_per_week_id ASC LIMIT 0,12";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_stats_visit_per_week_id, $get_stats_visit_per_week_week, $get_stats_visit_per_week_year, $get_stats_visit_per_week_human_unique, $get_stats_visit_per_week_human_unique_diff_from_last_week) = $row;
	

								if($x > 0){
									echo",";
								}
								echo"$get_stats_visit_per_week_human_unique";
								
								// Check that diff is ok
								$diff = $get_stats_visit_per_week_human_unique-$visit_per_week_human_unique;
								if($diff != "$get_stats_visit_per_week_human_unique_diff_from_last_week"){
									$res_update = mysqli_query($link, "UPDATE $t_stats_visists_per_week SET stats_visit_per_week_human_unique_diff_from_last_week=$diff WHERE stats_visit_per_week_id=$get_stats_visit_per_week_id") or die(mysqli_error($link));
								
								}

								// Transfer last year for print
								$visit_per_week_week				 = $get_stats_visit_per_week_week;
								$visit_per_week_year				 = $get_stats_visit_per_week_year;
								$visit_per_week_human_unique			 = $get_stats_visit_per_week_human_unique;
								$visit_per_week_human_unique_diff_from_last_week = $get_stats_visit_per_week_human_unique_diff_from_last_week;


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
						<p class=\"flex_col_white_bg_text_right_headline\">Unique&nbsp;visits&nbsp;in&nbsp;week&nbsp;$visit_per_week_week</p>
                  				<p class=\"flex_col_white_bg_text_right_content\">";
						if($visit_per_week_human_unique_diff_from_last_week == 0){
							echo"<img src=\"_inc/dashboard/_img/ti_angle_flat_no_change.png\" alt=\"ti_angle_up_no_change.png\" title=\"Same as last week ($visit_per_week_human_unique_diff_from_last_week unique human visits diff)\" />";
						}
						elseif($visit_per_week_human_unique_diff_from_last_week < 0){
							echo"<img src=\"_inc/dashboard/_img/ti_angle_down_warning.png\" alt=\"ti_angle_up_warning.png\" title=\"Decreased with $visit_per_week_human_unique_diff_from_last_week unique humans from last week\" />";
						}
						else{
							echo"<img src=\"_inc/dashboard/_img/ti_angle_up_success.png\" alt=\"ti_angle_up_success.png\" title=\"Increasted with $visit_per_week_human_unique_diff_from_last_week unique humans from last week\" />";
						}
                    				echo"
						<span>$visit_per_week_human_unique</span>
            					</p>
					</div>
				</div> <!-- //flex_col_white_bg -->
			<!-- //1.1 Visits per week -->


			<!-- 1.2 Comments per week -->
				<div class=\"flex_col_white_bg\">
					<table style=\"width: 100%;\">
					 <tr>
					  <td style=\"vertical-align:top;\">
						<span class=\"barsparks_comments_written\">";

						$x = 0;

						$comments_week					= 0;
						$comments_comments_written			= 0;
						$comments_comments_written_diff_from_last_week 	= 0;

						$query = "SELECT stats_comments_id, stats_comments_week, stats_comments_month, stats_comments_year, stats_comments_comments_written, stats_comments_comments_written_diff_from_last_week FROM $t_stats_comments_per_week ORDER BY stats_comments_id ASC LIMIT 0,12";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_stats_comments_id, $get_stats_comments_week, $get_stats_comments_month, $get_stats_comments_year, $get_stats_comments_comments_written, $get_stats_comments_comments_written_diff_from_last_week) = $row;
	

								if($x > 0){
									echo",";
								}
								echo"$get_stats_comments_comments_written";
								
								// Check that diff is ok
								$diff = $get_stats_comments_comments_written-$comments_comments_written;
								if($diff != "$get_stats_comments_comments_written_diff_from_last_week"){
									$res_update = mysqli_query($link, "UPDATE $t_stats_comments_per_week SET stats_comments_comments_written_diff_from_last_week=$diff WHERE stats_comments_id=$get_stats_comments_id") or die(mysqli_error($link));
								
								}

								// Transfer last week for print
								$comments_week					= $get_stats_comments_week;
								$comments_comments_written			= $get_stats_comments_comments_written;
								$comments_comments_written_diff_from_last_week 	= $get_stats_comments_comments_written_diff_from_last_week;

								// xx
								$x++;
						} // while
						echo"</span>
						<script>
						$('.barsparks_comments_written').sparkline('html', { 
							lineColor: '#99e4dc', 
							spotColor: '#33cabb', 
							minSpotColor: '#33cabb', 
							maxSpotColor: '#33cabb', 
							fillColor: false, height:'40px', barWidth:60
							});
						</script>
					  </td>
					  <td style=\"vertical-align:top;\">";
						if($comments_week == "0" OR $comments_week != "$week"){
							echo"
							<p class=\"flex_col_white_bg_text_right_headline\">Comments&nbsp;in&nbsp;week&nbsp;$week</p>
							<p class=\"flex_col_white_bg_text_right_content\"><span>0</span>
            						</p>";
                  				}
						else{
							echo"
							<p class=\"flex_col_white_bg_text_right_headline\">Comments&nbsp;in&nbsp;week&nbsp;$comments_week</p>
                  					<p class=\"flex_col_white_bg_text_right_content\">";
							if($comments_comments_written_diff_from_last_week == 0){
								echo"<img src=\"_inc/dashboard/_img/ti_angle_flat_no_change.png\" alt=\"ti_angle_up_no_change.png\" title=\"Same amount of comments as last week ($comments_comments_written_diff_from_last_week comments)\" />";
							}
							elseif($comments_comments_written_diff_from_last_week < 0){
								echo"<img src=\"_inc/dashboard/_img/ti_angle_down_warning.png\" alt=\"ti_angle_up_warning.png\" title=\"Decrease by $comments_comments_written_diff_from_last_week comments from last week\" />";
							}
							else{
								echo"<img src=\"_inc/dashboard/_img/ti_angle_up_success.png\" alt=\"ti_angle_up_success.png\" title=\"Increas by $comments_comments_written_diff_from_last_week comments from last week\" />";
							}
                    					echo"
							<span>$comments_comments_written</span>
            						</p>";
						}
						echo"
			                  </td>
					 </tr>
					</table>";
					if($comments_week == "0" OR $comments_week != "$week"){
						mysqli_query($link, "INSERT INTO $t_stats_comments_per_week 
						(stats_comments_id, stats_comments_week, stats_comments_month, stats_comments_year, stats_comments_comments_written) 
						VALUES 
						(NULL, $week, $month, $year, 0)")
						or die(mysqli_error($link));
					}
					echo"
				</div> <!-- //flex_col_white_bg -->
			<!-- //1.2 Comments per week -->




			<!-- 1.3 Users per week -->
				<div class=\"flex_col_white_bg\">
					<table style=\"width: 100%;\">
					 <tr>
					  <td style=\"vertical-align:top;\">
						<span class=\"barsparks_users_registered\">";

						$x = 0;

						$registered_week				= 0;
						$registered_users_registed			= 0;
						$registered_users_registed_diff_from_last_week	= 0;

						$query = "SELECT stats_registered_id, stats_registered_week, stats_registered_year, stats_registered_users_registed, stats_registered_users_registed_diff_from_last_week FROM $t_stats_users_registered_per_week ORDER BY stats_registered_id ASC LIMIT 0,12";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_stats_registered_id, $get_stats_registered_week, $get_stats_registered_year, $get_stats_registered_users_registed, $get_stats_registered_users_registed_diff_from_last_week) = $row;
	

							if($x > 0){
								echo",";
							}
							echo"$get_stats_registered_users_registed";
								
							// Check that diff is ok
							$diff = $get_stats_registered_users_registed-$registered_users_registed;
							if($diff  != "$get_stats_registered_users_registed_diff_from_last_week"){
								$res_update = mysqli_query($link, "UPDATE $t_stats_users_registered_per_week SET stats_registered_users_registed_diff_from_last_week=$diff WHERE stats_registered_id=$get_stats_registered_id") or die(mysqli_error($link));
							}

							// Transfer last year for print
							$registered_week				= $get_stats_registered_week;
							$registered_users_registed			= $get_stats_registered_users_registed;
							$registered_users_registed_diff_from_last_week	= $get_stats_registered_users_registed_diff_from_last_week;

							// xx
							$x++;
						} // while
						echo"</span>
						<script>
						$('.barsparks_users_registered').sparkline('html', { 
							type: 'discrete',
							lineColor: '#926dde', 
							thresholdColor: '#926dde', 
							height:'40px' });
						</script>
					  </td>
					  <td style=\"vertical-align:top;\">";
						if($registered_week == "0" OR $registered_week != "$week"){
							echo"
                  					<p class=\"flex_col_white_bg_text_right_headline\">New&nbsp;users&nbsp;in&nbsp;week&nbsp;$week</p>
                  					<p class=\"flex_col_white_bg_text_right_content\"><span>0</span></p>
							";
						}
						else{
							echo"
                  					<p class=\"flex_col_white_bg_text_right_headline\">New&nbsp;users&nbsp;in&nbsp;week&nbsp;$registered_week</p>
                  					<p class=\"flex_col_white_bg_text_right_content\">";
							if($registered_users_registed_diff_from_last_week == 0){
								echo"<img src=\"_inc/dashboard/_img/ti_angle_flat_no_change.png\" alt=\"ti_angle_up_no_change.png\" title=\"Same users as last week ($registered_users_registed_diff_from_last_week)\" />";
							}
							elseif($registered_users_registed_diff_from_last_week < 0){
								echo"<img src=\"_inc/dashboard/_img/ti_angle_down_warning.png\" alt=\"ti_angle_up_warning.png\" title=\"Decrease in users registered by $registered_users_registed_diff_from_last_week\" />";
							}
							else{
								echo"<img src=\"_inc/dashboard/_img/ti_angle_up_success.png\" alt=\"ti_angle_up_success.png\" title=\"Increase in users registered by $registered_users_registed_diff_from_last_week\" />";
							}
                    					echo"
							<span>$registered_users_registed</span>
            						</p>
							";
						}
						echo"
			                  </td>
					 </tr>
					</table>";
					if($registered_week == "0" OR $registered_week != "$week"){
						mysqli_query($link, "INSERT INTO $t_stats_users_registered_per_week 
						(stats_registered_id, stats_registered_week, stats_registered_year, stats_registered_users_registed, stats_registered_users_registed_diff_from_last_week) 
						VALUES 
						(NULL, $week, $year, 0, 0)")
						or die(mysqli_error($link));
					}
					echo"
				</div> <!-- //flex_col_white_bg -->
			<!-- //1.3 Users per week -->


		</div>
	<!-- //Row 1 -->



	<!-- Row 2 -->
		<div class=\"flex_row\">
			<!-- 2.1 Visits per month -->
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
			<!-- New Tasks / Unassigned -->
				<div class=\"flex_col_white_bg\">";

			$time = time();

			$query_t = "SELECT status_code_id, status_code_title, status_code_text_color, status_code_bg_color, status_code_border_color, status_code_weight, status_code_show_on_board, status_code_on_status_close_task, status_code_count_tasks FROM $t_tasks_status_codes WHERE status_code_show_on_board=1 AND status_code_task_is_assigned=0 ORDER BY status_code_weight ASC LIMIT 0,1";
			$result_t = mysqli_query($link, $query_t);
			$row_t = mysqli_fetch_row($result_t);
			list($get_status_code_id, $get_status_code_title, $get_status_code_text_color, $get_status_code_bg_color, $get_status_code_border_color, $get_status_code_weight, $get_status_code_show_on_board, $get_status_code_on_status_close_task, $get_status_code_count_tasks) = $row_t;	

					echo"
					<div class=\"task_status_headline\">
						<div class=\"task_status_headline_left\">
							<h2>$get_status_code_title</h2>
						</div>
						<div class=\"task_status_headline_right\">
							<p>
							<a href=\"index.php?open=dashboard&amp;page=tasks&amp;action=new_task&amp;status_code_id=$get_status_code_id&amp;l=$l\">+</a>
							</p>
						</div>
					</div>
					<div class=\"clear\"></div>";

						$query = "SELECT task_id, task_system_task_abbr, task_system_incremented_number, task_project_task_abbr, task_project_incremented_number, task_title, task_text, task_status_code_id, task_priority_id, task_priority_weight, task_created_datetime, task_created_by_user_id, task_created_by_user_alias, task_created_by_user_image, task_created_by_user_email, task_updated_datetime, task_due_datetime, task_due_time, task_due_translated, task_assigned_to_user_id, task_assigned_to_user_alias, task_assigned_to_user_image, task_assigned_to_user_thumb_40, task_assigned_to_user_email, task_qa_datetime, task_qa_by_user_id, task_qa_by_user_alias, task_qa_by_user_image, task_qa_by_user_email, task_finished_datetime, task_finished_by_user_id, task_finished_by_user_alias, task_finished_by_user_image, task_finished_by_user_email, task_is_archived, task_comments, task_project_id, task_project_part_id, task_system_id, task_system_part_id FROM $t_tasks_index ";
						$query = $query . "WHERE task_status_code_id=$get_status_code_id AND task_is_archived='0' ORDER BY task_priority_id, task_id ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_task_id, $get_task_system_task_abbr, $get_task_system_incremented_number, $get_task_project_task_abbr, $get_task_project_incremented_number, $get_task_title, $get_task_text, $get_task_status_code_id, $get_task_priority_id, $get_task_priority_weight, $get_task_created_datetime, $get_task_created_by_user_id, $get_task_created_by_user_alias, $get_task_created_by_user_image, $get_task_created_by_user_email, $get_task_updated_datetime, $get_task_due_datetime, $get_task_due_time, $get_task_due_translated, $get_task_assigned_to_user_id, $get_task_assigned_to_user_alias, $get_task_assigned_to_user_image, $get_task_assigned_to_user_thumb_40, $get_task_assigned_to_user_email, $get_task_qa_datetime, $get_task_qa_by_user_id, $get_task_qa_by_user_alias, $get_task_qa_by_user_image, $get_task_qa_by_user_email, $get_task_finished_datetime, $get_task_finished_by_user_id, $get_task_finished_by_user_alias, $get_task_finished_by_user_image, $get_task_finished_by_user_email, $get_task_is_archived, $get_task_comments, $get_task_project_id, $get_task_project_part_id, $get_task_system_id, $get_task_system_part_id) = $row;

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
							<div class=\"task_content_priority_$get_task_priority_weight\">

								<p>
								<a href=\"index.php?open=$open&amp;page=tasks&amp;action=open_task&amp;task_id=$get_task_id&amp;l=$l&amp;editor_language=$editor_language\""; if($get_read_id == ""){ echo" style=\"font-weight: bold;\""; } echo">";

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
								$number  $get_task_title</a>
								</p>
							</div> <!-- //task_priority_x -->
							";
						}
						echo"
				</div> <!-- //flex_col_white_bg -->
			<!-- //New Tasks / Unassigned -->


			<!-- Tasks per admin -->";

				$query_u = "SELECT user_id, user_email, user_name FROM $t_users WHERE user_rank='admin' ORDER BY user_name ASC";
				$result_u = mysqli_query($link, $query_u);
				while($row_u = mysqli_fetch_row($result_u)) {
					list($get_user_id, $get_user_email, $get_user_name) = $row_u;

					// Get my photo
					$query = "SELECT photo_id, photo_destination, photo_thumb_40, photo_thumb_50 FROM $t_users_profile_photo WHERE photo_user_id=$get_user_id AND photo_profile_image='1'";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_photo_id, $get_photo_destination, $get_photo_thumb_40, $get_photo_thumb_50) = $row;

					echo"
					<div class=\"flex_col_white_bg\">
						<div class=\"task_status_headline\">
							<div class=\"task_status_headline_left\">
								
								
									<p>";
									// Assigned to image
									if($get_photo_thumb_40 != "" && file_exists("../_uploads/users/images/$get_user_id/$get_photo_thumb_40")){
										echo"
										<img src=\"../_uploads/users/images/$get_user_id/$get_photo_thumb_40\" alt=\"$get_photo_thumb_40\" width=\"20\" height=\"20\" />
										";
									}
									else{
										echo"
										<img src=\"_inc/dashboard/_img/avatar_blank_40.png\" alt=\"avatar_blank_40.png\" width=\"20\" height=\"20\" />
										";
									}
									echo"</p>
								
									<h2 style=\"padding: 8px 0px 8px 0px;\">$get_user_name</h2>
								
							</div>
							<div class=\"task_status_headline_right\">
								<p>
								<a href=\"index.php?open=dashboard&amp;page=tasks&amp;action=new_task&amp;status_code_id=$get_status_code_id&amp;inp_assigned_to_user_alias=$get_user_name&amp;l=$l\">+</a>
								</p>
							</div>
						</div>
						<div class=\"clear\"></div>
						";

						// Statuses
						$query_s = "SELECT status_code_id, status_code_title, status_code_text_color, status_code_bg_color, status_code_border_color, status_code_weight, status_code_show_on_board, status_code_on_status_close_task, status_code_count_tasks FROM $t_tasks_status_codes WHERE status_code_show_on_board=1 AND status_code_task_is_assigned=1 ORDER BY status_code_weight ASC";
						$result_s = mysqli_query($link, $query_s);
						while($row_s = mysqli_fetch_row($result_s)) {
							list($get_status_code_id, $get_status_code_title, $get_status_code_text_color, $get_status_code_bg_color, $get_status_code_border_color, $get_status_code_weight, $get_status_code_show_on_board, $get_status_code_on_status_close_task, $get_status_code_count_tasks) = $row_s;

							echo"
							<h3>$get_status_code_title</h3>
							";

							// Tasks
							$query = "SELECT task_id, task_system_task_abbr, task_system_incremented_number, task_project_task_abbr, task_project_incremented_number, task_title, task_text, task_status_code_id, task_priority_id, task_priority_weight, task_created_datetime, task_created_by_user_id, task_created_by_user_alias, task_created_by_user_image, task_created_by_user_email, task_updated_datetime, task_due_datetime, task_due_time, task_due_translated, task_assigned_to_user_id, task_assigned_to_user_alias, task_assigned_to_user_image, task_assigned_to_user_thumb_40, task_assigned_to_user_email, task_qa_datetime, task_qa_by_user_id, task_qa_by_user_alias, task_qa_by_user_image, task_qa_by_user_email, task_finished_datetime, task_finished_by_user_id, task_finished_by_user_alias, task_finished_by_user_image, task_finished_by_user_email, task_is_archived, task_comments, task_project_id, task_project_part_id, task_system_id, task_system_part_id FROM $t_tasks_index ";
							$query = $query . "WHERE task_status_code_id=$get_status_code_id AND task_assigned_to_user_id=$get_user_id AND task_is_archived='0' ORDER BY task_priority_id, task_id ASC";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_task_id, $get_task_system_task_abbr, $get_task_system_incremented_number, $get_task_project_task_abbr, $get_task_project_incremented_number, $get_task_title, $get_task_text, $get_task_status_code_id, $get_task_priority_id, $get_task_priority_weight, $get_task_created_datetime, $get_task_created_by_user_id, $get_task_created_by_user_alias, $get_task_created_by_user_image, $get_task_created_by_user_email, $get_task_updated_datetime, $get_task_due_datetime, $get_task_due_time, $get_task_due_translated, $get_task_assigned_to_user_id, $get_task_assigned_to_user_alias, $get_task_assigned_to_user_image, $get_task_assigned_to_user_thumb_40, $get_task_assigned_to_user_email, $get_task_qa_datetime, $get_task_qa_by_user_id, $get_task_qa_by_user_alias, $get_task_qa_by_user_image, $get_task_qa_by_user_email, $get_task_finished_datetime, $get_task_finished_by_user_id, $get_task_finished_by_user_alias, $get_task_finished_by_user_image, $get_task_finished_by_user_email, $get_task_is_archived, $get_task_comments, $get_task_project_id, $get_task_project_part_id, $get_task_system_id, $get_task_system_part_id) = $row;
			
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
								<div class=\"task_content_priority_$get_task_priority_weight\">
 									<!-- Due -->";
										if($time > $get_task_due_time){
											echo"<div class=\"task_content_info\">
												<p>$get_task_due_translated</p>
											</div>\n";
										}
										echo"
 									<!-- //Due -->
									<p>
									<a href=\"index.php?open=$open&amp;page=tasks&amp;action=open_task&amp;task_id=$get_task_id&amp;l=$l&amp;editor_language=$editor_language\""; if($get_read_id == ""){ echo" style=\"font-weight: bold;\""; } echo">$number $get_task_title</a>
									</p>
								</div>
								";
							} // tasks (for this admin)
							echo"
							";
						} // statuses

						echo"
					</div> <!-- //flex_col_white_bg -->
					";
				} // admins
				echo"

			<!-- //Tasks per admin -->
		</div>
		";
		include("_inc/dashboard/tasks_include_send_monthly_newsletter.php");
		echo"
	<!-- //Row 3 -->
	";
}


?>