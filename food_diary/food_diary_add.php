<?php
/**
*
* File: food_diary/food_diary_add_food.php
* Version 1.0.0.
* Date 12:42 21.01.2018
* Copyright (c) 2008-2018 Sindre Andre Ditlefsen
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

/*- Tables --------------------------------------------------------------------------- */
include("_tables.php");

/*- Variables ------------------------------------------------------------------------- */
$l_mysql = quote_smart($link, $l);


if(isset($_GET['action'])) {
	$action = $_GET['action'];
	$action = strip_tags(stripslashes($action));
}
else{
	$action = "";
}
if(isset($_GET['date'])) {
	$date = $_GET['date'];
	$date = strip_tags(stripslashes($date));
}
else{
	$date = "";
}
if (isset($_GET['meal_id'])) {
	$meal_id = $_GET['meal_id'];
	$meal_id = stripslashes(strip_tags($meal_id));
}
else{
	$meal_id = "";
}

if(isset($_GET['main_category_id'])){
	$main_category_id= $_GET['main_category_id'];
	$main_category_id = strip_tags(stripslashes($main_category_id));
}
else{
	$main_category_id = "";
}
if(isset($_GET['sub_category_id'])){
	$sub_category_id= $_GET['sub_category_id'];
	$sub_category_id = strip_tags(stripslashes($sub_category_id));
}
else{
	$sub_category_id = "";
}
if(isset($_GET['inp_entry_food_query'])){
	$inp_entry_food_query = $_GET['inp_entry_food_query'];
	$inp_entry_food_query = strip_tags(stripslashes($inp_entry_food_query));
	$inp_entry_food_query = output_html($inp_entry_food_query);
} else{
	$inp_entry_food_query = "";
}
	

