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



echo"
<h1>$l_users</h1>

<!-- Feedback -->
	";
	if($ft != "" && $fm != ""){
		if($fm == "you_are_now_logged_out_see_you"){
			$fm = "$l_you_are_now_logged_out_see_you";
		}
		else{
			$fm = ucfirst($fm);
		}
		echo"<div class=\"$ft\"><p>$fm</p></div>";
	}
	echo"
<!-- //Feedback -->
";

$x = 0;
$query = "SELECT user_id, user_name,  user_alias, user_rank FROM $t_users ORDER BY user_last_online DESC";
$result = mysqli_query($link, $query);
while($row = mysqli_fetch_row($result)) {
	list($get_user_id, $get_user_name, $get_user_alias, $get_user_rank) = $row;

	// Profile
	$query_profile = "SELECT profile_id, profile_user_id, profile_first_name, profile_middle_name, profile_last_name, profile_address_line_a, profile_address_line_b, profile_zip, profile_city, profile_country, profile_phone, profile_work, profile_university, profile_high_school, profile_languages, profile_website, profile_interested_in, profile_relationship, profile_about, profile_newsletter FROM $t_users_profile WHERE profile_user_id='$get_user_id'";
	$result_profile = mysqli_query($link, $query_profile);
	$row_profile = mysqli_fetch_row($result_profile);
	list($get_profile_id, $get_profile_user_id, $get_profile_first_name, $get_profile_middle_name, $get_profile_last_name, $get_profile_address_line_a, $get_profile_address_line_b, $get_profile_zip, $get_profile_city, $get_profile_country, $get_profile_phone, $get_profile_work, $get_profile_university, $get_profile_high_school, $get_profile_languages, $get_profile_website, $get_profile_interested_in, $get_profile_relationship, $get_profile_about, $get_profile_newsletter) = $row_profile;

	// Photo
	$q = "SELECT photo_id, photo_destination FROM $t_users_profile_photo WHERE photo_user_id='$get_user_id' AND photo_profile_image='1'";
	$r = mysqli_query($link, $q);
	$rowb = mysqli_fetch_row($r);
	list($get_photo_id, $get_photo_destination) = $rowb;
	



	// Thumb
	$inp_new_x = 175;
	$inp_new_y = 175;
	$thumb = "user_" . $get_user_id . "-" . $inp_new_x . "x" . $inp_new_y . "png";

	if($get_photo_id != "" && !(file_exists("$root/_cache/$thumb")) && file_exists("$root/_uploads/users/images/$get_user_id/$get_photo_destination") && $get_photo_destination != ""){
		resize_crop_image($inp_new_x, $inp_new_y, "$root/_uploads/users/images/$get_user_id/$get_photo_destination", "$root/_cache/$thumb");
	}



	if($x == 0){
		echo"
		<div class=\"clear\"></div>
		<div class=\"left_center_center_right_left\">
		";
	}
	elseif($x == 1){
		echo"
		<div class=\"left_center_center_left_right_center\">
		";
	}
	elseif($x == 2){
		echo"
		<div class=\"left_center_center_right_right_center\">
		";
	}
	elseif($x == 3){
		echo"
		<div class=\"left_center_center_right_right\">
		";
	}

	
	echo"
		<p style=\"padding:0;margin: 8px 0px 8px 0px;\">
		";
		if($get_photo_id != ""){
			if(!(file_exists("$root/_uploads/users/images/$get_user_id/$get_photo_destination"))){
				$res = mysqli_query($link, "DELETE FROM $t_users_profile_photo WHERE photo_user_id='$get_user_id' AND photo_profile_image='1'");
			}
			echo"
			<a href=\"view_profile.php?user_id=$get_user_id&amp;l=$l\"><img src=\"$root/_cache/$thumb\" alt=\"$get_photo_destination\" class=\"image_rounded\" width=\"$inp_new_x\" height=\"$inp_new_y\" /></a>
			";
			
		}
		else{
			echo"
			<a href=\"view_profile.php?user_id=$get_user_id&amp;l=$l\"><img src=\"$root/users/_gfx/avatar_blank_175.png\" style=\"position: relative; top: 0; left: 0;\" alt=\"Avatar\" class=\"image_rounded\" /></a>
			";
		}
		echo"
		</p>
		<p style=\"padding:0;margin: 8px 0px 4px 0px;\">
		<a href=\"view_profile.php?user_id=$get_user_id&amp;l=$l\" style=\"font-weight:bold;color:#000;\">$get_user_alias</a>
		
		";
		if($get_user_name != "$get_user_alias"){
			echo"<span class=\"dark_grey\">@$get_user_name</span>";
		}
		echo"
		</p>	
		<p style=\"padding:0;margin: 2px 0px 5px 0px;\" class=\"dark_grey\">
		";
		if($get_profile_city != ""){
			echo"
			$get_profile_city";  if($get_profile_country != ""){ echo", $get_profile_country"; } echo"
			";
		}
		echo"
		</p>
	</div>
	";
	// Increment
	$x++;

	// Reset
	if($x == 4){
		$x = 0;
	}





			
}


/*- Footer ---------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");

?>