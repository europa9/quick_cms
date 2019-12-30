<?php
/**
*
* File: _admin/_inc/edb/_liquibase/agent/001_agent.php
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

$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_edb_agent_log") or die(mysqli_error($link)); 
echo"


<!-- edb_agent_log -->
";

$query = "SELECT * FROM $t_edb_agent_log LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_agent_log: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_agent_log(
	  agent_log_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(agent_log_id), 
	   agent_name VARCHAR(200),
	   agent_log_datetime DATETIME,
	   agent_log_date_ddmmyyhi VARCHAR(200),
	   agent_log_date_ddmmyyyyhi VARCHAR(200),
	   agent_log_date_saying VARCHAR(200),
	   agent_log_text TEXT
	   )")
	   or die(mysqli_error());

}
echo"
<!-- //edb_agent_log -->

";
?>