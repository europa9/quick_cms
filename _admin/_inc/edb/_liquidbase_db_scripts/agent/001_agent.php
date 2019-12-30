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

echo"



<!-- edb_agent_user_active_inactive -->
";

$query = "SELECT * FROM $t_edb_agent_user_active_inactive LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_agent_user_active_inactive: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_agent_user_active_inactive(
	  active_inactive_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(active_inactive_id), 
	   user_id INT,
	   agent_is_active INT
	   )")
	   or die(mysqli_error());

}
echo"
<!-- //edb_agent_user_active_inactive -->

";
?>