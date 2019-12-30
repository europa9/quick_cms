<?php
/**
*
* File: _admin/_inc/edb/_liquibase/software/001b_software.php
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

$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_edb_software_index") or die(mysqli_error($link)); 


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
	   software_show_in_acquire_list INT,
	   software_created_datetime DATETIME,
	   software_updated_datetime DATETIME
	   )")
	   or die(mysqli_error());


	mysqli_query($link, "INSERT INTO $t_edb_software_index
	(software_id, software_title, software_version, software_used_for, software_description, software_report_text, software_image_path, software_image_file, software_show_in_acquire_list) 
	VALUES 
	(NULL, 'Tableau Imager med Tableau writeblock', '1.2.1', 'forensic_imaging_of_hard_drives_memory_cards_usb_sticks', 'Sikre harddisker, minnepenner og SD-kort', '<p>Tableau Imager med writeblocker brukes til &aring; sikre innhold p&aring; harddisker, minnepenner og sd-kort. Writeblockeren s&oslash;rger for at ingen data blir endret f&oslash;r, under eller etter sikringen. Sikringsfilen blir lagret i r&aring;dataformat.</p>', 'uploads/edb/software', 'tableau_imager.png', 1),
	(NULL, 'Cellebrite iOS Device Extraction Advanced Logical metode 1 og metode 2', '7.26.0.206', 'forensic_imaging_of_mobiles', 'Sikre iPhone.', '<p>Cellebrite iOS Device Extraction tar en kopi av en Apple mobiltelefon. Kopien kan deretter gjennomg&aring;s av en etterforsker med Cellebrite Reader. </p>', 'uploads/edb/software', 'tableau_imager.png', 1),
	(NULL, 'Cellebrite UFED 4PC', '7.24.0.1', 'forensic_imaging_of_mobiles', 'Sikre Android telefoner.', '<p>Cellebrite UFED 4PC tar en kopi av en Android mobiltelefon. Kopien kan deretter gjennomg&aring;s av en etterforsker med Cellebrite Reader.</p>', 'uploads/edb/software', 'ufed_4pc.png', 1),
	(NULL, 'Paladin', '7', 'capture_pc', 'Sikre datamaskiner', '<p>Paladin 7 er et operativsystem som startes opp via en minnepenn. Operativsystemet skriver ikke til harddisken og dermed blir ingen data endret f&oslash;r, under eller etter sikringen. Sikringsfilen blir lagret i r&aring;dataformat.</p>', 'uploads/edb/software', 'paladin.png', 1),
	(NULL, 'Caine Linux 10 med Guymager', '0.8.11', 'forensic_imaging_of_hard_drives_memory_cards_usb_sticks', 'Sikre harddisker, minnepenner og SD-kort', '<p>Caine Linux 10 er et operativsystem som startes opp via en minnepenn. Operativsystemet skriver ikke til harddisken og dermed blir ingen data endret f&oslash;r, under eller etter sikringen. Sikringsfilen blir lagret i r&aring;dataformat.</p>', 'uploads/edb/software', 'guymaker.png', 1),
	(NULL, 'Cellebrite iOS Device Extraction Advanced Logical metode 1', '7.26.0.206', 'forensic_imaging_of_hard_drives_memory_cards_usb_sticks', '', '<p>Cellebrite iOS Device Extraction tar en kopi av en Apple mobiltelefon. Kopien kan deretter gjennomg&aring;s av en etterforsker med Cellebrite Reader.</p>', NULL, NULL, 1)
	") or die(mysqli_error($link));


}
echo"
<!-- //edb_software_index -->



";
?>