<?php 
/**
*
* File: recipes/my_recipes.php
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
	
	if($mode == "process"){

		$inp_recipe_country = $_POST['inp_recipe_country'];
		$inp_recipe_country = output_html($inp_recipe_country);
		$inp_recipe_country_mysql = quote_smart($link, $inp_recipe_country);


		$inp_recipe_title = $_POST['inp_recipe_title'];
		$inp_recipe_title = output_html($inp_recipe_title);
		$inp_recipe_title_mysql = quote_smart($link, $inp_recipe_title);
		if(empty($inp_recipe_title)){
			$ft = "error";
			$fm = $l_recipe_title_cant_be_empty;
			$mode = "";
		}
		else{
			// Check if we alreaddy have that recipe
			$query = "SELECT recipe_id FROM $t_recipes WHERE recipe_title=$inp_recipe_title_mysql AND recipe_language=$l_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_recipe_id) = $row;

			if($get_recipe_id != ""){
				$ft = "info";
				$fm = $l_we_already_have_a_recipe_with_that_name;
			
				$mode = "";
			}
		}

		$inp_recipe_introduction = $_POST['inp_recipe_introduction'];
		$inp_recipe_introduction = output_html($inp_recipe_introduction);
		$inp_recipe_introduction_mysql = quote_smart($link, $inp_recipe_introduction);
		if(empty($inp_recipe_introduction)){
			$ft = "error";
			$fm = $l_recipe_introduction_cant_be_empty;
			$mode = "";
		}

		$inp_recipe_category_id = $_POST['inp_recipe_category_id'];
		$inp_recipe_category_id = output_html($inp_recipe_category_id);
		$inp_recipe_category_id_mysql = quote_smart($link, $inp_recipe_category_id);
		
		$inp_recipe_cusine_id = $_POST['inp_recipe_cusine_id'];
		$inp_recipe_cusine_id = output_html($inp_recipe_cusine_id);
		$inp_recipe_cusine_id_mysql = quote_smart($link, $inp_recipe_cusine_id);

		$inp_recipe_occasion_id = $_POST['inp_recipe_occasion_id'];
		$inp_recipe_occasion_id = output_html($inp_recipe_occasion_id);
		$inp_recipe_occasion_id_mysql = quote_smart($link, $inp_recipe_occasion_id);

		$inp_recipe_season_id = $_POST['inp_recipe_season_id'];
		$inp_recipe_season_id = output_html($inp_recipe_season_id);
		$inp_recipe_season_id_mysql = quote_smart($link, $inp_recipe_season_id);

		$inp_number_servings = $_POST['inp_number_servings'];
		$inp_number_servings = output_html($inp_number_servings);
		$inp_number_servings_mysql = quote_smart($link, $inp_number_servings);
		if(empty($inp_number_servings)){
			$ft = "error";
			$fm = $l_servings_cant_be_empty;
			$mode = "";
		}


		$inp_recipe_user_id = $_SESSION['user_id'];
		$inp_recipe_user_id = output_html($inp_recipe_user_id);
		$inp_recipe_user_id_mysql = quote_smart($link, $inp_recipe_user_id);

		$inp_recipe_date = date("Y-m-d");
		$inp_recipe_time = date("H:i:s");

		$inp_recipe_user_ip = $_SERVER['REMOTE_ADDR'];
		$inp_recipe_user_ip = output_html($inp_recipe_user_ip);
		$inp_recipe_user_ip_mysql = quote_smart($link, $inp_recipe_user_ip);

		$inp_recipe_password = $inp_recipe_date . $inp_recipe_time . $inp_recipe_user_ip;
		$inp_recipe_password = sha1($inp_recipe_password);
		$inp_recipe_password_mysql = quote_smart($link, $inp_recipe_password);
		
		$inp_recipe_last_viewed = $inp_recipe_date . " " . $inp_recipe_time;

		
		if(isset($_POST['inp_recipe_language'])){
			$inp_recipe_language = $_POST['inp_recipe_language'];
			$inp_recipe_language = output_html($inp_recipe_language);
			$l = "$inp_recipe_language";
		}
		else{
			$inp_recipe_language = "$l";
		}
		$inp_recipe_language_mysql = quote_smart($link, $inp_recipe_language);

		if(isset($_POST['inp_age_restriction'])){
			$inp_age_restriction = $_POST['inp_age_restriction'];
			$inp_age_restriction = output_html($inp_age_restriction);
		}
		else{
			$inp_age_restriction = "$l";
		}
		$inp_age_restriction_mysql = quote_smart($link, $inp_age_restriction);


		if($mode == "process"){
			// Create shell
			
			// recipes
			mysqli_query($link, "INSERT INTO $t_recipes
			(recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_country, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb_278x156, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_comments, recipe_user_ip, recipe_notes, recipe_password, recipe_last_viewed, recipe_age_restriction) 
			VALUES 
			(NULL, $inp_recipe_user_id_mysql, $inp_recipe_title_mysql, $inp_recipe_category_id_mysql, $inp_recipe_language_mysql, $inp_recipe_country_mysql, $inp_recipe_introduction_mysql, '', '', '', '', '',  '$inp_recipe_date', '$inp_recipe_time', $inp_recipe_cusine_id_mysql, $inp_recipe_season_id_mysql, $inp_recipe_occasion_id_mysql, '', '0', '', 0, $inp_recipe_user_ip_mysql, 'E-mail not sent to administrators', $inp_recipe_password_mysql, '$inp_recipe_last_viewed', $inp_age_restriction_mysql)")
			or die(mysqli_error($link));

			// Get recipe ID
			$query = "SELECT recipe_id FROM $t_recipes WHERE recipe_user_id=$inp_recipe_user_id_mysql AND recipe_date='$inp_recipe_date' AND recipe_time='$inp_recipe_time'";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_recipe_id) = $row;


			// recipes_groups
			$inp_group_title = "$l_ingredients";
			$inp_group_title = output_html($inp_group_title);
			$inp_group_title_mysql = quote_smart($link, $inp_group_title);

			mysqli_query($link, "INSERT INTO $t_recipes_groups
			(group_id, group_recipe_id, group_title) 
			VALUES 
			(NULL, '$get_recipe_id', $inp_group_title_mysql)")
			or die(mysqli_error($link));

			// recipes_items

			// recipes_numbers
			mysqli_query($link, "INSERT INTO $t_recipes_numbers
			(number_id, number_recipe_id, number_hundred_calories, 
			number_hundred_proteins, number_hundred_fat, number_hundred_fat_of_which_saturated_fatty_acids, 
			number_hundred_carbs, number_hundred_carbs_of_which_dietary_fiber, number_hundred_carbs_of_which_sugars, 
			number_hundred_salt, number_hundred_sodium, number_serving_calories, 
			number_serving_proteins, number_serving_fat, number_serving_fat_of_which_saturated_fatty_acids, 
			number_serving_carbs, number_serving_carbs_of_which_dietary_fiber, number_serving_carbs_of_which_sugars, 
			number_serving_salt, number_serving_sodium, number_total_weight, 
			number_total_calories, number_total_proteins, number_total_fat, 
			number_total_fat_of_which_saturated_fatty_acids, number_total_carbs, number_total_carbs_of_which_dietary_fiber, 
			number_total_carbs_of_which_sugars, number_total_salt, number_total_sodium, 
			number_servings) 
			VALUES 
			(NULL, '$get_recipe_id', '0', 
			'0', '0', '0',
			'0', '0', '0',
			'0', '0', '0',
			'0', '0', '0',
			'0', '0', '0',
			'0', '0', '0',
			'0', '0', '0',
			'0', '0', '0',
			'0', '0', '0',
			$inp_number_servings_mysql)")
			or die(mysqli_error($link));

			// recipes_rating
			mysqli_query($link, "INSERT INTO $t_recipes_rating
			(rating_id, rating_recipe_id, rating_1, rating_2, rating_3, rating_4, rating_5, rating_total_votes, rating_average, rating_popularity, rating_ip_block) 
			VALUES 
			(NULL, '$get_recipe_id', '0', '0', '0', '0', '0', '0', '0', '0', '')")
			or die(mysqli_error($link));


			// Find group ID
			$query = "SELECT group_id, group_recipe_id, group_title FROM $t_recipes_groups WHERE group_recipe_id=$get_recipe_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_group_id, $get_group_recipe_id, $get_group_title) = $row;
			


			echo"
			<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float: left;padding: 2px 4px 0px 0px\" /> $l_submit_recipe</h1>
			
			<meta http-equiv=\"refresh\" content=\"1;url=submit_recipe_step_2_group_and_elements.php?recipe_id=$get_recipe_id&amp;action=add_items&amp;group_id=$get_group_id&amp;l=$l\">

			<p>
			<a href=\"submit_recipe_step_2_group_and_elements.php?recipe_id=$get_recipe_id&amp;action=add_items&amp;group_id=$get_group_id&amp;l=$l\" class=\"btn\">$l_continue</a>
			</p>

			";
		}
	}
	if($mode == ""){


		if(isset($_POST['inp_recipe_language'])){
			$inp_recipe_language = $_POST['inp_recipe_language'];
			$inp_recipe_language = output_html($inp_recipe_language);
		}
		else{
			$inp_recipe_language = "$l";
		}
		if(isset($_POST['inp_recipe_title'])){
			$inp_recipe_title = $_POST['inp_recipe_title'];
			$inp_recipe_title = output_html($inp_recipe_title);
		}
		else{
			$inp_recipe_title = "";
		}
		if(isset($_POST['inp_recipe_introduction'])){
			$inp_recipe_introduction = $_POST['inp_recipe_introduction'];
			$inp_recipe_introduction = output_html($inp_recipe_introduction);
		}
		else{
			$inp_recipe_introduction = "";
		}
		if(isset($_POST['inp_recipe_category_id'])){
			$inp_recipe_category_id = $_POST['inp_recipe_category_id'];
			$inp_recipe_category_id = output_html($inp_recipe_category_id);
		}
		else{
			$inp_recipe_category_id = "";
		}
		if(isset($_POST['inp_recipe_cusine_id'])){
			$inp_recipe_cusine_id = $_POST['inp_recipe_cusine_id'];
			$inp_recipe_cusine_id = output_html($inp_recipe_cusine_id);
		}
		else{
			$inp_recipe_cusine_id = "";
		}
		if(isset($_POST['inp_recipe_occasion_id'])){
			$inp_recipe_occasion_id = $_POST['inp_recipe_occasion_id'];
			$inp_recipe_occasion_id = output_html($inp_recipe_occasion_id);
		}
		else{
			$inp_recipe_occasion_id = "";
		}
		if(isset($_POST['inp_recipe_season_id'])){
			$inp_recipe_season_id = $_POST['inp_recipe_season_id'];
			$inp_recipe_season_id = output_html($inp_recipe_season_id);
		}
		else{
			$inp_recipe_season_id = "";
		}
		if(isset($_POST['inp_number_servings'])){
			$inp_number_servings = $_POST['inp_number_servings'];
			$inp_number_servings = output_html($inp_number_servings);
		}
		else{
			$inp_number_servings = "1";
		}
		if(isset($_POST['inp_age_restriction'])){
			$inp_age_restriction = $_POST['inp_age_restriction'];
			$inp_age_restriction = output_html($inp_age_restriction);
		}
		else{
			$inp_age_restriction = "0";
		}
	


		echo"
		<h1>$l_submit_recipe</h1>
	

		<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_recipe_title\"]').focus();
			});
			</script>
		<!-- //Focus -->

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

			<form method=\"post\" action=\"submit_recipe.php?l=$l&amp;mode=process\" enctype=\"multipart/form-data\">
	
			<p><b>$l_language</b><br />
			<select name=\"inp_recipe_language\">\n";
			$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;
	
				$flag_path 	= "$root/_webdesign/images/footer/flag_$get_language_active_flag" . "_16x16.png";

				echo"						";
				echo"<option value=\"$get_language_active_iso_two\""; if($inp_recipe_language == "$get_language_active_iso_two"){ echo" selected=\"selected\""; } echo">$get_language_active_name</option>\n";
			}
			echo"
			</select>
			</p>

			<p><b>$l_country*:</b><br />\n";

			if(isset($_GET['inp_food_country'])){
				$inp_food_country = $_GET['inp_food_country'];
				$inp_food_country = strip_tags(stripslashes($inp_food_country));
			}
			else{
				$inp_food_country = "";
			}

			// Find the country the last person registrered used
			$inp_user_id = $_SESSION['user_id'];
			$inp_user_id = output_html($inp_user_id);
			$inp_user_id_mysql = quote_smart($link, $inp_user_id);

			$query = "SELECT recipe_country FROM $t_recipes WHERE recipe_user_id=$inp_user_id_mysql ORDER BY recipe_id DESC LIMIT 0,1";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($inp_recipe_country) = $row;

			echo"
			<select name=\"inp_recipe_country\">";
			$query = "SELECT language_flag FROM $t_languages ORDER BY language_flag ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_language_flag) = $row;

				$country = str_replace("_", " ", $get_language_flag);
				$country = ucwords($country);
				if($country != "$prev_country"){
					echo"			";
					echo"<option value=\"$country\""; if($inp_recipe_country == "$country"){ echo" selected=\"selected\""; } echo">$country</option>\n";
				}
				$prev_country = "$country";
			}
			echo"
			</select>
			</p>



			<p><b>$l_title</b><br />
			<input type=\"text\" name=\"inp_recipe_title\" value=\"$inp_recipe_title\" size=\"50\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
			</p>

			<p><b>$l_introduction</b><br />
			<textarea name=\"inp_recipe_introduction\" rows=\"3\" cols=\"40\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">$inp_recipe_introduction</textarea>
			</p>


	
			<p><b>$l_category</b><br />
			<select name=\"inp_recipe_category_id\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">\n";
			$query = "SELECT category_id, category_name FROM $t_recipes_categories ORDER BY category_name ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
			list($get_category_id, $get_category_name) = $row;

			// Get translation
			$query_translation = "SELECT category_translation_id, category_translation_language, category_translation_value FROM $t_recipes_categories_translations WHERE category_id=$get_category_id AND category_translation_language=$l_mysql";
			$result_translation = mysqli_query($link, $query_translation);
			$row_translation = mysqli_fetch_row($result_translation);
			list($get_category_translation_id, $get_category_translation_language, $get_category_translation_value) = $row_translation;
			if($get_category_translation_id == ""){
				$get_category_translation_value = $get_category_name;
			}

			echo"						";
			echo"<option value=\"$get_category_id\""; if($inp_recipe_category_id == $get_category_id){ echo" selected=\"selected\""; } echo">$get_category_translation_value</option>\n";
			}
			echo"
			</select>
			</p>


			<p><b>$l_servings</b><br />
			<select name=\"inp_number_servings\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">
			<option value=\"0\""; if($inp_number_servings == ""){ echo" selected=\"selected\""; } echo">$l_none</option>\n";
			for($x=1;$x<21;$x++){
				echo"						";
				echo"<option value=\"$x\""; if($inp_number_servings == $x){ echo" selected=\"selected\""; } echo">$x</option>\n";
			}
			echo"
			</select>
			</p>

			<p><b>$l_cusine</b><br />
			<select name=\"inp_recipe_cusine_id\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">
			<option value=\"0\""; if($inp_recipe_cusine_id == ""){ echo" selected=\"selected\""; } echo">$l_none</option>\n";
			$query = "SELECT cuisine_id, cuisine_name FROM $t_recipes_cuisines ORDER BY cuisine_name ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
			list($get_cuisine_id, $get_cuisine_name) = $row;

			// Translation
			$query_translation = "SELECT cuisine_translation_id, cuisine_translation_value FROM $t_recipes_cuisines_translations WHERE cuisine_id=$get_cuisine_id AND cuisine_translation_language=$l_mysql";
			$result_translation = mysqli_query($link, $query_translation);
			$row_translation = mysqli_fetch_row($result_translation);
			list($get_cuisine_translation_id, $get_cuisine_translation_value) = $row_translation;
			if($get_cuisine_translation_id == ""){
				$get_cuisine_translation_value = $get_cuisine_name;
			}

			echo"						";
			echo"<option value=\"$get_cuisine_id\""; if($inp_recipe_cusine_id == $get_cuisine_id){ echo" selected=\"selected\""; } echo">$get_cuisine_translation_value</option>\n";
			}
			echo"
			</select>
			</p>

			<p><b>$l_occasion</b><br />
			<select name=\"inp_recipe_occasion_id\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">
			<option value=\"0\""; if($inp_recipe_occasion_id == ""){ echo" selected=\"selected\""; } echo">$l_none</option>\n";
			$query = "SELECT occasion_id, occasion_name FROM $t_recipes_occasions ORDER BY occasion_name ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
			list($get_occasion_id, $get_occasion_name) = $row;
			echo"						";

			// Translation
			$query_translation = "SELECT occasion_translation_id, occasion_translation_language, occasion_translation_value FROM $t_recipes_occasions_translations WHERE occasion_id=$get_occasion_id AND occasion_translation_language=$l_mysql";
			$result_translation = mysqli_query($link, $query_translation);
			$row_translation = mysqli_fetch_row($result_translation);
			list($get_occasion_translation_id, $get_occasion_translation_language, $get_occasion_translation_value) = $row_translation;
			if($get_occasion_translation_id == ""){
				$get_occasion_translation_value = $get_occasion_name;
			}

			echo"<option value=\"$get_occasion_id\""; if($inp_recipe_occasion_id == $get_occasion_id){ echo" selected=\"selected\""; } echo">$get_occasion_translation_value</option>\n";
			}
			echo"
			</select>
			</p>

			<p><b>$l_season</b><br />
			<select name=\"inp_recipe_season_id\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">
			<option value=\"0\""; if($inp_recipe_season_id == ""){ echo" selected=\"selected\""; } echo">$l_none</option>\n";
			$query = "SELECT season_id, season_name FROM $t_recipes_seasons";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
			list($get_season_id, $get_season_name) = $row;

			// Translation
			$query_translation = "SELECT season_translation_id, season_translation_language,season_translation_value FROM $t_recipes_seasons_translations WHERE season_id=$get_season_id AND season_translation_language=$l_mysql";
			$result_translation = mysqli_query($link, $query_translation);
			$row_translation = mysqli_fetch_row($result_translation);
			list($get_season_translation_id, $get_season_translation_language, $get_season_translation_value) = $row_translation;
			if($get_season_translation_id == ""){
				$get_season_translation_value = $get_season_name;
			}

			echo"						";
			echo"<option value=\"$get_season_id\""; if($inp_recipe_season_id == $get_season_id){ echo" selected=\"selected\""; } echo">$get_season_translation_value</option>\n";
			}
			echo"
			</select>
			</p>

			<p><b>$l_age_restriction:</b><br />
			<select name=\"inp_age_restriction\">
				<option value=\"0\""; if($inp_age_restriction == "0" OR $inp_age_restriction == ""){ echo" selected=\"selected\""; } echo">$l_no</option>
				<option value=\"1\""; if($inp_age_restriction == "1"){ echo" selected=\"selected\""; } echo">$l_yes</option>
			</select>
			<br />
			<em>$l_example_alcohol</em></p>

			<p>
			<input type=\"submit\" value=\"$l_continue\" class=\"btn\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
			</p>
		<!-- //Form -->
		";
	} // mode == ""
}
else{
	echo"
	<h1>
	<img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/recipes/submit_recipe.php\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>