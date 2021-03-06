<?php
/**
*
* File: _admin/_inc/rebus/_liquibase/rebus/counties.php
* Version 1.0.0
* Date 07:23 01.07.2021
* Copyright (c) 2021 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Tables ---------------------------------------------------------------------------- */

$result = mysqli_query($link, "DROP TABLE IF EXISTS $t_rebus_games_geo_counties") or die(mysqli_error($link)); 


echo"
<!-- games_index -->
";

$query = "SELECT * FROM $t_rebus_games_geo_counties LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_rebus_games_geo_counties: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_rebus_games_geo_counties(
	  county_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(county_id), 
	   county_name VARCHAR(200),
	   county_country_id INT, 
	   county_country_name VARCHAR(200), 
	   county_created_by_user_id INT,
	   county_created_by_user_name VARCHAR(200),
	   county_created_by_user_email VARCHAR(200), 
	   county_created_by_ip VARCHAR(200), 
	   county_created_by_hostname VARCHAR(200), 
	   county_created_by_user_agent VARCHAR(200)
	   )")
	   or die(mysqli_error());


}
echo"
<!-- //games_index -->

";
?>