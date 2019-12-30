<?php 
/**
*
* File: kosthold/total_kalulator.php
* Version 
* Date 2018-03-17 15:54:30
* Copyright (c) 2011-2018 Nettport.com
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "1801042040";
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
$website_title = "Kosthold - Total Kalkulator";
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
if (isset($_GET['inp_height'])) {
	$inp_height = $_GET['inp_height'];
	$inp_height = stripslashes(strip_tags($inp_height));
	$inp_height = str_replace(",", ".", $inp_height);
	if(!(is_numeric($inp_height))){
		$inp_height = "";
	}
	else{
		$inp_height = substr($inp_height, 0, 3);
	}
}
else{
	$inp_height = "";
}
if (isset($_GET['inp_mass'])) {
	$inp_mass = $_GET['inp_mass'];
	$inp_mass = stripslashes(strip_tags($inp_mass));
	$inp_mass = str_replace(",", ".", $inp_mass);
	if(!(is_numeric($inp_mass))){
		$inp_mass = "";
	}
	else{
		$inp_mass = substr($inp_mass, 0, 4);
	}
}
else{
	$inp_mass = "";
}

if (isset($_GET['inp_age'])) {
	$inp_age = $_GET['inp_age'];
	$inp_age = stripslashes(strip_tags($inp_age));
	$inp_age = str_replace(",", ".", $inp_age);
	if(!(is_numeric($inp_age))){
		$inp_age = "";
	}
	else{
		$inp_age = substr($inp_age, 0, 3);
	}
}
else{
	$inp_age = "";
}

if (isset($_GET['inp_gender'])) {
	$inp_gender = $_GET['inp_gender'];
	if($inp_gender != "male"){
		$inp_gender = "female";
	}
}
else{
	$inp_gender = "";
}




/*- Content ---------------------------------------------------------- */

