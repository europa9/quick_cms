<?php 
/**
*
* File: food/new_food_6_numbers_other.php
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

		// Process
		if($process == "1"){
				// per 100 Metric
				$inp_food_energy = $_POST['inp_food_energy'];
				$inp_food_energy = output_html($inp_food_energy);
				$inp_food_energy = str_replace(",", ".", $inp_food_energy);
				$inp_food_energy_metric_mysql = quote_smart($link, $inp_food_energy);
				if($inp_food_energy == ""){
					$ft = "error";
					$fm = "missing_energy";
				}

				$inp_food_fat = $_POST['inp_food_fat'];
				$inp_food_fat = output_html($inp_food_fat);
				$inp_food_fat = str_replace(",", ".", $inp_food_fat);
				$inp_food_fat_metric_mysql = quote_smart($link, $inp_food_fat);
				if($inp_food_fat == ""){
					$ft = "error";
					$fm = "missing_fat";
				}

				$inp_food_saturated_fat = $_POST['inp_food_saturated_fat'];
				$inp_food_saturated_fat = output_html($inp_food_saturated_fat);
				$inp_food_saturated_fat = str_replace(",", ".", $inp_food_saturated_fat);
				$inp_food_saturated_fat_metric_mysql = quote_smart($link, $inp_food_saturated_fat);
				if($inp_food_saturated_fat == ""){
					$ft = "error";
					$fm = "missing_saturated_fat";
				}

				$inp_food_monounsaturated_fat = $_POST['inp_food_monounsaturated_fat'];
				$inp_food_monounsaturated_fat = output_html($inp_food_monounsaturated_fat);
				$inp_food_monounsaturated_fat = str_replace(",", ".", $inp_food_monounsaturated_fat);
				$inp_food_monounsaturated_fat_metric_mysql = quote_smart($link, $inp_food_monounsaturated_fat);
				if($inp_food_monounsaturated_fat == ""){
					$ft = "error";
					$fm = "missing_monounsaturated_fat";
				}

				$inp_food_polyunsaturated_fat = $_POST['inp_food_polyunsaturated_fat'];
				$inp_food_polyunsaturated_fat = output_html($inp_food_polyunsaturated_fat);
				$inp_food_polyunsaturated_fat = str_replace(",", ".", $inp_food_polyunsaturated_fat);
				$inp_food_polyunsaturated_fat_metric_mysql = quote_smart($link, $inp_food_polyunsaturated_fat);
				if($inp_food_polyunsaturated_fat == ""){
					$ft = "error";
					$fm = "missing_polyunsaturated_fat";
				}

				$inp_food_carbohydrates = $_POST['inp_food_carbohydrates'];
				$inp_food_carbohydrates = output_html($inp_food_carbohydrates);
				$inp_food_carbohydrates = str_replace(",", ".", $inp_food_carbohydrates);
				$inp_food_carbohydrates_metric_mysql = quote_smart($link, $inp_food_carbohydrates);
				if($inp_food_carbohydrates == ""){
					$ft = "error";
					$fm = "missing_carbohydrates";
				}


				$inp_food_dietary_fiber = $_POST['inp_food_dietary_fiber'];
				$inp_food_dietary_fiber = output_html($inp_food_dietary_fiber);
				$inp_food_dietary_fiber = str_replace(",", ".", $inp_food_dietary_fiber);
				$inp_food_dietary_fiber_metric_mysql = quote_smart($link, $inp_food_dietary_fiber);


				$inp_food_carbohydrates_of_which_sugars = $_POST['inp_food_carbohydrates_of_which_sugars'];
				$inp_food_carbohydrates_of_which_sugars = output_html($inp_food_carbohydrates_of_which_sugars);
				$inp_food_carbohydrates_of_which_sugars = str_replace(",", ".", $inp_food_carbohydrates_of_which_sugars);
				$inp_food_carbohydrates_of_which_sugars_metric_mysql = quote_smart($link, $inp_food_carbohydrates_of_which_sugars);
				if($inp_food_carbohydrates_of_which_sugars == ""){
					$ft = "error";
					$fm = "missing_of_which_sugars";
				}



				$inp_food_proteins = $_POST['inp_food_proteins'];
				$inp_food_proteins = output_html($inp_food_proteins);
				$inp_food_proteins = str_replace(",", ".", $inp_food_proteins);
				$inp_food_proteins_metric_mysql = quote_smart($link, $inp_food_proteins);
				if($inp_food_proteins == ""){
					$ft = "error";
					$fm = "missing_proteins";
				}


				$inp_food_salt = $_POST['inp_food_salt'];
				$inp_food_salt = output_html($inp_food_salt);
				$inp_food_salt = str_replace(",", ".", $inp_food_salt);
				$inp_food_salt_metric_mysql = quote_smart($link, $inp_food_salt);
				if($inp_food_salt == ""){
					$ft = "error";
					$fm = "missing_salt";
				}

				// Sodium is 40 % of salt
				$inp_food_sodium = ($inp_food_salt*40)/100; // g
				$inp_food_sodium = $inp_food_sodium*1000; // mg
				$inp_food_sodium_metric_mysql = quote_smart($link, $inp_food_sodium);

				
				$inp_food_cholesterol = $_POST['inp_food_cholesterol'];
				$inp_food_cholesterol = output_html($inp_food_cholesterol);
				$inp_food_cholesterol = str_replace(",", ".", $inp_food_cholesterol);
				$inp_food_cholesterol_metric_mysql = quote_smart($link, $inp_food_cholesterol);
				if($inp_food_cholesterol == ""){
					$ft = "error";
					$fm = "missing_cholesterol";
				}



			if($ft == ""){	

					// Calculated metric
					$inp_food_energy_calculated_metric = round($inp_food_energy*$get_current_food_serving_size_metric/100, 0);
					$inp_food_energy_calculated_metric_mysql = quote_smart($link, $inp_food_energy_calculated_metric);

					$inp_food_fat_calculated_metric = round($inp_food_fat*$get_current_food_serving_size_metric/100, 1);
					$inp_food_fat_calculated_metric_mysql = quote_smart($link, $inp_food_fat_calculated_metric);

					$inp_food_saturated_fat_calculated_metric = round($inp_food_saturated_fat*$get_current_food_serving_size_metric/100, 1);
					$inp_food_saturated_fat_calculated_metric_mysql = quote_smart($link, $inp_food_saturated_fat_calculated_metric);

					$inp_food_monounsaturated_fat_calculated_metric = round($inp_food_monounsaturated_fat*$get_current_food_serving_size_metric/100, 1);
					$inp_food_monounsaturated_fat_calculated_metric_mysql = quote_smart($link, $inp_food_monounsaturated_fat_calculated_metric);

					$inp_food_polyunsaturated_fat_calculated_metric = round($inp_food_polyunsaturated_fat*$get_current_food_serving_size_metric/100, 1);
					$inp_food_polyunsaturated_fat_calculated_metric_mysql = quote_smart($link, $inp_food_polyunsaturated_fat_calculated_metric);

					$inp_food_carbohydrates_calculated_metric = round($inp_food_carbohydrates*$get_current_food_serving_size_metric/100, 0);
					$inp_food_carbohydrates_calculated_metric_mysql = quote_smart($link, $inp_food_carbohydrates_calculated_metric);

					$inp_food_dietary_fiber_calculated_metric = round($inp_food_dietary_fiber*$get_current_food_serving_size_metric/100, 0);
					$inp_food_dietary_fiber_calculated_metric_mysql = quote_smart($link, $inp_food_dietary_fiber_calculated_metric);

					$inp_food_carbohydrates_of_which_sugars_calculated_metric = round($inp_food_carbohydrates_of_which_sugars*$get_current_food_serving_size_metric/100, 0);
					$inp_food_carbohydrates_of_which_sugars_calculated_metric_mysql = quote_smart($link, $inp_food_carbohydrates_of_which_sugars_calculated_metric);

					$inp_food_proteins_calculated_metric = round($inp_food_proteins*$get_current_food_serving_size_metric/100, 0);
					$inp_food_proteins_calculated_metric_mysql = quote_smart($link, $inp_food_proteins_calculated_metric);

					$inp_food_salt_calculated_metric = round($inp_food_salt*$get_current_food_serving_size_metric/100, 2);
					$inp_food_salt_calculated_metric_mysql = quote_smart($link, $inp_food_salt_calculated_metric);

					$inp_food_sodium_calculated_metric = round($inp_food_sodium*$get_current_food_serving_size_metric/100, 0);
					$inp_food_sodium_calculated_metric_mysql = quote_smart($link, $inp_food_sodium_calculated_metric);

					$inp_food_cholesterol_calculated_metric = round($inp_food_cholesterol*$get_current_food_serving_size_metric/100, 0);
					$inp_food_cholesterol_calculated_metric_mysql = quote_smart($link, $inp_food_cholesterol_calculated_metric);

	
					// per 8 US System
					if($get_current_food_serving_size_us == "0"){
						$inp_food_energy_us = 0;
					}
					else{
						$inp_food_energy_us = round(($inp_food_energy_calculated_metric/$get_current_food_serving_size_us)*8, 0);
					}
					$inp_food_energy_us_mysql = quote_smart($link, $inp_food_energy_us);

					if($get_current_food_serving_size_us == "0"){
						$inp_food_fat_us = 0;
					}
					else{
						$inp_food_fat_us = round(($inp_food_fat_calculated_metric/$get_current_food_serving_size_us)*8, 0);
					}
					$inp_food_fat_us_mysql = quote_smart($link, $inp_food_fat_us);
	
					if($get_current_food_serving_size_us == "0"){
						$inp_food_saturated_fat_us = 0;
					}
					else{
						$inp_food_saturated_fat_us = round(($inp_food_saturated_fat_calculated_metric/$get_current_food_serving_size_us)*8, 0);
					}
					$inp_food_saturated_fat_us_mysql = quote_smart($link, $inp_food_saturated_fat_us);

					if($get_current_food_serving_size_us == "0"){
						$inp_food_monounsaturated_fat_us = 0;
					}
					else{
						$inp_food_monounsaturated_fat_us = round(($inp_food_monounsaturated_fat_calculated_metric/$get_current_food_serving_size_us)*8, 0);
					}
					$inp_food_monounsaturated_fat_us_mysql = quote_smart($link, $inp_food_monounsaturated_fat_us);

					if($get_current_food_serving_size_us == "0"){
						$inp_food_polyunsaturated_fat_us = 0;
					}
					else{
						$inp_food_polyunsaturated_fat_us = round(($inp_food_polyunsaturated_fat_calculated_metric/$get_current_food_serving_size_us)*8, 0);
					}
					$inp_food_polyunsaturated_fat_us_mysql = quote_smart($link, $inp_food_polyunsaturated_fat_us);

					if($get_current_food_serving_size_us == "0"){
						$inp_food_carbohydrates_us  = 0;
					}
					else{
						$inp_food_carbohydrates_us  = round(($inp_food_carbohydrates_calculated_metric/$get_current_food_serving_size_us)*8, 0);
					}
					$inp_food_carbohydrates_us_mysql = quote_smart($link, $inp_food_carbohydrates_us);

					if($get_current_food_serving_size_us == "0"){
						$inp_food_dietary_fiber_us = 0;
					}
					else{
						$inp_food_dietary_fiber_us = round(($inp_food_dietary_fiber_calculated_metric/$get_current_food_serving_size_us)*8, 0);
					}
					$inp_food_dietary_fiber_us_mysql = quote_smart($link, $inp_food_dietary_fiber_us);

					if($get_current_food_serving_size_us == "0"){
						$inp_food_carbohydrates_of_which_sugars_us = 0;
					}
					else{
						$inp_food_carbohydrates_of_which_sugars_us = round(($inp_food_carbohydrates_of_which_sugars_calculated_metric/$get_current_food_serving_size_us)*8, 0);
					}
					$inp_food_carbohydrates_of_which_sugars_us_mysql = quote_smart($link, $inp_food_carbohydrates_of_which_sugars_us);

					if($get_current_food_serving_size_us == "0"){
						$inp_food_proteins_us = 0;
					}
					else{
						$inp_food_proteins_us = round(($inp_food_proteins_calculated_metric/$get_current_food_serving_size_us)*8, 0);
					}
					$inp_food_proteins_us_mysql = quote_smart($link, $inp_food_proteins_us);

					if($get_current_food_serving_size_us == "0"){
						$inp_food_salt_us = 0;
					}
					else{
						$inp_food_salt_us = round(($inp_food_salt_calculated_metric/$get_current_food_serving_size_us)*8, 2);
					}
					$inp_food_salt_us_mysql = quote_smart($link, $inp_food_salt_us);

					if($get_current_food_serving_size_us == "0"){
						$inp_food_sodium_us = 0;
					}
					else{
						$inp_food_sodium_us = round(($inp_food_sodium_calculated_metric/$get_current_food_serving_size_us)*8, 0);
					}
					$inp_food_sodium_us_mysql = quote_smart($link, $inp_food_sodium_us);

					if($get_current_food_serving_size_us == "0"){
						$inp_food_cholesterol_us = 0;
					}
					else{
						$inp_food_cholesterol_us = round(($inp_food_cholesterol_calculated_metric/$get_current_food_serving_size_us)*8, 0);
					}
					$inp_food_cholesterol_us_mysql = quote_smart($link, $inp_food_cholesterol_us);


	
					// Calculated US System
					// Calculated US is the same as calculated metric

					// Calculate net content
					$inp_food_energy_net_content	   = round(($get_current_food_net_content_metric*$inp_food_energy)/100, 0);
					$inp_food_energy_net_content_mysql = quote_smart($link, $inp_food_energy_net_content);

					$inp_food_fat_net_content 	= round(($get_current_food_net_content_metric*$inp_food_fat)/100, 1);
					$inp_food_fat_net_content_mysql = quote_smart($link, $inp_food_fat_net_content);

	  				$inp_food_saturated_fat_net_content 	  = round(($get_current_food_net_content_metric*$inp_food_saturated_fat)/100, 1);
					$inp_food_saturated_fat_net_content_mysql = quote_smart($link, $inp_food_saturated_fat_net_content);

	  				$inp_food_monounsaturated_fat_net_content	= round(($get_current_food_net_content_metric*$inp_food_monounsaturated_fat)/100, 1);
					$inp_food_monounsaturated_fat_net_content_mysql = quote_smart($link, $inp_food_monounsaturated_fat_net_content);

	  				$inp_food_polyunsaturated_fat_net_content 	= round(($get_current_food_net_content_metric*$inp_food_polyunsaturated_fat)/100, 1);
					$inp_food_polyunsaturated_fat_net_content_mysql = quote_smart($link, $inp_food_polyunsaturated_fat_net_content);

	  				$inp_food_cholesterol_net_content	= round(($get_current_food_net_content_metric*$inp_food_cholesterol)/100, 1);
					$inp_food_cholesterol_net_content_mysql = quote_smart($link, $inp_food_cholesterol_net_content);

	 				$inp_food_carbohydrates_net_content 	  = round(($get_current_food_net_content_metric*$inp_food_carbohydrates)/100, 1);
					$inp_food_carbohydrates_net_content_mysql = quote_smart($link, $inp_food_carbohydrates_net_content);

	  				$inp_food_carbohydrates_of_which_sugars_net_content 	  = round(($get_current_food_net_content_metric*$inp_food_carbohydrates_of_which_sugars)/100, 1);
					$inp_food_carbohydrates_of_which_sugars_net_content_mysql = quote_smart($link, $inp_food_carbohydrates_of_which_sugars_net_content);

	  				$inp_food_dietary_fiber_net_content 		= round(($get_current_food_net_content_metric*$inp_food_dietary_fiber)/100, 1);
					$inp_food_dietary_fiber_net_content_mysql 	= quote_smart($link, $inp_food_dietary_fiber_net_content);

	 				$inp_food_proteins_net_content       = round(($get_current_food_net_content_metric*$inp_food_proteins)/100, 1);
					$inp_food_proteins_net_content_mysql = quote_smart($link, $inp_food_proteins_net_content);

	  				$inp_food_salt_net_content       = round(($get_current_food_net_content_metric*$inp_food_salt)/100, 1);
					$inp_food_salt_net_content_mysql = quote_smart($link, $inp_food_salt_net_content);

	  				$inp_food_sodium_net_content       = round(($get_current_food_net_content_metric*$inp_food_sodium)/100, 0);
					$inp_food_sodium_net_content_mysql = quote_smart($link, $inp_food_sodium_net_content);

	
					// Score
					$inp_total = $inp_food_energy + $inp_food_fat + $inp_food_saturated_fat + $inp_food_carbohydrates + $inp_food_dietary_fiber + $inp_food_carbohydrates_of_which_sugars + $inp_food_proteins + $inp_food_salt;
					$inp_calculation = ($inp_food_energy * 1) + 
				  		   	   ($inp_food_fat * 13) +  
				  		   	   ($inp_food_saturated_fat * 1) + 
				    		 	   ($inp_food_carbohydrates * 44) +
				     			   ($inp_food_dietary_fiber * 1) +
				    			   ($inp_food_carbohydrates_of_which_sugars * 1) +
				    			   ($inp_food_proteins * 43) +
				     			   ($inp_food_salt * 1);

						if($inp_total == "0"){
							$inp_score = "0";
						}
						else{
							$inp_score = round($inp_calculation / $inp_total, 0);
						}
						$inp_score_mysql = quote_smart($link, $inp_score);

			

					// Update
					$result = mysqli_query($link, "UPDATE $t_food_index SET 
								food_energy_metric=$inp_food_energy_metric_mysql, 
								food_fat_metric=$inp_food_fat_metric_mysql, 
								food_saturated_fat_metric=$inp_food_saturated_fat_metric_mysql, 
								food_monounsaturated_fat_metric=$inp_food_monounsaturated_fat_metric_mysql, 
								food_polyunsaturated_fat_metric=$inp_food_polyunsaturated_fat_metric_mysql, 
								food_cholesterol_metric=$inp_food_cholesterol_metric_mysql, 
								food_carbohydrates_metric=$inp_food_carbohydrates_metric_mysql, 
								food_dietary_fiber_metric=$inp_food_dietary_fiber_metric_mysql, 
								food_carbohydrates_of_which_sugars_metric=$inp_food_carbohydrates_of_which_sugars_metric_mysql, 
								food_proteins_metric=$inp_food_proteins_metric_mysql, 
								food_salt_metric=$inp_food_salt_metric_mysql, 
								food_sodium_metric=$inp_food_sodium_metric_mysql, 

								food_energy_us=$inp_food_energy_us_mysql, 
								food_fat_us=$inp_food_fat_us_mysql, 
								food_saturated_fat_us=$inp_food_saturated_fat_us_mysql, 
								food_monounsaturated_fat_us=$inp_food_monounsaturated_fat_us_mysql, 
								food_polyunsaturated_fat_us=$inp_food_polyunsaturated_fat_us_mysql, 
								food_cholesterol_us=$inp_food_cholesterol_us_mysql, 
								food_carbohydrates_us=$inp_food_carbohydrates_us_mysql, 
								food_dietary_fiber_us=$inp_food_dietary_fiber_us_mysql, 
								food_carbohydrates_us=$inp_food_carbohydrates_us_mysql, 
								food_dietary_fiber_us=$inp_food_dietary_fiber_us_mysql, 
								food_carbohydrates_of_which_sugars_us=$inp_food_carbohydrates_of_which_sugars_us_mysql, 
								food_proteins_us=$inp_food_proteins_us_mysql, 
								food_salt_us=$inp_food_salt_us_mysql, 
								food_sodium_us=$inp_food_sodium_us_mysql, 

								food_score=$inp_score_mysql, 

								food_energy_calculated_metric=$inp_food_energy_calculated_metric_mysql, 
								food_fat_calculated_metric=$inp_food_fat_calculated_metric_mysql,
								food_saturated_fat_calculated_metric=$inp_food_saturated_fat_calculated_metric_mysql,
								food_monounsaturated_fat_calculated_metric=$inp_food_monounsaturated_fat_calculated_metric_mysql,
								food_polyunsaturated_fat_calculated_metric=$inp_food_polyunsaturated_fat_calculated_metric_mysql,
								food_cholesterol_calculated_metric=$inp_food_cholesterol_calculated_metric_mysql,
								food_carbohydrates_calculated_metric=$inp_food_carbohydrates_calculated_metric_mysql,
								food_dietary_fiber_calculated_metric=$inp_food_dietary_fiber_calculated_metric_mysql, 
								food_carbohydrates_of_which_sugars_calculated_metric=$inp_food_carbohydrates_of_which_sugars_calculated_metric_mysql,
								food_proteins_calculated_metric=$inp_food_proteins_calculated_metric_mysql,
								food_salt_calculated_metric=$inp_food_salt_calculated_metric_mysql,
								food_sodium_calculated_metric=$inp_food_sodium_calculated_metric_mysql,

								food_energy_calculated_us=$inp_food_energy_calculated_metric_mysql, 
								food_fat_calculated_us=$inp_food_fat_calculated_metric_mysql, 
								food_saturated_fat_calculated_us=$inp_food_saturated_fat_calculated_metric_mysql, 
								food_monounsaturated_fat_calculated_us=$inp_food_monounsaturated_fat_calculated_metric_mysql, 
								food_polyunsaturated_fat_calculated_us=$inp_food_polyunsaturated_fat_calculated_metric_mysql, 
								food_cholesterol_calculated_us=$inp_food_cholesterol_calculated_metric_mysql, 
								food_carbohydrates_calculated_us=$inp_food_carbohydrates_calculated_metric_mysql, 
								food_dietary_fiber_calculated_us=$inp_food_dietary_fiber_calculated_metric_mysql, 
								food_carbohydrates_of_which_sugars_calculated_us=$inp_food_carbohydrates_of_which_sugars_calculated_metric_mysql, 
								food_proteins_calculated_us=$inp_food_proteins_calculated_metric_mysql, 
								food_salt_calculated_us=$inp_food_salt_calculated_metric_mysql, 
								food_sodium_calculated_us=$inp_food_sodium_calculated_metric_mysql,

								food_energy_net_content=$inp_food_energy_net_content_mysql,
								food_fat_net_content=$inp_food_fat_net_content_mysql,
								food_saturated_fat_net_content=$inp_food_monounsaturated_fat_net_content_mysql,
								food_monounsaturated_fat_net_content=$inp_food_monounsaturated_fat_net_content_mysql, 
								food_polyunsaturated_fat_net_content=$inp_food_polyunsaturated_fat_net_content_mysql, 
								food_cholesterol_net_content=$inp_food_cholesterol_net_content_mysql,
								food_carbohydrates_net_content=$inp_food_carbohydrates_net_content_mysql,
								food_carbohydrates_of_which_sugars_net_content=$inp_food_carbohydrates_of_which_sugars_net_content_mysql,
								food_dietary_fiber_net_content=$inp_food_dietary_fiber_net_content_mysql,
								food_proteins_net_content=$inp_food_proteins_net_content_mysql,
								food_salt_net_content=$inp_food_salt_net_content_mysql,
								food_sodium_net_content=$inp_food_sodium_net_content_mysql

								 WHERE food_id='$get_current_food_id'") or print(mysqli_error());



				// Header
				$url = "new_food_8_tags.php?main_category_id=$main_category_id&sub_category_id=$sub_category_id&food_id=$get_current_food_id&el=$l";
				header("Location: $url");
				exit;
			}
			else{
				$url = "new_food_7_numbers_hundred_metric.php?main_category_id=$main_category_id&sub_category_id=$sub_category_id&food_id=$get_current_food_id&l=$l";
				$url = $url . "&ft=$ft&fm=$fm";
				$url = $url . "&inp_food_energy=$inp_food_energy";
				$url = $url . "&inp_food_proteins=$inp_food_proteins";
				$url = $url . "&inp_food_carbohydrates=$inp_food_carbohydrates";
				$url = $url . "&inp_food_fat=$inp_food_fat";
				header("Location: $url");
				exit;
			}
		}


		echo"
		<h1>$get_current_food_manufacturer_name $get_current_food_name</h1>
		<!-- Feedback -->
				";
				if($ft != "" && $fm != ""){
					if($fm == "missing_energy"){
						$fm = "Please enter energy";
					}
					elseif($fm == "missing_proteins"){
						$fm = "Please enter proteins";
					}
					elseif($fm == "missing_carbohydrates"){
						$fm = "Please enter carbohydrates";
					}
					elseif($fm == "missing_fat"){
						$fm = "Please enter fat";
					}
					else{
						$fm = ucfirst($fm);
					}
					echo"<div class=\"$ft\"><p>$fm</p></div>";	
				}
				echo"

		<!-- //Feedback -->

		<!-- General information -->
			<!-- Focus -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_food_energy\"]').focus();
				});
				</script>
			<!-- //Focus -->

			<!-- Headline and system -->
				<table>
				 <tr>
				  <td style=\"padding: 0px 4px 0px 0px;\">
					<h2>$l_numbers</h2>
				  </td>
				  <td>
					<span>
					<a href=\"new_food_7_numbers_hundred_metric.php?food_id=$food_id&amp;l=$l\" style=\"font-weight:bold;\">$l_metric</a>
					&middot;
					<a href=\"new_food_7_numbers_pcs_us.php?food_id=$food_id&amp;l=$l\">$l_us</a>
					</span>
				  </td>
				 </tr>
				</table>
			<!-- //Headline and system -->
				
			
			<!-- Img -->
				<div style=\"float: left;margin-top: 20px;\">
					";
					if(file_exists("../$get_current_food_image_path/$get_current_food_image_b")){
						echo"<a href=\"../$get_current_food_image_path/$get_current_food_image_b\"><img src=\"../$get_current_food_image_path/$get_current_food_image_b\" alt=\"$get_current_food_image_b\" width=\"500\" height=\"500\" style=\"padding-right: 20px;\" /></a>";
					}
					echo"
				</div>
			<!-- //Img -->

			<!-- Numbers -->
				<div style=\"float: left;\">
					<form method=\"post\" action=\"new_food_7_numbers_hundred_metric.php?main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
		
					<!-- Measurement -->
						<p>
						$l_measurement:
						<a href=\"new_food_7_numbers_hundred_metric.php??main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;l=$l\" style=\"font-weight:bold;\">$l_per_hundred</a>
						&middot;
						<a href=\"new_food_7_numbers_pcs_metric.php??main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;l=$l\">$get_current_food_serving_size_pcs $get_current_food_serving_size_pcs_measurement</a>
						</p>
					<!-- //Measurement -->


					<table class=\"hor-zebra\" style=\"width: 350px\">
					 <thead>
					  <tr>
					   <th scope=\"col\">
					   </th>
					   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;vertical-align: bottom;\">
						<span>$l_per_100</span>
					   </th>
					   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;vertical-align: bottom;\">
						<span>$l_serving<br />$get_current_food_serving_size_metric $get_current_food_serving_size_measurement_metric ($get_current_food_serving_size_pcs $get_current_food_serving_size_pcs_measurement)</span>
					   </th>
					  </tr>
					 </thead>
					 <tbody>
					  <tr>
					   <td style=\"padding: 8px 4px 6px 8px;\">
						<span>$l_calories</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span><input type=\"text\" name=\"inp_food_energy\" value=\"$get_current_food_energy_metric\" size=\"3\" /></span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span class=\"food_energy_calculated\">$get_current_food_energy_calculated_metric</span>

						<!-- On change energy calculate -->
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_food_energy\"]').on(\"change paste keyup\", function() {
								var energy_hundred = $('[name=\"inp_food_energy\"]').val();
								energy_hundred = energy_hundred.replace(\",\", \".\");
								energy_calculated = Math.round((energy_hundred*$get_current_food_serving_size_metric)/100);
								\$(\".food_energy_calculated\").text(energy_calculated);
							});
						});
						</script>
						<!-- On change energy calculate -->
					   </td>
					  </tr>
					  <tr>
					   <td style=\"padding: 8px 4px 6px 8px;\">
						<p style=\"margin:0;padding: 0px 0px 4px 0px;\">$l_fat:</p>
						<p style=\"margin:0;padding: 0;\">$l_dash_saturated_fat</p>
						<p style=\"margin:0;padding: 0;\">$l_dash_monounsaturated_fat</p>
						<p style=\"margin:0;padding: 0;\">$l_dash_polyunsaturated_fat</p>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_food_fat\" value=\"$get_current_food_fat_metric\" size=\"3\" /><br /></p>
						<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_food_saturated_fat\" value=\"$get_current_food_saturated_fat_metric\" size=\"3\" /></p>
						<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_food_monounsaturated_fat\" value=\"$get_current_food_monounsaturated_fat_metric\" size=\"3\" /></p>
						<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_food_polyunsaturated_fat\" value=\"$get_current_food_polyunsaturated_fat_metric\" size=\"3\" /></p>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><span class=\"food_fat_calculated\">$get_current_food_fat_calculated_metric</span><br />
						<span class=\"food_saturated_fat_calculated\">$get_current_food_saturated_fat_calculated_metric</span><br />
						<span class=\"food_monounsaturated_fat_calculated\">$get_current_food_monounsaturated_fat_calculated_metric</span><br />
						<span class=\"food_polyunsaturated_fat_calculated\">$get_current_food_polyunsaturated_fat_calculated_metric</span></p>

						<!-- On change fat calculate -->
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_food_fat\"]').on(\"change paste keyup\", function() {
								var fat_hundred = $('[name=\"inp_food_fat\"]').val();
								fat_hundred = fat_hundred.replace(\",\", \".\");
								fat_calculated = Math.round((fat_hundred*$get_current_food_serving_size_metric)/100);
								\$(\".food_fat_calculated\").text(fat_calculated);
							});
							\$('[name=\"inp_food_saturated_fat\"]').on(\"change paste keyup\", function() {
								var input_b = $('[name=\"inp_food_saturated_fat\"]').val();
								input_b = input_b.replace(\",\", \".\");
								output_b = Math.round((input_b*$get_current_food_serving_size_metric)/100);
								\$(\".food_saturated_fat_calculated\").text(output_b);
							});
							\$('[name=\"inp_food_monounsaturated_fat\"]').on(\"change paste keyup\", function() {
								var input_c = $('[name=\"inp_food_monounsaturated_fat\"]').val();
								input_c = input_c.replace(\",\", \".\");
								output_c = Math.round((input_c*$get_current_food_serving_size_metric)/100);
								\$(\".food_monounsaturated_fat_calculated\").text(output_c);
							});
							\$('[name=\"inp_food_polyunsaturated_fat\"]').on(\"change paste keyup\", function() {
								var input_d = $('[name=\"inp_food_polyunsaturated_fat\"]').val();
								input_d = input_d.replace(\",\", \".\");
								output_d = Math.round((input_d*$get_current_food_serving_size_metric)/100);
								\$(\".food_polyunsaturated_fat_calculated\").text(output_d);
							});
						});
						</script>
						<!-- On change fat calculate -->
					   </td>
					 </tr>


					 <tr>
		 			  <td style=\"padding: 8px 4px 6px 8px;\">
						<p style=\"margin:0;padding: 0px 0px 4px 0px;\">$l_carbs:</p>
						<p style=\"margin:0;padding: 0;\">$l_dash_of_which_sugars</p>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_food_carbohydrates\" value=\"$get_current_food_carbohydrates_metric\" size=\"3\" /></p>
						<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_food_carbohydrates_of_which_sugars\" value=\"$get_current_food_carbohydrates_of_which_sugars_metric\" size=\"3\" /></p>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><span class=\"food_carbohydrates_calculated\">$get_current_food_carbohydrates_calculated_metric</span><br />
						<span class=\"food_carbohydrates_of_which_sugars_calculated\">$get_current_food_carbohydrates_of_which_sugars_calculated_metric</span></p>

						<!-- On change fat calculate -->
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_food_carbohydrates\"]').on(\"change paste keyup\", function() {
								var food_carbohydrates_hundred = $('[name=\"inp_food_carbohydrates\"]').val();
								food_carbohydrates_hundred = food_carbohydrates_hundred.replace(\",\", \".\");
								food_carbohydrates_calculated = Math.round((food_carbohydrates_hundred*$get_current_food_serving_size_metric)/100);
								\$(\".food_carbohydrates_calculated\").text(food_carbohydrates_calculated);
							});
							\$('[name=\"inp_food_carbohydrates_of_which_sugars\"]').on(\"change paste keyup\", function() {
								var food_carbohydrates_of_which_sugars_hundred = $('[name=\"inp_food_carbohydrates_of_which_sugars\"]').val();
								food_carbohydrates_of_which_sugars_hundred = food_carbohydrates_of_which_sugars_hundred.replace(\",\", \".\");
								food_carbohydrates_of_which_sugars_calculated = Math.round((food_carbohydrates_of_which_sugars_hundred*$get_current_food_serving_size_metric)/100);
								\$(\".food_carbohydrates_of_which_sugars_calculated\").text(food_carbohydrates_of_which_sugars_calculated);
							});
						});
						</script>
						<!-- On change fat calculate -->
			 		  </td>
					  </tr>
					 <tr>
		 			  <td style=\"padding: 8px 4px 6px 8px;\">
						<p style=\"margin:0;padding: 0;\">$l_dietary_fiber:</p>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<p style=\"margin:0px 0px 4px 0px;padding: 0;\"><input type=\"text\" name=\"inp_food_dietary_fiber\" value=\"$get_current_food_dietary_fiber_metric\" size=\"3\" /></p>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span class=\"food_dietary_fiber_calculated\">$get_current_food_dietary_fiber_calculated_metric</span>

						<!-- On change dietary fiber calculate -->
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_food_dietary_fiber\"]').on(\"change paste keyup\", function() {
								var food_dietary_fiber_hundred = $('[name=\"inp_food_dietary_fiber\"]').val();
								food_dietary_fiber_hundred = food_dietary_fiber_hundred.replace(\",\", \".\");
								food_dietary_fiber_calculated = Math.round((food_dietary_fiber_hundred*$get_current_food_serving_size_metric)/100);
								\$(\".food_dietary_fiber_calculated\").text(food_dietary_fiber_calculated);
							});
						});
						</script>
						<!-- On change dietary fiber calculate -->
					   </td>
					  </tr>
					  <tr>
					   <td style=\"padding: 8px 4px 6px 8px;\">
						<span>$l_protein:</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span><input type=\"text\" name=\"inp_food_proteins\" value=\"$get_current_food_proteins_metric\" size=\"3\" /></span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span class=\"food_proteins_calculated\">$get_current_food_proteins_calculated_metric</span>
						<!-- On change protein calculate -->
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_food_proteins\"]').on(\"change paste keyup\", function() {
								var food_proteins_hundred = $('[name=\"inp_food_proteins\"]').val();
								food_proteins_hundred = food_proteins_hundred.replace(\",\", \".\");
								food_proteins_calculated = Math.round((food_proteins_hundred*$get_current_food_serving_size_metric)/100);
								\$(\".food_proteins_calculated\").text(food_proteins_calculated);
							});
						});
						</script>
						<!-- On change protein calculate -->
					   </td>
					  </tr>
					 </tr>
					  <tr>
					   <td style=\"padding: 8px 4px 6px 8px;\">
						<span>$l_salt_in_gram</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span><input type=\"text\" name=\"inp_food_salt\" value=\"$get_current_food_salt_metric\" size=\"3\" /></span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span class=\"food_salt_calculated\">$get_current_food_salt_calculated_metric</span>
						<!-- On change salt calculate -->
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_food_salt\"]').on(\"change paste keyup\", function() {

								// Calculate salt pr pc
								var food_salt_hundred = \$('[name=\"inp_food_salt\"]').val();
								food_salt_hundred = food_salt_hundred.replace(\",\", \".\");
								food_salt_calculated = (food_salt_hundred*$get_current_food_serving_size_metric)/100;
								food_salt_calculated = food_salt_calculated.toFixed(2)
								\$(\".food_salt_calculated\").text(food_salt_calculated);

								// Calculate sodium (Sodium is 40 % of salt)
								food_sodium_hundred = (food_salt_hundred*40)/100; // g
								food_sodium_hundred = food_sodium_hundred*1000; // mg
								food_sodium_calculated = Math.round((food_sodium_hundred*$get_current_food_serving_size_metric)/100);
								\$(\".food_sodium_calculated\").text(food_sodium_calculated);
								\$('[name=\"inp_food_sodium\"]').val(Math.round(food_sodium_hundred));
							});
						});
						</script>
						<!-- On change salt calculate -->
					   </td>
					  </tr>
					  <tr>
					   <td style=\"padding: 8px 4px 6px 8px;\">
						<span>$l_sodium_in_mg</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span><input type=\"text\" name=\"inp_food_sodium\" value=\"$get_current_food_sodium_metric\" size=\"3\" /></span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span class=\"food_sodium_calculated\">$get_current_food_sodium_calculated_metric</span>
						<!-- On change sodium calculate -->
							<script>
							\$(document).ready(function(){
								\$('[name=\"inp_food_sodium\"]').on(\"change paste keyup\", function() {
									var food_sodium_hundred = \$('[name=\"inp_food_sodium\"]').val();
									food_sodium_hundred = food_sodium_hundred.replace(\",\", \".\");
									food_sodium_calculated = (food_sodium_hundred*$get_current_food_serving_size_metric)/100;
									food_sodium_calculated = food_sodium_calculated.toFixed(2)
									\$(\".food_sodium_calculated\").text(food_sodium_calculated);
						
								});
							});
							</script>
						<!-- On change sodium calculate -->
					   </td>
					  </tr>

					  <tr>
					   <td style=\"padding: 8px 4px 6px 8px;\">
						<span>$l_cholesterol_in_mg</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span><input type=\"text\" name=\"inp_food_cholesterol\" value=\"$get_current_food_cholesterol_metric\" size=\"3\" /></span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span class=\"food_cholesterol_calculated\">$get_current_food_cholesterol_calculated_metric</span>

						<!-- On change cholesterol calculate -->
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_food_cholesterol\"]').on(\"change paste keyup\", function() {
								var input = $('[name=\"inp_food_cholesterol\"]').val();
								input = input.replace(\",\", \".\");
								output = Math.round((input*$get_current_food_serving_size_metric)/100);
								\$(\".food_cholesterol_calculated\").text(output);
							});
						});
						</script>
						<!-- On change cholesterol calculate -->
					   </td>
					  </tr>
					 </tbody>
					</table>

					<p><input type=\"submit\" value=\"$l_save\" class=\"btn btn-success btn-sm\" /></p>
				</div>
				<div class=\"clear\"></div>
			<!-- //Numbers -->

		<!-- //General information -->

		";
	} // mode == ""
}
else{
	echo"
	<h1>
	<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/index.php?page=login&amp;l=$l&amp;refer=$root/food/new_food.php\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>