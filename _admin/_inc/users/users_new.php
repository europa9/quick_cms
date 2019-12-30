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

if($process == "1"){

	$inp_user_email = $_POST['inp_user_email'];
	$inp_user_email = output_html($inp_user_email);
	$inp_user_email = strtolower($inp_user_email);
	$inp_user_email_mysql = quote_smart($link, $inp_user_email);
			
	$inp_user_name = $_POST['inp_user_name'];
	$inp_user_name = output_html($inp_user_name);
	$inp_user_name = ucfirst($inp_user_name);
	$inp_user_name_mysql = quote_smart($link, $inp_user_name);

	$inp_user_language = $_POST['inp_user_language'];
	$inp_user_language = output_html($inp_user_language);
	$inp_user_language_mysql = quote_smart($link, $inp_user_language);

	$inp_user_rank = $_POST['inp_user_rank'];
	$inp_user_rank = output_html($inp_user_rank);
	$inp_user_rank_mysql = quote_smart($link, $inp_user_rank);

	$inp_profile_first_name = $_POST['inp_profile_first_name'];
	$inp_profile_first_name = output_html($inp_profile_first_name);
	$inp_profile_first_name = ucwords($inp_profile_first_name);
	$inp_profile_first_name_mysql = quote_smart($link, $inp_profile_first_name);

	$inp_profile_middle_name = $_POST['inp_profile_middle_name'];
	$inp_profile_middle_name = output_html($inp_profile_middle_name);
	$inp_profile_middle_name = ucwords($inp_profile_middle_name);
	$inp_profile_middle_name_mysql = quote_smart($link, $inp_profile_middle_name);

	$inp_profile_last_name = $_POST['inp_profile_last_name'];
	$inp_profile_last_name = output_html($inp_profile_last_name);
	$inp_profile_last_name = ucwords($inp_profile_last_name);
	$inp_profile_last_name_mysql = quote_smart($link, $inp_profile_last_name);

	// Mesurment
	if($l == "en"){
		$inp_profile_mesurment = "i"; // imperial
	}
	else{
		$inp_profile_mesurment = "m"; // metric
	}

	
	// Check empty email
	if(empty($inp_user_email)){
		$ft = "warning";
		$fm = "please_enter_a_email_address";
		$url = "index.php?open=$open&page=users_new&ft=$ft&fm=$fm";
		$url = $url . "&inp_user_email=$inp_user_email";
		$url = $url . "&inp_user_name=$inp_user_name";
		$url = $url . "&inp_user_language=$inp_user_language";
		$url = $url . "&inp_user_rank=$inp_user_rank";
		$url = $url . "&inp_profile_first_name=$inp_profile_first_name";
		$url = $url . "&inp_profile_middle_name=$inp_profile_middle_name";
		$url = $url . "&inp_profile_last_name=$inp_profile_last_name";
		$url = $url . "&editor_language=$editor_language";

		header("Location: $url");
		exit;
	}


	// Check if new email is taken
	$query = "SELECT user_id, user_email, user_name FROM $t_users WHERE user_email=$inp_user_email_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($check_user_id, $check_user_email, $check_user_name) = $row;
	if($check_user_id != ""){
		$fm = "email_alreaddy_in_use";
		$ft = "warning";
		$url = "index.php?open=$open&page=users_new&ft=$ft&fm=$fm";
		$url = $url . "&inp_user_name=$inp_user_name";
		$url = $url . "&inp_user_language=$inp_user_language";
		$url = $url . "&inp_user_rank=$inp_user_rank";
		$url = $url . "&inp_profile_first_name=$inp_profile_first_name";
		$url = $url . "&inp_profile_middle_name=$inp_profile_middle_name";
		$url = $url . "&inp_profile_last_name=$inp_profile_last_name";
		$url = $url . "&editor_language=$editor_language";

		header("Location: $url");
		exit;
	}
	// Check empty user name
	if(empty($inp_user_name)){
		$ft = "warning";
		$fm = "please_enter_a_user_name";
		$url = "index.php?open=$open&page=users_new&ft=$ft&fm=$fm";
		$url = $url . "&inp_user_email=$inp_user_email";
		$url = $url . "&inp_user_language=$inp_user_language";
		$url = $url . "&inp_user_rank=$inp_user_rank";
		$url = $url . "&inp_profile_first_name=$inp_profile_first_name";
		$url = $url . "&inp_profile_middle_name=$inp_profile_middle_name";
		$url = $url . "&inp_profile_last_name=$inp_profile_last_name";
		$url = $url . "&editor_language=$editor_language";

		header("Location: $url");
		exit;
	}

	// Check if new username is taken
	$query = "SELECT user_id, user_email, user_name FROM $t_users WHERE user_name=$inp_user_name_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($check_user_id, $check_user_email, $check_user_name) = $row;
	if($check_user_id != ""){
		$fm = "user_name_alreaddy_in_use";
		$ft = "warning";
		$url = "index.php?open=$open&page=users_new&ft=$ft&fm=$fm";
		$url = $url . "&inp_user_email=$inp_user_email";
		$url = $url . "&inp_user_name=$inp_user_name";
		$url = $url . "&inp_user_language=$inp_user_language";
		$url = $url . "&inp_user_rank=$inp_user_rank";
		$url = $url . "&inp_profile_first_name=$inp_profile_first_name";
		$url = $url . "&inp_profile_middle_name=$inp_profile_middle_name";
		$url = $url . "&inp_profile_last_name=$inp_profile_last_name";
		$url = $url . "&editor_language=$editor_language";

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
	$inp_user_salt = output_html($salt);
	$inp_user_salt_mysql = quote_smart($link, $inp_user_salt);


	// Create password
    	$password = '';
    	for ($i = 0; $i < 8; $i++) {
        	$password .= $characters[rand(0, $charactersLength - 1)];
    	}
	$inp_user_password = output_html($password);

	$inp_user_password_salt = $inp_user_password . $inp_user_salt;
	$inp_user_password_salt_encrypted = sha1($inp_user_password_salt);
	$inp_user_password_mysql = quote_smart($link, $inp_user_password_salt_encrypted);

	// Security
	$inp_user_security = rand(0,9999);

	// Registered
	$datetime = date("Y-m-d H:i:s");

	// Date format
	if($l == "no"){
		$inp_user_date_format = "l d. f Y";
	}
	else{
		$inp_user_date_format = "l jS \of F Y";
	}
	$inp_user_date_format_mysql = quote_smart($link, $inp_user_date_format);

	// Insert user
	mysqli_query($link, "INSERT INTO $t_users
	(user_id, user_email, user_name, user_alias, user_password, user_salt, user_security, user_language, user_date_format, user_registered, user_last_online, user_rank, user_points, user_likes, user_dislikes) 
	VALUES 
	(NULL, $inp_user_email_mysql, $inp_user_name_mysql, $inp_user_name_mysql, $inp_user_password_mysql, $inp_user_salt_mysql, '$inp_user_security', $inp_user_language_mysql, $inp_user_date_format_mysql, '$datetime', '$datetime', $inp_user_rank_mysql, '0', '0', '0')")
	or die(mysqli_error($link));


	// Get user id
	$query = "SELECT user_id FROM $t_users WHERE user_email=$inp_user_email_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_user_id) = $row;
			

	// Insert profile
	mysqli_query($link, "INSERT INTO $t_users_profile
	(profile_id, profile_user_id,profile_first_name, profile_middle_name, profile_last_name) 
	VALUES 
	(NULL, '$get_user_id', $inp_profile_first_name_mysql, $inp_profile_middle_name_mysql, $inp_profile_last_name_mysql)")
	or die(mysqli_error($link));
	
	// Link
	$pageURL = 'http';
	$pageURL .= "://";

	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} 
	else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	$link_admin = str_replace("index.php?open=$open&page=users_new&process=1", "", $pageURL);
	$link_site = str_replace("_admin/index.php?open=$open&page=users_new&process=1", "", $pageURL);



	// Send e-mail
	$host = $_SERVER['HTTP_HOST'];
	$from = "no-reply@" . $_SERVER['HTTP_HOST'];
	$reply = "post@" . $_SERVER['HTTP_HOST'];

	$subject = "Username and password for " . $host;
	$message = "Hello $inp_profile_first_name $inp_profile_last_name,\n\nWelcome to $host. This e-mail contains your username and password. Once logged in you can change your password.\n\nUsername: $inp_user_email\nPassword: $inp_user_password\nControl panel: $link_admin\nSite: $link_site\n\n---\n" . $host;

	$headers = "From: $from" . "\r\n" .
	    "Reply-To: $reply" . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();
	mail($inp_user_email, $subject, $message, $headers);

	// Header
	$url = "index.php?open=$open&page=users_new&ft=success&fm=user_created_and_mail_sent&editor_language=$editor_language";
	header("Location: $url");
	exit;
}

// Get variables from form
if(isset($_GET['inp_user_email'])) {
	$inp_user_email = $_GET['inp_user_email'];
	$inp_user_email = output_html($inp_user_email);
}
if(isset($_GET['inp_user_name'])) {
	$inp_user_name = $_GET['inp_user_name'];
	$inp_user_name = output_html($inp_user_name);
}
if(isset($_GET['inp_user_language'])) {
	$inp_user_language = $_GET['inp_user_language'];
	$inp_user_language = output_html($inp_user_language);
}
if(isset($_GET['inp_user_rank'])) {
	$inp_user_rank = $_GET['inp_user_rank'];
	$inp_user_rank = output_html($inp_user_rank);
}
if(isset($_GET['inp_profile_first_name'])) {
	$inp_profile_first_name = $_GET['inp_profile_first_name'];
	$inp_profile_first_name = output_html($inp_profile_first_name);
}
if(isset($_GET['inp_profile_middle_name'])) {
	$inp_profile_middle_name = $_GET['inp_profile_middle_name'];
	$inp_profile_middle_name = output_html($inp_profile_middle_name);
}
if(isset($_GET['inp_profile_last_name'])) {
	$inp_profile_last_name = $_GET['inp_profile_last_name'];
	$inp_profile_last_name = output_html($inp_profile_last_name);
}



echo"
<h1>$l_new_user</h1>

<form method=\"POST\" action=\"index.php?open=$open&amp;page=users_new&amp;process=1&amp;editor_language=$editor_language\" enctype=\"multipart/form-data\">

<!-- Feedback -->
	";
	if($ft != "" && $fm != ""){
		if($fm == "email_alreaddy_in_use"){
			$fm = "$l_email_alreaddy_in_use";
		}
		elseif($fm == "please_enter_a_email_address"){
			$fm = "$l_please_enter_a_email_address";
		}
		elseif($fm == "user_name_alreaddy_in_use"){
			$fm = "$l_user_name_alreaddy_in_use";
		}
		elseif($fm == "please_enter_a_user_name"){
			$fm = "$l_please_enter_a_user_name";
		}
		elseif($fm == "user_created_and_mail_sent"){
			$fm = "$l_user_created_and_mail_sent";
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
		\$('[name=\"inp_profile_first_name\"]').focus();
	});
	</script>
<!-- //Focus -->

<p>
$l_first_name:<br />
<input type=\"text\" name=\"inp_profile_first_name\" size=\"78\" value=\""; if(isset($inp_profile_first_name)){ echo"$inp_profile_first_name"; } echo"\" /><br />
</p>

<p>
$l_middle_name:<br />
<input type=\"text\" name=\"inp_profile_middle_name\" size=\"78\" value=\""; if(isset($inp_profile_middle_name)){ echo"$inp_profile_middle_name"; } echo"\" /><br />
</p>

<p>
$l_last_name:<br />
<input type=\"text\" name=\"inp_profile_last_name\" size=\"78\" value=\""; if(isset($inp_profile_last_name)){ echo"$inp_profile_last_name"; } echo"\" /><br />
</p>

<p>
$l_email_address:<br />
<input type=\"text\" name=\"inp_user_email\" size=\"78\" value=\""; if(isset($inp_user_email)){ echo"$inp_user_email"; } echo"\" /><br />
</p>

<p>
$l_user_name:<br />
<input type=\"text\" name=\"inp_user_name\" size=\"78\" value=\""; if(isset($inp_user_name)){ echo"$inp_user_name"; } echo"\" /><br />
</p>

<p>
$l_language:<br />
<select name=\"inp_user_language\">";
$filenames = "";
$dir = "_translations/site/";
$dirLen = strlen($dir);
$dp = @opendir($dir);
while($file = @readdir($dp)) $filenames [] = $file;
	for ($i = 0; $i < count($filenames); $i++){
		$content = $filenames[$i];
		$file_path = "$dir$content";

		if($file_path != "$dir." && $file_path != "$dir.."){
			echo"			";
			echo"<option value=\"$content\""; 
			if(isset($inp_user_language)){
				if($content == "$inp_user_language"){ echo" selected=\"selected\""; } 
			}
			else{
				if($content == "$get_my_user_language"){ echo" selected=\"selected\""; } 
			}
			echo">$content</option>\n";
		}
	}
echo"
</select>
</p>

<p>
$l_rank:<br />
<select name=\"inp_user_rank\">";
if($get_my_user_rank == "admin"){
	echo"<option value=\"admin\""; if(isset($inp_user_rank) && $inp_user_rank == "admin"){ echo" selected=\"selected\""; } echo">$l_admin</option>\n";
	echo"<option value=\"moderator\""; if(isset($inp_user_rank) && $inp_user_rank == "moderator"){ echo" selected=\"selected\""; } echo">$l_moderator</option>\n";
	echo"<option value=\"editor\""; if(isset($inp_user_rank) && $inp_user_rank == "editor"){ echo" selected=\"selected\""; } echo">$l_editor</option>\n";
	echo"<option value=\"trusted\""; if(isset($inp_user_rank) && $inp_user_rank == "trusted"){ echo" selected=\"selected\""; } echo">$l_trusted</option>\n";
	echo"<option value=\"user\""; if(isset($inp_user_rank) && $inp_user_rank == "user"){ echo" selected=\"selected\""; } echo">$l_user</option>\n";
}
elseif($get_my_user_rank == "moderator"){
	echo"<option value=\"moderator\""; if(isset($inp_user_rank) && $inp_user_rank == "moderator"){ echo" selected=\"selected\""; } echo">$l_moderator</option>\n";
	echo"<option value=\"editor\""; if(isset($inp_user_rank) && $inp_user_rank == "editor"){ echo" selected=\"selected\""; } echo">$l_editor</option>\n";
	echo"<option value=\"trusted\""; if(isset($inp_user_rank) && $inp_user_rank == "trusted"){ echo" selected=\"selected\""; } echo">$l_trusted</option>\n";
	echo"<option value=\"user\""; if(isset($inp_user_rank) && $inp_user_rank == "user"){ echo" selected=\"selected\""; } echo">$l_user</option>\n";
}
echo"
</select>
</p>

<p>
<input type=\"submit\" value=\"$l_create_user\" class=\"btn btn-success btn-sm\" />
</p>
</form>

<!-- Go back -->
	<p>
	<a href=\"index.php?open=$open&amp;editor_language=$editor_language\"><img src=\"_design/gfx/icons/16x16/go-previous.png\" alt=\"go-previous.png\" /></a>
	<a href=\"index.php?open=$open&amp;editor_language=$editor_language\">$l_go_back</a>
	</p>
<!-- Go back -->
";
?>