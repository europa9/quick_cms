<?php
/**
*
* File: _admin/_inc/knowledge/default.php
* Version 
* Date 20:17 30.10.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}
/*- Variables ------------------------------------------------------------------------ */
$tabindex = 0;


if($action == ""){
	echo"
	<h1>Knowledge</h1>
				

	<!-- Feedback -->
	";
	if($ft != ""){
		if($fm == "changes_saved"){
			$fm = "$l_changes_saved";
		}
		else{
			$fm = ucfirst($fm);
		}
		echo"<div class=\"$ft\"><span>$fm</span></div>";
	}
	echo"	
	<!-- //Feedback -->


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=knowledge&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Knowledge</a>
		&gt;
		<a href=\"index.php?open=knowledge&amp;page=default&amp;editor_language=$editor_language&amp;l=$l\">Default</a>
		</p>
	<!-- //Where am I? -->

	";
}
?>