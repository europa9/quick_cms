<?php
/**
*
* File: food/new_food_5_images.php
* Version 1.0.0
* Date 19:40 18.10.2020
* Copyright (c) 2020 Sindre Andre Ditlefsen
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


/*- Settings ---------------------------------------------------------------------------- */
$settings_image_width = "847";
$settings_image_height = "847";


/*- Translations ---------------------------------------------------------------------- */
include("$root/_admin/_translations/site/$l/food/ts_new_food.php");

/*- Variables ------------------------------------------------------------------------- */
$l_mysql = quote_smart($link, $l);

if(isset($_GET['image'])){
	$image= $_GET['image'];
	$image = strip_tags(stripslashes($image));
}
else{
	$image = "";
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
$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_country, food_net_content_metric, food_net_content_measurement_metric, food_net_content_us, food_net_content_measurement_us, food_net_content_added_measurement, food_serving_size_metric, food_serving_size_measurement_metric, food_serving_size_us, food_serving_size_measurement_us, food_serving_size_added_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy_metric, food_fat_metric, food_saturated_fat_metric, food_monounsaturated_fat_metric, food_polyunsaturated_fat_metric, food_cholesterol_metric, food_carbohydrates_metric, food_carbohydrates_of_which_sugars_metric, food_dietary_fiber_metric, food_proteins_metric, food_salt_metric, food_sodium_metric, food_energy_us, food_fat_us, food_saturated_fat_us, food_monounsaturated_fat_us, food_polyunsaturated_fat_us, food_cholesterol_us, food_carbohydrates_us, food_carbohydrates_of_which_sugars_us, food_dietary_fiber_us, food_proteins_us, food_salt_us, food_sodium_us, food_score, food_energy_calculated_metric, food_fat_calculated_metric, food_saturated_fat_calculated_metric, food_monounsaturated_fat_calculated_metric, food_polyunsaturated_fat_calculated_metric, food_cholesterol_calculated_metric, food_carbohydrates_calculated_metric, food_carbohydrates_of_which_sugars_calculated_metric, food_dietary_fiber_calculated_metric, food_proteins_calculated_metric, food_salt_calculated_metric, food_sodium_calculated_metric, food_energy_calculated_us, food_fat_calculated_us, food_saturated_fat_calculated_us, food_monounsaturated_fat_calculated_us, food_polyunsaturated_fat_calculated_us, food_cholesterol_calculated_us, food_carbohydrates_calculated_us, food_carbohydrates_of_which_sugars_calculated_us, food_dietary_fiber_calculated_us, food_proteins_calculated_us, food_salt_calculated_us, food_sodium_calculated_us, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_thumb_a_medium, food_thumb_a_large, food_image_b, food_thumb_b_small, food_thumb_b_medium, food_thumb_b_large, food_image_c, food_thumb_c_small, food_thumb_c_medium, food_thumb_c_large, food_image_d, food_thumb_d_small, food_thumb_d_medium, food_thumb_d_large, food_image_e, food_thumb_e_small, food_thumb_e_medium, food_thumb_e_large, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_created_date, food_last_viewed, food_age_restriction FROM $t_food_index WHERE food_id=$food_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_food_id, $get_current_food_user_id, $get_current_food_name, $get_current_food_clean_name, $get_current_food_manufacturer_name, $get_current_food_manufacturer_name_and_food_name, $get_current_food_description, $get_current_food_country, $get_current_food_net_content_metric, $get_current_food_net_content_measurement_metric, $get_current_food_net_content_us, $get_current_food_net_content_measurement_us, $get_current_food_net_content_added_measurement, $get_current_food_serving_size_metric, $get_current_food_serving_size_measurement_metric, $get_current_food_serving_size_us, $get_current_food_serving_size_measurement_us, $get_current_food_serving_size_added_measurement, $get_current_food_serving_size_pcs, $get_current_food_serving_size_pcs_measurement, $get_current_food_energy_metric, $get_current_food_fat_metric, $get_current_food_saturated_fat_metric, $get_current_food_monounsaturated_fat_metric, $get_current_food_polyunsaturated_fat_metric, $get_current_food_cholesterol_metric, $get_current_food_carbohydrates_metric, $get_current_food_carbohydrates_of_which_sugars_metric, $get_current_food_dietary_fiber_metric, $get_current_food_proteins_metric, $get_current_food_salt_metric, $get_current_food_sodium_metric, $get_current_food_energy_us, $get_current_food_fat_us, $get_current_food_saturated_fat_us, $get_current_food_monounsaturated_fat_us, $get_current_food_polyunsaturated_fat_us, $get_current_food_cholesterol_us, $get_current_food_carbohydrates_us, $get_current_food_carbohydrates_of_which_sugars_us, $get_current_food_dietary_fiber_us, $get_current_food_proteins_us, $get_current_food_salt_us, $get_current_food_sodium_us, $get_current_food_score, $get_current_food_energy_calculated_metric, $get_current_food_fat_calculated_metric, $get_current_food_saturated_fat_calculated_metric, $get_current_food_monounsaturated_fat_calculated_metric, $get_current_food_polyunsaturated_fat_calculated_metric, $get_current_food_cholesterol_calculated_metric, $get_current_food_carbohydrates_calculated_metric, $get_current_food_carbohydrates_of_which_sugars_calculated_metric, $get_current_food_dietary_fiber_calculated_metric, $get_current_food_proteins_calculated_metric, $get_current_food_salt_calculated_metric, $get_current_food_sodium_calculated_metric, $get_current_food_energy_calculated_us, $get_current_food_fat_calculated_us, $get_current_food_saturated_fat_calculated_us, $get_current_food_monounsaturated_fat_calculated_us, $get_current_food_polyunsaturated_fat_calculated_us, $get_current_food_cholesterol_calculated_us, $get_current_food_carbohydrates_calculated_us, $get_current_food_carbohydrates_of_which_sugars_calculated_us, $get_current_food_dietary_fiber_calculated_us, $get_current_food_proteins_calculated_us, $get_current_food_salt_calculated_us, $get_current_food_sodium_calculated_us, $get_current_food_barcode, $get_current_food_main_category_id, $get_current_food_sub_category_id, $get_current_food_image_path, $get_current_food_image_a, $get_current_food_thumb_a_small, $get_current_food_thumb_a_medium, $get_current_food_thumb_a_large, $get_current_food_image_b, $get_current_food_thumb_b_small, $get_current_food_thumb_b_medium, $get_current_food_thumb_b_large, $get_current_food_image_c, $get_current_food_thumb_c_small, $get_current_food_thumb_c_medium, $get_current_food_thumb_c_large, $get_current_food_image_d, $get_current_food_thumb_d_small, $get_current_food_thumb_d_medium, $get_current_food_thumb_d_large, $get_current_food_image_e, $get_current_food_thumb_e_small, $get_current_food_thumb_e_medium, $get_current_food_thumb_e_large, $get_current_food_last_used, $get_current_food_language, $get_current_food_synchronized, $get_current_food_accepted_as_master, $get_current_food_notes, $get_current_food_unique_hits, $get_current_food_unique_hits_ip_block, $get_current_food_comments, $get_current_food_likes, $get_current_food_dislikes, $get_current_food_likes_ip_block, $get_current_food_user_ip, $get_current_food_created_date, $get_current_food_last_viewed, $get_current_food_age_restriction) = $row;

