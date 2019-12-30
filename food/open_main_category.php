<?php
/**
*
* File: _food/open_main_category.php
* Version 1.0.0.
* Date 12:42 21.01.2018
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

/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/food/ts_food.php");

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

if(isset($_GET['main_category_id'])){
	$main_category_id= $_GET['main_category_id'];
	$main_category_id = strip_tags(stripslashes($main_category_id));
}
else{
	$main_category_id = "";
}
if(isset($_GET['sub_category_id'])){
	$sub_category_id= $_GET['sub_category_id'];
	$sub_category_id = strip_tags(stripslashes($sub_category_id));
}
else{
	$sub_category_id = "";
}


if(isset($_GET['order_by'])) {
	$order_by = $_GET['order_by'];
	$order_by = strip_tags(stripslashes($order_by));
}
else{
	$order_by = "";
}
if(isset($_GET['order_method'])) {
	$order_method = $_GET['order_method'];
	$order_method = strip_tags(stripslashes($order_method));
}
else{
	$order_method = "";
}

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
	$website_title = "$l_food - $get_category_translation_value";
}

/*- Headers ---------------------------------------------------------------------------------- */
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");



if($get_current_main_category_id == ""){
	echo"
	<h1>Server error 404</h1>
	<p>Category not found.</p>

	<p><a href=\"index.php?l=$l\">Categories</a></p>
	";
}
else{

	echo"
	<!-- Headline -->
		<h1>$get_category_translation_value</h1>
	<!-- //Headline -->

	<!-- Where am I ? -->
		<p><b>$l_you_are_here:</b><br />
		<a href=\"index.php?l=$l\">$l_food</a>
		&gt;
		<a href=\"open_main_category.php?main_category_id=$main_category_id&amp;l=$l\">$get_category_translation_value</a>
		</p>
	<!-- //Where am I ? -->


	<!-- All main categories -->
		<div class=\"clear\"></div>
		<div class=\"food_all_main_categories_selector\">
			<a href=\"#\" id=\"show_all_main_categories_link_img\"><img src=\"_gfx/show_all_categories_img.png\" alt=\"show_all_categories_img.png\" class=\"show_all_main_categories_img\" /></a>
			<a href=\"#\" id=\"show_all_main_categories_link_text\">$l_categories</a>
		</div>

		<script>
		\$(document).ready(function(){
			\$(\"#show_all_main_categories_link_img\").click(function () {
				\$(\"#food_show_all_main_categories\").toggle();
			});
			\$(\"#show_all_main_categories_link_text\").click(function () {
				\$(\"#food_show_all_main_categories\").toggle();
			});
		});
		</script>

		<div id=\"food_show_all_main_categories\">
			<ul>
			";
			// Get all categories
			$query = "SELECT $t_food_categories.category_id, $t_food_categories.category_name, $t_food_categories.category_parent_id FROM $t_food_categories";
			$query = $query . " WHERE category_user_id='0' AND category_parent_id='0' ORDER BY category_name ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_category_id, $get_category_name, $get_category_parent_id) = $row;

				// Translation
				$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_category_id AND category_translation_language=$l_mysql";
				$result_t = mysqli_query($link, $query_t);
				$row_t = mysqli_fetch_row($result_t);
				list($get_category_translation_value) = $row_t;

				echo"			";
				echo"<li><a href=\"$root/food/open_main_category.php?main_category_id=$get_category_id&amp;l=$l\">$get_category_translation_value</a></li>\n";
			}
			echo"
			</ul>
		</div>
	<!-- //All main categories -->

	<!-- Sub categories -->
		<div id=\"food_show_sub_categories\">
			<ul>";
			$queryb = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='$get_current_main_category_id' ORDER BY category_name ASC";
			$resultb = mysqli_query($link, $queryb);
			while($rowb = mysqli_fetch_row($resultb)) {
				list($get_sub_category_id, $get_sub_category_name, $get_sub_category_parent_id) = $rowb;

				// Translation
				$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_sub_category_id AND category_translation_language=$l_mysql";
				$result_t = mysqli_query($link, $query_t);
				$row_t = mysqli_fetch_row($result_t);
				list($get_category_translation_value) = $row_t;

				echo"
				<li><a href=\"open_sub_category.php?main_category_id=$main_category_id&amp;sub_category_id=$get_sub_category_id&amp;l=$l\">$get_category_translation_value</a></li>
				";
			}
			echo"
			</ul>
		</div>
	<!-- //Sub categories -->



	<!-- Sorting -->
		<div style=\"margin-top: 20px;\">
			<script>
			\$(function(){
				\$('#inp_order_by_select').on('change', function () {
					var url = \$(this).val();
					if (url) { // require a URL
 						window.location = url;
					}
					return false;
				});
				\$('#inp_order_method_select').on('change', function () {
					var url = \$(this).val();
					if (url) { // require a URL
 						window.location = url;
					}
					return false;
				});
			});
			</script>
		
        		<form method=\"get\" action=\"search.php\" enctype=\"multipart/form-data\">
			<p>
			<select name=\"inp_order_by\" id=\"inp_order_by_select\">
				<option value=\"index.php?l=$l\">- $l_order_by -</option>
				<option value=\"open_main_category.php?main_category_id=$main_category_id&amp;order_by=food_id&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_id"){ echo" selected=\"selected\""; } echo">$l_date</option>
				<option value=\"open_main_category.php?main_category_id=$main_category_id&amp;order_by=food_name&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_name"){ echo" selected=\"selected\""; } echo">$l_name</option>
				<option value=\"open_main_category.php?main_category_id=$main_category_id&amp;order_by=food_manufacturer_name_and_food_name&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_manufacturer_name_and_food_name" OR $order_by == ""){ echo" selected=\"selected\""; } echo">$l_manufacturer_and_name</option>
				<option value=\"open_main_category.php?main_category_id=$main_category_id&amp;order_by=food_unique_hits&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_unique_hits"){ echo" selected=\"selected\""; } echo">$l_unique_hits</option>
				<option value=\"open_main_category.php?main_category_id=$main_category_id&amp;order_by=food_energy&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_energy"){ echo" selected=\"selected\""; } echo">$l_calories</option>
				<option value=\"open_main_category.php?main_category_id=$main_category_id&amp;order_by=food_fat&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_fat"){ echo" selected=\"selected\""; } echo">$l_fat</option>
				<option value=\"open_main_category.php?main_category_id=$main_category_id&amp;order_by=food_carbohydrates&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_carbohydrates"){ echo" selected=\"selected\""; } echo">$l_carbs</option>
				<option value=\"open_main_category.php?main_category_id=$main_category_id&amp;order_by=food_proteins&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_proteins"){ echo" selected=\"selected\""; } echo">$l_proteins</option>
			</select>
			<select name=\"inp_order_method\" id=\"inp_order_method_select\">";
				if($order_by == ""){
					$order_by = "food_manufacturer_name_and_food_name";
				}
				echo"
				<option value=\"open_main_category.php?main_category_id=$main_category_id&amp;order_by=$order_by&amp;order_method=asc&amp;l=$l\""; if($order_method == "asc" OR $order_method == ""){ echo" selected=\"selected\""; } echo">$l_asc</option>
				<option value=\"open_main_category.php?main_category_id=$main_category_id&amp;order_by=$order_by&amp;order_method=desc&amp;l=$l\""; if($order_method == "desc"){ echo" selected=\"selected\""; } echo">$l_desc</option>
			</select>
			</p>
        		</form>
		</div>
		<div class=\"clear\"></div>
	<!-- //Sorting -->


	<!-- Sub categories -->


	";

	// Get sub categories
	$queryb = "SELECT category_id, category_name, category_parent_id FROM $t_food_categories WHERE category_user_id='0' AND category_parent_id='$get_current_main_category_id' ORDER BY category_name ASC";
	$resultb = mysqli_query($link, $queryb);
	while($rowb = mysqli_fetch_row($resultb)) {
		list($get_sub_category_id, $get_sub_category_name, $get_sub_category_parent_id) = $rowb;

		// Translation
		$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_sub_category_id AND category_translation_language=$l_mysql";
		$result_t = mysqli_query($link, $query_t);
		$row_t = mysqli_fetch_row($result_t);
		list($get_category_translation_value) = $row_t;

		echo"
		<div class=\"food_sub_categories_with_food\">
			<div class=\"food_sub_categories_with_food_right\">
				<a href=\"open_sub_category.php?main_category_id=$main_category_id&amp;sub_category_id=$get_sub_category_id&amp;l=$l\"><img src=\"_gfx/food_sub_categories_with_food_right.png\" alt=\"food_sub_categories_with_food_right.png\" /></a>
			</div>

			<a href=\"open_sub_category.php?main_category_id=$main_category_id&amp;sub_category_id=$get_sub_category_id&amp;l=$l\">$get_category_translation_value</a>
		</div>
		";

		// Get food
		$x = 0;
		$query = "SELECT food_id, food_user_id, food_name, food_manufacturer_name, food_description, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_fat, food_energy_calculated, food_proteins_calculated, food_carbohydrates_calculated, food_fat_calculated, food_barcode, food_category_id, food_image_path, food_thumb_small, food_thumb_medium, food_thumb_large, food_image_a, food_unique_hits, food_likes, food_dislikes FROM $t_food_index WHERE food_category_id=$get_sub_category_id AND food_language=$l_mysql";

		// Order
		if($order_by != ""){
			if($order_method == "desc"){
				$order_method_mysql = "DESC";
			}
			else{
				$order_method_mysql = "ASC";
			}

			if($order_by == "food_id" OR $order_by == "food_name" OR $order_by == "food_manufacturer_name_and_food_name" OR $order_by == "food_unique_hits" 
			OR $order_by == "food_energy" OR $order_by == "food_proteins" OR $order_by == "food_carbohydrates" OR $order_by == "food_fat"){
				$order_by_mysql = "$order_by";
			}
			else{
				$order_by_mysql = "food_id";
			}
			$query = $query . " ORDER BY $order_by_mysql $order_method_mysql";
		

		}
		$query = $query . " LIMIT 0,4";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_food_id, $get_food_user_id, $get_food_name, $get_food_manufacturer_name, $get_food_description, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_fat, $get_food_energy_calculated, $get_food_proteins_calculated, $get_food_carbohydrates_calculated, $get_food_fat_calculated, $get_food_barcode, $get_food_category_id,  $get_food_image_path, $get_food_thumb_small, $get_food_thumb_medium, $get_food_thumb_large, $get_food_image_a, $get_food_unique_hits, $get_food_likes, $get_food_dislikes) = $row;
				
			if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a")){
				// Name saying
				$title = "$get_food_manufacturer_name $get_food_name";
				$check = strlen($title);
				if($check > 35){
					$title = substr($title, 0, 35);
					$title = $title . "...";
				}
				// Thumb small
				if(!(file_exists("../$get_food_image_path/$get_food_thumb_small")) OR $get_food_thumb_small == ""){
					// Thumb name
					$extension = get_extension($get_food_image_a);
					$extension = strtolower($extension);
					$inp_new_x = 132;
					$inp_new_y = 132;
				
					$thumb_name = $get_food_id . "_thumb_" . $inp_new_x . "x" . $inp_new_y . "." . $extension;
					$thumb_name_mysql = quote_smart($link, $thumb_name);
					resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_food_image_path/$get_food_image_a", "$root/$get_food_image_path/$thumb_name");

					$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb_small=$thumb_name_mysql WHERE food_id=$get_food_id") or die(mysqli_error($link));
				
				}

				// Thumb medium
				if(!(file_exists("../$get_food_image_path/$get_food_thumb_medium")) OR $get_food_thumb_medium == ""){
					// Thumb name
					$extension = get_extension($get_food_image_a);
					$extension = strtolower($extension);
					$inp_new_x = 150;
					$inp_new_y = 150;
				
					$thumb_name = $get_food_id . "_thumb_" . $inp_new_x . "x" . $inp_new_y . "." . $extension;
					$thumb_name_mysql = quote_smart($link, $thumb_name);
					resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_food_image_path/$get_food_image_a", "$root/$get_food_image_path/$thumb_name");

					$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb_medium=$thumb_name_mysql WHERE food_id=$get_food_id") or die(mysqli_error($link));
				}

				// Thumb large
				if(!(file_exists("../$get_food_image_path/$get_food_thumb_large")) OR $get_food_thumb_large == ""){
					// Thumb name
					$extension = get_extension($get_food_image_a);
					$extension = strtolower($extension);
					$inp_new_x = 420;
					$inp_new_y = 283;
				
					$thumb_name = $get_food_id . "_thumb_" . $inp_new_x . "x" . $inp_new_y . "." . $extension;
					$thumb_name_mysql = quote_smart($link, $thumb_name);
					resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_food_image_path/$get_food_image_a", "$root/$get_food_image_path/$thumb_name");

					$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb_large=$thumb_name_mysql WHERE food_id=$get_food_id") or die(mysqli_error($link));
				}

				if($x == 0){
					echo"
					<div class=\"clear\"></div>
					<div class=\"left_center_center_right_left\" style=\"text-align: center;padding-bottom: 20px;\">
					";
				}
				elseif($x == 1){
					echo"
					<div class=\"left_center_center_left_right_center\" style=\"text-align: center;padding-bottom: 20px;\">
					";
				}
				elseif($x == 2){
					echo"
					<div class=\"left_center_center_right_right_center\" style=\"text-align: center;padding-bottom: 20px;\">
					";
				}
				elseif($x == 3){
					echo"
					<div class=\"left_center_center_right_right\" style=\"text-align: center;padding-bottom: 20px;\">
					";
				}
	

				echo"
				<p style=\"padding-bottom:5px;\">
				<a href=\"view_food.php?main_category_id=$main_category_id&amp;sub_category_id=$get_sub_category_id&amp;food_id=$get_food_id&amp;l=$l\"><img src=\"$root/$get_food_image_path/$get_food_thumb_small\" alt=\"$get_food_image_a\" style=\"margin-bottom: 5px;\" /></a><br />
				<a href=\"view_food.php?main_category_id=$main_category_id&amp;sub_category_id=$get_sub_category_id&amp;food_id=$get_food_id&amp;l=$l\" style=\"font-weight: bold;color: #444444;\">$title</a><br />
				</p>
				";
				if($get_food_energy != "0"){
					echo"
					<table style=\"margin: 0px auto;\">
					 <tr>
					  <td style=\"padding-right: 10px;text-align: center;\">
						<span class=\"grey_small\">$get_food_energy</span>
					  </td>
					  <td style=\"padding-right: 10px;text-align: center;\">
						<span class=\"grey_small\">$get_food_fat</span>
					  </td>
					  <td style=\"padding-right: 10px;text-align: center;\">
						<span class=\"grey_small\">$get_food_carbohydrates</span>
					  </td>
					  <td style=\"text-align: center;\">
						<span class=\"grey_small\">$get_food_proteins</span>
					  </td>
					 </tr>
					 <tr>
					  <td style=\"padding-right: 10px;text-align: center;\">
						<span class=\"grey_small\">$l_cal_lowercase</span>
					  </td>
					  <td style=\"padding-right: 10px;text-align: center;\">
						<span class=\"grey_small\">$l_fat_lowercase</span>
					  </td>
					  <td style=\"padding-right: 10px;text-align: center;\">
						<span class=\"grey_small\">$l_carb_lowercase</span>
					  </td>
					  <td style=\"text-align: center;\">
						<span class=\"grey_small\">$l_proteins_lowercase</span>
					  </td>
					 </tr>
					</table>
					";
				}
				echo"
	
				</div>
				";

				// Increment
				$x++;
		
				// Reset
				if($x == 4){
					$x = 0;
				}
			} // has image
		} // while

		echo"
		<div class=\"clear\"></div>
		";
	} // while
	echo"
	<!-- //Subcategories -->
	";

}


/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>