if($action == ""){
	echo"
	<h1>Total kalkulator</h1>


	<script>
	\$(document).ready(function(){
		\$('[name=\"inp_height\"]').focus();
	});
	</script>
        <form method=\"get\" action=\"total_kalkulator.php?action=calculate\" enctype=\"multipart/form-data\">";
	
	if(isset($fm)){
		echo"<div class=\"warning\"><p>$fm</p></div>";
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
		<input type=\"text\" name=\"inp_height\" value=\"$inp_height\" size=\"3\" /> cm
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
		<input type=\"text\" name=\"inp_mass\" value=\"$inp_mass\" size=\"3\" /> kg
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
		<input type=\"text\" name=\"inp_age\" value=\"$inp_age\" size=\"3\" /> &aring;r
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
		<select name=\"inp_gender\">
			<option value=\"male\""; if($inp_gender == "male"){ echo" selected=\"selected\""; } echo">Mann</option>
			<option value=\"female\""; if($inp_gender == "female"){ echo" selected=\"selected\""; } echo">Kvinne</option>
		</select>
		</p>
	  </td>	
	 </tr>
	 <tr>
	  <td style=\"text-align: right;padding-right: 4px;\">
		
	  </td>
	  <td>
		<p>
		<input type=\"hidden\" name=\"action\" value=\"calculate\" />
		<input type=\"submit\" value=\"Kalkuler\" class=\"btn btn_default\" />
		</p>
		
	  </td>	
	 </tr>
	</table>
			

	</form>
	";
}
elseif($action == "calculate"){
	/* 1. In data */
	if($inp_height == "" OR $inp_mass == "" OR $inp_gender == "" OR $inp_age == ""){
		echo"
		<h1>Alle felt må fylles ut</h1>

		<p>Vennligst fyll ut alle feltene.</p>

		<p>
		<a href=\"total_kalkulator.php?inp_height=$inp_height&amp;inp_mass=$inp_mass&amp;inp_age=$inp_age&amp;inp_gender=$inp_gender\">Tilbake</a>
		</p>
		";
	}
	else { 
		/* 1 In data */
		echo"
		<h1>Total kalkulator</h1>

		<h2>1. Inndata</h2>
		
		<table>
		 <tr>
		  <td>
			<span>H&oslash;yde:</span>
		  </td>
		  <td>
			<span>$inp_height cm</span>
		  </td>
		 </tr>
		 <tr>
		  <td>
			<span>Vekt:</span>
		  </td>
		  <td>
			<span>$inp_mass kg</span>
		  </td>
		 </tr>
		 <tr>
		  <td>
			<span>Kj&oslash;nn:</span>
		  </td>
		  <td>
			<span>"; if($inp_gender == "male"){ echo"Mann"; } else{ echo"Kvinne"; } echo"</span>
		  </td>
		 </tr>
		 <tr>
		  <td>
			<span>Alder:</span>
		  </td>
		  <td>
			<span>$inp_age</span>
		  </td>
		 </tr>
		</table>
		";


		/* 2. BMI */
		$inp_height_meter = $inp_height/100;
		$bmi = round($inp_mass / ($inp_height_meter*$inp_height_meter), 1);
		if($bmi < 18.5){
			$bmi_result = "<span style=\"color:red;\">undervektig</span>";
		}
		elseif($bmi > 18.5 && $bmi < 24.9){
			$bmi_result = "normal kroppsvekt";
		}
		elseif($bmi > 25 && $bmi < 29.9){
			$bmi_result = "<span style=\"color:red;\">overvektig</span>";
		}
		elseif($bmi > 30 && $bmi < 34.9){
			$bmi_result = "<span style=\"color:red;\">fedme</span>";
		}
		elseif($bmi > 35 && $bmi < 39.9){
			$bmi_result = "<span style=\"color:red;\">fedme, klasse II</span>";
		}
		else{
			$bmi_result = "<span style=\"color:red;\">fedme, klasse III (ekstrem fedme)</span>";
		}

		echo"
		<hr />
		<h2>2. BMI</h2>
		
		<p><b>OM BMI</b><br />
		Kroppsmasseindeks (KMI), fra engelsk body mass index (BMI), er en formel som viser balansen mellom høyde og vekt. Det indikerer om en person er over- eller undervektig eller har normal vekt.
		</p>
		<p>
		Muskuløse og personer med tung benbygning kan ha en BMI-verdi på over 25 uten å være overvektige. BMI skiller heller ikke mellom kroppsfett og muskler, selv om muskler veier mer enn fett. For å få en helt korrekt indikasjon måles fettinnholdet i blodet. 
		</p>

		<p>
		BMI = m/h<sup>2</sup>
		</p>

		<p><b>Din BMI</b><br />
		Din BMI er <b>$bmi</b> som kategoriserer deg i $bmi_result.</p>
		";
	


		/* 3. BMR */
		if($inp_gender == "male"){
			// BMR = 66.5 + (13.75 x kg body weight) + (5.003 x height in cm) - (6.755 x age)

			$bmr = 66.5+(13.75*$inp_mass)+(5.003*$inp_height)-(6.755*$inp_age);
			$bmr_rounded = round($bmr, 0);
		}
		else{
			// BMR = 55.1 + (9.563 x kg body weight) + (1.850 x height in cm) - (4.676 x age)

			$bmr = 655+(9.563*$inp_mass)+(1.850*$inp_height)-(4.676*$inp_age);
			$bmr_rounded = round($bmr, 0);
		}


		echo"
		<hr />
		<h2>3. BMR</h2>
		
		<p><b>OM BMR</b><br />
		Basal metabolic rate (BMR) er energiforbruket man har når man hviler. 
		Dette er altså hvor mange kalorier du trenger i løpet av en dag hvis du ikke gjør annet en å ligge helt i ro. 
		</p>

		<p>
		BMR er gitt av Harris-Benedict formelen og er ulik for kvinner og menn.<br />
		BMR for menn = 66.5 + (13.75 x kg body weight) + (5.003 x height in cm) - (6.755 x age)<br />
		BMR for kvinner = 55.1 + (9.563 x kg body weight) + (1.850 x height in cm) - (4.676 x age)
		</p>

		<p><b>Din BMR</b><br />
		Din BMR er <b>$bmr_rounded</b> kalorier.</p>
		";


		/* 4. Ditt energibehov */
		$bmr_sedentary = $bmr*1.2;
		$bmr_sedentary = round($bmr_sedentary, 0);

		$bmr_sedentary_fat = round($bmr_sedentary*13/100);
		$bmr_sedentary_carb = round($bmr_sedentary*44/100);
		$bmr_sedentary_proteins = round($bmr_sedentary*43/100);


		$bmr_slightly_active = $bmr*1.375;
		$bmr_slightly_active = round($bmr_slightly_active, 0);

		$bmr_slightly_active_fat = round($bmr_slightly_active*13/100);
		$bmr_slightly_active_carb = round($bmr_slightly_active*44/100);
		$bmr_slightly_active_proteins = round($bmr_slightly_active*43/100);

		$bmr_moderately_active = $bmr*1.55;
		$bmr_moderately_active = round($bmr_moderately_active, 0);

		$bmr_moderately_active_fat = round($bmr_moderately_active*13/100);
		$bmr_moderately_active_carb = round($bmr_moderately_active*44/100);
		$bmr_moderately_active_proteins = round($bmr_moderately_active*43/100);
	
		$bmr_active_lifestyle = $bmr*1.725;
		$bmr_active_lifestyle = round($bmr_active_lifestyle, 0);

		$bmr_active_lifestyle_fat = round($bmr_active_lifestyle*13/100);
		$bmr_active_lifestyle_carb = round($bmr_active_lifestyle*44/100);
		$bmr_active_lifestyle_proteins = round($bmr_active_lifestyle*43/100);


		$bmr_very_active = $bmr*1.9;
		$bmr_very_active = round($bmr_very_active, 0);

		$bmr_very_active_fat = round($bmr_very_active*13/100);
		$bmr_very_active_carb = round($bmr_very_active*44/100);
		$bmr_very_active_proteins = round($bmr_very_active*43/100);




		echo"
		<hr />
		<h2>4. Ditt energibehov</h2>
		
		<p><b>Om ditt energibehov</b><br />
		Kroppen er i bevegelse i løpet av dagen, men det er forskjell på kontorjobb og snekker. 
		Derfor må man ta dette i betrakning når man ønsker å finne ut hvor mye energi man trenger.
		</p>

		<p>
		Omentrent 13 % fett av maten man spiser bør være fett, 44 % karbohydrater og 43 % proteiner. 
		</p>

		<p><b>Ditt behov for energi</b></p>

		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span><b>Aktivitetsnivå</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Kalorier</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Fett</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Karbohydrat</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Protein</b></span>
		   </th>
		  </tr>
		 </thead>
		 <tbody>
		  <tr>
		   <td>
			<span>Stillesittende livsstil - Ingen sport eller aktiviteter</span>
		   </td>
		   <td>
			<span>$bmr_sedentary</span>
		   </td>
		   <td>
			<span>$bmr_sedentary_fat</span>
		   </td>
		   <td>
			<span>$bmr_sedentary_carb</span>
		   </td>
		   <td>
			<span>$bmr_sedentary_proteins</span>
		   </td>
		  </tr>
		  <tr>
		   <td class=\"odd\">
			<span>Litt aktiv livsstil - Lett trening mellom gang og tre ganger per uke</span>
		   </td>
		   <td class=\"odd\">
			<span>$bmr_slightly_active</span>
		   </td>
		   <td class=\"odd\">
			<span>$bmr_slightly_active_fat</span>
		   </td>
		   <td class=\"odd\">
			<span>$bmr_slightly_active_carb</span>
		   </td>
		   <td class=\"odd\">
			<span>$bmr_slightly_active_proteins</span>
		   </td>
		  </tr>
		  <tr>
		   <td>
			<span>Moderat aktiv livsstil - Trening tre til fem dager per uke</span>
		   </td>
		   <td>
			<span>$bmr_moderately_active</span>
		   </td>
		   <td>
			<span>$bmr_moderately_active_fat</span>
		   </td>
		   <td>
			<span>$bmr_moderately_active_carb</span>
		   </td>
		   <td>
			<span>$bmr_moderately_active_proteins</span>
		   </td>
		  </tr>
		  <tr>
		   <td class=\"odd\">
			<span>Aktiv livsstil - Tung eller intensiv trening seks til sju ganger per uke</span>
		   </td>
		   <td class=\"odd\">
			<span>$bmr_active_lifestyle</span>
		   </td>
		   <td class=\"odd\">
			<span>$bmr_active_lifestyle_fat</span>
		   </td>
		   <td class=\"odd\">
			<span>$bmr_active_lifestyle_carb</span>
		   </td>
		   <td class=\"odd\">
			<span>$bmr_active_lifestyle_proteins</span>
		   </td>
		  </tr>
		  <tr>
		   <td>
			<span>Veldig aktiv livsstil -Veldig tung eller intensiv trening to ganger om dagen</span>
		   </td>
		   <td>
			<span>$bmr_very_active</span>
		   </td>
		   <td>
			<span>$bmr_very_active_fat</span>
		   </td>
		   <td>
			<span>$bmr_very_active_carb</span>
		   </td>
		   <td>
			<span>$bmr_very_active_proteins</span>
		   </td>
		  </tr>
		 </tbody>
		</table>
		";



		/* 5. Gå ned i vekt */
		$kcal = 7700*0.5;
		$kcal_pr_day = round($kcal/7, 0);

		$bmr_sedentary_minus = $bmr_sedentary - $kcal_pr_day;

		$bmr_sedentary_minus_fat = round($bmr_sedentary_minus*13/100);
		$bmr_sedentary_minus_carb = round($bmr_sedentary_minus*44/100);
		$bmr_sedentary_minus_proteins = round($bmr_sedentary_minus*43/100);


		$bmr_slightly_active_minus =  $bmr_slightly_active - $kcal_pr_day;

		$bmr_slightly_active_minus_fat = round($bmr_slightly_active_minus*13/100);
		$bmr_slightly_active_minus_carb = round($bmr_slightly_active_minus*44/100);
		$bmr_slightly_active_minus_proteins = round($bmr_slightly_active_minus*43/100);

		$bmr_moderately_active_minus = $bmr_moderately_active - $kcal_pr_day;

		$bmr_moderately_active_minus_fat = round($bmr_moderately_active_minus*13/100);
		$bmr_moderately_active_minus_carb = round($bmr_moderately_active_minus*44/100);
		$bmr_moderately_active_minus_proteins = round($bmr_moderately_active_minus*43/100);
	
		$bmr_active_lifestyle_minus =  $bmr_active_lifestyle - $kcal_pr_day;
		$bmr_active_lifestyle_minus_fat = round($bmr_active_lifestyle_minus*13/100);
		$bmr_active_lifestyle_minus_carb = round($bmr_active_lifestyle_minus*44/100);
		$bmr_active_lifestyle_minus_proteins = round($bmr_active_lifestyle_minus*43/100);


		$bmr_very_active_minus =  $bmr_very_active - $kcal_pr_day;
		$bmr_very_active_minus_fat = round($bmr_very_active_minus*13/100);
		$bmr_very_active_minus_carb = round($bmr_very_active_minus*44/100);
		$bmr_very_active_minus_proteins = round($bmr_very_active_minus*43/100);


	
		echo"
		<hr />
		<h2>5. Gå ned i vekt</h2>
		
		<p><b>Om å gå ned i vekt</b><br />
		Et kilo på kroppen tilsvarer 7700 kcal. Det vil si at hvis du skal gå ned et kilo i løpet av en uke må du 
		skape et underskudd på 7700 kcal. Dette tilsvarer 1100 kcal hver dag!
		</p>

		<p>
		Når man skal gå ned i vekt må man tenke langsiktig. Man må sette seg mål på 4 kilo i gangen, noe som er 8 uker med slanking,
		omentrent to måneder. 
		For å klare å gå ned 4 kilo på to måneder kan man sette som mål å gå ned 0,5 kilo i uken.
		Da trenger man å skape et underskudd på 3850 kcal, altså 550 kcal pr dag. 
		</p>

		<p>
		Hvis man spiser mindre kalorier en det man forbrenner vil ta av seg vekt.
		</p>

		<p>For å oppsummere:</p>
		<ul>
			<li><span>550 kcal underskudd hver dag</span></li>
			<li><span>1 uke = 0,5 kilo</span></li>
			<li><span>8 uker = 4 kilo</span></li>
		</ul>
		
		<p><b>Hvis du skal gå ned 0,5 kilo pr uke:</b></p>

		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span><b>Aktivitetsnivå</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Kalorier</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Fett</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Karbohydrat</b></span>
		   </th>
		   <th scope=\"col\">
			<span><b>Protein</b></span>
		   </th>
		  </tr>
		 </thead>
		 <tbody>
		  <tr>
		   <td>
			<span>Stillesittende livsstil - Ingen sport eller aktiviteter</span>
		   </td>
		   <td>
			<span>$bmr_sedentary_minus</span>
		   </td>
		   <td>
			<span>$bmr_sedentary_minus_fat</span>
		   </td>
		   <td>
			<span>$bmr_sedentary_minus_carb</span>
		   </td>
		   <td>
			<span>$bmr_sedentary_minus_proteins</span>
		   </td>
		  </tr>
		  <tr>
		   <td class=\"odd\">
			<span>Litt aktiv livsstil - Lett trening mellom gang og tre ganger per uke</span>
		   </td>
		   <td class=\"odd\">
			<span>$bmr_slightly_active_minus</span>
		   </td>
		   <td class=\"odd\">
			<span>$bmr_slightly_active_minus_fat</span>
		   </td>
		   <td class=\"odd\">
			<span>$bmr_slightly_active_minus_carb</span>
		   </td>
		   <td class=\"odd\">
			<span>$bmr_slightly_active_minus_proteins</span>
		   </td>
		  </tr>
		  <tr>
		   <td>
			<span>Moderat aktiv livsstil - Trening tre til fem dager per uke</span>
		   </td>
		   <td>
			<span>$bmr_moderately_active_minus</span>
		   </td>
		   <td>
			<span>$bmr_moderately_active_minus_fat</span>
		   </td>
		   <td>
			<span>$bmr_moderately_active_minus_carb</span>
		   </td>
		   <td>
			<span>$bmr_moderately_active_minus_proteins</span>
		   </td>
		  </tr>
		  <tr>
		   <td class=\"odd\">
			<span>Aktiv livsstil - Tung eller intensiv trening seks til sju ganger per uke</span>
		   </td>
		   <td class=\"odd\">
			<span>$bmr_active_lifestyle_minus</span>
		   </td>
		   <td class=\"odd\">
			<span>$bmr_active_lifestyle_minus_fat</span>
		   </td>
		   <td class=\"odd\">
			<span>$bmr_active_lifestyle_minus_carb</span>
		   </td>
		   <td class=\"odd\">
			<span>$bmr_active_lifestyle_minus_proteins</span>
		   </td>
		  </tr>
		  <tr>
		   <td>
			<span>Veldig aktiv livsstil -Veldig tung eller intensiv trening to ganger om dagen</span>
		   </td>
		   <td>
			<span>$bmr_very_active_minus</span>
		   </td>
		   <td>
			<span>$bmr_very_active_minus_fat</span>
		   </td>
		   <td>
			<span>$bmr_very_active_minus_carb</span>
		   </td>
		   <td>
			<span>$bmr_very_active_minus_proteins</span>
		   </td>
		  </tr>
		 </tbody>
		</table>
		";

	} // null check
} // calculate



/*- Footer ----------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>