<?php
if(isset($_SESSION['admin_user_id'])){
	$t_backup_web_cache 		= $mysqlPrefixSav . "backup_web_cache";

	mysqli_query($link,"DROP TABLE IF EXISTS $t_backup_web_cache") or die(mysqli_error());


	mysqli_query($link, "CREATE TABLE $t_backup_web_cache(
			   web_id INT NOT NULL AUTO_INCREMENT,
			   PRIMARY KEY(web_id), 
			   web_file_path VARCHAR(300),
			   web_relative_path VARCHAR(300),
			   web_size VARCHAR(300))")
			   or die(mysqli_error($link));


}
?>