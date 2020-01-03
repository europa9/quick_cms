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
$t_edb_cases_counter_total = $mysqlPrefixSav . "edb_cases_counter_total";


echo"
<!-- edb_cases_counter_total -->
";

$query = "SELECT * FROM $t_edb_cases_counter_total LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_evidence_matrix_header: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_cases_counter_total(
	  total_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(total_id), 
	   total_number_of_cases INT, 
	   total_number_update DATE)")
	   or die(mysqli_error());
}
echo"
<!-- //edb_cases_counter_total -->

";
?>