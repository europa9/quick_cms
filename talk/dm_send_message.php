<?php 
/**
*
* File: talk/pm_send_message.php
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



/*- Variables ------------------------------------------------------------------------- */
if(isset($_POST['t_user_id'])){
	$t_user_id = $_POST['t_user_id'];
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
		echo"<h1>To user not found $query </h1>";
	}
	else{
		// Find conversation (we need conversation key)
		$query = "SELECT conversation_id, conversation_key, conversation_f_user_id, conversation_f_user_name, conversation_f_user_alias, conversation_f_image_path, conversation_f_image_file, conversation_f_image_thumb40, conversation_f_image_thumb50, conversation_f_has_blocked, conversation_f_unread_messages, conversation_t_user_id, conversation_t_user_name, conversation_t_user_alias, conversation_t_image_path, conversation_t_image_file, conversation_t_image_thumb40, conversation_t_image_thumb50, conversation_t_has_blocked, conversation_t_unread_messages FROM $t_talk_dm_conversations WHERE conversation_f_user_id=$get_my_user_id AND conversation_t_user_id=$get_to_user_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_conversation_id, $get_current_conversation_key, $get_current_conversation_f_user_id, $get_current_conversation_f_user_name, $get_current_conversation_f_user_alias, $get_current_conversation_f_image_path, $get_current_conversation_f_image_file, $get_current_conversation_f_image_thumb40, $get_current_conversation_f_image_thumb50, $get_current_conversation_f_has_blocked, $get_current_conversation_f_unread_messages, $get_current_conversation_t_user_id, $get_current_conversation_t_user_name, $get_current_conversation_t_user_alias, $get_current_conversation_t_image_path, $get_current_conversation_t_image_file, $get_current_conversation_t_image_thumb40, $get_current_conversation_t_image_thumb50, $get_current_conversation_t_has_blocked, $get_current_conversation_t_unread_messages) = $row;

		if($get_current_conversation_id == ""){
			echo"Create conversation";
			die;
		}

		// Get text
		if(isset($_POST['inp_text'])){
			$inp_text = $_POST['inp_text'];
			$inp_text = output_html($inp_text);
		}
		else{
			$inp_text = "";
		}
		$inp_text_mysql = quote_smart($link, $inp_text);


		if(isset($_POST['inp_file'])){
			$inp_file = $_POST['inp_file'];
			$inp_file = output_html($inp_file);
		}
		else{
			$inp_file = "";
		}
		$inp_file_mysql = quote_smart($link, $inp_file);

		if($inp_text != ""){

			// Dates
			$datetime = date("Y-m-d H:i:s");
			$time = time();
			$year = date("Y");
			$date_saying = date("j M Y");
			$datetime_saying = date("j M Y H:i");
			$time_saying = date("H:i");
				
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



			// Key
			$inp_key_mysql = quote_smart($link, $get_current_conversation_key);

			// Insert
			mysqli_query($link, "INSERT INTO $t_talk_dm_messages 
			(message_id, message_conversation_key, message_type, message_text, message_datetime, message_date_saying, message_time_saying, message_time, message_year, message_seen, message_from_user_id, message_from_ip, message_from_hostname, message_from_user_agent) 
			VALUES 
			(NULL, $inp_key_mysql, 'chat', $inp_text_mysql, '$datetime', '$date_saying', '$time_saying', '$time', $year, '0', $get_my_user_id, $inp_my_ip_mysql, $inp_my_hostname_mysql, $inp_my_user_agent_mysql)")
			or die(mysqli_error($link));

			// Attachment?
			if($inp_file != "" && file_exists("$root/_uploads/talk/images/$get_current_conversation_id/$inp_file")){
				$extension = get_extension($inp_file);

				$inp_attachment_type = "$extension";
				$inp_attachment_type = output_html($inp_attachment_type);
				$inp_attachment_type_mysql = quote_smart($link, $inp_attachment_type);

				$inp_attachment_path = "_uploads/talk/images/$get_current_conversation_id";
				$inp_attachment_path_mysql = quote_smart($link, $inp_attachment_path);

				$inp_attachment_file = "$inp_file";
				$inp_attachment_file = output_html($inp_attachment_file);
				$inp_attachment_file_mysql = quote_smart($link, $inp_attachment_file);

				$inp_attachment_thumb = str_replace(".$extension", "", $inp_file);
				$inp_attachment_thumb = $inp_attachment_thumb . "_thumb." . $extension;
				$inp_attachment_thumb = output_html($inp_attachment_thumb);
				$inp_attachment_thumb_mysql = quote_smart($link, $inp_attachment_thumb);
				
				$result = mysqli_query($link, "UPDATE $t_talk_dm_messages SET 
								message_attachment_type=$inp_attachment_type_mysql,
								message_attachment_path=$inp_attachment_path_mysql,
								message_attachment_file=$inp_attachment_file_mysql 
								 WHERE message_time='$time' AND message_from_user_id=$get_my_user_id") or die(mysqli_error($link));

				// Delete thumb
				if($inp_attachment_thumb != "" && file_exists("$root/_uploads/talk/images/$get_current_conversation_id/$inp_attachment_thumb")){
					unlink("$root/_uploads/talk/images/$get_current_conversation_id/$inp_attachment_thumb");
				}

			}


			// Update new messages box for to user
			$query = "SELECT conversation_id, conversation_key, conversation_f_user_id, conversation_f_user_name, conversation_f_user_alias, conversation_f_image_path, conversation_f_image_file, conversation_f_image_thumb40, conversation_f_image_thumb50, conversation_f_has_blocked, conversation_f_unread_messages, conversation_t_user_id, conversation_t_user_name, conversation_t_user_alias, conversation_t_image_path, conversation_t_image_file, conversation_t_image_thumb40, conversation_t_image_thumb50, conversation_t_has_blocked, conversation_t_unread_messages FROM $t_talk_dm_conversations WHERE conversation_f_user_id=$get_to_user_id AND conversation_t_user_id=$get_my_user_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_to_conversation_id, $get_to_conversation_key, $get_to_conversation_f_user_id, $get_to_conversation_f_user_name, $get_to_conversation_f_user_alias, $get_to_conversation_f_image_path, $get_to_conversation_f_image_file, $get_to_conversation_f_image_thumb40, $get_to_conversation_f_image_thumb50, $get_to_conversation_f_has_blocked, $get_to_conversation_f_unread_messages, $get_to_conversation_t_user_id, $get_to_conversation_t_user_name, $get_to_conversation_t_user_alias, $get_to_conversation_t_image_path, $get_to_conversation_t_image_file, $get_to_conversation_t_image_thumb40, $get_to_conversation_t_image_thumb50, $get_to_conversation_t_has_blocked, $get_to_conversation_t_unread_messages) = $row;

			$inp_new_messages = $get_to_conversation_f_unread_messages+1;

			$result = mysqli_query($link, "UPDATE $t_talk_dm_conversations SET conversation_f_unread_messages=$inp_new_messages WHERE conversation_id=$get_to_conversation_id");



			// Echo this message
			$query = "SELECT message_id, message_conversation_key, message_type, message_text, message_datetime, message_date_saying, message_time_saying, message_time, message_year, message_seen, message_from_user_id, message_attachment_type, message_attachment_path, message_attachment_file, message_from_ip, message_from_hostname, message_from_user_agent FROM $t_talk_dm_messages WHERE message_time='$time' AND message_from_user_id=$get_my_user_id";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_message_id, $get_message_conversation_key, $get_message_type, $get_message_text, $get_message_datetime, $get_message_date_saying, $get_message_time_saying, $get_message_time, $get_message_year, $get_message_seen, $get_message_from_user_id, $get_message_attachment_type, $get_message_attachment_path, $get_message_attachment_file, $get_message_from_ip, $get_message_from_hostname, $get_message_from_user_agent) = $row;
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
								echo"$get_message_time_saying</span>
								<img src=\"_gfx/seen_1.png\" alt=\"seen_1.png\" class=\"dm_message_seen_icon_$get_message_id\">";
						
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
			<div id=\"dm_message_seen_icon_result_$get_message_id\"></div>

			<!-- Check if sendt message is seen script -->
				<script language=\"javascript\" type=\"text/javascript\">
				\$(document).ready(function () {
					function navigation_look_for_new_messages_and_conversations(){
						var data = 'l=$l&t_user_id=$get_current_conversation_t_user_id&message_id=$get_message_id';
            					\$.ajax({
                					type: \"POST\",
               						url: \"dm_send_message_check_if_message_is_seen_script.php\",
                					data: data,
							beforeSend: function(html) { // this happens before actual call
							},
               						success: function(html){
								\$(\"#dm_message_seen_icon_result_$get_message_id\").html(html);
              						}
       						});
					}
					setInterval(navigation_look_for_new_messages_and_conversations,10000);
         			});
				</script>
			<!-- //Check if sendt message is seen script -->

			";
		} // inp_text
		else{
			echo"Noting to post";
		}

	} // to_user found

} // logged in


?>