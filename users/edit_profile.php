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

	$query = "SELECT user_id, user_name, user_alias, user_language, user_gender, user_dob, user_rank FROM $t_users WHERE user_id=$user_id_mysql AND user_security=$security_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_user_id, $get_user_name, $get_user_alias, $get_user_language, $get_user_gender, $get_user_dob, $get_user_rank) = $row;

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

	if($action == "save"){
		
		$inp_user_alias = $_POST['inp_user_alias'];
		$inp_user_alias = output_html($inp_user_alias);
		$inp_user_alias = ucfirst($inp_user_alias);
		$inp_user_alias = substr($inp_user_alias, 0, 20);
		$inp_user_alias_lower = strtolower($inp_user_alias);
		$inp_user_alias_mysql = quote_smart($link, $inp_user_alias);
		if($inp_user_alias != "$get_user_alias"){
			
			if(empty($inp_user_alias)){
				$fm_alias = "users_please_enter_a_alias";
			}
			else{
				// Is the alias taken?
				if($inp_user_alias_lower != "$get_user_alias"){
					$query = "SELECT user_id FROM $t_users WHERE user_alias=$inp_user_alias_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_check_user_id) = $row;
					if($get_check_user_id != ""){
						$fm_alias = "user_alias_taken";
					}
					else{
						// Update alias
						$result = mysqli_query($link, "UPDATE $t_users SET user_alias=$inp_user_alias_mysql WHERE user_id=$user_id_mysql");
					}
				}
			}
		}

		$inp_profile_work = $_POST['inp_profile_work'];
		$inp_profile_work = output_html($inp_profile_work);
		$inp_profile_work_mysql = quote_smart($link, $inp_profile_work);

		$inp_profile_university = $_POST['inp_profile_university'];
		$inp_profile_university = output_html($inp_profile_university);
		$inp_profile_university_mysql = quote_smart($link, $inp_profile_university);

		$inp_profile_high_school = $_POST['inp_profile_high_school'];
		$inp_profile_high_school = output_html($inp_profile_high_school);
		$inp_profile_high_school_mysql = quote_smart($link, $inp_profile_high_school);

		$inp_profile_languages = $_POST['inp_profile_languages'];
		$inp_profile_languages = output_html($inp_profile_languages);
		$inp_profile_languages_mysql = quote_smart($link, $inp_profile_languages);

		$inp_profile_website = $_POST['inp_profile_website'];
		$inp_profile_website = output_html($inp_profile_website);
		$inp_profile_website = strtolower($inp_profile_website);
		if($inp_profile_website != ""){
			$check = substr($inp_profile_website, 0, 3);
			if($check != "htt"){
				$inp_profile_website = "http://" . $inp_profile_website;
			}
		}
		$inp_profile_website_mysql = quote_smart($link, $inp_profile_website);

		if(isset($_POST['inp_interested_in_men'])){
			$inp_interested_in_men = $_POST['inp_interested_in_men'];
		}
		else{
			$inp_interested_in_men = "off";
		}
		if(isset($_POST['inp_interested_in_women'])){
			$inp_interested_in_women = $_POST['inp_interested_in_women'];
		}
		else{
			$inp_interested_in_women = "off";
		}
		
		$inp_interested_in = $inp_interested_in_men . "|" . $inp_interested_in_women;
		$inp_interested_in = output_html($inp_interested_in);
		$inp_interested_in_mysql = quote_smart($link, $inp_interested_in);

		$inp_profile_relationship = $_POST['inp_profile_relationship'];
		$inp_profile_relationship = output_html($inp_profile_relationship);
		$inp_profile_relationship_mysql = quote_smart($link, $inp_profile_relationship);

		$inp_profile_about_me = $_POST['inp_profile_about_me'];
		$inp_profile_about_me = output_html($inp_profile_about_me);
		$inp_profile_about_me_mysql = quote_smart($link, $inp_profile_about_me);


		$inp_user_gender = $_POST['inp_user_gender'];
		$inp_user_gender = output_html($inp_user_gender);
		$inp_user_gender_mysql = quote_smart($link, $inp_user_gender);

		// Dob
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

		// Update rest
					
		$result = mysqli_query($link, "UPDATE $t_users SET user_gender=$inp_user_gender_mysql WHERE user_id=$user_id_mysql");

		$result = mysqli_query($link, "UPDATE $t_users_profile SET profile_work=$inp_profile_work_mysql, profile_university=$inp_profile_university_mysql, profile_high_school=$inp_profile_high_school_mysql, profile_languages=$inp_profile_languages_mysql, profile_website=$inp_profile_website_mysql, profile_interested_in=$inp_interested_in_mysql, profile_relationship=$inp_profile_relationship_mysql, profile_about=$inp_profile_about_me_mysql WHERE profile_user_id=$user_id_mysql");
		

		

		$url = "edit_profile.php?l=$l&ft=success&fm=changes_saved";
		if(isset($fm_alias)){
			$url = $url . "&fm_alias=$fm_alias";
		}
		header("Location: $url");
		exit;
	}
	if($action == ""){
		echo"
		<h1>$l_profile</h1>

		<!-- You are here -->
			<div class=\"you_are_here\">
				<p>
				<b>$l_you_are_here:</b><br />
				<a href=\"my_profile.php?l=$l\">$l_my_profile</a>
				&gt; 
				<a href=\"edit_profile.php?l=$l\">$l_profile</a>
				</p>
			</div>
		<!-- //You are here -->

		<!-- Focus -->
		<script>
		\$(document).ready(function(){
			\$('[name=\"inp_user_alias\"]').focus();
		});
		</script>
		<!-- //Focus -->
		<form method=\"POST\" action=\"edit_profile.php?action=save&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\" name=\"nameform\">

		<!-- Feedback -->
			";
			if($ft != "" && $fm != ""){
				if($fm == "changes_saved"){
					$fm = "$l_changes_saved";
				}
				else{
					$fm = "$ft";
				}

				
				if(isset($_GET['fm_alias'])) {
					$fm_alias = $_GET['fm_alias'];
					$fm_alias = strip_tags(stripslashes($fm_alias));
					if($fm_alias == "users_please_enter_a_alias"){
						$fm = $fm . "<br /><br /><b>$l_users_please_enter_a_alias</b>";
					}
					else{
						$fm = $fm . "<br /><br /><b>$l_user_alias_taken</b>";
					}

				}
				echo"<div class=\"$ft\"><p>$fm</p></div>";
			}
			echo"
		<!-- //Feedback -->




		<p>
		$l_alias:<br />
		<input type=\"text\" name=\"inp_user_alias\" size=\"40\" value=\"$get_user_alias\" /><br />
		</p>


		<p>
		$l_work:<br />
		<input type=\"text\" name=\"inp_profile_work\" size=\"40\" value=\"$get_profile_work\" /><br />
		</p>

		<p>
		$l_university:<br />
		<input type=\"text\" name=\"inp_profile_university\" size=\"40\" value=\"$get_profile_university\" /><br />
		</p>

		<p>
		$l_high_school:<br />
		<input type=\"text\" name=\"inp_profile_high_school\" size=\"40\" value=\"$get_profile_high_school\" /><br />
		</p>

		<p>
		$l_languages:<br />
		<input type=\"text\" name=\"inp_profile_languages\" size=\"40\" value=\"$get_profile_languages\" /><br />
		</p>

		<p>
		$l_website:<br />
		<input type=\"text\" name=\"inp_profile_website\" size=\"40\" value=\"$get_profile_website\" /><br />
		</p>


		<p>
		$l_interested_in:<br />";
		$intrested_in_array = explode("|", $get_profile_interested_in);
		echo"
		<input type=\"checkbox\" name=\"inp_interested_in_men\""; if($intrested_in_array[0] == "on"){ echo" checked=\"checked\""; } echo" /> $l_men
		&nbsp;
		<input type=\"checkbox\" name=\"inp_interested_in_women\""; if(isset($intrested_in_array[1]) && $intrested_in_array[1] == "on"){ echo" checked=\"checked\""; } echo" /> $l_women
		</p>


		<p>
		$l_relationship_status:<br />
		<select name=\"inp_profile_relationship\"> 
			<option value=\"\""; if($get_profile_relationship == ""){ echo" selected=\"selected\""; } echo">- $l_please_select -</option>
			<option value=\"single\""; if($get_profile_relationship == "single"){ echo" selected=\"selected\""; } echo">$l_single</option>
			<option value=\"in_a_relationship\""; if($get_profile_relationship == "in_a_relationship"){ echo" selected=\"selected\""; } echo">$l_in_a_relationship</option>
			<option value=\"engaged\""; if($get_profile_relationship == "engaged"){ echo" selected=\"selected\""; } echo">$l_engaged</option>
			<option value=\"married\""; if($get_profile_relationship == "married"){ echo" selected=\"selected\""; } echo">$l_married</option>
			<option value=\"in_a_open_relationship\""; if($get_profile_relationship == "in_a_open_relationship"){ echo" selected=\"selected\""; } echo">$l_in_a_open_relationship</option>
			<option value=\"its_complicated\""; if($get_profile_relationship == "its_complicated"){ echo" selected=\"selected\""; } echo">$l_its_complicated</option>
			<option value=\"seperated\""; if($get_profile_relationship == "seperated"){ echo" selected=\"selected\""; } echo">$l_seperated</option>
			<option value=\"divorced\""; if($get_profile_relationship == "divorced"){ echo" selected=\"selected\""; } echo">$l_divorced</option>
			<option value=\"widow_widower\""; if($get_profile_relationship == "widow_widower"){ echo" selected=\"selected\""; } echo">$l_widow_widower</option>
		</select>
		</p>
		<p>
		$l_about_me:<br />
		<textarea name=\"inp_profile_about_me\" rows=\"6\" cols=\"40\">"; $get_profile_about = str_replace("<br />", "\n", $get_profile_about); echo"$get_profile_about</textarea>
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
		$l_month_array[1] = "$l_month_january";
		$l_month_array[2] = "$l_month_february";
		$l_month_array[3] = "$l_month_march";
		$l_month_array[4] = "$l_month_april";
		$l_month_array[5] = "$l_month_may";
		$l_month_array[6] = "$l_month_june";
		$l_month_array[7] = "$l_month_juli";
		$l_month_array[8] = "$l_month_august";
		$l_month_array[9] = "$l_month_september";
		$l_month_array[10] = "$l_month_october";
		$l_month_array[11] = "$l_month_november";
		$l_month_array[12] = "$l_month_december";
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
		<input type=\"submit\" value=\"$l_save\" class=\"btn\" />
		</p>

		</form>

		";
	}
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
		
	<meta http-equiv=\"refresh\" content=\"10;url=index.php\">
	";
}
/*- Footer ---------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");

?>