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
$t_edb_case_index_review_notes			= $mysqlPrefixSav . "edb_case_index_review_notes";
$t_edb_case_index_review_matrix_titles		= $mysqlPrefixSav . "edb_case_index_review_matrix_titles";
$t_edb_case_index_review_matrix_fields		= $mysqlPrefixSav . "edb_case_index_review_matrix_fields";
$t_edb_case_index_review_matrix_values		= $mysqlPrefixSav . "edb_case_index_review_matrix_values";
$t_edb_case_index_review_matrix_items		= $mysqlPrefixSav . "edb_case_index_review_matrix_items";

echo"
<!-- edb_case_index_review_notes -->
";

$query = "SELECT * FROM $t_edb_case_index_review_notes LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_review_notes: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_edb_case_index_review_notes(
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
<!-- //edb_case_index_review_notes -->



<!-- edb_case_index_review_matrix_titles -->
";

$query = "SELECT * FROM $t_edb_case_index_review_matrix_titles LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_review_matrix_titles: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_case_index_review_matrix_titles(
	  title_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(title_id), 
	   title_case_id INT,
	   title_name VARCHAR(100),
	   title_weight VARCHAR(100),
	   title_colspan INT,
	   title_headcell_text_color VARCHAR(100),
	   title_headcell_bg_color VARCHAR(100),
	   title_headcell_border_color_edge VARCHAR(100),
	   title_headcell_border_color_center VARCHAR(100),
	   title_bodycell_text_color VARCHAR(100),
	   title_bodycell_bg_color VARCHAR(100),
	   title_bodycell_border_color_edge VARCHAR(100),
	   title_bodycell_border_color_center VARCHAR(100),
	   title_subcell_text_color VARCHAR(100),
	   title_subcell_bg_color VARCHAR(100),
	   title_subcell_border_color_edge VARCHAR(100),
	   title_subcell_border_color_center VARCHAR(100)
	   )")
	   or die(mysqli_error());


}
echo"
<!-- //edb_case_index_review_matrix_titles -->

<!-- edb_case_index_review_matrix_fields -->
";

$query = "SELECT * FROM $t_edb_case_index_review_matrix_fields LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_review_matrix_fields: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_case_index_review_matrix_fields(
	  field_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(field_id), 
	   field_case_id INT,
	   field_name VARCHAR(100),
	   field_title_id INT,
	   field_title_name VARCHAR(100),
	   field_weight VARCHAR(100),
	   field_type VARCHAR(100),
	   field_size VARCHAR(100),
	   field_alt_a VARCHAR(100),
	   field_alt_b VARCHAR(100),
	   field_alt_c VARCHAR(100),
	   field_alt_d VARCHAR(100),
	   field_alt_e VARCHAR(100),
	   field_alt_f VARCHAR(100),
	   field_alt_g VARCHAR(100),
	   field_alt_h VARCHAR(100),
	   field_alt_i VARCHAR(100),
	   field_alt_j VARCHAR(100),
	   field_alt_k VARCHAR(100),
	   field_alt_l VARCHAR(100),
	   field_alt_m VARCHAR(100)
	   )")
	   or die(mysqli_error());

}
echo"
<!-- //edb_case_index_review_matrix_fields -->


<!-- edb_case_index_review_matrix_values -->
";

$query = "SELECT * FROM $t_edb_case_index_review_matrix_values LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_review_matrix_values: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_case_index_review_matrix_values(
	  value_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(value_id), 
	   value_case_id INT,
	   value_text TEXT,
	   value_item_id INT,
	   value_title_id INT,
	   value_field_id INT
	   )")
	   or die(mysqli_error());

}
echo"
<!-- //edb_case_index_review_matrix_values -->


<!-- edb_case_index_review_matrix_items -->
";

$query = "SELECT * FROM $t_edb_case_index_review_matrix_items LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_case_index_review_matrix_items: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_case_index_review_matrix_items(
	  matrix_item_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(matrix_item_id), 
	   matrix_item_case_id INT,
	   matrix_item_item_id INT,
	   matrix_item_record_id INT,
	   matrix_item_record_seized_year INT,
	   matrix_item_record_seized_journal INT,
	   matrix_item_record_seized_district_number INT,
	   matrix_item_numeric_serial_number INT,
	   matrix_item_title VARCHAR(300),
	   matrix_item_parent_item_id INT,
	   matrix_item_parent_matrix_item_id INT)")
	   or die(mysqli_error());

}
echo"
<!-- //edb_case_index_review_matrix_items -->


";
?>