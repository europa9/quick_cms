<?php
/**
*
* File: _admin/_inc/courses/new_main_category.php
* Version 
* Date 21:34 12.09.2019
* Copyright (c) 2008-2019 Sindre Andre Ditlefsen
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
/*- Variables ------------------------------------------------------------------------ */
$tabindex = 0;


if($action == ""){


	if($process == "1"){
		$inp_title = $_POST['inp_title'];
		$inp_title = output_html($inp_title);
		$inp_title_mysql = quote_smart($link, $inp_title);

		$inp_title_clean = clean($inp_title);
		$inp_title_clean_mysql = quote_smart($link, $inp_title_clean);

		$inp_language = $_POST['inp_language'];
		$inp_language = output_html($inp_language);
		$inp_language_mysql = quote_smart($link, $inp_language);

		$datetime = date("Y-m-d H:i:s");
		
		mysqli_query($link, "INSERT INTO $t_courses_categories_main
		(main_category_id, main_category_title, main_category_title_clean, main_category_description, main_category_language, main_category_created, main_category_updated) 
		VALUES 
		(NULL, $inp_title_mysql, $inp_title_clean_mysql, '', $inp_language_mysql, '$datetime', '$datetime')")
		or die(mysqli_error($link));

		// Get ID
		$query = "SELECT main_category_id FROM $t_courses_categories_main WHERE main_category_created='$datetime'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_main_category_id) = $row;



		// Header
		$url = "index.php?open=$open&page=categories_main&editor_language=$editor_language&ft=success&fm=category_created";
		header("Location: $url");
		exit;
	}

	echo"
	<h1>New main category</h1>
				

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
		<a href=\"index.php?open=courses&amp;page=default&amp;editor_language=$editor_language&amp;l=$l\">Courses</a>
		&gt;
		<a href=\"index.php?open=$open&amp;page=categories_main&amp;editor_language=$editor_language&amp;l=$l\">Categories</a>
		&gt;
		<a href=\"index.php?open=courses&amp;page=categories_main_new&amp;editor_language=$editor_language&amp;l=$l\">New category</a>
		</p>
	<!-- //Where am I? -->


	<!-- New course form -->
		
		<script>
		\$(document).ready(function(){
			\$('[name=\"inp_title\"]').focus();
		});
		</script>
			
		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;process=1\" enctype=\"multipart/form-data\">

		<p><b>Title:</b><br />
		<input type=\"text\" name=\"inp_title\" value=\"\" size=\"25\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
		</p>

		<p><b>Language:</b><br />
		<select name=\"inp_language\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\">\n";
		$query = "SELECT language_active_id, language_active_name, language_active_iso_two FROM $t_languages_active";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two) = $row;
			echo"	<option value=\"$get_language_active_iso_two\">$get_language_active_name</option>\n";
		}
		echo"
		</select>

		<p><input type=\"submit\" value=\"Create\" class=\"btn_default\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /></p>

		</form>
	<!-- //New course form -->
	";
}
?>