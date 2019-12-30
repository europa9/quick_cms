<?php
/**
*
* File: food/view_tag.php
* Version 1.0.0
* Date 23:07 09.07.2017
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
	$tag = strip_tags(stripslashes($tag));
}
else{
	$tag = "";
}
$tag_mysql = quote_smart($link, $tag);


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



/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_food - #$tag";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");



echo"
<!-- Search -->
	<div style=\"float: right;padding-top: 12px;\">
		<form method=\"post\" action=\"search.php\" enctype=\"multipart/form-data\">
		<p>
		<input type=\"text\" name=\"q\" value=\"\" size=\"10\" id=\"nettport_inp_search_query\" />
		<input type=\"submit\" value=\"$l_search\" id=\"nettport_search_submit_button\" class=\"btn_default\" />
		</p>
	</div>
<!-- //Search -->

<!-- Headline and language -->
	<h1>#$tag</h1>
<!-- //Headline and language -->



<!-- Food Quick menu -->
	<div class=\"clear\"></div>
	<p>
	<a href=\"$root/food/index.php?l=$l\" class=\"btn_default\">$l_home</a>
	<a href=\"$root/food/my_food.php?l=$l\" class=\"btn_default\">$l_my_food</a>
	<a href=\"$root/food/my_favorites.php?l=$l\" class=\"btn_default\">$l_my_favorites</a>
	<a href=\"$root/food/new_food.php?l=$l\" class=\"btn_default\">$l_new_food</a>
	</p>
<!-- //Food Quick menu -->


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
				<option value=\"view_tag.php?tag=$tag&amp;l=$l\">- $l_order_by -</option>
				<option value=\"view_tag.php?tag=$tag&amp;order_by=food_score&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_score"){ echo" selected=\"selected\""; } echo">$l_score</option>
				<option value=\"view_tag.php?tag=$tag&amp;order_by=food_id&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_id"){ echo" selected=\"selected\""; } echo">$l_date</option>
				<option value=\"view_tag.php?tag=$tag&amp;order_by=food_name&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_name"){ echo" selected=\"selected\""; } echo">$l_name</option>
				<option value=\"view_tag.php?tag=$tag&amp;order_by=food_manufacturer_name_and_food_name&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_manufacturer_name_and_food_name" OR $order_by == ""){ echo" selected=\"selected\""; } echo">$l_manufacturer_and_name</option>
				<option value=\"view_tag.php?tag=$tag&amp;order_by=food_unique_hits&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_unique_hits"){ echo" selected=\"selected\""; } echo">$l_unique_hits</option>
				<option value=\"view_tag.php?tag=$tag&amp;order_by=food_energy&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_energy"){ echo" selected=\"selected\""; } echo">$l_calories</option>
				<option value=\"view_tag.php?tag=$tag&amp;order_by=food_fat&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_fat"){ echo" selected=\"selected\""; } echo">$l_fat</option>
				<option value=\"view_tag.php?tag=$tag&amp;order_by=food_carbohydrates&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_carbohydrates"){ echo" selected=\"selected\""; } echo">$l_carbs</option>
				<option value=\"view_tag.php?tag=$tag&amp;order_by=food_proteins&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_proteins"){ echo" selected=\"selected\""; } echo">$l_proteins</option>
			</select>
			<select name=\"inp_order_method\" id=\"inp_order_method_select\">";
				if($order_by == ""){
					$order_by = "food_manufacturer_name_and_food_name";
				}
				echo"
				<option value=\"view_tag.php?tag=$tag&amp;order_by=$order_by&amp;order_method=asc&amp;l=$l\""; if($order_method == "asc" OR $order_method == ""){ echo" selected=\"selected\""; } echo">$l_asc</option>
				<option value=\"view_tag.php?tag=$tag&amp;order_by=$order_by&amp;order_method=desc&amp;l=$l\""; if($order_method == "desc"){ echo" selected=\"selected\""; } echo">$l_desc</option>
			</select>
			</p>
        		</form>
	</div>
<!-- //Sorting -->


";




// Get food with that tag
$x = 0;
$query = "SELECT $t_food_index_tags.tag_id, $t_food_index.food_id, $t_food_index.food_name, $t_food_index.food_manufacturer_name, $t_food_index.food_energy, $t_food_index.food_proteins, $t_food_index.food_carbohydrates, $t_food_index.food_fat, $t_food_index.food_image_path, $t_food_index.food_thumb, $t_food_index.food_image_a, $t_food_index.food_score, $t_food_index.food_category_id FROM $t_food_index_tags INNER JOIN $t_food_index ON $t_food_index_tags.tag_food_id=$t_food_index.food_id WHERE $t_food_index_tags.tag_title_clean=$tag_mysql AND $t_food_index_tags.tag_language=$l_mysql";


		// Order
		if($order_by != ""){
			if($order_method == "desc"){
				$order_method_mysql = "DESC";
			}
			else{
				$order_method_mysql = "ASC";
			}

			if($order_by == "food_score" OR $order_by == "food_id" OR $order_by == "food_manufacturer_name_and_food_name" OR $order_by == "food_name" OR $order_by == "food_unique_hits" 
			OR $order_by == "food_energy" OR $order_by == "food_proteins" OR $order_by == "food_carbohydrates" OR $order_by == "food_fat"){
				$order_by_mysql = "$t_food_index.$order_by";
			}
			else{
				$order_by_mysql = "$t_food_index.food_id";
			}
			$query = $query . " ORDER BY $order_by_mysql $order_method_mysql";
		}


$result = mysqli_query($link, $query);
while($row = mysqli_fetch_row($result)) {
	list($get_tag_id, $get_food_id, $get_food_name, $get_food_manufacturer_name, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_fat, $get_food_image_path, $get_food_thumb, $get_food_image_a, $get_food_score, $get_food_category_id) = $row;
		
	if(file_exists("$root/$get_food_image_path/$get_food_image_a")){
	
		// Name saying
		$title = "$get_food_manufacturer_name $get_food_name";
		$check = strlen($title);
		if($check > 35){
			$title = substr($title, 0, 35);
			$title = $title . "...";
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


		if($get_food_score > 0){
			echo"
			<img src=\"_gfx/smiley_sad.png\" alt=\"smiley_sad.gif\" title=\"$get_food_score\" class=\"food_score_img\" />";
		}
		elseif($get_food_score < 0){
			echo"
			<img src=\"_gfx/smiley_smile.png\" alt=\"smiley_smile.png\" title=\"$get_food_score\" class=\"food_score_img\" />";
		}
		else{
			echo"
			<img src=\"_gfx/smiley_confused.png\" alt=\"smiley_confused.png\" title=\"$get_food_score\" class=\"food_score_img\" />";
		}

		echo"
		<p style=\"padding-bottom:5px;\">
		";

	
		if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a")){
			if($get_food_thumb == ""){
				echo"<div class=\"info\"><span>Updated thumb name</span></div>
				<meta http-equiv=\"refresh\" content=\"1;url=view_tag.php?tag=$tag&amp;l=$l\" />.";
				$get_food_thumb = "TEMP";
			}
			if(!(file_exists("../$get_food_image_path/$get_food_thumb"))){

				$extension = getExtension($get_food_image_a);
				$extension = strtolower($extension);

				$new_food_thumb = substr($get_food_image_a, 0, -5);
				$new_food_thumb = $new_food_thumb . "thumb." . $extension;
				$new_food_thumb_mysql = quote_smart($link, $new_food_thumb);

				// Thumb
				$inp_new_x = 132;
				$inp_new_y = 132;
				resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_food_image_path/$get_food_image_a", "$root/$get_food_image_path/$new_food_thumb");

				$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb=$new_food_thumb_mysql WHERE food_id=$get_food_id") or die(mysqli_error($link));

				echo"<div class=\"info\"><span>Created thumb</span></div>";
			}
			echo"<a href=\"view_food.php?main_category_id=&amp;sub_category_id=$get_food_category_id&amp;food_id=$get_food_id&amp;l=$l\"><img src=\"../$get_food_image_path/$get_food_thumb\" alt=\"$get_food_thumb\" style=\"margin-bottom: 5px;\" /></a><br />";
		}
		else{
			echo"<a href=\"view_food.php?main_category_id=&amp;sub_category_id=$get_food_category_id&amp;food_id=$get_food_id&amp;l=$l\"><img src=\"_gfx/no_thumb.png\" alt=\"$get_food_image_a\" style=\"margin-bottom: 5px;\" /></a><br />";
		}


		echo"
		<a href=\"view_food.php?main_category_id=&amp;sub_category_id=$get_food_category_id&amp;food_id=$get_food_id&amp;l=$l\" style=\"font-weight: bold;color: #444444;\">$title</a><br />
		";
		echo"
		</p>

		<table style=\"margin: 0px auto;\">
		 <tr>
		  <td style=\"padding-right: 10px;text-align: center;\">
			<span class=\"grey_smal\">$get_food_energy</span>
		  </td>
		  <td style=\"padding-right: 10px;text-align: center;\">
			<span class=\"grey_smal\">$get_food_fat</span>
		  </td>
		  <td style=\"padding-right: 10px;text-align: center;\">
			<span class=\"grey_smal\">$get_food_carbohydrates</span>
		  </td>
		  <td style=\"text-align: center;\">
			<span class=\"grey_smal\">$get_food_proteins</span>
		  </td>
		 </tr>
		 <tr>
		  <td style=\"padding-right: 10px;text-align: center;\">
			<span class=\"grey_smal\">$l_cal_lowercase</span>
		  </td>
		  <td style=\"padding-right: 10px;text-align: center;\">
			<span class=\"grey_smal\">$l_fat_lowercase</span>
		  </td>
		  <td style=\"padding-right: 10px;text-align: center;\">
			<span class=\"grey_smal\">$l_carb_lowercase</span>
		  </td>
		  <td style=\"text-align: center;\">
			<span class=\"grey_smal\">$l_proteins_lowercase</span>
		  </td>
		 </tr>
		</table>
		</div>
		";
	
		// Increment
		$x++;

		// Reset
		if($x == 4){
			$x = 0;
		}
	} // img
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>