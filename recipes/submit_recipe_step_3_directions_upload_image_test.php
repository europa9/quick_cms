<?php 
/**
*
* File: recipes/submit_recipe_step_3_directions_image_uploader.php
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

/*- Functions ------------------------------------------------------------------------- */
include("$root/_admin/_functions/encode_national_letters.php");
include("$root/_admin/_functions/decode_national_letters.php");

/*- Translation ------------------------------------------------------------------------ */
include("$root/_admin/_translations/site/$l/recipes/ts_recipes.php");

/*- Variables ------------------------------------------------------------------------- */
if(isset($_GET['mode'])){
	$mode = $_GET['mode'];
	$mode = output_html($mode);
}
else{
	$mode = "";
}
if(isset($_GET['recipe_id'])){
	$recipe_id = $_GET['recipe_id'];
	$recipe_id = output_html($recipe_id);
}
else{
	$recipe_id = "";
}
$tabindex = 0;
$l_mysql = quote_smart($link, $l);

/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_recipes - $l_submit_recipe";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */

// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
	// Get my user
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);
	$query = "SELECT user_id, user_email, user_name, user_alias, user_rank FROM $t_users WHERE user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_user_id, $get_user_email, $get_user_name, $get_user_alias, $get_user_rank) = $row;


	// Get recipe
	$recipe_id_mysql = quote_smart($link, $recipe_id);

	$query = "SELECT recipe_id, recipe_user_id, recipe_title, recipe_category_id, recipe_image_path, recipe_image, recipe_thumb_278x156, recipe_video FROM $t_recipes WHERE recipe_id=$recipe_id_mysql AND recipe_user_id=$my_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_recipe_id, $get_recipe_user_id, $get_recipe_title, $get_recipe_category_id, $get_recipe_image_path, $get_recipe_image, $get_recipe_thumb_278x156, $get_recipe_video) = $row;

	if($get_recipe_id == ""){
		echo"
		<h1>Server error</h1>

		<p>
		Recipe not found.
		</p>
		";
	}
	else{
		echo"



			<form method=\"POST\" action=\"submit_recipe_step_3_directions_upload_image.php?recipe_id=$get_recipe_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
					<p>
					<input name=\"inp_image\" type=\"file\" tabindex=\"1\" />
					<input type=\"submit\" value=\"Upload\" tabindex=\"2\" />
					</p>

			</form>
	
		";
	} // recipe found
}
else{
	$action = "noshow";
	echo"
	<h1>
	<img src=\"$root/_webdesign/images/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/index.php?page=login&amp;l=$l&amp;refer=$root/recipes/submit_recipe.php\">
	";
}



/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>