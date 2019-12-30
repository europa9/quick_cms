<?php 
header("Content-Type: text/html;charset=ISO-8859-1");
/**
*
* File: food_diary/food_diary_add_query.php
* Version 1.0.0
* Date 15:38 21.01.2018
* Copyright (c) 2018 S. A. Ditlefsen
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



/*- MySQL Tables -------------------------------------------------------------------- */
$t_food_index	 	= $mysqlPrefixSav . "diet_food";
$t_food_index_queries 	= $mysqlPrefixSav . "diet_food_queries";

/*- Variables ------------------------------------------------------------------------- */
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
if(isset($_GET['meal_id']) OR isset($_POST['meal_id'])) {
	if(isset($_GET['meal_id'])){
		$meal_id = $_GET['meal_id'];
	}
	else{
		$meal_id = $_POST['meal_id'];
	}
	$meal_id = output_html($meal_id);
}
else{
	echo"Missing entry day number";
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
		$query = "SELECT query_name, query_times FROM $t_food_index_queries WHERE query_name=$q_mysql";
		$res = mysqli_query($link, $query);
		$row = mysqli_fetch_row($res);
		$get_query_name = $row[0];
		$get_query_times = $row[1];

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
		$q = "%" . $q . "%";
		$q_mysql = quote_smart($link, $q);


		// Set layout
		$x = 0;

		// Query
		$query = "SELECT food_id, food_user_id, food_name, food_manufacturer_name, food_description, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_fat, food_energy_calculated, food_proteins_calculated, food_carbohydrates_calculated, food_fat_calculated, food_barcode, food_category_id, food_image_path, food_thumb, food_image_a, food_unique_hits, food_likes, food_dislikes FROM $t_food_index WHERE food_language=$l_mysql AND (food_name LIKE $q_mysql OR food_manufacturer_name LIKE $q_mysql)";
	
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
			list($get_food_id, $get_food_user_id, $get_food_name, $get_food_manufacturer_name, $get_food_description, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_fat, $get_food_energy_calculated, $get_food_proteins_calculated, $get_food_carbohydrates_calculated, $get_food_fat_calculated, $get_food_barcode, $get_food_category_id,  $get_food_image_path, $get_food_thumb, $get_food_image_a, $get_food_unique_hits, $get_food_likes, $get_food_dislikes) = $row;


				
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
				$thumb = "../$get_food_image_path/$get_food_thumb";
			}
			else{
				$thumb = "_gfx/no_thumb.png";
			}





			echo"
				<p style=\"padding-bottom:5px;\">
				<a href=\"../food/view_food.php?food_id=$get_food_id&amp;l=$l\"><img src=\"$thumb\" alt=\"$get_food_image_a\" style=\"margin-bottom: 5px;\" /></a><br />
					
				<a href=\"../food/view_food.php?food_id=$get_food_id&amp;l=$l\" style=\"font-weight: bold;color: #444444;\">$title</a><br />
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


				<!-- Add food -->
					<form method=\"post\" action=\"food_diary_add_food.php?action=add_food_to_diary&amp;date=$date&amp;meal_id=$meal_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
					<p>
					<input type=\"hidden\" name=\"inp_entry_food_id\" value=\"$get_food_id\" />
					";
					if($get_food_serving_size_pcs_measurement == "g"){
						echo"
						<input type=\"text\" name=\"inp_entry_food_serving_size\" size=\"2\" value=\"$get_food_serving_size_gram\" />
						<input type=\"submit\" name=\"inp_submit_gram\" value=\"$get_food_serving_size_gram_measurement\" class=\"btn btn_default\" />";
					}
					else {
						echo"
						<input type=\"text\" name=\"inp_entry_food_serving_size\" size=\"2\" value=\"$get_food_serving_size_pcs\" />
						<input type=\"submit\" name=\"inp_submit_gram\" value=\"$get_food_serving_size_gram_measurement\" class=\"btn btn_default\" />
						<input type=\"submit\" name=\"inp_submit_pcs\" value=\"$get_food_serving_size_pcs_measurement\" class=\"btn btn_default\" />";
					}
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