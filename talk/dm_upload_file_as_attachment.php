<?php 
/**
*
* File: talk/dm_upload_file_as_attachment.php
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
		echo"<h1>To user not found</h1>";
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

		// Dates
		$datetime_clean = date("YmdHis");
				
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

		
		// Check for file (to be attatched to message)
		if(!(is_dir("$root/_uploads/"))){
			mkdir("$root/_uploads/", 0777);
		}
		if(!(is_dir("$root/_uploads/talk/"))){
			mkdir("$root/_uploads/talk/", 0777);
		}
		if(!(is_dir("$root/_uploads/talk/images"))){
			mkdir("$root/_uploads/talk/images", 0777);
		}
		if(!(is_dir("$root/_uploads/talk/images/$get_current_conversation_id"))){
			mkdir("$root/_uploads/talk/images/$get_current_conversation_id", 0777);
		}
				
		$inp_file_name = $_FILES['inp_file']['name'];
		$extension = get_extension($inp_file_name);
		$extension = strtolower($extension);
		if($inp_file_name){
			if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
				$ft = "warning";
				$fm = "unknown_file_format";	
			}
			else{
				$size=filesize($_FILES['inp_file']['tmp_name']);
				if($extension=="jpg" || $extension=="jpeg" ){
					ini_set ('gd.jpeg_ignore_warning', 1);
					error_reporting(0);
					$uploadedfile = $_FILES['inp_file']['tmp_name'];
					$src = imagecreatefromjpeg($uploadedfile);
				}
				elseif($extension=="png"){
					$uploadedfile = $_FILES['inp_file']['tmp_name'];
					$src = @imagecreatefrompng($uploadedfile);
				}
				else{
					$src = @imagecreatefromgif($uploadedfile);
				}

				list($width,$height) = @getimagesize($uploadedfile);
				if($width == "" OR $height == ""){
					$ft = "warning";
					$fm = "photo_could_not_be_uploaded_please_check_file_size";
				}
				else{
					// Keep orginal
					if($width > 971){
						$newwidth=970;
					}
					else{
						$newwidth=$width;
					}
					$newheight=round(($height/$width)*$newwidth, 0);
					$tmp_org =imagecreatetruecolor($newwidth,$newheight);

					imagecopyresampled($tmp_org,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
					$datetime = date("ymdhis");
					$filename = "$root/_uploads/talk/images/$get_current_conversation_id/". $get_my_user_id . "_" . $get_to_user_id . "_" . $datetime_clean . "." . $extension;

					if($extension=="jpg" || $extension=="jpeg" ){
						imagejpeg($tmp_org,$filename,100);
					}
					elseif($extension=="png"){
						imagepng($tmp_org,$filename);
					}
					else{
						imagegif($tmp_org,$filename);
					}
					imagedestroy($tmp_org);

					// Make thumb
					if($width > 41){
						$newwidth=40;
					}
					else{
						$newwidth=$width;
					}
					$newheight=round(($height/$width)*$newwidth, 0);
					$tmp_org =imagecreatetruecolor($newwidth,$newheight);

					imagecopyresampled($tmp_org,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
					$datetime = date("ymdhis");
					$filename = "$root/_uploads/talk/images/$get_current_conversation_id/". $get_my_user_id . "_" . $get_to_user_id . "_" . $datetime_clean . "_thumb." . $extension;

					if($extension=="jpg" || $extension=="jpeg" ){
						imagejpeg($tmp_org,$filename,100);
					}
					elseif($extension=="png"){
						imagepng($tmp_org,$filename);
					}
					else{
						imagegif($tmp_org,$filename);
					}
					imagedestroy($tmp_org);

					// Send feedback
					$inp_attachment_type = "$extension";
					$inp_attachment_type = output_html($inp_attachment_type);
					$inp_attachment_type_mysql = quote_smart($link, $inp_attachment_type);

					$inp_attachment_path = "_uploads/talk/images/$get_current_conversation_id/";
					$inp_attachment_path_mysql = quote_smart($link, $inp_attachment_path);

					$inp_attachment_file = $get_my_user_id . "_" . $get_to_user_id . "_" . $datetime_clean . "." . $extension;
					$inp_attachment_file = output_html($inp_attachment_file);
					$inp_attachment_file_mysql = quote_smart($link, $inp_attachment_file);

					$inp_attachment_thumb = $get_my_user_id . "_" . $get_to_user_id . "_" . $datetime_clean . "_thumb." . $extension;
					$inp_attachment_thumb = output_html($inp_attachment_thumb);
					$inp_attachment_thumb_mysql = quote_smart($link, $inp_attachment_thumb);

					$url = "dm.php?t_user_id=$get_to_user_id&inp_file=$inp_attachment_file&inp_thumb=$inp_attachment_thumb&l=$l";
					header("Location: $url");
					exit;

					echo"
					<img src=\"$root/$inp_attachment_path/$inp_attachment_thumb\" alt=\"$inp_attachment_file\" />
					";
						
						
				}  // if($width == "" OR $height == ""){
			}
		} // if($image){
		else{
			echo"No image selected";
		}
	} // to_user found

} // logged in


?>