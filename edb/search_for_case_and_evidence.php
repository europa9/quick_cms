<?php 
/**
*
* File: edb/search_for_case_and_evidence.php 
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

/*- Language --------------------------------------------------------------------------- */
include("$root/_admin/_translations/site/$l/edb/ts_edb.php");
include("$root/_admin/_translations/site/$l/edb/ts_cases_board_2_view_station.php");


/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['district_id'])) {
	$district_id = $_GET['district_id'];
	$district_id = strip_tags(stripslashes($district_id));
}
else{
	$district_id = "";
}
$district_id_mysql = quote_smart($link, $district_id);

if(isset($_GET['station_id'])) {
	$station_id = $_GET['station_id'];
	$station_id = strip_tags(stripslashes($station_id));
}
else{
	$station_id = "";
}
$station_id_mysql = quote_smart($link, $station_id);



if(isset($_GET['inp_search_for_case_and_evidence_query'])) {
	$inp_search_for_case_and_evidence_query = $_GET['inp_search_for_case_and_evidence_query'];
	$inp_search_for_case_and_evidence_query = strip_tags(stripslashes($inp_search_for_case_and_evidence_query));
}
else{
	$inp_search_for_case_and_evidence_query = "";
}
$inp_search_for_case_and_evidence_query_mysql = quote_smart($link, $inp_search_for_case_and_evidence_query);


