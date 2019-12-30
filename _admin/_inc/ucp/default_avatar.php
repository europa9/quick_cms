<?php
/**
*
* File: _admin/_inc/ucp/default_avatar.php
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


if($process == "1"){
	// Sjekk filen
	$fileName = basename($_FILES['inp_file']['name']);
	$fileExp = explode('.', $fileName); 
	$fileType = $fileExp[count($fileExp) -1]; 
	$fileType = strtolower("$fileType");

	// Finnes mappen?
	$ImagePath = "_data/users_avatars";
	if(!(is_dir("$ImagePath"))){
		mkdir("$ImagePath");
	}

	// Include myself
	$user_id = $_SESSION['fl_website_user_id'];
	include("_data/users/$user_id.php");

	// Gi et bra filnavn
	$NewName = str_replace("$fileType", "", $fileName);
	$NewName = strtolower($NewName);
	$NewName = str_replace("ô", "o", "$NewName");
	$NewName = str_replace("é", "e", "$NewName");
	$NewName = str_replace("ã", "a", "$NewName");
	$NewName = str_replace("í", "i", "$NewName");
	$NewName = str_replace("&#39;", "", "$NewName");
	$NewName = str_replace(" ", "_", "$NewName");
	$NewName = str_replace("æ", "ae", "$NewName");
	$NewName = str_replace("ø", "o", "$NewName");
	$NewName = str_replace("å", "aa", "$NewName");
	$NewName = str_replace("Æ", "AE", "$NewName");
	$NewName = str_replace("Ø", "O", "$NewName");
	$NewName = str_replace("Å", "AA", "$NewName");
	$NewName = str_replace("!", "", "$NewName");
	$NewName = str_replace("(", "", "$NewName");
	$NewName = str_replace(")", "", "$NewName");
	$NewName = str_replace(".", "", "$NewName");
	$NewName = str_replace("/", "_", "$NewName");
	$NewName = str_replace("#", "_", "$NewName");
	$NewName = str_replace(",", "_", "$NewName");
	$NewName = str_replace("+", "_", "$NewName");
	$NewName = str_replace(":", "_", "$NewName");
	$NewName = str_replace(";", "_", "$NewName");
	$NewName = htmlspecialchars("$NewName");

	$random  = rand(0,1000);
	$NewName = $user_id . "-" . $random;
	

	// Sett variabler
	$TargetPath = $ImagePath . "/" . $NewName . "." . $fileType;
	$ThumbPath  = $ImagePath . "/" . $NewName . "-thumb." . $fileType; 

	// Sjekk om det er en OK filendelse
	if($fileType == "jpg" OR $fileType == "png" OR $fileType == "gif"){
		$FileTypeCheck = "1";
	}
	else{
		if($fileType != ""){
			header("Location: ?open=ucp&page=default&sub=avatar&focus=inp_file&ft=error&fm=Ugyldig filtype $fileType");
			exit;
		}
		else{
			header("Location: ?open=ucp&page=default&sub=avatar&focus=inp_file&ft=warning&fm=Du valgte å ikke laste opp et bilde");
			exit;
		}
	}

	if($FileTypeCheck == "1"){
		if(move_uploaded_file($_FILES['inp_file']['tmp_name'], $TargetPath)) {

			// Sjekk om det faktisk er et bilde som er lastet opp
			$ImageSize = getimagesize($TargetPath);
			if(is_numeric($ImageSize[0]) && is_numeric($ImageSize[1]) && $ImageSize[2] !=""){
				// Dette bildet er OK


				// Opprett THUMB

				// Orginal størrelse
				$orig_x = "$ImageSize[0]";
				$orig_y = "$ImageSize[1]";
 
				
				if($orig_x == "$configUsersAvatarWidthSav" && $orig_y == "$configUsersAvatarHeightSav"){
					copy($TargetPath, $ThumbPath);
				}
				else{
					// Load image
					$thumb = imagecreatetruecolor($configUsersAvatarWidthSav, $configUsersAvatarHeightSav);
					if($fileType == "jpg"){
						$source = imagecreatefromjpeg($TargetPath);
					}
					elseif($fileType == "png"){
						$source = ImageCreateFromPNG($TargetPath);
					}
					elseif($fileType == "gif"){
						$source = ImageCreateFromGif($TargetPath);
					}

					// Resize
					imagecopyresized($thumb, $source, 0, 0, 0, 0, $configUsersAvatarWidthSav, $configUsersAvatarHeightSav, $orig_x, $orig_y);


					// save thumbnail into a file
					if($fileType == "jpg"){
						imagejpeg($thumb, "$ThumbPath", 100);
					}
					elseif($fileType == "png"){
						imagepng($thumb, "$ThumbPath");
					}
					elseif($fileType == "gif"){
						imagegif($thumb, "$ThumbPath", 100);
					}
				}

				// Finnes det et gammelt bilde?
				if(file_exists("$userAvatarSav") && $userAvatarSav != ""){
					unlink("$userAvatarSav");
				}


				// Nå er vi garantert riktig størrelse, slett orginalt
				// og gi nytt navn til thumb.
				$new_path = $ImagePath . "/" . $user_id . "." . $fileType;
				unlink("$TargetPath");
				rename("$ThumbPath", $new_path);

				// Put into user-file
				$input="<?php 
\$userAvatarSav		= \"$new_path\"; ?>";
				
				$fh = fopen("_data/users/$user_id.php", "a+") or die("can not open file");
				fwrite($fh, $input);
				fclose($fh);

				header("Location: ?open=ucp&page=default&sub=avatar&ft=success&fm=Bilde lastet opp.");
				exit;
			}
			else{
				// Dette er en fil som har fått byttet filendelse...
				unlink("$TargetPath");

				header("Location: ?open=ucp&page=default&sub=avatar&focus=inp_file&ft=error&fm=Ugyldig filtype!!");
				exit;
			}
		}
		else{
   			switch ($_FILES['inp_file'] ['error']){
				case 1:
					header("Location: ?open=ucp&page=default&sub=avatar&focus=inp_file&ft=error&fm=Filen er større enn denne PHP installasjonen tillater");
					exit;
					break;
				case 2:
					header("Location: ?open=ucp&page=default&sub=avatar&focus=inp_file&ft=error&fm=Filen er større enn dette skjemaet tillater");
					exit;
					break;
				case 3:
					header("Location: ?open=ucp&page=default&sub=avatar&focus=inp_file&ft=error&fm=Kun deler av filen var lastet opp");
					exit;
					break;
				case 4:
					header("Location: ?open=ucp&page=default&sub=avatar&focus=inp_file&ft=warning&fm=Ingen fil ble lastet opp");
					exit;
					break;
			}
		}
	}
	
}

echo"
<h2>Avatar</h2>
<form method=\"post\" action=\"?open=ucp&amp;page=default&amp;sub=avatar&amp;process=1\" enctype=\"multipart/form-data\" name=\"nameform\">
				
	
<!-- Feedback -->
";
if($ft != ""){
	echo"<div class=\"$ft\"><span>$fm</span></div>";
}
echo"	
<!-- //Feedback -->

<table>
 <tr>
  <td style=\"";if(file_exists("$userAvatarSav") && $userAvatarSav != ""){ echo"padding: 0px 24px 0px 0px;";}echo"vertical-align:top;\">
	";
	if(file_exists("$userAvatarSav") && $userAvatarSav != ""){
		echo"
		<h3>Din avatar</h3>
		<p><img src=\"$userAvatarSav\" alt=\"$userAvatarSav\" /></p>";
	}
	echo"
  </td>
  <td style=\"padding: 0px 4px 0px 0px;vertical-align:top;\">
	<h3>Ny avatar</h3>

	<p>Du kan laste opp bilder av typen jpg, png og gif. Størrelsen på avataren må være $configUsersAvatarWidthSav";echo"x$configUsersAvatarHeightSav piksler.</p>

	<form method=\"POST\" action=\"php_avansert_bildeopplastning.php?imgupload=1\" enctype=\"multipart/form-data\">

	<table>
	 <tr>
	  <td style=\"padding: 3px 5px 0px 0px;vertical-align:top;\">
		<p>
		<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"200000000\" />
		<input name=\"inp_file\" type=\"file\" /> 
		</p>
	  </td>
	  <td style=\"padding: 0px 0px 0px 0px;vertical-align:top;\">
		<p><input type=\"submit\" value=\"Send skjema\" class=\"btn btn-success btn-sm\" tabindex=\"3\" /></p>
	  </td>
	 </tr>
	</table>
	</form>
  </td>
 </tr>
</table>


</form>

";
?>