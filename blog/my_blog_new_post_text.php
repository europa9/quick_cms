<?php 
/**
*
* File: blog/my_blog_new_post_text.php
* Version 1.0.0
* Date 16:20 12.07.2020
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

/*- Tables ---------------------------------------------------------------------------- */
include("_tables_blog.php");

/*- Functions ------------------------------------------------------------------------- */
include("$root/_admin/_functions/encode_national_letters.php");
include("$root/_admin/_functions/decode_national_letters.php");

/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/blog/ts_blog.php");
include("$root/_admin/_translations/site/$l/blog/ts_my_blog.php");

/*- Blog config -------------------------------------------------------------------- */
include("$root/_admin/_data/blog.php");

/*- Tables -------------------------------------------------------------------- */
$t_blog_stats_most_used_categories	= $mysqlPrefixSav . "blog_stats_most_used_categories";


/*- Variables ------------------------------------------------------------------------- */


$tabindex = 0;
$l_mysql = quote_smart($link, $l);




/*- Functions -------------------------------------------------------------------------------- */
// include("$root/_admin/_functions/get_extension.php");

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



/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_blog - $l_my_blog";
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
	$query = "SELECT user_id, user_email, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_email, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_rank) = $row;

	// Get blog info
	$query = "SELECT blog_info_id, blog_user_id, blog_language, blog_title, blog_description, blog_created, blog_updated, blog_posts, blog_comments, blog_views, blog_user_ip FROM $t_blog_info WHERE blog_user_id=$my_user_id_mysql AND blog_language=$l_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_blog_info_id, $get_blog_user_id, $get_blog_language, $get_blog_title, $get_blog_description, $get_blog_created, $get_blog_updated, $get_blog_posts, $get_blog_comments, $get_blog_views, $get_blog_user_ip) = $row;


	// Can I have a blog?
	$can_post = "true";
	if($blogWhoCanHaveBlogSav == "admin"){
		if($get_my_user_rank != "admin"){
			$can_post = "false";
			echo"<p>Sorry, you can not post. Only admin can post.</p>";
		}
	}
	elseif($blogWhoCanHaveBlogSav == "admin_and_moderator"){
		if($get_my_user_rank == "admin" OR $get_my_user_rank == "moderator"){
		}
		else{
			$can_post = "false";
			echo"<p>Sorry, you can not post. Only admin and moderator can post.</p>";
		}
	}
	elseif($blogWhoCanHaveBlogSav == "admin_moderator_and_editor"){
		if($get_my_user_rank == "admin" OR $get_my_user_rank == "moderator" OR $get_my_user_rank == "editor"){
		}
		else{
			$can_post = "false";
			echo"<p>Sorry, you can not post. Only admin, moderator and editor can post.</p>";
		}
	}
	elseif($blogWhoCanHaveBlogSav == "admin_moderator_editor_and_trusted"){
		if($get_my_user_rank == "admin" OR $get_my_user_rank == "moderator" OR $get_my_user_rank == "editor" OR $get_my_user_rank == "trusted"){
		}
		else{
			$can_post = "false";
			echo"<p>Sorry, you can not post. Only admin, moderator, editor and trusted can post.</p>";
		}
	}

	if($can_post == "true"){
		if($get_blog_info_id == ""){
			echo"
			<h1><img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />Loading...</h1>
			<meta http-equiv=\"refresh\" content=\"1;url=$root/blog/my_blog_setup.php?reference=new_post&amp;l=$l\">
			<p>$l_creating_your_blog</p>
			";
		}
		else{
			// Fetch blog post
			if(isset($_GET['blog_post_id'])){
				$blog_post_id = $_GET['blog_post_id'];
				$blog_post_id = strip_tags(stripslashes($blog_post_id));
				if(!(is_numeric($blog_post_id))){
					echo"Blog post id not numeric";
					die;
				}
			}
			else{
				$blog_post_id =  "";
			}
			$blog_post_id_mysql = quote_smart($link, $blog_post_id);

			$query = "SELECT blog_post_id, blog_post_user_id, blog_post_title_pre, blog_post_title, blog_post_language, blog_post_status, blog_post_category_id, blog_post_category_title, blog_post_introduction, blog_post_privacy_level, blog_post_text, blog_post_image_path, blog_post_image_thumb_small, blog_post_image_thumb_medium, blog_post_image_thumb_large, blog_post_image_file, blog_post_image_ext, blog_post_image_text, blog_post_ad, blog_post_created, blog_post_created_rss, blog_post_updated, blog_post_updated_rss, blog_post_allow_comments, blog_post_comments, blog_post_views, blog_post_views_ipblock, blog_post_user_ip FROM $t_blog_posts WHERE blog_post_id=$blog_post_id_mysql AND blog_post_user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_blog_post_id, $get_current_blog_post_user_id, $get_current_blog_post_title_pre, $get_current_blog_post_title, $get_current_blog_post_language, $get_current_blog_post_status, $get_current_blog_post_category_id, $get_current_blog_post_category_title, $get_current_blog_post_introduction, $get_current_blog_post_privacy_level, $get_current_blog_post_text, $get_current_blog_post_image_path, $get_current_blog_post_image_thumb_small, $get_current_blog_post_image_thumb_medium, $get_current_blog_post_image_thumb_large, $get_current_blog_post_image_file, $get_current_blog_post_image_ext, $get_current_blog_post_image_text, $get_current_blog_post_ad, $get_current_blog_post_created, $get_current_blog_post_created_rss, $get_current_blog_post_updated, $get_current_blog_post_updated_rss, $get_current_blog_post_allow_comments, $get_current_blog_post_comments, $get_current_blog_post_views, $get_current_blog_post_views_ipblock, $get_current_blog_post_user_ip) = $row;
			if($get_current_blog_post_id == ""){
				echo"<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" /> Loading...</h1>
				<meta http-equiv=\"refresh\" content=\"0;url=my_blog_new_post.php?l=$l\">
				";
				die;
			} // blog post not found, create one
			
			if($process == "1"){
				// Text
				$inp_title_pre = $_POST['inp_title_pre'];
				$inp_title_pre = output_html($inp_title_pre);
				$inp_title_pre_mysql = quote_smart($link, $inp_title_pre);

				$inp_title = $_POST['inp_title'];
				$inp_title = output_html($inp_title);
				$inp_title_mysql = quote_smart($link, $inp_title);
					

				if($get_current_blog_post_introduction == ""){
						$blog_post_introduction = $_POST['inp_text'];
						$blog_post_introduction = substr($blog_post_introduction, 0, 200);
						$blog_post_introduction = str_replace("<br />", "\n", $blog_post_introduction);
						$blog_post_introduction = str_replace("<p>", "", $blog_post_introduction);
						$blog_post_introduction = str_replace("</p>", "", $blog_post_introduction);
						$blog_post_introduction = str_replace("<ul>", "", $blog_post_introduction);
						$blog_post_introduction = str_replace("</ul>", "", $blog_post_introduction);
						$blog_post_introduction = str_replace("<li>", "", $blog_post_introduction);
						$blog_post_introduction = str_replace("</li>", "", $blog_post_introduction);
						$blog_post_introduction = output_html($blog_post_introduction);
						$blog_post_introduction = str_replace("&amp;quot;", "&quot;", $blog_post_introduction);
						$blog_post_introduction = str_replace("&lt;p&gt;", "", $blog_post_introduction);
						$blog_post_introduction = str_replace("&lt;/p&gt;", "", $blog_post_introduction);

				}
				else{
					$blog_post_introduction = "$get_current_blog_post_introduction";
				}
				$blog_post_introduction_mysql = quote_smart($link, $blog_post_introduction);



				// Update post
				mysqli_query($link, "UPDATE $t_blog_posts SET 
								blog_post_title=$inp_title_mysql, 
								blog_post_title_pre=$inp_title_pre_mysql, 
								blog_post_introduction=$blog_post_introduction_mysql
								WHERE blog_post_id=$get_current_blog_post_id") or die(mysqli_error($link));

				if($blogEditModeSav == "bbcode"){
						$inp_text = $_POST['inp_text'];
						$inp_text = output_html($inp_text);
						$inp_text = str_replace("<br />", "\n", $inp_text);
						$inp_text = str_replace("&amp;quot;", "&quot;", $inp_text);
						$inp_text_mysql = quote_smart($link, $inp_text);

						$result = mysqli_query($link, "UPDATE $t_blog_posts SET blog_post_text=$inp_text_mysql WHERE blog_post_id=$get_current_blog_post_id") or die(mysqli_error($link));
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


				// Header
				$inp_submit = $_POST['inp_submit'];
				if($inp_submit == "$l_publish" OR $inp_submit == "$l_save"){
					$hi = date("H:i");
					$url = "my_blog_new_post_text.php?blog_post_id=$get_current_blog_post_id&l=$l&ft=success&fm=published_$hi";
					header("Location: $url");
					exit;
				}
				elseif($inp_submit == "$l_save_draft" OR $inp_submit == "$l_unpublish_and_save_as_draft"){
					$hi = date("H:i");
					$url = "my_blog_new_post_text.php?blog_post_id=$get_current_blog_post_id&l=$l&ft=success&fm=saved_as_draft_$hi";
					header("Location: $url");
					exit;
				}
				else{
					echo"??";
				}
			} // process
			echo"
			
			<h1>$l_new_post</h1>

			<!-- Where am I? -->
					<p><b>$l_you_are_here:</b><br />
					<a href=\"index.php?l=$l\">$l_blog</a>
					&gt;
					<a href=\"view_blog.php?info_id=$get_blog_info_id&amp;l=$l\">$get_blog_title</a>
					&gt;
					<a href=\"my_blog.php?l=$l\">$l_my_blog</a>
					&gt;
					<a href=\"my_blog_new_post.php?blog_post_id=$get_current_blog_post_id&amp;l=$l\">$l_new_post</a>
					&gt;
					<a href=\"my_blog_new_post_meta.php?blog_post_id=$get_current_blog_post_id&amp;l=$l\">$l_meta</a>
					</p>
			<!-- //Where am I? -->

			<!-- Process -->
					<p><b>$l_process:</b><br />
					<a href=\"my_blog_new_post_meta.php?blog_post_id=$get_current_blog_post_id&amp;l=$l\">$l_meta</a>
					-&gt; 
					<a href=\"my_blog_new_post_main_image.php?blog_post_id=$get_current_blog_post_id&amp;l=$l\">$l_main_image</a>
					-&gt; 
					<a href=\"my_blog_new_post.php?blog_post_id=$get_current_blog_post_id&amp;l=$l\" style=\"font-weight: bold;\">$l_text</a>
					-&gt; 
					<a href=\"view_post.php?post_id=$get_current_blog_post_id&amp;l=$l\">$l_view_post</a>
					</p>
			<!-- //Process -->

			<!-- Feedback -->
				";
				if($ft != ""){
					if($fm == "changes_saved"){
						$fm = "$l_changes_saved";
					}
					else{
						$fm = str_replace("_", " ", $fm);
						$fm = ucfirst($fm);
					}
					echo"<div class=\"$ft\"><span>$fm</span></div>";
				}
				echo"	
			<!-- //Feedback -->


			<!-- Text form -->
		
				<form method=\"post\" action=\"my_blog_new_post_text.php?blog_post_id=$get_current_blog_post_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

				<script>
					\$(document).ready(function(){
						";
						if($get_current_blog_post_title == ""){
							echo"\$('[name=\"inp_title_pre\"]').focus();";
						}
						else{
							echo"\$('[name=\"inp_text\"]').focus();";
						}
						echo"
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
								height: 600,
								/* without images_upload_url set, Upload tab won't show up*/
								images_upload_url: 'my_blog_new_post_text_upload_image.php?blog_post_id=$get_current_blog_post_id&process=1',

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
				<input type=\"text\" name=\"inp_title\" value=\"$get_current_blog_post_title\" size=\"55\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" style=\"width:99%;\" />
				</p>

				<p style=\"padding-bottom:0;margin-bottom:0;\"><b>$l_text:</b> (<a href=\"my_blog_images.php?l=$l\" target=\"_blank\" class=\"small\">$l_images</a>)<br />
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
						<textarea name=\"inp_text\" class=\"inp_text\" rows=\"25\" cols=\"50\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" style=\"width: 100%;\">$get_current_blog_post_text</textarea>
						</p>";
					}
					else{
						echo"
						<p style=\"padding-top:0;margin-top:0;\">
						<textarea name=\"inp_text\" class=\"editor\" rows=\"25\" cols=\"50\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" style=\"width: 100%;\">$get_current_blog_post_text</textarea>
						</p>
						";
					}
					echo"

					<p>
					<input type=\"submit\" value=\"";if($get_current_blog_post_status == "published"){ echo"$l_save"; } else{ echo"$l_publish"; } echo"\" name=\"inp_submit\" class=\"btn btn_default\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
					<input type=\"submit\" value=\"";if($get_current_blog_post_status == "draft"){ echo"$l_save_draft"; } else{ echo"$l_unpublish_and_save_as_draft"; } echo"\" name=\"inp_submit\" class=\"btn btn_default\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
					</p>
					</form>
					<div style=\"height: 20px;\"></div>
			<!-- //Text form -->
			";
		} // blog info found
	} // can post (access)
}
else{
	echo"
	<h1>
	<img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/blog/my_blog.php\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>