<?php
/**
*
* File: food_diary/food_diary_add_food.php
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

/*- Tables --------------------------------------------------------------------------- */
include("_tables.php");

/*- Variables ------------------------------------------------------------------------- */
$l_mysql = quote_smart($link, $l);


if(isset($_GET['action'])) {
	$action = $_GET['action'];
	$action = strip_tags(stripslashes($action));
}
else{
	$action = "";
}
if(isset($_GET['date'])) {
	$date = $_GET['date'];
	$date = strip_tags(stripslashes($date));
}
else{
	$date = "";
}
if(isset($_GET['hour_name'])) {
	$hour_name = $_GET['hour_name'];
	$hour_name = stripslashes(strip_tags($hour_name));
	if($hour_name != "breakfast" && $hour_name != "lunch" && $hour_name != "before_training" && $hour_name != "after_training" && $hour_name != "dinner" && $hour_name != "snacks" && $hour_name != "supper"){
		echo"Unknown hour name";
		die;
	}
}
else{
	echo"Missing hour name";
	die;
}

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
if(isset($_GET['inp_entry_food_query'])){
	$inp_entry_food_query = $_GET['inp_entry_food_query'];
	$inp_entry_food_query = strip_tags(stripslashes($inp_entry_food_query));
	$inp_entry_food_query = output_html($inp_entry_food_query);
} else{
	$inp_entry_food_query = "";
}
	

