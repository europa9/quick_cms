<?php 
/**
*
* File: recipes/edit_recipe_tags.php
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

/*- Tables ---------------------------------------------------------------------------- */
$t_search_engine_index 		= $mysqlPrefixSav . "search_engine_index";
$t_search_engine_access_control = $mysqlPrefixSav . "search_engine_access_control";

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
$query = "SELECT recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password FROM $t_recipes WHERE recipe_id=$recipe_id_mysql AND recipe_user_id=$recipe_user_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_recipe_id, $get_recipe_user_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_language, $get_recipe_introduction, $get_recipe_directions, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb, $get_recipe_video, $get_recipe_date, $get_recipe_time, $get_recipe_cusine_id, $get_recipe_season_id, $get_recipe_occasion_id, $get_recipe_marked_as_spam, $get_recipe_unique_hits, $get_recipe_unique_hits_ip_block, $get_recipe_user_ip, $get_recipe_notes, $get_recipe_password) = $row;

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
		// Delete all old tags
		$result = mysqli_query($link, "DELETE FROM $t_recipes_tags WHERE tag_recipe_id=$get_recipe_id");
				
		// Keywords
		$inp_index_keywords = "";

		// Lang
		$inp_tag_language_mysql = quote_smart($link, $get_recipe_language);

		$inp_tag_a = $_POST['inp_tag_a'];
		$inp_tag_a = output_html($inp_tag_a);
		$inp_tag_a_mysql = quote_smart($link, $inp_tag_a);

		$inp_tag_a_clean = clean($inp_tag_a);
		$inp_tag_a_clean = strtolower($inp_tag_a);
		$inp_tag_a_clean_mysql = quote_smart($link, $inp_tag_a_clean);

		if($inp_tag_a != ""){
			// Insert
			mysqli_query($link, "INSERT INTO $t_recipes_tags 
			(tag_id, tag_language, tag_recipe_id, tag_title, tag_title_clean, tag_user_id) 
			VALUES 
			(NULL, $inp_tag_language_mysql, $get_recipe_id, $inp_tag_a_mysql, $inp_tag_a_clean_mysql, $my_user_id_mysql)")
			or die(mysqli_error($link));

			// Keywords
			$inp_index_keywords = "$inp_tag_a";
		}

		$inp_tag_b = $_POST['inp_tag_b'];
		$inp_tag_b = output_html($inp_tag_b);
		$inp_tag_b_mysql = quote_smart($link, $inp_tag_b);

		$inp_tag_b_clean = clean($inp_tag_b);
		$inp_tag_b_clean = strtolower($inp_tag_b);
		$inp_tag_b_clean_mysql = quote_smart($link, $inp_tag_b_clean);

		if($inp_tag_b != ""){
			// Insert
			mysqli_query($link, "INSERT INTO $t_recipes_tags 
			(tag_id, tag_language, tag_recipe_id, tag_title, tag_title_clean, tag_user_id) 
			VALUES 
			(NULL, $inp_tag_language_mysql, $get_recipe_id, $inp_tag_b_mysql, $inp_tag_b_clean_mysql, $my_user_id_mysql)")
			or die(mysqli_error($link));

			// Keywords
			$inp_index_keywords = $inp_index_keywords . ", $inp_tag_b";
		}

		$inp_tag_c = $_POST['inp_tag_c'];
		$inp_tag_c = output_html($inp_tag_c);
		$inp_tag_c_mysql = quote_smart($link, $inp_tag_c);

		$inp_tag_c_clean = clean($inp_tag_c);
		$inp_tag_c_clean = strtolower($inp_tag_c);
		$inp_tag_c_clean_mysql = quote_smart($link, $inp_tag_c_clean);

		if($inp_tag_c != ""){
			// Insert
			mysqli_query($link, "INSERT INTO $t_recipes_tags 
			(tag_id, tag_language, tag_recipe_id, tag_title, tag_title_clean, tag_user_id) 
			VALUES 
			(NULL, $inp_tag_language_mysql, $get_recipe_id, $inp_tag_c_mysql, $inp_tag_c_clean_mysql, $my_user_id_mysql)")
			or die(mysqli_error($link));

			// Keywords
			$inp_index_keywords = $inp_index_keywords . ", $inp_tag_c";
		}

		// Search engine
		$query_exists = "SELECT index_id FROM $t_search_engine_index WHERE index_module_name='recipes' AND index_reference_name='recipe_id' AND index_reference_id=$get_recipe_id";
		$result_exists = mysqli_query($link, $query_exists);
		$row_exists = mysqli_fetch_row($result_exists);
		list($get_index_id) = $row_exists;
		if($get_index_id != ""){
			$datetime = date("Y-m-d H:i:s");
			$datetime_saying = date("j. M Y H:i");

			$inp_index_keywords_mysql = quote_smart($link, $inp_index_keywords);

			$result = mysqli_query($link, "UPDATE $t_search_engine_index SET 
							index_keywords=$inp_index_keywords_mysql,
							index_updated_datetime='$datetime',
							index_updated_datetime_print='$datetime_saying'
							 WHERE index_id=$get_index_id") or die(mysqli_error($link));
		}

		// Header
		$url = "edit_recipe_tags.php?recipe_id=$recipe_id&l=$l&ft=success&fm=changes_saved";
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
				<li><a href=\"edit_recipe_categorization.php?recipe_id=$recipe_id&amp;l=$l\">$l_categorization</a></li>
				<li><a href=\"edit_recipe_image.php?recipe_id=$recipe_id&amp;l=$l\">$l_image</a></li>
				<li><a href=\"edit_recipe_video.php?recipe_id=$recipe_id&amp;l=$l\">$l_video</a></li>
				<li><a href=\"edit_recipe_tags.php?recipe_id=$recipe_id&amp;l=$l\" class=\"active\">$l_tags</a></li>
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
			<a href=\"edit_recipe_tags.php?recipe_id=$recipe_id&amp;l=$l\">$l_tags</a>
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
				\$('[name=\"inp_tag_a\"]').focus();
			});
		</script>
		<!-- //Focus -->

		<form method=\"post\" action=\"edit_recipe_tags.php?recipe_id=$recipe_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
	

		";
				// Fetch tags
				$y = 1;
				$query = "SELECT tag_id, tag_title FROM $t_recipes_tags WHERE tag_recipe_id=$get_recipe_id ORDER BY tag_id ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_tag_id, $get_tag_title) = $row;
				
					if($y == "1"){
						$name = "inp_tag_a";
					}
					elseif($y == "2"){
						$name = "inp_tag_b";
					}
					elseif($y == "3"){
						$name = "inp_tag_c";
					}
					echo"
					<p><b>$l_tag $y:</b><br />
					<input type=\"text\" name=\"$name\" value=\"$get_tag_title\" size=\"20\" /></p>
					";
					$y++;
				}
				
				
				if($y == 1){
					echo"
					<p><b>$l_tag 1:</b><br />
					<input type=\"text\" name=\"inp_tag_a\" value=\"\" size=\"20\" /></p>
					
					<p><b>$l_tag 2:</b><br />
					<input type=\"text\" name=\"inp_tag_b\" value=\"\" size=\"20\" /></p>
					
					<p><b>$l_tag 3:</b><br />
					<input type=\"text\" name=\"inp_tag_c\" value=\"\" size=\"20\" /></p>
					";

				}
				elseif($y == 2){
					echo"
					
					<p><b>$l_tag 2:</b><br />
					<input type=\"text\" name=\"inp_tag_b\" value=\"\" size=\"20\" /></p>
					
					<p><b>$l_tag 3:</b><br />
					<input type=\"text\" name=\"inp_tag_c\" value=\"\" size=\"20\" /></p>
					";

				}
				elseif($y == 3){
					echo"
					
					<p><b>$l_tag 3:</b><br />
					<input type=\"text\" name=\"inp_tag_c\" value=\"\" size=\"20\" /></p>
					";

				}
				echo"


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