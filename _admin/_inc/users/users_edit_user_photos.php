<?php
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


/*- Access check -------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Language ------------------------------------------------------ */
include("_translations/admin/$l/users/t_users_edit_user.php");


/*- Varialbes  ---------------------------------------------------- */
if(isset($_GET['user_id'])) {
	$user_id = $_GET['user_id'];
	$user_id = strip_tags(stripslashes($user_id));
}
else{
	$user_id = "";
	echo"
	<h1>Error</h1>

	<p>$l_user_profile_not_found</p>
	";
	die;
}
if(isset($_GET['mode'])) {
	$mode = $_GET['mode'];
	$mode = strip_tags(stripslashes($mode));
}
else{
	$mode = "";
}
if(isset($_GET['refer'])) {
	$refer = $_GET['refer'];
	$refer = strip_tags(stripslashes($refer));
}
else{
	$refer = "";
}

// Get user
$user_id_mysql = quote_smart($link, $user_id);

$query = "SELECT user_id, user_email, user_name, user_alias, user_password, user_salt, user_security, user_language, user_gender, user_measurement, user_dob, user_date_format, user_registered, user_last_online, user_rank, user_points, user_likes, user_dislikes, user_status, user_login_tries, user_last_ip, user_synchronized, user_verified_by_moderator FROM $t_users WHERE user_id=$user_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_user_id, $get_user_email, $get_user_name, $get_user_alias, $get_user_password, $get_user_salt, $get_user_security, $get_user_language, $get_user_gender, $get_user_measurement, $get_user_dob, $get_user_date_format, $get_user_registered, $get_user_last_online, $get_user_rank, $get_user_points, $get_user_likes, $get_user_dislikes, $get_user_status, $get_user_login_tries, $get_user_last_ip, $get_user_synchronized, $get_user_verified_by_moderator) = $row;

$query = "SELECT profile_id, profile_user_id, profile_first_name, profile_middle_name, profile_last_name, profile_address_line_a, profile_address_line_b, profile_zip, profile_city, profile_country, profile_phone, profile_work, profile_university, profile_high_school, profile_languages, profile_website, profile_interested_in, profile_relationship, profile_about, profile_newsletter FROM $t_users_profile WHERE profile_user_id=$user_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_profile_id, $get_profile_user_id, $get_profile_first_name, $get_profile_middle_name, $get_profile_last_name, $get_profile_address_line_a, $get_profile_address_line_b, $get_profile_zip, $get_profile_city, $get_profile_country, $get_profile_phone, $get_profile_work, $get_profile_university, $get_profile_high_school, $get_profile_languages, $get_profile_website, $get_profile_interested_in, $get_profile_relationship, $get_profile_about, $get_profile_newsletter) = $row;
	
if($get_user_id == ""){
	echo"<h1>Error</h1><p>Error with user id.</p>"; 
	die;
}

// Can I edit?
$my_user_id = $_SESSION['admin_user_id'];
$my_user_id = output_html($my_user_id);
$my_user_id_mysql = quote_smart($link, $my_user_id);

$my_security  = $_SESSION['admin_security'];
$my_security = output_html($my_security);
$my_security_mysql = quote_smart($link, $my_security);
$query = "SELECT user_id, user_name, user_language, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql AND user_security=$my_security_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_my_user_id, $get_my_user_name, $get_my_user_language, $get_my_user_rank) = $row;


