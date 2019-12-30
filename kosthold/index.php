<?php 
/**
*
* File: kosthold/index.php
* Version 
* Date 2018-03-17 16:46:29
* Copyright (c) 2011-2018 Nettport.com
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "5";
$pageNoColumnSav      = "2";
$pageAllowCommentsSav = "0";
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
$website_title = "Kosthold";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */
echo"
<h1>Kosthold</h1>

<p><b>Kosthold</b></p>
<ul>
 <li><p><a href=\"kalorier_inn__kalorier_ut.php?l=no\">Kalorier inn, kalorier ut</a> - Kosthold kan være forvirrende men i utgangspunktet kan man si at kosthold er 3 enkle formler. Selv om formlene er enkle er det unntakene som gjør alt forvirrende.</p></li>

 <li><p><a href=\"proteinrik_mat.php?l=no\">Proteinrik mat</a> - Protein er et næringsstoff som menneskekroppen er avhengig av for å vokse og vedlikeholde muskler. Protein finnes i alle cellene i kroppen, og er en viktig komponent for muskelene. Proteiner finnes også i kroppens organer, hår og hud. .</p></li>

 <li><p><a href=\"slanking.php?l=no\">Slanking</a> - Hvordan skal man gå frem for å slanke seg?</p></li>

 <li><p><a href=\"fa_gratis_kostholdsplan_tilpasset_din_hoyde__vekt_og_mal.php?l=no\">Få gratis kostholdsplan tilpasset din høyde, vekt og mål</a> -
Klar til å gå ned i vekt? Start her!</p>
</ul>




<p><b>Kalkulatore</b></p>
<ul>

 <li><p><a href=\"kalkulator.php?l=no\">Kalkulator</a> - Tror du at du trenger å løpe maraton for å forbrenne fett på kroppen? Tro om igjen. </p></li>

 <li><p><a href=\"kalkulator/total_kalkulator.php?l=no\">Total kalkulator</a> - Kalkulerer alle dataene om deg.</p></li>

 <li><p><a href=\"kalkulator/bmi_kalkulator.php?l=no\">BMI kalkulator</a></p></li>

 <li><p><a href=\"kalkulator/bmr_kalkulator.php?l=no\">BMR kalkulator</a></p></li>

 <li><p><a href=\"kalkulator/slanke_kalkulator.php?l=no\">Slanke-kalkulator</a></p></li>

</ul>

";

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>