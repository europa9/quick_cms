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

if($action == "unsubscribe_and_source_is_emails"){
	// The user has clicked "unsubscribe" on a email link.
	$user_id = $_GET['user_id'];
	$user_id = output_html($user_id);
	$user_id_mysql = quote_smart($link, $user_id);
	
	$registered_time = $_GET['registered_time'];
	$registered_time = output_html($registered_time);
	$registered_time_mysql = quote_smart($link, $registered_time);
	
	$query = "SELECT user_id FROM $t_users WHERE user_id=$user_id_mysql AND user_registered_time=$registered_time_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_user_id) = $row;
	if($get_user_id != ""){
		// Remove from all lists
		$result = mysqli_query($link, "UPDATE $t_users_profile SET profile_newsletter=0 WHERE profile_user_id=$user_id_mysql");
		$result = mysqli_query($link, "UPDATE $t_users_email_subscriptions SET es_on_off=0 WHERE es_user_id=$user_id_mysql");
		

		echo"
		<h1>Unsubscribe</h1>

		<p>
		You have unsubscribed successfully.
		We will no longer send you e-mails.
		</p>
		";
	}
	else{
		echo"<p>Wrong parameters.</p>";
	}
}


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

		$inp_profile_newsletter = $_POST['inp_profile_newsletter'];
		$inp_profile_newsletter = output_html($inp_profile_newsletter);
		$inp_profile_newsletter_mysql = quote_smart($link, $inp_profile_newsletter);
		$result = mysqli_query($link, "UPDATE $t_users_profile SET profile_newsletter=$inp_profile_newsletter_mysql WHERE profile_user_id=$user_id_mysql");
			

		$inp_es_friend_request = $_POST['inp_es_friend_request'];
		$inp_es_friend_request = output_html($inp_es_friend_request);
		$inp_es_friend_request_mysql = quote_smart($link, $inp_es_friend_request);
		$result = mysqli_query($link, "UPDATE $t_users_email_subscriptions SET es_on_off=$inp_es_friend_request_mysql WHERE es_user_id=$user_id_mysql AND es_type='friend_request'");

		$inp_es_status_comments = $_POST['inp_es_status_comments'];
		$inp_es_status_comments = output_html($inp_es_status_comments);
		$inp_es_status_comments_mysql = quote_smart($link, $inp_es_status_comments);
		$result = mysqli_query($link, "UPDATE $t_users_email_subscriptions SET es_on_off=$inp_es_status_comments_mysql WHERE es_user_id=$user_id_mysql AND es_type='status_comments'");


		$inp_es_status_replies = $_POST['inp_es_status_replies'];
		$inp_es_status_replies = output_html($inp_es_status_replies);
		$inp_es_status_replies_mysql = quote_smart($link, $inp_es_status_replies);
		$result = mysqli_query($link, "UPDATE $t_users_email_subscriptions SET es_on_off=$inp_es_status_replies_mysql WHERE es_user_id=$user_id_mysql AND es_type='status_replies'");


		$inp_es_my_birthday = $_POST['inp_es_my_birthday'];
		$inp_es_my_birthday = output_html($inp_es_my_birthday);
		$inp_es_my_birthday_mysql = quote_smart($link, $inp_es_my_birthday);
		$result = mysqli_query($link, "UPDATE $t_users_email_subscriptions SET es_on_off=$inp_es_my_birthday_mysql WHERE es_user_id=$user_id_mysql AND es_type='my_birthday'");


		$url = "edit_subscriptions.php?l=$l&ft=success&fm=changes_saved"; 
		if($process == "1"){
			header("Location: $url");
		}
		else{
			echo"<meta http-equiv=\"refresh\" content=\"1;url=$url\">";
		}
		exit;
	}
	if($action == ""){
		// Check friend request
		$q = "SELECT es_on_off FROM $t_users_email_subscriptions WHERE es_user_id=$user_id_mysql AND es_type='friend_request'";
		$r = mysqli_query($link, $q);
		$rowb = mysqli_fetch_row($r);
		list($get_es_friend_request) = $rowb;
		
		$q = "SELECT es_on_off FROM $t_users_email_subscriptions WHERE es_user_id=$user_id_mysql AND es_type='status_comments'";
		$r = mysqli_query($link, $q);
		$rowb = mysqli_fetch_row($r);
		list($get_es_status_comments) = $rowb;


		
		$q = "SELECT es_on_off FROM $t_users_email_subscriptions WHERE es_user_id=$user_id_mysql AND es_type='status_replies'";
		$r = mysqli_query($link, $q);
		$rowb = mysqli_fetch_row($r);
		list($get_es_status_replies) = $rowb;
		if($get_es_status_replies == ""){
			$inp_es_user_id = quote_smart($link, $get_user_id);
			mysqli_query($link, "INSERT INTO $t_users_email_subscriptions
			(es_id, es_user_id, es_type, es_on_off) 
			VALUES 
			(NULL, $inp_es_user_id, 'status_replies', '1')")
			or die(mysqli_error($link));

			$get_es_status_replies = "1";
		}

		$q = "SELECT es_on_off FROM $t_users_email_subscriptions WHERE es_user_id=$user_id_mysql AND es_type='my_birthday'";
		$r = mysqli_query($link, $q);
		$rowb = mysqli_fetch_row($r);
		list($get_es_my_birthday) = $rowb;
		if($get_es_my_birthday == ""){
			$inp_es_user_id = quote_smart($link, $get_user_id);
			mysqli_query($link, "INSERT INTO $t_users_email_subscriptions
			(es_id, es_user_id, es_type, es_on_off) 
			VALUES 
			(NULL, $inp_es_user_id, 'my_birthday', '1')")
			or die(mysqli_error($link));

			$get_es_my_birthday = "1";
		}

		echo"
		<h1>$l_subscriptions</h1>


		<!-- You are here -->
			<div class=\"you_are_here\">
				<p>
				<b>$l_you_are_here:</b><br />
				<a href=\"my_profile.php?l=$l\">$l_my_profile</a>
				&gt; 
				<a href=\"edit_subscriptions.php?l=$l\">$l_subscriptions</a>
				</p>
			</div>
		<!-- //You are here -->

		<form method=\"POST\" action=\"edit_subscriptions.php?action=save&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\" name=\"nameform\">

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
			\$('[name=\"inp_profile_newsletter\"]').focus();
		});
		</script>
		<!-- //Focus -->



		<p>
		$l_newsletter:<br />
		<input type=\"radio\" name=\"inp_profile_newsletter\" value=\"1\""; if($get_profile_newsletter == "1" OR $get_profile_newsletter == ""){ echo" checked=\"checked\""; } echo" /> $l_yes
		&nbsp;
		<input type=\"radio\" name=\"inp_profile_newsletter\" value=\"0\""; if($get_profile_newsletter == "0"){ echo" checked=\"checked\""; } echo" /> $l_no
		</p>

		<p>
		$l_send_me_email_when_i_get_a_friend_request:<br />
		<input type=\"radio\" name=\"inp_es_friend_request\" value=\"1\""; if($get_es_friend_request == "1"){ echo" checked=\"checked\""; } echo" /> $l_yes
		&nbsp;
		<input type=\"radio\" name=\"inp_es_friend_request\" value=\"0\""; if($get_es_friend_request == "0" OR $get_es_friend_request == ""){ echo" checked=\"checked\""; } echo" /> $l_no
		</p>

		<p>
		$l_send_me_email_when_i_get_a_comment:<br />
		<input type=\"radio\" name=\"inp_es_status_comments\" value=\"1\""; if($get_es_status_comments == "1"){ echo" checked=\"checked\""; } echo" /> $l_yes
		&nbsp;
		<input type=\"radio\" name=\"inp_es_status_comments\" value=\"0\""; if($get_es_status_comments == "0" OR $get_es_status_comments == ""){ echo" checked=\"checked\""; } echo" /> $l_no
		</p>

		<p>
		$l_send_me_email_when_someone_replies_to_a_status_that_i_have_written:<br />
		<input type=\"radio\" name=\"inp_es_status_replies\" value=\"1\""; if($get_es_status_replies == "1"){ echo" checked=\"checked\""; } echo" /> $l_yes
		&nbsp;
		<input type=\"radio\" name=\"inp_es_status_replies\" value=\"0\""; if($get_es_status_replies == "0" OR $get_es_status_comments == ""){ echo" checked=\"checked\""; } echo" /> $l_no
		</p>

		<p>
		$l_send_me_email_on_my_birthday:<br />
		<input type=\"radio\" name=\"inp_es_my_birthday\" value=\"1\""; if($get_es_my_birthday == "1"){ echo" checked=\"checked\""; } echo" /> $l_yes
		&nbsp;
		<input type=\"radio\" name=\"inp_es_my_birthday\" value=\"0\""; if($get_es_my_birthday == "0" OR $get_es_my_birthday == ""){ echo" checked=\"checked\""; } echo" /> $l_no
		</p>


		<p>
		<input type=\"submit\" value=\"$l_save\" class=\"btn btn-success\" />
		</p>

		</form>

		";
	}
}

/*- Footer ---------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");

?>