<?php
/**
*
* File: _admin/_inc/stram/food.php
* Version 23:07 09.07.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}
/*- Tables ---------------------------------------------------------------------------- */
$t_food_categories		  = $mysqlPrefixSav . "food_categories";
$t_food_categories_translations	  = $mysqlPrefixSav . "food_categories_translations";
$t_food_index			  = $mysqlPrefixSav . "food_index";
$t_food_index_stores		  = $mysqlPrefixSav . "food_index_stores";
$t_food_index_ads		  = $mysqlPrefixSav . "food_index_ads";
$t_food_index_tags		  = $mysqlPrefixSav . "food_index_tags";
$t_food_index_prices		  = $mysqlPrefixSav . "food_index_prices";
$t_food_index_contents		  = $mysqlPrefixSav . "food_index_contents";
$t_food_stores		  	  = $mysqlPrefixSav . "food_stores";
$t_food_prices_currencies	  = $mysqlPrefixSav . "food_prices_currencies";
$t_food_favorites 		  = $mysqlPrefixSav . "food_favorites";
$t_food_measurements	 	  = $mysqlPrefixSav . "food_measurements";
$t_food_measurements_translations = $mysqlPrefixSav . "food_measurements_translations";



/*- Get extention ---------------------------------------------------------------------- */
function getExtension($str) {
		$i = strrpos($str,".");
		if (!$i) { return ""; } 
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l);
		return $ext;
}

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['language'])){
	$language = $_GET['language'];
	$language = strip_tags(stripslashes($language));
}
else{
	$language = "en";
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


/*- Settings ---------------------------------------------------------------------------- */
$settings_image_width = "847";
$settings_image_height = "847";

if($action == ""){
	echo"
	<h1>Food</h1>


	<!-- Language -->
		<table style=\"width: 100%;\">
		 <tr>
		  <td>
			<p>
			<a href=\"index.php?open=$open&amp;page=food&amp;action=new_food&amp;editor_language=$editor_language\">New food</a>
			</p>
		  </td>
		  <td style=\"text-align: right;\">
			
			<script>
			\$(function(){
			// bind change event to select
			\$('#inp_l').on('change', function () {
				var url = \$(this).val(); // get selected value
				if (url) { // require a URL
 					window.location = url; // redirect
				}
				return false;
			});
			});
			</script>

			<form method=\"get\" enctype=\"multipart/form-data\">
			<p>
			$l_language:
			<select id=\"inp_l\">
				<option value=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">$l_editor_language</option>
				<option value=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">-</option>\n";


				$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;

					$flag_path 	= "_design/gfx/flags/16x16/$get_language_active_flag" . "_16x16.png";
	
					// No language selected?
					if($editor_language == ""){
							$editor_language = "$get_language_active_iso_two";
					}
				
				
					echo"	<option value=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;editor_language=$get_language_active_iso_two&amp;l=$l\" style=\"background: url('$flag_path') no-repeat;padding-left: 20px;\"";if($editor_language == "$get_language_active_iso_two"){ echo" selected=\"selected\"";}echo">$get_language_active_name</option>\n";
				}
			echo"
			</select>
			</p>
			</form>

		  </td>
		 </tr>
		</table>
	<!-- //Language -->


	<!-- Left and right -->
		<div style=\"float: left;\">
			<!-- Main categories -->
				<table class=\"hor-zebra\">
				 <tr>
				  <td class=\"odd\">
						<p>";

					// Get all categories
					$editor_language_mysql = quote_smart($link, $editor_language);
					$query = "SELECT $t_food_categories.category_id, $t_food_categories.category_name, $t_food_categories.category_parent_id FROM $t_food_categories";
					$query = $query . " WHERE category_user_id='0' AND category_parent_id='0' ORDER BY category_name ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_category_id, $get_category_name, $get_category_parent_id) = $row;

						// Translation
						$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_category_id AND category_translation_language=$editor_language_mysql";
						$result_t = mysqli_query($link, $query_t);
						$row_t = mysqli_fetch_row($result_t);
						list($get_category_translation_value) = $row_t;

						echo"
						<a href=\"index.php?open=$open&amp;page=food&amp;action=open_main_category&amp;main_category_id=$get_category_id&amp;editor_language=$editor_language\">$get_category_translation_value</a><br />
						";

					}

					echo"
						</p>
				  </td>
				 </tr>
				</table>
			<!-- //Main categories -->
		</div>
		<div style=\"float: left;padding: 0px 0px 0px 20px;\">

			<!-- Show all food -->


								<table style=\"width: 100%;\">
						";
						// Set layout
						$layout = 0;

						// Get all food
						$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_net_content, food_net_content_measurement, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_carbohydrates_of_which_sugars, food_fat, food_fat_of_which_saturated_fatty_acids, food_salt, food_score, food_energy_calculated, food_proteins_calculated, food_salt_calculated, food_carbohydrates_calculated, food_carbohydrates_of_which_sugars_calculated, food_fat_calculated, food_fat_of_which_saturated_fatty_acids_calculated, food_barcode, food_category_id, food_image_path, food_thumb, food_image_a, food_image_b, food_image_c, food_image_d, food_image_e, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_date, food_time, food_last_viewed FROM $t_food_index WHERE food_language=$editor_language_mysql ORDER BY food_id DESC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_manufacturer_name_and_food_name, $get_food_description, $get_food_net_content, $get_food_net_content_measurement, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_carbohydrates_of_which_sugars, $get_food_fat, $get_food_fat_of_which_saturated_fatty_acids, $get_food_salt, $get_food_score, $get_food_energy_calculated, $get_food_proteins_calculated, $get_food_salt_calculated, $get_food_carbohydrates_calculated, $get_food_carbohydrates_of_which_sugars_calculated, $get_food_fat_calculated, $get_food_fat_of_which_saturated_fatty_acids_calculated, $get_food_barcode, $get_food_category_id, $get_food_image_path, $get_food_thumb, $get_food_image_a, $get_food_image_b, $get_food_image_c, $get_food_image_d, $get_food_image_e, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block, $get_food_user_ip, $get_food_date, $get_food_time, $get_food_last_viewed) = $row;
				
							// Name saying
							$check = strlen($get_food_name);
							if($check > 20){
								$get_food_name = substr($get_food_name, 0, 23);
								$get_food_name = $get_food_name . "...";
							}	



							if($layout == 0){
								echo"
								 <tr>
								  <td style=\"width: 143px;padding: 0px 40px 0px 0px;vertical-align: top;text-align: center;\">
									<p style=\"padding-bottom:0;\">
									<a href=\"index.php?open=$open&amp;page=food&amp;action=view_food&amp;main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$get_food_id&amp;editor_language=$editor_language\"><img src=\"";
									if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a")){
										echo"../image.php?width=132&amp;height=132&amp;image=/$get_food_image_path/$get_food_image_a";
									}
									else{
										echo"_inc/diet/_gfx/no_thumb.png";
									}
									echo"\" alt=\"$get_food_image_a\" style=\"margin-bottom: 5px;\" /></a><br />
					
									<a href=\"index.php?open=$open&amp;page=food&amp;action=view_food&amp;main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$get_food_id&amp;editor_language=$editor_language\">$get_food_manufacturer_name</a><br />
									<a href=\"index.php?open=$open&amp;page=food&amp;action=view_food&amp;main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$get_food_id&amp;editor_language=$editor_language\">$get_food_name</a><br />";
									if($check < 20){	
										echo"<br />";
									}					
									echo"
									</p>

									<div style=\"width: 127px; margin: 0 auto;\">
										<table>
										 <tr>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_energy kcal</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_fat fat</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_carbohydrates carb</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_proteins proteins</span>
										  </td>
										 </tr>
										</table>
									</div>
								  </td>
								";
							}
							elseif($layout == 1){
								echo"
								  <td style=\"width: 143px;padding: 0px 40px 0px 0px;vertical-align: top;text-align: center;\">
									<p style=\"padding-bottom:0;\">
									<a href=\"index.php?open=$open&amp;page=food&amp;action=view_food&amp;main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$get_food_id&amp;editor_language=$editor_language\"><img src=\"";
									if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a")){
										echo"../image.php?width=132&amp;height=132&amp;image=/$get_food_image_path/$get_food_image_a";
									}
									else{
										echo"_inc/diet/_gfx/no_thumb.png";
									}
									echo"\" alt=\"$get_food_image_a\" style=\"margin-bottom: 5px;\" /></a><br />
					
									<a href=\"index.php?open=$open&amp;page=food&amp;action=view_food&amp;main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$get_food_id&amp;editor_language=$editor_language\">$get_food_manufacturer_name</a><br />
									<a href=\"index.php?open=$open&amp;page=food&amp;action=view_food&amp;main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$get_food_id&amp;editor_language=$editor_language\">$get_food_name</a><br />";
									if($check < 20){	
										echo"<br />";
									}					
									echo"
									</p>

									<div style=\"width: 127px; margin: 0 auto;\">
										<table>
										 <tr>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_energy kcal</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_fat fat</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_carbohydrates carb</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_proteins proteins</span>
										  </td>
										 </tr>
										</table>
									</div>
								  </td>
								";
							}
							elseif($layout == 2){
								echo"
								  <td style=\"width: 143px;padding: 0px 0px 0px 0px;vertical-align: top;text-align: center;\">
									<p style=\"padding-bottom:0;\">
									<a href=\"index.php?open=$open&amp;page=food&amp;action=view_food&amp;main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$get_food_id&amp;editor_language=$editor_language\"><img src=\"";
									if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a")){
										echo"../image.php?width=132&amp;height=132&amp;image=/$get_food_image_path/$get_food_image_a";
									}
									else{
										echo"_inc/diet/_gfx/no_thumb.png";
									}
									echo"\" alt=\"$get_food_image_a\" style=\"margin-bottom: 5px;\" /></a><br />
					
									<a href=\"index.php?open=$open&amp;page=food&amp;action=view_food&amp;main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$get_food_id&amp;editor_language=$editor_language\">$get_food_manufacturer_name</a><br />
									<a href=\"index.php?open=$open&amp;page=food&amp;action=view_food&amp;main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$get_food_id&amp;editor_language=$editor_language\">$get_food_name</a><br />";
									if($check < 20){	
										echo"<br />";
									}					
									echo"
									</p>

									<div style=\"width: 127px; margin: 0 auto;\">
										<table>
										 <tr>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_energy kcal</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_fat fat</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_carbohydrates carb</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_proteins proteins</span>
										  </td>
										 </tr>
										</table>
									</div>
								  </td>
								 </tr>
								";
								$layout = -1;
							}
							$layout++;
						} // while

						echo"
						</table>
			<!-- //Show all food -->
		</div>
	<!-- //Left and right -->
	";
}
elseif($action == "open_main_category" && isset($_GET['main_category_id'])){
	
	// Get variables
	$main_category_id = $_GET['main_category_id'];
	$main_category_id = strip_tags(stripslashes($main_category_id));
	$main_category_id_mysql = quote_smart($link, $main_category_id);

	$editor_language_mysql = quote_smart($link, $editor_language);

	// Select category
	$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$main_category_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_main_category_id, $get_current_main_category_user_id, $get_current_main_category_name, $get_current_main_category_parent_id) = $row;

	if($get_current_main_category_id == ""){
		echo"
		<h1>Server error 404</h1>

		<p>Category not found.</p>

		<p><a href=\"index.php?open=$open&amp;page=categories&amp;editor_language=$editor_language\">Categories</a></p>
		";
	}
	else{

		// Translation
		$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_current_main_category_id AND category_translation_language=$editor_language_mysql";
		$result_t = mysqli_query($link, $query_t);
		$row_t = mysqli_fetch_row($result_t);
		list($get_category_translation_value) = $row_t;


		echo"
		<h1>$get_category_translation_value</h1>


		<!-- Language -->
			<table style=\"width: 100%;\">
			 <tr>
			  <td>
				<p>
				<a href=\"index.php?open=$open&amp;page=food&amp;action=new_food&amp;editor_language=$editor_language\">New food</a>
				</p>
			  </td>
			  <td style=\"text-align: right;\">

				<script>
				\$(function(){
				// bind change event to select
				\$('#inp_l').on('change', function () {
					var url = \$(this).val(); // get selected value
					if (url) { // require a URL
 						window.location = url; // redirect
					}
					return false;
				});
				});
				</script>
	
				<form method=\"get\" enctype=\"multipart/form-data\">
				<p>
				$l_language:
				<select id=\"inp_l\">
					<option value=\"index.php?open=$open&amp;page=$page&amp;main_category_id=$main_category_id&amp;editor_language=$editor_language&amp;l=$l\">$l_editor_language</option>
					<option value=\"index.php?open=$open&amp;page=$page&amp;main_category_id=$main_category_id&amp;editor_language=$editor_language&amp;l=$l\">-</option>\n";


					$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;

						$flag_path 	= "_design/gfx/flags/16x16/$get_language_active_flag" . "_16x16.png";
	
						// No language selected?
						if($editor_language == ""){
								$editor_language = "$get_language_active_iso_two";
						}
				
				
						echo"	<option value=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;main_category_id=$main_category_id&amp;editor_language=$get_language_active_iso_two&amp;l=$l\" style=\"background: url('$flag_path') no-repeat;padding-left: 20px;\"";if($editor_language == "$get_language_active_iso_two"){ echo" selected=\"selected\"";}echo">$get_language_active_name</option>\n";
					}
				echo"
				</select>
				</p>
				</form>
			  </td>
			 </tr>
			</table>
		<!-- //Language -->


		<!-- Left and right -->
			<div style=\"float: left;\">
				<!-- Main and sub categories -->
					<table class=\"hor-zebra\">
					 <tr>
					  <td class=\"odd\">
							<p>";

							// Get all categories
							$language_mysql = quote_smart($link, $language);
							$query = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='0' ORDER BY category_name ASC";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_main_category_id, $get_main_category_name, $get_main_category_parent_id) = $row;
				
								// Translation
								$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_main_category_id AND category_translation_language=$editor_language_mysql";
								$result_t = mysqli_query($link, $query_t);
								$row_t = mysqli_fetch_row($result_t);
								list($get_category_translation_value) = $row_t;


								echo"
								<a href=\"index.php?open=$open&amp;page=food&amp;action=open_main_category&amp;main_category_id=$get_main_category_id&amp;editor_language=$editor_language\""; if($get_main_category_id == "$get_current_main_category_id"){ echo" style=\"font-weight: bold;\""; } echo">$get_category_translation_value</a><br />
								";


								// Get sub
								if($get_main_category_id == "$get_current_main_category_id"){
									$queryb = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='$get_main_category_id' ORDER BY category_name ASC";
									$resultb = mysqli_query($link, $queryb);
									while($rowb = mysqli_fetch_row($resultb)) {
										list($get_sub_category_id, $get_sub_category_name, $get_sub_category_parent_id) = $rowb;

										// Translation
										$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_sub_category_id AND category_translation_language=$editor_language_mysql";
										$result_t = mysqli_query($link, $query_t);
										$row_t = mysqli_fetch_row($result_t);
										list($get_category_translation_value) = $row_t;
				
										echo"
										&nbsp; &nbsp; <a href=\"index.php?open=$open&amp;page=food&amp;action=open_sub_category&amp;main_category_id=$get_main_category_id&amp;sub_category_id=$get_sub_category_id&amp;editor_language=$editor_language\">$get_category_translation_value</a><br />
										";
									}

								}

							}

							echo"
					  </td>
					 </tr>
					</table>
				<!-- //Main and sub categories -->
			</div>
			<div style=\"float: left;padding: 0px 0px 0px 20px;\">
				<p>Select a sub category.</p>
			</div>
		<!-- //Left and right -->


		";
	}
} // open main category

