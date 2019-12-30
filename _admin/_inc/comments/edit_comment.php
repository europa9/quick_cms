<?php
/**
*
* File: _admin/_inc/comments/edit_comment.php
* Version 1
* Date 10:34 03.03.2018
* Copyright (c) 2008-2018 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}


/*- Functions ----------------------------------------------------------------------- */


/*- Variables ------------------------------------------------------------------------ */
if(isset($_GET['comment_id'])){
	$comment_id = $_GET['comment_id'];
	$comment_id = output_html($comment_id);
}
else{
	$comment_id = "";
}
$tabindex = 0;


// Get comment
$comment_id_mysql = quote_smart($link, $comment_id);
$query = "SELECT comment_id, comment_user_id, comment_language, comment_object, comment_object_id, comment_parent_id, comment_user_ip, comment_user_name, comment_user_avatar, comment_user_email, comment_user_subscribe, comment_created, comment_updated, comment_text, comment_likes, comment_dislikes, comment_reported, comment_report_checked FROM $t_comments WHERE comment_id=$comment_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_comment_id, $get_current_comment_user_id, $get_current_comment_language, $get_current_comment_object, $get_current_comment_object_id, $get_current_comment_parent_id, $get_current_comment_user_ip, $get_current_comment_user_name, $get_current_comment_user_avatar, $get_current_comment_user_email, $get_current_comment_user_subscribe, $get_current_comment_created, $get_current_comment_updated, $get_current_comment_text, $get_current_comment_likes, $get_current_comment_dislikes, $get_current_comment_reported, $get_current_comment_report_checked) = $row;

if($get_current_comment_id == ""){
	echo"
	<h1>Error</h1>

	<p>
	Comment not found.
	</p>
	";

}
else{
	if($process == "1"){
		$inp_text = $_POST['inp_text'];
		$inp_text = output_html($inp_text);
		$inp_Text_mysql = quote_smart($link, $inp_text);

		$result = mysqli_query($link, "UPDATE $t_comments SET comment_text=$inp_Text_mysql WHERE comment_id=$comment_id_mysql");

		$url = "index.php?open=$open&editor_language=$editor_language&ft=success&fm=changes_saved#comment$get_current_comment_id";
		header("Location: $url");
		exit;
	}
	echo"
	<h1>Edit comment</h1>

	<!-- Form -->
		<script>
		\$(document).ready(function(){
			\$('[name=\"inp_text\"]').focus();
		});
		</script>
			
		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;comment_id=$comment_id&amp;editor_language=$editor_language&amp;process=1\" enctype=\"multipart/form-data\">
					
		<p>
		<textarea name=\"inp_text\" rows=\"5\" cols=\"50\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">";
		$get_current_comment_text = str_replace("<br />", "\n", $get_current_comment_text);
		echo"$get_current_comment_text</textarea>
		</p>
		
		
		<p><input type=\"submit\" value=\"Save changes\" class=\"btn btn_default\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
		</form>
	<!-- //Form -->
	";
}
?>