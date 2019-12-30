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
include("$root/_admin/_translations/site/$l/users/ts_photo_edit.php");

/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_users";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");



/*- Content --------------------------------------------------------------------------- */



if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	// Variables
	if(isset($_GET['cover_photo_id'])) {
		$cover_photo_id = $_GET['cover_photo_id'];
		$cover_photo_id = strip_tags(stripslashes($cover_photo_id));
	}
	else{
		$cover_photo_id = "";
	}
	if(isset($_GET['rotate'])) {
		$rotate = $_GET['rotate'];
		$rotate = strip_tags(stripslashes($rotate));
	}
	else{
		$rotate = "";
	}

	// Get user
	$user_id = $_SESSION['user_id'];
	$user_id_mysql = quote_smart($link, $user_id);
	$security = $_SESSION['security'];
	$security_mysql = quote_smart($link, $security);

	$query = "SELECT user_id, user_name, user_language, user_rank FROM $t_users WHERE user_id=$user_id_mysql AND user_security=$security_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_user_id, $get_user_name, $get_user_language, $get_user_rank) = $row;

	$query = "SELECT profile_id, profile_user_id, profile_first_name, profile_middle_name, profile_last_name, profile_address_line_a, profile_address_line_b, profile_zip, profile_city, profile_country, profile_phone, profile_work, profile_university, profile_high_school, profile_languages, profile_website, profile_interested_in, profile_relationship, profile_about, profile_newsletter FROM $t_users_profile WHERE profile_user_id=$user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_profile_id, $get_profile_user_id, $get_profile_first_name, $get_profile_middle_name, $get_profile_last_name, $get_profile_address_line_a, $get_profile_address_line_b, $get_profile_zip, $get_profile_city, $get_profile_country, $get_profile_phone, $get_profile_work, $get_profile_university, $get_profile_high_school, $get_profile_languages, $get_profile_website, $get_profile_interested_in, $get_profile_relationship, $get_profile_about, $get_profile_newsletter) = $row;

	if($get_user_id == ""){
		echo"<h1>Error</h1><p>Error with user id.</p>"; 
		$_SESSION = array();
		session_destroy();
		die;
	}

	// Get cover photo id
	$cover_photo_id_mysql = quote_smart($link, $cover_photo_id);
	$query = "SELECT cover_photo_id, cover_photo_user_id, cover_photo_is_current, cover_photo_destination FROM $t_users_cover_photos WHERE cover_photo_id=$cover_photo_id_mysql AND cover_photo_user_id=$user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_cover_photo_id, $get_cover_photo_user_id, $get_cover_photo_is_current, $get_cover_photo_destination) = $row;

	if($get_cover_photo_id == ""){
		echo"
		<h1>Error</h1>
		<p>$l_photo_not_found_in_database</p>
		";
		die;
	}

	if(!(file_exists("$root/_uploads/users/images/$get_user_id/cover_photos/$get_cover_photo_destination"))){
		echo"
		<h1>Error</h1>
		<p>$l_photo_not_found</p>
		";
		die;
	}

	if($action == ""){
		echo"
		
		<h1>$l_cover_photo</h1>



		<!-- You are here -->
			<div class=\"you_are_here\">
				<p>
				<b>$l_you_are_here:</b><br />
				<a href=\"my_profile.php?l=$l\">$l_my_profile</a>
				&gt; 
				<a href=\"cover_photo.php?l=$l\">$l_cover_photo</a>
				&gt; 
				<a href=\"photo_upload_edit.php?cover_photo_id=$cover_photo_id&amp;l=$l\">$l_view_photo</a>
				</p>
			</div>
		<!-- //You are here -->


		<!-- Feedback -->
			";
			if($ft != "" && $fm != ""){
				if($fm == "photo_not_found_in_database"){
					$fm = "$l_photo_not_found_in_database";
				}
				elseif($fm == "photo_not_found"){
					$fm = "$l_photo_not_found";
				}
				elseif($fm == "photo_deleted"){
					$fm = "$l_photo_deleted";
				}
				elseif($fm == "photo_rotated"){
					$fm = "$l_photo_rotated";
				}
				elseif($fm == "photo_uploaded"){
					$fm = "$l_photo_uploaded";
				}
				elseif($fm == "photo_sat_as_profile_photo"){
					$fm = "$l_photo_sat_as_profile_photo";
				}
				elseif($fm == "unknown_file_format"){
					$fm = "$l_unknown_file_format";
				}
				elseif($fm == "photo_could_not_be_uploaded_please_check_file_size"){
					$fm = "$l_photo_could_not_be_uploaded_please_check_file_size";
				}
				elseif($fm == "cover_photo_is_now_current"){
					$fm = "$l_cover_photo_is_now_current";
				}
				else{
					$fm = "$ft";
				}
				echo"<div class=\"$ft\"><p>$fm</p></div>";
			}
			echo"
		<!-- //Feedback -->




		<!-- Menu -->
			<div style=\"float: left;margin-left: 3px;margin-top:16px;\">

				<p>
				<a href=\"cover_photo_delete.php?cover_photo_id=$get_cover_photo_id&amp;process=1&amp;l=$l\" class=\"btn\">$l_delete_this_photo</a>
				<a href=\"cover_photo_rotate.php?cover_photo_id=$get_cover_photo_id&amp;rotate=90&amp;process=1&amp;l=$l&amp;refer=page=cover_photo_editamp;cover_photo_id=$get_cover_photo_id\" class=\"btn\">$l_rotate</a>
				<a href=\"cover_photo_set_current.php?cover_photo_id=$get_cover_photo_id&amp;process=1&amp;l=$l&amp;refer=page=cover_photo_editamp;cover_photo_id=$get_cover_photo_id\" class=\"btn\">$l_set_as_cover_photo</a>
				</p>

			<script>
			\$(function() {
				\$('.confirm').click(function() {
					return window.confirm(\"$l_are_you_sure\");
				});
			});
			</script>
			</div>
		<!-- //Menu -->


		<!-- View image -->
			<div class=\"clear\"></div><p>
			<img src=\"$root/image.php?width=600&amp;image=/_uploads/users/images/$get_user_id/cover_photos/$get_cover_photo_destination\" alt=\"$get_cover_photo_destination\" />
			</p>	
		<!-- //View image -->	



		<!-- Go back -->
			<p><br />
			<a href=\"cover_photo.php?l=$l\"><img src=\"$root/users/_gfx/go-previous.png\" alt=\"go-previous.png\" /></a>
			<a href=\"cover_photo.php?l=$l\">$l_go_back</a>
			</p>
		<!-- //Go back -->	
		";

	} // action == ""
}
else{
	echo"
	<table>
	 <tr> 
	  <td style=\"padding-right: 6px;\">
		<p>
		<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"Loading\" />
		</p>
	  </td>
	  <td>
		<h1>Loading</h1>
	  </td>
	 </tr>
	</table>
		
	<meta http-equiv=\"refresh\" content=\"1;url=index.php\">
	";
}

/*- Footer ---------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");

?>