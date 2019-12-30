<?php

/*- Check if setup is run ------------------------------------------------------------ */
$server_name = $_SERVER['HTTP_HOST'];
$server_name = clean($server_name);
$setup_finished_file = "setup_finished_" . $server_name . ".php";
if(file_exists("../_data/$setup_finished_file")){
	echo"Setup is finished.";
	die;
}

/*- Translations --------------------------------------------------------------------- */
include("../_translations/admin/$language/settings/t_ssl.php");


/*- Include SSL config --------------------------------------------------------------- */
$server_name = $_SERVER['HTTP_HOST'];
$server_name_saying = ucfirst($server_name);
$server_name = clean($server_name);

$ssl_config_file = "ssl_" . $server_name . ".php";
if(file_exists("../_data/config/$ssl_config_file")){
	include("../_data/config/$ssl_config_file");
}
else{
	$configSLLActiveSav = "0";
}



/*- Variables ------------------------------------------------------------------------ */
$tabindex = 0;


if($process == "1"){
	$inp_site_title = $_POST['inp_site_title'];
	$inp_site_title = output_html($inp_site_title);

	$inp_site_title_clean = clean($inp_site_title);
		
	// Website config
	$year = date("Y");
	$server_name = $_SERVER['SERVER_NAME'];
	$server_name_ucfirst = ucfirst($server_name);

	// Email
	$host = $_SERVER['HTTP_HOST'];
	$inp_from_email = "post@" . $_SERVER['HTTP_HOST'];


	// Page URL
	$server_name = "http://" . $_SERVER["SERVER_NAME"];
	$request_uri = $_SERVER["REQUEST_URI"];

	$pageURL = $server_name.$request_uri;
	$inp_control_panel_url = str_replace("/setup/index.php?page=04_site&language=$language&process=1", "", $pageURL);
	$inp_site_url = str_replace("/_admin", "", $inp_control_panel_url);
	$inp_site_url_len = strlen($inp_site_url);

	$inp_site_url_request_uri = str_replace("/setup/index.php?page=04_site&language=$language&process=1", "$request_uri", $inp_site_url);
	$inp_site_url_request_uri = str_replace("$server_name", "", $inp_site_url_request_uri);

	$input_meta="<?php
	// General
	\$configWebsiteTitleSav		 = \"$inp_site_title\";
	\$configWebsiteTitleCleanSav	 = \"$inp_site_title_clean\";
	\$configWebsiteCopyrightSav	 = \"Copyright (c) $year $server_name_ucfirst\";
	\$configFromEmailSav 		 = \"$inp_from_email\";
	\$configFromNameSav 		 = \"$inp_site_title\";

	\$configWebsiteVersionSav	= \"1.0.0\";

	// Webmaster
	\$configWebsiteWebmasterSav	 = \"\";
	\$configWebsiteWebmasterEmailSav = \"\";

	// URLs

	\$configSiteURLSav 		= \"$inp_site_url\";
	\$configSiteURLLenSav 		= \"$inp_site_url_len\";

	\$configSiteURLAlternativeASav			= \"\";
	\$configSiteURLAlternativeALenSav		= \"\";

	\$configSiteURLAlternativeBSav			= \"\";
	\$configSiteURLAlternativeBLenSav		= \"\";

	\$configSiteURLAlternativeCSav			= \"\";
	\$configSiteURLAlternativeCLenSav		= \"\";

	\$configControlPanelURLSav 	= \"$inp_control_panel_url\";

	// Statisics
	\$configSiteUseGethostbyaddrSav = \"1\";

	// Test
	\$configSiteIsTestSav = \"0\";
	?>";

	// Directory
	if(!(is_dir("../_data/config/"))){ mkdir("../_data/config/"); } 
	$fh = fopen("../_data/config/meta.php", "w+") or die("can not open file");
	fwrite($fh, $input_meta);
	fclose($fh);


	$input_users_config="<?php
	// Users
	\$configUsersCanRegisterSav   = \"1\";
	\$configUsersAvatarWidthSav   = \"80\";
	\$configUsersAvatarHeightSav  = \"80\";
	\$configUsersPictureWidthSav  = \"600\";
	\$configUsersPictureHeightSav = \"450\";
	\$configUsersAllowedMailAddressesSav = \"\";
	\$configUsersEmailVerificationSav = \"1\";
	\$configUsersHasToBeVerifiedByModeratorSav 	= \"0\";
	?>";

	$fh = fopen("../_data/config/user_system.php", "w+") or die("can not open file");
	fwrite($fh, $input_users_config);
	fclose($fh);


	$input_logo_config="<?php
\$logoPathSav = \"_admin/_design/gfx\";
\$logoFileSav = \"nettport.png\";

\$logoPathEmailSav = \"_admin/_design/gfx\";
\$logoFileEmailSav = \"nettport.png\";

\$logoPathPdfSav = \"_admin/_design/gfx\";
\$logoFilePdfSav = \"nettport.png\";
?>";

	$fh = fopen("../_data/logo.php", "w+") or die("can not open file");
	fwrite($fh, $input_logo_config);
	fclose($fh);



	$update_file="<?php
\$webdesignSav 	 = \"default\";
?>";

	$fh = fopen("../_data/webdesign.php", "w+") or die("can not open file");
	fwrite($fh, $update_file);
	fclose($fh);

	

	// SSL
	$inp_ssl_active = $_POST['inp_ssl_active'];
	$inp_ssl_active = output_html($inp_ssl_active);

	$update_file="<?php
// General
\$configSLLActiveSav   	= \"$inp_ssl_active\";
?>";

	$fh = fopen("../_data/config/$ssl_config_file", "w+") or die("can not open file");
	fwrite($fh, $update_file);
	fclose($fh);



	// Move to administrator setup
	header("Location: index.php?page=05_administrator&language=$language");
	exit;

}

echo"
<h1>$l_site</h1>


<!-- Focus -->
	<script>
	\$(document).ready(function(){
		\$('[name=\"inp_site_title\"]').focus();
	});
	</script>
<!-- //Focus -->


<!-- Site form -->
	<form method=\"post\" action=\"index.php?page=04_site&amp;language=$language&amp;process=1\" enctype=\"multipart/form-data\">

	<!-- Error -->
		";
		if(isset($ft) && isset($fm)){
			echo"<div class=\"error\"><p>$fm</p></div>";
		}
		echo"
	<!-- //Error -->

	<p><b>$l_site_title:</b><br />
	<input type=\"text\" name=\"inp_site_title\" value=\""; if(isset($inp_site_title)){ echo"$inp_site_title"; } 
	else{ 
		$server_name = $_SERVER['HTTP_HOST'];
		$server_name = output_html($server_name);
		$server_name = ucfirst($server_name);
		echo"$server_name"; 
	} 
	echo"\" size=\"35\" tabindex=\"1\" /></p>



	<p><b>$l_ssl_active:</b><br />
	<input type=\"radio\" name=\"inp_ssl_active\" value=\"1\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\"";if(isset($configSLLActiveSav) && $configSLLActiveSav == "1"){ echo" checked=\"checked\"";}echo" />
	$l_active 
	&nbsp;
	<input type=\"radio\" name=\"inp_ssl_active\" value=\"0\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\"";if(isset($configSLLActiveSav) && $configSLLActiveSav == "0"){ echo" checked=\"checked\"";}echo" />
	$l_inactive
	</p>

	<p>
	<input type=\"submit\" value=\"$l_next\" class=\"submit\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
	</p>

	</form>

<!-- //Site form -->
";
?>
