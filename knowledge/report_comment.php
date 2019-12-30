<?php 
/**
*
* File: howto/report_comment.php
* Version 1.0
* Date 14:55 30.06.2019
* Copyright (c) 2019 S. A. Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "2";
$pageNoColumnSav      = "2";
$pageAllowCommentsSav = "1";
$pageAuthorUserIdSav  = "1";

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

/*- Translations ----------------------------------------------------------------------------- */
include("$root/_admin/_translations/site/$l/knowledge/ts_new_page.php");
include("$root/_admin/_translations/site/$l/knowledge/ts_new_comment_to_page.php");

/*- Functions ------------------------------------------------------------------------- */
include("$root/_admin/_functions/encode_national_letters.php");
include("$root/_admin/_functions/decode_national_letters.php");


/*- Variables -------------------------------------------------------------------------------- */
$tabindex = 0;
if (isset($_GET['space_id'])) {
	$space_id = $_GET['space_id'];
	$space_id = stripslashes(strip_tags($space_id));
}
else{
	$space_id = "";
}
$space_id_mysql = quote_smart($link, $space_id);

if (isset($_GET['page_id'])) {
	$page_id = $_GET['page_id'];
	$page_id = stripslashes(strip_tags($page_id));
}
else{
	$page_id = "";
}
$page_id_mysql = quote_smart($link, $page_id);

if (isset($_GET['comment_id'])) {
	$comment_id = $_GET['comment_id'];
	$comment_id = stripslashes(strip_tags($comment_id));
}
else{
	$comment_id = "";
}
$comment_id_mysql = quote_smart($link, $comment_id);

// Find space
$query = "SELECT space_id, space_title, space_title_clean, space_description, space_image, space_is_archived, space_unique_hits, space_unique_hits_ip_block, space_unique_hits_user_id_block, space_created_datetime, space_created_date_saying, space_created_user_id, space_created_user_alias, space_created_user_image, space_updated_datetime, space_updated_date_saying, space_updated_user_id, space_updated_user_alias, space_updated_user_image FROM $t_knowledge_spaces_index WHERE space_id=$space_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_space_id, $get_current_space_title, $get_current_space_title_clean, $get_current_space_description, $get_current_space_image, $get_current_space_is_archived, $get_current_space_unique_hits, $get_current_space_unique_hits_ip_block, $get_current_space_unique_hits_user_id_block, $get_current_space_created_datetime, $get_current_space_created_date_saying, $get_current_space_created_user_id, $get_current_space_created_user_alias, $get_current_space_created_user_image, $get_current_space_updated_datetime, $get_current_space_updated_date_saying, $get_current_space_updated_user_id, $get_current_space_updated_user_alias, $get_current_space_updated_user_image) = $row;

