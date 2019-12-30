<?php
/**
*
* File: _admin/_inc/edb/_liquibase/item/016_case_index_evidence_items_passwords.php
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


<!-- edb_case_index_evidence_items_passwords -->
";

$query = "SELECT * FROM $t_edb_case_index_evidence_items_passwords LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_evidence_items_passwords: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_case_index_evidence_items_passwords(
	  password_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(password_id), 
	   password_case_id INT,
	   password_item_id INT, 
	   password_available_id INT, 
	   password_available_title VARCHAR(250), 
	   password_item_type_id INT, 
	   password_set_number INT, 
	   password_value VARCHAR(250), 
	   password_tag_a VARCHAR(250), 
	   password_tag_b VARCHAR(250), 
	   password_tag_c VARCHAR(250), 
	   password_created_by_user_id INT,
	   password_created_by_user_name VARCHAR(250), 
	   password_created_datetime DATETIME,
	   password_updated_by_user_id INT,
	   password_updated_by_user_name VARCHAR(250), 
	   password_updated_datetime DATETIME
	   )")
	   or die(mysqli_error());
	
}
echo"
<!-- //edb_case_index_evidence_items_passwords -->



";
?>