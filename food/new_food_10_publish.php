<?php 
/**
*
* File: food/new_food_10_publish.php
* Version 1.0.0
* Date 23:59 27.11.2017
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

/*- Tables ---------------------------------------------------------------------------- */
include("_tables_food.php");



/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/food/ts_food.php");
include("$root/_admin/_translations/site/$l/food/ts_new_food.php");


/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['mode'])){
	$mode = $_GET['mode'];
	$mode = output_html($mode);
}
else{
	$mode = "";
}

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
	$food_id_mysql = quote_smart($link, $food_id);
}
else{
	$food_id = "";
}




$tabindex = 0;
$l_mysql = quote_smart($link, $l);



// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);



	// Select food
	$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_country, food_net_content_metric, food_net_content_measurement_metric, food_net_content_us, food_net_content_measurement_us, food_net_content_added_measurement, food_serving_size_metric, food_serving_size_measurement_metric, food_serving_size_us, food_serving_size_measurement_us, food_serving_size_added_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy_metric, food_fat_metric, food_saturated_fat_metric, food_monounsaturated_fat_metric, food_polyunsaturated_fat_metric, food_cholesterol_metric, food_carbohydrates_metric, food_carbohydrates_of_which_sugars_metric, food_dietary_fiber_metric, food_proteins_metric, food_salt_metric, food_sodium_metric, food_energy_us, food_fat_us, food_saturated_fat_us, food_monounsaturated_fat_us, food_polyunsaturated_fat_us, food_cholesterol_us, food_carbohydrates_us, food_carbohydrates_of_which_sugars_us, food_dietary_fiber_us, food_proteins_us, food_salt_us, food_sodium_us, food_score, food_energy_calculated_metric, food_fat_calculated_metric, food_saturated_fat_calculated_metric, food_monounsaturated_fat_calculated_metric, food_polyunsaturated_fat_calculated_metric, food_cholesterol_calculated_metric, food_carbohydrates_calculated_metric, food_carbohydrates_of_which_sugars_calculated_metric, food_dietary_fiber_calculated_metric, food_proteins_calculated_metric, food_salt_calculated_metric, food_sodium_calculated_metric, food_energy_calculated_us, food_fat_calculated_us, food_saturated_fat_calculated_us, food_monounsaturated_fat_calculated_us, food_polyunsaturated_fat_calculated_us, food_cholesterol_calculated_us, food_carbohydrates_calculated_us, food_carbohydrates_of_which_sugars_calculated_us, food_dietary_fiber_calculated_us, food_proteins_calculated_us, food_salt_calculated_us, food_sodium_calculated_us, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_thumb_a_medium, food_thumb_a_large, food_image_b, food_thumb_b_small, food_thumb_b_medium, food_thumb_b_large, food_image_c, food_thumb_c_small, food_thumb_c_medium, food_thumb_c_large, food_image_d, food_thumb_d_small, food_thumb_d_medium, food_thumb_d_large, food_image_e, food_thumb_e_small, food_thumb_e_medium, food_thumb_e_large, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_created_date, food_last_viewed, food_age_restriction FROM $t_food_index WHERE food_id=$food_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_food_id, $get_current_food_user_id, $get_current_food_name, $get_current_food_clean_name, $get_current_food_manufacturer_name, $get_current_food_manufacturer_name_and_food_name, $get_current_food_description, $get_current_food_country, $get_current_food_net_content_metric, $get_current_food_net_content_measurement_metric, $get_current_food_net_content_us, $get_current_food_net_content_measurement_us, $get_current_food_net_content_added_measurement, $get_current_food_serving_size_metric, $get_current_food_serving_size_measurement_metric, $get_current_food_serving_size_us, $get_current_food_serving_size_measurement_us, $get_current_food_serving_size_added_measurement, $get_current_food_serving_size_pcs, $get_current_food_serving_size_pcs_measurement, $get_current_food_energy_metric, $get_current_food_fat_metric, $get_current_food_saturated_fat_metric, $get_current_food_monounsaturated_fat_metric, $get_current_food_polyunsaturated_fat_metric, $get_current_food_cholesterol_metric, $get_current_food_carbohydrates_metric, $get_current_food_carbohydrates_of_which_sugars_metric, $get_current_food_dietary_fiber_metric, $get_current_food_proteins_metric, $get_current_food_salt_metric, $get_current_food_sodium_metric, $get_current_food_energy_us, $get_current_food_fat_us, $get_current_food_saturated_fat_us, $get_current_food_monounsaturated_fat_us, $get_current_food_polyunsaturated_fat_us, $get_current_food_cholesterol_us, $get_current_food_carbohydrates_us, $get_current_food_carbohydrates_of_which_sugars_us, $get_current_food_dietary_fiber_us, $get_current_food_proteins_us, $get_current_food_salt_us, $get_current_food_sodium_us, $get_current_food_score, $get_current_food_energy_calculated_metric, $get_current_food_fat_calculated_metric, $get_current_food_saturated_fat_calculated_metric, $get_current_food_monounsaturated_fat_calculated_metric, $get_current_food_polyunsaturated_fat_calculated_metric, $get_current_food_cholesterol_calculated_metric, $get_current_food_carbohydrates_calculated_metric, $get_current_food_carbohydrates_of_which_sugars_calculated_metric, $get_current_food_dietary_fiber_calculated_metric, $get_current_food_proteins_calculated_metric, $get_current_food_salt_calculated_metric, $get_current_food_sodium_calculated_metric, $get_current_food_energy_calculated_us, $get_current_food_fat_calculated_us, $get_current_food_saturated_fat_calculated_us, $get_current_food_monounsaturated_fat_calculated_us, $get_current_food_polyunsaturated_fat_calculated_us, $get_current_food_cholesterol_calculated_us, $get_current_food_carbohydrates_calculated_us, $get_current_food_carbohydrates_of_which_sugars_calculated_us, $get_current_food_dietary_fiber_calculated_us, $get_current_food_proteins_calculated_us, $get_current_food_salt_calculated_us, $get_current_food_sodium_calculated_us, $get_current_food_barcode, $get_current_food_main_category_id, $get_current_food_sub_category_id, $get_current_food_image_path, $get_current_food_image_a, $get_current_food_thumb_a_small, $get_current_food_thumb_a_medium, $get_current_food_thumb_a_large, $get_current_food_image_b, $get_current_food_thumb_b_small, $get_current_food_thumb_b_medium, $get_current_food_thumb_b_large, $get_current_food_image_c, $get_current_food_thumb_c_small, $get_current_food_thumb_c_medium, $get_current_food_thumb_c_large, $get_current_food_image_d, $get_current_food_thumb_d_small, $get_current_food_thumb_d_medium, $get_current_food_thumb_d_large, $get_current_food_image_e, $get_current_food_thumb_e_small, $get_current_food_thumb_e_medium, $get_current_food_thumb_e_large, $get_current_food_last_used, $get_current_food_language, $get_current_food_synchronized, $get_current_food_accepted_as_master, $get_current_food_notes, $get_current_food_unique_hits, $get_current_food_unique_hits_ip_block, $get_current_food_comments, $get_current_food_likes, $get_current_food_dislikes, $get_current_food_likes_ip_block, $get_current_food_user_ip, $get_current_food_created_date, $get_current_food_last_viewed, $get_current_food_age_restriction) = $row;

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
		$website_title = "$l_food - $l_new_food - $get_current_food_name $get_current_food_manufacturer_name";
		if(file_exists("./favicon.ico")){ $root = "."; }
		elseif(file_exists("../favicon.ico")){ $root = ".."; }
		elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
		elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
		include("$root/_webdesign/header.php");

		/*- Content ---------------------------------------------------------------------------------- */



		// Add to feed
		// Feed Category 
		$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$get_current_food_sub_category_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_sub_category_id, $get_current_sub_category_user_id, $get_current_sub_category_name, $get_current_sub_category_parent_id) = $row;

		$query_t = "SELECT category_translation_id, category_id, category_translation_language, category_translation_value, category_translation_no_food, category_translation_last_updated, category_stats_last_updated_year, category_calories_min_metric, category_calories_med_metric, category_calories_max_metric, category_fat_min_metric, category_fat_med_metric, category_fat_max_metric, category_saturated_fat_min_metric, category_saturated_fat_med_metric, category_saturated_fat_max_metric, category_monounsaturated_fat_min_metric, category_monounsaturated_fat_med_metric, category_monounsaturated_fat_max_metric, category_polyunsaturated_fat_min_metric, category_polyunsaturated_fat_med_metric, category_polyunsaturated_fat_max_metric, category_cholesterol_min_metric, category_cholesterol_med_metric, category_cholesterol_max_metric, category_carb_min_metric, category_carb_med_metric, category_carb_max_metric, category_carb_of_which_sugars_min_metric, category_carb_of_which_sugars_med_metric, category_carb_of_which_sugars_max_metric, category_dietary_fiber_min_metric, category_dietary_fiber_med_metric, category_dietary_fiber_max_metric, category_proteins_min_metric, category_proteins_med_metric, category_proteins_max_metric, category_salt_min_metric, category_salt_med_metric, category_salt_max_metric, category_sodium_min_metric, category_sodium_med_metric, category_sodium_max_metric, category_calories_min_us, category_calories_med_us, category_calories_max_us, category_fat_min_us, category_fat_med_us, category_fat_max_us, category_saturated_fat_min_us, category_saturated_fat_med_us, category_saturated_fat_max_us, category_monounsaturated_fat_min_us, category_monounsaturated_fat_med_us, category_monounsaturated_fat_max_us, category_polyunsaturated_fat_min_us, category_polyunsaturated_fat_med_us, category_polyunsaturated_fat_max_us, category_cholesterol_min_us, category_cholesterol_med_us, category_cholesterol_max_us, category_carb_min_us, category_carb_med_us, category_carb_max_us, category_carb_of_which_sugars_min_us, category_carb_of_which_sugars_med_us, category_carb_of_which_sugars_max_us, category_dietary_fiber_min_us, category_dietary_fiber_med_us, category_dietary_fiber_max_us, category_proteins_min_us, category_proteins_med_us, category_proteins_max_us, category_salt_min_us, category_salt_med_us, category_salt_max_us, category_sodium_min_us, category_sodium_med_us, category_sodium_max_us FROM $t_food_categories_translations WHERE category_id=$get_current_sub_category_id AND category_translation_language=$l_mysql";
		$result_t = mysqli_query($link, $query_t);
		$row_t = mysqli_fetch_row($result_t);
		list($get_current_sub_category_translation_id, $get_current_sub_category_id, $get_current_sub_category_translation_language, $get_current_sub_category_translation_value, $get_current_sub_category_translation_no_food, $get_current_sub_category_translation_last_updated, $get_current_sub_category_stats_last_updated_year, $get_current_sub_category_calories_min_metric, $get_current_sub_category_calories_med_metric, $get_current_sub_category_calories_max_metric, $get_current_sub_category_fat_min_metric, $get_current_sub_category_fat_med_metric, $get_current_sub_category_fat_max_metric, $get_current_sub_category_saturated_fat_min_metric, $get_current_sub_category_saturated_fat_med_metric, $get_current_sub_category_saturated_fat_max_metric, $get_current_sub_category_monounsaturated_fat_min_metric, $get_current_sub_category_monounsaturated_fat_med_metric, $get_current_sub_category_monounsaturated_fat_max_metric, $get_current_sub_category_polyunsaturated_fat_min_metric, $get_current_sub_category_polyunsaturated_fat_med_metric, $get_current_sub_category_polyunsaturated_fat_max_metric, $get_current_sub_category_cholesterol_min_metric, $get_current_sub_category_cholesterol_med_metric, $get_current_sub_category_cholesterol_max_metric, $get_current_sub_category_carb_min_metric, $get_current_sub_category_carb_med_metric, $get_current_sub_category_carb_max_metric, $get_current_sub_category_carb_of_which_sugars_min_metric, $get_current_sub_category_carb_of_which_sugars_med_metric, $get_current_sub_category_carb_of_which_sugars_max_metric, $get_current_sub_category_dietary_fiber_min_metric, $get_current_sub_category_dietary_fiber_med_metric, $get_current_sub_category_dietary_fiber_max_metric, $get_current_sub_category_proteins_min_metric, $get_current_sub_category_proteins_med_metric, $get_current_sub_category_proteins_max_metric, $get_current_sub_category_salt_min_metric, $get_current_sub_category_salt_med_metric, $get_current_sub_category_salt_max_metric, $get_current_sub_category_sodium_min_metric, $get_current_sub_category_sodium_med_metric, $get_current_sub_category_sodium_max_metric, $get_current_sub_category_calories_min_us, $get_current_sub_category_calories_med_us, $get_current_sub_category_calories_max_us, $get_current_sub_category_fat_min_us, $get_current_sub_category_fat_med_us, $get_current_sub_category_fat_max_us, $get_current_sub_category_saturated_fat_min_us, $get_current_sub_category_saturated_fat_med_us, $get_current_sub_category_saturated_fat_max_us, $get_current_sub_category_monounsaturated_fat_min_us, $get_current_sub_category_monounsaturated_fat_med_us, $get_current_sub_category_monounsaturated_fat_max_us, $get_current_sub_category_polyunsaturated_fat_min_us, $get_current_sub_category_polyunsaturated_fat_med_us, $get_current_sub_category_polyunsaturated_fat_max_us, $get_current_sub_category_cholesterol_min_us, $get_current_sub_category_cholesterol_med_us, $get_current_sub_category_cholesterol_max_us, $get_current_sub_category_carb_min_us, $get_current_sub_category_carb_med_us, $get_current_sub_category_carb_max_us, $get_current_sub_category_carb_of_which_sugars_min_us, $get_current_sub_category_carb_of_which_sugars_med_us, $get_current_sub_category_carb_of_which_sugars_max_us, $get_current_sub_category_dietary_fiber_min_us, $get_current_sub_category_dietary_fiber_med_us, $get_current_sub_category_dietary_fiber_max_us, $get_current_sub_category_proteins_min_us, $get_current_sub_category_proteins_med_us, $get_current_sub_category_proteins_max_us, $get_current_sub_category_salt_min_us, $get_current_sub_category_salt_med_us, $get_current_sub_category_salt_max_us, $get_current_sub_category_sodium_min_us, $get_current_sub_category_sodium_med_us, $get_current_sub_category_sodium_max_us) = $row_t;
		
	
		$inp_feed_category_name_mysql = quote_smart($link, $get_current_sub_category_translation_value);


		// Feed title
		$inp_feed_title = "$get_current_food_manufacturer_name $get_current_food_name";
		$inp_feed_title_mysql = quote_smart($link, $inp_feed_title);

		// Feed text
		$inp_feed_text = substr($get_current_food_description, 0, 200);
		$inp_feed_text_mysql = quote_smart($link, $inp_feed_text);

		// Feed image path
		$inp_feed_image_path_mysql = quote_smart($link, $get_current_food_image_path);

		// Feed image file
		$inp_feed_image_file_mysql = quote_smart($link, $get_current_food_image_a);

		// Feed image thumb 300x169
		$extension = get_extension($get_current_food_image_a);
		$inp_feed_image_thumb = str_replace(".$extension", "", $get_current_food_image_a);
		$inp_feed_image_thumb_a = $inp_feed_image_thumb . "_300x169." . $extension;
		$inp_feed_image_thumb_a_mysql = quote_smart($link, $inp_feed_image_thumb_a);

		// Feed image thumb 540x304
		$inp_feed_image_thumb = str_replace(".$extension", "", $get_current_food_image_a);
		$inp_feed_image_thumb_b = $inp_feed_image_thumb . "_540x304." . $extension;
		$inp_feed_image_thumb_b_mysql = quote_smart($link, $inp_feed_image_thumb_b);

		// Feed link URL
		$inp_feed_link_url = "food/view_food.php?main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;l=$l";
		$inp_feed_link_url_mysql = quote_smart($link, $inp_feed_link_url);

		// Feed link name
		$inp_feed_link_name = "$l_read_more";
		$inp_feed_link_name_mysql = quote_smart($link, $inp_feed_link_name);


		// Get current user
		$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$get_current_food_user_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_rank) = $row;

		// Author image
		$query = "SELECT photo_id, photo_destination, photo_thumb_40, photo_thumb_50, photo_thumb_60, photo_thumb_200 FROM $t_users_profile_photo WHERE photo_user_id='$get_current_food_user_id' AND photo_profile_image='1'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_my_photo_id, $get_my_photo_destination, $get_my_photo_thumb_40, $get_my_photo_thumb_50, $get_my_photo_thumb_60, $get_my_photo_thumb_200) = $row;


		$inp_feed_user_email_mysql = quote_smart($link, $get_my_user_email);
		$inp_feed_user_name_mysql = quote_smart($link, $get_my_user_name);
		$inp_feed_user_alias_mysql = quote_smart($link, $get_my_user_alias);
		$inp_feed_user_photo_file_mysql = quote_smart($link, $get_my_photo_destination);
		$inp_feed_user_photo_thumb_40_mysql = quote_smart($link, $get_my_photo_thumb_40);
		$inp_feed_user_photo_thumb_50_mysql = quote_smart($link, $get_my_photo_thumb_50);
		$inp_feed_user_photo_thumb_60_mysql = quote_smart($link, $get_my_photo_thumb_60);
		$inp_feed_user_photo_thumb_200_mysql = quote_smart($link, $get_my_photo_thumb_200);


		// My IP
		$inp_my_ip = $_SERVER['REMOTE_ADDR'];
		$inp_my_ip = output_html($inp_my_ip);
		$inp_my_ip_mysql = quote_smart($link, $inp_my_ip);

		// My hostname
		$inp_my_hostname = "$inp_ip";
		if($configSiteUseGethostbyaddrSav == "1"){
			$inp_my_hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']); // Some servers in local network cant use getostbyaddr because of nameserver missing
		}
		$inp_my_hostname = output_html($inp_my_hostname);
		$inp_my_hostname_mysql = quote_smart($link, $inp_my_hostname);
					
		// Lang
		$inp_feed_language = output_html($l);
		$inp_feed_language_mysql = quote_smart($link, $inp_feed_language);
					
		// Subscribe
		$query = "SELECT es_id, es_user_id, es_type, es_on_off FROM $t_users_email_subscriptions WHERE es_user_id='$get_current_food_user_id' AND es_type='users_feed'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_es_id, $get_es_user_id, $get_es_type, $get_es_on_off) = $row;
		if($get_es_id == ""){
			// Dont know
			mysqli_query($link, "INSERT INTO $t_users_email_subscriptions 
			(es_id, es_user_id, es_type, es_on_off) 
			VALUES 
			(NULL, $get_my_user_id, 'users_feed', 0)") or die(mysqli_error($link));
			$get_es_on_off = 0;
		}
					
		$year = date("Y");
		$date_saying = date("j M Y");

		// Check if exists
		if($get_current_food_age_restriction == "0"){
			$query = "SELECT feed_id FROM $t_users_feeds_index WHERE feed_module_name='food' AND feed_module_part_name='food' AND feed_module_part_id=$get_current_food_id AND feed_user_id=$get_current_food_user_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_feed_id) = $row;
			if($get_current_feed_id == ""){
				// Insert feed
				mysqli_query($link, "INSERT INTO $t_users_feeds_index
				(feed_id, feed_title, feed_text, feed_image_path, feed_image_file, 
				feed_image_thumb_300x169, feed_image_thumb_540x304, feed_link_url, feed_link_name, feed_module_name, 
				feed_module_part_name, feed_module_part_id, feed_main_category_id, feed_main_category_name, 
				feed_user_id, feed_user_email, feed_user_name, feed_user_alias, 
				feed_user_photo_file, feed_user_photo_thumb_40, feed_user_photo_thumb_50, feed_user_photo_thumb_60, feed_user_photo_thumb_200, 
				feed_user_subscribe, feed_user_ip, feed_user_hostname, feed_language, feed_created_datetime, 
				feed_created_year, feed_created_time, feed_created_date_saying, feed_likes, feed_dislikes, feed_comments) 
				VALUES 
				(NULL, $inp_feed_title_mysql, $inp_feed_text_mysql, $inp_feed_image_path_mysql, $inp_feed_image_file_mysql, 
				$inp_feed_image_thumb_a_mysql, $inp_feed_image_thumb_b_mysql, $inp_feed_link_url_mysql, $inp_feed_link_name_mysql, 'food', 
				'food', $get_current_food_id, $get_current_food_sub_category_id, $inp_feed_category_name_mysql, 
				$get_my_user_id, $inp_feed_user_email_mysql, $inp_feed_user_name_mysql, $inp_feed_user_alias_mysql, 
				$inp_feed_user_photo_file_mysql, $inp_feed_user_photo_thumb_40_mysql, $inp_feed_user_photo_thumb_50_mysql, $inp_feed_user_photo_thumb_60_mysql, $inp_feed_user_photo_thumb_200_mysql, 
				$get_es_on_off, $inp_my_ip_mysql, $inp_my_hostname_mysql, $inp_feed_language_mysql, '$datetime',
				'$year', '$time', '$date_saying', 0, 0, 0)")
				or die(mysqli_error($link));
						
			} // Create feed
			else{
				// Update feed
				mysqli_query($link, "UPDATE $t_users_feeds_index SET
						feed_title=$inp_feed_title_mysql, 
						feed_text=$inp_feed_text_mysql, 
						feed_image_path=$inp_feed_image_path_mysql, 
						feed_image_file=$inp_feed_image_file_mysql, 
						feed_image_thumb_300x169=$inp_feed_image_thumb_a_mysql, 
						feed_image_thumb_540x304=$inp_feed_image_thumb_b_mysql, 
						feed_modified_datetime='$datetime'
						WHERE feed_id=$get_current_feed_id")
						or die(mysqli_error($link));
			} // Update feed
		} // age restriction	

		echo"

		<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" /> Loading...</h1>
		<meta http-equiv=\"refresh\" content=\"1;url=view_food.php?main_category_id=$get_current_food_main_category_id&sub_category_id=$get_current_food_sub_category_id&food_id=$get_current_food_id&l=$l\">
		";

	} // food found
}
else{
	echo"
	<h1>
	<img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/index.php?page=login&amp;l=$l&amp;refer=$root/food/new_food.php\">
	";
}

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>