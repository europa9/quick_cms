<?php 
/**
*
* File: kosthold/proteinrik_mat.php
* Version 
* Date 2018-03-17 15:50:03
* Copyright (c) 2011-2018 Nettport.com
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "6";
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
$website_title = "Proteinrik mat";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */
echo"
<h1>Proteinrik mat</h1>

<p>
Protein er et næringsstoff som menneskekroppen er avhengig av for å vokse og vedlikeholde muskler. 

Protein finnes i alle cellene i kroppen, og er en viktig komponent for muskelene. 
Proteiner finnes også i kroppens organer, hår og hud. 
</p>


<p>
Omentrent 43 % av maten man spiser bør være proteiner. 
44 % bør være karbohydrater og 13 % fett. 
</p>


<h2>Kjøtt</h2>
	<div style=\"padding-left: 20px;\">
	<h3>Biff</h3>

		<p>
		Biff er en veldig god kilde til proteiner, men desverre veldig dyrt. Se derfor
		etter gode tilbud. 
		</p>

		<p>
		Stek biffen i stekepanne med melange slik at den ikke blir tørr. 
		De fleste liker biffen sin medium. 
		</p>


	<h3>Svinekoteletter</h3>

		<p>
		Koteletter er fulle av proteiner til musklene dine. 
		</p>

		<p>
		Styr unna røkte koteletter, da disse ofte ikke er ordentlig røkt. 
		Disse inneholder aromatilsetninger som kan være kreftfremkallende.
		</p>

	<h3>Kylling</h3>

		<p>
		Kyllingfilet, kyllinglår eller hel kylling er perfekt for aktive personer.
		Kjøp alltid kyllingfilet på butikken og ha det liggende i fryseboksen klar til steking. 
		</p>

		<p>
		Kjøp store kvantum kyllingfilet for å spare mest mulig penger. Styr unna kyllingfilet kjøpt
		i utlandet da disse kan inneholde antibiotika. 
		</p>

	<h3>Kalkun</h3>

		<p>
		Kalkunfilet inneholder masse proteiner som er bra for muskelveksten. 
		</p>

		<p>
		Vær forsiktig med kalkunfilet fra utlandet da fuglene ofte er matet med antibiotika.	
		</p>
	</div>

<h2>Sjømat</h2>

	
	<div style=\"padding-left: 20px;\">
	<h3>Tunfisk</h3>

		<p>
		Denne fisken krever kanskje litt tilvenning men tenk på at den inneholder proteiner, vitamin B
		og viktige antioksidanter.
		</p>

		<p>
		Tunfisk i salat er et godt alternativ til lunsj. 
		</p>

	<h3>Ørret</h3>

		<p>
		Ørret inneholder mye omega-3-fettsyrer og er rik på de fettløselige vitaminene A og D. Kjøttet er middels fett og rødlig i fargen.
		</p>

		<p>
		Kjøp frosne fileter på butikken. Tin ove natten i kjøleskapet 
		morgendagens middag.
		</p>


	<h3>Laks</h3>

		<p>
		En fisk som inneholder masse omega 3 og protein. 
		Kjøp laks med skinn, da denne gir bedre smak på fisken. 
		</p>

		<p>
		Villaks smaker bedre og inneholder mer protein, men er dyrere.
		</p>


	
	<h3>Hyse</h3>

		<p>
		Hyse (kolje) er en fisk i torskefamilien. 
		Hysen ses på som en slank fisk med mindre en 2 1/2 % fett. 
		I tillegg til proteiner har den et 
		stort innhold av vitamin A, B12 og D. 
		</p>
		
		<p>
		Hysen inneholder 11 % jern, noe som er veldig helsebringende.
		</p>

	<h3>Torsk</h3>

		<p>
		Torsken inneholder mye proteiner, omega-3 og 
		forebygger og kontrollerer høyt blodtrykk. 
		</p>

		<p>
		Kysttorsken som lever forholdsvis stasjonært i kyststrøk og nært bunnen, og den vandrende oseaniske torsken (skrei) som i større grad lever pelagisk og dypere på åpent hav.
		</p>
	</div>

