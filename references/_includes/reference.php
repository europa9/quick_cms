﻿<?php
/**
*
* File: references/_includes/reference.php
* Version 2.0.0
* Date 22:38 03.05.2019
* Copyright (c) 2011-2019 Localhost
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/*- Functions ------------------------------------------------------------------------ */

/*- Tables ---------------------------------------------------------------------------- */
$t_references_title_translations = $mysqlPrefixSav . "references_title_translations";
$t_references_categories_main	 = $mysqlPrefixSav . "references_categories_main";
$t_references_categories_sub 	 = $mysqlPrefixSav . "references_categories_sub";
$t_references_index		 = $mysqlPrefixSav . "references_index";
$t_references_index_groups	 = $mysqlPrefixSav . "references_index_groups";
$t_references_index_guides	 = $mysqlPrefixSav . "references_index_guides";


// Find reference
$reference_title_mysql = quote_smart($link, $referenceTitleSav);
$query = "SELECT reference_id, reference_title, reference_title_clean, reference_is_active, reference_front_page_intro, reference_description, reference_language, reference_main_category_id, reference_main_category_title, reference_sub_category_id, reference_sub_category_title, reference_image_file, reference_image_thumb, reference_icon_16, reference_icon_32, reference_icon_48, reference_icon_64, reference_icon_96, reference_icon_260, reference_groups_count, reference_guides_count, reference_read_times, reference_read_times_ip_block, reference_created, reference_updated FROM $t_references_index WHERE reference_title=$reference_title_mysql";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_reference_id, $get_current_reference_title, $get_current_reference_title_clean, $get_current_reference_is_active, $get_current_reference_front_page_intro, $get_current_reference_description, $get_current_reference_language, $get_current_reference_main_category_id, $get_current_reference_main_category_title, $get_current_reference_sub_category_id, $get_current_reference_sub_category_title, $get_current_reference_image_file, $get_current_reference_image_thumb, $get_current_reference_icon_16, $get_current_reference_icon_32, $get_current_reference_icon_48, $get_current_reference_icon_64, $get_current_reference_icon_96, $get_current_reference_icon_260, $get_current_reference_groups_count, $get_current_reference_guides_count, $get_current_reference_read_times, $get_current_reference_read_times_ip_block, $get_current_reference_created, $get_current_reference_updated) = $row;

if($get_current_reference_id != ""){
	

	if($action == ""){
		// Read times
		$my_ip = $_SERVER['REMOTE_ADDR'];
		$my_ip = output_html($my_ip);
		
		$ipblock_array = explode("\n", $get_current_reference_read_times_ip_block);
		$size = sizeof($ipblock_array);
		$i_have_visited_before = "false";
		for($x=0;$x<$size;$x++){
			if($ipblock_array[$x] == "$my_ip"){
				$i_have_visited_before = "true";
			}
		}
			
		if($i_have_visited_before == "false"){
			$inp_reference_read_times = $get_current_reference_read_times+1;
		
			if($get_current_reference_read_times_ip_block == ""){
				$inp_reference_read_times_ip_block = "$my_ip";
			}
			else{
				$inp_reference_read_times_ip_block = "$my_ip\n" . substr($get_current_reference_read_times_ip_block, 0, 400);
			}
			$inp_reference_read_times_ip_block_mysql = quote_smart($link, $inp_reference_read_times_ip_block);
			$result = mysqli_query($link, "UPDATE $t_references_index SET reference_read_times=$inp_reference_read_times, reference_read_times_ip_block=$inp_reference_read_times_ip_block_mysql WHERE reference_id=$get_current_reference_id") or die(mysqli_error($link));
		}

		// Headline
		echo"
		<h1>$get_current_reference_title</h1>
		<a href=\"index.php?l=$l\"><img src=\"_gfx/$get_current_reference_icon_96\" alt=\"$get_current_reference_icon_96\" style=\"float: right;padding: 0px 0px 10px 10px;\" /></a>
		
		<!-- About reference -->
			<div style=\"height:20px;\"></div>
			<p>
			$get_current_reference_description
			</p>
			
			<div style=\"height:20px;\"></div>
		<!-- //About reference -->

		";

	} // action == ""
} // course found
else{
	echo"<p>Reference not found</p>";
}
?>