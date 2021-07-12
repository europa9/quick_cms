<?php
/**
*
* File: _admin/_inc/rebus/_liquibase/rebus/games_index.php
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

$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_rebus_games_index") or die(mysqli_error($link)); 


echo"
<!-- games_index -->
";

$query = "SELECT * FROM $t_rebus_games_index LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_rebus_games_index: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_rebus_games_index(
	  game_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(game_id), 
	   game_title VARCHAR(250), 
	   game_language VARCHAR(2), 
	   game_introduction TEXT, 
	   game_description TEXT, 
	   game_privacy VARCHAR(20),
	   game_published INT, 
	   game_playable_after_datetime DATETIME,
	   game_playable_after_datetime_saying VARCHAR(50),
	   game_playable_after_time VARCHAR(50),
	   game_group_id INT,
	   game_group_name VARCHAR(200),
	   game_times_played INT, 
	   game_times_finished INT, 
	   game_finished_percentage INT, 
	   game_time_used_seconds INT,
	   game_time_used_saying VARCHAR(20),
	   game_image_path VARCHAR(200),
	   game_image_file VARCHAR(200),
	   game_image_thumb_570x321 VARCHAR(200),
	   game_image_thumb_278x156 VARCHAR(200),
	   game_country_id INT,
	   game_country_name VARCHAR(200),
	   game_county_id INT,
	   game_county_name VARCHAR(200),
	   game_municipality_id INT,
	   game_municipality_name VARCHAR(200),
	   game_city_id INT,
	   game_city_name VARCHAR(200),
	   game_place_id INT,
	   game_place_name VARCHAR(200),
	   game_number_of_assignments INT,
	   game_created_by_user_id INT,
	   game_created_by_user_name VARCHAR(200),
	   game_created_by_user_email VARCHAR(200), 
	   game_created_by_ip VARCHAR(200), 
	   game_created_by_hostname VARCHAR(200), 
	   game_created_by_user_agent VARCHAR(200), 
	   game_created_datetime DATETIME, 
	   game_created_date_saying VARCHAR(50),
	   game_updated_by_user_id INT,
	   game_updated_by_user_name VARCHAR(200),
	   game_updated_by_user_email VARCHAR(200), 
	   game_updated_by_ip VARCHAR(200), 
	   game_updated_by_hostname VARCHAR(200), 
	   game_updated_by_user_agent VARCHAR(200), 
	   game_updated_datetime DATETIME, 
	   game_updated_date_saying VARCHAR(50)
	   )")
	   or die(mysqli_error());


}
echo"
<!-- //games_index -->

";
?>