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
		<script src=\"_javascripts/amcharts/amcharts/amcharts.js\"></script>
		<script src=\"_javascripts/amcharts/amcharts/serial.js\"></script>
		<script src=\"_javascripts/amcharts/amcharts/pie.js\" type=\"text/javascript\"></script>
	<!-- //Charts javascript -->



	</div>
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


	<div>

	<!-- Row 1 -->
		<div class=\"first_row_flex_row\">

			<!-- This years numbers -->";

				$query = "SELECT count(user_id) FROM $t_users";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_count_users) = $row;

				echo"
				<div class=\"flex_col_white_bg\">
					<p class=\"flex_col_white_bg_text_left_content\"><span class=\"barsparks_this_year\">";
	
					$x = 0;
					$get_stats_monthly_unique = 0;
					$get_stats_monthly_unique_diff_from_last_month = 0;
					$query = "SELECT stats_monthly_id, stats_monthly_month, stats_monthly_human_unique, stats_monthly_human_unique_diff_from_last_month FROM $t_stats_monthly WHERE stats_monthly_year=$year_mysql ORDER BY stats_monthly_id ASC LIMIT 0,12";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_stats_monthly_id, $get_stats_monthly_month, $get_stats_monthly_human_unique, $get_stats_monthly_human_unique_diff_from_last_month) = $row;
	
						if($x > 0){
							echo",";
						}
						echo"$get_stats_monthly_human_unique";


						// xx
						$x++;
						
						// Calculate diff
						if(isset($unique_last_month)){
							$diff = $get_stats_monthly_human_unique-$unique_last_month;
							if($diff != $get_stats_monthly_human_unique_diff_from_last_month){
								$res_update = mysqli_query($link, "UPDATE $t_stats_monthly SET stats_monthly_human_unique_diff_from_last_month=$diff WHERE stats_monthly_id=$get_stats_monthly_id") or die(mysqli_error($link));
								$get_stats_monthly_human_unique_diff_from_last_month = $diff;
							}

						}

						// Holder variables for next iteration
						$unique_last_month = $get_stats_monthly_human_unique;


					}
					echo"</span></p>";
					if($x == 1){
						echo"<img src=\"_inc/dashboard/_img/sparkline_no_data.png\" alt=\"sparkline_no_data.png\" />";
					}
					
					echo"
					<script>
						$('.barsparks_this_year').sparkline('html', { 
							type: 'bar',
							barColor: '#f2a654', 
							barWidth: 7,
							barSpacing: 4, 
							height:'40px' });
					</script>

                			<div class=\"flex_col_white_bg_text_right\">
                  				<p class=\"flex_col_white_bg_text_right_headline\">";

						if($month == "01"){
							echo"$l_january";
						}
						elseif($month == "02"){
							echo"$l_february";
						}
						elseif($month == "03"){
							echo"$l_march";
						}
						elseif($month == "04"){
							echo"$l_april";
						}
						elseif($month == "05"){
							echo"$l_may";
						}
						elseif($month == "06"){
							echo"$l_june";
						}
						elseif($month == "07"){
							echo"$l_july";
						}
						elseif($month == "08"){
							echo"$l_august";
						}
						elseif($month == "09"){
							echo"$l_september";
						}
						elseif($month == "10"){
							echo"$l_october";
						}
						elseif($month == "11"){
							echo"$l_november";
						}
						elseif($month == "12"){
							echo"$l_december";
						}
						echo" unique visits</p>
                  				<p class=\"flex_col_white_bg_text_right_content\">";
						if($get_stats_monthly_unique_diff_from_last_month == 0){
							echo"<img src=\"_inc/dashboard/_img/ti_angle_flat_no_change.png\" alt=\"ti_angle_up_no_change.png\" />";
						}
						elseif($get_stats_monthly_unique_diff_from_last_month < 0){
							echo"<img src=\"_inc/dashboard/_img/ti_angle_down_warning.png\" alt=\"ti_angle_up_warning.png\" />";
						}
						else{
							echo"<img src=\"_inc/dashboard/_img/ti_angle_up_success.png\" alt=\"ti_angle_up_success.png\" />";
						}
                    				echo"
						<span>$get_stats_monthly_unique</span>
            					</p>
			                </div>
				</div>
			<!-- //This years numbers -->

			<!-- Users -->";
				$query = "SELECT count(user_id) FROM $t_users";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_count_users) = $row;

				echo"

				<div class=\"flex_col_white_bg\">
					<p class=\"flex_col_white_bg_text_left_content\"><span class=\"barsparks_user_registered\">";
	
					$x = 0;
					$query = "SELECT weekly_id, weekly_users_registed, weekly_users_registed_diff_from_last_week FROM $t_stats_users_registered_weekly ORDER BY weekly_id DESC LIMIT 0,20";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_weekly_id, $get_weekly_users_registed, $get_weekly_users_registed_diff_from_last_week) = $row;

						if($x > 0){
							echo",";
						}
						echo"$get_weekly_users_registed";
						$x++;

						
						// Calculate diff
						if(isset($weekly_user_registered_last_week)){
							$diff = $weekly_user_registered_last_week-$get_weekly_users_registed;
							if($diff != $get_weekly_users_registed_diff_from_last_week){
								$res_update = mysqli_query($link, "UPDATE $t_stats_users_registered_weekly SET weekly_users_registed_diff_from_last_week=$diff WHERE weekly_id=$get_weekly_id") or die(mysqli_error($link));
								$get_weekly_users_registed_diff_from_last_week = $diff;
							}

						}

						// Holder variables for next iteration
						$weekly_user_registered_last_week = $get_weekly_users_registed;


					}
					echo"</span></p>";
					if($x == 1){
						echo"<img src=\"_inc/dashboard/_img/sparkline_no_data.png\" alt=\"sparkline_no_data.png\" />";
					}
					
					echo"
					<script>
						$('.barsparks_user_registered').sparkline('html', { 
							lineColor: '#99e4dc', 
							spotColor: '#33cabb', 
							minSpotColor: '#33cabb', 
							maxSpotColor: '#33cabb', 
							fillColor: false, height:'40px', barWidth:60
							});
					</script>

                			<div class=\"flex_col_white_bg_text_right\">
                  				<p class=\"flex_col_white_bg_text_right_headline\">New users</p>
                  				<p class=\"flex_col_white_bg_text_right_content\">";
						if(!(isset($get_weekly_users_registed_diff_from_last_week))){
							$get_weekly_users_registed_diff_from_last_week = 0;
						}
						if($get_weekly_users_registed_diff_from_last_week == 0){
							echo"<img src=\"_inc/dashboard/_img/ti_angle_flat_no_change.png\" alt=\"ti_angle_up_no_change.png\" />";
						}
						elseif($get_weekly_users_registed_diff_from_last_week < 0){
							echo"<img src=\"_inc/dashboard/_img/ti_angle_down_warning.png\" alt=\"ti_angle_up_warning.png\" />";
						}
						else{
							echo"<img src=\"_inc/dashboard/_img/ti_angle_up_success.png\" alt=\"ti_angle_up_success.png\" />";
						}
						echo"
                    				<span>$get_weekly_users_registed_diff_from_last_week</span>
            					</p>
			                </div>
				</div>
			<!-- //Users -->



			<!-- Comments -->";

				echo"

				<div class=\"flex_col_white_bg\">
					<p class=\"flex_col_white_bg_text_left_content\"><span class=\"barsparks_new_comments\">";
	
					$x = 0;
					
					$query = "SELECT weekly_id, weekly_comments_written, weekly_comments_written_diff_from_last_week FROM $t_stats_comments_weekly ORDER BY weekly_id DESC LIMIT 0,20";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_weekly_id, $get_weekly_comments_written, $get_weekly_comments_written_diff_from_last_week) = $row;
						if($x > 0){
							echo",";
						}
						echo"$get_weekly_comments_written,$get_weekly_comments_written";
						$x++;
						
						// Calculate diff
						if(isset($weekly_comments_written_last_week)){
							$diff = $weekly_comments_written_last_week-$get_weekly_comments_written;
							if($diff != $get_weekly_comments_written_diff_from_last_week){
								$res_update = mysqli_query($link, "UPDATE $t_stats_comments_weekly SET weekly_comments_written_diff_from_last_week=$diff WHERE weekly_id=$get_weekly_id");
								$get_weekly_comments_written_diff_from_last_week = $diff;
							}

						}

						// Holder variables for next iteration
						$weekly_comments_written_last_week = $get_weekly_comments_written;
					}
					echo"</span></p>";
					if($x == 1){
						echo"<img src=\"_inc/dashboard/_img/sparkline_no_data.png\" alt=\"sparkline_no_data.png\" />";
					}
					
					echo"
					<script>
						$('.barsparks_new_comments').sparkline('html', { 
							type: 'discrete',
							lineColor: '#926dde', 
							thresholdColor: '#926dde', 
							height:'40px' });
					</script>

                			<div class=\"flex_col_white_bg_text_right\">
                  				<p class=\"flex_col_white_bg_text_right_headline\">New comments</p>
                  				<p class=\"flex_col_white_bg_text_right_content\">
 						";
						if(!(isset($get_weekly_comments_written_diff_from_last_week))){
							$get_weekly_comments_written_diff_from_last_week = 0;
						}
						if($get_weekly_comments_written_diff_from_last_week == 0){
							echo"<img src=\"_inc/dashboard/_img/ti_angle_flat_no_change.png\" alt=\"ti_angle_up_no_change.png\" />";
						}
						elseif($get_weekly_comments_written_diff_from_last_week < 0){
							echo"<img src=\"_inc/dashboard/_img/ti_angle_down_warning.png\" alt=\"ti_angle_up_warning.png\" />";
						}
						else{
							echo"<img src=\"_inc/dashboard/_img/ti_angle_up_success.png\" alt=\"ti_angle_up_success.png\" />";
						}
						echo"
                    				<span>$get_weekly_comments_written_diff_from_last_week</span>
            					</p>
			                </div>
				</div>
			<!-- //Comments -->

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
						<p><a href=\"index.php?open=dashboard&amp;page=statistics&amp;l=$l&amp;editor_language=$editor_language\">Statistics</a></p>
					</div>";

						$chart_data = "";
						$query = "SELECT stats_monthly_id, stats_monthly_month, stats_monthly_month_saying, stats_monthly_year, stats_monthly_human_unique, stats_monthly_unique_desktop, stats_monthly_unique_mobile, stats_monthly_unique_bots, stats_monthly_hits, stats_monthly_hits_desktop, stats_monthly_hits_mobile, stats_monthly_hits_bots, stats_monthly_sum_unique_browsers, stats_monthly_sum_unique_os FROM $t_stats_monthly ORDER BY stats_monthly_id DESC LIMIT 0,12";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_stats_monthly_id, $get_stats_monthly_month, $get_stats_monthly_month_saying, $get_stats_monthly_year, $get_stats_monthly_human_unique, $get_stats_monthly_unique_desktop, $get_stats_monthly_unique_mobile, $get_stats_monthly_unique_bots, $get_stats_monthly_hits, $get_stats_monthly_hits_desktop, $get_stats_monthly_hits_mobile, $get_stats_monthly_hits_bots, $get_stats_monthly_sum_unique_browsers, $get_stats_monthly_sum_unique_os) = $row;
							
							$year_saying = substr($get_stats_monthly_year, 2, 2);

							if($chart_data == ""){
								$chart_data = "{
									\"month\": \"$get_stats_monthly_month_saying $year_saying\",
									\"value\": $get_stats_monthly_human_unique
								}";	
							}
							else{
								$chart_data =  " {
									\"month\": \"$get_stats_monthly_month_saying $year_saying\",
									\"value\": $get_stats_monthly_human_unique
								}," . $chart_data;	
							}

						}
					echo"
        				<script>
						var chart;
						var graph;

						var chartDataVisitsYear = [$chart_data];


						AmCharts.ready(function() {

						  // SERIAL CHART
						  chart = new AmCharts.AmSerialChart();
						  chart.dataProvider = chartDataVisitsYear;
						  chart.categoryField = \"month\";
						  chart.hideCredits = \"true\";

						  // AXES
						  // Category
						  var categoryAxis = chart.categoryAxis;
						  categoryAxis.gridPosition = \"start\";
						  categoryAxis.fillAlpha = 1;
						  categoryAxis.labelFunction = function(labelText, serialDataItem) {
						    return labelText + \"\\n\" + serialDataItem.dataContext.value;
						  }
						  categoryAxis.gridAlpha = 0;

						  // value
						  var valueAxis = new AmCharts.ValueAxis();
						  valueAxis.axisColor = \"#DADADA\";
						  valueAxis.gridAlpha = 0.1;
						  chart.addValueAxis(valueAxis);

						  // GRAPH
						  var graph = new AmCharts.AmGraph();
						  graph.title = \"Income\";
						  graph.valueField = \"value\";
						  graph.type = \"column\";
						  graph.lineAlpha = 1;
						  graph.lineColor = \"#66d5c9\";
						  graph.fillColors = \"#99e4dc\";
						  graph.fillAlphas = 1;
						  chart.addGraph(graph);

						  // WRITE
						  chart.write(\"chartdiv_year\");
						});

					</script>
        				<div id=\"chartdiv_year\" style=\"width:100%; height:400px;\"></div>
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
						<p><a href=\"index.php?open=dashboard&amp;page=statistics&amp;action=open_month&amp;year=$year&amp;month=$month&amp;l=$l&amp;editor_language=$editor_language\">View</a></p>
					</div>
        				<script>
						var chart;
						var graph;

						var chartData = [";


						$x = 0;
						
						$stats_dayli_unique_desktop_this_month = 0;
						$stats_dayli_unique_mobile_this_month  = 0;
						$query = "SELECT stats_dayli_id, stats_dayli_day, stats_dayli_weekday, stats_dayli_human_unique, stats_dayli_unique_desktop, stats_dayli_unique_mobile, stats_dayli_unique_bots, stats_dayli_hits, stats_dayli_hits_desktop, stats_dayli_hits_mobile, stats_dayli_hits_bots FROM $t_stats_dayli WHERE stats_dayli_month=$month_mysql AND stats_dayli_year=$year_mysql";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_stats_dayli_id, $get_stats_dayli_day, $get_stats_dayli_weekday, $get_stats_dayli_human_unique, $get_stats_dayli_unique_desktop, $get_stats_dayli_unique_mobile, $get_stats_dayli_unique_bots, $get_stats_dayli_hits, $get_stats_dayli_hits_desktop, $get_stats_dayli_hits_mobile, $get_stats_dayli_hits_bots) = $row;
					
							// Transfer
							if($get_stats_dayli_weekday == "Mon"){
								$get_stats_dayli_weekday = "$l_mon";
							}
							elseif($get_stats_dayli_weekday == "Tue"){
								$get_stats_dayli_weekday = "$l_tue";
							}
							elseif($get_stats_dayli_weekday == "Wed"){
								$get_stats_dayli_weekday = "$l_wed";
							}
							elseif($get_stats_dayli_weekday == "Thu"){
								$get_stats_dayli_weekday = "$l_thu";
							}
							elseif($get_stats_dayli_weekday == "Fri"){
								$get_stats_dayli_weekday = "$l_fri";
							}
							elseif($get_stats_dayli_weekday == "Sat"){
								$get_stats_dayli_weekday = "$l_sat";
							}
							elseif($get_stats_dayli_weekday == "Sun"){
								$get_stats_dayli_weekday = "$l_sun";
							}
							$get_stats_dayli_weekday = substr($get_stats_dayli_weekday, 0, 1);

							if($x > 0){
								echo",";
							}
							echo"
							{
								\"day\": \"$get_stats_dayli_weekday $get_stats_dayli_day\",
								\"value\": $get_stats_dayli_human_unique
							}";


						// For desktop/mobile comparision
						$stats_dayli_unique_desktop_this_month = $stats_dayli_unique_desktop_this_month+$get_stats_dayli_unique_desktop;
						$stats_dayli_unique_mobile_this_month  = $stats_dayli_unique_mobile_this_month+$get_stats_dayli_unique_mobile;

						// xx
						$x++;
					}
					echo"
						];


		

						AmCharts.ready(function () {
							// SERIAL CHART
							chart = new AmCharts.AmSerialChart();

							chart.dataProvider = chartData;
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
                					chart.write(\"chartdiv_day\");
           					});

					</script>
        				<div id=\"chartdiv_day\" style=\"width:100%; height:400px;\"></div>
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
						<a href=\"index.php?open=dashboard&amp;page=tasks&amp;action=new_task&amp;status_code_id=$get_status_code_id&amp;l=$l&amp;process=1\">New task</a>
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