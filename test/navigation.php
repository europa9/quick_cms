<?php
/**
*
* File: test/course_navigation.php
* Version 2.0.0
* Date 2021-03-26 16:19:25
* Copyright (c) 2011-2019 Localhost
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Course info --------------------------------------------------------------------- */
$courseTitleSav = "test";

/*- Functions ------------------------------------------------------------------------ */

/*- Variables ------------------------------------------------------------------------ */
if(isset($_GET['module_id'])) {
	$module_id = $_GET['module_id'];
	$module_id = strip_tags(stripslashes($module_id));
}
else{
	$module_id = "";
}
if(isset($_GET['lesson_id'])) {
	$lesson_id = $_GET['lesson_id'];
	$lesson_id = strip_tags(stripslashes($lesson_id));
}
else{
	$lesson_id = "";
}

/*- Tables ---------------------------------------------------------------------------- */
$t_courses_title_translations	 = $mysqlPrefixSav . "courses_title_translations";
$t_courses_index		 = $mysqlPrefixSav . "courses_index";
$t_courses_users_enrolled 	 = $mysqlPrefixSav . "courses_users_enrolled";

$t_courses_categories_main	 = $mysqlPrefixSav . "courses_categories_main";
$t_courses_categories_sub 	 = $mysqlPrefixSav . "courses_categories_sub";
$t_courses_modules		 = $mysqlPrefixSav . "courses_modules";
$t_courses_modules_read		 = $mysqlPrefixSav . "courses_modules_read";

$t_courses_lessons 	 	= $mysqlPrefixSav . "courses_lessons";
$t_courses_lessons_read 	= $mysqlPrefixSav . "courses_lessons_read";
$t_courses_lessons_comments	= $mysqlPrefixSav . "courses_lessons_comments";

$t_courses_modules_quizzes_index  	= $mysqlPrefixSav . "courses_modules_quizzes_index";
$t_courses_modules_quizzes_qa 		= $mysqlPrefixSav . "courses_modules_quizzes_qa";
$t_courses_modules_quizzes_user_records	= $mysqlPrefixSav . "courses_modules_quizzes_user_records";

$t_courses_exams_index  		= $mysqlPrefixSav . "courses_exams_index";
$t_courses_exams_qa			= $mysqlPrefixSav . "courses_exams_qa";
$t_courses_exams_user_tries		= $mysqlPrefixSav . "courses_exams_user_tries";
$t_courses_exams_user_tries_qa		= $mysqlPrefixSav . "courses_exams_user_tries_qa";


/*- Translations ---------------------------------------------------------------------- */
include("$root/_admin/_translations/site/$l/courses/ts_navigation.php");

// Find course
$course_title_mysql = quote_smart($link, $courseTitleSav);
$query = "SELECT course_id, course_title, course_title_clean, course_is_active, course_front_page_intro, course_description, course_contents, course_language, course_main_category_id, course_main_category_title, course_sub_category_id, course_sub_category_title, course_intro_video_embedded, course_image_file, course_image_thumb, course_icon_48, course_icon_64, course_icon_96, course_modules_count, course_lessons_count, course_quizzes_count, course_users_enrolled_count, course_read_times, course_read_times_ip_block, course_created, course_updated FROM $t_courses_index WHERE course_title=$course_title_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_course_id, $get_current_course_title, $get_current_course_title_clean, $get_current_course_is_active, $get_current_course_front_page_intro, $get_current_course_description, $get_current_course_contents, $get_current_course_language, $get_current_course_main_category_id, $get_current_course_main_category_title, $get_current_course_sub_category_id, $get_current_course_sub_category_title, $get_current_course_intro_video_embedded, $get_current_course_image_file, $get_current_course_image_thumb, $get_current_course_icon_48, $get_current_course_icon_64, $get_current_course_icon_96, $get_current_course_modules_count, $get_current_course_lessons_count, $get_current_course_quizzes_count, $get_current_course_users_enrolled_count, $get_current_course_read_times, $get_current_course_read_times_ip_block, $get_current_course_created, $get_current_course_updated) = $row;

