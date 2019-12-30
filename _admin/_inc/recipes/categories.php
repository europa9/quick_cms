<?php
/**
*
* File: _admin/_inc/recipes/categories.php
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

/*- Tables ---------------------------------------------------------------------------- */
$t_recipes 	 			= $mysqlPrefixSav . "recipes";
$t_recipes_ingredients			= $mysqlPrefixSav . "recipes_ingredients";
$t_recipes_groups			= $mysqlPrefixSav . "recipes_groups";
$t_recipes_items			= $mysqlPrefixSav . "recipes_items";
$t_recipes_numbers			= $mysqlPrefixSav . "recipes_numbers";
$t_recipes_rating			= $mysqlPrefixSav . "recipes_rating";
$t_recipes_cuisines			= $mysqlPrefixSav . "recipes_cuisines";
$t_recipes_cuisines_translations	= $mysqlPrefixSav . "recipes_cuisines_translations";
$t_recipes_seasons			= $mysqlPrefixSav . "recipes_seasons";
$t_recipes_seasons_translations		= $mysqlPrefixSav . "recipes_seasons_translations";
$t_recipes_occasions			= $mysqlPrefixSav . "recipes_occasions";
$t_recipes_occasions_translations	= $mysqlPrefixSav . "recipes_occasions_translations";
$t_recipes_categories			= $mysqlPrefixSav . "recipes_categories";
$t_recipes_categories_translations	= $mysqlPrefixSav . "recipes_categories_translations";
$t_recipes_weekly_special		= $mysqlPrefixSav . "recipes_weekly_special";
$t_recipes_of_the_day			= $mysqlPrefixSav . "recipes_of_the_day";

/*- Variables ------------------------------------------------------------------------ */
if(isset($_GET['category_id'])) {
	$category_id= $_GET['category_id'];
	$category_id = strip_tags(stripslashes($category_id));
}
else{
	$category_id = "";
}


