<?php 
/**
*
* File: talk/open_starred_channel_get_messages.php
* Version 1.0.0
* Date 19:41 31.08.2019
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
include("$root/_admin/_data/talk.php");


/*- Tables ---------------------------------------------------------------------------- */
$t_talk_channels_index		= $mysqlPrefixSav . "talk_channels_index";
$t_talk_channels_messages	= $mysqlPrefixSav . "talk_channels_messages";
$t_talk_channels_users_online	= $mysqlPrefixSav . "talk_channels_users_online";
$t_talk_private			= $mysqlPrefixSav . "talk_private";
$t_talk_users_starred_channels	= $mysqlPrefixSav . "talk_users_starred_channels";
$t_talk_users_starred_users	= $mysqlPrefixSav . "talk_users_starred_users";

/*- Functions ------------------------------------------------------------------------- */
if($talkEncryptionMethodChannelsSav == "openssl_encrypt(AES-128-CBC)"){
	include("_encrypt_decrypt/openssl_encrypt_aes-128-cbc.php");
}
elseif($talkEncryptionMethodChannelsSav == "caesar_cipher(random)"){
	include("_encrypt_decrypt/caesar_cipher.php");
}

/*- Variables ------------------------------------------------------------------------- */
$tabindex = 0;
$l_mysql = quote_smart($link, $l);

/*- Variables ------------------------------------------------------------------------- */
if(isset($_POST['starred_channel_id'])){
	$starred_channel_id = $_POST['starred_channel_id'];
	$starred_channel_id = output_html($starred_channel_id);
}
else{
	$starred_channel_id = "";
}
$starred_channel_id_mysql = quote_smart($link, $starred_channel_id);

if(isset($_POST['last_message_id'])){
	$last_message_id = $_POST['last_message_id'];
	$last_message_id = output_html($last_message_id);
}
else{
	$last_message_id = "";
}
$last_message_id_mysql = quote_smart($link, $last_message_id);

