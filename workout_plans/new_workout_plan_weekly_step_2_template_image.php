<?php 
/**
*
* File: food/new_workout_plan_weekly_step_2_template_image.php
* Version 1.0.0
* Date 12:05 10.02.2018
* Copyright (c) 2011-2018 S. A. Ditlefsen
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
include("_tables.php");

/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/workout_plans/ts_new_workout_plan.php");

/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['weekly_id'])){
	$weekly_id = $_GET['weekly_id'];
	$weekly_id = output_html($weekly_id);
}
else{
	$weekly_id = "";
}
if(isset($_GET['session_id'])){
	$session_id = $_GET['session_id'];
	$session_id = output_html($session_id);
}
else{
	$session_id = "";
}
if(isset($_GET['session_main_id'])){
	$session_main_id = $_GET['session_main_id'];
	$session_main_id = output_html($session_main_id);
}
else{
	$session_main_id = "";
}

if(isset($_GET['type_id'])){
	$type_id = $_GET['type_id'];
	$type_id = strip_tags(stripslashes($type_id));
}
else{
	$type_id = "";
}


$tabindex = 0;
$l_mysql = quote_smart($link, $l);




/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_workout_plans - $l_new_workout_plan";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */
// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
	// Get my user
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_user_id, $get_user_email, $get_user_name, $get_user_alias, $get_user_rank) = $row;

	// Get workout plan weekly
	$weekly_id_mysql = quote_smart($link, $weekly_id);
	$query = "SELECT workout_weekly_id, workout_weekly_user_id, workout_weekly_period_id, workout_weekly_weight, workout_weekly_language, workout_weekly_title, workout_weekly_title_clean, workout_weekly_introduction, workout_weekly_goal, workout_weekly_image_path, workout_weekly_image_file, workout_weekly_created, workout_weekly_updated, workout_weekly_unique_hits, workout_weekly_unique_hits_ip_block, workout_weekly_comments, workout_weekly_likes, workout_weekly_dislikes, workout_weekly_rating, workout_weekly_ip_block, workout_weekly_user_ip, workout_weekly_notes FROM $t_workout_plans_weekly WHERE workout_weekly_id=$weekly_id_mysql AND workout_weekly_user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_workout_weekly_id, $get_current_workout_weekly_user_id, $get_current_workout_weekly_period_id, $get_current_workout_weekly_weight, $get_current_workout_weekly_language, $get_current_workout_weekly_title, $get_current_workout_weekly_title_clean, $get_current_workout_weekly_introduction, $get_current_workout_weekly_goal, $get_current_workout_weekly_image_path, $get_current_workout_weekly_image_file, $get_current_workout_weekly_created, $get_current_workout_weekly_updated, $get_current_workout_weekly_unique_hits, $get_current_workout_weekly_unique_hits_ip_block, $get_current_workout_weekly_comments, $get_current_workout_weekly_likes, $get_current_workout_weekly_dislikes, $get_current_workout_weekly_rating, $get_current_workout_weekly_ip_block, $get_current_workout_weekly_user_ip, $get_current_workout_weekly_notes) = $row;
	
	

	if($get_current_workout_weekly_id == ""){
		echo"<p>Weekly not found.</p>";
	}
	else{
		if($process == "1"){

				// Period
				$image_file = $_GET['image_file'];
				$image_file = output_html($image_file);	

				$workout_weekly_image_file = "$image_file." . "jpg";
				$workout_weekly_image_file_mysql = quote_smart($link, $workout_weekly_image_file);

				$workout_weekly_image_thumb_big = "$image_file" . "_thumb_400x269." . "jpg";
				$workout_weekly_image_thumb_big_mysql = quote_smart($link, $workout_weekly_image_thumb_big);

				$workout_weekly_image_thumb_medium = "$image_file" . "_thumb_145x98." . "jpg";
				$workout_weekly_image_thumb_medium_mysql = quote_smart($link, $workout_weekly_image_thumb_medium);


				// Update
				$result = mysqli_query($link, "UPDATE $t_workout_plans_weekly SET 
					workout_weekly_image_path='workout_plans/_gfx/image_templates',
					workout_weekly_image_thumb_big=$workout_weekly_image_thumb_big_mysql, 
					workout_weekly_image_thumb_medium=$workout_weekly_image_thumb_medium_mysql,
					workout_weekly_image_file=$workout_weekly_image_file_mysql 
					 WHERE workout_weekly_id=$weekly_id_mysql") or die(mysqli_error($link));



				// Header
				$url = "new_workout_plan_weekly_step_3_sessions.php?weekly_id=$get_current_workout_weekly_id&l=$l";
				header("Location: $url");
				exit;

		} // process
	
		echo"
		<h1>$l_new_weekly_workout_plan</h1>
	
		<h2>$l_describing_image</h2>

		<p>
		$l_select_one_image_below_that_describes_your_workout_plan
		</p>
		";

		// Custom pages
		$filenames = "";
		$dir = "_gfx/image_templates/";
		if ($handle = opendir($dir)) {
			while (false !== ($file = readdir($handle))) {
				if ($file === '.') continue;
				if ($file === '..') continue;
				if ($file === 'thumbs') continue;
				$extension = get_extension($file);
				$image_name = str_replace(".$extension", "", $file);

				// Check if this is a thumb
				$check = explode("_", $file);
				$array_size = sizeof($check);

				if($array_size == "1"){

					// Thumb
					$workout_weekly_image_thumb_big = "$image_name" . "_thumb_400x269." . $extension;
					$workout_weekly_image_thumb_medium = "$image_name" . "_thumb_145x98." . $extension;
					if(!(file_exists("_gfx/image_templates/thumbs/$workout_weekly_image_thumb_big"))){
						if(!is_dir("_gfx/image_templates/thumbs")){
							mkdir("_gfx/image_templates/thumbs");
						}
						resize_crop_image("400", "269", "_gfx/image_templates/$file", "_gfx/image_templates/thumbs/$workout_weekly_image_thumb_big");
					}
					if(!(file_exists("_gfx/image_templates/thumbs/$workout_weekly_image_thumb_medium"))){
						resize_crop_image("145", "98", "_gfx/image_templates/$file", "_gfx/image_templates/thumbs/$workout_weekly_image_thumb_medium");
					}

					echo"
					<a href=\"new_workout_plan_weekly_step_2_template_image.php?weekly_id=$weekly_id&amp;l=$l&amp;image_file=$image_name&amp;process=1\"><img src=\"_gfx/image_templates/thumbs/$workout_weekly_image_thumb_medium\" alt=\"$file\" /></a>
					";
				}
				
			}
			closedir($handle);
		}


	} // found
}
else{
	echo"
	<h1>
	<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/index.php?page=login&amp;l=$l&amp;refer=$root/exercises/new_exercise.php\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>