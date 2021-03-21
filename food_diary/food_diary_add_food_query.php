<?php
error_reporting(E_ALL & ~E_STRICT);
@session_start();
ini_set('arg_separator.output', '&amp;');

/**
*
* File: food_diary/food_diary_add_query.php
* Version 1.0.0
* Date 12:11 19.10.2020
* Copyright (c) 2018-2020 S. A. Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/



/*- Functions ------------------------------------------------------------------------ */
include("../_admin/_functions/output_html.php");
include("../_admin/_functions/clean.php");
include("../_admin/_functions/quote_smart.php");
include("../_admin/_functions/resize_crop_image.php");


/*- Common variables ----------------------------------------------------------------- */
$server_name = $_SERVER['HTTP_HOST'];
$server_name = clean($server_name);

/*- MySQL ------------------------------------------------------------ */
$check = substr($server_name, 0, 3);
if($check == "www"){
	$server_name = substr($server_name, 3);
}
$setup_finished_file = "setup_finished_" . $server_name . ".php";
if(!(file_exists("../_admin/_data/$setup_finished_file"))){
	die;
}
else{
	include("../_admin/_data/config/meta.php");
	include("../_admin/_data/config/user_system.php");
}
$mysql_config_file = "../_admin/_data/mysql_" . $server_name . ".php";
include("$mysql_config_file");
$link = mysqli_connect($mysqlHostSav, $mysqlUserNameSav, $mysqlPasswordSav, $mysqlDatabaseNameSav);
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

/*- Tables --------------------------------------------------------------------------- */
include("_tables.php");



/*- MySQL Tables -------------------------------------------------------------------- */
$t_food_index	 	= $mysqlPrefixSav . "food_index";
$t_food_index_queries 	= $mysqlPrefixSav . "food_index_queries";

/*- Variables ------------------------------------------------------------------------- */
$root = "../";
if(isset($_GET['l']) OR isset($_POST['l'])) {
	if(isset($_GET['l'])){
		$l = $_GET['l'];
	}
	else{
		$l = $_POST['l'];
	}
	$l = strip_tags(stripslashes($l));
}
else{
	$l = "";
}
$l_mysql = quote_smart($link, $l);

if(isset($_GET['order_by']) OR isset($_POST['order_by'])) {
	if(isset($_GET['order_by'])){
		$order_by = $_GET['order_by'];
	}
	else{
		$order_by = $_POST['order_by'];
	}
	$order_by = strip_tags(stripslashes($order_by));
}
else{
	$order_by = "";
}
if(isset($_GET['order_method']) OR isset($_POST['order_method'])) {
	if(isset($_GET['order_method'])){
		$order_method = $_GET['order_method'];
	}
	else{
		$order_method = $_POST['order_method'];
	}
	$order_method = strip_tags(stripslashes($order_method));
}
else{
	$order_method = "";
}



if(isset($_GET['date']) OR isset($_POST['date'])) {
	if(isset($_GET['date'])){
		$date = $_GET['date'];
	}
	else{
		$date = $_POST['date'];
	}
	$date = output_html($date);
}
else{
	echo"Missing meal plan id";
	die;
}
if(isset($_GET['hour_name']) OR isset($_POST['hour_name'])) {
	if(isset($_GET['hour_name'])){
		$hour_name = $_GET['hour_name'];
	}
	else{
		$hour_name = $_POST['hour_name'];
	}
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

/*- Language ------------------------------------------------------------------------ */
include("../_admin/_translations/site/$l/food/ts_food.php");
include("../_admin/_translations/site/$l/food_diary/ts_food_diary_add.php");



/*- Table exists? -------------------------------------------------------------------- */
$query = "SELECT * FROM $t_food_index_queries LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){
}
else{
	echo"Table created";
	mysqli_query($link, "CREATE TABLE $t_food_index_queries(
	 query_id INT NOT NULL AUTO_INCREMENT,
	 PRIMARY KEY(query_id), 
	 query_name VARCHAR(90) NOT NULL,
	 query_times BIGINT,
	 query_last_use DATETIME,
	 query_hidden INT)")
	 or die(mysql_error());
}

