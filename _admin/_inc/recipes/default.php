<?php
/**
*
* File: _admin/_inc/recipes/default.php
* Version 1.0
* Date 13:41 04.11.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Variables ------------------------------------------------------------------------ */
if(isset($_GET['view'])) {
	$view = $_GET['view'];
	$view = strip_tags(stripslashes($view));
}
else{
	$view = "";
}


/*- Tables ---------------------------------------------------------------------------- */
$t_recipes 	 	= $mysqlPrefixSav . "recipes";
$t_recipes_ingredients	= $mysqlPrefixSav . "recipes_ingredients";
$t_recipes_groups	= $mysqlPrefixSav . "recipes_groups";
$t_recipes_items	= $mysqlPrefixSav . "recipes_items";
$t_recipes_numbers	= $mysqlPrefixSav . "recipes_numbers";
$t_recipes_rating	= $mysqlPrefixSav . "recipes_rating";
$t_recipes_cuisines	= $mysqlPrefixSav . "recipes_cuisines";
$t_recipes_seasons	= $mysqlPrefixSav . "recipes_seasons";
$t_recipes_occasions	= $mysqlPrefixSav . "recipes_occasions";



	echo"
	<h1>$l_recipes</h1>


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

	<!-- Views -->
		<div class=\"tabs\">
			<ul>
				<li><a href=\"index.php?open=$open&amp;editor_language=$editor_language\""; if($view == ""){ echo" class=\"active\""; } echo">$l_all</a>
				<li><a href=\"index.php?open=$open&amp;view=marked_as_spam&amp;editor_language=$editor_language\""; if($view == "marked_as_spam"){ echo" class=\"active\""; } echo">$l_marked_as_spam</a>
				<li><a href=\"index.php?open=$open&amp;page=recipes_to_sql&amp;editor_language=$editor_language\">Recipes to SQL</a>
				<li><a href=\"index.php?open=$open&amp;page=recipes_to_sqlite\">Recipes to SQLite</a>
				<li><a href=\"index.php?open=$open&amp;page=rest_to_sqlite&amp;editor_language=$editor_language\">Rest to SQLite</a>
			</ul>
		</div><p>&nbsp;</p>
	<!-- //Views -->


	<!-- List all recipes -->
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span>$l_recipe</span>
		   </th>
		   <th scope=\"col\">
			<span>$l_author</span>
		   </th>
		   <th scope=\"col\">
			<span>$l_date</span>
		   </th>
		   <th scope=\"col\">
			<span>$l_actions</span>
		   </th>
		  </tr>
		</thead>
		<tbody>
		";
	


		$editor_language_mysql = quote_smart($link, $editor_language);
		$query = "SELECT $t_recipes.recipe_id, $t_recipes.recipe_user_id, $t_recipes.recipe_title, $t_recipes.recipe_introduction, $t_recipes.recipe_image_path, $t_recipes.recipe_image, $t_recipes.recipe_date, $t_recipes.recipe_unique_hits, $t_users.user_name FROM $t_recipes 
			JOIN $t_users ON $t_recipes.recipe_user_id=$t_users.user_id  WHERE recipe_language=$editor_language_mysql";
		if($view == "marked_as_spam"){
			$query = $query  . " AND recipe_marked_as_spam='1'";
		}
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_recipe_id, $get_recipe_user_id, $get_recipe_title, $get_recipe_introduction, $get_recipe_image_path, $get_recipe_image, $get_recipe_date, $get_recipe_unique_hits, $get_user_name) = $row;

			if(isset($odd) && $odd == false){
				$odd = true;
			}
			else{
				$odd = false;
			}

			echo"
			<tr>
			  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
				<div style=\"float:left;margin-right: 10px;\">
					";
					if($get_recipe_image != ""){
						echo"<img src=\"../image.php/$get_recipe_image.png?width=55&height=55&cropratio=1:1&image=/$get_recipe_image_path/$get_recipe_image\" />";
					}
					echo"
				</div>
				<div style=\"float:left;\">
					<a href=\"index.php?open=$open&amp;page=view_recipe&amp;recipe_id=$get_recipe_id&amp;editor_language=$editor_language\">$get_recipe_title</a><br />
					$get_recipe_introduction
					</p>
				</div>
				
			  </td>
			  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
				<span><a href=\"index.php?open=users&amp;page=users_edit_user&amp;user_id=$get_recipe_user_id&amp;editor_language=$editor_language\">$get_user_name</a></span>
			  </td>
			  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
				<span>$get_recipe_date</span>
			  </td>
			  <td"; if($odd == true){ echo" class=\"odd\""; } echo">
				<span>
				<a href=\"index.php?open=$open&amp;page=edit_recipe&amp;recipe_id=$get_recipe_id&amp;editor_language=$editor_language\">$l_edit</a>
				&middot;
				<a href=\"index.php?open=$open&amp;page=view_recipe&amp;recipe_id=$get_recipe_id&amp;editor_language=$editor_language\">$l_view</a>
				&middot;
				<a href=\"index.php?open=$open&amp;page=delete_recipe&amp;recipe_id=$get_recipe_id&amp;editor_language=$editor_language\">$l_delete</a>
				</span>
			 </td>
			</tr>
			";
		}
		echo"
		 </tbody>
		</table>
	<!-- //List all recipes -->
";
?>