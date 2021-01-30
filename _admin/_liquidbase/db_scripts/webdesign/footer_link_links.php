<?php
if(isset($_SESSION['admin_user_id'])){
	$t_webdesign_footer_link_links = $mysqlPrefixSav . "webdesign_footer_link_links";

	mysqli_query($link,"DROP TABLE IF EXISTS $t_webdesign_footer_link_links") or die(mysqli_error());

	mysqli_query($link, "CREATE TABLE $t_webdesign_footer_link_links(
	   link_id INT NOT NULL AUTO_INCREMENT,
	   PRIMARY KEY(link_id), 
 	   link_group_id INT,
 	   link_title VARCHAR(120),
 	   link_url VARCHAR(120),
 	   link_internal_or_external VARCHAR(50),
 	   link_language VARCHAR(120),
 	   link_weight INT,
 	   link_created DATE,
 	   link_created_by_user_id INT,
 	   link_updated DATE,
 	   link_updated_by_user_id INT)")
	   or die(mysqli_error($link));

}
?>