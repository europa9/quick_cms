<?php
/**
*
* File: _admin/_inc/food_diary/menu.php
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
	<h1>Food diary</h1>
	<div class=\"vertical\">
		<ul>
			<li><a href=\"index.php?open=$open&amp;editor_language=$editor_language\">Food diary</a></li>

	";
}




echo"
			<li><a href=\"index.php?open=$open&amp;page=food_diary&amp;editor_language=$editor_language\""; if($page == "food_diary"){ echo" class=\"selected\""; } echo">Food diary</a></li>
			<li><a href=\"index.php?open=$open&amp;page=not_logged_in&amp;editor_language=$editor_language\""; if($page == "not_logged_in"){ echo" class=\"selected\""; } echo">Not logged in</a></li>
			<li><a href=\"index.php?open=$open&amp;page=tables&amp;editor_language=$editor_language\""; if($page == "tables"){ echo" class=\"selected\""; } echo">Tables</a></li>
		
";

if($page == "menu"){
	echo"
		</ul>
	</div>
	";
}
?>