<?php
/**
*
* File: _admin/_inc/blog/tables.php
* Version 11:55 30.12.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}
/*- Tables ---------------------------------------------------------------------------- */
$t_courses_title_translations	 = $mysqlPrefixSav . "courses_title_translations";
$t_courses_index		 = $mysqlPrefixSav . "courses_index";
$t_courses_users_enrolled 	 = $mysqlPrefixSav . "courses_users_enrolled";

$t_courses_categories		 = $mysqlPrefixSav . "courses_categories";
$t_courses_modules		 = $mysqlPrefixSav . "courses_modules";
$t_courses_modules_read		 = $mysqlPrefixSav . "courses_modules_read";

$t_courses_modules_contents 	 = $mysqlPrefixSav . "courses_modules_contents";
$t_courses_modules_contents_read = $mysqlPrefixSav . "courses_modules_contents_read";
$t_courses_modules_contents_comments	= $mysqlPrefixSav . "courses_modules_contents_comments";

$t_courses_modules_quizzes_index  	= $mysqlPrefixSav . "courses_modules_quizzes_index";
$t_courses_modules_quizzes_qa 		= $mysqlPrefixSav . "courses_modules_quizzes_qa";
$t_courses_modules_quizzes_user_records	= $mysqlPrefixSav . "courses_modules_quizzes_user_records";

$t_courses_exams_index  		= $mysqlPrefixSav . "courses_exams_index";
$t_courses_exams_qa			= $mysqlPrefixSav . "courses_exams_qa";
$t_courses_exams_user_tries		= $mysqlPrefixSav . "courses_exams_user_tries";
$t_courses_exams_user_tries_qa		= $mysqlPrefixSav . "courses_exams_user_tries_qa";


echo"
<h1>Tables</h1>


<!-- Where am I? -->
	<p><b>You are here:</b><br />
	<a href=\"index.php?open=courses&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Courses</a>
	&gt;
	<a href=\"index.php?open=courses&amp;page=tables&amp;editor_language=$editor_language&amp;l=$l\">Tables</a>
	</p>
<!-- //Where am I? -->

<!-- courses title translations -->
";

$query = "SELECT * FROM $t_courses_title_translations LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_courses_title_translations: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_courses_title_translations(
	  courses_title_translation_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(courses_title_translation_id), 
	   courses_title_translation_title VARCHAR(500), 
	   courses_title_translation_language VARCHAR(10))")
	   or die(mysqli_error());


	// Insert all languages
	$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;
		
		mysqli_query($link, "INSERT INTO $t_courses_title_translations
		(courses_title_translation_id, courses_title_translation_title, courses_title_translation_language) 
		VALUES 
		(NULL, 'Courses', '$get_language_active_iso_two')")
		or die(mysqli_error($link));
	}
}
echo"
<!-- //courses title translations -->




<!-- courses categories -->
";

$query = "SELECT * FROM $t_courses_categories LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_courses_categories: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_courses_categories(
	  category_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(category_id), 
	   category_title VARCHAR(200), 
	   category_dir_name VARCHAR(200), 
	   category_description TEXT, 
	   category_language VARCHAR(10), 
	   category_created DATETIME,
	   category_updated DATETIME)")
	   or die(mysqli_error());
}
echo"
<!-- //courses categories -->

<!-- courses -->
";

$query = "SELECT * FROM $t_courses_index LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_courses_index: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_courses_index(
	  course_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(course_id), 
	   course_title VARCHAR(200), 
	   course_is_active INT, 
	   course_short_introduction TEXT, 
	   course_long_introduction TEXT, 
	   course_contents TEXT, 
	   course_language VARCHAR(10), 
	   course_dir_name VARCHAR(200), 
	   course_category_id INT, 
	   course_category_dir_name VARCHAR(200), 
	   course_intro_video_embedded VARCHAR(200), 
	   course_icon_48 VARCHAR(200),  
	   course_icon_64 VARCHAR(200),  
	   course_icon_96 VARCHAR(200),  
	   course_modules_count INT, 
	   course_lessons_count INT, 
	   course_quizzes_count INT, 
	   course_users_enrolled_count INT, 
	   course_read_times INT,
	   course_read_times_ip_block TEXT,
	   course_created DATETIME,
	   course_updated DATETIME)")
	   or die(mysqli_error());
}
echo"
<!-- //courses -->

