<?php 
/**
*
* File: workout_plans/weekly_workout_plan_new_comment.php
* Version 1.0.0
* Date 13:24 07.05.2021
* Copyright (c) 2011-2021 S. A. Ditlefsen
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
include("$root/_admin/_data/logo.php");

/*- Tables ---------------------------------------------------------------------------- */
include("_tables.php");

/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/workout_plans/ts_new_workout_plan.php");
include("$root/_admin/_translations/site/$l/workout_plans/ts_yearly_workout_plan_edit.php");

/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['weekly_id'])){
	$weekly_id = $_GET['weekly_id'];
	$weekly_id = output_html($weekly_id);
}
else{
	$weekly_id = "";
}


$tabindex = 0;
$l_mysql = quote_smart($link, $l);


// Get workout plan weekly
$weekly_id_mysql = quote_smart($link, $weekly_id);
$query = "SELECT workout_weekly_id, workout_weekly_user_id, workout_weekly_period_id, workout_weekly_weight, workout_weekly_language, workout_weekly_title, workout_weekly_title_clean, workout_weekly_introduction, workout_weekly_text, workout_weekly_goal, workout_weekly_image_path, workout_weekly_image_file, workout_weekly_created, workout_weekly_updated, workout_weekly_unique_hits, workout_weekly_unique_hits_ip_block, workout_weekly_comments, workout_weekly_likes, workout_weekly_dislikes, workout_weekly_rating, workout_weekly_ip_block, workout_weekly_user_ip, workout_weekly_notes FROM $t_workout_plans_weekly WHERE workout_weekly_id=$weekly_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_workout_weekly_id, $get_current_workout_weekly_user_id, $get_current_workout_weekly_period_id, $get_current_workout_weekly_weight, $get_current_workout_weekly_language, $get_current_workout_weekly_title, $get_current_workout_weekly_title_clean, $get_current_workout_weekly_introduction, $get_current_workout_weekly_text, $get_current_workout_weekly_goal, $get_current_workout_weekly_image_path, $get_current_workout_weekly_image_file, $get_current_workout_weekly_created, $get_current_workout_weekly_updated, $get_current_workout_weekly_unique_hits, $get_current_workout_weekly_unique_hits_ip_block, $get_current_workout_weekly_comments, $get_current_workout_weekly_likes, $get_current_workout_weekly_dislikes, $get_current_workout_weekly_rating, $get_current_workout_weekly_ip_block, $get_current_workout_weekly_user_ip, $get_current_workout_weekly_notes) = $row;
if($get_current_workout_weekly_id == ""){

	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "$l_workout_plans - Server error 404";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");
	echo"<h1>Server error 404</h1><p>Plan not found</p>";
	include("$root/_webdesign/footer.php");
	
}
else{

	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "$l_workout_plans - $get_current_workout_weekly_title";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");

	// Logged in?
	if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
		// Get my profile
		$my_user_id = $_SESSION['user_id'];
		$my_user_id_mysql = quote_smart($link, $my_user_id);
		$query = "SELECT user_id, user_name, user_alias, user_date_format FROM $t_users WHERE user_id=$my_user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_my_user_id, $get_my_user_name, $get_my_user_alias, $get_my_user_date_format) = $row;


		// Get my photo
		$query = "SELECT photo_id, photo_destination FROM $t_users_profile_photo WHERE photo_user_id='$get_my_user_id' AND photo_profile_image='1'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_photo_id, $get_photo_destination) = $row;

		// Get owner
		$query = "SELECT user_id, user_email, user_name, user_alias FROM $t_users WHERE user_id=$get_current_workout_weekly_user_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_owner_user_id, $get_owner_user_email, $get_owner_user_name, $get_owner_user_alias) = $row;



		/*- Content ---------------------------------------------------------------------------------- */
		if($process == "1"){
			$inp_text = $_POST['inp_text'];
			$inp_text = output_html($inp_text);
			$inp_text_mysql = quote_smart($link, $inp_text);

			if(empty($inp_text)){
				$url = "weekly_workout_plan_new_comment.php?weekly_id=$get_current_workout_weekly_id&l=$l&ft=error&fm=missing_text";
				header("Location: $url");
				exit;
			}

			// lang
			$l_mysql = quote_smart($link, $l);

			// Datetime and time
			$datetime = date("Y-m-d H:i:s");
			$time = time();

			// Datetime print
			$year = substr($datetime, 0, 4);
			$month = substr($datetime, 5, 2);
			$day = substr($datetime, 8, 2);

			if($day < 10){
				$day = substr($day, 1, 1);
			}
		
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

			$inp_comment_date_print = "$day $month_saying $year";

			// User, alias
			$inp_comment_user_name_mysql = quote_smart($link, $get_my_user_name);
			$inp_comment_user_alias_mysql = quote_smart($link, $get_my_user_alias);

			// Image
			$inp_comment_user_image_path_mysql = quote_smart($link, "_uploads/users/images/$get_my_user_id");

			// Image make a thumb
			if($get_photo_destination != ""){
				$inp_new_x = 65; // 950
				$inp_new_y = 65; // 640
				$thumb_full_path = "$root/_uploads/users/images/$get_my_user_id/user_" . $get_my_user_id . "-" . $inp_new_x . "x" . $inp_new_y . ".png";
				if(!(file_exists("$thumb_full_path"))){
					resize_crop_image($inp_new_x, $inp_new_y, "$root/_uploads/users/images/$get_my_user_id/$get_photo_destination", "$thumb_full_path");
				}
				$inp_comment_user_image_file = "user_" . $get_my_user_id . "-" . $inp_new_x . "x" . $inp_new_y . ".png";
			}
			else{
				$inp_comment_user_image_file = "";
			}
			$inp_comment_user_image_file_mysql = quote_smart($link, $inp_comment_user_image_file);

			// Ip 
			$inp_ip = $_SERVER['REMOTE_ADDR'];
			$inp_ip = output_html($inp_ip);
			$inp_ip_mysql = quote_smart($link, $inp_ip);

			$inp_hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$inp_hostname = output_html($inp_hostname);
			$inp_hostname_mysql = quote_smart($link, $inp_hostname);

			$inp_user_agent = $_SERVER['HTTP_USER_AGENT'];
			$inp_user_agent = output_html($inp_user_agent);
			$inp_user_agent_mysql = quote_smart($link, $inp_user_agent);

			mysqli_query($link, "INSERT INTO $t_workout_plans_weekly_comments
			(comment_id, comment_plan_id, comment_language, comment_approved, comment_datetime, 
			comment_time, comment_date_print, comment_user_id, comment_user_name, comment_user_alias, 
			comment_user_image_path, comment_user_image_file, comment_user_ip, comment_user_hostname, comment_user_agent, 
			comment_text, comment_reported) 
			VALUES 
			(NULL, $get_current_workout_weekly_id, $l_mysql, '1', '$datetime', 
			'$time', '$inp_comment_date_print', '$get_my_user_id', $inp_comment_user_name_mysql, $inp_comment_user_alias_mysql, 
			$inp_comment_user_image_path_mysql, $inp_comment_user_image_file_mysql, $inp_ip_mysql, $inp_hostname_mysql, $inp_user_agent_mysql, 
			$inp_text_mysql, '0')")
			or die(mysqli_error($link));
				
			// Get comment id
			$query = "SELECT comment_id FROM $t_workout_plans_weekly_comments WHERE comment_time='$time'";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_comment_id) = $row;

			// Email to owner
			$subject = "$l_new_comment_to $get_current_workout_weekly_title";
			
			$message = "<html>\n";
			$message = $message. "<head>\n";
			$message = $message. "  <title>$subject</title>\n";
			$message = $message. " </head>\n";
			$message = $message. "<body>\n";

			$message = $message . "<p><a href=\"$configSiteURLSav\"><img src=\"$configSiteURLSav/$logoPathSav/$logoFileSav\" alt=\"($configWebsiteTitleSav logo)\" /></a></p>\n\n";
			$message = $message . "<p>$inp_text</p>\n";

			$message = $message . "<p>\n";
			$message = $message . "<a href=\"$configSiteURLSav/workout_plans/weekly_workout_plan_view.php?weekly_id=$get_current_workout_weekly_id&l=$l#comment$get_comment_id\">$l_read</a>\n";
			$message = $message . "</p>\n";


			$message = $message . "<p>\n\n--<br />\nBest regards<br />\n$configWebsiteTitleSav<br />\n<a href=\"$configSiteURLSav\">$configSiteURLSav</a></p>";
			$message = $message. "</body>\n";
			$message = $message. "</html>\n";

			// Preferences for Subject field
			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-type: text/html; charset=utf-8';
			$headers[] = "From: $configFromNameSav <" . $configFromEmailSav . ">";
			if($configMailSendActiveSav == "1"){
				mail($get_owner_user_email, $subject, $message, implode("\r\n", $headers));
			}
				

			// Header
			$url = "weekly_workout_plan_view.php?weekly_id=$get_current_workout_weekly_id&l=$l#comment$get_comment_id";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>$get_current_workout_weekly_title</h1>
	


		<!-- Where am I ? -->
		<p><b>$l_you_are_here:</b><br />
			<a href=\"index.php?l=$l\">$l_workout_plans</a>
			&gt;
			";
			// Have period parent?
			if($get_current_workout_weekly_period_id != 0){
				$query = "SELECT workout_period_id, workout_period_yearly_id, workout_period_title FROM $t_workout_plans_period WHERE workout_period_id=$get_current_workout_weekly_period_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_workout_period_id, $get_current_workout_period_yearly_id, $get_current_workout_period_title) = $row;


				// Have yearly parent?
				if($get_current_workout_period_yearly_id != 0){
					$query = "SELECT workout_yearly_id, workout_yearly_title FROM $t_workout_plans_yearly WHERE workout_yearly_id=$get_current_workout_period_yearly_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_current_workout_yearly_id, $get_current_workout_yearly_title) = $row;
					echo"
					<a href=\"yearly_workout_plan_view.php?yearly_id=$get_current_workout_yearly_id&amp;l=$l\">$get_current_workout_yearly_title</a>
					&gt;
					";
				}


				echo"
				<a href=\"period_workout_plan_view.php?period_id=$get_current_workout_period_id&amp;l=$l\">$get_current_workout_period_title</a>
				&gt;
				";
			}



			echo"
			<a href=\"weekly_workout_plan_view.php?weekly_id=$weekly_id&amp;l=$l\">$get_current_workout_weekly_title</a>
			&gt;
			<a href=\"weekly_workout_plan_new_comment.php?weekly_id=$get_current_workout_weekly_id&amp;l=$l\">$l_new_comment</a>
		</p>
		<!-- //Where am I ? -->

		<!-- New comment form -->
		<h2>$l_new_comment</h2>

		
		<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_text\"]').focus();
			});
			</script>
		<!-- //Focus -->

		<form method=\"post\" action=\"weekly_workout_plan_new_comment.php?weekly_id=$get_current_workout_weekly_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
	
		<p>
		<textarea name=\"inp_text\" rows=\"5\" cols=\"45\" style=\"width: 95%;\"></textarea>
		</p>

		<p>
		<input type=\"submit\" value=\"$l_save_comment\" class=\"btn\" />
		</p>

		</form>
		<!-- //New comment form -->
		";
	} // logged in
	else{
		echo"
		<h1>
		<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
		Loading...</h1>
		<meta http-equiv=\"refresh\" content=\"1;url=$root/users/index.php?page=login&amp;l=$l\">
		";

	}
} // workout plan found


/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>