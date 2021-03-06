<?php
/**
*
* File: _admin/_inc/muscles/muscle_edit_image.php
* Version 15.00 03.03.2017
* Copyright (c) 2008-2017 Sindre Andre Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Access check ----------------------------------------------------------------------- */
if(!(isset($define_access_to_control_panel))){
	echo"<h1>Server error 403</h1>";
	die;
}


/*- Tables ----------------------------------------------------------------------------- */
$t_muscles				= $mysqlPrefixSav . "muscles";
$t_muscles_translations 		= $mysqlPrefixSav . "muscles_translations";
$t_muscle_groups 			= $mysqlPrefixSav . "muscle_groups";
$t_muscle_groups_translations	 	= $mysqlPrefixSav . "muscle_groups_translations";



/*- Get extention ---------------------------------------------------------------------- */
function getExtension($str) {
		$i = strrpos($str,".");
		if (!$i) { return ""; } 
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l);
		return $ext;
}


/*- Variables -------------------------------------------------------------------------- */
$editor_language_mysql = quote_smart($link, $editor_language);

if(isset($_GET['muscle_id'])){
	$muscle_id = $_GET['muscle_id'];
	$muscle_id = strip_tags(stripslashes($muscle_id));
}
else{
	$muscle_id = "";
}
if(isset($_GET['main_muscle_group_id'])){
	$main_muscle_group_id = $_GET['main_muscle_group_id'];
	$main_muscle_group_id = strip_tags(stripslashes($main_muscle_group_id));
}
else{
	$main_muscle_group_id = "";
}
if(isset($_GET['sub_muscle_group_id'])){
	$sub_muscle_group_id = $_GET['sub_muscle_group_id'];
	$sub_muscle_group_id = strip_tags(stripslashes($sub_muscle_group_id));
}
else{
	$sub_muscle_group_id = "";
}


/*- Scriptstart ---------------------------------------------------------------------- */

// Find muscle
$muscle_id_mysql = quote_smart($link, $muscle_id);
$query = "SELECT muscle_id, muscle_user_id, muscle_latin_name, muscle_latin_name_clean, muscle_simple_name, muscle_group_id_main, muscle_group_id_sub, muscle_text, muscle_image_path, muscle_image_file, muscle_video_path, muscle_video_file, muscle_unique_hits, muscle_unique_hits_ip_block FROM $t_muscles WHERE muscle_id='$muscle_id_mysql'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_muscle_id, $get_current_muscle_user_id, $get_current_muscle_latin_name, $get_current_muscle_latin_name_clean, $get_current_muscle_simple_name, $get_current_muscle_group_id_main, $get_current_muscle_group_id_sub, $get_current_muscle_text, $get_current_muscle_image_path, $get_current_muscle_image_file, $get_current_muscle_video_path, $get_current_muscle_video_file, $get_current_muscle_unique_hits, $get_current_muscle_unique_hits_ip_block) = $row;

// Find sub
$sub_muscle_group_id_mysql = quote_smart($link, $sub_muscle_group_id);
$query = "SELECT muscle_group_id, muscle_group_name, muscle_group_name_clean, muscle_group_parent_id, muscle_group_image_path, muscle_group_image_file FROM $t_muscle_groups WHERE muscle_group_id='$sub_muscle_group_id_mysql'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_sub_muscle_group_id, $get_current_sub_muscle_group_name, $get_current_sub_muscle_group_name_clean, $get_current_sub_muscle_group_parent_id, $get_current_sub_muscle_group_image_path, $get_current_sub_muscle_group_image_file) = $row;

// Find main
$main_muscle_group_id_mysql = quote_smart($link, $main_muscle_group_id);
$query = "SELECT muscle_group_id, muscle_group_name, muscle_group_name_clean, muscle_group_parent_id, muscle_group_image_path, muscle_group_image_file FROM $t_muscle_groups WHERE muscle_group_id='$main_muscle_group_id_mysql'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_main_muscle_group_id, $get_current_main_muscle_group_name, $get_current_main_muscle_group_name_clean, $get_current_main_muscle_group_parent_id, $get_current_main_muscle_group_image_path, $get_current_main_muscle_group_image_file) = $row;


