<?php
/**
*
* File: _admin/_inc/ucp/default_free_text.php
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



/*- Include user ---------------------------------------------------------------------- */
$user_id = $_SESSION['fl_website_user_id'];
include("_data/users/$user_id.php");


/*- Dir exists? ----------------------------------------------------------------------- */
if(!(is_dir("_data/users_free_text"))){
	mkdir("_data/users_free_text");
}

if($process == "1"){
	$inp_free_text   = $_POST['inp_free_text'];
	$inp_free_text    = output_html($inp_free_text);

	if($inp_free_text == ""){
		if(file_exists("_data/users_free_text/$user_id.txt")){
			unlink("_data/users_free_text/$user_id.txt");
		}
	}
	else{
		$fh = fopen("_data/users_free_text/$user_id.txt", "w+") or die("can not open file");
		fwrite($fh, $inp_free_text);
		fclose($fh);
	}

	header("Location: ?open=ucp&page=default&sub=free_text&focus=inp_free_text&ft=success&fm=Informasjonen ble lagret.");
	exit;
	
}

echo"
<h2>Fritekst</h2>
<form method=\"post\" action=\"?open=ucp&amp;page=default&amp;sub=free_text&amp;process=1\" enctype=\"multipart/form-data\" name=\"nameform\">
				
	
<!-- Feedback -->
";
if($ft != ""){
	echo"<div class=\"$ft\"><span>$fm</span></div>";
}
echo"	
<!-- //Feedback -->

<p>
<textarea name=\"inp_free_text\" rows=\"30\" cols=\"80\">";
if(file_exists("_data/users_free_text/$user_id.txt")){
	$fh = fopen("_data/users_free_text/$user_id.txt", "r");
	$data = fread($fh, filesize("_data/users_free_text/$user_id.txt"));
	fclose($fh);
	$data = str_replace("<br />", "\n", $data);
	echo"$data";
}

echo"</textarea>
</p>

<p><input type=\"submit\" value=\"Send skjema\" class=\"btn btn-success btn-sm\" tabindex=\"3\" /></p>
</form>

";
?>