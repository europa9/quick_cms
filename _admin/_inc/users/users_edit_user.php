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

	if($mode == "save"){
		$ft = "";
		$fm = "";

		$inp_user_email = $_POST['inp_user_email'];
		$inp_user_email = output_html($inp_user_email);
		$inp_user_email = strtolower($inp_user_email);
		$inp_user_email_mysql = quote_smart($link, $inp_user_email);

		if($inp_user_email != "$get_user_email"){
			// Check if new email is taken
			
			$query = "SELECT user_id, user_email, user_name FROM $t_users WHERE user_email=$inp_user_email_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($check_user_id, $check_user_email, $check_user_name) = $row;

			if($check_user_id == ""){
				// Update email
				$result = mysqli_query($link, "UPDATE $t_users SET user_email=$inp_user_email_mysql WHERE user_id=$user_id_mysql");
				$fm = "email_address_updated";
				$ft = "success";
			}
			else{
				$fm = "email_alreaddy_in_use";
				$ft = "warning";
			}

		}
			
		$inp_user_name = $_POST['inp_user_name'];
		$inp_user_name = output_html($inp_user_name);
		// $inp_user_name = ucfirst($inp_user_name);
		$inp_user_name_mysql = quote_smart($link, $inp_user_name);

		if($inp_user_name != "$get_user_name"){
			// Check if new email is taken
			
			$query = "SELECT user_id, user_email, user_name FROM $t_users WHERE user_name=$inp_user_name_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($check_user_id, $check_user_email, $check_user_name) = $row;
			if($check_user_id == ""){
				// Update email
				$result = mysqli_query($link, "UPDATE $t_users SET user_name=$inp_user_name_mysql WHERE user_id=$user_id_mysql");
				$fm = "user_name_updated";
				$ft = "success";
			}
			else{
				if($check_user_id != "$user_id"){
					$fm = "user_name_already_in_use";
					$ft = "warning";
				}
			}
		
		}

		$inp_user_language = $_POST['inp_user_language'];
		$inp_user_language = output_html($inp_user_language);
		$inp_user_language_mysql = quote_smart($link, $inp_user_language);

		$inp_user_gender = $_POST['inp_user_gender'];
		$inp_user_gender = output_html($inp_user_gender);
		$inp_user_gender_mysql = quote_smart($link, $inp_user_gender);

		$inp_user_dob_day = $_POST['inp_user_dob_day'];
		$day_len = strlen($inp_user_dob_day);

		$inp_user_dob_month = $_POST['inp_user_dob_month'];
		$month_len = strlen($inp_user_dob_month);

		$inp_user_dob_year = $_POST['inp_user_dob_year'];
		$year_len = strlen($inp_user_dob_year);

		$inp_user_dob = $inp_user_dob_year . "-" . $inp_user_dob_month . "-" . $inp_user_dob_day;
		$inp_user_dob = output_html($inp_user_dob);
		$inp_user_dob_mysql = quote_smart($link, $inp_user_dob);
		if($inp_user_dob != "--"){
			$result = mysqli_query($link, "UPDATE $t_users SET user_dob=$inp_user_dob_mysql WHERE user_id=$user_id_mysql");
		}

		$inp_user_measurement = $_POST['inp_user_measurement'];
		$inp_user_measurement = output_html($inp_user_measurement);
		$inp_user_measurement_mysql = quote_smart($link, $inp_user_measurement);

		$inp_user_rank = $_POST['inp_user_rank'];
		$inp_user_rank = output_html($inp_user_rank);
		$inp_user_rank_mysql = quote_smart($link, $inp_user_rank);

		$inp_user_points = $_POST['inp_user_points'];
		$inp_user_points = output_html($inp_user_points);
		$inp_user_points_mysql = quote_smart($link, $inp_user_points);

		$inp_user_likes = $_POST['inp_user_likes'];
		$inp_user_likes = output_html($inp_user_likes);
		$inp_user_likes_mysql = quote_smart($link, $inp_user_likes);

		$inp_user_dislikes = $_POST['inp_user_dislikes'];
		$inp_user_dislikes = output_html($inp_user_dislikes);
		$inp_user_dislikes_mysql = quote_smart($link, $inp_user_dislikes);

		$inp_user_status = $_POST['inp_user_status'];
		$inp_user_status = output_html($inp_user_status);
		$inp_user_status_mysql = quote_smart($link, $inp_user_status);

		$inp_user_verified_by_moderator = $_POST['inp_user_verified_by_moderator'];
		$inp_user_verified_by_moderator = output_html($inp_user_verified_by_moderator);
		$inp_user_verified_by_moderator_mysql = quote_smart($link, $inp_user_verified_by_moderator);



		$result = mysqli_query($link, "UPDATE $t_users SET user_language=$inp_user_language_mysql, user_gender=$inp_user_gender_mysql, user_measurement=$inp_user_measurement_mysql, user_rank=$inp_user_rank_mysql, user_points=$inp_user_points_mysql, user_likes=$inp_user_likes_mysql, user_dislikes=$inp_user_dislikes_mysql, user_status=$inp_user_status_mysql, user_verified_by_moderator=$inp_user_verified_by_moderator_mysql WHERE user_id=$user_id_mysql");
		
		if($ft == "" OR $ft == "success"){
			if($fm == ""){
				$fm = "changes_saved";
				$ft = "success";
			}
		}

		// get new information
		$query = "SELECT user_id, user_email, user_name, user_alias, user_password, user_salt, user_security, user_language, user_gender, user_measurement, user_dob, user_date_format, user_registered, user_last_online, user_rank, user_points, user_likes, user_dislikes, user_status, user_login_tries, user_last_ip, user_verified_by_moderator FROM $t_users WHERE user_id=$user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_user_id, $get_user_email, $get_user_name, $get_user_alias, $get_user_password, $get_user_salt, $get_user_security, $get_user_language, $get_user_gender, $get_user_measurement, $get_user_dob, $get_user_date_format, $get_user_registered, $get_user_last_online, $get_user_rank, $get_user_points, $get_user_likes, $get_user_dislikes, $get_user_status, $get_user_login_tries, $get_user_last_ip, $get_user_verified_by_moderator) = $row;

	}
	echo"
	<h1>$l_edit_user $get_user_name</h1>

	<!-- Menu -->
		";
		include("_inc/users/users_edit_user_menu.php");
		echo"
	<!-- //Menu -->

	<form method=\"POST\" action=\"index.php?open=$open&amp;page=users_edit_user&amp;action=&amp;mode=save&amp;user_id=$user_id&amp;l=$l&amp;editor_language=$editor_language\" enctype=\"multipart/form-data\" name=\"nameform\">

	<!-- Feedback -->
		";
		if($ft != "" && $fm != ""){
			if($fm == "email_alreaddy_in_use"){
				$fm = "$l_email_alreaddy_in_use";
			}
			elseif($fm == "user_name_updated"){
				$fm = "$l_user_name_updated";
			}
			elseif($fm == "user_name_alreaddy_in_use"){
				$fm = "$l_user_name_alreaddy_in_use";
			}
			elseif($fm == "email_address_updated"){
				$fm = "$l_email_address_updated";
			}
			elseif($fm == "changes_saved"){
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
			\$('[name=\"inp_user_email\"]').focus();
		});
		</script>
	<!-- //Focus -->


	<p>
	$l_email_address:<br />
	<input type=\"text\" name=\"inp_user_email\" size=\"78\" value=\"$get_user_email\" /><br />
	</p>

	<p>
	$l_user_name:<br />
	<input type=\"text\" name=\"inp_user_name\" size=\"78\" value=\"$get_user_name\" /><br />
	</p>
	<p>
	$l_language:<br />
	<select name=\"inp_user_language\">";


	$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;

		echo"			";
		echo"<option value=\"$get_language_active_iso_two\""; if($get_language_active_iso_two == "$get_user_language"){ echo" selected=\"selected\""; } echo">$get_language_active_name</option>\n";
	}
	echo"
	</select>
	</p>
	
	<p>
	$l_gender:<br />
	<select name=\"inp_user_gender\"> 
		<option value=\"\""; if($get_user_gender == ""){ echo" selected=\"selected\""; } echo">- $l_please_select -</option>
		<option value=\"male\""; if($get_user_gender == "male"){ echo" selected=\"selected\""; } echo">$l_male</option>
		<option value=\"female\""; if($get_user_gender == "female"){ echo" selected=\"selected\""; } echo">$l_female</option>
	</select>
	</p>


	<p>
	$l_birthday:<br />";
	$dob_array = explode("-", $get_user_dob);
	$dob_year = $dob_array[0];
	if(isset($dob_array[1])){
		$dob_month = $dob_array[1];
	}
	else{
		$dob_month = 0;
	}
	if(isset($dob_array[2])){
		$dob_day = $dob_array[2];
	}
	else{
		$dob_day = 0;
	}
			
	echo"
	<select name=\"inp_user_dob_day\">
		<option value=\"\""; if($dob_day == ""){ echo" selected=\"selected\""; } echo">- $l_day -</option>\n";
		for($x=1;$x<32;$x++){
			if($x<10){
				$y = 0 . $x;
			}
			else{
				$y = $x;
			}
			echo"<option value=\"$y\""; if($dob_day == "$x"){ echo" selected=\"selected\""; } echo">$x</option>\n";
		}
	echo"
	</select>

	<select name=\"inp_user_dob_month\">
		<option value=\"\""; if($dob_month == ""){ echo" selected=\"selected\""; } echo">- $l_month -</option>\n";

			$l_month_array[0] = "";
			$l_month_array[1] = "$l_january";
			$l_month_array[2] = "$l_february";
			$l_month_array[3] = "$l_march";
			$l_month_array[4] = "$l_april";
			$l_month_array[5] = "$l_may";
			$l_month_array[6] = "$l_june";
			$l_month_array[7] = "$l_juli";
			$l_month_array[8] = "$l_august";
			$l_month_array[9] = "$l_september";
			$l_month_array[10] = "$l_october";
			$l_month_array[11] = "$l_november";
			$l_month_array[12] = "$l_december";
			for($x=1;$x<13;$x++){
				if($x<10){
					$y = 0 . $x;
				}
				else{
					$y = $x;
				}
				echo"<option value=\"$y\""; if($dob_month == "$y"){ echo" selected=\"selected\""; } echo">$l_month_array[$x]</option>\n";
			}
	echo"
	</select>

	<select name=\"inp_user_dob_year\">
		<option value=\"\""; if($dob_year == ""){ echo" selected=\"selected\""; } echo">- $l_year -</option>\n";
		$year = date("Y");

			for($x=0;$x<150;$x++){
				echo"<option value=\"$year\""; if($dob_year == "$year"){ echo" selected=\"selected\""; } echo">$year</option>\n";
				$year = $year-1;

			}
			echo"
	</select>
	</p>

	<p>
	$l_measurement:<br />
	<select name=\"inp_user_measurement\">
		<option value=\"\""; if($get_user_measurement == ""){ echo" selected=\"selected\""; } echo">- $l_please_select -</option>
		<option value=\"metric\""; if($get_user_measurement == "metric"){ echo" selected=\"selected\""; } echo">Metric</option>
		<option value=\"imperial\""; if($get_user_measurement == "imperial"){ echo" selected=\"selected\""; } echo">Imperial</option>
	</select>
	</p>

	<p>
	$l_rank:<br />
			<select name=\"inp_user_rank\">";
			if($get_my_user_rank == "admin"){
				echo"<option value=\"admin\""; if($get_user_rank == "admin"){ echo" selected=\"selected\""; } echo">$l_admin</option>\n";
				echo"<option value=\"moderator\""; if($get_user_rank == "moderator"){ echo" selected=\"selected\""; } echo">$l_moderator</option>\n";
				echo"<option value=\"editor\""; if($get_user_rank == "editor"){ echo" selected=\"selected\""; } echo">$l_editor</option>\n";
				echo"<option value=\"trusted\""; if($get_user_rank == "trusted"){ echo" selected=\"selected\""; } echo">$l_trusted</option>\n";
				echo"<option value=\"user\""; if($get_user_rank == "user"){ echo" selected=\"selected\""; } echo">$l_user</option>\n";
			}
			elseif($get_my_user_rank == "moderator"){
				echo"<option value=\"moderator\""; if($get_user_rank == "moderator"){ echo" selected=\"selected\""; } echo">$l_moderator</option>\n";
				echo"<option value=\"editor\""; if($get_user_rank == "editor"){ echo" selected=\"selected\""; } echo">$l_editor</option>\n";
				echo"<option value=\"trusted\""; if($get_user_rank == "trusted"){ echo" selected=\"selected\""; } echo">$l_trusted</option>\n";
				echo"<option value=\"user\""; if($get_user_rank == "user"){ echo" selected=\"selected\""; } echo">$l_user</option>\n";
			}
			echo"
			</select>
			</p>

			<p>
			$l_points:<br />
			<input type=\"text\" name=\"inp_user_points\" size=\"78\" value=\"$get_user_points\" /><br />
			</p>

			<p>
			$l_likes:<br />
			<input type=\"text\" name=\"inp_user_likes\" size=\"78\" value=\"$get_user_likes\" /><br />
			</p>

			<p>
			$l_dislikes:<br />
			<input type=\"text\" name=\"inp_user_dislikes\" size=\"78\" value=\"$get_user_dislikes\" /><br />
			</p>


			<p>
			$l_status:<br />
			<input type=\"text\" name=\"inp_user_status\" size=\"78\" value=\"$get_user_status\" /><br />
			</p>

	<p>
	$l_user_verified_by_moderator:<br />
	<select name=\"inp_user_verified_by_moderator\">
		<option value=\"\""; if($get_user_verified_by_moderator == ""){ echo" selected=\"selected\""; } echo">- $l_please_select -</option>
		<option value=\"1\""; if($get_user_verified_by_moderator == "1"){ echo" selected=\"selected\""; } echo">$l_yes</option>
		<option value=\"0\""; if($get_user_verified_by_moderator == "0"){ echo" selected=\"selected\""; } echo">$l_no</option>
	</select>
	</p>
			
	<p>
	<input type=\"submit\" value=\"$l_save\" class=\"btn btn-success btn-sm\" />
	</p>

	</form>
	";
?>