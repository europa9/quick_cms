<?php 
/**
*
* File: kosthold/index.php
* Version 
* Date 2018-03-17 15:54:30
* Copyright (c) 2011-2018 Nettport.com
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "201803171658";
$pageNoColumnSav      = "2";
$pageAllowCommentsSav = "1";
$pageAuthorUserIdSav  = "1";

/*- Root dir --------------------------------------------------------------------------------- */
// This determine where we are
if(file_exists("favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
elseif(file_exists("../../../../favicon.ico")){ $root = "../../../.."; }
else{ $root = "../../.."; }

/*- Website config --------------------------------------------------------------------------- */
include("$root/_admin/website_config.php");

/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "Kosthold - BMR Kalkulator";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['action'])) {
	$action = $_GET['action'];
	$action = strip_tags(stripslashes($action));
}
else{
	$action = "";
}
if (isset($_GET['height'])) {
	$height = $_GET['height'];
	$height = stripslashes(strip_tags($height));
	$height = str_replace(",", ".", $height);
	if(!(is_numeric($height))){
		$height = "";
	}
	else{
		$height = substr($height, 0, 3);
	}
}
else{
	$height = "";
}
if (isset($_GET['mass'])) {
	$mass = $_GET['mass'];
	$mass = stripslashes(strip_tags($mass));
	$mass = str_replace(",", ".", $mass);
	if(!(is_numeric($mass))){
		$mass = "";
	}
	else{
		$mass = substr($mass, 0, 4);
	}
}
else{
	$mass = "";
}

if (isset($_GET['age'])) {
	$age = $_GET['age'];
	$age = stripslashes(strip_tags($age));
	$age = str_replace(",", ".", $age);
	if(!(is_numeric($age))){
		$age = "";
	}
	else{
		$age = substr($age, 0, 3);
	}
}
else{
	$age = "";
}

if (isset($_GET['gender'])) {
	$gender = $_GET['gender'];
	if($gender != "male"){
		$gender = "female";
	}
}
else{
	$gender = "";
}

if (isset($_GET['daily_activity'])) {
	$daily_activity = $_GET['daily_activity'];
	$daily_activity = stripslashes(strip_tags($daily_activity));
	$daily_activity = str_replace(",", ".", $daily_activity);
	if(!(is_numeric($daily_activity))){
		$daily_activity = "";
	}
	else{
		$daily_activity = substr($daily_activity, 0, 5);
	}
}
else{
	$daily_activity = "";
}

// Calculate
if($height != "" && $mass != "" && $gender != "" && $daily_activity != "" && $age != ""){
	
	if($gender == "male"){
		// BMR = 66.5 + (13.75 x kg body weight) + (5.003 x height in cm) - (6.755 x age)

		$bmr = 66.5+(13.75*$mass)+(5.003*$height)-(6.755*$age);
		$bmr_rounded = round($bmr, 0);
	}
	else{
		// BMR = 55.1 + (9.563 x kg body weight) + (1.850 x height in cm) - (4.676 x age)


		$bmr = 655+(9.563*$mass)+(1.850*$height)-(4.676*$age);
		$bmr_rounded = round($bmr, 0);
	}

	// Taking in to account activity
	$bmr_sedentary = $bmr*1.2;
	$bmr_sedentary = round($bmr_sedentary, 0);

	$bmr_slightly_active = $bmr*1.375;
	$bmr_slightly_active = round($bmr_slightly_active, 0);

	$bmr_moderately_active = $bmr*1.55;
	$bmr_moderately_active = round($bmr_moderately_active, 0);

	$bmr_active_lifestyle = $bmr*1.725;
	$bmr_active_lifestyle = round($bmr_active_lifestyle, 0);

	$bmr_very_active = $bmr*1.9;
	$bmr_very_active = round($bmr_very_active, 0);


	$bmr_your_activity = $bmr*$daily_activity;
	$bmr_your_activity = round($bmr_your_activity, 0);

}
else{
	if($action == "calculate"){
		if($height == ""){
			$fm = "Vennligst anngi din h&oslash;yde.";
		}
		if($mass == ""){
			$fm = "Vennligst anngi din vekt.";
		}
		if($gender == ""){
			$fm = "Vennligst anngi kj&oslash;nn.";
		}
		if($daily_activity == ""){
			$fm = "Vennligst anngi daglig aktivitet.";
		}
		if($age == ""){
			$fm = "Vennligst anngi din alder.";
		}
	}
}



/*- Content ---------------------------------------------------------- */
echo"
<h1>BMR kalkulator - Daglig inntak av kalorier</h1>

<!-- Linker -->
	<table>
	 <tr>
	  <td style=\"padding: 2px 4px 0px 0px;\">
		<p><a href=\"../fa_gratis_kostholdsplan_tilpasset_din_hoyde__vekt_og_mal.php\"><img src=\"gfx/list-add.png\" alt=\"list-add.png\" /></a></p>
	  </td>
	  <td>
		<p><a href=\"../fa_gratis_kostholdsplan_tilpasset_din_hoyde__vekt_og_mal.php\">F&aring; gratis kostholdsplan tilpasset din h&oslash;yde, vekt og m&aring;l</a></p>
	  </td>
	 </tr>
	</table>
