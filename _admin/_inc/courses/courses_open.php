<?php
/**
*
* File: _admin/_inc/comments/courses_open.php
* Version 
* Date 15:13 15.09.2019
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
$t_courses_liquidbase 	 = $mysqlPrefixSav . "courses_liquidbase";


$t_courses_title_translations	 = $mysqlPrefixSav . "courses_title_translations";
$t_courses_index		 = $mysqlPrefixSav . "courses_index";
$t_courses_users_enrolled 	 = $mysqlPrefixSav . "courses_users_enrolled";

$t_courses_categories_main	 = $mysqlPrefixSav . "courses_categories_main";
$t_courses_categories_sub 	 = $mysqlPrefixSav . "courses_categories_sub";
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

/*- Tables search --------------------------------------------------------------------- */
$t_search_engine_index 		= $mysqlPrefixSav . "search_engine_index";
$t_search_engine_access_control = $mysqlPrefixSav . "search_engine_access_control";


/*- Variables ------------------------------------------------------------------------ */
$tabindex = 0;
if(isset($_GET['course_id'])){
	$course_id = $_GET['course_id'];
	$course_id = strip_tags(stripslashes($course_id));
}
else{
	$course_id = "";
}
$course_id_mysql = quote_smart($link, $course_id);

$query = "SELECT course_id, course_title, course_title_clean, course_is_active, course_front_page_intro, course_description, course_contents, course_language, course_main_category_id, course_main_category_title, course_sub_category_id, course_sub_category_title, course_intro_video_embedded, course_image_file, course_image_thumb, course_icon_48, course_icon_64, course_icon_96, course_modules_count, course_lessons_count, course_quizzes_count, course_users_enrolled_count, course_read_times, course_read_times_ip_block, course_created, course_updated FROM $t_courses_index WHERE course_id=$course_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_course_id, $get_current_course_title, $get_current_course_title_clean, $get_current_course_is_active, $get_current_course_front_page_intro, $get_current_course_description, $get_current_course_contents, $get_current_course_language, $get_current_course_main_category_id, $get_current_course_main_category_title, $get_current_course_sub_category_id, $get_current_course_sub_category_title, $get_current_course_intro_video_embedded, $get_current_course_image_file, $get_current_course_image_thumb, $get_current_course_icon_48, $get_current_course_icon_64, $get_current_course_icon_96, $get_current_course_modules_count, $get_current_course_lessons_count, $get_current_course_quizzes_count, $get_current_course_users_enrolled_count, $get_current_course_read_times, $get_current_course_read_times_ip_block, $get_current_course_created, $get_current_course_updated) = $row;