if($get_current_course_id != ""){
	// Find me
	$get_current_enrolled_id  = "";
	if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
		// Get user
		$my_user_id = $_SESSION['user_id'];
		$my_user_id_mysql = quote_smart($link, $my_user_id);
		$my_security = $_SESSION['security'];
		$my_security_mysql = quote_smart($link, $my_security);
	
		// Am I enrolled?
		$query = "SELECT enrolled_id, enrolled_course_id, enrolled_course_title, enrolled_course_title_clean, enrolled_user_id, enrolled_started_datetime, enrolled_started_saying, enrolled_percentage_done, enrolled_has_completed_exam, enrolled_exam_total_questions, enrolled_exam_correct_answers, enrolled_exam_correct_percentage, enrolled_completed_datetime, enrolled_completed_saying FROM $t_courses_users_enrolled WHERE enrolled_course_id=$get_current_course_id AND enrolled_user_id=$my_user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_enrolled_id, $get_current_enrolled_course_id, $get_current_enrolled_course_title, $get_current_enrolled_course_title_clean, $get_current_enrolled_user_id, $get_current_enrolled_started_datetime, $get_current_enrolled_started_saying, $get_current_enrolled_percentage_done, $get_current_enrolled_has_completed_exam, $get_current_enrolled_exam_total_questions, $get_current_enrolled_exam_correct_answers, $get_current_enrolled_exam_correct_percentage, $get_current_enrolled_completed_datetime, $get_current_enrolled_completed_saying) = $row;
		if($get_current_enrolled_id == ""){
			// Insert
			$datetime = date("Y-m-d H:i:s");
			$date_saying = date("j. M Y");
			$inp_course_title_mysql = quote_smart($link, $get_current_course_title);
			$inp_course_title_clean_mysql = quote_smart($link, $get_current_course_title_clean);

			mysqli_query($link, "INSERT INTO $t_courses_users_enrolled 
			(enrolled_id, enrolled_course_id, enrolled_course_title, enrolled_course_title_clean, enrolled_user_id, enrolled_started_datetime, enrolled_started_saying, enrolled_percentage_done, enrolled_has_completed_exam) 
			VALUES 
			(NULL, $get_current_course_id, $inp_course_title_mysql, $inp_course_title_clean_mysql, $my_user_id_mysql, '$datetime', '$date_saying', '0', '0')")
			or die(mysqli_error($link));

			// Endrolled in course
			$inp_course_users_enrolled_count = $get_current_course_users_enrolled_count + 1;
			$result = mysqli_query($link, "UPDATE $t_courses_index SET course_users_enrolled_count=$inp_course_users_enrolled_count WHERE course_id=$get_current_course_id");

			// Get enrolled ID
			$query = "SELECT enrolled_id FROM $t_courses_users_enrolled WHERE enrolled_course_id=$get_current_course_id AND enrolled_user_id=$my_user_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_enrolled_id) = $row;


		}
		
	}
	// Nav start

	echo"
				<ul class=\"toc\">
";


	// Modules
	$query = "SELECT module_id, module_course_id, module_course_title, module_number, module_title, module_title_clean FROM $t_courses_modules WHERE module_course_id=$get_current_course_id ORDER BY module_number ASC";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_module_id, $get_module_course_id, $get_module_course_title, $get_module_number, $get_module_title, $get_module_title_clean) = $row;

		// Did I complete this module?
		if(isset($my_user_id)){
			$query_m = "SELECT module_read_id FROM $t_courses_modules_read WHERE read_course_id=$get_current_course_id AND read_module_id=$get_module_id AND read_user_id=$my_user_id_mysql";
			$result_m = mysqli_query($link, $query_m);
			$row_m = mysqli_fetch_row($result_m);
			list($get_module_read_id) = $row_m;


			if($get_module_read_id == "" && $get_module_id == "$module_id"){
				$inp_course_title_mysql = quote_smart($link, $get_current_course_title);
				$inp_module_title_mysql = quote_smart($link, $get_module_title);

				mysqli_query($link, "INSERT INTO $t_courses_modules_read 
				(module_read_id, read_course_id, read_course_title, read_module_id, read_module_title, read_user_id) 
				VALUES 
				(NULL, $get_current_course_id, $inp_course_title_mysql, $get_module_id, $inp_module_title_mysql, $my_user_id_mysql)");

				// Give point
				$query_u = "SELECT user_id, user_name, user_alias, user_points FROM $t_users WHERE user_id=$my_user_id_mysql";
				$result_u = mysqli_query($link, $query_u);
				$row_u = mysqli_fetch_row($result_u);
				list($get_my_user_id, $get_my_user_name, $get_my_user_alias, $get_my_user_points) = $row_u;
				
				$inp_user_points = $get_my_user_points +1;

				$result_u = mysqli_query($link, "UPDATE $t_users SET user_points=$inp_user_points WHERE user_id=$get_my_user_id");
			}

		}
		else{
			$get_module_read_id = "";
		}

		echo"
";
		echo"					";

		if($get_module_number == "1"){
			echo"<li class=\"header_home\"><a href=\"$root/$get_current_course_title_clean/$get_module_title_clean/index.php?course_id=$get_current_course_id&amp;module_id=$get_module_id&amp;l=$l\" id=\"navigation_module_id_$get_module_id\">$get_module_course_title</a></li>
";


			echo"					";
			echo"<li><a href=\"$root/$get_current_course_title_clean/index.php?l=$l\">";
			if($get_current_enrolled_id != ""){
				echo"<img src=\"$root/courses/_images/icons/navigation_lesson_read.png\" alt=\"navigation_lesson_read.png\" />"; 
			}
			echo"$l_index</a></li>
";
		}
		else{
			echo"<li class=\"header_up\"><a href=\"$root/$get_current_course_title_clean/$get_module_title_clean/index.php?course_id=$get_current_course_id&amp;module_id=$get_module_id&amp;l=$l\" id=\"navigation_module_id_$get_module_id\">$get_module_title</a></li>
";


		}
		// Get lessons
		$query_lessons = "SELECT lesson_id, lesson_number, lesson_title, lesson_title_clean, lesson_title_length, lesson_title_short FROM $t_courses_lessons WHERE lesson_module_id=$get_module_id ORDER BY lesson_number ASC";
		$result_lessons = mysqli_query($link, $query_lessons);
		while($row_lessons = mysqli_fetch_row($result_lessons)) {
			list($get_lesson_id, $get_lesson_number, $get_lesson_title, $get_lesson_title_clean, $get_lesson_title_length, $get_lesson_title_short) = $row_lessons;

			// Did I complete this lesson?
			if(isset($my_user_id)){
				$query_m = "SELECT lesson_read_id FROM $t_courses_lessons_read WHERE read_course_id=$get_current_course_id AND read_lesson_id=$get_lesson_id AND read_user_id=$my_user_id_mysql";
				$result_m = mysqli_query($link, $query_m);
				$row_m = mysqli_fetch_row($result_m);
				list($get_lesson_read_id) = $row_m;

				if($get_lesson_read_id == "" && $get_lesson_id == "$lesson_id"){
					$inp_course_title_mysql = quote_smart($link, $get_current_course_title);
					$inp_module_title_mysql = quote_smart($link, $get_module_course_title);
					$inp_lesson_title_mysql = quote_smart($link, $get_lesson_title);

					mysqli_query($link, "INSERT INTO $t_courses_lessons_read 
					(lesson_read_id, read_course_id, read_course_title, read_module_id, read_module_title, read_lesson_id, read_lesson_title, read_user_id) 
					VALUES 
					(NULL, $get_current_course_id, $inp_course_title_mysql, $get_module_id, $inp_module_title_mysql, $get_lesson_id, $inp_lesson_title_mysql, $my_user_id_mysql)");
					
					// Read ID
					$query_m = "SELECT lesson_read_id FROM $t_courses_lessons_read WHERE read_course_id=$get_current_course_id AND read_lesson_id=$get_lesson_id AND read_user_id=$my_user_id_mysql";
					$result_m = mysqli_query($link, $query_m);
					$row_m = mysqli_fetch_row($result_m);
					list($get_lesson_read_id) = $row_m;

					// Give point
					$query_u = "SELECT user_id, user_name, user_alias, user_points FROM $t_users WHERE user_id=$my_user_id_mysql";
					$result_u = mysqli_query($link, $query_u);
					$row_u = mysqli_fetch_row($result_u);
					list($get_my_user_id, $get_my_user_name, $get_my_user_alias, $get_my_user_points) = $row_u;

					$inp_user_points = $get_my_user_points+1;

					$result_u = mysqli_query($link, "UPDATE $t_users SET user_points=$inp_user_points WHERE user_id=$get_my_user_id");

				}

			}
			else{
				$get_lesson_read_id = "";
			}


			echo"					";
			echo"<li><a href=\"$root/$get_current_course_title_clean/$get_module_title_clean/$get_lesson_title_clean.php?course_id=$get_current_course_id&amp;module_id=$get_module_id&amp;lesson_id=$get_lesson_id&amp;l=$l\" "; if($get_lesson_id == "$lesson_id"){ echo" class=\"navigation_active\""; } echo" id=\"navigation_lesson_id_$get_lesson_id\"";
			if($get_lesson_title_length  > 30){
				echo" title=\"$get_lesson_title\""; 
			}
			echo">";
			if($get_lesson_read_id != ""){ 
				echo"<img src=\"$root/courses/_images/icons/navigation_lesson_read.png\" alt=\"navigation_lesson_read.png\" />"; 
			}
			if($get_lesson_title_length  > 30){
				echo"$get_lesson_title_short";
			}
			else{
				echo"$get_lesson_title";
			}
			echo"</a></li>
";
		} // Lessons
	} // modules
	// Nav stop

	// Find exam
	$query = "SELECT exam_id, exam_course_id, exam_course_title, exam_language, exam_total_questions, exam_total_points, exam_points_needed_to_pass FROM $t_courses_exams_index WHERE exam_course_id=$get_current_course_id";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_exam_id, $get_current_exam_course_id, $get_current_exam_course_title, $get_current_exam_language, $get_current_exam_total_questions, $get_current_exam_total_points, $get_current_exam_points_needed_to_pass) = $row;
	if($get_current_exam_id != ""){

		// Check if I've completed exam
		$get_current_try_id = "";
		if(isset($my_user_id)){
			$query_m = "SELECT try_id, try_course_id, try_course_title, try_exam_id, try_user_id, try_started_datetime, try_started_time, try_started_saying, try_is_closed, try_ended_datetime, try_ended_time, try_ended_saying, try_finished_saying, try_time_used, try_percentage, try_passed FROM $t_courses_exams_user_tries WHERE try_course_id=$get_current_course_id AND try_user_id=$my_user_id_mysql AND try_passed=1";
			$result_m = mysqli_query($link, $query_m);
			$row_m = mysqli_fetch_row($result_m);
			list($get_current_try_id, $get_current_try_course_id, $get_current_try_course_title, $get_current_try_exam_id, $get_current_try_user_id, $get_current_try_started_datetime, $get_current_try_started_time, $get_current_try_started_saying, $get_current_try_is_closed, $get_current_try_ended_datetime, $get_current_try_ended_time, $get_current_try_ended_saying, $get_current_try_finished_saying, $get_current_try_time_used, $get_current_try_percentage, $get_current_try_passed) = $row_m;
		}

		echo"
";
		echo"					";
		echo"<li class=\"header_up\"><a href=\"$root/$get_current_course_title_clean/exam.php?course_id=$get_current_course_id&amp;module_id=$get_module_id&amp;l=$l\">$l_exam</a></li>
";

		// Take exam
		echo"					";
		echo"<li><a href=\"$root/$get_current_course_title_clean/exam.php?course_id=$get_current_course_id&amp;module_id=$get_module_id&amp;l=$l\" id=\"navigation_exam\">";
		if($get_current_try_id != ""){ 
			echo"<img src=\"$root/courses/_images/icons/navigation_lesson_read.png\" alt=\"navigation_lesson_read.png\" />"; 
		}
		echo"$l_exam_index</a></li>
";


	}

	echo"
				</ul> <!-- //toc -->
	";

	// Scroll to module
	if($module_id !=""){
		echo"
		<script> 
		\$(document).ready(function(){
			var elmnt = document.getElementById(\"navigation_module_id_$module_id\");
			elmnt.scrollIntoView();
		});
		</script>
		";
	}
} // course found
?>

			