<!-- //Linker -->
<!-- Kalkuler BMR -->
        <form method=\"get\" action=\"bmr_kalkulator.php\" enctype=\"multipart/form-data\" name=\"nameform\">";
	
	if(isset($fm)){
		echo"<div class=\"warning\"><p>$fm</p></div>";
	}
	if(isset($bmr_your_activity)){
		echo"
		<div class=\"success\"><p>Du trenger <b>$bmr_your_activity</b> kcal hver dag for &aring; opprettholde vekten din.</p></div>
		";
	}

	echo"
	<table>
	 <tr>
	  <td style=\"text-align: right;padding-right: 4px;\">
		<p>
		Din h&oslash;yde:
		</p>
	  </td>
	  <td>
		<p>
		<input type=\"text\" name=\"height\" value=\"$height\" size=\"12\" /> cm
		</p>
	  </td>	
	 </tr>
	 <tr>
	  <td style=\"text-align: right;padding-right: 4px;\">
		<p>
		Din vekt:
		</p>
	  </td>
	  <td>
		<p>
		<input type=\"text\" name=\"mass\" value=\"$mass\" size=\"12\" /> kg
		</p>
	  </td>	
	 </tr>
	 <tr>
	  <td style=\"text-align: right;padding-right: 4px;\">
		<p>
		Alder:
		</p>
	  </td>
	  <td>
		<p>
		<input type=\"text\" name=\"age\" value=\"$age\" size=\"12\" /> &aring;r
		</p>
	  </td>	
	 </tr>
	 <tr>
	  <td style=\"text-align: right;padding-right: 4px;\">
		<p>
		Kj&oslash;nn:
		</p>
	  </td>
	  <td>
		<p>
		<select name=\"gender\">
			<option value=\"male\""; if($gender == "male"){ echo" selected=\"selected\""; } echo">Mann</option>
			<option value=\"female\""; if($gender == "female"){ echo" selected=\"selected\""; } echo">Kvinne</option>
		</select>
		</p>
	  </td>	
	 </tr>
	 <tr>
	  <td style=\"text-align: right;padding-right: 4px;\">
		<p>
		Daglig aktivitet:
		</p>
	  </td>
	  <td>
		<p>
		<select name=\"daily_activity\">
			<option value=\"1.2\""; if($daily_activity == "1.2"){ echo" selected=\"selected\""; } echo">Stillesittende livsstil - Ingen sport eller aktiviteter</option>
			<option value=\"1.375\""; if($daily_activity == "1.375"){ echo" selected=\"selected\""; } echo">Litt aktiv livsstil - Lett trening mellom gang og tre ganger per uke</option>
			<option value=\"1.55\""; if($daily_activity == "1.55"){ echo" selected=\"selected\""; } echo">Moderat aktiv livsstil - Trening tre til fem dager per uke</option>
			<option value=\"1.725\""; if($daily_activity == "1.725"){ echo" selected=\"selected\""; } echo">Aktiv livsstil - Tung eller intensiv trening seks til sju ganger per uke</option>
			<option value=\"1.9\""; if($daily_activity == "1.9"){ echo" selected=\"selected\""; } echo">Veldig aktiv livsstil -Veldig tung eller intensiv trening to ganger om dagen</option>
		</select>
		</p>
	  </td>	
	 </tr>
	 <tr>
	  <td style=\"text-align: right;padding-right: 4px;\">
		
	  </td>
	  <td>
		<p>
		<input type=\"hidden\" name=\"focus\" value=\"height\" />
		<input type=\"hidden\" name=\"action\" value=\"calculate\" />
		<input type=\"submit\" value=\"Beregn BMR\" />
		</p>
		
	  </td>	
	 </tr>
	</table>
			

	</form>
<!-- //Kalkuler BMR -->



<!-- Ditt resultat -->
	";
	if(isset($bmr_your_activity)){
		echo"

		<h2 style=\"border:0;\">Ditt resultat</h2>
		
		<p>
		Under er ditt resultat regnet ut fra forskjellig aktivitet. 
		</p>

		<table style=\"width: 100%;\">
		 <tr>
		  <td class=\"outline\">
			<table style=\"border-spacing: 1px;border-collapse: separate;width: 100%;\">
			 <tr>
			  <td class=\"headcell\">
				<span><b>Daglig aktivitet</b></span>
			  </td>
			  <td class=\"headcell\">
				<span><b>Ditt energibehov</b></span>
			  </td>
			 </tr>
			 <tr>
			  <td class=\"bodycell\">
				<span>Stillesittende livsstil - Ingen sport eller aktiviteter</span>
			  </td>
			  <td class=\"bodycell\">
				<span>$bmr_sedentary kcal</span>
			  </td>
			 </tr>
			 <tr>
			  <td class=\"subcell\">
				<span>Litt aktiv livsstil - Lett trening mellom gang og tre ganger per uke</span>
			  </td>
			  <td class=\"subcell\">
				<span>$bmr_slightly_active kcal</span>
			  </td>
			 </tr>
			 <tr>
			  <td class=\"bodycell\">
				<span>Moderat aktiv livsstil - Trening tre til fem dager per uke</span>
			  </td>
			  <td class=\"bodycell\">
				<span>$bmr_moderately_active kcal</span>
			  </td>
			 </tr>
			 <tr>
			  <td class=\"subcell\">
				<span>Aktiv livsstil - Tung eller intensiv trening seks til sju ganger per uke</span>
			  </td>
			  <td class=\"subcell\">
				<span>$bmr_active_lifestyle kcal</span>
			  </td>
			 </tr>
			 <tr>
			  <td class=\"bodycell\">
				<span>Veldig aktiv livsstil -Veldig tung eller intensiv trening to ganger om dagen</span>
			  </td>
			  <td class=\"bodycell\">
				<span>$bmr_very_active kcal</span>
			  </td>
			 </tr>
			</table>
		
		  </td>
		 </tr>
		</table>
		";
	}
	echo"
<!-- //Ditt resultat -->




";


/*- Footer ----------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>