<?php 
/**
*
* File: kosthold/kalkulator.php
* Version 
* Date 2018-03-17 16:01:33
* Copyright (c) 2011-2018 Nettport.com
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "9";
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
$website_title = "Kalkulator";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */
echo"
<h1>Kalkulator</h1>

<p>
Tror du at du trenger å løpe maraton for å forbrenne fett på kroppen? Tro om igjen. 
</p>

<p>
For å vite om du skal gå opp, ned eller bli værende på din nåværende vekt må du først regne ut BMI. 
BMI gir deg en indikasjon på din nåværende kategori.
</p>

<p>
Etter at du vet din BMI kan du regne ut basis forbrenningsrate (BMR). Denne gir deg antall kcal du trenger i løpet av en dag.
</p>



<h2>Basis forbrenningsrate (BMR)</h2>
<p>
For å fungere krever menneskekroppen krever en betydelig mengde energi (dvs. kalorier). 
Hver dag må kroppen puste, sirkulere blod, kontrollere kroppstemperatur, produsere nye celler, tenke, styrke muskler og nerver. 
Mengden energi som kroppen trenger for å fungere men den hviler heter basis forbrenningsrate. Dette forkortes til BMR. 
</p>

<p>
Basis forbrenningsrate (BMR) gir en indikasjon på hvor mye energi kroppen din trenger for å støtte vitale kroppsfunksjoner hvis du
ligger i sengen og hviler en hel dag. Faktisk er din BMR den største komponenten (i overkant av 60 prosent) av den totale energi brent hver dag.
</p>

<p>
Ved å vite din basis forbrenningsrate (BMR) vet du hvor mange kcal energi du trenger å forbrenne hver dag for å enten opprettholde vekten din, gå ned i vekt eller gå opp i vekt. 
</p>

<h3>BMR formel</h3>
<table>
 <tr>
  <td>
	<p style=\"padding-bottom:0;margin-bottom:0;\"><b>Menn:</b></p>
  </td>
  <td>
	<p style=\"padding-bottom:0;margin-bottom:0;\">BMR = (66,5 + (13,75 <b>·</b> vekt kg) + (5,003 <b>·</b> høyde cm) - (6,755 <b>·</b> alder år)) <b>·</b> aktivitetsnivå</p>
  </td>
 </tr>
 <tr>
  <td>
	<p style=\"padding:15px 8px 10px 0px;margin-top:0;\"><b>Kvinner:</b></p>
  </td>
  <td>
	<p style=\"padding:15px 8px 10px 0px;margin-top:0;\">BMR = (655 + (9,563 <b>·</b> vekt kg) + (1,850 <b>·</b> høyde cm) - (4,676 <b>·</b> alder)) <b>·</b> aktivitetsnivå</p>
  </td>
 </tr>
</table>

<h3>Daglige aktivitetsnivået</h3>
<p>
Det daglige aktivitetsnivået spiller også inn i kalkulasjonen av BMR. Det du har som daglig aktivitetsnivå er gitt
med et tall og skal multipliseres inn i ligningen for BMI. Under er de forskjellige forklart.<br />
</p>

<p><b>Stillesittende livsstil - Ingen sport eller aktiviteter</b><br />
Dette nivået er for noen som ikke har eller ikke kan innlemme øvelsen i sitt daglige liv 
(f.eks kjører i stedet for å gå, tar heisen i stedet for trappen, har en kontorjobb eller nedsatt bevegelighet).<br />
Daglig aktivitetsnivå = 1,2 <br />
</p>

<p><b>Litt aktiv livsstil - Lett trening mellom gang og tre ganger per uke</b><br />
Lett trening eller sport 1-3 dager per uke. Dette nivået vil omfatte personer som innlemme gange og aktivitet inn i deres daglige aktiviteter, men ikke har en øvelse regime på en slik eller trening eller spille sport færre enn tre ganger i uken.<br />
Daglig aktivitetsnivå = 1,375<br />
</p>

<p><b>Moderat aktiv livsstil - Trening tre til fem dager per uke</b><br />
Moderat trening eller sport 3-5 dager per uke. Dette nivået er for personer som trener eller spiller veldig aktiv idrett i minst 30 minutter non-stop i en tid minst tre ganger i uken, hver uke. Dette er nivået for folk som holder opp en god treningsopplegget som passer inn i deres daglige liv.<br />
Daglig aktivitetsnivå = 1,55<br />
</p>

<p><b>Aktiv livsstil - Tung eller intensiv trening seks til sju ganger per uke</b><br />
Hard trening eller sport 6-7 dager per uke. Dette nivået vil omfatte alvorlige ikke-profesjonelle idrettsutøvere trene aktivt for, for eksempel, en triatlon som krever nær daglig hard trening i minst en time om gangen.<br />
Daglig aktivitetsnivå = 1,725<br />
</p>

<p><b>
Veldig aktiv livsstil -Veldig tung eller intensiv trening to ganger om dagen</b><br />
Veldig hard trening eller sport mer enn en gang hver dag, og en fysisk jobb. Dette nivået er for folk å gjøre øvelsen flere ganger per dag, minst en time om gangen, og med den type fysisk jobb som krever topp kondisjon. Dette nivået er ikke vanlig - de fleste ikke-profesjonelle idrettsutøvere i seriøs trening vil være i Veldig aktiv nivå på de fleste.<br />
Daglig aktivitetsnivå = 1,9<br />
</p>

";

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>