<?php 
/**
*
* File: recipes/step_7_links.php
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
	

	// Get recipe
	$recipe_id_mysql = quote_smart($link, $recipe_id);
	$inp_recipe_user_id = $_SESSION['user_id'];
	$inp_recipe_user_id = output_html($inp_recipe_user_id);
	$inp_recipe_user_id_mysql = quote_smart($link, $inp_recipe_user_id);


	$query = "SELECT recipe_id, recipe_language FROM $t_recipes WHERE recipe_user_id=$inp_recipe_user_id_mysql AND recipe_id=$recipe_id_mysql AND recipe_user_id=$inp_recipe_user_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_recipe_id, $get_recipe_language) = $row;


	if($get_recipe_id == ""){
		echo"
		<h1>Server error</h1>

		<p>
		Recipe not found.
		</p>
		";
	}
	else{
		if($process == 1){
			
					// Delete all old links
		$result = mysqli_query($link, "DELETE FROM $t_recipes_links WHERE link_recipe_id=$get_recipe_id");
				
		// Lang
		$inp_language_mysql = quote_smart($link, $get_recipe_language);

		$inp_title_a = $_POST['inp_title_a'];
		$inp_title_a = output_html($inp_title_a);
		$inp_title_a_mysql = quote_smart($link, $inp_title_a);

		$inp_url_a = $_POST['inp_url_a'];
		$inp_url_a = output_html($inp_url_a);
		$size = strlen($inp_url_a);
		if($size > 3){
			$check = substr($inp_url_a, 0, 3);
			if($check != "htt"){
				$inp_url_a = "http://" . $inp_url_a;
			}
		}
		$inp_url_a_mysql = quote_smart($link, $inp_url_a);

		if($inp_title_a != "" && $inp_url_a != ""){
			// Insert
			mysqli_query($link, "INSERT INTO $t_recipes_links 
			(link_id, link_language, link_recipe_id, link_title, link_url, link_unique_click, link_unique_click_ipblock, link_user_id) 
			VALUES 
			(NULL, $inp_language_mysql, $get_recipe_id, $inp_title_a_mysql, $inp_url_a_mysql, '0', '', $my_user_id_mysql)")
			or die(mysqli_error($link));
		}


		$inp_title_b = $_POST['inp_title_b'];
		$inp_title_b = output_html($inp_title_b);
		$inp_title_b_mysql = quote_smart($link, $inp_title_b);

		$inp_url_b = $_POST['inp_url_b'];
		$inp_url_b = output_html($inp_url_b);
		$size = strlen($inp_url_b);
		if($size > 3){
			$check = substr($inp_url_b, 0, 3);
			if($check != "htt"){
				$inp_url_b = "http://" . $inp_url_b;
			}
		}
		$inp_url_b_mysql = quote_smart($link, $inp_url_b);

		if($inp_title_b != "" && $inp_url_b != ""){
			// Insert
			mysqli_query($link, "INSERT INTO $t_recipes_links 
			(link_id, link_language, link_recipe_id, link_title, link_url, link_unique_click, link_unique_click_ipblock, link_user_id) 
			VALUES 
			(NULL, $inp_language_mysql, $get_recipe_id, $inp_title_b_mysql, $inp_url_b_mysql, '0', '', $my_user_id_mysql)")
			or die(mysqli_error($link));
		}

		$inp_title_c = $_POST['inp_title_c'];
		$inp_title_c = output_html($inp_title_c);
		$inp_title_c_mysql = quote_smart($link, $inp_title_c);

		$inp_url_c = $_POST['inp_url_c'];
		$inp_url_c = output_html($inp_url_c);
		$size = strlen($inp_url_c);
		if($size > 3){
			$check = substr($inp_url_c, 0, 3);
			if($check != "htt"){
				$inp_url_c = "http://" . $inp_url_c;
			}
		}
		$inp_url_c_mysql = quote_smart($link, $inp_url_c);

		if($inp_title_c != "" && $inp_url_c != ""){
			// Insert
			mysqli_query($link, "INSERT INTO $t_recipes_links 
			(link_id, link_language, link_recipe_id, link_title, link_url, link_unique_click, link_unique_click_ipblock, link_user_id) 
			VALUES 
			(NULL, $inp_language_mysql, $get_recipe_id, $inp_title_c_mysql, $inp_url_c_mysql, '0', '', $my_user_id_mysql)")
			or die(mysqli_error($link));
		}


			// Header
			$url = "submit_recipe_step_8_finish.php?&recipe_id=$recipe_id&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;
		}
		echo"
		<h1>$l_links</h1>

		<!-- Feedback -->
			";
			if($ft != ""){
				if($fm == "changes_saved"){
					$fm = "$l_changes_saved";
				}
				else{
					$fm = ucfirst($fm);
				}
				echo"<div class=\"$ft\"><span>$fm</span></div>";
			}
			echo"	
		<!-- //Feedback -->



		<!-- Form -->
	
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_title_a\"]').focus();
			});
			</script>
			<form method=\"post\" action=\"submit_recipe_step_7_links.php?recipe_id=$recipe_id&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
			";
			// Fetch links
			$y = 1;
			$query = "SELECT link_id, link_title, link_url FROM $t_recipes_links WHERE link_recipe_id=$get_recipe_id ORDER BY link_id ASC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_link_id, $get_link_title, $get_link_url) = $row;
			
					if($y == "1"){
						$letter = "_a";
					}
					elseif($y == "2"){
						$letter = "_b";
					}
					elseif($y == "3"){
						$letter = "_c";
					}
					echo"
					<p style=\"padding-bottom:0;margin-bottom:0;\"><b>$l_link $y</b></p>
					<p>$l_title:<br />
					<input type=\"text\" name=\"inp_title$letter\" value=\"$get_link_title\" size=\"20\" />
					</p>
					<p>$l_url:<br />
					<input type=\"text\" name=\"inp_url$letter\" value=\"$get_link_url\" size=\"20\" /></p>
					";
					$y++;
				}
				
				
				if($y == 1){
					echo"
					<p style=\"padding-bottom:0;margin-bottom:0;\"><b>$l_link 1</b></p>
					<p>$l_title:<br />
					<input type=\"text\" name=\"inp_title_a\" value=\"\" size=\"20\" /></p>
					<p>$l_url:<br />
					<input type=\"text\" name=\"inp_url_a\" value=\"\" size=\"20\" /></p>

					<p style=\"padding-bottom:0;margin-bottom:0;\"><b>$l_link 2</b></p>
					<p>$l_title:<br />
					<input type=\"text\" name=\"inp_title_b\" value=\"\" size=\"20\" /></p>
					<p>$l_url:<br />
					<input type=\"text\" name=\"inp_url_b\" value=\"\" size=\"20\" /></p>

					<p style=\"padding-bottom:0;margin-bottom:0;\"><b>$l_link 3</b></p>
					<p>$l_title:<br />
					<input type=\"text\" name=\"inp_title_c\" value=\"\" size=\"20\" /></p>
					<p>$l_url:<br />
					<input type=\"text\" name=\"inp_url_c\" value=\"\" size=\"20\" /></p>
					";

				}
				elseif($y == 2){
					echo"

					<p style=\"padding-bottom:0;margin-bottom:0;\"><b>$l_link 2</b></p>
					<p>$l_title:<br />
					<input type=\"text\" name=\"inp_title_b\" value=\"\" size=\"20\" /></p>
					<p>$l_url:<br />
					<input type=\"text\" name=\"inp_url_b\" value=\"\" size=\"20\" /></p>

					<p style=\"padding-bottom:0;margin-bottom:0;\"><b>$l_link 3</b></p>
					<p>$l_title:<br />
					<input type=\"text\" name=\"inp_title_c\" value=\"\" size=\"20\" /></p>
					<p>$l_url:<br />
					<input type=\"text\" name=\"inp_url_c\" value=\"\" size=\"20\" /></p>
					";

				}
				elseif($y == 3){
					echo"

					<p style=\"padding-bottom:0;margin-bottom:0;\"><b>$l_link 3</b></p>
					<p>$l_title:<br />
					<input type=\"text\" name=\"inp_title_c\" value=\"\" size=\"20\" /></p>
					<p>$l_url:<br />
					<input type=\"text\" name=\"inp_url_c\" value=\"\" size=\"20\" /></p>
					";

				}
				echo"


			<p>
			<input type=\"submit\" value=\"$l_continue\" class=\"btn\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
			</p>
			</form>

		<!-- //Form -->

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