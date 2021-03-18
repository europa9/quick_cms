<?php
/**
*
* File: _admin/_inc/recipes/_liquidbase_db_scripts/recipes_numbers.php
* Version 1.0.0
* Date 17:21 31.12.2020
* Copyright (c) 2020 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

mysqli_query($link, "DROP TABLE $t_recipes_numbers") or die(mysqli_error());


echo"

	<!-- $t_recipes_numbers -->
	";
	$query = "SELECT * FROM $t_recipes_numbers";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_numbers: $row_cnt</p>
		";
	}
	else{

		echo"<pre>CREATE TABLE $t_recipes_numbers(
	  	 number_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(number_id), 
	  	   number_recipe_id INT,
	  	   number_servings INT,

		  number_energy_metric double DEFAULT NULL,
		  number_fat_metric double DEFAULT NULL,
		  number_saturated_fat_metric double DEFAULT NULL,
		  number_monounsaturated_fat_metric double DEFAULT NULL,
		  number_polyunsaturated_fat_metric double DEFAULT NULL,
	  	  number_cholesterol_metric DOUBLE,
		  number_carbohydrates_metric double DEFAULT NULL,
		  number_carbohydrates_of_which_sugars_metric double DEFAULT NULL,
		  number_dietary_fiber_metric double DEFAULT NULL,
		  number_proteins_metric double DEFAULT NULL,
		  number_salt_metric double DEFAULT NULL,
 		  number_sodium_metric int(11) DEFAULT NULL,

		  number_energy_serving double DEFAULT NULL,
		  number_fat_serving double DEFAULT NULL,
		  number_saturated_fat_serving double DEFAULT NULL,
		  number_monounsaturated_fat_serving double DEFAULT NULL,
		  number_polyunsaturated_fat_serving double DEFAULT NULL,
	  	  number_cholesterol_serving DOUBLE,
		  number_carbohydrates_serving double DEFAULT NULL,
		  number_carbohydrates_of_which_sugars_serving double DEFAULT NULL,
		  number_dietary_fiber_serving double DEFAULT NULL,
		  number_proteins_serving double DEFAULT NULL,
		  number_salt_serving double DEFAULT NULL,
 		  number_sodium_serving int(11) DEFAULT NULL,

		  number_energy_total double DEFAULT NULL,
		  number_fat_total double DEFAULT NULL,
		  number_saturated_fat_total double DEFAULT NULL,
		  number_monounsaturated_fat_total double DEFAULT NULL,
		  number_polyunsaturated_fat_total double DEFAULT NULL,
	  	  number_cholesterol_total DOUBLE,
		  number_carbohydrates_total double DEFAULT NULL,
		  number_carbohydrates_of_which_sugars_total double DEFAULT NULL,
		  number_dietary_fiber_total double DEFAULT NULL,
		  number_proteins_total double DEFAULT NULL,
		  number_salt_total double DEFAULT NULL,
 		  number_sodium_total int(11) DEFAULT NULL)</pre>";

		mysqli_query($link, "CREATE TABLE $t_recipes_numbers(
	  	 number_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(number_id), 
	  	   number_recipe_id INT,
	  	   number_servings INT,

		  number_energy_metric double DEFAULT NULL,
		  number_fat_metric double DEFAULT NULL,
		  number_saturated_fat_metric double DEFAULT NULL,
		  number_monounsaturated_fat_metric double DEFAULT NULL,
		  number_polyunsaturated_fat_metric double DEFAULT NULL,
	  	  number_cholesterol_metric DOUBLE,
		  number_carbohydrates_metric double DEFAULT NULL,
		  number_carbohydrates_of_which_sugars_metric double DEFAULT NULL,
		  number_dietary_fiber_metric double DEFAULT NULL,
		  number_proteins_metric double DEFAULT NULL,
		  number_salt_metric double DEFAULT NULL,
 		  number_sodium_metric int(11) DEFAULT NULL,

		  number_energy_serving double DEFAULT NULL,
		  number_fat_serving double DEFAULT NULL,
		  number_saturated_fat_serving double DEFAULT NULL,
		  number_monounsaturated_fat_serving double DEFAULT NULL,
		  number_polyunsaturated_fat_serving double DEFAULT NULL,
	  	  number_cholesterol_serving DOUBLE,
		  number_carbohydrates_serving double DEFAULT NULL,
		  number_carbohydrates_of_which_sugars_serving double DEFAULT NULL,
		  number_dietary_fiber_serving double DEFAULT NULL,
		  number_proteins_serving double DEFAULT NULL,
		  number_salt_serving double DEFAULT NULL,
 		  number_sodium_serving int(11) DEFAULT NULL,

		  number_energy_total double DEFAULT NULL,
		  number_fat_total double DEFAULT NULL,
		  number_saturated_fat_total double DEFAULT NULL,
		  number_monounsaturated_fat_total double DEFAULT NULL,
		  number_polyunsaturated_fat_total double DEFAULT NULL,
	  	  number_cholesterol_total DOUBLE,
		  number_carbohydrates_total double DEFAULT NULL,
		  number_carbohydrates_of_which_sugars_total double DEFAULT NULL,
		  number_dietary_fiber_total double DEFAULT NULL,
		  number_proteins_total double DEFAULT NULL,
		  number_salt_total double DEFAULT NULL,
 		  number_sodium_total int(11) DEFAULT NULL)")
		   or die(mysqli_error());

		// Loop trough all and calculate?
	}
	echo"
	<!-- //$t_recipes_numbers -->

";
?>