/*- Adapter view -------------------------------------------------------------------- */

if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	
	$query_t = "SELECT view_id, view_user_id, view_system, view_hundred_metric, view_serving, view_pcs_metric, view_eight_us, view_pcs_us FROM $t_food_diary_user_adapted_view WHERE view_user_id=$my_user_id_mysql";
	$result_t = mysqli_query($link, $query_t);
	$row_t = mysqli_fetch_row($result_t);
	list($get_current_view_id, $get_current_view_user_id, $get_current_view_system, $get_current_view_hundred_metric, $get_current_view_serving, $get_current_view_pcs_metric, $get_current_view_eight_us, $get_current_view_pcs_us) = $row_t;

	if($get_current_view_id == ""){
		mysqli_query($link, "INSERT INTO $t_food_diary_user_adapted_view 
				(view_id, view_user_id, view_system, view_hundred_metric, view_pcs_metric, 
				view_eight_us, view_pcs_us) 
				VALUES 
				(NULL, $my_user_id_mysql,  'metric', 1, 1,
				0, 0)")
				or die(mysqli_error($link));

		$query_t = "SELECT view_id, view_user_id, view_system, view_hundred_metric, view_serving, view_pcs_metric, view_eight_us, view_pcs_us FROM $t_food_diary_user_adapted_view WHERE view_user_id=$my_user_id_mysql";
		$result_t = mysqli_query($link, $query_t);
		$row_t = mysqli_fetch_row($result_t);
		list($get_current_view_id, $get_current_view_user_id, $get_current_view_system, $get_current_view_hundred_metric, $get_current_view_serving, $get_current_view_pcs_metric, $get_current_view_eight_us, $get_current_view_pcs_us) = $row_t;

	}
}
else{
	echo"Error: Your not logged in.";
	die;
}


