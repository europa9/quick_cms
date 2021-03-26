<?php

/*- Check if setup is run ------------------------------------------------------------ */
$server_name = $_SERVER['HTTP_HOST'];
$server_name = clean($server_name);
$setup_finished_file = "setup_finished_" . $server_name . ".php";
if(file_exists("../_data/$setup_finished_file")){
	echo"Setup is finished.";
	die;
}

/*- Check if setup data exists ------------------------------------------------------- */
if(!(file_exists("../../_cache/setup_data.php"))){
	// Make setup data

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
	$inp_control_panel_url = str_replace("/setup/", "", $page_url);
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
	$inp_site_url = str_replace("/_admin/setup/", "", $page_url);
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


	// Database
	$inp_mysql_host = "$server_name";
	$inp_mysql_user_name = "root";
	$inp_mysql_password = "";
	$inp_mysql_database_name = "quick";
	$inp_mysql_prefix = "q_";

	// General
	$inp_site_title = "$server_name_ucfirst";
	$inp_site_title_clean = clean($inp_site_title);

	//

	$update_file="<?php
// Database
\$mysqlHostSav   	= \"$inp_mysql_host\";
\$mysqlUserNameSav   	= \"$inp_mysql_user_name\";
\$mysqlPasswordSav	= \"$inp_mysql_password\";
\$mysqlDatabaseNameSav 	= \"$inp_mysql_database_name\";
\$mysqlPrefixSav 	= \"$inp_mysql_prefix\";


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
\$configSiteDaysToKeepPageVisitsSav = \"730\";

// Test
\$configSiteIsTestSav = \"0\";

// Admin
\$adminEmailSav = \"\";
\$adminPasswordSav = \"\";

// Webdesign
\$webdesignSav = \"\";
?>";
	$fh = fopen("../../_cache/setup_data.php", "w+") or die("can not open file");
	fwrite($fh, $update_file);
	fclose($fh);

}


if($process == 1){
	$inp_language = $_POST['inp_language'];
	$inp_language = output_html($inp_language);
	
	// Header
	header("Location: index.php?page=02_licence&language=$inp_language");
	exit;
}

echo"
<h1>$l_select_language</h1>

<form method=\"post\" action=\"index.php?page=01_select_language&amp;process=1\" enctype=\"multipart/form-data\">

	
	<select name=\"inp_language\">
		";
		$path = "../_translations/admin/";
		if (is_dir($path)) {
			if ($dh = opendir($path)) {
				while (($file = readdir($dh)) !== false) {
					if($file != ".." && $file != "."){

						if(!(is_dir("../_translations/admin/$file/setup"))){
							mkdir("../_translations/admin/$file/setup");
						}

						if(!(file_exists("../_translations/admin/$file/setup/setup.php"))){
							$input="<?php \$l_form_option_language = \"Please edit ../_translations/admin/$file/setup/setup.php\"; ?>";
							$fh = fopen("../_translations/admin/$file/setup/setup.php", "w+") or die("can not open file");
							fwrite($fh, $input);
							fclose($fh);
						}

						include("../_translations/admin/$file/setup/setup.php");
						
						echo"<option value=\"$file\">$file</option>\n";

					}
				}
			}
		}
	echo"</select>

	<p>
	<input type=\"submit\" value=\"$l_next\" class=\"submit\" />
	</p>

</form>

";
?>

