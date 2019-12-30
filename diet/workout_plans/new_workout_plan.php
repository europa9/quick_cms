<?php 
/**
*
* File: exercises/new_workout_plan.php
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


/*- Variables ------------------------------------------------------------------------- */
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


	if($process == "1"){

		$inp_title = $_POST['inp_title'];
		$inp_title = output_html($inp_title);
		$inp_title_mysql = quote_smart($link, $inp_title);
		if(empty($inp_title)){
			$url = "new_workout_plan.php?l=$l";
			$url = $url . "&ft=error&fm=missing_title";
			header("Location: $url");
			exit;
		}
		
		$inp_title_clean = clean($inp_title);
		$inp_title_clean_mysql = quote_smart($link, $inp_title_clean);

		$inp_duration = $_POST['inp_duration'];
		$inp_duration = output_html($inp_duration);

		$inp_language = $_POST['inp_language'];
		$inp_language = output_html($inp_language);
		$inp_language_mysql = quote_smart($link, $inp_language);
		$l = $inp_language;
		if(empty($inp_language)){
			$url = "new_workout_plan.php?l=$l";
			$url = $url . "&ft=error&fm=missing_language";
			header("Location: $url");
			exit;
		}


		$datetime = date("Y-m-d H:i:s");

		$inp_user_ip = $_SERVER['REMOTE_ADDR'];
		$inp_user_ip = output_html($inp_user_ip);
		$inp_user_ip_mysql = quote_smart($link, $inp_user_ip);



		if($inp_duration == "yearly"){
			mysqli_query($link, "INSERT INTO $t_workout_plans_yearly
			(workout_yearly_id, workout_yearly_user_id, workout_yearly_language, workout_yearly_title, workout_yearly_title_clean, workout_yearly_created, workout_yearly_updated, workout_yearly_unique_hits, workout_yearly_comments, workout_yearly_likes, workout_yearly_dislikes, workout_yearly_rating, workout_yearly_user_ip) 
			VALUES 
			(NULL, $my_user_id_mysql, $inp_language_mysql, $inp_title_mysql, $inp_title_clean_mysql, '$datetime', '$datetime', '0', 
			'0', '0', '0', '0', $inp_user_ip_mysql)
			")
			or die(mysqli_error($link));

			// Get ID
			$query_t = "SELECT workout_yearly_id FROM $t_workout_plans_yearly WHERE workout_yearly_user_id=$my_user_id_mysql AND workout_yearly_created='$datetime'";
			$result_t = mysqli_query($link, $query_t);
			$row_t = mysqli_fetch_row($result_t);
			list($get_workout_yearly_id) = $row_t;
			
			// Header
			$url = "new_workout_plan_yearly.php?yearly_id=$get_workout_yearly_id&l=$l";
			header("Location: $url");

		}
		elseif($inp_duration == "period"){
			mysqli_query($link, "INSERT INTO $t_workout_plans_period
			(workout_period_id, workout_period_user_id, workout_period_yearly_id, workout_period_language, workout_period_title, workout_period_title_clean, workout_period_created, workout_period_updated, workout_period_unique_hits, 
			workout_period_comments, workout_period_likes, workout_period_dislikes, workout_period_rating, workout_period_user_ip) 
			VALUES 
			(NULL, $my_user_id_mysql, '0', $inp_language_mysql, $inp_title_mysql, $inp_title_clean_mysql, '$datetime', '$datetime', '0', 
			'0', '0', '0', '0', $inp_user_ip_mysql)
			")
			or die(mysqli_error($link));

			// Get ID
			$query_t = "SELECT workout_period_id FROM $t_workout_plans_period WHERE workout_period_user_id=$my_user_id_mysql AND workout_period_created='$datetime'";
			$result_t = mysqli_query($link, $query_t);
			$row_t = mysqli_fetch_row($result_t);
			list($get_workout_period_id) = $row_t;
			
			// Header
			$url = "new_workout_plan_period.php?period_id=$get_workout_period_id&l=$l";
			header("Location: $url");
		}
		elseif($inp_duration == "weekly"){
			mysqli_query($link, "INSERT INTO $t_workout_plans_weekly
			(workout_weekly_id, workout_weekly_user_id, workout_weekly_period_id, workout_weekly_language, workout_weekly_title, workout_weekly_title_clean, workout_weekly_image_file, workout_weekly_created, workout_weekly_updated, workout_weekly_unique_hits, 
			workout_weekly_comments, workout_weekly_likes, workout_weekly_dislikes, workout_weekly_rating, workout_weekly_user_ip) 
			VALUES 
			(NULL, $my_user_id_mysql, '0', $inp_language_mysql, $inp_title_mysql, $inp_title_clean_mysql, '', '$datetime', '$datetime', '0', 
			'0', '0', '0', '0', $inp_user_ip_mysql)
			")
			or die(mysqli_error($link));

			// Get ID
			$query_t = "SELECT workout_weekly_id FROM $t_workout_plans_weekly WHERE workout_weekly_user_id=$my_user_id_mysql AND workout_weekly_created='$datetime'";
			$result_t = mysqli_query($link, $query_t);
			$row_t = mysqli_fetch_row($result_t);
			list($get_workout_weekly_id) = $row_t;
			
			// Header
			$url = "new_workout_plan_weekly.php?weekly_id=$get_workout_weekly_id&l=$l";
			header("Location: $url");
		}
		else{
			echo"what";
		}
	}

	
	echo"
	<h1>$l_new_workout_plan</h1>
	
	<!-- Feedback -->
		";
		if($ft != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			else{
				$fm = ucfirst($fm);
			}
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
	<!-- //Feedback -->

	<!-- Form -->
		<script>
			\$(document).ready(function(){
				\$('[name=\"inp_title\"]').focus();
			});
		</script>
		<form method=\"post\" action=\"new_workout_plan.php?l=$l&amp;process=1\" enctype=\"multipart/form-data\">


		<p><b>$l_title*:</b><br />
		<input type=\"text\" name=\"inp_title\" size=\"25\"  tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
		</p>

		<p><b>$l_duration/$l_type*:</b><br />
		<select name=\"inp_duration\"  tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">
			<option value=\"weekly\" selected=\"selected\">$l_weekly</option>
			<option value=\"period\">$l_period</option>
			<option value=\"yearly\">$l_yearly</option>
		</select>
		</p>

		<p><b>$l_language*:</b><br />
		<select name=\"inp_language\"  tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">\n";
		$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;
			$flag_path 	= "$root/_webdesign/images/flags/16x16/$get_language_active_flag" . "_16x16.png";
				
			echo"	<option value=\"$get_language_active_iso_two\"";if($l == "$get_language_active_iso_two"){ echo" selected=\"selected\"";}echo">$get_language_active_name</option>\n";
		}
		echo"
		</select>
		</p>

		<p>
		<input type=\"submit\" value=\"$l_next\" class=\"btn\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
		</p>

		</form>
	<!-- //Form -->
	";
}
else{
	echo"
	<h1>
	<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/exercises/new_exercise.php\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>