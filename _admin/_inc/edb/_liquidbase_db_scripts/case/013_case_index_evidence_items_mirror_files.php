<?php
/**
*
* File: _admin/_inc/edb/_liquibase/case/013_edb_case_index_evidence_items_mirror_files.php
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


<!-- edb_case_index_evidence_items_mirror_files -->
";
$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_edb_case_index_evidence_items_mirror_files") or die(mysqli_error($link)); 

$query = "SELECT * FROM $t_edb_case_index_evidence_items_mirror_files LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_evidence_items_mirror_files: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_evidence_items_mirror_files(
	  mirror_file_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(mirror_file_id), 
	   mirror_file_case_id INT,
	   mirror_file_record_id INT,
	   mirror_file_item_id INT,
	   mirror_file_path_windows VARCHAR(200), 
	   mirror_file_path_linux VARCHAR(200), 
	   mirror_file_file VARCHAR(200), 
	   mirror_file_ext VARCHAR(200), 
	   mirror_file_type VARCHAR(200), 
	   mirror_file_confirmed_by_human INT,
	   mirror_file_human_rejected INT,

	   mirror_file_created_datetime DATETIME,
	   mirror_file_created_date DATE,
	   mirror_file_created_time VARCHAR(200), 
	   mirror_file_created_date_saying VARCHAR(200), 
	   mirror_file_created_date_ddmmyy VARCHAR(200), 
	   mirror_file_created_date_ddmmyyyy VARCHAR(200), 

	   mirror_file_modified_datetime DATETIME,
	   mirror_file_modified_date DATE,
	   mirror_file_modified_time VARCHAR(200), 
	   mirror_file_modified_date_saying VARCHAR(200), 
	   mirror_file_modified_date_ddmmyy VARCHAR(200), 
	   mirror_file_modified_date_ddmmyyyy VARCHAR(200), 
	   
	   mirror_file_size_bytes VARCHAR(200), 
	   mirror_file_size_mb DOUBLE, 
	   mirror_file_size_human VARCHAR(200), 
	   mirror_file_backup_disk VARCHAR(200), 
	   mirror_file_exists INT,
	   mirror_file_exists_agent_tries_counter INT,
	   mirror_file_ready_for_automated_machine INT,
	   mirror_file_ready_agent_tries_counter INT,
	   mirror_file_comments VARCHAR(200))")
	   or die(mysqli_error());
}
echo"
<!-- //edb_case_index_evidence_items_mirror_files -->



<!-- edb_case_index_evidence_items_mirror_files_hash -->
";

$query = "SELECT * FROM $t_edb_case_index_evidence_items_mirror_files_hash LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_evidence_items_mirror_files_hash: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_evidence_items_mirror_files_hash(
	  hash_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(hash_id), 
	   hash_case_id INT,
	   hash_mirror_file_id INT,
	   hash_md5 VARCHAR(200), 
	   hash_sha1 VARCHAR(200), 
	   hash_created_datetime DATETIME, 
	   hash_created_ddmmyyhhiiss VARCHAR(200))")
	   or die(mysqli_error());
}
echo"
<!-- //edb_case_index_evidence_items_mirror_files_hash -->


";
?>