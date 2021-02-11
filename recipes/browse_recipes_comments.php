<?php 
/**
*
* File: recipes/browse_recipes_comments.php
* Version 1.0.0
* Date 23:50 12.01.2021
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

/*- Tables ---------------------------------------------------------------------------- */
include("_tables.php");

/*- Tables ------------------------------------------------------------------------ */
$t_recipes_tags_unique			= $mysqlPrefixSav . "recipes_tags_unique";

/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/recipes/ts_recipes.php");
include("$root/_admin/_translations/site/$l/recipes/ts_browse_recipes_newest.php");

/*- Variables ------------------------------------------------------------------------- */
$l_mysql = quote_smart($link, $l);



/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['order_by'])) {
	$order_by = $_GET['order_by'];
	$order_by = strip_tags(stripslashes($order_by));
}
else{
	$order_by = "recipe_id";
}
if(isset($_GET['order_method'])) {
	$order_method = $_GET['order_method'];
	$order_method = strip_tags(stripslashes($order_method));
}
else{
	$order_method = "desc";
}
if(isset($_GET['period'])) {
	$period = $_GET['period'];
	$period = strip_tags(stripslashes($period));
}
else{
	$period = "";
}
if(isset($_GET['year'])) {
	$year = $_GET['year'];
	$year = strip_tags(stripslashes($year));
	if(!(is_numeric($year))){
		echo"year not numeric";
		die;
	}
}
else{
	$year = date("Y");
}

$month = date("m");

/*- Tables ---------------------------------------------------------------------------------- */
include("_tables.php");

/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_recipes - $l_browse_recipes - $l_comments";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");


