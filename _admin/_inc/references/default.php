<?php
/**
*
* File: _admin/_inc/references/default.php
* Version 
* Date 20:17 30.10.2017
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
$t_references_title_translations = $mysqlPrefixSav . "references_title_translations";
$t_references_categories_main	 = $mysqlPrefixSav . "references_categories_main";
$t_references_categories_sub 	 = $mysqlPrefixSav . "references_categories_sub";
$t_references_index		 = $mysqlPrefixSav . "references_index";
$t_references_index_groups	 = $mysqlPrefixSav . "references_index_groups";
$t_references_index_guides	 = $mysqlPrefixSav . "references_index_guides";

/*- Variables ------------------------------------------------------------------------ */
$tabindex = 0;

if(isset($_GET['where'])){
	$where = $_GET['where'];
	$where = output_html($where);
}
else {
	$where = "comment_approved != '-1'";
}

if($action == ""){
	echo"
	<h1>References</h1>
				

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


	<!-- Where am I? -->
		<p><b>You are here:</b><br />
		<a href=\"index.php?open=references&amp;page=menu&amp;editor_language=$editor_language&amp;l=$l\">References</a>
		&gt;
		<a href=\"index.php?open=references&amp;page=default&amp;editor_language=$editor_language&amp;l=$l\">References index</a>
		</p>
	<!-- //Where am I? -->

	<!-- Menu + language selector -->
		<table>
		 <tr>
		  <td style=\"vertical-align:top;padding-right: 20px;\">
			<p>
			<a href=\"index.php?open=references&amp;page=references_new&amp;editor_language=$editor_language&amp;l=$l\" class=\"btn_default\">New references</a>
			</p>
		  </td>
		  <td style=\"vertical-align:top;\">
			<p>
			";
			$found_editor_language = "";
			$query = "SELECT language_active_id, language_active_name, language_active_iso_two, language_active_flag, language_active_default FROM $t_languages_active";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_language_active_id, $get_language_active_name, $get_language_active_iso_two, $get_language_active_flag, $get_language_active_default) = $row;
				echo"	<a href=\"index.php?open=$open&amp;editor_language=$get_language_active_iso_two&amp;l=$l\"><img src=\"_design/gfx/flags/16x16/$get_language_active_flag"; echo"_16x16.png\" alt=\"$get_language_active_flag\" /></a>\n";

				if($editor_language == "$get_language_active_iso_two"){
					$found_editor_language = "1";
				}
			}
			if($found_editor_language == ""){
				// Editor language not found
				if(isset($get_language_active_iso_two)){
					$editor_language = "$get_language_active_iso_two";
				}
				else{
					echo"<p>Editor language not found</p>";
				}
			}
			echo"
			</p>
		  </td>
		 </tr>
		</table>
	<!-- //Menu + language selector  -->

	<!-- Left and right -->
		<table>
		 <tr>
		  <td style=\"vertical-align:top;padding-right: 20px;\">
			<!-- Left: Categories -->
				<table class=\"hor-zebra\">
				 <tbody>
				  <tr>
				   <td>
					<p style=\"padding:4px 0px 4px 0px;margin:0;\">";
				$editor_language_mysql = quote_smart($link, $editor_language);
				$query = "SELECT main_category_id, main_category_title FROM $t_references_categories_main WHERE main_category_language=$editor_language_mysql ORDER BY main_category_title ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_main_category_id, $get_main_category_title) = $row;
					echo"
					<a href=\"index.php?open=$open&amp;page=open_main_category&amp;main_category_id=$get_main_category_id&amp;editor_language=$editor_language&amp;l=$l\">$get_main_category_title</a><br />
					";
				}
				echo"
					</p>
				   </td>
				  </tr>
				 </tbody>
				</table>
			<!-- //Left: Categories -->
		  </td>
		  <td style=\"vertical-align:top;\">
			<!-- Right: References -->";

				$editor_language_mysql = quote_smart($link, $editor_language);
				$query = "SELECT reference_id, reference_title, reference_title_clean, reference_is_active, reference_front_page_intro, reference_description, reference_language, reference_main_category_id, reference_main_category_title, reference_sub_category_id, reference_sub_category_title, reference_image_file, reference_image_thumb, reference_icon_16, reference_icon_32, reference_icon_48, reference_icon_64, reference_icon_96, reference_icon_260, reference_groups_count, reference_guides_count, reference_read_times, reference_created, reference_updated FROM $t_references_index WHERE reference_language=$editor_language_mysql ORDER BY reference_title ASC";
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_row($result)) {
					list($get_reference_id, $get_reference_title, $get_reference_title_clean, $get_reference_is_active, $get_reference_front_page_intro, $get_reference_description, $get_reference_language, $get_reference_main_category_id, $get_reference_main_category_title, $get_reference_sub_category_id, $get_reference_sub_category_title, $get_reference_image_file, $get_reference_image_thumb, $get_reference_icon_16, $get_reference_icon_32, $get_reference_icon_48, $get_reference_icon_64, $get_reference_icon_96, $get_reference_icon_260, $get_reference_groups_count, $get_reference_guides_count, $get_reference_read_times, $get_reference_created, $get_reference_updated) = $row;
					echo"
					<table style=\"width: 100%;\">
					  <tr>";
					if(file_exists("../$get_reference_title_clean/_gfx/$get_reference_icon_48")){
					echo"
					   <td style=\"width: 48px;vertical-align:top;padding-right: 10px;\">
						<p>
						<a href=\"index.php?open=$open&amp;page=reference_open&amp;reference_id=$get_reference_id&amp;editor_language=$editor_language&amp;l=$l\"><img src=\"../$get_reference_title_clean/_gfx/$get_reference_icon_48\" alt=\"$get_reference_icon_48\" /></a>
						</p>
					   </td>
					";
					}
					echo"
					   <td style=\"vertical-align:top;padding: 12px 0px 0px 0px;\">
						<p class=\"reference_title\">
						<a href=\"index.php?open=$open&amp;page=reference_open&amp;reference_id=$get_reference_id&amp;editor_language=$editor_language&amp;l=$l\">$get_reference_title</a>
						</p>
					  </td>
					 </tr>
					</table>
					";

				}
				echo"
			<!-- //Right: References -->
		  </td>
		 </tr>
		</table>
	<!-- //Left and right -->

	
	";
}
?>