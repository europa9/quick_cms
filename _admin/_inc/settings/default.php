<?php
/**
*
* File: _admin/_inc/settings/default.php
* Version 02:10 28.12.2011
* Copyright (c) 2008-2012 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}




if($process == "1"){
	$inp_website_title = $_POST['inp_website_title'];
	$inp_website_title = output_html($inp_website_title);

	$inp_website_title_clean = clean($inp_website_title);

	$inp_website_webmaster = $_POST['inp_website_webmaster'];
	$inp_website_webmaster = output_html($inp_website_webmaster);

	$inp_website_webmaster_email = $_POST['inp_website_webmaster_email'];
	$inp_website_webmaster_email = output_html($inp_website_webmaster_email);

	$inp_website_copyright = $_POST['inp_website_copyright'];
	$inp_website_copyright = output_html($inp_website_copyright);

	$inp_from_email = $_POST['inp_from_email'];
	$inp_from_email = output_html($inp_from_email);

	$inp_from_name = $_POST['inp_from_name'];
	$inp_from_name = output_html($inp_from_name);

	$inp_website_version = $_POST['inp_website_version'];
	$inp_website_version = output_html($inp_website_version);



	// CP URL
	$inp_control_panel_url = $_POST['inp_control_panel_url'];
	$inp_control_panel_url = output_html($inp_control_panel_url);

	// Website URL
	$inp_site_url = $_POST['inp_site_url'];
	$inp_site_url = output_html($inp_site_url);

	$inp_site_url_len = strlen($inp_site_url);

	// Website URL  Alernative 
	$inp_site_url_alternative_a = $_POST['inp_site_url_alternative_a'];
	$inp_site_url_alternative_a = output_html($inp_site_url_alternative_a);
	$inp_site_url_alternative_a_len = strlen($inp_site_url_alternative_a);

	$inp_site_url_alternative_b = $_POST['inp_site_url_alternative_b'];
	$inp_site_url_alternative_b = output_html($inp_site_url_alternative_b);
	$inp_site_url_alternative_b_len = strlen($inp_site_url_alternative_b);

	$inp_site_url_alternative_c = $_POST['inp_site_url_alternative_c'];
	$inp_site_url_alternative_c = output_html($inp_site_url_alternative_c);
	$inp_site_url_alternative_c_len = strlen($inp_site_url_alternative_c);

	// Statisics
	$inp_site_use_gethostbyaddr = $_POST['inp_site_use_gethostbyaddr'];
	$inp_site_use_gethostbyaddr = output_html($inp_site_use_gethostbyaddr);
	
	// Test
	$inp_site_is_test = $_POST['inp_site_is_test'];
	$inp_site_is_test = output_html($inp_site_is_test);

	$update_file="<?php
// General
\$configWebsiteTitleSav		 = \"$inp_website_title\";
\$configWebsiteTitleCleanSav	 = \"$inp_website_title_clean\";
\$configWebsiteCopyrightSav	 = \"$inp_website_copyright\";
\$configFromEmailSav 		 = \"$inp_from_email\";
\$configFromNameSav 		 = \"$inp_from_name\";

\$configWebsiteVersionSav	= \"$inp_website_version\";

// Webmaster
\$configWebsiteWebmasterSav	 = \"$inp_website_webmaster\";
\$configWebsiteWebmasterEmailSav = \"$inp_website_webmaster_email\";

// URLS
\$configSiteURLSav 			= \"$inp_site_url\";
\$configSiteURLLenSav 		 	= \"$inp_site_url_len\";

\$configSiteURLAlternativeASav		= \"$inp_site_url_alternative_a\";
\$configSiteURLAlternativeALenSav	= \"$inp_site_url_alternative_a_len\";

\$configSiteURLAlternativeBSav		= \"$inp_site_url_alternative_b\";
\$configSiteURLAlternativeBLenSav	= \"$inp_site_url_alternative_b_len\";

\$configSiteURLAlternativeCSav		= \"$inp_site_url_alternative_c\";
\$configSiteURLAlternativeCLenSav	= \"$inp_site_url_alternative_c_len\";

\$configControlPanelURLSav 	 = \"$inp_control_panel_url\";

// Statisics
\$configSiteUseGethostbyaddrSav = \"$inp_site_use_gethostbyaddr\";

// Test
\$configSiteIsTestSav = \"$inp_site_is_test\";
?>";

	$fh = fopen("_data/config/meta.php", "w+") or die("can not open file");
	fwrite($fh, $update_file);
	fclose($fh);

	header("Location: ?open=settings&page=default&focus=inp_website_title&ft=success&fm=changes_saved");
	exit;
}

$tabindex = 0;
echo"
<h1>$l_meta_data</h1>
<form method=\"post\" action=\"?open=settings&amp;page=default&amp;process=1\" enctype=\"multipart/form-data\">
				
	
<!-- Feedback -->
";
if($ft != ""){
	if($fm == "changes_saved"){
		$fm = "$l_changes_saved";
	}
	else{
		$fm = ucfirst($ft);
	}
	echo"<div class=\"$ft\"><span>$fm</span></div>";
}
echo"	
<!-- //Feedback -->

<!-- Focus -->
	<script>
	\$(document).ready(function(){
		\$('[name=\"inp_website_title\"]').focus();
	});
	</script>
<!-- //Focus -->

<h2>General</h2>
	<p>$l_website_title:<br />
	<input type=\"text\" name=\"inp_website_title\" value=\"$configWebsiteTitleSav\" size=\"50\" tabindex=\""; $tabindex=0; $tabindex=$tabindex+1;echo"$tabindex\" /></p>

	<p>$l_website_copyright:<br />
	<input type=\"text\" name=\"inp_website_copyright\" value=\"$configWebsiteCopyrightSav\" size=\"50\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>

	<p>Website E-mail address (used for sending e-mails):<br />
	<input type=\"text\" name=\"inp_from_email\" value=\"$configFromEmailSav\" size=\"50\" tabindex=\""; $tabindex=$tabindex+1;echo"$tabindex\" /></p>

	<p>Website from name:<br />
	<input type=\"text\" name=\"inp_from_name\" value=\"$configFromNameSav\" size=\"50\" tabindex=\""; $tabindex=$tabindex+1;echo"$tabindex\" /></p>

	<p>Website version:<br />
	<input type=\"text\" name=\"inp_website_version\" value=\"$configWebsiteVersionSav\" size=\"50\" tabindex=\""; $tabindex=$tabindex+1;echo"$tabindex\" /></p>

<h2>Webmaster</h2>

	<p>$l_webmaster_name:<br />
	<input type=\"text\" name=\"inp_website_webmaster\" value=\"$configWebsiteWebmasterSav\" size=\"50\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>


	<p>$l_webmaster_email:<br />
	<input type=\"text\" name=\"inp_website_webmaster_email\" value=\"$configWebsiteWebmasterEmailSav\" size=\"50\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>

<h2>URLs</h2>

	<p>$l_site_url:<br />
	<input type=\"text\" name=\"inp_site_url\" value=\"$configSiteURLSav\" size=\"30\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>

	<p>Website alternative URL:<br />
	<input type=\"text\" name=\"inp_site_url_alternative_a\" value=\"$configSiteURLAlternativeASav\" size=\"30\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /><br />
	<input type=\"text\" name=\"inp_site_url_alternative_b\" value=\"$configSiteURLAlternativeBSav\" size=\"30\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /><br />
	<input type=\"text\" name=\"inp_site_url_alternative_c\" value=\"$configSiteURLAlternativeCSav\" size=\"30\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /><br />
	</p>

	<p>$l_control_panel_url:<br />
	<input type=\"text\" name=\"inp_control_panel_url\" value=\"$configControlPanelURLSav\" size=\"50\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>

<h2>Statistics</h2>

	<p>Use gethostbyaddr<br />
	<input type=\"radio\" name=\"inp_site_use_gethostbyaddr\" value=\"1\""; if($configSiteUseGethostbyaddrSav == "1"){ echo" checked=\"checked\""; } echo" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /> Yes
	&nbsp;
	<input type=\"radio\" name=\"inp_site_use_gethostbyaddr\" value=\"0\""; if($configSiteUseGethostbyaddrSav == "0"){ echo" checked=\"checked\""; } echo" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /> No
	</p>

<h2>Test mode</h2>

	<p>Site is test-site<br />
	<input type=\"radio\" name=\"inp_site_is_test\" value=\"1\""; if($configSiteIsTestSav == "1"){ echo" checked=\"checked\""; } echo" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /> Yes
	&nbsp;
	<input type=\"radio\" name=\"inp_site_is_test\" value=\"0\""; if($configSiteIsTestSav == "0"){ echo" checked=\"checked\""; } echo" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /> No
	</p>
	

	<p><input type=\"submit\" value=\"$l_save_changes\" class=\"btn\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>

</form>

";
?>