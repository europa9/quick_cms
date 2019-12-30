<?php 
/**
*
* File: meal_plans/meal_plan_edit.php
* Version 1.0.0
* Date 12:05 10.02.2018
* Copyright (c) 2011-2018 S. A. Ditlefsen
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
include("$root/_admin/_translations/site/$l/meal_plans/ts_new_meal_plan.php");
include("$root/_admin/_translations/site/$l/meal_plans/ts_meal_plan_edit.php");

/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['meal_plan_id'])){
	$meal_plan_id = $_GET['meal_plan_id'];
	$meal_plan_id = output_html($meal_plan_id);
}
else{
	$meal_plan_id = "";
}
if(isset($_GET['entry_day_number'])){
	$entry_day_number = $_GET['entry_day_number'];
	$entry_day_number = output_html($entry_day_number);
}
else{
	$entry_day_number = "";
}
if(isset($_GET['entry_meal_number'])){
	$entry_meal_number = $_GET['entry_meal_number'];
	$entry_meal_number = output_html($entry_meal_number);
}
else{
	$entry_meal_number = "";
}

$tabindex = 0;
$l_mysql = quote_smart($link, $l);




/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_meal_plans - $l_edit_meal_plan";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */
// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
	// Get my user
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_user_id, $get_user_email, $get_user_name, $get_user_alias, $get_user_rank) = $row;

	// Get meal_plan
	$meal_plan_id_mysql = quote_smart($link, $meal_plan_id);
	$query = "SELECT meal_plan_id, meal_plan_user_id, meal_plan_language, meal_plan_title, meal_plan_title_clean, meal_plan_number_of_days, meal_plan_introduction, meal_plan_total_energy_without_training, meal_plan_total_fat_without_training, meal_plan_total_carb_without_training, meal_plan_total_protein_without_training, meal_plan_total_energy_with_training, meal_plan_total_fat_with_training, meal_plan_total_carb_with_training, meal_plan_total_protein_with_training, meal_plan_average_kcal_without_training, meal_plan_average_fat_without_training, meal_plan_average_carb_without_training, meal_plan_average_protein_without_training, meal_plan_average_kcal_with_training, meal_plan_average_fat_with_training, meal_plan_average_carb_with_training, meal_plan_average_protein_with_training, meal_plan_created, meal_plan_updated, meal_plan_user_ip, meal_plan_image_path, meal_plan_image_file, meal_plan_views, meal_plan_views_ip_block, meal_plan_likes, meal_plan_dislikes, meal_plan_rating, meal_plan_rating_ip_block, meal_plan_comments FROM $t_meal_plans WHERE meal_plan_id=$meal_plan_id_mysql AND meal_plan_user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_meal_plan_id, $get_current_meal_plan_user_id, $get_current_meal_plan_language, $get_current_meal_plan_title, $get_current_meal_plan_title_clean, $get_current_meal_plan_number_of_days, $get_current_meal_plan_introduction, $get_current_meal_plan_total_energy_without_training, $get_current_meal_plan_total_fat_without_training, $get_current_meal_plan_total_carb_without_training, $get_current_meal_plan_total_protein_without_training, $get_current_meal_plan_total_energy_with_training, $get_current_meal_plan_total_fat_with_training, $get_current_meal_plan_total_carb_with_training, $get_current_meal_plan_total_protein_with_training, $get_current_meal_plan_average_kcal_without_training, $get_current_meal_plan_average_fat_without_training, $get_current_meal_plan_average_carb_without_training, $get_current_meal_plan_average_protein_without_training, $get_current_meal_plan_average_kcal_with_training, $get_current_meal_plan_average_fat_with_training, $get_current_meal_plan_average_carb_with_training, $get_current_meal_plan_average_protein_with_training, $get_current_meal_plan_created, $get_current_meal_plan_updated, $get_current_meal_plan_user_ip, $get_current_meal_plan_image_path, $get_current_meal_plan_image_file, $get_current_meal_plan_views, $get_current_meal_plan_views_ip_block, $get_current_meal_plan_likes, $get_current_meal_plan_dislikes, $get_current_meal_plan_rating, $get_current_meal_plan_rating_ip_block, $get_current_meal_plan_comments) = $row;
	
	

	if($get_current_meal_plan_id == ""){
		echo"<p>Meal plan not found.</p>";
	}
	else{
		

		// Find entry
		$entry_id = $_GET['entry_id'];
		$entry_id = output_html($entry_id);
		$entry_id_mysql = quote_smart($link, $entry_id);
		$query = "SELECT entry_id, entry_meal_plan_id, entry_day_number, entry_meal_number, entry_weight, entry_food_id, entry_recipe_id, entry_name, entry_manufacturer_name, entry_serving_size, entry_serving_size_measurement, entry_energy_per_entry, entry_fat_per_entry, entry_carb_per_entry, entry_protein_per_entry, entry_text FROM $t_meal_plans_entries WHERE entry_id=$entry_id_mysql AND entry_meal_plan_id=$get_current_meal_plan_id";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_entry_id, $get_current_entry_meal_plan_id, $get_current_entry_day_number, $get_current_entry_meal_number, $get_current_entry_weight, $get_current_entry_food_id, $get_current_entry_recipe_id, $get_current_entry_name, $get_current_entry_manufacturer_name, $get_current_entry_serving_size, $get_current_entry_serving_size_measurement, $get_current_entry_energy_per_entry, $get_current_entry_fat_per_entry, $get_current_entry_carb_per_entry, $get_current_entry_protein_per_entry, $get_current_entry_text) = $row;
		if($get_current_entry_id == ""){
			echo"Entry not found";
		}
		else{
			if($get_current_entry_food_id != "0"){
				if($process == 1){
					
					$inp_entry_food_serving_size = $_POST['inp_entry_food_serving_size'];
					$inp_entry_food_serving_size = output_html($inp_entry_food_serving_size);
					$inp_entry_food_serving_size = str_replace(",", ".", $inp_entry_food_serving_size);
					$inp_entry_food_serving_size_mysql = quote_smart($link, $inp_entry_food_serving_size);
					if($inp_entry_food_serving_size == ""){
						$url = "meal_plan_edit_edit_entry.php?meal_plan_id=$meal_plan_id&entry_day_number=$entry_day_number&entry_meal_number=$entry_meal_number&l=$l&action=$action&entry_id=$entry_id";
						$url = $url . "&ft=error&fm=missing_amount";
						header("Location: $url");
						exit;
					}

				
					// get food
					$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_store, food_description, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_fat, food_energy_calculated, food_proteins_calculated, food_carbohydrates_calculated, food_fat_calculated, food_barcode, food_category_id, food_image_path, food_thumb, food_image_a, food_image_b, food_image_c, food_image_d, food_image_e, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block FROM $t_diet_food WHERE food_id=$get_current_entry_food_id";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_store, $get_food_description, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_fat, $get_food_energy_calculated, $get_food_proteins_calculated, $get_food_carbohydrates_calculated, $get_food_fat_calculated, $get_food_barcode, $get_food_category_id, $get_food_image_path, $get_food_thumb, $get_food_image_a, $get_food_image_b, $get_food_image_c, $get_food_image_d, $get_food_image_e, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block) = $row;

					if($get_food_id == ""){
						$url = "meal_plan_edit_edit_entry.php?meal_plan_id=$meal_plan_id&entry_day_number=$entry_day_number&entry_meal_number=$entry_meal_number&l=$l&action=$action&entry_id=$entry_id";
						$url = $url . "&ft=error&fm=food_not_found__maby_its_deleted";
						header("Location: $url");
						exit;
					}
				
					$inp_entry_food_name = output_html($get_food_name);
					$inp_entry_food_name_mysql = quote_smart($link, $inp_entry_food_name);

					$inp_entry_food_manufacturer_name = output_html($get_food_manufacturer_name);
					$inp_entry_food_manufacturer_name_mysql = quote_smart($link, $inp_entry_food_manufacturer_name);

					// Gram or pcs?
					if (isset($_POST['inp_submit_gram'])) {
						// Gram

						$inp_entry_food_serving_size_measurement = output_html($get_food_serving_size_gram_measurement);
						$inp_entry_food_serving_size_measurement_mysql = quote_smart($link, $inp_entry_food_serving_size_measurement);

						$inp_entry_energy_per_entry = round(($inp_entry_food_serving_size*$get_food_energy)/100, 1);
						$inp_entry_energy_per_entry_mysql = quote_smart($link, $inp_entry_energy_per_entry);

						$inp_entry_food_fat_per_entry = round(($inp_entry_food_serving_size*$get_food_fat)/100, 1);
						$inp_entry_food_fat_per_entry_mysql = quote_smart($link, $inp_entry_food_fat_per_entry);

						$inp_entry_carb_per_entry = round(($inp_entry_food_serving_size*$get_food_carbohydrates)/100, 1);
						$inp_entry_carb_per_entry_mysql = quote_smart($link, $inp_entry_carb_per_entry);

						$inp_entry_food_protein_per_entry = round(($inp_entry_food_serving_size*$get_food_proteins)/100, 1);
						$inp_entry_food_protein_per_entry_mysql = quote_smart($link, $inp_entry_food_protein_per_entry);

					}
					else{
						// PCS
						$inp_entry_food_serving_size_measurement = output_html($get_food_serving_size_pcs_measurement);
						$inp_entry_food_serving_size_measurement_mysql = quote_smart($link, $inp_entry_food_serving_size_measurement);

						$inp_entry_energy_per_entry = round(($inp_entry_food_serving_size*$get_food_energy_calculated)/$get_food_serving_size_pcs, 1);
						$inp_entry_energy_per_entry_mysql = quote_smart($link, $inp_entry_energy_per_entry);

						$inp_entry_food_fat_per_entry = round(($inp_entry_food_serving_size*$get_food_fat_calculated)/$get_food_serving_size_pcs, 1);
						$inp_entry_food_fat_per_entry_mysql = quote_smart($link, $inp_entry_food_fat_per_entry);

						$inp_entry_carb_per_entry = round(($inp_entry_food_serving_size*$get_food_carbohydrates_calculated)/$get_food_serving_size_pcs, 1);
						$inp_entry_carb_per_entry_mysql = quote_smart($link, $inp_entry_carb_per_entry);

						$inp_entry_food_protein_per_entry = round(($inp_entry_food_serving_size*$get_food_proteins_calculated)/$get_food_serving_size_pcs, 1);
						$inp_entry_food_protein_per_entry_mysql = quote_smart($link, $inp_entry_food_protein_per_entry);
					}


					// Update
					$result = mysqli_query($link, "UPDATE $t_meal_plans_entries SET entry_name=$inp_entry_food_name_mysql, entry_manufacturer_name=$inp_entry_food_manufacturer_name_mysql, 
									entry_serving_size=$inp_entry_food_serving_size_mysql, entry_serving_size_measurement=$inp_entry_food_serving_size_measurement_mysql, 
									entry_energy_per_entry=$inp_entry_energy_per_entry_mysql, entry_fat_per_entry=$inp_entry_food_fat_per_entry_mysql, 
									entry_carb_per_entry=$inp_entry_carb_per_entry_mysql, entry_protein_per_entry=$inp_entry_food_protein_per_entry_mysql WHERE entry_id='$get_current_entry_id'");
 
				


					$url = "meal_plan_edit.php?meal_plan_id=$meal_plan_id&entry_day_number=$entry_day_number&entry_meal_number=$entry_meal_number&l=$l";
					$url = $url . "&ft=success&fm=changes_saved";
					header("Location: $url");
					exit;
				}
				echo"
				<h1>$get_current_meal_plan_title</h1>
	

				<!-- Days of the week -->
				<div class=\"left\" style=\"width: 15%;margin-right: 20px;\">
					<table class=\"hor-zebra\">
					 <tbody>
					  <tr>
					   <td style=\"paddding: 0px 0px 0px 0px;margin: 0px 0px 0px 0px;\">
						<p style=\"paddding: 0px 0px 0px 0px;margin: 0px 0px 0px 0px;\">
						<a href=\"meal_plan_edit.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=1&amp;l=$l&amp;\""; if($entry_day_number == "1"){ echo" style=\"font-weight: bold;\""; } echo">$l_monday</a><br />
						<a href=\"meal_plan_edit.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=2&amp;l=$l&amp;\""; if($entry_day_number == "2"){ echo" style=\"font-weight: bold;\""; } echo">$l_tuesday</a><br />
						<a href=\"meal_plan_edit.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=3&amp;l=$l&amp;\""; if($entry_day_number == "3"){ echo" style=\"font-weight: bold;\""; } echo">$l_wednesday</a><br />
						<a href=\"meal_plan_edit.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=4&amp;l=$l&amp;\""; if($entry_day_number == "4"){ echo" style=\"font-weight: bold;\""; } echo">$l_thursday</a><br />
						<a href=\"meal_plan_edit.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=5&amp;l=$l&amp;\""; if($entry_day_number == "5"){ echo" style=\"font-weight: bold;\""; } echo">$l_friday</a><br />
						<a href=\"meal_plan_edit.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=6&amp;l=$l&amp;\""; if($entry_day_number == "6"){ echo" style=\"font-weight: bold;\""; } echo">$l_saturday</a><br />
						<a href=\"meal_plan_edit.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=7&amp;l=$l&amp;\""; if($entry_day_number == "7"){ echo" style=\"font-weight: bold;\""; } echo">$l_sunday</a><br />
						</p>
					   </td>
					  </tr>
					 </tbody>
					</table>
				</div>
				<!-- //Days of the week -->

				<!-- Current day -->
				<div class=\"right\" style=\"width: 82%;\">
				";
				if($entry_day_number > 0 && $entry_day_number < 8){
					if($entry_day_number == "1"){
						echo"<h2>$l_monday</h2>";
					}
					elseif($entry_day_number == "2"){
						echo"<h2>$l_tuesday</h2>";
					}
					elseif($entry_day_number == "3"){
						echo"<h2>$l_wednesday</h2>";
					}
					elseif($entry_day_number == "4"){
						echo"<h2>$l_thursday</h2>";
					}
					elseif($entry_day_number == "5"){
						echo"<h2>$l_friday</h2>";
					}
					elseif($entry_day_number == "6"){
						echo"<h2>$l_saturday</h2>";
					}
					elseif($entry_day_number == "7"){
						echo"<h2>$l_sunday</h2>";
					}
					echo"
				
					<!-- Feedback -->
						";
						if($ft != ""){
							if($fm == "changes_saved"){
								$fm = "$l_changes_saved";
							}
							else{
								$fm = ucfirst($fm);
							}
							echo"<div class=\"$ft\"><span>$fm</span></div>";
						}
						echo"	
					<!-- //Feedback -->


					
					<!-- About -->
						";
						// get food
						$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_store, food_description, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_fat, food_energy_calculated, food_proteins_calculated, food_carbohydrates_calculated, food_fat_calculated, food_barcode, food_category_id, food_image_path, food_thumb, food_image_a, food_image_b, food_image_c, food_image_d, food_image_e, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block FROM $t_diet_food WHERE food_id=$get_current_entry_food_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_store, $get_food_description, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_fat, $get_food_energy_calculated, $get_food_proteins_calculated, $get_food_carbohydrates_calculated, $get_food_fat_calculated, $get_food_barcode, $get_food_category_id, $get_food_image_path, $get_food_thumb, $get_food_image_a, $get_food_image_b, $get_food_image_c, $get_food_image_d, $get_food_image_e, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block) = $row;

						echo"

							<div style=\"float: left;\">
								<h2>
								$get_food_manufacturer_name $get_food_name
								</h2>

								<!-- Numbers -->

							<table style=\"width: 350px\">
							 <thead>
							  <tr>
							   <th scope=\"col\">
							   </th>
							   <th scope=\"col\" style=\"text-align: center;padding: 8px 4px 8px 4px;\">
								<span style=\"font-weight: normal;\">$l_energy</span>
							   </th>
							   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;\">
								<span style=\"font-weight: normal;\">$l_proteins</span>
							   </th>
							   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;\">
								<span style=\"font-weight: normal;\">$l_carbs</span>
							   </th>
							   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;\">
								<span style=\"font-weight: normal;\">$l_fat</span>
							   </th>
							  </tr>
							 </thead>
							 <tbody>
							  <tr>
							   <td style=\"text-align: right;padding: 8px 4px 6px 8px;\">
								<span>$l_per_100:</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_food_energy</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_food_proteins</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_food_carbohydrates</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_food_fat</span>
							  </td>
							 </tr>
							  <tr>
							   <td style=\"text-align: right;padding: 8px 4px 6px 8px;\">
								<span>$l_serving:</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_food_energy_calculated</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_food_proteins_calculated</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_food_carbohydrates_calculated</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_food_fat_calculated</span>
							   </td>
							  </tr>
							 </tbody>
							</table>
							<!-- //Numbers -->

						</div>
						";
						if($get_food_id != ""){
							// 845/4 = 211
							if(file_exists("$root/$get_food_image_path/$get_food_image_a")){
				
								echo"
								<div style=\"float: left;padding-left: 15px;\">
									<img src=\"$root/image.php?width=200&height=200&image=/$get_food_image_path/$get_food_image_a\" alt=\"$get_food_image_a\" />
								</div>";
							}
						}
						echo"
					<!-- //About -->


					<!-- Edit form -->
						<div class=\"clear\"></div>
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_entry_food_serving_size\"]').focus();
						});
						</script>
		
						<form method=\"post\" action=\"meal_plan_edit_edit_entry.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=$entry_day_number&amp;entry_meal_number=$entry_meal_number&amp;l=$l&amp;action=edit_entry&amp;entry_id=$entry_id&amp;process=1\" enctype=\"multipart/form-data\">
						
							<p><b>$l_meal</b><br />";
							if($entry_meal_number == 0){
								echo"$l_breakfast ";
							}
							elseif($entry_meal_number == 1){
								echo"$l_lunch";
							}
							elseif($entry_meal_number == 2){
								echo"$l_before_training  ";
							}
							elseif($entry_meal_number == 3){
								echo"$l_after_training ";
							}
							elseif($entry_meal_number == 4){
								echo"$l_dinnar";
							}
							elseif($entry_meal_number == 5){
								echo"$l_snacks";
							}
							elseif($entry_meal_number == 6){
								echo"$l_supper ";
							}
							else{
								echo"x out of range";
							}
							echo"</p>
							<p>
							<b>$l_amount:</b><br />
							<input type=\"text\" name=\"inp_entry_food_serving_size\" value=\"$get_current_entry_serving_size\" size=\"3\" />
							$get_food_serving_size_pcs_measurement
							

							<input type=\"submit\" name=\"inp_submit_gram\" value=\"$get_food_serving_size_gram_measurement\" class=\"btn btn_default\" />
							";
							if($get_food_serving_size_pcs_measurement != "g"){
								echo"<input type=\"submit\" name=\"inp_submit_pcs\" value=\"$get_food_serving_size_pcs_measurement\" class=\"btn btn_default\" />";
							}
							echo"</p>
						</form>
					<!-- //Edit form -->
					";


				}
				echo"
				</div>
				<!-- //Current day -->
				";
			} // food
			else{
				if($process == 1){
					
					$inp_entry_serving_size = $_POST['inp_entry_serving_size'];
					$inp_entry_serving_size = output_html($inp_entry_serving_size);
					$inp_entry_serving_size = str_replace(",", ".", $inp_entry_serving_size);
					$inp_entry_serving_size_mysql = quote_smart($link, $inp_entry_serving_size);
					if($inp_entry_serving_size == ""){
						$url = "meal_plan_edit_edit_entry.php?meal_plan_id=$meal_plan_id&entry_day_number=$entry_day_number&entry_meal_number=$entry_meal_number&l=$l&action=$action&entry_id=$entry_id";
						$url = $url . "&ft=error&fm=missing_amount";
						header("Location: $url");
						exit;
					}

				
					$recipe_id_mysql = quote_smart($link, $get_current_entry_recipe_id);
					$query = "SELECT recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password FROM $t_recipes WHERE recipe_id=$recipe_id_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_recipe_id, $get_recipe_user_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_language, $get_recipe_introduction, $get_recipe_directions, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb, $get_recipe_video, $get_recipe_date, $get_recipe_time, $get_recipe_cusine_id, $get_recipe_season_id, $get_recipe_occasion_id, $get_recipe_marked_as_spam, $get_recipe_unique_hits, $get_recipe_unique_hits_ip_block, $get_recipe_user_ip, $get_recipe_notes, $get_recipe_password) = $row;
					if($get_recipe_id == ""){
						$url = "meal_plan_edit_new_entry_recipe.php?meal_plan_id=$meal_plan_id&entry_day_number=$entry_day_number&entry_meal_number=$entry_meal_number&l=$l&action=new_entry_food";
						$url = $url . "&ft=error&fm=recipe_specified_not_found";
						header("Location: $url");
						exit;
					}

					// get numbers
					$query = "SELECT number_id, number_recipe_id, number_hundred_calories, number_hundred_proteins, number_hundred_fat, number_hundred_carbs, number_serving_calories, number_serving_proteins, number_serving_fat, number_serving_carbs, number_total_weight, number_total_calories, number_total_proteins, number_total_fat, number_total_carbs, number_servings FROM $t_recipes_numbers WHERE number_recipe_id=$recipe_id_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_number_id, $get_number_recipe_id, $get_number_hundred_calories, $get_number_hundred_proteins, $get_number_hundred_fat, $get_number_hundred_carbs, $get_number_serving_calories, $get_number_serving_proteins, $get_number_serving_fat, $get_number_serving_carbs, $get_number_total_weight, $get_number_total_calories, $get_number_total_proteins, $get_number_total_fat, $get_number_total_carbs, $get_number_servings) = $row;

					$inp_entry_name = output_html($get_recipe_title);
					$inp_entry_name_mysql = quote_smart($link, $inp_entry_name);

					$inp_entry_manufacturer_name = output_html("");
					$inp_entry_manufacturer_name_mysql = quote_smart($link, $inp_entry_manufacturer_name);

					if($entry_serving_size == "1"){
						$inp_entry_serving_size_measurement = output_html(strtolower($l_serving_abbreviation));
					}
					else{
						$inp_entry_serving_size_measurement = output_html(strtolower($l_servings_abbreviation));
					}
					$inp_entry_serving_size_measurement_mysql = quote_smart($link, $inp_entry_serving_size_measurement);

					$inp_entry_energy_per_entry = round($inp_entry_serving_size*$get_number_serving_calories, 1);
					$inp_entry_energy_per_entry_mysql = quote_smart($link, $inp_entry_energy_per_entry);

					$inp_entry_fat_per_entry = round($inp_entry_serving_size*$get_number_serving_fat, 1);
					$inp_entry_fat_per_entry_mysql = quote_smart($link, $inp_entry_fat_per_entry);

					$inp_entry_carb_per_entry = round($inp_entry_serving_size*$get_number_serving_carbs, 1);
					$inp_entry_carb_per_entry_mysql = quote_smart($link, $inp_entry_carb_per_entry);

					$inp_entry_protein_per_entry = round($inp_entry_serving_size*$get_number_serving_proteins, 1);
					$inp_entry_protein_per_entry_mysql = quote_smart($link, $inp_entry_protein_per_entry);



					// Update
					$result = mysqli_query($link, "UPDATE $t_meal_plans_entries SET entry_name=$inp_entry_name_mysql, entry_manufacturer_name=$inp_entry_manufacturer_name_mysql, 
									entry_serving_size=$inp_entry_serving_size_mysql, entry_serving_size_measurement=$inp_entry_serving_size_measurement_mysql, 
									entry_energy_per_entry=$inp_entry_energy_per_entry_mysql, entry_fat_per_entry=$inp_entry_fat_per_entry_mysql, 
									entry_carb_per_entry=$inp_entry_carb_per_entry_mysql, entry_protein_per_entry=$inp_entry_protein_per_entry_mysql 
									WHERE entry_id='$get_current_entry_id'");
 
				


					$url = "meal_plan_edit.php?meal_plan_id=$meal_plan_id&entry_day_number=$entry_day_number&entry_meal_number=$entry_meal_number&l=$l";
					$url = $url . "&ft=success&fm=changes_saved";
					header("Location: $url");
					exit;
				}
				echo"
				<h1>$get_current_meal_plan_title</h1>
	

				<!-- Days of the week -->
				<div class=\"left\" style=\"width: 15%;margin-right: 20px;\">
					<table class=\"hor-zebra\">
					 <tbody>
					  <tr>
					   <td style=\"paddding: 0px 0px 0px 0px;margin: 0px 0px 0px 0px;\">
						<p style=\"paddding: 0px 0px 0px 0px;margin: 0px 0px 0px 0px;\">
						<a href=\"meal_plan_edit.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=1&amp;l=$l&amp;\""; if($entry_day_number == "1"){ echo" style=\"font-weight: bold;\""; } echo">$l_monday</a><br />
						<a href=\"meal_plan_edit.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=2&amp;l=$l&amp;\""; if($entry_day_number == "2"){ echo" style=\"font-weight: bold;\""; } echo">$l_tuesday</a><br />
						<a href=\"meal_plan_edit.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=3&amp;l=$l&amp;\""; if($entry_day_number == "3"){ echo" style=\"font-weight: bold;\""; } echo">$l_wednesday</a><br />
						<a href=\"meal_plan_edit.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=4&amp;l=$l&amp;\""; if($entry_day_number == "4"){ echo" style=\"font-weight: bold;\""; } echo">$l_thursday</a><br />
						<a href=\"meal_plan_edit.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=5&amp;l=$l&amp;\""; if($entry_day_number == "5"){ echo" style=\"font-weight: bold;\""; } echo">$l_friday</a><br />
						<a href=\"meal_plan_edit.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=6&amp;l=$l&amp;\""; if($entry_day_number == "6"){ echo" style=\"font-weight: bold;\""; } echo">$l_saturday</a><br />
						<a href=\"meal_plan_edit.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=7&amp;l=$l&amp;\""; if($entry_day_number == "7"){ echo" style=\"font-weight: bold;\""; } echo">$l_sunday</a><br />
						</p>
					   </td>
					  </tr>
					 </tbody>
					</table>
				</div>
				<!-- //Days of the week -->

				<!-- Current day -->
				<div class=\"right\" style=\"width: 82%;\">
				";
				if($entry_day_number > 0 && $entry_day_number < 8){
					if($entry_day_number == "1"){
						echo"<h2>$l_monday</h2>";
					}
					elseif($entry_day_number == "2"){
						echo"<h2>$l_tuesday</h2>";
					}
					elseif($entry_day_number == "3"){
						echo"<h2>$l_wednesday</h2>";
					}
					elseif($entry_day_number == "4"){
						echo"<h2>$l_thursday</h2>";
					}
					elseif($entry_day_number == "5"){
						echo"<h2>$l_friday</h2>";
					}
					elseif($entry_day_number == "6"){
						echo"<h2>$l_saturday</h2>";
					}
					elseif($entry_day_number == "7"){
						echo"<h2>$l_sunday</h2>";
					}
					echo"
				
					<!-- Feedback -->
						";
						if($ft != ""){
							if($fm == "changes_saved"){
								$fm = "$l_changes_saved";
							}
							else{
								$fm = ucfirst($fm);
							}
							echo"<div class=\"$ft\"><span>$fm</span></div>";
						}
						echo"	
					<!-- //Feedback -->


					
					<!-- About -->
						";
						// get recipe
						$query = "SELECT recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password FROM $t_recipes WHERE recipe_id=$get_current_entry_recipe_id";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_recipe_id, $get_recipe_user_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_language, $get_recipe_introduction, $get_recipe_directions, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb, $get_recipe_video, $get_recipe_date, $get_recipe_time, $get_recipe_cusine_id, $get_recipe_season_id, $get_recipe_occasion_id, $get_recipe_marked_as_spam, $get_recipe_unique_hits, $get_recipe_unique_hits_ip_block, $get_recipe_user_ip, $get_recipe_notes, $get_recipe_password) = $row;

						// get numbers
						$query = "SELECT number_id, number_recipe_id, number_hundred_calories, number_hundred_proteins, number_hundred_fat, number_hundred_carbs, number_serving_calories, number_serving_proteins, number_serving_fat, number_serving_carbs, number_total_weight, number_total_calories, number_total_proteins, number_total_fat, number_total_carbs, number_servings FROM $t_recipes_numbers WHERE number_recipe_id='$get_recipe_id'";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_number_id, $get_number_recipe_id, $get_number_hundred_calories, $get_number_hundred_proteins, $get_number_hundred_fat, $get_number_hundred_carbs, $get_number_serving_calories, $get_number_serving_proteins, $get_number_serving_fat, $get_number_serving_carbs, $get_number_total_weight, $get_number_total_calories, $get_number_total_proteins, $get_number_total_fat, $get_number_total_carbs, $get_number_servings) = $row;

						echo"

						<div style=\"float: left;\">
							<h2>$get_recipe_title</h2>

							<!-- Numbers -->

							<table style=\"width: 350px\">
							 <thead>
							  <tr>
							   <th scope=\"col\">
							   </th>
							   <th scope=\"col\" style=\"text-align: center;padding: 8px 4px 8px 4px;\">
								<span style=\"font-weight: normal;\">$l_energy</span>
							   </th>
							   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;\">
								<span style=\"font-weight: normal;\">$l_proteins</span>
							   </th>
							   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;\">
								<span style=\"font-weight: normal;\">$l_carbs</span>
							   </th>
							   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;\">
								<span style=\"font-weight: normal;\">$l_fat</span>
							   </th>
							  </tr>
							 </thead>
							 <tbody>
							  <tr>
							   <td style=\"text-align: right;padding: 8px 4px 6px 8px;\">
								<span>$l_serving:</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_number_serving_calories</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_number_serving_proteins</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_number_serving_carbs</span>
							   </td>
							   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
								<span>$get_number_serving_fat</span>
							   </td>
							  </tr>
							 </tbody>
							</table>
							<!-- //Numbers -->

						</div>
						";
						if($get_recipe_image != ""){
							// 845/4 = 211
							if(file_exists("$root/$get_recipe_image_path/$get_recipe_image")){
				
								echo"
								<div style=\"float: left;padding-left: 15px;\">
									<img src=\"$root/image.php?width=200&height=200&image=/$get_recipe_image_path/$get_recipe_image\" alt=\"$get_recipe_image_path/$get_recipe_image\" />
								</div>";
							}
						}
						echo"
					<!-- //About -->


					<!-- Edit form Recipe -->
						<div class=\"clear\"></div>
						<script>
						\$(document).ready(function(){
							\$('[name=\"inp_entry_food_serving_size\"]').focus();
						});
						</script>
		
						<form method=\"post\" action=\"meal_plan_edit_edit_entry.php?meal_plan_id=$meal_plan_id&amp;entry_day_number=$entry_day_number&amp;entry_meal_number=$entry_meal_number&amp;l=$l&amp;action=edit_entry&amp;entry_id=$entry_id&amp;process=1\" enctype=\"multipart/form-data\">
						
							<p><b>$l_meal</b><br />";
							if($entry_meal_number == 0){
								echo"$l_breakfast ";
							}
							elseif($entry_meal_number == 1){
								echo"$l_lunch";
							}
							elseif($entry_meal_number == 2){
								echo"$l_before_training  ";
							}
							elseif($entry_meal_number == 3){
								echo"$l_after_training ";
							}
							elseif($entry_meal_number == 4){
								echo"$l_dinnar";
							}
							elseif($entry_meal_number == 5){
								echo"$l_snacks";
							}
							elseif($entry_meal_number == 6){
								echo"$l_supper ";
							}
							else{
								echo"x out of range";
							}
							echo"</p>

							<p>
							<b>$l_amount:</b><br />
							<input type=\"text\" name=\"inp_entry_serving_size\" value=\"$get_current_entry_serving_size\" size=\"3\" />
							</p>

							<p>
							<input type=\"submit\" value=\"$l_save\" class=\"btn btn_default\" />
							</p>
						</form>
					<!-- //Edit form Recipe -->
					";


				}
				echo"
				</div>
				<!-- //Current day -->
				";

			} // recipe
		} // entry found
	} // meal plan found
}
else{
	echo"
	<h1>
	<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/index.php?page=login&amp;l=$l&amp;refer=$root/exercises/new_exercise.php\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>