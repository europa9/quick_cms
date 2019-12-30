<?php
/**
*
* File: _admin/_inc/edb/_liquibase/review/review.p
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
$t_edb_review_matrix_titles = $mysqlPrefixSav . "edb_review_matrix_titles";
$t_edb_review_matrix_fields = $mysqlPrefixSav . "edb_review_matrix_fields";


echo"


<!-- edb_review_matrix_titles -->
";

$query = "SELECT * FROM $t_edb_review_matrix_titles LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_review_matrix_titles: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_review_matrix_titles(
	  title_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(title_id), 
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



	mysqli_query($link, "INSERT INTO $t_edb_review_matrix_titles
	(`title_id`, `title_name`, `title_weight`, `title_colspan`, `title_headcell_text_color`, `title_headcell_bg_color`, `title_headcell_border_color_edge`, `title_headcell_border_color_center`, `title_bodycell_text_color`, `title_bodycell_bg_color`, `title_bodycell_border_color_edge`, `title_bodycell_border_color_center`, `title_subcell_text_color`, `title_subcell_bg_color`, `title_subcell_border_color_edge`, `title_subcell_border_color_center`) 
	VALUES 
	(NULL, 'Merknad', '1', 1, '#000', '#a6a6a6', '#000', '#a3a3a3', '#000', '#d9d9d9', '#000', '#a3a3a3', '#000', '#f2f2f2', '#000', '#a3a3a3'),
	(NULL, 'IEF', '2', 4, '#000', '#3c8cec', '#000', '#7199b9', '#000', '#97ccf7', '#000', '#7199b9', '#000', '#d8ecfc', '#000', '#7199b9'),
	(NULL, 'Griffeye', '3', 4, '#000', '#22ca72', '#000', '#6cb18d', '#000', '#90ecbc', '#000', '#6cb18d', '#000', '#cef6e1', '#000', '#6cb18d'),
	(NULL, 'Social Media Reader', '4', 4, '#000', '#ffc000', '#000', '#bfa758', '#000', '#ffde75', '#000', '#bfa758', '#000', '#fff0c1', '#000', '#bfa758'),
	(NULL, 'Arkiv (Fb, Google, Dropbox mm)', '5', 4, '#000', '#ff6699', '#000', '#bf8b9c', '#000', '#ffb9d0', '#000', '#bf8b9c', '#000', '#ffdde8', '#000', '#bf8b9c'),
	(NULL, 'UFED', '6', 4, '#000', '#ff5050', '#000', '#bf6161', '#000', '#ff8181', '#000', '#bf6161', '#000', '#ffc5c5', '#000', '#bf6161')
	")
	or die(mysqli_error($link));


}
echo"
<!-- //edb_review_matrix_titles -->

<!-- edb_review_matrix_fields -->
";

$query = "SELECT * FROM $t_edb_review_matrix_fields LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_edb_review_matrix_fields: $row_cnt</p>
	";
}
else{


	mysqli_query($link, "CREATE TABLE $t_edb_review_matrix_fields(
	  field_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(field_id), 
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


	mysqli_query($link, "INSERT INTO $t_edb_review_matrix_fields
	(field_id, field_name, field_title_id, field_title_name, field_weight, 
	field_type, field_size, field_alt_a, field_alt_b, field_alt_c, field_alt_d, 
	field_alt_e, field_alt_f, field_alt_g, field_alt_h, field_alt_i, 
	field_alt_j, field_alt_k, field_alt_l, field_alt_m) 
	VALUES 
	(NULL, 'Tekst', 1, 'Merknad', '1', 'text', '25', '', '', '', '', '', '', '', '', '', '', '', '', ''),

	(NULL, 'IEF', 2, 'IEF', '1', 'select', '25', '-', 'Ferdig', 'Under arbeid', 'Ikke aktuelt', '', '', '', '', '', '', '', '', ''),
	(NULL, 'Dato', 2, 'IEF', '2', 'date', '25', '', '', '', '', '', '', '', '', '', '', '', '', ''),
	(NULL, 'Funn', 2, 'IEF', '3', 'select', '25', '-', 'Ja', 'Nei', '', '', '', '', '', '', '', '', '', ''),
	(NULL, 'BID', 2, 'IEF', '4', 'text', '6', '', '', '', '', '', '', '', '', '', '', '', '', ''),

	(NULL, 'Griffeye', 3, 'Griffeye', '1', 'select', '25', '-', 'Ferdig', 'Under arbeid', 'Ikke aktuelt', '', '', '', '', '', '', '', '', ''),
	(NULL, 'Dato', 3, 'Griffeye', '2', 'date', '25', '', '', '', '', '', '', '', '', '', '', '', '', ''),
	(NULL, 'Funn', 3, 'Griffeye', '3', 'select', '25', '-', 'Ja', 'Nei', '', '', '', '', '', '', '', '', '', ''),
	(NULL, 'BID', 3, 'Griffeye', '4', 'text', '6', '', '', '', '', '', '', '', '', '', '', '', '', ''),

	(NULL, 'SMR', 4, 'Social Media Reader', '1', 'select', '25', '-', 'Ferdig', 'Under arbeid', 'Ikke aktuelt', '', '', '', '', '', '', '', '', ''),
	(NULL, 'Dato', 4, 'Social Media Reader', '2', 'date', '25', '', '', '', '', '', '', '', '', '', '', '', '', ''),
	(NULL, 'Funn', 4, 'Social Media Reader', '3', 'select', '25', '-', 'Ja', 'Nei', '', '', '', '', '', '', '', '', '', ''),
	(NULL, 'BID', 4, 'Social Media Reader', '4', 'text', '6', '', '', '', '', '', '', '', '', '', '', '', '', ''),

	(NULL, 'Arkiv', 5, 'Arkiv (Fb, Google, Dropbox mm)', '1', 'select', '25', '-', 'Ferdig', 'Under arbeid', 'Ikke aktuelt', '', '', '', '', '', '', '', '', ''),
	(NULL, 'Dato', 5, 'Arkiv (Fb, Google, Dropbox mm)', '2', 'date', '25', '', '', '', '', '', '', '', '', '', '', '', '', ''),
	(NULL, 'Funn', 5, 'Arkiv (Fb, Google, Dropbox mm)', '3', 'select', '25', '-', 'Ja', 'Nei', '', '', '', '', '', '', '', '', '', ''),
	(NULL, 'BID', 5, 'Arkiv (Fb, Google, Dropbox mm)', '4', 'text', '6', '', '', '', '', '', '', '', '', '', '', '', '', ''),

	(NULL, 'UFED', 6, 'UFED', '1', 'select', '25', '-', 'Ferdig', 'Under arbeid', 'Ikke aktuelt', '', '', '', '', '', '', '', '', ''),
	(NULL, 'Dato', 6, 'UFED', '2', 'date', '25', '', '', '', '', '', '', '', '', '', '', '', '', ''),
	(NULL, 'Funn', 6, 'UFED', '3', 'select', '25', '-', 'Ja', 'Nei', '', '', '', '', '', '', '', '', '', ''),
	(NULL, 'BID', 6, 'UFED', '4', 'text', '6', '', '', '', '', '', '', '', '', '', '', '', '', '')

	")
	or die(mysqli_error($link));

}
echo"
<!-- //edb_review_matrix_fields -->


";
?>