/*- Script start --------------------------------------------------------------------- */
if($action == ""){
	echo"
	<h1>$l_categories</h1>


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

	<!-- Add -->
		<p>
		<a href=\"index.php?open=$open&amp;page=$page&amp;action=add&amp;editor_language=$editor_language\" class=\"btn\">$l_add</a>
		<a href=\"index.php?open=$open&amp;page=$page&amp;action=translations&amp;editor_language=$editor_language\" class=\"btn\">$l_translations</a>
		</p>
	<!-- //Add -->


	<!-- List all categories -->
		<div class=\"vertical\">
			<ul>
		";
	


		$editor_language_mysql = quote_smart($link, $editor_language);
		$query = "SELECT category_id, category_name, category_age_restriction, category_icon_path, category_icon_file FROM $t_recipes_categories";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_category_id, $get_category_name, $get_category_age_restriction, $get_category_icon_path, $get_category_icon_file) = $row;

			if(isset($style) && $style == ""){
				$style = "odd";
			}
			else{
				$style = "";
			}			

			echo"
			<li><a href=\"index.php?open=$open&amp;page=$page&amp;action=edit&amp;category_id=$get_category_id&amp;editor_language=$editor_language\">
			";
			if($get_category_icon_file != "" && file_exists("../$get_category_icon_path/$get_category_icon_file")){
				echo"<img src=\"../$get_category_icon_path/$get_category_icon_file\" alt=\"$get_category_icon_file\" />";
			}
			echo"$get_category_name</a></li>\n";
		}
		echo"
			</ul>
		</div>
	<!-- //List all categories -->
 	";
} // action == "";
elseif($action == "add"){
	if($process == "1"){
		$inp_name = $_POST['inp_name'];
		$inp_name = output_html($inp_name);
		$inp_name_mysql = quote_smart($link, $inp_name);

	
		$inp_age_restriction = $_POST['inp_age_restriction'];
		$inp_age_restriction = output_html($inp_age_restriction);
		$inp_age_restriction_mysql = quote_smart($link, $inp_age_restriction);

		$datetime = date("Y-m-d H:i:s");


		mysqli_query($link, "INSERT INTO $t_recipes_categories
		(category_id, category_name, category_age_restriction, category_last_updated) 
		VALUES 
		(NULL, $inp_name_mysql, $inp_age_restriction_mysql, '$datetime')")
		or die(mysqli_error($link));

		// Get ID
		$category_id_mysql = quote_smart($link, $category_id);
		$query = "SELECT category_id FROM $t_recipes_categories WHERE category_last_updated='$datetime'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_category_id) = $row;
	

		// Image
		

			// Sjekk filen
			$file_name = basename($_FILES['inp_image']['name']);
			$file_exp = explode('.', $file_name); 
			$file_type = $file_exp[count($file_exp) -1]; 
			$file_type = strtolower("$file_type");

			// Finnes mappen?
			$upload_path = "../_uploads/recipes/categories_icons";

			if(!(is_dir("../_uploads"))){
				mkdir("../_uploads");
			}
			if(!(is_dir("../_uploads/recipes"))){
				mkdir("../_uploads/recipes");
			}
			if(!(is_dir("../_uploads/recipes/categories_icons"))){
				mkdir("../_uploads/recipes/categories_icons");
			}

			// Sett variabler
			$new_name = $get_category_id . ".$file_type";
			$target_path = $upload_path . "/" . $new_name;

			// Sjekk om det er en OK filendelse
			$img_feedback = "";
			if($file_type == "jpg" OR $file_type == "jpeg" OR $file_type == "png" OR $file_type == "gif"){
				// Do I already have a image of that type? Then delete the old image..
				if($get_category_icon_file != "" && file_exists("../$get_category_icon_path/$get_category_icon_file")){
					unlink("../$get_category_icon_path/$get_category_icon_file");
				}

					

				if(move_uploaded_file($_FILES['inp_image']['tmp_name'], $target_path)) {
					// Sjekk om det faktisk er et bilde som er lastet opp
					list($width,$height) = getimagesize($target_path);
					if(is_numeric($width) && is_numeric($height)){


						// image path							
						$inp_category_icon_path = "_uploads/recipes/categories_icons";
						$inp_category_icon_path_mysql = quote_smart($link, $inp_category_icon_path);

						// image file
						$inp_category_icon_file = $new_name;
						$inp_category_icon_file_mysql = quote_smart($link, $inp_category_icon_file);

						// Update MySQL

						$result = mysqli_query($link, "UPDATE $t_recipes_categories SET category_icon_path=$inp_category_icon_path_mysql, 
								category_icon_file=$inp_category_icon_file_mysql WHERE category_last_updated='$datetime'") or die(mysqli_error($link));


					}
					else{
						// Dette er en fil som har fått byttet filendelse...
						unlink("$target_path");
					}
				}
				else{
					switch ($_FILES['inp_image'] ['error']){
					case 1:
						$img_feedback = "to_big_file";
					case 2:
						$img_feedback = "to_big_file";
					case 3:
						$img_feedback = "only_parts_uploaded";
					case 4:
						$img_feedback = "no_file_uploaded";
					}
				} // if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
			}
			else{
				$img_feedback = "invalid_file_type&file_type=$file_type";
			} // file type end


		$url = "index.php?open=$open&page=$page&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
		header("Location: $url");
		exit;
	}
	echo"
	<h1>$l_add</h1>

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


	<!-- Focus -->
		<script>
		\$(document).ready(function(){
			\$('[name=\"inp_name\"]').focus();
		});
		</script>
	<!-- //Focus -->


	<!-- Form -->
		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;editor_language=$editor_language&amp;process=1\" enctype=\"multipart/form-data\">


		<p>$l_name:<br />
		<input type=\"text\" name=\"inp_name\" value=\"\" size=\"40\" />
		</p>

		<p>$l_age_restriction:<br />
		<select name=\"inp_age_restriction\">
			<option value=\"0\">$l_no</option>
			<option value=\"1\">$l_yes</option>
		</select>
		</p>

		<p><b>Icon 128x128 png:</b><br />
		<input type=\"file\" name=\"inp_image\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
		</p>


		<p><input type=\"submit\" value=\"$l_save\" class=\"btn\" /></p>
		</form>
	<!-- //Form -->
	

	";
} // add
elseif($action == "edit"){
	// Find
	$category_id_mysql = quote_smart($link, $category_id);
	$query = "SELECT category_id, category_name, category_age_restriction, category_icon_path, category_icon_file FROM $t_recipes_categories WHERE category_id=$category_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_category_id, $get_category_name, $get_category_age_restriction, $get_category_icon_path, $get_category_icon_file) = $row;
	
	if($get_category_id == ""){
		echo"
		<h1>Server error 404</h1>

		<p>Not found in database.</p>

		<p>
		<a href=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language\">Back</a>
		</p>
		";
	} // not found
	else{
		if($process == 1){
			$inp_name = $_POST['inp_name'];
			$inp_name = output_html($inp_name);
			$inp_name_mysql = quote_smart($link, $inp_name);

		
			$inp_age_restriction = $_POST['inp_age_restriction'];
			$inp_age_restriction = output_html($inp_age_restriction);
			$inp_age_restriction_mysql = quote_smart($link, $inp_age_restriction);

			$result = mysqli_query($link, "UPDATE $t_recipes_categories SET category_name=$inp_name_mysql, category_age_restriction=$inp_age_restriction_mysql WHERE category_id=$category_id_mysql") or die(mysqli_error($link));

			// Image


			// Sjekk filen
			$file_name = basename($_FILES['inp_image']['name']);
			$file_exp = explode('.', $file_name); 
			$file_type = $file_exp[count($file_exp) -1]; 
			$file_type = strtolower("$file_type");

			// Finnes mappen?
			$upload_path = "../_uploads/recipes/categories_icons";

			if(!(is_dir("../_uploads"))){
				mkdir("../_uploads");
			}
			if(!(is_dir("../_uploads/recipes"))){
				mkdir("../_uploads/recipes");
			}
			if(!(is_dir("../_uploads/recipes/categories_icons"))){
				mkdir("../_uploads/recipes/categories_icons");
			}

			// Sett variabler
			$new_name = $get_category_id . ".$file_type";
			$target_path = $upload_path . "/" . $new_name;

			// Sjekk om det er en OK filendelse
			$img_feedback = "";
			if($file_type == "jpg" OR $file_type == "jpeg" OR $file_type == "png" OR $file_type == "gif"){
				// Do I already have a image of that type? Then delete the old image..
				if($get_category_icon_file != "" && file_exists("../$get_category_icon_path/$get_category_icon_file")){
					unlink("../$get_category_icon_path/$get_category_icon_file");
				}

					

				if(move_uploaded_file($_FILES['inp_image']['tmp_name'], $target_path)) {
					// Sjekk om det faktisk er et bilde som er lastet opp
					list($width,$height) = getimagesize($target_path);
					if(is_numeric($width) && is_numeric($height)){


						// image path							
						$inp_category_icon_path = "_uploads/recipes/categories_icons";
						$inp_category_icon_path_mysql = quote_smart($link, $inp_category_icon_path);

						// image file
						$inp_category_icon_file = $new_name;
						$inp_category_icon_file_mysql = quote_smart($link, $inp_category_icon_file);

						// Update MySQL

						$result = mysqli_query($link, "UPDATE $t_recipes_categories SET category_icon_path=$inp_category_icon_path_mysql, 
								category_icon_file=$inp_category_icon_file_mysql WHERE category_id=$category_id_mysql") or die(mysqli_error($link));


					}
					else{
						// Dette er en fil som har fått byttet filendelse...
						unlink("$target_path");
					}
				}
				else{
					switch ($_FILES['inp_image'] ['error']){
					case 1:
						$img_feedback = "to_big_file";
					case 2:
						$img_feedback = "to_big_file";
					case 3:
						$img_feedback = "only_parts_uploaded";
					case 4:
						$img_feedback = "no_file_uploaded";
					}
				} // if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
			}
			else{
				$img_feedback = "invalid_file_type&file_type=$file_type";
			} // file type end

			$url = "index.php?open=$open&page=$page&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved&img_feedback=$img_feedback";
			header("Location: $url");
			exit;

		}


		echo"
		<h1>$l_edit</h1>


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
	

		<!-- Focus -->
			<script>
			\$(document).ready(function(){
				\$('[name=\"inp_name\"]').focus();
			});
			</script>
		<!-- //Focus -->

	
		<!-- Form -->
			<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;category_id=$category_id&amp;editor_language=$editor_language&amp;process=1\" enctype=\"multipart/form-data\">


			<p>$l_name:<br />
			<input type=\"text\" name=\"inp_name\" value=\"$get_category_name\" size=\"40\" />
			</p>

			<p>$l_age_restriction:<br />
			<select name=\"inp_age_restriction\">
				<option value=\"0\""; if($get_category_age_restriction == "0"){ echo" selected=\"selected\""; } echo" >$l_no</option>
				<option value=\"1\""; if($get_category_age_restriction == "1"){ echo" selected=\"selected\""; } echo" >$l_yes</option>
			</select>
			</p>


			<p><b>Icon 128x128 png:</b><br />
			<!-- Existing image? -->
			";
			if($get_category_icon_file != "" && file_exists("../$get_category_icon_path/$get_category_icon_file")){
				echo"
				<img src=\"../$get_category_icon_path/$get_category_icon_file\" alt=\"$get_category_icon_file\" />
				</p>

				<p><b>New icon 128x128 png:</b><br />";
			}
			echo"
			<!-- //Existing image? -->
			<input type=\"file\" name=\"inp_image\" tabindex=\"";$tabindex=$tabindex+1;echo"$tabindex\" />
			</p>




			<p><input type=\"submit\" value=\"$l_save\" class=\"btn\" /></p>
			</form>
		<!-- //Form -->

		<!-- Delete -->
			<a href=\"index.php?open=$open&amp;page=$page&amp;action=delete&amp;category_id=$get_category_id&amp;editor_language=$editor_language\">$l_delete</a>
		<!-- //Delete -->
		";
	} // found
	
} // edit
elseif($action == "delete"){
	// Find
	$category_id_mysql = quote_smart($link, $category_id);
	$query = "SELECT category_id, category_name, category_age_restriction FROM $t_recipes_categories WHERE category_id=$category_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_category_id, $get_category_name, $get_category_age_restriction) = $row;
	
	if($get_category_id == ""){
		echo"
		<h1>Server error 404</h1>

		<p>Not found in database.</p>

		<p>
		<a href=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language\">Back</a>
		</p>
		";
	} // not found
	else{
		if($process == 1){
			$result = mysqli_query($link, "DELETE FROM $t_recipes_categories WHERE category_id=$category_id_mysql") or die(mysqli_error($link));


			$url = "index.php?open=$open&page=$page&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
			header("Location: $url");
			exit;

		}


		echo"
		<h1>$l_delete</h1>


		<p>$l_are_you_sure_you_want_to_delete $l_this_action_cannot_be_undone</p>

		<p>
		<a href=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;category_id=$category_id&amp;editor_language=$editor_language&amp;process=1\">$l_delete</a>
		&middot;
		<a href=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;process=1\">$l_cancel</a>
		</p>
		";
	} // found
	
} // delete
elseif($action == "translations"){
	if($process == 1){
		$editor_language_mysql = quote_smart($link, $editor_language);
		$query = "SELECT category_id, category_name, category_age_restriction FROM $t_recipes_categories";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_category_id, $get_category_name, $get_category_age_restriction) = $row;

			$inp_category_translation_value = $_POST["inp_category_translation_value_$get_category_id"];
			$inp_category_translation_value = output_html($inp_category_translation_value);
			$inp_category_translation_value_mysql = quote_smart($link, $inp_category_translation_value);

			// Update
			$result_update = mysqli_query($link, "UPDATE $t_recipes_categories_translations SET category_translation_value=$inp_category_translation_value_mysql WHERE category_id=$get_category_id AND category_translation_language=$editor_language_mysql") or die(mysqli_error($link));
		}

		$url = "index.php?open=$open&page=$page&action=$action&editor_language=$editor_language&l=$l&ft=success&fm=changes_saved";
		header("Location: $url");
		exit;

	}


	echo"
	<h1>$l_translations</h1>


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

	

	<!-- Translate form -->
		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;action=$action&amp;editor_language=$editor_language&amp;l=$l&amp;process=1\" enctype=\"multipart/form-data\">
	

		<table class=\"hor-zebra\">
		 <thead>
		  <tr>
		   <th scope=\"col\">
			<span>$l_name</span>
		   </th>
		   <th scope=\"col\">
			<span>$l_translation</span>
		   </th>
		  </tr>
		</thead>
		<tbody>
		";
	


		$editor_language_mysql = quote_smart($link, $editor_language);
		$query = "SELECT category_id, category_name, category_age_restriction FROM $t_recipes_categories";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_category_id, $get_category_name, $get_category_age_restriction) = $row;

			// Style
			if(isset($style) && $style == ""){
				$style = "odd";
			}
			else{
				$style = "";
			}	

			// Translation
			$query_translation = "SELECT category_translation_id, category_translation_language, category_translation_value FROM $t_recipes_categories_translations WHERE category_id=$get_category_id AND category_translation_language=$editor_language_mysql";
			$result_translation = mysqli_query($link, $query_translation);
			$row_translation = mysqli_fetch_row($result_translation);
			list($get_category_translation_id, $get_category_translation_language, $get_category_translation_value) = $row_translation;
			if($get_category_translation_id == ""){
				// It doesnt exists, create it.

				mysqli_query($link, "INSERT INTO $t_recipes_categories_translations
				(category_translation_id, category_id, category_translation_language, category_translation_value) 
				VALUES 
				(NULL, '$get_category_id', $editor_language_mysql, '')")
				or die(mysqli_error($link));

				echo"<div class=\"info\"><span>L O A D I N G</span></div>";
				echo"
 				<meta http-equiv=\"refresh\" content=\"0;URL='index.php?open=$open&amp;page=$page&amp;action=$action&amp;editor_language=$editor_language&amp;l=$l'\" />
				";

				
			}

			echo"
			<tr>
			  <td class=\"$style\">
				<span>$get_category_name</span>
			  </td>
			  <td class=\"$style\">
				<span><input type=\"text\" name=\"inp_category_translation_value_$get_category_id\" value=\"$get_category_translation_value\" size=\"40\" /></span>
			  </td>
			</tr>
			";
		}
		echo"
		 </tbody>
		</table>

		<p>
		<input type=\"submit\" value=\"$l_save_changes\" class=\"btn\" />
		</p>
		</form>

	<!-- //List all categories -->

	<!-- Back -->
		<p>
		<a href=\"index.php?open=$open&amp;page=$page&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn\">$l_back</a>
		</p>
	<!-- //Back -->
 	";
} // action == "";
?>