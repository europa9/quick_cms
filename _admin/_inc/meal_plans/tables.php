<?php
/**
*
* File: _admin/_inc/meal_plans/tables.php
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
	$value = str_replace("Ã¸", "�", $value);
	$value = str_replace("Ã¥", "�", $value);

        return $value;
}
function fix_local($value){
	$value = htmlentities($value);

        return $value;
}
/*- Tables ---------------------------------------------------------------------------- */
$t_meal_plans 		= $mysqlPrefixSav . "meal_plans";
$t_meal_plans_days	= $mysqlPrefixSav . "meal_plans_days";
$t_meal_plans_meals	= $mysqlPrefixSav . "meal_plans_meals";
$t_meal_plans_entries	= $mysqlPrefixSav . "meal_plans_entries";

echo"
<h1>Tables</h1>


	<!-- meal_plans -->
	";
	$query = "SELECT * FROM $t_meal_plans";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_meal_plans: $row_cnt</p>
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


		mysqli_query($link, "CREATE TABLE $t_meal_plans(
	  	 meal_plan_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(meal_plan_id), 
	  	   meal_plan_user_id INT,
	  	   meal_plan_language VARCHAR(50),
	  	   meal_plan_title VARCHAR(250),
	  	   meal_plan_title_clean VARCHAR(250),
	  	   meal_plan_number_of_days INT,
	  	   meal_plan_introduction TEXT,

	  	   meal_plan_total_energy_without_training INT,
	  	   meal_plan_total_fat_without_training INT,
	  	   meal_plan_total_carb_without_training INT,
	  	   meal_plan_total_protein_without_training INT,

	  	   meal_plan_total_energy_with_training INT,
	  	   meal_plan_total_fat_with_training INT,
	  	   meal_plan_total_carb_with_training INT,
	  	   meal_plan_total_protein_with_training INT,

	  	   meal_plan_average_kcal_without_training INT,
	  	   meal_plan_average_fat_without_training INT,
	  	   meal_plan_average_carb_without_training INT,
	  	   meal_plan_average_protein_without_training INT,

	  	   meal_plan_average_kcal_with_training INT,
	  	   meal_plan_average_fat_with_training INT,
	  	   meal_plan_average_carb_with_training INT,
	  	   meal_plan_average_protein_with_training INT,

	  	   meal_plan_created DATETIME,
	  	   meal_plan_updated DATETIME,
	  	   meal_plan_user_ip VARCHAR(250),
	  	   meal_plan_image_path VARCHAR(250),
	  	   meal_plan_image_thumb VARCHAR(250),
	  	   meal_plan_image_file VARCHAR(250),
	  	   meal_plan_views INT,
	  	   meal_plan_views_ip_block TEXT,
	  	   meal_plan_likes INT,
	  	   meal_plan_dislikes INT,
	  	   meal_plan_rating INT,
	  	   meal_plan_rating_ip_block TEXT,
	  	   meal_plan_comments INT)")
		   or die(mysqli_error());

	}
	echo"
	<!-- //meal_plans -->

	<!-- meal_plans_days -->
	";
	$query = "SELECT * FROM $t_meal_plans_days";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_meal_plans_days: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_meal_plans_days(
	  	 day_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(day_id), 
	  	   day_meal_plan_id INT,
	  	   day_number INT,

	  	   day_energy_without_training DOUBLE,
	  	   day_fat_without_training DOUBLE,
	  	   day_carb_without_training DOUBLE,
	  	   day_protein_without_training DOUBLE,

	  	   day_sum_without_training DOUBLE,
	  	   day_fat_without_training_percentage INT,
	  	   day_carb_without_training_percentage INT,
	  	   day_protein_without_training_percentage INT,

	  	   day_energy_with_training DOUBLE,
	  	   day_fat_with_training DOUBLE,
	  	   day_carb_with_training DOUBLE,
	  	   day_protein_with_training DOUBLE,

	  	   day_sum_with_training DOUBLE,
	  	   day_fat_with_training_percentage INT,
	  	   day_carb_with_training_percentage INT,
	  	   day_protein_with_training_percentage INT)")
		   or die(mysqli_error());

	}
	echo"
	<!-- //meal_plans_days -->

	<!-- meal_plans_meals -->
	";
	$query = "SELECT * FROM $t_meal_plans_meals";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_meal_plans_meals: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_meal_plans_meals(
	  	 meal_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(meal_id), 
	  	   meal_meal_plan_id INT,
	  	   meal_day_number INT,
	  	   meal_number INT,
	  	   meal_energy DOUBLE,
	  	   meal_fat DOUBLE,
	  	   meal_carb DOUBLE,
	  	   meal_protein DOUBLE)")
		   or die(mysqli_error());

	}
	echo"
	<!-- //meal_plans_days -->


	<!-- meal_plans_entries -->
	";
	$query = "SELECT * FROM $t_meal_plans_entries";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_meal_plans_entries: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_meal_plans_entries(
	  	 entry_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(entry_id), 
	  	   entry_meal_plan_id INT,
	  	   entry_day_number INT,
	  	   entry_meal_number INT,
	  	   entry_weight INT,
	  	   entry_food_id INT,
	  	   entry_recipe_id INT,
	  	   entry_name VARCHAR(250),
	  	   entry_manufacturer_name VARCHAR(250),
	  	   entry_serving_size DOUBLE,
	  	   entry_serving_size_measurement VARCHAR(250),
	  	   entry_energy_per_entry DOUBLE,
	  	   entry_fat_per_entry DOUBLE,
	  	   entry_carb_per_entry DOUBLE,
	  	   entry_protein_per_entry DOUBLE,
	  	   entry_text TEXT)")
		   or die(mysqli_error());

	}
	echo"
	<!-- //meal_plans_entries -->

	";
?>