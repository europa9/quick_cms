<?php
/**
*
* File: food/edit_food_tags.php
* Version 1.0.0
* Date 13:03 03.02.2018
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


/*- Translations ---------------------------------------------------------------------- */
include("$root/_admin/_translations/site/$l/food/ts_view_food.php");
include("$root/_admin/_translations/site/$l/food/ts_edit_food.php");
include("$root/_admin/_translations/site/$l/food/ts_new_food.php");

/*- Variables ------------------------------------------------------------------------- */
$l_mysql = quote_smart($link, $l);


if(isset($_GET['food_id'])){
	$food_id = $_GET['food_id'];
	$food_id = strip_tags(stripslashes($food_id));
	$food_id_mysql = quote_smart($link, $food_id);
}
else{
	$food_id = "";
}



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
	$website_title = "$l_food - $get_food_name $get_food_manufacturer_name - $l_edit_tags";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");



	// My user
	if(isset($_SESSION['user_id'])){
		$my_user_id = $_SESSION['user_id'];
		$my_user_id_mysql = quote_smart($link, $my_user_id);

		if($get_food_user_id != "$my_user_id"){
			echo"
			<p>Access denied.</p>
			";
		}
		else{
			if($process == 1){
				// Delete all old tags
				$result = mysqli_query($link, "DELETE FROM $t_food_index_tags WHERE tag_food_id=$get_food_id");
				
				// Lang
				$inp_tag_language_mysql = quote_smart($link, $get_food_language);

				$inp_tag_a = $_POST['inp_tag_a'];
				$inp_tag_a = output_html($inp_tag_a);
				$inp_tag_a_mysql = quote_smart($link, $inp_tag_a);

				$inp_tag_a_clean = clean($inp_tag_a);
				$inp_tag_a_clean = strtolower($inp_tag_a);
				$inp_tag_a_clean_mysql = quote_smart($link, $inp_tag_a_clean);

				if($inp_tag_a != ""){
					// Insert
					mysqli_query($link, "INSERT INTO $t_food_index_tags 
					(tag_id, tag_language, tag_food_id, tag_title, tag_title_clean, tag_user_id) 
					VALUES 
					(NULL, $inp_tag_language_mysql, $get_food_id, $inp_tag_a_mysql, $inp_tag_a_clean_mysql, $my_user_id_mysql)")
					or die(mysqli_error($link));
				}

				$inp_tag_b = $_POST['inp_tag_b'];
				$inp_tag_b = output_html($inp_tag_b);
				$inp_tag_b_mysql = quote_smart($link, $inp_tag_b);

				$inp_tag_b_clean = clean($inp_tag_b);
				$inp_tag_b_clean = strtolower($inp_tag_b);
				$inp_tag_b_clean_mysql = quote_smart($link, $inp_tag_b_clean);

				if($inp_tag_b != ""){
					// Insert
					mysqli_query($link, "INSERT INTO $t_food_index_tags 
					(tag_id, tag_language, tag_food_id, tag_title, tag_title_clean, tag_user_id) 
					VALUES 
					(NULL, $inp_tag_language_mysql, $get_food_id, $inp_tag_b_mysql, $inp_tag_b_clean_mysql, $my_user_id_mysql)")
					or die(mysqli_error($link));
				}

				$inp_tag_c = $_POST['inp_tag_c'];
				$inp_tag_c = output_html($inp_tag_c);
				$inp_tag_c_mysql = quote_smart($link, $inp_tag_c);

				$inp_tag_c_clean = clean($inp_tag_c);
				$inp_tag_c_clean = strtolower($inp_tag_c);
				$inp_tag_c_clean_mysql = quote_smart($link, $inp_tag_c_clean);

				if($inp_tag_c != ""){
					// Insert
					mysqli_query($link, "INSERT INTO $t_food_index_tags 
					(tag_id, tag_language, tag_food_id, tag_title, tag_title_clean, tag_user_id) 
					VALUES 
					(NULL, $inp_tag_language_mysql, $get_food_id, $inp_tag_c_mysql, $inp_tag_c_clean_mysql, $my_user_id_mysql)")
					or die(mysqli_error($link));
				}




				// Header	
				$url = "edit_food_tags.php?food_id=$get_food_id&el=$l&ft=success&fm=changes_saved";
				header("Location: $url");
				exit;
				

			
			}


			echo"
			<h1>$get_food_manufacturer_name $get_food_name</h1>

			<!-- Where am I? -->
				<p>
				<a href=\"my_food.php?l=$l#food$get_food_id\">$l_my_food</a>
				&gt;
				<a href=\"view_food.php?food_id=$food_id&amp;l=$l\">$get_food_name</a>
				&gt;
				<a href=\"edit_food.php?food_id=$food_id&amp;l=$l\">$l_edit</a>
				&gt;
				<a href=\"edit_food_tags.php?food_id=$food_id&amp;l=$l\">$l_tags</a>
				</p>
			<!-- //Where am I? -->


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

			<!-- Tags -->
				<!-- Focus -->
				<script>
					\$(document).ready(function(){
						\$('[name=\"inp_tag_a\"]').focus();
					});
				</script>
				<!-- //Focus -->

				<form method=\"post\" action=\"edit_food_tags.php?food_id=$get_food_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">

				";

				// Fetch tags
				$y = 1;
				$query = "SELECT tag_id, tag_title FROM $t_food_index_tags WHERE tag_food_id=$get_food_id ORDER BY tag_id ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_tag_id, $get_tag_title) = $row;
				
					if($y == "1"){
						$name = "inp_tag_a";
					}
					elseif($y == "2"){
						$name = "inp_tag_b";
					}
					elseif($y == "3"){
						$name = "inp_tag_c";
					}
					echo"
					<p><b>$l_tag $y:</b><br />
					<input type=\"text\" name=\"$name\" value=\"$get_tag_title\" size=\"20\" /></p>
					";
					$y++;
				}
				
				
				if($y == 1){
					echo"
					<p><b>$l_tag 1:</b><br />
					<input type=\"text\" name=\"inp_tag_a\" value=\"\" size=\"20\" /></p>
					
					<p><b>$l_tag 2:</b><br />
					<input type=\"text\" name=\"inp_tag_b\" value=\"\" size=\"20\" /></p>
					
					<p><b>$l_tag 3:</b><br />
					<input type=\"text\" name=\"inp_tag_c\" value=\"\" size=\"20\" /></p>
					";

				}
				elseif($y == 2){
					echo"
					
					<p><b>$l_tag 2:</b><br />
					<input type=\"text\" name=\"inp_tag_b\" value=\"\" size=\"20\" /></p>
					
					<p><b>$l_tag 3:</b><br />
					<input type=\"text\" name=\"inp_tag_c\" value=\"\" size=\"20\" /></p>
					";

				}
				elseif($y == 3){
					echo"
					
					<p><b>$l_tag 3:</b><br />
					<input type=\"text\" name=\"inp_tag_c\" value=\"\" size=\"20\" /></p>
					";

				}
				echo"
				<p><input type=\"submit\" value=\"$l_save\" class=\"btn btn-success btn-sm\" /></p>
				
				</form>
			<!-- //General information -->
			<!-- Back -->
				<p>
				<a href=\"my_food.php?l=$l#food$get_food_id\" class=\"btn btn_default\">$l_my_food</a>
				</p>
			<!-- //Back -->

			";
		}
	}
	else{
		echo"<p>Please log in</p>";
	}
}
/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>