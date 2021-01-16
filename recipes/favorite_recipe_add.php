<?php 
/**
*
* File: recipes/favorite_recipe_add.php
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

/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/recipes/ts_recipes.php");


/*- Tables ---------------------------------------------------------------------------------- */
include("_tables.php");


/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['recipe_id'])){
	$recipe_id = $_GET['recipe_id'];
	$recipe_id = output_html($recipe_id);
}
else{
	$recipe_id = "";
}
$tabindex = 0;
$l_mysql = quote_smart($link, $l);

/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_recipes";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */

// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
	// Get my profile
	$my_user_id = $_SESSION['user_id'];
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	$query = "SELECT user_id, user_alias, user_date_format FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_alias, $get_my_user_date_format) = $row;

	// Get recipe
	$recipe_id_mysql = quote_smart($link, $recipe_id);
	$query = "SELECT recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_country, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb_278x156, recipe_video, recipe_date, recipe_date_saying, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_comments, recipe_times_favorited, recipe_user_ip, recipe_notes, recipe_password, recipe_last_viewed, recipe_age_restriction, recipe_published FROM $t_recipes WHERE recipe_id=$recipe_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_recipe_id, $get_recipe_user_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_language, $get_recipe_country, $get_recipe_introduction, $get_recipe_directions, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb_278x156, $get_recipe_video, $get_recipe_date, $get_recipe_date_saying, $get_recipe_time, $get_recipe_cusine_id, $get_recipe_season_id, $get_recipe_occasion_id, $get_recipe_marked_as_spam, $get_recipe_unique_hits, $get_recipe_unique_hits_ip_block, $get_recipe_comments, $get_recipe_times_favorited, $get_recipe_user_ip, $get_recipe_notes, $get_recipe_password, $get_recipe_last_viewed, $get_recipe_age_restriction, $get_recipe_published) = $row;

	if($get_recipe_id == ""){
		echo"
		<h1>Server error</h1>

		<p>
		Recipe not found.
		</p>
		";
	}
	else{
		// Category
		$inp_recipe_language_mysql = quote_smart($link, $get_recipe_language);
		$query = "SELECT category_translation_value FROM $t_recipes_categories_translations WHERE category_id=$get_recipe_category_id AND category_translation_language=$inp_recipe_language_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_category_translation_value) = $row;



		// Check if I alreaddy have it
		$q = "SELECT recipe_favorite_id FROM $t_recipes_favorites WHERE recipe_favorite_recipe_id=$get_recipe_id AND recipe_favorite_user_id=$my_user_id_mysql";
		$r = mysqli_query($link, $q);
		$rowb = mysqli_fetch_row($r);
		list($get_recipe_favorite_id) = $rowb;
		if($get_recipe_favorite_id == ""){
			// Insert
			mysqli_query($link, "INSERT INTO $t_recipes_favorites
			(recipe_favorite_id, recipe_favorite_recipe_id, recipe_favorite_user_id, recipe_favorite_comment) 
			VALUES 
			(NULL, '$get_recipe_id', $my_user_id_mysql, '')")
			or die(mysqli_error($link));

			// Update recipe
			$inp_count = $get_recipe_times_favorited+1;
			mysqli_query($link, "UPDATE $t_recipes SET recipe_times_favorited=$inp_count WHERE recipe_id=$get_recipe_id") or die(mysqli_error($link)); 

			// Chef of the month
			$year = date("Y");
			$month = date("m");
			$month_full = date("F");
			$month_short = date("M");
				
			$query = "SELECT stats_chef_of_the_month_id, stats_chef_of_the_month_recipes_posted_count, stats_chef_of_the_month_recipes_posted_points, stats_chef_of_the_month_got_visits_count, stats_chef_of_the_month_got_visits_points, stats_chef_of_the_month_got_favorites_count, stats_chef_of_the_month_got_favorites_points, stats_chef_of_the_month_got_comments_count, stats_chef_of_the_month_got_comments_points, stats_chef_of_the_month_total_points FROM $t_recipes_stats_chef_of_the_month WHERE stats_chef_of_the_month_month=$month AND stats_chef_of_the_month_year=$year AND stats_chef_of_the_month_user_id=$get_recipe_user_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_stats_chef_of_the_month_id, $get_stats_chef_of_the_month_recipes_posted_count, $get_stats_chef_of_the_month_recipes_posted_points, $get_stats_chef_of_the_month_got_visits_count, $get_stats_chef_of_the_month_got_visits_points, $get_stats_chef_of_the_month_got_favorites_count, $get_stats_chef_of_the_month_got_favorites_points, $get_stats_chef_of_the_month_got_comments_count, $get_stats_chef_of_the_month_got_comments_points, $get_stats_chef_of_the_month_total_points) = $row;
			if($get_stats_chef_of_the_month_id == ""){
				// Author Photo
				$q = "SELECT photo_id, photo_user_id, photo_destination, photo_thumb_50, photo_thumb_60, photo_thumb_200 FROM $t_users_profile_photo WHERE photo_user_id='$get_recipe_user_id' AND photo_profile_image='1'";
				$r = mysqli_query($link, $q);
				$rowb = mysqli_fetch_row($r);
				list($get_photo_id, $get_photo_user_id, $get_photo_destination, $get_photo_thumb_50, $get_photo_thumb_60, $get_photo_thumb_200) = $rowb;

				// Insert chef of the month
				$inp_user_name_mysql = quote_smart($link, $get_recipe_user_name);
				$inp_user_photo_path_mysql = quote_smart($link, "_uploads/users/images/$get_recipe_user_id");
				$inp_user_photo_thumb_mysql = quote_smart($link, $get_photo_thumb_200);

				mysqli_query($link, "INSERT INTO $t_recipes_stats_chef_of_the_month 
				(stats_chef_of_the_month_id, stats_chef_of_the_month_month, stats_chef_of_the_month_month_full, stats_chef_of_the_month_month_short, stats_chef_of_the_month_year, 
				stats_chef_of_the_month_user_id, stats_chef_of_the_month_user_name, stats_chef_of_the_month_user_photo_path, stats_chef_of_the_month_user_photo_thumb, stats_chef_of_the_month_recipes_posted_count, 
				stats_chef_of_the_month_recipes_posted_points, stats_chef_of_the_month_got_visits_count, stats_chef_of_the_month_got_visits_points, stats_chef_of_the_month_got_favorites_count, stats_chef_of_the_month_got_favorites_points, 
				stats_chef_of_the_month_got_comments_count, stats_chef_of_the_month_got_comments_points, stats_chef_of_the_month_total_points) 
				VALUES 
				(NULL, $month, '$month_full', '$month_short', $year,
				$get_recipe_user_id, $inp_user_name_mysql, $inp_user_photo_path_mysql, $inp_user_photo_thumb_mysql, 0,
				0,0, 0, 1, 5, 0,
				0, 5)")
				or die(mysqli_error($link));
			}
			else{
				// Update visit
				$inp_count = $get_stats_chef_of_the_month_got_favorites_count+1;
				$inp_points = $inp_count*5;
				$inp_total_points = $get_stats_chef_of_the_month_recipes_posted_points+$get_stats_chef_of_the_month_got_visits_points+$get_stats_chef_of_the_month_got_favorites_points+$inp_points;
				mysqli_query($link, "UPDATE $t_recipes_stats_chef_of_the_month SET stats_chef_of_the_month_got_favorites_count=$inp_count, stats_chef_of_the_month_got_favorites_points=$inp_points, stats_chef_of_the_month_total_points=$inp_total_points WHERE stats_chef_of_the_month_id=$get_stats_chef_of_the_month_id") or die(mysqli_error($link)); 
			}


			// Stats :: Favorited per month
			$inp_recipe_title_mysql = quote_smart($link, $get_recipe_title);
			$inp_recipe_image_path_mysql = quote_smart($link, $get_recipe_image_path);
			$inp_recipe_image_mysql = quote_smart($link, $get_recipe_image);
			$inp_recipe_thumb_278x156_mysql = quote_smart($link, $get_recipe_thumb_278x156);
			$inp_category_translation_value_mysql = quote_smart($link, $get_category_translation_value);


			$query = "SELECT stats_favorited_per_month_id, stats_favorited_per_month_count FROM $t_recipes_stats_favorited_per_month WHERE stats_favorited_per_month_month=$month AND stats_favorited_per_month_year=$year AND stats_favorited_per_month_recipe_id=$get_recipe_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_stats_favorited_per_month_id, $get_stats_favorited_per_month_count) = $row;
			if($get_stats_favorited_per_month_id == ""){
				// Insert IP block
				mysqli_query($link, "INSERT INTO $t_recipes_stats_favorited_per_month 
				(stats_favorited_per_month_id, stats_favorited_per_month_month, stats_favorited_per_month_month_full, stats_favorited_per_month_month_short, stats_favorited_per_month_year, 
				stats_favorited_per_month_recipe_id, stats_favorited_per_month_recipe_title, stats_favorited_per_month_recipe_image_path, stats_favorited_per_month_recipe_thumb_278x156, stats_favorited_per_month_recipe_language, 
				stats_favorited_per_month_recipe_category_id, stats_favorited_per_month_recipe_category_translated, stats_favorited_per_month_count) 
				VALUES 
				(NULL, $month, '$month_full', '$month_short', $year, 
				$get_recipe_id, $inp_recipe_title_mysql, $inp_recipe_image_path_mysql, $inp_recipe_thumb_278x156_mysql, $inp_recipe_language_mysql, 
				$get_recipe_category_id, $inp_category_translation_value_mysql, 1
				)")
				or die(mysqli_error($link)); 
			}
			else{
				// Update favorited
				$inp_count = $get_stats_favorited_per_month_count+1;
				mysqli_query($link, "UPDATE $t_recipes_stats_favorited_per_month SET stats_favorited_per_month_count=$inp_count WHERE stats_favorited_per_month_id=$get_stats_favorited_per_month_id") or die(mysqli_error($link)); 
			}



			// Stats :: Favorited per year
			$query = "SELECT stats_favorited_per_year_id, stats_favorited_per_year_count FROM $t_recipes_stats_favorited_per_year WHERE stats_favorited_per_year_year=$year AND stats_favorited_per_year_recipe_id=$get_recipe_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_stats_favorited_per_year_id, $get_stats_favorited_per_year_count) = $row;
			if($get_stats_favorited_per_year_id == ""){
				// Insert IP block
				mysqli_query($link, "INSERT INTO $t_recipes_stats_favorited_per_year
				(stats_favorited_per_year_id, stats_favorited_per_year_year, stats_favorited_per_year_recipe_id, stats_favorited_per_year_recipe_title, stats_favorited_per_year_recipe_image_path, stats_favorited_per_year_recipe_thumb_278x156, stats_favorited_per_year_recipe_language, stats_favorited_per_year_recipe_category_id, stats_favorited_per_year_recipe_category_translated, stats_favorited_per_year_count) 
				VALUES 
				(NULL, $year, $get_recipe_id, $inp_recipe_title_mysql, $inp_recipe_image_path_mysql, $inp_recipe_thumb_278x156_mysql, $inp_recipe_language_mysql, $get_recipe_category_id, $inp_category_translation_value_mysql, 1
				)")
				or die(mysqli_error($link)); 
			}
			else{
				// Update favorited
				$inp_count = $get_stats_favorited_per_year_count+1;
				mysqli_query($link, "UPDATE $t_recipes_stats_favorited_per_year SET stats_favorited_per_year_count=$inp_count WHERE stats_favorited_per_year_id=$get_stats_favorited_per_year_id") or die(mysqli_error($link)); 
			}



			// Header
			$ft = "success";
			$fm = "recipe_favorited";
			$url = "view_recipe.php?recipe_id=$get_recipe_id&l=$l&ft=success&fm=$fm#favorite";
			if($process == "1"){
				header("Location: $url");
				exit;
			}
			else{
				echo"
				<h1>
				<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
				Loading...</h1>
				<meta http-equiv=\"refresh\" content=\"1;url=$url\">
				";

			}
		}


	} // recipe found
}
else{
	echo"
	<h1>
	<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/index.php?page=login&amp;l=$l\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>