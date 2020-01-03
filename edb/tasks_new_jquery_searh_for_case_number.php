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

if(isset($_POST['inp_case_number']) && $_POST['inp_case_number'] != ''){
	$inp_case_number = $_POST['inp_case_number'];

	$inp_case_number = strip_tags(stripslashes($inp_case_number));
	$inp_case_number = trim($inp_case_number);
	$inp_case_number = strtolower($inp_case_number);
	$inp_case_number = output_html($inp_case_number);
	$inp_case_number = $inp_case_number . "%";
	$part_mysql = quote_smart($link, $inp_case_number);

	echo"<ul>\n";

	// Cases
	$last_printed_id = "";
	$query = "SELECT case_id, case_number, case_title FROM $t_edb_case_index WHERE case_number LIKE $part_mysql";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result)) {
		list($get_case_id, $get_case_number, $get_case_title) = $row;
		
		if($get_case_id != "$last_printed_id"){
			echo"<li><a href=\"#$get_case_number\" class=\"tags_select\" data-divid=\"$get_case_number\">$get_case_number $get_case_title</a></li>\n";
		}

		$last_printed_id = "$get_case_id";
	}
	echo"</ul>\n";


	echo"
	<!-- Javascript on click add text to text input -->
		<script type=\"text/javascript\">
		\$(function() {
			\$('.tags_select').click(function() {
				var value = \$(this).data('divid');
            			var input = \$('#inp_case_number');
            			input.val(value);

				// Close
				\$(\"#inp_case_number_query_results\").html(''); 

				// Focus on text
				\$('[name=\"inp_text\"]').focus();


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