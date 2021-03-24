<?php
/**
*
* File: _admin/_inc/exercises/_liquibase/index.php
* Version 1.0.0
* Date 12:57 24.03.2021
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

$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_exercise_tags_cloud") or die(mysqli_error($link)); 


echo"

	<!-- exercise_tags_cloud -->
	";
	$query = "SELECT * FROM $t_exercise_tags_cloud";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_exercise_tags_cloud: $row_cnt</p>
		";
	}
	else{

		mysqli_query($link, "CREATE TABLE $t_exercise_tags_cloud(
	  	 cloud_id INT NOT NULL AUTO_INCREMENT,
	 	  PRIMARY KEY(cloud_id), 
	  	   cloud_language VARCHAR(20),
	  	   cloud_text VARCHAR(20),
	  	   cloud_clean VARCHAR(200),
	  	   cloud_occurrences INT)")
		   or die(mysqli_error());
	}
	echo"
	<!-- //exercise_tags_cloud -->

";
?>