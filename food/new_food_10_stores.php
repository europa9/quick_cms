<?php 
/**
*
* File: food/new_food_7_tags.php
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
	$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_country, food_net_content, food_net_content_measurement, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_fat, food_fat_of_which_saturated_fatty_acids, food_carbohydrates, food_carbohydrates_of_which_dietary_fiber, food_carbohydrates_of_which_sugars, food_proteins, food_salt, food_score, food_energy_calculated, food_fat_calculated, food_fat_of_which_saturated_fatty_acids_calculated, food_carbohydrates_calculated, food_carbohydrates_of_which_dietary_fiber_calculated, food_carbohydrates_of_which_sugars_calculated, food_proteins_calculated, food_salt_calculated, food_barcode, food_category_id, food_image_path, food_thumb_small, food_thumb_medium, food_thumb_large, food_image_a, food_image_b, food_image_c, food_image_d, food_image_e, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_date, food_time, food_last_viewed FROM $t_food_index WHERE food_id=$food_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_manufacturer_name_and_food_name, $get_food_description, $get_food_country, $get_food_net_content, $get_food_net_content_measurement, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_fat, $get_food_fat_of_which_saturated_fatty_acids, $get_food_carbohydrates, $get_food_carbohydrates_of_which_dietary_fiber, $get_food_carbohydrates_of_which_sugars, $get_food_proteins, $get_food_salt, $get_food_score, $get_food_energy_calculated, $get_food_fat_calculated, $get_food_fat_of_which_saturated_fatty_acids_calculated, $get_food_carbohydrates_calculated, $get_food_carbohydrates_of_which_dietary_fiber_calculated, $get_food_carbohydrates_of_which_sugars_calculated, $get_food_proteins_calculated, $get_food_salt_calculated, $get_food_barcode, $get_food_category_id, $get_food_image_path, $get_food_thumb_small, $get_food_thumb_medium, $get_food_thumb_large, $get_food_image_a, $get_food_image_b, $get_food_image_c, $get_food_image_d, $get_food_image_e, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block, $get_food_user_ip, $get_food_date, $get_food_time, $get_food_last_viewed) = $row;

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

		if($action == ""){
	
			// Process
			if($process == "1"){
				
				if(isset($_GET['store_id'])){
					$store_id = $_GET['store_id'];
					$store_id = strip_tags(stripslashes($store_id));
					$store_id_mysql = quote_smart($link, $store_id);

					// Fetch store
					$query = "SELECT store_id, store_user_id, store_name, store_country, store_language, store_website, store_logo FROM $t_food_stores WHERE store_id=$store_id_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_current_store_id, $get_current_store_user_id, $get_current_store_name, $get_current_store_country, $get_current_store_language, $get_current_store_website, $get_current_store_logo) = $row;
					if($get_current_store_id != ""){

						// Name
						$inp_name_mysql = quote_smart($link, $get_current_store_name);

						// Logo
						$inp_logo_mysql = quote_smart($link, $get_current_store_logo);

						// IP 
						$inp_my_ip = $_SERVER['REMOTE_ADDR'];
						$inp_my_ip = output_html($inp_my_ip);
						$inp_my_ip_mysql = quote_smart($link, $inp_my_ip);

						// Datetime (notes)
						$datetime = date("Y-m-d H:i:s");


						// Does the link exists?
						$query = "SELECT food_store_id FROM $t_food_index_stores WHERE food_store_food_id=$food_id_mysql AND food_store_store_id=$store_id_mysql";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($get_food_store_id) = $row;

						if($get_food_store_id == ""){
							// Insert
							mysqli_query($link, "INSERT INTO $t_food_index_stores
							(food_store_id, food_store_food_id, food_store_store_id, food_store_store_name, food_store_store_logo, food_store_user_id, food_store_user_ip, food_store_updated) 
							VALUES 
							(NULL, $food_id_mysql, $store_id_mysql, $inp_name_mysql, $inp_logo_mysql, $my_user_id_mysql, $inp_my_ip_mysql, '$datetime')") or die(mysqli_error($link));
						}
					} // Store found
				}
				

			
				$url = "new_food_10_stores.php?food_id=$get_food_id&l=$l&ft=success&fm=changes_saved";
				header("Location: $url");
				exit;
			}


			echo"
			<h1>$get_food_manufacturer_name $get_food_name</h1>
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

			<!-- Stores -->
				<p>$l_select_the_stores_where_you_can_purcase_the_food</p>
				
				<table>
				 <tr>
				  <td style=\"vertical-align: top;padding-right: 20px;\">
					<!-- Stores not selected -->
					<p><b>$l_available_stores:</b><br />";
					
					$query = "SELECT $t_food_stores.store_id, $t_food_stores.store_name FROM $t_food_stores WHERE $t_food_stores.store_language=$l_mysql ORDER BY $t_food_stores.store_name ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_store_id, $get_store_name) = $row;
						
						// Do I have it?
						$query_link = "SELECT food_store_id FROM $t_food_index_stores WHERE food_store_food_id=$food_id_mysql AND food_store_store_id=$get_store_id";
						$result_link = mysqli_query($link, $query_link);
						$row_link = mysqli_fetch_row($result_link);
						list($get_food_store_id) = $row_link;


						if($get_food_store_id == ""){
							echo"
							<a href=\"new_food_10_stores.php?food_id=$get_food_id&amp;store_id=$get_store_id&amp;l=$l&amp;process=1\">$get_store_name</a><br />
							";
						}
					}

					echo"
					<p>
					<!-- //Stores not selected -->
				  </td>
				  <td style=\"vertical-align: top;\">
					<p><b>$l_stores_where_you_can_buy_the_food:</b><br />";

					$query = "SELECT food_store_id, food_store_store_name FROM $t_food_index_stores WHERE food_store_food_id=$get_food_id ORDER BY food_store_store_name ASC";
					$result = mysqli_query($link, $query);
					while($row = mysqli_fetch_row($result)) {
						list($get_food_store_id, $get_food_store_store_name) = $row;

						echo"
						<a href=\"new_food_10_stores.php?action=remove_food_store&amp;food_id=$get_food_id&amp;food_store_id=$get_food_store_id&amp;l=$l&amp;process=1\">$get_food_store_store_name</a><br />
						";
					}


					echo"
					</p>
				  </td>
				 </tr>
				</table>
			<!-- //Stores -->

			<!-- New store -->
				<p>
				<a href=\"my_stores_new.php?l=$l\" class=\"btn_default\">$l_new_store</a>
				<a href=\"view_food.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$food_id&amp;l=$l\" class=\"btn_default\">$l_view_food</a>
				</p>
				
			<!-- //New store -->
	
			";
		} // action == ""
		elseif($action == "remove_food_store"){
			
			if(isset($_GET['food_store_id'])){
				$food_store_id = $_GET['food_store_id'];
				$food_store_id = strip_tags(stripslashes($food_store_id));
				$food_store_id_mysql = quote_smart($link, $food_store_id);



				// Fetch it
				$query = "SELECT food_store_id, food_store_user_id FROM $t_food_index_stores WHERE food_store_id=$food_store_id_mysql AND food_store_food_id=$food_id_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_food_store_id, $get_food_store_user_id) = $row;
				if($get_food_store_id != ""){
					if($get_food_store_user_id == "$my_user_id"){
						mysqli_query($link, "DELETE FROM $t_food_index_stores WHERE food_store_id=$get_food_store_id") or die(mysqli_error($link));

			
						$url = "new_food_10_stores.php?food_id=$get_food_id&l=$l&ft=success&fm=changes_saved";
						header("Location: $url");
						exit;
					}
					else{
						echo"403";
					}
				}
				else{
					echo"404";
				}

			}
		} // remove_food_store
	} // food found
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