<?php
/**
*
* File: _admin/_inc/food/edit_food_general.php
* Version 14:53 20.01.2021
* Copyright (c) 2021 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}
/*- Tables ---------------------------------------------------------------------------- */
$t_food_categories		  = $mysqlPrefixSav . "food_categories";
$t_food_categories_translations	  = $mysqlPrefixSav . "food_categories_translations";
$t_food_index			  = $mysqlPrefixSav . "food_index";
$t_food_index_stores		  = $mysqlPrefixSav . "food_index_stores";
$t_food_index_ads		  = $mysqlPrefixSav . "food_index_ads";
$t_food_index_tags		  = $mysqlPrefixSav . "food_index_tags";
$t_food_index_prices		  = $mysqlPrefixSav . "food_index_prices";
$t_food_index_contents		  = $mysqlPrefixSav . "food_index_contents";
$t_food_stores		  	  = $mysqlPrefixSav . "food_stores";
$t_food_prices_currencies	  = $mysqlPrefixSav . "food_prices_currencies";
$t_food_favorites 		  = $mysqlPrefixSav . "food_favorites";
$t_food_measurements	 	  = $mysqlPrefixSav . "food_measurements";
$t_food_measurements_translations = $mysqlPrefixSav . "food_measurements_translations";
$t_food_countries_used 		  = $mysqlPrefixSav . "food_countries_used";



/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['language'])){
	$language = $_GET['language'];
	$language = strip_tags(stripslashes($language));
}
else{
	$language = "en";
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
if(isset($_GET['mode'])){
	$mode = $_GET['mode'];
	$mode = strip_tags(stripslashes($mode));
}
else{
	$mode = "";
}


/*- Settings ---------------------------------------------------------------------------- */
$settings_image_width = "847";
$settings_image_height = "847";


// Get variables
$food_id = $_GET['food_id'];
$food_id = strip_tags(stripslashes($food_id));
$food_id_mysql = quote_smart($link, $food_id);
$editor_language_mysql = quote_smart($link, $editor_language);

// Select food
$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_country, food_net_content, food_net_content_measurement, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_fat, food_fat_of_which_saturated_fatty_acids, food_carbohydrates, food_dietary_fiber, food_carbohydrates_of_which_sugars, food_proteins, food_salt, food_sodium, food_score, food_energy_calculated, food_fat_calculated, food_fat_of_which_saturated_fatty_acids_calculated, food_carbohydrates_calculated, food_dietary_fiber_calculated, food_carbohydrates_of_which_sugars_calculated, food_proteins_calculated, food_salt_calculated, food_sodium_calculated, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_thumb_a_medium, food_thumb_a_large, food_image_b, food_thumb_b_small, food_thumb_b_medium, food_thumb_b_large, food_image_c, food_thumb_c_small, food_thumb_c_medium, food_thumb_c_large, food_image_d, food_thumb_d_small, food_thumb_d_medium, food_thumb_d_large, food_image_e, food_thumb_e_small, food_thumb_e_medium, food_thumb_e_large, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_created_date, food_last_viewed, food_age_restriction FROM $t_food_index WHERE food_id=$food_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_food_id, $get_current_food_user_id, $get_current_food_name, $get_current_food_clean_name, $get_current_food_manufacturer_name, $get_current_food_manufacturer_name_and_food_name, $get_current_food_description, $get_current_food_country, $get_current_food_net_content, $get_current_food_net_content_measurement, $get_current_food_serving_size_gram, $get_current_food_serving_size_gram_measurement, $get_current_food_serving_size_pcs, $get_current_food_serving_size_pcs_measurement, $get_current_food_energy, $get_current_food_fat, $get_current_food_fat_of_which_saturated_fatty_acids, $get_current_food_carbohydrates, $get_current_food_dietary_fiber, $get_current_food_carbohydrates_of_which_sugars, $get_current_food_proteins, $get_current_food_salt, $get_current_food_sodium, $get_current_food_score, $get_current_food_energy_calculated, $get_current_food_fat_calculated, $get_current_food_fat_of_which_saturated_fatty_acids_calculated, $get_current_food_carbohydrates_calculated, $get_current_food_dietary_fiber_calculated, $get_current_food_carbohydrates_of_which_sugars_calculated, $get_current_food_proteins_calculated, $get_current_food_salt_calculated, $get_current_food_sodium_calculated, $get_current_food_barcode, $get_current_food_main_category_id, $get_current_food_sub_category_id, $get_current_food_image_path, $get_current_food_image_a, $get_current_food_thumb_a_small, $get_current_food_thumb_a_medium, $get_current_food_thumb_a_large, $get_current_food_image_b, $get_current_food_thumb_b_small, $get_current_food_thumb_b_medium, $get_current_food_thumb_b_large, $get_current_food_image_c, $get_current_food_thumb_c_small, $get_current_food_thumb_c_medium, $get_current_food_thumb_c_large, $get_current_food_image_d, $get_current_food_thumb_d_small, $get_current_food_thumb_d_medium, $get_current_food_thumb_d_large, $get_current_food_image_e, $get_current_food_thumb_e_small, $get_current_food_thumb_e_medium, $get_current_food_thumb_e_large, $get_current_food_last_used, $get_current_food_language, $get_current_food_synchronized, $get_current_food_accepted_as_master, $get_current_food_notes, $get_current_food_unique_hits, $get_current_food_unique_hits_ip_block, $get_current_food_comments, $get_current_food_likes, $get_current_food_dislikes, $get_current_food_likes_ip_block, $get_current_food_user_ip, $get_current_food_created_date, $get_current_food_last_viewed, $get_current_food_age_restriction) = $row;

