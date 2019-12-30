<?php 
/**
*
* File: recipes/view_recipe.php
* Version 2.0.0
* Date 22:33 05.02.2019
* Copyright (c) 2011-2019 Localhost
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
if(isset($_GET['recipe_id'])) {
	$recipe_id = $_GET['recipe_id'];
	$recipe_id = strip_tags(stripslashes($recipe_id));
}
else{
	$recipe_id = "";
}

if(isset($_GET['servings'])) {
	$servings = $_GET['servings'];
	$servings = strip_tags(stripslashes($servings));
	$servings = str_replace(",", ".", $servings);

	if(!is_numeric($servings)){
		echo"
		<h1>Server error</h1>
		<p>The servings has to be numeric.</p>
		";
		die;
	}
	if($servings < 0 OR $servings > 999){
		echo"
		<h1>Server error</h1>
		<p>Are you really going to feed so many people?</p>
		";
		die;
	}
}
else{
	$servings = "";
}


$l_mysql = quote_smart($link, $l);


/*- Get recipe ------------------------------------------------------------------------- */
// Select
$recipe_id_mysql = quote_smart($link, $recipe_id);
$query = "SELECT recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_country, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_comments, recipe_user_ip, recipe_notes, recipe_password, recipe_last_viewed, recipe_age_restriction FROM $t_recipes WHERE recipe_id=$recipe_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_recipe_id, $get_recipe_user_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_language, $get_recipe_country, $get_recipe_introduction, $get_recipe_directions, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb, $get_recipe_video, $get_recipe_date, $get_recipe_time, $get_recipe_cusine_id, $get_recipe_season_id, $get_recipe_occasion_id, $get_recipe_marked_as_spam, $get_recipe_unique_hits, $get_recipe_unique_hits_ip_block, $get_recipe_comments, $get_recipe_user_ip, $get_recipe_notes, $get_recipe_password, $get_recipe_last_viewed, $get_recipe_age_restriction) = $row;

/*- Headers ---------------------------------------------------------------------------------- */
if($get_recipe_id == ""){
	$website_title = "Server error 404";
}
else{
	$website_title = "$l_recipes - $get_recipe_title";
}

if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */

