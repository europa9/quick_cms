<?php 
/**
*
* File: food/new_food_4_general_information.php
* Version 1.0.0
* Date 10:20 17.10.2020
* Copyright (c) 2011-2020 Localhost
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
if(isset($_GET['sub_category_id'])){
	$sub_category_id= $_GET['sub_category_id'];
	$sub_category_id = strip_tags(stripslashes($sub_category_id));
}
else{
	$sub_category_id = "";
}


$tabindex = 0;
$l_mysql = quote_smart($link, $l);


/*- Sub category -------------------------------------------------------------------------- */
// Select sub category
$sub_category_id_mysql = quote_smart($link, $sub_category_id);
$query = "SELECT category_id, category_user_id, category_name, category_parent_id FROM $t_food_categories WHERE category_id=$sub_category_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_sub_category_id, $get_current_sub_category_user_id, $get_current_sub_category_name, $get_current_sub_category_parent_id) = $row;

if($get_current_sub_category_id== ""){
	$website_title = "$l_food - Server error 404";
}
else{
	// Sub category Translation
	$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_current_sub_category_id AND category_translation_language=$l_mysql";
	$result_t = mysqli_query($link, $query_t);
	$row_t = mysqli_fetch_row($result_t);
	list($get_current_sub_category_translation_value) = $row_t;
	

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
	$website_title = "$l_food - $l_new_food - $get_current_main_category_translation_value - $get_current_sub_category_translation_value";

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
	


	if($get_current_sub_category_id == ""){
		echo"
		<h1>Server error 404</h1>
		<p>Sub category not found.</p>

		<p><a href=\"index.php?l=$l\">Categories</a></p>
		";
	}
	else{
		if($process == "1"){
			$inp_food_name = $_POST['inp_food_name'];
			$inp_food_name = output_html($inp_food_name);
			$inp_food_name_mysql = quote_smart($link, $inp_food_name);
			if(empty($inp_food_name)){
				$ft = "error";
				$fm = "missing_name";
			}

			// Clean name
			$inp_food_clean_name = clean($inp_food_name);
			$inp_food_clean_name_mysql = quote_smart($link, $inp_food_clean_name);

			$inp_food_manufacturer_name = $_POST['inp_food_manufacturer_name'];
			$inp_food_manufacturer_name = output_html($inp_food_manufacturer_name);
			$inp_food_manufacturer_name_mysql = quote_smart($link, $inp_food_manufacturer_name);

			$inp_food_manufacturer_name_and_food_name = "$inp_food_manufacturer_name $inp_food_name";
			$inp_food_manufacturer_name_and_food_name_mysql = quote_smart($link, $inp_food_manufacturer_name_and_food_name);
		
			// $inp_food_description = $_POST['inp_food_description'];
			$inp_food_description = "";
			$inp_food_description = output_html($inp_food_description);
			$inp_food_description_mysql = quote_smart($link, $inp_food_description);

			$inp_food_barcode_mysql = quote_smart($link, $barcode);

			$inp_food_country = $_POST['inp_food_country'];
			$inp_food_country = output_html($inp_food_country);
			$inp_food_country_mysql = quote_smart($link, $inp_food_country);

			$inp_age_restriction = $_POST['inp_age_restriction'];
			$inp_age_restriction = output_html($inp_age_restriction);
			$inp_age_restriction_mysql = quote_smart($link, $inp_age_restriction);

			// Food path
			$year = date("Y");
			$food_manufacturer_name_clean = clean($inp_food_manufacturer_name);
			$store_dir = $food_manufacturer_name_clean . "_" . $inp_food_clean_name;
			$inp_food_image_path = "_uploads/food/_img/$l/$year/$store_dir";
			$inp_food_image_path_mysql = quote_smart($link, $inp_food_image_path);


			if($ft == ""){
						
				$inp_food_user_id = $_SESSION['user_id'];
				$inp_food_user_id = output_html($inp_food_user_id);
				$inp_food_user_id_mysql = quote_smart($link, $inp_food_user_id);

				// IP 
				$inp_user_ip = $_SERVER['REMOTE_ADDR'];
				$inp_user_ip = output_html($inp_user_ip);
				$inp_user_ip_mysql = quote_smart($link, $inp_user_ip);

				// Datetime (notes)
				$datetime = date("Y-m-d H:i:s");
				$inp_notes = "Started on $datetime by user id $inp_food_user_id";
				$inp_notes_mysql = quote_smart($link, $inp_notes);

				$inp_food_time = date("H:i:s");


				// Accepted as master
				$inp_accepted_as_master = 0;
				$inp_accepted_as_master_mysql = quote_smart($link, $inp_accepted_as_master);


				mysqli_query($link, "INSERT INTO $t_food_index
				(food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, 
				food_manufacturer_name_and_food_name, food_description, food_country, food_net_content_metric, food_net_content_metric_measurement, 
				food_net_content_us_system, food_net_content_us_system_measurement, food_serving_size_metric, food_serving_size_metric_measurement, food_serving_size_us_system, 

				food_serving_size_us_system_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, 
				food_carbohydrates, food_dietary_fiber, food_carbohydrates_of_which_sugars, food_fat, food_fat_of_which_saturated_fatty_acids, 
				food_salt, food_sodium, food_score, food_energy_calculated, food_proteins_calculated, 
				food_salt_calculated, food_sodium_calculated, food_carbohydrates_calculated, food_dietary_fiber_calculated, food_carbohydrates_of_which_sugars_calculated, 
				food_fat_calculated, food_fat_of_which_saturated_fatty_acids_calculated, food_barcode, food_main_category_id, food_sub_category_id, 
				food_image_path, food_last_used, food_language, food_synchronized, food_accepted_as_master, 
				food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, 
				food_dislikes, food_likes_ip_block, food_user_ip, food_created_date, food_last_viewed, 
				food_age_restriction) 
				VALUES 
				(NULL, $inp_food_user_id_mysql, $inp_food_name_mysql, $inp_food_clean_name_mysql, $inp_food_manufacturer_name_mysql, 
				$inp_food_manufacturer_name_and_food_name_mysql, $inp_food_description_mysql, $inp_food_country_mysql, '0', 'g', 
				'0', 'US oz', '0', 'g', '0',
				'US oz', 0, 'g', '0', '0', 
				'0', '0', '0', '0', '0', 
				'0', '0', '0', '0', '0', 
				'0', '0', '0', '0', '0',
				 '0', '0', $inp_food_barcode_mysql, '$get_current_main_category_id', '$get_current_sub_category_id', 
				$inp_food_image_path_mysql, '$datetime', $l_mysql, '$datetime', $inp_accepted_as_master_mysql,
				$inp_notes_mysql, '0', '', '0', '0', 
				'0', '', $inp_user_ip_mysql, '$datetime','$datetime', 
				$inp_age_restriction_mysql)")
				or die(mysqli_error($link));

				// Get _id
				$query = "SELECT food_id FROM $t_food_index WHERE food_notes=$inp_notes_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_food_id) = $row;
				if($get_food_id == ""){
					echo"Error could not get food id";
					die;
				}


				// Check if food country is used
				$query_t = "SELECT food_country_id, food_country_count_food FROM $t_food_countries_used WHERE food_country_name=$inp_food_country_mysql";
				$result_t = mysqli_query($link, $query_t);
				$row_t = mysqli_fetch_row($result_t);
				list($get_food_country_id, $get_food_country_count_food) = $row_t;
				if($get_food_country_id == ""){
					// New food country
					mysqli_query($link, "INSERT INTO $t_food_countries_used 
					(food_country_id, food_country_name, food_country_count_food) 
					VALUES 
					(NULL, $inp_food_country_mysql, '1')")
					or die(mysqli_error($link));
				}
				else{
					$inp_count = $get_food_country_count_food+1;
					$result = mysqli_query($link, "UPDATE $t_food_countries_used SET food_country_count_food=$inp_count WHERE food_country_id=$get_food_country_id");
				}

				

				// Search engine
				$inp_index_title = "$inp_food_manufacturer_name $inp_food_name";
				$inp_index_title_mysql = quote_smart($link, $inp_index_title);

				$inp_index_url = "food/view_food.php?food_id=$get_food_id";
				$inp_index_url_mysql = quote_smart($link, $inp_index_url);

				$inp_index_short_description = substr($inp_food_description , 0, 200);
				$inp_index_short_description_mysql = quote_smart($link, $inp_index_short_description);

				$datetime = date("Y-m-d H:i:s");
				$datetime_saying = date("j. M Y H:i");

				$inp_index_language = output_html($l);
				$inp_index_language_mysql = quote_smart($link, $inp_index_language);

				mysqli_query($link, "INSERT INTO $t_search_engine_index 
				(index_id, index_title, index_url, index_short_description, index_keywords, 
				index_module_name, index_module_part_name, index_reference_name, index_reference_id, index_is_ad, 
				index_created_datetime, index_created_datetime_print, index_language) 
				VALUES 
				(NULL, $inp_index_title_mysql, $inp_index_url_mysql, $inp_index_short_description_mysql, '', 
				'food', 'food', 'food_id','$get_food_id', 0, 
				'$datetime', '$datetime_saying', $inp_index_language_mysql)")
				or die(mysqli_error($link));
		
				// Search engine
				include("new_food_00_add_update_search_engine.php");


				// Header
				$url = "new_food_5_images.php?main_category_id=$main_category_id&sub_category_id=$sub_category_id&food_id=$get_food_id&image=a&l=$l";
				header("Location: $url");
				exit;

			}
			else{
				$url = "new_food_4_general_information.php?main_category_id=$main_category_id&sub_category_id=$sub_category_id&l=$l";
				$url = $url . "&ft=$ft&fm=$fm";
				$url = $url . "&inp_food_name=$inp_food_name";
				$url = $url . "&inp_food_manufacturer_name=$inp_food_manufacturer_name";
				$url = $url . "&inp_food_description=$inp_food_description";
				$url = $url . "&inp_food_barcode=$inp_food_barcode";
				$url = $url . "&inp_food_serving_size_gram=$inp_food_serving_size_gram";
				$url = $url . "&inp_food_serving_size_gram_measurement=$inp_food_serving_size_gram_measurement";
				$url = $url . "&inp_food_serving_size_pcs=$inp_food_serving_size_pcs";
				$url = $url . "&inp_food_serving_size_pcs_measurement=$inp_food_serving_size_pcs_measurement";

				header("Location: $url");
				exit;
			}
		}	


		echo"
		<h1>$l_new_food</h1>
		<!-- Feedback -->
				";
				if($ft != "" && $fm != ""){
					if($fm == "missing_energy"){
						$fm = "Please enter energy";
					}
					elseif($fm == "missing_proteins"){
						$fm = "Please enter proteins";
					}
					elseif($fm == "missing_carbohydrates"){
						$fm = "Please enter carbohydrates";
					}
					elseif($fm == "missing_fat"){
						$fm = "Please enter fat";
					}
					else{
						$fm = ucfirst($fm);
					}
					echo"<div class=\"$ft\"><p>$fm</p></div>";	
				}
				echo"

		<!-- //Feedback -->


		<!-- General information -->
			<!-- Focus -->
			<script>
				\$(document).ready(function(){
					\$('[name=\"inp_food_name\"]').focus();
				});
			</script>
			<!-- //Focus -->

			<form method=\"post\" action=\"new_food_4_general_information.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;l=$l&amp;barcode=$barcode&amp;process=1\" enctype=\"multipart/form-data\">

			<h2>$l_general_information</h2>
					
			<p><b>$l_name*:</b><br />
			<input type=\"text\" name=\"inp_food_name\" value=\"";
				if(isset($_GET['inp_food_name'])){
					$inp_food_name= $_GET['inp_food_name'];
					$inp_food_name = output_html($inp_food_name);
					echo"$inp_food_name";
				}
				echo"\" size=\"40\" /></p>
			
			<p><b>$l_manufacturer*:</b><br />
			<input type=\"text\" name=\"inp_food_manufacturer_name\" value=\"";
				if(isset($_GET['inp_food_manufacturer_name'])){
					$inp_food_manufacturer_name= $_GET['inp_food_manufacturer_name'];
					$inp_food_manufacturer_name = output_html($inp_food_manufacturer_name);
					echo"$inp_food_manufacturer_name";
				}
				echo"\" size=\"40\" /></p>
			
			<p><b>$l_country*:</b><br />\n";


				if(isset($_GET['inp_food_country'])){
					$inp_food_country = $_GET['inp_food_country'];
					$inp_food_country = strip_tags(stripslashes($inp_food_country));
				}
				else{
					$inp_food_country = "";
				}

				// Find the country the last person registrered used
				$inp_food_user_id = $_SESSION['user_id'];
				$inp_food_user_id = output_html($inp_food_user_id);
				$inp_food_user_id_mysql = quote_smart($link, $inp_food_user_id);

				$query = "SELECT food_country FROM $t_food_index WHERE food_user_id=$inp_food_user_id_mysql ORDER BY food_id DESC LIMIT 0,1";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($inp_food_country) = $row;
			
				echo"
				<select name=\"inp_food_country\">\n";
				$query = "SELECT language_flag FROM $t_languages ORDER BY language_flag ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_language_flag) = $row;

					$country = str_replace("_", " ", $get_language_flag);
					$country = ucwords($country);
					if($country != "$prev_country"){
						echo"			";
						echo"<option value=\"$country\""; if($inp_food_country == "$country"){ echo" selected=\"selected\""; } echo">$country</option>\n";
					}
					$prev_country = "$country";
				}
				echo"
				</select>
				</p>
			
			<p><b>$l_age_restriction:</b><br />";

				if(isset($_GET['inp_age_restriction'])){
					$inp_age_restriction = $_GET['inp_age_restriction'];
					$inp_age_restriction = strip_tags(stripslashes($inp_age_restriction));
					echo"$inp_food_barcode";
				}
				else{
					$inp_age_restriction = 0;
				}
				echo"
				<select name=\"inp_age_restriction\">
					<option value=\"0\""; if($inp_age_restriction == "0"){ echo" selected=\"selected\""; } echo">$l_no</option>
					<option value=\"1\""; if($inp_age_restriction == "1"){ echo" selected=\"selected\""; } echo">$l_yes</option>
				</select>
				<br />
				<em>$l_example_alcohol</em></p>
			
			<p><input type=\"submit\" value=\"$l_save\" class=\"btn btn-success btn-sm\" /></p>
			
			<!-- //General information -->

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