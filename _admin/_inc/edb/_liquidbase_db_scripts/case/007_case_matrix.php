<?php
/**
*
* File: _admin/_inc/edb/_liquibase/case/007_evidence_matrix.php
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
$t_edb_case_index_matrix_names			= $mysqlPrefixSav . "edb_case_index_matrix_names";
$t_edb_case_index_matrix_header 		= $mysqlPrefixSav . "edb_case_index_matrix_header";
$t_edb_case_index_matrix_body_titles 		= $mysqlPrefixSav . "edb_case_index_matrix_body_titles";
$t_edb_case_index_matrix_body_values 		= $mysqlPrefixSav . "edb_case_index_matrix_body_values";

echo"
<!-- edb_case_index_matrix_names -->
";
$query = "SELECT * FROM $t_edb_case_index_matrix_names LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_matrix_names: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_matrix_names(
	  matrix_name_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(matrix_name_id), 
	   matrix_name_case_id INT,
	   matrix_name_name VARCHAR(200))")
	   or die(mysqli_error());
}
echo"
<!-- //edb_case_index_matrix_names -->




<!-- edb_case_index_matrix_header -->
";
$query = "SELECT * FROM $t_edb_case_index_matrix_header LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_matrix_header: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_matrix_header(
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
<!-- //edb_case_index_matrix_header -->


<!-- edb_case_index_matrix_body_titles -->
";
$query = "SELECT * FROM $t_edb_case_index_matrix_body_titles LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_matrix_body_titles: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_matrix_body_titles(
	  body_title_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(body_title_id), 
	   body_title_case_id INT,
	   body_title_evidence_id INT,
	   body_title_name VARCHAR(200),
	   body_title_weight INT)")
	   or die(mysqli_error());
}
echo"
<!-- //edb_case_index_matrix_body_titles -->



<!-- edb_case_index_evidence_matrix_body_values -->
";
$query = "SELECT * FROM $t_edb_case_index_matrix_body_values LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_matrix_body_values: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_matrix_body_values(
	  body_value_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(body_value_id), 
	   body_value_case_id INT,
	   body_value_body_title_id INT,
	   body_value_header_id INT,
	   body_value_weight INT,
	   body_value_content TEXT,
	   body_value_style_class VARCHAR(100),
	   body_value_bg_color VARCHAR(50),
	   body_value_txt_color VARCHAR(50),
	   body_link_color VARCHAR(50),
	   body_value_border VARCHAR(200))")
	   or die(mysqli_error());
}
echo"
<!-- //edb_case_index_matrix_body_values -->
";
?>