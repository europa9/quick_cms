<?php
/*- MySQL Tables -------------------------------------------------- */
$t_users 	 		= $mysqlPrefixSav . "users";
$t_users_profile 		= $mysqlPrefixSav . "users_profile";
$t_users_professional		= $mysqlPrefixSav . "users_professional";
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


$query = "SELECT professional_id, professional_user_id, professional_company, professional_company_location, professional_department, professional_work_email, professional_position, professional_position_abbr, professional_district FROM $t_users_professional WHERE professional_user_id=$get_user_id";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_professional_id, $get_professional_user_id, $get_professional_company, $get_professional_company_location, $get_professional_department, $get_professional_work_email, $get_professional_position, $get_professional_position_abbr, $get_professional_district) = $row;

if($get_user_id == ""){
	echo"<h1>Error</h1><p>Error with user id.</p>"; 
	die;
}
if($get_profile_id == ""){
	// Profile not found, create it
	mysqli_query($link, "INSERT INTO $t_users_profile 
	(profile_id, profile_user_id) 
	VALUES 
	(NULL, $get_user_id)")
	or die(mysqli_error($link)); 
}
if($get_professional_id == ""){
	// Create professional profile
	mysqli_query($link, "INSERT INTO $t_users_professional 
	(professional_id, professional_user_id) 
	VALUES 
	(NULL, $get_user_id)")
	or die(mysqli_error($link));
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

if($mode == "save"){

		$inp_company = $_POST['inp_company'];
		$inp_company = output_html($inp_company);
		$inp_company_mysql = quote_smart($link, $inp_company);

		$inp_company_location = $_POST['inp_company_location'];
		$inp_company_location = output_html($inp_company_location);
		$inp_company_location_mysql = quote_smart($link, $inp_company_location);

		$inp_department = $_POST['inp_department'];
		$inp_department = output_html($inp_department);
		$inp_department_mysql = quote_smart($link, $inp_department);

		$inp_work_email = $_POST['inp_work_email'];
		$inp_work_email = output_html($inp_work_email);
		$inp_work_email_mysql = quote_smart($link, $inp_work_email);

		$inp_position = $_POST['inp_position'];
		$inp_position = output_html($inp_position);
		$inp_position_mysql = quote_smart($link, $inp_position);


		$inp_position_abbr = $_POST['inp_position_abbr'];
		$inp_position_abbr = output_html($inp_position_abbr);
		$inp_position_abbr_mysql = quote_smart($link, $inp_position_abbr);


		$inp_district = $_POST['inp_district'];
		$inp_district = output_html($inp_district);
		$inp_district_mysql = quote_smart($link, $inp_district);



		$result = mysqli_query($link, "UPDATE $t_users_professional SET 
					professional_company=$inp_company_mysql, 
					professional_company_location=$inp_company_location_mysql, 
					professional_department=$inp_department_mysql, 
					professional_work_email=$inp_work_email_mysql, 
					professional_position=$inp_position_mysql,
					professional_position_abbr=$inp_position_abbr_mysql,
 					professional_district=$inp_district_mysql 
					WHERE professional_user_id=$user_id_mysql");

				// Send success
				$fm = "changes_saved";
				$ft = "success";
				
				// Get new information
				$query = "SELECT professional_id, professional_user_id, professional_company, professional_company_location, professional_department, professional_work_email, professional_position, professional_position_abbr, professional_district FROM $t_users_professional WHERE professional_user_id=$get_user_id";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_professional_id, $get_professional_user_id, $get_professional_company, $get_professional_company_location, $get_professional_department, $get_professional_work_email, $get_professional_position, $get_professional_position_abbr, $get_professional_district) = $row;


}
echo"
<h1>$l_edit $get_user_name</h1>

<!-- Menu -->
	";
	include("_inc/users/users_edit_user_menu.php");
	echo"
<!-- //Menu -->

<!-- Edit -->
	<form method=\"POST\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;mode=save&amp;user_id=$user_id&amp;l=$l&amp;editor_language=$editor_language\" enctype=\"multipart/form-data\" name=\"nameform\">
	<!-- Feedback -->
				";
				if($ft != "" && $fm != ""){
					if($fm == "changes_saved"){
						$fm = "$l_changes_saved";
					}
					else{
						$fm = "$ft";
					}
					echo"<div class=\"$ft\"><p>$fm</p></div>";
				}
				echo"
	<!-- //Feedback -->

	<!-- Focus -->
		<script>
		\$(document).ready(function(){
			\$('[name=\"inp_company\"]').focus();
		});
		</script>
	<!-- //Focus -->


		<p>
		Company:<br />
		<input type=\"text\" name=\"inp_company\" size=\"25\" value=\"$get_professional_company\" /><br />
		</p>

		<p>
		Company location:<br />
		<input type=\"text\" name=\"inp_company_location\" size=\"25\" value=\"$get_professional_company_location\" /><br />
		</p>

		<p>
		Department<br />
		<input type=\"text\" name=\"inp_department\" size=\"25\" value=\"$get_professional_department\" /><br />
		</p>

		<p>
		Work email:<br />
		<input type=\"text\" name=\"inp_work_email\" size=\"25\" value=\"$get_professional_work_email\" /><br />
		</p>

		<p>
		Position:<br />
		<input type=\"text\" name=\"inp_position\" size=\"25\" value=\"$get_professional_position\" /><br />
		</p>

		<p>
		Position abbreviation:<br />
		<input type=\"text\" name=\"inp_position_abbr\" size=\"25\" value=\"$get_professional_position_abbr\" /><br />
		</p>

		<p>
		District:<br />
		<input type=\"text\" name=\"inp_district\" size=\"25\" value=\"$get_professional_district\" /><br />
		</p>

			<p>
			<input type=\"submit\" value=\"$l_save\" />
			</p>

			</form>

";

?>