<?php
/**
*
* File: _admin/_inc/evidence/menu.php
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
	<h1>Evidence DB</h1>
	<div class=\"vertical\">
		<ul>
			<li><a href=\"index.php?open=edb&amp;editor_language=$editor_language\">Default</a></li>

	";
}



echo"
			<li><a href=\"index.php?open=edb&amp;page=case_codes&amp;editor_language=$editor_language\""; if($page == "case_codes"){ echo" class=\"selected\""; } echo">Case codes</a></li>
			<li><a href=\"index.php?open=edb&amp;page=districts_index&amp;editor_language=$editor_language\""; if($page == "districts_index"){ echo" class=\"selected\""; } echo">Districts</a></li>
			<li><a href=\"index.php?open=edb&amp;page=district_jour&amp;editor_language=$editor_language\""; if($page == "district_jour"){ echo" class=\"selected\""; } echo">District jour</a></li>
			<li><a href=\"index.php?open=edb&amp;page=stations_index&amp;editor_language=$editor_language\""; if($page == "stations_index"){ echo" class=\"selected\""; } echo">Stations</a></li>
			<li><a href=\"index.php?open=edb&amp;page=stations_directories&amp;editor_language=$editor_language\""; if($page == "stations_directories"){ echo" class=\"selected\""; } echo">Stations directories</a></li>
			<li><a href=\"index.php?open=edb&amp;page=station_jour&amp;editor_language=$editor_language\""; if($page == "station_jour"){ echo" class=\"selected\""; } echo">Station jour</a></li>
			<li><a href=\"index.php?open=edb&amp;page=priorities&amp;editor_language=$editor_language\""; if($page == "priorities"){ echo" class=\"selected\""; } echo">Priorities</a></li>
			<li><a href=\"index.php?open=edb&amp;page=statuses&amp;editor_language=$editor_language\""; if($page == "statuses"){ echo" class=\"selected\""; } echo">Statuses</a></li>
			<li><a href=\"index.php?open=edb&amp;page=software_index&amp;editor_language=$editor_language\""; if($page == "software_index"){ echo" class=\"selected\""; } echo">Software index</a></li>
			<li><a href=\"index.php?open=edb&amp;page=item_types&amp;editor_language=$editor_language\""; if($page == "item_types"){ echo" class=\"selected\""; } echo">Item types</a></li>
			<li><a href=\"index.php?open=edb&amp;page=machines&amp;editor_language=$editor_language\""; if($page == "machines"){ echo" class=\"selected\""; } echo">Machines</a></li>
			<li><a href=\"index.php?open=edb&amp;page=machine_types&amp;editor_language=$editor_language\""; if($page == "machine_types"){ echo" class=\"selected\""; } echo">Machine types</a></li>
			<li><a href=\"index.php?open=edb&amp;page=machines_all_tasks_available&amp;editor_language=$editor_language\""; if($page == "machines_all_tasks_available"){ echo" class=\"selected\""; } echo">All tasks available</a></li>
			
			<li><a href=\"index.php?open=edb&amp;page=reports&amp;editor_language=$editor_language\""; if($page == "reports"){ echo" class=\"selected\""; } echo">Reports</a></li>
			<li><a href=\"index.php?open=edb&amp;page=glossaries&amp;editor_language=$editor_language\""; if($page == "glossaries"){ echo" class=\"selected\""; } echo">Glossaries</a></li>

			<li><a href=\"index.php?open=edb&amp;page=human_tasks_on_new_case&amp;editor_language=$editor_language\""; if($page == "human_tasks_on_new_case"){ echo" class=\"selected\""; } echo">Human tasks on new case</a></li>
			<li><a href=\"index.php?open=edb&amp;page=human_tasks_in_case&amp;editor_language=$editor_language\""; if($page == "human_tasks_in_case"){ echo" class=\"selected\""; } echo">Human tasks in case</a></li>
			<li><a href=\"index.php?open=edb&amp;page=evidence_storage_shelves&amp;editor_language=$editor_language\""; if($page == "evidence_storage_shelves"){ echo" class=\"selected\""; } echo">Evidence storage shelves</a></li>

			<li><a href=\"index.php?open=edb&amp;page=review_standards&amp;editor_language=$editor_language\""; if($page == "review_standards"){ echo" class=\"selected\""; } echo">Review standards</a></li>
			<li><a href=\"index.php?open=edb&amp;page=ping_on&amp;editor_language=$editor_language\""; if($page == "ping_on"){ echo" class=\"selected\""; } echo">Ping on</a></li>
			<li><a href=\"index.php?open=edb&amp;page=backup_disks&amp;editor_language=$editor_language\""; if($page == "backup_disks"){ echo" class=\"selected\""; } echo">Backup disks</a></li>

			<li><a href=\"index.php?open=edb&amp;page=tables&amp;editor_language=$editor_language\""; if($page == "tables"){ echo" class=\"selected\""; } echo">Tables</a></li>
		
";
?>