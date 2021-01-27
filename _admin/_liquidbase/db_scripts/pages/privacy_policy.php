<?php
/**
*
* File: _admin/_liquidbase/db_scripts/webdesign/privacy_policy.php
* Version 1.0.0
* Date 21:19 28.08.2019
* Copyright (c) 2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

// Access check
if(isset($_SESSION['admin_user_id'])){

	/*- Tables ---------------------------------------------------------------------------- */


	$t_pages_privacy_policy = $mysqlPrefixSav . "pages_privacy_policy";


	$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_pages_privacy_policy") or die(mysqli_error($link)); 



	echo"

	<!-- webdesign_share_buttons -->
	";

	$query = "SELECT * FROM $t_pages_privacy_policy LIMIT 1";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_pages_privacy_policy: $row_cnt</p>
		";
		}
		else{

		mysqli_query($link, "CREATE TABLE $t_pages_privacy_policy(
		  privacy_policy_id INT NOT NULL AUTO_INCREMENT,
		  PRIMARY KEY(privacy_policy_id), 
		   privacy_policy_title VARCHAR(200), 
		   privacy_policy_language VARCHAR(200), 
		   privacy_policy_text TEXT,
		   privacy_policy_is_active INT,
		   privacy_policy_created_date DATE,
		   privacy_policy_created_date_saying VARCHAR(200), 
		   privacy_policy_created_by_user_id INT,
		   privacy_policy_created_by_user_name VARCHAR(200), 
		   privacy_policy_created_by_user_email VARCHAR(200), 
		   privacy_policy_created_by_name VARCHAR(200), 
		   privacy_policy_updated_date DATE,
		   privacy_policy_updated_date_saying VARCHAR(200), 
		   privacy_policy_updated_by_user_id INT,
		   privacy_policy_updated_by_user_name VARCHAR(200), 
		   privacy_policy_updated_by_user_email VARCHAR(200), 
		   privacy_policy_updated_by_name VARCHAR(200)
		   )")
		   or die(mysqli_error());

		$date = date("Y-m-d");
		$date_saying = date("j F Y");
		mysqli_query($link, "INSERT INTO $t_pages_privacy_policy (privacy_policy_id, privacy_policy_title, privacy_policy_language, privacy_policy_text, privacy_policy_is_active, 
					privacy_policy_created_date, privacy_policy_created_date_saying, privacy_policy_created_by_user_id, privacy_policy_created_by_user_name, privacy_policy_created_by_user_email, 
					privacy_policy_created_by_name)
					VALUES 
					(NULL, 'Privacy Policy', 'en', '', '1',
					'$date', '$date_saying', '1', 'Admin', '', 
					'Admin')
					") or die(mysqli_error());

		mysqli_query($link, "INSERT INTO $t_pages_privacy_policy (privacy_policy_id, privacy_policy_title, privacy_policy_language, privacy_policy_text, privacy_policy_is_active, 
					privacy_policy_created_date, privacy_policy_created_date_saying, privacy_policy_created_by_user_id, privacy_policy_created_by_user_name, privacy_policy_created_by_user_email, 
					privacy_policy_created_by_name)
					VALUES 
					(NULL, 'Personvernregler', 'no', '', '1',
					'$date', '$date_saying', '1', 'Admin', '', 
					'Admin')
					") or die(mysqli_error());
	}
	echo"
	<!-- //webdesign_share_buttons -->
	";
} // access
?>