<?php
/**
*
* File: comments/new_comment.php
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
include("$root/_admin/_data/config/comments_settings.php");
include("$root/_admin/_data/logo.php");


/*- Language ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/comment/ts_new_comment.php");
include("$root/_admin/_translations/site/$l/users/ts_login.php");


/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['object'])){
	$object = $_GET['object'];
	$object = output_html($object);	
	$object_mysql = quote_smart($link, $object);
	if(empty($object)){
		echo"<p>Object empty</p>"; die;
	}
}
else{
	echo"<p>Missing object</p>"; die;
}
if(isset($_GET['object_id'])){
	$object_id = $_GET['object_id'];
	$object_id = output_html($object_id);
	$object_id_mysql = quote_smart($link, $object_id);
	if(empty($object_id)){
		echo"<p>Object_id empty</p>"; die;
	}
}
else{
	echo"<p>Missing object_id</p>"; die;
}
if(isset($_GET['object_user_id'])){
	$object_user_id = $_GET['object_user_id'];
	$object_user_id = output_html($object_user_id);
	$object_user_id_mysql = quote_smart($link, $object_user_id);
}
else{
	echo"<p>Missing object user id</p>"; die;
}

if(isset($_GET['refererer_from_root'])){
	$refererer_from_root = $_GET['refererer_from_root'];
	$refererer_from_root = output_html($refererer_from_root);

	// If the start of referer is a "/" then we need to remove it
	$start = substr($refererer_from_root, 0, 1);
	if($start == "/"){
		$refererer_from_root = substr($refererer_from_root, 1);  
	}
}
else{
	echo"<p>Missing refererer_from_root</p>"; die;
}

/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_new_comment";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");


/*- PageID ----------------------------------------------------------------------------- */
if(!(isset($pageIdSav)) OR $object_id == ""){
	// Get page ID
	$inp_page_title_mysql = quote_smart($link, $website_title);
	$query = "SELECT page_id FROM $t_pages WHERE page_title=$inp_page_title_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($pageIdSav) = $row;
	if($pageIdSav == ""){
		// Insert

		$page_slug = clean($website_title);
		$inp_page_slug_mysql = quote_smart($link, $page_slug);

		$datetime = date("Y-m-d H:i:s");
		$l_mysql = quote_smart($link, $l);

		
		mysqli_query($link, "INSERT INTO $t_pages
		(page_id, page_title, page_language, page_slug, page_parent_id, page_created, page_created_by_user_id, page_updated_by_user_id, page_allow_comments, page_no_of_comments, page_uniqe_hits) 
		VALUES 
		(NULL, $inp_page_title_mysql, $l_mysql, $inp_page_slug_mysql, '0', '$datetime', '1', '1', '1', '0', '0')")
		or die(mysqli_error($link));

		// Get page ID
		$query = "SELECT page_id FROM $t_pages WHERE page_title=$inp_page_title_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($pageIdSav) = $row;
	}
	$object_id = "$pageIdSav";
}




/*- Scriptstart ---------------------------------------------------------------------- */
// Can I comment?
$can_i_comment = "false";

if(isset($commentSystemActiveSav) && $commentSystemActiveSav == "true"){

	$can_i_comment = "true";

	if($whoCanCommentSav == "registered_users"){
		if(isset($_SESSION['user_id'])){
			$can_i_comment = "true";
		}
		else {
			$can_i_comment = "false";
			if($process == "1"){

				$inp_email = $_POST['inp_email'];
				$inp_email = output_html($inp_email);
				$inp_email = strtolower($inp_email);
				$inp_email_mysql = quote_smart($link, $inp_email);

				$inp_password = $_POST['inp_password'];

				if(isset($_POST['inp_remember'])) {
					$inp_remember = $_POST['inp_remember'];
					if($inp_remember != "on"){
						$inp_remember = "off";
					}
				}
				else{
					$inp_remember = "off";
				}

				
				if(empty($inp_email)){
					$url = "new_comment.php?object=$object&object_id=$object_id&object_user_id=$object_user_id&l=$l&refererer_from_root=$refererer_from_root";
					$url = $url . "&ft=warning&fm=please_enter_your_email_address";

					header("Location: $url");
					exit;
				}
				if(empty($inp_password)){
					$url = "new_comment.php?object=$object&object_id=$object_id&object_user_id=$object_user_id&l=$l&refererer_from_root=$refererer_from_root";
					$url = $url . "&ft=warning&fm=please_enter_your_password&inp_email=$inp_email";

					header("Location: $url");
					exit;
				}


				$query = "SELECT user_id, user_password, user_salt, user_language, user_verified_by_moderator FROM $t_users WHERE user_email=$inp_email_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_user_id, $get_user_password, $get_user_salt, $get_user_language, $get_user_verified_by_moderator) = $row;

				if($get_user_id == ""){
					// Email not found
					$url = "new_comment.php?object=$object&object_id=$object_id&object_user_id=$object_user_id&l=$l&refererer_from_root=$refererer_from_root";
					$url = $url . "&ft=warning&fm=email_address_not_found";

					header("Location: $url");
					exit;

				}
				else{

					// Check password 
					$inp_password_encrypted = sha1($inp_password);

					if($inp_password_encrypted == "$get_user_password"){
						// Correct password
						$host = $_SERVER['HTTP_HOST'];


						// I am approved?
						if($get_user_verified_by_moderator == "1"){

							// -> Cookie
							if($inp_remember == "on"){
								$salt = substr (md5($get_user_password), 0, 2);
								$cookie = base64_encode ("$get_user_id:" . md5 ($get_user_password, $salt));

								setcookie ('remember_user', $cookie, strtotime( '+10 months' ), '/', $host);
							}

							// Set security pin
							$security = rand(0,9999);

							// -> Logg brukeren inn
							$_SESSION['user_id'] = "$get_user_id";
							$_SESSION['security'] = "$security";
							$user_last_ip = $_SERVER['REMOTE_ADDR'];
							$user_last_ip = output_html($user_last_ip);
							$user_last_ip_mysql = quote_smart($link, $user_last_ip);

							// Update last logged in
							$inp_user_last_online = date("Y-m-d H:i:s");
							$inp_user_last_online_time = time();
							$result = mysqli_query($link, "UPDATE $t_users SET 
									user_security='$security', 
									user_last_online='$inp_user_last_online', 
									user_last_online_time='$inp_user_last_online_time', 
									user_last_ip=$user_last_ip_mysql WHERE user_id='$get_user_id'");

				

							$url = "new_comment.php?object=$object&object_id=$object_id&object_user_id=$object_user_id&l=$l&refererer_from_root=$refererer_from_root";
							header("Location: $url");
							exit;
						}
						else{
							// Not approved yet
							$url = "$root/users/create_free_account_awaiting_approvement.php?l=$l"; 
							header("Location: $url");
							exit;

						}
					}
					else{
						// Wrong password
						$url = "new_comment.php?object=$object&object_id=$object_id&object_user_id=$object_user_id&l=$l&refererer_from_root=$refererer_from_root";
						$url = $url . "&ft=warning&fm=wrong_password&inp_email=$inp_email";

						header("Location: $url");
						exit;

					}
				}


			} // process == 1 (login)

			// Show login link
			echo"
			<h1>$l_please_login_to_comment</h1>

			<!-- Feedback -->
				";
				if($ft != "" && $fm != ""){
					if($fm == "please_enter_your_email_address"){
						$fm = "$l_please_enter_your_email_address";
					}
					elseif($fm == "please_enter_your_password"){
						$fm = "$l_please_enter_your_password";
					}
					elseif($fm == "email_address_not_found"){
						$fm = "$l_email_address_not_found";
					}
					elseif($fm == "wrong_password"){
						$fm = "$l_wrong_password";
					}
					else{
						$fm = ucfirst($fm);
						$fm = str_replace("_", " ", $fm);
					}
					echo"<div class=\"$ft\"><p>$fm</p></div>";
				}
				echo"
			<!-- //Feedback -->



			<!-- Focus -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_email\"]').focus();
				});
				</script>
			<!-- //Focus -->



			<form method=\"POST\" action=\"$root/comments/new_comment.php?object=$object&amp;object_id=$object_id&amp;object_user_id=$object_user_id&amp;l=$l&amp;process=1&amp;refererer_from_root=$refererer_from_root\" enctype=\"multipart/form-data\">


				
			<p>$l_email_address:<br />
			<input type=\"text\" name=\"inp_email\" size=\"30\" style=\"width: 240px;\" value=\""; 
			if(isset($_GET['inp_email'])) {
				$inp_email = $_GET['inp_email'];
				$inp_email = output_html($inp_email);
				$inp_email = strtolower($inp_email); echo"$inp_email"; 
			} echo"\" tabindex=\"1\" />
			</p>

			<p>$l_password:<br />
			<input type=\"password\" name=\"inp_password\" size=\"30\" style=\"width: 240px;\" value=\""; if(isset($inp_password)){ echo"$inp_password"; } echo"\" tabindex=\"2\" />
			</p>

			<p>
			<input type=\"checkbox\" name=\"inp_remember\" "; if(isset($inp_remember)){ if($inp_remember == "on"){ echo" checked=\"checked\""; } } else{ echo" checked=\"checked\""; } echo" />
			$l_remember_me<br />
			</p>


			<p>
			<input type=\"submit\" value=\"$l_login\" class=\"btn_default\" tabindex=\"3\" />
			</p>
			</form>
			
			<p>
			<a href=\"$root/users/create_free_account.php?l=$l\">$l_new_user &dash; $l_create_free_account</a>
			&middot;
			<a href=\"$root/users/forgot_password.php?l=$l\">$l_forgot_password_question</a>
			</p>
			";
		}
	}
	else {
		// Everyone
		$can_i_comment = "true";
		
	}

	// IP Block
	if($can_i_comment == "true"){
		// Check ip block
		$block_to_date = date("ymdh");
		$object_mysql = quote_smart($link, $object);
		$object_id_mysql = quote_smart($link, $object_id);

		if(isset($_SESSION['user_id'])){
			// Me
			$my_user_id = $_SESSION['user_id'];
			$my_user_id_mysql = quote_smart($link, $my_user_id);


			// Check by user ID
			$query = "SELECT block_id FROM $t_comments_users_block WHERE block_user_id=$my_user_id_mysql AND block_object=$object_mysql AND block_object_id=$object_id_mysql AND block_to_date=$block_to_date";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_block_id_user) = $row;
			if($get_block_id_user == ""){
				$can_i_comment = "true";
			}
			else {
				$can_i_comment = "false";
			
				echo"
				<h1>$l_user_block</h1>

				<p>
				<!-- Where am I ? -->
					<p><b>$l_you_are_here</b><br />
					<a href=\"$root/$refererer_from_root\">"; echo ucfirst($object); echo"</a>
					&gt;
					<a href=\"$root/comments/new_comment.php?object=$object&amp;object_id=$object_id&amp;object_user_id=$object_user_id&amp;refererer_from_root=$refererer_from_root&amp;l=$l\">$l_new_comment</a>
					</p>
				<!-- //Where am I ? -->

				<p>
				$l_please_wait_five_minutes_before_adding_a_new_comment 
				$l_this_is_to_prevent_spam
				</p>
				";
			}

		
			$my_user_ip = $_SERVER['REMOTE_ADDR'];
			$my_user_ip = output_html($my_user_ip);
			$my_user_ip_mysql = quote_smart($link, $my_user_ip);
			$query = "SELECT block_id FROM $t_comments_users_block WHERE block_user_ip=$my_user_ip_mysql AND block_object=$object_mysql AND block_object_id=$object_id_mysql AND block_to_date=$block_to_date";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_block_id) = $row;
			if($get_block_id == ""){
				$can_i_comment = "true";
			}
			else {
				$can_i_comment = "false";
			
				if($get_block_id_user == ""){ // prevents double error message
					echo"
					<h1>$l_ip_block</h1>

					<p>
					<!-- Where am I ? -->
						<p><b>$l_you_are_here</b><br />
						<a href=\"$root/$refererer_from_root\">"; echo ucfirst($object); echo"</a>
						&gt;
						<a href=\"$root/comments/new_comment.php?object=$object&amp;object_id=$object_id&amp;object_user_id=$object_user_id&amp;refererer_from_root=$refererer_from_root&amp;l=$l\">$l_new_comment</a>
						</p>
					<!-- //Where am I ? -->

					<p>
					$l_please_wait_five_minutes_before_adding_a_new_comment 
					$l_this_is_to_prevent_spam
					</p>
					";
				} 
			}
		}
	}
} // can I comment?