if($get_recipe_id == ""){
	echo"
	<h1>Recipe not found</h1>

	<p>
	The recipe you are trying to view was not found.
	</p>

	<p>
	<a href=\"index.php\">Back</a>
	</p>
	";
}
else{
	// Age

	$can_view_recipe = 1;
	$can_view_images = 1;
	if($get_recipe_age_restriction == "1"){
		// Check if I have accepted 
		$inp_ip_mysql = quote_smart($link, $inp_ip);
		$query_t = "SELECT accepted_id, accepted_country FROM $t_recipes_age_restrictions_accepted WHERE accepted_ip=$inp_ip_mysql";
		$result_t = mysqli_query($link, $query_t);
		$row_t = mysqli_fetch_row($result_t);
		list($get_accepted_id, $get_accepted_country) = $row_t;
		
		if($get_accepted_id == ""){
			// Accept age restriction
			$can_view_recipe = 0;
			include("view_recipe_show_age_restriction_warning.php");
		}
		else{
			// Can I see recipe and images?
			$country_mysql = quote_smart($link, $get_accepted_country);
			$query = "SELECT restriction_id, restriction_country_iso, restriction_country_name, restriction_country_flag, restriction_language, restriction_age_limit, restriction_title, restriction_text, restriction_can_view_recipe, restriction_can_view_image FROM $t_recipes_age_restrictions WHERE restriction_country_iso=$country_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_restriction_id, $get_restriction_country_iso, $get_restriction_country_name, $get_restriction_country_flag, $get_restriction_language, $get_restriction_age_limit, $get_restriction_title, $get_restriction_text, $get_restriction_can_view_recipe, $get_restriction_can_view_image) = $row;

			$can_view_recipe = $get_restriction_can_view_recipe;
			$can_view_images = $get_restriction_can_view_image;

			if($can_view_recipe == 0){
				echo"
				<h1 style=\"padding-bottom:0;margin-bottom:0;\">$get_recipe_title</h1>
				<p>$get_restriction_text</p>
				";
			}
		}
	}


	if($can_view_recipe == 1){

	// Unique hits
	$inp_ip = $_SERVER['REMOTE_ADDR'];
	$inp_ip = output_html($inp_ip);

	$recipe_unique_hits_ip_block_array = explode("\n", $get_recipe_unique_hits_ip_block);
	$recipe_unique_hits_ip_block_array_size = sizeof($recipe_unique_hits_ip_block_array);

	if($recipe_unique_hits_ip_block_array_size > 30){
		$recipe_unique_hits_ip_block_array_size = 20;
	}
	
	$has_seen_this_recipe_before = 0;

	for($x=0;$x<$recipe_unique_hits_ip_block_array_size;$x++){
		if($recipe_unique_hits_ip_block_array[$x] == "$inp_ip"){
			$has_seen_this_recipe_before = 1;
			break;
		}
	}
	
	if($has_seen_this_recipe_before == 0){
		$inp_recipe_unique_hits_ip_block = $inp_ip . "\n" . $get_recipe_unique_hits_ip_block;
		$inp_recipe_unique_hits_ip_block_mysql = quote_smart($link, $inp_recipe_unique_hits_ip_block);
		$inp_recipe_unique_hits = $get_recipe_unique_hits + 1;
		$result = mysqli_query($link, "UPDATE $t_recipes SET recipe_unique_hits=$inp_recipe_unique_hits, recipe_unique_hits_ip_block=$inp_recipe_unique_hits_ip_block_mysql WHERE recipe_id=$recipe_id_mysql") or die(mysqli_error($link));
	}

	// Select Nutrients
	$query = "SELECT number_id, number_recipe_id, number_hundred_calories, number_hundred_proteins, number_hundred_fat, number_hundred_fat_of_which_saturated_fatty_acids, number_hundred_carbs, number_hundred_carbs_of_which_dietary_fiber, number_hundred_carbs_of_which_sugars, number_hundred_salt, number_hundred_sodium, number_serving_calories, number_serving_proteins, number_serving_fat, number_serving_fat_of_which_saturated_fatty_acids, number_serving_carbs, number_serving_carbs_of_which_dietary_fiber, number_serving_carbs_of_which_sugars, number_serving_salt, number_serving_sodium, number_total_weight, number_total_calories, number_total_proteins, number_total_fat, number_total_fat_of_which_saturated_fatty_acids, number_total_carbs, number_total_carbs_of_which_dietary_fiber, number_total_carbs_of_which_sugars, number_total_salt, number_total_sodium, number_servings FROM $t_recipes_numbers WHERE number_recipe_id=$recipe_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_number_id, $get_number_recipe_id, $get_number_hundred_calories, $get_number_hundred_proteins, $get_number_hundred_fat, $get_number_hundred_fat_of_which_saturated_fatty_acids, $get_number_hundred_carbs, $get_number_hundred_carbs_of_which_dietary_fiber, $get_number_hundred_carbs_of_which_sugars, $get_number_hundred_salt, $get_number_hundred_sodium, $get_number_serving_calories, $get_number_serving_proteins, $get_number_serving_fat, $get_number_serving_fat_of_which_saturated_fatty_acids, $get_number_serving_carbs, $get_number_serving_carbs_of_which_dietary_fiber, $get_number_serving_carbs_of_which_sugars, $get_number_serving_salt, $get_number_serving_sodium, $get_number_total_weight, $get_number_total_calories, $get_number_total_proteins, $get_number_total_fat, $get_number_total_fat_of_which_saturated_fatty_acids, $get_number_total_carbs, $get_number_total_carbs_of_which_dietary_fiber, $get_number_total_carbs_of_which_sugars, $get_number_total_salt, $get_number_total_sodium, $get_number_servings) = $row;


	// Author
	$query = "SELECT user_alias FROM $t_users WHERE user_id=$get_recipe_user_id";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_user_alias) = $row;

	// Profile
	$query_profile = "SELECT profile_id, profile_user_id, profile_first_name, profile_middle_name, profile_last_name, profile_address_line_a, profile_address_line_b, profile_zip, profile_city, profile_country, profile_phone, profile_work, profile_university, profile_high_school, profile_languages, profile_website, profile_interested_in, profile_relationship, profile_about, profile_newsletter FROM $t_users_profile WHERE profile_user_id='$get_recipe_user_id'";
	$result_profile = mysqli_query($link, $query_profile);
	$row_profile = mysqli_fetch_row($result_profile);
	list($get_profile_id, $get_profile_user_id, $get_profile_first_name, $get_profile_middle_name, $get_profile_last_name, $get_profile_address_line_a, $get_profile_address_line_b, $get_profile_zip, $get_profile_city, $get_profile_country, $get_profile_phone, $get_profile_work, $get_profile_university, $get_profile_high_school, $get_profile_languages, $get_profile_website, $get_profile_interested_in, $get_profile_relationship, $get_profile_about, $get_profile_newsletter) = $row_profile;



	// Author Photo
	$q = "SELECT photo_id, photo_user_id, photo_destination, photo_thumb_50, photo_thumb_60 FROM $t_users_profile_photo WHERE photo_user_id='$get_recipe_user_id' AND photo_profile_image='1'";
	$r = mysqli_query($link, $q);
	$rowb = mysqli_fetch_row($r);
	list($get_photo_id, $get_photo_user_id, $get_photo_destination, $get_photo_thumb_50, $get_photo_thumb_60) = $rowb;
	

	if($get_photo_id != ""){					
		if($get_photo_thumb_50 == ""){
			$extension = get_extension($get_photo_destination);
			$extension = strtolower($extension);
			$name = str_replace(".$extension", "", $get_photo_destination);
	
			// Small
			$thumb_a = $name . "_40." . $extension;
			$thumb_a_mysql = quote_smart($link, $thumb_a);

			// Medium
			$thumb_b = $name . "_50." . $extension;
			$thumb_b_mysql = quote_smart($link, $thumb_b);

			// Large
			$thumb_c = $name . "_60." . $extension;
			$thumb_c_mysql = quote_smart($link, $thumb_c);

			// Extra Large
			$thumb_d = $name . "_200." . $extension;
			$thumb_d_mysql = quote_smart($link, $thumb_d);
		
			// Update
			$result_update = mysqli_query($link, "UPDATE $t_users_profile_photo SET photo_thumb_40=$thumb_a_mysql, photo_thumb_50=$thumb_b_mysql, photo_thumb_60=$thumb_c_mysql, photo_thumb_200=$thumb_d_mysql WHERE photo_id=$get_photo_id");
				
			// Pass new variables
			$get_photo_thumb_40 = "$thumb_a";
			$get_photo_thumb_50 = "$thumb_b";
			$get_photo_thumb_60 = "$thumb_c";
			$get_photo_thumb_200 = "$thumb_d";
		}
		if($get_photo_destination != "" && !(file_exists("$root/_uploads/users/images/$get_photo_user_id/$get_photo_thumb_50"))){
			// Thumb
			$inp_new_x = 50;
			$inp_new_y = 50;
			resize_crop_image($inp_new_x, $inp_new_y, "$root/_uploads/users/images/$get_photo_user_id/$get_photo_destination", "$root/_uploads/users/images/$get_photo_user_id/$get_photo_thumb_50");
		} // thumb
		if($get_photo_destination != "" && !(file_exists("$root/_uploads/users/images/$get_photo_user_id/$get_photo_thumb_60"))){
			// Thumb
			$inp_new_x = 60;
			$inp_new_y = 60;
			resize_crop_image($inp_new_x, $inp_new_y, "$root/_uploads/users/images/$get_photo_user_id/$get_photo_destination", "$root/_uploads/users/images/$get_photo_user_id/$get_photo_thumb_60");
		} // thumb
	}


	// Check Date, Time
	if($get_recipe_date == ""){
		$get_recipe_date = date("Y-m-d");
		$get_recipe_time = date("H:i");
		$result = mysqli_query($link, "UPDATE $t_recipes SET recipe_date='$get_recipe_date', recipe_time='$get_recipe_time' WHERE recipe_id=$recipe_id_mysql");
	}

	// Date
	$recipe_year = substr($get_recipe_date, 0, 4);
	$recipe_month = substr($get_recipe_date, 5, 2);
	$recipe_day = substr($get_recipe_date, 8, 2);

	if($recipe_day < 10){
		$recipe_day = substr($recipe_day, 1, 1);
	}
	
	if($recipe_month == "01"){
		$recipe_month_saying = $l_january;
	}
	elseif($recipe_month == "02"){
		$recipe_month_saying = $l_february;
	}
	elseif($recipe_month == "03"){
		$recipe_month_saying = $l_march;
	}
	elseif($recipe_month == "04"){
		$recipe_month_saying = $l_april;
	}
	elseif($recipe_month == "05"){
		$recipe_month_saying = $l_may;
	}
	elseif($recipe_month == "06"){
		$recipe_month_saying = $l_june;
	}
	elseif($recipe_month == "07"){
		$recipe_month_saying = $l_july;
	}
	elseif($recipe_month == "08"){
		$recipe_month_saying = $l_august;
	}
	elseif($recipe_month == "09"){
		$recipe_month_saying = $l_september;
	}
	elseif($recipe_month == "10"){
		$recipe_month_saying = $l_october;
	}
	elseif($recipe_month == "11"){
		$recipe_month_saying = $l_november;
	}
	else{
		$recipe_month_saying = $l_december;
	}

	// Time
	$get_recipe_time = substr($get_recipe_time, 0, 5);

	// Last viewed
	$inp_last_viewed = date("Y-m-d H:i:s");
	$result = mysqli_query($link, "UPDATE $t_recipes SET recipe_last_viewed='$inp_last_viewed' WHERE recipe_id=$recipe_id_mysql");
	

	// Category
	$query = "SELECT category_translation_value FROM $t_recipes_categories_translations WHERE category_id=$get_recipe_category_id AND category_translation_language=$l_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_category_translation_value) = $row;

	// Cusine
	if($get_recipe_cusine_id != 0){
		$query = "SELECT cuisine_translation_id, cuisine_translation_value FROM $t_recipes_cuisines_translations WHERE cuisine_id=$get_recipe_cusine_id AND cuisine_translation_language=$l_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_cuisine_translation_id, $get_cusine_translation_value) = $row;
	}

	// Season
	if($get_recipe_season_id != 0){
		$query = "SELECT season_translation_id, season_translation_value FROM $t_recipes_seasons_translations WHERE season_id=$get_recipe_season_id AND season_translation_language=$l_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_season_translation_id, $get_season_translation_value) = $row;
	}

	// Occasion
	if($get_recipe_occasion_id != 0){
		$query = "SELECT occasion_translation_id, occasion_translation_value FROM $t_recipes_occasions_translations WHERE occasion_id=$get_recipe_occasion_id AND occasion_translation_language=$l_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_occasion_translation_id, $get_occasion_translation_value) = $row;
	}


	// Rating
	$query_rating = "SELECT rating_id, rating_recipe_id, rating_1, rating_2, rating_3, rating_4, rating_5, rating_total_votes, rating_average, rating_popularity, rating_ip_block FROM $t_recipes_rating WHERE rating_recipe_id='$get_recipe_id'";
	$result_rating = mysqli_query($link, $query_rating);
	$row_rating = mysqli_fetch_row($result_rating);
	list($get_rating_id, $get_rating_recipe_id, $get_rating_1, $get_rating_2, $get_rating_3, $get_rating_4, $get_rating_5, $get_rating_total_votes, $get_rating_average, $get_rating_popularity, $get_rating_ip_block) = $row_rating;
	if($get_rating_average == ""){
		$get_rating_average = 0;
	}


	echo"	
	<!-- Headline and actions -->
		<h1 class=\"recipe_headline\" style=\"\">$get_recipe_title
					";
				if(isset($_SESSION['user_id'])){

					// My user
					$my_user_id = $_SESSION['user_id'];
					$my_user_id_mysql = quote_smart($link, $my_user_id);
					$q = "SELECT user_id, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
					$r = mysqli_query($link, $q);
					$rowb = mysqli_fetch_row($r);
					list($get_my_user_id, $get_my_user_rank) = $rowb;

					// Favorite
					$q = "SELECT recipe_favorite_id FROM $t_recipes_favorites WHERE recipe_favorite_recipe_id=$get_recipe_id AND recipe_favorite_user_id=$my_user_id_mysql";
					$r = mysqli_query($link, $q);
					$rowb = mysqli_fetch_row($r);
					list($get_recipe_favorite_id) = $rowb;
					if($get_recipe_favorite_id == ""){
						echo"
						<a href=\"favorite_recipe_add.php?recipe_id=$get_recipe_id&amp;l=$l&amp;process=1\"><img src=\"_gfx/icons/heart_grey.png\" alt=\"heart_grey.png\" /></a>
						";
					}
					else{
						echo"
						<a href=\"favorite_recipe_remove.php?recipe_id=$get_recipe_id&amp;l=$l&amp;process=1\"><img src=\"_gfx/icons/heart_fill.png\" alt=\"heart_fill.png\" /></a>
						";
					}

					// edit, delte
					if($get_my_user_id == "$get_recipe_user_id" OR $get_my_user_rank == "admin" OR $get_my_user_rank == "moderator"){
						echo"
						<a href=\"edit_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\"><img src=\"_gfx/icons/edit.png\" alt=\"ic_mode_edit_black_18dp_1x.png\" /></a>
						<a href=\"delete_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\"><img src=\"_gfx/icons/delete.png\" alt=\"ic_delete_black_18dp_1x.png\" /></a>
						";
					}
				}
				else{
					echo"
					<a href=\"$root/users/login.php?l=$l&amp;referer=../recipes/favorite_recipe_add.php?recipe_id=$get_recipe_id&amp;l=$l\"><img src=\"_gfx/icons/heart_grey.png\" alt=\"heart_grey.png\" /></a>
					";
				}
				echo"
					</h1>
		<div class=\"clear\"></div>
	<!-- //Headline and actions -->

	<!-- Ad -->
		";
		include("$root/ad/_includes/ad_main_below_headline.php");
		echo"
	<!-- //Ad -->


	<!-- Feedback -->
		";
		if($ft != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			else{
				$fm = str_replace("_", " ", $fm);
				$fm = ucfirst($fm);
			}
			echo"<div class=\"clear\"></div><div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
	<!-- //Feedback -->

	<!-- Image -->
		";
		if($get_recipe_video != ""){
			
			// <div>
			//	<a href=\"#video\" class=\"toggle\" data-divid=\"view_recipe_video\"><img src=\"../image.php/$get_recipe_image.png?width=847&height=437&image=/$get_recipe_image_path/$get_recipe_image\" /></a>
			//	<br />
			//	<a href=\"#video\" class=\"toggle\" data-divid=\"view_recipe_video\"><img src=\"_inc/recipes/gfx/play.png\" alt=\"play.png\" style=\"position:relative;margin-top: -200px;\" /></a>
			// </div>
			// <div class=\"view_recipe_video\" style=\"display:none;\">

			echo"
			<iframe width=\"847\" height=\"476\" src=\"$get_recipe_video\" frameborder=\"0\" allowfullscreen></iframe>
			";
		}
		else{
			if($get_recipe_image != ""){
				echo"<p style=\"padding-bottom:0;margin-bottom:0;\"><img src=\"$root/$get_recipe_image_path/$get_recipe_image\" alt=\"$get_recipe_image\" /></p>";
			}
		}
		echo"	
	<!-- //Image -->



	<!-- Recipe Header left and right -->
		<a id=\"recipe_header\"></a>
		<!-- Recipe Header left -->
			<div class=\"view_recipe_header_left\">


				<!-- Category, tags, links -->

					<table>
					 <tr>
					  <td style=\"vertical-align: top;\">
						<p style=\"margin: 2px 6px 0px 0px;padding:0;\"><img src=\"_gfx/icons/document_open.png\" alt=\"document_open.png\" /></p>
					  </td>
					  <td style=\"vertical-align: top;\">
						<p style=\"margin: 0px 0px 0px 0px;padding:0;\">$l_category: <a href=\"categories_browse.php?category_id=$get_recipe_category_id\">$get_category_translation_value</a>
						";
						// Cusine
						if($get_recipe_cusine_id != 0){
							echo"
							&middot;
							<a href=\"cuisines_browse.php?cuisine_id=$get_recipe_cusine_id\" title=\"$l_cuisine\">$get_cusine_translation_value</a>
							";
						}

						// Season
						if($get_recipe_season_id != 0){
							echo"
							&middot;
							<a href=\"seasons_browse.php?season_id=$get_recipe_season_id\" title=\"$l_season\">$get_season_translation_value</a>
							";
						}

						// Occasion
						if($get_recipe_occasion_id != 0){
							echo"
							&middot;
							<a href=\"occasions_browse.php?occasion_id=$get_recipe_occasion_id\" title=\"$l_occasion\">$get_occasion_translation_value</a>
							";
						}
						echo"
						</p>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"vertical-align: top;\">
						<p style=\"margin: 2px 6px 0px 0px;padding:0;\"><img src=\"_gfx/icons/tag_green.png\" alt=\"tag_green.png\" /></p>
					  </td>
					  <td style=\"vertical-align: top;\">
						<p style=\"margin: 0px 0px 0px 0px;padding:0;\">$l_tags: 
					";
					$x = 0;
					$query = "SELECT tag_id, tag_title, tag_title_clean FROM $t_recipes_tags WHERE tag_recipe_id=$get_recipe_id ORDER BY tag_id ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_tag_id, $get_tag_title, $get_tag_title_clean) = $row;
						echo"
						<a href=\"view_tag.php?tag=$get_tag_title_clean&amp;l=$l\">#$get_tag_title</a>
						";
						$x++;
					}
					if($x == "0"){
						echo"[<a href=\"suggest_tags.php?recipe_id=$recipe_id&amp;l=$l\">$l_suggest_tags</a>]";
					}
					echo"</p>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"vertical-align: top;\">
						<p style=\"margin: 2px 6px 0px 0px;padding:0;\"><img src=\"_gfx/icons/link.png\" alt=\"link.png\" /></p>
					  </td>
					  <td style=\"vertical-align: top;\">
						<p style=\"margin: 0px 0px 0px 0px;padding:0;\">$l_links: 

						";
						$x = 0;
						$query = "SELECT link_id, link_title, link_url, link_unique_click FROM $t_recipes_links WHERE link_recipe_id=$get_recipe_id ORDER BY link_id ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_link_id, $get_link_title, $get_link_url, $get_link_unique_click) = $row;
							if($x != 0){
								echo"&middot; ";
							}
							echo"
							<a href=\"view_link.php?link_id=$get_link_id\" title=\"$get_link_unique_click $l_unique_hits_lowercase\">$get_link_title</a>
							";
							$x++;
						}
						echo"
						</p>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"vertical-align: top;\">
						<p style=\"margin: 2px 6px 0px 0px;padding:0;\"><img src=\"_gfx/icons/eye_dark_grey.png\" alt=\"eye.png\" /></p>
					  </td>
					  <td style=\"vertical-align: top;\">
						<p style=\"margin: 0px 0px 0px 0px;padding:0;\">$get_recipe_unique_hits $l_unique_views_lovercase</p>
					  </td>
					 </tr>
					";

					// Servings
					if($servings == ""){
						$servings = $get_number_servings;
					}
					if($servings == 1){
						$servings_minus = 1;
					}
					else{
						$servings_minus = $servings - 1;
					}
					if($servings == 999){
						$servings_plus = 999;
					}
					else{
						$servings_plus = $servings + 1;
					}

					// Query
					$query_string = $_SERVER['QUERY_STRING'];
					$query_string = str_replace("recipe_id=$get_recipe_id", "", $query_string);
					$query_string = str_replace("l=$l", "", $query_string);
					$query_string = str_replace("servings=$servings", "", $query_string);
					$query_string = str_replace("&&", "", $query_string);
					echo"
					 <tr>
					  <td style=\"vertical-align: top;\">
						<a id=\"servings\"></a><p style=\"margin: 2px 6px 0px 0px;padding:0;\"><img src=\"_gfx/icons/members_edit.png\" alt=\"baseline_keyboard_arrow_down_black_18dp.png\" /></p>
					  </td>
					  <td style=\"vertical-align: top;\">
							<table>
							 <tr>
							  <td>
								<a href=\"view_recipe.php?recipe_id=$get_recipe_id&amp;servings=$servings_minus&amp;l=$l&amp;$query_string#recipe_header\"><img src=\"_gfx/icons/baseline_keyboard_arrow_down_black_18dp.png\" alt=\"baseline_keyboard_arrow_down_black_18dp.png\" /></a>

					 		  </td>
							  <td style=\"text-align:center;padding: 0px 6px 0px 6px;\">
								<p style=\"margin: 0px 0px 0px 0px;padding:0;\">$servings $l_servings_lowercase</p>
							  </td>
							  <td>
								<a href=\"view_recipe.php?recipe_id=$get_recipe_id&amp;servings=$servings_plus&amp;l=$l&amp;$query_string#recipe_header\"><img src=\"_gfx/icons/baseline_keyboard_arrow_up_black_18dp.png\" alt=\"baseline_keyboard_arrow_up_black_18dp.png\" /></a>
							  </td>
							 </tr>
							</table>
					  </td>
					 </tr>
					</table>
				<!-- //Created and Visits  -->



			</div> <!-- //view_recipe_left -->
		<!-- //Recipe Header left -->


		<!-- Recipe Header right -->
			<div class=\"view_recipe_header_right\">

				<!-- Rating -->
					<div class=\"recipe_rating\">
						<table>
					 <tr>
					  <td style=\"vertical-align: top;\">
						<p style=\"margin: 0px 0px 0px 0px;padding:0;\"><a href=\"view_recipe.php?recipe_id=$recipe_id&amp;l=$l#comments\" class=\"rating_stars_onclick\">";
						// Rating stars
						$rating_count = 1;
						for($x=0;$x<$get_rating_average;$x++){
							echo"			";
							echo"<img src=\"_gfx/icons/star_on.png\" alt=\"star_on.png\" />\n ";
							$rating_count++;
						}

						$rest = 5-$get_rating_average;
						$rating_count = $get_rating_average+1;
						for($x=0;$x<$rest;$x++){
							echo"			";
							echo"<img src=\"_gfx/icons/star_off.png\" alt=\"star_off.png\" /> ";

							$rating_count++;
						}
						echo"</a>

						<a href=\"view_recipe.php?recipe_id=$recipe_id&amp;l=$l#comments\" class=\"rating_stars_onclick\">($get_rating_total_votes)</a></p>
						<script>
						\$(document).ready(function(){
							\$(\".rating_stars_onclick\").click(function(){
								\$(\"#recipes_write_a_comment_btn\").removeClass(\"btn_default\").addClass(\"btn\");
							});
						});
						</script>

					  </td>
					 </tr>
					</table>
					</div>
				<!-- //Rating -->


				<div class=\"view_recipe_info_box\">
					";
					if($get_photo_id != "" && file_exists("$root/_uploads/users/images/$get_recipe_user_id/$get_photo_destination")){	
						echo"
						<a href=\"$root/users/view_profile.php?user_id=$get_recipe_user_id&amp;l=$l\"><img src=\"$root/_uploads/users/images/$get_recipe_user_id/$get_photo_thumb_60\" alt=\"$get_photo_destination\" class=\"recipe_author_image\" /></a>
						";
					}
					else{
						echo"
						<a href=\"$root/users/view_profile.php?user_id=$get_recipe_user_id&amp;l=$l\"><img src=\"$root/users/_gfx/avatar_blank_50.png\" style=\"position: relative; top: 0; left: 0;\" alt=\"Avatar\" class=\"recipe_author_image\" /></a>
						";
					}

					echo"
					<div class=\"recipe_author_text\">
						<p>
						$l_published_by <a href=\"$root/users/view_profile.php?user_id=$get_recipe_user_id&amp;l=$l\">$get_user_alias</a><br />
						";
						if($get_profile_city != ""){
							echo"
							<span class=\"grey\">$get_profile_city";  if($get_profile_country != ""){ echo", $get_profile_country"; } echo"</span>
							";
						}
						echo"
						</p>
					</div>
				</div>

			</div> <!-- //view_recipe_right -->
		<!-- //Recipe Header right -->
	<!-- //Recipe Header left and right -->


	<!-- Intro -->
		<div class=\"recipe_intro_wrapper\">
			<div class=\"recipe_intro\">
				<p>
				$get_recipe_introduction
				</p>
			</div>
		</div>
	<!-- //Intro -->

	<!-- Ingredients -->
		<div class=\"ingredients\">

        		<form method=\"get\" action=\"view_recipe.php#ingredients\" enctype=\"multipart/form-data\">
			<input type=\"hidden\" name=\"recipe_id\" value=\"$get_recipe_id\" />
			<input type=\"hidden\" name=\"servings\" value=\"$servings\" />
			<input type=\"hidden\" name=\"l\" value=\"$l\" />
			<a id=\"ingredients\"></a>


				<table style=\"width: 100%;\">
			";
			$x = 0;
			$query_groups = "SELECT group_id, group_title FROM $t_recipes_groups WHERE group_recipe_id=$get_recipe_id";
			$result_groups = mysqli_query($link, $query_groups);
			while($row_groups = mysqli_fetch_row($result_groups)) {
				list($get_group_id, $get_group_title) = $row_groups;
				echo"

				 <tr>
				  <td class=\"ingredients_headcell\">
					<h2 style=\"padding:0;margin:0;\">$get_group_title</h2>
				  </td>
				  <td class=\"ingredients_headcell_desktop\" style=\"text-align: center;\">
					<span>$l_calories</span>
				  </td>
				  <td class=\"ingredients_headcell_desktop\" style=\"text-align: center;\">
					<span>$l_fat</span>
				  </td>
				  <td class=\"ingredients_headcell_desktop\" style=\"text-align: center;\">
					<span>$l_carbs_abbreviation</span>
				  </td>
				  <td class=\"ingredients_headcell_desktop\" style=\"text-align: center;\">
					<span>$l_protein</span>
				  </td>
				  <td class=\"ingredients_headcell_desktop\" style=\"text-align: center;\">
					<span>";
					if($get_recipe_country == "United States"){
						echo"$l_sodium";
					}
					else{
						echo"$l_salt";
					}
					echo"</span>
				  </td>
				 </tr>
				";

				$items_calories_total 	= 0;
				$items_fat_total 	= 0;
				$items_carbs_total 	= 0;
				$items_protein_total 	= 0;
				$items_salt_total 	= 0;
				$items_sodium_total 	= 0;

				$items_calories_serving	= 0;
				$items_fat_serving 	= 0;
				$items_carbs_serving	= 0;
				$items_protein_serving	= 0;
				$items_salt_serving 	= 0;
				$items_sodium_serving 	= 0;
	
				$query_items = "SELECT item_id, item_recipe_id, item_group_id, item_amount, item_measurement, item_grocery, item_grocery_explanation, item_food_id, item_calories_per_hundred, item_fat_per_hundred, item_fat_of_which_saturated_fatty_acids_per_hundred, item_carbs_per_hundred, item_carbs_of_which_dietary_fiber_hundred, item_carbs_of_which_sugars_per_hundred, item_proteins_per_hundred, item_salt_per_hundred, item_sodium_per_hundred, item_calories_calculated, item_fat_calculated, item_fat_of_which_saturated_fatty_acids_calculated, item_carbs_calculated, item_carbs_of_which_dietary_fiber_calculated, item_carbs_of_which_sugars_calculated, item_proteins_calculated, item_salt_calculated, item_sodium_calculated FROM $t_recipes_items WHERE item_group_id=$get_group_id";
				$result_items = mysqli_query($link, $query_items);
				$row_cnt = mysqli_num_rows($result_items);
				while($row_items = mysqli_fetch_row($result_items)) {
					list($get_item_id, $get_item_recipe_id, $get_item_group_id, $get_item_amount, $get_item_measurement, $get_item_grocery, $get_item_grocery_explanation, $get_item_food_id, $get_item_calories_per_hundred, $get_item_fat_per_hundred, $get_item_fat_of_which_saturated_fatty_acids_per_hundred, $get_item_carbs_per_hundred, $get_item_carbs_of_which_dietary_fiber_hundred, $get_item_carbs_of_which_sugars_per_hundred, $get_item_proteins_per_hundred, $get_item_salt_per_hundred, $get_item_sodium_per_hundred, $get_item_calories_calculated, $get_item_fat_calculated, $get_item_fat_of_which_saturated_fatty_acids_calculated, $get_item_carbs_calculated, $get_item_carbs_of_which_dietary_fiber_calculated, $get_item_carbs_of_which_sugars_calculated, $get_item_proteins_calculated, $get_item_salt_calculated, $get_item_sodium_calculated) = $row_items;

					// Null check
					if($get_item_sodium_calculated == ""){
						echo"<div class=\"info\">Sodium calculated was blank</div>";
						$result_update = mysqli_query($link, "UPDATE $t_recipes_items SET item_sodium_calculated='0' WHERE item_id=$get_item_id");
			
					}

					// Style
					if(isset($style) && $style == "bodycell"){
						$style = "subcell";
					}
					else{
						$style = "bodycell";
					}

					// Amount
					if(isset($_GET["amount_$get_item_id"])) {
						$amount = $_GET["amount_$get_item_id"];
						$amount = strip_tags(stripslashes($amount));
						$amount = str_replace(",", ".", $amount);
	
						if(!is_numeric($amount)){
							$amount = ($get_item_amount/$get_number_servings)*$servings;
						}


						// Calories
						$get_item_calories_calculated = round(($get_item_calories_calculated/$get_item_amount)*$amount, 0);
						$get_item_fat_calculated = round(($get_item_fat_calculated/$get_item_amount)*$amount, 0);
						$get_item_carbs_calculated = round(($get_item_carbs_calculated/$get_item_amount)*$amount, 0);
						$get_item_proteins_calculated = round(($get_item_proteins_calculated/$get_item_amount)*$amount, 0);
						$get_item_salt_calculated = round(($get_item_salt_calculated/$get_item_amount)*$amount, 0);
						$get_item_sodium_calculated = round(($get_item_sodium_calculated/$get_item_amount)*$amount, 0);

					}
					else{
						if($servings == $get_number_servings){
							$amount = "$get_item_amount";
						}
						else{
							$amount = ($get_item_amount/$get_number_servings)*$servings;
						}
					}

					// Calories
					if($servings == $get_number_servings){
						$calories = "$get_item_calories_calculated";
					}
					else{
						if(isset($_GET["amount_$get_item_id"])) {
							$calories = $get_item_calories_calculated;
						}
						else{
							$calories = round(($get_item_calories_calculated/$get_number_servings)*$servings, 0);
						}
					}

					// Fat
					if($servings == $get_number_servings){
						$fat = "$get_item_fat_calculated";
					}
					else{
						if(isset($_GET["amount_$get_item_id"])) {
							$fat = $get_item_fat_calculated;
						}
						else{
							$fat = round(($get_item_fat_calculated/$get_number_servings)*$servings, 0);
						}
					}

					// Carbs
					if($servings == $get_number_servings){
						$carbs = "$get_item_carbs_calculated";
					}
					else{
						if(isset($_GET["amount_$get_item_id"])) {
							$carbs = $get_item_carbs_calculated;
						}
						else{
							$carbs = round(($get_item_carbs_calculated/$get_number_servings)*$servings, 0);
						}
					}


					// Protein
					if($servings == $get_number_servings){
						$protein = "$get_item_proteins_calculated";
					}
					else{
						if(isset($_GET["amount_$get_item_id"])) {
							$protein = $get_item_proteins_calculated;
						}
						else{
							$protein = round(($get_item_proteins_calculated/$get_number_servings)*$servings, 0);
						}
					}


					// Salt
					if($servings == $get_number_servings){
						$salt = "$get_item_salt_calculated";
					}
					else{
						if(isset($_GET["amount_$get_item_id"])) {
							$salt = $get_item_salt_calculated;
						}
						else{
							$salt = round(($get_item_salt_calculated/$get_number_servings)*$servings, 0);
						}
					}

					// Sodium
					if($servings == $get_number_servings){
						$sodium = "$get_item_sodium_calculated";
					}
					else{
						if(isset($_GET["amount_$get_item_id"])) {
							$sodium = $get_item_sodium_calculated;
						}
						else{
							$sodium = round(($get_item_sodium_calculated/$get_number_servings)*$servings, 0);
						}
					}

					// Total
					$items_calories_total 	= $items_calories_total + $calories;
					$items_fat_total 	= $items_fat_total + $fat;
					$items_carbs_total 	= $items_carbs_total + $carbs;
					$items_protein_total 	= $items_protein_total + $protein;
					$items_salt_total 	= $items_salt_total + $salt;
					$items_sodium_total	= $items_sodium_total + $sodium;


					$items_calories_serving	= $items_calories_serving + ($get_item_calories_calculated/$get_number_servings);
					$items_fat_serving 	= $items_fat_serving + ($get_item_fat_calculated/$get_number_servings);
					$items_carbs_serving	= $items_carbs_serving	+ ($get_item_carbs_calculated/$get_number_servings);
					$items_protein_serving	= $items_protein_serving + ($get_item_proteins_calculated/$get_number_servings);
					$items_salt_serving 	= $items_salt_serving + ($get_item_salt_calculated/$get_number_servings);
					$items_sodium_serving 	= $items_sodium_serving + ($get_item_sodium_calculated/$get_number_servings);


					echo"
					 <tr>
					  <td class=\"ingredients_body_$style\">
						

						<span><input type=\"text\" name=\"amount_$get_item_id\" size=\"1\" value=\"$amount\" class=\"ingredients_amount\" />$get_item_measurement</span>
					
						<span>";
						if($get_item_food_id != "" && $get_item_food_id != "0"){
								echo"<a href=\"$root/food/view_food.php?food_id=$get_item_food_id&amp;l=$l\">$get_item_grocery</a>";
						}
						else{
							echo"$get_item_grocery";
						}
						echo"<br /></span>


						<div class=\"mobile_only\">
							<table>
							 <tr>
							  <td style=\"padding: 5px 10px 0px 0px;text-align: center;\">
								<span class=\"grey_small\">$calories</span>
							  </td>
							  <td style=\"padding: 5px 10px 0px 0px;text-align: center;\">
								<span class=\"grey_small\">$fat</span>
							  </td>
							  <td style=\"padding: 5px 10px 0px 0px;text-align: center;\">
								<span class=\"grey_small\">$carbs</span>
							  </td>
							  <td style=\"padding: 5px 10px 0px 0px;text-align: center;\">
								<span class=\"grey_small\">$protein</span>
							  </td>
							  <td style=\"padding: 5px 0px 0px 0px;text-align: center;\">
								<span class=\"grey_small\">";
								if($get_recipe_country == "United States"){
									echo"$sodium";
								}
								else{
									echo"$salt";
								}
								echo"</span>
							  </td>
							 </tr>
							 <tr>
							  <td style=\"padding-right: 10px;text-align: center;\">
								<span class=\"grey_small\">$l_calories</span>
							  </td>
							  <td style=\"padding-right: 10px;text-align: center;\">
								<span class=\"grey_small\">$l_fat</span>
							  </td>
							  <td style=\"padding-right: 10px;text-align: center;\">
								<span class=\"grey_small\">$l_carbs_abbreviation</span>
							  </td>
							  <td style=\"padding-right: 10px;text-align: center;\">
								<span class=\"grey_small\">$l_protein</span>
							  </td>
							  <td style=\"text-align: center;\">
								<span class=\"grey_small\">";
								if($get_recipe_country == "United States"){
									echo"$l_sodium";
								}
								else{
									echo"$l_salt";
								}
								echo"</span>
							  </td>
							 </tr>
							</table>
						</div>
					  </td>
					  <td class=\"ingredients_body_desktop_$style\" style=\"text-align: center;\">
						<span>$calories</span>
					  </td>
					  <td class=\"ingredients_body_desktop_$style\" style=\"text-align: center;\">
						<span>$fat</span>
					  </td>
					  <td class=\"ingredients_body_desktop_$style\" style=\"text-align: center;\">
						<span>$carbs</span>
					  </td>
					  <td class=\"ingredients_body_desktop_$style\" style=\"text-align: center;\">
						<span>$protein</span>
					  </td>
					  <td class=\"ingredients_body_desktop_$style\" style=\"text-align: center;\">
						<span>";
						if($get_recipe_country == "United States"){
							echo"$sodium";
						}
						else{
							echo"$salt";
						}
						echo"</span>
					  </td>
					 </tr>
					 ";
				}

				// Serving and total
				$items_calories_serving	= round($items_calories_serving, 0);
				$items_fat_serving 	= round($items_fat_serving, 0);
				$items_carbs_serving	= round($items_carbs_serving, 0);
				$items_protein_serving	= round($items_protein_serving, 0);
				$items_salt_serving 	= round($items_salt_serving, 0);
				$items_sodium_serving 	= round($items_sodium_serving, 0);

				$items_calories_total 	= round($items_calories_total, 0);
				$items_fat_total 	= round($items_fat_total, 0);
				$items_carbs_total 	= round($items_carbs_total, 0);
				$items_protein_total 	= round($items_protein_total, 0);
				$items_salt_total 	= round($items_salt_total, 0);
				$items_sodium_total 	= round($items_sodium_total, 0);


				// Style
				if(isset($style) && $style == "bodycell"){
					$style = "subcell";
				}
				else{
					$style = "bodycell";
				}
				echo"
					 <tr>
					  <td class=\"ingredients_body_$style\">
						<span><input type=\"submit\" value=\"$l_update\" class=\"btn_default\" /></span>
						<div style=\"float: right;\" class=\"desktop_only\"><em>$l_serving</em></div>

						<div class=\"mobile_only\" style=\"clear:left;\">
							
							<table>
							 <tr>
							  <td style=\"padding: 5px 10px 0px 0px;text-align: right\">
								<em>$l_serving</em>
							  </td>
							  <td style=\"padding: 5px 10px 0px 0px;text-align: center;\">
								<em>$items_calories_serving</em>
							  </td>
							  <td style=\"padding: 5px 10px 0px 0px;text-align: center;\">
								<em>$items_fat_serving</em>
							  </td>
							  <td style=\"padding: 5px 10px 0px 0px;text-align: center;\">
								<em>$items_carbs_serving</em>
							  </td>
							  <td style=\"padding: 5px 10px 0px 0px;text-align: center;\">
								<em>$items_protein_serving</em>
							  </td>
							  <td style=\"padding: 5px 0px 0px 0px;text-align: center;\">
								<em>";
								if($get_recipe_country == "United States"){
									echo"$items_sodium_serving";
								}
								else{
									echo"$items_salt_serving";
								}
								echo"</em>
							  </td>
							 </tr>
							 <tr>
							  <td style=\"padding: 5px 10px 0px 0px;text-align: right\">
								<em>$l_total</em>
							  </td>
							  <td style=\"padding: 5px 10px 0px 0px;text-align: center;\">
								<em>$items_calories_total</em>
							  </td>
							  <td style=\"padding: 5px 10px 0px 0px;text-align: center;\">
								<em>$items_fat_total</em>
							  </td>
							  <td style=\"padding: 5px 10px 0px 0px;text-align: center;\">
								<em>$items_carbs_total</em>
							  </td>
							  <td style=\"padding: 5px 10px 0px 0px;text-align: center;\">
								<em>$items_protein_total</em>
							  </td>
							  <td style=\"padding: 5px 0px 0px 0px;text-align: center;\">
								<em>";
								if($get_recipe_country == "United States"){
									echo"$items_sodium_total";
								}
								else{
									echo"$items_salt_total";
								}
								echo"</em>
							  </td>
							 </tr>
							 <tr>
							  <td style=\"padding-right: 10px;text-align: center;\">
								
							  </td>
							  <td style=\"padding-right: 10px;text-align: center;\">
								<span class=\"grey_small\">$l_calories</span>
							  </td>
							  <td style=\"padding-right: 10px;text-align: center;\">
								<span class=\"grey_small\">$l_fat</span>
							  </td>
							  <td style=\"padding-right: 10px;text-align: center;\">
								<span class=\"grey_small\">$l_carbs_abbreviation</span>
							  </td>
							  <td style=\"padding-right: 10px;text-align: center;\">
								<span class=\"grey_small\">$l_protein</span>
							  </td>
							  <td style=\"text-align: center;\">
								<span class=\"grey_small\">";
								if($get_recipe_country == "United States"){
									echo"$l_sodium";
								}
								else{
									echo"$l_salt";
								}
								echo"</span>
							  </td>
							 </tr>
							</table>
						</div> <!-- Mobile only -->


					  </td>
					  <td class=\"ingredients_body_desktop_$style\" style=\"text-align: center;\">
						<em>$items_calories_serving</em>
					  </td>
					  <td class=\"ingredients_body_desktop_$style\" style=\"text-align: center;\">
						<em>$items_fat_serving</em>
					  </td>
					  <td class=\"ingredients_body_desktop_$style\" style=\"text-align: center;\">
						<em>$items_carbs_serving</em>
					  </td>
					  <td class=\"ingredients_body_desktop_$style\" style=\"text-align: center;\">
						<em>$items_protein_serving</em>
					  </td>
					  <td class=\"ingredients_body_desktop_$style\" style=\"text-align: center;\">
						<em>";
						if($get_recipe_country == "United States"){
							echo"$items_sodium_serving";
						}
						else{
							echo"$items_salt_serving";
						}
						echo"</em>
					  </td>
					 </tr>";

				// Total

				echo"
					 <tr>
					  <td class=\"ingredients_body_desktop_$style\" style=\"text-align: right;\">
						<em>$l_total</em>
					  </td>
					  <td class=\"ingredients_body_desktop_$style\" style=\"text-align: center;\">
						<em>$items_calories_total</em>
					  </td>
					  <td class=\"ingredients_body_desktop_$style\" style=\"text-align: center;\">
						<em>$items_fat_total</em>
					  </td>
					  <td class=\"ingredients_body_desktop_$style\" style=\"text-align: center;\">
						<em>$items_carbs_total</em>
					  </td>
					  <td class=\"ingredients_body_desktop_$style\" style=\"text-align: center;\">
						<em>$items_protein_total</em>
					  </td>
					  <td class=\"ingredients_body_desktop_$style\" style=\"text-align: center;\">
						<em>";
						if($get_recipe_country == "United States"){
							echo"$items_sodium_total";
						}
						else{
							echo"$items_salt_total";
						}
						echo"</em>
					  </td>
					 </tr>
					 ";



				$x++;
				echo"
				";
			} // while groups
		echo"	
				</table>
			</form>
		</div>
	<!-- //Ingredients -->




	
	<!-- Directions -->
		<div class=\"directions\">

			<h2>$l_directions</h2>

			$get_recipe_directions
		</div>
	<!-- //Directions -->


	<!-- Comments -->
		<a id=\"comments\"></a>

		<h2>$l_comments</h2>

		<p>
		<a href=\"view_recipe_write_comment.php?recipe_id=$recipe_id&amp;l=$l\" class=\"btn_default\" id=\"recipes_write_a_comment_btn\">$l_write_a_comment</a>	
		</p>


		<!-- Feedback -->
			";
			if($ft != ""){
				if($fm == "changes_saved"){
					$fm = "$l_changes_saved";
				}
				else{
					$fm = str_replace("_", " ", $fm);
					$fm = ucfirst($fm);
				}
				echo"<div class=\"$ft\"><span>$fm</span></div>";
			}
			echo"	
		<!-- //Feedback -->


		<!-- View comments -->
			";
			$query_groups = "SELECT comment_id, comment_recipe_id, comment_language, comment_approved, comment_datetime, comment_time, comment_date_print, comment_user_id, comment_user_alias, comment_user_image_path, comment_user_image_file, comment_user_ip, comment_user_hostname, comment_user_agent, comment_title, comment_text, comment_rating, comment_helpful_clicks, comment_useless_clicks, comment_marked_as_spam, comment_spam_checked, comment_spam_checked_comment FROM $t_recipes_comments WHERE comment_recipe_id=$get_recipe_id ORDER BY comment_id ASC";
			$result_groups = mysqli_query($link, $query_groups);
			while($row_groups = mysqli_fetch_row($result_groups)) {
				list($get_comment_id, $get_comment_recipe_id, $get_comment_language, $get_comment_approved, $get_comment_datetime, $get_comment_time, $get_comment_date_print, $get_comment_user_id, $get_comment_user_alias, $get_comment_user_image_path, $get_comment_user_image_file, $get_comment_user_ip, $get_comment_user_hostname, $get_comment_user_agent, $get_comment_title, $get_comment_text, $get_comment_rating, $get_comment_helpful_clicks, $get_comment_useless_clicks, $get_comment_marked_as_spam, $get_comment_spam_checked, $get_comment_spam_checked_comment) = $row_groups;
		
				echo"
				<a id=\"comment$get_comment_id\"></a>
				<div class=\"clear\" style=\"height:14px;\"></div>

				<div class=\"comment_item\">
					<table style=\"width: 100%;\">
					 <tr>
					  <td style=\"width: 80px;vertical-align:top;\">
						<!-- Image -->
							<p style=\"padding: 10px 0px 10px 0px;margin:0;\">
							<a href=\"$root/users/view_profile.php?user_id=$get_comment_user_id&amp;l=$l\">";
							if($get_comment_user_image_file == "" OR !(file_exists("$root/$get_comment_user_image_path/$get_comment_user_image_file"))){ 
								echo"<img src=\"$root/comments/_gfx/avatar_blank_65.png\" alt=\"avatar_blank_65.png\" class=\"comment_avatar\" />";
							} 
							else{ 
								$inp_new_x = 65; // 950
								$inp_new_y = 65; // 640
								$thumb_full_path = "$root/$get_comment_user_image_path/user_" . $get_comment_user_id . "-" . $inp_new_x . "x" . $inp_new_y . ".png";
								if(!(file_exists("$thumb_full_path"))){
									resize_crop_image($inp_new_x, $inp_new_y, "$root/_uploads/users/images/$get_comment_user_id/$get_comment_user_image_file", "$thumb_full_path");
								}

								echo"	<img src=\"$thumb_full_path\" alt=\"$get_comment_user_image_file\" class=\"comment_view_avatar\" />"; 
							} 
							echo"</a>
							</p>
							<!-- //Image -->
					  </td>
					  <td style=\"vertical-align:top;\">

						<!-- Stars, title and menu -->
						<table style=\"width: 100%;\">
						 <tr>
						  <td>
							<p style=\"margin:0;padding:0;\">
								";
								for($x=0;$x<$get_comment_rating;$x++){
									echo"<img src=\"_gfx/icons/star_on.png\" alt=\"star_on.png\" /> ";
								}
								$off = 5-$get_comment_rating;
								for($x=0;$x<$off;$x++){
									echo"<img src=\"_gfx/icons/star_off.png\" alt=\"star_off.png\" /> ";
								}
								echo"
								<b style=\"padding-left: 10px;\">$get_comment_title</b>
								</p>
						  </td>
						  <td style=\"text-align: right;\">


							<!-- Menu -->
							";
							if(isset($my_user_id)){
								if($get_comment_user_id == "$my_user_id" OR $get_my_user_rank == "admin" OR $get_my_user_rank == "moderator"){
									echo"
									<a href=\"edit_comment.php?comment_id=$get_comment_id&amp;l=$l\"><img src=\"$root/users/_gfx/edit.png\" alt=\"edit.png\" title=\"$l_edit\" /></a>
									<a href=\"delete_comment.php?comment_id=$get_comment_id&amp;l=$l\"><img src=\"$root/users/_gfx/delete.png\" alt=\"delete.png\" title=\"$l_delete\" /></a>
									";
								}
								else{
									echo"
									<a href=\"report_comment.php?comment_id=$get_comment_id&amp;l=$l\"><img src=\"$root/comments/_gfx/report_grey.png\" alt=\"report_grey.png\" title=\"$l_report\" /></a>
									";
								}
							}
							echo"
							<!-- //Menu -->
						  </td>
						 </tr>
						</table>
						<!-- //Stars, title and menu -->


						<!-- Author + date -->
						<p style=\"margin:0;padding:0;\">
						<span class=\"recipes_comment_by\">$l_by</span>
						<a href=\"$root/users/view_profile.php?user_id=$get_comment_user_id&amp;l=$l\" class=\"recipes_comment_author\">$get_comment_user_alias</a>
						<a href=\"#comment$get_comment_id\" class=\"recipes_comment_date\">$get_comment_date_print</a></span>
						</p>

						<!-- //Author + date -->

						<!-- Comment -->
							<p style=\"margin-top: 0px;padding-top: 0;\">$get_comment_text</p>
						<!-- Comment -->
					  </td>
					 </tr>
					</table>
				</div>
				";
			}
			echo"
		<!-- //View comments -->

	<!-- //Comments -->


	";
	} // can view recipe
} // recipe found

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>