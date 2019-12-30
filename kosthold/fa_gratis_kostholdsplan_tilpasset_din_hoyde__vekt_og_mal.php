<?php 
/**
*
* File: kosthold/fa_gratis_kostholdsplan_tilpasset_din_hoyde__vekt_og_mal.php
* Version 
* Date 2018-03-17 18:26:01
* Copyright (c) 2011-2018 Nettport.com
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "1803291401";
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
$website_title = "F&aring; gratis kostholdsplan tilpasset din h&oslash;yde, vekt og m&aring;l";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */
echo"
<h1>Få gratis kostholdsplan tilpasset din høyde, vekt og mål</h1>



<img src=\"gfx/fisk_kjott_egg.jpg\" alt=\"fisk_kjott_egg.jpg\" style=\"float: right;\" />

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

<p style=\"margin-bottom:0;padding-bottom:0;\">Det enste du behøver er å forteller oss hvem du er!</p>

<ul>
	<li><span>Kjønn</span></li>
	<li><span>Alder</span></li>
	<li><span>Høyde</span></li>
	<li><span>Vekt</span></li>
	<li><span>Forhold til kosthold</span></li>
	<li><span>Forhold til trening</span></li>
</ul>


<div style=\"height: 10px;\"></div>
<p>";
	
	if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
		echo"<a href=\"../discuss/form_view.php?form_id=1&amp;l=no\" class=\"btn btn_success\">Fortell oss hvem du er</a>";
	}
	else{
		echo"<a href=\"../users/create_free_account.php?l=no\" class=\"btn btn_success\">Ny bruker</a>
		<a href=\"../discuss/form_view.php?form_id=1&amp;l=no\" class=\"btn btn_success\">Eksisterende bruker</a>";
	}
echo"
</p>
<div style=\"height: 20px;\"></div>

";

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>