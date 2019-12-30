<?php
/*- Configuration ---------------------------------------------------------------------------- */
$layoutNumberOfColumn = "2";
$layoutCommentsActive = "1";

/*- Header ----------------------------------------------------------- */
$website_title = "Kosthold - Kostholdsplan handleliste";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");


/*- Content ---------------------------------------------------------- */
echo"
<h1>Kostholdsplan handleliste</h1>

$money

<h2>Ukentlig handleliste</h2>
	<table style=\"width: 100%\">
	 <tr>
	  <td class=\"outline\">
		<table style=\"border-spacing: 1px;width: 100%;\">
		 <tr>
		  <td style=\"width: 40%;padding-right: 8px;\" class=\"headcell\">
			<span><b>Vare</b></span>
		  </td>
		  <td style=\"width: 30%;padding-right: 8px;text-align: right;\" class=\"headcell\">
			<span><b>Pris pr</b></span>
		  </td>
		  <td style=\"width: 30%;padding-right: 8px;text-align: right;\" class=\"headcell\">
			<span><b>Pris totalt</b></span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>2 pk 18 First price egg</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>37,90</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>75,8</span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>1 pk 6 egg</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span></span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>22,40</span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>700 g kalkunfilet</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span></span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span></span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>4 pk grønnsaksblanding</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span></span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span></span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>1 pk Lettkokte havregryn</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span></span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>11,80</span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>1 pk Store havregryn</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span></span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>17,5</span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>7 bokser 200 g reker</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>36,90</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>258,30</span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>2 pK ferdig salat</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>24,96</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>49,92</span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>2 pk Vita hjertegod rundstykker</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>31,10</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>62,20</span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>1 pk First price kyllingfilet</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span></span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>111,84</span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>1 pk Fullkornspasta</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span></span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>19,5</span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>2 pk Wasa Sport +</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>7,00</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>14,00</span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>2 pk roastbeef</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>28,90</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>57,81</span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>1 pk kyllingfilet pålegg</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span></span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span></span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>1 pk kalkunfilet pålegg</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span></span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>16,90</span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>1 pk Philadelphia light</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span></span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>22,90</span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>1 stor paprika</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span></span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>8,17</span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>4 epler</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span></span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>17,71</span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>2 baner</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span></span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>9,19</span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>1 pk druer</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span></span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>29,90</span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>7 små skyr</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>16,90</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>118,30</span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>1 boks lett kokosmelk</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span></span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span>12,40</span>
		  </td>
		 </tr>
		</table>
	  </td>
	 </tr>
	</table>






<h2>Måntelig handleliste</h2>

	<table style=\"width: 100%\">
	 <tr>
	  <td class=\"outline\">
		<table style=\"border-spacing: 1px;width: 100%;\">
		 <tr>
		  <td style=\"width: 40%;padding-right: 8px;\" class=\"headcell\">
			<span><b>Vare</b></span>
		  </td>
		  <td style=\"width: 30%;padding-right: 8px;text-align: right;\" class=\"headcell\">
			<span><b>Pris pr</b></span>
		  </td>
		  <td style=\"width: 30%;padding-right: 8px;text-align: right;\" class=\"headcell\">
			<span><b>Pris totalt</b></span>
		  </td>
		 </tr>
		 <tr>
		  <td class=\""; if($style == "subcell"){ $style = "bodycell"; } else{ $style = "subcell"; } echo"$style\">
			<span>Proteinpulver</span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span></span>
		  </td>
		  <td style=\"text-align: right;\" class=\"$style\">
			<span></span>
		  </td>
		 </tr>
		</table>
	  </td>
	 </tr>
	</table>







";


/*- Footer ----------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>