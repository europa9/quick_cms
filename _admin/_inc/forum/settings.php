<?php
/**
*
* File: _admin/_inc/discuss/settings.php
* Version 1.0
* Date 11:26 14.04.2019
* Copyright (c) 2008-2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}


/*- Variables ----------------------------------------------------------------------- */
$tabindex = 0;


/*- Config ------------------------------------------------------------------------ */
if(!(file_exists("_data/forum.php"))){

	$create_config ="<?php
\$forumFromEmailSav 	= \"$configFromEmailSav\";
\$forumFromNameSav 	= \"$configFromEmailSav\";
\$forumShowTagsBelowNavSav = \"1\";
\$forumShowWatchedAndIgnoredTagsBelowNavSav = \"1\";
\$forumCSSToUseOnATagsBelowNavSav = \"forum_a_tag\";
\$forumNavigationIconPaddingLeftPx = \"4px\";
\$forumNavigationTextPaddingLeftPx = \"26px\";
\$forumCSSToUseOnLiTagsBelowNavSav = \"forum_li_tag\";
\$forumEmailSendingOnOffSav = \"1\";
?>";

	$fh = fopen("_data/forum.php", "w+") or die("can not open file");
	fwrite($fh, $create_config);
	fclose($fh);
}


if($process == "1"){


	$inp_from_email = $_POST['inp_from_email'];
	$inp_from_email = output_html($inp_from_email);

	$inp_from_name = $_POST['inp_from_name'];
	$inp_from_name = output_html($inp_from_name);

	$inp_show_tags_below_navigation = $_POST['inp_show_tags_below_navigation'];
	$inp_show_tags_below_navigation = output_html($inp_show_tags_below_navigation);

	$inp_show_watched_and_ignored_tags_below_navigation = $_POST['inp_show_watched_and_ignored_tags_below_navigation'];
	$inp_show_watched_and_ignored_tags_below_navigation = output_html($inp_show_watched_and_ignored_tags_below_navigation);

	$inp_css_to_use_on_a_tags_below_nav = $_POST['inp_css_to_use_on_a_tags_below_nav'];
	$inp_css_to_use_on_a_tags_below_nav = output_html($inp_css_to_use_on_a_tags_below_nav);

	$inp_css_navigation_icon_padding_left_px = $_POST['inp_css_navigation_icon_padding_left_px'];
	$inp_css_navigation_icon_padding_left_px = output_html($inp_css_navigation_icon_padding_left_px);

	$inp_css_navigation_text_padding_left_px = $_POST['inp_css_navigation_text_padding_left_px'];
	$inp_css_navigation_text_padding_left_px = output_html($inp_css_navigation_text_padding_left_px);

	$inp_css_to_use_on_li_tags_below_nav = $_POST['inp_css_to_use_on_li_tags_below_nav'];
	$inp_css_to_use_on_li_tags_below_nav = output_html($inp_css_to_use_on_li_tags_below_nav);

	$inp_email_sending_on_off = $_POST['inp_email_sending_on_off'];
	$inp_email_sending_on_off = output_html($inp_email_sending_on_off);

	$update_file="<?php
\$forumFromEmailSav 	= \"$inp_from_email\";
\$forumFromNameSav 	= \"$inp_from_name\";
\$forumShowTagsBelowNavSav = \"$inp_show_tags_below_navigation\";
\$forumShowWatchedAndIgnoredTagsBelowNavSav = \"$inp_show_watched_and_ignored_tags_below_navigation\";
\$forumCSSToUseOnATagsBelowNavSav = \"$inp_css_to_use_on_a_tags_below_nav\";
\$forumNavigationIconPaddingLeftPx = \"$inp_css_navigation_icon_padding_left_px\";
\$forumNavigationTextPaddingLeftPx = \"$inp_css_navigation_text_padding_left_px\";
\$forumCSSToUseOnLiTagsBelowNavSav = \"$inp_css_to_use_on_li_tags_below_nav\";
\$forumEmailSendingOnOffSav = \"$inp_email_sending_on_off\";
?>";

	$fh = fopen("_data/forum.php", "w+") or die("can not open file");
	fwrite($fh, $update_file);
	fclose($fh);
	include("_data/discuss.php");

	header("Location: ?open=$open&page=$page&ft=success&fm=changes_saved&editor_language=$editor_language");
	exit;
}
include("_data/forum.php");



