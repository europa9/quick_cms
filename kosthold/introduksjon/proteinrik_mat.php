<?php
/*- Configuration ---------------------------------------------------------------------------- */
$layoutNumberOfColumn = "2";
$layoutCommentsActive = "1";


/*- Header ----------------------------------------------------------- */
$website_title = "Kosthold - Proteinrik mat";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");


/*- Content ---------------------------------------------------------- */
echo"
<h1>Proteinrik mat</h1>

$money

<!-- Linker -->
	<table>
	 <tr>
	  <td style=\"padding: 2px 4px 0px 0px;\">
		<p><a href=\"faa_gratis_kostholdsplan_tilpasset_din_hoyde_vekt_og_mal.php\"><img src=\"gfx/list-add.png\" alt=\"list-add.png\" /></a></p>
	  </td>
	  <td>
		<p><a href=\"faa_gratis_kostholdsplan_tilpasset_din_hoyde_vekt_og_mal.php\">F� gratis kostholdsplan tilpasset din h�yde, vekt og m�l</a></p>
	  </td>
	 </tr>
	</table>
<!-- //Linker -->
<p>
Protein er et n�ringsstoff som menneskekroppen er avhengig av for � vokse og vedlikeholde muskler. 

Protein finnes i alle cellene i kroppen, og er en viktig komponent for muskelene. 
Proteiner finnes ogs� i kroppens organer, h�r og hud. 
</p>


<p>
Omentrent 43 % av maten man spiser b�r v�re proteiner. 
44 % b�r v�re karbohydrater og 13 % fett. 
</p>


<h2>Kj�tt</h2>
	<div style=\"padding-left: 20px;\">
	<h3>Biff</h3>

		<p>
		Biff er en veldig god kilde til proteiner, men desverre veldig dyrt. Se derfor
		etter gode tilbud. 
		</p>

		<p>
		Stek biffen i stekepanne med melange slik at den ikke blir t�rr. 
		De fleste liker biffen sin medium. 
		</p>


	<h3>Svinekoteletter</h3>

		<p>
		Koteletter er fulle av proteiner til musklene dine. 
		</p>

		<p>
		Styr unna r�kte koteletter, da disse ofte ikke er ordentlig r�kt. 
		Disse inneholder aromatilsetninger som kan v�re kreftfremkallende.
		</p>

	<h3>Kylling</h3>

		<p>
		Kyllingfilet, kyllingl�r eller hel kylling er perfekt for aktive personer.
		Kj�p alltid kyllingfilet p� butikken og ha det liggende i fryseboksen klar til steking. 
		</p>

		<p>
		Kj�p store kvantum kyllingfilet for � spare mest mulig penger. Styr unna kyllingfilet kj�pt
		i utlandet da disse kan inneholde antibiotika. 
		</p>

	<h3>Kalkun</h3>

		<p>
		Kalkunfilet inneholder masse proteiner som er bra for muskelveksten. 
		</p>

		<p>
		V�r forsiktig med kalkunfilet fra utlandet da fuglene ofte er matet med antibiotika.	
		</p>
	</div>

