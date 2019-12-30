<?php
/**
*
* File: _admin/_inc/settings/ssl.php
* Version 1.0.0
* Date 23:39 04.11.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Variables ------------------------------------------------------------------------- */
$tabindex = 0;



/*- Include SSL config --------------------------------------------------------------- */
$server_name = $_SERVER['HTTP_HOST'];
$server_name_saying = ucfirst($server_name);
$server_name = clean($server_name);

$ssl_config_file = "ssl_" . $server_name . ".php";
if(file_exists("_data/config/$ssl_config_file")){
	include("_data/config/$ssl_config_file");
}


if($process == "1"){
	// General
	$inp_ssl_active = $_POST['inp_ssl_active'];
	$inp_ssl_active = output_html($inp_ssl_active);

	$update_file="<?php
// General
\$configSLLActiveSav   	= \"$inp_ssl_active\";
?>";

	$fh = fopen("_data/config/$ssl_config_file", "w+") or die("can not open file");
	fwrite($fh, $update_file);
	fclose($fh);

	header("Location: index.php?open=$open&page=$page&editor_language=$editor_language&ft=success&fm=changes_saved");
	exit;
}

$tabindex = 0;
echo"
<h1>$l_ssl</h1>
<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;process=1\" enctype=\"multipart/form-data\">
				
	
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
		\$('[name=\"inp_owner_name\"]').focus();
	});
	</script>
<!-- //Focus -->

<p><b>$l_ssl_active:</b><br />
<input type=\"radio\" name=\"inp_ssl_active\" value=\"1\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\"";if(isset($configSLLActiveSav) && $configSLLActiveSav == "1"){ echo" checked=\"checked\"";}echo" />
$l_active 
&nbsp;
<input type=\"radio\" name=\"inp_ssl_active\" value=\"0\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\"";if(isset($configSLLActiveSav) && $configSLLActiveSav == "0"){ echo" checked=\"checked\"";}echo" />
$l_inactive
</p>
	
<p><input type=\"submit\" value=\"$l_save_changes\" class=\"submit\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>


</form>

";
?>