<?php
/**
*
* File: _admin/_inc/recipes/edit_recipe_image.php
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
	if($process == 1 && !empty($_FILES)) {
     
		// Sjekk filen
		$file_name = basename($_FILES['inp_image']['name']);
		$file_exp = explode('.', $file_name); 
		$file_type = $file_exp[count($file_exp) -1]; 
		$file_type = strtolower("$file_type");

		// Finnes mappen?
		$year = date("Y");
		$upload_path = "../_uploads/recipes/_image_uploads/$get_recipe_category_id/$get_recipe_user_id/$year";

		if(!(is_dir("../_uploads/recipes/_image_uploads/$get_recipe_category_id"))){
			mkdir("../_uploads/recipes/_image_uploads/$get_recipe_category_id");
		}
		if(!(is_dir("../_uploads/recipes/_image_uploads/$get_recipe_category_id/$get_recipe_user_id"))){
			mkdir("../_uploads/recipes/_image_uploads/$get_recipe_category_id/$get_recipe_user_id");
		}
		if(!(is_dir("../_uploads/recipes/_image_uploads/$get_recipe_category_id/$get_recipe_user_id/$year"))){
			mkdir("../_uploads/recipes/_image_uploads/$get_recipe_category_id/$get_recipe_user_id/$year");
		}


		// Sett variabler
		$new_name = $get_recipe_id . ".png";

		$target_path = $upload_path . "/" . $new_name;

		// Sjekk om det er en OK filendelse
		if($file_type == "jpg" OR $file_type == "png" OR $file_type == "gif"){
			if(move_uploaded_file($_FILES['inp_image']['tmp_name'], $target_path)) {

				// Sjekk om det faktisk er et bilde som er lastet opp
				$image_size = getimagesize($target_path);
				if(is_numeric($image_size[0]) && is_numeric($image_size[1])){

					// Image size
					list($width,$height) = getimagesize($target_path);


					// Dette bildet er OK


					// recipe_image_path
					$inp_recipe_image_path = "_uploads/recipes/_image_uploads/$get_recipe_category_id/$get_recipe_user_id/$year";
					$inp_recipe_image_path_mysql = quote_smart($link, $inp_recipe_image_path);

					// recipe_image
					$inp_recipe_image = $new_name;
					$inp_recipe_image_mysql = quote_smart($link, $inp_recipe_image);

					// recipe_thumb
					$inp_recipe_thumb = $get_recipe_id . "-thumb.png";
					$inp_recipe_thumb_mysql = quote_smart($link, $inp_recipe_thumb);
					
					// IP
					$inp_recipe_user_ip = $_SERVER['REMOTE_ADDR'];
					$inp_recipe_user_ip = output_html($inp_recipe_user_ip);
					$inp_recipe_user_ip_mysql = quote_smart($link, $inp_recipe_user_ip);

					

					// Update MySQL
					$result = mysqli_query($link, "UPDATE $t_recipes SET recipe_image_path=$inp_recipe_image_path_mysql, recipe_image=$inp_recipe_image_mysql, recipe_thumb=$inp_recipe_thumb_mysql, recipe_user_ip=$inp_recipe_user_ip_mysql WHERE recipe_id=$recipe_id_mysql");









					// Rezie image to 847x437
					$newwidth=847;
					$newheight=($height/$width)*$newwidth; // 667
					$tmp=imagecreatetruecolor($newwidth,$newheight);
						
					if($file_type == "jpg" || $file_type == "jpeg" ){
						$src = imagecreatefromjpeg($target_path);
					}
					else{
						$src = imagecreatefrompng($target_path);
					}

					imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
					imagepng($tmp, $target_path);
					imagedestroy($tmp);
					
					
					// Make thumb
					$width = $newwidth;
					$height = $newheight;

					$thumb_final_path = "../" . $inp_recipe_image_path. "/" . $inp_recipe_thumb;
					$newwidth=300;
					$newheight=200; // ($height/$width)*$newwidth
					$tmp=imagecreatetruecolor($newwidth,$newheight);
					$src = imagecreatefrompng($target_path);
					imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
					imagepng($tmp, $thumb_final_path);
					imagedestroy($tmp);
					


					$url = "index.php?open=$open&page=$page&recipe_id=$recipe_id&editor_language=$editor_language&ft=success&fm=image_uploaded";
					header("Location: $url");
					exit;
					
				}
				else{
					// Dette er en fil som har fått byttet filendelse...
					unlink("$target_path");

					$url = "index.php?open=$open&page=$page&recipe_id=$recipe_id&editor_language=$editor_language&ft=error&fm=file_is_not_an_image";
					header("Location: $url");
					exit;
				}
			}
			else{
   				switch ($_FILES['inp_image'] ['error']){
				case 1:
					$url = "index.php?open=$open&page=$page&recipe_id=$recipe_id&editor_language=$editor_language&ft=error&fm=to_big_file";
					header("Location: $url");
					exit;
					break;
				case 2:
					$url = "index.php?open=$open&page=$page&recipe_id=$recipe_id&editor_language=$editor_language&ft=error&fm=to_big_file";
					header("Location: $url");
					exit;
					break;
				case 3:
					$url = "index.php?open=$open&page=$page&recipe_id=$recipe_id&editor_language=$editor_language&ft=error&fm=only_parts_uploaded";
					header("Location: $url");
					exit;
					break;
				case 4:
					$url = "index.php?open=$open&page=$page&recipe_id=$recipe_id&editor_language=$editor_language&ft=error&fm=no_file_uploaded";
					header("Location: $url");
					exit;
					break;
				}
			} // if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
		}
		else{
					$url = "index.php?open=$open&page=$page&recipe_id=$recipe_id&editor_language=$editor_language&ft=error&fm=invalid_file_type&file_type=$file_type";
			header("Location: $url");
			exit;
		}
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
		<a href=\"index.php?open=$open&amp;page=edit_recipe_image&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language\" class=\"current\">$l_image</a>
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




	<!-- Image -->
		";
		if($get_recipe_image != ""){
			echo"<img src=\"../image.php/$get_recipe_image.png?width=847&height=600&image=/$get_recipe_image_path/$get_recipe_image\" />";
		}
		echo"		
	<!-- //Image -->

	<!-- Form -->
		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;recipe_id=$recipe_id&amp;editor_language=$editor_language&amp;process=1\" enctype=\"multipart/form-data\">
	

		<p><b>$l_new_image (847x600 png):</b><br />
		<input type=\"file\" name=\"inp_image\" />
		</p>

		<p>
		<input type=\"submit\" value=\"$l_upload_image\" class=\"submit\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
		</p>
	
			
		</form>

	<!-- //Form -->

	";
} // recipe found
?>