<h2>Sj�mat</h2>

	
	<div style=\"padding-left: 20px;\">
	<h3>Tunfisk</h3>

		<p>
		Denne fisken krever kanskje litt tilvenning men tenk p� at den inneholder proteiner, vitamin B
		og viktige antioksidanter.
		</p>

		<p>
		Tunfisk i salat er et godt alternativ til lunsj. 
		</p>

	<h3>�rret</h3>

		<p>
		�rret inneholder mye omega-3-fettsyrer og er rik p� de fettl�selige vitaminene A og D. Kj�ttet er middels fett og r�dlig i fargen.
		</p>

		<p>
		Kj�p frosne fileter p� butikken. Tin ove natten i kj�leskapet 
		morgendagens middag.
		</p>


	<h3>Laks</h3>

		<p>
		En fisk som inneholder masse omega 3 og protein. 
		Kj�p laks med skinn, da denne gir bedre smak p� fisken. 
		</p>

		<p>
		Villaks smaker bedre og inneholder mer protein, men er dyrere.
		</p>


	
	<h3>Hyse</h3>

		<p>
		Hyse (kolje) er en fisk i torskefamilien. 
		Hysen ses p� som en slank fisk med mindre en 2 1/2 % fett. 
		I tillegg til proteiner har den et 
		stort innhold av vitamin A, B12 og D. 
		</p>
		
		<p>
		Hysen inneholder 11 % jern, noe som er veldig helsebringende.
		</p>

	<h3>Torsk</h3>

		<p>
		Torsken inneholder mye proteiner, omega-3 og 
		forebygger og kontrollerer h�yt blodtrykk. 
		</p>

		<p>
		Kysttorsken som lever forholdsvis stasjon�rt i kyststr�k og n�rt bunnen, og den vandrende oseaniske torsken (skrei) som i st�rre grad lever pelagisk og dypere p� �pent hav.
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
	Produktet kan minne om yoghurt, men har en tykkere konsistens. Skyr har en litt syrlig melkesmak med et snev av gjenv�rende s�dme, 
	og leveres i smakstilsatte varianter p� linje med fruktyoghurt for � �ke sin appell hos forbrukerne.
	</p>
	
	<p>
	Sm� bokser med skyr innehodler mindre sukker en store bokser, men er til gjengjeld dyrere. 
	</p>

	<h3>Ekstra lett melk</h3>

	<p>
	Melk inneholder vitamin D og mye proteiner. 
	Du kan ogs� drikke myseprotein eller sjokolademelk uten sukker. 
	</p>
	
	<p>
	Bytt gjerne ut melk med soyamelk, men se etter us�tet type.
	</p>

	<h3>Gresk yogurt</h3>

	<p>
	Gresk yoghurt inneholder omtrent dobbelt s� mye protein som vanlig yogurt. 
	Yogurt har rikelig med kalsium som hjelper p� beinbygging.
	</p>

	<p>
	Naturell gresk yoghurt kan inneholde opptil tre ganger mindre sukker enn typer med smak.
	</p>


	<h3>Cottage cheese</h3>

	<p>
	Cottage cheese har kasein-protein som gir musklene en jevn tilf�rsel av aminosyrer. 
	Bruk cottage cheese som snacks f�r trening og gjerne til kveldsmat. 
	</p>

	<p>
	Cottage cheese har et h�yt innhold av natrium s� se p� etikettene for � hvilken type
	som har minst natrium.
	</p>


	<h3>Sveitsisk ost</h3>

	<p>
	Sveitserost gir mer protein enn andre typer vanlige oster. 
	Bruk denne osten p� lasagne, sm�rbr�d og hamburgere.
	</p>

	<p>
	Det finnes sveitiske oster med mindre fett i seg, se etter disse 
	p� butikken.
	</p>
	</div>


<h2>P�legg</h2>
	<div style=\"padding-left: 20px;\">
		<h3>Roastbiff</h3>

		<p>
		Roastbiff er storfekj�tt stekt i stekeovn. 
		Kj�ttet stekes ved lav varme, og skal v�re rosa til r�dt i midten ved servering. 
		</p>

		<p>
		Roastbiff inneholder 27 % proteiner, 3 % fett og ingen sukker. 
		</p>

		<h3>Kyllingfilet</h3>

		<p>
		Kyllingfilet er kjempegodt p�legg med mye proteiner.
		</p>		

		<p>
		Hvis du ikke �nsker kylling kan du isteden spise kalkunfilet. 
		</p>
	
	</div>


<h2>Snacks</h2>

	<div style=\"padding-left: 20px;\">
		<h3>T�rket oksekj�tt (jerky)</h3>

		<p>
		Noen butikken selger t�rket okse- eller 
		reinkj�tt. Dette er den ultimate snacksen for 
		seri�se muskelbyggere.
		</p>

		<p>
		Spekemat er et godt alternativ til t�rket oksekj�tt.
		</p>

		<h3>N�tteblanding</h3>
		
		<p>
		Pean�tter, cashewn�tter og mandler inneholder mye protein og sunt umettet fett. 
		De inneholder ogs� mye kcal, s� les pakningene n�ye.
		</p>

		<p>
		Det er en myte at for mye salt er skadelig, og at vi f�r i oss for mye salt,
		s� du trenger ikke se etter usaltet type.
		</p>

	</div>


<h2>Frossenmat</h2>


	<div style=\"padding-left: 20px;\">

		<h3>Gr�nnsaksblandinger</h3>
		
		<p>
		Brokkoliblanding inneholder rundt 2 % proteiner, s� det er ikke s� mye i 
		forhold til kj�tt. Det er alikavel veldig viktig at du spiser
		gr�nnsaker som brokkoli, gulr�tter, blomk�l og b�nner da disse inneholder
		vitaminer og mineraler. 
		</p>

		<p>
		En hel pakke med Eldorado frosen brokkoliblanding inneholder kun 65 kcal. 
		Her kan du spise s� mye du m�tte �nske.
		</p>
	</div>


<h2>Korn</h2>


	<div style=\"padding-left: 20px;\">

		<h3>Havregryn</h3>
		
		<p>
		Havregryn er valset, hel havre. De er lettkokt, og kan brukes som ingrediens i f.eks. havregr�t og br�dvarer. 
		Det g�r ogs� an � bruke havregryn som frokostblanding. Produktet ble opprinnelig fremstilt til � lage havregr�t av.
		</p>

		<p>
		Spiren i havregrynet er den mest n�ringsrike delen og inneholder store mengder plantebasert proteiner. 
		</p>
	</div>

";


/*- Footer ----------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>