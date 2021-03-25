<?php
/**
*
* File: _admin/_inc/settings/logo.php
* Version 1.0.0
* Date 16:45 04.03.2018
* Copyright (c) 2008-2018 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['mode'])) {
	$mode = $_GET['mode'];
	$mode = strip_tags(stripslashes($mode));
}
else{
	$mode = "";
}
if(isset($_GET['type'])) {
	$type = $_GET['type'];
	$type = strip_tags(stripslashes($type));
}
else{
	$type = "";
}


if($action == ""){
	echo"
	<h1>$l_logo</h1>

	
	<!-- Feedback -->
	";
	if($ft != ""){
		if($fm == "changes_saved"){
			$fm = "$l_changes_saved";
		}
		else{
			$fm = ucfirst($fm);
		}
		echo"<div class=\"$ft\"><span>$fm</span></div>";
	}
	echo"	
	<!-- //Feedback -->


	<p>
	<a href=\"index.php?open=$open&amp;page=$page&amp;action=new_logo&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn btn_default\">$l_new_logo</a>
	</p>

	
	";

	// Show logo 
	if(file_exists("_data/logo.php")){
		include("_data/logo.php");




		echo"
		<p><b>$l_general</b><br />
		<img src=\"../$logoPathSav/$logoFileSav\" alt=\"$logoFileSav\" />
		</p>
		<p><b>$l_email</b><br />
		<img src=\"../$logoPathEmailSav/$logoFileEmailSav\" alt=\"$logoFileEmailSav\" />
		</p>
		<p><b>$l_pdf</b><br />
		<img src=\"../$logoPathPdfSav/$logoFilePdfSav\" alt=\"$logoFilePdfSav\" />
		</p>
		";
	}


}
elseif($action == "new_logo"){
	if(file_exists("_data/logo.php")){
		include("_data/logo.php");
	}


	if($mode == "upload"){
		// Get type
		$inp_type = $_POST['inp_type'];
		$inp_type = output_html($inp_type);

		// Sjekk filen
		$file_name = basename($_FILES['inp_image']['name']);
		$file_exp = explode('.', $file_name); 
		$file_type = $file_exp[count($file_exp) -1]; 
		$file_type = strtolower("$file_type");

		// Finnes mappen?
		$year = date("Y");
		$upload_path = "../_uploads/logo/";

		if(!(is_dir("../_uploads/"))){
			mkdir("../_uploads/");
		}
		if(!(is_dir("../_uploads/logo/"))){
			mkdir("../_uploads/logo/");
		}


		// Sett variabler
		$random = rand(0, 100);
		$new_name = $configWebsiteTitleCleanSav . "_" . $inp_type . "_" . $random . ".png";

		$target_path = $upload_path . "/" . $new_name;

		// Sjekk om det er en OK filendelse
		if($file_type == "jpg" OR $file_type == "png" OR $file_type == "gif"){
			if(move_uploaded_file($_FILES['inp_image']['tmp_name'], $target_path)) {

				// Sjekk om det faktisk er et bilde som er lastet opp
				$image_size = getimagesize($target_path);
				if(is_numeric($image_size[0]) && is_numeric($image_size[1])){

					// Image size
					list($width,$height) = getimagesize($target_path);


					// Dette bildet er OK
					
					if($inp_type == "general"){
						$input_logo_file="<?php
\$logoPathSav = \"_uploads/logo\";
\$logoFileSav = \"$new_name\";

\$logoPathEmailSav = \"$logoPathEmailSav\";
\$logoFileEmailSav = \"$logoFileEmailSav\";

\$logoPathPdfSav = \"$logoPathPdfSav\";
\$logoFilePdfSav = \"$logoFilePdfSav\";
?>";
					}
					elseif($inp_type == "email"){
						$input_logo_file="<?php
\$logoPathSav = \"$logoPathSav\";
\$logoFileSav = \"$logoFileSav\";

\$logoPathEmailSav = \"_uploads/logo\";
\$logoFileEmailSav = \"$new_name\";

\$logoPathPdfSav = \"$logoPathPdfSav\";
\$logoFilePdfSav = \"$logoFilePdfSav\";
?>";
					}
					if($inp_type == "pdf"){
						$input_logo_file="<?php
\$logoPathSav = \"$logoPathSav\";
\$logoFileSav = \"$logoFileSav\";

\$logoPathEmailSav = \"$logoPathEmailSav\";
\$logoFileEmailSav = \"$logoFileEmailSav\";

\$logoPathPdfSav = \"_uploads/logo\";
\$logoFilePdfSav = \"$new_name\";
?>";
					}

					$fh = fopen("_data/logo.php", "w") or die("can not open file");
					fwrite($fh, $input_logo_file);
					fclose($fh);


					$ft = "success";
					$fm = "logo_uploaded";
					$mode = "";
					//echo"
					//<meta http-equiv=refresh content=\"3; url=index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;ft=success&amp;fm=image_uploaded\">
					//";
					// $url = "index.php?open=$open&page=$page&editor_language=$editor_language&ft=success&fm=image_uploaded";
					// header("Location: $url");
					// exit;
					
				}
				else{
					// Dette er en fil som har fått byttet filendelse...
					unlink("$target_path");

					$ft = "error";
					$fm = "file_is_not_an_image";
					$mode = "";
				}
			}
			else{
   				switch ($_FILES['inp_image'] ['error']){
				case 1:
					$ft = "error";
					$fm = "to_big_file";
					$mode = "";
					break;
				case 2:
					$ft = "error";
					$fm = "to_big_file";
					$mode = "";
					break;
				case 3:
					$ft = "error";
					$fm = "only_parts_uploaded";
					$mode = "";
					break;
				case 4:
					$ft = "error";
					$fm = "no_file_uploaded";
					$mode = "";
					break;
				}
			} // if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
		}
		else{
			$ft = "error";
			$fm = "invalid_file_type";
			$mode = "";
		}
	}
	if($mode == ""){
		echo"
		<h1>$l_new_logo</h1>

		<!-- You are here -->
			<p>
			<b>$l_you_are_here:</b><br />
			<a href=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">$l_logo</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=new_logo&amp;editor_language=$editor_language&amp;l=$l\">$l_new_logo</a>
			</p>
		<!-- //You are here -->

		<!-- Feedback -->
		";
		if($ft != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			else{
				$fm = str_replace("_", " ", $fm);
				$fm = ucfirst($fm);
			}
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
		<!-- //Feedback -->


		<!-- Form -->
		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;editor_language=$editor_language&amp;mode=upload&amp;l=$l\" enctype=\"multipart/form-data\">
	

		<p><b>$l_new_image:</b><br />
		<input type=\"file\" name=\"inp_image\" />
		</p>

		<p><b>$l_type:</b><br />
		<select name=\"inp_type\">
			<option value=\"general\">$l_general</option>
			<option value=\"email\">$l_email</option>
			<option value=\"pdf\">$l_pdf</option>
		</select>
		</p>



		<p>
		<input type=\"submit\" value=\"$l_upload\" class=\"submit\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
		</p>
	
			
		</form>

		<!-- //Form -->
		";
	} // mode == upload
} // action == "new logo
?>