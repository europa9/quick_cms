<?php 
/**
*
* File: recipes/open_category.php
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


/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/recipes/ts_recipes.php");

/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['category_id'])) {
	$category_id = $_GET['category_id'];
	$category_id = strip_tags(stripslashes($category_id));
}
else{
	$category_id = "";
}



// Select
$l_mysql = quote_smart($link, $l);
$category_id_mysql = quote_smart($link, $category_id);
$query = "SELECT category_id, category_name, category_age_restriction FROM $t_recipes_categories WHERE category_id=$category_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_category_id, $get_current_category_name, $get_current_category_age_restriction) = $row;

if($get_current_category_id != ""){
	// Get translation
	$category_id_mysql = quote_smart($link, $category_id);
	$query = "SELECT category_translation_id, category_translation_value, category_translation_image_updated_week, category_translation_no_recipes FROM $t_recipes_categories_translations WHERE category_id=$category_id_mysql AND category_translation_language=$l_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_category_translation_id, $get_current_category_translation_value, $get_current_category_translation_image_updated_week, $get_current_category_translation_no_recipes) = $row;

	if($get_current_category_translation_id == ""){
		// Create new translation
		mysqli_query($link, "INSERT INTO $t_recipes_categories_translations
		(category_translation_id, category_id, category_translation_language, category_translation_value) 
		VALUES 
		(NULL, $category_id_mysql, $l_mysql, '$get_current_category_name')")
		or die(mysqli_error($link));
	}
}



/*- Headers ---------------------------------------------------------------------------------- */
if($get_current_category_id == ""){
	$website_title = "Server error 404";
}
else{
	$website_title = "$l_recipes - $get_current_category_translation_value";
}

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
	<div class=\"left\">
		<h1>$get_current_category_translation_value</h1>
	</div>
	<div style=\"float: right;text-align: right;padding-top:12px;\">
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
					<option value=\"categories_browse_1200.php?category_id=$category_id\">- $l_order_by -</option>
					<option value=\"categories_browse_1200.php?category_id=$category_id&amp;order_by=recipe_id&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "recipe_id" OR $order_by == ""){ echo" selected=\"selected\""; } echo">$l_date</option>
					<option value=\"categories_browse_1200.php?category_id=$category_id&amp;order_by=recipe_title&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "recipe_title"){ echo" selected=\"selected\""; } echo">$l_title</option>
					<option value=\"categories_browse_1200.php?category_id=$category_id&amp;order_by=recipe_comments&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "recipe_comments"){ echo" selected=\"selected\""; } echo">$l_comments</option>
					<option value=\"categories_browse_1200.php?category_id=$category_id&amp;order_by=recipe_unique_hits&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "recipe_unique_hits"){ echo" selected=\"selected\""; } echo">$l_unique_hits</option>
					<option value=\"categories_browse_1200.php?category_id=$category_id&amp;order_by=number_serving_calories&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "number_serving_calories"){ echo" selected=\"selected\""; } echo">$l_calories</option>
					<option value=\"categories_browse_1200.php?category_id=$category_id&amp;order_by=number_serving_fat&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "number_serving_fat"){ echo" selected=\"selected\""; } echo">$l_fat</option>
					<option value=\"categories_browse_1200.php?category_id=$category_id&amp;order_by=number_serving_carbs&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "number_serving_carbs"){ echo" selected=\"selected\""; } echo">$l_carbs</option>
					<option value=\"categories_browse_1200.php?category_id=$category_id&amp;order_by=number_serving_proteins&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "number_serving_proteins"){ echo" selected=\"selected\""; } echo">$l_proteins</option>
				</select>
				<select name=\"inp_order_method\" id=\"inp_order_method_select\">
					<option value=\"categories_browse_1200.php?category_id=$category_id&amp;order_by=$order_by&amp;order_method=asc&amp;l=$l\""; if($order_method == "asc"){ echo" selected=\"selected\""; } echo">$l_asc</option>
					<option value=\"categories_browse_1200.php?category_id=$category_id&amp;order_by=$order_by&amp;order_method=desc&amp;l=$l\""; if($order_method == "desc"){ echo" selected=\"selected\""; } echo">$l_desc</option>
				</select> 
				</p>
        		</form>
		<!-- //Order -->
	</div>
	<div class=\"clear\"></div>


<!-- Where am I? -->
	<p><b>$l_you_are_here:</b><br />
	<a href=\"index.php?l=$l\">$l_recipes</a>
	&gt;
	<a href=\"categories.php?l=$l\">$l_categories</a>
	&gt;
	<a href=\"categories_browse_1200.php?caegory_id=$get_current_category_id&amp;l=$l\">$get_current_category_translation_value</a>
	</p>