<h2>Meieri</h2>
	<div style=\"padding-left: 20px;\">
	<h3>Egg</h3>

	<p>
	Egg er den ultimate muskelmaten. 
	De inneholder mer proteiner enn nesten alle andre matvarer. 
	Egg har mye aminosyrer som er viktig for muskler.
	</p>

	<p>
	Eggehviten er kun proteiner, mens eggeplommen inneholder mye fett.
	</p>

	<h3>Skyr</h3>

	<p>
	Skry fettfritt meieriprodukt med lange tradisjoner i islandsk og norsk kultur. 
	Produktet kan minne om yoghurt, men har en tykkere konsistens. Skyr har en litt syrlig melkesmak med et snev av gjenværende sødme, 
	og leveres i smakstilsatte varianter på linje med fruktyoghurt for å øke sin appell hos forbrukerne.
	</p>
	
	<p>
	Små bokser med skyr innehodler mindre sukker en store bokser, men er til gjengjeld dyrere. 
	</p>

	<h3>Ekstra lett melk</h3>

	<p>
	Melk inneholder vitamin D og mye proteiner. 
	Du kan også drikke myseprotein eller sjokolademelk uten sukker. 
	</p>
	
	<p>
	Bytt gjerne ut melk med soyamelk, men se etter usøtet type.
	</p>

	<h3>Gresk yogurt</h3>

	<p>
	Gresk yoghurt inneholder omtrent dobbelt så mye protein som vanlig yogurt. 
	Yogurt har rikelig med kalsium som hjelper på beinbygging.
	</p>

	<p>
	Naturell gresk yoghurt kan inneholde opptil tre ganger mindre sukker enn typer med smak.
	</p>


	<h3>Cottage cheese</h3>

	<p>
	Cottage cheese har kasein-protein som gir musklene en jevn tilførsel av aminosyrer. 
	Bruk cottage cheese som snacks før trening og gjerne til kveldsmat. 
	</p>

	<p>
	Cottage cheese har et høyt innhold av natrium så se på etikettene for å hvilken type
	som har minst natrium.
	</p>


	<h3>Sveitsisk ost</h3>

	<p>
	Sveitserost gir mer protein enn andre typer vanlige oster. 
	Bruk denne osten på lasagne, smørbrød og hamburgere.
	</p>

	<p>
	Det finnes sveitiske oster med mindre fett i seg, se etter disse 
	på butikken.
	</p>
	</div>


<h2>Pålegg</h2>
	<div style=\"padding-left: 20px;\">
		<h3>Roastbiff</h3>

		<p>
		Roastbiff er storfekjøtt stekt i stekeovn. 
		Kjøttet stekes ved lav varme, og skal være rosa til rødt i midten ved servering. 
		</p>

		<p>
		Roastbiff inneholder 27 % proteiner, 3 % fett og ingen sukker. 
		</p>

		<h3>Kyllingfilet</h3>

		<p>
		Kyllingfilet er kjempegodt pålegg med mye proteiner.
		</p>		

		<p>
		Hvis du ikke ønsker kylling kan du isteden spise kalkunfilet. 
		</p>
	
	</div>


<h2>Snacks</h2>

	<div style=\"padding-left: 20px;\">
		<h3>Tørket oksekjøtt (jerky)</h3>

		<p>
		Noen butikken selger tørket okse- eller 
		reinkjøtt. Dette er den ultimate snacksen for 
		seriøse muskelbyggere.
		</p>

		<p>
		Spekemat er et godt alternativ til tørket oksekjøtt.
		</p>

		<h3>Nøtteblanding</h3>
		
		<p>
		Peanøtter, cashewnøtter og mandler inneholder mye protein og sunt umettet fett. 
		De inneholder også mye kcal, så les pakningene nøye.
		</p>

		<p>
		Det er en myte at for mye salt er skadelig, og at vi får i oss for mye salt,
		så du trenger ikke se etter usaltet type.
		</p>

	</div>


<h2>Frossenmat</h2>


	<div style=\"padding-left: 20px;\">

		<h3>Grønnsaksblandinger</h3>
		
		<p>
		Brokkoliblanding inneholder rundt 2 % proteiner, så det er ikke så mye i 
		forhold til kjøtt. Det er alikavel veldig viktig at du spiser
		grønnsaker som brokkoli, gulrøtter, blomkål og bønner da disse inneholder
		vitaminer og mineraler. 
		</p>

		<p>
		En hel pakke med Eldorado frosen brokkoliblanding inneholder kun 65 kcal. 
		Her kan du spise så mye du måtte ønske.
		</p>
	</div>


<h2>Korn</h2>


	<div style=\"padding-left: 20px;\">

		<h3>Havregryn</h3>
		
		<p>
		Havregryn er valset, hel havre. De er lettkokt, og kan brukes som ingrediens i f.eks. havregrøt og brødvarer. 
		Det går også an å bruke havregryn som frokostblanding. Produktet ble opprinnelig fremstilt til å lage havregrøt av.
		</p>

		<p>
		Spiren i havregrynet er den mest næringsrike delen og inneholder store mengder plantebasert proteiner. 
		</p>
	</div>
";

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>