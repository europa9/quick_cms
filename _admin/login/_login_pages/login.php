<?php



if($process == "1"){


	// Variables
	if(isset($_POST['inp_email'])) {
		$inp_email = $_POST['inp_email'];
		$inp_email = output_html($inp_email);
		$inp_email = strtolower($inp_email);
		if(empty($inp_email)){
			header("Location: index.php?ft=error&fm=please_enter_your_email&l=$l");
			exit;
		}
		$inp_email_mysql = quote_smart($link, $inp_email);

		// Validate email
		// if (!filter_var($inp_email, FILTER_VALIDATE_EMAIL)) {
		//	header("Location: index.php?ft=error&fm=invalid_email_format");
		//	exit;
		// }
	}
	else{
		header("Location: index.php?ft=error&fm=please_enter_your_email&l=$l");
		exit;
	}
	if(isset($_POST['inp_password'])) {
		$inp_password = $_POST['inp_password'];
		$inp_password = output_html($inp_password);
		if(empty($inp_password)){
			header("Location: index.php?ft=error&fm=please_enter_your_password&l=$l");
			exit;
		}
	}
	else{
		header("Location: index.php?ft=error&fm=please_enter_your_password&l=$l");
		exit;
	}


	// We got mail and password, look for user
	$query = "SELECT user_id, user_password, user_salt, user_security, user_language, user_last_online, user_rank, user_login_tries FROM $t_users WHERE user_email=$inp_email_mysql OR user_name=$inp_email_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_user_id, $get_user_password, $get_user_salt, $get_user_security, $get_user_language, $get_user_last_online, $get_user_rank, $get_user_login_tries) = $row;

	if($get_user_id == ""){
		header("Location: index.php?ft=error&fm=unknown_email_address&l=$l");
		exit;
	}
	

	// E-mail found
	if($get_user_login_tries > "5"){
		// Can we reset it?
		$array = explode(" ", $get_user_last_online);
		$time  = explode(":", $array[1]);
		$hour  = $time[0];
		$now   = date("H");
		if($hour == "$now"){
			header("Location: index.php?ft=warning&fm=account_temporarily_banned_please_wait_one_hour_before_trying_again&inp_mail=$inp_mail&l=$l");
			exit;
		}
		
	}
		
	// Password
	$inp_password_encrypted = sha1($inp_password);

	if($inp_password_encrypted != "$get_user_password"){
		// Wrong password
		$inp_login_attempts = $userLoginAttemptsSav+1;
		$input_registered_date 	= date("Y-m-d H:i:s");
		$input_registered_time 	= time();

		// Header
		header("Location: index.php?ft=error&fm=wrong_password_please_enter_your_password&inp_mail=$inp_mail&l=$l");
		exit;
	}

	// Rank	
	if($get_user_rank == "admin" OR $get_user_rank == "moderator"){
		// Access OK!
	}
	else{
		header("Location: index.php?ft=warning&fm=access_denied_please_contact_administrator&inp_mail=$inp_mail&l=$l");
		exit;
	}
				
	// Login success
	$input_registered_date 	= date("Y-m-d H:i:s");
	$input_registered_time 	= time();
	$inp_ip			= $_SERVER['REMOTE_ADDR'];
	if($configSiteUseGethostbyaddrSav == "1"){
		$inp_host_by_addr = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	}
	else{
		$inp_host_by_addr = "";
	}

	// Add session
	$_SESSION['admin_user_id']  = "$get_user_id";
	$_SESSION['admin_security'] = "$get_user_security";
	$_SESSION['user_id'] = "$get_user_id";
	$_SESSION['security'] = "$get_user_security";
	


	// Move to admin-panel
	header("Location: ../_liquidbase/liquidbase.php?l=$l");
	exit;

}

// Language
if($l == ""){
	if(isset($_SESSION['l'])){
		$l = $_SESSION['l'];
	}
	else{
		$l = "en";
	}
}

echo"


<h1>$l_login</h1>

<!-- Administrator form -->

	<form method=\"post\" action=\"index.php?page=login&amp;process=1&amp;l=$l\" enctype=\"multipart/form-data\">

	<!-- Error -->
		";
		if(isset($ft) && isset($fm)){
		if($fm == "please_enter_your_email"){
			$fm = "$l_please_enter_your_email";
		}
		elseif($fm == "invalid_email_format"){
			$fm = "$l_invalid_email_format";
		}
		elseif($fm == "unknown_email_address"){
			$fm = "$l_unknown_email_address";
		}
		elseif($fm == "please_enter_your_password"){
			$fm = "$l_please_enter_your_password";
		}
		elseif($fm == "account_temporarily_banned_please_wait_one_hour_before_trying_again"){
			$fm = "$l_account_temporarily_banned_please_wait_one_hour_before_trying_again";
		}
		elseif($fm == "access_denied_please_contact_administrator"){
			$fm = "$l_access_denied_please_contact_administrator";
		}
		elseif($fm == "wrong_password_please_enter_your_password"){
			$fm = "$l_wrong_password_please_enter_your_password";
		}
		elseif($fm == "please_enter_your_password"){
			$fm = "$l_please_enter_your_password";
		}
		elseif($fm == "please_login_to_the_control_panel"){
			$fm = "$l_please_log_in_to_view_the_control_panel";
		}
		elseif($fm == "check_your_email"){
			$fm = "$l_check_your_email";
		}
		elseif($fm == "wrong_key"){
			$fm = "$l_wrong_key";
		}
		elseif($fm == "user_not_found"){
			$fm = "$l_user_not_found";
		}
		else{
			$fm = ucfirst($fm);
		}
		echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"
	<!-- //Error -->


	<!-- Focus -->
		<script>
		\$(document).ready(function(){
			\$('[name=\"inp_email\"]').focus();
		});
		</script>
	<!-- //Focus -->

	<p>$l_email:<br />
	<input type=\"text\" name=\"inp_email\" value=\""; if(isset($inp_email)){ echo"$inp_email"; } echo"\" size=\"30\" tabindex=\"1\" class=\"inp_email\" />
	</p>


	<p>$l_password:<br />
	<input type=\"password\" name=\"inp_password\" value=\"\" size=\"30\" tabindex=\"2\" class=\"inp_password\" />
	</p>

	<p>
	<input type=\"submit\" value=\"$l_login\" class=\"inp_submit\" tabindex=\"3\" />
	</p>

	</form>

<!-- //Administrator form -->

<!-- Main Menu -->
	<p>
	<a href=\"index.php?page=forgot_password\">$l_forgot_password</a>
	</p>

<!-- //Main Menu -->

";
?>
