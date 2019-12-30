<?php
/**
*
* File: _admin/_inc/calorie_counter/tables.php
* Version 11:55 30.12.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Functions ------------------------------------------------------------------------ */
function fix_utf($value){
	$value = str_replace("ÃƒÂ¸", "ø", $value);
	$value = str_replace("ÃƒÂ¥", "å", $value);

        return $value;
}
function fix_local($value){
	$value = htmlentities($value);

        return $value;
}
/*- Tables ---------------------------------------------------------------------------- */
$t_calorie_counter		  = $mysqlPrefixSav . "calorie_counter";

echo"
<h1>Tables</h1>


	<!-- diet_goal -->
	";

	
	$query = "SELECT * FROM $t_diet_goal";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_diet_goal: $row_cnt</p>
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

		
		<meta http-equiv=\"refresh\" content=\"2;url=index.php?open=$open&amp;page=tables\">
		";


		mysqli_query($link, "CREATE TABLE $t_diet_goal(
	  	 goal_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(goal_id), 
	  	   goal_user_id INT,
	  	   goal_current_weight INT,
	  	   goal_target_weight INT,
	  	   goal_i_want_to VARCHAR(50),
	  	   goal_weekly_goal VARCHAR(50),
	  	   goal_date DATE,
	  	   goal_activity_level INT,
	  	   goal_energy_bmr INT,
	  	   goal_proteins_bmr INT,
	  	   goal_carbs_bmr INT,
	  	   goal_fat_bmr INT,
	  	   goal_energy_diet INT,
	  	   goal_proteins_diet INT,
	  	   goal_carbs_diet INT,
	  	   goal_fat_diet INT,
	  	   goal_energy_with_activity INT,
	  	   goal_proteins_with_activity INT,
	  	   goal_carbs_with_activity INT,
	  	   goal_fat_with_activity INT,
	  	   goal_energy_with_activity_and_diet INT,
	  	   goal_proteins_with_activity_and_diet INT,
	  	   goal_carbs_with_activity_and_diet INT,
	  	   goal_fat_with_activity_and_diet INT,
	  	   goal_synchronized DATE,
	  	   goal_notes VARCHAR(50))")
		   or die(mysqli_error());

	}
	echo"
	<!-- //diet_goal -->

	
	<!-- diet_food_diary_cal_eaten -->
	";

	
	$query = "SELECT * FROM $t_diet_food_diary_cal_eaten";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_diet_food_diary_cal_eaten: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_diet_food_diary_cal_eaten(
	  	 fdce_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(fdce_id), 
	  	   fdce_user_id INT,
	  	   fdce_date DATE,
	  	   fdce_meal_no INT,
	  	   fdce_eaten_energy INT,
	  	   fdce_eaten_proteins INT,
	  	   fdce_eaten_carbs INT,
	  	   fdce_eaten_fat INT,
	  	   fdce_synchronized DATE)")
		   or die(mysqli_error());

	}
	echo"
	<!-- //diet_food_diary_cal_eaten -->


	<!-- diet_food_diary_sum -->
	";

	
	$query = "SELECT * FROM $t_diet_food_diary_sum";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_diet_food_diary_sum: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_diet_food_diary_sum(
	  	 food_diary_sum_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(food_diary_sum_id), 
	  	   food_diary_sum_user_id INT,
	  	   food_diary_sum_date DATE,
	  	   food_diary_sum_energy INT,
	  	   food_diary_sum_proteins INT,
	  	   food_diary_sum_carbs INT,
	  	   food_diary_sum_fat INT,
	  	   food_synchronized DATE)")
		   or die(mysqli_error());

	}
	echo"
	<!-- //diet_food_diary_sum -->

	<!-- diet_food_diary -->
	";

	
	$query = "SELECT * FROM $t_diet_food_diary";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_diet_food_diary: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_diet_food_diary(
	  	 fd_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(fd_id), 
	  	   fd_user_id INT,
	  	   fd_date DATE,
	  	   fd_meal_number INT,
	  	   fd_food_id INT,
	  	   fd_serving_size_gram DOUBLE,
	  	   fd_serving_size_gram_measurement VARCHAR(50),
	  	   fd_serving_size_pcs DOUBLE,
	  	   fd_serving_size_pcs_measurement VARCHAR(50),
	  	   fd_energy_calculated DOUBLE,
	  	   fd_protein_calculated DOUBLE,
	  	   fd_carbohydrates_calculated DOUBLE,
	  	   fd_fat_calculated DOUBLE,
	  	   fd_meal_id INT,
	  	   fd_synchronized DATE)")
		   or die(mysqli_error());

	}
	echo"
	<!-- //diet_food_diary -->
	

	<!-- diet_categories -->
	";

	
	$query = "SELECT * FROM $t_diet_categories";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_diet_categories: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_diet_categories(
	  	 category_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(category_id), 
	  	   category_user_id INT,
	  	   category_name VARCHAR(50),
	  	   category_age_restriction INT, 
	  	   category_parent_id INT,
	  	   category_icon VARCHAR(50),
	  	   category_last_updated DATETIME,
	  	   category_note VARCHAR(50))")
		   or print(mysqli_error());

		/*- Original --------------------------------------------------------------------------- */
		$language = "en";
		$category_parent_name[0] = "Bread and cereal";
		$category_sub_name[0][0] = "Bread";
		$category_sub_name[0][1] = "Cereals";
		$category_sub_name[0][2] = "Frozen bread and rolls";
		$category_sub_name[0][3] = "Crispbread";
		$category_sub_name[0][4] = "Sausage bread and lumps";

		$category_parent_name[1] = "Dessert and baking";
		$category_sub_name[1][0] = "Baking";
		$category_sub_name[1][1] = "Biscuit";
		$category_sub_name[1][2] = "Cakes";
		$category_sub_name[1][3] = "Buns";
		$category_sub_name[1][4] = "Ice cream";

		$category_parent_name[2] = "Drink";
		$category_sub_name[2][0] = "Soda";
		$category_sub_name[2][1] = "Water and mineral water";
		$category_sub_name[2][2] = "Juice";
		$category_sub_name[2][3] = "Smoothie";
		$category_sub_name[2][4] = "Lemonade";
		$category_sub_name[2][5] = "Coffee, tea and cocoa";
		$category_sub_name[2][6] = "Energy drink";

		$category_parent_name[12] = "Alcohol";
		$category_sub_name[12][0] = "Beer";
		$category_sub_name[12][1] = "Cider";
		$category_sub_name[12][2] = "Wine";
		$category_sub_name[12][3] = "Strong wine";
		$category_sub_name[12][4] = "Champagne";
		$category_sub_name[12][5] = "Liquor";
		$category_sub_name[12][6] = "Drink mix";
		$category_sub_name[12][7] = "Other drinks";

		$category_parent_name[3] = "Fruits and vegetables";
		$category_sub_name[3][0] = "Frozen fruits and vegetables";
		$category_sub_name[3][1] = "Fruit";
		$category_sub_name[3][2] = "Vegetables";
		$category_sub_name[3][3] = "Canned fruits and vegetables";
		$category_sub_name[3][4] = "Salads";

		$category_parent_name[4] = "Health";
		$category_sub_name[4][0] = "Protein bars";
		$category_sub_name[4][1] = "Protein powder";
		$category_sub_name[4][2] = "Meal substitutes";
		$category_sub_name[4][3] = "Other health products";

		$category_parent_name[5] = "Meat and chicken";
		$category_sub_name[5][0] = "Cattle and sheep";
		$category_sub_name[5][1] = "Pork and bacon";
		$category_sub_name[5][2] = "Chicken, turkey and duck";
		$category_sub_name[5][3] = "Meat replacement";
		$category_sub_name[5][4] = "Seafood";
		$category_sub_name[5][5] = "Dinner dishes and accessories";
		$category_sub_name[5][6] = "Pizza";
		$category_sub_name[5][7] = "Pasta, rice and noodle";
		$category_sub_name[5][8] = "Taco";
		$category_sub_name[5][9] = "Soups";
		$category_sub_name[5][10] = "Sauces";

		$category_parent_name[6] = "Dairy, cheese and eggs";
		$category_sub_name[6][0] = "Egg";
		$category_sub_name[6][1] = "Cream and sour cream";
		$category_sub_name[6][2] = "Yogurt";
		$category_sub_name[6][3] = "Milk";
		$category_sub_name[6][4] = "Butter and margarine";
		$category_sub_name[6][5] = "Cheese";

		$category_parent_name[7] = "Sandwich toppings";
		$category_sub_name[7][0] = "Meat and chicken toppings";
		$category_sub_name[7][1] = "Bacon and salami";
		$category_sub_name[7][2] = "Liver";
		$category_sub_name[7][3] = "Salad toppings";
		$category_sub_name[7][4] = "Fish spread";
		$category_sub_name[7][5] = "Sweet spreads";
		$category_sub_name[7][6] = "Mayonnaise";
		$category_sub_name[7][7] = "Tube spread";
		$category_sub_name[7][8] = "Cheese for sandwich";
		$category_sub_name[7][9] = "Other toppings";
		$category_sub_name[7][10] = "Jam";

		$category_parent_name[8] = "Snacks";
		$category_sub_name[8][0] = "Nuts";
		$category_sub_name[8][1] = "Potato chips";
		$category_sub_name[8][2] = "Chocolate";
		$category_sub_name[8][3] = "Sweets";
		$category_sub_name[8][4] = "Other snacks";

		$parent_size = sizeof($category_parent_name);
		$inp_category_id = 0;
		for($x=0;$x<$parent_size;$x++){
			// Count
			$inp_category_id = $inp_category_id+1;
			
			// Name
			$inp_name = $category_parent_name[$x];
			$inp_name = output_html($inp_name);
			$inp_name_mysql = quote_smart($link, $inp_name);

			if($inp_name != ""){
				mysqli_query($link, "INSERT INTO $t_diet_categories
				(category_id, category_user_id, category_name, category_parent_id) 
				VALUES 
				(NULL, '0', $inp_name_mysql, '0')") or die(mysqli_error($link));

				$query = "SELECT category_id FROM $t_diet_categories WHERE category_name='$category_parent_name[$x]'";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_category_id) = $row;

				echo"
				<p><b>$category_parent_name[$x]</b><br />
				";
				$sub_size = sizeof($category_sub_name[$x]);
				for($y=0;$y<$sub_size;$y++){
					$inp_category_id = $inp_category_id+1;
					$inp_name = $category_sub_name[$x][$y];
					$inp_name = output_html($inp_name);
					$inp_name_mysql = quote_smart($link, $inp_name);

					mysqli_query($link, "INSERT INTO $t_diet_categories
					(category_id, category_user_id, category_name, category_parent_id) 
					VALUES 
					($inp_category_id, '0', $inp_name_mysql, '$get_category_id')
					")
					or die(mysqli_error($link));

					echo"
					$inp_name<br />
					";
				}

			}

			echo"
			</p>
			";
		}
	}
	echo"
	<!-- //diet_categories -->

	<!-- Diet categories translations -->
	";
	$query = "SELECT * FROM $t_diet_categories_translations";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_diet_categories_translations: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_diet_categories_translations(
	  	category_translation_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(category_translation_id), 
	  	   category_id INT, 
	  	   category_translation_language VARCHAR(250), 
	  	   category_translation_value VARCHAR(250), 
	  	   category_translation_no_food INT, 
	  	   category_translation_last_updated DATETIME)")
		   or die(mysqli_error());
			
		// Create English translation file...
		if(!(is_dir("_translations/site/en/diet"))){
			mkdir("_translations/site/en/diet");
		}
		
