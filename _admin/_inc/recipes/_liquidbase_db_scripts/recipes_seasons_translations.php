<?php
/**
*
* File: _admin/_inc/recipes/_liquidbase_db_scripts/recipes_seasons_translations.php
* Version 1.0.0
* Date 17:21 31.12.2020
* Copyright (c) 2020 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

echo"
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


";
?>