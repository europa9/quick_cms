<?php
/**
*
* File: _admin/_inc/comments/courses_edit.php
* Version 
* Date 20:17 30.10.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

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

$query = "SELECT course_id, course_title, course_description, course_contents, course_language, course_dir_name, course_category_id, course_intro_video_embedded, course_icon_48, course_icon_64, course_icon_96, course_modules_count, course_lessons_count, course_quizzes_count, course_users_enrolled_count, course_read_times, course_created, course_updated FROM $t_courses_index WHERE course_id=$course_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_course_id, $get_current_course_title, $get_current_course_description, $get_current_course_contents, $get_current_course_language, $get_current_course_dir_name, $get_current_course_category_id, $get_current_course_intro_video_embedded, $get_current_course_icon_48, $get_current_course_icon_64, $get_current_course_icon_96, $get_current_course_modules_count, $get_current_course_lessons_count, $get_current_course_quizzes_count, $get_current_course_users_enrolled_count, $get_current_course_read_times, $get_current_course_created, $get_current_course_updated) = $row;

if($get_current_course_id == ""){
	echo"<p>Server error 404.</p>";
}
else{
	// Find category
	$query = "SELECT category_id, category_title, category_dir_name, category_description, category_language, category_created, category_updated FROM $t_courses_categories WHERE category_id=$get_current_course_category_id";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_category_id, $get_current_category_title, $get_current_category_dir_name, $get_current_category_description, $get_current_category_language, $get_current_category_created, $get_current_category_updated) = $row;


	if($action == ""){
		if($process == "1"){
			$inp_title = $_POST['inp_title'];
			$inp_title = output_html($inp_title);
			$inp_title_mysql = quote_smart($link, $inp_title);

			$inp_description = $_POST['inp_description'];
			$inp_description = output_html($inp_description);
			$inp_description_mysql = quote_smart($link, $inp_description);

			$inp_contents = $_POST['inp_contents'];
			$inp_contents = output_html($inp_contents);
			$inp_contents_mysql = quote_smart($link, $inp_contents);

			$inp_language = $_POST['inp_language'];
			$inp_language = output_html($inp_language);
			$inp_language_mysql = quote_smart($link, $inp_language);

			$inp_dir_name = $_POST['inp_dir_name'];
			$inp_dir_name = output_html($inp_dir_name);
			$inp_dir_name_mysql = quote_smart($link, $inp_dir_name);
	
			$inp_category_id = $_POST['inp_category_id'];
			$inp_category_id = output_html($inp_category_id);
			$inp_category_id_mysql = quote_smart($link, $inp_category_id);

			$inp_intro_video_embedded = $_POST['inp_intro_video_embedded'];
			$inp_intro_video_embedded = output_html($inp_intro_video_embedded);
			$inp_intro_video_embedded_mysql = quote_smart($link, $inp_intro_video_embedded);



			$datetime = date("Y-m-d H:i:s");


			$result = mysqli_query($link, "UPDATE $t_courses_index SET 
				course_title=$inp_title_mysql, 
				course_description=$inp_description_mysql, 
				course_contents=$inp_contents_mysql, 
				course_language=$inp_language_mysql, 
				course_dir_name=$inp_dir_name_mysql, 
				course_category_id=$inp_category_id_mysql, 
				course_intro_video_embedded=$inp_intro_video_embedded_mysql, 
				course_updated='$datetime'
				WHERE course_id=$get_current_course_id") or die(mysqli_error($link));



			// Header
			$url = "index.php?open=$open&page=courses_index&category_id=$inp_category_id&editor_language=$editor_language&ft=success&fm=changes_saved#course$get_current_course_id";
			header("Location: $url");
			exit;
		}

		echo"
		<h1>Edit course $get_current_category_title</h1>
				

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
			<a href=\"index.php?open=courses&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">Courses</a>
			&gt;
			<a href=\"index.php?open=courses&amp;page=default&amp;editor_language=$editor_language&amp;l=$l\">Categories</a>
			&gt;
			<a href=\"index.php?open=courses&amp;page=courses_index&amp;category_id=$get_current_category_id&amp;editor_language=$editor_language&amp;l=$l\">$get_current_category_title</a>
			&gt;
			<a href=\"index.php?open=courses&amp;page=courses_edit&amp;course_id=$get_current_course_id&amp;editor_language=$editor_language&amp;l=$l\">Edit $get_current_category_title</a>
			</p>
		<!-- //Where am I? -->


		<!-- Edit course form -->
		
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_title\"]').focus();
			});
			</script>
			
			<form method=\"post\" action=\"index.php?open=courses&amp;page=courses_edit&amp;course_id=$get_current_course_id&amp;editor_language=$editor_language&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

			<p><b>Title:</b><br />
			<input type=\"text\" name=\"inp_title\" value=\"$get_current_course_title\" size=\"25\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
			</p>

			<p><b>Description:</b><br />
			<textarea name=\"inp_description\" rows=\"8\" cols=\"60\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">";
			$get_current_course_description = str_replace("<br />", "\n", $get_current_course_description);
			echo"$get_current_course_description</textarea>
			</p>

			<p><b>Contents:</b><br />
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

			<p><b>Directory name:</b><br />
			<input type=\"text\" name=\"inp_dir_name\" value=\"$get_current_course_dir_name\" size=\"25\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
			</p>

			<p><b>Category:</b><br />
			<select name=\"inp_category_id\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">\n";
			$query = "SELECT category_id, category_title, category_description, category_language, category_created, category_updated FROM $t_courses_categories ORDER BY category_title ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_category_id, $get_category_title, $get_category_description, $get_category_language, $get_category_created, $get_category_updated) = $row;

				echo"	<option value=\"$get_category_id\""; if($get_category_id == "$get_current_course_category_id"){ echo" selected=\"selected\""; } echo">$get_category_title</option>\n";
			}
			echo"
			</select>

			<p><b>Intro video embedded:</b><br />
			<input type=\"text\" name=\"inp_intro_video_embedded\" value=\"$get_current_course_intro_video_embedded\" size=\"25\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
			</p>

			<p><input type=\"submit\" value=\"Save changes\" class=\"btn_default\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>

			</form>
		<!-- //Edit course form -->
		";
	} // action ==""
} // found
?>