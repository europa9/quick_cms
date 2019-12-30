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
	// Variables
	if(isset($_GET['photo_id'])) {
		$photo_id = $_GET['photo_id'];
		$photo_id = strip_tags(stripslashes($photo_id));
	}
	else{
		$photo_id = "";
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

	// Get photo id
	$photo_id_mysql = quote_smart($link, $photo_id);
	$query = "SELECT photo_id, photo_user_id, photo_title, photo_destination FROM $t_users_profile_photo WHERE photo_id=$photo_id_mysql AND photo_user_id=$user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_photo_id, $get_photo_user_id, $get_photo_title, $get_photo_destination) = $row;

	if($get_photo_id == ""){
		$url = "photo.php?l=$l&ft=warning&fm=photo_not_found_in_database"; 
		if($process == "1"){
			header("Location: $url");
		}
		else{
			echo"<p><img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"Loading\" /></p>
			<meta http-equiv=\"refresh\" content=\"1;url=$url\">";
		}
		die;
	}

	if(!(file_exists("$root/_uploads/users/images/$get_user_id/$get_photo_destination"))){
		$url = "photo.php?l=$l&ft=warning&fm=photo_not_found"; 
		if($process == "1"){
			header("Location: $url");
		}
		else{
			echo"<p><img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"Loading\" /></p>
			<meta http-equiv=\"refresh\" content=\"1;url=$url\">";
		}
		die;
	}

	

	if($action == ""){
		echo"
		
		<h1>$l_photo</h1>


		<!-- You are here -->
			<div class=\"you_are_here\">
				<p>
				<b>$l_you_are_here:</b><br />
				<a href=\"$root/users/index.php?page=my_profile&amp;l=$l\">$l_my_profile</a>
				&gt; 
				<a href=\"$root/users/index.php?page=photo&amp;l=$l\">$l_photo</a>
				&gt; 
				<a href=\"$root/users/index.php?page=photo_edit&amp;photo_id=$photo_id&amp;l=$l\">$l_view_photo</a>
				</p>
			</div>
		<!-- //You are here -->


		<!-- Feedback -->
			";
			if($ft != "" && $fm != ""){
				if($fm == "photo_rotated"){
					$fm = "$l_photo_rotated";
				}
				elseif($fm == "photo_sat_as_profile_photo"){
					$fm = "$l_photo_sat_as_profile_photo";
				}
				else{
					$fm = ucfirst($fm);
				}
				echo"<div class=\"$ft\"><p>$fm</p></div>";
			}
			echo"
		<!-- //Feedback -->

		<!-- Menu -->
			<p>
			<a href=\"photo_upload.php?l=$l\" class=\"btn\">$l_upload_new_photo</a>
			<a href=\"photo_delete.php?photo_id=$get_photo_id&amp;process=1&amp;l=$l\" class=\"btn confirm\">$l_delete_this_photo</a>
			<a href=\"photo_rotate.php?photo_id=$get_photo_id&amp;rotate=90&amp;process=1&amp;l=$l&amp;refer=page=photo_editamp;photo_id=$get_photo_id\" class=\"btn\">$l_rotate</a>
			<a href=\"photo_use_as_profile_photo.php?photo_id=$get_photo_id&amp;process=1&amp;l=$l&amp;refer=page=photo_editamp;photo_id=$get_photo_id\" class=\"btn\">$l_use_as_profile_photo</a>
			</p>

			<script>
			\$(function() {
				\$('.confirm').click(function() {
					return window.confirm(\"$l_are_you_sure\");
				});
			});
			</script>
		<!-- //Menu -->


		<!-- View image -->
			<!-- Focus -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_title\"]').focus();
				});
				</script>
			<!-- //Focus -->
			<form method=\"POST\" action=\"photo_edit.php?action=do_edit&amp;photo_id=$get_photo_id&amp;l=$l&amp;process=1\" id=\"upload_cover_photo_form\" enctype=\"multipart/form-data\">
			<p>
			$l_title:<br />
			<input type=\"text\" name=\"inp_title\" value=\"$get_photo_title\" size=\"25\" /><br />
			</p>

			<p>
			$l_image:<br />
			<img src=\"$root/image.php?width=400&amp;image=/_uploads/users/images/$get_user_id/$get_photo_destination\" alt=\"$get_photo_destination\" />
			</p>

			<p>
			<input type=\"submit\" value=\"$l_save_changes\" class=\"btn\" />
			</p>
			</form>
		<!-- //View image -->	



		<!-- Go back -->
			<p><br />
			<a href=\"photo.php?l=$l\"><img src=\"$root/users/_gfx/go-previous.png\" alt=\"go-previous.png\" /></a>
			<a href=\"photo.php?l=$l\">$l_go_back</a>
			</p>
		<!-- //Go back -->	
		";

	} // action == ""
	elseif($action == "do_edit" && $process == "1"){
		
		$inp_title = $_POST['inp_title'];
		$inp_title = output_html($inp_title);
		$inp_title_mysql = quote_smart($link, $inp_title);

		$result = mysqli_query($link, "UPDATE $t_users_profile_photo SET photo_title=$inp_title_mysql WHERE photo_id='$get_photo_id'");

		$url = "photo_edit.php?photo_id=$get_photo_id&l=$l&ft=success&fm=changes_saved";
		header("Location: $url");
		exit;
	}
}
else{
	echo"
	<table>
	 <tr> 
	  <td style=\"padding-right: 6px;\">
		<p>
		<img src=\"$root/_gfx/loading_22.gif\" alt=\"Loading\" />
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