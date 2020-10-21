<?php 
/**
*
* File: food/new_food_5_numbers.php
* Version 1.0.0
* Date 23:59 27.11.2017
* Copyright (c) 2011-2017 Localhost
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
include("$root/_admin/_translations/site/$l/food/ts_food.php");
include("$root/_admin/_translations/site/$l/food/ts_new_food.php");


/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['mode'])){
	$mode = $_GET['mode'];
	$mode = output_html($mode);
}
else{
	$mode = "";
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
if(isset($_GET['food_id'])){
	$food_id = $_GET['food_id'];
	$food_id = strip_tags(stripslashes($food_id));
	$food_id_mysql = quote_smart($link, $food_id);
}
else{
	$food_id = "";
}




$tabindex = 0;
$l_mysql = quote_smart($link, $l);



// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);

	// Select food
	
	// Select food
	$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_country, food_net_content, food_net_content_measurement, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_fat, food_fat_of_which_saturated_fatty_acids, food_carbohydrates, food_carbohydrates_of_which_dietary_fiber, food_carbohydrates_of_which_sugars, food_proteins, food_salt, food_sodium, food_score, food_energy_calculated, food_fat_calculated, food_fat_of_which_saturated_fatty_acids_calculated, food_carbohydrates_calculated, food_carbohydrates_of_which_dietary_fiber_calculated, food_carbohydrates_of_which_sugars_calculated, food_proteins_calculated, food_salt_calculated, food_sodium_calculated, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_thumb_a_medium, food_thumb_a_large, food_image_b, food_thumb_b_small, food_thumb_b_medium, food_thumb_b_large, food_image_c, food_thumb_c_small, food_thumb_c_medium, food_thumb_c_large, food_image_d, food_thumb_d_small, food_thumb_d_medium, food_thumb_d_large, food_image_e, food_thumb_e_small, food_thumb_e_medium, food_thumb_e_large, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_created_date, food_last_viewed, food_age_restriction FROM $t_food_index WHERE food_id=$food_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_manufacturer_name_and_food_name, $get_food_description, $get_food_country, $get_food_net_content, $get_food_net_content_measurement, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_fat, $get_food_fat_of_which_saturated_fatty_acids, $get_food_carbohydrates, $get_food_carbohydrates_of_which_dietary_fiber, $get_food_carbohydrates_of_which_sugars, $get_food_proteins, $get_food_salt, $get_food_sodium, $get_food_score, $get_food_energy_calculated, $get_food_fat_calculated, $get_food_fat_of_which_saturated_fatty_acids_calculated, $get_food_carbohydrates_calculated, $get_food_carbohydrates_of_which_dietary_fiber_calculated, $get_food_carbohydrates_of_which_sugars_calculated, $get_food_proteins_calculated, $get_food_salt_calculated, $get_food_sodium_calculated, $get_food_barcode, $get_food_main_category_id, $get_food_sub_category_id, $get_food_image_path, $get_food_image_a, $get_food_thumb_a_small, $get_food_thumb_a_medium, $get_food_thumb_a_large, $get_food_image_b, $get_food_thumb_b_small, $get_food_thumb_b_medium, $get_food_thumb_b_large, $get_food_image_c, $get_food_thumb_c_small, $get_food_thumb_c_medium, $get_food_thumb_c_large, $get_food_image_d, $get_food_thumb_d_small, $get_food_thumb_d_medium, $get_food_thumb_d_large, $get_food_image_e, $get_food_thumb_e_small, $get_food_thumb_e_medium, $get_food_thumb_e_large, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block, $get_food_user_ip, $get_food_created_date, $get_food_last_viewed, $get_food_age_restriction) = $row;


	if($get_food_id == ""){
		/*- Headers ---------------------------------------------------------------------------------- */
		$website_title = "$l_food - Server error 404";
		if(file_exists("./favicon.ico")){ $root = "."; }
		elseif(file_exists("../favicon.ico")){ $root = ".."; }
		elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
		elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
		include("$root/_webdesign/header.php");


		echo"
		<h1>Food not found</h1>

		<p>
		Sorry, the food was not found.
		</p>

		<p>
		<a href=\"index.php\">Back</a>
		</p>
		";
	}
	else{


		/*- Headers ---------------------------------------------------------------------------------- */
		$website_title = "$l_food - $l_new_food - $get_food_name $get_food_manufacturer_name";
		if(file_exists("./favicon.ico")){ $root = "."; }
		elseif(file_exists("../favicon.ico")){ $root = ".."; }
		elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
		elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
		include("$root/_webdesign/header.php");

		/*- Content ---------------------------------------------------------------------------------- */

		// Process
		if($process == "1"){
			// per 100 
			$inp_food_energy = $_POST['inp_food_energy'];
			$inp_food_energy = output_html($inp_food_energy);
			$inp_food_energy = str_replace(",", ".", $inp_food_energy);
			$inp_food_energy_mysql = quote_smart($link, $inp_food_energy);
			if($inp_food_energy == ""){
				$ft = "error";
				$fm = "missing_energy";
			}

			$inp_food_fat = $_POST['inp_food_fat'];
			$inp_food_fat = output_html($inp_food_fat);
			$inp_food_fat = str_replace(",", ".", $inp_food_fat);
			$inp_food_fat_mysql = quote_smart($link, $inp_food_fat);
			if($inp_food_fat == ""){
				$ft = "error";
				$fm = "missing_fat";
			}

			$inp_food_fat_of_which_saturated_fatty_acids = $_POST['inp_food_fat_of_which_saturated_fatty_acids'];
			$inp_food_fat_of_which_saturated_fatty_acids = output_html($inp_food_fat_of_which_saturated_fatty_acids);
			$inp_food_fat_of_which_saturated_fatty_acids = str_replace(",", ".", $inp_food_fat_of_which_saturated_fatty_acids);
			$inp_food_fat_of_which_saturated_fatty_acids_mysql = quote_smart($link, $inp_food_fat_of_which_saturated_fatty_acids);
			if($inp_food_fat_of_which_saturated_fatty_acids == ""){
				$ft = "error";
				$fm = "missing_of_which_saturated_fatty_acid";
			}

			$inp_food_carbohydrates = $_POST['inp_food_carbohydrates'];
			$inp_food_carbohydrates = output_html($inp_food_carbohydrates);
			$inp_food_carbohydrates = str_replace(",", ".", $inp_food_carbohydrates);
			$inp_food_carbohydrates_mysql = quote_smart($link, $inp_food_carbohydrates);
			if($inp_food_carbohydrates == ""){
				$ft = "error";
				$fm = "missing_carbohydrates";
			}


			$inp_food_carbohydrates_of_which_dietary_fiber = $_POST['inp_food_carbohydrates_of_which_dietary_fiber'];
			$inp_food_carbohydrates_of_which_dietary_fiber = output_html($inp_food_carbohydrates_of_which_dietary_fiber);
			$inp_food_carbohydrates_of_which_dietary_fiber = str_replace(",", ".", $inp_food_carbohydrates_of_which_dietary_fiber);
			$inp_food_carbohydrates_of_which_dietary_fiber_mysql = quote_smart($link, $inp_food_carbohydrates_of_which_dietary_fiber);


			$inp_food_carbohydrates_of_which_sugars = $_POST['inp_food_carbohydrates_of_which_sugars'];
			$inp_food_carbohydrates_of_which_sugars = output_html($inp_food_carbohydrates_of_which_sugars);
			$inp_food_carbohydrates_of_which_sugars = str_replace(",", ".", $inp_food_carbohydrates_of_which_sugars);
			$inp_food_carbohydrates_of_which_sugars_mysql = quote_smart($link, $inp_food_carbohydrates_of_which_sugars);
			if($inp_food_carbohydrates_of_which_sugars == ""){
				$ft = "error";
				$fm = "missing_of_which_sugars";
			}



			$inp_food_proteins = $_POST['inp_food_proteins'];
			$inp_food_proteins = output_html($inp_food_proteins);
			$inp_food_proteins = str_replace(",", ".", $inp_food_proteins);
			$inp_food_proteins_mysql = quote_smart($link, $inp_food_proteins);
			if($inp_food_proteins == ""){
				$ft = "error";
				$fm = "missing_proteins";
			}


			$inp_food_salt = $_POST['inp_food_salt'];
			$inp_food_salt = output_html($inp_food_salt);
			$inp_food_salt = str_replace(",", ".", $inp_food_salt);
			$inp_food_salt_mysql = quote_smart($link, $inp_food_salt);
			if($inp_food_salt == ""){
				$ft = "error";
				$fm = "missing_salt";
			}

			// Sodium is 40 % of salt
			$inp_food_sodium = ($inp_food_salt*40)/100; // g
			$inp_food_sodium = $inp_food_sodium*1000; // mg
			$inp_food_sodium_mysql = quote_smart($link, $inp_food_sodium);



			// Calculated
			$inp_food_energy_calculated = round($inp_food_energy*$get_food_serving_size_gram/100, 0);
			$inp_food_fat_calculated = round($inp_food_fat*$get_food_serving_size_gram/100, 0);
			$inp_food_fat_of_which_saturated_fatty_acids_calculated = round($inp_food_fat_of_which_saturated_fatty_acids*$get_food_serving_size_gram/100, 0);
			$inp_food_carbohydrates_calculated = round($inp_food_carbohydrates*$get_food_serving_size_gram/100, 0);
			$inp_food_carbohydrates_of_which_dietary_fiber_calculated = round($inp_food_carbohydrates_of_which_dietary_fiber*$get_food_serving_size_gram/100, 0);
			$inp_food_carbohydrates_of_which_sugars_calculated = round($inp_food_carbohydrates_of_which_sugars*$get_food_serving_size_gram/100, 0);
			$inp_food_proteins_calculated = round($inp_food_proteins*$get_food_serving_size_gram/100, 0);
			$inp_food_salt_calculated = round($inp_food_salt*$get_food_serving_size_gram/100, 0);
			$inp_food_sodium_calculated = round($inp_food_sodium*$get_food_serving_size_gram/100, 0);
	
			// Score
			$inp_total = $inp_food_energy + $inp_food_fat + $inp_food_fat_of_which_saturated_fatty_acids + $inp_food_carbohydrates + $inp_food_carbohydrates_of_which_dietary_fiber + $inp_food_carbohydrates_of_which_sugars + $inp_food_proteins + $inp_food_salt;
			$inp_calculation = ($inp_food_energy * 1) + 
				     ($inp_food_fat * 13) +  
				     ($inp_food_fat_of_which_saturated_fatty_acids * 1) + 
				     ($inp_food_carbohydrates * 44) +
				     ($inp_food_carbohydrates_of_which_dietary_fiber * 1) +
				     ($inp_food_carbohydrates_of_which_sugars * 1) +
				     ($inp_food_proteins * 43) +
				     ($inp_food_salt * 1);

			if($inp_total == "0"){
				$inp_score = "0";
			}
			else{
				$inp_score = round($inp_calculation / $inp_total, 0);
			}
			$inp_score_mysql = quote_smart($link, $inp_score);


			if($ft == ""){	
				// Update
				$result = mysqli_query($link, "UPDATE $t_food_index SET food_energy=$inp_food_energy_mysql, 
food_fat=$inp_food_fat_mysql, 
food_fat_of_which_saturated_fatty_acids=$inp_food_fat_of_which_saturated_fatty_acids_mysql, 
food_carbohydrates=$inp_food_carbohydrates_mysql, 
food_carbohydrates_of_which_dietary_fiber=$inp_food_carbohydrates_of_which_dietary_fiber_mysql, 
food_carbohydrates_of_which_sugars=$inp_food_carbohydrates_of_which_sugars_mysql, 
food_proteins=$inp_food_proteins_mysql, 
food_salt=$inp_food_salt_mysql, 
food_sodium=$inp_food_sodium_mysql, 
food_score=$inp_score_mysql, 
food_energy_calculated='$inp_food_energy_calculated', 
food_fat_calculated='$inp_food_fat_calculated',
food_fat_of_which_saturated_fatty_acids_calculated='$inp_food_fat_of_which_saturated_fatty_acids_calculated',
food_carbohydrates_calculated='$inp_food_carbohydrates_calculated',
food_carbohydrates_of_which_dietary_fiber_calculated=$inp_food_carbohydrates_of_which_dietary_fiber_calculated, 
food_carbohydrates_of_which_sugars_calculated='$inp_food_carbohydrates_of_which_sugars_calculated',
food_proteins_calculated='$inp_food_proteins_calculated',
food_salt_calculated='$inp_food_salt_calculated',
food_sodium_calculated='$inp_food_sodium_calculated' WHERE food_id='$get_food_id'") or print(mysqli_error());


				// Header
				if($get_food_country == "United States"){
					$url = "new_food_6_serving_size_united_states.php?main_category_id=$main_category_id&sub_category_id=$sub_category_id&food_id=$get_food_id&el=$l";
					header("Location: $url");
					exit;
				}
				else{
					$url = "new_food_6_serving_size_other.php?main_category_id=$main_category_id&sub_category_id=$sub_category_id&food_id=$get_food_id&el=$l";
					header("Location: $url");
					exit;
				}
			}
			else{
				$url = "new_food_5_numbers_other.php?main_category_id=$main_category_id&sub_category_id=$sub_category_id&food_id=$get_food_id&l=$l";
				$url = $url . "&ft=$ft&fm=$fm";
				$url = $url . "&inp_food_energy=$inp_food_energy";
				$url = $url . "&inp_food_proteins=$inp_food_proteins";
				$url = $url . "&inp_food_carbohydrates=$inp_food_carbohydrates";
				$url = $url . "&inp_food_fat=$inp_food_fat";
				header("Location: $url");
				exit;
			}
		}


		echo"
		<h1>$get_food_manufacturer_name $get_food_name</h1>
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
					\$('[name=\"inp_food_energy\"]').focus();
				});
				</script>
			<!-- //Focus -->

			<form method=\"post\" action=\"new_food_5_numbers_other.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$food_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
			<h2>$l_numbers</h2>

			<!-- Food image -->
			";
				if(file_exists("$root/$get_food_image_path/$get_food_image_b") && $get_food_image_b != ""){
					echo"
					<span style=\"float: left;margin-right: 20px;\">
					<img src=\"$root/$get_food_image_path/$get_food_image_b\" alt=\"$root/$get_food_image_path/$get_food_image_b\" width=\"600\" height=\"600\" />
					</span>
					";
				}
			echo"
			<!-- //Food image -->


			<table class=\"hor-zebra\" style=\"width: 350px\">
			 <thead>
			  <tr>
			   <th scope=\"col\">
			   </th>
			   <th scope=\"col\" style=\"text-align: center;padding: 6px 4px 6px 4px;vertical-align: bottom;\">
				<span>$l_per_100</span>
			   </th>
			  </tr>
			 </thead>
			 <tbody>
			  <tr>
			   <td style=\"padding: 8px 4px 6px 8px;\">
				<span>$l_calories</span>
			   </td>
			  <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<span><input type=\"text\" name=\"inp_food_energy\" value=\"$get_food_energy\" size=\"3\" /></span>
			   </td>
			 </tr>
			  <tr>
			   <td style=\"padding: 8px 4px 6px 8px;\">
				<p style=\"margin:0;padding: 0px 0px 4px 0px;\">$l_fat:</p>
				<p style=\"margin:0;padding: 0;\">$l_dash_of_which_saturated_fatty_acids</p>
			   </td>
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_food_fat\" value=\"$get_food_fat\" size=\"3\" /><br /></p>
				<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_food_fat_of_which_saturated_fatty_acids\" value=\"$get_food_fat_of_which_saturated_fatty_acids\" size=\"3\" /></p>
			   </td>
			 </tr>
			 <tr>
		 	  <td style=\"padding: 8px 4px 6px 8px;\">
				<p style=\"margin:0;padding: 0px 0px 4px 0px;\">$l_carbs:</p>
				<p style=\"margin:0;padding: 0;\">$l_dash_of_which_sugars</p>
			   </td>
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<p style=\"margin:0;padding: 0px 0px 4px 0px;\"><input type=\"text\" name=\"inp_food_carbohydrates\" value=\"$get_food_carbohydrates\" size=\"3\" /></p>
				<p style=\"margin:0;padding: 0;\"><input type=\"text\" name=\"inp_food_carbohydrates_of_which_sugars\" value=\"$get_food_carbohydrates_of_which_sugars\" size=\"3\" /></p>
			   </td>
			  </tr>
			 <tr>
		 	  <td style=\"padding: 8px 4px 6px 8px;\">
				<p style=\"margin:0;padding: 0;\">$l_dietary_fiber:</p>
			   </td>
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<p style=\"margin:0px 0px 4px 0px;padding: 0;\"><input type=\"text\" name=\"inp_food_carbohydrates_of_which_dietary_fiber\" value=\"$get_food_carbohydrates_of_which_dietary_fiber\" size=\"3\" /></p>
			   </td>
			  </tr>
			  <tr>
			   <td style=\"padding: 8px 4px 6px 8px;\">
				<span>$l_protein:</span>
			   </td>
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<span><input type=\"text\" name=\"inp_food_proteins\" value=\"$get_food_proteins\" size=\"3\" /></span>
			   </td>
			  </tr>
			 </tr>
			  <tr>
			   <td style=\"padding: 8px 4px 6px 8px;\">
				<span>$l_salt_in_gram</span>
			   </td>
			   <td style=\"text-align: center;padding: 0px 4px 0px 4px;\">
				<span><input type=\"text\" name=\"inp_food_salt\" value=\"$get_food_salt\" size=\"3\" /></span>
			   </td>
			  </tr>
			 </tbody>
			</table>
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