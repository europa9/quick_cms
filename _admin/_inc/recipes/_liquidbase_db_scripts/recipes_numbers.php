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
		mysqli_query($link, "CREATE TABLE $t_recipes_numbers(
	  	 number_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(number_id), 
	  	   number_recipe_id INT,
	  	   number_hundred_calories INT,
	  	   number_hundred_proteins INT,
	  	   number_hundred_fat INT,
	  	   number_hundred_fat_of_which_saturated_fatty_acids INT,
	  	   number_hundred_carbs INT,
	  	   number_hundred_carbs_of_which_dietary_fiber INT,
	  	   number_hundred_carbs_of_which_sugars INT,
	  	   number_hundred_salt DOUBLE,
	  	   number_hundred_sodium INT,

	  	   number_serving_calories INT,
	  	   number_serving_proteins INT,
	  	   number_serving_fat INT,
	  	   number_serving_fat_of_which_saturated_fatty_acids INT,
	  	   number_serving_carbs INT,
	  	   number_serving_carbs_of_which_dietary_fiber INT,
	  	   number_serving_carbs_of_which_sugars INT,
	  	   number_serving_salt DOUBLE,
	  	   number_serving_sodium INT,

	  	   number_total_weight INT,
	  	   number_total_calories INT,
	  	   number_total_proteins INT,
	  	   number_total_fat INT,
	  	   number_total_fat_of_which_saturated_fatty_acids INT,
	  	   number_total_carbs INT,
	  	   number_total_carbs_of_which_dietary_fiber INT,
	  	   number_total_carbs_of_which_sugars INT,
	  	   number_total_salt DOUBLE,
	  	   number_total_sodium INT,

	  	   number_servings INT)")
		   or die(mysqli_error());

		/*
		mysqli_query($link, "
INSERT INTO $t_recipes_numbers (`number_id`, `number_recipe_id`, `number_hundred_calories`, `number_hundred_proteins`, `number_hundred_fat`, `number_hundred_carbs`, `number_serving_calories`, `number_serving_proteins`, `number_serving_fat`, `number_serving_carbs`, `number_total_weight`, `number_total_calories`, `number_total_proteins`, `number_total_fat`, `number_total_carbs`, `number_servings`) VALUES
(1, 1, 0, 0, 0, 0, 250, 0, 0, 0, 0, 1251, 0, 0, 0, 5),
(2, 2, 0, 0, 0, 0, 265, 0, 0, 0, 0, 3190, 0, 0, 0, 12),
(3, 3, 0, 0, 0, 0, 163, 0, 0, 0, 0, 163, 0, 0, 0, 1),
(4, 4, 0, 0, 0, 0, 382, 0, 0, 0, 0, 382, 0, 0, 0, 1),
(5, 5, 0, 0, 0, 0, 126, 0, 0, 0, 0, 1260, 0, 0, 0, 10),
(6, 6, 0, 0, 0, 0, 210, 0, 0, 0, 0, 841, 0, 0, 0, 4),
(7, 7, 0, 0, 0, 0, 87, 0, 0, 0, 0, 174, 0, 0, 0, 2),
(8, 8, 0, 0, 0, 0, 80, 0, 0, 0, 0, 161, 0, 0, 0, 2),
(9, 9, 0, 0, 0, 0, 110, 0, 0, 0, 0, 110, 0, 0, 0, 1),
(10, 10, 0, 0, 0, 0, 472, 0, 0, 0, 0, 1889, 0, 0, 0, 4),
(11, 11, 0, 0, 0, 0, 655, 0, 0, 0, 0, 2623, 0, 0, 0, 4),
(12, 12, 0, 0, 0, 0, 551, 0, 0, 0, 0, 551, 0, 0, 0, 1),
(13, 13, 0, 0, 0, 0, 136, 0, 0, 0, 0, 136, 0, 0, 0, 1),
(14, 14, 0, 0, 0, 0, 116, 0, 0, 0, 0, 116, 0, 0, 0, 1),
(15, 15, 0, 0, 0, 0, 159, 0, 0, 0, 0, 159, 0, 0, 0, 1),
(16, 16, 0, 0, 0, 0, 44, 0, 0, 0, 0, 44, 0, 0, 0, 1),
(17, 17, 0, 0, 0, 0, 136, 0, 0, 0, 0, 136, 0, 0, 0, 1),
(18, 18, 0, 0, 0, 0, 89, 0, 0, 0, 0, 89, 0, 0, 0, 1),
(19, 19, 0, 0, 0, 0, 6, 0, 0, 0, 0, 6, 0, 0, 0, 1),
(20, 20, 0, 0, 0, 0, 155, 0, 0, 0, 0, 155, 0, 0, 0, 1),

		(21, 21, 0, 0, 0, 0, 424, 0, 0, 0, 0, 424, 0, 0, 0, 1)")
		   or die(mysqli_error());
		*/
	}
	echo"
	<!-- //$t_recipes_numbers -->

";
?>