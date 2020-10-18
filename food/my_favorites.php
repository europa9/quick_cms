<?php
/**
*
* File: _food/my_favorites.php
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


/*- Variables ------------------------------------------------------------------------- */
$l_mysql = quote_smart($link, $l);

if(isset($_GET['order_by'])) {
	$order_by = $_GET['order_by'];
	$order_by = strip_tags(stripslashes($order_by));
}
else{
	$order_by = "food_id";
}
if(isset($_GET['order_method'])) {
	$order_method = $_GET['order_method'];
	$order_method = strip_tags(stripslashes($order_method));
}
else{
	$order_method = "";
}

/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/food/ts_food.php");
include("$root/_admin/_translations/site/$l/food/ts_new_food.php");
include("$root/_admin/_translations/site/$l/food/ts_search.php");
include("$root/_admin/_translations/site/$l/food/ts_my_food.php");

/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_food - $l_my_food";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");




// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);

	echo"
	<!-- Headline -->
		<h1>$l_my_favorites</h1>
	<!-- //Headline -->

	<!-- Where am I ? -->
		<p><b>$l_you_are_here:</b><br />
		<a href=\"index.php?l=$l\">$l_food</a>
		&gt;
		<a href=\"my_favorites.php?l=$l\">$l_my_favorites</a>
		</p>
	<!-- //Where am I ? -->


	<!-- Menu -->
	<!-- //Menu -->



	<!-- My food -->
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span>$l_food</span>
		   </th>
		   <th scope=\"col\">
			<span>$l_per_hundred</span>
		   </th>
		   <th scope=\"col\">
			<span title=\"$l_unique_hits\">$l_unique</span>
		   </th>
		   <th scope=\"col\">
			<span>$l_rating</span>
		   </th>
		   <th scope=\"col\">
			<span>$l_actions</span>
		   </th>
		  </tr>
		</thead>
		<tbody>


		";
		// Set layout
		$x = 0;

		// Get food
		$query = "SELECT food_favorite_id, food_favorite_food_id, food_favorite_comment FROM $t_food_favorites WHERE food_favorite_user_id=$my_user_id_mysql";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_food_favorite_id, $get_food_favorite_food_id, $get_food_favorite_comment) = $row;
			


			$query_f = "SELECT food_id, food_user_id, food_name, food_manufacturer_name, food_description, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_fat, food_energy_calculated, food_proteins_calculated, food_carbohydrates_calculated, food_fat_calculated, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_image_a, food_thumb_a_small, food_thumb_a_medium, food_thumb_a_large, food_language, food_unique_hits, food_likes, food_dislikes FROM $t_food_index WHERE food_id=$get_food_favorite_food_id";
			$result_f = mysqli_query($link, $query_f);
			$row_f = mysqli_fetch_row($result_f);
			list($get_food_id, $get_food_user_id, $get_food_name, $get_food_manufacturer_name, $get_food_description, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_fat, $get_food_energy_calculated, $get_food_proteins_calculated, $get_food_carbohydrates_calculated, $get_food_fat_calculated, $get_food_barcode, $get_food_main_category_id, $get_food_sub_category_id, $get_food_image_path, $get_food_image_a, $get_food_thumb_a_small, $get_food_thumb_a_medium, $get_food_thumb_a_large, $get_food_language, $get_food_unique_hits, $get_food_likes, $get_food_dislikes) = $row_f;
	

			
			// Style
			if(isset($style) && $style == ""){
				$style = "odd";
			}
			else{
				$style = "";
			}

			// Rating
			$total_votes = $get_food_likes+$get_food_dislikes;
			$likes = round($total_votes*$get_food_likes/100, 0);

			echo"
			<tr>
			  <td class=\"$style\">
				 <table>
				  <tr>
				   <td style=\"padding-right: 10px;\">
					";
					if($get_food_image_a != ""){
						echo"<a href=\"$root/food/view_food.php?main_category_id=$get_food_main_category_id&amp;sub_category_id=$get_food_sub_category_id&amp;food_id=$get_food_id&amp;l=$get_food_language\"><img src=\"$root/$get_food_image_path/$get_food_thumb_a_small\" alt=\"$get_food_thumb_a_small\" /></a>";
					}
					echo"
				   </td>
				   <td>
					<a href=\"$root/food/view_food.php?main_category_id=$get_food_main_category_id&amp;sub_category_id=$get_food_sub_category_id&amp;food_id=$get_food_id&amp;l=$get_food_language\" class=\"recipe_open_category_a\">$get_food_manufacturer_name $get_food_name</a><br />
					$get_food_description
					</p>
				   </td>
				  </tr>
				 </table>
			
			  </td>
			  <td class=\"$style\" style=\"text-align: center;\">
				<table>
				 <tr>
				  <td style=\"padding-right: 10px;text-align: center;\">
					<span>$get_food_energy</span>
				  </td>
				  <td style=\"padding-right: 10px;text-align: center;\">
					<span>$get_food_fat</span>
				  </td>
				  <td style=\"padding-right: 10px;text-align: center;\">
					<span>$get_food_carbohydrates</span>
				  </td>
				  <td style=\"text-align: center;\">
					<span>$get_food_proteins</span>
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
			  </td>
			  <td class=\"$style\" style=\"text-align: center;\">
				<span>$get_food_unique_hits</span>
			  </td>
			  <td class=\"$style\" style=\"text-align: center;\">
				<span>$likes %</span>
			  </td>
			  <td class=\"$style\">
				<span>
				<a href=\"favorite_food_remove.php?food_id=$get_food_id&amp;l=$l&amp;process=1\">$l_remove</a>
				</span>
			 </td>
			</tr>
			";
		}

		echo"
		 </tbody>
		</table>
	";
	echo"
	<!-- //My food -->
	";

}
else{
	echo"

	<h1>
	<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/food/my_favorites.php\">

	<p>Please log in...</p>
	";
}

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>