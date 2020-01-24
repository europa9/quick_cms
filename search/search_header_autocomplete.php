<?php 
/**
*
* File: search/search_header_autocomplete.php
* Version 1.0
* Date 21:03 04.08.2019
* Copyright (c) 2019 S. A. Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Configuration ---------------------------------------------------------------------------- */
$pageIdSav            = "2";
$pageNoColumnSav      = "2";
$pageAllowCommentsSav = "1";
$pageAuthorUserIdSav  = "1";

/*- Root dir --------------------------------------------------------------------------------- */
// This determine where we are
if(file_exists("favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
elseif(file_exists("../../../../favicon.ico")){ $root = "../../../.."; }
else{ $root = "../../.."; }

/*- Website config --------------------------------------------------------------------------- */
include("$root/_admin/website_config.php");

/*- Tables Search Engine ---------------------------------------------------------------- */
$t_search_engine_index 		= $mysqlPrefixSav . "search_engine_index";
$t_search_engine_access_control = $mysqlPrefixSav . "search_engine_access_control";


/*- Query --------------------------------------------------------------------------- */

if(isset($_GET['inp_search_query']) && $_GET['inp_search_query'] != ''){
	$inp_search_query = $_GET['inp_search_query'];

	echo"
	<ul>\n";
		$inp_search_query = strip_tags(stripslashes($inp_search_query));
		$inp_search_query = trim($inp_search_query);
		$inp_search_query = strtolower($inp_search_query);
		$inp_search_query = output_html($inp_search_query);
		$inp_search_query_percentage = $inp_search_query . "%";
		$part_mysql = quote_smart($link, $inp_search_query_percentage);

		// Search
		$last_printed_id = "";
		$results_counter = 0;
		$query = "SELECT index_id, index_title, index_url, index_short_description, index_keywords, index_module_name, index_module_part_name, index_module_part_id, index_reference_name, index_reference_id, index_has_access_control, index_is_ad, index_created_datetime, index_created_datetime_print, index_updated_datetime, index_updated_datetime_print, index_language, index_unique_hits, index_hits_ipblock FROM $t_search_engine_index WHERE index_title LIKE $part_mysql OR index_short_description LIKE $part_mysql OR index_keywords LIKE $part_mysql ORDER BY index_unique_hits DESC";
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_row($result)) {
			list($get_index_id, $get_index_title, $get_index_url, $get_index_short_description, $get_index_keywords, $get_index_module_name, $get_index_module_part_name, $get_index_module_part_id, $get_index_reference_name, $get_index_reference_id, $get_index_has_access_control, $get_index_is_ad, $get_index_created_datetime, $get_index_created_datetime_print, $get_index_updated_datetime, $get_index_updated_datetime_print, $get_index_language, $get_index_unique_hits, $get_index_hits_ipblock) = $row;
		
			// Can view?
			$can_view_result = "1";

			if($can_view_result == "1"){

				if($get_index_id != "$last_printed_id"){
					echo"
					<li><a href=\"go.php?index_id=$get_index_id&amp;process=1&amp;l=$l\">$get_index_title</a></li>
					";
					$results_counter++;
				}
				$last_printed_id = "$get_index_id";
			} // can view result
		} // Search results


		if($results_counter == "0"){
			// Expand search 
			$percentage_inp_search_query_percentage = "%" . $inp_search_query . "%";
			$part_mysql = quote_smart($link, $percentage_inp_search_query_percentage);
			$query = "SELECT index_id, index_title, index_url, index_short_description, index_keywords, index_module_name, index_module_part_name, index_module_part_id, index_reference_name, index_reference_id, index_has_access_control, index_is_ad, index_created_datetime, index_created_datetime_print, index_updated_datetime, index_updated_datetime_print, index_language, index_unique_hits, index_hits_ipblock FROM $t_search_engine_index WHERE index_title LIKE $part_mysql OR index_short_description LIKE $part_mysql OR index_keywords LIKE $part_mysql ORDER BY index_unique_hits DESC";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_index_id, $get_index_title, $get_index_url, $get_index_short_description, $get_index_keywords, $get_index_module_name, $get_index_module_part_name, $get_index_module_part_id, $get_index_reference_name, $get_index_reference_id, $get_index_has_access_control, $get_index_is_ad, $get_index_created_datetime, $get_index_created_datetime_print, $get_index_updated_datetime, $get_index_updated_datetime_print, $get_index_language, $get_index_unique_hits, $get_index_hits_ipblock) = $row;
		
				// Can view?
				$can_view_result = "1";

				if($can_view_result == "1"){

					if($get_index_id != "$last_printed_id"){
						echo"
						<li><a href=\"go.php?index_id=$get_index_id&amp;process=1&amp;l=$l\">$get_index_title</a></li>
						";
						$results_counter++;
					}
					$last_printed_id = "$get_index_id";
				} // can view result
	
			} // Search results

		} // no results

	echo"
	</ul>
	";

}
else{
	echo"Missing q";
}

?>