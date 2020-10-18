<?php
/**
*
* File: _admin/_inc/food/_liquibase/food/stores.php
* Version 1.0.0
* Date 15:43 18.10.2020
* Copyright (c) 2020 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Tables ---------------------------------------------------------------------------- */

$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_food_stores") or die(mysqli_error($link)); 


echo"

	<!-- food_stores -->
	";
	$query = "SELECT * FROM $t_food_stores";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_food_stores: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_food_stores(
	  	 store_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(store_id), 
	  	   store_user_id INT, 
	  	   store_name VARCHAR(200), 
	  	   store_country VARCHAR(200), 
	  	   store_language VARCHAR(200), 
	  	   store_website VARCHAR(200), 
	  	   store_logo VARCHAR(200), 
	  	   store_added_datetime DATETIME, 
	  	   store_added_datetime_print VARCHAR(200), 
	  	   store_updatet_datetime DATETIME, 
	  	   store_updatet_datetime_print VARCHAR(200), 
	  	   store_user_ip VARCHAR(200),
	  	   store_reported VARCHAR(200), 
	  	   store_reported_checked VARCHAR(200))")
		   or die(mysqli_error());

	}
	echo"
	<!-- //food_stores -->


";
?>