<?php
/* Version 
* Date 12:50 01.03.2019
* Copyright (c) 2011-2019 Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "201803171700";
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
$website_title = "Kosthold - Slanke kalkulator";
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




/*- Content ---------------------------------------------------------- */
echo"
<h1>Slanke-kalkulator</h1>


<!-- Kalkuler BMR -->
        <form method=\"get\" action=\"slanke_kalkulator.php\" enctype=\"multipart/form-data\">";
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
		M&aring;l:
		</p>
	  </td>
	  <td>
		<p>
		<select name=\"goal\">
			<option value=\"loose_1\""; if($goal == "loose_1"){ echo" selected=\"selected\""; } echo">G&aring; ned 1 kg pr uke</option>
			<option value=\"loose_0.5\""; if($goal == "loose_0.5" OR $goal == ""){ echo" selected=\"selected\""; } echo">G&aring; ned 0,5 kg pr uke</option>
			<option value=\"0\""; if($goal == "0"){ echo" selected=\"selected\""; } echo">Opprettholde vekt</option>
			<option value=\"gain_0.5\""; if($goal == "gain_0.5"){ echo" selected=\"selected\""; } echo">G&aring; opp 0,5 kg pr uke</option>
			<option value=\"gain_1\""; if($goal == "gain_1"){ echo" selected=\"selected\""; } echo">G&aring; opp 1 kg pr uke</option>
		</select>
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


