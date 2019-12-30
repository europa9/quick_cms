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


<!-- courses categories -->
";

$query = "SELECT * FROM $t_courses_categories_sub LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_courses_categories_sub: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_courses_categories_sub(
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
	   course_title_clean VARCHAR(200), 
	   course_is_active INT, 
	   course_front_page_intro TEXT, 
	   course_description TEXT, 
	   course_contents TEXT, 
	   course_language VARCHAR(10), 
	   course_main_category_id INT, 
	   course_main_category_title VARCHAR(200), 
	   course_sub_category_id INT, 
	   course_sub_category_title VARCHAR(200), 
	   course_intro_video_embedded VARCHAR(200), 
	   course_image_file VARCHAR(200),  
	   course_image_thumb VARCHAR(200),  
	   course_icon_16 VARCHAR(200), 
	   course_icon_32 VARCHAR(200), 
	   course_icon_48 VARCHAR(200), 
	   course_icon_64 VARCHAR(200),  
	   course_icon_96 VARCHAR(200),  
	   course_icon_260 VARCHAR(200),  
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

<!-- courses_index_stats_monthly -->
";

$query = "SELECT * FROM $t_courses_index_stats_monthly LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_courses_index_stats_monthly: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_courses_index_stats_monthly(
	  monthly_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(monthly_id), 
	   monthly_course_id INT, 
	   monthly_year INT,
	   monthly_month INT,
	   monthly_users_enrolled_count INT, 
	   monthly_read_times INT,
	   monthly_read_times_ip_block TEXT)")
	   or die(mysqli_error());
}
echo"
<!-- //courses_index_stats_monthly -->

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
	   enrolled_course_id INT, 
	   enrolled_course_title VARCHAR(200), 
	   enrolled_course_title_clean VARCHAR(200), 
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
	   module_course_title VARCHAR(200),
	   module_number INT,
	   module_title VARCHAR(200),
	   module_title_clean VARCHAR(200),
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
	   read_course_title VARCHAR(200),

	   read_module_id INT,
	   read_module_title VARCHAR(200),

	   read_user_id INT)")
	   or die(mysqli_error());
}
echo"
<!-- //courses_modules_read -->


<!-- courses_lessons -->
";

$query = "SELECT * FROM $t_courses_lessons LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_courses_lessons: $row_cnt</p>
	";
}
else{

	mysqli_query($link, "CREATE TABLE $t_courses_lessons(
	  lesson_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(lesson_id), 
	   lesson_number INT,
	   lesson_title VARCHAR(200),
	   lesson_title_clean VARCHAR(200),
	   lesson_title_length INT,
	   lesson_title_short VARCHAR(90),
	   lesson_description TEXT,
	   lesson_content TEXT,
	   lesson_course_id INT,
	   lesson_course_title VARCHAR(200),
	   lesson_module_id INT,
	   lesson_module_title VARCHAR(200),
	   lesson_read_times INT,
	   lesson_read_times_ipblock TEXT,
	   lesson_created_datetime DATETIME,
	   lesson_created_date_formatted VARCHAR(60),
	   lesson_last_read_datetime DATETIME,
	   lesson_last_read_date_formatted VARCHAR(60))")
	   or die(mysqli_error());
}
echo"
<!-- //courses_modules_contents -->



<!-- courses_lessons_read -->
";

$query = "SELECT * FROM $t_courses_lessons_read LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_courses_lessons_read: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_courses_lessons_read (
	  lesson_read_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(lesson_read_id), 
	   read_course_id INT,
	   read_course_title VARCHAR(200),

	   read_module_id INT,
	   read_module_title VARCHAR(200),

	   read_lesson_id INT,
	   read_lesson_title VARCHAR(200),

	   read_user_id INT)")
	   or die(mysqli_error());
}
echo"
<!-- //courses_lessons_read -->
<!-- courses_lessons_comments -->
";

$query = "SELECT * FROM $t_courses_lessons_comments LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
	// Count rows
	$row_cnt = mysqli_num_rows($result);
	echo"
	<p>$t_courses_lessons_comments: $row_cnt</p>
	";
}
else{
	mysqli_query($link, "CREATE TABLE $t_courses_lessons_comments (
	  comment_id INT NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(comment_id), 
	   comment_course_id INT,
	   comment_course_title VARCHAR(200),
	   comment_module_id INT,
	   comment_module_title VARCHAR(200),
	   comment_lesson_id INT,
	   comment_lesson_title VARCHAR(200),
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
<!-- //courses_lessons_comments  -->


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
	   exam_course_title VARCHAR(200),
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
	   qa_course_title VARCHAR(200),
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
	   try_course_title VARCHAR(200),
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
	   try_qa_course_title VARCHAR(200),
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