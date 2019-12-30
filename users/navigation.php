<?php

if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	// Get user
	$user_id = $_SESSION['user_id'];
	$user_id_mysql = quote_smart($link, $user_id);
	$security = $_SESSION['security'];
	$security_mysql = quote_smart($link, $security);

	$query = "SELECT user_id, user_name, user_language, user_rank FROM $t_users WHERE user_id=$user_id_mysql AND user_security=$security_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_user_id, $get_user_name, $get_user_language, $get_user_rank) = $row;

	if($get_user_id != ""){
		echo"
		<ul>
			<li class=\"header_home\"><a href=\"index.php?l=$l\""; if($page  == "users"){ echo" class=\"navigation_active\"";}echo">$l_users</a></li>
			";
			echo"
			<li><a href=\"view_profile.php?user_id=$user_id&amp;l=$l\""; if($page == "view_profile"){ echo" class=\"navigation_active\"";}echo">$get_user_name</a></li>
			<li><a href=\"edit_profile.php?l=$l\""; if($page  == "edit_profile"){ echo" class=\"navigation_active\"";}echo">$l_profile</a></li>
			<li><a href=\"photo.php?l=$l\""; if($page  == "photo"){ echo" class=\"navigation_active\"";}echo">$l_photo</a></li>
			<li><a href=\"cover_photo.php?l=$l\""; if($page  == "cover_photo"){ echo" class=\"navigation_active\"";}echo">$l_cover_photo</a></li>
			<li><a href=\"edit_address.php?l=$l\""; if($page == "edit_address"){ echo" class=\"navigation_active\"";}echo">$l_address</a></li>
			<li><a href=\"edit_subscriptions.php?l=$l\""; if($page == "edit_subscriptions"){ echo" class=\"navigation_active\"";}echo">$l_subscriptions</a></li>
			<li><a href=\"settings.php?l=$l\""; if($page == "settings"){ echo" class=\"navigation_active\"";}echo">$l_settings</a></li>
			<li><a href=\"edit_password.php?l=$l\""; if($page == "edit_password"){ echo" class=\"navigation_active\"";}echo">$l_password</a></li>
			<li><a href=\"friend_requests.php?l=$l\""; if($page  == "friend_requests"){ echo" class=\"navigation_active\"";}echo">$l_friend_requests</a></li>
			<li><a href=\"edit_professional.php?l=$l\""; if($page  == "edit_professional"){ echo" class=\"navigation_active\"";}echo">$l_professional</a></li>
			<li><a href=\"notifications.php?l=$l\""; if($page  == "notifications"){ echo" class=\"navigation_active\"";}echo">$l_notifications</a></li>
			<li><a href=\"logout.php?process=1&amp;l=$l\""; if($page  == "logout"){ echo" class=\"navigation_active\"";}echo">$l_logout</a></li>
			<li><a href=\"delete_account.php?l=$l\""; if($page  == "delete_account"){ echo" class=\"navigation_active\"";}echo">$l_delete_account</a></li>
			
		</ul>";
			
	}
}
else{
	echo"
	<ul>
		<li class=\"header_home\"><a href=\"index.php?l=$l&amp;l=$l\""; if($page  == "users"){ echo" class=\"navigation_active\"";}echo">$l_users</a></li>

		<li><a href=\"create_free_account.php?l=$l\""; if($page == "create_free_account"){ echo" class=\"navigation_active\"";}echo">$l_create_free_account</a></li>
		<li><a href=\"login.php?l=$l\""; if($page == "login"){ echo" class=\"navigation_active\"";}echo">$l_login</a></li>
	</ul>";
}
?>