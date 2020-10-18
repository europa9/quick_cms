<?php
/**
*
* File: _admin/_inc/food/_liquibase/food/measurements_translations.php
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

$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_food_measurements_translations") or die(mysqli_error($link)); 


echo"


	<!-- food_measurements translations -->
	";
	$query = "SELECT * FROM $t_food_measurements_translations";
	$result = mysqli_query($link, $query);
	if($result !== FALSE){
		// Count rows
		$row_cnt = mysqli_num_rows($result);
		echo"
		<p>$t_food_measurements_translations: $row_cnt</p>
		";
	}
	else{
		mysqli_query($link, "CREATE TABLE $t_food_measurements_translations(
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
		
			mysqli_query($link, "INSERT INTO $t_food_measurements_translations
			(measurement_translation_id, measurement_id, measurement_translation_language, measurement_translation_value, measurement_translation_last_updated) 
			VALUES 
			(NULL, '$measurement_id', '$measurement_translation_language', '$measurement_translation_value', '$inp_date')
			")
			or die(mysqli_error($link));


		}


	}
	echo"
	<!-- //food_measurements -->
";
?>