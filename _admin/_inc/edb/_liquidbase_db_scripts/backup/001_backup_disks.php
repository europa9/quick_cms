<?php
/**
*
* File: _admin/_inc/edb/_liquibase/backup/001_backup_disks.php
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
<!-- edb_backup_disks -->
";

$query = "SELECT * FROM $t_edb_backup_disks LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_backup_disks: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_backup_disks(
	  disk_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(disk_id), 
	   disk_name VARCHAR(500), 
	   disk_signature VARCHAR(500), 
	   disk_capacity_bytes VARCHAR(500), 
	   disk_capacity_human VARCHAR(500), 
	   disk_available_bytes VARCHAR(500), 
	   disk_available_human VARCHAR(500), 
	   disk_used_bytes VARCHAR(500), 
	   disk_used_human VARCHAR(500), 
	   disk_client VARCHAR(500),
	   disk_district_id INT, 
	   disk_district_title VARCHAR(200), 
	   disk_station_id INT, 
	   disk_station_title VARCHAR(200))")
	   or die(mysqli_error());	


}
echo"
<!-- //edb_backup_disks -->


";
?>