if($get_current_food_id == ""){
	echo"
	<h1>Food not found</h1>
	<p>
	Sorry, the food was not found.
	</p>

	<p>
	<a href=\"index.php?open=$open&amp;page=default&amp;editor_language=$editor_language&amp;l=$l\">Back</a>
	</p>
	";
}
else{

	// Translation
	$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_current_food_main_category_id AND category_translation_language=$editor_language_mysql";
	$result_t = mysqli_query($link, $query_t);
	$row_t = mysqli_fetch_row($result_t);
	list($get_current_main_category_translation_value) = $row_t;


	$query_t = "SELECT category_translation_id, category_id, category_translation_language, category_translation_value, category_translation_no_food, category_translation_last_updated, category_calories_min, category_calories_med, category_calories_max, category_fat_min, category_fat_med, category_fat_max, category_fat_of_which_saturated_fatty_acids_min, category_fat_of_which_saturated_fatty_acids_med, category_fat_of_which_saturated_fatty_acids_max, category_carb_min, category_carb_med, category_carb_max, category_carb_of_which_dietary_fiber_min, category_carb_of_which_dietary_fiber_med, category_carb_of_which_dietary_fiber_max, category_carb_of_which_sugars_min, category_carb_of_which_sugars_med, category_carb_of_which_sugars_max, category_proteins_min, category_proteins_med, category_proteins_max, category_salt_min, category_salt_med, category_salt_max FROM $t_food_categories_translations WHERE category_id=$get_current_food_sub_category_id AND category_translation_language=$editor_language_mysql";
	$result_t = mysqli_query($link, $query_t);
	$row_t = mysqli_fetch_row($result_t);
	list($get_current_sub_category_translation_id, $get_current_sub_category_id, $get_current_sub_category_translation_language, $get_current_sub_category_translation_value, $get_current_sub_category_translation_no_food, $get_current_sub_category_translation_last_updated, $get_current_sub_category_calories_min, $get_current_sub_category_calories_med, $get_current_sub_category_calories_max, $get_current_sub_category_fat_min, $get_current_sub_category_fat_med, $get_current_sub_category_fat_max, $get_current_sub_category_fat_of_which_saturated_fatty_acids_min, $get_current_sub_category_fat_of_which_saturated_fatty_acids_med, $get_current_sub_category_fat_of_which_saturated_fatty_acids_max, $get_current_sub_category_carb_min, $get_current_sub_category_carb_med, $get_current_sub_category_carb_max, $get_current_sub_category_carb_of_which_dietary_fiber_min, $get_current_sub_category_carb_of_which_dietary_fiber_med, $get_current_sub_category_carb_of_which_dietary_fiber_max, $get_current_sub_category_carb_of_which_sugars_min, $get_current_sub_category_carb_of_which_sugars_med, $get_current_sub_category_carb_of_which_sugars_max, $get_current_sub_category_proteins_min, $get_current_sub_category_proteins_med, $get_current_sub_category_proteins_max, $get_current_sub_category_salt_min, $get_current_sub_category_salt_med, $get_current_sub_category_salt_max) = $row_t;

	// Author
	$query = "SELECT user_id, user_email, user_name, user_alias FROM $t_users WHERE user_id=$get_current_food_user_id";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_food_author_user_id, $get_current_food_author_user_email, $get_current_food_author_user_name, $get_current_food_author_user_alias) = $row;


	// Process == 1
	if($process == "1"){
		// Dates
		$datetime = date("Y-m-d H:i:s");


		// General
				$inp_food_name = $_POST['inp_food_name'];
				$inp_food_name = output_html($inp_food_name);
				$inp_food_name_mysql = quote_smart($link, $inp_food_name);
				if(empty($inp_food_name)){
					$ft = "error";
					$fm = "missing_name";
				}

				// Clean name
				$inp_food_clean_name = clean($inp_food_name);
				$inp_food_clean_name_mysql = quote_smart($link, $inp_food_clean_name);

				$inp_food_manufacturer_name = $_POST['inp_food_manufacturer_name'];
				$inp_food_manufacturer_name = output_html($inp_food_manufacturer_name);
				$inp_food_manufacturer_name_mysql = quote_smart($link, $inp_food_manufacturer_name);


				$inp_food_description = $_POST['inp_food_description'];
				$inp_food_description = output_html($inp_food_description);
				$inp_food_description_mysql = quote_smart($link, $inp_food_description);

				$inp_food_barcode = $_POST['inp_food_barcode'];
				$inp_food_barcode = output_html($inp_food_barcode);
				$inp_food_barcode_mysql = quote_smart($link, $inp_food_barcode);
	
				$inp_food_country = $_POST['inp_food_country'];
				$inp_food_country = output_html($inp_food_country);
				$inp_food_country_mysql = quote_smart($link, $inp_food_country);

				$inp_food_net_content = $_POST['inp_food_net_content'];
				if(empty($inp_food_net_content)){
					$inp_food_net_content = $_POST['inp_food_serving_size_gram'];
				}
				else{
					if(!(is_numeric($inp_food_net_content))){
						$inp_food_net_content = $_POST['inp_food_serving_size_gram'];
					}
				}
				$inp_food_net_content = output_html($inp_food_net_content);
				$inp_food_net_content = str_replace(",", ".", $inp_food_net_content);
				$inp_food_net_content_mysql = quote_smart($link, $inp_food_net_content);

				$inp_food_net_content_measurement = $_POST['inp_food_net_content_measurement'];
				$inp_food_net_content_measurement = output_html($inp_food_net_content_measurement);
				$inp_food_net_content_measurement_mysql = quote_smart($link, $inp_food_net_content_measurement);

				$inp_food_serving_size_gram = $_POST['inp_food_serving_size_gram'];
				$inp_food_serving_size_gram = output_html($inp_food_serving_size_gram);
				$inp_food_serving_size_gram = str_replace(",", ".", $inp_food_serving_size_gram);
				$inp_food_serving_size_gram_mysql = quote_smart($link, $inp_food_serving_size_gram);
				if(empty($inp_food_serving_size_gram)){
					$ft = "error";
					$fm = "missing_serving_size_gram";
				}
				else{
					if(!(is_numeric($inp_food_serving_size_gram))){
						$ft = "error";
						$fm = "food_serving_size_gram_is_not_numeric";
					}
				}

				$inp_food_serving_size_gram_measurement = $_POST['inp_food_serving_size_gram_measurement'];
				$inp_food_serving_size_gram_measurement = output_html($inp_food_serving_size_gram_measurement);
				$inp_food_serving_size_gram_measurement_mysql = quote_smart($link, $inp_food_serving_size_gram_measurement);
				if(empty($inp_food_serving_size_gram_measurement)){
					$ft = "error";
					$fm = "missing_serving_size_gram_measurement";
				}

				$inp_food_serving_size_pcs = $_POST['inp_food_serving_size_pcs'];
				$inp_food_serving_size_pcs = output_html($inp_food_serving_size_pcs);
				$inp_food_serving_size_pcs = str_replace(",", ".", $inp_food_serving_size_pcs);
				$inp_food_serving_size_pcs_mysql = quote_smart($link, $inp_food_serving_size_pcs);
				if(empty($inp_food_serving_size_pcs)){
					$ft = "error";
					$fm = "missing_serving_size_pcs";
				}
				else{
					if(!(is_numeric($inp_food_serving_size_pcs))){
						$ft = "error";
						$fm = "pcs_is_not_numeric";
					}
				}

				$inp_food_serving_size_pcs_measurement = $_POST['inp_food_serving_size_pcs_measurement'];
				$inp_food_serving_size_pcs_measurement = output_html($inp_food_serving_size_pcs_measurement);
				$inp_food_serving_size_pcs_measurement_mysql = quote_smart($link, $inp_food_serving_size_pcs_measurement);
				if(empty($inp_food_serving_size_pcs_measurement)){
					$ft = "error";
					$fm = "missing_serving_size_pcs_measurement";
				}


				$inp_age_restriction = $_POST['inp_age_restriction'];
				$inp_age_restriction = output_html($inp_age_restriction);
				$inp_age_restriction_mysql = quote_smart($link, $inp_age_restriction);



		// Category
		$inp_language = $_POST['inp_language'];
		$inp_language = strip_tags(stripslashes($inp_language));
		$inp_language_mysql = quote_smart($link, $inp_language);

		$inp_main_category_id = $_POST['inp_main_category_id'];
		$inp_main_category_id = strip_tags(stripslashes($inp_main_category_id));
		$inp_main_category_id_mysql = quote_smart($link, $inp_main_category_id);	

		$inp_sub_category_id = $_POST['inp_sub_category_id'];
		$inp_sub_category_id = strip_tags(stripslashes($inp_sub_category_id));
		$inp_sub_category_id_mysql = quote_smart($link, $inp_sub_category_id);	

		// Author
		$inp_author_user_name = $_POST['inp_author_user_name'];
		$inp_author_user_name = output_html($inp_author_user_name);
		$inp_author_user_name_mysql = quote_smart($link, $inp_author_user_name);

		$query = "SELECT user_id, user_email, user_name, user_alias FROM $t_users WHERE user_name=$inp_author_user_name_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_new_food_author_user_id, $get_new_food_author_user_email, $get_new_food_author_user_name, $get_new_food_author_user_alias) = $row;
		if($get_new_food_author_user_id == ""){
			$get_new_food_author_user_id = "0";
		}
					
		$result = mysqli_query($link, "UPDATE $t_food_index SET 
						food_user_id=$get_new_food_author_user_id,
						food_name=$inp_food_name_mysql, 
						food_clean_name=$inp_food_clean_name_mysql, 
						food_manufacturer_name=$inp_food_manufacturer_name_mysql, 
						food_description=$inp_food_description_mysql, 
						food_country=$inp_food_country_mysql,
						food_net_content=$inp_food_net_content_mysql, 
						food_net_content_measurement=$inp_food_net_content_measurement_mysql, 
						food_serving_size_gram=$inp_food_serving_size_gram_mysql, 
						food_serving_size_gram_measurement=$inp_food_serving_size_gram_measurement_mysql, 
						food_serving_size_pcs=$inp_food_serving_size_pcs_mysql, 
						food_serving_size_pcs_measurement=$inp_food_serving_size_pcs_measurement_mysql, 
						food_barcode=$inp_food_barcode_mysql,
						food_age_restriction=$inp_age_restriction_mysql,
						food_language=$inp_language_mysql,
						food_main_category_id=$inp_main_category_id_mysql,
						food_sub_category_id=$inp_sub_category_id_mysql

						 WHERE food_id=$food_id_mysql") or die(mysqli_error($link));


		// We changed size, so we need to update numbers
		if($inp_food_serving_size_gram != "$get_current_food_serving_size_gram"){
			if($get_current_food_energy != ""){
				$inp_food_energy_calculated = round($get_current_food_energy*$inp_food_serving_size_gram/100, 0);
			}
			else{
				$inp_food_energy_calculated = $get_current_food_energy_calculated;
			}

			if($get_current_food_fat != ""){
				$inp_food_fat_calculated = round($get_current_food_fat*$inp_food_serving_size_gram/100, 0);
			}
			else{
				$inp_food_fat_calculated = $get_current_food_fat_calculated;
			}

			if($get_current_food_fat_of_which_saturated_fatty_acids != ""){
				$inp_food_fat_of_which_saturated_fatty_acids_calculated = round($get_current_food_fat_of_which_saturated_fatty_acids*$inp_food_serving_size_gram/100, 0);
			}
			else{
				$inp_food_fat_of_which_saturated_fatty_acids_calculated = $get_current_food_fat_of_which_saturated_fatty_acids_calculated;
			}
			if($get_current_food_carbohydrates != ""){
				$inp_food_carbohydrates_calculated = round($get_current_food_carbohydrates*$inp_food_serving_size_gram/100, 0);
			}
			else{
				$inp_food_carbohydrates_calculated = $get_current_food_carbohydrates_calculated;
			}

			if($get_current_food_dietary_fiber != ""){
				$inp_food_dietary_fiber_calculated = round($get_current_food_dietary_fiber*$inp_food_serving_size_gram/100, 0);
			}
			else{
				$inp_food_dietary_fiber_calculated = $get_current_food_dietary_fiber_calculated;
			}

			if($get_current_food_carbohydrates_of_which_sugars != ""){
				$inp_food_carbohydrates_of_which_sugars_calculated = round($get_current_food_carbohydrates_of_which_sugars*$inp_food_serving_size_gram/100, 0);
			}
			else{
				$inp_food_carbohydrates_of_which_sugars_calculated = $get_current_food_carbohydrates_of_which_sugars_calculated;
			}
		
			if($get_current_food_proteins != ""){
				$inp_food_proteins_calculated = round($get_current_food_proteins*$inp_food_serving_size_gram/100, 0);
			}
			else{
				$inp_food_proteins_calculated = $get_current_food_proteins_calculated;
			}

			if($get_current_food_salt != ""){
				$inp_food_salt_calculated = round($get_current_food_salt*$inp_food_serving_size_gram/100, 0);
			}
			else{
				$inp_food_salt_calculated = $get_current_food_salt_calculated;
			}

			if($get_current_food_sodium != ""){
				$inp_food_sodium_calculated = round($get_current_food_sodium*$inp_food_serving_size_gram/100, 0);
			}
			else{
				$inp_food_sodium_calculated = $get_current_food_sodium_calculated;
			}
			if($inp_food_sodium_calculated == ""){
				$inp_food_sodium_calculated = 0;
			}



			$result = mysqli_query($link, "UPDATE $t_food_index SET food_energy_calculated='$inp_food_energy_calculated',
							food_proteins_calculated='$inp_food_proteins_calculated',
							food_salt_calculated='$inp_food_salt_calculated', 
							food_sodium_calculated='$inp_food_sodium_calculated',
							food_carbohydrates_calculated='$inp_food_carbohydrates_calculated',
							food_dietary_fiber_calculated='$inp_food_dietary_fiber_calculated',
							food_carbohydrates_of_which_sugars_calculated='$inp_food_carbohydrates_of_which_sugars_calculated',
							food_fat_calculated='$inp_food_fat_calculated',
							food_fat_of_which_saturated_fatty_acids_calculated='$inp_food_fat_of_which_saturated_fatty_acids_calculated'
							WHERE food_id='$get_current_food_id'") or die(mysqli_error($link));

		}


		// Countries
		if($inp_food_country != "$get_current_food_country"){
			$query_t = "SELECT food_country_id, food_country_count_food FROM $t_food_countries_used WHERE food_country_name=$inp_food_country_mysql";
			$result_t = mysqli_query($link, $query_t);
			$row_t = mysqli_fetch_row($result_t);
			list($get_food_country_id, $get_food_country_count_food) = $row_t;
			if($get_food_country_id == ""){
				// New food country
				mysqli_query($link, "INSERT INTO $t_food_countries_used 
				(food_country_id, food_country_name, food_country_count_food) 
				VALUES 
				(NULL, $inp_food_country_mysql, '1')")
				or die(mysqli_error($link));
			}
			else{
				$inp_count = $get_food_country_count_food+1;
				$result = mysqli_query($link, "UPDATE $t_food_countries_used SET food_country_count_food=$inp_count WHERE food_country_id=$get_food_country_id");
			}
		} // new country


		$url = "index.php?open=$open&page=edit_food_general_admin&main_category_id=$get_current_food_main_category_id&sub_category_id=$get_current_food_sub_category_id&food_id=$get_current_food_id&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
		header("Location: $url");
		exit;
	} // process == 1

	echo"
	<h1>$get_current_food_manufacturer_name $get_current_food_name</h1>

	<!-- Where am I ? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=$open&amp;page=default&amp;editor_language=$editor_language&amp;l=$l\">Food</a>
		&gt;
		<a href=\"index.php?open=$open&amp;page=default&amp;action=open_main_category&amp;main_category_id=$get_current_food_main_category_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_main_category_translation_value</a>
		&gt;
		<a href=\"index.php?open=$open&amp;page=default&amp;action=open_sub_category&amp;main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_sub_category_translation_value</a>
		&gt;
		<a href=\"index.php?open=$open&amp;page=open_food&amp;main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_food_manufacturer_name $get_current_food_name</a>
		</p>
	<!-- //Where am I ? -->

	<!-- Food Menu -->
		<div class=\"tabs\">
			<ul>
				<li><a href=\"index.php?open=$open&amp;page=open_food&amp;main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;editor_language=$editor_language&amp;l=$l\">View</a>
				<li><a href=\"index.php?open=$open&amp;page=edit_food_general_admin&amp;main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;editor_language=$editor_language&amp;l=$l\" class=\"active\">Edit</a>
				<li><a href=\"index.php?open=$open&amp;page=edit_food_numbers_admin&amp;main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;editor_language=$editor_language&amp;l=$l\">Numbers</a>
				<li><a href=\"index.php?open=$open&amp;page=edit_food_images_admin&amp;main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;editor_language=$editor_language&amp;l=$l\">Images</a>
				<li><a href=\"index.php?open=$open&amp;page=delete_food_admin&amp;main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;editor_language=$editor_language&amp;l=$l\">Delete</a>
			</ul>
		</div>
		<div class=\"clear\"></div>
	<!-- //Food Menu -->

	<!-- Feedback -->
	";
	if($ft != ""){
		if($fm == "changes_saved"){
			$fm = "$l_changes_saved";
		}
		else{
			$fm = ucfirst($ft);
		}
		echo"<div class=\"$ft\"><span>$fm</span></div>";
	}
	echo"	
	<!-- //Feedback -->

	<!-- Focus -->
		<script>
		\$(document).ready(function(){
			\$('[name=\"inp_food_name\"]').focus();
		});
		</script>
	<!-- //Focus -->

	<!-- Edit food general -->
		<form method=\"post\" action=\"index.php?open=$open&amp;page=edit_food_general_admin&amp;main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;editor_language=$editor_language&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\" id=\"my_form\">
			
		
		<!-- On change send form -->
			<script>
			\$(function(){
				\$('.on_change_submit_form').on('change', function () {
					\$(\"#my_form\").submit();

						return false;
				});
			});
			</script>
		<!-- //On change send form -->

		<!-- General -->
			<h2>General information</h2>
			
			<p><b>Name:</b><br />
			<input type=\"text\" name=\"inp_food_name\" value=\""; $get_current_food_name = str_replace("&amp;", "&", $get_current_food_name); echo"$get_current_food_name\" size=\"40\" />
			</p>

			<p><b>Manufacturer:</b><br />
			<input type=\"text\" name=\"inp_food_manufacturer_name\" value=\"$get_current_food_manufacturer_name\" size=\"40\" /></p>
			 
			<p><b>Description:</b><br />
			<input type=\"text\" name=\"inp_food_description\" value=\"$get_current_food_description\" size=\"40\" /></p>
			
			<p><b>Barcode:</b><br />
			<input type=\"text\" name=\"inp_food_barcode\" value=\"$get_current_food_barcode\" size=\"40\" /></p>
			
			<p><b>Country:</b><br />
			<select name=\"inp_food_country\">\n";
			$query = "SELECT language_flag FROM $t_languages ORDER BY language_flag ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_language_flag) = $row;
				$country = str_replace("_", " ", $get_language_flag);
				$country = ucwords($country);
				if($country != "$prev_country"){
					echo"			";
					echo"<option value=\"$country\""; if($get_current_food_country == "$country"){ echo" selected=\"selected\""; } echo">$country</option>\n";
				}
				$prev_country = "$country";
			}
			echo"
			</select></p>
			
			<p><b>Net content:</b><br />
			<input type=\"text\" name=\"inp_food_net_content\" value=\"$get_current_food_net_content\" size=\"3\" />
			<select name=\"inp_food_net_content_measurement\">
				<option value=\"g\""; if($get_current_food_net_content_measurement == "g"){ echo" selected=\"selected\""; } echo">g</option>
				<option value=\"ml\""; if($get_current_food_net_content_measurement == "ml"){ echo" selected=\"selected\""; } echo">ml</option>
			</select>
			</p>
			
			<p><b>Serving:</b><br />
			<input type=\"text\" name=\"inp_food_serving_size_gram\" value=\"$get_current_food_serving_size_gram\" size=\"3\" />
					
			<select name=\"inp_food_serving_size_gram_measurement\">
				<option value=\"g\""; if($get_current_food_serving_size_gram_measurement == "g"){ echo" selected=\"selected\""; } echo">g</option>
				<option value=\"ml\""; if($get_current_food_serving_size_gram_measurement == "ml"){ echo" selected=\"selected\""; } echo">ml</option>
			</select><br />
			<span class=\"smal\">Example g or ml</span>
			</p>
			
			<p><b>Serving pcs:</b><br />
			<input type=\"text\" name=\"inp_food_serving_size_pcs\" value=\"$get_current_food_serving_size_pcs\" size=\"3\" />
			<select name=\"inp_food_serving_size_pcs_measurement\">\n";
			// Get measurements
			$query = "SELECT measurement_id, measurement_name FROM $t_food_measurements ORDER BY measurement_name ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_measurement_id, $get_measurement_name) = $row;


				// Translation
				$query_translation = "SELECT measurement_translation_id, measurement_translation_value FROM $t_food_measurements_translations WHERE measurement_id=$get_measurement_id AND measurement_translation_language=$editor_language_mysql";
				$result_translation = mysqli_query($link, $query_translation);
				$row_translation = mysqli_fetch_row($result_translation);
				list($get_measurement_translation_id, $get_measurement_translation_value) = $row_translation;


				echo"				";
				echo"<option value=\"$get_measurement_translation_value\""; if($get_current_food_serving_size_pcs_measurement == "$get_measurement_translation_value"){ echo" selected=\"selected\""; } echo">$get_measurement_translation_value</option>\n";
			}
			echo"
			</select><br />
			<span class=\"smal\">Examples package, slice, pcs or plate</span>
			</p>
			
			<p><b>Age restriction:</b><br />
			<select name=\"inp_age_restriction\">
				<option value=\"0\""; if($get_current_food_age_restriction == "0"){ echo" selected=\"selected\""; } echo">$l_no</option>
				<option value=\"1\""; if($get_current_food_age_restriction == "1"){ echo" selected=\"selected\""; } echo">$l_yes</option>
			</select>
			<br />
			<em>Example alcohol</em></p>
			
		<!-- //General -->
		<!-- Category -->
			<h2>Category</h2>

			<p><b>Language:</b><br />
			<select name=\"inp_language\" class=\"on_change_submit_form\">\n";
			$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;
				echo"	<option value=\"$get_language_active_iso_two\"";if($get_current_food_language == "$get_language_active_iso_two"){ echo" selected=\"selected\"";}echo">$get_language_active_name</option>\n";
			}
			echo"
			</select>
			</p>
			
			<p><b>Main category:</b><br />
			<select name=\"inp_main_category_id\" class=\"on_change_submit_form\">\n";

			$query = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='0' ORDER BY category_name ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_main_category_id, $get_main_category_name, $get_main_category_parent_id) = $row;
				
				// Translation
				$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_main_category_id AND category_translation_language=$editor_language_mysql";
				$result_t = mysqli_query($link, $query_t);
				$row_t = mysqli_fetch_row($result_t);
				list($get_category_translation_value) = $row_t;

				echo"
				<option value=\"$get_main_category_id\""; if($get_main_category_id == "$get_current_food_main_category_id"){ echo" selected=\"selected\""; } echo">$get_category_translation_value</option>\n";
			}
			echo"
			</select>
			</p>
				
			<p><b>Sub category:</b><br />
			<select name=\"inp_sub_category_id\" class=\"on_change_submit_form\">\n";
			// Get all categories
			$food_main_category_id_mysql = quote_smart($link, $get_current_food_main_category_id);
			$query = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id=$food_main_category_id_mysql ORDER BY category_name ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_sub_category_id, $get_sub_category_name, $get_sub_category_parent_id) = $row;
				
				// Translation
				$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_sub_category_id AND category_translation_language=$editor_language_mysql";
				$result_t = mysqli_query($link, $query_t);
				$row_t = mysqli_fetch_row($result_t);
				list($get_category_translation_value) = $row_t;

				echo"
				<option value=\"$get_sub_category_id\""; if($get_sub_category_id == "$get_current_food_sub_category_id"){ echo" selected=\"selected\""; } echo">$get_category_translation_value</option>\n";
			}
			echo"
			</select>
			</p>

				
		<!-- //Category -->

		<!-- Author -->
			<h2>Author</h2>

			<p><b>User name:</b><br />
			<input type=\"text\" name=\"inp_author_user_name\" value=\"$get_current_food_author_user_name\" size=\"25\" />
			</p>


		<!-- //Author -->


		<p><input type=\"submit\" value=\"Save changes\" class=\"btn_default\" /></p>
		</form>
	<!-- //Edit food general -->
	";
} // food found
?>