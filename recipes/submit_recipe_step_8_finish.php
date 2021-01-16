<?php 
/**
*
* File: recipes/step_2_directions.php
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

/*- Tables ---------------------------------------------------------------------------------- */
include("_tables.php");


/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/recipes/ts_recipes.php");

/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['mode'])){
	$mode = $_GET['mode'];
	$mode = output_html($mode);
}
else{
	$mode = "";
}
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
$website_title = "$l_recipes - $l_submit_recipe";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */

// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
	// Dates
	$week = date("W");
	$year = date("Y");
	$month = date("m");
	$month_full = date("F");
	$month_short = date("M");

	// Get recipe
	$recipe_id_mysql = quote_smart($link, $recipe_id);
	$inp_recipe_user_id = $_SESSION['user_id'];
	$inp_recipe_user_id = output_html($inp_recipe_user_id);
	$inp_recipe_user_id_mysql = quote_smart($link, $inp_recipe_user_id);


	$query = "SELECT recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb_278x156, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password, recipe_last_viewed FROM $t_recipes WHERE recipe_id=$recipe_id_mysql AND recipe_user_id=$inp_recipe_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_recipe_id, $get_recipe_user_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_language, $get_recipe_introduction, $get_recipe_directions, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb_278x156, $get_recipe_video, $get_recipe_date, $get_recipe_time, $get_recipe_cusine_id, $get_recipe_season_id, $get_recipe_occasion_id, $get_recipe_marked_as_spam, $get_recipe_unique_hits, $get_recipe_unique_hits_ip_block, $get_recipe_user_ip, $get_recipe_notes, $get_recipe_password, $get_recipe_last_viewed) = $row;

	if($get_recipe_id == ""){
		echo"
		<h1>Server error</h1>

		<p>
		Recipe not found.
		</p>
		";
	}
	else{

		// Author
		$query = "SELECT user_name, user_alias FROM $t_users WHERE user_id=$inp_recipe_user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_user_name, $get_user_alias) = $row;

		// Author Photo
		$q = "SELECT photo_id, photo_user_id, photo_destination, photo_thumb_50, photo_thumb_60, photo_thumb_200 FROM $t_users_profile_photo WHERE photo_user_id=$inp_recipe_user_id_mysql AND photo_profile_image='1'";
		$r = mysqli_query($link, $q);
		$rowb = mysqli_fetch_row($r);
		list($get_photo_id, $get_photo_user_id, $get_photo_destination, $get_photo_thumb_50, $get_photo_thumb_60, $get_photo_thumb_200) = $rowb;
	




		// Who is moderator of the week?

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




		if($get_recipe_notes == "E-mail not sent to administrators"){

			// Mail from
			$host = $_SERVER['HTTP_HOST'];
			$from = "post@" . $_SERVER['HTTP_HOST'];
			$reply = "post@" . $_SERVER['HTTP_HOST'];
			
			$view_link = $configSiteURLSav . "/recipes/view_recipe.php?recipe_id=$get_recipe_id";
			$edit_link = $configControlPanelURLSav . "/index.php?open=recipes&page=edit_recipe&recipe_id=$get_recipe_id";
			$delete_link = $configControlPanelURLSav . "/index.php?open=recipes&page=delete_recipe&recipe_id=$get_recipe_id";
			
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			$user_agent = output_html($user_agent);

			$subject = "New recipe $get_recipe_title at $host";

			$message = "<html>\n";
			$message = $message. "<head>\n";
			$message = $message. "  <title>$subject</title>\n";
			$message = $message. " </head>\n";
			$message = $message. "<body>\n";

			$message = $message . "<p>Hi $get_moderator_user_name,</p>\n\n";
			$message = $message . "<p><b>Summary:</b><br />There is a new recipe at $host for lanugage $l. This is a information e-mail. No action is needed.</p>\n\n";

			$message = $message . "<p style='padding-bottom:0;margin-bottom:0'><b>Information:</b></p>\n";
			$message = $message . "<table>\n";
			$message = $message . " <tr><td><span>Recipe ID:</span></td><td><span>$get_recipe_language</span></td></tr>\n";
			$message = $message . " <tr><td><span>Category:</span></td><td><span>$get_recipe_category_id</span></td></tr>\n";
			$message = $message . " <tr><td><span>Title:</span></td><td><span>$get_recipe_title</span></td></tr>\n";
			$message = $message . " <tr><td><span>Language:</span></td><td><span>$get_recipe_language</span></td></tr>\n";
			$message = $message . " <tr><td><span>Introduction:</span></td><td><span>$get_recipe_introduction</span></td></tr>\n";
			$message = $message . " <tr><td><span>Date time:</span></td><td><span>$get_recipe_date $get_recipe_time</span></td></tr>\n";
			$message = $message . " <tr><td><span>Cusine:</span></td><td><span>$get_recipe_cusine_id</span></td></tr>\n";
			$message = $message . " <tr><td><span>Season:</span></td><td><span>$get_recipe_season_id</span></td></tr>\n";
			$message = $message . " <tr><td><span>Occasion:</span></td><td><span>$get_recipe_occasion_id</span></td></tr>\n";
			$message = $message . "</table>\n";
		

			$message = $message . "<p style='padding-bottom:0;margin-bottom:0'><b>User:</b></p>\n";
			$message = $message . "<table>\n";
			$message = $message . " <tr><td><span>User:</span></td><td><span>$get_recipe_user_id</span></td></tr>\n";
			$message = $message . " <tr><td><span>User IP:</span></td><td><span>$get_recipe_user_ip</span></td></tr>\n";
			$message = $message . " <tr><td><span>User agent:</span></td><td><span>$user_agent</span></td></tr>\n";
			$message = $message . "</table>\n";
		
			$message = $message . "<p><b>Image:</b><br />\n";
			$message = $message . "<img src='$configSiteURLSav/$get_recipe_image_path/$get_recipe_image' alt='$configSiteURLSav/$get_recipe_image_path/$get_recipe_image' /></p>\n";

			$message = $message . "<p><b>Video:</b><br />\n";
			$message = $message . "<a href='$get_recipe_video'>$get_recipe_video</a></p>\n";

			$message = $message . "<p><b>Information:</b><br />\n";
			$message = $message . "$get_recipe_directions</p>\n";

			$message = $message . "<p><b>Actions:</b><br />\n";
			$message = $message . "View: <a href=\"$view_link\">$view_link</a><br />\n";
			$message = $message . "Edit: <a href=\"$edit_link\">$edit_link</a><br />\n";
			$message = $message . "Delete: <a href=\"$delete_link\">$delete_link</a></p>";
			$message = $message . "<p>\n\n--<br />\nBest regards<br />\n$host</p>";
			$message = $message. "</body>\n";
			$message = $message. "</html>\n";


			// Preferences for Subject field
			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-type: text/html; charset=utf-8';
			$headers[] = "From: $configFromNameSav <" . $configFromEmailSav . ">";
			mail($get_moderator_user_email, $subject, $message, implode("\r\n", $headers));


			// Update
			$result = mysqli_query($link, "UPDATE $t_recipes SET recipe_notes='' WHERE recipe_id=$recipe_id_mysql");


			// Set user points
			$query = "SELECT user_id, user_name, user_alias, user_language, user_rank, user_gender, user_dob, user_points FROM $t_users WHERE user_id='$get_recipe_user_id'";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_user_id, $get_current_user_name, $get_current_user_alias, $get_current_user_language, $get_current_user_rank, $get_user_gender, $get_current_user_dob, $get_user_points) = $row;

			$inp_user_points = $get_user_points+1;

			$result = mysqli_query($link, "UPDATE $t_users SET user_points='$inp_user_points' WHERE user_id='$get_recipe_user_id'") or die(mysqli_error($link));



			// Chef of the month
			$query = "SELECT stats_chef_of_the_month_id, stats_chef_of_the_month_recipes_posted_count, stats_chef_of_the_month_recipes_posted_points, stats_chef_of_the_month_got_visits_count, stats_chef_of_the_month_got_visits_points, stats_chef_of_the_month_got_favorites_count, stats_chef_of_the_month_got_favorites_points, stats_chef_of_the_month_got_comments_count, stats_chef_of_the_month_got_comments_points, stats_chef_of_the_month_total_points FROM $t_recipes_stats_chef_of_the_month WHERE stats_chef_of_the_month_month=$month AND stats_chef_of_the_month_year=$year AND stats_chef_of_the_month_user_id=$get_recipe_user_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_stats_chef_of_the_month_id, $get_stats_chef_of_the_month_recipes_posted_count, $get_stats_chef_of_the_month_recipes_posted_points, $get_stats_chef_of_the_month_got_visits_count, $get_stats_chef_of_the_month_got_visits_points, $get_stats_chef_of_the_month_got_favorites_count, $get_stats_chef_of_the_month_got_favorites_points, $get_stats_chef_of_the_month_got_comments_count, $get_stats_chef_of_the_month_got_comments_points, $get_stats_chef_of_the_month_total_points) = $row;
			if($get_stats_chef_of_the_month_id == ""){
				// Insert chef of the month
				$inp_user_name_mysql = quote_smart($link, $get_user_name);
				$inp_user_photo_path_mysql = quote_smart($link, "_uploads/users/images/$get_recipe_user_id");
				$inp_user_photo_thumb_mysql = quote_smart($link, $get_photo_thumb_200);

				mysqli_query($link, "INSERT INTO $t_recipes_stats_chef_of_the_month 
				(stats_chef_of_the_month_id, stats_chef_of_the_month_month, stats_chef_of_the_month_month_full, stats_chef_of_the_month_month_short, stats_chef_of_the_month_year, 
				stats_chef_of_the_month_user_id, stats_chef_of_the_month_user_name, stats_chef_of_the_month_user_photo_path, stats_chef_of_the_month_user_photo_thumb, stats_chef_of_the_month_recipes_posted_count, 
				stats_chef_of_the_month_recipes_posted_points, stats_chef_of_the_month_got_visits_count, stats_chef_of_the_month_got_visits_points, stats_chef_of_the_month_got_favorites_count, stats_chef_of_the_month_got_favorites_points, 
				stats_chef_of_the_month_got_comments_count, stats_chef_of_the_month_got_comments_points, stats_chef_of_the_month_total_points) 
				VALUES 
				(NULL, $month, '$month_full', '$month_short', $year,
				$get_recipe_user_id, $inp_user_name_mysql, $inp_user_photo_path_mysql, $inp_user_photo_thumb_mysql, 1,
				7, 0, 0, 0, 0, 
				0, 0, 0)")
				or die(mysqli_error($link));
			}
			else{
				// Update visit
				$inp_count = $get_stats_chef_of_the_month_recipes_posted_count+1;
				$inp_points = $inp_count*7;
				$inp_total_points = $inp_points+$get_stats_chef_of_the_month_got_visits_points+$get_stats_chef_of_the_month_got_favorites_points+$get_stats_chef_of_the_month_got_comments_points;
				mysqli_query($link, "UPDATE $t_recipes_stats_chef_of_the_month SET stats_chef_of_the_month_recipes_posted_count=$inp_count, stats_chef_of_the_month_recipes_posted_points=$inp_points, stats_chef_of_the_month_total_points=$inp_total_points WHERE stats_chef_of_the_month_id=$get_stats_chef_of_the_month_id") or die(mysqli_error($link)); 
			}

		}


		// Location
		
		echo"
		<h1>
		<img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
		Loading...</h1>
		<meta http-equiv=\"refresh\" content=\"1;url=$root/recipes/view_recipe.php?recipe_id=$get_recipe_id\">
		";
		

	} // recipe found
}
else{
	$action = "noshow";
	echo"
	<h1>
	<img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/index.php?page=login&amp;l=$l&amp;refer=$root/recipes/submit_recipe.php\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>