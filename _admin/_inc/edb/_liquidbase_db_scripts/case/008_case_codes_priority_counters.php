<?php
/**
*
* File: _admin/_inc/edb/_liquibase/case/case_codes_priority_counters
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
<!-- edb_case_codes_priority_counters -->
";

$query = "SELECT * FROM $t_edb_case_codes_priority_counters LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_codes_priority_counters: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_codes_priority_counters(
	  priority_counter_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(priority_counter_id), 
	   priority_counter_year INT, 
	   priority_counter_case_code_id INT, 
	   priority_counter_case_code_title VARCHAR(200),
	   priority_counter_priority_id INT, 
	   priority_counter_priority_title VARCHAR(200),
	   priority_counter_count INT)")
	   or die(mysqli_error());
}
echo"
<!-- //edb_case_codes_priority_counters -->

";
?>