<?php
/**
*
* File: _admin/_inc/recipes/_liquidbase_db_scripts/recipes_items.php
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


	<!-- $t_recipes_items -->
	";
	$query = "SELECT * FROM $t_recipes_items";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_items: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_items(
	  	 item_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(item_id), 
	  	   item_recipe_id INT,
	  	   item_group_id INT,
	  	   item_amount DOUBLE,
	  	   item_measurement VARCHAR(50),
	  	   item_grocery VARCHAR(250),
	  	   item_grocery_explanation VARCHAR(250),
	  	   item_food_id INT,
	  	   item_calories_per_hundred DOUBLE,
	  	   item_fat_per_hundred DOUBLE,
	  	   item_fat_of_which_saturated_fatty_acids_per_hundred DOUBLE,
	  	   item_carbs_per_hundred DOUBLE,
	  	   item_carbs_of_which_dietary_fiber_hundred DOUBLE,
	  	   item_carbs_of_which_sugars_per_hundred DOUBLE,
	  	   item_proteins_per_hundred DOUBLE,
	  	   item_salt_per_hundred DOUBLE,
	  	   item_sodium_per_hundred INT,
	  	   item_calories_calculated DOUBLE,
	  	   item_fat_calculated DOUBLE,
	  	   item_fat_of_which_saturated_fatty_acids_calculated DOUBLE,
	  	   item_carbs_calculated DOUBLE,
	  	   item_carbs_of_which_dietary_fiber_calculated DOUBLE,
	  	   item_carbs_of_which_sugars_calculated DOUBLE,
	  	   item_proteins_calculated DOUBLE,
	  	   item_salt_calculated DOUBLE,
	  	   item_sodium_calculated INT)")
		   or die(mysqli_error());


		// include("_inc/recipes/tables_insert_items.php");

	}
		

	echo"
	<!-- //$t_recipes_items -->



";
?>