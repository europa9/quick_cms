<?php
/**
*
* File: _admin/_inc/recipes/_liquidbase_db_scripts/recipes_rating.php
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

	<!-- $t_recipes_rating -->
	";
	$query = "SELECT * FROM $t_recipes_rating";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_rating: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_rating(
	  	 rating_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(rating_id), 
	  	   rating_recipe_id INT,
	  	   rating_1 INT,
	  	   rating_2 INT,
	  	   rating_3 INT,
	  	   rating_4 INT,
	  	   rating_5 INT,
	  	   rating_total_votes INT,
	  	   rating_average INT,
	  	   rating_popularity INT,
	  	   rating_ip_block TEXT)")
		   or die(mysqli_error());

		/*
		mysqli_query($link, "
INSERT INTO $t_recipes_rating (`rating_id`, `rating_recipe_id`, `rating_1`, `rating_2`, `rating_3`, `rating_4`, `rating_5`, `rating_total_votes`, `rating_average`, `rating_popularity`) VALUES
(1, 1, 0, 0, 0, 0, 2, 2, 5, 10),
(2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 6, 0, 0, 0, 0, 1, 1, 5, 5),
(7, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 10, 0, 0, 0, 0, 1, 1, 5, 5),
(11, 11, 0, 0, 0, 0, 1, 1, 5, 5),
(12, 12, 0, 0, 0, 0, 1, 1, 5, 5),
(13, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
		
(20, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),

		(21, 21, 0, 0, 0, 0, 1, 1, 5, 5)")
		   or die(mysqli_error());
		*/

	}
	echo"
	<!-- //$t_recipes_rating -->


";
?>