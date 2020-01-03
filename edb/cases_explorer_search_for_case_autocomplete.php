<?php 
/**
*
* File: edb/cases_explorer_search_for_case_autocomplete.php
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

if(isset($_POST['inp_search_for_case_query']) && $_POST['inp_search_for_case_query'] != ''){
	$inp_search_for_case_query = $_POST['inp_search_for_case_query'];

	$inp_search_for_case_query = strip_tags(stripslashes($inp_search_for_case_query));
	$inp_search_for_case_query = trim($inp_search_for_case_query);
	$inp_search_for_case_query = strtolower($inp_search_for_case_query);
	$inp_search_for_case_query = output_html($inp_search_for_case_query);
	$inp_search_for_case_query = $inp_search_for_case_query . "%";
	$part_mysql = quote_smart($link, $inp_search_for_case_query);


	// Cases
	$last_printed_id = "";
	$query_cases = "SELECT case_id, case_number, case_title, case_code_id, case_code_title, case_priority_id, case_station_id, case_station_title, case_physical_location, case_backup_disks, case_assigned_to_user_id, case_assigned_to_user_name, case_assigned_to_user_first_name, case_assigned_to_user_middle_name, case_assigned_to_user_last_name, case_priority_title, case_updated_date_ddmmyyyy, case_updated_user_id, case_updated_user_name, case_updated_user_first_name, case_updated_user_middle_name, case_updated_user_last_name, case_created_date_ddmmyyyy, case_closed_date_ddmmyyyy FROM $t_edb_case_index WHERE case_number LIKE $part_mysql";
	$result_cases = mysqli_query($link, $query_cases);
	while($row_cases = mysqli_fetch_row($result_cases)) {
		list($get_case_id, $get_case_number, $get_case_title, $get_case_code_id, $get_case_code_title, $get_case_priority_id, $get_case_station_id, $get_case_station_title, $get_case_physical_location, $get_case_backup_disks, $get_case_assigned_to_user_id, $get_case_assigned_to_user_name, $get_case_assigned_to_user_first_name, $get_case_assigned_to_user_middle_name, $get_case_assigned_to_user_last_name, $get_case_priority_title, $get_case_updated_date_ddmmyyyy, $get_case_updated_user_id, $get_case_updated_user_name, $get_case_updated_user_first_name, $get_case_updated_user_middle_name, $get_case_updated_user_last_name, $get_case_created_date_ddmmyyyy, $get_case_closed_date_ddmmyyyy) = $row_cases;


		
		if($get_case_id != "$last_printed_id"){
			
				// Style
				if(isset($style) && $style == ""){
					$style = "odd";
				}
				else{
					$style = "";
				}
				echo"
				<tr>
				  <td class=\"$style\">
					<span><a href=\"open_case_overview.php?case_id=$get_case_id&amp;l=$l\">$get_case_number</a></span>
				  </td>
				  <td class=\"$style\">
					<span>$get_case_title</span>
				  </td>
				  <td class=\"$style\">
					<span>";
					if($get_case_assigned_to_user_id == ""){
						echo"
						(<a href=\"$root/users/view_profile.php?user_id=$get_case_updated_user_id&amp;l=$l\" title=\"$get_case_updated_user_name\">";
						if($get_case_updated_user_first_name == ""){
							echo"$get_case_updated_user_name";
						}
						else{
							echo"$get_case_updated_user_first_name $get_case_updated_user_middle_name $get_case_updated_user_last_name";
						}

						echo"</a>)
						";
					}
					else{
						echo"
						<a href=\"$root/users/view_profile.php?user_id=$get_case_assigned_to_user_id&amp;l=$l\" title=\"$get_case_assigned_to_user_name\">";
						if($get_case_assigned_to_user_first_name == ""){
							echo"$get_case_assigned_to_user_name";
						}
						else{
							echo"$get_case_assigned_to_user_first_name $get_case_assigned_to_user_middle_name $get_case_assigned_to_user_last_name";
						}

						echo"</a>
						";
					}
					echo"</span>
				  </td>
				  <td class=\"$style\">
					<span>$get_case_updated_date_ddmmyyyy</span>
				  </td>
				  <td class=\"$style\">
					<span>$get_case_physical_location</span>
				  </td>
				  <td class=\"$style\">
					<span>$get_case_backup_disks</span>
				  </td>
				  <td class=\"$style\">
					<span>$get_case_station_title</span>
				  </td>
				  <td class=\"$style\">
					<span>$get_case_code_id $get_case_code_title</span>
				  </td>
				  <td class=\"$style\">
					<span>$get_case_priority_title</span>
				  </td>
				  <td class=\"$style\">
					<span>$get_case_created_date_ddmmyyyy</span>
				  </td>
				  <td class=\"$style\">
					<span>$get_case_closed_date_ddmmyyyy</span>
				  </td>
				</tr>
				";
			$last_printed_id = "$get_case_id";
		}

	} // while

}
else{
	echo"Missing q";
}

?>