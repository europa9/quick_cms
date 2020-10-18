<?php
/**
*
* File: food/edit_food_general.php
* Version 1.0.0
* Date 13:03 03.02.2018
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


/*- Translations ---------------------------------------------------------------------- */
include("$root/_admin/_translations/site/$l/food/ts_view_food.php");
include("$root/_admin/_translations/site/$l/food/ts_edit_food.php");
include("$root/_admin/_translations/site/$l/food/ts_new_food.php");

/*- Variables ------------------------------------------------------------------------- */
$l_mysql = quote_smart($link, $l);


if(isset($_GET['open_main_category_id'])){
	$open_main_category_id= $_GET['open_main_category_id'];
	$open_main_category_id = strip_tags(stripslashes($open_main_category_id));
}
else{
	$open_main_category_id = "";
}
if(isset($_GET['sub_category_id'])){
	$sub_category_id= $_GET['sub_category_id'];
	$sub_category_id = strip_tags(stripslashes($sub_category_id));
}
else{
	$sub_category_id = "";
}

if(isset($_GET['food_id'])){
	$food_id = $_GET['food_id'];
	$food_id = strip_tags(stripslashes($food_id));
	$food_id_mysql = quote_smart($link, $food_id);
}
else{
	$food_id = "";
}



// Select food
$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_country, food_net_content, food_net_content_measurement, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_fat, food_fat_of_which_saturated_fatty_acids, food_carbohydrates, food_carbohydrates_of_which_dietary_fiber, food_carbohydrates_of_which_sugars, food_proteins, food_salt, food_sodium, food_score, food_energy_calculated, food_fat_calculated, food_fat_of_which_saturated_fatty_acids_calculated, food_carbohydrates_calculated, food_carbohydrates_of_which_dietary_fiber_calculated, food_carbohydrates_of_which_sugars_calculated, food_proteins_calculated, food_salt_calculated, food_sodium_calculated, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_thumb_a_medium, food_thumb_a_large, food_image_b, food_thumb_b_small, food_thumb_b_medium, food_thumb_b_large, food_image_c, food_thumb_c_small, food_thumb_c_medium, food_thumb_c_large, food_image_d, food_thumb_d_small, food_thumb_d_medium, food_thumb_d_large, food_image_e, food_thumb_e_small, food_thumb_e_medium, food_thumb_e_large, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_created_date, food_last_viewed, food_age_restriction FROM $t_food_index WHERE food_id=$food_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_manufacturer_name_and_food_name, $get_food_description, $get_food_country, $get_food_net_content, $get_food_net_content_measurement, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_fat, $get_food_fat_of_which_saturated_fatty_acids, $get_food_carbohydrates, $get_food_carbohydrates_of_which_dietary_fiber, $get_food_carbohydrates_of_which_sugars, $get_food_proteins, $get_food_salt, $get_food_sodium, $get_food_score, $get_food_energy_calculated, $get_food_fat_calculated, $get_food_fat_of_which_saturated_fatty_acids_calculated, $get_food_carbohydrates_calculated, $get_food_carbohydrates_of_which_dietary_fiber_calculated, $get_food_carbohydrates_of_which_sugars_calculated, $get_food_proteins_calculated, $get_food_salt_calculated, $get_food_sodium_calculated, $get_food_barcode, $get_food_main_category_id, $get_food_sub_category_id, $get_food_image_path, $get_food_image_a, $get_food_thumb_a_small, $get_food_thumb_a_medium, $get_food_thumb_a_large, $get_food_image_b, $get_food_thumb_b_small, $get_food_thumb_b_medium, $get_food_thumb_b_large, $get_food_image_c, $get_food_thumb_c_small, $get_food_thumb_c_medium, $get_food_thumb_c_large, $get_food_image_d, $get_food_thumb_d_small, $get_food_thumb_d_medium, $get_food_thumb_d_large, $get_food_image_e, $get_food_thumb_e_small, $get_food_thumb_e_medium, $get_food_thumb_e_large, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block, $get_food_user_ip, $get_food_created_date, $get_food_last_viewed, $get_food_age_restriction) = $row;

