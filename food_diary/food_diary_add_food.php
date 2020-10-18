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

	
		<!-- You are here -->
			<p><b>$l_you_are_here</b><br />
			<a href=\"index.php?l=$l\">$l_food_diary</a>
			&gt;
			<a href=\"food_diary_add.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_new_entry</a>
			&gt;
			<a href=\"food_diary_add_food.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_food</a>
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


		<!-- Menu -->
			<div class=\"tabs\">
				<ul>
					<li><a href=\"food_diary_add.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_recent</a></li>
					<li><a href=\"food_diary_add_food.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\" class=\"selected\">$l_food</a></li>
					<li><a href=\"food_diary_add_recipe.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_recipes</a></li>
				</ul>
			</div>
			<div class=\"clear\" style=\"height: 20px;\"></div>
		<!-- //Menu -->
	
		<!-- Food main categories -->
			<div class=\"vertical\">
				<ul>\n";
				// Get all categories
				$query = "SELECT $t_food_categories.category_id, $t_food_categories.category_name, $t_food_categories.category_parent_id FROM $t_food_categories";
				$query = $query . " WHERE category_user_id='0' AND category_parent_id='0' ORDER BY category_name ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_category_id, $get_category_name, $get_category_parent_id) = $row;
					// Translation
					$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_category_id AND category_translation_language=$l_mysql";
					$result_t = mysqli_query($link, $query_t);
					$row_t = mysqli_fetch_row($result_t);
					list($get_category_translation_value) = $row_t;

					echo"					";
					echo"<li><a href=\"food_diary_add_food.php?action=open_main_category&amp;date=$date&amp;meal_id=$meal_id&amp;inp_entry_food_query=$inp_entry_food_query&amp;main_category_id=$get_category_id&amp;l=$l\""; if($main_category_id == "$get_category_id"){ echo" style=\"font-weight: bold;\"";}echo">$get_category_translation_value</a></li>\n";
				}
			echo"
				</ul>
			</div>
		<!-- //Food main categories -->
		

		<!-- List all food in all categories -->

			<div id=\"nettport_search_results\">
			";
	
					// Set layout
					$x = 0;

			// Get all food
			$query = "SELECT food_id, food_user_id, food_name, food_manufacturer_name, food_description, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_fat, food_energy_calculated, food_proteins_calculated, food_carbohydrates_calculated, food_fat_calculated, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_unique_hits, food_likes, food_dislikes FROM $t_food_index WHERE food_language=$l_mysql";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_food_id, $get_food_user_id, $get_food_name, $get_food_manufacturer_name, $get_food_description, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_fat, $get_food_energy_calculated, $get_food_proteins_calculated, $get_food_carbohydrates_calculated, $get_food_fat_calculated, $get_food_barcode, $get_food_main_category_id, $get_food_sub_category_id,  $get_food_image_path, $get_food_image_a, $get_food_thumb_a_small, $get_food_unique_hits, $get_food_likes, $get_food_dislikes) = $row;
			
				// Name saying
				$title = "$get_food_manufacturer_name $get_food_name";
				$check = strlen($title);
				if($check > 35){
					$title = substr($title, 0, 35);
					$title = $title . "...";
				}



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
				</p>
				<table style=\"margin: 0px auto;\">
				 <tr>
				  <td style=\"padding-right: 10px;text-align: center;\">
					<span class=\"grey_smal\">$get_food_energy</span>
				  </td>
				  <td style=\"padding-right: 10px;text-align: center;\">
					<span class=\"grey_smal\">$get_food_fat</span>
				  </td>
				  <td style=\"padding-right: 10px;text-align: center;\">
					<span class=\"grey_smal\">$get_food_carbohydrates</span>
				  </td>
				  <td style=\"text-align: center;\">
					<span class=\"grey_smal\">$get_food_proteins</span>
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
					";
					if($get_food_serving_size_pcs_measurement == "g"){
						echo"
						<input type=\"text\" name=\"inp_entry_food_serving_size\" size=\"2\" value=\"$get_food_serving_size_gram\" />
						<input type=\"submit\" name=\"inp_submit_gram\" value=\"$get_food_serving_size_gram_measurement\" class=\"btn btn_default\" />";
					}
					else {
						echo"
						<input type=\"text\" name=\"inp_entry_food_serving_size\" size=\"2\" value=\"$get_food_serving_size_pcs\" />
						<input type=\"submit\" name=\"inp_submit_gram\" value=\"$get_food_serving_size_gram_measurement\" class=\"btn btn_default\" />
						<input type=\"submit\" name=\"inp_submit_pcs\" value=\"$get_food_serving_size_pcs_measurement\" class=\"btn btn_default\" />";
					}
					echo"
					</p>
					</form>
				<!-- //Add food -->
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
		<!-- //List all food in all categories -->


		";
	} // action == ""
	elseif($action == "search"){

		echo"
		<h1>$l_new_entry</h1>

	
		<!-- You are here -->
			<p><b>$l_you_are_here</b><br />
			<a href=\"index.php?l=$l\">$l_food_diary</a>
			&gt;
			<a href=\"food_diary_add.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_new_entry</a>
			&gt;
			<a href=\"food_diary_add_food.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_food</a>
			&gt;
			<a href=\"food_diary_add_food.php?action=search&amp;date=$date&amp;meal_id=$meal_id&amp;inp_entry_food_query=$inp_entry_food_query&amp;l=$l\">$inp_entry_food_query</a>
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
					<input type=\"text\" id=\"inp_entry_food_query\" name=\"inp_entry_food_query\" value=\"";if(isset($_GET['inp_entry_food_query'])){ echo"$inp_entry_food_query"; } echo"\" size=\"17\" />
					<input type=\"hidden\" name=\"action\" value=\"search\" />
					<input type=\"hidden\" name=\"date\" value=\"$date\" />
					<input type=\"hidden\" name=\"meal_id\" value=\"$meal_id\" />
					<input type=\"submit\" value=\"$l_search\" class=\"btn btn_default\" />
					<a href=\"$root/food/new_food.php?l=$l\" class=\"btn btn_default\">$l_new_food</a>
					</p>
				</form>
			<!-- //Food Search -->
		<!-- //Search -->


		<!-- Menu -->
			<div class=\"tabs\">
				<ul>
					<li><a href=\"food_diary_add.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_recent</a></li>
					<li><a href=\"food_diary_add_food.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\" class=\"selected\">$l_food</a></li>
					<li><a href=\"food_diary_add_recipe.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_recipes</a></li>
				</ul>
			</div>
			<div class=\"clear\" style=\"height: 20px;\"></div>
		<!-- //Menu -->
		

		<!-- Food that fits that search -->

			<div id=\"nettport_search_results\">
			";
	
			// Set layout
			$x = 0;

			// Get all food
			$query = "SELECT food_id, food_user_id, food_name, food_manufacturer_name, food_description, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_fat, food_energy_calculated, food_proteins_calculated, food_carbohydrates_calculated, food_fat_calculated, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_unique_hits, food_likes, food_dislikes FROM $t_food_index WHERE food_language=$l_mysql";
			$query = $query . " ORDER BY food_manufacturer_name, food_name ASC";

			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_food_id, $get_food_user_id, $get_food_name, $get_food_manufacturer_name, $get_food_description, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_fat, $get_food_energy_calculated, $get_food_proteins_calculated, $get_food_carbohydrates_calculated, $get_food_fat_calculated, $get_food_barcode, $get_food_main_category_id, $get_food_sub_category_id,$get_food_image_path, $get_food_image_a, $get_food_thumb_a_small, $get_food_unique_hits, $get_food_likes, $get_food_dislikes) = $row;
			
				// Name saying
				$title = "$get_food_manufacturer_name $get_food_name";
				$check = strlen($title);
				if($check > 35){
					$title = substr($title, 0, 35);
					$title = $title . "...";
				}
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

				// Thumb
				if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a")){
					$thumb = "../$get_food_image_path/$get_food_thumb_a_small";
				}
				else{
					$thumb = "_gfx/no_thumb.png";
				}


				echo"
				<p style=\"padding-bottom:5px;\">
				<a href=\"$root/food/view_food.php?food_id=$get_food_id&amp;l=$l\"><img src=\"$thumb\" alt=\"$get_food_image_a\" style=\"margin-bottom: 5px;\" /></a><br />
				<a href=\"$root/food/view_food.php?food_id=$get_food_id&amp;l=$l\" style=\"font-weight: bold;color: #444444;\">$title</a><br />
				</p>
				<table style=\"margin: 0px auto;\">
				 <tr>
				  <td style=\"padding-right: 10px;text-align: center;\">
					<span class=\"grey_smal\">$get_food_energy</span>
				  </td>
				  <td style=\"padding-right: 10px;text-align: center;\">
					<span class=\"grey_smal\">$get_food_fat</span>
				  </td>
				  <td style=\"padding-right: 10px;text-align: center;\">
					<span class=\"grey_smal\">$get_food_carbohydrates</span>
				  </td>
				  <td style=\"text-align: center;\">
					<span class=\"grey_smal\">$get_food_proteins</span>
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
					";
					if($get_food_serving_size_pcs_measurement == "g"){
						echo"
						<input type=\"text\" name=\"inp_entry_food_serving_size\" size=\"2\" value=\"$get_food_serving_size_gram\" />
						<input type=\"submit\" name=\"inp_submit_gram\" value=\"$get_food_serving_size_gram_measurement\" class=\"btn btn_default\" />";
					}
					else {
						echo"
						<input type=\"text\" name=\"inp_entry_food_serving_size\" size=\"2\" value=\"$get_food_serving_size_pcs\" />
						<input type=\"submit\" name=\"inp_submit_gram\" value=\"$get_food_serving_size_gram_measurement\" class=\"btn btn_default\" />
						<input type=\"submit\" name=\"inp_submit_pcs\" value=\"$get_food_serving_size_pcs_measurement\" class=\"btn btn_default\" />";
					}
					echo"
					</p>
					</form>
				<!-- //Add food -->
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
		
		<!-- //Food that fits that search -->


		";
	} // action == ""
	elseif($action == "open_main_category"){	
		// Get main category
		$main_category_id_mysql = quote_smart($link, $main_category_id);
		$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$main_category_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_main_category_id, $get_current_main_category_user_id, $get_current_main_category_name, $get_current_main_category_parent_id) = $row;
		if($get_current_main_category_id == ""){
			echo"Server error 404";
		}
		else{
			// Translation
			$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_current_main_category_id AND category_translation_language=$l_mysql";
			$result_t = mysqli_query($link, $query_t);
			$row_t = mysqli_fetch_row($result_t);
			list($get_current_main_category_translation_value) = $row_t;

			echo"
			<h1>$l_new_entry</h1>

	
			<!-- You are here -->
				<p><b>$l_you_are_here</b><br />
				<a href=\"index.php?l=$l\">$l_food_diary</a>
				&gt;
				<a href=\"food_diary_add.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_new_entry</a>
				&gt;
				<a href=\"food_diary_add_food.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_food</a>
				&gt;
				<a href=\"food_diary_add_food.php?action=$action&amp;date=$date&amp;meal_id=$meal_id&amp;main_category_id=$main_category_id&amp;l=$l\">$get_current_main_category_translation_value</a>
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
					<input type=\"text\" id=\"inp_entry_food_query\" name=\"inp_entry_food_query\" value=\"";if(isset($_GET['inp_entry_food_query'])){ echo"$inp_entry_food_query"; } echo"\" size=\"17\" />
					<input type=\"hidden\" name=\"action\" value=\"search\" />
					<input type=\"hidden\" name=\"date\" value=\"$date\" />
					<input type=\"hidden\" name=\"meal_id\" value=\"$meal_id\" />
					<input type=\"submit\" value=\"$l_search\" class=\"btn btn_default\" />
					<a href=\"$root/food/new_food.php?l=$l\" class=\"btn btn_default\">$l_new_food</a>
					</p>
				</form>
				<!-- //Food Search -->
			<!-- //Search -->


			<!-- Menu -->
			<div class=\"tabs\">
				<ul>
					<li><a href=\"food_diary_add.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_recent</a></li>
					<li><a href=\"food_diary_add_food.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\" class=\"selected\">$l_food</a></li>
					<li><a href=\"food_diary_add_recipe.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_recipes</a></li>
				</ul>
			</div>
			<div class=\"clear\" style=\"height: 20px;\"></div>
			<!-- //Menu -->
	
			<!-- Food sub categories -->
			<div class=\"vertical\">
				<ul>
					<li><a href=\"food_diary_add_food.php?action=$action&amp;date=$date&amp;meal_id=$meal_id&amp;main_category_id=$main_category_id&amp;l=$l\">$get_current_main_category_translation_value</a>\n";
				// Get sub categories

				

				$queryb = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='$get_current_main_category_id' ORDER BY category_name ASC";
				$resultb = mysqli_query($link, $queryb);
				while($rowb = mysqli_fetch_row($resultb)) {
					list($get_sub_category_id, $get_sub_category_name, $get_sub_category_parent_id) = $rowb;

					// Translation
					$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_sub_category_id AND category_translation_language=$l_mysql";
					$result_t = mysqli_query($link, $query_t);
					$row_t = mysqli_fetch_row($result_t);
					list($get_sub_category_translation_value) = $row_t;

					$get_sub_category_translation_value_len = strlen($get_sub_category_translation_value);

					echo"						";
					echo"<li><a href=\"food_diary_add_food.php?action=open_sub_category&amp;date=$date&amp;meal_id=$meal_id&amp;inp_entry_food_query=$inp_entry_food_query&amp;main_category_id=$main_category_id&amp;sub_category_id=$get_sub_category_id&amp;l=$l\""; if($sub_category_id == "$get_sub_category_id"){ echo" style=\"font-weight: bold;\"";}echo">&nbsp; &nbsp; $get_sub_category_translation_value</a></li>\n";


					// In category for mysql
					if(isset($in_category)){
						$in_category = $in_category . ",$get_sub_category_id";
					}
					else{
						$in_category = "$get_sub_category_id";
					}

				}
			echo"
				</ul>
			</div>
			<!-- //Food sub categories -->
	
			
			<!-- List all food in main category -->



					<div id=\"nettport_search_results\">
					";
	
					// Set layout
					$x = 0;

					// Get all food
					$query = "SELECT food_id, food_user_id, food_name, food_manufacturer_name, food_description, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_fat, food_energy_calculated, food_proteins_calculated, food_carbohydrates_calculated, food_fat_calculated, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_unique_hits, food_likes, food_dislikes FROM $t_food_index WHERE food_language=$l_mysql";
					if(isset($_GET['inp_entry_food_query'])){
						$inp_entry_food_query = $_GET['inp_entry_food_query'];
						$inp_entry_food_query = strip_tags(stripslashes($inp_entry_food_query));
						$inp_entry_food_query = output_html($inp_entry_food_query);
						
						$inp_entry_food_query = "%" . $inp_entry_food_query . "%";
						$inp_entry_food_query_mysql = quote_smart($link, $inp_entry_food_query);

						$query = $query . " AND food_name LIKE $inp_entry_food_query_mysql";
					}
					
					
					$query = $query . " AND food_main_category_id=$get_current_main_category_id";

					$query = $query . " ORDER BY food_manufacturer_name, food_name ASC";

					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_food_id, $get_food_user_id, $get_food_name, $get_food_manufacturer_name, $get_food_description, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_fat, $get_food_energy_calculated, $get_food_proteins_calculated, $get_food_carbohydrates_calculated, $get_food_fat_calculated, $get_food_barcode, $get_food_main_category_id, $get_food_sub_category_id,  $get_food_image_path, $get_food_image_a, $get_food_thumb_a_small, $get_food_unique_hits, $get_food_likes, $get_food_dislikes) = $row;
			
						// Name saying
						$title = "$get_food_manufacturer_name $get_food_name";
						$check = strlen($title);
						if($check > 35){
							$title = substr($title, 0, 35);
							$title = $title . "...";
						}

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
						// Thumb
						if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a")){
							$thumb = "../$get_food_image_path/$get_food_thumb_a_small";
						}
						else{
							$thumb = "_gfx/no_thumb.png";
						}



						echo"
							<p style=\"padding-bottom:5px;\">
							<a href=\"$root/food/view_food.php?food_id=$get_food_id&amp;l=$l\"><img src=\"$thumb\" alt=\"$get_food_image_a\" style=\"margin-bottom: 5px;\" /></a><br />
			
							<a href=\"$root/food/view_food.php?food_id=$get_food_id&amp;l=$l\" style=\"font-weight: bold;color: #444444;\">$title</a><br />
							";
							echo"
							</p>
							<table style=\"margin: 0px auto;\">
							 <tr>
							  <td style=\"padding-right: 10px;text-align: center;\">
								<span class=\"grey_smal\">$get_food_energy</span>
							  </td>
							  <td style=\"padding-right: 10px;text-align: center;\">
								<span class=\"grey_smal\">$get_food_fat</span>
							  </td>
							  <td style=\"padding-right: 10px;text-align: center;\">
								<span class=\"grey_smal\">$get_food_carbohydrates</span>
							  </td>
							  <td style=\"text-align: center;\">
								<span class=\"grey_smal\">$get_food_proteins</span>
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
								";
								if($get_food_serving_size_pcs_measurement == "g"){
									echo"
									<input type=\"text\" name=\"inp_entry_food_serving_size\" size=\"2\" value=\"$get_food_serving_size_gram\" />
									<input type=\"submit\" name=\"inp_submit_gram\" value=\"$get_food_serving_size_gram_measurement\" class=\"btn btn_default\" />";
								}
								else {
									echo"
									<input type=\"text\" name=\"inp_entry_food_serving_size\" size=\"2\" value=\"$get_food_serving_size_pcs\" />
									<input type=\"submit\" name=\"inp_submit_gram\" value=\"$get_food_serving_size_gram_measurement\" class=\"btn btn_default\" />
									<input type=\"submit\" name=\"inp_submit_pcs\" value=\"$get_food_serving_size_pcs_measurement\" class=\"btn btn_default\" />";
								}
								echo"
								</p>
								</form>
							<!-- //Add food -->
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
		
			<!-- //List all food in main category -->
			";
		} // main category found
	} // open main category
	elseif($action == "open_sub_category"){	
		// Get main category
		$main_category_id_mysql = quote_smart($link, $main_category_id);
		$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$main_category_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_main_category_id, $get_current_main_category_user_id, $get_current_main_category_name, $get_current_main_category_parent_id) = $row;
		if($get_current_main_category_id == ""){
			echo"Server error 404";
		}
		else{
			// Main Translation
			$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_current_main_category_id AND category_translation_language=$l_mysql";
			$result_t = mysqli_query($link, $query_t);
			$row_t = mysqli_fetch_row($result_t);
			list($get_current_main_category_translation_value) = $row_t;

			// Find sub
			$sub_category_id_mysql = quote_smart($link, $sub_category_id);
			$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$sub_category_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_sub_category_id, $get_current_sub_category_user_id, $get_current_sub_category_name, $get_current_sub_category_parent_id) = $row;
			if($get_current_sub_category_id== ""){
				echo"Server error 404";
			}
			else{
				// Sub category Translation
				$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_current_sub_category_id AND category_translation_language=$l_mysql";
				$result_t = mysqli_query($link, $query_t);
				$row_t = mysqli_fetch_row($result_t);
				list($get_current_sub_category_translation_value) = $row_t;
	


				echo"
				<h1>$l_new_entry</h1>

	
				<!-- You are here -->
					<p><b>$l_you_are_here</b><br />
					<a href=\"index.php?l=$l\">$l_food_diary</a>
					&gt;
					<a href=\"food_diary_add.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_new_entry</a>
					&gt;
					<a href=\"food_diary_add_food.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_food</a>
					&gt;
					<a href=\"food_diary_add_food.php?action=open_main_category&amp;date=$date&amp;meal_id=$meal_id&amp;main_category_id=$main_category_id&amp;l=$l\">$get_current_main_category_translation_value</a>
					&gt;
					<a href=\"food_diary_add_food.php?action=$action&amp;date=$date&amp;meal_id=$meal_id&amp;main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&am;l=$l\">$get_current_sub_category_translation_value</a>
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
					<input type=\"text\" id=\"inp_entry_food_query\" name=\"inp_entry_food_query\" value=\"";if(isset($_GET['inp_entry_food_query'])){ echo"$inp_entry_food_query"; } echo"\" size=\"17\" />
					<input type=\"hidden\" name=\"action\" value=\"search\" />
					<input type=\"hidden\" name=\"date\" value=\"$date\" />
					<input type=\"hidden\" name=\"meal_id\" value=\"$meal_id\" />
					<input type=\"submit\" value=\"$l_search\" class=\"btn btn_default\" />
					<a href=\"$root/food/new_food.php?l=$l\" class=\"btn btn_default\">$l_new_food</a>
					</p>
				</form>
				<!-- //Food Search -->
				<!-- //Search -->


				<!-- Menu -->
					<div class=\"tabs\">
						<ul>
							<li><a href=\"food_diary_add.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_recent</a></li>
							<li><a href=\"food_diary_add_food.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\" class=\"selected\">$l_food</a></li>
							<li><a href=\"food_diary_add_recipe.php?date=$date&amp;meal_id=$meal_id&amp;l=$l\">$l_recipes</a></li>
						</ul>
					</div>
					<div class=\"clear\" style=\"height: 20px;\"></div>
				<!-- //Menu -->
			
				<!-- List all food in sub category -->



					<div id=\"nettport_search_results\">
					";
	
					// Set layout
					$x = 0;

					// Get all food
					$query = "SELECT food_id, food_user_id, food_name, food_manufacturer_name, food_description, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_fat, food_energy_calculated, food_proteins_calculated, food_carbohydrates_calculated, food_fat_calculated, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_unique_hits, food_likes, food_dislikes FROM $t_food_index WHERE food_language=$l_mysql";
					if(isset($_GET['inp_entry_food_query'])){
						$inp_entry_food_query = $_GET['inp_entry_food_query'];
						$inp_entry_food_query = strip_tags(stripslashes($inp_entry_food_query));
						$inp_entry_food_query = output_html($inp_entry_food_query);
						
						$inp_entry_food_query = "%" . $inp_entry_food_query . "%";
						$inp_entry_food_query_mysql = quote_smart($link, $inp_entry_food_query);

						$query = $query . " AND food_name LIKE $inp_entry_food_query_mysql";
					}
					if($sub_category_id != ""){
						$sub_category_id_mysql = quote_smart($link, $sub_category_id);
						$query = $query . " AND food_sub_category_id=$sub_category_id_mysql";
					}

					$query = $query . " ORDER BY food_manufacturer_name, food_name ASC";

					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_food_id, $get_food_user_id, $get_food_name, $get_food_manufacturer_name, $get_food_description, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_fat, $get_food_energy_calculated, $get_food_proteins_calculated, $get_food_carbohydrates_calculated, $get_food_fat_calculated, $get_food_barcode, $get_food_main_category_id, $get_food_sub_category_id,  $get_food_image_path, $get_food_image_a, $get_food_thumb_a_small, $get_food_unique_hits, $get_food_likes, $get_food_dislikes) = $row;
			
						// Name saying
						$title = "$get_food_manufacturer_name $get_food_name";
						$check = strlen($title);
						if($check > 35){
							$title = substr($title, 0, 35);
							$title = $title . "...";
						}

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


						// Thumb
						if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a")){
							$thumb = "../$get_food_image_path/$get_food_thumb_a_small";
						}
						else{
							$thumb = "_gfx/no_thumb.png";
						}



						echo"
							<p style=\"padding-bottom:5px;\">
							<a href=\"$root/food/view_food.php?food_id=$get_food_id&amp;l=$l\"><img src=\"$thumb\" alt=\"$get_food_image_a\" style=\"margin-bottom: 5px;\" /></a><br />
			
							<a href=\"$root/food/view_food.php?food_id=$get_food_id&amp;l=$l\" style=\"font-weight: bold;color: #444444;\">$title</a><br />
							";
							echo"
							</p>
							<table style=\"margin: 0px auto;\">
							 <tr>
							  <td style=\"padding-right: 10px;text-align: center;\">
								<span class=\"grey_smal\">$get_food_energy</span>
							  </td>
							  <td style=\"padding-right: 10px;text-align: center;\">
								<span class=\"grey_smal\">$get_food_fat</span>
							  </td>
							  <td style=\"padding-right: 10px;text-align: center;\">
								<span class=\"grey_smal\">$get_food_carbohydrates</span>
							  </td>
							  <td style=\"text-align: center;\">
								<span class=\"grey_smal\">$get_food_proteins</span>
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
								";
								if($get_food_serving_size_pcs_measurement == "g"){
									echo"
									<input type=\"text\" name=\"inp_entry_food_serving_size\" size=\"2\" value=\"$get_food_serving_size_gram\" />
									<input type=\"submit\" name=\"inp_submit_gram\" value=\"$get_food_serving_size_gram_measurement\" class=\"btn btn_default\" />";
								}
								else {
									echo"
									<input type=\"text\" name=\"inp_entry_food_serving_size\" size=\"2\" value=\"$get_food_serving_size_pcs\" />
									<input type=\"submit\" name=\"inp_submit_gram\" value=\"$get_food_serving_size_gram_measurement\" class=\"btn btn_default\" />
									<input type=\"submit\" name=\"inp_submit_pcs\" value=\"$get_food_serving_size_pcs_measurement\" class=\"btn btn_default\" />";
								}
								echo"
								</p>
								</form>
							<!-- //Add food -->
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
		
				<!-- //List all food in sub category -->
					
				";
			} // sub category found
		} // main category found
	} // open sub category
	elseif($action == "add_food_to_diary"){
		if($process == 1){
			$inp_updated = date("Y-m-d H:i:s");
			$inp_updated_mysql = quote_smart($link, $inp_updated);

			$inp_entry_date = output_html($date);
			$inp_entry_date_mysql = quote_smart($link, $inp_entry_date);

			$inp_entry_meal_id = output_html($meal_id);
			$inp_entry_meal_id_mysql = quote_smart($link, $inp_entry_meal_id);

			$inp_entry_food_id = $_POST['inp_entry_food_id'];
			$inp_entry_food_id = output_html($inp_entry_food_id);
			$inp_entry_food_id_mysql = quote_smart($link, $inp_entry_food_id);

			$inp_entry_food_serving_size = $_POST['inp_entry_food_serving_size'];
			$inp_entry_food_serving_size = output_html($inp_entry_food_serving_size);
			$inp_entry_food_serving_size = str_replace(",", ".", $inp_entry_food_serving_size);
			$inp_entry_food_serving_size_mysql = quote_smart($link, $inp_entry_food_serving_size);
			if($inp_entry_food_serving_size == ""){
				$url = "food_diary_add_food.php?date=$date&meal_id=$meal_id&l=$l";
				$url = $url . "&ft=error&fm=missing_amount";
				header("Location: $url");
				exit;
			}


			// get food
			$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_country, food_net_content, food_net_content_measurement, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_fat, food_fat_of_which_saturated_fatty_acids, food_carbohydrates, food_carbohydrates_of_which_dietary_fiber, food_carbohydrates_of_which_sugars, food_proteins, food_salt, food_sodium, food_score, food_energy_calculated, food_fat_calculated, food_fat_of_which_saturated_fatty_acids_calculated, food_carbohydrates_calculated, food_carbohydrates_of_which_dietary_fiber_calculated, food_carbohydrates_of_which_sugars_calculated, food_proteins_calculated, food_salt_calculated, food_sodium_calculated, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_thumb_a_medium, food_thumb_a_large, food_image_b, food_thumb_b_small, food_thumb_b_medium, food_thumb_b_large, food_image_c, food_thumb_c_small, food_thumb_c_medium, food_thumb_c_large, food_image_d, food_thumb_d_small, food_thumb_d_medium, food_thumb_d_large, food_image_e, food_thumb_e_small, food_thumb_e_medium, food_thumb_e_large, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_created_date, food_last_viewed, food_age_restriction FROM $t_food_index WHERE food_id=$inp_entry_food_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_manufacturer_name_and_food_name, $get_food_description, $get_food_country, $get_food_net_content, $get_food_net_content_measurement, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_fat, $get_food_fat_of_which_saturated_fatty_acids, $get_food_carbohydrates, $get_food_carbohydrates_of_which_dietary_fiber, $get_food_carbohydrates_of_which_sugars, $get_food_proteins, $get_food_salt, $get_food_sodium, $get_food_score, $get_food_energy_calculated, $get_food_fat_calculated, $get_food_fat_of_which_saturated_fatty_acids_calculated, $get_food_carbohydrates_calculated, $get_food_carbohydrates_of_which_dietary_fiber_calculated, $get_food_carbohydrates_of_which_sugars_calculated, $get_food_proteins_calculated, $get_food_salt_calculated, $get_food_sodium_calculated, $get_food_barcode, $get_food_main_category_id, $get_food_sub_category_id, $get_food_image_path, $get_food_image_a, $get_food_thumb_a_small, $get_food_thumb_a_medium, $get_food_thumb_a_large, $get_food_image_b, $get_food_thumb_b_small, $get_food_thumb_b_medium, $get_food_thumb_b_large, $get_food_image_c, $get_food_thumb_c_small, $get_food_thumb_c_medium, $get_food_thumb_c_large, $get_food_image_d, $get_food_thumb_d_small, $get_food_thumb_d_medium, $get_food_thumb_d_large, $get_food_image_e, $get_food_thumb_e_small, $get_food_thumb_e_medium, $get_food_thumb_e_large, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block, $get_food_user_ip, $get_food_created_date, $get_food_last_viewed, $get_food_age_restriction) = $row;

			if($get_food_id == ""){
				$url = "food_diary_add_food.php?date=$date&meal_id=$meal_id&l=$l";
				$url = $url . "&ft=error&fm=food_not_found";
				header("Location: $url");
				exit;
			}
				
			$inp_entry_food_name = output_html($get_food_name);
			$inp_entry_food_name = str_replace("&amp;amp;", "&amp;", $inp_entry_food_name);
			$len = strlen($inp_entry_food_name);
			if($len > 23){
				$inp_entry_food_name = substr($inp_entry_food_name, 0, 20);
				$inp_entry_food_name = $inp_entry_food_name . "...";
			}
			$inp_entry_food_name_mysql = quote_smart($link, $inp_entry_food_name);

			$inp_entry_food_manufacturer_name = output_html($get_food_manufacturer_name);
			$inp_entry_food_manufacturer_name_mysql = quote_smart($link, $inp_entry_food_manufacturer_name);


			// Gram or pcs?
			if (isset($_POST['inp_submit_gram'])) {
				// Gram
				$inp_entry_food_serving_size_measurement = output_html($get_food_serving_size_gram_measurement);
				$inp_entry_food_serving_size_measurement_mysql = quote_smart($link, $inp_entry_food_serving_size_measurement);

				$inp_entry_food_energy_per_entry = round(($inp_entry_food_serving_size*$get_food_energy)/100, 1);
				$inp_entry_food_energy_per_entry_mysql = quote_smart($link, $inp_entry_food_energy_per_entry);

				$inp_entry_food_fat_per_entry = round(($inp_entry_food_serving_size*$get_food_fat)/100, 1);
				$inp_entry_food_fat_per_entry_mysql = quote_smart($link, $inp_entry_food_fat_per_entry);

				$inp_entry_food_carb_per_entry = round(($inp_entry_food_serving_size*$get_food_carbohydrates)/100, 1);
				$inp_entry_food_carb_per_entry_mysql = quote_smart($link, $inp_entry_food_carb_per_entry);

				$inp_entry_food_protein_per_entry = round(($inp_entry_food_serving_size*$get_food_proteins)/100, 1);
				$inp_entry_food_protein_per_entry_mysql = quote_smart($link, $inp_entry_food_protein_per_entry);

			}
			else{
				// PCS

				$inp_entry_food_serving_size_measurement = output_html($get_food_serving_size_pcs_measurement);
				$inp_entry_food_serving_size_measurement_mysql = quote_smart($link, $inp_entry_food_serving_size_measurement);

				$inp_entry_food_energy_per_entry = round(($inp_entry_food_serving_size*$get_food_energy_calculated)/$get_food_serving_size_pcs, 1);
				$inp_entry_food_energy_per_entry_mysql = quote_smart($link, $inp_entry_food_energy_per_entry);

				$inp_entry_food_fat_per_entry = round(($inp_entry_food_serving_size*$get_food_fat_calculated)/$get_food_serving_size_pcs, 1);
				$inp_entry_food_fat_per_entry_mysql = quote_smart($link, $inp_entry_food_fat_per_entry);

				$inp_entry_food_carb_per_entry = round(($inp_entry_food_serving_size*$get_food_carbohydrates_calculated)/$get_food_serving_size_pcs, 1);
				$inp_entry_food_carb_per_entry_mysql = quote_smart($link, $inp_entry_food_carb_per_entry);

				$inp_entry_food_protein_per_entry = round(($inp_entry_food_serving_size*$get_food_proteins_calculated)/$get_food_serving_size_pcs, 1);
				$inp_entry_food_protein_per_entry_mysql = quote_smart($link, $inp_entry_food_protein_per_entry);
			}

			// Insert
			mysqli_query($link, "INSERT INTO $t_food_diary_entires
			(entry_id, entry_user_id, entry_date, entry_meal_id, entry_food_id, entry_recipe_id, 
			entry_name, entry_manufacturer_name, entry_serving_size, entry_serving_size_measurement, 
			entry_energy_per_entry, entry_fat_per_entry, entry_carb_per_entry, entry_protein_per_entry,
			entry_updated, entry_synchronized) 
			VALUES 
			(NULL, '$get_my_user_id', $inp_entry_date_mysql, $inp_entry_meal_id_mysql, $inp_entry_food_id_mysql, '0',
			$inp_entry_food_name_mysql, $inp_entry_food_manufacturer_name_mysql, $inp_entry_food_serving_size_mysql, $inp_entry_food_serving_size_measurement_mysql, 
			$inp_entry_food_energy_per_entry_mysql, $inp_entry_food_fat_per_entry_mysql, $inp_entry_food_carb_per_entry_mysql, $inp_entry_food_protein_per_entry_mysql,
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

			$inp_total_day_consumed_energy = 0;
			$inp_total_day_consumed_fat = 0;
			$inp_total_day_consumed_carb = 0;
			$inp_total_day_consumed_protein = 0;
			$query = "SELECT total_meal_id, total_meal_energy, total_meal_fat, total_meal_carb, total_meal_protein FROM $t_food_diary_totals_meals WHERE total_meal_user_id=$my_user_id_mysql AND total_meal_date=$inp_entry_date_mysql";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
    				list($get_total_meal_id, $get_total_meal_energy, $get_total_meal_fat, $get_total_meal_carb, $get_total_meal_protein) = $row;

				if($get_total_meal_energy == ""){
					$get_total_meal_energy = 0;
				}
				if($get_total_meal_fat == ""){
					$get_total_meal_fat = 0;
				}
				if($get_total_meal_carb == ""){
					$get_total_meal_carb = 0;
				}
				if($get_total_meal_protein == ""){
					$get_total_meal_protein = 0;
				}
				
				$inp_total_day_consumed_energy = $inp_total_day_consumed_energy+$get_total_meal_energy;
				$inp_total_day_consumed_fat = $inp_total_day_consumed_fat+$get_total_meal_fat;
				$inp_total_day_consumed_carb = $inp_total_day_consumed_carb+$get_total_meal_carb;
				$inp_total_day_consumed_protein = $inp_total_day_consumed_protein+$get_total_meal_protein;
			}



			$inp_total_day_diff_sedentary_energy = $get_total_day_target_sedentary_energy-$inp_total_day_consumed_energy;
			$inp_total_day_diff_sedentary_fat = $get_total_day_target_sedentary_fat-$inp_total_day_consumed_fat;
			$inp_total_day_diff_sedentary_carb = $get_total_day_target_sedentary_carb-$inp_total_day_consumed_carb;
			$inp_total_day_diff_sedentary_protein = $get_total_day_target_sedentary_protein-$inp_total_day_consumed_protein;
	

			$inp_total_day_diff_with_activity_energy = $get_total_day_target_with_activity_energy-$inp_total_day_consumed_energy;
			$inp_total_day_diff_with_activity_fat = $get_total_day_target_with_activity_fat-$inp_total_day_consumed_fat;
			$inp_total_day_diff_with_activity_carb = $get_total_day_target_with_activity_carb-$inp_total_day_consumed_carb;
			$inp_total_day_diff_with_activity_protein = $get_total_day_target_with_activity_protein-$inp_total_day_consumed_protein;

			$result = mysqli_query($link, "UPDATE $t_food_diary_totals_days SET 
			total_day_consumed_energy='$inp_total_day_consumed_energy', total_day_consumed_fat='$inp_total_day_consumed_fat', total_day_consumed_carb='$inp_total_day_consumed_carb', total_day_consumed_protein=$inp_total_day_consumed_protein,
			total_day_diff_sedentary_energy='$inp_total_day_diff_sedentary_energy', total_day_diff_sedentary_fat='$inp_total_day_diff_sedentary_fat', total_day_diff_sedentary_carb='$inp_total_day_diff_sedentary_carb', total_day_diff_sedentary_protein='$inp_total_day_diff_sedentary_protein',
			total_day_diff_with_activity_energy='$inp_total_day_diff_with_activity_energy', total_day_diff_with_activity_fat='$inp_total_day_diff_with_activity_fat', total_day_diff_with_activity_carb='$inp_total_day_diff_with_activity_carb', total_day_diff_with_activity_protein='$inp_total_day_diff_with_activity_protein',
			total_day_updated=$inp_updated_mysql, total_day_synchronized='0'
			 WHERE total_day_user_id=$my_user_id_mysql AND total_day_date=$inp_entry_date_mysql");


			// Insert into last used food
			$day_of_the_week = date("N");

			$query = "SELECT last_used_id, last_used_times FROM $t_food_diary_last_used WHERE last_used_user_id=$my_user_id_mysql AND last_used_day_of_week='$day_of_the_week' AND last_used_meal_id=$inp_entry_meal_id_mysql AND last_used_food_id=$inp_entry_food_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_last_used_id, $get_last_used_times) = $row;
			if($get_last_used_id == ""){
				// First time used this food
				mysqli_query($link, "INSERT INTO $t_food_diary_last_used
				(last_used_id, last_used_user_id, last_used_day_of_week, last_used_meal_id, last_used_food_id, last_used_recipe_id, last_used_serving_size, last_used_times, last_used_date,
				last_used_updated, last_used_synchronized) 
				VALUES 
				(NULL, '$get_my_user_id', '$day_of_the_week', $inp_entry_meal_id_mysql, $inp_entry_food_id_mysql, '0', $inp_entry_food_serving_size_mysql, '1', $inp_entry_date_mysql,
				$inp_updated_mysql, '0')")
				or die(mysqli_error($link));
			}
			else{
				// Update counter and date
				$inp_last_used_times = $get_last_used_times + 1;

				$result = mysqli_query($link, "UPDATE $t_food_diary_last_used SET 
				last_used_times='$inp_last_used_times', last_serving_size=$inp_entry_food_serving_size_mysql, last_used_date=$inp_entry_date_mysql,
				last_used_updated=$inp_updated_mysql, last_used_synchronized='0'
				 WHERE last_used_id='$get_last_used_id'");

			}


			$url = "index.php?action=food_diary&date=$date";
			$url = $url . "&ft=success&fm=food_added#meal_id$meal_id";
			header("Location: $url");
			exit;
		}


	} // add_food_to_diary
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