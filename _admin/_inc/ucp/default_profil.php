<?php
/**
*
* File: _admin/_inc/ucp/default_profil.php
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
	// Birthday
	$inp_birth_day   = $_POST['inp_birth_day'];
	$inp_birth_month = $_POST['inp_birth_month'];
	$inp_birth_year  = $_POST['inp_birth_year'];
	$inp_birthday	 = $inp_birth_year . "-" . $inp_birth_month . "-" . $inp_birth_day;
	$inp_birthday    = output_html($inp_birthday);

	// Timezone
	$inp_time_zone   = $_POST['inp_time_zone'];
	$inp_time_zone   = output_html($inp_time_zone);

	// Summertime
	$inp_have_summer_time = $_POST['inp_have_summer_time'];
	$inp_have_summer_time = output_html($inp_have_summer_time);
	if($inp_have_summer_time != "0" && $inp_have_summer_time != "1"){ 
		$inp_have_summer_time = "0";
	}

	// Signature
	$inp_signature = $_POST['inp_signature'];
	$inp_signature = substr($inp_signature, 0, 265);
	$inp_signature = output_html($inp_signature);

	// Messenger
	$inp_messenger   = $_POST['inp_messenger'];
	$inp_messenger   = strtolower($inp_messenger);
	$inp_messenger   = output_html($inp_messenger);


	// Name
	$inp_first_name   = $_POST['inp_first_name'];
	$inp_first_name   = ucfirst($inp_first_name);
	$inp_first_name   = output_html($inp_first_name);

	$inp_middle_name   = $_POST['inp_middle_name'];
	$inp_middle_name   = ucfirst($inp_middle_name);
	$inp_middle_name   = output_html($inp_middle_name);

	$inp_last_name   = $_POST['inp_last_name'];
	$inp_last_name   = ucfirst($inp_last_name);
	$inp_last_name   = output_html($inp_last_name);


	// Address A
	$inp_address_a   = $_POST['inp_address_a'];
	$inp_address_a   = ucfirst($inp_address_a);
	$inp_address_a   = output_html($inp_address_a);

	// Address B
	$inp_address_b   = $_POST['inp_address_b'];
	$inp_address_b   = ucfirst($inp_address_b);
	$inp_address_b   = output_html($inp_address_b);

	// Address Zip
	$inp_zip = $_POST['inp_zip'];
	$inp_zip = output_html($inp_zip);

	// City
	$inp_city	= $_POST['inp_city'];
	$inp_city   	= ucfirst($inp_city);
	$inp_city   	= output_html($inp_city);

	// Municipality
	$inp_municipality = $_POST['inp_municipality'];
	$inp_municipality = ucfirst($inp_municipality);
	$inp_municipality = output_html($inp_municipality);

	// County
	$inp_county = $_POST['inp_county'];
	$inp_county = ucfirst($inp_county);
	$inp_county = output_html($inp_county);

	// Country
	$inp_country = $_POST['inp_country'];
	$inp_country = ucfirst($inp_country);
	$inp_country = output_html($inp_country);

	// Area code
	$inp_area_code = $_POST['inp_area_code'];
	$inp_area_code = str_replace("+", "", $inp_area_code);
	if($inp_area_code == ""){
		$inp_area_code = "0000";
	}
	else{
		$len = strlen($inp_area_code);
		while($len<4){
			$inp_area_code = "0" . $inp_area_code;
			$len = $len+1;
		}
	}
	$inp_area_code = output_html($inp_area_code);

	// Mobile number
	$inp_mobile_number = $_POST['inp_mobile_number'];
	$inp_mobile_number = output_html($inp_mobile_number);

	// Messenger
	$inp_messenger = $_POST['inp_messenger'];
	$inp_messenger = output_html($inp_messenger);

	// SocialMediaLink
	$inp_social_media_link = $_POST['inp_social_media_link'];
	$inp_social_media_link = output_html($inp_social_media_link);
	$check = substr($inp_social_media_link, 0, 3);
	if($check != "htt"){
		$inp_social_media_link = "http://" . $inp_social_media_link;
	}

	// WebLink
	$inp_web_link = $_POST['inp_web_link'];
	$inp_web_link = output_html($inp_web_link);
	$check = substr($inp_web_link, 0, 3);
	if($check != "htt"){
		$inp_web_link = "http://" . $inp_web_link;
	}

	// Occupation
	$inp_occupation = $_POST['inp_occupation'];
	$inp_occupation = output_html($inp_occupation);

	// Interests
	$inp_interests = $_POST['inp_interests'];
	$inp_interests = output_html($inp_interests);

	// Gender
	$inp_gender = $_POST['inp_gender'];
	if($inp_gender != "male"){
		$inp_gender = "female";
	}

	// Misc
	$user_id = $_SESSION['fl_website_user_id'];
	include("_data/users/$user_id.php");

	$inp_last_seen_date = date("Y-m-d H:i:s");
	$inp_last_seen_time = time();

	$update_file="<?php
// Created by default_email.php
// user-file verision: 1.3

// Genreal
\$userIdSav		= \"$userIdSav\";
\$userTypeSav		= \"$userTypeSav\";
\$userYmdhisSav		= \"$userYmdhisSav\";
\$userAliasSav		= \"$userAliasSav\";
\$userAliasCleanSav	= \"$userAliasCleanSav\";
\$userEmailSav		= \"$userEmailSav\";
\$userFirstNameSav	= \"$inp_first_name\";
\$userMiddleNameSav	= \"$inp_middle_name\";
\$userLastNameSav	= \"$inp_last_name\";

// Time and dates
\$userRegisteredDateSav = \"$userRegisteredDateSav\";
\$userRegisteredTimeSav = \"$userRegisteredTimeSav\";
\$userLastSeenDateSav 	= \"$inp_last_seen_date\";
\$userLastSeenTimeSav 	= \"$inp_last_seen_time\";
\$userBirthdaySav 	= \"$inp_birthday\";
\$userTimeZoneSav	= \"$inp_time_zone\";
\$userHaveSummerTimeSav	= \"$inp_have_summer_time\";

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
\$userSignatureSav	= \"$inp_signature\";
	
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
\$userAddressASav	 = \"$inp_address_a\";
\$userAddressBSav	 = \"$inp_address_b\";
\$userZipSav		 = \"$inp_zip\";
\$userCitySav		 = \"$inp_city\";
\$userMunicipalitySav	 = \"$inp_municipality\";
\$userCountySav		 = \"$inp_county\";
\$userCountrySav	 = \"$inp_country\";
\$userAreaCodeSav	 = \"$inp_area_code\";
\$userMobileNumberSav	 = \"$inp_mobile_number\";
\$userMessengerSav	 = \"$inp_messenger\";
\$userSocialMediaLinkSav = \"$inp_social_media_link\";
\$userSocialMediaNameSav = \"$userSocialMediaNameSav\";
\$userWebLinkSav   	 = \"$inp_web_link\";
\$userWebNameSav   	 = \"$userWebNameSav\";
\$userOccupationSav	 = \"$inp_occupation\";
\$userInterestsSav	 = \"$inp_interests\";
\$userGenderSav		 = \"$inp_gender\";
?>";

	$user_id = $_SESSION['fl_website_user_id'];
	$fh = fopen("_data/users/$user_id.php", "w+") or die("can not open file");
	fwrite($fh, $update_file);
	fclose($fh);

	header("Location: ?open=ucp&page=default&sub=profil&focus=inp_birth_day&ft=success&fm=Informasjonen ble lagret.");
	exit;
	
}

echo"
<h2>Profil</h2>
<form method=\"post\" action=\"?open=ucp&amp;page=default&amp;sub=profil&amp;process=1\" enctype=\"multipart/form-data\" name=\"nameform\">
				
	
<!-- Feedback -->
";
if($ft != ""){
	echo"<div class=\"$ft\"><span>$fm</span></div>";
}
echo"	
<!-- //Feedback -->

<h3>Personalia</h3>
<table>
 <tr>
  <td style=\"text-align:right;padding: 0px 4px 0px 20px;vertical-align:top;\">
	<p>Fornavn:</p>
  </td>
  <td>
	<p>
	<input type=\"text\" name=\"inp_first_name\" value=\"$userFirstNameSav\" size=\"58\" />
	</p>
  </td>
 </tr>
 <tr>
  <td style=\"text-align:right;padding: 0px 4px 0px 20px;vertical-align:top;\">
	<p>Fornavn:</p>
  </td>
  <td>
	<p>
	<input type=\"text\" name=\"inp_middle_name\" value=\"$userMiddleNameSav\" size=\"58\" />
	</p>
  </td>
 </tr>
 <tr>
  <td style=\"text-align:right;padding: 0px 4px 0px 20px;vertical-align:top;\">
	<p>Fornavn:</p>
  </td>
  <td>
	<p>
	<input type=\"text\" name=\"inp_last_name\" value=\"$userLastNameSav\" size=\"58\" />
	</p>
  </td>
 </tr>
 <tr>
  <td style=\"text-align:right;padding: 0px 4px 0px 20px;vertical-align:top;\">
	<p>Adresselinje 1:</p>
  </td>
  <td>
	<p>
	<input type=\"text\" name=\"inp_address_a\" value=\"$userAddressASav\" size=\"58\" />
	</p>
  </td>
 </tr>
 <tr>
<td style=\"text-align:right;padding: 0px 4px 0px 20px;vertical-align:top;\">
	<p>Adresselinje 2:</p>
  </td>
  <td>
	<p>
	<input type=\"text\" name=\"inp_address_b\" value=\"$userAddressBSav\" size=\"58\" />
	</p>
  </td>
 </tr>
 <tr>
<td style=\"text-align:right;padding: 0px 4px 0px 20px;vertical-align:top;\">
	<p>Postnr og sted:</p>
  </td>
  <td>
	<p>
	<input type=\"text\" name=\"inp_zip\" value=\"$userZipSav\" size=\"4\" />
	<input type=\"text\" name=\"inp_city\" value=\"$userCitySav\" size=\"50\" />
	</p>
  </td>
 </tr>
 <tr>
<td style=\"text-align:right;padding: 0px 4px 0px 20px;vertical-align:top;\">
	<p>Kommune:</p>
  </td>
  <td>
	<p>
	<input type=\"text\" name=\"inp_municipality\" value=\"$userMunicipalitySav\" size=\"58\" />
	</p>
  </td>
 </tr>
 <tr>
<td style=\"text-align:right;padding: 0px 4px 0px 20px;vertical-align:top;\">
	<p>Fylke:</p>
  </td>
  <td>
	<p>
	<input type=\"text\" name=\"inp_county\" value=\"$userCountySav\" size=\"58\" />
	</p>
  </td>
 </tr>
 <tr>
<td style=\"text-align:right;padding: 0px 4px 0px 20px;vertical-align:top;\">
	<p>Land:</p>
  </td>
  <td>
	<p>
	<input type=\"text\" name=\"inp_country\" value=\"$userCountrySav\" size=\"58\" />
	</p>
  </td>
 </tr>
 <tr>
<td style=\"text-align:right;padding: 0px 4px 0px 20px;vertical-align:top;\">
	<p>Mobilnr:</p>
  </td>
  <td>
	<p>
	<input type=\"text\" name=\"inp_area_code\" value=\"$userAreaCodeSav\" size=\"4\" />
	<input type=\"text\" name=\"inp_mobile_number\" value=\"$userMobileNumberSav\" size=\"50\" />
	</p>
  </td>
 </tr>
 <tr>
  <td style=\"text-align:right;padding-right: 4px;\">
	<p>Bursdag:</p>
  </td>
  <td>
	";
	$birth = explode("-", $userBirthdaySav);
	$birth_day = $birth[2];
	$birth_month = $birth[1];
	$birth_year = $birth[0];

	echo"
	<p>
	<select name=\"inp_birth_day\">
		<option value=\"00\""; if($birth_day == "" OR $birth_day == "00"){ echo" selected=\"selected\"";} echo">Dag</option>";
		for($x=1;$x<32;$x++){
			if($x < "10"){
				$value = "0" . $x;
			}
			else{
				$value = "$x";
			}
			echo"		<option value=\"$value\""; if($birth_day == "$value"){ echo" selected=\"selected\"";} echo">$x</option>";

		}
		echo"
	</select>

	<select name=\"inp_birth_month\">
		<option value=\"00\""; if($birth_month == "" OR $birth_month == "00"){ echo" selected=\"selected\"";} echo">Måned</option>
		<option value=\"01\""; if($birth_month == "01"){ echo" selected=\"selected\"";} echo">januar</option>
		<option value=\"02\""; if($birth_month == "02"){ echo" selected=\"selected\"";} echo">februar</option>
		<option value=\"03\""; if($birth_month == "03"){ echo" selected=\"selected\"";} echo">mars</option>
		<option value=\"04\""; if($birth_month == "04"){ echo" selected=\"selected\"";} echo">april</option>
		<option value=\"05\""; if($birth_month == "05"){ echo" selected=\"selected\"";} echo">mai</option>
		<option value=\"06\""; if($birth_month == "06"){ echo" selected=\"selected\"";} echo">juni</option>
		<option value=\"07\""; if($birth_month == "07"){ echo" selected=\"selected\"";} echo">juli</option>
		<option value=\"08\""; if($birth_month == "08"){ echo" selected=\"selected\"";} echo">august</option>
		<option value=\"09\""; if($birth_month == "09"){ echo" selected=\"selected\"";} echo">september</option>
		<option value=\"10\""; if($birth_month == "10"){ echo" selected=\"selected\"";} echo">oktober</option>
		<option value=\"11\""; if($birth_month == "11"){ echo" selected=\"selected\"";} echo">november</option>
		<option value=\"12\""; if($birth_month == "12"){ echo" selected=\"selected\"";} echo">desember</option>
	</select>

	<select name=\"inp_birth_year\">
		<option value=\"0000\""; if($birth_year == "" OR $birth_year == "0000"){ echo" selected=\"selected\"";} echo">År</option>";
		$start = date("Y");
		$stop  = $start-100;
		for($x=$start;$x>$stop;$x--){
			echo"		<option value=\"$x\""; if($birth_year == "$x"){ echo" selected=\"selected\"";} echo">$x</option>";

		}
		echo"
	</select>
	</p>
  </td>
 </tr>
 <tr>
  <td style=\"text-align:right;padding: 0px 4px 0px 20px;vertical-align:top;\">
	<p>Messenger:</p>
  </td>
  <td>
	<p>
	<input type=\"text\" name=\"inp_messenger\" value=\"$userMessengerSav\" size=\"50\" />
	</p>
  </td>
 </tr>
 <tr>
  <td style=\"text-align:right;padding: 0px 4px 0px 20px;vertical-align:top;\">
	<p>Sosial media:</p>
  </td>
  <td>
	<p>
	<input type=\"text\" name=\"inp_social_media_link\" value=\"$userSocialMediaLinkSav\" size=\"50\" />
	</p>
  </td>
 </tr>
 <tr>
  <td style=\"text-align:right;padding: 0px 4px 0px 20px;vertical-align:top;\">
	<p>Nettside:</p>
  </td>
  <td>
	<p>
	<input type=\"text\" name=\"inp_web_link\" value=\"$userWebLinkSav\" size=\"50\" />
	</p>
  </td>
 </tr>
 <tr>
  <td style=\"text-align:right;padding: 0px 4px 0px 20px;vertical-align:top;\">
	<p>Yrke:</p>
  </td>
  <td>
	<p>
	<input type=\"text\" name=\"inp_occupation\" value=\"$userOccupationSav\" size=\"50\" />
	</p>
  </td>
 </tr>
 <tr>
  <td style=\"text-align:right;padding: 0px 4px 0px 20px;vertical-align:top;\">
	<p>Interesser:</p>
  </td>
  <td>
	<p>
	<input type=\"text\" name=\"inp_interests\" value=\"$userInterestsSav\" size=\"50\" />
	</p>
  </td>
 </tr>
 <tr>
  <td style=\"text-align:right;padding: 0px 4px 0px 20px;vertical-align:top;\">
	<p>Kjønn:</p>
  </td>
  <td>
	<p>
	<select name=\"inp_gender\">
		<option value=\"male\"";if($userGenderSav == "male"){ echo" selected=\"selected\"";}echo">Mann</option>
		<option value=\"female\"";if($userGenderSav == "female"){ echo" selected=\"selected\"";}echo">Kvinne</option>
	</select>
	</p>
  </td>
 </tr>
</table>


<h3>Diverse</h3>	
<table>
 <tr>
  <td style=\"text-align:right;padding-right: 4px;\">
	<p>Tidssone:</p>
  </td>
  <td>
	<p>
	<select name=\"inp_time_zone\">
		<option title=\"[UTC - 12, Y] Baker Island\" value=\"-12\""; if($userTimeZoneSav == "-12"){ echo" selected=\"selected\"";} echo">[UTC - 12, Y] Baker Island</option>
		<option title=\"[UTC - 11, X] Niue, Samoa\" value=\"-11\""; if($userTimeZoneSav == "-11"){ echo" selected=\"selected\"";} echo">[UTC - 11, X] Niue, Samoa</option>
		<option title=\"[UTC - 10, W] Hawai-Aleutian, Cook Island\" value=\"-10\""; if($userTimeZoneSav == "-10"){ echo" selected=\"selected\"";} echo">[UTC - 10, W] Hawai-Aleutian, Cook Island</option>
		<option title=\"[UTC - 9:30, V*] Marquesas Islands\" value=\"-9.5\""; if($userTimeZoneSav == "-9.5"){ echo" selected=\"selected\"";} echo">[UTC - 9:30, V*] Marquesas Islands</option>
		<option title=\"[UTC - 9, V] Alaska, Gambier Island\" value=\"-9\""; if($userTimeZoneSav == "-9"){ echo" selected=\"selected\"";} echo">[UTC - 9, V] Alaska, Gambier Island</option>
		<option title=\"[UTC - 8, U] Stillehavet\" value=\"-8\""; if($userTimeZoneSav == "-8"){ echo" selected=\"selected\"";} echo">[UTC - 8, U] Stillehavet</option>
		<option title=\"[UTC - 7, T] Fjell\" value=\"-7\""; if($userTimeZoneSav == "-7"){ echo" selected=\"selected\"";} echo">[UTC - 7, T] Fjell</option>
		<option title=\"[UTC - 6, S] Sentralt\" value=\"-6\""; if($userTimeZoneSav == "-6"){ echo" selected=\"selected\"";} echo">[UTC - 6, S] Sentralt</option>
		<option title=\"[UTC - 5, R] Østlig\" value=\"-5\""; if($userTimeZoneSav == "-5"){ echo" selected=\"selected\"";} echo">[UTC - 5, R] Østlig</option>
		<option title=\"[UTC - 4, Q] Atlanterhavet\" value=\"-4\""; if($userTimeZoneSav == "-4"){ echo" selected=\"selected\"";} echo">[UTC - 4, Q] Atlanterhavet</option>
		<option title=\"[UTC - 3:30, P*] Newfoundland\" value=\"-3.5\""; if($userTimeZoneSav == "-3.5"){ echo" selected=\"selected\"";} echo">[UTC - 3:30, P*] Newfoundland</option>
		<option title=\"[UTC - 3, P] Amasonas, Sentral-Grønland\" value=\"-3\""; if($userTimeZoneSav == "-3"){ echo" selected=\"selected\"";} echo">[UTC - 3, P] Amasonas, Sentral-Grønland</option>
		<option title=\"[UTC - 2, O] Fernando de Noronha, Sør-Georgia &amp; Sør Sandwich Islands\" value=\"-2\""; if($userTimeZoneSav == "-2"){ echo" selected=\"selected\"";} echo">[UTC - 2, O] Fernando de Noronha, Sør-Georgia &amp;...</option>
		<option title=\"[UTC - 1, N] Azorene, Kapp Verde, Øst-Grønland\" value=\"-1\""; if($userTimeZoneSav == "-1"){ echo" selected=\"selected\"";} echo">[UTC - 1, N] Azorene, Kapp Verde, Øst-Grønland</option>
		<option title=\"[UTC, Z] Vest-Europa, Greenwich\" value=\"0\""; if($userTimeZoneSav == "0"){ echo" selected=\"selected\"";} echo">[UTC, Z] Vest-Europa, Greenwich</option>
		
		<option title=\"[UTC + 1, A] Mellom-Europa, Vest-Afrika\" value=\"1\""; if($userTimeZoneSav == "1"){ echo" selected=\"selected\"";} echo">[UTC + 1, A] Mellom-Europa, Vest-Afrika</option>
		<option title=\"[UTC + 2, B] Øst-Europa , Sentral-Afrikansk\" value=\"2\""; if($userTimeZoneSav == "2"){ echo" selected=\"selected\"";} echo">[UTC + 2, B] Øst-Europa , Sentral-Afrikansk</option>
		<option title=\"[UTC + 3, C] Moskva, Øst-Afrika\" value=\"3\""; if($userTimeZoneSav == "3"){ echo" selected=\"selected\"";} echo">[UTC + 3, C] Moskva, Øst-Afrika</option>
		<option title=\"[UTC + 3:30, C*] Iran\" value=\"3.5\""; if($userTimeZoneSav == "3.5"){ echo" selected=\"selected\"";} echo">[UTC + 3:30, C*] Iran</option>
		<option title=\"[UTC + 4, D] Golfstrømmen, Samara\" value=\"4\""; if($userTimeZoneSav == "4"){ echo" selected=\"selected\"";} echo">[UTC + 4, D] Golfstrømmen, Samara</option>
		<option title=\"[UTC + 4:30, D*] Afghanistan\" value=\"4.5\""; if($userTimeZoneSav == "4.5"){ echo" selected=\"selected\"";} echo">[UTC + 4:30, D*] Afghanistan</option>
		<option title=\"[UTC + 5, E] Pakistan, Yekaterinburg\" value=\"5\""; if($userTimeZoneSav == "5"){ echo" selected=\"selected\"";} echo">[UTC + 5, E] Pakistan, Yekaterinburg</option>
		<option title=\"[UTC + 5:30, E*] India, Sri Lanka\" value=\"5.5\""; if($userTimeZoneSav == "5.5"){ echo" selected=\"selected\"";} echo">[UTC + 5:30, E*] India, Sri Lanka</option>
		<option title=\"[UTC + 5:45, E&Dagger;] Nepal\" value=\"5.75\""; if($userTimeZoneSav == "5.75"){ echo" selected=\"selected\"";} echo">[UTC + 5:45, E&Dagger;] Nepal</option>
		<option title=\"[UTC + 6, F] Bangladesh, Bhutan, Novosibirsk\" value=\"6\""; if($userTimeZoneSav == "6"){ echo" selected=\"selected\"";} echo">[UTC + 6, F] Bangladesh, Bhutan, Novosibirsk</option>
		<option title=\"[UTC + 6:30, F*] Cocos Islands, Myanmar\" value=\"6.5\""; if($userTimeZoneSav == "6.5"){ echo" selected=\"selected\"";} echo">[UTC + 6:30, F*] Cocos Islands, Myanmar</option>
		<option title=\"[UTC + 7, G] Indochina, Krasnoyarsk\" value=\"7\""; if($userTimeZoneSav == "7"){ echo" selected=\"selected\"";} echo">[UTC + 7, G] Indochina, Krasnoyarsk</option>
		<option title=\"[UTC + 8, H] Kinesisk, Den Australske Western, Irkutsk\" value=\"8\""; if($userTimeZoneSav == "8"){ echo" selected=\"selected\"";} echo">[UTC + 8, H] Kinesisk, Den Australske Western, ...</option>
		<option title=\"[UTC + 8:45, H&Dagger;] Den Sørøst-Australske Western\" value=\"8.75\""; if($userTimeZoneSav == "8.75"){ echo" selected=\"selected\"";} echo">[UTC + 8:45, H&amp;Dagger;] Den Sørøst-Australske W...</option>
		<option title=\"[UTC + 9, I] Japan, Korea, Chita\" value=\"9\""; if($userTimeZoneSav == "9"){ echo" selected=\"selected\"";} echo">[UTC + 9, I] Japan, Korea, Chita</option>
		<option title=\"[UTC + 9:30, I*] Sentral-Australia\" value=\"9.5\""; if($userTimeZoneSav == "9.5"){ echo" selected=\"selected\"";} echo">[UTC + 9:30, I*] Sentral-Australia</option>
		<option title=\"[UTC + 10, K] Øst-Australia, Vladivostok\" value=\"10\""; if($userTimeZoneSav == "10"){ echo" selected=\"selected\"";} echo">[UTC + 10, K] Øst-Australia, Vladivostok</option>
		<option title=\"[UTC + 10:30, K*] Lord Howe\" value=\"10.5\""; if($userTimeZoneSav == "10.5"){ echo" selected=\"selected\"";} echo">[UTC + 10:30, K*] Lord Howe</option>
		<option title=\"[UTC + 11, L] Salomonøyene, Magadan\" value=\"11\""; if($userTimeZoneSav == "11"){ echo" selected=\"selected\"";} echo">[UTC + 11, L] Salomonøyene, Magadan</option>
		<option title=\"[UTC + 11:30, L*] Norfolk Island\" value=\"11.5\""; if($userTimeZoneSav == "11.5"){ echo" selected=\"selected\"";} echo">[UTC + 11:30, L*] Norfolk Island</option>
		<option title=\"[UTC + 12, M] New Zealand, Fiji, Kamchatka\" value=\"12\""; if($userTimeZoneSav == "12"){ echo" selected=\"selected\"";} echo">[UTC + 12, M] New Zealand, Fiji, Kamchatka</option>
		<option title=\"[UTC + 12:45, M&Dagger;] Chatham Islands\" value=\"12.75\""; if($userTimeZoneSav == "12.75"){ echo" selected=\"selected\"";} echo">[UTC + 12:45, M&Dagger;] Chatham Islands</option>
		<option title=\"[UTC + 13, M*] Tonga, Phoenix Islands\" value=\"13\""; if($userTimeZoneSav == "13"){ echo" selected=\"selected\"";} echo">[UTC + 13, M*] Tonga, Phoenix Islands</option>
		<option title=\"[UTC + 14, M&dagger;] Line Island\" value=\"14\""; if($userTimeZoneSav == "14"){ echo" selected=\"selected\"";} echo">[UTC + 14, M&dagger;] Line Island</option>
	</select>
	</p>
  </td>
 </tr>
 <tr>
  <td style=\"text-align:right;padding-right: 4px;\">
	<p>Sommertid:</p>
  </td>
  <td>
	<p>
	<input type=\"radio\" name=\"inp_have_summer_time\" value=\"1\"";if($userHaveSummerTimeSav == "1"){ echo" checked=\"chekced\"";}echo" /> Ja
	&nbsp;
	<input type=\"radio\" name=\"inp_have_summer_time\" value=\"0\"";if($userHaveSummerTimeSav == "0"){ echo" checked=\"chekced\"";}echo" /> Nei  
	</p>
  </td>
 </tr>
 <tr>
<td style=\"text-align:right;padding: 0px 4px 0px 20px;vertical-align:top;\">
	<p>Signatur:</p>
  </td>
  <td>
	<p>
	<textarea name=\"inp_signature\" rows=\"5\" cols=\"65\">";$userSignatureSav = str_replace("<br />", "\n", $userSignatureSav);echo"$userSignatureSav</textarea>
	</p>
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