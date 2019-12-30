<?php
if(isset($_SESSION['admin_user_id'])){
	$t_backup_web_root_dir_content 		= $mysqlPrefixSav . "backup_web_root_dir_content";

	mysqli_query($link,"DROP TABLE IF EXISTS $t_backup_web_root_dir_content") or die(mysqli_error());


	mysqli_query($link, "CREATE TABLE $t_backup_web_root_dir_content(
			   content_id INT NOT NULL AUTO_INCREMENT,
			   PRIMARY KEY(content_id), 
			   content_file_path VARCHAR(300),
			   content_relative_path VARCHAR(300),
			   content_size VARCHAR(300))")
			   or die(mysqli_error($link));


}
?>