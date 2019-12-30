<?php 
/**
*
* File: talk/pm.php
* Version 1.0.0
* Date 10:25 01.09.2019
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

/*- Translation ------------------------------------------------------------------------ */


/*- Tables ---------------------------------------------------------------------------- */
$t_talk_channels_index		= $mysqlPrefixSav . "talk_channels_index";
$t_talk_channels_messages	= $mysqlPrefixSav . "talk_channels_messages";
$t_talk_channels_users_online	= $mysqlPrefixSav . "talk_channels_users_online";
$t_talk_users_starred_channels	= $mysqlPrefixSav . "talk_users_starred_channels";

$t_talk_dm_conversations = $mysqlPrefixSav . "talk_dm_conversations";
$t_talk_dm_messages	 = $mysqlPrefixSav . "talk_dm_messages";


/*- Variables ------------------------------------------------------------------------- */
$tabindex = 0;
$l_mysql = quote_smart($link, $l);


if(isset($_GET['inp_file'])){
	$inp_file = $_GET['inp_file'];
	$inp_file = output_html($inp_file);
}
else{
	$inp_file = "";
}
if(isset($_GET['inp_thumb'])){
	$inp_thumb = $_GET['inp_thumb'];
	$inp_thumb = output_html($inp_thumb);
}
else{
	$inp_thumb = "";
}


/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['t_user_id'])){
	$t_user_id = $_GET['t_user_id'];
	$t_user_id = output_html($t_user_id);
}
else{
	$t_user_id = "";
}
$t_user_id_mysql = quote_smart($link, $t_user_id);

