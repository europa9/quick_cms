<?php
if(isset($_SESSION['admin_user_id'])){
	// Navigation
	$t_navigation = $mysqlPrefixSav . "navigation";

	mysqli_query($link,"DROP TABLE IF EXISTS $t_navigation") or die(mysqli_error());

	mysqli_query($link, "CREATE TABLE $t_navigation(
	   navigation_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(navigation_id), 
 	   navigation_parent_id INT,
 	   navigation_title VARCHAR(120),
 	   navigation_title_clean VARCHAR(120),
 	   navigation_url VARCHAR(120),
 	   navigation_url_path VARCHAR(120),
 	   navigation_url_query VARCHAR(120),
 	   navigation_language VARCHAR(120),
 	   navigation_internal_or_external VARCHAR(50),
 	   navigation_weight INT,
 	   navigation_created DATE,
 	   navigation_created_by_user_id INT,
 	   navigation_updated DATE,
 	   navigation_updated_by_user_id INT)")
	   or die(mysqli_error($link));

}
?>