/*- Query --------------------------------------------------------------------------- */
if(isset($_GET['q']) OR isset($_POST['q'])){
	if(isset($_GET['q'])) {
		$q = $_GET['q'];
	}
	else{
		$q = $_POST['q'];
	}
	$q = utf8_decode($q);
	$q = trim($q);
	$q = strtolower($q);
	$inp_datetime = date("Y-m-d H:i:s");
	$q = output_html($q);
	$q_mysql = quote_smart($link, $q);



	if($q != ""){
		$query_t = "SELECT query_name, query_times FROM $t_food_index_queries WHERE query_name=$q_mysql";
		$result_t = mysqli_query($link, $query_t);
		$row_t = mysqli_fetch_row($result_t);
		list($get_query_name, $get_query_times) = $row_t;

		if($get_query_name == ""){
			// Insert
			$insert_error = "0";
			mysqli_query($link, "INSERT INTO $t_food_index_queries
			(query_name, query_times, query_last_use) 
			VALUES
			($q_mysql, '1', '$inp_datetime') ")
			or $insert_error = 1;

		}
		else{
			$inp_query_times = $get_query_times+1;

			$result = mysqli_query($link, "UPDATE $t_food_index_queries SET query_times='$inp_query_times', query_last_use='$inp_datetime' WHERE query_name=$q_mysql");
		}



		// Ready for MySQL search
		$q = "" . $q . "%";
		$q_mysql = quote_smart($link, $q);


		// Set layout
		$x = 0;

		// Query
		$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_country, food_net_content_metric, food_net_content_measurement_metric, food_net_content_us, food_net_content_measurement_us, food_net_content_added_measurement, food_serving_size_metric, food_serving_size_measurement_metric, food_serving_size_us, food_serving_size_measurement_us, food_serving_size_added_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy_metric, food_fat_metric, food_saturated_fat_metric, food_monounsaturated_fat_metric, food_polyunsaturated_fat_metric, food_cholesterol_metric, food_carbohydrates_metric, food_carbohydrates_of_which_sugars_metric, food_dietary_fiber_metric, food_proteins_metric, food_salt_metric, food_sodium_metric, food_energy_us, food_fat_us, food_saturated_fat_us, food_monounsaturated_fat_us, food_polyunsaturated_fat_us, food_cholesterol_us, food_carbohydrates_us, food_carbohydrates_of_which_sugars_us, food_dietary_fiber_us, food_proteins_us, food_salt_us, food_sodium_us, food_score, food_energy_calculated_metric, food_fat_calculated_metric, food_saturated_fat_calculated_metric, food_monounsaturated_fat_calculated_metric, food_polyunsaturated_fat_calculated_metric, food_cholesterol_calculated_metric, food_carbohydrates_calculated_metric, food_carbohydrates_of_which_sugars_calculated_metric, food_dietary_fiber_calculated_metric, food_proteins_calculated_metric, food_salt_calculated_metric, food_sodium_calculated_metric, food_energy_calculated_us, food_fat_calculated_us, food_saturated_fat_calculated_us, food_monounsaturated_fat_calculated_us, food_polyunsaturated_fat_calculated_us, food_cholesterol_calculated_us, food_carbohydrates_calculated_us, food_carbohydrates_of_which_sugars_calculated_us, food_dietary_fiber_calculated_us, food_proteins_calculated_us, food_salt_calculated_us, food_sodium_calculated_us, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_thumb_a_medium, food_thumb_a_large, food_image_b, food_thumb_b_small, food_thumb_b_medium, food_thumb_b_large, food_image_c, food_thumb_c_small, food_thumb_c_medium, food_thumb_c_large, food_image_d, food_thumb_d_small, food_thumb_d_medium, food_thumb_d_large, food_image_e, food_thumb_e_small, food_thumb_e_medium, food_thumb_e_large, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_created_date, food_last_viewed, food_age_restriction FROM $t_food_index WHERE food_language=$l_mysql AND (food_name LIKE $q_mysql OR food_manufacturer_name LIKE $q_mysql)";
	
		// Order
		if($order_by != ""){
			if($order_method == "desc"){
				$order_method_mysql = "DESC";
			}
			else{
				$order_method_mysql = "ASC";
			}

			if($order_by == "food_id" OR $order_by == "food_name" OR $order_by == "food_unique_hits" 
			OR $order_by == "food_energy" OR $order_by == "food_proteins" OR $order_by == "food_carbohydrates" OR $order_by == "food_fat"){
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
									<input type=\"text\" name=\"inp_entry_food_serving_size\" size=\"2\" value=\"$get_food_serving_size_metric\" />
									<input type=\"submit\" name=\"inp_submit_metric\" value=\"$get_food_serving_size_measurement_metric\" class=\"btn btn_default\" />
									";
								}
								else{
									echo"
									<input type=\"text\" name=\"inp_entry_food_serving_size\" size=\"2\" value=\"$get_food_serving_size_pcs\" />
									<input type=\"submit\" name=\"inp_submit_metric\" value=\"$get_food_serving_size_measurement_metric\" class=\"btn btn_default\" />
									<input type=\"submit\" name=\"inp_submit_pcs\" value=\"$get_food_serving_size_pcs_measurement\" class=\"btn btn_default\" />
									";
								}
							} // metric
							if($get_current_view_eight_us == "1" OR $get_current_view_pcs_us == "1"){
								echo"
								<input type=\"text\" name=\"inp_entry_food_serving_size\" size=\"2\" value=\"$get_food_serving_size_pcs\" />
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
		} // while

		if($x == "2"){
			echo"
				<div class=\"left_center_center_right_right_center\" style=\"text-align: center;padding-bottom: 20px;\">
				</div>
			
				<div class=\"left_center_center_right_right\" style=\"text-align: center;padding-bottom: 20px;\">
				</div>
				<div class=\"clear\"></div>
			";
		}
	}
	else{
		echo"Q is blank";
	}
}
else{
	echo"No q";
}


?>