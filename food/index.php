<?php
/**
*
* File: food/index.php
* Version 2.0
* Date 15:41 18.10.2020
* Copyright (c) 2008-2020 Sindre Andre Ditlefsen
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
include("_tables_food.php");



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


<!-- Headline, buttons, search -->
	<div class=\"food_float_left\">
		<h1>$l_food</h1>
	</div>
	<div class=\"food_float_right\">
		
		<!-- Food menu -->
			<script>
			\$(document).ready(function() {
				\$('#toggle_food_search').click(function() {
					\$(\".food_search\").fadeIn();
					\$(\"#nettport_inp_search_query\").focus();
				})
			});
			</script>


			<p>
			<a href=\"#\" id=\"toggle_food_search\" class=\"btn_default\"><img src=\"_gfx/icons/outline_search_black_18dp.png\" alt=\"outline_search_black_18dp.png\" /> $l_search</a>
			<a href=\"$root/food/my_food.php?l=$l\" class=\"btn_default\">$l_my_food</a>
			<a href=\"$root/food/my_favorites.php?l=$l\" class=\"btn_default\">$l_my_favorites</a>
			<a href=\"$root/food/new_food.php?l=$l\" class=\"btn_default\">$l_new_food</a>
			</p>
		<!-- //Food menu -->
	</div>
	<div class=\"clear\"></div>
<!-- //Headline, buttons, search -->


<!-- Food Search -->
	<div class=\"food_search\">
		<form method=\"get\" action=\"search.php\" enctype=\"multipart/form-data\">
		<p>
		<input type=\"text\" name=\"search_query\" id=\"nettport_inp_search_query\" value=\"\" size=\"10\" style=\"width: 50%;\"  />
		<input type=\"hidden\" name=\"l\" value=\"$l\" />
		<input type=\"submit\" value=\"$l_search\" id=\"nettport_search_submit_button\" class=\"btn_default\" />
		</p>
		</form>
	</div>

	<!-- Search script -->
	<script id=\"source\" language=\"javascript\" type=\"text/javascript\">
	\$(document).ready(function () {
		\$('#nettport_inp_search_query').keyup(function () {
       			// getting the value that user typed
       			var searchString    = $(\"#nettport_inp_search_query\").val();
 			// forming the queryString
      			var data            = 'order_by=$order_by&order_method=$order_method&l=$l&search_query='+ searchString;
         
        		// if searchString is not empty
        		if(searchString) {


           			// ajax call
            			\$.ajax({
                			type: \"GET\",
               				url: \"search_jquery.php\",
                			data: data,
					beforeSend: function(html) { // this happens before actual call
						\$(\"#nettport_search_results\").html(''); 
					},
               				success: function(html){
						\$(\"#nettport_search_results\").html(''); 
                    				\$(\"#nettport_search_results\").html(html);
              				}
            			});
       			}
        		return false;
            	});
            });
	</script>
	<!-- //Search script -->
<!-- //Food Search -->

<!-- User adaptet view and Language selector -->
	<div class=\"food_float_left\">";
	if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
		$my_user_id = $_SESSION['user_id'];
		$my_user_id = output_html($my_user_id);
		$my_user_id_mysql = quote_smart($link, $my_user_id);
	
		$query_t = "SELECT view_id, view_user_id, view_ip, view_year, view_system, view_hundred_metric, view_pcs_metric, view_eight_us, view_pcs_us FROM $t_food_user_adapted_view WHERE view_user_id=$my_user_id_mysql";
		$result_t = mysqli_query($link, $query_t);
		$row_t = mysqli_fetch_row($result_t);
		list($get_current_view_id, $get_current_view_user_id, $get_current_view_ip, $get_current_view_year, $get_current_view_system, $get_current_view_hundred_metric, $get_current_view_pcs_metric, $get_current_view_eight_us, $get_current_view_pcs_us) = $row_t;
	}
	else{
		// IP
		$my_user_ip = $_SERVER['REMOTE_ADDR'];
		$my_user_ip = output_html($my_user_ip);
		$my_user_ip_mysql = quote_smart($link, $my_user_ip);
	
		$query_t = "SELECT view_id, view_user_id, view_ip, view_year, view_system, view_hundred_metric, view_pcs_metric, view_eight_us, view_pcs_us FROM $t_food_user_adapted_view WHERE view_ip=$my_user_ip_mysql";
		$result_t = mysqli_query($link, $query_t);
		$row_t = mysqli_fetch_row($result_t);
		list($get_current_view_id, $get_current_view_user_id, $get_current_view_ip, $get_current_view_year, $get_current_view_system, $get_current_view_hundred_metric, $get_current_view_pcs_metric, $get_current_view_eight_us, $get_current_view_pcs_us) = $row_t;

	}
	if($get_current_view_id == ""){
		$get_current_view_system = "metric";
		$get_current_view_hundred_metric = 1;
		$get_current_view_pcs_metric = 1;
	}
	echo"
	<p>
	<b>$l_show_per:</b>
	<input type=\"checkbox\" name=\"inp_show_hundred_metric\" class=\"onclick_go_to_url\""; if($get_current_view_hundred_metric == "1"){ echo" checked=\"checked\" data-target=\"user_adapted_view.php?set=hundred_metric&amp;value=0&amp;process=1&amp;referer=index&amp;l=$l\""; } else{ echo" data-target=\"user_adapted_view.php?set=hundred_metric&amp;value=1&amp;process=1&amp;referer=index&amp;l=$l\""; } echo" /> $l_hundred
	<input type=\"checkbox\" name=\"inp_show_pcs_metric\" class=\"onclick_go_to_url\""; if($get_current_view_pcs_metric == "1"){ echo" checked=\"checked\" data-target=\"user_adapted_view.php?set=pcs_metric&amp;value=0&amp;process=1&amp;referer=index&amp;l=$l\""; } else{ echo" data-target=\"user_adapted_view.php?set=pcs_metric&amp;value=1&amp;process=1&amp;referer=index&amp;l=$l\""; } echo" /> $l_pcs_g
	<input type=\"checkbox\" name=\"inp_show_metric_us_and_or_pcs\" class=\"onclick_go_to_url\""; if($get_current_view_eight_us == "1"){ echo" checked=\"checked\" data-target=\"user_adapted_view.php?set=eight_us&amp;value=0&amp;process=1&amp;referer=index&amp;l=$l\""; } else{ echo" data-target=\"user_adapted_view.php?set=eight_us&amp;value=1&amp;process=1&amp;referer=index&amp;l=$l\""; } echo" /> $l_eight
	<input type=\"checkbox\" name=\"inp_show_metric_us_and_or_pcs\" class=\"onclick_go_to_url\""; if($get_current_view_pcs_us == "1"){ echo" checked=\"checked\" data-target=\"user_adapted_view.php?set=pcs_us&amp;value=0&amp;process=1&amp;referer=index&amp;l=$l\""; } else{ echo" data-target=\"user_adapted_view.php?set=pcs_us&amp;value=1&amp;process=1&amp;referer=index&amp;l=$l\""; } echo" /> $l_pcs_oz
	

	<!-- On check go to URL -->
		<script>
		\$(function() {
			\$(\".onclick_go_to_url\").change(function(){
				var item=\$(this);
				window.location.href= item.data(\"target\")
			});
   		});
		</script>
	<!-- //On check go to URL -->
	</div>
<!-- //User adaptet view and Language selector -->


<!-- Language selector -->
	<div class=\"food_float_right\">

	<b>$l_language:</b>\n";
	$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag_path_16x16, language_active_flag_16x16, language_active_default FROM $t_languages_active";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag_path_16x16, $get_language_active_flag_16x16, $get_language_active_default) = $row;
		echo"
		<a href=\"index.php?l=$get_language_active_iso_two\"><img src=\"$root/$get_language_active_flag_path_16x16/$get_language_active_flag_16x16\" alt=\"$get_language_active_flag_16x16\" /></a>
		";
	}
	echo"</p>
	</div>
	<div class=\"clear\"></div>
<!-- //Language selector -->

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


<!-- Tags -->
	<div class=\"clear\"></div>
	<p style=\"padding: 20px 0px 0px 0px;margin: 0px 0px 0px 0px;\">
	";
	$query_t = "SELECT tag_id, tag_language, tag_title, tag_title_clean FROM $t_food_tags_unique WHERE tag_language=$l_mysql ORDER BY tag_unique_views_counter ASC";
	$result_t = mysqli_query($link, $query_t);
	while($row_t = mysqli_fetch_row($result_t)) {
		list($get_tag_id, $get_tag_language, $get_tag_title, $get_tag_title_clean) = $row_t;
		echo"
		<a href=\"view_tag.php?tag=$get_tag_title_clean&amp;l=$l\" class=\"btn_default\">$get_tag_title</a>
		";
	}
	echo"
	</p>
<!-- //Tags -->


<!-- New products -->
	
	<h2 style=\"margin-top: 10px;\">$l_new_products</h2>


	<div class=\"clear\"></div>
	<div id=\"nettport_search_results\">
	";
	
	// Set layout
	$nutritional_content_layout = "1";

	$x = 0;

	// Get all food
	$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_country, food_net_content_metric, food_net_content_measurement_metric, food_net_content_us, food_net_content_measurement_us, food_net_content_added_measurement, food_serving_size_metric, food_serving_size_measurement_metric, food_serving_size_us, food_serving_size_measurement_us, food_serving_size_added_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy_metric, food_fat_metric, food_saturated_fat_metric, food_monounsaturated_fat_metric, food_polyunsaturated_fat_metric, food_cholesterol_metric, food_carbohydrates_metric, food_carbohydrates_of_which_sugars_metric, food_dietary_fiber_metric, food_proteins_metric, food_salt_metric, food_sodium_metric, food_energy_us, food_fat_us, food_saturated_fat_us, food_monounsaturated_fat_us, food_polyunsaturated_fat_us, food_cholesterol_us, food_carbohydrates_us, food_carbohydrates_of_which_sugars_us, food_dietary_fiber_us, food_proteins_us, food_salt_us, food_sodium_us, food_score, food_energy_calculated_metric, food_fat_calculated_metric, food_saturated_fat_calculated_metric, food_monounsaturated_fat_calculated_metric, food_polyunsaturated_fat_calculated_metric, food_cholesterol_calculated_metric, food_carbohydrates_calculated_metric, food_carbohydrates_of_which_sugars_calculated_metric, food_dietary_fiber_calculated_metric, food_proteins_calculated_metric, food_salt_calculated_metric, food_sodium_calculated_metric, food_energy_calculated_us, food_fat_calculated_us, food_saturated_fat_calculated_us, food_monounsaturated_fat_calculated_us, food_polyunsaturated_fat_calculated_us, food_cholesterol_calculated_us, food_carbohydrates_calculated_us, food_carbohydrates_of_which_sugars_calculated_us, food_dietary_fiber_calculated_us, food_proteins_calculated_us, food_salt_calculated_us, food_sodium_calculated_us, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_thumb_a_medium, food_thumb_a_large, food_image_b, food_thumb_b_small, food_thumb_b_medium, food_thumb_b_large, food_image_c, food_thumb_c_small, food_thumb_c_medium, food_thumb_c_large, food_image_d, food_thumb_d_small, food_thumb_d_medium, food_thumb_d_large, food_image_e, food_thumb_e_small, food_thumb_e_medium, food_thumb_e_large, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_created_date, food_last_viewed, food_age_restriction FROM $t_food_index WHERE food_language=$l_mysql";
	$query = $query . " ORDER BY food_id DESC LIMIT 0,12";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_manufacturer_name_and_food_name, $get_food_description, $get_food_country, $get_food_net_content_metric, $get_food_net_content_measurement_metric, $get_food_net_content_us, $get_food_net_content_measurement_us, $get_food_net_content_added_measurement, $get_food_serving_size_metric, $get_food_serving_size_measurement_metric, $get_food_serving_size_us, $get_food_serving_size_measurement_us, $get_food_serving_size_added_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy_metric, $get_food_fat_metric, $get_food_saturated_fat_metric, $get_food_monounsaturated_fat_metric, $get_food_polyunsaturated_fat_metric, $get_food_cholesterol_metric, $get_food_carbohydrates_metric, $get_food_carbohydrates_of_which_sugars_metric, $get_food_dietary_fiber_metric, $get_food_proteins_metric, $get_food_salt_metric, $get_food_sodium_metric, $get_food_energy_us, $get_food_fat_us, $get_food_saturated_fat_us, $get_food_monounsaturated_fat_us, $get_food_polyunsaturated_fat_us, $get_food_cholesterol_us, $get_food_carbohydrates_us, $get_food_carbohydrates_of_which_sugars_us, $get_food_dietary_fiber_us, $get_food_proteins_us, $get_food_salt_us, $get_food_sodium_us, $get_food_score, $get_food_energy_calculated_metric, $get_food_fat_calculated_metric, $get_food_saturated_fat_calculated_metric, $get_food_monounsaturated_fat_calculated_metric, $get_food_polyunsaturated_fat_calculated_metric, $get_food_cholesterol_calculated_metric, $get_food_carbohydrates_calculated_metric, $get_food_carbohydrates_of_which_sugars_calculated_metric, $get_food_dietary_fiber_calculated_metric, $get_food_proteins_calculated_metric, $get_food_salt_calculated_metric, $get_food_sodium_calculated_metric, $get_food_energy_calculated_us, $get_food_fat_calculated_us, $get_food_saturated_fat_calculated_us, $get_food_monounsaturated_fat_calculated_us, $get_food_polyunsaturated_fat_calculated_us, $get_food_cholesterol_calculated_us, $get_food_carbohydrates_calculated_us, $get_food_carbohydrates_of_which_sugars_calculated_us, $get_food_dietary_fiber_calculated_us, $get_food_proteins_calculated_us, $get_food_salt_calculated_us, $get_food_sodium_calculated_us, $get_food_barcode, $get_food_main_category_id, $get_food_sub_category_id, $get_food_image_path, $get_food_image_a, $get_food_thumb_a_small, $get_food_thumb_a_medium, $get_food_thumb_a_large, $get_food_image_b, $get_food_thumb_b_small, $get_food_thumb_b_medium, $get_food_thumb_b_large, $get_food_image_c, $get_food_thumb_c_small, $get_food_thumb_c_medium, $get_food_thumb_c_large, $get_food_image_d, $get_food_thumb_d_small, $get_food_thumb_d_medium, $get_food_thumb_d_large, $get_food_image_e, $get_food_thumb_e_small, $get_food_thumb_e_medium, $get_food_thumb_e_large, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block, $get_food_user_ip, $get_food_created_date, $get_food_last_viewed, $get_food_age_restriction) = $row;

		if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a")){	
			// Name saying
			$title = "$get_food_manufacturer_name $get_food_name";
			$check = strlen($title);
			if($check > 35){
				$title = substr($title, 0, 35);
				$title = $title . "...";
			}

			// Thumb small
			if(!(file_exists("../$get_food_image_path/$get_food_thumb_a_small")) OR $get_food_thumb_a_small == ""){
				$ext = get_extension("$get_food_image_a");
				$inp_thumb_name = str_replace(".$ext", "", $get_food_image_a);
				$get_food_thumb_a_small = $inp_thumb_name . "_thumb_132x132." . $ext;
				$inp_food_thumb_a_small_mysql = quote_smart($link, $get_food_thumb_a_small);
				$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb_a_small=$inp_food_thumb_a_small_mysql WHERE food_id=$get_food_id") or die(mysqli_error($link));
				
				resize_crop_image(132, 132, "$root/$get_food_image_path/$get_food_image_a", "$root/$get_food_image_path/$get_food_thumb_a_small");
			}

			// Thumb medium
			if(!(file_exists("../$get_food_image_path/$get_food_thumb_a_medium")) OR $get_food_thumb_a_medium == ""){
				$ext = get_extension("$get_food_image_a");
				$inp_thumb_name = str_replace(".$ext", "", $get_food_image_a);
				$get_food_thumb_a_medium = $inp_thumb_name . "_thumb_200x200." . $ext;
				$inp_food_thumb_a_medium_mysql = quote_smart($link, $get_food_thumb_a_medium);
				$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb_a_medium=$inp_food_thumb_a_medium_mysql WHERE food_id=$get_food_id") or die(mysqli_error($link));
				
				resize_crop_image(200, 200, "$root/$get_food_image_path/$get_food_image_a", "$root/$get_food_image_path/$get_food_thumb_a_medium");
			}

			// Thumb large
			if(!(file_exists("../$get_food_image_path/$get_food_thumb_a_large")) OR $get_food_thumb_a_large == ""){
				$ext = get_extension("$get_food_image_a");
				$inp_thumb_name = str_replace(".$ext", "", $get_food_image_a);
				$get_food_thumb_a_large = $inp_thumb_name . "_thumb_420x283." . $ext;
				$inp_food_thumb_a_large_mysql = quote_smart($link, $get_food_thumb_a_large);
				$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb_a_large=$inp_food_thumb_a_large_mysql WHERE food_id=$get_food_id") or die(mysqli_error($link));
				
				resize_crop_image(420, 283, "$root/$get_food_image_path/$get_food_image_a", "$root/$get_food_image_path/$get_food_thumb_a_large");
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
				<a href=\"view_food.php?main_category_id=$get_food_main_category_id&amp;sub_category_id=$get_food_sub_category_id&amp;food_id=$get_food_id&amp;l=$l\"><img src=\"$root/$get_food_image_path/$get_food_thumb_a_small\" alt=\"$get_food_image_a\" style=\"margin-bottom: 5px;\" /></a><br />
					
				<a href=\"view_food.php?main_category_id=$get_food_main_category_id&amp;sub_category_id=$get_food_sub_category_id&amp;food_id=$get_food_id&amp;l=$l\" style=\"font-weight: bold;color: #444444;\">$title</a><br />
				";
				echo"
				</p>
				";

		// Tags
		$t = 0;
		$query_t = "SELECT tag_id, tag_title, tag_title_clean FROM $t_food_index_tags WHERE tag_food_id=$get_food_id ORDER BY tag_title ASC";
		$result_t = mysqli_query($link, $query_t);
		while($row_t = mysqli_fetch_row($result_t)) {
			list($get_tag_id, $get_tag_title, $get_tag_title_clean) = $row_t;
			if($t == "0"){
				echo"<p style=\"padding-top:0;\">";
			}

			echo"
			<a href=\"view_tag.php?tag=$get_tag_title_clean&amp;l=$l\" class=\"btn_default_small\">$get_tag_title</a>
			";
			$t++;

		}
		if($t > 0){
			echo"</p>";
		}

		if($nutritional_content_layout == "1" && ($get_current_view_hundred_metric == "1" OR $get_current_view_pcs_metric == "1" OR $get_current_view_eight_us == "1" OR $get_current_view_pcs_us == "1")){
				
				echo"
				<table style=\"margin: 0px auto;\">
				";
				if($get_current_view_hundred_metric == "1"){
					echo"
					 <tr>
					  <td style=\"padding-right: 6px;text-align: center;\">
						<span class=\"nutritional_number\">$l_hundred</span>
					  </td>
					  <td style=\"padding-right: 6px;text-align: center;\">
						<span class=\"nutritional_number\">$get_food_energy_metric</span>
					  </td>
					  <td style=\"padding-right: 6px;text-align: center;\">
						<span class=\"nutritional_number\">$get_food_fat_metric</span>
					  </td>
					  <td style=\"padding-right: 6px;text-align: center;\">
						<span class=\"nutritional_number\">$get_food_carbohydrates_metric</span>
					  </td>
					  <td style=\"text-align: center;\">
						<span class=\"nutritional_number\">$get_food_proteins_metric</span>
					  </td>
					 </tr>
					";
				}
				if($get_current_view_pcs_metric == "1"){
					echo"
					 <tr>
					  <td style=\"padding-right: 6px;text-align: center;"; if($get_current_view_hundred_metric == "1"){ echo"padding-top:6px;"; } echo"\">
						<span class=\"nutritional_number\" title=\"$get_food_serving_size_metric $get_food_serving_size_measurement_metric\">$get_food_serving_size_pcs $get_food_serving_size_pcs_measurement</span>
					  </td>
					  <td style=\"padding-right: 6px;text-align: center;"; if($get_current_view_hundred_metric == "1"){ echo"padding-top:6px;"; } echo"\">
						<span class=\"nutritional_number\">$get_food_energy_calculated_metric</span>
					  </td>
					  <td style=\"padding-right: 6px;text-align: center;"; if($get_current_view_hundred_metric == "1"){ echo"padding-top:6px;"; } echo"\">
						<span class=\"nutritional_number\">$get_food_fat_calculated_metric</span>
					  </td>
					  <td style=\"padding-right: 6px;text-align: center;"; if($get_current_view_hundred_metric == "1"){ echo"padding-top:6px;"; } echo"\">
						<span class=\"nutritional_number\">$get_food_carbohydrates_calculated_metric</span>
					  </td>
					  <td style=\"text-align: center;"; if($get_current_view_hundred_metric == "1"){ echo"padding-top:6px;"; } echo"\">
						<span class=\"nutritional_number\">$get_food_proteins_calculated_metric</span>
					  </td>
					 </tr>
					";
				}
				if($get_current_view_eight_us == "1"){
					echo"
					 <tr>
					  <td style=\"padding-right: 6px;text-align: center;"; if($get_current_view_hundred_metric == "1"){ echo"padding-top:6px;"; } echo"\">
						<span class=\"nutritional_number\">$l_per_eight_abbr_lowercase</span>
					  </td>
					  <td style=\"padding-right: 6px;text-align: center;"; if($get_current_view_hundred_metric == "1"){ echo"padding-top:6px;"; } echo"\">
						<span class=\"nutritional_number\">$get_food_energy_us</span>
					  </td>
					  <td style=\"padding-right: 6px;text-align: center;"; if($get_current_view_hundred_metric == "1"){ echo"padding-top:6px;"; } echo"\">
						<span class=\"nutritional_number\">$get_food_fat_us</span>
					  </td>
					  <td style=\"padding-right: 6px;text-align: center;"; if($get_current_view_hundred_metric == "1"){ echo"padding-top:6px;"; } echo"\">
						<span class=\"nutritional_number\">$get_food_carbohydrates_us</span>
					  </td>
					  <td style=\"text-align: center;"; if($get_current_view_hundred_metric == "1"){ echo"padding-top:6px;"; } echo"\">
						<span class=\"nutritional_number\">$get_food_proteins_us</span>
					  </td>
					 </tr>
					";
				}
				if($get_current_view_pcs_us == "1"){
					echo"
					 <tr>
					  <td style=\"padding-right: 6px;text-align: center;"; if($get_current_view_hundred_metric == "1"){ echo"padding-top:6px;"; } echo"\">
						<span class=\"nutritional_number\" title=\"$get_food_serving_size_us $get_food_serving_size_measurement_us\">$get_food_serving_size_pcs $get_food_serving_size_pcs_measurement</span>
					  </td>
					  <td style=\"padding-right: 6px;text-align: center;"; if($get_current_view_hundred_metric == "1"){ echo"padding-top:6px;"; } echo"\">
						<span class=\"nutritional_number\">$get_food_energy_calculated_us</span>
					  </td>
					  <td style=\"padding-right: 6px;text-align: center;"; if($get_current_view_hundred_metric == "1"){ echo"padding-top:6px;"; } echo"\">
						<span class=\"nutritional_number\">$get_food_fat_calculated_us</span>
					  </td>
					  <td style=\"padding-right: 6px;text-align: center;"; if($get_current_view_hundred_metric == "1"){ echo"padding-top:6px;"; } echo"\">
						<span class=\"nutritional_number\">$get_food_carbohydrates_calculated_us</span>
					  </td>
					  <td style=\"text-align: center;"; if($get_current_view_hundred_metric == "1"){ echo"padding-top:6px;"; } echo"\">
						<span class=\"nutritional_number\">$get_food_proteins_calculated_us</span>
					  </td>
					 </tr>
					";
				}
				if($get_current_view_hundred_metric == "1" OR $get_current_view_pcs_metric == "1" OR $get_current_view_eight_us == "1" OR $get_current_view_pcs_us == "1"){
					echo"
					 <tr>
					  <td style=\"padding-right: 6px;text-align: center;\">
					  </td>
					  <td style=\"padding-right: 6px;text-align: center;\">
						<span class=\"nutritional_number\">$l_calories_abbr_lowercase</span>
					  </td>
					  <td style=\"padding-right: 6px;text-align: center;\">
						<span class=\"nutritional_number\">$l_fat_abbr_lowercase</span>
					  </td>
					  <td style=\"padding-right: 6px;text-align: center;\">
						<span class=\"nutritional_number\">$l_carbohydrates_abbr_lowercase</span>
					  </td>
					  <td style=\"text-align: center;\">
						<span class=\"nutritional_number\">$l_proteins_abbr_lowercase</span>
					  </td>
					 </tr>
					</table>
					";
				}
			}
			elseif($nutritional_content_layout == "2" && ($get_current_view_hundred_metric == "1" OR $get_current_view_pcs_metric == "1" OR $get_current_view_eight_us == "1" OR $get_current_view_pcs_us == "1")){
				
					echo"
					<table style=\"margin: 0px auto;\">
					 <tr>
					  <td style=\"padding-right: 3px;\">
					  </td>";
					if($get_current_view_hundred_metric == "1"){
						echo"
						  <td style=\"padding-right: 3px;text-align: center;vertical-align: bottom;\">
							<span class=\"grey_small\">$l_hundred</span>
						  </td>
						";
					}
					if($get_current_view_pcs_metric == "1"){
						echo"
						  <td style=\"padding-right: 3px;text-align: center;vertical-align: bottom;\">
							<span class=\"grey_small\" title=\"$get_food_serving_size_metric $get_food_serving_size_measurement_metric\">$get_food_serving_size_pcs $get_food_serving_size_pcs_measurement<br />$get_food_serving_size_metric $get_food_serving_size_measurement_metric</span>
						  </td>
						";
					}
					if($get_current_view_eight_us == "1"){
						echo"
						  <td style=\"padding-right: 3px;text-align: center;vertical-align: bottom;\">
							<span class=\"grey_small\">$l_eight</span>
						  </td>
						";
					}
					if($get_current_view_pcs_us == "1"){
						echo"
						  <td style=\"padding-right: 3px;text-align: center;vertical-align: bottom;\">
							<span class=\"grey_small\" title=\"$get_food_serving_size_us $get_food_serving_size_measurement_us\">$get_food_serving_size_pcs $get_food_serving_size_pcs_measurement<br />$get_food_serving_size_us $get_food_serving_size_measurement_us</span>
						  </td>
						";
					}
					echo"
					 </tr>
					 <tr>
					  <td style=\"text-align: center;\">
						<span class=\"grey_small\">$l_calories_abbr_lowercase</span>
					  </td>";
					if($get_current_view_hundred_metric == "1"){
						echo"
						  <td style=\"text-align: center;\">
							<span class=\"grey_small\">$get_food_energy_metric</span>
						  </td>
						";
					}
					if($get_current_view_pcs_metric == "1"){
						echo"
						  <td style=\"text-align: center;\">
							<span class=\"grey_small\">$get_food_energy_calculated_metric</span>
						  </td>
						";
					}
					if($get_current_view_eight_us == "1"){
						echo"
						  <td style=\"text-align: center;\">
							<span class=\"grey_small\">$get_food_energy_us</span>
						  </td>
						";
					}
					if($get_current_view_pcs_us == "1"){
						echo"
						  <td style=\"text-align: center;\">
							<span class=\"grey_small\">$get_food_energy_calculated_us</span>
						  </td>
						";
					}
					echo"
					 </tr>
					 <tr>
					  <td style=\"text-align: center;\">
						<span class=\"grey_small\">$l_fat_abbr_lowercase</span>
					  </td>";
					if($get_current_view_hundred_metric == "1"){
						echo"
						  <td style=\"text-align: center;\">
							<span class=\"grey_small\">$get_food_fat_metric</span>
						  </td>
						";
					}
					if($get_current_view_pcs_metric == "1"){
						echo"
						  <td style=\"text-align: center;\">
							<span class=\"grey_small\">$get_food_fat_calculated_metric</span>
						  </td>
						";
					}
					if($get_current_view_eight_us == "1"){
						echo"
						  <td style=\"text-align: center;\">
							<span class=\"grey_small\">$get_food_fat_us</span>
						  </td>
						";
					}
					if($get_current_view_pcs_us == "1"){
						echo"
						  <td style=\"text-align: center;\">
							<span class=\"grey_small\">$get_food_fat_calculated_us</span>
						  </td>
						";
					}
					echo"
					 </tr>
					 <tr>
					  <td style=\"text-align: center;\">
						<span class=\"grey_small\">$l_carbohydrates_abbr_lowercase</span>
					  </td>";
					if($get_current_view_hundred_metric == "1"){
						echo"
						  <td style=\"text-align: center;\">
							<span class=\"grey_small\">$get_food_carbohydrates_metric</span>
						  </td>
						";
					}
					if($get_current_view_pcs_metric == "1"){
						echo"
						  <td style=\"text-align: center;\">
							<span class=\"grey_small\">$get_food_carbohydrates_calculated_metric</span>
						  </td>
						";
					}
					if($get_current_view_eight_us == "1"){
						echo"
						  <td style=\"text-align: center;\">
							<span class=\"grey_small\">$get_food_carbohydrates_us</span>
						  </td>
						";
					}
					if($get_current_view_pcs_us == "1"){
						echo"
						  <td style=\"text-align: center;\">
							<span class=\"grey_small\">$get_food_carbohydrates_calculated_us</span>
						  </td>
						";
					}
					echo"
					 </tr>
					 <tr>
					  <td style=\"text-align: center;\">
						<span class=\"grey_small\">$l_proteins_abbr_lowercase</span>
					  </td>";
					if($get_current_view_hundred_metric == "1"){
						echo"
						  <td style=\"text-align: center;\">
							<span class=\"grey_small\">$get_food_proteins_metric</span>
						  </td>
						";
					}
					if($get_current_view_pcs_metric == "1"){
						echo"
						  <td style=\"text-align: center;\">
							<span class=\"grey_small\">$get_food_proteins_calculated_metric</span>
						  </td>
						";
					}
					if($get_current_view_eight_us == "1"){
						echo"
						  <td style=\"text-align: center;\">
							<span class=\"grey_small\">$get_food_proteins_us</span>
						  </td>
						";
					}
					if($get_current_view_pcs_us == "1"){
						echo"
						  <td style=\"text-align: center;\">
							<span class=\"grey_small\">$get_food_proteins_calculated_us</span>
						  </td>
						";
					}
				echo"
					 </tr>
				</table>
				";

			} // $nutritional_content_layout == 2
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
	if($x == "0"){
		echo"
				<div class=\"clear\"></div>
		";
	}
	elseif($x == "2"){
		echo"
				<div class=\"left_center_center_right_right_center\" style=\"text-align: center;padding-bottom: 20px;\">
				</div>
				<div class=\"left_center_center_right_right\" style=\"text-align: center;padding-bottom: 20px;\">
				</div>
				<div class=\"clear\"></div>
		";
	}
	elseif($x == "3"){
		echo"
				<div class=\"left_center_center_right_right\" style=\"text-align: center;padding-bottom: 20px;\">
				</div>
				<div class=\"clear\"></div>
		";
	}
	echo"
	</div>

<!-- //New products -->

";


/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>