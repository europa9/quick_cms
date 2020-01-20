<?php 
/**
*
* File: recipes/submit_recipe_step_3_directions_image_uploader.php
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

/*- Functions ------------------------------------------------------------------------- */
include("$root/_admin/_functions/encode_national_letters.php");
include("$root/_admin/_functions/decode_national_letters.php");

/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/recipes/ts_recipes.php");


/*- Tables ---------------------------------------------------------------------------- */
$t_search_engine_index 		= $mysqlPrefixSav . "search_engine_index";
$t_search_engine_access_control = $mysqlPrefixSav . "search_engine_access_control";


/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['mode'])){
	$mode = $_GET['mode'];
	$mode = output_html($mode);
}
else{
	$mode = "";
}
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

/*- Content ---------------------------------------------------------------------------------- */

// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
	// Get my user
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_user_id, $get_user_email, $get_user_name, $get_user_alias, $get_user_rank) = $row;


	// Get recipe
	$recipe_id_mysql = quote_smart($link, $recipe_id);

	$query = "SELECT recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_image_path, recipe_image, recipe_thumb, recipe_video FROM $t_recipes WHERE recipe_id=$recipe_id_mysql AND recipe_user_id=$my_user_id_mysql";
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
			if($process == "1"){
		

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



				// Upload
				if($_SERVER["REQUEST_METHOD"] == "POST") {
					$image = $_FILES['inp_image']['name'];
					$filename = stripslashes($_FILES['inp_image']['name']);
					$extension = get_extension($filename);
					$extension = strtolower($extension);

					if($image){

						if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
							$ft = "warning";
							$fm = "unknown_file_format";
							$url = "submit_recipe_step_3_directions_image_uploader.php?recipe_id=$get_recipe_id&l=$l&ft=$ft&fm=$fm"; 
							header("Location: $url");
							exit;
						}
						else{
							$size=filesize($_FILES['inp_image']['tmp_name']);


							if($extension=="jpg" || $extension=="jpeg" ){
								ini_set ('gd.jpeg_ignore_warning', 1);
								error_reporting(0);
								$uploadedfile = $_FILES['inp_image']['tmp_name'];
								$src = imagecreatefromjpeg($uploadedfile);

							}
							elseif($extension=="png"){
								$uploadedfile = $_FILES['inp_image']['tmp_name'];
								$src = @imagecreatefrompng($uploadedfile);
							}
							else{
								$src = @imagecreatefromgif($uploadedfile);
							}
 	
							list($width,$height) = @getimagesize($uploadedfile);
	
							if($width == "" OR $height == ""){
	
								$ft = "warning";
								$fm = "photo_could_not_be_uploaded_please_check_file_size";
						
								$url = "submit_recipe_step_3_directions_image_uploader.php?recipe_id=$get_recipe_id&l=$l&ft=$ft&fm=$fm"; 
								header("Location: $url");
								exit;


							}
							else{
								// Keep orginal
								if($width > 971){
									$newwidth=970;
								}
								else{
									$newwidth=$width;
								}
								$newheight=round(($height/$width)*$newwidth, 0);
								$tmp_org =imagecreatetruecolor($newwidth,$newheight);

								imagecopyresampled($tmp_org,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
								$datetime = date("ymdhis");
								$filename = "$root/_uploads/recipes/_image_uploads/$get_recipe_category_id/$get_recipe_user_id/$year/". $my_user_id . "_" . $datetime . "." . $extension;

								if($extension=="jpg" || $extension=="jpeg" ){
									imagejpeg($tmp_org,$filename,100);
								}
								elseif($extension=="png"){
									imagepng($tmp_org,$filename);
								}
								else{
									imagegif($tmp_org,$filename);
								}
	
								imagedestroy($tmp_org);


								// Send feedback
								$ft = "success";
								$fm = "image_uploaded";
								$new_image = $my_user_id . "_" . $datetime . "." . $extension;
								$url = "submit_recipe_step_3_directions_image_uploader.php?recipe_id=$get_recipe_id&l=$l&ft=$ft&fm=$fm&new_image=$new_image"; 
								header("Location: $url");
								exit;

							}  // if($width == "" OR $height == ""){
						}
					} // if($image){
					else{
						switch ($_FILES['inp_image']['error']) {
							case UPLOAD_ERR_OK:
           							$fm = "photo_unknown_error";
								break;
							case UPLOAD_ERR_NO_FILE:
           							$fm = "no_file_selected";
								break;
							case UPLOAD_ERR_INI_SIZE:
           							$fm = "photo_exceeds_filesize";
								break;
							case UPLOAD_ERR_FORM_SIZE:
           							$fm_front = "photo_exceeds_filesize_form";
								break;
							default:
           							$fm_front = "unknown_upload_error";
								break;

						}
						if(isset($fm) && $fm != ""){
							$ft = "warning";
						}
						
						// Send feedback
						$url = "submit_recipe_step_3_directions_image_uploader.php?recipe_id=$get_recipe_id&l=$l&ft=$ft&fm=$fm"; 
						header("Location: $url");
						exit;
				
					}

				} // if($_SERVER["REQUEST_METHOD"] == "POST") {

			} // process == 1
			echo"
			<h1>$l_upload_image</h1>
		

			<!-- Feedback -->
			";
			if($ft != "" && $fm != ""){
				if($fm == "unknown_file_format"){
					$fm = "$l_unknown_file_format";
				}
				elseif($fm == "image_could_not_be_uploaded_please_check_file_size"){
					$fm = "$l_image_could_not_be_uploaded_please_check_file_size";
				}
				elseif($fm == "photo_unknown_error"){
					$fm = "$l_photo_unknown_error";
				}
				elseif($fm == "no_file_selected"){
					$fm = "$l_no_file_selected";
				}
				elseif($fm == "photo_exceeds_filesize"){
					$fm = "$l_photo_exceeds_filesize";
				}
				elseif($fm == "photo_exceeds_filesize_form"){
					$fm = "$l_photo_exceeds_filesize_form";
				}
				elseif($fm == "unknown_upload_error"){
					$fm = "$l_unknown_upload_error";
				}
				elseif($fm == "image_uploaded"){
					if(isset($_GET['new_image'])){
						$new_image = $_GET['new_image'];
						$new_image = output_html($new_image);
						$year = date("Y");
						if(file_exists("$root/_uploads/recipes/_image_uploads/$get_recipe_category_id/$get_recipe_user_id/$year/$new_image")){
							$fm = "
								</p>
								<form method=\"GET\" action=\"submit_recipe_step_3_directions_image_uploader.php\" enctype=\"multipart/form-data\">
									<p><b>$l_image_uploaded</b></p>

									<p>
									<img src=\"$root/_uploads/recipes/_image_uploads/$get_recipe_category_id/$get_recipe_user_id/$year/$new_image\" alt=\"$root/_uploads/recipes/_image_uploads/$get_recipe_category_id/$get_recipe_user_id/$year/$new_image\" />
									</p>

									<script>
									\$(document).ready(function(){
										\$('[name=\"inp_copy\"]').focus();
									});
									</script>
									<p><b>$l_url_to_copy:</b><br />
									<input type=\"text\" name=\"inp_copy\" value=\"$root/_uploads/recipes/_image_uploads/$get_recipe_category_id/$get_recipe_user_id/$year/$new_image\" size=\"25\" />
									</p>
								</form>
								<p>
								";
						}
						else{
							$fm = "Image uploaded, but an error happened.. <a href=\"$root/_uploads/recipes/_image_uploads/$get_recipe_category_id/$get_recipe_user_id/$year/$new_image\">$root/_uploads/recipes/_image_uploads/$get_recipe_category_id/$get_recipe_user_id/$year/$new_image</a>";
						}
					}
					
				}
				else{
					$fm = "$ft";
				}
				echo"<div class=\"$ft\"><p>$fm</p></div>";
			}
			echo"
			<!-- //Feedback -->


			<form method=\"POST\" action=\"submit_recipe_step_3_directions_image_uploader.php?recipe_id=$get_recipe_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p>$l_select_image (847x600 jpg):<br />
			<input name=\"inp_image\" type=\"file\" tabindex=\"1\" />
			</p>

			<p>
			<input type=\"submit\" value=\"$l_upload\" tabindex=\"2\" class=\"btn_default\" />
			</p>

			</form>
	
			<p style=\"margin-top: 30px;\">
			<a href=\"submit_recipe_step_3_directions.php?recipe_id=$get_recipe_id&amp;l=$l\"><img src=\"_gfx/icons/go-previous.png\" alt=\"go-previous.png\" /></a>
			<a href=\"submit_recipe_step_3_directions.php?recipe_id=$get_recipe_id&amp;l=$l\">$l_go_back</a>
			</p>
			";
		} // action == ""
	} // recipe found
}
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