<?php
/**
*
* File: users/index.php
* Version 17.46 18.02.2017
* Copyright (c) 2009-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "0";
$pageNoColumnSav      = "2";
$pageAllowCommentsSav = "0";

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

/*- Translation ------------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/users/ts_users.php");

/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_users";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");



/*- Content --------------------------------------------------------------------------- */

if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	// Get user
	$user_id = $_SESSION['user_id'];
	$user_id_mysql = quote_smart($link, $user_id);
	$security = $_SESSION['security'];
	$security_mysql = quote_smart($link, $security);

	$query = "SELECT user_id, user_name, user_alias, user_language, user_rank FROM $t_users WHERE user_id=$user_id_mysql AND user_security=$security_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_user_id, $get_user_name,  $get_user_alias, $get_user_language, $get_user_rank) = $row;

	if($get_user_id != ""){
		echo"
		<h1>$get_user_name</h1>

		<h2>$l_you</h2>
		<div class=\"vertical\">
			<ul>
				<li><a href=\"index.php?l=$l\""; if($page == "users"){ echo" class=\"navigation_active\"";}echo"><img src=\"_gfx/ic_supervisor_account_black_18dp_1x.png\" alt=\"ic_supervisor_account_black_18dp_1x.png\" /> $l_users</a></li>
				<li><a href=\"view_profile.php?user_id=$user_id&amp;l=$l\""; if($page == "view_profile"){ echo" class=\"navigation_active\"";}echo"><img src=\"_gfx/ic_person_black_18dp_1x.png\" alt=\"ic_person_black_18dp_1x.png\" /> $get_user_alias</a></li>
				<li><a href=\"edit_profile.php?l=$l\""; if($page  == "edit_profile"){ echo" class=\"navigation_active\"";}echo"><img src=\"_gfx/ic_mode_edit_black_18dp_1x.png\" alt=\"iic_mode_edit_black_18dp_1x.png\" /> $l_profile</a></li>
				<li><a href=\"photo.php?l=$l\""; if($page  == "photo"){ echo" class=\"navigation_active\"";}echo"><img src=\"_gfx/ic_portrait_black_18dp_1x.png\" alt=\"ic_portrait_black_18dp_1x.png\" /> $l_photo</a></li>
				<li><a href=\"cover_photo.php?l=$l\""; if($page  == "cover_photo"){ echo" class=\"navigation_active\"";}echo"><img src=\"_gfx/ic_insert_photo_black_18dp_1x.png\" alt=\"ic_insert_photo_black_18dp_1x.png\" /> $l_cover_photo</a></li>
				<li><a href=\"edit_address.php?l=$l\""; if($page == "edit_address"){ echo" class=\"navigation_active\"";}echo"><img src=\"_gfx/ic_contact_mail_black_18dp_1x.png\" alt=\"ic_contact_mail_black_18dp_1x.png\" /> $l_address</a></li>
			</ul>	
		</div>

		<h2>$l_general_account_settings</h2>
		<div class=\"vertical\">
			<ul>
				<li><a href=\"edit_subscriptions.php?l=$l\""; if($page == "edit_subscriptions"){ echo" class=\"navigation_active\"";}echo"><img src=\"_gfx/ic_notifications_black_18dp_1x.png\" alt=\"ic_notifications_black_18dp_1x.png\" /> $l_subscriptions</a></li>
				<li><a href=\"settings.php?l=$l\""; if($page == "settings"){ echo" class=\"navigation_active\"";}echo"><img src=\"_gfx/ic_settings_black_18dp_1x.png\" alt=\"ic_settings_black_18dp_1x.png\" /> $l_settings</a></li>
				<li><a href=\"edit_password.php?l=$l\""; if($page == "edit_password"){ echo" class=\"navigation_active\"";}echo"><img src=\"_gfx/ic_lock_outline_black_18dp_1x.png\" alt=\"ic_lock_outline_black_18dp_1x.png\" /> $l_password</a></li>
				<li><a href=\"logout.php?process=1&amp;l=$l\""; if($page  == "logout"){ echo" class=\"navigation_active\"";}echo"><img src=\"_gfx/ic_exit_to_app_black_18dp_1x.png\" alt=\"ic_exit_to_app_black_18dp_1x.png\" /> $l_logout</a></li>
				<li><a href=\"delete_account.php?l=$l\""; if($page  == "delete_account"){ echo" class=\"navigation_active\"";}echo"><img src=\"_gfx/ic_delete_black_18dp_1x.png\" alt=\"ic_delete_black_18dp_1x.png\" /> $l_delete_account</a></li>
			
			</ul>	
		</div>";
			
	}
	else{
		echo"
		<table>
		 <tr> 
		  <td style=\"padding-right: 6px;vertical-align: top;\">
			<span>
			<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"margin:0;padding: 23px 0px 0px 0px;\" />
			</span>
		  </td>
		  <td>
			<h1 style=\"border:0;margin:0;padding: 20px 0px 0px 0px;\">Loading</h1>
		  </td>
		 </tr>
		</table>
		<meta http-equiv=\"refresh\" content=\"1;url=logout.php?process=1&amp;l=$l\">
		";
	}
}
else{
	echo"
	<ul class=\"vertical\">
		<li class=\"header_home\"><a href=\"index.php?l=$l&amp;l=$l\""; if($page  == "users"){ echo" class=\"navigation_active\"";}echo">Users</a></li>

		<li><a href=\"create_free_account.php?l=$l\""; if($page == "create_free_account"){ echo" class=\"navigation_active\"";}echo">$l_create_free_account</a></li>
		<li><a href=\"login.php?l=$l\""; if($page == "login"){ echo" class=\"navigation_active\"";}echo">$l_login</a></li>
	</ul>";
}
/*- Footer ---------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");

?>