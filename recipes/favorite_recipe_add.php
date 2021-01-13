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
	$query = "SELECT recipe_id, recipe_user_id, recipe_title FROM $t_recipes WHERE recipe_id=$recipe_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_recipe_id, $get_recipe_user_id, $get_recipe_title) = $row;

	if($get_recipe_id == ""){
		echo"
		<h1>Server error</h1>

		<p>
		Recipe not found.
		</p>
		";
	}
	else{
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