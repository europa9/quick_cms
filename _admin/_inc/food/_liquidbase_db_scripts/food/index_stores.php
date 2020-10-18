<?php
/**
*
* File: _admin/_inc/food/_liquibase/food/index_stores.php
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

$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_food_index_stores") or die(mysqli_error($link)); 


echo"


	<!-- food_index_stores -->
	";
	$query = "SELECT * FROM $t_food_index_stores";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_food_index_stores: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_food_index_stores(
	  	 food_store_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(food_store_id), 
	  	   food_store_food_id INT, 
	  	   food_store_store_id INT,
	  	   food_store_store_name VARCHAR(200), 
	  	   food_store_store_logo VARCHAR(200), 
	  	   food_store_store_price DOUBLE,
	  	   food_store_store_currency VARCHAR(200), 
	  	   food_store_user_id INT,
	  	   food_store_user_ip VARCHAR(200), 
	  	   food_store_updated DATETIME)")
		   or die(mysqli_error());

	}

	echo"
	<!-- //food_index_stores -->


";
?>