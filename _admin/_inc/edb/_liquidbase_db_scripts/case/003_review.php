<?php
/**
*
* File: _admin/_inc/edb/_liquibase/case/003_review.php
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
/*- Tables ---------------------------------------------------------------------------- */
$t_edb_case_index_reviews			= $mysqlPrefixSav . "edb_case_index_reviews";

echo"

<!-- edb_case_index_review -->
";

$query = "SELECT * FROM $t_edb_case_index_reviews LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_reviews: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_reviews(
	  review_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(review_id), 
	   review_case_id INT,
	   review_text TEXT, 
	   review_updated_datetime DATETIME, 
	   review_updated_date DATE, 
	   review_updated_time VARCHAR(200), 
	   review_updated_saying VARCHAR(200), 
	   review_updated_ddmmyy VARCHAR(200), 
	   review_updated_ddmmyyyy VARCHAR(200), 

	   review_updated_by_user_id INT, 
	   review_updated_by_user_rank VARCHAR(200), 
	   review_updated_by_user_name VARCHAR(200), 
	   review_updated_by_user_alias VARCHAR(200), 
	   review_updated_by_user_email VARCHAR(200), 
	   review_updated_by_user_image_path VARCHAR(200), 
	   review_updated_by_user_image_file VARCHAR(200), 
	   review_updated_by_user_image_thumb_40 VARCHAR(200), 
	   review_updated_by_user_image_thumb_50 VARCHAR(200), 
	   review_updated_by_user_first_name VARCHAR(200), 
	   review_updated_by_user_middle_name VARCHAR(200), 
	   review_updated_by_user_last_name VARCHAR(200))")
	   or die(mysqli_error());
}
echo"
<!-- //edb_case_index_review -->


";
?>