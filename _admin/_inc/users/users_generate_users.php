<?php
/**
*
* File: _admin/_inc/settings/users_generate_users.php
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



/*- Variables ------------------------------------------------------------------------ */
if(isset($_GET['number'])) {
	$number = $_GET['number'];
	$number = strip_tags(stripslashes($number));
}
else{
	$number = "1";
}

$style = "";
	


echo"
<h2>Generer brukere</h2>

<META HTTP-EQUIV=Refresh CONTENT=\"1; URL=?open=settings&page=users&sub=generate_users&number=$number\">

<!-- Users -->

	<table width=\"100%\" >
	 <tr>
	  <td class=\"outline\">
		<table width=\"100%\" style=\"border-collapse: separate;border-spacing: 1px;\">
		 <tr>
		  <td class=\"headcell\">
			<span class=\"headcell\">Id</span>
		  </td>
		  <td class=\"headcell\">
			<span class=\"headcell\">Navn</span>
		  </td>
		  <td class=\"headcell\">
			<span class=\"headcell\">E-postadresse</span>
		  </td>
		 </tr>
		";
for($x=0;$x<$number;$x++){
	// Id
	$fh = fopen("_data/users/user_counter.dat", "r");
	$inp_user_id = fread($fh, filesize("_data/users/user_counter.dat"));
	fclose($fh);
	
	$inp_user_id = $inp_user_id+1;
	$fh = fopen("_data/users/user_counter.dat", "w+");
	fwrite($fh, $inp_user_id);
	fclose($fh);

	// Alias
	$inp_user_alias = "";
	$i = 0; //Reset the counter.
	$vowels = "aeio";
	$vowels_length = strlen($vowels);
	
	$consonants = "bcdfghjklmnpqrst";
	$consonants_length = strlen($consonants);

	$max = rand(3,8);
	while($i<$max) {
		$rand_vowel = mt_rand(1,$vowels_length-1);
		$inp_user_alias = $inp_user_alias . $vowels[$rand_vowel];


		$rand_consonant = mt_rand(1,$consonants_length-1);
		$inp_user_alias = $inp_user_alias . $consonants[$rand_consonant];

		$i++;
	}

	// Gender
	$inp_gender = rand(0,1);
	if($inp_gender == "0"){
		$inp_gender = "male";
	}
	else{
		$inp_gender = "female";
	}

	// First name
	if($inp_gender == "male"){
		$fh = fopen("_database/names/users_generate_users_first_names_male.txt", "r");
		$inp_first_name = fread($fh, filesize("_database/names/users_generate_users_first_names_male.txt"));
		fclose($fh);

		// Select a line
		$inp_first_name_array = explode("\n", $inp_first_name);
		$inp_first_name_array_size = sizeof($inp_first_name);
		
		$line = rand(0,$inp_first_name_array_size);
		
		// Get name from line
		$name = explode("|", $inp_first_name_array[$line]);
		$inp_first_name = $name[0];
	}
	else{
		$fh = fopen("_database/names/users_generate_users_first_names_female.txt", "r");
		$inp_first_name = fread($fh, filesize("_database/names/users_generate_users_first_names_female.txt"));
		fclose($fh);

		// Select line
		$inp_first_name_array = explode("\n", $inp_first_name);
		$inp_first_name_array_size = sizeof($inp_first_name);
		
		$line = rand(0,$inp_first_name_array_size);
		
		// Get name from line
		$name = explode("|", $inp_first_name_array[$line]);
		$inp_first_name = $name[1];
	}

	// Middle name
	$has_middlen_name = "";
	$has_middlen_name = rand(0, 100);
	if($has_middlen_name < "17"){
		// User has got a middle name

		if($inp_gender == "male"){
			$fh = fopen("_database/names/users_generate_users_first_names_male.txt", "r");
			$inp_middle_name = fread($fh, filesize("_database/names/users_generate_users_first_names_male.txt"));
			fclose($fh);

			// Select a line
			$inp_middle_name_array = explode("\n", $inp_middle_name);
			$inp_middle_name_array_size = sizeof($inp_middle_name);
		
			$line = rand(0,$inp_middle_name_array_size);
			
			// Get name from line
			$name = explode("|", $inp_middle_name_array[$line]);
			$inp_middle_name = $name[0];
		}
		else{
			$fh = fopen("_database/names/users_generate_users_first_names_female.txt", "r");
			$inp_middle_name = fread($fh, filesize("_database/names/users_generate_users_first_names_female.txt"));
			fclose($fh);

			// Select line
			$inp_middle_name_array = explode("\n", $inp_middle_name);
			$inp_middle_name_array_size = sizeof($inp_middle_name);
		
			$line = rand(0,$inp_middle_name_array_size);
		
			// Get name from line
			$name = explode("|", $inp_middle_name_array[$line]);
			$inp_middle_name = $name[1];
		}

		if($inp_middle_name == "$inp_first_name"){
			$inp_middle_name = "";
		}
	}
	else{
		// User does not have a middlename
		$inp_middle_name = "";
	}
	
	// Last name
	$fh = fopen("_database/names/users_generate_users_last_names.txt", "r");
	$last_names = fread($fh, filesize("_database/names/users_generate_users_last_names.txt"));
	fclose($fh);

	// Select line
	$last_names_array = explode("\n", $last_names);
	$last_names_array_size = sizeof($last_names_array);
		
	$line = rand(0,$last_names_array_size-1);
		
	$inp_last_name = $last_names_array[$line];
	$inp_last_name = trim(strip_tags($inp_last_name));
	$inp_last_name = str_replace(" ", "", $inp_last_name);

	// Mail
	$agents = array("gmail.no", "hotmail.se", "live.no", "hotmail.no", "live.no", "yahoo.no");
	$random_key = array_rand($agents, 1);
	
	$seperators = array("", "_", "-", ".");
	$seperator_key = array_rand($seperators, 1);

	$inp_user_email = $inp_first_name . $seperators[$seperator_key] . $inp_last_name . "@" . $agents[$random_key];
	$inp_user_email = strtolower($inp_user_email);

	// Registered
	$inp_date = date("Y-m-d H:i:s");
	$inp_time = time();
	
	// Birthday
	$day = rand("1", "28");
	if($day < "10"){ $day = "0" . $day; }
	$month = rand("1", "12");
	if($month < "10"){ $month = "0" . $month; }
	$year = date("Y");
	$year = $year-10;
	$year = rand("1990", $year);
	$inp_birthday = $year . "-" . $month . "-" . $day;

	
	// Generate a salt
	$inp_salt = "";
	$length = 10;
	$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
	$characters_len = strlen($characters) - 1;
	$string = "";    
	for ($p = 0; $p < $length; $p++) {
		$inp_salt .= $characters[mt_rand(0, $characters_len)];
	}

	// Generate password
	$inp_password = "";
	$length = 10;
	$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
	$characters_len = strlen($characters) - 1;
	$string = "";    
	for ($p = 0; $p < $length; $p++) {
		$inp_password .= $characters[mt_rand(0, $characters_len)];
	}
	$inp_password = sha1($inp_password);
	$inp_password = $inp_password. $inp_salt;

	// Ip
	$inp_ip	= $_SERVER['REMOTE_ADDR'];
	$inp_ip = output_html($inp_ip);

	$inp_host_by_addr = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$inp_host_by_addr = output_html($inp_host_by_addr);

	$inp_ymdhis = date("YmdHis");


	$create_user="<?php
// Created by default_email.php
// user-file verision: 1.4

// Genreal
\$userIdSav		= \"$inp_user_id\";
\$userTypeSav		= \"3\";
\$userYmdhisSav		= \"$inp_ymdhis\";
\$userAliasSav		= \"$inp_user_alias\";
\$userAliasCleanSav	= \"$inp_user_alias\";
\$userEmailSav		= \"$inp_user_email\";
\$userFirstNameSav	= \"$inp_first_name\";
\$userMiddleNameSav	= \"$inp_middle_name\";
\$userLastNameSav	= \"$inp_last_name\";

// Time and dates
\$userRegisteredDateSav = \"$inp_date\";
\$userRegisteredTimeSav = \"$inp_time\";
\$userLastSeenDateSav 	= \"$inp_date\";
\$userLastSeenTimeSav 	= \"$inp_time\";
\$userBirthdaySav 	= \"$inp_birthday\";
\$userTimeZoneSav	= \"1\";
\$userHaveSummerTimeSav	= \"1\";

// Security
\$userPasswordSav 	= \"$inp_password\";
\$userSaltSav 	  	= \"$inp_salt\";
\$userIpSav 		= \"$inp_ip\";
\$userHostByAddrSav	= \"$inp_host_by_addr\";
\$userPermissionsSav	= \"\";
\$userLoginAttemptsSav	= \"0\";

// Groups
\$userGroupsSav		= \"\";

// Forums
\$userLastpostTimeSav	= \"\";
\$userPostsSav		= \"0\";
\$userSignatureSav	= \"\";
	
// Private messages
\$userMessagesUnreadSav	= \"0\";

// Misc
\$userLanguageSav	= \"311\";

// Avatar and picture
\$userAvatarSav		= \"\";
\$userPictureSav	= \"\";
\$userPictureThumbSav	= \"\";

// About
\$userBusinessSav	 = \"0\";
\$userAddressNameSav	 = \"$inp_first_name $inp_middle_name $inp_last_name\";
\$userAddressASav	 = \"\";
\$userAddressBSav	 = \"\";
\$userZipSav		 = \"\";
\$userCitySav		 = \"\";
\$userMunicipalitySav	 = \"\";
\$userCountySav		 = \"\";
\$userCountrySav	 = \"Norway\";
\$userAreaCodeSav	 = \"\";
\$userMobileNumberSav	 = \"\";
\$userMessengerSav	 = \"\";
\$userSocialMediaLinkSav = \"\";
\$userSocialMediaNameSav = \"\";
\$userWebLinkSav   	 = \"\";
\$userWebNameSav   	 = \"\";
\$userOccupationSav	 = \"\";
\$userInterestsSav	 = \"\";
\$userGenderSav		 = \"$inp_gender\";
?>";

	$fh = fopen("_data/users/$inp_user_id.php", "w+") or die("can not open file");
	fwrite($fh, $create_user);
	fclose($fh);
		
				if($style == "bodycell"){ $style = "subcell"; } else{ $style = "bodycell"; }
				echo"
				 <tr>
				  <td class=\"$style\">
					<span>$inp_user_id</span>
				  </td>
				  <td class=\"$style\">
					<span>$inp_first_name $inp_middle_name $inp_last_name</span>
				  </td>
				  <td class=\"$style\">
					<span>$inp_user_email</span>
				  </td>
				 </tr>
				";

}
		
		echo"
		</table>
  </td>
 </tr>
</table>
<!-- //users -->




";
?>