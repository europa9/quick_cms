<?php 
/**
*
* File: comments/decline_comment.php
* Version 1.0.0
* Date 11:40 13.05.2018
* Copyright (c) 2011-2018 Localhost
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
include("$root/_admin/_translations/site/$l/comment/ts_decline_comment.php");


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_decline_comment";
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

	if (isset($_GET['security'])) {
		$security = $_GET['security'];
		$security = stripslashes(strip_tags($security));
	}
	else{
		$security = "";
	}


	$get_comment_created_encryped = md5("$get_comment_created");

	if($security != "$get_comment_created_encryped"){
		echo"
		<h1>Server error</h1>
		<p>
		Wrong security key.
		</p>
		";
	}
	else{


		// Decline comment
		$result = mysqli_query($link, "DELETE FROM $t_comments WHERE comment_id=$get_comment_id");

		// Decline comment user id
		// $result = mysqli_query($link, "UPDATE $t_users SET user_verified_by_moderator='1' WHERE user_id=$get_comment_user_id");

		echo"
		<h1>$l_comment_declined</h1>

		<!-- Show comment -->
			<p><b>$get_comment_user_name:</b><br />
			$get_comment_text
			</p>
		<!-- //Show comment -->
		
		";
		
	}  // security key ok
} // comment found



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>