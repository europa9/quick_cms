<?php
/**
*
* File: _admin/_inc/settings/user_system.php
* Version 02:10 28.12.2011
* Copyright (c) 2008-2012 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}



if($process == "1"){
	$inp_users_can_register = $_POST['inp_users_can_register'];
	if($inp_users_can_register != "1"){
		$inp_users_can_register = "0";
	}


	$inp_users_avatar_width = $_POST['inp_users_avatar_width'];
	$inp_users_avatar_width = output_html($inp_users_avatar_width);

	$inp_users_avatar_height = $_POST['inp_users_avatar_height'];
	$inp_users_avatar_height = output_html($inp_users_avatar_height);


	$inp_users_picture_width = $_POST['inp_users_picture_width'];
	$inp_users_picture_width = output_html($inp_users_picture_width);

	$inp_users_picture_height = $_POST['inp_users_picture_height'];
	$inp_users_picture_height = output_html($inp_users_picture_height);

	$inp_users_allowed_mail_addresses = $_POST['inp_users_allowed_mail_addresses'];
	$inp_users_allowed_mail_addresses = output_html($inp_users_allowed_mail_addresses);

	$inp_users_email_verification = $_POST['inp_users_email_verification'];
	if($inp_users_email_verification != "1"){
		$inp_users_email_verification = "0";
	}


	$inp_users_has_to_be_verified_by_moderator = $_POST['inp_users_has_to_be_verified_by_moderator'];
	$inp_users_has_to_be_verified_by_moderator = output_html($inp_users_has_to_be_verified_by_moderator);


	

	$update_file="<?php
\$configUsersCanRegisterSav   			= \"$inp_users_can_register\";
\$configUsersAvatarWidthSav   			= \"$inp_users_avatar_width\";
\$configUsersAvatarHeightSav  			= \"$inp_users_avatar_height\";
\$configUsersPictureWidthSav  			= \"$inp_users_picture_width\";
\$configUsersPictureHeightSav 			= \"$inp_users_picture_height\";
\$configUsersAllowedMailAddressesSav 		= \"$inp_users_allowed_mail_addresses\";
\$configUsersEmailVerificationSav 		= \"$inp_users_email_verification\";
\$configUsersHasToBeVerifiedByModeratorSav 	= \"$inp_users_has_to_be_verified_by_moderator\";
?>";

	$fh = fopen("_data/config/user_system.php", "w+") or die("can not open file");
	fwrite($fh, $update_file);
	fclose($fh);

	header("Location: ?open=$open&page=user_system&ft=success&fm=changes_saved&editor_language=$editor_language");
	exit;
}


$tabindex = 0;
echo"
<h1>$l_user_system</h1>
<form method=\"post\" action=\"?open=$open&amp;page=user_system&amp;process=1&amp;editor_language=$editor_language\" enctype=\"multipart/form-data\">
				
	
<!-- Feedback -->
";
if($ft != ""){
	if($fm == "changes_saved"){
		$fm = "$l_changes_saved";
	}
	else{
		$fm = ucfirst($ft);
	}
	echo"<div class=\"$ft\"><span>$fm</span></div>";
}
echo"	
<!-- //Feedback -->


<!-- Focus -->
	<script>
	\$(document).ready(function(){
		\$('[name=\"inp_users_can_register\"]').focus();
	});
	</script>
<!-- //Focus -->

<p><b>$l_registration_function:</b><br />

	<input type=\"radio\" name=\"inp_users_can_register\" value=\"1\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\"";if($configUsersCanRegisterSav == "1"){ echo" checked=\"checked\"";}echo" />
	$l_active 
	&nbsp;
	<input type=\"radio\" name=\"inp_users_can_register\" value=\"0\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\"";if($configUsersCanRegisterSav == "0"){ echo" checked=\"checked\"";}echo" />
	$l_inactive
	</p>

<p><b>$l_avatar_size:</b><br />

	<input type=\"text\" name=\"inp_users_avatar_width\" value=\"$configUsersAvatarWidthSav\" size=\"4\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
	x
	<input type=\"text\" name=\"inp_users_avatar_height\" value=\"$configUsersAvatarHeightSav\" size=\"4\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
	$l_pixels
	</p>

<p><b>$l_image_size:</b><br />

	<input type=\"text\" name=\"inp_users_picture_width\" value=\"$configUsersPictureWidthSav\" size=\"4\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
	x
	<input type=\"text\" name=\"inp_users_picture_height\" value=\"$configUsersPictureHeightSav\" size=\"4\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
	$l_pixels
</p>

<p><b>$l_approved_email_addresses:</b><br />
<input type=\"text\" name=\"inp_users_allowed_mail_addresses\" value=\"$configUsersAllowedMailAddressesSav\" size=\"60\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /><br />
	$l_example: student.hive.no, student.uia.no, google.com</p>

<p><b>$l_email_verification:</b><br />
<input type=\"radio\" name=\"inp_users_email_verification\" value=\"1\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\"";if($configUsersEmailVerificationSav == "1"){ echo" checked=\"checked\"";}echo" />
$l_yes
&nbsp;
<input type=\"radio\" name=\"inp_users_email_verification\" value=\"0\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\"";if($configUsersEmailVerificationSav == "0"){ echo" checked=\"checked\"";}echo" />
$l_no
</p>


<p><b>$l_users_has_to_be_verified_by_moderator:</b><br />
<input type=\"radio\" name=\"inp_users_has_to_be_verified_by_moderator\" value=\"1\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\"";if($configUsersHasToBeVerifiedByModeratorSav == "1"){ echo" checked=\"checked\"";}echo" />
$l_yes
&nbsp;
<input type=\"radio\" name=\"inp_users_has_to_be_verified_by_moderator\" value=\"0\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\"";if($configUsersHasToBeVerifiedByModeratorSav == "0"){ echo" checked=\"checked\"";}echo" />
$l_no
</p>

<p><input type=\"submit\" value=\"$l_save_changes\" class=\"submit\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>

</form>

";
?>