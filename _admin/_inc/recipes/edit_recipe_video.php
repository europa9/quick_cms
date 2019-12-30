<?php
/**
*
* File: _admin/_inc/recipes/edit_recipe_video.php
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
$query = "SELECT recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_language, recipe_video FROM $t_recipes WHERE recipe_id=$recipe_id_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_recipe_id, $get_recipe_user_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_language, $get_recipe_video) = $row;

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
	if($process == 1){
		$inp_recipe_video = $_POST['inp_recipe_video'];
		$inp_recipe_video = output_html($inp_recipe_video);
		$inp_recipe_video_mysql = quote_smart($link, $inp_recipe_video);


		// Update MySQL
		$result = mysqli_query($link, "UPDATE $t_recipes SET recipe_video=$inp_recipe_video_mysql WHERE recipe_id=$recipe_id_mysql");



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
		<a href=\"index.php?open=$open&amp;page=edit_recipe_video&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"current\">$l_video</a>
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




	<!-- Video -->
		";
		if($get_recipe_video != ""){
			echo"
			<iframe width=\"847\" height=\"476\" src=\"$get_recipe_video\" frameborder=\"0\" allowfullscreen></iframe>
			";
		}
		echo"		
	<!-- //Video -->

	<!-- Form -->
		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language&amp;process=1\" enctype=\"multipart/form-data\">
	

		<p><b>$l_enter_url_to_embeded_video:</b><br />
		<input type=\"text\" name=\"inp_recipe_video\" value=\"$get_recipe_video\" size=\"60\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" /><br />
		<span class=\"smal\">
		($l_example_video_url)</span>
		</p>

		<p>
		<input type=\"submit\" value=\"$l_save\" class=\"submit\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
		</p>
	
			
		</form>

	<!-- //Form -->




	";
} // recipe found
?>