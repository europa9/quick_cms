<?php 
/**
*
* File: comments/edit_comment.php
* Version 1.0.0
* Date 23:59 27.11.2017
* Copyright (c) 2011-2017 Localhost
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
if(isset($_GET['referer'])){
	$referer = $_GET['referer'];
	$referer = output_html($referer);
}
else{
	$referer = "";
}
$tabindex = 0;
$l_mysql = quote_smart($link, $l);


/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/comment/ts_edit_comment.php");


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_edit_comment";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */
// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
	// Get my profile
	$my_user_id = $_SESSION['user_id'];
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	$query = "SELECT user_id, user_alias, user_email, user_date_format FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_alias, $get_my_user_email, $get_my_user_date_format) = $row;

	// Get my profile image
	$q = "SELECT photo_id, photo_destination FROM $t_users_profile_photo WHERE photo_user_id=$my_user_id_mysql AND photo_profile_image='1'";
	$r = mysqli_query($link, $q);
	$rowb = mysqli_fetch_row($r);
	list($get_my_photo_id, $get_my_photo_destination) = $rowb;

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
		if($get_comment_user_id == "$my_user_id" OR $get_my_user_rank == "admin" OR $get_my_user_rank == "moderator"){


		

			if($process == 1){
			
				$inp_comment_text = $_POST['inp_comment_text'];
				$inp_comment_text = output_html($inp_comment_text);
				$inp_comment_text_mysql = quote_smart($link, $inp_comment_text);


				if($inp_comment_text = ""){
					$url = "edit_comment.php?comment_id=$comment_id&referer=$referer&l=$l&ft=error&fm=missing_comment";
					header("Location: $url");
					exit;
				}


				$inp_comment_user_name_mysql = quote_smart($link, $get_my_user_alias);
				$inp_comment_user_avatar_mysql = quote_smart($link, $get_my_photo_destination);
				$inp_comment_user_email_mysql = quote_smart($link, $get_my_user_email);
				$inp_comment_updated = date("Y-m-d H:i:s");

				$inp_user_ip = $_SERVER['REMOTE_ADDR'];
				$inp_user_ip = output_html($inp_user_ip);
				$inp_user_ip_mysql = quote_smart($link, $inp_user_ip);



				// Update
				$result = mysqli_query($link, "UPDATE $t_comments SET 
					comment_user_ip=$inp_user_ip_mysql,
					comment_user_name=$inp_comment_user_name_mysql, 
					comment_user_avatar=$inp_comment_user_avatar_mysql, 
					comment_user_email=$inp_comment_user_email_mysql, 
					comment_updated='$inp_comment_updated',
					comment_text=$inp_comment_text_mysql
				 WHERE comment_id=$get_comment_id");


			 
				// Header
				$ft = "success";
				$fm = "changes_saved";
				$url = "$referer#comment$get_comment_id";
				header("Location: $url");
				exit;
			} // process


			echo"
			<h1>$l_edit_comment</h1>

			<!-- Feedback -->
				";
				if($ft != "" && $fm != ""){
					if($fm == "x"){
						$fm = "x";
					}
					else{
						$fm = ucfirst($fm);
					}
					echo"<div class=\"$ft\"><p>$fm</p></div>";	
				}
				echo"

			<!-- //Feedback -->

			<div style=\"float: left;padding-right: 10px;\">
				<p>
				";
				if($get_my_photo_id != ""){
					echo"
					<img src=\"$root/image.php?width=648&amp;height=64&amp;cropratio=1:1&amp;image=/_uploads/users/images/$my_user_id/$get_my_photo_destination\" alt=\"$get_my_photo_destination\" />
					";
				}
				else{
					echo"<img src=\"$root/recipes/_gfx/avatar_blank_64.png\" alt=\"avatar_blank_64.png\" />";
				}
				echo"
				</p>
			</div>
			<div style=\"float: left\">
			
				<form method=\"post\" action=\"edit_comment.php?comment_id=$comment_id&amp;referer=$referer&amp;l=$l&amp;process=1\" />
					
					<p>
					<textarea name=\"inp_comment_text\" rows=\"2\" cols=\"40\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">"; 
					$get_comment_text = str_replace("<br />", "\n", $get_comment_text); echo"$get_comment_text</textarea><br />
					<input type=\"submit\" value=\"$l_save\" class=\"btn\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" style=\"margin-top: 4px;\" />
					</p>
				</form>
			</div>

			";
		} 
		else{
			echo"
			<h1>Access denined</h1>
			<p>Only the owner, admin or moderator can edit the comment.</p>
			";
		}
	} // comment not found
}
else{
	echo"
	<h1>
	<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/index.php?page=login&amp;l=$l\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>