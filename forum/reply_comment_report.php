<?php 
/**
*
* File: discuss/reply_comment_report.php
* Version 1.0.0
* Date 09:38 26.04.2019
* Copyright (c) 2011-2019 S. A. Ditlefsen
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
include("$root/_admin/_data/discuss.php");

/*- Forum config ------------------------------------------------------------------------ */
include("$root/_admin/_data/forum.php");
include("_include_tables.php");

/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/forum/ts_forum.php");
include("$root/_admin/_translations/site/$l/forum/ts_new_topic.php");

/*- Variables ------------------------------------------------------------------------- */
$tabindex = 0;
$l_mysql = quote_smart($link, $l);




/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['reply_comment_id'])){
	$reply_comment_id = $_GET['reply_comment_id'];
	$reply_comment_id = output_html($reply_comment_id);
}
else{
	$reply_comment_id = "";
}
if(isset($_GET['show'])) {
	$show = $_GET['show'];
	$show = strip_tags(stripslashes($show));
}
else{
	$show = "";
}

// Get reply comment id


$reply_comment_id_mysql = quote_smart($link, $reply_comment_id);
$query = "SELECT reply_comment_id, reply_comment_user_id, reply_comment_user_alias, reply_comment_user_image, reply_comment_topic_id, reply_comment_reply_id, reply_comment_text, reply_comment_created, reply_comment_updated, reply_comment_updated_translated, reply_comment_likes, reply_comment_dislikes, reply_comment_rating, reply_comment_likes_ip_block, reply_comment_user_ip, reply_comment_reported, reply_comment_reported_by_user_id, reply_comment_reported_reason, reply_comment_reported_checked FROM $t_forum_replies_comments WHERE reply_comment_id=$reply_comment_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_reply_comment_id, $get_current_reply_comment_user_id, $get_current_reply_comment_user_alias, $get_current_reply_comment_user_image, $get_current_reply_comment_topic_id, $get_current_reply_comment_reply_id, $get_current_reply_comment_text, $get_current_reply_comment_created, $get_current_reply_comment_updated, $get_current_reply_comment_updated_translated, $get_current_reply_comment_likes, $get_current_reply_comment_dislikes, $get_current_reply_comment_rating, $get_current_reply_comment_likes_ip_block, $get_current_reply_comment_user_ip, $get_current_reply_comment_reported, $get_current_reply_comment_reported_by_user_id, $get_current_reply_comment_reported_reason, $get_current_reply_comment_reported_checked) = $row;

