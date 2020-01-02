<?php
/**
*
* File: _admin/_inc/talk/default.php
* Version 
* Date 19:59 02.08.2019
* Copyright (c) 2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}


/*- Tables ---------------------------------------------------------------------------- */
$t_talk_liquidbase				= $mysqlPrefixSav . "talk_liquidbase";

$t_talk_channels_index		= $mysqlPrefixSav . "talk_channels_index";
$t_talk_channels_messages	= $mysqlPrefixSav . "talk_channels_messages";
$t_talk_channels_users_online	= $mysqlPrefixSav . "talk_channels_users_online";
$t_talk_users_starred_channels	= $mysqlPrefixSav . "talk_users_starred_channels";

$t_talk_dm_conversations = $mysqlPrefixSav . "talk_dm_conversations";
$t_talk_dm_messages	 = $mysqlPrefixSav . "talk_dm_messages";

$t_talk_total_unread = $mysqlPrefixSav . "talk_total_unread";

$t_talk_emojies_categories_main	= $mysqlPrefixSav . "talk_emojies_categories_main";
$t_talk_emojies_categories_sub	= $mysqlPrefixSav . "talk_emojies_categories_sub";
$t_talk_emojies_index 		= $mysqlPrefixSav . "talk_emojies_index";


/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['mode'])){
	$mode = $_GET['mode'];
	$mode = output_html($mode);
}
else{
	$mode = "";
}


/*- Config ------------------------------------------------------------------------------- */
if(!(file_exists("_data/talk.php"))){
	$update_file="<?php
// Encryption
\$talkEncryptionMethodSav		 = \"openssl_encrypt(AES-128-CBC)\";
?>";

		$fh = fopen("_data/talk.php", "w+") or die("can not open file");
		fwrite($fh, $update_file);
		fclose($fh);
}
include("_data/talk.php");

/*- Variables ------------------------------------------------------------------------ */
$tabindex = 0;


if($action == ""){

	if($mode == "save"){
		$inp_encryption_method = $_POST['inp_encryption_method'];
		$inp_encryption_method = output_html($inp_encryption_method);

	$update_file="<?php
// Encryption
\$talkEncryptionMethodSav		 = \"$inp_encryption_method\";
?>";

		$fh = fopen("_data/talk.php", "w+") or die("can not open file");
		fwrite($fh, $update_file);
		fclose($fh);

		// Update chats
		$result_update = mysqli_query($link, "UPDATE $t_talk_channels_index SET 
						channel_encryption_key='',
						channel_encryption_key_year=0, 
						channel_encryption_key_month=0") or die(mysqli_error($link));
		$result_delete = mysqli_query($link, "DELETE FROM $t_talk_channels_messages") or die(mysqli_error($link));


		echo"<h1>Saving..</h1>
		<meta http-equiv=refresh content=\"1; url=index.php?open=$open&page=$page&ft=success&fm=changes_saved\">";
		// header("Location: ?open=$open&page=$page&ft=success&fm=changes_saved");
		// exit;
	}


	echo"
	<h1>Talk</h1>
				

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


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=talk&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Talk</a>
		&gt;
		<a href=\"index.php?open=talk&amp;page=default&amp;editor_language=$editor_language&amp;l=$l\">Default</a>
		</p>
	<!-- //Where am I? -->


	<!-- Focus -->
		<script>
		\$(document).ready(function(){
			\$('[name=\"inp_website_title\"]').focus();
		});
		</script>
	<!-- //Focus -->
	<!-- Settings -->
		<form method=\"post\" action=\"?open=$open&page=$page&amp;mode=save\" enctype=\"multipart/form-data\">
		

		<p>Encryption method:<br />
		<select name=\"inp_encryption_method\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">
			<option value=\"none\""; if($talkEncryptionMethodSav == "none"){ echo" selected=\"selected\""; } echo">None</option>
			<option value=\"openssl_encrypt(AES-128-CBC)\""; if($talkEncryptionMethodSav == "openssl_encrypt(AES-128-CBC)"){ echo" selected=\"selected\""; } echo">openssl_encrypt(AES-128-CBC)</option>
			<option value=\"caesar_cipher(random)\""; if($talkEncryptionMethodSav == "caesar_cipher(random)"){ echo" selected=\"selected\""; } echo">Caesar cipher(random)</option>
		</select>
		</p>


		<p><input type=\"submit\" value=\"Save changes\" class=\"btn\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
		</form>		
	<!-- //Settings -->
	";
}
?>