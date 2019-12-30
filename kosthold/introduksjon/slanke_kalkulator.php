<?php
/*- Configuration ---------------------------------------------------------------------------- */
$layoutNumberOfColumn = "2";
$layoutCommentsActive = "1";


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
if (isset($_GET['goal'])) {
	$goal = $_GET['goal'];
	$goal = stripslashes(strip_tags($goal));
	
}
else{
	$goal = "";
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
if($height != "" && $mass != "" && $gender != "" && $daily_activity != "" && $age != "" && $goal != ""){
	
	if($gender == "male"){
		// BMR = 66.5 + (13.75 x kg body weight) + (5.003 x height in cm) - (6.755 x age)

		$bmr = 66.5+(13.75*$mass)+(5.003*$height)-(6.755*$age);
		$bmr_rounded = round($bmr, 0);
	}
	else{
		// BMR = 55.1 + (9.563 x kg body weight) + (1.850 x height in cm) - (4.676 x age)


		$bmr = 55.1+(9.563*$mass)+(1.850*$height)-(4.676*$age);
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


	// loose or gain
	// 1 kg fett = 7700 kcal
	if($goal == "loose_1"){
		$bmr_goal = round($bmr_your_activity - (7700/7), 0);
	}
	elseif($goal == "loose_0.5"){
		$kcal = 7700*0.5;
		$bmr_goal = round($bmr_your_activity - ($kcal/7), 0);
	}
	elseif($goal == "gain_0.5"){
		$kcal = 7700*0.5;
		$bmr_goal = round($bmr_your_activity + ($kcal/7), 0);
	}
	elseif($goal == "gain_1"){
		$kcal = 7700*1;
		$bmr_goal = round($bmr_your_activity + ($kcal/7), 0);
	}
	else{
		$bmr_goal = "$bmr_your_activity";
	}
}
else{
	if($action == "calculate"){
		if($height == ""){
			$fm = "Vennligst anngi din høyde.";
		}
		if($mass == ""){
			$fm = "Vennligst anngi din vekt.";
		}
		if($gender == ""){
			$fm = "Vennligst anngi kjønn.";
		}
		if($daily_activity == ""){
			$fm = "Vennligst anngi daglig aktivitet.";
		}
		if($age == ""){
			$fm = "Vennligst anngi din alder.";
		}
		if($goal == ""){
			$fm = "Vennligst anngi ditt mål.";
		}
	}
}

/*- Header ----------------------------------------------------------- */
$website_title = "Kosthold - Slanke-kalkulator (daglig inntak av kalorier)"; 
if(isset($bmr)){
	$website_title = "Kosthold - Slanke-kalkulator (daglig inntak av kalorier) - $bmr_your_activity kcal";
}
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");


/*- Content ---------------------------------------------------------- */
echo"
<h1>Slanke-kalkulator - Daglig inntak av kalorier</h1>

$money

<!-- Kalkuler BMR -->
        <form method=\"get\" action=\"slanke_kalkulator.php\" enctype=\"multipart/form-data\" name=\"nameform\">";
	
	if(isset($fm)){
		echo"<div class=\"warning\"><p>$fm</p></div>";
	}
	if(isset($bmr_your_activity)){
		echo"
		<div class=\"success\"><p>Du trenger <b>$bmr_goal</b> for å nå ditt mål.</p></div>
		";
	}

	echo"
	<table>
	 <tr>
	  <td style=\"text-align: right;padding-right: 4px;\">
		<p>
		Din høyde:
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
		<input type=\"text\" name=\"age\" value=\"$age\" size=\"12\" /> år
		</p>
	  </td>	
	 </tr>
	 <tr>
	  <td style=\"text-align: right;padding-right: 4px;\">
		<p>
		Mål:
		</p>
	  </td>
	  <td>
		<p>
		<select name=\"goal\">
			<option value=\"loose_1\""; if($goal == "loose_1"){ echo" selected=\"selected\""; } echo">Gå ned 1 kg pr uke</option>
			<option value=\"loose_0.5\""; if($goal == "loose_0.5"){ echo" selected=\"selected\""; } echo">Gå ned 0,5 kg pr uke</option>
			<option value=\"0\""; if($goal == "0"){ echo" selected=\"selected\""; } echo">Opprettholde vekt</option>
			<option value=\"gain_0.5\""; if($goal == "gain_0.5"){ echo" selected=\"selected\""; } echo">Gå opp 0,5 kg pr uke</option>
			<option value=\"gain_1\""; if($goal == "gain_1"){ echo" selected=\"selected\""; } echo">Gå opp 1 kg pr uke</option>
		</select>
		</p>
	  </td>	
	 </tr>
	 <tr>
	  <td style=\"text-align: right;padding-right: 4px;\">
		<p>
		Kjønn:
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



";


/*- Footer ----------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>