echo"
<h1>Settings</h1>

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

	
<form method=\"post\" action=\"?open=$open&amp;page=$page&amp;process=1&amp;editor_language=$editor_language\" enctype=\"multipart/form-data\">
				


<!-- Focus -->
	<script>
	\$(document).ready(function(){
		\$('[name=\"inp_discuss_from_email\"]').focus();
	});
	</script>
<!-- //Focus -->


<p><b>Discuss from name:</b><br />
<input type=\"text\" name=\"inp_from_name\" value=\"$forumFromNameSav\" size=\"25\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
</p>

<p><b>Discuss from e-mail:</b><br />
<input type=\"text\" name=\"inp_from_email\" value=\"$forumFromEmailSav\" size=\"25\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
</p>


<p><b>Show tags below navigation:</b><br />
<input type=\"radio\" name=\"inp_show_tags_below_navigation\" value=\"1\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\""; if($forumShowTagsBelowNavSav == "1"){ echo" checked=\"checked\""; } echo" />
Yes
&nbsp;
<input type=\"radio\" name=\"inp_show_tags_below_navigation\" value=\"0\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\""; if($forumShowTagsBelowNavSav == "0"){ echo" checked=\"checked\""; } echo" />
No
</p>

<p><b>Show Watched and Ignored tags below navigation:</b><br />
<input type=\"radio\" name=\"inp_show_watched_and_ignored_tags_below_navigation\" value=\"1\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\""; if($forumShowWatchedAndIgnoredTagsBelowNavSav == "1"){ echo" checked=\"checked\""; } echo" />
Yes
&nbsp;
<input type=\"radio\" name=\"inp_show_watched_and_ignored_tags_below_navigation\" value=\"0\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\""; if($forumShowWatchedAndIgnoredTagsBelowNavSav == "0"){ echo" checked=\"checked\""; } echo" />
No
</p>

<p><b>CSS to use on a tags below navigation:</b><br />
<select name=\"inp_css_to_use_on_a_tags_below_nav\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">
 <option value=\"forum_a_tag\" "; if($forumCSSToUseOnATagsBelowNavSav == "forum_a_tag"){ echo" selected=\"selected\""; } echo" />forum_a_tag</option>
 <option value=\"forum_a_tag_no_background\" "; if($forumCSSToUseOnATagsBelowNavSav == "forum_a_tag_no_background"){ echo" selected=\"selected\""; } echo" />forum_a_tag_no_background</option>
</select>
</p>

<p><b>Navigation icon paddign left (default 4px):</b><br />
<input type=\"text\" name=\"inp_css_navigation_icon_padding_left_px\" value=\"$forumNavigationIconPaddingLeftPx\" size=\"25\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
</p>

<p><b>Navigation text paddign left (default 26px):</b><br />
<input type=\"text\" name=\"inp_css_navigation_text_padding_left_px\" value=\"$forumNavigationTextPaddingLeftPx\" size=\"25\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
</p>

<p><b>CSS to use on li tags below navigation:</b><br />
<select name=\"inp_css_to_use_on_li_tags_below_nav\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">
 <option value=\"forum_li_horizontal\" "; if($forumCSSToUseOnLiTagsBelowNavSav == "forum_li_horizontal"){ echo" selected=\"selected\""; } echo" />forum_li_horizontal</option>
 <option value=\"forum_li_vertical\" "; if($forumCSSToUseOnLiTagsBelowNavSav == "forum_li_vertical"){ echo" selected=\"selected\""; } echo" />forum_li_vertical</option>
</select>
</p>

<p><b>E-mail sending on or off:</b><br />
Turn off if you dont have e-mail on your server<br />
<input type=\"radio\" name=\"inp_email_sending_on_off\" value=\"1\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\""; if($forumEmailSendingOnOffSav == "1"){ echo" checked=\"checked\""; } echo" />
On
&nbsp;
<input type=\"radio\" name=\"inp_email_sending_on_off\" value=\"0\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\""; if($forumEmailSendingOnOffSav == "0"){ echo" checked=\"checked\""; } echo" />
Off
</p>

<p><input type=\"submit\" value=\"$l_save_changes\" class=\"submit\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>


</form>

";
?>