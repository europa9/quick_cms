<?php
/**
*
* File: _admin/_inc/edb/_liquibase/agent/001b_agent.php
* Version 1.0.0
* Date 21:19 28.08.2019
* Copyright (c) 2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_edb_agents_index") or die(mysqli_error($link)); 
echo"



<!-- edb_agents_index -->
";

$query = "SELECT * FROM $t_edb_agents_index LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_agents_index: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_agents_index(
	  agent_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(agent_id), 
	   agent_script_file VARCHAR(200),
	   agent_last_runned DATETIME
	   )")
	   or die(mysqli_error());

	mysqli_query($link, "INSERT INTO $t_edb_agents_index
	(agent_id, agent_script_file) 
	VALUES 
	(NULL, '01_find_new_cases.php'),
	(NULL, '02_find_new_mirror_files_root.php'),
	(NULL, '03_find_new_mirror_files_sub.php'),
	(NULL, '04_changes_on_existing_mirror_files.php')")
	or die(mysqli_error($link)); 
}
echo"
<!-- //edb_agents_index -->
";
?>