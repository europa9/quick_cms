<?php
/**
*
* File: _admin/_inc/workout_diary/tables.php
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
$t_workout_diary_entries 	= $mysqlPrefixSav . "workout_diary_entries";
$t_workout_diary_plans 		= $mysqlPrefixSav . "workout_diary_plans";


echo"
<h1>Tables</h1>



	<!-- $t_workout_diary_entries -->
	";
	$query = "SELECT * FROM $t_workout_diary_entries";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_workout_diary_entries: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_workout_diary_entries(
	  	 workout_diary_entry_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(workout_diary_entry_id), 
	  	   workout_diary_entry_user_id INT,
		   workout_diary_entry_session_id INT,
		   workout_diary_entry_session_main_id INT,
		   workout_diary_entry_date DATE,
		   workout_diary_entry_year INT,
		   workout_diary_entry_month INT,
		   workout_diary_entry_day INT,
		   workout_diary_entry_week INT,
		   workout_diary_entry_exercise_id INT,
		   workout_diary_entry_exercise_title VARCHAR(250),
		   workout_diary_entry_measurement VARCHAR(250),
		   workout_diary_entry_set_a_weight INT,
		   workout_diary_entry_set_a_reps INT,
		   workout_diary_entry_set_b_weight INT,
		   workout_diary_entry_set_b_reps INT,
		   workout_diary_entry_set_c_weight INT,
		   workout_diary_entry_set_c_reps INT,
		   workout_diary_entry_set_d_weight INT,
		   workout_diary_entry_set_d_reps INT,
		   workout_diary_entry_set_e_weight INT,
		   workout_diary_entry_set_e_reps INT,
		   workout_diary_entry_set_avg_weight INT,
		   workout_diary_entry_set_avg_reps INT,
		   workout_diary_entry_velocity_a double,
		   workout_diary_entry_velocity_b double,
		   workout_diary_entry_velocity_measurement VARCHAR(250),
		   workout_diary_entry_distance INT,
		   workout_diary_entry_distance_measurement VARCHAR(250),
		   workout_diary_entry_duration_hh INT,
		   workout_diary_entry_duration_mm INT,
		   workout_diary_entry_duration_ss INT,
		   workout_diary_entry_notes TEXT)")
		   or die(mysqli_error());
	}
	echo"
	<!-- //diary s -->


	<!-- $t_workout_diary_plans -->
	";
	$query = "SELECT * FROM $t_workout_diary_plans";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_workout_diary_plans: $row_cnt</p>
		";
	}
	else{


		mysqli_query($link, "CREATE TABLE $t_workout_diary_plans(
	  	 workout_diary_plan_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(workout_diary_plan_id), 
	  	   workout_diary_plan_user_id INT,
		   workout_diary_plan_weight INT,
	  	   workout_diary_plan_period_id INT,
	  	   workout_diary_plan_session_id INT,
	  	   workout_diary_plan_weekly_id INT,
	  	   workout_diary_plan_yearly_id INT,
	  	   workout_diary_plan_title VARCHAR(200),
	  	   workout_diary_plan_date DATE,
	  	   workout_diary_plan_notes TEXT)")
		   or die(mysqli_error());
	}
	echo"
	<!-- //workout_diary_plans -->


	";
?>