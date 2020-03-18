<?php 
/**
*
* File: search/search.php 
* Version 1.0
* Date 14:01 24.01.2020
* Copyright (c) 2020 S. A. Ditlefsen
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
// include("$root/_admin/_translations/site/$l/edb/ts_edb.php");


/*- Tables Search Engine ---------------------------------------------------------------- */
$t_search_engine_index 		= $mysqlPrefixSav . "search_engine_index";
$t_search_engine_access_control = $mysqlPrefixSav . "search_engine_access_control";
$t_search_engine_searches	= $mysqlPrefixSav . "search_engine_searches";


/*- Variables -------------------------------------------------------------------------- */
if(isset($_GET['inp_search_query'])) {
	$inp_search_query = $_GET['inp_search_query'];
	$inp_search_query = strip_tags(stripslashes($inp_search_query));
}
else{
	// go to index
	header("Location: index.php?l=$l");
	exit;
}
$inp_search_query_mysql = quote_smart($link, $inp_search_query);


/*- Headers ---------------------------------------------------------------------------------- */
$website_title = "$l_search";
if($inp_search_query  != ""){
	$website_title = $website_title . " - $inp_search_query";
}
if(file_exists("./favicon.ico")){ $root = "."; }
elseif(file_exists("../favicon.ico")){ $root = ".."; }
elseif(file_exists("../../favicon.ico")){ $root = "../.."; }
elseif(file_exists("../../../favicon.ico")){ $root = "../../.."; }
include("$root/_webdesign/header.php");


echo"
<h1>$l_search_for $inp_search_query</h1>
	
<!-- Search -->
	<div class=\"search_search_div\">
		<form method=\"get\" action=\"search.php\" enctype=\"multipart/form-data\">
		<input type=\"text\" name=\"inp_search_query\" id=\"inp_search_query\" class='auto' value=\"$inp_search_query\" size=\"25\" />
		<input type=\"submit\" value=\"$l_search\" class=\"btn_default\" />
		</form>
		<div id=\"inp_search_results\"></div>
	</div>

	<!-- Search engines Autocomplete -->
		<script id=\"source\" language=\"javascript\" type=\"text/javascript\">
			\$(document).ready(function () {
				\$('#inp_search_query').keyup(function () {
					// getting the value that user typed
					var searchString    = \$(\"#inp_search_query\").val();
					// forming the queryString
      					var data            = 'inp_search_query='+ searchString;
         
        				// if searchString is not empty
        				if(searchString) {
						\$(\"#inp_search_results\").css('visibility','visible');
						// ajax call
        					\$.ajax({
        						type: \"GET\",
        						url: \"search_autocomplete.php\",
                					data: data,
							beforeSend: function(html) { // this happens before actual call
								\$(\"#inp_search_results\").html(''); 
							},
               						success: function(html){
                    						\$(\"#inp_search_results\").append(html);
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

	<div class=\"search_results\">
		";
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
					<div class=\"search_result_box\">
						<p>
						<a href=\"go.php?index_id=$get_index_id&amp;process=1&amp;l=$l\" class=\"search_index_title\">$get_index_title</a><br />
						<a href=\"go.php?index_id=$get_index_id&amp;process=1&amp;l=$l\" class=\"search_index_url\">$get_index_url</a><br />
						<span class=\"search_index_description\">$get_index_short_description</span>
						</p>
					</div>";

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
						<div class=\"search_result_box\">
							<p>
							<a href=\"go.php?index_id=$get_index_id&amp;process=1&amp;l=$l\" class=\"search_index_title\">$get_index_title</a><br />
							<a href=\"go.php?index_id=$get_index_id&amp;process=1&amp;l=$l\" class=\"search_index_url\">$get_index_url</a><br />
							<span class=\"search_index_description\">$get_index_short_description</span>
							</p>
						</div>";

						$results_counter++;
					}
					$last_printed_id = "$get_index_id";
				} // can view result
	
			} // Search results

		} // no results

		// IP
		$my_ip = $_SERVER['REMOTE_ADDR'];
		$my_ip = output_html($my_ip);

		$inp_search_query_mysql = quote_smart($link, $inp_search_query);

		$datetime = date("Y-m-d H:i:s");
		$datetime_saying = date("j M Y H:i:s");

		// Insert into searches
		$query = "SELECT search_id, search_query, search_unique_counter, search_unique_ip_block, search_number_of_results FROM $t_search_engine_searches WHERE search_query=$inp_search_query_mysql";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_row($result);
		list($get_search_id, $get_search_query, $get_search_unique_counter, $get_search_unique_ip_block, $get_search_number_of_results) = $row;
		if($get_search_id == ""){

			$inp_unique_ip_block_mysql = quote_smart($link, $my_ip);
			$inp_language_used_mysql = quote_smart($link, $l);
			

			mysqli_query($link, "INSERT INTO $t_search_engine_searches 
			(search_id, search_query, search_unique_counter, search_unique_ip_block, search_number_of_results, search_language_used, search_created_datetime, search_created_datetime_print) 
			VALUES 
			(NULL, $inp_search_query_mysql, 1, $inp_unique_ip_block_mysql, $results_counter, $inp_language_used_mysql, '$datetime', '$datetime_saying')")
			or die(mysqli_error($link)); 

		} // first time search
		else{
			// IP block 
			$array = explode("\n", $get_search_unique_ip_block);
			$size = sizeof($array);
			$found_my_ip = "false";
			for($x=0;$x<$size;$x++){
				$temp = $array[$x];
				if($temp == "$my_ip"){
					$found_my_ip = "true";
				}
			}
	
			if($found_my_ip == "false"){
				$inp_unique_counter = $get_search_unique_counter+1;

				$inp_ip_block = $my_ip . "\n" . $get_search_unique_ip_block;
				$inp_ip_block = substr($inp_ip_block, 0, 450);
				$inp_ip_block_mysql = quote_smart($link, $inp_ip_block);

		
				$result = mysqli_query($link, "UPDATE $t_search_engine_searches SET 
						search_unique_counter=$inp_unique_counter,
						search_unique_ip_block=$inp_ip_block_mysql,
						search_updated_datetime='$datetime', 
						search_updated_datetime_print='$datetime_saying'
						WHERE search_id='$get_search_id'");
			}

		}
		echo"
	</div>
<!-- //Search results -->
";

		

/*- Footer ----------------------------------------------------------------------------------- */
include("$root/_webdesign/$webdesignSav/footer.php");
?>