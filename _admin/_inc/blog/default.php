<?php
/**
*
* File: _admin/_inc/blog/default.php
* Version 15.00 03.03.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}


/*- Config ----------------------------------------------------------------------- */
if(!(file_exists("_data/blog.php"))){
	$update_file="<?php
\$blogWhoCanHaveBlogSav = \"everyone\";
\$blogEditModeSav 	= \"wuciwug\";

\$blogPostsImageSizeXSav = \"950\";
\$blogPostsImageSizeYSav = \"640\";

\$blogPostsThumbSmallSizeXSav = \"100\";
\$blogPostsThumbSmallSizeYSav = \"67\";

\$blogPostsThumbMediumSizeXSav = \"400\";
\$blogPostsThumbMediumSizeYSav = \"269\";

\$blogPostsThumbLargeSizeXSav = \"818\";
\$blogPostsThumbLargeSizeYSav = \"551\";
?>";

	$fh = fopen("_data/blog.php", "w+") or die("can not open file");
	fwrite($fh, $update_file);
	fclose($fh);
}


/*- Variables ------------------------------------------------------------------------ */
$tabindex = 0;


/*- Process -------------------------------------------------------------------------- */
if($process == "1"){
	$inp_who_can_have_blog = $_POST['inp_who_can_have_blog'];
	$inp_who_can_have_blog = output_html($inp_who_can_have_blog);

	$inp_edit_mode = $_POST['inp_edit_mode'];
	$inp_edit_mode = output_html($inp_edit_mode);


	$inp_posts_image_size_x = $_POST['inp_posts_image_size_x'];
	$inp_posts_image_size_x = output_html($inp_posts_image_size_x);
	$inp_posts_image_size_y = $_POST['inp_posts_image_size_y'];
	$inp_posts_image_size_y = output_html($inp_posts_image_size_y);

	$inp_posts_thumb_small_size_x = $_POST['inp_posts_thumb_small_size_x'];
	$inp_posts_thumb_small_size_x = output_html($inp_posts_thumb_small_size_x);
	$inp_posts_thumb_small_size_y = $_POST['inp_posts_thumb_small_size_y'];
	$inp_posts_thumb_small_size_y = output_html($inp_posts_thumb_small_size_y);

	$inp_posts_thumb_medium_size_x = $_POST['inp_posts_thumb_medium_size_x'];
	$inp_posts_thumb_medium_size_x = output_html($inp_posts_thumb_medium_size_x);
	$inp_posts_thumb_medium_size_y = $_POST['inp_posts_thumb_medium_size_y'];
	$inp_posts_thumb_medium_size_y = output_html($inp_posts_thumb_medium_size_y);

	$inp_posts_thumb_large_size_x = $_POST['inp_posts_thumb_large_size_x'];
	$inp_posts_thumb_large_size_x = output_html($inp_posts_thumb_large_size_x);
	$inp_posts_thumb_large_size_y = $_POST['inp_posts_thumb_large_size_y'];
	$inp_posts_thumb_large_size_y = output_html($inp_posts_thumb_large_size_y);


	$update_file="<?php
\$blogWhoCanHaveBlogSav = \"$inp_who_can_have_blog\";
\$blogEditModeSav 	= \"$inp_edit_mode\";

\$blogPostsImageSizeXSav = \"$inp_posts_image_size_x\";
\$blogPostsImageSizeYSav = \"$inp_posts_image_size_y\";

\$blogPostsThumbSmallSizeXSav = \"$inp_posts_thumb_small_size_x\";
\$blogPostsThumbSmallSizeYSav = \"$inp_posts_thumb_small_size_y\";

\$blogPostsThumbMediumSizeXSav = \"$inp_posts_thumb_medium_size_x\";
\$blogPostsThumbMediumSizeYSav = \"$inp_posts_thumb_medium_size_y\";

\$blogPostsThumbLargeSizeXSav = \"$inp_posts_thumb_large_size_x\";
\$blogPostsThumbLargeSizeYSav = \"$inp_posts_thumb_large_size_y\";
?>";

	$fh = fopen("_data/blog.php", "w+") or die("can not open file");
	fwrite($fh, $update_file);
	fclose($fh);

	$datetime = date("Y-m-d H:i:s");
	header("Location: ?open=$open&page=default&ft=success&fm=changes_saved&datetime=$datetime");
	exit;

}


