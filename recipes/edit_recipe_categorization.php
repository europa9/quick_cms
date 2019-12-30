<?php 
/**
*
* File: recipes/edit_recipe_c.php
* Version 1.0.0
* Date 13:43 18.11.2017
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
if(isset($_GET['recipe_id'])) {
	$recipe_id = $_GET['recipe_id'];
	$recipe_id = strip_tags(stripslashes($recipe_id));
}
else{
	$recipe_id = "";
}

$l_mysql = quote_smart($link, $l);



/*- Get recipe ------------------------------------------------------------------------- */
// Select
$user_id = $_SESSION['user_id'];
$recipe_user_id_mysql = quote_smart($link, $user_id);
$recipe_id_mysql = quote_smart($link, $recipe_id);
$query = "SELECT recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_country, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_comments, recipe_user_ip, recipe_notes, recipe_password, recipe_last_viewed, recipe_age_restriction FROM $t_recipes WHERE recipe_id=$recipe_id_mysql AND recipe_user_id=$recipe_user_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_recipe_id, $get_recipe_user_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_language, $get_recipe_country, $get_recipe_introduction, $get_recipe_directions, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb, $get_recipe_video, $get_recipe_date, $get_recipe_time, $get_recipe_cusine_id, $get_recipe_season_id, $get_recipe_occasion_id, $get_recipe_marked_as_spam, $get_recipe_unique_hits, $get_recipe_unique_hits_ip_block, $get_recipe_comments, $get_recipe_user_ip, $get_recipe_notes, $get_recipe_password, $get_recipe_last_viewed, $get_recipe_age_restriction) = $row;

// Translations
include("$root/_admin/_translations/site/$l/recipes/ts_edit_recipe.php");

