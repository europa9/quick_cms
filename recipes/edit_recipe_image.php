<?php 
/**
*
* File: recipes/edit_recipe_ingredients.php
* Version 1.0.0
* Date 13:43 18.11.2017
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
if(isset($_GET['recipe_id'])) {
	$recipe_id = $_GET['recipe_id'];
	$recipe_id = strip_tags(stripslashes($recipe_id));
}
else{
	$recipe_id = "";
}

$l_mysql = quote_smart($link, $l);



/*- Get recipe ------------------------------------------------------------------------- */
// Select
$recipe_id_mysql = quote_smart($link, $recipe_id);
$query = "SELECT recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_country, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb_278x156, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_comments, recipe_user_ip, recipe_notes, recipe_password, recipe_last_viewed, recipe_age_restriction FROM $t_recipes WHERE recipe_id=$recipe_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_recipe_id, $get_recipe_user_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_language, $get_recipe_country, $get_recipe_introduction, $get_recipe_directions, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb_278x156, $get_recipe_video, $get_recipe_date, $get_recipe_time, $get_recipe_cusine_id, $get_recipe_season_id, $get_recipe_occasion_id, $get_recipe_marked_as_spam, $get_recipe_unique_hits, $get_recipe_unique_hits_ip_block, $get_recipe_comments, $get_recipe_user_ip, $get_recipe_notes, $get_recipe_password, $get_recipe_last_viewed, $get_recipe_age_restriction) = $row;

// Translations
include("$root/_admin/_translations/site/$l/recipes/ts_submit_recipe_step_4_images.php");
include("$root/_admin/_translations/site/$l/recipes/ts_edit_recipe.php");

/*- Headers ---------------------------------------------------------------------------------- */
if($get_recipe_id == ""){
	$website_title = "Server error 404";
}
else{
	$website_title = "$l_my_recipes - $get_recipe_title - $l_edit_recipe";
}

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

