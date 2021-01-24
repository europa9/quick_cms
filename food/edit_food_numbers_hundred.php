<?php
/**
*
* File: food/edit_food_numbers.php
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
$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_country, food_net_content, food_net_content_measurement, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_fat, food_fat_of_which_saturated_fatty_acids, food_carbohydrates, food_dietary_fiber, food_carbohydrates_of_which_sugars, food_proteins, food_salt, food_sodium, food_score, food_energy_calculated, food_fat_calculated, food_fat_of_which_saturated_fatty_acids_calculated, food_carbohydrates_calculated, food_dietary_fiber_calculated, food_carbohydrates_of_which_sugars_calculated, food_proteins_calculated, food_salt_calculated, food_sodium_calculated, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_thumb_a_medium, food_thumb_a_large, food_image_b, food_thumb_b_small, food_thumb_b_medium, food_thumb_b_large, food_image_c, food_thumb_c_small, food_thumb_c_medium, food_thumb_c_large, food_image_d, food_thumb_d_small, food_thumb_d_medium, food_thumb_d_large, food_image_e, food_thumb_e_small, food_thumb_e_medium, food_thumb_e_large, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_created_date, food_last_viewed, food_age_restriction FROM $t_food_index WHERE food_id=$food_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_manufacturer_name_and_food_name, $get_food_description, $get_food_country, $get_food_net_content, $get_food_net_content_measurement, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_fat, $get_food_fat_of_which_saturated_fatty_acids, $get_food_carbohydrates, $get_food_dietary_fiber, $get_food_carbohydrates_of_which_sugars, $get_food_proteins, $get_food_salt, $get_food_sodium, $get_food_score, $get_food_energy_calculated, $get_food_fat_calculated, $get_food_fat_of_which_saturated_fatty_acids_calculated, $get_food_carbohydrates_calculated, $get_food_dietary_fiber_calculated, $get_food_carbohydrates_of_which_sugars_calculated, $get_food_proteins_calculated, $get_food_salt_calculated, $get_food_sodium_calculated, $get_food_barcode, $get_food_main_category_id, $get_food_sub_category_id, $get_food_image_path, $get_food_image_a, $get_food_thumb_a_small, $get_food_thumb_a_medium, $get_food_thumb_a_large, $get_food_image_b, $get_food_thumb_b_small, $get_food_thumb_b_medium, $get_food_thumb_b_large, $get_food_image_c, $get_food_thumb_c_small, $get_food_thumb_c_medium, $get_food_thumb_c_large, $get_food_image_d, $get_food_thumb_d_small, $get_food_thumb_d_medium, $get_food_thumb_d_large, $get_food_image_e, $get_food_thumb_e_small, $get_food_thumb_e_medium, $get_food_thumb_e_large, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block, $get_food_user_ip, $get_food_created_date, $get_food_last_viewed, $get_food_age_restriction) = $row;

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
				// per 100 
				$inp_food_energy = $_POST['inp_food_energy'];
				$inp_food_energy = output_html($inp_food_energy);
				$inp_food_energy = str_replace(",", ".", $inp_food_energy);
				$inp_food_energy_mysql = quote_smart($link, $inp_food_energy);
				if($inp_food_energy == ""){
					$ft = "error";
					$fm = "missing_energy";
				}

				$inp_food_fat = $_POST['inp_food_fat'];
				$inp_food_fat = output_html($inp_food_fat);
				$inp_food_fat = str_replace(",", ".", $inp_food_fat);
				$inp_food_fat_mysql = quote_smart($link, $inp_food_fat);
				if($inp_food_fat == ""){
					$ft = "error";
					$fm = "missing_fat";
				}

				$inp_food_fat_of_which_saturated_fatty_acids = $_POST['inp_food_fat_of_which_saturated_fatty_acids'];
				$inp_food_fat_of_which_saturated_fatty_acids = output_html($inp_food_fat_of_which_saturated_fatty_acids);
				$inp_food_fat_of_which_saturated_fatty_acids = str_replace(",", ".", $inp_food_fat_of_which_saturated_fatty_acids);
				$inp_food_fat_of_which_saturated_fatty_acids_mysql = quote_smart($link, $inp_food_fat_of_which_saturated_fatty_acids);
				if($inp_food_fat_of_which_saturated_fatty_acids == ""){
					$ft = "error";
					$fm = "missing_of_which_saturated_fatty_acid";
				}


				$inp_food_carbohydrates = $_POST['inp_food_carbohydrates'];
				$inp_food_carbohydrates = output_html($inp_food_carbohydrates);
				$inp_food_carbohydrates = str_replace(",", ".", $inp_food_carbohydrates);
				$inp_food_carbohydrates_mysql = quote_smart($link, $inp_food_carbohydrates);
				if($inp_food_carbohydrates == ""){
					$ft = "error";
					$fm = "missing_carbohydrates";
				}



				$inp_food_dietary_fiber = $_POST['inp_food_dietary_fiber'];
				$inp_food_dietary_fiber = output_html($inp_food_dietary_fiber);
				$inp_food_dietary_fiber = str_replace(",", ".", $inp_food_dietary_fiber);
				$inp_food_dietary_fiber_mysql = quote_smart($link, $inp_food_dietary_fiber);


				$inp_food_carbohydrates_of_which_sugars = $_POST['inp_food_carbohydrates_of_which_sugars'];
				$inp_food_carbohydrates_of_which_sugars = output_html($inp_food_carbohydrates_of_which_sugars);
				$inp_food_carbohydrates_of_which_sugars = str_replace(",", ".", $inp_food_carbohydrates_of_which_sugars);
				$inp_food_carbohydrates_of_which_sugars_mysql = quote_smart($link, $inp_food_carbohydrates_of_which_sugars);
				if($inp_food_carbohydrates_of_which_sugars == ""){
					$ft = "error";
					$fm = "missing_of_which_sugars";
				}




				$inp_food_proteins = $_POST['inp_food_proteins'];
				$inp_food_proteins = output_html($inp_food_proteins);
				$inp_food_proteins = str_replace(",", ".", $inp_food_proteins);
				$inp_food_proteins_mysql = quote_smart($link, $inp_food_proteins);
				if($inp_food_proteins == ""){
					$ft = "error";
					$fm = "missing_proteins";
				}

				$inp_food_salt = $_POST['inp_food_salt'];
				$inp_food_salt = output_html($inp_food_salt);
				$inp_food_salt = str_replace(",", ".", $inp_food_salt);
				$inp_food_salt_mysql = quote_smart($link, $inp_food_salt);
				if($inp_food_salt == ""){
					$ft = "error";
					$fm = "missing_salt";
				}

				// Sodium is 40 % of salt
				$inp_food_sodium = ($inp_food_salt*40)/100; // g
				$inp_food_sodium = $inp_food_sodium*1000; // mg
				$inp_food_sodium_mysql = quote_smart($link, $inp_food_sodium);


				// Calculated
				$inp_food_energy_calculated = round($inp_food_energy*$get_food_serving_size_gram/100, 0);
				$inp_food_fat_calculated = round($inp_food_fat*$get_food_serving_size_gram/100, 0);
				$inp_food_fat_of_which_saturated_fatty_acids_calculated = round($inp_food_fat_of_which_saturated_fatty_acids*$get_food_serving_size_gram/100, 0);
				$inp_food_carbohydrates_calculated = round($inp_food_carbohydrates*$get_food_serving_size_gram/100, 0);
				$inp_food_dietary_fiber_calculated = round($inp_food_dietary_fiber*$get_food_serving_size_gram/100, 0);
				$inp_food_carbohydrates_of_which_sugars_calculated = round($inp_food_carbohydrates_of_which_sugars*$get_food_serving_size_gram/100, 0);
				$inp_food_proteins_calculated = round($inp_food_proteins*$get_food_serving_size_gram/100, 0);
				$inp_food_salt_calculated = round($inp_food_salt*$get_food_serving_size_gram/100, 0);
				$inp_food_sodium_calculated = round($inp_food_sodium*$get_food_serving_size_gram/100, 0);


				// Score
				$inp_total = $inp_food_energy + $inp_food_fat + $inp_food_fat_of_which_saturated_fatty_acids + $inp_food_carbohydrates + $inp_food_dietary_fiber + $inp_food_carbohydrates_of_which_sugars + $inp_food_proteins + $inp_food_salt;
				$inp_calculation = ($inp_food_energy * 1) + 
				     ($inp_food_fat * 13) +  
				     ($inp_food_fat_of_which_saturated_fatty_acids * 1) + 
				     ($inp_food_carbohydrates * 44) +
				     ($inp_food_dietary_fiber * 1) +
				     ($inp_food_carbohydrates_of_which_sugars * 1) +
				     ($inp_food_proteins * 43) +
				     ($inp_food_salt * 1);

				$inp_score = 0;
				if($inp_total != 0){
					$inp_score = round($inp_calculation / $inp_total, 0);
				}
				$inp_score_mysql = quote_smart($link, $inp_score);


				if($ft == ""){	
					// Update

					$result = mysqli_query($link, "UPDATE $t_food_index SET food_energy=$inp_food_energy_mysql, 
food_fat=$inp_food_fat_mysql, 
food_fat_of_which_saturated_fatty_acids=$inp_food_fat_of_which_saturated_fatty_acids_mysql, 
food_carbohydrates=$inp_food_carbohydrates_mysql, 
food_dietary_fiber=$inp_food_dietary_fiber_mysql, 
food_carbohydrates_of_which_sugars=$inp_food_carbohydrates_of_which_sugars_mysql, 
food_proteins=$inp_food_proteins_mysql, 
food_salt=$inp_food_salt_mysql, 
food_sodium=$inp_food_sodium_mysql, 
food_score=$inp_score_mysql, 
food_energy_calculated='$inp_food_energy_calculated', 
food_fat_calculated='$inp_food_fat_calculated',
food_fat_of_which_saturated_fatty_acids_calculated='$inp_food_fat_of_which_saturated_fatty_acids_calculated',
food_carbohydrates_calculated='$inp_food_carbohydrates_calculated',
food_dietary_fiber_calculated=$inp_food_dietary_fiber_calculated, 
food_carbohydrates_of_which_sugars_calculated='$inp_food_carbohydrates_of_which_sugars_calculated',
food_proteins_calculated='$inp_food_proteins_calculated',
food_salt_calculated='$inp_food_salt_calculated',
food_sodium_calculated='$inp_food_sodium_calculated'
 WHERE food_id='$get_food_id'") or print(mysqli_error());

					$url = "edit_food_numbers_hundred.php?food_id=$get_food_id&l_$l&ft=success&fm=changes_saved";
					header("Location: $url");
					exit;
				}
				else{
					$url = "edit_food_numbers_hundred.php?food_id=$get_food_id&l=$l";
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
				<a href=\"edit_food_numbers_other.php?food_id=$food_id&amp;l=$l\">$l_numbers</a>
				</p>
			<!-- //Where am I? -->

			<!-- Feedback -->";
				if(isset($ft) && isset($fm)){
					echo"<div class=\"$ft\"><p>$fm</p></div>";
				}
			echo"
			<!-- //Feedback -->
			

			<!-- Focus -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_food_energy\"]').focus();
				});
				</script>
			<!-- //Focus -->

				<h2>$l_numbers</h2>

			<!-- Img -->
				<div style=\"float: left;margin-top: 20px;\">
					";
					if(file_exists("../$get_food_image_path/$get_food_image_b")){
						echo"<a href=\"../$get_food_image_path/$get_food_image_b\"><img src=\"../$get_food_image_path/$get_food_image_b\" alt=\"$get_food_image_b\" width=\"500\" height=\"500\" /></a>";
					}
					echo"
				</div>
			<!-- //Img -->

			<!-- Numbers -->
				<div style=\"float: left;margin-right: 20px;\">
					<form method=\"post\" action=\"edit_food_numbers_hundred.php?food_id=$food_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
				
					
					<p>
					<a href=\"edit_food_numbers_hundred.php?food_id=$food_id&amp;l=$l\" style=\"font-weight:bold;\">$l_enter_per_hundred</a>
					&middot;
					<a href=\"edit_food_numbers_pcs.php?food_id=$food_id&amp;l=$l\">$l_enter_per $get_food_serving_size_pcs $get_food_serving_size_pcs_measurement</a>
					</p>


			<table class=\"hor-zebra\" style=\"width: 350px\">
			 <thead>
			  <tr>
			   <th scope=\"col\">
			   </th>
			   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;vertical-align: bottom;\">
				<span>$l_per_100</span>
			   </th>
			   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;vertical-align: bottom;\">
				<span>$l_per $get_food_serving_size_pcs_measurement</span>
			   </th>
			  </tr>
			 </thead>
			 <tbody>
			  <tr>
			   <td style=\"padding: 8px 4px 6px 8px;\">
				<span>$l_calories</span>
			   </td>
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<span><input type=\"text\" name=\"inp_food_energy\" value=\"$get_food_energy\" size=\"3\" /></span>
			   </td>
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<span class=\"food_energy_calculated\">$get_food_energy_calculated</span>

				<!-- On change energy calculate -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_food_energy\"]').on(\"change paste keyup\", function() {
						var energy_hundred = $('[name=\"inp_food_energy\"]').val();
						energy_hundred = energy_hundred.replace(\",\", \".\");
						energy_calculated = Math.round((energy_hundred*$get_food_serving_size_gram)/100);
						\$(\".food_energy_calculated\").text(energy_calculated);
					});
				});
				</script>

				<!-- On change energy calculate -->
			   </td>
			  </tr>
			  <tr>
			   <td style=\"padding: 8px 4px 6px 8px;\">
				<p style=\"margin:0;padding: 0px 0px 4px 0px;\">$l_fat:</p>
				<p style=\"margin:0;padding: 0;\">$l_dash_of_which_saturated_fatty_acids</p>
			   </td>
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_food_fat\" value=\"$get_food_fat\" size=\"3\" /><br /></p>
				<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_food_fat_of_which_saturated_fatty_acids\" value=\"$get_food_fat_of_which_saturated_fatty_acids\" size=\"3\" /></p>
			   </td>
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><span class=\"food_fat_calculated\">$get_food_fat_calculated</span><br />
				<span class=\"food_fat_of_which_saturated_fatty_acids_calculated\">$get_food_fat_of_which_saturated_fatty_acids_calculated</span></p>

				<!-- On change fat calculate -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_food_fat\"]').on(\"change paste keyup\", function() {
						var fat_hundred = $('[name=\"inp_food_fat\"]').val();
						fat_hundred = fat_hundred.replace(\",\", \".\");
						fat_calculated = Math.round((fat_hundred*$get_food_serving_size_gram)/100);
						\$(\".food_fat_calculated\").text(fat_calculated);
					});
					\$('[name=\"inp_food_fat_of_which_saturated_fatty_acids\"]').on(\"change paste keyup\", function() {
						var food_fat_of_which_saturated_fatty_acids_hundred = $('[name=\"inp_food_fat_of_which_saturated_fatty_acids\"]').val();
						food_fat_of_which_saturated_fatty_acids_hundred = food_fat_of_which_saturated_fatty_acids_hundred.replace(\",\", \".\");
						food_fat_of_which_saturated_fatty_acids_calculated = Math.round((food_fat_of_which_saturated_fatty_acids_hundred*$get_food_serving_size_gram)/100);
						\$(\".food_fat_of_which_saturated_fatty_acids_calculated\").text(food_fat_of_which_saturated_fatty_acids_calculated);
					});
				});
				</script>
				<!-- On change fat calculate -->
			   </td>
			 </tr>
			 <tr>
		 	  <td style=\"padding: 8px 4px 6px 8px;\">
				<p style=\"margin:0;padding: 0px 0px 4px 0px;\">$l_carbs:</p>
				<p style=\"margin:0;padding: 0;\">$l_dash_of_which_sugars</p>
			   </td>
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_food_carbohydrates\" value=\"$get_food_carbohydrates\" size=\"3\" /></p>
				<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_food_carbohydrates_of_which_sugars\" value=\"$get_food_carbohydrates_of_which_sugars\" size=\"3\" /></p>
			   </td>
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><span class=\"food_carbohydrates_calculated\">$get_food_carbohydrates_calculated</span><br />
				<span class=\"food_carbohydrates_of_which_sugars_calculated\">$get_food_carbohydrates_of_which_sugars_calculated</span></p>

				<!-- On change fat calculate -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_food_carbohydrates\"]').on(\"change paste keyup\", function() {
						var food_carbohydrates_hundred = $('[name=\"inp_food_carbohydrates\"]').val();
						food_carbohydrates_hundred = food_carbohydrates_hundred.replace(\",\", \".\");
						food_carbohydrates_calculated = Math.round((food_carbohydrates_hundred*$get_food_serving_size_gram)/100);
						\$(\".food_carbohydrates_calculated\").text(food_carbohydrates_calculated);
					});
					\$('[name=\"inp_food_carbohydrates_of_which_sugars\"]').on(\"change paste keyup\", function() {
						var food_carbohydrates_of_which_sugars_hundred = $('[name=\"inp_food_carbohydrates_of_which_sugars\"]').val();
						food_carbohydrates_of_which_sugars_hundred = food_carbohydrates_of_which_sugars_hundred.replace(\",\", \".\");
						food_carbohydrates_of_which_sugars_calculated = Math.round((food_carbohydrates_of_which_sugars_hundred*$get_food_serving_size_gram)/100);
						\$(\".food_carbohydrates_of_which_sugars_calculated\").text(food_carbohydrates_of_which_sugars_calculated);
					});
				});
				</script>
				<!-- On change fat calculate -->
			   </td>
			  </tr>
			 <tr>
		 	  <td style=\"padding: 8px 4px 6px 8px;\">
				<p style=\"margin:0;padding: 0;\">$l_dietary_fiber:</p>
			   </td>
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<p style=\"margin:0px 0px 4px 0px;padding: 0;\"><input type=\"text\" name=\"inp_food_dietary_fiber\" value=\"$get_food_dietary_fiber\" size=\"3\" /></p>
			   </td>
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<span class=\"food_dietary_fiber_calculated\">$get_food_dietary_fiber_calculated</span>

				<!-- On change dietary fiber calculate -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_food_dietary_fiber\"]').on(\"change paste keyup\", function() {
						var food_dietary_fiber_hundred = $('[name=\"inp_food_dietary_fiber\"]').val();
						food_dietary_fiber_hundred = food_dietary_fiber_hundred.replace(\",\", \".\");
						food_dietary_fiber_calculated = Math.round((food_dietary_fiber_hundred*$get_food_serving_size_gram)/100);
						\$(\".food_dietary_fiber_calculated\").text(food_dietary_fiber_calculated);
					});
				});
				</script>
				<!-- On change dietary fiber calculate -->
			   </td>
			  </tr>
			  <tr>
			   <td style=\"padding: 8px 4px 6px 8px;\">
				<span>$l_protein:</span>
			   </td>
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<span><input type=\"text\" name=\"inp_food_proteins\" value=\"$get_food_proteins\" size=\"3\" /></span>
			   </td>
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<span class=\"food_proteins_calculated\">$get_food_proteins_calculated</span>
				<!-- On change protein calculate -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_food_proteins\"]').on(\"change paste keyup\", function() {
						var food_proteins_hundred = $('[name=\"inp_food_proteins\"]').val();
						food_proteins_hundred = food_proteins_hundred.replace(\",\", \".\");
						food_proteins_calculated = Math.round((food_proteins_hundred*$get_food_serving_size_gram)/100);
						\$(\".food_proteins_calculated\").text(food_proteins_calculated);
					});
				});
				</script>
				<!-- On change protein calculate -->
			   </td>
			  </tr>
			 </tr>
			  <tr>
			   <td style=\"padding: 8px 4px 6px 8px;\">
				<span>$l_salt_in_gram</span>
			   </td>
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<span><input type=\"text\" name=\"inp_food_salt\" value=\"$get_food_salt\" size=\"3\" /></span>
			   </td>
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<span class=\"food_salt_calculated\">$get_food_salt_calculated</span>
				<!-- On change salt calculate -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_food_salt\"]').on(\"change paste keyup\", function() {

						// Calculate salt pr pc
						var food_salt_hundred = \$('[name=\"inp_food_salt\"]').val();
						food_salt_hundred = food_salt_hundred.replace(\",\", \".\");
						food_salt_calculated = (food_salt_hundred*$get_food_serving_size_gram)/100;
						food_salt_calculated = food_salt_calculated.toFixed(2)
						\$(\".food_salt_calculated\").text(food_salt_calculated);

						// Calculate sodium (Sodium is 40 % of salt)
						food_sodium_hundred = (food_salt_hundred*40)/100; // g
						food_sodium_hundred = food_sodium_hundred*1000; // mg
						food_sodium_calculated = Math.round((food_sodium_hundred*$get_food_serving_size_gram)/100);
						\$(\".food_sodium_calculated\").text(food_sodium_calculated);
						\$('[name=\"inp_food_sodium\"]').val(Math.round(food_sodium_hundred));
						

					});
				});
				</script>
				<!-- On change salt calculate -->
			   </td>
			  </tr>
			  <tr>
			   <td style=\"padding: 8px 4px 6px 8px;\">
				<span>$l_sodium_in_mg</span>
			   </td>
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<span><input type=\"text\" name=\"inp_food_sodium\" value=\"$get_food_sodium\" size=\"3\" /></span>
			   </td>
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<span class=\"food_sodium_calculated\">$get_food_sodium_calculated</span>
				<!-- On change sodium calculate -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_food_sodium\"]').on(\"change paste keyup\", function() {
						var food_sodium_hundred = \$('[name=\"inp_food_sodium\"]').val();
						food_sodium_hundred = food_sodium_hundred.replace(\",\", \".\");
						food_sodium_calculated = (food_sodium_hundred*$get_food_serving_size_gram)/100;
						food_sodium_calculated = food_sodium_calculated.toFixed(2)
						\$(\".food_sodium_calculated\").text(food_sodium_calculated);
						
					});
				});
				</script>
				<!-- On change sodium calculate -->
			   </td>
			  </tr>
			 </tbody>
			</table>

					<p><input type=\"submit\" value=\"$l_save\" class=\"btn btn-success btn-sm\" /></p>
				</div>
			<!-- //Numbers -->

			<!-- Back -->
				<div class=\"clear\"></div>
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