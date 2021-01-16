<?php 
/**
*
* File: recipes/edit_recipe_ingredients.php
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
if(isset($_GET['group_id'])){
	$group_id = $_GET['group_id'];
	$group_id = output_html($group_id);
}
else{
	$group_id = "";
}

if(isset($_GET['item_id'])){
	$item_id = $_GET['item_id'];
	$item_id = output_html($item_id);
}
else{
	$item_id = "";
}
$tabindex = 0;
$l_mysql = quote_smart($link, $l);



/*- Get recipe ------------------------------------------------------------------------- */
// Select
$recipe_id_mysql = quote_smart($link, $recipe_id);
$query = "SELECT recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_country, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb_278x156, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_comments, recipe_user_ip, recipe_notes, recipe_password, recipe_last_viewed, recipe_age_restriction FROM $t_recipes WHERE recipe_id=$recipe_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_recipe_id, $get_recipe_user_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_language, $get_recipe_country, $get_recipe_introduction, $get_recipe_directions, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb_278x156, $get_recipe_video, $get_recipe_date, $get_recipe_time, $get_recipe_cusine_id, $get_recipe_season_id, $get_recipe_occasion_id, $get_recipe_marked_as_spam, $get_recipe_unique_hits, $get_recipe_unique_hits_ip_block, $get_recipe_comments, $get_recipe_user_ip, $get_recipe_notes, $get_recipe_password, $get_recipe_last_viewed, $get_recipe_age_restriction) = $row;

