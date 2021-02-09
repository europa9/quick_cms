<?php
/**
*
* File: _food/index.php
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

/*- Tables ---------------------------------------------------------------------------- */
include("_tables_food.php");


/*- Variables ------------------------------------------------------------------------- */
$l_mysql = quote_smart($link, $l);


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




/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_food";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");


echo"
<!-- Headline and language -->
	<table style=\"width: 100%;\">
	 <tr>
	  <td>
		<h1>Food</h1>
	  </td>
	  <td style=\"text-align: right;\">
			
		<script>
		\$(function(){
		// bind change event to select
		\$('#inp_l').on('change', function () {
			var url = \$(this).val(); // get selected value
			if (url) { // require a URL
					window.location = url; // redirect
			}
			return false;
		});
		});
		</script>

		<form method=\"get\" enctype=\"multipart/form-data\">
		<p>
		<select id=\"inp_l\">
			<option value=\"index.php?l=$l\">$l_language</option>
			<option value=\"index.php?l=$l\">-</option>\n";


			$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;

				$flag_path 	= "_design/gfx/flags/16x16/$get_language_active_flag" . "_16x16.png";
	
				echo"	<option value=\"index.php?l=$get_language_active_iso_two\" style=\"background: url('$flag_path') no-repeat;padding-left: 20px;\"";if($l == "$get_language_active_iso_two"){ echo" selected=\"selected\"";}echo">$get_language_active_name</option>\n";
			}
		echo"
		</select>
		</p>
		</form>

	  </td>
	 </tr>
	</table>
<!-- //Headline and language -->


<!-- Where am I ? -->
	<p><b>$l_you_are_here:</b><br />
	<a href=\"index.php?l=$l\">$l_food</a>
	</p>
<!-- //Where am I ? -->


<!-- Main categories -->

	<p><b>$l_main_categories:</b></p>
	<div class=\"vertical\">
		<ul>
	";
	// Get all categories
	$query = "SELECT $t_food_categories.category_id, $t_food_categories.category_name, $t_food_categories.category_parent_id FROM $t_food_categories";
	$query = $query . " WHERE category_user_id='0' AND category_parent_id='0' ORDER BY category_name ASC";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_category_id, $get_category_name, $get_category_parent_id) = $row;

		// Translation
		$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_category_id AND category_translation_language=$l_mysql";
		$result_t = mysqli_query($link, $query_t);
		$row_t = mysqli_fetch_row($result_t);
		list($get_category_translation_value) = $row_t;

		echo"
		<li><a href=\"open_main_category.php?main_category_id=$get_category_id&amp;l=$l\">$get_category_translation_value</a></li>
		";
	}
	echo"
		</ul>
	</div>
<!-- //Main categories -->
";

if(isset($desktop_design)){
echo"
<!-- Headline and language -->
	<table style=\"width: 100%;\">
	 <tr>
	  <td>
		<h1>Food</h1>
	  </td>
	  <td style=\"text-align: right;\">
			
		<script>
		\$(function(){
		// bind change event to select
		\$('#inp_l').on('change', function () {
			var url = \$(this).val(); // get selected value
			if (url) { // require a URL
					window.location = url; // redirect
			}
			return false;
		});
		});
		</script>

		<form method=\"get\" enctype=\"multipart/form-data\">
		<p>
		<select id=\"inp_l\">
			<option value=\"index.php?l=$l\">$l_language</option>
			<option value=\"index.php?l=$l\">-</option>\n";


			$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;

				$flag_path 	= "_design/gfx/flags/16x16/$get_language_active_flag" . "_16x16.png";
	
				echo"	<option value=\"index.php?l=$get_language_active_iso_two\" style=\"background: url('$flag_path') no-repeat;padding-left: 20px;\"";if($l == "$get_language_active_iso_two"){ echo" selected=\"selected\"";}echo">$get_language_active_name</option>\n";
			}
		echo"
		</select>
		</p>
		</form>

	  </td>
	 </tr>
	</table>
<!-- //Headline and language -->


