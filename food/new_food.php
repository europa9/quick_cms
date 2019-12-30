<?php 
/**
*
* File: food/new_food.php
* Version 1.0.0
* Date 23:59 27.11.2017
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


/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['mode'])){
	$mode = $_GET['mode'];
	$mode = output_html($mode);
}
else{
	$mode = "";
}
if(isset($_GET['food_id'])){
	$food_id = $_GET['food_id'];
	$food_id = output_html($food_id);
}
else{
	$food_id = "";
}
$tabindex = 0;
$l_mysql = quote_smart($link, $l);

/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_food - $l_new_food";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */

// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	

	
	echo"
	<h1>$l_new_food</h1>
	

	<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_recipe_title\"]').focus();
			});
			</script>
	<!-- //Focus -->

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

	<!-- Form -->

			<form method=\"get\" action=\"new_food_2_select_sub_category.php\" enctype=\"multipart/form-data\">
			



			<h2>$l_categorization</h2>
			<table>
			 <tr>
			  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
				<p><b>$l_language:</b></p>
			  </td>
			  <td>
				<script>
				\$(function(){
					\$('#inp_l').on('change', function () {
						var url = \$(this).val(); // get selected value
						if (url) { // require a URL
 							window.location = url; // redirect
						}
						return false;
					});
				});
				</script>
				<p>
				<select name=\"l\">
				<option value=\"$l\">- $l_please_select -</option>
				<option value=\"$l\"></option>\n";


				$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;

					$flag_path 	= "_design/gfx/flags/16x16/$get_language_active_flag" . "_16x16.png";
	
					// No language selected?
					if($l == ""){
							$l = "$get_language_active_iso_two";
					}
				
				
					echo"	<option value=\"$get_language_active_iso_two\" style=\"background: url('$flag_path') no-repeat;padding-left: 20px;\"";if($l == "$get_language_active_iso_two"){ echo" selected=\"selected\"";}echo">$get_language_active_name</option>\n";
				}
				echo"
				</select>
				</p>
			  </td>
			 </tr>
			 <tr>
			  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
				<p><b>Category:</b></p>
			  </td>
			  <td>
				<p>
				<select name=\"main_category_id\">
				<option value=\"new_food.php?l=$l\">- $l_please_select -</option>
				<option value=\"new_food.php?l=$l\"> </option>
				";

			// Get all categories
			$l_mysql = quote_smart($link, $l);
			$query = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='0' ORDER BY category_name ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_main_category_id, $get_main_category_name, $get_main_category_parent_id) = $row;
				
				// Translation
				$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_main_category_id AND category_translation_language=$l_mysql";
				$result_t = mysqli_query($link, $query_t);
				$row_t = mysqli_fetch_row($result_t);
				list($get_category_translation_value) = $row_t;

				echo"
				<option value=\"$get_main_category_id\">$get_category_translation_value</option>\n";
				
			}
			echo"
				</select>
				</p>
			  </td>
			 </tr>


			 <tr>
			  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
				
			  </td>
			  <td>
				<p>
				<input type=\"submit\" value=\"$l_next\" class=\"btn_default\" />
				</p>
			  </td>
			 </tr>
			</table>

	<!-- //Form -->
	";
}
else{
	echo"
	<h1>
	<img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/food/new_food.php\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>