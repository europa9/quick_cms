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
$pageIdSav            = "201803171659";
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
$website_title = "Kosthold - BMI Kalkulator";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Variables ------------------------------------------------------------------------- */
if (isset($_GET['m'])) {
	$m = $_GET['m'];
	$m = stripslashes(strip_tags($m));
	$m = str_replace(",", ".", $m);
	if(!(is_numeric($m))){
		$m = "";
	}
	else{
		$m = substr($m, 0, 3);
	}
}
else{
	$m = "";
}
if (isset($_GET['h'])) {
	$h = $_GET['h'];
	$h = stripslashes(strip_tags($h));
	$h = str_replace(",", ".", $h);
	if(!(is_numeric($h))){
		$h = "";
	}
	else{
		$h = substr($h, 0, 3);
	}
}
else{
	$h = "";
}


// Calculate
if($m != "" && $h != ""){
	// bmi = m / h^2 

	$h_meter = $h/100;
	$bmi = round($m / ($h_meter*$h_meter), 1);
	
}

/*- Content ---------------------------------------------------------- */
echo"
<h1>BMI kalkulator</h1>


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

<!-- BMI kalkulasjon -->
";
if(isset($bmi)){
	if($bmi < 18.5){
		$ft = "warning";
		$result = "undervektig";
		
	}
	elseif($bmi > 18.5 && $bmi < 24.9){
		$ft = "success";
		$result = "normal kroppsvekt";
	}
	elseif($bmi > 25 && $bmi < 29.9){
		$ft = "warning";
		$result = "overvektig";
	}
	elseif($bmi > 30 && $bmi < 34.9){
		$ft = "warning";
		$result = "fedme";
	}
	elseif($bmi > 35 && $bmi < 39.9){
		$ft = "warning";
		$result = "fedme, klasse II";
	}
	else{
		$ft = "warning";
		$result = "fedme, klasse III (ekstrem fedme)";
	}
	echo"
	<div class=\"$ft\" style=\"text-align: left;\">

	<p>Du har en BMI p&aring; <b>$bmi</b>, noe som kategoriserer vekten din som <b>$result</b>.</p>
	
	</div>";
}

echo"
	
<!-- //BMI kalkulasjon -->

<!-- Kalkuler BMI -->
        		<form method=\"get\" action=\"bmi_kalkulator.php\" enctype=\"multipart/form-data\" name=\"nameform\">
			<table>
			 <tr>
			  <td style=\"width: 150px;\">
				<p>
				<b>Din H&oslash;yde:</b><br />
				<input type=\"text\" name=\"h\" value=\"$h\" size=\"12\" /> cm
				</p>
			  </td>
			  <td style=\"width: 150px;\">
				<p>
				<b>Din vekt:</b><br />
				<input type=\"text\" name=\"m\" value=\"$m\" size=\"12\" /> kg
				</p>
			  </td>
			  <td style=\"width: 150px;vertical-align:bottom;\">
				<p>
				<input type=\"hidden\" name=\"focus\" value=\"h\" />
				<input type=\"submit\" value=\"Beregn BMI\" />
				</p>
			  </td>
			 </tr>
			</table>
			

			</form>
<!-- //Kalkuler BMI -->





<!-- Info og tabell -->
	<table>
	 <tr>
	  <td style=\"vertical-align:top;padding-right: 15px;\">
		<h2 style=\"border:0;\">Hva er BMI?</h2>
		<p>
		BMI er et fors&oslash;k p&aring; &aring; beregne mengden muskler, fett og bein i en kropp,
		og deretter kategorisere den personen som undervektig, normal vektig, overvektig, eller fedme basert p&aring; denne verdien. 
		Det p&aring;g&aring;r en debatt om hvor man skal skille mellom disse kategoriene p&aring; BMI skalaen.
		</p>
	  </td>
	  <td style=\"width: 390px;padding-left: 15px;vertical-align:top;\">
		<h2 style=\"border:0;\">BMI-verdier</h2>
		<table>
		 <tr>
		  <td class=\"outline\">
			<table style=\"border-spacing: 1px;border-collapse: separate;\">
			 <tr>
			  <td class=\"headcell\">
				<span><b>Kategori</b></span>
			  </td>
			  <td class=\"headcell\">
				<span><b>BMI [kg/m<sup>2</sup>]</b></span>
			  </td>
			 </tr>
			 <tr>
			  <td class=\"bodycell\">
				<span>Undervektig</span>
			  </td>
			  <td class=\"bodycell\">
				<span>&lt; 18,5</span>
			  </td>
			 </tr>
			 <tr>
			  <td class=\"subcell\">
				<span>Normal kroppsvekt</span>
			  </td>
			  <td class=\"subcell\">
				<span>fra 18,5 til 24,9</span>
			  </td>
			 </tr>
			 <tr>
			  <td class=\"bodycell\">
				<span>Overvektig</span>
			  </td>
			  <td class=\"bodycell\">
				<span>fra 25 til 29,9</span>
			  </td>
			 </tr>
			 <tr>
			  <td class=\"subcell\">
				<span>Fedme</span>
			  </td>
			  <td class=\"subcell\">
				<span>fra 30 til 34,9</span>
			  </td>
			 </tr>
			 <tr>
			  <td class=\"bodycell\">
				<span>Fedme, klasse II</span>
			  </td>
			  <td class=\"bodycell\">
				<span>fra 35 til 39,9</span>
			  </td>
			 </tr>
			 <tr>
			  <td class=\"subcell\">
				<span>Fedme, klasse III (ekstrem fedme)</span>
			  </td>
			  <td class=\"subcell\">
				<span>&gt; 40</span>
			  </td>
			 </tr>
			</table>
		
		  </td>
		 </tr>
		</table>
		
	  </td>
	 </tr>
	</table>
<!-- //Info og tabell -->


<!-- Formel -->
	<h2>BMI-formel</h2>
	<p>
	BMI er gitt av formelen:
	</p>

	<table>
	 <tr>
	  <td style=\"padding: 0px 4px 0px 20px;\">
		<span>BMI =</span>
	  </td>
	  <td>
		<table>
		 <tr>
		  <td style=\"border-bottom: #000 1px solid;padding: 0px 4px 0px 4px;\">
			<span>m</span>
		  </td>
		 </tr>
		 <tr>
		  <td style=\"padding: 0px 4px 0px 4px;\">
			<span>h<sup>2</sup></span>
		  </td>
		 </tr>
		</table>
	  </td>
	";
	if($h != "" && $m != ""){
		echo"
		  <td style=\"padding: 0px 4px 0px 4px;\">
			<span>=</span>
		  </td>

		  <td>
			<table>
			 <tr>
			  <td style=\"border-bottom: #000 1px solid;padding: 0px 4px 0px 4px;\">
				<span>$m</span>
			  </td>
			 </tr>
			 <tr>
			  <td style=\"padding: 0px 4px 0px 4px;\">
				<span>$h_meter<sup>2</sup></span>
			  </td>
			 </tr>
			</table>
		  </td>
		  <td style=\"padding: 0px 4px 0px 4px;\">
			<span>= $bmi</span>
		  </td>
		";
	}
	echo"
	 </tr>
	</table>
	<p>
	Der <i>m</i> er masse i kg og <i>h</i> er h&oslash;yde i meter. Benevningen for BMI er <i>kg/m<sup>2</sup></i>.
	</p>

<!-- //Formel -->



";


/*- Footer ----------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>