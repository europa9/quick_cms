<?php 
/**
*
* File: recipes/comment_recipe.php
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
include("_tables.php");

/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/recipes/ts_recipes.php");


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

	// Get my profile image
	$q = "SELECT photo_id, photo_destination FROM $t_users_profile_photo WHERE photo_user_id=$my_user_id_mysql AND photo_profile_image='1'";
	$r = mysqli_query($link, $q);
	$rowb = mysqli_fetch_row($r);
	list($get_my_photo_id, $get_my_photo_destination) = $rowb;



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
		if($process == 1){
			// IP date
			$inp_ip = $_SERVER['REMOTE_ADDR'];
			$inp_ip = output_html($inp_ip);
			$inp_ip_date = date("ymdHi");
			$inp_ip_and_date = $inp_ip . "." . $inp_ip_date;



			// Guess
			$has_commented_before = 0;


			// Check ip block
			if(file_exists("$root/_cache/recipe_comment_ip_block.dat")){
				$fh = fopen("$root/_cache/recipe_comment_ip_block.dat", "r");
				$comments_ip_block = fread($fh, filesize("$root/_cache/recipe_comment_ip_block.dat"));
				fclose($fh);

				$comments_ip_block_array = explode("\n", $comments_ip_block);
				$comments_ip_block_array_size = sizeof($comments_ip_block_array);

				if($comments_ip_block_array_size > 30){
					$comments_ip_block_array_size = 20;
				}
			
				for($x=0;$x<$comments_ip_block_array_size;$x++){
					if($comments_ip_block_array[$x] == "$inp_ip_and_date"){
						$has_commented_before = 1;
						break;
					}
				}
			}

			if($has_commented_before == 0){
				if(isset($comments_ip_block)){
					$inp_comments_ip_block = $inp_ip_and_date . "\n" . $comments_ip_block;
				}
				else{
					$inp_comments_ip_block = $inp_ip_and_date;
				}
				
				$fh = fopen("$root/_cache/recipe_comment_ip_block.dat", "w") or die("can not open file");
				fwrite($fh, $inp_comments_ip_block);
				fclose($fh);
			}


			$inp_recipe_comment_text = $_POST['inp_recipe_comment_text'];
			$inp_recipe_comment_text = output_html($inp_recipe_comment_text);
			$inp_recipe_comment_text_mysql = quote_smart($link, $inp_recipe_comment_text);
			if(empty($inp_recipe_comment_text)){
				$ft = "error";
				$fm = "no_comment_added";
				$url = "view_recipe.php?recipe_id=$get_recipe_id&l=$l&comment_ft=$ft&comment_fm=$fm#add_comment";
				header("Location: $url");
				exit;
			}


			// Rating
			$stars = 0;
			if(isset($_POST['rating-input-1'])){
				$inp_rating_1 = $_POST['rating-input-1'];
				$stars = 1;
			}
			if(isset($_POST['rating-input-2'])){
				$inp_rating_2 = $_POST['rating-input-2'];
				$stars = 2;
			}
			if(isset($_POST['rating-input-3'])){
				$inp_rating_3 = $_POST['rating-input-3'];
				$stars = 3;
			}
			if(isset($_POST['rating-input-4'])){
				$inp_rating_4 = $_POST['rating-input-4'];
				$stars = 4;
			}
			if(isset($_POST['rating-input-5'])){
				$inp_rating_1 = $_POST['rating-input-5'];
				$stars = 5;
			}
			$inp_recipe_comment_stars = output_html($stars);
			$inp_recipe_comment_stars_mysql = quote_smart($link, $inp_recipe_comment_stars);


			$inp_recipe_comment_user_alias_mysql = quote_smart($link, $get_my_user_alias);

			if($get_my_photo_destination != ""){
				$inp_recipe_comment_user_photo_mysql = quote_smart($link, $get_my_photo_destination);
			}
			else{
				$inp_recipe_comment_user_photo_mysql = "''";
			}

			$inp_recipe_comment_user_ip = $_SERVER['REMOTE_ADDR'];
			$inp_recipe_comment_user_ip = output_html($inp_recipe_comment_user_ip);
			$inp_recipe_comment_user_ip_mysql = quote_smart($link, $inp_recipe_comment_user_ip);

			$inp_recipe_comment_datetime = date("Y-m-d H:i:s");

			// Insert
			mysqli_query($link, "INSERT INTO $t_recipes_comments
			(recipe_comment_id, recipe_comment_recipe_id, recipe_comment_user_id, recipe_comment_user_alias, recipe_comment_user_photo, recipe_comment_user_ip, recipe_comment_text, recipe_comment_stars, recipe_comment_likes, recipe_comment_datetime, recipe_comment_reported) 
			VALUES 
			(NULL, '$get_recipe_id', $my_user_id_mysql, $inp_recipe_comment_user_alias_mysql, $inp_recipe_comment_user_photo_mysql, $inp_recipe_comment_user_ip_mysql, $inp_recipe_comment_text_mysql, $inp_recipe_comment_stars_mysql, '0', '$inp_recipe_comment_datetime', '0')")
			or die(mysqli_error($link));

			// Get comment ID
			$query = "SELECT recipe_comment_id FROM $t_recipes_comments WHERE recipe_comment_recipe_id='$get_recipe_id' AND recipe_comment_datetime='$inp_recipe_comment_datetime'";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_recipe_comment_id) = $row;


			// Check users subscription
			$query = "SELECT es_id, es_user_id, es_type, es_on_off FROM $t_users_email_subscriptions WHERE es_user_id='$get_recipe_user_id' AND es_type='comments'";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_es_id, $get_es_user_id, $get_es_type, $get_es_on_off) = $row;
			if($get_es_id == ""){
				mysqli_query($link, "INSERT INTO $t_users_email_subscriptions
				(es_id, es_user_id, es_type, es_on_off) 
				VALUES 
				(NULL, '$get_recipe_user_id', 'comments', '1')")
				or die(mysqli_error($link));
				$get_es_on_off = 0;
			}			

			if($get_es_on_off == "1"){
				// Send e-mail
				$query = "SELECT user_id, user_email, user_alias FROM $t_users WHERE user_id='$get_recipe_user_id'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_recipe_owner_user_id, $get_recipe_owner_user_email, $get_recipe_owner_user_alias) = $row;
			

				// Mail from
				$host = $_SERVER['HTTP_HOST'];
				$from = "post@" . $_SERVER['HTTP_HOST'];
				$reply = "post@" . $_SERVER['HTTP_HOST'];
			
				$view_link = $configSiteURLSav . "/recipes/view_recipe.php?recipe_id=$get_recipe_id#comments";
				$report_link = $configSiteURLSav . "/recipes/report_recipe_comment.php?recipe_id=$get_recipe_id&recipe_comment_id=$get_recipe_comment_id";
				$unsubscribe_link = $configSiteURLSav . "/recipes/unsubscribe.php?user_id=$get_recipe_owner_user_id";
			
			
				$subject = "New comment $get_recipe_title at $host";

				$message = "<html>\n";
				$message = $message. "<head>\n";
				$message = $message. "  <title>$subject</title>\n";
				$message = $message. " </head>\n";
				$message = $message. "<body>\n";
	
				$message = $message . "<p>Hi $get_recipe_owner_user_alias,</p>\n\n";
				$message = $message . "<p>There is a new comment for you recipe $get_recipe_title.</p>\n\n";

				$message = $message . "<p><b>$get_my_user_alias</b> <span style=\"color:grey;\">$inp_recipe_comment_datetime</span><br />\n";
				$message = $message . "$inp_recipe_comment_text</p>\n";
		


				$message = $message . "<p><b>Actions:</b><br />\n";
				$message = $message . "View: <a href=\"$view_link\">$view_link</a><br />\n";
				$message = $message . "Report: <a href=\"$report_link\">$report_link</a><br />\n";
				$message = $message . "</p>\n";
				$message = $message . "<p>Dont want any more e-mails? Then you can unsubscribe: <a href=\"$unsubscribe_link\">$unsubscribe_link</a></p>";

				$message = $message . "<p>\n\n--<br />\nBest regards<br />\n$host</p>";
				$message = $message. "</body>\n";
				$message = $message. "</html>\n";


				$encoding = "utf-8";

				// Preferences for Subject field
				$subject_preferences = array(
					       "input-charset" => $encoding,
					       "output-charset" => $encoding,
					       "line-length" => 76,
					       "line-break-chars" => "\r\n"
				);
				$header = "Content-type: text/html; charset=".$encoding." \r\n";
				$header .= "From: ".$host." <".$from."> \r\n";
				$header .= "MIME-Version: 1.0 \r\n";
				$header .= "Content-Transfer-Encoding: 8bit \r\n";
				$header .= "Date: ".date("r (T)")." \r\n";
				$header .= iconv_mime_encode("Subject", $subject, $subject_preferences);

				mail($get_recipe_owner_user_email, $subject, $message, $header);
	
			}
			

			
			// Rating
			$query_rating = "SELECT rating_id, rating_recipe_id, rating_1, rating_2, rating_3, rating_4, rating_5, rating_total_votes, rating_average, rating_popularity, rating_ip_block FROM $t_recipes_rating WHERE rating_recipe_id='$get_recipe_id'";
			$result_rating = mysqli_query($link, $query_rating);
			$row_rating = mysqli_fetch_row($result_rating);
			list($get_rating_id, $get_rating_recipe_id, $get_rating_1, $get_rating_2, $get_rating_3, $get_rating_4, $get_rating_5, $get_rating_total_votes, $get_rating_average, $get_rating_popularity, $get_rating_ip_block) = $row_rating;
			if($get_rating_average == ""){
				$get_rating_average = 0;
			}
			
			if($get_rating_1 == ""){
				$get_rating_1 = 0;
			}
			if($get_rating_2 == ""){
				$get_rating_2 = 0;
			}
			if($get_rating_3 == ""){
				$get_rating_3 = 0;
			}
			if($get_rating_4 == ""){
				$get_rating_4 = 0;
			}
			if($get_rating_5 == ""){
				$get_rating_5 = 0;
			}

			if($inp_recipe_comment_stars == 1){	
				$get_rating_1 = $get_rating_1+1;
			}
			elseif($inp_recipe_comment_stars == 2){	
				$get_rating_2 = $get_rating_2+1;
			}
			elseif($inp_recipe_comment_stars == 3){	
				$get_rating_3 = $get_rating_3+1;
			}
			elseif($inp_recipe_comment_stars == 4){	
				$get_rating_4= $get_rating_4+1;
			}
			elseif($inp_recipe_comment_stars == 5){	
				$get_rating_5 = $get_rating_5+1;
			}

			$inp_rating_total_votes = $get_rating_1+$get_rating_2+$get_rating_3+$get_rating_4+$get_rating_5;
			$inp_rating_average     = round((($get_rating_1*1) + ($get_rating_2*2) + ($get_rating_3*3) + ($get_rating_4*4) + ($get_rating_5*5))/$inp_rating_total_votes);

			$positive = $get_rating_4+$get_rating_5;
			$negative = $get_rating_1+$get_rating_2;
			$total    = $positive+$negative;
			$inp_rating_popularity  = round(($positive/$total*100));
						
			$result = mysqli_query($link, "UPDATE $t_recipes_rating SET rating_1=$get_rating_1, rating_2=$get_rating_2, rating_3=$get_rating_3, rating_4=$get_rating_4, rating_5=$get_rating_5, rating_total_votes=$inp_rating_total_votes, rating_average=$inp_rating_average , rating_popularity=$inp_rating_popularity, rating_ip_block='' WHERE rating_recipe_id='$get_recipe_id'") or die(mysqli_error($link));
					



			// Statistics
			// --> weekly
			$day = date("d");
			$month = date("m");
			$week = date("W");
			$year = date("Y");

			$query = "SELECT weekly_id, weekly_comments_written FROM $t_stats_comments_weekly WHERE weekly_week=$week AND weekly_year=$year";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_weekly_id,  $get_weekly_comments_written) = $row;
			if($get_weekly_id == ""){
				mysqli_query($link, "INSERT INTO $t_stats_comments_weekly 
				(weekly_id, weekly_week, weekly_year, weekly_comments_written, weekly_comments_written_diff_from_last_week, weekly_last_updated, weekly_last_updated_day, weekly_last_updated_month, weekly_last_updated_year) 
				VALUES 
				(NULL, $week, $year, 1, 1, '$datetime', $day, $month, $year)")
				or die(mysqli_error($link));
			}
			else{
				$inp_counter = $get_weekly_comments_written+1;
				$result = mysqli_query($link, "UPDATE $t_stats_comments_weekly SET weekly_comments_written=$inp_counter, 
						weekly_last_updated='$datetime', weekly_last_updated_day=$day, weekly_last_updated_month=$month, weekly_last_updated_year=$year WHERE weekly_id=$get_weekly_id") or die(mysqli_error($link));
			}

			// --> monthly
			$query = "SELECT monthly_id, monthly_comments_written FROM $t_stats_comments_monthly WHERE monthly_month=$month AND monthly_year=$year";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_monthly_id,  $get_monthly_comments_written) = $row;
			if($get_monthly_id == ""){
				mysqli_query($link, "INSERT INTO $t_stats_comments_monthly 
				(monthly_id, monthly_month, monthly_year, monthly_comments_written, monthly_last_updated, monthly_last_updated_day, monthly_last_updated_month, monthly_last_updated_year ) 
				VALUES 
				(NULL, $month, $year, 1, '$datetime', $day, $month, $year)")
				or die(mysqli_error($link));
			}
			else{
				$inp_counter = $get_monthly_comments_written+1;
				$result = mysqli_query($link, "UPDATE $t_stats_comments_monthly SET monthly_comments_written=$inp_counter, 
						monthly_last_updated='$datetime', monthly_last_updated_day=$day, monthly_last_updated_month=$month, monthly_last_updated_year=$year WHERE monthly_id=$get_monthly_id") or die(mysqli_error($link));
			}

			// --> yearly
			$query = "SELECT yearly_id, yearly_comments_written FROM $t_stats_comments_yearly WHERE yearly_year=$year";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_yearly_id, $get_yearly_comments_written) = $row;
			if($get_yearly_id == ""){
				mysqli_query($link, "INSERT INTO $t_stats_comments_yearly 
				(yearly_id, yearly_year, yearly_comments_written, yearly_last_updated, yearly_last_updated_day, yearly_last_updated_month, yearly_last_updated_year) 
				VALUES 
				(NULL, $year, 1, '$datetime', $day, $month, $year)")
				or die(mysqli_error($link));
			}
			else{
				$inp_counter = $get_yearly_comments_written+1;
				$result = mysqli_query($link, "UPDATE $t_stats_comments_yearly SET yearly_comments_written=$inp_counter, 
						yearly_last_updated='$datetime', yearly_last_updated_day=$day, yearly_last_updated_month=$month, yearly_last_updated_year=$year WHERE yearly_id=$get_yearly_id") or die(mysqli_error($link));
			}



			// Header
			$ft = "success";
			$fm = "comment_added";
			$url = "view_recipe.php?recipe_id=$get_recipe_id&l=$l&comment_ft=$ft&comment_fm=$fm#comments";
			header("Location: $url");
			exit;
		} // process
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