<?php
/**
*
* File: food/index.php
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
$website_title = "$l_food";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");


echo"
<!-- Search -->
	<div style=\"float: right;padding-top: 12px;\">
		<form method=\"get\" action=\"search.php\" enctype=\"multipart/form-data\">
		<p>
		<input type=\"text\" name=\"q\" value=\"\" size=\"10\" id=\"nettport_inp_search_query\" />
		<input type=\"hidden\" name=\"l\" value=\"$l\" />
		<input type=\"submit\" value=\"$l_search\" id=\"nettport_search_submit_button\" class=\"btn_default\" />
		</p>
		</form>
	</div>
<!-- //Search -->

<!-- Headline and language -->
	<h1>$l_food</h1>
<!-- //Headline and language -->





<!-- Food Quick menu -->
	<div class=\"clear\"></div>
	<p>
	<a href=\"$root/food/my_food.php?l=$l\" class=\"btn_default\">$l_my_food</a>
	<a href=\"$root/food/my_favorites.php?l=$l\" class=\"btn_default\">$l_my_favorites</a>
	<a href=\"$root/food/new_food.php?l=$l\" class=\"btn_default\">$l_new_food</a>
	</p>
<!-- //Food Quick menu -->


<!-- All categories -->
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
<!-- //All categories -->

<!-- Search script -->
	<script id=\"source\" language=\"javascript\" type=\"text/javascript\">
	\$(document).ready(function () {
		\$('#nettport_inp_search_query').keyup(function () {
       			// getting the value that user typed
       			var searchString    = $(\"#nettport_inp_search_query\").val();
 			// forming the queryString
      			var data            = 'order_by=$order_by&order_method=$order_method&l=$l&q='+ searchString;
         
        		// if searchString is not empty
        		if(searchString) {
           			// ajax call
            			\$.ajax({
                			type: \"POST\",
               				url: \"search_jquery.php\",
                			data: data,
					beforeSend: function(html) { // this happens before actual call
						\$(\"#nettport_search_results\").html(''); 
					},
               				success: function(html){
                    				\$(\"#nettport_search_results\").append(html);
              				}
            			});
       			}
        		return false;
            	});
            });
	</script>
<!-- //Search script -->

<!-- New products -->
	
	<h2 style=\"margin-top: 20px;\">$l_new_products</h2>


	<div class=\"clear\"></div>
	<div id=\"nettport_search_results\">
	";
	
	// Set layout
	$x = 0;

	// Get all food
	$query = "SELECT food_id, food_user_id, food_name, food_manufacturer_name, food_description, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_fat, food_energy_calculated, food_proteins_calculated, food_carbohydrates_calculated, food_fat_calculated, food_barcode, food_category_id, food_image_path, food_thumb_small, food_thumb_medium, food_thumb_large, food_image_a, food_unique_hits, food_likes, food_dislikes FROM $t_food_index WHERE food_language=$l_mysql";
	$query = $query . " ORDER BY food_id DESC LIMIT 0,12";

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
				<a href=\"view_food.php?food_id=$get_food_id&amp;l=$l\"><img src=\"$root/$get_food_image_path/$get_food_thumb_small\" alt=\"$get_food_image_a\" style=\"margin-bottom: 5px;\" /></a><br />
					
				<a href=\"view_food.php?food_id=$get_food_id&amp;l=$l\" style=\"font-weight: bold;color: #444444;\">$title</a><br />
				";
				echo"
				</p>";
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
	</div>

<!-- //New products -->

<!-- Links -->";
	$week = date("w");
	$query = "SELECT count(integration_id) FROM $t_food_integration WHERE integration_last_checked_week != '$week'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_count_integration_id) = $row;
	if($get_count_integration_id > 0){
		echo"
		<div class=\"clear\"></div>
		<p>
		<a href=\"integrations.php?l=$l\" class=\"btn_default\">$l_integrations</a>
		</p>
		";
	}
	echo"
<!-- //Links -->
";


/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>