/*- Include config ------------------------------------------------------------------------ */
include("_data/blog.php");

echo"
<h1>Blog</h1>

<!-- Feedback -->
";
if($ft != ""){
	if($fm == "changes_saved"){
		$fm = "$l_changes_saved";
	}
	else{
		$fm = ucfirst($ft);
	}
	echo"<div class=\"$ft\"><span>$fm</span></div>";
}
echo"	
<!-- //Feedback -->


<form method=\"post\" action=\"index.php?open=$open&amp;page=default&amp;process=1\" enctype=\"multipart/form-data\">


	<p>Who can have blog:<br />
	<select name=\"inp_who_can_have_blog\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">
		<option value=\"admin\""; if($blogWhoCanHaveBlogSav == "admin"){ echo" selected=\"selected\""; } echo">Admin</option>
		<option value=\"admin_and_moderator\""; if($blogWhoCanHaveBlogSav == "admin_and_moderator"){ echo" selected=\"selected\""; } echo">Admin and moderator</option>
		<option value=\"admin_moderator_and_editor\""; if($blogWhoCanHaveBlogSav == "admin_moderator_and_editor"){ echo" selected=\"selected\""; } echo">Admin, moderator and editor</option>
		<option value=\"admin_moderator_editor_and_trusted\""; if($blogWhoCanHaveBlogSav == "admin_moderator_editor_and_trusted"){ echo" selected=\"selected\""; } echo">Admin, moderator, editor and trusted</option>
		<option value=\"everyone\""; if($blogWhoCanHaveBlogSav == "everyone"){ echo" selected=\"selected\""; } echo">Everyone</option>
	</select>
	</p>

	<p>Edit mode:<br />
	<select name=\"inp_edit_mode\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">
		<option value=\"wuciwug\""; if($blogEditModeSav == "wuciwug"){ echo" selected=\"selected\""; } echo">wuciwug</option>
		<option value=\"bbcode\""; if($blogEditModeSav == "bbcode"){ echo" selected=\"selected\""; } echo">BB Code</option>
	</select>
	</p>

	<p>Blog posts image size:<br />
	<input type=\"text\" name=\"inp_posts_image_size_x\" value=\"$blogPostsImageSizeXSav\" size=\"3\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /> x
	<input type=\"text\" name=\"inp_posts_image_size_y\" value=\"$blogPostsImageSizeYSav\" size=\"3\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
	</p>

	<p>Blog posts thumb small:<br />
	<input type=\"text\" name=\"inp_posts_thumb_small_size_x\" value=\"$blogPostsThumbSmallSizeXSav\" size=\"3\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /> x
	<input type=\"text\" name=\"inp_posts_thumb_small_size_y\" value=\"$blogPostsThumbSmallSizeYSav\" size=\"3\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
	</p>

	<p>Blog posts thumb medium:<br />
	<input type=\"text\" name=\"inp_posts_thumb_medium_size_x\" value=\"$blogPostsThumbMediumSizeXSav\" size=\"3\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /> x
	<input type=\"text\" name=\"inp_posts_thumb_medium_size_y\" value=\"$blogPostsThumbMediumSizeYSav\" size=\"3\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
	</p>

	<p>Blog posts thumb large:<br />
	<input type=\"text\" name=\"inp_posts_thumb_large_size_x\" value=\"$blogPostsThumbLargeSizeXSav\" size=\"3\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /> x
	<input type=\"text\" name=\"inp_posts_thumb_large_size_y\" value=\"$blogPostsThumbLargeSizeYSav\" size=\"3\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
	</p>

	<p><input type=\"submit\" value=\"$l_save_changes\" class=\"btn\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
</form>

";
?>