<?php
/**
*
* File: _food/open_sub_category.php
* Version 1.0.0.
* Date 11:25 02.02.2019
* Copyright (c) 2008-2019 Sindre Andre Ditlefsen
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

if(isset($_GET['sub_category_id'])){
	$sub_category_id= $_GET['sub_category_id'];
	$sub_category_id = strip_tags(stripslashes($sub_category_id));
}
else{
	$sub_category_id = "";
}
if(isset($_GET['main_category_id'])){
	$main_category_id= $_GET['main_category_id'];
	$main_category_id = strip_tags(stripslashes($main_category_id));
}
else{
	$main_category_id = "";
}

if(isset($_GET['order_by'])) {
	$order_by = $_GET['order_by'];
	$order_by = strip_tags(stripslashes($order_by));
}
else{
	$order_by = "food_score";
}
if(isset($_GET['order_method'])) {
	$order_method = $_GET['order_method'];
	$order_method = strip_tags(stripslashes($order_method));
}
else{
	$order_method = "";
}
if(isset($_GET['store_id'])) {
	$store_id = $_GET['store_id'];
	$store_id = strip_tags(stripslashes($store_id));
}
else{
	$store_id = "";
}
$store_id_mysql = quote_smart($link, $store_id);

if(isset($_GET['update_statistics'])) {
	$update_statistics = $_GET['update_statistics'];
	$update_statistics = strip_tags(stripslashes($update_statistics));
}
else{
	$update_statistics = "";
}
if(isset($_GET['system'])){
	$system = $_GET['system'];
	$system = strip_tags(stripslashes($system));
	if($system != "all" && $system != "metric" && $system != "us"){
		echo"Unknown system";
		die;
	}
}
else{
	$system = "metric";
}


/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/food/ts_food.php");

/*- Sub category -------------------------------------------------------------------------- */
// Select sub category
$sub_category_id_mysql = quote_smart($link, $sub_category_id);
$query = "SELECT category_id, category_user_id, category_name, category_age_restriction, category_parent_id, category_icon, category_last_updated, category_note FROM $t_food_categories WHERE category_id=$sub_category_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_sub_category_id, $get_current_sub_category_user_id, $get_current_sub_category_name, $get_current_sub_category_age_restriction, $get_current_sub_category_parent_id, $get_current_sub_category_icon, $get_current_sub_category_last_updated, $get_current_sub_category_note) = $row;