/*- Find object ---------------------------------------------------------------------- */

if($can_i_comment == "true"){
	if($process == "1"){
		$inp_comment_text = $_POST['inp_comment_text'];
		$inp_comment_text = output_html($inp_comment_text);
		$inp_comment_text_mysql = quote_smart($link, $inp_comment_text);
		if(empty($inp_comment_text)){

			$url = "new_comment.php?object=$object&object_id=$object_id&object_user_id=$object_user_id&refererer_from_root=$refererer_from_root&amp;l=$l&ft=error&fm=missing_comment";
			header("Location: $url");
			exit;
		}
	
		// Check if the comment text has links in it
		// Only registered users can post links
		if(!(isset($_SESSION['user_id']))){
			if(isset($notApprovedUsersCanPostLinksSav) && $notApprovedUsersCanPostLinksSav == "false"){
				// Admin says that not registered user cant post links
		
				$has_link = strpos($inp_comment_text, 'http') !== false || strpos($inp_comment_text, 'www.') !== false;

				if($has_link){
					$inp_comment_name = $_POST['inp_comment_name'];
					$inp_comment_name = output_html($inp_comment_name);
					$inp_comment_name_mysql = quote_smart($link, $inp_comment_name);
					$inp_comment_email = $_POST['inp_comment_email'];
					$inp_comment_email = output_html($inp_comment_email);
					$inp_comment_email_mysql = quote_smart($link, $inp_comment_email);

					// Include translations
					if($l ==""){ $l = "en"; }
					include("../_admin/_translations/site/$l/comment/ts_new_comment.php");
   					echo"<!DOCTYPE html>\n";
   					echo"<html lang=\"en-US\">\n";
   					echo"<head>\n";
   					echo"	<title>Error</title>\n";
   					echo"</head>\n";
   					echo"<body>\n";
					echo"<h1>$l_no_links_allowed</h1>
					<p>
					$l_unregistered_users_are_not_allowed_to_post_links_in_their_comment <br />
					$l_please_remove_links_or_register_to_this_site_and_then_post_again<br />
					$l_this_is_to_prevent_spam.
					</p>
					";
   					echo"</body>\n";
   					echo"</html>\n";

					die;
				}

			}
		}

		if(!(isset($_SESSION['user_id']))){
			// Missing user login, so this is a new user


			$inp_comment_name = $_POST['inp_comment_name'];
			$inp_comment_name = output_html($inp_comment_name);
			$inp_comment_name_mysql = quote_smart($link, $inp_comment_name);

			if($inp_comment_name == ""){
				$url = "new_comment.php?object=$object&object_id=$object_id&object_user_id=$object_user_id&refererer_from_root=$refererer_from_root&amp;l=$l&ft=error&fm=missing_name&inp_comment_text=$inp_comment_text";
				header("Location: $url");
				exit;
			}
	
			$inp_comment_email = $_POST['inp_comment_email'];
			$inp_comment_email = output_html($inp_comment_email);
			$inp_comment_email_mysql = quote_smart($link, $inp_comment_email);

			if($inp_comment_email == ""){
				$url = "new_comment.php?object=$object&object_id=$object_id&object_user_id=$object_user_id&refererer_from_root=$refererer_from_root&amp;l=$l&ft=error&fm=missing_email&inp_comment_text=$inp_comment_text&inp_comment_name=$inp_comment_name";
				header("Location: $url");
				exit;
			}

			// Check for that user
			$query = "SELECT user_id, user_email, user_name, user_alias, user_date_format FROM $t_users WHERE user_email=$inp_comment_email_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_date_format) = $row;

			if($get_my_user_id == ""){
				// New user

				// Registered
				$datetime = date("Y-m-d H:i:s");
				$time = time();

				// Language
				$l = output_html($l);
				$l_mysql = quote_smart($link, $l);

				$my_user_ip = $_SERVER['REMOTE_ADDR'];
				$my_user_ip = output_html($my_user_ip);
				$my_user_ip_mysql = quote_smart($link, $my_user_ip);

				// Insert user
				mysqli_query($link, "INSERT INTO $t_users
				(user_id, user_email, user_name, user_alias, user_password, user_salt, user_security, user_language, user_measurement, user_date_format, user_registered, user_registered_time, user_last_online, user_last_online_time, user_rank, user_points, user_points_rank, user_likes, user_dislikes, user_last_ip, user_verified_by_moderator, user_marked_as_spammer) 
				VALUES 
				(NULL, $inp_comment_email_mysql, $inp_comment_name_mysql, $inp_comment_name_mysql, '', '', 1234, $l_mysql, 'metric', 'l jS \of F Y', '$datetime', '$time', '$datetime', '$time', 'user', '0', 'Newbie', '0', '0', $my_user_ip_mysql, '0', '0')")
				or die(mysqli_error($link));

				// Get user id
				$query = "SELECT user_id, user_email, user_name, user_alias, user_date_format FROM $t_users WHERE user_email=$inp_comment_email_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_date_format) = $row;
				$my_user_id_mysql = quote_smart($link, $get_my_user_id);

				// Insert profile			
				mysqli_query($link, "INSERT INTO $t_users_profile
				(profile_id, profile_user_id, profile_views, profile_privacy) 
				VALUES 
				(NULL, '$get_my_user_id', '0', 'public')")
				or die(mysqli_error($link));

				// Send photo and subscription
				$get_my_photo_destination = "";
				$get_my_es_on_off = "0";

			}
			else{
				// We found the user id by searching for e-mail
				// Here in the futuere we can make the user log in
				$my_user_id_mysql = quote_smart($link, $get_my_user_id);
		
			}
		}
		else{
			$my_user_id = $_SESSION['user_id'];
			$my_user_id_mysql = quote_smart($link, $my_user_id);
		}
	
		// We have now either inserted the user, or the user alreaddy exists

		// Get my profile
		$query = "SELECT user_id, user_email, user_name, user_alias, user_date_format FROM $t_users WHERE user_id=$my_user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_date_format) = $row;

		// Get my profile image
		$q = "SELECT photo_id, photo_destination FROM $t_users_profile_photo WHERE photo_user_id=$my_user_id_mysql AND photo_profile_image='1'";
		$r = mysqli_query($link, $q);
		$rowb = mysqli_fetch_row($r);
		list($get_my_photo_id, $get_my_photo_destination) = $rowb;


		// Get my subscription status
		$q = "SELECT es_id, es_on_off FROM $t_users_email_subscriptions WHERE es_user_id=$my_user_id_mysql AND es_type='comments'";
		$r = mysqli_query($link, $q);
		$rowb = mysqli_fetch_row($r);
		list($get_my_es_id, $get_my_es_on_off) = $rowb;

		if($get_my_es_id == ""){
			mysqli_query($link, "INSERT INTO $t_users_email_subscriptions
			(es_id, es_user_id, es_type, es_on_off) 
			VALUES 
			(NULL, $my_user_id_mysql, 'comments', '1')") or die(mysqli_error($link));
		
			$get_my_es_on_off = "1";
		}


		$inp_comment_language = output_html($l);
		$inp_comment_language_mysql = quote_smart($link, $inp_comment_language);

		if(isset($_GET['comment_parent_id'])){
			$inp_comment_parent_id = $_GET['comment_parent_id'];
		}
		else{
			$inp_comment_parent_id = "0";
		}
		$inp_comment_parent_id = output_html($inp_comment_parent_id);
		$inp_comment_parent_id_mysql = quote_smart($link, $inp_comment_parent_id);


		$inp_user_ip = $_SERVER['REMOTE_ADDR'];
		$inp_user_ip = output_html($inp_user_ip);
		$inp_user_ip_mysql = quote_smart($link, $inp_user_ip);

		$inp_user_hostname = gethostbyaddr($inp_user_ip);
		$inp_user_hostname = output_html($inp_user_hostname);
		$inp_user_hostname_mysql = quote_smart($link, $inp_user_hostname);

		$inp_comment_user_name_mysql = quote_smart($link, $get_my_user_alias);
	
		$inp_comment_user_avatar_mysql = quote_smart($link, $get_my_photo_destination);
		
		$inp_comment_user_email_mysql = quote_smart($link, $get_my_user_email);
	
		$inp_comment_user_subscribe_mysql = quote_smart($link, $get_my_es_on_off);

		$inp_comment_created = date("Y-m-d H:i:s");
		$inp_comment_updated = date("Y-m-d H:i:s");



		/*- User block ---------------------------------------------------------------------- */
	
		$block_to_date = date("ymdh");
		$block_to_week = date("W");

		// Check by user ID
		$query = "SELECT block_id FROM $t_comments_users_block WHERE block_user_id=$my_user_id_mysql AND block_object=$object_mysql AND block_object_id=$object_id_mysql AND block_to_date=$block_to_date";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_block_id) = $row;
		if($get_block_id != ""){
			$url = "new_comment.php?object=$object&object_id=$object_id&object_user_id=$object_user_id&refererer_from_root=$refererer_from_root&amp;l=$l&ft=error&fm=you_have_already_commented_on_this__please_wait_one_hour_before_trying_again#comment_form";
			header("Location: $url");
			exit;
		}
		else{
			// Check by user IP
			$query = "SELECT block_id FROM $t_comments_users_block WHERE block_user_ip=$inp_user_ip_mysql AND block_object=$object_mysql AND block_object_id=$object_id_mysql AND block_to_date=$block_to_date";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_block_id) = $row;

			if($get_block_id != ""){
				$url = "new_comment.php?object=$object&object_id=$object_id&object_user_id=$object_user_id&refererer_from_root=$refererer_from_root&amp;l=$l&ft=error&fm=ip_block#comment_form";
				header("Location: $url");
				exit;
			}
			else{
				mysqli_query($link, "INSERT INTO $t_comments_users_block
				(block_id, block_user_id, block_user_ip, block_object, block_object_id, block_to_date, block_to_week) 
				VALUES 
				(NULL, $my_user_id_mysql, $inp_user_ip_mysql, $object_mysql, $object_id_mysql, '$block_to_date', '$block_to_week')")
				or die(mysqli_error($link));
			}
		}


		/*- Insert comment ------------------------------------------------------------------ */
		mysqli_query($link, "INSERT INTO $t_comments
		(comment_id, comment_user_id, comment_language, 
		comment_object, comment_object_id, comment_parent_id, 
		comment_user_ip, comment_user_hostname, comment_user_name, comment_user_avatar, 
		comment_user_email, comment_user_subscribe, comment_created, 
		comment_updated, comment_text, comment_likes, comment_dislikes, comment_reported) 
		VALUES 
		(NULL, $my_user_id_mysql, $inp_comment_language_mysql, 
		$object_mysql, $object_id_mysql, $inp_comment_parent_id_mysql, 
		$inp_user_ip_mysql, $inp_user_hostname_mysql, $inp_comment_user_name_mysql, $inp_comment_user_avatar_mysql, 
		$inp_comment_user_email_mysql, $inp_comment_user_subscribe_mysql, '$inp_comment_created', 
		'$inp_comment_updated', $inp_comment_text_mysql, '0', '0', '0')")
		or die(mysqli_error($link));


		// Get comment ID
		$query = "SELECT comment_id FROM $t_comments WHERE comment_user_id=$my_user_id_mysql AND comment_created='$inp_comment_created'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_comment_id) = $row;


		// Guest? Then set it to unread
		if(!(isset($_SESSION['user_id']))){
			$result = mysqli_query($link, "UPDATE $t_comments SET comment_approved='0' WHERE comment_id='$get_comment_id'");
		}
		else {
			// Aprove it
			$result = mysqli_query($link, "UPDATE $t_comments SET comment_approved='1' WHERE comment_id='$get_comment_id'");
		}




	
		/*- Insert into admin inbox ---------------------------------------------------------------- */
		$inp_message_title = "New comment to $object $object_id";
		$inp_message_title_mysql = quote_smart($link, $inp_message_title);



		// Message
		$thumb_full_path = "../_cache/user_" . $get_my_photo_destination . "-" . "40" . "x" . "40" . ".png";

	
		$inp_message_text = "<table>
				 <tr>
				  <td style=\"padding-right: 10px;text-align:center;vertical-align: top;\">
					<p style=\"color: #000;font: normal 14px 'Open Sans',sans-serif;\">
					<a href=\"$configSiteURLSav/users/view_profile.php?user_id=$get_my_user_id\"><img src=\"$thumb_full_path\" alt=\"$get_my_photo_destination\" /></a><br />
					<a href=\"$configSiteURLSav/users/view_profile.php?user_id=$get_my_user_id\" style=\"color: #000;font: normal 14px 'Open Sans',sans-serif;text-decoration: none;\">$get_my_user_alias</a>
					</p>
				  </td>
				  <td style=\"vertical-align: top;\">
					<p style=\"color: #000;font: normal 14px 'Open Sans',sans-serif;\">
					$inp_comment_text
					</p>

					<p style=\"color: #000;font: normal 14px 'Open Sans',sans-serif;\">
					<a href=\"$configSiteURLSav/$refererer_from_root#comments\" style=\"font: normal 14px 'Open Sans',sans-serif;\">View</a>
					&middot;
					<a href=\"$configSiteURLSav/comments/reply_comment.php?comment_id=$get_comment_id\" style=\"font: normal 14px 'Open Sans',sans-serif;\">Reply</a>
					</p>
				  </td>
				 </tr>
				</table>";
		$inp_message_text_mysql = quote_smart($link, $inp_message_text);

		$datetime = date("Y-m-d H:i:s");

		$year = date("Y");
		$month = date("m");
		$day = date("d");
		$date_saying = date("j M Y");

		mysqli_query($link, "INSERT INTO $t_admin_messages_inbox
		(message_id, message_title, message_text, message_language, message_datetime, message_year, 
		message_month, message_day, message_date_sayning, message_sent_email_warning, message_replied, message_from_user_id, 
		message_from_name, message_from_image, message_from_ip, message_read, message_read_by_user_id, message_read_by_user_name, message_comment,
		message_archived, message_spam) 
		VALUES 
		(NULL, $inp_message_title_mysql, $inp_message_text_mysql, $inp_comment_language_mysql, '$datetime', '$year',
		'$month', '$day', '$date_saying','0', '0', $my_user_id_mysql, $inp_comment_user_name_mysql, $inp_comment_user_avatar_mysql, $inp_user_ip_mysql, '0',
		'0', '', '', 0, 0)")
		or die(mysqli_error($link));


		// Send comment as e-mail to admins


		$read_comment_url = $configSiteURLSav . "/" . $refererer_from_root . "#comments";

		$query = "SELECT user_id, user_email, user_name, user_alias, user_language FROM $t_users WHERE user_rank='admin' OR user_rank='moderator'";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_mod_user_id, $get_mod_user_email, $get_mod_user_name, $get_mod_user_alias, $get_user_language) = $row;

			$subject = "New comment to $object $object_id at $configWebsiteTitleSav ($inp_comment_updated)";

			$message = "<html>\n";
			$message = $message. "<head>\n";
			$message = $message. "  <title>$subject</title>\n";
			$message = $message. " </head>\n";
			$message = $message. "<body>\n";

			$message = $message . "<p><a href=\"$configSiteURLSav\"><img src=\"$configSiteURLSav/$logoPathSav/$logoFileSav\" alt=\"$logoFileSav\" /></a></p>\n\n";
			$message = $message . "<h1>New comment</h1>\n\n";

			$message = $message . "<p>\n";
			$message = $message . "Comment id: $get_comment_id<br />\n";
			$message = $message . "Language: $l<br />\n";
			$message = $message . "Object: $object<br />\n";
			$message = $message . "Object id: $object_id<br />\n";
			$message = $message . "Comment parent id: <br />\n";
			$message = $message . "Created: $datetime<br />\n";
			$message = $message . "Text: $inp_comment_text<br />\n";
			$message = $message . "Read: <a href=\"$read_comment_url\">$read_comment_url</a><br />\n";

			$message = $message . "</p>\n";

			$message = $message . "<p>\n";
			$message = $message . "User id: $get_my_user_id<br />\n";
			$message = $message . "User ip: $inp_user_ip <br />\n";
			$message = $message . "User hostname: $inp_user_hostname <br />\n";
			$message = $message . "User alias: $get_my_user_alias<br />\n";
			$message = $message . "User avatar: $get_my_photo_destination<br />\n";
			$message = $message . "User email: $get_my_user_email<br />\n";
			$message = $message . "</p>\n";
			$message = $message. "</body>\n";
			$message = $message. "</html>\n";

			// Preferences for Subject field
			$headers_mail_mod = array();
			$headers_mail_mod[] = 'MIME-Version: 1.0';
			$headers_mail_mod[] = 'Content-type: text/html; charset=utf-8';
			$headers_mail_mod[] = "From: $configFromNameSav <" . $configFromEmailSav . ">";
			mail($get_mod_user_email, $subject, $message, implode("\r\n", $headers_mail_mod));
		}



		// Statistics
		// --> weekly
		$day = date("d");
		$month = date("m");
		$week = date("W");
		$year = date("Y");

		$query = "SELECT weekly_id, weekly_comments_written FROM $t_stats_comments_weekly WHERE weekly_week=$week AND weekly_year=$year";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_weekly_id,  $get_weekly_comments_written) = $row;
		if($get_weekly_id == ""){
			mysqli_query($link, "INSERT INTO $t_stats_comments_weekly 
			(weekly_id, weekly_week, weekly_year, weekly_comments_written, weekly_comments_written_diff_from_last_week, weekly_last_updated, weekly_last_updated_day, weekly_last_updated_month, weekly_last_updated_year) 
			VALUES 
			(NULL, $week, $year, 1, 1, '$datetime', $day, $month, $year)")
			or die(mysqli_error($link));
		}
		else{
			$inp_counter = $get_weekly_comments_written+1;
			$result = mysqli_query($link, "UPDATE $t_stats_comments_weekly SET weekly_comments_written=$inp_counter, 
						weekly_last_updated='$datetime', weekly_last_updated_day=$day, weekly_last_updated_month=$month, weekly_last_updated_year=$year WHERE weekly_id=$get_weekly_id") or die(mysqli_error($link));
		}

		// --> monthly
		$query = "SELECT monthly_id, monthly_comments_written FROM $t_stats_comments_monthly WHERE monthly_month=$month AND monthly_year=$year";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_monthly_id,  $get_monthly_comments_written) = $row;
		if($get_monthly_id == ""){
			mysqli_query($link, "INSERT INTO $t_stats_comments_monthly 
			(monthly_id, monthly_month, monthly_year, monthly_comments_written, monthly_last_updated, monthly_last_updated_day, monthly_last_updated_month, monthly_last_updated_year ) 
			VALUES 
			(NULL, $month, $year, 1, '$datetime', $day, $month, $year)")
			or die(mysqli_error($link));
		}
		else{
			$inp_counter = $get_monthly_comments_written+1;
			$result = mysqli_query($link, "UPDATE $t_stats_comments_monthly SET monthly_comments_written=$inp_counter, 
						monthly_last_updated='$datetime', monthly_last_updated_day=$day, monthly_last_updated_month=$month, monthly_last_updated_year=$year WHERE monthly_id=$get_monthly_id") or die(mysqli_error($link));
		}

		// --> yearly
		$query = "SELECT yearly_id, yearly_comments_written FROM $t_stats_comments_yearly WHERE yearly_year=$year";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_yearly_id, $get_yearly_comments_written) = $row;
		if($get_yearly_id == ""){
			mysqli_query($link, "INSERT INTO $t_stats_comments_yearly 
			(yearly_id, yearly_year, yearly_comments_written, yearly_last_updated, yearly_last_updated_day, yearly_last_updated_month, yearly_last_updated_year) 
			VALUES 
			(NULL, $year, 1, '$datetime', $day, $month, $year)")
			or die(mysqli_error($link));
		}
		else{
			$inp_counter = $get_yearly_comments_written+1;
			$result = mysqli_query($link, "UPDATE $t_stats_comments_yearly SET yearly_comments_written=$inp_counter, 
						yearly_last_updated='$datetime', yearly_last_updated_day=$day, yearly_last_updated_month=$month, yearly_last_updated_year=$year WHERE yearly_id=$get_yearly_id") or die(mysqli_error($link));
		}



		// Go trough comments that are not approved
		$current_month = date("m");
		$query_groups = "SELECT comment_id, comment_user_id, comment_language, comment_object, comment_object_id, comment_parent_id, comment_user_ip, comment_user_name, comment_user_avatar, comment_user_email, comment_user_subscribe, comment_created, comment_updated, comment_text, comment_likes, comment_dislikes, comment_reported, comment_report_checked, comment_approved FROM $t_comments WHERE comment_approved='0' ORDER BY comment_id DESC";
		$result_groups = mysqli_query($link, $query_groups);
		while($row_groups = mysqli_fetch_row($result_groups)) {
			list($get_comment_id, $get_comment_user_id, $get_comment_language, $get_comment_object, $get_comment_object_id, $get_comment_parent_id, $get_comment_user_ip, $get_comment_user_name, $get_comment_user_avatar, $get_comment_user_email, $get_comment_user_subscribe, $get_comment_created, $get_comment_updated, $get_comment_text, $get_comment_likes, $get_comment_dislikes, $get_comment_reported, $get_comment_report_checked, $get_comment_approved) = $row_groups;
		
			// Date
			$date_day = substr($get_comment_updated, 8, 2);
			$date_month = substr($get_comment_updated, 5, 2);
			$date_year = substr($get_comment_updated, 0, 4);

			// Should it be deleted?
			// example 1. feb 2018 will be deleted 1. apr 2018 (20180401)
			$delete_month = $date_month+2;
			if($get_comment_approved == "0" && $current_month == "$delete_month"){
				// Delete comment
				$result = mysqli_query($link, "DELETE FROM $t_comments WHERE comment_id=$get_comment_id");
				// Delete comment
				$result = mysqli_query($link, "DELETE FROM $t_comments WHERE comment_id=$get_comment_id");


				// Title
				$inp_message_title = "Comment $get_comment_id ";
		



				// Check that user is approved, else delete user
				$query = "SELECT user_id, user_email, user_name, user_alias, user_password, user_password_replacement, user_password_date, user_salt, user_security, user_language, user_gender, user_height, user_measurement, user_dob, user_date_format, user_registered, user_registered_time, user_last_online, user_last_online_time, user_rank, user_points, user_points_rank, user_likes, user_dislikes, user_status, user_login_tries, user_last_ip, user_synchronized, user_verified_by_moderator, user_notes FROM $t_users WHERE user_id=$get_comment_user_id";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_user_id, $get_user_email, $get_user_name, $get_user_alias, $get_user_password, $get_user_password_replacement, $get_user_password_date, $get_user_salt, $get_user_security, $get_user_language, $get_user_gender, $get_user_height, $get_user_measurement, $get_user_dob, $get_user_date_format, $get_user_registered, $get_user_registered_time, $get_user_last_online, $get_user_last_online_time, $get_user_rank, $get_user_points, $get_user_points_rank, $get_user_likes, $get_user_dislikes, $get_user_status, $get_user_login_tries, $get_user_last_ip, $get_user_synchronized, $get_user_verified_by_moderator, $get_user_notes) = $row;
				if($get_user_verified_by_moderator == "0"){
					// echo"<p>Delete user $get_user_name</p>";
			
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



					$inp_message_title = $inp_message_title . " and user $get_user_name deleted from $host";


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
					$inp_message_title = $inp_message_title . " deleted from $host";
				}

				$message = $message . "<p><b>Comment:</b></p>\n";
				$message = $message . "<table>\n";
				$message = $message . " <tr><td><span>Date:</span></td><td><span>$date_day $date_month_saying $date_year</span></td></tr>\n";
				$message = $message . " <tr><td><span>Text:</span></td><td><span>$get_comment_text</span></td></tr>\n";
				$message = $message . "</table>\n";

				// Title
				$inp_message_title_mysql = quote_smart($link, $inp_message_title);
		
				// Message 
				$inp_message_text_mysql = quote_smart($link, $message);
	
				// User id
				$inp_message_from_user_id_mysql = quote_smart($link, $get_comment_user_id);

				// User name
				$inp_message_from_name_mysql = quote_smart($link, $get_comment_user_name);

				// Img
				$inp_message_from_image_mysql = quote_smart($link, $get_comment_user_avatar);
	
				// IP 
				$inp_message_from_ip_mysql = quote_smart($link, $get_comment_user_ip);



				// Put into admin inbox
				mysqli_query($link, "INSERT INTO $t_admin_messages_inbox
				(message_id, message_title, message_text, 
				message_language, message_datetime, message_year, 
				message_month, message_day, message_date_sayning, 
				message_sent_email_warning, message_replied, message_from_user_id, 
				message_from_name, message_from_image, message_from_ip, message_read, 
				message_read_by_user_id, message_read_by_user_name, message_comment,
				message_archived, message_spam) 
				VALUES 
				(NULL, $inp_message_title_mysql, $inp_message_text_mysql,
				$inp_comment_language_mysql, '$datetime', '$year',
				'$month', '$day', '$date_saying',
				'0', '0', $inp_message_from_user_id_mysql,
				$inp_message_from_name_mysql, $inp_message_from_image_mysql, $inp_message_from_ip_mysql, '0',
				'0', '', '',
				0, 0)")
				or die(mysqli_error($link));
			}

		} // comments not approved


		


		// Referrer
		// If the URL contains "?" then we can add &, else we have to add "?"
		$pos = strpos($refererer_from_root, "?");
		if ($pos === false) {
			$url = "$root/$refererer_from_root?ft=success&fm=comment_saved#comment$get_comment_id";
		}
		else{
			$url = "$root/$refererer_from_root&ft=success&fm=comment_saved#comment$get_comment_id";
		}

		header("Location: $url");
		exit;
	} // process == 1

	echo"
	<h1>$l_new_comment</h1>

	<!-- Where am I ? -->
		<p><b>$l_you_are_here</b><br />
		<a href=\"$root/$refererer_from_root\">"; echo ucfirst($object); echo"</a>
		&gt;
		<a href=\"$root/comments/new_comment.php?object=$object&amp;object_id=$object_id&amp;object_user_id=$object_user_id&amp;refererer_from_root=$refererer_from_root&amp;l=$l\">$l_new_comment</a>
		</p>
	<!-- //Where am I ? -->


	<!-- Feedback -->
		";
		if($ft != "" && $fm != ""){
			if($fm == "you_have_already_commented_on_this__please_wait_one_hour_before_trying_again"){
				$fm = "$l_you_have_already_commented_on_this__please_wait_one_hour_before_trying_again";
			}
			else{
				$fm = ucfirst($fm);
				$fm = str_replace("_", " ", $fm);
			}
			echo"<div class=\"$ft\"><p>$fm</p></div>";
		}
		echo"
	<!-- //Feedback -->

		<a id=\"add_comment\"></a>
		<div style=\"float: left;padding-right: 10px;\">
			<!-- My photo -->
			<p>
			";
			if(isset($_SESSION['user_id'])){
				// Me
				$my_user_id = $_SESSION['user_id'];
				$my_user_id_mysql = quote_smart($link, $my_user_id);

				// Get my profile image
				$q = "SELECT photo_id, photo_destination FROM $t_users_profile_photo WHERE photo_user_id=$my_user_id_mysql AND photo_profile_image='1'";
				$r = mysqli_query($link, $q);
				$rowb = mysqli_fetch_row($r);
				list($get_my_photo_id, $get_my_photo_destination) = $rowb;
				if($get_my_photo_id != ""){
					echo"
					<img src=\"$root/image.php?width=408&amp;height=40&amp;cropratio=1:1&amp;image=/_uploads/users/images/$my_user_id/$get_my_photo_destination\" alt=\"$get_my_photo_destination\" class=\"comment_avatar\" />
					";
				}
				else{
					echo"<img src=\"$root/comments/_gfx/avatar_blank_60.png\" alt=\"avatar_blank_60.png\" class=\"comment_avatar\" />";
				}
			}
			else{
				echo"<img src=\"$root/comments/_gfx/avatar_blank_60.png\" alt=\"avatar_blank_60.png\" class=\"comment_avatar\" />";
			}
			echo"
			</p>
			<!-- //My photo -->
		</div>
		<div style=\"overflow: hidden; width: auto; \">

			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_comment_text\"]').focus();
			});
			</script>

			<form method=\"post\" action=\"$root/comments/new_comment.php?object=$object&amp;object_id=$object_id&amp;object_user_id=$object_user_id&amp;l=$l&amp;process=1&amp;refererer_from_root=$refererer_from_root\">
					
			<p style=\"padding-bottom: 0;margin-bottom: 0;\">
			<textarea name=\"inp_comment_text\" rows=\"5\" cols=\"35\" tabindex=\"";$tabindex=0;echo"$tabindex\" id=\"inp_comment_text\">";
			if(isset($inp_comment_text)){
				echo"$inp_comment_text";
			}
			echo"</textarea>
			</p>
				
			"; if(!(isset($_SESSION['user_id']))){ echo"
			<div id=\"if_guest_then_fill_in_name_and_email\">

				<p class=\"comment_as_a_guest\">
				$l_name:<br />
				<input type=\"text\" name=\"inp_comment_name\" id=\"inp_comment_name\" value=\"";
				if(isset($inp_comment_name)){
					echo"$inp_comment_name";
				}
				echo"\" size=\"25\" />
				</p>

				<p>
				$l_email:<br />
				<input type=\"text\" name=\"inp_comment_email\" id=\"inp_comment_email\" value=\"";
				if(isset($inp_comment_email)){
					echo"$inp_comment_email";
				}
				echo"\" size=\"25\" />
				</p>
			</div>
				";
			}
			echo"
			<div id=\"comment_submit\">
				<p>
				<input type=\"submit\" value=\"$l_submit_comment\" class=\"btn\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
				</p>
			</div>
			</form>
		</div>
	";



	// Delete old blocks
	$week = date("W");
	$query_groups = "SELECT block_id, block_to_week FROM $t_comments_users_block";
	$result_groups = mysqli_query($link, $query_groups);
	while($row_groups = mysqli_fetch_row($result_groups)) {
		list($get_block_id, $get_block_to_week) = $row_groups;
		
		if($get_block_to_week != "$week"){
			$result_delete = mysqli_query($link, "DELETE FROM $t_comments_users_block WHERE block_id='$get_block_id'") or die(mysqli_error($link));
			// echo"<p class=\"small_grey\">Deleted $get_block_id</p>";
		}
	}


} // can I comment

/*- Footer ---------------------------------------------------------------- */
include("$root/_webdesign/footer.php");

		

?>