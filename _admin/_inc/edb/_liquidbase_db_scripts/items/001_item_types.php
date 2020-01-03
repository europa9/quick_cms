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
	   item_type_fill_color VARCHAR(50)
	   )")
	   or die(mysqli_error());
	
	$inp_terms_pc = "<p><b>Platedisk</b><br />En platedisk er en hard disk som består av sett med plater som står på en roterende spindel. Et lese- og skrivehodet beveger seg 
			langs platen for å lese og skrive data. Det er mulig å gjenopprette slettede filer fra en platedisk fordi når man sletter en fil i operativsystemet
			slettes kun linken til plasseringen av filen, mens dataene på platedisken fremdeles kan være inntakt frem til den blir skrevet over. </p>

			<p><b>SSD disk og M2-disk</b><br />SSD hard disker bruker flashminne istedenfor mekaniske plater til å lagre data. Om man kan gjenopprette slettede filer fra SSD disker
			kommer ann på kontrolleren til disken og operativssytemet. M2 disker er SSD disker i en mindre formfaktor.</p>";
	
	$inp_terms_mobile = "<p><b>Imei</b><br />IMEI er en unik ID for telefonen (den kan ha flere IMEI dersom den er en dual SIM-telefon, dvs. har flere SIM-kort). 
				IMEI består av 15 siffer og er lagret digitalt i enheten. Det kan også være klistrert på eller preget inn på telefonen. IMEI nummeret er delt inn slik:
				012960006 TAC (Type Allocation Code) 12591 (SNR Serial Number) 9 (CD - Check Digit).</p>

				<p><b>IMSI - International Mobile Subscriber Idenity</b><br />IMSI identifiserer abonnenten. Det består av 15 siffer og er lagret digitalt i SIM kortet. 
				Et IMSI nummer kan vise land og leverandør og er i formatet: 24202nnnnnnnnnn, 242 er Landkode (Norge) og 02 - Operatør (Telia).</p>";

	mysqli_query($link, "INSERT INTO $t_edb_item_types
	(item_type_id, item_type_title, item_type_has_hard_disks, item_type_has_sim_cards, item_type_has_sd_cards, item_type_has_networks, item_type_terms) 
	VALUES 
	(NULL, 'PC', '1', '0', '0', '1', '$inp_terms_pc'),
	(NULL, 'Mobiltelefon', '0', '1', '1', '1', '$inp_terms_mobile'),
	(NULL, 'Nettbrett ', '0', '1', '1', '1', '$inp_terms_mobile'),
	(NULL, 'Smartklokke', '0', '0', '0', '1', ''),
	(NULL, 'Online konto', '0', '0', '1', '1', ''),
	(NULL, 'SD-kort', '0', '0', '1', '1', ''),
	(NULL, 'Minnepenn', '1', '0', '0', '0', '')
	") or die(mysqli_error($link));

}
echo"
<!-- //edb_item_types -->

";
?>