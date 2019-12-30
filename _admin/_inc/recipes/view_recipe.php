<?php
/**
*
* File: _admin/_inc/recipes/view_recipe.php
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
if(isset($_GET['recipe_id'])) {
	$recipe_id = $_GET['recipe_id'];
	$recipe_id = strip_tags(stripslashes($recipe_id));
}
else{
	$recipe_id = "";
}

// Select
$recipe_id_mysql = quote_smart($link, $recipe_id);
$query = "SELECT recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_introduction, recipe_directions, recipe_image_path, recipe_image, recipe_thumb, recipe_video, recipe_date, recipe_time, recipe_cusine_id, recipe_season_id, recipe_occasion_id, recipe_marked_as_spam, recipe_unique_hits, recipe_unique_hits_ip_block, recipe_user_ip, recipe_notes, recipe_password FROM $t_recipes WHERE recipe_id=$recipe_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_recipe_id, $get_recipe_user_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_language, $get_recipe_introduction, $get_recipe_directions, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb, $get_recipe_video, $get_recipe_date, $get_recipe_time, $get_recipe_cusine_id, $get_recipe_season_id, $get_recipe_occasion_id, $get_recipe_marked_as_spam, $get_recipe_unique_hits, $get_recipe_unique_hits_ip_block, $get_recipe_user_ip, $get_recipe_notes, $get_recipe_password) = $row;

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
	// Select Nutrients
	$query = "SELECT number_id, number_recipe_id, number_hundred_calories, number_hundred_proteins, number_hundred_fat, number_hundred_carbs, number_serving_calories, number_serving_proteins, number_serving_fat, number_serving_carbs, number_total_weight, number_total_calories, number_total_proteins, number_total_fat, number_total_carbs, number_servings FROM $t_recipes_numbers WHERE number_recipe_id=$recipe_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_number_id, $get_number_recipe_id, $get_number_hundred_calories, $get_number_hundred_proteins, $get_number_hundred_fat, $get_number_hundred_carbs, $get_number_serving_calories, $get_number_serving_proteins, $get_number_serving_fat, $get_number_serving_carbs, $get_number_total_weight, $get_number_total_calories, $get_number_total_proteins, $get_number_total_fat, $get_number_total_carbs, $get_number_servings) = $row;


	// Check integritet
	if($get_recipe_date == ""){
		$get_recipe_date = date("Y-m-d");
		$get_recipe_time = date("H:i");
		$result = mysqli_query($link, "UPDATE $t_recipes SET recipe_date='$get_recipe_date', recipe_time='$get_recipe_time' WHERE recipe_id=$recipe_id_mysql");
	}

	// Author
	$query = "SELECT user_alias FROM $t_users WHERE user_id=$get_recipe_user_id";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_user_alias) = $row;

	// Date
	$recipe_year = substr($get_recipe_date, 0, 4);
	$recipe_month = substr($get_recipe_date, 5, 2);
	$recipe_day = substr($get_recipe_date, 8, 2);
	
	if($recipe_month == 01){
		$recipe_month_saying = $l_january;
	}
	elseif($recipe_month == 02){
		$recipe_month_saying = $l_february;
	}
	elseif($recipe_month == 03){
		$recipe_month_saying = $l_march;
	}
	elseif($recipe_month == 04){
		$recipe_month_saying = $l_april;
	}
	elseif($recipe_month == 05){
		$recipe_month_saying = $l_may;
	}
	elseif($recipe_month == 06){
		$recipe_month_saying = $l_june;
	}
	elseif($recipe_month == 07){
		$recipe_month_saying = $l_july;
	}
	elseif($recipe_month == 08){
		$recipe_month_saying = $l_august;
	}
	elseif($recipe_month == 09){
		$recipe_month_saying = $l_september;
	}
	elseif($recipe_month == 10){
		$recipe_month_saying = $l_october;
	}
	elseif($recipe_month == 11){
		$recipe_month_saying = $l_november;
	}
	else{
		$recipe_month_saying = $l_december;
	}

	// Time
	$get_recipe_time = substr($get_recipe_time, 0, 5);

	echo"
	<h1>$l_view_recipe</h1>


	<!-- Menu -->
		<div class=\"tabs\">
			<ul>
				<li><a href=\"index.php?open=$open&amp;editor_language=$editor_language\">$l_recipes</a>
				<li><a href=\"index.php?open=$open&amp;page=view_recipe&amp;recipe_id=$recipe_id&amp;&amp;editor_language=$editor_language\" class=\"current\">$l_view_recipe</a>
				<li><a href=\"index.php?open=$open&amp;page=edit_recipe&amp;recipe_id=$recipe_id&amp;&amp;editor_language=$editor_language\">$l_edit</a>
				<li><a href=\"index.php?open=$open&amp;page=delete_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\">$l_delete</a>
			</ul>
		</div><p>&nbsp;</p>
	<!-- //Menu -->

	<!-- Where am I ? -->
		<p><b>$l_you_are_here:</b><br />
		<a href=\"index.php?open=$open&amp;editor_language=$editor_language\">$l_recipes</a>
		&gt;
		<a href=\"index.php?open=$open&amp;page=view_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"current\">$get_recipe_title</a>
		</p>
	<!-- //Where am I ? -->


	<!-- Headline -->
		<h2>$get_recipe_title</h2>
	<!-- //Headline -->

	<!-- Image -->
		";
		if($get_recipe_video != ""){
			
			// <div>
			//	<a href=\"#video\" class=\"toggle\" data-divid=\"view_recipe_video\"><img src=\"../image.php/$get_recipe_image.png?width=847&height=437&image=/$get_recipe_image_path/$get_recipe_image\" /></a>
			//	<br />
			//	<a href=\"#video\" class=\"toggle\" data-divid=\"view_recipe_video\"><img src=\"_inc/recipes/gfx/play.png\" alt=\"play.png\" style=\"position:relative;margin-top: -200px;\" /></a>
			// </div>
			// <div class=\"view_recipe_video\" style=\"display:none;\">

			echo"
			<iframe width=\"847\" height=\"476\" src=\"$get_recipe_video\" frameborder=\"0\" allowfullscreen></iframe>
			";
		}
		else{
			if($get_recipe_image != ""){
				echo"<img src=\"../image.php/$get_recipe_image.png?width=847&height=437&image=/$get_recipe_image_path/$get_recipe_image\" />";
			}
		}
		echo"	
	<!-- //Image -->

	<!-- Info -->
		<div style=\"width: 847px;\">
			<p><b>$l_category</b> $get_recipe_category_id</p>
		</div>
	<!-- //Info -->

	<!-- Author -->
		<p>
		<a href=\"index.php?open=users&amp;page=users_edit_user&amp;user_id=$get_recipe_user_id&amp;l=$l&amp;editor_language=$editor_language\">$get_user_alias</a>
		<span class=\"grey\">&nbsp; $recipe_day $recipe_month_saying $recipe_year &nbsp; $get_recipe_time</span>
		</p>
	<!-- //Author -->

	<!-- Introduction -->
		<p>$get_recipe_introduction

		$l_this_recipe_serves $get_number_servings. </p>
	<!-- //Introduction -->

	<!-- Ingredients and Nutrients -->
		<div class=\"row\">

			<!-- Ingredients -->
				<div class=\"col\" style=\"border: #c9c9c9 1px solid;padding: 0px 10px 0px 10px;\">
					";
					$query_groups = "SELECT group_id, group_title FROM $t_recipes_groups WHERE group_recipe_id=$get_recipe_id";
					$result_groups = mysqli_query($link, $query_groups);
					while($row_groups = mysqli_fetch_row($result_groups)) {
						list($get_group_id, $get_group_title) = $row_groups;
						echo"
						<p style=\"padding-bottom:0;margin-bottom:0;\"><b>$get_group_title</b></p>
							
						<ul style=\"padding:0px 0px 0px 20px;margin:10px 0px 20px 0px;list-style-type: circle;\">\n";
	
						$x = 1;
						$query_items = "SELECT item_id, item_amount, item_measurement, item_grocery FROM $t_recipes_items WHERE item_group_id=$get_group_id";
						$result_items = mysqli_query($link, $query_items);
						$row_cnt = mysqli_num_rows($result_items);
						while($row_items = mysqli_fetch_row($result_items)) {
								list($get_item_id, $get_item_amount, $get_item_measurement, $get_item_grocery) = $row_items;
								echo"							";
								
								 echo"<li style=\"padding: 4px 0px 4px 4px\"><span>$get_item_amount  $get_item_measurement $get_item_grocery</span></li>\n";

								$x++;
						}
						echo"
						</ul>";


					}
				echo"
				</div>
			<!-- //Ingredients -->



			<!-- Nutrients-->
				<div class=\"col\" style=\"border: #c9c9c9 1px solid;border-left: #000 0px solid;padding: 0px 10px 0px 10px;background: #faf4f2;\">

				
					<div class=\"row\">
						<div class=\"col\">
							<p style=\"padding-bottom:0;margin-bottom:0;\"><b>$l_nutrients_total ($get_number_servings $l_servings_lowercase)</b></p>
							<ul style=\"padding:0;margin:10px 0px 10px 0px;list-style-type: none;\">\n";
								
							if($get_number_total_calories != ""){
								echo"								";
								echo"<li style=\"padding: 6px 0px 6px 4px;border-bottom: #ccc7c6 1px solid;\"><span>$l_calories<br /><b>$get_number_total_calories</b></span></li>\n";
							}
							if($get_number_total_fat != ""){
								echo"								";
								echo"<li style=\"padding: 6px 0px 6px 4px;border-bottom: #ccc7c6 1px solid;\"><span>$l_fat<br /><b>$get_number_total_fat</b></span></li>\n";
							}
							if($get_number_total_carbs != ""){
								echo"								";
								echo"<li style=\"padding: 6px 0px 6px 4px;\"><span>$l_carbs<br /><b>$get_number_total_carbs</b></span></li>\n";
							}
							if($get_number_total_proteins != ""){
								echo"								";
								echo"<li style=\"padding: 6px 0px 6px 4px;border-bottom: #ccc7c6 1px solid;\"><span>$l_proteins<br /><b>$get_number_total_proteins</b></span></li>\n";
							}
							echo"
							</ul>
						</div>
						<div class=\"col\">
							<p style=\"padding-bottom:0;margin-bottom:0;\"><b>$l_nutrients_per_serving</b></p>
							<ul style=\"padding:0;margin:10px 0px 10px 0px;list-style-type: none;\">\n";
								
							if($get_number_serving_calories != ""){
								echo"								";
								echo"<li style=\"padding: 6px 0px 6px 4px;border-bottom: #ccc7c6 1px solid;\"><span>$l_calories<br /><b>$get_number_serving_calories</b></span></li>\n";
							}
							if($get_number_serving_fat != ""){
								echo"								";
								echo"<li style=\"padding: 6px 0px 6px 4px;border-bottom: #ccc7c6 1px solid;\"><span>$l_fat<br /><b>$get_number_serving_fat</b></span></li>\n";
							}
							if($get_number_serving_carbs != ""){
								echo"								";
								echo"<li style=\"padding: 6px 0px 6px 4px;\"><span>$l_carbs<br /><b>$get_number_serving_carbs</b></span></li>\n";
							}
							if($get_number_serving_proteins != ""){
								echo"								";
								echo"<li style=\"padding: 6px 0px 6px 4px;border-bottom: #ccc7c6 1px solid;\"><span>$l_proteins<br /><b>$get_number_serving_proteins</b></span></li>\n";
							}
							echo"
							</ul>

					


						</div>
					</div>
				</div>
			<!-- //Nutrients -->



		</div>
	<!-- //Ingredients and Nutrients -->
	


	<!-- Directions -->
		<div class=\"clear\"></div>
		<h2>$l_step_by_step_directions</h2>

		<ul>
		";
		$get_recipe_directions = str_replace("\n", "<br />", $get_recipe_directions);
		
		$array = preg_split('/\d+\./i', $get_recipe_directions);

		for($x=0;$x<sizeof($array);$x++){
			if($array[$x] != ""){
	    			echo"<li style=\"padding: 0px 0px 20px 0px;\"><p><b>$l_step $x</b></p>
				<p>$array[$x]</p>
				</li>\n";
			}
		}


		echo"
		</ul>

	<!-- //Directions -->






	";
} // recipe found
?>