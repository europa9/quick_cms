<?php
/**
*
* File: food/view_food.php
* Version 1.0.0
* Date 23:07 09.07.2017
* Copyright (c) 2008-2018 Sindre Andre Ditlefsen
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
include("_tables_food.php");

/*- Get extention ---------------------------------------------------------------------- */
function getExtension($str) {
	$i = strrpos($str,".");
	if (!$i) { return ""; } 
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	return $ext;
}

/*- Tables ---------------------------------------------------------------------------- */
$t_food_liquidbase			= $mysqlPrefixSav . "food_liquidbase";

$t_food_categories		  	= $mysqlPrefixSav . "food_categories";
$t_food_categories_translations	  	= $mysqlPrefixSav . "food_categories_translations";
$t_food_index			 	= $mysqlPrefixSav . "food_index";
$t_food_index_stores		 	= $mysqlPrefixSav . "food_index_stores";
$t_food_index_ads		 	= $mysqlPrefixSav . "food_index_ads";
$t_food_index_tags		  	= $mysqlPrefixSav . "food_index_tags";
$t_food_index_prices		  	= $mysqlPrefixSav . "food_index_prices";
$t_food_index_contents		 	= $mysqlPrefixSav . "food_index_contents";
$t_food_index_ratings		 	= $mysqlPrefixSav . "food_index_ratings";
$t_food_stores		  	  	= $mysqlPrefixSav . "food_stores";
$t_food_prices_currencies	  	= $mysqlPrefixSav . "food_prices_currencies";
$t_food_favorites 		  	= $mysqlPrefixSav . "food_favorites";
$t_food_measurements	 	  	= $mysqlPrefixSav . "food_measurements";
$t_food_measurements_translations 	= $mysqlPrefixSav . "food_measurements_translations";
$t_food_countries_used	 	 	= $mysqlPrefixSav . "food_countries_used";
$t_food_integration	 	  	= $mysqlPrefixSav . "food_integration";
$t_food_age_restrictions 	 	= $mysqlPrefixSav . "food_age_restrictions";
$t_food_age_restrictions_accepted	= $mysqlPrefixSav . "food_age_restrictions_accepted";
/*- Variables ------------------------------------------------------------------------- */
$l_mysql = quote_smart($link, $l);


if(isset($_GET['main_category_id'])){
	$main_category_id= $_GET['main_category_id'];
	$main_category_id = strip_tags(stripslashes($main_category_id));
}
else{
	$main_category_id = "";
}
if(isset($_GET['sub_category_id'])){
	$sub_category_id= $_GET['sub_category_id'];
	$sub_category_id = strip_tags(stripslashes($sub_category_id));
}
else{
	$sub_category_id = "";
}

if(isset($_GET['food_id'])){
	$food_id = $_GET['food_id'];
	$food_id = strip_tags(stripslashes($food_id));
	
}
else{
	$food_id = "";
}
$food_id_mysql = quote_smart($link, $food_id);


// System
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);

	$query_t = "SELECT view_id, view_user_id, view_ip, view_year, view_system, view_hundred_metric, view_pcs_metric, view_eight_us, view_pcs_us FROM $t_food_user_adapted_view WHERE view_user_id=$my_user_id_mysql";
	$result_t = mysqli_query($link, $query_t);
	$row_t = mysqli_fetch_row($result_t);
	list($get_current_view_id, $get_current_view_user_id, $get_current_view_ip, $get_current_view_year, $get_current_view_system, $get_current_view_hundred_metric, $get_current_view_pcs_metric, $get_current_view_eight_us, $get_current_view_pcs_us) = $row_t;
}
else{
	// IP
	$my_user_ip = $_SERVER['REMOTE_ADDR'];
	$my_user_ip = output_html($my_user_ip);
	$my_user_ip_mysql = quote_smart($link, $my_user_ip);

	$query_t = "SELECT view_id, view_user_id, view_ip, view_year, view_system, view_hundred_metric, view_pcs_metric, view_eight_us, view_pcs_us FROM $t_food_user_adapted_view WHERE view_ip=$my_user_ip_mysql";
	$result_t = mysqli_query($link, $query_t);
	$row_t = mysqli_fetch_row($result_t);
	list($get_current_view_id, $get_current_view_user_id, $get_current_view_ip, $get_current_view_year, $get_current_view_system, $get_current_view_hundred_metric, $get_current_view_pcs_metric, $get_current_view_eight_us, $get_current_view_pcs_us) = $row_t;
}
if($get_current_view_system == ""){
	$get_current_view_system = "metric";
}




// Select food
$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_text, food_country, food_net_content_metric, food_net_content_measurement_metric, food_net_content_us, food_net_content_measurement_us, food_net_content_added_measurement, food_serving_size_metric, food_serving_size_measurement_metric, food_serving_size_us, food_serving_size_measurement_us, food_serving_size_added_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy_metric, food_fat_metric, food_saturated_fat_metric, food_monounsaturated_fat_metric, food_polyunsaturated_fat_metric, food_cholesterol_metric, food_carbohydrates_metric, food_carbohydrates_of_which_sugars_metric, food_dietary_fiber_metric, food_proteins_metric, food_salt_metric, food_sodium_metric, food_energy_us, food_fat_us, food_saturated_fat_us, food_monounsaturated_fat_us, food_polyunsaturated_fat_us, food_cholesterol_us, food_carbohydrates_us, food_carbohydrates_of_which_sugars_us, food_dietary_fiber_us, food_proteins_us, food_salt_us, food_sodium_us, food_score, food_energy_calculated_metric, food_fat_calculated_metric, food_saturated_fat_calculated_metric, food_monounsaturated_fat_calculated_metric, food_polyunsaturated_fat_calculated_metric, food_cholesterol_calculated_metric, food_carbohydrates_calculated_metric, food_carbohydrates_of_which_sugars_calculated_metric, food_dietary_fiber_calculated_metric, food_proteins_calculated_metric, food_salt_calculated_metric, food_sodium_calculated_metric, food_energy_calculated_us, food_fat_calculated_us, food_saturated_fat_calculated_us, food_monounsaturated_fat_calculated_us, food_polyunsaturated_fat_calculated_us, food_cholesterol_calculated_us, food_carbohydrates_calculated_us, food_carbohydrates_of_which_sugars_calculated_us, food_dietary_fiber_calculated_us, food_proteins_calculated_us, food_salt_calculated_us, food_sodium_calculated_us, food_energy_net_content, food_fat_net_content, food_saturated_fat_net_content, food_monounsaturated_fat_net_content, food_polyunsaturated_fat_net_content, food_cholesterol_net_content, food_carbohydrates_net_content, food_carbohydrates_of_which_sugars_net_content, food_dietary_fiber_net_content, food_proteins_net_content, food_salt_net_content, food_sodium_net_content, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_thumb_a_medium, food_thumb_a_large, food_image_b, food_thumb_b_small, food_thumb_b_medium, food_thumb_b_large, food_image_c, food_thumb_c_small, food_thumb_c_medium, food_thumb_c_large, food_image_d, food_thumb_d_small, food_thumb_d_medium, food_thumb_d_large, food_image_e, food_thumb_e_small, food_thumb_e_medium, food_thumb_e_large, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_created_date, food_last_viewed, food_age_restriction  FROM $t_food_index WHERE food_id=$food_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_food_id, $get_current_food_user_id, $get_current_food_name, $get_current_food_clean_name, $get_current_food_manufacturer_name, $get_current_food_manufacturer_name_and_food_name, $get_current_food_description, $get_current_food_text, $get_current_food_country, $get_current_food_net_content_metric, $get_current_food_net_content_measurement_metric, $get_current_food_net_content_us, $get_current_food_net_content_measurement_us, $get_current_food_net_content_added_measurement, $get_current_food_serving_size_metric, $get_current_food_serving_size_measurement_metric, $get_current_food_serving_size_us, $get_current_food_serving_size_measurement_us, $get_current_food_serving_size_added_measurement, $get_current_food_serving_size_pcs, $get_current_food_serving_size_pcs_measurement, $get_current_food_energy_metric, $get_current_food_fat_metric, $get_current_food_saturated_fat_metric, $get_current_food_monounsaturated_fat_metric, $get_current_food_polyunsaturated_fat_metric, $get_current_food_cholesterol_metric, $get_current_food_carbohydrates_metric, $get_current_food_carbohydrates_of_which_sugars_metric, $get_current_food_dietary_fiber_metric, $get_current_food_proteins_metric, $get_current_food_salt_metric, $get_current_food_sodium_metric, $get_current_food_energy_us, $get_current_food_fat_us, $get_current_food_saturated_fat_us, $get_current_food_monounsaturated_fat_us, $get_current_food_polyunsaturated_fat_us, $get_current_food_cholesterol_us, $get_current_food_carbohydrates_us, $get_current_food_carbohydrates_of_which_sugars_us, $get_current_food_dietary_fiber_us, $get_current_food_proteins_us, $get_current_food_salt_us, $get_current_food_sodium_us, $get_current_food_score, $get_current_food_energy_calculated_metric, $get_current_food_fat_calculated_metric, $get_current_food_saturated_fat_calculated_metric, $get_current_food_monounsaturated_fat_calculated_metric, $get_current_food_polyunsaturated_fat_calculated_metric, $get_current_food_cholesterol_calculated_metric, $get_current_food_carbohydrates_calculated_metric, $get_current_food_carbohydrates_of_which_sugars_calculated_metric, $get_current_food_dietary_fiber_calculated_metric, $get_current_food_proteins_calculated_metric, $get_current_food_salt_calculated_metric, $get_current_food_sodium_calculated_metric, $get_current_food_energy_calculated_us, $get_current_food_fat_calculated_us, $get_current_food_saturated_fat_calculated_us, $get_current_food_monounsaturated_fat_calculated_us, $get_current_food_polyunsaturated_fat_calculated_us, $get_current_food_cholesterol_calculated_us, $get_current_food_carbohydrates_calculated_us, $get_current_food_carbohydrates_of_which_sugars_calculated_us, $get_current_food_dietary_fiber_calculated_us, $get_current_food_proteins_calculated_us, $get_current_food_salt_calculated_us, $get_current_food_sodium_calculated_us, $get_current_food_energy_net_content, $get_current_food_fat_net_content, $get_current_food_saturated_fat_net_content, $get_current_food_monounsaturated_fat_net_content, $get_current_food_polyunsaturated_fat_net_content, $get_current_food_cholesterol_net_content, $get_current_food_carbohydrates_net_content, $get_current_food_carbohydrates_of_which_sugars_net_content, $get_current_food_dietary_fiber_net_content, $get_current_food_proteins_net_content, $get_current_food_salt_net_content, $get_current_food_sodium_net_content, $get_current_food_barcode, $get_current_food_main_category_id, $get_current_food_sub_category_id, $get_current_food_image_path, $get_current_food_image_a, $get_current_food_thumb_a_small, $get_current_food_thumb_a_medium, $get_current_food_thumb_a_large, $get_current_food_image_b, $get_current_food_thumb_b_small, $get_current_food_thumb_b_medium, $get_current_food_thumb_b_large, $get_current_food_image_c, $get_current_food_thumb_c_small, $get_current_food_thumb_c_medium, $get_current_food_thumb_c_large, $get_current_food_image_d, $get_current_food_thumb_d_small, $get_current_food_thumb_d_medium, $get_current_food_thumb_d_large, $get_current_food_image_e, $get_current_food_thumb_e_small, $get_current_food_thumb_e_medium, $get_current_food_thumb_e_large, $get_current_food_last_used, $get_current_food_language, $get_current_food_synchronized, $get_current_food_accepted_as_master, $get_current_food_notes, $get_current_food_unique_hits, $get_current_food_unique_hits_ip_block, $get_current_food_comments, $get_current_food_likes, $get_current_food_dislikes, $get_current_food_likes_ip_block, $get_current_food_user_ip, $get_current_food_created_date, $get_current_food_last_viewed, $get_current_food_age_restriction) = $row;

