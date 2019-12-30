<?php
/**
*
* File: courses/index.php
* Version 2.0.0
* Date 22:38 03.05.2019
* Copyright (c) 2011-2019 Localhost
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "201905032238";
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

/*- Header ----------------------------------------------------------- */
$website_title = "Courses";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------- */

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




echo"
<h1>$get_current_courses_title_translation_title</h1> 
";

// Get all categories
$categories_count = 0;
$query = "SELECT category_id, category_title, category_dir_name, category_description FROM $t_courses_categories WHERE category_language=$l_mysql ORDER BY category_title ASC";
$result = mysqli_query($link, $query);
while($row = mysqli_fetch_row($result)) {
	list($get_category_id, $get_category_title, $get_category_dir_name, $get_category_description) = $row;
	
	if($categories_count != 0){
		echo"<div style=\"height: 20px;\"></div><hr />";
	}
	echo"
	<p><a href=\"open_category.php?category=$get_category_dir_name&amp;l=$l\" class=\"h2\">$get_category_title</a></p>
	";

	// Get all courses
	$layout = "";
	$previous_course_title = "";
	$query_courses = "SELECT course_id, course_title, course_short_introduction, course_dir_name, course_icon_48, course_icon_64, course_icon_96 FROM $t_courses_index WHERE course_category_id=$get_category_id ORDER BY course_title ASC";
	$result_courses = mysqli_query($link, $query_courses);
	while($row_courses = mysqli_fetch_row($result_courses)) {
		list($get_course_id, $get_course_title, $get_course_short_introduction, $get_course_dir_name, $get_course_icon_48, $get_course_icon_64, $get_course_icon_96) = $row_courses;
		
		if(isset($layout) && $layout == "left"){
			$layout = "right";
		}
		else{
			$layout = "left";
		}

		// Look for duplicates
		if($get_course_title == "$previous_course_title"){
			echo"<div class=\"error\"><p>Duplicate found. Will delete now</p></div>";
			$course_dir_name_mysql = quote_smart($link, $get_course_dir_name);
			$result_delete = mysqli_query($link, "DELETE FROM $t_courses_index WHERE course_dir_name=$course_dir_name_mysql") or die(mysqli_error($link));
			$result_delete = mysqli_query($link, "DELETE FROM $t_courses_modules WHERE module_course_dir_name=$course_dir_name_mysql") or die(mysqli_error($link));
			$result_delete = mysqli_query($link, "DELETE FROM $t_courses_modules_contents WHERE content_course_dir_name=$course_dir_name_mysql") or die(mysqli_error($link));

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

		// Send parameters
		$previous_course_title = "$get_course_title";
	}

	if($layout == "left"){
		echo"<div class=\"course_right\"></div><div class=\"clear\"></div>";
	}
	$layout = "";

	// Increment
	$categories_count++;

} // while categories
echo"
<div class=\"clear\"></div>
<p>
&nbsp;
</p>
";

/*- Footer ----------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>