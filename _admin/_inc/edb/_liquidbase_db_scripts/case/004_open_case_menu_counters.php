<?php
/**
*
* File: _admin/_inc/edb/_liquibase/case/004_open_case_menu_counters.php
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


echo"
<!-- edb_case_index_open_case_menu_counters -->
";

$query = "SELECT * FROM $t_edb_case_index_open_case_menu_counters LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_open_case_menu_counters: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_open_case_menu_counters(
	  menu_counter_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(menu_counter_id), 
	   menu_counter_case_id INT,
	   menu_counter_overview INT,
	   menu_counter_evidence INT,
	   menu_counter_evidence_matrix INT,
	   menu_counter_statuses INT,
	   menu_counter_events INT,
	   menu_counter_notes INT,
	   menu_counter_review_notes INT,
	   menu_counter_review_matrix INT,
	   menu_counter_human_tasks_completed INT,
	   menu_counter_human_tasks_total INT,
	   menu_counter_automated_tasks_completed INT,
	   menu_counter_automated_tasks_total INT,
	   menu_counter_glossaries INT,
	   menu_counter_photos INT)")
	   or die(mysqli_error());
}
echo"
<!-- //edb_case_index_open_case_menu_counters -->


";
?>