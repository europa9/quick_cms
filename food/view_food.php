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

/*- Get extention ---------------------------------------------------------------------- */
function getExtension($str) {
	$i = strrpos($str,".");
	if (!$i) { return ""; } 
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	return $ext;
}

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
	$food_id_mysql = quote_smart($link, $food_id);
}
else{
	$food_id = "";
}






// Select food
$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_country, food_net_content, food_net_content_measurement, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_fat, food_fat_of_which_saturated_fatty_acids, food_carbohydrates, food_carbohydrates_of_which_dietary_fiber, food_carbohydrates_of_which_sugars, food_proteins, food_salt, food_sodium, food_score, food_energy_calculated, food_fat_calculated, food_fat_of_which_saturated_fatty_acids_calculated, food_carbohydrates_calculated, food_carbohydrates_of_which_dietary_fiber_calculated, food_carbohydrates_of_which_sugars_calculated, food_proteins_calculated, food_salt_calculated, food_sodium_calculated, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_thumb_a_medium, food_thumb_a_large, food_image_b, food_thumb_b_small, food_thumb_b_medium, food_thumb_b_large, food_image_c, food_thumb_c_small, food_thumb_c_medium, food_thumb_c_large, food_image_d, food_thumb_d_small, food_thumb_d_medium, food_thumb_d_large, food_image_e, food_thumb_e_small, food_thumb_e_medium, food_thumb_e_large, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_created_date, food_last_viewed, food_age_restriction FROM $t_food_index WHERE food_id=$food_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_manufacturer_name_and_food_name, $get_food_description, $get_food_country, $get_food_net_content, $get_food_net_content_measurement, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_fat, $get_food_fat_of_which_saturated_fatty_acids, $get_food_carbohydrates, $get_food_carbohydrates_of_which_dietary_fiber, $get_food_carbohydrates_of_which_sugars, $get_food_proteins, $get_food_salt, $get_food_sodium, $get_food_score, $get_food_energy_calculated, $get_food_fat_calculated, $get_food_fat_of_which_saturated_fatty_acids_calculated, $get_food_carbohydrates_calculated, $get_food_carbohydrates_of_which_dietary_fiber_calculated, $get_food_carbohydrates_of_which_sugars_calculated, $get_food_proteins_calculated, $get_food_salt_calculated, $get_food_sodium_calculated, $get_food_barcode, $get_food_main_category_id, $get_food_sub_category_id, $get_food_image_path, $get_food_image_a, $get_food_thumb_a_small, $get_food_thumb_a_medium, $get_food_thumb_a_large, $get_food_image_b, $get_food_thumb_b_small, $get_food_thumb_b_medium, $get_food_thumb_b_large, $get_food_image_c, $get_food_thumb_c_small, $get_food_thumb_c_medium, $get_food_thumb_c_large, $get_food_image_d, $get_food_thumb_d_small, $get_food_thumb_d_medium, $get_food_thumb_d_large, $get_food_image_e, $get_food_thumb_e_small, $get_food_thumb_e_medium, $get_food_thumb_e_large, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block, $get_food_user_ip, $get_food_created_date, $get_food_last_viewed, $get_food_age_restriction) = $row;

