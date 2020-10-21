<?php 
/**
*
* File: food/new_food_4_serving_size_other.php
* Version 1.0.0
* Date 23:59 27.11.2017
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
include("$root/_admin/_translations/site/$l/food/ts_food.php");
include("$root/_admin/_translations/site/$l/food/ts_new_food.php");


/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['mode'])){
	$mode = $_GET['mode'];
	$mode = output_html($mode);
}
else{
	$mode = "";
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
if(isset($_GET['food_id'])){
	$food_id = $_GET['food_id'];
	$food_id = strip_tags(stripslashes($food_id));
	$food_id_mysql = quote_smart($link, $food_id);
}
else{
	$food_id = "";
}




$tabindex = 0;
$l_mysql = quote_smart($link, $l);



// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);

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
		$website_title = "$l_food - $l_new_food - $get_food_name $get_food_manufacturer_name";
		if(file_exists("./favicon.ico")){ $root = "."; }
		elseif(file_exists("../favicon.ico")){ $root = ".."; }
		elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
		elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
		include("$root/_webdesign/header.php");

		/*- Content ---------------------------------------------------------------------------------- */

		// Process
		if($process == "1"){

			$inp_food_net_content = $_POST['inp_food_net_content'];
			$inp_food_net_content = output_html($inp_food_net_content);
			$inp_food_net_content = str_replace(",", ".", $inp_food_net_content);
			$inp_food_net_content_mysql = quote_smart($link, $inp_food_net_content);
			if(empty($inp_food_net_content)){
				$ft = "error";
				$fm = "missing_net_content";
			}
			else{
				if(!(is_numeric($inp_food_net_content))){
					$ft = "error";
					$fm = "net_content_is_not_numeric";
				}
			}

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

			$inp_food_description = $_POST['inp_food_description'];
			$inp_food_description = output_html($inp_food_description);
			$inp_food_description_mysql = quote_smart($link, $inp_food_description);

			if($ft == ""){

				// Calculate per pcs
				$inp_food_energy_calculated = round($get_food_energy*$inp_food_serving_size_gram/100, 0);
				$inp_food_fat_calculated = round($get_food_fat*$inp_food_serving_size_gram/100, 0);
				$inp_food_fat_of_which_saturated_fatty_acids_calculated = round($get_food_fat_of_which_saturated_fatty_acids*$inp_food_serving_size_gram/100, 0);
				$inp_food_carbohydrates_calculated = round($get_food_carbohydrates*$inp_food_serving_size_gram/100, 0);
				$inp_food_carbohydrates_of_which_dietary_fiber_calculated = round($get_food_carbohydrates_of_which_dietary_fiber*$inp_food_serving_size_gram/100, 0);
				$inp_food_carbohydrates_of_which_sugars_calculated = round($get_food_carbohydrates_of_which_sugars*$inp_food_serving_size_gram/100, 0);
				$inp_food_proteins_calculated = round($get_food_proteins*$inp_food_serving_size_gram/100, 0);
				$inp_food_salt_calculated = round($get_food_salt*$inp_food_serving_size_gram/100, 0);
				$inp_food_sodium_calculated = round($get_food_sodium*$inp_food_serving_size_gram/100, 0);
				
				
	
				// Update food_id
				$result = mysqli_query($link, "UPDATE $t_food_index SET 
								food_description=$inp_food_description_mysql, 
								food_net_content=$inp_food_net_content_mysql, 
								food_net_content_measurement=$inp_food_net_content_measurement_mysql, 
								food_serving_size_gram=$inp_food_serving_size_gram_mysql, 
								food_serving_size_gram_measurement=$inp_food_serving_size_gram_measurement_mysql, 
								food_serving_size_pcs=$inp_food_serving_size_pcs_mysql, 
								food_serving_size_pcs_measurement=$inp_food_serving_size_pcs_measurement_mysql,
								food_energy_calculated='$inp_food_energy_calculated', 
								food_fat_calculated='$inp_food_fat_calculated',
								food_fat_of_which_saturated_fatty_acids_calculated='$inp_food_fat_of_which_saturated_fatty_acids_calculated',
								food_carbohydrates_calculated='$inp_food_carbohydrates_calculated',
								food_carbohydrates_of_which_dietary_fiber_calculated=$inp_food_carbohydrates_of_which_dietary_fiber_calculated, 
								food_carbohydrates_of_which_sugars_calculated='$inp_food_carbohydrates_of_which_sugars_calculated',
								food_proteins_calculated='$inp_food_proteins_calculated',
								food_salt_calculated='$inp_food_salt_calculated',
								food_sodium_calculated='$inp_food_sodium_calculated' 
								WHERE food_id='$get_food_id'") or die(mysqli_error($link));


				$url = "new_food_7_tags.php?main_category_id=$main_category_id&sub_category_id=$sub_category_id&food_id=$get_food_id&el=$l";
				header("Location: $url");
				exit;
			}
			else{
				$url = "new_food_6_serving_size_other.php?main_category_id=$main_category_id&sub_category_id=$sub_category_id&food_id=$get_food_id&l=$l";
				$url = $url . "&ft=$ft&fm=$fm";
				$url = $url . "&inp_food_name=$inp_food_name";
				$url = $url . "&inp_food_manufacturer_name=$inp_food_manufacturer_name";
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
		<h1>$get_food_name - $get_food_country</h1>
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


			<!-- Serving size form -->
				<div style=\"float: left;\">
	
					<!-- Focus -->
					<script>
						\$(document).ready(function(){
							\$('[name=\"inp_food_net_content\"]').focus();
						});
					</script>
					<!-- //Focus -->

					<form method=\"post\" action=\"new_food_6_serving_size_other.php?food_id=$food_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

					<table>
					 <tr>
					  <td style=\"text-align: right;padding: 0px 4px 0px 0px;vertical-align:top;\">
						<p><b>$l_net_content*:</b></p>
					  </td>
					  <td>
						<p><input type=\"text\" name=\"inp_food_net_content\" value=\"$get_food_net_content\" size=\"3\" />
				
						<select name=\"inp_food_net_content_measurement\">
							<option value=\"g\""; if($get_food_net_content_measurement == "g"){ echo" selected=\"selected\""; } echo">g</option>
							<option value=\"ml\""; if($get_food_net_content_measurement == "ml"){ echo" selected=\"selected\""; } echo">ml</option>
						</select><br />
						<span class=\"small\">$l_how_much_does_an_entire_package_weighs<br />
						$l_if_it_is_fruit_then_enter_the_weight_of_one_piece<br />
						$l_example_one_banana_one_tomato_one_iceberg_lettuce_etc</span>
						</p>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"text-align: right;padding: 0px 4px 0px 0px;vertical-align:top;\">
						<p><b>$l_serving*:</b></p>
					  </td>
					  <td>
						<p><input type=\"text\" name=\"inp_food_serving_size_gram\" value=\"$get_food_serving_size_gram\" size=\"3\" />
						<select name=\"inp_food_serving_size_gram_measurement\">
							<option value=\"g\""; if($get_food_serving_size_gram_measurement == "g"){ echo" selected=\"selected\""; } echo">g</option>
							<option value=\"ml\""; if($get_food_serving_size_gram_measurement == "ml"){ echo" selected=\"selected\""; } echo">ml</option>
						</select><br />
						<span class=\"small\">$l_examples_g_ml</span>
						</p>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"text-align: right;padding: 0px 4px 0px 0px;vertical-align:top;\">
						<p><b>$l_serving_pcs*:</b></p> 
					  </td>
					  <td>
						<p><input type=\"text\" name=\"inp_food_serving_size_pcs\" value=\"$get_food_serving_size_pcs\" size=\"3\" />
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
						<span class=\"small\">$l_examples_package_slice_pcs_plate</span>
						</p>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"text-align: right;padding: 0px 4px 0px 0px;vertical-align:top;\">
						<p><b>$l_description:</b></p> 
					  </td>
					  <td>
						<p><input type=\"text\" name=\"inp_food_description\" value=\"$get_food_description\" size=\"35\" />
						</p>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
						
					  </td>
					  <td>
						<p><input type=\"submit\" value=\"$l_save\" class=\"btn btn-success btn-sm\" /></p>
					  </td>
					 </tr>
					</table>
					</form>
				</div>
			<!-- Serving size form -->

			<!-- Food image -->
			";
				if(file_exists("$root/$get_food_image_path/$get_food_image_a") && $get_food_image_a != ""){
					echo"
					<span style=\"float: left;margin-right: 20px;\">
					<img src=\"$root/$get_food_image_path/$get_food_image_a\" alt=\"$root/$get_food_image_path/$get_food_image_a\" width=\"600\" height=\"600\" />
					</span>
					";
				}
				if(file_exists("$root/$get_food_image_path/$get_food_image_b") && $get_food_image_b != ""){
					echo"
					<span style=\"float: left;margin-right: 20px;\">
					<img src=\"$root/$get_food_image_path/$get_food_image_b\" alt=\"$root/$get_food_image_path/$get_food_image_b\" width=\"600\" height=\"600\" />
					</span>
					";
				}
			echo"
			<!-- //Food image -->
				

		";
	} // mode == ""
}
else{
	echo"
	<h1>
	<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/index.php?page=login&amp;l=$l&amp;refer=$root/food/new_food.php\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>