if($get_my_user_rank != "moderator" && $get_my_user_rank != "admin"){
	echo"
	<h1>Server error 403</h1>
	<p>Your rank is $get_my_user_rank. You can not edit.</p>
	";
	die;
}

			if($mode == "delete_photo"){
				// Variables
				if(isset($_GET['photo_id'])) {
					$photo_id = $_GET['photo_id'];
					$photo_id = strip_tags(stripslashes($photo_id));
				}
				else{
					$photo_id = "";
				}
				if(isset($_GET['prev_photo_id'])) {
					$prev_photo_id = $_GET['prev_photo_id'];
					$prev_photo_id = strip_tags(stripslashes($prev_photo_id));
				}
				else{
					$prev_photo_id = "";
				}

				// Get photo id
				$photo_id_mysql = quote_smart($link, $photo_id);
				$query = "SELECT photo_id, photo_user_id, photo_profile_image, photo_title, photo_destination, photo_thumb_40, photo_thumb_50, photo_thumb_60, photo_thumb_200, photo_uploaded, photo_uploaded_ip, photo_views, photo_views_ip_block, photo_likes, photo_comments, photo_x_offset, photo_y_offset, photo_text FROM $t_users_profile_photo WHERE photo_id=$photo_id_mysql AND photo_user_id=$user_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_photo_id, $get_photo_user_id, $get_photo_profile_image, $get_photo_title, $get_photo_destination, $get_photo_thumb_40, $get_photo_thumb_50, $get_photo_thumb_60, $get_photo_thumb_200, $get_photo_uploaded, $get_photo_uploaded_ip, $get_photo_views, $get_photo_views_ip_block, $get_photo_likes, $get_photo_comments, $get_photo_x_offset, $get_photo_y_offset, $get_photo_text) = $row;

				if($get_photo_id == ""){
					// Send warning
					$fm = "photo_not_found";
					$ft = "warning";
				}
				else{


					if(!(file_exists("../_uploads/users/images/$get_user_id/$get_photo_destination"))){
						// Send warning
						$fm = "photo_not_found";
						$ft = "warning";
					}
					else{
	
						// Delete from MySQL
						$result = mysqli_query($link, "DELETE FROM $t_users_profile_photo WHERE photo_id='$get_photo_id'");

						// Delete photo
						unlink("../_uploads/users/images/$get_user_id/$get_photo_destination");

						// Delete thumb
						if(file_exists("../_uploads/users/images/$get_user_id/$get_photo_thumb_40") && $get_photo_thumb_40 != ""){
							unlink("../_uploads/users/images/$get_user_id/$get_photo_thumb_40");
						}
						if(file_exists("../_uploads/users/images/$get_user_id/$get_photo_thumb_50") && $get_photo_thumb_50 != ""){
							unlink("../_uploads/users/images/$get_user_id/$get_photo_thumb_50");
						}
						if(file_exists("../_uploads/users/images/$get_user_id/$get_photo_thumb_60") && $get_photo_thumb_60 != ""){
							unlink("../_uploads/users/images/$get_user_id/$get_photo_thumb_60");
						}
						if(file_exists("../_uploads/users/images/$get_user_id/$get_photo_thumb_200") && $get_photo_thumb_200 != ""){
							unlink("../_uploads/users/images/$get_user_id/$get_photo_thumb_200");
						}

						// Check if this was my profile photo
						if($get_photo_profile_image == "1"){
							// get a new photo to use as profile photo
							$query = "SELECT photo_id, photo_user_id, photo_profile_image, photo_destination FROM $t_users_profile_photo WHERE photo_user_id=$user_id_mysql";
							$result = mysqli_query($link, $query);
							$row = mysqli_fetch_row($result);
							list($get_photo_id, $get_photo_user_id, $get_users_profile_photo, $get_photo_destination) = $row;
		
							if($get_photo_id != ""){
								$result = mysqli_query($link, "UPDATE $t_users_profile_photo SET photo_profile_image='1' WHERE photo_id=$get_photo_id");
							}
						}


						// Send success
						$fm = "photo_deleted";
						$ft = "success";
					}
				}

			}
			echo"
			<h1>$l_photos $get_user_name</h1>

	<!-- Menu -->
		";
		include("_inc/users/users_edit_user_menu.php");
		echo"
	<!-- //Menu -->


			<!-- Feedback -->
				";
				if($ft != "" && $fm != ""){
					if($fm == "photo_not_found"){
						$fm = "$l_photo_not_found";
					}
					elseif($fm == "photo_deleted"){
						$fm = "$l_photo_deleted";
					}
					else{
						$fm = "$ft";
					}
					echo"<div class=\"$ft\"><p>$fm</p></div>";
				}
				echo"
			<!-- //Feedback -->

			<!-- Display photos -->
				<table>
				";
				$prev_photo_id = "";
				$query = "SELECT photo_id, photo_user_id, photo_profile_image, photo_title, photo_destination, photo_thumb_40, photo_thumb_50, photo_thumb_60, photo_thumb_200, photo_uploaded, photo_uploaded_ip, photo_views, photo_views_ip_block, photo_likes, photo_comments, photo_x_offset, photo_y_offset, photo_text FROM $t_users_profile_photo WHERE photo_user_id='$get_user_id'";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_photo_id, $get_photo_user_id, $get_photo_profile_image, $get_photo_title, $get_photo_destination, $get_photo_thumb_40, $get_photo_thumb_50, $get_photo_thumb_60, $get_photo_thumb_200, $get_photo_uploaded, $get_photo_uploaded_ip, $get_photo_views, $get_photo_views_ip_block, $get_photo_likes, $get_photo_comments, $get_photo_x_offset, $get_photo_y_offset, $get_photo_text) = $row;
					

					echo"
					 <tr>
					  <td style=\"padding: 0px 6px 0px 0px;vertical-align:top;\">
						<p>
						<a id=\"photo$get_photo_id\"></a>
						<a href=\"../_uploads/users/images/$get_user_id/$get_photo_destination\"><img src=\"../_uploads/users/images/$get_user_id/$get_photo_thumb_200\" alt=\"$get_photo_destination\" /></a>
						</p>
					  </td>
					  <td style=\"padding: 0px 0px 0px 0px;vertical-align:top;\">
						<p>
						$l_uploaded: $get_photo_uploaded<br />
						$l_ip: $get_photo_uploaded_ip<br />
						$l_views: $get_photo_views<br />
						$l_likes: $get_photo_likes<br />
						$l_comments: $get_photo_comments<br />

						<a href=\"index.php?open=$open&amp;page=$page&amp;action=photos&amp;mode=delete_photo&amp;photo_id=$get_photo_id&amp;user_id=$user_id&amp;l=$l#photo$prev_photo_id\">$l_delete_this_photo</a>
						</p>
					  </td>
					 </tr>
					";

					$prev_photo_id = $get_photo_id;
				}
				echo"
				</table>
			<!-- //Display photos -->

			";

?>