if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);

	// Get starred
	$query = "SELECT starred_channel_id, channel_id, channel_name, new_messages, user_id FROM $t_talk_users_starred_channels WHERE starred_channel_id=$starred_channel_id_mysql AND user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_starred_channel_id, $get_current_channel_id, $get_current_channel_name, $get_current_new_messages, $get_current_user_id) = $row;

	if($get_current_starred_channel_id == ""){
		echo"<h1>Starred Channel not found</h1>";
	}
	else{
		// Find channel
		$query = "SELECT channel_id, channel_name, channel_password, channel_last_message_time, channel_encryption_key, channel_encryption_key_year, channel_encryption_key_month FROM $t_talk_channels_index WHERE channel_id=$get_current_channel_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_channel_id, $get_current_channel_name, $get_current_channel_password, $get_current_channel_last_message_time, $get_current_channel_encryption_key, $get_current_channel_encryption_key_year, $get_current_channel_encryption_key_month) = $row;

		if($get_current_channel_id == ""){
			echo"<h1>Channel not found - 404 server error</h1>";
		}
		else{
			// Set all messages read
			$result = mysqli_query($link, "UPDATE $t_talk_users_starred_channels SET new_messages=0 WHERE starred_channel_id=$get_current_starred_channel_id") or die(mysqli_error($link));

			// Get messages
			$date_saying = date("j M Y");
			$query = "SELECT message_id, message_channel_id, message_type, message_text, message_datetime, message_date_saying, message_time_saying, message_time, message_year, message_from_user_id, message_from_user_name, message_from_user_alias, message_from_user_image_path, message_from_user_image_file, message_from_user_image_thumb_40, message_from_user_image_thumb_50, message_from_ip, message_from_hostname, message_from_user_agent FROM $t_talk_channels_messages WHERE message_id > $last_message_id_mysql AND message_channel_id=$get_current_channel_id AND message_from_user_id != $my_user_id_mysql  ORDER BY message_id DESC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_message_id, $get_message_channel_id, $get_message_type, $get_message_text, $get_message_datetime, $get_message_date_saying, $get_message_time_saying, $get_message_time, $get_message_year, $get_message_from_user_id, $get_message_from_user_name, $get_message_from_user_alias, $get_message_from_user_image_path, $get_message_from_user_image_file, $get_message_from_user_image_thumb_40, $get_message_from_user_image_thumb_50, $get_message_from_ip, $get_message_from_hostname, $get_message_from_user_agent) = $row;
	
				if($get_message_type == "info"){
										echo"
										<!-- Info -->
											<p class=\"talk_messages_info\">
											$get_message_text
											<span class=\"talk_messages_date_and_time\">(";
											if($date_saying != "$get_message_date_saying"){
												echo"$get_message_date_saying ";
											}
											echo"$get_message_time_saying)</span>
											</p>
										<!-- //Info -->
										";
				}
				else{
					// Decrypt message
					if($talkEncryptionMethodChannelsSav == "none"){
											
					}
					elseif($talkEncryptionMethodChannelsSav == "openssl_encrypt(AES-128-CBC)"){
						$get_message_text = openssl_decrypt_aes_128_cbc_decrypt($get_message_text, $get_current_channel_encryption_key);
					}
					elseif($talkEncryptionMethodChannelsSav == "caesar_cipher(random)"){
						$cipher = new KKiernan\CaesarCipher();
						$get_message_text = $cipher->encrypt($get_message_text, -$get_current_channel_encryption_key);
					}
					


					echo"
					<table>
					 <tr>
					  <td style=\"padding: 5px 5px 0px 0px;vertical-align:top;\">
						<!-- Img -->
						<p>";
						if($get_message_from_user_image_file != "" && file_exists("$root/$get_message_from_user_image_path/$get_message_from_user_image_file")){
							if(!(file_exists("$root/$get_message_from_user_image_path/$get_message_from_user_image_thumb_40")) && $get_message_from_user_image_thumb_40 != ""){
								// Make thumb
								$inp_new_x = 40; // 950
								$inp_new_y = 40; // 640
								resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_message_from_user_image_path/$get_message_from_user_image_file", "$root/$get_message_from_user_image_path/$get_message_from_user_image_thumb_40");
							
							}

							if(file_exists("$root/$get_message_from_user_image_path/$get_message_from_user_image_thumb_40") && $get_message_from_user_image_thumb_40 != ""){
								echo"
								<a href=\"dm.php?t_user_id=$get_message_from_user_id&amp;l=$l\"><img src=\"$root/$get_message_from_user_image_path/$get_message_from_user_image_thumb_40\" alt=\"$get_message_from_user_image_thumb_40\" class=\"talk_messages_from_user_image\" /></a>
								";
							}
						}
						else{
							echo"
							<a href=\"dm.php?t_user_id=$get_message_from_user_id&amp;l=$l\"><img src=\"_gfx/avatar_blank_40.png\" alt=\"avatar_blank_40.png\" class=\"talk_messages_from_user_image\" /></a>
							";
						}
						echo"
						</p>
						<!-- //Img -->
					  </td>
					  <td style=\"vertical-align:top;\">
						<!-- Name and text -->	
						<p>
						<a href=\"dm.php?t_user_id=$get_message_from_user_id&amp;l=$l\" class=\"talk_messages_from_user_alias\">$get_message_from_user_alias</a>
						<span class=\"talk_messages_date_and_time\">";
						if($date_saying != "$get_message_date_saying"){
							echo"$get_message_date_saying ";
						}
						echo"$get_message_time_saying</span>";
						
						if($get_message_from_user_id == "$my_user_id"){
							echo"
							<a href=\"open_starred_channel.php?action=delete_message&amp;message_id=$get_message_id&amp;starred_channel_id=$get_current_starred_channel_id&amp;l=$l&amp;process=1\"><img src=\"_gfx/delete_grey_16x16.png\" alt=\"delete.png\" /></a>
							";
						}

						echo"<br />
						$get_message_text
						</p>
						<!-- //Name and text -->
					  </td>
					 </tr>
					</table>";
				} // chat
				// Update last message ID
				echo"
				<script language=\"javascript\" type=\"text/javascript\">
				\$(document).ready(function () {
					\$(\"#variable_last_message_id\").html($get_message_id);
         			});
				</script>
				";
			} // messages
		} // channel found

	} // starred channel found

} // logged in


?>