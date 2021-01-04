<?php
/**
*
* File: _admin/_inc/recipes/_liquidbase_db_scripts/recipes_groups.php
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


	<!-- $t_recipes_groups -->
	";
	$query = "SELECT * FROM $t_recipes_groups";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_groups: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_groups(
	  	 group_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(group_id), 
	  	   group_recipe_id INT,
	  	   group_title VARCHAR(50))")
		   or die(mysqli_error());

		/*
		mysqli_query($link, "INSERT INTO $t_recipes_groups (`group_id`, `group_recipe_id`, `group_title`) 
		VALUES(1, 1, 'Matrett'),
(2, 2, 'Cherry filling'),
(3, 2, 'Crust and topping'),
(4, 3, 'Ingredients'),
(5, 4, 'Burger'),
(6, 4, 'Toppings'),
(7, 5, 'Ingredients'),
(8, 6, 'Matrett'),
(9, 7, 'Dish'),
(10, 8, 'Dish'),
(11, 9, 'Dish'),
(12, 10, 'Matrett'),
(13, 11, 'Matrett'),
(14, 12, 'Matrett'),
(15, 13, 'Ingredients'),
(16, 14, 'Ingredients'),
(17, 15, 'Ingredients'),
(18, 16, 'Ingredients'),
(19, 17, 'Broth'),
(20, 17, 'Ramen'),
(21, 18, 'Ingredients'),
(32, 28, 'Ingredients'),
(23, 20, 'Dish'),
(24, 21, 'Matrett'),
(27, 24, 'Ingredients'),
(28, 25, 'Ingredients'),
(30, 24, 'Vegetables'),
(31, 27, 'Ingredients'),
(33, 29, 'Ingredients'),
(34, 30, 'Ingredients'),
(35, 31, 'Ingredients'),
(36, 32, 'Ingredients'),
(37, 33, 'Ingredients'),
(38, 34, 'Ingredients'),
(39, 35, 'Ingredients'),
(40, 36, 'Ingredients'),
(41, 37, '')")
		   or die(mysqli_error());
		*/

	}
	echo"
	<!-- //$t_recipes_groups -->

";
?>