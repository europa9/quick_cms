<?php 
/**
*
* File: meal_plans/new_meal_plan_step_2_entries.php
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
include("_tables_meal_plans.php");

/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/meal_plans/ts_new_meal_plan.php");

/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['meal_plan_id'])){
	$meal_plan_id = $_GET['meal_plan_id'];
	$meal_plan_id = output_html($meal_plan_id);
}
else{
	$meal_plan_id = "";
}
if(isset($_GET['entry_day_number'])){
	$entry_day_number = $_GET['entry_day_number'];
	$entry_day_number = output_html($entry_day_number);
}
else{
	$entry_day_number = "";
}
if(isset($_GET['entry_meal_number'])){
	$entry_meal_number = $_GET['entry_meal_number'];
	$entry_meal_number = output_html($entry_meal_number);
}
else{
	$entry_meal_number = "";
}

$tabindex = 0;
$l_mysql = quote_smart($link, $l);




/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_meal_plans - $l_new_meal_plan";
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

	// Get meal_plan
	$meal_plan_id_mysql = quote_smart($link, $meal_plan_id);
	$query = "SELECT meal_plan_id, meal_plan_user_id, meal_plan_language, meal_plan_title, meal_plan_title_clean, meal_plan_number_of_days, meal_plan_introduction, meal_plan_total_energy_without_training, meal_plan_total_fat_without_training, meal_plan_total_carb_without_training, meal_plan_total_protein_without_training, meal_plan_total_energy_with_training, meal_plan_total_fat_with_training, meal_plan_total_carb_with_training, meal_plan_total_protein_with_training, meal_plan_average_kcal_without_training, meal_plan_average_fat_without_training, meal_plan_average_carb_without_training, meal_plan_average_protein_without_training, meal_plan_average_kcal_with_training, meal_plan_average_fat_with_training, meal_plan_average_carb_with_training, meal_plan_average_protein_with_training, meal_plan_created, meal_plan_updated, meal_plan_user_ip, meal_plan_image_path, meal_plan_image_file, meal_plan_views, meal_plan_views_ip_block, meal_plan_likes, meal_plan_dislikes, meal_plan_rating, meal_plan_rating_ip_block, meal_plan_comments FROM $t_meal_plans WHERE meal_plan_id=$meal_plan_id_mysql AND meal_plan_user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_meal_plan_id, $get_current_meal_plan_user_id, $get_current_meal_plan_language, $get_current_meal_plan_title, $get_current_meal_plan_title_clean, $get_current_meal_plan_number_of_days, $get_current_meal_plan_introduction, $get_current_meal_plan_total_energy_without_training, $get_current_meal_plan_total_fat_without_training, $get_current_meal_plan_total_carb_without_training, $get_current_meal_plan_total_protein_without_training, $get_current_meal_plan_total_energy_with_training, $get_current_meal_plan_total_fat_with_training, $get_current_meal_plan_total_carb_with_training, $get_current_meal_plan_total_protein_with_training, $get_current_meal_plan_average_kcal_without_training, $get_current_meal_plan_average_fat_without_training, $get_current_meal_plan_average_carb_without_training, $get_current_meal_plan_average_protein_without_training, $get_current_meal_plan_average_kcal_with_training, $get_current_meal_plan_average_fat_with_training, $get_current_meal_plan_average_carb_with_training, $get_current_meal_plan_average_protein_with_training, $get_current_meal_plan_created, $get_current_meal_plan_updated, $get_current_meal_plan_user_ip, $get_current_meal_plan_image_path, $get_current_meal_plan_image_file, $get_current_meal_plan_views, $get_current_meal_plan_views_ip_block, $get_current_meal_plan_likes, $get_current_meal_plan_dislikes, $get_current_meal_plan_rating, $get_current_meal_plan_rating_ip_block, $get_current_meal_plan_comments) = $row;
	
	

	if($get_current_meal_plan_id == ""){
		echo"<p>Meal plan not found.</p>";
	}
	else{
		if($process == 1){



			$inp_entry_day_number = output_html($entry_day_number);
			$inp_entry_day_number_mysql = quote_smart($link, $inp_entry_day_number);

			$inp_entry_meal_number = output_html($entry_meal_number);
			$inp_entry_meal_number_mysql = quote_smart($link, $inp_entry_meal_number);


			if(isset($_GET['entry_serving_size'])) {
				$entry_serving_size = $_GET['entry_serving_size'];
			}
			else{
				$entry_serving_size = 1;
			}
			$inp_entry_serving_size = output_html($entry_serving_size);
			$inp_entry_serving_size = str_replace(",", ".", $inp_entry_serving_size);
			$inp_entry_serving_size_mysql = quote_smart($link, $inp_entry_serving_size);
			if($inp_entry_serving_size == ""){
				$url = "new_meal_plan_step_2_entries_new_entry_recipe.php?meal_plan_id=$meal_plan_id&entry_day_number=$entry_day_number&entry_meal_number=$entry_meal_number&l=$l&action=new_entry_food";
				$url = $url . "&ft=error&fm=missing_amount";
				header("Location: $url");
				exit;
			}
				
			// get recipe
			if(isset($_GET['recipe_id'])) {
				$recipe_id = $_GET['recipe_id'];
				$recipe_id = strip_tags(stripslashes($recipe_id));
			}
			else{
				$url = "new_meal_plan_step_2_entries_new_entry_recipe.php?meal_plan_id=$meal_plan_id&entry_day_number=$entry_day_number&entry_meal_number=$entry_meal_number&l=$l&action=new_entry_food";
				$url = $url . "&ft=error&fm=missing_recipe";
				header("Location: $url");
				exit;
			}
			
			// Get recipe	
			$recipe_id_mysql = quote_smart($link, $recipe_id);
			$query = "SELECT recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password FROM $t_recipes WHERE recipe_id=$recipe_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_recipe_id, $get_recipe_user_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_language, $get_recipe_introduction, $get_recipe_directions, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb, $get_recipe_video, $get_recipe_date, $get_recipe_time, $get_recipe_cusine_id, $get_recipe_season_id, $get_recipe_occasion_id, $get_recipe_marked_as_spam, $get_recipe_unique_hits, $get_recipe_unique_hits_ip_block, $get_recipe_user_ip, $get_recipe_notes, $get_recipe_password) = $row;
			if($get_recipe_id == ""){
				$url = "new_meal_plan_step_2_entries_new_entry_recipe.php?meal_plan_id=$meal_plan_id&entry_day_number=$entry_day_number&entry_meal_number=$entry_meal_number&l=$l&action=new_entry_food";
				$url = $url . "&ft=error&fm=recipe_specified_not_found";
				header("Location: $url");
				exit;
			}

			// get numbers
			$query = "SELECT number_id, number_recipe_id, number_hundred_calories, number_hundred_proteins, number_hundred_fat, number_hundred_carbs, number_serving_calories, number_serving_proteins, number_serving_fat, number_serving_carbs, number_total_weight, number_total_calories, number_total_proteins, number_total_fat, number_total_carbs, number_servings FROM $t_recipes_numbers WHERE number_recipe_id=$recipe_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_number_id, $get_number_recipe_id, $get_number_hundred_calories, $get_number_hundred_proteins, $get_number_hundred_fat, $get_number_hundred_carbs, $get_number_serving_calories, $get_number_serving_proteins, $get_number_serving_fat, $get_number_serving_carbs, $get_number_total_weight, $get_number_total_calories, $get_number_total_proteins, $get_number_total_fat, $get_number_total_carbs, $get_number_servings) = $row;

			$inp_entry_name = output_html($get_recipe_title);
			$inp_entry_name_mysql = quote_smart($link, $inp_entry_name);

			$inp_entry_manufacturer_name = output_html("");
			$inp_entry_manufacturer_name_mysql = quote_smart($link, $inp_entry_manufacturer_name);

			if($entry_serving_size == "1"){
				$inp_entry_serving_size_measurement = output_html(strtolower($l_serving_abbreviation));
			}
			else{
				$inp_entry_serving_size_measurement = output_html(strtolower($l_servings_abbreviation));
			}
			$inp_entry_serving_size_measurement_mysql = quote_smart($link, $inp_entry_serving_size_measurement);

			$inp_entry_energy_per_entry = round($inp_entry_serving_size*$get_number_serving_calories, 1);
			$inp_entry_energy_per_entry_mysql = quote_smart($link, $inp_entry_energy_per_entry);

			$inp_entry_fat_per_entry = round($inp_entry_serving_size*$get_number_serving_fat, 1);
			$inp_entry_fat_per_entry_mysql = quote_smart($link, $inp_entry_fat_per_entry);

			$inp_entry_carb_per_entry = round($inp_entry_serving_size*$get_number_serving_carbs, 1);
			$inp_entry_carb_per_entry_mysql = quote_smart($link, $inp_entry_carb_per_entry);

			$inp_entry_protein_per_entry = round($inp_entry_serving_size*$get_number_serving_proteins, 1);
			$inp_entry_protein_per_entry_mysql = quote_smart($link, $inp_entry_protein_per_entry);


			// Insert
			mysqli_query($link, "INSERT INTO $t_meal_plans_entries
			(entry_id, entry_meal_plan_id, entry_day_number, entry_meal_number, entry_weight, entry_food_id, entry_recipe_id, 
			entry_name, entry_manufacturer_name, entry_serving_size, entry_serving_size_measurement, 
			entry_energy_per_entry, entry_fat_per_entry, entry_carb_per_entry, entry_protein_per_entry) 
			VALUES 
			(NULL, '$get_current_meal_plan_id', $inp_entry_day_number_mysql, $inp_entry_meal_number_mysql, '0', '0', '$get_recipe_id', 
			$inp_entry_name_mysql, $inp_entry_manufacturer_name_mysql, $inp_entry_serving_size_mysql, $inp_entry_serving_size_measurement_mysql, 
			$inp_entry_energy_per_entry_mysql, $inp_entry_fat_per_entry_mysql, $inp_entry_carb_per_entry_mysql, $inp_entry_protein_per_entry_mysql)")
			or die(mysqli_error($link));

			$url = "new_meal_plan_step_2_entries.php?meal_plan_id=$meal_plan_id&entry_day_number=$entry_day_number&entry_meal_number=$entry_meal_number&l=$l";
			$url = $url . "&ft=success&fm=recipe_added";
			header("Location: $url");
			exit;
		}

		/*- Recipe categories ----------------------------------------- */
		if(isset($_GET['inp_entry_recipe_query'])){
			$inp_entry_recipe_query = $_GET['inp_entry_recipe_query'];
			$inp_entry_recipe_query = strip_tags(stripslashes($inp_entry_recipe_query));
			$inp_entry_recipe_query = output_html($inp_entry_recipe_query);
		} else{
			$inp_entry_recipe_query = "";
		}
		if(isset($_GET['recipe_category_id'])){
			$recipe_category_id = $_GET['recipe_category_id'];
			$recipe_category_id = strip_tags(stripslashes($recipe_category_id));
		} else{
			$recipe_category_id = "";
		}



		echo"
		<h1>$get_current_meal_plan_title</h1>
	
				<script>
										\$(function(){
											// bind change event to select
											\$('#inp_amount_select').on('change', function () {
												var url = \$(this).val(); // get selected value
												if (url) { // require a URL
 													window.location = url; // redirect
												}
												return false;
											});
										});
										</script>

		<!-- Categories -->
			<div class=\"left\" style=\"width: 20%;\">
				<table class=\"hor-zebra\">
				 <tbody>
				  <tr>
				   <td style=\"paddding: 0px 0px 0px 0px;margin: 0px 0px 0px 0px;\">
					<p style=\"paddding: 0px 0px 0px 0px;margin: 0px 0px 0px 0px;\">";

						// Get all categories
						$query = "SELECT category_id, category_name, category_image_path, category_image FROM $t_recipes_categories ORDER BY category_name ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_category_id, $get_category_name, $get_category_image_path, $get_category_image) = $row;

							// Translations
							$query_t = "SELECT category_translation_id, category_translation_value FROM $t_recipes_categories_translations WHERE category_id=$get_category_id AND category_translation_language=$l_mysql";
							$result_t = mysqli_query($link, $query_t);
							$row_t = mysqli_fetch_row($result_t);
							list($get_category_translation_id, $get_category_translation_value) = $row_t;



							echo"		";
							echo"<a href=\"new_meal_plan_step_2_entries_new_entry_recipe.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=$entry_day_number&amp;entry_meal_number=$entry_meal_number&amp;action=new_entry_food&amp;recipe_category_id=$get_category_id&amp;l=$l\""; if($recipe_category_id == "$get_category_id"){ echo" style=\"font-weight: bold;\"";}echo">$get_category_translation_value</a><br />\n";

						}

						echo"
						</p>
					   </td>
					  </tr>
					 </tbody>
					</table>
				</div>
			<!-- //Categories -->

			<!-- Current day -->
				<div class=\"right\" style=\"width: 77%;\">
				";
				if($entry_day_number > 0 && $entry_day_number < 8){
					if($get_current_meal_plan_number_of_days > 1){
						if($entry_day_number == "1"){
							echo"<h2>$l_monday</h2>";
						}
						elseif($entry_day_number == "2"){
							echo"<h2>$l_tuesday</h2>";
						}
						elseif($entry_day_number == "3"){
							echo"<h2>$l_wednesday</h2>";
						}
						elseif($entry_day_number == "4"){
							echo"<h2>$l_thursday</h2>";
						}
						elseif($entry_day_number == "5"){
							echo"<h2>$l_friday</h2>";
						}
						elseif($entry_day_number == "6"){
							echo"<h2>$l_saturday</h2>";
						}
						elseif($entry_day_number == "7"){
							echo"<h2>$l_sunday</h2>";
						}
					}

					echo"
				
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

					";
					
					echo"
					<form method=\"get\" action=\"new_meal_plan_step_2_entries_new_entry_recipe.php\" enctype=\"multipart/form-data\">
						<p><b>$l_recipe_search</b><br />
						<input type=\"text\" name=\"inp_entry_recipe_query\" value=\"";if(isset($_GET['inp_entry_recipe_query'])){ echo"$inp_entry_recipe_query"; } echo"\" size=\"30\" />
						<input type=\"hidden\" name=\"meal_plan_id\" value=\"$meal_plan_id\" />
						<input type=\"hidden\" name=\"entry_day_number\" value=\"$entry_day_number\" />
						<input type=\"hidden\" name=\"entry_meal_number\" value=\"$entry_meal_number\" />
						<input type=\"hidden\" name=\"l\" value=\"$l\" />
						<input type=\"hidden\" name=\"action\" value=\"$action\" />
						<input type=\"submit\" value=\"$l_search\" class=\"btn btn_default\" />
						<a href=\"$root/recipes/submit_recipe.php?l=$l\" class=\"btn btn_default\">$l_create_new_recipe</a>
						</p>
					</form>


					<!-- Food list -->
						";
	
						// Set layout
						$x = 0;

						// Get all recipes
						$query = "SELECT recipe_id, recipe_title, recipe_introduction, recipe_image_path, recipe_image FROM $t_recipes WHERE recipe_language=$l_mysql";

						if(isset($_GET['inp_entry_recipe_query'])){
							$inp_entry_recipe_query = $_GET['inp_entry_recipe_query'];
							$inp_entry_recipe_query = strip_tags(stripslashes($inp_entry_recipe_query));
							$inp_entry_recipe_query = output_html($inp_entry_recipe_query);

							
							$inp_entry_recipe_query = "%" . $inp_entry_recipe_query . "%";
							$inp_entry_recipe_query_mysql = quote_smart($link, $inp_entry_recipe_query);

							$query = $query . " AND recipe_title LIKE $inp_entry_recipe_query_mysql";
						}
						if($recipe_category_id != ""){
							$recipe_category_id_mysql = quote_smart($link, $recipe_category_id);
							$query = $query . " AND recipe_category_id=$recipe_category_id_mysql";
						}

						$query = $query . " ORDER BY recipe_last_viewed ASC";

						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_recipe_id, $get_recipe_title, $get_recipe_introduction, $get_recipe_image_path, $get_recipe_image) = $row;
				
							// Select Nutrients
							$query_n = "SELECT number_id, number_recipe_id, number_hundred_calories, number_hundred_proteins, number_hundred_fat, number_hundred_carbs, number_serving_calories, number_serving_proteins, number_serving_fat, number_serving_carbs, number_total_weight, number_total_calories, number_total_proteins, number_total_fat, number_total_carbs, number_servings FROM $t_recipes_numbers WHERE number_recipe_id=$get_recipe_id";
							$result_n = mysqli_query($link, $query_n);
							$row_n = mysqli_fetch_row($result_n);
							list($get_number_id, $get_number_recipe_id, $get_number_hundred_calories, $get_number_hundred_proteins, $get_number_hundred_fat, $get_number_hundred_carbs, $get_number_serving_calories, $get_number_serving_proteins, $get_number_serving_fat, $get_number_serving_carbs, $get_number_total_weight, $get_number_total_calories, $get_number_total_proteins, $get_number_total_fat, $get_number_total_carbs, $get_number_servings) = $row_n;




							if($x == 0){
								echo"
								<div class=\"clear\"></div>
								<div class=\"left_center_right_left\" style=\"text-align: center;padding-bottom: 20px;\">
								";
							}
							elseif($x == 1){
								echo"
								<div class=\"left_center_right_center\" style=\"text-align: center;padding-bottom: 20px;\">
								";
							}
							elseif($x == 2){
								echo"
								<div class=\"left_center_right_right\" style=\"text-align: center;padding-bottom: 20px;\">
								";
							}


							echo"
									<p style=\"padding-bottom:5px;\">
									<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\"><img src=\"";
									if($get_recipe_image != "" && file_exists("../$get_recipe_image_path/$get_recipe_image")){
										echo"../image.php?width=132&amp;height=132&amp;image=/$get_recipe_image_path/$get_recipe_image";
									}
									else{
										echo"_gfx/no_thumb.png";
									}
									echo"\" alt=\"$get_recipe_image\" style=\"margin-bottom: 5px;\" /></a><br />
					
									<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\" style=\"font-weight: bold;color: #444444;\">$get_recipe_title</a><br />
									";
									echo"
									</p>

									<table style=\"margin: 0px auto;\">
									 <tr>
									  <td style=\"padding-right: 10px;text-align: center;\">
										<span class=\"grey_smal\">$get_number_serving_calories</span>
									  </td>
									  <td style=\"padding-right: 10px;text-align: center;\">
										<span class=\"grey_smal\">$get_number_serving_fat</span>
									  </td>
									  <td style=\"padding-right: 10px;text-align: center;\">
										<span class=\"grey_smal\">$get_number_serving_carbs</span>
									  </td>
									  <td style=\"text-align: center;\">
										<span class=\"grey_smal\">$get_number_serving_proteins</span>
									  </td>
									 </tr>
									 <tr>
									  <td style=\"padding-right: 10px;text-align: center;\">
										<span class=\"grey_smal\">$l_cal_lowercase</span>
									  </td>
									  <td style=\"padding-right: 10px;text-align: center;\">
										<span class=\"grey_smal\">$l_fat_lowercase</span>
									  </td>
									  <td style=\"padding-right: 10px;text-align: center;\">
										<span class=\"grey_smal\">$l_carb_lowercase</span>
									  </td>
									  <td style=\"text-align: center;\">
										<span class=\"grey_smal\">$l_proteins_lowercase</span>
									  </td>
									 </tr>
									</table>


									<!-- Add food -->
										<form>
										<p>
										<select id=\"inp_amount_select\">
											<option value=\"new_meal_plan_step_2_entries_new_entry_recipe.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=$entry_day_number&amp;entry_meal_number=$entry_meal_number&amp;recipe_id=$get_recipe_id&amp;entry_serving_size=1&amp;l=$l&amp;process=1\">1</option>
											<option value=\"new_meal_plan_step_2_entries_new_entry_recipe.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=$entry_day_number&amp;entry_meal_number=$entry_meal_number&amp;recipe_id=$get_recipe_id&amp;entry_serving_size=2&amp;l=$l&amp;process=1\">2</option>
											<option value=\"new_meal_plan_step_2_entries_new_entry_recipe.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=$entry_day_number&amp;entry_meal_number=$entry_meal_number&amp;recipe_id=$get_recipe_id&amp;entry_serving_size=3&amp;l=$l&amp;process=1\">3</option>
											<option value=\"new_meal_plan_step_2_entries_new_entry_recipe.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=$entry_day_number&amp;entry_meal_number=$entry_meal_number&amp;recipe_id=$get_recipe_id&amp;entry_serving_size=4&amp;l=$l&amp;process=1\">4</option>
											<option value=\"new_meal_plan_step_2_entries_new_entry_recipe.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=$entry_day_number&amp;entry_meal_number=$entry_meal_number&amp;recipe_id=$get_recipe_id&amp;entry_serving_size=5&amp;l=$l&amp;process=1\">5</option>
											<option value=\"new_meal_plan_step_2_entries_new_entry_recipe.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=$entry_day_number&amp;entry_meal_number=$entry_meal_number&amp;recipe_id=$get_recipe_id&amp;entry_serving_size=6&amp;l=$l&amp;process=1\">6</option>
											<option value=\"new_meal_plan_step_2_entries_new_entry_recipe.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=$entry_day_number&amp;entry_meal_number=$entry_meal_number&amp;recipe_id=$get_recipe_id&amp;entry_serving_size=7&amp;l=$l&amp;process=1\">7</option>
											<option value=\"new_meal_plan_step_2_entries_new_entry_recipe.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=$entry_day_number&amp;entry_meal_number=$entry_meal_number&amp;recipe_id=$get_recipe_id&amp;entry_serving_size=8&amp;l=$l&amp;process=1\">8</option>
										</select>
										<a href=\"new_meal_plan_step_2_entries_new_entry_recipe.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=$entry_day_number&amp;entry_meal_number=$entry_meal_number&amp;recipe_id=$get_recipe_id&amp;l=$l&amp;process=1\" class=\"btn btn_default\">$l_add</a>
										</p>
										</form>
										
									<!-- //Add food -->
								</div>
							";

							// Increment
							$x++;
		
							// Reset
							if($x == 3){
								$x = 0;
							}
						} // while

						echo"

					<!-- //Food list -->
					
					";
				}
				echo"
				</div>
			<!-- //Current day -->
			";
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