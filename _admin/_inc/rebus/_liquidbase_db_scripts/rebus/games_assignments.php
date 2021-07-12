<?php
/**
*
* File: _admin/_inc/rebus/_liquibase/rebus/games_assignments.php
* Version 1.0.0
* Date 07:23 01.07.2021
* Copyright (c) 2021 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Tables ---------------------------------------------------------------------------- */

$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_rebus_games_assignments") or die(mysqli_error($link)); 

echo"
<!-- games_assignments -->
";

$query = "SELECT * FROM $t_rebus_games_assignments LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_rebus_games_assignments: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_rebus_games_assignments(
	  assignment_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(assignment_id), 
	   assignment_game_id INT, 
	   assignment_number INT,
	   assignment_type VARCHAR(200),
	   assignment_value TEXT,
	   assignment_address VARCHAR(200),
	   assignment_video_embedded TEXT,
	   assignment_answer_a VARCHAR(200),
	   assignment_answer_a_clean VARCHAR(200),
	   assignment_answer_b VARCHAR(200),
	   assignment_answer_b_clean VARCHAR(200),
	   assignment_radius INT,
	   assignment_hint VARCHAR(200),
	   assignment_points INT,
	   assignment_text_when_correct_answer TEXT,
	   assignment_time_to_solve_seconds INT,
	   assignment_time_to_solve_saying VARCHAR(20),
	   assignment_created_by_user_id INT,
	   assignment_created_by_ip VARCHAR(200),
	   assignment_created_datetime DATETIME,
	   assignment_updated_by_user_id INT,
	   assignment_updated_by_ip VARCHAR(200),
	   assignment_updated_datetime DATETIME
	   )")
	   or die(mysqli_error());


}
echo"
<!-- //games_assignments -->

";
?>