if($get_current_course_id == ""){
	echo"<p>Server error 404.</p>";
}
else{
	// Find category
	$query = "SELECT main_category_id, main_category_title, main_category_title_clean, main_category_description, main_category_language, main_category_created, main_category_updated FROM $t_courses_categories_main WHERE main_category_id=$get_current_course_main_category_id";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_main_category_id, $get_current_main_category_title, $get_current_main_category_title_clean, $get_current_main_category_description, $get_current_main_category_language, $get_current_main_category_created, $get_current_main_category_updated) = $row;

	$query = "SELECT sub_category_id, sub_category_title, sub_category_title_clean, sub_category_description, sub_category_main_category_id, sub_category_main_category_title, sub_category_language, sub_category_created, sub_category_updated FROM $t_courses_categories_sub WHERE sub_category_id=$get_current_course_sub_category_id";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_sub_category_id, $get_current_sub_category_title, $get_current_sub_category_title_clean, $get_current_sub_category_description, $get_current_sub_category_main_category_id, $get_current_sub_category_main_category_title, $get_current_sub_category_language, $get_current_sub_category_created, $get_current_sub_category_updated) = $row;


	if($action == ""){
		if($process == "1"){
			$inp_title = $_POST['inp_title'];
			$inp_title = output_html($inp_title);
			$inp_title_mysql = quote_smart($link, $inp_title);
	
			$inp_title_clean = clean($inp_title);
			$inp_title_clean_mysql = quote_smart($link, $inp_title_clean);

			$inp_front_page_intro = $_POST['inp_front_page_intro'];
			$inp_front_page_intro = output_html($inp_front_page_intro);
			$inp_front_page_intro_mysql = quote_smart($link, $inp_front_page_intro);

			$inp_description = $_POST['inp_description'];
			$inp_description = output_html($inp_description);
			$inp_description_mysql = quote_smart($link, $inp_description);

			$inp_contents = $_POST['inp_contents'];
			$inp_contents = output_html($inp_contents);
			$inp_contents_mysql = quote_smart($link, $inp_contents);

			$inp_language = $_POST['inp_language'];
			$inp_language = output_html($inp_language);
			$inp_language_mysql = quote_smart($link, $inp_language);

			$inp_intro_video_embedded = $_POST['inp_intro_video_embedded'];
			$inp_intro_video_embedded = output_html($inp_intro_video_embedded);
			$inp_intro_video_embedded_mysql = quote_smart($link, $inp_intro_video_embedded);

			$datetime = date("Y-m-d H:i:s");


			$result = mysqli_query($link, "UPDATE $t_courses_index SET 
							course_title=$inp_title_mysql,
							course_title_clean=$inp_title_clean_mysql,
							course_front_page_intro=$inp_front_page_intro_mysql,
							course_description=$inp_description_mysql,
							course_contents=$inp_contents_mysql,
							course_language=$inp_language_mysql,
							course_intro_video_embedded=$inp_intro_video_embedded_mysql,
							course_updated='$datetime'
							WHERE course_id=$get_current_course_id") or die(mysqli_error($link));
			// Category
			$inp_category_id = $_POST['inp_category_id'];
			$inp_category_id = output_html($inp_category_id);
			$inp_category_id_mysql = quote_smart($link, $inp_category_id);
			if($inp_category_id != "0" && $inp_category_id != "$get_current_course_sub_category_id"){
				// Find this new sub category
				$query = "SELECT sub_category_id, sub_category_title, sub_category_main_category_id FROM $t_courses_categories_sub WHERE sub_category_id=$inp_category_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_new_sub_category_id, $get_new_sub_category_title, $get_new_sub_category_main_category_id) = $row;

				if($get_new_sub_category_id != ""){
					// Find new main category
					$query = "SELECT main_category_id, main_category_title FROM $t_courses_categories_main WHERE main_category_id=$get_new_sub_category_main_category_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_new_main_category_id, $get_new_main_category_title) = $row;

					$inp_sub_category_id_mysql = quote_smart($link, $get_new_sub_category_id);
					$inp_sub_category_title_mysql = quote_smart($link, $get_new_sub_category_title);

					$inp_main_category_id_mysql = quote_smart($link, $get_new_main_category_id);
					$inp_main_category_title_mysql = quote_smart($link, $get_new_main_category_title);

					$result = mysqli_query($link, "UPDATE $t_courses_index SET 
								course_main_category_id=$inp_main_category_id_mysql, 
								course_main_category_title=$inp_main_category_title_mysql,
								course_sub_category_id=$inp_sub_category_id_mysql, 
								course_sub_category_title=$inp_sub_category_title_mysql
							WHERE course_id=$get_current_course_id") or die(mysqli_error($link));
				}
			} // new category


			// Title
			$l_mysql = quote_smart($link, $l);
			$query = "SELECT courses_title_translation_id, courses_title_translation_title FROM $t_courses_title_translations WHERE courses_title_translation_language=$l_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_courses_title_translation_id, $get_current_courses_title_translation_title) = $row;
			if($get_current_courses_title_translation_id == ""){
				mysqli_query($link, "INSERT INTO $t_courses_title_translations
				(courses_title_translation_id, courses_title_translation_title, courses_title_translation_language) 
				VALUES 
				(NULL, 'Courses', $l_mysql)")
				or die(mysqli_error($link));
				$get_current_courses_title_translation_title = "Courses";
			}



			// Search engine
			$query_exists = "SELECT index_id FROM $t_search_engine_index WHERE index_module_name='courses' AND index_reference_name='course_id' AND index_reference_id=$get_current_course_id";
			$result_exists = mysqli_query($link, $query_exists);
			$row_exists = mysqli_fetch_row($result_exists);
			list($get_index_id) = $row_exists;
			if($get_index_id != ""){
				$datetime = date("Y-m-d H:i:s");
				$datetime_saying = date("j M Y H:i");
				
				$inp_index_title = "$inp_title | $get_current_courses_title_translation_title";
				$inp_index_title_mysql = quote_smart($link, $inp_index_title);
				
				$result = mysqli_query($link, "UPDATE $t_search_engine_index SET 
								index_title=$inp_index_title_mysql, 
								index_url=$inp_title_clean_mysql,
								index_short_description=$inp_front_page_intro_mysql,
								index_updated_datetime='$datetime', 
								index_updated_datetime_print='$datetime_saying'
							WHERE index_id=$get_index_id") or die(mysqli_error($link));
			}


			$url = "index.php?open=courses&page=courses_open&course_id=$get_current_course_id&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;
		} // process

		echo"
		<h1>$get_current_course_title</h1>
				

		<!-- Feedback -->
		";
		if($ft != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			else{
				$fm = ucfirst($fm);
			}
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
		<!-- //Feedback -->

		<!-- Where am I? -->
			<p><b>You are here:</b><br />
			<a href=\"index.php?open=courses&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Courses menu</a>
			&gt;
			<a href=\"index.php?open=courses&amp;page=default&amp;editor_language=$editor_language&amp;l=$l\">Courses</a>
			&gt;
			<a href=\"index.php?open=courses&amp;page=open_main_category&amp;main_category_id=$get_current_course_main_category_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_course_main_category_title</a>
			&gt;
			<a href=\"index.php?open=courses&amp;page=open_sub_category&amp;sub_category_id=$get_current_course_sub_category_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_course_sub_category_title</a>
			&gt;
			<a href=\"index.php?open=courses&amp;page=courses_open&amp;course_id=$course_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_course_title</a>
			</p>
		<!-- //Where am I? -->

		<!-- Course navigation -->
			<div class=\"tabs\">
				<ul>
					<li><a href=\"index.php?open=courses&amp;page=courses_open&amp;course_id=$course_id&amp;editor_language=$editor_language&amp;l=$l\" class=\"active\">Info</a>
					<li><a href=\"index.php?open=courses&amp;page=courses_modules_and_lessons&amp;course_id=$course_id&amp;editor_language=$editor_language&amp;l=$l\">Modules and lessons</a>
					<li><a href=\"index.php?open=courses&amp;page=courses_image&amp;course_id=$course_id&amp;editor_language=$editor_language&amp;l=$l\">Image</a>
					<li><a href=\"index.php?open=courses&amp;page=courses_icon&amp;course_id=$course_id&amp;editor_language=$editor_language&amp;l=$l\">Icon</a>
					<li><a href=\"index.php?open=courses&amp;page=courses_exam&amp;course_id=$course_id&amp;editor_language=$editor_language&amp;l=$l\">Exam</a>
					<li><a href=\"index.php?open=courses&amp;page=courses_read_from_file&amp;course_id=$course_id&amp;editor_language=$editor_language&amp;l=$l\">Read from file</a>
					<li><a href=\"index.php?open=courses&amp;page=courses_write_to_file&amp;course_id=$course_id&amp;editor_language=$editor_language&amp;l=$l\">Write to file</a>
					<li><a href=\"index.php?open=courses&amp;page=courses_delete&amp;course_id=$course_id&amp;editor_language=$editor_language&amp;l=$l\">Delete</a>
				</ul>
			</div>
			<div class=\"clear\" style=\"height: 10px;\"></div>
		<!-- //Course navigation -->


		<!-- Form -->
		
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_title\"]').focus();
			});
			</script>
			
			<form method=\"post\" action=\"index.php?open=courses&amp;page=courses_open&amp;course_id=$get_current_course_id&amp;editor_language=$editor_language&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p><b>Title:</b><br />
			<input type=\"text\" name=\"inp_title\" value=\"$get_current_course_title\" size=\"25\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
			</p>

			<p><b>Front page intro:</b><br />
			<textarea name=\"inp_front_page_intro\" rows=\"8\" cols=\"60\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">";
			$get_current_course_front_page_intro = str_replace("<br />", "\n", $get_current_course_front_page_intro);
			echo"$get_current_course_front_page_intro</textarea>
			</p>

			<p><b>Description:</b><br />
			<textarea name=\"inp_description\" rows=\"8\" cols=\"60\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">";
			$get_current_course_description = str_replace("<br />", "\n", $get_current_course_description);
			echo"$get_current_course_description</textarea>
			</p>

			<p><b>Contents (one bullet point at each line):</b><br />
			<textarea name=\"inp_contents\" rows=\"8\" cols=\"60\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">";
			$get_current_course_contents = str_replace("<br />", "\n", $get_current_course_contents);
			echo"$get_current_course_contents</textarea>
			</p>

			<p><b>Language:</b><br />
			<select name=\"inp_language\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">\n";
			$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;
				echo"	<option value=\"$get_language_active_iso_two\""; if($get_language_active_iso_two == "$get_current_course_language"){ echo" selected=\"selected\""; } echo">$get_language_active_name</option>\n";
			}
			echo"
			</select>

			<p><b>Category:</b><br />
			<select name=\"inp_category_id\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">\n";
			$query = "SELECT main_category_id, main_category_title FROM $t_courses_categories_main ORDER BY main_category_title ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_main_category_id, $get_main_category_title) = $row;

				echo"	<option value=\"0\""; if($get_main_category_id == "x"){ echo" selected=\"selected\""; } echo">$get_main_category_title</option>\n";

				$query_sub = "SELECT sub_category_id, sub_category_title FROM $t_courses_categories_sub WHERE sub_category_main_category_id=$get_main_category_id ORDER BY sub_category_title ASC";
				$result_sub = mysqli_query($link, $query_sub);
				while($row_sub = mysqli_fetch_row($result_sub)) {
					list($get_sub_category_id, $get_sub_category_title) = $row_sub;

					echo"	<option value=\"$get_sub_category_id\""; if($get_sub_category_id == "$get_current_course_sub_category_id"){ echo" selected=\"selected\""; } echo">&nbsp; &nbsp; $get_sub_category_title</option>\n";
				}
			}
			echo"
			</select>

			<p><b>Intro video embedded:</b><br />
			<input type=\"text\" name=\"inp_intro_video_embedded\" value=\"$get_current_course_intro_video_embedded\" size=\"25\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
			</p>

			<p><input type=\"submit\" value=\"Save changes\" class=\"btn_default\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>

			</form>
		<!-- //Form -->
		";
	} // action ==""
} // found
?>