// Translations
include("$root/_admin/_translations/site/$l/recipes/ts_edit_recipe.php");
include("$root/_admin/_translations/site/$l/recipes/ts_submit_recipe_step_2_group_and_elements.php");

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
	if(isset($_SESSION['user_id'])){
		// Get my user
		$my_user_id = $_SESSION['user_id'];
		$my_user_id = output_html($my_user_id);
		$my_user_id_mysql = quote_smart($link, $my_user_id);
		$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_user_id, $get_user_email, $get_user_name, $get_user_alias, $get_user_rank) = $row;

		// Access to recipe edit
		if($get_recipe_user_id == "$my_user_id" OR $get_user_rank == "admin"){


	// Get numbers
	$query = "SELECT number_id, number_recipe_id, number_hundred_calories, number_hundred_proteins, number_hundred_fat, number_hundred_fat_of_which_saturated_fatty_acids, number_hundred_carbs, number_hundred_carbs_of_which_dietary_fiber, number_hundred_carbs_of_which_sugars, number_hundred_salt, number_hundred_sodium, number_serving_calories, number_serving_proteins, number_serving_fat, number_serving_fat_of_which_saturated_fatty_acids, number_serving_carbs, number_serving_carbs_of_which_dietary_fiber, number_serving_carbs_of_which_sugars, number_serving_salt, number_serving_sodium, number_total_weight, number_total_calories, number_total_proteins, number_total_fat, number_total_fat_of_which_saturated_fatty_acids, number_total_carbs, number_total_carbs_of_which_dietary_fiber, number_total_carbs_of_which_sugars, number_total_salt, number_total_sodium, number_servings FROM $t_recipes_numbers WHERE number_recipe_id=$recipe_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_number_id, $get_number_recipe_id, $get_number_hundred_calories, $get_number_hundred_proteins, $get_number_hundred_fat, $get_number_hundred_fat_of_which_saturated_fatty_acids, $get_number_hundred_carbs, $get_number_hundred_carbs_of_which_dietary_fiber, $get_number_hundred_carbs_of_which_sugars, $get_number_hundred_salt, $get_number_hundred_sodium, $get_number_serving_calories, $get_number_serving_proteins, $get_number_serving_fat, $get_number_serving_fat_of_which_saturated_fatty_acids, $get_number_serving_carbs, $get_number_serving_carbs_of_which_dietary_fiber, $get_number_serving_carbs_of_which_sugars, $get_number_serving_salt, $get_number_serving_sodium, $get_number_total_weight, $get_number_total_calories, $get_number_total_proteins, $get_number_total_fat, $get_number_total_fat_of_which_saturated_fatty_acids, $get_number_total_carbs, $get_number_total_carbs_of_which_dietary_fiber, $get_number_total_carbs_of_which_sugars, $get_number_total_salt, $get_number_total_sodium, $get_number_servings) = $row;
	if($get_number_id == ""){
		mysqli_query($link, "INSERT INTO $t_recipes_numbers
		(number_id, number_recipe_id, number_hundred_calories, number_hundred_proteins, number_hundred_fat, number_hundred_carbs, number_serving_calories, number_serving_proteins, number_serving_fat, number_serving_carbs, number_total_weight, number_total_calories, number_total_proteins, number_total_fat, number_total_carbs, number_servings) 
		VALUES 
		(NULL, '$get_recipe_id', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '4')")
		or die(mysqli_error($link));
	}

	if($action == ""){
		echo"
		<h1>$get_recipe_title</h1>


		<!-- You are here -->
			<p>
			<b>$l_you_are_here:</b><br />
			<a href=\"index.php?l=$l\">$l_recipes</a>
			&gt;
			<a href=\"my_recipes.php?l=$l#recipe_id=$recipe_id\">$l_my_recipes</a>
			&gt;
			<a href=\"view_recipe.php?recipe_id=$recipe_id&amp;l=$l\">$get_recipe_title</a>
			&gt;
			<a href=\"edit_recipe_ingredients.php?recipe_id=$recipe_id&amp;l=$l\">$l_ingredients</a>
			</p>
		<!-- //You are here -->

		<!-- Menu -->
			<div class=\"tabs\">
			<ul>
				<li><a href=\"edit_recipe.php?recipe_id=$recipe_id&amp;l=$l\">$l_general</a></li>
				<li><a href=\"edit_recipe_ingredients.php?recipe_id=$recipe_id&amp;l=$l\" class=\"active\">$l_ingredients</a></li>
				<li><a href=\"edit_recipe_categorization.php?recipe_id=$recipe_id&amp;l=$l\">$l_categorization</a></li>
				<li><a href=\"edit_recipe_image.php?recipe_id=$recipe_id&amp;l=$l\">$l_image</a></li>
				<li><a href=\"edit_recipe_video.php?recipe_id=$recipe_id&amp;l=$l\">$l_video</a></li>
				<li><a href=\"edit_recipe_tags.php?recipe_id=$recipe_id&amp;l=$l\">$l_tags</a></li>
				<li><a href=\"edit_recipe_links.php?recipe_id=$recipe_id&amp;l=$l\">$l_links</a></li>
			</ul>
			</div><p>&nbsp;</p>
		<!-- //Menu -->

		<!-- Feedback -->
			";
			if($ft != ""){
				if($fm == "changes_saved"){
					$fm = "$l_changes_saved";
				}
				elseif($fm == "group_deleted"){
					$fm = "$l_group_deleted";
				}
				elseif($fm == "item_deleted"){
					$fm = "$l_item_deleted";
				}
				else{
					$fm = ucfirst($fm);
				}
				echo"<div class=\"$ft\"><span>$fm</span></div>";
			}
			echo"	
		<!-- //Feedback -->


		<!-- Groups -->
			";

			$query_groups = "SELECT group_id, group_title FROM $t_recipes_groups WHERE group_recipe_id=$get_recipe_id";
			$result_groups = mysqli_query($link, $query_groups);
			while($row_groups = mysqli_fetch_row($result_groups)) {
				list($get_group_id, $get_group_title) = $row_groups;
				echo"
				<table>
				 <tr>
				  <td style=\"padding-right: 10px;\">
					<h2 style=\"padding: 10px 0px 0px 0px;margin: 0;\">$get_group_title</h2>
				  </td>
				  <td>
					<p style=\"padding: 15px 0px 0px 0px;margin: 0;\">
					<a href=\"edit_recipe_ingredients.php?action=add_items&amp;recipe_id=$get_recipe_id&amp;group_id=$get_group_id&amp;l=$l\">$l_add_ingredient</a>
					&middot;
					<a href=\"edit_recipe_ingredients.php?action=edit_group&amp;recipe_id=$recipe_id&amp;group_id=$get_group_id&amp;l=$l\" class=\"grey\">$l_edit</a>
					&middot;
					<a href=\"edit_recipe_ingredients.php?action=delete_group&amp;recipe_id=$recipe_id&amp;group_id=$get_group_id&amp;l=$l\" class=\"grey\">$l_delete</a>
					</p>
				  </td>
				 </tr>
				</table>



				<div class=\"clear\"></div>

				<ul style=\"padding: 6px 0px 20px 35px;margin: 0;\">
				";

				$query_items = "SELECT item_id, item_amount, item_measurement, item_grocery FROM $t_recipes_items WHERE item_group_id=$get_group_id";
				$result_items = mysqli_query($link, $query_items);
				$row_cnt = mysqli_num_rows($result_items);
				while($row_items = mysqli_fetch_row($result_items)) {
					list($get_item_id, $get_item_amount, $get_item_measurement, $get_item_grocery) = $row_items;
					echo"					";
					echo"<li><span>$get_item_amount $get_item_measurement $get_item_grocery</span>
					<span>
					<a href=\"edit_recipe_ingredients.php?action=edit_item&amp;recipe_id=$recipe_id&amp;group_id=$get_group_id&amp;item_id=$get_item_id&amp;l=$l\" class=\"grey\">$l_edit</a>
					&middot;
					<a href=\"edit_recipe_ingredients.php?action=delete_item&amp;recipe_id=$recipe_id&amp;group_id=$get_group_id&amp;item_id=$get_item_id&amp;&amp;l=$l\" class=\"grey\">$l_delete</a>
					</span></li>\n";
				} // items



				echo"

				</ul>

				";

			} // groups



			echo"

		<!-- //Groups -->

		<!-- Buttons -->
			<p>
			<a href=\"edit_recipe_ingredients.php?recipe_id=$get_recipe_id&amp;action=add_group&amp;l=$l\" class=\"btn btn_default\">$l_add_another_group</a>
			<a href=\"my_recipes.php?l=$l#recipe$recipe_id\" class=\"btn btn_default\">$l_my_recipes</a>
			<a href=\"view_recipe.php?recipe_id=$recipe_id&amp;l=$l\" class=\"btn btn_default\">$l_view_recipe</a>
			</p>
		<!-- //Buttons -->

	



		";

	} 

	elseif($action == "add_group"){



		if($process == 1){

			$inp_group_title = $_POST['inp_group_title'];
			$inp_group_title = output_html($inp_group_title);
			$inp_group_title_mysql = quote_smart($link, $inp_group_title);

			if(empty($inp_group_title)){
				$ft = "error";
				$fm = "group_title_cant_be_empty";
				$url = "edit_recipe_ingredients.php?recipe_id=$get_recipe_id&l=$l&ft=$ft&fm=$fm";
				header("Location: $url");
				exit;
			}

			

			// Does that group already exists?
			$query = "SELECT group_id, group_recipe_id, group_title FROM $t_recipes_groups WHERE group_recipe_id=$get_recipe_id AND group_title=$inp_group_title_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_group_id, $get_group_recipe_id, $get_group_title) = $row;

			if($get_group_id != ""){
				$ft = "error";
				$fm = "you_already_have_a_group_with_that_name";
				$url = "edit_recipe_ingredients.php?recipe_id=$get_recipe_id&l=$l&ft=$ft&fm=$fm";
				header("Location: $url");
				exit;
			}

			// Insert
			mysqli_query($link, "INSERT INTO $t_recipes_groups
			(group_id, group_recipe_id, group_title) 
			VALUES 
			(NULL, '$get_recipe_id', $inp_group_title_mysql)")
			or die(mysqli_error($link));

			// Get group ID
			$query = "SELECT group_id, group_recipe_id, group_title FROM $t_recipes_groups WHERE group_recipe_id=$get_recipe_id AND group_title=$inp_group_title_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_group_id, $get_group_recipe_id, $get_group_title) = $row;


			// Header
			$url = "edit_recipe_ingredients.php?recipe_id=$get_recipe_id&action=add_items&group_id=$get_group_id&l=$l";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>$l_add_another_group</h1>



		<!-- Menu -->
		<div class=\"tabs\">
			<ul>
				<li><a href=\"edit_recipe.php?recipe_id=$recipe_id&amp;l=$l\">$l_general</a>
				<li><a href=\"edit_recipe_ingredients.php?recipe_id=$recipe_id&amp;l=$l\" class=\"active\">$l_ingredients</a>
				<li><a href=\"edit_recipe_categorization.php?recipe_id=$recipe_id&amp;l=$l\">$l_categorization</a>
				<li><a href=\"edit_recipe_image.php?recipe_id=$recipe_id&amp;l=$l\">$l_image</a>
				<li><a href=\"edit_recipe_video.php?recipe_id=$recipe_id&amp;l=$l\">$l_video</a>
				<li><a href=\"edit_recipe_tags.php?recipe_id=$recipe_id&amp;l=$l\">$l_tags</a></li>
				<li><a href=\"edit_recipe_links.php?recipe_id=$recipe_id&amp;l=$l\">$l_links</a></li>
			</ul>

		</div><p>&nbsp;</p>

		<!-- //Menu -->





		<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_group_title\"]').focus();
			});
			</script>
		<!-- //Focus -->



		<!-- Feedback -->
			";
			if($ft != ""){
				if($fm == "changes_saved"){
					$fm = "$l_changes_saved";
				}
				elseif($fm == "group_title_cant_be_empty"){
					$fm = "$l_group_title_cant_be_empty";
				}
				elseif($fm == "you_already_have_a_group_with_that_name"){
					$fm = "$l_you_already_have_a_group_with_that_name";
				}
				else{
					$fm = ucfirst($fm);
				}
				echo"<div class=\"$ft\"><span>$fm</span></div>";
			}
			echo"	
		<!-- //Feedback -->



		<!-- Add group -->

			<form method=\"post\" action=\"edit_recipe_ingredients.php?action=add_group&amp;recipe_id=$get_recipe_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p><b>$l_ingredients_title:</b>
			<input type=\"text\" name=\"inp_group_title\" size=\"30\" value=\"\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
			<input type=\"submit\" value=\"$l_create\" class=\"btn\" />
			</p>
			</form>
		<!-- //Add group -->



		<!-- Buttons -->
			<p style=\"margin-top: 20px;\">
			<a href=\"my_recipes.php?l=$l#recipe$recipe_id\" class=\"btn btn_default\">$l_my_recipes</a>
			<a href=\"view_recipe.php?recipe_id=$recipe_id&amp;l=$l\" class=\"btn btn_default\">$l_view_recipe</a>
			</p>
		<!-- //Buttons -->
		";

	}
	elseif($action == "add_items"){

		// Get group
		$group_id_mysql = quote_smart($link, $group_id);
		$query = "SELECT group_id, group_recipe_id, group_title FROM $t_recipes_groups WHERE group_id=$group_id_mysql AND group_recipe_id=$get_recipe_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_group_id, $get_group_recipe_id, $get_group_title) = $row;

		if($get_group_id == ""){
			echo"
			<h1>Server error</h1>

			<p>
			Group not found.
			</p>
			";
		}
		else{
			if($process == "1"){
				$inp_item_amount = $_POST['inp_item_amount'];
				$inp_item_amount = output_html($inp_item_amount);
				$inp_item_amount = str_replace(",", ".", $inp_item_amount);
				$inp_item_amount_mysql = quote_smart($link, $inp_item_amount);
				if(empty($inp_item_amount)){
					$ft = "error";
					$fm = "amound_cant_be_empty";
				}
				else{
					if(!(is_numeric($inp_item_amount))){
						// Do we have math? Example 1/8 ts
						$check_for_fraction = explode("/", $inp_item_amount);

						if(isset($check_for_fraction[0]) && isset($check_for_fraction[1])){
							if(is_numeric($check_for_fraction[0]) && is_numeric($check_for_fraction[1])){
								$inp_item_amount = $check_for_fraction[0] / $check_for_fraction[1];
							}
							else{
								$ft = "error";
								$fm = "amound_has_to_be_a_number";
							}
						}
						else{
							$ft = "error";
							$fm = "amound_has_to_be_a_number";
						}
					}
				}

				$inp_item_measurement = $_POST['inp_item_measurement'];
				$inp_item_measurement = output_html($inp_item_measurement);
				$inp_item_measurement = str_replace(",", ".", $inp_item_measurement);
				$inp_item_measurement_mysql = quote_smart($link, $inp_item_measurement);
				if(empty($inp_item_measurement)){
					$ft = "error";
					$fm = "measurement_cant_be_empty";
				}

				$inp_item_grocery = $_POST['inp_item_grocery'];
				$inp_item_grocery = output_html($inp_item_grocery);
				$inp_item_grocery_mysql = quote_smart($link, $inp_item_grocery);
				if(empty($inp_item_grocery)){
					$ft = "error";
					$fm = "grocery_cant_be_empty";
				}

				$inp_item_food_id = $_POST['inp_item_food_id'];
				$inp_item_food_id = output_html($inp_item_food_id);
				if($inp_item_food_id == ""){
					$inp_item_food_id = "0";
				}
				$inp_item_food_id_mysql = quote_smart($link, $inp_item_food_id);

				// Calories per hundred
				if(isset($_POST['inp_item_calories_per_hundred'])){
					$inp_item_calories_per_hundred = $_POST['inp_item_calories_per_hundred'];
				}
				else{
					$inp_item_calories_per_hundred = "0";
				}
				$inp_item_calories_per_hundred = output_html($inp_item_calories_per_hundred);
				$inp_item_calories_per_hundred = str_replace(",", ".", $inp_item_calories_per_hundred);
				if(empty($inp_item_calories_per_hundred)){
					$inp_item_calories_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_calories_per_hundred))){
						$ft = "error";
						$fm = "calories_have_to_be_a_number";
					}
				}
				$inp_item_calories_per_hundred = round($inp_item_calories_per_hundred, 0);
				$inp_item_calories_per_hundred_mysql = quote_smart($link, $inp_item_calories_per_hundred);


				$inp_item_calories_calculated = $_POST['inp_item_calories_calculated'];
				$inp_item_calories_calculated = output_html($inp_item_calories_calculated);
				$inp_item_calories_calculated = str_replace(",", ".", $inp_item_calories_calculated);
				if(empty($inp_item_calories_calculated)){
					$inp_item_calories_calculated = "0";
				}
				else{
					if(!(is_numeric($inp_item_calories_calculated))){
						$ft = "error";
						$fm = "calories_have_to_be_a_number";
					}
				}
				$inp_item_calories_calculated = round($inp_item_calories_calculated, 0);
				$inp_item_calories_calculated_mysql = quote_smart($link, $inp_item_calories_calculated);

				// Fat per hundred
				if(isset($_POST['inp_item_fat_per_hundred'])){
					$inp_item_fat_per_hundred = $_POST['inp_item_fat_per_hundred'];
				}
				else{
					$inp_item_fat_per_hundred = "0";
				}
				$inp_item_fat_per_hundred = output_html($inp_item_fat_per_hundred);
				$inp_item_fat_per_hundred = str_replace(",", ".", $inp_item_fat_per_hundred);
				if(empty($inp_item_fat_per_hundred)){
					$inp_item_fat_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_calories_per_hundred))){
						$ft = "error";
						$fm = "fat_have_to_be_a_number";
					}
				}
				$inp_item_fat_per_hundred = round($inp_item_fat_per_hundred, 0);
				$inp_item_fat_per_hundred_mysql = quote_smart($link, $inp_item_fat_per_hundred);

				$inp_item_fat_calculated = $_POST['inp_item_fat_calculated'];
				$inp_item_fat_calculated = output_html($inp_item_fat_calculated);
				$inp_item_fat_calculated = str_replace(",", ".", $inp_item_fat_calculated);
				if(empty($inp_item_fat_calculated)){
					$inp_item_fat_calculated = "0";
				}
				else{
					if(!(is_numeric($inp_item_calories_calculated))){
						$ft = "error";
						$fm = "fat_have_to_be_a_number";
					}
				}
				$inp_item_fat_calculated = round($inp_item_fat_calculated, 0);
				$inp_item_fat_calculated_mysql = quote_smart($link, $inp_item_fat_calculated);


				// Fat saturated fatty acids
				if(isset($_POST['inp_item_fat_per_hundred'])){
					$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = $_POST['inp_item_fat_of_which_saturated_fatty_acids_per_hundred'];
				}
				else{
					$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = "0";
				}
				$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = output_html($inp_item_fat_of_which_saturated_fatty_acids_per_hundred);
				$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = str_replace(",", ".", $inp_item_fat_of_which_saturated_fatty_acids_per_hundred);
				if(empty($inp_item_fat_of_which_saturated_fatty_acids_per_hundred)){
					$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_fat_of_which_saturated_fatty_acids_per_hundred))){
						$ft = "error";
						$fm = "fat_of_which_saturated_fatty_acids_per_hundred_have_to_be_a_number";
					}
				}
				$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = round($inp_item_fat_of_which_saturated_fatty_acids_per_hundred, 0);
				$inp_item_fat_of_which_saturated_fatty_acids_per_hundred_mysql = quote_smart($link, $inp_item_fat_of_which_saturated_fatty_acids_per_hundred);

				// Fat saturated fatty acids calculated
				$inp_item_fat_of_which_saturated_fatty_acids_calculated = $_POST['inp_item_fat_of_which_saturated_fatty_acids_calculated'];
				$inp_item_fat_of_which_saturated_fatty_acids_calculated = output_html($inp_item_fat_of_which_saturated_fatty_acids_calculated);
				$inp_item_fat_of_which_saturated_fatty_acids_calculated = str_replace(",", ".", $inp_item_fat_of_which_saturated_fatty_acids_calculated);
				if(empty($inp_item_fat_of_which_saturated_fatty_acids_calculated)){
					$inp_item_fat_of_which_saturated_fatty_acids_calculated = "0";
				}
				else{
					if(!(is_numeric($inp_item_fat_of_which_saturated_fatty_acids_calculated))){
						$ft = "error";
						$fm = "fat_of_which_saturated_fatty_acids_calculated_have_to_be_a_number";
					}
				}
				$inp_item_fat_of_which_saturated_fatty_acids_calculated = round($inp_item_fat_of_which_saturated_fatty_acids_calculated, 0);
				$inp_item_fat_of_which_saturated_fatty_acids_calculated_mysql = quote_smart($link, $inp_item_fat_of_which_saturated_fatty_acids_calculated);

				// Carbs per hundred
				if(isset($_POST['inp_item_carbs_per_hundred'])){
					$inp_item_carbs_per_hundred = $_POST['inp_item_carbs_per_hundred'];
				}
				else{
					$inp_item_carbs_per_hundred = "0";
				}				
				$inp_item_carbs_per_hundred = output_html($inp_item_carbs_per_hundred);
				$inp_item_carbs_per_hundred = str_replace(",", ".", $inp_item_carbs_per_hundred);
				if(empty($inp_item_carbs_per_hundred)){
					$inp_item_carbs_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_calories_per_hundred))){
						$ft = "error";
						$fm = "calories_have_to_be_a_number";
					}
				}
				$inp_item_carbs_per_hundred = round($inp_item_carbs_per_hundred, 0);
				$inp_item_carbs_per_hundred_mysql = quote_smart($link, $inp_item_carbs_per_hundred);

				// Carbs calculated
				$inp_item_carbs_calculated = $_POST['inp_item_carbs_calculated'];
				$inp_item_carbs_calculated = output_html($inp_item_carbs_calculated);
				$inp_item_carbs_calculated = str_replace(",", ".", $inp_item_carbs_calculated);
				if(empty($inp_item_carbs_calculated)){
					$inp_item_carbs_calculated = "0";
				}
				else{
					if(!(is_numeric($inp_item_calories_calculated))){
						$ft = "error";
						$fm = "calories_have_to_be_a_number";
					}
				}
				$inp_item_carbs_calculated = round($inp_item_carbs_calculated, 0);
				$inp_item_carbs_calculated_mysql = quote_smart($link, $inp_item_carbs_calculated);


				// Fiber per hundred
				if(isset($_POST['inp_item_carbs_of_which_dietary_fiber_per_hundred'])){
					$inp_item_carbs_of_which_dietary_fiber_per_hundred = $_POST['inp_item_carbs_of_which_dietary_fiber_per_hundred'];
				}
				else{
					$inp_item_carbs_of_which_dietary_fiber_per_hundred = "0";
				}
				$inp_item_carbs_of_which_dietary_fiber_per_hundred = output_html($inp_item_carbs_of_which_dietary_fiber_per_hundred);
				$inp_item_carbs_of_which_dietary_fiber_per_hundred = str_replace(",", ".", $inp_item_carbs_of_which_dietary_fiber_per_hundred);
				if(empty($inp_item_carbs_of_which_dietary_fiber_per_hundred)){
					$inp_item_carbs_of_which_dietary_fiber_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_carbs_of_which_dietary_fiber_per_hundred))){
						$ft = "error";
						$fm = "carbs_of_which_sugars_per_hundred_have_to_be_a_number";
					}
				}
				$inp_item_carbs_of_which_dietary_fiber_per_hundred = round($inp_item_carbs_of_which_dietary_fiber_per_hundred, 0);
				$inp_item_carbs_of_which_dietary_fiber_per_hundred_mysql = quote_smart($link, $inp_item_carbs_of_which_dietary_fiber_per_hundred);

				// Fiber calcualted
				if(isset($_POST['inp_item_carbs_of_which_dietary_fiber_calculated'])){
					$inp_item_carbs_of_which_dietary_fiber_calculated = $_POST['inp_item_carbs_of_which_dietary_fiber_calculated'];
				}
				else{
					$inp_item_carbs_of_which_dietary_fiber_calculated = "0";
				}
				$inp_item_carbs_of_which_dietary_fiber_calculated = output_html($inp_item_carbs_of_which_dietary_fiber_calculated);
				$inp_item_carbs_of_which_dietary_fiber_calculated = str_replace(",", ".", $inp_item_carbs_of_which_dietary_fiber_calculated);
				if(empty($inp_item_carbs_of_which_dietary_fiber_calculated)){
					$inp_item_carbs_of_which_dietary_fiber_calculated = "0";
				}
				else{
					if(!(is_numeric($inp_item_carbs_of_which_dietary_fiber_calculated))){
						$ft = "error";
						$fm = "carbs_of_which_sugars_per_hundred_have_to_be_a_number";
					}
				}
				$inp_item_carbs_of_which_dietary_fiber_calculated = round($inp_item_carbs_of_which_dietary_fiber_calculated, 0);
				$inp_item_carbs_of_which_dietary_fiber_calculated_mysql = quote_smart($link, $inp_item_carbs_of_which_dietary_fiber_calculated);



				// Carbs of which sugars
				if(isset($_POST['inp_item_carbs_of_which_sugars_per_hundred'])){
					$inp_item_carbs_of_which_sugars_per_hundred = $_POST['inp_item_carbs_of_which_sugars_per_hundred'];
				}
				else{
					$inp_item_carbs_of_which_sugars_per_hundred = "0";
				}
				$inp_item_carbs_of_which_sugars_per_hundred = output_html($inp_item_carbs_of_which_sugars_per_hundred);
				$inp_item_carbs_of_which_sugars_per_hundred = str_replace(",", ".", $inp_item_carbs_of_which_sugars_per_hundred);
				if(empty($inp_item_carbs_of_which_sugars_per_hundred)){
					$inp_item_carbs_of_which_sugars_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_carbs_of_which_sugars_per_hundred))){
						$ft = "error";
						$fm = "carbs_of_which_sugars_per_hundred_have_to_be_a_number";
					}
				}
				$inp_item_carbs_of_which_sugars_per_hundred = round($inp_item_carbs_of_which_sugars_per_hundred, 0);
				$inp_item_carbs_of_which_sugars_per_hundred_mysql = quote_smart($link, $inp_item_carbs_of_which_sugars_per_hundred);

				// Carbs of which sugars calcualted
				$inp_item_carbs_of_which_sugars_calculated = $_POST['inp_item_carbs_of_which_sugars_calculated'];
				$inp_item_carbs_of_which_sugars_calculated = output_html($inp_item_carbs_of_which_sugars_calculated);
				$inp_item_carbs_of_which_sugars_calculated = str_replace(",", ".", $inp_item_carbs_of_which_sugars_calculated);
				if(empty($inp_item_carbs_of_which_sugars_calculated)){
					$inp_item_carbs_of_which_sugars_calculated = "0";
				}
				else{
					if(!(is_numeric($inp_item_carbs_of_which_sugars_calculated))){
						$ft = "error";
						$fm = "carbs_of_which_sugars_calculated_have_to_be_a_number";
					}
				}
				$inp_item_carbs_of_which_sugars_calculated = round($inp_item_carbs_of_which_sugars_calculated, 0);
				$inp_item_carbs_of_which_sugars_calculated_mysql = quote_smart($link, $inp_item_carbs_of_which_sugars_calculated);


				// Proteins
				if(isset($_POST['inp_item_proteins_per_hundred'])){
					$inp_item_proteins_per_hundred = $_POST['inp_item_proteins_per_hundred'];
				}
				else{
					$inp_item_proteins_per_hundred = "0";
				}
				$inp_item_proteins_per_hundred = output_html($inp_item_proteins_per_hundred);
				$inp_item_proteins_per_hundred = str_replace(",", ".", $inp_item_proteins_per_hundred);
				if(empty($inp_item_proteins_per_hundred)){
					$inp_item_proteins_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_proteins_per_hundred))){
						$ft = "error";
						$fm = "proteins_have_to_be_a_number";
					}
				}
				$inp_item_proteins_per_hundred = round($inp_item_proteins_per_hundred, 0);
				$inp_item_proteins_per_hundred_mysql = quote_smart($link, $inp_item_proteins_per_hundred);

				// Proteins calculated
				$inp_item_proteins_calculated = $_POST['inp_item_proteins_calculated'];
				$inp_item_proteins_calculated = output_html($inp_item_proteins_calculated);
				$inp_item_proteins_calculated = str_replace(",", ".", $inp_item_proteins_calculated);
				if(empty($inp_item_proteins_calculated)){
					$inp_item_proteins_calculated = "0";
				}
				else{
					if(!(is_numeric($inp_item_proteins_calculated))){
						$ft = "error";
						$fm = "proteins_have_to_be_a_number";
					}
				}
				$inp_item_proteins_calculated = round($inp_item_proteins_calculated, 0);
				$inp_item_proteins_calculated_mysql = quote_smart($link, $inp_item_proteins_calculated);

				// Salt per hundred
				if(isset($_POST['inp_item_salt_per_hundred'])){
					$inp_item_salt_per_hundred = $_POST['inp_item_salt_per_hundred'];
				}
				else{
					$inp_item_salt_per_hundred = "0";
				}
				$inp_item_salt_per_hundred = output_html($inp_item_salt_per_hundred);
				$inp_item_salt_per_hundred = str_replace(",", ".", $inp_item_salt_per_hundred);
				if(empty($inp_item_salt_per_hundred)){
					$inp_item_salt_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_salt_per_hundred))){
						$ft = "error";
						$fm = "salt_have_to_be_a_number";
					}
				}
				$inp_item_salt_per_hundred = round($inp_item_salt_per_hundred, 0);
				$inp_item_salt_per_hundred_mysql = quote_smart($link, $inp_item_salt_per_hundred);

				// Sodium per hundred
				if($inp_item_salt_per_hundred != "0"){
					$inp_item_sodium_per_hundred = ($inp_item_salt_per_hundred*40)/100; // 40 % of salt
					$inp_item_sodium_per_hundred = $inp_item_sodium_per_hundred/1000; // mg
				}
				else{
					$inp_item_sodium_per_hundred = 0;
				}
				$inp_item_sodium_per_hundred_mysql = quote_smart($link, $inp_item_sodium_per_hundred);

				// Salt calculated
				if(isset($_POST['inp_item_salt_calculated'])){
					$inp_item_salt_calculated = $_POST['inp_item_salt_calculated'];
				}
				else{
					$inp_item_salt_calculated = 0;
				}
				$inp_item_salt_calculated = output_html($inp_item_salt_calculated);
				$inp_item_salt_calculated = str_replace(",", ".", $inp_item_salt_calculated);
				if(empty($inp_item_salt_calculated)){
					$inp_item_salt_calculated = "0";
				}
				else{
					if(!(is_numeric($inp_item_salt_calculated))){
						$ft = "error";
						$fm = "salt_have_to_be_a_number";
					}
				}
				$inp_item_salt_calculated = round($inp_item_salt_calculated, 0);
				$inp_item_salt_calculated_mysql = quote_smart($link, $inp_item_salt_calculated);


				// Sodium calculated
				if(isset($_POST['inp_item_sodium_calculated'])){
					$inp_item_sodium_calculated = $_POST['inp_item_sodium_calculated'];
					$inp_item_sodium_calculated = output_html($inp_item_sodium_calculated);
					$inp_item_sodium_calculated = str_replace(",", ".", $inp_item_sodium_calculated);
				}
				else{
					$inp_item_sodium_calculated = ($inp_item_salt_calculated*40)/100; // 40 % of salt
					$inp_item_sodium_calculated = $inp_item_sodium_calculated/1000; // mg
				}
				$inp_item_sodium_calculated_mysql = quote_smart($link, $inp_item_sodium_calculated);



				if(isset($fm) && $fm != ""){
					$url = "edit_recipe_ingredients.php?recipe_id=$get_recipe_id&action=add_items&group_id=$get_group_id&l=$l";
					$url = $url . "&ft=$ft&fm=$fm";
					$url = $url . "&amount=$inp_item_amount&measurement=$inp_item_measurement&grocery=$inp_item_grocery&calories=$inp_item_calories_calculated";
					$url = $url . "&proteins=$inp_item_proteins_calculated&fat=$inp_item_fat_calculated&carbs=$inp_item_carbs_calculated";

					header("Location: $url");
					exit;
				}


				// Have I already this item?
				$query = "SELECT item_id FROM $t_recipes_items WHERE item_recipe_id=$get_recipe_id AND item_group_id=$get_group_id AND item_grocery=$inp_item_grocery_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_item_id) = $row;
				if($get_item_id != ""){
					$ft = "error";
					$fm = "you_have_already_added_that_item";

					$url = "edit_recipe_ingredients.php?recipe_id=$get_recipe_id&action=add_items&group_id=$get_group_id&l=$l";
					$url = $url . "&ft=$ft&fm=$fm";
					$url = $url . "&amount=$inp_item_amount&measurement=$inp_item_measurement&grocery=$inp_item_grocery&calories=$inp_item_calories_calculated";
					$url = $url . "&proteins=$inp_item_proteins_calculated&fat=$inp_item_fat_calculated&carbs=$inp_item_carbs_calculated";

					header("Location: $url");
					exit;
				}


				// Insert
				mysqli_query($link, "INSERT INTO $t_recipes_items
				(item_id, item_recipe_id, item_group_id, item_amount, item_measurement, item_grocery, item_grocery_explanation, item_food_id, 
				item_calories_per_hundred, item_fat_per_hundred, item_fat_of_which_saturated_fatty_acids_per_hundred, item_carbs_per_hundred, item_carbs_of_which_dietary_fiber_hundred, item_carbs_of_which_sugars_per_hundred, item_proteins_per_hundred, item_salt_per_hundred, item_sodium_per_hundred, 
				item_calories_calculated, item_fat_calculated, item_fat_of_which_saturated_fatty_acids_calculated, item_carbs_calculated, item_carbs_of_which_dietary_fiber_calculated, item_carbs_of_which_sugars_calculated, item_proteins_calculated, item_salt_calculated, item_sodium_calculated) 
				VALUES 
				(NULL, '$get_recipe_id', '$get_group_id', $inp_item_amount_mysql, $inp_item_measurement_mysql, $inp_item_grocery_mysql, '', $inp_item_food_id_mysql, 
				$inp_item_calories_per_hundred_mysql, $inp_item_fat_per_hundred_mysql, $inp_item_fat_of_which_saturated_fatty_acids_per_hundred_mysql, $inp_item_carbs_per_hundred_mysql, $inp_item_carbs_of_which_dietary_fiber_per_hundred_mysql, $inp_item_carbs_of_which_sugars_per_hundred_mysql, $inp_item_proteins_per_hundred_mysql, $inp_item_salt_per_hundred_mysql, $inp_item_sodium_per_hundred_mysql,
				$inp_item_calories_calculated_mysql, $inp_item_fat_calculated_mysql, $inp_item_fat_of_which_saturated_fatty_acids_calculated_mysql, $inp_item_carbs_calculated_mysql, $inp_item_carbs_of_which_dietary_fiber_calculated_mysql, $inp_item_carbs_of_which_sugars_calculated_mysql, $inp_item_proteins_calculated_mysql, $inp_item_salt_calculated_mysql, $inp_item_sodium_calculated_mysql)")
				or die(mysqli_error($link));
			

				// Calculating total numbers


				$inp_number_hundred_calories = 0;
				$inp_number_hundred_proteins = 0;
				$inp_number_hundred_fat = 0;
				$inp_number_hundred_fat_of_which_saturated_fatty_acids = 0;
				$inp_number_hundred_carbs = 0;
				$inp_number_hundred_carbs_of_which_dietary_fiber = 0;
				$inp_number_hundred_carbs_of_which_sugars = 0;
				$inp_number_hundred_salt = 0;
				$inp_number_hundred_sodium = 0;
					
				$inp_number_serving_calories = 0;
				$inp_number_serving_proteins = 0;
				$inp_number_serving_fat = 0;
				$inp_number_serving_fat_of_which_saturated_fatty_acids = 0;
				$inp_number_serving_carbs = 0;
				$inp_number_serving_carbs_of_which_dietary_fiber = 0;
				$inp_number_serving_carbs_of_which_sugars = 0;
				$inp_number_serving_salt = 0;
				$inp_number_serving_sodium = 0;
					
				$inp_number_total_weight = 0;

				$inp_number_total_calories 				= 0;
				$inp_number_total_proteins 				= 0;
				$inp_number_total_fat     				= 0;
				$inp_number_total_fat_of_which_saturated_fatty_acids 	= 0;
				$inp_number_total_carbs    				= 0;
				$inp_number_total_carbs_of_which_dietary_fiber 		= 0;
				$inp_number_total_carbs_of_which_sugars 		= 0;
				$inp_number_total_salt 					= 0;
				$inp_number_total_sodium 				= 0;
					
				$query_groups = "SELECT group_id, group_title FROM $t_recipes_groups WHERE group_recipe_id=$get_recipe_id";
				$result_groups = mysqli_query($link, $query_groups);
				while($row_groups = mysqli_fetch_row($result_groups)) {
					list($get_group_id, $get_group_title) = $row_groups;

					$query_items = "SELECT item_id, item_recipe_id, item_group_id, item_amount, item_measurement, item_grocery, item_grocery_explanation, item_food_id, item_calories_per_hundred, item_fat_per_hundred, item_fat_of_which_saturated_fatty_acids_per_hundred, item_carbs_per_hundred, item_carbs_of_which_dietary_fiber_hundred, item_carbs_of_which_sugars_per_hundred, item_proteins_per_hundred, item_salt_per_hundred, item_sodium_per_hundred, item_calories_calculated, item_fat_calculated, item_fat_of_which_saturated_fatty_acids_calculated, item_carbs_calculated, item_carbs_of_which_dietary_fiber_calculated, item_carbs_of_which_sugars_calculated, item_proteins_calculated, item_salt_calculated, item_sodium_calculated FROM $t_recipes_items WHERE item_group_id=$get_group_id";
					$result_items = mysqli_query($link, $query_items);
					$row_cnt = mysqli_num_rows($result_items);
					while($row_items = mysqli_fetch_row($result_items)) {
						list($get_item_id, $get_item_recipe_id, $get_item_group_id, $get_item_amount, $get_item_measurement, $get_item_grocery, $get_item_grocery_explanation, $get_item_food_id, $get_item_calories_per_hundred, $get_item_fat_per_hundred, $get_item_fat_of_which_saturated_fatty_acids_per_hundred, $get_item_carbs_per_hundred, $get_item_carbs_of_which_dietary_fiber_hundred, $get_item_carbs_of_which_sugars_per_hundred, $get_item_proteins_per_hundred, $get_item_salt_per_hundred, $get_item_sodium_per_hundred, $get_item_calories_calculated, $get_item_fat_calculated, $get_item_fat_of_which_saturated_fatty_acids_calculated, $get_item_carbs_calculated, $get_item_carbs_of_which_dietary_fiber_calculated, $get_item_carbs_of_which_sugars_calculated, $get_item_proteins_calculated, $get_item_salt_calculated, $get_item_sodium_calculated) = $row_items;

						$inp_number_hundred_calories 				= $inp_number_hundred_calories+$get_item_calories_per_hundred;
						$inp_number_hundred_proteins 				= $inp_number_hundred_proteins+$get_item_proteins_per_hundred;
						$inp_number_hundred_fat      				= $inp_number_hundred_fat+$get_item_fat_per_hundred;
						$inp_number_hundred_fat_of_which_saturated_fatty_acids 	= $inp_number_hundred_fat_of_which_saturated_fatty_acids+$get_item_fat_of_which_saturated_fatty_acids_per_hundred;
						$inp_number_hundred_carbs    				= $inp_number_hundred_carbs+$get_item_carbs_per_hundred;
						$inp_number_hundred_carbs_of_which_dietary_fiber 	= $inp_number_hundred_carbs_of_which_dietary_fiber+$get_item_carbs_of_which_dietary_fiber_hundred;
						$inp_number_hundred_carbs_of_which_sugars 		= $inp_number_hundred_carbs_of_which_sugars+$get_item_carbs_of_which_sugars_per_hundred;
						$inp_number_hundred_salt 				= $inp_number_hundred_salt+$get_item_salt_per_hundred;
						$inp_number_hundred_sodium 				= $inp_number_hundred_sodium+$get_item_sodium_per_hundred;
					
						$inp_number_total_weight     = $inp_number_total_weight+$get_item_amount;

						$inp_number_total_calories 				= $inp_number_total_calories+$get_item_calories_calculated;
						$inp_number_total_proteins 				= $inp_number_total_proteins+$get_item_proteins_calculated;
						$inp_number_total_fat     				= $inp_number_total_fat+$get_item_fat_calculated;
						$inp_number_total_fat_of_which_saturated_fatty_acids 	= $inp_number_total_fat_of_which_saturated_fatty_acids+$get_item_fat_of_which_saturated_fatty_acids_calculated;
						$inp_number_total_carbs    				= $inp_number_total_carbs+$get_item_carbs_calculated;
						$inp_number_total_carbs_of_which_dietary_fiber 		= $inp_number_total_carbs_of_which_dietary_fiber+$get_item_carbs_of_which_dietary_fiber_calculated;
						$inp_number_total_carbs_of_which_sugars 		= $inp_number_total_carbs_of_which_sugars+$get_item_carbs_of_which_sugars_calculated;
						$inp_number_total_salt 					= $inp_number_total_salt+$get_item_salt_calculated;
						$inp_number_total_sodium				= $inp_number_total_salt+$get_item_sodium_calculated;
	
					} // items
				} // groups
					
				

	
				// Numbers : Per hundred
				$inp_number_hundred_calories_mysql 				= quote_smart($link, $inp_number_hundred_calories);
				$inp_number_hundred_proteins_mysql 				= quote_smart($link, $inp_number_hundred_proteins);
				$inp_number_hundred_fat_mysql      				= quote_smart($link, $inp_number_hundred_fat);
				$inp_number_hundred_fat_of_which_saturated_fatty_acids_mysql 	= quote_smart($link, $inp_number_hundred_fat_of_which_saturated_fatty_acids);
				$inp_number_hundred_carbs_mysql   				= quote_smart($link, $inp_number_hundred_carbs);
				$inp_number_hundred_carbs_of_which_dietary_fiber_mysql 		= quote_smart($link, $inp_number_hundred_carbs_of_which_dietary_fiber);
				$inp_number_hundred_carbs_of_which_sugars_mysql			= quote_smart($link, $inp_number_hundred_carbs_of_which_sugars);
				$inp_number_hundred_salt_mysql					= quote_smart($link, $inp_number_hundred_salt);
				$inp_number_hundred_sodium_mysql				= quote_smart($link, $inp_number_hundred_sodium);
					
				// Numbers : Total 
				$inp_number_total_weight_mysql     = quote_smart($link, $inp_number_total_weight);

				$inp_number_total_calories_mysql 				= quote_smart($link, $inp_number_total_calories);
				$inp_number_total_proteins_mysql 				= quote_smart($link, $inp_number_total_proteins);
				$inp_number_total_fat_mysql      				= quote_smart($link, $inp_number_total_fat);
				$inp_number_total_fat_of_which_saturated_fatty_acids_mysql	= quote_smart($link, $inp_number_total_fat_of_which_saturated_fatty_acids);
				$inp_number_total_carbs_mysql    				= quote_smart($link, $inp_number_total_carbs);
				$inp_number_total_carbs_of_which_dietary_fiber_mysql    	= quote_smart($link, $inp_number_total_carbs_of_which_dietary_fiber);
				$inp_number_total_carbs_of_which_sugars_mysql    		= quote_smart($link, $inp_number_total_carbs_of_which_sugars);
				$inp_number_total_salt_mysql    				= quote_smart($link, $inp_number_total_salt);
				$inp_number_total_sodium_mysql    				= quote_smart($link, $inp_number_total_sodium);

				// Numbers : Per serving
				$inp_number_serving_calories = round($inp_number_total_calories/$get_number_servings);
				$inp_number_serving_calories_mysql = quote_smart($link, $inp_number_serving_calories);

				$inp_number_serving_proteins = round($inp_number_total_proteins/$get_number_servings);
				$inp_number_serving_proteins_mysql = quote_smart($link, $inp_number_serving_proteins);

				$inp_number_serving_fat		= round($inp_number_total_fat/$get_number_servings);
				$inp_number_serving_fat_mysql   = quote_smart($link, $inp_number_serving_fat);

				$inp_number_serving_fat_of_which_saturated_fatty_acids		= round($inp_number_hundred_fat_of_which_saturated_fatty_acids/$get_number_servings);
				$inp_number_serving_fat_of_which_saturated_fatty_acids_mysql 	= quote_smart($link, $inp_number_serving_fat_of_which_saturated_fatty_acids);

				$inp_number_serving_carbs    = round($inp_number_total_carbs/$get_number_servings);
				$inp_number_serving_carbs_mysql    = quote_smart($link, $inp_number_serving_carbs);

				$inp_number_serving_carbs_of_which_dietary_fiber = round($inp_number_serving_carbs_of_which_dietary_fiber/$get_number_servings);
				$inp_number_serving_carbs_of_which_dietary_fiber_mysql 	= quote_smart($link, $inp_number_serving_carbs_of_which_dietary_fiber); 

				$inp_number_serving_carbs_of_which_sugars 		= round($inp_number_serving_carbs_of_which_sugars /$get_number_servings);
				$inp_number_serving_carbs_of_which_sugars_mysql 	= quote_smart($link, $inp_number_serving_carbs_of_which_sugars); 

				$inp_number_serving_salt 	= round($inp_number_serving_salt/$get_number_servings);
				$inp_number_serving_salt_mysql 	= quote_smart($link, $inp_number_serving_salt); 

				$inp_number_serving_sodium 	 = round($inp_number_serving_sodium/$get_number_servings);
				$inp_number_serving_sodium_mysql = quote_smart($link, $inp_number_serving_sodium); 



				$result = mysqli_query($link, "UPDATE $t_recipes_numbers SET 
					number_hundred_calories=$inp_number_hundred_calories_mysql, 
					number_hundred_proteins=$inp_number_hundred_proteins_mysql, 
					number_hundred_fat=$inp_number_hundred_fat_mysql, 
					number_hundred_fat_of_which_saturated_fatty_acids=$inp_number_hundred_fat_of_which_saturated_fatty_acids_mysql,
					number_hundred_carbs=$inp_number_hundred_carbs_mysql, 
					number_hundred_carbs_of_which_dietary_fiber=$inp_number_hundred_carbs_of_which_dietary_fiber_mysql,
					number_hundred_carbs_of_which_sugars=$inp_number_hundred_carbs_of_which_sugars_mysql,
					number_hundred_salt=$inp_number_hundred_salt_mysql,
					number_hundred_sodium=$inp_number_hundred_sodium_mysql,

					number_serving_calories=$inp_number_serving_calories_mysql, 
					number_serving_proteins=$inp_number_serving_proteins_mysql, 
					number_serving_fat=$inp_number_serving_fat_mysql, 
					number_serving_fat_of_which_saturated_fatty_acids=$inp_number_serving_fat_of_which_saturated_fatty_acids_mysql,
					number_serving_carbs=$inp_number_serving_carbs_mysql,
					number_serving_carbs_of_which_dietary_fiber=$inp_number_serving_carbs_of_which_dietary_fiber_mysql, 
					number_serving_carbs_of_which_sugars=$inp_number_serving_carbs_of_which_sugars_mysql, 
					number_serving_salt=$inp_number_serving_salt_mysql,
					number_serving_sodium=$inp_number_serving_sodium_mysql,

					number_total_weight=$inp_number_total_weight_mysql, 
					number_total_calories=$inp_number_total_calories_mysql, 
					number_total_proteins=$inp_number_total_proteins_mysql, 
					number_total_fat=$inp_number_total_fat_mysql, 
					number_total_fat_of_which_saturated_fatty_acids=$inp_number_serving_fat_of_which_saturated_fatty_acids_mysql,
					number_total_carbs=$inp_number_total_carbs_mysql,
					number_total_carbs_of_which_dietary_fiber=$inp_number_serving_carbs_of_which_dietary_fiber_mysql,
					number_total_carbs_of_which_sugars=$inp_number_serving_carbs_of_which_sugars_mysql, 
					number_total_salt=$inp_number_serving_salt_mysql, 
					number_total_sodium=$inp_number_serving_sodium_mysql
					 WHERE number_recipe_id=$recipe_id_mysql") or die(mysqli_error($link));



				// Header
				$ft = "success";
				$fm = "ingredient_added";

				$url = "edit_recipe_ingredients.php?recipe_id=$get_recipe_id&action=add_items&group_id=$get_group_id&l=$l";
				$url = $url . "&ft=$ft&fm=$fm";
				header("Location: $url");
				exit;

			}

			echo"

			<h1>$get_recipe_title</h1>

			<!-- Menu -->
			<div class=\"tabs\">
				<ul>
				<li><a href=\"edit_recipe.php?recipe_id=$recipe_id&amp;l=$l\">$l_general</a>
				<li><a href=\"edit_recipe_ingredients.php?recipe_id=$recipe_id&amp;l=$l\" class=\"active\">$l_ingredients</a>
				<li><a href=\"edit_recipe_categorization.php?recipe_id=$recipe_id&amp;l=$l\">$l_categorization</a>
				<li><a href=\"edit_recipe_image.php?recipe_id=$recipe_id&amp;l=$l\">$l_image</a>
				<li><a href=\"edit_recipe_video.php?recipe_id=$recipe_id&amp;l=$l\">$l_video</a>
			</ul>
			</div><p>&nbsp;</p>
			<!-- //Menu -->



		

			<h2>$l_add_ingredients</h2>



			<h3>$get_group_title</h3>



			<!-- Feedback -->
				";
				if($ft != ""){
					if($fm == "changes_saved"){
						$fm = "$l_changes_saved";
					}
					elseif($fm == "amound_cant_be_empty"){
						$fm = "$l_amound_cant_be_empty";
					}
					elseif($fm == "amound_has_to_be_a_number"){
						$fm = "$l_amound_has_to_be_a_number";
					}
					elseif($fm == "measurement_cant_be_empty"){
						$fm = "$l_measurement_cant_be_empty";
					}
					elseif($fm == "grocery_cant_be_empty"){
						$fm = "$l_grocery_cant_be_empty";
					}
					elseif($fm == "calories_cant_be_empty"){
						$fm = "$l_calories_cant_be_empty";
					}
					elseif($fm == "proteins_cant_be_empty"){
						$fm = "$l_proteins_cant_be_empty";
					}
					elseif($fm == "fat_cant_be_empty"){
						$fm = "$l_fat_cant_be_empty";
					}
					elseif($fm == "carbs_cant_be_empty"){
						$fm = "$l_carbs_cant_be_empty";
					}
					elseif($fm == "calories_have_to_be_a_number"){
						$fm = "$l_calories_have_to_be_a_number";
					}
					elseif($fm == "proteins_have_to_be_a_number"){
						$fm = "$l_proteins_have_to_be_a_number";
					}
					elseif($fm == "carbs_have_to_be_a_number"){
						$fm = "$l_carbs_have_to_be_a_number";
					}
					elseif($fm == "fat_have_to_be_a_number"){
						$fm = "$l_fat_have_to_be_a_number";
					}
					elseif($fm == "you_have_already_added_that_item"){
						$fm = "$l_you_have_already_added_that_item";
					}
					elseif($fm == "ingredient_added"){
						$fm = "$l_ingredient_added";
					}
					else{
						$fm = ucfirst($fm);
					}
					echo"<div class=\"$ft\"><span>$fm</span></div>";
				}
				echo"	
			<!-- //Feedback -->



				<!-- Focus -->
					<script>
					\$(document).ready(function(){
						\$('[name=\"inp_item_amount\"]').focus();
					});
					</script>
				<!-- //Focus -->


				<!-- Var -->
				";
					if(isset($_GET['amount'])){
						$inp_item_amount = $_GET['amount'];
						$inp_item_amount = output_html($inp_item_amount);
					}
					else{
						$inp_item_amount = "";
					}

					if(isset($_GET['measurement'])){
						$inp_item_measurement = $_GET['measurement'];
						$inp_item_measurement = output_html($inp_item_measurement);
					}
					else{
						$inp_item_measurement = "";
					}

					if(isset($_GET['grocery'])){
						$inp_item_grocery = $_GET['grocery'];
						$inp_item_grocery = output_html($inp_item_grocery);
					}
					else{
						$inp_item_grocery = "";
					}

					if(isset($_GET['calories_per_hundred'])){
						$inp_item_calories_per_hundred = $_GET['calories_per_hundred'];
						$inp_item_calories_per_hundred = output_html($inp_item_calories_per_hundred);
					}
					else{
						$inp_item_calories_per_hundred = "";
					}

					if(isset($_GET['proteins_per_hundred'])){
						$inp_item_proteins_per_hundred = $_GET['proteins_per_hundred'];
						$inp_item_proteins_per_hundred = output_html($inp_item_proteins_per_hundred);
					}
					else{
						$inp_item_proteins_per_hundred = "";
					}

					if(isset($_GET['fat_per_hundred'])){
						$inp_item_fat_per_hundred = $_GET['fat_per_hundred'];
						$inp_item_fat_per_hundred = output_html($inp_item_fat_per_hundred);
					}
					else{
						$inp_item_fat_per_hundred = "";
					}
					if(isset($_GET['fat_of_which_saturated_fatty_acids_per_hundred'])){
						$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = $_GET['fat_of_which_saturated_fatty_acids_per_hundred'];
						$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = output_html($inp_item_fat_of_which_saturated_fatty_acids_per_hundred);
					}
					else{
						$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = "";
					}

					if(isset($_GET['carbs_per_hundred'])){
						$inp_item_carbs_per_hundred = $_GET['carbs_per_hundred'];
						$inp_item_carbs_per_hundred = output_html($inp_item_carbs_per_hundred);
					}
					else{
						$inp_item_carbs_per_hundred = "";
					}

					if(isset($_GET['carbs_of_which_dietary_fiber_calculated'])){
						$inp_item_carbs_of_which_dietary_fiber_calculated = $_GET['carbs_of_which_dietary_fiber_calculated'];
						$inp_item_carbs_of_which_dietary_fiber_calculated = output_html($inp_item_carbs_of_which_dietary_fiber_calculated);
					}
					else{
						$inp_item_carbs_of_which_dietary_fiber_calculated = "";
					}

					if(isset($_GET['carbs_of_which_dietary_fiber_hundred'])){
						$inp_item_carbs_of_which_dietary_fiber_hundred = $_GET['carbs_of_which_dietary_fiber_hundred'];
						$inp_item_carbs_of_which_dietary_fiber_hundred = output_html($inp_item_carbs_of_which_dietary_fiber_hundred);
					}
					else{
						$inp_item_carbs_of_which_dietary_fiber_hundred = "";
					}

					if(isset($_GET['carbs_of_which_sugars_per_hundred'])){
						$inp_item_carbs_of_which_sugars_per_hundred = $_GET['carbs_of_which_sugars_per_hundred'];
						$inp_item_carbs_of_which_sugars_per_hundred = output_html($inp_item_carbs_of_which_sugars_per_hundred);
					}
					else{
						$inp_item_carbs_of_which_sugars_per_hundred = "";
					}



					if(isset($_GET['salt_per_hundred'])){
						$inp_item_salt_per_hundred = $_GET['salt_per_hundred'];
						$inp_item_salt_per_hundred = output_html($inp_item_salt_per_hundred);
					}
					else{
						$inp_item_salt_per_hundred = "";
					}

					if(isset($_GET['calories'])){
						$inp_item_calories_calculated = $_GET['calories'];
						$inp_item_calories_calculated = output_html($inp_item_calories_calculated);
					}
					else{
						$inp_item_calories_calculated = "";
					}

					if(isset($_GET['proteins'])){
						$inp_item_proteins_calculated = $_GET['proteins'];
						$inp_item_proteins_calculated = output_html($inp_item_proteins_calculated);
					}
					else{
						$inp_item_proteins_calculated = "";
					}

					if(isset($_GET['fat'])){
						$inp_item_fat_calculated = $_GET['fat'];
						$inp_item_fat_calculated = output_html($inp_item_fat_calculated);
					}
					else{
						$inp_item_fat_calculated = "";
					}
					if(isset($_GET['fat_of_which_saturated_fatty_acids'])){
						$inp_item_fat_of_which_saturated_fatty_acids_calculated = $_GET['fat_of_which_saturated_fatty_acids'];
						$inp_item_fat_of_which_saturated_fatty_acids_calculated = output_html($inp_item_fat_of_which_saturated_fatty_acids_calculated);
					}
					else{
						$inp_item_fat_of_which_saturated_fatty_acids_calculated = "";
					}

					if(isset($_GET['carbs'])){
						$inp_item_carbs_calculated = $_GET['carbs'];
						$inp_item_carbs_calculated = output_html($inp_item_carbs_calculated);
					}
					else{
						$inp_item_carbs_calculated = "";
					}

					if(isset($_GET['carbs_of_which_sugars'])){
						$inp_item_carbs_of_which_sugars_calculated = $_GET['carbs_of_which_sugars'];
						$inp_item_carbs_of_which_sugars_calculated = output_html($inp_item_carbs_of_which_sugars_calculated);
					}
					else{
						$inp_item_carbs_of_which_sugars_calculated = "";
					}

					if(isset($_GET['salt'])){
						$inp_item_salt_calculated = $_GET['salt'];
						$inp_item_salt_calculated = output_html($inp_item_salt_calculated);
					}
					else{
						$inp_item_salt_calculated = "";
					}

					if(isset($_GET['sodium'])){
						$inp_item_sodium_calculated = $_GET['sodium'];
						$inp_item_sodium_calculated = output_html($inp_item_sodium_calculated);
					}
					else{
						$inp_item_sodium_calculated = "";
					}


					echo"
				<!-- //Var -->



			<!-- Add item -->

				<form method=\"post\" action=\"edit_recipe_ingredients.php?recipe_id=$get_recipe_id&amp;action=add_items&amp;group_id=$group_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

				<h2 style=\"padding-bottom:0;margin-bottom:0;\">$l_food</h2>
				<table>
				 <tbody>
				  <tr>
				   <td style=\"padding: 0px 20px 0px 0px;\">
					<p>$l_amount<br />
					<input type=\"text\" name=\"inp_item_amount\" id=\"inp_item_amount\" size=\"3\" value=\"$inp_item_amount\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
					</p>
				   </td>
				   <td>
					<p>$l_measurement<br />
					<input type=\"text\" name=\"inp_item_measurement\" size=\"3\" value=\"$inp_item_measurement\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
					</p>
				   </td>
				  </tr>
				</table>
				<p>$l_grocery &middot; <a href=\"$root/food/new_food.php?l=$l\" target=\"_blank\">$l_new_food</a><br />
				<input type=\"text\" name=\"inp_item_grocery\" class=\"inp_item_grocery\" size=\"25\" value=\"$inp_item_grocery\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" id=\"nettport_inp_search_query\" />
				<input type=\"hidden\" name=\"inp_item_food_id\" id=\"inp_item_food_id\" /></p>


				<div id=\"nettport_search_results\">
				</div><div class=\"clear\"></div></span>

				<hr />
			
				<h2 style=\"padding-bottom:0;margin-bottom:0;\">$l_numbers</h2>
				<table class=\"hor-zebra\" style=\"width: 350px\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
				   </th>";
				if($get_recipe_country != "United States"){
					echo"
				   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;vertical-align: bottom;\">
					<span>$l_per_hundred</span>
				   </th>";
				}
				echo"
				   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;vertical-align: bottom;\">
					<span>$l_calculated</span>
				   </th>
				  </tr>
				 </thead>
				 <tbody>
				  <tr>
				   <td style=\"padding: 8px 4px 6px 8px;\">
					<span>$l_calories</span>
				   </td>";
				if($get_recipe_country != "United States"){
					echo"
				   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
					<span><input type=\"text\" name=\"inp_item_calories_per_hundred\" id=\"inp_item_calories_per_hundred\" size=\"5\" value=\"$inp_item_calories_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></span>
				   </td>";
				}
				echo"
				   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
					<span><input type=\"text\" name=\"inp_item_calories_calculated\" id=\"inp_item_calories_calculated\" size=\"5\" value=\"$inp_item_calories_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></span>
				   </td>
				  </tr>
				  <tr>
				   <td style=\"padding: 8px 4px 6px 8px;\">
					<p style=\"margin:0;padding: 0px 0px 4px 0px;\">$l_fat</p>
					<p style=\"margin:0;padding: 0;\">$l_dash_of_which_saturated_fatty_acids</p>
				   </td>";
				if($get_recipe_country != "United States"){
					echo"
				   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
					<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_item_fat_per_hundred\" id=\"inp_item_fat_per_hundred\" size=\"5\" value=\"$inp_item_fat_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
					<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_item_fat_of_which_saturated_fatty_acids_per_hundred\" id=\"inp_item_fat_of_which_saturated_fatty_acids_per_hundred\" size=\"5\" value=\"$inp_item_fat_of_which_saturated_fatty_acids_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
				   </td>";
				}
				echo"
				   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
					<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_item_fat_calculated\" id=\"inp_item_fat_calculated\" size=\"5\" value=\"$inp_item_fat_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
					<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_item_fat_of_which_saturated_fatty_acids_calculated\" id=\"inp_item_fat_of_which_saturated_fatty_acids_calculated\" size=\"5\" value=\"$inp_item_fat_of_which_saturated_fatty_acids_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
				   </td>
				 </tr>
				  <tr>
		 		  <td style=\"padding: 8px 4px 6px 8px;\">
					<p style=\"margin:0;padding: 0px 0px 4px 0px;\">$l_carbs</p>
					<p style=\"margin:0;padding: 0;\">$l_dash_of_which_sugars_calculated</p>
				   </td>";
				if($get_recipe_country != "United States"){
					echo"
				   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
					<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_item_carbs_per_hundred\" id=\"inp_item_carbs_per_hundred\" size=\"5\" value=\"$inp_item_carbs_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
					<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_item_carbs_of_which_sugars_per_hundred\" id=\"inp_item_carbs_of_which_sugars_per_hundred\" size=\"5\" value=\"$inp_item_carbs_of_which_sugars_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
				   </td>";
				}
				echo"
				   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
					<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_item_carbs_calculated\" id=\"inp_item_carbs_calculated\" size=\"5\" value=\"$inp_item_carbs_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
					<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_item_carbs_of_which_sugars_calculated\" id=\"inp_item_carbs_of_which_sugars_calculated\" size=\"5\" value=\"$inp_item_carbs_of_which_sugars_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
				   </td>
				  </tr>

				 <tr>
	 			  <td style=\"padding: 8px 4px 6px 8px;\">
					<p style=\"margin:0;padding: 0;\">$l_dietary_fiber</p>
				   </td>";
				if($get_recipe_country != "United States"){
					echo"
				 	  <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_item_carbs_of_which_dietary_fiber_per_hundred\" id=\"inp_item_carbs_of_which_dietary_fiber_per_hundred\" size=\"5\" value=\"$inp_item_carbs_of_which_dietary_fiber_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
					   </td>";
					}
				echo"
				   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
					<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_item_carbs_of_which_dietary_fiber_calculated\" id=\"inp_item_carbs_of_which_dietary_fiber_calculated\" size=\"5\" value=\"$inp_item_carbs_of_which_dietary_fiber_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
				   </td>
				  </tr>


				  <tr>
				   <td style=\"padding: 8px 4px 6px 8px;\">
					<span>$l_proteins</span>
				   </td>";
				if($get_recipe_country != "United States"){
					echo"
				   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
					<span><input type=\"text\" name=\"inp_item_proteins_per_hundred\" id=\"inp_item_proteins_per_hundred\" size=\"5\" value=\"$inp_item_proteins_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></span>
				   </td>";
				}
				echo"
				   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
					<span><input type=\"text\" name=\"inp_item_proteins_calculated\" id=\"inp_item_proteins_calculated\" size=\"5\" value=\"$inp_item_proteins_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></span>
				   </td>
				  </tr>
				 </tr>";
				if($get_recipe_country == "United States"){
					// US uses sodium only, while rest uses salt
					echo"
					  <tr>
					   <td style=\"padding: 8px 4px 6px 8px;\">
						<span>$l_sodium_in_mg</span>
					   </td>
				 	   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span><input type=\"text\" name=\"inp_item_sodium_calculated\" id=\"inp_item_sodium_calculated\" value=\"$inp_item_sodium_calculated\" size=\"5\" /></span>
					   </td>
					  </tr>
					";
				}
				else{
					echo"
					  <tr>
					   <td style=\"padding: 8px 4px 6px 8px;\">
						<span>$l_salt_in_gram</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span><input type=\"text\" name=\"inp_item_salt_per_hundred\" id=\"inp_item_salt_per_hundred\" value=\"$inp_item_salt_per_hundred\" size=\"5\" /></span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span><input type=\"text\" name=\"inp_item_salt_calculated\" id=\"inp_item_salt_calculated\" value=\"$inp_item_salt_calculated\" size=\"5\" /></span>
					   </td>
					  </tr>
					";
				}
				echo"
				 </tbody>
				</table>




			

				<p>
				<input type=\"submit\" value=\"$l_add_ingredient\" class=\"btn\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
				</p>





				</form>

				<!-- Search script -->
					<script id=\"source\" language=\"javascript\" type=\"text/javascript\">
					\$(document).ready(function () {
						\$('#nettport_inp_search_query').keyup(function () {
							$(\"#nettport_search_results\").show();
       							// getting the value that user typed
       							var searchString    = $(\"#nettport_inp_search_query\").val();
 							// forming the queryString
      							var data            = 'l=$l&recipe_id=$recipe_id&q='+ searchString;

        						// if searchString is not empty
        						if(searchString) {
           							// ajax call
            							\$.ajax({
                							type: \"POST\",
               								url: \"submit_recipe_step_2_group_and_elements_search_jquery.php\",
                							data: data,
									beforeSend: function(html) { // this happens before actual call
										\$(\"#nettport_search_results\").html(''); 
									},
               								success: function(html){
                    								\$(\"#nettport_search_results\").append(html);
              								}
            							});

       							}
        						return false;
            					});
         				   });
					</script>
				<!-- //Search script -->



			<!-- //Add item -->





			<!-- Buttons -->

				<p>

				<a href=\"edit_recipe_ingredients.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"btn btn_default\">$l_summary</a>



				<a href=\"edit_recipe_ingredients.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"btn btn_default\">$l_add_another_group</a>

	

				</p>

			<!-- //Buttons -->





			";

		} // group found

	} // action == "add_items")

	elseif($action == "edit_group"){

		// Get group

		$group_id_mysql = quote_smart($link, $group_id);

		$query = "SELECT group_id, group_recipe_id, group_title FROM $t_recipes_groups WHERE group_id=$group_id_mysql AND group_recipe_id=$get_recipe_id";

		$result = mysqli_query($link, $query);

		$row = mysqli_fetch_row($result);

		list($get_group_id, $get_group_recipe_id, $get_group_title) = $row;



		if($get_group_id == ""){

			echo"

			<h1>Server error</h1>



			<p>

			Group not found.

			</p>

			";

		}

		else{

			if($process == "1"){

				$inp_group_title = $_POST['inp_group_title'];

				$inp_group_title = output_html($inp_group_title);

				$inp_group_title_mysql = quote_smart($link, $inp_group_title);

				if(empty($inp_group_title)){

					$ft = "error";

					$fm = "title_cant_be_empty";



					$url = "edit_recipe_ingredients.php?action=edit_group&recipe_id=$get_recipe_id&group_id=$get_group_id&l=$l";

					$url = $url . "&ft=$ft&fm=$fm";



					header("Location: $url");

					exit;

				}



				// Update

				$result = mysqli_query($link, "UPDATE $t_recipes_groups SET group_title=$inp_group_title_mysql WHERE group_id=$get_group_id");





				// Header

				$ft = "success";

				$fm = "changes_saved";



				$url = "edit_recipe_ingredients.php?recipe_id=$get_recipe_id&group_id=$get_group_id&l=$l";

				$url = $url . "&ft=$ft&fm=$fm";

				header("Location: $url");

				exit;	



				



			}

			echo"

			<h1>$get_recipe_title</h1>





			<!-- Menu -->

			<div class=\"tabs\">

			<ul>

				<li><a href=\"edit_recipe.php?recipe_id=$recipe_id&amp;l=$l\">$l_general</a>

				<li><a href=\"edit_recipe_ingredients.php?recipe_id=$recipe_id&amp;l=$l\" class=\"active\">$l_ingredients</a>

				<li><a href=\"edit_recipe_categorization.php?recipe_id=$recipe_id&amp;l=$l\">$l_categorization</a>

				<li><a href=\"edit_recipe_image.php?recipe_id=$recipe_id&amp;l=$l\">$l_image</a>

				<li><a href=\"edit_recipe_video.php?recipe_id=$recipe_id&amp;l=$l\">$l_video</a>

			</ul>

			</div><p>&nbsp;</p>

			<!-- //Menu -->





			<h2>$l_edit_group</h2>







			<!-- Feedback -->

				";

				if($ft != ""){

					if($fm == "changes_saved"){

						$fm = "$l_changes_saved";

					}

					elseif($fm == "amound_cant_be_empty"){

						$fm = "$l_amound_cant_be_empty";

					}

					else{

						$fm = ucfirst($fm);

					}

					echo"<div class=\"$ft\"><span>$fm</span></div>";

				}

				echo"	

			<!-- //Feedback -->



			<!-- Edit group form -->

				<!-- Focus -->

					<script>

					\$(document).ready(function(){

						\$('[name=\"inp_group_title\"]').focus();

					});

					</script>

				<!-- //Focus -->





				<form method=\"post\" action=\"edit_recipe_ingredients.php?action=edit_group&amp;recipe_id=$get_recipe_id&amp;group_id=$group_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			

				<p><b>$l_title:</b><br />

				<input type=\"text\" name=\"inp_group_title\" size=\"30\" value=\"$get_group_title\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />

				<input type=\"submit\" value=\"$l_save_changes\" class=\"btn\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />

				</p>





				</form>

			<!-- //Add item -->



			<!-- Buttons -->

				<p>

				<a href=\"edit_recipe_ingredients.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"btn btn_default\">$l_summary</a>



				<a href=\"edit_recipe_ingredients.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"btn btn_default\">$l_add_another_group</a>

	

				</p>

			<!-- //Buttons -->





			";

		} // group found

	} // action == edit_group

	elseif($action == "delete_group"){

		// Get group

		$group_id_mysql = quote_smart($link, $group_id);

		$query = "SELECT group_id, group_recipe_id, group_title FROM $t_recipes_groups WHERE group_id=$group_id_mysql AND group_recipe_id=$get_recipe_id";

		$result = mysqli_query($link, $query);

		$row = mysqli_fetch_row($result);

		list($get_group_id, $get_group_recipe_id, $get_group_title) = $row;



		if($get_group_id == ""){

			echo"

			<h1>Server error</h1>



			<p>

			Group not found.

			</p>

			";

		}

		else{

			if($process == "1"){

				

				// Update

				$result = mysqli_query($link, "DELETE FROM $t_recipes_groups WHERE group_id=$get_group_id");

				$result = mysqli_query($link, "DELETE FROM $t_recipes_items WHERE item_group_id=$get_group_id");



				

				// Calculating total numbers

				$inp_number_hundred_calories = 0;

				$inp_number_hundred_proteins = 0;

				$inp_number_hundred_fat = 0;

				$inp_number_hundred_carbs = 0;

					

				$inp_number_serving_calories = 0;

				$inp_number_serving_proteins = 0;

				$inp_number_serving_fat = 0;

				$inp_number_serving_carbs = 0;

					

				$inp_number_total_weight = 0;



				$inp_number_total_calories = 0;

				$inp_number_total_proteins = 0;

				$inp_number_total_fat = 0;



				$inp_number_total_carbs = 0;

					

				$query_groups = "SELECT group_id, group_title FROM $t_recipes_groups WHERE group_recipe_id=$get_recipe_id";

				$result_groups = mysqli_query($link, $query_groups);

				while($row_groups = mysqli_fetch_row($result_groups)) {

					list($get_group_id, $get_group_title) = $row_groups;



					$query_items = "SELECT item_id, item_amount, item_calories_per_hundred, item_proteins_per_hundred, item_fat_per_hundred, item_carbs_per_hundred, item_calories_calculated, item_proteins_calculated, item_fat_calculated, item_carbs_calculated FROM $t_recipes_items WHERE item_group_id=$get_group_id";

					$result_items = mysqli_query($link, $query_items);

					$row_cnt = mysqli_num_rows($result_items);

					while($row_items = mysqli_fetch_row($result_items)) {

						list($get_item_id, $get_item_amount, $get_item_calories_per_hundred, $get_item_proteins_per_hundred, $get_item_fat_per_hundred, $get_item_carbs_per_hundred, $get_item_calories_calculated, $get_item_proteins_calculated, $get_item_fat_calculated, $get_item_carbs_calculated) = $row_items;



						$inp_number_hundred_calories = $inp_number_hundred_calories+$get_item_calories_per_hundred;

						$inp_number_hundred_proteins = $inp_number_hundred_proteins+$get_item_proteins_per_hundred;

						$inp_number_hundred_fat      = $inp_number_hundred_fat+$get_item_fat_per_hundred;

						$inp_number_hundred_carbs    = $inp_number_hundred_carbs+$get_item_carbs_per_hundred;

					

						$inp_number_total_weight     = $inp_number_total_weight+$get_item_amount;



						$inp_number_total_calories = $inp_number_total_calories+$get_item_calories_calculated;

						$inp_number_total_proteins = $inp_number_total_proteins+$get_item_proteins_calculated;

						$inp_number_total_fat      = $inp_number_total_fat+$get_item_fat_calculated;

						$inp_number_total_carbs    = $inp_number_total_carbs+$get_item_carbs_calculated;

	

					} // items

				} // groups

					

				$inp_number_serving_calories = round($inp_number_total_calories/$get_number_servings);

				$inp_number_serving_proteins = round($inp_number_total_proteins/$get_number_servings);

				$inp_number_serving_fat      = round($inp_number_total_fat/$get_number_servings);

				$inp_number_serving_carbs    = round($inp_number_total_carbs/$get_number_servings);



	

				// Ready numbers for MySQL

				$inp_number_hundred_calories_mysql = quote_smart($link, $inp_number_hundred_calories);

				$inp_number_hundred_proteins_mysql = quote_smart($link, $inp_number_hundred_proteins);

				$inp_number_hundred_fat_mysql      = quote_smart($link, $inp_number_hundred_fat);

				$inp_number_hundred_carbs_mysql    = quote_smart($link, $inp_number_hundred_carbs);

					

				$inp_number_total_weight_mysql     = quote_smart($link, $inp_number_total_weight);



				$inp_number_total_calories_mysql = quote_smart($link, $inp_number_total_calories);

				$inp_number_total_proteins_mysql = quote_smart($link, $inp_number_total_proteins);

				$inp_number_total_fat_mysql      = quote_smart($link, $inp_number_total_fat);

				$inp_number_total_carbs_mysql    = quote_smart($link, $inp_number_total_carbs);



					

				$inp_number_serving_calories_mysql = quote_smart($link, $inp_number_serving_calories);

				$inp_number_serving_proteins_mysql = quote_smart($link, $inp_number_serving_proteins);

				$inp_number_serving_fat_mysql      = quote_smart($link, $inp_number_serving_fat);

				$inp_number_serving_carbs_mysql    = quote_smart($link, $inp_number_serving_carbs);



				$result = mysqli_query($link, "UPDATE $t_recipes_numbers SET number_hundred_calories=$inp_number_hundred_calories_mysql, number_hundred_proteins=$inp_number_hundred_proteins_mysql, number_hundred_fat=$inp_number_hundred_fat_mysql, number_hundred_carbs=$inp_number_hundred_carbs_mysql, 

								number_serving_calories=$inp_number_serving_calories_mysql, number_serving_proteins=$inp_number_serving_proteins_mysql, number_serving_fat=$inp_number_serving_fat_mysql, number_serving_carbs=$inp_number_serving_carbs_mysql,

								number_total_weight=$inp_number_total_weight_mysql, 

								number_total_calories=$inp_number_total_calories_mysql, number_total_proteins=$inp_number_total_proteins_mysql, number_total_fat=$inp_number_total_fat_mysql, number_total_carbs=$inp_number_total_carbs_mysql WHERE number_recipe_id=$recipe_id_mysql");







				// Header

				$ft = "success";

				$fm = "group_deleted";



				$url = "edit_recipe_ingredients.php?&recipe_id=$get_recipe_id&l=$l";

				$url = $url . "&ft=$ft&fm=$fm";

				header("Location: $url");

				exit;	



				



			}

			echo"

			<h1>$get_recipe_title</h1>





			<!-- Menu -->

				<div class=\"tabs\">

				<ul>

				<li><a href=\"edit_recipe.php?recipe_id=$recipe_id&amp;l=$l\">$l_general</a>

				<li><a href=\"edit_recipe_ingredients.php?recipe_id=$recipe_id&amp;l=$l\" class=\"active\">$l_ingredients</a>

				<li><a href=\"edit_recipe_categorization.php?recipe_id=$recipe_id&amp;l=$l\">$l_categorization</a>

				<li><a href=\"edit_recipe_image.php?recipe_id=$recipe_id&amp;l=$l\">$l_image</a>

				<li><a href=\"edit_recipe_video.php?recipe_id=$recipe_id&amp;l=$l\">$l_video</a>

				</ul>

				</div><p>&nbsp;</p>

			<!-- //Menu -->

			<h2>$l_delete_group</h2>







			<!-- Feedback -->

				";

				if($ft != ""){

					if($fm == "changes_saved"){

						$fm = "$l_changes_saved";

					}

					elseif($fm == "amound_cant_be_empty"){

						$fm = "$l_amound_cant_be_empty";

					}

					else{

						$fm = ucfirst($fm);

					}

					echo"<div class=\"$ft\"><span>$fm</span></div>";

				}

				echo"	

			<!-- //Feedback -->



			<!-- Delete group -->

				<h3>$get_group_title</h3>

				<p>

				$l_are_you_sure_you_want_to_delete

				$l_the_action_cant_be_undone

				</p>



				<p>

				<a href=\"edit_recipe_ingredients.php?action=delete_group&amp;recipe_id=$get_recipe_id&amp;group_id=$group_id&amp;l=$l&amp;process=1\" class=\"btn btn_warning\">$l_delete</a>

				<a href=\"edit_recipe_ingredients.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"btn btn_default\">$l_cancel</a>

				</p>

			<!-- //Delete group -->





			";

		} // group found

	} // action == delete_group
	elseif($action == "edit_item"){
		// Get group
		$group_id_mysql = quote_smart($link, $group_id);
		$query = "SELECT group_id, group_recipe_id, group_title FROM $t_recipes_groups WHERE group_id=$group_id_mysql AND group_recipe_id=$get_recipe_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_group_id, $get_group_recipe_id, $get_group_title) = $row;

		if($get_group_id == ""){
			echo"
			<h1>Server error</h1>

			<p>
			Group not found.
			</p>
			";
		}
		else{
			// Get item
			$item_id_mysql = quote_smart($link, $item_id);
			$query = "SELECT item_id, item_recipe_id, item_group_id, item_amount, item_measurement, item_grocery, item_grocery_explanation, item_food_id, item_calories_per_hundred, item_fat_per_hundred, item_fat_of_which_saturated_fatty_acids_per_hundred, item_carbs_per_hundred, item_carbs_of_which_dietary_fiber_hundred, item_carbs_of_which_sugars_per_hundred, item_proteins_per_hundred, item_salt_per_hundred, item_sodium_per_hundred, item_calories_calculated, item_fat_calculated, item_fat_of_which_saturated_fatty_acids_calculated, item_carbs_calculated, item_carbs_of_which_dietary_fiber_calculated, item_carbs_of_which_sugars_calculated, item_proteins_calculated, item_salt_calculated, item_sodium_calculated FROM $t_recipes_items WHERE item_id=$item_id_mysql AND item_recipe_id=$get_recipe_id AND item_group_id=$get_group_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_item_id, $get_item_recipe_id, $get_item_group_id, $get_item_amount, $get_item_measurement, $get_item_grocery, $get_item_grocery_explanation, $get_item_food_id, $get_item_calories_per_hundred, $get_item_fat_per_hundred, $get_item_fat_of_which_saturated_fatty_acids_per_hundred, $get_item_carbs_per_hundred, $get_item_carbs_of_which_dietary_fiber_hundred, $get_item_carbs_of_which_sugars_per_hundred, $get_item_proteins_per_hundred, $get_item_salt_per_hundred, $get_item_sodium_per_hundred, $get_item_calories_calculated, $get_item_fat_calculated, $get_item_fat_of_which_saturated_fatty_acids_calculated, $get_item_carbs_calculated, $get_item_carbs_of_which_dietary_fiber_calculated, $get_item_carbs_of_which_sugars_calculated, $get_item_proteins_calculated, $get_item_salt_calculated, $get_item_sodium_calculated) = $row;


			if($get_item_id == ""){
				echo"
				<h1>Server error</h1>

				<p>
				Items not found.
				</p>
				";
			}
			else{
				if($process == "1"){
					$inp_item_amount = $_POST['inp_item_amount'];
					$inp_item_amount = output_html($inp_item_amount);
					$inp_item_amount = str_replace(",", ".", $inp_item_amount);
					$inp_item_amount_mysql = quote_smart($link, $inp_item_amount);
					if(empty($inp_item_amount)){
						$ft = "error";
						$fm = "amound_cant_be_empty";
					}
					else{
						if(!(is_numeric($inp_item_amount))){
							// Do we have math? Example 1/8 ts
							$check_for_fraction = explode("/", $inp_item_amount);

							if(isset($check_for_fraction[0]) && isset($check_for_fraction[1])){
								if(is_numeric($check_for_fraction[0]) && is_numeric($check_for_fraction[1])){
									$inp_item_amount = $check_for_fraction[0] / $check_for_fraction[1];
								}
								else{
									$ft = "error";
									$fm = "amound_has_to_be_a_number";
								}
							}
							else{
								$ft = "error";
								$fm = "amound_has_to_be_a_number";
							}
						}
					}
	
					$inp_item_measurement = $_POST['inp_item_measurement'];
					$inp_item_measurement = output_html($inp_item_measurement);
					$inp_item_measurement = str_replace(",", ".", $inp_item_measurement);
					$inp_item_measurement_mysql = quote_smart($link, $inp_item_measurement);
					if(empty($inp_item_measurement)){
						$ft = "error";
						$fm = "measurement_cant_be_empty";
					}

					$inp_item_grocery = $_POST['inp_item_grocery'];
					$inp_item_grocery = output_html($inp_item_grocery);
					$inp_item_grocery_mysql = quote_smart($link, $inp_item_grocery);
					if(empty($inp_item_grocery)){
						$ft = "error";
						$fm = "grocery_cant_be_empty";
					}

					$inp_item_food_id = $_POST['inp_item_food_id'];
					$inp_item_food_id = output_html($inp_item_food_id);
					if($inp_item_food_id == ""){
						$inp_item_food_id = "0";
					}
					$inp_item_food_id_mysql = quote_smart($link, $inp_item_food_id);


					// Calories per hundred
					if(isset($_POST['inp_item_calories_per_hundred'])){
						$inp_item_calories_per_hundred = $_POST['inp_item_calories_per_hundred'];
					}
					else{
						$inp_item_calories_per_hundred = "0";
					}
					$inp_item_calories_per_hundred = output_html($inp_item_calories_per_hundred);
					$inp_item_calories_per_hundred = str_replace(",", ".", $inp_item_calories_per_hundred);
					if(empty($inp_item_calories_per_hundred)){
						$inp_item_calories_per_hundred = "0";
					}
					else{
						if(!(is_numeric($inp_item_calories_per_hundred))){
							$ft = "error";
							$fm = "calories_have_to_be_a_number";
						}
					}
					$inp_item_calories_per_hundred = round($inp_item_calories_per_hundred, 0);
					$inp_item_calories_per_hundred_mysql = quote_smart($link, $inp_item_calories_per_hundred);


					$inp_item_calories_calculated = $_POST['inp_item_calories_calculated'];
					$inp_item_calories_calculated = output_html($inp_item_calories_calculated);
					$inp_item_calories_calculated = str_replace(",", ".", $inp_item_calories_calculated);
					if(empty($inp_item_calories_calculated)){
						$inp_item_calories_calculated = "0";
					}
					else{
						if(!(is_numeric($inp_item_calories_calculated))){
							$ft = "error";
							$fm = "calories_have_to_be_a_number";
						}
					}
					$inp_item_calories_calculated = round($inp_item_calories_calculated, 0);
					$inp_item_calories_calculated_mysql = quote_smart($link, $inp_item_calories_calculated);

					// Fat per hundred
					if(isset($_POST['inp_item_fat_per_hundred'])){
						$inp_item_fat_per_hundred = $_POST['inp_item_fat_per_hundred'];
					}
					else{
						$inp_item_fat_per_hundred = "0";
					}
					$inp_item_fat_per_hundred = output_html($inp_item_fat_per_hundred);
					$inp_item_fat_per_hundred = str_replace(",", ".", $inp_item_fat_per_hundred);
					if(empty($inp_item_fat_per_hundred)){
						$inp_item_fat_per_hundred = "0";
					}
					else{
						if(!(is_numeric($inp_item_calories_per_hundred))){
							$ft = "error";
							$fm = "fat_have_to_be_a_number";
						}
					}
					$inp_item_fat_per_hundred = round($inp_item_fat_per_hundred, 0);
					$inp_item_fat_per_hundred_mysql = quote_smart($link, $inp_item_fat_per_hundred);

					$inp_item_fat_calculated = $_POST['inp_item_fat_calculated'];
					$inp_item_fat_calculated = output_html($inp_item_fat_calculated);
					$inp_item_fat_calculated = str_replace(",", ".", $inp_item_fat_calculated);
					if(empty($inp_item_fat_calculated)){
						$inp_item_fat_calculated = "0";
					}
					else{
						if(!(is_numeric($inp_item_calories_calculated))){
							$ft = "error";
							$fm = "fat_have_to_be_a_number";
						}
					}
					$inp_item_fat_calculated = round($inp_item_fat_calculated, 0);
					$inp_item_fat_calculated_mysql = quote_smart($link, $inp_item_fat_calculated);


					// Fat saturated fatty acids
					if(isset($_POST['inp_item_fat_per_hundred'])){
						$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = $_POST['inp_item_fat_of_which_saturated_fatty_acids_per_hundred'];
					}
					else{
						$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = "0";
					}
					$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = output_html($inp_item_fat_of_which_saturated_fatty_acids_per_hundred);
					$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = str_replace(",", ".", $inp_item_fat_of_which_saturated_fatty_acids_per_hundred);
					if(empty($inp_item_fat_of_which_saturated_fatty_acids_per_hundred)){
						$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = "0";
					}
					else{
						if(!(is_numeric($inp_item_fat_of_which_saturated_fatty_acids_per_hundred))){
							$ft = "error";
							$fm = "fat_of_which_saturated_fatty_acids_per_hundred_have_to_be_a_number";
						}
					}
					$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = round($inp_item_fat_of_which_saturated_fatty_acids_per_hundred, 0);
					$inp_item_fat_of_which_saturated_fatty_acids_per_hundred_mysql = quote_smart($link, $inp_item_fat_of_which_saturated_fatty_acids_per_hundred);
	
					// Fat saturated fatty acids calculated
					$inp_item_fat_of_which_saturated_fatty_acids_calculated = $_POST['inp_item_fat_of_which_saturated_fatty_acids_calculated'];
					$inp_item_fat_of_which_saturated_fatty_acids_calculated = output_html($inp_item_fat_of_which_saturated_fatty_acids_calculated);
					$inp_item_fat_of_which_saturated_fatty_acids_calculated = str_replace(",", ".", $inp_item_fat_of_which_saturated_fatty_acids_calculated);
					if(empty($inp_item_fat_of_which_saturated_fatty_acids_calculated)){
						$inp_item_fat_of_which_saturated_fatty_acids_calculated = "0";
					}
					else{
						if(!(is_numeric($inp_item_fat_of_which_saturated_fatty_acids_calculated))){
							$ft = "error";
							$fm = "fat_of_which_saturated_fatty_acids_calculated_have_to_be_a_number";
						}
					}
					$inp_item_fat_of_which_saturated_fatty_acids_calculated = round($inp_item_fat_of_which_saturated_fatty_acids_calculated, 0);
					$inp_item_fat_of_which_saturated_fatty_acids_calculated_mysql = quote_smart($link, $inp_item_fat_of_which_saturated_fatty_acids_calculated);

					// Carbs per hundred
					if(isset($_POST['inp_item_carbs_per_hundred'])){
						$inp_item_carbs_per_hundred = $_POST['inp_item_carbs_per_hundred'];
					}
					else{
						$inp_item_carbs_per_hundred = "0";
					}				
					$inp_item_carbs_per_hundred = output_html($inp_item_carbs_per_hundred);
					$inp_item_carbs_per_hundred = str_replace(",", ".", $inp_item_carbs_per_hundred);
					if(empty($inp_item_carbs_per_hundred)){
						$inp_item_carbs_per_hundred = "0";
					}
					else{
						if(!(is_numeric($inp_item_calories_per_hundred))){
							$ft = "error";
							$fm = "calories_have_to_be_a_number";
						}
					}
					$inp_item_carbs_per_hundred = round($inp_item_carbs_per_hundred, 0);
					$inp_item_carbs_per_hundred_mysql = quote_smart($link, $inp_item_carbs_per_hundred);

					// Carbs calculated
					$inp_item_carbs_calculated = $_POST['inp_item_carbs_calculated'];
					$inp_item_carbs_calculated = output_html($inp_item_carbs_calculated);
					$inp_item_carbs_calculated = str_replace(",", ".", $inp_item_carbs_calculated);
					if(empty($inp_item_carbs_calculated)){
						$inp_item_carbs_calculated = "0";
					}
					else{
						if(!(is_numeric($inp_item_calories_calculated))){
							$ft = "error";
							$fm = "calories_have_to_be_a_number";
						}
					}
					$inp_item_carbs_calculated = round($inp_item_carbs_calculated, 0);
					$inp_item_carbs_calculated_mysql = quote_smart($link, $inp_item_carbs_calculated);

					// Fiber per hundred
					if(isset($_POST['inp_item_carbs_of_which_dietary_fiber_per_hundred'])){
						$inp_item_carbs_of_which_dietary_fiber_per_hundred = $_POST['inp_item_carbs_of_which_dietary_fiber_per_hundred'];
					}
					else{
						$inp_item_carbs_of_which_dietary_fiber_per_hundred = "0";
					}
					$inp_item_carbs_of_which_dietary_fiber_per_hundred = output_html($inp_item_carbs_of_which_dietary_fiber_per_hundred);
					$inp_item_carbs_of_which_dietary_fiber_per_hundred = str_replace(",", ".", $inp_item_carbs_of_which_dietary_fiber_per_hundred);
					if(empty($inp_item_carbs_of_which_dietary_fiber_per_hundred)){
						$inp_item_carbs_of_which_dietary_fiber_per_hundred = "0";
					}
					else{
						if(!(is_numeric($inp_item_carbs_of_which_dietary_fiber_per_hundred))){
							$ft = "error";
							$fm = "carbs_of_which_sugars_per_hundred_have_to_be_a_number";
						}
					}
					$inp_item_carbs_of_which_dietary_fiber_per_hundred = round($inp_item_carbs_of_which_dietary_fiber_per_hundred, 0);
					$inp_item_carbs_of_which_dietary_fiber_per_hundred_mysql = quote_smart($link, $inp_item_carbs_of_which_dietary_fiber_per_hundred);

					// Fiber calcualted
					if(isset($_POST['inp_item_carbs_of_which_dietary_fiber_calculated'])){
						$inp_item_carbs_of_which_dietary_fiber_calculated = $_POST['inp_item_carbs_of_which_dietary_fiber_calculated'];
					}
					else{
						$inp_item_carbs_of_which_dietary_fiber_calculated = "0";
					}
					$inp_item_carbs_of_which_dietary_fiber_calculated = output_html($inp_item_carbs_of_which_dietary_fiber_calculated);
					$inp_item_carbs_of_which_dietary_fiber_calculated = str_replace(",", ".", $inp_item_carbs_of_which_dietary_fiber_calculated);
					if(empty($inp_item_carbs_of_which_dietary_fiber_calculated)){
						$inp_item_carbs_of_which_dietary_fiber_calculated = "0";
					}
					else{
						if(!(is_numeric($inp_item_carbs_of_which_dietary_fiber_calculated))){
							$ft = "error";
							$fm = "carbs_of_which_sugars_per_hundred_have_to_be_a_number";
						}
					}
					$inp_item_carbs_of_which_dietary_fiber_calculated = round($inp_item_carbs_of_which_dietary_fiber_calculated, 0);
					$inp_item_carbs_of_which_dietary_fiber_calculated_mysql = quote_smart($link, $inp_item_carbs_of_which_dietary_fiber_calculated);



					// Carbs of which sugars
					if(isset($_POST['inp_item_carbs_of_which_sugars_per_hundred'])){
						$inp_item_carbs_of_which_sugars_per_hundred = $_POST['inp_item_carbs_of_which_sugars_per_hundred'];
					}
					else{
						$inp_item_carbs_of_which_sugars_per_hundred = "0";
					}
					$inp_item_carbs_of_which_sugars_per_hundred = output_html($inp_item_carbs_of_which_sugars_per_hundred);
					$inp_item_carbs_of_which_sugars_per_hundred = str_replace(",", ".", $inp_item_carbs_of_which_sugars_per_hundred);
					if(empty($inp_item_carbs_of_which_sugars_per_hundred)){
						$inp_item_carbs_of_which_sugars_per_hundred = "0";
					}
					else{
						if(!(is_numeric($inp_item_carbs_of_which_sugars_per_hundred))){
							$ft = "error";
							$fm = "carbs_of_which_sugars_per_hundred_have_to_be_a_number";
						}
					}
					$inp_item_carbs_of_which_sugars_per_hundred = round($inp_item_carbs_of_which_sugars_per_hundred, 0);
					$inp_item_carbs_of_which_sugars_per_hundred_mysql = quote_smart($link, $inp_item_carbs_of_which_sugars_per_hundred);

					// Carbs of which sugars calcualted
					$inp_item_carbs_of_which_sugars_calculated = $_POST['inp_item_carbs_of_which_sugars_calculated'];
					$inp_item_carbs_of_which_sugars_calculated = output_html($inp_item_carbs_of_which_sugars_calculated);
					$inp_item_carbs_of_which_sugars_calculated = str_replace(",", ".", $inp_item_carbs_of_which_sugars_calculated);
					if(empty($inp_item_carbs_of_which_sugars_calculated)){
						$inp_item_carbs_of_which_sugars_calculated = "0";
					}
					else{
						if(!(is_numeric($inp_item_carbs_of_which_sugars_calculated))){
							$ft = "error";
							$fm = "carbs_of_which_sugars_calculated_have_to_be_a_number";
						}
					}
					$inp_item_carbs_of_which_sugars_calculated = round($inp_item_carbs_of_which_sugars_calculated, 0);
					$inp_item_carbs_of_which_sugars_calculated_mysql = quote_smart($link, $inp_item_carbs_of_which_sugars_calculated);


					// Proteins
					if(isset($_POST['inp_item_proteins_per_hundred'])){
						$inp_item_proteins_per_hundred = $_POST['inp_item_proteins_per_hundred'];
					}
					else{
						$inp_item_proteins_per_hundred = "0";
					}
					$inp_item_proteins_per_hundred = output_html($inp_item_proteins_per_hundred);
					$inp_item_proteins_per_hundred = str_replace(",", ".", $inp_item_proteins_per_hundred);
					if(empty($inp_item_proteins_per_hundred)){
						$inp_item_proteins_per_hundred = "0";
					}
					else{
						if(!(is_numeric($inp_item_proteins_per_hundred))){
							$ft = "error";
							$fm = "proteins_have_to_be_a_number";
						}
					}
					$inp_item_proteins_per_hundred = round($inp_item_proteins_per_hundred, 0);
					$inp_item_proteins_per_hundred_mysql = quote_smart($link, $inp_item_proteins_per_hundred);

					// Proteins calculated
					$inp_item_proteins_calculated = $_POST['inp_item_proteins_calculated'];
					$inp_item_proteins_calculated = output_html($inp_item_proteins_calculated);
					$inp_item_proteins_calculated = str_replace(",", ".", $inp_item_proteins_calculated);
					if(empty($inp_item_proteins_calculated)){
						$inp_item_proteins_calculated = "0";
					}
					else{
						if(!(is_numeric($inp_item_proteins_calculated))){
							$ft = "error";
							$fm = "proteins_have_to_be_a_number";
						}
					}
					$inp_item_proteins_calculated = round($inp_item_proteins_calculated, 0);
					$inp_item_proteins_calculated_mysql = quote_smart($link, $inp_item_proteins_calculated);

					// Salt per hundred
					if(isset($_POST['inp_item_salt_per_hundred'])){
						$inp_item_salt_per_hundred = $_POST['inp_item_salt_per_hundred'];
					}
					else{
						$inp_item_salt_per_hundred = "0";
					}
					$inp_item_salt_per_hundred = output_html($inp_item_salt_per_hundred);
					$inp_item_salt_per_hundred = str_replace(",", ".", $inp_item_salt_per_hundred);
					if(empty($inp_item_salt_per_hundred)){
						$inp_item_salt_per_hundred = "0";
					}
					else{
						if(!(is_numeric($inp_item_salt_per_hundred))){
							$ft = "error";
							$fm = "salt_have_to_be_a_number";
						}
					}
					$inp_item_salt_per_hundred = round($inp_item_salt_per_hundred, 0);
					$inp_item_salt_per_hundred_mysql = quote_smart($link, $inp_item_salt_per_hundred);


					// Sodium per hundred
					if($inp_item_salt_per_hundred != "0"){
						$inp_item_sodium_per_hundred = ($inp_item_salt_per_hundred*40)/100; // 40 % of salt
						$inp_item_sodium_per_hundred = $inp_item_sodium_per_hundred/1000; // mg
					}
					else{
						$inp_item_sodium_per_hundred = 0;
					}
					$inp_item_sodium_per_hundred_mysql = quote_smart($link, $inp_item_sodium_per_hundred);

					// Salt calculated
					if(isset($_POST['inp_item_salt_calculated'])){
						$inp_item_salt_calculated = $_POST['inp_item_salt_calculated'];
					}
					else{
						// Todo: Fix calcualte by sodium
						$inp_item_salt_calculated = 0;
					}
					$inp_item_salt_calculated = output_html($inp_item_salt_calculated);
					$inp_item_salt_calculated = str_replace(",", ".", $inp_item_salt_calculated);
					if(empty($inp_item_salt_calculated)){
						$inp_item_salt_calculated = "0";
					}
					else{
						if(!(is_numeric($inp_item_salt_calculated))){
							$ft = "error";
							$fm = "salt_have_to_be_a_number";
						}
					}
					$inp_item_salt_calculated = round($inp_item_salt_calculated, 0);
					$inp_item_salt_calculated_mysql = quote_smart($link, $inp_item_salt_calculated);

					// Sodium calculated
					if(isset($_POST['inp_item_sodium_calculated'])){
						$inp_item_sodium_calculated = $_POST['inp_item_sodium_calculated'];
						$inp_item_sodium_calculated = output_html($inp_item_sodium_calculated);
						$inp_item_sodium_calculated = str_replace(",", ".", $inp_item_sodium_calculated);
					}
					else{
						$inp_item_sodium_calculated = ($inp_item_salt_calculated*40)/100; // 40 % of salt
						$inp_item_sodium_calculated = $inp_item_sodium_calculated/1000; // mg
					}
					$inp_item_sodium_calculated_mysql = quote_smart($link, $inp_item_sodium_calculated);

					if(isset($fm) && $fm != ""){
						$url = "edit_recipe_ingredients.php?action=edit_item&recipe_id=$get_recipe_id&group_id=$get_group_id&item_id=$get_item_id&l=$l";
						$url = $url . "&ft=$ft&fm=$fm";

						header("Location: $url");
						exit;
					}



					// Update
					$result = mysqli_query($link, "UPDATE $t_recipes_items SET item_amount=$inp_item_amount_mysql, item_measurement=$inp_item_measurement_mysql, 
						item_grocery=$inp_item_grocery_mysql, item_food_id=$inp_item_food_id_mysql, 
						item_calories_per_hundred=$inp_item_calories_per_hundred_mysql,
						item_fat_per_hundred=$inp_item_fat_per_hundred_mysql,
						item_fat_of_which_saturated_fatty_acids_per_hundred=$inp_item_fat_of_which_saturated_fatty_acids_per_hundred_mysql,
						item_carbs_per_hundred=$inp_item_carbs_per_hundred_mysql, 
						item_carbs_of_which_sugars_per_hundred=$inp_item_carbs_of_which_sugars_per_hundred_mysql,
						item_carbs_of_which_dietary_fiber_hundred=$inp_item_carbs_of_which_dietary_fiber_per_hundred_mysql, 
						item_proteins_per_hundred=$inp_item_proteins_per_hundred_mysql,
						item_salt_per_hundred=$inp_item_salt_per_hundred_mysql,
						item_sodium_per_hundred=$inp_item_sodium_per_hundred_mysql,

						item_calories_calculated=$inp_item_calories_calculated_mysql, 
						item_fat_calculated=$inp_item_fat_calculated_mysql, 
						item_fat_of_which_saturated_fatty_acids_calculated=$inp_item_fat_of_which_saturated_fatty_acids_calculated_mysql,  
						item_carbs_calculated=$inp_item_carbs_calculated_mysql,
						item_carbs_of_which_dietary_fiber_calculated=$inp_item_carbs_of_which_dietary_fiber_calculated_mysql, 
						item_carbs_of_which_sugars_calculated=$inp_item_carbs_of_which_sugars_calculated_mysql, 
						item_proteins_calculated=$inp_item_proteins_calculated_mysql, 
						item_salt_calculated=$inp_item_salt_calculated_mysql,
						item_sodium_calculated=$inp_item_sodium_calculated_mysql
						 WHERE item_id=$get_item_id") or die(mysqli_error($link));

				// Calculating total numbers


				$inp_number_hundred_calories = 0;
				$inp_number_hundred_proteins = 0;
				$inp_number_hundred_fat = 0;
				$inp_number_hundred_fat_of_which_saturated_fatty_acids = 0;
				$inp_number_hundred_carbs = 0;
				$inp_number_hundred_carbs_of_which_dietary_fiber = 0;
				$inp_number_hundred_carbs_of_which_sugars = 0;
				$inp_number_hundred_salt = 0;
				$inp_number_hundred_sodium = 0;
					
				$inp_number_serving_calories = 0;
				$inp_number_serving_proteins = 0;
				$inp_number_serving_fat = 0;
				$inp_number_serving_fat_of_which_saturated_fatty_acids = 0;
				$inp_number_serving_carbs = 0;
				$inp_number_serving_carbs_of_which_dietary_fiber = 0;
				$inp_number_serving_carbs_of_which_sugars = 0;
				$inp_number_serving_salt = 0;
				$inp_number_serving_sodium = 0;
					
				$inp_number_total_weight = 0;

				$inp_number_total_calories 				= 0;
				$inp_number_total_proteins 				= 0;
				$inp_number_total_fat     				= 0;
				$inp_number_total_fat_of_which_saturated_fatty_acids 	= 0;
				$inp_number_total_carbs    				= 0;
				$inp_number_total_carbs_of_which_dietary_fiber 		= 0;
				$inp_number_total_carbs_of_which_sugars 		= 0;
				$inp_number_total_salt 					= 0;
				$inp_number_total_sodium 					= 0;
					
				$query_groups = "SELECT group_id, group_title FROM $t_recipes_groups WHERE group_recipe_id=$get_recipe_id";
				$result_groups = mysqli_query($link, $query_groups);
				while($row_groups = mysqli_fetch_row($result_groups)) {
					list($get_group_id, $get_group_title) = $row_groups;

					$query_items = "SELECT item_id, item_recipe_id, item_group_id, item_amount, item_measurement, item_grocery, item_grocery_explanation, item_food_id, item_calories_per_hundred, item_fat_per_hundred, item_fat_of_which_saturated_fatty_acids_per_hundred, item_carbs_per_hundred, item_carbs_of_which_dietary_fiber_hundred, item_carbs_of_which_sugars_per_hundred, item_proteins_per_hundred, item_salt_per_hundred, item_sodium_per_hundred, item_calories_calculated, item_fat_calculated, item_fat_of_which_saturated_fatty_acids_calculated, item_carbs_calculated, item_carbs_of_which_dietary_fiber_calculated, item_carbs_of_which_sugars_calculated, item_proteins_calculated, item_salt_calculated, item_sodium_calculated FROM $t_recipes_items WHERE item_group_id=$get_group_id";
					$result_items = mysqli_query($link, $query_items);
					$row_cnt = mysqli_num_rows($result_items);
					while($row_items = mysqli_fetch_row($result_items)) {
						list($get_item_id, $get_item_recipe_id, $get_item_group_id, $get_item_amount, $get_item_measurement, $get_item_grocery, $get_item_grocery_explanation, $get_item_food_id, $get_item_calories_per_hundred, $get_item_fat_per_hundred, $get_item_fat_of_which_saturated_fatty_acids_per_hundred, $get_item_carbs_per_hundred, $get_item_carbs_of_which_dietary_fiber_hundred, $get_item_carbs_of_which_sugars_per_hundred, $get_item_proteins_per_hundred, $get_item_salt_per_hundred, $get_item_sodium_per_hundred, $get_item_calories_calculated, $get_item_fat_calculated, $get_item_fat_of_which_saturated_fatty_acids_calculated, $get_item_carbs_calculated, $get_item_carbs_of_which_dietary_fiber_calculated, $get_item_carbs_of_which_sugars_calculated, $get_item_proteins_calculated, $get_item_salt_calculated, $get_item_sodium_calculated) = $row_items;

						$inp_number_hundred_calories 				= $inp_number_hundred_calories+$get_item_calories_per_hundred;
						$inp_number_hundred_proteins 				= $inp_number_hundred_proteins+$get_item_proteins_per_hundred;
						$inp_number_hundred_fat      				= $inp_number_hundred_fat+$get_item_fat_per_hundred;
						$inp_number_hundred_fat_of_which_saturated_fatty_acids 	= $inp_number_hundred_fat_of_which_saturated_fatty_acids+$get_item_fat_of_which_saturated_fatty_acids_per_hundred;
						$inp_number_hundred_carbs    				= $inp_number_hundred_carbs+$get_item_carbs_per_hundred;
						$inp_number_hundred_carbs_of_which_dietary_fiber 	= $inp_number_hundred_carbs_of_which_dietary_fiber+$get_item_carbs_of_which_dietary_fiber_hundred;
						$inp_number_hundred_carbs_of_which_sugars 		= $inp_number_hundred_carbs_of_which_sugars+$get_item_carbs_of_which_sugars_per_hundred;
						$inp_number_hundred_salt 				= $inp_number_hundred_salt+$get_item_salt_per_hundred;
						$inp_number_hundred_sodium 				= $inp_number_hundred_sodium+$get_item_sodium_per_hundred;
					
						$inp_number_total_weight     = $inp_number_total_weight+$get_item_amount;

						$inp_number_total_calories 				= $inp_number_total_calories+$get_item_calories_calculated;
						$inp_number_total_proteins 				= $inp_number_total_proteins+$get_item_proteins_calculated;
						$inp_number_total_fat     				= $inp_number_total_fat+$get_item_fat_calculated;
						$inp_number_total_fat_of_which_saturated_fatty_acids 	= $inp_number_total_fat_of_which_saturated_fatty_acids+$get_item_fat_of_which_saturated_fatty_acids_calculated;
						$inp_number_total_carbs    				= $inp_number_total_carbs+$get_item_carbs_calculated;
						$inp_number_total_carbs_of_which_dietary_fiber 		= $inp_number_total_carbs_of_which_dietary_fiber+$get_item_carbs_of_which_dietary_fiber_calculated;
						$inp_number_total_carbs_of_which_sugars 		= $inp_number_total_carbs_of_which_sugars+$get_item_carbs_of_which_sugars_calculated;
						$inp_number_total_salt 					= $inp_number_total_salt+$get_item_salt_calculated;
						$inp_number_total_sodium				= $inp_number_total_salt+$get_item_sodium_calculated;
	
					} // items
				} // groups
					
				

	
				// Numbers : Per hundred
				$inp_number_hundred_calories_mysql 				= quote_smart($link, $inp_number_hundred_calories);
				$inp_number_hundred_proteins_mysql 				= quote_smart($link, $inp_number_hundred_proteins);
				$inp_number_hundred_fat_mysql      				= quote_smart($link, $inp_number_hundred_fat);
				$inp_number_hundred_fat_of_which_saturated_fatty_acids_mysql 	= quote_smart($link, $inp_number_hundred_fat_of_which_saturated_fatty_acids);
				$inp_number_hundred_carbs_mysql   				= quote_smart($link, $inp_number_hundred_carbs);
				$inp_number_hundred_carbs_of_which_dietary_fiber_mysql 		= quote_smart($link, $inp_number_hundred_carbs_of_which_dietary_fiber);
				$inp_number_hundred_carbs_of_which_sugars_mysql			= quote_smart($link, $inp_number_hundred_carbs_of_which_sugars);
				$inp_number_hundred_salt_mysql					= quote_smart($link, $inp_number_hundred_salt);
				$inp_number_hundred_sodium_mysql				= quote_smart($link, $inp_number_hundred_sodium);
					
				// Numbers : Total 
				$inp_number_total_weight_mysql     = quote_smart($link, $inp_number_total_weight);

				$inp_number_total_calories_mysql 				= quote_smart($link, $inp_number_total_calories);
				$inp_number_total_proteins_mysql 				= quote_smart($link, $inp_number_total_proteins);
				$inp_number_total_fat_mysql      				= quote_smart($link, $inp_number_total_fat);
				$inp_number_total_fat_of_which_saturated_fatty_acids_mysql	= quote_smart($link, $inp_number_total_fat_of_which_saturated_fatty_acids);
				$inp_number_total_carbs_mysql    				= quote_smart($link, $inp_number_total_carbs);
				$inp_number_total_carbs_of_which_dietary_fiber_mysql    	= quote_smart($link, $inp_number_total_carbs_of_which_dietary_fiber);
				$inp_number_total_carbs_of_which_sugars_mysql    		= quote_smart($link, $inp_number_total_carbs_of_which_sugars);
				$inp_number_total_salt_mysql    				= quote_smart($link, $inp_number_total_salt);
				$inp_number_total_sodium_mysql    				= quote_smart($link, $inp_number_total_sodium);

				// Numbers : Per serving
				$inp_number_serving_calories = round($inp_number_total_calories/$get_number_servings);
				$inp_number_serving_calories_mysql = quote_smart($link, $inp_number_serving_calories);

				$inp_number_serving_proteins = round($inp_number_total_proteins/$get_number_servings);
				$inp_number_serving_proteins_mysql = quote_smart($link, $inp_number_serving_proteins);

				$inp_number_serving_fat		= round($inp_number_total_fat/$get_number_servings);
				$inp_number_serving_fat_mysql   = quote_smart($link, $inp_number_serving_fat);

				$inp_number_serving_fat_of_which_saturated_fatty_acids		= round($inp_number_hundred_fat_of_which_saturated_fatty_acids/$get_number_servings);
				$inp_number_serving_fat_of_which_saturated_fatty_acids_mysql 	= quote_smart($link, $inp_number_serving_fat_of_which_saturated_fatty_acids);

				$inp_number_serving_carbs    = round($inp_number_total_carbs/$get_number_servings);
				$inp_number_serving_carbs_mysql    = quote_smart($link, $inp_number_serving_carbs);

				$inp_number_serving_carbs_of_which_dietary_fiber = round($inp_number_serving_carbs_of_which_dietary_fiber/$get_number_servings);
				$inp_number_serving_carbs_of_which_dietary_fiber_mysql 	= quote_smart($link, $inp_number_serving_carbs_of_which_dietary_fiber); 

				$inp_number_serving_carbs_of_which_sugars 		= round($inp_number_serving_carbs_of_which_sugars /$get_number_servings);
				$inp_number_serving_carbs_of_which_sugars_mysql 	= quote_smart($link, $inp_number_serving_carbs_of_which_sugars); 

				$inp_number_serving_salt 	= round($inp_number_serving_salt/$get_number_servings);
				$inp_number_serving_salt_mysql 	= quote_smart($link, $inp_number_serving_salt); 

				$inp_number_serving_sodium 	 = round($inp_number_serving_sodium/$get_number_servings);
				$inp_number_serving_sodium_mysql = quote_smart($link, $inp_number_serving_sodium); 



				$result = mysqli_query($link, "UPDATE $t_recipes_numbers SET 
					number_hundred_calories=$inp_number_hundred_calories_mysql, 
					number_hundred_proteins=$inp_number_hundred_proteins_mysql, 
					number_hundred_fat=$inp_number_hundred_fat_mysql, 
					number_hundred_fat_of_which_saturated_fatty_acids=$inp_number_hundred_fat_of_which_saturated_fatty_acids_mysql,
					number_hundred_carbs=$inp_number_hundred_carbs_mysql, 
					number_hundred_carbs_of_which_dietary_fiber=$inp_number_hundred_carbs_of_which_dietary_fiber_mysql,
					number_hundred_carbs_of_which_sugars=$inp_number_hundred_carbs_of_which_sugars_mysql,
					number_hundred_salt=$inp_number_hundred_salt_mysql,
					number_hundred_sodium=$inp_number_hundred_sodium_mysql,

					number_serving_calories=$inp_number_serving_calories_mysql, 
					number_serving_proteins=$inp_number_serving_proteins_mysql, 
					number_serving_fat=$inp_number_serving_fat_mysql, 
					number_serving_fat_of_which_saturated_fatty_acids=$inp_number_serving_fat_of_which_saturated_fatty_acids_mysql,
					number_serving_carbs=$inp_number_serving_carbs_mysql,
					number_serving_carbs_of_which_dietary_fiber=$inp_number_serving_carbs_of_which_dietary_fiber_mysql, 
					number_serving_carbs_of_which_sugars=$inp_number_serving_carbs_of_which_sugars_mysql, 
					number_serving_salt=$inp_number_serving_salt_mysql,
					number_serving_sodium=$inp_number_serving_sodium_mysql,

					number_total_weight=$inp_number_total_weight_mysql, 
					number_total_calories=$inp_number_total_calories_mysql, 
					number_total_proteins=$inp_number_total_proteins_mysql, 
					number_total_fat=$inp_number_total_fat_mysql, 
					number_total_fat_of_which_saturated_fatty_acids=$inp_number_serving_fat_of_which_saturated_fatty_acids_mysql,
					number_total_carbs=$inp_number_total_carbs_mysql,
					number_total_carbs_of_which_dietary_fiber=$inp_number_serving_carbs_of_which_dietary_fiber_mysql,
					number_total_carbs_of_which_sugars=$inp_number_serving_carbs_of_which_sugars_mysql, 
					number_total_salt=$inp_number_serving_salt_mysql, 
					number_total_sodium=$inp_number_serving_sodium_mysql
					 WHERE number_recipe_id=$recipe_id_mysql") or die(mysqli_error($link));



					// Header
					$ft = "success";
					$fm = "changes_saved";

					$url = "edit_recipe_ingredients.php?recipe_id=$get_recipe_id&action=edit_item&group_id=$group_id&item_id=$item_id&l=$l";
					$url = $url . "&ft=$ft&fm=$fm";
					header("Location: $url");
					exit;	
				}

				echo"
				<h1>$get_recipe_title</h1>


				<!-- You are here -->
					<p>
					<b>$l_you_are_here:</b><br />
					<a href=\"index.php?l=$l\">$l_recipes</a>
					&gt;
					<a href=\"my_recipes.php?l=$l#recipe_id=$recipe_id\">$l_my_recipes</a>
					&gt;
					<a href=\"view_recipe.php?recipe_id=$recipe_id&amp;l=$l\">$get_recipe_title</a>
					&gt;
					<a href=\"edit_recipe_ingredients.php?recipe_id=$recipe_id&amp;l=$l\">$l_ingredients</a>
					</p>
				<!-- //You are here -->

				<!-- Menu -->
					<div class=\"tabs\">
						<ul>
							<li><a href=\"edit_recipe.php?recipe_id=$recipe_id&amp;l=$l\">$l_general</a>
							<li><a href=\"edit_recipe_ingredients.php?recipe_id=$recipe_id&amp;l=$l\" class=\"active\">$l_ingredients</a>
							<li><a href=\"edit_recipe_categorization.php?recipe_id=$recipe_id&amp;l=$l\">$l_categorization</a>
							<li><a href=\"edit_recipe_image.php?recipe_id=$recipe_id&amp;l=$l\">$l_image</a>
							<li><a href=\"edit_recipe_video.php?recipe_id=$recipe_id&amp;l=$l\">$l_video</a>
						</ul>
					</div><p>&nbsp;</p>
				<!-- //Menu -->

				<h2>$l_edit_ingredients</h2>

				<h3>$get_group_title</h3>


				<!-- Feedback -->
				";
				if($ft != ""){
					if($fm == "changes_saved"){
						$fm = "$l_changes_saved";
					}
					elseif($fm == "amound_cant_be_empty"){
						$fm = "$l_amound_cant_be_empty";
					}
					elseif($fm == "amound_has_to_be_a_number"){
						$fm = "$l_amound_has_to_be_a_number";
					}
					elseif($fm == "measurement_cant_be_empty"){
						$fm = "$l_measurement_cant_be_empty";
					}
					elseif($fm == "grocery_cant_be_empty"){
						$fm = "$l_grocery_cant_be_empty";
					}
					elseif($fm == "calories_cant_be_empty"){
						$fm = "$l_calories_cant_be_empty";
					}
					elseif($fm == "proteins_cant_be_empty"){
						$fm = "$l_proteins_cant_be_empty";
					}
					elseif($fm == "fat_cant_be_empty"){
						$fm = "$l_fat_cant_be_empty";
					}
					elseif($fm == "carbs_cant_be_empty"){
						$fm = "$l_carbs_cant_be_empty";
					}
					elseif($fm == "calories_have_to_be_a_number"){
						$fm = "$l_calories_have_to_be_a_number";
					}
					elseif($fm == "proteins_have_to_be_a_number"){
						$fm = "$l_proteins_have_to_be_a_number";
					}
					elseif($fm == "carbs_have_to_be_a_number"){
						$fm = "$l_carbs_have_to_be_a_number";
					}
					elseif($fm == "fat_have_to_be_a_number"){
						$fm = "$l_fat_have_to_be_a_number";
					}
					else{
						$fm = ucfirst($fm);
					}
					echo"<div class=\"$ft\"><span>$fm</span></div>";
				}
				echo"	
				<!-- //Feedback -->

				<!-- Edit item -->
					<!-- Focus -->
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_item_amount\"]').focus();
						});
						</script>
					<!-- //Focus -->
					

				
					<form method=\"post\" action=\"edit_recipe_ingredients.php?action=$action&amp;recipe_id=$get_recipe_id&amp;group_id=$get_group_id&amp;item_id=$get_item_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
		
					<h2 style=\"padding-bottom:0;margin-bottom:0;\">$l_food</h2>
					<table>
					 <tbody>
					  <tr>
					   <td style=\"padding: 0px 20px 0px 0px;\">
						<p>$l_amount<br />
						<input type=\"text\" name=\"inp_item_amount\" id=\"inp_item_amount\" size=\"3\" value=\"$get_item_amount\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
						</p>
					   </td>
					   <td>
						<p>$l_measurement<br />
						<input type=\"text\" name=\"inp_item_measurement\" size=\"3\" value=\"$get_item_measurement\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
						</p>
					   </td>
					  </tr>
					</table>
					<p>$l_grocery &middot; <a href=\"$root/food/new_food.php?l=$l\" target=\"_blank\">$l_new_food</a><br />

					<input type=\"text\" name=\"inp_item_grocery\" class=\"inp_item_grocery\" id=\"inp_item_grocery\" size=\"25\" value=\"$get_item_grocery\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
					<input type=\"hidden\" name=\"inp_item_food_id\" id=\"inp_item_food_id\" /></p>

					<div id=\"nettport_search_results\">
					</div><div class=\"clear\"></div></span>

					<!-- Special character replacer -->
						<script>

						\$(document).ready(function(){
							window.setInterval(function(){
								var inp_item_grocery = \$(\".inp_item_grocery\").val();
								var inp_item_grocery = inp_item_grocery.replace(\"&aring;\", \"å\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&aelig;\", \"æ\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&Aring;\", \"Å\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&Aelig;\", \"Æ\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#192;\", \"À\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#193;\", \"Á\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#194;\", \"Â\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#195;\", \"Ã\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#196;\", \"Ä\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#197;\", \"Å\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#198;\", \"Æ\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#199;\", \"Ç\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#200;\", \"È\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#201;\", \"É\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#202;\", \"Ê\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#203;\", \"Ë\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#204;\", \"Ì\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#205;\", \"Í\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#206;\", \"Î\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#207;\", \"Ï\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#208;\", \"Ð\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#209;\", \"Ñ\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#210;\", \"Ò\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#211;\", \"Ó\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#212;\", \"Ô\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#213;\", \"Õ\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#214;\", \"Ö\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#215;\", \"×\");   
								var inp_item_grocery = inp_item_grocery.replace(\"&#216;\", \"Ø\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&Oslash;\", \"Ø\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&oslash;\", \"ø\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#217;\", \"Ù\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#218;\", \"Ú\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#219;\", \"Û\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#220;\", \"Ü\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#221;\", \"Ý\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#222;\", \"Þ\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#223;\", \"ß\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#224;\", \"à\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#225;\", \"á\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#226;\", \"â\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#227;\", \"ã\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#228;\", \"ä\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#229;\", \"å\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#230;\", \"æ\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#231;\", \"ç\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#232;\", \"è\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#233;\", \"é\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#234;\", \"ê\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#235;\", \"ë\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#236;\", \"ì\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#237;\", \"í\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#238;\", \"î\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#239;\", \"ï\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#240;\", \"ð\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#241;\", \"ñ\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&ntilde;\", \"ñ\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#242;\", \"ò\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#243;\", \"ó\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#244;\", \"ô\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#245;\", \"õ\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#246;\", \"ö\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#247;\", \"÷\");  
								var inp_item_grocery = inp_item_grocery.replace(\"&#248;\", \"ø\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#249;\", \"ù\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#250;\", \"ú\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#251;\", \"û\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#252;\", \"ü\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#253;\", \"ý\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#254;\", \"þ\"); 
								var inp_item_grocery = inp_item_grocery.replace(\"&#255;\", \"ÿ\"); 

								\$(\"#inp_item_grocery\").val(inp_item_grocery);
								
							}, 1000);

							
						});
						</script>

					<!-- //Special character replacer -->

					<h2 style=\"padding-bottom:0;margin-bottom:0;\">$l_numbers</h2>
					<table class=\"hor-zebra\" style=\"width: 350px\">
					 <thead>
					  <tr>
					   <th scope=\"col\">
					   </th>";
				if($get_recipe_country != "United States"){
					echo"
					   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;vertical-align: bottom;\">
						<span>$l_per_hundred</span>
					   </th>
					";
				}
				echo"
					   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;vertical-align: bottom;\">
						<span>$l_calculated</span>
					   </th>
					  </tr>
					 </thead>
					 <tbody>
					  <tr>
					   <td style=\"padding: 8px 4px 6px 8px;\">
						<span>$l_calories</span>
					   </td>";
					if($get_recipe_country != "United States"){
						echo"
						   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
							<span><input type=\"text\" name=\"inp_item_calories_per_hundred\" id=\"inp_item_calories_per_hundred\" size=\"5\" value=\"$get_item_calories_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></span>
						   </td>";
					}
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span><input type=\"text\" name=\"inp_item_calories_calculated\" id=\"inp_item_calories_calculated\" size=\"5\" value=\"$get_item_calories_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></span>
					   </td>
					  </tr>
					  <tr>
					   <td style=\"padding: 8px 4px 6px 8px;\">
						<p style=\"margin:0;padding: 0px 0px 4px 0px;\">$l_fat</p>
						<p style=\"margin:0;padding: 0;\">$l_dash_of_which_saturated_fatty_acids</p>
					   </td>";
					if($get_recipe_country != "United States"){
						echo"
					 	  <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
							<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_item_fat_per_hundred\" id=\"inp_item_fat_per_hundred\" size=\"5\" value=\"$get_item_fat_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
							<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_item_fat_of_which_saturated_fatty_acids_per_hundred\" id=\"inp_item_fat_of_which_saturated_fatty_acids_per_hundred\" size=\"5\" value=\"$get_item_fat_of_which_saturated_fatty_acids_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
						   </td>";
						}
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_item_fat_calculated\" id=\"inp_item_fat_calculated\" size=\"5\" value=\"$get_item_fat_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
						<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_item_fat_of_which_saturated_fatty_acids_calculated\" id=\"inp_item_fat_of_which_saturated_fatty_acids_calculated\" size=\"5\" value=\"$get_item_fat_of_which_saturated_fatty_acids_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
					   </td>
					  </tr>
					  <tr>
		 			  <td style=\"padding: 8px 4px 6px 8px;\">
						<p style=\"margin:0;padding: 0px 0px 4px 0px;\">$l_carbs</p>
						<p style=\"margin:0;padding: 0;\">$l_dash_of_which_sugars_calculated</p>
					   </td>";
					if($get_recipe_country != "United States"){
						echo"
					 	  <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
							<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_item_carbs_per_hundred\" id=\"inp_item_carbs_per_hundred\" size=\"5\" value=\"$get_item_carbs_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
							<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_item_carbs_of_which_sugars_per_hundred\" id=\"inp_item_carbs_of_which_sugars_per_hundred\" size=\"5\" value=\"$get_item_carbs_of_which_sugars_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
						   </td>";
						}
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_item_carbs_calculated\" id=\"inp_item_carbs_calculated\" size=\"5\" value=\"$get_item_carbs_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
						<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_item_carbs_of_which_sugars_calculated\" id=\"inp_item_carbs_of_which_sugars_calculated\" size=\"5\" value=\"$get_item_carbs_of_which_sugars_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
					   </td>
					  </tr>


					 <tr>
		 			  <td style=\"padding: 8px 4px 6px 8px;\">
						<p style=\"margin:0;padding: 0;\">$l_dietary_fiber</p>
					   </td>";
					if($get_recipe_country != "United States"){
						echo"
					 	  <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
							<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_item_carbs_of_which_dietary_fiber_per_hundred\" id=\"inp_item_carbs_of_which_dietary_fiber_per_hundred\" size=\"5\" value=\"$get_item_carbs_of_which_dietary_fiber_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
						   </td>";
						}
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_item_carbs_of_which_dietary_fiber_calculated\" id=\"inp_item_carbs_of_which_dietary_fiber_calculated\" size=\"5\" value=\"$get_item_carbs_of_which_dietary_fiber_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
					   </td>
					  </tr>

					  <tr>
					   <td style=\"padding: 8px 4px 6px 8px;\">
						<span>$l_proteins</span>
					   </td>";
					if($get_recipe_country != "United States"){
						echo"
						   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
							<span><input type=\"text\" name=\"inp_item_proteins_per_hundred\" id=\"inp_item_proteins_per_hundred\" size=\"5\" value=\"$get_item_proteins_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></span>
					 	  </td>";
						}
					echo"
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span><input type=\"text\" name=\"inp_item_proteins_calculated\" id=\"inp_item_proteins_calculated\" size=\"5\" value=\"$get_item_proteins_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></span>
					   </td>
					  </tr>";
					if($get_recipe_country == "United States"){
						echo"
						 <tr>
					 	  <td style=\"padding: 8px 4px 6px 8px;\">
							<span>$l_sodium_in_mg</span>
					 	   </td>
						   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
							<span><input type=\"text\" name=\"inp_item_sodium_calculated\" id=\"inp_item_sodium_calculated\" value=\"$get_item_sodium_calculated\" size=\"5\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></span>
					 	  </td>
						  </tr>
						";
					}
					else{
						echo"
						 <tr>
					 	  <td style=\"padding: 8px 4px 6px 8px;\">
							<span>$l_salt_in_gram</span>
					 	  </td>
					 	  <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
							<span><input type=\"text\" name=\"inp_item_salt_per_hundred\" id=\"inp_item_salt_per_hundred\" value=\"$get_item_salt_per_hundred\" size=\"5\" /></span>
						   </td>
						   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
							<span><input type=\"text\" name=\"inp_item_salt_calculated\" id=\"inp_item_salt_calculated\" value=\"$get_item_salt_calculated\" size=\"5\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></span>
					 	  </td>
						  </tr>
						";
					}
					echo"
					 </tbody>
					</table>

					<p>
					<input type=\"submit\" value=\"$l_save\" class=\"btn\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
					</p>


					</form>
					<!-- Search script -->
					<script id=\"source\" language=\"javascript\" type=\"text/javascript\">
					\$(document).ready(function () {
						\$('#inp_item_grocery').keyup(function () {
							$(\"#nettport_search_results\").show();
       							// getting the value that user typed
       							var searchString    = $(\"#inp_item_grocery\").val();
 							// forming the queryString
      							var data            = 'l=$l&recipe_id=$recipe_id&q='+ searchString;

        						// if searchString is not empty
        						if(searchString) {
           							// ajax call
            							\$.ajax({
                							type: \"POST\",
               								url: \"submit_recipe_step_2_group_and_elements_search_jquery.php\",
                							data: data,
									beforeSend: function(html) { // this happens before actual call
										\$(\"#nettport_search_results\").html(''); 
									},
               								success: function(html){
                    								\$(\"#nettport_search_results\").append(html);
              								}
            							});
       							}
        						return false;
            					});
         				   });
					</script>
					<!-- //Search script -->
				<!-- //Edit item -->

				<!-- Buttons -->
					<p>
					<a href=\"edit_recipe_ingredients.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"btn btn_default\">$l_add_another_group</a>
					</p>
				<!-- //Buttons -->
				";

			} // item found

		} // group found

	} // action == "edit_item")
	elseif($action == "delete_item"){

		// Get group

		$group_id_mysql = quote_smart($link, $group_id);

		$query = "SELECT group_id, group_recipe_id, group_title FROM $t_recipes_groups WHERE group_id=$group_id_mysql AND group_recipe_id=$get_recipe_id";

		$result = mysqli_query($link, $query);

		$row = mysqli_fetch_row($result);

		list($get_group_id, $get_group_recipe_id, $get_group_title) = $row;



		if($get_group_id == ""){

			echo"

			<h1>Server error</h1>



			<p>

			Group not found.

			</p>

			";

		}

		else{

			// Get item

			$item_id_mysql = quote_smart($link, $item_id);

			$query = "SELECT item_id, item_recipe_id, item_group_id, item_amount, item_measurement, item_grocery, item_calories_per_hundred, item_proteins_per_hundred, item_fat_per_hundred, item_carbs_per_hundred, item_calories_calculated, item_proteins_calculated, item_fat_calculated, item_carbs_calculated FROM $t_recipes_items WHERE item_id=$item_id_mysql AND item_recipe_id=$get_recipe_id AND item_group_id=$get_group_id";

			$result = mysqli_query($link, $query);

			$row = mysqli_fetch_row($result);

			list($get_item_id, $get_item_recipe_id, $get_item_group_id, $get_item_amount, $get_item_measurement, $get_item_grocery, $get_item_calories_per_hundred, $get_item_proteins_per_hundred, $get_item_fat_per_hundred, $get_item_carbs_per_hundred, $get_item_calories_calculated, $get_item_proteins_calculated, $get_item_fat_calculated, $get_item_carbs_calculated) = $row;





			if($get_item_id == ""){

				echo"

				<h1>Server error</h1>



				<p>

				Items not found.

				</p>

				";

			}

			else{



				if($process == "1"){

					



					// Delete

					$result = mysqli_query($link, "DELETE FROM $t_recipes_items WHERE item_id=$get_item_id");



			



					// Calculating total numbers

					$inp_number_hundred_calories = 0;

					$inp_number_hundred_proteins = 0;

					$inp_number_hundred_fat = 0;

					$inp_number_hundred_carbs = 0;

					

					$inp_number_serving_calories = 0;

					$inp_number_serving_proteins = 0;

					$inp_number_serving_fat = 0;

					$inp_number_serving_carbs = 0;

					

					$inp_number_total_weight = 0;

	

					$inp_number_total_calories = 0;

					$inp_number_total_proteins = 0;

					$inp_number_total_fat = 0;



					$inp_number_total_carbs = 0;

					

					$query_groups = "SELECT group_id, group_title FROM $t_recipes_groups WHERE group_recipe_id=$get_recipe_id";

					$result_groups = mysqli_query($link, $query_groups);

					while($row_groups = mysqli_fetch_row($result_groups)) {

						list($get_group_id, $get_group_title) = $row_groups;



						$query_items = "SELECT item_id, item_amount, item_calories_per_hundred, item_proteins_per_hundred, item_fat_per_hundred, item_carbs_per_hundred, item_calories_calculated, item_proteins_calculated, item_fat_calculated, item_carbs_calculated FROM $t_recipes_items WHERE item_group_id=$get_group_id";

						$result_items = mysqli_query($link, $query_items);

						$row_cnt = mysqli_num_rows($result_items);

						while($row_items = mysqli_fetch_row($result_items)) {

							list($get_item_id, $get_item_amount, $get_item_calories_per_hundred, $get_item_proteins_per_hundred, $get_item_fat_per_hundred, $get_item_carbs_per_hundred, $get_item_calories_calculated, $get_item_proteins_calculated, $get_item_fat_calculated, $get_item_carbs_calculated) = $row_items;



							$inp_number_hundred_calories = $inp_number_hundred_calories+$get_item_calories_per_hundred;

							$inp_number_hundred_proteins = $inp_number_hundred_proteins+$get_item_proteins_per_hundred;

							$inp_number_hundred_fat      = $inp_number_hundred_fat+$get_item_fat_per_hundred;

							$inp_number_hundred_carbs    = $inp_number_hundred_carbs+$get_item_carbs_per_hundred;

					

							$inp_number_total_weight     = $inp_number_total_weight+$get_item_amount;



							$inp_number_total_calories = $inp_number_total_calories+$get_item_calories_calculated;

							$inp_number_total_proteins = $inp_number_total_proteins+$get_item_proteins_calculated;

							$inp_number_total_fat      = $inp_number_total_fat+$get_item_fat_calculated;

							$inp_number_total_carbs    = $inp_number_total_carbs+$get_item_carbs_calculated;

	

						} // items

					} // groups

					

					$inp_number_serving_calories = round($inp_number_total_calories/$get_number_servings);

					$inp_number_serving_proteins = round($inp_number_total_proteins/$get_number_servings);

					$inp_number_serving_fat      = round($inp_number_total_fat/$get_number_servings);

					$inp_number_serving_carbs    = round($inp_number_total_carbs/$get_number_servings);



	

					// Ready numbers for MySQL

					$inp_number_hundred_calories_mysql = quote_smart($link, $inp_number_hundred_calories);

					$inp_number_hundred_proteins_mysql = quote_smart($link, $inp_number_hundred_proteins);

					$inp_number_hundred_fat_mysql      = quote_smart($link, $inp_number_hundred_fat);

					$inp_number_hundred_carbs_mysql    = quote_smart($link, $inp_number_hundred_carbs);

					

					$inp_number_total_weight_mysql     = quote_smart($link, $inp_number_total_weight);



					$inp_number_total_calories_mysql = quote_smart($link, $inp_number_total_calories);

					$inp_number_total_proteins_mysql = quote_smart($link, $inp_number_total_proteins);

					$inp_number_total_fat_mysql      = quote_smart($link, $inp_number_total_fat);

					$inp_number_total_carbs_mysql    = quote_smart($link, $inp_number_total_carbs);



						

					$inp_number_serving_calories_mysql = quote_smart($link, $inp_number_serving_calories);

					$inp_number_serving_proteins_mysql = quote_smart($link, $inp_number_serving_proteins);

					$inp_number_serving_fat_mysql      = quote_smart($link, $inp_number_serving_fat);

					$inp_number_serving_carbs_mysql    = quote_smart($link, $inp_number_serving_carbs);



					$result = mysqli_query($link, "UPDATE $t_recipes_numbers SET number_hundred_calories=$inp_number_hundred_calories_mysql, number_hundred_proteins=$inp_number_hundred_proteins_mysql, number_hundred_fat=$inp_number_hundred_fat_mysql, number_hundred_carbs=$inp_number_hundred_carbs_mysql, 

								number_serving_calories=$inp_number_serving_calories_mysql, number_serving_proteins=$inp_number_serving_proteins_mysql, number_serving_fat=$inp_number_serving_fat_mysql, number_serving_carbs=$inp_number_serving_carbs_mysql,

								number_total_weight=$inp_number_total_weight_mysql, 

								number_total_calories=$inp_number_total_calories_mysql, number_total_proteins=$inp_number_total_proteins_mysql, number_total_fat=$inp_number_total_fat_mysql, number_total_carbs=$inp_number_total_carbs_mysql WHERE number_recipe_id=$recipe_id_mysql");



	



					// Header

					$ft = "success";

					$fm = "item_deleted";



					$url = "edit_recipe_ingredients.php?recipe_id=$get_recipe_id&l=$l";

					$url = $url . "&ft=$ft&fm=$fm";

					header("Location: $url");

					exit;	



				



				}
				echo"
				<h1>$get_recipe_title</h1>





				<!-- Menu -->

					<div class=\"tabs\">
					<ul>
						<li><a href=\"edit_recipe.php?recipe_id=$recipe_id&amp;l=$l\">$l_general</a>
						<li><a href=\"edit_recipe_ingredients.php?recipe_id=$recipe_id&amp;l=$l\" class=\"active\">$l_ingredients</a>
						<li><a href=\"edit_recipe_categorization.php?recipe_id=$recipe_id&amp;l=$l\">$l_categorization</a>
						<li><a href=\"edit_recipe_image.php?recipe_id=$recipe_id&amp;l=$l\">$l_image</a>
						<li><a href=\"edit_recipe_video.php?recipe_id=$recipe_id&amp;l=$l\">$l_video</a>
					</ul>
					</div><p>&nbsp;</p>
				<!-- //Menu -->



				<h2>$l_delete_ingredients</h2>

				<h3>$get_group_title - $get_item_grocery</h3>


				<!-- Delete item -->
					<p>
					$l_are_you_sure_you_want_to_delete
					$l_the_action_cant_be_undone
					</p>


					<p>
					<a href=\"edit_recipe_ingredients.php?action=$action&amp;recipe_id=$get_recipe_id&amp;group_id=$get_group_id&amp;item_id=$get_item_id&amp;l=$l&amp;process=1\" class=\"btn btn_warning\">$l_delete</a>			

					<a href=\"edit_recipe_ingredients.php?&amp;recipe_id=$get_recipe_id&amp;group_id=$get_group_id&amp;item_id=$get_item_id&amp;l=$l\" class=\"btn btn_default\">$l_cancel</a>		

					</p>
				<!-- //Edit item -->

				";

			} // item found
		} // group found
	} // action == "delete_item")

	elseif($action == "add_group"){



		if($process == 1){

			$inp_group_title = $_POST['inp_group_title'];

			$inp_group_title = output_html($inp_group_title);

			$inp_group_title_mysql = quote_smart($link, $inp_group_title);



			if(empty($inp_group_title)){

				$ft = "error";

				$fm = "group_title_cant_be_empty";

				$url = "edit_recipe_ingredients.php?recipe_id=$get_recipe_id&l=$l&ft=$ft&fm=$fm";

				header("Location: $url");

				exit;

			}

			

			// Does that group already exists?

			$query = "SELECT group_id, group_recipe_id, group_title FROM $t_recipes_groups WHERE group_recipe_id=$get_recipe_id AND group_title=$inp_group_title_mysql";

			$result = mysqli_query($link, $query);

			$row = mysqli_fetch_row($result);

			list($get_group_id, $get_group_recipe_id, $get_group_title) = $row;



			if($get_group_id != ""){

				$ft = "error";

				$fm = "you_already_have_a_group_with_that_name";

				$url = "edit_recipe_ingredients.php?recipe_id=$get_recipe_id&l=$l&ft=$ft&fm=$fm";

				header("Location: $url");

				exit;

			}





			// Insert

			mysqli_query($link, "INSERT INTO $t_recipes_groups

			(group_id, group_recipe_id, group_title) 

			VALUES 

			(NULL, '$get_recipe_id', $inp_group_title_mysql)")

			or die(mysqli_error($link));

			

			// Get group ID

			$query = "SELECT group_id, group_recipe_id, group_title FROM $t_recipes_groups WHERE group_recipe_id=$get_recipe_id AND group_title=$inp_group_title_mysql";

			$result = mysqli_query($link, $query);

			$row = mysqli_fetch_row($result);

			list($get_group_id, $get_group_recipe_id, $get_group_title) = $row;





			// Header

			$url = "edit_recipe_ingredients.php?recipe_id=$get_recipe_id&action=add_items&group_id=$get_group_id&l=$l";

			header("Location: $url");

			exit;

		}





		echo"

		<h1>$l_add_another_group</h1>

	

		

		<!-- Menu -->

		<div class=\"tabs\">

			<ul>

				<li><a href=\"edit_recipe.php?recipe_id=$recipe_id&amp;l=$l\">$l_general</a>

				<li><a href=\"edit_recipe_ingredients.php?recipe_id=$recipe_id&amp;l=$l\" class=\"active\">$l_ingredients</a>

				<li><a href=\"edit_recipe_categorization.php?recipe_id=$recipe_id&amp;l=$l\">$l_categorization</a>

				<li><a href=\"edit_recipe_image.php?recipe_id=$recipe_id&amp;l=$l\">$l_image</a>

				<li><a href=\"edit_recipe_video.php?recipe_id=$recipe_id&amp;l=$l\">$l_video</a>

				<li><a href=\"edit_recipe_tags.php?recipe_id=$recipe_id&amp;l=$l\">$l_tags</a></li>

				<li><a href=\"edit_recipe_links.php?recipe_id=$recipe_id&amp;l=$l\">$l_links</a></li>

			</ul>

		</div><p>&nbsp;</p>

		<!-- //Menu -->





		<!-- Focus -->

			<script>

			\$(document).ready(function(){

				\$('[name=\"inp_group_title\"]').focus();

			});

			</script>

		<!-- //Focus -->



		<!-- Feedback -->

			";

			if($ft != ""){

				if($fm == "changes_saved"){

					$fm = "$l_changes_saved";

				}

				elseif($fm == "group_title_cant_be_empty"){

					$fm = "$l_group_title_cant_be_empty";

				}

				elseif($fm == "you_already_have_a_group_with_that_name"){

					$fm = "$l_you_already_have_a_group_with_that_name";

				}

				else{

					$fm = ucfirst($fm);

				}

				echo"<div class=\"$ft\"><span>$fm</span></div>";

			}

			echo"	

		<!-- //Feedback -->



		<!-- Add group -->



			<form method=\"post\" action=\"edit_recipe_ingredients.php?action=add_group&amp;recipe_id=$get_recipe_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			



			<p><b>$l_ingredients_title:</b>

			<input type=\"text\" name=\"inp_group_title\" size=\"30\" value=\"\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />

			

			<input type=\"submit\" value=\"$l_create\" class=\"btn\" />

			</p>

			</form>

		<!-- //Add group -->



		<!-- Buttons -->

			<p style=\"margin-top: 20px;\">

			<a href=\"my_recipes.php?l=$l#recipe$recipe_id\" class=\"btn btn_default\">$l_my_recipes</a>

			<a href=\"view_recipe.php?recipe_id=$recipe_id&amp;l=$l\" class=\"btn btn_default\">$l_view_recipe</a>

			</p>

		<!-- //Buttons -->

		";

	}

	elseif($action == "add_items"){

		// Get group

		$group_id_mysql = quote_smart($link, $group_id);

		$query = "SELECT group_id, group_recipe_id, group_title FROM $t_recipes_groups WHERE group_id=$group_id_mysql AND group_recipe_id=$get_recipe_id";

		$result = mysqli_query($link, $query);

		$row = mysqli_fetch_row($result);

		list($get_group_id, $get_group_recipe_id, $get_group_title) = $row;



		if($get_group_id == ""){

			echo"

			<h1>Server error</h1>



			<p>

			Group not found.

			</p>

			";

		}

		else{

			if($process == "1"){
				$inp_item_amount = $_POST['inp_item_amount'];
				$inp_item_amount = output_html($inp_item_amount);
				$inp_item_amount = str_replace(",", ".", $inp_item_amount);
				$inp_item_amount_mysql = quote_smart($link, $inp_item_amount);
				if(empty($inp_item_amount)){
					$ft = "error";
					$fm = "amound_cant_be_empty";
				}
				else{
					if(!(is_numeric($inp_item_amount))){
						// Do we have math? Example 1/8 ts
						$check_for_fraction = explode("/", $inp_item_amount);

						if(isset($check_for_fraction[0]) && isset($check_for_fraction[1])){
							if(is_numeric($check_for_fraction[0]) && is_numeric($check_for_fraction[1])){
								$inp_item_amount = $check_for_fraction[0] / $check_for_fraction[1];
							}
							else{
								$ft = "error";
								$fm = "amound_has_to_be_a_number";
							}
						}
						else{
							$ft = "error";
							$fm = "amound_has_to_be_a_number";
						}
					}
				}

				$inp_item_measurement = $_POST['inp_item_measurement'];
				$inp_item_measurement = output_html($inp_item_measurement);
				$inp_item_measurement = str_replace(",", ".", $inp_item_measurement);
				$inp_item_measurement_mysql = quote_smart($link, $inp_item_measurement);
				if(empty($inp_item_measurement)){
					$ft = "error";
					$fm = "measurement_cant_be_empty";
				}

				$inp_item_grocery = $_POST['inp_item_grocery'];
				$inp_item_grocery = output_html($inp_item_grocery);
				$inp_item_grocery_mysql = quote_smart($link, $inp_item_grocery);
				if(empty($inp_item_grocery)){
					$ft = "error";
					$fm = "grocery_cant_be_empty";
				}

				$inp_item_food_id = $_POST['inp_item_food_id'];
				$inp_item_food_id = output_html($inp_item_food_id);
				if($inp_item_food_id == ""){
					$inp_item_food_id = "0";
				}
				$inp_item_food_id_mysql = quote_smart($link, $inp_item_food_id);

				$inp_item_calories_per_hundred = $_POST['inp_item_calories_per_hundred'];
				$inp_item_calories_per_hundred = output_html($inp_item_calories_per_hundred);
				$inp_item_calories_per_hundred = str_replace(",", ".", $inp_item_calories_per_hundred);
				if(empty($inp_item_calories_per_hundred)){
					$inp_item_calories_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_calories_per_hundred))){
						$ft = "error";
						$fm = "calories_have_to_be_a_number";
					}
				}
				$inp_item_calories_per_hundred = round($inp_item_calories_per_hundred, 0);
				$inp_item_calories_per_hundred_mysql = quote_smart($link, $inp_item_calories_per_hundred);


				$inp_item_calories_calculated = $_POST['inp_item_calories_calculated'];
				$inp_item_calories_calculated = output_html($inp_item_calories_calculated);
				$inp_item_calories_calculated = str_replace(",", ".", $inp_item_calories_calculated);
				if(empty($inp_item_calories_calculated)){
					$inp_item_calories_calculated = "0";
				}
				else{
					if(!(is_numeric($inp_item_calories_calculated))){
						$ft = "error";
						$fm = "calories_have_to_be_a_number";
					}
				}
				$inp_item_calories_calculated = round($inp_item_calories_calculated, 0);
				$inp_item_calories_calculated_mysql = quote_smart($link, $inp_item_calories_calculated);


				$inp_item_fat_per_hundred = $_POST['inp_item_fat_per_hundred'];
				$inp_item_fat_per_hundred = output_html($inp_item_fat_per_hundred);
				$inp_item_fat_per_hundred = str_replace(",", ".", $inp_item_fat_per_hundred);
				if(empty($inp_item_fat_per_hundred)){
					$inp_item_fat_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_calories_per_hundred))){
						$ft = "error";
						$fm = "fat_have_to_be_a_number";
					}
				}
				$inp_item_fat_per_hundred = round($inp_item_fat_per_hundred, 0);
				$inp_item_fat_per_hundred_mysql = quote_smart($link, $inp_item_fat_per_hundred);

				$inp_item_fat_calculated = $_POST['inp_item_fat_calculated'];
				$inp_item_fat_calculated = output_html($inp_item_fat_calculated);
				$inp_item_fat_calculated = str_replace(",", ".", $inp_item_fat_calculated);
				if(empty($inp_item_fat_calculated)){
					$inp_item_fat_calculated = "0";
				}
				else{
					if(!(is_numeric($inp_item_calories_calculated))){
						$ft = "error";
						$fm = "fat_have_to_be_a_number";
					}
				}
				$inp_item_fat_calculated = round($inp_item_fat_calculated, 0);
				$inp_item_fat_calculated_mysql = quote_smart($link, $inp_item_fat_calculated);


				$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = $_POST['inp_item_fat_of_which_saturated_fatty_acids_per_hundred'];
				$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = output_html($inp_item_fat_of_which_saturated_fatty_acids_per_hundred);
				$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = str_replace(",", ".", $inp_item_fat_of_which_saturated_fatty_acids_per_hundred);
				if(empty($inp_item_fat_of_which_saturated_fatty_acids_per_hundred)){
					$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_fat_of_which_saturated_fatty_acids_per_hundred))){
						$ft = "error";
						$fm = "fat_of_which_saturated_fatty_acids_per_hundred_have_to_be_a_number";
					}
				}
				$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = round($inp_item_fat_of_which_saturated_fatty_acids_per_hundred, 0);
				$inp_item_fat_of_which_saturated_fatty_acids_per_hundred_mysql = quote_smart($link, $inp_item_fat_of_which_saturated_fatty_acids_per_hundred);

				$inp_item_fat_of_which_saturated_fatty_acids_calculated = $_POST['inp_item_fat_of_which_saturated_fatty_acids_calculated'];
				$inp_item_fat_of_which_saturated_fatty_acids_calculated = output_html($inp_item_fat_of_which_saturated_fatty_acids_calculated);
				$inp_item_fat_of_which_saturated_fatty_acids_calculated = str_replace(",", ".", $inp_item_fat_of_which_saturated_fatty_acids_calculated);
				if(empty($inp_item_fat_of_which_saturated_fatty_acids_calculated)){
					$inp_item_fat_of_which_saturated_fatty_acids_calculated = "0";
				}
				else{
					if(!(is_numeric($inp_item_fat_of_which_saturated_fatty_acids_calculated))){
						$ft = "error";
						$fm = "fat_of_which_saturated_fatty_acids_calculated_have_to_be_a_number";
					}
				}
				$inp_item_fat_of_which_saturated_fatty_acids_calculated = round($inp_item_fat_of_which_saturated_fatty_acids_calculated, 0);
				$inp_item_fat_of_which_saturated_fatty_acids_calculated_mysql = quote_smart($link, $inp_item_fat_of_which_saturated_fatty_acids_calculated);

				$inp_item_carbs_per_hundred = $_POST['inp_item_carbs_per_hundred'];
				$inp_item_carbs_per_hundred = output_html($inp_item_carbs_per_hundred);
				$inp_item_carbs_per_hundred = str_replace(",", ".", $inp_item_carbs_per_hundred);
				if(empty($inp_item_carbs_per_hundred)){
					$inp_item_carbs_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_calories_per_hundred))){
						$ft = "error";
						$fm = "calories_have_to_be_a_number";
					}
				}
				$inp_item_carbs_per_hundred = round($inp_item_carbs_per_hundred, 0);
				$inp_item_carbs_per_hundred_mysql = quote_smart($link, $inp_item_carbs_per_hundred);

				$inp_item_carbs_calculated = $_POST['inp_item_carbs_calculated'];
				$inp_item_carbs_calculated = output_html($inp_item_carbs_calculated);
				$inp_item_carbs_calculated = str_replace(",", ".", $inp_item_carbs_calculated);
				if(empty($inp_item_carbs_calculated)){
					$inp_item_carbs_calculated = "0";
				}
				else{
					if(!(is_numeric($inp_item_calories_calculated))){
						$ft = "error";
						$fm = "calories_have_to_be_a_number";
					}
				}
				$inp_item_carbs_calculated = round($inp_item_carbs_calculated, 0);
				$inp_item_carbs_calculated_mysql = quote_smart($link, $inp_item_carbs_calculated);


				$inp_item_carbs_of_which_sugars_per_hundred = $_POST['inp_item_carbs_of_which_sugars_per_hundred'];
				$inp_item_carbs_of_which_sugars_per_hundred = output_html($inp_item_carbs_of_which_sugars_per_hundred);
				$inp_item_carbs_of_which_sugars_per_hundred = str_replace(",", ".", $inp_item_carbs_of_which_sugars_per_hundred);
				if(empty($inp_item_carbs_of_which_sugars_per_hundred)){
					$inp_item_carbs_of_which_sugars_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_carbs_of_which_sugars_per_hundred))){
						$ft = "error";
						$fm = "carbs_of_which_sugars_per_hundred_have_to_be_a_number";
					}
				}
				$inp_item_carbs_of_which_sugars_per_hundred = round($inp_item_carbs_of_which_sugars_per_hundred, 0);
				$inp_item_carbs_of_which_sugars_per_hundred_mysql = quote_smart($link, $inp_item_carbs_of_which_sugars_per_hundred);

				$inp_item_carbs_of_which_sugars_calculated = $_POST['inp_item_carbs_of_which_sugars_calculated'];
				$inp_item_carbs_of_which_sugars_calculated = output_html($inp_item_carbs_of_which_sugars_calculated);
				$inp_item_carbs_of_which_sugars_calculated = str_replace(",", ".", $inp_item_carbs_of_which_sugars_calculated);
				if(empty($inp_item_carbs_of_which_sugars_calculated)){
					$inp_item_carbs_of_which_sugars_calculated = "0";
				}
				else{
					if(!(is_numeric($inp_item_carbs_of_which_sugars_calculated))){
						$ft = "error";
						$fm = "carbs_of_which_sugars_calculated_have_to_be_a_number";
					}
				}
				$inp_item_carbs_of_which_sugars_calculated = round($inp_item_carbs_of_which_sugars_calculated, 0);
				$inp_item_carbs_of_which_sugars_calculated_mysql = quote_smart($link, $inp_item_carbs_of_which_sugars_calculated);


				$inp_item_proteins_per_hundred = $_POST['inp_item_proteins_per_hundred'];
				$inp_item_proteins_per_hundred = output_html($inp_item_proteins_per_hundred);
				$inp_item_proteins_per_hundred = str_replace(",", ".", $inp_item_proteins_per_hundred);
				if(empty($inp_item_proteins_per_hundred)){
					$inp_item_proteins_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_proteins_per_hundred))){
						$ft = "error";
						$fm = "proteins_have_to_be_a_number";
					}
				}
				$inp_item_proteins_per_hundred = round($inp_item_proteins_per_hundred, 0);
				$inp_item_proteins_per_hundred_mysql = quote_smart($link, $inp_item_proteins_per_hundred);


				$inp_item_proteins_calculated = $_POST['inp_item_proteins_calculated'];
				$inp_item_proteins_calculated = output_html($inp_item_proteins_calculated);
				$inp_item_proteins_calculated = str_replace(",", ".", $inp_item_proteins_calculated);
				if(empty($inp_item_proteins_calculated)){
					$inp_item_proteins_calculated = "0";
				}
				else{
					if(!(is_numeric($inp_item_proteins_calculated))){
						$ft = "error";
						$fm = "proteins_have_to_be_a_number";
					}
				}
				$inp_item_proteins_calculated = round($inp_item_proteins_calculated, 0);
				$inp_item_proteins_calculated_mysql = quote_smart($link, $inp_item_proteins_calculated);

				$inp_item_salt_per_hundred = $_POST['inp_item_salt_per_hundred'];
				$inp_item_salt_per_hundred = output_html($inp_item_salt_per_hundred);
				$inp_item_salt_per_hundred = str_replace(",", ".", $inp_item_salt_per_hundred);
				if(empty($inp_item_salt_per_hundred)){
					$inp_item_salt_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_salt_per_hundred))){
						$ft = "error";
						$fm = "salt_have_to_be_a_number";
					}
				}
				$inp_item_salt_per_hundred = round($inp_item_salt_per_hundred, 0);
				$inp_item_salt_per_hundred_mysql = quote_smart($link, $inp_item_salt_per_hundred);

				$inp_item_salt_calculated = $_POST['inp_item_salt_calculated'];
				$inp_item_salt_calculated = output_html($inp_item_salt_calculated);
				$inp_item_salt_calculated = str_replace(",", ".", $inp_item_salt_calculated);
				if(empty($inp_item_salt_calculated)){
					$inp_item_salt_calculated = "0";
				}
				else{
					if(!(is_numeric($inp_item_salt_calculated))){
						$ft = "error";
						$fm = "salt_have_to_be_a_number";
					}
				}
				$inp_item_salt_calculated = round($inp_item_salt_calculated, 0);
				$inp_item_salt_calculated_mysql = quote_smart($link, $inp_item_salt_calculated);



				if(isset($fm) && $fm != ""){
					$url = "edit_recipe_ingredients.php?recipe_id=$get_recipe_id&action=add_items&group_id=$get_group_id&l=$l";
					$url = $url . "&ft=$ft&fm=$fm";
					$url = $url . "&amount=$inp_item_amount&measurement=$inp_item_measurement&grocery=$inp_item_grocery&calories=$inp_item_calories_calculated";
					$url = $url . "&proteins=$inp_item_proteins_calculated&fat=$inp_item_fat_calculated&carbs=$inp_item_carbs_calculated";

					header("Location: $url");
					exit;
				}


				// Have I already this item?
				$query = "SELECT item_id FROM $t_recipes_items WHERE item_recipe_id=$get_recipe_id AND item_group_id=$get_group_id AND item_grocery=$inp_item_grocery_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_item_id) = $row;
				if($get_item_id != ""){
					$ft = "error";
					$fm = "you_have_already_added_that_item";

					$url = "edit_recipe_ingredients.php?recipe_id=$get_recipe_id&action=add_items&group_id=$get_group_id&l=$l";
					$url = $url . "&ft=$ft&fm=$fm";
					$url = $url . "&amount=$inp_item_amount&measurement=$inp_item_measurement&grocery=$inp_item_grocery&calories=$inp_item_calories_calculated";
					$url = $url . "&proteins=$inp_item_proteins_calculated&fat=$inp_item_fat_calculated&carbs=$inp_item_carbs_calculated";

					header("Location: $url");
					exit;
				}



				// Insert
				mysqli_query($link, "INSERT INTO $t_recipes_items
				(item_id, item_recipe_id, item_group_id, item_amount, item_measurement, item_grocery, item_grocery_explanation, item_food_id, 
				item_calories_per_hundred, item_fat_per_hundred, item_fat_of_which_saturated_fatty_acids_per_hundred, item_carbs_per_hundred, item_carbs_of_which_sugars_per_hundred, item_proteins_per_hundred, item_salt_per_hundred, 
				item_calories_calculated, item_fat_calculated, item_fat_of_which_saturated_fatty_acids_calculated, item_carbs_calculated, item_carbs_of_which_sugars_calculated, item_proteins_calculated, item_salt_calculated) 
				VALUES 
				(NULL, '$get_recipe_id', '$get_group_id', $inp_item_amount_mysql, $inp_item_measurement_mysql, $inp_item_grocery_mysql, '', $inp_item_food_id_mysql, 
				$inp_item_calories_per_hundred_mysql, $inp_item_fat_per_hundred_mysql, $inp_item_fat_of_which_saturated_fatty_acids_per_hundred_mysql, $inp_item_carbs_per_hundred_mysql, $inp_item_carbs_of_which_sugars_per_hundred_mysql, $inp_item_proteins_per_hundred_mysql, $inp_item_salt_per_hundred_mysql,
				$inp_item_calories_calculated_mysql, $inp_item_fat_calculated_mysql, $inp_item_fat_of_which_saturated_fatty_acids_calculated_mysql, $inp_item_carbs_calculated_mysql, $inp_item_carbs_of_which_sugars_calculated_mysql, $inp_item_proteins_calculated_mysql, $inp_item_salt_calculated_mysql)")
				or die(mysqli_error($link));


				// Calculating total numbers
				$inp_number_hundred_calories = 0;
				$inp_number_hundred_proteins = 0;
				$inp_number_hundred_fat = 0;
				$inp_number_hundred_carbs = 0;

				$inp_number_serving_calories = 0;
				$inp_number_serving_proteins = 0;
				$inp_number_serving_fat = 0;
				$inp_number_serving_carbs = 0;

				$inp_number_total_weight = 0;

				$inp_number_total_calories = 0;
				$inp_number_total_proteins = 0;
				$inp_number_total_fat = 0;
				$inp_number_total_carbs = 0;

					
				$query_groups = "SELECT group_id, group_title FROM $t_recipes_groups WHERE group_recipe_id=$get_recipe_id";
				$result_groups = mysqli_query($link, $query_groups);
				while($row_groups = mysqli_fetch_row($result_groups)) {
					list($get_group_id, $get_group_title) = $row_groups;
	
					$query_items = "SELECT item_id, item_amount, item_calories_per_hundred, item_proteins_per_hundred, item_fat_per_hundred, item_carbs_per_hundred, item_calories_calculated, item_proteins_calculated, item_fat_calculated, item_carbs_calculated FROM $t_recipes_items WHERE item_group_id=$get_group_id";
					$result_items = mysqli_query($link, $query_items);
					$row_cnt = mysqli_num_rows($result_items);
					while($row_items = mysqli_fetch_row($result_items)) {
						list($get_item_id, $get_item_amount, $get_item_calories_per_hundred, $get_item_proteins_per_hundred, $get_item_fat_per_hundred, $get_item_carbs_per_hundred, $get_item_calories_calculated, $get_item_proteins_calculated, $get_item_fat_calculated, $get_item_carbs_calculated) = $row_items;

						$inp_number_hundred_calories = $inp_number_hundred_calories+$get_item_calories_per_hundred;
						$inp_number_hundred_proteins = $inp_number_hundred_proteins+$get_item_proteins_per_hundred;
						$inp_number_hundred_fat      = $inp_number_hundred_fat+$get_item_fat_per_hundred;
						$inp_number_hundred_carbs    = $inp_number_hundred_carbs+$get_item_carbs_per_hundred;
					
						$inp_number_total_weight     = $inp_number_total_weight+$get_item_amount;

						$inp_number_total_calories = $inp_number_total_calories+$get_item_calories_calculated;
						$inp_number_total_proteins = $inp_number_total_proteins+$get_item_proteins_calculated;
						$inp_number_total_fat      = $inp_number_total_fat+$get_item_fat_calculated;
						$inp_number_total_carbs    = $inp_number_total_carbs+$get_item_carbs_calculated;


					} // items

				} // groups

				$inp_number_serving_calories = round($inp_number_total_calories/$get_number_servings);
				$inp_number_serving_proteins = round($inp_number_total_proteins/$get_number_servings);
				$inp_number_serving_fat      = round($inp_number_total_fat/$get_number_servings);
				$inp_number_serving_carbs    = round($inp_number_total_carbs/$get_number_servings);


				// Ready numbers for MySQL
				$inp_number_hundred_calories_mysql = quote_smart($link, $inp_number_hundred_calories);
				$inp_number_hundred_proteins_mysql = quote_smart($link, $inp_number_hundred_proteins);
				$inp_number_hundred_fat_mysql      = quote_smart($link, $inp_number_hundred_fat);
				$inp_number_hundred_carbs_mysql    = quote_smart($link, $inp_number_hundred_carbs);

				$inp_number_total_weight_mysql     = quote_smart($link, $inp_number_total_weight);

				$inp_number_total_calories_mysql = quote_smart($link, $inp_number_total_calories);
				$inp_number_total_proteins_mysql = quote_smart($link, $inp_number_total_proteins);
				$inp_number_total_fat_mysql      = quote_smart($link, $inp_number_total_fat);
				$inp_number_total_carbs_mysql    = quote_smart($link, $inp_number_total_carbs);


				$inp_number_serving_calories_mysql = quote_smart($link, $inp_number_serving_calories);
				$inp_number_serving_proteins_mysql = quote_smart($link, $inp_number_serving_proteins);
				$inp_number_serving_fat_mysql      = quote_smart($link, $inp_number_serving_fat);
				$inp_number_serving_carbs_mysql    = quote_smart($link, $inp_number_serving_carbs);



				$result = mysqli_query($link, "UPDATE $t_recipes_numbers SET number_hundred_calories=$inp_number_hundred_calories_mysql, number_hundred_proteins=$inp_number_hundred_proteins_mysql, number_hundred_fat=$inp_number_hundred_fat_mysql, number_hundred_carbs=$inp_number_hundred_carbs_mysql, 
								number_serving_calories=$inp_number_serving_calories_mysql, number_serving_proteins=$inp_number_serving_proteins_mysql, number_serving_fat=$inp_number_serving_fat_mysql, number_serving_carbs=$inp_number_serving_carbs_mysql,
								number_total_weight=$inp_number_total_weight_mysql, 
								number_total_calories=$inp_number_total_calories_mysql, number_total_proteins=$inp_number_total_proteins_mysql, number_total_fat=$inp_number_total_fat_mysql, number_total_carbs=$inp_number_total_carbs_mysql WHERE number_recipe_id=$recipe_id_mysql");



				// Header
				$ft = "success";
				$fm = "ingredient_added";

				$url = "edit_recipe_ingredients.php?recipe_id=$get_recipe_id&action=add_items&group_id=$get_group_id&l=$l";
				$url = $url . "&ft=$ft&fm=$fm";
				header("Location: $url");
				exit;

			}

			echo"

			<h1>$get_recipe_title</h1>

			<!-- Menu -->
			<div class=\"tabs\">
				<ul>
				<li><a href=\"edit_recipe.php?recipe_id=$recipe_id&amp;l=$l\">$l_general</a>
				<li><a href=\"edit_recipe_ingredients.php?recipe_id=$recipe_id&amp;l=$l\" class=\"active\">$l_ingredients</a>
				<li><a href=\"edit_recipe_categorization.php?recipe_id=$recipe_id&amp;l=$l\">$l_categorization</a>
				<li><a href=\"edit_recipe_image.php?recipe_id=$recipe_id&amp;l=$l\">$l_image</a>
				<li><a href=\"edit_recipe_video.php?recipe_id=$recipe_id&amp;l=$l\">$l_video</a>
			</ul>
			</div><p>&nbsp;</p>
			<!-- //Menu -->



		

			<h2>$l_add_ingredients</h2>



			<h3>$get_group_title</h3>



			<!-- Feedback -->
				";
				if($ft != ""){
					if($fm == "changes_saved"){
						$fm = "$l_changes_saved";
					}
					elseif($fm == "amound_cant_be_empty"){
						$fm = "$l_amound_cant_be_empty";
					}
					elseif($fm == "amound_has_to_be_a_number"){
						$fm = "$l_amound_has_to_be_a_number";
					}
					elseif($fm == "measurement_cant_be_empty"){
						$fm = "$l_measurement_cant_be_empty";
					}
					elseif($fm == "grocery_cant_be_empty"){
						$fm = "$l_grocery_cant_be_empty";
					}
					elseif($fm == "calories_cant_be_empty"){
						$fm = "$l_calories_cant_be_empty";
					}
					elseif($fm == "proteins_cant_be_empty"){
						$fm = "$l_proteins_cant_be_empty";
					}
					elseif($fm == "fat_cant_be_empty"){
						$fm = "$l_fat_cant_be_empty";
					}
					elseif($fm == "carbs_cant_be_empty"){
						$fm = "$l_carbs_cant_be_empty";
					}
					elseif($fm == "calories_have_to_be_a_number"){
						$fm = "$l_calories_have_to_be_a_number";
					}
					elseif($fm == "proteins_have_to_be_a_number"){
						$fm = "$l_proteins_have_to_be_a_number";
					}
					elseif($fm == "carbs_have_to_be_a_number"){
						$fm = "$l_carbs_have_to_be_a_number";
					}
					elseif($fm == "fat_have_to_be_a_number"){
						$fm = "$l_fat_have_to_be_a_number";
					}
					elseif($fm == "you_have_already_added_that_item"){
						$fm = "$l_you_have_already_added_that_item";
					}
					elseif($fm == "ingredient_added"){
						$fm = "$l_ingredient_added";
					}
					else{
						$fm = ucfirst($fm);
					}
					echo"<div class=\"$ft\"><span>$fm</span></div>";
				}
				echo"	
			<!-- //Feedback -->



				<!-- Focus -->
					<script>
					\$(document).ready(function(){
						\$('[name=\"inp_item_amount\"]').focus();
					});
					</script>
				<!-- //Focus -->


				<!-- Var -->
				";

					if(isset($_GET['amount'])){
						$inp_item_amount = $_GET['amount'];
						$inp_item_amount = output_html($inp_item_amount);
					}
					else{
						$inp_item_amount = "";
					}

					if(isset($_GET['measurement'])){
						$inp_item_measurement = $_GET['measurement'];
						$inp_item_measurement = output_html($inp_item_measurement);
					}
					else{
						$inp_item_measurement = "";
					}


					if(isset($_GET['grocery'])){
						$inp_item_grocery = $_GET['grocery'];
						$inp_item_grocery = output_html($inp_item_grocery);
					}
					else{
						$inp_item_grocery = "";
					}


					if(isset($_GET['calories_per_hundred'])){
						$inp_item_calories_per_hundred = $_GET['calories_per_hundred'];
						$inp_item_calories_per_hundred = output_html($inp_item_calories_per_hundred);
					}
					else{
						$inp_item_calories_per_hundred = "";
					}

					if(isset($_GET['proteins_per_hundred'])){
						$inp_item_proteins_per_hundred = $_GET['proteins_per_hundred'];
						$inp_item_proteins_per_hundred = output_html($inp_item_proteins_per_hundred);
					}
					else{
						$inp_item_proteins_per_hundred = "";
					}

					if(isset($_GET['fat_per_hundred'])){
						$inp_item_fat_per_hundred = $_GET['fat_per_hundred'];
						$inp_item_fat_per_hundred = output_html($inp_item_fat_per_hundred);
					}
					else{
						$inp_item_fat_per_hundred = "";
					}
					if(isset($_GET['fat_of_which_saturated_fatty_acids_per_hundred'])){
						$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = $_GET['fat_of_which_saturated_fatty_acids_per_hundred'];
						$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = output_html($inp_item_fat_of_which_saturated_fatty_acids_per_hundred);
					}
					else{
						$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = "";
					}

					if(isset($_GET['carbs_per_hundred'])){
						$inp_item_carbs_per_hundred = $_GET['carbs_per_hundred'];
						$inp_item_carbs_per_hundred = output_html($inp_item_carbs_per_hundred);
					}
					else{
						$inp_item_carbs_per_hundred = "";
					}
					if(isset($_GET['carbs_of_which_sugars_per_hundred'])){
						$inp_item_carbs_of_which_sugars_per_hundred = $_GET['carbs_of_which_sugars_per_hundred'];
						$inp_item_carbs_of_which_sugars_per_hundred = output_html($inp_item_carbs_of_which_sugars_per_hundred);
					}
					else{
						$inp_item_carbs_of_which_sugars_per_hundred = "";
					}

					if(isset($_GET['salt_per_hundred'])){
						$inp_item_salt_per_hundred = $_GET['salt_per_hundred'];
						$inp_item_salt_per_hundred = output_html($inp_item_salt_per_hundred);
					}
					else{
						$inp_item_salt_per_hundred = "";
					}

					if(isset($_GET['calories'])){
						$inp_item_calories_calculated = $_GET['calories'];
						$inp_item_calories_calculated = output_html($inp_item_calories_calculated);
					}
					else{
						$inp_item_calories_calculated = "";
					}

					if(isset($_GET['proteins'])){
						$inp_item_proteins_calculated = $_GET['proteins'];
						$inp_item_proteins_calculated = output_html($inp_item_proteins_calculated);
					}
					else{
						$inp_item_proteins_calculated = "";
					}

					if(isset($_GET['fat'])){
						$inp_item_fat_calculated = $_GET['fat'];
						$inp_item_fat_calculated = output_html($inp_item_fat_calculated);
					}
					else{
						$inp_item_fat_calculated = "";
					}
					if(isset($_GET['fat_of_which_saturated_fatty_acids_calculated'])){
						$inp_item_fat_of_which_saturated_fatty_acids_calculated = $_GET['fat_of_which_saturated_fatty_acids_calculated'];
						$inp_item_fat_of_which_saturated_fatty_acids_calculated = output_html($inp_item_fat_of_which_saturated_fatty_acids_calculated);
					}
					else{
						$inp_item_fat_of_which_saturated_fatty_acids_calculated = "";
					}

					if(isset($_GET['carbs'])){
						$inp_item_carbs_calculated = $_GET['carbs'];
						$inp_item_carbs_calculated = output_html($inp_item_carbs_calculated);
					}
					else{
						$inp_item_carbs_calculated = "";
					}
					if(isset($_GET['carbs_of_which_sugars_calculated'])){
						$inp_item_carbs_of_which_sugars_calculated = $_GET['carbs_of_which_sugars_calculated'];
						$inp_item_carbs_of_which_sugars_calculated = output_html($inp_item_carbs_of_which_sugars_calculated);
					}
					else{
						$inp_item_carbs_of_which_sugars_calculated = "";
					}

					if(isset($_GET['salt_calculated'])){
						$inp_item_salt_calculated = $_GET['salt_calculated'];
						$inp_item_salt_calculated = output_html($inp_item_salt_calculated);
					}
					else{
						$inp_item_salt_calculated = "";
					}


					echo"

				<!-- //Var -->



			<!-- Add item -->

				<form method=\"post\" action=\"edit_recipe_ingredients.php?recipe_id=$get_recipe_id&amp;action=add_items&amp;group_id=$group_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

				<h2 style=\"padding-bottom:0;margin-bottom:0;\">$l_food</h2>
				<table>
				 <tbody>
				  <tr>
				   <td style=\"padding: 0px 20px 0px 0px;\">
					<p>$l_amount<br />
					<input type=\"text\" name=\"inp_item_amount\" id=\"inp_item_amount\" size=\"3\" value=\"$inp_item_amount\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
					</p>
				   </td>
				   <td>
					<p>$l_measurement<br />
					<input type=\"text\" name=\"inp_item_measurement\" size=\"3\" value=\"$inp_item_measurement\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
					</p>
				   </td>
				  </tr>
				</table>
				<p>$l_grocery &middot; <a href=\"$root/food/new_food.php?l=$l\" target=\"_blank\">$l_new_food</a><br />
				<input type=\"text\" name=\"inp_item_grocery\" class=\"inp_item_grocery\" size=\"25\" value=\"$inp_item_grocery\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" id=\"nettport_inp_search_query\" />
				<input type=\"hidden\" name=\"inp_item_food_id\" id=\"inp_item_food_id\" /></p>


				<div id=\"nettport_search_results\">
				</div><div class=\"clear\"></div></span>

				<hr />
				<h2 style=\"padding-bottom:0;margin-bottom:0;\">$l_numbers</h2>

				<table class=\"hor-zebra\" style=\"width: 350px\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
				   </th>
				   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;vertical-align: bottom;\">
					<span>$l_per_hundred</span>
				   </th>
				   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;vertical-align: bottom;\">
					<span>$l_calculated</span>
				   </th>
				  </tr>
				 </thead>
				 <tbody>
				  <tr>
				   <td style=\"padding: 8px 4px 6px 8px;\">
					<span>$l_energy</span>
				   </td>
				   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
					<span><input type=\"text\" name=\"inp_item_calories_per_hundred\" id=\"inp_item_calories_per_hundred\" size=\"5\" value=\"$inp_item_calories_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></span>
				   </td>
				   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
					<span><input type=\"text\" name=\"inp_item_calories_calculated\" id=\"inp_item_calories_calculated\" size=\"5\" value=\"$inp_item_calories_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></span>
				   </td>
				  </tr>
				  <tr>
				   <td style=\"padding: 8px 4px 6px 8px;\">
					<p style=\"margin:0;padding: 0px 0px 4px 0px;\">$l_fat</p>
					<p style=\"margin:0;padding: 0;\">$l_dash_of_which_saturated_fatty_acids</p>
				   </td>
				   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
					<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_item_fat_per_hundred\" id=\"inp_item_fat_per_hundred\" size=\"5\" value=\"$inp_item_fat_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
					<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_item_fat_of_which_saturated_fatty_acids_per_hundred\" id=\"inp_item_fat_of_which_saturated_fatty_acids_per_hundred\" size=\"5\" value=\"$inp_item_fat_of_which_saturated_fatty_acids_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
				   </td>
				   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
					<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_item_fat_calculated\" id=\"inp_item_fat_calculated\" size=\"5\" value=\"$inp_item_fat_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
					<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_item_fat_of_which_saturated_fatty_acids_calculated\" id=\"inp_item_fat_of_which_saturated_fatty_acids_calculated\" size=\"5\" value=\"$inp_item_fat_of_which_saturated_fatty_acids_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
				   </td>
				 </tr>
				  <tr>
		 		  <td style=\"padding: 8px 4px 6px 8px;\">
					<p style=\"margin:0;padding: 0px 0px 4px 0px;\">$l_carbs</p>
					<p style=\"margin:0;padding: 0;\">$l_dash_of_which_sugars_calculated</p>
				   </td>
				   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
					<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_item_carbs_per_hundred\" id=\"inp_item_carbs_per_hundred\" size=\"5\" value=\"$inp_item_carbs_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
					<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_item_carbs_of_which_sugars_per_hundred\" id=\"inp_item_carbs_of_which_sugars_per_hundred\" size=\"5\" value=\"$inp_item_carbs_of_which_sugars_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
				   </td>
				   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
					<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_item_carbs_calculated\" id=\"inp_item_carbs_calculated\" size=\"5\" value=\"$inp_item_carbs_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
					<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_item_carbs_of_which_sugars_calculated\" id=\"inp_item_carbs_of_which_sugars_calculated\" size=\"5\" value=\"$inp_item_carbs_of_which_sugars_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
				   </td>
				  </tr>
				  <tr>
				   <td style=\"padding: 8px 4px 6px 8px;\">
					<span>$l_proteins</span>
				   </td>
				   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
					<span><input type=\"text\" name=\"inp_item_proteins_per_hundred\" id=\"inp_item_proteins_per_hundred\" size=\"5\" value=\"$inp_item_proteins_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></span>
				   </td>
				   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
					<span><input type=\"text\" name=\"inp_item_proteins_calculated\" id=\"inp_item_proteins_calculated\" size=\"5\" value=\"$inp_item_proteins_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></span>
				   </td>
				  </tr>
				 </tr>
				  <tr>
				   <td style=\"padding: 8px 4px 6px 8px;\">
					<span>$l_sodium_in_gram</span>
				   </td>
				   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
					<span><input type=\"text\" name=\"inp_item_salt_per_hundred\" id=\"inp_item_salt_per_hundred\" value=\"$inp_item_salt_per_hundred\" size=\"5\" /></span>
				   </td>
				   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
					<span><input type=\"text\" name=\"inp_item_salt_calculated\" id=\"inp_item_salt_calculated\" value=\"$inp_item_salt_calculated\" size=\"5\" /></span>
				   </td>
				  </tr>
				 </tbody>
				</table>



			

				<p>
				<input type=\"submit\" value=\"$l_add_ingredient\" class=\"btn\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
				</p>





				</form>

				<!-- Search script -->

					<script id=\"source\" language=\"javascript\" type=\"text/javascript\">

					\$(document).ready(function () {

						\$('#nettport_inp_search_query').keyup(function () {

							$(\"#nettport_search_results\").show();

       							// getting the value that user typed

       							var searchString    = $(\"#nettport_inp_search_query\").val();

 							// forming the queryString

      							var data            = 'l=$l&q='+ searchString;

         

        						// if searchString is not empty

        						if(searchString) {

           							// ajax call

            							\$.ajax({

                							type: \"POST\",

               								url: \"submit_recipe_step_2_group_and_elements_search_jquery.php\",

                							data: data,

									beforeSend: function(html) { // this happens before actual call

										\$(\"#nettport_search_results\").html(''); 

									},

               								success: function(html){

                    								\$(\"#nettport_search_results\").append(html);

              								}

            							});

       							}

        						return false;

            					});

         				   });

					</script>

				<!-- //Search script -->



			<!-- //Add item -->





			<!-- Buttons -->

				<p>

				<a href=\"edit_recipe_ingredients.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"btn btn_default\">$l_summary</a>



				<a href=\"edit_recipe_ingredients.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"btn btn_default\">$l_add_another_group</a>

	

				</p>

			<!-- //Buttons -->





			";

		} // group found

	} // action == "add_items")

	elseif($action == "edit_group"){

		// Get group

		$group_id_mysql = quote_smart($link, $group_id);

		$query = "SELECT group_id, group_recipe_id, group_title FROM $t_recipes_groups WHERE group_id=$group_id_mysql AND group_recipe_id=$get_recipe_id";

		$result = mysqli_query($link, $query);

		$row = mysqli_fetch_row($result);

		list($get_group_id, $get_group_recipe_id, $get_group_title) = $row;



		if($get_group_id == ""){

			echo"

			<h1>Server error</h1>



			<p>

			Group not found.

			</p>

			";

		}

		else{

			if($process == "1"){

				$inp_group_title = $_POST['inp_group_title'];

				$inp_group_title = output_html($inp_group_title);

				$inp_group_title_mysql = quote_smart($link, $inp_group_title);

				if(empty($inp_group_title)){

					$ft = "error";

					$fm = "title_cant_be_empty";



					$url = "edit_recipe_ingredients.php?action=edit_group&recipe_id=$get_recipe_id&group_id=$get_group_id&l=$l";

					$url = $url . "&ft=$ft&fm=$fm";



					header("Location: $url");

					exit;

				}



				// Update

				$result = mysqli_query($link, "UPDATE $t_recipes_groups SET group_title=$inp_group_title_mysql WHERE group_id=$get_group_id");





				// Header

				$ft = "success";

				$fm = "changes_saved";



				$url = "edit_recipe_ingredients.php?recipe_id=$get_recipe_id&group_id=$get_group_id&l=$l";

				$url = $url . "&ft=$ft&fm=$fm";

				header("Location: $url");

				exit;	



				



			}

			echo"

			<h1>$get_recipe_title</h1>





			<!-- Menu -->

			<div class=\"tabs\">

			<ul>

				<li><a href=\"edit_recipe.php?recipe_id=$recipe_id&amp;l=$l\">$l_general</a>

				<li><a href=\"edit_recipe_ingredients.php?recipe_id=$recipe_id&amp;l=$l\" class=\"active\">$l_ingredients</a>

				<li><a href=\"edit_recipe_categorization.php?recipe_id=$recipe_id&amp;l=$l\">$l_categorization</a>

				<li><a href=\"edit_recipe_image.php?recipe_id=$recipe_id&amp;l=$l\">$l_image</a>

				<li><a href=\"edit_recipe_video.php?recipe_id=$recipe_id&amp;l=$l\">$l_video</a>

			</ul>

			</div><p>&nbsp;</p>

			<!-- //Menu -->





			<h2>$l_edit_group</h2>







			<!-- Feedback -->

				";

				if($ft != ""){

					if($fm == "changes_saved"){

						$fm = "$l_changes_saved";

					}

					elseif($fm == "amound_cant_be_empty"){

						$fm = "$l_amound_cant_be_empty";

					}

					else{

						$fm = ucfirst($fm);

					}

					echo"<div class=\"$ft\"><span>$fm</span></div>";

				}

				echo"	

			<!-- //Feedback -->



			<!-- Edit group form -->

				<!-- Focus -->

					<script>

					\$(document).ready(function(){

						\$('[name=\"inp_group_title\"]').focus();

					});

					</script>

				<!-- //Focus -->





				<form method=\"post\" action=\"edit_recipe_ingredients.php?action=edit_group&amp;recipe_id=$get_recipe_id&amp;group_id=$group_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			

				<p><b>$l_title:</b><br />

				<input type=\"text\" name=\"inp_group_title\" size=\"30\" value=\"$get_group_title\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />

				<input type=\"submit\" value=\"$l_save_changes\" class=\"btn\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />

				</p>





				</form>

			<!-- //Add item -->



			<!-- Buttons -->

				<p>

				<a href=\"edit_recipe_ingredients.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"btn btn_default\">$l_summary</a>



				<a href=\"edit_recipe_ingredients.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"btn btn_default\">$l_add_another_group</a>

	

				</p>

			<!-- //Buttons -->





			";

		} // group found

	} // action == edit_group

	elseif($action == "delete_group"){

		// Get group

		$group_id_mysql = quote_smart($link, $group_id);

		$query = "SELECT group_id, group_recipe_id, group_title FROM $t_recipes_groups WHERE group_id=$group_id_mysql AND group_recipe_id=$get_recipe_id";

		$result = mysqli_query($link, $query);

		$row = mysqli_fetch_row($result);

		list($get_group_id, $get_group_recipe_id, $get_group_title) = $row;



		if($get_group_id == ""){

			echo"

			<h1>Server error</h1>



			<p>

			Group not found.

			</p>

			";

		}

		else{

			if($process == "1"){

				

				// Update

				$result = mysqli_query($link, "DELETE FROM $t_recipes_groups WHERE group_id=$get_group_id");

				$result = mysqli_query($link, "DELETE FROM $t_recipes_items WHERE item_group_id=$get_group_id");



				

				// Calculating total numbers

				$inp_number_hundred_calories = 0;

				$inp_number_hundred_proteins = 0;

				$inp_number_hundred_fat = 0;

				$inp_number_hundred_carbs = 0;

					

				$inp_number_serving_calories = 0;

				$inp_number_serving_proteins = 0;

				$inp_number_serving_fat = 0;

				$inp_number_serving_carbs = 0;

					

				$inp_number_total_weight = 0;



				$inp_number_total_calories = 0;

				$inp_number_total_proteins = 0;

				$inp_number_total_fat = 0;



				$inp_number_total_carbs = 0;

					

				$query_groups = "SELECT group_id, group_title FROM $t_recipes_groups WHERE group_recipe_id=$get_recipe_id";

				$result_groups = mysqli_query($link, $query_groups);

				while($row_groups = mysqli_fetch_row($result_groups)) {

					list($get_group_id, $get_group_title) = $row_groups;



					$query_items = "SELECT item_id, item_amount, item_calories_per_hundred, item_proteins_per_hundred, item_fat_per_hundred, item_carbs_per_hundred, item_calories_calculated, item_proteins_calculated, item_fat_calculated, item_carbs_calculated FROM $t_recipes_items WHERE item_group_id=$get_group_id";

					$result_items = mysqli_query($link, $query_items);

					$row_cnt = mysqli_num_rows($result_items);

					while($row_items = mysqli_fetch_row($result_items)) {

						list($get_item_id, $get_item_amount, $get_item_calories_per_hundred, $get_item_proteins_per_hundred, $get_item_fat_per_hundred, $get_item_carbs_per_hundred, $get_item_calories_calculated, $get_item_proteins_calculated, $get_item_fat_calculated, $get_item_carbs_calculated) = $row_items;



						$inp_number_hundred_calories = $inp_number_hundred_calories+$get_item_calories_per_hundred;

						$inp_number_hundred_proteins = $inp_number_hundred_proteins+$get_item_proteins_per_hundred;

						$inp_number_hundred_fat      = $inp_number_hundred_fat+$get_item_fat_per_hundred;

						$inp_number_hundred_carbs    = $inp_number_hundred_carbs+$get_item_carbs_per_hundred;

					

						$inp_number_total_weight     = $inp_number_total_weight+$get_item_amount;



						$inp_number_total_calories = $inp_number_total_calories+$get_item_calories_calculated;

						$inp_number_total_proteins = $inp_number_total_proteins+$get_item_proteins_calculated;

						$inp_number_total_fat      = $inp_number_total_fat+$get_item_fat_calculated;

						$inp_number_total_carbs    = $inp_number_total_carbs+$get_item_carbs_calculated;

	

					} // items

				} // groups

					

				$inp_number_serving_calories = round($inp_number_total_calories/$get_number_servings);

				$inp_number_serving_proteins = round($inp_number_total_proteins/$get_number_servings);

				$inp_number_serving_fat      = round($inp_number_total_fat/$get_number_servings);

				$inp_number_serving_carbs    = round($inp_number_total_carbs/$get_number_servings);



	

				// Ready numbers for MySQL

				$inp_number_hundred_calories_mysql = quote_smart($link, $inp_number_hundred_calories);

				$inp_number_hundred_proteins_mysql = quote_smart($link, $inp_number_hundred_proteins);

				$inp_number_hundred_fat_mysql      = quote_smart($link, $inp_number_hundred_fat);

				$inp_number_hundred_carbs_mysql    = quote_smart($link, $inp_number_hundred_carbs);

					

				$inp_number_total_weight_mysql     = quote_smart($link, $inp_number_total_weight);



				$inp_number_total_calories_mysql = quote_smart($link, $inp_number_total_calories);

				$inp_number_total_proteins_mysql = quote_smart($link, $inp_number_total_proteins);

				$inp_number_total_fat_mysql      = quote_smart($link, $inp_number_total_fat);

				$inp_number_total_carbs_mysql    = quote_smart($link, $inp_number_total_carbs);



					

				$inp_number_serving_calories_mysql = quote_smart($link, $inp_number_serving_calories);

				$inp_number_serving_proteins_mysql = quote_smart($link, $inp_number_serving_proteins);

				$inp_number_serving_fat_mysql      = quote_smart($link, $inp_number_serving_fat);

				$inp_number_serving_carbs_mysql    = quote_smart($link, $inp_number_serving_carbs);



				$result = mysqli_query($link, "UPDATE $t_recipes_numbers SET number_hundred_calories=$inp_number_hundred_calories_mysql, number_hundred_proteins=$inp_number_hundred_proteins_mysql, number_hundred_fat=$inp_number_hundred_fat_mysql, number_hundred_carbs=$inp_number_hundred_carbs_mysql, 

								number_serving_calories=$inp_number_serving_calories_mysql, number_serving_proteins=$inp_number_serving_proteins_mysql, number_serving_fat=$inp_number_serving_fat_mysql, number_serving_carbs=$inp_number_serving_carbs_mysql,

								number_total_weight=$inp_number_total_weight_mysql, 

								number_total_calories=$inp_number_total_calories_mysql, number_total_proteins=$inp_number_total_proteins_mysql, number_total_fat=$inp_number_total_fat_mysql, number_total_carbs=$inp_number_total_carbs_mysql WHERE number_recipe_id=$recipe_id_mysql");







				// Header

				$ft = "success";

				$fm = "group_deleted";



				$url = "edit_recipe_ingredients.php?&recipe_id=$get_recipe_id&l=$l";

				$url = $url . "&ft=$ft&fm=$fm";

				header("Location: $url");

				exit;	



				



			}

			echo"

			<h1>$get_recipe_title</h1>





			<!-- Menu -->

				<div class=\"tabs\">

				<ul>

				<li><a href=\"edit_recipe.php?recipe_id=$recipe_id&amp;l=$l\">$l_general</a>

				<li><a href=\"edit_recipe_ingredients.php?recipe_id=$recipe_id&amp;l=$l\" class=\"active\">$l_ingredients</a>

				<li><a href=\"edit_recipe_categorization.php?recipe_id=$recipe_id&amp;l=$l\">$l_categorization</a>

				<li><a href=\"edit_recipe_image.php?recipe_id=$recipe_id&amp;l=$l\">$l_image</a>

				<li><a href=\"edit_recipe_video.php?recipe_id=$recipe_id&amp;l=$l\">$l_video</a>

				</ul>

				</div><p>&nbsp;</p>

			<!-- //Menu -->

			<h2>$l_delete_group</h2>







			<!-- Feedback -->

				";

				if($ft != ""){

					if($fm == "changes_saved"){

						$fm = "$l_changes_saved";

					}

					elseif($fm == "amound_cant_be_empty"){

						$fm = "$l_amound_cant_be_empty";

					}

					else{

						$fm = ucfirst($fm);

					}

					echo"<div class=\"$ft\"><span>$fm</span></div>";

				}

				echo"	

			<!-- //Feedback -->



			<!-- Delete group -->

				<h3>$get_group_title</h3>

				<p>

				$l_are_you_sure_you_want_to_delete

				$l_the_action_cant_be_undone

				</p>



				<p>

				<a href=\"edit_recipe_ingredients.php?action=delete_group&amp;recipe_id=$get_recipe_id&amp;group_id=$group_id&amp;l=$l&amp;process=1\" class=\"btn btn_warning\">$l_delete</a>

				<a href=\"edit_recipe_ingredients.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"btn btn_default\">$l_cancel</a>

				</p>

			<!-- //Delete group -->





			";

		} // group found

	} // action == delete_group
	elseif($action == "edit_item"){
		// Get group
		$group_id_mysql = quote_smart($link, $group_id);
		$query = "SELECT group_id, group_recipe_id, group_title FROM $t_recipes_groups WHERE group_id=$group_id_mysql AND group_recipe_id=$get_recipe_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_group_id, $get_group_recipe_id, $get_group_title) = $row;

		if($get_group_id == ""){
			echo"
			<h1>Server error</h1>

			<p>
			Group not found.
			</p>
			";
		}
		else{
			// Get item
			$item_id_mysql = quote_smart($link, $item_id);
			$query = "SELECT item_id, item_recipe_id, item_group_id, item_amount, item_measurement, item_grocery, item_grocery_explanation, item_food_id, item_calories_per_hundred, item_fat_per_hundred, item_fat_of_which_saturated_fatty_acids_per_hundred, item_carbs_per_hundred, item_carbs_of_which_sugars_per_hundred, item_proteins_per_hundred, item_salt_per_hundred, item_calories_calculated, item_fat_calculated, item_fat_of_which_saturated_fatty_acids_calculated, item_carbs_calculated, item_carbs_of_which_sugars_calculated, item_proteins_calculated, item_salt_calculated FROM $t_recipes_items WHERE item_id=$item_id_mysql AND item_recipe_id=$get_recipe_id AND item_group_id=$get_group_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_item_id, $get_item_recipe_id, $get_item_group_id, $get_item_amount, $get_item_measurement, $get_item_grocery, $get_item_grocery_explanation, $get_item_food_id, $get_item_calories_per_hundred, $get_item_fat_per_hundred, $get_item_fat_of_which_saturated_fatty_acids_per_hundred, $get_item_carbs_per_hundred, $get_item_carbs_of_which_sugars_per_hundred, $get_item_proteins_per_hundred, $get_item_salt_per_hundred, $get_item_calories_calculated, $get_item_fat_calculated, $get_item_fat_of_which_saturated_fatty_acids_calculated, $get_item_carbs_calculated, $get_item_carbs_of_which_sugars_calculated, $get_item_proteins_calculated, $get_item_salt_calculated) = $row;


			if($get_item_id == ""){
				echo"
				<h1>Server error</h1>

				<p>
				Items not found.
				</p>
				";
			}
			else{
				if($process == "1"){
					$inp_item_amount = $_POST['inp_item_amount'];
					$inp_item_amount = output_html($inp_item_amount);
					$inp_item_amount = str_replace(",", ".", $inp_item_amount);
					$inp_item_amount_mysql = quote_smart($link, $inp_item_amount);
					if(empty($inp_item_amount)){
						$ft = "error";
						$fm = "amound_cant_be_empty";
					}
					else{
						if(!(is_numeric($inp_item_amount))){
							// Do we have math? Example 1/8 ts
							$check_for_fraction = explode("/", $inp_item_amount);

							if(isset($check_for_fraction[0]) && isset($check_for_fraction[1])){
								if(is_numeric($check_for_fraction[0]) && is_numeric($check_for_fraction[1])){
									$inp_item_amount = $check_for_fraction[0] / $check_for_fraction[1];
								}
								else{
									$ft = "error";
									$fm = "amound_has_to_be_a_number";
								}
							}
							else{
								$ft = "error";
								$fm = "amound_has_to_be_a_number";
							}
						}
					}
	
					$inp_item_measurement = $_POST['inp_item_measurement'];
					$inp_item_measurement = output_html($inp_item_measurement);
					$inp_item_measurement = str_replace(",", ".", $inp_item_measurement);
					$inp_item_measurement_mysql = quote_smart($link, $inp_item_measurement);
					if(empty($inp_item_measurement)){
						$ft = "error";
						$fm = "measurement_cant_be_empty";
					}

					$inp_item_grocery = $_POST['inp_item_grocery'];
					$inp_item_grocery = output_html($inp_item_grocery);
					$inp_item_grocery_mysql = quote_smart($link, $inp_item_grocery);
					if(empty($inp_item_grocery)){
						$ft = "error";
						$fm = "grocery_cant_be_empty";
					}

					$inp_item_food_id = $_POST['inp_item_food_id'];
					$inp_item_food_id = output_html($inp_item_food_id);
					if($inp_item_food_id == ""){
						$inp_item_food_id = "0";
					}
					$inp_item_food_id_mysql = quote_smart($link, $inp_item_food_id);

				$inp_item_calories_per_hundred = $_POST['inp_item_calories_per_hundred'];
				$inp_item_calories_per_hundred = output_html($inp_item_calories_per_hundred);
				$inp_item_calories_per_hundred = str_replace(",", ".", $inp_item_calories_per_hundred);
				if(empty($inp_item_calories_per_hundred)){
					$inp_item_calories_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_calories_per_hundred))){
						$ft = "error";
						$fm = "calories_have_to_be_a_number";
					}
				}
				$inp_item_calories_per_hundred = round($inp_item_calories_per_hundred, 0);
				$inp_item_calories_per_hundred_mysql = quote_smart($link, $inp_item_calories_per_hundred);


					$inp_item_calories_calculated = $_POST['inp_item_calories_calculated'];
					$inp_item_calories_calculated = output_html($inp_item_calories_calculated);
					$inp_item_calories_calculated = str_replace(",", ".", $inp_item_calories_calculated);
					if(empty($inp_item_calories_calculated)){
						$inp_item_calories_calculated = "0";
					}
					else{
						if(!(is_numeric($inp_item_calories_calculated))){
							$ft = "error";
							$fm = "calories_have_to_be_a_number";
						}
					}
					$inp_item_calories_calculated = round($inp_item_calories_calculated, 0);
					$inp_item_calories_calculated_mysql = quote_smart($link, $inp_item_calories_calculated);

				$inp_item_fat_per_hundred = $_POST['inp_item_fat_per_hundred'];
				$inp_item_fat_per_hundred = output_html($inp_item_fat_per_hundred);
				$inp_item_fat_per_hundred = str_replace(",", ".", $inp_item_fat_per_hundred);
				if(empty($inp_item_fat_per_hundred)){
					$inp_item_fat_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_calories_per_hundred))){
						$ft = "error";
						$fm = "fat_have_to_be_a_number";
					}
				}
				$inp_item_fat_per_hundred = round($inp_item_fat_per_hundred, 0);
				$inp_item_fat_per_hundred_mysql = quote_smart($link, $inp_item_fat_per_hundred);

					$inp_item_fat_calculated = $_POST['inp_item_fat_calculated'];
					$inp_item_fat_calculated = output_html($inp_item_fat_calculated);
					$inp_item_fat_calculated = str_replace(",", ".", $inp_item_fat_calculated);
					if(empty($inp_item_fat_calculated)){
						$inp_item_fat_calculated = "0";
					}
					else{
						if(!(is_numeric($inp_item_calories_calculated))){
							$ft = "error";
							$fm = "fat_have_to_be_a_number";
						}
					}
					$inp_item_fat_calculated = round($inp_item_fat_calculated, 0);
					$inp_item_fat_calculated_mysql = quote_smart($link, $inp_item_fat_calculated);

				$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = $_POST['inp_item_fat_of_which_saturated_fatty_acids_per_hundred'];
				$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = output_html($inp_item_fat_of_which_saturated_fatty_acids_per_hundred);
				$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = str_replace(",", ".", $inp_item_fat_of_which_saturated_fatty_acids_per_hundred);
				if(empty($inp_item_fat_of_which_saturated_fatty_acids_per_hundred)){
					$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_fat_of_which_saturated_fatty_acids_per_hundred))){
						$ft = "error";
						$fm = "fat_of_which_saturated_fatty_acids_per_hundred_have_to_be_a_number";
					}
				}
				$inp_item_fat_of_which_saturated_fatty_acids_per_hundred = round($inp_item_fat_of_which_saturated_fatty_acids_per_hundred, 0);
				$inp_item_fat_of_which_saturated_fatty_acids_per_hundred_mysql = quote_smart($link, $inp_item_fat_of_which_saturated_fatty_acids_per_hundred);

					$inp_item_fat_of_which_saturated_fatty_acids_calculated = $_POST['inp_item_fat_of_which_saturated_fatty_acids_calculated'];
					$inp_item_fat_of_which_saturated_fatty_acids_calculated = output_html($inp_item_fat_of_which_saturated_fatty_acids_calculated);
					$inp_item_fat_of_which_saturated_fatty_acids_calculated = str_replace(",", ".", $inp_item_fat_of_which_saturated_fatty_acids_calculated);
					if(empty($inp_item_fat_of_which_saturated_fatty_acids_calculated)){
						$inp_item_fat_of_which_saturated_fatty_acids_calculated = "0";
					}
					else{
						if(!(is_numeric($inp_item_fat_of_which_saturated_fatty_acids_calculated))){
							$ft = "error";
							$fm = "fat_of_which_saturated_fatty_acids_calculated_have_to_be_a_number";
						}
					}
					$inp_item_fat_of_which_saturated_fatty_acids_calculated = round($inp_item_fat_of_which_saturated_fatty_acids_calculated, 0);
					$inp_item_fat_of_which_saturated_fatty_acids_calculated_mysql = quote_smart($link, $inp_item_fat_of_which_saturated_fatty_acids_calculated);


				$inp_item_carbs_per_hundred = $_POST['inp_item_carbs_per_hundred'];
				$inp_item_carbs_per_hundred = output_html($inp_item_carbs_per_hundred);
				$inp_item_carbs_per_hundred = str_replace(",", ".", $inp_item_carbs_per_hundred);
				if(empty($inp_item_carbs_per_hundred)){
					$inp_item_carbs_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_calories_per_hundred))){
						$ft = "error";
						$fm = "calories_have_to_be_a_number";
					}
				}
				$inp_item_carbs_per_hundred = round($inp_item_carbs_per_hundred, 0);
				$inp_item_carbs_per_hundred_mysql = quote_smart($link, $inp_item_carbs_per_hundred);

					$inp_item_carbs_calculated = $_POST['inp_item_carbs_calculated'];
					$inp_item_carbs_calculated = output_html($inp_item_carbs_calculated);
					$inp_item_carbs_calculated = str_replace(",", ".", $inp_item_carbs_calculated);
					if(empty($inp_item_carbs_calculated)){
						$inp_item_carbs_calculated = "0";
					}
					else{
						if(!(is_numeric($inp_item_calories_calculated))){
							$ft = "error";
							$fm = "calories_have_to_be_a_number";
						}
					}
					$inp_item_carbs_calculated = round($inp_item_carbs_calculated, 0);
					$inp_item_carbs_calculated_mysql = quote_smart($link, $inp_item_carbs_calculated);


				$inp_item_carbs_of_which_sugars_per_hundred = $_POST['inp_item_carbs_of_which_sugars_per_hundred'];
				$inp_item_carbs_of_which_sugars_per_hundred = output_html($inp_item_carbs_of_which_sugars_per_hundred);
				$inp_item_carbs_of_which_sugars_per_hundred = str_replace(",", ".", $inp_item_carbs_of_which_sugars_per_hundred);
				if(empty($inp_item_carbs_of_which_sugars_per_hundred)){
					$inp_item_carbs_of_which_sugars_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_carbs_of_which_sugars_per_hundred))){
						$ft = "error";
						$fm = "carbs_of_which_sugars_per_hundred_have_to_be_a_number";
					}
				}
				$inp_item_carbs_of_which_sugars_per_hundred = round($inp_item_carbs_of_which_sugars_per_hundred, 0);
				$inp_item_carbs_of_which_sugars_per_hundred_mysql = quote_smart($link, $inp_item_carbs_of_which_sugars_per_hundred);


					$inp_item_carbs_of_which_sugars_calculated = $_POST['inp_item_carbs_of_which_sugars_calculated'];
					$inp_item_carbs_of_which_sugars_calculated = output_html($inp_item_carbs_of_which_sugars_calculated);
					$inp_item_carbs_of_which_sugars_calculated = str_replace(",", ".", $inp_item_carbs_of_which_sugars_calculated);
					if(empty($inp_item_carbs_of_which_sugars_calculated)){
						$inp_item_carbs_of_which_sugars_calculated = "0";
					}
					else{
						if(!(is_numeric($inp_item_carbs_of_which_sugars_calculated))){
							$ft = "error";
							$fm = "carbs_of_which_sugars_calculated_have_to_be_a_number";
						}
					}
					$inp_item_carbs_of_which_sugars_calculated = round($inp_item_carbs_of_which_sugars_calculated, 0);
					$inp_item_carbs_of_which_sugars_calculated_mysql = quote_smart($link, $inp_item_carbs_of_which_sugars_calculated);
	

				$inp_item_proteins_per_hundred = $_POST['inp_item_proteins_per_hundred'];
				$inp_item_proteins_per_hundred = output_html($inp_item_proteins_per_hundred);
				$inp_item_proteins_per_hundred = str_replace(",", ".", $inp_item_proteins_per_hundred);
				if(empty($inp_item_proteins_per_hundred)){
					$inp_item_proteins_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_proteins_per_hundred))){
						$ft = "error";
						$fm = "proteins_have_to_be_a_number";
					}
				}
				$inp_item_proteins_per_hundred = round($inp_item_proteins_per_hundred, 0);
				$inp_item_proteins_per_hundred_mysql = quote_smart($link, $inp_item_proteins_per_hundred);


					$inp_item_proteins_calculated = $_POST['inp_item_proteins_calculated'];
					$inp_item_proteins_calculated = output_html($inp_item_proteins_calculated);
					$inp_item_proteins_calculated = str_replace(",", ".", $inp_item_proteins_calculated);
					if(empty($inp_item_proteins_calculated)){
						$inp_item_proteins_calculated = "0";
					}
					else{
						if(!(is_numeric($inp_item_proteins_calculated))){
							$ft = "error";
							$fm = "proteins_have_to_be_a_number";
						}
					}
					$inp_item_proteins_calculated_mysql = quote_smart($link, $inp_item_proteins_calculated);


				$inp_item_salt_per_hundred = $_POST['inp_item_salt_per_hundred'];
				$inp_item_salt_per_hundred = output_html($inp_item_salt_per_hundred);
				$inp_item_salt_per_hundred = str_replace(",", ".", $inp_item_salt_per_hundred);
				if(empty($inp_item_salt_per_hundred)){
					$inp_item_salt_per_hundred = "0";
				}
				else{
					if(!(is_numeric($inp_item_salt_per_hundred))){
						$ft = "error";
						$fm = "salt_have_to_be_a_number";
					}
				}
				$inp_item_salt_per_hundred = round($inp_item_salt_per_hundred, 0);
				$inp_item_salt_per_hundred_mysql = quote_smart($link, $inp_item_salt_per_hundred);

					$inp_item_salt_calculated = $_POST['inp_item_salt_calculated'];
					$inp_item_salt_calculated = output_html($inp_item_salt_calculated);
					$inp_item_salt_calculated = str_replace(",", ".", $inp_item_salt_calculated);
					if(empty($inp_item_salt_calculated)){
						$inp_item_salt_calculated = "0";
					}
					else{
						if(!(is_numeric($inp_item_salt_calculated))){
							$ft = "error";
							$fm = "salt_have_to_be_a_number";
						}
					}
					$inp_item_salt_calculated = round($inp_item_salt_calculated, 0);
					$inp_item_salt_calculated_mysql = quote_smart($link, $inp_item_salt_calculated);


					if(isset($fm) && $fm != ""){
						$url = "edit_recipe_ingredients.php?action=edit_item&recipe_id=$get_recipe_id&group_id=$get_group_id&item_id=$get_item_id&l=$l";
						$url = $url . "&ft=$ft&fm=$fm";

						header("Location: $url");
						exit;
					}

					// Calculate
					//$inp_item_calories_per_hundred = $inp_item_calories_calculated/
					//$item_proteins_per_hundred, item_fat_per_hundred, item_carbs_per_hundred




					// Update
					$result = mysqli_query($link, "UPDATE $t_recipes_items SET item_amount=$inp_item_amount_mysql, item_measurement=$inp_item_measurement_mysql, 
						item_grocery=$inp_item_grocery_mysql, item_food_id=$inp_item_food_id_mysql, 
						item_calories_per_hundred=$inp_item_calories_per_hundred_mysql,
						item_fat_per_hundred=$inp_item_fat_per_hundred_mysql,
						item_fat_of_which_saturated_fatty_acids_per_hundred=$inp_item_fat_of_which_saturated_fatty_acids_per_hundred_mysql,
						item_carbs_per_hundred=$inp_item_carbs_per_hundred_mysql, 
						item_carbs_of_which_sugars_per_hundred=$inp_item_carbs_of_which_sugars_per_hundred_mysql,
						item_proteins_per_hundred=$inp_item_proteins_per_hundred_mysql,
						item_salt_per_hundred=$inp_item_salt_per_hundred_mysql,
						item_calories_calculated=$inp_item_calories_calculated_mysql, 
						item_fat_calculated=$inp_item_fat_calculated_mysql, 
						item_fat_of_which_saturated_fatty_acids_calculated=$inp_item_fat_of_which_saturated_fatty_acids_calculated_mysql,  
						item_carbs_calculated=$inp_item_carbs_calculated_mysql,
						item_carbs_of_which_sugars_calculated=$inp_item_carbs_of_which_sugars_calculated_mysql, 
						item_proteins_calculated=$inp_item_proteins_calculated_mysql, 
						item_salt_calculated=$inp_item_salt_calculated_mysql
						 WHERE item_id=$get_item_id") or die(mysqli_error($link));

					// Calculating total numbers
					$inp_number_hundred_calories = 0;
					$inp_number_hundred_proteins = 0;
					$inp_number_hundred_fat = 0;
					$inp_number_hundred_carbs = 0;
					
					$inp_number_serving_calories = 0;
					$inp_number_serving_proteins = 0;
					$inp_number_serving_fat = 0;
					$inp_number_serving_carbs = 0;
					
					$inp_number_total_weight = 0;
	
					$inp_number_total_calories = 0;
					$inp_number_total_proteins = 0;
					$inp_number_total_fat = 0;

					$inp_number_total_carbs = 0;
					
					$query_groups = "SELECT group_id, group_title FROM $t_recipes_groups WHERE group_recipe_id=$get_recipe_id";
					$result_groups = mysqli_query($link, $query_groups);
					while($row_groups = mysqli_fetch_row($result_groups)) {
						list($get_group_id, $get_group_title) = $row_groups;

						$query_items = "SELECT item_id, item_amount, item_calories_per_hundred, item_proteins_per_hundred, item_fat_per_hundred, item_carbs_per_hundred, item_calories_calculated, item_proteins_calculated, item_fat_calculated, item_carbs_calculated FROM $t_recipes_items WHERE item_group_id=$get_group_id";
						$result_items = mysqli_query($link, $query_items);
						$row_cnt = mysqli_num_rows($result_items);
						while($row_items = mysqli_fetch_row($result_items)) {
							list($get_item_id, $get_item_amount, $get_item_calories_per_hundred, $get_item_proteins_per_hundred, $get_item_fat_per_hundred, $get_item_carbs_per_hundred, $get_item_calories_calculated, $get_item_proteins_calculated, $get_item_fat_calculated, $get_item_carbs_calculated) = $row_items;

							$inp_number_hundred_calories = $inp_number_hundred_calories+$get_item_calories_per_hundred;
							$inp_number_hundred_proteins = $inp_number_hundred_proteins+$get_item_proteins_per_hundred;
							$inp_number_hundred_fat      = $inp_number_hundred_fat+$get_item_fat_per_hundred;
							$inp_number_hundred_carbs    = $inp_number_hundred_carbs+$get_item_carbs_per_hundred;
					
							$inp_number_total_weight     = $inp_number_total_weight+$get_item_amount;

							$inp_number_total_calories = $inp_number_total_calories+$get_item_calories_calculated;
							$inp_number_total_proteins = $inp_number_total_proteins+$get_item_proteins_calculated;
							$inp_number_total_fat      = $inp_number_total_fat+$get_item_fat_calculated;
							$inp_number_total_carbs    = $inp_number_total_carbs+$get_item_carbs_calculated;
	
						} // items
					} // groups
					
					$inp_number_serving_calories = round($inp_number_total_calories/$get_number_servings);
					$inp_number_serving_proteins = round($inp_number_total_proteins/$get_number_servings);
					$inp_number_serving_fat      = round($inp_number_total_fat/$get_number_servings);
					$inp_number_serving_carbs    = round($inp_number_total_carbs/$get_number_servings);

	
					// Ready numbers for MySQL
					$inp_number_hundred_calories_mysql = quote_smart($link, $inp_number_hundred_calories);
					$inp_number_hundred_proteins_mysql = quote_smart($link, $inp_number_hundred_proteins);
					$inp_number_hundred_fat_mysql      = quote_smart($link, $inp_number_hundred_fat);
					$inp_number_hundred_carbs_mysql    = quote_smart($link, $inp_number_hundred_carbs);
					
					$inp_number_total_weight_mysql     = quote_smart($link, $inp_number_total_weight);

					$inp_number_total_calories_mysql = quote_smart($link, $inp_number_total_calories);
					$inp_number_total_proteins_mysql = quote_smart($link, $inp_number_total_proteins);
					$inp_number_total_fat_mysql      = quote_smart($link, $inp_number_total_fat);
					$inp_number_total_carbs_mysql    = quote_smart($link, $inp_number_total_carbs);

						
					$inp_number_serving_calories_mysql = quote_smart($link, $inp_number_serving_calories);
					$inp_number_serving_proteins_mysql = quote_smart($link, $inp_number_serving_proteins);
					$inp_number_serving_fat_mysql      = quote_smart($link, $inp_number_serving_fat);
					$inp_number_serving_carbs_mysql    = quote_smart($link, $inp_number_serving_carbs);

					$result = mysqli_query($link, "UPDATE $t_recipes_numbers SET number_hundred_calories=$inp_number_hundred_calories_mysql, number_hundred_proteins=$inp_number_hundred_proteins_mysql, number_hundred_fat=$inp_number_hundred_fat_mysql, number_hundred_carbs=$inp_number_hundred_carbs_mysql, 
								number_serving_calories=$inp_number_serving_calories_mysql, number_serving_proteins=$inp_number_serving_proteins_mysql, number_serving_fat=$inp_number_serving_fat_mysql, number_serving_carbs=$inp_number_serving_carbs_mysql,
								number_total_weight=$inp_number_total_weight_mysql, 
								number_total_calories=$inp_number_total_calories_mysql, number_total_proteins=$inp_number_total_proteins_mysql, number_total_fat=$inp_number_total_fat_mysql, number_total_carbs=$inp_number_total_carbs_mysql WHERE number_recipe_id=$recipe_id_mysql");

	

					// Header
					$ft = "success";
					$fm = "changes_saved";

					$url = "edit_recipe_ingredients.php?recipe_id=$get_recipe_id&action=edit_item&group_id=$group_id&item_id=$item_id&l=$l";
					$url = $url . "&ft=$ft&fm=$fm";
					header("Location: $url");
					exit;	
				}

				echo"
				<h1>$get_recipe_title</h1>

				<!-- Menu -->
					<div class=\"tabs\">
						<ul>
							<li><a href=\"edit_recipe.php?recipe_id=$recipe_id&amp;l=$l\">$l_general</a>
							<li><a href=\"edit_recipe_ingredients.php?recipe_id=$recipe_id&amp;l=$l\" class=\"active\">$l_ingredients</a>
							<li><a href=\"edit_recipe_categorization.php?recipe_id=$recipe_id&amp;l=$l\">$l_categorization</a>
							<li><a href=\"edit_recipe_image.php?recipe_id=$recipe_id&amp;l=$l\">$l_image</a>
							<li><a href=\"edit_recipe_video.php?recipe_id=$recipe_id&amp;l=$l\">$l_video</a>
						</ul>
					</div><p>&nbsp;</p>
				<!-- //Menu -->

				<h2>$l_edit_ingredients</h2>

				<h3>$get_group_title</h3>


				<!-- Feedback -->
				";
				if($ft != ""){
					if($fm == "changes_saved"){
						$fm = "$l_changes_saved";
					}
					elseif($fm == "amound_cant_be_empty"){
						$fm = "$l_amound_cant_be_empty";
					}
					elseif($fm == "amound_has_to_be_a_number"){
						$fm = "$l_amound_has_to_be_a_number";
					}
					elseif($fm == "measurement_cant_be_empty"){
						$fm = "$l_measurement_cant_be_empty";
					}
					elseif($fm == "grocery_cant_be_empty"){
						$fm = "$l_grocery_cant_be_empty";
					}
					elseif($fm == "calories_cant_be_empty"){
						$fm = "$l_calories_cant_be_empty";
					}
					elseif($fm == "proteins_cant_be_empty"){
						$fm = "$l_proteins_cant_be_empty";
					}
					elseif($fm == "fat_cant_be_empty"){
						$fm = "$l_fat_cant_be_empty";
					}
					elseif($fm == "carbs_cant_be_empty"){
						$fm = "$l_carbs_cant_be_empty";
					}
					elseif($fm == "calories_have_to_be_a_number"){
						$fm = "$l_calories_have_to_be_a_number";
					}
					elseif($fm == "proteins_have_to_be_a_number"){
						$fm = "$l_proteins_have_to_be_a_number";
					}
					elseif($fm == "carbs_have_to_be_a_number"){
						$fm = "$l_carbs_have_to_be_a_number";
					}
					elseif($fm == "fat_have_to_be_a_number"){
						$fm = "$l_fat_have_to_be_a_number";
					}
					else{
						$fm = ucfirst($fm);
					}
					echo"<div class=\"$ft\"><span>$fm</span></div>";
				}
				echo"	
				<!-- //Feedback -->

				<!-- Edit item -->
					<!-- Focus -->
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_item_amount\"]').focus();
						});
						</script>
					<!-- //Focus -->

				
					<form method=\"post\" action=\"edit_recipe_ingredients.php?action=$action&amp;recipe_id=$get_recipe_id&amp;group_id=$get_group_id&amp;item_id=$get_item_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
		
					<h2 style=\"padding-bottom:0;margin-bottom:0;\">$l_food</h2>
					<table>
					 <tbody>
					  <tr>
					   <td style=\"padding: 0px 20px 0px 0px;\">
						<p>$l_amount<br />
						<input type=\"text\" name=\"inp_item_amount\" id=\"inp_item_amount\" size=\"3\" value=\"$get_item_amount\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
						</p>
					   </td>
					   <td>
						<p>$l_measurement<br />
						<input type=\"text\" name=\"inp_item_measurement\" size=\"3\" value=\"$get_item_measurement\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
						</p>
					   </td>
					  </tr>
					</table>
					<p>$l_grocery &middot; <a href=\"$root/food/new_food.php?l=$l\" target=\"_blank\">$l_new_food</a><br />

					<input type=\"text\" name=\"inp_item_grocery\" class=\"inp_item_grocery\" size=\"25\" value=\"$get_item_grocery\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" id=\"nettport_inp_search_query\" />
					<input type=\"hidden\" name=\"inp_item_food_id\" id=\"inp_item_food_id\" /></p>

					<div id=\"nettport_search_results\">
					</div><div class=\"clear\"></div></span>


					<h2 style=\"padding-bottom:0;margin-bottom:0;\">$l_numbers</h2>
					<table class=\"hor-zebra\" style=\"width: 350px\">
					 <thead>
					  <tr>
					   <th scope=\"col\">
					   </th>
					   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;vertical-align: bottom;\">
						<span>$l_per_hundred</span>
					   </th>
					   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;vertical-align: bottom;\">
						<span>$l_calculated</span>
					   </th>
					  </tr>
					 </thead>
					 <tbody>
					  <tr>
					   <td style=\"padding: 8px 4px 6px 8px;\">
						<span>$l_energy</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span><input type=\"text\" name=\"inp_item_calories_per_hundred\" id=\"inp_item_calories_per_hundred\" size=\"5\" value=\"$get_item_calories_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span><input type=\"text\" name=\"inp_item_calories_calculated\" id=\"inp_item_calories_calculated\" size=\"5\" value=\"$get_item_calories_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></span>
					   </td>
					  </tr>
					  <tr>
					   <td style=\"padding: 8px 4px 6px 8px;\">
						<p style=\"margin:0;padding: 0px 0px 4px 0px;\">$l_fat</p>
						<p style=\"margin:0;padding: 0;\">$l_dash_of_which_saturated_fatty_acids</p>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_item_fat_per_hundred\" id=\"inp_item_fat_per_hundred\" size=\"5\" value=\"$get_item_fat_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
						<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_item_fat_of_which_saturated_fatty_acids_per_hundred\" id=\"inp_item_fat_of_which_saturated_fatty_acids_per_hundred\" size=\"5\" value=\"$get_item_fat_of_which_saturated_fatty_acids_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_item_fat_calculated\" id=\"inp_item_fat_calculated\" size=\"5\" value=\"$get_item_fat_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
						<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_item_fat_of_which_saturated_fatty_acids_calculated\" id=\"inp_item_fat_of_which_saturated_fatty_acids_calculated\" size=\"5\" value=\"$get_item_fat_of_which_saturated_fatty_acids_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
					   </td>
					  </tr>
					  <tr>
		 			  <td style=\"padding: 8px 4px 6px 8px;\">
						<p style=\"margin:0;padding: 0px 0px 4px 0px;\">$l_carbs</p>
						<p style=\"margin:0;padding: 0;\">$l_dash_of_which_sugars_calculated</p>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_item_carbs_per_hundred\" id=\"inp_item_carbs_per_hundred\" size=\"5\" value=\"$get_item_carbs_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
						<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_item_carbs_of_which_sugars_per_hundred\" id=\"inp_item_carbs_of_which_sugars_per_hundred\" size=\"5\" value=\"$get_item_carbs_of_which_sugars_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_item_carbs_calculated\" id=\"inp_item_carbs_calculated\" size=\"5\" value=\"$get_item_carbs_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
						<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_item_carbs_of_which_sugars_calculated\" id=\"inp_item_carbs_of_which_sugars_calculated\" size=\"5\" value=\"$get_item_carbs_of_which_sugars_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
					   </td>
					  </tr>
					  <tr>
					   <td style=\"padding: 8px 4px 6px 8px;\">
						<span>$l_proteins</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span><input type=\"text\" name=\"inp_item_proteins_per_hundred\" id=\"inp_item_proteins_per_hundred\" size=\"5\" value=\"$get_item_proteins_per_hundred\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span><input type=\"text\" name=\"inp_item_proteins_calculated\" id=\"inp_item_proteins_calculated\" size=\"5\" value=\"$get_item_proteins_calculated\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></span>
					   </td>
					  </tr>
					 </tr>
					  <tr>
					   <td style=\"padding: 8px 4px 6px 8px;\">
						<span>$l_sodium_in_gram</span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span><input type=\"text\" name=\"inp_item_salt_per_hundred\" id=\"inp_item_salt_per_hundred\" value=\"$get_item_salt_per_hundred\" size=\"5\" /></span>
					   </td>
					   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
						<span><input type=\"text\" name=\"inp_item_salt_calculated\" id=\"inp_item_salt_calculated\" value=\"$get_item_salt_calculated\" size=\"5\" /></span>
					   </td>
					  </tr>
					 </tbody>
					</table>

					<p>
					<input type=\"submit\" value=\"$l_save\" class=\"btn\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
					</p>


					</form>
					<!-- Search script -->
					<script id=\"source\" language=\"javascript\" type=\"text/javascript\">
					\$(document).ready(function () {
						\$('#nettport_inp_search_query').keyup(function () {
							$(\"#nettport_search_results\").show();
       							// getting the value that user typed
       							var searchString    = $(\"#nettport_inp_search_query\").val();
 							// forming the queryString
      							var data            = 'l=$l&q='+ searchString;
         
        						// if searchString is not empty
        						if(searchString) {
           							// ajax call
            							\$.ajax({
                							type: \"POST\",
               								url: \"submit_recipe_step_2_group_and_elements_search_jquery.php\",
                							data: data,
									beforeSend: function(html) { // this happens before actual call
										\$(\"#nettport_search_results\").html(''); 
									},
               								success: function(html){
                    								\$(\"#nettport_search_results\").append(html);
              								}
            							});
       							}
        						return false;
            					});
         				   });
					</script>
					<!-- //Search script -->
				<!-- //Edit item -->

				<!-- Buttons -->
					<p>
					<a href=\"edit_recipe_ingredients.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"btn btn_default\">$l_add_another_group</a>
					</p>
				<!-- //Buttons -->
				";

			} // item found

		} // group found

	} // action == "edit_item")
	elseif($action == "delete_item"){

		// Get group

		$group_id_mysql = quote_smart($link, $group_id);

		$query = "SELECT group_id, group_recipe_id, group_title FROM $t_recipes_groups WHERE group_id=$group_id_mysql AND group_recipe_id=$get_recipe_id";

		$result = mysqli_query($link, $query);

		$row = mysqli_fetch_row($result);

		list($get_group_id, $get_group_recipe_id, $get_group_title) = $row;



		if($get_group_id == ""){

			echo"

			<h1>Server error</h1>



			<p>

			Group not found.

			</p>

			";

		}

		else{

			// Get item

			$item_id_mysql = quote_smart($link, $item_id);

			$query = "SELECT item_id, item_recipe_id, item_group_id, item_amount, item_measurement, item_grocery, item_calories_per_hundred, item_proteins_per_hundred, item_fat_per_hundred, item_carbs_per_hundred, item_calories_calculated, item_proteins_calculated, item_fat_calculated, item_carbs_calculated FROM $t_recipes_items WHERE item_id=$item_id_mysql AND item_recipe_id=$get_recipe_id AND item_group_id=$get_group_id";

			$result = mysqli_query($link, $query);

			$row = mysqli_fetch_row($result);

			list($get_item_id, $get_item_recipe_id, $get_item_group_id, $get_item_amount, $get_item_measurement, $get_item_grocery, $get_item_calories_per_hundred, $get_item_proteins_per_hundred, $get_item_fat_per_hundred, $get_item_carbs_per_hundred, $get_item_calories_calculated, $get_item_proteins_calculated, $get_item_fat_calculated, $get_item_carbs_calculated) = $row;





			if($get_item_id == ""){

				echo"

				<h1>Server error</h1>



				<p>

				Items not found.

				</p>

				";

			}

			else{



				if($process == "1"){

					



					// Delete

					$result = mysqli_query($link, "DELETE FROM $t_recipes_items WHERE item_id=$get_item_id");



			



					// Calculating total numbers

					$inp_number_hundred_calories = 0;

					$inp_number_hundred_proteins = 0;

					$inp_number_hundred_fat = 0;

					$inp_number_hundred_carbs = 0;

					

					$inp_number_serving_calories = 0;

					$inp_number_serving_proteins = 0;

					$inp_number_serving_fat = 0;

					$inp_number_serving_carbs = 0;

					

					$inp_number_total_weight = 0;

	

					$inp_number_total_calories = 0;

					$inp_number_total_proteins = 0;

					$inp_number_total_fat = 0;



					$inp_number_total_carbs = 0;

					

					$query_groups = "SELECT group_id, group_title FROM $t_recipes_groups WHERE group_recipe_id=$get_recipe_id";

					$result_groups = mysqli_query($link, $query_groups);

					while($row_groups = mysqli_fetch_row($result_groups)) {

						list($get_group_id, $get_group_title) = $row_groups;



						$query_items = "SELECT item_id, item_amount, item_calories_per_hundred, item_proteins_per_hundred, item_fat_per_hundred, item_carbs_per_hundred, item_calories_calculated, item_proteins_calculated, item_fat_calculated, item_carbs_calculated FROM $t_recipes_items WHERE item_group_id=$get_group_id";

						$result_items = mysqli_query($link, $query_items);

						$row_cnt = mysqli_num_rows($result_items);

						while($row_items = mysqli_fetch_row($result_items)) {

							list($get_item_id, $get_item_amount, $get_item_calories_per_hundred, $get_item_proteins_per_hundred, $get_item_fat_per_hundred, $get_item_carbs_per_hundred, $get_item_calories_calculated, $get_item_proteins_calculated, $get_item_fat_calculated, $get_item_carbs_calculated) = $row_items;



							$inp_number_hundred_calories = $inp_number_hundred_calories+$get_item_calories_per_hundred;

							$inp_number_hundred_proteins = $inp_number_hundred_proteins+$get_item_proteins_per_hundred;

							$inp_number_hundred_fat      = $inp_number_hundred_fat+$get_item_fat_per_hundred;

							$inp_number_hundred_carbs    = $inp_number_hundred_carbs+$get_item_carbs_per_hundred;

					

							$inp_number_total_weight     = $inp_number_total_weight+$get_item_amount;



							$inp_number_total_calories = $inp_number_total_calories+$get_item_calories_calculated;

							$inp_number_total_proteins = $inp_number_total_proteins+$get_item_proteins_calculated;

							$inp_number_total_fat      = $inp_number_total_fat+$get_item_fat_calculated;

							$inp_number_total_carbs    = $inp_number_total_carbs+$get_item_carbs_calculated;

	

						} // items

					} // groups

					

					$inp_number_serving_calories = round($inp_number_total_calories/$get_number_servings);

					$inp_number_serving_proteins = round($inp_number_total_proteins/$get_number_servings);

					$inp_number_serving_fat      = round($inp_number_total_fat/$get_number_servings);

					$inp_number_serving_carbs    = round($inp_number_total_carbs/$get_number_servings);



	

					// Ready numbers for MySQL

					$inp_number_hundred_calories_mysql = quote_smart($link, $inp_number_hundred_calories);

					$inp_number_hundred_proteins_mysql = quote_smart($link, $inp_number_hundred_proteins);

					$inp_number_hundred_fat_mysql      = quote_smart($link, $inp_number_hundred_fat);

					$inp_number_hundred_carbs_mysql    = quote_smart($link, $inp_number_hundred_carbs);

					

					$inp_number_total_weight_mysql     = quote_smart($link, $inp_number_total_weight);



					$inp_number_total_calories_mysql = quote_smart($link, $inp_number_total_calories);

					$inp_number_total_proteins_mysql = quote_smart($link, $inp_number_total_proteins);

					$inp_number_total_fat_mysql      = quote_smart($link, $inp_number_total_fat);

					$inp_number_total_carbs_mysql    = quote_smart($link, $inp_number_total_carbs);



						

					$inp_number_serving_calories_mysql = quote_smart($link, $inp_number_serving_calories);

					$inp_number_serving_proteins_mysql = quote_smart($link, $inp_number_serving_proteins);

					$inp_number_serving_fat_mysql      = quote_smart($link, $inp_number_serving_fat);

					$inp_number_serving_carbs_mysql    = quote_smart($link, $inp_number_serving_carbs);



					$result = mysqli_query($link, "UPDATE $t_recipes_numbers SET number_hundred_calories=$inp_number_hundred_calories_mysql, number_hundred_proteins=$inp_number_hundred_proteins_mysql, number_hundred_fat=$inp_number_hundred_fat_mysql, number_hundred_carbs=$inp_number_hundred_carbs_mysql, 

								number_serving_calories=$inp_number_serving_calories_mysql, number_serving_proteins=$inp_number_serving_proteins_mysql, number_serving_fat=$inp_number_serving_fat_mysql, number_serving_carbs=$inp_number_serving_carbs_mysql,

								number_total_weight=$inp_number_total_weight_mysql, 

								number_total_calories=$inp_number_total_calories_mysql, number_total_proteins=$inp_number_total_proteins_mysql, number_total_fat=$inp_number_total_fat_mysql, number_total_carbs=$inp_number_total_carbs_mysql WHERE number_recipe_id=$recipe_id_mysql");



	



					// Header

					$ft = "success";

					$fm = "item_deleted";



					$url = "edit_recipe_ingredients.php?recipe_id=$get_recipe_id&l=$l";

					$url = $url . "&ft=$ft&fm=$fm";

					header("Location: $url");

					exit;	



				



				}
				echo"
				<h1>$get_recipe_title</h1>





				<!-- Menu -->

					<div class=\"tabs\">
					<ul>
						<li><a href=\"edit_recipe.php?recipe_id=$recipe_id&amp;l=$l\">$l_general</a>
						<li><a href=\"edit_recipe_ingredients.php?recipe_id=$recipe_id&amp;l=$l\" class=\"active\">$l_ingredients</a>
						<li><a href=\"edit_recipe_categorization.php?recipe_id=$recipe_id&amp;l=$l\">$l_categorization</a>
						<li><a href=\"edit_recipe_image.php?recipe_id=$recipe_id&amp;l=$l\">$l_image</a>
						<li><a href=\"edit_recipe_video.php?recipe_id=$recipe_id&amp;l=$l\">$l_video</a>
					</ul>
					</div><p>&nbsp;</p>
				<!-- //Menu -->



				<h2>$l_delete_ingredients</h2>

				<h3>$get_group_title - $get_item_grocery</h3>


				<!-- Delete item -->
					<p>
					$l_are_you_sure_you_want_to_delete
					$l_the_action_cant_be_undone
					</p>


					<p>
					<a href=\"edit_recipe_ingredients.php?action=$action&amp;recipe_id=$get_recipe_id&amp;group_id=$get_group_id&amp;item_id=$get_item_id&amp;l=$l&amp;process=1\" class=\"btn btn_warning\">$l_delete</a>			

					<a href=\"edit_recipe_ingredients.php?&amp;recipe_id=$get_recipe_id&amp;group_id=$get_group_id&amp;item_id=$get_item_id&amp;l=$l\" class=\"btn btn_default\">$l_cancel</a>		

					</p>
				<!-- //Edit item -->

				";

			} // item found
		} // group found
	} // action == "delete_item")

		} // is owner or admin
		else{
			echo"<p>Server error 403</p>
			<p>Only the owner and admin can edit the recipe</p>
			";
		}
	} // Isset user id
	else{
		echo"
		<h1>Log in</h1>
		<p><a href=\"$root/users/login.php?l=$l\">Please log in</a>
		</p>
		";
	}
} // recipe found



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");

?>