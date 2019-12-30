<?php 
/**
*
* File: discuss/view_topic.php
* Version 1.0.0
* Date 12:05 10.02.2018
* Copyright (c) 2011-2018 S. A. Ditlefsen
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
$t_talk_private			= $mysqlPrefixSav . "talk_private";
$t_talk_users_starred_channels	= $mysqlPrefixSav . "talk_users_starred_channels";
$t_talk_users_starred_users	= $mysqlPrefixSav . "talk_users_starred_users";

/*- Variables ------------------------------------------------------------------------- */
$tabindex = 0;
$l_mysql = quote_smart($link, $l);




/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['starred_channel_id'])){
	$starred_channel_id = $_GET['starred_channel_id'];
	$starred_channel_id = output_html($starred_channel_id);
}
else{
	$starred_channel_id = "";
}
if($starred_channel_id == ""){
	$url = "my_starred_channels.php?ft=error&fm=No_Starred_Channel_selected&l=$l";
	header("Location: $url");
	exit;
}
$starred_channel_id_mysql = quote_smart($link, $starred_channel_id);

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
		echo"
		<p><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" /> Loading...</p>
		<meta http-equiv=\"refresh\" content=\"1;url=my_starred_channels.php?ft=error&fm=Starred_Channel_not_found_($starred_channel_id)&l=$l\">
		";
	}
	else{
		// Find channel
		$query = "SELECT channel_id, channel_name, channel_password, channel_last_message_time, channel_encryption_key, channel_encryption_key_year, channel_encryption_key_month FROM $t_talk_channels_index WHERE channel_id=$get_current_channel_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_channel_id, $get_current_channel_name, $get_current_channel_password, $get_current_channel_last_message_time, $get_current_channel_encryption_key, $get_current_channel_encryption_key_year, $get_current_channel_encryption_key_month) = $row;

		if($get_current_channel_id == ""){
			echo"<h1>Channel not found</h1>";
			// Delete refrence
			$result_del = mysqli_query($link, "DELETE FROM $t_talk_users_starred_channels WHERE starred_channel_id=$get_current_starred_channel_id");

			echo"
			<p><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" /> Loading...</p>
			<meta http-equiv=\"refresh\" content=\"1;url=my_starred_channels.php?l=$l\">
			";
		}
		else{
			/*- Headers ---------------------------------------------------------------------------------- */
			$website_title = "$l_talk - #$get_current_channel_name";
			if(file_exists("./favicon.ico")){ $root = "."; }
			elseif(file_exists("../favicon.ico")){ $root = ".."; }
			elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
			elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
			include("$root/_webdesign/header.php");

			if($action == ""){
				$time = time();
				echo"
				<!-- Messages and users online -->
					<table style=\"width: 100%;\">
					 <tr>
					  <td style=\"vertical-align: top;\">
						<!-- Messages -->
							<div id=\"messages\">
								";
								// Set all messages read
								$result = mysqli_query($link, "UPDATE $t_talk_users_starred_channels SET new_messages=0 WHERE starred_channel_id=$get_current_starred_channel_id") or die(mysqli_error($link));

								// Get messages
								$variable_last_message_id = "1";
								$date_saying = date("j M Y");
								$time = time();
								$query = "SELECT message_id, message_channel_id, message_type, message_text, message_datetime, message_date_saying, message_time_saying, message_time, message_year, message_from_user_id, message_from_user_name, message_from_user_alias, message_from_user_image_path, message_from_user_image_file, message_from_user_image_thumb_40, message_from_user_image_thumb_50, message_from_ip, message_from_hostname, message_from_user_agent FROM $t_talk_channels_messages WHERE message_channel_id=$get_current_channel_id ORDER BY message_id DESC";
								$result = mysqli_query($link, $query);
								while($row = mysqli_fetch_row($result)) {
									list($get_message_id, $get_message_channel_id, $get_message_type, $get_message_text, $get_message_datetime, $get_message_date_saying, $get_message_time_saying, $get_message_time, $get_message_year, $get_message_from_user_id, $get_message_from_user_name, $get_message_from_user_alias, $get_message_from_user_image_path, $get_message_from_user_image_file, $get_message_from_user_image_thumb_40, $get_message_from_user_image_thumb_50, $get_message_from_ip, $get_message_from_hostname, $get_message_from_user_agent) = $row;
	
									// Is the message X days old?
									$time_since_written = $time-$get_message_time;
									$days_since_written = round($time_since_written  / (60 * 60 * 24));

									if($days_since_written > 100){
										$result_del = mysqli_query($link, "DELETE FROM $t_talk_channels_messages WHERE message_id=$get_message_id");
									}

									if($get_message_type == "info"){
										echo"
										<!-- Info -->
											<p class=\"talk_messages_info\">
											$get_message_text
											<span class=\"talk_messages_date_and_time\">";
											if($date_saying != "$get_message_date_saying"){
											echo"$get_message_date_saying ";
											}
											echo"$get_message_time_saying</span>
											</p>
										<!-- //Info -->
										";
									}
									else{
										// Decrypt message
										$c = base64_decode($get_message_text);
										$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
										$iv = substr($c, 0, $ivlen);
										$hmac = substr($c, $ivlen, $sha2len=32);
										$ciphertext_raw = substr($c, $ivlen+$sha2len);
										$original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $get_current_channel_encryption_key, $options=OPENSSL_RAW_DATA, $iv);
										$calcmac = hash_hmac('sha256', $ciphertext_raw, $get_current_channel_encryption_key, $as_binary=true);
										if (hash_equals($hmac, $calcmac)){
										    $get_message_text = "$original_plaintext";
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
									} // message type chat
									// Update last message ID
									$variable_last_message_id = "$get_message_id";
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
										var data = 'l=$l&starred_channel_id=$get_current_starred_channel_id&last_message_id=' + variable_last_message_id;
            									\$.ajax({
                									type: \"POST\",
               										url: \"open_starred_channel_get_messages.php\",
                									data: data,
											beforeSend: function(html) { // this happens before actual call
											},
               										success: function(html){
                    										\$(\"#messages\").append(html);
												\$('#messages').scrollTop(\$('#messages')[0].scrollHeight);
              										}
       									
										});
									}
									setInterval(get_messages,5000);
         				   			});
								</script>
							<!-- //Get new message script -->

						<!-- //Messages -->
					  </td>
					  <td style=\"vertical-align: top;\">
						<!-- Users -->
							<span id=\"variable_last_time\">$time</span>
							<div id=\"users_in_channel\">
								<ul>
								";
								// Get users
								$query = "SELECT online_id, online_channel_id, online_time, online_user_id, online_user_name, online_user_alias, online_user_image_path, online_user_image_file, online_user_image_thumb_40, online_user_image_thumb_50, online_ip, online_hostname, online_user_agent FROM $t_talk_channels_users_online WHERE online_channel_id=$get_current_channel_id";
								$result = mysqli_query($link, $query);
								while($row = mysqli_fetch_row($result)) {
									list($get_online_id, $get_online_channel_id, $get_online_time, $get_online_user_id, $get_online_user_name, $get_online_user_alias, $get_online_user_image_path, $get_online_user_image_file, $get_online_user_image_thumb_40, $get_online_user_image_thumb_50, $get_online_ip, $get_online_hostname, $get_online_user_agent) = $row;

									echo"
									<li><a href=\"dm.php?t_user_id=$get_online_user_id&amp;l=$l\" class=\"users_in_channel_user_alias\">$get_online_user_alias</a></li>";

								} // users
								echo"
								</ul>
							</div>


							<!-- Get users script -->
								<script language=\"javascript\" type=\"text/javascript\">
								\$(document).ready(function () {
									function get_users(){
										var variable_last_time = \$('#variable_last_time').html(); 
										var data = 'l=$l&starred_channel_id=$get_current_starred_channel_id&last_time=' + variable_last_message_id;
            									\$.ajax({
                									type: \"POST\",
               										url: \"open_starred_channel_get_users_online.php\",
                									data: data,
											beforeSend: function(html) { // this happens before actual call
											},
               										success: function(html){
                    										\$(\"#users_in_channel\").html(html);
              										}
       									
										});
									}
									setInterval(get_users,7000);
         				   			});
								</script>
							<!-- //Get users script -->
						<!-- //Users -->
					  </td>
					 </tr>
					</table>
				<!-- //Messages and users online -->

				<!-- New message form -->
				
					<!-- Focus -->
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_text\"]').focus();
						});
						</script>
					<!-- //Focus -->

					
					

					<p>
					<input type=\"text\" name=\"inp_text\" id=\"inp_text\" value=\"\" size=\"25\" style=\"width: 90%;\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />
					<a href=\"#\" id=\"inp_message_send\" class=\"btn_default\" tabindex=\""; $tabindex = $tabindex+1; echo"$tabindex\" />$l_send</a>
					</p>


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
 								// forming the queryString
								var data            = 'l=$l&starred_channel_id=$get_current_starred_channel_id&inp_text='+ inp_text;
         
        							// if searchString is not empty
        							if(inp_text) {
           								// ajax call
            								\$.ajax({
                								type: \"POST\",
               									url: \"open_starred_channel_send_message.php\",
                								data: data,
										beforeSend: function(html) { // this happens before actual call
											
										},
               									success: function(html){
                    									\$(\"#messages\").append(html);
                    									\$(\"#inp_text\").val('');
											\$('#messages').scrollTop(\$('#messages')[0].scrollHeight);
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

					
				// Find message
				$query = "SELECT message_id, message_channel_id, message_text, message_datetime, message_date_saying, message_time_saying, message_time, message_year, message_from_user_id, message_from_user_name, message_from_user_alias, message_from_user_image_path, message_from_user_image_file, message_from_user_image_thumb_40, message_from_user_image_thumb_50, message_from_ip, message_from_hostname, message_from_user_agent FROM $t_talk_channels_messages WHERE message_id=$message_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_current_message_id, $get_current_message_channel_id, $get_current_message_text, $get_current_message_datetime, $get_current_message_date_saying, $get_current_message_time_saying, $get_current_message_time, $get_current_message_year, $get_current_message_from_user_id, $get_current_message_from_user_name, $get_current_message_from_user_alias, $get_current_message_from_user_image_path, $get_current_message_from_user_image_file, $get_current_message_from_user_image_thumb_40, $get_current_message_from_user_image_thumb_50, $get_current_message_from_ip, $get_current_message_from_hostname, $get_current_message_from_user_agent) = $row;
				if($get_current_message_id != ""){
					if($get_current_message_from_user_id == "$my_user_id"){
						$result = mysqli_query($link, "DELETE FROM $t_talk_channels_messages WHERE message_id=$get_current_message_id");

						$url = "open_starred_channel.php?starred_channel_id=$get_current_starred_channel_id&amp;l=$l";
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
		} // channel found

	} // starred channel found

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