/*- Content ---------------------------------------------------------------------------------- */
if(isset($_SESSION['user_id']) && isset($_SESSION['security'])){
	// Look for case direct
	$query = "SELECT case_id FROM $t_edb_case_index WHERE case_number=$inp_search_for_case_and_evidence_query_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_case_id) = $row;
	if($get_current_case_id != ""){
		$url = "open_case_overview.php?case_id=$get_current_case_id&l=$l";
		header("Location: $url");
		exit;
	}
	
	// Look for evidence record
	// Path = year/bjnr-districtnr-lnr
	$array = explode("/", $inp_search_for_case_and_evidence_query);
	$array_size = sizeof($array);
	if($array_size == "2"){
		$seized_year = $array[0];
		$seized_year_mysql = quote_smart($link, $seized_year);

		$rest = $array[1];
		$rest_array = explode("-", $rest);
		$rest_array_size = sizeof($rest_array);

		if($rest_array_size == "3"){
			// Record
			$seized_journal = $rest_array[0];
			$seized_journal_mysql = quote_smart($link, $seized_journal);

			$seized_district_number = $rest_array[1]; 
			$seized_district_number_mysql = quote_smart($link, $seized_district_number);


			$item_numeric_serial_number = $rest_array[2]; 
			$item_numeric_serial_number_mysql = quote_smart($link, $item_numeric_serial_number);


			$query = "SELECT item_id, item_case_id FROM $t_edb_case_index_evidence_items WHERE item_record_seized_year=$seized_year_mysql  AND item_record_seized_journal=$seized_journal_mysql AND item_record_seized_district_number=$seized_district_number_mysql  AND item_numeric_serial_number=$item_numeric_serial_number_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_item_id, $get_current_item_case_id) = $row;
			if($get_current_item_id != ""){
				$url = "open_case_evidence_edit_evidence_item_info.php?case_id=$get_current_item_case_id&item_id=$get_current_item_id&l=$l";
				header("Location: $url");
				exit;

			}
		}
		elseif($rest_array_size == "2"){
			// Record
			$seized_journal = $rest_array[0];
			$seized_journal_mysql = quote_smart($link, $seized_journal);

			$seized_district_number = $rest_array[1]; 
			$seized_district_number_mysql = quote_smart($link, $seized_district_number);

			
			$query = "SELECT record_id, record_case_id FROM $t_edb_case_index_evidence_records WHERE record_seized_year=$seized_year_mysql AND record_seized_journal=$seized_journal_mysql AND record_seized_district_number=$seized_district_number_mysql";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($get_current_record_id, $get_current_record_case_id) = $row;
			if($get_current_record_id != ""){
				$url = "open_case_evidence_view_record.php?case_id=$get_current_record_case_id&record_id=$get_current_record_id&l=$l";
				header("Location: $url");
				exit;

			}
		}


	}
	

	/*- Headers ---------------------------------------------------------------------------------- */
	$website_title = "$l_edb - $l_search";
	if($inp_search_for_case_and_evidence_query  != ""){
		$website_title = "$l_edb - $l_search - $inp_search_for_case_and_evidence_query";
	}
	if(file_exists("./favicon.ico")){ $root = "."; }
	elseif(file_exists("../favicon.ico")){ $root = ".."; }
	elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
	elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
	include("$root/_webdesign/header.php");


	// Find district
	$query = "SELECT district_id, district_number, district_title, district_title_clean, district_icon_path, district_icon_16, district_icon_32, district_icon_260, district_number_of_stations, district_number_of_cases_now FROM $t_edb_districts_index WHERE district_id=$district_id_mysql";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	list($get_current_district_id, $get_current_district_number, $get_current_district_title, $get_current_district_title_clean, $get_current_district_icon_path, $get_current_district_icon_16, $get_current_district_icon_32, $get_current_district_icon_260, $get_current_district_number_of_stations, $get_current_district_number_of_cases_now) = $row;
	
	// Me
	$my_user_id = $_SESSION['user_id'];
	$my_user_id = output_html($my_user_id);
	$my_user_id_mysql = quote_smart($link, $my_user_id);

	if($action == ""){
		echo"
		<h1>$l_search_for $inp_search_for_case_and_evidence_query</h1>
	
		<!-- Search -->
			<div class=\"search_for_case_and_evidence_query\">
				<form method=\"get\" action=\"search_for_case_and_evidence.php\" enctype=\"multipart/form-data\" id=\"search_for_case_and_evidence_form\">
				<input type=\"text\" name=\"inp_search_for_case_and_evidence_query\" id=\"inp_search_for_case_and_evidence_query\" class='auto' value=\"$inp_search_for_case_and_evidence_query\" size=\"25\" />
				<input type=\"submit\" value=\"$l_search\" class=\"btn_default\" />
				</form>
				<div id=\"inp_search_for_case_and_evidence_query_results\"></div>
			</div>

			<!-- Search engines Autocomplete -->
				<script id=\"source\" language=\"javascript\" type=\"text/javascript\">
					\$(document).ready(function () {
						\$('#inp_search_for_case_and_evidence_query').keyup(function () {
							// getting the value that user typed
       							var searchString    = \$(\"#inp_search_for_case_and_evidence_query\").val();
 							// forming the queryString
      							var data            = 'inp_search_for_case_and_evidence_query='+ searchString;
         
        						// if searchString is not empty
        						if(searchString) {
								\$(\"#inp_search_for_case_and_evidence_query_results\").css('visibility','visible');

           							// ajax call
            							\$.ajax({
                							type: \"POST\",
               								url: \"search_for_case_and_evidence_autocomplete.php\",
                							data: data,
									beforeSend: function(html) { // this happens before actual call
									\$(\"#inp_search_for_case_and_evidence_query_results\").html(''); 
								},
               							success: function(html){
                    							\$(\"#inp_search_for_case_and_evidence_query_results\").append(html);
              							}
            						});
       						}
        					return false;
            				});
         				});
				</script>
			<!-- //Search engines Autocomplete -->
		<!-- //Search -->


		<!-- Search results -->

		<div id=\"edb_search_results_enter\">

			<ul>
				";
			$inp_search_for_case_and_evidence_query = strip_tags(stripslashes($inp_search_for_case_and_evidence_query));
			$inp_search_for_case_and_evidence_query = trim($inp_search_for_case_and_evidence_query);
			$inp_search_for_case_and_evidence_query = strtolower($inp_search_for_case_and_evidence_query);
			$inp_search_for_case_and_evidence_query = output_html($inp_search_for_case_and_evidence_query);
			$inp_search_for_case_and_evidence_query = $inp_search_for_case_and_evidence_query . "%";
			$part_mysql = quote_smart($link, $inp_search_for_case_and_evidence_query);
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
			$query = "SELECT item_id, item_case_id, item_record_id, item_record_seized_year, item_record_seized_journal, item_record_seized_district_number, item_numeric_serial_number, item_title FROM $t_edb_case_index_evidence_items WHERE item_record_seized_journal LIKE $part_mysql OR item_title LIKE $part_mysql";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result)) {
				list($get_item_id, $get_item_case_id, $get_item_record_id, $get_item_record_seized_year, $get_item_record_seized_journal, $get_item_record_seized_district_number, $get_item_numeric_serial_number, $get_item_title) = $row;
		
				if($get_item_id != "$last_printed_id"){
					echo"<li><a href=\"open_case_evidence_edit_evidence_item_info.php?case_id=$get_item_case_id&amp;item_id=$get_item_id\">$get_item_record_seized_year/$get_item_record_seized_journal-$get_item_record_seized_district_number-$get_item_numeric_serial_number $get_item_title</a></li>\n";
				}

				$last_printed_id = "$get_item_id";
			}


			echo"
			</ul>
		</div>
		<!-- //Search results -->


		";

		

	} // action == ""
} // logged in
else{
	// Log in
	echo"
	<h1><img src=\"_gfx/loading_22.gif\" alt=\"loading_22.gif\" /> $l_please_log_in...</h1>
	<meta http-equiv=\"refresh\" content=\"1;url=$root/users/login.php?l=$l&amp;referer=$root/edb\">
	";
} // not logged in
/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/$webdesignSav/footer.php");
?>