if($get_current_muscle_id == ""){
	echo"
	<p>Muscle not found.</p>
	";
}
else {
	// Muscle Translation
	$query_translation = "SELECT muscle_translation_id, muscle_translation_simple_name, muscle_translation_text FROM $t_muscles_translations WHERE muscle_translation_muscle_id=$muscle_id_mysql AND muscle_translation_language=$editor_language_mysql";
	$result_translation = mysqli_query($link, $query_translation);
	$row_translation = mysqli_fetch_row($result_translation);
	list($get_current_muscle_translation_id, $get_current_muscle_translation_simple_name, $get_current_muscle_translation_text) = $row_translation;
	if($get_current_muscle_translation_id == ""){
		mysqli_query($link, "INSERT INTO $t_muscles_translations
		(muscle_translation_id, muscle_translation_muscle_id, muscle_translation_language, muscle_translation_simple_name, muscle_translation_text) 
		VALUES 
		(NULL, 	'$get_current_muscle_id', $editor_language_mysql, '$get_current_muscle_simple_name', '')")
		or die(mysqli_error($link));
		echo"<div class=\"info\"><span>L O A D I N G</span></div>";
		echo"
		<meta http-equiv=\"refresh\" content=\"0;URL='index.php?open=$open&amp;page=$page&amp;main_muscle_group_id=$main_muscle_group_id&amp;sub_muscle_group_id=$sub_muscle_group_id&amp;muscle_id=$muscle_id&amp;editor_language=$editor_language&amp;l=$l'\" />
		";
	}
	
	if($get_current_main_muscle_group_name_clean == ""){
		echo"MUSCLE GROUP MAIN IS EMPTY!";
		die;
	}


	if($process == 1){
		$name = stripslashes($_FILES['inp_image']['name']);
		$extension = getExtension($name);
		$extension = strtolower($extension);

		if($name){
			if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
				$ft_image = "warning";
				$fm_image = "unknown_file_extension";
			}
			else{
				// Folders exists?
				if(!(is_dir("../_uploads"))){
					mkdir("../_uploads");
				}
				if(!(is_dir("../_uploads/muscles"))){
					mkdir("../_uploads/muscles");

				}
				if(!(is_dir("../_uploads/muscles/$get_current_main_muscle_group_name_clean"))){
					mkdir("../_uploads/muscles/$get_current_main_muscle_group_name_clean");
				}

				if(!(is_dir("../_uploads/muscles/$get_current_main_muscle_group_name_clean/$get_current_sub_muscle_group_name_clean"))){
					mkdir("../_uploads/muscles/$get_current_main_muscle_group_name_clean/$get_current_sub_muscle_group_name_clean");
				}


 				// Give new name
				$new_name = $get_current_muscle_latin_name_clean . ".png";
				$new_path = "../_uploads/muscles/$get_current_main_muscle_group_name_clean/$get_current_sub_muscle_group_name_clean/";
				$uploaded_file = $new_path . $new_name;

				// Upload file
				if (move_uploaded_file($_FILES['inp_image']['tmp_name'], $uploaded_file)) {


					// Get image size
					$file_size = filesize($uploaded_file);
 
					// Check with and height
					list($width,$height) = getimagesize($uploaded_file);
	
					if($width == "" OR $height == ""){
						$ft_image = "warning";
						$fm_image = "getimagesize_failed";
					}
					else{
						// Update MySQL
						$inp_muscle_image_path = "_uploads/muscles/$get_current_main_muscle_group_name_clean/$get_current_sub_muscle_group_name_clean";
						$inp_muscle_image_path_mysql = quote_smart($link, $inp_muscle_image_path);
						
						$inp_image_mysql = quote_smart($link, $new_name);
						$result = mysqli_query($link, "UPDATE $t_muscles SET muscle_image_path=$inp_muscle_image_path_mysql, muscle_image_file=$inp_image_mysql WHERE muscle_id='$get_current_muscle_id'");
		
						$ft_image = "success";
						$fm_image = "image_uploaded";

					}  // if($width == "" OR $height == ""){
				} // move_uploaded_file
				else{	
					switch ($_FILES['inp_image']['error']) {
						case UPLOAD_ERR_OK:
							$ft_image = "error";
           						$fm_image = "image_to_big";
							break;
						case UPLOAD_ERR_NO_FILE:
           						// $fm_image = "no_file_uploaded";
							break;
						case UPLOAD_ERR_INI_SIZE:
							$ft_image = "error";
           						$fm_image = "to_big_size_in_configuration";
							break;
						case UPLOAD_ERR_FORM_SIZE:
							$ft_image = "error";
           						$fm_image = "to_big_size_in_form";
							break;
						default:
							$ft_image = "error";
           						$fm_image = "unknown_error";
							break;
					}	
				}
			} // extension check
		} // if($image){


		// Delete cache
		$filenames = "";
		$dir = "../_cache/";
		$dirLen = strlen($dir);
		$dp = @opendir($dir);

		while($file = @readdir($dp)) $filenames [] = $file;

		for ($i = 0; $i < count($filenames); $i++){
			$content = $filenames[$i];
			$file_path = "$dir$content";

			if($file_path != "$dir." && $file_path != "$dir.."){
				unlink("$file_path");
			}
		}


		// Header
		$url = "index.php?open=$open&page=$page&main_muscle_group_id=$get_current_main_muscle_group_id&sub_muscle_group_id=$get_current_sub_muscle_group_id&muscle_id=$muscle_id&editor_language=$editor_language";
		$url = $url . "&ft=$ft_image&fm=$fm_image";

		header("Location: $url");
		exit;

	} // process == 1


	echo"

	<!-- Headline and Language -->
		<div style=\"float:left;\">
			<h1>$get_current_muscle_translation_simple_name</h1>
		</div>
		<div style=\"float:left;padding: 14px 0px 0px 500px\">
			<form>
			<select name=\"inp_language\" id=\"inp_language\">\n";

			$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;

				$flag_path 	= "_design/gfx/flags/16x16/$get_language_active_flag" . "_16x16.png";
				// No language selected?
				if($editor_language == ""){
						$editor_language = "$get_language_active_iso_two";
				}
				echo"<option value=\"index.php?open=$open&amp;page=$page&amp;main_muscle_group_id=$main_muscle_group_id&amp;sub_muscle_group_id=$sub_muscle_group_id&amp;muscle_id=$muscle_id&amp;editor_language=$get_language_active_iso_two&amp;l=$l\" style=\"background: url('$flag_path') no-repeat;padding-left: 20px;\"";if($editor_language == "$get_language_active_iso_two"){ echo" selected=\"selected\"";}echo">$get_language_active_name</option>\n";
			}
			echo"
			</select>
			</form>

			<script>
   			 $(function(){
    			  // bind change event to select
    			  $('#inp_language').on('change', function () {
     			     var url = $(this).val(); // get selected value
      			    if (url) { // require a URL
       			       window.location = url; // redirect
      			    }
      			    return false;
   			   });
  			  });
			</script>
		</div>
		<div class=\"clear\"></div>
	<!-- //Headline and Language -->


					
	<!-- Menu -->
		<p>
		<a href=\"index.php?open=$open&amp;page=view_muscle&amp;main_muscle_group_id=$main_muscle_group_id&amp;sub_muscle_group_id=$sub_muscle_group_id&amp;muscle_id=$muscle_id&amp;editor_language=$editor_language\">View</a>
		|
		<a href=\"index.php?open=$open&amp;page=muscle_edit&amp;main_muscle_group_id=$get_current_main_muscle_group_id&amp;sub_muscle_group_id=$get_current_sub_muscle_group_id&amp;muscle_id=$muscle_id&amp;editor_language=$editor_language\">Edit</a>
		|
		<a href=\"index.php?open=$open&amp;page=muscle_edit_image&amp;main_muscle_group_id=$main_muscle_group_id&amp;sub_muscle_group_id=$sub_muscle_group_id&amp;muscle_id=$muscle_id&amp;editor_language=$editor_language\" style=\"font-weight: bold;\">Image</a>
		|
		<a href=\"index.php?open=$open&amp;page=muscle_delete&amp;main_muscle_group_id=$main_muscle_group_id&amp;sub_muscle_group_id=$sub_muscle_group_id&amp;muscle_id=$muscle_id&amp;editor_language=$editor_language\">Delete</a>
		</p>
	<!-- //Menu -->


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

	<!-- Edit form -->
			

		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;main_muscle_group_id=$main_muscle_group_id&amp;sub_muscle_group_id=$sub_muscle_group_id&amp;muscle_id=$muscle_id&amp;editor_language=$editor_language&amp;process=1\" enctype=\"multipart/form-data\">


		<p style=\"padding-bottom:0;\">
		<img src=\"";
		if($get_current_muscle_image_file != "" && file_exists("../$get_current_muscle_image_path/$get_current_muscle_image_file")){
			echo"../image.php?image=/$get_current_muscle_image_path/$get_current_muscle_image_file";
		}
		else{
			echo"_design/gfx/no_thumb.png";
		}
		echo"\" alt=\"$get_current_muscle_latin_name\" style=\"margin-bottom: 5px;\" />
		</p>

		<p><b>New image:</b><br />
		<input type=\"file\" name=\"inp_image\" />
		</p>


		<p>
		<input type=\"submit\" value=\"Save\" class=\"btn\" />
		</p>

		</form>
	<!-- //Edit form -->
	";
} // muscle not found

?>