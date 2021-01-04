<?php 
/**
*
* File: recipes/occasions_browse.php
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

// Language
include("$root/_admin/_translations/site/$l/recipes/ts_search.php");
include("$root/_admin/_translations/site/$l/recipes/ts_recipes.php");


/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['occasion_id'])) {
	$occasion_id = $_GET['occasion_id'];
	$occasion_id = strip_tags(stripslashes($occasion_id));
}
else{
	$occasion_id = "";
}
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
$l_mysql = quote_smart($link, $l);


// Select
$occasion_id_mysql = quote_smart($link, $occasion_id);
$query = "SELECT occasion_id, occasion_name, occasion_image, occasion_last_updated FROM $t_recipes_occasions WHERE occasion_id=$occasion_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_occasion_id, $get_occasion_name, $get_occasion_image, $get_occasion_last_updated) = $row;

if($get_occasion_id != ""){
	// Translations
	$query = "SELECT occasion_translation_id, occasion_translation_value FROM $t_recipes_occasions_translations WHERE occasion_id='$get_occasion_id' AND occasion_translation_language=$l_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_occasion_translation_id, $get_occasion_translation_value) = $row;
	
}


/*- Headers ---------------------------------------------------------------------------------- */
if($get_occasion_id == ""){
	$website_title = "Server error 404";
}
else{
	$website_title = "$l_recipes - $l_occasions - $get_occasion_translation_value";
}

if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */

