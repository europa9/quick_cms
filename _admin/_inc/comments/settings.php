<?php
/**
*
* File: _admin/_inc/comments/settings.php
* Version 19.25 18.03.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Config ----------------------------------------------------------------------------- */
if(file_exists("_data/config/comments_settings.php")){
	include("_data/config/comments_settings.php");
}

/*- Variables -------------------------------------------------------------------------- */
$tabindex = 0;



/*- Process ---------------------------------------------------------------------------- */
if($process == "1"){
	$inp_who_can_comment = $_POST['inp_who_can_comment'];
	$inp_who_can_comment = output_html($inp_who_can_comment);

	$inp_comment_system_active = $_POST['inp_comment_system_active'];
	$inp_comment_system_active = output_html($inp_comment_system_active);

	$inp_not_approved_users_can_post_links = $_POST['inp_not_approved_users_can_post_links'];
	$inp_not_approved_users_can_post_links = output_html($inp_not_approved_users_can_post_links);




	$update_file="<?php
\$whoCanCommentSav 		  = \"$inp_who_can_comment\";
\$commentSystemActiveSav 	  = \"$inp_comment_system_active\";
\$notApprovedUsersCanPostLinksSav = \"$inp_not_approved_users_can_post_links\";
?>";

	$fh = fopen("_data/config/comments_settings.php", "w+") or die("can not open file");
	fwrite($fh, $update_file);
	fclose($fh);

	header("Location: ?open=$open&page=$page&ft=success&fm=changes_saved");
	exit;
}


/*- Page ---------------------------------------------------------------------------- */
echo"
<h1>Settings</h1>
<form method=\"post\" action=\"?open=$open&amp;page=$page&amp;process=1\" enctype=\"multipart/form-data\">
				
	
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
		\$('[name=\"inp_owner_name\"]').focus();
	});
	</script>
<!-- //Focus -->

<p>Who can comment:<br />
<input type=\"radio\" name=\"inp_who_can_comment\" value=\"everyone\""; if(isset($whoCanCommentSav) && $whoCanCommentSav == "everyone"){ echo" checked=\"checked\" "; } echo" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /> Everyone
&nbsp;
<input type=\"radio\" name=\"inp_who_can_comment\" value=\"registered_users\""; if(isset($whoCanCommentSav) && $whoCanCommentSav == "registered_users"){ echo" checked=\"checked\" "; } echo" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /> Registered users
</p>

<p>Comment system active:<br />
<input type=\"radio\" name=\"inp_comment_system_active\" value=\"true\""; if(isset($commentSystemActiveSav) && $commentSystemActiveSav == "true"){ echo" checked=\"checked\" "; } echo" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /> Active
&nbsp;
<input type=\"radio\" name=\"inp_comment_system_active\" value=\"false\""; if(isset($commentSystemActiveSav) && $commentSystemActiveSav == "false"){ echo" checked=\"checked\" "; } echo" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /> Inactive
</p>


<p>Users that are not approved yet:<br />
<input type=\"radio\" name=\"inp_not_approved_users_can_post_links\" value=\"true\""; if(isset($notApprovedUsersCanPostLinksSav) && $notApprovedUsersCanPostLinksSav == "true"){ echo" checked=\"checked\" "; } echo" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /> Can post links
&nbsp;
<input type=\"radio\" name=\"inp_not_approved_users_can_post_links\" value=\"false\""; if(isset($notApprovedUsersCanPostLinksSav) && $notApprovedUsersCanPostLinksSav == "false"){ echo" checked=\"checked\" "; } echo" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /> Can't post links
<br />
<span class=\"smal\">All users have a setting named &quot;user_verified_by_moderator&quot;. If this is set to 1 then the user is approved, if it's set to 0 
then the user has not been approved.</span></p>

<p><input type=\"submit\" value=\"$l_save_changes\" class=\"btn btn-success btn-sm\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>



</form>

";
?>