if($get_food_id == ""){
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
	$website_title = "$l_food - $get_food_name $get_food_manufacturer_name";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");


	// Last viewed
	$datetime = date("Y-m-d H:i:s");
	$result = mysqli_query($link, "UPDATE $t_food_index SET food_last_viewed='$datetime' WHERE food_id='$get_food_id'") or die(mysqli_error($link));

	// Author
	$query = "SELECT user_id, user_email, user_name, user_alias FROM $t_users WHERE user_id=$get_food_user_id";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_food_author_user_id, $get_food_author_user_email, $get_food_author_user_name, $get_food_author_user_alias) = $row;
	if($get_food_author_user_id == ""){
		$result = mysqli_query($link, "UPDATE $t_food_index SET food_user_id='1' WHERE food_id='$get_food_id'") or die(mysqli_error($link));
	}


	// Get sub category
	$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$get_food_sub_category_id";
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
		$result = mysqli_query($link, "UPDATE $t_food_index SET food_sub_category_id='$get_current_sub_category_id' WHERE food_id='$get_food_id'") or die(mysqli_error($link));
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
		if($get_current_main_category_id != "$get_food_main_category_id"){
			echo"<div class=\"info\"><p>Updated food main category id</p></div>\n";
			$result = mysqli_query($link, "UPDATE $t_food_index SET food_main_category_id='$get_current_main_category_id' WHERE food_id='$get_food_id'") or die(mysqli_error($link));
		}
	}

	// Translation
	$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_current_main_category_id AND category_translation_language=$l_mysql";
	$result_t = mysqli_query($link, $query_t);
	$row_t = mysqli_fetch_row($result_t);
	list($get_current_main_category_translation_value) = $row_t;

	// Sub category translation
	$query_t = "SELECT category_translation_id, category_id, category_translation_language, category_translation_value, category_translation_no_food, category_translation_last_updated, category_calories_min, category_calories_med, category_calories_max, category_fat_min, category_fat_med, category_fat_max, category_fat_of_which_saturated_fatty_acids_min, category_fat_of_which_saturated_fatty_acids_med, category_fat_of_which_saturated_fatty_acids_max, category_carb_min, category_carb_med, category_carb_max, category_carb_of_which_dietary_fiber_min, category_carb_of_which_dietary_fiber_med, category_carb_of_which_dietary_fiber_max, category_carb_of_which_sugars_min, category_carb_of_which_sugars_med, category_carb_of_which_sugars_max, category_proteins_min, category_proteins_med, category_proteins_max, category_salt_min, category_salt_med, category_salt_max FROM $t_food_categories_translations WHERE category_id=$get_current_sub_category_id AND category_translation_language=$l_mysql";
	$result_t = mysqli_query($link, $query_t);
	$row_t = mysqli_fetch_row($result_t);
	list($get_current_sub_category_translation_id, $get_current_sub_category_id, $get_current_sub_category_translation_language, $get_current_sub_category_translation_value, $get_current_sub_category_translation_no_food, $get_current_sub_category_translation_last_updated, $get_current_sub_category_calories_min, $get_current_sub_category_calories_med, $get_current_sub_category_calories_max, $get_current_sub_category_fat_min, $get_current_sub_category_fat_med, $get_current_sub_category_fat_max, $get_current_sub_category_fat_of_which_saturated_fatty_acids_min, $get_current_sub_category_fat_of_which_saturated_fatty_acids_med, $get_current_sub_category_fat_of_which_saturated_fatty_acids_max, $get_current_sub_category_carb_min, $get_current_sub_category_carb_med, $get_current_sub_category_carb_max, $get_current_sub_category_carb_of_which_dietary_fiber_min, $get_current_sub_category_carb_of_which_dietary_fiber_med, $get_current_sub_category_carb_of_which_dietary_fiber_max, $get_current_sub_category_carb_of_which_sugars_min, $get_current_sub_category_carb_of_which_sugars_med, $get_current_sub_category_carb_of_which_sugars_max, $get_current_sub_category_proteins_min, $get_current_sub_category_proteins_med, $get_current_sub_category_proteins_max, $get_current_sub_category_salt_min, $get_current_sub_category_salt_med, $get_current_sub_category_salt_max) = $row_t;
		

	
	// Unique hits
	$inp_ip = $_SERVER['REMOTE_ADDR'];
	$inp_ip = output_html($inp_ip);

	$ip_array = explode("\n", $get_food_unique_hits_ip_block);
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
		$inp_food_unique_hits_ip_block = $inp_ip . "\n" . $get_food_unique_hits_ip_block;
		$inp_food_unique_hits_ip_block_mysql = quote_smart($link, $inp_food_unique_hits_ip_block);
		$inp_food_unique_hits = $get_food_unique_hits + 1;
		$result = mysqli_query($link, "UPDATE $t_food_index SET food_unique_hits=$inp_food_unique_hits, food_unique_hits_ip_block=$inp_food_unique_hits_ip_block_mysql WHERE food_id=$food_id_mysql") or die(mysqli_error($link));
	}



	// Manufactor and food name
	if($get_food_manufacturer_name_and_food_name != "$get_food_manufacturer_name $get_food_name"){
		$inp_food_manufacturer_name_and_food_name = "$get_food_manufacturer_name $get_food_name";
		$inp_food_manufacturer_name_and_food_name_mysql = quote_smart($link, $inp_food_manufacturer_name_and_food_name);
		$result = mysqli_query($link, "UPDATE $t_food_index SET food_manufacturer_name_and_food_name=$inp_food_manufacturer_name_and_food_name_mysql WHERE food_id=$food_id_mysql") or die(mysqli_error($link));
		
		echo"
		<div class=\"info\"><p>Updated food_manufacturer_name_and_food_name to $inp_food_manufacturer_name_and_food_name</p></div>
		";
	}

	// Restriction?
	$can_view_food = 1;
	$can_view_images = 1;
	if($get_food_age_restriction == "1"){
		// Check if I have accepted 
		$inp_ip_mysql = quote_smart($link, $inp_ip);
		$query_t = "SELECT accepted_id, accepted_country FROM $t_food_age_restrictions_accepted WHERE accepted_ip=$inp_ip_mysql";
		$result_t = mysqli_query($link, $query_t);
		$row_t = mysqli_fetch_row($result_t);
		list($get_accepted_id, $get_accepted_country) = $row_t;
		
		if($get_accepted_id == ""){
			// Accept age restriction
			$can_view_food = 0;
			include("view_food_show_age_restriction_warning.php");
		}
		else{
			// Can I see food and images?
			$country_mysql = quote_smart($link, $get_accepted_country);
			$query = "SELECT restriction_id, restriction_country_iso, restriction_country_name, restriction_country_flag, restriction_language, restriction_age_limit, restriction_title, restriction_text, restriction_can_view_food, restriction_can_view_image FROM $t_food_age_restrictions WHERE restriction_country_iso=$country_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_restriction_id, $get_restriction_country_iso, $get_restriction_country_name, $get_restriction_country_flag, $get_restriction_language, $get_restriction_age_limit, $get_restriction_title, $get_restriction_text, $get_restriction_can_view_food, $get_restriction_can_view_image) = $row;

			$can_view_food = $get_restriction_can_view_food;
			$can_view_images = $get_restriction_can_view_image;

			if($can_view_food == 0){
				echo"
				<h1 style=\"padding-bottom:0;margin-bottom:0;\">$get_food_manufacturer_name $get_food_name</h1>
				<p>$get_restriction_text</p>
				";
			}
		}
	}


	if($can_view_food == 1){
		echo"
		<!-- Headline and store -->
			<h1 style=\"padding-bottom:0;margin-bottom:0;\">$get_food_manufacturer_name $get_food_name</h1>
		<!-- //Headline and store -->


		<!-- Where am I? -->
			<p><b>$l_you_are_here:</b><br />
			<a href=\"index.php?l=$l\">$l_food</a>
			&gt;
			<a href=\"open_main_category.php?main_category_id=$get_current_main_category_id&amp;l=$l\">$get_current_main_category_translation_value</a>
			&gt;
			<a href=\"open_sub_category.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;l=$l\">$get_current_sub_category_translation_value</a>
			&gt;
			<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;l=$l\">$get_food_name</a>
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
		if($get_food_clean_name == ""){
			$inp_food_clean_name = clean($get_food_name);
			$inp_food_clean_name_mysql = quote_smart($link, $inp_food_clean_name);
			$result = mysqli_query($link, "UPDATE $t_food_index SET food_clean_name =$inp_food_clean_name_mysql WHERE food_id='$get_food_id'") or die(mysqli_error($link));
			$get_food_clean_name = "$inp_food_clean_name";
		}


		if($get_food_image_path == ""){
			$year = date("Y");

			$inp_food_image_path = "_uploads/food/_img/$editor_language/$year";
			if(!(file_exists("../$inp_food_image_path"))){
				mkdir("../$inp_food_image_path");
			}

			$food_manufacturer_name_clean = clean($get_food_manufacturer_name);
			$store_dir = $food_manufacturer_name_clean . "_" . $get_food_clean_name;
			$inp_food_image_path = "_uploads/food/_img/$editor_language/$year/$store_dir";
			if(!(file_exists("../$inp_food_image_path"))){
				mkdir("../$inp_food_image_path");
			}
			$inp_food_image_path_mysql = quote_smart($link, $inp_food_image_path);
			$result = mysqli_query($link, "UPDATE $t_food_index SET food_image_path=$inp_food_image_path_mysql WHERE food_id='$get_food_id'") or die(mysqli_error($link));

			echo"<p>Created food image path</p>";
		}

		// 845/4 = 211
		if($action == "show_image" && isset($_GET['image']) && $can_view_images == 1){
			echo"<a id=\"image\"></a>";
			$image = $_GET['image'];
			$image = strip_tags(stripslashes($image));
	
			if($image == "a" && file_exists("../$get_food_image_path/$get_food_image_a") && $get_food_image_a != ""){
				
				if(file_exists("../$get_food_image_path/$get_food_image_b")){
					echo"<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;action=show_image&amp;image=b&amp;l=$l#image\"><img src=\"../$get_food_image_path/$get_food_image_a\" alt=\"$get_food_image_a\" /></a>";
				}
				else{
					echo"<img src=\"../$get_food_image_path/$get_food_image_a\" alt=\"$get_food_image_a\" />";
				}
			}
			if($image == "b" && file_exists("../$get_food_image_path/$get_food_image_b") && $get_food_image_b != ""){
				
				if(file_exists("../$get_food_image_path/$get_food_image_c")){
					echo"<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;action=show_image&amp;image=c&amp;l=$l#image\"><img src=\"../$get_food_image_path/$get_food_image_b\" alt=\"$get_food_image_b\" /></a>";
				}
				else{
					echo"<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;l=$l#image\"><img src=\"../$get_food_image_path/$get_food_image_b\" alt=\"$get_food_image_b\" /></a>";
				}
			}
			if($image == "c" && file_exists("../$get_food_image_path/$get_food_image_c") && $get_food_image_c != ""){
				
				if(file_exists("../$get_food_image_path/$get_food_image_d")){
					echo"<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;action=show_image&amp;image=d&amp;l=$l#image\"><img src=\"../$get_food_image_path/$get_food_image_c\" alt=\"$get_food_image_c\" /></a>";
				}
				else{
					echo"<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;l=$l#image\"><img src=\"../$get_food_image_path/$get_food_image_c\" alt=\"$get_food_image_c\" /></a>";
				}
			}
			if($image == "d" && file_exists("../$get_food_image_path/$get_food_image_d") && $get_food_image_d != ""){
				
				echo"<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;l=$l\"><img src=\"../$get_food_image_path/$get_food_image_d\" alt=\"$get_food_image_d\" /></a>";
				
			}
			echo"<br />";

		}

		if($get_food_image_a != ""  && $can_view_images == 1){
			// Thumb medium
			if(!(file_exists("../$get_food_image_path/$get_food_thumb_a_medium")) OR $get_food_thumb_a_medium == ""){
				$ext = get_extension("$get_food_image_a");
				$inp_thumb_name = str_replace(".$ext", "", $get_food_image_a);
				$get_food_thumb_a_medium = $inp_thumb_name . "_thumb_200x200." . $ext;
				$inp_food_thumb_a_medium_mysql = quote_smart($link, $get_food_thumb_a_medium);
				$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb_a_medium=$inp_food_thumb_a_medium_mysql WHERE food_id=$get_food_id") or die(mysqli_error($link));
				
				resize_crop_image(200, 200, "$root/$get_food_image_path/$get_food_image_a", "$root/$get_food_image_path/$get_food_thumb_a_medium");
			}
			echo"<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;action=show_image&amp;image=a&amp;l=$l#image\" style=\"margin-right: 11px;\"><img src=\"$root/$get_food_image_path/$get_food_thumb_a_medium\" alt=\"$get_food_thumb_a_medium\" /></a>";
		}

		if($get_food_image_b != ""  && $can_view_images == 1){
			// Thumb medium
			if(!(file_exists("../$get_food_image_path/$get_food_thumb_b_medium")) OR $get_food_thumb_b_medium == ""){
				$ext = get_extension("$get_food_image_b");
				$inp_thumb_name = str_replace(".$ext", "", $get_food_image_b);
				$get_food_thumb_b_medium = $inp_thumb_name . "_thumb_200x200." . $ext;
				$inp_food_thumb_b_medium_mysql = quote_smart($link, $get_food_thumb_b_medium);
				$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb_b_medium=$inp_food_thumb_b_medium_mysql WHERE food_id=$get_food_id") or die(mysqli_error($link));
				
				resize_crop_image(200, 200, "$root/$get_food_image_path/$get_food_image_b", "$root/$get_food_image_path/$get_food_thumb_b_medium");
			}
			echo"<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;action=show_image&amp;image=b&amp;l=$l#image\" style=\"margin-right: 11px;\"><img src=\"$root/$get_food_image_path/$get_food_thumb_b_medium\" alt=\"$get_food_thumb_b_medium\" /></a>";
		}


		if($get_food_image_c != ""  && $can_view_images == 1){
			// Thumb medium
			if(!(file_exists("../$get_food_image_path/$get_food_thumb_c_medium")) OR $get_food_thumb_c_medium == ""){
				$ext = get_extension("$get_food_image_c");
				$inp_thumb_name = str_replace(".$ext", "", $get_food_image_c);
				$get_food_thumb_c_medium = $inp_thumb_name . "_thumb_200x200." . $ext;
				$inp_food_thumb_c_medium_mysql = quote_smart($link, $get_food_thumb_c_medium);
				$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb_c_medium=$inp_food_thumb_c_medium_mysql WHERE food_id=$get_food_id") or die(mysqli_error($link));
				
				resize_crop_image(200, 200, "$root/$get_food_image_path/$get_food_image_c", "$root/$get_food_image_path/$get_food_thumb_c_medium");
			}

			echo"<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;action=show_image&amp;image=c&amp;l=$l#image\" style=\"margin-right: 11px;\"><img src=\"$root/$get_food_image_path/$get_food_thumb_c_medium\" alt=\"$get_food_thumb_c_medium\" /></a>";
	
		}
		if($get_food_image_d != ""  && $can_view_images == 1){
			if(!(file_exists("../$get_food_image_path/$get_food_thumb_d_medium")) OR $get_food_thumb_d_medium == ""){
				$ext = get_extension("$get_food_image_d");
				$inp_thumb_name = str_replace(".$ext", "", $get_food_image_d);
				$get_food_thumb_d_medium = $inp_thumb_name . "_thumb_200x200." . $ext;
				$inp_food_thumb_d_medium_mysql = quote_smart($link, $get_food_thumb_d_medium);
				$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb_d_medium=$inp_food_thumb_d_medium_mysql WHERE food_id=$get_food_id") or die(mysqli_error($link));
				
				resize_crop_image(200, 200, "$root/$get_food_image_path/$get_food_image_d", "$root/$get_food_image_path/$get_food_thumb_d_medium");
			}

			echo"<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;action=show_image&amp;image=d&amp;l=$l#image\" style=\"margin-right: 11px;\"><img src=\"$root/$get_food_image_path/$get_food_thumb_d_medium\" alt=\"$get_food_thumb_d_medium\" /></a>";
			
		}
		echo"
		</p>
		<!-- //Images -->
	
		<!-- Favorite, edit, delete -->
		<div class=\"clear\"></div>
		<div style=\"float: left;padding: 1px 0px 0px 0px;\">
			<p style=\"margin:0;padding:0;\">
			$l_published_by <a href=\"$root/users/view_profile.php?user_id=$get_food_user_id&amp;l=$l\">$get_food_author_user_alias</a><br />
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
					$q = "SELECT food_favorite_id FROM $t_food_favorites WHERE food_favorite_food_id=$get_food_id AND food_favorite_user_id=$my_user_id_mysql";
					$r = mysqli_query($link, $q);
					$rowb = mysqli_fetch_row($r);
					list($get_food_favorite_id) = $rowb;
					if($get_food_favorite_id == ""){
						echo"
						<a href=\"favorite_food_add.php?main_category_id=$get_food_main_category_id&amp;sub_category_id=$get_food_sub_category_id&amp;food_id=$get_food_id&amp;l=$l&amp;process=1\"><img src=\"_gfx/icons/heart_grey.png\" alt=\"heart_grey.png\" /></a>
						";
					}
					else{
						echo"
						<a href=\"favorite_food_remove.php?main_category_id=$get_food_main_category_id&amp;sub_category_id=$get_food_sub_category_id&amp;food_id=$get_food_id&amp;l=$l&amp;process=1\"><img src=\"_gfx/icons/heart_fill.png\" alt=\"heart_fill.png\" /></a>
						";
					}

					// edit, delte
					if($get_my_user_id == "$get_food_user_id" OR $get_my_user_rank == "admin" OR $get_my_user_rank == "moderator"){
						echo"
						<a href=\"edit_food.php?main_category_id=$get_food_main_category_id&amp;sub_category_id=$get_food_sub_category_id&amp;food_id=$get_food_id&amp;l=$l\"><img src=\"_gfx/icons/edit.png\" alt=\"ic_mode_edit_black_18dp_1x.png\" /></a>
						<a href=\"delete_food.php?main_category_id=$get_food_main_category_id&amp;sub_category_id=$get_food_sub_category_id&amp;food_id=$get_food_id&amp;l=$l\"><img src=\"_gfx/icons/delete.png\" alt=\"ic_delete_black_18dp_1x.png\" /></a>
						";
					}
				}
				else{
					echo"
					<a href=\"$root/users/index.php?page=login&amp;l=$l&amp;refer=../food/favorite_food_add.php?recipe_id=$get_food_id&amp;l=$l\"><img src=\"_gfx/icons/heart_grey.png\" alt=\"heart_grey.png\" /></a>
					";
				}
			echo"
			</p>
		</div>
		<div class=\"clear\"></div>
			<p style=\"margin-top: 0px;padding-top:0\">
			<img src=\"_gfx/icons/eye_dark_grey.png\" alt=\"eye.png\" /> $get_food_unique_hits $l_unique_views_lovercase
			</p>
		<!-- //Favorite, edit, delete -->
		
		<!-- About -->
		<p>
		$get_food_description

		<!-- Tags -->";

			$query = "SELECT tag_id, tag_title FROM $t_food_index_tags WHERE tag_food_id=$get_food_id ORDER BY tag_id ASC";
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

		$query = "SELECT ad_id, ad_text FROM $t_food_index_ads WHERE ad_food_id='$get_food_id'";
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
		<h2>$l_numbers</h2>
		";


		echo"
		<table class=\"hor-zebra\" style=\"width: auto;min-width: 0;display: table;\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
		   </th>";
		if($get_food_energy != "0"){
			echo"
			   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 8px;vertical-align: bottom;\">
				<span>$l_per_100</span>
		 	  </th>";
		}
		echo"
		   <th scope=\"col\" style=\"text-align: center;padding: 6px 8px 6px 8px;\">
			<span>$l_serving<br />$get_food_serving_size_gram $get_food_serving_size_gram_measurement ($get_food_serving_size_pcs $get_food_serving_size_pcs_measurement)</span>
		   </th>
			
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
		if($get_food_energy != "0"){
			echo"
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<span>$get_food_energy</span>
			   </td>";
		}
		echo"
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>$get_food_energy_calculated</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_med\">
			<span>$get_current_sub_category_calories_med</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_diff\">";
			$energy_diff_med = round($get_food_energy-$get_current_sub_category_calories_med, 0);

			if($energy_diff_med > 0){
				echo"<span style=\"color: red;\">$energy_diff_med</span>";
			}
			elseif($energy_diff_med < 0){
				echo"<span style=\"color: green;\">$energy_diff_med</span>";
			}
			else{
				echo"<span>$energy_diff_med</span>";
				// $product_score_description = $product_score_description . " $l_have_an_ok_amount_of_calories_lowercase, ";
			}
			echo"
		   </td>
		  </tr>

		  <tr>
		   <td style=\"padding: 8px 4px 6px 8px;\">
			<span>$l_fat<br /></span>
			<span>$l_dash_of_which_saturated_fatty_acids</span>
		   </td>";
		if($get_food_energy != "0"){
			echo"
		 	  <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<span>$get_food_fat<br /></span>
				<span>$get_food_fat_of_which_saturated_fatty_acids</span>
			   </td>";
		}
		echo"
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>$get_food_fat_calculated<br /></span>
			<span>$get_food_fat_of_which_saturated_fatty_acids_calculated</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_med\">
			<span>$get_current_sub_category_fat_med<br /></span>
			<span>$get_current_sub_category_fat_of_which_saturated_fatty_acids_med</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_diff\">";
			$fat_diff_med = round($get_food_fat-$get_current_sub_category_fat_med, 0);

			if($fat_diff_med > 0){
				echo"<span style=\"color: red;\">$fat_diff_med</span>";
			}
			elseif($fat_diff_med < 0){
				echo"<span style=\"color: green;\">$fat_diff_med</span>";
			}
			else{
				echo"<span>$fat_diff_med</span>";
				// $product_score_description = $product_score_description . " $l_ok_amount_of_fat_lowercase, ";
			}

			$food_fat_of_which_saturated_fatty_acids_diff_med = round($get_food_fat_of_which_saturated_fatty_acids-$get_current_sub_category_fat_of_which_saturated_fatty_acids_med, 0);
			
			if($food_fat_of_which_saturated_fatty_acids_diff_med > 0){
				echo"<span style=\"color: red;\"><br />$food_fat_of_which_saturated_fatty_acids_diff_med</span>";
			}
			elseif($food_fat_of_which_saturated_fatty_acids_diff_med < 0){
				echo"<span style=\"color: green;\"><br />$food_fat_of_which_saturated_fatty_acids_diff_med</span>";
			}
			else{
				echo"<span><br />$food_fat_of_which_saturated_fatty_acids_diff_med</span>";
				// $product_score_description = $product_score_description . " $l_ok_amount_of_fat_lowercase, ";
			}
			echo"
		   </td>
		  </tr>

		  <tr>
		   <td style=\"padding: 8px 4px 6px 8px;\">
			<span>$l_carbs<br /></span>
			<span>$l_dash_of_which_sugars</span>
		   </td>";
		if($get_food_energy != "0"){
			echo"
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<span>$get_food_carbohydrates<br /></span>
				<span>$get_food_carbohydrates_of_which_sugars</span>
			   </td>
			";
		}
		echo"
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>$get_food_carbohydrates_calculated<br /></span>
			<span>$get_food_carbohydrates_of_which_sugars_calculated</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_med\">
			<span>$get_current_sub_category_carb_med<br /></span>
			<span>$get_current_sub_category_carb_of_which_sugars_med</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_diff\">";
			$carbohydrate_diff_med = round($get_food_carbohydrates-$get_current_sub_category_carb_med, 0);
			
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
			$food_carbohydrates_of_which_sugars_diff_med = round($get_food_carbohydrates_of_which_sugars-$get_current_sub_category_carb_of_which_sugars_med, 0);
			
			if($food_carbohydrates_of_which_sugars_diff_med > 0){
				echo"<span style=\"color: red;\"><br />$food_carbohydrates_of_which_sugars_diff_med</span>";
			}
			elseif($food_carbohydrates_of_which_sugars_diff_med < 0){
				echo"<span style=\"color: green;\"><br />$food_carbohydrates_of_which_sugars_diff_med</span>";
			}
			else{
				echo"<span><br />$food_carbohydrates_of_which_sugars_diff_med</span>";
			}
			echo"
		   </td>
		  </tr>



		  <tr>
		   <td style=\"padding: 8px 4px 6px 8px;\">
			<span>$l_dietary_fiber<br /></span>
		   </td>";
		if($get_food_energy != "0"){
			echo"
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<span>$get_food_carbohydrates_of_which_dietary_fiber<br /></span>
			   </td>
			";
		}
		echo"
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>$get_food_carbohydrates_of_which_dietary_fiber_calculated<br /></span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_med\">
			<span>$get_current_sub_category_carb_of_which_dietary_fiber_med</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_diff\">";
			// Fiber
			$food_carbohydrates_of_which_dietary_fiber_diff_med = round($get_food_carbohydrates_of_which_dietary_fiber-$get_current_sub_category_carb_of_which_dietary_fiber_med, 0);
			
			if($food_carbohydrates_of_which_dietary_fiber_diff_med > 0){
				echo"<span style=\"color: red;\"><br />$food_carbohydrates_of_which_dietary_fiber_diff_med</span>";
			}
			elseif($food_carbohydrates_of_which_dietary_fiber_diff_med < 0){
				echo"<span style=\"color: green;\"><br />$food_carbohydrates_of_which_dietary_fiber_diff_med</span>";
			}
			else{
				echo"<span><br />$food_carbohydrates_of_which_dietary_fiber_diff_med</span>";
			}
			echo"
		   </td>
		  </tr>
		  <tr>
		   <td style=\"padding: 8px 4px 6px 8px;\">
			<span>$l_proteins</span>
		   </td>";
		if($get_food_energy != "0"){
			echo"
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<span>$get_food_proteins</span>
			   </td>
			";
		}
		echo"
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>$get_food_proteins_calculated</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_med\">
			<span>$get_current_sub_category_proteins_med</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_diff\">";
			$proteins_diff_med = round($get_food_proteins-$get_current_sub_category_proteins_med, 0);
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
		  </tr>
		 </tr>
		  <tr>
		   <td style=\"padding: 8px 4px 6px 8px;\">
			<span>$l_salt_in_gram<br />
			$l_dash_of_which_sodium_in_mg</span>
		   </td>";
		if($get_food_energy != "0"){
			echo"
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<span>$get_food_salt<br />
				$get_food_sodium</span>
			   </td>
			";
		}
		echo"
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>$get_food_salt_calculated<br />
			$get_food_sodium_calculated</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_med\">
			<span>$get_current_sub_category_salt_med</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\" class=\"current_sub_category_calories_diff\">";
			$salt_diff_med = round($get_food_salt-$get_current_sub_category_salt_med, 0);
			
			if($salt_diff_med > 0){
				echo"<span style=\"color: red;\">$salt_diff_med</span>";
			}
			elseif($salt_diff_med < 0){
				echo"<span style=\"color: green;\">$salt_diff_med</span>";
			}
			else{
				echo"<span>$salt_diff_med</span>";
			}
			echo"
		   </td>
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

			$score_number = $energy_diff_med+$fat_diff_med+$food_fat_of_which_saturated_fatty_acids_diff_med+$carbohydrate_diff_med+$food_carbohydrates_of_which_dietary_fiber_diff_med+$food_carbohydrates_of_which_sugars_diff_med+$proteins_diff_med+$salt_diff_med;

			if($get_food_score != $score_number){
				$result = mysqli_query($link, "UPDATE $t_food_index SET food_score='$score_number' WHERE food_id='$get_food_id'") or die(mysqli_error($link));
			}

			if($score_number > 0){
				echo"
				<em style=\"color: red;\">$score_number</em>
				<img src=\"_gfx/smiley_sad.png\" alt=\"smiley_sad.gif\" style=\"padding:0px 0px 0px 4px;\"  />";
			}
			elseif($score_number < 0){
				echo"
				<em style=\"color: green;\">$score_number</em>
				<img src=\"_gfx/smiley_smile.png\" alt=\"smiley_smile.png\" style=\"padding:0px 0px 0px 4px;\" />";
			}
			else{
				echo"
				<em>$score_number</em>
				<img src=\"_gfx/smiley_confused.png\" alt=\"smiley_confused.png\" style=\"padding:0px 0px 0px 4px;\" />";
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
			<span><a href=\"search.php?manufacturer_name=$get_food_manufacturer_name&amp;l=$l\">$get_food_manufacturer_name</a></span>
		   </td>
		  </tr>
		  <tr>
		   <td style=\"padding: 8px 4px 6px 8px;\">
			<span><b>$l_barcode:</b></span>
		   </td>
		   <td style=\"padding: 0px 4px 0px 4px;\">
			<span><a href=\"search.php?barcode=$get_food_barcode&amp;l=$l\">$get_food_barcode</a></span>
		   </td>
		  </tr>
		  <tr>
		   <td style=\"padding: 8px 4px 6px 8px;\">
			<span><b>$l_net_content:</b></span>
		   </td>
		   <td style=\"padding: 0px 4px 0px 4px;\">
			<span>$get_food_net_content $get_food_net_content_measurement</span>
		   </td>
		  </tr>
		  <tr>
		   <td style=\"padding: 8px 4px 6px 8px;\">
			<span><b>$l_stores:</b></span>
		   </td>
		   <td style=\"padding: 0px 4px 0px 4px;\">
			<span>";
			
			// Count stores
			$query = "SELECT count(food_store_id) FROM $t_food_index_stores  WHERE food_store_food_id=$get_food_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_count_food_stores) = $row;
	
			$x = 0;
			$count_minus_two = $get_count_food_stores-2;

			$query = "SELECT food_store_id, food_store_store_id, food_store_store_name FROM $t_food_index_stores WHERE food_store_food_id=$get_food_id ORDER BY food_store_store_name ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_food_store_id, $get_food_store_store_id, $get_food_store_store_name) = $row;
				echo"
				<a href=\"search.php?q=&amp;barcode=&amp;manufacturer_name=&amp;store_id=$get_food_store_store_id&amp;order_by=food_score&amp;order_method=asc&amp;l=$l\">$get_food_store_store_name</a>";
				
				// Check if I have prices
				$query_p = "SELECT food_price_id, food_price_food_id, food_price_store_id, food_price_store_name, food_price_price, food_price_currency, food_price_offer, food_price_offer_valid_from, food_price_offer_valid_to, food_price_user_id, food_price_user_ip, food_price_added_datetime, food_price_added_datetime_print, food_price_updated, food_price_updated_print, food_price_reported, food_price_reported_checked FROM $t_food_index_prices WHERE food_price_food_id=$get_food_id AND food_price_store_id=$get_food_store_store_id";
				$result_p = mysqli_query($link, $query_p);
				$row_p = mysqli_fetch_row($result_p);
				list($get_food_price_id, $get_food_price_food_id, $get_food_price_store_id, $get_food_price_store_name, $get_food_price_price, $get_food_price_currency, $get_food_price_offer, $get_food_price_offer_valid_from, $get_food_price_offer_valid_to, $get_food_price_user_id, $get_food_price_user_ip, $get_food_price_added_datetime, $get_food_price_added_datetime_print, $get_food_price_updated, $get_food_price_updated_print, $get_food_price_reported, $get_food_price_reported_checked) = $row_p;
				if($get_food_price_id == ""){
					echo"
					
					";
				}
				else{
					echo"
					<span>($get_food_price_price)</span>
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
		<div class=\"clear\" style=\"height: 20px;\"></div>




		";
		// Image warning to admin
		if($get_food_image_a == "" OR !(file_exists("../$get_food_image_path/$get_food_image_a"))){


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
			

			$missing_file = "$root/_cache/food_missing_img_$get_food_id.txt";

			if(!(file_exists("$missing_file"))){
			echo"<div class=\"clear\"></div>
			<div class=\"info\"><p>E-mail sent to admins. Writing to $root/_cache/food_missing_img_$get_food_id.txt</p></div>";

			// Mail from
			$host = $_SERVER['HTTP_HOST'];
			
			$view_link = $configSiteURLSav . "/food/view_food.php?food_id=$get_food_id";

			$subject = "Food missing image $get_food_name at $host";

			$message = "<html>\n";
			$message = $message. "<head>\n";
			$message = $message. "  <title>$subject</title>\n";
			$message = $message. " </head>\n";
			$message = $message. "<body>\n";

			$message = $message . "<p>Hi $get_moderator_user_name,</p>\n\n";
			$message = $message . "<p><b>Summary:</b><br />A food is missing image. Please take a image of the food and upload.</p>\n\n";

			$message = $message . "<p style='padding-bottom:0;margin-bottom:0'><b>Information:</b></p>\n";
			$message = $message . "<table>\n";
			$message = $message . " <tr><td><span>Food ID:</span></td><td><span>$get_food_id</span></td></tr>\n";
			$message = $message . " <tr><td><span>Name:</span></td><td><span><a href=\"$view_link\">$get_food_name</a></span></td></tr>\n";
			$message = $message . " <tr><td><span>Manufactor:</span></td><td><span>$get_food_manufacturer_name</span></td></tr>\n";
			$message = $message . " <tr><td><span>Description</span></td><td><span>$get_food_description</span></td></tr>\n";
			$message = $message . " <tr><td><span>Serving per 100:</span></td><td><span>$get_food_serving_size_gram $get_food_serving_size_gram_measurement</span></td></tr>\n";
			$message = $message . " <tr><td><span>Serving per pc:</span></td><td><span>$get_food_serving_size_pcs $get_food_serving_size_pcs_measurement</span></td></tr>\n";
			$message = $message . " <tr><td><span>Barcode:</span></td><td><span>$get_food_barcode</span></td></tr>\n";
			$message = $message . "</table>\n";

			$message = $message . "<p style='padding-bottom:0;margin-bottom:0'><b>Author:</b></p>\n";
			$message = $message . "<table>\n";
			$message = $message . " <tr><td><span>User ID:</span></td><td><span>$get_food_user_id</span></td></tr>\n";
			$message = $message . " <tr><td><span>User Name:</span></td><td><span>$get_food_author_user_name</span></td></tr>\n";
			$message = $message . " <tr><td><span>Alias:</span></td><td><span>$get_food_author_user_alias</span></td></tr>\n";
			$message = $message . " <tr><td><span>E-mail:</span></td><td><span>$get_food_author_user_email</span></td></tr>\n";
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
	} // can view food
}
/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>