<!-- //Where am I? -->


	";

	// Current week, datetime
	$current_week = date("W");
	$current_datetime = date("Y-m-d H:i:s");

	// Select recipes
	$x = 0;
	$count_recipes = 0;
	$query = "SELECT $t_recipes.recipe_id, $t_recipes.recipe_title, $t_recipes.recipe_introduction, $t_recipes.recipe_image_path, $t_recipes.recipe_image, $t_recipes.recipe_thumb, $t_recipes.recipe_unique_hits FROM $t_recipes JOIN $t_recipes_numbers ON $t_recipes.recipe_id=$t_recipes_numbers.number_recipe_id WHERE $t_recipes.recipe_category_id='$get_current_category_id' AND $t_recipes.recipe_language=$l_mysql";
	// Order
	if($order_method == "desc"){
		$order_method_mysql = "DESC";
	}
	else{
		$order_method_mysql = "ASC";
	}

	if($order_by == "recipe_id" OR $order_by == "recipe_title" OR $order_by == "recipe_unique_hits" OR $order_by == "recipe_unique_hits"){
		$order_by_mysql = "$t_recipes.$order_by";
	}
	elseif($order_by == "number_serving_calories" OR $order_by == "number_serving_fat" OR $order_by == "number_serving_carbs" OR $order_by == "number_serving_proteins"){
		$order_by_mysql = "$t_recipes_numbers.$order_by";
	}
	else{
		$order_by_mysql = "$t_recipes.recipe_id";
	}
	$query = $query . " ORDER BY $order_by_mysql $order_method_mysql";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_recipe_id, $get_recipe_title, $get_recipe_introduction, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb, $get_recipe_unique_hits) = $row;

		if($get_recipe_image != ""){
		

			// New image for category 
			if($order_by == "recipe_unique_hits" && $count_recipes == "0" && $get_current_category_translation_image_updated_week != "$current_week"){
				// This recipe can be the new category image
				$inp_category_image_path = "_uploads/recipes/categories";
				$extension = substr($get_recipe_image, -3);
				$inp_category_image = "category_" . $get_current_category_id . "_" . $l . ".$extension";
				$inp_category_image_mysql = quote_smart($link, $inp_category_image);

				$inp_new_x = 203;
				$inp_new_y = 152;

				if(file_exists("$root/_uploads/recipes/categories/$inp_category_image")){
					// We want a new one each week
					unlink("$root/_uploads/recipes/categories/$inp_category_image");
				}
				resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_recipe_image_path/$get_recipe_image", "$root/_uploads/recipes/categories/$inp_category_image");
				$result_update = mysqli_query($link, "UPDATE $t_recipes_categories_translations SET 
									category_translation_image_path='$inp_category_image_path', category_translation_image=$inp_category_image_mysql,
									category_translation_image_updated_week='$current_week', category_translation_last_updated='$current_datetime' WHERE category_id=$get_current_category_id AND category_translation_language=$l_mysql");
			}

			// Get rating
			$query_rating = "SELECT rating_id, rating_average, rating_popularity FROM $t_recipes_rating WHERE rating_recipe_id='$get_recipe_id'";
			$result_rating = mysqli_query($link, $query_rating);
			$row_rating = mysqli_fetch_row($result_rating);
			list($get_rating_id, $get_rating_average, $get_rating_popularity) = $row_rating;

			
			// 4 divs

			// 847 / 4 = 211
			// 847 / 3 = 282

			// Thumb
			$inp_new_x = 258; // 278 px × 154
			$inp_new_y = 184;
			 $thumb = "recipe_" . $get_recipe_id . "-" . $inp_new_x . "x" . $inp_new_y . ".jpg";
			 if(!(file_exists("$root/_cache/$thumb"))){
				resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_recipe_image_path/$get_recipe_image", "$root/_cache/$thumb");
			 }


			if($x == 0){
				echo"
				<div class=\"clear\"></div>
				<div class=\"left_center_center_right_left\">
				";
			}
			elseif($x == 1){
				echo"
				<div class=\"left_center_center_left_right_center\">
				";
			}
			elseif($x == 2){
				echo"
				<div class=\"left_center_center_right_right_center\">
				";
			}
			elseif($x == 3){
				echo"
				<div class=\"left_center_center_right_right\">
				";
			}
		
			echo"

				<!-- Gamle kode 
					<p class=\"recipe_open_category_img_p\">
					<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\"><img src=\"$root/$get_recipe_image_path/$get_recipe_thumb\" alt=\"$get_recipe_thumb\" /></a><br />
					</p>
					<p class=\"recipe_open_category_p\">
					<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"recipe_open_category_a\">$get_recipe_title</a>
					</p>
	
						Gamle kode slutt-->


					<!-- skriver ut bilder per oppskrift -->
					<p class=\"recipe_open_category_img_p\">
					<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\"><img src=\"$root/_cache/$thumb\" alt=\"$get_recipe_image\" width=\"$inp_new_x\" height=\"$inp_new_y\" /></a><br />
					</p>
					<p class=\"recipe_open_category_p\">
					<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"recipe_open_category_a\">$get_recipe_title</a>
					</p>


					<div class=\"recipe_open_category_unique_hits\">
						<img src=\"_gfx/icons/ic_eye_grey_18px.png\" alt=\"eye.png\" style=\"float:left;padding-right: 5px;\" /> 
						<span class=\"recipe_open_category_unique_hits_span\">
						$get_recipe_unique_hits 
						</span>
					</div>
					<div class=\"recipe_open_category_popularity\">
						<span class=\"recipe_open_category_popularity_span\">
						$get_rating_popularity %
						</span>
						<img src=\"_gfx/icons/ic_thumb_up_grey_18px.png\" alt=\"ic_thumb_up_grey_18px.png\" style=\"float:right;padding-left: 5px;\" /> 
					</div>



				</div>
			";

			// Increment
			$x++;
			$count_recipes++;
		
			// Reset
			if($x == 4){
				$x = 0;
			}

		} // get_recipe_image

	}
	// Check if number is correct
	if($count_recipes != "$get_current_category_translation_no_recipes"){
		$result = mysqli_query($link, "UPDATE $t_recipes_categories_translations SET category_translation_no_recipes='$count_recipes' WHERE category_id=$category_id_mysql AND category_translation_language=$l_mysql");
	}




	if($x == 1){
		echo"
			<div class=\"left_center_center_right_center\">
			</div>
			<div class=\"left_center_center_right_center\">
			</div>
			<div class=\"left_center_center_right_right\">
			</div>
		";
	
	}
	elseif($x == 2){
		echo"
			<div class=\"left_center_center_right_center\">
			</div>
			<div class=\"left_center_center_right_right\">
			</div>
		";

	}
	elseif($x == 3){
		echo"
			<div class=\"left_center_center_right_right\">
			</div>
		";

	}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>