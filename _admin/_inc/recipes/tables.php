<?php
/**
*
* File: _admin/_inc/recipes/tables.php
* Version 00.28 20.03.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}
/*- Tables ---------------------------------------------------------------------------- */
$t_recipes 	 			= $mysqlPrefixSav . "recipes";
$t_recipes_ingredients			= $mysqlPrefixSav . "recipes_ingredients";
$t_recipes_groups			= $mysqlPrefixSav . "recipes_groups";
$t_recipes_items			= $mysqlPrefixSav . "recipes_items";
$t_recipes_numbers			= $mysqlPrefixSav . "recipes_numbers";
$t_recipes_rating			= $mysqlPrefixSav . "recipes_rating";
$t_recipes_cuisines			= $mysqlPrefixSav . "recipes_cuisines";
$t_recipes_cuisines_translations	= $mysqlPrefixSav . "recipes_cuisines_translations";
$t_recipes_seasons			= $mysqlPrefixSav . "recipes_seasons";
$t_recipes_seasons_translations		= $mysqlPrefixSav . "recipes_seasons_translations";
$t_recipes_occasions			= $mysqlPrefixSav . "recipes_occasions";
$t_recipes_occasions_translations	= $mysqlPrefixSav . "recipes_occasions_translations";
$t_recipes_categories			= $mysqlPrefixSav . "recipes_categories";
$t_recipes_categories_translations	= $mysqlPrefixSav . "recipes_categories_translations";
$t_recipes_measurements			= $mysqlPrefixSav . "recipes_measurements";
$t_recipes_measurements_translations	= $mysqlPrefixSav . "recipes_measurements_translations";
$t_recipes_weekly_special		= $mysqlPrefixSav . "recipes_weekly_special";
$t_recipes_of_the_day			= $mysqlPrefixSav . "recipes_of_the_day";
$t_recipes_comments			= $mysqlPrefixSav . "recipes_comments";
$t_recipes_favorites			= $mysqlPrefixSav . "recipes_favorites";
$t_recipes_tags				= $mysqlPrefixSav . "recipes_tags";
$t_recipes_links			= $mysqlPrefixSav . "recipes_links";
$t_recipes_comments			= $mysqlPrefixSav . "recipes_comments";
$t_recipes_searches			= $mysqlPrefixSav . "recipes_searches";
$t_recipes_age_restrictions 	 	= $mysqlPrefixSav . "recipes_age_restrictions";
$t_recipes_age_restrictions_accepted	= $mysqlPrefixSav . "recipes_age_restrictions_accepted";

