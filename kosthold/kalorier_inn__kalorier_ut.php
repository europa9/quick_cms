<?php 
/**
*
* File: kosthold/kalorier_inn__kalorier_ut.php
* Version 
* Date 2018-03-17 15:49:31
* Copyright (c) 2011-2018 Nettport.com
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "7";
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
$website_title = "Kalorier inn, kalorier ut";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */
echo"
<h1>Kalorier inn, kalorier ut</h1>
<p>Kosthold kan være forvirrende men i utgangspunktet kan man si at kosthold er 3 enkle formler. Selv om formlene er enkle er det unntakene som gjør alt forvirrende. For eksempel bør et kosthold aldri bestå av mindre en 1500 kcal.</p>
<table class=\"hor-zebra\">
<thead>
<tr>
<th scope=\"col\"><strong>#</strong></th>
<th scope=\"col\"><strong>Tilfelle</strong></th>
<th scope=\"col\"><strong>Konsekvens</strong></th>
</tr>
</thead>
<tbody>
<tr>
<td>
<p>1</p>
</td>
<td>
<p>Kalorier inn = kalorier ut</p>
</td>
<td>
<p>Man spiser like mange kalorier som man forbrenner og dermed vil man opprettholde sin vekt.</p>
</td>
</tr>
<tr>
<td class=\"odd\">
<p>2</p>
</td>
<td class=\"odd\">
<p>Kalorier inn > kalorier ut</p>
</td>
<td class=\"odd\">
<p>Man spiser flere kalorer en det man forbrenner og man legger på seg.</p>
</td>
</tr>
<tr>
<td>
<p>3</p>
</td>
<td>
<p>Kalorier inn < kalorier ut</p>
</td>
<td>
<p>Man spiser mindre kalorier en det man forbrenner og man vil ta av seg vekt.</p>
</td>
</tr>
</tbody>
</table>
<h2>Kalorier</h2>
<p>Kroppen trenger kalorier for energi. Men hvis man spiser for mange kalorier - og ikke brenner nok av dem av gjennom aktivitet - fører til vektøkning.</p>
<p>De fleste matvarer og drikker inneholder kalorier. Noen matvarer, som for eksempel salat, inneholder få kalorier. Andre matvarer, som peanøtter, inneholder mange kalorier.</p>
<p>Du kan finne ut hvor mange kalorier er i en mat ved å se på etiketten. Etiketten vil også beskrive komponentene i maten - hvor mange gram karbohydrater, protein og fett den inneholder.</p>
<p>Definisjonen på en kalori er den mengden energi som trengs for å heve temperaturen av ett kilo vann med én grad Celsius. En kcal er det samme som 1000 kalorier.</p>
<h2>Karbohydrater</h2>
<p>Karbohydrater være bygd opp enkelt eller kompleks, alt ettersom størrelsen av det kjemiske molekylet.</p>
<ul>
<li>
<p><strong>Enkle karbohydrater:</strong> Ulike former for sukker, for eksempel glukose og sukrose (sukker). De er små molekyler som blir brutt ned og absorbert raskt av kroppen og er den raskeste energikilde.</p>
<p>Enkle karbohydrater øker nivået av blodsukker raskt. Frukt, meieriprodukter, honning og lønnesirup inneholder store mengder enkle karbohydrater, som gir den søte smaken i de fleste godteri og kaker.</p>
</li>
<li>
<p><strong>Komplekse karbohydrater:</strong> Disse karbohydrater er sammensatt av lange strenger av enkle karbohydrater. Fordi komplekse karbohydrater er større molekyler enn enkle karbohydrater, må de brytes ned til enkle karbohydrater før de kan bli absorbert. De vil derfor gi energi til kroppen saktere enn enkle karbohydrater, men likevel raskere enn protein eller fett.</p>
<p>Fordi de er fordøyningen av komplekse karbohydrater er saktere enn enkle karbohydrater er sannsynlighet mindre for at de blir omdannet til fett. De vil også øke blodsukkeret saktere og til lavere nivåer enn enkle karbohydrater og vil holde blodsukkere stabilt over en lengre tid. Komplekse karbohydrater inneholder stivelse og kostfiber, som oppstår i hveteprodukter (for eksempel brød og pasta), rug, mais, bønner og rotfrukter (for eksempel poteter).</p>
</li>
</ul>
<h2>Proteiner</h2>
<p>Proteiner består av enheter kalt aminosyrer. Fordi proteiner er komplekse molekyler bruker kroppen langt tid å bryte dem ned. Dette resulterer i at proteiner er mye langsommere og er en mer langvarig energikilde enn karbohydrater.</p>
<p>Det finnes 20 aminosyrer. Kroppen lager noen av disse selv, men kroppen klarer ikke å lage 9 essensielle aminosyrer. Dermed må de inn via kosten.</p>
<p>Alle mennesker trenger 8 av disse aminosyrene (isoleucin, leucin, lysin, metionin, fenylalanin, treonin, tryptofan og vali), mens spedbarn trenger 1 ekstra (histidin).</p>
<p>Prosentandelen av protein i kroppen kan bruke til å syntetisere essensielle aminosyrer varierer fra protein til protein. Legemet kan bruke 100% av proteinet i egg og en høy prosentandel av proteinene i melk og kjøtt. Kroppen kan bruke litt mindre enn halvparten av proteinet i de fleste grønnsaker og korn.</p>
<p>Kroppen trenger protein for å vedlikeholde og erstatte vev. Proteiner er også viktig for å kunne vokse samt å fungere. Protein brukes vanligvis ikke til energi, men hvis kroppen ikke får nok kalorier fra andre næringsstoffer eller fra fett lagret i kroppen, kan protein brukes til energi.</p>
<p>Kroppen inneholder store mengder protein. Protein er kroppens viktigste byggekloss og er den primære komponenten i de fleste celler. For eksempel finner vi proteiner i muskel, bindevev og hud.</p>
<h2>Fett</h2>
<p>Fett er komplekse molekyler som består av fettsyrer og glycerol. Kroppen trenger fett for vekst og energi. Fett brukes også til å syntetisere hormoner og for kroppens aktiviteter.</p>
<p>Fett er den tregeste energikilde, men den mest energieffektive form av mat. Hvert gram fett forsyner kroppen med ca 9 kalorier, mer enn dobbelt så stor som leveres av proteiner eller karbohydrater. Ettersom fett er en effektiv form for energi, lagrer kroppen fettet som energireserve. Kroppen kan også sette overflødig fett i blodårer og i indre organer. Dette er veldig farlig fordi det kan oppstå blokkeringer i blodstrømmen og skade organer som ofte forårsaker alvorlige lidelser.</p>
";

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>