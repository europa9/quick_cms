<?php
/**
*
* File: _admin/_inc/edb/_liquibase/ping_on/001_ping_on.php
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

$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_edb_ping_on") or die(mysqli_error($link)); 

echo"


<!-- edb_ping_on -->
";

$query = "SELECT * FROM $t_edb_ping_on LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_ping_on: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_ping_on(
	  ping_on_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(ping_on_id), 
	   ping_on_title VARCHAR(200),
	   ping_on_when VARCHAR(100),
	   ping_on_to_ip VARCHAR(200),
	   ping_on_last_datetime DATETIME
	   )")
	   or die(mysqli_error());

}
echo"
<!-- //edb_ping_on -->

";
?>