if($get_current_food_id == ""){
	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "$l_food - Server error 404";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");


	echo"
	<h1>Food not found</h1>

	<p>
	Sorry, the food was not found.
	</p>

	<p>
	<a href=\"index.php\">Back</a>
	</p>
	";
}
else{


	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "$l_food - $get_current_food_name $get_current_food_manufacturer_name";
	if($get_current_view_system == "metric"){
		$website_title = "$l_food - $get_current_food_name $get_current_food_manufacturer_name ($l_metric)";
	}
	elseif($get_current_view_system == "us"){
		$website_title = "$l_food - $get_current_food_name $get_current_food_manufacturer_name ($l_us)";
	}
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");


	// Last viewed
	$datetime = date("Y-m-d H:i:s");
	$result = mysqli_query($link, "UPDATE $t_food_index SET food_last_viewed='$datetime' WHERE food_id='$get_current_food_id'") or die(mysqli_error($link));

	// Author
	$query = "SELECT user_id, user_email, user_name, user_alias FROM $t_users WHERE user_id=$get_current_food_user_id";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_food_author_user_id, $get_current_food_author_user_email, $get_current_food_author_user_name, $get_current_food_author_user_alias) = $row;
	if($get_current_food_author_user_id == ""){
		$result = mysqli_query($link, "UPDATE $t_food_index SET food_user_id='1' WHERE food_id='$get_current_food_id'") or die(mysqli_error($link));
	}


	// Get sub category
	$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$get_current_food_sub_category_id";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_sub_category_id, $get_current_sub_category_user_id, $get_current_sub_category_name, $get_current_sub_category_parent_id) = $row;

	if($get_current_sub_category_id == ""){
		echo"<p><b>Unknown sub category.</b></p>";

		// Find a random sub category
		$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_parent_id != 0";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_sub_category_id, $get_current_sub_category_user_id, $get_current_sub_category_name, $get_current_sub_category_parent_id) = $row;
		echo"<p><b>Update sub category to $get_current_sub_category_id, $get_current_sub_category_user_id, $get_current_sub_category_name, $get_current_sub_category_parent_id.</b></p>";
		$result = mysqli_query($link, "UPDATE $t_food_index SET food_sub_category_id='$get_current_sub_category_id' WHERE food_id='$get_current_food_id'") or die(mysqli_error($link));
	}



	// Get main category
	$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$get_current_sub_category_parent_id";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_main_category_id, $get_current_main_category_user_id, $get_current_main_category_name, $get_current_main_category_parent_id) = $row;
	if($get_current_main_category_id == ""){
		echo"<p><b>Unknown category.</b></p>";
	}
	else{
		// Check that we have it correct
		if($get_current_main_category_id != "$get_current_food_main_category_id"){
			echo"<div class=\"info\"><p>Updated food main category id</p></div>\n";
			$result = mysqli_query($link, "UPDATE $t_food_index SET food_main_category_id='$get_current_main_category_id' WHERE food_id='$get_current_food_id'") or die(mysqli_error($link));
		}
	}

	// Translation
	$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_current_main_category_id AND category_translation_language=$l_mysql";
	$result_t = mysqli_query($link, $query_t);
	$row_t = mysqli_fetch_row($result_t);
	list($get_current_main_category_translation_value) = $row_t;

	// Sub category translation
	$query_t = "SELECT category_translation_id, category_id, category_translation_language, category_translation_value, category_translation_no_food, category_translation_last_updated, category_stats_last_updated_year, category_calories_min_metric, category_calories_med_metric, category_calories_max_metric, category_fat_min_metric, category_fat_med_metric, category_fat_max_metric, category_saturated_fat_min_metric, category_saturated_fat_med_metric, category_saturated_fat_max_metric, category_monounsaturated_fat_min_metric, category_monounsaturated_fat_med_metric, category_monounsaturated_fat_max_metric, category_polyunsaturated_fat_min_metric, category_polyunsaturated_fat_med_metric, category_polyunsaturated_fat_max_metric, category_cholesterol_min_metric, category_cholesterol_med_metric, category_cholesterol_max_metric, category_carb_min_metric, category_carb_med_metric, category_carb_max_metric, category_carb_of_which_sugars_min_metric, category_carb_of_which_sugars_med_metric, category_carb_of_which_sugars_max_metric, category_dietary_fiber_min_metric, category_dietary_fiber_med_metric, category_dietary_fiber_max_metric, category_proteins_min_metric, category_proteins_med_metric, category_proteins_max_metric, category_salt_min_metric, category_salt_med_metric, category_salt_max_metric, category_sodium_min_metric, category_sodium_med_metric, category_sodium_max_metric, category_calories_min_us, category_calories_med_us, category_calories_max_us, category_fat_min_us, category_fat_med_us, category_fat_max_us, category_saturated_fat_min_us, category_saturated_fat_med_us, category_saturated_fat_max_us, category_monounsaturated_fat_min_us, category_monounsaturated_fat_med_us, category_monounsaturated_fat_max_us, category_polyunsaturated_fat_min_us, category_polyunsaturated_fat_med_us, category_polyunsaturated_fat_max_us, category_cholesterol_min_us, category_cholesterol_med_us, category_cholesterol_max_us, category_carb_min_us, category_carb_med_us, category_carb_max_us, category_carb_of_which_sugars_min_us, category_carb_of_which_sugars_med_us, category_carb_of_which_sugars_max_us, category_dietary_fiber_min_us, category_dietary_fiber_med_us, category_dietary_fiber_max_us, category_proteins_min_us, category_proteins_med_us, category_proteins_max_us, category_salt_min_us, category_salt_med_us, category_salt_max_us, category_sodium_min_us, category_sodium_med_us, category_sodium_max_us FROM $t_food_categories_translations WHERE category_id=$get_current_sub_category_id AND category_translation_language=$l_mysql";
	$result_t = mysqli_query($link, $query_t);
	$row_t = mysqli_fetch_row($result_t);
	list($get_current_sub_category_translation_id, $get_current_sub_category_id, $get_current_sub_category_translation_language, $get_current_sub_category_translation_value, $get_current_sub_category_translation_no_food, $get_current_sub_category_translation_last_updated, $get_current_sub_category_stats_last_updated_year, $get_current_sub_category_calories_min_metric, $get_current_sub_category_calories_med_metric, $get_current_sub_category_calories_max_metric, $get_current_sub_category_fat_min_metric, $get_current_sub_category_fat_med_metric, $get_current_sub_category_fat_max_metric, $get_current_sub_category_saturated_fat_min_metric, $get_current_sub_category_saturated_fat_med_metric, $get_current_sub_category_saturated_fat_max_metric, $get_current_sub_category_monounsaturated_fat_min_metric, $get_current_sub_category_monounsaturated_fat_med_metric, $get_current_sub_category_monounsaturated_fat_max_metric, $get_current_sub_category_polyunsaturated_fat_min_metric, $get_current_sub_category_polyunsaturated_fat_med_metric, $get_current_sub_category_polyunsaturated_fat_max_metric, $get_current_sub_category_cholesterol_min_metric, $get_current_sub_category_cholesterol_med_metric, $get_current_sub_category_cholesterol_max_metric, $get_current_sub_category_carb_min_metric, $get_current_sub_category_carb_med_metric, $get_current_sub_category_carb_max_metric, $get_current_sub_category_carb_of_which_sugars_min_metric, $get_current_sub_category_carb_of_which_sugars_med_metric, $get_current_sub_category_carb_of_which_sugars_max_metric, $get_current_sub_category_dietary_fiber_min_metric, $get_current_sub_category_dietary_fiber_med_metric, $get_current_sub_category_dietary_fiber_max_metric, $get_current_sub_category_proteins_min_metric, $get_current_sub_category_proteins_med_metric, $get_current_sub_category_proteins_max_metric, $get_current_sub_category_salt_min_metric, $get_current_sub_category_salt_med_metric, $get_current_sub_category_salt_max_metric, $get_current_sub_category_sodium_min_metric, $get_current_sub_category_sodium_med_metric, $get_current_sub_category_sodium_max_metric, $get_current_sub_category_calories_min_us, $get_current_sub_category_calories_med_us, $get_current_sub_category_calories_max_us, $get_current_sub_category_fat_min_us, $get_current_sub_category_fat_med_us, $get_current_sub_category_fat_max_us, $get_current_sub_category_saturated_fat_min_us, $get_current_sub_category_saturated_fat_med_us, $get_current_sub_category_saturated_fat_max_us, $get_current_sub_category_monounsaturated_fat_min_us, $get_current_sub_category_monounsaturated_fat_med_us, $get_current_sub_category_monounsaturated_fat_max_us, $get_current_sub_category_polyunsaturated_fat_min_us, $get_current_sub_category_polyunsaturated_fat_med_us, $get_current_sub_category_polyunsaturated_fat_max_us, $get_current_sub_category_cholesterol_min_us, $get_current_sub_category_cholesterol_med_us, $get_current_sub_category_cholesterol_max_us, $get_current_sub_category_carb_min_us, $get_current_sub_category_carb_med_us, $get_current_sub_category_carb_max_us, $get_current_sub_category_carb_of_which_sugars_min_us, $get_current_sub_category_carb_of_which_sugars_med_us, $get_current_sub_category_carb_of_which_sugars_max_us, $get_current_sub_category_dietary_fiber_min_us, $get_current_sub_category_dietary_fiber_med_us, $get_current_sub_category_dietary_fiber_max_us, $get_current_sub_category_proteins_min_us, $get_current_sub_category_proteins_med_us, $get_current_sub_category_proteins_max_us, $get_current_sub_category_salt_min_us, $get_current_sub_category_salt_med_us, $get_current_sub_category_salt_max_us, $get_current_sub_category_sodium_min_us, $get_current_sub_category_sodium_med_us, $get_current_sub_category_sodium_max_us) = $row_t;
		

	
	// Unique hits
	$inp_ip = $_SERVER['REMOTE_ADDR'];
	$inp_ip = output_html($inp_ip);

	$ip_array = explode("\n", $get_current_food_unique_hits_ip_block);
	$ip_array_size = sizeof($ip_array);

	$has_seen_this_food_before = 0;

	for($x=0;$x<$ip_array_size;$x++){
		if($ip_array[$x] == "$inp_ip"){
			$has_seen_this_food_before = 1;
			break;
		}
		if($x > 5){
			break;
		}
	}
	
	if($has_seen_this_food_before == 0){
		$inp_food_unique_hits_ip_block = $inp_ip . "\n" . $get_current_food_unique_hits_ip_block;
		$inp_food_unique_hits_ip_block_mysql = quote_smart($link, $inp_food_unique_hits_ip_block);
		$inp_food_unique_hits = $get_current_food_unique_hits + 1;
		$result = mysqli_query($link, "UPDATE $t_food_index SET food_unique_hits=$inp_food_unique_hits, food_unique_hits_ip_block=$inp_food_unique_hits_ip_block_mysql WHERE food_id=$food_id_mysql") or die(mysqli_error($link));
	}



	// Manufactor and food name
	if($get_current_food_manufacturer_name_and_food_name != "$get_current_food_manufacturer_name $get_current_food_name"){
		$inp_food_manufacturer_name_and_food_name = "$get_current_food_manufacturer_name $get_current_food_name";
		$inp_food_manufacturer_name_and_food_name_mysql = quote_smart($link, $inp_food_manufacturer_name_and_food_name);
		$result = mysqli_query($link, "UPDATE $t_food_index SET food_manufacturer_name_and_food_name=$inp_food_manufacturer_name_and_food_name_mysql WHERE food_id=$food_id_mysql") or die(mysqli_error($link));
		
		echo"
		<div class=\"info\"><p>Updated food_manufacturer_name_and_food_name to $inp_food_manufacturer_name_and_food_name</p></div>
		";
	}

	// Restriction?
	$get_current_restriction_show_food = 1;
	$get_current_restriction_show_image_a = 1;
	$get_current_restriction_show_image_b = 1;
	$get_current_restriction_show_image_c = 1;
	$get_current_restriction_show_image_d = 1;
	$get_current_restriction_show_image_e = 1;
	$get_current_restriction_show_smileys = 1;
	if($get_current_food_age_restriction == "1"){
		// Check if I have accepted 
		$inp_ip_mysql = quote_smart($link, $my_ip);
		$query_t = "SELECT accepted_id, accepted_country FROM $t_food_age_restrictions_accepted WHERE accepted_ip=$inp_ip_mysql";
		$result_t = mysqli_query($link, $query_t);
		$row_t = mysqli_fetch_row($result_t);
		list($get_accepted_id, $get_accepted_country) = $row_t;
		
		if($get_accepted_id == ""){
			// Accept age restriction
			$get_current_restriction_show_food = 0;
			include("view_food_show_age_restriction_warning.php");
		}
		else{
			// Can I see food and images?
			$country_mysql = quote_smart($link, $get_accepted_country);
			$query = "SELECT restriction_id, restriction_country_name, restriction_country_iso_two, restriction_country_flag_path_16x16, restriction_country_flag_16x16, restriction_language, restriction_age_limit, restriction_title, restriction_text, restriction_show_food, restriction_show_image_a, restriction_show_image_b, restriction_show_image_c, restriction_show_image_d, restriction_show_image_e, restriction_show_smileys FROM $t_food_age_restrictions WHERE restriction_country_iso_two=$country_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_restriction_id, $get_current_restriction_country_name, $get_current_restriction_country_iso_two, $get_current_restriction_country_flag_path_16x16, $get_current_restriction_country_flag_16x16, $get_current_restriction_language, $get_current_restriction_age_limit, $get_current_restriction_title, $get_current_restriction_text, $get_current_restriction_show_food, $get_current_restriction_show_image_a, $get_current_restriction_show_image_b, $get_current_restriction_show_image_c, $get_current_restriction_show_image_d, $get_current_restriction_show_image_e, $get_current_restriction_show_smileys) = $row;

			if($get_current_restriction_id == ""){
				// Could not find country
				echo"<div class=\"error\"><p>Could not find country.</p></div>\n";
			}

			if($get_current_restriction_show_food == 0){
				echo"
				<h1 style=\"padding-bottom:0;margin-bottom:0;\">$get_current_food_manufacturer_name $get_current_food_name</h1>
				<p>$get_current_restriction_text</p>
				";
				
			}
		}
	}



	if($get_current_restriction_show_food == 1){
		if($process != "1"){
			echo"
			<!-- Headline and store -->
				<h1 style=\"padding-bottom:0;margin-bottom:0;\">$get_current_food_manufacturer_name $get_current_food_name</h1>
			<!-- //Headline and store -->


			<!-- Where am I? -->
				<p><b>$l_you_are_here:</b><br />
				<a href=\"index.php?l=$l\">$l_food</a>
				&gt;
				<a href=\"open_main_category.php?main_category_id=$get_current_main_category_id&amp;l=$l\">$get_current_main_category_translation_value</a>
				&gt;
				<a href=\"open_sub_category.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;l=$l\">$get_current_sub_category_translation_value</a>
				&gt;
				<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;l=$l\">$get_current_food_name</a>
				</p>
			<!-- //Where am I? -->
	
			<!-- Ad -->
				";
				include("$root/ad/_includes/ad_main_below_headline.php");
				echo"
			<!-- //Ad -->

			<!-- Images, width = 845 -->
				<p style=\"padding-bottom: 0;margin-bottom: 0;\">";

				// Clean name
				if($get_current_food_clean_name == ""){
					$inp_food_clean_name = clean($get_current_food_name);
					$inp_food_clean_name_mysql = quote_smart($link, $inp_food_clean_name);
					$result = mysqli_query($link, "UPDATE $t_food_index SET food_clean_name =$inp_food_clean_name_mysql WHERE food_id='$get_current_food_id'") or die(mysqli_error($link));
					$get_current_food_clean_name = "$inp_food_clean_name";
				}


				if($get_current_food_image_path == ""){
					$year = date("Y");

					$inp_food_image_path = "_uploads/food/_img/$editor_language/$year";
					if(!(file_exists("../$inp_food_image_path"))){
						mkdir("../$inp_food_image_path");
					}

					$food_manufacturer_name_clean = clean($get_current_food_manufacturer_name);
					$store_dir = $food_manufacturer_name_clean . "_" . $get_current_food_clean_name;
					$inp_food_image_path = "_uploads/food/_img/$editor_language/$year/$store_dir";
					if(!(file_exists("../$inp_food_image_path"))){
						mkdir("../$inp_food_image_path");
					}
					$inp_food_image_path_mysql = quote_smart($link, $inp_food_image_path);
					$result = mysqli_query($link, "UPDATE $t_food_index SET food_image_path=$inp_food_image_path_mysql WHERE food_id='$get_current_food_id'") or die(mysqli_error($link));

					echo"<p>Created food image path</p>";
				}

				// 845/4 = 211
				if($action == "show_image" && isset($_GET['image'])){
					echo"<a id=\"image\"></a>";
					$image = $_GET['image'];
					$image = strip_tags(stripslashes($image));
	
					if($image == "a" && file_exists("../$get_current_food_image_path/$get_current_food_image_a") && $get_current_food_image_a != ""){
				
						if(file_exists("../$get_current_food_image_path/$get_current_food_image_b")){
							echo"<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;action=show_image&amp;image=b&amp;l=$l#image\"><img src=\"../$get_current_food_image_path/$get_current_food_image_a\" alt=\"$get_current_food_image_a\" /></a>";
						}
						else{
							echo"<img src=\"../$get_current_food_image_path/$get_current_food_image_a\" alt=\"$get_current_food_image_a\" />";
						}
					}
					if($image == "b" && file_exists("../$get_current_food_image_path/$get_current_food_image_b") && $get_current_food_image_b != ""){
				
						if(file_exists("../$get_current_food_image_path/$get_current_food_image_c")){
							echo"<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;action=show_image&amp;image=c&amp;l=$l#image\"><img src=\"../$get_current_food_image_path/$get_current_food_image_b\" alt=\"$get_current_food_image_b\" /></a>";
						}
						else{
							echo"<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;l=$l#image\"><img src=\"../$get_current_food_image_path/$get_current_food_image_b\" alt=\"$get_current_food_image_b\" /></a>";
						}
					}
					if($image == "c" && file_exists("../$get_current_food_image_path/$get_current_food_image_c") && $get_current_food_image_c != ""){
						
						if(file_exists("../$get_current_food_image_path/$get_current_food_image_d")){
							echo"<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;action=show_image&amp;image=d&amp;l=$l#image\"><img src=\"../$get_current_food_image_path/$get_current_food_image_c\" alt=\"$get_current_food_image_c\" /></a>";
						}
						else{
							echo"<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;l=$l#image\"><img src=\"../$get_current_food_image_path/$get_current_food_image_c\" alt=\"$get_current_food_image_c\" /></a>";
						}
					}
					if($image == "d" && file_exists("../$get_current_food_image_path/$get_current_food_image_d") && $get_current_food_image_d != ""){
				
						echo"<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;l=$l\"><img src=\"../$get_current_food_image_path/$get_current_food_image_d\" alt=\"$get_current_food_image_d\" /></a>";
				
					}
					echo"<br />";

				}

				if($get_current_food_image_a != ""  && $get_current_restriction_show_image_a == 1){
					// Thumb medium
					if(!(file_exists("../$get_current_food_image_path/$get_current_food_thumb_a_medium")) OR $get_current_food_thumb_a_medium == ""){
						$ext = get_extension("$get_current_food_image_a");
						$inp_thumb_name = str_replace(".$ext", "", $get_current_food_image_a);
						$get_current_food_thumb_a_medium = $inp_thumb_name . "_thumb_200x200." . $ext;
						$inp_food_thumb_a_medium_mysql = quote_smart($link, $get_current_food_thumb_a_medium);
						$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb_a_medium=$inp_food_thumb_a_medium_mysql WHERE food_id=$get_current_food_id") or die(mysqli_error($link));
						resize_crop_image(200, 200, "$root/$get_current_food_image_path/$get_current_food_image_a", "$root/$get_current_food_image_path/$get_current_food_thumb_a_medium");
					}
					echo"<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;action=show_image&amp;image=a&amp;l=$l#image\" style=\"margin-right: 11px;\"><img src=\"$root/$get_current_food_image_path/$get_current_food_thumb_a_medium\" alt=\"$get_current_food_thumb_a_medium\" /></a>";
				}

				if($get_current_food_image_b != ""  && $get_current_restriction_show_image_b == 1){
					// Thumb medium
					if(!(file_exists("../$get_current_food_image_path/$get_current_food_thumb_b_medium")) OR $get_current_food_thumb_b_medium == ""){
						$ext = get_extension("$get_current_food_image_b");
						$inp_thumb_name = str_replace(".$ext", "", $get_current_food_image_b);
						$get_current_food_thumb_b_medium = $inp_thumb_name . "_thumb_200x200." . $ext;
						$inp_food_thumb_b_medium_mysql = quote_smart($link, $get_current_food_thumb_b_medium);
						$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb_b_medium=$inp_food_thumb_b_medium_mysql WHERE food_id=$get_current_food_id") or die(mysqli_error($link));
				
						resize_crop_image(200, 200, "$root/$get_current_food_image_path/$get_current_food_image_b", "$root/$get_current_food_image_path/$get_current_food_thumb_b_medium");
					}
					echo"<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;action=show_image&amp;image=b&amp;l=$l#image\" style=\"margin-right: 11px;\"><img src=\"$root/$get_current_food_image_path/$get_current_food_thumb_b_medium\" alt=\"$get_current_food_thumb_b_medium\" /></a>";
				}


				if($get_current_food_image_c != ""  && $get_current_restriction_show_image_c == 1){
					// Thumb medium
					if(!(file_exists("../$get_current_food_image_path/$get_current_food_thumb_c_medium")) OR $get_current_food_thumb_c_medium == ""){
						$ext = get_extension("$get_current_food_image_c");
						$inp_thumb_name = str_replace(".$ext", "", $get_current_food_image_c);
						$get_current_food_thumb_c_medium = $inp_thumb_name . "_thumb_200x200." . $ext;
						$inp_food_thumb_c_medium_mysql = quote_smart($link, $get_current_food_thumb_c_medium);
						$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb_c_medium=$inp_food_thumb_c_medium_mysql WHERE food_id=$get_current_food_id") or die(mysqli_error($link));
				
						resize_crop_image(200, 200, "$root/$get_current_food_image_path/$get_current_food_image_c", "$root/$get_current_food_image_path/$get_current_food_thumb_c_medium");
					}

					echo"<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;action=show_image&amp;image=c&amp;l=$l#image\" style=\"margin-right: 11px;\"><img src=\"$root/$get_current_food_image_path/$get_current_food_thumb_c_medium\" alt=\"$get_current_food_thumb_c_medium\" /></a>";
	
				}
				if($get_current_food_image_d != ""  && $get_current_restriction_show_image_d == 1){
					if(!(file_exists("../$get_current_food_image_path/$get_current_food_thumb_d_medium")) OR $get_current_food_thumb_d_medium == ""){
						$ext = get_extension("$get_current_food_image_d");
						$inp_thumb_name = str_replace(".$ext", "", $get_current_food_image_d);
						$get_current_food_thumb_d_medium = $inp_thumb_name . "_thumb_200x200." . $ext;
						$inp_food_thumb_d_medium_mysql = quote_smart($link, $get_current_food_thumb_d_medium);
						$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb_d_medium=$inp_food_thumb_d_medium_mysql WHERE food_id=$get_current_food_id") or die(mysqli_error($link));
				
						resize_crop_image(200, 200, "$root/$get_current_food_image_path/$get_current_food_image_d", "$root/$get_current_food_image_path/$get_current_food_thumb_d_medium");
					}

					echo"<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;action=show_image&amp;image=d&amp;l=$l#image\" style=\"margin-right: 11px;\"><img src=\"$root/$get_current_food_image_path/$get_current_food_thumb_d_medium\" alt=\"$get_current_food_thumb_d_medium\" /></a>";
			
				}
				echo"
				</p>
			<!-- //Images -->
	
			<!-- Favorite, edit, delete -->
				<div class=\"clear\"></div>
				<div style=\"float: left;padding: 1px 0px 0px 0px;\">
					<p style=\"margin:0;padding:0;\">
					$l_published_by <a href=\"$root/users/view_profile.php?user_id=$get_current_food_user_id&amp;l=$l\">$get_current_food_author_user_alias</a><br />
					</p>
				</div>
				<div style=\"float: left;padding: 3px 0px 0px 16px;\">
			
					<p style=\"margin: 0px;padding:0\">";
						if(isset($_SESSION['user_id'])){

							// My user
							$my_user_id = $_SESSION['user_id'];
							$my_user_id_mysql = quote_smart($link, $my_user_id);
							$q = "SELECT user_id, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
							$r = mysqli_query($link, $q);
							$rowb = mysqli_fetch_row($r);
							list($get_my_user_id, $get_my_user_rank) = $rowb;

							// Favorite
							$q = "SELECT food_favorite_id FROM $t_food_favorites WHERE food_favorite_food_id=$get_current_food_id AND food_favorite_user_id=$my_user_id_mysql";
							$r = mysqli_query($link, $q);
							$rowb = mysqli_fetch_row($r);
							list($get_current_food_favorite_id) = $rowb;
							if($get_current_food_favorite_id == ""){
								echo"
								<a href=\"favorite_food_add.php?main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;l=$l&amp;process=1\"><img src=\"_gfx/icons/heart_grey.png\" alt=\"heart_grey.png\" /></a>
								";
							}
							else{
								echo"
								<a href=\"favorite_food_remove.php?main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;l=$l&amp;process=1\"><img src=\"_gfx/icons/heart_fill.png\" alt=\"heart_fill.png\" /></a>
								";
							}

							// edit, delte
							if($get_my_user_id == "$get_current_food_user_id" OR $get_my_user_rank == "admin" OR $get_my_user_rank == "moderator"){
								echo"
								<a href=\"edit_food.php?main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;l=$l\"><img src=\"_gfx/icons/edit.png\" alt=\"ic_mode_edit_black_18dp_1x.png\" /></a>
								<a href=\"delete_food.php?main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;l=$l\"><img src=\"_gfx/icons/delete.png\" alt=\"ic_delete_black_18dp_1x.png\" /></a>
								";
							}
						}
						else{
							echo"
							<a href=\"$root/users/index.php?page=login&amp;l=$l&amp;refer=../food/favorite_food_add.php?recipe_id=$get_current_food_id&amp;l=$l\"><img src=\"_gfx/icons/heart_grey.png\" alt=\"heart_grey.png\" /></a>
							";
						}
					echo"
					</p>
				</div>
				<div class=\"clear\"></div>
				<p style=\"margin-top: 0px;padding-top:0\">
				<img src=\"_gfx/icons/eye_dark_grey.png\" alt=\"eye.png\" /> $get_current_food_unique_hits $l_unique_views_lovercase
				</p>
			<!-- //Favorite, edit, delete -->
		
			<!-- About -->
				<p>
				$get_current_food_description

				<!-- Tags -->";

					$query = "SELECT tag_id, tag_title FROM $t_food_index_tags WHERE tag_food_id=$get_current_food_id ORDER BY tag_id ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_tag_id, $get_tag_title) = $row;
						echo"
						<a href=\"view_tag.php?tag=$get_tag_title&amp;l=$l\">#$get_tag_title</a>
						";
					}
					echo"
				<!-- //Tags -->

				</p>
			<!-- //About -->


			<!-- Money link -->";

				$query = "SELECT ad_id, ad_text FROM $t_food_index_ads WHERE ad_food_id='$get_current_food_id'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_ad_id, $get_ad_text) = $row;
				if($get_ad_id != ""){
					echo"
					$get_ad_text
					<div class=\"clear\"></div>
					";
				}
				echo"
			<!-- //Money link -->
	
			<!-- Numbers -->
				<a id=\"numbers\"></a>
				
				<div style=\"float: left;\">
					<h2>$l_numbers</h2>
				</div>
				<div style=\"float: left;padding-left: 10px;\">
					<p>
					<a href=\"user_adapted_view.php?set=system&amp;value=all&amp;process=1&amp;referer=view_food&amp;main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;l=$l\""; if($get_current_view_system == "all"){ echo" style=\"font-weight:bold;\""; } echo">$l_all</a>
					&middot;
					<a href=\"user_adapted_view.php?set=system&amp;value=metric&amp;process=1&amp;referer=view_food&amp;main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;l=$l\""; if($get_current_view_system == "metric"){ echo" style=\"font-weight:bold;\""; } echo">$l_metric</a>
					&middot;
					<a href=\"user_adapted_view.php?set=system&amp;value=us&amp;process=1&amp;referer=view_food&amp;main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;l=$l\""; if($get_current_view_system == "us"){ echo" style=\"font-weight:bold;\""; } echo">$l_us</a>
					</p>
				</div>
				<div class=\"clear\"></div>
				";


				echo"
				<table class=\"hor-zebra\" style=\"width: auto;min-width: 0;display: table;\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
				   </th>";
				if($get_current_view_system == "all" OR $get_current_view_system == "metric"){
					echo"
					   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 8px;vertical-align: bottom;\">
						<span>$l_per_100</span>
		 			  </th>
					   <th scope=\"col\" style=\"text-align: center;padding: 6px 8px 6px 8px;\">
						<span>$l_serving<br />$get_current_food_serving_size_metric $get_current_food_serving_size_measurement_metric ($get_current_food_serving_size_pcs $get_current_food_serving_size_pcs_measurement)</span>
					   </th>
					";
				}
				if($get_current_view_system == "all" OR $get_current_view_system == "us"){
					echo"
					  <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 8px;vertical-align: bottom;\">
						<span>$l_per_8 $get_current_food_net_content_measurement_us</span>
		 			   </th>
					   <th scope=\"col\" style=\"text-align: center;padding: 6px 8px 6px 8px;\">
						<span>$l_serving<br />$get_current_food_serving_size_us $get_current_food_serving_size_measurement_us ($get_current_food_serving_size_pcs $get_current_food_serving_size_pcs_measurement)</span>
					   </th>
					";
				}
				if($get_current_food_serving_size_pcs != "1"){
					echo"
					   <th scope=\"col\" style=\"text-align: center;padding: 6px 8px 6px 8px;\">
						<span>$l_net_content<br />$get_current_food_net_content_metric $get_current_food_net_content_measurement_metric (1 $l_pcs_lowercase)</span>
					   </th>
					";
				}
				echo"
				   <th scope=\"col\" style=\"text-align: center;padding: 6px 8px 6px 8px;\" class=\"current_sub_category_calories_med\">
					<span>$l_median_for<br />
					$get_current_sub_category_translation_value</span>
				   </th>
				   <th scope=\"col\" style=\"text-align: center;padding: 6px 8px 6px 8px;\" class=\"current_sub_category_calories_diff\">
					<span>$l_diff</span>
				   </th>
				  </tr>
				 </thead>
				 <tbody>
				  <tr>
				   <td style=\"padding: 8px 4px 6px 8px;\">
					<span>$l_calories</span>
				   </td>";
				if($get_current_view_system == "all" OR $get_current_view_system == "metric"){
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_energy_metric</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_energy_calculated_metric</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_med\">
						<span>$get_current_sub_category_calories_med_metric</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_diff\">";
						$energy_diff_med = round($get_current_food_energy_metric-$get_current_sub_category_calories_med_metric, 0);

						if($energy_diff_med > 0){
							echo"<span style=\"color: red;\">$energy_diff_med</span>";
						}
						elseif($energy_diff_med < 0){
							echo"<span style=\"color: green;\">$energy_diff_med</span>";
						}
						else{
							echo"<span>$energy_diff_med_metric</span>";
							// $product_score_description = $product_score_description . " $l_have_an_ok_amount_of_calories_lowercase, ";
						}
						echo"
					   </td>
					";
				}
				if($get_current_view_system == "all" OR $get_current_view_system == "us"){
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_energy_us</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_energy_calculated_us</span>
					   </td>
					";
				}
				if($get_current_food_serving_size_pcs != "1"){
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_energy_net_content</span>
					   </th>
					";
				}
				echo"
				  </tr>

				  <tr>
				   <td style=\"padding: 8px 4px 6px 8px;\">
					<span>$l_fat<br />
					$l_dash_saturated_fat<br />
					$l_dash_monounsaturated_fat<br />
					$l_dash_polyunsaturated_fat</span>
				   </td>";
				if($get_current_view_system == "all" OR $get_current_view_system == "metric"){
					echo"
		 			  <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>
						$get_current_food_fat_metric<br />
						$get_current_food_saturated_fat_metric<br />
						$get_current_food_monounsaturated_fat_metric<br />
						$get_current_food_polyunsaturated_fat_metric
						</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>
						$get_current_food_fat_calculated_metric<br />
						$get_current_food_saturated_fat_calculated_metric<br />
						$get_current_food_monounsaturated_fat_calculated_metric<br />
						$get_current_food_polyunsaturated_fat_calculated_metric
						</span>
					   </td>

					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_med\">
						<span>$get_current_sub_category_fat_med_metric<br />
						$get_current_sub_category_saturated_fat_med_metric<br />
						$get_current_sub_category_monounsaturated_fat_med_metric<br />
						$get_current_sub_category_polyunsaturated_fat_med_metric</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_diff\">";
						$fat_diff_med = round($get_current_food_fat_metric-$get_current_sub_category_fat_med_metric, 0);
						$saturated_fat_diff_med = round($get_current_food_saturated_fat_metric-$get_current_sub_category_saturated_fat_med_metric, 0);
						$monounsaturated_fat_diff_med = round($get_current_food_monounsaturated_fat_metric-$get_current_sub_category_monounsaturated_fat_med_metric, 0);
						$polyunsaturated_fat_diff_med = round($get_current_food_polyunsaturated_fat_metric-$get_current_sub_category_polyunsaturated_fat_med_metric, 0);

						if($fat_diff_med > 0){
							echo"<span style=\"color: red;\">$fat_diff_med<br /></span>";
						}
						elseif($fat_diff_med < 0){
							echo"<span style=\"color: green;\">$fat_diff_med<br /></span>";
						}
						else{
							echo"<span>$fat_diff_med<br /></span>";
						}

						if($saturated_fat_diff_med > 0){
							echo"<span style=\"color: red;\">$saturated_fat_diff_med<br /></span>";
						}
						elseif($saturated_fat_diff_med < 0){
							echo"<span style=\"color: green;\">$saturated_fat_diff_med<br /></span>";
						}
						else{
							echo"<span>$saturated_fat_diff_med<br /></span>";
						}

						if($monounsaturated_fat_diff_med > 0){
							echo"<span style=\"color: red;\">$monounsaturated_fat_diff_med<br /></span>";
						}
						elseif($saturated_fat_diff_med < 0){
							echo"<span style=\"color: green;\">$monounsaturated_fat_diff_med<br /></span>";
						}
						else{
							echo"<span>$monounsaturated_fat_diff_med<br /></span>";
						}

						if($polyunsaturated_fat_diff_med > 0){
							echo"<span style=\"color: red;\">$polyunsaturated_fat_diff_med<br /></span>";
						}
						elseif($polyunsaturated_fat_diff_med < 0){
							echo"<span style=\"color: green;\">$polyunsaturated_fat_diff_med<br /></span>";
						}
						else{
							echo"<span>$polyunsaturated_fat_diff_med<br /></span>";
						}
						echo"
					   </td>
					";
				}
				if($get_current_view_system == "all" OR $get_current_view_system == "us"){
					echo"
		 			  <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>
						$get_current_food_fat_us<br />
						$get_current_food_saturated_fat_us<br />
						$get_current_food_monounsaturated_fat_us<br />
						$get_current_food_polyunsaturated_fat_us
						</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_fat_calculated_us<br />
						$get_current_food_saturated_fat_calculated_us<br />
						$get_current_food_monounsaturated_fat_calculated_us<br />
						$get_current_food_polyunsaturated_fat_calculated_us
						</span>
					   </td>";
				}
				if($get_current_food_serving_size_pcs != "1"){
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_fat_net_content<br />
						$get_current_food_saturated_fat_net_content<br />
						$get_current_food_monounsaturated_fat_net_content<br />
						$get_current_food_polyunsaturated_fat_net_content
						</span>
					   </th>
					";
				}
				echo"
				  </tr>

				  <tr>
				   <td style=\"padding: 8px 4px 6px 8px;\">
					<span>$l_carbs<br /></span>
					<span>$l_dash_of_which_sugars</span>
				   </td>";
				if($get_current_view_system == "all" OR $get_current_view_system == "metric"){
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_carbohydrates_metric<br /></span>
						<span>$get_current_food_carbohydrates_of_which_sugars_metric</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_carbohydrates_calculated_metric<br /></span>
						<span>$get_current_food_carbohydrates_of_which_sugars_calculated_metric</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_med\">
						<span>$get_current_sub_category_carb_med_metric<br /></span>
						<span>$get_current_sub_category_carb_of_which_sugars_med_metric</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_diff\">";
						$carbohydrate_diff_med = round($get_current_food_carbohydrates_metric-$get_current_sub_category_carb_med_metric, 0);
			
						if($carbohydrate_diff_med > 0){
							echo"<span style=\"color: red;\">$carbohydrate_diff_med</span>";
						}
						elseif($carbohydrate_diff_med < 0){
							echo"<span style=\"color: green;\">$carbohydrate_diff_med</span>";
						}
						else{
							echo"<span>$carbohydrate_diff_med</span>";
						}
						// Sugar
						$carbohydrates_of_which_sugars_diff_med = round($get_current_food_carbohydrates_of_which_sugars_metric-$get_current_sub_category_carb_of_which_sugars_med_metric, 0);
			
						if($carbohydrates_of_which_sugars_diff_med > 0){
							echo"<span style=\"color: red;\"><br />$carbohydrates_of_which_sugars_diff_med</span>";
						}
						elseif($carbohydrates_of_which_sugars_diff_med < 0){
							echo"<span style=\"color: green;\"><br />$carbohydrates_of_which_sugars_diff_med</span>";
						}
						else{
							echo"<span><br />$carbohydrates_of_which_sugars_diff_med</span>";
						}
						echo"
					   </td>
					";
				}
				if($get_current_view_system == "all" OR $get_current_view_system == "us"){
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_carbohydrates_us<br /></span>
						<span>$get_current_food_carbohydrates_of_which_sugars_us</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_carbohydrates_calculated_us<br /></span>
						<span>$get_current_food_carbohydrates_of_which_sugars_calculated_us</span>
					   </td>
					";
				}
				if($get_current_food_serving_size_pcs != "1"){
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_carbohydrates_net_content<br />
						$get_current_food_carbohydrates_of_which_sugars_net_content
						</span>
					   </th>
					";
				}
				echo"
				  </tr>



				  <tr>
				   <td style=\"padding: 8px 4px 6px 8px;\">
					<span>$l_dietary_fiber<br /></span>
				   </td>";
				if($get_current_view_system == "all" OR $get_current_view_system == "metric"){
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_dietary_fiber_metric<br /></span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_dietary_fiber_calculated_metric<br /></span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_med\">
						<span>$get_current_sub_category_dietary_fiber_med_metric</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_diff\">";
						// Fiber
						$dietary_fiber_diff_med = round($get_current_food_dietary_fiber_metric-$get_current_sub_category_dietary_fiber_med_metric, 0);
			
						if($dietary_fiber_diff_med > 0){
							echo"<span style=\"color: red;\"><br />$dietary_fiber_diff_med</span>";
						}
						elseif($dietary_fiber_diff_med < 0){
							echo"<span style=\"color: green;\"><br />$dietary_fiber_diff_med</span>";
						}
						else{
							echo"<span><br />$dietary_fiber_diff_med</span>";
						}
						echo"
					   </td>
					";
				}
				if($get_current_view_system == "all" OR $get_current_view_system == "us"){
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_dietary_fiber_us<br /></span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_dietary_fiber_calculated_us<br /></span>
					   </td>
					";
				}
				if($get_current_food_serving_size_pcs != "1"){
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_dietary_fiber_net_content
						</span>
					   </th>
					";
				}
				echo"
				  </tr>

				  <tr>
				   <td style=\"padding: 8px 4px 6px 8px;\">
					<span>$l_proteins</span>
				   </td>";
				if($get_current_view_system == "all" OR $get_current_view_system == "metric"){
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_proteins_metric</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_proteins_calculated_metric</span>
		 			  </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_med\">
						<span>$get_current_sub_category_proteins_med_metric</span>
					   </td>
				 	  <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_diff\">";
						$proteins_diff_med = round($get_current_food_proteins_metric-$get_current_sub_category_proteins_med_metric, 0);
						$proteins_diff_med = $proteins_diff_med*-1;
			
						if($proteins_diff_med < 0){
							echo"<span style=\"color: green;\">$proteins_diff_med</span>";
						}
						elseif($proteins_diff_med > 0){
							echo"<span style=\"color: red;\">$proteins_diff_med</span>";
						}
						else{
							echo"<span>$proteins_diff_med*</span>";
						}
						echo"
					   </td>
					";
				}
				if($get_current_view_system == "all" OR $get_current_view_system == "us"){
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_proteins_us</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_proteins_calculated_us</span>
		 			  </td>
					";
				}
				if($get_current_food_serving_size_pcs != "1"){
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_proteins_net_content
						</span>
					   </th>
					";
				}
				echo"
				  </tr>

				  <tr>
				   <td style=\"padding: 8px 4px 6px 8px;\">
					<span>$l_salt_in_gram<br />
					$l_dash_of_which_sodium_in_mg</span>
				   </td>";
				if($get_current_view_system == "all" OR $get_current_view_system == "metric"){
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_salt_metric<br />
						$get_current_food_sodium_metric</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_salt_calculated_metric<br />
						$get_current_food_sodium_calculated_metric</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_med\">
						<span>$get_current_sub_category_salt_med_metric</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_diff\">";
						$salt_diff_med = round($get_current_food_salt_metric-$get_current_sub_category_salt_med_metric, 0);
						$sodium_diff_med = round($get_current_food_sodium_metric-$get_current_sub_category_sodium_med_metric, 0);
				
						if($salt_diff_med > 0){
							echo"<span style=\"color: red;\">$salt_diff_med<br /></span>";
						}
						elseif($salt_diff_med < 0){
							echo"<span style=\"color: green;\">$salt_diff_med<br /></span>";
						}
						else{
							echo"<span>$salt_diff_med<br /></span>";
						}
						if($sodium_diff_med > 0){
							echo"<span style=\"color: red;\">$sodium_diff_med</span>";
						}
						elseif($sodium_diff_med < 0){
							echo"<span style=\"color: green;\">$sodium_diff_med</span>";
						}
						else{
							echo"<span>$sodium_diff_med</span>";
						}
						echo"
					   </td>
					";
				}
				if($get_current_view_system == "all" OR $get_current_view_system == "us"){
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_salt_us<br />
						$get_current_food_sodium_us</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_salt_calculated_us<br />
						$get_current_food_sodium_calculated_us</span>
					   </td>
					";
				}
				if($get_current_food_serving_size_pcs != "1"){
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_salt_net_content<br />
						$get_current_food_sodium_net_content</span>
					   </th>
					";
				}
				echo"
				  </tr>

				  <tr>
				   <td style=\"padding: 8px 4px 6px 8px;\">
					<span>$l_cholesterol_in_mg</span>
				   </td>";
				if($get_current_view_system == "all" OR $get_current_view_system == "metric"){
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_cholesterol_metric</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_cholesterol_calculated_metric</span>
		 			  </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_med\">
						<span>$get_current_sub_category_cholesterol_med_metric</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_diff\">";
						$cholesterol_diff_med = round($get_current_food_cholesterol_metric-$get_current_sub_category_cholesterol_med_metric, 0);
				
						if($cholesterol_diff_med > 0){
							echo"<span style=\"color: red;\">$cholesterol_diff_med<br /></span>";
						}
						elseif($cholesterol_diff_med < 0){
							echo"<span style=\"color: green;\">$cholesterol_diff_med<br /></span>";
						}
						else{
							echo"<span>$cholesterol_diff_med<br /></span>";
						}
						echo"
					   </td>
					";
				}
				if($get_current_view_system == "all" OR $get_current_view_system == "us"){
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_cholesterol_us</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_cholesterol_calculated_us</span>
		 			  </td>
					";
				}
				if($get_current_food_serving_size_pcs != "1"){
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span>$get_current_food_cholesterol_net_content</span>
					   </th>
					";
				}
				echo"
				 </tr>

				</table>

				<script>
				\$(document).ready(function(){
					\$(\".a_show_score\").click(function () {
						\$(\".current_sub_category_calories_med\").toggle();
						\$(\".current_sub_category_calories_diff\").toggle();
						\$(\".protein_diff\").toggle();
					});
				});
				</script>

				<p>
				<a href=\"#numbers\" class=\"a_show_score\">$l_score:</a> ";

				
				if($get_current_view_system == "all" OR $get_current_view_system == "metric"){
					$score_number = $energy_diff_med+$fat_diff_med+$saturated_fat_diff_med+$monounsaturated_fat_diff_med+$polyunsaturated_fat_diff_med+$carbohydrate_diff_med+$carbohydrates_of_which_sugars_diff_med+$dietary_fiber_diff_med+$proteins_diff_med+$salt_diff_med; // +$sodium_diff_med+$cholesterol_diff_med
	 				if($get_current_food_score != $score_number){
						$result = mysqli_query($link, "UPDATE $t_food_index SET food_score='$score_number' WHERE food_id='$get_current_food_id'") or die(mysqli_error($link));
					}
				}
				else{

				}

				if($get_current_restriction_show_smileys == "1"){
					if($get_current_food_score > 0){
						echo"
						<em style=\"color: red;\">$get_current_food_score</em>
						<img src=\"_gfx/smiley_sad.png\" alt=\"smiley_sad.gif\" style=\"padding:0px 0px 0px 4px;\"  />";
					}
					elseif($get_current_food_score < 0){
						echo"
						<em style=\"color: green;\">$get_current_food_score</em>
						<img src=\"_gfx/smiley_smile.png\" alt=\"smiley_smile.png\" style=\"padding:0px 0px 0px 4px;\" />";
					}
					else{
						echo"
						<em>$get_current_food_score</em>
						<img src=\"_gfx/smiley_confused.png\" alt=\"smiley_confused.png\" style=\"padding:0px 0px 0px 4px;\" />";
					}
				}
				echo"
				</p>
				<p class=\"protein_diff\">*$l_protein_diff_is_multiplied_with_minus_one_to_get_correct_calculation</p>
			<!-- //Numbers -->


			<!-- Info -->
				<h2>$l_info</h2>

		<table class=\"hor-zebra\" style=\"width: auto;min-width: 0;display: table;\">
		 <tbody>
		  <tr>
		   <td style=\"padding: 8px 4px 6px 8px;\">
			<span><b>$l_manufacturer:</b></span>
		   </td>
		   <td style=\"padding: 0px 4px 0px 4px;\">
			<span><a href=\"search.php?manufacturer_name=$get_current_food_manufacturer_name&amp;l=$l\">$get_current_food_manufacturer_name</a></span>
		   </td>
		  </tr>
		  <tr>
		   <td style=\"padding: 8px 4px 6px 8px;\">
			<span><b>$l_barcode:</b></span>
		   </td>
		   <td style=\"padding: 0px 4px 0px 4px;\">
			<span><a href=\"search.php?barcode=$get_current_food_barcode&amp;l=$l\">$get_current_food_barcode</a></span>
		   </td>
		  </tr>
		  <tr>
		   <td style=\"padding: 8px 4px 6px 8px;\">
			<span><b>$l_net_content:</b></span>
		   </td>
		   <td style=\"padding: 0px 4px 0px 4px;\">
			<span>$get_current_food_net_content_metric $get_current_food_net_content_measurement_metric</span>
		   </td>
		  </tr>
		  <tr>
		   <td style=\"padding: 8px 4px 6px 20px;\">
			<span><b>$l_us:</b></span>
		   </td>
		   <td style=\"padding: 0px 4px 0px 4px;\">
			<span>$get_current_food_net_content_us $get_current_food_net_content_measurement_us</span>
		   </td>
		  </tr>
		  <tr>
		   <td style=\"padding: 8px 4px 6px 8px;\">
			<span><b>$l_stores:</b></span>
		   </td>
		   <td style=\"padding: 0px 4px 0px 4px;\">
			<span>";
			
			// Count stores
			$query = "SELECT count(food_store_id) FROM $t_food_index_stores  WHERE food_store_food_id=$get_current_food_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_count_food_stores) = $row;
	
			$x = 0;
			$count_minus_two = $get_count_food_stores-2;

			$query = "SELECT food_store_id, food_store_store_id, food_store_store_name FROM $t_food_index_stores WHERE food_store_food_id=$get_current_food_id ORDER BY food_store_store_name ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_current_food_store_id, $get_current_food_store_store_id, $get_current_food_store_store_name) = $row;
				echo"
				<a href=\"search.php?q=&amp;barcode=&amp;manufacturer_name=&amp;store_id=$get_current_food_store_store_id&amp;order_by=food_score&amp;order_method=asc&amp;l=$l\">$get_current_food_store_store_name</a>";
				
				// Check if I have prices
				$query_p = "SELECT food_price_id, food_price_food_id, food_price_store_id, food_price_store_name, food_price_price, food_price_currency, food_price_offer, food_price_offer_valid_from, food_price_offer_valid_to, food_price_user_id, food_price_user_ip, food_price_added_datetime, food_price_added_datetime_print, food_price_updated, food_price_updated_print, food_price_reported, food_price_reported_checked FROM $t_food_index_prices WHERE food_price_food_id=$get_current_food_id AND food_price_store_id=$get_current_food_store_store_id";
				$result_p = mysqli_query($link, $query_p);
				$row_p = mysqli_fetch_row($result_p);
				list($get_current_food_price_id, $get_current_food_price_food_id, $get_current_food_price_store_id, $get_current_food_price_store_name, $get_current_food_price_price, $get_current_food_price_currency, $get_current_food_price_offer, $get_current_food_price_offer_valid_from, $get_current_food_price_offer_valid_to, $get_current_food_price_user_id, $get_current_food_price_user_ip, $get_current_food_price_added_datetime, $get_current_food_price_added_datetime_print, $get_current_food_price_updated, $get_current_food_price_updated_print, $get_current_food_price_reported, $get_current_food_price_reported_checked) = $row_p;
				if($get_current_food_price_id == ""){
					echo"
					
					";
				}
				else{
					echo"
					<span>($get_current_food_price_price)</span>
					";
				}


				if($x < $count_minus_two){
					echo", ";
				}
				elseif($x == $count_minus_two){
					echo" $l_and_lowercase ";
				}

				$x++;
			}
			echo"</span>
		   </td>
		  </tr>
		 </tbody>
		</table>

			<!-- //Info -->

			<!-- Text -->
				$get_current_food_text
			<!-- //Text -->

			<div class=\"clear\" style=\"height: 20px;\"></div>




			";
			// Image warning to admin
			if($get_current_food_image_a == "" OR !(file_exists("../$get_current_food_image_path/$get_current_food_image_a"))){


				// Who is moderator of the week?
				$week = date("W");
				$year = date("Y");

				$query = "SELECT moderator_user_id, moderator_user_email, moderator_user_name FROM $t_users_moderator_of_the_week WHERE moderator_week=$week AND moderator_year=$year";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_moderator_user_id, $get_moderator_user_email, $get_moderator_user_name) = $row;
				if($get_moderator_user_id == ""){
					// Create moderator of the week
					include("$root/_admin/_functions/create_moderator_of_the_week.php");
					
					$query = "SELECT moderator_user_id, moderator_user_email, moderator_user_name FROM $t_users_moderator_of_the_week WHERE moderator_week=$week AND moderator_year=$year";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_moderator_user_id, $get_moderator_user_email, $get_moderator_user_name) = $row;
				}
			

				$missing_file = "$root/_cache/food_missing_img_$get_current_food_id.txt";

				if(!(file_exists("$missing_file"))){
					echo"<div class=\"clear\"></div>
					<div class=\"info\"><p>E-mail sent to admins. Writing to $root/_cache/food_missing_img_$get_current_food_id.txt</p></div>";

					// Mail from
					$host = $_SERVER['HTTP_HOST'];
			
					$view_link = $configSiteURLSav . "/food/view_food.php?food_id=$get_current_food_id";

					$subject = "Food missing image $get_current_food_name at $host";

					$message = "<html>\n";
					$message = $message. "<head>\n";
					$message = $message. "  <title>$subject</title>\n";
					$message = $message. " </head>\n";
					$message = $message. "<body>\n";

					$message = $message . "<p>Hi $get_moderator_user_name,</p>\n\n";
					$message = $message . "<p><b>Summary:</b><br />A food is missing image. Please take a image of the food and upload.</p>\n\n";

					$message = $message . "<p style='padding-bottom:0;margin-bottom:0'><b>Information:</b></p>\n";
					$message = $message . "<table>\n";
					$message = $message . " <tr><td><span>Food ID:</span></td><td><span>$get_current_food_id</span></td></tr>\n";
					$message = $message . " <tr><td><span>Name:</span></td><td><span><a href=\"$view_link\">$get_current_food_name</a></span></td></tr>\n";
					$message = $message . " <tr><td><span>Manufactor:</span></td><td><span>$get_current_food_manufacturer_name</span></td></tr>\n";
					$message = $message . " <tr><td><span>Description</span></td><td><span>$get_current_food_description</span></td></tr>\n";
					$message = $message . " <tr><td><span>Barcode:</span></td><td><span>$get_current_food_barcode</span></td></tr>\n";
					$message = $message . "</table>\n";

					$message = $message . "<p style='padding-bottom:0;margin-bottom:0'><b>Author:</b></p>\n";
					$message = $message . "<table>\n";
					$message = $message . " <tr><td><span>User ID:</span></td><td><span>$get_current_food_user_id</span></td></tr>\n";
					$message = $message . " <tr><td><span>User Name:</span></td><td><span>$get_current_food_author_user_name</span></td></tr>\n";
					$message = $message . " <tr><td><span>Alias:</span></td><td><span>$get_current_food_author_user_alias</span></td></tr>\n";
					$message = $message . " <tr><td><span>E-mail:</span></td><td><span>$get_current_food_author_user_email</span></td></tr>\n";
					$message = $message . "</table>\n";
		
					$message = $message . "<p>\n\n--<br />\nBest regards<br />\n$host</p>";
					$message = $message. "</body>\n";
					$message = $message. "</html>\n";


					$headers[] = 'MIME-Version: 1.0';
					$headers[] = 'Content-type: text/html; charset=utf-8';
					$headers[] = "From: $configFromNameSav <" . $configFromEmailSav . ">";
					mail($get_moderator_user_email, $subject, $message, implode("\r\n", $headers));



					$fh = fopen($missing_file, "w") or die("can not open file");
					fwrite($fh, "-");
					fclose($fh);
				}

			}
		} // process != 1


		// New comment and read comments
		if($process != "1"){
			echo"
			<!-- Ratings -->
				<a id=\"ratings\"></a>

				<!-- Feedback -->
					";
					if(isset($_GET['ft_rating']) && isset($_GET['fm_rating'])){
						$ft_rating = $_GET['ft_rating'];
						$ft_rating = output_html($ft_rating);
						$fm_rating = $_GET['fm_rating'];
						$fm_rating = output_html($fm_rating);
						$fm_rating = str_replace("_", " ", $fm_rating);
						$fm_rating = ucfirst($fm_rating);
						echo"<div class=\"$ft_rating\"><span>$fm_rating</span></div>";
					}
					echo"	
				<!-- //Feedback -->
			";
		}
		include("view_food_include_new_rating.php");
		include("view_food_include_fetch_ratings.php");
		echo"
			<!-- //Ratings -->
		";

	} // can view food
}
/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>