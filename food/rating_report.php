<?php 
/**
*
* File: food/rating_report.php
* Version 1.0.0
* Date 11:51 01.11.2020
* Copyright (c) 2020 S. A. Ditlefsen
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
$t_food_liquidbase			= $mysqlPrefixSav . "food_liquidbase";

$t_food_categories		  	= $mysqlPrefixSav . "food_categories";
$t_food_categories_translations	  	= $mysqlPrefixSav . "food_categories_translations";
$t_food_index			 	= $mysqlPrefixSav . "food_index";
$t_food_index_stores		 	= $mysqlPrefixSav . "food_index_stores";
$t_food_index_ads		 	= $mysqlPrefixSav . "food_index_ads";
$t_food_index_tags		  	= $mysqlPrefixSav . "food_index_tags";
$t_food_index_prices		  	= $mysqlPrefixSav . "food_index_prices";
$t_food_index_contents		 	= $mysqlPrefixSav . "food_index_contents";
$t_food_index_ratings		 	= $mysqlPrefixSav . "food_index_ratings";
$t_food_stores		  	  	= $mysqlPrefixSav . "food_stores";
$t_food_prices_currencies	  	= $mysqlPrefixSav . "food_prices_currencies";
$t_food_favorites 		  	= $mysqlPrefixSav . "food_favorites";
$t_food_measurements	 	  	= $mysqlPrefixSav . "food_measurements";
$t_food_measurements_translations 	= $mysqlPrefixSav . "food_measurements_translations";
$t_food_countries_used	 	 	= $mysqlPrefixSav . "food_countries_used";
$t_food_integration	 	  	= $mysqlPrefixSav . "food_integration";
$t_food_age_restrictions 	 	= $mysqlPrefixSav . "food_age_restrictions";
$t_food_age_restrictions_accepted	= $mysqlPrefixSav . "food_age_restrictions_accepted";

$t_stats_comments_per_year	= $mysqlPrefixSav . "stats_comments_per_year";
$t_stats_comments_per_month	= $mysqlPrefixSav . "stats_comments_per_month";


/*- Variables ------------------------------------------------------------------------- */
$tabindex = 0;
$l_mysql = quote_smart($link, $l);



/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['rating_id'])){
	$rating_id = $_GET['rating_id'];
	$rating_id = output_html($rating_id);
}
else{
	$rating_id = "";
}

// Get rating
$rating_id_mysql = quote_smart($link, $rating_id);
$query = "SELECT rating_id, rating_food_id, rating_text, rating_by_user_id, rating_by_user_name, rating_by_user_image_path, rating_by_user_image_file, rating_by_user_image_thumb_60, rating_by_user_ip, rating_starts, rating_created, rating_created_saying, rating_created_timestamp, rating_updated, rating_updated_saying, rating_likes, rating_dislikes, rating_number_of_replies, rating_read_blog_owner, rating_reported, rating_reported_by_user_id, rating_reported_reason, rating_reported_checked FROM $t_food_index_ratings WHERE rating_id=$rating_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_rating_id, $get_current_rating_food_id, $get_current_rating_text, $get_current_rating_by_user_id, $get_current_rating_by_user_name, $get_current_rating_by_user_image_path, $get_current_rating_by_user_image_file, $get_current_rating_by_user_image_thumb_60, $get_current_rating_by_user_ip, $get_current_rating_starts, $get_current_rating_created, $get_current_rating_created_saying, $get_current_rating_created_timestamp, $get_current_rating_updated, $get_current_rating_updated_saying, $get_current_rating_likes, $get_current_rating_dislikes, $get_current_rating_number_of_replies, $get_current_rating_read_blog_owner, $get_current_rating_reported, $get_current_rating_reported_by_user_id, $get_current_rating_reported_reason, $get_current_rating_reported_checked) = $row;