<!-- Result -->
	";

	// Calculate
	if($height != "" && $mass != "" && $gender != "" && $daily_activity != "" && $age != "" && $goal != ""){
	
		if($gender == "male"){
			$bmr = 66.5+(13.75*$mass)+(5.003*$height)-(6.755*$age);
			$bmr_rounded = round($bmr, 0);
		}
		else{
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



		echo"
		<h2>Ditt resultat</h2>
		

			<p>
			Det <span style=\"color: green;\">gr&oslash;nne</span> tallet under er antall kcal du kan spise i l&oslash;pet av en dag for &aring; ";
				if($goal == "loose_1"){
					echo"g&aring; ned 1 kg/uken";
				}
				elseif($goal == "loose_0.5"){
					echo"g&aring; ned 0,5 kg/uken";
				}
				elseif($goal == "gain_0.5"){
					echo"g&aring; opp 0,5 kg/uken";
				}
				elseif($goal == "gain_1"){
					echo"g&aring; opp 1 kg/uken";
				}
				else{
					echo"opprettholde vekten din";
				}
				echo".
			Du kan ogs&aring; se fra tallene under hva som skjer hvis du &oslash;ker eller reduserer aktiviteten din i l&oslash;pet av en dag.
			</p>

			<p>
			Din BMR: $bmr_rounded 
			</p>

			<table class=\"hor-zebra\">
			 <thead>
			  <tr>
			   <th>
				
			   </th>
			   <th>
				<span><b>Opprettholde vekten din</b></span>
			   </th>
			   <th>
				<span><b>";
				if($goal == "loose_1"){
					echo"G&aring; ned 1 kg/uken";
				}
				elseif($goal == "loose_0.5"){
					echo"G&aring; ned 0,5 kg/uken";
				}
				elseif($goal == "gain_0.5"){
					echo"G&aring; opp 0,5 kg/uken";
				}
				elseif($goal == "gain_1"){
					echo"G&aring; opp 1 kg/uken";
				}
				else{
					echo"Opprettholde vekten";
				}
				echo"</b></span>
			   </th>
			  </tr>
			 </thead>
			 <tbody>

			  <tr>
			   <td"; if($daily_activity == "1.2"){ echo" class=\"important\""; } else{ } echo">
				<span>Stillesittende</span>
			   </td>
			   <td"; if($daily_activity == "1.2"){ echo" class=\"important\""; } else{ } echo">
				<span>$bmr_sedentary</span>
			   </td>
			   <td"; if($daily_activity == "1.2"){ echo" class=\"important\""; } else{ } echo">
				<span"; if($daily_activity == "1.2"){ echo" style=\"font-weight:bold;color:green;\""; } echo">";
				if($goal == "loose_1"){
					$bmr_goal = round($bmr_sedentary - (7700/7), 0);
				}
				elseif($goal == "loose_0.5"){
					$kcal = 7700*0.5;
					$bmr_goal = round($bmr_sedentary - ($kcal/7), 0);
				}
				elseif($goal == "gain_0.5"){
					$kcal = 7700*0.5;
					$bmr_goal = round($bmr_sedentary + ($kcal/7), 0);
				}
				elseif($goal == "gain_1"){
					$kcal = 7700*1;
					$bmr_goal = round($bmr_sedentary + ($kcal/7), 0);
				}
				else{
					$bmr_goal = "$bmr_sedentary";
				}
				echo"$bmr_goal</span>
			   </td>
			  </tr>

			  <tr>
			   <td"; if($daily_activity == "1.375"){ echo" class=\"important\""; } else{ echo" class=\"odd\""; } echo">
				<span>Litt aktiv</span>
			   </td>
			   <td"; if($daily_activity == "1.375"){ echo" class=\"important\""; } else{ echo" class=\"odd\""; } echo">
				<span>$bmr_slightly_active</span>
			   </td>
			   <td"; if($daily_activity == "1.375"){ echo" class=\"important\""; } else{ echo" class=\"odd\""; } echo">
				<span"; if($daily_activity == "1.375"){ echo" style=\"font-weight:bold;color:green;\""; } echo">";
				if($goal == "loose_1"){
					$bmr_goal = round($bmr_slightly_active - (7700/7), 0);
				}
				elseif($goal == "loose_0.5"){
					$kcal = 7700*0.5;
					$bmr_goal = round($bmr_slightly_active - ($kcal/7), 0);
				}
				elseif($goal == "gain_0.5"){
					$kcal = 7700*0.5;
					$bmr_goal = round($bmr_slightly_active + ($kcal/7), 0);
				}
				elseif($goal == "gain_1"){
					$kcal = 7700*1;
					$bmr_goal = round($bmr_slightly_active + ($kcal/7), 0);
				}
				else{
					$bmr_goal = "$bmr_slightly_active";
				}
				echo"$bmr_goal</span>
			   </td>
			  </tr>



			  <tr>
			   <td"; if($daily_activity == "1.55"){ echo" class=\"important\""; } echo">
				<span>Moderat aktiv</span>
			   </td>
			   <td"; if($daily_activity == "1.55"){ echo" class=\"important\""; } echo">
				<span>$bmr_moderately_active</span>
			   </td>
			   <td"; if($daily_activity == "1.55"){ echo" class=\"important\""; } echo">
				<span"; if($daily_activity == "1.55"){ echo" style=\"font-weight:bold;color:green;\""; } echo">";
				if($goal == "loose_1"){
					$bmr_goal = round($bmr_moderately_active - (7700/7), 0);
				}
				elseif($goal == "loose_0.5"){
					$kcal = 7700*0.5;
					$bmr_goal = round($bmr_moderately_active - ($kcal/7), 0);
				}
				elseif($goal == "gain_0.5"){
					$kcal = 7700*0.5;
					$bmr_goal = round($bmr_moderately_active + ($kcal/7), 0);
				}
				elseif($goal == "gain_1"){
					$kcal = 7700*1;
					$bmr_goal = round($bmr_moderately_active + ($kcal/7), 0);
				}
				else{
					$bmr_goal = "$bmr_moderately_active";
				}
				echo"$bmr_goal</span>
			   </td>
			  </tr>

			  <tr>
			   <td"; if($daily_activity == "1.725"){ echo" class=\"important\""; } else{ echo" class=\"odd\""; } echo">
				<span>Aktiv livsstil</span>
			   </td>
			   <td"; if($daily_activity == "1.725"){ echo" class=\"important\""; } else{ echo" class=\"odd\""; } echo">
				<span>$bmr_active_lifestyle</span>
			   </td>
			   <td"; if($daily_activity == "1.725"){ echo" class=\"important\""; } else{ echo" class=\"odd\""; } echo">
				<span"; if($daily_activity == "1.725"){ echo" style=\"font-weight:bold;color:green;\""; } echo">";
				if($goal == "loose_1"){
					$bmr_goal = round($bmr_active_lifestyle - (7700/7), 0);
				}
				elseif($goal == "loose_0.5"){
					$kcal = 7700*0.5;
					$bmr_goal = round($bmr_active_lifestyle - ($kcal/7), 0);
				}
				elseif($goal == "gain_0.5"){
					$kcal = 7700*0.5;
					$bmr_goal = round($bmr_active_lifestyle + ($kcal/7), 0);
				}
				elseif($goal == "gain_1"){
					$kcal = 7700*1;
					$bmr_goal = round($bmr_active_lifestyle + ($kcal/7), 0);
				}
				else{
					$bmr_goal = "$bmr_active_lifestyle";
				}
				echo"$bmr_goal</span>
			   </td>
			  </tr>


			  <tr>
			   <td"; if($daily_activity == "1.9"){ echo" class=\"important\""; } echo">
				<span>Veldig aktiv</span>
			   </td>
			   <td"; if($daily_activity == "1.9"){ echo" class=\"important\""; } echo">
				<span>$bmr_very_active</span>
			   </td>
			   <td"; if($daily_activity == "1.9"){ echo" class=\"important\""; } echo">
				<span"; if($daily_activity == "1.9"){ echo" style=\"font-weight:bold;color:green;\""; } echo">";
				if($goal == "loose_1"){
					$bmr_goal = round($bmr_very_active - (7700/7), 0);
				}
				elseif($goal == "loose_0.5"){
					$kcal = 7700*0.5;
					$bmr_goal = round($bmr_very_active - ($kcal/7), 0);
				}
				elseif($goal == "gain_0.5"){
					$kcal = 7700*0.5;
					$bmr_goal = round($bmr_very_active + ($kcal/7), 0);
				}
				elseif($goal == "gain_1"){
					$kcal = 7700*1;
					$bmr_goal = round($bmr_very_active + ($kcal/7), 0);
				}
				else{
					$bmr_goal = "$bmr_very_active";
				}
				echo"$bmr_goal</span>
			   </td>
			  </tr>

			 </tbody>
			</table>
		

		";
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
			if($goal == ""){
				$fm = "Vennligst anngi ditt m&aring;l.";
			}
			echo"<div class=\"warning\"><p>$fm</p></div>";
		}
	}

	echo"
<!-- //Result -->


";


/*- Footer ----------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>