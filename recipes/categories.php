<?php 
/**
*
* File: recipes/categories.php
* Version 1.0.0
* Date 13:43 18.11.2017
* Copyright (c) 2011-2017 Localhost
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

/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/recipes/ts_recipes.php");


/*- Variables ------------------------------------------------------------------------- */
$l_mysql = quote_smart($link, $l);


/*- Check that dir exists -------------------------------------------------------------------- */
if(!(is_dir("$root/_uploads/recipes/categories"))){
	mkdir("$root/_uploads/recipes/categories");
}


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_recipes - $l_categories";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */
if($action == ""){
	echo"
	<h1>$l_categories</h1>

	
	";

	// Select categories
	$x = 0;
	$query = "SELECT category_id, category_name FROM $t_recipes_categories ORDER BY category_name ASC";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_category_id, $get_category_name) = $row;

		// Translations
		$query_t = "SELECT category_translation_id, category_translation_value, category_translation_image_path, category_translation_image FROM $t_recipes_categories_translations WHERE category_id=$get_category_id AND category_translation_language=$l_mysql";
		$result_t = mysqli_query($link, $query_t);
		$row_t = mysqli_fetch_row($result_t);
		list($get_category_translation_id, $get_category_translation_value, $get_category_translation_image_path, $get_category_translation_image) = $row_t;
		if($get_category_translation_id == ""){

			mysqli_query($link, "INSERT INTO $t_recipes_categories_translations
			(category_translation_id, category_id, category_translation_language, category_translation_value) 
			VALUES 
			(NULL, '$get_category_id', $l_mysql, '$get_category_name')")
			or die(mysqli_error($link));

			echo"<div class=\"info\">Missing translation! Please refresh!</div>";
		}



		if(file_exists("$root/$get_category_translation_image_path/$get_category_translation_image") && $get_category_translation_image != ""){
			if($x == 0){
				echo"
				<div class=\"clear\"></div>
				<div class=\"left_center_center_right_left\">
				";
			}
			elseif($x == 1){
				echo"
				<div class=\"left_center_center_left_right_center\">
				";
			}
			elseif($x == 2){
				echo"
				<div class=\"left_center_center_right_right_center\">
				";
			}
			elseif($x == 3){
				echo"
				<div class=\"left_center_center_right_right\">
				";
			}
		
			echo"
					<p class=\"recipe_open_category_img_p\">
					<a href=\"$root/recipes/categories_browse.php?category_id=$get_category_id&amp;l=$l\"><img src=\"$root/$get_category_translation_image_path/$get_category_translation_image\" alt=\"$get_category_translation_image\" /></a><br />
					</p>
					<p class=\"recipe_open_category_p\">
					<a href=\"$root/recipes/categories_browse.php?category_id=$get_category_id&amp;l=$l\" class=\"recipe_open_category_a\">$get_category_translation_value</a>
					</p>
				</div>
			";

			// Increment
			$x++;
		
			// Reset
			if($x == 4){
				$x = 0;
			}
		}

	}

	if($x == 1){
		echo"
			<div class=\"left_center_center_right_center\">
			</div>
			<div class=\"left_center_center_right_center\">
			</div>
			<div class=\"left_center_center_right_right\">
			</div>
		";
	
	}
	elseif($x == 2){
		echo"
			<div class=\"left_center_center_right_center\">
			</div>
			<div class=\"left_center_center_right_right\">
			</div>
		";

	}
	elseif($x == 3){
		echo"
			<div class=\"left_center_center_right_right\">
			</div>
		";

	}

}

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>