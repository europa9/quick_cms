<?php 
/**
*
* File: food/new_food.php
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
	$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_description, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_fat, food_energy_calculated, food_proteins_calculated, food_carbohydrates_calculated, food_fat_calculated, food_barcode, food_category_id, food_image_path, food_thumb, food_image_a, food_image_b, food_image_c, food_image_d, food_image_e, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block FROM $t_food_index WHERE food_id=$food_id_mysql AND food_user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_description, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_fat, $get_food_energy_calculated, $get_food_proteins_calculated, $get_food_carbohydrates_calculated, $get_food_fat_calculated, $get_food_barcode, $get_food_category_id, $get_food_image_path, $get_food_thumb, $get_food_image_a, $get_food_image_b, $get_food_image_c, $get_food_image_d, $get_food_image_e, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block) = $row;

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

			$current_photo_path = "";
			
			if($image_number == "a" OR $image_number == ""){
				$image_number = "a";
				if(file_exists("../$get_food_image_path/$get_food_image_a")){
					$current_photo_path = "$get_food_image_path/$get_food_image_a";
				}
			}
			elseif($image_number == "b"){
				if(file_exists("../$get_food_image_path/$get_food_image_b")){
					$current_photo_path = "$get_food_image_path/$get_food_image_b";
				}
			}
			elseif($image_number == "c"){
				if(file_exists("../$get_food_image_path/$get_food_image_c")){
					$current_photo_path = "$get_food_image_path/$get_food_image_c";
				}
			}
			elseif($image_number == "d"){
				if(file_exists("../$get_food_image_path/$get_food_image_d")){
					$current_photo_path = "$get_food_image_path/$get_food_image_d";
				}
			}


			if($current_photo_path == ""){
				$url = "new_food_6_images_resize.php?main_category_id=$main_category_id&sub_category_id=$sub_category_id&food_id=$food_id&image_number=$image_number&l=$l&ft=error&fm=image_not_found";
				header("Location: $url");
				exit;
			}


			// Random id
			$seed = str_split('abcdefghijklmnopqrstuvwxyz'
			                 .'0123456789'); // and any other characters
			shuffle($seed); // probably optional since array_is randomized; this may be redundant
			$random_string = '';
			foreach (array_rand($seed, 2) as $k) $random_string .= $seed[$k];

			// extension
			$extension = getExtension($current_photo_path);
			$extension = strtolower($extension);


			// New name
			$inp_food_manufacturer_name = clean($get_food_manufacturer_name);
			$inp_food_name_clean = clean($get_food_name);

			$image_final_path = "../" . $get_food_image_path . "/" . $inp_food_manufacturer_name . "_" . $inp_food_name_clean . "_" . $random_string . "_" . $image_number . ".$extension";



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
   			imagepng($rotate, $image_final_path);



			// Free memory
			imagedestroy($source);
			imagedestroy($rotate); 

			// Delete old image

			unlink("../$current_photo_path");

			// Update
			if($extension == "jpg"){
				$inp_image = $inp_food_manufacturer_name . "_" . $inp_food_name_clean . "_" . $random_string . "_" . $image_number . ".jpg";
			}
			elseif($extension == "gif"){
				$inp_image = $inp_food_manufacturer_name . "_" . $inp_food_name_clean . "_" . $random_string . "_" . $image_number . ".gif";
			}
			else{
				$inp_image = $inp_food_manufacturer_name . "_" . $inp_food_name_clean . "_" . $random_string . "_" . $image_number . ".png";
			}
			$inp_image_mysql = quote_smart($link, $inp_image);

			if($image_number == "a" OR $image_number == ""){
				mysqli_query($link, "UPDATE $t_food_index SET food_image_a=$inp_image_mysql WHERE food_id=$food_id_mysql") or die(mysqli_error($link));
			}
			elseif($image_number == "b"){
				mysqli_query($link, "UPDATE $t_food_index SET food_image_b=$inp_image_mysql WHERE food_id=$food_id_mysql") or die(mysqli_error($link));
			}
			elseif($image_number == "c"){
				mysqli_query($link, "UPDATE $t_food_index SET food_image_c=$inp_image_mysql WHERE food_id=$food_id_mysql") or die(mysqli_error($link));
			}
			elseif($image_number == "d"){
				mysqli_query($link, "UPDATE $t_food_index SET food_image_d=$inp_image_mysql WHERE food_id=$food_id_mysql") or die(mysqli_error($link));
			}



			$url = "new_food_6_images_resize.php?main_category_id=$main_category_id&sub_category_id=$sub_category_id&food_id=$food_id&image_number=$image_number&l=$l&ft=success&fm=image_rotated";
			header("Location: $url");
			exit;

		}

	} // found
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