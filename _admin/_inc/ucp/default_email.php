<?php
/**
*
* File: _admin/_inc/ucp/default_email.php
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
	$inp_mail = $_POST['inp_mail'];
	$inp_mail = output_html($inp_mail);
	$inp_mail = strtolower($inp_mail);

	if($inp_mail == ""){
		header("Location: ?open=ucp&page=default&sub=email&focus=inp_mail&ft=error&fm=Hvis du ønsker å bytte e-postadresse må du anngi din nye adresse i feltet.");
		exit;
	}
	else{
		// Do someone else have this e-mail? We dont want any duplicates!
		$filenames = "";
		$dir = "_data/users/";
		$dirLen = strlen($dir);
		$dp = @opendir($dir);

		while($file = @readdir($dp)) $filenames [] = $file;
		for ($i = 0; $i < count($filenames); $i++){
			@rsort($filenames);
			$content = $filenames[$i];
			$file_path = "$dir$content";
			
			if($file_path != "_data/users/.." && $file_path != "_data/users/." && $file_path != "_data/users/index.html" && $file_path != "_data/users/user_counter.dat"){
				include("$file_path");

				if($userEmailSav == "$inp_mail"){
					// We have found a duplicate
					$user_id = $_SESSION['fl_website_user_id'];
					if($userIdSav == "$user_id"){
						// No actual changes...
						header("Location: ?open=ucp&page=default&sub=email&focus=inp_mail&ft=success&fm=Ingen endringer.");
						exit;
					}
					else{
						// No actual changes...
						header("Location: ?open=ucp&page=default&sub=email&focus=inp_mail&ft=warning&fm=Beklager, e-postadressen er allerde i bruk.");
						exit;
					}
				}
			}
		}


		// We have no duplicates and can save		
		$user_id = $_SESSION['fl_website_user_id'];
		include("_data/users/$user_id.php");

		$inp_last_seen_date = date("Y-m-d H:i:s");
		$inp_last_seen_time = time();

		$update_file="<?php
// Created by default_email.php
// user-file verision: 1.4

// Genreal
\$userIdSav		= \"$userIdSav\";
\$userTypeSav		= \"$userTypeSav\";
\$userYmdhisSav		= \"$userYmdhisSav\";
\$userAliasSav		= \"$userAliasSav\";
\$userAliasCleanSav	= \"$userAliasCleanSav\";
\$userEmailSav		= \"$inp_mail\";
\$userFirstNameSav	= \"$userFirstNameSav\";
\$userMiddleNameSav	= \"$userMiddleNameSav\";
\$userLastNameSav	= \"$userLastNameSav\";

// Time and dates
\$userRegisteredDateSav = \"$userRegisteredDateSav\";
\$userRegisteredTimeSav = \"$userRegisteredTimeSav\";
\$userLastSeenDateSav 	= \"$inp_last_seen_date\";
\$userLastSeenTimeSav 	= \"$inp_last_seen_time\";
\$userBirthdaySav 	= \"$userBirthdaySav\";
\$userTimeZoneSav	= \"$userTimeZoneSav\";
\$userHaveSummerTimeSav	= \"$userHaveSummerTimeSav\";

// Security
\$userPasswordSav 	= \"$userPasswordSav\";
\$userSaltSav 	  	= \"$userSaltSav\";
\$userIpSav 		= \"$userIpSav\";
\$userHostByAddrSav	= \"$userHostByAddrSav\";
\$userPermissionsSav	= \"$userPermissionsSav\";
\$userLoginAttemptsSav	= \"$userLoginAttemptsSav\";

// Groups
\$userGroupsSav		= \"$userGroupsSav\";

// Forums
\$userLastpostTimeSav	= \"$userLastpostTimeSav\";
\$userPostsSav		= \"$userPostsSav\";
\$userSignatureSav	= \"$userSignatureSav\";
	
// Private messages
\$userMessagesUnreadSav	= \"$userMessagesUnreadSav\";

// Misc
\$userLanguageSav	= \"$userLanguageSav\";

// Avatar and picture
\$userAvatarSav		= \"$userAvatarSav\";
\$userPictureSav	= \"$userPictureSav\";
\$userPictureThumbSav	= \"$userPictureThumbSav\";

// About
\$userBusinessSav	 = \"$userBusinessSav\";
\$userAddressNameSav	 = \"$userAddressNameSav\";
\$userAddressASav	 = \"$userAddressASav\";
\$userAddressBSav	 = \"$userAddressBSav\";
\$userZipSav		 = \"$userZipSav\";
\$userCitySav		 = \"$userCitySav\";
\$userMunicipalitySav	 = \"$userMunicipalitySav\";
\$userCountySav		 = \"$userCountySav\";
\$userCountrySav	 = \"$userCountrySav\";
\$userAreaCodeSav	 = \"$userAreaCodeSav\";
\$userMobileNumberSav	 = \"$userMobileNumberSav\";
\$userMessengerSav	 = \"$userMessengerSav\";
\$userSocialMediaLinkSav = \"$userSocialMediaLinkSav\";
\$userSocialMediaNameSav = \"$userSocialMediaNameSav\";
\$userWebLinkSav   	 = \"$userWebLinkSav\";
\$userWebNameSav   	 = \"$userWebNameSav\";
\$userOccupationSav	 = \"$userOccupationSav\";
\$userInterestsSav	 = \"$userInterestsSav\";
\$userGenderSav		 = \"$userGenderSav\";
?>";

		$user_id = $_SESSION['fl_website_user_id'];
		$fh = fopen("_data/users/$user_id.php", "w+") or die("can not open file");
		fwrite($fh, $update_file);
		fclose($fh);

		header("Location: ?open=ucp&page=default&sub=email&focus=inp_mail&ft=success&fm=Din nye e-postadresse er lagret i databasen.");
		exit;
	}	
}

echo"
<h2>E-postadresse</h2>
<form method=\"post\" action=\"?open=ucp&amp;page=default&amp;sub=email&amp;process=1\" enctype=\"multipart/form-data\" name=\"nameform\">
				
	
<!-- Feedback -->
";
if($ft != ""){
	echo"<div class=\"$ft\"><span>$fm</span></div>";
}
echo"	
<!-- //Feedback -->		
<table>
 <tr>
  <td style=\"text-align:right;padding-right: 4px;\">
	<p>E-post:</p>
  </td>
  <td>
	<p><input type=\"text\" name=\"inp_mail\" value=\"$userEmailSav\" size=\"40\" /></p>
  </td>
 </tr>
 <tr>
  <td style=\"text-align:right;padding-right: 4px;\">
	
  </td>
  <td>		
	<p><input type=\"submit\" value=\"Lagre endringer\" class=\"btn btn-success btn-sm\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>
  </td>
 </tr>
</table>
</form>

";
?>