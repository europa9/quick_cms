<?php
/**
*
* File: _admin/_inc/edb/_liquibase/software/001_software.php
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


<!-- edb_software_index -->
";

$query = "SELECT * FROM $t_edb_software_index LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_software_index: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_software_index(
	  software_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(software_id), 
	   software_title VARCHAR(200), 
	   software_version VARCHAR(200),
	   software_used_for VARCHAR(200),
	   software_description TEXT,
	   software_report_text TEXT,
	   software_image_path VARCHAR(200),
	   software_image_file VARCHAR(200),
	   software_show_in_acquire_list INT
	   )")
	   or die(mysqli_error());


	mysqli_query($link, "INSERT INTO $t_edb_software_index
	(software_id, software_title, software_version, software_used_for, software_description, software_report_text, software_image_path, software_image_file, software_show_in_acquire_list) 
	VALUES 
	(NULL, 'Tableau Imager', '1.2.1', 'capture_hard_drives', 'Sikre harddisker, minnepenner og SD-kort', 'Denne prosedyren gjør det mulig å sikre innholdet på harddiskene. Ingen data blir endret før, under eller etter sikringen. Sikringsfilen ble lagret i rådataformat.', 'uploads/edb/software', 'tableau_imager.png', 1),
	(NULL, 'Tableau Imager', '1.0.0', 'capture_hard_drives', 'Sikre harddisker, minnepenner og SD-kort', 'Sikrer en prosess', 'uploads/edb/software', 'tableau_imager.png', 0),
	(NULL, 'Cellebrite UFED 4PC', '7.22', 'capture_mobile_phones', 'Sikre mobiltelefoner', 'Prossedyren gjør at det blir tatt en kopi av mobilen.', 'uploads/edb/software', 'ufed_4pc.png', 1)
	") or die(mysqli_error($link));

	mysqli_query($link, "INSERT INTO $t_edb_software_index
	(software_id, software_title, software_version, software_used_for, software_description, software_report_text, software_image_path, software_image_file, software_show_in_acquire_list) 
	VALUES 
	(NULL, 'Paladin', '7', 'capture_pc', 'Sikre datamaskiner', 'Denne prosedyren gjør det mulig å sikre innholdet på harddiskene i datamaskinen uten å skru dem ut. Da operativsystemet kun har lesetilgang til diskene, garanterer denne metoden at ingen data blir endret før, under eller etter sikringen. Sikringsfilen ble lagret i rådataformat.', 'uploads/edb/software', 'paladin.png', 1),
	(NULL, 'Guymaker', '0.8.11', 'capture_hard_drives', 'Sikre harddisker, minnepenner og SD-kort', 'Denne prosedyren gjør det mulig å sikre innholdet på harddiskene. Ingen data blir endret før, under eller etter sikringen. Sikringsfilen ble lagret i rådataformat.', 'uploads/edb/software', 'guymaker.png', 1)
	") or die(mysqli_error($link));

}
echo"
<!-- //edb_software_index -->



";
?>