<?php 
/**
*
* File: edb/new_case_step_3_case_information_case_code_search.php
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
if(isset($_GET['q']) OR isset($_POST['q'])){
	if(isset($_GET['q'])) {
		$q = $_GET['q'];
	}
	else{
		$q = $_POST['q'];
	}
	$q = trim($q);
	$q = strtolower($q);
	$inp_datetime = date("Y-m-d H:i:s");
	$q = output_html($q);
	$q_mysql = quote_smart($link, $q);

	if($q != ""){
		
		$query = "SELECT code_id, code_number, code_title, code_title_clean, code_gives_priority_id, code_gives_priority_title FROM $t_edb_case_codes WHERE code_number=$q_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_code_id, $get_code_number, $get_code_title, $get_code_title_clean, $get_code_gives_priority_id, $get_code_gives_priority_title) = $row;
	
		if($get_code_id != ""){
			echo"
			<script language=\"javascript\" type=\"text/javascript\">
				\$(document).ready(function () {
					\$(\"#inp_code_title\").text(\"$get_code_title\");
					\$('#inp_priority').val('$get_code_gives_priority_id');
					\$('#inp_title').val('$get_code_title');
				});
			</script>
			";
		}
		else{
			echo"
			<script language=\"javascript\" type=\"text/javascript\">
				\$(document).ready(function () {
					\$(\"#inp_code_title\").text(\"Not found\");
				});
			</script>
			Not found
			";
		}
		
	}

}

else{

	echo"No q";

}


?>