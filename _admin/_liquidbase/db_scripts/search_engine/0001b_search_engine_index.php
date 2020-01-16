<?php
if(isset($_SESSION['admin_user_id'])){
	$t_search_engine_index 		= $mysqlPrefixSav . "search_engine_index";
	$t_search_engine_access_control = $mysqlPrefixSav . "search_engine_access_control";


	mysqli_query($link,"DROP TABLE IF EXISTS $t_search_engine_index") or die(mysqli_error());
	mysqli_query($link,"DROP TABLE IF EXISTS $t_search_engine_access_control") or die(mysqli_error());


	mysqli_query($link, "CREATE TABLE $t_search_engine_index(
			   index_id INT NOT NULL AUTO_INCREMENT,
			   PRIMARY KEY(index_id), 
			   index_title VARCHAR(200),
			   index_url VARCHAR(200),
			   index_short_description TEXT,
			   index_keywords VARCHAR(250),
			   index_module_name VARCHAR(200),
			   index_module_part_name VARCHAR(200),
			   index_reference_id VARCHAR(200),
			   index_has_access_control INT,
			   index_is_ad INT,
			   index_created_datetime DATETIME,
			   index_created_datetime_print VARCHAR(200),
			   index_updated_datetime DATETIME,
			   index_updated_datetime_print VARCHAR(200),
			   index_language VARCHAR(6),
			   index_unique_hits INT,
			   index_hits_ipblock TEXT
			   )")
			   or die(mysqli_error($link));

	mysqli_query($link, "CREATE TABLE $t_search_engine_access_control(
			   control_id INT NOT NULL AUTO_INCREMENT,
			   PRIMARY KEY(control_id), 
			   control_user_id INT,
			   control_user_name VARCHAR(200),
			   control_has_access_to_module_name VARCHAR(200),
			   control_has_access_to_module_part_name VARCHAR(200),
			   control_created_datetime DATETIME,
			   control_created_datetime_print VARCHAR(200),
			   control_updated_datetime DATETIME,
			   control_updated_datetime_print VARCHAR(200)
			   )")
			   or die(mysqli_error($link));


}
?>