echo"
<h1>Tables</h1>


	<!-- $t_recipes -->
	";
	
	$query = "SELECT * FROM $t_recipes";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes: $row_cnt</p>
		";
	}
	else{
		echo"
		<table>
		 <tr> 
		  <td style=\"padding-right: 6px;\">
			<p>
			<img src=\"_design/gfx/loading_22.gif\" alt=\"Loading\" />
			</p>
		  </td>
		  <td>
			<h1>Loading...</h1>
		  </td>
		 </tr>
		</table>

		
		<meta http-equiv=\"refresh\" content=\"2;url=index.php?open=$open&amp;page=$page\">
		";


		mysqli_query($link, "CREATE TABLE $t_recipes(
	  	 recipe_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(recipe_id), 
	  	   recipe_user_id INT,
	  	   recipe_title VARCHAR(250),
	  	   recipe_category_id INT,
	  	   recipe_language VARCHAR(50),
	  	   recipe_country VARCHAR(200),
	  	   recipe_introduction TEXT,
	  	   recipe_directions TEXT,
	  	   recipe_image_path VARCHAR(250),
	  	   recipe_image VARCHAR(250),
	  	   recipe_thumb VARCHAR(250),
	  	   recipe_video VARCHAR(250),
	  	   recipe_date DATE,
	  	   recipe_time TIME,
	  	   recipe_cusine_id INT,
	  	   recipe_season_id INT,
	  	   recipe_occasion_id INT,
	  	   recipe_marked_as_spam VARCHAR(250),
	  	   recipe_unique_hits INT,
	  	   recipe_unique_hits_ip_block TEXT,
	  	   recipe_comments INT,
	  	   recipe_user_ip VARCHAR(250),
	  	   recipe_notes VARCHAR(50),
	  	   recipe_password VARCHAR(120),
	  	   recipe_last_viewed DATETIME,
		   recipe_age_restriction INT)")
		   or die(mysqli_error());

		// include("_inc/recipes/tables_insert_recipes.php");
	}


	echo"
	<!-- //$t_recipes -->

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

	<!-- $t_recipes_cuisines -->
	";
	$query = "SELECT * FROM $t_recipes_cuisines";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_cuisines: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_cuisines(
	  	 cuisine_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(cuisine_id), 
	  	   cuisine_name VARCHAR(250), 
	  	   cuisine_image VARCHAR(250), 
	  	   cuisine_last_updated DATE)")
		   or die(mysqli_error());

		mysqli_query($link, "INSERT INTO $t_recipes_cuisines 
		(cuisine_id, cuisine_name) 
		VALUES 
		(NULL, 'American'),
		(NULL, 'Chinese'),
		(NULL, 'Continental'),
		(NULL, 'Cuban'),
		(NULL, 'French'),
		(NULL, 'Greek'),
		(NULL, 'Indian'),
		(NULL, 'Indonesian'),
		(NULL, 'Italian'),
		(NULL, 'Japanese'),
		(NULL, 'Korean'),
		(NULL, 'Lebanese'),
		(NULL, 'Malaysian'),
		(NULL, 'Mexican'),
		(NULL, 'Pakistani'),
		(NULL, 'Russian'),
		(NULL, 'Singapore'),
		(NULL, 'Spanish'),
		(NULL, 'Thai'),
		(NULL, 'Tibetan'),
		(NULL, 'Vietnamese'),
		(NULL, 'Italian'),
		(NULL, 'Norwegian')")
		or die(mysqli_error($link));
	}
	echo"
	<!-- //$t_recipes_cuisines -->

	<!-- $t_recipes_cuisines_translations -->
	";
	$query = "SELECT * FROM $t_recipes_cuisines_translations";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_cuisines_translations: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_cuisines_translations(
	  	 cuisine_translation_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(cuisine_translation_id), 
	  	   cuisine_id VARCHAR(250), 
	  	   cuisine_translation_language VARCHAR(2), 
	  	   cuisine_translation_value VARCHAR(250), 
	  	   cuisine_translation_no_recipes INT, 
	  	   cuisine_translation_last_updated DATE)")
		   or die(mysqli_error());

	}
	echo"
	<!-- //$t_recipes_cuisines_translations -->

	<!-- $t_recipes_seasons -->
	";
	$query = "SELECT * FROM $t_recipes_seasons";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_seasons: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_seasons(
	  	 season_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(season_id), 
	  	   season_name VARCHAR(250),
	  	   season_image VARCHAR(250),
	  	   season_last_updated DATE)")
		   or die(mysqli_error());

		mysqli_query($link, "INSERT INTO $t_recipes_seasons
		(season_id, season_name) 
		VALUES 
		(NULL, 'January'),
		(NULL, 'February'),
		(NULL, 'March'),
		(NULL, 'April'),
		(NULL, 'May'),
		(NULL, 'June'),
		(NULL, 'July'),
		(NULL, 'August'),
		(NULL, 'September'),
		(NULL, 'October'),
		(NULL, 'November'),
		(NULL, 'December')")
		or die(mysqli_error($link));
	}
	echo"
	<!-- //$t_recipes_seasons -->

	<!-- $t_recipes_seasons_translations -->
	";
	$query = "SELECT * FROM $t_recipes_seasons_translations";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_seasons_translations: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_seasons_translations(
	  	 season_translation_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(season_translation_id), 
	  	   season_id VARCHAR(250), 
	  	   season_translation_language VARCHAR(2), 
	  	   season_translation_value VARCHAR(250), 
	  	   season_translation_no_recipes INT, 
	  	   season_translation_last_updated DATE)")
		   or die(mysqli_error());

	}
	echo"
	<!-- //$t_recipes_seasons_translations -->

	<!-- $t_recipes_occasions -->
	";
	$query = "SELECT * FROM $t_recipes_occasions";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_occasions: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_occasions(
	  	occasion_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(occasion_id), 
	  	   occasion_name VARCHAR(250),
	  	   occasion_day INT,
	  	   occasion_month INT,
	  	   occasion_image VARCHAR(250), 
	  	   occasion_last_updated DATE)")
		   or die(mysqli_error());

		mysqli_query($link, "INSERT INTO $t_recipes_occasions
		(occasion_id, occasion_name, occasion_day, occasion_month) 
		VALUES 
		(NULL, 'Thanksgiving', '23', '11'),
		(NULL, 'Christmas', '24', '12'),
		(NULL, 'Hanukkah', '12', '12'),
		(NULL, 'New Year', '31', '12'),
		(NULL, 'Burns Night', '25', '01'),
		(NULL, 'Valentines Day', '14', '02'),
		(NULL, 'Chinese New Year', '16', '02'),
		(NULL, 'Pancake Day', '28', '02'),
		(NULL, 'St Davids Day', '01', '03'),
		(NULL, 'Mothers Day', '11', '03'),
		(NULL, 'St Patricks Day', '17', '03'),
		(NULL, 'Passover', '30', '03'),
		(NULL, 'Easter', '01', '04'),
		(NULL, 'Thai New Year', '13', '04'),
		(NULL, 'Baisakhi', '14', '04'),
		(NULL, 'St Georges Day', '23', '04'),
		(NULL, 'Eid', '14', '05'),
		(NULL, 'Fathers Day', '17', '06'),
		(NULL, 'Barbecue', '22', '06'),
		(NULL, 'Picnic', '23', '06'),
		(NULL, 'Student food', '01', '09'),
		(NULL, 'Diwali', '09', '10'),
		(NULL, 'Halloween', '31', '10'),
		(NULL, 'Bonfire Night', '05', '11')")
		or die(mysqli_error($link));
	}
	echo"
	<!-- //$t_recipes_occasions -->

	<!-- $t_recipes_occasions_translations -->
	";
	$query = "SELECT * FROM $t_recipes_occasions_translations";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_occasions_translations: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_occasions_translations(
	  	 occasion_translation_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(occasion_translation_id), 
	  	   occasion_id VARCHAR(250), 
	  	   occasion_translation_language VARCHAR(2), 
	  	   occasion_translation_value VARCHAR(250), 
	  	   occasion_translation_no_recipes INT, 
	  	   occasion_translation_last_updated DATE)")
		   or die(mysqli_error());

	}
	echo"
	<!-- //$t_recipes_occasions_translations -->




	<!-- $t_recipes_categories -->
	";
	$query = "SELECT * FROM $t_recipes_categories";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_categories: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_categories(
	  	category_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(category_id), 
	  	   category_name VARCHAR(250), 
	  	   category_age_restriction INT, 
	  	   category_icon_path VARCHAR(250), 
	  	   category_icon_file VARCHAR(250), 
	  	   category_last_updated DATETIME)")
		   or die(mysqli_error());

		mysqli_query($link, "INSERT INTO $t_recipes_categories
		(category_id, category_name, category_age_restriction) 
		VALUES 
		(NULL, 'Breakfast', '0'),
		(NULL, 'Dinner', '0'),
		(NULL, 'Sideretter', '0'),
		(NULL, 'Snacks', '0'),
		(NULL, 'Dessert', '0'),
		(NULL, 'Drinks', '1')")
		or die(mysqli_error($link));
	}
	echo"
	<!-- //$t_recipes_categories -->


	<!-- $t_recipes_categories_translations -->
	";
	$query = "SELECT * FROM $t_recipes_categories_translations";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_categories_translations: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_categories_translations(
	  	category_translation_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(category_translation_id), 
	  	   category_id INT, 
	  	   category_translation_language VARCHAR(250), 
	  	   category_translation_value VARCHAR(250), 
	  	   category_translation_no_recipes INT, 
	  	   category_translation_image_path VARCHAR(250), 
	  	   category_translation_image VARCHAR(250), 
	  	   category_translation_image_updated_week INT, 
	  	   category_translation_last_updated DATETIME)")
		   or die(mysqli_error());



		mysqli_query($link, "INSERT INTO $t_recipes_categories_translations
		(category_translation_id, category_id, category_translation_language, category_translation_value)
		VALUES 
		(NULL, 1, 'en', 'Breakfast'),
		(NULL, 2, 'en', 'Dinner'),
		(NULL, 3, 'en', 'Sides'),
		(NULL, 4, 'en', 'Snacks'),
		(NULL, 5, 'en', 'Dessert'),
		(NULL, 6, 'en', 'Drinks'),
		(NULL, 1, 'no', 'Frokost'),
		(NULL, 2, 'no', 'Middag'),
		(NULL, 3, 'no', 'Sideretter'),
		(NULL, 4, 'no', 'Snacks'),
		(NULL, 5, 'no', 'Dessert'),
		(NULL, 6, 'no', 'Drikke')")
		or die(mysqli_error($link));

	}
	echo"
	<!-- //$t_recipes_categories_translations -->




	<!-- $t_recipes_measurements -->
	";
	$query = "SELECT * FROM $t_recipes_measurements";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_measurements: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_measurements(
	  	measurement_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(measurement_id), 
	  	   measurement_name VARCHAR(250), 
	  	   measurement_g double, 
	  	   measurement_ml double)")
		   or die(mysqli_error());

	}
	echo"
	<!-- //$t_recipes_measurements -->


	<!-- $t_recipes_measurements_translations -->
	";
	$query = "SELECT * FROM $t_recipes_measurements_translations";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_categories_translations: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_measurements_translations(
	  	category_translation_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(category_translation_id), 
	  	   category_id INT, 
	  	   category_translation_language VARCHAR(250), 
	  	   category_translation_value VARCHAR(250))")
		   or die(mysqli_error());

	}
	echo"
	<!-- //$t_recipes_measurements_translations -->


	<!-- $t_recipes_weekly_special -->
	";
	$query = "SELECT * FROM $t_recipes_weekly_special";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_weekly_special: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_weekly_special(
	  	weekly_special_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(weekly_special_id), 
	  	   weekly_special_week INT, 
	  	   weekly_special_year INT, 
	  	   weekly_special_language VARCHAR(250), 
	  	   weekly_special_recipe_id INT)")
		   or die(mysqli_error());
	}
	echo"
	<!-- //$t_recipes_weekly_special -->



	<!-- $t_recipes_of_the_day -->
	";
	$query = "SELECT * FROM $t_recipes_of_the_day";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_of_the_day: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_of_the_day(
	  	recipe_of_the_day_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(recipe_of_the_day_id), 
	  	   recipe_of_the_day_date DATE, 
	  	   recipe_of_the_day_language VARCHAR(250), 
	  	   recipe_of_the_day_recipe_id INT)")
		   or die(mysqli_error());
	}
	echo"
	<!-- //$t_recipes_of_the_day -->


	<!-- $t_recipes_categories_translations -->
	";
	$query = "SELECT * FROM $t_recipes_categories_translations";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_categories_translations: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_categories_translations(
	  	category_translation_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(category_translation_id), 
	  	   category_id INT, 
	  	   category_translation_language VARCHAR(250), 
	  	   category_translation_value VARCHAR(250))")
		   or die(mysqli_error());

	}
	echo"
	<!-- //$t_recipes_weekly_special -->


	<!-- $t_recipes_favorites -->
	";
	$query = "SELECT * FROM $t_recipes_favorites";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_favorites: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_favorites(
	  	recipe_favorite_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(recipe_favorite_id), 
	  	   recipe_favorite_recipe_id INT, 
	  	   recipe_favorite_user_id INT,
	  	   recipe_favorite_comment VARCHAR(250))")
		   or die(mysqli_error());

	}
	echo"
	<!-- //$t_recipes_favorites -->






	<!-- tags -->
	";
	$query = "SELECT * FROM $t_recipes_tags";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_tags: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_tags(
	  	 tag_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(tag_id), 
	  	   tag_language VARCHAR(20),
	  	   tag_recipe_id INT,
		   tag_title VARCHAR(250),
		   tag_title_clean VARCHAR(250),
	  	   tag_user_id INT
	  	   )")
		   or die(mysqli_error());
	}
	echo"
	<!-- //tags -->
	

	<!-- links -->
	";
	$query = "SELECT * FROM $t_recipes_links";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_links: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_links(
	  	 link_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(link_id), 
	  	   link_language VARCHAR(20),
	  	   link_recipe_id INT,
		   link_title VARCHAR(250),
		   link_url VARCHAR(250),
	  	   link_unique_click INT,
		   link_unique_click_ipblock TEXT,
	  	   link_user_id INT
	  	   )")
		   or die(mysqli_error());
	}
	echo"
	<!-- //links -->

	<!-- Comments -->
	";
	$query = "SELECT * FROM $t_recipes_comments";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_links: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_comments(
	  	 comment_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(comment_id), 
	  	   comment_recipe_id INT,
	  	   comment_language VARCHAR(20),
	  	   comment_approved INT,
		   comment_datetime DATETIME,
		   comment_time VARCHAR(200),
		   comment_date_print VARCHAR(200),
		   comment_user_id INT,
		   comment_user_alias VARCHAR(250),
		   comment_user_image_path VARCHAR(250),
		   comment_user_image_file VARCHAR(250),
		   comment_user_ip VARCHAR(250),
		   comment_user_hostname VARCHAR(250),
		   comment_user_agent VARCHAR(250),
		   comment_title VARCHAR(250),
		   comment_text TEXT, 
		   comment_rating INT, 
	  	   comment_helpful_clicks INT,
	  	   comment_useless_clicks INT,
	  	   comment_marked_as_spam INT,
		   comment_spam_checked INT,
		   comment_spam_checked_comment TEXT
	  	   )")
		   or die(mysqli_error());
	}
	echo"
	<!-- //Comments -->

	<!-- Searches -->
	";
	$query = "SELECT * FROM $t_recipes_searches";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_searches: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_searches(
	  	 search_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(search_id), 
	  	   search_query VARCHAR(20),
	  	   search_language VARCHAR(20),
	  	   search_unique_count INT,
	  	   search_unique_ip_block TEXT,
	  	   search_first_datetime DATETIME,
	  	   search_first_saying VARCHAR(100),
	  	   search_last_datetime DATETIME,
	  	   search_last_saying VARCHAR(100),
		   search_found_recipes INT
	  	   )")
		   or die(mysqli_error());
	}
	echo"
	<!-- //Searches -->


	<!-- recipes_age_restrictions -->
	";
	$query = "SELECT * FROM $t_recipes_age_restrictions";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_age_restrictions: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_age_restrictions (
	  	 restriction_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(restriction_id), 
	  	 restriction_country_iso VARCHAR(2),
	  	 restriction_country_name VARCHAR(250),
	  	 restriction_country_flag VARCHAR(250),
	  	 restriction_language VARCHAR(250),
	  	 restriction_age_limit INT,
	  	 restriction_title VARCHAR(250),
	  	 restriction_text VARCHAR(250),
	  	 restriction_can_view_recipe INT,
	  	 restriction_can_view_image INT)")
		   or die(mysqli_error());

		$query = "SELECT language_iso_two, language_flag FROM $t_languages";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_language_iso_two, $get_language_flag) = $row;

			
			$inp_country_iso = "$get_language_iso_two";
			$inp_country_iso_mysql = quote_smart($link, $inp_country_iso);

			$inp_country_name = "$get_language_flag";
			$inp_country_name = str_replace("_", " ", $inp_country_name);
			$inp_country_name = ucwords($inp_country_name);
			$inp_country_name_mysql = quote_smart($link, $inp_country_name);

			$inp_country_flag = "$get_language_flag";
			$inp_country_flag_mysql = quote_smart($link, $inp_country_flag);

			$inp_language = "$get_language_iso_two";
			$inp_language_mysql = quote_smart($link, $inp_language);

			$inp_title = "Age restriction";
			$inp_title_mysql = quote_smart($link, $inp_title);

			$inp_text = "This page can only be viewed by adults.";
			$inp_text_mysql = quote_smart($link, $inp_text);

			$inp_can_view_image = "1";
			$inp_can_view_image_mysql = quote_smart($link, $inp_can_view_image);
			

			// Check if country exists
			$query_search = "SELECT restriction_id FROM $t_recipes_age_restrictions WHERE restriction_country_name=$inp_country_name_mysql";
			$result_search = mysqli_query($link, $query_search);
			$row_search = mysqli_fetch_row($result_search);
			list($get_restriction_id) = $row_search;

			if($get_restriction_id == ""){
				mysqli_query($link, "INSERT INTO $t_recipes_age_restrictions 
				(restriction_id, restriction_country_iso, restriction_country_name, restriction_country_flag, restriction_language, restriction_age_limit, restriction_title, restriction_text,  restriction_can_view_recipe, restriction_can_view_image) 
				VALUES 
				(NULL, $inp_country_iso_mysql, $inp_country_name_mysql, $inp_country_flag_mysql, $inp_language_mysql, '21', $inp_title_mysql, $inp_text_mysql, '1', $inp_can_view_image_mysql)")
				or die(mysqli_error($link));
			}
		}

	}
	echo"
	<!-- //recipes_age_restrictions  -->


	<!-- recipes_age_restrictions_accepted -->
	";
	$query = "SELECT * FROM $t_recipes_age_restrictions_accepted";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_recipes_age_restrictions_accepted: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_recipes_age_restrictions_accepted(
	  	 accepted_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(accepted_id), 
	  	 accepted_ip VARCHAR(250),
	  	 accepted_year INT,
	  	 accepted_month INT,
	  	 accepted_country VARCHAR(250)
	  	   )")
		   or die(mysqli_error());

	}
	echo"
	<!-- //recipes_age_restrictions_accepted -->

	";




?>