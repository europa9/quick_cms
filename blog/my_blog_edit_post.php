<?php 
/**
*
* File: blog/my_blog_new_post.php
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

/*- Functions ------------------------------------------------------------------------- */
include("$root/_admin/_functions/encode_national_letters.php");
include("$root/_admin/_functions/decode_national_letters.php");

/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/blog/ts_blog.php");
include("$root/_admin/_translations/site/$l/blog/ts_my_blog.php");

/*- Tables ---------------------------------------------------------------------------- */
$t_search_engine_index 		= $mysqlPrefixSav . "search_engine_index";
$t_search_engine_access_control = $mysqlPrefixSav . "search_engine_access_control";

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
	list($get_blog_info_id, $get_blog_user_id, $get_blog_language, $get_blog_title, $get_blog_description, $get_blog_created, $get_blog_updated, $get_blog_posts, $get_blog_comments, $get_blog_views, $get_blog_user_ip) = $row;

	if($get_blog_info_id == ""){
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
			
		$query = "SELECT blog_post_id, blog_post_user_id, blog_post_title, blog_post_language, blog_post_category_id, blog_post_introduction, blog_post_privacy_level, blog_post_text, blog_post_image_path, blog_post_image_thumb_small, blog_post_image_thumb_medium, blog_post_image_thumb_large, blog_post_image_file, blog_post_image_text, blog_post_ad, blog_post_created, blog_post_updated, blog_post_comments, blog_post_views, blog_post_user_ip FROM $t_blog_posts WHERE blog_post_id=$post_id_mysql AND blog_post_user_id=$my_user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_blog_post_id, $get_blog_post_user_id, $get_blog_post_title, $get_blog_post_language, $get_blog_post_category_id, $get_blog_post_introduction, $get_blog_post_privacy_level, $get_blog_post_text, $get_blog_post_image_path, $get_blog_post_image_thumb_small, $get_blog_post_image_thumb_medium, $get_blog_post_image_thumb_large, $get_blog_post_image_file, $get_blog_post_image_text, $get_blog_post_ad, $get_blog_post_created, $get_blog_post_updated, $get_blog_post_comments, $get_blog_post_views, $get_blog_post_user_ip) = $row;
			
		if($get_blog_post_id == ""){
			echo"<p>Post not found.</p>";
		}
		else{
			if($action == ""){
				
				if($process == "1"){
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

						$sql = "UPDATE $t_blog_posts SET blog_post_text=? WHERE blog_post_id=$get_blog_post_id";
						$stmt = $link->prepare($sql);
						$stmt->bind_param("s", $inp_text);
						$stmt->execute();
						if ($stmt->errno) {
							echo "FAILURE!!! " . $stmt->error; die;
						}
					}

			
					$result = mysqli_query($link, "UPDATE $t_blog_posts SET blog_post_title=$inp_title_mysql,
						blog_post_updated='$datetime', blog_post_updated_rss='$datetime_rss', blog_post_user_ip=$inp_user_ip_mysql
					 WHERE blog_post_id=$get_blog_post_id");


					
					// Search engine
					$reference_id_mysql = quote_smart($link, "blog_post_id$get_blog_post_id");
					$query_exists = "SELECT index_id FROM $t_search_engine_index WHERE index_module_name='blog' AND index_reference_id=$reference_id_mysql";
					$result_exists = mysqli_query($link, $query_exists);
					$row_exists = mysqli_fetch_row($result_exists);
					list($get_index_id) = $row_exists;
					if($get_index_id != ""){
						$inp_index_title = "$inp_title | $get_blog_title | $l_blog";
						$inp_index_title_mysql = quote_smart($link, $inp_index_title);
						$result = mysqli_query($link, "UPDATE $t_search_engine_index SET 
										index_title=$inp_index_title_mysql WHERE index_id=$get_index_id") or die(mysqli_error($link));
					}


					$url = "my_blog_edit_post.php?post_id=$get_blog_post_id&l=$l&ft=success&fm=changes_saved";
					header("Location: $url");
					exit;

				}
				echo"
				<h1>$get_blog_post_title</h1>

				<!-- Where am I ? -->
					<p><b>$l_you_are_here:</b><br />
					<a href=\"my_blog.php?l=$l\">$l_my_blog</a>
					&gt;
					<a href=\"view_post.php?post_id=$get_blog_post_id&amp;l=$l\">$get_blog_post_title</a>
					&gt;
					<a href=\"my_blog_edit_post.php?post_id=$post_id&amp;l=$l\">$l_edit</a>
					</p>
				<!-- //Where am I ? -->

				<!-- Edit blog post menu -->
					<div class=\"tabs\">
						<ul>
							<li><a href=\"my_blog_edit_post.php?post_id=$post_id&amp;l=$l\" class=\"selected\">$l_edit</a>
							<li><a href=\"my_blog_edit_post.php?post_id=$post_id&amp;action=meta&amp;l=$l\">$l_meta</a>
							<li><a href=\"my_blog_edit_post.php?post_id=$post_id&amp;action=image&amp;l=$l\">$l_image</a>
						</ul>
					</div>
					<div class=\"clear\" style=\"height: 20px;\"></div>
				<!-- //Edit blog post menu -->


				
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
				<h2>$l_edit</h2>

				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_title\"]').focus();
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
					image_list: [
						{ title: 'My page 1', value: 'http://www.tinymce.com' },
						{ title: 'My page 2', value: 'http://www.moxiecode.com' }
					],
						image_class_list: [
						{ title: 'None', value: '' },
						{ title: 'Some class', value: 'class-name' }
					],
					importcss_append: true,
					height: 400,
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
		
				<form method=\"post\" action=\"my_blog_edit_post.php?post_id=$post_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
				
				<p><b>$l_title:</b><br />
				<input type=\"text\" name=\"inp_title\" value=\"$get_blog_post_title\" size=\"55\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
				</p>
				<p style=\"padding-bottom:0;margin-bottom:0;\"><b>$l_text:</b>
				</p>";
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
					<textarea name=\"inp_text\" class=\"inp_text\" rows=\"25\" cols=\"50\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" style=\"width: 100%;\">$get_blog_post_text</textarea>
					</p>";
				}
				else{
					echo"
					<p style=\"padding-top:0;margin-top:0;\">
					<textarea name=\"inp_text\" class=\"editor\" rows=\"25\" cols=\"50\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" style=\"width: 100%;\">$get_blog_post_text</textarea>
					</p>
					";
				}
				echo"

				<p style=\"padding-top:0;margin-top:0;\">
				</p>

				<p><input type=\"submit\" value=\"$l_save\" class=\"btn btn_default\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
				</form>

				<!-- //Form -->
				";
			} // action ==""
			elseif($action == "meta"){
				
				if($process == "1"){
					$inp_introduction = $_POST['inp_introduction'];
					$inp_introduction = output_html($inp_introduction);
					$inp_introduction_mysql = quote_smart($link, $inp_introduction);

					$inp_category = $_POST['inp_category'];
					$inp_category = output_html($inp_category);
					$inp_category_mysql = quote_smart($link, $inp_category);

					$inp_privacy_level = $_POST['inp_privacy_level'];
					$inp_privacy_level = output_html($inp_privacy_level);
					$inp_privacy_level_mysql = quote_smart($link, $inp_privacy_level);

					if(isset($_POST['inp_ad'])){
						$inp_ad = $_POST['inp_ad'];
					}
					else{
						$inp_ad = "";
					}
					if($inp_ad == "on"){ $inp_ad = "1"; } else{ $inp_ad = "0"; } 
					$inp_ad = output_html($inp_ad);
					$inp_ad_mysql = quote_smart($link, $inp_ad);

					
					$result = mysqli_query($link, "UPDATE $t_blog_posts SET blog_post_category_id=$inp_category_mysql,
						blog_post_introduction=$inp_introduction_mysql,
						blog_post_privacy_level=$inp_privacy_level_mysql,
						blog_post_ad=$inp_ad_mysql
					 WHERE blog_post_id=$get_blog_post_id");



					$url = "my_blog_edit_post.php?post_id=$get_blog_post_id&action=$action&l=$l&ft=success&fm=changes_saved";
					header("Location: $url");
					exit;

				}
				echo"
				<h1>$get_blog_post_title</h1>

				<!-- Where am I ? -->
					<p><b>$l_you_are_here:</b><br />
					<a href=\"my_blog.php?l=$l\">$l_my_blog</a>
					&gt;
					<a href=\"view_post.php?post_id=$get_blog_post_id&amp;l=$l\">$get_blog_post_title</a>
					&gt;
					<a href=\"my_blog_edit_post.php?post_id=$post_id&amp;l=$l\">$l_edit</a>
					</p>
				<!-- //Where am I ? -->

				<!-- Edit blog post menu -->
					<div class=\"tabs\">
						<ul>
							<li><a href=\"my_blog_edit_post.php?post_id=$post_id&amp;l=$l\">$l_edit</a>
							<li><a href=\"my_blog_edit_post.php?post_id=$post_id&amp;action=meta&amp;l=$l\" class=\"selected\">$l_meta</a>
							<li><a href=\"my_blog_edit_post.php?post_id=$post_id&amp;action=image&amp;l=$l\">$l_image</a>
						</ul>
					</div>
					<div class=\"clear\" style=\"height: 20px;\"></div>
				<!-- //Edit blog post menu -->


				
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
					<h2>$l_edit</h2>
		
					<script>
					\$(document).ready(function(){
						\$('[name=\"inp_introduction\"]').focus();
					});
					</script>
		
					<form method=\"post\" action=\"my_blog_edit_post.php?post_id=$post_id&amp;action=meta&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
				
					<p><b>$l_introduction:</b><br />
					<textarea name=\"inp_introduction\" rows=\"5\" cols=\"50\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">";
					$get_blog_post_introduction = str_replace("<br />", "\n", $get_blog_post_introduction);
					echo"$get_blog_post_introduction</textarea>
					</p>


					<p><b>$l_category:</b><br />
					<select name=\"inp_category\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />\n";
					$query = "SELECT blog_category_id, blog_category_title, blog_category_posts FROM $t_blog_categories WHERE blog_category_user_id=$my_user_id_mysql AND blog_category_language=$l_mysql";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_blog_category_id, $get_blog_category_title, $get_blog_category_posts) = $row;
						echo"			";
						echo"<option value=\"$get_blog_category_id\""; if($get_blog_category_id == "$get_blog_post_category_id"){ echo" selected=\"selected\""; } echo">$get_blog_category_title</option>\n";
					}
					echo"
					</select>
					</p>
		
					<p><b>$l_who_can_see_this_post</b><br />
					<select name=\"inp_privacy_level\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
						<option value=\"everyone\""; if($get_blog_post_privacy_level == "everyone"){ echo" selected=\"selected\""; } echo">$l_everyone</option>
						<option value=\"friends\""; if($get_blog_post_privacy_level == "friends"){ echo" selected=\"selected\""; } echo">$l_friends</option>
						<option value=\"private\""; if($get_blog_post_privacy_level == "private"){ echo" selected=\"selected\""; } echo">$l_private</option>
					</select>

					
		
					<p><b>$l_mark_as_ad:</b><br />
					<input type=\"checkbox\" name=\"inp_ad\""; if($get_blog_post_ad == "1"){ echo" checked=\"checked\""; } echo" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
					$l_yes
					</p>



					<p><input type=\"submit\" value=\"$l_save\" class=\"btn btn_default\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
					</form>

				<!-- //Form -->
				";
			} // action =="meta"
			elseif($action == "image"){
				
				if($process == "1"){
					

					// Image
					// Delete cache
					delete_cache("$root/_cache");
					mkdir("$root/_cache");
				
					$inp_image_text = $_POST['inp_image_text'];
					$inp_image_text = output_html($inp_image_text);
					$inp_image_text_mysql = quote_smart($link, $inp_image_text);
					
					$result = mysqli_query($link, "UPDATE $t_blog_posts SET blog_post_image_text=$inp_image_text_mysql
					 WHERE blog_post_id=$get_blog_post_id");

					
					// Sjekk filen
					$file_name = basename($_FILES['inp_image']['name']);
					$file_exp = explode('.', $file_name); 
					$file_type = $file_exp[count($file_exp) -1]; 
					$file_type = strtolower("$file_type");

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

					// Sett variabler
					$new_name = $get_blog_post_id . ".$file_type";
					$target_path = $upload_path . "/" . $new_name;

					// Sjekk om det er en OK filendelse
					if($file_type == "jpg" OR $file_type == "jpeg" OR $file_type == "png" OR $file_type == "gif"){


						// Do I already have a image of that type? Then delete the old image..
						if($get_blog_post_image_file != "" && file_exists("$root/$get_blog_post_image_path/$get_blog_post_image_file")){
							unlink("$root/$get_blog_post_image_path/$get_blog_post_image_file");
						}

					

						if(move_uploaded_file($_FILES['inp_image']['tmp_name'], $target_path)) {
							// Sjekk om det faktisk er et bilde som er lastet opp
							list($width,$height) = getimagesize($target_path);
							if(is_numeric($width) && is_numeric($height)){


								// image path							
								$inp_image_path  = "_uploads/blog/$l/$get_blog_info_id";
								$inp_image_path_mysql = quote_smart($link, $inp_image_path);

								// image file
								$inp_image_file = $new_name;
								$inp_image_file_mysql = quote_smart($link, $inp_image_file);

								// Dette bildet er OK
								// Resize it
								$inp_new_x = 950;
								$inp_new_y = 640;
								if($width > $inp_new_x OR $height > $inp_new_y) {
									resize_crop_image($inp_new_x, $inp_new_y, "$root/$inp_image_path/$inp_image_file", "$root/$inp_image_path/$inp_image_file");
								}

								// Create thumb small
								$inp_thumb_small = $get_blog_post_id . "_thumb_" . $blogPostsThumbSmallSizeXSav . "x" . $blogPostsThumbSmallSizeYSav . "." . $file_type;
								$inp_thumb_small_mysql = quote_smart($link, $inp_thumb_small);
								resize_crop_image($blogPostsThumbSmallSizeXSav, $blogPostsThumbSmallSizeYSav, "$root/$inp_image_path/$inp_image_file", "$root/$inp_image_path/$inp_thumb_small");
		
								// Create thumb medium
								$inp_new_x = 150;
								$inp_new_y = 150;
								$inp_thumb_medium = $get_blog_post_id . "_thumb_" . $blogPostsThumbMediumSizeXSav . "x" . $blogPostsThumbMediumSizeYSav . "." . $file_type;
								$inp_thumb_medium_mysql = quote_smart($link, $inp_thumb_medium);
								resize_crop_image($blogPostsThumbMediumSizeXSav, $blogPostsThumbMediumSizeYSav, "$root/$inp_image_path/$inp_image_file", "$root/$inp_image_path/$inp_thumb_medium");
		
								// Create thumb large
								$inp_new_x = 420;
								$inp_new_y = 283;
								$inp_thumb_large = $get_blog_post_id . "_thumb_" . $blogPostsThumbLargeSizeXSav . "x" . $blogPostsThumbLargeSizeYSav . "." . $file_type;
								$inp_thumb_large_mysql = quote_smart($link, $inp_thumb_large);
								resize_crop_image($blogPostsThumbLargeSizeXSav, $blogPostsThumbLargeSizeYSav, "$root/$inp_image_path/$inp_image_file", "$root/$inp_image_path/$inp_thumb_large");
				
								// Update MySQL
								$result = mysqli_query($link, "UPDATE $t_blog_posts SET blog_post_image_path=$inp_image_path_mysql,
								blog_post_image_thumb_small=$inp_thumb_small_mysql,
								blog_post_image_thumb_medium=$inp_thumb_medium_mysql,
								blog_post_image_thumb_large=$inp_thumb_large_mysql,
								blog_post_image_file=$inp_image_file_mysql WHERE blog_post_id=$get_blog_post_id") or die(mysqli_error($link));


								// Header
								$url = "my_blog_edit_post.php?action=$action&post_id=$post_id&l=$l&ft=success&fm=image_uploaded";
								header("Location: $url");
								exit;
							}
							else{
								// Dette er en fil som har fått byttet filendelse...
								unlink("$target_path");
								$url = "my_blog_edit_post.php?action=$action&post_id=$post_id&l=$l&ft=error&fm=file_is_not_an_image";
								header("Location: $url");
								exit;
							}
						}
						else{
							switch ($_FILES['inp_image'] ['error']){
							case 1:
								$url = "my_blog_edit_post.php?action=$action&post_id=$post_id&l=$ll&ft=error&fm=to_big_file";
								header("Location: $url");
								exit;
							case 2:
								$url = "my_blog_edit_post.php?action=$action&post_id=$post_id&l=$l&ft=error&fm=to_big_file";
								header("Location: $url");
								exit;
							case 3:
								$url = "my_blog_edit_post.php?action=$action&post_id=$post_id&l=$l&ft=error&fm=only_parts_uploaded";
								header("Location: $url");
								exit;
							case 4:
								$url = "my_blog_edit_post.php?action=$action&post_id=$post_id&l=$l&ft=error&fm=no_file_uploaded";
								header("Location: $url");
								exit;
							}
						} // if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
					}
					else{
						$url = "my_blog_edit_post.php?action=$action&post_id=$post_id&l=$l&ft=error&fm=invalid_file_type&file_type=$file_type";
						header("Location: $url");
						exit;
					} // file type end
				}
				echo"
				<h1>$get_blog_post_title</h1>

				<!-- Where am I ? -->
					<p><b>$l_you_are_here:</b><br />
					<a href=\"my_blog.php?l=$l\">$l_my_blog</a>
					&gt;
					<a href=\"view_post.php?post_id=$get_blog_post_id&amp;l=$l\">$get_blog_post_title</a>
					&gt;
					<a href=\"my_blog_edit_post.php?post_id=$post_id&amp;l=$l\">$l_edit</a>
					</p>
				<!-- //Where am I ? -->

				<!-- Edit blog post menu -->
					<div class=\"tabs\">
						<ul>
							<li><a href=\"my_blog_edit_post.php?post_id=$post_id&amp;l=$l\">$l_edit</a>
							<li><a href=\"my_blog_edit_post.php?post_id=$post_id&amp;action=meta&amp;l=$l\">$l_meta</a>
							<li><a href=\"my_blog_edit_post.php?post_id=$post_id&amp;action=image&amp;l=$l\" class=\"selected\">$l_image</a>
						</ul>
					</div>
					<div class=\"clear\" style=\"height: 20px;\"></div>
				<!-- //Edit blog post menu -->


				
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
					<h2>$l_edit</h2>
		

					<form method=\"post\" action=\"my_blog_edit_post.php?post_id=$post_id&amp;action=$action&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
				
			

					<p><b>$l_image:</b><br />
					<!-- Existing image? -->
						";

						if($get_blog_post_image_file != "" && file_exists("$root/$get_blog_post_image_path/$get_blog_post_image_file")){
							// 950 x 640
							echo"
							<a href=\"$root/$get_blog_post_image_path/$get_blog_post_image_file\"><img src=\"$root/image.php?width=400&amp;height=269&amp;image=/$get_blog_post_image_path/$get_blog_post_image_file\" alt=\"$get_blog_post_image_file\" /></a>
							<br />
							<a href=\"my_blog_edit_post.php?action=rotate_image&amp;post_id=$post_id&amp;l=$l&amp;process=1\">$l_rotate</a>

							</p>

							<p><b>$l_new_image:</b><br />";
						}
						echo"
					<!-- //Existing image? -->
					<input type=\"file\" name=\"inp_image\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
					</p>

					<p><b>$l_text:</b><br />	
					<textarea name=\"inp_image_text\" rows=\"5\" cols=\"45\">"; 
					$get_blog_post_image_text = str_replace("<br />", "\n", $get_blog_post_image_text);
					echo"$get_blog_post_image_text</textarea>
					</p>


					<p><input type=\"submit\" value=\"$l_save\" class=\"btn btn_default\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
					</form>

				<!-- //Form -->
				";
			} // action =="image"
			elseif($action == "rotate_image"){
				
				if($process == "1"){
					
					// Delete cache
					delete_cache("$root/_cache");
					mkdir("$root/_cache");
				
					// Delete thumbs
					if(file_exists("$root/$get_blog_post_image_path/$get_blog_post_image_thumb_small") && $get_blog_post_image_thumb_small != ""){
						unlink("$root/$get_blog_post_image_path/$get_blog_post_image_thumb_small");
					}
					if(file_exists("$root/$get_blog_post_image_path/$get_blog_post_image_thumb_medium") && $get_blog_post_image_thumb_medium != ""){
						unlink("$root/$get_blog_post_image_path/$get_blog_post_image_thumb_medium");
					}
					if(file_exists("$root/$get_blog_post_image_path/$get_blog_post_image_thumb_large") && $get_blog_post_image_thumb_large != ""){
						unlink("$root/$get_blog_post_image_path/$get_blog_post_image_thumb_large");
					}


			
					// Random id
					$seed = str_split('abcdefghijklmnopqrstuvwxyz'
					                 .'0123456789'); // and any other characters
					shuffle($seed); // probably optional since array_is randomized; this may be redundant
					$random_string = '';
					foreach (array_rand($seed, 2) as $k) $random_string .= $seed[$k];

					// extension
					$extension = getExtension("../$get_blog_post_image_path/$get_blog_post_image_file");
					$extension = strtolower($extension);


					// New name
					$new_name = $get_blog_post_id . "_" . $random_string . ".$extension";
					$image_final_path = "../" . $get_blog_post_image_path . "/" . $new_name;



					// Load
					if($extension == "jpg"){
						$source = imagecreatefromjpeg("../$get_blog_post_image_path/$get_blog_post_image_file");
					}
					elseif($extension == "gif"){
						$source = ImageCreateFromGif("../$get_blog_post_image_path/$get_blog_post_image_file");
					}
					else{
						$source = ImageCreateFromPNG("../$get_blog_post_image_path/$get_blog_post_image_file");
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

					// Delete old
					unlink("../$get_blog_post_image_path/$get_blog_post_image_file");

					// image file
					$inp_image_file = $new_name;
					$inp_image_file_mysql = quote_smart($link, $inp_image_file);

					// Update with new
					$result = mysqli_query($link, "UPDATE $t_blog_posts SET 
						blog_post_image_file=$inp_image_file_mysql WHERE blog_post_id=$get_blog_post_id");


					
					$url = "my_blog_edit_post.php?action=image&post_id=$post_id&l=$l&ft=success&fm=image $image_final_path rotated";
					header("Location: $url");
					exit;

				}
			} // action =="rotate_image"
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