if($action == ""){
	echo"
	<div class=\"recipes_headline\">
		<h1>$get_occasion_translation_value</h1>

		<!-- Where am I? -->
			<p><b>$l_you_are_here:</b><br />
			<a href=\"index.php?l=$l\">$l_recipes</a>
			&gt;
			<a href=\"occasions_browse.php?occasion_id=$get_occasion_id&amp;l=$l\">$get_occasion_translation_value</a>
			</p>
		<!-- //Where am I? -->
	</div>
	<div class=\"recipes_menu\">
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
					<option value=\"occasions_browse.php?occasion_id=$occasion_id&amp;order_by=recipe_id&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "recipe_id" OR $order_by == ""){ echo" selected=\"selected\""; } echo">$l_date</option>
					<option value=\"occasions_browse.php?occasion_id=$occasion_id&amp;order_by=recipe_title&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "recipe_title"){ echo" selected=\"selected\""; } echo">$l_title</option>
					<option value=\"occasions_browse.php?occasion_id=$occasion_id&amp;order_by=recipe_comments&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "recipe_comments"){ echo" selected=\"selected\""; } echo">$l_comments</option>
					<option value=\"occasions_browse.php?occasion_id=$occasion_id&amp;order_by=recipe_unique_hits&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "recipe_unique_hits"){ echo" selected=\"selected\""; } echo">$l_unique_hits</option>
					<option value=\"occasions_browse.php?occasion_id=$occasion_id&amp;order_by=number_serving_calories&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "number_serving_calories"){ echo" selected=\"selected\""; } echo">$l_calories</option>
					<option value=\"occasions_browse.php?occasion_id=$occasion_id&amp;order_by=number_serving_fat&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "number_serving_fat"){ echo" selected=\"selected\""; } echo">$l_fat</option>
					<option value=\"occasions_browse.php?occasion_id=$occasion_id&amp;order_by=number_serving_carbs&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "number_serving_carbs"){ echo" selected=\"selected\""; } echo">$l_carbs</option>
					<option value=\"occasions_browse.php?occasion_id=$occasion_id&amp;order_by=number_serving_proteins&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "number_serving_proteins"){ echo" selected=\"selected\""; } echo">$l_proteins</option>
				</select>
				<select name=\"inp_order_method\" id=\"inp_order_method_select\">
					<option value=\"occasions_browse.php?occasion_id=$occasion_id&amp;order_by=$order_by&amp;order_method=asc&amp;l=$l\""; if($order_method == "asc" OR $order_method == ""){ echo" selected=\"selected\""; } echo">$l_asc</option>
					<option value=\"occasions_browse.php?occasion_id=$occasion_id&amp;order_by=$order_by&amp;order_method=desc&amp;l=$l\""; if($order_method == "desc"){ echo" selected=\"selected\""; } echo">$l_desc</option>
				</select>
				</p>
        		</form>
		<!-- //Order -->
	</div>
	";

	$date = date("Y-m-d");

	// Select recipes
	$x = 0;
	$query = "SELECT $t_recipes.recipe_id, $t_recipes.recipe_title, $t_recipes.recipe_introduction, $t_recipes.recipe_image_path, $t_recipes.recipe_image, $t_recipes.recipe_thumb_278x156, $t_recipes.recipe_unique_hits FROM $t_recipes JOIN $t_recipes_numbers ON $t_recipes.recipe_id=$t_recipes_numbers.number_recipe_id WHERE $t_recipes.recipe_occasion_id='$get_occasion_id' AND $t_recipes.recipe_language=$l_mysql";
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

	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_recipe_id, $get_recipe_title, $get_recipe_introduction, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb_278x156, $get_recipe_unique_hits) = $row;

		if($get_recipe_image != ""){
		

			// Get rating
			$query_rating = "SELECT rating_id, rating_average, rating_popularity FROM $t_recipes_rating WHERE rating_recipe_id='$get_recipe_id'";
			$result_rating = mysqli_query($link, $query_rating);
			$row_rating = mysqli_fetch_row($result_rating);
			list($get_rating_id, $get_rating_average, $get_rating_popularity) = $row_rating;

			// Select Nutrients
			$query_n = "SELECT number_id, number_recipe_id, number_hundred_calories, number_hundred_proteins, number_hundred_fat, number_hundred_fat_of_which_saturated_fatty_acids, number_hundred_carbs, number_hundred_carbs_of_which_dietary_fiber, number_hundred_carbs_of_which_sugars, number_hundred_salt, number_hundred_sodium, number_serving_calories, number_serving_proteins, number_serving_fat, number_serving_fat_of_which_saturated_fatty_acids, number_serving_carbs, number_serving_carbs_of_which_dietary_fiber, number_serving_carbs_of_which_sugars, number_serving_salt, number_serving_sodium, number_total_weight, number_total_calories, number_total_proteins, number_total_fat, number_total_fat_of_which_saturated_fatty_acids, number_total_carbs, number_total_carbs_of_which_dietary_fiber, number_total_carbs_of_which_sugars, number_total_salt, number_total_sodium, number_servings FROM $t_recipes_numbers WHERE number_recipe_id=$get_recipe_id";
			$result_n = mysqli_query($link, $query_n);
			$row_n = mysqli_fetch_row($result_n);
			list($get_number_id, $get_number_recipe_id, $get_number_hundred_calories, $get_number_hundred_proteins, $get_number_hundred_fat, $get_number_hundred_fat_of_which_saturated_fatty_acids, $get_number_hundred_carbs, $get_number_hundred_carbs_of_which_dietary_fiber, $get_number_hundred_carbs_of_which_sugars, $get_number_hundred_salt, $get_number_hundred_sodium, $get_number_serving_calories, $get_number_serving_proteins, $get_number_serving_fat, $get_number_serving_fat_of_which_saturated_fatty_acids, $get_number_serving_carbs, $get_number_serving_carbs_of_which_dietary_fiber, $get_number_serving_carbs_of_which_sugars, $get_number_serving_salt, $get_number_serving_sodium, $get_number_total_weight, $get_number_total_calories, $get_number_total_proteins, $get_number_total_fat, $get_number_total_fat_of_which_saturated_fatty_acids, $get_number_total_carbs, $get_number_total_carbs_of_which_dietary_fiber, $get_number_total_carbs_of_which_sugars, $get_number_total_salt, $get_number_total_sodium, $get_number_servings) = $row_n;
			
			// 4 divs

			// 847 / 4 = 211
			// 847 / 3 = 282

			// Recipe thumb
			if($get_recipe_thumb_278x156 == "" OR !(file_exists("$root/$get_recipe_image_path/$get_recipe_thumb_278x156"))){
				$inp_new_x = 278; // from HD 1920x1080
				$inp_new_y = 156;

				$ext = get_extension($get_recipe_image);

				echo"<div class=\"info\"><p>Creating recipe thumb $inp_new_x x $inp_new_y  px</p></div>";

				$thumb = $get_recipe_id . "_thumb_" . $inp_new_x . "x" . $inp_new_y . ".png";
				$thumb_mysql = quote_smart($link, $thumb);
				resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_recipe_image_path/$get_recipe_image", "$root/$get_recipe_image_path/$thumb");
				mysqli_query($link, "UPDATE $t_recipes SET recipe_thumb_278x156=$thumb_mysql WHERE recipe_id=$get_recipe_id") or die(mysqli_error($link));
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
					<!-- skriver ut bilder per oppskrift -->
					<p>
					<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\"><img src=\"$root/$get_recipe_image_path/$get_recipe_thumb_278x156\" alt=\"$get_recipe_image\" /></a><br />
					<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"h2\">$get_recipe_title</a>
					</p>

					<!-- Numbers -->

					<table style=\"margin: 0px auto;\">
					 <tr>
					  <td style=\"padding-right: 10px;text-align: center;\">
						<span class=\"grey_small\">$get_number_hundred_calories</span>
					  </td>
					  <td style=\"padding-right: 10px;text-align: center;\">
						<span class=\"grey_small\">$get_number_hundred_fat</span>
					  </td>
					  <td style=\"padding-right: 10px;text-align: center;\">
						<span class=\"grey_small\">$get_number_hundred_carbs</span>
					  </td>
					  <td style=\"text-align: center;\">
						<span class=\"grey_small\">$get_number_hundred_proteins</span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding-right: 10px;text-align: center;\">
						<span class=\"grey_small\">$l_cal_lowercase</span>
					  </td>
					  <td style=\"padding-right: 10px;text-align: center;\">
						<span class=\"grey_small\">$l_fat_lowercase</span>
					  </td>
					  <td style=\"padding-right: 10px;text-align: center;\">
						<span class=\"grey_small\">$l_carb_lowercase</span>
					  </td>
					  <td style=\"text-align: center;\">
						<span class=\"grey_small\">$l_proteins_abbr_lowercase</span>
					  </td>
					 </tr>
					</table>

				</div>
			";

			// Increment
			$x++;
		
			// Reset
			if($x == 4){
				$x = 0;
			}

			// Update image?
			if($get_occasion_last_updated != "$date"){
				$inp_occasion_image = "$get_recipe_image_path/$get_recipe_image";
				$inp_occasion_image_mysql = quote_smart($link, $inp_occasion_image);
				$result_upd = mysqli_query($link, "UPDATE $t_recipes_occasions SET occasion_image=$inp_occasion_image_mysql, occasion_last_updated='$date' WHERE occasion_id='$get_occasion_id'");
			}


		} // get_recipe_image

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

}
elseif($action == "3"){

echo"
<h1>$get_category_translation_value</h1>
";

// Select recipes

$x = 0;
$query = "SELECT recipe_id, recipe_title, recipe_introduction, recipe_image_path, recipe_image FROM $t_recipes WHERE recipe_category_id='$get_category_id' AND recipe_language=$l_mysql ORDER BY recipe_last_viewed ASC";
$result = mysqli_query($link, $query);
while($row = mysqli_fetch_row($result)) {
	list($get_recipe_id, $get_recipe_title, $get_recipe_introduction, $get_recipe_image_path, $get_recipe_image) = $row;

	if($get_recipe_image != ""){
		
			
		// 4 divs

		// 847 / 4 = 211
		// 847 / 3 = 282

		// Thumb
		$inp_new_x = 277;
		$inp_new_y = 103;
		$thumb = $get_recipe_id . "-" . $inp_new_x . "x" . $inp_new_y . "png";

		if(!(file_exists("$root/_cache/$thumb"))){
			create_thumb("$root/$get_recipe_image_path/$get_recipe_image", "$root/_cache/$thumb", $inp_new_x, $inp_new_y);
		}



		if($x == 0){
			echo"
			<div class=\"clear\"></div>
			<div class=\"left_center_right_left\">
			";
		}
		elseif($x == 1){
			echo"
			<div class=\"left_center_right_center\">
			";
		}
		elseif($x == 2){
			echo"
			<div class=\"left_center_right_right\">
			";
		}
		
		echo"
				<p style=\"margin: 10px 0px 10px 0px;padding: 0;\">
				<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id\"><img src=\"$root/_cache/$thumb\" alt=\"$get_recipe_image\" width=\"$inp_new_x\" height=\"$inp_new_y\" /></a><br />
				<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id\" class=\"h2\">$get_recipe_title</a>
				</p>


			</div>
		";

		// Increment
		$x++;
		
		// Reset
		if($x == 3){
			$x = 0;
		}

	} // get_recipe_image

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
}


/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>