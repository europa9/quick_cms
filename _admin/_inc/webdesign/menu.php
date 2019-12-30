<?php
/**
*
* File: _admin/_inc/sosial_media/menu.php
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


if($page == "menu"){
	echo"
	<h1>Webdesign</h1>
	<div class=\"vertical\">
		<ul>
			<li><a href=\"index.php?open=$open&amp;editor_language=$editor_language\">Webdesign</a></li>

	";
}


echo"
			<li";if($page == "social_media"){echo" class=\"down\"";}echo"><a href=\"./?open=$open&amp;page=social_media&amp;editor_language=$editor_language&amp;l=$l\"";if($page == "social_media"){echo" class=\"selected\"";}echo">Social media</a></li>
			<li";if($page == "slides"){echo" class=\"down\"";}echo"><a href=\"index.php?open=$open&amp;page=slides&amp;editor_language=$editor_language&amp;l=$l\"";if($page == "slides"){echo" class=\"selected\"";}echo">Slides</a></li>
			<li";if($page == "slides_new"){echo" class=\"down\"";}echo"><a href=\"index.php?open=$open&amp;page=slides_new&amp;editor_language=$editor_language&amp;l=$l\"";if($page == "slides_new"){echo" class=\"selected\"";}echo">New slide</a></li>
			<li";if($page == "favicon"){echo" class=\"down\"";}echo"><a href=\"index.php?open=$open&amp;page=favicon&amp;editor_language=$editor_language&amp;l=$l\"";if($page == "favicon"){echo" class=\"selected\"";}echo">Favicon</a></li>
			<li";if($page == "logo"){echo" class=\"down\"";}echo"><a href=\"index.php?open=$open&amp;page=logo&amp;editor_language=$editor_language&amp;l=$l\"";if($page == "logo"){echo" class=\"selected\"";}echo">Logo</a></li>
		
";

if($page == "menu"){
	echo"
		</ul>
	</div>
	";
}
?>