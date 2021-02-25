<?php
/**
*
* File: food_diary/food_diary_add_recipe.php
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

/*- Translation ------------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/food_diary/ts_food_diary.php");
include("$root/_admin/_translations/site/$l/food_diary/ts_food_diary_add.php");


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
			<a href=\"food_diary_add.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_new_entry</a>
			&gt;
			<a href=\"food_diary_add_recipe.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_recipes</a>
			</p>
		<!-- //You are here -->

		
		<!-- Recipe search -->
				
			<!-- Search engines Autocomplete -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_entry_recipe_query\"]').focus();
				});
				\$(document).ready(function () {
					\$('[name=\"inp_entry_recipe_query\"]').keyup(function () {


        					// getting the value that user typed
        					var searchString    = $(\"#inp_entry_recipe_query\").val();
        					// forming the queryString
       						var data            = 'l=$l&date=$date&meal_id=$meal_id&q='+ searchString;
         
        					// if searchString is not empty
        					if(searchString) {
        						// ajax call
          						\$.ajax({
                						type: \"POST\",
               							url: \"food_diary_add_recipe_query.php\",
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
				<form method=\"get\" action=\"food_diary_add_recipe.php\" enctype=\"multipart/form-data\" id=\"inp_entry_food_query_form\">
					<p style=\"padding-top:0;\"><b>$l_recipe_search</b><br />
					<input type=\"text\" name=\"inp_entry_recipe_query\" id=\"inp_entry_recipe_query\" value=\"";if(isset($_GET['inp_entry_recipe_query'])){ echo"$inp_entry_recipe_query"; } echo"\" size=\"5\" />
					<input type=\"hidden\" name=\"action\" value=\"recipe_search\" />
					<input type=\"hidden\" name=\"date\" value=\"$date\" />
					<input type=\"hidden\" name=\"meal_id\" value=\"$meal_id\" />
					<input type=\"submit\" value=\"$l_search\" class=\"btn_default\" />
					<a href=\"$root/recipes/submit_recipe.php?l=$l\" class=\"btn_default\" title=\"$l_new_recipe\">$l_new_recipe</a>
					</p>
				</form>
			<!-- //Food Search -->
		<!-- //Recipe search -->

		<!-- Menu -->
			<div class=\"tabs\">
				<ul>
					<li><a href=\"food_diary_add.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_recent</a></li>
					<li><a href=\"food_diary_add_food.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_food</a></li>
					<li><a href=\"food_diary_add_recipe.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\" class=\"selected\">$l_recipes</a></li>
				</ul>
			</div>
			<div class=\"clear\" style=\"height: 20px;\"></div>
		<!-- //Menu -->
		
		<!-- Recipes categories -->
			<div class=\"vertical\">
				<ul>\n";
					
				// Get all categories
				$query = "SELECT category_id, category_name FROM $t_recipes_categories ORDER BY category_name ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_category_id, $get_category_name) = $row;
				
					// Translations
					$query_t = "SELECT category_translation_id, category_translation_value FROM $t_recipes_categories_translations WHERE category_id=$get_category_id AND category_translation_language=$l_mysql";
					$result_t = mysqli_query($link, $query_t);
					$row_t = mysqli_fetch_row($result_t);
					list($get_category_translation_id, $get_category_translation_value) = $row_t;

					echo"		";
					echo"<li><a href=\"food_diary_add_recipe.php?action=open_recipe_category&amp;date=$date&amp;meal_id=$meal_id&amp;recipe_category_id=$get_category_id&amp;l=$l\""; if($recipe_category_id == "$get_category_id"){ echo" style=\"font-weight: bold;\"";}echo">$get_category_translation_value</a></li>\n";
				}
				echo"
		
				</ul>
			</div>
		<!-- //Recipes Categories -->


		<!-- All recipes list -->
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
						<!-- //Add Recipe -->
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
				
					
		<!-- //All recipes list -->
		";
	} // food
	elseif($action == "recipe_search"){
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
			<a href=\"food_diary_add.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_new_entry</a>
			&gt;
			<a href=\"food_diary_add_recipe.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_recipes</a>
			&gt;
			<a href=\"food_diary_add_recipe.php?actino=$action&amp;date=$date&amp;meal_id=$meal_id&amp;l=$l&amp;inp_entry_recipe_query=$inp_entry_recipe_query\">$inp_entry_recipe_query</a>
			</p>
		<!-- //You are here -->

		
		<!-- Recipe search -->
				
			<!-- Search engines Autocomplete -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_entry_recipe_query\"]').focus();
				});
				\$(document).ready(function () {
					\$('[name=\"inp_entry_recipe_query\"]').keyup(function () {


        					// getting the value that user typed
        					var searchString    = $(\"#inp_entry_recipe_query\").val();
        					// forming the queryString
       						var data            = 'l=$l&date=$date&meal_id=$meal_id&q='+ searchString;
         
        					// if searchString is not empty
        					if(searchString) {
        						// ajax call
          						\$.ajax({
                						type: \"POST\",
               							url: \"food_diary_add_recipe_query.php\",
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
				<form method=\"get\" action=\"food_diary_add_recipe.php\" enctype=\"multipart/form-data\" id=\"inp_entry_food_query_form\">
					<p style=\"padding-top:0;\"><b>$l_recipe_search</b><br />
					<input type=\"text\" name=\"inp_entry_recipe_query\" id=\"inp_entry_recipe_query\" value=\"";if(isset($_GET['inp_entry_recipe_query'])){ echo"$inp_entry_recipe_query"; } echo"\" size=\"15\" />
					<input type=\"hidden\" name=\"action\" value=\"recipe_search\" />
					<input type=\"hidden\" name=\"date\" value=\"$date\" />
					<input type=\"hidden\" name=\"meal_id\" value=\"$meal_id\" />
					<input type=\"submit\" value=\"$l_search\" class=\"btn btn_default\" />
					<a href=\"$root/recipes/submit_recipe.php?l=$l\" class=\"btn btn_default\">$l_new_recipe</a>
					</p>
				</form>
			<!-- //Food Search -->
		<!-- //Recipe search -->

		<!-- Menu -->
			<div class=\"tabs\">
				<ul>
					<li><a href=\"food_diary_add.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_recent</a></li>
					<li><a href=\"food_diary_add_food.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_food</a></li>
					<li><a href=\"food_diary_add_recipe.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\" class=\"selected\">$l_recipes</a></li>
				</ul>
			</div>
			<div class=\"clear\" style=\"height: 20px;\"></div>
		<!-- //Menu -->


		<!-- Search for that recipe -->
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
						<!-- //Add Recipe -->
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
				
					
		<!-- //Search for that recipe -->
		";
	} // recipe_search
	elseif($action == "open_recipe_category"){
		// Find category
		$recipe_category_id_mysql = quote_smart($link, $recipe_category_id);
		$query = "SELECT category_id, category_name, category_age_restriction FROM $t_recipes_categories WHERE category_id=$recipe_category_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_category_id, $get_category_name, $get_category_age_restriction) = $row;

		if($get_category_id == ""){
			echo"Server error 404";
		}
		else{
			// Get translation
			$query = "SELECT category_translation_id, category_translation_value FROM $t_recipes_categories_translations WHERE category_id=$get_category_id AND category_translation_language=$l_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_category_translation_id, $get_category_translation_value) = $row;
		
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
				<a href=\"food_diary_add.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_new_entry</a>
				&gt;
				<a href=\"food_diary_add_recipe.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_recipes</a>
				&gt;
				<a href=\"food_diary_add_recipe.php?action=$action&amp;date=$date&amp;meal_id=$meal_id&amp;recipe_category_id=$recipe_category_id&amp;l=$l\">$get_category_translation_value</a>
				</p>
			<!-- //You are here -->

		
			<!-- Recipe search -->
				
			<!-- Search engines Autocomplete -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_entry_recipe_query\"]').focus();
				});
				\$(document).ready(function () {
					\$('[name=\"inp_entry_recipe_query\"]').keyup(function () {


        					// getting the value that user typed
        					var searchString    = $(\"#inp_entry_recipe_query\").val();
        					// forming the queryString
       						var data            = 'l=$l&date=$date&meal_id=$meal_id&q='+ searchString;
         
        					// if searchString is not empty
        					if(searchString) {
        						// ajax call
          						\$.ajax({
                						type: \"POST\",
               							url: \"food_diary_add_recipe_query.php\",
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
				<form method=\"get\" action=\"food_diary_add_recipe.php\" enctype=\"multipart/form-data\" id=\"inp_entry_food_query_form\">
					<p style=\"padding-top:0;\"><b>$l_recipe_search</b><br />
					<input type=\"text\" name=\"inp_entry_recipe_query\" id=\"inp_entry_recipe_query\" value=\"";if(isset($_GET['inp_entry_recipe_query'])){ echo"$inp_entry_recipe_query"; } echo"\" size=\"15\" />
					<input type=\"hidden\" name=\"action\" value=\"recipe_search\" />
					<input type=\"hidden\" name=\"date\" value=\"$date\" />
					<input type=\"hidden\" name=\"meal_id\" value=\"$meal_id\" />
					<input type=\"submit\" value=\"$l_search\" class=\"btn btn_default\" />
					<a href=\"$root/recipes/submit_recipe.php?l=$l\" class=\"btn btn_default\">$l_new_recipe</a>
					</p>
				</form>
			<!-- //Food Search -->
			<!-- //Recipe search -->

			<!-- Menu -->
			<div class=\"tabs\">
				<ul>
					<li><a href=\"food_diary_add.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_recent</a></li>
					<li><a href=\"food_diary_add_food.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_food</a></li>
					<li><a href=\"food_diary_add_recipe.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\" class=\"selected\">$l_recipes</a></li>
				</ul>
			</div>
			<div class=\"clear\" style=\"height: 20px;\"></div>
			<!-- //Menu -->
		
			

			<!-- Recipes in category list -->
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

				// Get all recipes
				$query = "SELECT recipe_id, recipe_title, recipe_introduction, recipe_image_path, recipe_image FROM $t_recipes WHERE recipe_language=$l_mysql";

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
						<!-- //Add Recipe -->
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
				
					
			<!-- //Recipes in category list -->
			";
		} // Category found
	} // open_recipe_category
	elseif($action == "add_recipe_to_diary"){
		if($process == 1){
			$inp_updated = date("Y-m-d H:i:s");
			$inp_updated_mysql = quote_smart($link, $inp_updated);

			$inp_entry_date = output_html($date);
			$inp_entry_date_mysql = quote_smart($link, $inp_entry_date);

			$inp_entry_meal_id = output_html($meal_id);
			$inp_entry_meal_id_mysql = quote_smart($link, $inp_entry_meal_id);

			$inp_entry_recipe_id = $_GET['recipe_id'];
			$inp_entry_recipe_id = output_html($inp_entry_recipe_id);
			$inp_entry_recipe_id_mysql = quote_smart($link, $inp_entry_recipe_id);


			$inp_entry_serving_size = $_GET['entry_serving_size'];
			$inp_entry_serving_size = output_html($inp_entry_serving_size);
			$inp_entry_serving_size = str_replace(",", ".", $inp_entry_serving_size);
			$inp_entry_serving_size_mysql = quote_smart($link, $inp_entry_serving_size);
			if($inp_entry_serving_size == ""){
				$url = "food_diary_add_recipe.php?date=$date&meal_id=$meal_id&l=$l";
				$url = $url . "&ft=error&fm=missing_amount";
				header("Location: $url");
				exit;
			}


			// get recipe
			$query = "SELECT recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password FROM $t_recipes WHERE recipe_id=$inp_entry_recipe_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_recipe_id, $get_recipe_user_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_language, $get_recipe_introduction, $get_recipe_directions, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb, $get_recipe_video, $get_recipe_date, $get_recipe_time, $get_recipe_cusine_id, $get_recipe_season_id, $get_recipe_occasion_id, $get_recipe_marked_as_spam, $get_recipe_unique_hits, $get_recipe_unique_hits_ip_block, $get_recipe_user_ip, $get_recipe_notes, $get_recipe_password) = $row;
			if($get_recipe_id == ""){
				$url = "food_diary_add_recipe.php?date=$date&meal_id=$meal_id&l=$l";
				$url = $url . "&ft=error&fm=recipe_specified_not_found";
				header("Location: $url");
				exit;
			}

			// get numbers
			$query = "SELECT number_id, number_recipe_id, number_hundred_calories, number_hundred_proteins, number_hundred_fat, number_hundred_carbs, number_serving_calories, number_serving_proteins, number_serving_fat, number_serving_carbs, number_total_weight, number_total_calories, number_total_proteins, number_total_fat, number_total_carbs, number_servings FROM $t_recipes_numbers WHERE number_recipe_id=$inp_entry_recipe_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_number_id, $get_number_recipe_id, $get_number_hundred_calories, $get_number_hundred_proteins, $get_number_hundred_fat, $get_number_hundred_carbs, $get_number_serving_calories, $get_number_serving_proteins, $get_number_serving_fat, $get_number_serving_carbs, $get_number_total_weight, $get_number_total_calories, $get_number_total_proteins, $get_number_total_fat, $get_number_total_carbs, $get_number_servings) = $row;

			$inp_entry_name = output_html($get_recipe_title);
			$inp_entry_name_mysql = quote_smart($link, $inp_entry_name);

			$inp_entry_manufacturer_name = output_html("");
			$inp_entry_manufacturer_name_mysql = quote_smart($link, $inp_entry_manufacturer_name);

			if($inp_entry_serving_size == "1"){
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
			mysqli_query($link, "INSERT INTO $t_food_diary_entires
			(entry_id, entry_user_id, entry_date, entry_meal_id, entry_food_id, entry_recipe_id, 
			entry_name, entry_manufacturer_name, entry_serving_size, entry_serving_size_measurement, 
			entry_energy_per_entry, entry_fat_per_entry, entry_carb_per_entry, entry_protein_per_entry,
			entry_updated, entry_synchronized) 
			VALUES 
			(NULL, '$get_my_user_id', $inp_entry_date_mysql, $inp_entry_meal_id_mysql, '0', $inp_entry_recipe_id_mysql,
			$inp_entry_name_mysql, '', $inp_entry_serving_size_mysql, $inp_entry_serving_size_measurement_mysql, 
			$inp_entry_energy_per_entry_mysql, $inp_entry_fat_per_entry_mysql, $inp_entry_carb_per_entry_mysql, $inp_entry_protein_per_entry_mysql,
			$inp_updated_mysql, '0')")
			or die(mysqli_error($link));


			// food_diary_totals_meals :: Calcualte :: Get all meals for that day, and update numbers
			$inp_total_meal_energy = 0;
			$inp_total_meal_fat = 0;
			$inp_total_meal_carb = 0;
			$inp_total_meal_protein = 0;
			
			$query = "SELECT entry_id, entry_energy_per_entry, entry_fat_per_entry, entry_carb_per_entry, entry_protein_per_entry FROM $t_food_diary_entires WHERE entry_user_id=$my_user_id_mysql AND entry_date=$inp_entry_date_mysql AND entry_meal_id=$inp_entry_meal_id_mysql";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
    				list($get_entry_id, $get_entry_energy_per_entry, $get_entry_fat_per_entry, $get_entry_carb_per_entry, $get_entry_protein_per_entry) = $row;

				
				$inp_total_meal_energy 		= $inp_total_meal_energy+$get_entry_energy_per_entry;
				$inp_total_meal_fat 		= $inp_total_meal_fat+$get_entry_fat_per_entry;
				$inp_total_meal_carb		= $inp_total_meal_carb+$get_entry_carb_per_entry;
				$inp_total_meal_protein 	= $inp_total_meal_protein+$get_entry_protein_per_entry;
			}
			
			$result = mysqli_query($link, "UPDATE $t_food_diary_totals_meals SET 
			total_meal_energy='$inp_total_meal_energy', total_meal_fat='$inp_total_meal_fat', total_meal_carb='$inp_total_meal_carb', total_meal_protein='$inp_total_meal_protein',
			total_meal_updated=$inp_updated_mysql, total_meal_synchronized='0'
			 WHERE total_meal_user_id=$my_user_id_mysql AND total_meal_date=$inp_entry_date_mysql AND total_meal_meal_id=$inp_entry_meal_id_mysql");


			// food_diary_totals_days
			$query = "SELECT total_day_id, total_day_user_id, total_day_date, total_day_consumed_energy, total_day_consumed_fat, total_day_consumed_carb, total_day_consumed_protein, total_day_target_sedentary_energy, total_day_target_sedentary_fat, total_day_target_sedentary_carb, total_day_target_sedentary_protein, total_day_target_with_activity_energy, total_day_target_with_activity_fat, total_day_target_with_activity_carb, total_day_target_with_activity_protein, total_day_diff_sedentary_energy, total_day_diff_sedentary_fat, total_day_diff_sedentary_carb, total_day_diff_sedentary_protein, total_day_diff_with_activity_energy, total_day_diff_with_activity_fat, total_day_diff_with_activity_carb, total_day_diff_with_activity_protein FROM $t_food_diary_totals_days WHERE total_day_user_id=$my_user_id_mysql AND total_day_date=$inp_entry_date_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_total_day_id, $get_total_day_user_id, $get_total_day_date, $get_total_day_consumed_energy, $get_total_day_consumed_fat, $get_total_day_consumed_carb, $get_total_day_consumed_protein, $get_total_day_target_sedentary_energy, $get_total_day_target_sedentary_fat, $get_total_day_target_sedentary_carb, $get_total_day_target_sedentary_protein, $get_total_day_target_with_activity_energy, $get_total_day_target_with_activity_fat, $get_total_day_target_with_activity_carb, $get_total_day_target_with_activity_protein, $get_total_day_diff_sedentary_energy, $get_total_day_diff_sedentary_fat, $get_total_day_diff_sedentary_carb, $get_total_day_diff_sedentary_protein, $get_total_day_diff_with_activity_energy, $get_total_day_diff_with_activity_fat, $get_total_day_diff_with_activity_carb, $get_total_day_diff_with_activity_protein) = $row;

			$inp_total_day_consumed_energy = "";
			$inp_total_day_consumed_fat = "";
			$inp_total_day_consumed_carb = "";
			$inp_total_day_consumed_protein = "";
			$query = "SELECT total_meal_id, total_meal_energy, total_meal_fat, total_meal_carb, total_meal_protein FROM $t_food_diary_totals_meals WHERE total_meal_user_id=$my_user_id_mysql AND total_meal_date=$inp_entry_date_mysql";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
    				list($get_total_meal_id, $get_total_meal_energy, $get_total_meal_fat, $get_total_meal_carb, $get_total_meal_protein) = $row;

				
				$inp_total_day_consumed_energy = $inp_total_day_consumed_energy+$get_total_meal_energy;
				$inp_total_day_consumed_fat = $inp_total_day_consumed_fat+$get_total_meal_fat;
				$inp_total_day_consumed_carb = $inp_total_day_consumed_carb+$get_total_meal_carb;
				$inp_total_day_consumed_protein = $inp_total_day_consumed_protein+$get_total_meal_protein;
			}



			$inp_total_day_diff_sedentary_energy = $get_total_day_target_sedentary_energy-$inp_total_day_consumed_energy;
			$inp_total_day_diff_sedentary_fat = $get_total_day_target_sedentary_fat-$inp_total_day_consumed_fat;
			$inp_total_day_diff_sedentary_carb = $get_total_day_target_sedentary_energy-$inp_total_day_consumed_carb;
			$inp_total_day_diff_sedentary_protein = $get_total_day_target_sedentary_energy-$inp_total_day_consumed_protein;
	

			$inp_total_day_diff_with_activity_energy = $get_total_day_target_with_activity_energy-$inp_total_day_consumed_energy;
			$inp_total_day_diff_with_activity_fat = $get_total_day_target_with_activity_fat-$inp_total_day_consumed_fat;
			$inp_total_day_diff_with_activity_carb = $get_total_day_target_with_activity_energy-$inp_total_day_consumed_carb;
			$inp_total_day_diff_with_activity_protein = $get_total_day_target_with_activity_energy-$inp_total_day_consumed_protein;

			$result = mysqli_query($link, "UPDATE $t_food_diary_totals_days SET 
			total_day_consumed_energy='$inp_total_day_consumed_energy', total_day_consumed_fat='$inp_total_day_consumed_fat', total_day_consumed_carb='$inp_total_day_consumed_carb', total_day_consumed_protein=$inp_total_day_consumed_protein,
			total_day_diff_sedentary_energy='$inp_total_day_diff_sedentary_energy', total_day_diff_sedentary_fat='$inp_total_day_diff_sedentary_fat', total_day_diff_sedentary_carb='$inp_total_day_diff_sedentary_carb', total_day_diff_sedentary_protein='$inp_total_day_diff_sedentary_protein',
			total_day_diff_with_activity_energy='$inp_total_day_diff_with_activity_energy', total_day_diff_with_activity_fat='$inp_total_day_diff_with_activity_fat', total_day_diff_with_activity_carb='$inp_total_day_diff_with_activity_carb', total_day_diff_with_activity_protein='$inp_total_day_diff_with_activity_protein',
			total_day_updated=$inp_updated_mysql, total_day_synchronized='0'
			 WHERE total_day_user_id=$my_user_id_mysql AND total_day_date=$inp_entry_date_mysql");


			// Add recipe to recent list
			$day_of_the_week = date("N");

			$query = "SELECT last_used_id, last_used_times FROM $t_food_diary_last_used WHERE last_used_user_id=$my_user_id_mysql AND last_used_day_of_week='$day_of_the_week' AND last_used_meal_id=$inp_entry_meal_id_mysql AND last_used_recipe_id=$inp_entry_recipe_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_last_used_id, $get_last_used_times) = $row;
			if($get_last_used_id == ""){
				// First time used this recipe
				mysqli_query($link, "INSERT INTO $t_food_diary_last_used
				(last_used_id, last_used_user_id, last_used_day_of_week,last_used_meal_id, last_used_food_id, last_used_recipe_id, last_serving_size, last_used_times, last_used_date,
				last_used_updated, last_used_synchronized) 
				VALUES 
				(NULL, '$get_my_user_id', '$day_of_the_week', $inp_entry_meal_id_mysql, '0', $inp_entry_recipe_id_mysql, $inp_entry_serving_size_mysql, '1', $inp_entry_date_mysql,
				$inp_updated_mysql, '0')")
				or die(mysqli_error($link));
			}
			else{
				// Update counter and date
				$inp_last_used_times = $get_last_used_times + 1;

				$result = mysqli_query($link, "UPDATE $t_food_diary_last_used SET 
				last_used_times='$inp_last_used_times', last_serving_size=$inp_entry_serving_size_mysql, last_used_date=$inp_entry_date_mysql
				 WHERE last_used_id='$get_last_used_id'");

			}

			$url = "index.php?action=food_diary&date=$date";
			$url = $url . "&ft=success&fm=food_added#meal_id$meal_id";
			header("Location: $url");
			exit;
		}
	} // add_recipe_to_diary
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