/*- Translation ------------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/food_diary/ts_food_diary.php");


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_food_diary - $l_new_entry";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");


/*- Content ---------------------------------------------------------------------------------- */
// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){

	// Get my profile
	$my_user_id = $_SESSION['user_id'];
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	$query = "SELECT user_id, user_alias, user_email, user_gender, user_height, user_measurement, user_dob FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_alias, $get_my_user_email, $get_my_user_gender, $get_my_user_height, $get_user_measurement, $get_my_user_dob) = $row;
	
	if($action == ""){

		echo"
		<h1>$l_new_entry</h1>

	
		<!-- Feedback -->
		";
		if($ft != "" && $fm != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			else{
				$fm = ucfirst($fm);
			}
			echo"<div class=\"$ft\"><p>$fm</p></div>";
		}
		echo"
		<!-- //Feedback -->


		<!-- You are here -->
			<p><b>$l_you_are_here</b><br />
			<a href=\"index.php?l=$l\">$l_food_diary</a>
			&gt;
			<a href=\"food_diary_add_food.php?date=$date&amp;hour_name=$hour_name&amp;l=$l\">$l_new_entry</a>
			</p>
		<!-- //You are here -->


		<!-- Search -->	
			<!-- Search engines Autocomplete -->
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_entry_food_query\"]').focus();
				});
				\$(document).ready(function () {
					\$('#inp_entry_food_query').keyup(function () {
        					// getting the value that user typed
        					var searchString    = $(\"#inp_entry_food_query\").val();
        					// forming the queryString
       						var data            = 'l=$l&date=$date&hour_name=$hour_name&q='+ searchString;
         
        					// if searchString is not empty
        					if(searchString) {
        						// ajax call
          						\$.ajax({
                						type: \"POST\",
               							url: \"food_diary_add_food_query.php\",
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
			<!-- //Search engines Autocomplete -->

			<!-- Food Search -->
				<form method=\"get\" action=\"food_diary_add_food.php\" enctype=\"multipart/form-data\" id=\"inp_entry_food_query_form\">
					<p style=\"padding-top: 0;\"><b>$l_food_search</b><br />
					<input type=\"text\" id=\"inp_entry_food_query\" name=\"inp_entry_food_query\" value=\"";if(isset($_GET['inp_entry_food_query'])){ echo"$inp_entry_food_query"; } echo"\" size=\"12\" />
					<input type=\"hidden\" name=\"action\" value=\"search\" />
					<input type=\"hidden\" name=\"date\" value=\"$date\" />
					<input type=\"hidden\" name=\"hour_name\" value=\"$hour_name\" />
					<input type=\"submit\" value=\"$l_search\" class=\"btn btn_default\" />
					<a href=\"$root/food/new_food.php?l=$l\" class=\"btn btn_default\">$l_new_food</a>
					</p>
				</form>
			<!-- //Food Search -->
		<!-- //Search -->


	
		<div class=\"tabs\" style=\"margin-top: 10px;\">
			<ul>
				<li><a href=\"food_diary_add.php?date=$date&amp;hour_name=$hour_name&amp;l=$l\" class=\"selected\">$l_recent</a></li>
				<li><a href=\"food_diary_add_food.php?date=$date&amp;hour_name=$hour_name&amp;l=$l\">$l_food</a></li>
				<li><a href=\"food_diary_add_recipe.php?date=$date&amp;hour_name=$hour_name&amp;l=$l\">$l_recipes</a></li>
			</ul>
		</div>
		<div class=\"clear\" style=\"height: 20px;\"></div>
	
		<!-- Adapter view -->";
			
			$query_t = "SELECT view_id, view_user_id, view_system, view_hundred_metric, view_pcs_metric, view_eight_us, view_pcs_us FROM $t_food_diary_user_adapted_view WHERE view_user_id=$get_my_user_id";
			$result_t = mysqli_query($link, $query_t);
			$row_t = mysqli_fetch_row($result_t);
			list($get_current_view_id, $get_current_view_user_id, $get_current_view_system, $get_current_view_hundred_metric, $get_current_view_pcs_metric, $get_current_view_eight_us, $get_current_view_pcs_us) = $row_t;
			echo"
			<p><a id=\"adapter_view\"></a>
			<b>$l_show_per:</b>
			<input type=\"checkbox\" name=\"inp_show_hundred_metric\" class=\"onclick_go_to_url\" data-target=\"user_adapted_view.php?set=hundred_metric&amp;process=1&amp;referer=food_diary_add&amp;date=$date&amp;hour_name=$hour_name&amp;l=$l\""; if($get_current_view_hundred_metric == "1"){ echo" checked=\"checked\""; } echo" /> $l_hundred
			<input type=\"checkbox\" name=\"inp_show_pcs_metric\" class=\"onclick_go_to_url\" data-target=\"user_adapted_view.php?set=pcs_metric&amp;process=1&amp;referer=food_diary_add&amp;date=$date&amp;hour_name=$hour_name&amp;l=$l\""; if($get_current_view_pcs_metric == "1"){ echo" checked=\"checked\""; } echo" /> $l_pcs_g
			<input type=\"checkbox\" name=\"inp_show_metric_us_and_or_pcs\" class=\"onclick_go_to_url\" data-target=\"user_adapted_view.php?set=eight_us&amp;process=1&amp;referer=food_diary_add&amp;date=$date&amp;hour_name=$hour_name&amp;l=$l\""; if($get_current_view_eight_us == "1"){ echo" checked=\"checked\""; } echo" /> $l_eight
			<input type=\"checkbox\" name=\"inp_show_metric_us_and_or_pcs\" class=\"onclick_go_to_url\" data-target=\"user_adapted_view.php?set=pcs_us&amp;process=1&amp;referer=food_diary_add&amp;date=$date&amp;hour_name=$hour_name&amp;l=$l\""; if($get_current_view_pcs_us == "1"){ echo" checked=\"checked\""; } echo" /> $l_pcs_oz
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
		<!-- //Adapter view -->


		<!-- Recent food/recipe list -->

			<!-- Select list go to URL -->
				<script>
				\$(document).ready(function(){
					\$(\"select\").bind('change',function(){
						window.location = \$(':selected',this).attr('href'); // redirect
					})
				});
				</script>
			<!-- //Select list go to URL -->

			<div id=\"nettport_search_results\">
				";
				// Set layout
				$x = 0;


				// Last used food
				$hour_name_mysql = quote_smart($link, $hour_name);
				$query = "SELECT last_used_id, last_used_user_id, last_used_hour_name, last_used_food_id, last_used_times, last_used_datetime, last_used_name, last_used_manufacturer, last_used_image_path, last_used_image_thumb_132x132, last_used_food_main_category_id, last_used_food_sub_category_id, last_used_metric_or_us, last_used_selected_serving_size, last_used_selected_measurement, last_used_serving_size_metric, last_used_serving_size_measurement_metric, last_used_serving_size_us, last_used_serving_size_measurement_us, last_used_serving_size_pcs, last_used_serving_size_pcs_measurement, last_used_energy_metric, last_used_fat_metric, last_used_saturated_fat_metric, last_used_monounsaturated_fat_metric, last_used_polyunsaturated_fat_metric, last_used_cholesterol_metric, last_used_carbohydrates_metric, last_used_carbohydrates_of_which_sugars_metric, last_used_dietary_fiber_metric, last_used_proteins_metric, last_used_salt_metric, last_used_sodium_metric, last_used_energy_us, last_used_fat_us, last_used_saturated_fat_us, last_used_monounsaturated_fat_us, last_used_polyunsaturated_fat_us, last_used_cholesterol_us, last_used_carbohydrates_us, last_used_carbohydrates_of_which_sugars_us, last_used_dietary_fiber_us, last_used_proteins_us, last_used_salt_us, last_used_sodium_us, last_used_energy_serving, last_used_fat_serving, last_used_saturated_fat_serving, last_used_monounsaturated_fat_serving, last_used_polyunsaturated_fat_serving, last_used_cholesterol_serving, last_used_carbohydrates_serving, last_used_carbohydrates_of_which_sugars_serving, last_used_dietary_fiber_serving, last_used_proteins_serving, last_used_salt_serving, last_used_sodium_serving FROM $t_food_diary_last_used_food WHERE last_used_user_id='$get_my_user_id' AND last_used_hour_name=$hour_name_mysql ORDER BY last_used_times DESC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_last_used_id, $get_last_used_user_id, $get_last_used_hour_name, $get_last_used_food_id, $get_last_used_times, $get_last_used_datetime, $get_last_used_name, $get_last_used_manufacturer, $get_last_used_image_path, $get_last_used_image_thumb_132x132, $get_last_used_food_main_category_id, $get_last_used_food_sub_category_id, $get_last_used_metric_or_us, $get_last_used_selected_serving_size, $get_last_used_selected_measurement, $get_last_used_serving_size_metric, $get_last_used_serving_size_measurement_metric, $get_last_used_serving_size_us, $get_last_used_serving_size_measurement_us, $get_last_used_serving_size_pcs, $get_last_used_serving_size_pcs_measurement, $get_last_used_energy_metric, $get_last_used_fat_metric, $get_last_used_saturated_fat_metric, $get_last_used_monounsaturated_fat_metric, $get_last_used_polyunsaturated_fat_metric, $get_last_used_cholesterol_metric, $get_last_used_carbohydrates_metric, $get_last_used_carbohydrates_of_which_sugars_metric, $get_last_used_dietary_fiber_metric, $get_last_used_proteins_metric, $get_last_used_salt_metric, $get_last_used_sodium_metric, $get_last_used_energy_us, $get_last_used_fat_us, $get_last_used_saturated_fat_us, $get_last_used_monounsaturated_fat_us, $get_last_used_polyunsaturated_fat_us, $get_last_used_cholesterol_us, $get_last_used_carbohydrates_us, $get_last_used_carbohydrates_of_which_sugars_us, $get_last_used_dietary_fiber_us, $get_last_used_proteins_us, $get_last_used_salt_us, $get_last_used_sodium_us, $get_last_used_energy_serving, $get_last_used_fat_serving, $get_last_used_saturated_fat_serving, $get_last_used_monounsaturated_fat_serving, $get_last_used_polyunsaturated_fat_serving, $get_last_used_cholesterol_serving, $get_last_used_carbohydrates_serving, $get_last_used_carbohydrates_of_which_sugars_serving, $get_last_used_dietary_fiber_serving, $get_last_used_proteins_serving, $get_last_used_salt_serving, $get_last_used_sodium_serving) = $row;

					// Get food
					$query_f = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_country, food_net_content_metric, food_net_content_measurement_metric, food_net_content_us, food_net_content_measurement_us, food_net_content_added_measurement, food_serving_size_metric, food_serving_size_measurement_metric, food_serving_size_us, food_serving_size_measurement_us, food_serving_size_added_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy_metric, food_fat_metric, food_saturated_fat_metric, food_monounsaturated_fat_metric, food_polyunsaturated_fat_metric, food_cholesterol_metric, food_carbohydrates_metric, food_carbohydrates_of_which_sugars_metric, food_dietary_fiber_metric, food_proteins_metric, food_salt_metric, food_sodium_metric, food_energy_us, food_fat_us, food_saturated_fat_us, food_monounsaturated_fat_us, food_polyunsaturated_fat_us, food_cholesterol_us, food_carbohydrates_us, food_carbohydrates_of_which_sugars_us, food_dietary_fiber_us, food_proteins_us, food_salt_us, food_sodium_us, food_score, food_energy_calculated_metric, food_fat_calculated_metric, food_saturated_fat_calculated_metric, food_monounsaturated_fat_calculated_metric, food_polyunsaturated_fat_calculated_metric, food_cholesterol_calculated_metric, food_carbohydrates_calculated_metric, food_carbohydrates_of_which_sugars_calculated_metric, food_dietary_fiber_calculated_metric, food_proteins_calculated_metric, food_salt_calculated_metric, food_sodium_calculated_metric, food_energy_calculated_us, food_fat_calculated_us, food_saturated_fat_calculated_us, food_monounsaturated_fat_calculated_us, food_polyunsaturated_fat_calculated_us, food_cholesterol_calculated_us, food_carbohydrates_calculated_us, food_carbohydrates_of_which_sugars_calculated_us, food_dietary_fiber_calculated_us, food_proteins_calculated_us, food_salt_calculated_us, food_sodium_calculated_us, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_thumb_a_medium, food_thumb_a_large, food_image_b, food_thumb_b_small, food_thumb_b_medium, food_thumb_b_large, food_image_c, food_thumb_c_small, food_thumb_c_medium, food_thumb_c_large, food_image_d, food_thumb_d_small, food_thumb_d_medium, food_thumb_d_large, food_image_e, food_thumb_e_small, food_thumb_e_medium, food_thumb_e_large, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_created_date, food_last_viewed, food_age_restriction FROM $t_food_index WHERE food_id=$get_last_used_food_id";
					$result_f = mysqli_query($link, $query_f);
					$row_f = mysqli_fetch_row($result_f);
					list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_manufacturer_name_and_food_name, $get_food_description, $get_food_country, $get_food_net_content_metric, $get_food_net_content_measurement_metric, $get_food_net_content_us, $get_food_net_content_measurement_us, $get_food_net_content_added_measurement, $get_food_serving_size_metric, $get_food_serving_size_measurement_metric, $get_food_serving_size_us, $get_food_serving_size_measurement_us, $get_food_serving_size_added_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy_metric, $get_food_fat_metric, $get_food_saturated_fat_metric, $get_food_monounsaturated_fat_metric, $get_food_polyunsaturated_fat_metric, $get_food_cholesterol_metric, $get_food_carbohydrates_metric, $get_food_carbohydrates_of_which_sugars_metric, $get_food_dietary_fiber_metric, $get_food_proteins_metric, $get_food_salt_metric, $get_food_sodium_metric, $get_food_energy_us, $get_food_fat_us, $get_food_saturated_fat_us, $get_food_monounsaturated_fat_us, $get_food_polyunsaturated_fat_us, $get_food_cholesterol_us, $get_food_carbohydrates_us, $get_food_carbohydrates_of_which_sugars_us, $get_food_dietary_fiber_us, $get_food_proteins_us, $get_food_salt_us, $get_food_sodium_us, $get_food_score, $get_food_energy_calculated_metric, $get_food_fat_calculated_metric, $get_food_saturated_fat_calculated_metric, $get_food_monounsaturated_fat_calculated_metric, $get_food_polyunsaturated_fat_calculated_metric, $get_food_cholesterol_calculated_metric, $get_food_carbohydrates_calculated_metric, $get_food_carbohydrates_of_which_sugars_calculated_metric, $get_food_dietary_fiber_calculated_metric, $get_food_proteins_calculated_metric, $get_food_salt_calculated_metric, $get_food_sodium_calculated_metric, $get_food_energy_calculated_us, $get_food_fat_calculated_us, $get_food_saturated_fat_calculated_us, $get_food_monounsaturated_fat_calculated_us, $get_food_polyunsaturated_fat_calculated_us, $get_food_cholesterol_calculated_us, $get_food_carbohydrates_calculated_us, $get_food_carbohydrates_of_which_sugars_calculated_us, $get_food_dietary_fiber_calculated_us, $get_food_proteins_calculated_us, $get_food_salt_calculated_us, $get_food_sodium_calculated_us, $get_food_barcode, $get_food_main_category_id, $get_food_sub_category_id, $get_food_image_path, $get_food_image_a, $get_food_thumb_a_small, $get_food_thumb_a_medium, $get_food_thumb_a_large, $get_food_image_b, $get_food_thumb_b_small, $get_food_thumb_b_medium, $get_food_thumb_b_large, $get_food_image_c, $get_food_thumb_c_small, $get_food_thumb_c_medium, $get_food_thumb_c_large, $get_food_image_d, $get_food_thumb_d_small, $get_food_thumb_d_medium, $get_food_thumb_d_large, $get_food_image_e, $get_food_thumb_e_small, $get_food_thumb_e_medium, $get_food_thumb_e_large, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block, $get_food_user_ip, $get_food_created_date, $get_food_last_viewed, $get_food_age_restriction) = $row_f;

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

					// Thumb
					if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a")){
						$thumb = "../$get_food_image_path/$get_food_thumb_a_small";
					}
					else{
						$thumb = "_gfx/no_thumb.png";
					}


					echo"
					<p style=\"padding-bottom:5px;\">
					<a href=\"$root/food/view_food.php?main_category_id=$get_food_main_category_id&amp;sub_category_id=$get_food_sub_category_id&amp;food_id=$get_food_id&amp;l=$l\"><img src=\"$thumb\" alt=\"$get_food_image_a\" style=\"margin-bottom: 5px;\" /></a><br />
					<a href=\"$root/food/view_food.php?main_category_id=$get_food_main_category_id&amp;sub_category_id=$get_food_sub_category_id&amp;food_id=$get_food_id&amp;l=$l\" style=\"font-weight: bold;color: #444444;\">$title</a><br />
					</p>";

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
						} // get_current_view_hundred_metric
						echo"
						<!-- Add food -->
							<form method=\"post\" action=\"food_diary_add_food.php?action=add_food_to_diary&amp;date=$date&amp;hour_name=$hour_name&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
							<p>
							<input type=\"hidden\" name=\"inp_entry_food_id\" value=\"$get_food_id\" />
							";
							if($get_current_view_hundred_metric == "1" OR $get_current_view_pcs_metric == "1"){
								if($get_food_serving_size_pcs_measurement == "g"){
									echo"
									<input type=\"text\" name=\"inp_entry_food_serving_size\" size=\"2\" value=\"$get_last_used_selected_serving_size\" />
									<input type=\"submit\" name=\"inp_submit_metric\" value=\"$get_food_serving_size_measurement_metric\" class=\"btn btn_default\" />
									";
								}
								else{
									echo"
									<input type=\"text\" name=\"inp_entry_food_serving_size\" size=\"2\" value=\"$get_last_used_selected_serving_size\" />
									<input type=\"submit\" name=\"inp_submit_metric\" value=\"$get_food_serving_size_measurement_metric\" class=\"btn btn_default\" />
									<input type=\"submit\" name=\"inp_submit_pcs\" value=\"$get_food_serving_size_pcs_measurement\" class=\"btn btn_default\" />
									";
								}
							} // metric
							if($get_current_view_eight_us == "1" OR $get_current_view_pcs_us == "1"){
								echo"
								<input type=\"text\" name=\"inp_entry_food_serving_size\" size=\"2\" value=\"$get_last_used_selected_serving_size\" />
								<input type=\"submit\" name=\"inp_submit_us\" value=\"$get_food_serving_size_measurement_metric\" class=\"btn btn_default\" />
								<input type=\"submit\" name=\"inp_submit_pcs\" value=\"$get_food_serving_size_pcs_measurement\" class=\"btn btn_default\" />
								";
							} // us
							echo"
							</p>
							</form>
						<!-- //Add food -->
					</div>
					";
					// Increment
					$x++;
		
					// Reset
					if($x == 4){
						$x = 0;
					}
				} // while recent food
				if($x == "2"){
					echo"
						<div class=\"left_center_center_right_right_center\" style=\"text-align: center;padding-bottom: 20px;\">
						</div>
						<div class=\"left_center_center_right_right\" style=\"text-align: center;padding-bottom: 20px;\">
						</div>
					";
				}

			echo"
			</div> <!-- //nettport_search_results -->
			<div class=\"clear\"></div>
		
			";
			if($x == "0"){
				// No food
				echo"
				<p>$l_on_this_page_you_will_see_food_you_have_added_before</p>

				<p>
				$l_the_page_is_smart_so_it_will_remember_what_you_usually_have_for_your ";
				if($meal_id == "0"){
					echo"$l_breakfast_lowercase";
				}
				elseif($meal_id == "1"){
					echo"$l_lunch_lowercase";
				}
				elseif($meal_id == "2"){
					echo"$l_before_training_lowercase";
				}
				elseif($meal_id == "3"){
					echo"$l_after_training_lowercase";
				}
				elseif($meal_id == "4"){
					echo"$l_dinner_lowercase";
				}
				elseif($meal_id == "5"){
					echo"$l_snacks_lowercase";
				}
				else{
					echo"$l_supper";
				}
				echo"
				$l_on_lowercase
				";
				$dow = date("N",strtotime($date));
				
				if($dow == "1"){
					echo"$l_mondays_lowercase";
				}
				elseif($dow == "2"){
					echo"$l_tuesdays_lowercase";
				}
				elseif($dow == "3"){
					echo"$l_wednesdays_lowercase";
				}
				elseif($dow == "4"){
					echo"$l_thursdays_lowercase";
				}
				elseif($dow == "5"){
					echo"$l_fridays_lowercase";
				}
				elseif($dow == "6"){
					echo"$l_saturdays_lowercase";
				}
				else{
					echo"$l_sundays_lowercase";
				}
				echo".
				</p>

				<p>$l_the_more_you_use_the_food_diary_the_smarter_it_gets </p>
				";
			}
			echo"
		<!-- //Recent Food list -->
		";
	} // action == ""
}
else{
	echo"
	<h1>
	<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login?l=$l&amp;referer=$root/food_diary/index.php\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>