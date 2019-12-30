<?php 
/**
*
* File: food/new_food_6_images.php
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


/*- Settings ---------------------------------------------------------------------------- */
$settings_image_width = "847";
$settings_image_height = "847";



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


/*- Get extention ---------------------------------------------------------------------- */
function getExtension($str) {
		$i = strrpos($str,".");
		if (!$i) { return ""; } 
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l);
		return $ext;
}


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

if(isset($_GET['image_number'])){
	$image_number = $_GET['image_number'];
	$image_number = strip_tags(stripslashes($image_number));
	$image_number_mysql = quote_smart($link, $image_number);
}
else{
	$image_number = "";
}





$tabindex = 0;
$l_mysql = quote_smart($link, $l);



// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);

	// Select food
	$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_country, food_net_content, food_net_content_measurement, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_fat, food_fat_of_which_saturated_fatty_acids, food_carbohydrates, food_carbohydrates_of_which_dietary_fiber, food_carbohydrates_of_which_sugars, food_proteins, food_salt, food_score, food_energy_calculated, food_fat_calculated, food_fat_of_which_saturated_fatty_acids_calculated, food_carbohydrates_calculated, food_carbohydrates_of_which_dietary_fiber_calculated, food_carbohydrates_of_which_sugars_calculated, food_proteins_calculated, food_salt_calculated, food_barcode, food_category_id, food_image_path, food_thumb_small, food_thumb_medium, food_thumb_large, food_image_a, food_image_b, food_image_c, food_image_d, food_image_e, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_date, food_time, food_last_viewed FROM $t_food_index WHERE food_id=$food_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_manufacturer_name_and_food_name, $get_food_description, $get_food_country, $get_food_net_content, $get_food_net_content_measurement, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_fat, $get_food_fat_of_which_saturated_fatty_acids, $get_food_carbohydrates, $get_food_carbohydrates_of_which_dietary_fiber, $get_food_carbohydrates_of_which_sugars, $get_food_proteins, $get_food_salt, $get_food_score, $get_food_energy_calculated, $get_food_fat_calculated, $get_food_fat_of_which_saturated_fatty_acids_calculated, $get_food_carbohydrates_calculated, $get_food_carbohydrates_of_which_dietary_fiber_calculated, $get_food_carbohydrates_of_which_sugars_calculated, $get_food_proteins_calculated, $get_food_salt_calculated, $get_food_barcode, $get_food_category_id, $get_food_image_path, $get_food_thumb_small, $get_food_thumb_medium, $get_food_thumb_large, $get_food_image_a, $get_food_image_b, $get_food_image_c, $get_food_image_d, $get_food_image_e, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block, $get_food_user_ip, $get_food_date, $get_food_time, $get_food_last_viewed) = $row;

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
			
			// Clean name
			$food_name_clean = clean($get_food_name);
			$food_manufacturer_name_clean = clean($get_food_manufacturer_name);
			$store_dir = $food_manufacturer_name_clean . "_" . $get_food_clean_name;


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
			$year = date("Y");
			if(!(is_dir("../_uploads/food/_img/$l/$year"))){
				mkdir("../_uploads/food/_img/$l/$year");
			}
			if(!(is_dir("../_uploads/food/_img/$l/$year/$store_dir"))){
				mkdir("../_uploads/food/_img/$l/$year/$store_dir");
			}
				
			/*- Image upload ------------------------------------------------------------------------------------------ */
			$name = stripslashes($_FILES['inp_food_image']['name']);
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


					if($image_number == "a" OR $image_number == ""){
						$image_number = "a";
						$new_name = $food_manufacturer_name_clean . "_" . $food_name_clean . "_a." . $extension;
					}
					elseif($image_number == "b"){
						$new_name = $food_manufacturer_name_clean . "_" . $food_name_clean . "_b." . $extension;
					}
					elseif($image_number == "c"){
						$new_name = $food_manufacturer_name_clean . "_" . $food_name_clean . "_c." . $extension;
					}
					elseif($image_number == "d"){
						$new_name = $food_manufacturer_name_clean . "_" . $food_name_clean . "_d." . $extension;
					}
	
					$new_path = "../_uploads/food/_img/$l/$year/$store_dir/";
					$uploaded_file = $new_path . $new_name;
					// Upload file
					if (move_uploaded_file($_FILES['inp_food_image']['tmp_name'], $uploaded_file)) {

						// Get image size
						$file_size = filesize($uploaded_file);
						
						// Check with and height
						list($width,$height) = getimagesize($uploaded_file);
	
						if($width == "" OR $height == ""){
							$ft_image = "warning";
							$fm_image = "getimagesize_failed";
						}
						else{
							

							// Resize to 847x847
							$uploaded_file_new = $uploaded_file;
							if($width > 847 OR $height > 847){


								resize_crop_image($settings_image_width, $settings_image_height, $uploaded_file, $uploaded_file_new, $quality = 80);
							}				

							$inp_food_image_mysql = quote_smart($link, $new_name);

							if($image_number == "a" OR $image_number == ""){
								$result = mysqli_query($link, "UPDATE $t_food_index SET food_image_a=$inp_food_image_mysql WHERE food_id='$get_food_id'");
							}
							elseif($image_number == "b"){
								$result = mysqli_query($link, "UPDATE $t_food_index SET food_image_b=$inp_food_image_mysql WHERE food_id='$get_food_id'");
							}
							elseif($image_number == "c"){
								$result = mysqli_query($link, "UPDATE $t_food_index SET food_image_c=$inp_food_image_mysql WHERE food_id='$get_food_id'");
							}
							elseif($image_number == "d"){
								$result = mysqli_query($link, "UPDATE $t_food_index SET food_image_d=$inp_food_image_mysql WHERE food_id='$get_food_id'");
							}
		
								

						}  // if($width == "" OR $height == ""){
					} // move_uploaded_file
					else{
						switch ($_FILES['inp_food_image']['error']) {
							case UPLOAD_ERR_OK:
           							$fm_image = "There is no error, the file uploaded with success.";
								break;
							case UPLOAD_ERR_NO_FILE:
           							// $fm_image = "no_file_uploaded";
								break;
							case UPLOAD_ERR_INI_SIZE:
           							$fm_image = "to_big_size_in_configuration";
								break;
							case UPLOAD_ERR_FORM_SIZE:
           							$fm_image = "to_big_size_in_form";
								break;
							default:
           							$fm_image = "unknown_error";
								break;
						}	
					}
	
				} // extension check
			} // if($image){

			// Feedback
			if(isset($fm_image)){
				// Feedback with error
				$url = "new_food_6_images.php?main_category_id=$main_category_id&sub_category_id=$sub_category_id&food_id=$food_id&image_number=$image_number&l=$l";
				if(isset($fm_image)){
					$url = $url . "&fm_image=$fm_image";
				}
				header("Location: $url");
				exit;
			}
			else{
				// Feedback without error
				$url = "new_food_7_images_resize.php?main_category_id=$main_category_id&sub_category_id=$sub_category_id&food_id=$food_id&image_number=$image_number&l=$l";

				header("Location: $url");
				exit;
			}

		}


		echo"
		<h1>$get_food_manufacturer_name $get_food_name</h1>
		<!-- Feedback -->
			";
			if(isset($_GET['fm_image'])){
				echo"
				<div class=\"info\">
					<p>
					";
					if(isset($_GET['fm_image'])){
						$fm_image = $_GET['fm_image'];

						if($fm_image == "unknown_file_extension"){
							echo"Product image: Unknown file extension<br />\n";
						}
						elseif($fm_image == "getimagesize_failed"){
							echo"Product image: Could not get with and height of image<br />\n";
						}
						elseif($fm_image == "image_to_big"){
							echo"Product image: Image file size to big<br />\n";
						}
						elseif($fm_image == "to_big_size_in_configuration"){
							echo"Product image: Image file size to big (in config)<br />\n";
						}
						elseif($fm_image == "to_big_size_in_form"){
							echo"Product image: Image file size to big (in form)<br />\n";
						}
						elseif($fm_image == "unknown_error"){
							echo"Product image: Unknown error<br />\n";
						}

					}
				echo"
				</div>
				";
			}
			echo"
		<!-- //Feedback -->

		<!-- General information -->
			<!-- Focus -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_food_energy\"]').focus();
				});
				</script>
			<!-- //Focus -->

			<form method=\"post\" action=\"new_food_6_images.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$food_id&amp;l=$l&amp;image_number=$image_number&amp;process=1\" enctype=\"multipart/form-data\">
			";

			if($image_number == "a" OR $image_number == ""){
				echo"<h2>$l_upload_product_image</h2>";
			}
			elseif($image_number == "b"){
				echo"<h2>$l_upload_food_table_image</h2>";
			}
			elseif($image_number == "c"){
				echo"<h2>$l_upload_other_image</h2>";
			}
			elseif($image_number == "d"){
				echo"<h2>$l_upload_inspiration_image</h2>";
			}

			echo"

			<p>
			<b>$l_select_image (jpg $settings_image_width x $settings_image_height px)</b><br />
			<input type=\"file\" name=\"inp_food_image\" /> 
			<input type=\"submit\" value=\"$l_upload\" class=\"btn\" />
			</p>

			<p>
			<a href=\"new_food_7_tags.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$food_id&amp;l=$l\" class=\"btn_default\">$l_tags</a>
			<a href=\"new_food_8_stores.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$food_id&amp;l=$l\" class=\"btn_default\">$l_stores</a>
			<a href=\"view_food.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$food_id&amp;l=$l\" class=\"btn_default\">$l_view_food</a>
			</p>
				
		<!-- //General information -->

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