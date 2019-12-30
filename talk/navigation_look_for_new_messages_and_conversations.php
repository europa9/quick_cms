<?php

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
include("$root/_admin/_translations/site/$l/talk/ts_talk.php");

/*- Variables -------------------------------------------------------------------------- */
if(isset($_POST['starred_channel_id'])){
	$starred_channel_id = $_POST['starred_channel_id'];
	$starred_channel_id = output_html($starred_channel_id);
}
else{
	$starred_channel_id = "";
}

if(isset($_POST['t_user_id'])){
	$t_user_id = $_POST['t_user_id'];
	$t_user_id = output_html($t_user_id);
}
else{
	$t_user_id = "";
}

if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);

	/*- Tables ---------------------------------------------------------------------------- */
	$t_talk_channels_index		= $mysqlPrefixSav . "talk_channels_index";
	$t_talk_channels_messages	= $mysqlPrefixSav . "talk_channels_messages";
	$t_talk_channels_users_online	= $mysqlPrefixSav . "talk_channels_users_online";
	$t_talk_users_starred_channels	= $mysqlPrefixSav . "talk_users_starred_channels";

	$t_talk_dm_conversations = $mysqlPrefixSav . "talk_dm_conversations";
	$t_talk_dm_messages	 = $mysqlPrefixSav . "talk_dm_messages";

	$t_talk_total_unread = $mysqlPrefixSav . "talk_total_unread";

	// Date
	$time = time();
	$datetime = date("Y-m-d H:i:s");

	// My channels
	$query = "SELECT starred_channel_id, channel_id, channel_name, new_messages, user_id FROM $t_talk_users_starred_channels WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_starred_channel_id, $get_channel_id, $get_channel_name, $get_new_messages, $get_user_id) = $row;
		echo"
		<li><a href=\"$root/talk/open_starred_channel.php?starred_channel_id=$get_starred_channel_id&amp;l=$l\""; if($get_starred_channel_id == "$starred_channel_id"){ echo" class=\"navigation_active\"";}echo">$get_channel_name";
		echo" <b id=\"navigation_starred_channel_id$get_starred_channel_id\">";
		if($get_new_messages != "0"){echo"$get_new_messages"; }
		echo"</b>";
		echo"</a></li>
		";
	}
	echo"
	";

	// Conversations
	echo"
		<li class=\"header_up\"><a href=\"$root/talk/direct_messages.php?l=$l\""; if($minus_one == "direct_messages.php"){ echo" class=\"navigation_active\"";}echo">$l_direct_messages</a></li>
	";
	$query = "SELECT conversation_id, conversation_key, conversation_f_unread_messages, conversation_t_user_id, conversation_t_user_alias, conversation_t_last_online_time FROM $t_talk_dm_conversations WHERE conversation_f_user_id=$my_user_id_mysql AND conversation_f_has_blocked=0";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_conversation_id, $get_conversation_key, $get_conversation_f_unread_messages, $get_conversation_t_user_id, $get_conversation_t_user_alias, $get_conversation_t_last_online_time) = $row;

		$seconds_since_online = $time-$get_conversation_t_last_online_time;

		echo"
		<li><a href=\"$root/talk/dm.php?t_user_id=$get_conversation_t_user_id&amp;l=$l\""; if($get_conversation_t_user_id == "$t_user_id"){ echo" class=\"navigation_active\"";}echo">";

		if($seconds_since_online > 100){
			echo"<span style=\"color: #42b72a;height: 7px; width: 7px; background-color: #a0a0a0; border-radius: 50%; display: inline-block;float: left;margin: 6px 4px 0px 0px\"></span>";
		}
		else{
			echo"<span style=\"color: #42b72a;height: 7px; width: 7px; background-color: #42b72a; border-radius: 50%; display: inline-block;float: left;margin: 6px 4px 0px 0px\"></span>";
		}

		echo"$get_conversation_t_user_alias";
		echo" <b id=\"conversation_id$get_conversation_id\">";
		if($get_conversation_f_unread_messages != "0"){echo"$get_conversation_f_unread_messages"; }
		echo"</b>";
		echo"</a></li>
		";
	}

	// Update my online time
	$result = mysqli_query($link, "UPDATE $t_users SET user_last_online='$datetime' AND user_last_online_time='$time' WHERE user_id=$my_user_id_mysql");
	$result = mysqli_query($link, "UPDATE $t_talk_dm_conversations SET conversation_t_last_online_time='$time' WHERE conversation_t_user_id=$my_user_id_mysql");

} // logged in
?>