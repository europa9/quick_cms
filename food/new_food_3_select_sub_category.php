<?php 
/**
*
* File: food/new_food_3_select_sub_category.php
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

/*- Tables ---------------------------------------------------------------------------- */
$t_search_engine_index 		= $mysqlPrefixSav . "search_engine_index";
$t_search_engine_access_control = $mysqlPrefixSav . "search_engine_access_control";



/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/food/ts_food.php");
include("$root/_admin/_translations/site/$l/food/ts_new_food.php");


/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['barcode'])){
	$barcode = $_GET['barcode'];
	$barcode = output_html($barcode);
	if($barcode != "" && !(is_numeric($barcode))){
		echo"barcode_have_to_be_numeric";
		exit;
	}
}
else{
	$barcode = "";
}

if(isset($_GET['main_category_id'])){
	$main_category_id= $_GET['main_category_id'];
	$main_category_id = strip_tags(stripslashes($main_category_id));
}
else{
	$main_category_id = "";
}

$tabindex = 0;
$l_mysql = quote_smart($link, $l);

/*- Main category ------------------------------------------------------------------------- */
// Select category
$main_category_id_mysql = quote_smart($link, $main_category_id);
$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$main_category_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_main_category_id, $get_current_main_category_user_id, $get_current_main_category_name, $get_current_main_category_parent_id) = $row;
if($get_current_main_category_id == ""){
	$website_title = "$l_food - Server error 404";
}
else{
	// Translation
	$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_current_main_category_id AND category_translation_language=$l_mysql";
	$result_t = mysqli_query($link, $query_t);
	$row_t = mysqli_fetch_row($result_t);
	list($get_category_translation_value) = $row_t;
	$website_title = "$l_food - $l_new_food - $get_category_translation_value";
}


/*- Headers ---------------------------------------------------------------------------------- */
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */

// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	


	if($get_current_main_category_id == ""){
		echo"
		<h1>Server error 404</h1>
		<p>Category not found.</p>

		<p><a href=\"index.php?l=$l\">Categories</a></p>
		";
	}
	else{
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


			<!-- Scripts-->
			<script>
				\$(document).ready(function(){
					\$('[name=\"sub_category_id\"]').focus();
				});
				\$(function(){
					\$('.on_select_go_to_url').on('change', function () {
						var url = \$(this).val(); // get selected value
						if (url) { // require a URL
 							window.location = url; // redirect
						}
						return false;
					});
				});
			</script>
			<!-- //Scripts---->

			<h2>$l_categorization</h2>
			<table>
			 <tr>
			  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
				<p><b>$l_category:</b></p>
			  </td>
			  <td>

				<p>
				<select name=\"main_category_id\" class=\"on_select_go_to_url\">
				<option value=\"$l\">- $l_please_select -</option>
				<option value=\"$l\"> </option>
				";

			// Get all categories
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
				<option value=\"new_food_3_select_sub_category.php?main_category_id=$get_main_category_id&amp;barcode=$barcode&amp;l=$l\""; if($main_category_id == "$get_main_category_id"){ echo" selected=\"selected\""; } echo">$get_category_translation_value</option>\n";
				
			}
			echo"
				</select>
				</p>
			  </td>
			 </tr>
			 <tr>
			  <td style=\"text-align: right;padding: 0px 4px 0px 0px;\">
				<p><b>$l_sub_category:</b></p>
			  </td>
			  <td>
				<p>
				<select name=\"sub_category_id\" class=\"on_select_go_to_url\">
				<option value=\"$l\">- $l_please_select -</option>
				<option value=\"$l\"> </option>

				";

				// Get all categories
				$query = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id=$main_category_id_mysql ORDER BY category_name ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_sub_category_id, $get_sub_category_name, $get_sub_category_parent_id) = $row;
				
					// Translation
					$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_sub_category_id AND category_translation_language=$l_mysql";
					$result_t = mysqli_query($link, $query_t);
					$row_t = mysqli_fetch_row($result_t);
					list($get_category_translation_value) = $row_t;

					echo"
					<option value=\"new_food_4_general_information.php?main_category_id=$main_category_id&amp;sub_category_id=$get_sub_category_id&amp;barcode=$barcode&amp;&amp;l=$l\">$get_category_translation_value</option>\n";
					
				}
				echo"
				</select>
				</p>

			  </td>
			 </tr>
			</table>
		<!-- //Form -->
		";
	} // mode == ""
}
else{
	echo"
	<h1>
	<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/index.php?page=login&amp;l=$l&amp;refer=$root/food/new_food.php\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>