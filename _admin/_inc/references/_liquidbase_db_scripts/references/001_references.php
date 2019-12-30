<?php
/**
*
* File: _admin/_inc/references/_liquibase/courses/001_references.php
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


<!-- references title translations -->
";

$query = "SELECT * FROM $t_references_title_translations LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_references_title_translations: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_references_title_translations(
	  reference_title_translation_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(reference_title_translation_id), 
	   reference_title_translation_title VARCHAR(500), 
	   reference_title_translation_language VARCHAR(10))")
	   or die(mysqli_error());


	// Insert all languages
	$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;
		
		mysqli_query($link, "INSERT INTO $t_references_title_translations
		(reference_title_translation_id, reference_title_translation_title, reference_title_translation_language) 
		VALUES 
		(NULL, 'References', '$get_language_active_iso_two')")
		or die(mysqli_error($link));
	}
}
echo"
<!-- //reference title translations -->




<!-- reference categories main -->
";

$query = "SELECT * FROM $t_references_categories_main LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_references_categories_main: $row_cnt</p>
	";
}
else{
	echo"<p>CREATE TABLE $t_references_categories_main</p>";
	mysqli_query($link, "CREATE TABLE $t_references_categories_main(
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
<!-- //reference categories main -->


<!-- reference categories sub -->
";

$query = "SELECT * FROM $t_references_categories_sub LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_references_categories_sub: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_references_categories_sub(
	  sub_category_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(sub_category_id), 
	   sub_category_title VARCHAR(200), 
	   sub_category_title_clean VARCHAR(200), 
	   sub_category_description TEXT, 
	   sub_category_main_category_id INT,
	   sub_category_main_category_title VARCHAR(200), 
	   sub_category_language VARCHAR(10), 
	   sub_category_created DATETIME,
	   sub_category_updated DATETIME)")
	   or die(mysqli_error());
}
echo"
<!-- //reference categories sub -->

<!-- references index-->
";

$query = "SELECT * FROM $t_references_index LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_references_index: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_references_index(
	  reference_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(reference_id), 
	   reference_title VARCHAR(200), 
	   reference_title_clean VARCHAR(200), 
	   reference_title_short VARCHAR(200), 
	   reference_title_length INT,
	   reference_is_active INT, 
	   reference_front_page_intro TEXT, 
	   reference_description TEXT, 
	   reference_language VARCHAR(10), 
	   reference_main_category_id INT, 
	   reference_main_category_title VARCHAR(200), 
	   reference_sub_category_id INT, 
	   reference_sub_category_title VARCHAR(200), 
	   reference_image_file VARCHAR(200),  
	   reference_image_thumb VARCHAR(200),  
	   reference_icon_16 VARCHAR(200), 
	   reference_icon_32 VARCHAR(200), 
	   reference_icon_48 VARCHAR(200), 
	   reference_icon_64 VARCHAR(200),  
	   reference_icon_96 VARCHAR(200),  
	   reference_icon_260 VARCHAR(200),  
	   reference_groups_count INT, 
	   reference_guides_count INT, 
	   reference_read_times INT,
	   reference_read_times_ip_block TEXT,
	   reference_created DATETIME,
	   reference_updated DATETIME)")
	   or die(mysqli_error());
}
echo"
<!-- //references index-->

<!-- references_index_groups -->
";

$query = "SELECT * FROM $t_references_index_groups LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_references_index_groups: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_references_index_groups(
	  group_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(group_id), 
	   group_title VARCHAR(200), 
	   group_title_clean VARCHAR(200), 
	   group_title_short VARCHAR(200),
	   group_title_length INT,
	   group_number INT, 
	   group_reference_id INT, 
	   group_reference_title VARCHAR(200), 
	   group_read_times INT,
	   group_read_times_ip_block TEXT,
	   group_created_datetime DATETIME,
	   group_updated_datetime DATETIME, 
	   group_updated_formatted VARCHAR(200),
	   group_last_read DATETIME,
	   group_last_read_formatted VARCHAR(200))")
	   or die(mysqli_error());
}
echo"
<!-- //references_index_groups -->


<!-- references_index_guides -->
";

$query = "SELECT * FROM $t_references_index_guides LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_references_index_guides: $row_cnt</p>
	";
}
else{

	mysqli_query($link, "CREATE TABLE $t_references_index_guides(
	  guide_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(guide_id), 
	   guide_number INT, 
	   guide_title VARCHAR(200),
	   guide_title_clean VARCHAR(200),
	   guide_title_short VARCHAR(200),
	   guide_title_length INT,
	   guide_short_description VARCHAR(200),
	   guide_group_id INT, 
	   guide_group_title VARCHAR(200), 
	   guide_reference_id INT, 
	   guide_reference_title VARCHAR(200), 
	   guide_read_times INT,
	   guide_read_ipblock TEXT,
	   guide_created DATETIME,
	   guide_updated DATETIME,
	   guide_updated_formatted VARCHAR(200), 
	   guide_last_read DATETIME,
	   guide_last_read_formatted VARCHAR(200), 
	   guide_comments INT)")
	   or die(mysqli_error());
}
echo"
<!-- //references_index_guides -->


<!-- references_index_guides_comments -->
";

$query = "SELECT * FROM $t_references_index_guides_comments LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_references_index_guides_comments: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_references_index_guides_comments(
	  comment_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(comment_id), 
	   comment_reference_id INT,
	   comment_reference_title VARCHAR(200),
	   comment_group_id INT,
	   comment_group_title VARCHAR(200),
	   comment_guide_id INT,
	   comment_guide_title VARCHAR(200),
	   comment_language VARCHAR(20),
	   comment_approved INT,
	   comment_datetime DATETIME,
	   comment_time VARCHAR(200),
	   comment_date_print VARCHAR(200),
	   comment_user_id INT,
	   comment_user_alias VARCHAR(250),
	   comment_user_image_path VARCHAR(250),
	   comment_user_image_file VARCHAR(250),
	   comment_user_ip VARCHAR(250),
	   comment_user_hostname VARCHAR(250),
	   comment_user_agent VARCHAR(250),
	   comment_title VARCHAR(250),
	   comment_text TEXT, 
	   comment_rating INT, 
	   comment_helpful_clicks INT,
	   comment_useless_clicks INT,
	   comment_marked_as_spam INT,
	   comment_spam_checked INT,
	   comment_spam_checked_comment TEXT)")
	   or die(mysqli_error());
}
echo"
<!-- //references_index_guides_comments  -->


";
?>