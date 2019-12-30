<?php
/**
*
* File: _admin/_inc/ucp/default_password.php
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
	$inp_password = $_POST['inp_password'];
	$inp_password = output_html($inp_password);

	if($inp_password == ""){
		header("Location: ?open=ucp&page=default&sub=password&focus=inp_password&ft=error&fm=Hvis du ønsker å bytte passord må du anngi ditt nye passord i feltet.");
		exit;
	}
	else{


		// We have no duplicates and can save		
		$user_id = $_SESSION['fl_website_user_id'];
		include("_data/users/$user_id.php");

		// Salt
		$inp_password = sha1($inp_password);
		$inp_password = $inp_password . $userSaltSav;

		// Other variables
		$inp_last_seen_date = date("Y-m-d H:i:s");
		$inp_last_seen_time = time();

		$update_file="<?php
// Created by default_password.php
// user-file verision: 1.4

// Genreal
\$userIdSav		= \"$userIdSav\";
\$userTypeSav		= \"$userTypeSav\";
\$userYmdhisSav		= \"$userYmdhisSav\";
\$userAliasSav		= \"$userAliasSav\";
\$userAliasCleanSav	= \"$userAliasCleanSav\";
\$userEmailSav		= \"$userEmailSav\";
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
\$userPasswordSav 	= \"$inp_password\";
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

		header("Location: ?open=ucp&page=default&sub=password&focus=inp_password&ft=success&fm=Det nye passordet ditt ble lagret i databasen.");
		exit;
	}	
}

echo"
<h2>Passord</h2>
<form method=\"post\" action=\"?open=ucp&amp;page=default&amp;sub=password&amp;process=1\" enctype=\"multipart/form-data\" name=\"nameform\">
				
	
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
	<p>Ønsket nytt passord:</p>
  </td>
  <td>
	<p><input type=\"password\" name=\"inp_password\" value=\"\" size=\"40\" /></p>
  </td>
 </tr>
 <tr>
  <td style=\"text-align:right;padding-right: 4px;\">
	
  </td>
  <td>		
	<p><input type=\"submit\" value=\"Send skjema\" class=\"btn btn-success btn-sm\" tabindex=\"3\" /></p>
  </td>
 </tr>
</table>
</form>

";
?>