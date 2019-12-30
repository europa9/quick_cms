<?php

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
					$inp_text = $_POST['inp_text'];
					$inp_text = output_html($inp_text);
					$inp_text_mysql = quote_smart($link, $inp_text);

					if(empty($inp_text)){
						$url = "edit_comment_to_content.php?comment_id=$get_current_comment_id&course=$course&module=$module&content=$content&l=$l&ft=error&fm=missing_text";
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


	
					// Ip 
					$inp_ip = $_SERVER['REMOTE_ADDR'];
					$inp_ip = output_html($inp_ip);
					$inp_ip_mysql = quote_smart($link, $inp_ip);

					$inp_hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
					$inp_hostname = output_html($inp_hostname);
					$inp_hostname_mysql = quote_smart($link, $inp_hostname);

					$inp_user_agent = $_SERVER['HTTP_USER_AGENT'];
					$inp_user_agent = output_html($user_agent);
					$inp_user_agent_mysql = quote_smart($link, $user_agent);



					$result = mysqli_query($link, "UPDATE $t_courses_modules_contents_comments SET 
comment_datetime='$datetime', 
comment_time='$time', 
comment_date_print='$inp_comment_date_print', 
comment_user_ip=$inp_ip_mysql, 
comment_user_hostname=$inp_hostname_mysql, 
comment_user_agent=$inp_user_agent_mysql, 
comment_text=$inp_text_mysql
 WHERE comment_id=$get_current_comment_id") or die(mysqli_error($link));


					// Header
					$url = "$root/$get_current_content_course_dir_name/$get_current_content_module_title_clean/$get_current_content_url";
					if($get_current_content_url_type == "dir"){ $url = $url . "/index.php"; } 
					$url = $url . "?course=$get_current_content_course_dir_name&module=$get_current_content_module_title_clean&content=$get_current_content_title_clean&l=$l&ft=success&fm=changes_saved#comment$get_current_comment_id";
					header("Location: $url");
					exit;

				} // process

				echo"
				<h1>$l_edit_comment</h1>

			
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
					<a href=\"edit_comment_to_content.php?comment_id=$comment_id&amp;course=$get_current_content_course_dir_name&amp;module=$get_current_content_module_title_clean&amp;content=$get_current_content_title_clean&amp;l=$l\">$l_edit_comment</a>
					</p>
				<!-- //You are here -->


				<!-- Edit comment form -->

					<form method=\"post\" action=\"edit_comment_to_content.php?comment_id=$comment_id&amp;course=$get_current_content_course_dir_name&amp;module=$get_current_content_module_title_clean&amp;content=$get_current_content_title_clean&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
			
					<!-- Focus -->
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_text\"]').focus();
						});
						</script>
					<!-- //Focus -->

					<p><b>$l_comment:</b><br />
					<textarea name=\"inp_text\" rows=\"8\" cols=\"30\" class=\"comment_textarea\">";
					$get_current_comment_text = strip_tags(stripslashes($get_current_comment_text)); echo"$get_current_comment_text"; 
					echo"</textarea>
					</p>

					<p>
					<input type=\"submit\" value=\"$l_save\" class=\"btn_default\" />
					</p>
					</form>
				<!-- //Edit comment form -->
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