if($get_current_space_id == ""){
	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "404 server error";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");

	echo"
	<h1>Server error 404</h1>

	<p>Space not found.</p>
	";
}
else{
	// Find page
	$query = "SELECT page_id, page_space_id, page_title, page_title_clean, page_description, page_text, page_parent_id, page_no_of_children, page_weight, page_allow_comments, page_no_of_comments, page_unique_hits, page_unique_hits_ip_block, page_unique_hits_user_id_block, page_created_datetime, page_created_date_saying, page_created_user_id, page_created_user_alias, page_created_user_email, page_created_user_image, page_created_subscribe_to_comments, page_updated_datetime, page_updated_date_saying, page_updated_user_id, page_updated_user_alias, page_updated_user_email, page_updated_user_image, page_updated_subscribe_to_comments, page_updated_info, page_version FROM $t_knowledge_pages_index WHERE page_id=$page_id_mysql AND page_space_id=$get_current_space_id";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_page_id, $get_current_page_space_id, $get_current_page_title, $get_current_page_title_clean, $get_current_page_description, $get_current_page_text, $get_current_page_parent_id, $get_current_page_no_of_children, $get_current_page_weight, $get_current_page_allow_comments, $get_current_page_no_of_comments, $get_current_page_unique_hits, $get_current_page_unique_hits_ip_block, $get_current_page_unique_hits_user_id_block, $get_current_page_created_datetime, $get_current_page_created_date_saying, $get_current_page_created_user_id, $get_current_page_created_user_alias, $get_current_page_created_user_email, $get_current_page_created_user_image, $get_current_page_created_subscribe_to_comments, $get_current_page_updated_datetime, $get_current_page_updated_date_saying, $get_current_page_updated_user_id, $get_current_page_updated_user_alias, $get_current_page_updated_user_email, $get_current_page_updated_user_image, $get_current_page_updated_subscribe_to_comments, $get_current_page_updated_info, $get_current_page_version) = $row;

	if($get_current_page_id == ""){
		/*- Headers ---------------------------------------------------------------------------------- */
		$website_title = "404 server error";
		if(file_exists("./favicon.ico")){ $root = "."; }
		elseif(file_exists("../favicon.ico")){ $root = ".."; }
		elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
		elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
		include("$root/_webdesign/header.php");

		echo"
		<h1>Server error 404</h1>

		<p>Page not found.</p>
		";
	}
	else{
		/*- Headers ---------------------------------------------------------------------------------- */
		$website_title = "$get_current_space_title - $get_current_page_title - $l_report_comment";
		if(file_exists("./favicon.ico")){ $root = "."; }
		elseif(file_exists("../favicon.ico")){ $root = ".."; }
		elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
		elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
		include("$root/_webdesign/header.php");


		// Check if I have access
		if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
			$my_user_id = $_SESSION['user_id'];
			$my_user_id = output_html($my_user_id);
			$my_user_id_mysql = quote_smart($link, $my_user_id);

			// Access?
			$query = "SELECT member_id, member_space_id, member_rank, member_user_id, member_user_alias, member_user_image, member_user_about, member_added_datetime, member_added_date_saying, member_added_by_user_id, member_added_by_user_alias, member_added_by_user_image FROM $t_knowledge_spaces_members WHERE member_space_id=$space_id_mysql AND member_user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_member_id, $get_member_space_id, $get_member_rank, $get_member_user_id, $get_member_user_alias, $get_member_user_image, $get_member_user_about, $get_member_added_datetime, $get_member_added_date_saying, $get_member_added_by_user_id, $get_member_added_by_user_alias, $get_member_added_by_user_image) = $row;
			if($get_member_id == ""){
				echo"
				<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> Server error 403</h1>
		
				<meta http-equiv=\"refresh\" content=\"1;url=view_page.php?space_id=$get_current_page_space_id&amp;page_id=$get_current_page_id&amp;l=$l&amp;ft=warning&amp;fm=your_not_a_member_of_this_space\">
				";
			}
			else{


				// Find comment
				$query = "SELECT comment_id, comment_page_id, comment_parent_comment_id, comment_title, comment_text, comment_approved, comment_datetime, comment_time, comment_date_print, comment_user_id, comment_user_alias, comment_user_email, comment_user_image_file, comment_user_ip, comment_user_hostname, comment_user_agent, comment_subscribe_to_new_comments, comment_rating, comment_helpful_clicks, comment_useless_clicks, comment_marked_as_spam, comment_spam_checked, comment_spam_checked_comment, comment_read_by_page_author FROM $t_knowledge_pages_comments WHERE comment_id=$comment_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_comment_id, $get_current_comment_page_id, $get_current_comment_parent_comment_id, $get_current_comment_title, $get_current_comment_text, $get_current_comment_approved, $get_current_comment_datetime, $get_current_comment_time, $get_current_comment_date_print, $get_current_comment_user_id, $get_current_comment_user_alias, $get_current_comment_user_email, $get_current_comment_user_image_file, $get_current_comment_user_ip, $get_current_comment_user_hostname, $get_current_comment_user_agent, $get_current_comment_subscribe_to_new_comments, $get_current_comment_rating, $get_current_comment_helpful_clicks, $get_current_comment_useless_clicks, $get_current_comment_marked_as_spam, $get_current_comment_spam_checked, $get_current_comment_spam_checked_comment, $get_current_comment_read_by_page_author) = $row;
				if($get_current_comment_id == ""){
					echo"
					<h1>$l_comment_not_found</h1>

					<p>
					<a href=\"view_page.php?space_id=$get_current_page_space_id&amp;page_id=$get_current_page_id&amp;l=$l\">$get_current_page_title</a>
					</p>
					";
				}
				else{
					// Is it reported already?
					if($get_current_comment_marked_as_spam != "1"){


						if($process == "1"){
							$inp_reason = $_POST['inp_reason'];
							$inp_reason = output_html($inp_reason);
							$inp_reason_mysql = quote_smart($link, $inp_reason);

							// IP
							$my_ip = $_SERVER['REMOTE_ADDR'];
							$my_ip = output_html($inp_ip);
							$my_ip_mysql = quote_smart($link, $inp_ip);

							$my_hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
							$my_hostname = output_html($inp_hostname);
							$my_hostname_mysql = quote_smart($link, $inp_hostname);

							$my_user_agent = $_SERVER['HTTP_USER_AGENT'];
							$my_user_agent = output_html($user_agent);
							$my_user_agent_mysql = quote_smart($link, $user_agent);

							$datetime = date("Y-m-d H:i:s");
							$date_saying = date("j M Y");
							$time = time();
					
							// Update
							$result = mysqli_query($link, "UPDATE $t_knowledge_pages_comments SET 
									comment_marked_as_spam='1'
									WHERE comment_id=$get_current_comment_id");

							// Mail to admin and moderator
							$subject = "$l_comment $get_current_comment_id $l_reported_lowercase - $get_current_comment_title";
							$message = $message . "$l_comment_id: $get_current_comment_id\n";

							$message = $message . "$l_title: $get_current_comment_title\n";
							$message = $message . "$l_author_id: $get_current_comment_user_id\n";
							$message = $message . "$l_author: $get_current_comment_user_alias\n";
							$message = $message . "$l_email: $get_current_comment_user_email\n";
							$message = $message . "$l_date: $date_saying ($get_current_comment_datetime)\n";
							$message = $message . "$l_ip: $get_current_comment_user_ip\n";
							$message = $message . "$l_hostname: $get_current_comment_user_hostname\n";
							$message = $message . "$l_user_agent: $get_current_comment_user_agent\n";
							$message = $message . "$l_email: $get_my_user_email\n";
							$message = $message . "$l_comment: $get_current_comment_text\n";
							$message = $message . "$l_reason: $inp_reason\n";
							$message = $message . "$l_read_link: $configSiteURLSav/view_page.php?space_id=$space_id&page_id=$get_current_page_id#comment$get_current_comment_id\n\n";

							$message = $message . "--\n";
							$message = $message . "$l_regards\n";
							$message = $message . "$configFromNameSav\n";
							$message = $message . "$configWebsiteTitleSav\n";
							$message = $message . "$configFromEmailSav";


							$query = "SELECT member_id, member_space_id, member_rank, member_user_id, member_user_alias, member_user_email, member_user_image, member_user_about, member_added_datetime, member_added_date_saying, member_added_by_user_id, member_added_by_user_alias, member_added_by_user_image FROM $t_knowledge_spaces_members WHERE member_space_id=$get_current_space_id AND (member_rank='admin' OR member_rank='moderator')";
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_row($result)) {
								list($get_member_id, $get_member_space_id, $get_member_rank, $get_member_user_id, $get_member_user_alias, $get_member_user_email, $get_member_user_image, $get_member_user_about, $get_member_added_datetime, $get_member_added_date_saying, $get_member_added_by_user_id, $get_member_added_by_user_alias, $get_member_added_by_user_image) = $row;
								$send_message = "$l_hello $get_member_user_alias,\n\n" . $message;
								mail($get_member_user_email, $subject, $send_message, $headers);
							}

							// header
							$url = "view_page.php?space_id=$space_id&page_id=$get_current_page_id&ft_comment=success&fm_comment=comment_reported#comment$get_current_comment_id";
							header("Location: $url");
							exit;
						} // process
	
						echo"
						<h1>$l_report_comment</h1>
	
						<!-- Where am I ? -->
							<p><b>$l_you_are_here:</b><br />";

			
							if($get_current_page_parent_id != "0"){
								// Find parent
								$query = "SELECT page_id, page_space_id, page_title, page_parent_id FROM $t_knowledge_pages_index WHERE page_id=$get_current_page_parent_id AND page_space_id=$get_current_space_id";
								$result = mysqli_query($link, $query);
								$row = mysqli_fetch_row($result);
								list($get_parent_a_page_id, $get_parent_a_page_space_id, $get_parent_a_page_title, $get_parent_a_page_parent_id) = $row;


								if($get_parent_a_page_parent_id != "0" && $get_parent_a_page_parent_id != ""){
									// Find parent
									$query = "SELECT page_id, page_space_id, page_title, page_parent_id FROM $t_knowledge_pages_index WHERE page_id=$get_parent_a_page_parent_id AND page_space_id=$get_current_space_id";
									$result = mysqli_query($link, $query);
									$row = mysqli_fetch_row($result);
									list($get_parent_b_page_id, $get_parent_b_page_space_id, $get_parent_b_page_title, $get_parent_b_page_parent_id) = $row;


									if($get_parent_b_page_parent_id != "0"){
										// Find parent
										$query = "SELECT page_id, page_space_id, page_title, page_parent_id FROM $t_knowledge_pages_index WHERE page_id=$get_parent_b_page_parent_id AND page_space_id=$get_current_space_id";
										$result = mysqli_query($link, $query);
										$row = mysqli_fetch_row($result);
										list($get_parent_c_page_id, $get_parent_c_page_space_id, $get_parent_c_page_title, $get_parent_c_page_parent_id) = $row;

										echo"
										<a href=\"view_page.php?space_id=$get_current_page_space_id&amp;page_id=$get_parent_c_page_id&amp;l=$l\">$get_parent_c_page_title</a>
										&gt; ";
									}
									echo"
									<a href=\"view_page.php?space_id=$get_current_page_space_id&amp;page_id=$get_parent_b_page_id&amp;l=$l\">$get_parent_b_page_title</a>
									&gt; ";
								}
								echo"
								<a href=\"view_page.php?space_id=$get_current_page_space_id&amp;page_id=$get_parent_a_page_id&amp;l=$l\">$get_parent_a_page_title</a>
								&gt; ";
							}
							echo"
				
							<a href=\"view_page.php?space_id=$get_current_page_space_id&amp;page_id=$get_current_page_id&amp;l=$l\">$get_current_page_title</a>
							&gt;
							<a href=\"report_comment.php?space_id=$get_current_page_space_id&amp;page_id=$get_current_page_id&amp;l=$l\">$l_report_comment</a>
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
									$fm = str_replace("_", " ", $fm);
								}
								echo"<div class=\"$ft\"><span>$fm</span></div>";
							}
							echo"	
						<!-- //Feedback -->

				
						<!-- Report comment Form -->
							<script>
							\$(document).ready(function(){
								\$('[name=\"inp_reason\"]').focus();
							});
							</script>
							<!-- //Focus -->
							<form method=\"POST\" action=\"report_comment.php?space_id=$space_id&amp;page_id=$get_current_page_id&amp;comment_id=$get_current_comment_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

							<p><b>$l_reason</b><br />
							<textarea name=\"inp_reason\" cols=\"20\" style=\"width: 100%;min-height:200px\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\"></textarea>
							</p>


							<p>
							<input type=\"submit\" value=\"$l_send_report\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
							</p>
							</form>
						<!-- //Report comment Form -->
						";
					} // not reported
					else{
						echo"
						<h1>$l_comment_already_reported</h1>
						<p>$l_the_comment_is_already_reported</p>

						<p>
						<a href=\"view_page.php?space_id=$get_current_page_space_id&amp;page_id=$get_current_page_id&amp;l=$l\">$get_current_page_title</a>
						</p>
						";
					}
				} // comment found
		
			} // is member of space
		} // logged in
		else{
			$url = "$root/users/login.php?l=$l&amp;referer=$root/knowledge/new_comment_to_page.php?space_id=$get_current_page_space_id" . "amp;page_id=$get_current_page_id";
			echo"
			<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> $l_new_comment - Please log in...</h1>
		
			<p><a href=\"$url\">$url</a></p>

			<meta http-equiv=\"refresh\" content=\"1;url=$url\">
			";
			
		}
	} // page found
} // space found


/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/$webdesignSav/footer.php");
?>