<?php
/**
*
* File: _admin/_inc/recipes/edit_recipe_general.php
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
$t_recipes_categories	= $mysqlPrefixSav . "recipes_categories";


/*- Variables ------------------------------------------------------------------------ */
if(isset($_GET['recipe_id'])) {
	$recipe_id = $_GET['recipe_id'];
	$recipe_id = strip_tags(stripslashes($recipe_id));
}
else{
	$recipe_id = "";
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
	// Get number of servings
	$query = "SELECT number_servings, number_total_calories, number_total_proteins, number_total_fat, number_total_carbs FROM $t_recipes_numbers WHERE number_recipe_id=$recipe_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_number_servings, $get_number_total_calories, $get_number_total_proteins, $get_number_total_fat, $get_number_total_carbs) = $row;

	if($process == 1){
		$inp_recipe_title = $_POST['inp_recipe_title'];
		$inp_recipe_title = output_html($inp_recipe_title);
		$inp_recipe_title_mysql = quote_smart($link, $inp_recipe_title);

		$inp_recipe_introduction = $_POST['inp_recipe_introduction'];
		$inp_recipe_introduction = output_html($inp_recipe_introduction);
		$inp_recipe_introduction = str_replace("<br />", "\n", $inp_recipe_introduction);
		$inp_recipe_introduction_mysql = quote_smart($link, $inp_recipe_introduction);

		$inp_recipe_category_id = $_POST['inp_recipe_category_id'];
		$inp_recipe_category_id = output_html($inp_recipe_category_id);
		$inp_recipe_category_id_mysql = quote_smart($link, $inp_recipe_category_id);

		$inp_recipe_cusine_id = $_POST['inp_recipe_cusine_id'];
		if($inp_recipe_cusine_id != ""){
			$inp_recipe_cusine_id = output_html($inp_recipe_cusine_id);
			$inp_recipe_cusine_id_mysql = quote_smart($link, $inp_recipe_cusine_id);
			$result = mysqli_query($link, "UPDATE $t_recipes SET recipe_cusine_id=$inp_recipe_cusine_id_mysql WHERE recipe_id=$recipe_id_mysql");
		}

		$inp_recipe_occasion_id = $_POST['inp_recipe_occasion_id'];
		if($inp_recipe_occasion_id != ""){
			$inp_recipe_occasion_id = output_html($inp_recipe_occasion_id);
			$inp_recipe_occasion_id_mysql = quote_smart($link, $inp_recipe_occasion_id);
			$result = mysqli_query($link, "UPDATE $t_recipes SET recipe_occasion_id=$inp_recipe_occasion_id_mysql WHERE recipe_id=$recipe_id_mysql");
		}

		$inp_recipe_season_id = $_POST['inp_recipe_season_id'];
		if($inp_recipe_season_id != ""){
			$inp_recipe_season_id = output_html($inp_recipe_season_id);
			$inp_recipe_season_id_mysql = quote_smart($link, $inp_recipe_season_id);
			$result = mysqli_query($link, "UPDATE $t_recipes SET recipe_season_id=$inp_recipe_season_id_mysql WHERE recipe_id=$recipe_id_mysql");
		}

		if(isset($_POST['inp_recipe_marked_as_spam'])){
			$inp_recipe_marked_as_spam = $_POST['inp_recipe_marked_as_spam'];
			if($inp_recipe_marked_as_spam == "on"){
				$inp_recipe_marked_as_spam = 1;
			}
		}
		else{
			$inp_recipe_marked_as_spam = 0;
		}
		
		$inp_recipe_marked_as_spam_mysql = quote_smart($link, $inp_recipe_marked_as_spam);

		$inp_recipe_user_id = $_POST['inp_recipe_user_id'];
		$inp_recipe_user_id = output_html($inp_recipe_user_id);
		$inp_recipe_user_id_mysql = quote_smart($link, $inp_recipe_user_id);


		// Update MySQL
		$result = mysqli_query($link, "UPDATE $t_recipes SET recipe_user_id=$inp_recipe_user_id_mysql, recipe_title=$inp_recipe_title_mysql, recipe_introduction=$inp_recipe_introduction_mysql, 
						recipe_category_id=$inp_recipe_category_id_mysql, recipe_marked_as_spam=$inp_recipe_marked_as_spam_mysql WHERE recipe_id=$recipe_id_mysql");

		// Directions

		$inp_recipe_directions = $_POST['inp_recipe_directions'];
		require_once "_functions/htmlpurifier/HTMLPurifier.auto.php";
		$config = HTMLPurifier_Config::createDefault();
		$purifier = new HTMLPurifier($config);
		$clean_html = $purifier->purify($inp_recipe_directions);
		//$inp_recipe_directions_mysql = quote_smart($link, $inp_recipe_directions);

		$sql = "UPDATE $t_recipes SET recipe_directions=? WHERE recipe_id=$get_recipe_id";
		$stmt = $link->prepare($sql);
		$stmt->bind_param("s", $inp_recipe_directions);
		$stmt->execute();
		if ($stmt->errno) {
			echo "FAILURE!!! " . $stmt->error; die;
		}




		// Servings
		$inp_number_servings = $_POST['inp_number_servings'];
		$inp_number_servings = output_html($inp_number_servings);
		$inp_number_servings_mysql = quote_smart($link, $inp_number_servings);

		if($inp_number_servings != "$get_number_servings"){
			// Update the rest of the numbers
			
					
			$inp_number_serving_calories = round($get_number_total_calories/$inp_number_servings);
			$inp_number_serving_proteins = round($get_number_total_proteins/$inp_number_servings);
			$inp_number_serving_fat      = round($get_number_total_fat/$inp_number_servings);
			$inp_number_serving_carbs    = round($get_number_total_carbs/$inp_number_servings);
	
			$inp_number_serving_calories_mysql = quote_smart($link, $inp_number_serving_calories);
			$inp_number_serving_proteins_mysql = quote_smart($link, $inp_number_serving_proteins);
			$inp_number_serving_fat_mysql      = quote_smart($link, $inp_number_serving_fat);
			$inp_number_serving_carbs_mysql    = quote_smart($link, $inp_number_serving_carbs);



			// Update
			$result = mysqli_query($link, "UPDATE $t_recipes_numbers SET number_servings=$inp_number_servings_mysql, number_serving_calories=$inp_number_serving_calories_mysql, number_serving_proteins=$inp_number_serving_proteins_mysql, number_serving_fat=$inp_number_serving_fat_mysql, number_serving_carbs=$inp_number_serving_carbs_mysql WHERE number_recipe_id=$recipe_id_mysql");
			



		}


		// Header
		$url = "index.php?open=$open&page=$page&recipe_id=$recipe_id&editor_language=$editor_language&ft=success&fm=changes_saved";
		header("Location: $url");
		exit;
	}
	echo"
	<h1>$l_edit</h1>


	<!-- Menu -->
		<div class=\"tabs\">
			<ul>
				<li><a href=\"index.php?open=$open&amp;editor_language=$editor_language\">$l_recipes</a>
				<li><a href=\"index.php?open=$open&amp;page=view_recipe&amp;recipe_id=$recipe_id&amp;&amp;editor_language=$editor_language\">$l_view_recipe</a>
				<li><a href=\"index.php?open=$open&amp;page=edit_recipe&amp;recipe_id=$recipe_id&amp;&amp;editor_language=$editor_language\" class=\"current\">$l_edit</a>
				<li><a href=\"index.php?open=$open&amp;page=delete_recipe&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\">$l_delete</a>
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
		<a href=\"index.php?open=$open&amp;page=edit_recipe_general&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"current\">$l_general</a>
		</p>
	<!-- //Where am I ? -->



	<!-- Feedback -->
	";
	if($ft != ""){
		if($fm == "changes_saved"){
			$fm = "$l_changes_saved";
		}
		else{
			$fm = ucfirst($ft);
		}
		echo"<div class=\"$ft\"><span>$fm</span></div>";
	}
	echo"	
	<!-- //Feedback -->



	<!-- Edit selection -->


		<!-- TinyMCE -->
			<script type=\"text/javascript\" src=\"_javascripts/tinymce/tinymce_4.7.1/tinymce.min.js\"></script>
			<script>
			tinymce.init({
				mode : \"specific_textareas\",
        			editor_selector : \"myTextEditor\",
				plugins: \"image\",
				menubar: \"insert\",
				toolbar: \"image\",
				height: 500,
				menubar: false,
				plugins: [
				    'advlist autolink lists link image charmap print preview anchor textcolor',
				    'searchreplace visualblocks code fullscreen',
				    'insertdatetime media table contextmenu paste code help'
				  ],
				  toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
				  content_css: [
				    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
				    '//www.tinymce.com/css/codepen.min.css']
			});
			</script>
		<!-- //TinyMCE -->


	<!-- Form -->
		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language&amp;process=1\" enctype=\"multipart/form-data\">
	

		<!-- Content Left -->
			<div class=\"content_left\">

				<p><b>$l_title</b><br />
				<input type=\"text\" name=\"inp_recipe_title\" value=\"$get_recipe_title\" size=\"60\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
				</p>

				<p><b>$l_introduction</b><br />
				<textarea name=\"inp_recipe_introduction\" rows=\"2\" cols=\"60\">$get_recipe_introduction</textarea>
				</p>

				<p><b>$l_directions</b><br />
				<textarea name=\"inp_recipe_directions\" rows=\"15\" cols=\"80\" class=\"myTextEditor\">$get_recipe_directions</textarea>
				</p>

				<!-- Buttons -->
					<p>
					<input type=\"submit\" value=\"$l_save_changes\" class=\"submit\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
					</p>
				<!-- //Buttons -->
	
			</div>

		<!-- //Content Left -->
	

		<!-- Content Right -->
			<div class=\"content_right\">
				
				<div class=\"content_right_box\">
					<h2>$l_categorization</h2>


					<p><b>$l_category</b><br />
					<select name=\"inp_recipe_category_id\">\n";
						$query = "SELECT category_id, category_name FROM $t_recipes_categories ORDER BY category_name ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_category_id, $get_category_name) = $row;
							echo"						";
							echo"<option value=\"$get_category_id\""; if($get_recipe_category_id == $get_category_id){ echo" selected=\"selected\""; } echo">$get_category_name</option>\n";
						}
					echo"
					</select>
					</p>

					<p><b>$l_cusine</b><br />
					<select name=\"inp_recipe_cusine_id\">
						<option value=\"\""; if($get_recipe_cusine_id == ""){ echo" selected=\"selected\""; } echo">$l_none</option>\n";
						$query = "SELECT cuisine_id, cuisine_name FROM $t_recipes_cuisines ORDER BY cuisine_name ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_cuisine_id, $get_cuisine_name) = $row;
							echo"						";
							echo"<option value=\"$get_cuisine_id\""; if($get_recipe_cusine_id == $get_cuisine_id){ echo" selected=\"selected\""; } echo">$get_cuisine_name</option>\n";
						}
					echo"
					</select>
					</p>

					<p><b>$l_occasion</b><br />
					<select name=\"inp_recipe_occasion_id\">
						<option value=\"\""; if($get_recipe_occasion_id == ""){ echo" selected=\"selected\""; } echo">$l_none</option>\n";
						$query = "SELECT occasion_id, occasion_name FROM $t_recipes_occasions ORDER BY occasion_name ASC";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_occasion_id, $get_occasion_name) = $row;
							echo"						";
							echo"<option value=\"$get_occasion_id\""; if($get_recipe_occasion_id == $get_occasion_id){ echo" selected=\"selected\""; } echo">$get_occasion_name</option>\n";
						}
					echo"
					</select>
					</p>

					<p><b>$l_season</b><br />
					<select name=\"inp_recipe_season_id\">
						<option value=\"\""; if($get_recipe_season_id == ""){ echo" selected=\"selected\""; } echo">$l_none</option>\n";
						$query = "SELECT season_id, season_name FROM $t_recipes_seasons";
						$result = mysqli_query($link, $query);
						while($row = mysqli_fetch_row($result)) {
							list($get_season_id, $get_season_name) = $row;
							echo"						";
							echo"<option value=\"$get_season_id\""; if($get_recipe_season_id == $get_season_id){ echo" selected=\"selected\""; } echo">$get_season_name</option>\n";
						}
					echo"
					</select>
					</p>

					<p><b>$l_servings</b><br />
					<select name=\"inp_number_servings\">
						<option value=\"\""; if($get_number_servings == ""){ echo" selected=\"selected\""; } echo">$l_none</option>\n";
						for($x=1;$x<21;$x++){
							echo"						";
							echo"<option value=\"$x\""; if($get_number_servings == $x){ echo" selected=\"selected\""; } echo">$x</option>\n";
						}
					echo"
					</select>
					</p>



				</div>



				<div class=\"content_right_box\">
					<h2>$l_admin</h2>


					<p><b>$l_marked_as_spam</b><br />
					<input type=\"checkbox\" name=\"inp_recipe_marked_as_spam\" "; if($get_recipe_marked_as_spam == 1){ echo" checked=\"checked\""; } echo" /> $l_yes
					</p>

					<p><b>$l_user_ip</b><br />
					$get_recipe_user_ip
					</p>

					<p><b>$l_user</b><br />
					<input type=\"text\" name=\"inp_recipe_user_id\" value=\"$get_recipe_user_id\" size=\"3\" />
					</p>



				</div>
			</div>

		<!-- //Content Right -->
	

		</form>

	<!-- //Form -->

	";
} // recipe found
?>