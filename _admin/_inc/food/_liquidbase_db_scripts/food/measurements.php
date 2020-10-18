<?php
/**
*
* File: _admin/_inc/food/_liquibase/food/measurements.php
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

$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_food_measurements") or die(mysqli_error($link)); 


echo"

	<!-- food_measurements -->
	";

	
	$query = "SELECT * FROM $t_food_measurements";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_food_measurements: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_food_measurements(
	  	 measurement_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(measurement_id), 
	  	   measurement_name VARCHAR(50), 
	  	   measurement_last_updated DATETIME)")
		   or die(mysqli_error());


		// En
		$inp_measurement_last_updated = date("Y-m-d H:i:s");
		mysqli_query($link, "INSERT INTO $t_food_measurements
		(measurement_id, measurement_name, measurement_last_updated) 
		VALUES 
		(NULL, 'bag', '$inp_measurement_last_updated'),
		(NULL, 'bowl', '$inp_measurement_last_updated'),
		(NULL, 'box', '$inp_measurement_last_updated'),
		(NULL, 'handful', '$inp_measurement_last_updated'),
		(NULL, 'package', '$inp_measurement_last_updated'),
		(NULL, 'piece', '$inp_measurement_last_updated'),
		(NULL, 'pizza', '$inp_measurement_last_updated'),
		(NULL, 'slice', '$inp_measurement_last_updated'),
		(NULL, 'spoon', '$inp_measurement_last_updated'),
		(NULL, 'teaspoon', '$inp_measurement_last_updated'),
		(NULL, 'tablespoon', '$inp_measurement_last_updated')
		")
		or die(mysqli_error($link));
	}

	echo"
";
?>