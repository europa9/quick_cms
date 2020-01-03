<?php
/**
*
* File: _admin/_inc/edb/_liquibase/item/002_item_types_available_passwords.php
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


<!-- edb_item_available_passwords -->
";

$query = "SELECT * FROM $t_edb_item_types_available_passwords LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_item_types_available_passwords: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_item_types_available_passwords(
	  available_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(available_id), 
	   available_item_type_id INT, 
	   available_title VARCHAR(200),
	   available_title_clean VARCHAR(200),
	   available_type VARCHAR(200), 
	   available_size INT, 
	   available_last_updated_datetime DATETIME, 
	   available_last_updated_user_id INT
	   )")
	   or die(mysqli_error());

	// PC
	mysqli_query($link, "INSERT INTO $t_edb_item_types_available_passwords
	(available_id, available_item_type_id, available_title, available_title_clean, available_type, available_size) 
	VALUES 
	(NULL, 1, 'User', 'bruker', 'text', 25),
	(NULL, 1, 'Password', 'passord', 'text', 25)
	") or die(mysqli_error($link));

	// Mobiltelefon
	mysqli_query($link, "INSERT INTO $t_edb_item_types_available_passwords
	(available_id, available_item_type_id, available_title, available_title_clean, available_type, available_size) 
	VALUES 
	(NULL, 2, 'Unlock pattern', 'unlock_pattern', NULL),
	(NULL, 2, 'PIN', 'pin', 'text', 7),
	(NULL, 2, 'Password', 'passord', 'text', 7)
	") or die(mysqli_error($link));

	// Nettbrett
	mysqli_query($link, "INSERT INTO $t_edb_item_types_available_passwords
	(available_id, available_item_type_id, available_title, available_title_clean, available_type, available_size) 
	VALUES 
	(NULL, 3, 'Unlock pattern', 'unlock_pattern', NULL),
	(NULL, 3, 'PIN', 'pin', 'text', 7),
	(NULL, 3, 'Password', 'passord', 'text', 7)
	") or die(mysqli_error($link));

	// Online konto
	mysqli_query($link, "INSERT INTO $t_edb_item_types_available_passwords
	(available_id, available_item_type_id, available_title, available_title_clean, available_type, available_size) 
	VALUES 
	(NULL, 5, 'Domain', 'domene', 'screen_lock', NULL),
	(NULL, 5, 'Username', 'brukernavn', 'text', 7),
	(NULL, 5, 'Password', 'passord', 'text', 7)
	") or die(mysqli_error($link));

}
echo"
<!-- //edb_item_types_available_passwords -->

";
?>