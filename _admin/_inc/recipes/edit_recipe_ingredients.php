<?php
/**
*
* File: _admin/_inc/recipes/edit_recipe_ingredients.php
* Version 1.0.0
* Date 11:43 12.11.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Tables --------------------------------------------------------------------------- */
$t_recipes 	 	= $mysqlPrefixSav . "recipes";
$t_recipes_ingredients	= $mysqlPrefixSav . "recipes_ingredients";
$t_recipes_groups	= $mysqlPrefixSav . "recipes_groups";
$t_recipes_items	= $mysqlPrefixSav . "recipes_items";
$t_recipes_numbers	= $mysqlPrefixSav . "recipes_numbers";
$t_recipes_rating	= $mysqlPrefixSav . "recipes_rating";
$t_recipes_cuisines	= $mysqlPrefixSav . "recipes_cuisines";
$t_recipes_seasons	= $mysqlPrefixSav . "recipes_seasons";
$t_recipes_occasions	= $mysqlPrefixSav . "recipes_occasions";


/*- Variables ------------------------------------------------------------------------ */
if(isset($_GET['mode'])) {
	$mode = $_GET['mode'];
	$mode = strip_tags(stripslashes($mode));
}
else{
	$mode = "";
}
if(isset($_GET['recipe_id'])) {
	$recipe_id = $_GET['recipe_id'];
	$recipe_id = strip_tags(stripslashes($recipe_id));
}
else{
	$recipe_id = "";
}
if(isset($_GET['group_id'])) {
	$group_id = $_GET['group_id'];
	$group_id = strip_tags(stripslashes($group_id));
}
else{
	$group_id = "";
}
if(isset($_GET['item_id'])) {
	$item_id = $_GET['item_id'];
	$item_id = strip_tags(stripslashes($item_id));
}
else{
	$item_id = "";
}


/*- Translations --------------------------------------------------------------------- */
include("_translations/admin/$l/recipes/t_view_recipe.php");

// Select
$recipe_id_mysql = quote_smart($link, $recipe_id);
$query = "SELECT recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password FROM $t_recipes WHERE recipe_id=$recipe_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_recipe_id, $get_recipe_user_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_language, $get_recipe_introduction, $get_recipe_directions, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb, $get_recipe_date, $get_recipe_time, $get_recipe_cusine_id, $get_recipe_season_id, $get_recipe_occasion_id, $get_recipe_marked_as_spam, $get_recipe_unique_hits, $get_recipe_unique_hits_ip_block, $get_recipe_user_ip, $get_recipe_notes, $get_recipe_password) = $row;

