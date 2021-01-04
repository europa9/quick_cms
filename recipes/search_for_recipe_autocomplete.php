<?php 
/**
*
* File: recipes/index_search_for_recipe_autocomplete.php
* Version 1.0
* Date 11:52 31.12.2020
* Copyright (c) 2020 S. A. Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "2";
$pageNoColumnSav      = "2";
$pageAllowCommentsSav = "1";
$pageAuthorUserIdSav  = "1";

/*- Root dir --------------------------------------------------------------------------------- */
// This determine where we are
if(file_exists("favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
elseif(file_exists("../../../../favicon.ico")){ $root = "../../../.."; }
else{ $root = "../../.."; }

/*- Website config --------------------------------------------------------------------------- */
include("$root/_admin/website_config.php");


/*- Tables ---------------------------------------------------------------------------- */
$t_recipes 		= $mysqlPrefixSav . "recipes";
$t_recipes_numbers 	= $mysqlPrefixSav . "recipes_numbers";

/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['l'])) {
	$l = $_GET['l'];
	$l = strip_tags(stripslashes($l));
	$l = output_html($l);
	$l = substr($l, 0, 2);
	if(!(file_exists("$root/_admin/_translations/site/$l/recipes/ts_search.php"))){
		echo"Error lang";
		die;
	}
}
else{
	$l = "en";
}

// Language
include("$root/_admin/_translations/site/$l/recipes/ts_search.php");
include("$root/_admin/_translations/site/$l/recipes/ts_recipes.php");


/*- Query --------------------------------------------------------------------------- */

