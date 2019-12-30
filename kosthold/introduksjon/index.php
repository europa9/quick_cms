<?php
/*- Configuration ---------------------------------------------------------------------------- */
$layoutNumberOfColumn = "2";
$layoutCommentsActive = "1";

/*- Header ----------------------------------------------------------- */
$website_title = "Kosthold - Introduksjon";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");


/*- Content ---------------------------------------------------------- */
echo"
			
<h1>Kosthold</h1> 
$money

<p>
Kosthold kan v�re forvirrende men i utgangspunktet kan man si at kosthold er 3 enkle formler.
Selv om formlene er enkle er det unntakene som gj�r alt forvirrende. For eksempel b�r
et kosthold aldri best� av mindre en 1500 kcal.
</p>



<table>
 <tr>
  <td class=\"outline\">
	<table style=\"border-spacing: 1px;width: 100%;\">
	 <tr>
	  <td style=\"padding-right: 8px\" class=\"headcell\">
		<span><b>#</b></span>
	  </td>
	  <td style=\"padding-right: 8px;width:180px;\" class=\"headcell\">
		<span><b>Tilfelle</b></span>
	  </td>
	  <td class=\"headcell\">
		<span><b>Konsekvens</b></span>
	  </td>		
	 </tr>
	 <tr>
	  <td class=\"bodycell\" style=\"padding-right: 8px;vertical-align:top;\">
		<p>1</p>
	  </td>
	  <td class=\"bodycell\" style=\"padding-right: 8px;vertical-align:top;\">
		<p>Kalorier inn = kalorier ut</p>
	  </td>
	  <td class=\"bodycell\" style=\"vertical-align:top;\">
		<p>
		Man spiser like mange kalorier som man forbrenner og dermed vil
		man opprettholde sin vekt.
		</p>
	  </td>
	 </tr>
	 <tr>
	  <td class=\"subcell\" style=\"padding-right: 8px;vertical-align:top;\">
		<p>2</p>
	  </td>
	  <td class=\"subcell\" style=\"padding-right: 8px;vertical-align:top;\">
		<p>Kalorier inn &gt; kalorier ut</p>
	  </td>
	  <td class=\"subcell\" style=\"vertical-align:top;\">
		<p>
		Man spiser flere kalorer en det man forbrenner og man legger p� seg.
		</p>
	  </td>
	 </tr>
	 <tr>
	  <td class=\"bodycell\" style=\"padding-right: 8px;vertical-align:top;\">
		<p>3</p>
	  </td>
	  <td class=\"bodycell\" style=\"padding-right: 8px;vertical-align:top;\">
		<p>Kalorier inn &lt; kalorier ut</p>
	  </td>
	  <td class=\"bodycell\" style=\"vertical-align:top;\">
		<p>
		Man spiser mindre kalorier en det man forbrenner og man vil ta av seg vekt.
		</p>
	  </td>
	 </tr>
	</table>
  </td>
 </tr>
</table>
<h2>Kalorier</h2>

	<p>
	Kroppen trenger kalorier for energi. Men hvis man spiser for mange kalorier - og ikke brenner nok av dem av gjennom aktivitet - f�rer til vekt�kning.
	</p>

	<p>
	De fleste matvarer og drikker inneholder kalorier. Noen matvarer, som for eksempel salat, inneholder f� kalorier. 
	Andre matvarer, som pean�tter, inneholder mange kalorier.
	</p>

	<p>
	Du kan finne ut hvor mange kalorier er i en mat ved � se p� etiketten. Etiketten vil ogs� beskrive komponentene i maten - hvor mange gram karbohydrater, protein og fett den inneholder.
	</p>

	<p>
	Definisjonen p� en kalori er den mengden energi som trengs for � heve temperaturen av ett kilo vann med �n grad Celsius. 
	En kcal er det samme som 1000 kalorier.
	</p>

