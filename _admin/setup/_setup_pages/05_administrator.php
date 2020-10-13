<?php

/*- Check if setup is run ------------------------------------------------------------ */
$server_name = $_SERVER['HTTP_HOST'];
$server_name = clean($server_name);
$setup_finished_file = "setup_finished_" . $server_name . ".php";
if(file_exists("../_data/$setup_finished_file")){
	echo"Setup is finished.";
	die;
}


if($process == "1"){
	// Administrator
	$inp_user_email = $_POST['inp_user_email'];
	$inp_user_email = output_html($inp_user_email);
	$inp_user_email_mysql = quote_smart($link, $inp_user_email);

	$inp_user_name = "Administrator";
	$inp_user_name_mysql = quote_smart($link, $inp_user_name);

	$inp_user_password = $_POST['inp_user_password'];
	$inp_user_password = output_html($inp_user_password);

		
	if(empty($inp_user_email)){
		$ft = "warning";
		$fm = "please_enter_your_email_address";
		$url = "index.php?page=05_administrator&language=$language&ft=$ft&fm=$fm";
		header("Location: $url");
		exit;
	}
	if(empty($inp_user_password)){
		$ft = "warning";
		$fm = "please_enter_your_password";
		$url = "index.php?page=05_administrator&language=$language&ft=$ft&fm=$fm";
		header("Location: $url");
		exit;
	}


	// Create salt
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$charactersLength = strlen($characters);
    	$salt = '';
    	for ($i = 0; $i < 6; $i++) {
        	$salt .= $characters[rand(0, $charactersLength - 1)];
    	}
	$inp_user_salt_mysql = quote_smart($link, $salt);

	// Password
	$inp_user_password_encrypted =  sha1($inp_user_password);
	$inp_user_password_mysql = quote_smart($link, $inp_user_password_encrypted);

	// Security
	$inp_user_security = rand(0,9999);

	// Language
	$inp_user_language = output_html($language);
	$inp_user_language_mysql = quote_smart($link, $inp_user_language);

	// Registered
	$datetime = date("Y-m-d H:i:s");
	$time = time();

	// Date format
	if($language == "no"){
		$inp_user_date_format = "l d. f Y";
	}
	else{
		$inp_user_date_format = "l jS \of F Y";
	}
	$inp_user_date_format_mysql = quote_smart($link, $inp_user_date_format);



	// Mesurment
	if($language == "en"){
		$inp_profile_mesurment = "imperial"; // imperial
	}
	else{
		$inp_profile_mesurment = "metric"; // metric
	}

	// Insert user
	mysqli_query($link, "INSERT INTO $t_users
	(user_id, user_email, user_name, user_alias, user_password, user_salt, user_security, user_language, user_measurement, user_date_format, user_registered, user_registered_time, user_last_online, user_last_online_time, user_rank, user_points, user_points_rank, user_likes, user_dislikes, user_verified_by_moderator, user_marked_as_spammer) 
	VALUES 
	(NULL, $inp_user_email_mysql, $inp_user_name_mysql, $inp_user_name_mysql, $inp_user_password_mysql, $inp_user_salt_mysql, '$inp_user_security', $inp_user_language_mysql, '$inp_profile_mesurment', $inp_user_date_format_mysql, '$datetime', '$time', '$datetime', '$time', 'admin', '0', 'Newbie', '0', '0', '1', 0)")
	or die(mysqli_error($link));


	// Get user id
	$query = "SELECT user_id FROM $t_users WHERE user_email=$inp_user_email_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_user_id) = $row;


	// Insert profile
	mysqli_query($link, "INSERT INTO $t_users_profile
	(profile_id, profile_user_id, profile_privacy) 
	VALUES 
	(NULL, '$get_user_id', 'public')")
	or die(mysqli_error($link));


	// Setup email notifications
	$inp_es_user_id = quote_smart($link, $get_user_id);
	mysqli_query($link, "INSERT INTO $t_users_email_subscriptions
	(es_id, es_user_id, es_type, es_on_off) 
	VALUES 
	(NULL, $inp_es_user_id, 'friend_request', '1'),
	(NULL, $inp_es_user_id, 'status_comments', '1')")
	or die(mysqli_error($link));


	// Login user
	$_SESSION['user_id'] = "$get_user_id";
	$_SESSION['security'] = "$inp_user_security";
	$_SESSION['admin_user_id']  = "$get_user_id";
	$_SESSION['admin_security'] = "$inp_user_security";


	// Move to admin-panel
	header("Location: index.php?page=06_webdesign&language=$language");
	exit;

}


echo"
<h1>$l_administrator</h1>


<!-- Focus -->
	<script>
	\$(document).ready(function(){
		\$('[name=\"inp_user_email\"]').focus();
	});
	</script>
<!-- //Focus -->



<!-- Administrator form -->

	<form method=\"post\" action=\"index.php?page=05_administrator&amp;language=$language&amp;process=1\" enctype=\"multipart/form-data\">

	<!-- Error -->
		";
		if(isset($ft) && isset($fm)){
			if($ft != ""){
				if($fm == "please_enter_your_user_name"){
					$fm = "$l_please_enter_your_user_name";
				}
				elseif($fm == "please_enter_your_email_address"){
					$fm = "$l_please_enter_your_email";
				}
				elseif($fm == "please_enter_your_password"){
					$fm = "$l_please_enter_your_password";
				}
				else{
					$fm = ucfirst($fm);
				}	
				echo"<div class=\"$ft\"><span>$fm</span></div>";
			}
		}
		echo"
	<!-- //Error -->

	<p><b>$l_email:</b><br />
	<input type=\"text\" name=\"inp_user_email\" value=\""; if(isset($inp_user_email)){ echo"$inp_user_email"; } echo"\" size=\"35\" tabindex=\"1\" /></p>

	<p><b>$l_password:</b><br />
	<input type=\"password\" name=\"inp_user_password\" value=\""; if(isset($inp_user_password)){ echo"$inp_user_password"; } echo"\" size=\"35\" tabindex=\"3\" /></p>

	<p>
	<input type=\"submit\" value=\"$l_next\" class=\"submit\" />
	</p>

	</form>

<!-- //Administrator form -->
";
?>