/*- Content ---------------------------------------------------------------------------------- */
if($get_recipe_id == ""){
	echo"
	<h1>Recipe not found</h1>

	<p>
	The recipe you are trying to edit was not found.
	</p>

	<p>
	<a href=\"index.php\">Back</a>
	</p>
	";
}
else{
	if(isset($_SESSION['user_id'])){
		// Get my user
		$my_user_id = $_SESSION['user_id'];
		$my_user_id = output_html($my_user_id);
		$my_user_id_mysql = quote_smart($link, $my_user_id);
		$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_user_id, $get_user_email, $get_user_name, $get_user_alias, $get_user_rank) = $row;

		// Access to recipe edit
		if($get_recipe_user_id == "$my_user_id" OR $get_user_rank == "admin"){


	if($action == ""){
		if($process == 1){
				
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
					if($width < 1919){
						$url = "edit_recipe_image.php?recipe_id=$recipe_id&l=$l&ft=error&fm=width_have_to_be_bigger";
						header("Location: $url");
						exit;
					}
					if($height < 1079){
						$url = "edit_recipe_image.php?recipe_id=$recipe_id&l=$l&ft=error&fm=height_have_to_be_bigger";
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
					$inp_recipe_thumb = $get_recipe_id . "_thumb_278x156.jpg";
					$inp_recipe_thumb_mysql = quote_smart($link, $inp_recipe_thumb);
					
					// IP
					$inp_recipe_user_ip = $_SERVER['REMOTE_ADDR'];
						$inp_recipe_user_ip = output_html($inp_recipe_user_ip);
						$inp_recipe_user_ip_mysql = quote_smart($link, $inp_recipe_user_ip);

					
						// Update MySQL
						$result = mysqli_query($link, "UPDATE $t_recipes SET 
									recipe_image_path=$inp_recipe_image_path_mysql, 
									recipe_image=$inp_recipe_image_mysql, 
									recipe_thumb_278x156=$inp_recipe_thumb_mysql, 
									recipe_user_ip=$inp_recipe_user_ip_mysql WHERE recipe_id=$recipe_id_mysql");

						// Rezie image to 1920x1080
						$newwidth=1920;
						$newheight=($height/$width)*$newwidth; // 600
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
						$newwidth=278;
						$newheight=156; // ($height/$width)*$newwidth
						$tmp=imagecreatetruecolor($newwidth,$newheight);
						$src = imagecreatefromjpeg($target_path);
						imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
						imagejpeg($tmp, $thumb_final_path);
						imagedestroy($tmp);
					
						$url = "edit_recipe_image.php?recipe_id=$recipe_id&l=$l&ft=success&fm=image_uploaded";
						header("Location: $url");
						exit;
					}
					else{
						// Dette er en fil som har fått byttet filendelse...
						unlink("$target_path");
	
						$url = "edit_recipe_image.php?recipe_id=$recipe_id&l=$l&ft=error&fm=file_is_not_an_image";
						header("Location: $url");
						exit;
					}
				}
				else{
					switch ($_FILES['inp_image'] ['error']){
					case 1:
						$url = "edit_recipe_image.php?recipe_id=$recipe_id&l=$l&ft=error&fm=to_big_file";
						header("Location: $url");
						exit;
						break;
					case 2:
						$url = "edit_recipe_image.php?recipe_id=$recipe_id&l=$l&ft=error&fm=to_big_file";
						header("Location: $url");
						exit;
						break;
					case 3:
						$url = "edit_recipe_image.php?recipe_id=$recipe_id&l=$l&ft=error&fm=only_parts_uploaded";
						header("Location: $url");
						exit;
						break;
					case 4:
						$url = "edit_recipe_image.php?recipe_id=$recipe_id&l=$l&ft=error&fm=no_file_uploaded";
						header("Location: $url");
						exit;
						break;
					}
				} // if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
			}
			else{
				$url = "edit_recipe_image.php?recipe_id=$recipe_id&l=$l&ft=error&fm=invalid_file_type&file_type=$file_type";
				header("Location: $url");
				exit;
			}
		} // if($process == 1){
		echo"
		<h1>$get_recipe_title</h1>


		<!-- Menu -->
		<div class=\"tabs\">
			<ul>
				<li><a href=\"edit_recipe.php?recipe_id=$recipe_id&amp;l=$l\">$l_general</a></li>
				<li><a href=\"edit_recipe_ingredients.php?recipe_id=$recipe_id&amp;l=$l\">$l_ingredients</a></li>
				<li><a href=\"edit_recipe_categorization.php?recipe_id=$recipe_id&amp;l=$l\">$l_categorization</a></li>
				<li><a href=\"edit_recipe_image.php?recipe_id=$recipe_id&amp;l=$l\" class=\"active\">$l_image</a></li>
				<li><a href=\"edit_recipe_video.php?recipe_id=$recipe_id&amp;l=$l\">$l_video</a></li>
				<li><a href=\"edit_recipe_tags.php?recipe_id=$recipe_id&amp;l=$l\">$l_tags</a></li>
				<li><a href=\"edit_recipe_links.php?recipe_id=$recipe_id&amp;l=$l\">$l_links</a></li>
			</ul>
		</div><p>&nbsp;</p>
		<!-- //Menu -->
	
		<!-- You are here -->
			<p>
			<b>$l_you_are_here:</b><br />
			<a href=\"my_recipes.php?l=$l#recipe_id=$recipe_id\">$l_my_recipes</a>
			&gt;
			<a href=\"view_recipe.php?recipe_id=$recipe_id&amp;l=$l\">$get_recipe_title</a>
			&gt;
			<a href=\"edit_recipe_image.php?recipe_id=$recipe_id&amp;l=$l\">$l_image</a>
			</p>
		<!-- //You are here -->
		

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
				echo"<img src=\"$root/$get_recipe_image_path/$get_recipe_image\" alt=\"$get_recipe_image_path/$get_recipe_image\" />";
			}
			echo"		
		<!-- //Image -->

		<!-- Add image -->

			<form method=\"post\" action=\"edit_recipe_image.php?recipe_id=$get_recipe_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
			
			<p><b>$l_new_image (1920x1080 jpg):</b><br />
			<input type=\"file\" name=\"inp_image\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
			</p>

			<p>
			<input type=\"submit\" value=\"$l_upload_image\" class=\"btn\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
			";
			if($get_recipe_image != ""){
				echo"
				<a href=\"edit_recipe_image.php?action=rotate_image&amp;recipe_id=$get_recipe_id&amp;l=$l&amp;process=1\" class=\"btn btn_default\">$l_rotate</a>";
			}
			echo"
			</p>
	
			</form>
		<!-- //Add image -->

		<!-- Delete thumbs -->
			";
			// Delete cache
			delete_cache("$root/_cache");
			mkdir("$root/_cache");
			echo"
		<!-- //Delete thumbs -->

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
				$url = "edit_recipe_image.php?recipe_id=$recipe_id&l=$l&ft=success&fm=image_rotated";
				header("Location: $url");
				exit;
			}
			else{
				// Header
				$url = "edit_recipe_image.php?recipe_id=$recipe_id&l=$l&ft=info&fm=image_not_found";
				header("Location: $url");
				exit;
			}

		} // process
	} // action == "rotate"
		} // is owner or admin
		else{
			echo"<p>Server error 403</p>
			<p>Only the owner and admin can edit the recipe</p>
			";
		}
	} // Isset user id
	else{
		echo"
		<h1>Log in</h1>
		<p><a href=\"$root/users/login.php?l=$l\">Please log in</a>
		</p>
		";
	}
} // recipe found

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>