<?php
/**
*
* File: _admin/_inc/users/default.php
* Version 1.0
* Date: 18:32 30.10.2017
* Copyright (c) 2008-2012 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
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
	
echo"
<h1>$l_users</h1>


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
	<p>
	<a href=\"index.php?open=$open&amp;page=users_new&amp;editor_language=$editor_language\" class=\"btn\">$l_new_user</a>
	</p>

		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span>$l_user_name</span>
		   </th>
		   <th scope=\"col\">
			<span>$l_rank</span>
		   </th>
		   <th scope=\"col\">
			<span>$l_actions</span>
		   </th>
		  </tr>
		</thead>
		<tbody>


	";

	$query = "SELECT user_id, user_name, user_gender, user_rank FROM $t_users ORDER BY user_last_online DESC";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_user_id, $get_user_name, $get_user_gender, $get_user_rank) = $row;

		// Profile
		$q = "SELECT profile_id, profile_first_name, profile_middle_name, profile_last_name, profile_city, profile_country, profile_work, profile_university, profile_high_school, profile_relationship FROM $t_users_profile WHERE profile_user_id='$get_user_id'";
		$r = mysqli_query($link, $q);
		$rowb = mysqli_fetch_row($r);
		list($get_profile_id, $get_profile_first_name,  $get_profile_middle_name,  $get_profile_last_name,  $get_profile_city, $get_profile_country, $get_profile_work, $get_profile_university, $get_profile_high_school, $get_profile_relationship) = $rowb;
	
		// Photo
		$q = "SELECT photo_id, photo_destination FROM $t_users_profile_photo WHERE photo_user_id='$get_user_id' AND photo_profile_image='1'";
		$r = mysqli_query($link, $q);
		$rowb = mysqli_fetch_row($r);
		list($get_photo_id, $get_photo_destination) = $rowb;
	
		// Style
		if(isset($style) && $style == ""){
			$style = "odd";
		}
		else{
			$style = "";
		}
	
		echo"
		 <tr>
		  <td class=\"$style\">
			";
			if($get_photo_id != ""){
				$thumb = str_replace("_org", "_thumb", $get_photo_destination);
				echo"
				<a href=\"index.php?open=$open&amp;page=users_edit_user&amp;user_id=$get_user_id&amp;l=$l&amp;editor_language=$editor_language\"><img src=\"../image.php?width=35&amp;height=35&amp;cropratio=1:1&amp;image=/_uploads/users/images/$get_user_id/$thumb\" alt=\"$get_photo_destination\" class=\"image_rounded\" style=\"float: left;margin-right: 5px;\" /></a>
				";
			}
			else{
				echo"
				<a href=\"index.php?open=$open&amp;page=users_edit_user&amp;user_id=$get_user_id&amp;l=$l&amp;editor_language=$editor_language\"><img src=\"_design/gfx/avatar_blank_35.png\" alt=\"Avatar\" class=\"image_rounded\" style=\"float: left;margin-right: 5px;\" /></a>
				";
			}
			echo"
			<span>$get_user_name<br />
			$get_profile_first_name  $get_profile_middle_name  $get_profile_last_name</span>
		  </td>
		  <td class=\"$style\">
			<span>$get_user_rank</span>
		  </td>
		  <td class=\"$style\">
			<span><a href=\"?open=$open&amp;page=users_edit_user&amp;user_id=$get_user_id&amp;l=$l&amp;editor_language=$editor_language\">$l_edit</a>
			| <a href=\"?open=$open&amp;page=users_delete_user&amp;user_id=$get_user_id&amp;l=$l&amp;process=1&amp;editor_language=$editor_language\" class=\"confirm\">$l_delete</a></span>
		  </td>
		 </tr>
		";

	}
	echo"
	
		 </tbody>
		</table>

	<script>
	\$(function() {
		\$('.confirm').click(function() {
			return window.confirm(\"$l_are_you_sure\");
		});
	});
	</script>
<!-- //Users list -->
	";
?>