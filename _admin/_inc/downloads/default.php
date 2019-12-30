<?php
/**
*
* File: _admin/_inc/downloads/default.php
* Version 15.00 03.03.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}



/*- Scriptstart ---------------------------------------------------------------------- */
echo"

<h1>Downloads</h1>

<div class=\"vertical\">
	<ul>
		<li><a href=\"index.php?open=$open&amp;page=downloads&amp;l=$l&amp;editor_language=$editor_language\">Downloads</a></li>
		<li><a href=\"index.php?open=$open&amp;page=new_download&amp;l=$l&amp;editor_language=$editor_language\">New download</a></li>
		<li><a href=\"index.php?open=$open&amp;page=categories&amp;l=$l&amp;editor_language=$editor_language\">Categories</a></li>
		<li><a href=\"index.php?open=$open&amp;page=scan_for_new_files&amp;l=$l&amp;editor_language=$editor_language\">Scan for new files</a></li>
		<li><a href=\"index.php?open=$open&amp;page=tables&amp;l=$l&amp;editor_language=$editor_language\">Tables</a></li>
	</ul>
</div>
";
?>