$nettport_diet_categories_translations = array(
  array('category_translation_id' => '1','category_id' => '1','category_translation_language' => 'en','category_translation_value' => 'Bread and cereal','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '2','category_id' => '2','category_translation_language' => 'en','category_translation_value' => 'Bread','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '3','category_id' => '3','category_translation_language' => 'en','category_translation_value' => 'Cereals','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '4','category_id' => '4','category_translation_language' => 'en','category_translation_value' => 'Frozen bread and rolls','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '5','category_id' => '5','category_translation_language' => 'en','category_translation_value' => 'Crispbread','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '6','category_id' => '6','category_translation_language' => 'en','category_translation_value' => 'Sausage bread and lumps','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '7','category_id' => '7','category_translation_language' => 'en','category_translation_value' => 'Dessert and baking','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '8','category_id' => '8','category_translation_language' => 'en','category_translation_value' => 'Baking','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '9','category_id' => '9','category_translation_language' => 'en','category_translation_value' => 'Biscuit','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '10','category_id' => '10','category_translation_language' => 'en','category_translation_value' => 'Cakes','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '11','category_id' => '11','category_translation_language' => 'en','category_translation_value' => 'Buns','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '12','category_id' => '12','category_translation_language' => 'en','category_translation_value' => 'Ice cream','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '13','category_id' => '13','category_translation_language' => 'en','category_translation_value' => 'Drink','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '14','category_id' => '14','category_translation_language' => 'en','category_translation_value' => 'Soda','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '15','category_id' => '15','category_translation_language' => 'en','category_translation_value' => 'Water and mineral water','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '16','category_id' => '16','category_translation_language' => 'en','category_translation_value' => 'Juice','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '17','category_id' => '17','category_translation_language' => 'en','category_translation_value' => 'Smoothie','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '18','category_id' => '18','category_translation_language' => 'en','category_translation_value' => 'Lemonade','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '19','category_id' => '19','category_translation_language' => 'en','category_translation_value' => 'Coffee, tea and cocoa','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '20','category_id' => '20','category_translation_language' => 'en','category_translation_value' => 'Energy drink','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '21','category_id' => '21','category_translation_language' => 'en','category_translation_value' => 'Fruits and vegetables','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '22','category_id' => '22','category_translation_language' => 'en','category_translation_value' => 'Frozen fruits and vegetables','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '23','category_id' => '23','category_translation_language' => 'en','category_translation_value' => 'Fruit','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '24','category_id' => '24','category_translation_language' => 'en','category_translation_value' => 'Vegetables','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '25','category_id' => '25','category_translation_language' => 'en','category_translation_value' => 'Canned fruits and vegetables','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '26','category_id' => '26','category_translation_language' => 'en','category_translation_value' => 'Salads','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '27','category_id' => '27','category_translation_language' => 'en','category_translation_value' => 'Health','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '28','category_id' => '28','category_translation_language' => 'en','category_translation_value' => 'Protein bars','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '29','category_id' => '29','category_translation_language' => 'en','category_translation_value' => 'Protein powder','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '30','category_id' => '30','category_translation_language' => 'en','category_translation_value' => 'Meal substitutes','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '31','category_id' => '31','category_translation_language' => 'en','category_translation_value' => 'Other health products','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '32','category_id' => '32','category_translation_language' => 'en','category_translation_value' => 'Meat and chicken','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '33','category_id' => '33','category_translation_language' => 'en','category_translation_value' => 'Cattle and sheep','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '34','category_id' => '34','category_translation_language' => 'en','category_translation_value' => 'Pork and bacon','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '35','category_id' => '35','category_translation_language' => 'en','category_translation_value' => 'Chicken, turkey and duck','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '36','category_id' => '36','category_translation_language' => 'en','category_translation_value' => 'Meat replacement','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '37','category_id' => '37','category_translation_language' => 'en','category_translation_value' => 'Seafood','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '38','category_id' => '38','category_translation_language' => 'en','category_translation_value' => 'Dinner dishes and accessories','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '39','category_id' => '39','category_translation_language' => 'en','category_translation_value' => 'Pizza','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '40','category_id' => '40','category_translation_language' => 'en','category_translation_value' => 'Pasta, rice and noodle','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '41','category_id' => '41','category_translation_language' => 'en','category_translation_value' => 'Taco','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '42','category_id' => '42','category_translation_language' => 'en','category_translation_value' => 'Soups','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '43','category_id' => '43','category_translation_language' => 'en','category_translation_value' => 'Sauces','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '44','category_id' => '44','category_translation_language' => 'en','category_translation_value' => 'Dairy, cheese and eggs','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '45','category_id' => '45','category_translation_language' => 'en','category_translation_value' => 'Egg','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '46','category_id' => '46','category_translation_language' => 'en','category_translation_value' => 'Cream and sour cream','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '47','category_id' => '47','category_translation_language' => 'en','category_translation_value' => 'Yogurt','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '48','category_id' => '48','category_translation_language' => 'en','category_translation_value' => 'Milk','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '49','category_id' => '49','category_translation_language' => 'en','category_translation_value' => 'Butter and margarine','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '50','category_id' => '50','category_translation_language' => 'en','category_translation_value' => 'Cheese','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '51','category_id' => '51','category_translation_language' => 'en','category_translation_value' => 'Sandwich toppings','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '52','category_id' => '52','category_translation_language' => 'en','category_translation_value' => 'Meat and chicken toppings','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '53','category_id' => '53','category_translation_language' => 'en','category_translation_value' => 'Bacon and salami','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '54','category_id' => '54','category_translation_language' => 'en','category_translation_value' => 'Liver','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '55','category_id' => '55','category_translation_language' => 'en','category_translation_value' => 'Salad toppings','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '56','category_id' => '56','category_translation_language' => 'en','category_translation_value' => 'Fish spread','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '57','category_id' => '57','category_translation_language' => 'en','category_translation_value' => 'Sweet spreads','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '58','category_id' => '58','category_translation_language' => 'en','category_translation_value' => 'Mayonnaise','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '59','category_id' => '59','category_translation_language' => 'en','category_translation_value' => 'Tube spread','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '60','category_id' => '60','category_translation_language' => 'en','category_translation_value' => 'Cheese for sandwich','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '61','category_id' => '61','category_translation_language' => 'en','category_translation_value' => 'Other toppings','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '62','category_id' => '62','category_translation_language' => 'en','category_translation_value' => 'Jam','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '63','category_id' => '63','category_translation_language' => 'en','category_translation_value' => 'Snacks','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '64','category_id' => '64','category_translation_language' => 'en','category_translation_value' => 'Nuts','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '65','category_id' => '65','category_translation_language' => 'en','category_translation_value' => 'Potato chips','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '66','category_id' => '66','category_translation_language' => 'en','category_translation_value' => 'Chocolate','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '67','category_id' => '67','category_translation_language' => 'en','category_translation_value' => 'Sweets','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '68','category_id' => '68','category_translation_language' => 'en','category_translation_value' => 'Other snacks','category_translation_no_food' => '0','category_translation_last_updated' => '2018-01-03 16:04:04'),
  array('category_translation_id' => '69','category_id' => '1','category_translation_language' => 'no','category_translation_value' => 'BrÃƒÂ¸d og frokostblandinger','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '70','category_id' => '2','category_translation_language' => 'no','category_translation_value' => 'BrÃƒÂ¸d','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '71','category_id' => '3','category_translation_language' => 'no','category_translation_value' => 'Frokostblandinger','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '72','category_id' => '4','category_translation_language' => 'no','category_translation_value' => 'Frosset brÃƒÂ¸d og rundstykker','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '73','category_id' => '5','category_translation_language' => 'no','category_translation_value' => 'KnekkebrÃƒÂ¸d','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '74','category_id' => '6','category_translation_language' => 'no','category_translation_value' => 'PÃƒÂ¸lsebrÃƒÂ¸d og lomper','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '75','category_id' => '7','category_translation_language' => 'no','category_translation_value' => 'Dessert og baking','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '76','category_id' => '8','category_translation_language' => 'no','category_translation_value' => 'Baking','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '77','category_id' => '9','category_translation_language' => 'no','category_translation_value' => 'Kjeks','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '78','category_id' => '10','category_translation_language' => 'no','category_translation_value' => 'Kake','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '79','category_id' => '11','category_translation_language' => 'no','category_translation_value' => 'Boller','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '80','category_id' => '12','category_translation_language' => 'no','category_translation_value' => 'Iskrem','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '81','category_id' => '13','category_translation_language' => 'no','category_translation_value' => 'Drikke','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '82','category_id' => '14','category_translation_language' => 'no','category_translation_value' => 'Bruks','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '83','category_id' => '15','category_translation_language' => 'no','category_translation_value' => 'Mineralvann','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '84','category_id' => '16','category_translation_language' => 'no','category_translation_value' => 'Juice','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '85','category_id' => '17','category_translation_language' => 'no','category_translation_value' => 'Smoothie','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '86','category_id' => '18','category_translation_language' => 'no','category_translation_value' => 'Saft','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '87','category_id' => '19','category_translation_language' => 'no','category_translation_value' => 'Kaffe, te og kakao','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '88','category_id' => '20','category_translation_language' => 'no','category_translation_value' => 'Energidrikk','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '89','category_id' => '21','category_translation_language' => 'no','category_translation_value' => 'Frukt og grÃƒÂ¸nnsaker','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '90','category_id' => '22','category_translation_language' => 'no','category_translation_value' => 'Frosen frukt og grÃƒÂ¸nnsaker','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '91','category_id' => '23','category_translation_language' => 'no','category_translation_value' => 'Frukt','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '92','category_id' => '24','category_translation_language' => 'no','category_translation_value' => 'GrÃƒÂ¸nnsaker','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '93','category_id' => '25','category_translation_language' => 'no','category_translation_value' => 'Hermetisert frukt og grÃƒÂ¸nnsaker','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '94','category_id' => '26','category_translation_language' => 'no','category_translation_value' => 'Salater','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '95','category_id' => '27','category_translation_language' => 'no','category_translation_value' => 'Helse','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '96','category_id' => '28','category_translation_language' => 'no','category_translation_value' => 'Proteinbarer','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '97','category_id' => '29','category_translation_language' => 'no','category_translation_value' => 'Proteinpulver','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '98','category_id' => '30','category_translation_language' => 'no','category_translation_value' => 'MÃƒÂ¥ltidserstattere','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '99','category_id' => '31','category_translation_language' => 'no','category_translation_value' => 'Andre helseprodukter','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '100','category_id' => '32','category_translation_language' => 'no','category_translation_value' => 'KjÃƒÂ¸tt og kylling','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '101','category_id' => '33','category_translation_language' => 'no','category_translation_value' => 'Storfe og sau','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '102','category_id' => '34','category_translation_language' => 'no','category_translation_value' => 'Svin og bacon','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '103','category_id' => '35','category_translation_language' => 'no','category_translation_value' => 'Kylling, kalkun og and','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '104','category_id' => '36','category_translation_language' => 'no','category_translation_value' => 'KjÃƒÂ¸tterstatning','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '105','category_id' => '37','category_translation_language' => 'no','category_translation_value' => 'SjÃƒÂ¸mat','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '106','category_id' => '38','category_translation_language' => 'no','category_translation_value' => 'Middag og tilbehÃƒÂ¸r','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '107','category_id' => '39','category_translation_language' => 'no','category_translation_value' => 'Pizza','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '108','category_id' => '40','category_translation_language' => 'no','category_translation_value' => 'Pasta, ris og nudler','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '109','category_id' => '41','category_translation_language' => 'no','category_translation_value' => 'Taco','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '110','category_id' => '42','category_translation_language' => 'no','category_translation_value' => 'Supper','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '111','category_id' => '43','category_translation_language' => 'no','category_translation_value' => 'Sauser','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '112','category_id' => '44','category_translation_language' => 'no','category_translation_value' => 'Meieri, ost og egg','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '113','category_id' => '45','category_translation_language' => 'no','category_translation_value' => 'Egg','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '114','category_id' => '46','category_translation_language' => 'no','category_translation_value' => 'Krem og rÃƒÂ¸mme','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '115','category_id' => '47','category_translation_language' => 'no','category_translation_value' => 'Yogurt','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '116','category_id' => '48','category_translation_language' => 'no','category_translation_value' => 'Melk','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '117','category_id' => '49','category_translation_language' => 'no','category_translation_value' => 'SmÃƒÂ¸r og margarin','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '118','category_id' => '50','category_translation_language' => 'no','category_translation_value' => 'Ost','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '119','category_id' => '51','category_translation_language' => 'no','category_translation_value' => 'PÃƒÂ¥legg','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '120','category_id' => '52','category_translation_language' => 'no','category_translation_value' => 'KjÃƒÂ¸tt- og kyllingpÃƒÂ¥legg','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '121','category_id' => '53','category_translation_language' => 'no','category_translation_value' => 'Bacon og salami','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '122','category_id' => '54','category_translation_language' => 'no','category_translation_value' => 'Lever','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '123','category_id' => '55','category_translation_language' => 'no','category_translation_value' => 'SalatpÃƒÂ¥legg','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '124','category_id' => '56','category_translation_language' => 'no','category_translation_value' => 'FiskepÃƒÂ¥legg','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '125','category_id' => '57','category_translation_language' => 'no','category_translation_value' => 'SÃƒÂ¸tpÃƒÂ¥legg','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '126','category_id' => '58','category_translation_language' => 'no','category_translation_value' => 'Majones','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '127','category_id' => '59','category_translation_language' => 'no','category_translation_value' => 'TubepÃƒÂ¥legg','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '128','category_id' => '60','category_translation_language' => 'no','category_translation_value' => 'Ost','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '129','category_id' => '61','category_translation_language' => 'no','category_translation_value' => 'Annet','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '130','category_id' => '62','category_translation_language' => 'no','category_translation_value' => 'SyltetÃƒÂ¸y','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '131','category_id' => '63','category_translation_language' => 'no','category_translation_value' => 'Snacks','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '132','category_id' => '64','category_translation_language' => 'no','category_translation_value' => 'NÃƒÂ¸tter','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '133','category_id' => '65','category_translation_language' => 'no','category_translation_value' => 'Potetgull','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '134','category_id' => '66','category_translation_language' => 'no','category_translation_value' => 'Sjokolade','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '135','category_id' => '67','category_translation_language' => 'no','category_translation_value' => 'SÃƒÂ¸tsaker','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL),
  array('category_translation_id' => '136','category_id' => '68','category_translation_language' => 'no','category_translation_value' => 'Annet','category_translation_no_food' => NULL,'category_translation_last_updated' => NULL)
);




		$inp_category_translation_last_updated = date("Y-m-d H:i:s");
		foreach($nettport_diet_categories_translations as $v){
			
			$category_id = $v["category_id"];
			$category_translation_language = $v["category_translation_language"];
			$category_translation_value = $v["category_translation_value"];
		
			mysqli_query($link, "INSERT INTO $t_diet_categories_translations
			(category_translation_id, category_id, category_translation_language, category_translation_value, category_translation_no_food, category_translation_last_updated) 
			VALUES 
			(NULL, '$category_id', '$category_translation_language', '$category_translation_value', '0', '$inp_category_translation_last_updated')
			")
			or die(mysqli_error($link));


		}
	}

	echo"
	<!-- //Diet categories translations -->
	

	<!-- diet_food -->
	";

	
	$query = "SELECT * FROM $t_diet_food";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_diet_food: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_diet_food(
	  	 food_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(food_id), 
	  	   food_user_id INT,
		   food_name VARCHAR(250),
		   food_clean_name VARCHAR(250),
	  	   food_manufacturer_name VARCHAR(250),
	  	   food_store VARCHAR(50),
	  	   food_description VARCHAR(250),
	  	   food_serving_size_gram DOUBLE,
	  	   food_serving_size_gram_measurement VARCHAR(50),
	  	   food_serving_size_pcs DOUBLE,
	  	   food_serving_size_pcs_measurement VARCHAR(50),
	  	   food_energy DOUBLE,
	  	   food_proteins DOUBLE,
	  	   food_carbohydrates DOUBLE,
	  	   food_fat DOUBLE,
	  	   food_energy_calculated DOUBLE,
	  	   food_proteins_calculated DOUBLE,
	  	   food_carbohydrates_calculated DOUBLE,
	  	   food_fat_calculated DOUBLE,
	  	   food_barcode VARCHAR(50),
	  	   food_category_id INT,
	  	   food_image_path VARCHAR(200),
	  	   food_thumb VARCHAR(250),
	  	   food_image_a VARCHAR(250),
	  	   food_image_b VARCHAR(250),
	  	   food_image_c VARCHAR(250),
	  	   food_image_d VARCHAR(250),
	  	   food_image_e VARCHAR(250),
	  	   food_last_used DATE,
	  	   food_language VARCHAR(50),
	  	   food_synchronized DATE,
	  	   food_accepted_as_master INT,
	  	   food_notes TEXT,
	  	   food_unique_hits INT,
	  	   food_unique_hits_ip_block TEXT,
	  	   food_comments INT,
	  	   food_likes INT,
	  	   food_dislikes INT,
	  	   food_likes_ip_block TEXT,
		   food_user_ip VARCHAR(250),
	  	   food_date DATE,
	  	   food_time TIME)")
		   or die(mysqli_error());


		// Norwegian
		$stram_diet_food = array(
  array('food_id' => '1','food_user_id' => '0','food_name' => 'Speltlompe med havre','food_clean_name' => 'speltlompe_med_havre','food_manufacturer_name' => 'Aulie','food_store' => '','food_description' => '','food_serving_size_gram' => '26','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '122','food_proteins' => '3.5','food_carbohydrates' => '23.4','food_fat' => '1','food_energy_calculated' => '32','food_proteins_calculated' => '1','food_carbohydrates_calculated' => '6','food_fat_calculated' => '0','food_barcode' => '','food_category_id' => '6','food_image_path' => '_uploads/food/_img/no/2018/aulie_speltlompe_med_havre','food_thumb' => '1_thumb.png','food_image_a' => '1_a.png','food_image_b' => '1_b.png','food_image_c' => 'aulie_speltlomper_med_havre_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '2','food_user_id' => '0','food_name' => 'Havregryn lettkokt','food_clean_name' => 'havregryn_lettkokt','food_manufacturer_name' => 'Axa','food_store' => '','food_description' => '','food_serving_size_gram' => '60','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '60','food_serving_size_pcs_measurement' => 'g','food_energy' => '389','food_proteins' => '11.4','food_carbohydrates' => '63.1','food_fat' => '7.8','food_energy_calculated' => '233','food_proteins_calculated' => '7','food_carbohydrates_calculated' => '38','food_fat_calculated' => '5','food_barcode' => '7044416013141','food_category_id' => '3','food_image_path' => '_uploads/food/_img/no/18/2','food_thumb' => 'axa_havregryn_lettkokt_thumb.png','food_image_a' => 'axa_havregryn_lettkokt_a.png','food_image_b' => 'axa_havregryn_lettkokt_b.png','food_image_c' => 'axa_havregryn_lettkokt_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '3','food_user_id' => '0','food_name' => 'Havregryn store','food_clean_name' => 'havregryn_store','food_manufacturer_name' => 'Axa','food_store' => '','food_description' => '','food_serving_size_gram' => '80','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '80','food_serving_size_pcs_measurement' => 'g','food_energy' => '380','food_proteins' => '13','food_carbohydrates' => '61','food_fat' => '7','food_energy_calculated' => '304','food_proteins_calculated' => '10','food_carbohydrates_calculated' => '49','food_fat_calculated' => '6','food_barcode' => '7044416012533','food_category_id' => '3','food_image_path' => '_uploads/food/_img/no/18/3','food_thumb' => 'axa_havregryn_store_thumb.png','food_image_a' => 'axa_havregryn_store_a.png','food_image_b' => 'axa_havregryn_store_b.png','food_image_c' => 'axa_havregryn_store_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '4','food_user_id' => '0','food_name' => 'Frosne pitapr?d','food_clean_name' => NULL,'food_manufacturer_name' => 'Hatting','food_store' => NULL,'food_description' => NULL,'food_serving_size_gram' => '80','food_serving_size_gram_measurement' => 'gram','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '251','food_proteins' => '8.1','food_carbohydrates' => '50','food_fat' => '1.5','food_energy_calculated' => '201','food_proteins_calculated' => '6','food_carbohydrates_calculated' => '40','food_fat_calculated' => '1','food_barcode' => NULL,'food_category_id' => '4','food_image_path' => NULL,'food_thumb' => 'hatting_frosne_pitabrod_thumb.jpg','food_image_a' => 'hatting_frosne_pitabrod_a.jpg','food_image_b' => 'hatting_frosne_pitabrod_b.jpg','food_image_c' => 'hatting_frosne_pitabrod_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '5','food_user_id' => '0','food_name' => 'Frosne ekstra grove rundstykker','food_clean_name' => NULL,'food_manufacturer_name' => 'Hvita hjertegod','food_store' => NULL,'food_description' => NULL,'food_serving_size_gram' => '70','food_serving_size_gram_measurement' => 'gram','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '250','food_proteins' => '18','food_carbohydrates' => '25','food_fat' => '6','food_energy_calculated' => '175','food_proteins_calculated' => '13','food_carbohydrates_calculated' => '18','food_fat_calculated' => '4','food_barcode' => NULL,'food_category_id' => '4','food_image_path' => NULL,'food_thumb' => 'hvita_hjertegod_frosne_ekstra_grove_rundstykker_thumb.jpg','food_image_a' => 'hvita_hjertegod_frosne_ekstra_grove_rundstykker_a.jpg','food_image_b' => 'hvita_hjertegod_frosne_ekstra_grove_rundstykker_b.jpg','food_image_c' => 'hvita_hjertegod_frosne_ekstra_grove_rundstykker_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '6','food_user_id' => '0','food_name' => 'Steinovnsbakte solsikkebriks','food_clean_name' => NULL,'food_manufacturer_name' => 'Rema 1000','food_store' => NULL,'food_description' => NULL,'food_serving_size_gram' => '60','food_serving_size_gram_measurement' => 'gram','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '260','food_proteins' => '10','food_carbohydrates' => '39','food_fat' => '0.5','food_energy_calculated' => '156','food_proteins_calculated' => '6','food_carbohydrates_calculated' => '23','food_fat_calculated' => '0','food_barcode' => NULL,'food_category_id' => '4','food_image_path' => NULL,'food_thumb' => 'rema_1000_steinovnsbakte_solsikkebriks_thumb.jpg','food_image_a' => 'rema_1000_steinovnsbakte_solsikkebriks_a.jpg','food_image_b' => 'rema_1000_steinovnsbakte_solsikkebriks_b.jpg','food_image_c' => 'rema_1000_steinovnsbakte_solsikkebriks_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '7','food_user_id' => '0','food_name' => 'Fiber Balance','food_clean_name' => 'fiber_balance','food_manufacturer_name' => 'Wasa','food_store' => '','food_description' => '','food_serving_size_gram' => '10','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '330','food_proteins' => '14','food_carbohydrates' => '43','food_fat' => '5.5','food_energy_calculated' => '33','food_proteins_calculated' => '1','food_carbohydrates_calculated' => '4','food_fat_calculated' => '1','food_barcode' => '','food_category_id' => '5','food_image_path' => '_uploads/food/_img/no/18/7','food_thumb' => '7_thumb.png','food_image_a' => '7_a.png','food_image_b' => '7_b.png','food_image_c' => 'wasa_fiber_balance_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '8','food_user_id' => '0','food_name' => 'Sport +','food_clean_name' => 'sport__','food_manufacturer_name' => 'Wasa','food_store' => '','food_description' => '','food_serving_size_gram' => '16','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '338','food_proteins' => '10.5','food_carbohydrates' => '55.5','food_fat' => '3.5','food_energy_calculated' => '54','food_proteins_calculated' => '2','food_carbohydrates_calculated' => '9','food_fat_calculated' => '1','food_barcode' => '','food_category_id' => '5','food_image_path' => '_uploads/food/_img/no/2018/sport__','food_thumb' => '8_thumb.png','food_image_a' => '8_a.png','food_image_b' => '8_b.png','food_image_c' => 'wasa_sport_pluss_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '9','food_user_id' => '0','food_name' => 'Sukker','food_clean_name' => 'sukker','food_manufacturer_name' => 'Dan Sukker','food_store' => '','food_description' => '','food_serving_size_gram' => '100','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '100','food_serving_size_pcs_measurement' => 'pose','food_energy' => '400','food_proteins' => '0','food_carbohydrates' => '100','food_fat' => '0','food_energy_calculated' => '400','food_proteins_calculated' => '0','food_carbohydrates_calculated' => '100','food_fat_calculated' => '0','food_barcode' => '','food_category_id' => '8','food_image_path' => '_uploads/food/_img/no/2018/dan_sukker_sukker','food_thumb' => '9_thumb.png','food_image_a' => '9_a.png','food_image_b' => '9_b.png','food_image_c' => 'dan_sukker_sukker_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '10','food_user_id' => '0','food_name' => 'Siktet hvetemel','food_clean_name' => 'siktet_hvetemel','food_manufacturer_name' => 'Møllerens','food_store' => '','food_description' => '','food_serving_size_gram' => '100','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '100','food_serving_size_pcs_measurement' => 'pose','food_energy' => '341','food_proteins' => '10.2','food_carbohydrates' => '69.6','food_fat' => '1.6','food_energy_calculated' => '341','food_proteins_calculated' => '10','food_carbohydrates_calculated' => '70','food_fat_calculated' => '2','food_barcode' => '','food_category_id' => '8','food_image_path' => '_uploads/food/_img/no/2018/mllerens_siktet_hvetemel','food_thumb' => '10_thumb.png','food_image_a' => '10_a.png','food_image_b' => '10_b.png','food_image_c' => 'moollerens_siktet_hvetemel_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '11','food_user_id' => '0','food_name' => 'Ritz Crackers','food_clean_name' => 'ritz_crackers','food_manufacturer_name' => 'Mondelez Norge','food_store' => '','food_description' => '','food_serving_size_gram' => '200','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'pakke','food_energy' => '490','food_proteins' => '7.8','food_carbohydrates' => '61','food_fat' => '23','food_energy_calculated' => '980','food_proteins_calculated' => '16','food_carbohydrates_calculated' => '122','food_fat_calculated' => '46','food_barcode' => '','food_category_id' => '9','food_image_path' => '_uploads/food/_img/no/2018/mondelez_norge_ritz_crackers','food_thumb' => '11_thumb.png','food_image_a' => '11_a.png','food_image_b' => '11_b.png','food_image_c' => 'mondelez_norge_ritz_crackers_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '12','food_user_id' => '0','food_name' => 'Battery Energy Drink 50cl','food_clean_name' => 'battery_energy_drink_50cl','food_manufacturer_name' => 'Ringnes','food_store' => 'Meny','food_description' => '','food_serving_size_gram' => '500','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'boks','food_energy' => '50','food_proteins' => '0.4','food_carbohydrates' => '11.5','food_fat' => '0','food_energy_calculated' => '250','food_proteins_calculated' => '2','food_carbohydrates_calculated' => '58','food_fat_calculated' => '0','food_barcode' => '7044610806228','food_category_id' => '20','food_image_path' => '_uploads/food/_img/no/2018/battery_energy_drink_50cl','food_thumb' => 'ringnes_battery_energy_drink_50cl_thumb.png','food_image_a' => 'ringnes_battery_energy_drink_50cl_a.png','food_image_b' => 'ringnes_battery_energy_drink_50cl_b.png','food_image_c' => 'ringnes_battery_energy_drink_50cl_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '13','food_user_id' => '0','food_name' => 'Frossen brokkoliblanding','food_clean_name' => 'frossen_brokkoliblanding','food_manufacturer_name' => 'First Price','food_store' => '','food_description' => '','food_serving_size_gram' => '250','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '0.5','food_serving_size_pcs_measurement' => 'pose','food_energy' => '25','food_proteins' => '1.9','food_carbohydrates' => '2.7','food_fat' => '0.2','food_energy_calculated' => '63','food_proteins_calculated' => '5','food_carbohydrates_calculated' => '7','food_fat_calculated' => '1','food_barcode' => '7035620020278','food_category_id' => '22','food_image_path' => '_uploads/food/_img/no/2018/first_price_frossen_brokkoliblanding','food_thumb' => 'first_price_frossen_brokkoliblanding_thumb.png','food_image_a' => 'first_price_frossen_brokkoliblanding_a.png','food_image_b' => 'first_price_frossen_brokkoliblanding_b.png','food_image_c' => 'eldorado_frossen_brokkoliblanding_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '14','food_user_id' => '0','food_name' => 'Fosne brokkolitopper','food_clean_name' => NULL,'food_manufacturer_name' => 'Rema 1000','food_store' => NULL,'food_description' => NULL,'food_serving_size_gram' => '225','food_serving_size_gram_measurement' => 'gram','food_serving_size_pcs' => '0.5','food_serving_size_pcs_measurement' => 'pose','food_energy' => '27','food_proteins' => '2.8','food_carbohydrates' => '1.9','food_fat' => '0.5','food_energy_calculated' => '61','food_proteins_calculated' => '6','food_carbohydrates_calculated' => '4','food_fat_calculated' => '1','food_barcode' => NULL,'food_category_id' => '22','food_image_path' => NULL,'food_thumb' => 'rema_1000_frosne_brokkolitopper_thumb.jpg','food_image_a' => 'rema_1000_frosne_brokkolitopper_a.jpg','food_image_b' => 'rema_1000_frosne_brokkolitopper_b.jpg','food_image_c' => 'rema_1000_frosne_brokkolitopper_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '15','food_user_id' => '0','food_name' => 'R?de druer','food_clean_name' => NULL,'food_manufacturer_name' => 'Bama','food_store' => NULL,'food_description' => NULL,'food_serving_size_gram' => '200','food_serving_size_gram_measurement' => 'gram','food_serving_size_pcs' => '0.5','food_serving_size_pcs_measurement' => 'pakke','food_energy' => '62','food_proteins' => '0.7','food_carbohydrates' => '13.8','food_fat' => '0.2','food_energy_calculated' => '124','food_proteins_calculated' => '1','food_carbohydrates_calculated' => '28','food_fat_calculated' => '0','food_barcode' => NULL,'food_category_id' => '23','food_image_path' => NULL,'food_thumb' => 'bama_rode_druer_thumb.jpg','food_image_a' => 'bama_rode_druer_a.jpg','food_image_b' => 'bama_rode_druer_b.jpg','food_image_c' => 'bama_rode_druer_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '16','food_user_id' => '0','food_name' => 'Brokkoli','food_clean_name' => NULL,'food_manufacturer_name' => 'Bama','food_store' => NULL,'food_description' => NULL,'food_serving_size_gram' => '300','food_serving_size_gram_measurement' => 'gram','food_serving_size_pcs' => '0.5','food_serving_size_pcs_measurement' => 'stk','food_energy' => '33','food_proteins' => '2.8','food_carbohydrates' => '7','food_fat' => '0.4','food_energy_calculated' => '99','food_proteins_calculated' => '8','food_carbohydrates_calculated' => '21','food_fat_calculated' => '1','food_barcode' => NULL,'food_category_id' => '24','food_image_path' => NULL,'food_thumb' => 'bama_brokkoli_thumb.jpg','food_image_a' => 'bama_brokkoli_a.jpg','food_image_b' => 'bama_brokkoli_b.jpg','food_image_c' => 'bama_brokkoli_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '17','food_user_id' => '0','food_name' => 'Gulrot','food_clean_name' => NULL,'food_manufacturer_name' => 'Bama','food_store' => NULL,'food_description' => NULL,'food_serving_size_gram' => '44','food_serving_size_gram_measurement' => 'gram','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '41','food_proteins' => '0.9','food_carbohydrates' => '10','food_fat' => '0.2','food_energy_calculated' => '18','food_proteins_calculated' => '0','food_carbohydrates_calculated' => '4','food_fat_calculated' => '0','food_barcode' => NULL,'food_category_id' => '24','food_image_path' => NULL,'food_thumb' => 'bama_gulrot_thumb.jpg','food_image_a' => 'bama_gulrot_a.jpg','food_image_b' => 'bama_gulrot_b.jpg','food_image_c' => 'bama_gulrot_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '18','food_user_id' => '0','food_name' => 'Isberg mix','food_clean_name' => 'isberg_mix','food_manufacturer_name' => 'Bama','food_store' => '','food_description' => '','food_serving_size_gram' => '125','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '0.5','food_serving_size_pcs_measurement' => 'pakke','food_energy' => '14','food_proteins' => '0.8','food_carbohydrates' => '2.2','food_fat' => '0.1','food_energy_calculated' => '18','food_proteins_calculated' => '1','food_carbohydrates_calculated' => '3','food_fat_calculated' => '0','food_barcode' => '','food_category_id' => '26','food_image_path' => '_uploads/food/_img/no/2018/bama_isberg_mix','food_thumb' => '18_thumb.png','food_image_a' => '18_a.png','food_image_b' => '18_b.png','food_image_c' => 'bama_isberg_mix_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '19','food_user_id' => '0','food_name' => 'Isbergsalat','food_clean_name' => NULL,'food_manufacturer_name' => 'Bama','food_store' => NULL,'food_description' => NULL,'food_serving_size_gram' => '50','food_serving_size_gram_measurement' => 'gram','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'neve','food_energy' => '12','food_proteins' => '0.8','food_carbohydrates' => '1.5','food_fat' => '0.1','food_energy_calculated' => '6','food_proteins_calculated' => '0','food_carbohydrates_calculated' => '1','food_fat_calculated' => '0','food_barcode' => NULL,'food_category_id' => '26','food_image_path' => NULL,'food_thumb' => 'bama_isbergsalat_thumb.jpg','food_image_a' => 'bama_isbergsalat_a.jpg','food_image_b' => 'bama_isbergsalat_b.jpg','food_image_c' => 'bama_isbergsalat_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '20','food_user_id' => '0','food_name' => 'Meksikansk salat','food_clean_name' => 'meksikansk_salat','food_manufacturer_name' => 'Bama','food_store' => '','food_description' => '','food_serving_size_gram' => '135','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '0.5','food_serving_size_pcs_measurement' => 'pakke','food_energy' => '140','food_proteins' => '3','food_carbohydrates' => '3.1','food_fat' => '11.2','food_energy_calculated' => '189','food_proteins_calculated' => '4','food_carbohydrates_calculated' => '4','food_fat_calculated' => '15','food_barcode' => '7023026084109','food_category_id' => '26','food_image_path' => '_uploads/food/_img/no/2018/bama_meksikansk_salat','food_thumb' => '20_thumb.png','food_image_a' => '20_a.png','food_image_b' => '20_b.png','food_image_c' => 'bama_meksikansk_salat_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '21','food_user_id' => '0','food_name' => 'R?d paprika','food_clean_name' => NULL,'food_manufacturer_name' => 'Bama','food_store' => NULL,'food_description' => NULL,'food_serving_size_gram' => '36','food_serving_size_gram_measurement' => 'gram','food_serving_size_pcs' => '0.25','food_serving_size_pcs_measurement' => 'stk','food_energy' => '30','food_proteins' => '1','food_carbohydrates' => '4.7','food_fat' => '0.4','food_energy_calculated' => '11','food_proteins_calculated' => '0','food_carbohydrates_calculated' => '2','food_fat_calculated' => '0','food_barcode' => NULL,'food_category_id' => '24','food_image_path' => NULL,'food_thumb' => 'bama_rod_paprika_thumb.jpg','food_image_a' => 'bama_rod_paprika_a.jpg','food_image_b' => 'bama_rod_paprika_b.jpg','food_image_c' => 'bama_rod_paprika_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '22','food_user_id' => '0','food_name' => 'Romano mix','food_clean_name' => 'romano_mix','food_manufacturer_name' => 'Bama','food_store' => '','food_description' => '','food_serving_size_gram' => '88','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '0.5','food_serving_size_pcs_measurement' => 'pakke','food_energy' => '13','food_proteins' => '1.3','food_carbohydrates' => '1.6','food_fat' => '0.2','food_energy_calculated' => '11','food_proteins_calculated' => '1','food_carbohydrates_calculated' => '1','food_fat_calculated' => '0','food_barcode' => '','food_category_id' => '26','food_image_path' => '_uploads/food/_img/no/2018/bama_romano_mix','food_thumb' => '22_thumb.png','food_image_a' => '22_a.png','food_image_b' => '22_b.png','food_image_c' => 'bama_romano_mix_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '23','food_user_id' => '0','food_name' => 'Baked beans','food_clean_name' => 'baked_beans','food_manufacturer_name' => 'Coop','food_store' => '','food_description' => '','food_serving_size_gram' => '420','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'boks','food_energy' => '116','food_proteins' => '5','food_carbohydrates' => '19','food_fat' => '0.5','food_energy_calculated' => '487','food_proteins_calculated' => '21','food_carbohydrates_calculated' => '80','food_fat_calculated' => '2','food_barcode' => '','food_category_id' => '25','food_image_path' => '_uploads/food/_img/no/2018/coop_baked_beans','food_thumb' => '23_thumb.png','food_image_a' => '23_a.png','food_image_b' => '23_b.png','food_image_c' => 'coop_baked_beans_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '24','food_user_id' => '0','food_name' => 'Kokosmelk','food_clean_name' => 'kokosmelk','food_manufacturer_name' => 'Eldorado','food_store' => 'Kiwi','food_description' => '','food_serving_size_gram' => '60','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '0.25','food_serving_size_pcs_measurement' => 'boks','food_energy' => '68','food_proteins' => '0.8','food_carbohydrates' => '3.3','food_fat' => '5.7','food_energy_calculated' => '41','food_proteins_calculated' => '0','food_carbohydrates_calculated' => '2','food_fat_calculated' => '3','food_barcode' => '7311041048733','food_category_id' => '25','food_image_path' => '_uploads/food/_img/no/2018/kokosmelk','food_thumb' => 'eldorado_kokosmelk_thumb.png','food_image_a' => 'eldorado_kokosmelk_a.png','food_image_b' => 'eldorado_kokosmelk_b.png','food_image_c' => 'eldorado_kokosmelk_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '26','food_user_id' => '0','food_name' => 'Maiskorn','food_clean_name' => 'maiskorn','food_manufacturer_name' => 'Eldorado','food_store' => 'Kiwi','food_description' => '','food_serving_size_gram' => '99','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '0.5','food_serving_size_pcs_measurement' => 'boks','food_energy' => '76','food_proteins' => '2.3','food_carbohydrates' => '14','food_fat' => '1','food_energy_calculated' => '75','food_proteins_calculated' => '2','food_carbohydrates_calculated' => '14','food_fat_calculated' => '1','food_barcode' => '7311041000663','food_category_id' => '25','food_image_path' => '_uploads/food/_img/no/2018/maiskorn','food_thumb' => 'eldorado_maiskorn_thumb.png','food_image_a' => 'eldorado_maiskorn_a.png','food_image_b' => 'eldorado_maiskorn_b.png','food_image_c' => 'eldorado_maiskorn_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '27','food_user_id' => '0','food_name' => 'Tomatbønner','food_clean_name' => 'tomatbonner','food_manufacturer_name' => 'Nora','food_store' => 'Meny','food_description' => '','food_serving_size_gram' => '420','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'boks','food_energy' => '83','food_proteins' => '3.8','food_carbohydrates' => '14','food_fat' => '0.6','food_energy_calculated' => '349','food_proteins_calculated' => '16','food_carbohydrates_calculated' => '59','food_fat_calculated' => '3','food_barcode' => '7039010012980','food_category_id' => '25','food_image_path' => '_uploads/food/_img/no/2018/tomatbnner','food_thumb' => 'nora_tomatbonner_thumb.png','food_image_a' => 'nora_tomatbonner_a.png','food_image_b' => 'nora_tomatbonner_b.png','food_image_c' => 'nora_tomatboonner_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '28','food_user_id' => '0','food_name' => 'Bønner i tomatsaus','food_clean_name' => 'bnner_i_tomatsaus','food_manufacturer_name' => 'Rema 1000','food_store' => 'Rema 1000','food_description' => '','food_serving_size_gram' => '420','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'boks','food_energy' => '95','food_proteins' => '5.3','food_carbohydrates' => '15','food_fat' => '0.6','food_energy_calculated' => '399','food_proteins_calculated' => '22','food_carbohydrates_calculated' => '63','food_fat_calculated' => '3','food_barcode' => '','food_category_id' => '25','food_image_path' => '_uploads/food/_img/no/2018/rema_1000_bnner_i_tomatsaus','food_thumb' => '28_thumb.png','food_image_a' => '28_a.png','food_image_b' => '28_b.png','food_image_c' => 'rema_1000_boonner_i_tomatsaus_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '29','food_user_id' => '0','food_name' => 'Power Meal Bringebærsmak','food_clean_name' => 'power_meal_bringebaersmak','food_manufacturer_name' => 'Strongr','food_store' => '','food_description' => '','food_serving_size_gram' => '80','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'skje','food_energy' => '396','food_proteins' => '37.5','food_carbohydrates' => '39.5','food_fat' => '9.6','food_energy_calculated' => '317','food_proteins_calculated' => '30','food_carbohydrates_calculated' => '32','food_fat_calculated' => '8','food_barcode' => '','food_category_id' => '29','food_image_path' => '_uploads/food/_img/no/2018/strongr_power_meal_bringebrsmak','food_thumb' => 'strongr_power_meal_thumb.jpg','food_image_a' => 'strongr_power_meal_a.jpg','food_image_b' => 'strongr_power_meal_b.jpg','food_image_c' => 'strongr_power_meal_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '30','food_user_id' => '0','food_name' => 'Pure Protein Meal Sjokoladesmak','food_clean_name' => NULL,'food_manufacturer_name' => 'Strongr','food_store' => NULL,'food_description' => NULL,'food_serving_size_gram' => '70','food_serving_size_gram_measurement' => 'gram','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'skje','food_energy' => '382','food_proteins' => '43.3','food_carbohydrates' => '43.2','food_fat' => '4.8','food_energy_calculated' => '267','food_proteins_calculated' => '30','food_carbohydrates_calculated' => '30','food_fat_calculated' => '3','food_barcode' => NULL,'food_category_id' => '29','food_image_path' => NULL,'food_thumb' => 'strongr_pure_protein_meal_sjokoladesmak_thumb.jpg','food_image_a' => 'strongr_pure_protein_meal_sjokoladesmak_a.jpg','food_image_b' => 'strongr_pure_protein_meal_sjokoladesmak_b.jpg','food_image_c' => 'strongr_pure_protein_meal_sjokoladesmak_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '31','food_user_id' => '0','food_name' => 'MealTech','food_clean_name' => NULL,'food_manufacturer_name' => 'Tech Nutrition','food_store' => NULL,'food_description' => NULL,'food_serving_size_gram' => '80','food_serving_size_gram_measurement' => 'gram','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'skje','food_energy' => '403','food_proteins' => '49.5','food_carbohydrates' => '28','food_fat' => '9','food_energy_calculated' => '322','food_proteins_calculated' => '40','food_carbohydrates_calculated' => '22','food_fat_calculated' => '7','food_barcode' => NULL,'food_category_id' => '29','food_image_path' => NULL,'food_thumb' => 'tech_nutrition_mealtech_thumb.jpg','food_image_a' => 'tech_nutrition_mealtech_a.jpg','food_image_b' => 'tech_nutrition_mealtech_b.jpg','food_image_c' => 'tech_nutrition_mealtech_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '32','food_user_id' => '0','food_name' => 'Chocolate peanut','food_clean_name' => 'chocolate_peanut','food_manufacturer_name' => 'Atkins','food_store' => '','food_description' => '','food_serving_size_gram' => '60','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '386','food_proteins' => '29.4','food_carbohydrates' => '24.8','food_fat' => '19','food_energy_calculated' => '232','food_proteins_calculated' => '18','food_carbohydrates_calculated' => '15','food_fat_calculated' => '11','food_barcode' => '','food_category_id' => '28','food_image_path' => '_uploads/food/_img/no/2018/atkins_chocolate_peanut','food_thumb' => '32_thumb.png','food_image_a' => '32_a.png','food_image_b' => '32_b.png','food_image_c' => 'atkins_chocolate_peanut_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '33','food_user_id' => '0','food_name' => 'Protein bar almond and caramel flavour','food_clean_name' => 'protein_bar_almond_and_caramel_flavour','food_manufacturer_name' => 'Maxim','food_store' => '','food_description' => '','food_serving_size_gram' => '50','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '328','food_proteins' => '41','food_carbohydrates' => '27','food_fat' => '9.2','food_energy_calculated' => '164','food_proteins_calculated' => '21','food_carbohydrates_calculated' => '14','food_fat_calculated' => '5','food_barcode' => '','food_category_id' => '28','food_image_path' => '_uploads/food/_img/no/2018/maxim_protein_bar_almond_and_caramel_flavour','food_thumb' => '33_thumb.png','food_image_a' => '33_a.png','food_image_b' => '33_b.png','food_image_c' => 'maxim_protein_bar_clmond_cnd_caramel_flavour_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '34','food_user_id' => '0','food_name' => 'YT 1 Oppladning før trening - Søt og salt med sjokolade','food_clean_name' => 'yt_1_oppladning_fr_trening_-_st_og_salt_med_sjokolade','food_manufacturer_name' => 'Tine','food_store' => '','food_description' => '','food_serving_size_gram' => '50','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '427','food_proteins' => '21','food_carbohydrates' => '45','food_fat' => '17','food_energy_calculated' => '214','food_proteins_calculated' => '11','food_carbohydrates_calculated' => '23','food_fat_calculated' => '9','food_barcode' => '','food_category_id' => '28','food_image_path' => '_uploads/food/_img/no/2018/tine_yt_1_oppladning_fr_trening_-_st_og_salt_med_sjokolade','food_thumb' => '34_thumb.png','food_image_a' => '34_a.png','food_image_b' => '34_b.png','food_image_c' => 'tine_yt_1_oppladning_for_trening_sot_og_salt_med_sjokolade_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '35','food_user_id' => '0','food_name' => 'YT 3 Restitusjonsbar','food_clean_name' => 'yt_restitusjonsbar','food_manufacturer_name' => 'Tine','food_store' => 'Meny','food_description' => '','food_serving_size_gram' => '65','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '377','food_proteins' => '29','food_carbohydrates' => '48','food_fat' => '8.3','food_energy_calculated' => '245','food_proteins_calculated' => '19','food_carbohydrates_calculated' => '31','food_fat_calculated' => '5','food_barcode' => '7038010043550','food_category_id' => '28','food_image_path' => '_uploads/food/_img/no/2018/tine_yt_restitusjonsbar','food_thumb' => '35_thumb.png','food_image_a' => '35_a.png','food_image_b' => '35_b.png','food_image_c' => 'tine_yt_restitusjonsbar_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '36','food_user_id' => '0','food_name' => 'Lean Whey Chocolate Milkshake','food_clean_name' => NULL,'food_manufacturer_name' => 'Gymgrossisten Optimum Nutrition','food_store' => NULL,'food_description' => NULL,'food_serving_size_gram' => '30','food_serving_size_gram_measurement' => 'gram','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'skje','food_energy' => '410','food_proteins' => '20','food_carbohydrates' => '1.4','food_fat' => '1.4','food_energy_calculated' => '123','food_proteins_calculated' => '6','food_carbohydrates_calculated' => '0','food_fat_calculated' => '0','food_barcode' => NULL,'food_category_id' => '29','food_image_path' => NULL,'food_thumb' => 'gymgrossisten_100_lean_whey_chocolate_milkshake_thumb.jpg','food_image_a' => 'gymgrossisten_100_lean_whey_chocolate_milkshake_a.jpg','food_image_b' => 'gymgrossisten_100_lean_whey_chocolate_milkshake_b.jpg','food_image_c' => 'gymgrossisten_100_lean_whey_chocolate_milkshake_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '37','food_user_id' => '0','food_name' => '100% Whey Gold Standard Cookies and Cream','food_clean_name' => NULL,'food_manufacturer_name' => 'Gymgrossisten','food_store' => NULL,'food_description' => NULL,'food_serving_size_gram' => '30','food_serving_size_gram_measurement' => 'gram','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'skje','food_energy' => '363','food_proteins' => '78.9','food_carbohydrates' => '7.8','food_fat' => '2.5','food_energy_calculated' => '109','food_proteins_calculated' => '24','food_carbohydrates_calculated' => '2','food_fat_calculated' => '1','food_barcode' => NULL,'food_category_id' => '29','food_image_path' => NULL,'food_thumb' => 'gymgrossisten_100_whey_gold_standard_cookies_and_cream_thumb.jpg','food_image_a' => 'gymgrossisten_100_whey_gold_standard_cookies_and_cream_a.jpg','food_image_b' => 'gymgrossisten_100_whey_gold_standard_cookies_and_cream_b.jpg','food_image_c' => 'gymgrossisten_100_whey_gold_standard_cookies_cnd_cream_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '38','food_user_id' => '0','food_name' => '100% Whey Gold Standard Delicious Strawberry','food_clean_name' => NULL,'food_manufacturer_name' => 'Gymgrossisten','food_store' => NULL,'food_description' => NULL,'food_serving_size_gram' => '30','food_serving_size_gram_measurement' => 'gram','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'skje','food_energy' => '375','food_proteins' => '82.5','food_carbohydrates' => '4.5','food_fat' => '2.9','food_energy_calculated' => '113','food_proteins_calculated' => '25','food_carbohydrates_calculated' => '1','food_fat_calculated' => '1','food_barcode' => NULL,'food_category_id' => '29','food_image_path' => NULL,'food_thumb' => 'gymgrossisten_100_whey_gold_standard_delicious_strawberry_thumb.jpg','food_image_a' => 'gymgrossisten_100_whey_gold_standard_delicious_strawberry_a.jpg','food_image_b' => 'gymgrossisten_100_whey_gold_standard_delicious_strawberry_b.jpg','food_image_c' => 'gymgrossisten_100_whey_gold_standard_delicious_strawberry_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '39','food_user_id' => '0','food_name' => 'Lean Protein Blueberry Raspberry Ice Cream','food_clean_name' => NULL,'food_manufacturer_name' => 'Gymgrossisten','food_store' => NULL,'food_description' => NULL,'food_serving_size_gram' => '30','food_serving_size_gram_measurement' => 'gram','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'skje','food_energy' => '378','food_proteins' => '80','food_carbohydrates' => '4','food_fat' => '5','food_energy_calculated' => '113','food_proteins_calculated' => '24','food_carbohydrates_calculated' => '1','food_fat_calculated' => '2','food_barcode' => NULL,'food_category_id' => '29','food_image_path' => NULL,'food_thumb' => 'gymgrossisten_lean_protein_thumb.jpg','food_image_a' => 'gymgrossisten_lean_protein_a.jpg','food_image_b' => 'gymgrossisten_lean_protein_b.jpg','food_image_c' => 'gymgrossisten_lean_protein_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '40','food_user_id' => '0','food_name' => 'Whey 80 Ice Coffee','food_clean_name' => NULL,'food_manufacturer_name' => 'Gymgrossisten','food_store' => NULL,'food_description' => NULL,'food_serving_size_gram' => '30','food_serving_size_gram_measurement' => 'gram','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'skje','food_energy' => '396','food_proteins' => '76','food_carbohydrates' => '4','food_fat' => '8','food_energy_calculated' => '119','food_proteins_calculated' => '23','food_carbohydrates_calculated' => '1','food_fat_calculated' => '2','food_barcode' => NULL,'food_category_id' => '29','food_image_path' => NULL,'food_thumb' => 'gymgrossisten_whey_80_ice_coffee_thumb.jpg','food_image_a' => 'gymgrossisten_whey_80_ice_coffee_a.jpg','food_image_b' => 'gymgrossisten_whey_80_ice_coffee_b.jpg','food_image_c' => 'gymgrossisten_whey_80_ice_coffee_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '41','food_user_id' => '0','food_name' => 'Prozyme proteinpulver bringebær','food_clean_name' => 'prozyme_proteinpulver_bringeba','food_manufacturer_name' => 'Tech Nutrition','food_store' => '','food_description' => '','food_serving_size_gram' => '40','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'skje','food_energy' => '368','food_proteins' => '82.5','food_carbohydrates' => '5','food_fat' => '1.3','food_energy_calculated' => '147','food_proteins_calculated' => '33','food_carbohydrates_calculated' => '2','food_fat_calculated' => '1','food_barcode' => '','food_category_id' => '29','food_image_path' => '_uploads/food/_img/no/2018/tech_nutrition_prozyme_proteinpulver_bringeba','food_thumb' => 'tech_nutrition_prozyme_proteinpulver_bringeba_thumb.png','food_image_a' => 'tech_nutrition_prozyme_proteinpulver_bringeba_a.png','food_image_b' => 'prozyme_proteinpulve_b.jpg','food_image_c' => 'prozyme_proteinpulve_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '42','food_user_id' => '0','food_name' => 'Sprek proteinsmoothie','food_clean_name' => 'sprek_proteinsmoothie','food_manufacturer_name' => 'Tech Nutrition','food_store' => '','food_description' => '','food_serving_size_gram' => '28','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'skje','food_energy' => '262','food_proteins' => '71','food_carbohydrates' => '23.3','food_fat' => '1','food_energy_calculated' => '73','food_proteins_calculated' => '20','food_carbohydrates_calculated' => '7','food_fat_calculated' => '0','food_barcode' => '','food_category_id' => '29','food_image_path' => '_uploads/food/_img/no/2018/tech_nutrition_sprek_proteinsmoothie','food_thumb' => 'tech_nutrition_sprek_proteinsmoothie_thumb.png','food_image_a' => 'tech_nutrition_sprek_proteinsmoothie_a.png','food_image_b' => 'sprek_proteinpulver_b.jpg','food_image_c' => 'sprek_proteinpulver_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '43','food_user_id' => '0','food_name' => 'Stjernebacon','food_clean_name' => 'stjernebacon','food_manufacturer_name' => 'Gilde','food_store' => 'Meny','food_description' => '','food_serving_size_gram' => '23','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'skive','food_energy' => '301','food_proteins' => '14','food_carbohydrates' => '0.5','food_fat' => '27','food_energy_calculated' => '69','food_proteins_calculated' => '3','food_carbohydrates_calculated' => '0','food_fat_calculated' => '6','food_barcode' => '7037204303258','food_category_id' => '34','food_image_path' => '_uploads/food/_img/no/2018/stjernebacon','food_thumb' => '43_thumb.png','food_image_a' => '43_a.png','food_image_b' => '43_b.png','food_image_c' => 'gilde_stjernebacon_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '44','food_user_id' => '0','food_name' => 'Kvernet deig av storfe (5 %)','food_clean_name' => 'kvernet_deig_av_storfe_5','food_manufacturer_name' => 'Nordfjord','food_store' => '','food_description' => '','food_serving_size_gram' => '200','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '0.5','food_serving_size_pcs_measurement' => 'pakke','food_energy' => '123','food_proteins' => '19','food_carbohydrates' => '0','food_fat' => '5','food_energy_calculated' => '246','food_proteins_calculated' => '38','food_carbohydrates_calculated' => '0','food_fat_calculated' => '10','food_barcode' => '','food_category_id' => '33','food_image_path' => '_uploads/food/_img/no/2018/nordfjord_kvernet_deig_av_storfe_5','food_thumb' => 'nordfjord_kvernet_deig_av_storfe_thumb.jpg','food_image_a' => 'nordfjord_kvernet_deig_av_storfe_a.jpg','food_image_b' => 'nordfjord_kvernet_deig_av_storfe_b.jpg','food_image_c' => 'nordfjord_kvernet_deig_cv_storfe_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '45','food_user_id' => '0','food_name' => 'Kvernet deig av storfe','food_clean_name' => 'kvernet_deig_av_storfe','food_manufacturer_name' => 'Rema 1000','food_store' => 'Rema 1000','food_description' => '','food_serving_size_gram' => '200','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '0.5','food_serving_size_pcs_measurement' => 'pakke','food_energy' => '123','food_proteins' => '19','food_carbohydrates' => '0','food_fat' => '1.9','food_energy_calculated' => '246','food_proteins_calculated' => '38','food_carbohydrates_calculated' => '0','food_fat_calculated' => '4','food_barcode' => '','food_category_id' => '33','food_image_path' => '_uploads/food/_img/no/2018/kvernet_deig_av_storfe','food_thumb' => '45_thumb.png','food_image_a' => '45_a.png','food_image_b' => '45_b.png','food_image_c' => 'rema_1000_kvernet_deig_cv_storfe_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '47','food_user_id' => '0','food_name' => 'Strimlet svinekjøtt av bog','food_clean_name' => 'strimlet_svinekjtt_av_bog','food_manufacturer_name' => 'Rema 1000','food_store' => '','food_description' => '','food_serving_size_gram' => '192','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '0.5','food_serving_size_pcs_measurement' => 'pakke','food_energy' => '110','food_proteins' => '24','food_carbohydrates' => '0','food_fat' => '1.6','food_energy_calculated' => '211','food_proteins_calculated' => '46','food_carbohydrates_calculated' => '0','food_fat_calculated' => '3','food_barcode' => '','food_category_id' => '34','food_image_path' => '_uploads/food/_img/no/2018/rema_1000_strimlet_svinekjtt_av_bog','food_thumb' => 'rema_1000_tynnskaaret_svinefilet_thumb.jpg','food_image_a' => 'rema_1000_tynnskaaret_svinefilet_a.jpg','food_image_b' => 'rema_1000_tynnskaaret_svinefilet_b.jpg','food_image_c' => 'rema_1000_tynnskaaret_svinefilet_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '48','food_user_id' => '0','food_name' => 'Frossen god helg kylling bbq','food_clean_name' => 'frossen_god_helg_kylling_bbq','food_manufacturer_name' => 'Den stolte hane','food_store' => '','food_description' => '','food_serving_size_gram' => '412','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '0.5','food_serving_size_pcs_measurement' => 'pakke','food_energy' => '179','food_proteins' => '16.8','food_carbohydrates' => '0.1','food_fat' => '12.2','food_energy_calculated' => '737','food_proteins_calculated' => '69','food_carbohydrates_calculated' => '0','food_fat_calculated' => '50','food_barcode' => '','food_category_id' => '35','food_image_path' => '_uploads/food/_img/no/2018/den_stolte_hane_frossen_god_helg_kylling_bbq','food_thumb' => '48_thumb.png','food_image_a' => '48_a.png','food_image_b' => '48_b.png','food_image_c' => 'den_stolte_hane_frossen_god_helg_kylling_bbq_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '49','food_user_id' => '0','food_name' => 'Frossen kyllingfilet','food_clean_name' => 'frossen_kyllingfilet','food_manufacturer_name' => 'First Price','food_store' => '','food_description' => '','food_serving_size_gram' => '200','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '93','food_proteins' => '21','food_carbohydrates' => '0.2','food_fat' => '0.9','food_energy_calculated' => '186','food_proteins_calculated' => '42','food_carbohydrates_calculated' => '0','food_fat_calculated' => '2','food_barcode' => '','food_category_id' => '35','food_image_path' => '_uploads/food/_img/no/2018/first_price_frossen_kyllingfilet','food_thumb' => '49_thumb.png','food_image_a' => '49_a.png','food_image_b' => '49_b.png','food_image_c' => 'first_price_frossen_kyllingfilet_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '50','food_user_id' => '0','food_name' => 'Kalkunfilet salt og pepper (fersk)','food_clean_name' => 'kalkunfilet_salt_og_pepper_fersk','food_manufacturer_name' => 'Prior','food_store' => NULL,'food_description' => NULL,'food_serving_size_gram' => '100','food_serving_size_gram_measurement' => 'gram','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '113','food_proteins' => '25','food_carbohydrates' => '0.2','food_fat' => '1.4','food_energy_calculated' => '113','food_proteins_calculated' => '25','food_carbohydrates_calculated' => '0','food_fat_calculated' => '1','food_barcode' => NULL,'food_category_id' => '35','food_image_path' => '_uploads/food/_img/no/2018/prior_kalkunfilet_salt_og_pepper_fersk','food_thumb' => 'prior_kalkunfilet_salt_og_pepper_thumb.jpg','food_image_a' => 'prior_kalkunfilet_salt_og_pepper_a.jpg','food_image_b' => 'prior_kalkunfilet_salt_og_pepper_b.jpg','food_image_c' => 'prior_kalkunfilet_salt_og_pepper_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '51','food_user_id' => '0','food_name' => 'Reker i lake','food_clean_name' => NULL,'food_manufacturer_name' => 'Fiskemannen','food_store' => NULL,'food_description' => NULL,'food_serving_size_gram' => '200','food_serving_size_gram_measurement' => 'gram','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'boks','food_energy' => '79','food_proteins' => '16','food_carbohydrates' => '1.5','food_fat' => '1','food_energy_calculated' => '158','food_proteins_calculated' => '32','food_carbohydrates_calculated' => '3','food_fat_calculated' => '2','food_barcode' => NULL,'food_category_id' => '44','food_image_path' => NULL,'food_thumb' => 'fiskemannen_reker_i_lake_thumb.jpg','food_image_a' => 'fiskemannen_reker_i_lake_a.jpg','food_image_b' => 'fiskemannen_reker_i_lake_b.jpg','food_image_c' => 'fiskemannen_reker_i_lake_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '52','food_user_id' => '0','food_name' => 'Egg eggehvite','food_clean_name' => 'egg_eggehvite','food_manufacturer_name' => 'First Price','food_store' => '','food_description' => '','food_serving_size_gram' => '30','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '42','food_proteins' => '10.2','food_carbohydrates' => '0.4','food_fat' => '0','food_energy_calculated' => '13','food_proteins_calculated' => '3','food_carbohydrates_calculated' => '0','food_fat_calculated' => '0','food_barcode' => '','food_category_id' => '45','food_image_path' => '_uploads/food/_img/no/2018/egg_eggehvite','food_thumb' => 'first_price_egg_eggehvite_thumb.jpg','food_image_a' => 'first_price_egg_eggehvite_a.jpg','food_image_b' => 'first_price_egg_eggehvite_b.jpg','food_image_c' => 'first_price_egg_eggehvite_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '53','food_user_id' => '0','food_name' => 'Egg eggeplomme','food_clean_name' => 'egg_eggeplomme','food_manufacturer_name' => 'First Price','food_store' => '','food_description' => '','food_serving_size_gram' => '15','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '308','food_proteins' => '15.8','food_carbohydrates' => '0.2','food_fat' => '27.1','food_energy_calculated' => '46','food_proteins_calculated' => '2','food_carbohydrates_calculated' => '0','food_fat_calculated' => '4','food_barcode' => '','food_category_id' => '45','food_image_path' => '_uploads/food/_img/no/2018/egg_eggeplomme','food_thumb' => 'first_price_egg_eggeplomme_thumb.jpg','food_image_a' => 'first_price_egg_eggeplomme_a.jpg','food_image_b' => 'first_price_egg_eggeplomme_b.jpg','food_image_c' => 'first_price_egg_eggeplomme_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '54','food_user_id' => '0','food_name' => 'Egg (kokt)','food_clean_name' => 'egg_kokt','food_manufacturer_name' => 'First Price','food_store' => '','food_description' => '','food_serving_size_gram' => '63','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '143','food_proteins' => '12.4','food_carbohydrates' => '0.3','food_fat' => '10.2','food_energy_calculated' => '90','food_proteins_calculated' => '8','food_carbohydrates_calculated' => '0','food_fat_calculated' => '6','food_barcode' => '','food_category_id' => '45','food_image_path' => '_uploads/food/_img/no/2018/egg_kokt','food_thumb' => 'first_price_egg_kokt_thumb.png','food_image_a' => 'first_price_egg_kokt_a.png','food_image_b' => 'first_price_egg_kokt_b.jpg','food_image_c' => 'first_price_egg_kokt_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '55','food_user_id' => '0','food_name' => 'Egg','food_clean_name' => 'egg','food_manufacturer_name' => 'Flemming','food_store' => '','food_description' => '','food_serving_size_gram' => '63','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '142','food_proteins' => '12.4','food_carbohydrates' => '0.3','food_fat' => '10.1','food_energy_calculated' => '89','food_proteins_calculated' => '8','food_carbohydrates_calculated' => '0','food_fat_calculated' => '6','food_barcode' => '','food_category_id' => '45','food_image_path' => '_uploads/food/_img/no/2018/egg','food_thumb' => '55_thumb.png','food_image_a' => '55_a.png','food_image_b' => 'flemming_egg_b.jpg','food_image_c' => '55_c.png','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '56','food_user_id' => '0','food_name' => 'Cottage Cheese original','food_clean_name' => 'cottage_cheese_original','food_manufacturer_name' => 'Tine','food_store' => '','food_description' => '','food_serving_size_gram' => '250','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'boks','food_energy' => '96','food_proteins' => '13','food_carbohydrates' => '1.5','food_fat' => '4.3','food_energy_calculated' => '240','food_proteins_calculated' => '33','food_carbohydrates_calculated' => '4','food_fat_calculated' => '11','food_barcode' => '','food_category_id' => '47','food_image_path' => '_uploads/food/_img/no/2018/tine_cottage_cheese_original','food_thumb' => 'tine_cottage_cheese_thumb.jpg','food_image_a' => 'tine_cottage_cheese_a.jpg','food_image_b' => 'tine_cottage_cheese_b.jpg','food_image_c' => 'tine_cottage_cheese_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '57','food_user_id' => '0','food_name' => 'Mager Cottage Cheese 400g','food_clean_name' => 'mager_cottage_cheese_400g','food_manufacturer_name' => 'Tine','food_store' => '','food_description' => '','food_serving_size_gram' => '200','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '0.5','food_serving_size_pcs_measurement' => 'boks','food_energy' => '79','food_proteins' => '13','food_carbohydrates' => '2.1','food_fat' => '2','food_energy_calculated' => '158','food_proteins_calculated' => '26','food_carbohydrates_calculated' => '4','food_fat_calculated' => '4','food_barcode' => '7038010054488','food_category_id' => '47','food_image_path' => '_uploads/food/_img/no/2018/mager_cottage_cheese_400g','food_thumb' => '57_thumb.png','food_image_a' => '57_a.png','food_image_b' => '57_b.png','food_image_c' => 'tine_mager_cottage_cheese_400g_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '58','food_user_id' => '0','food_name' => 'Mager cottage cheese med eple, pære og vanilje','food_clean_name' => 'mager_cottage_cheese_med_eple__pre_og_vanilje','food_manufacturer_name' => 'Tine','food_store' => 'Meny','food_description' => '','food_serving_size_gram' => '250','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'boks','food_energy' => '92','food_proteins' => '11','food_carbohydrates' => '7.6','food_fat' => '1.7','food_energy_calculated' => '230','food_proteins_calculated' => '28','food_carbohydrates_calculated' => '19','food_fat_calculated' => '4','food_barcode' => '7038010042232','food_category_id' => '47','food_image_path' => '_uploads/food/_img/no/2018/mager_cottage_cheese_med_eple__pre_og_vanilje','food_thumb' => '58_thumb.png','food_image_a' => '58_a.png','food_image_b' => '58_b.png','food_image_c' => 'tine_mager_cottage_cheese_eple_paere_og_vanilje_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '59','food_user_id' => '0','food_name' => 'Liten skyr blåbær','food_clean_name' => 'liten_skyr_blbr','food_manufacturer_name' => 'Q Meieriene','food_store' => '','food_description' => '','food_serving_size_gram' => '160','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '58','food_proteins' => '10','food_carbohydrates' => '4','food_fat' => '0.2','food_energy_calculated' => '93','food_proteins_calculated' => '16','food_carbohydrates_calculated' => '6','food_fat_calculated' => '0','food_barcode' => '','food_category_id' => '47','food_image_path' => '_uploads/food/_img/no/2018/liten_skyr_blbr','food_thumb' => '59_thumb.png','food_image_a' => '59_a.png','food_image_b' => '59_b.png','food_image_c' => 'q_meieriene_liten_skyr_blabaer_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '60','food_user_id' => '0','food_name' => 'Liten skyr jorbær og lime','food_clean_name' => 'liten_skyr_jorbr_og_lime','food_manufacturer_name' => 'Q Meieriene','food_store' => '','food_description' => '','food_serving_size_gram' => '160','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '58','food_proteins' => '10','food_carbohydrates' => '4','food_fat' => '0.2','food_energy_calculated' => '93','food_proteins_calculated' => '16','food_carbohydrates_calculated' => '6','food_fat_calculated' => '0','food_barcode' => '','food_category_id' => '47','food_image_path' => '_uploads/food/_img/no/2018/q_meieriene_liten_skyr_jorbr_og_lime','food_thumb' => '60_thumb.png','food_image_a' => '60_a.png','food_image_b' => '60_b.png','food_image_c' => 'q_meieriene_liten_skyr_jordbaer_og_lime_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '61','food_user_id' => '0','food_name' => 'Skyr skogsbærkick','food_clean_name' => 'skyr_skogsbrkick','food_manufacturer_name' => 'Q Meieriene','food_store' => '','food_description' => '','food_serving_size_gram' => '170','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '108','food_proteins' => '10','food_carbohydrates' => '15','food_fat' => '0.4','food_energy_calculated' => '184','food_proteins_calculated' => '17','food_carbohydrates_calculated' => '26','food_fat_calculated' => '1','food_barcode' => '','food_category_id' => '47','food_image_path' => '_uploads/food/_img/no/2018/q_meieriene_skyr_skogsbrkick','food_thumb' => '61_thumb.png','food_image_a' => '61_a.png','food_image_b' => '61_b.png','food_image_c' => 'q_meieriene_skyr_skogsbaerkick_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '62','food_user_id' => '0','food_name' => 'Go morgen melon- og pasjonsfruktyoghurt med 4-kornmusli','food_clean_name' => 'go_morgen_melon-_og_pasjonsfruktyoghurt_med_4-kornmusli','food_manufacturer_name' => 'Tine','food_store' => '','food_description' => '','food_serving_size_gram' => '195','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '125','food_proteins' => '4.4','food_carbohydrates' => '20','food_fat' => '2.9','food_energy_calculated' => '244','food_proteins_calculated' => '9','food_carbohydrates_calculated' => '39','food_fat_calculated' => '6','food_barcode' => '7038010008528','food_category_id' => '47','food_image_path' => '_uploads/food/_img/no/2018/tine_go_morgen_melon-_og_pasjonsfruktyoghurt_med_4-kornmusli','food_thumb' => '62_thumb.png','food_image_a' => '62_a.png','food_image_b' => '62_b.png','food_image_c' => 'tine_go_morgen_melon-_og_pasjonsfruktyoghurt_med_4-kornmusli_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '63','food_user_id' => '0','food_name' => 'Go morgen skogsbæryoghurt med 4-kormusli','food_clean_name' => 'go_morgen_skogsbryoghurt_med_4-kormusli','food_manufacturer_name' => 'Tine','food_store' => '','food_description' => '','food_serving_size_gram' => '195','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '126','food_proteins' => '4.5','food_carbohydrates' => '20','food_fat' => '3','food_energy_calculated' => '246','food_proteins_calculated' => '9','food_carbohydrates_calculated' => '39','food_fat_calculated' => '6','food_barcode' => '','food_category_id' => '47','food_image_path' => '_uploads/food/_img/no/2018/tine_go_morgen_skogsbryoghurt_med_4-kormusli','food_thumb' => '63_thumb.png','food_image_a' => '63_a.png','food_image_b' => '63_b.png','food_image_c' => 'tine_go_morgen_skogsbaeryoghurt_med_4-kornmusli_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '64','food_user_id' => '0','food_name' => 'Double 0% Protein - Plus','food_clean_name' => 'double_0_protein_-_plus','food_manufacturer_name' => 'Yoplait','food_store' => '','food_description' => '','food_serving_size_gram' => '125','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '63','food_proteins' => '8','food_carbohydrates' => '6.8','food_fat' => '0.4','food_energy_calculated' => '79','food_proteins_calculated' => '10','food_carbohydrates_calculated' => '9','food_fat_calculated' => '1','food_barcode' => '','food_category_id' => '47','food_image_path' => '_uploads/food/_img/no/2018/yoplait_double_0_protein_-_plus','food_thumb' => 'yoplait_double_protein_thumb.jpg','food_image_a' => 'yoplait_double_protein_a.jpg','food_image_b' => 'yoplait_double_protein_b.jpg','food_image_c' => 'yoplait_double_protein_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '65','food_user_id' => '0','food_name' => 'Finnbiff med poteter og tyttebærsyltetøy','food_clean_name' => 'finnbiff_med_poteter_og_tyttebrsyltety','food_manufacturer_name' => 'Fjordland','food_store' => '','food_description' => '','food_serving_size_gram' => '485','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'pakke','food_energy' => '81','food_proteins' => '4.1','food_carbohydrates' => '14','food_fat' => '3','food_energy_calculated' => '393','food_proteins_calculated' => '20','food_carbohydrates_calculated' => '68','food_fat_calculated' => '15','food_barcode' => '','food_category_id' => '38','food_image_path' => '_uploads/food/_img/no/2018/finnbiff_med_poteter_og_tyttebrsyltety','food_thumb' => '65_thumb.png','food_image_a' => '65_a.png','food_image_b' => '65_b.png','food_image_c' => 'fjordland_finnbiff_med_poteter_og_tyttebaersyltetooy_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '66','food_user_id' => '0','food_name' => 'Ristorante Pizza Spesiale','food_clean_name' => 'ristorante_pizza_spesiale','food_manufacturer_name' => 'Dr. Oetker','food_store' => '','food_description' => '','food_serving_size_gram' => '330','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'pizza','food_energy' => '254','food_proteins' => '10','food_carbohydrates' => '23','food_fat' => '13','food_energy_calculated' => '838','food_proteins_calculated' => '33','food_carbohydrates_calculated' => '76','food_fat_calculated' => '43','food_barcode' => '','food_category_id' => '39','food_image_path' => '_uploads/food/_img/no/2018/ristorante_pizza_spesiale','food_thumb' => 'dr_oetker_ristorante_pizza_spesiale_thumb.png','food_image_a' => 'dr_oetker_ristorante_pizza_spesiale_a.png','food_image_b' => 'dr_oetker_ristorante_pizza_speciale_b.jpg','food_image_c' => 'dr_oetker_ristorante_pizza_speciale_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '67','food_user_id' => '0','food_name' => 'Nudler med kjøttsmak','food_clean_name' => 'nudler_med_kjttsmak','food_manufacturer_name' => 'First Price','food_store' => '','food_description' => '','food_serving_size_gram' => '85','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'pakke','food_energy' => '349','food_proteins' => '11.2','food_carbohydrates' => '66.6','food_fat' => '3.5','food_energy_calculated' => '297','food_proteins_calculated' => '10','food_carbohydrates_calculated' => '57','food_fat_calculated' => '3','food_barcode' => '','food_category_id' => '40','food_image_path' => '_uploads/food/_img/no/2018/nudler_med_kjttsmak','food_thumb' => '67_thumb.png','food_image_a' => '67_a.png','food_image_b' => '67_b.png','food_image_c' => 'first_price_nudler_med_kjootsmak_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '68','food_user_id' => '0','food_name' => 'Fullkornspasta fusilli','food_clean_name' => 'fullkornspasta_fusilli','food_manufacturer_name' => 'Sopps','food_store' => '','food_description' => '','food_serving_size_gram' => '60','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '60','food_serving_size_pcs_measurement' => 'g','food_energy' => '350','food_proteins' => '14','food_carbohydrates' => '65','food_fat' => '2','food_energy_calculated' => '210','food_proteins_calculated' => '8','food_carbohydrates_calculated' => '39','food_fat_calculated' => '1','food_barcode' => '','food_category_id' => '40','food_image_path' => '_uploads/food/_img/no/2018/fullkornspasta_fusilli','food_thumb' => 'sopps_fullkornspasta_fusilli_thumb.jpg','food_image_a' => 'sopps_fullkornspasta_fusilli_a.jpg','food_image_b' => 'sopps_fullkornspasta_fusilli_b.jpg','food_image_c' => 'sopps_fullkornspasta_fusilli_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '69','food_user_id' => '0','food_name' => 'Fullkornspasta penne','food_clean_name' => 'fullkornspasta_penne','food_manufacturer_name' => 'Sopps','food_store' => '','food_description' => '','food_serving_size_gram' => '60','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '60','food_serving_size_pcs_measurement' => 'g','food_energy' => '350','food_proteins' => '14','food_carbohydrates' => '65','food_fat' => '2','food_energy_calculated' => '210','food_proteins_calculated' => '8','food_carbohydrates_calculated' => '39','food_fat_calculated' => '1','food_barcode' => '','food_category_id' => '40','food_image_path' => '_uploads/food/_img/no/2018/fullkornspasta_penne','food_thumb' => 'sopps_fullkornspasta_penne_thumb.jpg','food_image_a' => 'sopps_fullkornspasta_penne_a.jpg','food_image_b' => 'sopps_fullkornspasta_penne_b.jpg','food_image_c' => 'sopps_fullkornspasta_penne_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '70','food_user_id' => '0','food_name' => 'Jasminris','food_clean_name' => 'jasminris','food_manufacturer_name' => 'Eldorado','food_store' => '','food_description' => '','food_serving_size_gram' => '60','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '60','food_serving_size_pcs_measurement' => 'g','food_energy' => '360','food_proteins' => '7','food_carbohydrates' => '80','food_fat' => '0.9','food_energy_calculated' => '216','food_proteins_calculated' => '4','food_carbohydrates_calculated' => '48','food_fat_calculated' => '1','food_barcode' => '','food_category_id' => '40','food_image_path' => '_uploads/food/_img/no/2018/jasminris','food_thumb' => 'eldorado_jasminris_thumb.jpg','food_image_a' => 'eldorado_jasminris_a.jpg','food_image_b' => 'eldorado_jasminris_b.jpg','food_image_c' => 'eldorado_jasminris_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '71','food_user_id' => '0','food_name' => 'Fullkorns couscous','food_clean_name' => 'fullkorns_couscous','food_manufacturer_name' => 'Go Green','food_store' => '','food_description' => '','food_serving_size_gram' => '70','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '70','food_serving_size_pcs_measurement' => 'g','food_energy' => '350','food_proteins' => '12','food_carbohydrates' => '34','food_fat' => '2','food_energy_calculated' => '245','food_proteins_calculated' => '8','food_carbohydrates_calculated' => '24','food_fat_calculated' => '1','food_barcode' => '','food_category_id' => '40','food_image_path' => '_uploads/food/_img/no/2018/fullkorns_couscous','food_thumb' => 'gogreen_fullkorns_couscous_thumb.jpg','food_image_a' => 'gogreen_fullkorns_couscous_a.jpg','food_image_b' => 'gogreen_fullkorns_couscous_b.jpg','food_image_c' => 'gogreen_fullkorns_couscous_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '72','food_user_id' => '0','food_name' => 'Thai hom mali rice jasminris','food_clean_name' => 'thai_hom_mali_rice_jasminris','food_manufacturer_name' => 'Rema 1000','food_store' => '','food_description' => '','food_serving_size_gram' => '60','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '60','food_serving_size_pcs_measurement' => 'g','food_energy' => '316','food_proteins' => '7.1','food_carbohydrates' => '78','food_fat' => '0.6','food_energy_calculated' => '190','food_proteins_calculated' => '4','food_carbohydrates_calculated' => '47','food_fat_calculated' => '0','food_barcode' => '','food_category_id' => '40','food_image_path' => '_uploads/food/_img/no/2018/thai_hom_mali_rice_jasminris','food_thumb' => '72_thumb.png','food_image_a' => '72_a.png','food_image_b' => '72_b.png','food_image_c' => 'rema_1000_thai_hom_mali_rice_jasminris_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '73','food_user_id' => '0','food_name' => 'Fullkornsris','food_clean_name' => 'fullkornsris','food_manufacturer_name' => 'Uncle Bens','food_store' => '','food_description' => '','food_serving_size_gram' => '60','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '60','food_serving_size_pcs_measurement' => 'g','food_energy' => '344','food_proteins' => '8','food_carbohydrates' => '73','food_fat' => '2.2','food_energy_calculated' => '206','food_proteins_calculated' => '5','food_carbohydrates_calculated' => '44','food_fat_calculated' => '1','food_barcode' => '','food_category_id' => '40','food_image_path' => '_uploads/food/_img/no/2018/fullkornsris','food_thumb' => 'uncle_bens_fullkornsris_thumb.jpg','food_image_a' => 'uncle_bens_fullkornsris_a.jpg','food_image_b' => 'uncle_bens_fullkornsris_b.jpg','food_image_c' => 'uncle_bens_fullkornsris_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '74','food_user_id' => '0','food_name' => 'Tex Mex Taco Sauce','food_clean_name' => 'text_mex_taco_sauce_','food_manufacturer_name' => 'Coop','food_store' => 'Coop','food_description' => '','food_serving_size_gram' => '15','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'ts','food_energy' => '34','food_proteins' => '1.2','food_carbohydrates' => '6.5','food_fat' => '0.2','food_energy_calculated' => '5','food_proteins_calculated' => '0','food_carbohydrates_calculated' => '1','food_fat_calculated' => '0','food_barcode' => '7032069715512','food_category_id' => '41','food_image_path' => '_uploads/food/_img/no/2018/text_mex_taco_sauce_','food_thumb' => 'coop_tex_mex_taco_sauce_thumb.png','food_image_a' => 'coop_tex_mex_taco_sauce_a.png','food_image_b' => 'coop_tex_mex_taco_sauce_b.png','food_image_c' => 'co-op_tex_mex_taco_sauce_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '75','food_user_id' => '0','food_name' => 'Myke tortilla-lefser','food_clean_name' => 'myke_tortilla-lefser','food_manufacturer_name' => 'First Price','food_store' => '','food_description' => '','food_serving_size_gram' => '40','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '332','food_proteins' => '9.3','food_carbohydrates' => '54.2','food_fat' => '8','food_energy_calculated' => '133','food_proteins_calculated' => '4','food_carbohydrates_calculated' => '22','food_fat_calculated' => '3','food_barcode' => '','food_category_id' => '41','food_image_path' => '_uploads/food/_img/no/2018/myke_tortilla-lefser','food_thumb' => '75_thumb.png','food_image_a' => '75_a.png','food_image_b' => '75_b.png','food_image_c' => 'first_prince_myke_tortilla-lefser_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '76','food_user_id' => '0','food_name' => '8 Tortillas Whole Weat','food_clean_name' => '8_tortillas_whole_weat','food_manufacturer_name' => 'Old El Paso','food_store' => '','food_description' => '','food_serving_size_gram' => '41','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '286','food_proteins' => '8.3','food_carbohydrates' => '46.6','food_fat' => '6','food_energy_calculated' => '117','food_proteins_calculated' => '3','food_carbohydrates_calculated' => '19','food_fat_calculated' => '2','food_barcode' => '','food_category_id' => '41','food_image_path' => '_uploads/food/_img/no/2018/8_tortillas_whole_weat','food_thumb' => 'old_el_paso_whole_wheete_thumb.jpg','food_image_a' => 'old_el_paso_whole_wheete_a.jpg','food_image_b' => 'old_el_paso_whole_wheete_b.jpg','food_image_c' => 'old_el_paso_whole_wheete_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '77','food_user_id' => '0','food_name' => 'Fullkorn tortillas 6 stk','food_clean_name' => 'fullkorn_tortillas_6_stk','food_manufacturer_name' => 'Rema 1000','food_store' => '','food_description' => '','food_serving_size_gram' => '62','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '234','food_proteins' => '9.8','food_carbohydrates' => '47','food_fat' => '5.8','food_energy_calculated' => '145','food_proteins_calculated' => '6','food_carbohydrates_calculated' => '29','food_fat_calculated' => '4','food_barcode' => '','food_category_id' => '41','food_image_path' => '_uploads/food/_img/no/2018/fullkorn_tortillas_6_stk','food_thumb' => 'rema_1000_fullkorn_tortillas_6_stk_thumb.png','food_image_a' => 'rema_1000_fullkorn_tortillas_6_stk_a.png','food_image_b' => 'rema_1000_fullkorn_tortillas_6_stk_b.png','food_image_c' => 'rema_1000_fullkorn_tortillas_6_stk_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '78','food_user_id' => '0','food_name' => 'Orginal Wrap Tortilla Big Size','food_clean_name' => 'orginal_wrap_tortilla_big_size','food_manufacturer_name' => 'Santa Maria','food_store' => '','food_description' => '','food_serving_size_gram' => '62','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '300','food_proteins' => '8.5','food_carbohydrates' => '53','food_fat' => '5','food_energy_calculated' => '186','food_proteins_calculated' => '5','food_carbohydrates_calculated' => '33','food_fat_calculated' => '3','food_barcode' => '','food_category_id' => '41','food_image_path' => '_uploads/food/_img/no/2018/orginal_wrap_tortilla_big_size','food_thumb' => 'santa_maria_orginal_wrap_tortilla_big_size_thumb.jpg','food_image_a' => 'santa_maria_orginal_wrap_tortilla_big_size_a.jpg','food_image_b' => 'santa_maria_orginal_wrap_tortilla_big_size_b.jpg','food_image_c' => 'santa_maria_orginal_wrap_tortilla_big_size_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '79','food_user_id' => '0','food_name' => '8 Tortillas With Whole Weat','food_clean_name' => '8_tortillas_with_whole_weat','food_manufacturer_name' => 'Santa Maria','food_store' => '','food_description' => '','food_serving_size_gram' => '40','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '280','food_proteins' => '8','food_carbohydrates' => '47','food_fat' => '5.5','food_energy_calculated' => '112','food_proteins_calculated' => '3','food_carbohydrates_calculated' => '19','food_fat_calculated' => '2','food_barcode' => '','food_category_id' => '41','food_image_path' => '_uploads/food/_img/no/2018/8_tortillas_with_whole_weat','food_thumb' => 'santa_maria_tortilla_with_whole_weat_thumb.jpg','food_image_a' => 'santa_maria_tortilla_with_whole_weat_a.jpg','food_image_b' => 'santa_maria_tortilla_with_whole_weat_b.jpg','food_image_c' => 'santa_maria_tortilla_with_whole_weat_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '80','food_user_id' => '0','food_name' => 'Philadelphia naturell light','food_clean_name' => 'philadelphia_naturell_light','food_manufacturer_name' => 'Kraft','food_store' => '','food_description' => '','food_serving_size_gram' => '30','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'skje','food_energy' => '152','food_proteins' => '7.4','food_carbohydrates' => '5.1','food_fat' => '11','food_energy_calculated' => '46','food_proteins_calculated' => '2','food_carbohydrates_calculated' => '2','food_fat_calculated' => '3','food_barcode' => '','food_category_id' => '60','food_image_path' => '_uploads/food/_img/no/2018/philadelphia_naturell_light','food_thumb' => 'kraft_philadelphia_naturell_light_thumb.png','food_image_a' => 'kraft_philadelphia_naturell_light_a.png','food_image_b' => 'kraft_philadelphia_naturell_light_b.png','food_image_c' => 'kraft_philadelphia_naturell_light_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '81','food_user_id' => '0','food_name' => 'Lammerull pålegg','food_clean_name' => 'lammerull_plegg','food_manufacturer_name' => 'Gilde','food_store' => '','food_description' => '','food_serving_size_gram' => '13','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'skive','food_energy' => '173','food_proteins' => '17','food_carbohydrates' => '1.4','food_fat' => '11','food_energy_calculated' => '22','food_proteins_calculated' => '2','food_carbohydrates_calculated' => '0','food_fat_calculated' => '1','food_barcode' => '','food_category_id' => '52','food_image_path' => '_uploads/food/_img/no/2018/lammerull_plegg','food_thumb' => '81_thumb.png','food_image_a' => '81_a.png','food_image_b' => 'gilde_lammerull_palegg_b.jpg','food_image_c' => 'gilde_lammerull_palegg_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '82','food_user_id' => '0','food_name' => 'Roastbiff pålegg','food_clean_name' => 'roastbiff_palegg','food_manufacturer_name' => 'Gilde','food_store' => '','food_description' => '','food_serving_size_gram' => '50','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'skive','food_energy' => '117','food_proteins' => '24','food_carbohydrates' => '1.3','food_fat' => '1.8','food_energy_calculated' => '59','food_proteins_calculated' => '12','food_carbohydrates_calculated' => '1','food_fat_calculated' => '1','food_barcode' => '','food_category_id' => '52','food_image_path' => '_uploads/food/_img/no/2018/roastbiff_plegg','food_thumb' => 'gilde_roastbiff_palegg_thumb.png','food_image_a' => 'gilde_roastbiff_palegg_a.png','food_image_b' => 'gilde_roastbiff_palegg_b.jpg','food_image_c' => 'gilde_roastbiff_palegg_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '83','food_user_id' => '0','food_name' => 'Kalkunfilet med peppermix','food_clean_name' => 'kalkunfilet_med_peppermix','food_manufacturer_name' => 'Kylling Norge','food_store' => '','food_description' => '','food_serving_size_gram' => '50','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'skive','food_energy' => '103','food_proteins' => '21.8','food_carbohydrates' => '1','food_fat' => '1.2','food_energy_calculated' => '52','food_proteins_calculated' => '11','food_carbohydrates_calculated' => '1','food_fat_calculated' => '1','food_barcode' => '','food_category_id' => '52','food_image_path' => '_uploads/food/_img/no/2018/kalkunfilet_med_peppermix','food_thumb' => '83_thumb.png','food_image_a' => '83_a.png','food_image_b' => '83_b.png','food_image_c' => 'kylling_norge_kalkunfilet_med_peppermix_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '84','food_user_id' => '0','food_name' => 'Jalapeñoskinke','food_clean_name' => 'jalapeoskinke','food_manufacturer_name' => 'Nordfjord','food_store' => 'Rema 1000','food_description' => '','food_serving_size_gram' => '9','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'skive','food_energy' => '104','food_proteins' => '18','food_carbohydrates' => '1.2','food_fat' => '3','food_energy_calculated' => '9','food_proteins_calculated' => '2','food_carbohydrates_calculated' => '0','food_fat_calculated' => '0','food_barcode' => '7024850015468','food_category_id' => '52','food_image_path' => '_uploads/food/_img/no/2018/jalapeoskinke','food_thumb' => 'nordfjord_jalapeñoskinke_thumb.png','food_image_a' => 'nordfjord_jalapeñoskinke_a.png','food_image_b' => 'nordfjord_jalapeñoskinke_b.png','food_image_c' => 'nordfjord_jalapenoskinke_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '85','food_user_id' => '0','food_name' => 'Kalkunfilet naturell pålegg','food_clean_name' => 'kalkunfilet_naturell_palegg','food_manufacturer_name' => 'Prior','food_store' => '','food_description' => '','food_serving_size_gram' => '50','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'skive','food_energy' => '104','food_proteins' => '21','food_carbohydrates' => '2','food_fat' => '1.2','food_energy_calculated' => '52','food_proteins_calculated' => '11','food_carbohydrates_calculated' => '1','food_fat_calculated' => '1','food_barcode' => '7039610024055','food_category_id' => '52','food_image_path' => '_uploads/food/_img/no/2018/kalkunfilet_plegg','food_thumb' => 'prior_kalkunfilet_naturell_palegg_thumb.png','food_image_a' => 'prior_kalkunfilet_naturell_palegg_a.png','food_image_b' => 'prior_kalkunfilet_naturell_palegg_b.png','food_image_c' => 'prior_kalkunfilet_palegg_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '86','food_user_id' => '0','food_name' => 'Kyllingfilet pålegg','food_clean_name' => 'kyllingfilet_plegg','food_manufacturer_name' => 'Solvinge','food_store' => '','food_description' => '','food_serving_size_gram' => '10','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'skive','food_energy' => '197','food_proteins' => '20.3','food_carbohydrates' => '2','food_fat' => '0.3','food_energy_calculated' => '20','food_proteins_calculated' => '2','food_carbohydrates_calculated' => '0','food_fat_calculated' => '0','food_barcode' => '7057370023989','food_category_id' => '52','food_image_path' => '_uploads/food/_img/no/2018/kyllingfilet_plegg','food_thumb' => '86_thumb.png','food_image_a' => '86_a.png','food_image_b' => '86_b.png','food_image_c' => 'solvinge_kyllingfilet_palegg_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '87','food_user_id' => '0','food_name' => 'Hapå','food_clean_name' => 'hap','food_manufacturer_name' => 'Kavli','food_store' => '','food_description' => '','food_serving_size_gram' => '30','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'pose','food_energy' => '314','food_proteins' => '7','food_carbohydrates' => '58','food_fat' => '6','food_energy_calculated' => '94','food_proteins_calculated' => '2','food_carbohydrates_calculated' => '17','food_fat_calculated' => '2','food_barcode' => '','food_category_id' => '57','food_image_path' => '_uploads/food/_img/no/2018/hap','food_thumb' => 'kavli_hapå_thumb.png','food_image_a' => 'kavli_hapå_a.png','food_image_b' => 'kavli_hapaa_b.jpg','food_image_c' => 'kavli_hapaa_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '88','food_user_id' => '0','food_name' => 'Bringebærsyltetøy','food_clean_name' => 'bringebrsyltety','food_manufacturer_name' => 'First Price','food_store' => '','food_description' => '','food_serving_size_gram' => '30','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'pose','food_energy' => '193','food_proteins' => '0.4','food_carbohydrates' => '46','food_fat' => '0.2','food_energy_calculated' => '58','food_proteins_calculated' => '0','food_carbohydrates_calculated' => '14','food_fat_calculated' => '0','food_barcode' => '','food_category_id' => '62','food_image_path' => '_uploads/food/_img/no/2018/bringebrsyltety','food_thumb' => '88_thumb.png','food_image_a' => '88_a.png','food_image_b' => '88_b.png','food_image_c' => 'first_price_bringaebaersyltetooy_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '89','food_user_id' => '0','food_name' => 'Heimefrå kirsebær','food_clean_name' => 'utvalde_kirsebr','food_manufacturer_name' => 'Lerums','food_store' => '','food_description' => '','food_serving_size_gram' => '30','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'pose','food_energy' => '159','food_proteins' => '0.3','food_carbohydrates' => '39','food_fat' => '0','food_energy_calculated' => '48','food_proteins_calculated' => '0','food_carbohydrates_calculated' => '12','food_fat_calculated' => '0','food_barcode' => '','food_category_id' => '62','food_image_path' => '_uploads/food/_img/no/2018/utvalde_kirsebr','food_thumb' => 'lerums_heimefrå_kirsebær_thumb.png','food_image_a' => 'lerums_heimefrå_kirsebær_a.png','food_image_b' => 'lerums_utvalde_kirsebear_b.jpg','food_image_c' => 'lerums_utvalde_kirsebear_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '90','food_user_id' => '0','food_name' => 'Nøttemiks','food_clean_name' => 'nttemiks','food_manufacturer_name' => 'First Price','food_store' => '','food_description' => '','food_serving_size_gram' => '600','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'pakke','food_energy' => '512','food_proteins' => '16.1','food_carbohydrates' => '37.1','food_fat' => '32.3','food_energy_calculated' => '3072','food_proteins_calculated' => '97','food_carbohydrates_calculated' => '223','food_fat_calculated' => '194','food_barcode' => '7311041048931','food_category_id' => '64','food_image_path' => '_uploads/food/_img/no/2018/nttemiks','food_thumb' => 'first_price_nøttemiks_thumb.png','food_image_a' => 'first_price_nøttemiks_a.png','food_image_b' => 'first_price_nøttemiks_b.png','food_image_c' => 'first_price_noottemiks_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '91','food_user_id' => '0','food_name' => 'Micropop','food_clean_name' => 'micropop','food_manufacturer_name' => 'Eldorado','food_store' => '','food_description' => '','food_serving_size_gram' => '100','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '389','food_proteins' => '7','food_carbohydrates' => '35','food_fat' => '19.1','food_energy_calculated' => '389','food_proteins_calculated' => '7','food_carbohydrates_calculated' => '35','food_fat_calculated' => '19','food_barcode' => '7035620022609','food_category_id' => '68','food_image_path' => '_uploads/food/_img/no/2018/micropop','food_thumb' => 'eldorado_micropop_thumb.png','food_image_a' => 'eldorado_micropop_a.png','food_image_b' => 'eldorado_micropop_b.png','food_image_c' => 'eldorado_micropop_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '92','food_user_id' => '0','food_name' => 'Sørlandschips Spansk paprika med persille','food_clean_name' => 'srlandschips_spansk_paprika_med_persille','food_manufacturer_name' => 'Snacks','food_store' => '','food_description' => '','food_serving_size_gram' => '200','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'pakke','food_energy' => '504','food_proteins' => '7','food_carbohydrates' => '58','food_fat' => '26','food_energy_calculated' => '1008','food_proteins_calculated' => '14','food_carbohydrates_calculated' => '116','food_fat_calculated' => '52','food_barcode' => '0','food_category_id' => '65','food_image_path' => '_uploads/food/_img/no/2018/srlandschips_spansk_paprika_med_persille','food_thumb' => '92_thumb.png','food_image_a' => '92_a.png','food_image_b' => 'soorlandschips_spansk_paprika_med_persille_b.jpg','food_image_c' => 'soorlandschips_spansk_paprika_med_persille_c.jpg','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => NULL),
  array('food_id' => '95','food_user_id' => '0','food_name' => 'Chili beans','food_clean_name' => 'chili_beans','food_manufacturer_name' => 'S&amp;W Fine Foods','food_store' => 'Meny','food_description' => '','food_serving_size_gram' => '439','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'boks','food_energy' => '113','food_proteins' => '5.4','food_carbohydrates' => '18','food_fat' => '1.1','food_energy_calculated' => '496','food_proteins_calculated' => '24','food_carbohydrates_calculated' => '79','food_fat_calculated' => '5','food_barcode' => '11194384487','food_category_id' => '25','food_image_path' => '_uploads/food/_img/no/2018/chili_beans','food_thumb' => 's_amp_w_fine_foods_chili_beans_thumb.png','food_image_a' => 's_amp_w_fine_foods_chili_beans_a.png','food_image_b' => 's_amp_w_fine_foods_chili_beans_b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-07 20:57:57'),
  array('food_id' => '96','food_user_id' => '0','food_name' => 'Kjøttdeig av storfe','food_clean_name' => 'kjøttdeig_av_storfe','food_manufacturer_name' => 'Coop','food_store' => 'Coop','food_description' => '14 % fett','food_serving_size_gram' => '200','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '0.5','food_serving_size_pcs_measurement' => 'pakke','food_energy' => '198','food_proteins' => '18','food_carbohydrates' => '0','food_fat' => '14','food_energy_calculated' => '396','food_proteins_calculated' => '36','food_carbohydrates_calculated' => '0','food_fat_calculated' => '28','food_barcode' => '7025110072160','food_category_id' => '33','food_image_path' => '_uploads/food/_img/no/2018/kjøttdeig_av_storfe','food_thumb' => 'coop_kjøttdeig_av_storfe_thumb.png','food_image_a' => 'coop_kjøttdeig_av_storfe_a.png','food_image_b' => 'coop_kjøttdeig_av_storfe_b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-07 21:03:31'),
  array('food_id' => '97','food_user_id' => '0','food_name' => 'Dolmio Bolognese','food_clean_name' => 'dolmio_bolognese','food_manufacturer_name' => 'Mars Norge AS','food_store' => 'Meny','food_description' => 'Smooth moste grønnsaker','food_serving_size_gram' => '250','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '0.5','food_serving_size_pcs_measurement' => 'boks','food_energy' => '48','food_proteins' => '1.4','food_carbohydrates' => '7.7','food_fat' => '0.8','food_energy_calculated' => '120','food_proteins_calculated' => '4','food_carbohydrates_calculated' => '19','food_fat_calculated' => '2','food_barcode' => '4002339004476','food_category_id' => '43','food_image_path' => '_uploads/food/_img/no/2018/dolmio_bolognese','food_thumb' => '97_thumb.png','food_image_a' => '97_a.png','food_image_b' => '97_b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-07 21:21:54'),
  array('food_id' => '98','food_user_id' => '0','food_name' => 'Boysenbær','food_clean_name' => 'boysenbær','food_manufacturer_name' => 'Coop','food_store' => 'Coop','food_description' => '','food_serving_size_gram' => '30','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'ss','food_energy' => '176','food_proteins' => '0.5','food_carbohydrates' => '42','food_fat' => '0.1','food_energy_calculated' => '53','food_proteins_calculated' => '0','food_carbohydrates_calculated' => '13','food_fat_calculated' => '0','food_barcode' => '','food_category_id' => '62','food_image_path' => '_uploads/food/_img/no/2018/boysenbær','food_thumb' => 'boysenbær_thumb.png','food_image_a' => 'boysenbær_a.png','food_image_b' => 'boysenbær_b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-08 18:42:29'),
  array('food_id' => '99','food_user_id' => '0','food_name' => 'Wok Saus Lemongras','food_clean_name' => 'wok_saus_lemongras','food_manufacturer_name' => 'Go Tan','food_store' => 'Rema 1000','food_description' => '2-3 porsjoner','food_serving_size_gram' => '120','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'pakke','food_energy' => '76','food_proteins' => '0.9','food_carbohydrates' => '12','food_fat' => '2.7','food_energy_calculated' => '91','food_proteins_calculated' => '1','food_carbohydrates_calculated' => '14','food_fat_calculated' => '3','food_barcode' => '8710605020236','food_category_id' => '43','food_image_path' => '_uploads/food/_img/no/2018/wok_saus_lemongras','food_thumb' => 'wok_saus_lemongras_thumb.png','food_image_a' => 'wok_saus_lemongras_a.png','food_image_b' => 'wok_saus_lemongras_b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-09 17:00:31'),
  array('food_id' => '100','food_user_id' => '0','food_name' => 'Kyllingfilet naturell smak','food_clean_name' => 'kyllingfilet_naturlig_smak','food_manufacturer_name' => 'Prior','food_store' => 'Meny','food_description' => '85 % filet','food_serving_size_gram' => '10','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'skive','food_energy' => '97','food_proteins' => '20','food_carbohydrates' => '2.1','food_fat' => '0.9','food_energy_calculated' => '10','food_proteins_calculated' => '2','food_carbohydrates_calculated' => '0','food_fat_calculated' => '0','food_barcode' => '','food_category_id' => '52','food_image_path' => '_uploads/food/_img/no/2018/prior_kyllingfilet_naturlig_smak','food_thumb' => 'kyllingfilet_naturlig_smak_thumb.png','food_image_a' => 'kyllingfilet_naturlig_smak_a.png','food_image_b' => 'kyllingfilet_naturlig_smak_b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-09 18:08:30'),
  array('food_id' => '101','food_user_id' => '0','food_name' => 'Tynnskåret svinefilet','food_clean_name' => 'tynnskåret_svinefilet','food_manufacturer_name' => 'Nordfjord','food_store' => 'Rema 1000','food_description' => 'En pakke inneholder 12 skiver. En pakke er 384 g.','food_serving_size_gram' => '32','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'skive','food_energy' => '110','food_proteins' => '24','food_carbohydrates' => '0','food_fat' => '1.8','food_energy_calculated' => '35','food_proteins_calculated' => '8','food_carbohydrates_calculated' => '0','food_fat_calculated' => '1','food_barcode' => '7024850084211','food_category_id' => '34','food_image_path' => '_uploads/food/_img/no/2018/nordfjord_tynnskåret_svinefilet','food_thumb' => 'tynnskåret_svinefilet_thumb.png','food_image_a' => 'tynnskåret_svinefilet_a.png','food_image_b' => 'tynnskåret_svinefilet_b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-09 18:34:15'),
  array('food_id' => '102','food_user_id' => '0','food_name' => 'Gresk yoghurt mango og pasjonsfrukt','food_clean_name' => 'gresk_yoghurt_mango_og_pasjonsfrukt','food_manufacturer_name' => 'Tine','food_store' => 'Rema 1000','food_description' => '90 kcal','food_serving_size_gram' => '160','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '56','food_proteins' => '8.2','food_carbohydrates' => '5.4','food_fat' => '0.2','food_energy_calculated' => '90','food_proteins_calculated' => '13','food_carbohydrates_calculated' => '9','food_fat_calculated' => '0','food_barcode' => '','food_category_id' => '47','food_image_path' => '_uploads/food/_img/no/2018/tine_gresk_yoghurt_mango_og_pasjonsfrukt','food_thumb' => 'gresk_yoghurt_mango_og_pasjonsfrukt_thumb.png','food_image_a' => 'gresk_yoghurt_mango_og_pasjonsfrukt_a.png','food_image_b' => 'gresk_yoghurt_mango_og_pasjonsfrukt_b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-09 22:38:27'),
  array('food_id' => '103','food_user_id' => '0','food_name' => 'Håndverker med gresskarkjerner','food_clean_name' => 'håndverker_med_gresskarkjerner','food_manufacturer_name' => 'Hatting','food_store' => 'Meny','food_description' => 'Det er 6 rundstykker i en pakke. En pakke er 438 gram og et rundstykke 73 g.','food_serving_size_gram' => '73','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '260','food_proteins' => '11','food_carbohydrates' => '37','food_fat' => '6','food_energy_calculated' => '190','food_proteins_calculated' => '8','food_carbohydrates_calculated' => '27','food_fat_calculated' => '4','food_barcode' => '5701014052881','food_category_id' => '4','food_image_path' => '_uploads/food/_img/no/2018/hatting_håndverker_med_gresskarkjerner','food_thumb' => 'håndverker_med_gresskarkjerner_thumb.png','food_image_a' => 'håndverker_med_gresskarkjerner_a.png','food_image_b' => 'håndverker_med_gresskarkjerner_b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-10 17:15:48'),
  array('food_id' => '104','food_user_id' => '0','food_name' => 'Licorice Original Soft &amp; Fresh','food_clean_name' => 'licorice_original_soft__amp__fresh','food_manufacturer_name' => 'Panda','food_store' => 'Meny','food_description' => 'En pakke er 200 g.','food_serving_size_gram' => '200','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'pakke','food_energy' => '327','food_proteins' => '3.5','food_carbohydrates' => '76','food_fat' => '0.4','food_energy_calculated' => '654','food_proteins_calculated' => '7','food_carbohydrates_calculated' => '152','food_fat_calculated' => '1','food_barcode' => '','food_category_id' => '67','food_image_path' => '_uploads/food/_img/no/2018/panda_licorice_original_soft__amp__fresh','food_thumb' => 'licorice_original_soft__amp__fresh_thumb.png','food_image_a' => 'licorice_original_soft__amp__fresh_a.png','food_image_b' => 'licorice_original_soft__amp__fresh_b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-10 17:35:53'),
  array('food_id' => '105','food_user_id' => '0','food_name' => 'Blåbærsyltetøy Naturlig Lett','food_clean_name' => 'blåbærsyltetøy_naturlig_lett','food_manufacturer_name' => 'Nora','food_store' => 'Meny','food_description' => 'Mer bær, mindre sukker. Ingen kunstig søtning.','food_serving_size_gram' => '30','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'ss','food_energy' => '138','food_proteins' => '0.5','food_carbohydrates' => '31','food_fat' => '0.5','food_energy_calculated' => '41','food_proteins_calculated' => '0','food_carbohydrates_calculated' => '9','food_fat_calculated' => '0','food_barcode' => '','food_category_id' => '62','food_image_path' => '_uploads/food/_img/no/2018/nora_blåbærsyltetøy_naturlig_lett','food_thumb' => 'blåbærsyltetøy_naturlig_lett_thumb.png','food_image_a' => 'blåbærsyltetøy_naturlig_lett_a.png','food_image_b' => 'blåbærsyltetøy_naturlig_lett_b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-10 17:49:59'),
  array('food_id' => '106','food_user_id' => '0','food_name' => 'Bifflapskaus','food_clean_name' => 'bifflapskaus','food_manufacturer_name' => 'Fjordland','food_store' => 'Coop Prix','food_description' => '','food_serving_size_gram' => '480','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'boks','food_energy' => '84','food_proteins' => '6.2','food_carbohydrates' => '8.8','food_fat' => '2.4','food_energy_calculated' => '403','food_proteins_calculated' => '30','food_carbohydrates_calculated' => '42','food_fat_calculated' => '12','food_barcode' => '','food_category_id' => '38','food_image_path' => '_uploads/food/_img/no/2018/fjordland_bifflapskaus','food_thumb' => 'bifflapskaus_thumb.png','food_image_a' => 'bifflapskaus_a.png','food_image_b' => 'bifflapskaus_b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-10 17:54:18'),
  array('food_id' => '107','food_user_id' => '0','food_name' => 'BBQ Kyllinglår','food_clean_name' => 'bbq_kyllinglår','food_manufacturer_name' => 'Dansk Kylling','food_store' => 'Coop Prix','food_description' => 'BBQ Kyllingelår. Kyllingunder- og overlår med ryggben. Tilstatt vann.  En pakke er 1100 g. Et lår veier 200 g.','food_serving_size_gram' => '200','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '150','food_proteins' => '15','food_carbohydrates' => '0.6','food_fat' => '9.4','food_energy_calculated' => '300','food_proteins_calculated' => '30','food_carbohydrates_calculated' => '1','food_fat_calculated' => '19','food_barcode' => '5760725200479','food_category_id' => '35','food_image_path' => '_uploads/food/_img/no/2018/dansk_kylling_bbq_kyllinglår','food_thumb' => 'bbq_kyllinglår_thumb.png','food_image_a' => 'bbq_kyllinglår_a.png','food_image_b' => 'bbq_kyllinglår_b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-10 17:57:33'),
  array('food_id' => '108','food_user_id' => '0','food_name' => 'Bønner i tomatsaus','food_clean_name' => 'bønner_i_tomatsaus','food_manufacturer_name' => 'Xtra','food_store' => 'Coop Prix','food_description' => 'En boks er 420g.','food_serving_size_gram' => '420','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'boks','food_energy' => '105','food_proteins' => '4.1','food_carbohydrates' => '18','food_fat' => '0.5','food_energy_calculated' => '441','food_proteins_calculated' => '17','food_carbohydrates_calculated' => '76','food_fat_calculated' => '2','food_barcode' => '7340011340041','food_category_id' => '25','food_image_path' => '_uploads/food/_img/no/2018/xtra_bønner_i_tomatsaus','food_thumb' => 'bønner_i_tomatsaus_thumb.png','food_image_a' => 'bønner_i_tomatsaus_a.png','food_image_b' => 'bønner_i_tomatsaus_b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-10 18:26:16'),
  array('food_id' => '109','food_user_id' => '0','food_name' => 'Brokkoliblanding med brokkoli, gulrot og blomkål','food_clean_name' => 'brokkoliblanding_med_brokkoli__gulrot_og_blomkål','food_manufacturer_name' => 'Coop','food_store' => 'Coop Prix','food_description' => 'En pakke inneholder 500 g.','food_serving_size_gram' => '250','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '0.5','food_serving_size_pcs_measurement' => 'pakke','food_energy' => '26','food_proteins' => '1.9','food_carbohydrates' => '4.2','food_fat' => '0.1','food_energy_calculated' => '65','food_proteins_calculated' => '5','food_carbohydrates_calculated' => '11','food_fat_calculated' => '0','food_barcode' => '','food_category_id' => '22','food_image_path' => '_uploads/food/_img/no/2018/coop_brokkoliblanding_med_brokkoli__gulrot_og_blomkål','food_thumb' => 'coop_brokkoliblanding_med_brokkoli__thumb.png','food_image_a' => 'coop_brokkoliblanding_med_brokkoli__a.png','food_image_b' => 'coop_brokkoliblanding_med_brokkoli__b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-10 22:20:15'),
  array('food_id' => '110','food_user_id' => '0','food_name' => 'Frukt til smoothie','food_clean_name' => 'frukt_til_smoothie','food_manufacturer_name' => 'Coop','food_store' => 'Coop Pix','food_description' => 'Jordbær, banan og blåbær. En pakke er 4x150 g, totalt 600g.','food_serving_size_gram' => '150','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'pose','food_energy' => '51','food_proteins' => '0.7','food_carbohydrates' => '11','food_fat' => '0','food_energy_calculated' => '77','food_proteins_calculated' => '1','food_carbohydrates_calculated' => '17','food_fat_calculated' => '0','food_barcode' => '','food_category_id' => '22','food_image_path' => '_uploads/food/_img/no/2018/coop_frukt_til_smoothie','food_thumb' => 'frukt_til_smoothie_thumb.png','food_image_a' => 'coop_frukt_til_smoothie_a.png','food_image_b' => 'coop_frukt_til_smoothie_b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-11 18:17:47'),
  array('food_id' => '111','food_user_id' => '0','food_name' => 'Jordbærsyltetøy','food_clean_name' => 'jordbærsyltetøy','food_manufacturer_name' => 'Rema 1000','food_store' => 'Rema 1000','food_description' => '40 % bær.','food_serving_size_gram' => '30','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'ss','food_energy' => '183','food_proteins' => '0.5','food_carbohydrates' => '45','food_fat' => '0.5','food_energy_calculated' => '55','food_proteins_calculated' => '0','food_carbohydrates_calculated' => '14','food_fat_calculated' => '0','food_barcode' => '7040280016325','food_category_id' => '62','food_image_path' => '_uploads/food/_img/no/2018/rema_1000_jordbærsyltetøy','food_thumb' => 'jordbærsyltetøy_thumb.png','food_image_a' => 'rema_1000_jordbærsyltetøy_a.png','food_image_b' => 'rema_1000_jordbærsyltetøy_b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-11 18:23:25'),
  array('food_id' => '112','food_user_id' => '0','food_name' => 'Eple og pæresyltetøy','food_clean_name' => 'eple_og_pæresyltetøy','food_manufacturer_name' => 'Lerum','food_store' => 'Kiwi','food_description' => '45 % eple og 35 % pære. 80 g frukt pr 100 g. Et glass veier 330 g.','food_serving_size_gram' => '30','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'ss','food_energy' => '61','food_proteins' => '0.3','food_carbohydrates' => '16.7','food_fat' => '0.1','food_energy_calculated' => '18','food_proteins_calculated' => '0','food_carbohydrates_calculated' => '5','food_fat_calculated' => '0','food_barcode' => '','food_category_id' => '62','food_image_path' => '_uploads/food/_img/no/2018/lerum_eple_og_pæresyltetøy','food_thumb' => 'eple_og_pæresyltetøy_thumb.png','food_image_a' => 'lerum_eple_og_pæresyltetøy_a.png','food_image_b' => 'lerum_eple_og_pæresyltetøy_b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-11 18:28:19'),
  array('food_id' => '113','food_user_id' => '0','food_name' => 'Go Morgen Zero Blåbær- og tranebæryoghurt med muslikrønsj','food_clean_name' => 'go_morgen_zero_blåbær-_og_tranebæryoghurt_med_muslikrønsj','food_manufacturer_name' => 'Tine','food_store' => 'Kiwi','food_description' => 'Søtet med søtstoff. Helt uten tilsatt sukker.','food_serving_size_gram' => '190','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '101','food_proteins' => '4.6','food_carbohydrates' => '11','food_fat' => '4.3','food_energy_calculated' => '192','food_proteins_calculated' => '9','food_carbohydrates_calculated' => '21','food_fat_calculated' => '8','food_barcode' => '7038010054358','food_category_id' => '47','food_image_path' => '_uploads/food/_img/no/2018/tine_go_morgen_zero_blåbær-_og_tranebæryoghurt_med_muslikrønsj','food_thumb' => 'go_morgen_zero_blåbær-_og_tranebæryoghurt_med_muslikrønsj_thumb.png','food_image_a' => 'tine_go_morgen_zero_blåbær-_og_tranebæryoghurt_med_muslikrønsj_a.png','food_image_b' => 'tine_go_morgen_zero_blåbær-_og_tranebæryoghurt_med_muslikrønsj_b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-11 18:31:54'),
  array('food_id' => '114','food_user_id' => '0','food_name' => 'Påskeegg','food_clean_name' => 'påskeegg','food_manufacturer_name' => 'Freia','food_store' => 'Kiwi','food_description' => '4 stk sjokoladeegg fylt med melkekrem. Ett egg veier 34g. 4 egg veier 136g.','food_serving_size_gram' => '136','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '4','food_serving_size_pcs_measurement' => 'stk','food_energy' => '193','food_proteins' => '2.3','food_carbohydrates' => '18','food_fat' => '12.5','food_energy_calculated' => '262','food_proteins_calculated' => '3','food_carbohydrates_calculated' => '24','food_fat_calculated' => '17','food_barcode' => '7040110642106','food_category_id' => '66','food_image_path' => '_uploads/food/_img/no/2018/freia_påskeegg','food_thumb' => 'påskeegg_thumb.png','food_image_a' => 'freia_påskeegg_a.png','food_image_b' => 'freia_påskeegg_b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-11 18:37:15'),
  array('food_id' => '115','food_user_id' => '0','food_name' => 'Andebryst','food_clean_name' => 'andebryst','food_manufacturer_name' => 'Möllers','food_store' => 'Color Line','food_description' => 'Dypfrosset vakumpakket andebryst. Veier 300 g.','food_serving_size_gram' => '300','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '118','food_proteins' => '19.9','food_carbohydrates' => '0','food_fat' => '4.3','food_energy_calculated' => '354','food_proteins_calculated' => '60','food_carbohydrates_calculated' => '0','food_fat_calculated' => '13','food_barcode' => '5707735004932','food_category_id' => '35','food_image_path' => '_uploads/food/_img/no/2018/mampersandouml_llers_andebryst','food_thumb' => 'mampersandouml_llers_andebryst_thumb.png','food_image_a' => 'mampersandouml_llers_andebryst_a.png','food_image_b' => 'mampersandouml_llers_andebryst_b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-11 18:42:15'),
  array('food_id' => '116','food_user_id' => '0','food_name' => 'Aspargesbønner','food_clean_name' => 'aspargesbønner','food_manufacturer_name' => 'Rema 1000','food_store' => 'Rema 1000','food_description' => 'En pakke inneholder 300 g.','food_serving_size_gram' => '150','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '0.5','food_serving_size_pcs_measurement' => 'pakke','food_energy' => '28','food_proteins' => '0','food_carbohydrates' => '0.1','food_fat' => '0.5','food_energy_calculated' => '42','food_proteins_calculated' => '0','food_carbohydrates_calculated' => '0','food_fat_calculated' => '1','food_barcode' => '7032069718865','food_category_id' => '22','food_image_path' => '_uploads/food/_img/no/2018/rema_1000_aspargesbønner','food_thumb' => 'aspargesbønner_thumb.png','food_image_a' => 'rema_1000_aspargesbønner_a.png','food_image_b' => 'rema_1000_aspargesbønner_b.png','food_image_c' => 'rema_1000_aspargesbønner_c.png','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-11 19:12:15'),
  array('food_id' => '117','food_user_id' => '0','food_name' => 'Mexican Potetchips','food_clean_name' => 'mexican_potetchips','food_manufacturer_name' => 'Bondens','food_store' => 'Rema 1000','food_description' => 'Sørlandschips.','food_serving_size_gram' => '200','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'pakke','food_energy' => '507','food_proteins' => '5.5','food_carbohydrates' => '51','food_fat' => '30','food_energy_calculated' => '1014','food_proteins_calculated' => '11','food_carbohydrates_calculated' => '102','food_fat_calculated' => '60','food_barcode' => '7071688000029','food_category_id' => '65','food_image_path' => '_uploads/food/_img/no/2018/bondens_mexican_potetchips','food_thumb' => 'mexican_potetchips_thumb.png','food_image_a' => 'bondens_mexican_potetchips_a.png','food_image_b' => 'bondens_mexican_potetchips_b.png','food_image_c' => 'bondens_mexican_potetchips_c.png','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-11 19:19:45'),
  array('food_id' => '118','food_user_id' => '0','food_name' => 'Kesam mager vanlije','food_clean_name' => 'kesam_mager_vanlije','food_manufacturer_name' => 'Tine','food_store' => 'Rema 1000','food_description' => '0,9 % fett. Rik på proteiner. Et beger er 420 g.','food_serving_size_gram' => '210','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '0.5','food_serving_size_pcs_measurement' => 'stk','food_energy' => '88','food_proteins' => '11','food_carbohydrates' => '8.9','food_fat' => '0.9','food_energy_calculated' => '185','food_proteins_calculated' => '23','food_carbohydrates_calculated' => '19','food_fat_calculated' => '2','food_barcode' => '7038010055843','food_category_id' => '47','food_image_path' => '_uploads/food/_img/no/2018/tine_kesam_mager_vanlije','food_thumb' => 'kesam_mager_vanlije_thumb.png','food_image_a' => 'tine_kesam_mager_vanlije_a.png','food_image_b' => 'tine_kesam_mager_vanlije_b.png','food_image_c' => 'tine_kesam_mager_vanlije_c.png','food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-11 19:23:22'),
  array('food_id' => '119','food_user_id' => '0','food_name' => 'Multigrain','food_clean_name' => 'multigrain','food_manufacturer_name' => 'Ryvita','food_store' => 'Rema 1000','food_description' => 'En pakke inneholder 250g. Et knekkebrød veier 11 g.','food_serving_size_gram' => '11','food_serving_size_gram_measurement' => 'g','food_serving_size_pcs' => '1','food_serving_size_pcs_measurement' => 'stk','food_energy' => '370','food_proteins' => '11.2','food_carbohydrates' => '56','food_fat' => '7.2','food_energy_calculated' => '41','food_proteins_calculated' => '1','food_carbohydrates_calculated' => '6','food_fat_calculated' => '1','food_barcode' => '5010265002072','food_category_id' => '5','food_image_path' => '_uploads/food/_img/no/2018/ryvita_multigrain','food_thumb' => 'multigrain_thumb.png','food_image_a' => 'ryvita_multigrain_a.png','food_image_b' => 'ryvita_multigrain_b.png','food_image_c' => NULL,'food_image_d' => NULL,'food_image_e' => NULL,'food_last_used' => NULL,'food_language' => 'no','food_synchronized' => NULL,'food_accepted_as_master' => NULL,'food_notes' => 'Started on 2018-01-11 19:31:45')
);



		foreach($stram_diet_food as $v){
			
			$food_id = $v["food_id"];

			$food_name = $v["food_name"];
			//$food_name = fix_local($food_name);

			$food_clean_name = $v["food_clean_name"];

			$food_manufacturer_name = $v["food_manufacturer_name"];
			//$food_manufacturer_name = fix_local($food_manufacturer_name);

			$food_store = $v["food_store"];

			$food_description = $v["food_description"];
			//$food_description = fix_local($food_description);

			$food_serving_size_gram = $v["food_serving_size_gram"];
			$food_serving_size_gram_measurement = $v["food_serving_size_gram_measurement"];
			$food_serving_size_pcs = $v["food_serving_size_pcs"];
			$food_serving_size_pcs_measurement = $v["food_serving_size_pcs_measurement"];

			$food_energy = $v["food_energy"];
			$food_proteins = $v["food_proteins"];
			$food_carbohydrates = $v["food_carbohydrates"];
			$food_fat = $v["food_fat"];

			$food_energy_calculated = $v["food_energy_calculated"];
			$food_proteins_calculated = $v["food_proteins_calculated"];
			$food_carbohydrates_calculated = $v["food_carbohydrates_calculated"];
			$food_fat_calculated = $v["food_fat_calculated"];

			$food_user_id = $v["food_user_id"];
			$food_barcode = $v["food_barcode"];
			$food_category_id = $v["food_category_id"];

			$food_image_path = $v["food_image_path"];
			$food_thumb = $v["food_thumb"];
			$food_image_a = $v["food_image_a"];
			$food_image_b = $v["food_image_b"];
			$food_image_c = $v["food_image_c"];
			$food_image_d = $v["food_image_d"];
			$food_image_e = $v["food_image_e"];
			$food_language = $v["food_language"];



			mysqli_query($link, "INSERT INTO $t_diet_food
			(food_id, food_name, food_clean_name, food_manufacturer_name, food_store, food_description, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, 
			food_energy, food_proteins, food_carbohydrates, food_fat, 
			food_energy_calculated, food_proteins_calculated, food_carbohydrates_calculated, food_fat_calculated, 
			food_user_id, food_barcode, food_category_id, food_image_path, food_thumb, 
			food_image_a, food_image_b, food_image_c, food_image_d, food_image_e, food_language) 
			VALUES 
			(NULL, '$food_name', '$food_clean_name', '$food_manufacturer_name', '$food_store', '$food_description', '$food_serving_size_gram', '$food_serving_size_gram_measurement', '$food_serving_size_pcs', '$food_serving_size_pcs_measurement',
			'$food_energy', '$food_proteins', '$food_carbohydrates', '$food_fat', 
			'$food_energy_calculated', '$food_proteins_calculated', '$food_carbohydrates_calculated', '$food_fat_calculated',
			'$food_user_id', '$food_barcode', '$food_category_id', '$food_image_path', '$food_thumb', 
			'$food_image_a', '$food_image_b', '$food_image_c', '$food_image_d', '$food_image_e', '$food_language')
			")
			or die(mysqli_error($link));


		}




	}
	echo"
	<!-- //diet_food -->
	

	<!-- diet_measurements -->
	";

	
	$query = "SELECT * FROM $t_diet_measurements";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_diet_measurements: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_diet_measurements(
	  	 measurement_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(measurement_id), 
	  	   measurement_name VARCHAR(50), 
	  	   measurement_last_updated DATETIME)")
		   or die(mysqli_error());


		// En
		$inp_measurement_last_updated = date("Y-m-d H:i:s");
		mysqli_query($link, "INSERT INTO $t_diet_measurements
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

	<!-- diet_measurements translations -->
	";
	$query = "SELECT * FROM $t_diet_measurements_translations";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_diet_measurements_translations: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_diet_measurements_translations(
	  	measurement_translation_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(measurement_translation_id), 
	  	   measurement_id INT, 
	  	   measurement_translation_language VARCHAR(250), 
	  	   measurement_translation_value VARCHAR(250), 
	  	   measurement_translation_last_updated DATETIME)")
		   or die(mysqli_error());


$nettport_diet_measurements_translations = array(
  array('measurement_translation_id' => '1','measurement_id' => '1','measurement_translation_language' => 'en','measurement_translation_value' => 'bag','measurement_translation_last_updated' => '2018-01-03 14:40:49'),
  array('measurement_translation_id' => '2','measurement_id' => '2','measurement_translation_language' => 'en','measurement_translation_value' => 'bowl','measurement_translation_last_updated' => '2018-01-03 14:40:49'),
  array('measurement_translation_id' => '3','measurement_id' => '3','measurement_translation_language' => 'en','measurement_translation_value' => 'box','measurement_translation_last_updated' => '2018-01-03 14:40:49'),
  array('measurement_translation_id' => '4','measurement_id' => '4','measurement_translation_language' => 'en','measurement_translation_value' => 'handful','measurement_translation_last_updated' => '2018-01-03 14:40:49'),
  array('measurement_translation_id' => '5','measurement_id' => '5','measurement_translation_language' => 'en','measurement_translation_value' => 'package','measurement_translation_last_updated' => '2018-01-03 14:40:49'),
  array('measurement_translation_id' => '6','measurement_id' => '6','measurement_translation_language' => 'en','measurement_translation_value' => 'piece','measurement_translation_last_updated' => '2018-01-03 14:40:49'),
  array('measurement_translation_id' => '7','measurement_id' => '7','measurement_translation_language' => 'en','measurement_translation_value' => 'pizza','measurement_translation_last_updated' => '2018-01-03 14:40:49'),
  array('measurement_translation_id' => '8','measurement_id' => '8','measurement_translation_language' => 'en','measurement_translation_value' => 'slice','measurement_translation_last_updated' => '2018-01-03 14:40:49'),
  array('measurement_translation_id' => '9','measurement_id' => '9','measurement_translation_language' => 'en','measurement_translation_value' => 'spoon','measurement_translation_last_updated' => '2018-01-03 14:40:49'),
  array('measurement_translation_id' => '10','measurement_id' => '10','measurement_translation_language' => 'en','measurement_translation_value' => 'teaspoon','measurement_translation_last_updated' => '2018-01-03 14:40:49'),
  array('measurement_translation_id' => '11','measurement_id' => '11','measurement_translation_language' => 'en','measurement_translation_value' => 'tablespoon','measurement_translation_last_updated' => '2018-01-03 14:40:49'),
  array('measurement_translation_id' => '12','measurement_id' => '1','measurement_translation_language' => 'no','measurement_translation_value' => 'pose','measurement_translation_last_updated' => NULL),
  array('measurement_translation_id' => '13','measurement_id' => '2','measurement_translation_language' => 'no','measurement_translation_value' => 'bolle','measurement_translation_last_updated' => NULL),
  array('measurement_translation_id' => '14','measurement_id' => '3','measurement_translation_language' => 'no','measurement_translation_value' => 'boks','measurement_translation_last_updated' => NULL),
  array('measurement_translation_id' => '15','measurement_id' => '4','measurement_translation_language' => 'no','measurement_translation_value' => 'hÃ¥ndfull','measurement_translation_last_updated' => NULL),
  array('measurement_translation_id' => '16','measurement_id' => '5','measurement_translation_language' => 'no','measurement_translation_value' => 'pakke','measurement_translation_last_updated' => NULL),
  array('measurement_translation_id' => '17','measurement_id' => '6','measurement_translation_language' => 'no','measurement_translation_value' => 'stk','measurement_translation_last_updated' => NULL),
  array('measurement_translation_id' => '18','measurement_id' => '7','measurement_translation_language' => 'no','measurement_translation_value' => 'pizza','measurement_translation_last_updated' => NULL),
  array('measurement_translation_id' => '19','measurement_id' => '8','measurement_translation_language' => 'no','measurement_translation_value' => 'skive','measurement_translation_last_updated' => NULL),
  array('measurement_translation_id' => '20','measurement_id' => '9','measurement_translation_language' => 'no','measurement_translation_value' => 'skje','measurement_translation_last_updated' => NULL),
  array('measurement_translation_id' => '21','measurement_id' => '10','measurement_translation_language' => 'no','measurement_translation_value' => 'ts','measurement_translation_last_updated' => NULL),
  array('measurement_translation_id' => '22','measurement_id' => '11','measurement_translation_language' => 'no','measurement_translation_value' => 'ss','measurement_translation_last_updated' => NULL)
);

		$inp_date = date("Y-m-d H:i:s");
		foreach($nettport_diet_measurements_translations as $v){
			
			$measurement_id = $v["measurement_id"];
			$measurement_translation_language = $v["measurement_translation_language"];
			$measurement_translation_value = $v["measurement_translation_value"];
		
			mysqli_query($link, "INSERT INTO $t_diet_measurements_translations
			(measurement_translation_id, measurement_id, measurement_translation_language, measurement_translation_value, measurement_translation_last_updated) 
			VALUES 
			(NULL, '$measurement_id', '$measurement_translation_language', '$measurement_translation_value', '$inp_date')
			")
			or die(mysqli_error($link));


		}


	}
	echo"
	<!-- //diet_measurements -->

	<!-- diet_food_favorites -->
	";
	$query = "SELECT * FROM $t_diet_food_favorites";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_diet_food_favorites: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_diet_food_favorites(
	  	food_favorite_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(food_favorite_id), 
	  	   food_favorite_food_id INT, 
	  	   food_favorite_user_id INT,
	  	   food_favorite_comment VARCHAR(250))")
		   or die(mysqli_error());

	}
	echo"
	<!-- //diet_food_favorites -->

	";
?>