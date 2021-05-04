<?php
/**
*
* File: _admin/_liquidbase/db_scripts/webdesign/frontpage_grid_groups.php
* Version 1.0.0
* Date 09:11 04.05.2021
* Copyright (c) 2021 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

// Access check
if(isset($_SESSION['admin_user_id'])){

	/*- Tables ---------------------------------------------------------------------------- */


	$t_grid_groups	= $mysqlPrefixSav . "grid_groups";


	$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_grid_groups") or die(mysqli_error($link)); 



	echo"

	<!-- grid_groups -->
	";

	$query = "SELECT * FROM $t_grid_groups LIMIT 1";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_grid_groups: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_grid_groups(
		  group_id INT NOT NULL AUTO_INCREMENT,
		  PRIMARY KEY(group_id), 
		   group_language VARCHAR(20),
		   group_title VARCHAR(200), 
		   group_title_english VARCHAR(200), 
		   group_active INT,
		   group_created_datetime DATETIME,
		   group_created_user_id INT,
		   group_updated_datetime DATETIME,
		   group_updated_user_id INT
		   )")
		   or die(mysqli_error());

		$my_user_id = $_SESSION['admin_user_id'];
		$my_user_id = output_html($my_user_id);
		$my_user_id_mysql = quote_smart($link, $my_user_id);

		$datetime = date("Y-m-d H:i:s");

		mysqli_query($link, "INSERT INTO $t_grid_groups(group_id, group_language, group_title, group_title_english, group_active, group_created_user_id, group_created_datetime)
					VALUES 
					(NULL, 'en', 'Frontpage', 'Frontpage', 0, $my_user_id_mysql, '$datetime'),
					(NULL, 'no', 'Forside', 'Frontpage', 0, $my_user_id_mysql, '$datetime')
					") or die(mysqli_error());


	}
	echo"
	<!-- //grid_groups -->
	";
} // access
?>