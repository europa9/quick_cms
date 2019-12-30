<?php
/**
*
* File: courses/open_category.php
* Version 2.0.0
* Date 22:38 03.05.2019
* Copyright (c) 2011-2019 Localhost
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "201905032247";
$layoutNumberOfColumn = "2";
$layoutCommentsActive = "0";

/*- Root dir --------------------------------------------------------------------------------- */
// This determine where we are
if(file_exists("favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
elseif(file_exists("../../../../favicon.ico")){ $root = "../../../.."; }
else{ $root = "../../.."; }

/*- Website config --------------------------------------------------------------------------- */
include("$root/_admin/website_config.php");

/*- Variables ------------------------------------------------------------------------ */
if(isset($_GET['category'])){
	$category = $_GET['category'];
	$category = strip_tags(stripslashes($category));
}
else{
	$category = "";
}
$category_mysql = quote_smart($link, $category);



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

// Category
$query = "SELECT category_id, category_title, category_dir_name, category_description, category_language, category_created, category_updated FROM $t_courses_categories WHERE category_dir_name=$category_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_category_id, $get_current_category_title, $get_current_category_dir_name, $get_current_category_description, $get_current_category_language, $get_current_category_created, $get_current_category_updated) = $row;

if($get_current_category_id == ""){
	/*- Header ----------------------------------------------------------- */
	$website_title = "$get_current_courses_title_translation_title - Server error 404";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");

	echo"<p>Server error 404.</p>";
}
else{

	/*- Header ----------------------------------------------------------- */
	$website_title = "$get_current_courses_title_translation_title - $get_current_category_title";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");

	/*- Content ---------------------------------------------------------- */





	echo"
	<h1>$get_current_category_title</h1> 
	";

	// Get all courses
	$layout = "";
	$query_courses = "SELECT course_id, course_title, course_short_introduction, course_dir_name, course_icon_48, course_icon_64, course_icon_96 FROM $t_courses_index WHERE course_category_id=$get_current_category_id ORDER BY course_title ASC";
	$result_courses = mysqli_query($link, $query_courses);
	while($row_courses = mysqli_fetch_row($result_courses)) {
		list($get_course_id, $get_course_title, $get_course_short_introduction, $get_course_dir_name, $get_course_icon_48, $get_course_icon_64, $get_course_icon_96) = $row_courses;
		
		if(isset($layout) && $layout == "left"){
			$layout = "right";
		}
		else{
			$layout = "left";
		}
		// Intro lenght
		$len = strlen($get_course_short_introduction);
		if($len > 160){
			$get_course_short_introduction = substr($get_course_short_introduction, 0, 158);
			$get_course_short_introduction = $get_course_short_introduction . "..";
		}
		echo"
		<div class=\"course_$layout\">
			<div class=\"course\">
				<a href=\"$root/$get_course_dir_name/index.php?course=$get_course_dir_name&amp;l=$l\"><img src=\"$root/$get_course_dir_name/_images/$get_course_icon_96\" alt=\"$get_course_icon_96\" class=\"course_icon\" /></a>
		
		
				<div class=\"course_text\">
					<a href=\"$root/$get_course_dir_name/index.php?course=$get_course_dir_name&amp;l=$l\" class=\"h2\">$get_course_title</a>
					<p>
					$get_course_short_introduction
					</p>

					<a href=\"$root/$get_course_dir_name/index.php?course=$get_course_dir_name&amp;l=$l\" class=\"course_read_button\">Read</a>
				</div>
				<div class=\"clear\"></div>
			</div>
		</div>
		";
		if($layout == "right"){
			echo"<div class=\"clear\"></div>";
		}
	}

	if($layout == "left"){
		echo"<div class=\"course_right\"></div><div class=\"clear\"></div>";
	}
	$layout = "";


	echo"
	<div class=\"clear\"></div>
	<p>
	&nbsp;
	</p>
	";
} // Course found
/*- Footer ----------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>