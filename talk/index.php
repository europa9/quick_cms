<?php 
/**
*
* File: talk/index.php
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


/*- Tables ---------------------------------------------------------------------------- */
$t_talk_channels_index		= $mysqlPrefixSav . "talk_channels_index";
$t_talk_channels_messages	= $mysqlPrefixSav . "talk_channels_messages";
$t_talk_channels_users_online	= $mysqlPrefixSav . "talk_channels_users_online";
$t_talk_private			= $mysqlPrefixSav . "talk_private";
$t_talk_users_starred_channels	= $mysqlPrefixSav . "talk_users_starred_channels";
$t_talk_users_starred_users	= $mysqlPrefixSav . "talk_users_starred_users";


/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	// Get my user
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_rank) = $row;


	// Count number of starred channels
	$query = "SELECT count(starred_channel_id) FROM $t_talk_users_starred_channels WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($count_starred_channel_id) = $row;


	if($count_starred_channel_id == "0"){
		// Count number channels
		$query = "SELECT count(channel_id) FROM $t_talk_channels_index WHERE channel_password=''";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($count_channel_id) = $row;

		if($count_channel_id == "0"){
			// Create a channel and join it	

			// My IP
			$inp_my_ip = $_SERVER['REMOTE_ADDR'];
			$inp_my_ip = output_html($inp_my_ip);
			$inp_my_ip_mysql = quote_smart($link, $inp_my_ip);

			// Dates
			$datetime = date("Y-m-d H:i:s");
			$time = time();
			$date_saying = date("j. M Y H:i");
			$inp_name_mysql = quote_smart($link, $configWebsiteTitleSav);
			mysqli_query($link, "INSERT INTO $t_talk_channels_index
			(channel_id, channel_name, channel_password, channel_created_by_user_id, channel_created_by_user_ip, channel_created_datetime, channel_created_saying, channel_last_message_time, channel_last_message_saying, channel_users_online) 
			VALUES 
			(NULL, $inp_name_mysql, '', $get_my_user_id, $inp_my_ip_mysql, '$datetime', '$date_saying', '$time', '$date_saying', 1)")
			or die(mysqli_error($link));
			
			// Get ID
			$query = "SELECT channel_id FROM $t_talk_channels_index WHERE channel_name=$inp_name_mysql AND channel_last_message_time='$time'";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_channel_id) = $row;

			// Starred
			mysqli_query($link, "INSERT INTO $t_talk_users_starred_channels
			(starred_channel_id, channel_id, channel_name, new_messages, user_id) 
			VALUES 
			(NULL, $get_channel_id, $inp_name_mysql, 0, $get_my_user_id)")
			or die(mysqli_error($link));

			// Get starred channel ID
			$query = "SELECT starred_channel_id, channel_id, channel_name, new_messages, user_id FROM $t_talk_users_starred_channels WHERE user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_starred_channel_id, $get_current_channel_id, $get_current_channel_name, $get_current_new_messages, $get_current_user_id) = $row;
			

			// Go to that channel
			$url = "$root/talk/open_starred_channel.php?starred_channel_id=$get_current_starred_channel_id&l=$l";
			header("Location: $url");
			exit;
		}
		elseif($count_channel_id == "1"){
			// Join the first channel avaible

			// Get ID
			$query = "SELECT channel_id, channel_name FROM $t_talk_channels_index";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_channel_id, $get_channel_name) = $row;

			$inp_name_mysql = quote_smart($link, $get_channel_name);

			// Starred
			mysqli_query($link, "INSERT INTO $t_talk_users_starred_channels
			(starred_channel_id, channel_id, channel_name, new_messages, user_id) 
			VALUES 
			(NULL, $get_channel_id, $inp_name_mysql, 0, $get_my_user_id)")
			or die(mysqli_error($link));

			// Get starred channel ID
			$query = "SELECT starred_channel_id, channel_id, channel_name, new_messages, user_id FROM $t_talk_users_starred_channels WHERE user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_starred_channel_id, $get_current_channel_id, $get_current_channel_name, $get_current_new_messages, $get_current_user_id) = $row;
		
			// Go to that channel
			$url = "$root/talk/open_starred_channel.php?starred_channel_id=$get_current_starred_channel_id&l=$l";
			header("Location: $url");
			exit;



		}
		else{
			// Find channels to join
			$url = "$root/talk/channel_list.php?l=$l";
			header("Location: $url");
			exit;
		}
	}
	elseif($count_starred_channel_id == "1"){
		// Find my starred channel
		$query = "SELECT starred_channel_id, channel_id, channel_name, new_messages, user_id FROM $t_talk_users_starred_channels WHERE user_id=$my_user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_starred_channel_id, $get_current_channel_id, $get_current_channel_name, $get_current_new_messages, $get_current_user_id) = $row;

	
		$url = "$root/talk/open_starred_channel.php?starred_channel_id=$get_current_starred_channel_id&?l=$l";
		header("Location: $url");
		exit;
	}

	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "$l_talk";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");

	// We have many channels
	echo"
	<h1>$l_talk</h1>

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

	<!-- Channels and conversations -->
		<table>
		 <tr>
		  <td style=\"padding-right: 40px;vertical-align:top;\">
			<h2>$l_starred_channels</h2>
			<div class=\"vertical\" style=\"width: 100%;\">
				<ul style=\"width: 100%;\">";
					$query = "SELECT starred_channel_id, channel_id, channel_name, new_messages, user_id FROM $t_talk_users_starred_channels WHERE user_id=$my_user_id_mysql";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_starred_channel_id, $get_channel_id, $get_channel_name, $get_new_messages, $get_user_id) = $row;
						echo"
						<li style=\"width: 100%;\"><a href=\"$root/talk/open_starred_channel.php?starred_channel_id=$get_starred_channel_id&amp;l=$l\">$get_channel_name</a></li>
						";
					}
					echo"
				</ul>
			</div>
		  </td>
		  <td style=\"vertical-align:top;\">
			<h2>$l_direct_messages</h2>
			<div class=\"vertical\" style=\"width: 100%;\">
				<ul style=\"width: 100%;\">";
					$query = "SELECT conversation_id, conversation_key, conversation_f_unread_messages, conversation_t_user_id, conversation_t_user_alias FROM $t_talk_dm_conversations WHERE conversation_f_user_id=$my_user_id_mysql AND conversation_f_has_blocked=0";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_conversation_id, $get_conversation_key, $get_conversation_f_unread_messages, $get_conversation_t_user_id, $get_conversation_t_user_alias) = $row;
						echo"
						<li style=\"width: 100%;\"><a href=\"$root/talk/dm.php?t_user_id=$get_conversation_t_user_id&amp;l=$l\">$get_conversation_t_user_alias</a></li>
						";
					}
					echo"
				</ul>
			</div>
		  </td>
		 </tr>
		</table>
	<!-- //Channels and conversations -->


	";
} // logged in
else{
	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "$l_talk";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");



	
	echo"
	<h1>$l_talk</h1>

	<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /></h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/talk\">
	";
}
/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/$webdesignSav/footer.php");
?>