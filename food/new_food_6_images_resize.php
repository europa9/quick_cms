<?php 
/**
*
* File: food/new_food.php
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


/*- Settings ---------------------------------------------------------------------------- */
$settings_image_width = "847";
$settings_image_height = "847";



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


/*- Get extention ---------------------------------------------------------------------- */
function getExtension($str) {
		$i = strrpos($str,".");
		if (!$i) { return ""; } 
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l);
		return $ext;
}


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

if(isset($_GET['image_number'])){
	$image_number = $_GET['image_number'];
	$image_number = strip_tags(stripslashes($image_number));
	$image_number_mysql = quote_smart($link, $image_number);
}
else{
	$image_number = "";
}





$tabindex = 0;
$l_mysql = quote_smart($link, $l);



// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);

	// Select food
	$query = "SELECT food_id, food_user_id, food_name, food_clean_name, food_manufacturer_name, food_description, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_fat, food_energy_calculated, food_proteins_calculated, food_carbohydrates_calculated, food_fat_calculated, food_barcode, food_category_id, food_image_path, food_thumb, food_image_a, food_image_b, food_image_c, food_image_d, food_image_e, food_last_used, food_language, food_synchronized, food_accepted_as_master, food_notes, food_unique_hits, food_unique_hits_ip_block, food_comments, food_likes, food_dislikes, food_likes_ip_block FROM $t_food_index WHERE food_id=$food_id_mysql AND food_user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_food_id, $get_food_user_id, $get_food_name, $get_food_clean_name, $get_food_manufacturer_name, $get_food_description, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_fat, $get_food_energy_calculated, $get_food_proteins_calculated, $get_food_carbohydrates_calculated, $get_food_fat_calculated, $get_food_barcode, $get_food_category_id, $get_food_image_path, $get_food_thumb, $get_food_image_a, $get_food_image_b, $get_food_image_c, $get_food_image_d, $get_food_image_e, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_accepted_as_master, $get_food_notes, $get_food_unique_hits, $get_food_unique_hits_ip_block, $get_food_comments, $get_food_likes, $get_food_dislikes, $get_food_likes_ip_block) = $row;

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
		/*- Footer ----------------------------------------------------------------------------------- */
		include("$root/_webdesign/footer.php");
	}
	else{


		/*- Headers ---------------------------------------------------------------------------------- */
		$website_title = "$l_food - $l_new_food - $get_food_name $get_food_manufacturer_name";
		if(file_exists("./favicon.ico")){ $root = "."; }
		elseif(file_exists("../favicon.ico")){ $root = ".."; }
		elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
		elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }


		// Process
		if($process != "1"){
			echo"<!DOCTYPE html>\n";
			echo"<html lang=\"en\">\n";
			echo"<head>\n";
			echo"	<title>$get_food_name</title>\n";

			echo"	<!-- Site CSS-->\n";
			echo"	<link rel=\"stylesheet\" type=\"text/css\" href=\"$root/_webdesign/reset.css\" />\n";
			echo"	<link rel=\"stylesheet\" type=\"text/css\" href=\"$root/_webdesign/master.css\" />\n";
			echo"	<link rel=\"stylesheet\" type=\"text/css\" href=\"$root/users/_gfx/users.css\" />\n";
			echo"	<!-- //Site CSS -->\n";


			echo"	<link rel=\"icon\" href=\"$root/favicon.ico\" />\n";
			echo"	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
			echo"	<meta name=\"viewport\" content=\"width=device-width; initial-scale=1.0;\"/>\n";

			echo"	<!-- jQuery -->\n";
			echo"		<script type=\"text/javascript\" src=\"$root/_scripts/javascripts/jquery/jquery-3.1.1.min.js\"></script>\n";
			echo"		<script type=\"text/javascript\" src=\"$root/_scripts/javascripts/jquery/query-ui.js\"></script>\n";
			echo"		<link rel=\"stylesheet\" href=\"$root/_scripts/javascripts/jquery/jquery-ui.css\" />\n";
			echo"	<!-- //jQuery -->\n";

	
			echo"	</head>\n";
			echo"	<body>\n";
			echo"	<a id=\"top\"></a>\n";
			echo"	<div style=\"text-align: center;\">\n";


			
			

		}


		echo"

		<!-- Title -->
			<h1>$l_new_food</h1>
			";
			if($image_number == "a" OR $image_number == ""){
				echo"<h2>$l_resize_product_image</h2>";
			}
			elseif($image_number == "b"){
				echo"<h2>$l_resize_food_table_image</h2>";
			}
			elseif($image_number == "c"){
				echo"<h2>$l_resize_other_image</h2>";
			}
			elseif($image_number == "d"){
				echo"<h2>$l_resize_inspiration_image</h2>";
			}
			echo"
		<!-- //Title -->


		<!-- Feedback -->
		<!-- //Feedback -->


		<!-- Load image -->


			";
			if($image_number == "a" OR $image_number == ""){
				$image_path = "$root/$get_food_image_path/$get_food_image_a";
			}
			elseif($image_number == "b"){
				$image_path = "$root/$get_food_image_path/$get_food_image_b";
			}
			elseif($image_number == "c"){
				$image_path = "$root/$get_food_image_path/$get_food_image_c";
			}
			elseif($image_number == "d"){
				$image_path = "$root/$get_food_image_path/$get_food_image_d";
			}

			if(file_exists("$image_path")){
				echo"
				<script>
					\$(document).ready(function(){
						\$('#duck').imgAreaSelect({ minWidth: $settings_image_width, minHeight: $settings_image_height, maxWidth: $settings_image_width, maxHeight: $settings_image_height, handles: true });
					});
				</script>
				

				<p>
				<a href=\"new_food_6_images_resize_rotate.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$food_id&amp;image_number=$image_number&amp;l=$l&amp;process=1\" class=\"btn\">$l_rotate</a>
			
				";
				if($image_number == "a" OR $image_number == ""){
					echo"
					<a href=\"new_food_5_images.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$food_id&amp;image_number=b&amp;l=$l\" class=\"btn btn_default\">$l_upload_food_table_image</a>
					";
				}
				elseif($image_number == "b"){
					echo"
					<a href=\"new_food_5_images.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$food_id&amp;image_number=c&amp;l=$l\" class=\"btn btn_default\">$l_upload_other_image</a>
					";
				}
				elseif($image_number == "c"){
					echo"
					<a href=\"new_food_5_images.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$food_id&amp;image_number=d&amp;l=$l\" class=\"btn btn_default\">$l_upload_inspiration_image</a>
					";
				}
				elseif($image_number == "d"){
					echo"
					";
				}

				echo"
				<a href=\"new_food_7_tags.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$food_id&amp;l=$l\" class=\"btn btn_default\">$l_tags</a>
				<a href=\"new_food_8_stores.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$food_id&amp;l=$l\" class=\"btn btn_default\">$l_stores</a>
				<a href=\"view_food.php?main_category_id=$main_category_id&amp;sub_category_id=$sub_category_id&amp;food_id=$food_id&amp;l=$l\" class=\"btn btn_default\">$l_view_food</a>
				</p>

				<p><img src=\"$image_path\" id=\"duck\" style=\"max-width: none;\" /></p>


				";
			}
			echo"
		<!-- //Load image -->


		<!-- General information -->
				
		<!-- //General information -->

		";
		echo"	
		</div>
		</body>
		</html>";
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




?>