/*- Translation ------------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/food_diary/ts_food_diary.php");


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_food_diary - $l_new_entry";
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
	$query = "SELECT user_id, user_alias, user_email, user_gender, user_height, user_measurement, user_dob FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_alias, $get_my_user_email, $get_my_user_gender, $get_my_user_height, $get_user_measurement, $get_my_user_dob) = $row;
	
	if($action == ""){

		echo"
		<h1>$l_new_entry</h1>

	
		<!-- Feedback -->
		";
		if($ft != "" && $fm != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			else{
				$fm = ucfirst($fm);
			}
			echo"<div class=\"$ft\"><p>$fm</p></div>";
		}
		echo"
		<!-- //Feedback -->


		<!-- You are here -->
			<p><b>$l_you_are_here</b><br />
			<a href=\"index.php?l=$l\">$l_food_diary</a>
			&gt;
			<a href=\"food_diary_add_food.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_new_entry</a>
			</p>
		<!-- //You are here -->


		<!-- Search -->	
			<!-- Search engines Autocomplete -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_entry_food_query\"]').focus();
				});
				\$(document).ready(function () {
					\$('#inp_entry_food_query').keyup(function () {
        					// getting the value that user typed
        					var searchString    = $(\"#inp_entry_food_query\").val();
        					// forming the queryString
       						var data            = 'l=$l&date=$date&meal_id=$meal_id&q='+ searchString;
         
        					// if searchString is not empty
        					if(searchString) {
        						// ajax call
          						\$.ajax({
                						type: \"POST\",
               							url: \"food_diary_add_food_query.php\",
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
			<!-- //Search engines Autocomplete -->

			<!-- Food Search -->
				<form method=\"get\" action=\"food_diary_add_food.php\" enctype=\"multipart/form-data\" id=\"inp_entry_food_query_form\">
					<p style=\"padding-top: 0;\"><b>$l_food_search</b><br />
					<input type=\"text\" id=\"inp_entry_food_query\" name=\"inp_entry_food_query\" value=\"";if(isset($_GET['inp_entry_food_query'])){ echo"$inp_entry_food_query"; } echo"\" size=\"12\" />
					<input type=\"hidden\" name=\"action\" value=\"search\" />
					<input type=\"hidden\" name=\"date\" value=\"$date\" />
					<input type=\"hidden\" name=\"meal_id\" value=\"$meal_id\" />
					<input type=\"submit\" value=\"$l_search\" class=\"btn btn_default\" />
					<a href=\"$root/food/new_food.php?l=$l\" class=\"btn btn_default\">$l_new_food</a>
					</p>
				</form>
			<!-- //Food Search -->
		<!-- //Search -->


	
		<div class=\"tabs\" style=\"margin-top: 10px;\">
			<ul>
				<li><a href=\"food_diary_add.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\" class=\"selected\">$l_recent</a></li>
				<li><a href=\"food_diary_add_food.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_food</a></li>
				<li><a href=\"food_diary_add_recipe.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_recipes</a></li>
			</ul>
		</div>
		<div class=\"clear\" style=\"height: 20px;\"></div>
	


		<!-- Recent food/recipe list -->

			<!-- Select list go to URL -->
				<script>
				\$(document).ready(function(){
					\$(\"select\").bind('change',function(){
						window.location = \$(':selected',this).attr('href'); // redirect
					})
				});
				</script>
			<!-- //Select list go to URL -->

			<div id=\"nettport_search_results\">
				";
				// Set layout
				$x = 0;
				$day_of_the_week = date("N");
				// Can add last_used_day_of_week='$day_of_the_week' AND  to make it more precise
				$meal_id_mysql = quote_smart($link, $meal_id);
				$query = "SELECT last_used_id, last_used_food_id, last_used_recipe_id, last_used_serving_size, last_used_serving_size_gram, last_used_serving_size_gram_measurement, last_used_serving_size_pcs, last_used_serving_size_pcs_measurement FROM $t_food_diary_last_used WHERE last_used_user_id='$get_my_user_id' AND last_used_meal_id=$meal_id_mysql ORDER BY last_used_times DESC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_last_used_id, $get_last_used_food_id, $get_last_used_recipe_id, $get_last_used_serving_size, $get_last_used_serving_size_gram, $get_last_used_serving_size_gram_measurement, $get_last_used_serving_size_pcs, $get_last_used_serving_size_pcs_measurement) = $row;

					if($get_last_used_food_id != "0"){
						// Get this food
						$query_food = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_country, food_net_content_metric, food_net_content_measurement_metric, food_net_content_us, food_net_content_measurement_us, food_net_content_added_measurement, food_serving_size_metric, food_serving_size_measurement_metric, food_serving_size_us, food_serving_size_measurement_us, food_serving_size_added_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy_metric, food_fat_metric, food_saturated_fat_metric, food_monounsaturated_fat_metric, food_polyunsaturated_fat_metric, food_cholesterol_metric, food_carbohydrates_metric, food_carbohydrates_of_which_sugars_metric, food_dietary_fiber_metric, food_proteins_metric, food_salt_metric, food_sodium_metric, food_energy_us, food_fat_us, food_saturated_fat_us, food_monounsaturated_fat_us, food_polyunsaturated_fat_us, food_cholesterol_us, food_carbohydrates_us, food_carbohydrates_of_which_sugars_us, food_dietary_fiber_us, food_proteins_us, food_salt_us, food_sodium_us, food_score, food_energy_calculated_metric, food_fat_calculated_metric, food_saturated_fat_calculated_metric, food_monounsaturated_fat_calculated_metric, food_polyunsaturated_fat_calculated_metric, food_cholesterol_calculated_metric, food_carbohydrates_calculated_metric, food_carbohydrates_of_which_sugars_calculated_metric, food_dietary_fiber_calculated_metric, food_proteins_calculated_metric, food_salt_calculated_metric, food_sodium_calculated_metric, food_energy_calculated_us, food_fat_calculated_us, food_saturated_fat_calculated_us, food_monounsaturated_fat_calculated_us, food_polyunsaturated_fat_calculated_us, food_cholesterol_calculated_us, food_carbohydrates_calculated_us, food_carbohydrates_of_which_sugars_calculated_us, food_dietary_fiber_calculated_us, food_proteins_calculated_us, food_salt_calculated_us, food_sodium_calculated_us, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_thumb_a_medium, food_thumb_a_large, food_image_b, food_thumb_b_small, food_thumb_b_medium, food_thumb_b_large, food_image_c, food_thumb_c_small, food_thumb_c_medium, food_thumb_c_large, food_image_d, food_thumb_d_small, food_thumb_d_medium, food_thumb_d_large, food_image_e, food_thumb_e_small, food_thumb_e_medium, food_thumb_e_large, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_created_date, food_last_viewed, food_age_restriction FROM $t_food_index WHERE food_id=$get_last_used_food_id";
						$result_food = mysqli_query($link, $query_food);
						$row_food = mysqli_fetch_row($result_food);
						list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_manufacturer_name_and_food_name, $get_food_description, $get_food_country, $get_food_net_content_metric, $get_food_net_content_measurement_metric, $get_food_net_content_us, $get_food_net_content_measurement_us, $get_food_net_content_added_measurement, $get_food_serving_size_metric, $get_food_serving_size_measurement_metric, $get_food_serving_size_us, $get_food_serving_size_measurement_us, $get_food_serving_size_added_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy_metric, $get_food_fat_metric, $get_food_saturated_fat_metric, $get_food_monounsaturated_fat_metric, $get_food_polyunsaturated_fat_metric, $get_food_cholesterol_metric, $get_food_carbohydrates_metric, $get_food_carbohydrates_of_which_sugars_metric, $get_food_dietary_fiber_metric, $get_food_proteins_metric, $get_food_salt_metric, $get_food_sodium_metric, $get_food_energy_us, $get_food_fat_us, $get_food_saturated_fat_us, $get_food_monounsaturated_fat_us, $get_food_polyunsaturated_fat_us, $get_food_cholesterol_us, $get_food_carbohydrates_us, $get_food_carbohydrates_of_which_sugars_us, $get_food_dietary_fiber_us, $get_food_proteins_us, $get_food_salt_us, $get_food_sodium_us, $get_food_score, $get_food_energy_calculated_metric, $get_food_fat_calculated_metric, $get_food_saturated_fat_calculated_metric, $get_food_monounsaturated_fat_calculated_metric, $get_food_polyunsaturated_fat_calculated_metric, $get_food_cholesterol_calculated_metric, $get_food_carbohydrates_calculated_metric, $get_food_carbohydrates_of_which_sugars_calculated_metric, $get_food_dietary_fiber_calculated_metric, $get_food_proteins_calculated_metric, $get_food_salt_calculated_metric, $get_food_sodium_calculated_metric, $get_food_energy_calculated_us, $get_food_fat_calculated_us, $get_food_saturated_fat_calculated_us, $get_food_monounsaturated_fat_calculated_us, $get_food_polyunsaturated_fat_calculated_us, $get_food_cholesterol_calculated_us, $get_food_carbohydrates_calculated_us, $get_food_carbohydrates_of_which_sugars_calculated_us, $get_food_dietary_fiber_calculated_us, $get_food_proteins_calculated_us, $get_food_salt_calculated_us, $get_food_sodium_calculated_us, $get_food_barcode, $get_food_main_category_id, $get_food_sub_category_id, $get_food_image_path, $get_food_image_a, $get_food_thumb_a_small, $get_food_thumb_a_medium, $get_food_thumb_a_large, $get_food_image_b, $get_food_thumb_b_small, $get_food_thumb_b_medium, $get_food_thumb_b_large, $get_food_image_c, $get_food_thumb_c_small, $get_food_thumb_c_medium, $get_food_thumb_c_large, $get_food_image_d, $get_food_thumb_d_small, $get_food_thumb_d_medium, $get_food_thumb_d_large, $get_food_image_e, $get_food_thumb_e_small, $get_food_thumb_e_medium, $get_food_thumb_e_large, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block, $get_food_user_ip, $get_food_created_date, $get_food_last_viewed, $get_food_age_restriction) = $row_food;
	

						// Name saying
						$title = "$get_food_manufacturer_name $get_food_name";
						$check = strlen($title);
						if($check > 35){
							$title = substr($title, 0, 35);
							$title = $title . "...";
						}
					} // food
					else{
						// Get recipe
						$query_recipe = "SELECT recipe_id, recipe_title, recipe_introduction, recipe_image_path, recipe_image FROM $t_recipes WHERE recipe_id=$get_last_used_recipe_id";
						$result_recipe = mysqli_query($link, $query_recipe);
						$row_recipe = mysqli_fetch_row($result_recipe);
						list($get_recipe_id, $get_recipe_title, $get_recipe_introduction, $get_recipe_image_path, $get_recipe_image) = $row_recipe;
	

						// Select Nutrients
						$query_n = "SELECT number_id, number_recipe_id, number_hundred_calories, number_hundred_proteins, number_hundred_fat, number_hundred_carbs, number_serving_calories, number_serving_proteins, number_serving_fat, number_serving_carbs, number_total_weight, number_total_calories, number_total_proteins, number_total_fat, number_total_carbs, number_servings FROM $t_recipes_numbers WHERE number_recipe_id=$get_recipe_id";
						$result_n = mysqli_query($link, $query_n);
						$row_n = mysqli_fetch_row($result_n);
						list($get_number_id, $get_number_recipe_id, $get_number_hundred_calories, $get_number_hundred_proteins, $get_number_hundred_fat, $get_number_hundred_carbs, $get_number_serving_calories, $get_number_serving_proteins, $get_number_serving_fat, $get_number_serving_carbs, $get_number_total_weight, $get_number_total_calories, $get_number_total_proteins, $get_number_total_fat, $get_number_total_carbs, $get_number_servings) = $row_n;

					} // recipe


					if($x == 0){
						echo"
						<div class=\"clear\"></div>
						<div class=\"left_center_center_right_left\" style=\"text-align: center;padding-bottom: 20px;\">
						";
					}
					elseif($x == 1){
						echo"
						<div class=\"left_center_center_left_right_center\" style=\"text-align: center;padding-bottom: 20px;\">
						";
					}
					elseif($x == 2){
						echo"
						<div class=\"left_center_center_right_right_center\" style=\"text-align: center;padding-bottom: 20px;\">
						";
					}
					elseif($x == 3){
						echo"
						<div class=\"left_center_center_right_right\" style=\"text-align: center;padding-bottom: 20px;\">
						";
					}

					// Food
					if($get_last_used_food_id != "0"){

						// Thumb
						if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a")){
							$thumb = "../$get_food_image_path/$get_food_thumb_a_small";
						}
						else{
							$thumb = "_gfx/no_thumb.png";
						}


						echo"
						<p style=\"padding-bottom:5px;\">
						<a href=\"$root/food/view_food.php?main_category_id=$get_food_main_category_id&amp;sub_category_id=$get_food_sub_category_id&amp;food_id=$get_food_id&amp;l=$l\"><img src=\"$thumb\" alt=\"$get_food_image_a\" style=\"margin-bottom: 5px;\" /></a><br />
		
						<a href=\"$root/food/view_food.php?main_category_id=$get_food_main_category_id&amp;sub_category_id=$get_food_sub_category_id&amp;food_id=$get_food_id&amp;l=$l\" style=\"font-weight: bold;color: #444444;\">$title</a><br />
						";
						echo"
						</p>
						<table style=\"margin: 0px auto;\">
						 <tr>
						  <td style=\"padding-right: 10px;text-align: center;\">
							<span class=\"grey_smal\">$get_food_energy_metric</span>
						  </td>
						  <td style=\"padding-right: 10px;text-align: center;\">
							<span class=\"grey_smal\">$get_food_fat_metric</span>
						  </td>
						  <td style=\"padding-right: 10px;text-align: center;\">
							<span class=\"grey_smal\">$get_food_carbohydrates_metric</span>
						  </td>
						  <td style=\"text-align: center;\">
							<span class=\"grey_smal\">$get_food_proteins_metric</span>
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
							<form method=\"post\" action=\"food_diary_add_food.php?action=add_food_to_diary&amp;date=$date&amp;meal_id=$meal_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
								<p>
								<input type=\"hidden\" name=\"inp_entry_food_id\" value=\"$get_food_id\" />
								<input type=\"text\" name=\"inp_entry_food_serving_size\" size=\"3\" value=\"$get_last_used_serving_size\" />
								<input type=\"submit\" name=\"inp_submit_gram\" value=\"$get_food_serving_size_measurement_metric\" class=\"btn btn_default\" />
								";
								if($get_food_serving_size_pcs_measurement != "g"){
									echo"<input type=\"submit\" name=\"inp_submit_pcs\" value=\"$get_food_serving_size_pcs_measurement\" class=\"btn btn_default\" />";
								}
								echo"
								</p>
								</form>
						<!-- //Add food -->
						";
					} // food
					else{
						if($get_recipe_image != "" && file_exists("../$get_recipe_image_path/$get_recipe_image")){

							$inp_new_x = 132;
							$inp_new_y = 132;
							$thumb = "recipe_" . $get_recipe_id . "-" . $inp_new_x . "x" . $inp_new_y . ".png";

							if(!(file_exists("$root/_cache/$thumb"))){
								resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_recipe_image_path/$get_recipe_image", "$root/_cache/$thumb");
							}
							$thumb = "$root/_cache/$thumb";
						}
						else{
							$thumb = "_gfx/no_thumb.png";
						}

						echo"
						<p style=\"padding-bottom:5px;\">
						<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\"><img src=\"$thumb\" alt=\"$get_recipe_image\" style=\"margin-bottom: 5px;\" /></a><br />
						<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\" style=\"font-weight: bold;color: #444444;\">$get_recipe_title</a><br />
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
						<!-- Add Recipe -->
							<form>
							<p>
							<select classs=\"inp_amount_select\">
								<option value=\"1\" href=\"food_diary_add_recipe.php?action=add_recipe_to_diary&amp;date=$date&amp;meal_id=$meal_id&amp;recipe_id=$get_recipe_id&amp;entry_serving_size=1&amp;l=$l&amp;process=1\">1</option>
								<option value=\"2\" href=\"food_diary_add_recipe.php?action=add_recipe_to_diary&amp;date=$date&amp;meal_id=$meal_id&amp;recipe_id=$get_recipe_id&amp;entry_serving_size=2&amp;l=$l&amp;process=1\">2</option>
								<option value=\"3\" href=\"food_diary_add_recipe.php?action=add_recipe_to_diary&amp;date=$date&amp;meal_id=$meal_id&amp;recipe_id=$get_recipe_id&amp;entry_serving_size=3&amp;l=$l&amp;process=1\">3</option>
								<option value=\"4\" href=\"food_diary_add_recipe.php?action=add_recipe_to_diary&amp;date=$date&amp;meal_id=$meal_id&amp;recipe_id=$get_recipe_id&amp;entry_serving_size=4&amp;l=$l&amp;process=1\">4</option>
								<option value=\"5\" href=\"food_diary_add_recipe.php?action=add_recipe_to_diary&amp;date=$date&amp;meal_id=$meal_id&amp;recipe_id=$get_recipe_id&amp;entry_serving_size=5&amp;l=$l&amp;process=1\">5</option>
								<option value=\"6\" href=\"food_diary_add_recipe.php?action=add_recipe_to_diary&amp;date=$date&amp;meal_id=$meal_id&amp;recipe_id=$get_recipe_id&amp;entry_serving_size=6&amp;l=$l&amp;process=1\">6</option>
								<option value=\"7\" href=\"food_diary_add_recipe.php?action=add_recipe_to_diary&amp;date=$date&amp;meal_id=$meal_id&amp;recipe_id=$get_recipe_id&amp;entry_serving_size=7&amp;l=$l&amp;process=1\">7</option>
								<option value=\"8\" href=\"food_diary_add_recipe.php?action=add_recipe_to_diary&amp;date=$date&amp;meal_id=$meal_id&amp;recipe_id=$get_recipe_id&amp;entry_serving_size=8&amp;l=$l&amp;process=1\">8</option>
							</select>
							<a href=\"food_diary_add_recipe.php?action=add_recipe_to_diary&amp;date=$date&amp;meal_id=$meal_id&amp;recipe_id=$get_recipe_id&amp;entry_serving_size=1&amp;l=$l&amp;process=1\" class=\"btn btn_default\">$l_add</a>
							</p>
							</form>
						<!-- //Add Recipe -->";
					} // recipe
					echo"
					</div>
				";
				// Increment
				$x++;
		
				// Reset
				if($x == 4){
					$x = 0;
				}
			} // while

			echo"
			</div> <!-- //nettport_search_results -->
		
			";
			if($x == "0"){
				// No food
				echo"
				<p>$l_on_this_page_you_will_see_food_you_have_added_before</p>

				<p>
				$l_the_page_is_smart_so_it_will_remember_what_you_usually_have_for_your ";
				if($meal_id == "0"){
					echo"$l_breakfast_lowercase";
				}
				elseif($meal_id == "1"){
					echo"$l_lunch_lowercase";
				}
				elseif($meal_id == "2"){
					echo"$l_before_training_lowercase";
				}
				elseif($meal_id == "3"){
					echo"$l_after_training_lowercase";
				}
				elseif($meal_id == "4"){
					echo"$l_dinner_lowercase";
				}
				elseif($meal_id == "5"){
					echo"$l_snacks_lowercase";
				}
				else{
					echo"$l_supper";
				}
				echo"
				$l_on_lowercase
				";
				$dow = date("N",strtotime($date));
				
				if($dow == "1"){
					echo"$l_mondays_lowercase";
				}
				elseif($dow == "2"){
					echo"$l_tuesdays_lowercase";
				}
				elseif($dow == "3"){
					echo"$l_wednesdays_lowercase";
				}
				elseif($dow == "4"){
					echo"$l_thursdays_lowercase";
				}
				elseif($dow == "5"){
					echo"$l_fridays_lowercase";
				}
				elseif($dow == "6"){
					echo"$l_saturdays_lowercase";
				}
				else{
					echo"$l_sundays_lowercase";
				}
				echo".
				</p>

				<p>$l_the_more_you_use_the_food_diary_the_smarter_it_gets </p>
				";
			}
			echo"
		<!-- //Recent Food list -->
		";
	} // action == ""
}
else{
	echo"
	<h1>
	<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login?l=$l&amp;referer=$root/food_diary/index.php\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>