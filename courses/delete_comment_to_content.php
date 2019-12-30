<?php 
/**
*
* File: courses/delete_comment_to_content.php
* Version 2.0.0
* Date 22:33 05.02.2019
* Copyright (c) 2019 Localhost
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

/*- Translation ------------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/courses/ts_courses.php");

/*- Variables ------------------------------------------------------------------------ */
if(isset($_GET['course'])) {
	$course = $_GET['course'];
	$course = strip_tags(stripslashes($course));
}
else{
	$course = "";
}
if(isset($_GET['module'])) {
	$module = $_GET['module'];
	$module = strip_tags(stripslashes($module));
}
else{
	$module = "";
}
if(isset($_GET['content'])) {
	$content = $_GET['content'];
	$content = strip_tags(stripslashes($content));
}
else{
	$content = "";
}
if(isset($_GET['comment_id'])) {
	$comment_id = $_GET['comment_id'];
	$comment_id = strip_tags(stripslashes($comment_id));
}
else{
	$comment_id = "";
}


if(isset($_SESSION['user_id'])){
	// Search for content
	$content_mysql = quote_smart($link, $content);
	$query = "SELECT content_id, content_course_id, content_course_dir_name, content_module_id, content_module_title_clean, content_type, content_number, content_title, content_title_clean, content_description, content_url, content_url_type, content_read_times, content_read_times_ipblock, content_created_datetime, content_created_date_formatted, content_last_read_datetime, content_last_read_date_formatted FROM $t_courses_modules_contents WHERE content_title_clean=$content_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_content_id, $get_current_content_course_id, $get_current_content_course_dir_name, $get_current_content_module_id, $get_current_content_module_title_clean, $get_current_content_type, $get_current_content_number, $get_current_content_title, $get_current_content_title_clean, $get_current_content_description, $get_current_content_url, $get_current_content_url_type, $get_current_content_read_times, $get_current_content_read_times_ipblock, $get_current_content_created_datetime, $get_current_content_created_date_formatted, $get_current_content_last_read_datetime, $get_current_content_last_read_date_formatted) = $row;

	if($get_current_content_id != ""){

		// Search for comment
		$comment_id_mysql = quote_smart($link, $comment_id);
		$query = "SELECT comment_id, comment_course_id, comment_course_dir_name, comment_module_id, comment_module_title_clean, comment_content_id, comment_content_title_clean, comment_language, comment_approved, comment_datetime, comment_time, comment_date_print, comment_user_id, comment_user_alias, comment_user_image_path, comment_user_image_file, comment_user_ip, comment_user_hostname, comment_user_agent, comment_title, comment_text, comment_rating, comment_helpful_clicks, comment_useless_clicks, comment_marked_as_spam, comment_spam_checked, comment_spam_checked_comment FROM $t_courses_modules_contents_comments WHERE comment_id=$comment_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_comment_id, $get_current_comment_course_id, $get_current_comment_course_dir_name, $get_current_comment_module_id, $get_current_comment_module_title_clean, $get_current_comment_content_id, $get_current_comment_content_title_clean, $get_current_comment_language, $get_current_comment_approved, $get_current_comment_datetime, $get_current_comment_time, $get_current_comment_date_print, $get_current_comment_user_id, $get_current_comment_user_alias, $get_current_comment_user_image_path, $get_current_comment_user_image_file, $get_current_comment_user_ip, $get_current_comment_user_hostname, $get_current_comment_user_agent, $get_current_comment_title, $get_current_comment_text, $get_current_comment_rating, $get_current_comment_helpful_clicks, $get_current_comment_useless_clicks, $get_current_comment_marked_as_spam, $get_current_comment_spam_checked, $get_current_comment_spam_checked_comment) = $row;

		if($get_current_comment_id != ""){

			/*- Header ----------------------------------------------------------- */
			$website_title = "$get_current_content_title - $l_edit_comment";
			if(file_exists("./favicon.ico")){ $root = "."; }
			elseif(file_exists("../favicon.ico")){ $root = ".."; }
			elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
			elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
			include("$root/_webdesign/header.php");


			// Check access to comment
			// Get my user
			$my_user_id = $_SESSION['user_id'];
			$my_user_id = output_html($my_user_id);
			$my_user_id_mysql = quote_smart($link, $my_user_id);
			$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_rank) = $row;

			if($get_current_comment_user_id == "$my_user_id" OR $get_my_user_rank == "admin" OR $get_my_user_rank == "moderator"){
				if($process == "1"){
					
					$result = mysqli_query($link, "DELETE FROM $t_courses_modules_contents_comments WHERE comment_id=$get_current_comment_id") or die(mysqli_error($link));

					// Header
					$url = "$root/$get_current_content_course_dir_name/$get_current_content_module_title_clean/$get_current_content_url";
					if($get_current_content_url_type == "dir"){ $url = $url . "/index.php"; } 
					$url = $url . "?course=$get_current_content_course_dir_name&module=$get_current_content_module_title_clean&content=$get_current_content_title_clean&l=$l&ft=success&fm=comment_deleted#comments";
					header("Location: $url");
					exit;

				} // process

				echo"
				<h1>$l_delete_comment</h1>

			
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

				<!-- You are here -->
					<p><b>$l_you_are_here</b><br />
					<a href=\"$root/$get_current_content_course_dir_name/$get_current_content_module_title_clean/$get_current_content_url";
					if($get_current_content_url_type == "dir"){ echo"/index.php"; } 
					echo"?course=$get_current_content_course_dir_name&amp;module=$get_current_content_module_title_clean&amp;content=$get_current_content_title_clean&amp;l=$l\">$get_current_content_title</a>
					&gt;
					<a href=\"delete_comment_to_content.php?comment_id=$comment_id&amp;course=$get_current_content_course_dir_name&amp;module=$get_current_content_module_title_clean&amp;content=$get_current_content_title_clean&amp;l=$l\">$l_delete_comment</a>
					</p>
				<!-- //You are here -->


				<!-- Delete comment form -->
					<p>$l_are_you_sure</p>
					

					<p>
					<a href=\"delete_comment_to_content.php?comment_id=$comment_id&amp;course=$get_current_content_course_dir_name&amp;module=$get_current_content_module_title_clean&amp;content=$get_current_content_title_clean&amp;l=$l&amp;process=1\" class=\"btn_warning\">$l_confirm_delete</a>
					</p>
				<!-- //Delete comment form -->
				";
			} // access

		} // comment found
		else{

			/*- Header ----------------------------------------------------------- */
			$website_title = "$get_current_content_title - Server error 404";
			if(file_exists("./favicon.ico")){ $root = "."; }
			elseif(file_exists("../favicon.ico")){ $root = ".."; }
			elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
			elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
			include("$root/_webdesign/header.php");

			echo"Comment not found";
		} // comment not found
	} // content found
	else{
		/*- Header ----------------------------------------------------------- */
		$website_title = "Server error 404";
		if(file_exists("./favicon.ico")){ $root = "."; }
		elseif(file_exists("../favicon.ico")){ $root = ".."; }
		elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
		elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
		include("$root/_webdesign/header.php");
		echo"Content not found";
	
	} // Content not found
} // logged in
else{
	/*- Header ----------------------------------------------------------- */
	$website_title = "Server error 403";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");
	echo"
	<h1>
	<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/index.php?page=login&amp;l=$l&amp;refer=$root/recipes/edit_comment.php?comment_id=$comment_id\">
	";

} // not logged in

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>