if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){

	// Get my user
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_rank) = $row;


	// Find pm user
	$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$t_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_to_user_id, $get_to_user_email, $get_to_user_name, $get_to_user_alias, $get_to_user_rank) = $row;

	if($get_to_user_id == ""){
		echo"<h1>User not found</h1>";
	}
	else{

		// My photo
		$query = "SELECT photo_id, photo_destination, photo_thumb_40, photo_thumb_50 FROM $t_users_profile_photo WHERE photo_user_id=$my_user_id_mysql AND photo_profile_image='1'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_my_photo_id, $get_my_photo_destination, $get_my_photo_thumb_40, $get_my_photo_thumb_50) = $row;

		$inp_my_user_name_mysql = quote_smart($link, $get_my_user_name);
		$inp_my_user_alias_mysql = quote_smart($link, $get_my_user_alias);

		$inp_my_user_image_path = "_uploads/users/images/$get_my_user_id";
		$inp_my_user_image_path_mysql = quote_smart($link, $inp_my_user_image_path);
		$inp_my_user_image_file_mysql = quote_smart($link, $get_my_photo_destination);
		$inp_my_user_image_thumb_a_mysql = quote_smart($link, $get_my_photo_thumb_40);
		$inp_my_user_image_thumb_b_mysql = quote_smart($link, $get_my_photo_thumb_50);

		// My IP
		$inp_my_ip = $_SERVER['REMOTE_ADDR'];
		$inp_my_ip = output_html($inp_my_ip);
		$inp_my_ip_mysql = quote_smart($link, $inp_my_ip);
		$inp_my_hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$inp_my_hostname = output_html($inp_my_hostname);
		$inp_my_hostname_mysql = quote_smart($link, $inp_my_hostname);
		$inp_my_user_agent = $_SERVER['HTTP_USER_AGENT'];
		$inp_my_user_agent = output_html($inp_my_user_agent);
		$inp_my_user_agent_mysql = quote_smart($link, $inp_my_user_agent);



		// To photo
		$query = "SELECT photo_id, photo_destination, photo_thumb_40, photo_thumb_50 FROM $t_users_profile_photo WHERE photo_user_id=$get_to_user_id AND photo_profile_image='1'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_to_photo_id, $get_to_photo_destination, $get_to_photo_thumb_40, $get_to_photo_thumb_50) = $row;

		$inp_to_user_name_mysql = quote_smart($link, $get_to_user_name);
		$inp_to_user_alias_mysql = quote_smart($link, $get_to_user_alias);
		$inp_to_user_image_path = "_uploads/users/images/$get_to_user_id";
		$inp_to_user_image_path_mysql = quote_smart($link, $inp_to_user_image_path);

		$inp_to_user_image_file_mysql = quote_smart($link, $get_to_photo_destination);
		$inp_to_user_image_thumb_a_mysql = quote_smart($link, $get_to_photo_thumb_40);
		$inp_to_user_image_thumb_b_mysql = quote_smart($link, $get_to_photo_thumb_50);


		// Look for conversation
		$query = "SELECT conversation_id, conversation_key, conversation_f_user_id, conversation_f_user_name, conversation_f_user_alias, conversation_f_image_path, conversation_f_image_file, conversation_f_image_thumb40, conversation_f_image_thumb50, conversation_f_has_blocked, conversation_f_unread_messages, conversation_t_user_id, conversation_t_user_name, conversation_t_user_alias, conversation_t_image_path, conversation_t_image_file, conversation_t_image_thumb40, conversation_t_image_thumb50, conversation_t_has_blocked, conversation_t_unread_messages, conversation_encryption_key, conversation_encryption_key_year, conversation_encryption_key_month FROM $t_talk_dm_conversations WHERE conversation_f_user_id=$get_my_user_id AND conversation_t_user_id=$get_to_user_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_conversation_id, $get_current_conversation_key, $get_current_conversation_f_user_id, $get_current_conversation_f_user_name, $get_current_conversation_f_user_alias, $get_current_conversation_f_image_path, $get_current_conversation_f_image_file, $get_current_conversation_f_image_thumb40, $get_current_conversation_f_image_thumb50, $get_current_conversation_f_has_blocked, $get_current_conversation_f_unread_messages, $get_current_conversation_t_user_id, $get_current_conversation_t_user_name, $get_current_conversation_t_user_alias, $get_current_conversation_t_image_path, $get_current_conversation_t_image_file, $get_current_conversation_t_image_thumb40, $get_current_conversation_t_image_thumb50, $get_current_conversation_t_has_blocked, $get_current_conversation_t_unread_messages, $get_current_conversation_encryption_key, $get_current_conversation_encryption_key_year, $get_current_conversation_encryption_key_month) = $row;

		if($get_current_conversation_id == ""){
			// Create conversation
			$inp_conversation_key = date("ymdhis");
			$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
			$charactersLength = strlen($characters);
			for ($i = 0; $i < 5; $i++) {
				$inp_conversation_key .= $characters[rand(0, $charactersLength - 1)];
			}
			$inp_conversation_key_mysql = quote_smart($link, $inp_conversation_key);

			mysqli_query($link, "INSERT INTO $t_talk_dm_conversations 
			(conversation_id, conversation_key, conversation_f_user_id, conversation_f_user_name, conversation_f_user_alias, conversation_f_image_path, conversation_f_image_file, conversation_f_image_thumb40, conversation_f_image_thumb50, conversation_f_has_blocked, conversation_f_unread_messages, conversation_t_user_id, conversation_t_user_name, conversation_t_user_alias, conversation_t_image_path, conversation_t_image_file, conversation_t_image_thumb40, conversation_t_image_thumb50, conversation_t_has_blocked, conversation_t_unread_messages) 
			VALUES 
			(NULL, $inp_conversation_key_mysql, $get_my_user_id, $inp_my_user_name_mysql, $inp_my_user_alias_mysql, $inp_my_user_image_path_mysql, $inp_my_user_image_file_mysql, $inp_my_user_image_thumb_a_mysql, $inp_my_user_image_thumb_b_mysql, '0', '0', $get_to_user_id, $inp_to_user_name_mysql, $inp_to_user_alias_mysql, $inp_to_user_image_path_mysql, $inp_to_user_image_file_mysql, $inp_to_user_image_thumb_a_mysql, $inp_to_user_image_thumb_b_mysql, '0', '0')")
			or die(mysqli_error($link));

			$query = "SELECT conversation_id, conversation_key, conversation_f_user_id, conversation_f_user_name, conversation_f_user_alias, conversation_f_image_path, conversation_f_image_file, conversation_f_image_thumb40, conversation_f_image_thumb50, conversation_f_has_blocked, conversation_f_unread_messages, conversation_t_user_id, conversation_t_user_name, conversation_t_user_alias, conversation_t_image_path, conversation_t_image_file, conversation_t_image_thumb40, conversation_t_image_thumb50, conversation_t_has_blocked, conversation_t_unread_messages FROM $t_talk_dm_conversations WHERE conversation_f_user_id=$get_my_user_id AND conversation_t_user_id=$get_to_user_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_conversation_id, $get_current_conversation_key, $get_current_conversation_f_user_id, $get_current_conversation_f_user_name, $get_current_conversation_f_user_alias, $get_current_conversation_f_image_path, $get_current_conversation_f_image_file, $get_current_conversation_f_image_thumb40, $get_current_conversation_f_image_thumb50, $get_current_conversation_f_has_blocked, $get_current_conversation_f_unread_messages, $get_current_conversation_t_user_id, $get_current_conversation_t_user_name, $get_current_conversation_t_user_alias, $get_current_conversation_t_image_path, $get_current_conversation_t_image_file, $get_current_conversation_t_image_thumb40, $get_current_conversation_t_image_thumb50, $get_current_conversation_t_has_blocked, $get_current_conversation_t_unread_messages) = $row;

		}


		// Also check that the other user has conversation
		$query = "SELECT conversation_id, conversation_key, conversation_f_user_id, conversation_f_user_name, conversation_f_user_alias, conversation_f_image_path, conversation_f_image_file, conversation_f_image_thumb40, conversation_f_image_thumb50, conversation_f_has_blocked, conversation_f_unread_messages, conversation_t_user_id, conversation_t_user_name, conversation_t_user_alias, conversation_t_image_path, conversation_t_image_file, conversation_t_image_thumb40, conversation_t_image_thumb50, conversation_t_has_blocked, conversation_t_unread_messages FROM $t_talk_dm_conversations WHERE conversation_f_user_id=$get_to_user_id AND conversation_t_user_id=$my_user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_to_conversation_id, $get_to_conversation_key, $get_to_conversation_f_user_id, $get_to_conversation_f_user_name, $get_to_conversation_f_user_alias, $get_to_conversation_f_image_path, $get_to_conversation_f_image_file, $get_to_conversation_f_image_thumb40, $get_to_conversation_f_image_thumb50, $get_to_conversation_f_has_blocked, $get_to_conversation_f_unread_messages, $get_to_conversation_t_user_id, $get_to_conversation_t_user_name, $get_to_conversation_t_user_alias, $get_to_conversation_t_image_path, $get_to_conversation_t_image_file, $get_to_conversation_t_image_thumb40, $get_to_conversation_t_image_thumb50, $get_to_conversation_t_has_blocked, $get_to_conversation_t_unread_messages) = $row;
		if($get_to_conversation_id == ""){
			// Insert
			$inp_conversation_key_mysql = quote_smart($link, $get_current_conversation_key);

			mysqli_query($link, "INSERT INTO $t_talk_dm_conversations 
			(conversation_id, conversation_key, conversation_f_user_id, conversation_f_user_name, conversation_f_user_alias, conversation_f_image_path, conversation_f_image_file, conversation_f_image_thumb40, conversation_f_image_thumb50, conversation_f_has_blocked, conversation_f_unread_messages, conversation_t_user_id, conversation_t_user_name, conversation_t_user_alias, conversation_t_image_path, conversation_t_image_file, conversation_t_image_thumb40, conversation_t_image_thumb50, conversation_t_has_blocked, conversation_t_unread_messages) 
			VALUES 
			(NULL, $inp_conversation_key_mysql, $get_to_user_id, $inp_to_user_name_mysql, $inp_to_user_alias_mysql, $inp_to_user_image_path_mysql, $inp_to_user_image_file_mysql, $inp_to_user_image_thumb_a_mysql, $inp_to_user_image_thumb_b_mysql, '0', '0', $get_my_user_id, $inp_my_user_name_mysql, $inp_my_user_alias_mysql, $inp_my_user_image_path_mysql, $inp_my_user_image_file_mysql, $inp_my_user_image_thumb_a_mysql, $inp_my_user_image_thumb_b_mysql, '0', '0')")
			or die(mysqli_error($link));

			$query = "SELECT conversation_id, conversation_key, conversation_f_user_id, conversation_f_user_name, conversation_f_user_alias, conversation_f_image_path, conversation_f_image_file, conversation_f_image_thumb40, conversation_f_image_thumb50, conversation_f_has_blocked, conversation_f_unread_messages, conversation_t_user_id, conversation_t_user_name, conversation_t_user_alias, conversation_t_image_path, conversation_t_image_file, conversation_t_image_thumb40, conversation_t_image_thumb50, conversation_t_has_blocked, conversation_t_unread_messages FROM $t_talk_dm_conversations WHERE conversation_f_user_id=$my_user_id_mysql AND conversation_t_user_id=$get_to_user_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_to_conversation_id, $get_to_conversation_key, $get_to_conversation_f_user_id, $get_to_conversation_f_user_name, $get_to_conversation_f_user_alias, $get_to_conversation_f_image_path, $get_to_conversation_f_image_file, $get_to_conversation_f_image_thumb40, $get_to_conversation_f_image_thumb50, $get_to_conversation_f_has_blocked, $get_to_conversation_f_unread_messages, $get_to_conversation_t_user_id, $get_to_conversation_t_user_name, $get_to_conversation_t_user_alias, $get_to_conversation_t_image_path, $get_to_conversation_t_image_file, $get_to_conversation_t_image_thumb40, $get_to_conversation_t_image_thumb50, $get_to_conversation_t_has_blocked, $get_to_conversation_t_unread_messages) = $row;
		}

		// Block check
		if($get_current_conversation_f_has_blocked == "1"){
			echo"Blocked";
		}
		else{

			/*- Headers ---------------------------------------------------------------------------------- */
			$website_title = "$l_talk - $get_current_conversation_t_user_alias";
			if(file_exists("./favicon.ico")){ $root = "."; }
			elseif(file_exists("../favicon.ico")){ $root = ".."; }
			elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
			elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
			include("$root/_webdesign/header.php");

			if($action == ""){
				$time = time();
				echo"

				<!-- Messages -->
					<div id=\"messages\">";
					// Set all messages read
					$result = mysqli_query($link, "UPDATE $t_talk_dm_conversations SET conversation_f_unread_messages=0 WHERE conversation_id=$get_current_conversation_id") or die(mysqli_error($link));

					// Get messages
					$variable_last_message_id = "1";
					$date_saying = date("j M Y");
					$time = time();
					$x = 0;
					$query = "SELECT message_id, message_conversation_key, message_type, message_text, message_datetime, message_date_saying, message_time_saying, message_time, message_year, message_seen, message_attachment_type, message_attachment_path, message_attachment_file, message_from_user_id, message_from_ip, message_from_hostname, message_from_user_agent FROM $t_talk_dm_messages WHERE message_conversation_key='$get_current_conversation_key' ORDER BY message_id ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_message_id, $get_message_conversation_key, $get_message_type, $get_message_text, $get_message_datetime, $get_message_date_saying, $get_message_time_saying, $get_message_time, $get_message_year, $get_message_seen, $get_message_attachment_type, $get_message_attachment_path, $get_message_attachment_file, $get_message_from_user_id, $get_message_from_ip, $get_message_from_hostname, $get_message_from_user_agent) = $row;
	
									
						if($x > 250){
							$result_del = mysqli_query($link, "DELETE FROM $t_talk_dm_messages WHERE message_id=$get_message_id");
							// Attachment?
							if($get_message_attachment_file != "" && file_exists("$root/$get_message_attachment_path/$get_message_attachment_file")){
								unlink("$root/$get_message_attachment_path/$get_message_attachment_file");
							}

						}


						// Decrypt message
						$c = base64_decode($get_message_text);
						$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
						$iv = substr($c, 0, $ivlen);
						$hmac = substr($c, $ivlen, $sha2len=32);
						$ciphertext_raw = substr($c, $ivlen+$sha2len);
						$original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $get_current_conversation_encryption_key, $options=OPENSSL_RAW_DATA, $iv);
						$calcmac = hash_hmac('sha256', $ciphertext_raw, $get_current_conversation_encryption_key, $as_binary=true);
						if (hash_equals($hmac, $calcmac)) {
							 $get_message_text = "$original_plaintext";
						}




						if($get_message_from_user_id == "$get_current_conversation_f_user_id"){
							// This is a message that I have written
							if($get_message_seen == "0"){
								$result_update = mysqli_query($link, "UPDATE $t_talk_dm_messages SET message_seen=1 WHERE message_id=$get_message_id") or die(mysqli_error($link));
								$get_message_seen = "1";
							}
							echo"

							<table>
							 <tr>
							  <td style=\"padding: 5px 5px 0px 0px;vertical-align:top;\">
								<!-- Img -->
								<p>";
								if($get_current_conversation_f_image_file != "" && file_exists("$root/$get_current_conversation_f_image_path/$get_current_conversation_f_image_file")){
								if(!(file_exists("$root/$get_current_conversation_f_image_path/$get_current_conversation_f_image_thumb40")) && $get_current_conversation_f_image_thumb40 != ""){
									// Make thumb
									$inp_new_x = 40; // 950
									$inp_new_y = 40; // 640
									resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_current_conversation_f_image_path/$get_current_conversation_f_image_file", "$root/$get_current_conversation_f_image_path/$get_current_conversation_f_image_thumb40");
								}

								if(file_exists("$root/$get_current_conversation_f_image_path/$get_current_conversation_f_image_thumb40") && $get_current_conversation_f_image_thumb40 != ""){
									echo"
									<a href=\"$root/users/view_profile.php?user_id=$get_current_conversation_f_user_id&amp;l=$l\"><img src=\"$root/$get_current_conversation_f_image_path/$get_current_conversation_f_image_thumb40\" alt=\"$get_current_conversation_f_image_thumb40\" class=\"talk_messages_from_user_image\" /></a>
									";
								}
								}
								else{
								echo"
								<a href=\"$root/users/view_profile.php?user_id=$get_current_conversation_f_user_id&amp;l=$l\"><img src=\"_gfx/avatar_blank_40.png\" alt=\"avatar_blank_40.png\" class=\"talk_messages_from_user_image\" /></a>
								";
								}
								echo"
								</p>
								<!-- //Img -->
							  </td>
							  <td style=\"vertical-align:top;\">
								<!-- Name and text -->	
								<p>
								<a href=\"$root/users/view_profile.php?user_id=$get_current_conversation_f_user_id&amp;l=$l\" class=\"talk_messages_from_user_alias\">$get_current_conversation_f_user_alias</a>
								<span class=\"talk_messages_date_and_time\">";
								if($date_saying != "$get_message_date_saying"){
									echo"$get_message_date_saying ";
								}
								echo"$get_message_time_saying</span>";
						
								if($get_message_seen == "2"){
									echo" <img src=\"_gfx/seen_$get_message_seen.png\" alt=\"seen_$get_message_seen.png\" class=\"dm_message_seen_icon\" />";
								}
								if($get_current_conversation_f_user_id == "$my_user_id"){
									echo"
									<a href=\"dm.php?action=delete_message&amp;message_id=$get_message_id&amp;t_user_id=$get_to_user_id&amp;l=$l&amp;process=1\"><img src=\"_gfx/delete_grey_16x16.png\" alt=\"delete.png\" /></a>
									";
								}
								echo"<br />
								";
								// Attachment?
								if($get_message_attachment_file != "" && file_exists("$root/$get_message_attachment_path/$get_message_attachment_file")){
									if($get_message_attachment_type == "jpg" OR $get_message_attachment_type == "png" OR $get_message_attachment_type == "gif"){
										echo"<img src=\"$root/$get_message_attachment_path/$get_message_attachment_file\" alt=\"$get_message_attachment_path/$get_message_attachment_file\" /><br />\n";
									}
								}
								echo"
								$get_message_text
								</p>
								<!-- //Name and text -->
							  </td>
							 </tr>
							</table>
							";


		
						}
						else{
							// This is me, so set the message as read
							if($get_message_seen == "0" OR $get_message_seen == "1"){
								$result_update = mysqli_query($link, "UPDATE $t_talk_dm_messages SET message_seen=2 WHERE message_id=$get_message_id") or die(mysqli_error($link));
								$get_message_seen = "2";
							}
							echo"
							<table>
							 <tr>
							  <td style=\"padding: 5px 5px 0px 0px;vertical-align:top;\">
								<!-- Img -->
								<p>";
								if($get_current_conversation_t_image_file != "" && file_exists("$root/$get_current_conversation_t_image_path/$get_current_conversation_t_image_file")){
								if(!(file_exists("$root/$get_current_conversation_t_image_path/$get_current_conversation_t_image_thumb40")) && $get_current_conversation_t_image_thumb40 != ""){
									// Make thumb
									$inp_new_x = 40; // 950
									$inp_new_y = 40; // 640
									resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_current_conversation_t_image_path/$get_current_conversation_t_image_file", "$root/$get_current_conversation_t_image_path/$get_current_conversation_t_image_thumb40");
								}

								if(file_exists("$root/$get_current_conversation_t_image_path/$get_current_conversation_t_image_thumb40") && $get_current_conversation_t_image_thumb40 != ""){
									echo"
									<a href=\"$root/users/view_profile.php?user_id=$get_current_conversation_t_user_id&amp;l=$l\"><img src=\"$root/$get_current_conversation_t_image_path/$get_current_conversation_t_image_thumb40\" alt=\"$get_current_conversation_t_image_thumb40\" class=\"talk_messages_from_user_image\" /></a>
									";
								}
								}
								else{
								echo"
								<a href=\"$root/users/view_profile.php?user_id=$get_current_conversation_t_user_id&amp;l=$l\"><img src=\"_gfx/avatar_blank_40.png\" alt=\"avatar_blank_40.png\" class=\"talk_messages_from_user_image\" /></a>
								";
								}
								echo"
								</p>
								<!-- //Img -->
							  </td>
							  <td style=\"vertical-align:top;\">
								<!-- Name and text -->	
								<p>
								<a href=\"$root/users/view_profile.php?user_id=$get_current_conversation_t_user_id&amp;l=$l\" class=\"talk_messages_from_user_alias\">$get_current_conversation_t_user_alias</a>
								<span class=\"talk_messages_date_and_time\">";
								if($date_saying != "$get_message_date_saying"){
									echo"$get_message_date_saying ";
								}
								echo"$get_message_time_saying</span>";
								if($get_message_seen == "2"){
									echo" <img src=\"_gfx/seen_$get_message_seen.png\" alt=\"seen_$get_message_seen.png\" class=\"dm_message_seen_icon\" />";
								}
								if($get_current_conversation_t_user_id == "$my_user_id"){
									echo"
									<a href=\"dm.php?action=delete_message&amp;message_id=$get_message_id&amp;t_user_id=$get_to_user_id&amp;l=$l&amp;process=1\"><img src=\"_gfx/delete_grey_16x16.png\" alt=\"delete.png\" /></a>
									";
								}
								echo"<br />
								";
								// Attachment?
								if($get_message_attachment_file != "" && file_exists("$root/$get_message_attachment_path/$get_message_attachment_file")){
									if($get_message_attachment_type == "jpg" OR $get_message_attachment_type == "png" OR $get_message_attachment_type == "gif"){
										echo"<img src=\"$root/$get_message_attachment_path/$get_message_attachment_file\" alt=\"$get_message_attachment_path/$get_message_attachment_file\" /><br />\n";
									}
								}
								echo"
								$get_message_text
								</p>
								<!-- //Name and text -->
							  </td>
							 </tr>
							</table>
							";
						}


						// Update last message ID
						$variable_last_message_id = "$get_message_id";

						$x++;
					} // messages
					echo"

					</div>
					<span id=\"variable_last_message_id\">$variable_last_message_id</span>
							
					<!-- Get new message script -->
						<script language=\"javascript\" type=\"text/javascript\">
							\$(document).ready(function () {
								\$('#messages').scrollTop(\$('#messages')[0].scrollHeight);
								function get_messages(){
									var variable_last_message_id = \$('#variable_last_message_id').html(); 
									var data = 'l=$l&to_user_id=$get_to_user_id&last_message_id=' + variable_last_message_id;
            								\$.ajax({
                								type: \"POST\",
               									url: \"dm_get_messages.php\",
                								data: data,
										beforeSend: function(html) { // this happens before actual call
										},
               									success: function(html){
                    									\$(\"#messages\").append(html);

											// We want to scroll to bottom if user is not scrolling
											\$('#messages').scrollTop(\$('#messages')[0].scrollHeight);
											
											
              									}
									});
								}
								setInterval(get_messages,4000);
         				   		});
						</script>
					<!-- //Get new message script -->

				<!-- //Messages -->

				<!-- New message form -->
					<!-- Focus -->
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_text\"]').focus();
						});
						</script>
					<!-- //Focus -->

					<form method=\"POST\" action=\"dm_upload_file_as_attachment.php?t_user_id=$t_user_id&amp;l=$l&amp;process=1\" id=\"dm_upload_file_as_attachment_form_data\" enctype=\"multipart/form-data\">
						
					<p>
					<input type=\"hidden\" name=\"inp_attachment_file\" id=\"inp_attachment_file\" value=\"$inp_file\" size=\"25\" />
					<input type=\"text\" name=\"inp_text\" id=\"inp_text\" value=\"\" size=\"25\" style=\"width: 82%;\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
					
					";
					if($inp_thumb != ""){
						if(file_exists("$root/_uploads/talk/images/$get_current_conversation_id/$inp_thumb")){
							echo"
							<span id=\"dm_upload_file_as_attachment_preview\">
							<img src=\"$root/_uploads/talk/images/$get_current_conversation_id/$inp_thumb\" alt=\"$inp_thumb\" style=\"float: left;margin: -4px 0px 0px 0px;\" />
							</span>
							<span  id=\"dm_upload_file_as_attachment_form\" style=\"visibility:hidden;\">";
						}
						else{
							echo"<a href=\"$root/_uploads/talk/images/$get_current_conversation_id/$inp_thumb\" style=\"color:red;\">Thumb not found</a>\n";
						}
					}
					else{
						echo"
						<span id=\"dm_upload_file_as_attachment_form\">
						";
					}
					echo"
						<input type=\"file\" name=\"inp_file\" id=\"inp_file\" class=\"inputfile\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
						<label for=\"inp_file\"></label>
						<input type=\"submit\" value=\"Upload\" style=\"display:none;\" />
						</span>
				

					<a href=\"#\" id=\"inp_message_send\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />$l_send</a>	
					</p>
					</form>
					<div style=\"height: 5px;\"></div>
					<!-- On file selected send form -->
						<script type=\"text/javascript\">
							\$(document).ready(function(){
								\$('input[type=\"file\"]').change(function(){
            								\$(\"#dm_upload_file_as_attachment_form_data\").submit();
								});
							});
						</script>
					<!-- //On file selected send form -->

					<!-- Send new message script -->
							<script id=\"source\" language=\"javascript\" type=\"text/javascript\">
							\$(document).ready(function () {

							\$('#inp_text').keypress(function (e) {
								if (e.which == 13) {
									myfunc();
   									return false;
								}
							});


							\$('#inp_message_send').click(function(){
								myfunc();
   								return false;
							});
							
							function myfunc () {
								// getting the value that user typed
       								var inp_text = $(\"#inp_text\").val();
       								var inp_attachment_file = $(\"#inp_attachment_file\").val();
 								// forming the queryString
								var data = 'l=$l&t_user_id=$get_current_conversation_t_user_id&inp_file='+ inp_attachment_file + '&inp_text='+ inp_text;
         
        							// if searchString is not empty
        							if(inp_text) {
           								// ajax call
            								\$.ajax({
                								type: \"POST\",
               									url: \"dm_send_message.php\",
                								data: data,
										beforeSend: function(html) { // this happens before actual call
                    								
										},
               									success: function(html){
                    									\$(\"#messages\").append(html);
                    									\$(\"#inp_text\").val('');
											\$('#messages').scrollTop(\$('#messages')[0].scrollHeight);

											// Reset upload image somehow
											\$(\"#dm_upload_file_as_attachment_preview\").hide();
											\$(\"#dm_upload_file_as_attachment_form\").css('visibility', 'visible');
              									}
            								});
       								}
        							return false;
            						}
         				   		});
							</script>
					<!-- //Send new message script -->

				<!-- //New message form -->
				
				";
			} // action == ""
			elseif($action == "delete_message"){
				if(isset($_GET['message_id'])){
					$message_id = $_GET['message_id'];
					$message_id = output_html($message_id);
				}
				else{
					$message_id = "";
				}
				$message_id_mysql = quote_smart($link, $message_id);

					
				// Find pm
				$query = "SELECT message_id, message_from_user_id, message_attachment_type, message_attachment_path, message_attachment_file FROM $t_talk_dm_messages WHERE message_id=$message_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_message_id, $get_current_message_from_user_id, $get_message_attachment_type, $get_message_attachment_path, $get_message_attachment_file) = $row;
				if($get_current_message_id != ""){
					if($get_current_message_from_user_id == "$my_user_id"){
						$result = mysqli_query($link, "DELETE FROM $t_talk_dm_messages WHERE message_id=$get_current_message_id");

						// Attachment?
						if($get_message_attachment_file != "" && file_exists("$root/$get_message_attachment_path/$get_message_attachment_file")){
							unlink("$root/$get_message_attachment_path/$get_message_attachment_file");
						}
						$url = "dm.php?t_user_id=$t_user_id&l=$l";
						header("Location: $url");
						exit;
					}
					else{
						echo"<p>Access to message denied</p>";
					}
				}
				else{
					echo"<p>Message not found</p>";
				}
			} // delete message
		} // not blocked
	} // user found

} // logged in
else{
	echo"
	<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /></h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/talk\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>