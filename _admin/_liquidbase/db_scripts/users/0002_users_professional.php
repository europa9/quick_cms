<?php
if(isset($_SESSION['admin_user_id'])){
	$t_users_professional 	= $mysqlPrefixSav . "users_professional";


	mysqli_query($link,"DROP TABLE IF EXISTS $t_users_professional") or die(mysqli_error());


	mysqli_query($link, "CREATE TABLE $t_users_professional(
			   professional_id INT NOT NULL AUTO_INCREMENT,
			   PRIMARY KEY(professional_id), 
			   professional_user_id INT,
			   professional_company VARCHAR(200),
			   professional_company_location VARCHAR(200),
			   professional_department VARCHAR(200),
			   professional_work_email VARCHAR(200),
			   professional_position VARCHAR(200),
			   professional_position_abbr VARCHAR(200),
			   professional_district VARCHAR(200))")
			   or die(mysqli_error($link));



}
?>