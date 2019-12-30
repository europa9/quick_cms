<?php
/**
*
* File: _admin/_inc/edb/_liquibase/item/001_item.php
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


<!-- edb_item_types -->
";
$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_edb_item_types") or die(mysqli_error($link)); 

$query = "SELECT * FROM $t_edb_item_types LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_item_types: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_item_types(
	  item_type_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(item_type_id), 
	   item_type_title VARCHAR(200), 
	   item_type_image_path VARCHAR(200), 
	   item_type_image_file VARCHAR(200), 
	   item_type_has_hard_disks INT, 
	   item_type_has_sim_cards INT, 
	   item_type_has_sd_cards INT, 
	   item_type_has_networks INT, 
	   item_type_terms TEXT, 
	   item_type_line_color VARCHAR(50), 
	   item_type_fill_color VARCHAR(50), 
	   item_type_keywords TEXT
	   )")
	   or die(mysqli_error());


	mysqli_query($link, "INSERT INTO $t_edb_item_types
	(item_type_id, item_type_title, item_type_image_path, item_type_image_file, item_type_has_hard_disks, item_type_has_sim_cards, item_type_has_sd_cards, item_type_has_networks, item_type_terms, item_type_line_color, item_type_fill_color) 
	VALUES 
	(NULL, 'PC', NULL, NULL, 1, 0, 0, 1, '<p><strong>Platedisk</strong><br />En platedisk er en hard disk som best&aring;r av sett med plater som st&aring;r p&aring; en roterende spindel. Et lese- og skrivehodet beveger seg langs platen for &aring; lese og skrive data. Det er mulig &aring; gjenopprette slettede filer fra en platedisk fordi n&aring;r man sletter en fil i operativsystemet slettes kun linken til plasseringen av filen, mens dataene p&aring; platedisken fremdeles kan v&aelig;re inntakt frem til den blir skrevet over.</p>\r\n<p><strong>SSD disk og M2-disk</strong><br />SSD hard disker bruker flashminne istedenfor mekaniske plater til &aring; lagre data. Om man kan gjenopprette slettede filer fra SSD disker kommer ann p&aring; kontrolleren til disken og operativssytemet. M2 disker er SSD disker i en mindre formfaktor.</p>', '#d35d60', '#d35d60')
	") or die(mysqli_error($link));



	mysqli_query($link, "INSERT INTO $t_edb_item_types
	(item_type_id, item_type_title, item_type_image_path, item_type_image_file, item_type_has_hard_disks, item_type_has_sim_cards, item_type_has_sd_cards, item_type_has_networks, item_type_terms, item_type_line_color, item_type_fill_color) 
	VALUES 
	(NULL, 'Mobiltelefon', NULL, NULL, 0, 1, 1, 1, '<p><strong>Imei</strong><br />IMEI er en unik ID for telefonen (den kan ha flere IMEI dersom den er en dual SIM-telefon, dvs. har flere SIM-kort). IMEI best&aring;r av 15 siffer og er lagret digitalt i enheten. Det kan ogs&aring; v&aelig;re klistrert p&aring; eller preget inn p&aring; telefonen. IMEI nummeret er delt inn slik: 012960006 TAC (Type Allocation Code) 12591 (SNR Serial Number) 9 (CD - Check Digit).</p>\r\n<p><strong>IMSI - International Mobile Subscriber Idenity</strong><br />IMSI identifiserer abonnenten. Det best&aring;r av 15 siffer og er lagret digitalt i SIM kortet. Et IMSI nummer kan vise land og leverand&oslash;r og er i formatet: 24202nnnnnnnnnn, 242 er Landkode (Norge) og 02 - Operat&oslash;r (Telia).</p>', '#7394cb', '#7394cb')
	") or die(mysqli_error($link));

	mysqli_query($link, "INSERT INTO $t_edb_item_types
	(item_type_id, item_type_title, item_type_image_path, item_type_image_file, item_type_has_hard_disks, item_type_has_sim_cards, item_type_has_sd_cards, item_type_has_networks, item_type_terms, item_type_line_color, item_type_fill_color) 
	VALUES 
	(NULL, 'Nettbrett', NULL, NULL, 0, 1, 1, 1, '<p><strong>Imei</strong><br />IMEI er en unik ID for nettbrettet (den kan ha flere IMEI dersom den er en dual SIM-telefon, dvs. har flere SIM-kort). IMEI best&aring;r av 15 siffer og er lagret digitalt i enheten. Det kan ogs&aring; v&aelig;re klistrert p&aring; eller preget inn p&aring; nettbrettet. IMEI nummeret er delt inn slik: 012960006 TAC (Type Allocation Code) 12591 (SNR Serial Number) 9 (CD - Check Digit).</p>\r\n<p><strong>IMSI - International Mobile Subscriber Idenity</strong><br />IMSI identifiserer abonnenten. Det best&aring;r av 15 siffer og er lagret digitalt i SIM kortet. Et IMSI nummer kan vise land og leverand&oslash;r og er i formatet: 24202nnnnnnnnnn, 242 er Landkode (Norge) og 02 - Operat&oslash;r (Telia).</p>', '#9066a7', '#9066a7')
	") or die(mysqli_error($link));

	mysqli_query($link, "INSERT INTO $t_edb_item_types
	(item_type_id, item_type_title, item_type_image_path, item_type_image_file, item_type_has_hard_disks, item_type_has_sim_cards, item_type_has_sd_cards, item_type_has_networks, item_type_terms, item_type_line_color, item_type_fill_color) 
	VALUES 
	(NULL, 'Smartklokke', NULL, NULL, 0, 0, 0, 1, '', '#e1974d', '#e1974d')
	") or die(mysqli_error($link));

	mysqli_query($link, "INSERT INTO $t_edb_item_types
	(item_type_id, item_type_title, item_type_image_path, item_type_image_file, item_type_has_hard_disks, item_type_has_sim_cards, item_type_has_sd_cards, item_type_has_networks, item_type_terms, item_type_line_color, item_type_fill_color) 
	VALUES 
	(NULL, 'Online konto', NULL, NULL, 0, 0, 1, 1, '', '#84bb5c', '#84bb5c')
	") or die(mysqli_error($link));

	mysqli_query($link, "INSERT INTO $t_edb_item_types
	(item_type_id, item_type_title, item_type_image_path, item_type_image_file, item_type_has_hard_disks, item_type_has_sim_cards, item_type_has_sd_cards, item_type_has_networks, item_type_terms, item_type_line_color, item_type_fill_color) 
	VALUES 
	(NULL, 'SD-kort', NULL, NULL, 0, 0, 1, 1, '', '#9066a7', '#9066a7')
	") or die(mysqli_error($link));

	mysqli_query($link, "INSERT INTO $t_edb_item_types
	(item_type_id, item_type_title, item_type_image_path, item_type_image_file, item_type_has_hard_disks, item_type_has_sim_cards, item_type_has_sd_cards, item_type_has_networks, item_type_terms, item_type_line_color, item_type_fill_color) 
	VALUES 
	(NULL, 'Minnepenn', NULL, NULL, 1, 0, 0, 0, '', '#818787', '#818787')
	") or die(mysqli_error($link));
	
	// Social media reader
	mysqli_query($link, "INSERT INTO $t_edb_item_types
	(item_type_id, item_type_title, item_type_keywords) 
	VALUES 
	(NULL, 'Facebook JSON', 'facebook_json'),
	(NULL, 'Facebook HTML', 'facebook_html'),
	(NULL, 'MBOX', 'mbox'),
	(NULL, 'Skype Database', 'skype_database'),
	(NULL, 'Skype JSON', 'skype_json'),
	(NULL, 'SnapChat JSON', 'snapchat'),
	(NULL, 'UFED ChatExcel', 'ufed'),
	(NULL, 'Vipps', 'vipps')
	") or die(mysqli_error($link));

}
echo"
<!-- //edb_item_types -->

";
?>