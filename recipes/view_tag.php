<?php 
/**
*
* File: recipes/view_tag_1200.php
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

/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['tag'])) {
	$tag = $_GET['tag'];
	$tag = strip_tags(stripslashes($tag));
}
else{
	$tag = "";
}
$tag_mysql = quote_smart($link, $tag);


$l_mysql = quote_smart($link, $l);



/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_recipes - #$tag";
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
<!-- Headline -->
	<div class=\"recipes_headline\">
		<h1>#$tag</h1>

		<!-- Where am I? -->
			<p><b>$l_you_are_here:</b><br />
			<a href=\"index.php?l=$l\">$l_recipes</a>
			&gt;
			<a href=\"view_tag_1200.php?tag=$tag&amp;l=$l\">#$tag</a>
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
					<option value=\"view_tag.php?tag=$tag&amp;l=$l\">- $l_order_by -</option>
					<option value=\"view_tag.php?tag=$tag&amp;order_by=recipe_id&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "recipe_id" OR $order_by == ""){ echo" selected=\"selected\""; } echo">$l_date</option>
					<option value=\"view_tag.php?tag=$tag&amp;order_by=recipe_title&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "recipe_title"){ echo" selected=\"selected\""; } echo">$l_title</option>
					<option value=\"view_tag.php?tag=$tag&amp;order_by=recipe_comments&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "recipe_comments"){ echo" selected=\"selected\""; } echo">$l_comments</option>
					<option value=\"view_tag.php?tag=$tag&amp;order_by=recipe_unique_hits&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "recipe_unique_hits"){ echo" selected=\"selected\""; } echo">$l_unique_hits</option>
					<option value=\"view_tag.php?tag=$tag&amp;order_by=number_serving_calories&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "number_serving_calories"){ echo" selected=\"selected\""; } echo">$l_calories</option>
					<option value=\"view_tag.php?tag=$tag&amp;order_by=number_serving_fat&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "number_serving_fat"){ echo" selected=\"selected\""; } echo">$l_fat</option>
					<option value=\"view_tag.php?tag=$tag&amp;order_by=number_serving_carbs&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "number_serving_carbs"){ echo" selected=\"selected\""; } echo">$l_carbs</option>
					<option value=\"view_tag.php?tag=$tag&amp;order_by=number_serving_proteins&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "number_serving_proteins"){ echo" selected=\"selected\""; } echo">$l_proteins</option>
				</select>
				<select name=\"inp_order_method\" id=\"inp_order_method_select\">
					<option value=\"view_tag.php?tag=$tag&amp;order_by=$order_by&amp;order_method=asc&amp;l=$l\""; if($order_method == "asc"){ echo" selected=\"selected\""; } echo">$l_asc</option>
					<option value=\"view_tag.php?tag=$tag&amp;order_by=$order_by&amp;order_method=desc&amp;l=$l\""; if($order_method == "desc"){ echo" selected=\"selected\""; } echo">$l_desc</option>
				</select> 
				</p>
        		</form>
		<!-- //Order -->
	</div>
	<div class=\"clear\"></div>
<!-- //Headline -->
";

	// Select recipes
	$x = 0;
	$count_recipes = 0;
	$query = "SELECT $t_recipes_tags.tag_id, $t_recipes.recipe_id, $t_recipes.recipe_title, $t_recipes.recipe_introduction, $t_recipes.recipe_image_path, $t_recipes.recipe_image, $t_recipes.recipe_thumb_278x156, $t_recipes.recipe_unique_hits FROM $t_recipes_tags INNER JOIN $t_recipes ON $t_recipes_tags.tag_recipe_id=$t_recipes.recipe_id WHERE $t_recipes_tags.tag_language=$l_mysql AND $t_recipes_tags.tag_title_clean=$tag_mysql";

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
		list($get_tag_id, $get_recipe_id, $get_recipe_title, $get_recipe_introduction, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb_278x156, $get_recipe_unique_hits) = $row;

		if($get_recipe_image != ""){
		

			// Get rating
			$query_rating = "SELECT rating_id, rating_average FROM $t_recipes_rating WHERE rating_recipe_id='$get_recipe_id'";
			$result_rating = mysqli_query($link, $query_rating);
			$row_rating = mysqli_fetch_row($result_rating);
			list($get_rating_id, $get_rating_average) = $row_rating;

			// Select Nutrients
			$query_n = "SELECT number_id, number_recipe_id, number_hundred_calories, number_hundred_proteins, number_hundred_fat, number_hundred_fat_of_which_saturated_fatty_acids, number_hundred_carbs, number_hundred_carbs_of_which_dietary_fiber, number_hundred_carbs_of_which_sugars, number_hundred_salt, number_hundred_sodium, number_serving_calories, number_serving_proteins, number_serving_fat, number_serving_fat_of_which_saturated_fatty_acids, number_serving_carbs, number_serving_carbs_of_which_dietary_fiber, number_serving_carbs_of_which_sugars, number_serving_salt, number_serving_sodium, number_total_weight, number_total_calories, number_total_proteins, number_total_fat, number_total_fat_of_which_saturated_fatty_acids, number_total_carbs, number_total_carbs_of_which_dietary_fiber, number_total_carbs_of_which_sugars, number_total_salt, number_total_sodium, number_servings FROM $t_recipes_numbers WHERE number_recipe_id=$get_recipe_id";
			$result_n = mysqli_query($link, $query_n);
			$row_n = mysqli_fetch_row($result_n);
			list($get_number_id, $get_number_recipe_id, $get_number_hundred_calories, $get_number_hundred_proteins, $get_number_hundred_fat, $get_number_hundred_fat_of_which_saturated_fatty_acids, $get_number_hundred_carbs, $get_number_hundred_carbs_of_which_dietary_fiber, $get_number_hundred_carbs_of_which_sugars, $get_number_hundred_salt, $get_number_hundred_sodium, $get_number_serving_calories, $get_number_serving_proteins, $get_number_serving_fat, $get_number_serving_fat_of_which_saturated_fatty_acids, $get_number_serving_carbs, $get_number_serving_carbs_of_which_dietary_fiber, $get_number_serving_carbs_of_which_sugars, $get_number_serving_salt, $get_number_serving_sodium, $get_number_total_weight, $get_number_total_calories, $get_number_total_proteins, $get_number_total_fat, $get_number_total_fat_of_which_saturated_fatty_acids, $get_number_total_carbs, $get_number_total_carbs_of_which_dietary_fiber, $get_number_total_carbs_of_which_sugars, $get_number_total_salt, $get_number_total_sodium, $get_number_servings) = $row_n;

			

			// Recipe thumb
			if($get_recipe_thumb_278x156 == "" OR !(file_exists("$root/$get_recipe_image_path/$get_recipe_thumb_278x156"))){
				$inp_new_x = 278; // from HD 1920x1080
				$inp_new_y = 156;

				$ext = get_extension($get_recipe_image);

				echo"<div class=\"info\"><p>Creating recipe thumb $inp_new_x x $inp_new_y  px</p></div>";

				$thumb = $get_recipe_id . "_thumb_" . $inp_new_x . "x" . $inp_new_y . ".$ext";
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
					<p><a id=\"recipe$get_recipe_id\"></a>
					<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\"><img src=\"$root/$get_recipe_image_path/$get_recipe_thumb_278x156\" alt=\"$get_recipe_image\" /></a><br />
					<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"h2\">$get_recipe_title</a>
					</p>

					<!-- Numbers -->";
						if($get_number_hundred_calories != "0"){
						echo"
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
						";
					}
					echo"

				</div>
			";

			// Increment
			$x++;
			$count_recipes = $count_recipes+1;
		
			// Reset
			if($x == 4){
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
	echo"
	<div class=\"clear\"></div>
	";

	// Check if it exists in tags unique
	$year = date("Y");
	$month = date("m");
	$week = date("W");
	$tag_title_clean_mysql = quote_smart($link, $tag);
	$query = "SELECT tag_id, tag_language, tag_title, tag_title_clean, tag_number_of_recipes, tag_last_clicked_week, tag_unique_views_counter, tag_unique_views_ip_block FROM $t_recipes_tags_unique WHERE tag_language=$l_mysql AND tag_title_clean=$tag_title_clean_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_tag_id, $get_tag_language, $get_tag_title, $get_tag_title_clean, $get_tag_number_of_recipes, $get_tag_last_clicked_week, $get_tag_unique_views_counter, $get_tag_unique_views_ip_block) = $row;
	if($get_tag_id == ""){
		// Insert this tag unique
		mysqli_query($link, "INSERT INTO $t_recipes_tags_unique 
		(tag_id, tag_language, tag_title, tag_title_clean, tag_number_of_recipes, tag_last_clicked_year, tag_last_clicked_month, tag_last_clicked_week, tag_unique_views_counter) 
		VALUES 
		(NULL, $l_mysql, $tag_title_clean_mysql, $tag_title_clean_mysql, $count_recipes, $year, $month, $week, 1)")
		or die(mysqli_error($link)); 
	}
	else{
		// Update count, year, month, week
		if($count_recipes != "$get_tag_number_of_recipes" OR $week != "$get_tag_last_clicked_week"){
			$result = mysqli_query($link, "UPDATE $t_recipes_tags_unique SET 
						tag_number_of_recipes=$count_recipes, 
						tag_last_clicked_year=$year, 
						tag_last_clicked_month=$month, 
						tag_last_clicked_week=$week
						WHERE tag_id=$get_tag_id") or die(mysqli_error($link));
		}

		// Update hits
		$inp_ip = $_SERVER['REMOTE_ADDR'];
		$inp_ip = output_html($inp_ip);

		$ip_block_array = explode("\n", $get_tag_unique_views_ip_block);
		$ip_block_array_size = sizeof($ip_block_array);

		if($ip_block_array_size > 10){
			$ip_block_array_size = 5;
		}
	
		$has_seen_this_before = 0;

		$inp_unique_hits_ip_block = "";
		for($x=0;$x<$ip_block_array_size;$x++){
			if($ip_block_array[$x] == "$inp_ip"){
				$has_seen_this_before = 1;
				break;
			}
			if($inp_unique_hits_ip_block == ""){
				$inp_unique_hits_ip_block = $ip_block_array[$x];
			}
			else{
				$inp_unique_hits_ip_block = $inp_unique_hits_ip_block . "\n" . $ip_block_array[$x];
			}
		}
	
		if($has_seen_this_before == 0){
			$inp_unique_hits_ip_block = $inp_ip . "\n" . $inp_unique_hits_ip_block;
			$inp_unique_hits_ip_block_mysql = quote_smart($link, $inp_unique_hits_ip_block);
			$inp_unique_hits = $get_tag_unique_views_counter + 1;
			$result = mysqli_query($link, "UPDATE $t_recipes_tags_unique SET tag_unique_views_counter=$inp_unique_hits, tag_unique_views_ip_block=$inp_unique_hits_ip_block_mysql WHERE tag_id=$get_tag_id") or die(mysqli_error($link));
		}

	}


/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>