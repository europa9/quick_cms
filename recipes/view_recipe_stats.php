<?php 
/**
*
* File: recipes/view_recipe_stats.php
* Version 3.0.0
* Date 21:07 12.01.2021
* Copyright (c) 2021 Localhost
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Configuration --------------------------------------------------------------------- */
$pageIdSav            = "2";
$pageNoColumnSav      = "2";
$pageAllowCommentsSav = "0";

/*- Root dir -------------------------------------------------------------------------- */
// This determine where we are
if(file_exists("favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
elseif(file_exists("../../../../favicon.ico")){ $root = "../../../.."; }
else{ $root = "../../.."; }

/*- Website config -------------------------------------------------------------------- */
include("$root/_admin/website_config.php");



/*- Tables ----------------------------------------------------------------------------- */
include("_tables.php");

/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['recipe_id'])) {
	$recipe_id = $_GET['recipe_id'];
	$recipe_id = strip_tags(stripslashes($recipe_id));
}
else{
	$recipe_id = "";
}



/*- Get recipe ------------------------------------------------------------------------- */
// Select
$recipe_id_mysql = quote_smart($link, $recipe_id);
$query = "SELECT recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_country, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb_278x156, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_comments, recipe_user_ip, recipe_notes, recipe_password, recipe_last_viewed, recipe_age_restriction FROM $t_recipes WHERE recipe_id=$recipe_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_recipe_id, $get_recipe_user_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_language, $get_recipe_country, $get_recipe_introduction, $get_recipe_directions, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb_278x156, $get_recipe_video, $get_recipe_date, $get_recipe_time, $get_recipe_cusine_id, $get_recipe_season_id, $get_recipe_occasion_id, $get_recipe_marked_as_spam, $get_recipe_unique_hits, $get_recipe_unique_hits_ip_block, $get_recipe_comments, $get_recipe_user_ip, $get_recipe_notes, $get_recipe_password, $get_recipe_last_viewed, $get_recipe_age_restriction) = $row;

/*- Headers ---------------------------------------------------------------------------------- */
if($get_recipe_id == ""){
	$website_title = "Server error 404";
}
else{
	$website_title = "$l_recipes - $get_recipe_title - $l_stats";
}

if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */
if($get_recipe_id == ""){
	echo"
	<h1>Recipe not found</h1>

	<p>
	The recipe you are trying to view was not found.
	</p>

	<p>
	<a href=\"index.php\">Back</a>
	</p>
	";
}
else{
	// Category
	$query = "SELECT category_translation_value FROM $t_recipes_categories_translations WHERE category_id=$get_recipe_category_id AND category_translation_language=$l_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_category_translation_value) = $row;


	echo"
	<h1>$get_recipe_title $l_stats_headline</h1>

	<!-- Charts javascript -->
		<script src=\"$root/_admin/_javascripts/amcharts4/core.js\"></script>
		<script src=\"$root/_admin/_javascripts/amcharts4/charts.js\"></script>
		<script src=\"$root/_admin/_javascripts/amcharts4/themes/animated.js\"></script>
		<script src=\"$root/_admin/_javascripts/amcharts4/plugins/venn.js\"></script>
	<!-- //Charts javascript -->

	<!-- You are here -->
		<p><b>$l_you_are_here:</b><br />
		<a href=\"index.php?l=$l\">$l_recipes</a>
		&gt;
		<a href=\"categories_browse.php?category_id=$get_recipe_category_id\">$get_category_translation_value</a>
		&gt;
		<a href=\"view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\">$get_recipe_title</a>
		&gt;
		<a href=\"view_recipe_stats.php?recipe_id=$get_recipe_id&amp;l=$l\">$l_stats</a>
		</p>
	<!-- //You are here -->


	<!-- Visits -->
		<a id=\"visits\"></a>
		<h2 style=\"padding-bottom:0;margin-bottom:0;\">$l_unique_visits_per_month</h2>

		<script>
		am4core.ready(function() {
			var chart = am4core.create(\"chartdiv_visits_per_month\", am4charts.XYChart);
			chart.data = [";

			$x = 0;
			$query = "SELECT stats_visit_per_month_id, stats_visit_per_month_month, stats_visit_per_month_month_full, stats_visit_per_month_month_short, stats_visit_per_month_year, stats_visit_per_month_recipe_id, stats_visit_per_month_recipe_title, stats_visit_per_month_recipe_image_path, stats_visit_per_month_recipe_thumb_278x156, stats_visit_per_month_recipe_language, stats_visit_per_month_count FROM $t_recipes_stats_views_per_month WHERE stats_visit_per_month_recipe_id=$get_recipe_id ORDER BY stats_visit_per_month_id ASC LIMIT 0,24";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_stats_visit_per_month_id, $get_stats_visit_per_month_month, $get_stats_visit_per_month_month_full, $get_stats_visit_per_month_month_short, $get_stats_visit_per_month_year, $get_stats_visit_per_month_recipe_id, $get_stats_visit_per_month_recipe_title, $get_stats_visit_per_month_recipe_image_path, $get_stats_visit_per_month_recipe_thumb_278x156, $get_stats_visit_per_month_recipe_language, $get_stats_visit_per_month_count) = $row;
						
				if($x > 0){
					echo",";
				}
				echo"
				{
					\"x\": \"$get_stats_visit_per_month_month_short $get_stats_visit_per_month_year\",
					\"value\": $get_stats_visit_per_month_count
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

	<!-- Favorited -->
		<a id=\"favorited\"></a>
		<h2 style=\"padding-bottom:0;margin-bottom:0;\">$l_favorited</h2>

		<script>
		am4core.ready(function() {
			var chart = am4core.create(\"chartdiv_favorited_per_month\", am4charts.XYChart);
			chart.data = [";

			$x = 0;
			$query = "SELECT stats_favorited_per_month_id, stats_favorited_per_month_month, stats_favorited_per_month_month_full, stats_favorited_per_month_month_short, stats_favorited_per_month_year, stats_favorited_per_month_recipe_id, stats_favorited_per_month_recipe_title, stats_favorited_per_month_recipe_image_path, stats_favorited_per_month_recipe_thumb_278x156, stats_favorited_per_month_recipe_language, stats_favorited_per_month_recipe_category_id, stats_favorited_per_month_recipe_category_translated, stats_favorited_per_month_count FROM $t_recipes_stats_favorited_per_month WHERE stats_favorited_per_month_recipe_id=$get_recipe_id ORDER BY stats_favorited_per_month_id ASC LIMIT 0,24";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_stats_favorited_per_month_id, $get_stats_favorited_per_month_month, $get_stats_favorited_per_month_month_full, $get_stats_favorited_per_month_month_short, $get_stats_favorited_per_month_year, $get_stats_favorited_per_month_recipe_id, $get_stats_favorited_per_month_recipe_title, $get_stats_favorited_per_month_recipe_image_path, $get_stats_favorited_per_month_recipe_thumb_278x156, $get_stats_favorited_per_month_recipe_language, $get_stats_favorited_per_month_recipe_category_id, $get_stats_favorited_per_month_recipe_category_translated, $get_stats_favorited_per_month_count) = $row;
						
				if($x > 0){
					echo",";
				}
				echo"
				{
					\"x\": \"$get_stats_favorited_per_month_month_short $get_stats_favorited_per_month_year\",
					\"value\": $get_stats_favorited_per_month_count
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
		<div id=\"chartdiv_favorited_per_month\" style=\"height: 400px;\"></div>
	<!-- //Favorited -->



	";
} // recipe found

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>