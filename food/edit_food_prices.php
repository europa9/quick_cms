<?php
/**
*
* File: food/edit_food_prices.php
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

/*- Tables ---------------------------------------------------------------------------- */
include("_tables_food.php");


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
}
else{
	$food_id = "";
}
$food_id_mysql = quote_smart($link, $food_id);


if(isset($_GET['price_id'])){
	$price_id = $_GET['price_id'];
	$price_id = strip_tags(stripslashes($price_id));
}
else{
	$price_id = "";
}
$price_id_mysql = quote_smart($link, $price_id);

$food_id_mysql = quote_smart($link, $food_id);


// Select food
$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_country, food_net_content_metric, food_net_content_measurement_metric, food_net_content_us_system, food_net_content_measurement_us_system, food_net_content_added_measurement, food_serving_size_metric, food_serving_size_measurement_metric, food_serving_size_us_system, food_serving_size_measurement_us_system, food_serving_size_added_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy_metric, food_fat_metric, food_fat_of_which_saturated_fatty_acids_metric, food_monounsaturated_fat_metric, food_polyunsaturated_fat_metric, food_cholesterol_metric, food_carbohydrates_metric, food_carbohydrates_of_which_sugars_metric, food_dietary_fiber_metric, food_proteins_metric, food_salt_metric, food_sodium_metric, food_energy_us_system, food_fat_us_system, food_fat_of_which_saturated_fatty_acids_us_system, food_monounsaturated_fat_us_system, food_polyunsaturated_fat_us_system, food_cholesterol_us_system, food_carbohydrates_us_system, food_carbohydrates_of_which_sugars_us_system, food_dietary_fiber_us_system, food_proteins_us_system, food_salt_us_system, food_sodium_us_system, food_score, food_energy_calculated_metric, food_fat_calculated_metric, food_fat_of_which_saturated_fatty_acids_calculated_metric, food_monounsaturated_fat_calculated_metric, food_polyunsaturated_fat_calculated_metric, food_carbohydrates_calculated_metric, food_carbohydrates_of_which_sugars_calculated_metric, food_dietary_fiber_calculated_metric, food_proteins_calculated_metric, food_salt_calculated_metric, food_sodium_calculated_metric, food_energy_calculated_us_system, food_fat_calculated_us_system, food_fat_of_which_saturated_fatty_acids_calculated_us_system, food_monounsaturated_fat_calculated_us_system, food_polyunsaturated_fat_calculated_us_system, food_carbohydrates_calculated_us_system, food_carbohydrates_of_which_sugars_calculated_us_system, food_dietary_fiber_calculated_us_system, food_proteins_calculated_us_system, food_salt_calculated_us_system, food_sodium_calculated_us_system, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_thumb_a_medium, food_thumb_a_large, food_image_b, food_thumb_b_small, food_thumb_b_medium, food_thumb_b_large, food_image_c, food_thumb_c_small, food_thumb_c_medium, food_thumb_c_large, food_image_d, food_thumb_d_small, food_thumb_d_medium, food_thumb_d_large, food_image_e, food_thumb_e_small, food_thumb_e_medium, food_thumb_e_large, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_created_date, food_last_viewed, food_age_restriction FROM $t_food_index WHERE food_id=$food_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_manufacturer_name_and_food_name, $get_food_description, $get_food_country, $get_food_net_content_metric, $get_food_net_content_measurement_metric, $get_food_net_content_us_system, $get_food_net_content_measurement_us_system, $get_food_net_content_added_measurement, $get_food_serving_size_metric, $get_food_serving_size_measurement_metric, $get_food_serving_size_us_system, $get_food_serving_size_measurement_us_system, $get_food_serving_size_added_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy_metric, $get_food_fat_metric, $get_food_fat_of_which_saturated_fatty_acids_metric, $get_food_monounsaturated_fat_metric, $get_food_polyunsaturated_fat_metric, $get_food_cholesterol_metric, $get_food_carbohydrates_metric, $get_food_carbohydrates_of_which_sugars_metric, $get_food_dietary_fiber_metric, $get_food_proteins_metric, $get_food_salt_metric, $get_food_sodium_metric, $get_food_energy_us_system, $get_food_fat_us_system, $get_food_fat_of_which_saturated_fatty_acids_us_system, $get_food_monounsaturated_fat_us_system, $get_food_polyunsaturated_fat_us_system, $get_food_cholesterol_us_system, $get_food_carbohydrates_us_system, $get_food_carbohydrates_of_which_sugars_us_system, $get_food_dietary_fiber_us_system, $get_food_proteins_us_system, $get_food_salt_us_system, $get_food_sodium_us_system, $get_food_score, $get_food_energy_calculated_metric, $get_food_fat_calculated_metric, $get_food_fat_of_which_saturated_fatty_acids_calculated_metric, $get_food_monounsaturated_fat_calculated_metric, $get_food_polyunsaturated_fat_calculated_metric, $get_food_carbohydrates_calculated_metric, $get_food_carbohydrates_of_which_sugars_calculated_metric, $get_food_dietary_fiber_calculated_metric, $get_food_proteins_calculated_metric, $get_food_salt_calculated_metric, $get_food_sodium_calculated_metric, $get_food_energy_calculated_us_system, $get_food_fat_calculated_us_system, $get_food_fat_of_which_saturated_fatty_acids_calculated_us_system, $get_food_monounsaturated_fat_calculated_us_system, $get_food_polyunsaturated_fat_calculated_us_system, $get_food_carbohydrates_calculated_us_system, $get_food_carbohydrates_of_which_sugars_calculated_us_system, $get_food_dietary_fiber_calculated_us_system, $get_food_proteins_calculated_us_system, $get_food_salt_calculated_us_system, $get_food_sodium_calculated_us_system, $get_food_barcode, $get_food_main_category_id, $get_food_sub_category_id, $get_food_image_path, $get_food_image_a, $get_food_thumb_a_small, $get_food_thumb_a_medium, $get_food_thumb_a_large, $get_food_image_b, $get_food_thumb_b_small, $get_food_thumb_b_medium, $get_food_thumb_b_large, $get_food_image_c, $get_food_thumb_c_small, $get_food_thumb_c_medium, $get_food_thumb_c_large, $get_food_image_d, $get_food_thumb_d_small, $get_food_thumb_d_medium, $get_food_thumb_d_large, $get_food_image_e, $get_food_thumb_e_small, $get_food_thumb_e_medium, $get_food_thumb_e_large, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block, $get_food_user_ip, $get_food_created_date, $get_food_last_viewed, $get_food_age_restriction) = $row;

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
			if($action == ""){
				if($process == "1"){
				
					$inp_price = $_POST['inp_price'];
					$inp_price = output_html($inp_price);
					$inp_price = str_replace(",", ".", $inp_price);
					$inp_price_mysql = quote_smart($link, $inp_price);
					if($inp_price == ""){
						$url = "edit_food_prices.php?food_id=$get_food_id&l=$l&ft=error&fm=missing_price";
						header("Location: $url");
						exit;
					}

					// Currency
					$inp_currency = $_POST['inp_currency'];
					$inp_currency = output_html($inp_currency);
					$inp_currency_mysql = quote_smart($link, $inp_currency);

					$query = "SELECT currency_id, currency_last_used_language FROM $t_food_prices_currencies WHERE currency_code=$inp_currency_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_currency_id, $get_currency_last_used_language) = $row;
					if($get_currency_id != ""){
						if($get_currency_last_used_language != "$l"){
							$l_mysql = quote_smart($link, $l);
							// First reset, then update the correct one
							mysqli_query($link, "UPDATE $t_food_prices_currencies SET currency_last_used_language='' WHERE currency_last_used_language=$l_mysql") or die(mysqli_error($link));
							mysqli_query($link, "UPDATE $t_food_prices_currencies SET currency_last_used_language=$l_mysql WHERE currency_id=$get_currency_id") or die(mysqli_error($link));
							
						} 
					}

					// Store
					if(!(isset($_POST['inp_store_id']))){
						$url = "edit_food_prices.php?food_id=$get_food_id&l=$l&ft=error&fm=no_store_selected_please_add_stores";
						header("Location: $url");
						exit;
					}
					$inp_store_id = $_POST['inp_store_id'];
					$inp_store_id = output_html($inp_store_id);
					$inp_store_id_mysql = quote_smart($link, $inp_store_id);
					if($inp_store_id == ""){
						$url = "edit_food_prices.php?food_id=$get_food_id&l=$l&ft=error&fm=missing_store";
						header("Location: $url");
						exit;
					}

					$query = "SELECT store_id, store_name FROM $t_food_stores WHERE store_id=$inp_store_id_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_store_id, $get_store_name) = $row;
					if($get_store_id == ""){
						echo"Store not found $query ";die;
					}
					$inp_store_name_mysql = quote_smart($link, $get_store_name);

					// Offer
					if(isset($_POST['inp_offer'])){
						$inp_offer = "1";
					}
					else{
						$inp_offer = "0";
					}
					$inp_offer_mysql = quote_smart($link, $inp_offer);


					// IP 
					$inp_my_ip = $_SERVER['REMOTE_ADDR'];
					$inp_my_ip = output_html($inp_my_ip);
					$inp_my_ip_mysql = quote_smart($link, $inp_my_ip);
	
					// Datetime (notes)
					$datetime = date("Y-m-d H:i:s");
					$datetime_print = date("j M Y");

				
					// Insert price
					mysqli_query($link, "INSERT INTO $t_food_index_prices
					(food_price_id, food_price_food_id, food_price_store_id, food_price_store_name, food_price_price, food_price_currency, food_price_offer, food_price_user_id, food_price_user_ip, 
					food_price_added_datetime, food_price_added_datetime_print, food_price_updated, food_price_updated_print) 
					VALUES 
					(NULL, $get_food_id, $inp_store_id_mysql,  $inp_store_name_mysql, $inp_price_mysql, $inp_currency_mysql, $inp_offer_mysql, $my_user_id_mysql, $inp_my_ip_mysql,
					'$datetime', '$datetime_print', '$datetime', '$datetime_print')")
					or die(mysqli_error($link));


			
					$url = "edit_food_prices.php?food_id=$get_food_id&l=$l&ft=success&fm=changes_saved";
					header("Location: $url");
					exit;
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
					<a href=\"edit_food_stores.php?food_id=$food_id&amp;l=$l\">$l_stores</a>
					</p>
				<!-- //Where am I? -->


				<!-- Feedback -->
				";
				if($ft != "" && $fm != ""){
					if($fm == "changes_saved"){
						$fm = "$l_changes_saved";
					}
					elseif($fm == "price_deleted"){
						$fm = "$l_price_deleted";
					}
					else{
						$fm = ucfirst($fm);
					}
					echo"<div class=\"$ft\"><p>$fm</p></div>";	
				}
				echo"
				<!-- //Feedback -->

				<!-- Add price -->
					<h2>$l_new_price</h2>
					<form method=\"post\" action=\"edit_food_prices.php?food_id=$food_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
					<script>
					\$(document).ready(function(){
						\$('[name=\"inp_price\"]').focus();
					});
					</script>

					
					<p>$l_price:<br />
					<input type=\"text\" name=\"inp_price\" value=\"\" size=\"4\" />
					<select name=\"inp_currency\">";

					$query = "SELECT currency_id, currency_name, currency_code, currency_symbol, currency_last_used_language FROM $t_food_prices_currencies ORDER BY currency_code ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_currency_id, $get_currency_name, $get_currency_code, $get_currency_symbol, $get_currency_last_used_language) = $row;


						echo"						";
						echo"<option value=\"$get_currency_code\""; if($get_currency_last_used_language == "$l"){ echo" selected=\"selected\""; } echo">$get_currency_code</option>\n";
					}
					echo"</select>
					</p>

					<p>$l_store:<br />
					<select name=\"inp_store_id\">\n";
					$x = 0;
					$query = "SELECT food_store_id, food_store_store_id, food_store_store_name FROM $t_food_index_stores WHERE food_store_food_id=$get_food_id ORDER BY food_store_store_name ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_food_store_id, $get_food_store_store_id, $get_food_store_store_name) = $row;
						echo"						";
						echo"<option value=\"$get_food_store_store_id\">$get_food_store_store_name</option>\n";
						$x++;
					}
					echo"
					</select>
					</p>
					";
					if($x == "0"){
						// No stores for this product. Add stores first
						echo"<div class=\"info\"><p>$l_please_add_stores_for_the_product_before_prices</p></div>
    						<meta http-equiv=\"refresh\" content=\"0;URL='edit_food_stores.php?food_id=$get_food_id&amp;l=$l'\" />";
					}
					echo"

					<p>
					<input type=\"checkbox\" name=\"inp_offer\" /> $l_offer
					</p>

					<p><input type=\"submit\" value=\"$l_save_price\" class=\"btn_default\" /></p>
					
					</form>
				<!-- //Add price -->

				<!-- Price history -->
					<hr />
					<h2>$l_price_history</h2>
					<table>
					";
					
					$query = "SELECT food_price_id, food_price_food_id, food_price_store_id, food_price_store_name, food_price_price, food_price_currency, food_price_offer, food_price_user_id, food_price_user_ip, food_price_added_datetime, food_price_added_datetime_print, food_price_updated, food_price_updated_print FROM $t_food_index_prices WHERE food_price_food_id='$get_food_id' ORDER BY food_price_id DESC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_food_price_id, $get_food_price_food_id, $get_food_price_store_id, $get_food_price_store_name, $get_food_price_price, $get_food_price_currency, $get_food_price_offer, $get_food_price_user_id, $get_food_price_user_ip, $get_food_price_added_datetime, $get_food_price_added_datetime_print, $get_food_price_updated, $get_food_price_updated_print) = $row;
						echo"
						 <tr>
						  <td style=\"vertical-align: top;padding: 15px 15px 15px 0px;border-bottom: #ccc 1px solid;\">
							<span>$get_food_price_added_datetime_print</span>
						  </td>
						  <td style=\"vertical-align: top;padding: 15px 15px 15px 0px;border-bottom: #ccc 1px solid;\">
							<span>$get_food_price_store_name</span>
						  </td>
						  <td style=\"vertical-align: top;padding: 15px 15px 15px 0px;border-bottom: #ccc 1px solid;\">
							<span>$get_food_price_price</spanp>
						  </td>
						  <td style=\"vertical-align: top;padding: 15px 15px 15px 0px;border-bottom: #ccc 1px solid;\">
							<span>";
							if($get_food_price_user_id == "$my_user_id"){
								echo"
								<a href=\"edit_food_prices.php?food_id=$food_id&amp;action=edit_price&amp;price_id=$get_food_price_id&amp;l=$l\">$l_edit</a>
								&middot;
								<a href=\"edit_food_prices.php?food_id=$food_id&amp;action=delete_price&amp;price_id=$get_food_price_id&amp;l=$l\">$l_delete</a>
								";
							}
							echo"
							</span>	
						  </td>
						 </tr>
						";
					}

					echo"
					</table>
				<!-- //Price history -->
				<!-- Back -->
					<p>
					<a href=\"my_food.php?l=$l#food$get_food_id\" class=\"btn btn_default\">$l_my_food</a>
					</p>
				<!-- //Back -->

				";
			} // action
			elseif($action == "edit_price"){
				// Select price
				$query = "SELECT food_price_id, food_price_food_id, food_price_store_id, food_price_store_name, food_price_price, food_price_currency, food_price_offer, food_price_offer_valid_from, food_price_offer_valid_to, food_price_user_id, food_price_user_ip, food_price_added_datetime, food_price_added_datetime_print, food_price_updated, food_price_updated_print, food_price_reported, food_price_reported_checked FROM $t_food_index_prices WHERE food_price_id=$price_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_food_price_id, $get_food_price_food_id, $get_food_price_store_id, $get_food_price_store_name, $get_food_price_price, $get_food_price_currency, $get_food_price_offer, $get_food_price_offer_valid_from, $get_food_price_offer_valid_to, $get_food_price_user_id, $get_food_price_user_ip, $get_food_price_added_datetime, $get_food_price_added_datetime_print, $get_food_price_updated, $get_food_price_updated_print, $get_food_price_reported, $get_food_price_reported_checked) = $row;

				if($get_food_price_id == ""){
					echo"<p>Price not found..</p>";
				}
				else{
					
					if($get_food_price_user_id == "$my_user_id"){
						if($process == "1"){

							$inp_price = $_POST['inp_price'];
							$inp_price = output_html($inp_price);
							$inp_price = str_replace(",", ".", $inp_price);
							$inp_price_mysql = quote_smart($link, $inp_price);
							if($inp_price == ""){
								$url = "edit_food_prices.php?food_id=$get_food_id&l=$l&ft=error&fm=missing_price";
								header("Location: $url");
								exit;
							}
		
							// Currency
							$inp_currency = $_POST['inp_currency'];
							$inp_currency = output_html($inp_currency);
							$inp_currency_mysql = quote_smart($link, $inp_currency);

							$query = "SELECT currency_id, currency_last_used_language FROM $t_food_prices_currencies WHERE currency_code=$inp_currency_mysql";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_currency_id, $get_currency_last_used_language) = $row;
							
					
							// Store
							$inp_store_id = $_POST['inp_store_id'];
							$inp_store_id = output_html($inp_store_id);
							$inp_store_id_mysql = quote_smart($link, $inp_store_id);

							$query = "SELECT store_id, store_name FROM $t_food_stores WHERE store_id=$inp_store_id_mysql";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_store_id, $get_store_name) = $row;
							if($get_store_id == ""){
								echo"Store not found $query ";die;
							}
							$inp_store_name_mysql = quote_smart($link, $get_store_name);

							// Offer
							if(isset($_POST['inp_offer'])){
								$inp_offer = "1";
							}
							else{
								$inp_offer = "0";
							}
							$inp_offer_mysql = quote_smart($link, $inp_offer);


							// IP 
							$inp_my_ip = $_SERVER['REMOTE_ADDR'];
							$inp_my_ip = output_html($inp_my_ip);
							$inp_my_ip_mysql = quote_smart($link, $inp_my_ip);
	
							// Datetime
							$datetime = date("Y-m-d H:i:s");
							$datetime_print = date("j M Y");

							mysqli_query($link, "UPDATE $t_food_index_prices SET food_price_store_id=$inp_store_id_mysql,
							food_price_store_name=$inp_store_name_mysql, food_price_price=$inp_price_mysql, food_price_currency=$inp_currency_mysql, food_price_offer=$inp_offer_mysql, 
							food_price_user_id=$my_user_id_mysql, food_price_user_ip=$inp_my_ip_mysql, food_price_updated='$datetime', food_price_updated_print='$datetime_print' WHERE food_price_id=$get_food_price_id") or die(mysqli_error($link));
							

							$url = "edit_food_prices.php?food_id=$food_id&action=edit_price&price_id=$get_food_price_id&l=$l&ft=success&fm=changes_saved";
							header("Location: $url");
							exit;

						}
						echo"
						<h1>$l_edit_price</h1>

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


						
						<form method=\"post\" action=\"edit_food_prices.php?food_id=$food_id&amp;action=edit_price&amp;price_id=$get_food_price_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_price\"]').focus();
						});
						</script>

					
						<p>$l_price:<br />
						<input type=\"text\" name=\"inp_price\" value=\"$get_food_price_price\" size=\"4\" />
						<select name=\"inp_currency\">";

						$query = "SELECT currency_id, currency_name, currency_code, currency_symbol, currency_last_used_language FROM $t_food_prices_currencies ORDER BY currency_code ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_currency_id, $get_currency_name, $get_currency_code, $get_currency_symbol, $get_currency_last_used_language) = $row;


							echo"						";
							echo"<option value=\"$get_currency_code\""; if($get_currency_code == "$get_food_price_currency"){ echo" selected=\"selected\""; } echo">$get_currency_code</option>\n";
						}
						echo"</select>
						</p>
	
						<p>$l_store:<br />
						<select name=\"inp_store_id\">\n";
						$query = "SELECT food_store_id, food_store_store_id, food_store_store_name FROM $t_food_index_stores WHERE food_store_food_id=$get_food_id ORDER BY food_store_store_name ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_food_store_id, $get_food_store_store_id, $get_food_store_store_name) = $row;
							echo"						";
							echo"<option value=\"$get_food_store_store_id\""; if($get_food_store_store_id == "$get_food_price_store_id"){ echo" selected=\"selected\""; } echo">$get_food_store_store_name</option>\n";
						}
						echo"
						</select>
						</p>

						<p>
						<input type=\"checkbox\" name=\"inp_offer\""; if($get_food_price_offer == "1"){ echo" checked=\"checked\""; } echo" /> $l_offer
						</p>

						<p><input type=\"submit\" value=\"$l_save_price\" class=\"btn_default\" /></p>
					
						</form>


						<!-- Back -->
							<p>
							<a href=\"edit_food_prices.php?food_id=$food_id&amp;l=$l\"><img src=\"_gfx/icons/go-previous.png\" alt=\"go-previous.png\" /></a>
							<a href=\"edit_food_prices.php?food_id=$food_id&amp;l=$l\">$l_prices</a>
							</p>
						<!-- //Back -->
						";
					}
					else{
						echo"<p>Access to price denied.</p";
					} // price access
				} // price found
			} // edit_price
			elseif($action == "delete_price"){

				// Select price
				$query = "SELECT food_price_id, food_price_food_id, food_price_store_id, food_price_store_name, food_price_price, food_price_currency, food_price_offer, food_price_offer_valid_from, food_price_offer_valid_to, food_price_user_id, food_price_user_ip, food_price_added_datetime, food_price_added_datetime_print, food_price_updated, food_price_updated_print, food_price_reported, food_price_reported_checked FROM $t_food_index_prices WHERE food_price_id=$price_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_food_price_id, $get_food_price_food_id, $get_food_price_store_id, $get_food_price_store_name, $get_food_price_price, $get_food_price_currency, $get_food_price_offer, $get_food_price_offer_valid_from, $get_food_price_offer_valid_to, $get_food_price_user_id, $get_food_price_user_ip, $get_food_price_added_datetime, $get_food_price_added_datetime_print, $get_food_price_updated, $get_food_price_updated_print, $get_food_price_reported, $get_food_price_reported_checked) = $row;

				if($get_food_price_id == ""){
					echo"<p>Price not found..</p>";
				}
				else{
					
					if($get_food_price_user_id == "$my_user_id"){
						if($process == "1"){

							
							mysqli_query($link, "DELETE FROM $t_food_index_prices WHERE food_price_id=$get_food_price_id") or die(mysqli_error($link));
							

							$url = "edit_food_prices.php?food_id=$food_id&l=$l&ft=success&fm=price_deleted";
							header("Location: $url");
							exit;

						}
						echo"
						<h1>$l_delete_price</h1>

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

						<p>
						$l_are_you_sure
						</p>

						<p><a href=\"edit_food_prices.php?food_id=$food_id&amp;action=delete_price&amp;price_id=$get_food_price_id&amp;l=$l&amp;process=1\" class=\"btn_warning\">$l_yes</a>

						<!-- Back -->
							<p>
							<a href=\"edit_food_prices.php?food_id=$food_id&amp;l=$l\"><img src=\"_gfx/icons/go-previous.png\" alt=\"go-previous.png\" /></a>
							<a href=\"edit_food_prices.php?food_id=$food_id&amp;l=$l\">$l_prices</a>
							</p>
						<!-- //Back -->
						";
					}
					else{
						echo"<p>Access to price denied.</p";
					} // price access
				} // price found
			} // delete_price
		} // access
	}
	else{
		echo"<p>Please log in</p>";
	}
}
/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>