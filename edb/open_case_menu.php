<?php 
/**
*
* File: edb/open_case_menu.php
* Version 1.0
* Date 21:03 04.08.2019
* Copyright (c) 2019 S. A. Ditlefsen
* License: http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*- Tables ----------------------------------------------------------------------------------- */
$t_edb_case_index_matrix_names			= $mysqlPrefixSav . "edb_case_index_matrix_names";


/*- Language --------------------------------------------------------------------------- */
include("$root/_admin/_translations/site/$l/edb/ts_open_case_menu.php");

$php_self = basename($_SERVER['PHP_SELF']);

// Menu counter
$query = "SELECT menu_counter_id, menu_counter_case_id, menu_counter_overview, menu_counter_evidence, menu_counter_evidence_matrix, menu_counter_statuses, menu_counter_events, menu_counter_notes, menu_counter_review_notes, menu_counter_review_matrix, menu_counter_human_tasks_completed, menu_counter_human_tasks_total, menu_counter_automated_tasks_completed, menu_counter_automated_tasks_total, menu_counter_glossaries, menu_counter_photos, menu_counter_usr_psw FROM $t_edb_case_index_open_case_menu_counters WHERE menu_counter_case_id=$get_current_case_id";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_menu_counter_id, $get_current_menu_counter_case_id, $get_current_menu_counter_overview, $get_current_menu_counter_evidence, $get_current_menu_counter_evidence_matrix, $get_current_menu_counter_statuses, $get_current_menu_counter_events, $get_current_menu_counter_notes, $get_current_menu_counter_review_notes, $get_current_menu_counter_review_matrix, $get_menu_counter_human_tasks_completed, $get_current_menu_counter_human_tasks_total, $get_current_menu_counter_automated_tasks_completed, $get_current_menu_counter_automated_tasks_total, $get_current_menu_counter_glossaries, $get_current_menu_counter_photos, $get_current_menu_counter_usr_psw) = $row;
if($get_current_menu_counter_id == ""){
	// Insert
	mysqli_query($link, "INSERT INTO $t_edb_case_index_open_case_menu_counters 
	(menu_counter_id, menu_counter_case_id, menu_counter_overview, menu_counter_evidence, menu_counter_evidence_matrix, menu_counter_statuses, menu_counter_events, menu_counter_notes, menu_counter_review_notes, menu_counter_review_matrix, menu_counter_human_tasks_completed, menu_counter_human_tasks_total, menu_counter_automated_tasks_completed, menu_counter_automated_tasks_total, menu_counter_glossaries, menu_counter_photos, menu_counter_usr_psw) 
	VALUES 
	(NULL, $get_current_case_id, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)")
	or die(mysqli_error($link));
}	

// Matrix name
$query = "SELECT matrix_name_id, matrix_name_case_id, matrix_name_name FROM $t_edb_case_index_matrix_names WHERE matrix_name_case_id=$get_current_case_id";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($get_current_matrix_name_id, $get_current_matrix_name_case_id, $get_current_matrix_name_name) = $row;
if($get_current_matrix_name_id == ""){
	$inp_default_name_mysql = quote_smart($link, $l_matrix);
	mysqli_query($link, "INSERT INTO $t_edb_case_index_matrix_names 
				(matrix_name_id, matrix_name_case_id, matrix_name_name) 
				VALUES 
				(NULL, $get_current_case_id, $inp_default_name_mysql)")
				or die(mysqli_error($link));
		
	$get_current_matrix_name_name = "$l_matrix";
}

echo"<div class=\"tabs\">
						<ul>
							<li><a href=\"open_case_overview.php?case_id=$get_current_case_id&amp;l=$l\""; if($php_self == "open_case_overview.php"){ echo" class=\"active\""; } echo">$l_overview</a></li>
							<li><a href=\"open_case_evidence.php?case_id=$get_current_case_id&amp;l=$l\""; if($php_self == "open_case_evidence.php" OR $php_self == "open_case_evidence_delete_record" OR $php_self == "open_case_evidence_edit_evidence_item_acquire.php" OR $php_self == "open_case_evidence_edit_evidence_item_info.php" OR $php_self == "open_case_evidence_edit_evidence_item_item.php" OR $php_self == "open_case_evidence_edit_evidence_item_request.php" OR $php_self == "open_case_evidence_edit_record.php" OR $php_self == "open_case_evidence_new_item.php" OR $php_self == "open_case_evidence_new_record.php" OR $php_self == "open_case_evidence_edit_evidence_item_information.php" OR $php_self == "open_case_evidence_new_requester.php" OR $php_self == "open_case_evidence_view_record.php"){ echo" class=\"active\""; } echo">$l_evidence"; if($get_current_menu_counter_evidence != "" && $get_current_menu_counter_evidence != "0"){ echo" ($get_current_menu_counter_evidence)"; } echo"</a></li>
							<li><a href=\"open_case_statuses.php?case_id=$get_current_case_id&amp;l=$l\""; if($php_self == "open_case_statuses.php"){ echo" class=\"active\""; } echo">$l_statuses"; if($get_current_menu_counter_statuses != "" && $get_current_menu_counter_statuses != "0"){ echo" ($get_current_menu_counter_statuses)"; } echo"</a></li>
							<li><a href=\"open_case_events.php?case_id=$get_current_case_id&amp;l=$l\""; if($php_self == "open_case_events.php"){ echo" class=\"active\""; } echo">$l_events"; if($get_current_menu_counter_events != "" && $get_current_menu_counter_events != "0"){ echo" ($get_current_menu_counter_events)"; } echo"</a></li>
							<li><a href=\"open_case_notes.php?case_id=$get_current_case_id&amp;l=$l\""; if($php_self == "open_case_notes.php"){ echo" class=\"active\""; } echo">$l_notes"; if($get_current_menu_counter_notes != "" && $get_current_menu_counter_notes != "0"){ echo" ($get_current_menu_counter_notes)"; } echo"</a></li>
							<li><a href=\"open_case_evidence_matrix.php?case_id=$get_current_case_id&amp;l=$l\""; if($php_self == "open_case_evidence_matrix.php"){ echo" class=\"active\""; } echo">$get_current_matrix_name_name"; if($get_current_menu_counter_evidence_matrix != "" && $get_current_menu_counter_evidence_matrix != "0"){ echo" ($get_current_menu_counter_evidence_matrix)"; } echo"</a></li>
							<li><a href=\"open_case_review_notes.php?case_id=$get_current_case_id&amp;l=$l\""; if($php_self == "open_case_review_notes.php"){ echo" class=\"active\""; } echo">$l_review_notes"; if($get_current_menu_counter_review_notes != "" && $get_current_menu_counter_review_notes != "0"){ echo" ($get_current_menu_counter_review_notes)"; } echo"</a></li>
							<li><a href=\"open_case_review_matrix.php?case_id=$get_current_case_id&amp;l=$l\""; if($php_self == "open_case_review_matrix.php"){ echo" class=\"active\""; } echo">$l_review_matrix"; if($get_current_menu_counter_review_matrix != "" && $get_current_menu_counter_review_notes != "0"){ echo" ($get_current_menu_counter_review_matrix)"; } echo"</a></li>
							<li><a href=\"open_case_human_tasks.php?case_id=$get_current_case_id&amp;l=$l\""; if($php_self == "open_case_human_tasks.php"){ echo" class=\"active\""; } echo">$l_human_tasks"; if($get_current_menu_counter_human_tasks_total != "" && $get_current_menu_counter_human_tasks_total != "0"){ echo" ($get_menu_counter_human_tasks_completed/$get_current_menu_counter_human_tasks_total)"; } echo"</a></li>
							<li><a href=\"open_case_glossaries.php?case_id=$get_current_case_id&amp;l=$l\""; if($php_self == "open_case_glossaries.php"){ echo" class=\"active\""; } echo">$l_glossaries"; if($get_current_menu_counter_glossaries != "" && $get_current_menu_counter_glossaries != "0"){ echo" ($get_current_menu_counter_glossaries)"; } echo"</a></li>
							<li><a href=\"open_case_automated_tasks.php?case_id=$get_current_case_id&amp;l=$l\""; if($php_self == "open_case_automated_tasks.php"){ echo" class=\"active\""; } echo">$l_automated_tasks"; if($get_current_menu_counter_automated_tasks_total != "" && $get_current_menu_counter_automated_tasks_total != "0"){ echo" ($get_current_menu_counter_automated_tasks_completed/$get_current_menu_counter_automated_tasks_total)"; } echo"</a></li>
							<li><a href=\"open_case_photos.php?case_id=$get_current_case_id&amp;l=$l\""; if($php_self == "open_case_photos.php"){ echo" class=\"active\""; } echo">$l_photos"; if($get_current_menu_counter_photos != "" && $get_current_menu_counter_photos != "0"){ echo" ($get_current_menu_counter_photos)"; } echo"</a></li>
							<li><a href=\"open_case_usr_psw.php?case_id=$get_current_case_id&amp;l=$l\""; if($php_self == "open_case_usr_psw.php"){ echo" class=\"active\""; } echo">$l_user_password"; if($get_current_menu_counter_usr_psw != "" && $get_current_menu_counter_usr_psw != "0"){ echo" ($get_current_menu_counter_usr_psw)"; } echo"</a></li>\n";
							if($get_my_station_member_rank == "admin" OR $get_my_station_member_rank == "moderator" OR $get_my_station_member_rank == "editor"){
								echo"<li><a href=\"open_case_delete_case.php?case_id=$get_current_case_id&amp;l=$l\""; if($php_self == "open_case_delete_case.php"){ echo" class=\"active\""; } echo">$l_delete</a></li>\n";
							}
							echo"
							
						</ul>
					</div>
					<div class=\"clear\" style=\"height: 10px;\"></div>
";
?>