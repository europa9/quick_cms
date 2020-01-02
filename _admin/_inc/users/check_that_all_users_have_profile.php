<?php
/**
*
* File: _admin/_inc/users/check_that_all_users_have_profile.php
* Version 1.0
* Date: 17:03 02.01.2020
* Copyright (c) 2008-2020 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['order_by'])) {
	$order_by = $_GET['order_by'];
	$order_by = strip_tags(stripslashes($order_by));
}
else{
	$order_by = "";
}
if($order_by == ""){
	$order_by = "user_name";
}
if(isset($_GET['order_method'])) {
	$order_method = $_GET['order_method'];
	$order_method = strip_tags(stripslashes($order_method));
	if($order_method != "asc" && $order_method != "desc"){
		echo"Wrong order method";
		die;
	}
}
else{
	$order_method = "asc";
}






/*- MySQL Tables -------------------------------------------------- */
$t_users 	 		= $mysqlPrefixSav . "users";
$t_users_profile 		= $mysqlPrefixSav . "users_profile";
$t_users_friends 		= $mysqlPrefixSav . "users_friends";
$t_users_friends_requests 	= $mysqlPrefixSav . "users_friends_requests";
$t_users_profile		= $mysqlPrefixSav . "users_profile";
$t_users_profile_photo 		= $mysqlPrefixSav . "users_profile_photo";
$t_users_status 		= $mysqlPrefixSav . "users_status";
$t_users_status_comments 	= $mysqlPrefixSav . "users_status_comments";
$t_users_status_comments_likes 	= $mysqlPrefixSav . "users_status_comments_likes";
$t_users_status_likes 		= $mysqlPrefixSav . "users_status_likes";


if($action == ""){
	echo"
	<h1>Check that all users have profile</h1>


	<!-- Feedback -->
	";
	if($ft != "" && $fm != ""){
		if($fm == "user_deleted"){
			$fm = "$l_user_deleted";
		}
		else{
			$fm = ucfirst($ft);
		}
		echo"<div class=\"$ft\"><p>$fm</p></div>";
	}
	echo"
	<!-- //Feedback -->



	<!-- Users list -->
	";
	$count_users = 0;

	$query = "SELECT user_id, user_name, user_gender, user_rank FROM $t_users ORDER BY user_last_online DESC";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_user_id, $get_user_name, $get_user_gender, $get_user_rank) = $row;

		// Profile
		$q = "SELECT profile_id FROM $t_users_profile WHERE profile_user_id='$get_user_id'";
		$r = mysqli_query($link, $q);
		$rowb = mysqli_fetch_row($r);
		list($get_profile_id) = $rowb;
		if($get_profile_id == ""){
			// Create profile
			
			mysqli_query($link, "INSERT INTO $t_users_profile
			(profile_id, profile_user_id) 
			VALUES 
			(NULL, '$get_user_id')")
			or die(mysqli_error($link));

			echo"<p>Created profile for $get_user_id, $get_user_name</p>\n";
		}
		
		$count_users++;

	}
	echo"
		<p>$count_users scanned.</p>
	<!-- //Users list -->
	";
}
?>