if($get_current_sub_category_id== ""){
	$website_title = "$l_food - Server error 404";
}
else{
	// Sub category Translation
	$query_t = "SELECT category_translation_id, category_id, category_translation_language, category_translation_value, category_translation_no_food, category_translation_last_updated, category_stats_last_updated_year, category_calories_min_metric, category_calories_med_metric, category_calories_max_metric, category_fat_min_metric, category_fat_med_metric, category_fat_max_metric, category_saturated_fat_min_metric, category_saturated_fat_med_metric, category_saturated_fat_max_metric, category_monounsaturated_fat_min_metric, category_monounsaturated_fat_med_metric, category_monounsaturated_fat_max_metric, category_polyunsaturated_fat_min_metric, category_polyunsaturated_fat_med_metric, category_polyunsaturated_fat_max_metric, category_cholesterol_min_metric, category_cholesterol_med_metric, category_cholesterol_max_metric, category_carb_min_metric, category_carb_med_metric, category_carb_max_metric, category_carb_of_which_sugars_min_metric, category_carb_of_which_sugars_med_metric, category_carb_of_which_sugars_max_metric, category_dietary_fiber_min_metric, category_dietary_fiber_med_metric, category_dietary_fiber_max_metric, category_proteins_min_metric, category_proteins_med_metric, category_proteins_max_metric, category_salt_min_metric, category_salt_med_metric, category_salt_max_metric, category_sodium_min_metric, category_sodium_med_metric, category_sodium_max_metric, category_calories_min_us, category_calories_med_us, category_calories_max_us, category_fat_min_us, category_fat_med_us, category_fat_max_us, category_saturated_fat_min_us, category_saturated_fat_med_us, category_saturated_fat_max_us, category_monounsaturated_fat_min_us, category_monounsaturated_fat_med_us, category_monounsaturated_fat_max_us, category_polyunsaturated_fat_min_us, category_polyunsaturated_fat_med_us, category_polyunsaturated_fat_max_us, category_cholesterol_min_us, category_cholesterol_med_us, category_cholesterol_max_us, category_carb_min_us, category_carb_med_us, category_carb_max_us, category_carb_of_which_sugars_min_us, category_carb_of_which_sugars_med_us, category_carb_of_which_sugars_max_us, category_dietary_fiber_min_us, category_dietary_fiber_med_us, category_dietary_fiber_max_us, category_proteins_min_us, category_proteins_med_us, category_proteins_max_us, category_salt_min_us, category_salt_med_us, category_salt_max_us, category_sodium_min_us, category_sodium_med_us, category_sodium_max_us FROM $t_food_categories_translations WHERE category_id=$get_current_sub_category_id AND category_translation_language=$l_mysql";
	$result_t = mysqli_query($link, $query_t);
	$row_t = mysqli_fetch_row($result_t);
	list($get_current_sub_category_translation_id, $get_current_sub_category_id, $get_current_sub_category_translation_language, $get_current_sub_category_translation_value, $get_current_sub_category_translation_no_food, $get_current_sub_category_translation_last_updated, $get_current_sub_category_stats_last_updated_year, $get_current_sub_category_calories_min_metric, $get_current_sub_category_calories_med_metric, $get_current_sub_category_calories_max_metric, $get_current_sub_category_fat_min_metric, $get_current_sub_category_fat_med_metric, $get_current_sub_category_fat_max_metric, $get_current_sub_category_saturated_fat_min_metric, $get_current_sub_category_saturated_fat_med_metric, $get_current_sub_category_saturated_fat_max_metric, $get_current_sub_category_monounsaturated_fat_min_metric, $get_current_sub_category_monounsaturated_fat_med_metric, $get_current_sub_category_monounsaturated_fat_max_metric, $get_current_sub_category_polyunsaturated_fat_min_metric, $get_current_sub_category_polyunsaturated_fat_med_metric, $get_current_sub_category_polyunsaturated_fat_max_metric, $get_current_sub_category_cholesterol_min_metric, $get_current_sub_category_cholesterol_med_metric, $get_current_sub_category_cholesterol_max_metric, $get_current_sub_category_carb_min_metric, $get_current_sub_category_carb_med_metric, $get_current_sub_category_carb_max_metric, $get_current_sub_category_carb_of_which_sugars_min_metric, $get_current_sub_category_carb_of_which_sugars_med_metric, $get_current_sub_category_carb_of_which_sugars_max_metric, $get_current_sub_category_dietary_fiber_min_metric, $get_current_sub_category_dietary_fiber_med_metric, $get_current_sub_category_dietary_fiber_max_metric, $get_current_sub_category_proteins_min_metric, $get_current_sub_category_proteins_med_metric, $get_current_sub_category_proteins_max_metric, $get_current_sub_category_salt_min_metric, $get_current_sub_category_salt_med_metric, $get_current_sub_category_salt_max_metric, $get_current_sub_category_sodium_min_metric, $get_current_sub_category_sodium_med_metric, $get_current_sub_category_sodium_max_metric, $get_current_sub_category_calories_min_us, $get_current_sub_category_calories_med_us, $get_current_sub_category_calories_max_us, $get_current_sub_category_fat_min_us, $get_current_sub_category_fat_med_us, $get_current_sub_category_fat_max_us, $get_current_sub_category_saturated_fat_min_us, $get_current_sub_category_saturated_fat_med_us, $get_current_sub_category_saturated_fat_max_us, $get_current_sub_category_monounsaturated_fat_min_us, $get_current_sub_category_monounsaturated_fat_med_us, $get_current_sub_category_monounsaturated_fat_max_us, $get_current_sub_category_polyunsaturated_fat_min_us, $get_current_sub_category_polyunsaturated_fat_med_us, $get_current_sub_category_polyunsaturated_fat_max_us, $get_current_sub_category_cholesterol_min_us, $get_current_sub_category_cholesterol_med_us, $get_current_sub_category_cholesterol_max_us, $get_current_sub_category_carb_min_us, $get_current_sub_category_carb_med_us, $get_current_sub_category_carb_max_us, $get_current_sub_category_carb_of_which_sugars_min_us, $get_current_sub_category_carb_of_which_sugars_med_us, $get_current_sub_category_carb_of_which_sugars_max_us, $get_current_sub_category_dietary_fiber_min_us, $get_current_sub_category_dietary_fiber_med_us, $get_current_sub_category_dietary_fiber_max_us, $get_current_sub_category_proteins_min_us, $get_current_sub_category_proteins_med_us, $get_current_sub_category_proteins_max_us, $get_current_sub_category_salt_min_us, $get_current_sub_category_salt_med_us, $get_current_sub_category_salt_max_us, $get_current_sub_category_sodium_min_us, $get_current_sub_category_sodium_med_us, $get_current_sub_category_sodium_max_us) = $row_t;
	

	// Find main category
	$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$get_current_sub_category_parent_id";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_main_category_id, $get_current_main_category_user_id, $get_current_main_category_name, $get_current_main_category_parent_id) = $row;
	
	// Main category translation
	$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_current_main_category_id AND category_translation_language=$l_mysql";
	$result_t = mysqli_query($link, $query_t);
	$row_t = mysqli_fetch_row($result_t);
	list($get_current_main_category_translation_value) = $row_t;
	
	// Title
	$website_title = "$l_food - $get_current_main_category_translation_value - $get_current_sub_category_translation_value";

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
	<!-- Headline, buttons, search -->
		<div class=\"food_headline\">
		
			<!-- Headline -->
				<h1>$get_current_sub_category_translation_value</h1>
			<!-- //Headline -->

			<!-- Where am I ? -->
				<p><b>$l_you_are_here:</b><br />
				<a href=\"index.php?l=$l\">$l_food</a>
				&gt;
				<a href=\"open_main_category.php?main_category_id=$get_current_main_category_id&amp;l=$l\">$get_current_main_category_translation_value</a>
				&gt;
				<a href=\"open_sub_category.php?sub_category_id=$get_current_sub_category_id&amp;l=$l\">$get_current_sub_category_translation_value</a>
				</p>
			<!-- //Where am I ? -->

		</div>
		<div class=\"food_menu\">
		
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

			<!-- System -->
				<p>
				$l_system:
				<a href=\"open_sub_category.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;system=metric&amp;l=$l\""; if($system == "metric"){ echo" style=\"font-weight:bold;\""; } echo">$l_metric</a>
				&middot;
				<a href=\"open_sub_category.php?main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;system=us&amp;l=$l\""; if($system == "us"){ echo" style=\"font-weight:bold;\""; } echo">$l_us</a>
				</p>
			<!-- System -->
		</div>
		<div class=\"clear\"></div>
	<!-- //Headline, buttons, search -->


	<!-- Food Search -->
		<div class=\"food_search\">
			<form method=\"get\" action=\"search.php\" enctype=\"multipart/form-data\">
			<p>
			<input type=\"text\" name=\"search_query\" id=\"nettport_inp_search_query\" value=\"\" size=\"10\" style=\"width: 50%;\"  />
			<input type=\"hidden\" name=\"system\" value=\"$system\" />
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
                    					\$(\"#nettport_search_results\").append(html);
              					}
            				});
       				}
        			return false;
			});
		});
		</script>
		<!-- //Search script -->
		<div id=\"nettport_search_results\">
		</div>
	<!-- //Food Search -->

	<!-- User adaptet view -->";
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
		<input type=\"checkbox\" name=\"inp_show_hundred_metric\" class=\"onclick_go_to_url\""; if($get_current_view_hundred_metric == "1"){ echo" checked=\"checked\" data-target=\"user_adapted_view.php?set=hundred_metric&amp;value=0&amp;process=1&amp;referer=open_sub_category&amp;main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;l=$l\""; } else{ echo" data-target=\"user_adapted_view.php?set=hundred_metric&amp;value=1&amp;process=1&amp;referer=open_sub_category&amp;main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;l=$l\""; } echo" /> $l_hundred
		<input type=\"checkbox\" name=\"inp_show_pcs_metric\" class=\"onclick_go_to_url\""; if($get_current_view_pcs_metric == "1"){ echo" checked=\"checked\" data-target=\"user_adapted_view.php?set=pcs_metric&amp;value=0&amp;process=1&amp;referer=open_sub_category&amp;main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;l=$l\""; } else{ echo" data-target=\"user_adapted_view.php?set=pcs_metric&amp;value=1&amp;process=1&amp;referer=open_sub_category&amp;main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;l=$l\""; } echo" /> $l_pcs_g
		<input type=\"checkbox\" name=\"inp_show_metric_us_and_or_pcs\" class=\"onclick_go_to_url\""; if($get_current_view_eight_us == "1"){ echo" checked=\"checked\" data-target=\"user_adapted_view.php?set=eight_us&amp;value=0&amp;process=1&amp;referer=open_sub_category&amp;main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;l=$l\""; } else{ echo" data-target=\"user_adapted_view.php?set=eight_us&amp;value=1&amp;process=1&amp;referer=open_sub_category&amp;main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;l=$l\""; } echo" /> $l_eight
		<input type=\"checkbox\" name=\"inp_show_metric_us_and_or_pcs\" class=\"onclick_go_to_url\""; if($get_current_view_pcs_us == "1"){ echo" checked=\"checked\" data-target=\"user_adapted_view.php?set=pcs_us&amp;value=0&amp;process=1&amp;referer=open_sub_category&amp;main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;l=$l\""; } else{ echo" data-target=\"user_adapted_view.php?set=pcs_us&amp;value=1&amp;process=1&amp;referer=open_sub_category&amp;main_category_id=$get_current_main_category_id&amp;sub_category_id=$get_current_sub_category_id&amp;l=$l\""; } echo" /> $l_pcs_oz
		</p>

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

	<!-- //User adaptet view -->

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
				echo"<li><a href=\"$root/food/open_main_category.php?main_category_id=$get_category_id&amp;system=$system&amp;l=$l\">$get_category_translation_value</a></li>\n";
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
				<li><a href=\"open_sub_category.php?main_category_id=$main_category_id&amp;sub_category_id=$get_sub_category_id&amp;system=$system&amp;l=$l\""; if($get_sub_category_id == "$sub_category_id"){ echo" class=\"active\""; } echo">$get_category_translation_value</a></li>
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
				\$('#inp_store_select').on('change', function () {
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
				<option value=\"open_sub_category.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;store_id=$store_id&amp;system=$system&amp;l=$l\">- $l_order_by -</option>
				<option value=\"open_sub_category.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;order_by=food_score&amp;order_method=$order_method&amp;store_id=$store_id&amp;system=$system&amp;l=$l\""; if($order_by == "food_score"){ echo" selected=\"selected\""; } echo">$l_score</option>
				<option value=\"open_sub_category.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;order_by=food_id&amp;order_method=$order_method&amp;store_id=$store_id&amp;system=$system&amp;l=$l\""; if($order_by == "food_id"){ echo" selected=\"selected\""; } echo">$l_date</option>
				<option value=\"open_sub_category.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;order_by=food_name&amp;order_method=$order_method&amp;store_id=$store_id&amp;system=$system&amp;l=$l\""; if($order_by == "food_name"){ echo" selected=\"selected\""; } echo">$l_name</option>
				<option value=\"open_sub_category.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;order_by=food_manufacturer_name_and_food_name&amp;order_method=$order_method&amp;store_id=$store_id&amp;system=$system&amp;l=$l\""; if($order_by == "food_manufacturer_name_and_food_name" OR $order_by == ""){ echo" selected=\"selected\""; } echo">$l_manufacturer_and_name</option>
				<option value=\"open_sub_category.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;order_by=food_unique_hits&amp;order_method=$order_method&amp;store_id=$store_id&amp;system=$system&amp;l=$l\""; if($order_by == "food_unique_hits"){ echo" selected=\"selected\""; } echo">$l_unique_hits</option>
				<option value=\"open_sub_category.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;order_by=food_energy_metric&amp;order_method=$order_method&amp;store_id=$store_id&amp;system=$system&amp;l=$l\""; if($order_by == "food_energy_metric"){ echo" selected=\"selected\""; } echo">$l_calories</option>
				<option value=\"open_sub_category.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;order_by=food_fat_metric&amp;order_method=$order_method&amp;store_id=$store_id&amp;system=$system&amp;l=$l\""; if($order_by == "food_fat_metric"){ echo" selected=\"selected\""; } echo">$l_fat</option>
				<option value=\"open_sub_category.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;order_by=food_carbohydrates_metric&amp;order_method=$order_method&amp;store_id=$store_id&amp;system=$system&amp;l=$l\""; if($order_by == "food_carbohydrates_metric"){ echo" selected=\"selected\""; } echo">$l_carbs</option>
				<option value=\"open_sub_category.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;order_by=food_proteins_metric&amp;order_method=$order_method&amp;store_id=$store_id&amp;system=$system&amp;l=$l\""; if($order_by == "food_proteins_metric"){ echo" selected=\"selected\""; } echo">$l_proteins</option>
			</select>
			<select name=\"inp_order_method\" id=\"inp_order_method_select\">";
				if($order_by == ""){
					$order_by = "food_manufacturer_name_and_food_name";
				}
				echo"
				<option value=\"open_sub_category.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;order_by=$order_by&amp;order_method=asc&amp;store_id=$store_id&amp;system=$system&amp;l=$l\""; if($order_method == "asc" OR $order_method == ""){ echo" selected=\"selected\""; } echo">$l_asc</option>
				<option value=\"open_sub_category.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;order_by=$order_by&amp;order_method=desc&amp;store_id=$store_id&amp;system=$system&amp;l=$l\""; if($order_method == "desc"){ echo" selected=\"selected\""; } echo">$l_desc</option>
			</select>
			<select name=\"inp_store\" id=\"inp_store_select\">
				<option value=\"open_sub_category.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;order_by=$order_by&amp;order_method=asc&amp;store_id=&amp;system=$system&amp;l=$l\""; if($store_id == ""){ echo" selected=\"selected\""; } echo">- $l_store -</option>\n";

				$query = "SELECT store_id, store_name FROM $t_food_stores WHERE store_language=$l_mysql ORDER BY store_name ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_store_id, $get_store_name) = $row;
					echo"				";
					echo"<option value=\"open_sub_category.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;order_by=$order_by&amp;order_method=$order_method&amp;store_id=$get_store_id&amp;system=$system&amp;l=$l\""; if($get_store_id == "$store_id"){ echo" selected=\"selected\""; } echo">$get_store_name</option>\n";
				}
				echo"				
			</select>
			</p>
        		</form>
	</div>
	<!-- //Sorting -->

	<!-- Update -->
	";
	$year = date("Y");
	if($get_current_sub_category_stats_last_updated_year != "$year"){
		$update_statistics = 1;
	}
	if($update_statistics == 1){

		echo"
		<div class=\"clear\"></div>
		<div class=\"info\">
			<h2>$l_calculating...</h2>
			<p>
			<a href=\"open_sub_category.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;system=$system&l=$l#statistics\">open_sub_category.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&system=$system&l=$l</a>
			</p>
			<meta http-equiv=\"refresh\" content=\"1;url=open_sub_category.php?main_category_id=$main_category_id&sub_category_id=$sub_category_id&system=$system\">
		</div>
		";
	}
	echo"
	<!-- //Update -->


	

	<!-- Food in subcategory -->
		";

		// Ready calculations : number of foods
		$inp_total_number_of_foods_in_sub_category = 0;
		
		// Ready calculations : min
		$inp_current_sub_category_calories_min_metric = 999;
		$inp_current_sub_category_fat_min_metric = 999;
		$inp_current_sub_category_saturated_fat_min_metric = 999;
		$inp_current_sub_category_monounsaturated_fat_min_metric = 999;
		$inp_current_sub_category_polyunsaturated_fat_min_metric = 999;
		$inp_current_sub_category_cholesterol_min_metric = 999;
		$inp_current_sub_category_carb_min_metric = 999;
		$inp_current_sub_category_carb_of_which_sugars_min_metric = 999;
		$inp_current_sub_category_dietary_fiber_min_metric = 999;
		$inp_current_sub_category_proteins_min_metric = 999;
		$inp_current_sub_category_salt_min_metric = 999;
		$inp_current_sub_category_sodium_min_metric = 999;

		$inp_current_sub_category_calories_min_us = 999;
		$inp_current_sub_category_fat_min_us = 999;
		$inp_current_sub_category_saturated_fat_min_us = 999;
		$inp_current_sub_category_monounsaturated_fat_min_us = 999;
		$inp_current_sub_category_polyunsaturated_fat_min_us = 999;
		$inp_current_sub_category_cholesterol_min_us = 999;
		$inp_current_sub_category_carb_min_us = 999;
		$inp_current_sub_category_carb_of_which_sugars_min_us = 999;
		$inp_current_sub_category_dietary_fiber_min_us = 999;
		$inp_current_sub_category_proteins_min_us = 999;
		$inp_current_sub_category_salt_min_us = 999;
		$inp_current_sub_category_sodium_min_us = 999;


		// Ready calculations : median
		$inp_current_sub_category_calories_med_sum_metric = 0;
		$inp_current_sub_category_fat_med_sum_metric = 0;
		$inp_current_sub_category_saturated_fat_med_sum_metric = 0;
		$inp_current_sub_category_monounsaturated_fat_med_sum_metric = 0;
		$inp_current_sub_category_polyunsaturated_fat_med_sum_metric = 0;
		$inp_current_sub_category_cholesterol_med_sum_metric = 0;
		$inp_current_sub_category_carb_med_sum_metric = 0;
		$inp_current_sub_category_carb_of_which_sugars_med_sum_metric = 0;
		$inp_current_sub_category_dietary_fiber_med_sum_metric = 0;
		$inp_current_sub_category_proteins_med_sum_metric = 0;
		$inp_current_sub_category_salt_med_sum_metric = 0;
		$inp_current_sub_category_sodium_med_sum_metric = 0;

		$inp_current_sub_category_calories_med_sum_us = 0;
		$inp_current_sub_category_fat_med_sum_us = 0;
		$inp_current_sub_category_saturated_fat_med_sum_us = 0;
		$inp_current_sub_category_monounsaturated_fat_med_sum_us = 0;
		$inp_current_sub_category_polyunsaturated_fat_med_sum_us = 0;
		$inp_current_sub_category_cholesterol_med_sum_us = 0;
		$inp_current_sub_category_carb_med_sum_us = 0;
		$inp_current_sub_category_carb_of_which_sugars_med_sum_us = 0;
		$inp_current_sub_category_dietary_fiber_med_sum_us = 0;
		$inp_current_sub_category_proteins_med_sum_us = 0;
		$inp_current_sub_category_salt_med_sum_us = 0;
		$inp_current_sub_category_sodium_med_sum_us = 0;

		// Ready calculations : max
		$inp_current_sub_category_calories_max_metric = 0;
		$inp_current_sub_category_fat_max_metric = 0;
		$inp_current_sub_category_saturated_fat_max_metric = 0;
		$inp_current_sub_category_monounsaturated_fat_max_metric = 0;
		$inp_current_sub_category_polyunsaturated_fat_max_metric = 0;
		$inp_current_sub_category_cholesterol_max_metric = 0;
		$inp_current_sub_category_carb_max_metric = 0;
		$inp_current_sub_category_carb_of_which_sugars_max_metric = 0;
		$inp_current_sub_category_dietary_fiber_max_metric = 0;
		$inp_current_sub_category_proteins_max_metric = 0;
		$inp_current_sub_category_salt_max_metric = 0;
		$inp_current_sub_category_sodium_max_metric = 0;

		$inp_current_sub_category_calories_max_us = 0;
		$inp_current_sub_category_fat_max_us = 0;
		$inp_current_sub_category_saturated_fat_max_us = 0;
		$inp_current_sub_category_monounsaturated_fat_max_us = 0;
		$inp_current_sub_category_polyunsaturated_fat_max_us = 0;
		$inp_current_sub_category_cholesterol_max_us = 0;
		$inp_current_sub_category_carb_max_us = 0;
		$inp_current_sub_category_carb_of_which_sugars_max_us = 0;
		$inp_current_sub_category_dietary_fiber_max_us = 0;
		$inp_current_sub_category_proteins_max_us = 0;
		$inp_current_sub_category_salt_max_us = 0;
		$inp_current_sub_category_sodium_max_us = 0;



		// Set layout
		$x = 0;
		$show_food = "true";

		// Get food
		$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_country, food_net_content_metric, food_net_content_measurement_metric, food_net_content_us, food_net_content_measurement_us, food_net_content_added_measurement, food_serving_size_metric, food_serving_size_measurement_metric, food_serving_size_us, food_serving_size_measurement_us, food_serving_size_added_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy_metric, food_fat_metric, food_saturated_fat_metric, food_monounsaturated_fat_metric, food_polyunsaturated_fat_metric, food_cholesterol_metric, food_carbohydrates_metric, food_carbohydrates_of_which_sugars_metric, food_dietary_fiber_metric, food_proteins_metric, food_salt_metric, food_sodium_metric, food_energy_us, food_fat_us, food_saturated_fat_us, food_monounsaturated_fat_us, food_polyunsaturated_fat_us, food_cholesterol_us, food_carbohydrates_us, food_carbohydrates_of_which_sugars_us, food_dietary_fiber_us, food_proteins_us, food_salt_us, food_sodium_us, food_score, food_energy_calculated_metric, food_fat_calculated_metric, food_saturated_fat_calculated_metric, food_monounsaturated_fat_calculated_metric, food_polyunsaturated_fat_calculated_metric, food_cholesterol_calculated_metric, food_carbohydrates_calculated_metric, food_carbohydrates_of_which_sugars_calculated_metric, food_dietary_fiber_calculated_metric, food_proteins_calculated_metric, food_salt_calculated_metric, food_sodium_calculated_metric, food_energy_calculated_us, food_fat_calculated_us, food_saturated_fat_calculated_us, food_monounsaturated_fat_calculated_us, food_polyunsaturated_fat_calculated_us, food_cholesterol_calculated_us, food_carbohydrates_calculated_us, food_carbohydrates_of_which_sugars_calculated_us, food_dietary_fiber_calculated_us, food_proteins_calculated_us, food_salt_calculated_us, food_sodium_calculated_us, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_thumb_a_medium, food_thumb_a_large, food_image_b, food_thumb_b_small, food_thumb_b_medium, food_thumb_b_large, food_image_c, food_thumb_c_small, food_thumb_c_medium, food_thumb_c_large, food_image_d, food_thumb_d_small, food_thumb_d_medium, food_thumb_d_large, food_image_e, food_thumb_e_small, food_thumb_e_medium, food_thumb_e_large, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_created_date, food_last_viewed, food_age_restriction FROM $t_food_index WHERE food_sub_category_id=$get_current_sub_category_id AND food_language=$l_mysql";

		// Order
		if($order_by != ""){
			if($order_method == "desc"){
				$order_method_mysql = "DESC";
			}
			else{
				$order_method_mysql = "ASC";
			}

			if($order_by == "food_score" OR $order_by == "food_id" OR $order_by == "food_manufacturer_name_and_food_name" OR $order_by == "food_name" OR $order_by == "food_unique_hits" 
			OR $order_by == "food_energy_metric" OR $order_by == "food_proteins_metric" OR $order_by == "food_carbohydrates_metric" OR $order_by == "food_fat_metric"){
				$order_by_mysql = "$order_by";
			}



			else{
				$order_by_mysql = "food_id";
			}
			$query = $query . " ORDER BY $order_by_mysql $order_method_mysql";
		}


		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_manufacturer_name_and_food_name, $get_food_description, $get_food_country, $get_food_net_content_metric, $get_food_net_content_measurement_metric, $get_food_net_content_us, $get_food_net_content_measurement_us, $get_food_net_content_added_measurement, $get_food_serving_size_metric, $get_food_serving_size_measurement_metric, $get_food_serving_size_us, $get_food_serving_size_measurement_us, $get_food_serving_size_added_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy_metric, $get_food_fat_metric, $get_food_saturated_fat_metric, $get_food_monounsaturated_fat_metric, $get_food_polyunsaturated_fat_metric, $get_food_cholesterol_metric, $get_food_carbohydrates_metric, $get_food_carbohydrates_of_which_sugars_metric, $get_food_dietary_fiber_metric, $get_food_proteins_metric, $get_food_salt_metric, $get_food_sodium_metric, $get_food_energy_us, $get_food_fat_us, $get_food_saturated_fat_us, $get_food_monounsaturated_fat_us, $get_food_polyunsaturated_fat_us, $get_food_cholesterol_us, $get_food_carbohydrates_us, $get_food_carbohydrates_of_which_sugars_us, $get_food_dietary_fiber_us, $get_food_proteins_us, $get_food_salt_us, $get_food_sodium_us, $get_food_score, $get_food_energy_calculated_metric, $get_food_fat_calculated_metric, $get_food_saturated_fat_calculated_metric, $get_food_monounsaturated_fat_calculated_metric, $get_food_polyunsaturated_fat_calculated_metric, $get_food_cholesterol_calculated_metric, $get_food_carbohydrates_calculated_metric, $get_food_carbohydrates_of_which_sugars_calculated_metric, $get_food_dietary_fiber_calculated_metric, $get_food_proteins_calculated_metric, $get_food_salt_calculated_metric, $get_food_sodium_calculated_metric, $get_food_energy_calculated_us, $get_food_fat_calculated_us, $get_food_saturated_fat_calculated_us, $get_food_monounsaturated_fat_calculated_us, $get_food_polyunsaturated_fat_calculated_us, $get_food_cholesterol_calculated_us, $get_food_carbohydrates_calculated_us, $get_food_carbohydrates_of_which_sugars_calculated_us, $get_food_dietary_fiber_calculated_us, $get_food_proteins_calculated_us, $get_food_salt_calculated_us, $get_food_sodium_calculated_us, $get_food_barcode, $get_food_main_category_id, $get_food_sub_category_id, $get_food_image_path, $get_food_image_a, $get_food_thumb_a_small, $get_food_thumb_a_medium, $get_food_thumb_a_large, $get_food_image_b, $get_food_thumb_b_small, $get_food_thumb_b_medium, $get_food_thumb_b_large, $get_food_image_c, $get_food_thumb_c_small, $get_food_thumb_c_medium, $get_food_thumb_c_large, $get_food_image_d, $get_food_thumb_d_small, $get_food_thumb_d_medium, $get_food_thumb_d_large, $get_food_image_e, $get_food_thumb_e_small, $get_food_thumb_e_medium, $get_food_thumb_e_large, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block, $get_food_user_ip, $get_food_created_date, $get_food_last_viewed, $get_food_age_restriction) = $row;
				

			if(file_exists("$root/$get_food_image_path/$get_food_image_a") && $get_food_image_a != "" && $show_food ==  "true"){

				// Store?
				if($store_id != ""){
					$query_store = "SELECT food_store_id FROM $t_food_index_stores WHERE food_store_food_id=$get_food_id AND food_store_store_id=$store_id_mysql";
					$result_store = mysqli_query($link, $query_store);
					$row_store = mysqli_fetch_row($result_store);
					list($get_food_store_id) = $row_store;
					if($get_food_store_id == ""){
						$show_food = "false";
					}
					else{
						$show_food = "true";
					}

				}
			
	
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
				<a href=\"view_food.php?main_category_id=$main_category_id&amp;sub_category_id=$get_sub_category_id&amp;food_id=$get_food_id&amp;l=$l\"><img src=\"$root/$get_food_image_path/$get_food_thumb_a_small\" alt=\"$get_food_image_a\" style=\"margin-bottom: 5px;\" /></a><br />
				<a href=\"view_food.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$get_food_id&amp;l=$l\" style=\"font-weight: bold;color: #444444;\">$title</a><br />
				";
				echo"
				</p>
				";

				if($get_current_view_hundred_metric == "1" OR $get_current_view_pcs_metric == "1" OR $get_current_view_eight_us == "1" OR $get_current_view_pcs_us == "1"){
				
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
				echo"
				</div>
				";
	
				// Increment
				$x++;
		
				// Reset
				if($x == 4){
					$x = 0;
				}

				if($update_statistics == 1){
					// Ready calculations : number of foods
					$inp_total_number_of_foods_in_sub_category = $inp_total_number_of_foods_in_sub_category+1;

					// min
					if($get_food_energy_metric < $inp_current_sub_category_calories_min_metric && $get_food_energy_metric != 0){
						$inp_current_sub_category_calories_min_metric = $get_food_energy_metric;
						$inp_current_sub_category_calories_min_us = $get_food_energy_us;
					}
					if($get_food_fat_metric < $inp_current_sub_category_fat_min_metric && $get_food_fat_metric != 0){
						$inp_current_sub_category_fat_min_metric = $get_food_fat_metric;
						$inp_current_sub_category_fat_min_us = $get_food_fat_us;
					}
					if($get_food_saturated_fat_metric  < $inp_current_sub_category_saturated_fat_min_metric && $get_food_saturated_fat_metric != 0){
						$inp_current_sub_category_saturated_fat_min_metric = $get_food_saturated_fat_metric;
						$inp_current_sub_category_saturated_fat_min_us = $get_food_saturated_fat_us;
					}
					if($get_food_monounsaturated_fat_metric  < $inp_current_sub_category_monounsaturated_fat_min_metric && $get_food_monounsaturated_fat_metric != 0){
						$inp_current_sub_category_monounsaturated_fat_min_metric = $get_food_monounsaturated_fat_metric;
						$inp_current_sub_category_monounsaturated_fat_min_us = $get_food_monounsaturated_fat_us;
					}
					if($get_food_polyunsaturated_fat_metric  < $inp_current_sub_category_polyunsaturated_fat_min_metric && $get_food_polyunsaturated_fat_metric != 0){
						$inp_current_sub_category_polyunsaturated_fat_min_metric = $get_food_polyunsaturated_fat_metric;
						$inp_current_sub_category_polyunsaturated_fat_min_us = $get_food_polyunsaturated_fat_us;
					}
					if($get_food_cholesterol_metric < $inp_current_sub_category_cholesterol_min_metric && $get_food_cholesterol_metric != 0){
						$inp_current_sub_category_cholesterol_min_metric = $get_food_cholesterol_metric;
						$inp_current_sub_category_cholesterol_min_us = $get_food_cholesterol_us;
					}
					if($get_food_carbohydrates_metric < $inp_current_sub_category_carb_min_metric  && $get_food_carbohydrates_metric != 0){
						$inp_current_sub_category_carb_min_metric = $get_food_carbohydrates_metric;
						$inp_current_sub_category_carb_min_us = $get_food_carbohydrates_us;
					}
					if($get_food_carbohydrates_of_which_sugars_metric < $inp_current_sub_category_carb_of_which_sugars_min_metric && $get_food_carbohydrates_of_which_sugars_metric != 0){
						$inp_current_sub_category_carb_of_which_sugars_min_metric = $get_food_carbohydrates_of_which_sugars_metric;
						$inp_current_sub_category_carb_of_which_sugars_min_us = $get_food_carbohydrates_of_which_sugars_us;
					}
					if($get_food_dietary_fiber_metric < $inp_current_sub_category_dietary_fiber_min_metric && $get_food_dietary_fiber_metric != 0){
						$inp_current_sub_category_dietary_fiber_min_metric = $get_food_dietary_fiber_metric;
						$inp_current_sub_category_dietary_fiber_min_us = $get_food_dietary_fiber_us;
					}
					if($get_food_proteins_metric < $inp_current_sub_category_proteins_min_metric && $get_food_proteins_metric != 0){
						$inp_current_sub_category_proteins_min_metric = $get_food_proteins_metric;
						$inp_current_sub_category_proteins_min_us = $get_food_proteins_us;
					}
					if($get_food_salt_metric < $inp_current_sub_category_salt_min_metric && $get_food_salt_metric != 0){
						$inp_current_sub_category_salt_min_metric = $get_food_salt_metric;
						$inp_current_sub_category_salt_min_us = $get_food_salt_us;
					}
					if($get_food_sodium_metric < $inp_current_sub_category_sodium_min_metric && $get_food_sodium_metric != 0){
						$inp_current_sub_category_sodium_min_metric = $get_food_sodium_metric;
						$inp_current_sub_category_sodium_min_us = $get_food_sodium_us;
					}



					// Ready calculations : median
					$inp_current_sub_category_calories_med_sum_metric		= $inp_current_sub_category_calories_med_sum_metric + $get_food_energy_metric;
					$inp_current_sub_category_fat_med_sum_metric 			= $inp_current_sub_category_fat_med_sum_metric + $get_food_fat_metric;
					$inp_current_sub_category_saturated_fat_med_sum_metric		= $inp_current_sub_category_saturated_fat_med_sum_metric + $get_food_saturated_fat_metric;
					$inp_current_sub_category_monounsaturated_fat_med_sum_metric 	= $inp_current_sub_category_monounsaturated_fat_med_sum_metric+ $get_food_monounsaturated_fat_metric;
					$inp_current_sub_category_polyunsaturated_fat_med_sum_metric 	= $inp_current_sub_category_polyunsaturated_fat_med_sum_metric + $get_food_polyunsaturated_fat_metric;
					$inp_current_sub_category_carb_med_sum_metric 			= $inp_current_sub_category_carb_med_sum_metric + $get_food_carbohydrates_metric;
					$inp_current_sub_category_carb_of_which_sugars_med_sum_metric 	= $inp_current_sub_category_carb_of_which_sugars_med_sum_metric + $get_food_carbohydrates_of_which_sugars_metric;
					$inp_current_sub_category_dietary_fiber_med_sum_metric 		= $inp_current_sub_category_dietary_fiber_med_sum_metric + $get_food_dietary_fiber_metric;
					$inp_current_sub_category_proteins_med_sum_metric 		= $inp_current_sub_category_proteins_med_sum_metric + $get_food_proteins_metric;
					$inp_current_sub_category_salt_med_sum_metric 			= $inp_current_sub_category_salt_med_sum_metric + $get_food_salt_metric;
					$inp_current_sub_category_sodium_med_sum_metric 		= $inp_current_sub_category_sodium_med_sum_metric + $get_food_sodium_metric;

					$inp_current_sub_category_calories_med_sum_us			= $inp_current_sub_category_calories_med_sum_us + $get_food_energy_us;
					$inp_current_sub_category_fat_med_sum_us 			= $inp_current_sub_category_fat_med_sum_us + $get_food_fat_us;
					$inp_current_sub_category_saturated_fat_med_sum_us		= $inp_current_sub_category_saturated_fat_med_sum_us + $get_food_saturated_fat_us;
					$inp_current_sub_category_monounsaturated_fat_med_sum_us 	= $inp_current_sub_category_monounsaturated_fat_med_sum_us+ $get_food_monounsaturated_fat_us;
					$inp_current_sub_category_polyunsaturated_fat_med_sum_us 	= $inp_current_sub_category_polyunsaturated_fat_med_sum_us + $get_food_polyunsaturated_fat_us;
					$inp_current_sub_category_carb_med_sum_us 			= $inp_current_sub_category_carb_med_sum_us + $get_food_carbohydrates_us;
					$inp_current_sub_category_carb_of_which_sugars_med_sum_us 	= $inp_current_sub_category_carb_of_which_sugars_med_sum_us + $get_food_carbohydrates_of_which_sugars_us;
					$inp_current_sub_category_dietary_fiber_med_sum_us 		= $inp_current_sub_category_dietary_fiber_med_sum_us + $get_food_dietary_fiber_us;
					$inp_current_sub_category_proteins_med_sum_us 			= $inp_current_sub_category_proteins_med_sum_us + $get_food_proteins_us;
					$inp_current_sub_category_salt_med_sum_us 			= $inp_current_sub_category_salt_med_sum_us + $get_food_salt_us;
					$inp_current_sub_category_sodium_med_sum_us 			= $inp_current_sub_category_sodium_med_sum_us + $get_food_sodium_us;



					// max
					if($get_food_energy_metric > $inp_current_sub_category_calories_max_metric){
						$inp_current_sub_category_calories_max_metric = $get_food_energy_metric;
						$inp_current_sub_category_calories_max_us = $get_food_energy_us;
					}
					if($get_food_fat_metric > $inp_current_sub_category_fat_max_metric){
						$inp_current_sub_category_fat_max_metric = $get_food_fat_metric;
						$inp_current_sub_category_fat_max_us = $get_food_fat_us;
					}
					if($get_food_saturated_fat_metric > $inp_current_sub_category_saturated_fat_max_metric){
						$inp_current_sub_category_saturated_fat_max_metric = $get_food_saturated_fat_metric;
						$inp_current_sub_category_saturated_fat_max_us = $get_food_saturated_fat_us;
					}
					if($get_food_monounsaturated_fat_metric > $inp_current_sub_category_monounsaturated_fat_max_metric){
						$inp_current_sub_category_monounsaturated_fat_max_metric = $get_food_monounsaturated_fat_metric;
						$inp_current_sub_category_monounsaturated_fat_max_us = $get_food_monounsaturated_fat_us;
					}
					if($get_food_polyunsaturated_fat_metric > $inp_current_sub_category_polyunsaturated_fat_max_metric){
						$inp_current_sub_category_polyunsaturated_fat_max_metric = $get_food_polyunsaturated_fat_metric;
						$inp_current_sub_category_polyunsaturated_fat_max_us = $get_food_polyunsaturated_fat_us;
					}
					if($get_food_carbohydrates_metric > $inp_current_sub_category_carb_max_metric){
						$inp_current_sub_category_carb_max_metric = $get_food_carbohydrates_metric;
						$inp_current_sub_category_carb_max_us = $get_food_carbohydrates_us;
					}
					if($get_food_carbohydrates_of_which_sugars_metric > $inp_current_sub_category_carb_of_which_sugars_max_metric){
						$inp_current_sub_category_carb_of_which_sugars_max_metric = $get_food_carbohydrates_of_which_sugars_metric;
						$inp_current_sub_category_carb_of_which_sugars_max_us = $get_food_carbohydrates_of_which_sugars_us;
					}
					if($get_food_dietary_fiber_metric > $inp_current_sub_category_dietary_fiber_max_metric){
						$inp_current_sub_category_dietary_fiber_max_metric = $get_food_dietary_fiber_metric;
						$inp_current_sub_category_dietary_fiber_max_us = $get_food_dietary_fiber_us;
					}
					if($get_food_proteins_metric > $inp_current_sub_category_proteins_max_metric){
						$inp_current_sub_category_proteins_max_metric = $get_food_proteins_metric;
						$inp_current_sub_category_proteins_max_us = $get_food_proteins_us;
					}
					if($get_food_salt_metric > $inp_current_sub_category_salt_max_metric){
						$inp_current_sub_category_salt_max_metric = $get_food_salt_metric;
						$inp_current_sub_category_salt_max_us = $get_food_salt_us;
					}
					if($get_food_sodium_metric > $inp_current_sub_category_sodium_max_metric){
						$inp_current_sub_category_sodium_max_metric = $get_food_sodium_metric;
						$inp_current_sub_category_sodium_max_us = $get_food_sodium_us;
					}

				} // $update_statistics
			} // Image
		}

		if($update_statistics == 1){
			// Calculations : min
			if($inp_current_sub_category_calories_min_metric == 999){
				$inp_current_sub_category_calories_min_metric = 0;
				$inp_current_sub_category_calories_min_us = 0;
			}
			if($inp_current_sub_category_fat_min_metric == 999){
				$inp_current_sub_category_fat_min_metric = 0;
				$inp_current_sub_category_fat_min_us = 0;
			}
			if($inp_current_sub_category_saturated_fat_min_metric == 999){
				$inp_current_sub_category_saturated_fat_min_metric = 0;
				$inp_current_sub_category_saturated_fat_min_us = 0;
			}
			if($inp_current_sub_category_monounsaturated_fat_min_metric == 999){
				$inp_current_sub_category_monounsaturated_fat_min_metric = 0;
				$inp_current_sub_category_monounsaturated_fat_min_us = 0;
			}
			if($inp_current_sub_category_polyunsaturated_fat_min_metric == 999){
				$inp_current_sub_category_polyunsaturated_fat_min_metric = 0;
				$inp_current_sub_category_polyunsaturated_fat_min_us = 0;
			}
		
			if($inp_current_sub_category_cholesterol_min_metric == 999){
				$inp_current_sub_category_cholesterol_min_metric = 0;
				$inp_current_sub_category_cholesterol_min_us = 0;
			}
		
			if($inp_current_sub_category_carb_min_metric == 999){
				$inp_current_sub_category_carb_min_metric = 0;
				$inp_current_sub_category_carb_min_us = 0;
			}
			if($inp_current_sub_category_carb_of_which_sugars_min_metric == 999){
				$inp_current_sub_category_carb_of_which_sugars_min_metric = 0;
				$inp_current_sub_category_carb_of_which_sugars_min_us = 0;
			}
			if($inp_current_sub_category_dietary_fiber_min_metric == 999){
				$inp_current_sub_category_dietary_fiber_min_metric = 0;
				$inp_current_sub_category_dietary_fiber_min_us = 0;
			}
			if($inp_current_sub_category_proteins_min_metric == 999){
				$inp_current_sub_category_proteins_min_metric = 0;
				$inp_current_sub_category_proteins_min_us = 0;
			}
			if($inp_current_sub_category_salt_min_metric == 999){
				$inp_current_sub_category_salt_min_metric = 0;
				$inp_current_sub_category_salt_min_us = 0;
			}
			if($inp_current_sub_category_sodium_min_metric == 999){
				$inp_current_sub_category_sodium_min_metric = 0;
				$inp_current_sub_category_sodium_min_us = 0;
			}
				



			// Calculations : median
			if($inp_total_number_of_foods_in_sub_category != 0){
				$inp_current_sub_category_calories_med_sum_metric = round($inp_current_sub_category_calories_med_sum_metric/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_fat_med_sum_metric = round($inp_current_sub_category_fat_med_sum_metric/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_saturated_fat_med_sum_metric = round($inp_current_sub_category_saturated_fat_med_sum_metric/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_monounsaturated_fat_med_sum_metric = round($inp_current_sub_category_monounsaturated_fat_med_sum_metric/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_polyunsaturated_fat_med_sum_metric = round($inp_current_sub_category_polyunsaturated_fat_med_sum_metric/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_cholesterol_med_sum_metric = round($inp_current_sub_category_cholesterol_med_sum_metric/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_carb_med_sum_metric = round($inp_current_sub_category_carb_med_sum_metric/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_carb_of_which_sugars_med_sum_metric = round($inp_current_sub_category_carb_of_which_sugars_med_sum_metric/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_dietary_fiber_med_sum_metric = round($inp_current_sub_category_dietary_fiber_med_sum_metric/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_proteins_med_sum_metric = round($inp_current_sub_category_proteins_med_sum_metric/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_salt_med_sum_metric = round($inp_current_sub_category_salt_med_sum_metric/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_sodium_med_sum_metric = round($inp_current_sub_category_sodium_med_sum_metric/$inp_total_number_of_foods_in_sub_category, 1);

				$inp_current_sub_category_calories_med_sum_us = round($inp_current_sub_category_calories_med_sum_us/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_fat_med_sum_us = round($inp_current_sub_category_fat_med_sum_us/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_saturated_fat_med_sum_us = round($inp_current_sub_category_saturated_fat_med_sum_us/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_monounsaturated_fat_med_sum_us = round($inp_current_sub_category_monounsaturated_fat_med_sum_us/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_polyunsaturated_fat_med_sum_us = round($inp_current_sub_category_polyunsaturated_fat_med_sum_us/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_cholesterol_med_sum_us = round($inp_current_sub_category_cholesterol_med_sum_us/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_carb_med_sum_us = round($inp_current_sub_category_carb_med_sum_us/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_carb_of_which_sugars_med_sum_us = round($inp_current_sub_category_carb_of_which_sugars_med_sum_us/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_dietary_fiber_med_sum_us = round($inp_current_sub_category_dietary_fiber_med_sum_us/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_proteins_med_sum_us = round($inp_current_sub_category_proteins_med_sum_us/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_salt_med_sum_us = round($inp_current_sub_category_salt_med_sum_us/$inp_total_number_of_foods_in_sub_category, 1);
				$inp_current_sub_category_sodium_med_sum_us = round($inp_current_sub_category_sodium_med_sum_us/$inp_total_number_of_foods_in_sub_category, 1);

			}



			// Update
			$result = mysqli_query($link, "UPDATE $t_food_categories_translations SET 
							category_translation_no_food=$inp_total_number_of_foods_in_sub_category,
							category_stats_last_updated_year=$year,

							category_calories_min_metric=$inp_current_sub_category_calories_min_metric, 
							category_calories_med_metric=$inp_current_sub_category_calories_med_sum_metric, 
							category_calories_max_metric=$inp_current_sub_category_calories_max_metric, 

							category_fat_min_metric=$inp_current_sub_category_fat_min_metric, 
							category_fat_med_metric=$inp_current_sub_category_fat_med_sum_metric, 
							category_fat_max_metric=$inp_current_sub_category_fat_max_metric, 

							category_saturated_fat_min_metric=$inp_current_sub_category_saturated_fat_min_metric, 
							category_saturated_fat_med_metric=$inp_current_sub_category_saturated_fat_med_sum_metric, 
							category_saturated_fat_max_metric=$inp_current_sub_category_saturated_fat_max_metric, 

							category_monounsaturated_fat_min_metric=$inp_current_sub_category_monounsaturated_fat_min_metric, 
							category_monounsaturated_fat_med_metric=$inp_current_sub_category_monounsaturated_fat_med_sum_metric, 
							category_monounsaturated_fat_max_metric=$inp_current_sub_category_monounsaturated_fat_max_metric, 

							category_polyunsaturated_fat_min_metric=$inp_current_sub_category_polyunsaturated_fat_min_metric, 
							category_polyunsaturated_fat_med_metric=$inp_current_sub_category_polyunsaturated_fat_med_sum_metric, 
							category_polyunsaturated_fat_max_metric=$inp_current_sub_category_polyunsaturated_fat_max_metric, 


							category_cholesterol_min_metric=$inp_current_sub_category_cholesterol_min_metric, 
							category_cholesterol_med_metric=$inp_current_sub_category_cholesterol_med_sum_metric, 
							category_cholesterol_max_metric=$inp_current_sub_category_cholesterol_max_metric, 

							category_carb_min_metric=$inp_current_sub_category_carb_min_metric, 
							category_carb_med_metric=$inp_current_sub_category_carb_med_sum_metric, 
							category_carb_max_metric=$inp_current_sub_category_carb_max_metric, 

							category_carb_of_which_sugars_min_metric=$inp_current_sub_category_carb_of_which_sugars_min_metric, 
							category_carb_of_which_sugars_med_metric=$inp_current_sub_category_carb_of_which_sugars_med_sum_metric, 
							category_carb_of_which_sugars_max_metric=$inp_current_sub_category_carb_of_which_sugars_max_metric, 

							category_dietary_fiber_min_metric=$inp_current_sub_category_dietary_fiber_min_metric, 
							category_dietary_fiber_med_metric=$inp_current_sub_category_dietary_fiber_med_sum_metric, 
							category_dietary_fiber_max_metric=$inp_current_sub_category_dietary_fiber_max_metric, 

							category_proteins_min_metric=$inp_current_sub_category_proteins_min_metric, 
							category_proteins_med_metric=$inp_current_sub_category_proteins_med_sum_metric, 
							category_proteins_max_metric=$inp_current_sub_category_proteins_max_metric,

							category_salt_min_metric=$inp_current_sub_category_salt_min_metric, 
							category_salt_med_metric=$inp_current_sub_category_salt_med_sum_metric, 
							category_salt_max_metric=$inp_current_sub_category_salt_max_metric,

							category_sodium_min_metric=$inp_current_sub_category_sodium_min_metric, 
							category_sodium_med_metric=$inp_current_sub_category_sodium_med_sum_metric, 
							category_sodium_max_metric=$inp_current_sub_category_sodium_max_metric,


							category_calories_min_us=$inp_current_sub_category_calories_min_us, 
							category_calories_med_us=$inp_current_sub_category_calories_med_sum_us, 
							category_calories_max_us=$inp_current_sub_category_calories_max_us, 

							category_fat_min_us=$inp_current_sub_category_fat_min_us, 
							category_fat_med_us=$inp_current_sub_category_fat_med_sum_us, 
							category_fat_max_us=$inp_current_sub_category_fat_max_us, 

							category_saturated_fat_min_us=$inp_current_sub_category_saturated_fat_min_us, 
							category_saturated_fat_med_us=$inp_current_sub_category_saturated_fat_med_sum_us, 
							category_saturated_fat_max_us=$inp_current_sub_category_saturated_fat_max_us, 

							category_monounsaturated_fat_min_us=$inp_current_sub_category_monounsaturated_fat_min_us, 
							category_monounsaturated_fat_med_us=$inp_current_sub_category_monounsaturated_fat_med_sum_us, 
							category_monounsaturated_fat_max_us=$inp_current_sub_category_monounsaturated_fat_max_us, 

							category_polyunsaturated_fat_min_us=$inp_current_sub_category_polyunsaturated_fat_min_us, 
							category_polyunsaturated_fat_med_us=$inp_current_sub_category_polyunsaturated_fat_med_sum_us, 
							category_polyunsaturated_fat_max_us=$inp_current_sub_category_polyunsaturated_fat_max_us, 


							category_cholesterol_min_us=$inp_current_sub_category_cholesterol_min_us, 
							category_cholesterol_med_us=$inp_current_sub_category_cholesterol_med_sum_us, 
							category_cholesterol_max_us=$inp_current_sub_category_cholesterol_max_us, 

							category_carb_min_us=$inp_current_sub_category_carb_min_us, 
							category_carb_med_us=$inp_current_sub_category_carb_med_sum_us, 
							category_carb_max_us=$inp_current_sub_category_carb_max_us, 

							category_carb_of_which_sugars_min_us=$inp_current_sub_category_carb_of_which_sugars_min_us, 
							category_carb_of_which_sugars_med_us=$inp_current_sub_category_carb_of_which_sugars_med_sum_us, 
							category_carb_of_which_sugars_max_us=$inp_current_sub_category_carb_of_which_sugars_max_us, 

							category_dietary_fiber_min_us=$inp_current_sub_category_dietary_fiber_min_us, 
							category_dietary_fiber_med_us=$inp_current_sub_category_dietary_fiber_med_sum_us, 
							category_dietary_fiber_max_us=$inp_current_sub_category_dietary_fiber_max_us, 

							category_proteins_min_us=$inp_current_sub_category_proteins_min_us, 
							category_proteins_med_us=$inp_current_sub_category_proteins_med_sum_us, 
							category_proteins_max_us=$inp_current_sub_category_proteins_max_us,

							category_salt_min_us=$inp_current_sub_category_salt_min_us, 
							category_salt_med_us=$inp_current_sub_category_salt_med_sum_us, 
							category_salt_max_us=$inp_current_sub_category_salt_max_us,

							category_sodium_min_us=$inp_current_sub_category_sodium_min_us, 
							category_sodium_med_us=$inp_current_sub_category_sodium_med_sum_us, 
							category_sodium_max_us=$inp_current_sub_category_sodium_max_us

							WHERE category_id=$get_current_sub_category_id AND category_translation_language=$l_mysql") or print(mysqli_error());
		} // $update_statistics
	echo"
	<!-- //Food in category -->

	<!-- Stats -->
		<div class=\"clear\"></div>
		<hr />
		<a id=\"statistics\"></a>
		<h2>$l_statistics</h2>

		<p style=\"padding-top:0;margin-top:0;\">$l_number_of_foods: $get_current_sub_category_translation_no_food</p>

		<table class=\"hor-zebra\" style=\"width: auto;min-width: 0;display: table;\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
		   </th>
		   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;vertical-align: bottom;\">
			<span>$l_min</span>
		   </th>
		   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;\">
			<span>$l_med</span>
		   </th>
		   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;\">
			<span>$l_max</span>
		   </th>
		  </tr>
		 </thead>
		 <tbody>
		  <tr>
		   <td style=\"padding: 8px 4px 6px 8px;\">
			<span>$l_cal</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"$get_current_sub_category_calories_min_metric";
			}
			else{
				echo"$get_current_sub_category_calories_min_us";
			}
			echo"</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"$get_current_sub_category_calories_med_metric";
			}
			else{
				echo"$get_current_sub_category_calories_med_us";
			}
			echo"</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"$get_current_sub_category_calories_max_metric";
			}
			else{
				echo"$get_current_sub_category_calories_max_us";
			}
			echo"</span>
		   </td>
		  </tr>
		  <tr>
		   <td style=\"padding: 8px 4px 6px 8px;\">
			<span>$l_fat<br />
			$l_dash_saturated_fat<br />
			$l_dash_monounsaturated_fat<br />
			$l_dash_polyunsaturated_fat<br />
			</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"
				$get_current_sub_category_fat_min_metric<br />
				$get_current_sub_category_saturated_fat_min_metric<br />
				$get_current_sub_category_monounsaturated_fat_min_metric<br />
				$get_current_sub_category_polyunsaturated_fat_min_metric<br />
				";
			}
			else{
				echo"
				$get_current_sub_category_fat_min_us<br />
				$get_current_sub_category_saturated_fat_min_us<br />
				$get_current_sub_category_monounsaturated_fat_min_us<br />
				$get_current_sub_category_polyunsaturated_fat_min_us<br />
				";
			}
			echo"</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"
				$get_current_sub_category_fat_med_metric<br />
				$get_current_sub_category_saturated_fat_med_metric<br />
				$get_current_sub_category_monounsaturated_fat_med_metric<br />
				$get_current_sub_category_polyunsaturated_fat_med_metric<br />
				";
			}
			else{
				echo"
				$get_current_sub_category_fat_med_us<br />
				$get_current_sub_category_saturated_fat_med_us<br />
				$get_current_sub_category_monounsaturated_fat_med_us<br />
				$get_current_sub_category_polyunsaturated_fat_med_us<br />
				";
			}
			echo"</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"
				$get_current_sub_category_fat_max_metric<br />
				$get_current_sub_category_saturated_fat_max_metric<br />
				$get_current_sub_category_monounsaturated_fat_max_metric<br />
				$get_current_sub_category_polyunsaturated_fat_max_metric<br />
				";
			}
			else{
				echo"
				$get_current_sub_category_fat_max_us<br />
				$get_current_sub_category_saturated_fat_max_us<br />
				$get_current_sub_category_monounsaturated_fat_max_us<br />
				$get_current_sub_category_polyunsaturated_fat_max_us<br />
				";
			}
			echo"</span>
		   </td>
		  </tr>
		  <tr>
		   <td style=\"padding: 8px 4px 6px 8px;\">
			<span>$l_carbs<br />
			$l_dash_of_which_sugars_calculated</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"
				$get_current_sub_category_carb_min_metric<br />
				$get_current_sub_category_carb_of_which_sugars_min_metric
				";
			}
			else{
				echo"
				$get_current_sub_category_carb_min_us<br />
				$get_current_sub_category_carb_of_which_sugars_min_us
				";
			}
			echo"</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"
				$get_current_sub_category_carb_med_metric<br />
				$get_current_sub_category_carb_of_which_sugars_med_metric
				";
			}
			else{
				echo"
				$get_current_sub_category_carb_med_us<br />
				$get_current_sub_category_carb_of_which_sugars_med_us
				";
			}
			echo"</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"
				$get_current_sub_category_carb_max_metric<br />
				$get_current_sub_category_carb_of_which_sugars_max_metric
				";
			}
			else{
				echo"
				$get_current_sub_category_carb_max_us<br />
				$get_current_sub_category_carb_of_which_sugars_max_us
				";
			}
			echo"</span>
		   </td>
		 </tr>
		  <tr>
		   <td style=\"padding: 8px 4px 6px 8px;\">
			<span>$l_dietary_fiber</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"$get_current_sub_category_dietary_fiber_min_metric";
			}
			else{
				echo"$get_current_sub_category_dietary_fiber_min_us";
			}
			echo"</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"$get_current_sub_category_dietary_fiber_med_metric";
			}
			else{
				echo"$get_current_sub_category_dietary_fiber_med_us";
			}
			echo"</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"$get_current_sub_category_dietary_fiber_max_metric";
			}
			else{
				echo"$get_current_sub_category_dietary_fiber_max_us";
			}
			echo"</span>
		   </td>
		  </tr>
		  <tr>
		   <td style=\"padding: 8px 4px 6px 8px;\">
			<span>$l_proteins</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"$get_current_sub_category_proteins_min_metric";
			}
			else{
				echo"$get_current_sub_category_proteins_min_us";
			}
			echo"</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"$get_current_sub_category_proteins_med_metric";
			}
			else{
				echo"$get_current_sub_category_proteins_med_us";
			}
			echo"</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"$get_current_sub_category_proteins_max_metric";
			}
			else{
				echo"$get_current_sub_category_proteins_max_us";
			}
			echo"</span>
		   </td>
		  </tr>

		  <tr>
		   <td style=\"padding: 8px 4px 6px 8px;\">
			<span>$l_salt</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"$get_current_sub_category_salt_min_metric";
			}
			else{
				echo"$get_current_sub_category_salt_min_us";
			}
			echo"</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"$get_current_sub_category_salt_med_metric";
			}
			else{
				echo"$get_current_sub_category_salt_med_us";
			}
			echo"</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"$get_current_sub_category_salt_max_metric";
			}
			else{
				echo"$get_current_sub_category_salt_max_us";
			}
			echo"</span>
		    </td>
		   </tr>
		  </tr>

		  <tr>
		   <td style=\"padding: 8px 4px 6px 8px;\">
			<span>$l_sodium</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"$get_current_sub_category_sodium_min_metric";
			}
			else{
				echo"$get_current_sub_category_sodium_min_us";
			}
			echo"</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"$get_current_sub_category_sodium_med_metric";
			}
			else{
				echo"$get_current_sub_category_sodium_med_us";
			}
			echo"</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"$get_current_sub_category_sodium_max_metric";
			}
			else{
				echo"$get_current_sub_category_sodium_max_us";
			}
			echo"</span>
		    </td>
		   </tr>
		  </tr>

		  <tr>
		   <td style=\"padding: 8px 4px 6px 8px;\">
			<span>$l_cholesterol</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"$get_current_sub_category_cholesterol_min_metric";
			}
			else{
				echo"$get_current_sub_category_cholesterol_min_us";
			}
			echo"</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"$get_current_sub_category_cholesterol_med_metric";
			}
			else{
				echo"$get_current_sub_category_cholesterol_med_us";
			}
			echo"</span>
		   </td>
		   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
			<span>";
			if($system == "metric"){
				echo"$get_current_sub_category_cholesterol_max_metric";
			}
			else{
				echo"$get_current_sub_category_cholesterol_max_us";
			}
			echo"</span>
		    </td>
		   </tr>
		  </tr>

		 </tbody>
		</table>
		
		<p><a href=\"open_sub_category.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;l=$l&amp;update_statistics=1\" class=\"smal\">$l_update_statistics</a></p>
	<!-- //Stats -->
	";

}


/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>