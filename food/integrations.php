<?php
/**
*
* File: food/integrations.php
* Version 1.0.0.
* Date 20:38 08.02.2019
* Copyright (c) 2019 Sindre Andre Ditlefsen
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


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_food - $l_integrations";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

if($action == ""){
	$week = date("w");
	$datetime = date("Y-m-d H:i:s");

	echo"
	<h1>$l_integrations</h1>

	<p>
	$l_datetime: $datetime<br />
	$l_week: $week<br />
	</p>
	
	<!-- Integrations sites -->
	<p><b>$l_integrations_ready_to_run:</b></p>
	<div class=\"vertical\">
		<ul>";

		// food_integration
			$query = "SELECT integration_id, integration_title FROM $t_food_integration";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_integration_id, $get_integration_title) = $row;
				
				echo"<li><a href=\"integrations.php?action=step_1_ask_last_on_server&amp;integration_id=$get_integration_id&amp;l=$l\">$get_integration_title</a></li>\n";
			}
			echo"
			</ul>
		</div>
	<!-- //Integrations sites -->
	";
}
elseif($action == "step_1_ask_last_on_server"){
	// Variables
	if(isset($_GET['integration_id'])){
		$integration_id= $_GET['integration_id'];
		$integration_id = strip_tags(stripslashes($integration_id));
	}
	else{
		$integration_id = "";
	}

	$week = date("w");
	$datetime = date("Y-m-d H:i:s");


	// Select integration
	$integration_id_mysql = quote_smart($link, $integration_id);
	$query = "SELECT integration_id, integration_title, integration_url, integration_password, integration_last_downloaded, integration_last_on_server, integration_last_checked_week, integration_last_checked_datetime FROM $t_food_integration WHERE integration_id=$integration_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_integration_id, $get_integration_title, $get_integration_url, $get_integration_password, $get_integration_last_downloaded, $get_integration_last_on_server, $get_integration_last_checked_week, $get_integration_last_checked_datetime) = $row;

	if($get_integration_id == ""){
		echo"
		<h1>Server error 404</h1>

		<p>Not found.</p>

		<p><a href=\"index.php\">Home</a></p>
		";
	}
	else{
		echo"
		<h1>$get_integration_title</h1>

		<p><b>$l_before_request</b><br />
		$l_last_downloaded: $get_integration_last_downloaded<br />
		$l_last_on_server: $get_integration_last_on_server
		</p>

		<!-- Request -->
			<p><b>$l_after_request</b><br />";
			$last_on_server = file_get_contents("$get_integration_url/food/api/get_last_food_index_id_on_server.php");
			$last_on_server = output_html($last_on_server);
			$last_on_server_mysql = quote_smart($link, $last_on_server);
	
			// Update
			$result = mysqli_query($link, "UPDATE $t_food_integration SET 
							integration_last_on_server=$last_on_server_mysql,
							integration_last_checked_week='$week',
							integration_last_checked_datetime='$datetime'
							 WHERE integration_id=$get_integration_id") or die(mysqli_error($link));


			echo"$l_last_on_server: $last_on_server	
			</p>

		
		<!-- //Request -->

		<!-- Action -->
			";
			if($last_on_server > $get_integration_last_downloaded){

				echo"
				<p>
				<a href=\"integrations.php?action=step_2_download&amp;integration_id=$get_integration_id&amp;l=$l&amp;datetime=$datetime\">$l_download</a>
				</p>
				<meta http-equiv=\"refresh\" content=\"2;url=integrations.php?action=step_2_download&amp;integration_id=$get_integration_id&amp;l=$l&amp;datetime=$datetime\" />
				";
			}
			echo"
		<!-- //Action -->
		";
	}
}
elseif($action == "step_2_download"){
	// Variables
	if(isset($_GET['integration_id'])){
		$integration_id= $_GET['integration_id'];
		$integration_id = strip_tags(stripslashes($integration_id));
	}
	else{
		$integration_id = "";
	}

	$week = date("w");
	$datetime = date("Y-m-d H:i:s");


	// Select integration
	$integration_id_mysql = quote_smart($link, $integration_id);
	$query = "SELECT integration_id, integration_title, integration_url, integration_password, integration_last_downloaded, integration_last_on_server, integration_last_checked_week, integration_last_checked_datetime FROM $t_food_integration WHERE integration_id=$integration_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_integration_id, $get_integration_title, $get_integration_url, $get_integration_password, $get_integration_last_downloaded, $get_integration_last_on_server, $get_integration_last_checked_week, $get_integration_last_checked_datetime) = $row;

	if($get_integration_id == ""){
		echo"
		<h1>Server error 404</h1>

		<p>Not found.</p>

		<p><a href=\"index.php\">Home</a></p>
		";
	}
	else{


		echo"
		<h1>$get_integration_title</h1>

		<p><b>$l_before_request</b><br />
		$l_last_downloaded: $get_integration_last_downloaded<br />
		$l_last_on_server: $get_integration_last_on_server
		</p>

		<!-- Request -->
			<p><b>$l_after_request</b><br />";
			$start = $get_integration_last_downloaded+1;
			$stop = $start+1;


			// Update last downloaded
			$result = mysqli_query($link, "UPDATE $t_food_integration SET integration_last_downloaded='$stop' WHERE integration_id=$get_integration_id");
		

			// Download food
			$data = file_get_contents("$get_integration_url/food/api/get_many_food_index_from_server.php?start=$start&stop=$stop");
			
			if($data != ""){
				$json = json_decode($data, true); // decode the JSON into an associative array
				$json_size = sizeof($json);

				// index
				echo"<p>$l_json_size: $json_size </p>";
				for($x=0;$x<$json_size;$x++){
					$object = $json[$x];

					// Index
					$inp_food_id = $object['index']['food_id'];
					$inp_food_id = output_html($inp_food_id);
					$inp_food_id_mysql = quote_smart($link, $inp_food_id);

					$inp_food_user_id = $object['index']['food_user_id'];
					$inp_food_user_id = output_html($inp_food_user_id);
					$inp_food_user_id_mysql = quote_smart($link, $inp_food_user_id);

					$inp_food_name = $object['index']['food_name'];
					$inp_food_name = output_html($inp_food_name);
					$inp_food_name_mysql = quote_smart($link, $inp_food_name);

					$inp_food_clean_name = $object['index']['food_clean_name'];
					$inp_food_clean_name = output_html($inp_food_clean_name);
					$inp_food_clean_name_mysql = quote_smart($link, $inp_food_clean_name);

					$inp_food_manufacturer_name = $object['index']['food_manufacturer_name'];
					$inp_food_manufacturer_name = output_html($inp_food_manufacturer_name);
					$inp_food_manufacturer_name_mysql = quote_smart($link, $inp_food_manufacturer_name);
					echo"<h2>$inp_food_manufacturer_name $inp_food_name</h2>";

					$inp_food_manufacturer_name_and_food_name = $object['index']['food_manufacturer_name_and_food_name'];
					$inp_food_manufacturer_name_and_food_name = output_html($inp_food_manufacturer_name_and_food_name);
					$inp_food_manufacturer_name_and_food_name_mysql = quote_smart($link, $inp_food_manufacturer_name_and_food_name);

					$inp_food_description = $object['index']['food_description'];
					$inp_food_description = output_html($inp_food_description);
					$inp_food_description_mysql = quote_smart($link, $inp_food_description);

					$inp_food_country = $object['index']['food_country'];
					$inp_food_country = output_html($inp_food_country);
					$inp_food_country_mysql = quote_smart($link, $inp_food_country);

					$inp_food_net_content = $object['index']['food_net_content'];
					$inp_food_net_content = output_html($inp_food_net_content);
					$inp_food_net_content_mysql = quote_smart($link, $inp_food_net_content);

					$inp_food_net_content_measurement = $object['index']['food_net_content_measurement'];
					$inp_food_net_content_measurement = output_html($inp_food_net_content_measurement);
					$inp_food_net_content_measurement_mysql = quote_smart($link, $inp_food_net_content_measurement);

					$inp_food_serving_size_gram = $object['index']['food_serving_size_gram'];
					$inp_food_serving_size_gram = output_html($inp_food_serving_size_gram);
					$inp_food_serving_size_gram_mysql = quote_smart($link, $inp_food_serving_size_gram);

					$inp_food_serving_size_gram_measurement = $object['index']['food_serving_size_gram_measurement'];
					$inp_food_serving_size_gram_measurement = output_html($inp_food_serving_size_gram_measurement);
					$inp_food_serving_size_gram_measurement_mysql = quote_smart($link, $inp_food_serving_size_gram_measurement);

					$inp_food_serving_size_pcs = $object['index']['food_serving_size_pcs'];
					$inp_food_serving_size_pcs = output_html($inp_food_serving_size_pcs);
					$inp_food_serving_size_pcs_mysql = quote_smart($link, $inp_food_serving_size_pcs);


					$inp_food_serving_size_pcs_measurement = $object['index']['food_serving_size_pcs_measurement'];
					$inp_food_serving_size_pcs_measurement = output_html($inp_food_serving_size_pcs_measurement);
					$inp_food_serving_size_pcs_measurement_mysql = quote_smart($link, $inp_food_serving_size_pcs_measurement);

					$inp_food_energy = $object['index']['food_energy'];
					$inp_food_energy = output_html($inp_food_energy);
					$inp_food_energy_mysql = quote_smart($link, $inp_food_energy);

					$inp_food_fat = $object['index']['food_fat'];
					$inp_food_fat = output_html($inp_food_fat);
					$inp_food_fat_mysql = quote_smart($link, $inp_food_fat);

					$inp_food_fat_of_which_saturated_fatty_acids = $object['index']['food_fat_of_which_saturated_fatty_acids'];
					$inp_food_fat_of_which_saturated_fatty_acids = output_html($inp_food_fat_of_which_saturated_fatty_acids);
					$inp_food_fat_of_which_saturated_fatty_acids_mysql = quote_smart($link, $inp_food_fat_of_which_saturated_fatty_acids);

					$inp_food_carbohydrates = $object['index']['food_carbohydrates'];
					$inp_food_carbohydrates = output_html($inp_food_carbohydrates);
					$inp_food_carbohydrates_mysql = quote_smart($link, $inp_food_carbohydrates);

					$inp_food_dietary_fiber = $object['index']['food_dietary_fiber'];
					if($inp_food_dietary_fiber == ""){
						$inp_food_dietary_fiber = 0;
					}
					$inp_food_dietary_fiber = output_html($inp_food_dietary_fiber);
					$inp_food_dietary_fiber_mysql = quote_smart($link, $inp_food_dietary_fiber);

					$inp_food_carbohydrates_of_which_sugars = $object['index']['food_carbohydrates_of_which_sugars'];
					$inp_food_carbohydrates_of_which_sugars = output_html($inp_food_carbohydrates_of_which_sugars);
					$inp_food_carbohydrates_of_which_sugars_mysql = quote_smart($link, $inp_food_carbohydrates_of_which_sugars);

					$inp_food_proteins = $object['index']['food_proteins'];
					$inp_food_proteins = output_html($inp_food_proteins);
					$inp_food_proteins_mysql = quote_smart($link, $inp_food_proteins);

					$inp_food_salt = $object['index']['food_salt'];
					$inp_food_salt = output_html($inp_food_salt);
					$inp_food_salt_mysql = quote_smart($link, $inp_food_salt);

					$inp_food_score = $object['index']['food_score'];
					$inp_food_score = output_html($inp_food_score);
					$inp_food_score_mysql = quote_smart($link, $inp_food_score);

					$inp_food_energy_calculated = $object['index']['food_energy_calculated'];
					$inp_food_energy_calculated = output_html($inp_food_energy_calculated);
					$inp_food_energy_calculated_mysql = quote_smart($link, $inp_food_energy_calculated);

					$inp_food_fat_calculated = $object['index']['food_fat_calculated'];
					$inp_food_fat_calculated = output_html($inp_food_fat_calculated);
					$inp_food_fat_calculated_mysql = quote_smart($link, $inp_food_fat_calculated);

					$inp_food_fat_of_which_saturated_fatty_acids_calculated = $object['index']['food_fat_of_which_saturated_fatty_acids_calculated'];
					$inp_food_fat_of_which_saturated_fatty_acids_calculated = output_html($inp_food_fat_of_which_saturated_fatty_acids_calculated);
					$inp_food_fat_of_which_saturated_fatty_acids_calculated_mysql = quote_smart($link, $inp_food_fat_of_which_saturated_fatty_acids_calculated);

					$inp_food_carbohydrates_calculated = $object['index']['food_carbohydrates_calculated'];
					$inp_food_carbohydrates_calculated = output_html($inp_food_carbohydrates_calculated);
					$inp_food_carbohydrates_calculated_mysql = quote_smart($link, $inp_food_carbohydrates_calculated);

					$inp_food_dietary_fiber_calculated = $object['index']['food_dietary_fiber_calculated'];	
					if($inp_food_dietary_fiber_calculated == ""){
						$inp_food_dietary_fiber_calculated = 0;
					}
					$inp_food_dietary_fiber_calculated = output_html($inp_food_dietary_fiber_calculated);
					$inp_food_dietary_fiber_calculated_mysql = quote_smart($link, $inp_food_dietary_fiber_calculated);

					$inp_food_carbohydrates_of_which_sugars_calculated = $object['index']['food_carbohydrates_of_which_sugars_calculated'];
					$inp_food_carbohydrates_of_which_sugars_calculated = output_html($inp_food_carbohydrates_of_which_sugars_calculated);
					$inp_food_carbohydrates_of_which_sugars_calculated_mysql = quote_smart($link, $inp_food_carbohydrates_of_which_sugars_calculated);

					$inp_food_proteins_calculated = $object['index']['food_proteins_calculated'];
					$inp_food_proteins_calculated = output_html($inp_food_proteins_calculated);
					$inp_food_proteins_calculated_mysql = quote_smart($link, $inp_food_proteins_calculated);

					$inp_food_salt_calculated = $object['index']['food_salt_calculated'];
					$inp_food_salt_calculated = output_html($inp_food_salt_calculated);
					$inp_food_salt_calculated_mysql = quote_smart($link, $inp_food_salt_calculated);

					$inp_food_barcode = $object['index']['food_barcode'];
					$inp_food_barcode = output_html($inp_food_barcode);
					$inp_food_barcode_mysql = quote_smart($link, $inp_food_barcode);

					$inp_food_category_id = $object['index']['food_category_id'];
					$inp_food_category_id = output_html($inp_food_category_id);
					$inp_food_category_id_mysql = quote_smart($link, $inp_food_category_id);

					$inp_food_image_path = $object['index']['food_image_path'];
					$inp_food_image_path = output_html($inp_food_image_path);
					$inp_food_image_path_mysql = quote_smart($link, $inp_food_image_path);

					$inp_food_thumb_small = $object['index']['food_thumb_small'];
					$inp_food_thumb_small = output_html($inp_food_thumb_small);
					$inp_food_thumb_small_mysql = quote_smart($link, $inp_food_thumb_small);

					$inp_food_thumb_medium = $object['index']['food_thumb_medium'];
					$inp_food_thumb_medium = output_html($inp_food_thumb_medium);
					$inp_food_thumb_medium_mysql = quote_smart($link, $inp_food_thumb_medium);

					$inp_food_thumb_large = $object['index']['food_thumb_large'];
					$inp_food_thumb_large = output_html($inp_food_thumb_large);
					$inp_food_thumb_large_mysql = quote_smart($link, $inp_food_thumb_large);

					$inp_food_image_a = $object['index']['food_image_a'];
					$inp_food_image_a = output_html($inp_food_image_a);
					$inp_food_image_a_mysql = quote_smart($link, $inp_food_image_a);

					$inp_food_image_b = $object['index']['food_image_b'];
					$inp_food_image_b = output_html($inp_food_image_b);
					$inp_food_image_b_mysql = quote_smart($link, $inp_food_image_b);

					$inp_food_image_c = $object['index']['food_image_c'];
					$inp_food_image_c = output_html($inp_food_image_c);
					$inp_food_image_c_mysql = quote_smart($link, $inp_food_image_c);

					$inp_food_image_d = $object['index']['food_image_d'];
					$inp_food_image_d = output_html($inp_food_image_d);
					$inp_food_image_d_mysql = quote_smart($link, $inp_food_image_d);

					$inp_food_image_e = $object['index']['food_image_e'];
					$inp_food_image_e = output_html($inp_food_image_e);
					$inp_food_image_e_mysql = quote_smart($link, $inp_food_image_e);

					$inp_food_language = $object['index']['food_language'];
					$inp_food_language = output_html($inp_food_language);
					$inp_food_language_mysql = quote_smart($link, $inp_food_language);



					// Datetime (notes)
					$datetime = date("Y-m-d H:i:s");
				
					$inp_food_date = date("Y-m-d");
					$inp_food_date_mysql = quote_smart($link, $inp_food_date);

					$inp_food_time = date("H:i:s"); 
					$inp_food_time_mysql = quote_smart($link, $inp_food_time);

					$inp_food_last_viewed = date("Y-m-d");
					$inp_food_last_viewed_mysql = quote_smart($link, $inp_food_last_viewed);



					// Check if exists
					$query = "SELECT food_id FROM $t_food_index WHERE food_name=$inp_food_name_mysql AND food_manufacturer_name=$inp_food_manufacturer_name_mysql AND food_country=$inp_food_country_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_check_if_exists_food_id) = $row;
					
					if($get_check_if_exists_food_id == ""){


						mysqli_query($link, "INSERT INTO $t_food_index
						(food_id, food_user_id, food_name, 
						food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, 
						food_description, food_country, food_net_content, food_net_content_measurement, 
						food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, 
						food_serving_size_pcs_measurement, food_energy, food_fat, 
						food_fat_of_which_saturated_fatty_acids, food_carbohydrates, food_dietary_fiber, 
						food_carbohydrates_of_which_sugars, food_proteins, food_salt, 
						food_score, food_energy_calculated, food_fat_calculated, 
						food_fat_of_which_saturated_fatty_acids_calculated, food_carbohydrates_calculated, food_dietary_fiber_calculated, 
						food_carbohydrates_of_which_sugars_calculated, food_proteins_calculated, food_salt_calculated, 
						food_barcode, food_category_id, food_image_path, 
						food_thumb_small, food_thumb_medium, food_thumb_large, 
						food_image_a, food_image_b, food_image_c, 
						food_image_d, food_image_e, food_last_used, 
						food_language, food_synchronized, food_accepted_as_master, 
						food_notes, food_unique_hits, food_unique_hits_ip_block, 
						food_comments, food_likes, food_dislikes, 
						food_likes_ip_block, food_user_ip, food_date, 
						food_time, food_last_viewed) 
						VALUES 
						(NULL, $inp_food_user_id_mysql, $inp_food_name_mysql, 
						$inp_food_clean_name_mysql, $inp_food_manufacturer_name_mysql, $inp_food_manufacturer_name_and_food_name_mysql, 
						$inp_food_description_mysql, $inp_food_country_mysql, $inp_food_net_content_mysql, $inp_food_net_content_measurement_mysql, 
						$inp_food_serving_size_gram_mysql, $inp_food_serving_size_gram_measurement_mysql, $inp_food_serving_size_pcs_mysql, 
						$inp_food_serving_size_pcs_measurement_mysql, $inp_food_energy_mysql, $inp_food_fat_mysql, 
						$inp_food_fat_of_which_saturated_fatty_acids_mysql, $inp_food_carbohydrates_mysql, $inp_food_dietary_fiber_mysql, 
						$inp_food_carbohydrates_of_which_sugars_mysql, $inp_food_proteins_mysql, $inp_food_salt_mysql, 
						$inp_food_score_mysql, $inp_food_energy_calculated_mysql, $inp_food_fat_calculated_mysql, 
						$inp_food_fat_of_which_saturated_fatty_acids_calculated_mysql, $inp_food_carbohydrates_calculated_mysql, $inp_food_dietary_fiber_calculated_mysql, 
						$inp_food_carbohydrates_of_which_sugars_calculated_mysql, $inp_food_proteins_calculated_mysql, $inp_food_salt_calculated_mysql, 
						$inp_food_barcode_mysql, $inp_food_category_id_mysql, $inp_food_image_path_mysql, 
						$inp_food_thumb_small_mysql, $inp_food_thumb_medium_mysql, $inp_food_thumb_large_mysql, 
						$inp_food_image_a_mysql, $inp_food_image_b_mysql, $inp_food_image_c_mysql, 
						$inp_food_image_d_mysql, $inp_food_image_e_mysql, '$datetime', 
						$inp_food_language_mysql, '$datetime', '1', 
						'Created $datetime', '0', '', 
						'0', '0', '0', 
						'', '', $inp_food_date_mysql, 
						$inp_food_time_mysql, $inp_food_last_viewed_mysql)")
						or die(mysqli_error($link));

						// Get food id
						$query = "SELECT food_id FROM $t_food_index WHERE food_name=$inp_food_name_mysql AND food_notes='Created $datetime'";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_food_id) = $row;

					

					
						// Copy image
						if($inp_food_image_path != ""){
						$dir_array = explode("/", $inp_food_image_path);
						$dir_array_size = sizeof($dir_array);

						if(!(is_dir("$root/$dir_array[0]"))){
							echo"<p>mkdir $root/$dir_array[0]</p>\n";
							mkdir("$root/$dir_array[0]");
						}
						if(!(is_dir("$root/$dir_array[0]/$dir_array[1]"))){
							echo"<p>mkdir $root/$dir_array[0]/$dir_array[1]</p>\n";
							mkdir("$root/$dir_array[0]/$dir_array[1]");
						}
						if(!(is_dir("$root/$dir_array[0]/$dir_array[1]/$dir_array[2]"))){
							echo"<p>mkdir $root/$dir_array[0]/$dir_array[1]/$dir_array[2]</p>\n";
							mkdir("$root/$dir_array[0]/$dir_array[1]/$dir_array[2]");
						}
						if(!(is_dir("$root/$dir_array[0]/$dir_array[1]/$dir_array[2]/$dir_array[3]"))){
							echo"<p>mkdir $root/$dir_array[0]/$dir_array[1]/$dir_array[2]/$dir_array[3]</p>\n";
							mkdir("$root/$dir_array[0]/$dir_array[1]/$dir_array[2]/$dir_array[3]");
						}
						if(!(is_dir("$root/$dir_array[0]/$dir_array[1]/$dir_array[2]/$dir_array[3]/$dir_array[4]"))){
							echo"<p>mkdir $root/$dir_array[0]/$dir_array[1]/$dir_array[2]/$dir_array[3]/$dir_array[4]</p>\n";
							mkdir("$root/$dir_array[0]/$dir_array[1]/$dir_array[2]/$dir_array[3]/$dir_array[4]");
						}
						if(!(is_dir("$root/$dir_array[0]/$dir_array[1]/$dir_array[2]/$dir_array[3]/$dir_array[4]/$dir_array[5]"))){
							echo"<p>mkdir $root/$dir_array[0]/$dir_array[1]/$dir_array[2]/$dir_array[3]/$dir_array[4]/$dir_array[5]</p>\n";
							mkdir("$root/$dir_array[0]/$dir_array[1]/$dir_array[2]/$dir_array[3]/$dir_array[4]/$dir_array[5]");
						}
	
						}
						if($inp_food_image_a != ""){
							copy("$get_integration_url/$inp_food_image_path/$inp_food_image_a", "$root/$inp_food_image_path/$inp_food_image_a");
							echo"<img src=\"$get_integration_url/$inp_food_image_path/$inp_food_image_a\" alt=\"$get_integration_url/$inp_food_image_path/$inp_food_image_a\" width=\"50\" height=\"50\" />\n";
						}
						if($inp_food_image_b != ""){
							copy("$get_integration_url/$inp_food_image_path/$inp_food_image_b", "$root/$inp_food_image_path/$inp_food_image_b");
						}
						if($inp_food_image_c != ""){
							copy("$get_integration_url/$inp_food_image_path/$inp_food_image_c", "$root/$inp_food_image_path/$inp_food_image_c");
						}
						if($inp_food_image_d != ""){
							copy("$get_integration_url/$inp_food_image_path/$inp_food_image_d", "$root/$inp_food_image_path/$inp_food_image_d");
						}
						if($inp_food_image_e != ""){
							copy("$get_integration_url/$inp_food_image_path/$inp_food_image_e", "$root/$inp_food_image_path/$inp_food_image_e");
						}


						// food tags
						$index_tags = $object['index_tags'];
						$index_tags_size = sizeof($index_tags);
						for($y=0;$y<$index_tags_size;$y++){
							$temp = $index_tags[$y];

							$inp_tag_id = $temp['tag_id'];
							$inp_tag_id = output_html($inp_tag_id);
							$inp_tag_id_mysql = quote_smart($link, $inp_tag_id);

							$inp_tag_language = $temp['tag_language'];
							$inp_tag_language = output_html($inp_tag_language);
							$inp_tag_language_mysql = quote_smart($link, $inp_tag_language);

							$inp_tag_food_id = $temp['tag_food_id'];
							$inp_tag_food_id = output_html($inp_tag_food_id);
							$inp_tag_food_id_mysql = quote_smart($link, $inp_tag_food_id);

							$inp_tag_title = $temp['tag_title'];
							$inp_tag_title = output_html($inp_tag_title);
							$inp_tag_title_mysql = quote_smart($link, $inp_tag_title);

							$inp_tag_title_clean = $temp['tag_title'];
							$inp_tag_title_clean = output_html($inp_tag_title_clean);
							$inp_tag_title_clean_mysql = quote_smart($link, $inp_tag_title_clean);

							$inp_tag_user_id = $temp['tag_user_id'];
							$inp_tag_user_id = output_html($inp_tag_user_id);
							$inp_tag_user_id_mysql = quote_smart($link, $inp_tag_user_id);
						

							mysqli_query($link, "INSERT INTO $t_food_index_tags 
							(tag_id, tag_language, tag_food_id, tag_title, tag_title_clean, tag_user_id) 
							VALUES 
							(NULL, $inp_tag_language_mysql, $get_food_id, $inp_tag_title_mysql, $inp_tag_title_clean_mysql, '1')")
							or die(mysqli_error($link));
						}

					} // doesnt exists
				} // for

			} // data != ""
			

			echo"
			</p>

		
		<!-- //Request -->

		<!-- Action -->
			";
			if($get_integration_last_on_server > $get_integration_last_downloaded){

				echo"
				<p>
				<a href=\"integrations.php?action=step_2_download&amp;integration_id=$get_integration_id&amp;l=$l&amp;datetime=$datetime\">$l_download</a>
				</p>
				<meta http-equiv=\"refresh\" content=\"2;url=integrations.php?action=step_2_download&amp;integration_id=$get_integration_id&amp;l=$l&amp;datetime=$datetime\" />
				";
			}
			else{

				// Update last downloaded
				$result = mysqli_query($link, "UPDATE $t_food_integration SET integration_last_downloaded='$get_integration_last_on_server' WHERE integration_id=$get_integration_id");
		

				echo"
				<p>
				<a href=\"integrations.php?ft=success&amp;fm=finished&amp;l=$l\">$l_integrations</a>
				</p>
				<meta http-equiv=\"refresh\" content=\"2;url=integrations.php?ft=success&amp;fm=finished&amp;l=$l\" />
				";
			}
			echo"
		<!-- //Action -->
		";
	}
}

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>