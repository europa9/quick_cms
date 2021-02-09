<?php
/**
*
* File: _admin/_inc/exercise/view_tag.php
* Version 1.0.0
* Date 20:53 09.02.2018
* Copyright (c) 2008-2018 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Configuration --------------------------------------------------------------------- */
$pageIdSav            = "2";
$pageNoColumnSav      = "2";
$pageAllowCommentsSav = "0";

/*- Root dir -------------------------------------------------------------------------- */
// This determine where we are
if(file_exists("favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
elseif(file_exists("../../../../favicon.ico")){ $root = "../../../.."; }
else{ $root = "../../.."; }

/*- Website config -------------------------------------------------------------------- */
include("$root/_admin/website_config.php");

/*- Tables ---------------------------------------------------------------------------- */
include("_tables_exercises.php");


/*- Get extention ---------------------------------------------------------------------- */
function getExtension($str) {
	$i = strrpos($str,".");
	if (!$i) { return ""; } 
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	return $ext;
}


/*- Variables ------------------------------------------------------------------------- */
$l_mysql = quote_smart($link, $l);
if(isset($_GET['tag'])){
	$tag = $_GET['tag'];
	$tag = output_html($tag);
}
else{
	$tag = "";
}

/*- Scriptstart ---------------------------------------------------------------------- */


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_exercises - #$tag";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

echo"
<!-- Headline -->
	<h1>#$tag</h1> 
<!-- //Headline -->


<!-- Where am I? -->
	<p>
	<b>$l_you_are_here:</b><br />
	<a href=\"$root/exercises/index.php?l=$l\">$l_exercises</a>
	&gt;
	<a href=\"$root/exercises/view_tag.php?tag=$tag&amp;l=$l\">#$tag</a>
	</p>
<!-- //Where am I? -->


<!-- Exercises -->
	";
	$x = 0;
	$tag_mysql = quote_smart($link, $tag);
	$query = "SELECT $t_exercise_index_tags.tag_id, $t_exercise_index_tags.tag_exercise_id, $t_exercise_index.exercise_id, $t_exercise_index.exercise_title, $t_exercise_index.exercise_user_id, $t_exercise_index.exercise_muscle_group_id_main, $t_exercise_index.exercise_equipment_id, $t_exercise_index.exercise_type_id, $t_exercise_index.exercise_level_id, $t_exercise_index.exercise_updated_datetime, $t_exercise_index.exercise_guide FROM $t_exercise_index_tags JOIN $t_exercise_index ON $t_exercise_index_tags.tag_exercise_id=$t_exercise_index.exercise_id WHERE $t_exercise_index_tags.tag_language=$l_mysql AND $t_exercise_index_tags.tag_clean=$tag_mysql";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_tag_id, $get_tag_exercise_id, $get_exercise_id, $get_exercise_title, $get_exercise_user_id, $get_exercise_muscle_group_id_main, $get_exercise_equipment_id, $get_exercise_type_id, $get_exercise_level_id, $get_exercise_updated_datetime, $get_exercise_guide) = $row;
		
		if($x == 0){
			echo"
			<div class=\"clear\" style=\"height: 10px;\"></div>
			<div class=\"left_right_left\">
			";
		}
		elseif($x == 1){
			echo"
			<div class=\"left_right_right\">
			";
		}




		echo"
				<p style=\"padding: 10px 0px 0px 0px;margin-bottom:0;\">
				<a href=\"view_exercise.php?exercise_id=$get_exercise_id&amp;type_id=$get_exercise_type_id&amp;main_muscle_group_id=$get_exercise_muscle_group_id_main&amp;l=$l\" class=\"exercise_index_title\">$get_exercise_title</a><br />
				</p>\n";
					// Images
					$query_images = "SELECT exercise_image_id, exercise_image_type, exercise_image_path, exercise_image_file, exercise_image_thumb_medium FROM $t_exercise_index_images WHERE exercise_image_exercise_id='$get_exercise_id' ORDER BY exercise_image_type ASC LIMIT 0,2";
					$result_images = mysqli_query($link, $query_images);
					while($row_images = mysqli_fetch_row($result_images)) {
						list($get_exercise_image_id, $get_exercise_image_type, $get_exercise_image_path, $get_exercise_image_file, $get_exercise_image_thumb_medium) = $row_images;

						if($get_exercise_image_file != "" && file_exists("$root/$get_exercise_image_path/$get_exercise_image_file")){
							
							if(!(file_exists("../$get_exercise_image_path/$get_exercise_image_thumb_medium"))){
								$extension = getExtension($get_exercise_image_file);
								$extension = strtolower($extension);

								$thumb = substr($get_exercise_image_file, 0, -4);
								$thumb = $thumb . "_thumb_medium." . $extension;
								$thumb_mysql = quote_smart($link, $thumb);

								// Thumb
								$inp_new_x = 150;
								$inp_new_y = 150;
								resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_exercise_image_path/$get_exercise_image_file", "$root/$get_exercise_image_path/$get_exercise_image_thumb_medium");

								$result_update = mysqli_query($link, "UPDATE $t_exercise_index_images SET exercise_image_thumb_medium=$thumb_mysql WHERE exercise_image_id=$get_exercise_image_id") or die(mysqli_error($link));
							}
							if($get_exercise_image_thumb_medium == ""){
								$extension = getExtension($get_exercise_image_file);
								$extension = strtolower($extension);

								$thumb = substr($get_exercise_image_file, 0, -4);
								$thumb = $thumb . "_thumb_medium." . $extension;
								$thumb_mysql = quote_smart($link, $thumb);

								$result_update = mysqli_query($link, "UPDATE $t_exercise_index_images SET exercise_image_thumb_medium=$thumb_mysql WHERE exercise_image_id=$get_exercise_image_id") or die(mysqli_error($link));
							}

							echo"				";
							echo"<a href=\"view_exercise.php?exercise_id=$get_exercise_id&amp;type_id=$get_exercise_type_id&amp;main_muscle_group_id=$get_exercise_muscle_group_id_main&amp;l=$l\"><img src=\"$root/$get_exercise_image_path/$get_exercise_image_thumb_medium\" alt=\"$get_exercise_image_thumb_medium\" /></a>\n";
						}
					}
					echo"
			</div>
		";
		if($x == 1){
			$x = -1;
		}
		$x++;

	}
	echo"

<!-- //Exercises -->
";

?>