elseif($action == "open_sub_category" && isset($_GET['main_category_id']) && isset($_GET['sub_category_id'])){
	
	// Get variables
	$main_category_id = $_GET['main_category_id'];
	$main_category_id = strip_tags(stripslashes($main_category_id));
	$main_category_id_mysql = quote_smart($link, $main_category_id);

	$sub_category_id = $_GET['sub_category_id'];
	$sub_category_id = strip_tags(stripslashes($sub_category_id));
	$sub_category_id_mysql = quote_smart($link, $sub_category_id);

	$editor_language_mysql = quote_smart($link, $editor_language);

	// Select main category
	$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$main_category_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_main_category_id, $get_current_main_category_user_id, $get_current_main_category_name, $get_current_main_category_parent_id) = $row;

	// Select sub category
	$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$sub_category_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_sub_category_id, $get_current_sub_category_user_id, $get_current_sub_category_name, $get_current_sub_category_parent_id) = $row;

	
	if($get_current_main_category_id == ""){
		echo"
		<h1>Server error 404</h1>

		<p>Main category not found.</p>

		<p><a href=\"index.php?open=$open&amp;page=food&amp;editor_language=$editor_language\">Categories</a></p>
		";
	}
	else{

		if($get_current_sub_category_id == ""){
			echo"
			<h1>Server error 404</h1>

			<p>Sub category not found.</p>
	
			<p><a href=\"index.php?open=$open&amp;page=food&amp;editor_language=$editor_language\">Categories</a></p>
			";
		}
		else{
			// Translation
			$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_current_main_category_id AND category_translation_language=$editor_language_mysql";
			$result_t = mysqli_query($link, $query_t);
			$row_t = mysqli_fetch_row($result_t);
			list($get_current_main_category_translation_value) = $row_t;

			$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_current_sub_category_id AND category_translation_language=$editor_language_mysql";
			$result_t = mysqli_query($link, $query_t);
			$row_t = mysqli_fetch_row($result_t);
			list($get_current_sub_category_translation_value) = $row_t;


			echo"
			<h1>$get_current_sub_category_translation_value</h1>


			<!-- Language -->
				<table style=\"width: 100%;\">
				 <tr>
				  <td>
					<p>
					<a href=\"index.php?open=$open&amp;page=food&amp;action=new_food&amp;editor_language=$editor_language\">New food</a>
					</p>
				  </td>
				  <td style=\"text-align: right;\">
					<script>
					\$(function(){
					// bind change event to select
					\$('#inp_l').on('change', function () {
						var url = \$(this).val(); // get selected value
						if (url) { // require a URL
 							window.location = url; // redirect
						}
						return false;
					});
					});
					</script>
	
					<form method=\"get\" enctype=\"multipart/form-data\">
					<p>
					$l_language:
					<select id=\"inp_l\">
						<option value=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">$l_editor_language</option>
						<option value=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">-</option>\n";

	
						$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;

							$flag_path 	= "_design/gfx/flags/16x16/$get_language_active_flag" . "_16x16.png";
	
							// No language selected?
							if($editor_language == ""){
									$editor_language = "$get_language_active_iso_two";
							}
				
				
							echo"	<option value=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;editor_language=$get_language_active_iso_two&amp;l=$l\" style=\"background: url('$flag_path') no-repeat;padding-left: 20px;\"";if($editor_language == "$get_language_active_iso_two"){ echo" selected=\"selected\"";}echo">$get_language_active_name</option>\n";
						}
					echo"
					</select>
					</p>
					</form>
				  </td>
				 </tr>
				</table>
			<!-- //Language -->


			<!-- Left and right -->
				<div style=\"float: left;\">
					<!-- Main and sub categories -->
						<table class=\"hor-zebra\">
						 <tr>
						  <td class=\"odd\">
								<p>";

								// Get all categories
								$language_mysql = quote_smart($link, $language);
								$query = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='0' ORDER BY category_name ASC";
								$result = mysqli_query($link, $query);
								while($row = mysqli_fetch_row($result)) {
									list($get_main_category_id, $get_main_category_name, $get_main_category_parent_id) = $row;
				
									// Translation
									$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_main_category_id AND category_translation_language=$editor_language_mysql";
									$result_t = mysqli_query($link, $query_t);
									$row_t = mysqli_fetch_row($result_t);
									list($get_category_translation_value) = $row_t;

									echo"
									<a href=\"index.php?open=$open&amp;page=food&amp;action=open_main_category&amp;main_category_id=$get_main_category_id&amp;editor_language=$editor_language\""; if($get_main_category_id == "$get_current_main_category_id"){ echo" style=\"font-weight: bold;\""; } echo">$get_category_translation_value</a><br />
									";

									// Get sub
									if($get_main_category_id == "$get_current_main_category_id"){
										$queryb = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='$get_main_category_id' ORDER BY category_name ASC";
										$resultb = mysqli_query($link, $queryb);
										while($rowb = mysqli_fetch_row($resultb)) {
											list($get_sub_category_id, $get_sub_category_name, $get_sub_category_parent_id) = $rowb;
				
											// Translation
											$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_sub_category_id AND category_translation_language=$editor_language_mysql";
											$result_t = mysqli_query($link, $query_t);
											$row_t = mysqli_fetch_row($result_t);
											list($get_category_translation_value) = $row_t;

											echo"
											&nbsp; &nbsp; <a href=\"index.php?open=$open&amp;page=food&amp;action=open_sub_category&amp;main_category_id=$get_main_category_id&amp;sub_category_id=$get_sub_category_id&amp;editor_language=$editor_language\""; if($get_sub_category_id == "$get_current_sub_category_id"){ echo" style=\"font-weight: bold;\""; } echo">$get_category_translation_value</a><br />
											";
										}

									}

								}

								echo"
								</p>
						  </td>
						 </tr>
						</table>
					<!-- //Main and sub categories -->
				</div>
				<div style=\"float: left;padding: 0px 0px 0px 20px;\">

					<!-- Feedback -->
						";
						if(isset($fm)){
							echo"
							<div class=\"$ft\">
								<p>
								";
								if($fm == "food_deleted"){
									echo"Food deleted.<br />\n";
								}
								echo"
								</p>
							</div>";
						}
						echo"
					<!-- //Feedback -->


					<!-- Show food from sub category -->


								<table style=\"width: 100%;\">
						";
						// Set layout
						$layout = 0;

						// Get all food
						$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_net_content, food_net_content_measurement, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_carbohydrates_of_which_sugars, food_fat, food_fat_of_which_saturated_fatty_acids, food_salt, food_score, food_energy_calculated, food_proteins_calculated, food_salt_calculated, food_carbohydrates_calculated, food_carbohydrates_of_which_sugars_calculated, food_fat_calculated, food_fat_of_which_saturated_fatty_acids_calculated, food_barcode, food_category_id, food_image_path, food_thumb, food_image_a, food_image_b, food_image_c, food_image_d, food_image_e, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_date, food_time, food_last_viewed FROM $t_food_index WHERE food_category_id='$get_current_sub_category_id' AND food_language=$editor_language_mysql ORDER BY food_last_used ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_manufacturer_name_and_food_name, $get_food_description, $get_food_net_content, $get_food_net_content_measurement, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_carbohydrates_of_which_sugars, $get_food_fat, $get_food_fat_of_which_saturated_fatty_acids, $get_food_salt, $get_food_score, $get_food_energy_calculated, $get_food_proteins_calculated, $get_food_salt_calculated, $get_food_carbohydrates_calculated, $get_food_carbohydrates_of_which_sugars_calculated, $get_food_fat_calculated, $get_food_fat_of_which_saturated_fatty_acids_calculated, $get_food_barcode, $get_food_category_id, $get_food_image_path, $get_food_thumb, $get_food_image_a, $get_food_image_b, $get_food_image_c, $get_food_image_d, $get_food_image_e, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block, $get_food_user_ip, $get_food_date, $get_food_time, $get_food_last_viewed) = $row;
				
							// Name saying
							$check = strlen($get_food_name);
							if($check > 20){
								$get_food_name = substr($get_food_name, 0, 23);
								$get_food_name = $get_food_name . "...";
							}	



							if($layout == 0){
								echo"
								 <tr>
								  <td style=\"width: 143px;padding: 0px 10px 0px 0px;vertical-align: top;text-align: center;\">
									<p style=\"padding-bottom:0;\">
									<a href=\"index.php?open=$open&amp;page=food&amp;action=view_food&amp;main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$get_food_id&amp;editor_language=$editor_language\"><img src=\"";
									if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a")){
										echo"../image.php?width=132&amp;height=132&amp;image=/$get_food_image_path/$get_food_image_a";
									}
									else{
										echo"_design/gfx/no_thumb.jpg";
									}
									echo"\" alt=\"$get_food_image_a\" style=\"margin-bottom: 5px;\" /></a><br />
					
									<a href=\"index.php?open=$open&amp;page=food&amp;action=view_food&amp;main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$get_food_id&amp;editor_language=$editor_language\">$get_food_manufacturer_name</a><br />
									<a href=\"index.php?open=$open&amp;page=food&amp;action=view_food&amp;main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$get_food_id&amp;editor_language=$editor_language\">$get_food_name</a><br />";
									if($check < 20){	
										echo"<br />";
									}					
									echo"
									</p>

									<div style=\"width: 127px; margin: 0 auto;\">
										<table>
										 <tr>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_energy kcal</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_fat fat</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_carbohydrates carb</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_proteins proteins</span>
										  </td>
										 </tr>
										</table>
									</div>
								  </td>
								";
							}
							elseif($layout == 1){
								echo"
								  <td style=\"width: 143px;padding: 0px 10px 0px 0px;vertical-align: top;text-align: center;\">
									<p style=\"padding-bottom:0;\">
									<a href=\"index.php?open=$open&amp;page=food&amp;action=view_food&amp;main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$get_food_id&amp;editor_language=$editor_language\"><img src=\"";
									if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a")){
										echo"../image.php?width=132&amp;height=132&amp;image=/$get_food_image_path/$get_food_image_a";
									}
									else{
										echo"_design/gfx/no_thumb.jpg";
									}
									echo"\" alt=\"$get_food_image_a\" style=\"margin-bottom: 5px;\" /></a><br />
					
									<a href=\"index.php?open=$open&amp;page=food&amp;action=view_food&amp;main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$get_food_id&amp;editor_language=$editor_language\">$get_food_manufacturer_name</a><br />
									<a href=\"index.php?open=$open&amp;page=food&amp;action=view_food&amp;main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$get_food_id&amp;editor_language=$editor_language\">$get_food_name</a><br />";
									if($check < 20){	
										echo"<br />";
									}					
									echo"
									</p>

									<div style=\"width: 127px; margin: 0 auto;\">
										<table>
										 <tr>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_energy kcal</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_fat fat</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_carbohydrates carb</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_proteins proteins</span>
										  </td>
										 </tr>
										</table>
									</div>
								  </td>
								";
							}
							elseif($layout == 2){
								echo"
								  <td style=\"width: 143px;padding: 0px 10px 0px 0px;vertical-align: top;text-align: center;\">
									<p style=\"padding-bottom:0;\">
									<a href=\"index.php?open=$open&amp;page=food&amp;action=view_food&amp;main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$get_food_id&amp;editor_language=$editor_language\"><img src=\"";
									if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a")){
										echo"../image.php?width=132&amp;height=132&amp;image=/$get_food_image_path/$get_food_image_a";
									}
									else{
										echo"_design/gfx/no_thumb.jpg";
									}
									echo"\" alt=\"$get_food_image_a\" style=\"margin-bottom: 5px;\" /></a><br />
					
									<a href=\"index.php?open=$open&amp;page=food&amp;action=view_food&amp;main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$get_food_id&amp;editor_language=$editor_language\">$get_food_manufacturer_name</a><br />
									<a href=\"index.php?open=$open&amp;page=food&amp;action=view_food&amp;main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$get_food_id&amp;editor_language=$editor_language\">$get_food_name</a><br />";
									if($check < 20){	
										echo"<br />";
									}					
									echo"
									</p>

									<div style=\"width: 127px; margin: 0 auto;\">
										<table>
										 <tr>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_energy kcal</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_fat fat</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_carbohydrates carb</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_proteins proteins</span>
										  </td>
										 </tr>
										</table>
									</div>
								  </td>
								 </tr>
								";
								$layout = -1;
							}
							$layout++;
						} // while

						echo"
						</table>
					<!-- //Show food from sub category -->
				</div>
			<!-- //Left and right -->


			";
		} // sub category found
	} // main category found
} // open sub category
elseif($action == "view_food" OR $action == "edit_food" OR $action == "edit_ads" OR $action == "delete_food" && isset($_GET['food_id'])){
	
	// Get variables
	$food_id = $_GET['food_id'];
	$food_id = strip_tags(stripslashes($food_id));
	$food_id_mysql = quote_smart($link, $food_id);

	$editor_language_mysql = quote_smart($link, $editor_language);

	// Select food
	$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_net_content, food_net_content_measurement, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_carbohydrates_of_which_sugars, food_fat, food_fat_of_which_saturated_fatty_acids, food_salt, food_score, food_energy_calculated, food_proteins_calculated, food_salt_calculated, food_carbohydrates_calculated, food_carbohydrates_of_which_sugars_calculated, food_fat_calculated, food_fat_of_which_saturated_fatty_acids_calculated, food_barcode, food_category_id, food_image_path, food_thumb, food_image_a, food_image_b, food_image_c, food_image_d, food_image_e, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_date, food_time, food_last_viewed FROM $t_food_index WHERE food_id=$food_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_manufacturer_name_and_food_name, $get_food_description, $get_food_net_content, $get_food_net_content_measurement, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_carbohydrates_of_which_sugars, $get_food_fat, $get_food_fat_of_which_saturated_fatty_acids, $get_food_salt, $get_food_score, $get_food_energy_calculated, $get_food_proteins_calculated, $get_food_salt_calculated, $get_food_carbohydrates_calculated, $get_food_carbohydrates_of_which_sugars_calculated, $get_food_fat_calculated, $get_food_fat_of_which_saturated_fatty_acids_calculated, $get_food_barcode, $get_food_category_id, $get_food_image_path, $get_food_thumb, $get_food_image_a, $get_food_image_b, $get_food_image_c, $get_food_image_d, $get_food_image_e, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block, $get_food_user_ip, $get_food_date, $get_food_time, $get_food_last_viewed) = $row;

	if($get_food_id == ""){
		echo"
		<h1>Food not found</h1>

		<p>
		Sorry, the food was not found.
		</p>

		<p>
		<a href=\"index.php?open=$open&amp;page=food\">Back</a>
		</p>
		";
	}
	else{
		// Get sub category
		$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$get_food_category_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_sub_category_id, $get_current_sub_category_user_id, $get_current_sub_category_name, $get_current_sub_category_parent_id) = $row;

		if($get_current_sub_category_id == ""){
			echo"<p><b>Unknown sub category.</b></p>";
			// Find a random category

			$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_parent_id != 0";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_sub_category_id, $get_current_sub_category_user_id, $get_current_sub_category_name, $get_current_sub_category_parent_id) = $row;


			echo"<p><b>Update sub category to $get_current_sub_category_id, $get_current_sub_category_user_id, $get_current_sub_category_name, $get_current_sub_category_parent_id.</b></p>";

			$result = mysqli_query($link, "UPDATE $t_food_index SET food_category_id='$get_current_sub_category_id' WHERE food_id='$get_food_id'") or die(mysqli_error($link));

			echo"<div class=\"info\"><span>L O A D I N G</span></div>
 			<meta http-equiv=\"refresh\" content=\"1;URL='index.php?open=$open&amp;page=food&amp;action=$action&amp;main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;editor_language=$editor_language'\" />
			";

			
		}

		// Get main category
		$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$get_current_sub_category_parent_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_main_category_id, $get_current_main_category_user_id, $get_current_main_category_name, $get_current_main_category_parent_id) = $row;

		if($get_current_main_category_id == ""){
			echo"<p><b>Unknown category.</b></p>";
		}

		// Translation
		$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_current_main_category_id AND category_translation_language=$editor_language_mysql";
		$result_t = mysqli_query($link, $query_t);
		$row_t = mysqli_fetch_row($result_t);
		list($get_current_main_category_translation_value) = $row_t;

		$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_current_sub_category_id AND category_translation_language=$editor_language_mysql";
		$result_t = mysqli_query($link, $query_t);
		$row_t = mysqli_fetch_row($result_t);
		list($get_current_sub_category_translation_value) = $row_t;
		

		if($process != "1"){
			echo"
			<h1>$get_food_manufacturer_name $get_food_name</h1>



			<!-- Left and right -->
			<div style=\"float: left;\">
				<!-- Main and sub categories -->
					<table class=\"hor-zebra\">
					 <tr>
					  <td class=\"odd\">
						<p>";
						// Get all categories
						$language_mysql = quote_smart($link, $language);
						$query = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='0' ORDER BY category_name ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_main_category_id, $get_main_category_name, $get_main_category_parent_id) = $row;
								
							// Translation
							$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_main_category_id AND category_translation_language=$editor_language_mysql";
							$result_t = mysqli_query($link, $query_t);
							$row_t = mysqli_fetch_row($result_t);
							list($get_category_translation_value) = $row_t;
			
							echo"
							<a href=\"index.php?open=$open&amp;page=food&amp;action=open_main_category&amp;main_category_id=$get_main_category_id&amp;editor_language=$editor_language\""; if($get_main_category_id == "$get_current_main_category_id"){ echo" style=\"font-weight: bold;\""; } echo">$get_category_translation_value</a><br />
							";

							// Get sub
							if($get_main_category_id == "$get_current_main_category_id"){
								$queryb = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='$get_main_category_id' ORDER BY category_name ASC";
								$resultb = mysqli_query($link, $queryb);
								while($rowb = mysqli_fetch_row($resultb)) {
									list($get_sub_category_id, $get_sub_category_name, $get_sub_category_parent_id) = $rowb;
			
									// Translation
									$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_sub_category_id AND category_translation_language=$editor_language_mysql";
									$result_t = mysqli_query($link, $query_t);
									$row_t = mysqli_fetch_row($result_t);
									list($get_category_translation_value) = $row_t;

									echo"
									&nbsp; &nbsp; <a href=\"index.php?open=$open&amp;page=food&amp;action=open_sub_category&amp;main_category_id=$get_main_category_id&amp;sub_category_id=$get_sub_category_id&amp;editor_language=$editor_language\""; if($get_sub_category_id == "$get_current_sub_category_id"){ echo" style=\"font-weight: bold;\""; } echo">$get_category_translation_value</a><br />
									";
								}
							}
						}
						echo"
						</p>
					  </td>
					 </tr>
					</table>
				<!-- //Main and sub categories -->
			</div>
			<div style=\"float: left;padding: 0px 0px 0px 20px;\">

				<!-- Right -->
				
					<p>
					<a href=\"index.php?open=$open&amp;page=food&amp;action=open_sub_category&amp;main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;editor_language=$editor_language#food_id$food_id\">$get_current_sub_category_translation_value</a>
					|
					<a href=\"index.php?open=$open&amp;page=food&amp;action=view_food&amp;main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;editor_language=$editor_language\""; if($action == "view_food"){ echo" style=\"font-weight: bold;\""; } echo">View</a>
					|
					<a href=\"index.php?open=$open&amp;page=food&amp;action=edit_food&amp;main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;editor_language=$editor_language\""; if($action == "edit_food"){ echo" style=\"font-weight: bold;\""; } echo">Edit</a>
					|
					<a href=\"index.php?open=$open&amp;page=food&amp;action=edit_ads&amp;main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;editor_language=$editor_language\""; if($action == "edit_ads"){ echo" style=\"font-weight: bold;\""; } echo">Ads</a>
					|
					<a href=\"index.php?open=$open&amp;page=food&amp;action=delete_food&amp;main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;editor_language=$editor_language\""; if($action == "delete_food"){ echo" style=\"font-weight: bold;\""; } echo">Delete</a>
					</p>
			";
			
		} // process
		if($action == "view_food"){
				echo"


					<!-- Images -->
						<p>";

						// Clean name
						if($get_food_clean_name == ""){
							$inp_food_clean_name = clean($get_food_name);
							$inp_food_clean_name_mysql = quote_smart($link, $inp_food_clean_name);
							$result = mysqli_query($link, "UPDATE $t_food_index SET food_clean_name =$inp_food_clean_name_mysql WHERE food_id='$get_food_id'") or die(mysqli_error($link));

							$get_food_clean_name = "$inp_food_clean_name";
						}


						if($get_food_image_path == ""){
							$year = date("Y");

							$inp_food_image_path = "_uploads/food/_img/$editor_language/$year";
							if(!(file_exists("../$inp_food_image_path"))){
								mkdir("../$inp_food_image_path");
							}

							$food_manufacturer_name_clean = clean($get_food_manufacturer_name);
							$store_dir = $food_manufacturer_name_clean . "_" . $get_food_clean_name;
							$inp_food_image_path = "_uploads/food/_img/$editor_language/$year/$store_dir";
							if(!(file_exists("../$inp_food_image_path"))){
								mkdir("../$inp_food_image_path");
							}
							$inp_food_image_path_mysql = quote_smart($link, $inp_food_image_path);
							$result = mysqli_query($link, "UPDATE $t_food_index SET food_image_path=$inp_food_image_path_mysql WHERE food_id='$get_food_id'") or die(mysqli_error($link));

							echo"<p>Created food image path</p>";
						}
						if($get_food_image_a != ""){
							if(file_exists("../$get_food_image_path/$get_food_image_a")){
								echo"<img src=\"../image.php?width=400&amp;height=400&amp;image=/$get_food_image_path/$get_food_image_a\" alt=\"$get_food_image_a\" />";
							}
							
						}
						if($get_food_image_b != ""){

							if(file_exists("../$get_food_image_path/$get_food_image_b")){
								echo"<img src=\"../image.php?width=400&amp;height=400&amp;image=/$get_food_image_path/$get_food_image_b\" alt=\"$get_food_image_b\" />";
							}
						}
						if($get_food_image_c != ""){
							if(file_exists("../$get_food_image_path/$get_food_image_c")){
								echo"<img src=\"../image.php?width=400&amp;height=400&amp;image=/$get_food_image_path//$get_food_image_c\" alt=\"$get_food_image_c\" />";
							}
						}
						if($get_food_image_d != ""){
							if(file_exists("../$get_food_image_path/$get_food_image_d")){
								echo"<img src=\"../image.php?width=400&amp;height=400&amp;image=/$get_food_image_path//$get_food_image_d\" alt=\"$get_food_image_d\" />";
							}
						}
						echo"
						</p>
					<!-- //Images -->
		
					<!-- About -->
						<p>
						$get_food_serving_size_gram $get_food_serving_size_gram_measurement is equivalent with
						$get_food_serving_size_pcs $get_food_serving_size_pcs_measurement. 
						$get_food_description
						</p>
					<!-- //About -->

					<!-- Numbers -->
						<h2>Numbers</h2>

						<table>
						 <tr>
						  <td class=\"outline\">

							<table style=\"width: 100%;border-spacing: 1px;border-collapse: separate;\">
							 <tr>
							  <td class=\"headcell\" style=\"text-align: right;padding: 0px 4px 0px 4px;\">
				
							  </td>
							  <td class=\"headcell\" style=\"padding: 0px 4px 0px 4px;text-align:center;\">
								<p>Energy</p>
							  </td>
							  <td class=\"headcell\" style=\"padding: 0px 4px 0px 4px;text-align:center;\">
								<p>Proteins</p>
							  </td>
							  <td class=\"headcell\" style=\"padding: 0px 4px 0px 4px;text-align:center;\">
								<p>Carbs</p>
							  </td>
							  <td class=\"headcell\" style=\"padding: 0px 4px 0px 4px;text-align:center;\">
								<p>Fat</p>
							  </td>
							 </tr>

							 <tr>
							  <td class=\"bodycell\" style=\"text-align: right;padding: 0px 4px 0px 4px;\">
								<p><b>Per 100:</b></p>
							  </td>
							  <td class=\"bodycell\" style=\"padding: 0px 4px 0px 0px;text-align:center;\">
								<span>$get_food_energy</span>
							  </td>
							  <td class=\"bodycell\" style=\"padding: 0px 4px 0px 0px;text-align:center;\">
								<span>$get_food_proteins</span>
							  </td>
							  <td class=\"bodycell\" style=\"padding: 0px 4px 0px 0px;text-align:center;\">
								<span>$get_food_carbohydrates</span>
				 			 </td>
				 			 <td class=\"bodycell\" style=\"padding: 0px 4px 0px 0px;text-align:center;\">
								<span>$get_food_fat</span>
				 			 </td>
				 			</tr>

							 <tr>
							  <td class=\"subcell\" style=\"text-align: right;padding: 0px 4px 0px 4px;\">
								<p><b>Per serving:</b></p>
							  </td>
							  <td class=\"subcell\" style=\"padding: 0px 4px 0px 0px;text-align:center;\">
								<span>$get_food_energy_calculated</span>
							  </td>
							  <td class=\"subcell\" style=\"padding: 0px 4px 0px 0px;text-align:center;\">
								<span>$get_food_proteins_calculated</span>
							  </td>
							  <td class=\"subcell\" style=\"padding: 0px 4px 0px 0px;text-align:center;\">
								<span>$get_food_carbohydrates_calculated</span>
							  </td>
							  <td class=\"subcell\" style=\"padding: 0px 4px 0px 0px;text-align:center;\">
								<span>$get_food_fat_calculated</span>
							  </td>
							 </tr>
							</table>
						  </td>
						 </tr>
						</table>

						<!-- //Numbers -->
						";
			} // action == "view_food"
			elseif($action == "edit_food" && isset($_GET['food_id'])){
	
				// Get variables
				$food_id = $_GET['food_id'];
				$food_id = strip_tags(stripslashes($food_id));
				$food_id_mysql = quote_smart($link, $food_id);

				$language_mysql = quote_smart($link, $editor_language);

				// Select food
				$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_net_content, food_net_content_measurement, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_carbohydrates_of_which_sugars, food_fat, food_fat_of_which_saturated_fatty_acids, food_salt, food_score, food_energy_calculated, food_proteins_calculated, food_salt_calculated, food_carbohydrates_calculated, food_carbohydrates_of_which_sugars_calculated, food_fat_calculated, food_fat_of_which_saturated_fatty_acids_calculated, food_barcode, food_category_id, food_image_path, food_thumb, food_image_a, food_image_b, food_image_c, food_image_d, food_image_e, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_date, food_time, food_last_viewed FROM $t_food_index WHERE food_id=$food_id_mysql AND food_language=$language_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_manufacturer_name_and_food_name, $get_food_description, $get_food_net_content, $get_food_net_content_measurement, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_carbohydrates_of_which_sugars, $get_food_fat, $get_food_fat_of_which_saturated_fatty_acids, $get_food_salt, $get_food_score, $get_food_energy_calculated, $get_food_proteins_calculated, $get_food_salt_calculated, $get_food_carbohydrates_calculated, $get_food_carbohydrates_of_which_sugars_calculated, $get_food_fat_calculated, $get_food_fat_of_which_saturated_fatty_acids_calculated, $get_food_barcode, $get_food_category_id, $get_food_image_path, $get_food_thumb, $get_food_image_a, $get_food_image_b, $get_food_image_c, $get_food_image_d, $get_food_image_e, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block, $get_food_user_ip, $get_food_date, $get_food_time, $get_food_last_viewed) = $row;

				if($get_food_id == ""){
					echo"
					<h1>Food not found</h1>

					<p>
					Sorry, the food was not found.
					</p>

					<p>
					<a href=\"index.php?open=$open&amp;page=food\">Back</a>
					</p>
					";
				}
				else{
					// Get sub category
					$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$get_food_category_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_current_sub_category_id, $get_current_sub_category_user_id, $get_current_sub_category_name, $get_current_sub_category_parent_id) = $row;

					// Get main category
					$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$get_current_sub_category_parent_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_current_main_category_id, $get_current_main_category_user_id, $get_current_main_category_name, $get_current_main_category_parent_id) = $row;
			
						
					// Process
					if($process == "1"){
						$inp_food_name = $_POST['inp_food_name'];
						$inp_food_name = output_html($inp_food_name);
						$inp_food_name_mysql = quote_smart($link, $inp_food_name);

						$inp_food_name_clean = clean($inp_food_name);
						$inp_food_name_clean = substr($inp_food_name_clean, 0, 30);
						$inp_food_name_clean_mysql = quote_smart($link, $inp_food_name_clean);

						$inp_food_manufacturer_name = $_POST['inp_food_manufacturer_name'];
						$inp_food_manufacturer_name = output_html($inp_food_manufacturer_name);
						$inp_food_manufacturer_name_mysql = quote_smart($link, $inp_food_manufacturer_name);

						$inp_food_description = $_POST['inp_food_description'];
						$inp_food_description = output_html($inp_food_description);
						$inp_food_description_mysql = quote_smart($link, $inp_food_description);

						$inp_food_barcode = $_POST['inp_food_barcode'];
						$inp_food_barcode = output_html($inp_food_barcode);
						$inp_food_barcode_mysql = quote_smart($link, $inp_food_barcode);
	
						// Category
						$inp_food_category_id = $_POST['inp_food_category_id'];
						$inp_food_category_id = output_html($inp_food_category_id);
						$inp_food_category_id_mysql = quote_smart($link, $inp_food_category_id);
						if($inp_food_category_id == ""){
							$fm_category_error = "invalid_category";
						}
						else{
							$result = mysqli_query($link, "UPDATE $t_food_index SET food_category_id=$inp_food_category_id_mysql WHERE food_id='$get_food_id'");
						}

						// Serving
						$inp_food_serving_size_gram = $_POST['inp_food_serving_size_gram'];
						$inp_food_serving_size_gram = output_html($inp_food_serving_size_gram);
						$inp_food_serving_size_gram = str_replace(",", ".", $inp_food_serving_size_gram);
						$inp_food_serving_size_gram_mysql = quote_smart($link, $inp_food_serving_size_gram);

						$inp_food_serving_size_gram_measurement = $_POST['inp_food_serving_size_gram_measurement'];
						$inp_food_serving_size_gram_measurement = output_html($inp_food_serving_size_gram_measurement);
						$inp_food_serving_size_gram_measurement_mysql = quote_smart($link, $inp_food_serving_size_gram_measurement);

						$inp_food_serving_size_pcs = $_POST['inp_food_serving_size_pcs'];
						$inp_food_serving_size_pcs = output_html($inp_food_serving_size_pcs);
						$inp_food_serving_size_pcs = str_replace(",", ".", $inp_food_serving_size_pcs);
						$inp_food_serving_size_pcs_mysql = quote_smart($link, $inp_food_serving_size_pcs);

						$inp_food_serving_size_pcs_measurement = $_POST['inp_food_serving_size_pcs_measurement'];
						$inp_food_serving_size_pcs_measurement = output_html($inp_food_serving_size_pcs_measurement);
						$inp_food_serving_size_pcs_measurement_mysql = quote_smart($link, $inp_food_serving_size_pcs_measurement);

						// per 100 
						$inp_food_energy = $_POST['inp_food_energy'];
						$inp_food_energy = output_html($inp_food_energy);
						$inp_food_energy = str_replace(",", ".", $inp_food_energy);
						$inp_food_energy_mysql = quote_smart($link, $inp_food_energy);

						$inp_food_proteins = $_POST['inp_food_proteins'];
						$inp_food_proteins = output_html($inp_food_proteins);
						$inp_food_proteins = str_replace(",", ".", $inp_food_proteins);
						$inp_food_proteins_mysql = quote_smart($link, $inp_food_proteins);

						$inp_food_carbohydrates = $_POST['inp_food_carbohydrates'];
						$inp_food_carbohydrates = output_html($inp_food_carbohydrates);
						$inp_food_carbohydrates = str_replace(",", ".", $inp_food_carbohydrates);
						$inp_food_carbohydrates_mysql = quote_smart($link, $inp_food_carbohydrates);

						$inp_food_fat = $_POST['inp_food_fat'];
						$inp_food_fat = output_html($inp_food_fat);
						$inp_food_fat = str_replace(",", ".", $inp_food_fat);
						$inp_food_fat_mysql = quote_smart($link, $inp_food_fat);

						// Calculated
						$inp_food_energy_calculated = round($inp_food_energy*$inp_food_serving_size_gram/100, 0);
						$inp_food_proteins_calculated = round($inp_food_proteins*$inp_food_serving_size_gram/100, 0);
						$inp_food_carbohydrates_calculated = round($inp_food_carbohydrates*$inp_food_serving_size_gram/100, 0);
						$inp_food_fat_calculated = round($inp_food_fat*$inp_food_serving_size_gram/100, 0);


						// Update
						$result = mysqli_query($link, "UPDATE $t_food_index SET food_name=$inp_food_name_mysql, food_clean_name=$inp_food_name_clean_mysql, food_manufacturer_name=$inp_food_manufacturer_name_mysql, food_description=$inp_food_description_mysql, food_serving_size_gram=$inp_food_serving_size_gram_mysql, food_serving_size_gram_measurement=$inp_food_serving_size_gram_measurement_mysql, food_serving_size_pcs=$inp_food_serving_size_pcs_mysql, food_serving_size_pcs_measurement=$inp_food_serving_size_pcs_measurement_mysql, food_energy=$inp_food_energy_mysql, food_proteins=$inp_food_proteins_mysql, food_carbohydrates=$inp_food_carbohydrates_mysql, food_fat=$inp_food_fat_mysql, food_energy_calculated='$inp_food_energy_calculated', food_proteins_calculated='$inp_food_proteins_calculated', food_carbohydrates_calculated='$inp_food_carbohydrates_calculated', food_fat_calculated='$inp_food_fat_calculated', food_barcode=$inp_food_barcode_mysql WHERE food_id='$get_food_id'") or die(mysqli_error($link));



						/*- Image A ------------------------------------------------------------------------------------------ */
						$name = stripslashes($_FILES['inp_food_image_a']['name']);
						$extension = getExtension($name);
						$extension = strtolower($extension);

						if($name){

							// Directory for storing
							$year = date("Y");
							$food_manufacturer_name_clean = clean($inp_food_manufacturer_name);
							$store_dir = $food_manufacturer_name_clean . "_" . $inp_food_name_clean;
							$inp_food_image_path = "_uploads/food/_img/$editor_language/$year/$store_dir";
							$inp_food_image_path_mysql = quote_smart($link, $inp_food_image_path);


							if(!(is_dir("../_uploads"))){
								mkdir("../_uploads");
							}
							if(!(is_dir("../_uploads/food"))){
								mkdir("../_uploads/food");
							}
							if(!(is_dir("../_uploads/food/_img"))){
								mkdir("../_uploads/food/_img");
							}
							if(!(is_dir("../_uploads/food/_img/$editor_language"))){
								mkdir("../_uploads/food/_img/$editor_language");
							}
							if(!(is_dir("../_uploads/food/_img/$editor_language/$year"))){
								mkdir("../_uploads/food/_img/$editor_language/$year");
							}
							if(!(is_dir("../_uploads/food/_img/$editor_language/$year/$store_dir"))){
								mkdir("../_uploads/food/_img/$editor_language/$year/$store_dir");
							}
							$result = mysqli_query($link, "UPDATE $t_food_index SET food_image_path=$inp_food_image_path_mysql WHERE food_id='$get_food_id'");

							$get_food_image_path = "$inp_food_image_path";
	


							if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
								$ft_image_a = "warning";
								$fm_image_a = "unknown_file_extension";
							}
							else{
 
								// Give new name
								$food_manufacturer_name_clean = clean($get_food_manufacturer_name);
								$new_name = $food_manufacturer_name_clean . "_" . $inp_food_name_clean . "_a.png";
								$new_path = "../$get_food_image_path/";
								$uploaded_file = $new_path . $new_name;

								// Upload file
								if (move_uploaded_file($_FILES['inp_food_image_a']['tmp_name'], $uploaded_file)) {


									// Get image size
									$file_size = filesize($uploaded_file);
						
 
									// Check with and height
									list($width,$height) = getimagesize($uploaded_file);
	
									if($width == "" OR $height == ""){
										$ft_image_a = "warning";
										$fm_image_a = "getimagesize_failed";
									}
									else{

										// Orientation
										if ($width > $height) {
											// Landscape
										} else {
											// Portrait or Square
										}


									// Resize to 700x742
									$newwidth=$settings_image_width;
									$newheight=($height/$width)*$newwidth;
									$tmp=imagecreatetruecolor($newwidth,$newheight);
						
									if($extension=="jpg" || $extension=="jpeg" ){
										$src = imagecreatefromjpeg($uploaded_file);
									}
									elseif($extension=="png"){
										$src = imagecreatefrompng($uploaded_file);
									}
									else{
										$src = imagecreatefromgif($uploaded_file);
									}
	
									imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
									imagepng($tmp,$uploaded_file);
									imagedestroy($tmp);
						

									// Make thumb 132x140
									$thumb_name = $food_manufacturer_name_clean . "_" . $inp_food_name_clean . "_thumb.png";
									$thumb_file = $new_path . $thumb_name;

									$thumb_with = 132;
									$thumb_height = ($height/$width)*$thumb_with;
									$tmp=imagecreatetruecolor($thumb_with,$thumb_height);


									imagecopyresampled($tmp,$src,0,0,0,0,$thumb_with,$thumb_height, $width,$height);

									imagepng($tmp,$thumb_file);
				
									imagedestroy($tmp);
							

									// Update MySQL
									$inp_food_thumb_mysql = quote_smart($link, $thumb_name);
									$inp_food_image_a_mysql = quote_smart($link, $new_name);
									$result = mysqli_query($link, "UPDATE $t_food_index SET food_thumb=$inp_food_thumb_mysql, food_image_a=$inp_food_image_a_mysql WHERE food_id='$get_food_id'");


								}  // if($width == "" OR $height == ""){
							} // move_uploaded_file
							else{
								switch ($_FILES['inp_food_image_a']['error']) {
									case UPLOAD_ERR_OK:
           									$fm_image_a = "image_to_big";
										break;
									case UPLOAD_ERR_NO_FILE:
           									// $fm_image_a = "no_file_uploaded";
										break;
									case UPLOAD_ERR_INI_SIZE:
           									$fm_image_a = "to_big_size_in_configuration";
										break;
									case UPLOAD_ERR_FORM_SIZE:
           									$fm_image_a = "to_big_size_in_form";
										break;
									default:
           									$fm_image_a = "unknown_error";
										break;

								}	
							}
	
						} // extension check
					} // if($image){


					/*- Image B ------------------------------------------------------------------------------------------ */
					// $tmp_name = $_FILES['inp_food_image_b']['tmp_name'];
					$name = stripslashes($_FILES['inp_food_image_b']['name']);
					$extension = getExtension($name);
					$extension = strtolower($extension);

					if($name){
						if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
							$ft_image_a = "warning";
							$fm_image_a = "unknown_file_extension";
						}
						else{
 
							// Give new name
							$food_manufacturer_name_clean = clean($get_food_manufacturer_name);
							$new_name = $food_manufacturer_name_clean . "_" . $inp_food_name_clean . "_b.png";
							$new_path = "../$get_food_image_path/";
							$uploaded_file = $new_path . $new_name;

							// Upload file
							if (move_uploaded_file($_FILES['inp_food_image_b']['tmp_name'], $uploaded_file)) {


								// Get image size
								$file_size = filesize($uploaded_file);
 
								// Check with and height
								list($width,$height) = getimagesize($uploaded_file);
	
								if($width == "" OR $height == ""){
									$ft_image_b = "warning";
									$fm_image_b = "getimagesize_failed";
								}
								else{

									// Orientation
									if ($width > $height) {
										// Landscape
									} else {
										// Portrait or Square
									}


									// Resize to $settings_image_width
									$newwidth=$settings_image_width;
									$newheight=($height/$width)*$newwidth;
									$tmp=imagecreatetruecolor($newwidth,$newheight);
								
									if($extension=="jpg" || $extension=="jpeg" ){
										$src = imagecreatefromjpeg($uploaded_file);
									}
									else if($extension=="png"){
										$src = imagecreatefrompng($uploaded_file);
									}
									else{
										$src = imagecreatefromgif($uploaded_file);
									}

									imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
	
									imagepng($tmp,$uploaded_file);

									imagedestroy($tmp);
							
									// Update MySQL
									$inp_food_image_b_mysql = quote_smart($link, $new_name);
									$result = mysqli_query($link, "UPDATE $t_food_index SET food_image_b=$inp_food_image_b_mysql WHERE food_id='$get_food_id'");


								}  // if($width == "" OR $height == ""){
							} // move_uploaded_file
							else{
								switch ($_FILES['inp_food_image_b']['error']) {
									case UPLOAD_ERR_OK:
           									$fm_image_b = "image_to_big";
										break;
									case UPLOAD_ERR_NO_FILE:
           									// $fm_image_b = "no_file_uploaded";
										break;
									case UPLOAD_ERR_INI_SIZE:
           									$fm_image_b = "to_big_size_in_configuration";
										break;
									case UPLOAD_ERR_FORM_SIZE:
           									$fm_image_b = "to_big_size_in_form";
										break;
									default:
           									$fm_image_b = "unknown_error";
										break;

								}	
							}
						} // extension check
					} // if($image){
			

					/*- Image C ------------------------------------------------------------------------------------------ */
					// $tmp_name = $_FILES['inp_food_image_c']['tmp_name'];
					$name = stripslashes($_FILES['inp_food_image_c']['name']);
					$extension = getExtension($name);
					$extension = strtolower($extension);

					if($name){
						if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
							$ft_image_c = "warning";
							$fm_image_c = "unknown_file_extension";
						}
						else{
 
							// Give new name
							$food_manufacturer_name_clean = clean($get_food_manufacturer_name);
							$new_name = $food_manufacturer_name_clean . "_" . $inp_food_name_clean . "_c.png";
							$new_path = "../$get_food_image_path/";
							$uploaded_file = $new_path . $new_name;

							// Upload file
							if (move_uploaded_file($_FILES['inp_food_image_c']['tmp_name'], $uploaded_file)) {


								// Get image size
								$file_size = filesize($uploaded_file);
 
								// Check with and height
								list($width,$height) = getimagesize($uploaded_file);
	
								if($width == "" OR $height == ""){
									$ft_image_c = "warning";
									$fm_image_c = "getimagesize_failed";
								}
								else{

									// Orientation
									if ($width > $height) {
										// Landscape
									} else {
										// Portrait or Square
									}


									// Resize to 700x
									$newwidth=$settings_image_width;
									$newheight=($height/$width)*$newwidth;
									$tmp=imagecreatetruecolor($newwidth,$newheight);
						
									if($extension=="jpg" || $extension=="jpeg" ){
										$src = imagecreatefromjpeg($uploaded_file);
									}
									else if($extension=="png"){
										$src = imagecreatefrompng($uploaded_file);
									}
									else{
										$src = imagecreatefromgif($uploaded_file);
									}

									imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
	
									imagepng($tmp,$uploaded_file);

									imagedestroy($tmp);
						
									// Update MySQL
									$inp_food_image_c_mysql = quote_smart($link, $new_name);
									$result = mysqli_query($link, "UPDATE $t_food_index SET food_image_c=$inp_food_image_c_mysql WHERE food_id='$get_food_id'");


								}  // if($width == "" OR $height == ""){
							} // move_uploaded_file
							else{
								switch ($_FILES['inp_food_image_c']['error']) {
									case UPLOAD_ERR_OK:
           									$fm_image_c = "image_to_big";
										break;
									case UPLOAD_ERR_NO_FILE:
           									// $fm_image_c = "no_file_uploaded";
										break;
									case UPLOAD_ERR_INI_SIZE:
           									$fm_image_c = "to_big_size_in_configuration";
										break;
									case UPLOAD_ERR_FORM_SIZE:
           									$fm_image_c = "to_big_size_in_form";
										break;
									default:
           									$fm_image_c = "unknown_error";
										break;

								}	
							}
						} // extension check
					} // if($image){


					// Feedback
					$url = "index.php?open=$open&page=food&action=edit_food&main_category_id=$get_current_main_category_id&sub_category_id=$get_current_sub_category_id&food_id=$food_id&editor_language=$editor_language&ft=success&fm=changes_saved";
			
					if(isset($fm_category_error)){
						$url = $url . "&ft_category_error=$ft_category_error&fm_category_error=$fm_category_error";
					}

					if(isset($fm_image_a)){
						$url = $url . "&ft_image_a=$ft_image_a&fm_image_a=$fm_image_a";
					}
					if(isset($fm_image_b)){
						$url = $url . "&ft_image_b=$ft_image_a&fm_image_b=$fm_image_c";
					}
					if(isset($fm_image_c)){
						$url = $url . "&ft_image_c=$ft_image_a&fm_image_c=$fm_image_c";
					}

					header("Location: $url");
					exit;

				}

				echo"
		
				<!-- Feedback -->
								";
								if(isset($fm)){
									echo"
									<div class=\"info\">
										<p>
										";
										if($fm == "changes_saved"){
											echo"Changes saved<br />\n";
										}
										if(isset($_GET['fm_image_a'])){
											$fm_image_a = $_GET['fm_image_a'];

											if($fm_image_a == "unknown_file_extension"){
												echo"Image 1: Unknown file extension<br />\n";
											}
											elseif($fm_image_a == "getimagesize_failed"){
												echo"Image 1: Could not get with and height of image<br />\n";
											}
											elseif($fm_image_a == "image_to_big"){
							echo"Image 1: Image file size to big<br />\n";
						}
						elseif($fm_image_a == "to_big_size_in_configuration"){
							echo"Image 1: Image file size to big (in config)<br />\n";
						}
						elseif($fm_image_a == "to_big_size_in_form"){
							echo"Image 1: Image file size to big (in form)<br />\n";
						}
						elseif($fm_image_a == "unknown_error"){
							echo"Image 1: Unknown error<br />\n";
						}

					}
					if(isset($_GET['fm_image_b'])){
						$fm_image_b = $_GET['fm_image_b'];

						if($fm_image_b == "unknown_file_extension"){
							echo"Image 2: Unknown file extension<br />\n";
						}
						elseif($fm_image_b == "getimagesize_failed"){
							echo"Image 2: Could not get with and height of image<br />\n";
						}
						elseif($fm_image_b == "image_to_big"){
							echo"Image 2: Image file size to big<br />\n";
						}
						elseif($fm_image_b == "to_big_size_in_configuration"){
							echo"Image 2: Image file size to big (in config)<br />\n";
						}
						elseif($fm_image_b == "to_big_size_in_form"){
							echo"Image 2: Image file size to big (in form)<br />\n";
						}
						elseif($fm_image_b == "unknown_error"){
							echo"Image 2: Unknown error<br />\n";
						}

					}
					if(isset($_GET['fm_image_c'])){
						$fm_image_c = $_GET['fm_image_c'];

						if($fm_image_c == "unknown_file_extension"){
							echo"Image 3: Unknown file extension<br />\n";
						}
						elseif($fm_image_c == "getimagesize_failed"){
							echo"Image 3: Could not get with and height of image<br />\n";
						}
						elseif($fm_image_c == "image_to_big"){
							echo"Image 3: Image file size to big<br />\n";
						}
						elseif($fm_image_c == "to_big_size_in_configuration"){
							echo"Image 3: Image file size to big (in config)<br />\n";
						}
						elseif($fm_image_c == "to_big_size_in_form"){
							echo"Image 3: Image file size to big (in form)<br />\n";
						}
						elseif($fm_image_c == "unknown_error"){
							echo"Image 3: Unknown error<br />\n";
						}

					}
					echo"
					</p>
				</div>";
			}
			echo"
			<!-- //Feedback -->

		
							<!-- Focus -->
							<script>
								\$(document).ready(function(){
									\$('[name=\"inp_food_name\"]').focus();
								});
							</script>
							<!-- //Focus -->

		<form method=\"post\" action=\"index.php?open=$open&amp;page=food&amp;action=edit_food&amp;main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;editor_language=$editor_language&amp;process=1\" enctype=\"multipart/form-data\">

		<h2>General information</h2>
		<table>
		 <tr>
		  <td style=\"text-align: right;padding: 0px 4px 0px 0px;vertical-align: top;\">
			<p><b>Name:</b></p>
		  </td>
		  <td>
			<p><input type=\"text\" name=\"inp_food_name\" value=\"$get_food_name\" size=\"40\" /><br />
			<i>Clean: $get_food_clean_name</i></p>
		  </td>
		 </tr>
		 <tr>
		  <td style=\"text-align: right;padding: 0px 4px 0px 0px;vertical-align: top;\">
			<p><b>Manufacturer:</b></p>
		  </td>
		  <td>
			<p><input type=\"text\" name=\"inp_food_manufacturer_name\" value=\"$get_food_manufacturer_name\" size=\"40\" /><br />
			"; 
			$food_manufacturer_name_clean = clean($get_food_manufacturer_name);
			$food_manufacturer_name_clean = str_replace('ö"', 'o', $food_manufacturer_name_clean);
			$food_manufacturer_name_clean = str_replace('ll', 'o', $food_manufacturer_name_clean);
			echo"<i>Clean: $food_manufacturer_name_clean</i></p>
		  </td>
		 </tr>
		 <tr>
		  <td style=\"text-align: right;padding: 0px 4px 0px 0px;vertical-align: top;\">
			<p><b>Description:</b></p>
		  </td>
		  <td>
			<p><textarea name=\"inp_food_description\" rows=\"4\" cols=\"50\">";
			$get_food_description = str_replace("<br />", "\n", $get_food_description);

			echo"$get_food_description</textarea></p>
		  </td>
		 </tr>
		 <tr>
		  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
			<p><b>Barcode:</b></p>
		  </td>
		  <td>
			<p><input type=\"text\" name=\"inp_food_barcode\" value=\"$get_food_barcode\" size=\"40\" /></p>
		  </td>
		 </tr>
		 <tr>
		  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
			<p><b>Category:</b></p>
		  </td>
		  <td>
			<p>
			<select name=\"inp_food_category_id\">\n";

			// Get all categories
			$language_mysql = quote_smart($link, $language);
			$query = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='0' ORDER BY category_name ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_main_category_id, $get_main_category_name, $get_main_category_parent_id) = $row;

				// Translation
				$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_main_category_id AND category_translation_language=$editor_language_mysql";
				$result_t = mysqli_query($link, $query_t);
				$row_t = mysqli_fetch_row($result_t);
				list($get_category_translation_value) = $row_t;

				echo"			";
				echo"<option value=\"\">$get_category_translation_value</option>\n";
				
				$queryb = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='$get_main_category_id' ORDER BY category_name ASC";
				$resultb = mysqli_query($link, $queryb);
				while($rowb = mysqli_fetch_row($resultb)) {
					list($get_sub_category_id, $get_sub_category_name, $get_sub_category_parent_id) = $rowb;
				
					// Translation
					$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_sub_category_id AND category_translation_language=$editor_language_mysql";
					$result_t = mysqli_query($link, $query_t);
					$row_t = mysqli_fetch_row($result_t);
					list($get_category_translation_value) = $row_t;

					echo"			";
					echo"<option value=\"$get_sub_category_id\""; if($get_sub_category_id == "$get_current_sub_category_id"){ echo" selected=\"selected\""; } echo">&nbsp; &nbsp; $get_category_translation_value</option>\n";
				}
				echo"			";
				echo"<option value=\"\"> </option>\n";
			}
			echo"

			</select>
			</p>
		  </td>
		 </tr>
		 <tr>
		  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
			<p><b>Serving:</b></p>
		  </td>
		  <td>
			<p><input type=\"text\" name=\"inp_food_serving_size_gram\" value=\"$get_food_serving_size_gram\" size=\"3\" />
			<select name=\"inp_food_serving_size_gram_measurement\">
				<option value=\"g\""; if($get_food_serving_size_gram_measurement == "g"){ echo" selected=\"selected\""; } echo">g</option>
				<option value=\"ml\""; if($get_food_serving_size_gram_measurement == "ml"){ echo" selected=\"selected\""; } echo">ml</option>
			</select>
		  </td>
		 </tr>
		 <tr>
		  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
			<p><b>Serving pcs:</b></p>
		  </td>
		  <td>
			<p><input type=\"text\" name=\"inp_food_serving_size_pcs\" value=\"$get_food_serving_size_pcs\" size=\"3\" />
			<select name=\"inp_food_serving_size_pcs_measurement\">\n";

			// Get measurements
			$editor_language_mysql = quote_smart($link, $editor_language);
			$query = "SELECT measurement_id, measurement_name FROM $t_food_measurements ORDER BY measurement_name ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_measurement_id, $get_measurement_name) = $row;


				// Translation
				$query_translation = "SELECT measurement_translation_id, measurement_translation_value FROM $t_food_measurements_translations WHERE measurement_id=$get_measurement_id AND measurement_translation_language=$editor_language_mysql";
				$result_translation = mysqli_query($link, $query_translation);
				$row_translation = mysqli_fetch_row($result_translation);
				list($get_measurement_translation_id, $get_measurement_translation_value) = $row_translation;


				echo"				";
				echo"<option value=\"$get_measurement_translation_value\""; if($get_food_serving_size_pcs_measurement == "$get_measurement_translation_value"){ echo" selected=\"selected\""; } echo">$get_measurement_translation_value</option>\n";
			}
			echo"
			</select>
		  </td>
		 </tr>
		</table>

		<h2>Numbers</h2>
			<table>
			 <tr>
			  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
				
			  </td>
			  <td style=\"padding: 0px 4px 0px 0px;text-align: center;\">
				<p>Energy</p>
			  </td>
			  <td style=\"padding: 0px 4px 0px 0px;text-align: center;\">
				<p>Fat</p>
			  </td>
			  <td style=\"padding: 0px 4px 0px 0px;text-align: center;\">
				<p>Carbs</p>
			  </td>
			  <td style=\"padding: 0px 4px 0px 0px;text-align: center;\">
				<p>Proteins</p>
			  </td>
			 </tr>

			 <tr>
			  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
				<p><b>Per 100:</b></p>
			  </td>
			  <td style=\"padding: 0px 4px 0px 0px;text-align: center;\">
				<span><input type=\"text\" name=\"inp_food_energy\" value=\"$get_food_energy\" size=\"3\" style=\"text-align: center;\" /></span>
			  </td>
			  <td style=\"padding: 0px 4px 0px 0px;text-align: center;\">
				<span><input type=\"text\" name=\"inp_food_fat\" value=\"$get_food_fat\" size=\"3\" style=\"text-align: center;\" /></span>
			  </td>
			  <td style=\"padding: 0px 4px 0px 0px;text-align: center;\">
				<span><input type=\"text\" name=\"inp_food_carbohydrates\" value=\"$get_food_carbohydrates\" size=\"3\" style=\"text-align: center;\" /></span>
			  </td>
			  <td style=\"padding: 0px 4px 0px 0px;text-align: center;\">
				<span><input type=\"text\" name=\"inp_food_proteins\" value=\"$get_food_proteins\" size=\"3\" style=\"text-align: center;\" /></span>
			  </td>
			 </tr>

			 <tr>
			  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
				<p><b>Per serving:</b></p>
			  </td>
			  <td style=\"padding: 0px 4px 0px 0px;text-align: center;\">
				<span>$get_food_energy_calculated</span>
			  </td>
			  <td style=\"padding: 0px 4px 0px 0px;text-align: center;\">
				<span>$get_food_fat_calculated</span>
			  </td>
			  <td style=\"padding: 0px 4px 0px 0px;text-align: center;\">
				<span>$get_food_carbohydrates_calculated</span>
			  </td>
			  <td style=\"padding: 0px 4px 0px 0px;text-align: center;\">
				<span>$get_food_proteins_calculated</span>
			  </td>
			 </tr>
			</table>


		<h2>Images (min height $settings_image_height px. Pefect with is $settings_image_width px)</h2>

			<table>
			 <tr>
			  <td style=\"text-align: right;padding: 0px 4px 0px 0px;vertical-align: top;\">
				<p><b>Product image:</b></p>
			  </td>
			  <td>
				<p>";
				if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a")){
					echo"<img src=\"../image.php?width=200&amp;height=200&amp;image=/$get_food_image_path/$get_food_image_a\" alt=\"$get_food_image_a\" /><br />
					File: <i>$get_food_image_a</i>";
				}
				else{
					echo"";
				}
				echo"
				</p>
			  </td>
			 </tr>
			 <tr>
			  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
				
			  </td>
			  <td>
    				<p>
				<input type=\"file\" name=\"inp_food_image_a\" />
				</p>
			  </td>
			 </tr>
			 <tr>
			  <td style=\"text-align: right;padding: 10px 4px 0px 0px;vertical-align: top;\">
				<p><b>Food table image:</b></p>
			  </td>
			  <td style=\"padding: 10px 0px 0px 0px;\">
				<p>
				";
				if($get_food_image_b != "" && file_exists("../$get_food_image_path/$get_food_image_b")){
					echo"<img src=\"../image.php?width=200&amp;height=200&amp;image=/$get_food_image_path/$get_food_image_b\" alt=\"$get_food_image_b\" /><br />
					File: <i>$get_food_image_b</i>
					";
				}
				echo"</p>
			  </td>
			 </tr>
			 <tr>
			  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
				
			  </td>
			  <td>
    				<p>
				<input type=\"file\" name=\"inp_food_image_b\" />
				</p>
			  </td>
			 </tr>
			 <tr>
			  <td style=\"text-align: right;padding: 10px 4px 0px 0px;vertical-align: top;\">
				<p><b>Inspiration image:</b></p>
			  </td>
			  <td style=\"padding: 10px 0px 0px 0px;\">
				<p>
				";
				if($get_food_image_c != "" && file_exists("../$get_food_image_path/$get_food_image_c")){
					echo"<img src=\"../image.php?width=200&amp;height=200&amp;image=/$get_food_image_path/$get_food_image_c\" alt=\"$get_food_image_c\" /><br />
					File: <i>$get_food_image_c</i>
					";
				}
				echo"</p>
			  </td>
			 </tr>
			 <tr>
			  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
				
			  </td>
			  <td>
    				<p>
				<input type=\"file\" name=\"inp_food_image_c\" />
				</p>
			  </td>
			 </tr>
			</table>
		<p>
		<input type=\"submit\" value=\"Save changes\" class=\"btn btn-success btn-sm\" />
		</p>
		
		</form>
		";

		} // food found
	} // edit_food
	elseif($action == "edit_ads"){

		// Get my user
		$my_user_id = $_SESSION['user_id'];
		$my_user_id = output_html($my_user_id);
		$my_user_id_mysql = quote_smart($link, $my_user_id);
		$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_rank) = $row;

		// Get ad
		$query = "SELECT ad_id, ad_text, ad_url FROM $t_food_index_ads WHERE ad_food_id='$get_food_id'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_ad_id, $get_ad_text, $get_ad_url) = $row;

		if($get_ad_id == ""){	
			$datetime = date("Y-m-d H:i:s");
			$inp_food_language_mysql = quote_smart($link, $get_food_language);
			
			mysqli_query($link, "INSERT INTO $t_food_index_ads
			(ad_id, ad_food_language, ad_food_id, ad_food_created_datetime, ad_food_created_by_user_id, ad_food_unique_clicks) 
			VALUES 
			(NULL, $inp_food_language_mysql, '$get_food_id', '$datetime', '$get_my_user_id', '0')")
			or die(mysqli_error($link));

			// Get id
			$query = "SELECT ad_id FROM $t_food_index_ads WHERE ad_food_id='$get_food_id'";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_ad_id) = $row;
		}
		if($process == "1"){
			$datetime = date("Y-m-d H:i:s");
			$inp_food_language_mysql = quote_smart($link, $get_food_language);

			// URL
			$inp_url = $_POST['inp_url'];
			$inp_url = output_html($inp_url);
			$inp_url = str_replace("&amp;", "&", $inp_url);
			$inp_url_mysql = quote_smart($link, $inp_url);

			// Update the ad
			$result = mysqli_query($link, "UPDATE $t_food_index_ads SET ad_url=$inp_url_mysql, ad_food_updated_datetime='$datetime', ad_food_updated_by_user_id='$get_my_user_id' WHERE ad_id='$get_ad_id'");

			
			// Text	
			$inp_text = $_POST['inp_text'];
			$sql = "UPDATE $t_food_index_ads SET ad_text=? WHERE ad_id='$get_ad_id'";
			$stmt = $link->prepare($sql);
			$stmt->bind_param("s", $inp_text);
			$stmt->execute();
			if ($stmt->errno) {
				echo "FAILURE!!! " . $stmt->error; die;
			}
			
			// Move
			if(empty($inp_url)){
				$url = "index.php?open=food&page=food&action=edit_ads&main_category_id=$main_category_id&sub_category_id=$sub_category_id&food_id=$food_id&editor_language=$editor_language&ft=warning&fm=url_is_empty";
				header("Location: $url");
				exit;
			}
			else{
				$url = "index.php?open=food&page=food&action=edit_ads&main_category_id=$main_category_id&sub_category_id=$sub_category_id&food_id=$food_id&editor_language=$editor_language&ft=success&fm=changes_saved";
				header("Location: $url");
				exit;
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
		<!-- Food ads form -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_text\"]').focus();
			});
			</script>
			
			<form method=\"post\" action=\"index.php?open=$open&amp;page=food&amp;action=$action&amp;main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;editor_language=$editor_language&amp;process=1\" enctype=\"multipart/form-data\">

			<h2>Ads</h2>
		
			<p>Link for this will be 
			<input type=\"text\" value=\"&lt;a href=&quot;view_food_go_a.php?a_id=$get_ad_id&quot; rel=&quot;nofollow&quot;&gt;$get_food_name&lt;/a&gt;\" size=\"60\" style=\"border: 0px solid;border-bottom: 1px dashed;\" />
			</p>

	
			<p><b>HTML:</b><br />
			<textarea name=\"inp_text\" rows=\"18\" cols=\"80\">$get_ad_text</textarea>
			</p>
			<p><b>URL:</b><br />
			<input type=\"text\" name=\"inp_url\" size=\"60\" value=\"$get_ad_url\" />
			</p>

			<p><input type=\"submit\" value=\"Save\" class=\"btn btn_default\" />
			</form>
		<!-- //Food ads form -->
		";
	} // edit_ads
	elseif($action == "delete_food" && isset($_GET['food_id'])){
	
		// Get variables
		$food_id = $_GET['food_id'];
		$food_id = strip_tags(stripslashes($food_id));
		$food_id_mysql = quote_smart($link, $food_id);

		$editor_language_mysql = quote_smart($link, $editor_language);

		// Select food
		$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_net_content, food_net_content_measurement, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_carbohydrates_of_which_sugars, food_fat, food_fat_of_which_saturated_fatty_acids, food_salt, food_score, food_energy_calculated, food_proteins_calculated, food_salt_calculated, food_carbohydrates_calculated, food_carbohydrates_of_which_sugars_calculated, food_fat_calculated, food_fat_of_which_saturated_fatty_acids_calculated, food_barcode, food_category_id, food_image_path, food_thumb, food_image_a, food_image_b, food_image_c, food_image_d, food_image_e, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_date, food_time, food_last_viewed FROM $t_food_index WHERE food_id=$food_id_mysql AND food_language=$editor_language_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_manufacturer_name_and_food_name, $get_food_description, $get_food_net_content, $get_food_net_content_measurement, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_carbohydrates_of_which_sugars, $get_food_fat, $get_food_fat_of_which_saturated_fatty_acids, $get_food_salt, $get_food_score, $get_food_energy_calculated, $get_food_proteins_calculated, $get_food_salt_calculated, $get_food_carbohydrates_calculated, $get_food_carbohydrates_of_which_sugars_calculated, $get_food_fat_calculated, $get_food_fat_of_which_saturated_fatty_acids_calculated, $get_food_barcode, $get_food_category_id, $get_food_image_path, $get_food_thumb, $get_food_image_a, $get_food_image_b, $get_food_image_c, $get_food_image_d, $get_food_image_e, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block, $get_food_user_ip, $get_food_date, $get_food_time, $get_food_last_viewed) = $row;

						if($get_food_id == ""){
							echo"
							<h1>Food not found</h1>

							<p>
							Sorry, the food was not found.
							</p>

							<p>
							<a href=\"index.php?open=$open&amp;page=food\">Back</a>
							</p>
							";
						}
						else{
							// Get sub category
							$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$get_food_category_id";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_current_sub_category_id, $get_current_sub_category_user_id, $get_current_sub_category_name, $get_current_sub_category_parent_id) = $row;

							// Get main category
							$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$get_current_sub_category_parent_id";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_current_main_category_id, $get_current_main_category_user_id, $get_current_main_category_name, $get_current_main_category_parent_id) = $row;
		
							// Process
							if($process == "1"){
			// Delete
			$result = mysqli_query($link, "DELETE FROM $t_food_index WHERE food_id='$get_food_id'");

			// Delete images
			if($get_food_thumb != "" && file_exists("../$get_food_image_path/$get_food_thumb")){
				unlink("../$get_food_image_path/$get_food_thumb");
			}
			if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a")){
				unlink("../$get_food_image_path/$get_food_image_a");
			}
			if($get_food_image_b != "" && file_exists("../$get_food_image_path/$get_food_image_b")){
				unlink("../$get_food_image_path/$get_food_image_b");
			}
			if($get_food_image_c != "" && file_exists("../$get_food_image_path/$get_food_image_c")){
				unlink("../$get_food_image_path/$get_food_image_c");
			}

			// Feedback
			$url = "index.php?open=$open&page=food&action=open_sub_category&main_category_id=$get_current_main_category_id&sub_category_id=$get_current_sub_category_id&editor_language=$editor_language&ft=success&fm=food_deleted#&food_id$food_id";
			

			header("Location: $url");
			exit;

		}

				echo"


				<p>
				Are you sure you want to delete the food?
				</p>
	
				<p>
				<a href=\"index.php?open=$open&amp;page=food&amp;action=open_sub_category&amp;main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;editor_language=$editor_language#food_id$food_id\">Go back</a>
				|
				<a href=\"index.php?open=$open&amp;page=food&amp;action=delete_food&amp;main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;editor_language=$editor_language&amp;process=1\">Delete</a>
				</p>
				";

			} // food found
		}

		echo"

				<!-- //Right -->
			</div>
		";

	} // food found


} // view_food
elseif($action == "new_food"){


	if(isset($_GET['step'])){
		$step = $_GET['step'];
		$step = strip_tags(stripslashes($step));
	}
	else{
		$step = "";
	}


	if($step == ""){
		echo"
		<h1>New food</h1>

		<p>
		Please select a main category.
		</p>


		<h2>Categorization</h2>
			<table>
			 <tr>
			  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
				<p><b>Language:</b></p>
			  </td>
			  <td>
				<script>
				\$(function(){
					\$('#inp_l').on('change', function () {
						var url = \$(this).val(); // get selected value
						if (url) { // require a URL
 							window.location = url; // redirect
						}
						return false;
					});
				});
				</script>
				<p>
				<select id=\"inp_l\">
				<option value=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">$l_editor_language</option>
				<option value=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">-</option>\n";


				$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;

					$flag_path 	= "_design/gfx/flags/16x16/$get_language_active_flag" . "_16x16.png";
	
					// No language selected?
					if($editor_language == ""){
							$editor_language = "$get_language_active_iso_two";
					}
				
				
					echo"	<option value=\"index.php?open=$open&amp;page=food&amp;action=new_food&amp;main_category_id=$get_main_category_id&amp;editor_language=$get_language_active_iso_two&amp;l=$l\" style=\"background: url('$flag_path') no-repeat;padding-left: 20px;\"";if($editor_language == "$get_language_active_iso_two"){ echo" selected=\"selected\"";}echo">$get_language_active_name</option>\n";
				}
				echo"
				</select>
				</p>
			  </td>
			 </tr>
			 <tr>
			  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
				<p><b>$l_category:</b></p>
			  </td>
			  <td>
				<script>
				\$(function(){
					\$('#inp_c').on('change', function () {
						var url = \$(this).val(); // get selected value
						if (url) { // require a URL
 							window.location = url; // redirect
						}
						return false;
					});
				});
				</script>


				<p>
				<select id=\"inp_c\">
				<option value=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;editor_language=$editor_language&amp;l=$l\">- Please select -</option>
				<option value=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;editor_language=$editor_language&amp;l=$l\"> </option>
				";

			// Get all categories
			$editor_language_mysql = quote_smart($link, $editor_language);
			$query = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='0' ORDER BY category_name ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_main_category_id, $get_main_category_name, $get_main_category_parent_id) = $row;
				
				// Translation
				$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_main_category_id AND category_translation_language=$editor_language_mysql";
				$result_t = mysqli_query($link, $query_t);
				$row_t = mysqli_fetch_row($result_t);
				list($get_category_translation_value) = $row_t;

				echo"
				<option value=\"index.php?open=$open&amp;page=food&amp;action=new_food&amp;step=select_sub_category&amp;main_category_id=$get_main_category_id&amp;editor_language=$editor_language\">$get_category_translation_value</option>\n";
				
			}
			echo"
				</select>
				</p>
			  </td>
			 </tr>
			</table>
		<!-- //Main categories -->

		<p>
		<a href=\"index.php?open=$open&amp;page=food&amp;editor_language=$editor_language\"><img src=\"_design/gfx/icons/16x16/go-previous.png\" alt=\"go-previous.png\" /></a>
		<a href=\"index.php?open=$open&amp;page=food&amp;editor_language=$editor_language\">Go back</a>
		</p>

		";
	} // select main category
	elseif($step == "select_sub_category"){
		// Variables
		$language_mysql = quote_smart($link, $language);

		// Find main category
		$main_category_id = $_GET['main_category_id'];
		$main_category_id = strip_tags(stripslashes($main_category_id));
		$main_category_id_mysql = quote_smart($link, $main_category_id);
		$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$main_category_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_main_category_id, $get_current_main_category_user_id, $get_current_main_category_name, $get_current_main_category_parent_id) = $row;
			
		if($get_current_main_category_id == ""){
			echo"<p>Main category not found.</p>";
		}
		else{
			echo"
			<h1>New food</h1>

			<p>
			Please select a sub category.
			</p>


		<h2>Categorization</h2>
			<table>
			 <tr>
			  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
				<p><b>Language:</b></p>
			  </td>
			  <td>
				<script>
				\$(function(){
					\$('#inp_l').on('change', function () {
						var url = \$(this).val(); // get selected value
						if (url) { // require a URL
 							window.location = url; // redirect
						}
						return false;
					});
				});
				</script>
				<p>
				<select id=\"inp_l\">
				<option value=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;editor_language=$editor_language&amp;l=$l\">$l_editor_language</option>
				<option value=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;editor_language=$editor_language&amp;l=$l\">-</option>\n";


				$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;

					$flag_path 	= "_design/gfx/flags/16x16/$get_language_active_flag" . "_16x16.png";
	
					// No language selected?
					if($editor_language == ""){
							$editor_language = "$get_language_active_iso_two";
					}
				
				
					echo"	<option value=\"index.php?open=$open&amp;page=food&amp;action=new_food&amp;main_category_id=$get_main_category_id&amp;editor_language=$get_language_active_iso_two&amp;l=$l\" style=\"background: url('$flag_path') no-repeat;padding-left: 20px;\"";if($editor_language == "$get_language_active_iso_two"){ echo" selected=\"selected\"";}echo">$get_language_active_name</option>\n";
				}
				echo"
				</select>
				</p>
			  </td>
			 </tr>
			 <tr>
			  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
				<p><b>Category:</b></p>
			  </td>
			  <td>
				<script>
				\$(function(){
					\$('#inp_c').on('change', function () {
						var url = \$(this).val(); // get selected value
						if (url) { // require a URL
 							window.location = url; // redirect
						}
						return false;
					});
				});
				</script>


				<p>
				<select id=\"inp_c\">
				<option value=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;main_category_id=$main_category_id&amp;editor_language=$editor_language&amp;l=$l\">- Please select -</option>
				<option value=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;main_category_id=$main_category_id&amp;editor_language=$editor_language&amp;l=$l\"> </option>
				";

			// Get all categories
			$editor_language_mysql = quote_smart($link, $editor_language);
			$query = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='0' ORDER BY category_name ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_main_category_id, $get_main_category_name, $get_main_category_parent_id) = $row;
				
				// Translation
				$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_main_category_id AND category_translation_language=$editor_language_mysql";
				$result_t = mysqli_query($link, $query_t);
				$row_t = mysqli_fetch_row($result_t);
				list($get_category_translation_value) = $row_t;

				echo"
				<option value=\"index.php?open=$open&amp;page=food&amp;action=new_food&amp;step=select_sub_category&amp;main_category_id=$get_main_category_id&amp;editor_language=$editor_language\""; if($get_main_category_id == "$main_category_id"){ echo" selected=\"selected\""; } echo">$get_category_translation_value</option>\n";
				
			}
			echo"
				</select>
				</p>
			  </td>
			 </tr>
			 <tr>
			  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
				<p><b>Sub category:</b></p>
			  </td>
			  <td>
				<script>
				\$(function(){
					\$('#inp_s').on('change', function () {
						var url = \$(this).val(); // get selected value
						if (url) { // require a URL
 							window.location = url; // redirect
						}
						return false;
					});
				});
				</script>


				<p>
				<select id=\"inp_s\">
				<option value=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">- Please select -</option>
				<option value=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\"> </option>

				";

				// Get all categories
			$editor_language_mysql = quote_smart($link, $editor_language);
				$query = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id=$main_category_id_mysql ORDER BY category_name ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_sub_category_id, $get_sub_category_name, $get_sub_category_parent_id) = $row;
				
					// Translation
					$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_sub_category_id AND category_translation_language=$editor_language_mysql";
					$result_t = mysqli_query($link, $query_t);
					$row_t = mysqli_fetch_row($result_t);
					list($get_category_translation_value) = $row_t;

					echo"
					<option value=\"index.php?open=$open&amp;page=food&amp;action=new_food&amp;step=general_information&amp;main_category_id=$main_category_id&amp;sub_category_id=$get_sub_category_id&amp;editor_language=$editor_language\">$get_category_translation_value</option>\n";
					
				}
				echo"
				</select>
				</p>

			  </td>
			 </tr>
			</table>

			<p>
			<a href=\"index.php?open=$open&amp;page=food&amp;editor_language=$editor_language\"><img src=\"_design/gfx/icons/16x16/go-previous.png\" alt=\"go-previous.png\" /></a>
			<a href=\"index.php?open=$open&amp;page=food&amp;editor_language=$editor_language\">Go back</a>
			</p>

			";
		}
	} // select sub category
	elseif($step == "general_information"){
		// Variables
		$editor_language_mysql = quote_smart($link, $editor_language);

		// Find main category
		$main_category_id = $_GET['main_category_id'];
		$main_category_id = strip_tags(stripslashes($main_category_id));
		$main_category_id_mysql = quote_smart($link, $main_category_id);
		$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$main_category_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_main_category_id, $get_current_main_category_user_id, $get_current_main_category_name, $get_current_main_category_parent_id) = $row;

		if($get_current_main_category_id == ""){
			echo"<p>Main category not found.</p>";
		}
		else{

			// Find sub category
			$sub_category_id = $_GET['sub_category_id'];
			$sub_category_id = strip_tags(stripslashes($sub_category_id));
			$sub_category_id_mysql = quote_smart($link, $sub_category_id);
			$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$sub_category_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_sub_category_id, $get_current_sub_category_user_id, $get_current_sub_category_name, $get_current_sub_category_parent_id) = $row;
	
			if($get_current_sub_category_id == ""){
				echo"<p>Sub category not found.</p>";
			}
			else{
				if($process == "1"){
					$inp_food_name = $_POST['inp_food_name'];
					$inp_food_name = output_html($inp_food_name);
					$inp_food_name_mysql = quote_smart($link, $inp_food_name);
					if(empty($inp_food_name)){
						$ft = "error";
						$fm = "missing_name";
					}

					// Clean name
					$inp_food_clean_name = clean($inp_food_name);
					$inp_food_clean_name_mysql = quote_smart($link, $inp_food_clean_name);
					


					$inp_food_manufacturer_name = $_POST['inp_food_manufacturer_name'];
					$inp_food_manufacturer_name = output_html($inp_food_manufacturer_name);
					$inp_food_manufacturer_name_mysql = quote_smart($link, $inp_food_manufacturer_name);

					$inp_food_store = $_POST['inp_food_store'];
					$inp_food_store = output_html($inp_food_store);
					$inp_food_store_mysql = quote_smart($link, $inp_food_store);

					$inp_food_description = $_POST['inp_food_description'];
					$inp_food_description = output_html($inp_food_description);
					$inp_food_description_mysql = quote_smart($link, $inp_food_description);

					$inp_food_barcode = $_POST['inp_food_barcode'];
					$inp_food_barcode = output_html($inp_food_barcode);
					$inp_food_barcode_mysql = quote_smart($link, $inp_food_barcode);
	
					$inp_food_serving_size_gram = $_POST['inp_food_serving_size_gram'];
					$inp_food_serving_size_gram = output_html($inp_food_serving_size_gram);
					$inp_food_serving_size_gram = str_replace(",", ".", $inp_food_serving_size_gram);
					$inp_food_serving_size_gram_mysql = quote_smart($link, $inp_food_serving_size_gram);
					if(empty($inp_food_serving_size_gram)){
						$ft = "error";
						$fm = "missing_serving_size_gram";
					}
					else{
						if(!(is_numeric($inp_food_serving_size_gram))){
							$ft = "error";
							$fm = "food_serving_size_gram_is_not_numeric";
						}
					}

					$inp_food_serving_size_gram_measurement = $_POST['inp_food_serving_size_gram_measurement'];
					$inp_food_serving_size_gram_measurement = output_html($inp_food_serving_size_gram_measurement);
					$inp_food_serving_size_gram_measurement_mysql = quote_smart($link, $inp_food_serving_size_gram_measurement);
					if(empty($inp_food_serving_size_gram_measurement)){
						$ft = "error";
						$fm = "missing_serving_size_gram_measurement";
					}

					$inp_food_serving_size_pcs = $_POST['inp_food_serving_size_pcs'];
					$inp_food_serving_size_pcs = output_html($inp_food_serving_size_pcs);
					$inp_food_serving_size_pcs = str_replace(",", ".", $inp_food_serving_size_pcs);
					$inp_food_serving_size_pcs_mysql = quote_smart($link, $inp_food_serving_size_pcs);
					if(empty($inp_food_serving_size_pcs)){
						$ft = "error";
						$fm = "missing_serving_size_pcs";
					}
					else{
						if(!(is_numeric($inp_food_serving_size_pcs))){
							$ft = "error";
							$fm = "pcs_is_not_numeric";
						}
					}

					$inp_food_serving_size_pcs_measurement = $_POST['inp_food_serving_size_pcs_measurement'];
					$inp_food_serving_size_pcs_measurement = output_html($inp_food_serving_size_pcs_measurement);
					$inp_food_serving_size_pcs_measurement_mysql = quote_smart($link, $inp_food_serving_size_pcs_measurement);
					if(empty($inp_food_serving_size_pcs_measurement)){
						$ft = "error";
						$fm = "missing_serving_size_pcs_measurement";
					}


					// Food path
					$year = date("Y");
					$food_manufacturer_name_clean = clean($inp_food_manufacturer_name);
					$store_dir = $food_manufacturer_name_clean . "_" . $inp_food_clean_name;
					$inp_food_image_path = "_uploads/food/_img/$editor_language/$year/$store_dir";
					$inp_food_image_path_mysql = quote_smart($link, $inp_food_image_path);


					if($ft == ""){
						// Datetime (notes)
						$datetime = date("Y-m-d H:i:s");
						$inp_notes = "Started on $datetime";
						$inp_notes_mysql = quote_smart($link, $inp_notes);
						
						mysqli_query($link, "INSERT INTO $t_food_index
						(food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_store, food_description, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_barcode, food_category_id, food_image_path, food_language, food_notes) 
						VALUES 
						(NULL, '0', $inp_food_name_mysql, $inp_food_clean_name_mysql, $inp_food_manufacturer_name_mysql, $inp_food_store_mysql, $inp_food_description_mysql, $inp_food_serving_size_gram_mysql, $inp_food_serving_size_gram_measurement_mysql, $inp_food_serving_size_pcs_mysql, $inp_food_serving_size_pcs_measurement_mysql, $inp_food_barcode_mysql, '$get_current_sub_category_id', $inp_food_image_path_mysql, $editor_language_mysql, $inp_notes_mysql)")
						or die(mysqli_error($link));

						// Get _id
						$query = "SELECT food_id FROM $t_food_index WHERE food_notes=$inp_notes_mysql";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_food_id) = $row;
	
						// Update food_id
						$result = mysqli_query($link, "UPDATE $t_food_index SET food_id='$get_food_id' WHERE food_id='$get_food_id'");


						$url = "index.php?open=$open&page=food&action=new_food&step=numbers&main_category_id=$main_category_id&sub_category_id=$sub_category_id&food_id=$get_food_id&editor_language=$editor_language";
						header("Location: $url");
						exit;
					}
					else{
						$url = "index.php?open=$open&page=food&action=new_food&step=general_information&main_category_id=$main_category_id&sub_category_id=$sub_category_id&editor_language=$editor_language";
						$url = $url . "&ft=$ft&fm=$fm";
						$url = $url . "&inp_food_name=$inp_food_name";
						$url = $url . "&inp_food_manufacturer_name=$inp_food_manufacturer_name";
						$url = $url . "&inp_food_store=$inp_food_store";
						$url = $url . "&inp_food_description=$inp_food_description";
						$url = $url . "&inp_food_barcode=$inp_food_barcode";
						$url = $url . "&inp_food_serving_size_gram=$inp_food_serving_size_gram";
						$url = $url . "&inp_food_serving_size_gram_measurement=$inp_food_serving_size_gram_measurement";
						$url = $url . "&inp_food_serving_size_pcs=$inp_food_serving_size_pcs";
						$url = $url . "&inp_food_serving_size_pcs_measurement=$inp_food_serving_size_pcs_measurement";

						header("Location: $url");
						exit;
					}
				}			


	
				echo"
				<h1>New food</h1>

				<!-- Feedback -->
					";
					if($ft != "" && $fm != ""){
						if($fm == "missing_name"){
							$fm = "Please enter a name";
						}
						elseif($fm == "missing_serving_size_gram"){
							$fm = "Please enter serving (field 1)";
						}
						elseif($fm == "missing_serving_size_gram_measurement"){
							$fm = "Please enter serving (field 2)";
						}
						elseif($fm == "missing_serving_size_pcs"){
							$fm = "Please enter serving pcs (field 1)";
						}
						elseif($fm == "missing_serving_size_pcs_measurement"){
							$fm = "Please enter serving pcs (field 2)";
						}
						else{
							$fm = ucfirst($fm);
						}
						echo"<div class=\"$ft\"><p>$fm</p></div>";	
					}
					echo"
				<!-- //Feedback -->

				<!-- General information -->
					<!-- Focus -->
					<script>
						\$(document).ready(function(){
							\$('[name=\"inp_food_name\"]').focus();
						});
					</script>
					<!-- //Focus -->

					<form method=\"post\" action=\"index.php?open=$open&amp;page=food&amp;action=new_food&amp;step=general_information&amp;main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;editor_language=$editor_language&amp;process=1\" enctype=\"multipart/form-data\">

					<h2>General information</h2>
					<table>
					 <tr>
					  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
						<p><b>Name:</b></p>
					  </td>
					  <td>
						<p><input type=\"text\" name=\"inp_food_name\" value=\"\" size=\"40\" /></p>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
						<p><b>Manufacturer:</b></p>
					  </td>
					  <td>
						<p><input type=\"text\" name=\"inp_food_manufacturer_name\" value=\"\" size=\"40\" /></p>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
						<p><b>Store:</b></p>
					  </td>
					  <td>
						<p><input type=\"text\" name=\"inp_food_store\" value=\"\" size=\"40\" /></p>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"text-align: right;padding: 0px 4px 0px 0px;vertical-align:top;\">
						<p><b>Description:</b></p>
					  </td>
					  <td>
						<p><textarea name=\"inp_food_description\" rows=\"4\" cols=\"50\"></textarea></p>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
						<p><b>Barcode:</b></p>
					  </td>
					  <td>
						<p><input type=\"text\" name=\"inp_food_barcode\" value=\"\" size=\"40\" /></p>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"text-align: right;padding: 0px 4px 0px 0px;vertical-align:top;\">
						<p><b>Serving:</b></p>
					  </td>
					  <td>
						<p><input type=\"text\" name=\"inp_food_serving_size_gram\" value=\"\" size=\"3\" />
						
						<select name=\"inp_food_serving_size_gram_measurement\">
							<option value=\"g\">g</option>
							<option value=\"ml\">ml</option>
						</select><br />
						<span class=\"smal\">Examples: 72 g, 90 ml</span>
						</p>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"text-align: right;padding: 0px 4px 0px 0px;vertical-align:top;\">
						<p><b>Serving pcs:</b></p> 
					  </td>
					  <td>
						<p><input type=\"text\" name=\"inp_food_serving_size_pcs\" value=\"\" size=\"3\" />
						<select name=\"inp_food_serving_size_pcs_measurement\">\n";

						// Get measurements
						$editor_language_mysql = quote_smart($link, $editor_language);
						$query = "SELECT measurement_id, measurement_name FROM $t_food_measurements ORDER BY measurement_name ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_measurement_id, $get_measurement_name) = $row;


							// Translation
							$query_translation = "SELECT measurement_translation_id, measurement_translation_value FROM $t_food_measurements_translations WHERE measurement_id=$get_measurement_id AND measurement_translation_language=$editor_language_mysql";
							$result_translation = mysqli_query($link, $query_translation);
							$row_translation = mysqli_fetch_row($result_translation);
							list($get_measurement_translation_id, $get_measurement_translation_value) = $row_translation;


							echo"				";
							echo"<option value=\"$get_measurement_translation_value\">$get_measurement_translation_value</option>\n";
						}
						echo"
						</select><br />
						<span class=\"smal\">Examples: 1 package, 1 slice, 1 pcs, 1 plate</span>
						</p>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
						
					  </td>
					  <td>
						<p><input type=\"submit\" value=\"Save\" class=\"btn btn-success btn-sm\" /></p>
					  </td>
					 </tr>
					</table>
				<!-- //General information -->


				<p>
				<a href=\"index.php?open=$open&amp;page=food&amp;editor_language=$editor_language\"><img src=\"_design/gfx/icons/16x16/go-previous.png\" alt=\"go-previous.png\" /></a>
				<a href=\"index.php?open=$open&amp;page=food&amp;editor_language=$editor_language\">Go back</a>
				</p>
				";
			} // sub category found
		} // main category found
	} // general information
	elseif($step == "numbers"){
		// Variables
		$editor_language_mysql = quote_smart($link, $editor_language);
		
		$food_id = $_GET['food_id'];
		$food_id = strip_tags(stripslashes($food_id));
		$food_id_mysql = quote_smart($link, $food_id);

		// Find food
		$query = "SELECT food_id, food_user_id, food_name, food_manufacturer_name, food_store, food_description, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_fat, food_energy_calculated, food_proteins_calculated, food_carbohydrates_calculated, food_fat_calculated, food_barcode, food_category_id, food_thumb, food_image_a, food_image_b, food_image_c, food_last_used, food_language, food_synchronized, food_notes FROM $t_food_index WHERE food_id=$food_id_mysql AND food_language=$editor_language_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_food_id, $get_food_user_id, $get_food_name, $get_food_manufacturer_name, $get_food_store, $get_food_description, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_fat, $get_food_energy_calculated, $get_food_proteins_calculated, $get_food_carbohydrates_calculated, $get_food_fat_calculated, $get_food_barcode, $get_food_category_id, $get_food_thumb, $get_food_image_a, $get_food_image_b, $get_food_image_c, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_notes) = $row;

		if($get_food_id == ""){
			echo"
			<h1>Food not found</h1>

			<p>
			Sorry, the food was not found.
			</p>

			<p>
			<a href=\"index.php?open=$open&amp;page=food\">Back</a>
			</p>
			";
		}
		else{
			// Get sub category
			$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$get_food_category_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_sub_category_id, $get_current_sub_category_user_id, $get_current_sub_category_name, $get_current_sub_category_parent_id) = $row;

			// Get main category
			$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$get_current_sub_category_parent_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_main_category_id, $get_current_main_category_user_id, $get_current_main_category_name, $get_current_main_category_parent_id) = $row;

			// Process
			if($process == "1"){
				// per 100 
				$inp_food_energy = $_POST['inp_food_energy'];
				$inp_food_energy = output_html($inp_food_energy);
				$inp_food_energy = str_replace(",", ".", $inp_food_energy);
				$inp_food_energy_mysql = quote_smart($link, $inp_food_energy);
				if($inp_food_energy == ""){
					$ft = "error";
					$fm = "mising_energy";
				}

				$inp_food_proteins = $_POST['inp_food_proteins'];
				$inp_food_proteins = output_html($inp_food_proteins);
				$inp_food_proteins = str_replace(",", ".", $inp_food_proteins);
				$inp_food_proteins_mysql = quote_smart($link, $inp_food_proteins);
				if($inp_food_proteins == ""){
					$ft = "error";
					$fm = "mising_proteins";
				}

	
				$inp_food_carbohydrates = $_POST['inp_food_carbohydrates'];
				$inp_food_carbohydrates = output_html($inp_food_carbohydrates);
				$inp_food_carbohydrates = str_replace(",", ".", $inp_food_carbohydrates);
				$inp_food_carbohydrates_mysql = quote_smart($link, $inp_food_carbohydrates);
				if($inp_food_carbohydrates == ""){
					$ft = "error";
					$fm = "mising_carbohydrates";
				}


				$inp_food_fat = $_POST['inp_food_fat'];
				$inp_food_fat = output_html($inp_food_fat);
				$inp_food_fat = str_replace(",", ".", $inp_food_fat);
				$inp_food_fat_mysql = quote_smart($link, $inp_food_fat);
				if($inp_food_fat == ""){
					$ft = "error";
					$fm = "mising_fat";
				}


				// Calculated
				$inp_food_energy_calculated = round($inp_food_energy*$get_food_serving_size_gram/100, 0);
				$inp_food_proteins_calculated = round($inp_food_proteins*$get_food_serving_size_gram/100, 0);
				$inp_food_carbohydrates_calculated = round($inp_food_carbohydrates*$get_food_serving_size_gram/100, 0);
				$inp_food_fat_calculated = round($inp_food_fat*$get_food_serving_size_gram/100, 0);
		

				if($ft == ""){	
					// Update
					$result = mysqli_query($link, "UPDATE $t_food_index SET food_energy=$inp_food_energy_mysql, food_proteins=$inp_food_proteins_mysql, food_carbohydrates=$inp_food_carbohydrates_mysql, food_fat=$inp_food_fat_mysql, food_energy_calculated='$inp_food_energy_calculated', food_proteins_calculated='$inp_food_proteins_calculated', food_carbohydrates_calculated='$inp_food_carbohydrates_calculated', food_fat_calculated='$inp_food_fat_calculated' WHERE food_id='$get_food_id'");

					$url = "index.php?open=$open&page=food&action=new_food&step=images&main_category_id=$main_category_id&sub_category_id=$sub_category_id&food_id=$get_food_id&editor_language=$editor_language";
					header("Location: $url");
					exit;
				}
				else{
					$url = "index.php?open=$open&page=food&action=new_food&step=numbers&main_category_id=$main_category_id&sub_category_id=$sub_category_id&food_id=$get_food_id&editor_language=$editor_language";
					$url = $url . "&ft=$ft&fm=$fm";
					$url = $url . "&inp_food_energy=$inp_food_energy";
					$url = $url . "&inp_food_proteins=$inp_food_proteins";
					$url = $url . "&inp_food_carbohydrates=$inp_food_carbohydrates";
					$url = $url . "&inp_food_fat=$inp_food_fat";

					header("Location: $url");
					exit;
				}
			}


			echo"
			<h1>New food</h1>

			<!-- Feedback -->
				";
				if($ft != "" && $fm != ""){
					if($fm == "missing_energy"){
						$fm = "Please enter energy";
					}
					elseif($fm == "missing_proteins"){
						$fm = "Please enter proteins";
					}
					elseif($fm == "missing_carbohydrates"){
						$fm = "Please enter carbohydrates";
					}
					elseif($fm == "missing_fat"){
						$fm = "Please enter fat";
					}
					else{
						$fm = ucfirst($fm);
					}
					echo"<div class=\"$ft\"><p>$fm</p></div>";	
				}
				echo"
			<!-- //Feedback -->

			<!-- Numbers -->
				<!-- Focus -->
				<script>
					\$(document).ready(function(){
						\$('[name=\"inp_food_energy\"]').focus();
					});
				</script>
				<!-- //Focus -->

				<form method=\"post\" action=\"index.php?open=$open&amp;page=food&amp;action=new_food&amp;step=numbers&amp;main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;editor_language=$editor_language&amp;process=1\" enctype=\"multipart/form-data\">
				<h2>Numbers</h2>

				<table>
				 <tr>
				  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
					<p>Kcal pr 100:</p>
				  </td>
				  <td>
					<p><input type=\"text\" name=\"inp_food_energy\" value=\"$get_food_energy\" size=\"3\" /></p>
				  </td>
				 </tr>
				 <tr>
				  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
					<p>Fat pr 100:</p>
				  </td>
				  <td>
					<p><input type=\"text\" name=\"inp_food_fat\" value=\"$get_food_fat\" size=\"3\" /></p>
				  </td>
				 </tr>
				 <tr>
				  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
					<p>Carbs pr 100:</p>
				  </td>
				  <td>
					<p><input type=\"text\" name=\"inp_food_carbohydrates\" value=\"$get_food_carbohydrates\" size=\"3\" /></p>
				  </td>
				 </tr>
				 <tr>
				  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
					<p>Proteins pr 100:</p>
				  </td>
				  <td>
					<p><input type=\"text\" name=\"inp_food_proteins\" value=\"$get_food_proteins\" size=\"3\" /></p>
				  </td>
				 </tr>
				 <tr>
				  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
					
				  </td>
				  <td>
					<p><input type=\"submit\" value=\"Save\" class=\"btn btn-success btn-sm\" /></p>
				  </td>
				 </tr>
				</table>
			<!-- //Numbers -->


			<p>
			<a href=\"index.php?open=$open&amp;page=food&amp;editor_language=$editor_language\"><img src=\"_design/gfx/icons/16x16/go-previous.png\" alt=\"go-previous.png\" /></a>
			<a href=\"index.php?open=$open&amp;page=food&amp;editor_language=$editor_language\">Go back</a>
			</p>
			";

		}
	} // numbers
	elseif($step == "images"){
		// Variables
		$editor_language_mysql = quote_smart($link, $editor_language);
		
		$food_id = $_GET['food_id'];
		$food_id = strip_tags(stripslashes($food_id));
		$food_id_mysql = quote_smart($link, $food_id);

		// Find food
		$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_store, food_description, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_fat, food_energy_calculated, food_proteins_calculated, food_carbohydrates_calculated, food_fat_calculated, food_barcode, food_category_id, food_thumb, food_image_a, food_image_b, food_image_c, food_last_used, food_language, food_synchronized, food_notes FROM $t_food_index WHERE food_id=$food_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_store, $get_food_description, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_fat, $get_food_energy_calculated, $get_food_proteins_calculated, $get_food_carbohydrates_calculated, $get_food_fat_calculated, $get_food_barcode, $get_food_category_id, $get_food_thumb, $get_food_image_a, $get_food_image_b, $get_food_image_c, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_notes) = $row;

		if($get_food_id == ""){
			echo"
			<h1>Food not found</h1>

			<p>
			Sorry, the food was not found.
			</p>

			<p>
			<a href=\"index.php?open=$open&amp;page=food\">Back</a>
			</p>
			";
		}
		else{
			// Get sub category
			$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$get_food_category_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_sub_category_id, $get_current_sub_category_user_id, $get_current_sub_category_name, $get_current_sub_category_parent_id) = $row;

			// Get main category
			$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$get_current_sub_category_parent_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_main_category_id, $get_current_main_category_user_id, $get_current_main_category_name, $get_current_main_category_parent_id) = $row;

			// Clean name
			$food_name_clean = clean($get_food_name);
			$food_manufacturer_name_clean = clean($get_food_manufacturer_name);
			$store_dir = $food_manufacturer_name_clean . "_" . $get_food_clean_name;

			// Process
			if($process == "1"){
				// Directory for storing
				if(!(is_dir("../_uploads"))){
					mkdir("../_uploads");
				}
				if(!(is_dir("../_uploads/food"))){
					mkdir("../_uploads/food");
				}
				if(!(is_dir("../_uploads/food/_img"))){
					mkdir("../_uploads/food/_img");
				}
				if(!(is_dir("../_uploads/food/_img/$editor_language"))){
					mkdir("../_uploads/food/_img/$editor_language");
				}
				$year = date("Y");
				if(!(is_dir("../_uploads/food/_img/$editor_language/$year"))){
					mkdir("../_uploads/food/_img/$editor_language/$year");
				}
				if(!(is_dir("../_uploads/food/_img/$editor_language/$year/$store_dir"))){
					mkdir("../_uploads/food/_img/$editor_language/$year/$store_dir");
				}
	

				
				/*- Image A ------------------------------------------------------------------------------------------ */
				// $tmp_name = $_FILES['inp_food_image_a']['tmp_name'];
				$name = stripslashes($_FILES['inp_food_image_a']['name']);
				$extension = getExtension($name);
				$extension = strtolower($extension);

				if($name){
					if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
						$ft_image_a = "warning";
						$fm_image_a = "unknown_file_extension";
					}
					else{
 
						// Give new name
						$food_manufacturer_name_clean = clean($get_food_manufacturer_name);
						$new_name = $food_manufacturer_name_clean . "_" . $food_name_clean . "_a.png";
						$new_path = "../_uploads/food/_img/$editor_language/$year/$store_dir/";
						$uploaded_file = $new_path . $new_name;
						// Upload file
						if (move_uploaded_file($_FILES['inp_food_image_a']['tmp_name'], $uploaded_file)) {



							// Get image size
							$file_size = filesize($uploaded_file);
						
 
							// Check with and height
							list($width,$height) = getimagesize($uploaded_file);
	
							if($width == "" OR $height == ""){
								$ft_image_a = "warning";
								$fm_image_a = "getimagesize_failed";
							}
							else{

								// Orientation
								if ($width > $height) {
									// Landscape
								} else {
									// Portrait or Square
								}


								// Resize to 700x742
								$newwidth=$settings_image_width;
								$newheight=($height/$width)*$newwidth;
								$tmp=imagecreatetruecolor($newwidth,$newheight);
						
								if($extension=="jpg" || $extension=="jpeg" ){
									$src = imagecreatefromjpeg($uploaded_file);
								}
								else if($extension=="png"){
									$src = imagecreatefrompng($uploaded_file);
								}
								else{
									$src = imagecreatefromgif($uploaded_file);
								}
	
								imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
								imagepng($tmp,$uploaded_file);
								imagedestroy($tmp);
						

								// Make thumb 132x140
								$thumb_name = $food_name_clean . "_thumb.png";
								$thumb_file = $new_path . $thumb_name;

								$thumb_with = 132;
								$thumb_height = ($height/$width)*$thumb_with;
								$tmp=imagecreatetruecolor($thumb_with,$thumb_height);


								imagecopyresampled($tmp,$src,0,0,0,0,$thumb_with,$thumb_height, $width,$height);

								imagepng($tmp,$thumb_file);

								imagedestroy($tmp);
							

								// Update MySQL
								$inp_food_thumb_mysql = quote_smart($link, $thumb_name);
								$inp_food_image_a_mysql = quote_smart($link, $new_name);
								$result = mysqli_query($link, "UPDATE $t_food_index SET food_thumb=$inp_food_thumb_mysql, food_image_a=$inp_food_image_a_mysql WHERE food_id='$get_food_id'");


							}  // if($width == "" OR $height == ""){
						} // move_uploaded_file
						else{
							switch ($_FILES['inp_food_image_a']['error']) {
								case UPLOAD_ERR_OK:
           								$fm_image_a = "There is no error, the file uploaded with success.";
									break;
								case UPLOAD_ERR_NO_FILE:
           								// $fm_image_a = "no_file_uploaded";
									break;
								case UPLOAD_ERR_INI_SIZE:
           								$fm_image_a = "to_big_size_in_configuration";
									break;
								case UPLOAD_ERR_FORM_SIZE:
           								$fm_image_a = "to_big_size_in_form";
									break;
								default:
           								$fm_image_a = "unknown_error";
									break;

							}	
						}
	
					} // extension check
				} // if($image){


				/*- Image B ------------------------------------------------------------------------------------------ */
				// $tmp_name = $_FILES['inp_food_image_b']['tmp_name'];
				$name = stripslashes($_FILES['inp_food_image_b']['name']);
				$extension = getExtension($name);
				$extension = strtolower($extension);

				if($name){
					if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
						$ft_image_a = "warning";
						$fm_image_a = "unknown_file_extension";
					}
					else{
 
						// Give new name
						$food_manufacturer_name_clean = clean($get_food_manufacturer_name);
						$new_name = $food_manufacturer_name_clean . "_" . $food_name_clean . "_b.png";
						$new_path = "../_uploads/food/_img/$editor_language/$year/$store_dir/";
						$uploaded_file = $new_path . $new_name;

						// Upload file
						if (move_uploaded_file($_FILES['inp_food_image_b']['tmp_name'], $uploaded_file)) {


							// Get image size
							$file_size = filesize($uploaded_file);
 
							// Check with and height
							list($width,$height) = getimagesize($uploaded_file);
	
							if($width == "" OR $height == ""){
								$ft_image_b = "warning";
								$fm_image_b = "getimagesize_failed";
							}
							else{

								// Orientation
								if ($width > $height) {
								// Landscape
								} else {
									// Portrait or Square
								}


								// Resize to 700x742
								$newwidth=$settings_image_width;
								$newheight=($height/$width)*$newwidth;
								$tmp=imagecreatetruecolor($newwidth,$newheight);
						
								if($extension=="jpg" || $extension=="jpeg" ){
									$src = imagecreatefromjpeg($uploaded_file);
								}
								else if($extension=="png"){
									$src = imagecreatefrompng($uploaded_file);
								}
								else{
									$src = imagecreatefromgif($uploaded_file);
								}

								imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
	


								imagepng($tmp,$uploaded_file);

								imagedestroy($tmp);
						
								// Update MySQL
								$inp_food_image_b_mysql = quote_smart($link, $new_name);
								$result = mysqli_query($link, "UPDATE $t_food_index SET food_image_b=$inp_food_image_b_mysql WHERE food_id='$get_food_id'");


							}  // if($width == "" OR $height == ""){
						} // move_uploaded_file
						else{
							switch ($_FILES['inp_food_image_b']['error']) {
								case UPLOAD_ERR_OK:
           								$fm_image_b = "There is no error, the file uploaded with success.";
									break;
								case UPLOAD_ERR_NO_FILE:
           								// $fm_image_b = "no_file_uploaded";
									break;
								case UPLOAD_ERR_INI_SIZE:
           								$fm_image_b = "to_big_size_in_configuration";
									break;
								case UPLOAD_ERR_FORM_SIZE:
           								$fm_image_b = "to_big_size_in_form";
									break;
								default:
           								$fm_image_b = "unknown_error";
									break;
							}	
						}
					} // extension check
				} // if($image){
			

				/*- Image C ------------------------------------------------------------------------------------------ */
				// $tmp_name = $_FILES['inp_food_image_c']['tmp_name'];
				$name = stripslashes($_FILES['inp_food_image_c']['name']);
				$extension = getExtension($name);
				$extension = strtolower($extension);
	
				if($name){
					if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
						$ft_image_c = "warning";
						$fm_image_c = "unknown_file_extension";
					}
					else{
						// Give new name
						$food_manufacturer_name_clean = clean($get_food_manufacturer_name);
						$new_name = $food_manufacturer_name_clean . "_" . $food_name_clean . "_c.png";
						$new_path = "../_uploads/food/_img/$editor_language/$year/$store_dir/";
						$uploaded_file = $new_path . $new_name;

						// Upload file
						if (move_uploaded_file($_FILES['inp_food_image_c']['tmp_name'], $uploaded_file)) {


							// Get image size
							$file_size = filesize($uploaded_file);
 
							// Check with and height
							list($width,$height) = getimagesize($uploaded_file);
	
							if($width == "" OR $height == ""){
								$ft_image_c = "warning";
								$fm_image_c = "getimagesize_failed";
							}
							else{

								// Orientation
								if ($width > $height) {
									// Landscape
								} else {
									// Portrait or Square
								}


								// Resize to 700x742
								$newwidth=$settings_image_width;
								$newheight=($height/$width)*$newwidth;
								$tmp=imagecreatetruecolor($newwidth,$newheight);
						
								if($extension=="jpg" || $extension=="jpeg" ){
									$src = imagecreatefromjpeg($uploaded_file);
								}
								else if($extension=="png"){
									$src = imagecreatefrompng($uploaded_file);
								}
								else{
									$src = imagecreatefromgif($uploaded_file);
								}

								imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
	
								imagepng($tmp,$uploaded_file);

								imagedestroy($tmp);
						
								// Update MySQL
								$inp_food_image_c_mysql = quote_smart($link, $new_name);
								$result = mysqli_query($link, "UPDATE $t_food_index SET food_image_c=$inp_food_image_c_mysql WHERE food_id='$get_food_id'");

							}  // if($width == "" OR $height == ""){
						} // move_uploaded_file
						else{
							switch ($_FILES['inp_food_image_c']['error']) {
								case UPLOAD_ERR_OK:
           								$fm_image_c = "There is no error, the file uploaded with success. ";
									break;
								case UPLOAD_ERR_NO_FILE:
           								// $fm_image_c = "no_file_uploaded";
									break;
								case UPLOAD_ERR_INI_SIZE:
           								$fm_image_c = "to_big_size_in_configuration";
									break;
								case UPLOAD_ERR_FORM_SIZE:
           								$fm_image_c = "to_big_size_in_form";
									break;
								default:
           								$fm_image_c = "unknown_error";
									break;

							}	
						}
	
					} // extension check
				} // if($image){



				// Feedback
				if(isset($fm_image_a) OR isset($fm_image_b) OR isset($fm_image_c)){
					// Feedback with error

					$url = "index.php?open=$open&page=food&action=new_food&step=images&main_category_id=$get_current_main_category_id&sub_category_id=$get_current_sub_category_id&food_id=$food_id&editor_language=$editor_language";
					if(isset($fm_image_a)){
						$url = $url . "&fm_image_a=$fm_image_a";
					}
					if(isset($fm_image_b)){
						$url = $url . "&fm_image_b=$fm_image_c";
					}
					if(isset($fm_image_c)){
						$url = $url . "&fm_image_c=$fm_image_c";
					}
					header("Location: $url");
					exit;
				}
				else{
					// Feedback without error
					$url = "index.php?open=$open&page=food&action=view_food&step=images&main_category_id=$main_category_id&sub_category_id=$sub_category_id&food_id=$food_id&editor_language=$editor_language&ft=success&fm=changes_saved";


					header("Location: $url");
					exit;
				}


				
			} // process


			echo"
			<h1>New food</h1>

			<!-- Feedback -->
			";
			if(isset($_GET['fm_image_a']) OR isset($_GET['fm_image_b']) OR isset($_GET['fm_image_c'])){
				echo"
				<div class=\"info\">
					<p>
					";
					if(isset($_GET['fm_image_a'])){
						$fm_image_a = $_GET['fm_image_a'];

						if($fm_image_a == "unknown_file_extension"){
							echo"Product image: Unknown file extension<br />\n";
						}
						elseif($fm_image_a == "getimagesize_failed"){
							echo"Product image: Could not get with and height of image<br />\n";
						}
						elseif($fm_image_a == "image_to_big"){
							echo"Product image: Image file size to big<br />\n";
						}
						elseif($fm_image_a == "to_big_size_in_configuration"){
							echo"Product image: Image file size to big (in config)<br />\n";
						}
						elseif($fm_image_a == "to_big_size_in_form"){
							echo"Product image: Image file size to big (in form)<br />\n";
						}
						elseif($fm_image_a == "unknown_error"){
							echo"Product image: Unknown error<br />\n";
						}

					}
					if(isset($_GET['fm_image_b'])){
						$fm_image_b = $_GET['fm_image_b'];

						if($fm_image_b == "unknown_file_extension"){
							echo"Food table image: Unknown file extension<br />\n";
						}
						elseif($fm_image_b == "getimagesize_failed"){
							echo"Food table image: Could not get with and height of image<br />\n";
						}
						elseif($fm_image_b == "image_to_big"){
							echo"Food table image: Image file size to big<br />\n";
						}
						elseif($fm_image_b == "to_big_size_in_configuration"){
							echo"Food table image: Image file size to big (in config)<br />\n";
						}
						elseif($fm_image_b == "to_big_size_in_form"){
							echo"Food table image: Image file size to big (in form)<br />\n";
						}
						elseif($fm_image_b == "unknown_error"){
							echo"Food table image: Unknown error<br />\n";
						}

					}
					if(isset($_GET['fm_image_c'])){
						$fm_image_c = $_GET['fm_image_c'];

						if($fm_image_c == "unknown_file_extension"){
							echo"Inspiration image: Unknown file extension<br />\n";
						}
						elseif($fm_image_c == "getimagesize_failed"){
							echo"Inspiration image: Could not get with and height of image<br />\n";
						}
						elseif($fm_image_c == "image_to_big"){
							echo"Inspiration image: Image file size to big<br />\n";
						}
						elseif($fm_image_c == "to_big_size_in_configuration"){
							echo"Inspiration image: Image file size to big (in config)<br />\n";
						}
						elseif($fm_image_c == "to_big_size_in_form"){
							echo"Inspiration image: Image file size to big (in form)<br />\n";
						}
						elseif($fm_image_c == "unknown_error"){
							echo"Inspiration image: Unknown error<br />\n";
						}

					}
					echo"
					</p>
				</div>";
			}
			echo"
			<!-- //Feedback -->

			<!-- Images -->

				<h2>Images (min height $settings_image_height px. Pefect with is $settings_image_width px)</h2>

				<form method=\"post\" action=\"index.php?open=$open&amp;page=food&amp;action=new_food&amp;step=images&amp;main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;editor_language=$editor_language&amp;process=1\" enctype=\"multipart/form-data\">
				
				<table>";
				if($get_food_image_a == ""){
					echo"
					 <tr>
					  <td style=\"text-align: right;padding: 0px 4px 0px 0px;vertical-align: top;\">
						<p><b>Product image:</b></p>
					  </td>
					  <td>
    						<p>
						<input type=\"file\" name=\"inp_food_image_a\" />
						</p>
					  </td>
					 </tr>
					";
				}
				if($get_food_image_b == ""){
					echo"
					 <tr>
					  <td style=\"text-align: right;padding: 10px 4px 0px 0px;vertical-align: top;\">
						<p><b>Food table image:</b></p>
					  </td>
					  <td>
    						<p>
						<input type=\"file\" name=\"inp_food_image_b\" />
						</p>
					  </td>
					 </tr>
					";
				}
				if($get_food_image_c == ""){
					echo"
					 <tr>
					  <td style=\"text-align: right;padding: 10px 4px 0px 0px;vertical-align: top;\">
						<p><b>Inspiration image:</b></p>
					  </td>
					  <td>
    						<p>
						<input type=\"file\" name=\"inp_food_image_c\" />
						</p>
					  </td>
					 </tr>
					";
				}
				echo"
				 <tr>
				  <td style=\"text-align: right;padding: 10px 4px 0px 0px;vertical-align: top;\">
					
				  </td>
				  <td>
					<p>
					<input type=\"submit\" value=\"Upload images\"  class=\"btn btn-success btn-sm\"  />
					<input type=\"submit\" value=\"Skip this step\"  class=\"btn btn-sm\"  />
					</p>
				  </td>
				 </tr>
				</table>

			<!-- //Images -->


			<p>
			<a href=\"index.php?open=$open&amp;page=food&amp;editor_language=$editor_language\"><img src=\"_design/gfx/icons/16x16/go-previous.png\" alt=\"go-previous.png\" /></a>
			<a href=\"index.php?open=$open&amp;page=food&amp;editor_language=$editor_language\">Go back</a>
			</p>
			";

		}
	} // numbers
	else{
		echo"<p>Unknown step.</p>";
	}
}
?>