<?php 
/**
*
* File: diet/index.php
* Version 
* Date 2018-03-17 13:32:14
* Copyright (c) 2011-2018 Nettport.com
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "2";
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
$website_title = "Diet";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */
echo"
<h1><span id=\"result_box\" class=\"short_text\" lang=\"en\"><span class=\"\">Diet</span></span></h1>
<p>Kosthold kan v&aelig;re forvirrende men i utgangspunktet kan man si at kosthold er 3 enkle formler. Selv om formlene er enkle er det unntakene som gj&oslash;r alt forvirrende. For eksempel b&oslash;r et kosthold aldri best&aring; av mindre en 1500 kcal.</p>
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
<p>Kalorier inn &gt; kalorier ut</p>
</td>
<td class=\"odd\">
<p>Man spiser flere kalorer en det man forbrenner og man legger p&aring; seg.</p>
</td>
</tr>
<tr>
<td>
<p>3</p>
</td>
<td>
<p>Kalorier inn &lt; kalorier ut</p>
</td>
<td>
<p>Man spiser mindre kalorier en det man forbrenner og man vil ta av seg vekt.</p>
</td>
</tr>
</tbody>
</table>
<h2>Kalorier</h2>
<p>Kroppen trenger kalorier for energi. Men hvis man spiser for mange kalorier - og ikke brenner nok av dem av gjennom aktivitet - f&oslash;rer til vekt&oslash;kning.</p>
<p>De fleste matvarer og drikker inneholder kalorier. Noen matvarer, som for eksempel salat, inneholder f&aring; kalorier. Andre matvarer, som pean&oslash;tter, inneholder mange kalorier.</p>
<p>Du kan finne ut hvor mange kalorier er i en mat ved &aring; se p&aring; etiketten. Etiketten vil ogs&aring; beskrive komponentene i maten - hvor mange gram karbohydrater, protein og fett den inneholder.</p>
<p>Definisjonen p&aring; en kalori er den mengden energi som trengs for &aring; heve temperaturen av ett kilo vann med &eacute;n grad Celsius. En kcal er det samme som 1000 kalorier.</p>
<h2>Karbohydrater</h2>
<p>Karbohydrater v&aelig;re bygd opp enkelt eller kompleks, alt ettersom st&oslash;rrelsen av det kjemiske molekylet.</p>
<ul>
<li>
<p><strong>Enkle karbohydrater:</strong> Ulike former for sukker, for eksempel glukose og sukrose (sukker). De er sm&aring; molekyler som blir brutt ned og absorbert raskt av kroppen og er den raskeste energikilde.</p>
<p>Enkle karbohydrater &oslash;ker niv&aring;et av blodsukker raskt. Frukt, meieriprodukter, honning og l&oslash;nnesirup inneholder store mengder enkle karbohydrater, som gir den s&oslash;te smaken i de fleste godteri og kaker.</p>
</li>
<li>
<p><strong>Komplekse karbohydrater:</strong> Disse karbohydrater er sammensatt av lange strenger av enkle karbohydrater. Fordi komplekse karbohydrater er st&oslash;rre molekyler enn enkle karbohydrater, m&aring; de brytes ned til enkle karbohydrater f&oslash;r de kan bli absorbert. De vil derfor gi energi til kroppen saktere enn enkle karbohydrater, men likevel raskere enn protein eller fett.</p>
<p>Fordi de er ford&oslash;yningen av komplekse karbohydrater er saktere enn enkle karbohydrater er sannsynlighet mindre for at de blir omdannet til fett. De vil ogs&aring; &oslash;ke blodsukkeret saktere og til lavere niv&aring;er enn enkle karbohydrater og vil holde blodsukkere stabilt over en lengre tid. Komplekse karbohydrater inneholder stivelse og kostfiber, som oppst&aring;r i hveteprodukter (for eksempel br&oslash;d og pasta), rug, mais, b&oslash;nner og rotfrukter (for eksempel poteter).</p>
</li>
</ul>
<h2>Proteiner</h2>
<p>Proteiner best&aring;r av enheter kalt aminosyrer. Fordi proteiner er komplekse molekyler bruker kroppen langt tid &aring; bryte dem ned. Dette resulterer i at proteiner er mye langsommere og er en mer langvarig energikilde enn karbohydrater.</p>
<p>Det finnes 20 aminosyrer. Kroppen lager noen av disse selv, men kroppen klarer ikke &aring; lage 9 essensielle aminosyrer. Dermed m&aring; de inn via kosten.</p>
<p>Alle mennesker trenger 8 av disse aminosyrene (isoleucin, leucin, lysin, metionin, fenylalanin, treonin, tryptofan og vali), mens spedbarn trenger 1 ekstra (histidin).</p>
<p>Prosentandelen av protein i kroppen kan bruke til &aring; syntetisere essensielle aminosyrer varierer fra protein til protein. Legemet kan bruke 100% av proteinet i egg og en h&oslash;y prosentandel av proteinene i melk og kj&oslash;tt. Kroppen kan bruke litt mindre enn halvparten av proteinet i de fleste gr&oslash;nnsaker og korn.</p>
<p>Kroppen trenger protein for &aring; vedlikeholde og erstatte vev. Proteiner er ogs&aring; viktig for &aring; kunne vokse samt &aring; fungere. Protein brukes vanligvis ikke til energi, men hvis kroppen ikke f&aring;r nok kalorier fra andre n&aelig;ringsstoffer eller fra fett lagret i kroppen, kan protein brukes til energi.</p>
<p>Kroppen inneholder store mengder protein. Protein er kroppens viktigste byggekloss og er den prim&aelig;re komponenten i de fleste celler. For eksempel finner vi proteiner i muskel, bindevev og hud.</p>
<h2>Fett</h2>
<p>Fett er komplekse molekyler som best&aring;r av fettsyrer og glycerol. Kroppen trenger fett for vekst og energi. Fett brukes ogs&aring; til &aring; syntetisere hormoner og for kroppens aktiviteter.</p>
<p>Fett er den tregeste energikilde, men den mest energieffektive form av mat. Hvert gram fett forsyner kroppen med ca 9 kalorier, mer enn dobbelt s&aring; stor som leveres av proteiner eller karbohydrater. Ettersom fett er en effektiv form for energi, lagrer kroppen fettet som energireserve. Kroppen kan ogs&aring; sette overfl&oslash;dig fett i blod&aring;rer og i indre organer. Dette er veldig farlig fordi det kan oppst&aring; blokkeringer i blodstr&oslash;mmen og skade organer som ofte for&aring;rsaker alvorlige lidelser.</p>
";

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>