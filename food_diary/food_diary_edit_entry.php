<?php
/**
*
* File: food_diary/food_diary_edit_entry.php
* Version 1.0.0.
* Date 12:42 21.01.2018
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

/*- Tables --------------------------------------------------------------------------- */
include("_tables.php");


/*- Variables ------------------------------------------------------------------------- */
$l_mysql = quote_smart($link, $l);

/*- Translation ------------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/food_diary/ts_food_diary.php");


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_food_diary - $l_edit_entry";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");


/*- Content ---------------------------------------------------------------------------------- */
// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security']) && isset($_GET['entry_id'])) {

	// Get my profile
	$my_user_id = $_SESSION['user_id'];
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	$query = "SELECT user_id, user_alias, user_email, user_gender, user_height, user_measurement, user_dob FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_alias, $get_my_user_email, $get_my_user_gender, $get_my_user_height, $get_my_user_measurement, $get_my_user_dob) = $row;
	
	// Get entry

	$entry_id = $_GET['entry_id'];
	$entry_id = strip_tags(stripslashes($entry_id));
	$entry_id_mysql = quote_smart($link, $entry_id);

	$query = "SELECT entry_id, entry_user_id, entry_date, entry_meal_id, entry_food_id, entry_recipe_id, entry_name, entry_manufacturer_name, entry_serving_size, entry_serving_size_measurement, entry_energy_per_entry, entry_fat_per_entry, entry_carb_per_entry, entry_protein_per_entry, entry_text FROM $t_food_diary_entires WHERE entry_id=$entry_id_mysql AND entry_user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_entry_id, $get_current_entry_user_id, $get_current_entry_date, $get_current_entry_meal_id, $get_current_entry_food_id, $get_current_entry_recipe_id, $get_current_entry_name, $get_current_entry_manufacturer_name, $get_current_entry_serving_size, $get_current_entry_serving_size_measurement, $get_current_entry_energy_per_entry, $get_current_entry_fat_per_entry, $get_current_entry_carb_per_entry, $get_current_entry_protein_per_entry, $get_current_entry_text) = $row;
	
	if($get_current_entry_id == ""){
		echo"
		<h1>Server error 404</h1>
		<p>Entry not found.</p>
		";
	}
	else{
		if($process == "1"){

			$inp_updated = date("Y-m-d H:i:s");
			$inp_updated_mysql = quote_smart($link, $inp_updated);


			$inp_entry_serving_size = $_POST['inp_entry_serving_size'];
			$inp_entry_serving_size = output_html($inp_entry_serving_size);
			$inp_entry_serving_size = str_replace(",", ".", $inp_entry_serving_size);
			$inp_entry_serving_size_mysql = quote_smart($link, $inp_entry_serving_size);
			$result = mysqli_query($link, "UPDATE $t_food_diary_entires SET entry_serving_size=$inp_entry_serving_size_mysql, entry_updated=$inp_updated_mysql, entry_synchronized='0' WHERE entry_id=$entry_id_mysql AND entry_user_id=$my_user_id_mysql");



			// Calculate
			if($get_current_entry_food_id != "0"){
				// get food


				$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_country, food_net_content_metric, food_net_content_measurement_metric, food_net_content_us, food_net_content_measurement_us, food_net_content_added_measurement, food_serving_size_metric, food_serving_size_measurement_metric, food_serving_size_us, food_serving_size_measurement_us, food_serving_size_added_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy_metric, food_fat_metric, food_saturated_fat_metric, food_monounsaturated_fat_metric, food_polyunsaturated_fat_metric, food_cholesterol_metric, food_carbohydrates_metric, food_carbohydrates_of_which_sugars_metric, food_dietary_fiber_metric, food_proteins_metric, food_salt_metric, food_sodium_metric, food_energy_us, food_fat_us, food_saturated_fat_us, food_monounsaturated_fat_us, food_polyunsaturated_fat_us, food_cholesterol_us, food_carbohydrates_us, food_carbohydrates_of_which_sugars_us, food_dietary_fiber_us, food_proteins_us, food_salt_us, food_sodium_us, food_score, food_energy_calculated_metric, food_fat_calculated_metric, food_saturated_fat_calculated_metric, food_monounsaturated_fat_calculated_metric, food_polyunsaturated_fat_calculated_metric, food_cholesterol_calculated_metric, food_carbohydrates_calculated_metric, food_carbohydrates_of_which_sugars_calculated_metric, food_dietary_fiber_calculated_metric, food_proteins_calculated_metric, food_salt_calculated_metric, food_sodium_calculated_metric, food_energy_calculated_us, food_fat_calculated_us, food_saturated_fat_calculated_us, food_monounsaturated_fat_calculated_us, food_polyunsaturated_fat_calculated_us, food_cholesterol_calculated_us, food_carbohydrates_calculated_us, food_carbohydrates_of_which_sugars_calculated_us, food_dietary_fiber_calculated_us, food_proteins_calculated_us, food_salt_calculated_us, food_sodium_calculated_us, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_thumb_a_medium, food_thumb_a_large, food_image_b, food_thumb_b_small, food_thumb_b_medium, food_thumb_b_large, food_image_c, food_thumb_c_small, food_thumb_c_medium, food_thumb_c_large, food_image_d, food_thumb_d_small, food_thumb_d_medium, food_thumb_d_large, food_image_e, food_thumb_e_small, food_thumb_e_medium, food_thumb_e_large, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_created_date, food_last_viewed, food_age_restriction FROM $t_food_index WHERE food_id=$get_current_entry_food_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_manufacturer_name_and_food_name, $get_food_description, $get_food_country, $get_food_net_content_metric, $get_food_net_content_measurement_metric, $get_food_net_content_us, $get_food_net_content_measurement_us, $get_food_net_content_added_measurement, $get_food_serving_size_metric, $get_food_serving_size_measurement_metric, $get_food_serving_size_us, $get_food_serving_size_measurement_us, $get_food_serving_size_added_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy_metric, $get_food_fat_metric, $get_food_saturated_fat_metric, $get_food_monounsaturated_fat_metric, $get_food_polyunsaturated_fat_metric, $get_food_cholesterol_metric, $get_food_carbohydrates_metric, $get_food_carbohydrates_of_which_sugars_metric, $get_food_dietary_fiber_metric, $get_food_proteins_metric, $get_food_salt_metric, $get_food_sodium_metric, $get_food_energy_us, $get_food_fat_us, $get_food_saturated_fat_us, $get_food_monounsaturated_fat_us, $get_food_polyunsaturated_fat_us, $get_food_cholesterol_us, $get_food_carbohydrates_us, $get_food_carbohydrates_of_which_sugars_us, $get_food_dietary_fiber_us, $get_food_proteins_us, $get_food_salt_us, $get_food_sodium_us, $get_food_score, $get_food_energy_calculated_metric, $get_food_fat_calculated_metric, $get_food_saturated_fat_calculated_metric, $get_food_monounsaturated_fat_calculated_metric, $get_food_polyunsaturated_fat_calculated_metric, $get_food_cholesterol_calculated_metric, $get_food_carbohydrates_calculated_metric, $get_food_carbohydrates_of_which_sugars_calculated_metric, $get_food_dietary_fiber_calculated_metric, $get_food_proteins_calculated_metric, $get_food_salt_calculated_metric, $get_food_sodium_calculated_metric, $get_food_energy_calculated_us, $get_food_fat_calculated_us, $get_food_saturated_fat_calculated_us, $get_food_monounsaturated_fat_calculated_us, $get_food_polyunsaturated_fat_calculated_us, $get_food_cholesterol_calculated_us, $get_food_carbohydrates_calculated_us, $get_food_carbohydrates_of_which_sugars_calculated_us, $get_food_dietary_fiber_calculated_us, $get_food_proteins_calculated_us, $get_food_salt_calculated_us, $get_food_sodium_calculated_us, $get_food_barcode, $get_food_main_category_id, $get_food_sub_category_id, $get_food_image_path, $get_food_image_a, $get_food_thumb_a_small, $get_food_thumb_a_medium, $get_food_thumb_a_large, $get_food_image_b, $get_food_thumb_b_small, $get_food_thumb_b_medium, $get_food_thumb_b_large, $get_food_image_c, $get_food_thumb_c_small, $get_food_thumb_c_medium, $get_food_thumb_c_large, $get_food_image_d, $get_food_thumb_d_small, $get_food_thumb_d_medium, $get_food_thumb_d_large, $get_food_image_e, $get_food_thumb_e_small, $get_food_thumb_e_medium, $get_food_thumb_e_large, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block, $get_food_user_ip, $get_food_created_date, $get_food_last_viewed, $get_food_age_restriction) = $row;


				// Gram or pcs?
				if (isset($_POST['inp_submit_gram'])) {
					// Gram
					$inp_entry_food_serving_size_measurement = output_html($get_food_serving_size_measurement_metric);
					$inp_entry_food_serving_size_measurement_mysql = quote_smart($link, $inp_entry_food_serving_size_measurement);

					$inp_entry_food_energy_per_entry = round(($inp_entry_serving_size*$get_food_energy_metric)/100, 1);
					$inp_entry_food_energy_per_entry_mysql = quote_smart($link, $inp_entry_food_energy_per_entry);

					$inp_entry_food_fat_per_entry = round(($inp_entry_serving_size*$get_food_fat_metric)/100, 1);
					$inp_entry_food_fat_per_entry_mysql = quote_smart($link, $inp_entry_food_fat_per_entry);

					$inp_entry_food_carb_per_entry = round(($inp_entry_serving_size*$get_food_carbohydrates_metric)/100, 1);
					$inp_entry_food_carb_per_entry_mysql = quote_smart($link, $inp_entry_food_carb_per_entry);

					$inp_entry_food_protein_per_entry = round(($inp_entry_serving_size*$get_food_proteins_metric)/100, 1);
					$inp_entry_food_protein_per_entry_mysql = quote_smart($link, $inp_entry_food_protein_per_entry);


				}
				else{
					$inp_entry_food_serving_size_measurement = output_html($get_food_serving_size_pcs_measurement);
					$inp_entry_food_serving_size_measurement_mysql = quote_smart($link, $inp_entry_food_serving_size_measurement);

					$inp_entry_food_energy_per_entry = round(($inp_entry_serving_size*$get_food_energy_calculated_metric)/$get_food_serving_size_pcs, 1);
					$inp_entry_food_energy_per_entry_mysql = quote_smart($link, $inp_entry_food_energy_per_entry);

					$inp_entry_food_fat_per_entry = round(($inp_entry_serving_size*$get_food_fat_calculated_metric)/$get_food_serving_size_pcs, 1);
					$inp_entry_food_fat_per_entry_mysql = quote_smart($link, $inp_entry_food_fat_per_entry);

					$inp_entry_food_carb_per_entry = round(($inp_entry_serving_size*$get_food_carbohydrates_calculated_metric)/$get_food_serving_size_pcs, 1);
					$inp_entry_food_carb_per_entry_mysql = quote_smart($link, $inp_entry_food_carb_per_entry);

					$inp_entry_food_protein_per_entry = round(($inp_entry_serving_size*$get_food_proteins_calculated_metric)/$get_food_serving_size_pcs, 1);
					$inp_entry_food_protein_per_entry_mysql = quote_smart($link, $inp_entry_food_protein_per_entry);

				}


				$result = mysqli_query($link, "UPDATE $t_food_diary_entires SET 
				entry_serving_size_measurement=$inp_entry_food_serving_size_measurement_mysql,
				entry_energy_per_entry=$inp_entry_food_energy_per_entry_mysql, entry_fat_per_entry=$inp_entry_food_fat_per_entry_mysql, 
				entry_carb_per_entry=$inp_entry_food_carb_per_entry_mysql, entry_protein_per_entry=$inp_entry_food_protein_per_entry_mysql WHERE entry_id=$entry_id_mysql AND entry_user_id=$my_user_id_mysql");

			} // food
			else{
				// get recipe
				$query = "SELECT recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password FROM $t_recipes WHERE recipe_id=$get_current_entry_recipe_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_recipe_id, $get_recipe_user_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_language, $get_recipe_introduction, $get_recipe_directions, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb, $get_recipe_video, $get_recipe_date, $get_recipe_time, $get_recipe_cusine_id, $get_recipe_season_id, $get_recipe_occasion_id, $get_recipe_marked_as_spam, $get_recipe_unique_hits, $get_recipe_unique_hits_ip_block, $get_recipe_user_ip, $get_recipe_notes, $get_recipe_password) = $row;

				// get numbers
				$query = "SELECT number_id, number_recipe_id, number_hundred_calories, number_hundred_proteins, number_hundred_fat, number_hundred_carbs, number_serving_calories, number_serving_proteins, number_serving_fat, number_serving_carbs, number_total_weight, number_total_calories, number_total_proteins, number_total_fat, number_total_carbs, number_servings FROM $t_recipes_numbers WHERE number_recipe_id='$get_recipe_id'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_number_id, $get_number_recipe_id, $get_number_hundred_calories, $get_number_hundred_proteins, $get_number_hundred_fat, $get_number_hundred_carbs, $get_number_serving_calories, $get_number_serving_proteins, $get_number_serving_fat, $get_number_serving_carbs, $get_number_total_weight, $get_number_total_calories, $get_number_total_proteins, $get_number_total_fat, $get_number_total_carbs, $get_number_servings) = $row;


				$inp_entry_energy_per_entry = round($inp_entry_serving_size*$get_number_serving_calories, 1);
				$inp_entry_energy_per_entry_mysql = quote_smart($link, $inp_entry_energy_per_entry);

				$inp_entry_fat_per_entry = round($inp_entry_serving_size*$get_number_serving_fat, 1);
				$inp_entry_fat_per_entry_mysql = quote_smart($link, $inp_entry_fat_per_entry);

				$inp_entry_carb_per_entry = round($inp_entry_serving_size*$get_number_serving_carbs, 1);
				$inp_entry_carb_per_entry_mysql = quote_smart($link, $inp_entry_carb_per_entry);

				$inp_entry_protein_per_entry = round($inp_entry_serving_size*$get_number_serving_proteins, 1);
				$inp_entry_protein_per_entry_mysql = quote_smart($link, $inp_entry_protein_per_entry);

				$result = mysqli_query($link, "UPDATE $t_food_diary_entires SET 
				entry_energy_per_entry=$inp_entry_energy_per_entry_mysql, entry_fat_per_entry=$inp_entry_fat_per_entry_mysql, 
				entry_carb_per_entry=$inp_entry_carb_per_entry_mysql, entry_protein_per_entry=$inp_entry_protein_per_entry_mysql WHERE entry_id=$entry_id_mysql AND entry_user_id=$my_user_id_mysql");


			} // recipe

			
			// food_diary_totals_meals :: Calcualte :: Get all meals for that day, and update numbers
			$inp_total_meal_energy = 0;
			$inp_total_meal_fat = 0;
			$inp_total_meal_carb = 0;
			$inp_total_meal_protein = 0;
			
			$query = "SELECT entry_id, entry_energy_per_entry, entry_fat_per_entry, entry_carb_per_entry, entry_protein_per_entry FROM $t_food_diary_entires WHERE entry_user_id=$my_user_id_mysql AND entry_date='$get_current_entry_date' AND entry_meal_id='$get_current_entry_meal_id'";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
    				list($get_entry_id, $get_entry_energy_per_entry, $get_entry_fat_per_entry, $get_entry_carb_per_entry, $get_entry_protein_per_entry) = $row;

				
				$inp_total_meal_energy 		= $inp_total_meal_energy+$get_entry_energy_per_entry;
				$inp_total_meal_fat 		= $inp_total_meal_fat+$get_entry_fat_per_entry;
				$inp_total_meal_carb		= $inp_total_meal_carb+$get_entry_carb_per_entry;
				$inp_total_meal_protein 	= $inp_total_meal_protein+$get_entry_protein_per_entry;
			}
			
			$result = mysqli_query($link, "UPDATE $t_food_diary_totals_meals SET 
			total_meal_energy='$inp_total_meal_energy', total_meal_fat='$inp_total_meal_fat', total_meal_carb='$inp_total_meal_carb', total_meal_protein='$inp_total_meal_protein',
			total_meal_updated=$inp_updated_mysql, total_meal_synchronized='0'
			 WHERE total_meal_user_id=$my_user_id_mysql AND total_meal_date='$get_current_entry_date' AND total_meal_meal_id='$get_current_entry_meal_id'");


			// food_diary_totals_days
			$query = "SELECT total_day_id, total_day_user_id, total_day_date, total_day_consumed_energy, total_day_consumed_fat, total_day_consumed_carb, total_day_consumed_protein, total_day_target_sedentary_energy, total_day_target_sedentary_fat, total_day_target_sedentary_carb, total_day_target_sedentary_protein, total_day_target_with_activity_energy, total_day_target_with_activity_fat, total_day_target_with_activity_carb, total_day_target_with_activity_protein, total_day_diff_sedentary_energy, total_day_diff_sedentary_fat, total_day_diff_sedentary_carb, total_day_diff_sedentary_protein, total_day_diff_with_activity_energy, total_day_diff_with_activity_fat, total_day_diff_with_activity_carb, total_day_diff_with_activity_protein FROM $t_food_diary_totals_days WHERE total_day_user_id=$my_user_id_mysql AND total_day_date='$get_current_entry_date'";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_total_day_id, $get_total_day_user_id, $get_total_day_date, $get_total_day_consumed_energy, $get_total_day_consumed_fat, $get_total_day_consumed_carb, $get_total_day_consumed_protein, $get_total_day_target_sedentary_energy, $get_total_day_target_sedentary_fat, $get_total_day_target_sedentary_carb, $get_total_day_target_sedentary_protein, $get_total_day_target_with_activity_energy, $get_total_day_target_with_activity_fat, $get_total_day_target_with_activity_carb, $get_total_day_target_with_activity_protein, $get_total_day_diff_sedentary_energy, $get_total_day_diff_sedentary_fat, $get_total_day_diff_sedentary_carb, $get_total_day_diff_sedentary_protein, $get_total_day_diff_with_activity_energy, $get_total_day_diff_with_activity_fat, $get_total_day_diff_with_activity_carb, $get_total_day_diff_with_activity_protein) = $row;

			$inp_total_day_consumed_energy = 0;
			$inp_total_day_consumed_fat = 0;
			$inp_total_day_consumed_carb = 0;
			$inp_total_day_consumed_protein = 0;
			$query = "SELECT total_meal_id, total_meal_energy, total_meal_fat, total_meal_carb, total_meal_protein FROM $t_food_diary_totals_meals WHERE total_meal_user_id=$my_user_id_mysql AND total_meal_date='$get_current_entry_date'";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
    				list($get_total_meal_id, $get_total_meal_energy, $get_total_meal_fat, $get_total_meal_carb, $get_total_meal_protein) = $row;

				
				$inp_total_day_consumed_energy  = $inp_total_day_consumed_energy+$get_total_meal_energy;
				$inp_total_day_consumed_fat     = $inp_total_day_consumed_fat+$get_total_meal_fat;
				$inp_total_day_consumed_carb    = $inp_total_day_consumed_carb+$get_total_meal_carb;
				$inp_total_day_consumed_protein = $inp_total_day_consumed_protein+$get_total_meal_protein;
			}


			$inp_total_day_diff_sedentary_energy = $get_total_day_target_sedentary_energy-$inp_total_day_consumed_energy;
			$inp_total_day_diff_sedentary_fat = $get_total_day_target_sedentary_fat-$inp_total_day_consumed_fat;
			$inp_total_day_diff_sedentary_carb = $get_total_day_target_sedentary_energy-$inp_total_day_consumed_carb;
			$inp_total_day_diff_sedentary_protein = $get_total_day_target_sedentary_energy-$inp_total_day_consumed_protein;
	

			$inp_total_day_diff_with_activity_energy = $get_total_day_target_with_activity_energy-$inp_total_day_consumed_energy;
			$inp_total_day_diff_with_activity_fat = $get_total_day_target_with_activity_fat-$inp_total_day_consumed_fat;
			$inp_total_day_diff_with_activity_carb = $get_total_day_target_with_activity_energy-$inp_total_day_consumed_carb;
			$inp_total_day_diff_with_activity_protein = $get_total_day_target_with_activity_energy-$inp_total_day_consumed_protein;

			$result = mysqli_query($link, "UPDATE $t_food_diary_totals_days SET 
			total_day_consumed_energy='$inp_total_day_consumed_energy', total_day_consumed_fat='$inp_total_day_consumed_fat', total_day_consumed_carb='$inp_total_day_consumed_carb', total_day_consumed_protein=$inp_total_day_consumed_protein,
			total_day_diff_sedentary_energy='$inp_total_day_diff_sedentary_energy', total_day_diff_sedentary_fat='$inp_total_day_diff_sedentary_fat', total_day_diff_sedentary_carb='$inp_total_day_diff_sedentary_carb', total_day_diff_sedentary_protein='$inp_total_day_diff_sedentary_protein',
			total_day_diff_with_activity_energy='$inp_total_day_diff_with_activity_energy', total_day_diff_with_activity_fat='$inp_total_day_diff_with_activity_fat', total_day_diff_with_activity_carb='$inp_total_day_diff_with_activity_carb', total_day_diff_with_activity_protein='$inp_total_day_diff_with_activity_protein',
			total_day_updated=$inp_updated_mysql, total_day_synchronized='0'
			 WHERE total_day_user_id=$my_user_id_mysql AND total_day_date='$get_current_entry_date'");



			$url = "index.php?date=$get_current_entry_date&l=$l&ft=success&fm=changes_saved#meal$get_current_entry_meal_id";
			header("Location: $url");
			exit;
		} // process




		// Date
		$year  = substr($get_current_entry_date, 0, 4);
		$month = substr($get_current_entry_date, 5, 2);
		$day   = substr($get_current_entry_date, 8, 2);
			
		if($month == "01"){
			$month_saying = $l_january;
		}
		elseif($month == "02"){
			$month_saying = $l_february;
		}
		elseif($month == "03"){
			$month_saying = $l_march;
		}
		elseif($month == "04"){
			$month_saying = $l_april;
		}
		elseif($month == "05"){
			$month_saying = $l_may;
		}
		elseif($month == "06"){
			$month_saying = $l_june;
		}
		elseif($month == "07"){
			$month_saying = $l_july;
		}
		elseif($month == "08"){
			$month_saying = $l_august;
		}
		elseif($month == "09"){
			$month_saying = $l_september;
		}
		elseif($month == "10"){
			$month_saying = $l_october;
		}
		elseif($month == "11"){
			$month_saying = $l_november;
		}
		else{
			$month_saying = $l_december;
		}

		echo"
		<h1>$get_current_entry_name</h1>

	
		<!-- Feedback -->
		";
		if($ft != "" && $fm != ""){
		if($fm == "changes_saved"){
			$fm = "$l_changes_saved";
		}
		else{
			$fm = ucfirst($fm);
		}
		echo"<div class=\"$ft\"><p>$fm</p></div>";
		}
		echo"
		<!-- //Feedback -->


		<!-- You are here -->
			<p><b>$l_you_are_here</b><br />
			<a href=\"index.php?l=$l\">$l_food_diary</a>
			&gt;
			<a href=\"index.php?date=$get_current_entry_date&amp;l=$l\">$day $month_saying $year</a>
			&gt;
			<a href=\"index.php?date=$get_current_entry_date&amp;l=$l#meal$get_current_entry_meal_id\">";

			if($get_current_entry_meal_id == "0"){
				echo"$l_breakfast";
			}
			elseif($get_current_entry_meal_id == "1"){
				echo"$l_lunch";
			}
			elseif($get_current_entry_meal_id == "2"){
				echo"$l_before_training";
			}
			elseif($get_current_entry_meal_id == "3"){
				echo"$l_after_training";
			}
			elseif($get_current_entry_meal_id == "4"){
				echo"$l_dinner";
			}
			elseif($get_current_entry_meal_id == "5"){
				echo"$l_snacks";
			}
			elseif($get_current_entry_meal_id == "6"){
				echo"$l_supper";
			}
			else{
				echo"??";die;
			}
			echo"</a>
			&gt;
			<a href=\"food_diary_edit_entry.php?entry_id=$entry_id&amp;l=$l\">$get_current_entry_name</a>
			</p>
		<!-- //You are here -->



		<!-- About -->
		";
			if($get_current_entry_food_id != "0"){
				// get food
				$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_country, food_net_content_metric, food_net_content_measurement_metric, food_net_content_us, food_net_content_measurement_us, food_net_content_added_measurement, food_serving_size_metric, food_serving_size_measurement_metric, food_serving_size_us, food_serving_size_measurement_us, food_serving_size_added_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy_metric, food_fat_metric, food_saturated_fat_metric, food_monounsaturated_fat_metric, food_polyunsaturated_fat_metric, food_cholesterol_metric, food_carbohydrates_metric, food_carbohydrates_of_which_sugars_metric, food_dietary_fiber_metric, food_proteins_metric, food_salt_metric, food_sodium_metric, food_energy_us, food_fat_us, food_saturated_fat_us, food_monounsaturated_fat_us, food_polyunsaturated_fat_us, food_cholesterol_us, food_carbohydrates_us, food_carbohydrates_of_which_sugars_us, food_dietary_fiber_us, food_proteins_us, food_salt_us, food_sodium_us, food_score, food_energy_calculated_metric, food_fat_calculated_metric, food_saturated_fat_calculated_metric, food_monounsaturated_fat_calculated_metric, food_polyunsaturated_fat_calculated_metric, food_cholesterol_calculated_metric, food_carbohydrates_calculated_metric, food_carbohydrates_of_which_sugars_calculated_metric, food_dietary_fiber_calculated_metric, food_proteins_calculated_metric, food_salt_calculated_metric, food_sodium_calculated_metric, food_energy_calculated_us, food_fat_calculated_us, food_saturated_fat_calculated_us, food_monounsaturated_fat_calculated_us, food_polyunsaturated_fat_calculated_us, food_cholesterol_calculated_us, food_carbohydrates_calculated_us, food_carbohydrates_of_which_sugars_calculated_us, food_dietary_fiber_calculated_us, food_proteins_calculated_us, food_salt_calculated_us, food_sodium_calculated_us, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_thumb_a_medium, food_thumb_a_large, food_image_b, food_thumb_b_small, food_thumb_b_medium, food_thumb_b_large, food_image_c, food_thumb_c_small, food_thumb_c_medium, food_thumb_c_large, food_image_d, food_thumb_d_small, food_thumb_d_medium, food_thumb_d_large, food_image_e, food_thumb_e_small, food_thumb_e_medium, food_thumb_e_large, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_created_date, food_last_viewed, food_age_restriction FROM $t_food_index WHERE food_id=$get_current_entry_food_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_manufacturer_name_and_food_name, $get_food_description, $get_food_country, $get_food_net_content_metric, $get_food_net_content_measurement_metric, $get_food_net_content_us, $get_food_net_content_measurement_us, $get_food_net_content_added_measurement, $get_food_serving_size_metric, $get_food_serving_size_measurement_metric, $get_food_serving_size_us, $get_food_serving_size_measurement_us, $get_food_serving_size_added_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy_metric, $get_food_fat_metric, $get_food_saturated_fat_metric, $get_food_monounsaturated_fat_metric, $get_food_polyunsaturated_fat_metric, $get_food_cholesterol_metric, $get_food_carbohydrates_metric, $get_food_carbohydrates_of_which_sugars_metric, $get_food_dietary_fiber_metric, $get_food_proteins_metric, $get_food_salt_metric, $get_food_sodium_metric, $get_food_energy_us, $get_food_fat_us, $get_food_saturated_fat_us, $get_food_monounsaturated_fat_us, $get_food_polyunsaturated_fat_us, $get_food_cholesterol_us, $get_food_carbohydrates_us, $get_food_carbohydrates_of_which_sugars_us, $get_food_dietary_fiber_us, $get_food_proteins_us, $get_food_salt_us, $get_food_sodium_us, $get_food_score, $get_food_energy_calculated_metric, $get_food_fat_calculated_metric, $get_food_saturated_fat_calculated_metric, $get_food_monounsaturated_fat_calculated_metric, $get_food_polyunsaturated_fat_calculated_metric, $get_food_cholesterol_calculated_metric, $get_food_carbohydrates_calculated_metric, $get_food_carbohydrates_of_which_sugars_calculated_metric, $get_food_dietary_fiber_calculated_metric, $get_food_proteins_calculated_metric, $get_food_salt_calculated_metric, $get_food_sodium_calculated_metric, $get_food_energy_calculated_us, $get_food_fat_calculated_us, $get_food_saturated_fat_calculated_us, $get_food_monounsaturated_fat_calculated_us, $get_food_polyunsaturated_fat_calculated_us, $get_food_cholesterol_calculated_us, $get_food_carbohydrates_calculated_us, $get_food_carbohydrates_of_which_sugars_calculated_us, $get_food_dietary_fiber_calculated_us, $get_food_proteins_calculated_us, $get_food_salt_calculated_us, $get_food_sodium_calculated_us, $get_food_barcode, $get_food_main_category_id, $get_food_sub_category_id, $get_food_image_path, $get_food_image_a, $get_food_thumb_a_small, $get_food_thumb_a_medium, $get_food_thumb_a_large, $get_food_image_b, $get_food_thumb_b_small, $get_food_thumb_b_medium, $get_food_thumb_b_large, $get_food_image_c, $get_food_thumb_c_small, $get_food_thumb_c_medium, $get_food_thumb_c_large, $get_food_image_d, $get_food_thumb_d_small, $get_food_thumb_d_medium, $get_food_thumb_d_large, $get_food_image_e, $get_food_thumb_e_small, $get_food_thumb_e_medium, $get_food_thumb_e_large, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block, $get_food_user_ip, $get_food_created_date, $get_food_last_viewed, $get_food_age_restriction) = $row;

				echo"
				<div style=\"float: left;\">
					<h2>
					$get_food_manufacturer_name $get_food_name
					</h2>

					<!-- Food Numbers -->

							<table style=\"width: 350px\">
							 <thead>
							  <tr>
							   <th scope=\"col\">
							   </th>
							   <th scope=\"col\" style=\"text-align: center;padding: 8px 4px 8px 4px;\">
								<span style=\"font-weight: normal;\">$l_energy</span>
							   </th>
							   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;\">
								<span style=\"font-weight: normal;\">$l_proteins</span>
							   </th>
							   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;\">
								<span style=\"font-weight: normal;\">$l_carbs</span>
							   </th>
							   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;\">
								<span style=\"font-weight: normal;\">$l_fat</span>
							   </th>
							  </tr>
							 </thead>
							 <tbody>
							  <tr>
							   <td style=\"text-align: right;padding: 8px 4px 6px 8px;\">
								<span>$l_per_100:</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_food_energy_metric</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_food_proteins_metric</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_food_carbohydrates_metric</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_food_fat_metric</span>
							  </td>
							 </tr>
							  <tr>
							   <td style=\"text-align: right;padding: 8px 4px 6px 8px;\">
								<span>$l_serving:</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_food_energy_calculated_metric</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_food_proteins_calculated_metric</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_food_carbohydrates_calculated_metric</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_food_fat_calculated_metric</span>
							   </td>
							  </tr>
							 </tbody>
							</table>
					<!-- //Food Numbers -->

				</div>
				";
				if($get_food_id != ""){
					// 845/4 = 211
					if(file_exists("$root/$get_food_image_path/$get_food_image_a")){
						echo"
						<div style=\"float: left;padding-left: 15px;\">
							<a href=\"$root/food/view_food.php?main_category_id=$get_food_main_category_id&amp;sub_category_id=$get_food_sub_category_id&amp;food_id=$get_food_id&amp;action=show_image&amp;image=a&amp;l=$l\"><img src=\"$root/$get_food_image_path/$get_food_thumb_a_medium\" alt=\"$get_food_image_a\" /></a>
						</div>";
					}
				}
				echo"

				<!-- Edit form food -->
					<div class=\"clear\"></div>
					<script>
					\$(document).ready(function(){
						\$('[name=\"inp_entry_serving_size\"]').focus();
					});
					</script>
		
					<form method=\"post\" action=\"food_diary_edit_entry.php?entry_id=$entry_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
					<p>
					<b>$l_amount:</b><br />
					<input type=\"text\" name=\"inp_entry_serving_size\" value=\"$get_current_entry_serving_size\" size=\"3\" />
					$get_current_entry_serving_size_measurement


					<input type=\"submit\" name=\"inp_submit_gram\" value=\"$get_food_serving_size_measurement_metric\" class=\"btn btn_default\" />
					";
					if($get_food_serving_size_pcs_measurement != "g"){
						echo"<input type=\"submit\" name=\"inp_submit_pcs\" value=\"$get_food_serving_size_pcs_measurement\" class=\"btn btn_default\" />";
					}
					echo"</p>

					<p>
					<a href=\"food_diary_delete_entry.php?entry_id=$entry_id&amp;l=$l\" class=\"btn btn_warning\">$l_delete</a>
					</p>

					</form>
				<!-- //Edit form food -->

				";
			} // food
			else{
				// get recipe
				$query = "SELECT recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password FROM $t_recipes WHERE recipe_id=$get_current_entry_recipe_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_recipe_id, $get_recipe_user_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_language, $get_recipe_introduction, $get_recipe_directions, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb, $get_recipe_video, $get_recipe_date, $get_recipe_time, $get_recipe_cusine_id, $get_recipe_season_id, $get_recipe_occasion_id, $get_recipe_marked_as_spam, $get_recipe_unique_hits, $get_recipe_unique_hits_ip_block, $get_recipe_user_ip, $get_recipe_notes, $get_recipe_password) = $row;

				// get numbers
				$query = "SELECT number_id, number_recipe_id, number_hundred_calories, number_hundred_proteins, number_hundred_fat, number_hundred_carbs, number_serving_calories, number_serving_proteins, number_serving_fat, number_serving_carbs, number_total_weight, number_total_calories, number_total_proteins, number_total_fat, number_total_carbs, number_servings FROM $t_recipes_numbers WHERE number_recipe_id='$get_recipe_id'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_number_id, $get_number_recipe_id, $get_number_hundred_calories, $get_number_hundred_proteins, $get_number_hundred_fat, $get_number_hundred_carbs, $get_number_serving_calories, $get_number_serving_proteins, $get_number_serving_fat, $get_number_serving_carbs, $get_number_total_weight, $get_number_total_calories, $get_number_total_proteins, $get_number_total_fat, $get_number_total_carbs, $get_number_servings) = $row;

						echo"

						<div style=\"float: left;\">
							<h2>$get_recipe_title</h2>

							<!-- Numbers -->

							<table style=\"width: 350px\">
							 <thead>
							  <tr>
							   <th scope=\"col\">
							   </th>
							   <th scope=\"col\" style=\"text-align: center;padding: 8px 4px 8px 4px;\">
								<span style=\"font-weight: normal;\">$l_energy</span>
							   </th>
							   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;\">
								<span style=\"font-weight: normal;\">$l_proteins</span>
							   </th>
							   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;\">
								<span style=\"font-weight: normal;\">$l_carbs</span>
							   </th>
							   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;\">
								<span style=\"font-weight: normal;\">$l_fat</span>
							   </th>
							  </tr>
							 </thead>
							 <tbody>
							  <tr>
							   <td style=\"text-align: right;padding: 8px 4px 6px 8px;\">
								<span>$l_serving:</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_number_serving_calories</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_number_serving_proteins</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_number_serving_carbs</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_number_serving_fat</span>
							   </td>
							  </tr>
							 </tbody>
							</table>
							<!-- //Numbers -->

						</div>
						";
						if($get_recipe_image != ""){
							// 845/4 = 211
							if(file_exists("$root/$get_recipe_image_path/$get_recipe_image")){
				
								echo"
								<div style=\"float: left;padding-left: 15px;\">
									<img src=\"$root/image.php?width=200&height=200&image=/$get_recipe_image_path/$get_recipe_image\" alt=\"$get_recipe_image_path/$get_recipe_image\" />
								</div>";
							}
						}
				echo"

				<!-- Edit form recipe-->
					<div class=\"clear\"></div>
					<script>
					\$(document).ready(function(){
						\$('[name=\"inp_entry_serving_size\"]').focus();
					});
					</script>
		
					<form method=\"post\" action=\"food_diary_edit_entry.php?entry_id=$entry_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
					<p>
					<b>$l_amount:</b><br />
					<input type=\"text\" name=\"inp_entry_serving_size\" value=\"$get_current_entry_serving_size\" size=\"3\" />
					$get_current_entry_serving_size_measurement
					</p>

					<p>
					<input type=\"submit\" value=\"$l_save\" class=\"btn btn_default\" />
					<a href=\"food_diary_delete_entry.php?entry_id=$entry_id&amp;l=$l\" class=\"btn btn_warning\">$l_delete</a>
					</p>

					</form>
				<!-- //Edit form recipe -->

				";
					
		} // recipe

		echo"
		<!-- //About -->


		";
		
	} // entry found
}
else{
	echo"
	<h1>
	<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login?l=$l&amp;referer=$root/food_diary/index.php\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>