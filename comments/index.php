<?php 
/**
*
* File: comments/index.php
* Version 1.0.0
* Date 20:28 16-Jul-18
* Copyright (c) 2018 Nettport.com
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
include("$root/_admin/_translations/site/$l/comment/ts_view_comments.php");


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_comments";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");


// Am I logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	// Get my user
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_rank) = $row;
}


/*- Who is moderator of the week? ---------------------------------------------------------------- */
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




/*- Content ---------------------------------------------------------------------------------- */

echo"
<h1>$l_comments</h1>
";


$current_month = date("m");


$query_groups = "SELECT comment_id, comment_user_id, comment_language, comment_object, comment_object_id, comment_parent_id, comment_user_ip, comment_user_name, comment_user_avatar, comment_user_email, comment_user_subscribe, comment_created, comment_updated, comment_text, comment_likes, comment_dislikes, comment_reported, comment_report_checked, comment_approved FROM $t_comments WHERE comment_parent_id='0' ORDER BY comment_id DESC";
$result_groups = mysqli_query($link, $query_groups);
while($row_groups = mysqli_fetch_row($result_groups)) {
	list($get_comment_id, $get_comment_user_id, $get_comment_language, $get_comment_object, $get_comment_object_id, $get_comment_parent_id, $get_comment_user_ip, $get_comment_user_name, $get_comment_user_avatar, $get_comment_user_email, $get_comment_user_subscribe, $get_comment_created, $get_comment_updated, $get_comment_text, $get_comment_likes, $get_comment_dislikes, $get_comment_reported, $get_comment_report_checked, $get_comment_approved) = $row_groups;
		
	// Date
	$date_day = substr($get_comment_updated, 8, 2);
	$date_month = substr($get_comment_updated, 5, 2);
	$date_year = substr($get_comment_updated, 0, 4);

	if($date_day < 10){
		$date_day = substr($date_day, 1, 1);
	}
	if($date_month == "01"){
		$date_month_saying = "$l_jan";
	}
	elseif($date_month == "02"){
		$date_month_saying = "$l_feb";
	}
	elseif($date_month == "03"){
		$date_month_saying = "$l_mar";
	}
	elseif($date_month == "04"){
		$date_month_saying = "$l_apr";
	}
	elseif($date_month == "05"){
		$date_month_saying = "$l_may";
	}
	elseif($date_month == "06"){
		$date_month_saying = "$l_jun";
	}
	elseif($date_month == "07"){
		$date_month_saying = "$l_jul";
	}
	elseif($date_month == "08"){
		$date_month_saying = "$l_aug";
	}
	elseif($date_month == "09"){
		$date_month_saying = "$l_sep";
	}
	elseif($date_month == "10"){
		$date_month_saying = "$l_oct";
	}
	elseif($date_month == "11"){
		$date_month_saying = "$l_nov";
	}
	else{
		$date_month_saying = "$l_dec";
	}
	
	echo"
	<a id=\"comment$get_comment_id\"></a>
	<div class=\"clear\" style=\"height:14px;\"></div>
	
	<div class=\"comment_item\">
	<p style=\"float: left;padding: 10px 18px 10px 0px;margin:0;\">
		<a href=\"$root/users/view_profile.php?user_id=$get_comment_user_id&amp;l=$l\">";
		if($get_comment_user_avatar == "" OR !(file_exists("$root/_uploads/users/images/$get_comment_user_id/$get_comment_user_avatar"))){ 
			echo"<img src=\"$root/comments/_gfx/avatar_blank_65.png\" alt=\"avatar_blank_65.png\" class=\"comment_avatar\" />";
		} 
		else{ 
			echo"	<img src=\"$root/image.php?width=65&amp;height=65&amp;cropratio=1:1&amp;image=/_uploads/users/images/$get_comment_user_id/$get_comment_user_avatar\" alt=\"$get_comment_user_avatar.png\" class=\"comment_view_avatar\" />"; 
		} 
		echo"</a>
	</p>
	
	<div style=\"overflow: hidden;\">
		<p class=\"comment_view_author\">
		<a href=\"$root/users/view_profile.php?user_id=$get_comment_user_id&amp;l=$l\" class=\"comment_view_author\">$get_comment_user_name</a>
		</p>

		<p>
		<a href=\"#comment$get_comment_id\" class=\"comment_view_date\">$date_day $date_month_saying $date_year</a></span>
		</p>

		<!-- Menu -->
			<div style=\"float: left;margin: 10px 0px 0px 4px;\">
			";
			if(isset($my_user_id)){
				if($get_comment_user_id == "$my_user_id" OR $get_my_user_rank == "admin" OR $get_my_user_rank == "moderator"){
					echo"
					<a href=\"$root/comments/edit_comment.php?comment_id=$get_comment_id&amp;referer=$referer&amp;l=$l\"><img src=\"$root/users/_gfx/edit.png\" alt=\"edit.png\" title=\"$l_edit\" /></a>
					<a href=\"$root/comments/delete_comment.php?comment_id=$get_comment_id&amp;referer=$referer&amp;l=$l\"><img src=\"$root/users/_gfx/delete.png\" alt=\"delete.png\" title=\"$l_delete\" /></a>
					";
				}
			else{
				echo"
				<a href=\"$root/comments/report_comment.php?comment_id=$get_comment_id&amp;l=$l\"><img src=\"$root/comments/_gfx/report_grey.png\" alt=\"report_grey.png\" title=\"$l_report\" /></a>
				";
			}
		}
			echo"
			</div>
			<div style=\"clear:left;\"></div>
		<!-- //Menu -->
			
		<p style=\"clear:left;margin-top: 0px;padding-top: 0;\">$get_comment_text</p>
	</div>
	</div>
	";

	// Should it be deleted?
	$delete_month = $date_month+2;
	if($get_comment_approved == "0" && $current_month == "$delete_month"){
		// Delete comment
		$result = mysqli_query($link, "DELETE FROM $t_comments WHERE comment_id=$get_comment_id");


		// Ready email 
		$host = $_SERVER['HTTP_HOST'];
		$from = "post@" . $_SERVER['HTTP_HOST'];
		$reply = "post@" . $_SERVER['HTTP_HOST'];

		// Subject
		$subject = "Comment $get_comment_id ";
		
		// Message
		$message = "<html>\n";
		$message = $message. "<head>\n";
		$message = $message. "  <title>$subject</title>\n";
		$message = $message. " </head>\n";
		$message = $message. "<body>\n";



		// Check that user is approved, else delete user
		$query = "SELECT user_id, user_email, user_name, user_alias, user_password, user_password_replacement, user_password_date, user_salt, user_security, user_language, user_gender, user_height, user_measurement, user_dob, user_date_format, user_registered, user_registered_time, user_last_online, user_last_online_time, user_rank, user_points, user_points_rank, user_likes, user_dislikes, user_status, user_login_tries, user_last_ip, user_synchronized, user_verified_by_moderator, user_notes FROM $t_users WHERE user_id=$get_comment_user_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_user_id, $get_user_email, $get_user_name, $get_user_alias, $get_user_password, $get_user_password_replacement, $get_user_password_date, $get_user_salt, $get_user_security, $get_user_language, $get_user_gender, $get_user_height, $get_user_measurement, $get_user_dob, $get_user_date_format, $get_user_registered, $get_user_registered_time, $get_user_last_online, $get_user_last_online_time, $get_user_rank, $get_user_points, $get_user_points_rank, $get_user_likes, $get_user_dislikes, $get_user_status, $get_user_login_tries, $get_user_last_ip, $get_user_synchronized, $get_user_verified_by_moderator, $get_user_notes) = $row;
		if($get_user_verified_by_moderator == "0"){
			echo"
			<p>Delete user $get_user_name</p>
			";
			
			// Delete user
			$result = mysqli_query($link, "DELETE FROM $t_users WHERE user_id=$get_user_id");
		
			// Delete profile
			$result = mysqli_query($link, "DELETE FROM $t_users_profile WHERE profile_user_id=$get_user_id");
		
			// Browse photos
			$query = "SELECT photo_id, photo_destination FROM $t_users_profile_photo WHERE photo_user_id='$get_user_id'";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_photo_id, $get_photo_destination) = $row;

				unlink("$root/_uploads/users/images/$get_user_id/$get_photo_destination");
			}
						
			// Delete photos
			$result = mysqli_query($link, "DELETE FROM $t_users_profile_photo WHERE photo_user_id='$get_user_id'");



			$subject = $subject . " and user $get_user_name deleted from $host";


			$message = $message . "<p>Comment $get_comment_id and user $get_user_name was deleted because they where 2 months old and not approved by moderator.</p>\n";
			$message = $message . "<p><b>User:</b></p>\n";
			$message = $message . "<table>\n";
			$message = $message . " <tr><td><span>Id:</span></td><td><span>$get_user_id</span></td></tr>\n";
			$message = $message . " <tr><td><span>Email:</span></td><td><span>$get_user_email</span></td></tr>\n";
			$message = $message . " <tr><td><span>Username:</span></td><td><span>$get_user_name</span></td></tr>\n";
			$message = $message . " <tr><td><span>Alias:</span></td><td><span>$get_user_alias</span></td></tr>\n";
			$message = $message . " <tr><td><span>Language:</span></td><td><span>$get_user_language</span></td></tr>\n";
			$message = $message . " <tr><td><span>Measurement:</span></td><td><span>$get_user_measurement</span></td></tr>\n";
			$message = $message . " <tr><td><span>Dob:</span></td><td><span>$get_user_dob</span></td></tr>\n";
			$message = $message . " <tr><td><span>Date format:</span></td><td><span>$get_user_date_format</span></td></tr>\n";
			$message = $message . " <tr><td><span>Registered:</span></td><td><span>$get_user_registered</span></td></tr>\n";
			$message = $message . " <tr><td><span>Last online:</span></td><td><span>$get_user_last_online</span></td></tr>\n";
			$message = $message . " <tr><td><span>Rank:</span></td><td><span>$get_user_rank</span></td></tr>\n";
			$message = $message . " <tr><td><span>Points:</span></td><td><span>$get_user_points</span></td></tr>\n";
			$message = $message . " <tr><td><span>Points rank:</span></td><td><span>$get_user_points_rank</span></td></tr>\n";
			$message = $message . " <tr><td><span>Likes:</span></td><td><span>$get_user_likes</span></td></tr>\n";
			$message = $message . " <tr><td><span>Dislikes:</span></td><td><span>$get_user_dislikes</span></td></tr>\n";
			$message = $message . " <tr><td><span>Status:</span></td><td><span>$get_user_status</span></td></tr>\n";
			$message = $message . " <tr><td><span>Login tries:</span></td><td><span>$get_user_login_tries</span></td></tr>\n";
			$message = $message . " <tr><td><span>Last ip:</span></td><td><span>$get_user_last_ip</span></td></tr>\n";
			$message = $message . " <tr><td><span>Synchronized:</span></td><td><span>$get_user_synchronized</span></td></tr>\n";
			$message = $message . " <tr><td><span>Verified by moderator:</span></td><td><span>$get_user_verified_by_moderator</span></td></tr>\n";
			$message = $message . " <tr><td><span>Notes:</span></td><td><span>$get_user_notes</span></td></tr>\n";
			$message = $message . "</table>\n";

			


		}
		else{
			$subject = $subject . " deleted from $host";
		}

		$message = $message . "<p><b>Comment:</b></p>\n";
		$message = $message . "<table>\n";
		$message = $message . " <tr><td><span>Date:</span></td><td><span>$date_day $date_month_saying $date_year</span></td></tr>\n";
		$message = $message . " <tr><td><span>Text:</span></td><td><span>$get_comment_text</span></td></tr>\n";
		$message = $message . "</table>\n";



		$message = $message . "<p>&nbsp;</p>\n";
		$message = $message . "<p>\n\n--<br />\nBest regards<br />\n$configWebsiteTitleSav<br />\n$configSiteURLSav</p>";

		$message = $message. "</body>\n";
		$message = $message. "</html>\n";

		$encoding = "utf-8";

		// Preferences for Subject field
		$subject_preferences = array(
	    		"input-charset" => $encoding,
	      		"output-charset" => $encoding,
	       		"line-length" => 76,
	       		"line-break-chars" => "\r\n"
		);
		$header = "Content-type: text/html; charset=".$encoding." \r\n";
		$header .= "From: ".$host." <".$from."> \r\n";
		$header .= "MIME-Version: 1.0 \r\n";
		$header .= "Content-Transfer-Encoding: 8bit \r\n";
		$header .= "Date: ".date("r (T)")." \r\n";
		$header .= iconv_mime_encode("Subject", $subject, $subject_preferences);
		mail($get_moderator_user_email, $subject, $message, $header);

	}

} // comments



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>