<!-- courses_users_enrolled -->
";

$query = "SELECT * FROM $t_courses_users_enrolled LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_courses_users_enrolled: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_courses_users_enrolled(
	  enrolled_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(enrolled_id), 
	   enrolled_course_dir_name VARCHAR(200), 
	   enrolled_user_id INT, 
	   enrolled_started_datetime DATETIME,
	   enrolled_started_saying VARCHAR(200), 
	   enrolled_percentage_done INT,
	   enrolled_has_completed_exam INT,
	   enrolled_exam_total_questions INT,
	   enrolled_exam_correct_answers INT,
	   enrolled_exam_correct_percentage INT,
	   enrolled_completed_datetime DATETIME,
	   enrolled_completed_saying VARCHAR(200))")
	   or die(mysqli_error());
}
echo"
<!-- //courses_users_enrolled -->


<!-- courses_modules -->
";

$query = "SELECT * FROM $t_courses_modules LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_courses_modules: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_courses_modules(
	  module_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(module_id), 
	   module_course_id INT,
	   module_course_dir_name VARCHAR(200),
	   module_number INT,
	   module_title VARCHAR(200),
	   module_title_clean VARCHAR(200),
	   module_url VARCHAR(200),
	   module_read_times INT,
	   module_read_ipblock TEXT,
	   module_created DATETIME,
	   module_updated DATETIME,
	   module_last_read_datetime DATETIME,
	   module_last_read_date_formatted VARCHAR(60))")
	   or die(mysqli_error());
}
echo"
<!-- //courses_modules -->

<!-- courses_modules_read -->
";

$query = "SELECT * FROM $t_courses_modules_read LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_courses_modules_read: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_courses_modules_read(
	  module_read_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(module_read_id), 

	   read_course_id INT,
	   read_course_dir_name VARCHAR(200),

	   read_module_id INT,
	   read_module_title_clean VARCHAR(200),

	   read_user_id INT)")
	   or die(mysqli_error());
}
echo"
<!-- //courses_modules_read -->


<!-- courses_modules_contents -->
";

$query = "SELECT * FROM $t_courses_modules_contents LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_courses_modules_contents: $row_cnt</p>
	";
}
else{

	mysqli_query($link, "CREATE TABLE $t_courses_modules_contents(
	  content_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(content_id), 
	   content_course_id INT,
	   content_course_dir_name VARCHAR(200),
	   content_module_id INT,
	   content_module_title_clean VARCHAR(200),
	   content_type VARCHAR(100),
	   content_number INT,
	   content_title VARCHAR(200),
	   content_title_clean VARCHAR(200),
	   content_description TEXT,
	   content_url VARCHAR(200),
	   content_url_type VARCHAR(200),
	   content_read_times INT,
	   content_read_times_ipblock TEXT,
	   content_created_datetime DATETIME,
	   content_created_date_formatted VARCHAR(60),
	   content_last_read_datetime DATETIME,
	   content_last_read_date_formatted VARCHAR(60))")
	   or die(mysqli_error());
}
echo"
<!-- //courses_modules_contents -->



<!-- courses_modules_contents_read -->
";

$query = "SELECT * FROM $t_courses_modules_contents_read LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_courses_modules_contents_read: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_courses_modules_contents_read (
	  content_read_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(content_read_id), 
	   read_course_id INT,
	   read_course_dir_name VARCHAR(200),

	   read_module_id INT,
	   read_module_title_clean VARCHAR(200),

	   read_content_id INT,
	   read_content_title_clean VARCHAR(200),

	   read_user_id INT)")
	   or die(mysqli_error());
}
echo"
<!-- //courses_modules_contents_read -->
<!-- courses_modules_contents_comments -->
";

$query = "SELECT * FROM $t_courses_modules_contents_comments LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_courses_modules_contents_comments: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_courses_modules_contents_comments (
	  comment_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(comment_id), 
	   comment_course_id INT,
	   comment_course_dir_name VARCHAR(200),
	   comment_module_id INT,
	   comment_module_title_clean VARCHAR(200),
	   comment_content_id INT,
	   comment_content_title_clean VARCHAR(200),
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
<!-- //courses_modules_contents_comments  -->


