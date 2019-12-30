<?php 
/**
*
* File: recipes/my_recipes.php
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


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_recipes - $l_my_recipes";
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");

/*- Content ---------------------------------------------------------------------------------- */

// Logged in?
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	
}
else{
	$action = "noshow";
	echo"
	<h1>
	<img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" style=\"float:left;padding: 1px 5px 0px 0px;\" />
	Loading...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/recipes/my_recipes.php\">
	";
}

if($action == ""){

	echo"
	<h1>$l_my_recipes</h1>

	<!-- Feedback -->
	";
	if($ft != ""){
		if($fm == "changes_saved"){
			$fm = "$l_changes_saved";
		}
		elseif($fm == "recipe_deleted"){
			$fm = "$l_recipe_deleted";
		}
		else{
			$fm = ucfirst($ft);
		}
		echo"<div class=\"$ft\"><span>$fm</span></div>";
	}
	echo"	
	<!-- //Feedback -->

	<!-- List all recipes -->
		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span>$l_recipe</span>
		   </th>
		   <th scope=\"col\">
			<span>$l_date</span>
		   </th>
		   <th scope=\"col\">
			<span title=\"$l_unique_hits\">$l_unique</span>
		   </th>
		   <th scope=\"col\">
			<span>$l_rating</span>
		   </th>
		   <th scope=\"col\">
			<span>$l_actions</span>
		   </th>
		  </tr>
		</thead>
		<tbody>


	";

	// Select recipes
	$x = 0;
	$user_id = $_SESSION['user_id'];
	$recipe_user_id_mysql = quote_smart($link, $user_id);
	$query = "SELECT recipe_id, recipe_title, recipe_language, recipe_introduction, recipe_image_path, recipe_image, recipe_date, recipe_unique_hits FROM $t_recipes WHERE recipe_user_id=$recipe_user_id_mysql ORDER BY recipe_id DESC";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_recipe_id, $get_recipe_title, $get_recipe_language, $get_recipe_introduction, $get_recipe_image_path, $get_recipe_image, $get_recipe_date, $get_recipe_unique_hits) = $row;

		// Get rating
		$query_rating = "SELECT rating_id, rating_average, rating_popularity FROM $t_recipes_rating WHERE rating_recipe_id='$get_recipe_id'";
		$result_rating = mysqli_query($link, $query_rating);
		$row_rating = mysqli_fetch_row($result_rating);
		list($get_rating_id, $get_rating_average, $get_rating_popularity) = $row_rating;

	
		/*
		$inp_new_x = 110;
		$inp_new_y = 78;
		$thumb = $get_recipe_id . "-" . $inp_new_x . "x" . $inp_new_y . "png";
		if(!(file_exists("$root/_cache/$thumb"))){
			create_thumb("$root/$get_recipe_image_path/$get_recipe_image", "$root/_cache/$thumb", $inp_new_x, $inp_new_y);
		}
		*/

		// Style
		if(isset($style) && $style == ""){
			$style = "odd";
		}
		else{
			$style = "";
		}

		// Title
		$check = strlen($get_recipe_title);
		if($check > 33){
			$get_recipe_title = substr($get_recipe_title, 0, 30);
			$get_recipe_title = $get_recipe_title . "...";
		}

		// Intro
		$check = strlen($get_recipe_introduction);
		if($check > 33){
			$get_recipe_introduction = substr($get_recipe_introduction, 0, 30);
			$get_recipe_introduction = $get_recipe_introduction . "...";
		}

		// Date
		$recipe_year = substr($get_recipe_date, 0, 4);
		$recipe_month = substr($get_recipe_date, 5, 2);
		$recipe_day = substr($get_recipe_date, 8, 2);

		if($recipe_day < 10){
			$recipe_day = substr($recipe_day, 1, 1);
		}
	
		if($recipe_month == "01"){
			$recipe_month_saying = $l_january;
		}
		elseif($recipe_month == "02"){
			$recipe_month_saying = $l_february;
		}
		elseif($recipe_month == "03"){
			$recipe_month_saying = $l_march;
		}
		elseif($recipe_month == "04"){
			$recipe_month_saying = $l_april;
		}
		elseif($recipe_month == "05"){
			$recipe_month_saying = $l_may;
		}
		elseif($recipe_month == "06"){
			$recipe_month_saying = $l_june;
		}
		elseif($recipe_month == "07"){
			$recipe_month_saying = $l_july;
		}
		elseif($recipe_month == "08"){
			$recipe_month_saying = $l_august;
		}
		elseif($recipe_month == "09"){
			$recipe_month_saying = $l_september;
		}
		elseif($recipe_month == "10"){
			$recipe_month_saying = $l_october;
		}
		elseif($recipe_month == "11"){
			$recipe_month_saying = $l_november;
		}
		else{
			$recipe_month_saying = $l_december;
		}


		// Rating
		$query_rating = "SELECT rating_id, rating_recipe_id, rating_1, rating_2, rating_3, rating_4, rating_5, rating_total_votes, rating_average, rating_popularity, rating_ip_block FROM $t_recipes_rating WHERE rating_recipe_id='$get_recipe_id'";
		$result_rating = mysqli_query($link, $query_rating);
		$row_rating = mysqli_fetch_row($result_rating);
		list($get_rating_id, $get_rating_recipe_id, $get_rating_1, $get_rating_2, $get_rating_3, $get_rating_4, $get_rating_5, $get_rating_total_votes, $get_rating_average, $get_rating_popularity, $get_rating_ip_block) = $row_rating;
		if($get_rating_average == ""){
			$get_rating_average = 0;
		}


		echo"
		<tr>
		  <td class=\"$style\">
			 <table>
			  <tr>
			   <td style=\"padding-right: 10px;\">
				";
				if($get_recipe_image != ""){
					echo"<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$get_recipe_language\"><img src=\"$root/image.php?width=100&amp;height=71&amp;image=/$get_recipe_image_path/$get_recipe_image\" alt=\"$get_recipe_image\" /></a>";
				}
				echo"
			   </td>
			   <td>
				<a href=\"$root/recipes/view_recipe.php?recipe_id=$get_recipe_id&amp;l=$get_recipe_language\" class=\"recipe_open_category_a\">$get_recipe_title</a><br />
				$get_recipe_introduction
				</p>
			   </td>
			  </tr>
			 </table>
			
		  </td>
		  <td class=\"$style\">
			<span>$recipe_day $recipe_month_saying $recipe_year</span>
		  </td>
		  <td class=\"$style\" style=\"text-align: center;\">
			<span>$get_recipe_unique_hits</span>
		  </td>
		  <td class=\"$style\" style=\"text-align: center;\">
			<span>$get_rating_average</span>
		  </td>
		  <td class=\"$style\">
			<span>
			<a href=\"edit_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\">$l_edit</a>
			&middot;
			<a href=\"delete_recipe.php?recipe_id=$get_recipe_id&amp;l=$l\">$l_delete</a>
			</span>
		 </td>
		</tr>
		";


	}

		echo"
		 </tbody>
		</table>
	";

}


/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/footer.php");
?>