<?php
/**
*
* File: _admin/_inc/food/_liquibase/food/categories.php
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

$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_food_categories") or die(mysqli_error($link)); 


echo"


	<!-- food_categories -->
	";

	
	$query = "SELECT * FROM $t_food_categories";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_food_categories: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_food_categories(
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



		mysqli_query($link, "INSERT INTO $t_food_categories
		(`category_id`, `category_user_id`, `category_name`, `category_age_restriction`, `category_parent_id`, `category_icon`, `category_last_updated`, `category_note`) 
		VALUES 
(1, 0, 'Bread and cereal', 0, 0, '', '2018-09-11 08:28:01', '\n\r\n'),
(2, 0, 'Bread', 0, 1, '', '2018-09-11 08:28:01', '\n\r\n'),
(3, 0, 'Cereals', 0, 1, '', '2018-09-11 08:28:01', '\n\r\n'),
(4, 0, 'Frozen bread and rolls', 0, 1, '', '2018-09-11 08:28:01', '\n\r\n'),
(5, 0, 'Crispbread', 0, 1, '', '2018-09-11 08:28:01', '\n\r\n'),
(6, 0, 'Sausage bread and lumps', 0, 1, '', '2018-09-11 08:28:01', '\n\r\n'),
(7, 0, 'Dessert and baking', 0, 0, '', '2018-09-11 08:28:01', '\n\r\n'),
(8, 0, 'Baking', 0, 7, '', '2018-09-11 08:28:01', '\n\r\n'),
(9, 0, 'Biscuit', 0, 7, '', '2018-09-11 08:28:01', '\n\r\n'),
(10, 0, 'Cakes', 0, 7, '', '2018-09-11 08:28:01', '\n\r\n'),
(11, 0, 'Buns', 0, 7, '', '2018-09-11 08:28:01', '\n\r\n'),
(12, 0, 'Single ice cream', 0, 63, '', '2018-09-11 08:28:01', '\n\r\n'),
(13, 0, 'Drink', 0, 0, '', '2018-09-11 08:28:01', '\n\r\n'),
(14, 0, 'Soda', 0, 13, '', '2018-09-11 08:28:01', '\n\r\n'),
(15, 0, 'Water and mineral water', 0, 13, '', '2018-09-11 08:28:01', '\n\r\n'),
(16, 0, 'Juice', 0, 13, '', '2018-09-11 08:28:01', '\n\r\n'),
(17, 0, 'Smoothie', 0, 13, '', '2018-09-11 08:28:01', '\n\r\n'),
(18, 0, 'Lemonade', 0, 13, '', '2018-09-11 08:28:01', '\n\r\n'),
(19, 0, 'Coffee, tea and cocoa', 0, 13, '', '2018-09-11 08:28:01', '\n\r\n'),
(20, 0, 'Energy drink', 0, 13, '', '2018-09-11 08:28:01', '\n\r\n'),
(21, 0, 'Fruits and vegetables', 0, 0, '', '2018-09-11 08:28:01', '\n\r\n'),
(22, 0, 'Frozen vegetables', 0, 21, '', '2018-09-11 08:28:01', '\n\r\n'),
(23, 0, 'Fruit', 0, 21, '', '2018-09-11 08:28:01', '\n\r\n'),
(24, 0, 'Vegetables', 0, 21, '', '2018-09-11 08:28:01', '\n\r\n'),
(25, 0, 'Canned fruits and vegetables', 0, 21, '', '2018-09-11 08:28:01', '\n\r\n'),
(26, 0, 'Salads', 0, 21, '', '2018-09-11 08:28:01', '\n\r\n'),
(27, 0, 'Health', 0, 0, '', '2018-09-11 08:28:01', '\n\r\n'),
(28, 0, 'Protein bars', 0, 27, '', '2018-09-11 08:28:01', '\n\r\n'),
(29, 0, 'Protein powder', 0, 27, '', '2018-09-11 08:28:01', '\n\r\n'),
(30, 0, 'Meal substitutes', 0, 27, '', '2018-09-11 08:28:01', '\n\r\n'),
(31, 0, 'Other health products', 0, 27, '', '2018-09-11 08:28:01', '\n\r\n'),
(32, 0, 'Dinnar', 0, 0, '', '2018-09-11 08:28:01', '\n\r\n'),
(33, 0, 'Cattle and sheep', 0, 32, '', '2018-09-11 08:28:01', '\n\r\n'),
(34, 0, 'Pork and bacon', 0, 32, '', '2018-09-11 08:28:01', '\n\r\n'),
(35, 0, 'Chicken, turkey and duck', 0, 32, '', '2018-09-11 08:28:01', '\n\r\n'),
(36, 0, 'Meat replacement', 0, 32, '', '2018-09-11 08:28:01', '\n\r\n'),
(37, 0, 'Seafood', 0, 32, '', '2018-09-11 08:28:01', '\n\r\n'),
(38, 0, 'Ready meals', 0, 32, '', '2018-09-11 08:28:01', '\n\r\n'),
(39, 0, 'Pizza', 0, 32, '', '2018-09-11 08:28:01', '\n\r\n'),
(40, 0, 'Pasta, rice and noodle', 0, 32, '', '2018-09-11 08:28:01', '\n\r\n'),
(41, 0, 'Taco Sauce', 0, 32, '', '2018-09-11 08:28:01', '\n\r\n'),
(42, 0, 'Soups', 0, 32, '', '2018-09-11 08:28:01', '\n\r\n'),
(43, 0, 'Sauces', 0, 32, '', '2018-09-11 08:28:01', '\n\r\n'),
(44, 0, 'Dairy, cheese and eggs', 0, 0, '', '2018-09-11 08:28:01', '\n\r\n'),
(45, 0, 'Egg', 0, 44, '', '2018-09-11 08:28:01', '\n\r\n'),
(46, 0, 'Cream and sour cream', 0, 44, '', '2018-09-11 08:28:01', '\n\r\n'),
(47, 0, 'Yogurt', 0, 44, '', '2018-09-11 08:28:01', '\n\r\n'),
(48, 0, 'Milk', 0, 44, '', '2018-09-11 08:28:01', '\n\r\n'),
(49, 0, 'Butter and margarine', 0, 44, '', '2018-09-11 08:28:01', '\n\r\n'),
(50, 0, 'Cheese', 0, 44, '', '2018-09-11 08:28:01', '\n\r\n'),
(51, 0, 'Sandwich toppings', 0, 0, '', '2018-09-11 08:28:01', '\n\r\n'),
(52, 0, 'Meat and chicken toppings', 0, 51, '', '2018-09-11 08:28:01', '\n\r\n'),
(53, 0, 'Bacon and salami', 0, 51, '', '2018-09-11 08:28:01', '\n\r\n'),
(54, 0, 'Liver', 0, 51, '', '2018-09-11 08:28:01', '\n\r\n'),
(55, 0, 'Salad toppings', 0, 51, '', '2018-09-11 08:28:01', '\n\r\n'),
(56, 0, 'Fish spread', 0, 51, '', '2018-09-11 08:28:01', '\n\r\n'),
(57, 0, 'Sweet spreads', 0, 51, '', '2018-09-11 08:28:01', '\n\r\n'),
(58, 0, 'Mayonnaise', 0, 51, '', '2018-09-11 08:28:01', '\n\r\n'),
(59, 0, 'Tube spread', 0, 51, '', '2018-09-11 08:28:01', '\n\r\n'),
(60, 0, 'Cheese for sandwich', 0, 51, '', '2018-09-11 08:28:01', '\n\r\n'),
(61, 0, 'Other toppings', 0, 51, '', '2018-09-11 08:28:01', '\n\r\n'),
(62, 0, 'Jam', 0, 51, '', '2018-09-11 08:28:01', '\n\r\n'),
(63, 0, 'Snacks', 0, 0, '', '2018-09-11 08:28:01', '\n\r\n'),
(64, 0, 'Nuts', 0, 63, '', '2018-09-11 08:28:01', '\n\r\n'),
(65, 0, 'Potato chips', 0, 63, '', '2018-09-11 08:28:01', '\n\r\n'),
(66, 0, 'Chocolate', 0, 63, '', '2018-09-11 08:28:01', '\n\r\n'),
(67, 0, 'Sweets', 0, 63, '', '2018-09-11 08:28:01', '\n\r\n'),
(68, 0, 'Other snacks', 0, 63, '', '2018-09-11 08:28:01', '\n\r\n'),
(69, 0, 'Fries', 0, 32, '', '2018-09-11 08:28:01', 'Created 2018-08-05 16:27:09\n\r\n'),
(70, 0, 'Canned ice cream', 0, 63, '', '2018-09-11 08:28:01', 'Created 2018-08-05 16:28:28\n\r\n'),
(71, 0, 'Taco tortillas', 0, 32, '', '2018-09-11 08:28:01', 'Created 2018-08-05 17:02:08\n\r\n'),
(72, 0, 'Taco spices', 0, 32, '', '2018-09-11 08:28:01', 'Created 2018-08-05 17:04:04\n\r\n'),
(73, 0, 'Frozen fruits', 0, 21, '', '2018-09-11 08:28:01', 'Created 2018-08-11 19:15:41\n\r\n'),
(74, 0, 'Dining accessories', 0, 32, '', '2019-11-06 21:36:18', 'Created 2019-05-25 14:45:14\n\r\n'),
(75, 0, 'Oil and spices', 0, 0, '', '2019-11-06 21:36:18', 'Created 2019-05-25 14:49:36\n\r\n'),
(76, 0, 'Ketchup and mustard', 0, 75, '', '2019-11-06 21:36:18', 'Created 2019-05-25 14:50:01\n\r\n'),
(77, 0, 'Oils and vinegar', 0, 75, '', '2019-11-06 21:36:18', 'Created 2019-05-25 14:50:16\n\r\n'),
(78, 0, 'Dressing', 0, 75, '', '2019-11-06 21:36:18', 'Created 2019-05-25 14:50:29\n\r\n'),
(79, 0, 'Spices', 0, 75, '', '2019-11-06 21:36:18', 'Created 2019-05-25 14:50:38\n\r\n'),
(80, 0, 'Broth and fund', 0, 75, '', '2019-11-06 21:36:18', 'Created 2019-05-25 14:51:05\n\r\n'),
(81, 0, 'Protein pudding', NULL, 27, NULL, NULL, 'Created 2020-10-19 16:58:32'),
(82, 0, 'Fresh baked goods', NULL, 1, NULL, NULL, 'Created 2020-10-19 18:15:54'),
(83, 0, 'Half-baked bread and baguettes', NULL, 1, NULL, NULL, 'Created 2020-10-20 17:37:26')
			")
			or die(mysqli_error($link));



		mysqli_query($link, "ALTER TABLE $t_food_categories MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84")or die(mysqli_error($link));




		/*- Original --------------------------------------------------------------------------- */
		/*
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
				mysqli_query($link, "INSERT INTO $t_food_categories
				(category_id, category_user_id, category_name, category_parent_id) 
				VALUES 
				(NULL, '0', $inp_name_mysql, '0')") or die(mysqli_error($link));

				$query = "SELECT category_id FROM $t_food_categories WHERE category_name='$category_parent_name[$x]'";
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

					mysqli_query($link, "INSERT INTO $t_food_categories
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
		*/
	}
	echo"
	<!-- //food_categories -->

";
?>