<?php
/**
*
* File: _admin/_inc/food_diary/tables.php
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

$t_food_diary_goals 	  	= $mysqlPrefixSav . "food_diary_goals";
$t_food_diary_entires	  	= $mysqlPrefixSav . "food_diary_entires";
$t_food_diary_totals_meals  	= $mysqlPrefixSav . "food_diary_totals_meals";
$t_food_diary_totals_days  	= $mysqlPrefixSav . "food_diary_totals_days";
$t_food_diary_last_used  	= $mysqlPrefixSav . "food_diary_last_used";

echo"
<h1>Tables</h1>


	<!-- diet_goal -->
	";
	$query = "SELECT * FROM $t_food_diary_goals";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_food_diary_goals: $row_cnt</p>
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


		mysqli_query($link, "CREATE TABLE $t_food_diary_goals(
	  	 goal_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(goal_id), 
	  	   goal_user_id INT,
	  	   goal_current_weight INT,
	  	   goal_current_fat_percentage INT,
	  	   goal_target_weight INT,
	  	   goal_target_fat_percentage INT,
	  	   goal_i_want_to VARCHAR(50),
	  	   goal_weekly_goal VARCHAR(50),
	  	   goal_date DATE,
	  	   goal_activity_level DOUBLE,
	  	   goal_current_bmi INT,
	  	   goal_target_bmi INT,
	  	   goal_current_bmr_calories INT,
	  	   goal_current_bmr_fat INT,
	  	   goal_current_bmr_carbs INT,
	  	   goal_current_bmr_proteins INT,
	  	   goal_current_sedentary_calories INT,
	  	   goal_current_sedentary_fat INT,
	  	   goal_current_sedentary_carbs INT,
	  	   goal_current_sedentary_proteins INT,
	  	   goal_current_with_activity_calories INT,
	  	   goal_current_with_activity_fat INT,
	  	   goal_current_with_activity_carbs INT,
	  	   goal_current_with_activity_proteins INT,
	  	   goal_target_bmr_calories INT,
	  	   goal_target_bmr_fat INT,
	  	   goal_target_bmr_carbs INT,
	  	   goal_target_bmr_proteins INT,
	  	   goal_target_sedentary_calories INT,
	  	   goal_target_sedentary_fat INT,
	  	   goal_target_sedentary_carbs INT,
	  	   goal_target_sedentary_proteins INT,
	  	   goal_target_with_activity_calories INT,
	  	   goal_target_with_activity_fat INT,
	  	   goal_target_with_activity_carbs INT,
	  	   goal_target_with_activity_proteins INT,
	  	   goal_updated DATETIME,
	  	   goal_synchronized VARCHAR(50),
	  	   goal_notes VARCHAR(50))")
		   or die(mysqli_error());

	}
	echo"
	<!-- //diet_goal -->



	<!-- food_diary_entires -->
	";
	$query = "SELECT * FROM $t_food_diary_entires";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_food_diary_entires: $row_cnt</p>
		";
	}
	else{
		
		mysqli_query($link, "CREATE TABLE $t_food_diary_entires(
	  	 entry_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(entry_id), 
	  	   entry_user_id INT,
	  	   entry_date DATE,
	  	   entry_meal_id INT,
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
	  	   entry_text TEXT,
	  	   entry_deleted INT,
	  	   entry_updated DATETIME,
	  	   entry_synchronized VARCHAR(50))")
		   or die(mysqli_error());

	}
	echo"
	<!-- //food_diary_entires -->


	<!-- food_diary_totals_meals -->
	";
	$query = "SELECT * FROM $t_food_diary_totals_meals";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_food_diary_totals_meals: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_food_diary_totals_meals(
	  	 total_meal_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(total_meal_id), 
	  	   total_meal_user_id INT,
	  	   total_meal_date DATE,
	  	   total_meal_meal_id INT,
	  	   total_meal_energy DOUBLE,
	  	   total_meal_fat DOUBLE,
	  	   total_meal_carb DOUBLE,
	  	   total_meal_protein DOUBLE,
	  	   total_meal_updated DATETIME,
	  	   total_meal_synchronized VARCHAR(50))")
		   or die(mysqli_error());
	}
	echo"
	<!-- //food_diary_entires -->

	<!-- food_diary_totals_days -->
	";
	$query = "SELECT * FROM $t_food_diary_totals_days";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_food_diary_totals_days: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_food_diary_totals_days(
	  	 total_day_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(total_day_id), 
	  	   total_day_user_id INT,
	  	   total_day_date DATE,
	  	   total_day_consumed_energy DOUBLE,
	  	   total_day_consumed_fat DOUBLE,
	  	   total_day_consumed_carb DOUBLE,
	  	   total_day_consumed_protein DOUBLE,
	  	   total_day_target_sedentary_energy DOUBLE,
	  	   total_day_target_sedentary_fat DOUBLE,
	  	   total_day_target_sedentary_carb DOUBLE,
	  	   total_day_target_sedentary_protein DOUBLE,
	  	   total_day_target_with_activity_energy DOUBLE,
	  	   total_day_target_with_activity_fat DOUBLE,
	  	   total_day_target_with_activity_carb DOUBLE,
	  	   total_day_target_with_activity_protein DOUBLE,
	  	   total_day_diff_sedentary_energy DOUBLE,
	  	   total_day_diff_sedentary_fat DOUBLE,
	  	   total_day_diff_sedentary_carb DOUBLE,
	  	   total_day_diff_sedentary_protein DOUBLE,
	  	   total_day_diff_with_activity_energy DOUBLE,
	  	   total_day_diff_with_activity_fat DOUBLE,
	  	   total_day_diff_with_activity_carb DOUBLE,
	  	   total_day_diff_with_activity_protein DOUBLE,
		   total_day_updated DATETIME,
	  	   total_day_synchronized VARCHAR(50))")
		   or die(mysqli_error());
	}
	echo"
	<!-- //food_diary_entires -->


	<!-- food_diary_last_used_food -->
	";
	$query = "SELECT * FROM $t_food_diary_last_used";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_food_diary_last_used: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_food_diary_last_used(
	  	 last_used_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(last_used_id), 
	  	   last_used_user_id INT,
	  	   last_used_day_of_week INT,
	  	   last_used_meal_id INT,
	  	   last_used_food_id INT,
	  	   last_used_recipe_id INT,
	  	   last_used_serving_size DOUBLE,
	  	   last_used_times INT,
	  	   last_used_date DATE,
	  	   last_used_updated DATETIME,
	  	   last_used_synchronized VARCHAR(50),
	  	   last_used_name VARCHAR(200),
	  	   last_used_manufacturer VARCHAR(200),
	  	   last_used_image_path VARCHAR(200),
	  	   last_used_image_thumb VARCHAR(200),

	  	   last_used_net_content DOUBLE,
	  	   last_used_net_content_measurement VARCHAR(50),
	  	   last_used_serving_size_gram DOUBLE,
	  	   last_used_serving_size_gram_measurement VARCHAR(50),
	  	   last_used_serving_size_pcs DOUBLE,
	  	   last_used_serving_size_pcs_measurement VARCHAR(50),

	  	   last_used_calories_per_hundred INT,
	  	   last_used_fat_per_hundred INT,
	  	   last_used_saturated_fatty_acids_per_hundred INT,
	  	   last_used_carbs_per_hundred INT,
	  	   last_used_sugar_per_hundred INT,
	  	   last_used_proteins_per_hundred INT,
	  	   last_used_salt_per_hundred INT,

	  	   last_used_calories_per_serving INT,
	  	   last_used_fat_per_serving INT,
	  	   last_used_saturated_fatty_acids_per_serving INT,
	  	   last_used_carbs_per_serving INT,
	  	   last_used_sugar_per_serving INT,
	  	   last_used_proteins_per_serving INT,
	  	   last_used_salt_per_serving INT)")
		   or die(mysqli_error());
	}
	echo"
	<!-- //food_diary_last_used_food -->

	
	";
?>