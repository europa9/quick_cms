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
	$page_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$page_url = htmlspecialchars($page_url, ENT_QUOTES, 'UTF-8');

	// Control panel URL
	$inp_control_panel_url = str_replace("/setup/index.php?page=04_site&amp;language=$language&amp;process=1", "", $page_url);
	$inp_control_panel_url_len = strlen($inp_control_panel_url);

	$control_panel_url_parsed = parse_url($inp_control_panel_url);
	$inp_control_panel_url_scheme = $control_panel_url_parsed['scheme'];
	$inp_control_panel_url_host = $control_panel_url_parsed['host'];
	if(isset($control_panel_url_parsed['port'])){
		$inp_control_panel_url_port = $control_panel_url_parsed['port'];
	}
	else{
		$inp_control_panel_url_port = "";
	}
	$inp_control_panel_url_path = $control_panel_url_parsed['path'];



	// Site URL
	$inp_site_url = str_replace("/_admin/setup/index.php?page=04_site&amp;language=$language&amp;process=1", "", $page_url);
	$inp_site_url_len = strlen($inp_site_url);


	$site_url_parsed = parse_url($inp_site_url);
	$inp_site_url_scheme = $site_url_parsed['scheme'];
	$inp_site_url_host = $site_url_parsed['host'];
	if(isset($site_url_parsed['port'])){
		$inp_site_url_port = $site_url_parsed['port'];
	}
	else{
		$inp_site_url_port = "";
	}
	if(isset($site_url_parsed['path'])){
		$inp_site_url_path = $site_url_parsed['path'];
	}
	else{
		$inp_site_url_path = "";
	}

	$input_meta="<?php
	// General
	\$configWebsiteTitleSav		 = \"$inp_site_title\";
	\$configWebsiteTitleCleanSav	 = \"$inp_site_title_clean\";
	\$configWebsiteCopyrightSav	 = \"Copyright (c) $year $server_name_ucfirst\";
	\$configFromEmailSav 		 = \"$inp_from_email\";
	\$configFromNameSav 		 = \"$inp_site_title\";

	\$configWebsiteVersionSav	= \"1.0.0\";
	\$configMailSendActiveSav	= \"1\";

	// Webmaster
	\$configWebsiteWebmasterSav	 = \"\";
	\$configWebsiteWebmasterEmailSav = \"\";

	// URLs
	\$configSiteURLSav 		= \"$inp_site_url\";
	\$configSiteURLLenSav 		= \"$inp_site_url_len\";
	\$configSiteURLSchemeSav	= \"$inp_site_url_scheme\";
	\$configSiteURLHostSav		= \"$inp_site_url_host\";
	\$configSiteURLPortSav		= \"$inp_site_url_port\";
	\$configSiteURLPathSav		= \"$inp_site_url_path\";

	\$configControlPanelURLSav 		= \"$inp_control_panel_url\";
	\$configControlPanelURLLenSav 		= \"$inp_control_panel_url_len\";
	\$configControlPanelURLSchemeSav	= \"$inp_control_panel_url_scheme\";
	\$configControlPanelURLHostSav		= \"$inp_control_panel_url_host\";
	\$configControlPanelURLPortSav		= \"$inp_control_panel_url_port\";
	\$configControlPanelURLPathSav		= \"$inp_control_panel_url_path\";

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

	// Search index
	\$configShowUsersOnSearchEngineIndexSav   		= \"0\";
	\$configIncludeFirstNameLastNameOnSearchEngineIndexSav	= \"0\";
	\$configIncludeProfessionalOnSearchEngineIndexSav	= \"0\";

	// View profile
	\$configViewProfileIncludeFirstNameLastNameSav   	= \"0\";
	\$configViewProfileIncludeProfessionalSav   		= \"0\";
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

	<p>
	<input type=\"submit\" value=\"$l_next\" class=\"submit\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
	</p>

	</form>

<!-- //Site form -->
";
?>