if($get_current_reply_comment_id == ""){
	echo"<p>Reply comment not found.</p>";
	
}
else{
	// Find topic
	$topic_id_mysql = quote_smart($link, $get_current_reply_comment_topic_id);
	$query = "SELECT topic_id, topic_user_id, topic_user_alias, topic_user_image, topic_language, topic_title, topic_text, topic_created, topic_updated, topic_updated_translated, topic_replies, topic_views, topic_views_ip_block, topic_likes, topic_dislikes, topic_rating, topic_likes_ip_block, topic_user_ip, topic_reported, topic_reported_by_user_id, topic_reported_reason, topic_reported_checked FROM $t_forum_topics WHERE topic_id=$topic_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_topic_id, $get_current_topic_user_id, $get_current_topic_user_alias, $get_current_topic_user_image, $get_current_topic_language, $get_current_topic_title, $get_current_topic_text, $get_current_topic_created, $get_current_topic_updated, $get_current_topic_updated_translated, $get_current_topic_replies, $get_current_topic_views, $get_current_topic_views_ip_block, $get_current_topic_likes, $get_current_topic_dislikes, $get_current_topic_rating, $get_current_topic_likes_ip_block, $get_current_topic_user_ip, $get_current_topic_reported, $get_current_topic_reported_by_user_id, $get_current_topic_reported_reason, $get_current_topic_reported_checked) = $row;

	// Get reply
	$reply_id_mysql = quote_smart($link, $get_current_reply_comment_reply_id);
	$query = "SELECT reply_id, reply_user_id, reply_user_alias, reply_user_image, reply_topic_id, reply_text, reply_created, reply_updated, reply_updated_translated, reply_selected_answer, reply_likes, reply_dislikes, reply_rating, reply_likes_ip_block, reply_user_ip, reply_reported, reply_reported_by_user_id, reply_reported_reason, reply_reported_checked FROM $t_forum_replies WHERE reply_id=$reply_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_reply_id, $get_current_reply_user_id, $get_current_reply_user_alias, $get_current_reply_user_image, $get_current_reply_topic_id, $get_current_reply_text, $get_current_reply_created, $get_current_reply_updated, $get_current_reply_updated_translated, $get_current_reply_selected_answer, $get_current_reply_likes, $get_current_reply_dislikes, $get_current_reply_rating, $get_current_reply_likes_ip_block, $get_current_reply_user_ip, $get_current_reply_reported, $get_current_reply_reported_by_user_id, $get_current_reply_reported_reason, $get_current_reply_reported_checked) = $row;

	

	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "$l_discuss - $get_current_topic_title - $l_report_comment";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");
		
	// Logged in?
	if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
		// Get my user
		$my_user_id = $_SESSION['user_id'];
		$my_user_id = output_html($my_user_id);
		$my_user_id_mysql = quote_smart($link, $my_user_id);
		$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_rank) = $row;
		

		if($get_current_reply_comment_reported == ""){
		
			if($process == "1"){
				$inp_reason = $_POST['inp_reason'];
				$inp_reason = output_html($inp_reason);
				$inp_reason_mysql = quote_smart($link, $inp_reason);
				if(empty($inp_reason)){
					$url = "report_topic.php?topic_id=$topic_id&l=$l&ft=error&fm=insert_a_reason";
					header("Location: $url");
					exit;
				}


				// Update
				$result = mysqli_query($link, "UPDATE $t_forum_replies_comments SET 
						reply_comment_reported='1',
						reply_comment_reported_by_user_id='$get_my_user_id',
						reply_comment_reported_reason=$inp_reason_mysql,
						reply_comment_reported_checked=''
				 WHERE reply_comment_id=$get_current_reply_comment_id");


				// Who is moderator of the week?
				$week = date("W");
				$year = date("Y");

				$query = "SELECT moderator_user_id, moderator_user_email, moderator_user_name FROM $t_users_moderator_of_the_week WHERE moderator_week=$week AND moderator_year=$year";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_moderator_user_id, $get_moderator_user_email, $get_moderator_user_name) = $row;
				if($get_moderator_user_id == ""){
					// Create moderator of the week
					include("$root/_admin/_functions/create_moderator_of_the_week.php");
					
					$query = "SELECT moderator_user_id, moderator_user_email, moderator_user_name FROM $t_users_moderator_of_the_week WHERE moderator_week=$week AND moderator_year=$year";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_moderator_user_id, $get_moderator_user_email, $get_moderator_user_name) = $row;
				}


				
				// Mail from
				$view_link = $configSiteURLSav . "/discuss/view_topic.php?topic_id=$get_current_topic_id#replycomment$get_current_reply_comment_id";
				$edit_link = $configControlPanelURLSav . "/discuss/reply_comment_edit.php?reply_comment_id=$get_current_reply_comment_id";
				$delete_link = $configControlPanelURLSav . "/discuss/reply_comment_delete.php?reply_comment_id=$get_current_reply_comment_id";
			
				$user_agent = $_SERVER['HTTP_USER_AGENT'];
				$user_agent = output_html($user_agent);

				$subject = "Discuss - Reported comment from $get_current_reply_comment_user_alias for topic $get_current_topic_title at $configWebsiteTitleSav";

				$message = "<html>\n";
				$message = $message. "<head>\n";
				$message = $message. "  <title>$subject</title>\n";
				$message = $message. " </head>\n";
				$message = $message. "<body>\n";

				$message = $message . "<p>Hi $get_moderator_user_name,</p>\n\n";
				$message = $message . "<p><b>Summary:</b><br />Reported comment from $get_current_reply_comment_user_alias for topic $get_current_topic_title at $configWebsiteTitleSav. Please check if the topic should be deleted or edited.</p>\n\n";

				$message = $message . "<p style='padding-bottom:0;margin-bottom:0'><b>Comment Information:</b></p>\n";
				$message = $message . "<table>\n";
				$message = $message . " <tr><td><span>Topic ID:</span></td><td><span>$get_current_topic_id</span></td></tr>\n";
				$message = $message . " <tr><td><span>Topic title:</span></td><td><span>$get_current_topic_title</span></td></tr>\n";
				$message = $message . " <tr><td><span>Comment user ID:</span></td><td><span>$get_current_reply_comment_user_id</span></td></tr>\n";
				$message = $message . " <tr><td><span>Comment Alias:</span></td><td><span>$get_current_reply_comment_user_alias</span></td></tr>\n";
				$message = $message . " <tr><td><span>Comment IP:</span></td><td><span>$get_current_reply_comment_user_ip</span></td></tr>\n";
				$message = $message . "</table>\n";
		

				$message = $message . "<p style='padding-bottom:0;margin-bottom:0'><b>Report:</b></p>\n";
				$message = $message . "<table>\n";
				$message = $message . " <tr><td><span>Reporter user ID:</span></td><td><span>$get_my_user_id</span></td></tr>\n";
				$message = $message . " <tr><td><span>Reporter alias:</span></td><td><span>$get_my_user_alias</span></td></tr>\n";
				$message = $message . " <tr><td><span>Reason:</span></td><td><span>$inp_reason</span></td></tr>\n";
				$message = $message . "</table>\n";


				$message = $message . "<p><b>Actions:</b><br />\n";
				$message = $message . "View: <a href=\"$view_link\">$view_link</a><br />\n";
				$message = $message . "Edit: <a href=\"$edit_link\">$edit_link</a><br />\n";
				$message = $message . "Delete: <a href=\"$delete_link\">$delete_link</a></p>";
				$message = $message . "<p>\n\n--<br />\nBest regards<br />\n$configWebsiteTitleSav</p>";
				$message = $message. "</body>\n";
				$message = $message. "</html>\n";


				// Send mail
				$headers = "MIME-Version: 1.0" . "\r\n" .
				    "Content-type: text/html; charset=iso-8859-1" . "\r\n" .
				    "To: $get_moderator_user_email" . "\r\n" .
				    "Reply-To: $discussFromEmailSav" . "\r\n" .
				    "From: $discussFromEmailSav" . "\r\n" .
				    "Reply-To: $discussFromEmailSav" . "\r\n" .
				    'X-Mailer: PHP/' . phpversion();

				mail($get_moderator_user_email, $subject, $message, $headers);


	
				$url = "view_topic.php?topic_id=$get_current_topic_id&l=$l&ft=success&fm=report_sent_to_a_moderator#replycomment$get_current_reply_comment_id";
				header("Location: $url");
				exit;

			}
			echo"
			<h1>$get_current_topic_title</h1>


			<!-- Where am I ? -->
				<p><b>$l_you_are_here</b><br />";
				if($show == "popular"){
					echo"<a href=\"index.php?show=$show&amp;l=$l\">$l_popular</a>";
				}
				elseif($show == "unanswered"){
					echo"<a href=\"index.php?show=$show&amp;l=$l\">$l_unanswered</a>";
				}
				elseif($show == "active"){
					echo"<a href=\"index.php?show=$show&amp;l=$l\">$l_active</a>";
				}
				else{
					echo"<a href=\"index.php?l=$l\">$l_discuss</a>";
				}
				echo"
				&gt;
				<a href=\"view_topic.php?topic_id=$get_current_topic_id&amp;l=$l\">$get_current_topic_title</a>
				&gt;
				<a href=\"view_topic.php?topic_id=$get_current_topic_id&amp;l=$l#replycomment$get_current_reply_comment_id\">$l_comment_by $get_current_reply_comment_user_alias</a>
				&gt;
				<a href=\"reply_comment_report.php?reply_comment_id=$get_current_reply_comment_id&amp;l=$l\">$l_report_comment</a>
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
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_reason\"]').focus();
				});
				</script>
			
				<form method=\"post\" action=\"reply_comment_report.php?reply_comment_id=$get_current_reply_comment_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
					
		
				<p><b>$l_reason:</b><br />
				<textarea name=\"inp_reason\" rows=\"5\" cols=\"50\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\"></textarea>
				</p>
		

				<p><input type=\"submit\" value=\"$l_send_report\" class=\"btn btn_default\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
				</form>
			<!-- //Form -->
			";
		} // reported
		else{
			echo"
			<h1>$get_current_topic_title</h1>


			<!-- Where am I ? -->
				<p><b>$l_you_are_here</b><br />";
				if($show == "popular"){
					echo"<a href=\"index.php?show=$show&amp;l=$l\">$l_popular</a>";
				}
				elseif($show == "unanswered"){
					echo"<a href=\"index.php?show=$show&amp;l=$l\">$l_unanswered</a>";
				}
				elseif($show == "active"){
					echo"<a href=\"index.php?show=$show&amp;l=$l\">$l_active</a>";
				}
				else{
					echo"<a href=\"index.php?l=$l\">$l_discuss</a>";
				}
				echo"
				&gt;
				<a href=\"view_topic.php?topic_id=$get_current_topic_id&amp;l=$l\">$get_current_topic_title</a>
				&gt;
				<a href=\"view_topic.php?topic_id=$get_current_topic_id&amp;l=$l#replycomment$get_current_reply_comment_id\">$l_comment_by $get_current_reply_comment_user_alias</a>
				&gt;
				<a href=\"reply_comment_report.php?reply_comment_id=$get_current_reply_comment_id&amp;l=$l\">$l_report_comment</a>
				</p>
			<!-- //Where am I ? -->

			<p>$l_comment_is_already_reported</p>
			";
		}
	}
	else{
		echo"
		<h1>
		<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
		Loading...</h1>
		<meta http-equiv=\"refresh\" content=\"1;url=$root/users/index.php?page=login&amp;l=$l&amp;refer=$root/discuss/report_topic.php?topic_id=$topic_id\">
		";
	}
} //  post found



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>