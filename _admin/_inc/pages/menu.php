<?php
/**
*
* File: _admin/_inc/settings/menu.php
* Version 02:10 28.12.2011
* Copyright (c) 2008-2012 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Language --------------------------------------------------------------------------- */
include("_translations/admin/$l/pages/t_common.php");


if($page == "menu"){
	echo"
	<h1>Pages</h1>
	<div class=\"vertical\">
		<ul>
			<li><a href=\"index.php?open=$open&amp;editor_language=$editor_language\">Pages</a></li>

	";
}
echo"
			<li";if($page == "new_page"){echo" class=\"down\"";}echo"><a href=\"./?open=pages&amp;page=new_page&amp;editor_language=$editor_language\"";if($page == "new_page"){echo" class=\"selected\"";}echo">$l_new_page</a></li>
			<li";if($page == "navigation"){echo" class=\"down\"";}echo"><a href=\"./?open=pages&amp;page=navigation&amp;editor_language=$editor_language\"";if($page == "navigation"){echo" class=\"selected\"";}echo">$l_navigation</a></li>
			
";

if($page == "menu"){
	echo"
		</ul>
	</div>
	";
}
?>