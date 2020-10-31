<?php 
/**
*
* File: blog/my_blog_edit_post.php
* Version 1.0.0
* Date 09:37 18.07.2020
* Copyright (c) 2011-2020 S. A. Ditlefsen
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
include("$root/_admin/_translations/site/$l/blog/ts_blog.php");
include("$root/_admin/_translations/site/$l/blog/ts_my_blog.php");

/*- Blog config -------------------------------------------------------------------- */
include("$root/_admin/_data/blog.php");


/*- Variables ------------------------------------------------------------------------- */
$tabindex = 0;
$l_mysql = quote_smart($link, $l);


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
				delete_directory($dirname.'/'.$file);    
			}
		}
	closedir($dir_handle);
	rmdir($dirname);
	return true;
}

/*- Get extention ---------------------------------------------------------------------- */
function getExtension($str) {
		$i = strrpos($str,".");
		if (!$i) { return ""; } 
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l);
		return $ext;
}


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_blog - $l_my_blog";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */
// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security']) && isset($_GET['post_id'])){
	
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
	list($get_current_blog_info_id, $get_current_blog_user_id, $get_current_blog_language, $get_current_blog_title, $get_current_blog_description, $get_current_blog_created, $get_current_blog_updated, $get_current_blog_posts, $get_current_blog_comments, $get_current_blog_views, $get_current_blog_user_ip) = $row;

	if($get_current_blog_info_id == ""){
		echo"
		<h1><img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />Loading...</h1>
		<meta http-equiv=\"refresh\" content=\"1;url=$root/blog/my_blog_setup.php?l=$l\">
		<p>$l_creating_your_blog</p>
		";
	}
	else{
		// Get post
		$post_id = $_GET['post_id'];
		$post_id = strip_tags(stripslashes($post_id));
		$post_id_mysql = quote_smart($link, $post_id);
			
		$query = "SELECT blog_post_id, blog_post_user_id, blog_post_title_pre, blog_post_title, blog_post_language, blog_post_status, blog_post_category_id, blog_post_category_title, blog_post_introduction, blog_post_privacy_level, blog_post_text, blog_post_image_path, blog_post_image_thumb_small, blog_post_image_thumb_medium, blog_post_image_thumb_large, blog_post_image_file, blog_post_image_ext, blog_post_image_text, blog_post_ad, blog_post_created, blog_post_created_rss, blog_post_updated, blog_post_updated_rss, blog_post_allow_comments, blog_post_comments, blog_post_views, blog_post_views_ipblock, blog_post_user_ip FROM $t_blog_posts WHERE blog_post_id=$post_id_mysql AND blog_post_user_id=$my_user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_blog_post_id, $get_current_blog_post_user_id, $get_current_blog_post_title_pre, $get_current_blog_post_title, $get_current_blog_post_language, $get_current_blog_post_status, $get_current_blog_post_category_id, $get_current_blog_post_category_title, $get_current_blog_post_introduction, $get_current_blog_post_privacy_level, $get_current_blog_post_text, $get_current_blog_post_image_path, $get_current_blog_post_image_thumb_small, $get_current_blog_post_image_thumb_medium, $get_current_blog_post_image_thumb_large, $get_current_blog_post_image_file, $get_current_blog_post_image_ext, $get_current_blog_post_image_text, $get_current_blog_post_ad, $get_current_blog_post_created, $get_current_blog_post_created_rss, $get_current_blog_post_updated, $get_current_blog_post_updated_rss, $get_current_blog_post_allow_comments, $get_current_blog_post_comments, $get_current_blog_post_views, $get_current_blog_post_views_ipblock, $get_current_blog_post_user_ip) = $row;
			
		if($get_current_blog_post_id == ""){
			echo"<p>Post not found.</p>";
		}
		else{
			if($process == "1"){
				// Status
				$inp_post_status = "$get_current_blog_post_status";
				if(isset($_POST['inp_submit'])){
					$inp_submit = $_POST['inp_submit'];
				}
				else{
					$inp_submit = "";
				}
				$inp_submit = output_html($inp_submit);
				if($inp_submit == "$l_publish" OR $inp_submit == "$l_save"){
					$inp_post_status = "published";
				}
				elseif($inp_submit == "$l_save_draft" OR $inp_submit == "$l_unpublish_and_save_as_draft"){
					$inp_post_status = "draft";
				}
				else{
					$inp_post_status = "$get_current_blog_post_status";
				}
				$inp_post_status = output_html($inp_post_status);
				$inp_post_status_mysql = quote_smart($link, $inp_post_status);
						
				// Title
				$inp_title_pre = $_POST['inp_title_pre'];
				$inp_title_pre = output_html($inp_title_pre);
				$inp_title_pre_mysql = quote_smart($link, $inp_title_pre);

				$inp_title = $_POST['inp_title'];
				$inp_title = output_html($inp_title);
				$inp_title_mysql = quote_smart($link, $inp_title);
	
				$datetime = date("Y-m-d H:i:s");
				$datetime_rss = date("D, d M Y H:i:s T");

				$inp_user_ip = $_SERVER['REMOTE_ADDR'];
				$inp_user_ip = output_html($inp_user_ip);
				$inp_user_ip_mysql = quote_smart($link, $inp_user_ip);

				// Text
				if($blogEditModeSav == "bbcode"){
					$inp_text = $_POST['inp_text'];
					$inp_text = output_html($inp_text);
					$inp_text = str_replace("<br />", "\n", $inp_text);
					$inp_text = str_replace("&amp;quot;", "&quot;", $inp_text);
					$inp_text_mysql = quote_smart($link, $inp_text);
					$result = mysqli_query($link, "UPDATE $t_blog_posts SET blog_post_text=$inp_text_mysql WHERE blog_post_id=$get_blog_post_id");
				}
				elseif($blogEditModeSav == "wuciwug"){
					$inp_text = $_POST['inp_text'];
					$inp_text = encode_national_letters($inp_text);
								
					require_once "$root/_admin/_functions/htmlpurifier/HTMLPurifier.auto.php";

					$config = HTMLPurifier_Config::createDefault();
					$purifier = new HTMLPurifier($config);
					$clean_html = $purifier->purify($inp_text);

					$sql = "UPDATE $t_blog_posts SET blog_post_text=? WHERE blog_post_id=$get_current_blog_post_id";
					$stmt = $link->prepare($sql);
					$stmt->bind_param("s", $inp_text);
					$stmt->execute();
					if ($stmt->errno) {
						echo "FAILURE!!! " . $stmt->error; die;
					}
				}

			
				$result = mysqli_query($link, "UPDATE $t_blog_posts SET 
									blog_post_title=$inp_title_mysql,
									blog_post_title_pre=$inp_title_pre_mysql, 
									blog_post_status=$inp_post_status_mysql,  
									blog_post_updated='$datetime', 
									blog_post_updated_rss='$datetime_rss', 
									blog_post_user_ip=$inp_user_ip_mysql
									 WHERE blog_post_id=$get_current_blog_post_id");

				if($inp_submit == "$l_publish" OR $inp_submit == "$l_save" OR $inp_submit == "$l_save_draft" OR $inp_submit == "$l_unpublish_and_save_as_draft" OR $inp_submit == "$l_text"){
					$url = "my_blog_edit_post.php?post_id=$get_current_blog_post_id&l=$l&ft=success&fm=changes_saved";
				}
				elseif($inp_submit == "$l_main_image"){
					$url = "my_blog_edit_post_main_image.php?post_id=$get_current_blog_post_id&l=$l&ft=success&fm=changes_saved";
				}
				elseif($inp_submit == "$l_images"){
					$url = "my_blog_edit_post_images.php?post_id=$get_current_blog_post_id&l=$l&ft=success&fm=changes_saved";
				}
				elseif($inp_submit == "$l_meta"){
					$url = "my_blog_edit_post_meta.php?post_id=$get_current_blog_post_id&l=$l&ft=success&fm=changes_saved";
				}
				elseif($inp_submit == "$l_view_post"){
					$url = "view_post.php?post_id=$get_current_blog_post_id&l=$l";
				}

				header("Location: $url");
				exit;
			}
			echo"
			<h1>$l_edit $get_current_blog_post_title</h1>

			<!-- Where am I ? -->
				<p><b>$l_you_are_here:</b><br />
				<a href=\"index.php?l=$l\">$l_blog</a>
				&gt;
				<a href=\"view_blog.php?info_id=$get_current_blog_info_id&amp;l=$l\">$get_current_blog_title</a>
				&gt;
				<a href=\"my_blog.php?l=$l\">$l_my_blog</a>
				&gt;
				<a href=\"view_post.php?post_id=$get_current_blog_post_id&amp;l=$l\">$get_current_blog_post_title</a>
				&gt;
				<a href=\"my_blog_edit_post.php?post_id=$get_current_blog_post_id&amp;l=$l\">$l_text</a>
				</p>
			<!-- //Where am I ? -->

				
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


			<!-- Form -->
		
				<form method=\"post\" action=\"my_blog_edit_post.php?post_id=$get_current_blog_post_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
				<!-- Form Buttons -->
						<p>
						<input type=\"submit\" value=\"$l_text\" name=\"inp_submit\" class=\"btn btn_default\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" style=\"font-weight: bold;\" />
						<input type=\"submit\" value=\"$l_meta\" name=\"inp_submit\" class=\"btn btn_default\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
						<input type=\"submit\" value=\"$l_main_image\" name=\"inp_submit\" class=\"btn btn_default\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
						<input type=\"submit\" value=\"$l_images\" name=\"inp_submit\" class=\"btn btn_default\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
						<input type=\"submit\" value=\"$l_view_post\" name=\"inp_submit\" class=\"btn btn_default\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
						</p>
				<!-- //Form Buttons -->


				<script>
					\$(document).ready(function(){
						\$('[name=\"inp_title_pre\"]').focus();
					});
				</script>
				";

				if($blogEditModeSav == "bbcode"){
					echo"
		
					<!-- BBCode -->
						<script>
						\$(document).ready(function(){
							\$(\".insert_bold\").click(function () {
							var text1 = \$(\".inp_text\").val();
							\$(\".inp_text\").val(text1 + \"[b][/b]\").show();
							\$('[name=\"inp_text\"]').focus();
						});
						\$(\".insert_italic\").click(function () {
							var text1 = \$(\".inp_text\").val();
							\$(\".inp_text\").val(text1 + \"[i][/i]\").show();
							\$('[name=\"inp_text\"]').focus();
						});
						\$(\".insert_underline\").click(function () {
							var text1 = \$(\".inp_text\").val();
							\$(\".inp_text\").val(text1 + \"[u][/u]\").show();
							\$('[name=\"inp_text\"]').focus();
						});
						\$(\".insert_striketrough\").click(function () {
							var text1 = \$(\".inp_text\").val();
							\$(\".inp_text\").val(text1 + \"[s][/s]\").show();
							\$('[name=\"inp_text\"]').focus();
						});
						\$(\".insert_img\").click(function () {
							var text1 = \$(\".inp_text\").val();
							\$(\".inp_text\").val(text1 + \"[img][/img]\").show();
							\$('[name=\"inp_text\"]').focus();
						});
						\$(\".insert_link\").click(function () {
							var text1 = \$(\".inp_text\").val();
							\$(\".inp_text\").val(text1 + \"[url][/url]\").show();
							\$('[name=\"inp_text\"]').focus();
						});
						\$(\".insert_bullet\").click(function () {
							var text1 = \$(\".inp_text\").val();
							\$(\".inp_text\").val(text1 + \"[ul][li][/li][li][/li][/ul]\").show();
							\$('[name=\"inp_text\"]').focus();
						});
						});
						</script>
					<!-- //BBCode -->
					";
				}
				else{
					echo"
					<!-- TinyMCE -->
							<script type=\"text/javascript\" src=\"$root/_admin/_javascripts/tinymce/tinymce.min.js\"></script>
							<script>
							tinymce.init({
								selector: 'textarea.editor',
								plugins: 'print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern help',
								toolbar: 'formatselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | link image media pageembed | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat | addcomment',
								image_advtab: true,
								content_css: [
									'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
									'//www.tiny.cloud/css/codepen.min.css'
								],
								link_list: [
									{ title: 'My page 1', value: 'http://www.tinymce.com' },
									{ title: 'My page 2', value: 'http://www.moxiecode.com' }
								],
								image_list: [";
									$x=0;
									$query = "SELECT image_id, image_title, image_path, image_file FROM $t_blog_images WHERE image_user_id=$my_user_id_mysql ORDER BY image_blog_post_id DESC";
									$result = mysqli_query($link, $query);
									while($row = mysqli_fetch_row($result)) {
										list($get_image_id, $get_image_title, $get_image_path, $get_image_file) = $row;
										if($x > 0){
											echo",";
										}
										echo"\n						";
										echo"{ title: '$get_image_title', value: '$get_image_path/$get_image_file' }";
							
										$x++;
									}
									echo"
								],
								image_class_list: [
									{ title: 'None', value: '' },
									{ title: 'Some class', value: 'class-name' }
								],
								importcss_append: true,
								file_picker_callback: function (callback, value, meta) {
									/* Provide file and text for the link dialog */
									if (meta.filetype === 'file') {
										callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
									}
									/* Provide image and alt text for the image dialog */
									if (meta.filetype === 'image') {
										callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
									}
									/* Provide alternative source and posted for the media dialog */
									if (meta.filetype === 'media') {
										callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
									}
								}
							});
						</script>
					<!-- //TinyMCE -->
					";
				}
				echo"
		
				
				<p><b>$l_pre_title:</b><br />
				<input type=\"text\" name=\"inp_title_pre\" value=\"$get_current_blog_post_title_pre\" size=\"55\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" style=\"width:99%;\" />
				</p>

				<p><b>$l_title:</b><br />
				<input type=\"text\" name=\"inp_title\" value=\"$get_current_blog_post_title\" size=\"55\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
				</p>
				<p style=\"padding-bottom:0;margin-bottom:0;\"><b>$l_text:</b>
				</p>

				";
				if($blogEditModeSav == "bbcode"){
					echo"
						<p class=\"insert\">
						<a href=\"#\" class=\"insert_bold\">b</a>
						<a href=\"#\" class=\"insert_italic\">i</a>
						<a href=\"#\" class=\"insert_underline\">u</a>
						<a href=\"#\" class=\"insert_striketrough\">s</a>
						<a href=\"#\" class=\"insert_img\"><img src=\"_gfx/bb/image.png\" alt=\"image.png\"></a>
						<a href=\"#\" class=\"insert_link\"><img src=\"_gfx/bb/link.png\" alt=\"link.png\"></a>
						<a href=\"#\" class=\"insert_bullet\"><img src=\"_gfx/bb/text_list_bullets\" alt=\"text_list_bullets\"></a>
						</p>
						<p style=\"padding-top:0;margin-top:0;\">
						<textarea name=\"inp_text\" class=\"inp_text\" rows=\"25\" cols=\"50\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" style=\"width: 100%;\">$get_current_blog_post_text</textarea>
						</p>";
				}
				else{
					echo"
					<p style=\"padding-top:0;margin-top:0;\">
					<textarea name=\"inp_text\" class=\"editor\" rows=\"50\" cols=\"50\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" style=\"width: 100%;\">$get_current_blog_post_text</textarea>
					</p>
					";
				}
				echo"

				<p style=\"padding-top:0;margin-top:0;\">
				</p>

				<!-- Form Buttons -->
					<p>
					<input type=\"submit\" value=\"";if($get_current_blog_post_status == "published"){ echo"$l_save"; } else{ echo"$l_publish"; } echo"\" name=\"inp_submit\" class=\"btn btn_default\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
					<input type=\"submit\" value=\"";if($get_current_blog_post_status == "draft"){ echo"$l_save_draft"; } else{ echo"$l_unpublish_and_save_as_draft"; } echo"\" name=\"inp_submit\" class=\"btn btn_default\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
					</p>
				<!-- //Form Buttons -->
				</form>

			<!-- //Form -->
			";
		} //  post found

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