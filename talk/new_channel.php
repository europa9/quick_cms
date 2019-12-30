<?php 
/**
*
* File: talk/new_channel.php
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


/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/talk/ts_talk.php");

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




/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_talk - $l_new_channel";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */
// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
	// Get my user
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_rank) = $row;
	
	if($process == "1"){
		// Title
		$inp_name = $_POST['inp_name'];
		$inp_name = output_html($inp_name);
		$inp_name_mysql = quote_smart($link, $inp_name);

		if($inp_name == ""){
			$url = "new_channel.php?l=$l&ft=error&fm=insert_a_name";
			header("Location: $url");
			exit;
		}
		
		// Already exists?
		$query = "SELECT channel_id FROM $t_talk_channels_index WHERE channel_name=$inp_name_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_channel_id) = $row;
		if($get_channel_id != ""){
			$url = "new_channel.php?l=$l&ft=error&fm=name_is_taken";
			header("Location: $url");
			exit;
		}

		// Password
		$inp_password = $_POST['inp_password'];
		if($inp_password == ""){
			$inp_password_encrypted = "";
		}
		else{
			$inp_password_encrypted = sha1($inp_password);
		}
		$inp_password_encrypted_mysql = quote_smart($link, $inp_password_encrypted);
		
		// Dates
		$time = time();
		$date_saying = date("j M Y H:i");

		// My IP
		$inp_my_ip = $_SERVER['REMOTE_ADDR'];
		$inp_my_ip = output_html($inp_my_ip);
		$inp_my_ip_mysql = quote_smart($link, $inp_my_ip);


		mysqli_query($link, "INSERT INTO $t_talk_channels_index
		(channel_id, channel_name, channel_password, channel_created_by_user_id, channel_created_by_user_ip, channel_created_datetime, channel_created_saying, channel_last_message_time, channel_last_message_saying, channel_users_online) 
		VALUES 
		(NULL, $inp_name_mysql, $inp_password_encrypted_mysql, $get_my_user_id, $inp_my_ip_mysql, '$datetime', '$date_saying', '$time', '$date_saying', 1)")
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
		$query = "SELECT starred_channel_id, channel_id, channel_name, new_messages, user_id FROM $t_talk_users_starred_channels WHERE channel_id=$get_channel_id AND user_id=$my_user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_starred_channel_id, $get_current_channel_id, $get_current_channel_name, $get_current_new_messages, $get_current_user_id) = $row;

		
		// Header
		$url = "open_starred_channel.php?starred_channel_id=$get_current_starred_channel_id&ft=success&fm=channel_created&l=$l";
		header("Location: $url");
		exit;

	}
	echo"
	<h1>$l_new_channel</h1>
		
	<!-- Feedback -->
		";
		if($ft != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			else{
				$fm = ucfirst($fm);
			}
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
	<!-- //Feedback -->


	<!-- Form -->
		<script>
		\$(document).ready(function(){
			\$('[name=\"inp_name\"]').focus();
		});
		</script>
	
		<form method=\"post\" action=\"new_channel.php?l=$l&amp;process=1\" enctype=\"multipart/form-data\">


		<p><b>$l_name:</b><br />
		<input type=\"text\" name=\"inp_name\" value=\"";
		if(isset($_GET['inp_name'])){
			$inp_name = $_GET['inp_name'];
			$inp_name = output_html($inp_name);
			echo"$inp_name";
		}
		echo"\" size=\"25\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
		</p>

		<p><b>$l_password</b><br />
		<span class=\"small\">$l_leave_blank_if_you_dont_want_a_channel_password</span><br />
		<input type=\"password\" name=\"inp_password\" value=\"";
		if(isset($_GET['inp_password'])){
			$inp_password = $_GET['inp_password'];
			$inp_password = output_html($inp_password);
			echo"$inp_password";
		}
		echo"\" size=\"25\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
		</p>


		<p><input type=\"submit\" value=\"$l_create_channel\" class=\"btn btn_default\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
		</form>
		<!-- //Form -->
	";
	
}
else{
	echo"
	<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" /> Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/discuss/new_topic.php\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>