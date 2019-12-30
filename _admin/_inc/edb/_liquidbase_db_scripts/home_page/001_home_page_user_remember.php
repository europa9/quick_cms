<?php
/**
*
* File: _admin/_inc/edb/_liquibase/home_page/001_home_page_user_remember.php
* Version 1.0.0
* Date 21:19 28.08.2019
* Copyright (c) 2019 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

echo"


<!-- home_page_user_remember -->
";

$query = "SELECT * FROM $t_edb_home_page_user_remember LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_home_page_user_remember: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_home_page_user_remember(
	  user_remember_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(user_remember_id), 
	   user_remember_user_id INT,
	   user_remember_district_id INT,
	   user_remember_district_title VARCHAR(200),
	   user_remember_station_id INT,
	   user_remember_station_title VARCHAR(200)
	   )")
	   or die(mysqli_error());

}
echo"
<!-- //home_page_user_remember -->

";
?>