if(isset($_GET['q']) && $_GET['q'] != ''){
	$q = $_GET['q'];
	$q = strip_tags(stripslashes($q));
	$q = trim($q);
	$q = strtolower($q);
	$q = output_html($q);
	$q = "%" . $q . "%";
	$q_mysql = quote_smart($link, $q);


	$l_mysql = quote_smart($link, $l);

	// 1. Search for recipe
	$search_results_count  = 0;
	$x = 0;
	$query = "SELECT $t_recipes.recipe_id, $t_recipes.recipe_title, $t_recipes.recipe_language, $t_recipes.recipe_introduction, $t_recipes.recipe_image_path, $t_recipes.recipe_image, $t_recipes.recipe_unique_hits, $t_recipes_numbers.number_serving_calories, $t_recipes_numbers.number_serving_proteins, $t_recipes_numbers.number_serving_fat, $t_recipes_numbers.number_serving_carbs FROM $t_recipes JOIN $t_recipes_numbers ON $t_recipes.recipe_id=$t_recipes_numbers.number_recipe_id WHERE $t_recipes.recipe_title LIKE $q_mysql AND $t_recipes.recipe_language=$l_mysql";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_recipe_id, $get_recipe_title, $get_recipe_language, $get_recipe_introduction, $get_recipe_image_path, $get_recipe_image, $get_recipe_unique_hits, $get_number_serving_calories, $get_number_serving_proteins, $get_number_serving_fat, $get_number_serving_carbs) = $row;

		if($get_recipe_image != ""){
		

			// Get rating
			$query_rating = "SELECT rating_id, rating_average, rating_popularity FROM $t_recipes_rating WHERE rating_recipe_id='$get_recipe_id'";
			$result_rating = mysqli_query($link, $query_rating);
			$row_rating = mysqli_fetch_row($result_rating);
			list($get_rating_id, $get_rating_average, $get_rating_popularity) = $row_rating;

			
			// 3 divs

			// 600 / 4 = 150
			// 600 / 3 = 200

			// Thumb

			$inp_new_x = 190;
			$inp_new_y = 98;
			$thumb = "recipe_" . $get_recipe_id . "-" . $inp_new_x . "x" . $inp_new_y . ".png";

			if(!(file_exists("$root/_cache/$thumb"))){
				resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_recipe_image_path/$get_recipe_image", "$root/_cache/$thumb");
			}




			if($x == 0){
				echo"
				<div class=\"clear\"></div>
				<div class=\"left_center_center_right_left\">
				";
			}
			elseif($x == 1){
				echo"
				<div class=\"left_center_center_left_right_center\">
				";
			}
			elseif($x == 2){
				echo"
				<div class=\"left_center_center_right_right_center\">
				";
			}
			elseif($x == 3){
				echo"
				<div class=\"left_center_center_right_right\">
				";
			}
		
			echo"
					<!-- skriver ut bilder per oppskrift -->
					<p class=\"recipe_open_category_img_p\">
					<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\"><img src=\"$root/_cache/$thumb\" alt=\"$get_recipe_image\"  /></a><br />
					</p>
					<p class=\"recipe_open_category_p\">
					<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"recipe_open_category_a\">$get_recipe_title</a>
					</p>


					<div class=\"recipe_open_category_unique_hits\">
						<img src=\"_gfx/icons/ic_eye_grey_18px.png\" alt=\"eye.png\" style=\"float:left;padding-right: 5px;\" /> 
						<span class=\"recipe_open_category_unique_hits_span\">
						$get_recipe_unique_hits 
						</span>
					</div>
					<div class=\"recipe_open_category_popularity\">
						<span class=\"recipe_open_category_popularity_span\">
						$get_rating_popularity %
						</span>
						<img src=\"_gfx/icons/ic_thumb_up_grey_18px.png\" alt=\"ic_thumb_up_grey_18px.png\" style=\"padding-left: 5px;\" /> 
					</div>



				</div>
			";

			// Increment
			$x++;
		
			// Reset
			if($x == 4){
				$x = 0;
			}

			$search_results_count++;
		} // get_recipe_image
	}


	if($x == 1){
		echo"
			<div class=\"left_center_center_right_center\">
			</div>
			<div class=\"left_center_center_right_center\">
			</div>
			<div class=\"left_center_center_right_right\">
			</div>
		";
	
	}
	elseif($x == 2){
		echo"
			<div class=\"left_center_center_right_center\">
			</div>
			<div class=\"left_center_center_right_right\">
			</div>
		";

	}
	elseif($x == 3){
		echo"
			<div class=\"left_center_center_right_right\">
			</div>
		";

	}

	// Search into database
	$my_ip = $_SERVER['REMOTE_ADDR'];
	$my_ip = output_html($my_ip);
	$my_ip_mysql = quote_smart($link, $my_ip);

	$datetime = date("Y-m-d H:i:s");
	$datetime_saying = date("j M Y");

	$search_query = str_replace("%", "", $q);
	$search_query_mysql = quote_smart($link, $search_query);
	$query = "SELECT search_id, search_unique_count, search_unique_ip_block FROM $t_recipes_searches WHERE search_query=$search_query_mysql AND search_language=$l_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_search_id, $get_search_unique_count, $get_search_unique_ip_block) = $row;

	if($get_search_id == ""){
		mysqli_query($link, "INSERT INTO $t_recipes_searches 
		(search_id, search_query, search_language, search_unique_count, search_unique_ip_block, search_first_datetime, search_first_saying, search_last_datetime, search_last_saying, search_found_recipes) 
		VALUES 
		(NULL, $search_query_mysql, $l_mysql, 1, $my_ip_mysql, '$datetime', '$datetime_saying', '$datetime', '$datetime_saying', $search_results_count)")
		or die(mysqli_error($link));
	}
	else{
		$unique_ip_block_array = explode("\n", $get_search_unique_ip_block);
		$size = sizeof($unique_ip_block_array);
		if($size > 10){
			$size = 1;
		}
		
		$count_me = 1;

		for($x=0;$x<$size;$x++){
			$ip = $unique_ip_block_array[$x];
			if($ip == "$my_ip"){
				$count_me = 0;
				break;
			}
		}
		
		if($count_me == "1"){
			$inp_search_unique_count = $get_search_unique_count+1;
			$inp_search_unique_ip_block = $get_search_unique_ip_block . "\n" . $my_ip;
		}
		else{
			$inp_search_unique_count = $get_search_unique_count;
			$inp_search_unique_ip_block = $get_search_unique_ip_block . "\n" . $my_ip;
		}
		$inp_search_unique_ip_block_mysql = quote_smart($link, $inp_search_unique_ip_block);


		$result = mysqli_query($link, "UPDATE $t_recipes_searches SET search_unique_count=$inp_search_unique_count, search_unique_ip_block=$inp_search_unique_ip_block_mysql, search_last_datetime='$datetime', search_last_saying='$datetime_saying', search_found_recipes=$search_results_count WHERE search_id=$get_search_id") or die(mysqli_error($link));

	}

	if($search_results_count == 0){
		echo"
		<p>$l_no_recipes_found</p>
		";

		// Send email to moderator
		$q = str_replace("%", "", $q);
		$q_encrypted = md5("$q");
		$q_antispam_file = "$root/_cache/recipe_search_no_results_" . $q_encrypted . ".txt";
		
		if(!(file_exists("$q_antispam_file"))){
			
			$fh = fopen($q_antispam_file, "w") or die("can not open file");
			fwrite($fh, "$q");
			fclose($fh);
			
		
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




			// Mail from
			$search_link = $configSiteURLSav . "/recipes/search.php?q=$q&amp;l=$l";
			$subject = "No search result for $q at $configWebsiteTitleSav";

			$message = "<html>\n";
			$message = $message. "<head>\n";
			$message = $message. "  <title>$subject</title>\n";
			$message = $message. " </head>\n";
			$message = $message. "<body>\n";

			$message = $message . "<p>Hi $get_moderator_user_name,</p>\n\n";
			$message = $message . "<p><b>Summary:</b><br />A user has searched for <em>$q</em> and got no search results at $configWebsiteTitleSav for lanugage $l.\n";
			$message = $message . "Please consider to add a recipe for that query.</p>\n\n";

			$message = $message . "<p style='padding-bottom:0;margin-bottom:0'><b>Search information:</b></p>\n";
			$message = $message . "<table>\n";
			$message = $message . " <tr><td><span>Query:</span></td><td><span>$q</span></td></tr>\n";
			$message = $message . " <tr><td><span>Link:</span></td><td><span><a href=\"$search_link\">$search_link</a></span></td></tr>\n";
			$message = $message . "</table>\n";

			$message = $message . "<p>\n\n--<br />\nBest regards<br />\n$configWebsiteTitleSav</p>";
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
			$header .= "From: ".$configFromNameSav." <".$configFromEmailSav."> \r\n";
			$header .= "MIME-Version: 1.0 \r\n";
			$header .= "Content-Transfer-Encoding: 8bit \r\n";
			$header .= "Date: ".date("r (T)")." \r\n";
			$header .= iconv_mime_encode("Subject", $subject, $subject_preferences);

			mail($get_moderator_user_email, $subject, $message, $header);

			echo"<p>Our moderator $get_moderator_user_name will look at this query and maybe add a recipe for it later.</p>";
		}
	}
}
else{
	echo"Missing q";
}

?>