if($get_recipe_id == ""){
	echo"
	<h1>Recipe not found</h1>

	<p>
	The recipe you are trying to edit was not found.
	</p>

	<p>
	<a href=\"index.php?open=$open&amp;editor_language=$editor_language\">Back</a>
	</p>
	";
}
else{
	if($action == ""){
		echo"
		<h1>$l_edit</h1>


		<!-- Menu -->
			<div class=\"tabs\">
				<ul>
					<li><a href=\"index.php?open=$open&amp;editor_language=$editor_language\">$l_recipes</a></li>
					<li><a href=\"index.php?open=$open&amp;page=view_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\">$l_view_recipe</a></li>
					<li><a href=\"index.php?open=$open&amp;page=edit_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"current\">$l_edit</a></li>
					<li><a href=\"index.php?open=$open&amp;page=delete_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\">$l_delete</a></li>
				</ul>
			</div><p>&nbsp;</p>
		<!-- //Menu -->

		<!-- Where am I ? -->
			<p><b>$l_you_are_here:</b><br />
			<a href=\"index.php?open=$open&amp;editor_language=$editor_language\">$l_recipes</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=view_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"current\">$get_recipe_title</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=edit_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"current\">$l_edit</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=edit_recipe_ingredients&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"current\">$l_ingredients</a>
			</p>
		<!-- //Where am I ? -->

		<!-- Feedback -->
		";
		if($ft != ""){
			if($fm == "changes_saved"){
				$fm = "$l_changes_saved";
			}
			elseif($fm == "please_confirm_that_you_want_to_delete_the_item"){
				$fm = "$l_please_confirm_that_you_want_to_delete_the_item <br /><br /><a href=\"index.php?open=recipes&amp;page=edit_recipe_ingredients&amp;action=delete_item&amp;recipe_id=$recipe_id&amp;group_id=$group_id&amp;item_id=$item_id&amp;editor_language=$editor_language&amp;process=1\" class=\"btn\">$l_confirm_delete</a>";
			}
			else{
				$fm = ucfirst($ft);
			}
			echo"<div class=\"$ft\"><span>$fm</span></div>";
		}
		echo"	
		<!-- //Feedback -->


		<!-- Groups -->
			<p>
			<a href=\"index.php?open=recipes&amp;page=edit_recipe_ingredients&amp;action=new_group&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"btn\">$l_new_group</a>
			</p>

				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
			 	  <th scope=\"col\">
					<span>$l_group</span>
				   </th>
				   <th scope=\"col\">
					<span>
					
					</span>
		 		   </th>
				  </tr>
				 </thead>
				 <tbody>
			";
			$query_groups = "SELECT group_id, group_title FROM $t_recipes_groups WHERE group_recipe_id=$get_recipe_id";
			$result_groups = mysqli_query($link, $query_groups);
			while($row_groups = mysqli_fetch_row($result_groups)) {
				list($get_group_id, $get_group_title) = $row_groups;


				if(isset($style) && $style == "odd"){
					$style = "";
				}
				else{
					$style = "odd";
				}
				echo"
				<tr>
				   <td class=\"$style\">
					<span>$get_group_title</span>
				   </td>
				   <td class=\"$style\">
					<span>
					<a href=\"index.php?open=recipes&amp;page=edit_recipe_ingredients&amp;action=edit_group&amp;recipe_id=$recipe_id&amp;group_id=$get_group_id&amp;editor_language=$editor_language\">$l_edit</a>
					&middot;
					<a href=\"index.php?open=recipes&amp;page=edit_recipe_ingredients&amp;action=delete_group&amp;recipe_id=$recipe_id&amp;group_id=$get_group_id&amp;editor_language=$editor_language\">$l_delete</a>
					</span>
		 		   </td>
				  </tr>
				";
				$query_items = "SELECT item_id, item_amount, item_measurement, item_grocery FROM $t_recipes_items WHERE item_group_id=$get_group_id";
				$result_items = mysqli_query($link, $query_items);
				$row_cnt = mysqli_num_rows($result_items);
				while($row_items = mysqli_fetch_row($result_items)) {
					list($get_item_id, $get_item_amount, $get_item_measurement, $get_item_grocery) = $row_items;


					if(isset($style) && $style == "odd"){
						$style = "";
					}
					else{
						$style = "odd";
					}
					if($mode == "delete_item" && $item_id == $get_item_id){ 
						$style = "danger";
					}
					echo"
					<tr>
					  <td class=\"$style\" style=\"padding-left: 20px;\">
						<span><a id=\"item_id$get_item_id\"></a>$get_item_amount $get_item_measurement $get_item_grocery</span>
					   </td>
					   <td class=\"$style\">
						<span>
						<a href=\"index.php?open=recipes&amp;page=edit_recipe_ingredients&amp;action=edit_group&amp;mode=edit_item&amp;recipe_id=$recipe_id&amp;group_id=$get_group_id&amp;item_id=$get_item_id&amp;editor_language=$editor_language\">$l_edit</a>
						&middot;";

						if($mode == "delete_item" && $item_id == $get_item_id){ 
							echo" <a href=\"index.php?open=recipes&amp;page=edit_recipe_ingredients&amp;action=delete_item&amp;recipe_id=$recipe_id&amp;group_id=$get_group_id&amp;item_id=$get_item_id&amp;editor_language=$editor_language&amp;process=1\">$l_confirm_delete</a>";
						
						}
						else{
							echo"
							<a href=\"index.php?open=recipes&amp;page=edit_recipe_ingredients&amp;mode=delete_item&amp;recipe_id=$recipe_id&amp;group_id=$get_group_id&amp;item_id=$get_item_id&amp;editor_language=$editor_language&amp;ft=warning&amp;fm=please_confirm_that_you_want_to_delete_the_item#item_id$get_item_id\">$l_delete</a>
							";
						}
						echo"</span>
		 			   </td>
					  </tr>
					";
				}

			}
			echo"		
				 </tbody>
				</table>		
			</p>
		<!-- //Groups -->

		";
	} // action == ""
	elseif($action == "new_group" OR $action == "new_group_save"){
		if($action == "new_group_save"){
			// inp_group_title 
			$inp_group_title = $_POST['inp_group_title'];
			$inp_group_title = output_html($inp_group_title);
			$inp_group_title_mysql = quote_smart($link, $inp_group_title);
			if(empty($inp_group_title)){
				$ft = "error";
				$fm = "group_title_is_empty";
			}
			else{
				// Check if group already exists
				$query = "SELECT group_id FROM $t_recipes_groups WHERE group_recipe_id=$recipe_id_mysql AND group_title=$inp_group_title_mysql";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($get_group_id) = $row;
				if($get_group_id != ""){
					$ft = "error";
					$fm = "you_already_have_a_group_with_that_name";
				}
				else{
					// Insert group
					mysqli_query($link, "INSERT INTO $t_recipes_groups
					(group_id, group_recipe_id, group_title) 
					VALUES 
					(NULL, $recipe_id_mysql, $inp_group_title_mysql)")
					or die(mysqli_error($link));

					// Get ID
					$query = "SELECT group_id FROM $t_recipes_groups WHERE group_recipe_id=$recipe_id_mysql AND group_title=$inp_group_title_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_group_id) = $row;



					// Loop
					for($x=0;$x<15;$x++){
						$inp_item_amount = $_POST["inp_item_amount_$x"];
						$inp_item_amount = output_html($inp_item_amount);
						$inp_item_amount = str_replace(",", ".", $inp_item_amount);
						if(!(is_numeric($inp_item_amount))){
							$inp_item_amount = 0;
						}
						$inp_item_amount_mysql = quote_smart($link, $inp_item_amount);

						$inp_item_measurement = $_POST["inp_item_measurement_$x"];
						$inp_item_measurement = output_html($inp_item_measurement);
						$inp_item_measurement_mysql = quote_smart($link, $inp_item_measurement);

						$inp_item_grocery = $_POST["inp_item_grocery_$x"];
						$inp_item_grocery = output_html($inp_item_grocery);
						$inp_item_grocery_mysql = quote_smart($link, $inp_item_grocery);

						$inp_item_calories_calculated = $_POST["inp_item_calories_calculated_$x"];
						if($inp_item_calories_calculated == ""){
							$inp_item_calories_calculated = "0";
						}
						else{
							if(!(is_numeric($inp_item_calories_calculated))){
								$inp_item_calories_calculated = 0;
							}
						}
						$inp_item_calories_calculated = output_html($inp_item_calories_calculated);
						$inp_item_calories_calculated = str_replace(",", ".", $inp_item_calories_calculated);
						$inp_item_calories_calculated_mysql = quote_smart($link, $inp_item_calories_calculated);

						$inp_item_proteins_calculated = $_POST["inp_item_proteins_calculated_$x"];
						if($inp_item_proteins_calculated == ""){
							$inp_item_proteins_calculated = "0";
						}
						else{
							if(!(is_numeric($inp_item_proteins_calculated))){
								$inp_item_proteins_calculated = 0;
							}
						}
						$inp_item_proteins_calculated = output_html($inp_item_proteins_calculated);
						$inp_item_proteins_calculated = str_replace(",", ".", $inp_item_proteins_calculated);
						$inp_item_proteins_calculated_mysql = quote_smart($link, $inp_item_proteins_calculated);

						$inp_item_fat_calculated = $_POST["inp_item_fat_calculated_$x"];
						if($inp_item_fat_calculated == ""){
							$inp_item_fat_calculated = "0";
						}
						else{
							if(!(is_numeric($inp_item_fat_calculated))){
								$inp_item_fat_calculated = 0;
							}
						}
						$inp_item_fat_calculated = output_html($inp_item_fat_calculated);
						$inp_item_fat_calculated = str_replace(",", ".", $inp_item_fat_calculated);
						$inp_item_fat_calculated_mysql = quote_smart($link, $inp_item_fat_calculated);

						$inp_item_carbs_calculated = $_POST["inp_item_carbs_calculated_$x"];
						if($inp_item_carbs_calculated == ""){
							$inp_item_carbs_calculated = "0";
						}
						else{
							if(!(is_numeric($inp_item_carbs_calculated))){
								$inp_item_carbs_calculated = 0;
							}
						}
						$inp_item_carbs_calculated = output_html($inp_item_carbs_calculated);
						$inp_item_carbs_calculated = str_replace(",", ".", $inp_item_carbs_calculated);
						$inp_item_carbs_calculated_mysql = quote_smart($link, $inp_item_carbs_calculated);

						if($inp_item_amount != "" && $inp_item_measurement != "" && $inp_item_grocery != ""){
							// Insert item
							mysqli_query($link, "INSERT INTO $t_recipes_items
							(item_id, item_recipe_id, item_group_id, item_amount, item_measurement, item_grocery, item_calories_calculated, item_proteins_calculated, item_fat_calculated, item_carbs_calculated) 
							VALUES 
							(NULL, $recipe_id_mysql, '$get_group_id', $inp_item_amount_mysql, $inp_item_measurement_mysql, $inp_item_grocery_mysql, $inp_item_calories_calculated_mysql, $inp_item_proteins_calculated_mysql, $inp_item_fat_calculated_mysql, $inp_item_carbs_calculated_mysql)")
							or die(mysqli_error($link));
						}
						
						

					} // for

					// Get number of servings
					$query = "SELECT number_servings FROM $t_recipes_numbers WHERE number_recipe_id=$recipe_id_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_number_servings) = $row;





					// Calculating total numbers
					$inp_number_hundred_calories = 0;
					$inp_number_hundred_proteins = 0;
					$inp_number_hundred_fat = 0;
					$inp_number_hundred_carbs = 0;
					
					$inp_number_serving_calories = 0;
					$inp_number_serving_proteins = 0;
					$inp_number_serving_fat = 0;
					$inp_number_serving_carbs = 0;
					
					$inp_number_total_weight = 0;

					$inp_number_total_calories = 0;
					$inp_number_total_proteins = 0;
					$inp_number_total_fat = 0;

					$inp_number_total_carbs = 0;
					

					$query_groups = "SELECT group_id, group_title FROM $t_recipes_groups WHERE group_recipe_id=$get_recipe_id";
					$result_groups = mysqli_query($link, $query_groups);
					while($row_groups = mysqli_fetch_row($result_groups)) {
						list($get_group_id, $get_group_title) = $row_groups;

						$query_items = "SELECT item_id, item_amount, item_calories_per_hundred, item_proteins_per_hundred, item_fat_per_hundred, item_carbs_per_hundred, item_calories_calculated, item_proteins_calculated, item_fat_calculated, item_carbs_calculated FROM $t_recipes_items WHERE item_group_id=$get_group_id";
						$result_items = mysqli_query($link, $query_items);
						$row_cnt = mysqli_num_rows($result_items);
						while($row_items = mysqli_fetch_row($result_items)) {
							list($get_item_id, $get_item_amount, $get_item_calories_per_hundred, $get_item_proteins_per_hundred, $get_item_fat_per_hundred, $get_item_carbs_per_hundred, $get_item_calories_calculated, $get_item_proteins_calculated, $get_item_fat_calculated, $get_item_carbs_calculated) = $row_items;


							$inp_number_hundred_calories = $inp_number_hundred_calories+$get_item_calories_per_hundred;
							$inp_number_hundred_proteins = $inp_number_hundred_proteins+$get_item_proteins_per_hundred;
							$inp_number_hundred_fat      = $inp_number_hundred_fat+$get_item_fat_per_hundred;
							$inp_number_hundred_carbs    = $inp_number_hundred_carbs+$get_item_carbs_per_hundred;
					
							$inp_number_total_weight     = $inp_number_total_weight+$get_item_amount;

							$inp_number_total_calories = $inp_number_total_calories+$get_item_calories_calculated;
							$inp_number_total_proteins = $inp_number_total_proteins+$get_item_proteins_calculated;
							$inp_number_total_fat      = $inp_number_total_fat+$get_item_fat_calculated;
							$inp_number_total_carbs    = $inp_number_total_carbs+$get_item_carbs_calculated;
	

						} // items
					} // groups
					
					$inp_number_serving_calories = round($inp_number_total_calories/$get_number_servings);
					$inp_number_serving_proteins = round($inp_number_total_proteins/$get_number_servings);
					$inp_number_serving_fat      = round($inp_number_total_fat/$get_number_servings);
					$inp_number_serving_carbs    = round($inp_number_total_carbs/$get_number_servings);


					// Ready numbers for MySQL
					$inp_number_hundred_calories_mysql = quote_smart($link, $inp_number_hundred_calories);
					$inp_number_hundred_proteins_mysql = quote_smart($link, $inp_number_hundred_proteins);
					$inp_number_hundred_fat_mysql      = quote_smart($link, $inp_number_hundred_fat);
					$inp_number_hundred_carbs_mysql    = quote_smart($link, $inp_number_hundred_carbs);
					
					$inp_number_total_weight_mysql     = quote_smart($link, $inp_number_total_weight);

					$inp_number_total_calories_mysql = quote_smart($link, $inp_number_total_calories);
					$inp_number_total_proteins_mysql = quote_smart($link, $inp_number_total_proteins);
					$inp_number_total_fat_mysql      = quote_smart($link, $inp_number_total_fat);
					$inp_number_total_carbs_mysql    = quote_smart($link, $inp_number_total_carbs);

					
					$inp_number_serving_calories_mysql = quote_smart($link, $inp_number_serving_calories);
					$inp_number_serving_proteins_mysql = quote_smart($link, $inp_number_serving_proteins);
					$inp_number_serving_fat_mysql      = quote_smart($link, $inp_number_serving_fat);
					$inp_number_serving_carbs_mysql    = quote_smart($link, $inp_number_serving_carbs);

					$result = mysqli_query($link, "UPDATE $t_recipes_numbers SET number_hundred_calories=$inp_number_hundred_calories_mysql, number_hundred_proteins=$inp_number_hundred_proteins_mysql, number_hundred_fat=$inp_number_hundred_fat_mysql, number_hundred_carbs=$inp_number_hundred_carbs_mysql, 
									number_serving_calories=$inp_number_serving_calories_mysql, number_serving_proteins=$inp_number_serving_proteins_mysql, number_serving_fat=$inp_number_serving_fat_mysql, number_serving_carbs=$inp_number_serving_carbs_mysql,
									number_total_weight=$inp_number_total_weight_mysql, 
									number_total_calories=$inp_number_total_calories_mysql, number_total_proteins=$inp_number_total_proteins_mysql, number_total_fat=$inp_number_total_fat_mysql, number_total_carbs=$inp_number_total_carbs_mysql WHERE number_recipe_id=$recipe_id_mysql");


					$ft = "success";
					$fm = "ingredients_saved";
							
					$loading = "<p style=\"font-weight: bold;\"><img src=\"_design/gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float: left;padding-right: 5px;\" /> Loading</p>
					<meta http-equiv=refresh content=\"1; url=index.php?open=recipes&amp;page=edit_recipe_ingredients&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language&amp;ft=$ft&amp;fm=$fm\">";



				} // Group alreaddy exists


			} // group title empty
		}
		echo"
		<h1>$l_edit</h1>


		<!-- Menu -->
			<div id=\"tabs\">
				<ul>
					<li><a href=\"index.php?open=$open&amp;editor_language=$editor_language\">$l_recipes</a></li>
					<li><a href=\"index.php?open=$open&amp;page=view_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\">$l_view_recipe</a></li>
					<li><a href=\"index.php?open=$open&amp;page=edit_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"current\">$l_edit</a></li>
					<li><a href=\"index.php?open=$open&amp;page=delete_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\">$l_delete</a></li>
				</ul>
			</div><p>&nbsp;</p>
		<!-- //Menu -->

		<!-- Where am I ? -->
			<p><b>$l_you_are_here:</b><br />
			<a href=\"index.php?open=$open&amp;editor_language=$editor_language\">$l_recipes</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=view_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"current\">$get_recipe_title</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=edit_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"current\">$l_edit</a>
			&gt;
			<a href=\"index.php?open=$open&amp;page=edit_recipe_ingredients&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"current\">$l_ingredients</a>
			&gt;
			<a href=\"index.php?open=recipes&amp;page=edit_recipe_ingredients&amp;action=new_group&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\">$l_new_group</a>
			</p>
		<!-- //Where am I ? -->

		
		<!-- Feedback -->
		";
		if(isset($loading)){
			echo"$loading";
		}
		else{
			if($ft != ""){
				if($fm == "group_title_is_empty"){
					$fm = "$l_group_title_is_empty";
				}
				elseif($fm == "you_already_have_a_group_with_that_name"){
					$fm = "$l_you_already_have_a_group_with_that_name";
				}
				else{
					$fm = ucfirst($ft);
				}
				echo"<div class=\"$ft\"><span>$fm</span></div>";
			}
		}
		echo"	
		<!-- //Feedback -->



		<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_group_title\"]').focus();
			});
			</script>
		<!-- //Focus -->


		<!-- New group form -->
			<form method=\"post\" action=\"index.php?open=recipes&amp;page=edit_recipe_ingredients&amp;action=new_group_save&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" enctype=\"multipart/form-data\">
	
			<p><b>$l_group_title:</b><br />
			<input type=\"text\" name=\"inp_group_title\" value=\"\" size=\"40\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" />
			</p>

				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
					<span>$l_amount</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_measurement</span>
		 		   </th>
				   <th scope=\"col\">
					<span>$l_grocery</span>
		 		   </th>
				   <th scope=\"col\">
					<span>$l_calories</span>
		 		   </th>
				   <th scope=\"col\">
					<span>$l_proteins</span>
		 		   </th>
				   <th scope=\"col\">
					<span>$l_fat</span>
		 		   </th>
				   <th scope=\"col\">
					<span>$l_carbs</span>
		 		   </th>
				  </tr>
				 </thead>
				 <tbody>
			";

			for($x=0;$x<15;$x++){

				if(isset($odd) && $odd == false){
					$odd = true;
				}
				else{
					$odd = false;
				}
				echo"
				<tr>
				  <td"; if($odd == true){ echo" class=\"odd\""; } echo" style=\"padding-left: 20px;\">
					<span><input type=\"text\" name=\"inp_item_amount_$x\" value=\"\" size=\"3\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" /></span>
				   </td>
				   <td"; if($odd == true){ echo" class=\"odd\""; } echo">
					<span><input type=\"text\" name=\"inp_item_measurement_$x\" value=\"\" size=\"5\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" /></span>
		 		   </td>
				   <td"; if($odd == true){ echo" class=\"odd\""; } echo">
					<span><input type=\"text\" name=\"inp_item_grocery_$x\" value=\"\" size=\"20\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" /></span>
		 		   </td>
				   <td"; if($odd == true){ echo" class=\"odd\""; } echo">
					<span><input type=\"text\" name=\"inp_item_calories_calculated_$x\" value=\"\" size=\"3\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" /></span>
		 		   </td>
				   <td"; if($odd == true){ echo" class=\"odd\""; } echo">
					<span><input type=\"text\" name=\"inp_item_proteins_calculated_$x\" value=\"\" size=\"3\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" /></span>
		 		   </td>
				   <td"; if($odd == true){ echo" class=\"odd\""; } echo">
					<span><input type=\"text\" name=\"inp_item_fat_calculated_$x\" value=\"\" size=\"3\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" /></span>
		 		   </td>
				   <td"; if($odd == true){ echo" class=\"odd\""; } echo">
					<span><input type=\"text\" name=\"inp_item_carbs_calculated_$x\" value=\"\" size=\"3\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" /></span>
		 		   </td>
				  </tr>
				";
			}
			echo"
				 </tbody>
				</table>

				<p><input type=\"submit\" value=\"$l_save\" class=\"submit\" /></p>
			</form>
		<!-- //New group form -->

		";
	} // new group
	elseif($action == "edit_group" OR $action == "edit_group_save"){
		// Find group
		$group_id_mysql = quote_smart($link, $group_id);
		$query = "SELECT group_id, group_recipe_id, group_title FROM $t_recipes_groups WHERE group_id=$group_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_group_id, $get_group_recipe_id, $get_group_title) = $row;
	
		if($get_group_id == ""){
			echo"
			<h1>Recipe group not found</h1>

			<p>
			<a href=\"index.php?open=$open&amp;page=edit_recipe_ingredients&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"btn\">Back</a>
			</p>
			";
		}
		else{
			if($action == "edit_group_save"){

				// inp_group_title 
				$inp_group_title = $_POST['inp_group_title'];
				$inp_group_title = output_html($inp_group_title);
				$inp_group_title_mysql = quote_smart($link, $inp_group_title);
				if(empty($inp_group_title)){
					$ft = "error";
					$fm = "group_title_is_empty";
				}
				else{
					// Update group name
					$result = mysqli_query($link, "UPDATE $t_recipes_groups SET group_title=$inp_group_title_mysql WHERE group_id=$group_id_mysql") or die(mysqli_error($link));


					// Fetch my existings items
					$query_items = "SELECT item_id, item_amount, item_measurement, item_grocery, item_calories_calculated, item_proteins_calculated, item_fat_calculated, item_carbs_calculated FROM $t_recipes_items WHERE item_group_id=$get_group_id";
					$result_items = mysqli_query($link, $query_items);
					$row_cnt = mysqli_num_rows($result_items);
					while($row_items = mysqli_fetch_row($result_items)) {
						list($get_item_id, $get_item_amount, $get_item_measurement, $get_item_grocery, $get_item_calories_calculated, $get_item_proteins_calculated, $get_item_fat_calculated, $get_item_carbs_calculated) = $row_items;	
					

						$inp_item_amount = $_POST["inp_item_amount_$get_item_id"];
						$inp_item_amount = output_html($inp_item_amount);
						$inp_item_amount = str_replace(",", ".", $inp_item_amount);
						if(!(is_numeric($inp_item_amount))){
							$inp_item_amount = 0;
						}
						$inp_item_amount_mysql = quote_smart($link, $inp_item_amount);

						$inp_item_measurement = $_POST["inp_item_measurement_$get_item_id"];
						$inp_item_measurement = output_html($inp_item_measurement);
						$inp_item_measurement_mysql = quote_smart($link, $inp_item_measurement);

						$inp_item_grocery = $_POST["inp_item_grocery_$get_item_id"];
						$inp_item_grocery = output_html($inp_item_grocery);
						$inp_item_grocery_mysql = quote_smart($link, $inp_item_grocery);

						$inp_item_calories_calculated = $_POST["inp_item_calories_calculated_$get_item_id"];
						if($inp_item_calories_calculated == ""){
							$inp_item_calories_calculated = "0";
						}
						else{
							if(!(is_numeric($inp_item_calories_calculated))){
								$inp_item_calories_calculated = 0;
							}
						}
						$inp_item_calories_calculated = output_html($inp_item_calories_calculated);
						$inp_item_calories_calculated = str_replace(",", ".", $inp_item_calories_calculated);
						$inp_item_calories_calculated_mysql = quote_smart($link, $inp_item_calories_calculated);

						$inp_item_proteins_calculated = $_POST["inp_item_proteins_calculated_$get_item_id"];
						if($inp_item_proteins_calculated == ""){
							$inp_item_proteins_calculated = "0";
						}
						else{
							if(!(is_numeric($inp_item_proteins_calculated))){
								$inp_item_proteins_calculated = 0;
							}
						}
						$inp_item_proteins_calculated = output_html($inp_item_proteins_calculated);
						$inp_item_proteins_calculated = str_replace(",", ".", $inp_item_proteins_calculated);
						$inp_item_proteins_calculated_mysql = quote_smart($link, $inp_item_proteins_calculated);

						$inp_item_fat_calculated = $_POST["inp_item_fat_calculated_$get_item_id"];
						if($inp_item_fat_calculated == ""){
							$inp_item_fat_calculated = "0";
						}
						else{
							if(!(is_numeric($inp_item_fat_calculated))){
								$inp_item_fat_calculated = 0;
							}
						}
						$inp_item_fat_calculated = output_html($inp_item_fat_calculated);
						$inp_item_fat_calculated = str_replace(",", ".", $inp_item_fat_calculated);
						$inp_item_fat_calculated_mysql = quote_smart($link, $inp_item_fat_calculated);

						$inp_item_carbs_calculated = $_POST["inp_item_carbs_calculated_$get_item_id"];
						if($inp_item_carbs_calculated == ""){
							$inp_item_carbs_calculated = "0";
						}
						else{
							if(!(is_numeric($inp_item_carbs_calculated))){
								$inp_item_carbs_calculated = 0;
							}
						}
						$inp_item_carbs_calculated = output_html($inp_item_carbs_calculated);
						$inp_item_carbs_calculated = str_replace(",", ".", $inp_item_carbs_calculated);
						$inp_item_carbs_calculated_mysql = quote_smart($link, $inp_item_carbs_calculated);


						// Empty?
						if($inp_item_amount == "" OR $inp_item_measurement == "" OR $inp_item_grocery == ""){
							// Delete item
							$result = mysqli_query($link, "DELETE FROM $t_recipes_items WHERE item_id=$get_item_id AND item_group_id=$get_group_id") or die(mysqli_error($link));
						}
						else{

							$debug = 0;
							if($debug == 1){
								echo"<p>UPDATE $t_recipes_items SET item_amount=$inp_item_amount_mysql, item_measurement=$inp_item_measurement_mysql, item_grocery=$inp_item_grocery_mysql, 
										item_calories_calculated=$inp_item_calories_calculated_mysql, item_proteins_calculated=$inp_item_proteins_calculated_mysql, item_fat_calculated=$inp_item_fat_calculated_mysql, item_carbs_calculated=$inp_item_carbs_calculated_mysql WHERE item_id=$get_item_id</p>";
							}
							else{

							// Update item
							$result = mysqli_query($link, "UPDATE $t_recipes_items SET item_amount=$inp_item_amount_mysql, item_measurement=$inp_item_measurement_mysql, item_grocery=$inp_item_grocery_mysql, 
										item_calories_calculated=$inp_item_calories_calculated_mysql, item_proteins_calculated=$inp_item_proteins_calculated_mysql, item_fat_calculated=$inp_item_fat_calculated_mysql, item_carbs_calculated=$inp_item_carbs_calculated_mysql WHERE item_id=$get_item_id AND item_group_id=$get_group_id") or die(mysqli_error($link));

							}
						}

					} // while


					// Loop
					for($x=0;$x<5;$x++){
						$inp_item_amount = $_POST["inp_item_amount_$x"];
						$inp_item_amount = output_html($inp_item_amount);
						$inp_item_amount = str_replace(",", ".", $inp_item_amount);
						if(!(is_numeric($inp_item_amount))){
							$inp_item_amount = 0;
						}
						$inp_item_amount_mysql = quote_smart($link, $inp_item_amount);

						$inp_item_measurement = $_POST["inp_item_measurement_$x"];
						$inp_item_measurement = output_html($inp_item_measurement);
						$inp_item_measurement_mysql = quote_smart($link, $inp_item_measurement);

							$inp_item_grocery = $_POST["inp_item_grocery_$x"];
							$inp_item_grocery = output_html($inp_item_grocery);
							$inp_item_grocery_mysql = quote_smart($link, $inp_item_grocery);

							$inp_item_calories_calculated = $_POST["inp_item_calories_calculated_$x"];
							if($inp_item_calories_calculated == ""){
								$inp_item_calories_calculated = "0";
							}
							else{
								if(!(is_numeric($inp_item_calories_calculated))){
									$inp_item_calories_calculated = 0;
								}
							}
							$inp_item_calories_calculated = output_html($inp_item_calories_calculated);
							$inp_item_calories_calculated = str_replace(",", ".", $inp_item_calories_calculated);
							$inp_item_calories_calculated_mysql = quote_smart($link, $inp_item_calories_calculated);

							$inp_item_proteins_calculated = $_POST["inp_item_proteins_calculated_$x"];
							if($inp_item_proteins_calculated == ""){
								$inp_item_proteins_calculated = "0";
							}
							else{
								if(!(is_numeric($inp_item_proteins_calculated))){
									$inp_item_proteins_calculated = 0;
								}
						}
						$inp_item_proteins_calculated = output_html($inp_item_proteins_calculated);
							$inp_item_proteins_calculated = str_replace(",", ".", $inp_item_proteins_calculated);
						$inp_item_proteins_calculated_mysql = quote_smart($link, $inp_item_proteins_calculated);

						$inp_item_fat_calculated = $_POST["inp_item_fat_calculated_$x"];
						if($inp_item_fat_calculated == ""){
								$inp_item_fat_calculated = "0";
							}
							else{
								if(!(is_numeric($inp_item_fat_calculated))){
									$inp_item_fat_calculated = 0;
								}
							}
						$inp_item_fat_calculated = output_html($inp_item_fat_calculated);
							$inp_item_fat_calculated = str_replace(",", ".", $inp_item_fat_calculated);
						$inp_item_fat_calculated_mysql = quote_smart($link, $inp_item_fat_calculated);

							$inp_item_carbs_calculated = $_POST["inp_item_carbs_calculated_$x"];
							if($inp_item_carbs_calculated == ""){
								$inp_item_carbs_calculated = "0";
							}
							else{
								if(!(is_numeric($inp_item_carbs_calculated))){
									$inp_item_carbs_calculated = 0;
								}
						}
						$inp_item_carbs_calculated = output_html($inp_item_carbs_calculated);
						$inp_item_carbs_calculated = str_replace(",", ".", $inp_item_carbs_calculated);
						$inp_item_carbs_calculated_mysql = quote_smart($link, $inp_item_carbs_calculated);

						if($inp_item_amount != "" && $inp_item_measurement != "" && $inp_item_grocery != ""){
							// Insert item
							mysqli_query($link, "INSERT INTO $t_recipes_items
							(item_id, item_recipe_id, item_group_id, item_amount, item_measurement, item_grocery, item_calories_calculated, item_proteins_calculated, item_fat_calculated, item_carbs_calculated) 
							VALUES 
							(NULL, $recipe_id_mysql, '$get_group_id', $inp_item_amount_mysql, $inp_item_measurement_mysql, $inp_item_grocery_mysql, $inp_item_calories_calculated_mysql, $inp_item_proteins_calculated_mysql, $inp_item_fat_calculated_mysql, $inp_item_carbs_calculated_mysql)")
							or die(mysqli_error($link));
						}
						
						

					} // for


					// Get number of servings
					$query = "SELECT number_servings FROM $t_recipes_numbers WHERE number_recipe_id=$recipe_id_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_number_servings) = $row;





					// Calculating total numbers
					$inp_number_hundred_calories = 0;
					$inp_number_hundred_proteins = 0;
					$inp_number_hundred_fat = 0;
					$inp_number_hundred_carbs = 0;
					
					$inp_number_serving_calories = 0;
					$inp_number_serving_proteins = 0;
					$inp_number_serving_fat = 0;
					$inp_number_serving_carbs = 0;
					
					$inp_number_total_weight = 0;

					$inp_number_total_calories = 0;
					$inp_number_total_proteins = 0;
					$inp_number_total_fat = 0;

					$inp_number_total_carbs = 0;
					

					$query_groups = "SELECT group_id, group_title FROM $t_recipes_groups WHERE group_recipe_id=$get_recipe_id";
					$result_groups = mysqli_query($link, $query_groups);
					while($row_groups = mysqli_fetch_row($result_groups)) {
						list($get_group_id, $get_group_title) = $row_groups;

						$query_items = "SELECT item_id, item_amount, item_calories_per_hundred, item_proteins_per_hundred, item_fat_per_hundred, item_carbs_per_hundred, item_calories_calculated, item_proteins_calculated, item_fat_calculated, item_carbs_calculated FROM $t_recipes_items WHERE item_group_id=$get_group_id";
						$result_items = mysqli_query($link, $query_items);
						$row_cnt = mysqli_num_rows($result_items);
						while($row_items = mysqli_fetch_row($result_items)) {
							list($get_item_id, $get_item_amount, $get_item_calories_per_hundred, $get_item_proteins_per_hundred, $get_item_fat_per_hundred, $get_item_carbs_per_hundred, $get_item_calories_calculated, $get_item_proteins_calculated, $get_item_fat_calculated, $get_item_carbs_calculated) = $row_items;


							$inp_number_hundred_calories = $inp_number_hundred_calories+$get_item_calories_per_hundred;
							$inp_number_hundred_proteins = $inp_number_hundred_proteins+$get_item_proteins_per_hundred;
							$inp_number_hundred_fat      = $inp_number_hundred_fat+$get_item_fat_per_hundred;
							$inp_number_hundred_carbs    = $inp_number_hundred_carbs+$get_item_carbs_per_hundred;
					
							$inp_number_total_weight     = $inp_number_total_weight+$get_item_amount;

							$inp_number_total_calories = $inp_number_total_calories+$get_item_calories_calculated;
							$inp_number_total_proteins = $inp_number_total_proteins+$get_item_proteins_calculated;
							$inp_number_total_fat      = $inp_number_total_fat+$get_item_fat_calculated;
							$inp_number_total_carbs    = $inp_number_total_carbs+$get_item_carbs_calculated;
	
						} // items
					} // groups
					
					$inp_number_serving_calories = round($inp_number_total_calories/$get_number_servings);
					$inp_number_serving_proteins = round($inp_number_total_proteins/$get_number_servings);
					$inp_number_serving_fat      = round($inp_number_total_fat/$get_number_servings);
					$inp_number_serving_carbs    = round($inp_number_total_carbs/$get_number_servings);

	
					// Ready numbers for MySQL
					$inp_number_hundred_calories_mysql = quote_smart($link, $inp_number_hundred_calories);
					$inp_number_hundred_proteins_mysql = quote_smart($link, $inp_number_hundred_proteins);
					$inp_number_hundred_fat_mysql      = quote_smart($link, $inp_number_hundred_fat);
					$inp_number_hundred_carbs_mysql    = quote_smart($link, $inp_number_hundred_carbs);
					
					$inp_number_total_weight_mysql     = quote_smart($link, $inp_number_total_weight);

					$inp_number_total_calories_mysql = quote_smart($link, $inp_number_total_calories);
					$inp_number_total_proteins_mysql = quote_smart($link, $inp_number_total_proteins);
					$inp_number_total_fat_mysql      = quote_smart($link, $inp_number_total_fat);
					$inp_number_total_carbs_mysql    = quote_smart($link, $inp_number_total_carbs);

					
					$inp_number_serving_calories_mysql = quote_smart($link, $inp_number_serving_calories);
					$inp_number_serving_proteins_mysql = quote_smart($link, $inp_number_serving_proteins);
					$inp_number_serving_fat_mysql      = quote_smart($link, $inp_number_serving_fat);
					$inp_number_serving_carbs_mysql    = quote_smart($link, $inp_number_serving_carbs);

					$result = mysqli_query($link, "UPDATE $t_recipes_numbers SET number_hundred_calories=$inp_number_hundred_calories_mysql, number_hundred_proteins=$inp_number_hundred_proteins_mysql, number_hundred_fat=$inp_number_hundred_fat_mysql, number_hundred_carbs=$inp_number_hundred_carbs_mysql, 
									number_serving_calories=$inp_number_serving_calories_mysql, number_serving_proteins=$inp_number_serving_proteins_mysql, number_serving_fat=$inp_number_serving_fat_mysql, number_serving_carbs=$inp_number_serving_carbs_mysql,
									number_total_weight=$inp_number_total_weight_mysql, 
									number_total_calories=$inp_number_total_calories_mysql, number_total_proteins=$inp_number_total_proteins_mysql, number_total_fat=$inp_number_total_fat_mysql, number_total_carbs=$inp_number_total_carbs_mysql WHERE number_recipe_id=$recipe_id_mysql");


					$ft = "success";
					$fm = "ingredients_saved";
						
					$loading = "<p style=\"font-weight: bold;\"><img src=\"_design/gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float: left;padding-right: 5px;\" /> Loading</p>
					<meta http-equiv=refresh content=\"1; url=index.php?open=recipes&amp;page=edit_recipe_ingredients&amp;recipe_id=$recipe_id&amp;group_id=$group_id&amp;editor_language=$editor_language&amp;ft=$ft&amp;fm=$fm\">";


					// Give new info
					$group_id_mysql = quote_smart($link, $group_id);
					$query = "SELECT group_id, group_recipe_id, group_title FROM $t_recipes_groups WHERE group_id=$group_id_mysql";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_row($result);
					list($get_group_id, $get_group_recipe_id, $get_group_title) = $row;



				} // group title empty
			}
			
			echo"
			<h1>$l_edit</h1>


			<!-- Menu -->
				<div id=\"tabs\">
					<ul>
						<li><a href=\"index.php?open=$open&amp;editor_language=$editor_language\">$l_recipes</a></li>
						<li><a href=\"index.php?open=$open&amp;page=view_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\">$l_view_recipe</a></li>
						<li><a href=\"index.php?open=$open&amp;page=edit_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"current\">$l_edit</a></li>
						<li><a href=\"index.php?open=$open&amp;page=delete_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\">$l_delete</a></li>
					</ul>
				</div><p>&nbsp;</p>
			<!-- //Menu -->

			<!-- Where am I ? -->
				<p><b>$l_you_are_here:</b><br />
				<a href=\"index.php?open=$open&amp;editor_language=$editor_language\">$l_recipes</a>
				&gt;
				<a href=\"index.php?open=$open&amp;page=view_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"current\">$get_recipe_title</a>
				&gt;
				<a href=\"index.php?open=$open&amp;page=edit_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"current\">$l_edit</a>
				&gt;
				<a href=\"index.php?open=$open&amp;page=edit_recipe_ingredients&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"current\">$l_ingredients</a>
				&gt;
				<a href=\"index.php?open=recipes&amp;page=edit_recipe_ingredients&amp;action=edit_group&amp;recipe_id=$recipe_id&amp;group_id=$group_id&amp;editor_language=$editor_language\">$l_edit_group $get_group_title</a>
				</p>
			<!-- //Where am I ? -->

		
			<!-- Feedback -->
				";
				if(isset($loading)){
					echo"$loading";
				}
				else{
					if($ft != ""){
						if($fm == "group_title_is_empty"){
							$fm = "$l_group_title_is_empty";
						}
						elseif($fm == "you_already_have_a_group_with_that_name"){
							$fm = "$l_you_already_have_a_group_with_that_name";
						}
						else{
							$fm = ucfirst($ft);
						}
						echo"<div class=\"$ft\"><span>$fm</span></div>";
					}
				}
				echo"	
			<!-- //Feedback -->



			<!-- Focus -->
			<script>
			\$(document).ready(function(){\n";
				if($mode == "edit_item"){
					echo"				";
					echo"\$('[name=\"inp_item_amount_$item_id\"]').focus();";
				}
				else{
					echo"				";
					echo"\$('[name=\"inp_group_title\"]').focus();";
				}
				echo"
			});
			</script>
			<!-- //Focus -->


			<!-- Edit group form -->
			<form method=\"post\" action=\"index.php?open=recipes&amp;page=edit_recipe_ingredients&amp;action=edit_group_save&amp;recipe_id=$recipe_id&amp;group_id=$group_id&amp;editor_language=$editor_language\" enctype=\"multipart/form-data\">
	
			<p><b>$l_group_title:</b><br />
			<input type=\"text\" name=\"inp_group_title\" value=\"$get_group_title\" size=\"40\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" />
			</p>

				<table class=\"hor-zebra\">
				 <thead>
				  <tr>
				   <th scope=\"col\">
					<span>$l_amount</span>
				   </th>
				   <th scope=\"col\">
					<span>$l_measurement</span>
		 		   </th>
				   <th scope=\"col\">
					<span>$l_grocery</span>
		 		   </th>
				   <th scope=\"col\">
					<span>$l_calories</span>
		 		   </th>
				   <th scope=\"col\">
					<span>$l_proteins</span>
		 		   </th>
				   <th scope=\"col\">
					<span>$l_fat</span>
		 		   </th>
				   <th scope=\"col\">
					<span>$l_carbs</span>
		 		   </th>
				  </tr>
				 </thead>
				 <tbody>
			";

			// Fetch items
			
			$style = "";
			$query_items = "SELECT item_id, item_amount, item_measurement, item_grocery, item_calories_calculated, item_proteins_calculated, item_fat_calculated, item_carbs_calculated FROM $t_recipes_items WHERE item_group_id=$get_group_id";
			$result_items = mysqli_query($link, $query_items);
			$row_cnt = mysqli_num_rows($result_items);
			while($row_items = mysqli_fetch_row($result_items)) {
				list($get_item_id, $get_item_amount, $get_item_measurement, $get_item_grocery, $get_item_calories_calculated, $get_item_proteins_calculated, $get_item_fat_calculated, $get_item_carbs_calculated) = $row_items;	


				if(isset($style) && $style == "odd"){
					$style = "";
				}
				else{
					$style = "odd";
				}
				if($mode == "edit_item" && $item_id == $get_item_id){ 
					$style = "important";
				}

				echo"
				<tr>
				  <td"; if($style != ""){ echo" class=\"$style\""; } echo">
					<span><input type=\"text\" name=\"inp_item_amount_$get_item_id\" value=\"$get_item_amount\" size=\"3\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\"/></span>
				   </td>
				  <td"; if($style != ""){ echo" class=\"$style\""; } echo">
					<span><input type=\"text\" name=\"inp_item_measurement_$get_item_id\" value=\"$get_item_measurement\" size=\"5\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" /></span>
		 		   </td>
				  <td"; if($style != ""){ echo" class=\"$style\""; } echo">
					<span><input type=\"text\" name=\"inp_item_grocery_$get_item_id\" value=\"$get_item_grocery\" size=\"20\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" /></span>
		 		   </td>
				  <td"; if($style != ""){ echo" class=\"$style\""; } echo">
					<span><input type=\"text\" name=\"inp_item_calories_calculated_$get_item_id\" value=\"$get_item_calories_calculated\" size=\"3\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" /></span>
		 		   </td>
				  <td"; if($style != ""){ echo" class=\"$style\""; } echo">
					<span><input type=\"text\" name=\"inp_item_proteins_calculated_$get_item_id\" value=\"$get_item_proteins_calculated\" size=\"3\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" /></span>
		 		   </td>
				  <td"; if($style != ""){ echo" class=\"$style\""; } echo">
					<span><input type=\"text\" name=\"inp_item_fat_calculated_$get_item_id\" value=\"$get_item_fat_calculated\" size=\"3\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" /></span>
		 		   </td>
				  <td"; if($style != ""){ echo" class=\"$style\""; } echo">
					<span><input type=\"text\" name=\"inp_item_carbs_calculated_$get_item_id\" value=\"$get_item_carbs_calculated\" size=\"3\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" /></span>
		 		   </td>
				  </tr>
				";

				$i++;
			}

			// Add 5 blank rows
			for($x=0;$x<5;$x++){

				if(isset($odd) && $odd == false){
					$odd = true;
				}
				else{
					$odd = false;
				}
				echo"
				<tr>
				  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
					<span><input type=\"text\" name=\"inp_item_amount_$x\" value=\"\" size=\"3\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" /></span>
				   </td>
				   <td"; if($odd == true){ echo" class=\"odd\""; } echo">
					<span><input type=\"text\" name=\"inp_item_measurement_$x\" value=\"\" size=\"5\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" /></span>
		 		   </td>
				   <td"; if($odd == true){ echo" class=\"odd\""; } echo">
					<span><input type=\"text\" name=\"inp_item_grocery_$x\" value=\"\" size=\"20\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" /></span>
		 		   </td>
				   <td"; if($odd == true){ echo" class=\"odd\""; } echo">
					<span><input type=\"text\" name=\"inp_item_calories_calculated_$x\" value=\"\" size=\"3\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" /></span>
		 		   </td>
				   <td"; if($odd == true){ echo" class=\"odd\""; } echo">
					<span><input type=\"text\" name=\"inp_item_proteins_calculated_$x\" value=\"\" size=\"3\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" /></span>
		 		   </td>
				   <td"; if($odd == true){ echo" class=\"odd\""; } echo">
					<span><input type=\"text\" name=\"inp_item_fat_calculated_$x\" value=\"\" size=\"3\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" /></span>
		 		   </td>
				   <td"; if($odd == true){ echo" class=\"odd\""; } echo">
					<span><input type=\"text\" name=\"inp_item_carbs_calculated_$x\" value=\"\" size=\"3\" tabindex=\""; $tabindex = $tabindex + 1; echo"$tabindex\" /></span>
		 		   </td>
				  </tr>
				";
			}
			echo"
				 </tbody>
				</table>

				<p><input type=\"submit\" value=\"$l_save_changes\" class=\"submit\" /></p>
			</form>
			<!-- //Edit group form -->

			";

		} // recipe group found
	} // edit_group
	elseif($action == "delete_item"){
		// Find group
		$group_id_mysql = quote_smart($link, $group_id);
		$query = "SELECT group_id, group_recipe_id, group_title FROM $t_recipes_groups WHERE group_id=$group_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_group_id, $get_group_recipe_id, $get_group_title) = $row;
	
		if($get_group_id == ""){
			echo"
			<h1>Recipe group not found</h1>

			<p>
			<a href=\"index.php?open=$open&amp;page=edit_recipe_ingredients&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"btn\">Back</a>
			</p>
			";
		}
		else{
			// Find item
			$item_id_mysql = quote_smart($link, $item_id);
			$query = "SELECT item_id FROM $t_recipes_items WHERE item_id=$item_id_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_item_id) = $row;

			if($get_item_id == ""){
				echo"
				<h1>Item not found</h1>

				<p>
				<a href=\"index.php?open=$open&amp;page=edit_recipe_ingredients&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"btn\">Back</a>
				</p>
				";
			}
			else{

				// Delete item
				$result = mysqli_query($link, "DELETE FROM $t_recipes_items WHERE item_id=$get_item_id") or die(mysqli_error($link));

				// Header
				$prev_item = $get_item_id-1;
				$url = "index.php?open=recipes&page=edit_recipe_ingredients&mode=delete_item&recipe_id=$recipe_id&group_id=$group_id&editor_language=$editor_language&ft=success&fm=item_deleted#item$prev_item";
				header("Location: $url");
				exit;
			}
		}

	}
	elseif($action == "delete_group"){
		// Find group
		$group_id_mysql = quote_smart($link, $group_id);
		$query = "SELECT group_id, group_recipe_id, group_title FROM $t_recipes_groups WHERE group_id=$group_id_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_group_id, $get_group_recipe_id, $get_group_title) = $row;
	
		if($get_group_id == ""){
			echo"
			<h1>Recipe group not found</h1>

			<p>
			<a href=\"index.php?open=$open&amp;page=edit_recipe_ingredients&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"btn\">Back</a>
			</p>
			";
		}
		else{
			if($process == 1){

				// Delete groups
				$result = mysqli_query($link, "DELETE FROM $t_recipes_groups WHERE group_id=$get_group_id") or die(mysqli_error($link));

				// Delete items
				$result = mysqli_query($link, "DELETE FROM $t_recipes_items WHERE item_group_id=$get_group_id") or die(mysqli_error($link));

				// Header
				$url = "index.php?open=recipes&page=edit_recipe_ingredients&recipe_id=$recipe_id&group_id=$group_id&editor_language=$editor_language&ft=success&fm=group_delete";
				header("Location: $url");
				exit;
			}
			echo"
			<h1>$l_edit</h1>


			<!-- Menu -->
				<div id=\"tabs\">
					<ul>
						<li><a href=\"index.php?open=$open&amp;editor_language=$editor_language\">$l_recipes</a></li>
						<li><a href=\"index.php?open=$open&amp;page=view_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\">$l_view_recipe</a></li>
						<li><a href=\"index.php?open=$open&amp;page=edit_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"current\">$l_edit</a></li>
						<li><a href=\"index.php?open=$open&amp;page=delete_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\">$l_delete</a></li>
					</ul>
				</div><p>&nbsp;</p>
			<!-- //Menu -->

			<!-- Where am I ? -->
				<p><b>$l_you_are_here:</b><br />
				<a href=\"index.php?open=$open&amp;editor_language=$editor_language\">$l_recipes</a>
				&gt;
				<a href=\"index.php?open=$open&amp;page=view_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"current\">$get_recipe_title</a>
				&gt;
				<a href=\"index.php?open=$open&amp;page=edit_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"current\">$l_edit</a>
				&gt;
				<a href=\"index.php?open=$open&amp;page=edit_recipe_ingredients&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"current\">$l_ingredients</a>
				&gt;
				<a href=\"index.php?open=recipes&amp;page=edit_recipe_ingredients&amp;action=edit_group&amp;recipe_id=$recipe_id&amp;group_id=$group_id&amp;editor_language=$editor_language\">$l_delete $get_group_title</a>
				</p>
			<!-- //Where am I ? -->


			<!-- Delete form -->
				<h2>$l_delete $get_group_title</h2>
				<p>$l_are_you_sure_you_want_to_delete_the_group</p>

				<p>
				<a href=\"index.php?open=recipes&amp;page=edit_recipe_ingredients&amp;action=delete_group&amp;recipe_id=$recipe_id&amp;group_id=$group_id&amp;editor_language=$editor_language&amp;process=1\" class=\"btn\">$l_confirm_delete</a>
				</p>
			";

		}
	}
} // recipe found
?>