<?php 
/**
*
* File: recipes/index.php
* Version 1.0.0
* Date 13:43 18.11.2017
* Copyright (c) 2011-2017 Localhost
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

/*- Tables ------------------------------------------------------------------------ */
$t_recipes_tags_unique			= $mysqlPrefixSav . "recipes_tags_unique";

/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/recipes/ts_recipes.php");
include("$root/_admin/_translations/site/$l/recipes/ts_frontpage.php");

/*- Variables ------------------------------------------------------------------------- */
$l_mysql = quote_smart($link, $l);


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_recipes";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

// Language
include("$root/_admin/_translations/site/$l/recipes/ts_search.php");

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


/*- Content ---------------------------------------------------------------------------------- */
echo"
<!-- Headline, buttons, search -->
	<div class=\"recipes_headline_left\">
		<h1>$l_recipes</h1>
	</div>
	<div class=\"recipes_headline_center\">
		<p>
		<a href=\"$root/recipes/my_recipes.php?l=$l\" class=\"btn_default\">$l_my_recipes</a>
		<a href=\"$root/recipes/my_favorites.php?l=$l\" class=\"btn_default\">$l_my_favorites</a>
		<a href=\"$root/recipes/submit_recipe.php?l=$l\" class=\"btn_default\">$l_submit_recipe</a>
		</p>
	</div>
	<div class=\"recipes_headline_right\">
		<!-- Order -->
			<script>
			\$(function(){
				\$('#inp_order_by_select').on('change', function () {
					var url = \$(this).val();
					if (url) { // require a URL
 						window.location = url;
					}
					return false;
				});
				\$('#inp_order_method_select').on('change', function () {
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
				<select name=\"inp_order_by\" id=\"inp_order_by_select\">
					<option value=\"index.php\">- $l_order_by -</option>
					<option value=\"index.php?order_by=recipe_id&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "recipe_id" OR $order_by == ""){ echo" selected=\"selected\""; } echo">$l_date</option>
					<option value=\"index.php?order_by=recipe_title&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "recipe_title"){ echo" selected=\"selected\""; } echo">$l_title</option>
					<option value=\"index.php?order_by=recipe_comments&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "recipe_comments"){ echo" selected=\"selected\""; } echo">$l_comments</option>
					<option value=\"index.php?order_by=recipe_unique_hits&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "recipe_unique_hits"){ echo" selected=\"selected\""; } echo">$l_unique_hits</option>
					<option value=\"index.php?order_by=number_serving_calories&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "number_serving_calories"){ echo" selected=\"selected\""; } echo">$l_calories</option>
					<option value=\"index.php?order_by=number_serving_fat&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "number_serving_fat"){ echo" selected=\"selected\""; } echo">$l_fat</option>
					<option value=\"index.php?order_by=number_serving_carbs&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "number_serving_carbs"){ echo" selected=\"selected\""; } echo">$l_carbs</option>
					<option value=\"index.php?order_by=number_serving_proteins&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "number_serving_proteins"){ echo" selected=\"selected\""; } echo">$l_proteins</option>
				</select>
				<select name=\"inp_order_method\" id=\"inp_order_method_select\">
					<option value=\"index.php?order_by=$order_by&amp;order_method=asc&amp;l=$l\""; if($order_method == "asc" OR $order_method == ""){ echo" selected=\"selected\""; } echo">$l_asc</option>
					<option value=\"index.php?order_by=$order_by&amp;order_method=desc&amp;l=$l\""; if($order_method == "desc"){ echo" selected=\"selected\""; } echo">$l_desc</option>
				</select>
		<!-- //Order -->
		<!-- Search -->
			<input type=\"text\" name=\"q\" value=\"\" size=\"10\" id=\"nettport_inp_search_query\" />
			<input type=\"submit\" value=\"$l_search\" id=\"nettport_search_submit_button\" class=\"btn_default\" />
			</p>
		<!-- //Search -->

	</div>
	<div class=\"clear\"></div>
<!-- //Headline, buttons, search -->



