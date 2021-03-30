<?php
/**
*
* File: _admin/_inc/recipes/default.php
* Version 1.0
* Date 23:58 05.01.2021
* Copyright (c) 2021 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}

/*- Functions ------------------------------------------------------------------------ */
include("_functions/get_extension.php");

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



/*- Check if setup is run ------------------------------------------------------------- */
$t_recipes_liquidbase	= $mysqlPrefixSav . "recipes_liquidbase";
$query = "SELECT * FROM $t_recipes_liquidbase LIMIT 1";
$result = mysqli_query($link, $query);
if($result !== FALSE){



	echo"
	<h1>$l_recipes</h1>


	<!-- Feedback -->
	";
	if($ft != ""){
		if($fm == "changes_saved"){
			$fm = "$l_changes_saved";
		}
		else{
			$fm = ucfirst($fm);
			$fm = str_replace("_", " ", $fm);
		}
		echo"<div class=\"$ft\"><span>$fm</span></div>";
	}
	echo"	
	<!-- //Feedback -->

	<!-- Select language -->

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
		$l_language:
		<select id=\"inp_l\">
			<option value=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">$l_editor_language</option>
			<option value=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\">-</option>\n";


			$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;

				$flag_path 	= "_design/gfx/flags/16x16/$get_language_active_flag" . "_16x16.png";

				// No language selected?
				if($editor_language == ""){
						$editor_language = "$get_language_active_iso_two";
				}
				
				
				echo"	<option value=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;editor_language=$get_language_active_iso_two&amp;l=$l\" style=\"background: url('$flag_path') no-repeat;padding-left: 20px;\"";if($editor_language == "$get_language_active_iso_two"){ echo" selected=\"selected\"";}echo">$get_language_active_name</option>\n";
			}
		echo"
		</select>
		</p>
		</form>
	<!-- //Select language -->

	

	<!-- Recipes buttons -->";
		// Navigation
		$query = "SELECT navigation_id FROM $t_pages_navigation WHERE navigation_url_path='recipes/index.php'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_navigation_id) = $row;
		if($get_navigation_id == ""){
			echo"
			<p>
			<a href=\"index.php?open=pages&amp;page=navigation&amp;action=new_auto_insert&amp;module=recipes&amp;editor_language=$editor_language&amp;l=$l&amp;process=1\" class=\"btn_default\">Create navigation</a>
			</p>
			";
		}
		echo"
	<!-- //Recipes buttons -->

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
		";
	
		$x = 0;
		$editor_language_mysql = quote_smart($link, $editor_language);
		$query = "SELECT $t_recipes.recipe_id, $t_recipes.recipe_user_id, $t_recipes.recipe_title, $t_recipes.recipe_introduction, $t_recipes.recipe_image_path, $t_recipes.recipe_image, $t_recipes.recipe_thumb_278x156, $t_recipes.recipe_date, $t_recipes.recipe_unique_hits FROM $t_recipes WHERE recipe_language=$editor_language_mysql";
		if($view == "marked_as_spam"){
			$query = $query  . " AND recipe_marked_as_spam='1'";
		}
		$query = $query . " ORDER BY recipe_title ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_recipe_id, $get_recipe_user_id, $get_recipe_title, $get_recipe_introduction, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb_278x156, $get_recipe_date, $get_recipe_unique_hits) = $row;

			// Style
			if(isset($odd) && $odd == false){
				$odd = true;
			}
			else{
				$odd = false;
			}
			
			// Author
			$query_u = "SELECT user_id, user_name FROM $t_users WHERE user_id=$get_recipe_user_id";
			$result_u = mysqli_query($link, $query_u);
			$row_u = mysqli_fetch_row($result_u);
			list($get_author_user_id, $get_author_user_name) = $row_u;


			// Thumb
			if($get_recipe_image != ""){
				if($get_recipe_thumb_278x156 == "" OR !(file_exists("../$get_recipe_image_path/$get_recipe_thumb_278x156")) && file_exists("../$get_recipe_image_path/$get_recipe_image")){
					$inp_new_x = 278; // 278x156
					$inp_new_y = 156;

					$ext = get_extension($get_recipe_image);

					echo"<div class=\"info\"><p>Creating recipe thumb $inp_new_x x $inp_new_y  px</p></div>";

					$thumb = $get_recipe_id . "_thumb_" . $inp_new_x . "x" . $inp_new_y . ".$ext";
					$thumb_mysql = quote_smart($link, $thumb);
					resize_crop_image($inp_new_x, $inp_new_y, "../$get_recipe_image_path/$get_recipe_image", "../$get_recipe_image_path/$thumb");
					mysqli_query($link, "UPDATE $t_recipes SET recipe_thumb_278x156=$thumb_mysql WHERE recipe_id=$get_recipe_id") or die(mysqli_error($link));
				}
			}


			if($x == "0"){
				echo"
				<div class=\"left_center_center_right_left\">
				";
			}
			elseif($x == "1"){
				echo"
				<div class=\"left_center_center_left_right_center\">
				";
			}
			elseif($x == "2"){
				echo"
				<div class=\"left_center_center_right_right_center\">
				";
			}
			elseif($x == "3"){
				echo"
				<div class=\"left_center_center_right_right\">
				";
			}


			echo"
					
				<p class=\"recipe_image_and_text\">
					<a id=\"recipe$get_recipe_id\"></a>
					<a href=\"index.php?open=$open&amp;page=edit_recipe_general&amp;recipe_id=$get_recipe_id&amp;editor_language=$editor_language&amp;l=$l\"><img src=\"../$get_recipe_image_path/$get_recipe_thumb_278x156\" alt=\"$get_recipe_image\" /></a><br />
					<a href=\"index.php?open=$open&amp;page=edit_recipe_general&amp;recipe_id=$get_recipe_id&amp;editor_language=$editor_language&amp;l=$l\" class=\"recipe_title\">$get_recipe_title</a>
				</p>
				
				<p class=\"recipe_actions\">
					<a href=\"../recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\" class=\"btn_default\">View</a>
					<a href=\"index.php?open=$open&amp;page=edit_recipe_general&amp;recipe_id=$get_recipe_id&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">Edit</a>
					<a href=\"index.php?open=$open&amp;page=delete_recipe&amp;recipe_id=$get_recipe_id&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">Delete</a>
				</p>
					
			</div>

			";
			// Increment
			$x = $x+1;
			if($x == "4"){ 
				echo"<div class=\"clear\"></div>\n";
				$x = 0; 
			}
		}


	if($x == "0"){
	}
	elseif($x == "1"){
		echo"
		</div> <!-- //left_center_center_left_right_left -->

		<div class=\"left_center_center_right_right_center\">
		</div> <!-- //left_center_center_right_right_center -->

		<div class=\"left_center_center_right_right_center\">
		</div> <!-- //left_center_center_right_right_center -->

		<div class=\"left_center_center_right_right\">
		</div> <!-- //left_center_center_right_right -->
		";
	}
	elseif($x == "2"){
		echo"
		<div class=\"left_center_center_right_right_center\">
		</div> <!-- //left_center_center_right_right_center -->

		<div class=\"left_center_center_right_right\">
		</div> <!-- //left_center_center_right_right -->
		";
	}
	elseif($x == "3"){
		echo"
		<div class=\"left_center_center_right_right\">
		</div> <!-- //left_center_center_right_right -->
		";
	}
		echo"
		
	<!-- //List all recipes -->
	";

}
else{
	echo"
	<div class=\"info\"><p><img src=\"_design/gfx/loading_22.gif\" alt=\"loading_22.gif\" /> Running setup</p></div>
	<meta http-equiv=\"refresh\" content=\"1;url=index.php?open=$open&amp;page=tables&amp;refererer=default&amp;editor_language=$editor_language&amp;l=$l\" />
	";
} // setup has not runned
?>