if($get_current_rating_id == ""){
	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "$l_blog - 404";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");
	echo"<p>Comment not found.</p>";
}
else{
	// Get food
	$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_manufacturer_name_and_food_name, food_description, food_country, food_net_content, food_net_content_measurement, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_fat, food_fat_of_which_saturated_fatty_acids, food_carbohydrates, food_dietary_fiber, food_carbohydrates_of_which_sugars, food_proteins, food_salt, food_sodium, food_score, food_energy_calculated, food_fat_calculated, food_fat_of_which_saturated_fatty_acids_calculated, food_carbohydrates_calculated, food_dietary_fiber_calculated, food_carbohydrates_of_which_sugars_calculated, food_proteins_calculated, food_salt_calculated, food_sodium_calculated, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_thumb_a_medium, food_thumb_a_large, food_image_b, food_thumb_b_small, food_thumb_b_medium, food_thumb_b_large, food_image_c, food_thumb_c_small, food_thumb_c_medium, food_thumb_c_large, food_image_d, food_thumb_d_small, food_thumb_d_medium, food_thumb_d_large, food_image_e, food_thumb_e_small, food_thumb_e_medium, food_thumb_e_large, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block, food_user_ip, food_created_date, food_last_viewed, food_age_restriction FROM $t_food_index WHERE food_id=$get_current_rating_food_id";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_food_id, $get_current_food_user_id, $get_current_food_name, $get_current_food_clean_name, $get_current_food_manufacturer_name, $get_current_food_manufacturer_name_and_food_name, $get_current_food_description, $get_current_food_country, $get_current_food_net_content, $get_current_food_net_content_measurement, $get_current_food_serving_size_gram, $get_current_food_serving_size_gram_measurement, $get_current_food_serving_size_pcs, $get_current_food_serving_size_pcs_measurement, $get_current_food_energy, $get_current_food_fat, $get_current_food_fat_of_which_saturated_fatty_acids, $get_current_food_carbohydrates, $get_current_food_dietary_fiber, $get_current_food_carbohydrates_of_which_sugars, $get_current_food_proteins, $get_current_food_salt, $get_current_food_sodium, $get_current_food_score, $get_current_food_energy_calculated, $get_current_food_fat_calculated, $get_current_food_fat_of_which_saturated_fatty_acids_calculated, $get_current_food_carbohydrates_calculated, $get_current_food_dietary_fiber_calculated, $get_current_food_carbohydrates_of_which_sugars_calculated, $get_current_food_proteins_calculated, $get_current_food_salt_calculated, $get_current_food_sodium_calculated, $get_current_food_barcode, $get_current_food_main_category_id, $get_current_food_sub_category_id, $get_current_food_image_path, $get_current_food_image_a, $get_current_food_thumb_a_small, $get_current_food_thumb_a_medium, $get_current_food_thumb_a_large, $get_current_food_image_b, $get_current_food_thumb_b_small, $get_current_food_thumb_b_medium, $get_current_food_thumb_b_large, $get_current_food_image_c, $get_current_food_thumb_c_small, $get_current_food_thumb_c_medium, $get_current_food_thumb_c_large, $get_current_food_image_d, $get_current_food_thumb_d_small, $get_current_food_thumb_d_medium, $get_current_food_thumb_d_large, $get_current_food_image_e, $get_current_food_thumb_e_small, $get_current_food_thumb_e_medium, $get_current_food_thumb_e_large, $get_current_food_last_used, $get_current_food_language, $get_current_food_synchronized, $get_current_food_accepted_as_master, $get_current_food_notes, $get_current_food_unique_hits, $get_current_food_unique_hits_ip_block, $get_current_food_comments, $get_current_food_likes, $get_current_food_dislikes, $get_current_food_likes_ip_block, $get_current_food_user_ip, $get_current_food_created_date, $get_current_food_last_viewed, $get_current_food_age_restriction) = $row;


	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "$l_food - $get_current_food_manufacturer_name_and_food_name";
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");
	
	// Logged in?
	if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
		// Get my user
		$my_user_id = $_SESSION['user_id'];
		$my_user_id = output_html($my_user_id);
		$my_user_id_mysql = quote_smart($link, $my_user_id);
		$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_my_user_id, $get_my_user_email, $get_my_user_name, $get_my_user_alias, $get_my_user_rank) = $row;

		$query = "SELECT photo_id, photo_destination, photo_thumb_60 FROM $t_users_profile_photo WHERE photo_user_id=$my_user_id_mysql AND photo_profile_image='1'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_my_photo_id, $get_my_photo_destination, $get_my_photo_thumb_60) = $row;

		if($get_current_rating_reported == "1"){

			echo"
			<h1>$l_report_rating</h1>

			<!-- Where am I? -->
				<p>
				<b>$l_you_are_here:</b><br />
				<a href=\"$root/food/index.php?l=$l\">$l_food</a>
				&gt;
				<a href=\"$root/food/view_food.php?food_id=$get_current_food_id&amp;main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;l=$l\">$get_current_food_manufacturer_name_and_food_name</a>
				&gt;
				<a href=\"rating_report.php?rating_id=$get_current_rating_id&amp;l=$l\">$l_report_rating</a>
				</p>
			<!-- //Where am I? -->

			<p>
			$l_this_rating_is_already_reported.
			</p>
			";
		}
		else{
			if($process == "1"){
				$inp_text = $_POST['inp_text'];
				$inp_text = output_html($inp_text);
				$inp_text_mysql = quote_smart($link, $inp_text);

				if($inp_text == ""){
					$url = "rating_report.php?rating_id=$get_current_rating_id&l=$l&ft_rating=warning&fm_rating=missing_text";
					header("Location: $url");
					exit;
				} // no text 
				else{
					// Update
					mysqli_query($link, "UPDATE $t_food_index_ratings SET
							rating_reported=1,
							rating_reported_by_user_id=$get_my_user_id,
							rating_reported_reason=$inp_text_mysql,
							rating_reported_checked=0
							WHERE 
							rating_id=$get_current_rating_id")
							or die(mysqli_error($link));

					// Refresh site
					$url = "view_food.php?food_id=$get_current_food_id&main_category_id=$get_current_food_main_category_id&sub_category_id=$get_current_food_sub_category_id&l=$l&ft_rating=success&fm_rating=rating_reported#rating$get_current_rating_id";
					header("Location: $url");
					exit;
				} // text
			} // process == 1


			echo"
			<h1>$l_report_rating</h1>

			<!-- Where am I? -->
				<p>
				<b>$l_you_are_here:</b><br />
				<a href=\"$root/food/index.php?l=$l\">$l_food</a>
				&gt;
				<a href=\"$root/food/view_food.php?food_id=$get_current_food_id&amp;main_category_id=$get_current_food_main_category_id&amp;sub_category_id=$get_current_food_sub_category_id&amp;l=$l\">$get_current_food_manufacturer_name_and_food_name</a>
				&gt;
				<a href=\"rating_report.php?rating_id=$get_current_rating_id&amp;l=$l\">$l_report_rating</a>
				</p>
			<!-- //Where am I? -->
	
			<!-- View rating -->
			<p><b>$l_original_rating:</b></p>
			<table>
			 <tr>
			  <td style=\"vertical-align: top;padding-right: 10px;text-align:center;\">
				<p>
				";
				if(file_exists("$root/$get_current_rating_by_user_image_path/$get_current_rating_by_user_image_thumb_60") && $get_current_rating_by_user_image_thumb_60 != ""){

				
					echo"
					<a href=\"users/view_profile.php?user_id=$get_current_rating_by_user_id&amp;l=$l\"><img src=\"$root/$get_current_rating_by_user_image_path/$get_current_rating_by_user_image_thumb_60\" alt=\"$get_current_rating_by_user_image_thumb_60\" /></a>
					<br />
					";
				}
				echo"
				</p>
			  </td>
			  <td style=\"vertical-align: top;\">
				<p>
				<a href=\"users/view_profile.php?user_id=$get_current_rating_by_user_id&amp;l=$l\" style=\"font-weight: bold;\">$get_current_rating_by_user_name</a> 
				$get_current_rating_created_saying<br />
				</p>

				<p>
				$get_current_rating_text
				</p>
			  </td>
			 </tr>
			<!-- //View rating -->
	
			<!-- Reason to mark it as spam form -->

	 		 <tr>
			  <td colspan=\"2\">
				<p style=\"padding-top: 16px\"><b>$l_reason:</b></p>
			  </td>
			 </tr>
	 		 <tr>
			  <td style=\"vertical-align: top;padding-right: 10px;text-align:center;\">
				<p>
				";
				if(file_exists("$root/_uploads/users/images/$get_my_user_id/$get_my_photo_destination") && $get_my_photo_destination != ""){

					// Thumb
					if(!(file_exists("$root/_uploads/users/images/$get_my_user_id/$get_my_photo_thumb_60"))){
						resize_crop_image(60, 60, "$root/_uploads/users/images/$get_my_user_id/$get_my_photo_destination", "$root/_uploads/users/images/$get_my_user_id/$get_my_photo_thumb_60");
					}
					echo"
					<img src=\"$root/_uploads/users/images/$get_my_user_id/$get_my_photo_thumb_60\" alt=\"$get_my_photo_thumb_60\" />
					<br />
					";
				}
				echo"
				$get_my_user_name
				</p>
			  </td>
			  <td style=\"vertical-align: top;\">
				<script>
				\$(document).ready(function(){
					\$('[name=\"inp_text\"]').focus();
				});
				</script>
				<form method=\"post\" action=\"rating_report.php?rating_id=$get_current_rating_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
				<p>
				<textarea name=\"inp_text\" rows=\"5\" cols=\"80\"></textarea><br />
				<input type=\"submit\" value=\"$l_send_report\" class=\"btn_default\" />
				</p>
				</form>
			  </td>
			 </tr>
			</table>

			<!-- //Reason to mark it as spam form -->
			";
		} // not previously reported
	} // is logged in
	else{
		echo"<p>Not logged in.</p>";
	}
} // comment found


/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>