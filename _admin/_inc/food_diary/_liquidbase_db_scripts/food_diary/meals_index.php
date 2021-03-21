<?php
/**
*
* File: _admin/_inc/food_diary/_liquidbase_db_scripts/food_diary/meals.php
* Version 1.0.0
* Date 11:50 20.03.2021
* Copyright (c) 2021 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Tables ---------------------------------------------------------------------------- */

$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_food_diary_meals_index") or die(mysqli_error($link)); 


echo"

	<!-- food_diary_meals_index -->
	";
	$query = "SELECT * FROM $t_food_diary_meals_index";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_food_diary_meals_index: $row_cnt</p>
		";
	}
	else{
		echo"
		";


		mysqli_query($link, "CREATE TABLE $t_food_diary_meals_index(
	  	 meal_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(meal_id), 
	  	   meal_user_id INT,
	  	   meal_hour_name VARCHAR(50),
	  	   meal_last_used_date DATE,

	  	   meal_energy_total DOUBLE,
	  	   meal_fat_total DOUBLE,
	  	   meal_saturated_total DOUBLE,
	  	   meal_monounsaturated_fat_total DOUBLE,
	  	   meal_polyunsaturated_fat_total DOUBLE,
	  	   meal_cholesterol_total DOUBLE,
	  	   meal_carbohydrates_total DOUBLE,
	  	   meal_carbohydrates_of_which_sugars_total DOUBLE,
	  	   meal_dietary_fiber_total DOUBLE,
	  	   meal_proteins_total DOUBLE,
	  	   meal_salt_total DOUBLE,
	  	   meal_sodium_total INT)")
		   or die(mysqli_error());

	}
	echo"
	<!-- //food_diary_meals_index -->

";
?>