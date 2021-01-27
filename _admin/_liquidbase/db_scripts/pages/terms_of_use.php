<?php
/**
*
* File: _admin/_liquidbase/db_scripts/webdesign/terms_of_use.php
* Version 1.0.0
* Date 21:19 28.08.2019
* Copyright (c) 2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

// Access check
if(isset($_SESSION['admin_user_id'])){

	/*- Tables ---------------------------------------------------------------------------- */


	$t_pages_terms_of_use = $mysqlPrefixSav . "pages_terms_of_use";


	$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_pages_terms_of_use") or die(mysqli_error($link)); 



	echo"

	<!-- webdesign_share_buttons -->
	";

	$query = "SELECT * FROM $t_pages_terms_of_use LIMIT 1";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_pages_terms_of_use: $row_cnt</p>
		";
		}
		else{
		mysqli_query($link, "CREATE TABLE $t_pages_terms_of_use(
		  terms_of_use_id INT NOT NULL AUTO_INCREMENT,
		  PRIMARY KEY(terms_of_use_id), 
		   terms_of_use_title VARCHAR(200), 
		   terms_of_use_language VARCHAR(200), 
		   terms_of_use_text TEXT,
		   terms_of_use_is_active INT,
		   terms_of_use_created_date DATE,
		   terms_of_use_created_date_saying VARCHAR(200), 
		   terms_of_use_created_by_user_id INT,
		   terms_of_use_created_by_user_name VARCHAR(200), 
		   terms_of_use_created_by_user_email VARCHAR(200), 
		   terms_of_use_created_by_name VARCHAR(200), 
		   terms_of_use_updated_date DATE,
		   terms_of_use_updated_date_saying VARCHAR(200), 
		   terms_of_use_updated_by_user_id INT,
		   terms_of_use_updated_by_user_name VARCHAR(200), 
		   terms_of_use_updated_by_user_email VARCHAR(200), 
		   terms_of_use_updated_by_name VARCHAR(200)
		   )")
		   or die(mysqli_error());

		$date = date("Y-m-d");
		$date_saying = date("j F Y");
		mysqli_query($link, "INSERT INTO $t_pages_terms_of_use(terms_of_use_id, terms_of_use_title, terms_of_use_language, terms_of_use_text, terms_of_use_is_active, terms_of_use_created_date, terms_of_use_created_date_saying, terms_of_use_created_by_user_id, terms_of_use_created_by_user_name, terms_of_use_created_by_user_email, terms_of_use_created_by_name)
					VALUES 
					(NULL, 'Terms of Use', 'en', '', '1', '$date', '$date_saying', '1', 'Admin', '', 'Admin'),
					(NULL, 'Vilkår for bruk', 'no', '', '1', '$date', '$date_saying', '1', 'Admin', '', 'Admin')
					") or die(mysqli_error());
	}
	echo"
	<!-- //webdesign_share_buttons -->
	";
} // access
?>