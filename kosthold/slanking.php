<?php 
/**
*
* File: kosthold/slanking.php
* Version 
* Date 2018-03-17 15:57:09
* Copyright (c) 2011-2018 Nettport.com
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "8";
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
$website_title = "Slanking";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */
echo"
		
<h1>Slanking</h1> 

<p>
Lurer du på hvordan du kan gå ned 5 kg? 
Her er løsningen for å regne ut hvor mange kcal din kropp trenger hver dag.
</p>



<h2>Hvor mange kcal trenger jeg hvis jeg bare sitter i ro?</h2>
<div style=\"padding-left: 20px;\">
	<p>
	Frem med penn og papir. 
	Du må regne ut med en formel hvor mange kcal du trenger per dag. 
	Det daglige antall kcal man trenger har vi gitt navnet BMR.
	Det tallet du får ut av formelen er det antall kcal du må spise hver dag
	for å opprettholde vekten din hvis du ikke beveger deg i det hele tatt.
	
	</p>

	<p>
	<b>Menn:</b><br />
	BMR = 66.5 + (13.75 x kg kroppsvekt) + (5.003 x høyde i cm) - (6.755 x alder)
	</p>

	<p>
	<b>Damer:</b><br />
	BMR = 655 + (9.563 x kg kroppsvekt) + (1.850 x høyde i cm) - (4.676 x alder)
	</p>

	<p>
	<b>Eksempel:</b><br />
	Et eksempel: Pia veier 64  kg, er 173 cm høy og 24 år. Hvor høy er BMR til Pia?
	</p>

	<p>
	Løsning:<br />
	BMR = 655 + (9.563 x kg kroppsvekt) + (1.850 x høyde i cm) - (4.676 x alder)<br />
	BMR = 655 + (9.563 x 64 kg ) + (1.850 x 173 cm) - (4.676 x 24 år)<br />
	BMR = 655 + (9,563 * 64  ) + (1,850 * 173) - (4.676 * 24)<br />
	BMR = 655 + (612,032 ) + (320,05) - (112,224)<br />
	BMR = 1485 kcal<br />
	</p>
</div>

<h2>Hvor mange kcal trenger jeg hvis jeg beveger meg?</h2>
<div style=\"padding-left: 20px;\">
	<p><b>Aktivitetsnivå</b><br />
	For å få tatt inn i betrakning at vi beveger oss i løpet av en dag må vi også ta med
	aktivitetsnivået i formelen. 
	</p>
	<table class=\"hor-zebra\">
	 <thead>
	  <tr>
	   <th scope=\"col\">
		<span><b>Faktor</b></span>
	   </th>
	   <th scope=\"col\">
			<span><b>Forklaring</b></span>
	   </th>
	   <th scope=\"col\">
	  </tr>
	</thead>

	<tbody>
	<tr>
	  <td>
			<span>1,2</span>
	  </td>
	  <td>
			<span>Stillesittende livsstil - Ingen sport eller aktiviteter</span>
	 </td>
	</tr>
			
	<tr>
	  <td class=\"odd\">
			<span>1,375</span>
	  </td>
	  <td class=\"odd\">
			<span>Litt aktiv livsstil - Lett trening mellom gang og tre ganger per uke</span>
	 </td>
	</tr>
			
	<tr>
	  <td>
			<span>1,55</span>
	  </td>
	  <td>
			<span>Moderat aktiv livsstil - Trening tre til fem dager per uke</span>
	 </td>
	</tr>
			
	<tr>
	  <td class=\"odd\">
			<span>1,725</span>
		  </td>
	  <td class=\"odd\">
			<span>Aktiv livsstil - Tung eller intensiv trening seks til sju ganger per uke</span>
	 </td>
	</tr>
			
	<tr>
	  <td>
			<span>1,9</span>
		  </td>
		  <td>
			<span>Veldig aktiv livsstil -Veldig tung eller intensiv trening to ganger om dagen</span>

			 </td>
			</tr>
			
		 </tbody>
		</table>

	<p>
	Kcal = BMR * Aktivitetsnivå faktor
	</p>


	<p>
	<b>Eksempel:</b><br />
	Et eksempel: Pia veier 64  kg, er 173 cm høy og 24 år. Hun har en BMR på 1485 kcal. Hun har en litt aktiv 
	livsstil. Hvor mange kcal trenger Pia for å opprettholde vekten sin?
	</p>

	<p>
	Løsning:<br />
	Kcal = BMR * Aktivitetsnivå faktor<br />
	Kcal = 1485 * 1,375<br />
	Kcal = 2042 kcal<br />
	</p>
</div>

<h2>Hvor mange kcal trenger jeg hvis jeg vil gå ned i vekt?</h2>
<div style=\"padding-left: 20px;\">
	<p><b>Gå ned i vekt?</b><br />
	1 kg fett tilsvarer 7700 kcal. Så for å f.eks. gå ned 0,5 kg pr uke må man trekke fra denne mengden
	med fett, og fordele den ut over en uke. 
	</p>

	<p>
	BMR mål = Kcal - ((1 kg fett*0,5)/7)
	</p>


	<b>Eksempel:</b><br />
	Et eksempel: Pia veier 64  kg, er 173 cm høy og 24 år. Hun har en BMR på 875 kcal. Hun har en litt aktiv 
	livsstil og skal ha 2042 kcal. Hun vil gå ned 0,5 kg på 1 uke. Hvor mange kcal skal hun spise?
	</p>

	<p>
	Løsning:<br />
	BMR mål = Kcal - ((1 kg fett*0,5)/7)<br />
	BMR mål = 2042 - ((7700*0,5)/7)<br />
	BMR mål = 2042 - 550<br />
	Kcal = 1492 kcal<br />
	</p>


</div>

";

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>