if($get_current_food_id == ""){
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
	$website_title = "$l_food - $get_current_food_name $get_current_food_manufacturer_name";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");





	// My user
	if(isset($_SESSION['user_id'])){
		$my_user_id = $_SESSION['user_id'];
		$my_user_id_mysql = quote_smart($link, $my_user_id);

		if($get_current_food_user_id != "$my_user_id"){
			echo"
			<p>Access denied.</p>
			";
		}
		else{

			if($action == "" && $image != ""){
				if($process == "1"){
					// Upload
					// Delete all old thumbnails
					if($image == "a"){
					if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_a_small") && $get_current_food_thumb_a_small != ""){
						unlink("../$get_current_food_image_path/$get_current_food_thumb_a_small");
					}
					if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_a_medium") && $get_current_food_thumb_a_medium != ""){
						unlink("../$get_current_food_image_path/$get_current_food_thumb_a_medium");
					}
					if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_a_large") && $get_current_food_thumb_a_large != ""){
						unlink("../$get_current_food_image_path/$get_current_food_thumb_a_large");
					}
					}
					elseif($image == "b"){
					if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_b_small") && $get_current_food_thumb_b_small != ""){
						unlink("../$get_current_food_image_path/$get_current_food_thumb_b_small");
					}
					if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_b_medium") && $get_current_food_thumb_b_medium != ""){
						unlink("../$get_current_food_image_path/$get_current_food_thumb_b_medium");
					}
					if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_b_large") && $get_current_food_thumb_b_large != ""){
						unlink("../$get_current_food_image_path/$get_current_food_thumb_b_large");
					}
					}
					elseif($image == "c"){
					if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_c_small") && $get_current_food_thumb_c_small != ""){
						unlink("../$get_current_food_image_path/$get_current_food_thumb_c_small");
					}
					if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_c_medium") && $get_current_food_thumb_c_medium != ""){
						unlink("../$get_current_food_image_path/$get_current_food_thumb_c_medium");
					}
					if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_c_large") && $get_current_food_thumb_c_large != ""){
						unlink("../$get_current_food_image_path/$get_current_food_thumb_c_large");
					}
					}
					elseif($image == "d"){
					if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_d_small") && $get_current_food_thumb_d_small != ""){
						unlink("../$get_current_food_image_path/$get_current_food_thumb_d_small");
					}
					if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_d_medium") && $get_current_food_thumb_d_medium != ""){
						unlink("../$get_current_food_image_path/$get_current_food_thumb_d_medium");
					}
					if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_d_large") && $get_current_food_thumb_d_large != ""){
						unlink("../$get_current_food_image_path/$get_current_food_thumb_d_large");
					}
					}

					// Clean name
					$food_name_clean = clean($get_current_food_name);
					$food_manufacturer_name_clean = clean($get_current_food_manufacturer_name);

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
					if(!(is_dir("../_uploads/food/_img/$l"))){
						mkdir("../_uploads/food/_img/$l");
					}
					if(!(is_dir("../_uploads/food/_img/$l/$get_current_food_id"))){
						mkdir("../_uploads/food/_img/$l/$get_current_food_id");
					}
				
					/*- Image upload ------------------------------------------------------------------------------------------ */
					$name = stripslashes($_FILES['inp_image']['name']);
					$extension = get_extension($name);
					$extension = strtolower($extension);

					if($name){
						if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
							$ft_image_a = "warning";
							$fm_image_a = "unknown_file_extension";
						}
						else{
					
 
							// Give new name
							$food_manufacturer_name_clean = clean($get_current_food_manufacturer_name);

							
							$new_name = $food_manufacturer_name_clean . "_" . $food_name_clean . "_" . $image . "." . $extension;
						
							$new_path = "../_uploads/food/_img/$l/$get_current_food_id/";
							$uploaded_file = $new_path . $new_name;
							// Upload file
							if (move_uploaded_file($_FILES['inp_image']['tmp_name'], $uploaded_file)) {

								// Get image size
								$file_size = filesize($uploaded_file);
						
								// Check with and height
								list($width,$height) = getimagesize($uploaded_file);
	
								if($width == "" OR $height == ""){
									$ft = "warning";
									$fm = "getimagesize_failed";
								}
								else{

									// Resize to 847x847
									$uploaded_file_new = $uploaded_file;
									if($width > 847 OR $height > 847){
										resize_crop_image($settings_image_width, $settings_image_height, $uploaded_file, $uploaded_file_new, $quality = 80);
									}

									$inp_food_image_path = "_uploads/food/_img/$l/$get_current_food_id";
									$inp_food_image_path = output_html($inp_food_image_path);
									$inp_food_image_path_mysql = quote_smart($link, $inp_food_image_path);
									$inp_food_image_mysql = quote_smart($link, $new_name);

									// Thumb small
									$inp_thumb_name = str_replace(".$extension", "", $new_name);
									$inp_thumb_small = $inp_thumb_name . "_thumb_132x132." . $extension;
									$inp_thumb_small_mysql = quote_smart($link, $inp_thumb_small);
									resize_crop_image(132, 132, "$root/_uploads/food/_img/$l/$get_current_food_id/$new_name", "$root/_uploads/food/_img/$l/$get_current_food_id/$inp_thumb_small");
							

									// Thumb medium
									$inp_thumb_medium = $inp_thumb_name . "_thumb_200x200." . $extension;
									$inp_thumb_medium_mysql = quote_smart($link, $inp_thumb_medium);
									resize_crop_image(200, 200, "$root/_uploads/food/_img/$l/$get_current_food_id/$new_name", "$root/_uploads/food/_img/$l/$get_current_food_id/$inp_thumb_medium");
							

									// Logo over image
									// Config
									include("$root/_admin/_data/food.php");
									if($foodPrintLogoOnImagesSav == "1"){
										include("$root/_admin/_functions/stamp_image.php");
										include("$root/_admin/_data/logo.php");
										$stamp = "$logoFileStampImages1280x720Sav";
										list($width,$height) = getimagesize("$root/_uploads/food/_img/$l/$get_current_food_id/$new_name");

										if($width < 1280){ // Width less than 1280
											$stamp = "$logoFileStampImages1280x720Sav";
										}
										elseif($width > 1280 && $width < 1920){  // Width bigger than 1280 and less than 1920
											$stamp = "$logoFileStampImages1920x1080Sav";
										}
										elseif($width > 1921 && $width < 2560){
											$stamp = "$logoFileStampImages2560x1440Sav";
										}
										else{
											$stamp = "$logoFileStampImages7680x4320Sav";
										}
										stamp_image("$root/_uploads/food/_img/$l/$get_current_food_id/$new_name", "$root/$logoPathSav/$stamp");
									}

	

									if($image == "a"){
										$result = mysqli_query($link, "UPDATE $t_food_index SET 
														food_image_path=$inp_food_image_path_mysql, 
														food_image_a=$inp_food_image_mysql, 
														food_thumb_a_small=$inp_thumb_small_mysql, 
														food_thumb_a_medium=$inp_thumb_medium_mysql,
														food_thumb_a_large='' WHERE food_id='$get_current_food_id'");
									}
									elseif($image == "b"){
										$result = mysqli_query($link, "UPDATE $t_food_index SET food_image_path=$inp_food_image_path_mysql, food_image_b=$inp_food_image_mysql, food_thumb_b_small=$inp_thumb_small_mysql, food_thumb_b_medium=$inp_thumb_medium_mysql, food_thumb_b_large='' WHERE food_id='$get_current_food_id'");
									}
									elseif($image == "c"){
										$result = mysqli_query($link, "UPDATE $t_food_index SET food_image_path=$inp_food_image_path_mysql, food_image_c=$inp_food_image_mysql, food_thumb_c_small=$inp_thumb_small_mysql, food_thumb_c_medium=$inp_thumb_medium_mysql, food_thumb_c_large='' WHERE food_id='$get_current_food_id'");
									}
									elseif($image == "d"){
										$result = mysqli_query($link, "UPDATE $t_food_index SET food_image_path=$inp_food_image_path_mysql, food_image_d=$inp_food_image_mysql, food_thumb_d_small=$inp_thumb_small_mysql, food_thumb_d_medium=$inp_thumb_medium_mysql, food_thumb_d_large='' WHERE food_id='$get_current_food_id'");
									}
									elseif($image == "e"){
										$result = mysqli_query($link, "UPDATE $t_food_index SET food_image_path=$inp_food_image_path_mysql, food_image_e=$inp_food_image_mysql, food_thumb_e_small=$inp_thumb_small_mysql, food_thumb_e_medium=$inp_thumb_medium_mysql, food_thumb_e_large='' WHERE food_id='$get_current_food_id'");
									}
							
           								$ft = "success";
									$fm = "image_uploaded";

								}  // if($width == "" OR $height == ""){
							} // move_uploaded_file
							else{
           							$ft = "error";
								switch ($_FILES['inp_food_image']['error']) {
									case UPLOAD_ERR_OK:
           									$fm = "There is no error, the file uploaded with success.";
										break;
									case UPLOAD_ERR_NO_FILE:
           									// $fm_image = "no_file_uploaded";
										break;
									case UPLOAD_ERR_INI_SIZE:
           									$fm = "to_big_size_in_configuration";
										break;
									case UPLOAD_ERR_FORM_SIZE:
           									$fm = "to_big_size_in_form";
										break;
									default:
           									$fm = "unknown_error";
										break;
								}	
							}
	
						} // extension check
					} // if($image){
					else{
           					$ft = "error";
						$fm = "no_image_selected";
					}


					// Search engine
					include("new_food_00_add_update_search_engine.php");

					// Feedback
					$url = "new_food_5_images.php?main_category_id=$get_current_food_main_category_id&sub_category_id=$get_current_food_sub_category_id&food_id=$get_current_food_id&image=$image&ft=$ft&fm=$fm&l=$l";
					header("Location: $url");
					exit;

				} // process == 1 (upload)

				echo"
				<h1>$get_current_food_manufacturer_name $get_current_food_name</h1>

				<!-- Feedback -->
					";
					if($ft != ""){
						if($fm == "changes_saved"){
							$fm = "$l_changes_saved";
						}
						else{
							$fm = ucfirst(str_replace("_", " ", $fm));
						}
						echo"<div class=\"$ft\"><span>$fm</span></div>";
					}
					echo"	
				<!-- //Feedback -->

				<!-- Image x -->
					";
					if($image == "a"){
						echo"<h2>$l_product_image</h2>\n";
					}
					elseif($image == "b"){
						echo"<h2>$l_food_table_image</h2>\n";
					}
					elseif($image == "c"){
						echo"<h2>$l_barcode_image</h2>\n";
					}
					elseif($image == "d"){
						echo"<h2>$l_inspiration_image</h2>\n";
					}
					else{
						echo"<h2>Unknown image</h2>\n";
						die;
					}
					echo"
					<!-- New image -->

						<!-- Focus -->
							<script>
							\$(document).ready(function(){
								\$('[name=\"inp_image\"]').focus();
							});
							</script>
						<!-- //Focus -->

						<form method=\"post\" action=\"new_food_5_images.php?main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;image=$image&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

						<p>
						<b>$l_select_product_image (jpg $settings_image_width x $settings_image_height px)</b><br />
						<input type=\"file\" name=\"inp_image\" /> 
						<input type=\"submit\" value=\"$l_upload\" class=\"btn\" />
						</p>
						</form>
					<!-- //New image -->


					<p>";
					if($image == "a"){
						if($get_current_food_image_a != ""){
							// Thumb A medium
							if(!(file_exists("../$get_current_food_image_path/$get_current_food_thumb_a_medium")) OR $get_current_food_thumb_a_medium == ""){
								$ext = get_extension("$get_current_food_image_a");
								$inp_thumb_name = str_replace(".$ext", "", $get_current_food_image_a);
								$get_current_food_thumb_a_medium = $inp_thumb_name . "_thumb_200x200." . $ext;
								$inp_food_thumb_a_medium_mysql = quote_smart($link, $get_current_food_thumb_a_medium);
								$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb_a_medium=$inp_food_thumb_a_medium_mysql WHERE food_id=$get_current_food_id") or die(mysqli_error($link));
								resize_crop_image(200, 200, "$root/$get_current_food_image_path/$get_current_food_image_a", "$root/$get_current_food_image_path/$get_current_food_thumb_a_medium");
							}
							echo"
							<a href=\"$root/$get_current_food_image_path/$get_current_food_image_a\"><img src=\"$root/$get_current_food_image_path/$get_current_food_thumb_a_medium\" alt=\"$get_current_food_thumb_a_medium\" /></a><br />
							<a href=\"new_food_5_images.php?action=rotate&amp;main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;image=$image&amp;l=$l&amp;process=1\" class=\"btn btn_default\">$l_rotate</a>
							";
						}
					} // A
					elseif($image == "b"){
						if($get_current_food_image_b != ""){
							// Thumb B medium
							if(!(file_exists("../$get_current_food_image_path/$get_current_food_thumb_b_medium")) OR $get_current_food_thumb_b_medium == ""){
								$ext = get_extension("$get_current_food_image_b");
								$inp_thumb_name = str_replace(".$ext", "", $get_current_food_image_b);
								$get_current_food_thumb_b_medium = $inp_thumb_name . "_thumb_200x200." . $ext;
								$inp_food_thumb_b_medium_mysql = quote_smart($link, $get_current_food_thumb_b_medium);
								$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb_b_medium=$inp_food_thumb_b_medium_mysql WHERE food_id=$get_current_food_id") or die(mysqli_error($link));
								resize_crop_image(200, 200, "$root/$get_current_food_image_path/$get_current_food_image_b", "$root/$get_current_food_image_path/$get_current_food_thumb_b_medium");
							}
							echo"
							<a href=\"$root/$get_current_food_image_path/$get_current_food_image_b\"><img src=\"$root/$get_current_food_image_path/$get_current_food_thumb_b_medium\" alt=\"$get_current_food_thumb_b_medium\" /></a><br />
							<a href=\"new_food_5_images.php?action=rotate&amp;main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;image=$image&amp;l=$l&amp;process=1\" class=\"btn_default\">$l_rotate</a>
							";
						}
					} // B
					elseif($image == "c"){
						if($get_current_food_image_c != ""){
							// Thumb C medium
							if(!(file_exists("../$get_current_food_image_path/$get_current_food_thumb_c_medium")) OR $get_current_food_thumb_c_medium == ""){
								$ext = get_extension("$get_current_food_image_c");
								$inp_thumb_name = str_replace(".$ext", "", $get_current_food_image_c);
								$get_current_food_thumb_c_medium = $inp_thumb_name . "_thumb_200x200." . $ext;
								$inp_food_thumb_c_medium_mysql = quote_smart($link, $get_current_food_thumb_c_medium);
								$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb_c_medium=$inp_food_thumb_c_medium_mysql WHERE food_id=$get_current_food_id") or die(mysqli_error($link));
								resize_crop_image(200, 200, "$root/$get_current_food_image_path/$get_current_food_image_c", "$root/$get_current_food_image_path/$get_current_food_thumb_c_medium");
							}
							echo"
							<a href=\"$root/$get_current_food_image_path/$get_current_food_image_c\"><img src=\"$root/$get_current_food_image_path/$get_current_food_thumb_c_medium\" alt=\"$get_current_food_thumb_c_medium\" /></a><br />
							<a href=\"new_food_5_images.php?action=rotate&amp;main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;image=$image&amp;l=$l&amp;process=1\" class=\"btn_default\">$l_rotate</a>
							";
						}
					} // C
					elseif($image == "d"){
						if($get_current_food_image_d != ""){
							// Thumb D medium
							if(!(file_exists("../$get_current_food_image_path/$get_current_food_thumb_d_medium")) OR $get_current_food_thumb_d_medium == ""){
								$ext = get_extension("$get_current_food_image_d");
								$inp_thumb_name = str_replace(".$ext", "", $get_current_food_image_d);
								$get_current_food_thumb_d_medium = $inp_thumb_name . "_thumb_200x200." . $ext;
								$inp_food_thumb_d_medium_mysql = quote_smart($link, $get_current_food_thumb_d_medium);
								$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb_d_medium=$inp_food_thumb_d_medium_mysql WHERE food_id=$get_current_food_id") or die(mysqli_error($link));
								resize_crop_image(200, 200, "$root/$get_current_food_image_path/$get_current_food_image_d", "$root/$get_current_food_image_path/$get_current_food_thumb_d_medium");
							}
							echo"
							<a href=\"$root/$get_current_food_image_path/$get_current_food_image_d\"><img src=\"$root/$get_current_food_image_path/$get_current_food_thumb_d_medium\" alt=\"$get_current_food_thumb_d_medium\" /></a><br />
							<a href=\"new_food_5_images.php?action=rotate&amp;main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;image=$image&amp;l=$l&amp;process=1\" class=\"btn_default\">$l_rotate</a>
							";
						}
					} // D
					echo"
					</p>
				<!-- //Image x -->

				<!-- Next -->
					<p>";
					if($image == "a"){
						echo"
						<a href=\"new_food_5_images.php?main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;image=b&amp;l=$l\"><img src=\"_gfx/icons/go-next.png\" alt=\"go-next.png\" /></a>
						<a href=\"new_food_5_images.php?main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;image=b&amp;l=$l\">$l_upload_food_table_image</a>
						";
					}
					elseif($image == "b"){
						echo"
						<a href=\"new_food_5_images.php?main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;image=c&amp;l=$l\"><img src=\"_gfx/icons/go-next.png\" alt=\"go-next.png\" /></a>
						<a href=\"new_food_5_images.php?main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;image=c&amp;l=$l\">$l_upload_image_of_barcode</a>
						";
					}
					elseif($image == "c"){
						echo"
						<a href=\"new_food_5_images.php?main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;image=d&amp;l=$l\"><img src=\"_gfx/icons/go-next.png\" alt=\"go-next.png\" /></a>
						<a href=\"new_food_5_images.php?main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;image=d&amp;l=$l\">$l_upload_inspiration_image</a>
						";
					}
					elseif($image == "d"){
						if($get_current_food_country == "United States"){
							echo"
							<a href=\"new_food_6_serving_size.php?main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;l=$l\"><img src=\"_gfx/icons/go-next.png\" alt=\"go-next.png\" /></a>
							<a href=\"new_food_6_serving_size.php?main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;l=$l\">$l_serving_size</a>
							";
						}
						else{
							echo"
							<a href=\"new_food_6_serving_size.php?main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;l=$l\"><img src=\"_gfx/icons/go-next.png\" alt=\"go-next.png\" /></a>
							<a href=\"new_food_6_serving_size.php?main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;food_id=$get_current_food_id&amp;l=$l\">$l_serving_size</a>
							";
						}
					}
					echo"
					</p>
				<!-- //Next -->
				";
			} // action == ""
			elseif($action == "rotate" && $process == 1 && $image != ""){
			
				// Delete all old thumbnails
				if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_a_small") && $get_current_food_thumb_a_small != ""){
					unlink("../$get_current_food_image_path/$get_current_food_thumb_a_small");
				}
				if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_a_medium") && $get_current_food_thumb_a_medium != ""){
					unlink("../$get_current_food_image_path/$get_current_food_thumb_a_medium");
				}
				if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_a_large") && $get_current_food_thumb_a_large != ""){
					unlink("../$get_current_food_image_path/$get_current_food_thumb_a_large");
				}
				if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_b_small") && $get_current_food_thumb_b_small != ""){
					unlink("../$get_current_food_image_path/$get_current_food_thumb_b_small");
				}
				if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_b_medium") && $get_current_food_thumb_b_medium != ""){
					unlink("../$get_current_food_image_path/$get_current_food_thumb_b_medium");
				}
				if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_b_large") && $get_current_food_thumb_b_large != ""){
					unlink("../$get_current_food_image_path/$get_current_food_thumb_b_large");
				}
				if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_c_small") && $get_current_food_thumb_c_small != ""){
					unlink("../$get_current_food_image_path/$get_current_food_thumb_c_small");
				}
				if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_c_medium") && $get_current_food_thumb_c_medium != ""){
					unlink("../$get_current_food_image_path/$get_current_food_thumb_c_medium");
				}
				if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_c_large") && $get_current_food_thumb_c_large != ""){
					unlink("../$get_current_food_image_path/$get_current_food_thumb_c_large");
				}
				if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_d_small") && $get_current_food_thumb_d_small != ""){
					unlink("../$get_current_food_image_path/$get_current_food_thumb_d_small");
				}
				if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_d_medium") && $get_current_food_thumb_d_medium != ""){
					unlink("../$get_current_food_image_path/$get_current_food_thumb_d_medium");
				}
				if(file_exists("../$get_current_food_image_path/$get_current_food_thumb_d_large") && $get_current_food_thumb_d_large != ""){
					unlink("../$get_current_food_image_path/$get_current_food_thumb_d_large");
				}

				// Current photo
				if($image == "a"){
					$current_photo_path = "$get_current_food_image_path/$get_current_food_image_a";
				}
				elseif($image == "b"){
					$current_photo_path = "$get_current_food_image_path/$get_current_food_image_b";
				}
				elseif($image == "c"){
					$current_photo_path = "$get_current_food_image_path/$get_current_food_image_c";
				}
				elseif($image == "d"){
					$current_photo_path = "$get_current_food_image_path/$get_current_food_image_d";
				}
				elseif($image == "e"){
					$current_photo_path = "$get_current_food_image_path/$get_current_food_image_e";
				}

				// Random id
				$seed = str_split('abcdefghijklmnopqrstuvwxyz' . '0123456789');
				shuffle($seed); // probably optional since array_is randomized; this may be redundant
				$random_string = '';
				foreach (array_rand($seed, 2) as $k) $random_string .= $seed[$k];

				// extension
				$extension = get_extension($current_photo_path);
				$extension = strtolower($extension);

				// New name
				$inp_food_manufacturer_name = clean($get_current_food_manufacturer_name);
				$inp_food_name_clean = clean($get_current_food_name);

				$image_final_path = "../" . $get_current_food_image_path . "/" . $inp_food_manufacturer_name . "_" . $inp_food_name_clean . "_" . $random_string . "_" . $image . ".$extension";


				// Load
				if($extension == "jpg"){
					$source = imagecreatefromjpeg("../$current_photo_path");
				}
				elseif($extension == "gif"){
					$source = ImageCreateFromGif("../$current_photo_path");
				}
				else{
					$source = ImageCreateFromPNG("../$current_photo_path");
				}


				$original_x = imagesx($source);
				$original_y = imagesy($source);

				$bgColor = imagecolorallocatealpha($source, 255, 255, 255, 127);
   
				// Rotate
   				$rotate = imagerotate($source, 270, $bgColor);
   				imagesavealpha($rotate, true);

				if($extension == "jpg"){
					imagejpeg($rotate, $image_final_path);
				}
				elseif($extension == "gif"){
					imagegif($rotate, $image_final_path);
				}
				else{
					imagepng($rotate, $image_final_path);
				}

   				



				// Free memory
				imagedestroy($source);
				imagedestroy($rotate); 

				// Delete old image
				unlink("../$current_photo_path");

				// Update
				if($extension == "jpg"){
					$inp_image = $inp_food_manufacturer_name . "_" . $inp_food_name_clean . "_" . $random_string . "_" . $image . ".jpg";
				}
				elseif($extension == "gif"){
					$inp_image = $inp_food_manufacturer_name . "_" . $inp_food_name_clean . "_" . $random_string . "_" . $image . ".gif";
				}
				else{
					$inp_image = $inp_food_manufacturer_name . "_" . $inp_food_name_clean . "_" . $random_string . "_" . $image . ".png";
				}
				$inp_image_mysql = quote_smart($link, $inp_image);


				if($image == "a"){
					mysqli_query($link, "UPDATE $t_food_index SET food_image_a=$inp_image_mysql, food_thumb_a_small='', food_thumb_a_medium='', food_thumb_a_large='' WHERE food_id=$food_id_mysql") or die(mysqli_error($link));
				}
				elseif($image == "b"){
					mysqli_query($link, "UPDATE $t_food_index SET food_image_b=$inp_image_mysql, food_thumb_b_small='', food_thumb_b_medium='', food_thumb_b_large='' WHERE food_id=$food_id_mysql") or die(mysqli_error($link));
				}
				elseif($image == "c"){
					mysqli_query($link, "UPDATE $t_food_index SET food_image_c=$inp_image_mysql, food_thumb_c_small='', food_thumb_c_medium='', food_thumb_c_large='' WHERE food_id=$food_id_mysql") or die(mysqli_error($link));
				}
				elseif($image == "d"){
					mysqli_query($link, "UPDATE $t_food_index SET food_image_d=$inp_image_mysql, food_thumb_d_small='', food_thumb_d_medium='', food_thumb_d_large='' WHERE food_id=$food_id_mysql") or die(mysqli_error($link));
				}
				elseif($image == "e"){
					mysqli_query($link, "UPDATE $t_food_index SET food_image_e=$inp_image_mysql, food_thumb_e_small='', food_thumb_e_medium='', food_thumb_e_large='' WHERE food_id=$food_id_mysql") or die(mysqli_error($link));
				}

				

				$url = "new_food_5_images.php?main_category_id=$get_current_food_main_category_id&sub_category_id=$get_current_food_sub_category_id&food_id=$food_id&image=$image&l=$l&ft=success&fm=image_rotated&image=$image";
				header("Location: $url");
				exit;
			} // action == "rotate"
		} // access ok
	} // logged in
	else{
		echo"<p>Please log in</p>";
	}
} // food found
/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>