<?php
/**
*
* File: _admin/_inc/courses/_liquibase/courses/001_courses.php
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




<!-- courses categories -->
";

$query = "SELECT * FROM $t_courses_categories_main LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_courses_categories_main: $row_cnt</p>
	";
}
else{
	echo"<p>CREATE TABLE $t_courses_categories_main</p>";
	mysqli_query($link, "CREATE TABLE $t_courses_categories_main(
	  main_category_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(main_category_id), 
	   main_category_title VARCHAR(200), 
	   main_category_title_clean VARCHAR(200), 
	   main_category_description TEXT, 
	   main_category_language VARCHAR(10), 
	   main_category_created DATETIME,
	   main_category_updated DATETIME)")
	   or die(mysqli_error());
}
echo"
<!-- //courses categories -->


";
?>