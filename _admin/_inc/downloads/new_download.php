<?php
/**
*
* File: _admin/_inc/downloads/new_download.php
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

/*- Tables ---------------------------------------------------------------------------- */
$t_downloads_index 				= $mysqlPrefixSav . "downloads_index";
$t_downloads_main_categories 			= $mysqlPrefixSav . "downloads_main_categories";
$t_downloads_main_categories_translations 	= $mysqlPrefixSav . "downloads_main_categories_translations";

$t_downloads_sub_categories 			= $mysqlPrefixSav . "downloads_sub_categories";
$t_downloads_sub_categories_translations 	= $mysqlPrefixSav . "downloads_sub_categories_translations";



/*- Varialbes  ---------------------------------------------------- */
if(isset($_GET['main_category_id'])) {
	$main_category_id = $_GET['main_category_id'];
	$main_category_id = strip_tags(stripslashes($main_category_id));
}
else{
	$main_category_id = "";
}
if(isset($_GET['sub_category_id'])) {
	$sub_category_id = $_GET['sub_category_id'];
	$sub_category_id = strip_tags(stripslashes($sub_category_id));
}
else{
	$sub_category_id = "";
}


/*- Functions ---------------------------------------------------- */


/*- Scriptstart ---------------------------------------------------------------------- */
if($action == ""){
	if($process == "1"){
		$inp_title = $_POST['inp_title'];
		$inp_title = output_html($inp_title);
		$inp_title_mysql = quote_smart($link, $inp_title);
		if(empty($inp_title)){
			echo"No title";die;
		}

		$inp_language = $_POST['inp_language'];
		$inp_language = output_html($inp_language);
		$inp_language_mysql = quote_smart($link, $inp_language);

		$inp_main_category_id = $_POST['inp_main_category_id'];
		$inp_main_category_id = output_html($inp_main_category_id);
		$inp_main_category_id_mysql = quote_smart($link, $inp_main_category_id);

		
		// Insert
		$datetime = date("Y-m-d H:i:s");
		$date_print = date('j M Y');

		mysqli_query($link, "INSERT INTO $t_downloads_index
		(download_id, download_title, download_language, download_main_category_id, download_sub_category_id, download_created_datetime, download_updated_datetime, download_updated_print) 
		VALUES 
		(NULL, $inp_title_mysql, $inp_language_mysql, $inp_main_category_id_mysql, '0', '$datetime', '$datetime', '$date_print')")
		or die(mysqli_error($link));

		// Fetch ID
		$query = "SELECT download_id FROM $t_downloads_index WHERE download_created_datetime='$datetime'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_current_download_id) = $row;


		$url = "index.php?open=$open&page=edit_download&download_id=$get_current_download_id&main_category_id=$inp_main_category_id&editor_language=$editor_language";
		header("Location: $url");
		exit;
	}
	echo"
	<h1>New download</h1>

	<!-- Feedback -->
		";
		if($ft != "" && $fm != ""){
			if($fm == "category_deleted"){
				$fm = "Category deleted";
			}
			else{
				$fm = ucfirst($fm);
			}
			echo"<div class=\"$ft\"><p>$fm</p></div>";
		}
		echo"
	<!-- //Feedback -->
		

	<!-- New download form -->
		<!-- Focus -->
		<script>
			\$(document).ready(function(){
				\$('[name=\"inp_title\"]').focus();
			});
		</script>
		<!-- //Focus -->

		<form method=\"post\" action=\"index.php?open=$open&amp;page=$page&amp;l=$l&amp;editor_language=$editor_language&amp;process=1\" enctype=\"multipart/form-data\">

		<p><b>Title:</b><br />
		<input type=\"text\" name=\"inp_title\" value=\"\" size=\"25\" />
		</p>

		<p>Language:<br />
		<select name=\"inp_language\">\n";
		$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;
			echo"		<option value=\"$get_language_active_iso_two\">$get_language_active_name</option>\n";
		}
		echo"</select>

		<p>Category:<br />
		<select name=\"inp_main_category_id\">\n";
		$query = "SELECT main_category_id, main_category_title FROM $t_downloads_main_categories ORDER BY main_category_title ASC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_main_category_id, $get_main_category_title) = $row;
			echo"		<option value=\"$get_main_category_id\">$get_main_category_title</option>\n";
		}
		echo"</select>

		<p>
		<input type=\"submit\" value=\"Save\" class=\"btn_default\" />
		</p>

		</form>
	<!-- New download form -->
	";

} 
?>