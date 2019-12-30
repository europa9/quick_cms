<?php
/**
*
* File: _admin/_inc/edb/_liquibase/machines/001_machines.php
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


<!-- edb_machines_index -->
";

$query = "SELECT * FROM $t_edb_machines_index LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_machines_index: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_machines_index(
	  machine_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(machine_id), 
	   machine_name VARCHAR(200), 
	   machine_type_id INT, 
	   machine_type_title VARCHAR(200), 
	   machine_os VARCHAR(200), 
	   machine_ip VARCHAR(200),
	   machine_mac VARCHAR(200),
	   machine_key VARCHAR(200),
	   machine_description TEXT,
	   machine_station_id INT,
	   machine_station_title VARCHAR(200),
	   machine_last_seen_datetime DATETIME,
	   machine_last_seen_time VARCHAR(200), 
	   machine_last_seen_ddmmyyhi VARCHAR(200),
	   machine_last_seen_ddmmyyyyhi VARCHAR(200),
	   machine_is_working_with_automated_task_id INT,
	   machine_started_working_datetime DATETIME,
	   machine_started_working_time VARCHAR(200), 
	   machine_started_working_ddmmyyhi VARCHAR(200), 
	   machine_started_working_ddmmyyyyhi VARCHAR(200)
	   )")
	   or die(mysqli_error());


	mysqli_query($link, "INSERT INTO $t_edb_machines_index
	(machine_id, machine_name, machine_type_id, machine_type_title, machine_os, machine_ip, machine_mac, machine_key, machine_description, machine_station_id, machine_station_title) 
	VALUES 
	(NULL, 'DPAStavAutoXway1', '1', 'X-Ways', 'Windows 10', '10.1.0.50', '50:60:70:80', 'stavanger_xway_1', 'X-way machine 1 Creates cases and processes them', 1, 'Stavanger'),
	(NULL, 'DPAStavAutoIEF1', '2', 'IEF', 'Windows 10', '10.1.0.51', '50:60:70:81', 'stavanger_ief_1', 'IEF 1 Creates cases and processes them', 1, 'Stavanger'),
	(NULL, 'DPAHaugAutoXway1', '1', 'X-Ways', 'Windows 10', '10.2.0.50', '50:60:70:90', 'haugesund_xway_1', 'X-way machine 1 Creates cases and processes them', 2, 'Haugesund'),
	(NULL, 'DPAHaugAutoIEF1', '2', 'IEF', 'Windows 10', '10.2.0.51', '50:60:70:91', 'stavanger_ief_1', 'IEF 1 Creates cases and processes them', 2, 'Haugesund')
	") or die(mysqli_error($link));

}
echo"
<!-- //edb_machines_index -->
<!-- edb_machines_types -->
";

$query = "SELECT * FROM $t_edb_machines_types LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_machines_types: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_machines_types(
	  machine_type_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(machine_type_id), 
	   machine_type_title VARCHAR(200)
	   )")
	   or die(mysqli_error());


	mysqli_query($link, "INSERT INTO $t_edb_machines_types
	(machine_type_id, machine_type_title) 
	VALUES 
	(NULL, 'X-Ways'),
	(NULL, 'IEF'),
	(NULL, 'Griffey')
	") or die(mysqli_error($link));

}
echo"
<!-- //edb_machines_types -->

<!-- edb_machines_all_tasks_available -->
";

$query = "SELECT * FROM $t_edb_machines_all_tasks_available LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_machines_all_tasks_available: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_machines_all_tasks_available(
	  task_available_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(task_available_id), 
	   task_available_name VARCHAR(200), 
	   task_available_machine_type_id INT,
	   task_available_machine_type_title VARCHAR(200), 
	   task_available_description TEXT,
	   task_available_description_report TEXT,
	   task_available_script_path VARCHAR(200),
	   task_available_script_file VARCHAR(200),
	   task_available_script_version VARCHAR(20),
	   task_available_code TEXT
	   )")
	   or die(mysqli_error());


	mysqli_query($link, "INSERT INTO $t_edb_machines_all_tasks_available
	(task_available_id, task_available_name, task_available_machine_type_id, task_available_machine_type_title, task_available_description, task_available_description_report, task_available_script_path, task_available_script_file, task_available_script_version) 
	VALUES 
	(NULL, 'X-Ways nedlastning av overgrepsmateriale', 1, 'X-Ways', 'Create X-Ways project, refine volume snapshot, copy out files', 'X-Ways Forensics v 19.8. Det ble sett etter slettede filer og alle bilder, video og lyd ble kopiert ut av sikringsfilene og gjort tilgjengelig for etterforsker. Resultatene av prosesseringen ble så gjennomgått i det samme programmet.', '_uploads/edb/task_available_scripts', 'x_ways_nedlastning_av_overgrepsmateriale.exe', '1.0.0'),
	(NULL, 'X-Ways egenprodusert overgrepsmateriale', 1, 'X-Ways', 'Create X-Ways project, refine volume snapshot, copy out files', 'X-Ways Forensics v 19.8. Det ble sett etter slettede filer og alle bilder, video og lyd ble kopiert ut av sikringsfilene og gjort tilgjengelig for etterforsker. Resultatene av prosesseringen ble så gjennomgått i det samme programmet.', '_uploads/edb/task_available_scripts', 'x_ways_egenprodusert_overgrepsmateriale.exe', '1.0.0'),
	(NULL, 'IEF standard', 2,  'IEF',  'Create IEF project and process it', 'Internet Evidence Finder. Programmet gir en oversikt over Internetthistorikk. Internetthistorikken ble gjennomgått av etterforsker i det samme programmet.', '_uploads/edb/task_available_scripts', 'ief_standard.exe', '1.0.0')
	") or die(mysqli_error($link));

}
echo"
<!-- //edb_machines_all_tasks_available -->

<!-- edb_machines_all_tasks_available_to_items -->
";

$query = "SELECT * FROM $t_edb_machines_all_tasks_available_to_item LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_machines_all_tasks_available_to_item: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_machines_all_tasks_available_to_item(
	  task_available_to_item_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(task_available_to_item_id), 
	   task_available_id INT, 
	   item_type_id INT
	   )")
	   or die(mysqli_error());

/*
	mysqli_query($link, "INSERT INTO $t_edb_machines_all_tasks_available_to_item
	(task_available_to_item_id, task_available_id, item_type_id) 
	VALUES 
	(NULL, 'X-Ways standard', 'X-Ways', 'Create X-Ways project, refine volume snapshot, copy out files', 'x_ways_standard.exe'),
	(NULL, 'IEF standard', 'IEF',  'Create IEF project and process it', 'ief_standard.exe')
	") or die(mysqli_error($link));
*/
}
echo"
<!-- //edb_machines_all_tasks_available -->


";
?>