<!-- Left and right -->
	<div style=\"float: left;\">
		<!-- Main categories -->
			<table class=\"hor-zebra\">
			 <tr>
			  <td class=\"odd\">
				<p>";

				// Get all categories
				$query = "SELECT $t_food_categories.category_id, $t_food_categories.category_name, $t_food_categories.category_parent_id FROM $t_food_categories";
				$query = $query . " WHERE category_user_id='0' AND category_parent_id='0' ORDER BY category_name ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_category_id, $get_category_name, $get_category_parent_id) = $row;

					// Translation
					$query_t = "SELECT category_translation_value FROM $t_food_categories_translations WHERE category_id=$get_category_id AND category_translation_language=$l_mysql";
					$result_t = mysqli_query($link, $query_t);
					$row_t = mysqli_fetch_row($result_t);
					list($get_category_translation_value) = $row_t;

					echo"
					<a href=\"open_main_category.php?main_category_id=$get_category_id&amp;l=$l\">$get_category_translation_value</a><br />
					";

				}

				echo"
					</p>
			  </td>
			 </tr>
			</table>
		<!-- //Main categories -->
	</div>
	<div style=\"float: left;padding: 0px 0px 0px 20px;\">

		<!-- Show categories and foods -->
			<table style=\"width: 100%;\">
			";
			// Set layout
			$layout = 0;

			// Get all food
			$query = "SELECT food_id, food_user_id, food_name, food_manufacturer_name, food_description, food_serving_size_gram, food_serving_size_gram_measurement, food_serving_size_pcs, food_serving_size_pcs_measurement, food_energy, food_proteins, food_carbohydrates, food_fat, food_energy_calculated, food_proteins_calculated, food_carbohydrates_calculated, food_fat_calculated, food_barcode, food_main_category_id, food_sub_category_id, food_image_path, food_thumb, food_image_a, food_image_b, food_image_c, food_last_used, food_language, food_synchronized, food_notes FROM $t_food_index WHERE food_language=$l_mysql ORDER BY food_id DESC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_food_id, $get_food_user_id, $get_food_name, $get_food_manufacturer_name, $get_food_description, $get_food_serving_size_gram, $get_food_serving_size_gram_measurement, $get_food_serving_size_pcs, $get_food_serving_size_pcs_measurement, $get_food_energy, $get_food_proteins, $get_food_carbohydrates, $get_food_fat, $get_food_energy_calculated, $get_food_proteins_calculated, $get_food_carbohydrates_calculated, $get_food_fat_calculated, $get_food_barcode, $get_food_main_category_id, $get_food_sub_category_id, $get_food_image_path, $get_food_thumb, $get_food_image_a, $get_food_image_b, $get_food_image_c, $get_food_last_used, $get_food_language, $get_food_synchronized, $get_food_notes) = $row;
				
				// Name saying
				$check = strlen($get_food_name);
				if($check > 20){
					$get_food_name = substr($get_food_name, 0, 23);
					$get_food_name = $get_food_name . "...";
				}	


				if($layout == 0){
					echo"
					 <tr>
					  <td style=\"width: 143px;padding: 0px 40px 0px 0px;vertical-align: top;text-align: center;\">
						<p style=\"padding-bottom:0;\">
						<a href=\"view_food.php?food_id=$get_food_id&amp;l=$l\"><img src=\"";
									if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a")){
										echo"../image.php?width=132&amp;height=132&amp;image=/$get_food_image_path/$get_food_image_a";
									}
									else{
										echo"_inc/diet/_gfx/no_thumb.png";
									}
									echo"\" alt=\"$get_food_image_a\" style=\"margin-bottom: 5px;\" /></a><br />
					
									<a href=\"view_food.php?food_id=$get_food_id&amp;l=$l\">$get_food_manufacturer_name</a><br />
									<a href=\"view_food.php?food_id=$get_food_id&amp;l=$l\">$get_food_name</a><br />";
									if($check < 20){	
										echo"<br />";
									}					
									echo"
									</p>

									<div style=\"width: 127px; margin: 0 auto;\">
										<table>
										 <tr>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_energy kcal</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_fat fat</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_carbohydrates carb</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_proteins proteins</span>
										  </td>
										 </tr>
										</table>
									</div>
								  </td>
								";
							}
							elseif($layout == 1){
								echo"
								  <td style=\"width: 143px;padding: 0px 40px 0px 0px;vertical-align: top;text-align: center;\">
									<p style=\"padding-bottom:0;\">
									<a href=\"view_food.php?food_id=$get_food_id&amp;l=$l\"><img src=\"";
									if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a")){
										echo"../image.php?width=132&amp;height=132&amp;image=/$get_food_image_path/$get_food_image_a";
									}
									else{
										echo"_inc/diet/_gfx/no_thumb.png";
									}
									echo"\" alt=\"$get_food_image_a\" style=\"margin-bottom: 5px;\" /></a><br />
					
									<a href=\"view_food.php?food_id=$get_food_id&amp;l=$l\">$get_food_manufacturer_name</a><br />
									<a href=\"view_food.php?food_id=$get_food_id&amp;l=$l\">$get_food_name</a><br />";
									if($check < 20){	
										echo"<br />";
									}					
									echo"
									</p>

									<div style=\"width: 127px; margin: 0 auto;\">
										<table>
										 <tr>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_energy kcal</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_fat fat</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_carbohydrates carb</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_proteins proteins</span>
										  </td>
										 </tr>
										</table>
									</div>
								  </td>
								";
							}
							elseif($layout == 2){
								echo"
								  <td style=\"width: 143px;padding: 0px 0px 0px 0px;vertical-align: top;text-align: center;\">
									<p style=\"padding-bottom:0;\">
									<a href=\"view_food.php?food_id=$get_food_id&amp;l=$l\"><img src=\"";
									if($get_food_image_a != "" && file_exists("../$get_food_image_path/$get_food_image_a")){
										echo"../image.php?width=132&amp;height=132&amp;image=/$get_food_image_path/$get_food_image_a";
									}
									else{
										echo"_inc/diet/_gfx/no_thumb.png";
									}
									echo"\" alt=\"$get_food_image_a\" style=\"margin-bottom: 5px;\" /></a><br />
					
									<a href=\"view_food.php?food_id=$get_food_id&amp;l=$l\">$get_food_manufacturer_name</a><br />
									<a href=\"view_food.php?food_id=$get_food_id&amp;l=$l\">$get_food_name</a><br />";
									if($check < 20){	
										echo"<br />";
									}					
									echo"
									</p>

									<div style=\"width: 127px; margin: 0 auto;\">
										<table>
										 <tr>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_energy kcal</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_fat fat</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_carbohydrates carb</span>
										  </td>
										  <td style=\"padding-right: 5px;\">
											<span class=\"smal\">$get_food_proteins proteins</span>
										  </td>
										 </tr>
										</table>
									</div>
								  </td>
								 </tr>
								";
								$layout = -1;
							}
							$layout++;
						} // while

						echo"
			</table>
		<!-- Show categories and foods -->
	</div>
<!-- //Left and right -->
";
}


/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>