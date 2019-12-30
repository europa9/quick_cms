<?php 
/**
*
* File: edb/open_case_evidence_edit_evidence_item_item_jquery_search_for_storage_shelve.php
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


/*- Tables ---------------------------------------------------------------------------- */
$t_edb_evidence_storage_locations 	= $mysqlPrefixSav . "edb_evidence_storage_locations";
$t_edb_evidence_storage_shelves		= $mysqlPrefixSav . "edb_evidence_storage_shelves";

/*- Query --------------------------------------------------------------------------- */

if(isset($_GET['q']) && $_GET['q'] != ''){
	$q = $_GET['q'];
	$q = strip_tags(stripslashes($q));
	$q = trim($q);
	$q = strtolower($q);
	$q = output_html($q);
	$q = "%" . $q . "%";
	$part_mysql = quote_smart($link, $q);


	//get matched data from skills table
	$last_shelf_id = "";
	$query = "SELECT shelf_id, shelf_first_letter, shelf_number, shelf_full_name, shelf_barcode, shelf_station_id, shelf_station_title, shelf_storage_location_id, shelf_storage_location_title, shelf_storage_location_abbr FROM $t_edb_evidence_storage_shelves WHERE shelf_full_name LIKE $part_mysql OR shelf_storage_location_title LIKE $part_mysql";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_shelf_id, $get_shelf_first_letter, $get_shelf_number, $get_shelf_full_name, $get_shelf_barcode, $get_shelf_station_id, $get_shelf_station_title, $get_shelf_storage_location_id, $get_shelf_storage_location_title, $get_shelf_storage_location_abbr) = $row;
		if($last_shelf_id != "$get_shelf_id"){

			echo"
			<a href=\"#\" class=\"tags_select\" data-divid=\"$get_shelf_full_name ($get_shelf_storage_location_abbr)\" title=\"$get_shelf_full_name $get_shelf_storage_location_title\">$get_shelf_full_name ($get_shelf_storage_location_title)</a><br />
			";
		} // duplicates
		$last_shelf_id = "$get_shelf_id";
	}
	echo"
	<!-- Javascript on click add text to text input -->
		<script type=\"text/javascript\">
		\$(function() {
			\$('.tags_select').click(function() {
				var value = \$(this).data('divid');
            			var input = \$('#inp_storage_autosearch');
            			input.val(value);

				// Close
				\$(\"#autosearch_storage_search_results_show\").html(''); 

				// Submit
				\$('.form').form.submit();

            			return false;
       			});
    		});
		</script>
	<!-- //Javascript on click add text to text input -->
	";

}
else{
	echo"Missing q";
}

?>