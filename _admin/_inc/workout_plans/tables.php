<?php
/**
*
* File: _admin/_inc/workout_plans/tables.php
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
$t_workout_plans_yearly  		= $mysqlPrefixSav . "workout_plans_yearly";
$t_workout_plans_period  		= $mysqlPrefixSav . "workout_plans_period";
$t_workout_plans_weekly  		= $mysqlPrefixSav . "workout_plans_weekly";
$t_workout_plans_weekly_tags  		= $mysqlPrefixSav . "workout_plans_weekly_tags";
$t_workout_plans_weekly_tags_unique  	= $mysqlPrefixSav . "workout_plans_weekly_tags_unique";
$t_workout_plans_sessions 		= $mysqlPrefixSav . "workout_plans_sessions";
$t_workout_plans_sessions_main 		= $mysqlPrefixSav . "workout_plans_sessions_main";
$t_workout_plans_favorites 		= $mysqlPrefixSav . "workout_plans_favorites";


echo"
<h1>Tables</h1>



	<!-- $t_workout_plans_yearly -->
	";
	$query = "SELECT * FROM $t_workout_plans_yearly";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_workout_plans_yearly: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_workout_plans_yearly(
	  	 workout_yearly_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(workout_yearly_id), 
	  	   workout_yearly_user_id INT,
	  	   workout_yearly_weight INT,
		   workout_yearly_language VARCHAR(20),
	  	   workout_yearly_title VARCHAR(250),
	  	   workout_yearly_title_clean VARCHAR(250),
	  	   workout_yearly_introduction TEXT,
	  	   workout_yearly_goal TEXT,
	  	   workout_yearly_text TEXT,
	  	   workout_yearly_year INT,
	  	   workout_yearly_image_path VARCHAR(250),
	  	   workout_yearly_image_file VARCHAR(250),
	  	   workout_yearly_created DATETIME,
	  	   workout_yearly_updated DATETIME,
	  	   workout_yearly_unique_hits INT,
	  	   workout_yearly_unique_hits_ip_block TEXT,
	  	   workout_yearly_comments INT,
	  	   workout_yearly_likes INT,
	  	   workout_yearly_dislikes INT,
	  	   workout_yearly_rating INT,
	  	   workout_yearly_ip_block TEXT,
		   workout_yearly_user_ip VARCHAR(250),
	  	   workout_yearly_notes TEXT)")
		   or die(mysqli_error());
	}
	echo"
	<!-- //$t_workout_plans_yearly -->

	<!-- $t_workout_plans_period -->
	";
	$query = "SELECT * FROM $t_workout_plans_period";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_workout_plans_period: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_workout_plans_period(
	  	 workout_period_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(workout_period_id), 
	  	   workout_period_user_id INT,
	  	   workout_period_yearly_id INT,
	  	   workout_period_weight INT,
		   workout_period_language VARCHAR(20),
	  	   workout_period_title VARCHAR(250),
	  	   workout_period_title_clean VARCHAR(250),
	  	   workout_period_introduction TEXT,
	  	   workout_period_goal TEXT,
	  	   workout_period_text TEXT,
	  	   workout_period_from VARCHAR(200),
	  	   workout_period_to VARCHAR(200),
	  	   workout_period_image_path VARCHAR(250),
	  	   workout_period_image_file VARCHAR(250),
	  	   workout_period_created DATETIME,
	  	   workout_period_updated DATETIME,
	  	   workout_period_unique_hits INT,
	  	   workout_period_unique_hits_ip_block TEXT,
	  	   workout_period_comments INT,
	  	   workout_period_likes INT,
	  	   workout_period_dislikes INT,
	  	   workout_period_rating INT,
	  	   workout_period_ip_block TEXT,
		   workout_period_user_ip VARCHAR(250),
	  	   workout_period_notes TEXT)")
		   or die(mysqli_error());
	}
	echo"
	<!-- //$t_workout_plans_period -->

	<!-- workout_weekly_plans -->
	";
	$query = "SELECT * FROM $t_workout_plans_weekly";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_workout_plans_weekly: $row_cnt</p>
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

		mysqli_query($link, "CREATE TABLE $t_workout_plans_weekly(
	  	 workout_weekly_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(workout_weekly_id), 
	  	   workout_weekly_user_id INT,
	  	   workout_weekly_period_id INT,
	  	   workout_weekly_weight INT,
		   workout_weekly_language VARCHAR(20),
	  	   workout_weekly_title VARCHAR(250),
	  	   workout_weekly_title_clean VARCHAR(250),
	  	   workout_weekly_introduction TEXT,
	  	   workout_weekly_goal TEXT,
	  	   workout_weekly_image_path VARCHAR(250),
	  	   workout_weekly_image_thumb_medium VARCHAR(250),
	  	   workout_weekly_image_thumb_big VARCHAR(250),
	  	   workout_weekly_image_file VARCHAR(250),
	  	   workout_weekly_created DATETIME,
	  	   workout_weekly_updated DATETIME,
	  	   workout_weekly_unique_hits INT,
	  	   workout_weekly_unique_hits_ip_block TEXT,
	  	   workout_weekly_comments INT,
	  	   workout_weekly_likes INT,
	  	   workout_weekly_dislikes INT,
	  	   workout_weekly_rating INT,
	  	   workout_weekly_ip_block TEXT,
		   workout_weekly_user_ip VARCHAR(250),
	  	   workout_weekly_notes TEXT,
	  	   workout_weekly_number_of_sessions INT)")
		   or die(mysqli_error());

		$date = date("Y-m-d");
		$datetime = date("Y-m-d H:i:s");
		mysqli_query($link, "INSERT INTO $t_workout_plans_weekly
		(workout_weekly_id, workout_weekly_user_id, workout_weekly_language, workout_weekly_title, workout_weekly_introduction, workout_weekly_goal, workout_weekly_created, workout_weekly_updated, workout_weekly_unique_hits, workout_weekly_unique_hits_ip_block, workout_weekly_comments, workout_weekly_likes, workout_weekly_dislikes, workout_weekly_rating, workout_weekly_ip_block, workout_weekly_user_ip, workout_weekly_notes) 
		VALUES 
		(NULL, '1', 'en', '7 days strenght training', 'Here is a 7 day strenght training plan to increase muscle strenght', 'Increase muscle strenght', '$datetime', '$datetime', '0', '', '0', '0', '0', '0', '', '', '')")
		or die(mysqli_error($link));
	}
	echo"
	<!-- //workout_weekly -->




	<!-- workout_plans_weekly_tags -->
	";
	$query = "SELECT * FROM $t_workout_plans_weekly_tags";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_workout_plans_weekly_tags: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_workout_plans_weekly_tags(
	  	 tag_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(tag_id), 
	  	   tag_weekly_id INT,
		   tag_language VARCHAR(250),
	  	   tag_title VARCHAR(250),
	  	   tag_title_clean VARCHAR(250),
	  	   tag_user_id INT)")
		   or die(mysqli_error());
	}
	echo"
	<!-- //workout_plans_weekly_tags -->

	<!-- workout_plans_weekly_tags_unique -->
	";
	$query = "SELECT * FROM $t_workout_plans_weekly_tags_unique";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_workout_plans_weekly_tags_unique: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_workout_plans_weekly_tags_unique(
	  	 tag_unique_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(tag_unique_id), 
		   tag_unique_language VARCHAR(250),
	  	   tag_unique_title VARCHAR(250),
	  	   tag_unique_title_clean VARCHAR(250),
	  	   tag_unique_no_of_workout_plans INT,
	  	   tag_unique_hits INT,
	  	   tag_unique_hits_ipblock TEXT)")
		   or die(mysqli_error());
	}
	echo"
	<!-- //workout_plans_weekly_tags_unique -->


	<!-- session_plans -->
	";
	$query = "SELECT * FROM $t_workout_plans_sessions";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_workout_plans_sessions: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_workout_plans_sessions(
	  	 workout_session_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(workout_session_id), 
	  	   workout_session_user_id INT,
		   workout_session_weekly_id INT,
	  	   workout_session_weight INT,
	  	   workout_session_title VARCHAR(250),
	  	   workout_session_title_clean VARCHAR(250),
	  	   workout_session_duration VARCHAR(250),
	  	   workout_session_intensity VARCHAR(250),
	  	   workout_session_goal TEXT,
	  	   workout_session_warmup TEXT,
	  	   workout_session_end TEXT)")
		   or die(mysqli_error());
	}
	echo"
	<!-- //session_plans -->

	<!-- workout_plans_sessions_main -->
	";
	$query = "SELECT * FROM $t_workout_plans_sessions_main";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_workout_plans_sessions_main: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_workout_plans_sessions_main(
	  	 workout_session_main_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(workout_session_main_id), 
	  	   workout_session_main_user_id INT,
		   workout_session_main_session_id INT,
	  	   workout_session_main_weight INT,
	  	   workout_session_main_exercise_id INT,
	  	   workout_session_main_exercise_title VARCHAR(250),
	  	   workout_session_main_reps INT,
	  	   workout_session_main_sets INT,
	  	   workout_session_main_velocity_a double,
	  	   workout_session_main_velocity_b double,
	  	   workout_session_main_distance INT,
	  	   workout_session_main_duration INT,
	  	   workout_session_main_intensity INT,
	  	   workout_session_main_text TEXT)")
		   or die(mysqli_error());
	}
	echo"
	<!-- //workout_plans_sessions_main -->



	<!-- workout_plans_favorites -->
	";
	$query = "SELECT * FROM $t_workout_plans_favorites";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_workout_plans_favorites: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_workout_plans_favorites(
	  	 workout_plan_favorite_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(workout_plan_favorite_id), 
	  	   workout_plan_favorite_user_id INT,
		   workout_plan_favorite_weight INT,
	  	   workout_plan_favorite_period_id INT,
	  	   workout_plan_favorite_session_id INT,
	  	   workout_plan_favorite_weekly_id INT,
	  	   workout_plan_favorite_yearly_id INT,
	  	   workout_plan_favorite_title VARCHAR(200),
	  	   workout_plan_favorite_date DATE,
	  	   workout_plan_favorite_notes TEXT)")
		   or die(mysqli_error());
	}
	echo"
	<!-- //workout_plans_favorites -->


	";
?>