/*- Headers ---------------------------------------------------------------------------------- */
if($get_recipe_id == ""){
	$website_title = "Server error 404";
}
else{
	$website_title = "$l_my_recipes - $get_recipe_title - $l_edit_recipe";
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
	The recipe you are trying to edit was not found.
	</p>

	<p>
	<a href=\"index.php\">Back</a>
	</p>
	";
}
else{
	// Get number of servings
	$query = "SELECT number_servings, number_total_calories, number_total_proteins, number_total_fat, number_total_carbs FROM $t_recipes_numbers WHERE number_recipe_id=$recipe_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_number_servings, $get_number_total_calories, $get_number_total_proteins, $get_number_total_fat, $get_number_total_carbs) = $row;

	if($process == 1){
		

		$inp_recipe_country = $_POST['inp_recipe_country'];
		$inp_recipe_country = output_html($inp_recipe_country);
		$inp_recipe_country_mysql = quote_smart($link, $inp_recipe_country);


		// Servings
		$inp_number_servings = $_POST['inp_number_servings'];
		$inp_number_servings = output_html($inp_number_servings);
		$inp_number_servings_mysql = quote_smart($link, $inp_number_servings);

		if($inp_number_servings != "$get_number_servings"){
			// Update the rest of the numbers
			
					
			$inp_number_serving_calories = round($get_number_total_calories/$inp_number_servings);
			$inp_number_serving_proteins = round($get_number_total_proteins/$inp_number_servings);
			$inp_number_serving_fat      = round($get_number_total_fat/$inp_number_servings);
			$inp_number_serving_carbs    = round($get_number_total_carbs/$inp_number_servings);
	
			$inp_number_serving_calories_mysql = quote_smart($link, $inp_number_serving_calories);
			$inp_number_serving_proteins_mysql = quote_smart($link, $inp_number_serving_proteins);
			$inp_number_serving_fat_mysql      = quote_smart($link, $inp_number_serving_fat);
			$inp_number_serving_carbs_mysql    = quote_smart($link, $inp_number_serving_carbs);



			// Update
			$result = mysqli_query($link, "UPDATE $t_recipes_numbers SET number_servings=$inp_number_servings_mysql, number_serving_calories=$inp_number_serving_calories_mysql, number_serving_proteins=$inp_number_serving_proteins_mysql, number_serving_fat=$inp_number_serving_fat_mysql, number_serving_carbs=$inp_number_serving_carbs_mysql WHERE number_recipe_id=$recipe_id_mysql");
			



		}



		$inp_recipe_category_id = $_POST['inp_recipe_category_id'];
		$inp_recipe_category_id = output_html($inp_recipe_category_id);
		$inp_recipe_category_id_mysql = quote_smart($link, $inp_recipe_category_id);
		$result = mysqli_query($link, "UPDATE $t_recipes SET recipe_category_id=$inp_recipe_category_id_mysql WHERE recipe_id=$recipe_id_mysql");

		$inp_recipe_cusine_id = $_POST['inp_recipe_cusine_id'];
		if($inp_recipe_cusine_id != ""){
			$inp_recipe_cusine_id = output_html($inp_recipe_cusine_id);
			$inp_recipe_cusine_id_mysql = quote_smart($link, $inp_recipe_cusine_id);
			$result = mysqli_query($link, "UPDATE $t_recipes SET recipe_cusine_id=$inp_recipe_cusine_id_mysql WHERE recipe_id=$recipe_id_mysql");
		}

		$inp_recipe_occasion_id = $_POST['inp_recipe_occasion_id'];
		if($inp_recipe_occasion_id != ""){
			$inp_recipe_occasion_id = output_html($inp_recipe_occasion_id);
			$inp_recipe_occasion_id_mysql = quote_smart($link, $inp_recipe_occasion_id);
			$result = mysqli_query($link, "UPDATE $t_recipes SET recipe_occasion_id=$inp_recipe_occasion_id_mysql WHERE recipe_id=$recipe_id_mysql");
		}

		$inp_recipe_season_id = $_POST['inp_recipe_season_id'];
		if($inp_recipe_season_id != ""){
			$inp_recipe_season_id = output_html($inp_recipe_season_id);
			$inp_recipe_season_id_mysql = quote_smart($link, $inp_recipe_season_id);
			$result = mysqli_query($link, "UPDATE $t_recipes SET recipe_season_id=$inp_recipe_season_id_mysql WHERE recipe_id=$recipe_id_mysql");
		}

		if(isset($_POST['inp_recipe_marked_as_spam'])){
			$inp_recipe_marked_as_spam = $_POST['inp_recipe_marked_as_spam'];
			if($inp_recipe_marked_as_spam == "on"){
				$inp_recipe_marked_as_spam = 1;
			}
		}
		else{
			$inp_recipe_marked_as_spam = 0;
		}
		


		if(isset($_POST['inp_recipe_language'])){
			$inp_recipe_language = $_POST['inp_recipe_language'];
			$inp_recipe_language = output_html($inp_recipe_language);
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



		$result = mysqli_query($link, "UPDATE $t_recipes SET recipe_country=$inp_recipe_country_mysql, recipe_language=$inp_recipe_language_mysql, recipe_age_restriction=$inp_age_restriction_mysql WHERE recipe_id=$recipe_id_mysql");
		
		

		// Header
		$url = "edit_recipe_categorization.php?recipe_id=$recipe_id&l=$l&ft=success&fm=changes_saved";
		header("Location: $url");
		exit;
	}



	echo"
	<h1>$get_recipe_title</h1>


	<!-- Menu -->
		<div class=\"tabs\">
			<ul>
				<li><a href=\"edit_recipe.php?recipe_id=$recipe_id&amp;l=$l\">$l_general</a></li>
				<li><a href=\"edit_recipe_ingredients.php?recipe_id=$recipe_id&amp;l=$l\">$l_ingredients</a></li>
				<li><a href=\"edit_recipe_categorization.php?recipe_id=$recipe_id&amp;l=$l\" class=\"active\">$l_categorization</a></li>
				<li><a href=\"edit_recipe_image.php?recipe_id=$recipe_id&amp;l=$l\">$l_image</a></li>
				<li><a href=\"edit_recipe_video.php?recipe_id=$recipe_id&amp;l=$l\">$l_video</a></li>
				<li><a href=\"edit_recipe_tags.php?recipe_id=$recipe_id&amp;l=$l\">$l_tags</a></li>
				<li><a href=\"edit_recipe_links.php?recipe_id=$recipe_id&amp;l=$l\">$l_links</a></li>
			</ul>
		</div><p>&nbsp;</p>
	<!-- //Menu -->

	
	<!-- You are here -->
			<p>
			<b>$l_you_are_here:</b><br />
			<a href=\"my_recipes.php?l=$l#recipe_id=$recipe_id\">$l_my_recipes</a>
			&gt;
			<a href=\"view_recipe.php?recipe_id=$recipe_id&amp;l=$l\">$get_recipe_title</a>
			&gt;
			<a href=\"edit_recipe_categorization.php?recipe_id=$recipe_id&amp;l=$l\">$l_categorization</a>
			</p>
	<!-- //You are here -->

	<!-- Feedback -->
	";
	if($ft != ""){
		if($fm == "changes_saved"){
			$fm = "$l_changes_saved";
		}
		else{
			$fm = ucfirst($ft);
		}
		echo"<div class=\"$ft\"><span>$fm</span></div>";
	}
	echo"	
	<!-- //Feedback -->



	<!-- Form -->
		<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_recipe_country\"]').focus();
			});
			</script>
		<!-- //Focus -->

		<form method=\"post\" action=\"edit_recipe_categorization.php?recipe_id=$recipe_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
	

		<p><b>$l_country</b><br />
		<select name=\"inp_recipe_country\">";
		$query = "SELECT language_flag FROM $t_languages ORDER BY language_flag ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_language_flag) = $row;

			$country = str_replace("_", " ", $get_language_flag);
			$country = ucwords($country);
			if($country != "$prev_country"){
				echo"			";
				echo"<option value=\"$country\""; if($get_recipe_country == "$country"){ echo" selected=\"selected\""; } echo">$country</option>\n";
			}
			$prev_country = "$country";
		}
		echo"
		</select>
		</p>

		<p><b>$l_servings</b><br />
		<select name=\"inp_number_servings\">
			<option value=\"\""; if($get_number_servings == ""){ echo" selected=\"selected\""; } echo">$l_none</option>\n";
			for($x=1;$x<21;$x++){
				echo"						";
				echo"<option value=\"$x\""; if($get_number_servings == $x){ echo" selected=\"selected\""; } echo">$x</option>\n";
			}
			echo"
		</select>
		</p>

		<p><b>$l_category</b><br />
		<select name=\"inp_recipe_category_id\">\n";
			$query = "SELECT category_id, category_translation_value FROM $t_recipes_categories_translations WHERE category_translation_language=$l_mysql ORDER BY category_translation_value ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_category_id, $get_category_translation_value) = $row;
				echo"						";
				echo"<option value=\"$get_category_id\""; if($get_recipe_category_id == $get_category_id){ echo" selected=\"selected\""; } echo">$get_category_translation_value</option>\n";
			}
			echo"
		</select>
		</p>

		<p><b>$l_cusine</b><br />
		<select name=\"inp_recipe_cusine_id\">
			<option value=\"\""; if($get_recipe_cusine_id == ""){ echo" selected=\"selected\""; } echo">$l_none</option>\n";
			$query = "SELECT cuisine_id, cuisine_translation_value FROM $t_recipes_cuisines_translations WHERE cuisine_translation_language=$l_mysql ORDER BY cuisine_translation_value ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_cuisine_id, $get_cuisine_translation_value) = $row;
				echo"						";
				echo"<option value=\"$get_cuisine_id\""; if($get_recipe_cusine_id == $get_cuisine_id){ echo" selected=\"selected\""; } echo">$get_cuisine_translation_value</option>\n";
			}
			echo"
		</select>
		</p>

		<p><b>$l_occasion</b><br />
		<select name=\"inp_recipe_occasion_id\">
			<option value=\"\""; if($get_recipe_occasion_id == ""){ echo" selected=\"selected\""; } echo">$l_none</option>\n";
			$query = "SELECT occasion_id, occasion_translation_value FROM $t_recipes_occasions_translations WHERE occasion_translation_language=$l_mysql ORDER BY occasion_translation_value ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_occasion_id, $get_occasion_translation_value) = $row;
				echo"						";
				echo"<option value=\"$get_occasion_id\""; if($get_recipe_occasion_id == $get_occasion_id){ echo" selected=\"selected\""; } echo">$get_occasion_translation_value</option>\n";
			}
		echo"
		</select>
		</p>

		<p><b>$l_season</b><br />
		<select name=\"inp_recipe_season_id\">
			<option value=\"\""; if($get_recipe_season_id == ""){ echo" selected=\"selected\""; } echo">$l_none</option>\n";
			$query = "SELECT season_id, season_translation_value FROM $t_recipes_seasons_translations WHERE season_translation_language=$l_mysql ORDER BY season_translation_value ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_season_id, $get_season_translation_value) = $row;
				echo"						";
				echo"<option value=\"$get_season_id\""; if($get_recipe_season_id == $get_season_id){ echo" selected=\"selected\""; } echo">$get_season_translation_value</option>\n";
			}
		echo"
		</select>
		</p>

		<p><b>$l_language</b><br />
		<select name=\"inp_recipe_language\">\n";
		$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;
	
			$flag_path 	= "$root/_webdesign/images/footer/flag_$get_language_active_flag" . "_16x16.png";

			echo"						";
			echo"<option value=\"$get_language_active_iso_two\""; if($get_recipe_language == "$get_language_active_iso_two"){ echo" selected=\"selected\""; } echo">$get_language_active_name</option>\n";
		}
		echo"
		</select>
		</p>

		<p><b>$l_age_restriction:</b><br />
		<select name=\"inp_age_restriction\">
			<option value=\"0\""; if($get_recipe_age_restriction == "0"){ echo" selected=\"selected\""; } echo">$l_no</option>
			<option value=\"1\""; if($get_recipe_age_restriction == "1"){ echo" selected=\"selected\""; } echo">$l_yes</option>
		</select>
		<br />
		<em>$l_example_alcohol</em></p>


		<p>
		<input type=\"submit\" value=\"$l_save_changes\" class=\"btn\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
		</p>
		</form>

	<!-- //Form -->


	<!-- Buttons -->
		<p style=\"margin-top: 20px;\">
		<a href=\"my_recipes.php?l=$l#recipe$recipe_id\" class=\"btn btn_default\">$l_my_recipes</a>
		<a href=\"view_recipe.php?recipe_id=$recipe_id&amp;l=$l\" class=\"btn btn_default\">$l_view_recipe</a>

		</p>
	<!-- //Buttons -->
	";
} // recipe found

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>