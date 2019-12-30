<?php 
/**
*
* File: comments/report_comment.php
* Version 1.0.0
* Date12:15 09.03.2019
* Copyright (c) 2019 S. A. Ditlefsen
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


/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['comment_id'])){
	$comment_id = $_GET['comment_id'];
	$comment_id = output_html($comment_id);
}
else{
	$comment_id = "";
}
$tabindex = 0;
$l_mysql = quote_smart($link, $l);


/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/comment/ts_report_comment.php");


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_report_comment";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */

// Get comment
$comment_id_mysql = quote_smart($link, $comment_id);
$query = "SELECT comment_id, comment_user_id, comment_language, comment_object, comment_object_id, comment_parent_id, comment_user_ip, comment_user_name, comment_user_avatar, comment_user_email, comment_user_subscribe, comment_created, comment_updated, comment_text, comment_likes, comment_dislikes, comment_reported, comment_report_checked FROM $t_comments WHERE comment_id=$comment_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_comment_id, $get_comment_user_id, $get_comment_language, $get_comment_object, $get_comment_object_id, $get_comment_parent_id, $get_comment_user_ip, $get_comment_user_name, $get_comment_user_avatar, $get_comment_user_email, $get_comment_user_subscribe, $get_comment_created, $get_comment_updated, $get_comment_text, $get_comment_likes, $get_comment_dislikes, $get_comment_reported, $get_comment_report_checked) = $row;

if($get_comment_id == ""){
	echo"
	<h1>Server error</h1>

	<p>
	Comment not found.
	</p>
	";
}
else{
	if($action == ""){
		if($get_comment_reported == "1"){
			echo"
			<h1>$l_comment_already_reported</h1>

			<p>
			$l_the_comment_has_already_been_reported
			</p>
			";
		}
		else{
			if($process == 1){
				$inp_email  = $_POST['inp_email'];
				$inp_email = output_html($inp_email);
				$inp_email_mysql = quote_smart($link, $inp_email);

				$inp_reason = $_POST['inp_reason'];
				$inp_reason = output_html($inp_reason);
				$inp_reason_mysql = quote_smart($link, $inp_reason);

				if(empty($inp_email)){
					$url = "report_comment.php?comment_id=$comment_id&ft=error&fm=missing_email&inp_reason=$inp_reason";
					header("Location: $url");
					exit;
				}
				if(empty($inp_reason)){
					$url = "report_comment.php?comment_id=$comment_id&ft=error&fm=missing_reason&inp_email=$inp_email";
					header("Location: $url");
					exit;
				}


				// Update
				$result = mysqli_query($link, "UPDATE $t_comments SET 
					comment_reported='1',
					comment_reported_reason=$inp_reason_mysql
					 WHERE comment_id=$get_comment_id");


				// E-mail
				$query = "SELECT user_id, user_email, user_name, user_alias, user_language FROM $t_users WHERE user_rank='admin' OR user_rank='moderator'";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_mod_user_id, $get_mod_user_email, $get_mod_user_name, $get_mod_user_alias, $get_user_language) = $row;


					$subject = "Comment $get_comment_id reported";
					$message = "Hello $get_mod_user_name,\n\n";
					$message = $message . "A comment at $configWebsiteTitleSav has been reported.\n\n";

					$message = $message . "--- Report ---\n";
					$message = $message . "E-mail: $inp_email\n";
					$message = $message . "Reason: $inp_reason\n\n";

					$message = $message . "--- Comment ---\n";
					$message = $message . "Object: $get_comment_object\n";
					$message = $message . "Object ID: $get_comment_object_id\n";
					$message = $message . "User ID: $get_comment_user_id\n";
					$message = $message . "Language: $get_comment_language\n";
					$message = $message . "User IP: $get_comment_user_ip\n";
					$message = $message . "Username: $get_comment_user_name\n";
					$message = $message . "Avatar: $get_comment_user_avatar\n";
					$message = $message . "E-mail: $get_comment_user_email\n";
					$message = $message . "Created: $get_comment_created\n";
					$message = $message . "Updated: $get_comment_updated\n";
					$message = $message . "Text: $get_comment_text\n\n";

					$message = $message . "--- Links ---\n";
					$message = $message . "Edit: $configControlPanelURLSav/index.php?open=comments&page=edit_comment&comment_id=$get_comment_object_id\n\n";
					$message = $message . "--\n";
					$message = $message . "Regards\n";
					$message = $message . "$configFromNameSav";
					$headers = "From: $configFromEmailSav" . "\r\n" .
					    "Reply-To: $configFromEmailSav" . "\r\n" .
					    'X-Mailer: PHP/' . phpversion();

					mail($get_mod_user_id, $subject, $message, $headers);
				}


				$url = "report_comment.php?action=report_sent&comment_id=$comment_id&ft=success&fm=report_sent";
				header("Location: $url");
				exit;

			}
			echo"
			<h1>$l_report_comment</h1>

			<!-- Feedback -->
				";
				if($ft != "" && $fm != ""){
					if($fm == "missing_email"){
						$fm = "$l_missing_email";
					}
					elseif($fm == "missing_reason"){
						$fm = "$l_missing_reason";
					}
					else{
						$fm = ucfirst($fm);
						$fm = str_replace("_", " ", $fm);
					}
					echo"<div class=\"$ft\"><p>$fm</p></div>";
				}
				echo"
			<!-- //Feedback -->


			<form method=\"post\" action=\"report_comment.php?comment_id=$comment_id&amp;l=$l&amp;process=1\" />
					
			<p>$l_email:<br />
			<input type=\"text\" name=\"inp_email\" value=\"";
			if(isset($_GET['inp_email'])){
				$inp_email  = $_GET['inp_email'];
				$inp_email = output_html($inp_email);
				echo"$inp_email";
			}
			echo"\" tabindex=\""; $tabindex=$tabindex+1; echo"$tabindex\" />
			</p>
	
			<p>$l_reason:<br />
			<textarea name=\"inp_reason\" rows=\"5\" cols=\"40\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">";
			if(isset($_GET['inp_reason'])){
				$inp_reason  = $_GET['inp_reason'];
				$inp_reason = output_html($inp_reason);
				$inp_reason = str_replace("<br />", "\n", $inp_reason); 
				echo"$inp_reason";
			}
			echo"</textarea>
			</p>

			<p>
			<input type=\"submit\" value=\"$l_send\" class=\"btn\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" style=\"margin-top: 4px;\" />
			</p>
			</form>
			";

		} // $get_comment_reported != 1
		
		
	} // action == ""
	elseif($action == "report_sent"){
		echo"
		<h1>$l_thank_you</h1>

		<p>
		$l_your_report_is_sent
		</p>
		";
	}
		
} // comment found



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>