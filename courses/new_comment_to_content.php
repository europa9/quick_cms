<?php
/**
*
* File: courses/new_comment_to_content.php
* Version 2.0.0
* Date 22:38 03.05.2019
* Copyright (c) 2011-2019 Localhost
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/


/*- Root dir --------------------------------------------------------------------------------- */
// This determine where we are
if(file_exists("favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
elseif(file_exists("../../../../favicon.ico")){ $root = "../../../.."; }
else{ $root = "../../.."; }

/*- Website config --------------------------------------------------------------------------- */
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


if($content != ""){
	// Search for content
	$content_mysql = quote_smart($link, $content);
	$query = "SELECT content_id, content_course_id, content_course_dir_name, content_module_id, content_module_title_clean, content_type, content_number, content_title, content_title_clean, content_description, content_url, content_url_type, content_read_times, content_read_times_ipblock, content_created_datetime, content_created_date_formatted, content_last_read_datetime, content_last_read_date_formatted FROM $t_courses_modules_contents WHERE content_title_clean=$content_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_content_id, $get_current_content_course_id, $get_current_content_course_dir_name, $get_current_content_module_id, $get_current_content_module_title_clean, $get_current_content_type, $get_current_content_number, $get_current_content_title, $get_current_content_title_clean, $get_current_content_description, $get_current_content_url, $get_current_content_url_type, $get_current_content_read_times, $get_current_content_read_times_ipblock, $get_current_content_created_datetime, $get_current_content_created_date_formatted, $get_current_content_last_read_datetime, $get_current_content_last_read_date_formatted) = $row;

	if($get_current_content_id != ""){

		/*- Header ----------------------------------------------------------- */
		$website_title = "$get_current_content_title - $l_new_comment";
		if(file_exists("./favicon.ico")){ $root = "."; }
		elseif(file_exists("../favicon.ico")){ $root = ".."; }
		elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
		elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
		include("$root/_webdesign/header.php");


		// Can I write a comment?
		if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){

			// Find me
			$my_user_id = $_SESSION['user_id'];
			$my_user_id = output_html($my_user_id);
			$my_user_id_mysql = quote_smart($link, $my_user_id);

			$query = "SELECT user_id, user_email, user_name, user_alias FROM $t_users WHERE user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias) = $row;


			// Get my photo
			$query = "SELECT photo_id, photo_destination FROM $t_users_profile_photo WHERE photo_user_id='$get_my_user_id' AND photo_profile_image='1'";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_photo_id, $get_photo_destination) = $row;


			// Check anti spam
			$can_write_comment = 1;
			$query = "SELECT comment_id, comment_time FROM $t_courses_modules_contents_comments WHERE comment_user_id=$my_user_id_mysql ORDER BY comment_id DESC LIMIT 0,1";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_comment_id, $get_comment_time) = $row;
			if($get_comment_id != ""){
				$time = time();

				$diff = $time-$get_comment_time;
	
				if($diff < 120){
					echo"
					<h1>$l_hello</h1>
					<div class=\"info\">
						<p><b>$l_anti_spam</b><br />
						$l_please_wait_five_minutes_before_posting_a_new_comment</p>
					</div>
					";
					$can_write_comment = 0;
				}
			}



			if($can_write_comment == 1){
				if($process == "1"){

					$inp_text = $_POST['inp_text'];
					$inp_text = output_html($inp_text);
					$inp_text_mysql = quote_smart($link, $inp_text);

					if(empty($inp_text)){
						
						$url = "new_comment_to_content.php?course=$course&module=$module&content=$content&l=$l&ft=error&fm=missing_text";
						header("Location: $url");
						exit;
					}

					// lang
					$l_mysql = quote_smart($link, $l);

					// Datetime and time
					$datetime = date("Y-m-d H:i:s");
					$time = time();

					// Datetime print
					$year = substr($datetime, 0, 4);
					$month = substr($datetime, 5, 2);
					$day = substr($datetime, 8, 2);

					if($day < 10){
						$day = substr($day, 1, 1);
					}
			
					if($month == "01"){
						$month_saying = $l_january;
					}
					elseif($month == "02"){
						$month_saying = $l_february;
					}
					elseif($month == "03"){
						$month_saying = $l_march;
					}
					elseif($month == "04"){
						$month_saying = $l_april;
					}
					elseif($month == "05"){
						$month_saying = $l_may;
					}
					elseif($month == "06"){
						$month_saying = $l_june;
					}
					elseif($month == "07"){
						$month_saying = $l_july;
					}
					elseif($month == "08"){
						$month_saying = $l_august;
					}
					elseif($month == "09"){
						$month_saying = $l_september;
					}
					elseif($month == "10"){
						$month_saying = $l_october;
					}
					elseif($month == "11"){
						$month_saying = $l_november;
					}
					else{
						$month_saying = $l_december;
					}

					$inp_comment_date_print = "$day $month_saying $year";

					// Alias
					$inp_comment_user_alias_mysql = quote_smart($link, $get_my_user_alias);

					// Image
					$inp_comment_user_image_path_mysql = quote_smart($link, "_uploads/users/images/$get_my_user_id");

					// Image make a thumb
					if($get_photo_destination != ""){
						$inp_new_x = 65; // 950
						$inp_new_y = 65; // 640
						$thumb_full_path = "$root/_uploads/users/images/$get_my_user_id/user_" . $get_my_user_id . "-" . $inp_new_x . "x" . $inp_new_y . ".png";
						if(!(file_exists("$thumb_full_path"))){
							resize_crop_image($inp_new_x, $inp_new_y, "$root/_uploads/users/images/$get_my_user_id/$get_photo_destination", "$thumb_full_path");
						}
						$inp_comment_user_image_file = "user_" . $get_my_user_id . "-" . $inp_new_x . "x" . $inp_new_y . ".png";
					}
					else{
						$inp_comment_user_image_file = "";
					}
					$inp_comment_user_image_file_mysql = quote_smart($link, $inp_comment_user_image_file);
	
					// Ip 
					$inp_ip = $_SERVER['REMOTE_ADDR'];
					$inp_ip = output_html($inp_ip);
					$inp_ip_mysql = quote_smart($link, $inp_ip);

					$inp_hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
					$inp_hostname = output_html($inp_hostname);
					$inp_hostname_mysql = quote_smart($link, $inp_hostname);

					$inp_user_agent = $_SERVER['HTTP_USER_AGENT'];
					$inp_user_agent = output_html($inp_user_agent);
					$inp_user_agent_mysql = quote_smart($link, $inp_user_agent);

					$inp_comment_course_id_mysql = quote_smart($link, $get_current_content_course_id);
					$inp_comment_course_dir_name_mysql = quote_smart($link, $get_current_content_course_dir_name);

					$inp_comment_module_id_mysql = quote_smart($link, $get_current_content_module_id);
					$inp_comment_module_title_clean_mysql = quote_smart($link, $get_current_content_module_title_clean);

					$inp_comment_content_id_mysql = quote_smart($link, $get_current_content_id);
					$inp_comment_content_title_clean_mysql = quote_smart($link, $get_current_content_title_clean);

					mysqli_query($link, "INSERT INTO $t_courses_modules_contents_comments
					(comment_id, comment_course_id, comment_course_dir_name, comment_module_id, comment_module_title_clean, comment_content_id, comment_content_title_clean, comment_language, comment_approved, comment_datetime, comment_time, comment_date_print, comment_user_id, comment_user_alias, 
					comment_user_image_path, comment_user_image_file, comment_user_ip, comment_user_hostname, comment_user_agent, 
					comment_text, comment_helpful_clicks, comment_useless_clicks, comment_marked_as_spam, comment_spam_checked, comment_spam_checked_comment) 
					VALUES 
					(NULL, $inp_comment_course_id_mysql, $inp_comment_course_dir_name_mysql, $inp_comment_module_id_mysql, $inp_comment_module_title_clean_mysql, $inp_comment_content_id_mysql, $inp_comment_content_title_clean_mysql, $l_mysql, '1', '$datetime', '$time', '$inp_comment_date_print', '$get_my_user_id', $inp_comment_user_alias_mysql, 
					$inp_comment_user_image_path_mysql, $inp_comment_user_image_file_mysql, $inp_ip_mysql, $inp_hostname_mysql, $inp_user_agent_mysql, 
					$inp_text_mysql, '0', '0', '0', '0', '')")
					or die(mysqli_error($link));
				
					// Get comment id
					$query = "SELECT comment_id FROM $t_courses_modules_contents_comments WHERE comment_time='$time'";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_comment_id) = $row;


				
				

					// Email to moderators
					$read_comment_url = "$configSiteURLSav/$get_current_content_course_dir_name/$get_current_content_module_title_clean/$get_current_content_url";
					if($get_current_content_url_type == "dir"){ $read_comment_url = $read_comment_url . "/index.php"; } 
					$read_comment_url = $read_comment_url . "?course=$get_current_content_course_dir_name&amp;module=$get_current_content_module_title_clean&amp;content=$get_current_content_title_clean&amp;l=$l#comment$get_comment_id";

					$query = "SELECT user_id, user_email, user_name, user_alias, user_language FROM $t_users WHERE user_rank='admin' OR user_rank='moderator'";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_mod_user_id, $get_mod_user_email, $get_mod_user_name, $get_mod_user_alias, $get_user_language) = $row;
						
						if($get_my_user_email != "$get_mod_user_email"){
							$subject = "$get_current_content_title $l_new_comment_lowercase ($inp_comment_date_print)";
						

							$message = "<html>\n";
							$message = $message. "<head>\n";
							$message = $message. "  <title>$subject</title>\n";
							$message = $message. " </head>\n";
							$message = $message. "<body>\n";

							$message = $message. "<p>$l_hello,</p>\n";

							$message = $message. "<p>\n";
							$message = $message. "$l_there_is_a_new_comment_to_the_course_content $get_current_content_title $l_at_lowercase $configWebsiteTitleSav.<br />\n";
							$message = $message. "$l_follow_the_url_to_read_the_comment<br />\n";
							$message = $message. "<a href=\"$read_comment_url\">$read_comment_url</a>\n";
							$message = $message. "</p>\n";

							$message = $message. "<p>\n";
							$message = $message. "--<br />\n";
							$message = $message. "$l_regards<br />\n";
							$message = $message. "$configFromNameSav<br />\n";
							$message = $message. "$l_email: $configFromEmailSav<br />\n";
							$message = $message. "$l_web: $configWebsiteTitleSav\n";
							$message = $message. "</p>";

							$message = $message. "</body>\n";
							$message = $message. "</html>\n";

							$headers_mail_mod = array();
							$headers_mail_mod[] = 'MIME-Version: 1.0';
							$headers_mail_mod[] = 'Content-type: text/html; charset=utf-8';
							$headers_mail_mod[] = "From: $configFromNameSav <" . $configFromEmailSav . ">";

							mail($get_mod_user_email, $subject, $message, implode("\r\n", $headers_mail_mod));
						}
					} // while e-mail



					// Header
					$url = "$root/$get_current_content_course_dir_name/$get_current_content_module_title_clean/$get_current_content_url";
					if($get_current_content_url_type == "dir"){ $url = $url . "/index.php"; } 
					$url = $url . "?course=$get_current_content_course_dir_name&module=$get_current_content_module_title_clean&content=$get_current_content_title_clean&l=$l&ft=success&fm=comment_saved#comment$get_comment_id";
					header("Location: $url");
					exit;

				

				} // process == 1
			
        			echo" 
				<h1>$l_new_comment</h1>

			
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
					<a href=\"new_comment_to_content.php?course=$get_current_content_course_dir_name&amp;module=$get_current_content_module_title_clean&amp;content=$get_current_content_title_clean&amp;l=$l\">$l_new_comment</a>

					</p>
				<!-- //You are here -->
			
				<!-- New comment form -->

					<form method=\"post\" action=\"new_comment_to_content.php?course=$get_current_content_course_dir_name&amp;module=$get_current_content_module_title_clean&amp;content=$get_current_content_title_clean&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
			
					<!-- Focus -->
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_text\"]').focus();
						});
						</script>
					<!-- //Focus -->

					<p><b>$l_comment:</b><br />
					<textarea name=\"inp_text\" rows=\"8\" cols=\"30\" class=\"comment_textarea\">";
					if(isset($_GET['inp_text'])) { $inp_text = $_GET['inp_text']; $inp_text = strip_tags(stripslashes($inp_text)); echo"$inp_text"; } echo"</textarea>
					</p>

					<p>
					<input type=\"submit\" value=\"$l_post_comment\" class=\"btn_default\" />
					</p>
					</form>
				<!-- //New comment form -->
				";

			} // can write comment
		} // logged in
		else{
			echo"
			<h1>
			<img src=\"$root/courses/_images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
			Loading...</h1>
			<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/courses/new_comment_to_content.php?course=$get_current_content_course_dir_name&amp;module=$get_current_content_module_title_clean&amp;content=$get_current_content_title_clean&amp;l=$l\">
			";
		}
	} // content not found
	else{
		/*- Header ----------------------------------------------------------- */
		$website_title = "Server error 404 #1";
		if(file_exists("./favicon.ico")){ $root = "."; }
		elseif(file_exists("../favicon.ico")){ $root = ".."; }
		elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
		elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
		include("$root/_webdesign/header.php");
		echo"<p>Server error 404 #1</p>";
	}
} // not content
else{

	/*- Header ----------------------------------------------------------- */
	$website_title = "Server error 404 #2";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");
	echo"<p>Server error 404 #2</p>";
}


/*- Footer ----------------------------------------------------------- */
include("$root/_webdesign/footer.php");





?>