<!-- Newest recipes -->";
	echo"
	<div class=\"clear\"></div>
	<p class=\"frontpage_category_headline_leftside_p\"><a href=\"$root/recipes/browse_recipes.php?l=$l\" class=\"frontpage_category_headline_leftside_a\">$l_fresh_recipes_headline</a></p>
	<p class=\"frontpage_category_headline_rightside_p\"><a href=\"$root/recipes/browse_recipes.php?l=$l\" class=\"frontpage_category_headline_rightside_a\">$l_more_new_recipes</a></p>
	<div class=\"clear\"></div>
	";
	

	// Get four recipes
	$x = 0;
	$query = "SELECT recipe_id, recipe_title, recipe_category_id, recipe_introduction, recipe_image_path, recipe_image FROM $t_recipes WHERE recipe_language=$l_mysql ORDER BY recipe_id DESC LIMIT 0,4";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_recipe_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_introduction, $get_recipe_image_path, $get_recipe_image) = $row;

			if($get_recipe_image != ""){
				// Category
				$query_cat = "SELECT category_translation_id, category_translation_value FROM $t_recipes_categories_translations WHERE category_id=$get_recipe_category_id AND category_translation_language=$l_mysql";
				$result_cat = mysqli_query($link, $query_cat);
				$row_cat = mysqli_fetch_row($result_cat);
				list($get_category_translation_id, $get_category_translation_value) = $row_cat;
	

				$inp_new_x = 278; // 278 px × 154
				$inp_new_y = 184;
				$thumb = "recipe_" . $get_recipe_id . "-" . $inp_new_x . "x" . $inp_new_y . ".png";
		
				if(!(file_exists("$root/_cache/$thumb"))){
					resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_recipe_image_path/$get_recipe_image", "$root/_cache/$thumb");
				}

				if($x == "0"){
					echo"
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
						<p class=\"frontpage_post_image\">
							<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\"><img src=\"$root/_cache/$thumb\" alt=\"$get_recipe_image\" /></a><br />
						</p>

						<p class=\"frontpage_post_category_p\">
							<a href=\"$root/recipes/categories_browse.php?category_id=$get_recipe_category_id&amp;l=$l\" class=\"frontpage_post_category_a\">$get_category_translation_value</a><br />
						</p>
						<p class=\"frontpage_post_title\">
							<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"h2\">$get_recipe_title</a>
						</p>
					
					</div>
				";
			
				// Increment
				$x = $x+1;

			} // image
		}
	echo"
		<div class=\"clear\"></div>
<!-- //Newest recipes -->


<!-- Four recipes for the season -->";
	// What is the season?
	$month = date("m");
	$day = date("d");
	// Occation
	$query_owner = "SELECT occasion_id, occasion_name, occasion_day, occasion_month, occasion_image, occasion_last_updated FROM $t_recipes_occasions WHERE occasion_day>$day AND occasion_month=$month LIMIT 0,1";
	$result_owner = mysqli_query($link, $query_owner);
	$row_owner = mysqli_fetch_row($result_owner);
	list($get_occasion_id, $get_occasion_name, $get_occasion_day, $get_occasion_month, $get_occasion_image, $get_occasion_last_updated) = $row_owner;
	
	if($get_occasion_id != ""){
		// Translation
		$query_owner = "SELECT occasion_translation_id, occasion_translation_value FROM $t_recipes_occasions_translations WHERE occasion_id=$get_occasion_id AND occasion_translation_language=$l_mysql";
		$result_owner = mysqli_query($link, $query_owner);
		$row_owner = mysqli_fetch_row($result_owner);
		list($get_occasion_translation_id, $get_occasion_translation_value) = $row_owner;
	

		echo"
		<div class=\"clear\"></div>
		<p class=\"frontpage_category_headline_leftside_p\"><a href=\"$root/recipes/occasions_browse.php?occasion_id=$get_occasion_id&amp;l=$l\" class=\"frontpage_category_headline_leftside_a\">$get_occasion_translation_value</a></p>
		<p class=\"frontpage_category_headline_rightside_p\"><a href=\"$root/recipes/occasions_browse.php?occasion_id=$get_occasion_id&amp;l=$l\" class=\"frontpage_category_headline_rightside_a\">$l_more_recipes</a></p>
		<div class=\"clear\"></div>
		";
	

		// Get four recipes
		$x = 0;
		$query = "SELECT recipe_id, recipe_title, recipe_category_id, recipe_introduction, recipe_image_path, recipe_image FROM $t_recipes WHERE recipe_language=$l_mysql AND recipe_occasion_id=$get_occasion_id ORDER BY recipe_unique_hits DESC LIMIT 0,4";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_recipe_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_introduction, $get_recipe_image_path, $get_recipe_image) = $row;

			if($get_recipe_image != ""){
				// Category
				$query_cat = "SELECT category_translation_id, category_translation_value FROM $t_recipes_categories_translations WHERE category_id=$get_recipe_category_id AND category_translation_language=$l_mysql";
				$result_cat = mysqli_query($link, $query_cat);
				$row_cat = mysqli_fetch_row($result_cat);
				list($get_category_translation_id, $get_category_translation_value) = $row_cat;
	

				$inp_new_x = 278; // 278 px × 154
				$inp_new_y = 184;
				$thumb = "recipe_" . $get_recipe_id . "-" . $inp_new_x . "x" . $inp_new_y . ".png";
		
				if(!(file_exists("$root/_cache/$thumb"))){
					resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_recipe_image_path/$get_recipe_image", "$root/_cache/$thumb");
				}

				if($x == "0"){
					echo"
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
						<p class=\"frontpage_post_image\">
							<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\"><img src=\"$root/_cache/$thumb\" alt=\"$get_recipe_image\" /></a><br />
						</p>

						<p class=\"frontpage_post_category_p\">
							<a href=\"$root/recipes/categories_browse.php?category_id=$get_recipe_category_id&amp;l=$l\" class=\"frontpage_post_category_a\">$get_category_translation_value</a><br />
						</p>
						<p class=\"frontpage_post_title\">
							<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"h2\">$get_recipe_title</a>
						</p>
					
					</div>
				";
			
				// Increment
				$x = $x+1;

			} // image
		}
 	} // occation found
	echo"
		<div class=\"clear\"></div>
