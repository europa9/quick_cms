<?php 
/**
*
* File: blog/my_blog_images.php
* Version 1.0.0
* Date 12:05 10.02.2018
* Copyright (c) 2011-2018 S. A. Ditlefsen
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
include("$root/_admin/_translations/site/$l/blog/ts_blog.php");
include("$root/_admin/_translations/site/$l/blog/ts_my_blog.php");

/*- Variables ------------------------------------------------------------------------- */


$tabindex = 0;
$l_mysql = quote_smart($link, $l);


if(isset($_GET['image_id'])) {
	$image_id = $_GET['image_id'];
	$image_id = strip_tags(stripslashes($image_id));
}
else{
	$image_id = "";
}


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_blog - $l_my_blog - $l_images";
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

	// Get blog info
	$query = "SELECT blog_info_id, blog_user_id, blog_language, blog_title, blog_description, blog_created, blog_updated, blog_posts, blog_comments, blog_views, blog_user_ip FROM $t_blog_info WHERE blog_user_id=$my_user_id_mysql AND blog_language=$l_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_blog_info_id, $get_blog_user_id, $get_blog_language, $get_blog_title, $get_blog_description, $get_blog_created, $get_blog_updated, $get_blog_posts, $get_blog_comments, $get_blog_views, $get_blog_user_ip) = $row;

	if($get_blog_info_id == ""){

		echo"
		<h1><img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />Loading...</h1>
		<meta http-equiv=\"refresh\" content=\"1;url=$root/blog/my_blog_setup.php?l=$l\">
	

		<p>$l_creating_your_blog</p>
		";
	}
	else{
		if($action == ""){
			echo"
			<h1>$l_my_blog</h1>
		
			<!-- My blog menu -->
				<div class=\"tabs\">
					<ul>
						<li><a href=\"my_blog.php?l=$l\">$l_posts</a></li>
						<li><a href=\"my_blog_new_post.php?l=$l\">$l_new_post</a></li>
						<li><a href=\"my_blog_images.php?l=$l\" class=\"selected\">$l_images</a></li>
						<li><a href=\"my_blog_info.php?l=$l\">$l_info</a></li>
						<li><a href=\"my_blog_categories.php?l=$l\">$l_categories</a></li>
					</ul>
				
				</div>
				<div class=\"clear\" style=\"height: 20px;\"></div>
			<!-- //My blog menu -->
		
				
			<!-- Feedback -->
				";
				if($ft != ""){
					if($fm == "changes_saved"){
						$fm = "$l_changes_saved";
					}
					else{
						$fm = ucfirst($fm);
					}
					echo"<div class=\"$ft\"><span>$fm</span></div>";
				}
				echo"	
			<!-- //Feedback -->


			<p>
			<a href=\"my_blog_images.php?action=upload_image&amp;l=$l\" class=\"btn btn_default\">$l_upload_image</a>
			</p>
			
			<!-- Images -->
				";
				
				$query = "SELECT image_id, image_user_id, image_title, image_path, image_thumb, image_file, image_uploaded_datetime, image_uploaded_ip, image_unique_views, image_ip_block, image_reported, image_reported_checked, image_likes, image_dislikes, image_likes_dislikes_ipblock, image_comments FROM $t_blog_images WHERE image_user_id=$my_user_id_mysql ORDER BY image_id DESC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_image_id, $get_image_user_id, $get_image_title, $get_image_path, $get_image_thumb, $get_image_file, $get_image_uploaded_datetime, $get_image_uploaded_ip, $get_image_unique_views, $get_image_ip_block, $get_image_reported, $get_image_reported_checked, $get_image_likes, $get_image_dislikes, $get_image_likes_dislikes_ipblock, $get_image_comments) = $row;
			
					// Clean up
					if(!(file_exists("$root/$get_image_path/$get_image_file"))){
						echo"<div class=\"info\"><p>Img not found on server.</p></div>\n";
						mysqli_query($link, "DELETE FROM $t_blog_images WHERE image_id='$get_image_id'") or die(mysqli_error($link));
					}

					// Thumb
					if(!(file_exists("$root/$get_image_path/$get_image_thumb")) && $get_image_file != ""){
						$img_size = getimagesize("$root/$get_image_path/$get_image_file");

						$inp_new_x = 200; 
						$inp_new_y = $newheight=round(($img_size[1]/$img_size[0])*$inp_new_x, 0);
						
						resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_image_path/$get_image_file", "$root/$get_image_path/$get_image_thumb");
						
					}


					echo"
					<table>
					 <tr>
					  <td style=\"vertical-align: top;padding: 0px 10px 0px 0px;\">
						<p>
						<a href=\"$root/$get_image_path/$get_image_file\"><img src=\"$root/$get_image_path/$get_image_thumb\" alt=\"$get_image_thumb\" /></a>
						</p>
					  </td>
					  <td style=\"vertical-align: top;\">
						
						<p><b>$get_image_title</b></p>

						<p>$l_url_to_copy:<br />
						<input type=\"text\" name=\"img_$get_image_id\" value=\"$configSiteURLSav/$get_image_path/$get_image_file\" />
						</p>
						
						<p>
						<a href=\"my_blog_images.php?action=edit_image&amp;image_id=$get_image_id&amp;l=$l\">$l_edit</a>
						&middot;
						<a href=\"my_blog_images.php?action=rotate_image&amp;image_id=$get_image_id&amp;l=$l&amp;process=1\">$l_rotate</a>
						&middot;
						<a href=\"my_blog_images.php?action=delete_image&amp;image_id=$get_image_id&amp;l=$l\">$l_delete</a>
						</p>
					  </td>
					 </tr>
					</table>
					";
				}
				echo"
			<!-- //Images -->
			";
		} // action == ""
		elseif($action == "upload_image"){
			if($process == "1"){
				$inp_title = $_POST['inp_title'];
				$inp_title = output_html($inp_title);
				$inp_title_mysql = quote_smart($link, $inp_title);
				

				
				// Finnes mappen?
				$upload_path = "$root/_uploads/blog/$l/$get_blog_info_id";

				if(!(is_dir("$root/_uploads"))){
					mkdir("$root/_uploads");
				}
				if(!(is_dir("$root/_uploads/blog"))){
					mkdir("$root/_uploads/blog");
				}
				if(!(is_dir("$root/_uploads/blog/$l"))){
					mkdir("$root/_uploads/blog/$l");
				}
				if(!(is_dir("$root/_uploads/blog/$l/$get_blog_info_id"))){
					mkdir("$root/_uploads/blog/$l/$get_blog_info_id");
				}

				// Get extention
				function getExtension($str) {
					$i = strrpos($str,".");
					if (!$i) { return ""; } 
					$l = strlen($str) - $i;
					$ext = substr($str,$i+1,$l);
					return $ext;
				}



				// Upload
				if($_SERVER["REQUEST_METHOD"] == "POST") {
       					$tmp_name = $_FILES['inp_image']["tmp_name"];
					$image = $_FILES['inp_image']['name'];
					$extension = getExtension($image);
					$extension = strtolower($extension);
				

					$datetime = date("ymdhis");
					$filename = "$root/_uploads/blog/$l/$get_blog_info_id/". $my_user_id . "_" . $datetime . "." . $extension;


					if($image){

						if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
							$ft = "warning";
							$fm = "unknown_file_format";
							$url = "my_blog_images.php?action=upload_image&l=$l&ft=$ft&fm=$fm"; 
							header("Location: $url");
							exit;
						}
						else{
							if(move_uploaded_file($tmp_name, "$filename")){
							
								// Check width and height
								list($width,$height) = getimagesize($filename);
								if($width == "" OR $height == ""){
									unlink("$filename");

									$ft = "warning";
									$fm = "image_could_not_be_uploaded_please_check_file_size";
						
									$url = "my_blog_images.php?action=upload_image&l=$l&ft=$ft&fm=$fm"; 
									header("Location: $url");
									exit;
								}
							

								// Path
								$inp_path = "_uploads/blog/$l/$get_blog_info_id";
								$inp_path_mysql = quote_smart($link, $inp_path);


								// File
								$inp_file = $my_user_id . "_" . $datetime . "." . $extension;
								$inp_file_mysql = quote_smart($link, $inp_file);

								// Thumb
								$inp_thumb = $my_user_id . "_" . $datetime . "_thumb." . $extension;
								$inp_thumb_mysql = quote_smart($link, $inp_thumb);

								// Datetime
								$datetime = date("Y-m-d H:i:s");

								// IP
								$my_ip = $_SERVER['REMOTE_ADDR'];
								$my_ip = output_html($my_ip);
								$my_ip_mysql = quote_smart($link, $my_ip);


								// Insert into MySQL
								mysqli_query($link, "INSERT INTO $t_blog_images
								(image_id, image_user_id, image_title, image_path, image_thumb, image_file, image_uploaded_datetime, image_uploaded_ip, image_unique_views, image_ip_block, image_reported, image_reported_checked, image_likes, image_dislikes, image_likes_dislikes_ipblock, image_comments) 
								VALUES 
								(NULL, $my_user_id_mysql, $inp_title_mysql, $inp_path_mysql, $inp_thumb_mysql, $inp_file_mysql, '$datetime', $my_ip_mysql, '0', '', 0, '', 0, 0, '', '0')")
								or die(mysqli_error($link));



								// Send feedback
								$ft = "success";
								$fm = "image_uploaded";
								$url = "my_blog_images.php?action=upload_image&l=$l&ft=$ft&fm=$fm"; 
								header("Location: $url");
								exit;

							}  // move uploaded file
						} // if($width == "" OR $height == ""){
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
						$url = "my_blog_images.php?action=upload_image&l=$l&ft=$ft&fm=$fm"; 
						header("Location: $url");
						exit;
				
					}

				} // if($_SERVER["REQUEST_METHOD"] == "POST") {

				
			}
			echo"
			<h1>$l_my_blog</h1>
		
			<!-- My blog menu -->
				<div class=\"tabs\">
					<ul>
						<li><a href=\"my_blog.php?l=$l\">$l_posts</a></li>
						<li><a href=\"my_blog_new_post.php?l=$l\">$l_new_post</a></li>
						<li><a href=\"my_blog_images.php?l=$l\" class=\"selected\">$l_images</a></li>
						<li><a href=\"my_blog_info.php?l=$l\">$l_info</a></li>
						<li><a href=\"my_blog_categories.php?l=$l\">$l_categories</a></li>
					</ul>
				
				</div>
				<div class=\"clear\" style=\"height: 20px;\"></div>
			<!-- //My blog menu -->
		
				
			
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
					$fm = "$l_image_uploaded";
					
				}
				else{
					$fm = "$ft";
				}
				echo"<div class=\"$ft\"><p>$fm</p></div>";
			}
			echo"
			<!-- //Feedback -->

			<!-- Upload iamge Form -->

				<h2>$l_upload_image</h2>

				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_title\"]').focus();
				});
				</script>
		
				<form method=\"post\" action=\"my_blog_images.php?action=$action&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
				

				<p><b>$l_title:</b><br />
				<input type=\"text\" name=\"inp_title\" value=\"\" size=\"25\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				</p>

				<p>$l_select_image:<br />
				<input name=\"inp_image\" type=\"file\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				</p>

				<p><input type=\"submit\" value=\"$l_upload\" class=\"btn btn_default\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" /></p>
				</form>

			<!-- //Upload iamge Form -->

			<p>
			<a href=\"my_blog_images.php?l=$l\"><img src=\"_gfx/icons/go-previous.png\" alt=\"go-previous.png\" /></a>
			<a href=\"my_blog_images.php?l=$l\">$l_previous</a>
			
			</p>
			";
		} // upload
		elseif($action == "edit_image"){
			// Find image
			$image_id_mysql = quote_smart($link, $image_id);
			$query = "SELECT image_id, image_user_id, image_title, image_path, image_thumb, image_file, image_uploaded_datetime, image_uploaded_ip, image_unique_views, image_ip_block, image_reported, image_reported_checked, image_likes, image_dislikes, image_likes_dislikes_ipblock, image_comments FROM $t_blog_images WHERE image_id=$image_id_mysql AND image_user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_image_id, $get_image_user_id, $get_image_title, $get_image_path, $get_image_thumb, $get_image_file, $get_image_uploaded_datetime, $get_image_uploaded_ip, $get_image_unique_views, $get_image_ip_block, $get_image_reported, $get_image_reported_checked, $get_image_likes, $get_image_dislikes, $get_image_likes_dislikes_ipblock, $get_image_comments) = $row;


			if($get_image_id == ""){
				echo"<p>Image not found</p>";
			} // image not found
			else{
				if($process == "1"){
					$inp_title = $_POST['inp_title'];
					$inp_title = output_html($inp_title);
					$inp_title_mysql = quote_smart($link, $inp_title);

					mysqli_query($link, "UPDATE $t_blog_images SET image_title=$inp_title_mysql WHERE image_id=$image_id_mysql AND image_user_id=$my_user_id_mysql") or die(mysqli_error($link));

					$url = "my_blog_images.php?action=$action&image_id=$image_id&l=$l&ft=success&fm=changes_saved"; 
					header("Location: $url");
					exit;
				}

				echo"
				<h2>$get_image_title</h2>
				
			
				<!-- Feedback -->
				";
				if($ft != "" && $fm != ""){
					if($fm == "changes_saved"){
						$fm = "$l_changes_saved";
					}
					else{
						$fm = "$ft";
					}
					echo"<div class=\"$ft\"><p>$fm</p></div>";
				}
				echo"
				<!-- //Feedback -->
				
				<p>
				<a href=\"$root/$get_image_path/$get_image_file\"><img src=\"$root/$get_image_path/$get_image_thumb\" alt=\"$get_image_thumb\" /></a>
				</p>

				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_title\"]').focus();
				});
				</script>
		
				<form method=\"post\" action=\"my_blog_images.php?action=$action&amp;image_id=$image_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
				

				<p><b>$l_title:</b><br />
				<input type=\"text\" name=\"inp_title\" value=\"$get_image_title\" size=\"25\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
				</p>

				<p><input type=\"submit\" value=\"$l_save_changes\" class=\"btn btn_default\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" /></p>
				</form>



				<p>
				<a href=\"my_blog_images.php?l=$l\"><img src=\"_gfx/icons/go-previous.png\" alt=\"go-previous.png\" /></a>
				<a href=\"my_blog_images.php?l=$l\">$l_previous</a>
				</p>
				";
			}// image found

		} // edit_image
		elseif($action == "delete_image"){
			// Find image
			$image_id_mysql = quote_smart($link, $image_id);
			$query = "SELECT image_id, image_user_id, image_title, image_path, image_thumb, image_file, image_uploaded_datetime, image_uploaded_ip, image_unique_views, image_ip_block, image_reported, image_reported_checked, image_likes, image_dislikes, image_likes_dislikes_ipblock, image_comments FROM $t_blog_images WHERE image_id=$image_id_mysql AND image_user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_image_id, $get_image_user_id, $get_image_title, $get_image_path, $get_image_thumb, $get_image_file, $get_image_uploaded_datetime, $get_image_uploaded_ip, $get_image_unique_views, $get_image_ip_block, $get_image_reported, $get_image_reported_checked, $get_image_likes, $get_image_dislikes, $get_image_likes_dislikes_ipblock, $get_image_comments) = $row;


			if($get_image_id == ""){
				echo"<p>Image not found</p>";
			} // image not found
			else{
				if($process == "1"){
					unlink("$root/$get_image_path/$get_image_thumb");
					unlink("$root/$get_image_path/$get_image_file");

					mysqli_query($link, "DELETE FROM $t_blog_images WHERE image_id=$image_id_mysql AND image_user_id=$my_user_id_mysql") or die(mysqli_error($link));

					$url = "my_blog_images.php?l=$l&ft=success&fm=image_deleted"; 
					header("Location: $url");
					exit;
				}

				echo"
				<h2>$get_image_title</h2>
				
			
				<!-- Feedback -->
				";
				if($ft != "" && $fm != ""){
					if($fm == "changes_saved"){
						$fm = "$l_changes_saved";
					}
					else{
						$fm = "$ft";
					}
					echo"<div class=\"$ft\"><p>$fm</p></div>";
				}
				echo"
				<!-- //Feedback -->
				
				<p>
				<a href=\"$root/$get_image_path/$get_image_file\"><img src=\"$root/$get_image_path/$get_image_thumb\" alt=\"$get_image_thumb\" /></a>
				</p>
					
				<p>
				$l_are_you_sure
				</p>
				

				<p>
				<a href=\"my_blog_images.php?action=delete_image&amp;image_id=$image_id&amp;l=$l&amp;process=1\" class=\"btn_danger\">$l_confirm_delete</a>
				</p>

				<p>
				<a href=\"my_blog_images.php?l=$l\"><img src=\"_gfx/icons/go-previous.png\" alt=\"go-previous.png\" /></a>
				<a href=\"my_blog_images.php?l=$l\">$l_previous</a>
				</p>
				";
			}// image found
		}
		elseif($action == "rotate_image"){
			// Find image
			$image_id_mysql = quote_smart($link, $image_id);
			$query = "SELECT image_id, image_user_id, image_title, image_path, image_thumb, image_file, image_uploaded_datetime, image_uploaded_ip, image_unique_views, image_ip_block, image_reported, image_reported_checked, image_likes, image_dislikes, image_likes_dislikes_ipblock, image_comments FROM $t_blog_images WHERE image_id=$image_id_mysql AND image_user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_image_id, $get_image_user_id, $get_image_title, $get_image_path, $get_image_thumb, $get_image_file, $get_image_uploaded_datetime, $get_image_uploaded_ip, $get_image_unique_views, $get_image_ip_block, $get_image_reported, $get_image_reported_checked, $get_image_likes, $get_image_dislikes, $get_image_likes_dislikes_ipblock, $get_image_comments) = $row;


			if($get_image_id == ""){
				echo"<p>Image not found</p>";
			} // image not found
			else{
				if($process == "1"){
					// Delete thumb
					if(file_exists("$root/$get_image_path/$get_image_thumb")){
						unlink("$root/$get_image_path/$get_image_thumb");
					}
					
					// Get extention
					function getExtension($str) {
						$i = strrpos($str,".");
						if (!$i) { return ""; } 
						$l = strlen($str) - $i;
						$ext = substr($str,$i+1,$l);
						return $ext;
					}
					$extension = getExtension($get_image_file);
					$extension = strtolower($extension);	

					// Get a new name
					$datetime = date("ymdhis");
					$new_image_file = $my_user_id . "_" . $datetime . "." . $extension;
					$new_image_file_mysql = quote_smart($link, $new_image_file);

					// Get a new thumb name
					$datetime = date("ymdhis");
					$new_image_thumb = $my_user_id . "_" . $datetime . "_thumb." . $extension;
					$new_image_thumb_mysql = quote_smart($link, $new_image_thumb);

			
					// Update name
					mysqli_query($link, "UPDATE $t_blog_images SET image_thumb=$new_image_thumb_mysql, image_file=$new_image_file_mysql WHERE image_id=$image_id_mysql AND image_user_id=$my_user_id_mysql") or die(mysqli_error($link));


					// Rename
					rename("$root/$get_image_path/$get_image_file", "$root/$get_image_path/$new_image_file");


					$rotate = "";
					if($extension == "jpg"){
						// Load
						$source = imagecreatefromjpeg("$root/$get_image_path/$new_image_file");

						// Rotate
						if($rotate == ""){
							$rotate = imagerotate($source, -90, 0);
						}
						else{
							$rotate = imagerotate($source, 90, 0);
						}

						// Save
						imagejpeg($rotate, "$root/$get_image_path/$new_image_file");
					}
					elseif($extension == "png"){
						// Load
						$source = imagecreatefrompng("$root/$get_image_path/$new_image_file");

						// Bg
						$bgColor = imagecolorallocatealpha($source, 255, 255, 255, 127);
				
						// Rotate
						if($rotate == ""){
							$rotate = imagerotate($source, -90, $bgColor);
						}
						else{
							$rotate = imagerotate($source, 90, $bgColor);
						}
	
						// Save
						imagesavealpha($rotate, true);
						imagepng($rotate, "$root/$get_image_path/$new_image_file");

					}

		
					// Free the memory
					imagedestroy($source);




					// Move
					$url = "my_blog_images.php?l=$l&ft=success&fm=image_rotated#image$get_image_id"; 
					header("Location: $url");
					exit;
				} // process
			}// image found
		} // rotate_image
	} // found
}
else{
	echo"
	<h1>
	<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/index.php?page=login&amp;l=$l&amp;refer=$root/blog/my_blog.php\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>