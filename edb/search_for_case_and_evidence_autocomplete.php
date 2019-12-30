<?php 
/**
*
* File: edb/search_for_case_and_evidence_autocomplete.php
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


/*- Query --------------------------------------------------------------------------- */

if(isset($_GET['inp_search_for_case_and_evidence_query']) && $_GET['inp_search_for_case_and_evidence_query'] != ''){
	$inp_search_for_case_and_evidence_query = $_GET['inp_search_for_case_and_evidence_query'];
}
elseif(isset($_POST['inp_search_for_case_and_evidence_query']) && $_POST['inp_search_for_case_and_evidence_query'] != ''){
	$inp_search_for_case_and_evidence_query = $_POST['inp_search_for_case_and_evidence_query'];
}
else{
	$inp_search_for_case_and_evidence_query = "";
}

if($inp_search_for_case_and_evidence_query != ""){
	$inp_search_for_case_and_evidence_query = strip_tags(stripslashes($inp_search_for_case_and_evidence_query));
	$inp_search_for_case_and_evidence_query = trim($inp_search_for_case_and_evidence_query);
	$inp_search_for_case_and_evidence_query = strtolower($inp_search_for_case_and_evidence_query);
	$inp_search_for_case_and_evidence_query = output_html($inp_search_for_case_and_evidence_query);
	$inp_search_for_case_and_evidence_query = $inp_search_for_case_and_evidence_query . "%";
	$part_mysql = quote_smart($link, $inp_search_for_case_and_evidence_query);

	echo"<ul>\n";

	// Cases
	$last_printed_id = "";
	$query = "SELECT case_id, case_number, case_title FROM $t_edb_case_index WHERE case_number LIKE $part_mysql";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_case_id, $get_case_number, $get_case_title) = $row;
		
		if($get_case_id != "$last_printed_id"){
			echo"<li><a href=\"open_case_overview.php?case_id=$get_case_id\">$get_case_number $get_case_title</a></li>\n";
		}

		$last_printed_id = "$get_case_id";
	}

	// Items
	$last_printed_id = "";
	$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title FROM $t_edb_case_index_evidence_items WHERE item_record_seized_journal LIKE $part_mysql";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_item_id, $get_item_case_id, $get_item_record_id, $get_item_record_seized_year, $get_item_record_seized_journal, $get_item_record_seized_district_number, $get_item_numeric_serial_number, $get_item_title) = $row;
		
		if($get_item_id != "$last_printed_id"){
			echo"<li><a href=\"open_case_evidence_edit_evidence_item_info.php?case_id=$get_item_case_id&amp;item_id=$get_item_id\">$get_item_record_seized_year/$get_item_record_seized_journal-$get_item_record_seized_district_number-$get_item_numeric_serial_number $get_item_title</a></li>\n";
		}

		$last_printed_id = "$get_item_id";
	}
	echo"</ul>\n";

}
else{
	echo"Missing q";
}

?>