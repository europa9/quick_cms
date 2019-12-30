<?php
/**
*
* File: _admin/_inc/edb/_liquibase/item/017_case_index_evidence_items_zips.php
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


<!-- case_index_evidence_items_zips -->
";

$query = "SELECT * FROM $t_edb_case_index_evidence_items_zips LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_evidence_items_zips: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_evidence_items_zips(
	  zip_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(zip_id), 
	   zip_case_id INT,
	   zip_item_id INT, 
	   zip_file_name VARCHAR(250), 
	   zip_file_path_windows VARCHAR(250), 
	   zip_file_path_linux VARCHAR(250), 
	   zip_size_bytes VARCHAR(250), 
	   zip_size_human VARCHAR(250), 
	   zip_backup_disk_id INT,
	   zip_backup_disk_name VARCHAR(250), 
	   zip_created_datetime DATETIME, 
	   zip_created_user_id INT,
	   zip_created_by_user_name VARCHAR(250),
	   zip_created_by_ip VARCHAR(250), 
	   zip_updated_datetime DATETIME, 
	   zip_updated_user_id INT,
	   zip_updated_user_name VARCHAR(250),
	   zip_updated_ip VARCHAR(250)
	   )")
	   or die(mysqli_error());
}
echo"
<!-- //case_index_evidence_items_zips -->



";
?>