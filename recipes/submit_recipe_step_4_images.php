<?php 
/**
*
* File: recipes/submit_recipe_step_4_images.php
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
include("$root/_admin/_translations/site/$l/recipes/ts_recipes.php");


/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['recipe_id'])){
	$recipe_id = $_GET['recipe_id'];
	$recipe_id = output_html($recipe_id);
}
else{
	$recipe_id = "";
}

$tabindex = 0;
$l_mysql = quote_smart($link, $l);

/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_recipes - $l_submit_recipe";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Functions -------------------------------------------------------------------------------- */
function delete_cache($dirname) {
	if (is_dir($dirname))
		$dir_handle = opendir($dirname);
	if (!$dir_handle)
		return false;
	while($file = readdir($dir_handle)) {
		if ($file != "." && $file != "..") {
			if (!is_dir($dirname."/".$file))
  				unlink($dirname."/".$file);
        		else
				delete_cache($dirname.'/'.$file);    
			}
		}
	closedir($dir_handle);
	rmdir($dirname);
	return true;
}
// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	

	// Get recipe
	$recipe_id_mysql = quote_smart($link, $recipe_id);
	$inp_recipe_user_id = $_SESSION['user_id'];
	$inp_recipe_user_id = output_html($inp_recipe_user_id);
	$inp_recipe_user_id_mysql = quote_smart($link, $inp_recipe_user_id);
	$query = "SELECT recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_image_path, recipe_image, recipe_thumb, recipe_video FROM $t_recipes WHERE recipe_user_id=$inp_recipe_user_id_mysql AND recipe_id=$recipe_id_mysql AND recipe_user_id=$inp_recipe_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_recipe_id, $get_recipe_user_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb, $get_recipe_video) = $row;

	if($get_recipe_id == ""){
		echo"
		<h1>Server error</h1>

		<p>
		Recipe not found.
		</p>
		";
	}
	else{
	

		if($action == ""){
			if($process == 1){
				// Delete cache
				delete_cache("$root/_cache");
				mkdir("$root/_cache");
				
				// Sjekk filen
				$file_name = basename($_FILES['inp_image']['name']);
				$file_exp = explode('.', $file_name); 
				$file_type = $file_exp[count($file_exp) -1]; 
				$file_type = strtolower("$file_type");

				// Finnes mappen?
				$year = date("Y");
				$upload_path = "$root/_uploads/recipes/_image_uploads/$get_recipe_category_id/$get_recipe_user_id/$year";

				if(!(is_dir("$root/_uploads"))){
					mkdir("$root/_uploads");
				}
				if(!(is_dir("$root/_uploads/recipes"))){
					mkdir("$root/_uploads/recipes");
				}
				if(!(is_dir("$root/_uploads/recipes/_image_uploads"))){
					mkdir("$root/_uploads/recipes/_image_uploads");
				}
				if(!(is_dir("$root/_uploads/recipes/_image_uploads/$get_recipe_category_id"))){
					mkdir("$root/_uploads/recipes/_image_uploads/$get_recipe_category_id");
				}
				if(!(is_dir("$root/_uploads/recipes/_image_uploads/$get_recipe_category_id/$get_recipe_user_id"))){
					mkdir("$root/_uploads/recipes/_image_uploads/$get_recipe_category_id/$get_recipe_user_id");
				}
				if(!(is_dir("$root/_uploads/recipes/_image_uploads/$get_recipe_category_id/$get_recipe_user_id/$year"))){
					mkdir("$root/_uploads/recipes/_image_uploads/$get_recipe_category_id/$get_recipe_user_id/$year");
				}


				// Sett variabler
				
				$new_name = $get_recipe_id . ".jpg";

				$target_path = $upload_path . "/" . $new_name;
				$target_path_temp = "$root/_cache/temp_" . $new_name;

				// Sjekk om det er en OK filendelse
				if($file_type == "jpg" OR $file_type == "jpeg" OR $file_type == "png" OR $file_type == "gif"){
					if(move_uploaded_file($_FILES['inp_image']['tmp_name'], $target_path_temp)) {

						// Sjekk om det faktisk er et bilde som er lastet opp
						list($width,$height) = getimagesize($target_path_temp);
						if(is_numeric($width) && is_numeric($height)){


							// Check that file is big enough
							if($width < 846){
								$url = "submit_recipe_step_4_images.php?recipe_id=$recipe_id&l=$l&ft=error&fm=width_have_to_be_bigger&width=$width&height=$height";
								header("Location: $url");
								exit;
							}
							if($height < 599){
								$url = "submit_recipe_step_4_images.php?recipe_id=$recipe_id&l=$l&ft=error&fm=height_have_to_be_bigger&width=$width&height=$height";
								header("Location: $url");
								exit;
							}

							// Dette bildet er OK
							copy($target_path_temp, $target_path);
							unlink($target_path_temp);


							// recipe_image_path
							$inp_recipe_image_path = "_uploads/recipes/_image_uploads/$get_recipe_category_id/$get_recipe_user_id/$year";
							$inp_recipe_image_path_mysql = quote_smart($link, $inp_recipe_image_path);

							// recipe_image
							$inp_recipe_image = $new_name;
							$inp_recipe_image_mysql = quote_smart($link, $inp_recipe_image);

							// recipe_thumb
							$inp_recipe_thumb = $get_recipe_id . "-thumb.jpg";
							$inp_recipe_thumb_mysql = quote_smart($link, $inp_recipe_thumb);
					
							// IP
							$inp_recipe_user_ip = $_SERVER['REMOTE_ADDR'];
							$inp_recipe_user_ip = output_html($inp_recipe_user_ip);
							$inp_recipe_user_ip_mysql = quote_smart($link, $inp_recipe_user_ip);

					

							// Update MySQL
							$result = mysqli_query($link, "UPDATE $t_recipes SET recipe_image_path=$inp_recipe_image_path_mysql, recipe_image=$inp_recipe_image_mysql, recipe_thumb=$inp_recipe_thumb_mysql, recipe_user_ip=$inp_recipe_user_ip_mysql WHERE recipe_id=$recipe_id_mysql");


							// Rezie image to 847x437
							$newwidth=847;
							$newheight=($height/$width)*$newwidth; // 667
							$tmp=imagecreatetruecolor($newwidth,$newheight);
						
							if($file_type == "jpg" || $file_type == "jpeg" ){
								$src = imagecreatefromjpeg($target_path);
							}
							else{
								$src = imagecreatefrompng($target_path);

							}

							imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
							imagejpeg($tmp, $target_path);
							imagedestroy($tmp);
					
					
							// Make thumb
							$width = $newwidth;
							$height = $newheight;

							$thumb_final_path = "$root/" . $inp_recipe_image_path. "/" . $inp_recipe_thumb;
							$newwidth=300;
							$newheight=200; // ($height/$width)*$newwidth
							$tmp=imagecreatetruecolor($newwidth,$newheight);
							$src = imagecreatefromjpeg($target_path);
							imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
							imagejpeg($tmp, $thumb_final_path);
							imagedestroy($tmp);
					


							$url = "submit_recipe_step_4_images.php?recipe_id=$recipe_id&l=$l&ft=success&fm=image_uploaded";
							header("Location: $url");
							exit;
					
						}
						else{
							// Dette er en fil som har fått byttet filendelse...
							unlink("$target_path");

							$url = "submit_recipe_step_4_images.php?recipe_id=$recipe_id&l=$l&ft=error&fm=file_is_not_an_image";
							header("Location: $url");
							exit;
						}
					}
					else{
   						switch ($_FILES['inp_image'] ['error']){
							case 1:
								$url = "submit_recipe_step_4_images.php?recipe_id=$recipe_id&l=$l&ft=error&fm=to_big_file";
								header("Location: $url");
								exit;
								break;
							case 2:
								$url = "submit_recipe_step_4_images.php?recipe_id=$recipe_id&l=$l&ft=error&fm=to_big_file";
								header("Location: $url");
								exit;
								break;
							case 3:
								$url = "submit_recipe_step_4_images.php?recipe_id=$recipe_id&l=$l&ft=error&fm=only_parts_uploaded";
								header("Location: $url");
								exit;
								break;
							case 4:
								$url = "submit_recipe_step_4_images.php?recipe_id=$recipe_id&l=$l&ft=error&fm=no_file_uploaded";
								header("Location: $url");
								exit;
								break;
						}
					} // if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
				}
				else{
					$url = "submit_recipe_step_4_images?recipe_id=$recipe_id&l=$l&ft=error&fm=invalid_file_type&file_type=$file_type";
					header("Location: $url");
					exit;
				}
			}


			echo"
			<h1>$get_recipe_title</h1>

			<h2>$l_image</h2>
	
		

			<!-- Feedback -->
			";
			if($ft != ""){
				if($fm == "width_have_to_be_bigger"){
					$fm = "$l_width_have_to_be_bigger";
				}
				elseif($fm == "height_have_to_be_bigger"){
					$fm = "$l_height_have_to_be_bigger";
				}
				elseif($fm == "image_uploaded"){
					$fm = "$l_image_uploaded";
				}
				elseif($fm == "file_is_not_an_image"){
					$fm = "$l_file_is_not_an_image";
				}
				elseif($fm == "to_big_file"){
					$fm = "$l_to_big_file";
				}
				elseif($fm == "only_parts_uploaded"){
					$fm = "$l_only_parts_uploaded";
				}
				elseif($fm == "no_file_uploaded"){
					$fm = "$l_no_file_uploaded";
				}
				elseif($fm == "invalid_file_type"){
					$fm = "$l_invalid_file_type";
				}

				elseif($fm == "image_rotated"){
					$fm = "$l_image_rotated";
				}
				elseif($fm == "image_not_found"){
					$fm = "$l_image_not_found";
				}
				else{
					$fm = ucfirst($fm);
				}
				echo"<div class=\"$ft\"><span>$fm</span></div>";
			}
			echo"	
			<!-- //Feedback -->


			<!-- Image -->
			";
			if($get_recipe_image != ""){
				echo"<img src=\"$root/image.php/$get_recipe_image.png?width=847&height=437&image=/$get_recipe_image_path/$get_recipe_image\" />";
			}
			echo"		
			<!-- //Image -->

			<!-- Add image -->

			<form method=\"post\" action=\"submit_recipe_step_4_images.php?recipe_id=$get_recipe_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
			
			<p><b>$l_new_image (847x600 jpg):</b><br />
			<input type=\"file\" name=\"inp_image\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
			</p>

			<p>
			<input type=\"submit\" value=\"$l_upload_image\" class=\"btn\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
			";
			if($get_recipe_image != ""){
				echo"
				<a href=\"submit_recipe_step_4_images.php?action=rotate_image&amp;recipe_id=$get_recipe_id&amp;l=$l&amp;process=1\" class=\"btn btn_default\">$l_rotate</a>";
			}
			echo"
			</p>
	
			</form>
			<!-- //Add image -->


			<p style=\"margin-top: 20px;\">
			<a href=\"submit_recipe_step_5_video.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"btn btn_default\">$l_continue</a>
			</p>
			";
		} // action == ""
		elseif($action == "rotate_image"){
			if($process == 1){
				
				$image_final_path = "$root/" . $get_recipe_image_path . "/" . $get_recipe_id . ".jpg";

				if($get_recipe_image != "" && file_exists("$image_final_path")){
					// Roate it 

					// Load
					$source = imagecreatefromjpeg("$root/$get_recipe_image_path/$get_recipe_image");
					$original_x = imagesx($source);
					$original_y = imagesy($source);

					$bgColor = imagecolorallocatealpha($source, 255, 255, 255, 127);
   
					// Rotate
   					$rotate = imagerotate($source, 270, $bgColor);
   					imagesavealpha($rotate, true);
   					imagejpeg($rotate, $image_final_path);


					// Free memory
					imagedestroy($source);
					imagedestroy($rotate); 


					// Update
					$inp_recipe_image = $get_recipe_id . ".jpg";
					$inp_recipe_image_mysql = quote_smart($link, $inp_recipe_image);
					mysqli_query($link, "UPDATE $t_recipes SET recipe_image=$inp_recipe_image_mysql, recipe_user_ip=$inp_ip_mysql WHERE recipe_id=$get_recipe_id") or die(mysqli_error($link));



					// Delete old thumb
					if(file_exists("$root/$get_recipe_image_path/$get_recipe_thumb") && $get_recipe_thumb != ""){
						unlink("$root/$get_recipe_image_path/$get_recipe_thumb");
					}

	
					// Thumb 300 x 200
					$thumb_final_path = "$root/" . $get_recipe_image_path . "/" . $get_recipe_id . "-thumb" . ".jpg";
					resize_crop_image(300, 200, $image_final_path, $thumb_final_path);

					// Update
					$inp_recipe_thumb = $get_recipe_id . "-thumb" . ".jpg";
					$inp_recipe_thumb_mysql = quote_smart($link, $inp_recipe_thumb);
					mysqli_query($link, "UPDATE $t_recipes SET recipe_thumb=$inp_recipe_thumb_mysql, recipe_user_ip=$inp_ip_mysql WHERE recipe_id=$get_recipe_id") or die(mysqli_error($link));


					// Delete cache
					delete_cache("$root/_cache");
					mkdir("$root/_cache");
				
					// Header
					$url = "submit_recipe_step_4_images.php?recipe_id=$recipe_id&l=$l&ft=success&fm=image_rotated";
					header("Location: $url");
					exit;
				}
				else{
					// Header
					$url = "submit_recipe_step_4_images.php?recipe_id=$recipe_id&l=$l&ft=info&fm=image_not_found";
					header("Location: $url");
					exit;
				}


			} // process
		} // action == "rotate"
	}// recipe found
} // logged in
else{
	$action = "noshow";
	echo"
	<h1>
	<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/index.php?page=login&amp;l=$l&amp;refer=$root/recipes/submit_recipe.php\">
	";
}

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>