<!-- //Four recipes for the season -->




<!-- 10 popular tags -->";
	// Tags unique
	$query_tags = "SELECT tag_id, tag_language, tag_title, tag_title_clean, tag_number_of_recipes, tag_last_clicked_week FROM $t_recipes_tags_unique WHERE tag_language=$l_mysql ORDER BY tag_last_clicked_week, tag_unique_views_counter DESC LIMIT 0,20";
	$result_tags = mysqli_query($link, $query_tags);
	while($row_tags = mysqli_fetch_row($result_tags)) {
		list($get_tag_id, $get_tag_language, $get_tag_title, $get_tag_title_clean, $get_tag_number_of_recipes, $get_tag_last_clicked_week) = $row_tags;

	
		echo"
		<div class=\"clear\"></div>
		<p class=\"frontpage_category_headline_leftside_p\"><a href=\"$root/recipes/view_tag_1200.php?tag=$get_tag_title_clean&amp;l=$l\" class=\"frontpage_category_headline_leftside_a\">#$get_tag_title_clean</a></p>
		<p class=\"frontpage_category_headline_rightside_p\"><a href=\"$root/recipes/view_tag_1200.php?tag=$get_tag_title_clean&amp;l=$l\" class=\"frontpage_category_headline_rightside_a\">$l_more #$get_tag_title_clean</a></p>
		<div class=\"clear\"></div>
		";
	

		// Get four recipes
		$x = 0;
		$tag_title_clean_mysql = quote_smart($link, $get_tag_title_clean);
		$query = "SELECT $t_recipes_tags.tag_id, $t_recipes.recipe_id, $t_recipes.recipe_title, $t_recipes.recipe_introduction, $t_recipes.recipe_image_path, $t_recipes.recipe_image, $t_recipes.recipe_unique_hits FROM $t_recipes_tags INNER JOIN $t_recipes ON $t_recipes_tags.tag_recipe_id=$t_recipes.recipe_id WHERE $t_recipes_tags.tag_language=$l_mysql AND $t_recipes_tags.tag_title_clean=$tag_title_clean_mysql ORDER BY $t_recipes.recipe_id DESC LIMIT 4,4";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_tag_id, $get_recipe_id, $get_recipe_title, $get_recipe_introduction, $get_recipe_image_path, $get_recipe_image, $get_recipe_unique_hits) = $row;

			if($get_recipe_image != ""){
				// Category
				$query_cat = "SELECT category_translation_id, category_translation_value FROM $t_recipes_categories_translations WHERE category_id=$get_recipe_category_id AND category_translation_language=$l_mysql";
				$result_cat = mysqli_query($link, $query_cat);
				$row_cat = mysqli_fetch_row($result_cat);
				list($get_category_translation_id, $get_category_translation_value) = $row_cat;
	

				$inp_new_x = 278; // 278 px × 154
				$inp_new_y = 184;
				$thumb = "recipe_" . $get_recipe_id . "-" . $inp_new_x . "x" . $inp_new_y . ".png";
		
				if(!(file_exists("$root/_cache/$thumb"))){
					resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_recipe_image_path/$get_recipe_image", "$root/_cache/$thumb");
				}

				if($x == "0"){
					echo"
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
						<p class=\"frontpage_post_image\">
							<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\"><img src=\"$root/_cache/$thumb\" alt=\"$get_recipe_image\" /></a><br />
						</p>

						<p class=\"frontpage_post_category_p\">
							<a href=\"$root/recipes/categories_browse.php?category_id=$get_recipe_category_id&amp;l=$l\" class=\"frontpage_post_category_a\">$get_category_translation_value</a><br />
						</p>
						<p class=\"frontpage_post_title\">
							<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"h2\">$get_recipe_title</a>
						</p>
					
					</div>
				";
			
				// Increment
				$x = $x+1;

			} // image
		}
		echo"
		<div class=\"clear\"></div>
		";
 	} // tags
	echo"
	<div class=\"clear\"></div>
<!-- //10 popular tags -->
";


/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>