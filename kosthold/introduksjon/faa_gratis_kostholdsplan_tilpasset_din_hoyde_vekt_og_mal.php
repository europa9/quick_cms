<?php
/*- Configuration ---------------------------------------------------------------------------- */
$layoutNumberOfColumn = "2";
$layoutCommentsActive = "1";

/*- Header ----------------------------------------------------------- */
$website_title = "Kosthold - Få gratis kostholdsplan tilpasset din høyde, vekt og mål";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");


/*- Content ---------------------------------------------------------- */
echo"
<h1>Få gratis kostholdsplan tilpasset din høyde, vekt og mål</h1>

$money


<table>
 <tr> 
  <td>
	<table>
	 <tr>
	  <td style=\"padding: 2px 4px 0px 10px;vertical-algin:top;\">
		<p><img src=\"gfx/success.png\" alt=\"success.png\" /></p>
	  </td>
	  <td style=\"padding: 0px 0px 0px 0px;vertical-algin:top;\">
		<p>Tilpasset din høyde og vekt</p>
	  </td>
	 </tr>
	 <tr>
	  <td style=\"padding: 2px 4px 0px 10px;vertical-algin:top;\">
		<p><img src=\"gfx/success.png\" alt=\"success.png\" /></p>
	  </td>
	  <td style=\"padding: 0px 0px 0px 0px;vertical-algin:top;\">
		<p>Lar deg oppnå dine mål</p>
	  </td>
	 </tr>
	 <tr>
	  <td style=\"padding: 2px 4px 0px 10px;vertical-algin:top;\">
		<p><img src=\"gfx/success.png\" alt=\"success.png\" /></p>
	  </td>
	  <td style=\"padding: 0px 0px 0px 0px;vertical-algin:top;\">
		<p>Få bedre blodtrykk</p>
	  </td>
	 </tr>
	 <tr>
	  <td style=\"padding: 2px 4px 0px 10px;vertical-algin:top;\">
		<p><img src=\"gfx/success.png\" alt=\"success.png\" /></p>
	  </td>
	  <td style=\"padding: 0px 0px 0px 0px;vertical-algin:top;\">
		<p>Få lavere hvilepuls</p>
	  </td>
	 </tr>
	</table>
  </td>
  <td>
	<img src=\"gfx/fisk_kjott_egg.jpg\" alt=\"fisk_kjott_egg.jpg\" />
  </td>
 </tr>
</table>
<p style=\"margin-bottom:0;padding-bottom:0;\">Det enste du behøver er å forteller oss hvem du er!</p>

<ul>
	<li><span>Kjønn</span></li>
	<li><span>Alder</span></li>
	<li><span>Høyde</span></li>
	<li><span>Vekt</span></li>
	<li><span>Forhold til kosthold</span></li>
	<li><span>Forhold til trening</span></li>
</ul>



<p>
<a href=\"$root/stram/index.php?action=setup_new_account&amp;focus=inp_antispam\" class=\"green_button\">Fortell oss hvem du er</a>
</p>



";


/*- Footer ----------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>