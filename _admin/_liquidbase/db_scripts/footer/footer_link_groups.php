<?php
if(isset($_SESSION['admin_user_id'])){
	$t_footer_link_groups = $mysqlPrefixSav . "footer_link_groups";

	mysqli_query($link,"DROP TABLE IF EXISTS $t_footer_link_groups") or die(mysqli_error());

	mysqli_query($link, "CREATE TABLE $t_footer_link_groups(
	   group_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(group_id), 
 	   group_title VARCHAR(120),
 	   group_language VARCHAR(120),
 	   group_weight INT,
 	   group_number_of_links INT,
 	   group_created DATE,
 	   group_created_by_user_id INT,
 	   group_updated DATE,
 	   group_updated_by_user_id INT)")
	   or die(mysqli_error($link));

}
?>