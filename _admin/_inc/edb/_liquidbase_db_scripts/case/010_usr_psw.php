<?php
/**
*
* File: _admin/_inc/edb/_liquibase/case/001_usr_psw.php
* Version 1.0.0
* Date 16:02 13.11.2019
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


<!-- edb_case_index_usr_psw -->
";
	
$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_edb_case_index_usr_psw") or die(mysqli_error($link)); 

$query = "SELECT * FROM $t_edb_case_index_usr_psw LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_usr_psw: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_usr_psw(
	  usr_psw_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(usr_psw_id), 
	   usr_psw_case_id INT,
	   usr_psw_related_to_text VARCHAR(250),
	   usr_psw_item_id INT,
	   usr_psw_record_id INT,
	   usr_psw_review_matrix_item_id INT,
	   usr_psw_domain VARCHAR(200), 
	   usr_psw_login_user VARCHAR(200), 
	   usr_psw_login_password VARCHAR(200), 
	   usr_psw_startup_password VARCHAR(200), 
	   usr_psw_screen_lock VARCHAR(200), 
	   usr_psw_pin VARCHAR(200), 
	   usr_psw_unlock_pattern VARCHAR(200), 
	   usr_psw_decrypt_password VARCHAR(200), 
	   usr_psw_bios_password VARCHAR(200), 
	   usr_psw_reset_to_a VARCHAR(250),
	   usr_psw_reset_to_b VARCHAR(250),
	   usr_psw_tag_a VARCHAR(250),
	   usr_psw_tag_b VARCHAR(250),
	   usr_psw_tag_c VARCHAR(250),
	   usr_psw_tag_d VARCHAR(250),
	   usr_psw_updated_datetime DATETIME,
	   usr_psw_updated_user_id INT,
	   usr_psw_updated_user_name VARCHAR(250)
	   )")
	   or die(mysqli_error());

}
echo"
<!-- /edb_case_index_usr_psw -->
";
?>