<!-- $t_courses_exams_index -->
";

$query = "SELECT * FROM $t_courses_exams_index LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_courses_exams_index: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_courses_exams_index (
	  exam_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(exam_id), 
	   exam_course_id INT,
	   exam_course_dir_name VARCHAR(200),
	   exam_language VARCHAR(20),
	   exam_total_questions INT,
	   exam_total_points INT,
	   exam_points_needed_to_pass INT)")
	   or die(mysqli_error());
}
echo"
<!-- //courses_exams_index -->


<!-- courses_exams_qa -->
";

$query = "SELECT * FROM $t_courses_exams_qa LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_courses_exams_qa: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_courses_exams_qa(
	  qa_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(qa_id), 
	   qa_course_id INT,
	   qa_course_dir_name VARCHAR(200),
	   qa_exam_id INT,
	   qa_question_number INT,
	   qa_question VARCHAR(200),
	   qa_text TEXT,
	   qa_type VARCHAR(200),
	   qa_alt_a VARCHAR(200),
	   qa_alt_b VARCHAR(200),
	   qa_alt_c VARCHAR(200),
	   qa_alt_d VARCHAR(200),
	   qa_alt_e VARCHAR(200),
	   qa_alt_f VARCHAR(200),
	   qa_alt_g VARCHAR(200),
	   qa_alt_h VARCHAR(200),
	   qa_alt_i VARCHAR(200),
	   qa_alt_j VARCHAR(200),
	   qa_alt_k VARCHAR(200),
	   qa_alt_l VARCHAR(200),
	   qa_alt_m VARCHAR(200),
	   qa_alt_n VARCHAR(200),
	   qa_correct_alternatives VARCHAR(200),
	   qa_points INT,
	   qa_hint TEXT,
	   qa_explanation TEXT)")
	   or die(mysqli_error());
}
echo"
<!-- //courses_exams_qa -->


<!-- courses_modules_exams_user_tries -->
";

$query = "SELECT * FROM $t_courses_exams_user_tries LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_courses_exams_user_tries: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_courses_exams_user_tries(
	  try_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(try_id), 
	   try_course_id INT,
	   try_course_dir_name VARCHAR(200),
	   try_exam_id INT,
	   try_user_id INT,
	   try_started_datetime DATETIME,
	   try_started_time VARCHAR(200),
	   try_started_saying VARCHAR(200),
	   try_is_closed INT,
	   try_ended_datetime DATETIME,
	   try_ended_time VARCHAR(200),
	   try_ended_saying VARCHAR(200),
	   try_finished_saying VARCHAR(200),
	   try_time_used VARCHAR(200),
	   try_percentage INT,
	   try_passed INT)")
	   or die(mysqli_error());
}
echo"
<!-- //courses_exams_user_tries -->



<!-- courses_exams_user_tries_qa -->
";

$query = "SELECT * FROM $t_courses_exams_user_tries_qa LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_courses_exams_user_tries_qa: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_courses_exams_user_tries_qa(
	  try_qa_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(try_qa_id), 
	   try_qa_course_id INT,
	   try_qa_course_dir_name VARCHAR(200),
	   try_qa_exam_id INT,
	   try_qa_try_id INT,
	   try_qa_user_id INT,
	   try_qa_qa_id INT,
	   try_qa_alt_a VARCHAR(200),
	   try_qa_alt_b VARCHAR(200),
	   try_qa_alt_c VARCHAR(200),
	   try_qa_alt_d VARCHAR(200),
	   try_qa_alt_e VARCHAR(200),
	   try_qa_alt_f VARCHAR(200),
	   try_qa_alt_g VARCHAR(200),
	   try_qa_alt_h VARCHAR(200),
	   try_qa_alt_i VARCHAR(200),
	   try_qa_alt_j VARCHAR(200),
	   try_qa_alt_k VARCHAR(200),
	   try_qa_alt_l VARCHAR(200),
	   try_qa_alt_m VARCHAR(200),
	   try_qa_alt_n VARCHAR(200),
	   try_qa_points_awarded DOUBLE,
	   try_qa_is_correct INT)")
	   or die(mysqli_error());
}
echo"
<!-- //courses_exams_user_tries_qa -->
";


?>