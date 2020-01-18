<?php
/**
*
* File: _admin/_inc/dashboard/menu.php
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
	<h1>Dashboard</h1>
	<div class=\"vertical\">
		<ul>
			<li><a href=\"index.php?open=$open&amp;editor_language=$editor_language\">Dashboard</a></li>

	";
}


echo"
			<li><a href=\"./?open=dashboard&amp;page=inbox&amp;editor_language=$editor_language\"";if($page == "inbox"){echo" class=\"selected\"";}echo">Inbox</a></li>
			<li><a href=\"./?open=dashboard&amp;page=banned&amp;editor_language=$editor_language\"";if($page == "banned"){echo" class=\"selected\"";}echo">Banned</a></li>
			<li><a href=\"./?open=dashboard&amp;page=backup&amp;editor_language=$editor_language\"";if($page == "backup"){echo" class=\"selected\"";}echo">Backup</a></li>
			<li><a href=\"./?open=dashboard&amp;page=notepad&amp;editor_language=$editor_language\"";if($page == "notepad"){echo" class=\"selected\"";}echo">Notepad</a></li>
			<li><a href=\"./?open=dashboard&amp;page=tasks&amp;editor_language=$editor_language\"";if($page == "tasks"){echo" class=\"selected\"";}echo">Tasks</a></li>
			<li><a href=\"./?open=dashboard&amp;page=moderator_of_the_week&amp;editor_language=$editor_language\"";if($page == "moderator_of_the_week"){echo" class=\"selected\"";}echo">Moderator ofw</a></li>
			<li><a href=\"./?open=dashboard&amp;page=user_agents&amp;editor_language=$editor_language\"";if($page == "user_agents"){echo" class=\"selected\"";}echo">User agents</a></li>
			<li><a href=\"./?open=dashboard&amp;page=statistics&amp;editor_language=$editor_language\"";if($page == "statistics"){echo" class=\"selected\"";}echo">Statistics</a></li>

";


if($page == "menu"){
	echo"
		</ul>
	</div>
	";
}
?>