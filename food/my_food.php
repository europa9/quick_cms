<?php
/**
*
* File: _food/my_food.php
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
	$order_method = "DESC";
}

/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/food/ts_food.php");
include("$root/_admin/_translations/site/$l/food/ts_new_food.php");
include("$root/_admin/_translations/site/$l/food/ts_search.php");



/*- Functions ------------------------------------------------------------------------ */
	// Get extention
	function getExtension($str) {
		$i = strrpos($str,".");
		if (!$i) { return ""; } 
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l);
		return $ext;
	}



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
		<h1>$l_my_food</h1>
	<!-- //Headline -->

	<!-- Where am I ? -->
		<p><b>$l_you_are_here:</b><br />
		<a href=\"index.php?l=$l\">$l_food</a>
		&gt;
		<a href=\"my_food.php?l=$l\">$l_my_food</a>
		</p>
	<!-- //Where am I ? -->


	<!-- Menu -->
	<!-- //Menu -->



	<!-- Sorting -->
	<div style=\"float: right;\">
			<script>
			\$(function(){
				\$('#inp_order_by_select').on('change', function () {
					var url = \$(this).val();
					if (url) { // require a URL
 						window.location = url;
					}
					return false;
				});
				\$('#inp_order_method_select').on('change', function () {
					var url = \$(this).val();
					if (url) { // require a URL
 						window.location = url;
					}
					return false;
				});
			});
			</script>
		
        		<form method=\"get\" action=\"search.php\" enctype=\"multipart/form-data\">
			<p>
			<select name=\"inp_order_by\" id=\"inp_order_by_select\">
				<option value=\"my_food.php?l=$l\">- $l_order_by -</option>
				<option value=\"my_food.php?order_by=food_id&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_id" OR $order_by == ""){ echo" selected=\"selected\""; } echo">$l_date</option>
				<option value=\"my_food.php?order_by=food_name&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_name"){ echo" selected=\"selected\""; } echo">$l_name</option>
				<option value=\"my_food.php?order_by=food_unique_hits&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_unique_hits"){ echo" selected=\"selected\""; } echo">$l_unique_hits</option>
				<option value=\"my_food.php?order_by=food_energy&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_energy"){ echo" selected=\"selected\""; } echo">$l_calories</option>
				<option value=\"my_food.php?order_by=food_fat&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_fat"){ echo" selected=\"selected\""; } echo">$l_fat</option>
				<option value=\"my_food.php?order_by=food_carbohydrates&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_carbohydrates"){ echo" selected=\"selected\""; } echo">$l_carbs</option>
				<option value=\"my_food.php?order_by=food_proteins&amp;order_method=$order_method&amp;l=$l\""; if($order_by == "food_proteins"){ echo" selected=\"selected\""; } echo">$l_proteins</option>
			</select>
			<select name=\"inp_order_method\" id=\"inp_order_method_select\">
				<option value=\"my_food.php?order_by=$order_by&amp;order_method=asc&amp;l=$l\""; if($order_method == "asc"){ echo" selected=\"selected\""; } echo">$l_asc</option>
				<option value=\"my_food.php?order_by=$order_by&amp;order_method=desc&amp;l=$l\""; if($order_method == "desc" OR $order_method == ""){ echo" selected=\"selected\""; } echo">$l_desc</option>
			</select>
			</p>
        		</form>
	</div>
	<!-- //Sorting -->

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
		$query = "SELECT food_id, food_user_id, food_name, food_manufacturer_name, food_description, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_fat, food_energy_calculated, food_proteins_calculated, food_carbohydrates_calculated, food_fat_calculated, food_barcode, food_category_id, food_image_path, food_thumb_small, food_thumb_medium, food_thumb_large, food_image_a, food_language, food_unique_hits, food_likes, food_dislikes FROM $t_food_index WHERE food_user_id=$my_user_id_mysql AND food_language=$l_mysql";

		// Order
		if($order_by != ""){
			if($order_method == "asc"){
				$order_method_mysql = "ASC";
			}
			else{
				$order_method_mysql = "DESC";
			}

			if($order_by == "food_id" OR $order_by == "food_name" OR $order_by == "food_unique_hits"){
				$order_by_mysql = "$order_by";
			}
			else{
				$order_by_mysql = "food_id";
			}
			$query = $query . " ORDER BY $order_by_mysql $order_method_mysql";
		}


		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_food_id, $get_food_user_id, $get_food_name, $get_food_manufacturer_name, $get_food_description, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_fat, $get_food_energy_calculated, $get_food_proteins_calculated, $get_food_carbohydrates_calculated, $get_food_fat_calculated, $get_food_barcode, $get_food_category_id, $get_food_image_path, $get_food_thumb_small, $get_food_thumb_medium, $get_food_thumb_large, $get_food_image_a, $get_food_language, $get_food_unique_hits, $get_food_likes, $get_food_dislikes) = $row;
			
			// Style
			if(isset($style) && $style == ""){
				$style = "odd";
			}
			else{
				$style = "";
			}

			// Thumb small
			if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a") && !(file_exists("../$get_food_image_path/$get_food_thumb_small")) && $get_food_thumb_small == ""){
				// Thumb name
				$extension = get_extension($get_food_image_a);
				$extension = strtolower($extension);
				$inp_new_x = 132;
				$inp_new_y = 132;
				
				$thumb_name = $get_food_id . "_thumb_" . $inp_new_x . "x" . $inp_new_y . "." . $extension;
				$thumb_name_mysql = quote_smart($link, $thumb_name);
				resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_food_image_path/$get_food_image_a", "$root/$get_food_image_path/$thumb_name");

				$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb_small=$thumb_name_mysql WHERE food_id=$get_food_id") or die(mysqli_error($link));
				
			}

			// Thumb medium
			if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a") && !(file_exists("../$get_food_image_path/$get_food_thumb_medium")) OR $get_food_thumb_medium == ""){
				// Thumb name
				$extension = get_extension($get_food_image_a);
				$extension = strtolower($extension);
				$inp_new_x = 150;
				$inp_new_y = 150;
				
				$thumb_name = $get_food_id . "_thumb_" . $inp_new_x . "x" . $inp_new_y . "." . $extension;
				$thumb_name_mysql = quote_smart($link, $thumb_name);
				resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_food_image_path/$get_food_image_a", "$root/$get_food_image_path/$thumb_name");

				$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb_medium=$thumb_name_mysql WHERE food_id=$get_food_id") or die(mysqli_error($link));
			}

			// Thumb large
			if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a") && !(file_exists("../$get_food_image_path/$get_food_thumb_large")) OR $get_food_thumb_large == ""){
				// Thumb name
				$extension = get_extension($get_food_image_a);
				$extension = strtolower($extension);
				$inp_new_x = 420;
				$inp_new_y = 283;
				
				$thumb_name = $get_food_id . "_thumb_" . $inp_new_x . "x" . $inp_new_y . "." . $extension;
				$thumb_name_mysql = quote_smart($link, $thumb_name);
				resize_crop_image($inp_new_x, $inp_new_y, "$root/$get_food_image_path/$get_food_image_a", "$root/$get_food_image_path/$thumb_name");

				$result_update = mysqli_query($link, "UPDATE $t_food_index SET food_thumb_large=$thumb_name_mysql WHERE food_id=$get_food_id") or die(mysqli_error($link));
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
					
					// Thumb
					if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a")){
						
						echo"<a href=\"$root/food/view_food.php?food_id=$get_food_id&amp;sub_category_id=$get_food_category_id&amp;l=$get_food_language\"><img src=\"../$get_food_image_path/$get_food_thumb_small\" alt=\"$get_food_thumb_small\" style=\"margin-bottom: 5px;\" /></a><br />";
					}
					else{
						echo"<a href=\"$root/food/view_food.php?food_id=$get_food_id&amp;sub_category_id=$get_food_category_id&amp;l=$get_food_language\"><img src=\"_gfx/no_thumb.png\" alt=\"$get_food_image_a\" style=\"margin-bottom: 5px;\" /></a><br />";
					}


					echo"
				   </td>
				   <td>
					<a href=\"$root/food/view_food.php?food_id=$get_food_id&amp;sub_category_id=$get_food_category_id&amp;l=$get_food_language\" class=\"recipe_open_category_a\">$get_food_manufacturer_name $get_food_name</a><br />
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
				<a href=\"edit_food.php?food_id=$get_food_id&amp;l=$l\">$l_edit</a>
				&middot;
				<a href=\"delete_food.php?food_id=$get_food_id&amp;l=$l\">$l_delete</a>
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
	<img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/food/my_food.php\">

	<p>Please log in...</p>
	";
}

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>