<?php
/**
*
* File: _admin/_inc/edb/_liquibase/case/005_evidence_matrix.php
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
/*- Tables ---------------------------------------------------------------------------- */
$t_edb_case_index_evidence_matrix_header = $mysqlPrefixSav . "edb_case_index_evidence_matrix_header";
$t_edb_case_index_evidence_matrix_body = $mysqlPrefixSav . "edb_case_index_evidence_matrix_body";


echo"
<!-- edb_case_index_evidence_matrix_header -->
";

$query = "SELECT * FROM $t_edb_case_index_evidence_matrix_header LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_evidence_matrix_header: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_evidence_matrix_header(
	  header_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(header_id), 
	   header_case_id INT,
	   header_weight INT,
	   header_content TEXT,
	   header_style_class VARCHAR(100),
	   header_bg_color VARCHAR(50),
	   header_txt_color VARCHAR(50),
	   header_link_color VARCHAR(50),
	   header_border VARCHAR(200))")
	   or die(mysqli_error());
}
echo"
<!-- //edb_case_index_evidence_matrix_header -->

<!-- edb_case_index_evidence_matrix_body -->
";

$query = "SELECT * FROM $t_edb_case_index_evidence_matrix_body LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_evidence_matrix_body: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_evidence_matrix_body(
	  body_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(body_id), 
	   body_case_id INT,
	   body_evidence_id INT,
	   body_header_id INT,
	   body_weight INT,
	   body_content TEXT,
	   body_style_class VARCHAR(100),
	   body_bg_color VARCHAR(50),
	   body_txt_color VARCHAR(50),
	   body_link_color VARCHAR(50),
	   body_border VARCHAR(200))")
	   or die(mysqli_error());
}
echo"
<!-- //edb_case_index_evidence_matrix_body -->

";
?>