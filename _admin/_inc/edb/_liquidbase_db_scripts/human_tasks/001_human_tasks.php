<?php
/**
*
* File: _admin/_inc/edb/_liquibase/human_tasks/001_human_tasks.php
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
$t_edb_human_tasks_on_new_case		= $mysqlPrefixSav . "edb_human_tasks_on_new_case";
$t_edb_human_tasks_in_case_categories	= $mysqlPrefixSav . "edb_human_tasks_in_case_categories";
$t_edb_human_tasks_in_case_tasks	= $mysqlPrefixSav . "edb_human_tasks_in_case_tasks";

echo"

<!-- edb_human_tasks_on_new_case -->
";

$query = "SELECT * FROM $t_edb_human_tasks_on_new_case LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_human_tasks_on_new_case: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_human_tasks_on_new_case(
	  new_case_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(new_case_id), 
	   new_case_title VARCHAR(200), 
	   new_case_priority_id INT, 
	   new_case_priority_title VARCHAR(200), 
	   new_case_deadline_days INT
	   )")
	   or die(mysqli_error());
	
	mysqli_query($link, "INSERT INTO $t_edb_human_tasks_on_new_case
	(new_case_id, new_case_title, new_case_priority_id, new_case_priority_title, new_case_deadline_days) 
	VALUES 
	(NULL, 'Backup', '2', 'Medium', 14),
	(NULL, 'Sendt mail til etterforsker om at bevisene kan gjennomg&aring;s', '2', 'Medium', 14),
	(NULL, 'Skriv sikringsrapport', '2', 'Medium', 14),
	(NULL, 'Skriv analyserapport', '2', 'Medium', 14)
	") or die(mysqli_error($link));

}
echo"
<!-- //edb_human_tasks_on_new_case -->


<!-- edb_human_tasks_in_case_categories-->
";

$query = "SELECT * FROM $t_edb_human_tasks_in_case_categories LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_human_tasks_in_case_categories: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_human_tasks_in_case_categories(
	  in_case_category_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(in_case_category_id), 
	   in_case_category_title VARCHAR(200)
	   )")
	   or die(mysqli_error());
	
	mysqli_query($link, "INSERT INTO $t_edb_human_tasks_in_case_categories
	(in_case_category_id, in_case_category_title) 
	VALUES 
	(NULL, 'Sikringsoppgaver')
	") or die(mysqli_error($link));

}
echo"
<!-- //edb_human_tasks_in_case_categories -->


<!-- edb_human_tasks_in_case_tasks -->
";

$query = "SELECT * FROM $t_edb_human_tasks_in_case_tasks LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_human_tasks_in_case_categories: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_human_tasks_in_case_tasks(
	  in_case_task_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(in_case_task_id), 
	   in_case_task_title VARCHAR(200), 
	   in_case_category_id INT, 
	   in_case_category_title VARCHAR(200), 
	   in_case_task_priority_id INT, 
	   in_case_task_priority_title VARCHAR(200), 
	   in_case_task_deadline_days INT
	   )")
	   or die(mysqli_error());
	
	mysqli_query($link, "INSERT INTO $t_edb_human_tasks_in_case_tasks
	(in_case_task_id, in_case_category_id, in_case_category_title, in_case_task_title, in_case_task_priority_id, in_case_task_priority_title, in_case_task_deadline_days) 
	VALUES 
	(NULL, 1, 'Sikringsoppgaver', 'Skriv sikringssrapport', 2, 'Medium', 14),
	(NULL, 1, 'Sikringsoppgaver', 'Ta ny backup', 2, 'Medium', 14),
	(NULL, 1, 'Sikringsoppgaver', 'Slette sak fra saker n&aring;r ferdig (for &aring; spare diskplass)', 1, 'Lav', 200)
	") or die(mysqli_error($link));

}
echo"
<!-- //edb_human_tasks_in_case_tasks -->

";
?>