if($get_food_id == ""){
	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "$l_food - Server error 404";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");


	echo"
	<h1>Food not found</h1>

	<p>
	Sorry, the food was not found.
	</p>

	<p>
	<a href=\"index.php\">Back</a>
	</p>
	";
}
else{


	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "$l_food - $get_food_name $get_food_manufacturer_name";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");





	// Get sub category
	$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$get_food_sub_category_id";
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

		$result = mysqli_query($link, "UPDATE $t_food_index SET food_sub_category_id='$get_current_sub_category_id' WHERE food_id='$get_food_id'") or die(mysqli_error($link));

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
	$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_current_main_category_id AND category_translation_language=$l_mysql";
	$result_t = mysqli_query($link, $query_t);
	$row_t = mysqli_fetch_row($result_t);
	list($get_current_main_category_translation_value) = $row_t;

	$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_current_sub_category_id AND category_translation_language=$l_mysql";
	$result_t = mysqli_query($link, $query_t);
	$row_t = mysqli_fetch_row($result_t);
	list($get_current_sub_category_translation_value) = $row_t;
	


	// My user
	if(isset($_SESSION['user_id'])){
		$my_user_id = $_SESSION['user_id'];
		$my_user_id_mysql = quote_smart($link, $my_user_id);

		if($get_food_user_id != "$my_user_id"){
			echo"
			<p>Access denied.</p>
			";
		}
		else{
			if($process == 1){
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


				$inp_food_description = $_POST['inp_food_description'];
				$inp_food_description = output_html($inp_food_description);
				$inp_food_description_mysql = quote_smart($link, $inp_food_description);

				$inp_food_barcode = $_POST['inp_food_barcode'];
				$inp_food_barcode = output_html($inp_food_barcode);
				$inp_food_barcode_mysql = quote_smart($link, $inp_food_barcode);
	
				$inp_food_country = $_POST['inp_food_country'];
				$inp_food_country = output_html($inp_food_country);
				$inp_food_country_mysql = quote_smart($link, $inp_food_country);

				$inp_food_net_content = $_POST['inp_food_net_content'];
				if(empty($inp_food_net_content)){
					$inp_food_net_content = $_POST['inp_food_serving_size_gram'];
				}
				else{
					if(!(is_numeric($inp_food_net_content))){
						$inp_food_net_content = $_POST['inp_food_serving_size_gram'];
					}
				}
				$inp_food_net_content = output_html($inp_food_net_content);
				$inp_food_net_content = str_replace(",", ".", $inp_food_net_content);
				$inp_food_net_content_mysql = quote_smart($link, $inp_food_net_content);

				$inp_food_net_content_measurement = $_POST['inp_food_net_content_measurement'];
				$inp_food_net_content_measurement = output_html($inp_food_net_content_measurement);
				$inp_food_net_content_measurement_mysql = quote_smart($link, $inp_food_net_content_measurement);

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


				$inp_age_restriction = $_POST['inp_age_restriction'];
				$inp_age_restriction = output_html($inp_age_restriction);
				$inp_age_restriction_mysql = quote_smart($link, $inp_age_restriction);


				if($ft == ""){
						
					$inp_food_user_id = $_SESSION['user_id'];
					$inp_food_user_id = output_html($inp_food_user_id);
					$inp_food_user_id_mysql = quote_smart($link, $inp_food_user_id);

					// IP 
					$inp_user_ip = $_SERVER['REMOTE_ADDR'];
					$inp_user_ip = output_html($inp_user_ip);
					$inp_user_ip_mysql = quote_smart($link, $inp_user_ip);

					// Datetime (notes)
					$datetime = date("Y-m-d H:i:s");
					$inp_notes = "Started on $datetime by user id $inp_food_user_id";
					$inp_notes_mysql = quote_smart($link, $inp_notes);

					
				
					// Update food_id
					$result = mysqli_query($link, "UPDATE $t_food_index SET food_name=$inp_food_name_mysql, food_clean_name=$inp_food_clean_name_mysql, 
									food_manufacturer_name=$inp_food_manufacturer_name_mysql, 
									food_description=$inp_food_description_mysql, 
									food_country=$inp_food_country_mysql,
									food_net_content=$inp_food_net_content_mysql, food_net_content_measurement=$inp_food_net_content_measurement_mysql, 
									food_serving_size_gram=$inp_food_serving_size_gram_mysql, food_serving_size_gram_measurement=$inp_food_serving_size_gram_measurement_mysql, 
									food_serving_size_pcs=$inp_food_serving_size_pcs_mysql, food_serving_size_pcs_measurement=$inp_food_serving_size_pcs_measurement_mysql, 
									food_barcode=$inp_food_barcode_mysql, food_user_ip=$inp_user_ip_mysql,
									food_age_restriction=$inp_age_restriction_mysql WHERE food_id='$get_food_id'") or die(mysqli_error($link));


					// We changed size, so we need to update numbers
					if($inp_food_serving_size_gram != "$get_food_serving_size_gram"){
						if($get_food_energy != ""){
							$inp_food_energy_calculated = round($get_food_energy*$inp_food_serving_size_gram/100, 0);
						}
						else{
							$inp_food_energy_calculated = $get_food_energy_calculated;
						}

						if($get_food_fat != ""){
							$inp_food_fat_calculated = round($get_food_fat*$inp_food_serving_size_gram/100, 0);
						}
						else{
							$inp_food_fat_calculated = $get_food_fat_calculated;
						}

						if($get_food_fat_of_which_saturated_fatty_acids != ""){
							$inp_food_fat_of_which_saturated_fatty_acids_calculated = round($get_food_fat_of_which_saturated_fatty_acids*$inp_food_serving_size_gram/100, 0);
						}
						else{
							$inp_food_fat_of_which_saturated_fatty_acids_calculated = $get_food_fat_of_which_saturated_fatty_acids_calculated;
						}

						if($get_food_carbohydrates != ""){
							$inp_food_carbohydrates_calculated = round($get_food_carbohydrates*$inp_food_serving_size_gram/100, 0);
						}
						else{
							$inp_food_carbohydrates_calculated = $get_food_carbohydrates_calculated;
						}

						if($get_food_carbohydrates_of_which_dietary_fiber != ""){
							$inp_food_carbohydrates_of_which_dietary_fiber_calculated = round($get_food_carbohydrates_of_which_dietary_fiber*$inp_food_serving_size_gram/100, 0);
						}
						else{
							$inp_food_carbohydrates_of_which_dietary_fiber_calculated = $get_food_carbohydrates_of_which_dietary_fiber_calculated;
						}
	
						if($get_food_carbohydrates_of_which_sugars != ""){
							$inp_food_carbohydrates_of_which_sugars_calculated = round($get_food_carbohydrates_of_which_sugars*$inp_food_serving_size_gram/100, 0);
						}
						else{
							$inp_food_carbohydrates_of_which_sugars_calculated = $get_food_carbohydrates_of_which_sugars_calculated;
						}
		

						if($get_food_proteins != ""){
							$inp_food_proteins_calculated = round($get_food_proteins*$inp_food_serving_size_gram/100, 0);
						}
						else{
							$inp_food_proteins_calculated = $get_food_proteins_calculated;
						}

	
	
						if($get_food_salt != ""){
							$inp_food_salt_calculated = round($get_food_salt*$inp_food_serving_size_gram/100, 0);
						}
						else{
							$inp_food_salt_calculated = $get_food_salt_calculated;
						}

						if($get_food_sodium != ""){
							$inp_food_sodium_calculated = round($get_food_sodium*$inp_food_serving_size_gram/100, 0);
						}
						else{
							$inp_food_sodium_calculated = $get_food_sodium_calculated;
						}
						if($inp_food_sodium_calculated == ""){
							$inp_food_sodium_calculated = 0;
						}



						$result = mysqli_query($link, "UPDATE $t_food_index SET food_energy_calculated='$inp_food_energy_calculated',
food_proteins_calculated='$inp_food_proteins_calculated',
food_salt_calculated='$inp_food_salt_calculated', 
food_sodium_calculated='$inp_food_sodium_calculated',
food_carbohydrates_calculated='$inp_food_carbohydrates_calculated',
food_carbohydrates_of_which_dietary_fiber_calculated='$inp_food_carbohydrates_of_which_dietary_fiber_calculated',
food_carbohydrates_of_which_sugars_calculated='$inp_food_carbohydrates_of_which_sugars_calculated',
food_fat_calculated='$inp_food_fat_calculated',
food_fat_of_which_saturated_fatty_acids_calculated='$inp_food_fat_of_which_saturated_fatty_acids_calculated'
WHERE food_id='$get_food_id'") or die(mysqli_error($link));

					}


					// Countries
					if($inp_food_country != "$get_food_country"){
						$query_t = "SELECT food_country_id, food_country_count_food FROM $t_food_countries_used WHERE food_country_name=$inp_food_country_mysql";
						$result_t = mysqli_query($link, $query_t);
						$row_t = mysqli_fetch_row($result_t);
						list($get_food_country_id, $get_food_country_count_food) = $row_t;
						if($get_food_country_id == ""){
							// New food country
							mysqli_query($link, "INSERT INTO $t_food_countries_used 
							(food_country_id, food_country_name, food_country_count_food) 
							VALUES 
							(NULL, $inp_food_country_mysql, '1')")
							or die(mysqli_error($link));
						}
						else{
							$inp_count = $get_food_country_count_food+1;
							$result = mysqli_query($link, "UPDATE $t_food_countries_used SET food_country_count_food=$inp_count WHERE food_country_id=$get_food_country_id");
						}
					} // new country

					// Header	
					$url = "edit_food_general.php?food_id=$get_food_id&el=$l&ft=success&fm=changes_saved";
					header("Location: $url");
					exit;
				}
				else{
					$url = "edit_food_general.php?food_id=$food_id&l=$l&ft=$ft&fm=$fm";
					$url = $url . "&ft=$ft&fm=$fm";

					header("Location: $url");
					exit;
				}

			
			}


			echo"
			<h1>$get_food_manufacturer_name $get_food_name</h1>

			<!-- Where am I? -->
				<p>
				<a href=\"my_food.php?l=$l#food$get_food_id\">$l_my_food</a>
				&gt;
				<a href=\"view_food.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;food_id=$food_id&amp;l=$l\">$get_food_name</a>
				&gt;
				<a href=\"edit_food.php?food_id=$food_id&amp;l=$l\">$l_edit</a>
				&gt;
				<a href=\"edit_food_general.php?food_id=$food_id&amp;l=$l\">$l_general</a>
				</p>
			<!-- //Where am I? -->


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

				<form method=\"post\" action=\"edit_food_general.php?food_id=$get_food_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

				<h2>$l_general_information</h2>
					
				<p><b>$l_name:</b><br />
				<input type=\"text\" name=\"inp_food_name\" value=\""; $get_food_name = str_replace("&amp;", "&", $get_food_name); echo"$get_food_name\" size=\"40\" /></p>
			
				<p><b>$l_manufacturer:</b><br />
				<input type=\"text\" name=\"inp_food_manufacturer_name\" value=\"$get_food_manufacturer_name\" size=\"40\" /></p>
			 
				<p><b>$l_description:</b><br />
				<input type=\"text\" name=\"inp_food_description\" value=\"$get_food_description\" size=\"40\" /></p>
			
				<p><b>$l_barcode:</b><br />
				<input type=\"text\" name=\"inp_food_barcode\" value=\"$get_food_barcode\" size=\"40\" /></p>
			
				<p><b>$l_country:</b><br />
				<select name=\"inp_food_country\">\n";
				$query = "SELECT language_flag FROM $t_languages ORDER BY language_flag ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_language_flag) = $row;

					$country = str_replace("_", " ", $get_language_flag);
					$country = ucwords($country);
					if($country != "$prev_country"){
						echo"			";
						echo"<option value=\"$country\""; if($get_food_country == "$country"){ echo" selected=\"selected\""; } echo">$country</option>\n";
					}
					$prev_country = "$country";
				}
				echo"
				</select></p>
			
				<p><b>$l_net_content:</b><br />
				<input type=\"text\" name=\"inp_food_net_content\" value=\"$get_food_net_content\" size=\"3\" />

				<select name=\"inp_food_net_content_measurement\">
					<option value=\"g\""; if($get_food_net_content_measurement == "g"){ echo" selected=\"selected\""; } echo">g</option>
					<option value=\"ml\""; if($get_food_net_content_measurement == "ml"){ echo" selected=\"selected\""; } echo">ml</option>
				</select>
				</p>
			
				<p><b>$l_serving:</b><br />
				<input type=\"text\" name=\"inp_food_serving_size_gram\" value=\"$get_food_serving_size_gram\" size=\"3\" />
						
				<select name=\"inp_food_serving_size_gram_measurement\">
					<option value=\"g\""; if($get_food_serving_size_gram_measurement == "g"){ echo" selected=\"selected\""; } echo">g</option>
					<option value=\"ml\""; if($get_food_serving_size_gram_measurement == "ml"){ echo" selected=\"selected\""; } echo">ml</option>
				</select><br />
				<span class=\"smal\">$l_examples_g_ml</span>
				</p>
				
				<p><b>$l_serving_pcs:</b><br />
				<input type=\"text\" name=\"inp_food_serving_size_pcs\" value=\"$get_food_serving_size_pcs\" size=\"3\" />
				<select name=\"inp_food_serving_size_pcs_measurement\">\n";
				// Get measurements
				$query = "SELECT measurement_id, measurement_name FROM $t_food_measurements ORDER BY measurement_name ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_measurement_id, $get_measurement_name) = $row;


					// Translation
					$query_translation = "SELECT measurement_translation_id, measurement_translation_value FROM $t_food_measurements_translations WHERE measurement_id=$get_measurement_id AND measurement_translation_language=$l_mysql";
					$result_translation = mysqli_query($link, $query_translation);
					$row_translation = mysqli_fetch_row($result_translation);
					list($get_measurement_translation_id, $get_measurement_translation_value) = $row_translation;


					echo"				";
					echo"<option value=\"$get_measurement_translation_value\""; if($get_food_serving_size_pcs_measurement == "$get_measurement_translation_value"){ echo" selected=\"selected\""; } echo">$get_measurement_translation_value</option>\n";
				}
				echo"
				</select><br />
				<span class=\"smal\">$l_examples_package_slice_pcs_plate</span>
				</p>
			

				<p><b>$l_age_restriction:</b><br />
				<select name=\"inp_age_restriction\">
					<option value=\"0\""; if($get_food_age_restriction == "0"){ echo" selected=\"selected\""; } echo">$l_no</option>
					<option value=\"1\""; if($get_food_age_restriction == "1"){ echo" selected=\"selected\""; } echo">$l_yes</option>
				</select>
				<br />
				<em>$l_example_alcohol</em></p>

			
				<p><input type=\"submit\" value=\"$l_save\" class=\"btn btn-success btn-sm\" /></p>
			
			<!-- //General information -->
			<!-- Back -->
				<p>
				<a href=\"my_food.php?l=$l#food$get_food_id\" class=\"btn btn_default\">$l_my_food</a>
				</p>
			<!-- //Back -->

			";
		}
	}
	else{
		echo"<p>Please log in</p>";
	}
}
/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>