<h2>Karbohydrater</h2>

	<p>
	Karbohydrater v�re bygd opp enkelt eller kompleks, alt ettersom st�rrelsen av det kjemiske
	molekylet.
	</p>

	<ul>
		<li><p><b>Enkle karbohydrater:</b> Ulike former for sukker, for eksempel glukose og sukrose (sukker). 
		De er sm� molekyler som blir brutt ned og absorbert raskt av kroppen og er den raskeste energikilde. 
		</p>
		<p>
		Enkle karbohydrater �ker niv�et av blodsukker raskt. 
		Frukt, meieriprodukter, honning og l�nnesirup inneholder store mengder enkle karbohydrater, som gir den s�te smaken i de fleste godteri og kaker.
		</p></li>

		<li><p><b>Komplekse karbohydrater:</b> Disse karbohydrater er sammensatt av lange strenger av enkle karbohydrater. 
		Fordi komplekse karbohydrater er st�rre molekyler enn enkle karbohydrater, m� de brytes ned til enkle karbohydrater f�r de kan bli absorbert. 
		De vil derfor gi energi til kroppen saktere enn enkle karbohydrater, men likevel raskere enn protein eller fett. 
		</p>
		<p>
		Fordi de er ford�yningen av komplekse karbohydrater er saktere enn enkle karbohydrater er sannsynlighet mindre for at de blir omdannet til fett.
		De vil ogs� �ke blodsukkeret saktere og til lavere niv�er enn enkle karbohydrater og vil holde blodsukkere stabilt over
		en lengre tid. 
		Komplekse karbohydrater inneholder stivelse og kostfiber, som oppst�r i hveteprodukter (for eksempel br�d og pasta), rug, mais, b�nner og rotfrukter (for eksempel poteter).
		</p></li>
	</ul>



<h2>Proteiner</h2>
	<p>
	Proteiner best�r av enheter kalt aminosyrer. 
	Fordi proteiner er komplekse molekyler bruker kroppen langt tid � bryte dem ned. 
	Dette resulterer i at proteiner er mye langsommere og er en mer langvarig energikilde enn karbohydrater.
	</p>

	<p>
	Det finnes 20 aminosyrer. Kroppen lager noen av disse selv, men kroppen klarer ikke � lage 9 essensielle aminosyrer. 
	Dermed m� de inn via kosten.
	</p>

	<p>
	Alle mennesker trenger 8 av disse aminosyrene (isoleucin, leucin, lysin, metionin, fenylalanin, treonin, tryptofan og vali), 
		mens spedbarn trenger 1 ekstra (histidin).
	</p>

	<p>
	Prosentandelen av protein i kroppen kan bruke til � syntetisere essensielle aminosyrer varierer fra protein til protein. 
	Legemet kan bruke 100% av proteinet i egg og en h�y prosentandel av proteinene i melk og kj�tt. 
	Kroppen kan bruke litt mindre enn halvparten av proteinet i de fleste gr�nnsaker og korn.
	</p>

	<p>
	Kroppen trenger protein for � vedlikeholde og erstatte vev.
	Proteiner er ogs� viktig for � kunne vokse samt � fungere. 
	Protein brukes vanligvis ikke til energi, men hvis kroppen ikke f�r nok kalorier fra andre n�ringsstoffer eller fra fett lagret i kroppen, kan protein brukes til energi. 
	</p>

	<p>
	Kroppen inneholder store mengder protein. Protein er kroppens viktigste byggekloss og er den prim�re komponenten i de fleste celler. 
	For eksempel finner vi proteiner i muskel, bindevev og hud.
	</p>

<h2>Fett</h2>
	<p>
	Fett er komplekse molekyler som best�r av fettsyrer og glycerol. 
	Kroppen trenger fett for vekst og energi. 
	Fett brukes ogs� til � syntetisere hormoner og for kroppens aktiviteter.
	</p>

	<p>
	Fett er den tregeste energikilde, men den mest energieffektive form av mat. 
	Hvert gram fett forsyner kroppen med ca 9 kalorier, mer enn dobbelt s� stor som leveres av proteiner eller karbohydrater. 
	Ettersom fett er en effektiv form for energi, lagrer kroppen fettet som energireserve. 
	Kroppen kan ogs� sette overfl�dig fett i blod�rer og i indre organer.
	Dette er veldig farlig fordi det kan oppst� blokkeringer i blodstr�mmen og skade organer som ofte for�rsaker alvorlige lidelser.
	</p>



";


/*- Footer ----------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>