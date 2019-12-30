<?php 
/**
*
* File: recipes/favorite_recipe_remove.php
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
include("$root/_admin/_translations/site/$l/recipes/ts_recipes.php");

/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['recipe_id'])){
	$recipe_id = $_GET['recipe_id'];
	$recipe_id = output_html($recipe_id);
}
else{
	$recipe_id = "";
}
if(isset($_GET['referer'])){
	$referer = $_GET['referer'];
	$referer = output_html($referer);
}
else{
	$referer = "";
}

$tabindex = 0;
$l_mysql = quote_smart($link, $l);

/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_recipes";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */

// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
	// Get my profile
	$my_user_id = $_SESSION['user_id'];
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	$query = "SELECT user_id, user_alias, user_date_format FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_my_user_id, $get_my_user_alias, $get_my_user_date_format) = $row;

	// Get recipe
	$recipe_id_mysql = quote_smart($link, $recipe_id);
	$query = "SELECT recipe_id, recipe_user_id, recipe_title FROM $t_recipes WHERE recipe_id=$recipe_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_recipe_id, $get_recipe_user_id, $get_recipe_title) = $row;

	if($get_recipe_id == ""){
		echo"
		<h1>Server error</h1>

		<p>
		Recipe not found.
		</p>
		";
	}
	else{
		// Check if I alreaddy have it
		$q = "SELECT recipe_favorite_id FROM $t_recipes_favorites WHERE recipe_favorite_recipe_id=$get_recipe_id AND recipe_favorite_user_id=$my_user_id_mysql";
		$r = mysqli_query($link, $q);
		$rowb = mysqli_fetch_row($r);
		list($get_recipe_favorite_id) = $rowb;
		if($get_recipe_favorite_id != ""){
		
			// Delete
			$result = mysqli_query($link, "DELETE FROM $t_recipes_favorites WHERE recipe_favorite_id=$get_recipe_favorite_id");
			

			// Header
			$ft = "success";
			$fm = "recipe_favorite_removed";

			if($referer == ""){
				$url = "view_recipe.php?recipe_id=$get_recipe_id&l=$l&ft=success&fm=$fm#favorite";
			}
			else{
				$url = "$referer.php?l=$l&ft=success&fm=$fm";
			}
			if($process == "1"){
				header("Location: $url");
				exit;
			}
			else{
				echo"
				<h1>
				<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
				Loading...</h1>
				<meta http-equiv=\"refresh\" content=\"1;url=$url\">
				";

			}
		}


	} // recipe found
}
else{
	echo"
	<h1>
	<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/index.php?page=login&amp;l=$l\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>