/*- Content ---------------------------------------------------------------------------------- */
echo"
<!-- Headline, buttons, search -->
	<div class=\"recipes_headline\">
		<h1>$l_browse_recipes</h1>
		<!-- Where am I? -->
			<p><b>$l_you_are_here:</b><br />
			<a href=\"index.php?l=$l\">$l_recipes</a>
			&gt;
			<a href=\"browse_recipes_comments.php?l=$l\">$l_comments</a>
			</p>
		<!-- //Where am I? -->

	</div>
	<div class=\"recipes_menu\">
		<!-- Recipes menu -->
			<script>
			\$(document).ready(function() {
				\$('#toggle_recipes_search').click(function() {
					\$(\".recipes_search\").fadeIn();
					\$(\"#inp_recipe_query\").focus();
				})
			});
			</script>


			<p>
			<a href=\"#\" id=\"toggle_recipes_search\" class=\"btn_default\">$l_search</a>
			<a href=\"$root/recipes/my_recipes.php?l=$l\" class=\"btn_default\">$l_my_recipes</a>
			<a href=\"$root/recipes/my_favorites.php?l=$l\" class=\"btn_default\">$l_my_favorites</a>
			<a href=\"$root/recipes/submit_recipe.php?l=$l\" class=\"btn_default\">$l_submit_recipe</a>
			</p>
		<!-- //Recipes menu -->
	</div>
	<div class=\"clear\"></div>
<!-- //Headline, buttons, search -->


<!-- Search -->
	<div class=\"recipes_search\">
		<form method=\"get\" action=\"search.php\" enctype=\"multipart/form-data\">
		<p>
		<b>$l_search_for_recipe:</b><br />
		
		<input type=\"text\" name=\"q\" value=\"\" size=\"15\" style=\"width: 50%;\" id=\"inp_recipe_query\" />
		<input type=\"submit\" value=\"$l_search\" class=\"btn_default\" />
		</p>
		</form>


		<!-- Search for recipe Autocomplete -->
			<script id=\"source\" language=\"javascript\" type=\"text/javascript\">
			\$(document).ready(function () {
				\$('#inp_recipe_query').keyup(function () {
					// getting the value that user typed
       					var searchString    = \$(\"#inp_recipe_query\").val();

 					// forming the queryString
      					var data            = 'l=$l&q='+ searchString;
         
        				// if searchString is not empty
        				if(searchString) {
						\$(\"#inp_recipe_query_results\").css('visibility','visible');

           					// ajax call
            					\$.ajax({
                					type: \"GET\",
               						url: \"search_for_recipe_autocomplete.php\",
                					data: data,
							beforeSend: function(html) { // this happens before actual call
								\$(\"#inp_recipe_query_results\").html(''); 
							},
               						success: function(html){
                    						\$(\"#inp_recipe_query_results\").append(html);
              						}
            					});
       					}
        				return false;
            			});
         		   });
			</script>
			<div id=\"inp_recipe_query_results\"></div>
			<div class=\"clear\"></div>
		<!-- //Search for recipe Autocomplete -->
		
	</div>
<!-- //Search -->

		<!-- Order -->
			<script>
			\$(function(){
				\$('.on_select_go_to_url').on('change', function () {
					var url = \$(this).val();
					if (url) { // require a URL
 						window.location = url;
					}
					return false;
				});
			});
			</script>

			<form method=\"get\" action=\"search.php\" enctype=\"multipart/form-data\">
				<p>
				<select name=\"inp_selected\" class=\"on_select_go_to_url\">
					<option value=\"browse_recipes_newest.php?l=$l\">- $l_selected -</option>
					<option value=\"browse_recipes_newest.php?order_by=recipe_id&amp;order_method=desc&amp;l=$l\">$l_newest</option>
					<option value=\"browse_recipes_views.php?l=$l\">$l_views</option>
					<option value=\"browse_recipes_comments.php?l=$l\" selected=\"selected\">$l_comments</option>
					<option value=\"browse_recipes_rating.php?l=$l\">$l_rating</option>
				</select>
				<select name=\"inp_period\" class=\"on_select_go_to_url\">
					<option value=\"browse_recipes_comments.php?l=$l\">$l_all_time</option>
					<option value=\"browse_recipes_comments.php?period=30_days&amp;l=$l\""; if($period == "30_days"){ echo" selected=\"selected\""; } echo">$l_thirty_days</option>";

					$query = "SELECT DISTINCT stats_visit_per_year_year FROM $t_recipes_stats_views_per_year WHERE stats_visit_per_year_recipe_language=$l_mysql";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_stats_visit_per_year_year) = $row;

						echo"					";
						echo"<option value=\"browse_recipes_comments.php?period=year&amp;year=$get_stats_visit_per_year_year&amp;l=$l\""; if($period == "year" && $get_stats_visit_per_year_year == "$year"){ echo" selected=\"selected\""; } echo">$l_year $get_stats_visit_per_year_year</option>\n";

					}
					echo"
					
				</select>
		<!-- //Order -->



<!-- Browse recipes views -->";
	echo"
	";
	

	// Select recipes
	$x = 0;
	if($period == ""){
		$query = "SELECT $t_recipes.recipe_id, $t_recipes.recipe_title, $t_recipes.recipe_category_id, $t_recipes.recipe_introduction, $t_recipes.recipe_image_path, $t_recipes.recipe_image, $t_recipes.recipe_thumb_278x156, $t_recipes.recipe_unique_hits FROM $t_recipes JOIN $t_recipes_numbers ON $t_recipes.recipe_id=$t_recipes_numbers.number_recipe_id WHERE $t_recipes.recipe_language=$l_mysql AND recipe_comments > 0";
		$query = $query . " ORDER BY recipe_comments DESC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_recipe_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_introduction, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb_278x156, $get_recipe_unique_hits) = $row;

			if($get_recipe_image != "" && file_exists("$root/$get_recipe_image_path/$get_recipe_image")){
				// Category
				$query_cat = "SELECT category_translation_id, category_translation_value FROM $t_recipes_categories_translations WHERE category_id=$get_recipe_category_id AND category_translation_language=$l_mysql";
				$result_cat = mysqli_query($link, $query_cat);
				$row_cat = mysqli_fetch_row($result_cat);
				list($get_category_translation_id, $get_category_translation_value) = $row_cat;
	

		
				if(!(file_exists("$root/$get_recipe_image_path/$get_recipe_thumb_278x156"))){
					if($get_recipe_thumb_278x156 == ""){
						echo"<div class=\"info\">Thumb 278x156 is blank</div>";
						die;
					}
					$inp_new_x = 278;
					$inp_new_y = 156;
					resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_recipe_image_path/$get_recipe_image", "$root/$get_recipe_image_path/$get_recipe_thumb_278x156");
				}

				if($x == "0"){
					echo"
					<div class=\"clear\"></div>
					<div class=\"left_center_center_right_left\">
					";
				}
				elseif($x == "1"){
					echo"
					<div class=\"left_center_center_left_right_center\">
					";
				}
				elseif($x == "2"){
					echo"
					<div class=\"left_center_center_right_right_center\">
					";
				}
				elseif($x == "3"){
					echo"
					<div class=\"left_center_center_right_right\">
					";
				}
				echo"
						<p class=\"frontpage_post_image\"><a id=\"recipe$get_recipe_id\"></a>
							<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\"><img src=\"$root/$get_recipe_image_path/$get_recipe_thumb_278x156\" alt=\"$get_recipe_image\" /></a><br />
						</p>

						<p class=\"frontpage_post_title\">
							<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"h2\">$get_recipe_title</a>
						</p>
					
					</div>
				";
			
				// Increment
				$x = $x+1;

				if($x == "4"){
					$x = 0;
				}

			} // image
		} // while
	} // period == all time
	elseif($period == "30_days"){
		
		$query = "SELECT stats_comment_per_month_id, stats_comment_per_month_recipe_id, stats_comment_per_month_recipe_title, stats_comment_per_month_recipe_image_path, stats_comment_per_month_recipe_thumb_278x156, stats_comment_per_month_count FROM $t_recipes_stats_comments_per_month WHERE stats_comment_per_month_month=$month AND stats_comment_per_month_year=$year AND stats_comment_per_month_recipe_language=$l_mysql ORDER BY stats_comment_per_month_count DESC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_stats_comment_per_month_id, $get_stats_comment_per_month_recipe_id, $get_stats_comment_per_month_recipe_title, $get_stats_comment_per_month_recipe_image_path, $get_stats_comment_per_month_recipe_thumb_278x156, $get_stats_comment_per_month_count) = $row;

			if($get_stats_comment_per_month_recipe_thumb_278x156 != "" && file_exists("$root/$get_stats_comment_per_month_recipe_image_path/$get_stats_comment_per_month_recipe_thumb_278x156")){
				
				if($x == "0"){
					echo"
					<div class=\"clear\"></div>
					<div class=\"left_center_center_right_left\">
					";
				}
				elseif($x == "1"){
					echo"
					<div class=\"left_center_center_left_right_center\">
					";
				}
				elseif($x == "2"){
					echo"
					<div class=\"left_center_center_right_right_center\">
					";
				}
				elseif($x == "3"){
					echo"
					<div class=\"left_center_center_right_right\">
					";
				}
				echo"
						<p class=\"frontpage_post_image\"><a id=\"recipe$get_stats_comment_per_month_recipe_id\"></a>
							<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_stats_comment_per_month_recipe_id&amp;l=$l\"><img src=\"$root/$get_stats_comment_per_month_recipe_image_path/$get_stats_comment_per_month_recipe_thumb_278x156\" alt=\"$get_stats_comment_per_month_recipe_thumb_278x156\" /></a><br />
						</p>

						<p class=\"frontpage_post_title\">
							<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_stats_comment_per_month_recipe_id&amp;l=$l\" class=\"h2\">$get_stats_comment_per_month_recipe_title</a>
						</p>
					
					</div>
				";
			
				// Increment
				$x = $x+1;

				if($x == "4"){
					$x = 0;
				}

			} // image
		} // while

	} // 30 days
	elseif($period == "year"){
		$year_mysql = quote_smart($link, $year);
		$query = "SELECT stats_comment_per_year_id, stats_comment_per_year_recipe_id, stats_comment_per_year_recipe_title, stats_comment_per_year_recipe_image_path, stats_comment_per_year_recipe_thumb_278x156, stats_comment_per_year_recipe_language, stats_comment_per_year_count FROM $t_recipes_stats_comments_per_year WHERE stats_comment_per_year_year=$year AND stats_comment_per_year_recipe_language=$l_mysql ORDER BY stats_comment_per_year_count DESC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_stats_comment_per_year_id, $get_stats_comment_per_year_recipe_id, $get_stats_comment_per_year_recipe_title, $get_stats_comment_per_year_recipe_image_path, $get_stats_comment_per_year_recipe_thumb_278x156, $get_stats_comment_per_year_recipe_language, $get_stats_comment_per_year_count) = $row;

			if($get_stats_comment_per_year_recipe_thumb_278x156 != "" && file_exists("$root/$get_stats_comment_per_year_recipe_image_path/$get_stats_comment_per_year_recipe_thumb_278x156")){
				
				if($x == "0"){
					echo"
					<div class=\"clear\"></div>
					<div class=\"left_center_center_right_left\">
					";
				}
				elseif($x == "1"){
					echo"
					<div class=\"left_center_center_left_right_center\">
					";
				}
				elseif($x == "2"){
					echo"
					<div class=\"left_center_center_right_right_center\">
					";
				}
				elseif($x == "3"){
					echo"
					<div class=\"left_center_center_right_right\">
					";
				}
				echo"
						<p class=\"frontpage_post_image\"><a id=\"recipe$get_stats_comment_per_year_recipe_id\"></a>
							<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_stats_comment_per_year_recipe_id&amp;l=$l\"><img src=\"$root/$get_stats_comment_per_year_recipe_image_path/$get_stats_comment_per_year_recipe_thumb_278x156\" alt=\"$get_stats_comment_per_year_recipe_thumb_278x156\" /></a><br />
						</p>

						<p class=\"frontpage_post_title\">
							<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_stats_comment_per_year_recipe_id&amp;l=$l\" class=\"h2\">$get_stats_comment_per_year_recipe_title</a>
						</p>
					
					</div>
				";
			
				// Increment
				$x = $x+1;

				if($x == "4"){
					$x = 0;
				}

			} // image
		} // while
	} // year
	echo"
		<div class=\"clear\"></div>
<!-- //Browse recipes -->


	";


/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>